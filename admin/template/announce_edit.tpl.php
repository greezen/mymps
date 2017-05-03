<?php include mymps_tpl('inc_head_jq');?>
<script type="text/javascript" src="../include/datepicker/datepicker.js"></script>
<link rel="stylesheet" href="../include/datepicker/ui.css">
<script language='javascript'>
  $(function(){
   $("#datepicker1").datepicker();
   $("#datepicker2").datepicker();
 });
  function CheckSubmit()
  {
   if(document.form1.title.value=="")
   {
     document.form1.title.focus();
     alert("请填写公告标题！");
     return false;
   }
   if(document.form1.author.value=="")
   {
     document.form1.author.focus();
     alert("请填写作者！");
     return false;
   }

   return true;
 }
</script>
<form method=post  name="form1" action="announce.php?part=edit" onSubmit="return CheckSubmit();">
  <input name="id" value="<?=$edit[id]?>" type="hidden" />
  <input name="action" value="dopost" type="hidden" />
  <div id="<?=MPS_SOFTNAME?>">
    <table border="0" cellspacing="0" cellpadding="0" class="vbm">

      <tr class="firstr">
        <td colspan="2"><b>编辑网站公告</b></td>
      </tr>
      <?php if(!$admin_cityid){?>
      <tr bgcolor="#f5fbff">
        <td align="right">隶属分站：</td>
        <td>
          <select name="cityid">
            <option value="0">总站</option>
            <?php echo get_cityoptions($edit[cityid]); ?>
          </select>
        </td>
      </tr>
      <?}else{?>
      <input name="cityid" type="hidden" value="<?php echo $admin_cityid; ?>">
      <?php }?> 
      <tr bgcolor="#f5fbff" >
        <td width="12%" align="right">公告标题： </td>
        <td colspan="3"> <input name="title" class="text" type="text" value="<?=$edit[title]?>" size="50"> 
          <select name="titlecolor">
            <option value="">默认标题颜色</option>
            <?php echo get_color_options($edit['titlecolor']);?>
          </select><font color="red">*</font></td>
        </tr>
        <tr bgcolor="#f5fbff" >
          <td width="12%" align="right">开始时间：</td>
          <td><input id="datepicker1" readonly="readonly" name="begintime" class="text" type="text" value="<?=GetTime($edit[begintime])?>"/> 无开始时间请留空</td>
        </tr>
        <tr bgcolor="#f5fbff" >
          <td width="12%" align="right">截止时间：</td>
          <td><input id="datepicker2" readonly="readonly" name="endtime" class="text" type="text" value="<?=GetTime($edit[endtime])?>"/> 无截止时间请留空</td>
        </tr>
        <tr bgcolor="#f5fbff" >
          <td width="12%" align="right">跳转地址：</td>
          <td>
            <input name="redirecturl" class="text" type="text" value="<?=$edit[redirecturl]?>" size="50"> 若填写了此处，以下部分则不需填写
          </td>
        </tr>
        <tr bgcolor="#f5fbff" >
          <td width="12%" align="right">作者：</td>
          <td><input name="author" class="text" type="text" style="width:100px" value="<?=$edit[author]?>"><font color="red">*</font></td>
        </tr>
      </table>
      <div style="margin-top:3px;">
        <?php echo $acontent?>
      </div>
    </div>
    <center><input type="submit" value="提 交" class="mymps large"/></center>
  </form>
  <?php mymps_admin_tpl_global_foot();?>