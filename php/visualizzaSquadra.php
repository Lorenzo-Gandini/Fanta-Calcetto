<?php
	include_once "php/funzioni.php";

	$nomeSq = $_SESSION["squadra"];

	$sql = "SELECT giocatori, ruolo FROM composta JOIN giocatore ON (composta.giocatori = giocatore.nome) WHERE composta.squadra = '$nomeSq' ORDER BY ruolo, giocatori ASC";
	$res = $cid->query($sql) or die("<p>Impossibile eseguire la query.</p>"
		   										 . "<p>Codice errore " . $cid->errno . ": " . $cid->error) . "</p>";



echo "<h2 class=\"title\"> <strong>$nomeSq</strong> </h2>";
echo "<br />";
echo "<h4 class=\"title\"> $_SESSION[motto]</h4>";
echo "<br />";

echo "<div class=\"mx-auto\" style=\"width: 70%;\">";

echo "<table class=\"table text-center\">";
echo "<tr>";
			echo 	"<th align=\"right\">Nome</th>";
			echo 	"<th>Ruolo</th>";
echo "</tr>";
		while($nome = $res->fetch_assoc()) {
			if($nome["ruolo"]=='P'){
				$color="por";
			}
			if($nome["ruolo"]=='A'){
				$color="att";
			}
			if($nome["ruolo"]=='D'){
				$color="dif";
			}
			if($nome["ruolo"]=='C'){
				$color="cen";
			}
				echo "<tr class=\"$color\">";
				echo	"<td>$nome[giocatori]</td>";
				echo 	"<td>$nome[ruolo]</td>";
				echo "</tr>";
			}

echo "</table>";

echo "</div>";
?>
