<?php include mymps_tpl('inc_head');?>
<form method="post" name="form1" action="?">
  <input name="cityid" value="<?php echo $cityid?>" type="hidden">
  <input name="cityedit[olddirectory]" value="<?php echo $city['directory']?>" type="hidden">
  <div id="<?=MPS_SOFTNAME?>">
    <table border="0" cellspacing="0" cellpadding="0" class="vbm">
      <tr class="firstr">
        <td colspan="2" align="left"><span><a href="area.php" style="text-decoration:underline">已增加分站地区</a> &raquo; <?=$city['cityname']?></span></td>
      </tr>
      <tr>
        <td colspan="5" bgcolor="#f6ffdd">
          对于多个分站,要使用二级域名的话,需要把你的域名泛解释到当前服务器所在IP .如：“*.mymps.com.cn”，泛解释域名必须是*号开头的.一切设置好之后,需要重启服务才会生效.
        </td>
      </tr>
      <tr bgcolor="#ffffff">
        <td width="15%" valign="top">隶属省份/直辖市： </td>
        <td>
          <select name="cityedit[provinceid]">
            <option value="0" <?php if($v['provinceid'] == 0) echo 'selected'; ?>>不隶属</option>
            <?php if(is_array($province)){foreach($province as $k => $v){?>
            <option value="<?=$v[provinceid]?>" <?php if($v['provinceid'] == $city['provinceid']) echo 'selected'; ?>><?=$v[provincename]?></option>
            <?php }}?>
          </select></td>
        </tr>
        <tr bgcolor="#ffffff">
          <td width="15%" valign="top">分站城市名： </td>
          <td><input name="cityedit[cityname]" class="text" type="text" value="<?=$city['cityname']?>">
            <font color="red">*</font>
            <div style="color:#666; margin-top:5px">如: 北京</div></td>
          </tr>
          <tr bgcolor="#ffffff">
            <td valign="top">分站城市全拼/英文全称：</td>
            <td><input name="cityedit[citypy]" class="text" type="text" value="<?=$city['citypy']?>"> <font color="red">*</font><div style="color:#666; margin-top:5px">如: <font style="text-decoration:underline">beijing</font><br />只能是字母\数字\下画线,不允许汉字与特殊字符</div> </td>
          </tr>
          <tr bgcolor="#ffffff">
            <td valign="top">拼音/单词首字母： </td>
            <td><input name="cityedit[firstletter]" class="txt" type="text" value="<?=$city['firstletter']?>"> 
              <font color="red">*</font>
              <div style="color:#666; margin-top:5px">如: b</div></td>
            </tr>
            <tr bgcolor="#ffffff">
              <td valign="top">目录名称： </td>
              <td><input name="cityedit[directory]" class="text" type="text" value="<?=$city['directory']?>"> <font color="red">*</font>
               <div style="color:#666; margin-top:5px">如: bj（建议拼音首字母）<br />只能是字母\数字\下画线,不允许汉字与特殊字符,否则无法访问<br />
                <font color="red">分站建立以后,你可以用&nbsp; <b style="color:#006acd; text-decoration:underline"><?php echo $mymps_global['SiteUrl']?><?php echo $mymps_global['cfg_citiesdir']; ?>/bj/</b> &nbsp;来访问此分站</font></div> </td>
              </tr>
              <tr bgcolor="#ffffff">
                <td valign="top">二级域名： </td>
                <td><input name="cityedit[domain]" class="text" type="text" value="<?=$city['domain']?>"> <font>末尾请务必接"/"</font><div style="color:#666; margin-top:5px">
                  如: http://bj.mymps.com.cn/
                  <br />你可以设置二级域名绑定以上目录,但是需要服务器设置绑定并且需要在域名管理那里做设置指向
                  <br /><font color="red">填写二级域名后你可以用&nbsp; <b style="color:#006acd; text-decoration:underline">http://bj.mymps.com.cn/</b> &nbsp;来访问此分站</font></div></td>
                </tr>
                <tr bgcolor="#ffffff">
                  <td>地图标注起始坐标：</td>
                  <td><input name="cityedit[mappoint]" id="mappoint" type="text" class="text" value="<?=$city['mappoint']?>"/><input name="markmap" type="button" class="gray mini" value="我要标注" onclick="javascript:setbg('地图标注',500,300,'../map.php?action=markpoint&width=500&height=230&title=default_map_point&p=<?=$city['mappoint']?>&cityname=<?=$city[citypy]?>')"/>
                    <div style="color:#666; margin-top:5px; line-height:25px;">
                     <i>(1).</i>若无法正常标注，请检查你的<a href="config.php">地图标注接口</a>设置是否设置正确<br />
                     <i>(2).</i>若使用<b>默认51ditu</b>接口，并且添加的城市为国内城市，则可不设置起始标注坐标(留空即可)，系统会自动锁定<font color="red">(重要！)</font>
                   </div></td>
                 </tr>
                 <tr bgcolor="#ffffff">
                  <td >城市排序： </td>
                  <td><input name="cityedit[displayorder]" class="txt" type="text" value="<?=$city['displayorder']?>"></td>
                </tr>
                <tr bgcolor="#ffffff">
                  <td >热门城市？ </td>
                  <td><input name="cityedit[ifhot]" class="checkbox" type="checkbox" value="1" <?php if($city['ifhot'] == 1) echo 'checked'; ?>></td>
                </tr>
                <tr class="firstr">
                  <td colspan="5">
                   SEO优化设置
                 </td>
               </tr>
               <tr bgcolor="#ffffff">
                <td >分站显示标题(title)： </td>
                <td><input name="cityedit[title]" class="text" type="text" value="<?=$city['title']?>"></td>
              </tr>
              <tr bgcolor="#ffffff">
                <td >分站关键词(keywords)： </td>
                <td><textarea name="cityedit[keywords]" style="width:500px; height:100px"><?=$city['keywords']?></textarea></td>
              </tr>
              <tr bgcolor="#ffffff">
                <td >分站描述(description)： </td>
                <td><textarea name="cityedit[description]" style="width:500px; height:100px"><?=$city['description']?></textarea></td>
              </tr>
            </table>
          </div>
          <center>
            <input type="submit" name="<?=CURSCRIPT?>_submit" value="提交" class="mymps large"/>
            &nbsp;&nbsp;
          </center>
        </form>
        <?php mymps_admin_tpl_global_foot();?>