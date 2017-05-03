<?php include mymps_tpl('inc_head');?>
<div id="<?=MPS_SOFTNAME?>">
<table border="0" cellspacing="0" cellpadding="0" class="vbm">
  <tr class="firstr">
  	<td colspan="2">技巧提示</td>
  </tr>
  <tr bgcolor="#ffffff">
    <td id="menu_tip">
		<li>
	    数据表优化可以去除数据文件中的碎片，使记录排列紧密，提高读写速度。</li>
    </td>
  </tr>
</table>
</div>
<div id="<?=MPS_SOFTNAME?>" style="padding-bottom:0">
<div class="mpstopic-category">
	<div class="panel-tab">
		<ul class="clearfix tab-list">
			<li><a href="?part=optimize" <?php if($part == 'optimize'){?>class="current"<?php }?>>数据库优化</a></li>
			<li><a href="?part=check" <?php if($part == 'check'){?>class="current"<?php }?>>数据库检查</a></li>
			<li><a href="?part=repair" <?php if($part == 'repair'){?>class="current"<?php }?>>数据库修复</a></li>
			<li><a href="data_replace.php">数据库内容替换</a></li>
		</ul>
	</div>
</div>
</div>
<?php if($part == 'optimize'){?>
<div id="<?=MPS_SOFTNAME?>">
<table border="0" cellspacing="0" cellpadding="0" class="vbm">
<tr class="firstr">
<td>数据表</td><td>类型</td><td>记录数</td><td>数据</td><td>索引</td><td>碎片</td></tr>
<?php

foreach($tablearray as $tp) {
    $query = $db->query("SHOW TABLE STATUS LIKE '$tp%'", 'SILENT');
    while($table = $db->fetchRow($query)) {
        if(is_array($optimizetables) && in_array($table['Name'], $optimizetables)) {
            if($part == 'optimize') {
				$db->query("OPTIMIZE TABLE $table[Name]");
			} elseif($part == 'check'){
				$db->query("CHECK TABLE $table[Name]");
			} elseif($part == 'repair'){
				$db->query("REPAIR TABLE $table[Name]");
			}
        }
?>
<tr bgcolor="#ffffff"><td><?=$table[Name]?></td><td><?=$table[$tabletype]?></td><td><?=$table[Rows]?></td><td><?=$table[Data_length]?></td><td><?=$table[Index_length]?></td><td><?=$table[Data_free]?></td></tr>
<?php
         $totalsize += $table['Data_length'] + $table['Index_length'];
    }
}
?>
<tr bgcolor="#ffffff">
	<td colspan="7"><?=sizecount($totalsize)?></td>
</tr>
</table>
</div>
<?php }elseif($part == 'check'){?>
<div id="<?=MPS_SOFTNAME?>">
<table border="0" cellspacing="0" cellpadding="0" class="vbm">
<tr class="firstr">
<td>检查</td><td>数据表</td><td>类型</td><td>记录数</td><td>数据</td><td>索引</td></tr>
<?php

foreach($tablearray as $tp) {
    $query = $db->query("SHOW TABLE STATUS LIKE '$tp%'", 'SILENT');
    while($table = $db->fetchRow($query)) {
        if(is_array($optimizetables) && in_array($table['Name'], $optimizetables)) {
            $db->query("CHECK TABLE $table[Name]");
       
?>
<tr bgcolor="#ffffff"><td><font color="green">成功</font></td><td><?=$table[Name]?></td><td><?=$table[$tabletype]?></td><td><?=$table[Rows]?></td><td><?=$table[Data_length]?></td><td><?=$table[Index_length]?></td></tr>
<?php
	 }
    }
}
?>
</table>
</div>
<?php }elseif($part == 'repair'){?>
<div id="<?=MPS_SOFTNAME?>">
<table border="0" cellspacing="0" cellpadding="0" class="vbm">
<tr class="firstr">
<td>修复</td><td>数据表</td><td>类型</td><td>记录数</td><td>数据</td><td>索引</td></tr>
<?php

foreach($tablearray as $tp) {
    $query = $db->query("SHOW TABLE STATUS LIKE '$tp%'", 'SILENT');
    while($table = $db->fetchRow($query)) {
        if(is_array($optimizetables) && in_array($table['Name'], $optimizetables)) {
            $db->query("REPAIR TABLE $table[Name]");
        
?>
<tr bgcolor="#ffffff"><td><font color="green">成功</font></td><td><?=$table[Name]?></td><td><?=$table[$tabletype]?></td><td><?=$table[Rows]?></td><td><?=$table[Data_length]?></td><td><?=$table[Index_length]?></td></tr>
<?php
		}
    }
}
?>
</table>
</div>
<?php }?>
<?php mymps_admin_tpl_global_foot();?>