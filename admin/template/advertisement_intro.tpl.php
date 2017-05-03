<?php include mymps_tpl('inc_head');?>
<style>
	.smalltxt{ font-size:12px!important; color:#999!important; font-weight:100!important}
	.altbg1{ background-color:#f1f5f8; width:20%}
	.altbg2{ background-color:white;}
	.altbg2 li{ margin:5px auto;}
</style>
<div id="<?=MPS_SOFTNAME?>" style="padding-bottom:0">
	<div class="mpstopic-category">
		<div class="panel-tab">
			<ul class="clearfix tab-list">
				<li><a href="?part=intro" <?php if($part == 'intro'){?>class="current"<?php }?>>广告位详细介绍</a></li>
				<li><a href="?" <?php if($part == 'list'){?>class="current"<?php }?>>广告列表</a></li>
			</ul>
		</div>
	</div>
</div>

<div id="<?=MPS_SOFTNAME?>">
	<table border="0" cellspacing="0" cellpadding="0" class="vbm">
		<tr class="firstr"><td colspan="2">详细介绍</td></tr>
		<?php foreach($vbm_adv_type as $k => $v){?>
		<tr>
			<td width="45%" class="altbg1"><b><?=$v[name]?>:</b></td>
			<td class="altbg2"><?=$v[notice]?>
			</td>
		</tr>
		<?php }?>
	</table>
</div>
<?php mymps_admin_tpl_global_foot();?>