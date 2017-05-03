<tr class="firstr"> 
      <td>进行状态： </td>
      <td style="text-align:right"><font style="font-weight:100">若未看到进行状态，请点击增大按钮→</font> 
	  <script language='javascript'>
		function ResizeDiv(obj,ty)
		{
			if(ty=="+") document.all[obj].style.pixelHeight += 50;
			else if(document.all[obj].style.pixelHeight>80) document.all[obj].style.pixelHeight = document.all[obj].style.pixelHeight - 50;
		}
      </script>
        [<a href="javascript:ResizeDiv('mdv','+');">增大</a>] [<a href="javascript:ResizeDiv('mdv','-');">缩小</a>]      </td>
  </tr>
  <tr bgcolor="#FFFFFF"> 
    <td colspan="2" id="mtd">
    <div id='mdv' style='width:100%;height:400px;'> 
        <iframe name="stafrm" frameborder="0" id="stafrm" width="100%" height="100%" onload='stafrm.document.body.scrollTop=stafrm.document.body.scrollHeight'></iframe>
      </div>
      <script language="JavaScript">
	  document.all.mdv.style.pixelHeight = screen.height - 510;
	  </script>
       </td>
  </tr>