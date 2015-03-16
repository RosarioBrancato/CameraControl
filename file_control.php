<?php

	include_once('constants.php');
	include_once('controller/FileController.php');
	
	$ctrl = new FileController();
	
	if(isset($_GET['panorama'])) {
		echo $ctrl->getPanorama();
		
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