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
			$('#main_content').append('<input type="hidden" id="first_image" value="' + $(data).get(0).url + '" />');
			$('#main_content').append('<input type="hidden" id="last_image" value="' + $(data).get(-1).url + '" />');
			$.each(data, function(index, value) {
				$('#main_content').append(getArchiveHtmlRow(value.date, value.time, value.url));
			});
		},
		error: function(xhr, status, error) {
			//alert('failed: ' + error);
		}
	});
});

$(window).scroll(function()  {
	if($('#nav_archive').hasClass('selected')) {
		var height = $(window).height();
		var scrolled = $(window).scrollTop();
		var doc = $(document).height();
		
		var last_image_url = $('#last_image').val();
		
		if((scrolled + height) > (doc - 100)) {
			$.ajax({
				url: URL_HOME + 'file_control.php',
				type: 'get',
				data: { load_archive: "load_archive", last_image: last_image_url, count: "10" },
				dataType: 'json',
				success: function(data) {
					if(!$.isEmptyObject(data)) {
						//insert html of pictures
						$.each(data, function(index, value) {
							$('#main_content').append(getArchiveHtmlRow(value.date, value.time, value.url));
						});
						$('#last_image').val($(data).get(-1).url);
					}
				},
				error: function(xhr, status, error) {
					//alert('failed: ' + error);
				}
			});
		}
	}
});

window.setInterval(function() {
	if($('#nav_archive').hasClass('selected')) {
		var first_image_url = $('#first_image').val();
		
		$.ajax({
			url: URL_HOME + 'file_control.php',
			type: 'get',
			data: { load_archive_new : "load_archive_new", first_image: first_image_url },
			dataType: 'json',
			success: function(data) {
				if(!$.isEmptyObject(data)) {
					$.each(data, function(index, value) {
						$('#main_content').prepend(getArchiveHtmlRow(value.date, value.time, value.url));
					});
					$('#first_image').val($(data).get(0).url);
				}
			}
		});
	}
}, 10000);

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