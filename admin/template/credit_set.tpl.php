<?php include mymps_tpl('inc_head');?>
<div id="<?=MPS_SOFTNAME?>" style="padding-bottom:0">
	<div class="mpstopic-category">
		<div class="panel-tab">
			<ul class="clearfix tab-list">
			<li><a href="score.php">积分增减设置</a></li>
			<li><a href="credit.php">信用值增减设置</a></li>
			<li><a href="credit_set.php" class="current">信用等级管理</a></li>
			</ul>
		</div>
	</div>
</div>
<div id="<?=MPS_SOFTNAME?>">
<table border="0" cellspacing="0" cellpadding="0" class="vbm">
  <tr class="firstr">
  	<td colspan="2">相关说明</td>
  </tr>
  <tr bgcolor="#ffffff">
    <td id="menu_tip">
 		<li>您可以修改 /images/credit 目录下的图片，设计适合自己站点风格的图标</li>
    </td>
  </tr>
</table>
</div>
<div id="<?=MPS_SOFTNAME?>" style="margin-top:10px;">
<table border="0" cellspacing="0" cellpadding="0" class="vbm">
  <tr class="firstr">
  	<td colspan="2">实时更新会员信用值缓存</td>
  </tr>
 <tr bgcolor="#ffffff">
    	<td> 
        <li><input type="button" class="gray mini" onclick="location.href='?ac=update_credits';this.disabled='true'" value="更新会员信用图标"></li>
        </td>
        <td><div style="color:#333">
			1，在您修改了以下信用度设置后，网站的会员信用等级图标不会立即应用，须点击“更新会员信用图标”
<br />
2，如果您的网站会员很多，该操作耗时可能会较长
<br />
3，如果没有更新以下积分信用设置，不建议更新信用图标
		</div></td>
    </tr>
</table>
</div>
<form action="?" method="post">
<div id="<?=MPS_SOFTNAME?>">
<table border="0" cellspacing="0" cellpadding="0" class="vbm">
<tr class="firstr"><td colspan="5">信用等级</td></tr> 
<tr bgcolor="#f5f8ff" style="font-weight:bold"><td>信用等级</td><td>信用度大于</td><td>信用度小于</td><td>等级图标</td></tr> 
<?php for($i=1;$i<16;$i++){?>
<tr align="center" bgcolor="white"><td><?php echo $i; ?></td><td><input type="text" class="txt" name="credit_setnew[rank][<?php echo $i; ?>]" value="<?php echo $credit_set[rank][$i]?>"></td><td><?php echo $credit_set[rank][$i+1]?>&nbsp;</td><td><img src="../images/credit/<?php echo $i; ?>.gif" border="0"></td> 
<?php }?>
</table>
</div>
<center><input name="seoset_submit" value="提 交" class="mymps large" type="submit"/></center>
</form>
<?php mymps_admin_tpl_global_foot();?>