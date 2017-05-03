<?php include mymps_tpl('inc_head');?>
<script type="text/javascript" src="js/titlealt.js"></script>
<div id="<?=MPS_SOFTNAME?>">
<table border="0" cellspacing="0" cellpadding="0" class="vbm">
<tr class="firstr">
	<td colspan="2">检索分类信息</td>
	<?php if(!$admin_cityid){?><td>按分站筛选</td><?php }?>
</tr>
<tr>
	<td colspan="2" bgcolor="white">
    <form action="?" method="get">
    	<input name="cityid" value="<?=$cityid?>" type="hidden">
    	<input name="keywords" value="<?=$keywords?>" type="text" class="text" style="width:180px">
        <select name="show">
		<option value="idno" <?php if($show == 'idno') echo 'selected'; ?>>信息ID编号</option>
		<option value="catidno" <?php if($show == 'catidno') echo 'selected'; ?>>分类catID编号</option>
		<option value="title" <?php if($show == 'title') echo 'selected'; ?>>信息标题</option>
		<option value="userid" <?php if($show == 'userid') echo 'selected'; ?>>用户名</option>
		<option value="tel" <?php if($show == 'tel') echo 'selected'; ?>>联系电话</option>
        </select> 
        <input name="submit" type="submit" value="搜索" class="gray mini"/>
    </form>
	</td>
	<?php if(!$admin_cityid){?>
	<td>
	<select name="cityid" onChange="location.href='?page=<?=$page?>&info_level=<?=$info_level?>&keywords=<?=$keywords?>&show=<?=$show?>&upgrade=<?=$upgrade?>&ifred=<?=$ifred?>&ifbold=<?=$ifbold?>&cityid='+(this.options[this.selectedIndex].value)">
	<option value="0">全部</option>
	<?php echo get_cityoptions($cityid); ?>
	</select>
	</td>
	<?}?>
</tr>
</table>
</div>
<div class="clear"></div>
<div id="<?=MPS_SOFTNAME?>" style="padding-bottom:0">
    <div class="mpstopic-category">
        <div class="panel-tab">
            <ul class="clearfix tab-list">
            	<li><a href="information.php" <?php if($info_level=='' && $upgrade != 'index' && $upgrade != 'list' && $upgrade != 'category' && $ifred != '1' && $ifbold != '1'){?>class="current"<?php }?>>全部</a></li>
            	<li><a title="待审信息" href="information.php?info_level=0" <?php if($info_level==='0'){?>class="current"<?php }?>>待审</a></li>
                <li><a title="正常信息" href="information.php?info_level=1" <?php if($info_level==1){?>class="current"<?php }?>>正常</a></li>
                <li><a title="推荐信息" href="information.php?info_level=2" <?php if($info_level==2){?>class="current"<?php }?>>推荐</a></li>
                <li><a title="首页置顶信息" href="information.php?upgrade=index" <?php if($upgrade=='index'){?>class="current"<?php }?>>首顶</a></li>
                <li><a title="大类置顶信息" href="information.php?upgrade=category" <?php if($upgrade=='category'){?>class="current"<?php }?>>大顶</a></li>
				<li><a title="小类置顶信息" href="information.php?upgrade=list" <?php if($upgrade=='list'){?>class="current"<?php }?>>小顶</a></li>
                <li><a title="标题套红信息" href="information.php?ifred=1" <?php if($ifred==1){?>class="current"<?php }?>>套红</a></li>
                <li><a title="标题加粗信息" href="information.php?ifbold=1" <?php if($ifbold==1){?>class="current"<?php }?>>加粗</a></li>
            </ul>
        </div>
    </div>
</div>
<form action="?action=pm" method="post">
<input name="url" type="hidden" value="<?=GetUrl()?>">
<div id="<?=MPS_SOFTNAME?>">
<table border="0" cellspacing="0" cellpadding="0" class="vbm" >
    <tr class="firstr">
    <td width="30">选择</td>
    <td width="40">缩略图</td>
	<td width="30">状态</td>
    <td>信息标题</td>
    <td width="50">大顶</td>
	<td width="50">小顶</td>
    <td width="50">首顶</td>
	<td width="50">发布人</td>
	<td width="60">所在地</td>
	<td width="50">时间</td>
    <td width="30">管理</td>
  </tr>
