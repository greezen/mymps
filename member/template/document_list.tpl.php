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
        <h3 class="ptitle"><span>商铺文章</span></h3>
        <p class="pextra addwebsite"><a href="?m=document&ac=new&tid=<?=$tid?>&type=corp"><span>发布<?=$documenttype[$tid]['typename']?></span></a></p>
    </div></div></div>
    <div class="pbody">

        <div class="cleafix pagetab-wrap">
            <ul class="pagetab">
            <?php foreach($documenttype as $key => $val){?>
                <li><a href="?m=document&tid=<?=$val['typeid']?>&type=corp" <?php if($tid == $val['typeid']){?>class="current"<?php }?>><span><?=$val['typename']?></span></a></li>
            <?php }?>
            </ul>
        </div>
		<div id="msg_success"></div>
<div id="msg_error"></div>
<div id="msg_alert"></div>
        <form method="post" action="?m=<?=$m?>&tid=<?=$tid?>&page=<?=$page?>">
        <div class="datatablewrap">
            <table class="datatable">
                <thead>
                    <tr>
                        <td>
                            <input class="checkall" name="checkall" type="checkbox" id="checkall" onClick="CheckAll(this.form)"/>
                        </td>
                        <td>标题</td>
                        <td>作者</td>
			            <td>来源</td>
                        <td>状态</td>
                        <td>发布时间</td>
                        <td>详情</td>
                    </tr>
                </thead>
                <tbody>
                <?php if($rows_num == 0 ){?>
                    <tr>
                        <td colspan="6">
                        <div class="nodata">您尚未添加<?=$documenttype[$tid]['typename']?></div>
                        </td>
                    </tr>
                <?php } else {
                $i = 1;
                foreach($document as $d){
                ?>
                	<tr <?php if($i%2 == 0) echo 'class="row-even"'?>>
                        <td><input class="checkbox" type='checkbox' name='selectedids[]' value='<?=$d[id]?>' id="<?=$d[id]?>'"></td>
                        <td width="190">
                        <a href="../store.php?uid=<?=$uid?>&part=document&id=<?=$d['id']?>" target="_blank" title="<?=$d['title']?>"><?=substring($d['title'],0,30)?></a>
                        <?php if($d['imgpath']) echo '<span class="imgnum">图</span>'?>
                        </td>
                        <td>
                        <?=$d['author']?>
                        </td>
                        <td>
                        <?=$d['source']?>
                        </td>
                        <td>
                        <?=$ifcheck_arr[$d['if_check']]?>
                        </td>
                        <td>
                        <?=GetTime($d['pubtime'])?>
                        </td>
                        <td>
                        <a href="?m=document&ac=edit&id=<?=$d['id']?>&type=corp">编辑</a>
                        </td>
                    </tr>
                <?php 
                	$i++;
                    }
                    unset($i);
                }
                ?>
                </tbody>
            </table>
            <div class="clearfix datacontrol">
                <div class="dataaction">
                    <span class="minbtn-wrap"><span class="btn"><input type="submit" value="删除" class="button" name="document_submit" onClick="if(!confirm('您确定要删除这些<?=$documenttype[$tid]['typename']?>吗?一旦删除将不可恢复'))return false;"/></span></span> 
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