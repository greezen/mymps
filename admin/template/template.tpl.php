<?php include mymps_tpl('inc_head');?>
<script type='text/javascript' src='js/vbm.js'></script>
<script type="text/javascript">
function simplevalue(){
	$Obj('banmian_simple').className='txt';
	$Obj('banmian_portal').className='txt';
	$Obj('banmian_classic').className='txt';
	$Obj('banmian_simple').className='txt checked';
	$Obj('indextopinfo').value='<?php echo $defaultset[simple][indextopinfo];?>';
	$Obj('newinfo').value='<?php echo $defaultset[simple][newinfo];?>';
	$Obj('announce').value='<?php echo $defaultset[simple][announce];?>';
	$Obj('faq').value='<?php echo $defaultset[simple][faq];?>';
	$Obj('lifebox').value='<?php echo $defaultset[simple][lifebox];?>';
	$Obj('telephone').value='<?php echo $defaultset[simple][telephone];?>';
	$Obj('goods').value='<?php echo $defaultset[simple][goods];?>';
	$Obj('foreachinfo').value='<?php echo $defaultset[simple][foreachinfo];?>';
	$Obj('news').value='<?php echo $defaultset[simple][news];?>';
}

function portalvalue(){
	$Obj('banmian_simple').className='txt';
	$Obj('banmian_portal').className='txt';
	$Obj('banmian_classic').className='txt';
	$Obj('banmian_portal').className='txt checked';
	$Obj('indextopinfo').value='<?php echo $defaultset[portal][indextopinfo];?>';
	$Obj('newinfo').value='<?php echo $defaultset[portal][newinfo];?>';
	$Obj('announce').value='<?php echo $defaultset[portal][announce];?>';
	$Obj('faq').value='<?php echo $defaultset[portal][faq];?>';
	$Obj('lifebox').value='<?php echo $defaultset[portal][lifebox];?>';
	$Obj('telephone').value='<?php echo $defaultset[portal][telephone];?>';
	$Obj('goods').value='<?php echo $defaultset[portal][goods];?>';
	$Obj('foreachinfo').value='<?php echo $defaultset[portal][foreachinfo];?>';
	$Obj('news').value='<?php echo $defaultset[portal][news];?>';
}

