<?php

	if(isset($_GET)) {
		getImage();
	}

	function getImage(){
		//RL
		/*$imageBin = file_get_contents("http://10.142.126.233/cgi-bin/video.jpg");
		$base64   = base64_encode($imageBin); 
		$myfile = fopen("image/snapshot.jpg", "w");
		fwrite($myfile, $imageBin);
		fclose($myfile);
		echo '{"path" : "http://localhost/cam-ctrl/image/snapshot.jpg"}';*/
		
		//TEST
		$imageBin = file_get_contents('image/default.png');
		$base64 = base64_encode($imageBin);
		echo '{"path" : "http://localhost:84/github/cam-ctrl/image/default.png"}';
	}
?>