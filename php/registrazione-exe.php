<?php
	include_once("funzioni.php");
	// controlli sull'input e assegnamento alle variabili

	$nome = addslashes($_POST["nome"]);
	$cognome = addslashes($_POST["cognome"]);
	$email = $_POST["email"];
	$pw1 = $_POST["pw1"];
  $nick = trim($_POST["nickname"]);
	$dataN = $_POST["dataN"];
	$citta = addslashes($_POST["citta"]);
  //provincia???
	$favSqua = trim($_POST["squadra_cuore"]);

	$errore = "</br>";



		$insert = "INSERT INTO utente (email, nickname, password, nome, cognome, residenza, data_nascita, squadra_cuore)
		VALUES ('$email','$nick','$pw1','$nome','$cognome','$citta','$dataN','$favSqua')";
		$res = $cid -> query($insert)
		Or die("<p>Impossibile eseguire la query.</p>"
			   . "<p>Codice errore " . $cid->errno . ": " . $cid->error . "</p>");

				 session_start();
				 $_SESSION["utente"] = $nick;
				 importa_dati_utente($cid, $nick);

		header("Location:../index.php?op=creaSquadra");

?>
