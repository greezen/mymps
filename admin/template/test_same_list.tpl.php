<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv='Content-Type' content='text/html; charset=gb2312'>
<title><?=$here?>  - powered by <?=MPS_SOFTNAME?></title>
<link href='template/css/<?=MPS_SOFTNAME?>.css' rel='stylesheet' type='text/css'>
<script type='text/javascript' src='../template/global/mymps.js'></script>
<script type='text/javascript' src='../template/global/noerr.js'></script>
</head>

<body>
<div id="<?=MPS_SOFTNAME?>">
<table border="0" cellspacing="0" cellpadding="0" class="vbm">
<form name="form1" action="test_same.php?" method="post">
<input name="part" value="do_action" type="hidden">
<input type='hidden' name='pagesize' value='<?=$pagesize?>' />
<input name="deltype" value="<?=$deltype?>" type="hidden" />
  <tr class="firstr">
    <td width="10%"> &nbsp;</td>
    <td width="10%"> 重复数量 </td>
    <td> 信息标题 </td>
  </tr>
 <?php
 while($row = $db->fetchRow($query))
 {
	 if($row['dd']==1 ) break;
 ?>
   <tr bgcolor="#FFFFFF" height="24" onMouseMove="javascript:this.bgColor='#EFEFEF';" onMouseOut="javascript:this.bgColor='#FFFFFF';">
    <td>
      <input name="infoTitles[]" id="<?=$row['id']?>" type="checkbox" value="<?php echo urlencode($row['title'])?>" class="checkbox" />
    </td>
    <td>
	<?php
     $allinfo += $row['dd'];
     echo $row['dd'];
    ?>
	</td>
    <td><a href="information.php?keywords=<?php echo $row['title']; ?>&show=title"><?php echo $row['title']; ?></a></td>
  </tr>
  <?php }?>
  <tr bgcolor="#E5F9FF">
   <td height="28" colspan="3" bgcolor="#F8FBFB"> <input name="chkall" type="checkbox" onclick="AllCheck('prefix', this.form, 'infoTitles')" class="checkbox"/> &nbsp;&nbsp;
     <input class="gray mini" value="删除重复信息" type="submit" name="<?=CURSCRIPT?>_submit">
      (共有 <font color="red"><?php echo $allinfo; ?></font> 篇重复标题的分类信息主题！)<br /><br />&nbsp;&nbsp;↑
只<?php echo $deltype == 'delnew' ? '保留最早的一条' : '保留最近的一条'?>
   </td>
 </tr>
</form>
</table>
</div>
</body>
</html>
