/* 彭彭滚动组件1.0 2007年11月1日 作者：彭成刚 网站：http://www.zzcn.net/ QQ:76526211 */
/*
组件注意地方：滚动的部分高度或宽度要高于滚动框架的高度或宽度。调用方式放在Html架构代码下方。
关于w_demo的问题，由于横向滚动的时候需要调整整体的宽度，所以要多套一层框架。
<script language="JavaScript" type="text/javascript" src="ppRoll.js"></script>
Html架构代码：
(上下）
<div id="demo">
	<div id="demo1">
	滚动主题
	</div>
	<div id="demo2">
	</div>
</div>
（左右）
<div id="demo">
<table border=0 cellspacing=0 cellpadding=0>
    <tr>
      <td id="demo1">滚动内容(注意横向滚动内容的东西里一定要有宽度，比如嵌入一table，一定要让它有宽度)</td>
      <td id="demo2"></td>
    </tr>
  </table>
</div>



//调用方式
<script type="text/javascript">
var ppRoll = new ppRoll({
					speed:60, 		//速度
					demo:"demo",	//外框架div
					demo1:"demo1",	//滚动主体div
					demo2:"demo2",	//复制的div
					objStr:"ppRoll",	//创建的对象名
					width:"192px",	//外框架demo的宽度
					height:"360px",	//外框架demo的高度
					direction:"top"	//滚动方向，可选值：top、down、left、right
					});
</script>
*/
function ppRoll(a)
{
	this.myA = a;
	this.myA.IsPlay = 1;
	this.$(a.demo).style.overflow = "hidden";
	this.$(a.demo).style.width = a.width;
	this.$(a.demo).style.height = a.height;
	this.$(a.demo2).innerHTML=this.$(a.demo1).innerHTML;
	this.$(a.demo).scrollTop=this.$(a.demo).scrollHeight;
	this.Marquee();
	this.$(a.demo).onmouseover=function() {eval(a.objStr+".clearIntervalpp();");}
	this.$(a.demo).onmouseout=function() {eval(a.objStr+".setTimeoutpp();")}
}
ppRoll.prototype.$ = function(Id)
{
	return document.getElementById(Id);
}
ppRoll.prototype.getV = function(){ 
alert(this.$(this.myA.demo2).offsetWidth-this.$(this.myA.demo).scrollLeft);
alert(this.$(this.myA.demo2).offsetWidth);
alert(this.$(this.myA.demo).scrollLeft);}
ppRoll.prototype.Marquee = function()
{
	this.MyMar=setTimeout(this.myA.objStr+".Marquee();",this.myA.speed);
	if(this.myA.IsPlay == 1)
	{
		//向上滚动
		if(this.myA.direction == "top")
		{
			if(this.$(this.myA.demo).scrollTop>=this.$(this.myA.demo2).offsetHeight)
				this.$(this.myA.demo).scrollTop-=this.$(this.myA.demo2).offsetHeight;
			else{
				this.$(this.myA.demo).scrollTop++;
			}
		}
		
		//向下滚动
		if(this.myA.direction == "down")
		{
			if(this.$(this.myA.demo1).offsetTop-this.$(this.myA.demo).scrollTop>=0)
				this.$(this.myA.demo).scrollTop+=this.$(this.myA.demo2).offsetHeight;
			else{
				this.$(this.myA.demo).scrollTop--;
			}
		}
		
		//向左滚动
		if(this.myA.direction == "left")
		{
			if(this.$(this.myA.demo2).offsetWidth-this.$(this.myA.demo).scrollLeft<=0)
				this.$(this.myA.demo).scrollLeft-=this.$(this.myA.demo1).offsetWidth;
			else{
				this.$(this.myA.demo).scrollLeft++;
			}
		}
		
		//向右滚动
		if(this.myA.direction == "right")
		{
			if(this.$(this.myA.demo).scrollLeft<=0)
				this.$(this.myA.demo).scrollLeft+=this.$(this.myA.demo2).offsetWidth;
			else{
				this.$(this.myA.demo).scrollLeft--;
			}
		}

	}
}
ppRoll.prototype.clearIntervalpp = function()
{
	this.myA.IsPlay = 0;
}
ppRoll.prototype.setTimeoutpp = function()
{
	this.myA.IsPlay = 1;
}
