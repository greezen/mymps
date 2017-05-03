<?php include mymps_tpl('inc_head');?>
<script language="javascript" src="js/vbm.js"></script>
<script language="javascript">
  function hide_backup_type(){
   var jumpTest = $Obj('isjump');
   var jtr = $Obj('redirecturltr');
   if(jumpTest.checked){
    jtr.style.display = "";
  } else {
    jtr.style.display = "none";
  }
}
ifcheck = false;
</script>
<style>
  .dblist{ line-height:25px;}
  .dblist li{ float:left; display:block; width:200px;}
</style>
<div id="<?=MPS_SOFTNAME?>">
  <table border="0" cellspacing="0" cellpadding="0" class="vbm">
    <tr class="firstr">
     <td colspan="2">技巧提示</td>
   </tr>
   <tr bgcolor="#ffffff">
    <td id="menu_tip">
      <li style="color:#FF6600;">服务器备份目录为 <font color="#006acd"><b><? echo $mymps_global[cfg_backup_dir]?></b></font></li>
      <li>数据备份功能根据您的选择备份全部分类信息和设置数据，导出的数据文件可用“数据还原”功能</li>
      <li>数据备份选项中的设置，仅供高级用户的特殊用途使用，当您尚未对数据库做全面细致的了解之前，请使用默认参数备份，否则将导致备份数据错误等严重问题。
      </li>
      <li>十六进制方式可以保证备份数据的完整性，但是备份文件会占用更多的空间。
      </li>
      <li>压缩备份文件可以让您的备份文件占用更小的空间。
      </li>
    </td>
  </tr>
</table>
</div>
<form action="?part=backup&setup=1" method="post">
  <input name="action" value="doaction" type="hidden">
  <div id="<?=MPS_SOFTNAME?>">
    <table border="0" cellspacing="0" cellpadding="0" class="vbm">
      <tr class="firstr">
        <td colspan="2">数据备份类型</td>
      </tr>
      <tr bgcolor="#ffffff">
        <td width="100" class="bd_txt">数据库</td>
        <td>
          <label for="mymps"><input id="mymps" name="type" type="radio" class="radio" value="mymps" checked="checked" onClick="hide_backup_type()"> Mymps全部数据</label>
        </td>
      </tr>
      <tr bgcolor="#ffffff">
        <td width="56" class="bd_txt">&nbsp;</td>
        <td>
          <label for="isjump"><input name="type" type="radio" class="radio" value="custom" id="isjump" onClick="hide_backup_type()"> 自定义备份</label>
        </td>
      </tr>
      <tr bgcolor="#ffffff" id="redirecturltr" style="display:none">
       <td>
         <input class="checkbox" name="chkall" onclick="CheckAll(this.form)" checked="checked" type="checkbox" id="chkalltables" /><label for="chkalltables"> 全选</label>
       </td>
       <td>
        <ul class="dblist" onmouseover="altStyle(this);">
          <?php foreach($mymps_tables as $key => $val){?>
          <li><label for="list_<?php echo $val['Name'];?>"><input type="checkbox" name="customtables[]" value="<?php echo $val['Name'];?>" class="checkbox" checked="checked" id="list_<?php echo $val['Name'];?>"/> <?php echo $val['Name'];?></label></li>
          <?php }?>
        </ul>
      </td>
    </tr>
    <tr class="firstr">
      <td class="bd_txt" colspan="2">数据备份选项</td>
    </tr>
    <tr bgcolor="#ffffff">
    	<td>建表语句格式</td>
      <td>
        <input class="radio" type="radio" name="sqlcompat" value="" checked>&nbsp;默认<br />
        <input class="radio" type="radio" name="sqlcompat" value="MYSQL40">&nbsp;MySQL 3.23/4.0.x<br />
        <input class="radio" type="radio" name="sqlcompat" value="MYSQL41">&nbsp;MySQL 4.1.x/5.x</td>
      </tr>
      <tr bgcolor="#ffffff">
       <td>强制字符集</td>
       <td>
        <input class="radio" type="radio" name="sqlcharset" value="" checked="checked">&nbsp;默认<br />
        <input class="radio" type="radio" name="sqlcharset" value="gbk">&nbsp;GBK<br />
        <input class="radio" type="radio" name="sqlcharset" value="utf8">&nbsp;UTF-8</td>
      </tr>
      <tr bgcolor="#ffffff">
       <td>备份数据/结构</td>
       <td>
        <input class="radio" type="radio" name="extendins" value="0" checked>&nbsp;数据和结构<br />
        <input class="radio" type="radio" name="extendins" value="1" >&nbsp;只备份结构
      </td>
    </tr>
    <tr bgcolor="#ffffff">
     <td>备份文件名</td>
     <td><input type="text" class="text" name="filename" value="<?php echo $defaultfilename; ?>" />.sql</td>
   </tr>
<!--<tr bgcolor="#ffffff">
       <td>单卷文件长度限制</td>
       <td><input type="text" class="txt" names="sizelimit" value="4096" />KB</td>
     </tr> -->
   </table>
 </div>
 <center><input type="submit" name="backup_submit" value="提 交" class="mymps large"/></center>
</form>
<?php mymps_admin_tpl_global_foot();?>