<?php 
define('IN_MYMPS', true);

$charset	= 'gbk';
$dbcharset	= 'gbk';

require_once(dirname(__FILE__)."/global.php");
require_once(dirname(__FILE__)."/../include/global.php");
require_once(dirname(__FILE__)."/../include/cache.fun.php");

chk_mymps_install();

$step = isset($_GET['step']) ? intval($_GET['step']) : '';
$step = $step ? $step : '1' ;

$installinfo= "欢迎来到 <font class=\"softname\">".MPS_SOFTNAME."</font> <font class=\"version\">".MPS_VERSION."</font> 安装向导，安装前请仔细阅读安装说明后才开始安装。安装文件夹里同样提供了有关软件安装的说明，请您仔细阅读。<div style=\"margin-top:.5em\">安装过程中遇到任何问题 &nbsp;<a href=\"".MPS_BBS."\" target=\"_blank\" class=\"black\"><u><b>请到官方讨论区寻求帮助</b></u></a></div>";

if($step == '1'){

	$info = "阅读安装协议";
	include(mymps_tpl("inc_head"));
	$licence = openfile("../licence.txt");
	?>
	<div class="agreement">
		<?php echo $licence;?>
	</div>
	<div class="c"></div>
	<div id="content">

		<div class="wrapD">
			<div class="wrapE">
				<div class="c"></div>
			</div>
		</div>
		<div class="stepbt">
			<strong class="last">请务必认真阅读软件安装协议</strong>
			<input style="cursor:pointer;"  class="next mymps large" type="button" onclick="location.href='?step=2'" value="同意协议，进入下一步">
		</div>

	</div>
</div>
<?php

}elseif($step == '2'){
	
	$info = "阅读使用说明";
	include(mymps_tpl("inc_head"));
	$licence = openfile("../readme.txt");
	?>
	<div class="agreement">
		<?php echo $licence?>
	</div>
	<div class="c"></div>
	<div id="content">

		<div class="wrapD">
			<div class="wrapE">
				<div class="c"></div>
			</div>
		</div>
		<div class="stepbt">
			<input type="button" onclick="javascript:history.go(-1);" class="gray large last" value="上一步：阅读安装协议">
			<input style="cursor:pointer;" class="next mymps large" type="button" onclick="location.href='?step=3'" value="进入下一步">
		</div>

	</div>
</div>

<?php

}elseif($step == '3'){

	$info = "检测系统环境";
	$phpv = @phpversion();
	$sp_server = $_SERVER["SERVER_SOFTWARE"];
	$sp_name = $_SERVER["SERVER_NAME"];
	$short_open_tag = ini_get('short_open_tag')?'<font color=green>支持</font>':'<font color=red>请修改php.ini，short_open_tag=On，否则无法安装</font>';
	$disabled = ini_get('short_open_tag')?'':'disabled="disabled"';
	require_once(MYMPS_DATA."/sp_testdirs.php");
	include(mymps_tpl("inc_head"));
	?>
	<div class="c"></div>
	<div id="content">
		<div class="wrapD">
			<div class="wrapE">
				<div class="boxA">
					<div style="width:57%; float:left">
						<h3>检测系统环境</h3>
						<table class="dlA">
							<tr>
								<td width="130">服务器域名</td>
								<td><?php echo $sp_name; ?></td>
							</tr>
							<tr>
								<td>服务器操作系统</td>
								<td><?php echo defined('PHP_OS')?PHP_OS: ' '; ?></td>
							</tr>
							<tr>
								<td>服务器解译引擎</td>
								<td><?php echo $sp_server; ?></td>
							</tr>
							<tr>
								<td>PHP程式版本</td>
								<td><?php echo $phpv; ?></td>
							</tr>
							<tr>
								<td>mymps路径</td>
								<td><?php echo MYMPS_ROOT; ?></td>
							</tr>
							<tr>
								<td>短标记支持</td>
								<td><?php echo $short_open_tag; ?></td>
							</tr>
						</table>
					</div>
					<div style="margin-left:56%">
						<h3>检查目录可写</h3>
						<div style="margin-top:20px;">
							<?php include(MYMPS_TPL."/box/sp_testdirs.html"); ?>
						</div>
					</div>
					
				</div>
				<div class="c"></div>
				<br />
			</div>
		</div>
		<div class="stepbt">
			<input type="button" onclick="javascript:history.go(-1);" class="gray large last" value="上一步：阅读使用说明">
			<input style="cursor:pointer;" class="next mymps large" type="button" onclick="location.href='?step=4'" value="进入下一步" <?php echo $disabled; ?>>
		</button>
	</div>

</div>
</div>
<?php

}elseif ($step == '4'){
	
	$info = "填写数据库信息";
	include(mymps_tpl("inc_head"));
	?>
	<div class="c"></div>
	<script language="JavaScript">
		function $obj(id) {
			return document.getElementById(id);
		}
		function postcheck(){
			if(document.install.db_host.value==""){
				alert('数据库服务器不能为空');
				document.install.db_host.focus();
				return false;
			}
			if (document.install.db_user.value=="") {
				alert('数据库用户名不能为空');
				document.install.db_user.focus();
				return false;
			}
			if (document.install.db_name.value=="") {
				alert('数据库名不能为空');
				document.install.db_name.focus();
				return false;
			}
			if (!document.install.db_pass.value && !confirm('你填的数据库密码为空，是否使用空的数据库密码')) {
				return false;
			}
			document.install.mymps.disabled=true;
			document.install.mymps.value="安装中...";
			return true;
		}
	</script>
	<div id="content">
		<form name="install" action="index.php?step=5" method="post" onsubmit="return postcheck();">
			<div class="wrapD">
				<div class="wrapE">
					<div class="boxA">
						<div style="width:57%; float:left">
							<h3>填写数据库信息</h3>
							<table class="dlA">
								<tr>
									<td>数据库服务器</td>
									<td><input type="text" name="db_host" value="localhost" class="inputA" /></td>
								</tr>
								<tr>
									<td>数据库用户名</td>
									<td><input type="text" name="db_user" value="" class="inputA" /></td>
								</tr>
								<tr>
									<td>数据库密码</td>
									<td><input type="text" name="db_pass" value="" class="inputA" /></td>
								</tr>
								<tr>
									<td>数据库名</td>
									<td><input type="text" name="db_name" class="inputA" /></td>
								</tr>
								<tr>
									<td height="18">数据表区分前缀(如非必要.<b>请保持默认</b>)</td>
									<td><input type="text" name="db_mymps" value="my_" class="inputA" /></td>
								</tr>
							</table>
						</div>
						<div style="margin-left:56%">
							<h3>填写网站创始人信息</h3>
							<table class="dlA dlB">
								<tbody id="showadmin">
									<tr>
										<td>用户名</td>
										<td><input type="text" name="manager" class="inputA" /> 系统登录名</td>
									</tr>
									<tr>
										<td>密码</td>
										<td><input type="text" name="manager_pass" class="inputA" /></td>
									</tr>
									<tr>
										<td>确认密码</td>
										<td><input type="text" name="manager_chkpass" class="inputA" /></td>
									</tr>
									<tr>
										<td height="18">Email</td>
										<td><input type="text" name="email" class="inputA" value="" /></td>
									</tr>
								</tbody>
							</table>
						</div>
						
					</div>
					<div class="c"></div>
				</div>
			</div>
			<div class="c"></div>
			<div class="wrapCC">
				<table cellpadding="0" cellspacing="0" class="wrapCC_table">
					<tr>
						<td height="18">cookie加密前缀(如非必要.<b>请保持默认</b>)</td>
						<td><input type="text" name="cookiepre" value="<?php echo random(4).'_'; ?>" class="inputB" /></td>
					</tr>
					<tr>
						<td height="18">cookiedomain(如非必要.<b>请保持默认</b>)</td>
						<td><input type="text" name="cookiedomain" value="<?php echo !in_array($_SERVER["SERVER_NAME"],array('127.0.0.1','localhost')) ? str_replace('www','',$_SERVER["SERVER_NAME"]) : '' ;?>" class="inputB" /></td>
					</tr>
					<tr>
						<td height="18">cookiepath(如非必要.<b>请保持默认</b>)</td>
						<td><input type="text" name="cookiepath" value="/" class="inputB" /></td>
					</tr>
					<tr>
						<td height="18">安装全国各省市地区分类?</td>
						<td><input type="checkbox" name="installarea"/></td>
					</tr>
					<tr>
						<td height="18">安装默认信息栏目分类?</td>
						<td><input type="checkbox" name="installcategory" checked="checked"/></td>
					</tr>
					<tr>
						<td height="18">安装默认广告数据?</td>
						<td><input type="checkbox" name="installadv"/></td>
					</tr>
					<tr>
						<td height="18">安装信息模型数据?</td>
						<td><input type="checkbox" name="installinfomodel" checked="checked"/> 建议安装</td>
					</tr>
					<tr>
						<td height="18">安装优惠券分类?</td>
						<td><input type="checkbox" name="installcoupon" checked="checked"/> 建议安装</td>
					</tr>
					<tr>
						<td height="18">安装团购分类?</td>
						<td><input type="checkbox" name="installgroup" checked="checked"/> 建议安装</td>
					</tr>
					<tr>
						<td height="18">安装商家行业分类?</td>
						<td><input type="checkbox" name="installcorp" checked="checked"/> 建议安装</td>
					</tr>
				</table>
			</div>
			<div class="stepbt">
				<input type="button" onclick="javascript:history.go(-1);" class="gray large last" value="上一步：检测系统环境">
				<input style="cursor:pointer;" class="next mymps large" type="submit" value="进入下一步" name="mymps" id="mymps"></button>
			</div>
		</form>
	</div>
</div>
<?php

}elseif($step == '5'){
	@set_time_limit(0);
	$db_host  	= trim($_POST['db_host']);
	$db_user  	= trim($_POST['db_user']);
	$db_pass  	= trim($_POST['db_pass']);
	$db_name  	= trim($_POST['db_name']);
	$db_mymps 	= trim($_POST['db_mymps']);
	$admin      = trim($_POST['manager']);
	$password   = trim($_POST['manager_pass']);
	$repassword = trim($_POST['manager_chkpass']);
	$email      = trim($_POST['email']);
	$in_type	= trim($_POST['install_type']);
	
	!$db_host && write_msg("未填写数据库服务器地址。");
	!$db_user && write_msg("未填写数据库服务器用户名。");
	!$db_name && write_msg("未填写数据库名称。");
	(!$db_mymps || strstr($db_mymps, '.')) && write_msg("您指定的数据表前缀包含点字符，请返回修改。");
	
	!$admin && write_msg("未填写创始人登录用户名。");
	!$password && write_msg("未填写创始人管理密码。");
	!$repassword && write_msg("未填写重复密码。");
	($password != $repassword) && write_msg("两次输入的密码不一致。");

	$conn = @mysql_connect($db_host, $db_user, $db_pass);
	($conn === false) && write_msg("安装失败！请检查数据库用户名以及数据库密码是否正确。"); 
	
	mysql_connect($db_host, $db_user, $db_pass);
	$cur_os = PHP_OS;
	$cur_phpversion = PHP_VERSION;
	($cur_phpversion < '4.3.0') && write_msg("您的PHP版本低于4.3.0, 无法安装使用 ".MPS_SOFTNAME."<br />");
	$cur_mysqlversion = mysql_get_server_info();
	($cur_mysqlversion < '3.23') && write_msg("您的MySQL版本低于3.23, 由于程序没有经过此平台的测试, 建议您换 MySQL4 的数据库服务器.<br />");
	
	$yes = mysql_select_db($db_name);
	if($yes === false){
		$sql = $mysql_version >= '4.1' ? "CREATE DATABASE $db_name DEFAULT CHARACTER SET $dbcharset" : "CREATE DATABASE $db_name";
		(mysql_query($sql, $conn) === false) && write_msg("无法创建数据库,请检查相关参数是否正确。");
	}
	
	@mysql_close($conn);
	
	$files = "<?php\n\n";
	$files .= "\$charset    = \"$charset\";\n\n";
	$files .= "//系统字符集编码\n\n";
	$files .= "\$dbcharset = \"$dbcharset\";\n\n";
	$files .= "//数据库字符集编码\n\n";
	$files .= "\$db_host    = \"$db_host\";\n\n";
	$files .= "//数据库服务器地址，一般为localhost\n\n";
	$files .= "\$db_name    = \"$db_name\";\n\n";
	$files .= "//使用的数据库名称\n\n";
	$files .= "\$db_user    = \"$db_user\";\n\n";
	$files .= "//数据库帐号\n\n";
	$files .= "\$db_pass    = \"$db_pass\";\n\n";
	$files .= "//数据库密码\n\n";
	$files .= "\$db_mymps   = \"$db_mymps\";\n\n";
	$files .= "//数据库前缀\n\n";
	$files .= "\$db_intype  = \"$in_type\";\n\n";
	$files .= "\$cookiepre = \"$cookiepre\";\n\n";
	$files .= "//cookies加密前缀\n\n";
	$files .= "\$cookiedomain = \"$cookiedomain\";\n\n";
	$files .= "\$cookiepath = \"$cookiepath\";\n\n";
	$files .= "?>";
	
	$file = @fopen(MYMPS_DATA . '/config.db.php', 'wb+');
	
	!$file && write_msg('无法打开数据库配置文件 /config.db.php');
	if(!@fwrite($file, trim($files))){
		write_msg('无法写入配置文件 config.db.php');
		exit;
	}
	@fclose($file);
	
	require_once(MYMPS_INC."/db.class.php");
	
	if($install = import(MYMPS_ROOT.'/install/install.sql',$db_mymps,$dbcharset)){
		
		if($installarea) import(MYMPS_ROOT.'/install/install_area.sql',$db_mymps,$dbcharset);
		
		if($installcategory) import(MYMPS_ROOT.'/install/install_category.sql',$db_mymps,$dbcharset);
		
		if($installcoupon) import(MYMPS_ROOT.'/install/install_coupon.sql',$db_mymps,$dbcharset);
		
		if($installgroup) import(MYMPS_ROOT.'/install/install_group.sql',$db_mymps,$dbcharset);
		
		if($installcorp) import(MYMPS_ROOT.'/install/install_corp.sql',$db_mymps,$dbcharset);
		if($installinfomodel) import(MYMPS_ROOT.'/install/install_infomodel.sql',$db_mymps,$dbcharset);
		if($installadv) import(MYMPS_ROOT.'/install/install_adv.sql',$db_mymps,$dbcharset);
		
		$password = md5($password);
		$now_domain = get_inurl();
		$db->query("INSERT INTO `{$db_mymps}admin` (userid,uname,pwd,email,typeid) VALUES ('$admin','$admin','$password','$email','1')");
		$db->query("UPDATE `{$db_mymps}config` SET value = 'blue' WHERE description = 'cfg_tpl_dir'");
		$db->query("UPDATE `{$db_mymps}config` SET value = '$now_domain' WHERE description = 'SiteUrl'");
		update_config_cache();
		write_lock();
		restore_headerurl();
		restore_footerurl();
		$step = "!";
		$info = "完成安装";
		$mymps_install_success_info = "恭喜，您的 ".MPS_SOFTNAME."分类信息系统 ".MPS_VERSION." 已经安装成功！";
		include(mymps_tpl("inc_head"));
		?>
		<div class="c"></div>
		<div id="content">

			<div class="wrapD">
				<div class="wrapE">
					<div class="boxB">
						<div class="cgLeft"></div>
						<div class="cg" style="margin-left:35%">
							<h1><?php echo $mymps_install_success_info; ?></h1>
							<ul class="listA">
								<li>系统前台地址 ： <a href="<?php echo $now_domain; ?>/index.php" target="_blank" style="color:#000"><?php echo $now_domain?>/index.php</a></li>
								<li>系统后台地址 ： <a href="<?php echo $now_domain; ?>/admin/index.php?go=config" target="_blank" style="color:#000"><?php echo $now_domain?>/admin/index.php</a></li>
								<li><?php echo MPS_SOFTNAME;?>官方论坛 ： <a href="<?php echo MPS_BBS;?>" target="_blank" style="color:#000"><?php echo MPS_BBS?></a></li>
							</ul>
						</div>
					</div>
					<div class="c"></div>
				</div>
			</div>
			<div class="stepbt"><input type="button" class="next gray large" onClick="closewindows();" value="关闭窗口"></div>
			<script language="JavaScript">
				function closewindows(){
					var agt = navigator.userAgent.toLowerCase();
					var is_ie = ((agt.indexOf("msie") != -1) && (agt.indexOf("opera") == -1));
					if (is_ie) {
						var ieversion = parseFloat(agt.substring(agt.indexOf("msie")+5,agt.indexOf(';',agt.indexOf("msie"))));
						if (ieversion < 5.5) {
							var str  = '<object id="notipclose" classid="clsid:adb880a6-d8ff-11cf-9377-00aa003b7a11"><param name="command" value="close"></object>';
							document.body.insertadjacenthtml(beforeend,str);
							document.all.notipclose.click();
						} else {
							window.opener = null;
							window.close();
						}
					} else {
						window.close();
					}
				}
			</script>

		</div>

	</div>
	<?php
} else {
	write_msg('您的'.MPS_SOFTNAME.'安装失败！');
}
}

