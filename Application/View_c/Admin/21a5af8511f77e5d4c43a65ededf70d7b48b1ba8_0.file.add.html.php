<?php
/* Smarty version 3.1.30, created on 2017-08-26 23:37:27
  from "D:\Workspace\testmvc\Application\View\Admin\student\add.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_59a195b788a6b8_69994536',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '21a5af8511f77e5d4c43a65ededf70d7b48b1ba8' => 
    array (
      0 => 'D:\\Workspace\\testmvc\\Application\\View\\Admin\\student\\add.html',
      1 => 1503761822,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:../layout.html' => 1,
  ),
),false)) {
function content_59a195b788a6b8_69994536 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>


<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_435059a195b78861c4_29360794', "pagebody");
$_smarty_tpl->inheritance->endChild();
$_smarty_tpl->_subTemplateRender("file:../layout.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 2, false);
}
/* {block "pagebody"} */
class Block_435059a195b78861c4_29360794 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

<div id="mainPage">
    <div class="well bordered-top bordered-purple popover-container">
        
        <div class="row">
                <div class="col-lg-12 col-sm-12 col-xs-12">
                    
                    <form id="stuForm" enctype="multipart/form-data" method="post" action="">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="m_name">姓名：</label>
                                            <span class="input-icon">
                                                <input type="hidden" name="id" id="m_id" value="<?php echo $_smarty_tpl->tpl_vars['stu']->value['id'];?>
">
                                                <input type="text" class="form-control" name="name" id="m_name" value="<?php echo $_smarty_tpl->tpl_vars['stu']->value['name'];?>
" placeholder="姓名">
                                                <i class="fa fa-asterisk red"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="m_age">年龄：</label>
                                            <span class="input-icon">
                                                <input type="number" class="form-control" name="age" id="m_age" value="<?php echo $_smarty_tpl->tpl_vars['stu']->value['age'];?>
"  placeholder="年龄">
                                                <i class="fa fa-asterisk red"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="m_image">图像：</label>
                                            <span class="input-icon">
                                                <input type="file" class="form-control" name="image" id="m_image">
                                                <i class="fa fa-asterisk red"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                
                                <hr class="wide">

                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group" style="text-align: center;">
                                            <button type="submit">保存</button>
                                            <button type="reset">取消</button>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </form>

                </div>
            </div>
        
    </div>
</div>

<?php
}
}
/* {/block "pagebody"} */
}
