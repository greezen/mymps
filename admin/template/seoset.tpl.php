<?php include mymps_tpl('inc_head');?>
<style>
FIELDSET{ float:left; width:44%; margin:10px 10px 5px 5px; height:150px; line-height:25px;}
</style>
<script type='text/javascript' src='js/vbm.js'></script>
<div id="<?=MPS_SOFTNAME?>">
<table border="0" cellspacing="0" cellpadding="0" class="vbm">
  <tr class="firstr">
  	<td colspan="2">技巧提示</td>
  </tr>
  <tr bgcolor="#ffffff">
    <td id="menu_tip">
    <li><?=MPS_SOFTNAME?>作为国内领先的CMS系统，内置了<b>各模块</b>的伪静态以及动静态自由切换的功能，开始DIY你的网站SEO配置吧！</li>
	<li>若不会使用规则文件，可以从这里面找一下：<a style="text-decoration:underline" href="http://zhideyao.cn/" target="_blank">http://zhideyao.cn/</a></li>
    </td>
  </tr>
</table>
</div>
<form action="seoset.php" method="post">
<div id="<?=MPS_SOFTNAME?>">
<table border="0" cellspacing="0" cellpadding="0" class="vbm">
  <tr class="firstr">
  	<td colspan="2">SEO基本设置</td>
  </tr>
 <tr bgcolor="#f1f5f8">
 <td style="width:35%; line-height:22px">网站标题，显示于title标签中网站名称之后，适当出现关键词</td>
 <td bgcolor="#ffffff"><input name="seo_sitename" value="<?=$seo['seo_sitename']?>" class="text"/></td>
 </tr>
 <tr bgcolor="#f1f5f8">
 <td style="width:35%; line-height:22px">网站关键词，多个关键词以“,”分隔开<br />
分站名用 <font color="red">{city}</font> 代替(未单独设置分站关键词时生效)</td>
 <td bgcolor="#ffffff"><input name="seo_keywords" value="<?=$seo['seo_keywords']?>" class="text"/></td>
 </tr>
 <tr bgcolor="#f1f5f8">
 <td style="width:35%; line-height:22px">网站描述，不超过255个字符<br />
分站名用 <font color="red">{city}</font> 代替(未单独设置分站描述时生效)</td>
 <td bgcolor="#ffffff"><textarea name="seo_description" style="height:100px; width:205px"><?=$seo['seo_description']?></textarea></td>
 </tr>
 <tr class="firstr">
  	<td colspan="2">SEO详细设置</td>
  </tr>
 <tr bgcolor="#f5f8ff" style="font-weight:bold">
      <td>针对页面</td>
      <td>显示方式</td>
    </tr>
 <tr bgcolor="#f1f5f8">
 <td style="width:35%">站务/about.php</td>
 <td bgcolor="#ffffff"><?=GetSeoType($seo[seo_force_about],'seo_force_about')?></td>
 </tr>
  <tr bgcolor="#f1f5f8">
  <td >分类/category.php</td>
 <td bgcolor="#ffffff"><?=GetSeoType($seo[seo_force_category],'seo_force_category')?></font></td>
 </tr>
  <tr bgcolor="#f1f5f8">
  <td >信息/info.php</td>
 <td bgcolor="#ffffff"><?=GetSeoType($seo[seo_force_info],'seo_force_info')?></td>
 </tr>
 <tr bgcolor="#f1f5f8">
  <td >新闻/news.php</td>
 <td bgcolor="#ffffff"><?=GetSeoType($seo[seo_force_news],'seo_force_news')?></td>
  <tr bgcolor="#f1f5f8">
 </tr>
  <tr bgcolor="#f1f5f8">
  <td >空间/space.php</td>
 <td bgcolor="#ffffff"><?=GetSeoType($seo[seo_force_space],'seo_force_space')?></td>
 </tr>
  <tr bgcolor="#f1f5f8">
  <td >店铺/store.php</td>
 <td bgcolor="#ffffff"><?=GetSeoType($seo[seo_force_store],'seo_force_store')?></td>
 </tr>
  <tr bgcolor="#f1f5f8">
  <td>商家黄页/corp.php</td>
 <td bgcolor="#ffffff"><?=GetSeoType($seo[seo_force_yp],'seo_force_yp')?></td>
 </tr>
</table>
</div>
<center><label for="updatefile"><input id="updatefile" name="updatefile" value="1" type="checkbox">更新伪静态规则文件</label></center>
<center><input name="seoset_submit" value="提 交" class="mymps large" type="submit"/></center>
</form>
<div class="clear" style="margin-top:5px"></div>
<div id="<?=MPS_SOFTNAME?>">
<table border="0" cellspacing="0" cellpadding="0" class="vbm">
 <tr class="firstr">
  	<td colspan="2">伪静态规则说明</td>
 </tr>
<!-- <tr>
    <td colspan="2" bgcolor="#f6ffdd">
    IIS伪静态规则文件 /rewrite/httpd.ini；Apache伪静态规则文件 /rewrite/.htaccess；如有不明之处请联系官方客服以获得帮助
    </td>
 </tr>-->
 <tr>
 	<td bgcolor="#ffffff" colspan="2">
     <FIELDSET><LEGEND>IIS.各分站二级域名伪静态说明</LEGEND> 
     对于多个分站使用独立二级域名,需要把你的域名泛解析到当前服务器所在IP .如：“*.mymps.com.cn”解析到你当前服务器的IP
     </FIELDSET>
      <FIELDSET><LEGEND>Apache.各分站二级域名伪静态说明</LEGEND>
         1：对于多个分站使用独立二级域名,需要把你的域名泛解析到当前服务器所在IP<br />
      2：分类->分站划分->已建分站->全部分站启用二级域名
      <br />
3：<input class="mymps mini" value="生成apache伪静态规则" onclick="location.href='?action=makeapacherewrite'" type="button" alt="点击生成apache伪静态规则文件" title="点击生成apache伪静态规则文件"><br />
4：修改apache配置文件,在最后一行添加以下代码
<br />Include <?php echo str_replace('\\','/',MYMPS_ROOT);?>/apache.txt 
</FIELDSET>
     <FIELDSET><LEGEND>IIS.各分站二级目录伪静态说明</LEGEND>
     IIS伪静态规则文件 /rewrite/httpd.ini
     <br />1：虚拟主机用户，添加伪静态规则路径 /rewrite/rewrite.dll
     <br />2：VPS或独立服务器用户，添加ISAPI， 路径为程序/rewrite/rewrite.dll
     </FIELDSET>
      <FIELDSET><LEGEND>Apache.各分站二级目录伪静态说明</LEGEND> 
      Apache伪静态规则文件 /rewrite/.htaccess
      </FIELDSET>
    </td>
 </tr> 
 </table>
</div>
<?php mymps_admin_tpl_global_foot();?>