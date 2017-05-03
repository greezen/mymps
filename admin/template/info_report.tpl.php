<? include mymps_tpl('inc_head');?>
<script type="text/javascript" src="/template/global/messagebox.js"></script>
<div id="<?=MPS_SOFTNAME?>" style=" padding-bottom:0">
    <div class="mpstopic-category">
        <div class="panel-tab">
            <ul class="clearfix tab-list">
            <li><a href="?part=report" <?php if($report_type == ''){?>class="current"<?php }?>>全部举报记录</a></li>
            <?php foreach($report_type_arr as $k => $v){?>
                <li><a href="?part=report&report_type=<?=$k?>" <?php if($report_type==$k){?>class="current"<?php }?>><?=$v?></a></li>
            <?php }?>
            </ul>
        </div>
    </div>
</div>
<form name='form1' method='post' action='?part=<?=$part?>' onSubmit='return checkSubmit();'>
<input name="url" type="hidden" value="<?=GetUrl()?>">
<input name="action" type="hidden" value="delall">
<div id="<?=MPS_SOFTNAME?>">
<table border="0" cellspacing="0" cellpadding="0" class="vbm">
    <tr class="firstr">
      <td width="60"><input name="checkall" type="checkbox" id="checkall" onClick="CheckAll(this.form)" class="checkbox"/>删?</td>
      <td width="30">编号</td>
   	  <td>举报对象</td>
      <td>附加描述</td>
      <td>举报时间</td>
      <td>举报IP</td>
      <td>相关操作</td>
    </tr>
    <tbody onmouseover="addMouseEvent(this);">
<?php foreach($report AS $v){
?>
    <tr align="center" bgcolor="white">
      <td><input type='checkbox' name='id[]' value='<?=$v[id]?>' id="<?=$v[id]?>" class="checkbox"></td>
      <td><?=$v[id]?></td>
      <td><a href="../information.php?id=<?=$v[infoid]?>" target="_blank"><?=$v[infotitle]?></a>&nbsp;</td>
	  <td><?=$v[content]?>&nbsp;</td>
      <td><em><?=$v[pubtime]?></em></td>
      <td><?=$v[ip]?></td>
      <td><a href="?keywords=<?=$v[infoid]?>&show=idno">查看该信息</a></td>
    </tr>
<?php }?>
</tbody>
</table>
</div>
<center><input type="submit" onClick="if(!confirm('确定要操作吗？'))return false;" value="执行操作" class="mymps mini"/></center>
</form>
<div class="pagination"><?=page2()?></div>
<?=mymps_admin_tpl_global_foot();?>