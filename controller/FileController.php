<?php

class FileController {
	
	public function ToString() {
		return 'FileController';
	}
	
	public function getPanorama() {
		$sleep_counter = 0;
		while(!file_exists('image/unlocked.txt')) {
			sleep(1);
			$sleep_counter = $sleep_counter + 1;
			if($sleep_counter > 10) {
				return '{"path" : "" }';
			}
		}
		
		//RL
		/*
		$imageBin = file_get_contents(URL_CAM_SNAPSHOT);
		$base64   = base64_encode($imageBin); 
		$myfile = fopen("image/snapshot.jpg", "w");
		fwrite($myfile, $imageBin);
		fclose($myfile);
		echo '{"path" : "' . URL_IMAGE . '/snapshot.jpg"}';
		*/
		
		//TEST
		$imageBin = file_get_contents('image/default.png');
		$base64 = base64_encode($imageBin);
		return '{"path" : "http://localhost:84/github/cam-ctrl/image/default.png"}';
	}
	
	public function lock() {
		if(!file_exists(FILE_LOCKED)) {
			if(file_exists(FILE_UNLOCKED)) {
				unlink(FILE_UNLOCKED);
			}
			$file = fopen(FILE_LOCKED, 'w');
			fclose($file);
		}
	}
	
	public function unlock() {
		if(!file_exists(FILE_UNLOCKED)) {
			if(file_exists(FILE_LOCKED)) {
				unlink(FILE_LOCKED);
			}
			$file = fopen(FILE_UNLOCKED, 'w');
			fclose($file);
		}
	}
}

?>