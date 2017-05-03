<?php
function get_group_class(){
	global $db,$db_mymps;
	static $res = NULL;
	$data = read_static_cache('group_class');
	if($data === false){
		$query = $db -> query("SELECT * FROM `{$db_mymps}group_category` WHERE cate_view = '1' ORDER BY cate_order ASC");
		while($row = $db-> fetchRow($query)){
			$res[$row['cate_id']]['cate_id'] = $row['cate_id'];
			$res[$row['cate_id']]['cate_name'] = $row['cate_name'];
			$res[$row['cate_id']]['cate_uri'] = plugin_url('group',array('cate_id'=>$row['cate_id']));
		}
		write_static_cache('group_class',$res);
	} else {
		$res = $data;
	}
	return $res;
}

function get_groupclass_select($formname='cate_id',$cate_id='',$ifselect='yes'){
	global $db,$db_mymps;
	$data = get_group_class();
	$mymps .= $ifselect == 'yes' ? '<select name="'.$formname.'" id="'.$formname.'">' : '';
	foreach($data as $k => $v){
		$mymps .= '<option value="'.$v[cate_id].'"';
		$mymps .= $cate_id == $v['cate_id'] ? ' selected style="background-color:#6EB00C;color:white"' : '';
		$mymps .= '>'.$v[cate_name].'</option>';
	}
	$mymps .= $ifselect == 'yes' ?'</select>' : '';
	unset($data);
	return $mymps;
}
?>