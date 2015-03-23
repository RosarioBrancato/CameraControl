$('#nav_admin').click(function(event) {
	//highlight navigation point
	$('#nav_panorama').removeClass('selected');
	$('#nav_archive').removeClass('selected');
	$('#nav_admin').addClass('selected');
	
	//insert default html
	var html = '';
	html += '<div class="row">';
	html += '	<div class="box">';
	html += '		<div class="col-lg-12">';
	html += '			<center><p class="form-inline">Username: <input type="text" class="form-control" id="username" maxlen="20" /></p></center>';
	html += '			<center><p class="form-inline">Password: <input type="password" class="form-control" id="password" maxlen="20" /></p></center>';
	html += '			<center><input type="button" class="btn btn-warning" id="login" value="Login and open the Camera Control Panel" /></center>';
	html += '			<center><p id="feedback"> </p></center>';
	html += '		</div>';
	html += '	</div>';
	html += '</div>';
	$('#main_content').html(html);
	
	$('#login').on('click', function() {
		var u_name = $('#username').val();
		var pwd = $('#password').val();
		
		$.ajax({
			url: URL_HOME + 'login.php',
			type: 'post',
			data: { login: 'login', username: u_name, password: pwd },
			dataType: 'json',
			success: function(data) {
				//insert path to panorama picture
				if(!$.isEmptyObject(data)) {
					if(data.success == "1") {
						window.open(URL_HOME + 'control_panel.php', '_blank', 'height=600,width=1000');
						$('#username').val('');
						$('#password').val('');
					} else {
						alert('Login data is incorrect!');
					}
				}
			},
			error: function(xhr, status, error) {
				alert('failed: ' + error);
			}
		});
	});
	
});