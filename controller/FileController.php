<?php

class FileController {
	
	public function getPanorama() {		
		if($this->isLocked()) {
			return '{ "path" : "" }';
		}
		
		//Get filename
		$filename = $this->getPanoramaFilename();
		$url = '';
		
		if(strlen($filename) > 0) {
			$url = URL_PANORAMA . $filename;
		}
		
		return '{ "path" : "'. $url . '" }';
	}
	
	public function getArchive($start = '', $end = 10) {
		//check if locked
		if($this->isLocked(true, 60)) {
			return '{}';
		}
		
		//Get files and order descending
		//Formatting: 'image/archive/yyyy-mm-dd_hh-mm-ss.jpg
		$files_tmp = glob('image/archive/*');
		krsort($files_tmp);
		
		//Reindex array
		$files = array();
		$files = array_values($files_tmp);
		
		//Select range
		$index_start = 0;
		if($start != '') {
			//Format url for the search
			$to_search = 'image/archive/' . basename($start);
			$index_start = array_search($to_search, $files);
			
			if($index_start === false) {
				//index not found, return an empty json
				return '{}';
			} else {
				//Up index to select the first new image
				$index_start++;
			}
		}
		
		//Get archive file infos
		$archive = array();
		for($i = $index_start; ($i < sizeof($files) && $i < ($index_start + $end)); $i++) {
			$file = $files[$i];
			$pic_info = array();
			
			$filename = basename($file, '.jpg');
			$datetime = explode('_', $filename);
			
			$pic_info['date'] = date('d.m.Y', strtotime($datetime[0]));
			$pic_info['time'] = date('H:i', strtotime(str_replace('-', ':', $datetime[1])));
			$pic_info['url'] = URL_ARCHIVE . basename($file); 
			
			array_push($archive, $pic_info);
		}
		
		return json_encode($archive);
	}
	
	public function getNewArchivePicture($old_pic) {
		//check if locked
		if($this->isLocked(true, 60)) {
			return '{}';
		}
		
		//Get files and order descending
		//Formatting: 'image/archive/yyyy-mm-dd_hh-mm-ss.jpg
		$files_tmp = glob('image/archive/*');
		krsort($files_tmp);
		
		//Reindex array
		$files = array();
		$files = array_values($files_tmp);
		
		$first_file = $files[0];
		$archive = array();
		if(basename($old_pic) != basename($first_file)) {
			//Current image is not the newest, return url + info as json
			$pic_info = array();
			
			$filename = basename($first_file, '.jpg');
			$datetime = explode('_', $filename);
			
			$pic_info['date'] = date('d.m.Y', strtotime($datetime[0]));
			$pic_info['time'] = date('H:i', strtotime(str_replace('-', ':', $datetime[1])));
			$pic_info['url'] = URL_ARCHIVE . basename($first_file); 
			
			array_push($archive, $pic_info);
			
			return json_encode($archive);
			
		} else {
			//Current image is the newest, return empty json
			return '{}';
		}
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
	
	private function isLocked($wait = false, $seconds = 10) {
		if($wait) {
			$sleep_counter = 0;
			while(!file_exists(FILE_UNLOCKED)) {
				sleep(1);
				$sleep_counter = $sleep_counter + 1;
				if($sleep_counter > 10) {
					return true;
				}
			}
			
			return false;
			
		} else {
			return !file_exists(FILE_UNLOCKED);
		}
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