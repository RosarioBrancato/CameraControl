//WINDOW TASK SCHEDULER SIMULATOR

//Create new panorama picture
window.setInterval(function() {
	$.get(URL_HOME + 'file_control.php', { task : 'create_panorama' });
}, 60000); //1 min

//Move current panorama picture to the archive
window.setInterval(function() { 
	$.get(URL_HOME + 'file_control.php', { task : 'move_to_archive' });
}, 900000); //15 min

//Delete pictures in the archive, which are older than 2 weeks.
window.setInterval(function() { 
	$.get(URL_HOME + 'file_control.php', { task : 'clean_archive' });
}, 1209600000); //24 hours