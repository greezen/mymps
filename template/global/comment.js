function checkreply()
{if(document.form1.content.value=="")
{document.form1.content.focus();alert("请填写评论内容！");return false;}
if(document.form1.checkcode.value=="")
{document.form1.checkcode.focus();alert("请输入验证码！");return false;}
document.form1.mymps.disabled=true;document.form1.mymps.value="提交中...";return true;}