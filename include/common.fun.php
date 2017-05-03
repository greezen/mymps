<?php
if ( !function_exists('htmlspecialchars_decode') )
{
    function htmlspecialchars_decode($text)
    {
        return strtr($text, array_flip(get_html_translation_table(HTML_SPECIALCHARS)));
    }
}

function checkhtml($html) {
	global $charset;
	preg_match_all("/\<([^\<]+)\>/is", $html, $ms);

	$searchs[] = '<';
	$replaces[] = '&lt;';
	$searchs[] = '>';
	$replaces[] = '&gt;';

	if($ms[1]) {
		$allowtags = 'img|a|font|div|table|tbody|caption|tr|td|th|br|p|b|strong|i|u|em|span|ol|ul|li|blockquote|object|param|embed';
		$ms[1] = array_unique($ms[1]);
		foreach ($ms[1] as $value) {
			$searchs[] = "&lt;".$value."&gt;";

			$value = str_replace('&', '_uch_tmp_str_', $value);
			//$value = mhtmlspecialchars($value);
			$value = str_replace('_uch_tmp_str_', '&', $value);

			$value = str_replace(array('\\','/*'), array('.','/.'), $value);
			$skipkeys = array('onabort','onactivate','onafterprint','onafterupdate','onbeforeactivate','onbeforecopy','onbeforecut','onbeforedeactivate',
					'onbeforeeditfocus','onbeforepaste','onbeforeprint','onbeforeunload','onbeforeupdate','onblur','onbounce','oncellchange','onchange',
					'onclick','oncontextmenu','oncontrolselect','oncopy','oncut','ondataavailable','ondatasetchanged','ondatasetcomplete','ondblclick',
					'ondeactivate','ondrag','ondragend','ondragenter','ondragleave','ondragover','ondragstart','ondrop','onerror','onerrorupdate',
					'onfilterchange','onfinish','onfocus','onfocusin','onfocusout','onhelp','onkeydown','onkeypress','onkeyup','onlayoutcomplete',
					'onload','onlosecapture','onmousedown','onmouseenter','onmouseleave','onmousemove','onmouseout','onmouseover','onmouseup','onmousewheel',
					'onmove','onmoveend','onmovestart','onpaste','onpropertychange','onreadystatechange','onreset','onresize','onresizeend','onresizestart',
					'onrowenter','onrowexit','onrowsdelete','onrowsinserted','onscroll','onselect','onselectionchange','onselectstart','onstart','onstop',
					'onsubmit','onunload','javascript','script','eval','behaviour','expression','style','class');
			$skipstr = implode('|', $skipkeys);
			$value = preg_replace(array("/($skipstr)/i"), '.', $value);
			if(!preg_match("/^[\/|\s]?($allowtags)(\s+|$)/is", $value)) {
				$value = '';
			}
			$replaces[] = empty($value)?'':"<".str_replace('&quot;', '"', $value).">";
		}
	}
	$html = trim(str_replace($searchs, $replaces, $html));
 
    return $html;
}

function mhtmlspecialchars($string, $flags = null) {
	global $charset;
    if(is_array($string)) {
        foreach($string as $key => $val) {
            $string[$key] = mhtmlspecialchars($val, $flags);
        }
    } else {
        if($flags === null) {
            $string = str_replace(array('&', '"', '<', '>'), array('&amp;', '&quot;', '&lt;', '&gt;'), $string);
            if(strpos($string, '&amp;#') !== false) {
                $string = preg_replace('/&amp;((#(\d{3,5}|x[a-fA-F0-9]{4}));)/', '&\\1', $string);
            }
        } else {
            if(PHP_VERSION < '5.4.0') {
                $string = htmlspecialchars($string, $flags);
            } else {
                if($charset == 'utf-8') {
                    $charset = 'UTF-8';
                } else {
                    $charset = 'ISO-8859-1';
                }
                $string = htmlspecialchars($string, $flags, $charset);
            }
        }
    }
    return $string;
}

function get_shop_tpl($opt='',$s_uid=''){
	global $db,$db_mymps;
	if($s_uid){
		$member = get_member_group('',$s_uid);
		$option = $member['allow_tpl'];
	}else{
		$option = $db -> getAll("SELECT * FROM `{$db_mymps}member_tpl`");
	}
	foreach ($option as $key => $v){
		$mymps .= '<option value='.$v[tpl_path];
		if(is_array($opt)){
			$mymps .= in_array($v[tpl_path],$opt) ? ' style = "background-color:#6EB00C;color:white" selected>' : '>';
		} else {
			$mymps .= ($opt == $v[tpl_path]) ? ' style = "background-color:#6EB00C;color:white" selected>' : '>';
		}
		
		$mymps .= $v[tpl_name].'</option>';
	}
	return $mymps;
}

function filter_str($msg){
	//$msg = str_replace('&','&amp;',$msg);
	//$msg = str_replace(' ','&nbsp;',$msg);
	$msg = str_replace('"','&quot;',$msg);
	$msg = str_replace("'",'&#39;',$msg);
	$msg = str_replace("<","&lt;",$msg);
	$msg = str_replace(">","&gt;",$msg);
	$msg = str_replace("\t","   &nbsp;  &nbsp;",$msg);
	//$msg = str_replace("\r","",$msg);
	$msg = str_replace("   "," &nbsp; ",$msg);
	return $msg;
}

/*获得空间文档*/
function get_member_docu($num=10,$userid='',$if_check=1,$typeid=0){
	global $db,$db_mymps;
	$where = "WHERE 1";
	$where .= $if_check == 1 ? " AND a.if_check = '1'" : "";
	$where .= $typeid ? " AND a.typeid = '$typeid'" : "";
	$where .= $userid ? " AND a.userid = '$userid'" : "";
	$num = $num ? "LIMIT 0,$num" : "";
	$query = $db -> query("SELECT a.*,b.id AS uid,b.tname FROM `{$db_mymps}member_docu` AS a LEFT JOIN `{$db_mymps}member` AS b ON a.userid = b.userid {$where} ORDER BY a.pubtime DESC {$num}");
	while($row = $db -> fetchRow($query)){
		$arr['id'] = $row['id'];
		$arr['userid'] = $row['userid'];
		$arr['tname'] = $row['tname'];
		$arr['typeid'] = $row['typeid'];
		$arr['title']  = $row['title'];
		$arr['pubtime']= $row['pubtime'];
		$arr['imgpath']= $row['imgpath'];
		$arr['hit']= $row['hit'];
		$arr['pre_imgpath']= $row['pre_imgpath'];
		$arr['tname_uri']  = Rewrite('store',array('uid'=>$row['uid'],'part'=>'index'));
		$arr['uri']   	= Rewrite('store',array('uid'=>$row['uid'],'id'=>$row['id'],'part'=>'document'));
		$docu[] = $arr;
		$arr = NULL;
	}
	return $docu;
}

//设置COOKIE
function msetcookie($var,$val,$life=0){
	global $cookiepre,$cookiedomain,$cookiepath,$timestamp;
	$cookie_pre  = $cookiepre.'_';
	$cookie_path = $cookiepath ? $cookiepath : '/';
	$life = $life ? $life : 3600;
	$life = $timestamp+$life;
	setcookie($cookie_pre.$var,$val,$life,$cookie_path,$cookiedomain);
}

//返回COOKIE
function mgetcookie($var){
	global $cookiepre;
	$cookie_pre  = $cookiepre.'_';
	$tvar = $cookie_pre.$var;
	return $_COOKIE[$tvar];
}

function is_email($email) {
	return strlen($email) > 6 && preg_match("/^[\w\-\.]+@[\w\-\.]+(\.\w+)+$/", $email);
}

/*function html2js($str){
	$str=str_replace('\\','\\\\',$str);
	$str=str_replace("'","\'",$str);
	$str=str_replace('"','\"',$str);
	$str=str_replace('\t','',$str);
	$str= explode("\r\n",$str);       
	for($i=0;$i<count($str);$i++){
		$re.="document.writeln(\"".$str[$i]."\");\r\n";
    }
	return $re;
}*/

function html2js($content){
	$content = str_replace('"', '\"',$content);
	$content = str_replace("\r", "\\r",$content);
	$content = str_replace("\n", "\\n",$content);
	return "<!--\r\ndocument.write(\"".$content."\");\r\n-->\r\n";
}

function textarea_post_change($mymps_string)
{
	return nl2br(str_replace(' ','&nbsp;',mhtmlspecialchars(trim($mymps_string))));
}

function de_textarea_post_change($mymps_string)
{
	return str_replace('<br />',' ',str_replace('&nbsp;',' ',trim($mymps_string)));
}

function random($length=5,$strtolower=1)
{
	$hash = '';
	$chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz';
	$max = strlen($chars) - 1;
	mt_srand((double)microtime() * 1000000);
	for($i = 0; $i < $length; $i++) {
		$hash .= $chars[mt_rand(0, $max)];
	}
	if($strtolower==1){
		$hash=strtolower($hash);
	}
	return $hash;
}

function FileExt($filename) {
	$temp_arr = explode(".", $filename);
	$file_ext = array_pop($temp_arr);
	$file_ext = trim($file_ext);
	$file_ext = strtolower($file_ext);
	return $file_ext;
}

function createfile($file,$str)
{
	if (is_file($file)){
		@unlink ($file);
	}
  	$fp=fopen($file,"w");
	if (!is_writable ($file)){
		return false;
	}
	if (!fwrite($fp,$str)){
		return false;
	}
	fclose ($fp);
	return $file;
}

function createdir($path)
{
	if (!file_exists($path)){
		createdir(dirname($path));
		mkdir($path, 0777);
		return true;
	} elseif(file_exists($path)){
		return true;
	} else {
		return false;
	}
}

function DelDir($dirName) 
{
	if(! is_dir($dirName)){
		return false;
	}
	$handle = @opendir($dirName);     
	while(($file = @readdir($handle)) !== false){         
		if($file != '.' && $file != '..'){
			 $dir = $dirName . '/' . $file;             
			 is_dir($dir) ? DelDir($dir) : @unlink($dir);         
		}     
	}     
	closedir($handle);
	return rmdir($dirName);
}

function die_msg($msg)
{
	return '<p style="font-family: Verdana, Tahoma; font-size: 11px;"><b>Mymps info:</b>'.$msg.'</p>';
}

/* 调用UCenter函数 */
function uc_call($func, $params=NULL)
{
    restore_error_handler();
    if (!function_exists($func)){
        include_once(MYMPS_ROOT.'/uc_client/client.php');
    }
    $res = call_user_func_array($func, $params);
    //set_error_handler('exception_handler');
    return $res;
}

function get_editor($editor_name,$type,$value = '',$width='100%',$height='400px',$BasePath='../include/kindeditor')
{
	$html = '';  
	$html .= '<script charset="utf-8" src="'.$BasePath.'/kindeditor-min.js"></script><script charset="utf-8" src="'.$BasePath.'/lang/zh_CN.js"></script>'; 
	
	switch($type){
		case 'Member':
			$html .= "<script>
			var editor;
			KindEditor.ready(function(K) {
				editor = K.create('textarea[name=\"".$editor_name."\"]', {
						resizeType : 1,
						filterMode : true,
						uploadJson : '".$BasePath."/upload_user.php' // 相对于当前页面的路径
				});
				
			});</script>";
		break;
		
		case 'information':
			$html .= "<script>
			var editor;
			KindEditor.ready(function(K) {
				editor = K.create('textarea[name=\"".$editor_name."\"]', {
						resizeType : 1,
						filterMode : true,
						items : [ 'fontname', 'fontsize', '|' ,'forecolor','hilitecolor', 'bold','italic', 'underline', 'strikethrough', 'removeformat', 'clearhtml' ]
				});
				
			});</script>";
		break;
		
		default:
			$html .= "<script>
			var editor;
			KindEditor.ready(function(K) {
				editor = K.create('textarea[name=\"".$editor_name."\"]', {
						resizeType : 1,
						filterMode : true,
						uploadJson : '".$BasePath."/upload_admin.php' // 相对于当前页面的路径
				});
				
			});</script>";
		break;
		
	}

	$html .= '<textarea require="true" datatype="limit" msg="请填写信息内容描述" msgid="content" name="'.$editor_name.'" style="width:'.$width.';height:'.$height.';visibility:hidden;">'.$value.'</textarea>';  
	
	return $html;  
}

function mymps_chk_randcode($getcode='')
{
	global $timestamp;
	session_start();
	$getcode = trim(strtoupper($getcode));
	$sessioncode = $_SESSION['chkcode']['code'];
	if($timestamp < $_SESSION['chkcode']['time'] && $sessioncode == $getcode){
		return true;
	}else{
		return false;
	}
}

function CheckUserID($uid,$msgtitle='用户名')
{
	for($i=0;isset($uid[$i]);$i++){
		if(ord($ck_uid[$i]) > 0x80){
			if(isset($uid[$i+1]) && ord($uid[$i+1])>0x40){
				$i++;
			}else{
				return $msgtitle.'可能含有乱码，建议你改用英文字母和数字组合！';
			}
		}
	}
	return 'ok';
}

function GetIP()
{
	if(!empty($_SERVER["HTTP_CLIENT_IP"])){
		$cip = $_SERVER["HTTP_CLIENT_IP"];
	}elseif(!empty($_SERVER["HTTP_X_FORWARDED_FOR"])){
		$cip = $_SERVER["HTTP_X_FORWARDED_FOR"];
	}elseif(!empty($_SERVER["REMOTE_ADDR"])){
		$cip = $_SERVER["REMOTE_ADDR"];
	}else{
		$cip = '';
	}
	preg_match("/[\d\.]{7,15}/", $cip, $cips);
	$cip = isset($cips[0]) ? $cips[0] : 'unknown';
	unset($cips);
	return $cip;
}

function utf8_unserialize ($serial_str) { 
	$out = preg_replace('!s:(\d+):"(.*?)";!se', "'s:'.strlen('$2').':\"$2\";'", $serial_str ); 
	return unserialize ($out); 
}

function write_admin_record($msg)
{
	global $admin_id,$db_mymps,$db,$timestamp;
	$db->query("INSERT INTO `{$db_mymps}admin_record_action` (id,adminid,ip,pubdate,action) VALUES ('','$admin_id','".GetIP()."','$timestamp','$msg')");
}

