var URL = 'http://localhost:84/github/cam-ctrl/';
var URL_DEFAULT_IMG = 'http://localhost:84/github/cam-ctrl/image/default.png';

window.setInterval(function() { 
	$.ajax({
		url: URL + 'image_getter.php',
		type: 'get',
		dataType: 'json',
		success: function(data) {
			$('#cam_view').attr('src', data.path);
			//alert('success: ' + data);
		},
		error: function(xhr, status, error) {
			$('#cam_view').attr('src', URL_DEFAULT_IMG);
			alert('failed: ' + error);
		}
	});
}, 1000);