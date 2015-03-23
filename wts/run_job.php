<?php

	include_once('../constants.php');

	$to_do = $argv[1];
	file_get_contents(URL_HOME . 'file_control.php?task="' . $to_do . '"');

?>