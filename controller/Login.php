<?php

class Login {
	
	private $username = 'admin';
	private $password = '1234';

	//Check if the login is valid
	public function isLoginValid($username, $password) {
		$retVar = false;
		
		if($username === $this->username && $password === $this->password) {
			$retVar = true;
			
			$_SESSION['username'] = $username;
		}
		
		return $retVar;
	}
		
}

?>