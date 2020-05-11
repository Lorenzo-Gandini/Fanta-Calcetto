
<?php

    include_once("funzioni.php");
    $campionato_cons = $_POST["nome_camp"];
    $nomeSq = $_SESSION["squadra"];
    $posD = 0;
    $posG = 0;

    //seleziono l'id del campionato considerato dalla form.
    $sql1 = "SELECT id FROM campionato WHERE nome='$campionato_cons'";
    $res1 = $cid->query($sql1) or die("<p>1.Impossibile eseguire la query.</p>"
		                               . "<p>Codice errore " . $cid->errno . ": " . $cid->error . "</p>");
    $id_this = $res1->fetch_row();
    $id_camp = $id_this[0];

    //seleziono l'ultima giornata chiusa
    $sql2 = "SELECT num_giornata FROM giornata WHERE id='$id_camp' AND stato=2 ORDER BY num_giornata DESC";
    $res2 = $cid->query($sql2) or die("<p>2.Impossibile eseguire la query.</p>"
                                       . "<p>Codice errore " . $cid->errno . ": " . $cid->error . "</p>");
    $giorn_this = $res2->fetch_row();
    $last_giornata = $giorn_this[0];

    echo "<h2 class=\"title\"><strong>$campionato_cons</strong></h2>";
    echo "<br />";
    echo "<br />";

    /* VOTI MIEI GIOCATORI*/
    echo "<div class=\"row\">";
        echo "<div class=\"col-sm-4\">";
            //Seleziono tutti i giocatori della mia squadra
            $sql6 = "SELECT giocatori FROM composta WHERE squadra = '$nomeSq'";
            $res6 = $cid->query($sql6) or die("<p>6. Impossibile eseguire la query.</p>"
                                                         . "<p>Codice errore " . $cid->errno . ": " . $cid->error) . "</p>";
            echo "<h4 class=\"title titolo\">Voti dei miei giocatori</h4>";
            echo "<div align=\"center\">";
                echo "<table class=\"table text-center\" align=\"center\">";
                echo "<tr>";
                    echo 	"<th style=\"width: 200px;\">Nome</th>";
                    echo 	"<th>Voto</th>";
                echo "</tr>";

                //prendo lo stato dei giocatori della mia formazione di questa giornata
                $sql9 = "SELECT stato_gioc FROM formazione WHERE nome_sq=' ' AND num_giornata=' ' AND id_campionato=''";
                $res9 = $cid->query($sql9) or die("<p>9.Impossibile eseguire la query.</p>"
                                               . "<p>Codice errore " . $cid->errno . ": " . $cid->error . "</p>");


                while($nome = $res6->fetch_assoc()) {
                    //Seleziono il giocatore dalla tabella valuta, prendendo l'id del campionato e il numero della giornata come parametri.
                    $sql7 = "SELECT nome_giocatore, voto, stato_gioc FROM valuta JOIN formazione ON(valuta.nome_giocatore=formazione.nome_gioc) WHERE valuta.id_camp='$id_camp' AND
                    valuta.num_giornata='$last_giornata' AND valuta.nome_giocatore='$nome[giocatori]' AND
                    formazione.nome_sq='$nomeSq' AND formazione.num_giornata='$last_giornata' AND formazione.id_campionato='$id_camp'";
                    $res7 = $cid->query($sql7) or die("<p>7.Impossibile eseguire la query.</p>"
                                                   . "<p>Codice errore " . $cid->errno . ": " . $cid->error . "</p>");
                    while($nome_play = $res7->fetch_assoc()) {
                       $color = "";
                       if($nome_play["stato_gioc"] == 1) {
                           $color = "titolari";
                       }
                       echo "<tr class=\"$color\">";
                           echo	"<td>$nome_play[nome_giocatore]</td>";
                           echo 	"<td>$nome_play[voto]</td>";
                       echo "</tr>";
                    }
                }
                echo "</table>";
            echo "</div>";
        echo "</div>"; //end col sm 4

    /*CLASSIFICA GIORNALIERA */
        echo "<div class=\"col-sm-4\">";
            //prendo il punteggio e la squadra che hanno giocato in questa giornata in questo campionato e li ordino
            $sql3 = "SELECT punteggio, nome_squadra FROM punteggi WHERE id_campionato='$id_camp' AND num_giornata='$last_giornata' ORDER BY punteggio DESC";
            $res3 = $cid->query($sql3) or die("<p>3.Impossibile eseguire la query.</p>"
                                               . "<p>Codice errore " . $cid->errno . ": " . $cid->error . "</p>");

            echo "<h4 class=\"title titolo\">Classifica giornaliera</h4>";
            echo "<div class=\"mx-auto\">";
                echo "<table class=\"table text-center\">";
                echo "<tr>";
                    echo 	"<th align=\"right\">Posizione</th>";
                    echo 	"<th>Squadra</th>";
                    echo 	"<th>Punteggio</th>";
                echo "</tr>";
                        while($punteggi_gior = $res3->fetch_assoc()) {
                            $posD++;
                            echo "<tr>";
                            echo	"<td>$posD</td>";
                            echo	"<td>$punteggi_gior[nome_squadra]</td>";
                            echo 	"<td>$punteggi_gior[punteggio]</td>";
                            echo "</tr>";
                        }
                echo "</table>";
            echo "</div>";

            $top_c = top_coach($cid, $id_camp, $last_giornata, $nomeSq);
            if($top_c){
                echo "<div align=\"center\">";
                echo "<div class=\"alert alert-success\">Congratulazioni! Sei un TOP COACH!</div>";
                echo "</div>";
            }
        echo "</div>"; //end col sm 5

        /* CLASSIFICA GENERALE */
        echo "<div class=\"col-sm-4\">";
            echo "<h4 class=\"title titolo\">Classifica generale</h4>";
            echo "<div class=\"mx-auto\">";
                echo "<table class=\"table text-center\">";
                echo "<tr>";
                    echo 	"<th align=\"right\">Posizione</th>";
                    echo 	"<th>Squadra</th>";
                    echo 	"<th>Punteggio</th>";
                echo "</tr>";
                //prendo i nomi delle squadre che competono in questo campionato
                $sql5 = "SELECT squadra FROM compete WHERE campionato='$id_camp'";
                $res5 = $cid->query($sql5) or die("<p>5.Impossibile eseguire la query.</p>"
                                                   . "<p>Codice errore " . $cid->errno . ": " . $cid->error . "</p>");
                while ($sq = $res5->fetch_row()){
                   $squadra = $sq[0];
                   $puntiTotSquadra = classifica_utente($cid, $squadra, $id_camp);
                   $arrSqPunti["$squadra"] = $puntiTotSquadra;
                }
                //ordino l'array
                arsort($arrSqPunti);

                while (list($chiave, $valore) = each($arrSqPunti)) {
                    $posG++;
                    echo "<tr>";
                    echo	"<td>$posG</td>";
                    echo	"<td>$chiave</td>";
                    echo 	"<td>$valore</td>";
                    echo "</tr>";
                }

                echo "</table>";
            echo "</div>";
            echo "<div align=\"center\">";
                echo last_35($cid, $id_camp, $nomeSq);
            echo"</div>";

        echo "</div>"; //col sm 4

    echo "</div>"; //end div row

    echo "<br />";
    echo "<br />";

?>
