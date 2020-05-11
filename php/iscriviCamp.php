<div>
	<form role="form" method="post" action="index.php?op=iscriviCamp-exe">
		<?php
			include_once("funzioni.php");

			$squadra = $_SESSION["squadra"];

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
				$select = "SELECT DISTINCT nome FROM campionato WHERE id NOT IN (SELECT campionato FROM compete WHERE squadra='$squadra')";
				$result = $cid->query($select) or die("<p>Impossibile eseguire la query.</p>"
				                              . "<p>Codice errore " . $cid->errno . ": " . $cid->error . "</p>");



					echo "<h1 class=\"text-center\"><strong>Campionati in corso</strong></h1>";
					echo "<table class=\"table text-center\">";
					echo 	"<tr>";
					echo 		"<th class=\"text-center\">Campionato</th>";
					echo		"<th class=\"text-center\">Iscriviti</th>";
					echo	"</tr>";
						while($nomeCamp = $result->fetch_assoc()) {
							echo "<tr>";
							echo	"<td>$nomeCamp[nome]</td>";
							echo	"<td>
										<input type=\"checkbox\" name=\"nomeC[]\" value=\"$nomeCamp[nome]\">
									</td>";
							echo "<tr>";
						}
					echo "</table>";

					echo "<div align=\"center\">";
					      echo "<input type=\"submit\" class=\"btn btn-primary col-md-3\" id=\"send\" value=\"Continua\"></input>";
						  echo " ";
					      echo "<input type=\"reset\" class=\"btn btn-danger btn-red col-md-3\" value=\"Cancella\"></input>";
					echo "</div>";


			}
			?>
		</form>

</div>
