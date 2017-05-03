<?php 
include mymps_tpl('inc_head');
$admindir = getcwdOL();
?>

<form action="?" method="get">
<div id="<?=MPS_SOFTNAME?>">
<table border="0" cellspacing="0" cellpadding="0" class="vbm">
  <tr class="firstr">
  	<td colspan="2">搜索符合条件的团购活动</td>
  </tr>
  <tr bgcolor="#ffffff">
    <td style="background-color:#f1f5f8; width:40%">团购活动名称</td>
    <td>&nbsp;<input name="gname" class="text" value="<?php echo $gname; ?>"></td>
  </tr>
  <tr bgcolor="#ffffff">
    <td style="background-color:#f1f5f8; width:40%">用户名(UserID)</td>
    <td>&nbsp;<input name="userid" class="text" value="<?php echo $userid; ?>"></td>
  </tr>
  <tr bgcolor="#ffffff">
    <td style="background-color:#f1f5f8; width:40%">所属分类</td>
    <td>&nbsp;<select name="cate_id">
    <option value="">>不限分类</option>
    <?php echo get_groupclass_select('cate_id',$cate_id,'no'); ?>
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
    <td>活动名称</td>
    <td width="100">发起商家</td>
    <td>发布时间</td>
    <td>排序</td>
    <td>报名</td>
    <td>状态</td>
    <td>操作</td>
  </tr>
<tbody onmouseover="addMouseEvent(this);">
<?php foreach($group AS $row){?>
    <tr bgcolor="white" >
    <td><input type='checkbox' name='selectedids[]' value="<?=$row['groupid']?>" class='checkbox' id="<?=$row['groupid']?>"></td>
    <td><img src="<?=$mymps_global['SiteUrl'].$row['pre_picture']?>" width="60"></td>
    <td><a href="../group.php?id=<?=$row[groupid]?>" target="_blank"><?=$row['gname']?></a></td>
    <td><a href="javascript:void(0);" onclick="
setbg('<?=MPS_SOFTNAME?>会员中心',400,110,'../box.php?part=member&userid=<?=$row[userid]?>&admindir=<?=$admindir?>')"><?=$row[userid]?></a></td>
    <td><em><?php echo GetTime($row['dateline']); ?></em></td>
    <td><?=$row['displayorder']?></td>
    <td>&nbsp;<?=$row['signintotal']?></td>
    <td>
    <?php echo $glevel[$row['glevel']] ?></td>
    <td><a href="?part=edit&id=<?=$row[groupid]?>">编辑</a></td>
  </tr>
<?}?>
</tbody>
<tr bgcolor="#ffffff" height="28">
    <td style="border-right:1px #fff solid;"><input name="checkall" type="checkbox" id="checkall" onClick="CheckAll(this.form)" class="checkbox"/></td>
    <td colspan="10">
    <?php foreach($glevel as $k => $v){?>
	<label for="glevel<?=$k?>"><input type="radio" value="glevel<?=$k?>" id="glevel<?=$k?>" name="action" class="radio">转<?=$v?></label> 
    <?php }?>
     <hr style="height:1px; border:1px #c5d8e8 solid;"/>
     <label for="delall"><input type="radio" value="delall" id="delall" name="action" class="radio">批量删除</label> 
    </td>
</tr>
</table>
</div>
<center><input type="submit" value="提 交" class="mymps large" name="group_submit"/></center>
</form>
<div class="pagination"><?php echo page2();?></div>
<?php mymps_admin_tpl_global_foot();?>