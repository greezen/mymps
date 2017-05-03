<?php include mymps_tpl('inc_head'); ?>
<script type='text/javascript' src='js/vbm.js'></script>
<div id="<?=MPS_SOFTNAME?>" style="padding-bottom:0">
    <div class="mpstopic-category">
        <div class="panel-tab">
            <ul class="clearfix tab-list">
    <li><a href="?typename=网站首页" <?php if($typename=='网站首页') echo 'class="current"';?>>网站首页</a></li>
    <?php if(!$admin_cityid){?><li><a href="?typename=新闻首页" <?php if($typename=='新闻首页') echo 'class="current"';?>>新闻首页</a></li><?php }?>
            </ul>
			<?php if(!$admin_cityid){?>
            <ul style="float:right; text-align:right">
               <select name="cityid" onChange="location.href='?typename=<?=$typename?>&cityid='+(this.options[this.selectedIndex].value)">
       	<option value="0">总站</option>
        <?php echo get_cityoptions($cityid); ?>
       </select>
            </ul>
            <?php }?>
        </div>
    </div>
</div>
<form method='post' action='?part=<?=$part?>'>
<input name="typename" value="<?=$typename?>" type="hidden" />
<div id="<?=MPS_SOFTNAME?>">
<table border="0" cellspacing="0" cellpadding="0" class="vbm">
    <tr class="firstr">
    <td width="60"><input name="checkall" type="checkbox" class="checkbox" id="checkall" onClick="CheckAll(this.form)"/> 删?</td>
    <td align="center">焦点图路径</td>
    <td width="200" align="center">说明文字</td>
    <td width="100" align="center">添加时间</td>
    <td width="100" align="center">顺序</td>
    <td width="100" align="center">编辑</td>
  </tr>
<?php foreach($row AS $row){?>
    <tr align="center" bgcolor="white">
    <td><input type='checkbox' name='delids[]' value='<?=$row[id]?>' class="checkbox" id="<?=$row[id]?>"></td>
    <td><a href='javascript:blocknone("pm_<?=$row[id]?>");'><?=$row[pre_image]?></a></td>
    <td><?=$row[words]?></td>
    <td><em><?=GetTime($row[pubdate])?></em></td>
    <td><input name="displayorder[<?=$row[id]?>]" value="<?=$row[focusorder]?>" class="txt"/></td>
    <td>
	  <a href='?part=edit&id=<?=$row[id]?>'>详情</a>
    </td>
  </tr>
  <tr style="background-color:white; display:none" id="pm_<?=$row[id]?>">
    <td>&nbsp;</td>
    <td colspan="5"><img src="<?=$row[pre_image]?>"/></td>
    </tr>
    <? }?>
</table>
</div>
<center style='margin:10px'><input type="submit" value="提 交"  class="mymps large" name="focus_submit"/> </center>
</form>
<div class="pagination"><?php echo page2(); ?></div>
<?php mymps_admin_tpl_global_foot();?>