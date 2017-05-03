<script type="text/javascript" src="<?=$mymps_global[SiteUrl]?>/template/default/js/jquery.autocomplete.min.js"></script> 
<link rel="stylesheet" href="<?=$mymps_global[SiteUrl]?>/template/default/css/jquery.autocomplete.css" />
<script type="text/javascript"> 
var cities = [
<? $i=1;if(is_array($allcities = get_allcities()))foreach($allcities as $k =>$v){?>
<? if($i > 1) echo ',';?>{ name1: "<?=$v[cityid]?>",name: "<?=$v[directory]?>", to: "<?=$v[cityname]?>" }
<? $i=$i+1;}?>
];
$(function() {
$('#cityid').autocomplete(cities, {
max: 400, //列表里的条目数 
minChars: 0, //自动完成激活之前填入的最小字符 
width: 166, //提示的宽度，溢出隐藏 
scrollHeight: 300, //提示的高度，溢出显示滚动条 
matchContains: true, //包含匹配，就是data参数里的数据，是否只要包含文本框里的数据就显示 
autoFill: false, //自动填充 
formatItem: function(row, i, max) { 
return row.to; 
}, 
formatMatch: function(row, i, max) { 
return row.name1 + row.name + row.to; 
}, 
formatResult: function(row) { 
return row.name1; 
} 
});
});
</script>