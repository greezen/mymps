<?php include mymps_tpl('inc_head');?>
<style>
.start0 { background:url('images/review_start.gif') no-repeat 0 -1px;  width:58px; height:15px; }
.start1 { background:url('images/review_start.gif') no-repeat 0 -15px; width:58px; height:15px; }
.start2 { background:url('images/review_start.gif') no-repeat 0 -29px; width:58px; height:15px; }
.start3 { background:url('images/review_start.gif') no-repeat 0 -43px; width:58px; height:15px; }
.start4 { background:url('images/review_start.gif') no-repeat 0 -57px; width:58px; height:15px; }
.start5 { background:url('images/review_start.gif') no-repeat 0 -71px; width:58px; height:15px; }
</style>
<script type="text/javascript" src="/template/global/messagebox.js"></script>
<script type="text/javascript" src="js/vbm.js"></script>
<div id="<?=MPS_SOFTNAME?>" style="padding-bottom:0">
	<div class="mpstopic-category">
		<div class="panel-tab">
			<ul class="clearfix tab-list">
				<li><a href="member_tpl.php">空间模板</a></li>
				<li><a href="member_comment.php" class="current">空间点评</a></li>
			</ul>
		</div>
	</div>
</div>
<div class="ccc2">
	<ul>
    <form action="?part=list" method="get">
    <select name="commentlevel">
    <option value="">审核状态</option>
    <option value="0" <?php if($_GET[commentlevel] == 0){echo "selected"; }?>>待审</option>
    <option value="1" <?php if($_GET[commentlevel] == 1){echo "selected"; }?>>正常</option>
    </select>
    <input name="keywords" type="text" class='text' value="<?=$keywords?>">
     &nbsp;&nbsp;<input type="submit" value="检索点评" class="gray mini">&nbsp;&nbsp; 
    </form>
	</ul>
</div>
<form name='form1' method='post' action='?'>
<input name="url" type="hidden" value="<?=GetUrl()?>">
<div id="<?=MPS_SOFTNAME?>">
<table border="0" cellspacing="0" cellpadding="0" class="vbm">
    <tr class="firstr">
      <td width="40">选择</td>
        <td>来自</td>
        <td>质量</td>
        <td>服务</td>
        <td>环境</td>
        <td>性价比</td>
        <td>点评的空间</td>
        <td>状态</td>
        <td>点评时间</td>
    </tr>
    <?
foreach($comment AS $list)
{
?>
    <tr align="center" bgcolor="#f5fbff" >
      <td><input type='checkbox' name='ids[]' id='<?=$list[id]?>' value='<?=$list[id]?>' class='checkbox'></td>
      <td><a href="javascript:blocknone('pm_<?=$list[id]?>');"><?=$list[fromuser]?>+</a></td>
        <td><div class="start<?=$list[quality]?>"></div></td>
        <td><div class="start<?=$list[service]?>"></div></td>
        <td><div class="start<?=$list[environment]?>"></div></td>
        <td><div class="start<?=$list[price]?>"></div></td>
        <td><a href="javascript:setbg('<?=MPS_SOFTNAME?>会员中心',400,110,'../box.php?part=member&userid=<?=$list[userid]?>')"><?=$list[userid]?></a></td>
        <td>
        <?php if (empty($list['commentlevel'])) echo '<font color=red>待审</font>'; else echo '<font color=green>正常</font>'?>
        </td>
      <td>
      <?=GetTime($list[pubtime])?></td>
    </tr>
    <tr style="background-color:white; display:none" id="pm_<?=$list[id]?>">
        <td>&nbsp;</td>
        <td colspan="8">
        <div class="pm_view">
        <?=$list[content]?>
        </div>
        <div style="margin:0 5px 10px 5px; padding:10px; background-color:#f2f2f2"><b>喜欢程度：</b>
            <?php if($list[enjoy] == '0'){echo '不喜欢';}elseif($list[enjoy] == '1'){echo '无所谓';}elseif($list[enjoy] == '2'){echo '喜欢';}elseif($list[enjoy] == '3'){echo '很喜欢';}?>
            <hr style="height:1px; color:#dedede"/>
            <?php if($list[reply]){?>
            <div style="margin:0 5px 10px 5px; padding:10px; background-color:#f2f2f2">
            <b>回复内容：</b><?=$list[reply]?><hr style="height:1px; color:#dedede"/><b>回复时间：</b><?=GetTime($list[retime])?>
            </div>
            <?php }?>
        </div>
        </td>
    </tr>
    <?
}
?>
    <tr bgcolor="#ffffff" height="28">
    <td align="center" style="border-right:1px #fff solid;"><input name="checkall" type="checkbox" class='checkbox' id="checkall" onClick="CheckAll(this.form)"/></td>
    <td colspan="9">
    <label for="delall"><input type="radio" value="delall" id="delall" name="part" class="radio">批量删除</label>
    <?php foreach($mlevel as $k => $v){?>
    <label for="level<?=$k?>"><input type="radio" value="level.<?=$k?>" id="level<?=$k?>" name="part" class="radio">转为<?=$v?></label> 
    <?php }?>　
    </td>
    </tr>
</table>
</div>
<center><input type="submit" value="提 交" class="mymps large" name="member_comment_submit"/></center>
</form>
<div class="pagination"><?echo page2()?></div>
<?php mymps_admin_tpl_global_foot();?>