<?php
function flink_pr(){
	$flink_pr=array('0','1','2','3','3-10');
	return $flink_pr;
}

function flink_dayip(){
	$flink_dayip=array('1000以下','1000以上');
	return $flink_dayip;
}

function apply_flink_pr($pr=""){
	$flink_pr=flink_pr();
	foreach ($flink_pr as $k => $value){
		$str .='<input type="radio" name="pr" value="'.$value.'" style="border:0" class="li"';
		$str .= ($value == $pr) ? "checked " : '';
		$str .= '>'.$value;
	}
	return $str;
}

function apply_flink_dayip($dayip=""){
	$flink_dayip=flink_dayip();
	foreach ($flink_dayip as $k => $value){
		$str .='<input type="radio" name="dayip" value="'.$value.'" style="border:0" class="li"';
		$str .= ($value == $dayip) ? "checked " : '';
		$str .= '>'.$value;
	}
	return $str;
}

function webtype_option($typeid=''){
	$alltype = $GLOBALS['db'] -> getAll("SELECT * FROM {$GLOBALS['db_mymps']}flink_type ORDER BY id Asc");
	foreach($alltype as $row){
		$return .= "<option value=".$row[id];
		$return .= $row[id] == $typeid ? " selected style='background-color:#6EB00C;color:white'" : "" ;
		$return .= ">".$row[typename]."</option>";
	}
	return $return;
}
?>