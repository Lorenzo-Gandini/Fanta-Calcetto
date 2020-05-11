<?php

	$hostname = "localhost";
	$username = "root";
	$password= "";
	$db = "fantacalcettostatale";

	$cid = new mysqli($hostname,$username,$password,$db);

	if($cid->connect_errno) {
		$_errore=true;
		$_err_msg= "Non riesco a connettermi al database.";
	}

?>