function write_msg($msg="",$url="javascript:history.go(-1);",$action="")
{
	global $charset,$db,$db_mymps,$mymps_global,$mymps_starttime;
	!empty($action) && write_admin_record($msg);
	if(defined('IN_AJAX')){
		echo "<script language=javascript>alert('".$msg."');";
		echo $url == 'olmsg' ? "</script>" : "window.location.href='".$url."';</script>";
	} else {
		$hidden = $url == 'olmsg' ? 1 : '';
		if (!empty($msg)&&!empty($url)){
			if($url=="javascript:history.go(-1);"){
				$time_echo = "setTimeout('JumpUrl()',20000);";
				$goto = "<a href='".$url."'>如果你的浏览器没反应，请点击这里...</a>";
			}elseif($url == "olmsg"){
				$time_echo = $goto = "";
			}else{
				$time_echo = "setTimeout('JumpUrl()',1500);";
				$goto = "<a href='".$url."'>如果你的浏览器没反应，请点击这里...</a>";
			}
			include MYMPS_ROOT."/template/global/mymps_message.html";
		}elseif(empty($msg)&&!empty($url)){
			Header("HTTP/1.1 303 See Other");
			Header("Location: $url");
		}
	}
	//is_object($db) && $db->Close();
	if(!defined('NO_EXIT')) {
		$mymps_global = $db = $db_mymps = $charset = $timestamp = NULL;
		exit;
	}
}

function show_msg($msgs,$ms="")
{
	global $charset,$db,$db_mymps;
	if(!empty($ms)&&$ms=='record'){
		while (list($k,$v)=each($msgs)){$str .=	"<br>".$v."<br>";};
		write_admin_record(SpHtml2Text($str));
	}elseif(!empty($ms)&&$ms!='record'){
		write_admin_record($ms);
	}
	$title = $mymps_global[SiteName].'提示信息!';
	include(MYMPS_ROOT."/template/global/mymps_msg.html");
	while (list($k,$v)=each($msgs)){$str .=	"<br>".$v."<br>";};
	echo $str."</div></div></div></center></body></html>";
}

function mymps_goto($url='')
{
    return "<script>window.document.location.href='$url';</script>";
}

function is_member_info($id,$type='public')
{
	global $db,$db_mymps;
	if(empty($id)){
		write_msg("操作失败！您没有选择对象！");
	}
	$type = ($type == 'public')?'AND a.info_level != 0':'';
	$post = $db->getRow("SELECT a.*,b.modid FROM `{$db_mymps}information` AS a LEFT JOIN `{$db_mymps}category` AS b ON a.catid = b.catid WHERE a.id = '$id' $type");
	return $post;
}

function setParam($param1,$rewrite='active',$pre='',$htmlpath='')
{
	if($rewrite == 'rewrite'){
		$param = $pre;
		foreach($param1 as $key){
			global ${$key};
			$param .= ${$key} ? urlencode($key).'-'.${$key}.'-' : '';
		}
	} elseif($rewrite == 'active'){
		if(defined('IN_ADMIN')){
			foreach($param1 as $key){
				global ${$key};
				$param .= urlencode($key).'='.${$key}.'&';
			}
		} else {
			foreach($param1 as $key){
				global ${$key};
				$param .= ${$key} ? urlencode($key).'='.${$key}.'&' : '';
			}
		}
	}elseif($rewrite == 'rewrite_py'){
		$param = '';
		foreach($param1 as $key){
			global ${$key};
			$param .= ${$key}!= NULL ? urlencode($key).'-'.${$key}.'-' : '';
		}
	}
	return $param;
}

function get_page_idin($column='id',$sql='',$cfg_page=''){
	global $page,$per_page,$per_screen,$pages_num,$rows_num,$mymps_global,$db,$db_mymps;
	$page = (empty($page) || $page <0 ||!is_numeric($page))?1:$page;
	$per_page = $cfg_page ? $cfg_page : ($per_page ? $per_page : $mymps_global['cfg_page_line']);
	$per_screen = !isset($per_screen)?10:$per_screen;
	$pages_num = ceil($rows_num/$per_page);

	$query = $db -> query($sql." limit ".(($page-1)*$per_page).", ".$per_page);
	while($row = $db -> fetchRow($query)){
		$idin .= $row[$column].',';
	}
	$idin = $idin ? substr($idin,0,-1) : NULL;
	return $idin;
}

function page1($sqlstr='',$per_page='')
{
	global $page,$per_screen,$pages_num,$rows_num,$mymps_global,$db,$db_mymps;
	$page = (empty($page) || $page <0 ||!is_numeric($page))?1:$page;
	$per_page = $per_page ? $per_page : $mymps_global['cfg_page_line'];
	$per_screen = !isset($per_screen)?10:$per_screen;
	$pages_num = ceil($rows_num/$per_page);
	return $db -> getAll($sqlstr." limit ".(($page-1)*$per_page).", ".$per_page);
}

function page2($rewrite='active',$ext='.html')
{
	global $rows_num,$page,$pages_num,$per_page,$param,$per_screen,$dir_typename,$city;
	$font_size="10pt";
	$mid = ceil(($per_screen+1)/2);
	$nav = '';
	if($page <= $mid ){
		$begin = 1;
	}elseif($page > $pages_num-$mid) {
		$begin = $pages_num-$per_screen+1;
	}else{
		$begin = $page-$mid+1;
	}
	$begin = ($begin < 0)?1:$begin;
	if($rewrite == 'active'){
		$nav .="<span class=anum>共".$rows_num."记录</span> ";
		if($page>1)$nav .= "<a href='?$param"."page=".($page-1)."' title='第".($page-1)."页'><上一页</a>";
		if($begin!=1)$nav .= "<a href='?$param' title='第1页'>1 ...</a>";
		$end = ($begin+$per_screen>$pages_num)?$pages_num+1:$begin+$per_screen;
		for($i=$begin; $i<$end; $i++) {
			if (!empty($i)){
				$nav .=($page!=$i)?"<a href='?$param"."page=$i' title='第{$i}页'>$i</a> ":" <span class=current>$i</span> ";
			}
		}
		if($end!=$pages_num+1) $nav .= "<a href='?$param"."page=$pages_num' title='第{$pages_num}页'>... {$pages_num}</a>";
		if($page<$pages_num)   $nav .= "<a href='?$param"."page=".($page+1)."' title='第".($page+1)."页'>下一页></a>";
	} elseif($rewrite == 'rewrite') {
		$nav .="<span class=anum>共".$rows_num."记录</span> ";
		if($page>1)$nav .= "<a href='$param"."page-".($page-1).".html' title='第".($page-1)."页'><上一页</a>";
		if($begin!=1)$nav .= "<a href='$param"."page-1.html' title='第1页'>1 ...</a>";
		$end = ($begin+$per_screen>$pages_num)?$pages_num+1:$begin+$per_screen;
		for($i=$begin; $i<$end; $i++) {
			if (!empty($i)){
				$nav .=($page!=$i)?"<a href='$param"."page-$i.html' title='第{$i}页'>$i</a> ":" <span class=current>$i</span> ";
			}
		}
		if($end!=$pages_num+1) $nav .= "<a href='$param"."page-$pages_num.html' title='第{$pages_num}页'>... {$pages_num}</a>";
		if($page<$pages_num)   $nav .= "<a href='$param"."page-".($page+1).".html' title='第".($page+1)."页'>下一页></a>";
	}elseif($rewrite == 'rewrite_py') {
		$param = $city['domain'].$dir_typename.'-'.$param;
		$nav .="<span class=anum>共".$rows_num."记录</span> ";
		if($page>1)$nav .= "<a href='$param"."page-".($page-1)."/' title='第".($page-1)."页'><上一页</a>";
		if($begin!=1)$nav .= "<a href='$param"."page-1/' title='第1页'>1 ...</a>";
		$end = ($begin+$per_screen>$pages_num)?$pages_num+1:$begin+$per_screen;
		for($i=$begin; $i<$end; $i++) {
			if (!empty($i)){
				$nav .=($page!=$i)?"<a href='$param"."page-$i/' title='第{$i}页'>$i</a> ":" <span class=current>$i</span> ";
			}
		}
		if($end!=$pages_num+1) $nav .= "<a href='$param"."page-$pages_num/' title='第{$pages_num}页'>... {$pages_num}</a>";
		if($page<$pages_num)   $nav .= "<a href='$param"."page-".($page+1)."/' title='第".($page+1)."页'>下一页></a>";
	}
	return $nav; 
}

/*************/
/*获取广告缓存*/
/*$page = array('index','category','info')*/
/*************/
function get_advertisement($page = 'index'){
	$data = read_static_cache('adv_'.$page);
	return $data;
}

function GetUrl(){ 
	$url="http://".$_SERVER["HTTP_HOST"]; 
	if(isset($_SERVER["REQUEST_URI"])){ 
		$url.=$_SERVER["REQUEST_URI"]; 
	} else{ 
		$url.=$_SERVER["PHP_SELF"]; 
		if(!empty($_SERVER["QUERY_STRING"])){$url.="?".$_SERVER["QUERY_STRING"];} 
	} 
	return $url; 
}

function GetTime($time='',$c='Y-m-d H:i:s')
{
	return $time ? date($c,$time) : '';
}

function globalassign(){
	global $mymps_global,$docunav,$about,$city;
	
	if(CURSCRIPT == 'store'){
		$docunav = get_member_docunav();
	} else {
		/*站务链接*/
		$about = array();
		$about['aboutus_uri'] = Rewrite('about',array('part'=>'aboutus'));
		$about['news_uri'] = Rewrite('news',array('part'=>'index'));
		$about['faq_uri'] = Rewrite('about',array('part'=>'faq'));
		$about['yp_uri'] = Rewrite('corp',array('part'=>'index'));
		$about['friendlink_uri'] = Rewrite('about',array('part'=>'friendlink'));
		$about['announce_uri'] = Rewrite('about',array('part'=>'announce'));
		$about['sitemap_uri'] = Rewrite('about',array('part'=>'sitemap'));
	}
}

function mymps_tpl($str,$curscript='')
{
	global $mymps_global;
	$mymps_global['SiteStat'] = htmlspecialchars_decode($mymps_global['SiteStat']);
	$mymps_global['SiteStat'] = str_replace('type=\'/javascript\'','type=\'text/javascript\'',$mymps_global['SiteStat']);
	$curscript = $curscript ? $curscript : CURSCRIPT;
	
	if (defined('IN_SMT')){
		if($curscript == 'wap'){
			$tpldir = 'm';
			$templateid = 8;
			$tplfile =  MYMPS_ROOT.'/'.$tpldir.'/template/'.$str.'.html';
			$objfile =  MYMPS_DATA.'/templates/'.$templateid.'_'.$str.'.tpl.php';
		}elseif($curscript == 'search'){
			$tpldir = 'search';
			$templateid = 7;
			$tplfile =  MYMPS_TPL.'/'.$tpldir.'/'.$str.'.html';
			$objfile =  MYMPS_DATA.'/templates/'.$templateid.'_'.$str.'.tpl.php';
		}elseif($curscript == 'store'){
			$GLOBALS['store']['template'] = $GLOBALS['store']['template'] ? $GLOBALS['store']['template'] : 'blue';
			$tpldir = 'spaces/store';
			$templateid = '6_'.$GLOBALS['store']['template'];
			$tplfile =  MYMPS_TPL.'/'.$tpldir.'/'.$GLOBALS['store']['template'].'/'.$str.'.html';
			$objfile =  MYMPS_DATA.'/templates/'.$templateid.'_'.$str.'.tpl.php';
		}elseif($curscript == 'coupon'){
			$tpldir = 'plugin/coupon/template';
			$templateid = '5';
			$tplfile =  MYMPS_ROOT.'/'.$tpldir.'/'.$str.'.html';
			$objfile =  MYMPS_DATA.'/templates/'.$templateid.'_'.$str.'.tpl.php';
		}elseif($curscript == 'group'){
			$tpldir = 'plugin/group/template';
			$templateid = '4';
			$tplfile =  MYMPS_ROOT.'/'.$tpldir.'/'.$str.'.html';
			$objfile =  MYMPS_DATA.'/templates/'.$templateid.'_'.$str.'.tpl.php';
		}elseif($curscript == 'goods'){
			$tpldir = 'plugin/goods/template';
			$templateid = '3';
			$tplfile =  MYMPS_ROOT.'/'.$tpldir.'/'.$str.'.html';
			$objfile =  MYMPS_DATA.'/templates/'.$templateid.'_'.$str.'.tpl.php';
		}elseif($curscript == 'space'){
			$tpldir = 'spaces/person';
			$templateid = 2;
			$tplfile =  MYMPS_TPL.'/'.$tpldir.'/'.$str.'.html';
			$objfile =  MYMPS_DATA.'/templates/'.$templateid.'_'.$str.'.tpl.php';
		}else{
			$tpldir = $tpldir ? $tpldir : TPLDIR;
			$templateid = $templateid ? $templateid : TEMPLATEID;
			$tplfile = MYMPS_TPL.'/'.$tpldir.'/'.$str.'.html';
			$objfile = MYMPS_DATA.'/templates/'.$templateid.'_'.$str.'.tpl.php';
		}
		@chktplrefresh($objfile, $tplfile, filemtime($objfile), $templateid, $tpldir);
		return $objfile;
	}else{
		/*if(defined('IN_ADMIN')) return MYMPS_ROOT.'/adm/template/'.$str.'.tpl.php';
		elseif(defined('IN_MEMBERADMIN')) return MYMPS_ROOT.'/member/template/'.$str.'.tpl.php';
		elseif(defined('WAP')) return MYMPS_ROOT.'/m/template/'.$str.'.tpl.php';
		else */
		return 'template/'.$str.'.tpl.php';
	}
}

