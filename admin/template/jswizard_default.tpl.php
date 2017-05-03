<?php include mymps_tpl('inc_head');?>

<style>
.smalltxt{ font-size:12px!important; color:#999!important; font-weight:100!important}
.altbg1{ background-color:#f1f5f8}
</style>
<div id="<?=MPS_SOFTNAME?>" style=" padding-bottom:0">
    <div class="mpstopic-category">
        <div class="panel-tab">
            <ul class="clearfix tab-list">
                <li><a href="?part=settings">基本设置</a></li>
                <li><a href="?" class="current">调用项目管理</a></li>
            </ul>
        </div>
    </div>
</div>
<div id="<?=MPS_SOFTNAME?>">
<table border="0" cellspacing="0" cellpadding="0" class="vbm">
    <form method="get" action="?">
    <input name="part" value="add" type="hidden">
    <tr class="firstr"><td colspan="2">添加数据调用</td></tr>
    <tr>
    <td class="altbg1" width="160">自定义标签名<br><font color="gray">请输入一个便于记忆的能代表此数据调用脚本作用的标识，建议用英文或数字表示</font></td>
    <td><input type="text" name="flag" value="<?=$randam?>" class="text" style="line-height:18px"/></td>
    </tr>
    <tr>
    <td class="altbg1">调用类型</td>
    <td>
    <select name="customtype">
    <? foreach($customtypearr as $k =>$v){?>
    <option value="<?=$k?>"><?=$v?></option>
	<? }?>
    </select>
    </td>
    </tr>
    <tr bgcolor="#ffffff">
    <td>
    </td>
    <td>
    <input type="submit" value="添加调用项目" class="mymps large"/>
    </td>
    </tr>
    </form>
</table>
</div>
<form name='form1' method='post' action='?'>
<input name="forward_url" value="<?=GetUrl()?>" type="hidden">
<input name="part" value="<?=$part?>" type="hidden"/>
<div id="<?=MPS_SOFTNAME?>">
<table border="0" cellspacing="0" cellpadding="0" class="vbm">
<tr class="firstr">
<td width="5%"><input class="checkbox" name="checkall" type="checkbox" id="checkall" onClick="CheckAll(this.form)"/>删?</td>
<td width="15%">标签名</td>
<td>调用类型</td>
<td width="15%">添加时间</td>
<td width="15%">调用代码</td>
</tr>

<?php 
if(is_array($jswizard)){
	foreach($jswizard as $key => $val){?>
<tr bgcolor="white">
  <td><input class="checkbox" type='checkbox' name='delids[]' value='<?=$val[id]?>' id="<?=$val[id]?>"></td>
  <td><a href="?part=detail&id=<?=$val['id']?>"><?=$val['flag']?></a></td>
  <td><?=$customtypearr[$val['customtype']] ? $customtypearr[$val['customtype']] : '分类信息'?></td>
  <td><?=GetTime($val['edittime'])?></td>
  <td>
  <a href="javascript:void(0);" onclick="setbg('站内调用',550,110,'../box.php?part=custom&flag=<?=$val[flag]?><?php if($val['jscharset'] == 1) echo '&jscharset=1'; ?>')">站内调用</a> 
  &nbsp;&nbsp;
  <a href="javascript:void(0);" onclick="setbg('站外调用',550,110,'../box.php?part=jswizard&flag=<?=$val[flag]?><?php if($val['jscharset'] == 1) echo '&jscharset=1'; ?>')">站外调用</a></td>
</tr>
<?php 
	}
}
?>

</table>
</div>
<center>
<input type="submit" value="提 交" class="mymps large" name="<?=CURSCRIPT?>_submit"/>  
</center>
</form>
<div class="pagination"><?php echo page2();?></div>
<?php mymps_admin_tpl_global_foot();?>