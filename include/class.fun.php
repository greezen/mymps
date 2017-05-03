<?php 
!defined('IN_MYMPS') && die('FORBIDDEN');

function get_member_cat($cat_arr='',$ifnone=true){
	$option .= $ifnone == false ? "<select datatype=\"limit\" require=\"true\" msg=\"请选择所属分类\" class=input name=catid>" : "<select datatype=\"limit\" require=\"true\" msg=\"请选择所属分类\" class=input name=\"catid[]\">";
	$option .= $ifnone == false ? '<option value="">>不限分类</option>' : '<option value="">请选择所属分类</option>';
	$option .= cat_list('corp','',$cat_arr,true);
	$option .= "</select>";
	return $option;
}
//总分类
function get_catparents(){
	global $db,$db_mymps;
	$data = read_static_cache('catparents');
	if($data === false){
		$query = $db -> query("SELECT * FROM `{$db_mymps}category` WHERE if_view = '2' AND parentid = '0' ORDER BY catorder DESC");
		while($row = $db->fetchRow($query)){
			$res[$row['catid']]['catid'] = $row['catid'];
			$res[$row['catid']]['catname'] = $row['catname'];
			$res[$row['catid']]['uri'] 	= Rewrite('category',array('catid'=>$row['catid'],'html_dir'=>$row['html_dir']));
			$res[$row['catid']]['uri_corp'] = Rewrite('corp',array('catid'=>$row['catid']));
		}
		write_static_cache('catparents',$res);
	}else{
		$res = $data;
	}
	return $res;
}

function get_area_children($areaid,$pre='a.areaid')
{
	return create_in(array_unique(array_merge(array($areaid), array_keys(cat_list('area',$areaid,0, false)))),$pre);
}

function get_children($catid,$pre='a.catid')
{
	return create_in(array_unique(array_merge(array($catid), array_keys(cat_list('category',$catid,0, false)))),$pre);
}

function get_cat_children($catid,$type = 'category')
{
	if($row = $GLOBALS['db']->getAll("SELECT catid FROM `{$GLOBALS['db_mymps']}".$type."` WHERE parentid = '$catid'")){
		$cat = array();
		foreach ($row as $k => $v){
			$cat[$v['catid']] = $v['catid'];
		}
		$cats = implode(',', $cat).','.$catid;
		return $cats;
	}else{
		return $catid;
	}
}

function get_corp_children($corpid)
{
	if($row = $GLOBALS['db']->getAll("SELECT corpid FROM `{$GLOBALS['db_mymps']}corp` WHERE parentid = '$corpid'")){
		$cat = array();
		foreach ($row as $k => $v){
			$cat[$v['corpid']] = $v['corpid'];
		}
		$cats = implode(',', $cat).','.$corpid;
		return $cats;
	}else{
		return $corpid;
	}
}

/*
 * 获得指定信息分类同级的所有分类以及该分类下的子分类
 */
function get_categories_foreach($catid = 0,$type = 'category',$ifview = '2')
{
	$bif_view = ($ifview == '2' || $ifview == '1') ? " AND b.if_view = '$ifview'" : "";
    /*
	判断当前分类是否有下级分类
    */
	$child = mymps_count($type,"WHERE parentid = '$catid'");
	
	if(!$child || $child == 0){
		/* 如果没有下级分类 */
		$row = $GLOBALS['db'] -> getRow("SELECT parentid FROM `{$GLOBALS['db_mymps']}".$type."` WHERE catid = '$catid'");
		$sql = "SELECT catid, catname, catorder, if_view, html_dir FROM `{$GLOBALS['db_mymps']}".$type."` WHERE parentid = '$row[parentid]' ORDER BY catorder ASC , catid ASC";
	} else {
		/*如果有下级分类*/
		$sql = "SELECT catid, catname, catorder, if_view, html_dir FROM `{$GLOBALS['db_mymps']}".$type."` WHERE parentid = '$catid' ORDER BY catorder ASC , catid ASC";
	}
	$res = $GLOBALS['db']->getAll($sql);
	return $res;
}

/*
 *获得地区分类及该分类下的子分类
 *
 */
