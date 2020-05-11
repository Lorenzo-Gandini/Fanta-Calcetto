<?php
  include_once("funzioni.php");
  session_start();
  $utente = $_SESSION["utente"];
//  $inizio = $_SESSION["nGiornata"];
  $nomeCamp = addslashes($_POST["nomeCam"]);
  $numeroGiorCamp = addslashes($_POST["nGiornateCam"]);
  $id=0;


//creo un id univoco per ogni campionato. prendo l'ultimo id e aggiungo 1
  $select = "SELECT id FROM campionato ORDER BY id DESC LIMIT 1";
  	$result = $cid->query($select) or die("<p>Impossibile eseguire la query.</p>"
  	                               . "<p>Codice errore " . $cid->errno . ": " . $cid->error) . "</p>";
    $row = $result->fetch_row();
  	$id = $row[0];

    $id += 1;


//inserisco nel db i dati del campionato
    $sql = "INSERT INTO campionato (id, nome, numero_giornate) VALUES ('$id', '$nomeCamp', '$numeroGiorCamp')";
    $cid->query($sql) or die("<p>1.Impossibile eseguire la query.</p>"
  		                            . "<p>Codice errore " . $cid->errno . ": " . $cid->error) . "</p>";

    for($i=1;$i<=$numeroGiorCamp;$i++){
        $sql2 = "INSERT INTO giornata (num_giornata,id) VALUES ('$i', '$id')";
        $cid->query($sql2) or die("<p>2.Impossibile eseguire la query.</p>"
  		                            . "<p>Codice errore " . $cid->errno . ": " . $cid->error) . "</p>";
    }

      header("Location:../index.php?stato=ok");

?>