include(mymps_tpl("inc_foot"));

function restore_headerurl(){
	global $db,$db_mymps,$mymps_global;
	//$db -> query("DELETE FROM `{$db_mymps}navurl` WHERE typeid = '3'");
	/*信息栏目导航*/
	$query = $db -> query("SELECT * FROM `{$db_mymps}category` WHERE parentid = '0'");
	while($row = $db -> fetchRow($query)){
		$category[$row['catid']]['catid'] = $row['catid'];
		$category[$row['catid']]['name']  = $row['catname'];
		$category[$row['catid']]['uri']   = "category.php?catid=".$row['catid'];
		$category[$row['catid']]['flag']  = $row['catid'];
	}
	
	$i=0;
	if(is_array($category)){
		foreach($category as $k => $v){
			$i = $i+1;
			$db -> query("INSERT INTO `{$db_mymps}navurl` (url,target,title,flag,typeid,isview,displayorder,createtime)VALUES('$v[uri]','_self','$v[name]','$v[catid]','3','2','$i','$timestamp')");
		}
	}
}

function restore_footerurl(){
	global $db,$db_mymps,$timestamp;
	$seo = array();
	$seo['seo_force_about'] = 'active';
	$query = $db->query("SELECT * FROM `{$db_mymps}about` ORDER BY displayorder ASC");
	while($row=$db->fetchRow($query)){
		$about[$row['id']]['id']=$row['id'];
		$about[$row['id']]['name']=$row['typename'];
		$about[$row['id']]['uri']= Rewrite('about',array('part'=>'aboutus','id'=>$row['id']));
	}
	
	$url = array();
	$url['faq']['name']				= '网站帮助';
	$url['faq']['uri']				= Rewrite('about',array('part'=>'faq'));
	$url['friendlink']['name']		= '友情链接';
	$url['friendlink']['uri']		= Rewrite('about',array('part'=>'friendlink'));
	$url['annnounce']['name']		= '网站公告';
	$url['annnounce']['uri']		= Rewrite('about',array('part'=>'announce'));
	$url['sitemap']['name']			= '网站地图';
	$url['sitemap']['uri']			= Rewrite('about',array('part'=>'sitemap'));

	$url = is_array($about) ? array_merge($about,$url) : $url;
	$i=0;
	foreach($url as $k => $v){
		$i = $i+1;
		$db -> query("INSERT INTO `{$db_mymps}navurl` (url,target,title,flag,typeid,isview,displayorder,createtime)VALUES('$v[uri]','_blank','$v[name]','$k','2','2','$i','$timestamp')");
	}
}
?>