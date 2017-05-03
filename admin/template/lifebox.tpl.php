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
    <?php }?>
    &nbsp;
    </td>
  </tr>
  <tr bgcolor="#ffffff">
    <td id="menu_tip" colspan="2">
 <li>生活百宝箱显示在首页的第一屏右侧，显示最新的24个文字链接，每个连接文字建议5个汉字以内</li>
 <li>链接类型选为直接跳转，当打开页面时将至将跳转到该链接地址</li>
 <li>填写站外链接，请确认链接地址包含http://</li>
    </td>
  </tr>
</table>
</div>
<form action="?part=service" method="post">
<input name="forward_url" value="<?=GetUrl()?>" type="hidden"/>
<div id="<?=MPS_SOFTNAME?>">
<table border="0" cellspacing="0" cellpadding="0" class="vbm">
    <tr style="font-weight:bold; background-color:#dff6ff">
      <td><input class="checkbox" name="checkall" type="checkbox" id="checkall" onClick="CheckAll(this.form)"/> 删?</td>
	  <?php if(!$admin_cityid){?><td>隶属分站</td><?php }?>
      <td>链接文字(<font color="red">*</font>)</td>
      <td>类型</td>
      <td>链接URL地址(<font color="red">*</font>)</td>
      <td>显示顺序</td>
      <td>启用状态</td>
    </tr>
    <?php foreach($lifebox as $k =>$value){?>
        <tr bgcolor="#ffffff">
          <td><input class="checkbox" type='checkbox' name='delids[]' value='<?=$value[id]?>' id="<?=$value[id]?>"></td>

		<?php if(!$admin_cityid){?>
		<td>
			<select name="edit[<?=$value[id]?>][cityid]">
				<option value="0">总站</option>
				<?php echo get_cityoptions($value['cityid']); ?>
			</select>
        <?}else{?>
			<input name="edit[<?=$value[id]?>][cityid]" type="hidden" value="<?php echo $admin_cityid; ?>">
		</td>
		<?php }?> 
		
          <td bgcolor="white"><input class="text" name="edit[<?=$value[id]?>][lifename]" value="<?=$value[lifename]?>" />       
		  </td>
          
        <td><select name="edit[<?=$value[id]?>][typeid]">
      <?php echo get_servtype_options($value[typeid]);?>
      </select></td>
          <td bgcolor="white"><input class="text" value="<?=$value[lifeurl]?>" name="edit[<?=$value[id]?>][lifeurl]"/></td>
          <td ><input name="edit[<?=$value[id]?>][displayorder]" value="<?=$value[displayorder]?>" type="text" class="txt"/></td>
          <td bgcolor="white"><select name="edit[<?=$value[id]?>][if_view]"><?=get_ifview_options($value[if_view])?></select></td>
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
      <td bgcolor="white"><input name="newlifename[]" value="" type="text" class="text"/></td>
      <td><select name="newtypeid[]"><?php echo get_servtype_options($typeid);?></select></td>
      <td bgcolor="white"><input name="newlifeurl[]" value="" type="text" class="text"/></td>
      <td><input name="newdisplayorder[]" value="0" type="text" class="txt"/></td>
      <td bgcolor="white"><select name="newif_view[]">
      <?=get_ifview_options(2)?>
      </select></td>
   </tr>
   </tbody>
   
   <tbody id="secqaabodyhidden" style="display:none">
       <tr align="center" bgcolor="white">
      <td align="center">&nbsp;</td>
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
      <td bgcolor="white"><input name="newlifename[]" value="" type="text" class="text"/> </td>
      <td><select name="newtypeid[]"><?php echo get_servtype_options($typeid);?></select></td>
      <td bgcolor="white"><input name="newlifeurl[]" value="" type="text" class="text"/></td>
      <td><input name="newdisplayorder[]" value="0" type="text" class="txt"/></td>
      <td bgcolor="white"><select name="newif_view[]">
      <?=get_ifview_options(2)?>
      </select></td>
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