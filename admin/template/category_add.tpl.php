<?php include mymps_tpl('inc_head');?>
<script language=javascript>
function chkform(){
	if(document.form1.catname.value==""){
		alert('请输入栏目标题！');
		document.form1.catname.focus();
		return false;
	}
	if(document.form.catname.value.length<2){
		alert('栏目标题请控制在2个字节以上!');
		document.form1.catname.focus();
		return false;
	}
}
function do_copy(){
  ff = document.form1;
  ff.title.value=document.getElementById("catname").value;
  ff.keywords.value=document.getElementById("catname").value;
}

function isUndefined(variable) {
	return typeof variable == 'undefined' ? true : false;
}

function insertunit(text) {
	$obj('jstemplate').focus();
	$obj('jstemplate').value=text;
}

function insertunit2(text) {
	$obj('jstemplate2').focus();
	$obj('jstemplate2').value=text;
}
</script>
<div id="<?=MPS_SOFTNAME?>">
<table border="0" cellspacing="0" cellpadding="0" class="vbm">
  <tr class="firstr">
  	<td colspan="2">技巧提示</td>
  </tr>
  <tr bgcolor="#ffffff">
    <td id="menu_tip">
  <li>栏目不设置为启用时，仅作为一个分类方案保存，你可以在启用的时候开启它</li>
    </td>
  </tr>
</table>
</div>
<form method=post onSubmit="return chkform()" name="form1" action="?part=add">
<div id="<?=MPS_SOFTNAME?>">
<table width="100%"  border="0" cellspacing="0" cellpadding="0" class="vbm">
<tr class="firstr">
<td colspan="2">
    <div class="left"><a href="javascript:collapse_change('1')">栏目基本信息</a></div>
    <div class="right"><a href="javascript:collapse_change('1')"><img id="menuimg_1" src="template/images/menu_reduce.gif"/></a></div>
</td>
</tr>
<tbody id="menu_1">
<tr bgcolor="white">
  <td width="15%" bgcolor="#F1F5F8">栏目名称： </td>
  <td><textarea rows="20" name="catname" cols="20" style="float:left"></textarea>
<div style="margin-top:3px; float:left; margin-left:10px;">支持行业分类批量添加，多个分类换行隔开 <br />
<font color="red">范例：<br />行业1<br />行业2<br />行业3<br />行业4<br />行业5</font></div></td>
</tr>
<tr bgcolor="white">
  <td bgcolor="#F1F5F8">隶属栏目： </td>
  <td><select name="parentid" id="parentid" >
    <option value="0">作为根栏目...</option>
	<?=cat_list('category',0,0,true,2)?>
  </select>  </td>
</tr>
<tr bgcolor="white">
  <td bgcolor="#F1F5F8">栏目排序： </td>
  <td><input name="catorder" type="text" id="catorder" value="<?=$maxorder?>" class="txt"></td>
</tr>
<tr bgcolor="white">
  <td bgcolor="#F1F5F8">所属模型： </td>
  <td><select name="modid"><?php echo info_typemodels(); ?></select> [<a href="info_type.php?part=mod">模型管理</a>]</td>
</tr>
<tr bgcolor="white">
  <td bgcolor="#F1F5F8">是否启用： </td>
  <td><select name="isview">
      <?=get_ifview_options()?>
      </select></td>
</tr>
<tr bgcolor="white">
  <td width="15%" bgcolor="#F1F5F8">是否开启图片上传模块： </td>
  <td>
  <label for="1"><input class="radio" type="radio" value="1" name="if_upimg" checked="checked">开启</label> 
  <label for="0"><input class="radio" type="radio" value="0" name="if_upimg">关闭</label></td>
</tr>
<tr bgcolor="white">
  <td width="15%" bgcolor="#F1F5F8">是否开启地图标注： </td>
  <td>
  <label for="1"><input class="radio" type="radio" value="1" name="if_mappoint">开启</label> 
  <label for="0"><input class="radio" type="radio" value="0" name="if_mappoint" checked="checked">关闭</label></td>
</tr>
<tr bgcolor="white">
  <td bgcolor="#F1F5F8">拼音伪静态规则名： </td>
  <td><?=GetHtmlType('2','dir_type','add')?></td>
</tr>
</tbody>
</table>
</div>
<div id="<?=MPS_SOFTNAME?>">
<table cellpadding="0" cellspacing="0" class="vbm">
<tr class="firstr">
<td colspan="3">
    <div class="left"><a href="javascript:collapse_change('3')">栏目应用模板</a></div>
    <div class="right"><a href="javascript:collapse_change('3')"><img id="menuimg_3" src="template/images/menu_reduce.gif"/></a></div>
</td>
</tr>
<tbody id="menu_3">
<tr bgcolor="white">
  <td bgcolor="#F1F5F8" width="15%">栏目列表使用模板： </td>
  <td width="300">
  /template/default/ <input name="template" class="text" style="width:100px;" id="jstemplate" value="list"> .tpl.php <br />
  </td>
  <td><?php foreach($category_tpl as $k => $v){?>
   <a href="###" title="点击使用<?=$v?>" onclick="insertunit('<?=$k?>')" class="temp"><?=$v?><br />（<?=$k?>）</a>
   <?php if($k == 'category') echo '<div class=clear></div>'?>
  	 <?php }?>
	</td>
</tr>
<tr bgcolor="white">
  <td bgcolor="#F1F5F8">栏目信息详细页使用模板：</td>
  <td>/template/default/ <input name="template_info" class="text" style="width:100px;" id="jstemplate2" value="info">  .tpl.php </td>
  <td>
  <?php foreach($information_tpl as $k => $v){?>
   <a href="###" title="点击使用<?=$v?>" onclick="insertunit2('<?=$k?>')" class="temp <?php if($cat['template_info'] == $k) echo 'curtemp'?>"><?=$v?><br />（<?=$k?>）</a>
  <?php }?>
</td>
</tr>
</tbody>
</table>
</div>
<div id="<?=MPS_SOFTNAME?>">
<table cellpadding="0" cellspacing="0" class="vbm">
<tr class="firstr">
<td colspan="3">
    <div class="left"><a href="javascript:collapse_change('4')">栏目信息联系方式查看权限</a></div>
    <div class="right"><a href="javascript:collapse_change('4')"><img id="menuimg_4" src="template/images/menu_reduce.gif"/></a></div>
</td>
</tr>
<tbody id="menu_4">
<tr bgcolor="white">
  <td bgcolor="#F1F5F8" width="15%">查看隶属该栏目下的信息联系方式扣除金币数量</td>
  <td>
  <input name="usecoin" class="txt" id="usecoin" value="0"> <img src="../member/images/mymps_icon_incomes.gif" align="absmiddle"> <font style="color:#777; margin-left:10px;">注意：填写0时，表示游客可免费查看该栏目下的信息联系方式</font> <font color="red">请填写整数！</font>
  </td>
</tr>
</tbody>
</table>
</div>
<center>
<input type="submit" value="确认提交" name="<?=CURSCRIPT?>_submit" class="mymps mini" />　
<input type="button" onClick=history.back() value="返 回" class="mymps mini">
</center>
</form>
<?php mymps_admin_tpl_global_foot();?>