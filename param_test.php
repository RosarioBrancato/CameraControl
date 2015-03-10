<?php

	define('URL', 'http://10.142.126.210/cgi-bin/camctrl.cgi');
	define('URL2', 'http://10.142.126.215/cgi-bin/camctrl.cgi');

	while(true) {
		
		echo file_get_contents(URL . '?move=left');
		echo file_get_contents(URL . '?move=left');
		echo file_get_contents(URL . '?move=left');
		
		echo file_get_contents(URL2 . '?move=left');
		echo file_get_contents(URL2 . '?move=left');
		echo file_get_contents(URL2 . '?move=left');
		
		
		echo file_get_contents(URL . '?move=up');
		echo file_get_contents(URL . '?move=up');
		echo file_get_contents(URL . '?move=up');
		
		echo file_get_contents(URL2 . '?move=up');
		echo file_get_contents(URL2 . '?move=up');
		echo file_get_contents(URL2 . '?move=up');
		
		
		echo file_get_contents(URL . '?move=right');
		echo file_get_contents(URL . '?move=right');
		echo file_get_contents(URL . '?move=right');
		
		echo file_get_contents(URL2 . '?move=right');
		echo file_get_contents(URL2 . '?move=right');
		echo file_get_contents(URL2 . '?move=right');
		
		
		echo file_get_contents(URL . '?move=down');
		echo file_get_contents(URL . '?move=down');
		echo file_get_contents(URL . '?move=down');
		
		echo file_get_contents(URL2 . '?move=down');
		echo file_get_contents(URL2 . '?move=down');
		echo file_get_contents(URL2 . '?move=down');
	}

?>