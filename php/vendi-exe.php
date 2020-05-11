<?php
	include_once("funzioni.php");
	session_start();
    $nomeSq = $_SESSION["squadra"];
    $utente = $_SESSION["utente"]; //prendo il nick dell'utente
	$errore = "";

		//prendo i soldi che l'utente possiede
    $ins = "SELECT fantacash FROM utente WHERE nickname = '$utente'";
    $res = $cid -> query($ins) or die("<p>Impossibile eseguire la query.</p>"
                                  . "<p>Codice errore " . $cid->errno . ": " . $cid->error . "</p>");
    $so = $res -> fetch_row();
    $soldi = $so[0];

  	if(isset($_POST["giocatoreVenduto"])) {
  		$venduti = $_POST["giocatoreVenduto"];
  	}

  //se non ha venduto giocatori
  	if(count($venduti) == 0) {
  		$errore .= "</br>Non hai venduto alcun giocatore.";
  	}

		//prendo il prezzo dei giocatori selezionati
		foreach($venduti as $giocator) {
		$sel = "SELECT prezzo FROM giocatore WHERE nome = '$giocator'";
		$res1 = $cid -> query($sel) or die("<p>Impossibile eseguire la query.</p>"
																	. "<p>Codice errore " . $cid->errno . ": " . $cid->error . "</p>");
		while ($soldiSpesi = $res1 -> fetch_assoc()) {
				$quotazione = $soldiSpesi["prezzo"];
				$soldi += $quotazione;
			}
        }

			

    // aggiorno i soldi dell'utente nel db
      $insert = "UPDATE utente SET fantacash = '$soldi' WHERE nickname = '$utente'";
      $res = $cid -> query($insert) or die("<p>Impossibile eseguire la query.</p>"
                                    . "<p>Codice errore " . $cid->errno . ": " . $cid->error . "</p>");


		//cancello i giocatori venduti
      foreach($venduti as $giocatore){
        $delete = "DELETE FROM composta WHERE squadra = '$nomeSq' AND giocatori = '$giocatore'";
    		$res = $cid->query($delete) or die("<p>Impossibile eseguire la query.</p>"
    		                            . "<p>Codice errore " . $cid->errno . ": " . $cid->error . "</p>");
      }

    //se non ha venduto giocatori
  	if($errore != "") {
  		header("Location:../index.php?stato=no&msg=".urlencode($errore));
  	}
  	else {
  		header("Location:../index.php?op=compra");
	}

?>
