<?php

class cachepages
{

	var $cacheRoot = "";
	var $cacheLimitTime = "";
	var $cacheFileName = "";
	var $cacheFileExt = "php";

	function cachepages( $cacheLimitTime, $curscript )
	{
		if ( $cacheLimitTime )
		{
			$this->cacheLimitTime = $cacheLimitTime;
		}
		if ( CURSCRIPT == "information" )
		{
			$this->cacheRoot = MYMPS_DATA."/pagesinfo/";
		}
		else if ( CURSCRIPT == "category" )
		{
			$this->cacheRoot = MYMPS_DATA."/pageslist/";
		}
		else
		{
			$this->cacheRoot = MYMPS_DATA."/pagesmymps/";
		}
		$this->cacheFileName = $this->getcachefilename( $curscript );
		ob_start( );
	}

	function cachecheck( )
	{
		global $timestamp;
		if ( 0 < $this->cacheLimitTime && file_exists( $this->cacheFileName ) )
		{
			$cachePagesTime = $this->getfilecreatetime( $this->cacheFileName );
			if ( $timestamp < $cachePagesTime + $this->cacheLimitTime )
			{
				echo file_get_contents( $this->cacheFileName );
				ob_end_flush( );
				exit( );
			}
		}
	}

	function caching( $staticFileName = "" )
	{
		global $timestamp;
		if ( $staticFileName )
		{
			$this->savefile( $staticFileName, $cacheContent );
		}
		$cacheContent = ob_get_contents( );
		ob_end_flush( );
		$this->savefile( $this->cacheFileName, $cacheContent );
	}

	function clearcache( $fileName = "all" )
	{
		if ( $fileName != "all" )
		{
			$fileName = $this->cacheRoot.$fileName.".".$this->cacheFileExt;
			if ( file_exists( $fileName ) )
			{
				return unlink( $fileName );
			}
			return false;
		}
		if ( is_dir( $this->cacheRoot ) )
		{
			if ( $dir = @opendir( $this->cacheRoot ) )
			{
				while ( $file = @readdir( $dir ) )
				{
					$check = is_dir( $file );
					if ( !$check )
					{
						@unlink( $this->cacheRoot.$file );
					}
				}
				@closedir( $dir );
				return true;
			}
			return false;
		}
		return false;
	}

	function getcachefilename( $curscript )
	{
		return $this->cacheRoot.$curscript.".".$this->cacheFileExt;
	}

	function getfilecreatetime( $fileName )
	{
		if ( file_exists( $fileName ) )
		{
			return filemtime( $fileName );
		}
		return 0;
	}

	function savefile( $fileName, $text )
	{
		if ( !$fileName && !$text )
		{
			return false;
		}
		if ( $this->makedir( dirname( $fileName ) ) && ( $fp = fopen( $fileName, "w" ) ) )
		{
			if ( @fwrite( $fp, $text ) )
			{
				fclose( $fp );
				return true;
			}
			fclose( $fp );
			return false;
		}
		return false;
	}

	function makedir( $dir, $mode = "0777" )
	{
		if ( !file_exists( $dir ) )
		{
			makedir( dirname( $dir ) );
			mkdir( $dir, $mode );
			return true;
		}
		if ( file_exists( $dir ) )
		{
			return true;
		}
		return false;
	}

}

?>
