<?php
	$nickname = $_POST["user"];
	$pw = $_POST["pass"];

	include_once("funzioni.php");

//se c'è connessione col db
	if($cid) {
		$esito = esiste_utente($cid,$nickname,$pw);

		if($esito["stato"]) {                //se stato è 1
			if(isset($_POST["ricordami"])) {   //se l'utente richiede di essere ricordato, allora setto il cookie
				setcookie ("user",$nickname,time()+43200,"/");
			}
			elseif(isset($_COOKIE["user"])) {  //se non mette ricordami no
				unset($_COOKIE['user']);
				setcookie('user', null, -1, '/');
			}
			session_start();
			$_SESSION["utente"] = $nickname;
			importa_dati_utente($cid, $nickname);
			$cid->close();

			header("Location:../index.php?stato=ok");
		}

		else {                              //se stato è 0
			header("Location:../index.php?stato=no&msg=" . urlencode($esito["msg"]));
		}
	}
//se non riesci a connetterti
	else {
		header("Location:../index.php?stato=no&msg=". urlencode("</br>Errore connessione al database."));
	}
?>
