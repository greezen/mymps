<?php
define('IN_SMT',true);
define('CURSCRIPT','post');
define('IN_MYMPS', true);
define('IN_MANAGE',true);

require_once dirname(__FILE__)."/include/global.php";
require_once dirname(__FILE__)."/data/config.php";
require_once MYMPS_DATA."/config.db.php";
require_once MYMPS_INC."/db.class.php";
require_once MYMPS_INC."/upfile.fun.php";
require_once MYMPS_DATA."/config.inc.php";

ifsiteopen();
$data = '';
@include MYMPS_DATA.'/caches/authcodesettings.php';
$authcodesettings = $data;
$data = NULL;

!in_array($action,array('input','edit','ok')) && $action = 'input';
$action = isset($action) ? trim($action) : '';
$cityid	= isset($cityid) ? intval($cityid) : '';

if($action != 'ok')
{
	$ip = '';
	$ip = GetIP();
	$ip2area 	= $address = $ipdata = '';
	require_once MYMPS_INC.'/ip.class.php';
	$ipdata  = new ip();
	$address = $ipdata -> getaddress($ip);
	$ip2area = $address['area1'].$address['area2'];
	if($mymps_global['cfg_if_post_othercity'] == 0 && $cityid && is_array($cityarr = get_ip2city($ip))){
		if($cityid != $cityarr[cityid]) write_msg('您的IP不属于该分站，请不要在该分站下发布信息^_^');
	}
	unset($ipdata,$address);
}