function get_area_tree($areaid){
	$data = read_static_cache('area_tree');
	/****************************/
	/*获得所有根分类和所有子分类*/
	/****************************/
	if($data === false){
		$sql = "SELECT a.*, b.areaid AS childid, b.areaname AS childname FROM `{$GLOBALS['db_mymps']}area` AS a LEFT JOIN `{$GLOBALS['db_mymps']}area` AS b ON b.parentid = a.areaid WHERE a.parentid = '0'  ORDER BY a.areaorder ASC , a.areaid ASC, b.areaorder ASC";
		$res = $GLOBALS['db']->getAll($sql);
		$area_arr = array();
		foreach ($res AS $row){
			$area_arr[$row['areaid']]['areaid']    = $row['areaid'];
			$area_arr[$row['areaid']]['areaname']  = $row['areaname'];
			if ($row['childid'] != NULL){
				$area_arr[$row['areaid']]['children'][$row['childid']]['areaid']    = $row['childid'];
				$area_arr[$row['areaid']]['children'][$row['childid']]['areaname']  = $row['childname'];
			}
		}
		write_static_cache('area_tree',$area_arr);
	}else{
		$area_arr = $data;
	}
	
	if($areaid >0){
		$parentid = $GLOBALS['db']->getOne("SELECT parentid FROM `{$GLOBALS['db_mymps']}area` WHERE areaid = '$areaid'");
		if($parentid >0){
			return $area_arr[$parentid]['children'];
		}else{
			return $area_arr[$areaid]['children'] ? $area_arr[$areaid]['children'] : $area_arr;
		}
	} else{
		return $area_arr;
	}
}

/**
 * 获得指定信息分类同级的所有分类以及该分类下的子分类
 */
