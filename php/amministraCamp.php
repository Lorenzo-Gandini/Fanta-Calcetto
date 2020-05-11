<?php
    $campionato_cons = $_POST["nome_camp"];
    $_SESSION["nome_camp"] = $campionato_cons;

    echo "<h1 class=\"text-center\"><strong>Gestione di $campionato_cons </strong></h1>";
?>
        <div class="mx-auto"><br/>
            <div class="col-md-6 offset-md-3">
                <a class="btn btn-primary btn-md btn-block btn-conf" href="index.php?op=apriIscr-exe" role="button">
                    Apri iscrizioni per la giornata
                </a>
            </div>
            <div class="col-md-6 offset-md-3"> <!--chiude le iscrizioni, la giornata attuale e genera valutazioni-->
                <a class="btn btn-primary btn-md btn-block  btn-conf" href="index.php?op=chiudiIscr-exe" role="button">
                    Chiudi iscrizioni e genera valutazioni
                </a>
            </div>
            <div class="col-md-6 offset-md-3">
                <a class="btn btn-primary btn-md btn-block  btn-conf" href="index.php?op=gestioneCampionati" role="button">
                    Indietro
                </a>
            </div><br/>
</div>

<?php
?>
