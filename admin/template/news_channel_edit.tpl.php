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
  ff.description.value=document.getElementById("catname").value;
}
function copyoption(s1, s2) {
	var s1 = $(s1);
	var s2 = $(s2);
	var len = s1.options.length;
	for(var i=0; i<len; i++) {
		op = s1.options[i];
		if(op.selected == true && !optionexists(s2, op.value)) {
			o = op.cloneNode(true);
			s2.appendChild(o);
		}
	}
}

function optionexists(s1, value) {
	var len = s1.options.length;
		for(var i=0; i<len; i++) {
			if(s1.options[i].value == value) {
				return true;
			}
		}
	return false;
}
</script>
<div id="<?=MPS_SOFTNAME?>" style=" padding-bottom:0">
    <div class="mpstopic-category">
        <div class="panel-tab">
            <ul class="clearfix tab-list">
                <li><a title="已添加的新闻类别" href="channel.php">已添加的新闻类别</a></li>
                <li><a title="新增新闻类别" href="channel.php?part=add">新增新闻类别</a></li>
				<li><a title="编辑新闻类别" href="channel.php?part=edit&catid=<?=$catid?>" class="current">编辑新闻类别</a></li>
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
    <td  id="menu_tip">
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
<tr bgcolor="#f5fbff">
  <td width="15%">栏目名称： </td>
  <td><input name="catname" type="text" class="text" id="catname" value="<?=$cat[catname]?>" size="30"> 
  		<select name="fontcolor">
          <option value="">默认颜色</option>
          <?foreach ($cat_color as $k){?>
          <option value="<?=$k?>" style="background-color:<?=$k?>;" <?if($cat[color] == $k) echo 'selected';?>></option>
          <?}?>
        </select>
  		<font color="red">*</font></td>
</tr>
<tr bgcolor="#f5fbff">
  <td>隶属栏目： </td>
  <td><select name="parentid" id="parentid" >
    <option value="0">作为根栏目...</option>
<?php echo cat_list('channel',0,$cat[parentid]);?>
  </select>  </td>
</tr>
<tr bgcolor="#f5fbff">
  <td>栏目排序： </td>
  <td><input name="catorder" type="text" class="text" id="catorder" value="<?=$cat[catorder]?>" size="13"></td>
</tr>
<tr bgcolor="#f5fbff">
  <td>是否启用： </td>
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
    <div class="left"><a href="javascript:collapse_change('2')">SEO优化设置<font style="color:#FF6600; font-weight:100">(若与栏目名称相同，
<label for="copy">
点此<input name="radio" id="copy" type="radio" onClick="do_copy();"  class="radio"/>复制</label>
)</font></div>
    <div class="right"><a href="javascript:collapse_change('2')"><img id="menuimg_2" src="template/images/menu_reduce.gif"/></a></div>
</td>
</tr>
<tbody id="menu_2">
<tr bgcolor="#f5fbff">
  <td width="15%">显示标题(title)： </td>
  <td> <input name="title" type="text" class="text" id="title" value="<?=$cat[title]?>" size="50"> <font color="red">*</font>(<font style="color:#FF6600">范例：郑州本地新闻_郑州电脑新闻</font>,不超过15个字符)
  </td>
</tr>
<tr bgcolor="#f5fbff">
  <td>关键词(keyword)： </td>
  <td><input name="keywords" type="text" class="text" id="keywords" value="<?=$cat[keywords]?>" size="50">   (多个关键字以","隔开;分站名用 <font color="red">{city}</font> 代替)</td>
</tr>
<tr bgcolor="#f5fbff">
  <td>介绍(description)： </td>
  <td><textarea name="description" cols="49" rows="5" id="description"><?=$cat[description]?></textarea> (分站名用 <font color="red">{city}</font> 代替)</td>
</tr>
<tr bgcolor="#f5fbff">
  <td>目录存放形式：<br /><i style="color:#666">生成静态目录时生效</i> </td>
  <td><?=GetHtmlType($cat[dir_type],'dir_type','edit',$cat[dir_typename])?> </td>
</tr>
</tbody>
</table>
</div>
<center>
<input type="submit" name="<?=CURSCRIPT?>_submit" value="保存修改" class="mymps mini" />　
<input type="button" onClick="location.href='?part=list'" value="返 回" class="mymps mini">
</center>
</form>
<?php mymps_admin_tpl_global_foot();?>