<?php include mymps_tpl('inc_head');?>
<div id="<?=MPS_SOFTNAME?>" style="padding-bottom:0">
	<div class="mpstopic-category">
		<div class="panel-tab">
			<ul class="clearfix tab-list">
				<li><a href="?part=intro" <?php if($part == 'intro'){?>class="current"<?php }?>>广告位详细介绍</a></li>
				<li><a href="?" <?php if($part == 'list'){?>class="current"<?php }?>>广告列表</a></li>
			</ul>
			<ul style="float:right; text-align:right">
				<?php if(!$admin_cityid){?>
				<select name="cityid" onChange="location.href='?page=<?=$page?>&type=<?=$info_level?>&cityid='+(this.options[this.selectedIndex].value)">
					<option value="0">总站</option>
					<?php echo get_cityoptions($cityid); ?>
				</select>
				<?}?>
				<select name="type" onChange="location.href='?cityid=<?=$cityid?>&type='+(this.options[this.selectedIndex].value)">
					<option value="">==按广告类型筛选==</option>
					<?php foreach($vbm_adv_type as $k=>$v){?>
					<option value="<?=$k?>" <?php if($k == $type) echo 'selected'; ?>><?=$v[name]?></option>
					<?php }?>
				</select>
			</ul>
		</div>
	</div>
</div>
<div id="<?=MPS_SOFTNAME?>">
	<table border="0" cellspacing="0" cellpadding="0" class="vbm">
		<tr class="firstr">
			<td>添加广告</td>
		</tr>
		<tr bgcolor="#ffffff">
			<td>
				<form method="get" action="?">
					<input name="part" value="add" type="hidden"/>
					广告标题：<input style="vertical-align: middle" class="text" type="text" name="title" value="" size="25" maxlength="50"> <?=get_adv_style()?>
					<?=get_adv_option();?>
				</form>
			</td>
		</tr>
	</table>
</div>
<form name='form1' method='post' action='adv.php'>
	<input name="forward_url" value="<?=GetUrl()?>" type="hidden">
	<input name="part" value="<?=$part?>" type="hidden"/>
	<div id="<?=MPS_SOFTNAME?>">
		<table border="0" cellspacing="0" cellpadding="0" class="vbm">
			<tr class="firstr">
				<td width="5%">
					<input name="chkall" type="checkbox" onclick="AllCheck('prefix', this.form, 'delids')" class="checkbox"/>删?</td>
					<td width="5%">可用</td>
					<td width="8%">显示顺序</td>
					<td width="15%">标题</td>
					<td width="12%">类型</td>
					<td width="5%">样式</td>
					<td width="8%">起始时间</td>
					<td width="8%">终止时间</td>
					<td width="10%">详情</td>
				</tr>
				<?php foreach($adv as $k =>$value){?>
				<tr bgcolor="white">
					<td><input class="checkbox" type='checkbox' name='delids[]' value='<?=$value[advid]?>' id="<?=$value[advid]?>"></td>
					<td><input class="checkbox" type="checkbox" name="available[<?=$value[advid]?>]" value="1" <?php if ($value['available'] == 1){echo 'checked';}?>/></td>
					<td><input name="displayorder[<?=$value[advid]?>]" value="<?=$value[displayorder]?>" type="text" class="txt"/></td>
					<td><input name="titlenew[<?=$value[advid]?>]" value="<?=$value[title]?>" type="text" class="text" style="width:100px"/></td>
					<td><a href="?cityid=<?=$cityid?>&type=<?=$value[type]?>"><?=$vbm_adv_type[$value[type]][name]?></a></td>
					<td>
						<?php 
						$adv_style = ($charset == 'utf-8') ? utf8_unserialize($value[parameters]) : unserialize($value[parameters]);
						echo $vbm_adv_style[$adv_style[style]];
						?></td>
						<td><em><?php echo $value[starttime] ? GetTime($value[starttime],'Y-m-d') : '-'; ?></em></td>
						<td><em><?php echo $value[endtime] ? GetTime($value[endtime],'Y-m-d') : '-'; ?></em></td>
						<td><a href="?part=edit&advid=<?=$value[advid]?>">编辑</a> <?php if(!in_array($value[type],array('couplead','floatad'))){?>&nbsp;&nbsp;<a href="
							javascript:setbg('广告预览',550,110,'../box.php?part=advertisementview&id=<?=$value[advid]?>')">预览</a><?php }?> <?php if($value[type] == 'normalad'){?> &nbsp;&nbsp;<a href="
							javascript:setbg('自定义广告调用',550,110,'../box.php?part=advertisement&id=<?=$value[advid]?>')">调用</a><?}?></td>
						</tr>
						<?php }?>
					</table>
				</div>
				<center>
					<input type="submit" value="提 交" class="mymps large" name="<?=CURSCRIPT?>_submit"/>  
				</center>
			</form>
			<div class="pagination"><?php echo page2();?></div>
			<?php mymps_admin_tpl_global_foot();?>