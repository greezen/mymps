<?php include mymps_tpl('inc_head');?>
<div id="<?=MPS_SOFTNAME?>" style="padding-bottom:0">
	<div class="mpstopic-category">
		<div class="panel-tab">
			<ul class="clearfix tab-list">
				<li><a href="config.php?part=imgcode" <?php if($part == 'imgcode'){?>class="current"<?php }?>>验证码控制</a></li>
				<li><a href="config.php?part=checkask" <?php if($part == 'checkask'){?>class="current"<?php }?>>验证问答设置</a></li>
				<li><a href="config.php?part=badwords" <?php if($part == 'badwords'){?>class="current"<?php }?>>过滤设置</a></li>
				<li><a href="config.php?part=commentsettings" <?php if($part == 'commentsettings'){?>class="current"<?php }?>>评论点评设置</a></li>
			</ul>
		</div>
	</div>
</div>
<form action="?part=badwords" method="post" name="form1">
  <input name="action" value="dopost" type="hidden"/>
  <div id="<?=MPS_SOFTNAME?>">
    <table border="0" cellspacing="0" cellpadding="0" class="vbm">
      <tr class="firstr">
        <td colspan="5">
          <a name="#禁止词语过滤设置"></a>
          <div class="left">
            <a href="javascript:collapse_change('10')">脏话，禁止词语过滤设置</a></div>
            <div class="right"><a href="javascript:collapse_change('10')"><img id="menuimg_10" src="template/images/menu_reduce.gif"/></a></div>
          </td>
        </tr>
        <tbody id="menu_10" style="display:">
          <tr bgcolor="#f5fbff" >
            <td style="width:100px; line-height:22px">
              信息中禁止出现的词语，用","分开 </td>
              <td colspan="2">
                <textarea name="cfg_badwords0" style=" width:350px; height:120px"><?=$filter[words]?></textarea>
              </td>

            </tr>
            <tr bgcolor="#f5fbff" >
             <td style="width:100px; line-height:22px">
              禁止词语的替代词语
            </td>
            <td colspan="2">
             <input name="cfg_badwords1" value="<?=$filter[view]?>" class="text" type="text"/>
           </td>
         </tr>
         <tr bgcolor="#f5fbff" >
           <td style="width:35%; line-height:22px">
            当出现违禁词语时，是否自动转为待审核状态<br />（包括分类信息、分类信息评论、网站留言等等）<br />
            <i style="color:red">注意：该设置在您关闭了信息审核和评论审核的功能下生效 </i>     </td>
            <td colspan="2">
              <select name="cfg_badwords2" />
              <option value="1" <?php if($filter[ifcheck] == 1){?>style='background-color:#6EB00C;color:white' selected<?}?>>是/开启</option>
              <option value="0" <?php if($filter[ifcheck] == 0){?>style='background-color:#6EB00C;color:white' selected<?}?>>否/关闭</option>
            </select>
          </td> 
        </tr>
      </tbody>
    </table>
  </div>
  <center>
    <input class="mymps large" value="提 交" type="submit" > 
  </center>
</form>
<?php mymps_admin_tpl_global_foot();?>