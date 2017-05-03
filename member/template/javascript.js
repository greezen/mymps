function $obj(id) {
	return document.getElementById(id);
}

function setButtonDisable(b,c){
	var d=$obj(b);
	if(d)if(!c&&arguments.length==2)window.setTimeout("setButtonDisable('"+b+"',false,0);",40);
	else{
		d.disabled=c;d=d.parentNode.parentNode;var e="";if(d.className.indexOf("minbtn-wrap")>-1)e="minbtn-disable";else if(d.className.indexOf("btn-wrap")>-1)e="btn-disable";
		if(e)c?addCssClass(d,e):removeCssClass(d,e)
	}
}

function noneblock(targetid){
	var ifview = document.getElementsByTagName("a");
    var target = document.getElementById(targetid);
	
	target.style.display = target.style.display == 'none' ? 'block' : 'block';
}

function CleanHtml(content)
{
  	content = content.replace(/<p>/gi,"\n\r");
	content = content.replace(/<br>/gi,"\n");
	content = content.replace(/&nbsp;/gi," ");
  	content = content.replace(/(<(meta|iframe|frame|span|tbody|layer)[^>]*>|<\/(iframe|frame|meta|span|tbody|layer)>)/gi, "");
  	content = content.replace(/<\\?\?xml[^>]*>/gi, "") ;
  	content = content.replace(/o:/gi, "");
  	content = content.replace(/ /gi, " ");
	return content;
}

function AvatarSubmit()
{
	if(document.form1.mymps_member_logo.value=="")
	{
   		document.form1.mymps_member_logo.focus();
   		alert("请选择你要上传的文件！");
   		return false;
	}
}

function CertifySubmit()
{
	if(document.form1.certify_image.value=="")
	{
   		document.form1.certify_image.focus();
   		alert("请选择你要上传的文件！");
   		return false;
	}
}

function AlbumSubmit(){
	if(document.form1.title.value=="")
	{
   		document.form1.title.focus();
   		alert("相片标题不能为空！");
   		return false;
	} else if(document.form1.album_up.value==""){
   		document.form1.album_up.focus();
   		alert("请选择你要上传的文件！");
   		return false;
	}
}

function SeePic(img,f){
   if ( f.value != "" ) { img.src = f.value; }
}

function CheckAll(form)
{
	for (var i=0;i<form.elements.length-1;i++)
	{
		var e = form.elements[i];
		if( e.type == 'checkbox'){
			e.checked = ifcheck;
		}
	}
	ifcheck = ifcheck == false ? true : false;
}

ifcheck = true;