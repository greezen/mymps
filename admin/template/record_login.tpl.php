<?php include mymps_tpl('inc_head');?>
<?php if($do == 'admin'){?>
<div id="<?=MPS_SOFTNAME?>" style="padding-bottom:0">
	<div class="mpstopic-category">
		<div class="panel-tab">
			<ul class="clearfix tab-list">
				<li><a href="?do=<?=$do?>&part=login" <?php if($part == 'login'){?>class="current"<?php }?>>管理登录记录</a></li>
				<li><a href="?do=<?=$do?>&part=action" <?php if($part == 'action'){?>class="current"<?php }?>>管理操作记录</a></li>
			</ul>
		</div>
	</div>
</div>
<?} ?>
<div class="ccc2">
	<ul>
      <form action="?" name="form1" method="get">
        <select name="result">
            <option value=""<?php if(empty($result))echo "selected";?>>筛选&raquo;&nbsp;&nbsp;所有登录记录</option>
            <option value="false"<?php if($result == 'false')echo "selected";?>>筛选&raquo;&nbsp;&nbsp;登录失败记录</option>
            <option value="true"<?php if($result == 'true')echo "selected";?>>筛选&raquo;&nbsp;&nbsp;登录成功记录</option>
        </select>
      &nbsp;&nbsp;
     	<input name="keywords" class="text" value="<?=$keywords?>">
        <input name="do" value="<?=$do?>" type="hidden">
        <input name="part" value="login" type="hidden">
        <input type="submit" value="模糊搜索" class="gray mini">&nbsp;&nbsp;
     </form>
	</ul>
</div>
<div id="<?=MPS_SOFTNAME?>">
<table border="0" cellspacing="0" cellpadding="0" class="vbm">
  <form name='form1' method='post' action='?do=<?=$do?>&part=<?=$part?>' onSubmit='return checkSubmit();'>
    <input type='hidden' name='action' value='delall'/>
    <input name="url" type="hidden" value="<?=GetUrl()?>">
    <tr class="firstr">
    <td width="30">选择</td>
    <td align="center">尝试用户名</td>
    <td align="center">尝试密码</td>
    <td align="center">IP地址</td>
    <td align="center">时间</td>
    <td align="center">登录状态</td>
    </tr>
  	<tbody onmouseover="addMouseEvent(this);">
    <?
foreach($record AS $k)
{
?>
    <tr align="center" bgcolor="white">
    <td><input type='checkbox' class="checkbox" name='id[]' value='<?=$k[id]?>' id="<?=$k[id]?>"></td>
    <td><?=$k[adminid]?></td>
    <td><?if($k[result] == '0'){echo $k[adminpwd];}else{echo "******";}?></td>
    <td><?=$k[ip]?></td>
    <td><em><?=$k[pubdate]?></em></td>
    <td><?php 
    if($k[result] == '0'){echo "<font color=red>登录失败</font>";}else{echo "<font color=green>登录成功</font>";}?></td>
  </tr>
    <?
}
?>	</tbody>
    <tr bgcolor="#ffffff" height="28">
    <td align="center" style="border-right:1px #fff solid;"><input name="checkall" type="checkbox" class="checkbox" id="checkall" onClick="CheckAll(this.form)"/></td>
    <td colspan="10"><input type="submit" onClick="javascript:if(!confirm('确定要操作吗？\n\n此操作不可以恢复！'))return false;" value="批量删除" class="mymps mini" <?php if($do == 'admin'){echo "disabled";}?>/>  
         <input type="button" value="只保存最新的<?=$mymps_mymps['cfg_record_save']?>条记录" class="mymps mini" onclick="location.href='?do=<?=$do?>&part=<?=$part?>&action=delrecord&url=<?=urlencode(GetUrl())?>'">    
    </td>
    </tr>
    </form>
</table>
</div>
<div class="pagination"><?echo page2()?></div>
<?php mymps_admin_tpl_global_foot();?>