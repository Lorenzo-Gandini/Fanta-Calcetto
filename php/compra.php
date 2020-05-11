<h1 class="text-center"><strong>Compra i nuovi giocatori</strong></h1>
<br />
<?php
	include_once "php/funzioni.php";

	$utente = $_SESSION["email"];
    $nomeSq = $_SESSION["squadra"];
	$query_fantac = "SELECT fantacash FROM utente WHERE email = '$utente'";
	$res = $cid->query($query_fantac) or die("<p>Impossibile eseguire la query.</p>" . "<p>Codice errore " . $cid->errno . ": " . $cid->error . "</p>");
	$row = $res->fetch_row();
    $fantacash = $row[0];

    //funzione
    $ruoli_insq = ruoli_gioc($nomeSq, $cid);

    $nPor = 2 - $ruoli_insq[0];
    $nDif = 3 - $ruoli_insq[1];
    $nCen = 3 - $ruoli_insq[2];
    $nAtt = 3 - $ruoli_insq[3];


    $sql = "SELECT nome, squadra, prezzo, ruolo FROM giocatore WHERE nome NOT IN (SELECT giocatori FROM composta WHERE squadra='$nomeSq')";
    $por = $cid->query($sql) or die("<p>Impossibile eseguire la query.</p>"
                                            . "<p>Codice errore " . $cid->errno . ": " . $cid->error . "</p>");
    $dif = $cid->query($sql) or die("<p>Impossibile eseguire la query.</p>"
                                            . "<p>Codice errore " . $cid->errno . ": " . $cid->error . "</p>");
    $cen = $cid->query($sql) or die("<p>Impossibile eseguire la query.</p>"
                                            . "<p>Codice errore " . $cid->errno . ": " . $cid->error . "</p>");
    $att = $cid->query($sql) or die("<p>Impossibile eseguire la query.</p>"
                                            . "<p>Codice errore " . $cid->errno . ": " . $cid->error . "</p>");
