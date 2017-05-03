var Browser=new Object();Browser.isMozilla=(typeof document.implementation!='undefined')&&(typeof document.implementation.createDocument!='undefined')&&(typeof HTMLDocument!='undefined');Browser.isIE=window.ActiveXObject?true:false;Browser.isFirefox=(navigator.userAgent.toLowerCase().indexOf("firefox")!=-1);Browser.isSafari=(navigator.userAgent.toLowerCase().indexOf("safari")!=-1);Browser.isOpera=(navigator.userAgent.toLowerCase().indexOf("opera")!=-1);var Common=new Object();Common.htmlEncode=function(str)
{return str.replace(/&/g,'&amp;').replace(/"/g,'&quot;').replace(/</g,'&lt;').replace(/>/g,'&gt;');}
Common.trim=function(str)
{return str.replace(/(^\s*)|(\s*$)/g,"");}
Common.strlen=function(str)
{if(Browser.isFirefox)
{Charset=document.characterSet;}
else
{Charset=document.charset;}
if(Charset.toLowerCase()=='utf-8')
{return str.replace(/[\u4e00-\u9fa5]/g,"***").length;}
else
{return str.replace(/[^\x00-\xff]/g,"**").length;}}
Common.isdate=function(str)
{var result=str.match(/^(\d{4})(-|\/)(\d{1,2})\2(\d{1,2})$/);if(result==null)return false;var d=new Date(result[1],result[3]-1,result[4]);return(d.getFullYear()==result[1]&&d.getMonth()+1==result[3]&&d.getDate()==result[4]);}
Common.isnumber=function(val)
{var reg=/[\d|\.|,]+/;return reg.test(val);}
Common.isalphanumber=function(str)
{var result=str.match(/^[a-zA-Z0-9]+$/);if(result==null)return false;return true;}
Common.isint=function(val)
{var reg=/\d+/;return reg.test(val);}
Common.isemail=function(email)
{var reg=/([\w|_|\.|\+]+)@([-|\w]+)\.([A-Za-z]{2,4})/;return reg.test(email);}
Common.fixeventargs=function(e)
{var evt=(typeof e=="undefined")?window.event:e;return evt;}
Common.srcelement=function(e)
{if(typeof e=="undefined")e=window.event;var src=document.all?e.srcElement:e.target;return src;}
Common.isdatetime=function(val)
{var result=str.match(/^(\d{4})(-|\/)(\d{1,2})\2(\d{1,2}) (\d{1,2}):(\d{1,2}):(\d{1,2})$/);if(result==null)return false;var d=new Date(result[1],result[3]-1,result[4],result[5],result[6],result[7]);return(d.getFullYear()==result[1]&&(d.getMonth()+1)==result[3]&&d.getDate()==result[4]&&d.getHours()==result[5]&&d.getMinutes()==result[6]&&d.getSeconds()==result[7]);}
var FileNum=1;function AddInputFile(Field)
{FileNum++;var fileTag="<div id='file_"+FileNum+"'><input type='file' name='"+Field+"["+FileNum+"]' size='20' onchange='javascript:AddInputFile(\""+Field+"\")'> <input type='text' name='"+Field+"_description["+FileNum+"]' size='20' title='名称'> <input type='button' value='删除' name='Del' onClick='DelInputFile("+FileNum+");'></div>";var fileObj=document.createElement("div");fileObj.id='file_'+FileNum;fileObj.innerHTML=fileTag;document.getElementById("file_div").appendChild(fileObj);}
function DelInputFile(FileNum)
{var DelObj=document.getElementById("file_"+FileNum);document.getElementById("file_div").removeChild(DelObj);}
function FilePreview(Url,IsShow)
{Obj=document.getElementById('FilePreview');if(IsShow)
{Obj.style.left=event.clientX+80;Obj.style.top=event.clientY+20;Obj.innerHTML="<img src='"+Url+"'>";Obj.style.display='block';}
else
{Obj.style.display='none';}}
function setEditorSize(editorID,flag)
{var minHeight=400;var step=150;var e=$('#'+editorID);var h=parseInt(e.height());if(!flag&&h<minHeight)
{e.height(200);return;}
return flag?(e.height(h+step)):(e.height(h-step));}
function EditorSize(editorID)
{$('a[action]').parent('div').css({'text-align':'right'});$('a[action]').css({'font-size':'24px','font-weight':700,display:'block',float:'right',width:'28px','text-align':'center'});$('a[action]').click(function(){var flag=parseInt($(this).attr('action'));setEditorSize(editorID,flag);});}
function modal(url,triggerid,id,type)
{id='#'+id;triggerid='#'+triggerid;switch(type)
{case'ajax':$(id).jqm({ajax:url,modal:false,trigger:triggerid});break;default:$(id).jqm();break;}
$(id).html('');$(id).hide();}
function menu_selected(id)
{$('#menu_'+id).addClass('selected');}
function is_ie()
{if(!$.browser.msie)
{$("body").prepend('<div id="MM_msie" style="border:#FF7300 solid 1px;padding:10px;color:#FF0000">本功能只支持IE浏览器，请用IE浏览器打开。<div>');}}
function select_catids()
{$('#addbutton').attr('disabled','');}
function transact(update,fromfiled,tofiled)
{if(update=='delete')
{var fieldvalue=$('#'+tofiled).val();$("select[@id="+tofiled+"] option").each(function()
{if($(this).val()==fieldvalue){$(this).remove();}});}
else
{var fieldvalue=$('#'+fromfiled).val();var have_exists=0;var len=$("select[@id="+tofiled+"] option").length;if(len>5)
{alert('最多添加 6 项');return false;}
$("select[@id="+tofiled+"] option").each(function()
{if($(this).val()==fieldvalue){have_exists=1;alert('已经添加到列表中');return false;}});if(have_exists==0)
{fieldvalue="<option value='"+fieldvalue+"'>"+fieldvalue+"</option>"
$('#'+tofiled).append(fieldvalue);$('#deletebutton').attr('disabled','');}}}
var set_show=false;