//WTS TESTING

//Create new panorama picture
$('.create_panorama').click(function() {
	$.get(URL_HOME + 'file_control.php', { task : 'create_panorama' });
});

//Move current panorama picture to the archive
$('.move_to_archive').click(function() {
	$.get(URL_HOME + 'file_control.php', { task : 'move_to_archive' });
});

//Delete pictures in the archive, which are older than 2 weeks.
$('.clean_archive').click(function() {
	$.get(URL_HOME + 'file_control.php', { task : 'clean_archive' });
});