function unknown_err_msg()
{
	$msgs="未知错误，可能与你提交的参数有关<br /><br />获取更多帮助请前往<a href=http://zhideyao.cn target=_blank>Mymps官方网站</a>";
	write_msg($msgs,'olmsg');
}
/*text str html*/
function Spcnw_mid($str,$start,$slen){
  $str_len = strlen($str);
  $strs = Array();
  for($i=0;$i<$str_len;$i++){
  	if(ord($str[$i])>0x80){
  		if($str_len>$i+1) $strs[] = $str[$i].$str[$i+1];
  		else $strs[] = '';
  	  $i++;
  	}
  	else{ $strs[] = $str[$i]; }
  }
  $wlen = count($strs);
  if($wlen < $start) return "";
  $restr = "";
  $startdd = $start;
  $enddd = $startdd + $slen;
  for($i=$startdd;$i<$enddd;$i++){
  	if(!isset($strs[$i])) break;
  	$restr .= $strs[$i];
  }
  return $restr;
}
//text to html
function Text2Html($txt){
	$txt = str_replace("  ","　",$txt);
	$txt = str_replace("<","&lt;",$txt);
	$txt = str_replace(">","&gt;",$txt);
	$txt = preg_replace("/[\r\n]{1,}/isU","<br/>\r\n",$txt);
	return $txt;
}
//html to text
function SpHtml2Text($str){
	$str = preg_replace("/<sty(.*)\\/style>|<scr(.*)\\/script>|<!--(.*)-->/isU","",$str);
	$alltext = "";
	$start = 1;
	for($i=0;$i<strlen($str);$i++){
	if($start==0 && $str[$i]==">") $start = 1;
	else if($start==1){
	  if($str[$i]=="<"){ $start = 0; $alltext .= " "; }
	  else if(ord($str[$i])>31) $alltext .= $str[$i];
	}
	}
	$alltext = str_replace("　"," ",$alltext);
	$alltext = preg_replace("/&([^;&]*)(;|&)/","",$alltext);
	$alltext = preg_replace("/[ ]+/s"," ",$alltext);
	return $alltext;
}
//clear the html
function clear_html($str){
	$str = preg_replace("/<style .*?<\/style>/is", "", $str);  
	$str = preg_replace("/<script .*?<\/script>/is", "", $str);  
	$str = preg_replace("/<br \s*\/?\/>/i", "\n", $str);  
	$str = preg_replace("/<\/?p>/i", "\n\n", $str);  
	$str = preg_replace("/<\/?td>/i", "\n", $str);  
	$str = preg_replace("/<\/?div>/i", "\n", $str);  
	$str = preg_replace("/<\/?blockquote>/i", "\n", $str); 
	$str = preg_replace("/<\/?li>/i", "\n", $str);  
	$str = preg_replace("/\&nbsp\;/i", " ", $str);  
	$str = preg_replace("/\&nbsp/i", " ", $str);    
	$str = preg_replace("/\&amp\;/i", "&", $str);  
	$str = preg_replace("/\&amp/i", "&", $str);    
	$str = preg_replace("/\&lt\;/i", "<", $str);  
	$str = preg_replace("/\&lt/i", "<", $str);    
	$str = preg_replace("/\&ldquo\;/i", '"', $str);  
	$str = preg_replace("/\&ldquo/i", '"', $str);      
	$str = preg_replace("/\&lsquo\;/i", "'", $str);      
	$str = preg_replace("/\&lsquo/i", "'", $str);     
	$str = preg_replace("/\&rsquo\;/i", "'", $str);      
	$str = preg_replace("/\&rsquo/i", "'", $str);  
	$str = preg_replace("/\&gt\;/i", ">", $str);   
	$str = preg_replace("/\&gt/i", ">", $str);   
	$str = preg_replace("/\&rdquo\;/i", '"', $str);   
	$str = preg_replace("/\&rdquo/i", '"', $str);
	$str = strip_tags($str);
	$str = html_entity_decode($str, ENT_QUOTES);
	$str = preg_replace("/\&\#.*?\;/i", "", $str);          
	return $str;
}
//count total nums of the table of mymps sql
function mymps_count($table,$where='')
{
	global $db,$db_mymps;
	$count = $db->getOne("SELECT count(*) FROM {$db_mymps}".$table." ".$where);
	if($count){
		return $count;
	}else{
		return 0;
		exit;
	}
}

function mymps_delete($table,$where='')
{
	global $db,$db_mymps;
	$delete = $db->query("DELETE FROM {$db_mymps}".$table." ".$where);
	if($delete){return true;}else{return false;}
}

function mymps_del_all($table,$id,$idor='id')
{
	global $db,$db_mymps;
	$id = !empty($id) ? join(',', $id) : 0;
	$delete = $db->query("DELETE FROM {$db_mymps}".$table." WHERE ".$idor." IN (".$id.")");
	if($delete){return $id;}else{return false;}
}

function substring($str, $start, $length)
{
	$len = $length;
	if($length < 0){
		$str = strrev($str); 
		$len = -$length;
	}
	$len= ($len < strlen($str)) ? $len : strlen($str);
	for ($i= $start; $i < $len; $i ++){
		   if (ord(substr($str, $i, 1)) > 0xa0){
			 $tmpstr .= substr($str, $i, 2);
			 $i++;
		   }else {
			 $tmpstr .= substr($str, $i, 1);
		   }
	}
	if($length < 0) $tmpstr = strrev($tmpstr);
	return $tmpstr;
}

function substring_utf8($str, $start, $lenth)

{

	$len = strlen($str);

	$r = array();

	$n = 0;

	$m = 0;

	for($i = 0; $i < $len; $i++) {

		$x = substr($str, $i, 1);

		$a  = base_convert(ord($x), 10, 2);

		$a = substr('00000000'.$a, -8);

		if ($n < $start){

			if (substr($a, 0, 1) == 0) {

			}elseif (substr($a, 0, 3) == 110) {

				$i += 1;

			}elseif (substr($a, 0, 4) == 1110) {

				$i += 2;

			}

			$n++;

		}else{

			if (substr($a, 0, 1) == 0) {

				$r[ ] = substr($str, $i, 1);

			}elseif (substr($a, 0, 3) == 110) {

				$r[ ] = substr($str, $i, 2);

				$i += 1;

			}elseif (substr($a, 0, 4) == 1110) {

				$r[ ] = substr($str, $i, 3);

				$i += 2;

			}else{

				$r[ ] = '';

			}

			if (++$m >= $lenth){

				break;

			}

		}

	}

	return join($r);

} // End subString_UTF8;

function get_info_life_time($time)
{
	global $timestamp;
	$last_time = round(($time > 0 ? ($time - $timestamp) : 0)/(3600*24));
	if($last_time >= 5){
		$last_time = "还有<font color=green>$last_time</font>天过期";
	}elseif($last_time > 0 && $lastime < 5){
		$last_time = "还有<font color=red>$last_time</font>天过期";
	}elseif($last_time == 0){
		$last_time = '<font color=green>长期有效</font>';
	}else{
		$last_time = '<font color=red>已过期</font>';
	}
	return $last_time;
}

function plugin_url($flag,$params=''){
	global $mymps_global,$city;
	$args = array(
				  'id'=>0,
				  'cate_id'=>0,
				  'areaid'=>0,
				  'page'=>0,
				  'orderby'=>0,
				  'catid'=>0,
				  'tuijian'=>0,
				  'cuxiao'=>0
				  );
	extract(array_merge($args,$params));
	
	$uri = $flag.'.php';
	
	if($cate_id && $areaid){
		$uri = '';
		$uri .= '?cate_id='.$cate_id.'&areaid='.$areaid;
		$uri .= $orderby ? '&orderby='.$orderby : '';
		$uri .= $page ? '&page='.$page : '';
	} elseif($cate_id){
		$uri .= '?cate_id='.$cate_id;
		$uri .= $orderby ? '&orderby='.$orderby : '';
		$uri .= $page ? '&page='.$page : '';
	}elseif($catid){
		$uri .= '?catid='.$catid;
		$uri .= $orderby ? '&orderby='.$orderby : '';
		$uri .= $page ? '&page='.$page : '';
	}elseif($areaid){
		$uri .= '?areaid='.$areaid;
		$uri .= $orderby ? '&orderby='.$orderby : '';
		$uri .= $page ? '&page='.$page : '';
	} elseif($id) {
		$uri .= '?id='.$id;
	} elseif($orderby) {
		$uri = $orderby ? '?orderby='.$orderby : '';
		$uri .= $page ? '&page='.$page : '';
	}

	$uri .= $tuijian == 1 ? '&tuijian=1' : '';
	$uri .= $cuxiao == 1 ? '&cuxiao=1' : '';
	
	unset($flag,$orderby,$page,$cate_id,$areaid,$id,$params);
	return $uri;
}

/*
 *url rules rewrite functions
 */
function Rewrite($types, $params){
	global $seo,$mymps_global;
    $args = array(
				'id' => 0,
				'catid' => 0,
				'cityid' => 0,
				'areaid' => 0,
				'page' => 0 ,
				'part' => 0 ,
				'user' => 0 ,
				'typeid' => 0 ,
				'action' => 0,
				'type'=>0,
				'uid'=>0,
				'domain'=>0,
				'directory'=>0
			);
    extract(array_merge($args, $params));
	if(!$seo) $seo = get_seoset();//获得SEO配置信息
	$uri = '';
    //$uri .= $mymps_global['SiteUrl'];
	
    switch($types){
		//栏目
		case 'category':
			if($cityid) $city = get_city_caches($cityid);
			$uri = $city['domain'] ? $city['domain'] : '';
		
			if($seo['seo_force_category'] == 'rewrite_py'){
				$rewrite = 3;//拼音伪静态
			} elseif($seo['seo_force_category'] == 'rewrite'){
				$rewrite = 1;
			} else {
				$rewrite = 0;
			}
			if($catid && $rewrite == 1){
				$uri .= 'category-catid-' . $catid;
				$uri .= $areaid?'-areaid-'.$areaid:'';
				$uri .= $page? '-page-'.$page : '';
			}elseif($catid && $rewrite == 3){
				$uri .= $dir_typename;
				$uri .= $areaid?'-areaid-'.$areaid:'';
				$uri .= $page? '-page-'.$page : '';
			}elseif($catid && empty($rewrite)){
				$uri .= 'category.php?catid=' . $catid;
				if($areaid)$uri .= '&amp;areaid=' . $areaid;
				if($page)$uri .= '&amp;page=' . $page;
			}
			
		break;
		
		//信息
        case 'info':
			
			if($cityid){
				$city = get_city_caches($cityid);
			}
			if($seo['seo_force_info'] == 'rewrite_py'){
				$rewrite = 3;//拼音伪静态
			} elseif($seo['seo_force_info'] == 'rewrite'){
				$rewrite = 1;
			} else {
				$rewrite = 0;
			}
			
			if($city['domain']){
				$uri = $city['domain'];
			} elseif($domain) {
				$uri = $domain;
			} elseif($directory) {
				$uri = $mymps_global['cfg_citiesdir'].'/'.$directory.'/';
			} else {
				$uri = $mymps_global['SiteUrl'].'/';
			}
			
			if($rewrite == 1){
				$uri .= 'information-id-'.$id;
			}elseif($rewrite == 3){
				if(empty($dir_typename)){
					$cat_dir = $cat_dir ? $cat_dir : get_category_dir();
					$dir_typename = $cat_dir[$catid];
				}
				$uri .= $dir_typename.'/'.$id.'.html';
			}elseif(empty($rewrite)){
				$uri .= 'information.php?id='.$id;
			}
			
        break;
		//站务
        case 'about':
			if(in_array($part,array('faq','aboutus'))){
				$uri = $mymps_global['SiteUrl'].'/';
			} elseif($mymps_global['cfg_independency']){
				if($part == 'announce' && strstr($mymps_global['cfg_independency'],'announce')) {
					$uri = $mymps_global['SiteUrl'].'/';
				}
				if($part == 'friendlink' && strstr($mymps_global['cfg_independency'],'flink')) {
					$uri = $mymps_global['SiteUrl'].'/';
				}
			} else{
				$uri = $city['domain'];
			}
			
			$rewrite = $seo['seo_force_about'] == 'rewrite' ? 1 : 0;
		
			if(empty($part)){
				return false;
			}elseif($id&&empty($page)){
				if($part == 'announce'){
					$uri .= $rewrite ? ''.$part.'.html#'.$id : 'about.php?part='.$part.'#' . $id;
				} else {
					$uri .= $rewrite ? ''.$part.'-id-'.$id : 'about.php?part='.$part.'&amp;id=' . $id;
				}
			}elseif($page&&empty($id)){
				$uri .= $rewrite ? ''.$part.'-page-'.$page : 'about.php?part='.$part.'&amp;page=' . $page;
			}elseif(empty($id)&&empty($page)&&empty($action)){
				$uri .= $rewrite ? ''.$part : 'about.php?part='.$part;
			}elseif(empty($id)&&empty($page)&&$action){
				$uri .= $rewrite ? ''.$part.'-action-'.$action : 'about.php?part='.$part.'&amp;action='.$action;
			}
			
		
        break;
		//黄页
		case 'corp':
			$rewrite = $seo['seo_force_yp'] == 'rewrite' ? 1 : 0;
			if ($action == 'index' && empty($catid) && empty($areaid)){
				$uri .= $rewrite ? 'corporation' : 'corporation.php';
			}elseif(empty($action) && $rewrite){
				$uri .= 'corporation' . ($catid ? '-catid-'.$catid : '');
				$uri .= $areaid ? '-areaid-'.$areaid : '';
				$uri .= $page ? '-page-'.$page : '';
			}elseif(empty($action) && empty($rewrite)){
				$uri .= 'corporation.php?catid=' . $catid;
				if($page)$uri .= '&amp;page=' . $page;
				if($areaid)$uri .= '&amp;areaid=' . $areaid;
			}
		break;
		//新闻
		case 'news':
			$rewrite = $seo['seo_force_news'] == 'rewrite' ? 1 : 0;
			$uri = $mymps_global['SiteUrl'].'/';
			if ($action == 'index' && empty($catid) && empty($id)){
				$uri .= $rewrite ? 'news' : 'news.php';
			}elseif($id && empty($catid) && empty($action)){
				$uri .= $rewrite ? 'news-id-'.$id : 'news.php?id='.$id;
			}elseif($catid && $rewrite && empty($id) && empty($action)){
				$uri .= 'news-catid-' . $catid;
				$uri .= $page ? '-page-'.$page : '';
			}elseif($catid && empty($rewrite) && empty($id) && empty($action)){
				$uri .= 'news.php?catid=' . $catid;
				if($page)$uri .= '&amp;page=' . $page;
			}
		
		break;
		//空间
		case 'space':
			$uri = $mymps_global['SiteUrl'].'/';
			$rewrite = ($seo['seo_force_space'] == 'rewrite' && inchinese($user)) ? 1 : 0;
            if(empty($user)){
                return false;
            } else{
                $uri .= $rewrite ? 'space/' . $user .'/' : 'space.php?user='.urlencode($user);
            }
        break;
		//店铺
		case 'store':
			$uri = $mymps_global['SiteUrl'].'/';
			$rewrite = $seo['seo_force_store'] == 'rewrite' ? 1 : 0;

			if(!$part) $part = 'index';
            if(empty($uid)){
                return false;
            } elseif($uid && $part == 'index') {
                $uri .= $rewrite ? 'store-' . $uid .'/' : 'store.php?uid='.$uid;
            } elseif($uid && $part && $rewrite) {
				$uri .= 'store-' . $uid . '/' . $part;
				$uri .= $type ? '-type-'.$type : '';
				$uri .= $typeid ? '-typeid-'.$typeid :'';
				$uri .= $id ? '-id-'.$id :'';
				$uri .= $page ? '-page-'.$page :'';
			} elseif($uid && $part && !$rewrite) {
				$uri .=  'store.php?uid='.$uid.'&amp;part='.$part;
				$uri .= $type ? '&amp;type='.$type :'';
				$uri .= $typeid ? '&amp;typeid='.$typeid :'';
				$uri .= $id ? '&amp;id='.$id :'';
				$uri .= $page ? '&amp;page='.$page :'';
			}
        break;
        default:
            return false;
        break;
    }
    if($rewrite == 3 && $types =='category'){
		$uri .= '/';
	}else{
    	if(in_array($rewrite,array(1,2)))$uri .= ((empty($part) || $part == 'index') && in_array($types,array('space','store'))) ? '/' : $part === 'announce' && !empty($id) ? '':'.html';
	}
	unset($seo,$rewrite);
    return $uri;
}

function inchinese($text){
	return @ereg("^[a-z0-9_.-]+$",$text);
}

