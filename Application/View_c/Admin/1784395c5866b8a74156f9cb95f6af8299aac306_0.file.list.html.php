<?php
/* Smarty version 3.1.30, created on 2017-08-27 00:08:13
  from "D:\Workspace\testmvc\Application\View\Admin\student\list.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_59a19cedac1b49_28314516',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '1784395c5866b8a74156f9cb95f6af8299aac306' => 
    array (
      0 => 'D:\\Workspace\\testmvc\\Application\\View\\Admin\\student\\list.html',
      1 => 1503763689,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:../layout.html' => 1,
  ),
),false)) {
function content_59a19cedac1b49_28314516 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>


<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_2321259a19cedaba271_16381386', "pagebody");
?>


<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_1317359a19cedac0b08_67599662', "js");
$_smarty_tpl->inheritance->endChild();
$_smarty_tpl->_subTemplateRender("file:../layout.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 2, false);
}
/* {block "pagebody"} */
class Block_2321259a19cedaba271_16381386 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

<div id="mainPage">
    <div class="well bordered-top bordered-purple popover-container">
        <div class="row">
            <div class="col-lg-12 col-sm-12 col-xs-12">
                <form class="form-inline search-form" id="searchFrom" role="form">
                    <div class="row     margin-bottom-5">
                        <div class="col-lg-6 col-sm-6 col-xs-6">
                            <div class="form-group">
                                <label for="c_name">名称</label>
                                <input type="text" class="form-control" id="c_name" name="name" placeholder="">
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-6 col-xs-6">

                            <a href="javascript:void(0);" id="btn-search" class="btn btn-purple btn-xs"><i class="glyphicon glyphicon-search"></i>查询</a>
                            <a href="javascript:void(0);" id="btn-reset" class="btn btn-purple btn-xs"><i class="fa fa-refresh"></i>重置</a>
                        </div>
                    </div>

                </form>
            </div>
            
        </div>
            
        <hr class="wide">
        
        <div class="row">
            <div class="col-lg-12 col-sm-12 col-xs-12">
                <div class="btn-group">
                    <a href="index.php?p=Admin&c=Student&a=operate" id="btn-add" class="btn btn-purple btn-xs"><i class="fa fa-plus"></i>新增</a>
                    <a href="index.php?p=Admin&c=Student&a=remove" id="btn-remove" class="btn btn-purple btn-xs"><i class="glyphicon glyphicon-trash"></i>删除</a>
<!--                    <a href="index.php?p=Admin&c=Student&a=operate" id="btn-edit" class="btn btn-purple btn-xs"><i class="fa fa-edit"></i>修改</a>-->
                </div>
            </div>
        </div>
        
        <hr class="wide">
        
        <table>
            <tr>
                <th>编号</th>
                <th>姓名</th>
                <th>年龄</th>
                <th>操作</th>
            </tr>
            <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['stuList']->value, 'stu');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['stu']->value) {
?>
            <tr>
                <td><?php echo $_smarty_tpl->tpl_vars['stu']->value['id'];?>
</td>
                <td><?php echo $_smarty_tpl->tpl_vars['stu']->value['name'];?>
</td>
                <td><?php echo $_smarty_tpl->tpl_vars['stu']->value['age'];?>
</td>
                <td><image src="/Public/uploads/<?php echo $_smarty_tpl->tpl_vars['stu']->value['user_photo'];?>
" width="50" height="50" /></td>
                <td><button type="button" onclick="delClick('<?php echo $_smarty_tpl->tpl_vars['stu']->value['id'];?>
')">删除</button></td>
                <td><button type="button" onclick="location.href='index.php?p=Admin&c=Student&a=operate&id=<?php echo $_smarty_tpl->tpl_vars['stu']->value['id'];?>
'">修改</button></td>
            </tr>
            <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>


	</table>
    </div>
</div>

<div id="operatePage" style="display: none;"></div>

<?php
}
}
/* {/block "pagebody"} */
/* {block "js"} */
class Block_1317359a19cedac0b08_67599662 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

<?php echo '<script'; ?>
>
    function delClick(id){
        if(confirm('确定删除吗?')){ 
            location.href="index.php?p=Admin&c=Student&a=del&id=" + id;
        }
    }
<?php echo '</script'; ?>
>
<?php
}
}
/* {/block "js"} */
}
