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
	if (document.form1.title.value=="") {
		alert('请填写优惠券名称');
		document.form1.title.focus();
		return false;
	}
	if (document.form1.userid.value=="") {
		alert('请填写发布商家会员用户名');
		document.form1.userid.focus();
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
    <td class="altbg1">优惠券名称:<font color="red">*</font></td>
    <td>
        <input type="text" name="title" value="<?=$edit['title']?>" class="text" />
    </td>
</tr>
<tr>
    <td class="altbg1" width="15%">发布商家:<font color="red">*</font></td>
    <td width="75%">
        <input type="text" name="userid" id="userid" value="<?=$edit['userid']?>" class="text" style="background-color:#eee"/> <font color=red>非必要，请勿修改</font>
    </td>
</tr>
<tr>
    <td class="altbg1">优惠券分类:<font color="red">*</font></td>
    <td>
        <?php echo get_couponclass_select('cate_id',$edit['cate_id']); ?>
    </td>
</tr>
<tr>
    <td class="altbg1">所属地区:<font color="red">*</font></td>
    <td>
        <?php echo select_where('area','areaid',$edit['areaid'],$edit['cityid']); ?>
    </td>
</tr>
<tr>
    <td class="altbg1">有效期:</td>
    <td><input type="text" id="datepicker1" readonly="readonly" name="begindate" value="<?=$begindate?>" class="text" style="width:150px"/> - <input type="text" name="enddate" value="<?=$enddate?>" id="datepicker2" readonly="readonly" class="text" style="width:150px" />&nbsp;</td>
</tr>
<tr>
    <td class="altbg1">优惠说明:<font color="red">*</font></td>
    <td><textarea name="des" style="height:60px; width:500px;"><?=de_textarea_post_change($edit['des'])?></textarea></td>
</tr>
<tr>
    <td class="altbg1">优惠券类型:</td>
    <td>
         <label for="1"><input name="ctype" type="radio" id="1" onclick='$("sup").style.display = "";' class="radio" <?php if($edit['ctype'] == '折扣券' || empty($edit['ctype'])) echo 'checked'; ?>>折扣券</label> <label for="2"><input name="ctype" class="radio" onclick='$("sup").style.display = "none";' value="2" id="2" type="radio" <?php if($edit['ctype'] == '抵价券') echo 'checked'; ?>>抵价券</label>
    </td>
</tr>
<tr id="sup" <?php if($edit['sup'] == '抵价券') echo 'style="display:none"'?>>
	<td class="altbg1">折扣</td>
    <td><input name="sup" class="txt" value="<?=$edit['sup']?>"> 折</td>
</tr>
<tr>
    <td class="altbg1">可用:</td>
    <td>
        <input type="radio" name="status" value="1" id="radio_status_1"  checked="checked" class="radio"/><label for="radio_status_1">可用</label>&nbsp;<input type="radio" name="status" value="2" id="radio_status_2" class="radio"/><label for="radio_status_2">失效</label>                </td>
</tr>
<tr>
	<td class="altbg1">状态</td>
    <td>
    <select name="grade">
    	<option value="0" <?php if($edit['grade'] == 0) echo 'selected style=\'background-color:#6eb00c; color:white!important;\''; ?>>待审</option>
        <option value="1" <?php if($edit['grade'] == 1) echo 'selected style=\'background-color:#6eb00c; color:white!important;\''; ?>>正常</option>
        <option value="2" <?php if($edit['grade'] == 2) echo 'selected style=\'background-color:#6eb00c; color:white!important;\''; ?>>推荐</option>
    </select>
    </td>
</tr>
<tr class="firstr">
	<td colspan="2">预览图片</td>
</tr>
<tr>
    <td class="altbg1">优惠券图片:</td>
    <td> 
    <?php
    echo "<img src=".$mymps_global[SiteUrl]."".$edit[pre_picture]." style='_margin-top:expression(( 180 - this.height ) / 2);' />\r\n";
    ?>
    </td>
</tr>
<tr>
    <td class="altbg1">更新图片:</td>
    <td> 
    <input type="file" name="coupon_image" size="30" id="litpic" onChange="SeePic(document.picview,document.form1.litpic);">
    </td>
</tr>
<tr>
    <td class="altbg1">预览:</td>
    <td> 
    <img src="template/images/mpview.gif" width="150" id="picview" name="picview" />
    </td>
</tr>
</table>
<div style="margin-top:3px;">
<?php echo $acontent; ?>
</div>
</div>
<center><input type="submit" name="coupon_submit" value="提 交" class="mymps large" /></center>
</form>
<?php mymps_admin_tpl_global_foot();?>