function get_categories_tree($catid = 0,$type = 'category',$ifview = '2')
{
	$data = read_static_cache($type.'_tree');
	$rewritetype = $type == 'channel' ? 'news' : 'category';
	/****************************/
	/*获得所有根分类和所有子分类*/
	/****************************/
	if($catid == 0) {
		
		if($data === false){
			
			$parentid = 0;
			$bif_view = ($ifview == '2' || $ifview == '1') ? " AND a.if_view = '$ifview' AND b.if_view = '$ifview'" : "";
			$sql = "SELECT a.*, b.catid AS childid, b.catname AS childname, b.color AS childcolor,b.html_dir AS child_html_dir,b.htmlpath AS child_htmlpath,b.dir_typename AS child_dir_typename FROM `{$GLOBALS['db_mymps']}".$type."` AS a LEFT JOIN `{$GLOBALS['db_mymps']}".$type."` AS b ON b.parentid = a.catid WHERE a.parentid = '$parentid' {$bif_view} ORDER BY a.catorder ASC , b.catorder ASC";
			$res = $GLOBALS['db']->getAll($sql);
			
			$cat_arr = array();
			
			foreach ($res AS $row){
				
				if ($row['if_view']){
					$cat_arr[$row['catid']]['catid']    = $row['catid'];
					$cat_arr[$row['catid']]['catname']  = $row['catname'];
					$cat_arr[$row['catid']]['color']	= $row['color'];
					$cat_arr[$row['catid']]['if_view']  = $row['if_view'];
					$cat_arr[$row['catid']]['html_dir'] = $row['html_dir'];
					$cat_arr[$row['catid']]['uri']		= Rewrite($rewritetype,array('catid'=>$row['catid'],'html_dir'=>$row['html_dir'],'dir_typename'=>$row['dir_typename']));
					$type == 'category' && $cat_arr[$row['catid']]['usecoin'] = $row['usecoin'];
					$cat_arr[$row['catid']]['icon']    = $row['icon'];
					if ($row['childid'] != NULL){
						$cat_arr[$row['catid']]['children'][$row['childid']]['catid']    = $row['childid'];
						$cat_arr[$row['catid']]['children'][$row['childid']]['catname']  = $row['childname'];
						$cat_arr[$row['catid']]['children'][$row['childid']]['if_view']  = $row['if_view'];
						$cat_arr[$row['catid']]['children'][$row['childid']]['color']= $row['childcolor'];
						$cat_arr[$row['catid']]['children'][$row['childid']]['html_dir'] = $row['child_html_dir'];
						$cat_arr[$row['catid']]['children'][$row['childid']]['uri'] 	 = Rewrite($rewritetype,array('catid'=>$row['childid'],'html_dir'=>$row['child_html_dir'],'dir_typename'=>$row['child_dir_typename']));
						$type == 'category' && $cat_arr[$row['catid']]['children'][$row['childid']]['usecoin']  = $row['usecoin'];
					}
				}
				
			}
			write_static_cache($type.'_tree',$cat_arr);
		}else{
			$cat_arr = $data;
		} 

	} 
	/****************************/
	/*获得一个根分类和所有子分类*/
	/****************************/
	else {
		
		if($data === NULL || empty($data[$catid])){
			
			$bif_view = ($ifview == '2' || $ifview == '1') ? " AND b.if_view = '$ifview'" : "";
			$parentid = $GLOBALS['db']->getOne("SELECT parentid FROM `{$GLOBALS['db_mymps']}".$type."` WHERE catid = '$catid'");
			if ($parentid == 0 || $GLOBALS['db']->getOne("SELECT count(catid) FROM `{$GLOBALS['db_mymps']}".$type."` WHERE parentid = '$catid'")){
				/*二级分类*/
				$sql = "SELECT a.*, b.catid AS childid, b.catname AS childname, b.catorder AS childorder,b.html_dir AS child_html_dir,b.htmlpath AS child_htmlpath,b.dir_typename AS child_dir_typename FROM `{$GLOBALS['db_mymps']}".$type."` AS a LEFT JOIN `{$GLOBALS['db_mymps']}".$type."` AS b ON b.parentid = a.catid {$bif_view} WHERE a.catid = '$catid' ORDER BY catorder ASC , childorder ASC";		
			}else{
				/*底层分类*/
				$sql = "SELECT a.*, b.catid AS childid, b.catname AS childname, b.catorder AS childorder, b.html_dir AS child_html_dir,b.dir_typename AS child_dir_typename, b.htmlpath AS child_htmlpath FROM `{$GLOBALS['db_mymps']}".$type."` AS a LEFT JOIN `{$GLOBALS['db_mymps']}".$type."` AS b ON b.parentid = a.catid {$bif_view} WHERE b.parentid = '$parentid' ORDER BY catorder ASC , childorder ASC";
			}
			
			$res = $GLOBALS['db']->getAll($sql);
			
			$cat_arr = array();
			foreach ($res AS $row){
				if ($row['if_view']){
					$cat_arr[$row['catid']]['catid']    = $row['catid'];
					$cat_arr[$row['catid']]['catname']  = $row['catname'];
					$type == 'category' && $cat_arr[$row['catid']]['usecoin']  = $row['usecoin'];
					$cat_arr[$row['catid']]['catorder'] = $row['catorder'];
					$cat_arr[$row['catid']]['if_view']  = $row['if_view'];
					$cat_arr[$row['catid']]['html_dir'] = $row['html_dir'];
					$cat_arr[$row['catid']]['uri']		= Rewrite($rewritetype,array('catid'=>$row['catid'],'html_dir'=>$row['html_dir'],'dir_typename'=>$row['dir_typename']));
					if ($row['childid'] != NULL){
						$cat_arr[$row['catid']]['children'][$row['childid']]['catid']    = $row['childid'];
						$cat_arr[$row['catid']]['children'][$row['childid']]['catname']  = $row['childname'];
						$type == 'category' && $cat_arr[$row['catid']]['children'][$row['childid']]['usecoin']  = $row['usecoin'];
						$cat_arr[$row['catid']]['children'][$row['childid']]['if_view']  = $row['if_view'];
						$cat_arr[$row['catid']]['children'][$row['childid']]['catorder'] = $row['childorder'];
						$cat_arr[$row['catid']]['children'][$row['childid']]['html_dir'] = $row['child_html_dir'];
						$cat_arr[$row['catid']]['children'][$row['childid']]['uri'] 	 = Rewrite($rewritetype,array('catid'=>$row['childid'],'html_dir'=>$row['child_html_dir'],'dir_typename'=>$row['child_dir_typename']));
					}
				}
			}
			
		} else {
			$cat_arr[$catid] = $data[$catid];
		}
	}
	
	return $cat_arr;
}

/**
 * 获得指定商家分类同级的所有分类以及该分类下的子分类
 */
