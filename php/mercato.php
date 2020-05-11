<?php
	include_once("funzioni.php");

    if(isset($_SESSION["squadra"])) { //se ha creato la squadra
    	$nomeSq = $_SESSION["squadra"];
    	$utente = $_SESSION["utente"]; //prendo il nick dell'utente

      $sql = "SELECT giocatori FROM composta WHERE squadra = '$nomeSq'";
    	$res1 = $cid->query($sql) or die("<p>Impossibile eseguire la query.</p>"
    		   										 . "<p>Codice errore " . $cid->errno . ": " . $cid->error) . "</p>";

    	if($res1->num_rows == 0) { // se l'utente non ha giocatori lo rimando a scegli giocatori
    		echo "<div class=\"alert alert-danger\">Attenzione! Non hai giocatori!</div>";
    		echo "<div class=\"text-center\">";
    		echo 	"<input type=\"button\" value=\"Seleziona i giocatori\" class=\"btn btn-primary btn-md btn-conf\"
    						onClick=\"window.location = 'http://localhost/calcetto/index.php?op=scegligiocatori'\">";
    		echo "</div>";
    	}
    	else {
    		$select = "SELECT fantacash FROM utente WHERE nickname = '$utente'";
    		$res2 = $cid->query($select) or die("<p>Impossibile eseguire la query.</p>"
    		                             . "<p>Codice errore " . $cid->errno . ": " . $cid->error . "</p>");
    		$row = $res2->fetch_row();
    		$fantamilioni = $row[0];

    		echo "<h2 class=\"text-center\"><strong>Qui puoi vendere i giocatori della tua squadra <em>$nomeSq</em></strong></h2>";
    		//echo "<h2 class=\"text-center\">$nomeSq</h2>";
    		echo "<h4 class=\"text-center titolo\">Seleziona i giocatori che vuoi vendere.</h4>";
				echo "<h6><br/>Hai a disposizione: <span id=\"fanta_m\">$fantamilioni</span> fantamilioni.<br/></h6>";

          $sql = "SELECT giocatori, ruolo, prezzo FROM composta JOIN giocatore ON (composta.giocatori = giocatore.nome) WHERE composta.squadra = '$nomeSq' ORDER BY ruolo, giocatori ASC";
        	$res = $cid->query($sql) or die("<p>Impossibile eseguire la query.</p>"
        		   										 . "<p>Codice errore " . $cid->errno . ": " . $cid->error) . "</p>";

    		echo "<form role=\"form\" name=\"vendiGiocatori\" method=\"POST\" action=\"php/vendi-exe.php\">";
    		echo "<table class=\"table text-center\">";
    		echo "<tr>";
    		echo 	"<th class=\"text-center\">Giocatore</th>";
    		echo 	"<th class=\"text-center\">Ruolo</th>";
    		echo	"<th class=\"text-center\">Quotazione</th>";
    		echo	"<th class=\"text-center\">Seleziona</th>";
    		echo "</tr>";
    		while($giocatore = $res->fetch_assoc()) {
				if($giocatore["ruolo"]=='P'){
					$color="por";
				}
				if($giocatore["ruolo"]=='A'){
					$color="att";
				}
				if($giocatore["ruolo"]=='D'){
					$color="dif";
				}
				if($giocatore["ruolo"]=='C'){
					$color="cen";
				}
    			echo "<tr class=\"$color\">";
    			echo	"<td>$giocatore[giocatori]</td>";
    			echo 	"<td>$giocatore[ruolo]</td>";
    			echo	"<td>$giocatore[prezzo]</td>";
    			echo	"<td>
										 <input type=\"checkbox\"
														value=\"$giocatore[giocatori]\"
														name=\"giocatoreVenduto[]\"
														onclick=\"aggiorna_cash(this,$giocatore[prezzo])\">
								 </td>";
    			echo "</tr>";
    		}
    		echo "</table>";
			echo "<div align=\"center\">";
    		echo "<input type=\"submit\" class=\"btn btn-primary col-md-3\" id=\"send\" value=\"Vendi\"/></input>";
			echo " ";
    		echo "<input type=\"reset\" class=\"btn btn-danger btn-red col-md-3\" value=\"Cancella\"/></input>";
			echo "</div>";
    		echo "</form>";
    	}

}
//se non ha creato la squadra
else{
    echo "<div class=\"alert alert-danger\">Attenzione! Devi creare una squadra prima!</div>";
    echo "<div class=\"text-center\">";
    echo 	"<input type=\"button\" value=\"Crea squadra\" class=\"bottone\"
                    onClick=\"window.location = 'http://localhost/calcetto/index.php?op=creaSquadra'\">";
    echo "</div>";
}




?>
