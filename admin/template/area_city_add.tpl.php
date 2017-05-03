<?php include mymps_tpl('inc_head');?>
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
<div id="<?=MPS_SOFTNAME?>" style="padding-bottom:0">
  <div class="mpstopic-category">
    <div class="panel-tab">
      <ul class="clearfix tab-list">
        <li><a href="?part=area_city_add" class="current">增加单一分站</a></li>
        <li><a href="?part=area_city_add&action=batch">批量增加分站</a></li>
      </ul>
    </div>
  </div>
</div>
<div style="display:none;">
  <iframe width=0 height=0 src='' id="iframe_t" name="iframe_t"></iframe> 
  <form method="post" target="iframe_t" id="form_t"></form>
</div>
<form method=post onSubmit="return chkform()" name="form" action="?">
  <div id="<?=MPS_SOFTNAME?>">
    <table border="0" cellspacing="0" cellpadding="0" class="vbm">
      <tr class="firstr">
        <td colspan="2" align="left">创建城市分站</td>
      </tr>
      <tr>
        <td colspan="5" bgcolor="#f6ffdd">
          对于多个分站,要使用二级域名的话,需要把你的域名泛解释到当前服务器所在IP .如：“*.<?php echo str_replace( array("http://","www."),array("",""),$mymps_global['SiteUrl'] ); ?>”，泛解释域名必须是*号开头的.一切设置好之后,需要重启服务才会生效.
        </td>
      </tr>
      <tr bgcolor="#ffffff">
        <td width="15%" valign="top">隶属省份/直辖市： </td>
        <td>
          <select name="citynew[provinceid]">
            <option value="0">不隶属</option>
            <?php if(is_array($province)){foreach($province as $k => $v){?>
            <option value="<?=$v[provinceid]?>"><?=$v[provincename]?></option>
            <?php }}?>
          </select></td>
        </tr>

        <tr bgcolor="#ffffff">
          <td width="15%" valign="top">分站城市名： </td>
          <td><input name="citynew[cityname]" id="newcityname" onBlur="getpinyinhead(this.value);" class="text" type="text"> <font color="red">*</font><div style="color:#666; margin-top:5px">如: 北京</div></td>
        </tr>
        <tr bgcolor="#ffffff">
          <td valign="top">分站储存目录名： </td>
          <td><input id="newdirectory" onBlur="document.getElementById('newfirstletter').value=this.value.substring(0,1);document.getElementById('newdomain').value='http://'+this.value+'<?php echo str_replace('http://www','',$mymps_global[SiteUrl]).'/'; ?>';getpinyin(document.getElementById('newcityname').value);" name="citynew[directory]" class="text" type="text" value=""> <font color="red">*</font><div style="color:#666; margin-top:5px">如: <font style="text-decoration:underline">bj</font>，只能是字母\数字\下画线,不允许汉字与特殊字符,否则无法访问<br />
            <font color="red">分站建立以后,你可以用&nbsp; <b style="color:#006acd; text-decoration:underline"><?php echo $mymps_global['SiteUrl']?><?php echo $mymps_global['cfg_citiesdir']; ?>/bj/</b> &nbsp;来访问此分站</font></div> </td>
          </tr>
          <tr bgcolor="#ffffff">
            <td valign="top">分站城市全拼/英文全称：</td>
            <td><input id="newcitypy" name="citynew[citypy]" class="text" type="text" value=""> <font color="red">*</font><div style="color:#666; margin-top:5px">如: <font style="text-decoration:underline">beijing</font>，只能是字母\数字\下画线,不允许汉字与特殊字符</div> </td>
          </tr>
          <tr bgcolor="#ffffff">
            <td valign="top">拼音/单词首字母： </td>
            <td><input id="newfirstletter" name="citynew[firstletter]" class="txt" type="text"> <font color="red">*</font><div style="color:#666; margin-top:5px">如: <font style="text-decoration:underline">b</font></div></td>
          </tr>
          <tr bgcolor="#ffffff">
            <td valign="top">二级域名： </td>
            <td><input id="newdomain" name="citynew[domain]" class="text" type="text" value=""> 
             <div style="color:#666; margin-top:5px">末尾请务必接"<font color="red">/</font>"，
              如: <font style="text-decoration:underline">http://beijing.mymps.com.cn/</font>
              <br /><font color="red">若不启用二级域名形式，请留空</font>
              <br />填写二级域名后你可以用&nbsp; <b style="color:#006acd; text-decoration:underline">http://beijing.<?php echo str_replace( array("http://","www."),array("",""),$mymps_global['SiteUrl'] ); ?></b> &nbsp;来访问此分站</div></td>
            </tr>
            <tr bgcolor="#ffffff">
              <td>地图标注起始坐标：</td>
              <td><input name="citynew[mappoint]" value="" class="text" id="mappoint"/><input type="button" class="gray mini" value="我要标注" onClick="javascript:setbg('地图标注',500,300,'../map.php?action=markpoint&width=500&height=230&title=default_map_point&cityname='+document.getElementById('newdirectory').value+'&p=')"/>
                <div style="color:#666; margin-top:5px; line-height:25px;">
                 <i>(1).</i>若无法正常标注，请检查你的<a href="config.php">地图标注接口</a>设置是否设置正确<br />
                 <i>(2).</i>若使用<b>51ditu</b>接口，并且添加的城市为国内城市，则可不设置起始标注坐标(留空即可)，系统会自动锁定<font color="red">(重要！)</font>
               </div></td>
             </tr>
             <tr bgcolor="#ffffff">
              <td >城市排序： </td>
              <td><input name="citynew[displayorder]" class="txt" type="text" value="<?=$db -> getOne("SELECT MAX(displayorder) FROM `{$db_mymps}city`")?>"></td>
            </tr>
            <tr bgcolor="#ffffff">
              <td >热门城市？ </td>
              <td><input name="citynew[ifhot]" class="checkbox" type="checkbox" value="1"></td>
            </tr>
            <tr class="firstr">
              <td colspan="5">
               SEO优化设置
             </td>
           </tr>
           <tr bgcolor="#ffffff">
            <td >分站显示标题(title)： </td>
            <td><input name="citynew[title]" class="text" type="text" value=""></td>
          </tr>
          <tr bgcolor="#ffffff">
            <td >分站关键词(keywords)： </td>
            <td><textarea name="citynew[keywords]" style="width:500px; height:100px"></textarea></td>
          </tr>
          <tr bgcolor="#ffffff">
            <td >分站描述(description)： </td>
            <td><textarea name="citynew[description]" style="width:500px; height:100px"></textarea></td>
          </tr>
        </table>
      </div>
      <center>
        <input type="submit" name="<?=CURSCRIPT?>_submit" value="提交" class="mymps large"/>
        &nbsp;&nbsp;
      </center>
    </form>
    <?php mymps_admin_tpl_global_foot();?>