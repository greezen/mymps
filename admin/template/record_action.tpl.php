<?php include mymps_tpl('inc_head');?>
<?php if($do == 'admin'){?>
<div id="<?=MPS_SOFTNAME?>" style="padding-bottom:0">
	<div class="mpstopic-category">
		<div class="panel-tab">
			<ul class="clearfix tab-list">
				<li><a href="?do=<?=$do?>&part=login" <?php if($part == 'login'){?>class="current"<?php }?>>管理登录记录</a></li>
				<li><a href="?do=<?=$do?>&part=action" <?php if($part == 'action'){?>class="current"<?php }?>>管理操作记录</a></li>
			</ul>
		</div>
	</div>
</div>
<?} ?>
<div class="ccc2">
    <ul>
      <form action="?" name="form1" method="get">
        <input name="do" value="<?=$do?>" type="hidden">
        <input name="part" value="action" type="hidden">
        <input name="keywords" class="text" value="<?=$keywords?>">
        <input type="submit" value="模糊搜索" class="gray mini">&nbsp;&nbsp;
        <input type="button" value="只保存最新的<?=$mymps_mymps['cfg_record_save']?>条记录" class="mymps mini" onclick="location.href='?do=<?=$do?>&part=<?=$part?>&action=delrecord&url=<?=urlencode(GetUrl())?>'" <?php if($do == 'member'){echo "disabled";}?>>
    </form>
</ul>
</div>
<div id="<?=MPS_SOFTNAME?>">
    <table border="0" cellspacing="0" cellpadding="0" class="vbm">
      <form name='form1' method='post' action='?do=<?=$do?>&part=<?=$part?>' onSubmit='return checkSubmit();'>
        <input type='hidden' name='action' value='delall'/>
        <input name="url" type="hidden" value="<?=GetUrl()?>">
        <tr class="firstr">
            <td width="30">选择</td>
            <td width="80">操作者</td>
            <td width="120">用户组</td>
            <td width="150">操作时间</td>
            <td width="100">IP地址</td>
            <td>动作 / 操作提示</td>
        </tr>
        <tbody onmouseover="addMouseEvent(this);">
            <?foreach($record AS $k){?>
            <tr bgcolor="white">
                <td><input type='checkbox' name='id[]' value='<?=$k[id]?>' class='checkbox' id="<?=$k[id]?>"></td>
                <td><?=$k[adminid]?></td>
                <td><?=$k[typename]?></td>
                <td><em><?=$k[pubdate]?></em></td>
                <td><?=$k[ip]?></td>
                <td align="left"><?=$k[action]?></td>
            </tr>
            <?
        }
        ?>
    </tbody>
    <tr bgcolor="#ffffff" height="28">
        <td style="border-right:1px #fff solid;"><input name="checkall" type="checkbox" id="checkall" onClick="CheckAll(this.form)" class="checkbox"/></td>
        <td colspan="10">　
        <input type="submit" onClick="javascript:if(!confirm('确定要操作吗？\n\n此操作不可以恢复！'))return false;" value="批量删除" class="mymps mini" <?php if($do == 'admin'){echo "disabled";}?>/>      
        </td>
    </tr>
</form>
</table>
</div>
<div class="pagination"><?=page2()?></div>
<?php mymps_admin_tpl_global_foot();?>