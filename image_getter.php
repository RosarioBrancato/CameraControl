<?php

	include_once('constants.php');

	if(isset($_GET)) {
		getImage();
	}

	function getImage() {
		//RL
		$imageBin = file_get_contents(URL_CAM_SNAPSHOT);
		$base64   = base64_encode($imageBin); 
		$myfile = fopen("image/snapshot.jpg", "w");
		fwrite($myfile, $imageBin);
		fclose($myfile);
		echo '{"path" : "' . URL_IMAGE . '/snapshot.jpg"}';
		
		//TEST
		/*$imageBin = file_get_contents('image/default.png');
		$base64 = base64_encode($imageBin);
		echo '{"path" : "http://localhost:84/github/cam-ctrl/image/default.png"}';*/
	}
?>