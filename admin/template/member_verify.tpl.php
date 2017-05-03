<?php include mymps_tpl('inc_head');?>
<div id="<?=MPS_SOFTNAME?>" style="padding-bottom:0">
	<div class="mpstopic-category">
		<div class="panel-tab">
			<ul class="clearfix tab-list">
                <li><a href="member.php?part=verify&type=person&do_action=default" <? if($type=='person'){?>class="current"<? }?>>个人会员(<?=$count[person]?>)</a></li>
				<li><a href="member.php?part=verify&type=store&do_action=default" <? if($type=='store'){?>class="current"<? }?>>商家会员(<?=$count[store]?>)</a></li>
			</ul>
		</div>
	</div>
</div>
<form name='form1' method='post' action='member.php' onSubmit='return checkSubmit();'>
<input type='hidden' name='part' value='verify'/>
<input name="url" type="hidden" value="<?=GetUrl()?>">
<input name="do_act" value="<?=$type?>" type="hidden">
<div id="<?=MPS_SOFTNAME?>">
<table border="0" cellspacing="0" cellpadding="0" class="vbm">
    <tr class="firstr">
      <td width="30">选择</td>
      <td width="30">编号</td>
      <td width="60">类型</td>
      <td>用户名</td>
      <? if($type == 'store'){?>
      <td>联系人</td><td>固定电话</td><td>联系地址</td>
	  <? }else{?>
      <td>电子邮箱</td>
	  <? }?>
      <td>注册时间</td>
      <td>注册IP</td>
      <td width="30">编辑</td>
    </tr>
    <tbody onmouseover="addMouseEvent(this);">
<?php if(is_array($member)){foreach($member AS $member){
if($admin_id != 1 && $member[userid] == 'admin'){}else{
?>
    <tr align="center" bgcolor="white">
      <td><input type='checkbox' name='id[]' value='<?=$member[id]?>' class='checkbox' id="<?=$member[id]?>"></td>
      <td><?=$member[id]?></td>
      <td><?=$member[if_corp] == 1 ? '商家' : '个人'?></td>
	  <td><font color="red">[待审]</font> <a href="javascript:void(0);" onclick="
setbg('<?=MPS_SOFTNAME?>会员中心',400,110,'../box.php?part=member&userid=<?=$member[userid]?>&admindir=<?=$admindir?>')"><?php echo $member['if_corp'] ? $member['tname'].'('.$member[userid].')' : $member[userid]; ?></a></td>
	  <? if($type == 'store'){?><td><?=$member[cname]?></td><td><?=$member[tel]?></td><td><font title="<?=$member[address]?>"><?=cutstr($member[address],20)?></font></td><? }else{?>
      <td><?=$member[email]?></td>
	  <? }?>
      <td><em><?=GetTime($member[jointime])?></em></td>
      <td><a href="
javascript:setbg('查看IP所在地',400,110,'../box.php?part=iptoarea&ip=<?=$member[joinip]?>&admindir=<?=$admindir?>')" title="点击查看注册地"><?=$member[joinip]?></a></td>
      <td><a href="member.php?part=edit&id=<?=$member[id]?>">详情</a></td>
    </tr>
<?php }}}?>
</tbody>
<tr bgcolor="#ffffff" height="28">
    <td style="border-right:1px #fff solid;"><input name="checkall" type="checkbox" id="checkall" onClick="CheckAll(this.form)" class="checkbox"/></td>
    <td colspan="10">
	  <label for="yes"><input type="radio" id="yes" value="yes" name="do_action" checked>通过审核</label>
      <? if($type == 'store'){?><label for="no"><input type="radio" id="no" value="no" name="do_action">否决审核</label><? }?>
      <label for="del"><input type="radio" id="del" value="del" name="do_action">删除会员</label>
    </td>
</tr>
<tr>
<td colspan="10">
<input type="submit" value="提 交" class="mymps large"/>&nbsp;&nbsp; <? if($type == 'person'){?>
<input class="gray large" onClick="window.location.href='?part=verify&do_action=yes&do_act=allperson'" value="全部个人会员通过审核" type="button"> &nbsp;&nbsp;
<input class="gray large" onClick="window.location.href='?part=verify&do_action=del&do_act=allperson'" value="删除全部待审个人会员" type="button">
<? }else{?>
<input class="gray large" onClick="window.location.href='?part=verify&do_action=yes&do_act=allstore'" value="全部商家通过审核" type="button"> &nbsp;&nbsp;
<input class="gray large" onClick="window.location.href='?part=verify&do_action=no&do_act=allstore'" value="否决全部待审商家" type="button"> &nbsp;&nbsp;
<input class="gray large"  onClick="window.location.href='?part=verify&do_action=del&do_act=allstore'" value="删除全部待审商家" type="button">
<? }?>
</td>
</tr>
</table>
</div>
<div class="pagination"><?=page2()?></div>
</form>
<?php mymps_admin_tpl_global_foot();?>