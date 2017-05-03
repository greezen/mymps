<?php include mymps_tpl('inc_head');?>
<style>
  a.letter{margin:1px 5px; font-weight:bold; font-size:14px; text-decoration:underline;}
</style>
<script language=javascript>
  function chkform(){
   if(document.form.areaname.value==""){
    alert('请输入地区名称，多个地区以 | 隔开！');
    document.form.areaname.focus();
    return false;
  }
}

function getpinyin(t){
	if(t != ''){
		url='include/get_pinyin.php?t='+t;
		target='iframe_t';
		document.getElementById('form_t').action=url;
		document.getElementById('form_t').target=target;
		document.getElementById('form_t').submit();
	}
}

function getpinyinhead(t){
	if(t != ''){
		url='include/get_pinyin.php?ishead=1&t='+t;
		target='iframe_t';
		document.getElementById('form_t').action=url;
		document.getElementById('form_t').target=target;
		document.getElementById('form_t').submit();
	}
}
</script>
<script type="text/javascript" src="js/vbm.js"></script>
<div id="<?=MPS_SOFTNAME?>" style="padding-bottom:0">
  <div class="mpstopic-category">
    <div class="panel-tab">
      <ul class="clearfix tab-list">
        <li><a href="?" class="current">已增加分站/地区</a></li>
        <li><a href="province.php">省份/直辖市管理</a></li>
      </ul>
      <ul style="float:right; text-align:right">
        <form method="get" action="?">
         <select name="type">
          <option value="cityid" <?php if($type == 'cityid') echo 'selected'; ?>>分站编号</option>
          <option value="cityname" <?php if($type == 'cityname') echo 'selected'; ?>>分站名称</option>
          <option value="directory" <?php if($type == 'directory') echo 'selected'; ?>>存放目录名</option>
          <option value="provincename" <?php if($type == 'provincename') echo 'selected'; ?>>隶属省份</option>
        </select> 
        
        <input name="keywords" type="text" class="text" style="width:100px;" value="<?=$keywords?>">    每页显示记录数：<input name="showperpage" type="text" class="txt" value="<?=$showperpage ? $showperpage : ''?>">
        <input type="submit" value="搜 索" class="gray mini">
      </form>
    </ul>
  </div>
</div>
</div>

