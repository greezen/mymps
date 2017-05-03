<?php include mymps_tpl('inc_head');?>
<div id="<?=MPS_SOFTNAME?>" style="padding-bottom:0">
  <div class="mpstopic-category">
    <div class="panel-tab">
      <ul class="clearfix tab-list">
        <li><a href="?part=area_city_add">增加单一分站</a></li>
        <li><a href="?part=area_city_add&action=batch" class="current">批量增加分站</a></li>
      </ul>
    </div>
  </div>
</div>
<?php if($step == '2'){?>
<form name="form_mymps" action="?" method="post">
  <input name="step" value="2" type="hidden">
  <input name="batchnewprovinceid" value="<?php echo $batchnew[provinceid]; ?>" type="hidden">
  <div id="<?=MPS_SOFTNAME?>">
    <table border="0" cellspacing="0" cellpadding="0" class="vbm">
      <tr class="firstr">
        <td width="80">隶属省份</td>
        <td width="80">分站名称</td>
        <td>储存目录名</td>
        <td>全拼/英文全称</td>
        <td>拼音首字母</td>
        <td>二级域名</td>
        <td>城市排序</td>
        <td>热门城市</td>
      </tr>
      <?php if(is_array($array)) {foreach($array as $k => $v){?>
      <tr>
        <td><?php echo $provincename ? $provincename : '<font color=red>不隶属</font>'; ?></td>
        <td><input name="batchnewcityname[]" value="<?php echo $v['cityname']; ?>" class="txt" type="text"/></td>
        <td><input name="batchnewdirectory[]" class="txt" type="text" value="<?php echo $v['directory']; ?>"></td>
        <td><input name="batchnewcitypy[]" class="text" type="text" value="<?php echo $v['citypy']; ?>"></td>
        <td><input name="batchnewfirstletter[]" class="txt" type="text" value="<?php echo $v['firstletter']; ?>"></td>
        <td><input name="batchnewdomain[]" class="text" type="text" value="<?php echo $v['domain']; ?>"></td>
        <td><input name="batchnewdisplayorder[]" class="txt" type="text" value="<?php echo $v['displayorder']; ?>"></td>
        <td><input name="batchnewifhot[]" type="checkbox" class="checkbox"></td>
      </tr>
      <?php }}?>
      <?php if($repeatwarning){?>
      <tr>
        <td colspan="8" bgcolor="#f6ffdd"><?php echo $repeatwarning; ?></td>
      </tr>
      <?php }?>
    </table>
  </div>
  <center><input type="button" onclick="history.go(-1);" value="< 返回" class="gray large"/> &nbsp; <input name="<?=CURSCRIPT?>_submit" type="submit" value="下一步 >" class="mymps large"/></center>
</form>
<?php }else{?>
<form method="post" name="form" action="?">
  <input name="step" value="1" type="hidden">
  <div id="<?=MPS_SOFTNAME?>">
    <table border="0" cellspacing="0" cellpadding="0" class="vbm">
      <tr class="firstr">
        <td colspan="2" align="left">创建城市分站</td>
      </tr>
      <tr bgcolor="#ffffff">
        <td width="15%" valign="top">隶属省份/直辖市： </td>
        <td>
          <select name="batchnew[provinceid]">
            <option value="0">不隶属</option>
            <?php if(is_array($province)){foreach($province as $k => $v){?>
            <option value="<?=$v[provinceid]?>"><?=$v[provincename]?></option>
            <?php }}?>
          </select></td>
        </tr>

        <tr bgcolor="#ffffff">
          <td width="15%" valign="top">分站城市名： </td>
          <td><textarea name="batchnew[cityname]" id="newcityname" style="width:400px; height:200px;"></textarea> <font color="red">*</font><div style="color:#666; margin-top:5px">多个分站名用空格相隔开，如: 北京 上海 天津 南昌 广州</div></td>
        </tr>
      </table>
    </div>
    <center>
      <input type="submit" name="<?=CURSCRIPT?>_submit" value="下一步" class="mymps large"/>
      &nbsp;&nbsp;
    </center>
  </form>
  <?php }?>
  <?php mymps_admin_tpl_global_foot();?>