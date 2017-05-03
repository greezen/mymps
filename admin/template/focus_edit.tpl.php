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
     if(document.form1.vbm_img.value==""){
	     alert("请上传图片！");
	     document.form1.vbm_img.focus();
	     return false;
     }
     return true;
 }
</script>
<script language="javascript" src="js/vbm.js"></script>
<form method="POST" name="form1" action="focus.php?part=<?=$part?>" enctype="multipart/form-data"  onSubmit="return CheckSubmit();">
<input name="image" value="<?=$row[image]?>" type="hidden">
<input name="pre_image" value="<?=$row[pre_image]?>" type="hidden">
<input name=id type=hidden value="<?=$row[id]?>"/>
<input name="typename" value="<?=$row[typename]?>" type="hidden" />
<div id="<?=MPS_SOFTNAME?>">
<table width="100%"  border="0" cellspacing="0" cellpadding="0" class="vbm">
            <tbody>
			<?php if(!$admin_cityid){?>
			 <tr bgcolor="#f5fbff" >
                <td width="15%" align="right" valign="top">隶属分站：</td>
                <td>
                <select name="cityid">
                	<option value="0">总站</option>
					<?php echo get_cityoptions($row[cityid]); ?>
                </select>
                </td>
                </tr>
			 <?php } else {?>
			 <input name="cityid" type="hidden" value="<?php echo $admin_cityid; ?>">
			 <?php }?>
              <tr bgcolor="#f5fbff" >
                <td width="15%" align="right">图片源地址：</td>
                <td>
                <input name=image type=text class="text" style='background-color:#CCCCCC' value="<?=$row[image]?>" readonly="readonly"/> 不可更改
                </td>
              </tr>
              <tr bgcolor="#f5fbff" >
                <td width="15%" align="right">原图片：</td>
                <td>
                <img src="<?=$row[pre_image]?>"/>
                </td>
              </tr>
            <tr bgcolor="#f5fbff">
                <td align="right" valign="top">选择上传的图片：</td>
                <td><input type="file" name="mymps_focus" size="45" id="litpic" onchange="SeePic(document.picview,document.form1.litpic);"><br /><br />
                  支持上传的类型：<?=$mymps_global[cfg_upimg_type]?><br />
网站首页焦点图尺寸：<?=$mymps_mymps[cfg_focus_limit][$tpl_index[banmian]][index][width]?> * <?=$mymps_mymps[cfg_focus_limit][$tpl_index[banmian]][index][height]?><br />
新闻首页焦点图尺寸：<?=$mymps_mymps[cfg_focus_limit][news][width]?> * <?=$mymps_mymps[cfg_focus_limit][news][height]?><br />
</td>
              </tr>
              <tr bgcolor="#f5fbff" >
                <td width="15%">图片顺序：</td>
                <td>
                <input name=focusorder type=text class="text" value="<?=$row[focusorder]?>"/>
                </td>
              </tr>
              <tr bgcolor="#f5fbff" >
                <td width="15%">图片说明：</td>
                <td>
                <input name=words type=text class="text" value="<?=$row[words]?>"/>
                </td>
              </tr>
              <tr bgcolor="#f5fbff" >
                <td width="15%">跳转网址：</td>
                <td>
                <input name=url type=text size=35 style='width:250px' value="<?=$row[url]?>"/>
                </td>
              </tr>
            </tbody>
            <tfoot>
              <tr bgcolor="#f5fbff" >
                <td height="45">&nbsp;</td>
                <td height="45">
                <input value="更 新" type="submit" class="mymps mini" name="<?=CURSCRIPT?>_submit">　
                <input type="reset" onClick=history.back() value="返 回" class="mymps mini">
                </td>
              </tr>
            </tfoot>
          </table>
</div>           
</form>
<?php mymps_admin_tpl_global_foot();?>