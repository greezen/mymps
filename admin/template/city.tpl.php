<?php include mymps_tpl('inc_head');?>
<form name="form_mymps" action="?part=list" method="post">
<input name="rename" value="1" type="hidden">
<div id="<?=MPS_SOFTNAME?>">
    <table border="0" cellspacing="0" cellpadding="0" class="vbm">
		<tr class="firstr">
          <td colspan="2">城市切换页分站排列类型</td>
        </tr>
		<tr bgcolor="white">
			<td style="line-height:25px;" colspan="2">
			<label for="pinyin"><input name="cfg_cityshowtype" value="pinyin" type="radio" id="pinyin" <?php if($mymps_global['cfg_cityshowtype'] == 'pinyin') echo 'checked';?>>按分站拼音首字母</label><br />
			<label for="province"><input name="cfg_cityshowtype" value="province" type="radio" id="province" <?php if($mymps_global['cfg_cityshowtype'] == 'province') echo 'checked';?>>按分站所属省份</label>
			</td>
		</tr>
    	<tr class="firstr">
          <td colspan="2">浏览者首次访问网站首页(<font style="text-decoration:underline"><?php echo $mymps_global['SiteUrl']; ?></font>)时打开</td>
        </tr>
		<tr bgcolor="white">
          <td style="line-height:25px;" colspan="2">
         <label for="home"><input name="cfg_redirectpage" class="radio" value="home" type="radio" id="home" onclick="document.getElementById('nonecity').style.display='none';document.getElementById('sitecity').style.display='none'" <?php if($mymps_global['cfg_redirectpage'] == 'home') echo 'checked';?>>总站首页</label> <br />
<i style="margin-left:20px"><?php echo $mymps_global['SiteUrl']; ?></i><br />
          <label for="viewercity"><input name="cfg_redirectpage" class="radio" value="viewercity" type="radio" id="viewercity" onclick="document.getElementById('nonecity').style.display='';document.getElementById('sitecity').style.display='none'">浏览者所在城市的分站首页</label><br />
<div id="nonecity" style=" background-color:#f5f5f5; border:1px #eee solid; margin-top:5px; margin-bottom:5px; line-height:25px; padding-left:30px; <?php if(!in_array($mymps_global['cfg_redirectpage'],array('nchome','ncchangecity'))) echo 'display:none';?>">
  若无对应城市分站打开<br />
  <label for="nchome"><input name="cfg_redirectpage" class="radio" value="nchome" id="nchome" type="radio" <?php if($mymps_global['cfg_redirectpage'] == 'nchome') echo 'checked';?>>总站首页</label><br />
  <label for="ncchangecity"><input name="cfg_redirectpage" class="radio" value="ncchangecity" id="ncchangecity" type="radio" <?php if($mymps_global['cfg_redirectpage'] == 'ncchangecity') echo 'checked';?>>城市选择页</label>
</div>
<i style="margin-left:20px">根据浏览器IP自动跳转至所在城市分站，如：http://beijing.mymps.com.cn</i><br />
          <label for="changecity"><input onclick="document.getElementById('nonecity').style.display='none';document.getElementById('sitecity').style.display='none'" name="cfg_redirectpage" class="radio" value="changecity" type="radio" id="changecity" <?php if($mymps_global['cfg_redirectpage'] == 'changecity') echo 'checked';?>>城市选择页</label><br />
