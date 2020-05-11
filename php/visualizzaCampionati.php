<?php
	include_once "php/funzioni.php";

    $squadra = $_SESSION["squadra"];
    $nome;

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
?>

    <h1 class="text-center"><strong>I miei campionati</strong></h1>
    <br />
    <div class="mx-auto" style="width: 50%;">
       <table class="table text-center">
               <?php foreach($nome as $nome_camp) { ?>
                   <tr>
                    <td><?php echo "$nome_camp"; ?></td>
                    </tr>
               <?php } // end foreach ?>
       </table>
     </div>
