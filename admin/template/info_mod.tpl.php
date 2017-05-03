<?php include mymps_tpl('inc_head');?>
<script type="text/javascript">
function copyoption(s1, s2) {
	var s1 = $(s1);
	var s2 = $(s2);
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
	var s1 = $(s1);
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
	var s1 = $(s1);
	var len = s1.options.length;
	for(var i=s1.options.length - 1; i>-1; i--) {
		op = s1.options[i];
		op.selected = true;
	}
}
</script>
<form name='form1' method='post' action='?part=mod&action=delall'>
<div id="<?=MPS_SOFTNAME?>">
<table border="0" cellspacing="0" cellpadding="0" class="vbm">
   
    <tr class="firstr">
      <td width="50"><input class="checkbox" name="checkall" type="checkbox" id="checkall" onClick="CheckAll(this.form)"/>删?</td>
      <td width="50">编号</td>
      <td>名称</td>
      <td>显示顺序</td>
      <td>编辑</td>
    </tr>
<tbody onmouseover="addMouseEvent(this);">
<?php foreach($mod as $k =>$value){?>
    <tr align="center" bgcolor="white">
      <td><input type='checkbox' class="checkbox" name='id[]' value='<?=$value[id]?>' <?php if($value[type]=='1'){echo "disabled";}?>/></td>
      <td><?=$value[id]?></td>
      <td><?=$value[name]?></td>
      <td><?=$value[displayorder]?></td>
      <td><a href="?part=mod&action=edit&id=<?=$value[id]?>">详情</a></td>
    </tr>
<?}?>
	</tbody>
	</table>
	</div>
<center><input type="submit" onClick="if(!confirm('确定要删除该模型吗？\n\n此操作不可以恢复！'))return false;" value="提 交" class="mymps large"/></center>
</form>
<div class="clear" style="height:10px;"></div>
<form action="?part=mod&action=insert" method="post" name="form2">
<div id="<?=MPS_SOFTNAME?>">
<table border="0" cellspacing="0" cellpadding="0" class="vbm">
    <tr class="firstr">
    <td colspan="2">新增模型</td>
    </tr>
    <tr bgcolor="#ffffff">
      <td width="15%"><b>模型名称</b></td>
      <td><input name="name" type="text" class="text"></td>
    </tr>
    <tr bgcolor="#ffffff">
      <td><b>显示顺序</b></td>
      <td><input name="displayorder" type="text" class="text" value="0"></td>
    </tr>
    </table>
</div>
<center><input type="submit" value="提 交" class="mymps large"/></center>
</form>
<?php mymps_admin_tpl_global_foot();?>