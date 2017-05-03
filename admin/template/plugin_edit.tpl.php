<?php include mymps_tpl('inc_head');?>
<form action="plugin.php" method="post" name="form1">
<input name="op" value="edit" type="hidden">
<input name="id" value="<?=$id?>" type="hidden">
<div id="<?=MPS_SOFTNAME?>">
<table width="100%" cellspacing="0" cellpadding="0" class="vbm">
      <tr class="firstr">
        <td colspan="5">
       		插件详情 - <?php echo $edit['name']; ?>
        </td>
      </tr>
      <tbody id="menu_1">
	  <tr bgcolor="#f5fbff">
        <td width="19%" height="25">插件名称</td>
        <td><?php echo $edit['name']; ?></td>
      </tr>
      <tr bgcolor="#f5fbff">
        <td height="25">插件标识</td>
        <td><?php echo $edit['flag']; ?></td>
      </tr>
      <tr bgcolor="#f5fbff">
        <td height="25">插件目录</td>
        <td>/plugin/<?php echo $edit['directory']; ?></td>
      </tr>
      <tr bgcolor="#f5fbff">
        <td width="19%" height="25">版本</td>
        <td><?php echo $edit['version']; ?></td>
      </tr>
      <tr bgcolor="#f5fbff">
        <td width="19%" height="25">作者</td>
        <td><?php echo $edit['author']; ?>    
		</td>
      </tr>
      <tr bgcolor="#f5fbff">
        <td height="25">发布时间</td>
        <td><?php echo GetTime($edit['releasetime']); ?> </td>
      </tr>
      <tr class="firstr">
        <td colspan="5">
            前台设置
        </td>
      </tr>
      <tr bgcolor="#f5fbff">
        <td height="25"><strong>显示标题</strong><br />分站名用 <font color="red">{city}</font> 代替</td>
        <td><input name="config[seotitle]" value="<?php echo $edit[config][seotitle]?>" class="text" type="text"></td>
      </tr>
      <tr bgcolor="#f5fbff">
        <td height="25"><strong>meta keywords（关键词）</strong><br />分站名用 <font color="red">{city}</font> 代替</td>
        <td><input name="config[seokeywords]" value="<?php echo $edit[config][seokeywords]?>" class="text" type="text"></td>
      </tr>
      <tr bgcolor="#f5fbff">
        <td height="25"><strong>meta description（描述）</strong><br />分站名用 <font color="red">{city}</font> 代替</td>
        <td><textarea name="config[seodescription]" style="width:300px; height:100px"><?php echo $edit[config][seodescription]?></textarea></td>
      </tr>
      <tr class="firstr">
        <td colspan="5">
            菜单设置
        </td>
      </tr>
      <tr bgcolor="#f5fbff">
        <td height="25">管理中心菜单<br /><i style="color:#666">非必要，请勿修改（<font color="red">重要</font>）</i></td>
        <td><textarea name="config[adminmenu]" style="width:300px; height:100px"><?php echo $edit[config][adminmenu]?></textarea></td>
      </tr>
	  <?php if($edit['flag'] == 'goods'){?>
	  <tr class="firstr">
        <td colspan="5">
            公用信息
        </td>
      </tr>
      <tr bgcolor="#f5fbff">
        <td height="25">配送与取货</td>
        <td><textarea name="config[quhuo]" style="width:300px; height:100px"><?php echo $edit[config][quhuo]?></textarea></td>
      </tr>
	  <tr bgcolor="#f5fbff">
        <td height="25">付款方式</td>
        <td><textarea name="config[fukuan]" style="width:300px; height:100px"><?php echo $edit[config][fukuan]?></textarea></td>
      </tr>
	  <tr bgcolor="#f5fbff">
        <td height="25">售后服务</td>
        <td><textarea name="config[service]" style="width:300px; height:100px"><?php echo $edit[config][service]?></textarea></td>
      </tr>
	  <?php }?>
      </tbody>
      </table>
</div>
<center><input type="submit" name="plugin_submit" value="提 交" class="mymps large" /></center>
</form>
<?php mymps_admin_tpl_global_foot();?>