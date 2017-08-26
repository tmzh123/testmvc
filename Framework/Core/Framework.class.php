<?php
/**
 * Created by PhpStorm.
 * User: Joe
 * Date: 2017-8-4
 * Time: 18:03
 */


class Framework{
    /*
     *  跑起来
     * */
    public static function run(){
        self::initConst();
        self::initConfig();
        self::initRoute();
        self::registerAutoLoad();
        self::initDispatch();
    }

    /*
     *  定义路径常量
     * */
    private static function initConst(){
        define('DS',DIRECTORY_SEPARATOR);     // 定义目录分隔符
        define('ROOT_PATH',getcwd().DS);        // 定义根目录
        define('APP_PATH',ROOT_PATH.'Application'.DS);  //Application 目录
        define('CONFIG_PATH',APP_PATH.'Config'.DS);     //Config 目录
        define('MODEL_PATH',APP_PATH.'Model'.DS);  //Model 目录
        define('CONTROLLER_PATH',APP_PATH.'Controller'.DS);  //Controller 目录
        define('VIEW_PATH',APP_PATH.'View'.DS);  //View 模版目录
        
        define('VIEWC_PATH',APP_PATH.'View_c'.DS);  //View 混编目录
        
        define('CACHE_SMARTY_PATH', APP_PATH.'cache'.DS);   //Smarty缓存文件

        define('FRAMEWORK_PATH',ROOT_PATH.'Framework'.DS);  //Framework 目录
        define('CORE_PATH',FRAMEWORK_PATH.'Core'.DS);  //Core 目录
        define('LIB_PATH',FRAMEWORK_PATH.'Lib'.DS);  //Lib 目录

        define('PUBLIC_PATH',ROOT_PATH.'Public'.DS);    //Public 目录

    }

    /*
     *  导入配置文件
     * */
    private static function initConfig(){
        $GLOBALS['config'] = require CONFIG_PATH.'config.php';
    }

    /*
     *  定制路由
     * */
    private static function initRoute(){
        //当前平台名
        $p = isset($_REQUEST['p']) ? $_REQUEST['p'] : $GLOBALS['config']['app']['default_platform'];
        //当前控制器名
        $c = isset($_REQUEST['c']) ? $_REQUEST['c'] : $GLOBALS['config']['app']['default_controller'];
        //当前方法名
        $a = isset($_REQUEST['a']) ? $_REQUEST['a'] : $GLOBALS['config']['app']['default_action'];

        define('PLATFORM_NAME',$p);
        define('CONTROLLER_NAME',$c);
        define('ACTION_NAME',$a);

        //当前控制器的目录
        define('__URL__',CONTROLLER_PATH.PLATFORM_NAME.DS);
        //当前视图模版的目录
        define('__VIEW__',VIEW_PATH.PLATFORM_NAME.DS);
        //当前视图混编页面的目录
        define('__VIEWC__',VIEWC_PATH.PLATFORM_NAME.DS);
    }

    /*
     *  自定义自动加载类
     * */
    private static function autoLoad($class_name){
        $class_map = array(
            'MySQLDB' => CORE_PATH.'MySQLDB.class.php',
            'BaseModel' => CORE_PATH.'BaseModel.class.php',
            'BaseController' => CORE_PATH.'BaseController.class.php',
            'Smarty' => LIB_PATH.'smarty/Smarty.class.php',
        );
        if(isset($class_map[$class_name])){
            require $class_map[$class_name];
        }
        elseif (substr($class_name,-5) == 'Model'){
            require MODEL_PATH.$class_name.'.class.php';
        }
        elseif (substr($class_name,-10) == 'Controller'){
            require __URL__.$class_name.'.class.php';
        }
        elseif (substr($class_name, -3) == 'Lib') {
            require LIB_PATH.$class_name.'.class.php';
        }
    }

    /*
     *  注册自定义加载类
     * */
    private static function registerAutoLoad(){
        spl_autoload_register('self::autoLoad');
    }

    //请求分发
    private static function initDispatch(){

        $controllerName = CONTROLLER_NAME.'Controller';
        $actionName = ACTION_NAME.'Action';

        $controller = new $controllerName();
        $controller->$actionName();
    }
}