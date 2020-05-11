<div>
    <?php
        include_once("funzioni.php");
        $campionato_cons = $_POST["nome_camp"];
        $xml;

        //seleziono l'id del campionato considerato dalla form.
        $sql1 = "SELECT id FROM campionato WHERE nome='$campionato_cons'";
        $res1 = $cid->query($sql1) or die("<p>1.Impossibile eseguire la query.</p>"
    		                               . "<p>Codice errore " . $cid->errno . ": " . $cid->error . "</p>");
        $id_this = $res1->fetch_row();
        $id_camp = $id_this[0];






/*CREAZIONE XML GIORNALIERO*/
        //seleziono l'ultima giornata chiusa
        $sql2 = "SELECT num_giornata FROM giornata WHERE id='$id_camp' AND stato=2 ORDER BY num_giornata DESC";
        $res2 = $cid->query($sql2) or die("<p>2.Impossibile eseguire la query.</p>"
                                           . "<p>Codice errore " . $cid->errno . ": " . $cid->error . "</p>");
        $giorn_this = $res2->fetch_row();
        $last_giornata = $giorn_this[0];

        $genere = "Giornaliera";
        $xml = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\"?>";
        $xml .= "\n";
        $xml .= "<!DOCTYPE CLASSIFICA SYSTEM \"classifica.dtd\">";
        $xml .= "\n";
        $xml .= "<CLASSIFICA genere=\"$genere\">";
        $xml .= "\n";
        $xml .= "\t";
        $xml .= "<CAMPIONATO nomeCampionato=\"$campionato_cons\" giornata=\"$last_giornata\">";
        $xml .= "\n";


        $sql3 = "SELECT punteggio, nome_squadra FROM punteggi WHERE id_campionato='$id_camp' AND num_giornata='$last_giornata' ORDER BY punteggio DESC";
        $res3 = $cid->query($sql3) or die("<p>3.Impossibile eseguire la query.</p>"
                                           . "<p>Codice errore " . $cid->errno . ": " . $cid->error . "</p>");

        while($punteggi_gior = $res3->fetch_assoc()) {
            $xml .= "\t\t";
            $xml .= "<SQUADRA nomeSquadra=\"$punteggi_gior[nome_squadra]\">";
            $xml .= "\n";
    		$xml .= "\t\t\t";
            $xml .= "<PUNTI>$punteggi_gior[punteggio]</PUNTI>";
            $xml .= "\n";
    		$xml .= "\t\t";
            $xml .= "</SQUADRA>";
            $xml .= "\n";
        }


        $xml .= "\t";
        $xml .= "</CAMPIONATO>";
        $xml .= "\n";
        $xml .= "</CLASSIFICA>";



        // Apro in scrittura il file
    	$fp = fopen("XML/classificaGiornaliera.xml", "w");
    	// Sostituisco tutto ciò che c'era scritto prima sul file con le nuove informazioni
    	fwrite($fp, $xml);
    	// Chiudo il file che abbiamo appena scritto
    	fclose($fp);

        //echo "<div class=\"alert alert-success\">Operazione riuscita! è stata esportata la classifica giornaliera!</div>";



/*CREAZIONE XML GENERALE*/

        //prendo i nomi delle squadre che competono in questo campionato
        $sql5 = "SELECT squadra FROM compete WHERE campionato='$id_camp'";
        $res5 = $cid->query($sql5) or die("<p>4.Impossibile eseguire la query.</p>"
                                           . "<p>Codice errore " . $cid->errno . ": " . $cid->error . "</p>");
        while ($sq = $res5->fetch_row()){
           $squadra = $sq[0];
           $puntiTotSquadra = classifica_utente($cid, $squadra, $id_camp);
           $arrSqPunti["$squadra"] = $puntiTotSquadra;
        }
        //ordino l'array
        arsort($arrSqPunti);

        $genere = "Generale";
        $xml = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\"?>";
        $xml .= "\n";
        $xml .= "<!DOCTYPE CLASSIFICA SYSTEM \"classifica.dtd\">";
        $xml .= "\n";
        $xml .= "<CLASSIFICA genere=\"$genere\">";
        $xml .= "\n";
        $xml .= "\t";
        $xml .= "<CAMPIONATO nomeCampionato=\"$campionato_cons\">";
        $xml .= "\n";


        while (list($chiave, $valore) = each($arrSqPunti)) {
            $xml .= "\t\t";
            $xml .= "<SQUADRA nomeSquadra=\"$chiave\">";
            $xml .= "\n";
    		$xml .= "\t\t\t";
            $xml .= "<PUNTI>$valore</PUNTI>";
            $xml .= "\n";
    		$xml .= "\t\t";
            $xml .= "</SQUADRA>";
            $xml .= "\n";
        }

        $xml .= "\t";
        $xml .= "</CAMPIONATO>";
        $xml .= "\n";
        $xml .= "</CLASSIFICA>";

        // Apro in scrittura il file
    	$fp = fopen("XML/classificaGenerale.xml", "w");
    	// Sostituisco tutto ciò che c'era scritto prima sul file con le nuove informazioni
    	fwrite($fp, $xml);
    	// Chiudo il file che abbiamo appena scritto
    	fclose($fp);

        //echo "<div class=\"alert alert-success\">Operazione riuscita! è stata esportata la classifica generale!</div>";
    ?>
    <h1 class="title"> <strong>Scarica le classifiche!</strong></h1>
    <br />
    <div class="mx-auto" style="width: 70%;">
        <h2 class="text-center titolo">Classifica Giornaliera</h2>
        <div align="center">
            <a href="XML/classificaGiornaliera.xml" download><button class="btn btn-primary">Download</button></a>
        </div>     <br />
        <h2 class="text-center titolo">Classifica Generale</h2>
        <div align="center">
            <a href="XML/classificaGenerale.xml" download><button class="btn btn-primary">Download</button></a>
        </div>
    </div>

</div>
