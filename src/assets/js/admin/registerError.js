document.addEventListener('DOMContentLoaded',()=>{

	var url = new URL(location.href);
	url.searchParams.set('uer-error','celebrities');
	location.href=url.href

});