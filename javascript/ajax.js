window.setInterval(function() {
	/*$.ajax({
		url: URL_HOME + 'file_control.php',
		type: 'get',
		data: { panorama: "panorama"},
		dataType: 'json',
		success: function(data) {
			if(data.path.length > 0) {
				$('#cam_view').attr('src', data.path);
				//alert('success: ' + data);
			}
		},
		error: function(xhr, status, error) {
			$('#cam_view').attr('src', URL_DEFAULT_IMG);
			//alert('failed: ' + error);
		}
	});*/
	
	d = new Date();
	$("#cam_view").attr("src", URL_CAM_SNAPSHOT + d.getTime());
	
}, 1000);

$('.home').click(function() {
	$.get(URL_CAM + '?move=home');
	$('#feedback').html('Done!').stop(true, true).show().fadeOut(1000);
});

$('.left').click(function() {
	$.get(URL_CAM + '?move=left');
	$('#feedback').html('Done!').stop(true, true).show().fadeOut(1000);
});

$('.right').click(function() {
	$.get(URL_CAM + '?move=right');
	$('#feedback').html('Done!').stop(true, true).show().fadeOut(1000);
});

$('.up').click(function() {
	$.get(URL_CAM + '?move=up');
	$('#feedback').html('Done!').stop(true, true).show().fadeOut(1000);
});

$('.down').click(function() {
	$.get(URL_CAM + '?move=down');
	$('#feedback').html('Done!').stop(true, true).show().fadeOut(1000);
});

$('.set_speedpan').click(function() {
	var speed = $('.speedpan').val();
	$.get(URL_CAM + '?speedpan=' + speed);
	$('#feedback').html('Done!').stop(true, true).show().fadeOut(1000);
});