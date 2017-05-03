<?php include mymps_tpl('inc_header'); ?>
<link rel="stylesheet" type="text/css" href="template/css/new.exchange.css" />
<script language="javascript" src="template/javascript.js"></script>

</head>
<body class="<?php echo $mymps_global['cfg_tpl_dir']; ?>">
<div class="container">

	<?php include mymps_tpl('inc_head'); ?>
    <div id="main" class="main section-setting">
        <div class="clearfix main-inner">
            <div class="content">
                <div class="clearfix content-inner">
                    <div class="content-main">
                        <div class="content-main-inner">
                            
                            <div class="pwrap">
    <div class="phead"><div class="phead-inner"><div class="phead-inner">
        <h3 class="ptitle"><span>我的收藏</span></h3>

    </div></div></div>
    <div class="pbody">

        <div id="msg_success"></div>
        <div id="msg_error"></div>
		<div id="msg_alert"></div>
        <form method="post" action="?m=<?=$m?>&l=<?=$l?>&page=<?=$page?>" name="form1">
        <input id="ac" name="ac" value="" type="hidden">
        <div class="datatablewrap">
            <table class="datatable">
                    <thead>
                        <tr>
                            <td width="50">&nbsp;<input class="checkall" name="checkall" type="checkbox" id="checkall" onClick="CheckAll(this.form)"/></td>
                            <td width="400">收藏的主题</td>
                            <td>收藏的时间</td>
                            <td>操作</td>
                        </tr>
                    </thead>
                    <tbody>
                    <?php 
                    if($rows_num > 0){
                    $i=1; 
                    foreach($list as $art){
                    ?>
                    <tr <?php if($i%2 == 0) echo 'class="row-even"'?>>
                    	<td>&nbsp;<input class="checkbox" type='checkbox' name='selectedids[]' value='<?=$art[id]?>' id="<?=$art[id]?>'"></td>
                            <td>
                            <a href="<?=$art['url']?>" target="_blank" style="float:left;" title="<?=$art['title']?>"><?=$art['title']?></a></td>
                            <td><?=$art['intime']?></td>
                            <td><a href="?m=shoucang&ac=delthis&id=<?=$art[id]?>" onClick="if(!confirm('您确定要删除这个收藏吗?一旦删除将不可恢复'))return false;">删除</a></td>
                    </tr>
                    <?php 
                    	$i=$i+1;
                   	 }
                    } else {
                    ?>
                   <tr>
                        <td height="15" colspan="10">
                            <div class="nodata">没有记录</div>
                        </td>
                    </tr>
                    <?}?>
                    </tbody>
                </table>
            <div class="clearfix datacontrol">
                <div class="dataaction">
                    <span class="minbtn-wrap"><span class="btn"><input type="button" value="删除" class="button" onClick="if(!confirm('您确定要删除这些收藏主题吗?一旦删除将不可恢复'))return false; $('ac').value = 'del'; document.form1.submit();"/></span></span> 
                </div>
                <div class="pagination"><?php echo page2(); ?></div>
            </div>
        </div>
        </form>

    </div>
    <div class="pfoot"><p><b>-</b></p></div>
</div>
                                
                        </div>
                    </div>
                </div>
            </div>
            <?php include mymps_tpl('inc_sidebar'); ?>
        </div>
    </div>
	<?php include mymps_tpl('inc_foot'); ?>
    
</div>
</body>
</html>