<?php include mymps_tpl('inc_head');?>
<div id="<?=MPS_SOFTNAME?>">
<table border="0" cellspacing="0" cellpadding="0" class="vbm">
  <tr class="firstr">
  	<td>相关说明</td>
    <td style="text-align:right">
    <?php if(!$admin_cityid){?>
    选择分站：<select name="cityid" onChange="location.href='?page=<?=$page?>&cityid='+(this.options[this.selectedIndex].value)">
       	<option value="0">总站</option>
        <?php echo get_cityoptions($cityid); ?>
       </select>
    <? }?>
    &nbsp;
    </td>
  </tr>
  <tr bgcolor="#ffffff">
    <td id="menu_tip" colspan="2">
 <li>生活百宝箱显示在首页底部，生活助手上方</li>
    </td>
  </tr>
</table>
</div>
<form action="?" method="post">
<input name="forward_url" value="<?=GetUrl()?>" type="hidden"/>
<div id="<?=MPS_SOFTNAME?>">
<table border="0" cellspacing="0" cellpadding="0" class="vbm">
    <tr style="font-weight:bold; background-color:#dff6ff">
      <td><input class="checkbox" name="checkall" type="checkbox" id="checkall" onClick="CheckAll(this.form)"/> 删?</td>
	  <?php if(!$admin_cityid){?><td>隶属分站</td><?php }?>
      <td>电话所属商家或行业(<font color="red">*</font>)</td>
      <td>电话号码(<font color="red">*</font>)</td>
      <td>颜色</td>
      <td>是否加粗</td>
      <td>显示顺序</td>
      <td>启用状态</td>
    </tr>
    <?php foreach($telephone as $k =>$value){?>
        <tr bgcolor="#ffffff">
          <td><input class="checkbox" type='checkbox' name='delids[]' value='<?=$value[id]?>' id="<?=$value[id]?>"></td>
		  <?php if(!$admin_cityid){?>
		  <td bgcolor="white">
			<select name="edit[<?=$value[id]?>][cityid]">
			<option value="0">总站</option>
			<?php echo get_cityoptions($value['cityid']); ?>
		   </select>
			<?}else{?>
			<input name="edit[<?=$value[id]?>][cityid]" type="hidden" value="<?php echo $admin_cityid; ?>">
		  </td>
		  <?php }?>
          <td bgcolor="white"><input class="text" name="edit[<?=$value[id]?>][telname]" value="<?=$value[telname]?>" />
          </td>
          <td><input class="text" value="<?=$value[telnumber]?>" name="edit[<?=$value[id]?>][telnumber]"/></td>
          <td bgcolor="white"><select name="edit[<?=$value[id]?>][color]">
                <option value="">默认颜色</option>
                <?php echo get_color_options($value['color']); ?>
      		  </select>
          </td>
          <td><select name="edit[<?=$value[id]?>][if_bold]">
              <option value="0" <?php if($value['if_bold'] != 1){echo 'selected="selected"; style="background-color:#6EB00C;color:white"';}?>>不加粗</option>
              <option value="1" <?php if($value['if_bold'] == 1){echo 'selected="selected"; style="background-color:#6EB00C;color:white"';}?>>加粗</option>
      		  </select>
          </td>
          <td bgcolor="white"><input name="edit[<?=$value[id]?>][displayorder]" value="<?=$value[displayorder]?>" type="text" class="txt"/></td>
          <td><select name="edit[<?=$value[id]?>][if_view]"><?=get_ifview_options($value[if_view])?></select></td>
        </tr>
    <?}?>
  <tbody id="secqaabody" bgcolor="white">
   <tr align="center">
   	 	<td>新增:<a href="###" onclick="newnode = $('secqaabodyhidden').firstChild.cloneNode(true); $('secqaabody').appendChild(newnode)">[+]</a></td>
		<?php if(!$admin_cityid){?>
		<td bgcolor="white">
        <select name="newcityid[]">
       	<option value="0">总站</option>
        <?php echo get_cityoptions($cityid); ?>
       </select>
        <?}else{?>
		<input name="newcityid[]" type="hidden" value="<?php echo $admin_cityid; ?>">
		</td>
		<?php }?>
        <td bgcolor="white"><input name="newtelname[]" value="" type="text" class="text"/>
       </td>
        <td><input name="newtelnumber[]" value="" type="text" class="text"/></td>
        <td bgcolor="white"><select name="newcolor[]" style="float:left">
              <option value="">默认颜色</option>
               <?php echo get_color_options(); ?>
              </select></td>
        <td><select name="newif_bold[]">
              <option value="0">不加粗</option>
              <option value="1">加粗</option>
              </select></td>
        <td bgcolor="white"><input name="newdisplayorder[]" value="0" type="text" class="txt"/></td>
        <td><select name="newif_view[]">
        <?=get_ifview_options(2)?>
        </select>
        </td>
   </tr>
   </tbody>
   
   <tbody id="secqaabodyhidden" style="display:none">
       <tr align="center" bgcolor="white">
       		<td>&nbsp;</td>
			<?php if(!$admin_cityid){?>
			<td bgcolor="white">
				<select name="newcityid[]">
				<option value="0">总站</option>
				<?php echo get_cityoptions($cityid); ?>
			   </select>
				<?}else{?>
				<input name="newcityid[]" type="hidden" value="<?php echo $admin_cityid; ?>">
			</td>
			<?php }?>
            <td bgcolor="white"><input name="newtelname[]" value="" type="text" class="text"/>
            </td>
            <td><input name="newtelnumber[]" value="" type="text" class="text"/></td>
            <td bgcolor="white"><select name="newcolor[]" style="float:left">
                  <option value="">默认颜色</option>
                   <?php echo get_color_options(); ?>
                  </select></td>
            <td><select name="newif_bold[]">
                  <option value="0">不加粗</option>
                  <option value="1">加粗</option>
                  </select></td>
            <td bgcolor="white"><input name="newdisplayorder[]" value="0" type="text" class="txt"/></td>
            <td><select name="newif_view[]">
            <?=get_ifview_options(2)?>
            </select>
            </td>
       </tr>
   </tbody>
</table>
</div>
<center>
<input class="mymps large" value="提 交" name="<?=CURSCRIPT?>_submit" type="submit"> &nbsp;
</center>
</form>
<div class="pagination"><?php echo page2()?></div>  
<?php mymps_admin_tpl_global_foot();?>