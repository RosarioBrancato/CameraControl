var URL_HOME = 'http://localhost:84/github/cam-ctrl/';
var URL_DEFAULT_IMG = 'http://localhost:84/github/cam-ctrl/image/default.png';

//var URL_HOME = 'http://localhost/cam-ctrl/';
//var URL_DEFAULT_IMG = 'http://localhost/cam-ctrl/image/default.png';
var URL_CAM = 'http://10.142.126.233/cgi-bin/camctrl.cgi';

window.setInterval(function() { 
	$.ajax({
		url: URL_HOME + 'image_getter.php',
		type: 'get',
		dataType: 'json',
		success: function(data) {
			var time = new Date();
			$('#cam_view').attr('src', data.path + '?' + time.getTime());
			//alert('success: ' + data);
		},
		error: function(xhr, status, error) {
			$('#cam_view').attr('src', URL_DEFAULT_IMG);
			alert('failed: ' + error);
		}
	});
}, 1000);

$('.home').click(function() {
	$.get(URL_CAM + '?move=home');
});

$('.left').click(function() {
	$.get(URL_CAM + '?move=left');
});

$('.right').click(function() {
	$.get(URL_CAM + '?move=right');
});

$('.up').click(function() {
	$.get(URL_CAM + '?move=up');
});

$('.down').click(function() {
	$.get(URL_CAM + '?move=down');
});

$('.set_speedpan').click(function() {
	var speed = $('.speedpan').val();
	$.get(URL_CAM + '?speedpan=' + speed);
});