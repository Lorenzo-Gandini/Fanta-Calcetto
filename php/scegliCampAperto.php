<div>
	<?php
		include_once "php/funzioni.php";

	    $squadra = $_SESSION["squadra"];
	    $nome;

		//se ho meno di 11 giocatori in squadra rimando a compra
		$nGioc = conta_giocatori($cid, $squadra);
		if($nGioc<11){
			echo "<div class=\"alert alert-danger\">Attenzione! Nella tua squadra mancano dei giocatori!</div>";
			echo "<div class=\"text-center\">";
			echo 	"<input type=\"button\" value=\"Compra giocatori\" class=\"btn btn-primary btn-md btn-conf\"
							onClick=\"window.location = 'http://localhost/calcetto/index.php?op=compra'\">";
			echo "</div>";
		}

		else{
			$sql = "SELECT campionato FROM compete WHERE squadra = '$squadra'";
		    $res = $cid->query($sql) or die("<p>Impossibile eseguire la query.</p>"
		                                            . "<p>Codice errore " . $cid->errno . ": " . $cid->error . "</p>");


		    while($id_camp = $res->fetch_assoc()) {
		        $id = $id_camp["campionato"];
		        $sql1 = "SELECT nome FROM campionato WHERE id = '$id'";
		        $res1 = $cid->query($sql1) or die("<p>2.Impossibile eseguire la query.</p>"
		                                                . "<p>Codice errore " . $cid->errno . ": " . $cid->error . "</p>");

		        $nom = $res1 -> fetch_row();
		        $nome[] = $nom[0];
		    }

		    echo "<h1 class=\"text-center\"><strong>Scegli i campionati aperti</strong></h1>";
		   // echo "<h3 class=\"text-center\">Presenta la tua formazione</h3>";
				echo "<br />";
		    echo "<form role=\"form\" name=\"campAperti\" method=\"POST\" action=\"index.php?op=visualizzaFormazione\">";
		    echo "<table class=\"table text-center\">";

		    foreach($nome as $nome_camp){
		        $sql = "SELECT id FROM campionato WHERE nome='$nome_camp'";
		        $res = $cid->query($sql) or die("<p>Impossibile eseguire la query.</p>"
		                                      . "<p>Codice errore " . $cid->errno . ": " . $cid->error) . "</p>";
		        $id_camp = $res->fetch_row();
		        $id_considerato = $id_camp[0];

		        $sql3 = "SELECT num_giornata FROM giornata WHERE id='$id_considerato' AND stato='1' ORDER BY num_giornata DESC ";
		        $res3 = $cid->query($sql3) or die("<p>3.Impossibile eseguire la query.</p>"
		                                      . "<p>Codice errore " . $cid->errno . ": " . $cid->error) . "</p>";
		        $giornata2 = $res3->fetch_row();
		        $giornata_cons2 = $giornata2[0];

		        $sql4 = "SELECT num_giornata FROM formazione WHERE id_campionato='$id_considerato' and num_giornata='$giornata_cons2' and nome_sq='$squadra'";
		        $res4 = $cid->query($sql4) or die("<p>4.Impossibile eseguire la query.</p>"
		                                      . "<p>Codice errore " . $cid->errno . ": " . $cid->error) . "</p>";
		        $gio = $res4->fetch_row();
		        $giornata_formazione = $gio[0];

		        //se la giornata del campionato è aperta
		        if(isset($giornata_cons2)&& !(isset($giornata_formazione))){
		            echo "<div class=\"mx-auto\">";
								echo "<tr>";
		            echo	"<th colspan=\"2\">$nome_camp
		       						&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
											&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
											&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
											&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
		                  <input type=\"checkbox\" name=\"nomeC[]\" value=\"$nome_camp\">
		                </th>";
		            echo "<tr>";
		            echo "</div>";
		        }
		        if(isset($giornata_formazione)){
		            echo "<tr><td>";
		                echo "<div class=\"alert alert-success\">Hai già presentato la formazione per $nome_camp</div>";
		            echo "</td></tr>";
		        }
		        if(!(isset($giornata_cons2))){
		            echo "<tr><td>";
		                echo "<div class=\"alert alert-danger\">La prossima giornata di $nome_camp non è stata ancora aperta</div>";
		            echo "</td></tr>";
		        }
		    }
		      echo "</table>";

		       echo "<div align=\"center\">";
		             echo "<input type=\"submit\" class=\"btn btn-primary col-md-3\" id=\"send\" value=\"Continua\"></input>";
		           echo " ";
		             echo "<input type=\"reset\" class=\"btn btn-danger btn-red col-md-3\" value=\"Cancella\"></input>";
		       echo "</div>";
		       echo "</form>";
		}


	?>

</div>
