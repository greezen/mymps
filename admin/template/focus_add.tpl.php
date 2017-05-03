<?php include mymps_tpl('inc_head');?>
<script language='javascript'>
	function CheckSubmit()
  {
     if(document.form1.focusorder.value==""){
	     alert("焦点图顺序不能为空！");
	     document.form1.focusorder.focus();
	     return false;
     }
     if(document.form1.words.value==""){
	     alert("图片说明不能为空！");
	     document.form1.words.focus();
	     return false;
     }
     if(document.form1.url.value==""){
	     alert("跳转网址不能为空！");
	     document.form1.url.focus();
	     return false;
     }
     if(document.form1.mymps_focus.value==""){
	     alert("请上传图片！");
	     document.form1.mymps_focus.focus();
	     return false;
     }
     return true;
 }
</script>
<script language="javascript" src="js/vbm.js"></script>
<form method="POST" name="form1" action="?part=add" enctype="multipart/form-data" onSubmit="return CheckSubmit();">
<div id="<?=MPS_SOFTNAME?>">
<table width="100%"  border="0" cellspacing="0" cellpadding="0" class="vbm">
            <tbody>
			<?php if(!$admin_cityid){?>
			<tr bgcolor="#f5fbff">
				<td align="right">隶属分站：</td>
				<td>
				<select name="cityid">
				<option value="0">总站</option>
				<?php echo get_cityoptions($cityid); ?>
			   </select>
				</td>
			</tr>
			<?}else{?>
			<input name="cityid" type="hidden" value="<?php echo $admin_cityid; ?>">
			<?php }?>
              <tr bgcolor="#f5fbff" >
                <td width="15%" align="right" valign="top">选择位置：</td>
                <td>
                <select name="typename">
                	<option value="网站首页">网站首页</option>
                    <?php if(!$admin_cityid){?><option value="新闻首页">新闻首页</option><?php }?>
                </select>
                </td>
              </tr>
              <tr bgcolor="#f5fbff" >
                <td width="15%" align="right" valign="top">图片顺序：</td>
                <td>
                <input name=focusorder type=text class="text" value="<?=$maxorder?>"/>
                </td>
              </tr>
              <tr bgcolor="#f5fbff" >
                <td width="15%" align="right" valign="top">图片说明：</td>
                <td>
                <input name=words type=text class="text" />
                </td>
              </tr>
              <tr bgcolor="#f5fbff" >
                <td width="15%" align="right" valign="top">跳转网址：</td>
                <td>
                <input name=url type=text class="text" value="http://"/>
                </td>
              </tr>
              <tr bgcolor="#f5fbff" >
                <td align="right" valign="top">选择上传的图片：</td>
                <td><input type="file" name="mymps_focus" size="45" id="litpic"><br /><br />
                  支持上传的类型：<?=$mymps_global[cfg_upimg_type]?><br />
网站首页焦点图尺寸：<?=$mymps_mymps[cfg_focus_limit][$tpl_index[banmian]][index][width]?> * <?=$mymps_mymps[cfg_focus_limit][$tpl_index[banmian]][index][height]?><br />
新闻首页焦点图尺寸：<?=$mymps_mymps[cfg_focus_limit][news][width]?> * <?=$mymps_mymps[cfg_focus_limit][news][height]?><br />
</td>
              </tr>
            </tbody>
          </table>
</div> 
<center><input class="mymps large" type="submit" value="上 传" name="focus_submit"></center>
</form>
<?php mymps_admin_tpl_global_foot();?>