function get_member_docutype(){
	$data = read_static_cache('document_type');
	if($data === false){
		$query = $GLOBALS['db'] -> query("SELECT * FROM `{$GLOBALS['db_mymps']}member_docutype` WHERE ifview = 2 ORDER BY displayorder,typeid DESC");
		while($row = $GLOBALS['db'] -> fetchRow($query)){
			$res[$row['typeid']]['typeid'] = $row['typeid'];
			$res[$row['typeid']]['typename'] = $row['typename'];
			$res[$row['typeid']]['arrid'] = $row['arrid'];
		}
		write_static_cache('document_type',$res);
	} else {
		$res = $data;
	}
	return $res;
}

/*百宝箱*/
function mymps_get_lifebox($num='12',$cityid=NULL){
	global $db,$db_mymps;
	$city_limit = $cityid ? " AND cityid = '$cityid'" : " AND cityid = '0'";
	$query = $db -> query("SELECT * FROM `{$db_mymps}lifebox` WHERE if_view = 2 {$city_limit} ORDER BY displayorder DESC LIMIT 0,$num");
	while($row = $db -> fetchRow($query)){
		$list[$row['id']]['id'] = $row['id'];
		$list[$row['id']]['lifename'] = $row['lifename'];
		$list[$row['id']]['lifeurl'] = $row['lifeurl'];
	}
	return $list;
}

/*网站公告*/
function mymps_get_announce($num='12',$cityid=NULL){
	global $db,$db_mymps,$timestamp;
	$city_limit = $cityid ? " AND cityid = '$cityid'" : " AND cityid = '0'";
	$query = $db -> query("SELECT * FROM `{$db_mymps}announce` WHERE begintime<'$timestamp' AND (endtime='0' OR endtime>'$timestamp') {$city_limit} ORDER BY id DESC LIMIT 0,$num");
	while($row = $db -> fetchRow($query)){
		$list[$row['id']]['title'] 		= $row['title'];
		$list[$row['id']]['begintime']	= $row['begintime'];
		$list[$row['id']]['endtime']	= $row['endtime'];
		$list[$row['id']]['titlecolor']	= $row['titlecolor'];
		$list[$row['id']]['author']		= $row['author'];
		$list[$row['id']]['content']	= $row['content'];
		$list[$row['id']]['uri'] 		= $row['redirecturl'] ? $row['redirecturl'] : Rewrite('about',array('part'=>'announce','id'=>$row['id'],'html_path'=>'/announce/index'.$seo['seo_htmlext'].'#'.$row['id']));
	}
	return $list;
}

/*便民电话*/
function mymps_get_telephone($num='20',$cityid=NULL){
	global $db,$db_mymps;
	
	$city_limit = $cityid ? " AND cityid = '$cityid'" : " AND cityid = '0'";
	
	$query = $db -> query("SELECT * FROM `{$db_mymps}telephone` WHERE if_view = 2 {$city_limit} ORDER BY displayorder DESC LIMIT 0,$num");
	while($row = $db -> fetchRow($query)){
		$list[$row['id']]['telname'] = $row['telname'];
		$list[$row['id']]['telnumber'] = $row['telnumber'];
		$list[$row['id']]['if_bold'] = $row['if_bold'];
		$list[$row['id']]['color'] = $row['color'];
	}	
	return $list;
}	

function get_member_docunav(){
	$data = get_member_docutype();
	foreach($data as $key => $value){
		$docu[$value['typeid']]['typename'] = $value['typename'];
		$docu[$value['typeid']]['typeid'] = $value['typeid'];
		$docu[$value['typeid']]['uri'] = Rewrite('store',array('uid'=>$GLOBALS['uid'],'part'=>'document','typeid'=>$value['typeid']));
	}
	return $docu;
}

function get_seoset(){
	$data = read_static_cache('seoset');
	if($data === false){
		$query = $GLOBALS['db']->query("SELECT description,value FROM `{$GLOBALS['db_mymps']}config` WHERE type = 'seo'");
		while($row = $GLOBALS['db']->fetchRow($query)){
			$res[$row['description']] = $row['value'];
		}
		write_static_cache('seoset',$res);
	}else{
		$res = $data;
	}
	return $res;
}

/*************************/
/* 取得当前位置和页面标题*/
/*************************/
function get_location($type = 'category',$cat = 0, $str = '', $extra='',$pdetail='')
{
	global $seo,$pluginsettings,$mymps_global,$city,$areaid,$streetid;
	$raquo = $mymps_global['cfg_raquo'];
	/* 处理前面部分 */
	if(!$seo) $seo	= get_seoset();
	$seo['seo_sitename'] = str_replace('{city}',$city['cityname'],$seo['seo_sitename']);
	if(in_array($type,array('channel','news'))){
		$location   = '当前位置：<a href="'.$mymps_global[SiteUrl].'">'.$mymps_global['SiteName'].'</a>';
	}else{
		$location   = '当前位置：<a href="'.$city[domain].'">'.$city['cityname'].$mymps_global['SiteName'].'</a>';
	}
	
	if($type == 'news'){
		$page_title = $pluginsettings['news']['seotitle'] ? $pluginsettings['news']['seotitle'] : $city['cityname'].$GLOBALS['mymps_global']['SiteName'];
		$page_title = str_replace('{city}',$city['cityname'],$page_title);
	} else {
		$page_title = $city['cityname'].$mymps_global['SiteName'];
	}
	
	if($seo['seo_sitename'] && $type == 'index' && empty($cat) && empty($str)) $page_title = $page_title.' - '.$seo['seo_sitename'];
	
	if(in_array($type,array('category','channel','corp','news'))){
		
		if ($cat > 0){
			$cat_arr = get_parent_cats($type,$cat);
		}else{
			$cat_arr = array();
		}
		
		if($type == 'channel'){
			$location .= ' <code>'.$raquo.'</code> <a href="'.Rewrite('news',array('action'=>'index')).'">'.$city[cityname].'网站新闻</a>';
			$page_title = $city['cityname'].'网站新闻 - '.$page_title;
		} elseif($type == 'corp') {
			$location .= ' <code>'.$raquo.'</code> <a href="'.Rewrite('corp',array('action'=>'index')).'">'.$city[cityname].'商家店铺</a>';
			$page_title = $city[cityname].'商家店铺 - '.$page_title;
		}
		
		/* 循环分类 */
		if (!empty($cat_arr)){
			krsort($cat_arr);
			foreach ($cat_arr as $val){
				$val_uri = $val['uri'];
				$page_title =  $city['cityname'].(mhtmlspecialchars($GLOBALS['cat']['title'] && $GLOBALS['catid'] == $val['catid']) ? $GLOBALS['cat']['title'] :($type == 'corp' ? $val['corpname'] : $val['catname'])) . ' - ' . $page_title;
				$location   .= ' <code> '.$raquo.' </code> <a href="' .$city['domain']. $val_uri . '">' .$city['cityname'].
								mhtmlspecialchars($type == 'corp' ? $val['corpname'] : $val['catname']) . '</a>';
			}
		}
		$page_title = $extra ? $extra.$page_title : $page_title;
		$page_title = $city['area'][$areaid]['areaname'].$city['area'][$areaid]['street'][$streetid]['streetname'].$page_title;
	}
	
	if(in_array($type,array('channel','news'))) $location = str_replace($city['domain'],'',$location);
	
    /* 处理最后一部分 */
    if (!empty($str)){
        $page_title = $str.($type == 'space' ? '的个人空间' : '').' - '.$page_title;
        $location   .= ' <code>'.$raquo.'</code> &nbsp;' .$str.($type == 'space' ? '的个人空间' : '');
    }
	
	$page_title = $pdetail ? $pdetail : $page_title;
	
	$cur = array('page_title'=>$page_title,'location'=>$location);

	unset($page_title,$cat,$location,$type);
    /* 返回值 */
    return $cur;
}

function get_areaname($areaid){
	global $db,$db_mymps;
	$data = read_static_cache('area_option_static');
	return $data[$areaid]['areaname'] ? $data[$areaid]['areaname'] : $db -> getOne("SELECT areaname FROM `{$db_mymps}area` WHERE areaid = '$areaid'");
}

//get the images upload box when write the information or edit the information
function get_upload_image_view($if_upimg = 1 , $infoid = '')
{
	global $mymps_global,$db,$db_mymps;
	if($if_upimg == 1){
		$cfg_upimg_number = $mymps_global[cfg_upimg_number]?$mymps_global[cfg_upimg_number]:'3';
		for($i=0;$i<$cfg_upimg_number;$i++){
			$mymps .= $i==0 ? '' : '<br />';
			$mymps .= '<input class="input" type="file" name=mymps_img_'.$i.' datatype="filter" msg="图片文件格式不正确">';
			$mymps .= '<br />';
		}
	}
	return $mymps;
}
//edit the info images
function get_upload_image_edit($if_upimg = 1,$infoid,$admin='no'){
	global $mymps_global,$db,$db_mymps;
	if($if_upimg == 1){
		$cfg_upimg_number = $mymps_global[cfg_upimg_number]?$mymps_global[cfg_upimg_number]:'4';
		if($admin == 'no'){
			$mymps .='<tr><td class=tdr>上传图片：</td><td class="upload_img">';
		}else{
			$mymps .='<div class="upload_img"><span>';
		}
		for($i=0;$i<$cfg_upimg_number;$i++){
			if(!empty($infoid)){
				$view = $db->getRow("SELECT image_id,prepath FROM `{$db_mymps}info_img` WHERE infoid = '$infoid' AND image_id = '$i'");
				$imagei = $view ? $mymps_global['SiteUrl'].$view[prepath] : $mymps_global['SiteUrl'].'/images/nopic.gif';
			}else{
				$imagei = $mymps_global['SiteUrl']."/images/nopic.gif";
			}
			$mymps .= '
			<ul>
			<div class="preview"><img src="'.$imagei.'" name="img'.$i.'" id="img'.$i.'" style="width:120px; height:120px;"></div>
			<li><input class="img_input" type="file" onpropertychange="if(CheckFile(this.value,this))img'.$i.'.src=this.value" name=mymps_img_'.$i.' onkeydown="return false" onpaste="return false" ondragenter="return false"></li>
			<li style="text-align:center; font-weight:100; color:#000; font-size:12px; line-height:22px"><input name="delinfoimg['.$i.']" type="checkbox" class="checkbox"> <font>删?</font></li>
			</ul>
			';
		}
		$mymps .= '</td></tr>';
	}
	return $mymps;
}
//get the new array
function arraychange($oldarray)
{
	$oldarray = explode("\r\n",$oldarray);
	$new_array = array();
	foreach($oldarray as $t) { 
		$t = explode('=', $t);
		if(!isset($new_array[$t[0]])){
			$new_array[$t[0]] = $t[1];
		}
	}
	return $new_array;
}
//get the format_date
function get_format_time($time){
	global $timestamp;
        $limit = ($timestamp ? $timestamp : time()) - $time;
	
	if($limit<60){
		$strTime=$limit.'秒钟前';	
	}else if($limit/60<60){
		$strTime=floor($limit/60).'分钟前';
	}else if($limit/60/60<24){
		$strTime=floor($limit/60/60).'小时前';
	}else if($limit/60/60>24&&$limit/60/60<48){
		$strTime='昨天'.date('H:i',$time);
	}else if($limit/60/60/24>2 && $limit/60/60/24<3){
		$strTime='前天'.date('H:i',$time);	
	}else if($limit/60/60/24<7){
		$strTime=floor($limit/60/60/24).'天前';
	}else{
		$strTime=date('y-m-d',$time);
	}
	return $strTime;
}

function replace_html_style($html = '',$id = ''){
	$random = rand();
	$year	= date("Y",time());
	$month	= date("m",time());
	$day	= date("d",time());
	$time	= time();
	return preg_replace('/\{([0-9a-zA-Z]+)\}/e','$$1',$html);
}

function clearcookies() {
	global $s_uid, $admin_id;
	foreach(array('s_uid', 'admin_id') as $k) {
		msetcookie($k);
	}
	$s_uid = $admin_id = $credits = '';
}

function submit_check($var, $allowget = 0) {
    if($allowget || ($_SERVER['REQUEST_METHOD'] == 'POST' && (empty($_SERVER['HTTP_REFERER']) ||
            preg_replace("/https?:\/\/([^\:\/]+).*/i", "\\1", $_SERVER['HTTP_REFERER']) == preg_replace("/([^\:]+).*/", "\\1", $_SERVER['HTTP_HOST'])))) {
        return true;
    } else {
        return false;
    }
}

function get_sex_option($cursex=''){
	foreach (array('男','女') as $key){
		$mymps .= '<option value='.$key;
		$mymps .= ($cursex == $key) ? ' style = "background-color:#6EB00C;color:white" selected>' : '>';
		$mymps .= $key.'</option>';
	}
	return $mymps;
}

function get_memtpl_options($opt=''){
	$option = $GLOBALS['db'] -> getAll("SELECT * FROM `{$GLOBALS['db_mymps']}member_tpl` WHERE if_view = '2' ORDER BY displayorder ASC");
	foreach ($option as $key => $v){
		$mymps .= '<option value='.$v[tpl_path];
		if(is_array($opt)){
			$mymps .= in_array($v[tpl_path],$opt) ? ' style = "background-color:#6EB00C;color:white" selected>' : '>';
		} else {
			$mymps .= ($opt == $v[tpl_path]) ? ' style = "background-color:#6EB00C;color:white" selected>' : '>';
		}
		
		$mymps .= $v[tpl_name].'</option>';
	}
	return $mymps;
}

//根据设置的栏目名称和栏目ID，获得栏目的实际保存路径
function get_htmlpath_type($dir_type,$typename,$id,$mydir){
	//路径类型判断
	if($dir_type == 1){
		//按栏目ID
		$html_path = $id;
	} elseif ($dir_type == 2) {
		//按栏目拼音
		$html_path = GetPinyin($typename);
	} elseif ($dir_type == 3) {
		//按栏目拼音首字母
		$html_path = GetPinyin($typename,1);
	} elseif ($dir_type == 4) {
		//自定义栏目名
		!$mydir && write_msg('请填写自定义栏目名！');
		$html_path = $mydir;
	} else {
		$html_path = false;
	}
	return $html_path;
}

function create_in($item_list, $field = '')
{
    if (empty($item_list)){
        return $field . " IN ('') ";
    }else{
        if (!is_array($item_list)){
            $item_list = explode(',', $item_list);
        }
        $item_list = array_unique($item_list);
        $item_list_tmp = '';
        foreach ($item_list AS $item){
            if ($item !== ''){
                $item_list_tmp .= $item_list_tmp ? ",'$item'" : "'$item'";
            }
        }
        if (empty($item_list_tmp)){
            return $field . " IN ('') ";
        }else{
            return $field . ' IN (' . $item_list_tmp . ') ';
        }
    }
}

/*
 * dat info_posttime.php
 */
