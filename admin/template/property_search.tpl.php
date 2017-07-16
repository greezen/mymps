<? include mymps_tpl('inc_head_jq');?>
<script type="text/javascript" src="../include/datepicker/datepicker.js"></script>
<link rel="stylesheet" href="../include/datepicker/ui.css">
<script language='javascript'>
    $(function(){
        $("#datepicker1").datepicker();
        $("#datepicker2").datepicker();
    });
</script>
<div id="<?=MPS_SOFTNAME?>" style=" padding-bottom:0">
    <div class="mpstopic-category">
        <div class="panel-tab">
            <ul class="clearfix tab-list">
                <li><a href="?act=search" class="current">交费记录</a></li>
            </ul>
        </div>
    </div>
</div>
    <form action="?" method="get">
        <div id="<?=MPS_SOFTNAME?>">
            <table border="0" cellspacing="0" cellpadding="0" class="vbm">
                <tr class="firstr">
                    <td colspan="2">搜索</td>
                </tr>
                <tr bgcolor="#ffffff">
                    <td style="background-color:#f1f5f8">日期 :</td>
                    <td>&nbsp;
                        <input name="begindate" style="width:80px;" class="text" value="<?php echo $begindate; ?>" readonly="readonly" id="datepicker1"> -
                        <input name="enddate" style="width:80px;"  class="text" value="<?php echo $enddate; ?>" id="datepicker2" readonly="readonly">
                        <input name="act" type="hidden" value="1" readonly="readonly">
                    </td>
                </tr>
            </table>
        </div>
        <center><input type="submit" value="提 交" class="mymps large" /></center>
        <div class="clear" style="margin-bottom:5px"></div>
    </form>
<form name="form_mymps" action="?part=list" method="post">
<div id="<?=MPS_SOFTNAME?>">
<table border="0" cellspacing="0" cellpadding="0" class="vbm">
    <tr class="firstr">
        <td>日期</td>
        <td>地址</td>
        <td>交费额</td>
        <td>交费人</td>
        <td>手机</td>
        <td>支付方式</td>
    </tr>
<?php foreach($list as $item) :?>
  <tr>
      <td><?=$item['period']?></td>
      <td><?=get_address($item['room_id'], 'room')?></td>
      <td><?=$item['manage_fee']+$item['electric_fee']+$item['water_fee']+$item['other_fee']?></td>
      <td><?=empty($item['openid'])?$item['userid']:$item['nickname'];?></td>
      <td><?=$item['mobile']?></td>
      <td><?=$map_pay_type[$item['pay_type']]?></td>
</tr>
<?php endforeach;?>
<tr>
    <td>总计：</td>
    <td colspan="5"><?=$total?></td>
</tr>
</table>
<div class="pagination"><?php echo page2();?></div>
</div>
</form>
<?=mymps_admin_tpl_global_foot()?>