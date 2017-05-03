var n = 0;
function displayHTML(obj) {
	win = window.open(" ", 'popup', 'toolbar = no, status = no, scrollbars=yes');
	win.document.write("" + obj.value + "");
}
function HighlightAll(obj) {
	obj.focus();
	obj.select();
	if(document.all) {
		obj.createTextRange().execCommand("Copy");
		window.status = "将模板内容复制到剪贴板";
		setTimeout("window.status=''", 1800);
	}
}
function findInPage(obj, str, noalert) {
	var txt, i, found;
	if(str == "") {
		return false;
	}
	if(document.layers) {
		if(!obj.find(str)) {
			while(obj.find(str, false, true)) {
				n++;
			}
		} else {
			n++;
		}
		if(n == 0 && !noalert) {
			alert("未找到指定字串。");
		}
	}
	if(document.all) {
		txt = obj.createTextRange();
		for(i = 0; i <= n && (found = txt.findText(str)) != false; i++) {
			txt.moveStart('character', 1);
			txt.moveEnd('textedit');
		}
		if(found) {
			txt.moveStart('character', -1);
			txt.findText(str);
			txt.select();
			txt.scrollIntoView();
			n++;
			return true;
		} else {
			if(n > 0) {
				n = 0;
				findInPage(obj, str, noalert);
			} else if(!noalert) {
				alert("未找到指定字串。");
			}
		}
	}
	return false;
}// JavaScript Document