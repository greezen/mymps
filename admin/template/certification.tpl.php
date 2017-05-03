<?php include mymps_tpl('inc_head');
$admindir = getcwdOL();
?>
<script type='text/javascript' src='js/vbm.js'></script>
<div id="<?=MPS_SOFTNAME?>" style=" padding-bottom:0">
    <div class="mpstopic-category">
        <div class="panel-tab">
            <ul class="clearfix tab-list">
            <?php foreach($certify_arr as $k => $v){?>
                <li><a href="?typeid=<?=$k?>" <?php if($typeid==$k){?>class="current"<?php }?>><?=$v?></a></li>
            <?php }?>
            </ul>
        </div>
    </div>
</div>
<form name='form1' method='post' action='certification.php'>
<input name="forward_url" value="<?=GetUrl()?>" type="hidden">
<div id="<?=MPS_SOFTNAME?>">
    <table border="0" cellspacing="0" cellpadding="0" class="vbm">
    <tr class="firstr">
    <td colspan="6"><b><?=$certify_arr[$typeid]?>认证提交记录</b></td>
    </tr>
    <tr style="font-weight:bold; background-color:#f5f8ff">
      <td><input class="checkbox" name="checkall" type="checkbox" id="checkall" onClick="CheckAll(this.form)"/> 删?</td>
      <td>相关图片</td>
      <td>会员名</td>
      <td>类型</td>
      <td>编辑</td>
    </tr>
    <?php foreach($certification as $k =>$value){?>
        <tr bgcolor="white">
          <td><input class="checkbox" type='checkbox' name='delids[]' value='<?=$value[id]?>' id="<?=$value[id]?>"></td>
          <td><a href='javascript:blocknone("pm_<?=$value[id]?>");'><?=$value[img_path]?></a></td>
          <td><a href="
javascript:setbg('Mymps会员中心',400,110,'../box.php?part=member&userid=<?=$value[userid]?>&admindir=<?=$admindir?>')"><?=$value[userid]?></a>
<hr style="width:80px;"/>
<?php if($value[per_certify] == '1'){?>
        <img src="../images/person1.gif" alt="已通过身份证认证"/>
        <?}else{?>
        <img src="../images/person0.gif" alt="未通过身份证认证"/>
        <?}?>
        <?php if($value[com_certify] == '1'){?>
        <img src="../images/company1.gif" alt="已通过营业执照认证"/>
        <?}else{?>
        <img src="../images/company0.gif" alt="未通过营业执照认证"/>
        <?}?>
</td>
          <td><?=$certify_arr[$value[typeid]]?></td>
          <td><a href="?part=yes&userid=<?=$value[userid]?>&typeid=<?=$typeid?>&page=<?=$page?>">通过审核</a> | <a href="?part=no&userid=<?=$value[userid]?>&typeid=<?=$typeid?>&page=<?=$page?>">注销审核</a></td>
        </tr>
        <tr style="background-color:white; display:none" id="pm_<?=$value[id]?>">
            <td>&nbsp;</td>
            <td colspan="5"><img src="<?=$value[img_path]?>" height="200"/></td>
            </tr>
    <?}?>
    </table>
</div>
<center>
<input type="submit" value="提 交" class="mymps large" name="certification_submit"/>  
</center>
</form>
<div class="pagination"><?php echo page2();?></div>
<?php mymps_admin_tpl_global_foot();?>