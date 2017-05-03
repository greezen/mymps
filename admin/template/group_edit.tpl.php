<?php 
include mymps_tpl('inc_head_jq');
?>
<script type="text/javascript" src="../include/datepicker/datepicker.js"></script>
<link rel="stylesheet" href="../include/datepicker/ui.css">
<script language='javascript'>
$(function(){
	$("#datepicker1").datepicker();
	$("#datepicker2").datepicker();
});
</script>
<script language="javascript" src="js/vbm.js"></script>
<script language="javascript">
function check_sub(){
	if (document.form1.gname.value=="") {
		alert('请填写活动标题');
		document.form1.gname.focus();
		return false;
	}
	if (document.form1.userid.value=="") {
		alert('请填写发起活动的会员用户名');
		document.form1.userid.focus();
		return false;
	}
	if (document.form1.gaddress.value=="") {
		alert('请填写活动地点！');
		document.form1.gaddress.focus();
		return false;
	}
	if (document.form1.meetdate.value=="") {
		alert('请选择集合时间！');
		document.form1.meetdate.focus();
		return false;
	}
	if (document.form1.enddate.value=="") {
		alert('请选择结束时间！');
		document.form1.enddate.focus();
		return false;
	}
	if (document.form1.des.value=="") {
		alert('请填写简短说明！');
		document.form1.des.focus();
		return false;
	}
	return true;
}
</script>
<style>
.vbm tr{ background:#ffffff}
.altbg1{ background-color:#f1f5f8}
.vbm span{ margin:0!important}
</style>
<form action="?part=edit&id=<?=$id?>" method="post" enctype="multipart/form-data" name="form1" onSubmit="return check_sub();">
<input name="pre_picture" value="<?=$edit['pre_picture']?>" type="hidden">
<input name="picture" value="<?=$edit['picture']?>" type="hidden">
<div id="<?=MPS_SOFTNAME?>">
<table width="100%" cellspacing="0" cellpadding="0" class="vbm">
<tr class="firstr">
	<td colspan="2">基本信息</td>
</tr>
<tr>
    <td class="altbg1">团购名称:<font color="red">*</font></td>
    <td>
        <input type="text" name="gname" value="<?=$edit['gname']?>" class="text" />
    </td>
</tr>
<tr>
    <td class="altbg1" width="15%">发起商家用户名:<font color="red">*</font></td>
    <td width="75%">
        <input type="text" name="userid" id="userid" value="<?=$edit['userid']?>" class="text" style="background-color:#eee"/> <font color=red>非必要，请勿修改</font>
    </td>
</tr>
<tr>
    <td class="altbg1">团购分类:<font color="red">*</font></td>
    <td>
        <?php echo get_groupclass_select('cate_id',$edit['cate_id']); ?>
    </td>
</tr>
<tr>
    <td class="altbg1">所属地区:<font color="red">*</font></td>
    <td>
        <?php echo select_where('area','areaid',$edit['areaid'],$edit['cityid']); ?>
    </td>
</tr>
<tr>
    <td class="altbg1">活动地点:<font color="red">*</font></td>
    <td><input type="text" name="gaddress" value="<?=$edit['gaddress']?>" class="text" /></td>
</tr>
<tr>
    <td class="altbg1">集合时间:<font color="red">*</font></td>
    <td><input id="datepicker1" type="text" name="meetdate" readonly="readonly" value="<?=$meetdate?>" class="text" style="width:180px" /></td>
</tr>
<tr>
    <td class="altbg1">结束时间:<font color="red">*</font></td>
    <td><input id="datepicker2" type="text" name="enddate" readonly="readonly" value="<?=$enddate?>" class="text" style="width:180px" /></td>
</tr>
<tr>
    <td class="altbg1">活动简介:<font color="red">*</font></td>
    <td><textarea name="des" style="height:60px; width:500px;"><?=de_textarea_post_change($edit['des'])?></textarea></td>
</tr>
<tr>
    <td class="altbg1">活动详情:<font color="red">*</font></td>
    <td><?php echo $acontent; ?></td>
</tr>
<tr class="firstr">
	<td colspan="2">预览图片</td>
</tr>
<tr>
    <td class="altbg1">团购图片:</td>
    <td> 
    <?php
    echo "<img src=".$mymps_global[SiteUrl]."".$edit[pre_picture]." style='_margin-top:expression(( 180 - this.height ) / 2);' />\r\n";
    ?>
    </td>
</tr>
<tr>
    <td class="altbg1">更新图片:</td>
    <td> 
    <input type="file" name="group_image" size="30">
    </td>
</tr>
<tr class="firstr">
	<td colspan="2">附加信息</td>
</tr>
<tr>
	<td class="altbg1">排列顺序</td>
    <td>
    <input name="displayorder" class="txt" value="<?=$edit['displayorder']?>">
    <br><br>
    数值越大，排列越靠前
    </td>
</tr>
<tr>
	<td class="altbg1">报名人数</td>
    <td>
    <input name="signintotal" class="txt" value="<?=$edit['signintotal']?>">
    <br><br>
    更改活动报名人数的显示，可帮您提高虚拟人气，新报名数字将在此基础上累加
    </td>
</tr>
<tr>
	<td class="altbg1">状态设置</td>
    <td>
    <select name="glevel">
    	<?php foreach($glevel as $k => $v){?>
    	<option value="<?=$k?>" <?php if($edit['glevel'] == $k) echo 'selected style=\'background-color:#6eb00c; color:white!important;\''; ?>><?=$v?></option>
        <?php }?>
    </select><br><br>
    审核通过，组团中均开启报名；待审核，活动流产，活动结束则隐藏报名
    </td>
</tr>
<tr>
    <td class="altbg1" width="15%">带队团长:</td>
    <td width="75%">
        <input type="text" name="mastername" id="mastername" value="<?=$edit['mastername']?>" class="text"/>
    </td>
</tr>
<tr>
    <td class="altbg1" width="15%">团长QQ:</td>
    <td width="75%">
        <input type="text" name="masterqq" id="masterqq" value="<?=$edit['masterqq']?>" class="text"/><br>
<br>供活动详情页面，团长旁边的在线QQ调用

    </td>
</tr>
<tr>
    <td class="altbg1" width="15%">讨论地址:</td>
    <td width="75%">
        <input type="text" name="commenturl" value="<?=$edit['commenturl']?>" class="text"/>
    </td>
</tr>
<tr>
    <td class="altbg1" width="15%">与此次活动的商家关系:</td>
    <td width="75%">
        <input type="text" name="biztype" value="<?=$edit['biztype']?>" class="text"/> 例如：合作，非合作
    </td>
</tr>
<tr>
    <td class="altbg1" width="15%">备注说明:</td>
    <td width="75%">
        <textarea name="othercontent" style="width:300px; height:100px;"><?=$edit['othercontent']?></textarea>
    </td>
</tr>
</table>
</div>
<center><input type="submit" name="group_submit" value="提 交" class="mymps large" /></center>
</form>
<?php mymps_admin_tpl_global_foot();?>