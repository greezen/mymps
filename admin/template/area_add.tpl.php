<?php include mymps_tpl('inc_head');?>
<form method=post onSubmit="return chkform()" name="form" action="?part=add">
  <div id="<?=MPS_SOFTNAME?>">
    <table border="0" cellspacing="0" cellpadding="0" class="vbm">
      <tr class="firstr">
        <td colspan="2" align="left">增加分站下的地区</td>
      </tr>
      <tr bgcolor="#ffffff">
        <td width="15%">地区名称： </td>
        <td>
          <textarea rows="3" name="newarea[areaname]" cols="50"></textarea><br />
          <div style="margin-top:3px">支持地区批量添加，多个地区以空格隔开<br />
            <font color="red">范例：地区1 地区2 地区3 地区4 地区5</font></div></td>
          </tr>
          <tr bgcolor="#ffffff">
            <td >隶属分站： </td>
            <td>
              <select name="newarea[cityid]">
                <?php if(is_array($city_area)){
                 foreach($city_area as $k => $v){
                  ?>
                  <option value="<?=$v['cityid']?>"><?=$v['firstletter']?>.<?=$v['cityname']?></option>
                  <?
                }   } else {
                 ?>
                 <option value="0" disabled="disabled">您尚未创建城市分站,请先创建城市分站</option>
                 <?
               }
               ?>
             </select>
           </td>
         </tr>
         <tr bgcolor="#ffffff">
          <td >地区排序： </td>
          <td><input name="newarea[displayorder]" class="txt" type="text" value=""></td>
        </tr>
      </table>
    </div>
    <center>
      <input type="submit" name="<?=CURSCRIPT?>_submit" value="提交" class="mymps large"/>
      &nbsp;&nbsp;
    </center>
  </form>
  <?php mymps_admin_tpl_global_foot();?>