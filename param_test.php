<?php

	while(true) {
		echo file_get_contents('http://10.142.126.233/cgi-bin/camctrl.cgi?move=left');
		echo file_get_contents('http://10.142.126.233/cgi-bin/camctrl.cgi?move=left');
		echo file_get_contents('http://10.142.126.233/cgi-bin/camctrl.cgi?move=left');
		
		echo file_get_contents('http://10.142.126.233/cgi-bin/camctrl.cgi?move=up');
		echo file_get_contents('http://10.142.126.233/cgi-bin/camctrl.cgi?move=up');
		echo file_get_contents('http://10.142.126.233/cgi-bin/camctrl.cgi?move=up');
		
		echo file_get_contents('http://10.142.126.233/cgi-bin/camctrl.cgi?move=right');
		echo file_get_contents('http://10.142.126.233/cgi-bin/camctrl.cgi?move=right');
		echo file_get_contents('http://10.142.126.233/cgi-bin/camctrl.cgi?move=right');
		
		echo file_get_contents('http://10.142.126.233/cgi-bin/camctrl.cgi?move=down');
		echo file_get_contents('http://10.142.126.233/cgi-bin/camctrl.cgi?move=down');
		echo file_get_contents('http://10.142.126.233/cgi-bin/camctrl.cgi?move=down');
	}

?>