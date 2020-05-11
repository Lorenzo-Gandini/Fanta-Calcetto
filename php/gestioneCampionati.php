<form role="form" method="POST" action="index.php?op=amministraCamp">
	<?php
	        include_once("funzioni.php");

	    	$select = "SELECT DISTINCT nome FROM campionato";
		    $result = $cid->query($select) or die("<p>Impossibile eseguire la query.</p>"
		                               . "<p>Codice errore " . $cid->errno . ": " . $cid->error . "</p>");

			echo "<h1 class=\"text-center\"><strong>Scegli il campionato da gestire</strong></h1><br/>";
	        echo "<div class=\"mx-auto\" style=\"width: 50%\">";
	            echo "<table class=\"table text-center \">";
	            while($nomeCamp = $result->fetch_assoc()) {
	                echo "<tr>";
	                echo "<td>
	                            <input type=\"submit\" class=\"btn btn-primary btn-md btn-conf\" name=\"nome_camp\" value=\"$nomeCamp[nome]\">
	                        </td>";
	                echo "</tr>";
	            }
	            echo "</table>";
	        echo "</div>";

	?>
</form>
