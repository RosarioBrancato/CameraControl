<?php

class FileController {
	
	public function getPanorama() {		
		if($this->isLocked()) {
			return '{"path" : "" }';
		}
		
		//Get filename
		$filename = $this->getPanoramaFilename();
		$url = '';
		
		if(strlen($filename) > 0) {
			$url = URL_PANORAMA . $filename;
		}
		
		return '{"path" : "'. $url . '" }';
	}
	
	public function getArchive() {
		//TO-DO
	}
	
	public function getNewArchivePicture() {
		//TO-DO
	}
	
	
	
	public function createPanorama() {
		//Lock access to pictures
		$this->lock();
		
		//Picture part 1
		file_get_contents(URL_CAM_CTRL . '?move=home&speedpan=5');
		sleep(2);
		$imageBinP1 = file_get_contents(URL_CAM_SNAPSHOT);
		$base64P1 = base64_encode($imageBinP1); 
		$myfileP1 = fopen("image/tmp/part1.jpg", "w");
		fwrite($myfileP1, $imageBinP1);
		fclose($myfileP1);
		
		//Move Cam T1
		$this->moveCam();
		
		//Picture part 2
		$imageBinP2 = file_get_contents(URL_CAM_SNAPSHOT);
		$base64P2 = base64_encode($imageBinP2); 
		$myfileP2 = fopen("image/tmp/part2.jpg", "w");
		fwrite($myfileP2, $imageBinP2);
		fclose($myfileP2);
		
		//Move Cam T2
		$this->moveCam();
		
		//Picture part 2
		$imageBinP3 = file_get_contents(URL_CAM_SNAPSHOT);
		$base64P3 = base64_encode($imageBinP2); 
		$myfileP3 = fopen("image/tmp/part3.jpg", "w");
		fwrite($myfileP3, $imageBinP3);
		fclose($myfileP3);
		
		//Create panorama pictures
		//Load images
		$tmp_panorama = imagecreatetruecolor(1920, 480);
		$part1 = imagecreatefromjpeg('image/tmp/part1.jpg');
		$part2 = imagecreatefromjpeg('image/tmp/part2.jpg');
		$part3 = imagecreatefromjpeg('image/tmp/part3.jpg');
		
		//Combine images
		imagecopy($tmp_panorama, $part1, 0, 0, 0, 0, 640, 480);
		imagecopy($tmp_panorama, $part2, 640, 0, 0, -7, 640, 480); 
		imagecopy($tmp_panorama, $part3, 1280, 0, 0, -12, 640, 480);
		
		//Cut black edges
		$panorama = imagecreatetruecolor(1920, 461);
		imagecopy($panorama, $tmp_panorama, 0, 0, 0, 14, 1920, 461);
		
		//Delete older images
		$files = glob('image/panorama/*');
		foreach($files as $file) {
			if(is_file($file)) {
				unlink($file);
			}
		}
		
		//Save image
		imagejpeg($panorama, 'image/panorama/' . date('Y-m-d_H-i-s') . '.jpg', 100);
		
		//Dispose variables
		imagedestroy($tmp_panorama);
		imagedestroy($part1);
		imagedestroy($part2);
		imagedestroy($part3);
		imagedestroy($panorama);
		
		//Unlock access to pictures
		$this->unlock();
	}
	
	public function movePanoramaToArchive() {
		$this->lock();
		
		//Get panorama picture filename
		$panorama = $this->getPanoramaFilename();
		//Copy panorama picture in archive
		copy('image/panorama/' . $panorama, 'image/archive/' . $panorama);
		
		$this->unlock();
	}
	
	public function cleanArchive() {
		$this->lock();
		
		$files = glob('image/archive/*');
		foreach($files as $file) {
			$filename = basename($file);
			$datetime = explode('_', $filename);
			
			//Get dates
			$img_date = $datetime[0];
			$two_weeks = date('Y-m-d', strtotime('-14 day'));
			
			//Compare dates
			if(strtotime($img_date) < strtotime($two_weeks)) {
				unlink('image/archive/' . $filename);
			}
		}
		
		$this->unlock();
	}
	
	
	
	private function lock() {
		if(!file_exists(FILE_LOCKED)) {
			if(file_exists(FILE_UNLOCKED)) {
				unlink(FILE_UNLOCKED);
			}
			$file = fopen(FILE_LOCKED, 'w');
			fclose($file);
		}
	}
	
	private function unlock() {
		if(!file_exists(FILE_UNLOCKED)) {
			if(file_exists(FILE_LOCKED)) {
				unlink(FILE_LOCKED);
			}
			$file = fopen(FILE_UNLOCKED, 'w');
			fclose($file);
		}
	}
	
	private function isLocked() {
		/*$sleep_counter = 0;
		while(!file_exists(FILE_UNLOCKED)) {
			sleep(1);
			$sleep_counter = $sleep_counter + 1;
			if($sleep_counter > 10) {
				return true;
			}
		}*/
		
		//return false;
		
		return !file_exists(FILE_UNLOCKED);
	}
	
	private function getPanoramaFilename() {
		$files = glob('image/panorama/*');
		$filename = '';
		if(sizeof($files) > 0) {
			$filename = basename($files[0]);
		}
		return $filename;
	}

	private function moveCam() {
		file_get_contents(URL_CAM_CTRL . '?move=right&speedpan=-5');
		file_get_contents(URL_CAM_CTRL . '?move=right&speedpan=-5');
		
		file_get_contents(URL_CAM_CTRL . '?move=right&speedpan=0');
		file_get_contents(URL_CAM_CTRL . '?move=right&speedpan=0');
		file_get_contents(URL_CAM_CTRL . '?move=right&speedpan=0');
		
		sleep(3);
	}
}

?>