<?php include mymps_tpl('inc_head');?>
<div id="<?=MPS_SOFTNAME?>" style="padding-bottom:0">
	<div class="mpstopic-category">
		<div class="panel-tab">
			<ul class="clearfix tab-list">
				<li><a href="?part=cache" class="current">页面缓存</a></li>
				<li><a href="?part=cache_sys">数据缓存</a></li>
                <li><a href="optimise.php">系统优化</a></li>
			</ul>
		</div>
	</div>
</div>
<div id="<?=MPS_SOFTNAME?>">
<table border="0" cellspacing="0" cellpadding="0" class="vbm">
  <tr class="firstr">
  	<td colspan="2">技巧提示</td>
  </tr>
  <tr bgcolor="#ffffff">
    <td id="menu_tip">
 <li>注意：启用缓存功能后，在你设定的时间内，系统前台页面显示将不会发生变化</li>
  <li>如您尚未完成系统的配置和初始化安装，建议关闭所有页面的缓存功能</li>
  <li>开启页面缓存功能，可大大提高系统负载能力，具体时间视你的网站访问量而自己拟定 </li>
  <li>当贵站数据量过百万时，强烈建议开启页面缓存 </li>
    </td>
  </tr>
</table>
</div>
<form action="?part=cache_update" method="post">
<input name="return_url" type="hidden" value="<?=$return_url?>">
<div id="<?=MPS_SOFTNAME?>">
<table border="0" cellspacing="0" cellpadding="0" class="vbm">
  <tr class="firstr">
  	<td colspan="2">清除页面缓存</td>
  </tr>
  <tr>
	<td class="altbg1" valign="center" style="text-align:center;width:15%"><b>选择清除类型</b></td>
	<td class="altbg2">
	
	<label for="smarty_caches"><input checked="checked" name="updatecache[]" value="tpl_caches" type="checkbox" class="checkbox" id="smarty_caches">清除网页缓存文件</label><br />
	<label for="smarty_compiles"><input checked="checked" name="updatecache[]" value="tpl_compiles" type="checkbox" class="checkbox" id="smarty_compiles">清除模板编译文件</label><br />

	</td>
  </tr>
</table>
</div>
<center><input type="submit" value="提 交" class="mymps large"></center>
</form>
<div class="clear" style="height:10px;"></div>
<form action="?part=cacheupdate" method="post">
<div id="<?=MPS_SOFTNAME?>">
<table border="0" cellspacing="0" cellpadding="0" class="vbm">
    <tr class="firstr">
      <td width="200">缓存前台页面</td>
      <td>缓存时间</td>
    </tr>
    <? foreach ($admin_cache as $k =>$a)
    {
    ?>
<tr bgcolor="#f1f5f8">
      <td align="left">
        <b><?=$admin_cache_array[$k]?> (<?=$k?>)</b>
       </td>
      <td align="left">&nbsp;</td>
    </tr>
    <?
  	  foreach ($a as $q => $w)
      {
          if(is_array($w))
            {
    ?>
    <tr bgcolor="#ffffff">
      <td align="left">
        <?=$w["name"]?> (<?=$q?>)      </td>
      <td align="left" bgcolor="white">
      <select name="<?=$q."_time"?>">
      	<? foreach($time_cache as $c =>$d){?>
      	<option value="<?=$c?>" <? if($cache[$q][time] == $c) echo 'selected';?>><?=$d?></option>
        <? }?>
      </select>
      </td>
    </tr>
    <? }
    }}?>
</table>
</div>
<center>
<input class="mymps large" value="提 交" type="submit" > 
</center>
</form>
<?php echo mymps_admin_tpl_global_foot();?>