function GetInfoPostTime($posttime='',$formname='posttime'){
	global $info_posttime;
	$info_posttime_form = "<select name='$formname' id='$formname'>";
	foreach($info_posttime as $k=>$v){
	 	if($k==$posttime) $info_posttime_form .= "<option value='$k' selected>$v</option>\r\n";
	 	else $info_posttime_form .= "<option value='$k'>$v</option>\r\n";
	}
	$info_posttime_form .= "</select>\r\n";
	return $info_posttime_form;
}

function mymps_global_header(){
	global $charset,$mymps_global;
	return "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">
<html xmlns=\"http://www.w3.org/1999/xhtml\">
<head>
<meta http-equiv=\"Content-Type\" content=\"text/html; charset=".$charset."\" />
<meta http-equiv=\"Content-Language\" content=\"zh-CN\"/>
<meta name=\"generator\" content=\"".MPS_SOFTNAME.MPS_VERSION."\"/>
<meta name=\"author\" content=\"".MPS_SOFTNAME." DevTeam Corporation\" />
<link rel=\"shortcut icon\" href=\"".$mymps_global[SiteUrl]."/favicon.ico\" />";
}

function HighLight($str, $keywords, $color = "red"){
	if (empty($keywords)) {
		return $str;
	} elseif(is_array($keywords)){
		foreach($keywords as $k => $v){
			$str = preg_replace('/'.$v.'/i','<font color='.$color.'>'.$v.'</font>', $str);
		}
	}else {
		$str = preg_replace('/'.$keywords.'/i','<font color='.$color.'>'.$keywords.'</font>', $str);
	}
	return $str;
}

function convertip_tiny($ip, $ipdatafile){
	static $fp = NULL, $offset = array(), $index = NULL;

	$ipdot = explode('.', $ip);
	$ip    = pack('N', ip2long($ip));

	$ipdot[0] = (int)$ipdot[0];
	$ipdot[1] = (int)$ipdot[1];

	if($fp === NULL && $fp = @fopen($ipdatafile, 'rb')) {
		$offset = unpack('Nlen', fread($fp, 4));
		$index  = fread($fp, $offset['len'] - 4);
	}
	elseif($fp == FALSE) {
		return  '- Invalid IP data file';
	}
	$length = $offset['len'] - 1028;
	$start  = unpack('Vlen', $index[$ipdot[0] * 4] . $index[$ipdot[0] * 4 + 1] . $index[$ipdot[0] * 4 + 2] . $index[$ipdot[0] * 4 + 3]);

	for ($start = $start['len'] * 8 + 1024; $start < $length; $start += 8){
		if ($index{$start} . $index{$start + 1} . $index{$start + 2} . $index{$start + 3} >= $ip){
			$index_offset = unpack('Vlen', $index{$start + 4} . $index{$start + 5} . $index{$start + 6} . "\x0");
			$index_length = unpack('Clen', $index{$start + 7});
			break;
		}
	}
	fseek($fp, $offset['len'] + $index_offset['len'] - 1024);
	if($index_length['len']) {
		return fread($fp, $index_length['len']);
	} 
	else {
		return '- Unknown';
	}
}

function ip2area($ip){
	$return = '';
	if(preg_match("/^\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}$/", $ip)) {
		$iparray = explode('.', $ip);

		if($iparray[0] == 10 || $iparray[0] == 127 || ($iparray[0] == 192 && $iparray[1] == 168) || ($iparray[0] == 172 && ($iparray[1] >= 16 && $iparray[1] <= 31))) {
			$return = '- LAN';
		} elseif($iparray[0] > 255 || $iparray[1] > 255 || $iparray[2] > 255 || $iparray[3] > 255){
			$return = '- Invalid IP Address';
		} else {
			$tinyipfile = MYMPS_DATA.'/ipdat/tinyipdata.dat';
			$return = convertip_tiny($ip, $tinyipfile);
		}
	}
	return $return;
}

/*
 *change the disallowed words to allowed words
 */
function filter_bad_words($cfg_badwords,$str)
{
	$cfg_bwords=explode(',',$cfg_badwords[0]);
	foreach ($cfg_bwords as $i){
		$str = str_replace($cfg_bwords,$cfg_badwords[1],$str);
	}
	return $str;
}

function verify_badwords_filter($ifopenname,$title='',$content=''){
	global $mymps_global;
	static $res = NULL;
	$title 	 = $title 	? mhtmlspecialchars(trim($title))  : '';
	$content = $content ? trim($content) : '';
	if($res === NULL){
		$data = read_static_cache('badwords');
		if($data === false){
			$query = $GLOBALS['db'] -> query("SELECT words,view,ifcheck FROM `{$GLOBALS['db_mymps']}badwords`");
			while($row = $GLOBALS['db']->fetchRow($query)){
				$cfg_badwords[0] = $row['words']; 
				$cfg_badwords[1] = $row['view']; 
				$cfg_badwords[2] = $row['ifcheck'];
			}
			write_static_cache('badwords',$cfg_badwords);
		}else{
			$cfg_badwords = $data;
		}
	}
	if($ifopenname==1){
		$info_level = 0;
		if(is_array($cfg_badwords)){
			$title=$title?SpHtml2Text(filter_bad_words($cfg_badwords,$title)):'';
			$content=$content?filter_bad_words($cfg_badwords,$content):'';
		}
	}else{
		if(is_array($cfg_badwords)){
			if($cfg_badwords[0] && $cfg_badwords[2]==1){
				foreach(explode(',',$cfg_badwords[0]) as $k => $v){
					if(strstr($title,$v)||strstr($content,$v)){
						$info_level = 0;
						break;
					}else{
						$info_level = 1;
					}
				}
			}elseif($cfg_badwords[2]==0){
				$title=SpHtml2Text(filter_bad_words($cfg_badwords,$title));
				$content=filter_bad_words($cfg_badwords,$content);
				$info_level = 1;
			}else{
				$info_level = 1;
			}
		}else{
			$info_level = 1;
		}
	}
	$verified_result = array();
	$verified_result['title']	  = $title;
	$verified_result['content']	  = $content;
	$verified_result['level']	  = $info_level;
	return $verified_result;
}

function get_info_option_array(){
	global $db,$db_mymps;
	$data = read_static_cache('info_typeoptions');
	if($data === false){
		$query = $db->query("SELECT title,identifier,rules,type FROM `{$db_mymps}info_typeoptions` WHERE classid >0 ORDER BY displayorder DESC");
		while($row = $db -> fetchRow($query)){
			$mymps[$row['identifier']]['title'] = $row['title'];
			$mymps[$row['identifier']]['rules'] = $row['rules'];
			$mymps[$row['identifier']]['type'] = $row['type'];
		}
		write_static_cache('info_typeoptions',$mymps);
	} else {
		$mymps = $data;
	}
	return $mymps;
}

function get_info_option_titval($option,$value,$class="mayi"){
	global $charset;
	if(!is_array($option) || empty($option)){
		return array();
	} else {
		if($option['type'] == 'radio' || $option['type'] == 'select'){
			$tmp 			= $charset == 'utf-8' ? utf8_unserialize($option['rules']) : unserialize($option['rules']);
			$new_array  	= arraychange($tmp['choices']);
			$new_value		= $new_array[$value];
			$value			= $new_value;
		}elseif($option['type'] == 'checkbox'){
			$value = explode(",",$value);
			$tmp = $charset == 'utf-8' ? utf8_unserialize($option['rules']) : unserialize($option['rules']);
			foreach ($value as $m =>$n){
				$new_array = arraychange($tmp[choices]);
				$nvalue .= "<font class=".$class.">".$new_array[$n]."</font>";
			}
			$value			= $nvalue;
		}else{
			$rules = $charset == 'utf-8' ? utf8_unserialize($option['rules']) : unserialize($option['rules']);
			$value			= $value.$rules['units'];
		}
		return array('title'=>$option['title'],'value'=>$value);
	}
}

function clear_mirror($str){
	$str = str_replace('-','',$str);
	$str = str_replace('+','',$str);
	return $str;
}

function part_ip($ip){
	return preg_replace('/((?:\d+\.){3})\d+/', "\\1*",$ip);
}

function ajax_output($ajax_content){
	global $charset;
	@header("Expires: -1");
	@header("Cache-Control: no-store, private, post-check=0, pre-check=0, max-age=0", FALSE); 
	@header("Pragma: no-cache"); 
	@header('Content-Type: text/xml'); 
	$mymps .= '<?xml version="1.0" encoding="'.($charset == "gbk" ? "gbk" : "utf-8").'"?><root><![CDATA[';
	$mymps .= $ajax_content;
	$mymps .= ']]></root>';
	return $mymps;
}

/**************************/
/*获得各模型允许提交的参数*/
/**************************/
function allow_identifier(){
	$data = read_static_cache("mod_search_identifier");
	if($data === false){
		require_once MYMPS_DATA."/info.type.inc.php";
		$query 	= $GLOBALS['db'] -> query("SELECT id,options  FROM `{$GLOBALS['db_mymps']}info_typemodels` ORDER BY displayorder DESC");
		while($row = $GLOBALS['db'] -> fetchRow($query)){

			$option = explode(",",$row[options]);
			
			foreach($option as $w => $u){
				$newrow = $GLOBALS['db'] -> getRow("SELECT identifier,search FROM `{$GLOBALS['db_mymps']}info_typeoptions` WHERE optionid='$u'");
				if($newrow['search']=='on'){
					$arr[$row[id]]['identifier'][] = $newrow['identifier'];
				}
			}
			$res = $arr;
		}
		
		write_static_cache("mod_search_identifier",$res);
	} else {
		$res = $data;
	}
	
	return $res;
}

/**********************/
/*获得信息筛选条件选项*/
/**********************/
function mod_identifier(){
	$data = read_static_cache("mod_search_option");
	if($data === false){
		require_once MYMPS_DATA."/info.type.inc.php";
		$query 	= $GLOBALS['db'] -> query("SELECT id,options  FROM `{$GLOBALS['db_mymps']}info_typemodels` ORDER BY displayorder DESC");
		while($row = $GLOBALS['db'] -> fetchRow($query)){
			$option = explode(',',$row[options]);
			foreach($option as $w => $u){
				$nrow = $GLOBALS['db'] -> getRow("SELECT optionid,title,identifier,type,rules,search FROM `{$GLOBALS['db_mymps']}info_typeoptions` WHERE optionid='$u'");
				if($nrow['search'] == 'on'){
					$extra = ($GLOBALS['charset'] == 'utf-8')	? utf8_unserialize($nrow['rules']) : unserialize($nrow['rules']);
					if(in_array($nrow['type'],array('select','radio','checkbox','number')))
					{
						if(is_array($extra)){
							foreach($extra as $k => $value){
								if($nrow[type] == 'radio' || $nrow[type] == 'select' || $nrow[type] == 'checkbox' || ($nrow[type] == 'number' && $k == 'choices')){
									$extr = array_merge(array('-1'=>'不限'),arraychange($value));
									foreach($extr as $ekey => $eval){
										$ar['id']  = $ekey;
										$ar['name']  = $eval;
										$ar['identifier']  = $nrow['identifier'];
										$arr[$row['id']][$nrow['optionid']]['list'][] = $ar;
									}
								}
								$arr[$row['id']][$nrow['optionid']]['title'] = $nrow['title'];
								$arr[$row['id']][$nrow['optionid']]['type']  = $nrow['type'];
								$arr[$row['id']][$nrow['optionid']]['identifier'] = $nrow['identifier'];
								$arr[$row['id']][$nrow['optionid']]['publish'] = get_info_var_type($nrow['type'],$nrow['identifier'],$extr,$get_value,'front');
							}
						}
					}
				}
			}
		}
		$res = $arr;
		write_static_cache('mod_search_option',$res);
	}else{
		$res = $data;
	}
	return $res;
}

function mymps_get_faq($num=5,$typeid=NULL){
	global $db,$db_mymps,$seo;
	if(!$seo) $seo = get_seoset();
	$where  = $typeid ? "WHERE typeid = $typeid" : '';
	$sql 	= "SELECT id,typeid,title FROM {$db_mymps}faq $where ORDER BY id DESC LIMIT 0,".$num;
	$do_mymps = $db -> query($sql);
	
	while($row = $db -> fetchRow($do_mymps)){
		$arr['id']        	= $row['id'];
		$arr['title'] 		= $row['title'];
		$arr['uri']      	= Rewrite('about',array('part'=>'faq','id'=>$row['id']));
		$faq_list[]      	= $arr;
	}
	
	unset($seo);
	return $faq_list;
}

function mymps_get_focus($type='index',$num=5,$cityid=NULL){
	global $db,$db_mymps,$independency;
	if(!$independency) $independency = array();
	$city_limit = (in_array('focus',$independency) || !$cityid) ? "" : " AND cityid = '$cityid'";
	$type_limit = $type == "index" ? " AND typename= '网站首页'" : " AND typename = '新闻首页'";
	
	$query = $db -> query("SELECT image,pre_image,url,words,id FROM `{$db_mymps}focus` WHERE 1 {$type_limit} {$city_limit} ORDER BY focusorder DESC LIMIT 0,$num");
	while($row = $db -> fetchRow($query)){
		$list[$row['id']]['id'] = $row['id'];
		$list[$row['id']]['image'] = $row['image'];
		$list[$row['id']]['pre_image'] = $row['pre_image'];
		$list[$row['id']]['url'] = $row['url'];
		$list[$row['id']]['words'] = $row['words'];
	}
	return $list;
}

function mymps_get_news($num=10,$catid=NULL,$ifimg=NULL,$leftjoin=NULL,$ifhot=NULL,$orderby=1){
	global $city,$db,$db_mymps;
	$cat_limit  = empty($catid) ? '' : "AND a.catid IN(".get_cat_children($catid,'channel').")";
	$img_limit  = !$ifimg ? '' : "AND a.imgpath != ''";
	$commend_limit = empty($ifhot) ? '' : " AND a.iscommend = '1'";
	$orderby	= empty($orderby) ? "ORDER BY a.hit DESC" : "ORDER BY a.id DESC";
	$res = array();
	if($leftjoin){
		$query = $db -> query("SELECT a.*,b.catname FROM `{$GLOBALS['db_mymps']}news` AS a LEFT JOIN `{$GLOBALS['db_mymps']}channel` AS b ON a.catid = b.catid WHERE 1 {$cat_limit} {$img_limit}{$city_limit} {$commend_limit} {$orderby} LIMIT 0,$num");
		while($row = $db -> fetchRow($query)){
			$arr['id'] 			= $row['id'];
			$arr['title'] 		= $row['title'];
			$arr['iscommend']	= $row['iscommend'];
			$arr['imgpath'] 	= $row['imgpath'];
			$arr['content'] 	= clear_html($row['content']);
			$arr['begintime'] 	= $row['begintime'];
			$arr['catname']		= $row['catname'];
			$arr['caturi']		= Rewrite('news',array('catid'=>$row['catid']));
			$arr['uri']			= $row['isjump'] ? $row['redirect_url'] : Rewrite('news',array('id'=>$row['id']));
			$res[]      = $arr;
		}
	}else{
		$query = $db -> query("SELECT a.* FROM `{$GLOBALS['db_mymps']}news` AS a WHERE 1 {$cat_limit} {$img_limit}{$city_limit} {$orderby} LIMIT 0,$num");
		while($row = $db -> fetchRow($query)){
			$arr['id'] 			= $row['id'];
			$arr['title'] 		= $row['isbold'] == 1 ? '<strong>'.$row['title'].'</strong>' : $row['title'];
			$arr['title'] 		= $row['title'];
			$arr['iscommend']	= $row['iscommend'];
			$arr['imgpath'] 	= $row['imgpath'];
			$arr['content'] 	= clear_html($row['content']);
			$arr['begintime'] 	= $row['begintime'];
			$arr['uri']			= $row['isjump'] ? $row['redirect_url'] : Rewrite('news',array('id'=>$row['id']));
			$res[]      = $arr;
		}
	}
	return $res;
}

