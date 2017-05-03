<?php include mymps_tpl('inc_head');?>

<form action="?" name="form1" method="post">
<input name="url" value="<?=$url?>" type="hidden">
<input name="action" value="<?=$do_action?>" type="hidden">
<input name="id" value="<?=$id?>" type="hidden">
<input name="typeid" value="<?=$typeid?>" type="hidden">
<input name="userid" value="<?=$userid?>" type="hidden">
<input name="part" value="sendpm" type="hidden" />
<?php if(in_array($do_action,array('upgrade_index','upgrade','upgrade_list'))){?>
<div id="<?=MPS_SOFTNAME?>">
<table border="0" cellspacing="0" cellpadding="0" class="vbm">
<tr class="firstr">
	<td class="h" style="text-align:right">置顶时间</td><td class="h">&nbsp;</td>
</tr>
<tr bgcolor="#f5fbff">
    <td width="20%" style="text-align:right;">您选择的置顶类型：</td>
    <td bgcolor="white">
    <font color="red"><?php echo $do_action == 'upgrade_index' ? '首页置顶' :( $do_action == 'upgrade_list' ? '小类置顶' : '大类置顶'); ?></font>
    </td>
</tr>
<tr bgcolor="#f5fbff">
    <td width="20%" style="text-align:right;">请选择置顶时间：</td>
    <td bgcolor="white">
    <?=GetUpgradeTime()?>
    </td>
</tr>
</table>
</div>
<?php }?>
<?php if(in_array($do_action,array('ifred'))){?>
<div id="<?=MPS_SOFTNAME?>">
<table border="0" cellspacing="0" cellpadding="0" class="vbm">
<tr bgcolor="#f5fbff">
    <td width="20%" style="text-align:right;">信息标题是否套红：</td>
    <td bgcolor="white">
        <select name="ifred">
            <option value="1">套红</option>
            <option value="0">取消套红</option>
        </select>
    </td>
</tr>
</table>
</div>
<?php }?>
<?php if(in_array($do_action,array('ifbold'))){?>
<div id="<?=MPS_SOFTNAME?>">
<table border="0" cellspacing="0" cellpadding="0" class="vbm">
<tr bgcolor="#f5fbff">
    <td width="20%" style="text-align:right;">信息标题是否加粗：</td>
    <td bgcolor="white">
        <select name="ifbold">
            <option value="1">加粗</option>
            <option value="0">取消加粗</option>
        </select>
    </td>
</tr>
</table>
</div>
<?php }?>
<div id="<?=MPS_SOFTNAME?>">
<table border="0" cellspacing="0" cellpadding="0" class="vbm">
<tr class="firstr"><td class="h" style="text-align:right">管理选项</td><td class="h">&nbsp;</td></tr>
	<tr bgcolor="#f5fbff">
		<td width="20%" style="text-align:right;">金币处理：</td>
        <td bgcolor="white">
			<input type="radio" class="radio" name="if_money" value="1" onClick="this.form.money_num.disabled=false"/>是
			<input type="radio" class="radio" name="if_money" value="0" checked onClick="this.form.money_num.disabled=true"/>否
		</td>
	</tr>
    
	<tr bgcolor="#f5fbff">
		<td width="20%" style="text-align:right;">金币变化：</td>
        <td bgcolor="white">
            <img src="../member/images/mymps_icon_incomes.gif" align="absmiddle">
            <input name="money_num" disabled="disabled" value="<?php echo $nummoney ? $nummoney : '+2';?>" style="width:40px; margin-top:5px">(增加金币为+，扣除金币为-)
		</td>
	</tr>

	<tr bgcolor="#f5fbff">
		<td width="20%" style="text-align:right;">短消息通知：</td>
		<td bgcolor="white">
			<input type="radio" class="radio" name="if_pm" value="1" onClick="this.form.because.disabled=false;this.form.msg.disabled=false;this.form.title.disabled=false"/>是
			<input type="radio" class="radio" name="if_pm" value="0" checked onClick="this.form.because.disabled=true;this.form.msg.disabled=true;this.form.title.disabled=true"/>否
		</td>
	</tr>
    
	<tr bgcolor="#f5fbff">
		<td width="20%" style="text-align:right;">通知标题：</td>
		<td>
			<input name="title" value="<?=$title?>" id="title" class="text" style="width:300px"/>
		</td>
	</tr>
    
	<tr bgcolor="#f5fbff">
		<td style="text-align:right;">通知内容：</td>
		<td bgcolor="white">
        <select name="because" disabled="disabled" size="10" multiple onchange="this.form.msg.value=this.value">
            <option value="">自定义</option>
            <?php foreach($info_do_type as $k=>$v){?>
            	<optgroup label="<?=$k?>"><?=$k?></optgroup>
                <?php foreach ($v as $w=>$m){?>
                	<option value="<?=$m?>"><?=$m?></option>
                <?}?>
            <?}?>
        </select>&nbsp;&nbsp;
        <textarea name="msg" disabled="disabled" rows="10" cols="80"></textarea>
		</td>
	</tr>
    
	<tr bgcolor="#f5fbff">
    <td>&nbsp;</td>
    <td bgcolor="white">
    <input type="submit" value="提 交" style="margin-left:5px;" class="mymps mini" name="<?=CURSCRIPT?>_submit"/>&nbsp;&nbsp;
    <input type="button" onclick="javascript:history.go(-1)" class="mymps mini" value="返 回"/>
	</td>
    </tr>
</table>
</div>
</form>
<?php mymps_admin_tpl_global_foot();?>