<?php
if (!defined('IN_MYMPS'))
{
    die('FORBIDDEN');
}
//user for option_edit
$mymps_admin_info_type=array(
	"number"=>'
		<tr>
		<td bgcolor="#f5fbff" width="45%" ><b>数值最大值（可选）:</b></td>
		<td bgcolor="#f5fbff"><input type="text" size="50" name="rules[number][maxnum]" value="'.$rules.'" >
		</td>
		</tr>
		<tr>
		<td bgcolor="#f5fbff" width="45%" ><b>数值最小值（可选）:</b></td>
		<td bgcolor="#f5fbff"><input type="text" size="50" name="rules[number][minnum]" value="'.$rules.'" >
		</td>
		</tr>
		',
	"text"=>'
		<tr>
		<td bgcolor="#f5fbff" width="45%" >
		<b>内容最大长度（可选）:</b>
		</td>
		<td bgcolor="#f5fbff">
		<input type="text" size="50" name="rules[text][maxlength]" value="'.$rules.'" >
		</td>
		</tr>
		',
	"textarea"=>'
		<tr>
		<td bgcolor="#f5fbff" width="45%" >
		<b>内容最大长度（可选）:</b>
		</td>
		<td bgcolor="#f5fbff">
		<input type="text" size="50" name="rules[textarea][maxlength]" value="'.$rules.'" >
		</td>
		</tr>
		',
	"select"=>'
		<tr>
		<td bgcolor="#f5fbff" width="25%">
		<b>选项内容:</b><br />只在项目为可选时有效，每行一个选项，等号前面为选项索引(建议用数字)，后面为内容，例如: <br /><i>1 = 光电鼠标<br />2 = 机械鼠标<br />3 = 没有鼠标</i><br /><br />注意: 选项确定后请勿修改索引和内容的对应关系，但仍可以新增选项。如需调换显示顺序，可以通过移动整行的上下位置来实现</td>
		<td bgcolor="#f5fbff">
	<textarea rows="8" name="rules[select][choices]" id="rules[select][choices]" cols="50">'.$rules.'</textarea>
		</td>
		</tr>
		',
	"radio"=>'
		<tr>
		<td bgcolor="#f5fbff" width="45%">
		<b>选项内容:</b><br />只在项目为可选时有效，每行一个选项，等号前面为选项索引(建议用数字)，后面为内容，例如: <br /><i>1 = 光电鼠标<br />2 = 机械鼠标<br />3 = 没有鼠标</i><br />注意: 选项确定后请勿修改索引和内容的对应关系，但仍可以新增选项。如需调换显示顺序，可以通过移动整行的上下位置来实现
		</td>
		<td bgcolor="#f5fbff">
		<textarea  rows="8" name="rules[radio][choices]" id="rules[radio][choices]" cols="50">'.$rules.'</textarea>
		</td>
		</tr>
		',
	"checkbox"=>'
		<tr>
		<td bgcolor="#f5fbff" width="45%">
		<b>选项内容:</b><br />只在项目为可选时有效，每行一个选项，等号前面为选项索引(建议用数字)，后面为内容，例如: <br /><i>1 = 光电鼠标<br />2 = 机械鼠标<br />3 = 没有鼠标</i><br />注意: 选项确定后请勿修改索引和内容的对应关系，但仍可以新增选项。如需调换显示顺序，可以通过移动整行的上下位置来实现</td>
		<td bgcolor="#f5fbff">
		<textarea  rows="8" name="rules[checkbox][choices]" id="rules[checkbox][choices]" cols="50">'.$rules.'</textarea>
		</td>
		</tr>
		',
	"image"=>'
		<tr>
		<td bgcolor="#f5fbff" width="45%" ><b>图片最大宽度（可选）:</b></td>
		<td bgcolor="#f5fbff"><input type="text" size="50" name="rules[image][maxwidth]" value="'.$rules.'" >
		</td>
		</tr>
		<tr>
		<td bgcolor="#f5fbff" width="45%" ><b>图片最大高度（可选）:</b></td>
		<td bgcolor="#f5fbff"><input type="text" size="50" name="rules[image][maxheight]" value="'.$rules.'" >
		</td>
		</tr>
		'
);

$var_type= array(
	'text'=>'字串',
	'number'=>'数字',
	'textarea'=>'文本',
	'radio'=>'单选',
	'checkbox'=>'多选',
	'select'=>'选择',
	'age'=>'年龄',
	'email'=>'电子邮件',
	'image'=>'图片',
	'url'=>'超级链接',
	'calendar'=>'日历'
);


function get_info_var_type($type,$name,$value){
	switch($type){
		case 'text':
			$str.="<input name=\"".$name."\" value=\"".$value."\">";
		break; 
		case 'textarea':
			$str.="<textarea name=\"".$name."\">".$value."</textarea>";
		break;
		case 'radio':
			$str.="<input name=\"".$name."\" type=\"radio\">";
		break;
		case 'checkbox':
			$str.="<input name=\"".$name."\" type=\"checkbox\">";
		break;
		case 'select':
			$str.="<select name=\"".$name."\">";
			$str.="<option value=\"".$value."\"></option>";
			$str.="</select>";
		break;
	}
	return $str;
}
?>