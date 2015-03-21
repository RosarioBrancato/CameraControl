$('#nav_panorama').click(function() {
	//highlight navigation point
	$('#nav_archive').removeClass('selected');
	$('#nav_admin').removeClass('selected');
	$('#nav_panorama').addClass('selected');
	
	//insert default html
	var html = '';
	html += '<div class="row">';
	html += '	<div class="box">';
	html += '		<div class="col-lg-12">';
	html += '			<img id="cam_view" class="img-rounded" src="' + URL_DEFAULT_IMG + '" alt="Camera View" />'
	html += '		</div>';
	html += '	</div>';
	html += '</div>';
	$('#main_content').html('').append(html);
			
	$.ajax({
		url: URL_HOME + 'file_control.php',
		type: 'get',
		data: { panorama: "panorama" },
		dataType: 'json',
		success: function(data) {
			//insert path to panorama picture
			if(data.path.length > 0) {
				$('#cam_view').attr('src', data.path);
			}
		},
		error: function(xhr, status, error) {
			$('#cam_view').attr('src', URL_DEFAULT_IMG);
			//alert('failed: ' + error);
		}
	});
});

$('#nav_archive').click(function() {
	//highlight navigation point
	$('#nav_panorama').removeClass('selected');
	$('#nav_admin').removeClass('selected');
	$('#nav_archive').addClass('selected');
	
	//insert html
	$('#main_content').html('').append(getArchiveHtmlRow('', '', URL_DEFAULT_IMG));
			
	$.ajax({
		url: URL_HOME + 'file_control.php',
		type: 'get',
		data: { load_archive: "load_archive" },
		dataType: 'json',
		success: function(data) {
			//insert html of pictures
			$('#main_content').html('');
			$.each(data, function(index, value) {
				$('#main_content').append(getArchiveHtmlRow(value.date, value.time, value.url));
			});
		},
		error: function(xhr, status, error) {
			alert('failed: ' + error);
		}
	});
});

$('#nav_admin').click(function() {
	//highlight navigation point
	$('#nav_panorama').removeClass('selected');
	$('#nav_archive').removeClass('selected');
	$('#nav_admin').addClass('selected');
	
	//insert html
	$('#main_content').html('').append(getArchiveHtmlRow('', '', URL_DEFAULT_IMG));
});

$(window).scroll(function()  {
	if($('#nav_archive').hasClass('selected')) {
		var height = $(window).height();
		var scrolled = $(window).scrollTop();
		var doc = $(document).height();
		
		if((scrolled + height) > (doc - 100)) {
			//alert('Almost through! Height: ' + height + ' Scrolled: ' + scrolled + ' Document: ' + doc);
		}
	}
});

function getArchiveHtmlRow(date, time, url) {
	var html = '';
	
	html += '<div class="row">';
    html += '	<div class="box">';
    html +=	'		<div class="col-lg-3 text-center">'
	html += ' 			<p class="archive-datetime">' + date + '</p>';
	html += ' 			<p class="archive-datetime">' + time + '</p>';
    html += '		</div>';
    html +=	'		<div class="col-lg-9">'
	html += ' 			<img class="img-rounded" src="' + url + '" alt="Camera View" />';
    html += '		</div>';
    html += '	</div>';
    html += '</div>';
	
	return html;
}