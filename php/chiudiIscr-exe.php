<?php
    include_once("funzioni.php");

    $nome_camp = $_SESSION["nome_camp"];

    //seleziono l'id del campionato considerato dalla form.
    $sql = "SELECT id FROM campionato WHERE nome='$nome_camp'";
    $res = $cid->query($sql) or die("<p>Impossibile eseguire la query.</p>"
  		                            . "<p>Codice errore " . $cid->errno . ": " . $cid->error) . "</p>";
    $id_camp = $res->fetch_row();
    $id_considerato = $id_camp[0];

    //seleziono l'ultima giornata aperta
    $sql3 = "SELECT num_giornata FROM giornata WHERE id='$id_considerato' AND stato='1' ORDER BY num_giornata DESC ";
    $res3 = $cid->query($sql3) or die("<p>2.Impossibile eseguire la query.</p>"
  		                            . "<p>Codice errore " . $cid->errno . ": " . $cid->error) . "</p>";
    $giornata2 = $res3->fetch_row();
    $giornata_cons2 = $giornata2[0];




    //se la giornata non è stata aperta
    if(!(isset($giornata_cons2))){
        echo "<div class=\"alert alert-danger\">Attenzione! Devi aprire prima una giornata!</div>";
        echo "<div class=\"text-center\">";
        echo "<input type=\"button\" value=\"Vai ad Amministra Campionati\" class=\"btn btn-primary btn-md btn-conf\"
                    onClick=\"window.location = 'http://localhost/calcetto/index.php?op=gestioneCampionati'\">";
        echo "</div>";
    }

    //chiudo correttamente la giornata e assegno i voti
    else{
        //aggiorno lo stato della giornata e la chiudo
        $sql2 = "UPDATE giornata SET stato='2' WHERE id='$id_considerato' AND num_giornata='$giornata_cons2'";
        $cid->query($sql2) or die("<p>3.Impossibile eseguire la query.</p>"
  		                            . "<p>Codice errore " . $cid->errno . ": " . $cid->error) . "</p>";


/*INIZIO CONTROLLO*/

        //prendo le squadre che partecipano a questo campionato
        $sql5 = "SELECT squadra FROM compete WHERE campionato='$id_considerato'";
        $res5 = $cid->query($sql5) or die("<p>4.Impossibile eseguire la query.</p>"
  		                            . "<p>Codice errore " . $cid->errno . ": " . $cid->error) . "</p>";
        while($squadra = $res5->fetch_row()){
            $squadra_camp = $squadra[0];

            $sql6 = "SELECT DISTINCT nome_gioc FROM formazione WHERE num_giornata='$giornata_cons2' AND id_campionato='$id_considerato' AND nome_sq='$squadra_camp'";
            $res6 = $cid->query($sql6) or die("<p>5.Impossibile eseguire la query.</p>"
      		                            . "<p>Codice errore " . $cid->errno . ": " . $cid->error) . "</p>";
            $nome = $res6->fetch_row();
            $nomeG = $nome[0];
            //se non è presenta la formazione per questa giornata prendo la formazione della giornata precedente e la inserisco
            if(!(isset($nomeG))) {
                $giornata_prec = $giornata_cons2 - 1;
                $sql7 = "SELECT DISTINCT nome_gioc, ruolo, stato_gioc FROM formazione WHERE num_giornata='$giornata_prec' AND id_campionato='$id_considerato' AND nome_sq='$squadra_camp'";
                $res7 = $cid->query($sql7) or die("<p>6.Impossibile eseguire la query.</p>"
          		                            . "<p>Codice errore " . $cid->errno . ": " . $cid->error) . "</p>";

                while($giocatore = $res7->fetch_assoc()){
                    $nome = $giocatore["nome_gioc"];
                    $ruolo = $giocatore["ruolo"];
                    $stato = $giocatore["stato_gioc"];

                    $insert = "INSERT INTO formazione (nome_gioc, ruolo, num_giornata, stato_gioc, id_campionato, nome_sq)
    				VALUES ('$nome','$ruolo','$giornata_cons2','$stato','$id_considerato','$squadra_camp')";
    				$res8 = $cid -> query($insert) or die("<p>7.Impossibile eseguire la query.</p>"
    											  . "<p>Codice errore " . $cid->errno . ": " . $cid->error . "</p>");
                }
            }
        }

/*FINE CONTROLLO*/


        //prendo i giocatori della formazione di questa giornata
        $sql4 = "SELECT DISTINCT nome_gioc FROM formazione WHERE num_giornata='$giornata_cons2' AND id_campionato='$id_considerato'";
        $res4 = $cid->query($sql4) or die("<p>8.Impossibile eseguire la query.</p>"
  		                            . "<p>Codice errore " . $cid->errno . ": " . $cid->error) . "</p>";


        //assegno i voti a ogni giocatore
        while($nome_gioc = $res4->fetch_assoc()){
            $gioc_cons = $nome_gioc["nome_gioc"];
            $voto = rand(-1,10);
            $sql5 = "INSERT INTO valuta (voto, nome_giocatore, num_giornata, id_camp) VALUES ('$voto', '$gioc_cons', '$giornata_cons2','$id_considerato')";
            $res5 = $cid->query($sql5) or die("<p>9.Impossibile eseguire la query.</p>"
  		                            . "<p>Codice errore " . $cid->errno . ": " . $cid->error) . "</p>";
        }

        //assegno i punti alle squadre
        $sql5 = "SELECT DISTINCT squadra FROM compete WHERE campionato='$id_considerato'";
        $res5 = $cid->query($sql5) or die("<p>10.Impossibile eseguire la query.</p>"
  		                            . "<p>Codice errore " . $cid->errno . ": " . $cid->error) . "</p>";
        while($nome_sq = $res5->fetch_assoc()){
            $squadraInCamp = $nome_sq["squadra"];
            $punti = punteggio_squadra($cid, $squadraInCamp, $giornata_cons2, $id_considerato);
            
            se_35($cid, $id_considerato, $squadraInCamp, $punti);
            
        }

        echo "<div class=\"alert alert-success\">Operazione riuscita! è stata chiusa la giornata $giornata_cons2 e sono stati assegnati i voti ai giocatori !</div>";
        echo "<div class=\"text-center\">";
        echo "<input type=\"button\" value=\"Vai ad Amministra Campionati\" class=\"btn btn-primary btn-md btn-conf\"
                    onClick=\"window.location = 'http://localhost/calcetto/index.php?op=gestioneCampionati'\">";
        echo "</div>";
    }

?>


<!--
per ogni squadra in quel campionato devo controllare se è stata presentata la formazione per la giornata corrente.
se è stata presentata la formazione (quindi i giocatori sono stati inseriti dentro 'formazione') allora ok,
se non è stata presentata la formazione prendo la formazione della giornata precedente e inserisco quella per questa giornata.
una volta che tutti hanno la formazione inserita per questa giornata allora assegno i voti. -->
