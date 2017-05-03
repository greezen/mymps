<?php include mymps_tpl('inc_head');?>
<script type="text/javascript" src="js/vbm.js"></script>
<style>
.ccc2 ul input{margin:2px 0}
</style>
<div id="<?=MPS_SOFTNAME?>" style=" padding-bottom:0">
    <div class="mpstopic-category">
        <div class="panel-tab">
            <ul class="clearfix tab-list">
                <?=get_mymps_config_menu()?>
            </ul>
        </div>
    </div>
</div>
<form action="?part=update" method="post" name="form1">
<?=get_mymps_config_input()?>
<div align="center" style="margin:15px;">
<input class="mymps mini" value="±£´æÉèÖÃ" type="submit" > 
<input type="button" onClick="history.back()"value="·µ»Ø" class="mymps mini">
</div>
</form>
<?php mymps_admin_tpl_global_foot();?>