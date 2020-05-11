<div class="container">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <!-- navbar sinistra. Logo + Home-->
        <div class="navbar-header">
            <a href="index.php" class="btn btn-secondary" role="button" id="LogoHome" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-futbol fa-lg" aria-hidden="true"></i> Home
            </a>
        </div>

        <!-- icona per menu quando la pagina si restringe. data-target: imposta il nome dell'oggetto che deve comparire all'interno del menu -->
        <button class="navbar-toggler justify-content-md-center" type="button" data-toggle="collapse" data-target="#navbarcentral" aria-controls="navbarsExample04" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- navbar centrale. Bottoni con dropdown  -->
        <div class="collapse navbar-collapse justify-content-md-center" id="navbarcentral">
            <ul class="nav navbar-nav ">
              <?php if(isset($_SESSION["utente"])) { ?> <!-- se l'utente si è loggato vede il menu-->
                <!-- Menu inerente Squadra-->
                <li class="nav-item dropdown">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownSquadra" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Squadra</button>
                <div class="dropdown-menu" aria-labelledby="dropdownSquadra">
                    <a class="dropdown-item" href="index.php?op=visualizzaSquadra">La mia squadra</a>
                    <a class="dropdown-item" href="index.php?op=scegliCampAperto">Schiera formazione</a>
                    <!--<a class="dropdown-item" href="index.php?op=creaSquadra">Crea la tua squadra</a> -->
                    <!--<a class="dropdown-item" href="index.php?op=scegliGiocatori">Scegli giocatori</a> -->
                </div>
                </li>
                <!-- Menu inerente Mercato -->
                <li class="nav-item dropdown">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMercato" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Mercato</button>
                  <div class="dropdown-menu" aria-labelledby="dropdownMercato">
                    <a class="dropdown-item" href="index.php?op=mercato">Compravendita giocatori</a>
                  </div>
              </li>

                <!-- Menu inerente Campionato -->
                <li class="nav-item dropdown">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownCampionati" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Campionati</button>
                  <div class="dropdown-menu" aria-labelledby="dropdownCampionati">
                    <a class="dropdown-item" href="index.php?op=visualizzaCampionati">I miei campionati</a> <!--vedi i campionati in sui sei iscritto-->
                    <a class="dropdown-item" href="index.php?op=iscriviCamp">Iscrizioni campionati</a> <!--vedi tutti i campionati e puoi iscriverti-->
                    <a class="dropdown-item" href="index.php?op=classifica">Classifiche</a> <!--classifica generale e giornaliera e valutazioni giocatori -->
                    <a class="dropdown-item" href="index.php?op=esporta">Esporta classifiche</a> <!-- esporta classifiche-->
                  </div>
              </li>
                <!-- Menu inerente Profilo -->
                <li class="nav-item dropdown">
                <a class="btn btn-primary" id="dropdownProfilo" aria-haspopup="true" aria-expanded="false" href="index.php?op=visualizzaProfilo">Profilo</a>

              </li>
                <?php
        					$tipo = $_SESSION["tipo"];
        					if($tipo == '1' || $tipo == '2') { // se l'utente è commissario 1 o amministratore 2
  				      ?>
                <!-- Menu inerente Amministrazione -->
                <li class="nav-item dropdown">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownAmministrazione" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Amministrazione</button>
                  <div class="dropdown-menu" aria-labelledby="dropdownAmministrazione">
                    <a class="dropdown-item" href="index.php?op=creaCamp">Crea campionato</a>
                            <?php
            					$tipo = $_SESSION["tipo"];
            					if($tipo == '2') { // se l'utente è amministratore 2
      				        ?>
                    <a class="dropdown-item" href="index.php?op=gestioneCampionati">Gestisci Campionati</a>
                            <?php }?>
                  </div>
              </li>
            <?php } }
            else{  ?>
              <a href="index.php?op=info" class="btn btn-secondary" role="button" id="info" aria-haspopup="true" aria-expanded="false">
                  <i class="fas fa-info-circle" aria-hidden="true"></i> Info
              </a>
            <?php  } ?>
            </ul>
        </div>

        <!-- navbar destra. Contiene LogIn  -->
        <ul class="nav navbar-nav navbar-right">


            <div class="dropdown">
              <!-- Modal Registrazione (va messo qui se no non funziona)-->
                <div class="modal fade" id="registratiModal" tabindex="-1" role="dialog" aria-labelledby="registModalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="registModalLabel">  Registrazione nuovo utente</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>


                      <div class="modal-body" align="center">
                        <div class="col-md-8 order-md-1">
                                 <form role="form" data-toggle="validator" method="POST" action="php/registrazione-exe.php">
                                   <div class="row">
                                     <div class="col-md-6 mb-3">
                                       <label for="nome">Nome</label>
                                       <input type="text" class="form-control" name="nome" placeholder="Nome">
                                     </div>

                                     <div class="col-md-6 mb-3">
                                       <label for="cognome">Cognome</label>
                                       <input type="text" class="form-control" name="cognome" placeholder="Cognome">
                                     </div>
                                   </div>

                                   <div class="form-group has-feedback">
                                     <label for="email">Email</label>
                                      <div class="input-group">
                                        <div class="input-group-prepend">
                                         <span class="input-group-text"><i class="fa fa-envelope" aria-hidden="true"></i></span>
                                        </div>
                                          <input type="email" class="form-control" name="email" placeholder="tu@esempio.it" data-type-error="Inserire mail valida" data-required-error="Inserire mail" required>
                                        </div>
                                        <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                        <div class="help-block with-errors"></div>
                                   </div>


                                  <div class="form-group">
                                    <label for="pw1">Password</label>
                                    <div>
                                      <div class="form-group has-feedback">
                                       <input type="password" data-minlength="6" class="form-control" id="pw1" name="pw1" placeholder="Password" data-minlength-error="Minimo 6 caratteri" required>
                                       <div class="help-block with-errors"></div>
                                   </div>

                                   <div class="form-group has-feedback">
                                       <input type="password" class="form-control" id="pw2" data-match="#pw1" data-match-error="Le password non corrispondono"  placeholder="Ripeti la password" required>
                                       <div class="help-block with-errors"></div>
                                   </div>
                                  </div>
                                 </div>

                                   <div class="form-group has-feedback">
                                     <label for="nickname">Nickname</label>
                                       <input type="text" class="form-control" name="nickname"  placeholder="Nickname" data-required-error="Inserire Nickname" required>
                                       <div class="help-block with-errors"></div>
                                   </div>



                                   <div class="form-group">
                                     <label for="dataN">Data di Nascita</label>
                                     <input type="date" class="form-control" name="dataN" placeholder="Data di Nascita">
                                   </div>

                                   <div class="row">
                                     <div class="col-md-6 mb-3">
                                       <label for="citta">Città</label>
                                       <input type="text" class="form-control" name="citta">
                                     </div>

                                     <div class="form-group col-md-6 mb-3">
                                       <label for="provincia">Provincia</label>
                                       <select class="custom-select d-block w-100" id="provincia">
                                          <option value="">Scegli...</option>
                                          <option value="ag">Agrigento</option>
                                        	<option value="al">Alessandria</option>
                                        	<option value="an">Ancona</option>
                                        	<option value="ao">Aosta</option>
                                        	<option value="ar">Arezzo</option>
                                        	<option value="ap">Ascoli Piceno</option>
                                        	<option value="at">Asti</option>
                                        	<option value="av">Avellino</option>
                                        	<option value="ba">Bari</option>
                                        	<option value="bt">Barletta-Andria-Trani</option>
                                        	<option value="bl">Belluno</option>
                                        	<option value="bn">Benevento</option>
                                        	<option value="bg">Bergamo</option>
                                        	<option value="bi">Biella</option>
                                        	<option value="bo">Bologna</option>
                                        	<option value="bz">Bolzano</option>
                                        	<option value="bs">Brescia</option>
                                        	<option value="br">Brindisi</option>
                                        	<option value="ca">Cagliari</option>
                                        	<option value="cl">Caltanissetta</option>
                                        	<option value="cb">Campobasso</option>
                                        	<option value="ci">Carbonia-iglesias</option>
                                        	<option value="ce">Caserta</option>
                                        	<option value="ct">Catania</option>
                                        	<option value="cz">Catanzaro</option>
                                        	<option value="ch">Chieti</option>
                                        	<option value="co">Como</option>
                                        	<option value="cs">Cosenza</option>
                                        	<option value="cr">Cremona</option>
                                        	<option value="kr">Crotone</option>
                                        	<option value="cn">Cuneo</option>
                                        	<option value="en">Enna</option>
                                        	<option value="fm">Fermo</option>
                                        	<option value="fe">Ferrara</option>
                                        	<option value="fi">Firenze</option>
                                        	<option value="fg">Foggia</option>
                                        	<option value="fc">Forl&igrave;-Cesena</option>
                                        	<option value="fr">Frosinone</option>
                                        	<option value="ge">Genova</option>
                                        	<option value="go">Gorizia</option>
                                        	<option value="gr">Grosseto</option>
                                        	<option value="im">Imperia</option>
                                        	<option value="is">Isernia</option>
                                        	<option value="sp">La spezia</option>
                                        	<option value="aq">L'aquila</option>
                                        	<option value="lt">Latina</option>
                                        	<option value="le">Lecce</option>
                                        	<option value="lc">Lecco</option>
                                        	<option value="li">Livorno</option>
                                        	<option value="lo">Lodi</option>
                                        	<option value="lu">Lucca</option>
                                        	<option value="mc">Macerata</option>
                                        	<option value="mn">Mantova</option>
                                        	<option value="ms">Massa-Carrara</option>
                                        	<option value="mt">Matera</option>
                                        	<option value="vs">Medio Campidano</option>
                                        	<option value="me">Messina</option>
                                        	<option value="mi">Milano</option>
                                        	<option value="mo">Modena</option>
                                        	<option value="mb">Monza e della Brianza</option>
                                        	<option value="na">Napoli</option>
                                        	<option value="no">Novara</option>
                                        	<option value="nu">Nuoro</option>
                                        	<option value="og">Ogliastra</option>
                                        	<option value="ot">Olbia-Tempio</option>
                                        	<option value="or">Oristano</option>
                                        	<option value="pd">Padova</option>
                                        	<option value="pa">Palermo</option>
                                        	<option value="pr">Parma</option>
                                        	<option value="pv">Pavia</option>
                                        	<option value="pg">Perugia</option>
                                        	<option value="pu">Pesaro e Urbino</option>
                                        	<option value="pe">Pescara</option>
                                        	<option value="pc">Piacenza</option>
                                        	<option value="pi">Pisa</option>
                                        	<option value="pt">Pistoia</option>
                                        	<option value="pn">Pordenone</option>
                                        	<option value="pz">Potenza</option>
                                        	<option value="po">Prato</option>
                                        	<option value="rg">Ragusa</option>
                                        	<option value="ra">Ravenna</option>
                                        	<option value="rc">Reggio di Calabria</option>
                                        	<option value="re">Reggio nell'Emilia</option>
                                        	<option value="ri">Rieti</option>
                                        	<option value="rn">Rimini</option>
                                        	<option value="rm">Roma</option>
                                        	<option value="ro">Rovigo</option>
                                        	<option value="sa">Salerno</option>
                                        	<option value="ss">Sassari</option>
                                        	<option value="sv">Savona</option>
                                        	<option value="si">Siena</option>
                                        	<option value="sr">Siracusa</option>
                                        	<option value="so">Sondrio</option>
                                        	<option value="ta">Taranto</option>
                                        	<option value="te">Teramo</option>
                                        	<option value="tr">Terni</option>
                                        	<option value="to">Torino</option>
                                        	<option value="tp">Trapani</option>
                                        	<option value="tn">Trento</option>
                                        	<option value="tv">Treviso</option>
                                        	<option value="ts">Trieste</option>
                                        	<option value="ud">Udine</option>
                                        	<option value="va">Varese</option>
                                        	<option value="ve">Venezia</option>
                                        	<option value="vb">Verbano-Cusio-Ossola</option>
                                        	<option value="vc">Vercelli</option>
                                        	<option value="vr">Verona</option>
                                        	<option value="vv">Vibo valentia</option>
                                        	<option value="vi">Vicenza</option>
                                          <option value="vt">Viterbo</option>
                                       </select>
                                     </div>
                                   </div>

                                   <div class="form-group">
                                     <label for="squadra_cuore">Squadra del Cuore</label>
                                     <input type="text" class="form-control" name="squadra_cuore">
                                   </div>

                                   <hr class="mb-8">
                                   <div align="center">
                                        <input type="submit" class="btn btn-primary col-md-5" value="Continua"></input>
                                        <input type="reset" class="btn btn-danger btn-red col-md-5" value="Annulla"></input>
                                   </div>

                                 </form>
                               </div>
                             </div>

                      </div>
                    </div>
                  </div>
                </div>


                <?php if(isset($_SESSION["utente"])) { ?>   <!-- se l'utente si è loggato si vede logout-->
                <a href="php/logout-exe.php" class="btn btn-secondary" role="button" id="logout" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-sign-out-alt" aria-hidden="true"></i> Log Out
                </a>
                <?php } else {?> <!-- se l'utente non si è loggato si vede login-->

                <!-- Bottone contenente icona e scritta  login -->
                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span><i class="fa fa-user" aria-hidden="true"></i></span> Log In
                </button>
                <?php }?>

                <div class="dropdown-menu dropdown-menu-right">
                    <!-- Form per l'inserimento dei dati dell'utente. Specificate le dimensioni del padding  -->
                    <form role="form" data-toggle="validator" class="px-4 pt-3" method="POST" action="php/login-exe.php">
                        <!-- Nickname  -->
                        <div class="form-group">
                            <label for="dropdownFormNick">Nickname</label>
                            <div class="input-group" style="width: 300px;">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-user-circle" aria-hidden="true"></i></span>
                                </div>
                                <input type="text" class="form-control" id="dropdownFormNick" name="user" placeholder="Nickname">
                            </div>
                        </div>


                        <!-- Password  -->
                        <div class="form-group">
                            <label for="dropdownFormPassword">Password</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-lock fa-lg" aria-hidden="true"></i></span>
                                </div>
                                <input type="password" class="form-control" id="dropdownFormPassword" name="pass" placeholder="Password">
                            </div>
                        </div>
                        <!-- Checkbox per ricordare le credenziali  -->
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="dropdownCheck" name="ricordami" <?php if (isset($_COOKIE["user"])) echo "checked"; ?>>
                            <label class="form-check-label" for="dropdownCheck">
                                Ricordami
                            </label>
                        </div>

                      <div class="mx-auto px-4 py-1">
                          <button type="submit" class="btn btn-primary btn-block">Entra</button>
                      </div>
                    </form>


                    <div class="dropdown-divider"></div>

                    <div class="mx-auto px-5">
                      <!-- Button trigger modal -->
                        <button type="button" class="btn btn-primary btn-block" data-toggle="modal" data-target="#registratiModal">
                            Registrati qui
                        </button>

                    </div>
                </div>
            </div>
        </ul>

    </nav>
</div>
