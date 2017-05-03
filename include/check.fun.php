<?php
//check if is qq
function is_qq($qq)
{
	if(ereg("^[1-9][0-9]{4,}$",$qq)) 
	{
		return true;
	}
	else 
	{
		return false;
	}
}
//check if is email address 
function is_email($C_mailaddr)
{ 
	if (!eregi("^[_a-z0-9-]+(.[_a-z0-9-]+)*@[a-z0-9-]+(.[a-z0-9-]+)*$",$C_mailaddr)) 
	{ 
		return false; 
	} 
	return true; 
}
//check if is www address
function is_www($C_weburl)
{ 
	if (!ereg("^http://[_a-zA-Z0-9-]+(.[_a-zA-Z0-9-]+)*$", $C_weburl)) 
	{ 
		return false; 
	} 
	return true; 
} 
//check if is password
function is_pwd($C_passwd) 
{ 
	if (!CheckLengthBetween($C_passwd, 4, 20)) return false; //¿í¶È¼ì²â 
	if (!ereg("^[_a-zA-Z0-9]*$", $C_passwd)) return false; //ÌØÊâ×Ö·û¼ì²â 
	return true; 
}
//check if is telephone number
function is_tel($C_telephone) 
{ 
if (!ereg("^[+]?[0-9]+([xX-][0-9]+)*$", $C_telephone)) return false; 
return true; 
} 

?>