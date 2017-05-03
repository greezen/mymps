<?php
!defined('IN_MYMPS') && exit('FORBIDDEN');
class mysql {
	var $query_num = 0;
	var $link;
	
	function mysql($dbhost, $dbuser, $dbpw, $dbname, $pconnect = 0) {
		$this->connect($dbhost, $dbuser, $dbpw, $dbname, $pconnect);
	}

	function connect($dbhost, $dbuser, $dbpw, $dbname, $pconnect = 0) {
        global $dbcharset;
        $func = empty($pconnect) ? "mysql_connect" : "mysql_pconnect";
        if(!$this->link = @$func($dbhost, $dbuser, $dbpw, 1)) {
        	$this->halt("Can not connect to MySQL server");
        }
		
		if ($this->server_info() > '4.1')
        {
            if ($dbcharset != 'latin1')
            {
                mysql_query("SET character_set_connection=$dbcharset, character_set_results=$dbcharset, character_set_client=binary", $this->link);
            }
            if ($this->server_info() > '5.0.1')
            {
                mysql_query("SET sql_mode=''", $this->link);
            }
        }	
			
		if($dbname) {
			if (!@mysql_select_db($dbname, $this->link)) $this->halt('Cannot use database '.$dbname);
		}
	}

	function select_db($dbname) {
		$this->dbname = $dbname;
		if (!@mysql_select_db($dbname, $this->link)) 
			$this->halt('Cannot use database '.$dbname);
	}

	function server_info() {
		return mysql_get_server_info();
	}
	
	function version() {
		return mysql_get_server_info();
	}
	
    function fetchRow($query){
        return mysql_fetch_assoc($query);
    }
	
	function fetch_first($sql) {
		return $this->fetch_array($this->query($sql));
	}

	function query($SQL, $method = '') {
        if($method == 'unbuffer' && function_exists('mysql_unbuffered_query')) 
			$query = mysql_unbuffered_query($SQL, $this->link);
		else
			$query = mysql_query($SQL, $this->link);
		if (!$query && $method != 'SILENT') 
            $this->halt('MySQL Query Error: ' . $SQL);
        $this->query_num++;
		return $query;
	}
	
    function getOne($sql, $limited = false){
        if ($limited == true){
            $sql = trim($sql . ' LIMIT 1');
        }

        $res = $this->query($sql);
        if ($res !== false){
            $row = mysql_fetch_row($res);

            if ($row !== false){
                return $row[0];
            }else{
                return '';
            }
        }else{
            return false;
        }
    }
	
	// add for pw
	function get_one($sql, $result_type = MYSQL_ASSOC){
		$result = $this->query($sql);
		$record = $this->fetch_array($result, $result_type);
		return $record;
	}
	// add for pw
	function get_value($sql, $result_type = MYSQL_NUM, $field = 0){
		$result_set = $this->query($sql);
		$rt =& $this->fetch_array($result_set, $result_type);
		return isset($rt[$field]) ? $rt[$field] : false;
	}
	//add for pw
    function escape($s){
		if(function_exists('mysql_real_escape_string')){
			return htmlspecialchars(mysql_real_escape_string($s, $this->link));
		}
		return htmlspecialchars(addslashes($s));
    }
	//add for pw
	function query_unbuffered($sql) {
		$s = $this->query($sql, 'UNBUFFERED');
		return $s;
	}

	function getCol($sql){
		$res = $this->query($sql);
		if ($res !== false){
			$arr = array();
			while ($row = mysql_fetch_row($res)){
				$arr[] = $row[0];
			}
	
			return $arr;
		}else{
			return false;
		}
	}

    function getAll($sql){
        $res = $this->query($sql);
        if ($res !== false){
            $arr = array();
            while ($row = mysql_fetch_array($res)){
                $arr[] = $row;
            }

            return $arr;
        } else {
            return false;
        }
    }

    function getRow($sql, $limited = false){
        if ($limited == true){
            $sql = trim($sql . ' LIMIT 1');
        }

        $res = $this->query($sql);
        if ($res !== false){
            return mysql_fetch_assoc($res);
        }else{
            return false;
        }
    }

    function fetch_array($query, $result_type = MYSQL_ASSOC) {
        return mysql_fetch_array($query, $result_type);
    }

	function affected_rows() {
		return mysql_affected_rows($this->link);
	}

	function fetch_row($query) {
		return mysql_fetch_row($query);
	}

	function num_rows($query) {
		return mysql_num_rows($query);
	}

	function num_fields($query) {
		return mysql_num_fields($query);
	}

	function result($query, $row) {
		$query = mysql_result($query, $row);
		return $query;
	}

	function free_result($query) {
		return mysql_free_result($query);
	}

	function insert_id() {
		return ($id = mysql_insert_id($this->link)) >= 0 ? $id : $this->result($this->query("SELECT last_insert_id()"), 0);
	}

	function Close() {
		return mysql_close($this->link);
	}

    function error() {
        return (($this->link) ? mysql_error($this->link) : mysql_error());
    }

    function errno() {
        return intval(($this->link) ? mysql_errno($this->link) : mysql_errno());
    }

	function halt($msg = '') {
        global $charset;
		$msg = "<html>\n<head>\n";
		$msg .= "<meta content=\"text/html; charset=$charset\" http-equiv=\"Content-Type\">\n";
		$msg .= "<style type=\"text/css\">\n";
		$msg .=  "body,p,pre {\n";
		$msg .=  "font:12px Verdana;\n";
		$msg .=  "}\n";
		$msg .=  "</style>\n";
		$msg .= "</head>\n";
		$msg .= "<body bgcolor=\"#FFFFFF\" text=\"#000000\" link=\"#006699\" vlink=\"#5493B4\">\n";
		$msg .= "<b>Mymps error</b>: ".htmlspecialchars($this->error())."\n<br />";
		$msg .= "<b>error number</b>: ".$this->errno()."\n<br />";
		$msg .= "<b>Date</b>: ".date("Y-m-d @ H:i")."\n<br />";
		$msg .= "<b>Script</b>: http://".$_SERVER['HTTP_HOST'].getenv("REQUEST_URI")."\n<br />";

		$msg .= "</body>\n</html>";
		echo $msg;
		exit;
	}
}
$db = new mysql($db_host, $db_user, $db_pass, $db_name);
$db_host = $db_user = $db_pass = NULL;
?>