function article_list(cookieName,a_title){
 
 var isdone="none";
    if(GetCookie("EMARTICLE9")!=null){    
 for(i=0;i<10;i++){                            
   arr_temp_check=GetCookie("EMARTICLE"+i).split("@#$");
    if(arr_temp_check.length>1){                 
   temp_check=arr_temp_check[1];  
 
   arr_a_title=a_title.split("@#$")
   temp_arr_a_title=arr_a_title[0];  
   
   if(temp_check==temp_arr_a_title){  
    SetCookie("EMARTICLE"+i,a_title);
    isdone="ok";
    //break;
    }
   }
  }
}

  if(isdone=="none"){
   replacecookie(cookieName,a_title);
   new_article=GetCookie(cookieName);
   for(i=0;i<9;i++){
    k=i+1;
     //if(GetCookie('EMARTICLE'+k)==null){str_replace=""}else{str_replace=GetCookie('EMARTICLE'+k)}
    replacecookie("EMARTICLE"+i,GetCookie('EMARTICLE'+k)); 
   }
     SetCookie("EMARTICLE9",new_article);
  }

} 
 
function SetCookie(cookieName,a_title) {
   var c_time=new Date();
   var s_month=(c_time.getMonth()+1).toString();
   var s_day=c_time.getDate().toString();
   var s_hour=c_time.getHours().toString();
   var s_minutes=c_time.getMinutes().toString();
   var s_seconds=c_time.getSeconds().toString();
   
   if(s_month.length<2){s_month="0"+s_month;}
   if(s_day.length<2){s_day="0"+s_day;}
   if(s_hour.length<2){s_hour="0"+s_hour;}
   if(s_minutes.length<2){s_minutes="0"+s_minutes;}
   if(s_seconds.length<2){s_seconds="0"+s_seconds;}
    
    var strtime=s_month+"-"+s_day+" "+s_hour+":"+s_minutes+":"+s_seconds
    var expires = new Date ();
    
    expires.setTime(expires.getTime() + 31 * (24 * 60 * 60 * 1000));
   // document.cookie = cookieName + "=" + strtime+ "@#$"+escape(a_title) +"; expires=" + expires.toGMTString();
   document.cookie = cookieName + "=" + strtime+ "@#$"+escape(a_title) +"; expires=" + expires.toGMTString();
} 

function replacecookie(cookieName,a_title){
    var expires = new Date ();
    expires.setTime(expires.getTime() + 31 * (24 * 60 * 60 * 1000));
    document.cookie = cookieName + "=" + escape(a_title)+"; expires=" + expires.toGMTString();;
}

function GetCookie(name) {
    var dc = document.cookie;
    var prefix = name + "=";
    var begin = dc.indexOf("; " + prefix);
    if (begin == -1)
    {
        begin = dc.indexOf(prefix);
        if (begin != 0) return null;
    }
    else
    {
        begin += 2;
    }
    var end = document.cookie.indexOf(";", begin);
    if (end == -1)
    {
        end = dc.length;
    }
    return unescape(dc.substring(begin + prefix.length, end));
} 

function clearCookie(){ 
	var keys=document.cookie.match(/[^ =;]+(?=\=)/g); 
	if (keys) { 
		for (var i = keys.length; i--;){
			document.cookie=keys[i]+'=0;expires=' + new Date( 0).toUTCString();
		}
	}
}
  

article_list('EMARTICLE0',document.title+'@#$'+window.location.href);
listArticle=new Array();
for(i=0;i<10;i++){
	listArticle[i]=GetCookie('EMARTICLE'+i);
	// document.writeln(i+"="+listArticle[i]) ;
	//  document.writeln("<br>") ;
}

listArticle.sort();
var jj=new Array();
for(i=listArticle.length-1;i>=0;i--){
	if(listArticle[i]!="null"){
		str_temp=listArticle[i].split("@#$");
		jj[i]=str_temp[1];
		// document.writeln(listArticle[i]);
		document.writeln("<li><a href='"+str_temp[2]+"'><h2><i class='ico_dot'></i>"+str_temp[1].replace(' - пео╒','').substr(0,20)+"</h2></a></li>") ;
		//document.writeln("<br>") ;
	}

}