function get_corp_tree($catid = 0,$type = 'corp')
{
	$data = read_static_cache($type.'_tree');
	/****************************/
	/*获得所有根分类和所有子分类*/
	/****************************/
	if($catid == 0) {
		
		if($data === false){
			
			$parentid = 0;
			$sql = "SELECT a.corpid, a.corpname, b.corpid AS childid, b.corpname AS childname FROM `{$GLOBALS['db_mymps']}".$type."` AS a LEFT JOIN `{$GLOBALS['db_mymps']}".$type."` AS b ON b.parentid = a.corpid WHERE a.parentid = '$parentid' ORDER BY a.corporder ASC , a.corpid ASC, b.corporder ASC";
			$res = $GLOBALS['db']->getAll($sql);
			
			$cat_arr = array();
			foreach ($res AS $row){
				
				$cat_arr[$row['corpid']]['corpid']    = $row['corpid'];
				$cat_arr[$row['corpid']]['corpname']  = $row['corpname'];
				$cat_arr[$row['corpid']]['uri']		   = Rewrite('corp',array('catid'=>$row['corpid']));
				
				if ($row['childid'] != NULL){
					$cat_arr[$row['corpid']]['children'][$row['childid']]['corpid']    = $row['childid'];
					$cat_arr[$row['corpid']]['children'][$row['childid']]['corpname']  = $row['childname'];
					$cat_arr[$row['corpid']]['children'][$row['childid']]['uri'] 	   = Rewrite('corp',array('catid'=>$row['childid']));
				}
				
			}
			write_static_cache($type.'_tree',$cat_arr);
		}else{
			$cat_arr = $data;
		} 

	} 
	/****************************/
	/*获得一个根分类和所有子分类*/
	/****************************/
	else {
		
		if($data === NULL || empty($data[$catid])){

			$parentid = $GLOBALS['db']->getOne("SELECT parentid FROM `{$GLOBALS['db_mymps']}".$type."` WHERE corpid = '$corpid'");
			
			if ($parentid == 0){
				/* 获取当前同级分类及其子分类 */
				$sql = "SELECT a.corpid, a.corpname, a.corporder, b.corpid AS childid, b.corpname AS childname, b.corporder AS childorder FROM `{$GLOBALS['db_mymps']}".$type."` AS a LEFT JOIN `{$GLOBALS['db_mymps']}".$type."` AS b ON b.parentid = a.corpid WHERE a.corpid = '$catid' ORDER BY corporder ASC , corpid ASC, childorder ASC";
				
			}else{
				/* 获取当前分类及其父分类 */
				$sql = "SELECT a.corpid, a.corpname, a.corporder, b.corpid AS childid, b.corpname AS childname, b.corporder AS childorder FROM `{$GLOBALS['db_mymps']}".$type."` AS a LEFT JOIN `{$GLOBALS['db_mymps']}".$type."` AS b ON b.parentid = a.catid WHERE b.parentid = '$parentid' ORDER BY corporder ASC , corpid ASC, childorder ASC";
				
			}
			
			$res = $GLOBALS['db']->getAll($sql);
			
			$cat_arr = array();
			foreach ($res AS $row){

				$cat_arr[$row['corpid']]['corpid']    = $row['corpid'];
				$cat_arr[$row['corpid']]['corpname']  = $row['corpname'];
				$cat_arr[$row['corpid']]['corporder'] = $row['corporder'];
				$cat_arr[$row['corpid']]['uri']		  = Rewrite('corp',array('catid'=>$row['corpid']));
				if ($row['childid'] != NULL){
					$cat_arr[$row['corpid']]['children'][$row['childid']]['corpid']    = $row['childid'];
					$cat_arr[$row['corpid']]['children'][$row['childid']]['corpname']  = $row['childname'];
					$cat_arr[$row['corpid']]['children'][$row['childid']]['corporder'] = $row['childorder'];
					$cat_arr[$row['corpid']]['children'][$row['childid']]['uri'] 	   = Rewrite('corp',array('catid'=>$row['childid']));
				}

			}
			
		} else {
			$cat_arr[] = $data[$catid];
		}
	}
	
	return $cat_arr;
}

/*
 * 获得指定分类的所有上级分类
 */