<div id="h0">

  <?php if(empty($cityid) && empty($areaid)){?>

  <form name="form_mymps" action="?part=list" method="post">
    <input name="url" type="hidden" value="<?=GetUrl()?>">
    <div id="<?=MPS_SOFTNAME?>">
      <table border="0" cellspacing="0" cellpadding="0" class="vbm">
        <tr class="firstr">
          <td width="40"><input name="chkall" type="checkbox" onclick="AllCheck('prefix', this.form, 'action')" class="checkbox" id="createdir"/></td>
          <td width="40">编号</td>
          <td width="40">状态</td>
          <td>分站名称</td>
          <td>存放目录</td>
          <td>域名</td>
          <td width="80">排序</td>
          <td>操作</td>
        </tr>
        <?php 
        if(is_array($list)){
          foreach($list AS $area)
          {
            ?>
            <tr bgcolor="#ffffff">
              <a name="<?=$area[firstletter]?>"></a>
              <td width="40"><label><input name="actiondir[<?=$area[cityid]?>]" value="<?=$area[directory]?>" type="checkbox" class="checkbox" <?php if(empty($area[directory])) echo 'disabled';?>/></label></td>
              <td width="40"><?=$area[cityid]?></td>
              <td width="40"><?=$area[status]==1?'<font color=green>正常</font>':'<font color=red>已关闭</font>'?></td>
              <td width="80" style="<?php if($area['ifhot'] == '1') echo 'color:red; text-decoration:underline'; ?>"><label><b><?=$area[cityname]?></b></label></td>
              <td align="left"><?=$mymps_global['cfg_citiesdir']?>/<?=$area[directory]?></td>
              <td align="left"><a href="<?=$area[domain] ? $area[domain] : $mymps_global['SiteUrl'].$mymps_global['cfg_citiesdir'].'/'.$area[directory]?>" target="_blank" style="text-decoration:underline"><?=$area[domain] ? $area[domain] : $mymps_global['SiteUrl'].$mymps_global['cfg_citiesdir'].'/'.$area[directory]?></a></td>
              <td width="40"><input name="updatecity_displayorder[<?=$area[cityid]?>]" value="<?=$area[displayorder]?>" class="txt" type="text"/></td>
              <td><a href="?part=list&cityid=<?=$area[cityid]?>">下属地区</a> / <a href="?part=edit&cityid=<?=$area[cityid]?>">编辑分站</a> / <a onClick="if(!confirm('该操作将同时删除该分站下的地区，路段，分类信息，会员，广告，公告设置，你确定要删除该分站吗？'))return false;" href="?part=del&cityid=<?=$area[cityid]?>">删除分站</a></td>
            </tr>
            <?
          }
        } else {
          ?>
          <tr bgcolor="#ffffff">
            <td colspan="10" bgcolor="#ffffff"><div class="nodata">地区 <span><?php echo $curareaname?></span>没有下属地区分类。</div></td>
          </tr>
          <?}?>
          <tr bgcolor="#f5fbff">
            <td  colspan="9">
             <label for="action_delcity"><input onclick="javascript:alert('将同步删除分站下的信息、新闻、商家等内容且不能恢复，请谨慎操作！')" type="radio" class="radio" id="action_delcity" name="action" value="delcity">删除分站</label>
             <label for="action_deldir"><input type="radio" class="radio" id="action_deldir" name="action" value="deldir">删除分站目录</label>
             <label for="action_mkdir"><input type="radio" class="radio" id="action_mkdir" name="action" value="mkdir">生成分站目录</label>
             <label for="action_open"><input type="radio" class="radio" id="action_open" name="action" value="open">开启分站</label>
             <label for="action_close"><input type="radio" class="radio" id="action_close" name="action" value="close">关闭分站</label>
           </td>
         </tr>
         <tr bgcolor="white">
           <td colspan="9">
            <input name="<?=CURSCRIPT?>_submit" type="submit" value="提交" class="mymps large"/>&nbsp;&nbsp;&nbsp;&nbsp;
            <input type="button" value="全部分站启用二级域名&raquo;" class="gray mini" onclick="if(!confirm('该操作需服务器/云主机/VPS支持'))return false;location.href='area.php?part=usedomain'" style="margin-left:90px;">
            <input type="button" value="全部分站取消二级域名&raquo;" class="gray mini" onclick="location.href='area.php?part=usenodomain'" style="margin-left:10px;">
            <input type="button" value="一键生成全部分站目录 &raquo;" class="gray mini" onclick="location.href='area.php?part=makealldir'" style="margin-left:10px;">
            <input type="button" value="一键删除全部分站目录 &raquo;" class="gray mini" onclick="location.href='area.php?part=delalldir'" style="margin-left:10px;">
          </td>
        </tr>
      </table>
    </div>
    <center></center>
  </form>
  <div class="pagination"><?=page2()?></div>

  <?php } elseif($areaid) {?>
  <div>
    当前位置：<span><a href="area.php">城市分站</a> &raquo; <a href="?cityid=<?=$cityid?>"><?php echo $cityname; ?></a> &raquo; <?php echo $currentname; ?></span>
  </div>
  <div class="clear"></div>
  <form action="?" method="post">
    <input name="areaid" value="<?php echo $areaid; ?>" type="hidden">
    <input name="cityname" value="<?php echo $cityname; ?>" type="hidden" />
    <input name="cityid" value="<?php echo $cityid; ?>" type="hidden" />
    <div id="<?=MPS_SOFTNAME?>">
     <table border="0" cellspacing="0" cellpadding="0" class="vbm">
      <tr class="firstr">
        <td width="40"><label><input name="checkall" type="checkbox" id="checkall" onClick="CheckAll(this.form)" class="checkbox"/>删?</label></td>
        <td width="60%">街道/路段名</td>
        <td>排序</td>
      </tr>
      <?php 
      if($list){
        foreach($list AS $area)
        {
          ?>
          <tr bgcolor="#ffffff">
            <td width="40"><label><input type='checkbox' name='deletestreetid[]' value='<?=$area[streetid]?>' class='checkbox'></label></td>
            <td align="left"><input name="updatestreet_streetname[<?=$area[streetid]?>]" value="<?=$area[streetname]?>" class="txt" style="width:100px"> </td>
            <td><input name="updatestreet_displayorder[<?=$area[streetid]?>]" value="<?=$area[displayorder]?>" class="txt" type="text"/></td>
          </tr>
          <?
        }
      } else {
        ?>
        <tr bgcolor="#ffffff">
          <td colspan="5" bgcolor="#ffffff"><div class="nodata">地区 <span><?php echo $currentname; ?></span>尚未添加隶属街道/路段<br />
            <br />返回<a href="?cityid=<?=$cityid?>">上一级</a></div></td>
          </tr>
          <?}?>
        </table>
      </div>
      <center><input name="<?=CURSCRIPT?>_submit" type="submit" value="提交" class="mymps large" onClick="if(!confirm('删除操作将同步删除隶属该区域的街道路段，您确定您要继续吗？'))return false;"/></center>
    </form>
    <div class="clear"></div>
    <form method="post" name="form" action="?">
      <input name="newstreet[areaid]" value="<?=$areaid?>" type="hidden">
      <input name="cityname" value="<?php echo $cityname; ?>" type="hidden" />
      <input name="cityid" value="<?php echo $cityid; ?>" type="hidden" />
      <div id="<?=MPS_SOFTNAME?>">
        <table border="0" cellspacing="0" cellpadding="0" class="vbm">
          <tr class="firstr">
            <td colspan="2" align="left">增加 <span><?=$currentname?></span>地区下的街道</td>
          </tr>
          <tr bgcolor="#ffffff">
            <td width="8%">街道名称： </td>
            <td>
              <textarea rows="3" name="newstreet[streetname]" cols="50"></textarea><br />
              <div style="margin-top:3px">支持街道批量添加，多个街道以空格隔开<br />
                <font color="red">范例：街道1 街道2 街道3 街道4 街道5</font></div></td>
              </tr>
              <tr bgcolor="#ffffff">
                <td >街道排序： </td>
                <td><input name="newstreet[displayorder]" class="txt" type="text" value="0"></td>
              </tr>
            </table>
          </div>
          <center>
            <input type="submit" name="<?=CURSCRIPT?>_submit" value="提交" class="mymps large"/>
            &nbsp;&nbsp;
          </center>
        </form>
        <?php } elseif($cityid) {?>
        <div>当前位置：<span><a href="area.php">城市分站</a> &raquo; <?php echo $currentname; ?></span></div>
        <div class="clear"></div>
        <form action="?" method="post">
          <input name="cityid" value="<?=$cityid?>" type="hidden">
          <div id="<?=MPS_SOFTNAME?>">
            <table border="0" cellspacing="0" cellpadding="0" class="vbm">
              <tr class="firstr">
                <td width="5%"><label><input name="checkall" type="checkbox" id="checkall" onClick="CheckAll(this.form)" class="checkbox"/>删?</label></td>
                <td>名称</td>
                <td>排序</td>
                <td>操作</td>
              </tr>
              <?php 
              if($list){
                foreach($list AS $area)
                {
                  ?>
                  <tr bgcolor="#ffffff">
                    <td><label><input type='checkbox' name='deleteareaid[]' value='<?=$area[areaid]?>' class='checkbox'></label></td>
                    <td align="left"><input name="updatearea_areaname[<?=$area[areaid]?>]" value="<?=$area[areaname]?>" class="txt" style="width:100px"> </td>
                    <td><input name="updatearea_displayorder[<?=$area[areaid]?>]" value="<?=$area[displayorder]?>" class="txt" type="text"/></td>
                    <td><a href="?part=list&areaid=<?=$area[areaid]?>&cityid=<?=$cityid?>&cityname=<?=$currentname?>">下属街道/路段</a></td>
                  </tr>
                  <?
                }
              } else {
                ?>
                <tr bgcolor="#ffffff">
                  <td colspan="5" bgcolor="#ffffff"><div class="nodata">该城市分站 <span><?php echo $currentname; ?></span>尚未添加隶属地区<br />
                    <br />返回<a href="area.php">上一级</a></div></td>
                  </tr>
                  <?}?>
                </table>
              </div>
              <center><input name="<?=CURSCRIPT?>_submit" type="submit" value="提交" class="mymps large"/></center>
            </form>
            <div class="clear" style="margin-top:5px"></div>
            <form method=post name="form" action="?">
              <input name="newarea[cityid]" value="<?=$cityid?>" type="hidden">
              <div id="<?=MPS_SOFTNAME?>">
                <table border="0" cellspacing="0" cellpadding="0" class="vbm">
                  <tr class="firstr">
                    <td colspan="2" align="left">增加 <span><?=$currentname?></span>分站下的地区</td>
                  </tr>
                  <tr bgcolor="#ffffff">
                    <td width="8%">地区名称： </td>
                    <td>
                      <textarea rows="3" name="newarea[areaname]" cols="50"></textarea><br />
                      <div style="margin-top:3px">支持地区批量添加，多个地区以空格隔开<br />
                        <font color="red">范例：地区1 地区2 地区3 地区4 地区5</font></div></td>
                      </tr>
                      <tr bgcolor="#ffffff">
                        <td >地区排序： </td>
                        <td><input name="newarea[displayorder]" class="txt" type="text" value="0"></td>
                      </tr>
                    </table>
                  </div>
                  <center>
                    <input type="submit" name="<?=CURSCRIPT?>_submit" value="提交" class="mymps large"/>
                    &nbsp;&nbsp;
                  </center>
                </form>
                <?php }?>
              </div>
              <?php mymps_admin_tpl_global_foot();?>