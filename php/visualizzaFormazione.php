<?php
	include_once("funzioni.php");
	$squadra = $_SESSION["squadra"];

//se ho selezionato almeno un campionato
	if(isset($_POST["nomeC"])){

		$campionati = $_POST["nomeC"];
		$_SESSION["nCampForm"] = $campionati;


		$select1 = "SELECT giocatori, ruolo FROM composta JOIN giocatore ON (composta.giocatori = giocatore.nome) WHERE composta.squadra = '$squadra' ORDER BY ruolo, giocatori ASC";
		$result1 = $cid->query($select1) or die("<p>Impossibile eseguire la query.</p>"
									  . "<p>Codice errore " . $cid->errno . ": " . $cid->error . "</p>");

		$modulo = 211;
		$nPor = 1;
		$nDif = 2;
		$nCen = 1;
		$nAtt = 1;
	?>


	<div>

	<form role="form" method="post" action="index.php?op=formazione-exe">
	<!--pulsanti-->
		<div class="mx-auto" align="center">
			<h1 class="text-center">Scegli la formazione</h1>
			<input type="reset" class="btn btn-primary btn-md btn-conf" value="2-1-1" onclick=<?php echo "aggiorna_mod1()"; ?>></input>
			<input type="reset" class="btn btn-primary btn-md btn-conf" value="1-2-1" onclick=<?php echo "aggiorna_mod2()"; ?>></input>
			<input type="reset" class="btn btn-primary btn-md btn-conf" value="1-1-2" onclick=<?php echo "aggiorna_mod3()"; ?>></input>
		</div>
        <hr/>

        <!-- div contenente l'elenco dei giocatori ancora da scegliere e l'elenco dei giocatori della mia squadra. -->

        <div class="row">
                            <!-- Valori che si aggiornano -->
            <div class="col-sm-3">
                <?php
                    echo "<h6>Portieri da scegliere : <strong><span id=\"m_por\"> $nPor </span></strong></h56>";
                    echo "<h6>Difensori da scegliere : <strong><span id=\"m_dif\"> $nDif </span></strong></h6>";
                    echo "<h6>Centrocampisti da scegliere : <strong><span id=\"m_cen\"> $nCen </span></strong></h6>";
                    echo "<h6>Attaccanti da scegliere : <strong><span id=\"m_att\"> $nAtt </span></strong></h6>";
                ?>
            </div>

            <!-- Lista dei giocatori -->
            <div class="col-sm-6">
                <!--<div class="mx-auto" style="width: 70%;"> -->

                 <?php
                    echo "<h3 class=\"text-center\">Scegli i titolari</h3>";
                    echo "<table class=\"table text-center\">";
                        while($nomeGioc = $result1->fetch_assoc()) {
                            if($nomeGioc["ruolo"]=='P'){
                                $ruolo = 0;
								$color="por";
                            }
                            if($nomeGioc["ruolo"]=='D'){
                                $ruolo = 1;
								$color="dif";
                            }
                            if($nomeGioc["ruolo"]=='C'){
                                $ruolo = 2;
								$color="cen";
                            }
                            if($nomeGioc["ruolo"]=='A'){
                                $ruolo = 3;
								$color="att";
                            }

                            echo "<tr class=\"$color\">";
                            echo	"<td>$nomeGioc[giocatori]</td>";
                            echo	"<td>$nomeGioc[ruolo]</td>";
                                                     ?>
                                        <td>
                                        <input 	type="checkbox"
                                                        name="nomeG[]"
                                                        value="<?php echo $nomeGioc["giocatori"]; ?>"
                                                        onclick="<?php echo "controlla_mod(this,$ruolo)"; ?>"></td>

                        <?php	echo "<tr>";
                        }
                    echo "</table>";
                ?>
            </div>
        </div>
        <?php
            echo "<div align=\"center\">";
            echo "<input type=\"submit\" class=\"btn btn-primary col-md-3\" id=\"send\" value=\"Continua\"></input>";
            echo "</div>";
        ?>


		</form>
    </div>




<?php } //end if

else {
	echo "<div class=\"alert alert-danger\">Attenzione! Devi selezionare almeno un campionato!</div>";
}

 ?>