function get_parent_cats($type='category',$cat='')
{
	
	if ($cat == 0) return array();

	$data = read_static_cache($type.'_pid_releate');
	if($data === false){
		if($type == 'category'){
			$arr = $GLOBALS['db']->getAll("SELECT catid, catname, parentid, html_dir,dir_typename FROM `{$GLOBALS['db_mymps']}category`");
		} elseif($type == 'channel'){
			$arr = $GLOBALS['db']->getAll("SELECT catid, catname, parentid, html_dir FROM `{$GLOBALS['db_mymps']}channel`");
		} elseif($type == 'corp'){
			$arr = $GLOBALS['db'] -> getAll("SELECT corpid,corpname,parentid FROM `{$GLOBALS['db_mymps']}corp`");
		}
	} else {
		$arr = $data;
	}

	if (empty($arr)) return array();

	$index = 0;
	$cats  = array();

	while (1){
		if($type == 'corp'){
			foreach ($arr AS $row){
				if ($cat == $row['corpid']){
					$cat = $row['parentid'];
					$cats[$index]['corpid']  = $row['corpid'];
					$cats[$index]['corpname']= $row['corpname'];
					$cats[$index]['uri'] 	 = Rewrite('corp',array('catid'=>$row['corpid']));
					$index++;
					break;
				}
			}
		} else {
			foreach ($arr AS $row){
				if ($cat == $row['catid']){
					$cat = $row['parentid'];
					$cats[$index]['catid']   = $row['catid'];
					$cats[$index]['catname'] = $row['catname'];
					if($type == 'category'){
						$cats[$index]['uri'] = Rewrite('category',array('catid'=>$row['catid'],'html_dir'=>$row['html_dir'],'dir_typename'=>$row['dir_typename']));
					} else {
						$cats[$index]['uri'] = Rewrite('news',array('catid'=>$row['catid'],'html_dir'=>$row['html_dir']));
					}
					$index++;
					break;
				}
			}
		}
		
		if ($index == 0 || $cat == 0){
			break;
		}
	}
	
	return $cats;
}

/*
 * 获得指定分类的所有下级分类
 */
function get_child_cats($cat){

	if ($cat == 0) return array();
	$catr = $cat;

	$data = read_static_cache('category_pid_releate');
	if($data === false){
		$arr = $GLOBALS['db']->getAll("SELECT catid, catname, parentid, html_dir, dir_typename FROM `{$GLOBALS['db_mymps']}category`");
	} else {
		$arr = $data;
	}

	if (empty($arr)) return array();

	$index = 0;
	$cats  = array();

	while (1){
		foreach ($arr AS $row){
			if ($cat == $row['parentid']){
				$cat = $row['has_children'];
				$cats[$index]['catid']   = $row['catid'];
				$cats[$index]['catname'] = $row['catname'];
				$index++;
				break;
			}
		}
		if ($index == 0 || $cat == 0){
			break;
		}
	}
	
	foreach($cats as $k => $v){
		$catreturn .= $v['catid'].',';
	}
	$catreturn = substr($catreturn,0,-1);
	$catreturn = $catreturn ? ($catr.','.$catreturn) : $catr;
	
	return $catreturn;
}


/**
 * 获得指定分类下的子分类的数组
 *
 * @access  public
 * @param   int     $catid     分类的ID
 * @param   int     $selected   当前选中分类的ID
 * @param   boolean $re_type    返回的类型: 值为真时返回下拉列表,否则返回数组
 * @param   int     $level      限定返回的级数。为0时返回所有级数
 * @param   int     $is_show_all 如果为true显示所有分类，如果为false隐藏不可见分类。
 * @return  mix
 */
