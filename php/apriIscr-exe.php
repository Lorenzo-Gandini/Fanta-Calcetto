<?php

    include_once("funzioni.php");

    $nome_camp = $_SESSION["nome_camp"];

    $sql = "SELECT id FROM campionato WHERE nome='$nome_camp'";
    $res = $cid->query($sql) or die("<p>Impossibile eseguire la query.</p>"
  		                            . "<p>Codice errore " . $cid->errno . ": " . $cid->error) . "</p>";
    $id_camp = $res->fetch_row();
    $id_considerato = $id_camp[0];

    //seleziono l'ultima giornata aperta
    $sql3 = "SELECT num_giornata FROM giornata WHERE id='$id_considerato' AND stato='1' ORDER BY num_giornata DESC ";
    $res3 = $cid->query($sql3) or die("<p>3.Impossibile eseguire la query.</p>"
  		                            . "<p>Codice errore " . $cid->errno . ": " . $cid->error) . "</p>";
    $giornata2 = $res3->fetch_row();
    $giornata_cons2 = $giornata2[0];

    if(isset($giornata_cons2)) {
        echo "<div class=\"alert alert-danger\">Attenzione! Devi chiudere la giornata in corso prima di aprirne un'altra!</div>";
        echo "<div class=\"text-center\">";
        echo "<input type=\"button\" value=\"Vai ad Amministra Campionati\" class=\"btn btn-primary btn-md btn-conf\"
                    onClick=\"window.location = 'http://localhost/calcetto/index.php?op=gestioneCampionati'\">";
        echo "</div>";
    }
    else {
        //seleziono il numero di giornate di un campionato
        $sel = "SELECT numero_giornate FROM campionato WHERE id='$id_considerato'";
        $res9 = $cid->query($sel) or die("<p>1.Impossibile eseguire la query.</p>"
                                        . "<p>Codice errore " . $cid->errno . ": " . $cid->error) . "</p>";
        $ultima = $res9->fetch_row();
        $ultima_gior = $ultima[0];
        
        //seleziono l'ultima giornata chiusa
        $sql7 = "SELECT num_giornata FROM giornata WHERE id='$id_considerato' AND stato='2' ORDER BY num_giornata DESC ";
        $res7 = $cid->query($sql7) or die("<p>3.Impossibile eseguire la query.</p>"
      		                            . "<p>Codice errore " . $cid->errno . ": " . $cid->error) . "</p>";
        $giorna = $res7->fetch_row();
        $giornata_cons = $giorna[0];

        if($ultima_gior == $giornata_cons){
            echo "<div class=\"alert alert-warning\">Il campionato si è concluso!</div>";
        }
        else{
            $sql1 = "SELECT num_giornata FROM giornata WHERE  id='$id_considerato' AND stato='0' ORDER BY num_giornata";
            $res1 = $cid->query($sql1) or die("<p>1.Impossibile eseguire la query.</p>"
                                            . "<p>Codice errore " . $cid->errno . ": " . $cid->error) . "</p>";
            $giornate = $res1->fetch_row();
            $giornata_cons = $giornate[0];

            $sql2 = "UPDATE giornata SET stato='1' WHERE id='$id_considerato' AND num_giornata='$giornata_cons'";
            $cid->query($sql2) or die("<p>2.Impossibile eseguire la query.</p>"
      		                            . "<p>Codice errore " . $cid->errno . ": " . $cid->error) . "</p>";

            echo "<div class=\"alert alert-success\">Operazione riuscita! è stata aperta la giornata $giornata_cons !</div>";
            echo "<div class=\"text-center\">";
            echo "<input type=\"button\" value=\"Vai ad Amministra Campionati\" class=\"btn btn-primary btn-md btn-conf\"
                        onClick=\"window.location = 'http://localhost/calcetto/index.php?op=gestioneCampionati'\">";
            echo "</div>";
        }

    }

?>
