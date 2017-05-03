<?php
!defined('IN_MYMPS') && die('Access Denied');
define("IPDATA",MYMPS_DATA."/ipdat/ipdata.dat");
class ip
{
	var $fp;
	var $firstip;
	var $lastip;
	var $totalip;
	
	function ip($datfile = IPDATA)
	{
		$this->fp=fopen($datfile,'rb');
		$this->firstip = $this->get4b();
		$this->lastip = $this->get4b();
		$this->totalip =($this->lastip - $this->firstip)/7 ;
		register_shutdown_function(array($this,"closefp"));
	}

	function closefp()
	{
		fclose($this->fp);
	}

	function get4b()
	{
		$str=unpack("V",fread($this->fp,4));
		return $str[1];
	}

	function getoffset()
	{
		$str=unpack("V",fread($this->fp,3).chr(0));
		return $str[1];
	}

	function getstr(){
		$split=fread($this->fp,1);
		while(ord($split)!=0)
		{
			$str .=$split;
			$split=fread($this->fp,1);
		}
		return $str;
	}

	function iptoint($ip)
	{
		return pack("N",intval(ip2long($ip)));
	}

	function readaddress()
	{
		$now_offset=ftell($this->fp);
		$flag=$this->getflag();
		switch(ord($flag))
		{
			case 0:
				$address="";
			break;
			case 1:
			case 2:
				fseek($this->fp,$this->getoffset());
				$address=$this->getstr();
			break;
			default:
				fseek($this->fp,$now_offset);
				$address=$this->getstr();
			break;
		}
		return $address;
	}

	function getflag()
	{
		return fread($this->fp,1);
	}

	function searchip($ip)
	{
		$ip=gethostbyname($ip);
		$ip_offset["ip"]=$ip;
		$ip=$this->iptoint($ip);
		$firstip=0;
		$lastip=$this->totalip;
		$ipoffset=$this->lastip;
		while ($firstip <= $lastip)
		{
			$i=floor(($firstip + $lastip) / 2);
			fseek($this->fp,$this->firstip + $i * 7);
			$startip=strrev(fread($this->fp,4));
			if ($ip < $startip)
			{
				$lastip=$i - 1;
			}
			else
			{
				fseek($this->fp,$this->getoffset());
				$endip=strrev(fread($this->fp,4));
				if($ip > $endip)
				{
					$firstip=$i + 1;
				}
				else
				{
					$ip_offset["offset"]=$this->firstip + $i * 7;
					break;
				}
			}
		}
		return $ip_offset;
	}

	function getaddress($ip)
	{
		$ip_offset=$this->searchip($ip);
		$ipoffset=$ip_offset["offset"];
		$address["ip"]=$ip_offset["ip"];
		fseek($this->fp,$ipoffset);
		$address["startip"]=long2ip($this->get4b());
		$address_offset=$this->getoffset();
		fseek($this->fp,$address_offset);
		$address["endip"]=long2ip($this->get4b());
		$flag=$this->getflag();
		switch (ord($flag))
		{
			case 1:
				$address_offset=$this->getoffset();
				fseek($this->fp,$address_offset);
				$flag=$this->getflag();
				switch(ord($flag))
				{
					case 2:
						fseek($this->fp,$this->getoffset());
						$address["area1"]=$this->getstr();
						fseek($this->fp,$address_offset+4);
						$address["area2"]=$this->readaddress();
					break;
					default:
						fseek($this->fp,$address_offset);
						$address["area1"]=$this->getstr();
						$address["area2"]=$this->readaddress();
					break;
				}
			break;
			case 2:
				$address1_offset=$this->getoffset();
				fseek($this->fp,$address1_offset);  
				$address["area1"]=$this->getstr();
				fseek($this->fp,$address_offset+8);
				$address["area2"]=$this->readaddress();
			break;
			default:
				fseek($this->fp,$address_offset+4);
				$address["area1"]=$this->getstr();
				$address["area2"]=$this->readaddress();
			break;
		}
		if(strpos($address["area1"]," CZ88.NET")!=false)
		{
			$address["area1"]="";
		}
		if(strpos($address["area2"]," CZ88.NET")!=false)
		{
			$address["area2"]="";
		}
		return $address;
	}
}
?>