function mymps_get_members($num=NULL,$level=NULL,$orderby=NULL,$if_certify=NULL,$ifindex=NULL,$iflist=NULL,$catid=NULL,$cityid=NULL){
	global $db,$db_mymps,$mymps_global;
	if($mymps_global['cfg_if_corp'] == 1){
		$where 	 = $level ? " WHERE a.levelid = '$level'":" WHERE 1";
		$where   .= " AND a.status = '1'";
		$where	 .= " AND a.if_corp = '1'";
		$where	 .= $if_certify ? " AND a.com_certify = '1'" : " ";
		$where	 .= $ifindex ? " AND a.ifindex = '2'" : " ";
		$where	 .= $iflist ? " AND a.iflist = '2'" : " ";
		$where   .= $cityid ? " AND a.cityid = '$cityid'" : '';
		$where 	 .= !empty($catid) 	? " AND catid IN(".get_corp_children($catid).") "  : "";
		
		$orderby = $orderby == 1 ?  "ORDER BY a.levelid DESC" :"ORDER BY a.id DESC" ;
		$limit   = $num ? " LIMIT 0,".$num : '';
	
		$sql = "SELECT a.* FROM `{$db_mymps}member` AS a  $where $orderby $limit";
		
		$do_mymps = $db -> query($sql);
	
		while($row = $db -> fetchRow($do_mymps)){
			$arr['id']        	= $row['id'];
			$arr['userid']   	= $row['userid'];
			$arr['cname'] 		= $row['cname'];
			$arr['tname']		= $row['tname'] ? $row['tname'] : $row['userid'];
			$arr['prelogo']		= $row['prelogo'] ? $row['prelogo'] : '/images/nophoto.gif';
			$arr['jointime'] 	= $row['jointime'];
			$arr['logintime']	= $row['logintime'];
			$arr['tel']			= $row['tel'];
			$arr['address']		= $row['address'];
			$arr['qq']			= $row['qq'];
			$arr['credits']		= $row['credits'];
			$arr['hit']		= $row['hit'];
			$arr['introduce']	= clear_html($row['introduce']);
			$arr['uri']      	= Rewrite('store',array('uid'=>$row['id']/*,'part'=>'album'*/));
			$member_list[]      = $arr;
		}
	}else{
		$member_list = array();
	}
	return $member_list;
}

/*获得机构文档/文章*/
function mymps_get_member_docus($num=10,$userid=NULL,$typeid=NULL,$orderby=1){
	global $db,$db_mymps;
	$where = "WHERE a.if_check = '1'";
	$where .= $userid ? " AND a.userid = '$userid'" : "";
	$where .= $typeid ? " AND a.typeid = '$typeid'" : "";
	$limit   = " LIMIT 0,".$num;
	$orderby = $orderby == 1 ? " ORDER BY a.pubtime DESC " : " ORDER BY a.id DESC ";
	
	$query = $db -> query("SELECT a.*,b.id AS uid,b.tname FROM `{$db_mymps}member_docu` AS a LEFT JOIN `{$db_mymps}member` AS b ON a.userid = b.userid {$where} {$orderby} {$limit}");
	while($row = $db -> fetchRow($query)){
		$arr['id'] = $row['id'];
		$arr['userid'] = $row['userid'];
		$arr['tname'] = $row['tname'];
		$arr['typeid'] = $row['typeid'];
		$arr['title']  = $row['title'];
		$arr['pubtime']= $row['pubtime'];
		$arr['imgpath']= $row['imgpath'];
		$arr['hit']= $row['hit'];
		$arr['pre_imgpath']= $row['pre_imgpath'];
		$arr['tname_uri']  = Rewrite('store',array('uid'=>$row['uid'],'part'=>'index'));
		$arr['uri']   	= Rewrite('store',array('uid'=>$row['uid'],'id'=>$row['id'],'part'=>'document'));
		$docu[] = $arr;
	}
	return $docu;
}

/*
 *获得信息列表
 */
function mymps_get_infos($num=10,$info_level=NULL,$upgrade_type=NULL,$userid=NULL,$catid=NULL,$certify=NULL,$if_hot=NULL,$tel=NULL,$cityid=NULL){
	global $timestamp,$db_mymps,$mymps_global,$db,$city,$seo;
	$where .= !$info_level ? 'WHERE (a.info_level =1 OR a.info_level = 2)':'WHERE a.info_level = '.$info_level;
	$where .= $userid	? ' AND a.userid = "'.$userid.'" ' : '';
	$where .= $certify	? ' AND a.certify = "'.$certify.'" ' : '';
	$where .= $tel		? ' AND a.tel = "'.$tel.'" ' : '';
	$where .= $catid	? ' AND '.get_children($catid,'a.catid') : '';
	$where .= $cityid > 0 ? ' AND a.cityid = "'.$cityid.'" ' : '';
	
	if($upgrade_type == 1){
		$where .= " AND a.upgrade_type_list = 2 ";
	} elseif($upgrade_type == 2){
		$where .= " AND a.upgrade_type = 2 ";
	} elseif($upgrade_type == 3){
		$where .= " AND a.upgrade_type_index = 2 ";
	}

	$where .= !empty($sql) ? $sql	: '';
	$orderby = $if_hot ? " ORDER BY a.hit DESC " : " ORDER BY a.begintime DESC ";
	$info_list = array();
	$idin = get_page_idin("id","SELECT a.id FROM `{$db_mymps}information` AS a {$where} {$orderby}",$num);
	
	if($idin){
		$sql = "SELECT a.id,a.contact_who,a.title,a.content,a.begintime,a.catid,a.info_level,a.hit,a.dir_typename,a.ifred,a.ifbold,a.userid,a.catid,a.cityid,a.catname,a.img_path FROM `{$GLOBALS['db_mymps']}information` AS a WHERE id IN ($idin) {$orderby}";
		$do_mymps = $db -> query($sql);
		while($row = $db -> fetchRow($do_mymps)){
			$arr['id']        = $row['id'];
			$arr['catid']     = $row['catid'];
			$arr['title']     = $row['title'];
			$arr['content']   = clear_html($row['content']);
			$arr['ifred']     = $row['ifred'];
			$arr['ifbold']    = $row['ifbold'];
			$arr['hit']    	  = $row['hit'];
			$arr['begintime'] = $row['begintime'];
			$arr['img_path']  = $row['img_path'];
			$arr['catname']   = $row['catname'];
			$arr['info_level']= $row['info_level'];
			$arr['userid']    = $row['userid'];
			$arr['contact_who']= $row['contact_who'];
			$arr['uri']       = Rewrite('info',array('id'=>$row['id'],'cityid'=>$row['cityid'],'dir_typename'=>$row['dir_typename']));
			$arr['uri_tname'] = Rewrite('space',array('user'=>$row['userid']));
			$arr['uri_cat']	  = Rewrite('category',array('catid'=>$row['catid'],'dir_typename'=>$row['dir_typename']));
			$info_list[]      = $arr;
		}
	}
	return $info_list;
}

/*团购活动*/
function mymps_get_groups($num=10,$glevel=NULL,$cityid=false)
{
	global $db,$db_mymps;
	static $res = NULL;
	$limit = $num ? " LIMIT 0,$num" : "";
	$where = $glevel ? " WHERE glevel > '$glevel'" : " WHERE glevel > '0'";
	$where .= $cityid ? " AND cityid = '$cityid'" : "";
	$query = $db -> query("SELECT * FROM `{$db_mymps}group` $where ORDER BY dateline DESC $limit");
	while($row = $db -> fetchRow($query)){
		$res[$row['groupid']]['groupid'] = $row['groupid'];
		$res[$row['groupid']]['gname'] = $row['gname'];
		$res[$row['groupid']]['picture'] = $row['picture'];
		$res[$row['groupid']]['pre_picture'] = $row['pre_picture'];
		$res[$row['groupid']]['userid'] = $row['userid'];
		$res[$row['groupid']]['uri'] = plugin_url('group',array('id'=>$row['groupid']));
		$res[$row['groupid']]['gaddress'] = $row['gaddress'];
		$res[$row['groupid']]['meetdate'] = $row['meetdate'];
		$res[$row['groupid']]['enddate'] = $row['enddate'];
		$res[$row['groupid']]['dateline'] = $row['dateline'];
	}
	return $res;
}

/*商品*/
function mymps_get_goods($num=10,$onsale=1,$shuxing=NULL,$catid=NULL,$userid=NULL,$orderby=1,$cityid=false)
{
	global $db,$db_mymps;
	$limit = $num ? " LIMIT 0,$num" : "";
	$where = $onsale == 1 ? " WHERE onsale = '1'" : " WHERE 1";
	$where .= $userid ? " AND userid = '$userid'" : "";
	$where .= $shuxing == 'cuxiao' ? " AND cuxiao = '1'" : "";
	$where .= $shuxing == 'remai' ? " AND remai = '1'" : "";
	$where .= $shuxing == 'tuijian' ? " AND tuijian = '1'" : "";
	$where .= $catid ? " AND catid IN(".mymps_get_goods_children($catid).")" : "";
	$where .= $cityid ? " AND cityid = '$cityid'" : "";
	
	$orderby = empty($orderby) ? " ORDER BY hit DESC " : " ORDER BY dateline DESC ";

	$query = $db -> query("SELECT * FROM `{$db_mymps}goods` $where $orderby $limit");
	while($row = $db -> fetchRow($query)){
		$res[$row['goodsid']]['goodsid'] = $row['goodsid'];
		$res[$row['goodsid']]['goodsname'] = $row['goodsname'];
		$res[$row['goodsid']]['oldprice'] = $row['oldprice'];
		$res[$row['goodsid']]['content'] = clear_html($row['content']);
		$res[$row['goodsid']]['nowprice'] = $row['nowprice'];
		$res[$row['goodsid']]['pre_picture'] = $row['pre_picture'] ? $row['pre_picture'] : $mymps_global['SiteUrl'].'/images/nophoto.gif';
		$res[$row['goodsid']]['picture'] = $row['picture'] ? $row['picture'] : $mymps_global['SiteUrl'].'/images/nophoto.gif';
		$res[$row['goodsid']]['uri'] = plugin_url('goods',array('id'=>$row['goodsid']));
	}
	return $res;
}

/*优惠券*/
function mymps_get_coupons($num=10,$grade=0)
{
	global $db,$db_mymps,$city;
	static $res = NULL;
	$limit = $num ? " LIMIT 0,$num" : "";
	$where = $grade ? " WHERE grade > '$grade'" : " WHERE grade > '0'";
	$where .= $cityid ? " AND cityid = '$cityid'" : "";
	$query = $db -> query("SELECT * FROM `{$db_mymps}coupon` $where ORDER BY begindate DESC $limit");
	while($row = $db -> fetchRow($query)){
		$res[$row['id']]['id'] = $row['id'];
		$res[$row['id']]['title'] = $row['title'];
		$res[$row['id']]['des'] = $row['des'];
		$res[$row['id']]['picture'] = $row['picture'];
		$res[$row['id']]['pre_picture'] = $row['pre_picture'];
		$res[$row['id']]['userid'] = $row['userid'];
		$res[$row['id']]['uri'] = plugin_url('coupon',array('id'=>$row['id']));
		$res[$row['id']]['begindate'] = $row['begindate'];
		$res[$row['id']]['enddate'] = $row['enddate'];
		$res[$row['id']]['dateline'] = $row['dateline'];
	}
	return count($res)>0?$res:false;
}

//获得导航  主导航 副导航 尾部导航
function mymps_get_navurl($type,$num='30'){
	$data = read_static_cache('navurl_'.$type);
	if ($data === false){
		if($type == 'foot') {
			$query = "SELECT * FROM `{$GLOBALS['db_mymps']}navurl` WHERE isview = '2' AND typeid = '2' ORDER BY displayorder ASC LIMIT 0,$num";
		} elseif($type == 'header') {
			$query = "SELECT * FROM `{$GLOBALS['db_mymps']}navurl` WHERE isview = '2' AND typeid = '3' ORDER BY displayorder ASC LIMIT 0,$num";
		} elseif($type == 'head') {
			$query = "SELECT * FROM `{$GLOBALS['db_mymps']}navurl` WHERE isview = '2' AND typeid = '1' ORDER BY displayorder ASC LIMIT 0,$num";
		}
		$res = $GLOBALS['db'] -> getAll($query);
		write_static_cache('navurl_'.$type, $res);
	}else {
		$res = $data;
	}
	return $res;
}
/*
 *aboutus.php 取得aboutus
 */
function get_aboutus($id=NULL){
	global $seo;
	if(!$seo) $seo = get_seoset();
	if(!$id){
		$query = $GLOBALS['db']->query("SELECT id,typename,pubdate,dir_typename FROM `{$GLOBALS['db_mymps']}about` ORDER BY displayorder,id ASC");
		while($row = $GLOBALS['db']-> fetchRow($query)){
			$arr['id'] 			= $row['id'];
			$arr['typename'] 	= $row['typename'];
			$arr['pubdate'] 	= $row['pubdate'];
			$arr['uri'] 		= $row['redirect_url'] ? $row['redirect_url'] : Rewrite('about',array('part'=>'aboutus','id'=>$row['id'],'html_path'=>'/aboutus/'.$row['dir_typename'].$seo['seo_htmlext']));
			$aboutus[] 		= $arr;
		}
	} else {
		$aboutus = $GLOBALS['db']->getRow("SELECT * FROM {$GLOBALS['db_mymps']}about WHERE id =$id");
	}
	return $aboutus;
}
/*
 faq.php 取得faq
 */
