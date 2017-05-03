<?php include mymps_tpl('inc_head');?>
<script language="javascript" src="js/vbm.js"></script>
<script language="javascript">
    function check_sub(){
       if (document.form1.goodsname.value=="") {
          alert('请填写商品名称');
          document.form1.goodsname.focus();
          return false;
      }
      if (document.form1.userid.value=="") {
          alert('请填写发起商品的会员用户名');
          document.form1.userid.focus();
          return false;
      }
      if (document.form1.content.value=="") {
          alert('请填写商品详细介绍！');
          document.form1.content.focus();
          return false;
      }
      return true;
  }
</script>
<style>
    .vbm tr{ background:#ffffff}
    .altbg1{ background-color:#f1f5f8;}
</style>
<form name="form1" action="?part=edit&id=<?=$id?>" method="post" enctype="multipart/form-data" onSubmit="return check_sub();">
    <input name="pre_picture" value="<?=$edit['pre_picture']?>" type="hidden">
    <input name="picture" value="<?=$edit['picture']?>" type="hidden">
    <div id="<?=MPS_SOFTNAME?>">
        <table width="100%" cellspacing="0" cellpadding="0" class="vbm">
            <tr class="firstr">
               <td colspan="2">基本信息</td>
           </tr>
           <tr>
            <td class="altbg1">隶属分站:<font color="red">*</font></td>
            <td>
                <select name="cityid">
                   <option value="">>总站</option>
                   <?php echo get_cityoptions($edit['cityid']); ?>
               </select>
           </td>
       </tr>
       <tr>
        <td class="altbg1">商品名称:<font color="red">*</font></td>
        <td>
            <input type="text" name="goodsname" value="<?=$edit['goodsname']?>" class="text" />
        </td>
    </tr>
    <tr>
        <td class="altbg1" width="15%">供货商家用户名:<font color="red">*</font></td>
        <td width="75%">
            <input type="text" name="userid" id="userid" value="<?=$edit['userid']?>" class="text" style="background-color:#eee"/> <font color=red>非必要，请勿修改</font>
        </td>
    </tr>
    <tr>
        <td class="altbg1">市场价格:</td>
        <td>
           <input name="oldprice" value="<?=$edit['oldprice']?>" type="text" class="text" style="width:50px"/> <?php echo $moneytype; ?>
       </td>
   </tr>
   <tr>
    <td class="altbg1">优惠价格:</td>
    <td>
       <input name="nowprice" value="<?=$edit['nowprice']?>" type="text" class="text" style="width:50px"/> <?php echo $moneytype; ?>
   </td>
</tr>
<tr>
    <td class="altbg1">商品分类:<font color="red">*</font></td>
    <td>
        <select name="catid">
           <option value="">==选择商品所属的分类==</option>
           <?=goods_cat_list(0,$edit['catid'])?>
       </select>
   </td>
</tr>
<tr class="firstr">
	<td colspan="2">预览图片</td>
</tr>
<tr>
    <td class="altbg1">商品图片:</td>
    <td> 
        <?php
        echo "<img src=".$mymps_global[SiteUrl]."".$edit[pre_picture]." style='_margin-top:expression(( 180 - this.height ) / 2);' />\r\n";
        ?>
    </td>
</tr>
<tr>
    <td class="altbg1">更新图片:</td>
    <td> 
        <input type="file" name="goods_image" size="30" id="litpic" onChange="SeePic(document.picview,document.form1.litpic);">
    </td>
</tr>
<tr>
    <td class="altbg1">预览:</td>
    <td> 
        <img src="template/images/mpview.gif" width="150" id="picview" name="picview" />
    </td>
</tr>
<tr class="firstr">
	<td colspan="2">附加信息</td>
</tr>
<tr>
    <td class="altbg1">赠送礼品:</td>
    <td>
       <input name="gift" value="<?php if($edit['gift'] == ''){echo '本商品没有赠送礼品';}else{echo $edit['gift'];}?>" class="text">
   </td>
</tr>
<tr>
    <td class="altbg1">货源情况:</td>
    <td>
       <input name="huoyuan" type="radio" class="radio" value="1" <?php if($edit['huoyuan'] == 1 || !$id) echo 'checked';?>>有货
       <input name="huoyuan" type="radio" class="radio" value="2" <?php if($edit['huoyuan'] != 1) echo 'checked';?>>缺货
   </td>
</tr>
<tr>
    <td class="altbg1">商品属性:</td>
    <td>
      <input name="rushi" type="checkbox" class="radio" value="1" <?php if($edit['rushi'] == 1 || !$id) echo 'checked';?>>如实描述
      <input name="tuihuan" type="checkbox" class="radio" value="1" <?php if($edit['tuihuan'] == 1 || !$id) echo 'checked';?>>七天退换
      <input name="jiayi" type="checkbox" class="radio" value="1" <?php if($edit['jiayi'] == 1 || !$id) echo 'checked';?>>假一赔三
      <input name="weixiu" type="checkbox" class="radio" value="1" <?php if($edit['weixiu'] == 1) echo 'checked';?>>30天维修
      <input name="fahuo" type="checkbox" class="radio" value="1" <?php if($edit['fahuo'] == 1 || !$id) echo 'checked';?>>闪电发货
      <input name="zhengpin" type="checkbox" class="radio" value="1" <?php if($edit['zhengpin'] == 1 || !$id) echo 'checked';?>>正品保障
  </td>
</tr>
<tr>
    <td class="altbg1">商品状态:</td>
    <td>
      <input name="onsale" type="checkbox" class="radio" value="1" <?php if($edit['onsale'] == 1) echo 'checked';?>>上架
      <input name="tuijian" type="checkbox" class="radio" value="1" <?php if($edit['tuijian'] == 1) echo 'checked';?>>推荐
      <input name="remai" type="checkbox" class="radio" value="1" <?php if($edit['remai'] == 1) echo 'checked';?>>热卖
      <input name="cuxiao" type="checkbox" class="radio" value="1" <?php if($edit['cuxiao'] == 1) echo 'checked';?>>促销
      <input name="baozhang" type="checkbox" class="radio" value="1" <?php if($edit['baozhang'] == 1 || !$id) echo 'checked';?>>加入消费者保障计划
  </td>
</tr>
</table>
<div style="margin-top:3px;"><?php echo $acontent; ?></div>
</div>
<div style="padding-left:18%; padding-top:10px; padding-bottom:10px;">
    <input type="submit" name="goods_submit" value="提 交" class="mymps large" style="margin-right:15px"/>
    <input type="button" onclick="history.back();" value="返回" class="mymps large" />
</div>
</form>
<?php mymps_admin_tpl_global_foot();?>