?>

  <form role="form" method="POST" action="php/scegliGio-exe.php">
	   <!-- Navbar per scegliere i ruoli -->
        <div class="cont-scroll">
            <div class="row">
                <div class="col-3">
                    <div id="list-giocatori" class="list-group">
                      <a class="list-group-item list-group-item-action list-group-item-2 active" href="#list-item-portieri">Portieri</a>
                      <a class="list-group-item list-group-item-action list-group-item-2" href="#list-item-difensori">Difensori</a>
                      <a class="list-group-item list-group-item-action list-group-item-2" href="#list-item-centrocampisti">Centrocampisti</a>
                      <a class="list-group-item list-group-item-action list-group-item-2" href="#list-item-attaccanti">Attaccanti</a>
                    </div>
                    <div id="list-comunicazioni" class="list-group"><?php
                        echo "<h6><br/><b>Fantamilioni rimasti:</b> <span id=\"fanta_c\">$fantacash</span> <br/></h6>";
                        echo "<h6><b>Portieri da scegliere:</b> <span id=\"f_por\"> $nPor </span><br/></h6>";
                        echo "<h6><b>Difensori da scegliere:</b> <span id=\"f_dif\"> $nDif </span><br/></h6>";
                        echo "<h6><b>Centrocampisti da scegliere:</b> <span id=\"f_cen\"> $nCen </span><br/></h6>";
                        echo "<h6><b>Attaccanti da scegliere:</b> <span id=\"f_att\"> $nAtt </span><br/></h6>";  ?>

                    </div>
                </div>
                <div class="col-9 list-scrolling"  data-spy="scroll" >
                    <div data-target="#list-giocatori" data-offset="0" class="scrollspy-example">
                         <br /><h4 id="list-item-portieri"><strong>PORTIERI</strong></h4>
                            <table class="table text-center">
                                    <?php while($portieri = $por->fetch_assoc()) { ?>
                                        <?php if($portieri["ruolo"]=='P'){ ?>
                                            <tr class="por"><td> <input type="checkbox"
                                                            name="por[]"
                                                            value="<?php echo $portieri["nome"]; ?> "
                                                            onclick="<?php echo "aggiorna_por(this,$portieri[prezzo])"; ?>"></td>
                                            <td> <?php echo $portieri["nome"]; ?> </td>
                                            <td> <?php echo $portieri["squadra"]; ?> </td>
                                            <td> <?php echo $portieri["prezzo"]; ?> </td>
                                            <td> <?php echo $portieri["ruolo"]; ?> </td></tr>
                                        <?php } // end if ?>
                                    <?php } // end while ?>
                            </table>


                            <br />
                        <br /><h4 id="list-item-difensori"><strong>DIFENSORI</strong></h4>
                          <table class="table text-center">
                                    <?php while($difensori = $dif->fetch_assoc()) { ?>
                                        <?php if($difensori["ruolo"]=='D'){ ?>
                                            <tr class="dif"><td> <input type="checkbox"
                                                            name="dif[]"
                                                            value="<?php echo $difensori["nome"]; ?>"
                                                            onclick="<?php echo "aggiorna_dif(this,$difensori[prezzo])"; ?>"></td>
                                            <td> <?php echo $difensori["nome"]; ?> </td>
                                            <td> <?php echo $difensori["squadra"]; ?> </td>
                                            <td> <?php echo $difensori["prezzo"]; ?> </td>
                                            <td> <?php echo $difensori["ruolo"]; ?> </td></tr>
                                        <?php } // end if ?>
                                    <?php } // end while ?>
                            </table><br />
                          <br /><h4 id="list-item-centrocampisti"><strong>CENTROCAMPISTI</strong></h4>
                           <table class="table text-center">
                                    <?php while($centrocampisti = $cen->fetch_assoc()) { ?>
                                        <?php if($centrocampisti["ruolo"]=='C'){ ?>
                                            <tr class="cen"><td> <input type="checkbox"
                                                            name="cen[]"
                                                            value="<?php echo $centrocampisti["nome"]; ?>"
                                                            onclick="<?php echo "aggiorna_cen(this,$centrocampisti[prezzo])"; ?>"></td>
                                            <td> <?php echo $centrocampisti["nome"]; ?> </td>
                                            <td> <?php echo $centrocampisti["squadra"]; ?> </td>
                                            <td> <?php echo $centrocampisti["prezzo"]; ?> </td>
                                            <td> <?php echo $centrocampisti["ruolo"]; ?> </td></tr>
                                        <?php } // end if ?>
                                    <?php } // end while ?>
                            </table><br />
                          <br /><h4 id="list-item-attaccanti"><strong>ATTACCANTI</strong></h4>
                            <table class="table text-center">
                            <?php while($attaccanti = $att->fetch_assoc()) { ?>
                                        <?php if($attaccanti["ruolo"]=='A'){ ?>
                                            <tr class="att"><td> <input type="checkbox"
                                                            name="att[]"
                                                            value="<?php echo $attaccanti["nome"]?>"
                                                            onclick="<?php echo "aggiorna_att(this,$attaccanti[prezzo])"; ?>"></td>
                                            <td> <?php echo $attaccanti["nome"]; ?> </td>
                                            <td> <?php echo $attaccanti["squadra"]; ?> </td>
                                            <td> <?php echo $attaccanti["prezzo"]; ?> </td>
                                            <td> <?php echo $attaccanti["ruolo"]; ?> </td></tr>
                                        <?php } // end if ?>
                                    <?php } // end while ?>
                                 </table><br />
                    </div>
                </div>
            </div>
        </div>


        <div align="center">
            <input type="submit" class="btn btn-primary col-md-3" id="send" value="Continua"></input>
            <input type="reset" class="btn btn-danger btn-red col-md-3" value="Cancella"></input>
        </div>

  </form>
