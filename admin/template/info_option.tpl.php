<?php include mymps_tpl('inc_head');?>
<div id="<?=MPS_SOFTNAME?>" style=" padding-bottom:0">
    <div class="mpstopic-category">
        <div class="panel-tab">
            <ul class="clearfix tab-list">
            <li><a href="?part=option_type" <?php if($part == 'option_type'){?>class="current"<?php }?>>类别管理</a></li>
            <?php foreach($options as $k =>$value){?>
                <li><a href="?classid=<?=$value[optionid]?>" <?php if($classid==$value[optionid]){?>class="current"<?php }?>><?=$value[title]?></a></li>
            <?php }?>
            </ul>
        </div>
    </div>
</div>
<form name='form1' method='post' action='?'>
<div id="<?=MPS_SOFTNAME?>">
<table border="0" cellspacing="0" cellpadding="0" class="vbm">
  	<input name="part" value="option_delall" type="hidden">
    <input name="url" value="<?=GetUrl()?>" type="hidden">
    <tr class="firstr">
    <td colspan="7"><b><?=$detail['title']?></b> 分类信息字段管理</td>
    </tr>
    
    <tr style="font-weight:bold; height:24px; background-color:#f1f5f8">
      <td><input class="checkbox" name="checkall" type="checkbox" id="checkall" onClick="CheckAll(this.form)"/>删?</td>
      <td>模型ID</td>
      <td>名称</td>
      <td>变量名</td>
      <td>类型</td>
      <td>显示顺序</td>
      <td>编辑</td>
    </tr>
	<tbody onmouseover="addMouseEvent(this);">
<?php foreach($option as $k =>$value){?>
    <tr bgcolor="white">
      <td><input <?php if($value[optionid]==1) echo 'disabled'; ?> class="checkbox" type='checkbox' name='id[]' value='<?=$value[optionid]?>' id="<?=$value[optionid]?>"></td>
      <td><?=$value[optionid]?></td>
      <td><?=$value[title]?></td>
      <td><?=$value[identifier]?></td>
      <td><?=$var_type[$value[type]]?>(<?=$value[type]?>)</td>
      <td><?=$value[displayorder]?></td>
      <td><a href="?part=option_edit&optionid=<?=$value[optionid]?>">详情</a></td>
    </tr>
    <?}?>
    </tbody>
	</table>
	</div>
	<center><input type="submit" onClick="if(!confirm('确定要操作吗？\n\n此操作不可以恢复！'))return false;" value="提 交" class="mymps large" name="deloption"/></center>
</form>
<div class="clear" style="height:10px"></div>
<form action="?part=option_add" method="post" name="form2">
<div id="<?=MPS_SOFTNAME?>">
<table border="0" cellspacing="0" cellpadding="0" class="vbm">
<tr class="firstr">
<td colspan="2"><?=$detail['title']?> 新增模型字段</td>
</tr>
<tr bgcolor="#ffffff">
    <td style="background-color:#f1f5f8; width:15%;">字段名称</td>
    <td><input name="title" type="text" class="text"> <br /><i style="color:#555; margin-top:3px;">中文名称如“价格”</i></td>
</tr>
<tr bgcolor="#ffffff">
    <td style="background-color:#f1f5f8;">变量名</td>
    <td><input name="identifier" type="text" class="text"> <br /><i style="color:#555; margin-top:3px;">可用字段名称的拼音全拼或首字母</i></td>
</tr>
<tr bgcolor="#ffffff">
    <td style="background-color:#f1f5f8;">类型</td>
    <td>
	<select name="type">
		<?=get_type_option()?>
    </select>
	</td>
</tr>
<tr bgcolor="#ffffff">
    <td style="background-color:#f1f5f8;">其它属性</td>
    <td>
<label for="available"><input name="available" type="checkbox" id="available" class="checkbox" checked>可用</label> 
<label for="required"><input name="required" type="checkbox" id="required" class="checkbox">必填</label>
<label for="search"><input name="search" type="checkbox" id="search" class="checkbox">作为筛选条件</label>
	</td>
</tr>
<tr bgcolor="#ffffff">
    <td style="background-color:#f1f5f8;">显示顺序</td>
    <td><input name="displayorder" type="text" class="text" value="0"></td>
</tr>
    <input name="classid" value="<?=$detail[optionid]?>" type="hidden" />
</table>
</div>
<center><input type="submit" value="提交" class="mymps large" name="optionnew"/></center>
</form>
<?php mymps_admin_tpl_global_foot();?>