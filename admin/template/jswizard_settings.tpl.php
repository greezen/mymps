<?php include mymps_tpl('inc_head');?>
<style>
.smalltxt{ font-size:12px!important; color:#999!important; font-weight:100!important}
.altbg1{ background-color:#f1f5f8}
</style>
<script language="javascript" src="js/vbm.js"></script>
<div id="<?=MPS_SOFTNAME?>" style=" padding-bottom:0">
    <div class="mpstopic-category">
        <div class="panel-tab">
            <ul class="clearfix tab-list">
                <li><a href="?part=settings" class="current">基本设置</a></li>
                <li><a href="?">调用项目管理</a></li>
            </ul>
        </div>
    </div>
</div>
<form method="post" action="?">
<input name="return_url" value="<?php echo GetUrl();?>" type="hidden">
<div id="<?=MPS_SOFTNAME?>">
<table border="0" cellspacing="0" cellpadding="0" class="vbm">
    <tr class="firstr"><td colspan="2">数据调用</td></tr>
    <tbody style="display: yes; background-color:white">
        <tr>
            <td width="45%" class="altbg1" ><b>启用外部调用:</b><br /><span class="smalltxt">外部调用将使得您可以将<?=$mymps_global['SiteName']?>最新分类信息主题、排行等资料嵌入到您的普通网页中，访问者无需访问<?=$mymps_global['SiteName']?>即可获知<?=$mymps_global['SiteName']?>最近更新的情况</span></td><td class="altbg2"><label for="1"><input class="radio" type="radio" name="settingsnew[jsstatus]" value="1" id="1" <?php if($settings[jsstatus] == 1){echo 'checked';} ?> 
            onclick="$Obj('hidden_settings_jsstatus').style.display = '';" > 是</label> &nbsp; &nbsp; 
            <label for="0"><input class="radio" type="radio" name="settingsnew[jsstatus]" value="0" id="0" onclick="$Obj('hidden_settings_jsstatus').style.display = 'none';" <?php if($settings[jsstatus] == 0){echo 'checked';} ?>> 否</label>
            </td>
        </tr>
    <tbody>
    <tbody id="hidden_settings_jsstatus" style="background-color:white; <?php if($settings[jsstatus] == 0){echo 'display:none;';}?>">
    <tr>
        <td width="45%" class="altbg1" ><b>数据调用缓存时间(秒):</b><br /><span class="smalltxt">由于一些排序检索操作比较耗费资源，数据调用程序采用缓存技术来实现数据的定期更新，默认值 1800，建议设置为 900 的数值，0 为不缓存(极耗费系统资源)</span></td><td class="altbg2"><input type="text" size="50" name="settingsnew[jscachelife]" value="<?=$settings[jscachelife]?>" class="text">
        </td>
    </tr>
    <tr>
        <td width="45%" class="altbg1" ><b>外部调用数据日期格式:</b><br />
        <span class="smalltxt">使用 Y 表示年，m 表示月，d 表示天。如 Y/m/d 表示 2010/12/31</span></td><td class="altbg2"><input type="text" size="50" name="settingsnew[jsdateformat]" value="<?=$settings[jsdateformat]?>" class="text">
        </td>
    </tr>
    <tr>
        <td width="45%" class="altbg1" valign="top"><b>外部调用数据来路限制:</b><br /><span class="smalltxt">为了避免其它网站非法调用<?=$mymps_global['SiteName']?>数据，加重您的服务器负担，您可以设置允许调用<?=$mymps_global['SiteName']?>数据的来路域名列表，只有在列表中的域名和网站，才能调用您<?=$mymps_global['SiteName']?>的信息。每个域名一行，不支持通配符，请勿包含 http:// 或其它非域名内容，留空为不限制来路，即任何网站均可调用</span></td>
        <td class="altbg2"><textarea  rows="6" name="settingsnew[jsrefdomains]" id="settingsnew[jsrefdomains]" cols="50"><?php echo $settings[jsrefdomains]?></textarea></td></tr>
    </tbody>
</table>
</div>
<center><input class="mymps large" value="提 交" name="<?=CURSCRIPT?>_submit" type="submit"></center>
</form>
<?php mymps_admin_tpl_global_foot();?>