function get_faq($id=NULL){
	global $seo,$db,$db_mymps;
	if(!$seo) $seo = get_seoset();
	if($id){
		$faq = $db -> getRow("SELECT id,title,content FROM `{$db_mymps}faq` WHERE id = '$id'");
	}else{
		$query = $db -> query("SELECT id,typename FROM `{$db_mymps}faq_type` ORDER BY id ASC");
		while($row = $db->fetchRow($query)){
			$faq[$row['id']]['typename'] = $row['typename'];
		}
		$query = $row = NULL;
		
		$query = $db ->query("SELECT * FROM `{$db_mymps}faq` ORDER BY id DESC");
		while($row = $db -> fetchRow($query)){
			$arr['id'] 		= $row['id'];
			$arr['title'] 	= $row['title'];
			$arr['uri'] 	= Rewrite('about',array('part'=>'faq','id'=>$row['id'],'html_path'=>'/faq/'.$row['id'].$seo['seo_htmlext']));
			$faq[$row['typeid']]['faq'][$row['id']] = $arr;
		}
	}
	return $faq;
}
/*
 *取得内页友情链接
 */
function get_flink(){
	global $db,$db_mymps,$city;

	$city_limit = $city['cityid'] ? " AND cityid = '$city[cityid]'" : " AND cityid = '0'";
	
	$query = $db -> query("SELECT * FROM `{$db_mymps}flink_type` ORDER BY id ASC");
	while($row = $db -> fetchRow($query)){
		$flink[$row['id']]['typename'] = $row['typename'];
	}
	$query = $row = NULL;
	
	$query = $db -> query("SELECT * FROM `{$db_mymps}flink` WHERE ischeck = '2' AND ifindex = '1' {$city_limit} ORDER BY weblogo DESC,ordernumber DESC,id DESC");
	while($row = $db -> fetchRow($query)){
		$arr['id'] = $row['id'];
		$arr['webname'] = $row['webname'];
		$arr['weblogo'] = $row['weblogo'];
		$arr['url'] = $row['url'];
		if($row['weblogo']){
			$flink[$row['typeid']]['imglink'][$row['id']] = $arr;
		} else {
			$flink[$row['typeid']]['txtlink'][$row['id']] = $arr;
		}
	}
	
	//print_r($flink);
	//exit;

	return $flink;
}
/*
 * ASS info.php
 */
function get_member_info($userid=''){
	$row = $GLOBALS['db'] -> getRow("SELECT * FROM `{$GLOBALS['db_mymps']}member` WHERE userid = '$userid'");
	$row['uri'] = Rewrite('space',array('user'=>$row['userid']));
	return $row;
}

function chk_member_purview($purview)
{
	global $db,$db_mymps,$s_uid;
	$member  = get_member_group('',$s_uid);
	!in_array($purview,explode(',',$member['purviews'])) && write_msg("您当前的会员级别没有该栏目的操作权限！<br />请先升级会员级别！","index.php?m=levelup");
}

function get_member_group($groupid='',$userid=''){
	if(empty($groupid)){
		$groupid = $GLOBALS['db'] -> getOne("SELECT levelid FROM {$GLOBALS['db_mymps']}member WHERE userid = '$userid'");
	}
	$data = read_static_cache('member_'.$groupid);
	if($data === false){
		$res = 	$GLOBALS['db'] -> getRow("SELECT * FROM `{$GLOBALS['db_mymps']}member_level` WHERE id = '$groupid'");
		$res['allow_tpl'] = empty($res['allow_tpl']) ? '/template/space/theme1' : $res['allow_tpl'];
		
		$in = create_in(explode(',',$res['allow_tpl']),'tpl_path');
		
		$query = $GLOBALS['db'] -> query("SELECT * FROM `{$GLOBALS['db_mymps']}member_tpl` WHERE $in AND if_view = '2'");
		$res['allow_tpl'] = array();
		while($row = $GLOBALS['db']->fetchRow($query)){
			$res['allow_tpl'][$row['id']]['tpl_name'] = $row['tpl_name'];
			$res['allow_tpl'][$row['id']]['tpl_path'] = $row['tpl_path'];
		}
		write_static_cache('member_'.$groupid,$res);
	} else {
		$res = $data;
	}
	return $res;
}

function runcron() {
	global $timestamp, $db, $db_mymps;
	include MYMPS_ROOT.'/data/cron.cache.php';
	if(is_array($m_cron)){
		$i = 0;
		foreach ($m_cron as $key => $cron){
			if ($cron['nextrun'] <= $timestamp) {
				list($yearnow, $monthnow, $daynow) = explode('-', gmdate('Y-m-d', $timestamp + 8* 3600));
				$nextrun = @gmmktime(0, 0, 0, $monthnow, $daynow+1, $yearnow) - 8 * 3600;
				include MYMPS_ROOT.'/include/crons/'.$key.'.inc.php';
				$db->query("UPDATE `{$db_mymps}crons` SET lastrun=".$timestamp.",nextrun=".$nextrun." WHERE name='$key'");
				$i++;
			}
		}
		if($i > 0) write_cron_cache();
	} else {
		write_cron_cache();
	}
}

function ifplugin($pluginname=''){
	global $pluginsettings,$mymps_global;
	$data = read_static_cache('plugin');
	if($data === false){
		write_plugin_cache();
	} else {
		$pluginsettings = $data;
		if($mymps_global['cfg_if_corp'] != 1){
			unset($pluginsettings['coupon'],$pluginsettings['group'],$pluginsettings['goods']);
		}
	}
	return (!$pluginsettings[$pluginname] || $pluginsettings[$pluginname]['disable'] == 1) ? false : true;
}

function cutstr($string, $length, $dot = '') {
	global $charset;

	if(strlen($string) <= $length) {
		return $string;
	}

	$string = str_replace(array('&amp;', '&quot;', '&lt;', '&gt;'), array('&', '"', '<', '>'), $string);

	$strcut = '';
	if(strtolower($charset) == 'utf-8') {

		$n = $tn = $noc = 0;
		while($n < strlen($string)) {

			$t = ord($string[$n]);
			if($t == 9 || $t == 10 || (32 <= $t && $t <= 126)) {
				$tn = 1; $n++; $noc++;
			} elseif(194 <= $t && $t <= 223) {
				$tn = 2; $n += 2; $noc += 2;
			} elseif(224 <= $t && $t < 239) {
				$tn = 3; $n += 3; $noc += 2;
			} elseif(240 <= $t && $t <= 247) {
				$tn = 4; $n += 4; $noc += 2;
			} elseif(248 <= $t && $t <= 251) {
				$tn = 5; $n += 5; $noc += 2;
			} elseif($t == 252 || $t == 253) {
				$tn = 6; $n += 6; $noc += 2;
			} else {
				$n++;
			}

			if($noc >= $length) {
				break;
			}

		}
		if($noc > $length) {
			$n -= $tn;
		}

		$strcut = substr($string, 0, $n);

	} else {
		for($i = 0; $i < $length; $i++) {
			$strcut .= ord($string[$i]) > 127 ? $string[$i].$string[++$i] : $string[$i];
		}
	}

	$strcut = str_replace(array('&', '"', '<', '>'), array('&amp;', '&quot;', '&lt;', '&gt;'), $strcut);

	return $strcut.$dot;
}

/*加密与解密*/
function mmd5($string,$action="EN",$rand='',$db_mixcode=''){ 
	global $db_mixcode;
    $secret_string = $db_mixcode.$rand.'^fgfZ4_9dfjdf';

    if($string=="") return ""; 
    if($action=="EN") $md5code=substr(md5($string),8,10); 
    else{ 
        $md5code=substr($string,-10); 
        $string=substr($string,0,strlen($string)-10); 
    } 
	$key = md5($md5code.$secret_string); 
    $string = ($action=="EN"?$string:base64_decode($string)); 
    $len = strlen($key); 
    $code = ""; 
    for($i=0; $i<strlen($string); $i++){ 
        $k = $i%$len; 
        $code .= $string[$i]^$key[$k]; 
    } 
    $code = ($action == "DE" ? (substr(md5($code),8,10)==$md5code?$code:NULL) : base64_encode($code)."$md5code"); 
    return $code; 
}

function mymps_get_goods_children($catid)
{
	if($row = $GLOBALS['db']->getAll("SELECT catid FROM `{$GLOBALS['db_mymps']}goods_category` WHERE parentid = '$catid'")){
		$cat = array();
		foreach ($row as $k => $v){
			$cat[$v['catid']] = $v['catid'];
		}
		$cats = implode(',', $cat).','.$catid;
		return $cats;
	}else{
		return $catid;
	}
}

function mygetenv( $var_name )
{
	if ( isset( $_SERVER[$var_name] ) ){
		return $_SERVER[$var_name];
	}
	if ( isset( $_ENV[$var_name] ) ){
		return $_ENV[$var_name];
	}
	if ( getenv( $var_name ) ){
		return getenv( $var_name );
	}
	if ( function_exists( "apache_getenv" ) && apache_getenv( $var_name, true ) ){
		return apache_getenv( $var_name, true );
	}
	return '';
}

function getRootdomain($domain){  
	$suffix=array("ae","af","ag","ai","al","am","an","ao","aq","ar","as","at","au","aw","az","ba","bb","bd","be","bf","bg","bh","bi","bj","bm","bn","bo","br","bs","bt","bv","bw","by","bz","ca","cc","cf","cg","ch","ci","ck","cl","cm","cn","co","cq","cr","cu","cv","cx","cy","cz","de","dj","dk","dm","do","dz","ec","ee","eg","eh","es","et","ev","fi","fj","fk","fm","fo","fr","ga","gb","gd","ge","gf","gh","gi","gl","gm","gn","gp","gr","gt","gu","gw","gy","hk","hm","hn","hr","ht","hu","id","ie","il","in","io","iq","ir","is","it","jm","jo","jp","ke","kg","kh","ki","km","kn","kp","kr","kw","ky","kz","la","lb","lc","li","lk","lr","ls","lt","lu","lv","ly","ma","mc","md","mg","mh","ml","mm","mn","mo","mp","mq","mr","ms","mt","mv","mw","mx","my","mz","na","nc","ne","nf","ng","ni","nl","no","np","nr","nt","nu","nz","om","qa","pa","pe","pf","pg","ph","pk","pl","pm","pn","pr","pt","pw","py","re","ro","ru","rw","sa","sb","sc","sd","se","sg","sh","si","sj","sk","sl","sm","sn","so","sr","st","su","sy","sz","tc","td","tf","tg","th","tj","tk","tm","tn","to","tp","tr","tt","tv","tw","tz","ua","ug","uk","us","uy","va","vc","ve","vg","vn","vu","wf","ws","ye","yu","za","zm","zr","zw","com","edu","gov","int","mil","net","org","wang","top");
	$domainArr=explode(".",$domain);
	$l=count($domainArr);
	$key=0;
	for($i=0;$i<$l;$i++){
		if(in_array($domainArr[$i],$suffix)){
			$key=$i;
			break;
		}
	}
	for($i=$key;$i<$l;$i++)
		$inSuffixs.=".".$domainArr[$i];
	return $domainArr[$key-1].$inSuffixs;
}

function ifsiteopen(){
	global $mymps_global;
	if($mymps_global['cfg_if_site_open'] != 1) {
		$mymps_global['cfg_site_open_reason'] = str_replace('\n','<br />',$mymps_global['cfg_site_open_reason']);
		exit('网站已关闭，关闭原因：<br><br /><b>'.$mymps_global['cfg_site_open_reason'].'</b>');
	}
}

function replace_insidelink($txt,$type='information')
{
	$data = read_static_cache('insidelink');
	if(is_array($data['detail']) && $data['settings']['forward'][$type] == 1)
	{
		$word = $replacement = array();
		foreach($data['detail'] as $k => $v)
		{
			$word[] = $k;
			$replacement[] = '<a href="'.$v.'" target="_blank">'.$k.'</a>';
		}

        $txt = @preg_replace("#(^|>)([^<]+)(?=<|$)#sUe", "replacelight('\\2', \$word, \$replacement, '\\1')", $txt);
	}
	return $txt;
}

function replacelight($txt, $word, $replacement, $pre)
{
    $txt = str_replace('\"', '"', $txt);
	$txt = str_replace($word, $replacement, $txt);
    return $pre.$txt;
}

function pcclient(){ 
	$user_agent = $_SERVER['HTTP_USER_AGENT']; 
	$mobile_agents = Array("240x320","acer","acoon","acs-","abacho","ahong","airness","alcatel","amoi","android","anywhereyougo.com","applewebkit/525","applewebkit/532","asus","audio","au-mic","avantogo","becker","benq","bilbo","bird","blackberry","blazer","bleu","cdm-","compal","coolpad","danger","dbtel","dopod","elaine","eric","etouch","fly ","fly_","fly-","go.web","goodaccess","gradiente","grundig","haier","hedy","hitachi","htc","huawei","hutchison","inno","ipad","ipaq","ipod","jbrowser","kddi","kgt","kwc","lenovo","lg ","lg2","lg3","lg4","lg5","lg7","lg8","lg9","lg-","lge-","lge9","longcos","maemo","mercator","meridian","micromax","midp","mini","mitsu","mmm","mmp","mobi","mot-","moto","nec-","netfront","newgen","nexian","nf-browser","nintendo","nitro","nokia","nook","novarra","obigo","palm","panasonic","pantech","philips","phone","pg-","playstation","pocket","pt-","qc-","qtek","rover","sagem","sama","samu","sanyo","samsung","sch-","scooter","sec-","sendo","sgh-","sharp","siemens","sie-","softbank","sony","spice","sprint","spv","symbian","tablet","talkabout","tcl-","teleca","telit","tianyu","tim-","toshiba","tsm","up.browser","utec","utstar","verykool","virgin","vk-","voda","voxtel","vx","wap","wellco","wig browser","wii","windows ce","wireless","xda","xde","zte"); 
	$is_mobile = true; 
	foreach ($mobile_agents as $device) { 
		if (stristr($user_agent, $device)) { 
			$is_mobile = false; 
			break; 
		}
	} 
	return $is_mobile; 
}

function get_smplist_cats($cats,$showstyle){
	global $db,$db_mymps,$mymps_global;
	$query = $db -> query("SELECT * FROM `{$db_mymps}category` WHERE catid ".create_in($cats)." AND if_view = '2' ORDER BY catorder ASC");
	while($row = $db -> fetchRow($query)){
		$listcats[$row['catid']]['catid'] = $row['catid'];
		$listcats[$row['catid']]['catname'] = $row['catname'];
		$listcats[$row['catid']]['icon'] = $row['icon'];
		$listcats[$row['catid']]['caturi'] = Rewrite('category',array('catid'=>$row['catid'],'dir_typename'=>$row['dir_typename']));
		$listcats[$row['catid']]['showstyle'] = $showstyle[$row['catid']];
		$listcats[$row['catid']]['color'] = $row['color'];
	}
	
	$query = $db -> query("SELECT * FROM `{$db_mymps}category` WHERE parentid ".create_in($cats)." AND if_view = '2' ORDER BY catorder ASC");
	while($r = $db -> fetchRow($query)){
		$listcats[$r['parentid']]['children'][$r['catid']]['catid'] = $r['catid'];
		$listcats[$r['parentid']]['children'][$r['catid']]['catname'] = $r['catname'];
		$listcats[$r['parentid']]['children'][$r['catid']]['color'] = $r['color'];
		$listcats[$r['parentid']]['children'][$r['catid']]['caturi'] =  Rewrite('category',array('catid'=>$r['catid'],'dir_typename'=>$r['dir_typename']));
	}
	
	return $listcats;
}

