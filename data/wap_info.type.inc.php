<?php
$var_type = array(
	'text'=>'字串',
	'textarea'=>'编辑框',
	'number'=>'数字',
	'radio'=>'单选',
	'checkbox'=>'多选',
	'select'=>'选择'
);

//user for option_edit
$mymps_admin_info_type=array(
	"text"=>'
		<tr>
		<td bgcolor="#f5fbff" width="45%" >
		<b>字符最大长度:</b>
		</td>
		<td bgcolor="#f5fbff">
		<input type="text" size="50" name="rules[text][maxlength]" value="'.$rules[text].'" >
		</td>
		</tr>
		',
	"textarea"=>'
		<tr>
		<td bgcolor="#f5fbff" width="45%" >
		<b>字符最大长度:</b>
		</td>
		<td bgcolor="#f5fbff">
		<input type="text" size="50" name="rules[textarea][maxlength]" value="'.$rules[textarea].'" >
		</td>
		</tr>
		',
	"radio"=>'
		<tr>
		<td bgcolor="#f5fbff" width="45%">
		<b>选项内容:</b><br />只在项目为可选时有效，每行一个选项，等号前面为选项索引(建议用数字)，后面为内容，例如: <br /><i>1=苹果<br />2=香蕉<br />3=没有水果</i><br />注意: 选项确定后请勿修改索引和内容的对应关系，但仍可以新增选项。如需调换显示顺序，可以通过移动整行的前后位置来实现
		</td>
		<td bgcolor="#f5fbff">
		<textarea  rows="8" name="rules[radio][choices]" id="rules[radio][choices]" cols="50">'.$rules[radio].'</textarea>
		</td>
		</tr>
		',
	"checkbox"=>'
		<tr>
		<td bgcolor="#f5fbff" width="45%">
		<b>选项内容:</b><br />只在项目为可选时有效，每行一个选项，等号前面为选项索引(建议用数字)，后面为内容，例如: <br /><i>1=苹果<br />2=香蕉<br />3=菠萝</i><br />注意: 选项确定后请勿修改索引和内容的对应关系，但仍可以新增选项。如需调换显示顺序，可以通过移动整行的前后位置来实现</td>
		<td bgcolor="#f5fbff">
		<textarea  rows="8" name="rules[checkbox][choices]" id="rules[checkbox][choices]" cols="50">'.$rules[checkbox].'</textarea>
		</td>
		</tr>
		',
	"select"=>'
		<tr>
		<td bgcolor="#f5fbff" width="25%">
		<b>选项内容:</b><br />只在项目为可选时有效，每行一个选项，等号前面为选项索引(建议用数字)，后面为内容，例如: <br /><i>1=分类信息系统<br />2=企业建站系统<br />3=B2B商务系统</i><br /><br />注意: 选项确定后请勿修改索引和内容的对应关系，但仍可以新增选项。如需调换显示顺序，可以通过移动整行的前后位置来实现</td>
		<td bgcolor="#f5fbff">
	<textarea rows="8" name="rules[select][choices]" id="rules[select][choices]" cols="50">'.$rules[select].'</textarea>
		</td>
		</tr>
		',
	"number"=>'
		<tr>
		<td bgcolor="#f5fbff" width="45%" >
		<b>单位（可选）:</b>
		</td>
		<td bgcolor="#f5fbff">
		<input type="text" size="50" name="rules[number][units]" value="'.$rules[number].'" >
		</td>
		</tr>
		'
		
);

