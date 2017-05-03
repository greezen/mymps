<?php include mymps_tpl('inc_head');?>
<div id="<?=MPS_SOFTNAME?>">
<table border="0" cellspacing="0" cellpadding="0" class="vbm">
      <tr class="firstr">
      <td colspan="2">
       基本资料
      </td>
      </tr>
      <tr bgcolor="#f5fbff">
        <td>所报活动</td>
        <td bgcolor="white">
        <a href="group_list.php?part=edit&id=<?php echo $view['groupid']; ?>" target="_blank"><?php echo $view['gname']; ?></a>
        </td>
      </tr>
	  <tr bgcolor="#f5fbff">
        <td>真实姓名</td>
        <td bgcolor="white">
        <?php echo $view['sname']; ?>
        </td>
      </tr>
      <tr bgcolor="#f5fbff">
        <td>联系电话</td>
        <td bgcolor="white">
        <?php echo $view['tel']; ?>
        </td>
      </tr>
      <tr bgcolor="#f5fbff">
        <td>QQ</td>
        <td bgcolor="white">
        <?php echo $view['qqmsn']; ?>
        </td>
      </tr>
      <tr bgcolor="#f5fbff">
        <td>年龄</td>
        <td bgcolor="white">
        <?php echo $view['age']; ?>
        </td>
      </tr>
      <tr bgcolor="#f5fbff">
        <td>参加人数</td>
        <td bgcolor="white">
        <?php echo $view['totalnumber']; ?>
        </td>
      </tr>
      <tr bgcolor="#f5fbff">
        <td>简短附言</td>
        <td bgcolor="white">
        <?php echo $view['message']; ?>
        </td>
      </tr>
      <tr class="firstr">
      	<td colspan="2">附加资料</td>
      </tr>
      <tr bgcolor="#f5fbff">
        <td>报名时间</td>
        <td bgcolor="white">
        <?php echo GetTime($view['dateline']); ?>
        </td>
      </tr>
      <tr bgcolor="#f5fbff">
        <td>报名IP</td>
        <td bgcolor="white">
        <?php echo $view['signinip']; ?>
        </td>
      </tr>
      <tr bgcolor="#f5fbff">
        <td>当前状态</td>
        <td bgcolor="white">
        <?php echo $status[$view['status']]; ?>
        </td>
      </tr>
</table>
</div>
<center><input type="submit" class="mymps large" value="返 回" onClick="history.back();"></center>
<?php mymps_admin_tpl_global_foot();?>