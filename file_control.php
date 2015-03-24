<?php

	include_once('constants.php');
	include_once('controller/FileController.php');
	
	//Object to control the whole website
	$ctrl = new FileController();
	
	//Get link of the panorama image
	if(isset($_GET['panorama'])) {
		echo $ctrl->getPanorama();
	
	//Get image of the archive
	} else if(isset($_GET['load_archive'])) {	
	
		//Get archive from a specific date and a cout
		if(isset($_GET['last_image']) && isset($_GET['count'])) {
			$start = $_GET['last_image'];
			$count = $_GET['count'];
			echo $ctrl->getArchive($start, $count);
			
		} else {
			echo $ctrl->getArchive();
		}
		
	//Get the newst image of the archive
	} else if(isset($_GET['load_archive_new'])) {
		$url = '';
		
		if(isset($_GET['first_image'])) {
			$url = $_GET['first_image'];
		}
		
		echo $ctrl->getNewArchivePicture($url);
		
	//Run tasks of the Windows Task Scheduler
	} else if(isset($_GET['task'])) {
		//Create a panorama image
		if($_GET['task'] === 'create_panorama') {
			$ctrl->createPanorama();
		
		//Move the current panorama impage
		} else if($_GET['task'] === 'move_to_archive') {
			$ctrl->movePanoramaToArchive();
			
		//Delete image of the archive, which are older than two weeks
		} else if($_GET['task'] === 'clean_archive') {
			$ctrl->cleanArchive();
		}
	}

?>