function cat_list($type = 'category',$catid = 0, $selected = 0, $re_type = true, $level = 0, $is_show_all = true)
{
	$data = read_static_cache($type.'_pid_releate');
	if ($data === false){
		if(in_array($type,array('area','corp'))){
			$sql = "SELECT c.".$type."id, c.".$type."name, c.parentid, c.".$type."order, COUNT(s.".$type."id) AS has_children FROM `{$GLOBALS['db_mymps']}".$type."` AS c LEFT JOIN `{$GLOBALS['db_mymps']}".$type."` AS s ON s.parentid=c.".$type."id GROUP BY c.".$type."id ORDER BY c.parentid, c.".$type."order ASC";
		}elseif($type == 'category') {
			$sql = "SELECT c.catid, c.modid, c.dir_typename, c.dir_typename, c.catname,c.usecoin, c.parentid, c.if_view, c.catorder, c.template_info, COUNT(s.catid) AS has_children FROM `{$GLOBALS['db_mymps']}".$type."` AS c LEFT JOIN `{$GLOBALS['db_mymps']}".$type."` AS s ON s.parentid=c.catid GROUP BY c.catid ORDER BY c.parentid, c.catorder ASC";
		}else {
			$sql = "SELECT c.catid, c.dir_typename, c.dir_typename, c.catname, c.parentid, c.if_view, c.catorder, COUNT(s.catid) AS has_children FROM `{$GLOBALS['db_mymps']}".$type."` AS c LEFT JOIN `{$GLOBALS['db_mymps']}".$type."` AS s ON s.parentid=c.catid GROUP BY c.catid ORDER BY c.parentid, c.catorder ASC";
		}
		
		$res = $GLOBALS['db']->getAll($sql);
		$sql = NULL;
		
		$newres = array();
		
		//如果数组过大，不采用静态缓存方式
		if (count($res) <= 1000){
			write_static_cache($type.'_pid_releate', $res);
		}
	} else {
		$res = $data;
	}


	if (empty($res) == true){
		return $re_type ? '' : array();
	}

    $options = cat_options($type, $catid, $res); // 获得指定分类下的子分类的数组

    $children_level = 99999; //大于这个分类的将被删除
    if ($is_show_all == false){
    	foreach ($options as $key => $val){
    		if ($val['level'] > $children_level){
    			unset($options[$key]);
    		}else{
    			if ($val['is_show'] == 0){
    				unset($options[$key]);
    				if ($children_level > $val['level']){
                        $children_level = $val['level']; //标记一下，这样子分类也能删除
                    }
                }else{
                    $children_level = 99999; //恢复初始值
                }
            }
        }
    }

    /* 截取到指定的缩减级别 */
    if ($level > 0){
    	if ($catid == 0){
    		$end_level = $level;
    	}else{
            $first_item = reset($options); // 获取第一个元素
            $end_level  = $first_item['level'] + $level;
        }

        /* 保留level小于end_level的部分 */
        foreach ($options AS $key => $val){
        	if ($val['level'] >= $end_level){
        		unset($options[$key]);
        	}
        }
    }
    /****************/
    /*如果为地区分类或商家分类*/
    /****************/
    if(in_array($type,array('area','corp'))){
    	if ($re_type == true){
    		$select = '';
    		if(is_array($options)){
    			foreach ($options AS $var){
    				$select .= '<option value="' . $var[$type.'id'] . '" ';
    				if(is_array($selected)){
    					$select .= in_array($var[$type.'id'],$selected) ? "selected='ture' style='background-color:#6eb00c; color:white!important;'" : '';
    				} else {
    					$select .= ($selected == $var[$type.'id']) ? "selected='ture' style='background-color:#6eb00c; color:white!important;'" : '';
    				}
    				$select .= '>';
    				if ($var['level'] > 0){
    					$select .= str_repeat('&nbsp;', $var['level'] * 4);
    				}
    				$select .= '└ '.mhtmlspecialchars($var[$type.'name'], ENT_QUOTES) . '</option>';
    			}
    		}
    		
    		return $select;
    	}else{
    		if(is_array($options)){
    			foreach ($options AS $key => $value){
    				$options[$key]['url'] = $value[$type.'id'];
    			}
    		}
    		return $options;
    	}
    	
    	/****************/
    	/*如果为信息栏目或新闻栏目分类*/
    	/****************/
    } else {
    	if ($re_type == true){
    		$select = '';
    		foreach ($options AS $var){
    			$select .= '<option value="' . $var['catid'] . '" ';
    			if(is_array($selected)){
    				$select .= in_array($var['catid'],$selected) ? "selected='ture' style='background-color:#6eb00c; color:white!important;'" : '';
    			} else {
    				$select .= ($selected == $var['catid']) ? "selected='ture' style='background-color:#6eb00c; color:white!important;'" : '';
    			}
    			$select .= '>';
    			if ($var['level'] > 0){
    				$select .= str_repeat('&nbsp;', $var['level'] * 4);
    			}
    			$select .= '└ '.mhtmlspecialchars($var['catname'], ENT_QUOTES) . '</option>';
    		}
    		return $select;
    	}else{
    		foreach ($options AS $key => $value){
    			$options[$key]['url'] = $value['catid'];
    		}
    		return $options;
    	}
    }

}

/**
 * 过滤和排序所有分类，返回一个带有缩进级别的数组
 *
 * @access  private
 * @param   int     $catid     上级分类ID
 * @param   array   $arr        含有所有分类的数组
 * @param   int     $level      级别
 * @return  void
 */