<i style="margin-left:20px"><?php echo $mymps_global['SiteUrl']?>/changecity.php</i><br />
		  <label for="citysite"><input onclick="document.getElementById('nonecity').style.display='none';document.getElementById('sitecity').style.display=''" class="radio" value="citysite" type="radio" id="citysite" name="cfg_redirectpage" <?php if(is_numeric($mymps_global['cfg_redirectpage'])) echo 'checked';?>>强制访问指定分站首页</label><br />
		  <div id="sitecity" style="<?php if(!is_numeric($mymps_global['cfg_redirectpage'])){?>display:none;<?php }?>  border-top:1px #eee solid; margin-top:5px; padding-top:10px; margin-bottom:5px; line-height:25px; padding-left:15px">
          
		  	<select name="cfg_redirectpagee">
			<?php echo get_cityoptions($mymps_global['cfg_redirectpage']); ?>
			</select>
		  </div>
        </td>
        </tr>
    	<tr class="firstr">
          <td colspan="2">城市分站文件存放目录</td>
        </tr>
        <tr bgcolor="white">
          <td width="250" style="line-height:25px;"><input name="cfg_citiesdir" class="text" value="<?php echo $mymps_global['cfg_citiesdir'];?>"><br /><i>范例:&nbsp;&nbsp;<b style="color:#006acd">/city</b>&nbsp;&nbsp;或留空。</i>
</td>
          <td bgcolor="#ffffff" style="border-left:1px #eee solid;">
          <div style="line-height:25px;">
          <b style="color:red">以北京(beijing)为例：</b><br />
<i>(1).</i>若填写为<font color="#006acd">/city</font>，北京分站文件存放目录则为<font color="#006acd">/city/beijing</font>，访问该分站时，分站路径为<font color="#006acd"><?=$mymps_global['SiteUrl']?>/city/beijing/</font><br /><i>(2).</i>若留空，北京分站文件存放目录为<font color="#006acd">/beijing</font>，访问该分站时，分站路径为<font color="#006acd"><?=$mymps_global['SiteUrl']?>/beijing/</font><br />
<b style="color:red">其他说明：</b><br />当分站存放目录留空时，各分站目录名不可与系统目录重复<br />
<?php 
foreach($mympsdirectory as $k){
	echo ' <font color="#006acd">/'.$k.'</font> ';
}
?>
		   </div>
           </td>
        </tr>
    	<tr class="firstr">
          <td colspan="2">分站模式下，选中以下模块数据为空时自动补充总站数据</td>
        </tr>
        <tr bgcolor="white">
          <td style="line-height:25px">
          <?php
          if($mymps_global['cfg_independency']){
          	$independency = explode(',',$mymps_global['cfg_independency']);
          } else {
		  	$independency = array();
		  }
          ?>
		  <select name="independency[]" multiple="multiple" style="width:220px; height:105px;">
		  	<option value="advertisement" <?php if(in_array('advertisement',$independency)) echo 'selected'; ?>>广告 /advertisement</option>
			<option value="focus" <?php if(in_array('focus',$independency)) echo 'selected'; ?>>焦点图 /focus</option>
			<option value="announce" <?php if(in_array('announce',$independency)) echo 'selected'; ?>>公告 /announce</option>
			<option value="friendlink" <?php if(in_array('friendlink',$independency)) echo 'selected'; ?>>友情链接 /friendlink</option>
			<option value="telephone" <?php if(in_array('telephone',$independency)) echo 'selected'; ?>>便民电话 /telephone</option>
			<option value="lifebox" <?php if(in_array('lifebox',$independency)) echo 'selected'; ?>>百宝箱 /lifebox</option>
		  </select>
          </td>
          <td bgcolor="#ffffff" valign="top" style="border-left:1px #eee solid;">
          <div style="line-height:25px;">
          <b style="color:red">相关说明：</b><br />
          <i>(1).</i>网站初期各分站的数据不多可能导致各个模块的数据显示为空<br />
		  <i>(2).</i>选择后，分站下该模块数据为空时将自动补充总站数据<br />
		  <i>(3).</i>提交成功后若未及时生效，请<a style="text-decoration:underline" href="config.php?part=cache_sys">前往清除并更新系统缓存</a>
          </div>
		  </td>
        </tr>
    </table>
</div>
<center><input name="<?=CURSCRIPT?>_submit" type="submit" value="提交" class="mymps large"/></center>
</form>
<?php mymps_admin_tpl_global_foot();?>