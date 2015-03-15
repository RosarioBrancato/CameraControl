<?php

	include_once('constants.php');
	include_once('controller/FileController.php');
	
	$ctrl = new FileController();
	
	$ctrl->unlock();
	
	if(isset($_GET['panorama'])) {
		echo $ctrl->getPanorama();
	}

?>