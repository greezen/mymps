function show_tab(id)
{
	$("li[name='s8']").attr('class','');
	$("#s8_"+id).attr('class','selected');
	$("#desc>ul").hide();
	$("#"+id).show();
}