function classicvalue(){
	$Obj('banmian_simple').className='txt';
	$Obj('banmian_portal').className='txt';
	$Obj('banmian_classic').className='txt';
	$Obj('banmian_classic').className='txt checked';
	$Obj('indextopinfo').value='<?php echo $defaultset[classic][indextopinfo];?>';
	$Obj('newinfo').value='<?php echo $defaultset[classic][newinfo];?>';
	$Obj('announce').value='<?php echo $defaultset[classic][announce];?>';
	$Obj('faq').value='<?php echo $defaultset[classic][faq];?>';
	$Obj('lifebox').value='<?php echo $defaultset[classic][lifebox];?>';
	$Obj('telephone').value='<?php echo $defaultset[classic][telephone];?>';
	$Obj('goods').value='<?php echo $defaultset[classic][goods];?>';
	$Obj('foreachinfo').value='<?php echo $defaultset[classic][foreachinfo];?>';
	$Obj('news').value='<?php echo $defaultset[classic][news];?>';
}
</script>
<style>
.smalltxt{ font-size:12px!important; color:#999!important; font-weight:100!important}
.altbg1{ background-color:#f1f5f8}

.blue{ width:70px; height:30px; display:block; background-color:#3592E2; padding-right:10px;}
.green{ width:70px; height:30px; display:block; background-color:#42B712; padding-right:10px;}
.orange{ width:70px; height:30px; display:block; background-color:#F78015; padding-right:10px;}
.red{ width:70px; height:30px; display:block; background-color:#C40000; padding-right:10px;}

.showtpl1{display:block; height:90px; float:left; text-align:center; margin:10px}
.showtpl1 a{ display:block; width:116px; float:left; height:184px;}
.showtpl1 a.checked img{ border:4px #F90 solid;}
.showtpl1 .txt{ margin-top:5px; float:left;}


.showtpl2{display:block; height:90px; float:left; text-align:center; margin:10px 10px 20px 10px;}
.showtpl2 .txt{ margin-top:5px; float:left; border:1px #ddd solid; padding:10px 0;}
.checked{ border:2px #FFB38C solid!important; background-color:#FFF6F0; padding:5px 0 10px 5px;}

.showtpl1 label,.showtpl2 label{ cursor:pointer;}

.showtpl a:hover,.showindex a:hover{ text-decoration:none; cursor:pointer}</style>
<div id="<?=MPS_SOFTNAME?>" style="padding-bottom:0">
	<div class="mpstopic-category">
		<div class="panel-tab">
			<ul class="clearfix tab-list">
			<li><a href="template.php" class="current">默认模板设置</a></li>
			<li><a href="file_manage.php">风格在线编辑</a></li>
			</ul>
		</div>
	</div>
</div>
<form method="post" action="?">
<input name="return_url" value="<?php echo GetUrl();?>" type="hidden">
<div id="<?=MPS_SOFTNAME?>">
<table border="0" cellspacing="0" cellpadding="0" class="vbm">
	<tr class="firstr"><td colspan="2">网站模板应用设置</td></tr>
	<tr bgcolor="white">
		<td width="20%" class="altbg1" ><b>网站使用模板风格</b><br /><span class="smalltxt"></span></td>
		<td class="altbg2">
		<?php foreach($template['fengge']['flag'] as $k => $v){?>
			<div id="index_<?=$k?>" class="showtpl1 <?php if($mymps_global['cfg_tpl_dir'] == $k){?>checked<?php }?>">
			<label for="<?=$k?>">
			<div class="txt"><span class="<?=$k?>"></span><div class="clearfix"></div><input onclick="$Obj('index_blue').className='showtpl1';$Obj('index_green').className='showtpl1';$Obj('index_orange').className='showtpl1';$Obj('index_red').className='showtpl1';$Obj('index_<?=$k?>').className='showtpl1 checked';<?php if($k == 'red'){ echo '$Obj(\'style_normal\').disabled=true;$Obj(\'style_standard\').checked=true';}else{echo '$Obj(\'style_normal\').disabled=false;';}?>" id="<?=$k?>" name="cfg_tpl_dir" type="radio" class="radio" value="<?=$k?>" <?php if($mymps_global['cfg_tpl_dir'] == $k){?>checked="checked"<?php }?>><?=$v?> <br /><font color="#666">(<?=$k?>)</font></div>
			</label>
			</div>
		<?php }?>
		</td>
	</tr>
	<tr bgcolor="white">
		<td width="20%" class="altbg1" ><b>模板是否显示背景图</b><br /><span class="smalltxt"></span></td>
		<td class="altbg2">
		 	<label for="bodybg_1"><input id="bodybg_1" name="bodybg" type="radio" value="1" <?php if($mymps_global['bodybg'] == '1'){echo ' checked="checked" ';}?>> 是</label>
			<label for="bodybg_0"><input id="bodybg_0" name="bodybg" type="radio" value="0" <?php if($mymps_global['bodybg'] == '0'){?>checked="checked"<?php }?>> 否</label>
		</td>
	</tr>
	<tr bgcolor="white">
		<td width="20%" class="altbg1" ><b>风格样式</b><br /><span class="smalltxt"></span></td>
		<td class="altbg2">
		 	<input id="style_normal" name="head_style" type="radio" value="normal" <?php if($mymps_global['head_style'] == 'normal'){echo ' checked="checked" ';}?> <?php if($mymps_global['cfg_tpl_dir'] == 'red'){echo ' disabled="disabled" ';}?>> 传统样式
			<input id="style_standard" name="head_style" type="radio" value="new" <?php if($mymps_global['head_style'] == 'new'){?>checked="checked"<?php }?>> 扁平化样式
		</td>
	</tr>
	<tr bgcolor="white">
		<td width="20%" class="altbg1" ><b>网页宽度</b><br /><span class="smalltxt"></span></td>
		<td class="altbg2">
			<table width="0" border="0" cellspacing="0" cellpadding="0" style="border:1px #C5D8E8 solid; margin:10px 0 10px 10px">
			<tr>
			  <td style="border-right:1px #C5D8E8 solid; border-bottom:none;">首页</td>
			  <td style="border-right:1px #C5D8E8 solid; border-bottom:none;">分类列表页</td>
			  <td style="border-right:1px #C5D8E8 solid; border-bottom:none;">内容详情页</td>
			  <td style="border-bottom:none;">其他页</td>
			</tr>
			<tr>
			  <td style="border-right:1px #C5D8E8 solid;border-bottom:none;">
			  <select name="screen_index">
			  <option value="standard" <?php if($mymps_global[screen_index] == 'standard') echo 'selected'; ?>>标准版(1000px)</option>
			  <option value="full" <?php if($mymps_global[screen_index] == 'full') echo 'selected'; ?>>宽版(1200px)</option>
			  </select>
			  </td>
			  <td style="border-right:1px #C5D8E8 solid;border-bottom:none;">
			  <select name="screen_cat">
			  <option value="standard" <?php if($mymps_global[screen_cat] == 'standard') echo 'selected'; ?>>标准版(1000px)</option>
			  <option value="full" <?php if($mymps_global[screen_cat] == 'full') echo 'selected'; ?>>宽版(1200px)</option>
			  </select>
			  </td>
			  <td style="border-right:1px #C5D8E8 solid;border-bottom:none;">
			  <select name="screen_info">
			  <option value="standard" <?php if($mymps_global[screen_info] == 'full') echo 'selected'; ?>>标准版(1000px)</option>
			  <option value="full" <?php if($mymps_global[screen_info] == 'full') echo 'selected'; ?>>宽版(1200px)</option>
			  </select>
			  </td>
			  <td style="border-bottom:none;">
			  <select name="screen_search">
			  <option value="standard" <?php if($mymps_global[screen_search] == 'standard') echo 'selected'; ?>>标准版(1000px)</option>
			  <option value="full" <?php if($mymps_global[screen_search] == 'full') echo 'selected'; ?>>宽版(1200px)</option>
			  </select>
			  </td>
			</tr>
			</table>
		</td>
	</tr>
    <tr bgcolor="white">
        <td width="20%" class="altbg1" ><b>首页版面使用:</b><br /><span class="smalltxt"></span></td>
		<td class="altbg2">
		<?php foreach($template['banmian']['flag'] as $k => $v){
			if($k == 'simple'){
				$obj = 'onclick="simplevalue();$Obj(\'simple_tpl\').style.display=\'\';$Obj(\'classic_tpl\').style.display=\'none\';$Obj(\'portal_tpl\').style.display=\'none\';"';
			} elseif($k == 'portal') {
				$obj = 'onclick="portalvalue();$Obj(\'simple_tpl\').style.display=\'none\';$Obj(\'classic_tpl\').style.display=\'none\';$Obj(\'portal_tpl\').style.display=\'\';"';
			} elseif($k == 'classic') {
				$obj = 'onclick="classicvalue();$Obj(\'simple_tpl\').style.display=\'none\';$Obj(\'classic_tpl\').style.display=\'\';$Obj(\'portal_tpl\').style.display=\'none\';"';
			}
		?>
			<div class="showtpl2">
			<label for="<?=$k?>" title="<?php echo $k == 'simple' ? '适合分类信息为主的站长使用' :($k == 'portal' ? '适合地方门户的站长使用' : '适合其他行业信息的站长使用')?>">
			<!--<div class="img"><img src="../images/tpl_preview/<?=$k?>.gif"></div>-->
			<div id="banmian_<?=$k?>" style="padding:15px;" class="txt <?php if($tpl_index[banmian] == $k){?>checked<?php }?>"><?=$v?> <input  <?php echo $obj;?> id="<?=$k?>" name="tpl_index[banmian]" type="radio" class="radio" value="<?=$k?>" <?php if($tpl_index[banmian] == $k){?>checked="checked"<?php }?>><br /><font color="#666">模板文件路径<br />/template/default/index_<font style="color:#cd0000;"><?=$k?></font>.html</font></div>
			</label>
			</div>
		<?php }?>
		<div class="clear"></div>
		<div id="simple_tpl" style="display:<?php if($tpl_index[banmian] != 'simple'){?>none<?php }?>;">
			<div class="simple_tpl_bg">
				<div class="hd">
					首页分类布局设置(可按住ctrl键多选)
				</div>
				<div class="bd">
					<div class="first">
						<select name="tpl_index[smp_cats][first][]" multiple="multiple">
							<?php foreach($cat as $k => $v){?>
							<option value="<?=$v[catid]?>" <?php if(in_array($v[catid],$tpl_index[smp_cats][first])) echo 'selected';?>><?=$v[catname]?></option>
							<?php }?>
						</select><br /><br />
	
	第一列
					</div>
					<div class="second">
						<select name="tpl_index[smp_cats][second][]" multiple="multiple">
							<?php foreach($cat as $k => $v){?>
							<option value="<?=$v[catid]?>" <?php if(in_array($v[catid],$tpl_index[smp_cats][second])) echo 'selected';?>><?=$v[catname]?></option>
							<?php }?>
						</select><br /><br />
	
	第二列
					</div>
					<div class="third">
						<select name="tpl_index[smp_cats][third][]" multiple="multiple">
							<?php foreach($cat as $k => $v){?>
							<option value="<?=$v[catid]?>"<?php if(in_array($v[catid],$tpl_index[smp_cats][third])) echo 'selected';?>><?=$v[catname]?></option>
							<?php }?>
						</select><br /><br />
	
	第三列
					</div>
					<div class="fourth">
						<select name="tpl_index[smp_cats][fourth][]" multiple="multiple">
							<?php foreach($cat as $k => $v){?>
							<option value="<?=$v[catid]?>"<?php if(in_array($v[catid],$tpl_index[smp_cats][fourth])) echo 'selected';?>><?=$v[catname]?></option>
							<?php }?>
						</select><br /><br />
	
	第四列
					</div>
				</div>
			</div>
			<div class="clear"></div>
			<div class="simple_tpl_bg2">
				<div class="hd">
					子类显示方式
				</div>
				<div class="bd">
					<?php foreach($cat as $k =>$v){?>
						<ul>
						<li class="catname"><?php echo $v[catname]; ?></li> 
						<li class="rad">
						<select name="tpl_index[showstyle][<?=$v[catid]?>]">
							<option value="1" <?php if($tpl_index[showstyle][$v[catid]] == 1) echo 'selected'; ?>>单列</option> 
							<option value="2" <?php if($tpl_index[showstyle][$v[catid]] == 2) echo 'selected'; ?>>双列</option>
							<option value="3" <?php if($tpl_index[showstyle][$v[catid]] == 3) echo 'selected'; ?>>三列</option>
						</select>
						</li>
						</ul>
					<?php }?>
				</div>
			</div>
		</div>
        <div id="classic_tpl" style="display:<?php if($tpl_index[banmian] != 'classic'){?>none<?php }?>;">
            <div class="simple_tpl_bg">
                <div class="bd">
                    <table cellpadding="0" cellspacing="0">
                        <tr>
                            <td>首页展示分类栏目至多数量</td>
                            <td><input name="tpl_index[classic][cats]" type="txt" class="txt" value="<?=$tpl_index[classic][cats]?>"></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
		<div id="portal_tpl" style="display:<?php if($tpl_index[banmian] != 'portal'){?>none<?php }?>;">
			<div class="simple_tpl_bg">
				<div class="hd">板块ID指定（以适应自行修改过分类后，模板模块不对应）</div>
				<div class="bd">
					<table cellpadding="0" cellspacing="0">
						<tr><td>当前 <span>二手转让</span>栏目ID（默认1）</td><td><input name="tpl_index[portal][ershou]" type="txt" class="txt" value="<?=$tpl_index[portal][ershou]?>"></td><td>&nbsp;&nbsp;&nbsp;&nbsp;模型ID（默认2）<input name="tpl_index[portal][ershoumod]" type="txt" class="txt" value="<?=$tpl_index[portal][ershoumod]?>"></td></tr>
						<tr><td>当前 <span>出租房</span>栏目ID（默认41）</td><td><input name="tpl_index[portal][zufang]" type="text" class="txt" value="<?=$tpl_index[portal][zufang]?>"></td><td>&nbsp;&nbsp;&nbsp;&nbsp;模型ID（默认23）<input name="tpl_index[portal][zufangmod]" type="txt" class="txt" value="<?=$tpl_index[portal][zufangmod]?>"></td></tr>
						<tr><td>当前 <span>二手房</span>栏目ID（默认43）</td><td><input name="tpl_index[portal][ershoufang]" type="txt" class="txt" value="<?=$tpl_index[portal][ershoufang]?>"></td><td>&nbsp;&nbsp;&nbsp;&nbsp;模型ID（默认22）<input name="tpl_index[portal][ershoufangmod]" type="txt" class="txt" value="<?=$tpl_index[portal][ershoufangmod]?>"></td></tr>
						<tr><td>当前 <span>招聘</span>栏目ID（默认4）</td><td><input name="tpl_index[portal][zhaopin]" type="text" class="txt" value="<?=$tpl_index[portal][zhaopin]?>"></td><td>&nbsp;&nbsp;&nbsp;&nbsp;模型ID（默认7）<input name="tpl_index[portal][zhaopinmod]" type="txt" class="txt" value="<?=$tpl_index[portal][zhaopinmod]?>"></td></tr>
						<tr><td>当前 <span>求职简历</span>栏目ID（默认6）</td><td><input name="tpl_index[portal][jianli]" type="text" class="txt" value="<?=$tpl_index[portal][jianli]?>"></td><td>&nbsp;&nbsp;&nbsp;&nbsp;模型ID（默认9）<input name="tpl_index[portal][jianlimod]" type="txt" class="txt" value="<?=$tpl_index[portal][jianlimod]?>"></td></tr>
					</table>
				</div>
			</div>
			<div class="clear"></div>
			<div class="simple_tpl_bg" style="margin-top:5px;">
				<div class="hd">各分类选项名（以适应自行修改过选项名后，首页模板选项值不显示 <a href="info_type.php?classid=2" target="_blank">查看选项名</a>）</div>
				<div class="bd">
					<table cellpadding="0" cellspacing="0">
						<tr><td><span>出租房</span>租金选项名（默认mini_rent）</td><td><input style="width:100px;" name="tpl_index[portali][mini_rent]" type="txt" class="text" value="<?=$tpl_index[portali][mini_rent]?>"></td></tr>
						<tr><td><span>二手房</span>面积选项名（默认acreage）</td><td><input style="width:100px;" name="tpl_index[portali][acreage]" type="txt" class="text" value="<?=$tpl_index[portali][acreage]?>"></td></tr>
						<tr><td><span>二手房</span>房价选项名（默认prices）</td><td><input style="width:100px;" name="tpl_index[portali][prices]" type="txt" class="text" value="<?=$tpl_index[portali][prices]?>"></td></tr>
						<tr><td><span>招聘</span>公司名选项名（默认company）</td><td><input style="width:100px;" name="tpl_index[portali][company]" type="txt" class="text" value="<?=$tpl_index[portali][company]?>"></td></tr>
					</table>
				</div>
			</div>
		</div>
		</td>
    </tr>
	<tr class="firstr">
        <td colspan="2">首页调用数详细设置</td>
    </tr>
	<tr bgcolor="white">
        <td width="20%" class="altbg1" ><b>首页置顶信息至多显示数量:</b></td>
		<td class="altbg2">
			<input id="indextopinfo" name="tpl_index[indextopinfo]" value="<?=$tpl_index[indextopinfo]?>" type="text" class="txt">
        </td>
    </tr>
	<tr bgcolor="white">
        <td width="20%" class="altbg1" ><b>最新发布信息至多显示数量:</b></td>
		<td class="altbg2">
			<input id="newinfo" name="tpl_index[newinfo]" value="<?=$tpl_index[newinfo]?>" type="text" class="txt">
        </td>
    </tr>
	<tr bgcolor="white">
        <td width="20%" class="altbg1" ><b>网站公告至多显示数量:</b></td>
		<td class="altbg2">
			<input id="announce" name="tpl_index[announce]" value="<?=$tpl_index[announce]?>" type="text" class="txt">
        </td>
    </tr>
	<tr bgcolor="white">
        <td width="20%" class="altbg1" ><b>帮助中心至多显示数量:</b></td>
		<td class="altbg2">
			<input id="faq" name="tpl_index[faq]" value="<?=$tpl_index[faq]?>" type="text" class="txt">
        </td>
    </tr>
	<tr bgcolor="white">
        <td width="20%" class="altbg1" ><b>网站新闻至多显示数量:</b></td>
		<td class="altbg2">
			<input id="news" name="tpl_index[news]" value="<?=$tpl_index[news]?>" type="text" class="txt">
        </td>
    </tr>
	<tr bgcolor="white">
        <td width="20%" class="altbg1" ><b>各个栏目下的信息显示数量:</b></td>
		<td class="altbg2">
			<input id="foreachinfo" name="tpl_index[foreachinfo]" value="<?=$tpl_index[foreachinfo]?>" type="text" class="txt">
        </td>
    </tr>
	<tr bgcolor="white">
        <td width="20%" class="altbg1" ><b>商品显示数量:</b></td>
		<td class="altbg2">
			<input id="goods" name="tpl_index[goods]" value="<?=$tpl_index[goods]?>" type="text" class="txt">
        </td>
    </tr>
	<tr bgcolor="white">
        <td width="20%" class="altbg1" ><b>便民电话显示数量:</b></td>
		<td class="altbg2">
			<input id="telephone" name="tpl_index[telephone]" value="<?=$tpl_index[telephone]?>" type="text" class="txt">
        </td>
    </tr>
	<tr bgcolor="white">
        <td width="20%" class="altbg1" ><b>生活百宝箱显示数量:</b></td>
		<td class="altbg2">
			<input id="lifebox" name="tpl_index[lifebox]" value="<?=$tpl_index[lifebox]?>" type="text" class="txt">
        </td>
    </tr>
</table>
</div>
<center><input class="mymps large" value="提 交" name="<?=CURSCRIPT?>_submit" type="submit"></center>
</form>
<?php mymps_admin_tpl_global_foot();?>