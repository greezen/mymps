<? include mymps_tpl('inc_head')?>
<div id="<?=MPS_SOFTNAME?>" style=" padding-bottom:0">
    <div class="mpstopic-category">
        <div class="panel-tab">
            <ul class="clearfix tab-list">
                <li><a href="?part=add">信息录入</a></li>
                <li><a href="?part=list" class="current">信息查询</a></li>
            </ul>
        </div>
    </div>
</div>
<form name="form_mymps" action="?part=list" method="post">
<div id="<?=MPS_SOFTNAME?>">
<table border="0" cellspacing="0" cellpadding="0" class="vbm">
    <tr class="firstr">
      <td>编号</td>
      <td>应交时间</td>
      <td>价格</td>
      <td>地址</td>
      <td>创建时间</td>
      <td>更新时间</td>
      <td>操作</td>
    </tr>
<?php foreach($list as $item) :?>
  <tr>
  <td width="40"><?=$item['id']?></td>
  <td><?=$item['period']?></td>
  <td><?=$item['manage_fee']+$item['electric_fee']+$item['water_fee']+$item['other_fee']?></td>
  <td><?=get_address($item['room_id'], 'room')?></td>
  <td><?=date('Y-m-d H:i:s', $item['time_created'])?></td>
  <td><?=date('Y-m-d H:i:s', $item['time_updated'])?></td>
  <td>
      <a href="?part=edit&id=<?=$item['id']?>">编辑</a> /
      <a href="?part=copy&id=<?=$item['id']?>">复制</a> /
      <a href="?part=del&id=<?=$item['id']?>" onClick="if(!confirm('确定要删除此信息吗？'))return false;">删除</a>
  </td>
</tr>
<?php endforeach;?>
</table>
<div class="pagination"><?php echo page2();?></div>
</div>
</form>
<?=mymps_admin_tpl_global_foot()?>