function cat_options($type='category',$spec_cat_id, $arr)
{
	$cat_options = array();

	if (isset($cat_options[$spec_cat_id])){
		return $cat_options[$spec_cat_id];
	}

	if (!isset($cat_options[0])){
		$level = $last_cat_id = 0;
		$options = $cat_id_array = $level_array = array();
		$data = read_static_cache($type.'_option_static');

		if ($data === false){
			while (!empty($arr)){
				foreach ($arr AS $key => $value){

					$cat_id = $type == 'area' ? $value['areaid'] : ($type == 'corp' ? $value['corpid'] : $value['catid']);
					if ($level == 0 && $last_cat_id == 0){
						if ($value['parentid'] > 0){
							break;
						}
						$options[$cat_id]          = $value;
						$options[$cat_id]['level'] = $level;
						$options[$cat_id]['id']    = $cat_id;
						$options[$cat_id]['name']  = $type == 'category' ? $value['catname'] : $value[$type.'name'];
						unset($arr[$key]);

						if ($value['has_children'] == 0){
							continue;
						}
						$last_cat_id  = $cat_id;
						$cat_id_array = array($cat_id);
						$level_array[$last_cat_id] = ++$level;
						continue;
					}

					if ($value['parentid'] == $last_cat_id){
						$options[$cat_id]          = $value;
						$options[$cat_id]['level'] = $level;
						$options[$cat_id]['id']    = $cat_id;
						$options[$cat_id]['name']  = $type == 'category' ? $value['catname'] : $value[$type.'name'];
						unset($arr[$key]);

						if ($value['has_children'] > 0){
							if (end($cat_id_array) != $last_cat_id){
								$cat_id_array[] = $last_cat_id;
							}
							$last_cat_id    = $cat_id;
							$cat_id_array[] = $cat_id;
							$level_array[$last_cat_id] = ++$level;
						}
					} elseif ($value['parentid'] > $last_cat_id){
						break;
					}
				}

				$count = count($cat_id_array);
				if ($count > 1){
					$last_cat_id = array_pop($cat_id_array);
				}elseif ($count == 1){
					if ($last_cat_id != end($cat_id_array)){
						$last_cat_id = end($cat_id_array);
					}else{
						$level = 0;
						$last_cat_id = 0;
						$cat_id_array = array();
						continue;
					}
				}

				if ($last_cat_id && isset($level_array[$last_cat_id])){
					$level = $level_array[$last_cat_id];
				}else{
					$level = 0;
				}
			}
            //如果数组过大，不采用静态缓存方式
			if (count($options) <= 2000){
				write_static_cache($type.'_option_static', $options);
			}
		}else{
			$options = $data;
		}
		$cat_options[0] = $options;
	}else{
		$options = $cat_options[0];
	}

	if (!$spec_cat_id){
		return $options;
	}else{
		if (empty($options[$spec_cat_id])){
			return array();
		}

		$spec_cat_id_level = $options[$spec_cat_id]['level'];

		foreach ($options AS $key => $value){
			if ($key != $spec_cat_id){
				unset($options[$key]);
			}else{
				break;
			}
		}

		$spec_cat_id_array = array();
		foreach ($options AS $key => $value){
			if (($spec_cat_id_level == $value['level'] && ($type == 'area' ? $value['areaid'] :$value['catid']) != $spec_cat_id) ||
				($spec_cat_id_level > $value['level'])){
				break;
		}else{
			$spec_cat_id_array[$key] = $value;
		}
	}
	$cat_options[$spec_cat_id] = $spec_cat_id_array;

	return $spec_cat_id_array;
}
}

/*
 *获得当前栏目信息
 */
function get_cat_info($catid = 0,$type = 'category'){
	global $db,$db_mymps;
	return $db -> getRow("SELECT * FROM `{$db_mymps}".$type."` WHERE catid = '$catid'");
}
/*
 *判断是否含有子栏目
 */
function has_children($type='channel',$catid){
	return $GLOBALS['db'] -> getOne("SELECT catid FROM `{$GLOBALS['db_mymps']}channel` WHERE parentid = '$catid'");
}
if ( !defined( "IN_MYMPS" ) )
{
	exit( "FORBIDDEN" );
}
?>