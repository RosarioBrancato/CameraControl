$('#nav_admin').click(function(event) {
	//highlight navigation point
	/*$('#nav_panorama').removeClass('selected');
	$('#nav_archive').removeClass('selected');
	$('#nav_admin').addClass('selected');
	
	//insert html
	$('#main_content').html('').append(getArchiveHtmlRow('', '', URL_DEFAULT_IMG));*/
	
	window.open(URL_HOME + 'control_panel.html', '_blank', 'height=600,width=1000');
});