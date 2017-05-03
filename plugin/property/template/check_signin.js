function qq_msn(value){
	window.clipboardData.setData("Text",value); 
	alert("复制URL地址成功，请粘贴到你的QQ/MSN上推荐给你的好友");
}
function checkbaoming(){
	if (document.form1.sname.value=="") {
		alert('请填写您的真实姓名!');
		document.form1.sname.focus();
		return false;
	}
	if (document.form1.tel.value=="") {
		alert('请输入联系电话，建议填写手机！');
		document.form1.tel.focus();
		return false;
	}
	if (document.form1.checkcode.value=="") {
		alert('请输入验证码！');
		document.form1.checkcode.focus();
		return false;
	}
	return true;
}