<tbody onmouseover="addMouseEvent(this);">
<?php foreach($information AS $row){?>

     <tr bgcolor="white" >
    <td><input type='checkbox' name='id[]' value='<?=$row[id]?>' class='checkbox' id="<?=$row[id]?>"></td>
     <td><?php $row['img_path'] = $row['img_path'] ? $row['img_path'] : '/images/nophoto.gif';?><img src="<?=$row[img_path]?>" width="48" height="36" style="border:1px #dddddd solid; padding:1px"></td>
	<td><?=$row[info_level]?></td>
    <td><?php if($row['img_path']){?><font color="green">[<?=$row['img_count']?>图]</font> <?php }?><a style="<?php if($row['ifred'] == 1) echo 'color:red;';?><?php if($row['ifbold'] == 1) echo 'font-weight:bold;';?>" href="<?=$row[uri]?>" target="_blank" title="<?=$row[id]?> - <?=$row[title]?>"><?php echo $row[title]; ?></a><a title="catID编号:<?=$row[catid]?>" target="_blank" href="<?=$row[uri_cat]?>" style="color:#333; margin-left:10px"><?=$row[catname]?></a><?php if($row[certify] == 1){?> <img title="认证信息" alt="认证信息" align="absmiddle" src="../images/company1.gif"><?}?></td>
 
    <td><div class="signin_button"  onmouseover="wsug(event, '<?php echo $row['upgrade_time']; ?>')" onmouseout="wsug(event, 0)"><?=$row[upgrade_type]?></div></td>
    <td><div class="signin_button"  onmouseover="wsug(event, '<?php echo $row['upgrade_time_list']; ?>')" onmouseout="wsug(event, 0)"><?=$row[upgrade_type_list]?></div></td>
    <td><div class="signin_button"  onmouseover="wsug(event, '<?php echo $row['upgrade_time_index']; ?>')" onmouseout="wsug(event, 0)"><?=$row[upgrade_type_index]?></div></td>
	<td><?=$row[contact_who]?>
    </td>
	<td><div class="signin_button"  onmouseover="wsug(event, '<?php echo $row['ip2area'] == 'wap' ? '手机端' : $row['ip2area']; ?>')" onmouseout="wsug(event, 0)"><i style="color:#585858"><?php echo $row['ip2area'] == 'wap' ? '手机端' : $row['ip']; ?></i></div>
    </td>
	<td><div class="signin_button"  onmouseover="wsug(event, '发布时间：<?php echo GetTime($row['begintime']);?>')" onmouseout="wsug(event, 0)"><font style="color:#585858"><?php echo date("m-d",$row['begintime']);?></font></div></td>
	<td>
     <a href='?action=edit&id=<?=$row[id]?>'>编辑</a>
    </td>
  </tr>
<?}?>
</tbody>
<tr bgcolor="#ffffff" height="28">
    <td style="border-right:1px #fff solid;"><input name="checkall" type="checkbox" id="checkall" onClick="CheckAll(this.form)" class="checkbox"/></td>
    <td colspan="10">
    <label for="delall"><input type="radio" value="delall" id="delall" name="do_action" class="radio">删除</label> 
    <label for="refresh"><input type="radio" value="refresh" id="refresh" name="do_action" class="radio">刷新</label>
    <?php foreach($information_level as $k => $v){?>
    <label for="level<?=$k?>"><input type="radio" value="level.<?=$k?>" id="level<?=$k?>" name="do_action" class="radio">转为<?=$v?></label> 
    <?php }?>
    <hr style="height:1px; border:1px #c5d8e8 solid;"/>
	<label for="certify_yes"><input type="radio" value="certify_yes" id="certify_yes" name="do_action" class="radio">通过认证</label> 
	<label for="certify_no"><input type="radio" value="certify_no" id="certify_no" name="do_action" class="radio">取消认证</label> 
    <hr style="height:1px; border:1px #c5d8e8 solid;"/>
    <label for="upgrade"><input type="radio" value="upgrade" id="upgrade" name="do_action" class="radio">取消/大类置顶</label> 
	<label for="upgrade_list"><input type="radio" value="upgrade_list" id="upgrade_list" name="do_action" class="radio">取消/小类置顶</label> 
    <label for="upgrade_index"><input type="radio" value="upgrade_index" id="upgrade_index" name="do_action" class="radio">取消/首页置顶</label> 
    <hr style="height:1px; border:1px #c5d8e8 solid;"/>
    <label for="ifred"><input type="radio" value="ifred" id="ifred" name="do_action" class="radio">取消/标题套红</label> 
    <label for="ifbold"><input type="radio" value="ifbold" id="ifbold" name="do_action" class="radio">取消/标题加粗</label> 
    </td>
</tr>
</table>
</div>
<center><input type="submit" value="提 交" class="mymps large"/></center>
</form>
<div class="pagination"><?php echo page2();?></div>
<?php mymps_admin_tpl_global_foot();?>