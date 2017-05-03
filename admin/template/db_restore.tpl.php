<?php include mymps_tpl('inc_head');?>
<script type='text/javascript' src='js/vbm.js'></script>
<div id="<?=MPS_SOFTNAME?>">
  <table border="0" cellspacing="0" cellpadding="0" class="vbm">
    <tr class="firstr">
     <td colspan="2">技巧提示</td>
   </tr>
   <tr bgcolor="#ffffff">
    <td id="menu_tip">
      <li>恢复备份数据的同时将覆盖原有数据！！！！</li>
      <li>数据恢复功能只能恢复由本系统导出的数据文件</li>
      <li>从本地恢复数据需要服务器支持上传并保证数据小于上传上限</li>
      <li>如果您使用了分卷备份导入文件卷1其他数据文件会自动导入</li>
    </td>
  </tr>
</table>
</div>
<form name="cpform" method="post" action="?part=restore&action=dodelete">
  <div id="<?=MPS_SOFTNAME?>">
    <table border="0" cellspacing="0" cellpadding="0" class="vbm">
      <tr class="firstr">
        <td width="50"><input type="checkbox" name="chkall" id="chkall" class="checkbox" onclick="CheckAll(this.form)" /><label for="chkall">删?</label></td>
        <td>文件名</td>
        <td>版本</td>
        <td>时间</td>
        <td>类型</td>
        <td>尺寸</td>
        <td>卷数</td>
        <td>&nbsp;</td>
      </tr>

      <?php
      foreach($exportlog as $key => $val) {
        $info = $val[1];
        $info['dateline'] = is_int($info['dateline']) ? GetTime($info['dateline']): '未知';
        $info['size'] = sizecount($exportsize[$key]);
        $info['volume'] = count($val);
        $info['method'] = $info['method'] == 'multivol' ? $lang['db_multivol'] : $lang['db_shell'];
        ?>
        <tr bgcolor="#ffffff">
          <td  width="40"><input class="checkbox" type="checkbox" name="delete[]" value="<?=$key?>"></td>
          <td><a href="javascript:;" onclick="javascript:blocknone('exportlog_<?=$key?>')"><img id="menuimg_1" src="template/images/menu_add.gif" align="absmiddle"/> <?=$key?></a></td>
          <td><?=$info['version']?></td>
          <td><?=$info['dateline']?></td>
          <td><?=$backuptype[$info['type']]?></td>
          <td><?=$info['size']?></td>
          <td><?=$info['volume']?></td>
          <td><?php echo "<a class=\"act\" href=\"?part=restore&from=server&datafile_server=$info[filename]&action=dorestore\"".($info['version'] != $version ? " onclick=\"return confirm('该备份文件的系统版本与你当前使用的mymps版本不同');\"" : '')." class=\"act\">导入</a>"?></td>
        </tr>
        <tbody id="exportlog_<?=$key?>" style="display:none">
          <?php foreach($val as $v) {
           $v['dateline'] = is_int($v['dateline']) ? GetTime($v['dateline']) : '未知';
           $v['size'] = sizecount($v['size']);
           ?>
           <tr bgcolor="#ffffff"><td>&nbsp;</td><td><i style="color:#666"><?=substr(strrchr($v['filename'], "/"), 1)?></i></td><td><i style="color:#666"><?=$v['version']?></i></td><td><i style="color:#666"><?=$v['dateline']?></i></td><td><i style="color:#666"><?=$backuptype[$v['type']]?></i></td><td><i style="color:#666"><?=$v['size']?></i></td><td><i style="color:#666"><?=$v['volume']?>#</i></td><td>&nbsp;</td></tr>
           <?
         }
         ?>
       </tbody>
       <?
     }
     ?>
   </table>
 </div>
 <center>
  <input type="submit" name="submit" value="提 交" class="mymps large"/>
</center>
</form>
<?php mymps_admin_tpl_global_foot();?>