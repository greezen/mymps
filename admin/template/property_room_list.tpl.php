<? include mymps_tpl('inc_head')?>
<div id="<?=MPS_SOFTNAME?>" style=" padding-bottom:0">
    <div class="mpstopic-category">
        <div class="panel-tab">
            <ul class="clearfix tab-list">
                <li><a href="?part=list" class="current">房号信息</a></li>
                <li><a href="?part=add">增加房号</a></li>
            </ul>
        </div>
    </div>
</div>
<form action="?" method="get">
    <div id="<?=MPS_SOFTNAME?>">
        <table border="0" cellspacing="0" cellpadding="0" class="vbm">
            <tr class="firstr">
                <td colspan="2">搜索</td>
            </tr>
            <tr bgcolor="#ffffff">
                <td style="background-color:#f1f5f8; width:40%">房号</td>
                <td>&nbsp;<input name="name" class="text" value="<?php echo $name; ?>"></td>
            </tr>
        </table>
    </div>
    <center><input type="submit" value="提 交" class="mymps large" /></center>
    <div class="clear" style="margin-bottom:5px"></div>
</form>
<div id="<?=MPS_SOFTNAME?>">
<table border="0" cellspacing="0" cellpadding="0" class="vbm">
    <tr class="firstr">
      <td>编号</td>
      <td>房号</td>
      <td>地址</td>
      <td>创建时间</td>
      <td>更新时间</td>
      <td>操作</td>
    </tr>
<?php foreach($list as $item) :?>
  <tr>
  <td width="40"><?=$item['room_id']?></td>
  <td><?=$item['name']?></td>
  <td><?=get_address($item['building_id'], 'building')?></td>
  <td><?=date('Y-m-d H:i:s', $item['time_created'])?></td>
  <td><?=date('Y-m-d H:i:s', $item['time_updated'])?></td>
  <td>
      <a href="?part=edit&room_id=<?=$item['room_id']?>">编辑</a> /
      <a href="?part=del&room_id=<?=$item['room_id']?>" onClick="if(!confirm('确定要删除该房号吗？'))return false;">删除</a>
  </td>
</tr>
<?php endforeach;?>
</table>
<div class="pagination"><?php echo page2();?></div>
</div>
<?=mymps_admin_tpl_global_foot()?>