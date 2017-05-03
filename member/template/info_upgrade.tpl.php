<?php include mymps_tpl('inc_header');?>
<style>.refreshed{ margin-left:5px;}</style>
<link rel="stylesheet" type="text/css" href="template/css/new.exchange.css" />
<script language="javascript" src="template/javascript.js"></script>

</head>
<body class="<?php echo $mymps_global['cfg_tpl_dir']; ?>">
<div class="container">

	<?php include mymps_tpl('inc_head');?>
    <div id="main" class="main section-setting">
        <div class="clearfix main-inner">
            <div class="content">
                <div class="clearfix content-inner">
                    <div class="content-main">
                        <div class="content-main-inner">
                            
                            <div class="pwrap">
    <div class="phead"><div class="phead-inner"><div class="phead-inner">
        <h3 class="ptitle"><span>置顶服务介绍</span></h3>
        <p class="pextra"><a href="?m=info"><span>&laquo; 返回分类信息列表</span></a></p>
    </div></div></div>
    <div class="pbody">
        <div id="msg_success"></div>
        <div id="msg_error"></div>
        <table>
		<tr>
			<td>
			<div class="upgradetd">
                <div class="introTitle"><span style="color:#F30;" class="t1">首页置顶</span><br>
<span class="t2">1天仅需<?=$mymps_global[cfg_member_upgrade_index_top]?>金币</span></div>
                <div class="t3">在网站<font color="#FF3300">首页最醒目位置</font>轮播展示您发布的信息,吸引全场眼球！</div>
            </div>
            </td>
			<td>
            <div class="upgradetd" style="margin-left:5px">
                <div class="introTitle"><span style="color:#369;" class="t1">大类置顶</span><br>
<span class="t2">1天仅需<?=$mymps_global[cfg_member_upgrade_top]?>金币</span></div>
                <div class="t3">显示在大类类目列表页面的<font color="#FF3300">最顶部位置</font>，吸引更多关注！</div>
            </div>
            </td>
			<td>
			<div class="upgradetd" style="margin-left:5px">
                <div class="introTitle"><span style="color:green;" class="t1">小类置顶</span><br>
<span class="t2">1天仅需<?=$mymps_global[cfg_member_upgrade_list_top]?>金币</span></div>
                <div class="t3">显示在小类类目列表页面的<font color="#FF3300">最顶部位置</font>，吸引更多关注！</div>
            </div>
            </td>
		</tr>
	</table>
        <form method="post" action="?m=<?=$m?>&l=<?=$l?>&page=<?=$page?>">
        <input type="hidden" name="id" value="<?=$id?>">
        <input type="hidden" name="catid" value="<?=$row['catid']?>">
        <input type="hidden" name="money_own" value="<?=$money_own?>">
        <input type="hidden" name="iftop" value="<?=$row['upgrade_type']?>">
		<input type="hidden" name="iflisttop" value="<?=$row['upgrade_type_list']?>">
        <input type="hidden" name="ifindextop" value="<?=$row['upgrade_type_index']?>">
        <input type="hidden" name="ac" value="actionupgrade">
        <div class="datatablewrap">
            <table class="datatable">
                    <thead>
                        <tr>
                            <td>推广我发布的信息</td>
                        </tr>
                    </thead>
                    <tbody>
                    <tr>
                            <td>
                            <a href="../information.php?id=<?=$id?>" target="_blank" style="float:left; font-weight:bold; line-height:22px"><?=$row['title']?></a> <?php if($row['upgrade_type'] == 2) echo '<span class="refreshed">大类置顶中</span>'; ?>  <?php if($row['upgrade_type_list'] == 2) echo '<span class="refreshed">小类置顶中</span>'; ?> <?php if($row['upgrade_type_index'] == 2) echo '<span class="refreshed">首页置顶中</span>'; ?>
							
							</td>
                    </tr>
                    <tr>
                      <td>
							<select name="upgrade_type" id="upgrade_type">
                                <option value="cfg_member_upgrade_top">大类置顶</option>
								<option value="cfg_member_upgrade_list_top">小类置顶</option>
                                <option value="cfg_member_upgrade_index_top">上首页</option>
                            </select></td>
                    </tr>
                    <tr>
                      <td><?=GetUpgradeTime()?></td>
                    </tr>
                    </tbody>
                </table>
        </div>
        <div class="clearfix current_action_money">您目前拥有金币<font color="red"><?=$money_own?></font>，将扣除您的金币：<span style="color:red"><font id="total">0</font></span></div>
        <div class="clearfix datacontrol">
                <div class="dataaction">
                    <span class="minbtn-wrap"><span class="btn"><input type="submit" value="确认提交置顶" class="button" name="actionupgrade" <?php if($row['upgrade_type'] == 2 && $row['upgrade_type_list'] == 2 && $row['upgrade_type_index'] == 2) echo 'disabled';?>></span></span> 
                </div>
            </div>
        </form>
		<script language="javascript">
            function calculate() 
            {
                var ID0=document.getElementById("upgrade_type").value; 
                var ID1=document.getElementById("upgrade_time").value; 
                var ID2=document.getElementById("total").value;
                if(ID0 == "cfg_member_upgrade_top"){
                    document.getElementById("total").innerHTML=(<?php echo $mymps_global[cfg_member_upgrade_top]?>*ID1);
                }else if(ID0 == "cfg_member_upgrade_list_top"){
                    document.getElementById("total").innerHTML=(<?php echo $mymps_global[cfg_member_upgrade_list_top]?>*ID1);
                }else{
                    document.getElementById("total").innerHTML=(<?php echo $mymps_global[cfg_member_upgrade_index_top]?>*ID1);
                }
                
                if(ID0==""||ID1=="") 
                ID2="";
                setTimeout("calculate()",30);
            } 
            calculate();
        </script>
    </div>
    <div class="pfoot"><p><b>-</b></p></div>
</div>
                                
                        </div>
                    </div>
                </div>
            </div>
            <?php include mymps_tpl('inc_sidebar');?>
        </div>
    </div>
	<?php include mymps_tpl('inc_foot');?>
    
</div>
</body>
</html>