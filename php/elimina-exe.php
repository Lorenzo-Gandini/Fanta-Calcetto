<?php
	session_start();
	include_once("funzioni.php");

	$nick = $_SESSION["utente"];

	$cancella = "DELETE FROM utente WHERE nickname = '$nick'";
  	$cid->query($cancella) or die("<p>Impossibile eseguire la query.</p>"
	                                 . "<p>Codice errore " . $cid->errno . ": " . $cid->error . "</p>");


  session_destroy();


	header("Location:../index.php?stato=ok");

?>
