var collapsed=getcookie('TvE_collapse');function collapse_change(menucount){if($obj('menu_'+menucount).style.display=='none'){$obj('menu_'+menucount).style.display='';collapsed=collapsed.replace('['+menucount+']','');$obj('menuimg_'+menucount).src='template/images/menu_reduce.gif';}else{$obj('menu_'+menucount).style.display='none';collapsed+='['+menucount+']';$obj('menuimg_'+menucount).src='template/images/menu_add.gif';}
setcookie('TvE_collapse',collapsed,2592000);}
var lang=new Array();var userAgent=navigator.userAgent.toLowerCase();var is_opera=userAgent.indexOf('opera')!=-1&&opera.version();var is_moz=(navigator.product=='Gecko')&&userAgent.substr(userAgent.indexOf('firefox')+8,3);var is_ie=(userAgent.indexOf('msie')!=-1&&!is_opera)&&userAgent.substr(userAgent.indexOf('msie')+5,3);
Array.prototype.push=function(value){this[this.length]=value;return this.length;}
function AllCheck(type,form,value,checkall,changestyle){var checkall=checkall?checkall:'chkall';for(var i=0;i<form.elements.length;i++){var e=form.elements[i];if(type=='option'&&e.type=='radio'&&e.value==value&&e.disabled!=true){e.checked=true;}else if(type=='value'&&e.type=='checkbox'&&e.getAttribute('chkvalue')==value){e.checked=form.elements[checkall].checked;}else if(type=='prefix'&&e.name&&e.name!=checkall&&(!value||(value&&e.name.match(value)))){e.checked=form.elements[checkall].checked;if(changestyle&&e.parentNode&&e.parentNode.tagName.toLowerCase()=='li'){e.parentNode.className=e.checked?'checked':'';}}}}
function CheckAll(form)
{for(var i=0;i<form.elements.length-1;i++)
{var e=form.elements[i];if(e.type=='checkbox'){e.checked=ifcheck;}}
ifcheck=ifcheck==false?true:false;}
function doane(event){e=event?event:window.event;if(is_ie){e.returnValue=false;e.cancelBubble=true;}else if(e){e.stopPropagation();e.preventDefault();}}
function fetchCheckbox(cbn){return $obj(cbn)&&$obj(cbn).checked==true?1:0;}
function getcookie(name){var cookie_start=document.cookie.indexOf(name);var cookie_end=document.cookie.indexOf(";",cookie_start);return cookie_start==-1?'':unescape(document.cookie.substring(cookie_start+name.length+1,(cookie_end>cookie_start?cookie_end:document.cookie.length)));}
function thumbImg(obj){var zw=obj.width;var zh=obj.height;if(is_ie&&zw==0&&zh==0){var matches
re=/width=(["']?)(\d+)(\1)/i
matches=re.exec(obj.outerHTML);zw=matches[2];re=/height=(["']?)(\d+)(\1)/i
matches=re.exec(obj.outerHTML);zh=matches[2];}
obj.resized=true;obj.style.width=zw+'px';obj.style.height='auto';if(obj.offsetHeight>zh){obj.style.height=zh+'px';obj.style.width='auto';}
if(is_ie){var imgid='img_'+Math.random();obj.id=imgid;setTimeout('try {if ($obj(\''+imgid+'\').offsetHeight > '+zh+') {$obj(\''+imgid+'\').style.height = \''+zh+'px\';$obj(\''+imgid+'\').style.width = \'auto\';}} catch(e){}',1000);}
obj.onload=null;}
function imgzoom(obj){}
function in_array(needle,haystack){if(typeof needle=='string'||typeof needle=='number'){for(var i in haystack){if(haystack[i]==needle){return true;}}}
return false;}
function setcopy(text,alertmsg){if(is_ie){clipboardData.setData('Text',text);alert(alertmsg);}else if(prompt('Press Ctrl+C Copy to Clipboard',text)){alert(alertmsg);}}
function isUndefined(variable){return typeof variable=='undefined'?true:false;}
function mb_strlen(str){var len=0;for(var i=0;i<str.length;i++){len+=str.charCodeAt(i)<0||str.charCodeAt(i)>255?(charset=='utf-8'?3:2):1;}
return len;}
function setcookie(cookieName,cookieValue,seconds,path,domain,secure){var expires=new Date();expires.setTime(expires.getTime()+seconds);document.cookie=escape(cookieName)+'='+escape(cookieValue)
+(expires?'; expires='+expires.toGMTString():'')
+(path?'; path='+path:'/')
+(domain?'; domain='+domain:'')
+(secure?'; secure':'');}
function strlen(str){return(is_ie&&str.indexOf('\n')!=-1)?str.replace(/\r?\n/g,'_').length:str.length;}
function updatestring(str1,str2,clear){str2='_'+str2+'_';return clear?str1.replace(str2,''):(str1.indexOf(str2)==-1?str1+str2:str1);}
function toggle_collapse(objname,noimg){var obj=$obj(objname);obj.style.display=obj.style.display==''?'none':'';if(!noimg){var img=$obj(objname+'_img');img.src=img.src.indexOf('_yes.gif')==-1?img.src.replace(/_no\.gif/,'_yes\.gif'):img.src.replace(/_yes\.gif/,'_no\.gif')}
var collapsed=getcookie('mymps_collapse');collapsed=updatestring(collapsed,objname,!obj.style.display);setcookie('mymps_collapse',collapsed,(collapsed?86400*30:-(86400*30*1000)));}
function trim(str){return(str+'').replace(/(\s+)$/g,'').replace(/^\s+/g,'');}
function updateseccode(){type=seccodedata[2];var rand=Math.random();if(type==2){$obj('seccodeimage').innerHTML='<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0" width="'+seccodedata[0]+'" height="'+seccodedata[1]+'" align="middle">'
+'<param name="allowScriptAccess" value="sameDomain" /><param name="movie" value="seccode.php?update='+rand+'" /><param name="quality" value="high" /><param name="wmode" value="transparent" /><param name="bgcolor" value="#ffffff" />'
+'<embed src="seccode.php?update='+rand+'" quality="high" wmode="transparent" bgcolor="#ffffff" width="'+seccodedata[0]+'" height="'+seccodedata[1]+'" align="middle" allowScriptAccess="sameDomain" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" /></object>';}else{$obj('seccodeimage').innerHTML='<img id="seccode" onclick="updateseccode()" width="'+seccodedata[0]+'" height="'+seccodedata[1]+'" src="seccode.php?update='+rand+'" class="absmiddle" alt="" />';}}
function updatesecqaa(){var x=new Ajax();x.get('ajax.php?action=updatesecqaa&inajax=1',function(s){$obj('secquestion').innerHTML=s;});}
function _attachEvent(obj,evt,func){if(obj.addEventListener){obj.addEventListener(evt,func,false);}else if(obj.attachEvent){obj.attachEvent("on"+evt,func);}}
function $obj(id)
{return document.getElementById(id);}
ifcheck=true;function addMouseEvent(obj){var checkbox,atr,ath,i;atr=obj.getElementsByTagName("tr");for(i=0;i<atr.length;i++){atr[i].onclick=function(){ath=this.getElementsByTagName("th");checkbox=this.getElementsByTagName("input")[0];if(!ath.length&&checkbox.getAttribute("type")=="checkbox"){if(this.className!="IptIn"){this.className="IptIn";checkbox.checked=true;}else{this.className="";checkbox.checked=false;}}}}}
function showdiv(divname){var div3=document.getElementById(divname);div3.style.display="block";div3.style.left=event.clientX+10;div3.style.top=event.clientY+5;div3.style.position="absolute";}
function closediv(divname){var div3=document.getElementById(divname);div3.style.display="none";}