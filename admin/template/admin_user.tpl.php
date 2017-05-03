<?php include mymps_tpl('inc_head');?>
<div id="<?=MPS_SOFTNAME?>" style=" padding-bottom:0">
  <div class="mpstopic-category">
    <div class="panel-tab">
      <ul class="clearfix tab-list">
        <li><a href="?do=user" class="current">管理员列表</a></li>
        <li><a href="?do=user&part=add">增加管理员</a></li>
      </ul>
      <?php if(!$admin_cityid){?>
      <ul style="float:right; text-align:right">
       <select name="cityid" onChange="location.href='?do=user&cityid='+(this.options[this.selectedIndex].value)">
        <option value="0">总站</option>
        <?php echo get_cityoptions($cityid); ?>
      </select>
    </ul>
    <?php }?>
  </div>
</div>
</div>
<div id="<?=MPS_SOFTNAME?>">
  <table border="0" cellspacing="0" cellpadding="0" class="vbm">
    <tr class="firstr">
     <td colspan="2">相关说明</td>
   </tr>
   <tr bgcolor="#ffffff">
    <td id="menu_tip" colspan="2">
     <li>分站管理员登录后台，只能管理属于该分站下的信息数据</li>
   </td>
 </tr>
</table>
</div>
<div id="<?=MPS_SOFTNAME?>">
  <table border="0" cellspacing="0" cellpadding="0" class="vbm">
    <tr class="firstr">
      <td align="center">隶属分站</td>
      <td align="center">登录用户名</td>
      <td width="100" align="center">笔名</td>
      <td width="100" align="center">真名</td>
      <td width="50" align="center">用户组</td>
      <td align="center">上次登陆</td>
      <td align="center">管理项</td>
    </tr>
    <?
    foreach($admin AS $row)
    {
      ?>
      <tr align="center" bgcolor="#ffffff">
        <td><b><?=$allcities[$row['cityid']]['cityname'] ? $allcities[$row['cityid']]['cityname'] : '总站'?></b>&nbsp;</td>
        <td><?=$row[userid]?>&nbsp;</td>
        <td><?=$row[uname]?>&nbsp;</td>
        <td><?=$row[tname]?>&nbsp;</td>
        <td><?=$row[typename]?>&nbsp;</td>
        <td><em>时间：<?=GetTime($row[logintime])?>&nbsp;　IP：<?=$row[loginip]?></em></td>
        <td>
         <a href='admin.php?do=user&part=edit&id=<?=$row[id]?>'><u>更改</u></a> |
         <a href='admin.php?do=user&part=delete&id=<?=$row[id]?>' onClick="return confirm('您确定要删除该管理员吗，如不确定请点取消')"><u>删除</u></a>　
       </td>
     </tr>

     <?
   }
   ?>
 </table>
</div>
<?php mymps_admin_tpl_global_foot();?>