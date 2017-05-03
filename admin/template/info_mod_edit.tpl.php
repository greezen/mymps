<?php include mymps_tpl('inc_head');?>
<script type="text/javascript">
function copyoption(s1, s2) {
	var s1 = $obj(s1);
	var s2 = $obj(s2);
	var len = s1.options.length;
	for(var i=0; i<len; i++) {
		op = s1.options[i];
		if(op.selected == true && !optionexists(s2, op.value)) {
			o = op.cloneNode(true);
			s2.appendChild(o);
		}
	}
}

function optionexists(s1, value) {
	var len = s1.options.length;
		for(var i=0; i<len; i++) {
			if(s1.options[i].value == value) {
				return true;
			}
		}
	return false;
}

function removeoption(s1) {
	var s1 = $obj(s1);
	var len = s1.options.length;
	for(var i=s1.options.length - 1; i>-1; i--) {
		op = s1.options[i];
		if(op.selected && op.selected == true) {
			s1.removeChild(op);
		}
	}
	return false;
}

function selectalloption(s1) {
	var s1 = $obj(s1);
	var len = s1.options.length;
	for(var i=s1.options.length - 1; i>-1; i--) {
		op = s1.options[i];
		op.selected = true;
	}
}

function moveUp(selectObj) 
{ 
    var theObjOptions=selectObj.options;
    for(var i=1;i<theObjOptions.length;i++) {
        if( theObjOptions[i].selected && !theObjOptions[i-1].selected ) {
            swapOptionProperties(theObjOptions[i],theObjOptions[i-1]);
        }
    }
} 

function moveDown(selectObj) 
{ 
    var theObjOptions=selectObj.options;
    for(var i=theObjOptions.length-2;i>-1;i--) {
        if( theObjOptions[i].selected && !theObjOptions[i+1].selected ) {
            swapOptionProperties(theObjOptions[i],theObjOptions[i+1]);
        }
    }
} 

function move(index,to) {
	var list = document.form1.moptselect;
	var total = list.options.length-1;
	if (index == -1) return false;
	if (to == +1 && index == total) return false;
	if (to == -1 && index == 0) return false;
	var items = new Array;
	var values = new Array;
	for (i = total; i >= 0; i--) {
		items[i] = list.options[i].text;
		values[i] = list.options[i].value;
	}
	for (i = total; i >= 0; i--) {
	if (index == i) {
		list.options[i + to] = new Option(items[i],values[i + to], 0, 1);
		list.options[i] = new Option(items[i + to], values[i]);
		i--;
	} else {
		list.options[i] = new Option(items[i], values[i]);
	   }
	}
	list.focus();
}

function swapOptionProperties(option1,option2){
    //option1.swapNode(option2);
    var tempStr=option1.value;
    option1.value=option2.value;
    option2.value=tempStr;
    tempStr=option1.text;
    option1.text=option2.text;
    option2.text=tempStr;
    tempStr=option1.selected;
    option1.selected=option2.selected;
    option2.selected=tempStr;
}
</script>
<form method="post" name="form1" action="?part=mod&action=update" onsubmit="selectalloption('moptselect');">
<input name="id" value="<?=$edit['id']?>" type="hidden">
<div id="<?=MPS_SOFTNAME?>">
<table border="0" cellspacing="0" cellpadding="0" class="vbm">
    <tr class="firstr">
    <td colspan="2">分类选项基本设置</td>
    </tr>
    <tr bgcolor="#f5fbff">
      <td width="15%">模型名称</td>
      <td bgcolor="#f5fbff"><input name="name" value="<?=$edit['name']?>" type="text" class="text"></td>
    </tr>
    <tr bgcolor="#f5fbff">
      <td width="15%">显示顺序</td>
      <td bgcolor="#f5fbff"><input name="displayorder" value="<?=$edit['displayorder']?>" type="text" class="text"></td>
    </tr>
</table>
</div>
<div id="<?=MPS_SOFTNAME?>">
    <table border="0" cellpadding="0" cellspacing="0" class="vbm">
    <tr class="firstr">
    <td colspan="3">模型选项设置</td>
    </tr>
    <tr>
    <td width="15%" bgcolor="#f5fbff"><b><?=$edit['name']?><br>使用的字段：</b></td>
    <td bgcolor="#f5fbff" width="300">
    <select name="options[]" size="10" multiple="multiple" style="width: 300px; border:2px #26C67F solid;" id="moptselect">
    <?php if(is_array($options)){foreach ($options as $k=>$value){
        $get=$db->getRow("SELECT optionid,title,type,identifier FROM `{$db_mymps}info_typeoptions` WHERE optionid = '$value'");
    	?>
        <option value="<?=$value?>"><?=$get[title]?> / <?=$get[identifier]?> / <?=$get[type]?></option>
	<?}}?>
    </select><br /><a href="###" onclick="removeoption('moptselect')">[删除]</a>    </td>
    <td bgcolor="#f5fbff" title="left">
	<input type="button" value="↑" 
onClick="moveUp(this.form.moptselect)"><br><br>
<input type="button" value="↓"
onClick="moveDown(this.form.moptselect)">
	</td>
    </tr>
    <tr>
    <td width="15%" bgcolor="#f5fbff"><b>可添加的系统字段：</b></td>
    <td colspan="2" bgcolor="#f5fbff">
    <select name="" size="20" multiple="multiple" style="width: 300px" id="coptselect">
    <?php echo $opt;?>
    </select>
    <br /><a href="###" onclick="copyoption('coptselect', 'moptselect')">[添加到<?=$edit['name']?>中]</a>    </td></tr>
    </table>
</div>
<center>
<input type="submit" value="提 交" class="mymps large" <?php if($edit['id'] == 1) echo 'disabled'; ?>/>　
<input type="button" onclick="location.href='?part=mod&action=list';" value="返 回" class="gray large">
</center>
<?php mymps_admin_tpl_global_foot();?>