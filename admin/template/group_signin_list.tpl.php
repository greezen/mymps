<?php 
include mymps_tpl('inc_head');
$admindir = getcwdOL();
?>

<script type='text/javascript' src='js/calendar.js'></script>
<form action="?" method="get">
<div id="<?=MPS_SOFTNAME?>">
<table border="0" cellspacing="0" cellpadding="0" class="vbm">
  <tr class="firstr">
  	<td colspan="2">搜索符合条件的报名信息</td>
  </tr>
  <tr bgcolor="#ffffff">
    <td style="background-color:#f1f5f8; width:40%">姓名</td>
    <td>&nbsp;<input name="name" class="text" value="<?php echo $name; ?>"></td>
  </tr>
  <tr bgcolor="#ffffff">
    <td style="background-color:#f1f5f8; width:40%">商家用户名</td>
    <td>&nbsp;<input name="userid" class="text" value="<?php echo $userid; ?>"></td>
  </tr>
  <tr bgcolor="#ffffff">
    <td style="background-color:#f1f5f8">报名时间(书写格式：yy-mm-dd):</td>
    <td>&nbsp;<input name="begindate" style="width:100px;" class="txt" value="<?php echo $begindate; ?>" onclick="popUpCalendar(this, this, &quot;yyyy-mm-dd&quot;)"> - <input name="enddate" style="width:100px;"  class="txt" value="<?php echo $enddate; ?>" onclick="popUpCalendar(this, this, &quot;yyyy-mm-dd&quot;)"></td>
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
    <td>真实姓名</td>
    <td>商家用户名</td>
    <td>所报活动</td>
    <td width="100">联系电话</td>
    <td>报名时间</td>
    <td>IP</td>
    <td>人数</td>
    <td>状态</td>
    <td>操作</td>
  </tr>
<tbody onmouseover="addMouseEvent(this);">
<?php foreach($group AS $row){?>
    <tr bgcolor="white" >
    <td><input type='checkbox' name='selectedids[]' value="<?=$row['signid']?>" class='checkbox' id="<?=$row['signid']?>"></td>
    <td><a href="?part=view&id=<?=$row[signid]?>"><?=$row['sname']?></a></td>
    <td><a href="javascript:void(0);" onclick="
setbg('<?=MPS_SOFTNAME?>会员中心',400,110,'../box.php?part=member&userid=<?=$row[userid]?>&admindir=<?=$admindir?>')"><?=$row[userid]?></a></td>
    <td><a href="../group.php?id=<?=$row['groupid']?>" target="_blank"><?=$row['gname']?></a></td>
    <td><?=$row['tel']?></td>
    <td><em><?php echo GetTime($row['dateline']); ?></em></td>
    <td><?=$row['signinip']?></td>
    <td>&nbsp;<?=$row['totalnumber']?></td>
    <td>
    <?php echo $status[$row['status']] ?></td>
    <td><a href="?part=view&id=<?=$row[signid]?>">详细</a></td>
  </tr>
<?}?>
</tbody>
<tr bgcolor="#ffffff" height="28">
    <td style="border-right:1px #fff solid;"><input name="checkall" type="checkbox" id="checkall" onClick="CheckAll(this.form)" class="checkbox"/></td>
    <td colspan="10">
    <?php foreach($status as $k => $v){?>
	<label for="status<?=$k?>"><input type="radio" value="status<?=$k?>" id="status<?=$k?>" name="action" class="radio">转<?=$v?></label> 
    <?php }?>
     <hr style="height:1px; border:1px #c5d8e8 solid;"/>
     <label for="delall"><input type="radio" value="delall" id="delall" name="action" class="radio">批量删除</label> 
    </td>
</tr>
</table>
</div>
<center><input type="submit" value="提 交" class="mymps large" name="<?=CURSCRIPT?>_submit"/></center>
</form>
<div class="pagination"><?php echo page2();?></div>
<?php mymps_admin_tpl_global_foot();?>