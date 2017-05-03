<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv='Content-Type' content='text/html; charset=gbk'>
<title><?=$here?>  - powered by <?=MPS_SOFTNAME?></title>
<link href='template/css/<?=MPS_SOFTNAME?>.css' rel='stylesheet' type='text/css'>
<script type='text/javascript' src='../template/global/noerr.js'></script>
<script src="js/jquery.172.min.js" type="text/javascript"></script>
<script language="javascript">
var current_domain = '<?php echo $mymps_global[SiteUrl]; ?>';
ifcheck = true;
function AllCheck(type, form, value, checkall, changestyle) {
	var checkall = checkall ? checkall : 'chkall';
	for (var i = 0; i < form.elements.length; i++) {
		var e = form.elements[i];
		if (type == 'option' && e.type == 'radio' && e.value == value && e.disabled != true) {
			e.checked = true;
		} else if (type == 'value' && e.type == 'checkbox' && e.getAttribute('chkvalue') == value) {
			e.checked = form.elements[checkall].checked;
		} else if (type == 'prefix' && e.name && e.name != checkall && (!value || (value && e.name.match(value)))) {
			e.checked = form.elements[checkall].checked;
			if (changestyle && e.parentNode && e.parentNode.tagName.toLowerCase() == 'li') {
				e.parentNode.className = e.checked ? 'checked' : '';
			}
		}
	}
}

function CheckAll(form) {
	for (var i = 0; i < form.elements.length - 1; i++) {
		var e = form.elements[i];
		if (e.type == 'checkbox') {
			e.checked = ifcheck;
		}
	}
	ifcheck = ifcheck == false ? true : false;
}

function doane(event) {
	e = event ? event : window.event;
	if (is_ie) {
		e.returnValue = false;
		e.cancelBubble = true;
	} else if (e) {
		e.stopPropagation();
		e.preventDefault();
	}
}

function fetchCheckbox(cbn) {
	return $obj(cbn) && $obj(cbn).checked == true ? 1 : 0;
}

function $obj(id) {
	return document.getElementById(id);
}


function $$(obj){
	return parent.document.getElementById(obj);
}

function ascreen(){
	if($$('adminheader').style.display==''){
		fullscreen();
	} else if($$('adminheader').style.display=='none'){
		wrapscreen();
	}
}
function fullscreen(){
	$$('adminheader').style.display='none';
	$$('adminlefter').style.display='none';
	$obj('href').href='javascript:wrapscreen();';
}
function wrapscreen(){
	$$('adminheader').style.display='';
	$$('adminlefter').style.display='';
	$obj('href').href='javascript:fullscreen();';
}
</script>
<script type="text/javascript" src="../template/global/messagebox.js"></script>
</head>
<body>
<div class='bodytitle'>
    <div class='bodytitleleft'></div>
    <div class='bodytitletxt'><?=$here?></div>
    <div class='bodytitleright'></div>
    <div class='iicon'>
    <a href='javascript:window.location.reload();'>刷新</a>
    <a href='javascript:history.back();'>后退</a>
    <a href='javascript:history.go(1);'>前进</a>
	<a href='javascript:ascreen();' id="href">全屏</a>
    </div>
</div>
<div class="clear"></div>
<div style="margin-left:10px; margin-top:5px;margin-right:10px;">