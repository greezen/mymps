<?php include mymps_tpl('inc_head');?>
<script language=javascript>
function chkform(){
	if(document.form1.catname.value==""){
		alert('请输入栏目标题！');
		document.form1.catname.focus();
		return false;
	}
	if(document.form1.cat.value==""){
		alert('请选择栏目！');
		document.form1.cat.focus();
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
<form method=post onSubmit="return chkform()" name="form1" action="?part=edit">
<input name="catid" value="<?=$cat[catid]?>" type="hidden">
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
  <td><input name="catname" type="text" class="text" id="catname" value="<?=$cat[catname]?>" size="30"> 
  		<select name="fontcolor">
          <option value="">默认颜色</option>
          <?php echo get_color_options($cat['color']); ?>
        </select>
  		<font color="red">*</font></td>
</tr>
<tr bgcolor="white">
  <td bgcolor="#F1F5F8">隶属栏目： </td>
  <td><select name="parentid" id="parentid" >
    <?php if(!$cat[parentid]){?><option value="0">作为根栏目...</option><?php }?>
	<?php echo $cat[parentid] ? cat_list('category',0,$cat[parentid],true,2) : ''; ?>
  </select>  </td>
</tr>
<?php if($cat[parentid] == 0){?>
<tr bgcolor="white">
  <td bgcolor="#F1F5F8">栏目图标路径： <br />尺寸/30*30或以上</td>
  <td><input name="icon" type="text" class="text" id="icon" value="<?=$cat[icon]?>"> <?php if($cat[icon] != ''){?><img src="<?=$cat[icon]?>"><?php }?> &nbsp;&nbsp;&nbsp;&nbsp;格式如：/template/default/images/index/icon_fang.gif</td>
</tr>
<?php }?>
<tr bgcolor="white">
  <td bgcolor="#F1F5F8">栏目排序： </td>
  <td><input name="catorder" type="text" class="txt" id="catorder" value="<?=$cat[catorder]?>" size="13"></td>
</tr>
<tr bgcolor="white">
  <td bgcolor="#F1F5F8">所属模型： <div style="margin-top:10px; color:#666"><label for="children_mod"><input name="children_mod" value="1" type="checkbox" class="checkbox" id="children_mod">同步应用到子栏目</label></div></td>
  <td><select name="modid"><?php echo info_typemodels($cat[modid])?></select> [<a href="info_type.php?part=mod">模型管理</a>]</td>
</tr>
<tr bgcolor="white">
  <td bgcolor="#F1F5F8">是否启用： </td>
  <td> <select name="isview">
      <?=get_ifview_options($cat[if_view])?>
      </select></td>
</tr>
<tr bgcolor="white">
  <td width="15%" bgcolor="#F1F5F8">是否开启图片上传： <?php if(!$cat['parentid']){?><div style="margin-top:10px; color:#666"><label for="children_upload"><input checked="checked" name="children_upload" value="1" type="checkbox" class="checkbox" id="children_upload">同步应用到子栏目</label></div><?php }?></td>
  <td>
  <label for="up1"><input class="radio" type="radio" value="1" id="up1" name="if_upimg" <?php if($cat[if_upimg]=='1'){?>checked="checked"<?}?>>开启</label> 
  <label for="up0"><input class="radio" type="radio" value="0" id="up0" name="if_upimg" <?php if($cat[if_upimg]=='0'){?>checked="checked"<?}?>>关闭</label></td>
</tr>
<tr bgcolor="white">
  <td width="15%" bgcolor="#F1F5F8">是否开启地图标注： <?php if(!$cat['parentid']){?><div style="margin-top:10px; color:#666"><label for="children_map"><input checked="checked" name="children_map" value="1" type="checkbox" class="checkbox" id="children_map">同步应用到子栏目</label></div><?php }?></td>
  <td>
  <label for="map1"><input class="radio" type="radio" value="1" id="map1" name="if_mappoint" <?php if($cat[if_mappoint]=='1'){?>checked="checked"<?}?>>开启</label> 
  <label for="map0"><input class="radio" type="radio" value="0" id="map0" name="if_mappoint" <?php if($cat[if_mappoint]=='0'){?>checked="checked"<?}?>>关闭</label></td>
</tr>
</tbody>
</table>
</div>
<div id="<?=MPS_SOFTNAME?>">
<table cellpadding="0" cellspacing="0" class="vbm">
<tr class="firstr">
<td colspan="2">
    <div class="left"><a href="javascript:collapse_change('2')">SEO优化设置<font style="color:#FF6600; font-weight:100">(若与栏目名称相同，
<label for="copy">
点此<input name="radio" id="copy" class="radio" type="radio" onClick="do_copy();" />复制</label>
)</font></a></div>
    <div class="right"><a href="javascript:collapse_change('2')"><img id="menuimg_2" src="template/images/menu_reduce.gif"/></a></div>
</td>
</tr>
<tbody id="menu_2">
<tr bgcolor="white">
  <td width="15%" bgcolor="#F1F5F8">显示标题(title)： </td>
  <td> <input name="title" type="text" id="title" class="text" value="<?=$cat[title]?>" size="50"> <font color="red">*</font>(<font style="color:#FF6600">范例：二手车求购_二手车买卖</font>,不超过15个字符)
  </td>
</tr>
<tr bgcolor="white">
  <td bgcolor="#F1F5F8">关键词(keyword)： </td>
  <td><input name="keywords" type="text" id="keywords" class="text" value="<?=$cat[keywords]?>" size="50">   (多个关键字以","隔开)</td>
</tr>
<tr bgcolor="white">
  <td bgcolor="#F1F5F8">相关说明： <div style="margin-top:10px; color:#666"><label for="children_des"><input name="children_des" value="1" type="checkbox" class="checkbox" id="children_des">同步应用到子栏目</label></div></td>
  <td><textarea name="description" cols="49" rows="5" id="description"><?=$cat[description]?></textarea> (适当出现关键字，最好是完整的句子，不超过200字符)</td>
</tr>
<tr bgcolor="white">
  <td bgcolor="#F1F5F8">目录/拼音伪静态<br />【自定义名】：</td>
  <td><?=GetHtmlType($cat[dir_type],'dir_type','edit',$cat[dir_typename])?> <font style="color:#666">请填写字母（勿含数字，- ，_，空格以及其它符号）正确范例：<span>fang</span></font></td>
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
  <td bgcolor="#F1F5F8" width="15%">栏目列表页使用模板： <div style="margin-top:10px; color:#666"><label for="children_tpl"><input name="children_tpl" value="1" type="checkbox" class="checkbox" id="children_tpl">同步应用到子栏目</label></div></td>
  <td width="300">/template/default/ <input name="template" class="text" style="width:100px;" id="jstemplate" value="<?php echo $cat['template'];?>">  .tpl.php   
  </td>
  <td>
  <?php foreach($category_tpl as $k => $v){?>
   <a href="###" title="点击使用<?=$v?>" onclick="insertunit('<?=$k?>')" class="temp <?php if($cat['template'] == $k) echo 'curtemp'?>"><?=$v?><br />（<?=$k?>）</a>
    <?php if($k == 'category') echo '<div class=clear></div>'?>
  <?php }?>
</td>
</tr>
<tr bgcolor="white">
  <td bgcolor="#F1F5F8">栏目信息详细页使用模板： <div style="margin-top:10px; color:#666"><label for="children_tplinfo"><input name="children_tplinfo" checked="checked" value="1" type="checkbox" class="checkbox" id="children_tplinfo">同步应用到子栏目</label></div></td>
  <td>/template/default/ <input name="template_info" class="text" style="width:100px;" id="jstemplate2" value="<?php echo $cat['template_info'];?>">  .tpl.php 
  </td>
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
  <td bgcolor="#F1F5F8" width="15%">查看隶属该栏目下的信息联系方式扣除金币数量：<?php if(!$cat['parentid']){?><div style="margin-top:10px; color:#666"><label for="children_usecoin"><input name="children_usecoin" value="1" type="checkbox" class="checkbox" id="children_usecoin" checked="checked">同步应用到子栏目</label></div><?php }?></td>
  <td>
  <input name="usecoin" class="txt" id="usecoin" value="<?php echo $cat['usecoin']; ?>"> <img src="../member/images/mymps_icon_incomes.gif" align="absmiddle"> <font style="color:#777; margin-left:10px;">注意：填写0时，表示游客可免费查看该栏目下的信息联系方式</font> <font color="red">请填写整数！</font>
  </td>
</tr>
</tbody>
</table>
</div>
<center>
<input type="submit" name="<?=CURSCRIPT?>_submit" value="保存修改" class="mymps mini" />　
<input type="button" onClick=history.back() value="返 回" class="mymps mini">
</center>
</form>
<?php mymps_admin_tpl_global_foot();?>