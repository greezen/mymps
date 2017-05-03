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
       <td colspan="2">搜索符合条件的下单信息</td>
     </tr>
     <tr bgcolor="#ffffff">
      <td style="background-color:#f1f5f8; width:40%">联系人</td>
      <td>&nbsp;<input name="oname" class="text" value="<?php echo $oname; ?>"></td>
    </tr>
    <tr bgcolor="#ffffff">
      <td style="background-color:#f1f5f8; width:40%">商家用户名</td>
      <td>&nbsp;<input name="userid" class="text" value="<?php echo $userid; ?>"></td>
    </tr>
    <tr bgcolor="#ffffff">
      <td style="background-color:#f1f5f8">下单时间(书写格式：yy-mm-dd):</td>
      <td>&nbsp;<input name="begindate" style="width:80px;" class="text" value="<?php echo $begindate; ?>" readonly="readonly" id="datepicker1"> - <input name="enddate" style="width:80px;"  class="text" value="<?php echo $enddate; ?>" id="datepicker2" readonly="readonly"></td>
    </tr>
  </table>
</div>
<center><input type="submit" value="提 交" class="mymps large" /></center>
<div class="clear" style="margin-bottom:5px"></div>
</form>
<form action="?part=list" method="post">
  <input name="url" type="hidden" value="<?=GetUrl()?>">
  <input name="action" value="delall" type="hidden">
  <div id="<?=MPS_SOFTNAME?>">
    <table border="0" cellspacing="0" cellpadding="0" class="vbm" >
      <tr class="firstr">
       <td width="50">
         <input type="checkbox" name="chkall" onclick="AllCheck('prefix', this.form, 'selectedids')" class="checkbox"/>删?</td>
         <td>联系人</td>
         <td>商家用户名</td>
         <td>下单商品</td>
         <td width="100">联系电话</td>
         <td>下单时间</td>
         <td>IP</td>
         <td>数量</td>
         <td>操作</td>
       </tr>
       <tbody onmouseover="addMouseEvent(this);">
        <?php foreach($goods AS $row){?>
        <tr bgcolor="white" >
          <td><input type='checkbox' name='selectedids[]' value="<?=$row['id']?>" class='checkbox' id="<?=$row['id']?>"></td>
          <td><?=$row['oname']?></td>
          <td><a href="javascript:void(0);" onclick="
            setbg('<?=MPS_SOFTNAME?>会员中心',400,110,'../box.php?part=member&userid=<?=$row[userid]?>&admindir=<?=$admindir?>')"><?=$row[userid]?></a></td>
            <td><a href="../goods.php?id=<?=$row['goodsid']?>" target="_blank"><?=$row['goodsname']?></a></td>
            <td><?=$row['tel']?></td>
            <td><em><?php echo GetTime($row['dateline']); ?></em></td>
            <td><?=$row['ip']?></td>
            <td>&nbsp;<?=$row['ordernum']?></td>
            <td><a href="?part=view&id=<?=$row[id]?>">详细</a></td>
          </tr>
          <?}?>
        </tbody>
      </table>
    </div>
    <center><input type="submit" value="提 交" class="mymps large" name="<?=CURSCRIPT?>_submit"/></center>
  </form>
  <div class="pagination"><?php echo page2();?></div>
  <?php mymps_admin_tpl_global_foot();?>