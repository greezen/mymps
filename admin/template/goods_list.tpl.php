<?php 
include mymps_tpl('inc_head');
$admindir = getcwdOL();
?>

<form action="?" method="get">
  <div id="<?=MPS_SOFTNAME?>">
    <table border="0" cellspacing="0" cellpadding="0" class="vbm">
      <tr class="firstr">
       <td colspan="2">搜索符合条件的商品</td>
     </tr>
     <tr bgcolor="#ffffff">
      <td style="background-color:#f1f5f8; width:40%">商品名称</td>
      <td>&nbsp;<input name="goodsname" class="text" value="<?php echo $goodsname; ?>"></td>
    </tr>
    <tr bgcolor="#ffffff">
      <td style="background-color:#f1f5f8; width:40%">用户名(UserID)</td>
      <td>&nbsp;<input name="userid" class="text" value="<?php echo $userid; ?>"></td>
    </tr>
    <tr bgcolor="#ffffff">
      <td style="background-color:#f1f5f8; width:40%">所属分类</td>
      <td>&nbsp;<select name="catid">
       <option value="">==选择商品所属的分类==</option>
       <?=goods_cat_list(0,$catid)?>
     </select></td>
   </tr>
   <?php if(!$admin_cityid){?>
   <tr bgcolor="#ffffff">
     <td style="background-color:#f1f5f8; width:40%">所属地区</td>
     <td>&nbsp;<select name="cityid">
       <option value="">全部</option>
       <?php echo get_cityoptions($cityid); ?>
     </select></td>
   </tr>
   <? }else{ ?>
   <input name="cityid" value="<?php echo $admin_cityid?>" type="hidden" />
   <? }?>
 </table>
</div>
<center><input type="submit" value="提 交" class="mymps large" /></center>
<div class="clear" style="margin-bottom:5px"></div>
</form>
<div id="<?=MPS_SOFTNAME?>" style="padding-bottom:0">
  <div class="mpstopic-category">
   <div class="panel-tab">
    <ul class="clearfix tab-list">
      <li><a href="?part=list" <?php if($type == ''){?>class="current"<?php }?>>全部</a></li>
      <?php foreach($goodslevel as $k => $v){?>
      <li><a href="?part=list&type=<?=$k?>" <?php if($type == $k){?>class="current"<?php }?>><?=$v?></a></li>
      <?php }?>
    </ul>
  </div>
</div>
</div>
<form action="?part=list" method="post">
  <input name="url" type="hidden" value="<?=GetUrl()?>">
  <div id="<?=MPS_SOFTNAME?>">
    <table border="0" cellspacing="0" cellpadding="0" class="vbm" >
      <tr class="firstr">
        <td width="30">&nbsp;</td>
        <td>商品名称</td>
        <td width="100">商品分类</td>
        <td width="100">供货商家</td>
        <td>发布时间</td>
        <td>状态</td>
        <td>操作</td>
      </tr>
      <tbody onmouseover="addMouseEvent(this);">
        <?php foreach($goods AS $row){?>
        <tr bgcolor="white" >
          <td><input type='checkbox' name='selectedids[]' value="<?=$row['goodsid']?>" class='checkbox' id="<?=$row['goodsid']?>"></td>
          <td><a href="../goods.php?id=<?=$row[goodsid]?>" target="_blank"><?=$row['goodsname']?></a>
           <?php if($row['tuijian'] == 1){?><img src="../../plugin/goods/template/images/tuijian.gif" align="absmiddle"><?}?>
           <?php if($row['remai'] == 1){?><img src="../../plugin/goods/template/images/remai.gif" align="absmiddle"><?}?>
           <?php if($row['cuxiao'] == 1){?><img src="../../plugin/goods/template/images/cuxiao.gif" align="absmiddle"><?}?>
         </td>
         <td><a href="../goods.php?catid=<?=$row[catid]?>" target="_blank"><?=$row[catname]?></a></td>
         <td><a href="javascript:void(0);" onclick="
          setbg('<?=MPS_SOFTNAME?>会员中心',400,110,'../box.php?part=member&userid=<?=$row[userid]?>&admindir=<?=$admindir?>')"><?=$row[userid]?></a></td>
          <td><em><?php echo GetTime($row['dateline']); ?></em></td>
          <td>
            <?php echo $goodslevel[$row['onsale']] ?></td>
            <td><a href="?part=edit&id=<?=$row[goodsid]?>">编辑</a></td>
          </tr>
          <?}?>
        </tbody>
        <tr bgcolor="#ffffff" height="28">
          <td style="border-right:1px #fff solid;"><input name="checkall" type="checkbox" id="checkall" onClick="CheckAll(this.form)" class="checkbox"/></td>
          <td colspan="10">
            <?php foreach($goodslevel as $k => $v){?>
            <label for="goodslevel<?=$k?>"><input type="radio" value="goodslevel<?=$k?>" id="goodslevel<?=$k?>" name="action" class="radio">转为<?=$v?></label> 
            <?php }?>
            <hr style="height:1px; border:1px #c5d8e8 solid;"/>
            <label for="delall"><input type="radio" value="delall" id="delall" name="action" class="radio">批量删除</label> 
          </td>
        </tr>
      </table>
    </div>
    <center><input type="submit" value="提 交" class="mymps large" name="goods_submit"/></center>
  </form>
  <div class="pagination"><?php echo page2();?></div>
  <?php mymps_admin_tpl_global_foot();?>