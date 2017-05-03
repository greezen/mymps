<?php include mymps_tpl('inc_head_jq');?>
<script type="text/javascript" src="../include/datepicker/datepicker.js"></script>
<link rel="stylesheet" href="../include/datepicker/ui.css">
<script language='javascript'>
	$(function(){
		$("#datepicker1").datepicker();
		$("#datepicker2").datepicker();
	});
</script>
<div id="<?=MPS_SOFTNAME?>">
	<table border="0" cellspacing="0" cellpadding="0" class="vbm">
		<tr class="firstr">
			<td colspan="5">
				<div class="left">
					<a href="javascript:collapse_change('tip')">技巧提示</a></div>
					<div class="right"><a href="javascript:collapse_change('tip')"><img id="menuimg_tip" src="template/images/menu_reduce.gif"/></a></div>
				</td>
			</tr>
			<tr>
				<td id="menu_tip" bgcolor="white">
					<?php echo $type ? $vbm_adv_type[$type][notice] : $vbm_adv_type[$edit[type]][notice];?>
				</td>
			</tr>
		</table>
	</div>
	<form method="post" name="settings" action="adv.php?advid=<?=$advid?>">
		<input name="part" value="adv<?=$part?>" type="hidden"/>
		<input name="type" value="<?php echo $type ? $type : $edit[type] ;?>" type="hidden"/>
		<input name="oldcityid" value="<?=$edit['cityid']?>" type="hidden">
		<?php if($advid){?>
		<input name="forward_url" value="<?php echo GetUrl(); ?>" type="hidden">
		<?php }?>
		<div id="<?=MPS_SOFTNAME?>">
			<table border="0" cellspacing="0" cellpadding="0" class="vbm">
				<tr class="firstr">
					<td colspan="2">
						<div class="left">
							<a href="javascript:collapse_change('float')"><?php echo $type ? $vbm_adv_type[$type][name] : $vbm_adv_type[$edit[type]][name];?></a></div>
							<div class="right"><a href="javascript:collapse_change('float')"><img id="menuimg_float" src="template/images/menu_reduce.gif"/></a></div>
						</td>
					</tr>

					<tbody id="menu_float" style="display: yes">
						<?php if(!$admin_cityid){?>
						<tr>
							<td width="45%" bgcolor="white" >隶属分站：</td>
							<td>
								<select name="advnew[cityid]">
									<option value="0">总站</option>
									<?php echo get_cityoptions($edit[cityid]); ?>
								</select>
							</td>
						</tr>
						<?}else{?>
						<input name="advnew[cityid]" type="hidden" value="<?php echo $admin_cityid; ?>">
						<?php }?> 
						<tr>
							<td width="45%" bgcolor="white" >展现方式:<br /><i style="color:#666">请选择所需的广告展现方式</i></td><td bgcolor="white"><?php echo $style ? get_adv_style($style,'advnew[style]') : get_adv_style($adv_style[style],'advnew[style]') ; ?></td></tr>
							<tr><td width="45%" bgcolor="white" >广告标题(<font color="red">*必填</font>):<br /><i style="color:#666">注意: 广告标题只为识别辨认不同广告条目之用，并不在广告中显示</i></td><td bgcolor="white"><input class="text" type="text" size="50" name="advnew[title]" value="<?php echo $title ? $title : $edit[title] ; ?>" >
							</td></tr>
							<?php if($type != 'normalad' && $edit['type'] != 'normalad'){?>
							<tr><td width="45%" bgcolor="white" >广告投放范围(<font color="red">*必选</font>):<br /><i style="color:#666">设置本广告投放的页面或网站范围，可以按住 CTRL 多选，选择“全部”为不限制选择广告投放的范围</i></td><td bgcolor="white">
								<select name="advnew[targets][]" size="15" multiple="multiple">
									<?php if($type == 'infoad' || $edit['type'] == 'infoad'){
										echo get_infoad_target($edit['targets']);
									} else {?>
									<?php if(in_array($type,array('intercatad','interlistad')) || in_array($edit['type'],array('intercatad','interlistad'))){
										$edit['targets'] = $edit['targets'] ? $edit['targets'] : array();
										?>
										<option value="all" <?php if(in_array('all',$edit['targets'])) echo 'selected style="background-color:#6EB00C;color:white"';?>> > 全部</option>
										<option value=""> </option>
										<?}elseif($type == 'indexcatad' || $edit['type'] == 'indexcatad'){?>
										<optgroup label="<?=MPS_SOFTNAME?>网站首页">
											<?}else{
												foreach($adv_target as $kad => $vad){?>
												<option value="<?=$vad?>" <?php if(is_array($edit['targets'])){
													if(in_array($vad,$edit['targets'])){
														echo 'selected style="background-color:#6EB00C;color:white"'; }
													}?>>&nbsp;&nbsp;> <?=$kad?></option>
													<optgroup label="<?=MPS_SOFTNAME?>">
														<?php 
													}}
												}?>

												<?php 
												if($type == 'infoad' || $edit['type'] == 'infoad'){
													
												} elseif($type == 'indexcatad' || $edit['type'] == 'indexcatad') {
													echo cat_list('category',0,$edit['targets'],true,1);
												} else {
													echo cat_list('category',0,$edit['targets']);
												}
												?>
											</optgroup>
										</select>

									</td></tr>
									<?}?>
									<?php if($type == 'interlistad' || $edit['type'] == 'interlistad'){?>
									<tr><td width="45%" bgcolor="#FFFFFF">展示位置(<font color="red">*必填</font>):<br /><i style="color:#666">将广告的展示位置设置在栏目页信息列表头部位置或者尾部位置</i></td><td bgcolor="white">
										<select name="advnew[position]" class="text">
											<option value="top" <?php if($adv_style['position'] != 'bottom') echo 'selected';?>>头部</option>
											<option value="bottom" <?php if($adv_style['position'] == 'bottom') echo 'selected';?>>尾部</option>
										</select>
									</td></tr>
									<?php }?>
									<?php if($type == 'floatad' || $edit['type'] == 'floatad'){?>
									<tr><td width="45%" bgcolor="#FFFFFF">漂浮高度(<font color="red">*必填</font>):<br /><i style="color:#666">漂浮广告距离页面底部的高度，请根据漂浮广告的高度进行适当的调节，允许范围在 40～600 之间，默认值 200</i></td><td bgcolor="white"><input type="text" name="advnew[floath]" value="<?php echo $adv_style['floath'] ? $adv_style['floath'] : '200'?>" class="text">
									</td></tr>
									<?php }?>
									<tr><td width="45%" bgcolor="white" >广告起始时间(选填):<br /><i style="color:#666">设置广告起始生效的时间，格式 yyyy-mm-dd，留空为不限制起始时间</i></td><td bgcolor="white"><input type="text" id="datepicker1" name="advnew[starttime]" value="<?php echo $edit[starttime] ?  GetTime($edit[starttime]) : ''?>" class="text">
									</td></tr><tr><td width="45%" bgcolor="white" >广告结束时间(选填):<br /><i style="color:#666">设置广告广告结束的时间，格式 yyyy-mm-dd，留空为不限制结束时间</i></td><td bgcolor="white"><input id="datepicker2" type="text" name="advnew[endtime]" class="text" value="<?php echo $edit[endtime] ?  GetTime($edit[endtime]) : ''?>">
								</td></tr>
							</table>
						</div>

						<div id="<?=MPS_SOFTNAME?>">
							<?php echo $style ? get_style_forminput('',$style) : get_style_forminput($edit[code],$adv_style); ?>
						</div>

						<center><input type="submit" name="<?=CURSCRIPT?>_submit" class="mymps large" value="提 交"/><br /><br /><a href="adv.php?type=<?php echo $type?type:$edit[type]; ?>&cityid=<?=$edit[cityid]?>" class="back">返回<?php echo $type ? $vbm_adv_type[$type][name] : $vbm_adv_type[$edit[type]][name];?>管理</a><br />
							<br /><a href="adv.php?&cityid=<?=$edit[cityid]?>" class="back">返回广告管理首页</a></center>
						</form>
						<?php mymps_admin_tpl_global_foot();?>