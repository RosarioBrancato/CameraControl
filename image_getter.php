<?php

	if(isset($_GET)) {
		getImage();
	}

	function getImage(){
		//RL
		/*$imageBin = file_get_contents("http://10.142.126.231/cgi-bin/video.jpg");
		$base64   = base64_encode($imageBin); 
		$myfile = fopen("images/snapshot.jpg", "w");
		fwrite($myfile, $imageBin);
		fclose($myfile);
		echo '{"path" : "http://localhost:84/github/cam-ctrl/image/snapshot.png"}';*/
		
		//TEST
		$imageBin = file_get_contents('image/default.png');
		$base64 = base64_encode($imageBin);
		
		echo '{"path" : "http://localhost:84/github/cam-ctrl/image/default.png"}';
	}
?>