function select_where($table,$name='parentid',$currentid='',$parentid=''){
	global $db,$db_mymps;
	if($parentid){
		switch($table){
			case 'area':
				$rs = get_city_caches($parentid);
				$rs = $rs['area'];
				if(is_array($rs)){
					foreach($rs as $k => $v){
						$currentidk = $currentid == $v['areaid'] ?" selected ":" ";
						$view .= "<option value='$v[areaid]' $currentidk>$v[areaname]</option>";
					}
				}
			break;
			case 'street':
				$cityid = $db -> getOne("SELECT cityid FROM `{$db_mymps}area` WHERE areaid = '$parentid'");
				$rs = get_city_caches($cityid);
				$rs = $rs['area'][$parentid]['street'];
				foreach($rs as $k => $v){
					$currentidk= $currentid == $v['streetid'] ?" selected ":" ";
					$view .= "<option value='$v[streetid]' $currentidk>$v[streetname]</option>";
				}
			break;
		}
		
		return $view ? "<select class='input' style='width:140px' id='$table' name=$name><option value=''>请选择</option>$view</select>" : "";
		
	}
}

//获得三级联动select
function select_where_option($actionfile,$cityid,$areaid,$streetid){
	$actionfile = empty($actionfile) ? $mymps_global[SiteUrl].'/include/selectwhere.php' : $actionfile;
	$mymps .= '<select id=\'cityid\' name=\'cityid\'  onChange="choose_where(\'getarea\',this.options[this.selectedIndex].value,\'\',\'1\')"  class="input" style="width:140px!important" require="true" datatype="limit" msgid="地区" msg="请选择所在分站">
<option value=\'\'  selected >请选择所在分站</option>';
	$mymps .= get_cityoptions($cityid);
	$mymps .= '</select>
<span id="showarea"></span>&nbsp;<span id="showstreet"></span>';
	$mymps .= '<SCRIPT LANGUAGE="JavaScript">
<!--
function choose_where(t,parentid,currentid,delstreet){
';
	$mymps .= "
	if(t=='getarea'){
		url='".$actionfile."?action=getarea&parentid='+parentid+'&currentid='+currentid+'&delstreet='+delstreet;
		target='iframe_area';
	}else{
		url='".$actionfile."?action=getstreet&parentid='+parentid+'&currentid='+currentid;
		target='iframe_street';
	}
	document.getElementById('form_area').action=url;
	document.getElementById('form_area').target=target;
	document.getElementById('form_area').submit();
	}
	";
	$mymps .= $cityid ? 'choose_where("getarea","'.$cityid.'","'.$areaid.'","1");' : '';
	$mymps .= ($cityid && $areaid) ? 'choose_where("getstreet","'.$areaid.'","'.$streetid.'","0");' : '';
	$mymps .= '
//-->
</SCRIPT>
	';
	return $mymps;
}

function ip2city($ip) {
	global $charset;
	if(!preg_match("/^\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}$/", $ip)) {
		return '';
	}
	if($fd = @fopen(MYMPS_DATA.'/ipdat/ipdata.dat', 'rb')) {

		$ip = explode('.', $ip);
		$ipNum = $ip[0] * 16777216 + $ip[1] * 65536 + $ip[2] * 256 + $ip[3];

		$DataBegin = fread($fd, 4);
		$DataEnd = fread($fd, 4);
		$ipbegin = implode('', unpack('L', $DataBegin));
		if($ipbegin < 0) $ipbegin += pow(2, 32);
		$ipend = implode('', unpack('L', $DataEnd));
		if($ipend < 0) $ipend += pow(2, 32);
		$ipAllNum = ($ipend - $ipbegin) / 7 + 1;

		$BeginNum = 0;
		$EndNum = $ipAllNum;

		while($ip1num > $ipNum || $ip2num < $ipNum) {
			$Middle= intval(($EndNum + $BeginNum) / 2);

			fseek($fd, $ipbegin + 7 * $Middle);
			$ipData1 = fread($fd, 4);
			if(strlen($ipData1) < 4) {
				fclose($fd);
				return '- System Error';
			}
			$ip1num = implode('', unpack('L', $ipData1));
			if($ip1num < 0) $ip1num += pow(2, 32);

			if($ip1num > $ipNum) {
				$EndNum = $Middle;
				continue;
			}

			$DataSeek = fread($fd, 3);
			if(strlen($DataSeek) < 3) {
				fclose($fd);
				return '- System Error';
			}
			$DataSeek = implode('', unpack('L', $DataSeek.chr(0)));
			fseek($fd, $DataSeek);
			$ipData2 = fread($fd, 4);
			if(strlen($ipData2) < 4) {
				fclose($fd);
				return '- System Error';
			}
			$ip2num = implode('', unpack('L', $ipData2));
			if($ip2num < 0) $ip2num += pow(2, 32);

			if($ip2num < $ipNum) {
				if($Middle == $BeginNum) {
					fclose($fd);
					return '- Unknown';
				}
				$BeginNum = $Middle;
			}
		}

		$ipFlag = fread($fd, 1);
		if($ipFlag == chr(1)) {
			$ipSeek = fread($fd, 3);
			if(strlen($ipSeek) < 3) {
				fclose($fd);
				return '- System Error';
			}
			$ipSeek = implode('', unpack('L', $ipSeek.chr(0)));
			fseek($fd, $ipSeek);
			$ipFlag = fread($fd, 1);
		}

		if($ipFlag == chr(2)) {
			$AddrSeek = fread($fd, 3);
			if(strlen($AddrSeek) < 3) {
				fclose($fd);
				return '- System Error';
			}
			$ipFlag = fread($fd, 1);
			if($ipFlag == chr(2)) {
				$AddrSeek2 = fread($fd, 3);
				if(strlen($AddrSeek2) < 3) {
					fclose($fd);
					return '- System Error';
				}
				$AddrSeek2 = implode('', unpack('L', $AddrSeek2.chr(0)));
				fseek($fd, $AddrSeek2);
			} else {
				fseek($fd, -1, SEEK_CUR);
			}

			while(($char = fread($fd, 1)) != chr(0))
				$ipAddr2 .= $char;

			$AddrSeek = implode('', unpack('L', $AddrSeek.chr(0)));
			fseek($fd, $AddrSeek);

			while(($char = fread($fd, 1)) != chr(0))
				$ipAddr1 .= $char;
		} else {
			fseek($fd, -1, SEEK_CUR);
			while(($char = fread($fd, 1)) != chr(0))
				$ipAddr1 .= $char;

			$ipFlag = fread($fd, 1);
			if($ipFlag == chr(2)) {
				$AddrSeek2 = fread($fd, 3);
				if(strlen($AddrSeek2) < 3) {
					fclose($fd);
					return '- System Error';
				}
				$AddrSeek2 = implode('', unpack('L', $AddrSeek2.chr(0)));
				fseek($fd, $AddrSeek2);
			} else {
				fseek($fd, -1, SEEK_CUR);
			}
			while(($char = fread($fd, 1)) != chr(0))
				$ipAddr2 .= $char;
		}
		fclose($fd);

		if(preg_match('/http/i', $ipAddr2)) {
			$ipAddr2 = '';
		}
		$ipaddr = "$ipAddr1 $ipAddr2";
		$ipaddr = preg_replace('/CZ88\.NET/is', '', $ipaddr);
		$ipaddr = preg_replace('/^\s*/is', '', $ipaddr);
		$ipaddr = preg_replace('/\s*$/is', '', $ipaddr);
		if(preg_match('/http/i', $ipaddr) || $ipaddr == '') {
			$ipaddr = '- Unknown';
		}
		return ''.($charset == 'utf-8' ? iconv('gbk','UTF-8',$ipaddr) : $ipaddr);
	}
}

/**获取用户的来源城市**/
function get_ip2city($ip){
	global $db,$db_mymps;
	$area = ip2city($ip);
	if(is_array($all_cities = get_allcities())){
		foreach($all_cities as $k => $v){
			$v['cityname']=str_replace(array("市","区"," "),array("","",""),$v['cityname']);
			if(@strstr($area,$v['cityname'])){
				return $v;
			}
		}
	}
}

function get_latlng2cityid($lat='',$lng=''){
	global $db,$db_mymps,$charset;
	if($lat && $lng){
		$array = json_decode(file_get_contents("http://api.map.baidu.com/geocoder?output=json&location=$lat,$lng"),true);
		$city = $charset == 'gbk' ? iconv('UTF-8','GBK',$array['result']['addressComponent']['city']) : $array['result']['addressComponent']['city'];
		$city = str_replace(array('市','区'),array('',''),$city);
		if(is_array($all_cities = get_allcities())){
			foreach($all_cities as $k => $v){
				if($city == $v['cityname']){
					return $v['cityid'];
				}
			}
		}
	}
}

/*获得浏览器版本信息*/
function getbrowser() {  
    global $_SERVER;  
    $agent  = $_SERVER['HTTP_USER_AGENT'];  
    $browser  = '';  
    $browser_ver  = '';
  
    if (preg_match('/OmniWeb\/(v*)([^\s|;]+)/i', $agent, $regs)) {  
      $browser  = 'OmniWeb';  
      $browser_ver   = $regs[2];  
    }elseif (preg_match('/Netscape([\d]*)\/([^\s]+)/i', $agent, $regs)) {  
      $browser  = 'Netscape';  
      $browser_ver   = $regs[2];  
    }elseif (preg_match('/Chrome\/([^\s]+)/i', $agent, $regs)) {  
      $browser  = 'Chrome';
      $browser_ver   = $regs[1];  
    }elseif (preg_match('/safari\/([^\s]+)/i', $agent, $regs)) {  
      $browser  = 'Safari';
      $browser_ver   = $regs[1];
    }elseif (preg_match('/MSIE\s([^\s|;]+)/i', $agent, $regs)) {  
      $browser  = 'Internet Explorer';  
      $browser_ver   = $regs[1];  
    }elseif (preg_match('/Opera[\s|\/]([^\s]+)/i', $agent, $regs)) {  
      $browser  = 'Opera';  
      $browser_ver   = $regs[1];  
    }elseif (preg_match('/NetCaptor\s([^\s|;]+)/i', $agent, $regs)) {  
      $browser  = '(Internet Explorer ' .$browser_ver. ') NetCaptor';  
      $browser_ver   = $regs[1];  
    }elseif (preg_match('/Maxthon/i', $agent, $regs)) {  
      $browser  = '(Internet Explorer ' .$browser_ver. ') Maxthon';  
      $browser_ver   = '';  
    }elseif (preg_match('/360SE/i', $agent, $regs)) {  
      $browser       = '(Internet Explorer ' .$browser_ver. ') 360SE';
      $browser_ver   = '';  
    }elseif (preg_match('/SE 2.x/i', $agent, $regs)) {  
      $browser       = '(Internet Explorer ' .$browser_ver. ') 搜狗';  
      $browser_ver   = '';  
    }elseif (preg_match('/FireFox\/([^\s]+)/i', $agent, $regs)) {  
      $browser  = 'FireFox';  
      $browser_ver   = $regs[1];  
    }elseif (preg_match('/Lynx\/([^\s]+)/i', $agent, $regs)) {  
      $browser  = 'Lynx';  
      $browser_ver   = $regs[1];  
    }  
  
    if ($browser != '') {  
       return $browser.' '.$browser_ver;  
    }  
    else {  
      return '未知浏览器版本';
    }  
}

/*获得操作系统信息*/
function getos() {
    $agent = $_SERVER['HTTP_USER_AGENT'];  
    $os = false;  
    if (@eregi('win', $agent) && strpos($agent, '95')) {  
      $os = 'Windows 95';  
    }else if (@eregi('win 9x', $agent) && strpos($agent, '4.90')) {  
      $os = 'Windows ME';  
    }else if (@eregi('win', $agent) && @ereg('98', $agent)) {  
      $os = 'Windows 98';  
    }else if (@eregi('win', $agent) && @eregi('nt 5.1', $agent)) {  
      $os = 'Windows XP';  
    }else if (@eregi('win', $agent) && @eregi('nt 5', $agent)) {  
      $os = 'Windows 2000';  
    }else if (@eregi('win', $agent) && @eregi('nt', $agent)) {  
      $os = 'Windows NT';  
    }else if (@eregi('win', $agent) && @ereg('32', $agent)) {  
      $os = 'Windows 32';  
    }else if (@eregi('linux', $agent)) {  
      $os = 'Linux';  
    }else if (@eregi('unix', $agent)) {  
      $os = 'Unix';  
    }else if (@eregi('sun', $agent) && @eregi('os', $agent)) {  
      $os = 'SunOS';  
    }else if (@eregi('ibm', $agent) && @eregi('os', $agent)) {  
      $os = 'IBM OS/2';  
    }else if (@eregi('Mac', $agent) && @eregi('PC', $agent)) {  
      $os = 'Macintosh';  
    }else if (@eregi('PowerPC', $agent)) {  
      $os = 'PowerPC';  
    }else if (@eregi('AIX', $agent)) {  
      $os = 'AIX';  
    }else if (@eregi('HPUX', $agent)) {  
      $os = 'HPUX';  
    }else if (@eregi('NetBSD', $agent)) {  
      $os = 'NetBSD';  
    }else if (@eregi('BSD', $agent)) {  
      $os = 'BSD';  
    }else if (@ereg('OSF1', $agent)) {  
      $os = 'OSF1';  
    }else if (@ereg('IRIX', $agent)) {
      $os = 'IRIX';  
    }else if (@eregi('FreeBSD', $agent)) {  
      $os = 'FreeBSD';  
    }else if (@eregi('teleport', $agent)) {  
      $os = 'teleport';  
    }else if (@eregi('flashget', $agent)) {  
      $os = 'flashget';  
    }else if (@eregi('webzip', $agent)) {  
      $os = 'webzip';  
    }else if (@eregi('offline', $agent)) {  
      $os = 'offline';  
    }else{  
      $os = 'Unknown';  
    }  
    return $os;
}

function getport(){
	global $mymps_global;
	
	$port = $_SERVER['REMOTE_PORT'];
	if($port == 0 || trim($port)=="" || $port == NULL){
		$port = file_get_contents($mymps_global['SiteUrl']."/include/port.asp");
	}
	return $port;
}

function is_robot(){
    $ua = strtolower($_SERVER['HTTP_USER_AGENT']);
    if(!empty($ua)){
        $spiderAgentArr = array(
            "Baiduspider",
            "Googlebot",
            "360Spider",
            "Sosospider",
            "sogou spider"
        );
        foreach($spiderAgentArr as $val){
            $spiderAgent = strtolower($val);
            if(strpos($ua, $spiderAgent) !== false){
                return true;
            }
        }
        return false;
    } else {
        return false;
    }
}

function strexists($haystack, $needle) {
	return !(strpos($haystack, $needle) === FALSE);
}
?>