<?php
	include_once("funzioni.php");
	// controlli sull'input e assegnamento alle variabili

	$nomeSq = addslashes($_POST["nomeSquadra"]);
	$mottoSq = addslashes($_POST["mottoSquadra"]);
	$errore = "</br>";

	session_start();
	$utente = $_SESSION["email"];


		$insert = "INSERT INTO squadra (nome, motto)
		VALUES ('$nomeSq','$mottoSq')";
		$res = $cid -> query($insert)
		Or die("<p>Impossibile eseguire la query.</p>"
			   . "<p>Codice errore " . $cid->errno . ": " . $cid->error . "</p>");


		$insert = "INSERT INTO crea (email, squadra)
		VALUES ('$utente','$nomeSq')";
		$res = $cid -> query($insert)
		Or die("<p>Impossibile eseguire la query.</p>"
				 . "<p>Codice errore " . $cid->errno . ": " . $cid->error . "</p>");

        $_SESSION["squadra"]= $nomeSq;
        $_SESSION["motto"]= $mottoSq;

		//reindirizzamento
		header("Location:../index.php?op=scegliGiocatori");

?>
