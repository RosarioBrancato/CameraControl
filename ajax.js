var URL = 'http://localhost:84/github/cam-ctrl/';
var URL_DEFAULT_IMG = 'http://localhost:84/github/cam-ctrl/image/default.png';

//var URL = 'http://localhost/cam-ctrl/';
//var URL_DEFAULT_IMG = 'http://localhost/cam-ctrl/image/default.png';

window.setInterval(function() { 
	$.ajax({
		url: URL + 'image_getter.php',
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
	$.get('http://10.142.126.233/cgi-bin/camctrl.cgi?move=home');
});

$('.left').click(function() {
	$.get('http://10.142.126.233/cgi-bin/camctrl.cgi?move=left');
});

$('.right').click(function() {
	$.get('http://10.142.126.233/cgi-bin/camctrl.cgi?move=right');
});

$('.up').click(function() {
	$.get('http://10.142.126.233/cgi-bin/camctrl.cgi?move=up');
});

$('.down').click(function() {
	$.get('http://10.142.126.233/cgi-bin/camctrl.cgi?move=right');
});