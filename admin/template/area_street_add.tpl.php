<?php include mymps_tpl('inc_head');?>
<form method=post onSubmit="return chkform()" name="form" action="?part=add">
  <div id="<?=MPS_SOFTNAME?>">
    <table border="0" cellspacing="0" cellpadding="0" class="vbm">
      <tr class="firstr">
        <td colspan="2" align="left">增加地区下的街道</td>
      </tr>
      <tr bgcolor="#ffffff">
        <td width="15%">街道名称： </td>
        <td>
          <textarea rows="3" name="newstreet[streetname]" cols="50"></textarea><br />
          <div style="margin-top:3px">支持街道批量添加，多个街道以空格隔开<br />
            <font color="red">范例：街道1 街道2 街道3 街道4 街道5</font></div></td>
          </tr>
          <tr bgcolor="#ffffff">
            <td >隶属地区： </td>
            <td>
              <select name="newstreet[areaid]">
                <?php if(is_array($city_area)){
                 foreach($city_area as $k => $v){
                  ?>
                  <optgroup label="<?=$v['firstletter']?>.<?=$v['cityname']?>">
                   <?php if(is_array($v['area'])){foreach($v['area'] as $t => $w){?>
                   <option value="<?=$w['areaid']?>"><?=$w['areaname']?></option>
                   <?php }}else {?>
                   <option value="0" disabled="disabled">您尚未增加分站地区，请先增加分站下的地区</option>
                   <?}?>
                 </optgroup>
                 <?
               }
             }else{
              ?>
              <option value="0" disabled="disabled">您尚未创建分站，请先创建分站</option>
              <?php }?>
            </select>
          </td>
        </tr>
        <tr bgcolor="#ffffff">
          <td >街道排序： </td>
          <td><input name="newstreet[displayorder]" class="txt" type="text"></td>
        </tr>
      </table>
    </div>
    <center>
      <input type="submit" name="<?=CURSCRIPT?>_submit" value="提交" class="mymps large"/>
      &nbsp;&nbsp;
    </center>
  </form>
  <?php mymps_admin_tpl_global_foot();?>