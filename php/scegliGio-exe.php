<?php
	include_once("funzioni.php");
	// controlli sull'input e assegnamento alle variabili
    session_start();
    $sq = $_SESSION["squadra"];
    $utente = $_SESSION["utente"];
    $spesa_tot=0;
    $soldi_fin=300;

    /* inserisco i giocatori scelti nella squadra e reindirizzo a visualizza squadra.  */
    $portieri = $_POST["por"];
    foreach($portieri as $play=>$value){
        $insert_por = "INSERT INTO composta (squadra, giocatori)
                    VALUES ('$sq', '$value')";
        $cid -> query($insert_por) Or die("<p>2. Impossibile eseguire la query.</p>"
           . "<p>Codice errore " . $cid->errno . ": " . $cid->error . "</p>");
      }

    $difensori = $_POST["dif"];
    foreach( $difensori as $play=>$value){
        $insert_dif = "INSERT INTO composta (squadra, giocatori)
                    VALUES ('$sq', '$value')";
        $cid -> query($insert_dif) Or die("<p>3. Impossibile eseguire la query.</p>"
           . "<p>Codice errore " . $cid->errno . ": " . $cid->error . "</p>");
      }

    $centrocampisti = $_POST["cen"];
    foreach($centrocampisti as $play=>$value){
        $insert_cen = "INSERT INTO composta (squadra, giocatori)
                    VALUES ('$sq', '$value')";
        $cid -> query($insert_cen) Or die("<p>4. Impossibile eseguire la query.</p>"
           . "<p>Codice errore " . $cid->errno . ": " . $cid->error . "</p>");
      }

    $attaccanti = $_POST['att'];
    foreach($attaccanti as $play=>$value){
        $insert_att = "INSERT INTO composta (squadra, giocatori)
                    VALUES ('$sq', '$value')";
        $cid -> query($insert_att) Or die("<p>5. Impossibile eseguire la query.</p>"
           . "<p>Codice errore " . $cid->errno . ": " . $cid->error . "</p>");
      }


    $sel_nomi = "SELECT  DISTINCT giocatori FROM composta WHERE squadra = '$sq'";
    $res = $cid -> query( $sel_nomi) Or die("<p>6. Impossibile eseguire la query.</p>"
           . "<p>Codice errore " . $cid->errno . ": " . $cid->error . "</p>");
    while ($elenconomi = $res -> fetch_assoc()) {
        $caso = $elenconomi["giocatori"];
        $sel = "SELECT prezzo FROM giocatore WHERE nome = '$caso'";
        $res2 = $cid -> query($sel) or die("<p>7.Impossibile eseguire la query.</p>"
                                                                    . "<p>Codice errore " . $cid->errno . ": " . $cid->error . "</p>");
        $prezzo_s = $res2 -> fetch_row();
        $prezzo_singolo = $prezzo_s[0];
        $spesa_tot = $spesa_tot + $prezzo_singolo;
        }
    $soldi_fin = $soldi_fin - $spesa_tot;
    $insert = "UPDATE utente SET fantacash = '$soldi_fin' WHERE nickname = '$utente'";
    $res = $cid -> query($insert) or die("<p>8.Impossibile eseguire la query.</p>"
                                    . "<p>Codice errore " . $cid->errno . ": " . $cid->error . "</p>");


	//iscrivo la squadra al campionato generale
	/*ATTENZIONE!!! IL CAMPIONATO GENERALE DOVRà AVERE ID=1*/
	$sql2 = "SELECT squadra FROM compete WHERE squadra = '$sq' AND campionato='1'";
	$res2 = $cid -> query($sql2) or die("<p>11.Impossibile eseguire la query.</p>"
                                    . "<p>Codice errore " . $cid->errno . ": " . $cid->error . "</p>");
	$iscr = $res2->fetch_row();
	$iscritto = $iscr[0];

	//se dentro iscritto non c'è niente vuol dire che non è ancora iscritto al campionato generale
	if(!(isset($iscritto))) {
		$sql1 = "INSERT INTO compete (squadra, campionato) VALUES ('$sq','1')";
		$res1 = $cid->query($sql1) or die("<p>10.Impossibile eseguire la query.</p>"
										. "<p>Codice errore " . $cid->errno . ": " . $cid->error) . "</p>";

		header("Location:../index.php?op=scegliCampAperto");
	}
	else {
		header("Location:../index.php?stato=ok");
	}

    

?>
