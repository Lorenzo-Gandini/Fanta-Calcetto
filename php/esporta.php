<div>
    <form role="form" method="POST" action="index.php?op=esporta-exe">
        <?php
            include_once("funzioni.php");
            $squadra = $_SESSION["squadra"];

            $select = "SELECT DISTINCT campionato.nome FROM campionato, compete WHERE campionato.id=compete.campionato AND compete.squadra='$squadra'";
            $result = $cid->query($select) or die("<p>Impossibile eseguire la query.</p>"
                                       . "<p>Codice errore " . $cid->errno . ": " . $cid->error . "</p>");


            echo "<h1 class=\"text-center\"><strong>Esportazione classifiche</strong></h1>";
            echo "<h3 class=\"text-center titolo\">Scegli un campionato da cui esportare le classifiche</h3>";
            echo "<div class=\"mx-auto\" style=\"width: 50%\">";
                echo "<table class=\"table text-center col-md-5\">";
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
</div>
