<?php include mymps_tpl('inc_head');?>
<script language=javascript>
function chkform(){
	if(document.form1.catname.value==""){
		alert('请输入分类标题！');
		document.form1.catname.focus();
		return false;
	}
	if(document.form1.cat.value==""){
		alert('请选择分类！');
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
	$('jstemplate').focus();
	$('jstemplate').value=text;
}
</script>
<div id="<?=MPS_SOFTNAME?>" style=" padding-bottom:0">
    <div class="mpstopic-category">
        <div class="panel-tab">
            <ul class="clearfix tab-list">
                <li><a href="?part=list">商品分类</a></li>
                <li><a href="?part=add">增加分类</a></li>
			    <li><a href="?part=edit&catid=<?=$catid?>" class="current">编辑分类</a></li>
            </ul>
        </div>
    </div>
</div>
<div id="<?=MPS_SOFTNAME?>">
<table border="0" cellspacing="0" cellpadding="0" class="vbm">
  <tr class="firstr">
  	<td colspan="2">技巧提示</td>
  </tr>
  <tr bgcolor="#ffffff">
    <td id="menu_tip">
  <li>分类不设置为启用时，仅作为一个分类方案保存，你可以在启用的时候开启它</li>
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
    <div class="left"><a href="javascript:collapse_change('1')">分类基本信息</a></div>
    <div class="right"><a href="javascript:collapse_change('1')"><img id="menuimg_1" src="template/images/menu_reduce.gif"/></a></div>
</td>
</tr>
<tbody id="menu_1">
<tr bgcolor="white">
  <td width="15%" bgcolor="#F1F5F8">分类名称： </td>
  <td><input name="catname" type="text" class="text" id="catname" value="<?=$cat[catname]?>" size="30"> 
  		<select name="fontcolor">
          <option value="">默认颜色</option>
          <?foreach ($cat_color as $k){?>
          <option value="<?=$k?>" style="background-color:<?=$k?>;" <?if($cat[color] == $k) echo 'selected';?>></option>
          <?}?>
        </select>
  		<font color="red">*</font></td>
</tr>
<tr bgcolor="white">
  <td bgcolor="#F1F5F8">隶属分类： </td>
  <td><select name="parentid" id="parentid" >
    <option value="0">作为根分类...</option>
	<?=goods_cat_list(1,$cat[parentid],true,1)?>
  </select>  </td>
</tr>
<tr bgcolor="white">
  <td bgcolor="#F1F5F8">分类排序： </td>
  <td><input name="catorder" type="text" class="txt" id="catorder" value="<?=$cat[catorder]?>" size="13"></td>
</tr>
<tr bgcolor="white">
  <td bgcolor="#F1F5F8">是否启用： </td>
  <td> <select name="isview">
      <?=get_ifview_options($cat[if_view])?>
      </select></td>
</tr>
</tbody>
</table>
</div>
<div id="<?=MPS_SOFTNAME?>">
<table cellpadding="0" cellspacing="0" class="vbm">
<tr class="firstr">
<td colspan="2">
    <div class="left"><a href="javascript:collapse_change('2')">SEO优化设置<font style="color:#FF6600; font-weight:100">(若与分类名称相同，
<label for="copy">
点此<input name="radio" id="copy" class="radio" type="radio" onClick="do_copy();" />复制</label>
)</font></a></div>
    <div class="right"><a href="javascript:collapse_change('2')"><img id="menuimg_2" src="template/images/menu_reduce.gif"/></a></div>
</td>
</tr>
<tbody id="menu_2">
<tr bgcolor="white">
  <td width="15%" bgcolor="#F1F5F8">显示标题(title)： </td>
  <td> <input name="title" type="text" id="title" class="text" value="<?=$cat[title]?>" size="50"> <font color="red">*</font>(<font style="color:#FF6600">范例：运动/户外/休闲商品</font>;分站名用 <font color="red">{city}</font> 代替)
  </td>
</tr>
<tr bgcolor="white">
  <td bgcolor="#F1F5F8">关键词(keyword)： </td>
  <td><input name="keywords" type="text" id="keywords" class="text" value="<?=$cat[keywords]?>" size="50">   (多个关键字以","隔开;分站名用 <font color="red">{city}</font> 代替)</td>
</tr>
<tr bgcolor="white">
  <td bgcolor="#F1F5F8">描述(description)： </td>
  <td><textarea name="description" cols="49" rows="5" id="description"><?=$cat[description]?></textarea> (分站名用 <font color="red">{city}</font> 代替)</td>
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