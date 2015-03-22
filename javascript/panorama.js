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

window.setInterval(function() {
	if($('#nav_panorama').hasClass('selected')) {
		$.ajax({
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
		});
	}
}, 1000);