<?php
    include_once("funzioni.php");
    $squadra = $_SESSION["squadra"];
    $nome_camp = $_POST["nomeC"];

    if(isset($nome_camp)){
        foreach($nome_camp as $questo_camp){
            $sql = "SELECT id FROM campionato WHERE nome='$questo_camp'";
            $res = $cid->query($sql) or die("<p>Impossibile eseguire la query.</p>"
                                            . "<p>Codice errore " . $cid->errno . ": " . $cid->error) . "</p>";
            $id_camp = $res->fetch_row();
            $id_considerato = $id_camp[0];

            $sql1 = "INSERT INTO compete (squadra, campionato) VALUES ('$squadra','$id_considerato')";
            $res1 = $cid->query($sql1) or die("<p>1.Impossibile eseguire la query.</p>"
                                            . "<p>Codice errore " . $cid->errno . ": " . $cid->error) . "</p>";
            echo "<div class=\"alert alert-success\">Operazione riuscita! Sei iscritto al campionato $questo_camp</div>";
        }

        echo "<div class=\"alert alert-warning\">ATTENZIONE! Presenta subito una formazione per i campionati in cui ti sei iscritto, altrimenti non portai partecipare!</div>";
        echo "<div class=\"text-center\">";
        echo "<input type=\"button\" value=\"Presenta formazione\" class=\"btn btn-primary btn-md btn-conf\"
                onClick=\"window.location = 'http://localhost/calcetto/index.php?op=scegliCampAperto'\">";
        echo "</div>";
    }
    else{
        echo "<div class=\"alert alert-danger\">Attenzione! devi selezionare almeno un campionato!</div>";
        echo "<div class=\"text-center\">";
        echo "<input type=\"button\" value=\"Vai ad Campionati in corso\" class=\"btn btn-primary btn-md btn-conf\"
                    onClick=\"window.location = 'http://localhost/calcetto/index.php?op=iscriviCamp'\">";
        echo "</div>";
    }



?>
