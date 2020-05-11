<?php session_start();?>

<!DOCTYPE html>
<html lang="en">
  <meta charset="UTF-8">

    <?php include_once "common/header.html"; ?>


  <body>
    <?php
        include_once "common/navigation.php";
        include_once "php/funzioni.php";
    ?>

    <div class="container">

      <?php

      // gestisco le notifiche di successo o insuccesso nell'esecuzione di una funzionalità
      				if(isset($_GET["stato"])) {
      					if($_GET["stato"]=="ok") {
      						echo "Operazione conclusa con successo.";
      					}
      					else {
      						echo "Errore. ". urldecode($_GET["msg"]);
      					}
      				}

      //se sei utente
      if(isset($_SESSION["utente"])) {

        if(isset($_GET["op"])) {
          include_once "php/". $_GET["op"] . ".php";
        }

        else {
          echo "<h1>Ciao $_SESSION[utente]!</h1>";
echo "<br />";
echo "<br />";
          if(isset($_SESSION["squadra"])) {
              //faccio vedere a che posizione sei nel campionato generale
              $id_camp = 1;
              $sq = $_SESSION["squadra"];

              $sql2 = "SELECT num_giornata FROM giornata WHERE id='$id_camp' AND stato=2 ORDER BY num_giornata DESC";
              $res2 = $cid->query($sql2) or die("<p>2.Impossibile eseguire la query.</p>"
                                                 . "<p>Codice errore " . $cid->errno . ": " . $cid->error . "</p>");
              $giorn_this = $res2->fetch_row();
              $last_giornata = $giorn_this[0];

                                                /*CLASSIFICA GIORNALIERA */
              //prendo il punteggio e la squadra che hanno giocato in questa giornata in questo campionato e li ordino
              $sql3 = "SELECT punteggio FROM punteggi WHERE id_campionato='$id_camp' AND num_giornata='$last_giornata' AND nome_squadra='$sq'";
              $res3 = $cid->query($sql3) or die("<p>3.Impossibile eseguire la query.</p>"
                       . "<p>Codice errore " . $cid->errno . ": " . $cid->error . "</p>");
              $punteggo = $res3->fetch_row();
              $punteggo_gior = $punteggo[0];
              echo "La tua squadra <b>$sq</b> in questa <b>giornata $last_giornata</b>  del campionato generale ha ottenuto <b>$punteggo_gior punti</b>!";
              echo "<br />";
              echo "<br />";

                                                    /* CLASSIFICA GENERALE */
              //prendo i nomi delle squadre che competono in questo campionato
              $sql5 = "SELECT squadra FROM compete WHERE campionato='$id_camp'";
              $res5 = $cid->query($sql5) or die("<p>5.Impossibile eseguire la query.</p>"
                                                 . "<p>Codice errore " . $cid->errno . ": " . $cid->error . "</p>");
              while ($squ = $res5->fetch_row()){
                 $squadra = $squ[0];
                 $puntiTotSquadra = classifica_utente($cid, $squadra, $id_camp);
                 $arrSqPunti["$squadra"] = $puntiTotSquadra;
              }
              $pos=0;
              //ordino l'array
              arsort($arrSqPunti);
              while (list($chiave, $valore) = each($arrSqPunti)) {
                  $pos++;
                  if("$chiave" == "$sq"){
                      echo	"La tua squadra <b>$chiave</b>  nel campionato generale è in <b>posizione $pos</b>  con <b>$valore punti</b>.";
                      echo "<br />";
                      $camp = $pos;
                  }
              }

              //se il campionato generale è finito e sei primo sei il campione
              if($last_giornata==38 && $camp==1){
                  echo "<br />";
                  echo "<br />";
                  echo "<div class=\"alert alert-success\" role=\"alert\">";
                    echo "<h1><strong><u>Complimenti! Sei il Campione del Campionato Generale!</u></strong></h1>";
                  echo "</div>";
              }

          }
          else{
              echo "<div class=\"alert alert-danger\">Attenzione! Non hai ancora creato una squadra! Vai subito a crearne una.</div>";
              echo "<div class=\"text-center\">";
              echo "<input type=\"button\" value=\"Crea Squadra\" class=\"btn btn-primary btn-md btn-conf\"
                          onClick=\"window.location = 'http://localhost/calcetto/index.php?op=creaSquadra'\">";
              echo "</div>";
          }


        }

      }

      //se non hai ancora effettuato l'accesso
      else {

        if(isset($_GET["op"]))
          include_once "php/". $_GET["op"] . ".php";

        else {
          if(isset($_COOKIE["user"])) {
            echo "<h1>Ciao $_COOKIE[user]!</br>
                Sei sul sito del Fantacalcetto Statale.</br>
                Per accedere ai servizi devi autenticarti.</h1>";
          }
          else {
            echo "<h1>Sito ufficiale FantacalcettoStatale.</h1>";
            echo "<h4>Per accedere ai servizi è necessario autenticarsi.</h4>";
          }
        }
      } //end else
      ?>

    </div>


      <?php include_once "common/footer.html"; ?>

    </body>
</html>
