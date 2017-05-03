<?php include mymps_tpl('inc_head');?>
<div id="<?=MPS_SOFTNAME?>" style=" padding-bottom:0">
    <div class="mpstopic-category">
        <div class="panel-tab">
            <ul class="clearfix tab-list">
                <li><a href="friendlink.php?part=list">已增加友情链接</a></li>
                <li><a href="friendlink.php?part=add">增加友情链接</a></li>
                <?php if(!$admin_cityid){?><li><a href="friendlink.php?do=type" <?php if($do=='type'){?>class="current"<?php }?>>网站类型管理</a></li><?php }?>
				<li><a href="friendlink.php?part=edit&id=<?=$id?>" class="current">编辑链接</a></li>
            </ul>
        </div>
    </div>
</div>
<form action="friendlink.php?part=update&id=<?=$link[id]?>" method="post" enctype="multipart/form-data" name="form1" onSubmit="return CheckSubmit();";>
    <input type="hidden" name="createtime" value="<?=date("Y-m-d H:i:s", time()) 
?>">
<div id="<?=MPS_SOFTNAME?>">
<table width="100%" cellspacing="0" cellpadding="0" class="vbm">
      <tr class="firstr">
        <td colspan="5">
        <div class="left"><a href="javascript:collapse_change('1')">网站概况</a></div>
        <div class="right"><a href="javascript:collapse_change('1')"><img id="menuimg_1" src="template/images/menu_reduce.gif"/></a></div>
        </td>
      </tr>
      <tbody id="menu_1">
	  <?php if(!$admin_cityid){?>
        <tr bgcolor="#f5fbff">
            <td>隶属分站：</td>
            <td>
            <select name="cityid">
            <option value="0">总站</option>
            <?php echo get_cityoptions($link[cityid]); ?>
           </select>
            </td>
        </tr>
        <?}else{?>
        <input name="cityid" type="hidden" value="<?php echo $admin_cityid; ?>">
        <?php }?> 
	  <tr bgcolor="#f5fbff">
        <td width="19%" height="25">网址：</td>
        <td>
        	<input name="url" type=text class=text id="url" value="<?=$link[url]?>" size="30" />        </td>
      </tr>
      <tr bgcolor="#f5fbff">
        <td height="25">网站名称：</td>
        <td>
        	<input name="webname" type=text class=text id="webname" size="30" value="<?=$link[webname]?>"/>        </td>
      </tr>
      <tr bgcolor="#f5fbff">
        <td height="25">网站LOGO：</td>
        <td>
        <input name="weblogo" type=text class=text id="weblogo" size="30" value="<?=$link[weblogo]?>"/> <br />尺寸80*35<br />
若显示文字链接则不需添加logo地址<br />
logo不显示在分类页面
    </td>
      </tr>
      <tr bgcolor="#f5fbff">
        <td width="19%" height="25">PR值</td>
        <td>
		<?=apply_flink_pr($link[pr]);?>	
        </td>
      </tr>
      <tr bgcolor="#f5fbff">
        <td width="19%" height="25">日IP</td>
        <td>
        <?=apply_flink_dayip($link[dayip]);?>	    
		</td>
      </tr>
      <tr bgcolor="#f5fbff">
        <td height="25">网站简况：</td>
        <td><textarea name="msg" cols="50" rows="5" id="msg"><?=de_textarea_post_change($link[msg])?></textarea></td>
      </tr>
      </tbody>
      </table>
</div>
<div id="<?=MPS_SOFTNAME?>">
<table width="100%" cellspacing="0" cellpadding="0" class="vbm">
     <tr class="firstr">
        <td colspan="3">
         <div class="left"><a href="javascript:collapse_change('3')">其他属性</a></div>
         <div class="right"><a href="javascript:collapse_change('3')"><img id="menuimg_3" src="template/images/menu_reduce.gif"/></a></div>
        </td>
      </tr>
      <tbody id="menu_3">
      <tr bgcolor="#f5fbff">
        <td height="25">网站类型：</td>
        <td>
        <select name="typeid" id="typeid">
		<?php echo webtype_option($link[typeid]) ; ?>
        </select>
        </td>
      </tr>
      <tr bgcolor="#f5fbff">
        <td height="25">链接状态：</td>
        <td>
        <label><input class="radio" type='radio' name='ischeck' value="1" <?php if ($link[ischeck]=="1") echo"checked='checked'";?>> 待审</label>
        <label><input type='radio' class="radio" name='ischeck' value="2" <? if ($link[ischeck]=="2") echo"checked='checked'";?>> 正常</label>
                </td>
      </tr>
      <tr bgcolor="#f5fbff">
        <td width="19%" height="25">排列序号：</td>
        <td>
<input name="ordernumber" type=text class=txt id="order" value="<?=$link[ordernumber]?>"/>        
(由小到大排列)        
		</td>
      </tr>
</tbody>
    </table>
</div>
<div id="<?=MPS_SOFTNAME?>">
<table width="100%" cellspacing="0" cellpadding="0" class="vbm">
<tr class="firstr"><td colspan="2">显示位置</td></tr>
  <tr bgcolor="#f5fbff">
    <td width="19%" height="25">显示在网站首页？</td>
    <td>
    <select name="ifindex" id="ifindex">
    <option value="2" <?php if($link[ifindex] == 2) echo 'selected';?>>是</option>
	<option value="1" <?php if($link[ifindex] == 1) echo 'selected';?>>否</option>
    </select>
    </td>
  </tr>
<tr bgcolor="#f5fbff">
    <td height="25">显示在该分类下：</td>
    <td>
	<select name="catid">
	<option value="0" <?php if($link[catid] == 0) echo 'selected';?>>不在分类显示</option>
	<?=cat_list('category',0,$link['catid'],true,1)?>
  </select>
    </td>
  </tr>
      </tbody>
    </table>
</div>
<center><input type="submit" name="submit" value="提 交" class="mymps large" /></center>
</form>
<?php mymps_admin_tpl_global_foot();?>