if($act == 'dopost') {

	if(!$mixcode || $mixcode != md5($cookiepre)){
		die('FORBIDDEN');
		exit();
	}
	
	empty($cityid) && write_msg('请选择您要发布的分站！');
	empty($title) && write_msg("请输入信息标题!");
	empty($content) && write_msg("您还没有输入信息描述!");
	empty($tel) && write_msg("联系电话不能为空！");
	empty($contact_who) && write_msg("联系人不能为空！");
	
	mymps_check_upimage("mymps_img_");
	$lat = isset($lat) ? (float)$lat : '';
	$lng = isset($lng) ? (float)$lng : '';
	$id = $action == 'edit' ? intval($id) : '';
	$userid 	= isset($userid) ? mhtmlspecialchars($userid) : '';
	$manage_pwd	= isset($manage_pwd) ? trim($manage_pwd) : '';
	$catid 		= intval($catid);
	if(empty($catid)) write_msg('您未指定发布的信息栏目');
	$areaid 	= intval($areaid);
	$streetid	= intval($streetid);
	$title 		= trim(mhtmlspecialchars($title));
	$content	= $mymps_global['cfg_post_editor'] == 1 ? $content : textarea_post_change($content) ;
	$begintime 	= $timestamp;
	$activetime	= $endtime 	= intval($endtime);
	$endtime 	= ($endtime == 0)?0:(($endtime*3600*24)+$begintime);
	$ismember 	= intval($ismember);
	$mappoint   = isset($mappoint) ? trim(mhtmlspecialchars($mappoint)) : '';
	$tel		= isset($tel) ? trim(mhtmlspecialchars($tel)) : '';
	$qq			= isset($qq) ? trim(mhtmlspecialchars($qq)) : '';
	$web_address= trim(mhtmlspecialchars($web_address));
	$email		= isset($email) ? trim(mhtmlspecialchars($email)) : '';
	$result 	= verify_badwords_filter($mymps_global['cfg_if_info_verify'],$title,$content);
	$title 		= $result['title'];
	$content 	= $result['content'];
	$content	= preg_replace("/<a[^>]+>(.+?)<\/a>/i","$1",$content);;//去除超链接文字和代码
	$info_level = $result['level'];
	unset($result);
	$extra		= isset($extra) ? $extra : '';
	
	$d = $db->getRow("SELECT catname,dir_typename,modid FROM `{$db_mymps}category` WHERE catid = '$catid'");
	
	if($action == 'input'){
	
		if(!empty($mymps_global['cfg_allow_post_area']) && !empty($ip2area)){
			$i = 1;
			$allow_post_area = array();
			$allow_post_area = explode('=',$mymps_global['cfg_allow_post_area']);
			$allow_post_areas = explode(',',$allow_post_area[0]);
			foreach($allow_post_areas as $k => $v){
				if(strstr($ip2area,$v)) {
					$i=$i+1;
				}
			}
			if($allow_post_area[1] == '-1' && $i == 1){
				write_msg("系统判断您的IP并非<b style='color:red'>".$allow_post_area[0]."</b>本地IP！<br />如果您要继续操作，请联系客服。");
				exit;
			} elseif($allow_post_area[1] == 0 && $i == 1) {
				$info_level = 0;
			}
			unset($allow_post_area,$address,$ipdata,$allow_post_areas,$i);
		}
		
		$checkquestion = isset($checkquestion) ? $checkquestion : '';
		$data = '';
		@include MYMPS_DATA.'/caches/checkanswer_settings.php';
		if(is_array($data)){
			$whenpost = $data['whenpost'];
			$result   = read_static_cache('checkanswer');
			if($whenpost == 1 && is_array($result)){
				if(!is_array($checkquestion) || empty($checkquestion['answer']) || empty($checkquestion['id'])){
					write_msg('您还没有输入验证问题！');
					exit;
				}
				if($result[$checkquestion['id']]['answer'] != $checkquestion['answer']){
					write_msg('您输入的验证问题答案不正确，请重新输入！');
				}
			}
			$result = $checkquestion = $whenpost = $data = NULL;
		}
		
		$img_count	= upload_img_num('mymps_img_');
		
		if(!empty($mymps_global['cfg_disallow_post_tel']) && !empty($tel)){
			$disallow_tel = array();
			$disallow_tel = explode('=',$mymps_global['cfg_disallow_post_tel']);
			$disallow_telarray = explode(',',$disallow_tel[0]);
			if($disallow_tel[1] == -1){
				in_array($tel,$disallow_telarray) && write_msg("您的电话号码<b style='color:red'>".$tel."</b> 已被管理员加入黑名单！<br />如果您要继续操作，请联系客服。");
			} elseif($disallow_tel[1] == 0) {
				in_array($tel,$disallow_telarray) && $info_level = 0;
			}
			unset($disallow_tel,$disallow_telarray);
		}
		
		if (empty($ismember)){
			if($mymps_global['cfg_if_nonmember_info'] != 1) write_msg('对不起，您还没有登录！请您登录后再发布信息！');
			 //游客发布信息数量限制
			if($mymps_global['cfg_if_nonmember_info'] == 1 && $mymps_global['cfg_nonmember_perday_post'] > 0){
				$count = mymps_count("information","WHERE ip = '$ip' AND begintime > '".mktime(0,0,0)."' AND ismember = '0'");
				$count >= $mymps_global[cfg_nonmember_perday_post] && write_msg("很抱歉！游客每天只能发布 <b style='color:red'>".$mymps_global[cfg_nonmember_perday_post]."</b> 条信息<br />如果您要继续操作，请联系客服。");
			}
			empty($manage_pwd) && write_msg("请输入您的管理密码！以便于以后对该信息的修改和删除");
			empty($contact_who) && write_msg("请填写联系人！");
			$manage_pwd = md5($manage_pwd);
			
			if($authcodesettings['post'] == 1 && !$randcode = mymps_chk_randcode($checkcode)){
				write_msg('验证码输入错误，请返回重新输入');
			}
			
			$sql = "INSERT INTO `{$db_mymps}information` (title,content,catid,catname,dir_typename,cityid,areaid,streetid,begintime,activetime,endtime,manage_pwd,ismember,ip,ip2area,info_level,qq,email,tel,contact_who,img_count,mappoint,latitude,longitude)VALUES('$title','$content','$catid','$d[catname]','$d[dir_typename]','$cityid','$areaid','$streetid','$begintime','$activetime','$endtime','$manage_pwd','$ismember','$ip','$ip2area','$info_level','$qq','$email','$tel','$contact_who','$img_count','$mappoint','$lat','$lng')";
		}elseif($ismember == 1){
			$s_uid = $status = '';
			require_once MYMPS_INC."/member.class.php";
			if(!$member_log->chk_in()) write_msg("对不起,您还没有登录！");
			$memberinfo	= $member_log -> get_info();
			$status = $memberinfo['status'];
			if(empty($status)){
				write_msg('您的账号 [<b>'.$s_uid.'</b>] 目前处于<font color=red>待审状态</font>！<br>请进入邮箱查收验证邮件或等待客服人员开通账号！');
				exit;
			}
			chk_member_purview("purview_info");
			$perpost_money_cost = $mymps_global['cfg_member_perpost_consume'] ? $mymps_global['cfg_member_perpost_consume'] : 0 ;
			$userid = trim($s_uid);
			
			/*信息认证情况*/
			if($userid){
				$row = $db ->getRow("SELECT per_certify,com_certify FROM `{$db_mymps}member` WHERE userid = '$userid'");
				if($row['per_certify'] == 1 || $row['com_certify'] == 1){
					$certify = 1;
				}else{
					$certify = 0;
				}
				unset($row);
			}
			
			if($authcodesettings['memberpost'] == 1 && !$randcode = mymps_chk_randcode($checkcode)){
				write_msg('验证码输入错误，请返回重新输入');
			}
			
			$sql = "INSERT INTO `{$db_mymps}information` (title,content,begintime,activetime,endtime,catid,catname,dir_typename,cityid,areaid,streetid,userid,ismember,ip,ip2area,info_level,qq,email,tel,contact_who,img_count,mappoint,certify,latitude,longitude) Values ('$title','$content','$begintime','$activetime','$endtime','$catid','$d[catname]','$d[dir_typename]','$cityid','$areaid','$streetid','$userid','$ismember','$ip','$ip2area','$info_level','$qq','$email','$tel','$contact_who','$img_count','$mappoint','$certify','$lat','$lng')";
			
			/*积分变化*/
			$score_change = get_credit_score();
			$score_changer = $score_change['score']['rank']['information'];
			$score_changer = $score_changer == 0 ? '+0' : $score_changer;
			if($score_changer){
				$db->query("UPDATE `{$db_mymps}member` SET score = score".$score_changer." WHERE userid = '$userid'");
			}
			$score_change = $score_changer = NULL;
			
			/*金币变化*/
			if(!empty($perpost_money_cost)){
				$db->query("UPDATE `{$db_mymps}member` SET money_own = money_own - '$perpost_money_cost' WHERE userid = '$userid'");
			}
		} else {
			exit('Access Denied!');
		}
		
		$db -> query($sql);
		$id = $db -> insert_id();
		
		$k = $v = NULL;
		if(is_array($extra) && $d['modid'] > 1){
			foreach($extra as $k =>$v){
				$v = is_array($v) ? implode(',',$v) : $v;
				$sql1 .= ",`".$k."`";
				$sql2 .= ",'$v'";
			}
			$sql = "(id.$sql1)VALUES('$id','','')";
			$db->query("INSERT INTO `{$db_mymps}information_{$d[modid]}` (`id`{$sql1})VALUES('$id'{$sql2})");
			unset($sql1,$sql2);
		}
		
		if($img_count > 0){
			for($i=0;$i<$img_count;$i++){
				$name_file = "mymps_img_".$i;
				if($_FILES[$name_file]['name']){
					$destination="/information/".date('Ym')."/";
					$mymps_image = start_upload($name_file,$destination,$mymps_global['cfg_upimg_watermark'],$mymps_mymps['cfg_information_limit']['width'],$mymps_mymps['cfg_information_limit']['height']);
					$db -> query("INSERT INTO `{$db_mymps}info_img` (image_id,path,prepath,infoid,uptime) VALUES ('$i','$mymps_image[0]','$mymps_image[1]','$id','$timestamp')");
				}
			}
			$db -> query("UPDATE `{$db_mymps}information` SET img_path = '$mymps_image[1]' WHERE id = '$id'");
		}
		
		write_msg("","?action=ok&id=".$id."&title=".urlencode($title)."&level=".$info_level."&filepath=".$infopath);
		
	} elseif($action == 'edit'){
		
		if(is_array($_FILES)){
			for($i=0;$i<count($_FILES);$i++){
				$name_file = "mymps_img_".$i;
				if($_FILES[$name_file]['name']){
					$destination = "/information/".date('Ym')."/";
					$mymps_image = start_upload($name_file,$destination,$mymps_global['cfg_upimg_watermark'],$mymps_mymps['cfg_information_limit']['width'],$mymps_mymps['cfg_information_limit']['height']);
					if($row = $db -> getRow("SELECT path,prepath FROM `{$db_mymps}info_img` WHERE infoid = '$id' AND image_id = '$i'")){
						@unlink(MYMPS_ROOT.$row['path']);
						@unlink(MYMPS_ROOT.$row['prepath']);
						$db->query("UPDATE `{$db_mymps}info_img` SET image_id = '$i' , path = '$mymps_image[0]' , prepath = '$mymps_image[1]' , uptime = '$timestamp' WHERE image_id = '$i' AND infoid = '$id'");
					} else {
						$db->query("INSERT INTO `{$db_mymps}info_img` (image_id,path,prepath,infoid,uptime) VALUES ('$i','$mymps_image[0]','$mymps_image[1]','$id','$timestamp')");
					}
					$db -> query("UPDATE `{$db_mymps}information` SET img_path = '$mymps_image[1]' WHERE id = '$id'");
				}
			}
		}
		
		if(is_array($delinfoimg)){
			$img_path = $db ->getOne("SELECT img_path FROM `{$db_mymps}information` WHERE id = '$id'");
			foreach($delinfoimg as $key => $val){
				if($val == 'on'){
					$infoimgrow = $db -> getRow("SELECT id,path,prepath FROM `{$db_mymps}info_img` WHERE image_id = '$key' AND infoid = '$id'");
					if($infoimgrow){
						@unlink(MYMPS_ROOT.$infoimgrow['path']);
						@unlink(MYMPS_ROOT.$infoimgrow['prepath']);
						mymps_delete("info_img","WHERE id = '$infoimgrow[id]'");
						if($infoimgrow['prepath'] == $img_path) $db->query("UPDATE `{$db_mymps}information` SET img_path = '' WHERE id = '$id'");
					}
					unset($infoimgrow);
				}
			}
		}

		$sql = $k = $v = NULL;
		if(is_array($extra) && $d['modid'] > 1){
			foreach($extra as $k =>$v){
				$sql .= is_array($v) ? "`".$k ."` = '".implode(',',$v)."',": "`".$k ."` = '$v',";
			}
			$sql = $sql ? substr($sql,0,-1) : NULL;
			if($sql){
				$db->query("UPDATE `{$db_mymps}information_{$d[modid]}` SET {$sql} WHERE id = '$id'");
				unset($sql);
			}
		}
		
		$manage_pwd = empty($manage_pwd) ? "" : "manage_pwd='".md5($manage_pwd)."',";
		$userid 	= empty($userid) ? "" : "userid='$userid',";
		$img_count 	= mymps_count("info_img","WHERE infoid = '$id'");
		$img_path	= $mymps_image[1] ? $mymps_image[1] : '';
		
		$d = $db->getRow("SELECT catname,dir_typename FROM `{$db_mymps}category` WHERE catid = '$catid'");
		$sql 		= "UPDATE `{$db_mymps}information` SET {$manage_pwd} {$userid} title = '$title',content = '$content',catid = '$catid', cityid = '$cityid', areaid = '$areaid', streetid = '$streetid',begintime = '$begintime', activetime = '$activetime', endtime = '$endtime', ismember = '$ismember' , ip = '$ip' , ip2area = '$ip2area' , info_level = '$info_level' , qq = '$qq' , email = '$email' , tel = '$tel' , contact_who = '$contact_who' , img_count = '$img_count' , mappoint = '$mappoint',catname='$d[catname]',dir_typename='$d[dir_typename]' WHERE id = '$id'";
		$db->query($sql);
		$editlimit = mgetcookie('editlimit');
		$editlimit=$editlimit + 1;
		msetcookie('editlimit',$editlimit,3600*24);
		write_msg("操作成功！您已经成功修改该信息！<br />若信息内容无变化请刷新浏览器！",Rewrite('info',array('id'=>$id,'dir_typename'=>$d['dir_typename'],'cityid'=>$cityid)));
	}
} else {
	
	//assign post
	$catid = isset($catid) ? intval($catid) : '';
	$city = get_city_caches($cityid);
	if($action == 'input'){
	
	if($catname && !$catid) $catid = $db ->getOne("SELECT catid FROM `{$db_mymps}category` WHERE catname = '$catname'");
	/*如果为分类选择页*/
	if(!$catid){
		
		$loc 		= get_location('post','','选择分类 - 发布分类信息');
		$page_title = $loc['page_title'];
		globalassign();
		$categories = get_categories_tree(0,'category');
		include mymps_tpl('info_post');
		
	}else{
		
		if(!empty($mymps_global['cfg_allow_post_area']) && !empty($ip2area)){
			$i = 1;
			$allow_post_area = array();
			$allow_post_area = explode('=',$mymps_global['cfg_allow_post_area']);
			$allow_post_areas = explode(',',$allow_post_area[0]);
			foreach($allow_post_areas as $k => $v){
				if(strstr($ip2area,$v)) {
					$i=$i+1;
				}
			}
			if($allow_post_area[1] == '-1' && $i == 1){
				write_msg("系统判断您的IP并非<b style='color:red'>".$allow_post_area[0]."</b>本地IP！<br />如果您要继续操作，请联系客服。");
				exit;
			} elseif($allow_post_area[1] == 0 && $i == 1) {
				$info_level = 0;
			}
			unset($allow_post_area,$ip2area,$address,$ipdata,$allow_post_areas,$i);
		}
		
		if(!empty($mymps_global['cfg_forbidden_post_ip'])){
			foreach(explode(",", $mymps_global['cfg_forbidden_post_ip']) as $ctrlip) {
				if(preg_match("/^(".preg_quote(($ctrlip = trim($ctrlip)), '/').")/", $ip)) {
					$ctrlip = $ctrlip.'%';
					write_msg("您当前的IP <b style='color:red'>".$ip."</b> 已被管理员加入黑名单，不允许发布信息！");
					exit;
				}
			}
		}
		
		$cat = post_cat_info($catid);
		if($cat['parentid'] == 0) {
			$loc 		= get_location('post','','选择分类 - 发布'.$cat[catname].'信息');
			$page_title = $loc['page_title'];
			$categories = get_categories_tree($catid,'category');
			globalassign();
			include mymps_tpl('info_post');
			exit;
		}elseif($db->getOne("SELECT COUNT(catid) FROM `{$db_mymps}category` WHERE parentid = '$catid'")){
			//如果为最底层分类
			$cat_option = $db->getAll("SELECT catid,catname FROM `{$db_mymps}category` WHERE parentid = '$catid' ORDER BY catorder ASC");
		}
		
		require_once MYMPS_DATA."/info_lasttime.php";
		require_once MYMPS_DATA."/info.type.inc.php";
		require_once MYMPS_INC."/member.class.php";
		
		if($log = $member_log->chk_in()) chk_member_purview("purview_info");
		
		if($mymps_global['cfg_post_editor'] == 1){
			$acontent 	= get_editor('content','information','','400px','300px','include/kindeditor');
		} else {
			$acontent = "<textarea name=\"content\" style=\"width:400px;height:300px;\" class=\"input\" require=\"true\" datatype=\"limit\" msg=\"请填写信息内容描述\"></textarea>";
		}
		
		if($log){
			//判断金额是否足够
			$memberinfo			= $member_log -> get_info();
			$his_money 			= $memberinfo['money_own'];
			$status				= $memberinfo['status'];
			if($status < 1) {
				write_msg('您的会员账号尚未通过审核，不能发布信息！');
				exit;
			}
			($his_money - $mymps_global['cfg_member_perpost_consume']) < 0 && write_msg('您的用户余额 <font color=red><b>'.$his_money.'</b></font>过低 不能再发布信息，请联系管理员充值');
			$per = $db->getRow("SELECT b.perday_maxpost FROM `{$db_mymps}member` AS a LEFT JOIN `{$db_mymps}member_level` AS b ON a.levelid = b.id WHERE a.userid = '$s_uid'");
			$perday_maxpost = $per[perday_maxpost];
			if(!empty($perday_maxpost)){
				$count = mymps_count("information","WHERE userid LIKE '$s_uid' AND begintime > '".mktime(0,0,0)."'");
				$count >= $perday_maxpost && write_msg("很抱歉！您当前的会员级别每天只能发布".$perday_maxpost."条信息");
			}
			$onload 				= '';
			/*$cityid 				= $cityid ? $cityid : $memberinfo['cityid'];
			$areaid 				= $memberinfo['areaid'];
			$streetid 				= $memberinfo['streetid'];*/
			$post['mobile'] 		= $memberinfo['mobile'];
			$post['qq'] 			= $memberinfo['qq'];
			$post['email'] 			= $memberinfo['email'];
			$post['userid'] 		= $memberinfo['userid'];
			$post['contact_who']  	= $memberinfo['cname'];
			$post['ismember'] 		= 1;
			$post['manage_pwd'] 	= '';
			$post['imgcode']= $authcodesettings['memberpost'] == 1 ? 1 : '';
			
		}else{
			if(!empty($mymps_global['cfg_nonmember_perday_post'])){
				$count = mymps_count("information","WHERE ip = '$ip' AND begintime > '".mktime(0,0,0)."' AND ismember = '0'");
				$count >= $mymps_global[cfg_nonmember_perday_post] && write_msg("很抱歉！游客每天只能发布".$mymps_global[cfg_nonmember_perday_post]."条信息");
			}
			
			$mymps_global['cfg_if_nonmember_info']=='0' && write_msg("对不起，您还没有登录！请您登录后再发布信息！",$mymps_global['cfg_member_logfile']."?url=".urlencode(getUrl()));
			
			$onload = ($mymps_global['cfg_if_nonmember_info_box'] == 1)?"javascript:setbg('建议您登陆后再进行此次操作',450,70,'box.php?part=memberinfopost&url=".urlencode(urlencode(getUrl()))."')":"";
			$post['manage_pwd'] =  1;
			$post['ismember'] = 0;
			$post['imgcode']= $authcodesettings['post'] == 1 ? 1 : '';
			//write_msg('请您登录后再发布信息！','login.php?url='.urlencode(GetUrl()));
		}
	
		$post['mymps_extra_value'] 	 = return_category_info_options($cat['modid']);
		$post['upload_img'] 		 = $cat['if_upimg'] == 1 ? get_upload_image_view(1,$id) : '';
		$post['GetInfoLastTime']	 = GetInfoLastTime();
		$post['action']		 	  	 ="input";
		$post['submit']		  	 	 = "提交发布";
		$post['ip']				 	 = $ip;
		$post['catid']			  	 = $catid;
		$post['mixcode']			 = md5($cookiepre);
		$post['select_where_option'] = select_where_option('/include/selectwhere.php',$cityid,$areaid,$streetid);
		$loc 						 = get_location('post','','填写内容 - 发布分类信息');
		$page_title 				 = $loc['page_title'];
		
		/*验证回答设置*/
		$whenpost = '';
		$whenpost = $db -> getOne("SELECT value FROM `{$db_mymps}config` WHERE description = 'whenpost' AND type = 'checkanswe'");
		if($whenpost == '1' && $checkanswer = read_static_cache('checkanswer')){
			$checkquestion['id']		= $randid = array_rand($checkanswer,1);
			$checkquestion['question']  = $checkanswer[$randid]['question'];
			$checkquestion['answer']	= $checkanswer[$randid]['answer'];
		}
		
		globalassign();
		include mymps_tpl('info_post_write');
	}
	
	} elseif ($action == 'edit') {
	
		require_once MYMPS_DATA."/info_lasttime.php";
		require_once MYMPS_DATA."/info.type.inc.php";
		require_once MYMPS_INC."/member.class.php";
		
		$editlimit = mgetcookie('editlimit');
		if($editlimit >= 4) write_msg('您今天修改的信息太多了，休息一下吧 ^_^');
		$id 	= intval($id);
		if(!$post = is_member_info($id)) write_msg('操作失败！你所指定的信息不存在或者已被删除！');
		$catid 	= $post['catid'];
		$areaid = $post['areaid'];
		
		$cat = $db->getRow("SELECT a.if_upimg,a.modid,b.catid FROM `{$db_mymps}category` AS a LEFT JOIN `{$db_mymps}category` AS b ON a.parentid = b.catid WHERE a.catid = '$catid'");
		
		if($post['ismember'] == 1){
			if(!$log = $member_log -> chk_in()){
				write_msg('',$mymps_global['SiteUrl'].'/'.$mymps_global['cfg_member_logfile'].'?url='.urlencode($mymps_global['cfg_postfile'].'?action=edit&id='.$id));
			}elseif($log && $s_uid != $post['userid']){
				write_msg('操作失败！该信息不是您发布的！','olmsg');
			}
			$nav_bar 		= '<a href="info.php?id='.$id.'">'.$post['title'].'</a> &raquo; 修改信息';
		}elseif($post[ismember] == 0 &&!empty($manage_pwd)){
			if(mymps_count("information","WHERE id = '$id' AND manage_pwd = '".md5($manage_pwd)."' AND ismember = 0") == 0){
				write_msg("操作失败！您输入的管理密码不正确！");
			}
			$post['manage_pwd']= "<tr><td class=\"tdr\">管理密码：</td><td><input type=\"password\" name=\"manage_pwd\" class=\"text\"/>
		如不修改，请留空</td></tr>";
			$post[ismember] = 0;
			$nav_bar 		= '<a href="info.php?id='.$id.'">'.$post['title'].'</a> &raquo; <a href="../member/info.php?part=edit&id='.$id.'">输入管理密码</a> &raquo; 修改信息';
		}elseif($post[ismember] == 0 && empty($manage_pwd)){
			$action = '修改';
			$title = "输入管理密码 - ".$action."信息 - ".$post[title];
			$nav_bar = '<a href="../information.php?id='.$id.'">'.$post[title].'</a> &raquo; 输入管理密码 &raquo; '.$action.'信息</li>';
			$post['part'] = $part;
			globalassign();
			include mymps_tpl('info_write_pwd');
			exit;
		}
		
		$post['mobile'] = $post['tel'];
		
		if($mymps_global['cfg_post_editor'] == 1){
			$acontent 	= get_editor('content','information',$post[content],'400px','300px','include/kindeditor');
		} else {
			$acontent = "<textarea name=\"content\" style='width:400px;height:300px;'>".de_textarea_post_change($post[content])."</textarea>";
		}
		
		$title 	  = "修改信息内容 - ".$post['title'];
		$post['GetInfoLastTime']	 = GetInfoLastTime($post['activetime']);
		$post['mymps_extra_value'] 	 = return_category_info_options($cat['modid'],$id);
		$post['mymps_extra_value']   = is_array($post['mymps_extra_value']) ? $post['mymps_extra_value'] : array();
		$post['upload_img'] 		 = get_upload_image_edit($cat['if_upimg'],$id,'yes');
		$post['action']				 = "edit";
		$post['submit'] 			 = "保存修改";
		$post['select_where_option'] = select_where_option('/include/selectwhere.php',$post['cityid'],$post['areaid'],$post['streetid']);
		$post['mixcode']			 = md5($cookiepre);
		$cat 					 	 = post_cat_info($catid);
		
		globalassign();
		include mymps_tpl('info_post_write');
	
	} elseif($action == 'ok'){
	
		$ok['id']	   	= intval($id);
		$ok['filepath'] = trim(mhtmlspecialchars($filepath));
		$ok['title']	= trim(mhtmlspecialchars($title));
		$ok['level']	= intval($level);
		$r	= $db ->getRow("SELECT a.cityid,b.dir_typename FROM `{$db_mymps}information` AS a LEFT JOIN `{$db_mymps}category` AS b ON a.catid = b.catid WHERE a.id = '$ok[id]'");
		$city = get_city_caches($r['cityid']);
		$ok['info_uri'] = Rewrite('info',array('id'=>$ok['id'],'cityid'=>$r['cityid'],'dir_typename'=>$r['dir_typename']));
		
		if(!$title || !$id) exit('Access Denied!');
		
		$nav_bar = '信息发布状态提示';
		globalassign();
		include mymps_tpl('info_post_write_ok');
	
	}
	
}

is_object($db) && $db->Close();
$city = $maincity = NULL;
unset($city,$maincity);

function post_cat_info($catid){
	global $db,$db_mymps;
	return $db -> getRow("SELECT a.catid,a.modid,a.if_upimg,a.catname,b.catid as parentid,a.if_mappoint,b.catname as parentname FROM `{$db_mymps}category` AS a LEFT JOIN `{$db_mymps}category` AS b ON a.parentid = b.catid WHERE a.catid = '$catid'");
}
?>