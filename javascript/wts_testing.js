//WINDOW TASK SCHEDULER TESTING

//Create new panorama picture
$('.create_panorama').click(function() {
	$.get(URL_HOME + 'file_control.php', { task : 'create_panorama' });
	$('#feedback').html('Done!').stop(true, true).show().fadeOut(1000);
});

//Move current panorama picture to the archive
$('.move_to_archive').click(function() {
	$.get(URL_HOME + 'file_control.php', { task : 'move_to_archive' });
	$('#feedback').html('Done!').stop(true, true).show().fadeOut(1000);
});

//Delete pictures in the archive, which are older than 2 weeks.
$('.clean_archive').click(function() {
	$.get(URL_HOME + 'file_control.php', { task : 'clean_archive' });
	$('#feedback').html('Done!').stop(true, true).show().fadeOut(1000);
});