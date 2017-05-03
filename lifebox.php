<?php
define('IN_MYMPS', true);

require_once dirname(__FILE__)."/include/global.php";
require_once MYMPS_DATA."/config.php";

ifsiteopen();
require_once MYMPS_DATA."/config.db.php";
require_once MYMPS_INC."/db.class.php";

$id = isset($id) ? intval($id) : '';

if($part == 'rand' || empty($id)){
	$lifebox = $db -> getRow("SELECT * FROM `{$db_mymps}lifebox` WHERE if_view = '2' ORDER BY rand() LIMIT 0,1");
	$nextlifebox = $db -> getRow("SELECT * FROM `{$db_mymps}lifebox` WHERE id > '$lifebox[id]' AND if_view = '2'");
} elseif($lifebox = $db -> getRow("SELECT * FROM `{$db_mymps}lifebox` WHERE id = '$id' AND if_view = '2'")) {
	$lifebox['typeid'] == '1' && write_msg('',$lifebox['lifeurl']);
	$nextlifebox = $db -> getRow("SELECT * FROM `{$db_mymps}lifebox` WHERE id > '$id' AND if_view = '2'");
}else {
	write_msg('您所指定的生活工具链接不存在或者为未启用状态!');
}
?>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
	<title><?php echo $lifebox['lifename']?> - 生活百宝箱 - <?php echo $mymps_global['SiteName']?></title>
	<meta name="keywords" content="<?php echo $lifebox['lifename']?>,<?php echo $mymps_global['SiteName']?>">
	<style>
		#ctop {border-top:4px solid #ff6600; width:100%; height:30px; padding-left:10px;padding-right:10px;background:#FEF0D4;font-size:14px; }
		.left{ float: left;}
		.right{ float: right;}
		.clear{ clear: both}
		a {color:#FF6600;text-decoration:underline;}
		a:hover {color:red;}
		.green {color:green;}
	</style>
</head>
<body style="margin: 0px;overflow:hidden">
	<table border=0 cellPadding=0 cellSpacing=0 height="100%" width="100%">
		<tr>
			<td>
				<iframe name="collecturl" SRC="<?php echo $lifebox['lifeurl']?>" frameBorder=0 style="HEIGHT: 100%; WIDTH: 100%;overflow-x:hidden;overflow-y:auto" scrolling=yes></iframe>
			</td>
		</tr>
		<tr height=10 style="overflow:hidden">
			<td>
				<div style="width:100%;height:36px; overflow:hidden;">
					<div id="ctop">
						<div class="left" style="padding-left:20px;line-height:30px; width:600px; overflow:hidden;"><a href='<?php echo $lifebox['lifeurl']; ?>' target=_top>查看原贴</a> <a href="lifebox.php?id=<?php echo $nextlifebox['id']; ?>" target=_top><?php echo $nextlifebox['lifename'] ? '下一个：'.$nextlifebox['lifename'] : ''; ?></a> </div>
						<div class="right" style="padding-left:20px;line-height:30px; "><a href="lifebox.php?part=rand" target=_top>随机显示</a> <a href="<?php echo $mymps_global['SiteUrl']; ?>" target=_blank>返回<?php echo $mymps_global['SiteName']; ?> &raquo;</a></div>
					</div>
				</td>
			</tr>
		</table>
		<div style="display:none">
			<?php
			echo $mymps_global['SiteStat'];
			is_object($db) && $db->Close();
			$mymps_global = $db = $timestamp = $part = $lifebox = NULL;
			?>
		</div>
	</body>
	</html>