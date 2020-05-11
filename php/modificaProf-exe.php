<?php
  include_once("funzioni.php");
// controlli sull'input
  session_start();
  $utente = $_SESSION["utente"]; // prendo il nick dell'utente

  $nome = addslashes($_POST["nome"]);
  $cognome = addslashes($_POST["cognome"]);
  $dataN = $_POST["dataN"];
  $residenza = addslashes($_POST["residenza"]);
  $squadra_cuore = trim($_POST["squadra_cuore"]);
  $oldpw = $_POST["oldpw"];
  $newpw1 = $_POST["newpw1"];
  $newpw2 = $_POST["newpw2"];

  $errore = "";



  // controllo se la oldpw è quella attuale
  $select = "SELECT password FROM utente WHERE nickname = '$utente'";
  $result = $cid->query($select) or die("<p>Impossibile eseguire la query.</p>"
                                 . "<p>Codice errore " . $cid->errno . ": " . $cid->error . "</p>");
  $row = $result->fetch_row();
  $controlPw = $row[0];


  if(empty($oldpw) && empty($newpw1) && empty($newpw2)) { // se non cambio password
  				$aggiorna = "UPDATE utente SET nome = '$nome', cognome = '$cognome',
                 data_nascita = '$dataN', residenza = '$residenza', squadra_cuore = '$squadra_cuore' WHERE nickname = '$utente'";
  				$res = $cid->query($aggiorna) or die("<p>Impossibile eseguire la query.</p>"
  				                              . "<p>Codice errore " . $cid->errno . ": " . $cid->error . "</p>");
          importa_dati_utente($cid, $utente);
  				header("Location:../index.php?stato=ok");
  		}
  if(!empty($oldpw) && !empty($newpw1) && !empty($newpw2)) { // se modifico la password
    if($oldpw == $controlPw) { // se la password attuale è corretta
      if(empty($newpw1) && !empty($newpw2)) {
        $errore = "</br>Specificare il campo Nuova Password!</br>";
      }
      if(!empty($newpw1) && empty($newpw2)) {
        $errore = "</br>Specificare il campo Ripeti la Password!</br>";
      }
      else {
        if(!empty($newpw1) && !empty($newpw2)) {
          $aggiorna = "UPDATE utente SET password = '$newpw1', nome = '$nome', cognome = '$cognome',
                 data_nascita = '$dataN', residenza = '$residenza', squadra_cuore = '$squadra_cuore' WHERE nickname = '$utente'";
          $res = $cid->query($aggiorna) or die("<p>Impossibile eseguire la query.</p>"
                                        . "<p>Codice errore " . $cid->errno . ": " . $cid->error . "</p>");
          importa_dati_utente($cid, $utente);
          header("Location:../index.php?stato=ok");
        }
      }
    }
    else {
      $errore = "</br>La password inserita non corrisponde a quella attuale.";
      header("Location:../index.php?stato=no&msg=".urlencode($errore));
    }
  }

?>