function get_info_var_type($type,$name="",$rules="",$value="",$forward='back',$title='',$require=''){
	$required = $require == 1 ? "require=\"true\" datatype=\"limit\" msg=\"".$title."不能为空\"" : "";
	if($forward == 'back'){
		switch($type){
			case 'text':
				$mymps_rule_str = $rules[maxlength]?$rules[maxlength]."字符以内":"";
				$mymps .= "<input name=\"extra[".$name."]\" value=\"".$value."\" type=\"text\" size=\"26\" ".$required."> ".$mymps_rule_str;
			break;
			case 'textarea':
				$mymps_rule_str = $rules[maxlength]?"<br />不得超过".$rules[maxlength]."个字符":"";
				$mymps = "<textarea name=\"extra[".$name."]\"  ".$required.">".$value."</textarea> ".$mymps_rule_str;
			break;
			case 'radio':
				$i = 0;
				foreach($rules as $k => $v){
					$i = $i + 1;
					$mymps .= "<label for=\"".$name.$k."\"><input id=\"".$name.$k."\" name=\"extra[".$name."]\" type=\"radio\" class=\"radio\" value=\"".$k."\"";
					$mymps .= ($k == $value || $i == 1)?"checked":"";
					$mymps .= ">".$v."</label> ";
				}
				$i = $endrules = NULL;
			break;
			case 'checkbox':
				$count = $require == 1 ? count($rules) : "";
				$new_value = explode(",",$value);
				$required = "min=1 max=$count require=\"true\" datatype=\"limit|group\" msgid = $title  msg=\"必须要选择一个".$title."\"";
				$mymps = "<div class=\"checkboxinner style=float:left;\">";
				foreach($rules as $k => $v){
					$mymps .= "<label for=\"".$name.$k."\" style=\"margin:0 10px 0 0;\"><input $required id=\"".$name.$k."\" name=\"extra[".$name."][]\" type=\"checkbox\" class=\"checkbox\" value=\"".$k."\"";
					$mymps .= in_array($k,$new_value)?"checked":"";
					$mymps .=">".$v."</label>";
				}
				$mymps .= "</div>";
				$endrules = $required = NULL;
			break;
			case 'select':
				$mymps .="<div class=\"select\">";
				//$mymps .="<label class=\"psu\">请选择</label>";
				$mymps .= "<select name=\"extra[".$name."]\" class=\"decorate\" ".$required.">";
				$mymps .= "<option value=\"\">请选择".$title."</option>";
				foreach($rules as $k => $v){
					$mymps .= "<option value=\"".$k."\"";
					$mymps .= ($k == $value)?"selected ":"";
					$mymps .=">".$v."</option> ";
				}
				$mymps .= "</select>";
				$mymps .="</div>";
			break;
			case 'number':
				$required = $require == 1 ? "require=\"true\" datatype=\"limit|double\" msg=\"请填写".$title."，0 表示面议\"" : "";
				$mymps .= "<input $required msgid=\"".$title."\" name=\"extra[".$name."]\" value=\"".$value."\" type=\"text\"> <span class=units>".$rules[units]."</span>";
			break;
		}
	} else {
		switch($type){
			case 'text':
				$mymps_rule_str = $rules[maxlength]?$rules[maxlength]."字符以内":"";
				$mymps .= "<input name=\"".$name."\" value=\"".$value."\" type=\"text\" size=\"26\"> ".$mymps_rule_str;
			break;
			case 'textarea':
				$mymps_rule_str = $rules[maxlength]?"<br />不得超过".$rules[maxlength]."个字符":"";
				$mymps = "<textarea name=\"".$name."\"  cols=\"100\" rows=\"10\" class=\"input\">".$value."</textarea> ".$mymps_rule_str;
			break;
			case 'radio':
				foreach($rules as $k => $v){
					$mymps .= "<label for=\"".$name.$k."\"><input id=\"".$name.$k."\" name=\"extra[".$name."]\" type=\"radio\" class=\"radio\" value=\"".$k."\"";
					$mymps .= ($k == $value)?"checked":"";
					$mymps .= ">".$v."</label> ";
				}
				$endrules = NULL;
			break;
			case 'checkbox':
				$new_value = explode(",",$value);
				foreach($rules as $k => $v){
					$mymps .= "<label for=\"".$name.$k."\" style=\"margin:0 10px 0 0;\"><input id=\"".$name.$k."\" name=\"".$name."\" type=\"checkbox\"  class=\"checkbox\" value=\"".$k."\"";
					$mymps .= in_array($k,$new_value)?"checked":"";
					$mymps .=">".$v."</label>";
				}
			break;
			case 'select':
				$mymps .= "<select name=\"".$name."\" class=\"decorate\" >";
				$mymps .= "<option value=\"\">请选择".$title."</option>";
				foreach($rules as $k => $v){
					$mymps .= "<option value=\"".$k."\"";
					$mymps .= ($k == $value)?"selected ":"";
					$mymps .=">".$v."</option> ";
				}
				$mymps .= "</select>";
			break;
			case 'number':
				$mymps .= "<input name=\"".$name."[min]\" type=\"text\"> 至 <input  name=\"".$name."[max]\" type=\"text\" float:none;\"> ";
			break;
		}
	}
	return $mymps;
}

function return_category_info_options($modid = '',$edit_id = ''){
	global $db,$db_mymps,$charset;
	$return = array();
	$row = $db->getRow("SELECT id,options FROM `{$db_mymps}info_typemodels` WHERE id = '$modid'");
	$option=explode(",",$row[options]);
	foreach($option as $w=>$u){
		$res = $db->getRow("SELECT title,identifier,type,rules,required FROM `{$db_mymps}info_typeoptions` WHERE optionid='$u'");
		$required	= $res[required]=='on'? 1 : '';
		$extra		= ($charset == 'utf-8')	? utf8_unserialize($res[rules])	: unserialize($res[rules]);
		if(is_array($extra)){
			if($edit_id) $get = $db ->getRow("SELECT * FROM `{$db_mymps}information_{$modid}` WHERE id = '$edit_id'");
			$get_value = $get[$res[identifier]];
			foreach($extra as $k => $value){
				if($res[type] == 'radio' || $res[type] == 'select' || $res[type] == 'checkbox'){
					$extra = arraychange($value);
				}elseif($res[type] == 'number' && $k == 'units'){
					continue;
				}
				$returns['required']  =  $required;
				$returns['title']	  =  $res['title'];
				$returns['value']	  =  get_info_var_type($res[type],$res[identifier],$extra,$get_value,'back',$res['title'],$required);
				$return[] = $returns;
			}
		}
	}
	return $return ? $return : NULL;
}
?>