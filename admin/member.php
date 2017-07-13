<?php
@set_time_limit(0);
define('CURSCRIPT','member');

require_once(dirname(__FILE__)."/global.php");
require_once(MYMPS_INC."/db.class.php");
require_once(MYMPS_MEMBER."/include/mymps.menu.inc.php");

$do = $do ? mhtmlspecialchars($do) : 'member';
$tuijian = $tuijian ? mhtmlspecialchars($tuijian) : 'all';
$if_corp = !$if_corp ? 0 : 1; 

if(in_array(PASSPORT_TYPE,array('ucenter','phpwind'))){
	require (PASSPORT_TYPE == 'ucenter' ? MYMPS_ROOT.'/uc_client/client.php' : MYMPS_ROOT.'/pw_client/uc_client.php');
}

switch ($do){

	case 'member':
	
	$part = $part ? $part : 'default';
	
	if($part == 'default'){
		
		$do_action = isset($do_action) ? trim($do_action) : '';
		$url = $url ? $url : 'member.php';
		
		
		if($do_action == 'delall') {
			
			empty($id) && write_msg("请选择指定会员");

			foreach ($id as $k => $v){
				$row = $db->getRow("SELECT id,userid,prelogo,logo FROM `{$db_mymps}member` WHERE id ='$v'");
					//$deluserarr[] = $row['userid'];
				if($row['logo'] != '/images/nophoto.jpg') @unlink(MYMPS_ROOT.$row['logo']);
				if($row['prelogo'] != '/images/nophoto.jpg') @unlink(MYMPS_ROOT.$row['prelogo']);
				
				mymps_delete("member_category","WHERE userid = '$row[userid]'");
				mymps_delete("member_pm","WHERE fromuser = '$row[userid]' OR fromuser = '$row[userid]'");
				
				/*删除附表信息*/
				$query = $db -> query("SELECT a.id,b.modid FROM `{$db_mymps}information` AS a LEFT JOIN `{$db_mymps}category` AS b ON a.catid = b.catid WHERE a.userid = '$row[userid]'");
				while($r = $db -> fetchRow($query)){
					if($r[modid] > 1) mymps_delete("information_".$r[modid],"WHERE id = '$r[id]'");
				}
				
				
				$row['userid'] && mymps_delete("information","WHERE userid = '$row[userid]'");
				$row['userid'] && mymps_delete("member_docu","WHERE userid = '$row[userid]'");
				
				/*删除相册*/
				$query = $db -> query("SELECT path,prepath FROM `{$db_mymps}member_album` WHERE userid = '$row[userid]'");
				if($query){
					while($r = $db -> fetchRow($query)){
						@unlink(MYMPS_ROOT.$r['path']);
						@unlink(MYMPS_ROOT.$r['prepath']);
					}
				}
				
				$row['userid'] && mymps_delete("member_album","WHERE userid = '$row[userid]'");
				$row['userid'] && mymps_delete("member_record_login","WHERE userid = '$row[userid]'");
				$row['userid'] && mymps_delete("member_record_use","WHERE userid = '$row[userid]'");
				$row['userid'] && mymps_delete("member_comment","WHERE userid = '$row[userid]'");
				
				/*删除插件里的信息*/
				$row['userid'] && mymps_delete("goods","WHERE userid = '$row[userid]'");
				$row['userid'] && mymps_delete("coupon","WHERE userid = '$row[userid]'");
				$row['userid'] && mymps_delete("group","WHERE userid = '$row[userid]'");
				
			}
			
			write_msg('成功删除编号为'.mymps_del_all("member",$id).'的会员',$url,"mymps");
			
		} elseif($do_action == 'delinfo'){
			
			empty($id) && write_msg("请选择指定会员");
			
			foreach ($_POST['id'] as $k => $v){
				$row = $db->getRow("SELECT userid FROM `{$db_mymps}member` WHERE id ='$v'");
				$query = $db -> query("SELECT img_path FROM `{$db_mymps}information` WHERE userid = '$row[userid]'");
				if($query){
					while($r = $db -> fetchRow($query)){
						@unlink(MYMPS_ROOT.$r['img_path']);
					}
				}
				$row['userid'] && mymps_delete("information","WHERE userid = '$row[userid]'");
			}
			write_msg('成功删除会员发布的分类信息',$url,"mymps");
			
		} elseif($do_action == 'deldoc'){
			
			empty($id) && write_msg("请选择指定会员");
			
			foreach ($_POST['id'] as $k => $v){
				$row = $db->getRow("SELECT id,userid FROM `{$db_mymps}member` WHERE id ='$v'");
				$row['userid'] && mymps_delete("member_docu","WHERE userid = '$row[userid]'");
			}
			write_msg('成功删除会员发布的空间文档信息',$url,"mymps");
		} elseif($do_action == 'delcomment') {
			
			empty($id) && write_msg("请选择指定会员");
			
			foreach ($_POST['id'] as $k => $v){
				$row = $db->getRow("SELECT id,userid FROM `{$db_mymps}member` WHERE id ='$v'");
				$row['userid'] && mymps_delete("member_comment","WHERE userid = '$row[userid]'");
			}
			write_msg('成功删除会员的网友点评信息',$url,"mymps");
		} elseif($do_action == 'delpm') {
			
			empty($id) && write_msg("请选择指定会员");
			
			foreach ($_POST['id'] as $k => $v){
				$row = $db->getRow("SELECT userid FROM `{$db_mymps}member` WHERE id ='$v'");
				$row['userid'] && mymps_delete("member_pm","WHERE fromuser = '$row[userid]' OR fromuser = '$row[userid]'");
			}
			
			write_msg('成功删除会员的短消息记录',$url,"mymps");
		} elseif($do_action == 'delalbum') {
			
			empty($id) && write_msg("请选择指定会员");
			
			foreach ($_POST['id'] as $k => $v){
				$row = $db->getRow("SELECT userid FROM `{$db_mymps}member` WHERE id ='$v'");
				$query = $db -> query("SELECT path,prepath FROM `{$db_mymps}member_album` WHERE userid = '$row[userid]'");
				if($query){
					while($r = $db -> fetchRow($query)){
						@unlink(MYMPS_ROOT.$r['path']);
						@unlink(MYMPS_ROOT.$r['prepath']);
					}
				}
				$row['userid'] && mymps_delete("member_album","WHERE userid = '$row[userid]'");
			}
			
			write_msg('成功删除会员的空间相册信息',$url,"mymps");
		} elseif($do_action == 'person') {
			
			empty($id) && write_msg("请选择指定会员");
			
			foreach ($_POST['id'] as $k => $v){
				$db -> query("UPDATE `{$db_mymps}member` SET if_corp = '0',tname='' WHERE id = '$v'");	
			}
			write_msg("会员类型已成功调整为个人会员！",$url,'write_record');
			
		} elseif($do_action == 'per_certify') {
			
			empty($id) && write_msg("请选择指定会员");
			
			foreach ($_POST['id'] as $k => $v){
				$db -> query("UPDATE `{$db_mymps}member` SET per_certify = '1' WHERE id = '$v'");	
			}
			write_msg("指定会员已设置通过身份证认证！",$url,'write_record');
			
		} elseif($do_action == 'com_certify') {
			
			empty($id) && write_msg("请选择指定会员");
			
			foreach ($_POST['id'] as $k => $v){
				$db -> query("UPDATE `{$db_mymps}member` SET com_certify = '1' WHERE id = '$v'");	
			}
			write_msg("指定会员已设置通过营业执照认证！",$url,'write_record');
			
		} elseif($do_action == 'corp') {
			
			empty($id) && write_msg("请选择指定会员");
			
			foreach ($_POST['id'] as $k => $v){
				$db -> query("UPDATE `{$db_mymps}member` SET if_corp = '1' WHERE id = '$v'");	
			}
			write_msg("会员类型已成功调整为商家会员！",$url,'write_record');
			
		} elseif($do_action == 'ifindex2'){
			
			empty($id) && write_msg("请选择指定会员");
			
			is_array($id) && $db -> query("UPDATE `{$db_mymps}member` SET ifindex = '2' WHERE ".create_in($id,'id'));
			write_msg("您的处理请求已经提交成功！",$url);
			
		} elseif($do_action == 'ifindex1'){
			
			empty($id) && write_msg("请选择指定会员");
			
			is_array($id) && $db -> query("UPDATE `{$db_mymps}member` SET ifindex = '1' WHERE ".create_in($id,'id'));
			write_msg("您的处理请求已经提交成功！",$url);
			
		} elseif($do_action == 'iflist2'){
			
			empty($id) && write_msg("请选择指定会员");
			
			is_array($id) && $db -> query("UPDATE `{$db_mymps}member` SET iflist = '2' WHERE ".create_in($id,'id'));
			write_msg("您的处理请求已经提交成功！",$url);
			
		} elseif($do_action == 'iflist1'){
			
			empty($id) && write_msg("请选择指定会员");
			
			is_array($id) && $db -> query("UPDATE `{$db_mymps}member` SET iflist = '1' WHERE ".create_in($id,'id'));
			write_msg("您的处理请求已经提交成功！",$url);
			
		} elseif(is_numeric($do_action)) {
			
			$nowval = $db -> getOne("SELECT levelname FROM `{$db_mymps}member_level` WHERE id = '$do_action'");
			
			if(!$nowval){
				write_msg('您所调整至的会员组不存在！');
			}
			
			if(is_array($_POST['id'])){
				foreach ($_POST['id'] as $k => $v){
					$db -> query("UPDATE `{$db_mymps}member` SET levelid = '$do_action' WHERE id = '$v'");	
				}
				write_msg("会员状态已成功调整为".$nowval."!",$url,'write_record');
			} else {
				write_msg('您没有选择需要操作的会员！');
			}
			
		} elseif(empty($do_action)){
			
			chk_admin_purview('purview_网站会员');
			
			$where = "WHERE a.status = '1' ";
			$where .= $admin_cityid && $if_corp == 1 ? " AND a.cityid = '$admin_cityid'" : ( $cityid ? " AND a.cityid = '$cityid'" : "" );
			$where .= $userid != ''  ? " AND a.userid = '$userid'" : "";
			$where .= $ifindex != ''  ? " AND a.ifindex = '$ifindex'" : "";
			$where .= $iflist != ''  ? " AND a.iflist = '$iflist'" : "";
			$where .= $levelid != '' ? " AND a.levelid = '$levelid'" : "";
			$where .= $tname != ''? " AND a.tname LIKE '%".$tname."%'" : "";
			$where .= isset($if_corp) ? " AND a.if_corp = '$if_corp'" : "";
			
			if($tuijian == 'index'){
				$where .= " AND a.ifindex = '2'";
			} elseif($tuijian == 'list'){
				$where .= " AND a.iflist = '2'";
			}
			
			$where .= ($catid != '' && $if_corp == 1) ? "  AND f.catid IN (".get_corp_children($catid).")" : "";
			$where .= !empty($areaid) ? "  AND a.areaid IN (".get_area_children($areaid).")" : "";
			
			$regdatebefore = $regdatebefore ? strtotime($regdatebefore) : 0;
			$where .= $regdatebefore ? " AND a.jointime <= '$regdatebefore'" : "";
			
			$regdateafter = $regdateafter ? strtotime($regdateafter) : 0;
			$where .= $regdateafter ? " AND a.jointime >= '$regdateafter'" : "";
			
			$lastvisitbefore = $lastvisitbefore ? strtotime($lastvisitbefore) : 0;
			$where .= $lastvisitbefore ? " AND a.logintime <= '$lastvisitbefore'" : "";
			
			$lastvisitafter = $lastvisitafter ? strtotime($lastvisitafter) : 0;
			$where .= $lastvisitafter ? " AND a.jointime >= '$lastvisitafter'" : "";
			
			$where .= $regip != '' ? " AND a.joinip LIKE '".str_replace('*', '%', $regip)."'" : "";
			$where .= $lastip != '' ? " AND a.loginip LIKE '".str_replace('*', '%', $lastip)."'" : "";
			
			$moneylower = $moneylower ? intval($moneylower) : 0;
			$where .= $moneylower != '' ? " AND a.money_own <= '$moneylower'" : ""; 
			
			$moneyhigher = $moneyhigher ? intval($moneyhigher) : 0;
			$where .= $moneyhigher != '' ? " AND a.money_own >= '$moneyhigher'" : "";
			
			$sql = ($catid != '' && $if_corp == 1) ? "SELECT a.id,a.openid,a.nickname,a.if_corp,a.money_own,a.userid,a.userpwd,a.joinip,a.logintime,a.credit,a.credits,a.jointime,a.levelid,b.levelname,a.tname,a.levelup_time,a.ifindex,a.iflist FROM `{$db_mymps}member` AS a LEFT JOIN `{$db_mymps}member_category` AS f ON a.userid = f.userid LEFT JOIN `{$db_mymps}member_level` AS b ON a.levelid = b.id $where ORDER BY a.id DESC" : "SELECT a.id,a.openid,a.nickname,a.if_corp,a.money_own,a.userid,a.userpwd,a.joinip,a.logintime,a.credit,a.credits,a.jointime,a.levelid,b.levelname,a.tname,a.levelup_time,a.ifindex,a.iflist FROM {$db_mymps}member AS a LEFT JOIN `{$db_mymps}member_level` AS b ON a.levelid = b.id  $where ORDER BY a.id DESC";
			$param = setParam(array('userid','catid','lastip','regip','tname','levelid','cityid','areaid','if_corp','more_options','moneylower','moneyhigher','regdatebefore','regdateafter','lastvisitbefore','lastvisitafter','ifindex','iflist','tuijian'));
			
			$rows_num = $db->getOne(($catid != '' && $if_corp == 1) ?  "SELECT COUNT(*) FROM `{$db_mymps}member` AS a LEFT JOIN `{$db_mymps}member_category` AS f ON a.userid = f.userid $where" : "SELECT COUNT(*) FROM `{$db_mymps}member` AS a $where");
			$member = page1($sql);
			
			$regdatebefore   =  $regdatebefore ? date('Y-m-d',$regdatebefore) : '';
			$regdateafter   =  $regdateafter ? date('Y-m-d',$regdateafter) : '';
			$lastvisitbefore =  $lastvisitbefore   ? date('Y-m-d',$lastvisitbefore)	 : '';
			$lastvisitafter  =  $lastvisitafter   ? date('Y-m-d',$lastvisitafter)	 : '';
			$moneylower		 = $moneylower == 0   ? '' : $moneylower;
			$moneyhigher	 = $moneyhigher == 0   ? '' : $moneyhigher;
			
			$here = $if_corp == '0' ? '个人会员' : '商家会员';
			include(mymps_tpl("member_default"));
			
		}
		
	}elseif($part == 'add'){
		
		chk_admin_purview("purview_增加会员");
		$action = 'insert';
		$acontent	= get_editor('content','','','100%','300px');
		$here = "新增会员";
		include(mymps_tpl($if_corp == 1 ? 'member_shop' : 'member'));
		
	}elseif($part == 'insert'){
		
		require_once MYMPS_MEMBER.'/include/common.func.php';
		
		if(PASSPORT_TYPE == 'phpwind'){
				//整合pw
			$checkuser = uc_check_username($userid);
			if($checkuser == -2){
				write_msg('用户名重复，请换一个用户名');
			} elseif($checkuser == -1){
				write_msg('用户名不符合规范，请换一个用户名');
			} elseif($checkuser == 1){
				
			} else {
				write_msg('未知错误，请换一个用户名');
			}
			
			if($email){
				$checkemail = uc_check_email($email);
				$checkemail == -3 && write_msg('Email格式不正确，请填写正确的Email');
				$checkemail == -4 && write_msg('该Email地址已重复，请更换一个Email地址');
			}
			
			uc_user_register($userid,md5($userpwd),$email);
			
		}elseif(PASSPORT_TYPE == 'ucenter'){
				//整合uc
			
			if(!empty($activation) && ($activeuser = uc_get_user($activation))) {
				list($uid, $userid) = $activeuser;
			} else {
				
				if(uc_get_user($userid) && !$db->getOne("SELECT userid FROM {$db_mymps}member WHERE userid='$userid'")) {
					write_msg('该用户已存在于ucenter，您可以在前台登录用户管理中心来激活该用户');
				}
				
				$uid = uc_user_register($userid,$userpwd,$email);
				
				if($uid <= 0) {
					
					if($uid == -1) {
						write_msg('用户名不合法');
					} elseif($uid == -2) {
						write_msg( '包含要允许注册的词语');
					} elseif($uid == -3) {
						write_msg( '用户名已经存在');
					} elseif($uid == -4) {
						write_msg( 'Email 格式有误');
					} elseif($uid == -5) {
						write_msg( 'Email 不允许注册');
					} elseif($uid == -6) {
						write_msg( '该 Email 已经被注册');
					} else {
						write_msg( '未定义');
					}
					
				} else {
					
					$userid  = trim($userid);
					$userpwd = $userpwd ? trim(md5($userpwd)) : md5(random());
					$email 	 = trim($email);
					
				}
				
			}
			
		} else {
			
			$rs	= CheckUserID($userid,'用户名');
			
			$rs != 'ok' && write_msg($rs);
			
			strlen($userid) > 20 && write_msg("你的用户名或昵称名称过长，不允许注册！");
			
			(strlen($userid) < 3 || strlen($userpwd) < 5) && write_msg("你的用户名或密码过短(不能少于3个字符)，不允许注册！");
			
			!is_email($email) && write_msg("Email格式不正确！");

			if($db->getOne("SELECT id FROM `{$db_mymps}member` WHERE userid = '$userid' ")){
				write_msg("你指定的用户名 {$userid} 已存在，请使用别的用户名！");
			}
		}
		
		if($userid) {
			
			member_reg($userid,md5($userpwd),$email);
			$reg_corp = intval($reg_corp);
			
			switch ($reg_corp){
				case '0':
				$db->query("UPDATE `{$db_mymps}member` SET cname = '$cname',levelid = '$levelid',money_own='$money_own',if_corp = '0',status='1' WHERE userid = '$userid'");
				break;
				
				case '1':
				if(is_array($catid)){
					$catids  = implode(',',$catid);
				} else {
					write_msg('请选择商家所属类别');
				}
				
				/*信用等级*/
				$score_change = get_credit_score();
				if($score_change){
					foreach($score_change['credit_set']['rank'] AS $level => $credi) {
						if($credit <= $credi) {
							$credits = $level;
							break;
						}else{
							$credits = 16;
						}
					}
					$credits = $credits - 1;
				}

				
				$db->query("UPDATE `{$db_mymps}member` SET levelid='$levelid',tname = '$tname',cname = '$cname',catid = '$catids', cityid = '$cityid',areaid='$areaid',streetid='$streetid',qq='$qq',msn='$msn',email='$email',address='$address',busway='$busway',money_own='$money_own',score='$score',credit='$credit',credits='$credits',tel='$tel',mobile='$mobile',mappoint='$mappoint',introduce='$content',web='$web',if_corp='1',template='$template',status='1' WHERE userid = '$userid'");
				if(is_array($catid)){
					foreach($catid as $kids => $vids){
						$db->query("INSERT `{$db_mymps}member_category` (userid,catid)VALUES('$userid','$vids')");
					}
				}
				break;
			}
			
			write_msg("添加会员 <b>".$userid."</b> 成功","member.php","mymps");
			
		}

		
	}elseif($part == 'edit'){
		
		$sql = "SELECT a.*,b.id as levelid,b.levelname FROM `{$db_mymps}member` AS a LEFT JOIN `{$db_mymps}member_level` AS b ON a.levelid = b.id WHERE a.id = '$id'";
		$edit = $db->getRow($sql);
		$if_corp = $edit['if_corp'];
		$if_corp == 1 && $acontent	= get_editor('content','',$edit['introduce'],'100%','300px');
		$here = "会员资料修改";
		$action = 'update';
		include(mymps_tpl($if_corp == 1 ? "member_shop" : "member"));
		
	}elseif($part == 'update'){
		
		if(PASSPORT_TYPE == 'phpwind'){
				//整合pw
			$pw_user = uc_user_get($userid);
			if(!empty($userpwd)){
				$result = uc_user_edit($pw_user['uid'], $pw_user['username'], '', md5($userpwd), $email);
				
				if ($result == -3) {
					write_msg('未定义错误：EMAIL格式有误！');
				} elseif ($result == -4) {
					write_msg('未定义错误：该EMAIL已经被注册！');
				} elseif ($result == -2) {
					write_msg('未定义错误：受保护的用户，您无权修改！');
				} elseif ($result == -1) {
					write_msg('未定义错误：受保护的用户，您无权修改！');
				}
			}
		}elseif(PASSPORT_TYPE == 'ucenter'){
				//整合uc
			
			$result =  uc_user_edit($userid, $userpwd, $userpwd, $email, 1);
			
			if ($result == -4) {
				write_msg('未定义错误：EMAIL格式有误！');
			} elseif ($result == -5) {
				write_msg('未定义错误：该email不允许注册！');
			} elseif ($result == -6) {
				write_msg('未定义错误：该email已经被注册！');
			} elseif ($result == -8) {
				write_msg('未定义错误：受保护的用户，您无权修改！');
			} elseif ($result == -1) {
				write_msg('未定义错误：旧密码不正确！');
			} elseif ($result == -7) {
				write_msg('未定义错误：电子邮箱不能留空！');
			}
			
		}  else {
			
			$rs = CheckUserID($userid,'用户名');
			if( $rs != 'ok'){
				write_msg($rs);
			}
			
			!is_email($email) && write_msg("电子邮件格式不正确。");
			
			$old=$db->getRow("SELECT id,userid FROM `{$db_mymps}member` WHERE id = '$id'");
			if($db->getOne("SELECT id FROM `{$db_mymps}member` WHERE userid LIKE '$userid' AND userid != '$old[userid]'")){
				write_msg("你指定的用户名 {".$userid."} 已有其他用户使用！");
			}
			
		}
		
		if($reg_corp == '1'){
			if(is_array($catid)){
				mymps_delete("member_category","WHERE userid = '$userid'");
				foreach($catid as $kids => $vids){
					$db->query("INSERT `{$db_mymps}member_category` (userid,catid)VALUES('$userid','$vids')");
				}
				$catid  = implode(',',$catid);
			} else {
				write_msg('请选择所属类别');
			}
		}
		
		$userpwd = !empty($userpwd) ? "userpwd='".md5($userpwd)."'," :"";
		/*信用等级*/
		$score_change = get_credit_score();
		if($score_change){
			foreach($score_change['credit_set']['rank'] AS $level => $credi) {
				if($credit <= $credi) {
					$credits = $level;
					break;
				}else{
					$credits = 16;
				}
			}
			$credits = $credits - 1;
		}
		
		$sql = ($if_corp == '1' && $reg_corp == '1') ? "UPDATE `{$db_mymps}member` SET {$userpwd} userid = '$userid', levelid='$levelid',tname = '$tname',cname = '$cname',catid = '$catid', cityid = '$cityid',areaid = '$areaid',streetid = '$streetid',qq='$qq',msn='$msn',email='$email',address='$address',busway='$busway',money_own='$money_own',tel='$tel',mobile='$mobile',mappoint='$mappoint',introduce='$content',web='$web',per_certify='$per_certify',com_certify='$com_certify',score='$score',credit='$credit',credits='$credits',template='$template' WHERE id = '$id'" : "UPDATE `{$db_mymps}member` SET {$userpwd} userid = '$userid', levelid='$levelid',cname = '$cname',email='$email',money_own='$money_own',per_certify='$per_certify',com_certify='$com_certify',score='$score',credit='$credit',credits='$credits' WHERE id = '$id'";
		
		$res = $db->query($sql);
		$score_change = $credits = $credit = NULL;
		
		if($per_certify == 1 || $com_certify == 1) {
			$db -> query("UPDATE `{$db_mymps}information` SET certify = '1' WHERE userid = '$userid'");
		}
		
		write_msg(($if_corp == '1' ? $tname : $userid)."的用户信息修改成功","member.php?do=member&part=edit&id=".$id,'record');
		
	} elseif($part == 'levelup') {
		$levelup_notice = textarea_post_change($levelup_notice);
		mymps_delete("config","WHERE description = 'levelup_notice'");
		$db -> query("INSERT INTO `{$db_mymps}config` SET value = '$levelup_notice', type = 'levelup', description = 'levelup_notice'");
		write_msg('提示信息提交成功！','member.php?do=group');
	} elseif($part == 'verify'){
		
		chk_admin_purview("purview_审核会员");
			//审核待审会员
		if($do_action == 'del'){
			
			if($do_act == 'allperson'){
					//删除所有待审个人会员
				$db -> query("DELETE FROM `{$db_mymps}member` WHERE if_corp = '0' AND status = '0'");
				$url = 'member.php?part=verify&do_action=default&type=person';
			} elseif($do_act == 'allstore'){
					//删除所有待审商家会员
				$id = $db ->getAll("SELECT id FROM `{$db_mymps}member` WHERE if_corp = '1' AND status = '0'");
				
				foreach ($id as $k => $v){
					$row = $db->getRow("SELECT id,userid,prelogo,logo FROM `{$db_mymps}member` WHERE id ='$v[id]'");
						//$deluserarr[] = $row['userid'];
					if($row['logo'] != '/images/nophoto.jpg') @unlink(MYMPS_ROOT.$row['logo']);
					if($row['prelogo'] != '/images/nophoto.jpg') @unlink(MYMPS_ROOT.$row['prelogo']);
					
					mymps_delete("member_category","WHERE userid = '$row[userid]'");
					mymps_delete("member_pm","WHERE fromuser = '$row[userid]' OR fromuser = '$row[userid]'");
					
					/*删除附表信息*/
					$query = $db -> query("SELECT a.id,b.modid FROM `{$db_mymps}information` AS a LEFT JOIN `{$db_mymps}category` AS b ON a.catid = b.catid WHERE a.userid = '$row[userid]'");
					while($r = $db -> fetchRow($query)){
						if($r[modid] > 1) mymps_delete("information_".$r[modid],"WHERE id = '$r[id]'");
					}
					
					$row['userid'] && mymps_delete("information","WHERE userid = '$row[userid]'");
					$row['userid'] && mymps_delete("member_record_login","WHERE userid = '$row[userid]'");
					$row['userid'] && mymps_delete("member_record_use","WHERE userid = '$row[userid]'");
					$row['userid'] && mymps_delete("member_comment","WHERE userid = '$row[userid]'");
				}
				$db -> query("DELETE FROM `{$db_mymps}member` WHERE if_corp = '1' AND status = '0'");
				$url = 'member.php?part=verify&do_action=default&type=store';
			} elseif($do_act == 'person'){
					//删除指定个人会员
				empty($id) && write_msg('请选择对象!');
				$ids = create_in($id,'id');
				$db -> query("DELETE FROM `{$db_mymps}member` WHERE if_corp = '0' AND status = '0' AND $ids");
				
			} elseif($do_act == 'store'){
					//删除指定商家会员
				empty($id) && write_msg('请选择对象!');
				
				foreach ($id as $k => $v){
					$row = $db->getRow("SELECT id,userid,prelogo,logo FROM `{$db_mymps}member` WHERE id ='$v'");
						//$deluserarr[] = $row['userid'];
					if($row['logo'] != '/images/nophoto.jpg') @unlink(MYMPS_ROOT.$row['logo']);
					if($row['prelogo'] != '/images/nophoto.jpg') @unlink(MYMPS_ROOT.$row['prelogo']);
					
					mymps_delete("member_category","WHERE userid = '$row[userid]'");
					mymps_delete("member_pm","WHERE fromuser = '$row[userid]' OR fromuser = '$row[userid]'");
					
					/*删除附表信息*/
					$query = $db -> query("SELECT a.id,b.modid FROM `{$db_mymps}information` AS a LEFT JOIN `{$db_mymps}category` AS b ON a.catid = b.catid WHERE a.userid = '$row[userid]'");
					while($r = $db -> fetchRow($query)){
						if($r[modid] > 1) mymps_delete("information_".$r[modid],"WHERE id = '$r[id]'");
					}
					
					$row['userid'] && mymps_delete("information","WHERE userid = '$row[userid]'");
					$row['userid'] && mymps_delete("member_record_login","WHERE userid = '$row[userid]'");
					$row['userid'] && mymps_delete("member_record_use","WHERE userid = '$row[userid]'");
					$row['userid'] && mymps_delete("member_comment","WHERE userid = '$row[userid]'");
				}
				$ids = create_in($id,'id');
				$db -> query("DELETE FROM `{$db_mymps}member` WHERE if_corp = '1' AND status = '0' AND $ids");
			}
			write_msg('指定待审会员删除成功！',$url);
			
		} elseif($do_action == 'yes') {
			
			if($do_act == 'allperson'){
					//通过所有待审个人会员
				$db->query("UPDATE `{$db_mymps}member` SET status = '1' WHERE status = '0' AND if_corp = '0'");
				$url = 'member.php?part=verify&do_action=default&type=person';
			} elseif($do_act == 'allstore'){
					//通过所有待审商家会员
				$db->query("UPDATE `{$db_mymps}member` SET status = '1' WHERE status = '0' AND if_corp = '1'");
				$url = 'member.php?part=verify&do_action=default&type=store';
			} elseif($do_act == 'person'){
					//通过指定个人会员
				empty($id) && write_msg('请选择对象!');
				$ids = create_in($id,'id');
				$db->query("UPDATE `{$db_mymps}member` SET status = '1' WHERE status = '0' AND if_corp = '0' AND $ids");
			} elseif($do_act == 'store'){
					//通过指定商家会员
				empty($id) && write_msg('请选择对象!');
				$ids = create_in($id,'id');
				$db->query("UPDATE `{$db_mymps}member` SET status = '1' WHERE status = '0' AND if_corp = '1' AND $ids");
			}
			
			write_msg('指定会员已通过审核！',$url);
			
		} elseif($do_action == 'no') {
			
			if($do_act == 'allstore'){
					//否决所有商家会员
				$db->query("UPDATE `{$db_mymps}member` SET status = '1',if_corp = '0' WHERE status = '0' AND if_corp = '1'");
				$url = 'member.php?part=verify&do_action=default&type=store';
			} elseif($do_act == 'store'){
					//否决指定商家会员
				empty($id) && write_msg('请选择对象!');
				$ids = create_in($id,'id');
				$db->query("UPDATE `{$db_mymps}member` SET status = '1',if_corp = '0' WHERE status = '0' AND if_corp = '1' AND $ids");
			}
			
			write_msg('指定会员已被否决！',$url);
			
		} elseif($do_action == 'default') {
			$where1 ="WHERE if_corp = '0' AND status = '0'";
			$where1 .= $admin_cityid ? " AND cityid = '$admin_cityid'" : "";
			
			$where2 ="WHERE if_corp = '1' AND status = '0'";
			$where2 .= $admin_cityid ? " AND cityid = '$admin_cityid'" : "";
			
			$count['person'] = mymps_count("member",$where1);
			$count['store'] = mymps_count("member",$where2);
			$type = in_array($type,array('person','store')) ? $type : 'person';
			$page = empty($page) ? 1 : intval($page);
			$where = " WHERE status = '0'";
			if($type=='store'){
				$where .= " AND if_corp = '1'";
				$where .= $admin_cityid ? " AND cityid = '$admin_cityid'" : "";
			}
			if($type=='person'){
				$where .= " AND if_corp = '0'";
				$where .= $admin_cityid ? " AND cityid = '$admin_cityid'" : "";
			}
			if($type=='all') $where .="";
			$sql = "SELECT * FROM {$db_mymps}member $where ORDER BY id DESC";
			$param = setParam(array('do','part','type','do_action'));
			$rows_num = mymps_count("member",$where);
			$member = page1($sql);
			$here="待审用户列表";
			include mymps_tpl('member_verify');
		} else{
			write_msg('请选择需要进行的操作！');	
		}
	}
	break;
	
	case 'group':
	$part = $part ? $part : 'list' ;
	if ($part == 'list'){
		
		chk_admin_purview("purview_会员组");
		$sql = "SELECT * FROM {$db_mymps}member_level ORDER BY id desc";
		$group = $db->getAll($sql);
		$here = "注册用户组管理";
		$levelup_notice = $db -> getOne("SELECT value FROM `{$db_mymps}config` WHERE description = 'levelup_notice'");
		$levelup_notice = de_textarea_post_change($levelup_notice);
		include(mymps_tpl("member_group"));	
		
	}elseif($part == 'add'){
		
		chk_admin_purview("purview_会员组");
		$here = "新增用户组";
		include(mymps_tpl("member_group_add"));
		
	}elseif($part == 'insert'){
		$purview  = is_array($purview) ? implode(",", $purview) : '';
		$purview  = $purview ? trim($purview) : '';
		$perday_maxpost = trim($perday_maxpost);
		if(!$settings['ifopen']) write_msg('您至少要选择启用一个升级期限');
		if(!empty($levelname)){
			if($db->getOne("select count(*) from {$db_mymps}member_level where levelname = '$levelname'")){
				write_msg("已经存在此用户组，请重新输入！");
			}
			$settings = serialize($settings);
			$db->query("INSERT INTO `{$db_mymps}member_level` (id,levelname,ifsystem,purviews,money_own,perday_maxpost,signin_notice,signin_del,signin_view,moneysettings) VALUES ('','$levelname','0','$purview','$money_own','$perday_maxpost','$signin_notice','$signin_del','$signin_view','$settings')");
			clear_cache_files('member_'.$db->insert_id());
			write_msg("添加用户组 ".$levelname." 成功","member.php?do=group","MyMPS");
		}else{
			write_msg("用户组名不能为空！");
		}
		
	}elseif($part == 'edit'){
		
		$group = $db->getRow("SELECT * FROM `{$db_mymps}member_level` WHERE id = '$id'");
		$purviews = explode(',',$group['purviews']);
		$group['allow_tpl'] = explode(',',$group['allow_tpl']);
		$settings = $charset == 'utf-8' ? utf8_unserialize($group['moneysettings']) : unserialize($group['moneysettings']);
		$here = "设置用户组权限";
		include(mymps_tpl("member_group_edit"));

	}elseif($part == 'update'){

		$purview = is_array($purview) ? implode(",", $purview) : '';
		$purview = $purview ? trim($purview) : '';
		$allow_tpl = is_array($allow_tpl) ? implode(",", $allow_tpl) : '';
		if(!$settings['ifopen']) write_msg('您至少要选择启用一个升级期限');
		$settings = serialize($settings);
		$db->query("UPDATE `{$db_mymps}member_level` SET levelname='$levelname',purviews='$purview',money_own='$money_own',perday_maxpost='$perday_maxpost',signin_view='$signin_view',signin_del='$signin_del',signin_notice='$signin_notice',member_contact='$member_contact',allow_tpl='$allow_tpl',moneysettings = '$settings' WHERE id = '$id'");
		clear_cache_files('member_'.$id);
		write_msg("用户组 ".$levelname." 权限设置成功","member.php?do=group&part=edit&id=".$id,"mymps");
		
	}elseif($part == 'delete'){
		
		if(empty($id)){
			write_msg("没有选择记录");
		}elseif (mymps_count("member","WHERE levelid = '$id'")>0){
			write_msg("该用户组下尚有成员，不能删除！");
		}else{
			mymps_delete("member_level","WHERE id = '$id'");
			clear_cache_files('member_'.$id);
			write_msg("删除用户组 $id 成功","?do=group","record");
		}
		
	}
	break;
}

is_object($db) && $db->Close();
$mymps_global = $db = $db_mymps = $part = NULL;

function get_member_level_label(){
	global $db,$db_mymps;
	$member_level = $db -> getAll("SELECT id,levelname FROM `{$db_mymps}member_level`");
	foreach($member_level as $k=>$value){
		$mymps .= "<label for=".$value[id]."><input name=do_action value=".$value[id]." type=radio class=radio id=".$value[id]."";
		$mymps .= ($id==$value[id])?" checked":"";
		$mymps .= ">".$value[levelname]."</label>";
	}
	return $mymps;
}

if (!function_exists('get_member_level')){
	function get_member_level($id='',$name='levelid'){
		global $db,$db_mymps;
		$member_level = $db -> getAll("SELECT id,levelname FROM `{$db_mymps}member_level`");
		$mymps .= "<select name=\"".$name."\">";
		$mymps .= "<option value=''>>不限组别</option>";
		foreach($member_level as $k=>$value){
			$mymps .= "<option value=".$value[id]."";
			$mymps .= ($id==$value[id])?" selected style=\"background-color:#6EB00C;color:white\"":"";
			$mymps .= ">".$value[levelname]."</option>";
		}
		$mymps .= "</select>";
		return $mymps;
	}
}
?>