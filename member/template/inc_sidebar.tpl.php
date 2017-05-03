<?php if($box != 1){?>
<div class="sidebar">
    <div class="sidebar-inner">
        <div class="sidebarmenu">
            <div class="sidebarmenu-inner">
                <div class="sidebarmenu-list">
                    <ul class="faceview">
                    	<div class="img"><img src="<?php echo $mymps_global['SiteUrl'].($face != '' ? $face : '/images/noavatar_small.gif')?>" alt="" width="66" height="66" /></div><?php echo $s_uid; ?>
                    </ul>
                    <ul class="index">
                    	<li <?php if($m != 'index'){?>onmouseover= "this.className= 'li_mouseover '; " onmouseout= "this.className= 'li_normal '; " <?php } if($m == 'index') echo 'class="current"';?>><a href="?type=<?php echo $type; ?>" class="house">首页</a></li>
                    </ul>
                        <?php 
                        if($if_corp != 1 || $type == 'user') unset($member_menu['corp']);
						if($type == 'corp') unset($member_menu['user']);
                        foreach($member_menu as $key => $val){
                        	echo '<ul>';
                        	foreach($member_menu[$key] as $k => $v)
                            {
                        ?>
                        	<li <?php if($m != $k){?>onmouseover= "this.className= 'li_mouseover '; " onmouseout= "this.className= 'li_normal '; " <?php } if($m == $k) echo 'class="current"'; ?>>
                            <a class="<?php echo $k; ?>" href="index.php?m=<?php echo $k; ?>&type=<?php echo $key; ?>"><?php echo $v; ?></a>
                            </li>
                        <?php 
                        	}
                            echo '</ul>';
                        }
                        ?>
                </div>
				<?php if($if_corp != 1 && $mymps_global[cfg_if_corp] == 1){?><div style="margin-top:6px"><a href="index.php?m=shop" title="我是商户，申请开通商家管理平台"><img src="template/images/shop_apply.gif"></a></div>
				<?php }?>
            </div>
        </div>
    </div>
</div>
<?php }?>