<?php

	include_once('constants.php');
	include_once('controller/FileController.php');
	
	$ctrl = new FileController();
	
	if(isset($_GET['panorama'])) {
		echo $ctrl->getPanorama();
		
	} else if(isset($_GET['load_archive'])) {	
	
		if(isset($_GET['last_image']) && isset($_GET['count'])) {
			$start = $_GET['last_image'];
			$count = $_GET['count'];
			echo $ctrl->getArchive($start, $count);
			
		} else {
			echo $ctrl->getArchive();
		}
		
	} else if(isset($_GET['load_archive_new'])) {
		$url = '';
		
		if(isset($_GET['first_image'])) {
			$url = $_GET['first_image'];
		}
		
		echo $ctrl->getNewArchivePicture($url);
		
	} else if(isset($_GET['task'])) {
		if($_GET['task'] === 'create_panorama') {
			$ctrl->createPanorama();
		
		} else if($_GET['task'] === 'move_to_archive') {
			$ctrl->movePanoramaToArchive();
			
		} else if($_GET['task'] === 'clean_archive') {
			$ctrl->cleanArchive();
		}
	}

?>