<?php 
include mymps_tpl('inc_head_jq');
$admindir = getcwdOL();
?>
<script type="text/javascript" src="../include/datepicker/datepicker.js"></script>
<link rel="stylesheet" href="../include/datepicker/ui.css">
<script language='javascript'>
$(function(){
	$("#datepicker1").datepicker();
	$("#datepicker2").datepicker();
});
</script>
<form action="?" method="get">
<div id="<?=MPS_SOFTNAME?>">
<table border="0" cellspacing="0" cellpadding="0" class="vbm">
  <tr class="firstr">
  	<td colspan="2">搜索符合条件的优惠券</td>
  </tr>
  <tr bgcolor="#ffffff">
    <td style="background-color:#f1f5f8; width:40%">优惠券名称</td>
    <td>&nbsp;<input name="title" class="text" value="<?php echo $title; ?>"></td>
  </tr>
  <tr bgcolor="#ffffff">
    <td style="background-color:#f1f5f8; width:40%">用户名(UserID)</td>
    <td>&nbsp;<input name="userid" class="text" value="<?php echo $userid; ?>"></td>
  </tr>
  <tr bgcolor="#ffffff">
    <td style="background-color:#f1f5f8; width:40%">所属分类</td>
    <td>&nbsp;<select name="cate_id">
    <option value="">>不限分类</option>
    <?php echo get_couponclass_select('cate_id',$cate_id,'no'); ?>
    </select></td>
  </tr>
	<?php if(!$admin_cityid){?>
	<tr bgcolor="#ffffff">
	<td style="background-color:#f1f5f8; width:40%">所属地区</td>
	<td>&nbsp;<select name="cityid">
	<option value="">>城市分站</option>
	<?php echo get_cityoptions($cityid); ?>
	</select></td>
	</tr>
	<? }else{ ?>
	<input name="cityid" value="<?php echo $admin_cityid?>" type="hidden" />
	<? }?>
  <tr bgcolor="#ffffff">
    <td style="background-color:#f1f5f8">优惠期(书写格式：yy-mm-dd):</td>
    <td>&nbsp;<input name="begindate" readonly="readonly" id="datepicker1" class="text" style="width:80px" value="<?php echo $begindate; ?>"> - <input name="enddate" readonly="readonly" class="text" style="width:80px" id="datepicker2" value="<?php echo $enddate; ?>"></td>
  </tr>
  <tr bgcolor="#ffffff">
  	<td style="background:#f1f5f8">优惠券状态</td>
    <td>
    <label for="yes"><input class="radio" name="status" type="radio" value="yes" id="yes" <?php if($status == 'yes' || empty($status)) echo 'checked'; ?>>可用</label> <label for="no"><input name="status" class="radio" type="radio" value="no" id="no" <?php if($status == 'no' ) echo 'checked'; ?>>失效</label></td>
  </tr>
</table>
</div>
<center><input type="submit" value="提 交" class="mymps large" /></center>
<div class="clear" style="margin-bottom:5px"></div>
</form>
<form action="?part=list" method="post">
<input name="url" type="hidden" value="<?=GetUrl()?>">
<div id="<?=MPS_SOFTNAME?>">
<table border="0" cellspacing="0" cellpadding="0" class="vbm" >
    <tr class="firstr">
    <td width="30">&nbsp;</td>
    <td>预览图</td>
    <td>名称</td>
    <td width="100">上传会员</td>
    <td>上传时间</td>
    <td>可用？</td>
    <td>打印</td>
    <td>人气</td>
    <td>状态</td>
    <td>操作</td>
  </tr>
<tbody onmouseover="addMouseEvent(this);">
<?php foreach($coupon AS $row){?>
    <tr bgcolor="white" >
    <td><input type='checkbox' name='selectedids[]' value="<?=$row['id']?>" class='checkbox' id="<?=$row['id']?>"></td>
    <td><img src="<?=$mymps_global['SiteUrl'].$row['pre_picture']?>" width="60"></td>
    <td><a href="../coupon.php?id=<?=$row[id]?>" target="_blank"><?=$row['title']?></a></td>
    <td><a href="javascript:void(0);" onclick="
setbg('<?=MPS_SOFTNAME?>会员中心',400,110,'../box.php?part=member&userid=<?=$row[userid]?>&admindir=<?=$admindir?>')"><?=$row[userid]?></a></td>
    <td><em><?php echo GetTime($row['dateline']); ?></em></td>
    <td><?php echo $row['status'] == 1 ? '<font color=green>可用</font>' : '<font color=red>失效</font>' ;?></td>
    <td><?=$row['prints']?></td>
    <td><?=$row['hit']?></td>
    <td>
    <?php 
    if($row['grade'] == 0){
   		echo '<font color=red>待审</font>';
    }elseif($row['grade'] == 1){
    	echo '<font color=#006acd>正常</font>';
    }elseif($row['grade'] == 2){
   		echo '<font color=green>推荐</font>';
    }?></td>
    <td><a href="?part=edit&id=<?=$row[id]?>">编辑</a></td>
  </tr>
<?}?>
</tbody>
<tr bgcolor="#ffffff" height="28">
    <td style="border-right:1px #fff solid;"><input name="checkall" type="checkbox" id="checkall" onClick="CheckAll(this.form)" class="checkbox"/></td>
    <td colspan="10">
	<label for="grade0"><input type="radio" value="grade0" id="grade0" name="action" class="radio">转<font color=red>待审</font></label> 
    <label for="grade1"><input type="radio" value="grade1" id="grade1" name="action" class="radio">转<font color=#006acd>正常</font></label> 
    <label for="grade2"><input type="radio" value="grade2" id="grade2" name="action" class="radio">转<font color=green>推荐</font></label> 
     <hr style="height:1px; border:1px #c5d8e8 solid;"/>
     <label for="delall"><input type="radio" value="delall" id="delall" name="action" class="radio">批量删除</label> 
    </td>
</tr>
</table>
</div>
<center><input type="submit" value="提 交" class="mymps large" name="coupon_submit"/></center>
</form>
<div class="pagination"><?php echo page2();?></div>
<?php mymps_admin_tpl_global_foot();?>