function StoreCommentFormCheck(){
	if (document.StoreCommentForm.content.value=="") {
		alert('评价/留言内容不能为空！');
		document.StoreCommentForm.content.focus();
		return false;
	}
	return true;
}