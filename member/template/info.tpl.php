<?php include mymps_tpl('inc_header');?>
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
        <h3 class="ptitle"><span>我发布的分类信息</span></h3>
        <p class="pextra addwebsite"><a href="<?php echo (!$row['tel'] && !$row['qq']) ? '?m=base&error=41' : '../'.$mymps_global['cfg_postfile'].'?cityid='.$cityid; ?>"><span>发布分类信息</span></a></p>
    </div></div></div>
    <div class="pbody">

        <div class="cleafix pagetab-wrap">
            <ul class="pagetab">                                                             
                <li><a href="?m=info&l=normal" <?php if($l == 'normal'){?>class="current"<?php }?>><span>我发布的信息</span></a></li>
                <li><a href="?m=info&l=inormal" <?php if($l == 'inormal'){?>class="current"<?php }?>><span>审核中的信息</span></a></li>
				<li><a href="?m=info&l=tuiguang" <?php if($l == 'tuiguang'){?>class="current"<?php }?>><span>推广中的信息</span></a></li>
            </ul>
        </div>
        <div id="msg_success"></div>
        <div id="msg_error"></div>
		<div id="msg_alert"></div>
        <form method="post" action="?m=<?=$m?>&l=<?=$l?>&page=<?=$page?>" name="form1">
        <div class="datatablewrap">
			<div class="xinxi-guanli-box">
				<?php 
				if($rows_num > 0){
				$i=1; 
				foreach($list as $art){
				?>
				<table width="100%" border="0" cellspacing="0" cellpadding="0" class="xinfabu prico">
	  <tr class="xintit">
	    <td colspan="3">
			<span class="czfr"><?php if($art['info_level'] > 0){?><a href="<?php echo $mymps_global['cfg_postfile'] ? '../'.$mymps_global['cfg_postfile'] : '../post.php'?>?action=edit&id=<?=$art[id]?>" target="_blank">修改</a> | <?php }?>
			<a href="?m=info&ac=del&id=<?php echo $art['id']; ?>&l=<?php echo $l;?>&page=<?php echo $page;?>" onClick="if(!confirm('您确定要删除这条信息吗?一旦删除将不可恢复'))return false;">删除</a>
			</span>
 		   	<span class="xthpic"></span>
	    	<span>发布时间:<?php echo $art['begintime'];?></span>
			<span><?php echo get_info_life_time($art['endtime']); ?></span>
	    	<span>编号:<?php echo $art['id']; ?></span>
	    	<span>浏览 <?php echo $art['hit']?> 次</span>
			</td>
		  </tr>
          <tr>
            <td class="t">
            	<div class="title">
	            	<a href="<?=$art['uri']?>" target="_blank" class="img">
	            		<img src="<?php echo $art['img_path'] ? $art['img_path'] : '../images/nophoto.gif'?>" />
	            	</a>
	            	<a style=" font-weight:bold" title="<?=$art['title']?>" href="<?=$art['uri']?>" target="_blank" style="float:left;"><?=cutstr($art['title'],40)?></a><br><?=cutstr($art['content'],40)?><br> <?php if(mgetcookie('refreshed'.$art['id']) == 1) echo '<span class="refreshed">已刷新</span>'; ?> <?php if($art['ifred'] == 1) echo '<span class="fred">已套红</span>'; ?> <?php if($art['ifbold'] == 1) echo '<span class="fbold">已加粗</span>'; ?>
	           	 	<p class="txq"><a target='_blank' href='<?php echo $art[uri_cat]?>' class="a_xq1"><?php echo $art['catname']?></a></p>
           	 	</div>
            </td>
            <td>
			<?php if($art['info_level'] < 1){?>
			<span class="examine"></span><b class="f14 red_f6">审核中</b><br />
			<p class="xsitxt">审核通过后即可自动正常显示，如不放心可稍后回来再看一下。</p>
			<?}elseif($art['endtime'] < $timestamp && $art['endtime'] && $mymps_global['cfg_info_if_gq'] != 1){?>
			<span class="examine"></span><b class="f14 red_f6">显示中</b><br />
			<p class="xsitxt" >信息联系方式关闭，可使用刷新功能重新发布。</p>
			<?php }else{?>
			<span class="xianshi"></span><b class="f14 green">显示中</b><br />
			
			<?php if($art['upgrade_type_index']){?>
			<span class="examine"></span><b class="f14 red_f6">首页置顶<?php if($art['upgrade_time_index'] != 0){ echo '至'.date("Y-m-d",$art['upgrade_time_index']);}?></b><br /><?php }?>
			
			<?php if($art['upgrade_type']){?>
			<span class="examine"></span><b class="f14 red_f6">大类置顶<?php if($art['upgrade_time'] != 0){ echo '至'.date("Y-m-d",$art['upgrade_time']);}?></b><br /><?php }?>
			
			<?php if($art['upgrade_type_list']){?>
			<span class="examine"></span><b class="f14 red_f6">小类置顶<?php if($art['upgrade_time_list'] != 0){ echo '至'.date("Y-m-d",$art['upgrade_time_list']);}?></b><br /><?php }?>
			
			<?php }?>
			</td>
   			 <td class="w1">
			 <?php if($art['info_level'] > 0){?>
			 <span class="refresh">
			 <a  <?php if(mgetcookie('refreshed'.$art['id']) != 1){ ?> onClick="<?php if($mymps_global['cfg_member_info_refresh']>0){?>if(!confirm('您当前拥有金币<?php echo $money_own; ?>个，刷新该信息将扣除您<?php echo $mymps_global['cfg_member_info_refresh']; ?>个金币'))return false;<? }?>" <?php }else{?> onClick="alert('该信息已被刷新过了，不能重复刷新。');return false;" <?php }?> title='刷新后信息靠前显示，相当于新发一条。' href="?m=info&ac=refresh&id=<?=$art[id]?>">刷新</a>
			 </span>
			 <span class="extension" >
			 <a <?php if($art['ifbold'] == 1){?>onClick="alert('该信息的信息标题已被加粗过了，不能重复加粗。');return false;"<?php }else{?> onClick="if(!confirm('您当前拥有金币<?php echo $money_own; ?>个，套红该信息标题将扣除您<?php echo $mymps_global['cfg_member_info_bold']; ?>个金币'))return false;" <?php }?>href="?m=info&ac=bold&id=<?=$art[id]?>&page=<?=$page?>">加粗</a>
	</span><br />	
	<span class="sticky" >
		<a href="?m=info&ac=upgrade&id=<?=$art[id]?>">置顶</a>
	</span>
	<span class="extension precision" >
		<a class="on" <?php if($art['ifred'] == 1){?>onClick="alert('该信息的信息标题已被套红过了，不能重复套红。');return false;"<?php }else{?>onClick="if(!confirm('您当前拥有金币<?php echo $money_own; ?>个，套红该信息标题将扣除您<?php echo $mymps_global['cfg_member_info_red']; ?>个金币'))return false;"<?php }?> href="?m=info&ac=red&id=<?=$art[id]?>&page=<?=$page?>">套红</a>
	</span>	
		  <?php }?>
		  </td>
          </tr>
          <tr class="infotdno">
          	<td colspan="3">
               
            </td>
          </tr>
	      </table>     
		  		<?php 
				}}
				?>
				 
			</div>				
			<?php if($rows_num > 0){?>
            <div class="clearfix datacontrol">
                <div class="dataaction">
                </div>
                <div class="pagination"><?php echo page2(); ?></div>
            </div>
			<?php }else{?>
			<div class="nodata">暂无记录</div>
			<?php }?>
        </div>
        </form>

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