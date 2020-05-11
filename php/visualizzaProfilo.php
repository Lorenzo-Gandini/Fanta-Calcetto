    <?php include_once("funzioni.php"); ?>

<h2 class="title"><strong>Il mio profilo</strong></h2>
<br />
    <?php
        $nick = $_SESSION["utente"];
        importa_dati_utente($cid, $nick); ?>
<div>
  <div class="tab-content" id="nav-tabContent">
    <!-- tab visualizza -->
    <div class="tab-pane fade show active" id="list-visualizza" role="tabpanel">
      <div class="mx-auto" style="width: 70%;">
        <table class="table text-center">
          <tr>
              <td>Nome:</td>
              <td><?php echo $_SESSION["nome"]; ?></td>
          </tr>
          <tr>
              <td>Cognome:</td>
              <td><?php echo $_SESSION["cognome"]; ?></td>
          </tr>
          <tr>
              <td>Data di Nascita:</td>
              <td><?php echo $_SESSION["dataN"]; ?></td>
          </tr>
          <tr>
              <td>Email:</td>
              <td><?php echo $_SESSION["email"]; ?></td>
          </tr>
          <tr>
              <td>Nickname:</td>
              <td><?php echo $_SESSION["utente"]; ?></td>
          </tr>
          <tr>
              <td>Fantamilioni:</td>
              <td><?php echo $_SESSION["fantacash"]; ?></td>
          </tr>
          <tr>
              <td>La mia Squadra:</td>
              <td><?php echo $_SESSION["squadra"]; ?></td>
          </tr>
          <tr>
              <td>Squadra del cuore:</td>
              <td><?php echo $_SESSION["squadra_cuore"]; ?></td>
          </tr>
          <tr>
              <td>Residenza:</td>
              <td><?php echo $_SESSION["residenza"]; ?></td>
          </tr>
          <tr>
              <td>Tipologia utente:</td>
              <td>
                  <?php
                    $tipo = $_SESSION["tipo"];
                    if($tipo == 0){
                        echo "Allenatore";
                    }
                    if($tipo == 1){
                        echo "Commissario Tecnico";
                    }
                   if($tipo == 2){
                        echo "Admin";
                    }
                  ?>
              </td>
          </tr>
          <tr> <!-- per la linea sotto resideza -->
            <th></th>
            <th></th>
          </tr>
        </table>
      </div>
    </div>

    <!-- tab form modifica -->

    <div class="tab-pane fade" id="list-modifica" role="tabpanel">
      <form role="form" data-toggle="validator" method="POST" action="php/modificaProf-exe.php">
      <div class="mx-auto" style="width: 70%;">
        <table class="table text-center">
          <tr>
              <td>Nome:</td>
              <td><input class="form-control" type="text" name="nome" value="<?php echo $_SESSION["nome"]; ?>"/></td>
          </tr>
          <tr>
              <td>Cognome:</td>
              <td><input class="form-control" type="text" name="cognome" value="<?php echo $_SESSION["cognome"]; ?>"/></td>
          </tr>
          <tr>
              <td>Data di nascita:</td>
              <td><input class="form-control" type="date" name="dataN" value="<?php echo $_SESSION["dataN"]; ?>"/></td>
          </tr>
          <tr>
              <td>Password attuale</td>
              <td><input class="form-control" type="password" name="oldpw" placeholder="Password attuale"/></td>
          </tr>
          <div class="form-group">
            <tr>

                <td>Nuova password:</td>
                <td><div class="form-group has-feedback">
                    <input class="form-control" type="password" data-minlength="6" class="form-control" id="newpw1" data-minlength-error="Minimo 6 caratteri" name="newpw1" placeholder="Nuova password"/>
                    <div class="help-block with-errors"></div>
                    </div>
                </td>
            </tr>
            <tr>
                <th></th>
                <td><div class="form-group has-feedback">
                    <input class="form-control" type="password" name="newpw2" data-match="#newpw1" data-match-error="Le password non corrispondono"  placeholder="Ripeti la password"/>
                    <div class="help-block with-errors"></div>
                    </div>
                </td>
            </tr>
          </div>
          <tr>
              <td>Squadra del cuore:</td>
              <td><input class="form-control" type="text" name="squadra_cuore" value="<?php echo $_SESSION["squadra_cuore"]; ?>"/></td>
          </tr>
          <tr>
              <td>Residenza:</td>
              <td><input class="form-control" type="text" name="residenza" value="<?php echo $_SESSION["residenza"]; ?>"/></td>
          </tr>
          <tr><!-- per la linea sotto resideza -->
            <th></th>
            <th></th>
          </tr>
        </table>

        <div align="center">
             <input type="submit" class="btn btn-primary" value="Salva"></input>
             <input type="reset" class="btn btn-danger btn-red" value="Cancella"></input>

        </div>

      </div>
      </form>
    </div>

  </div>

 <hr />
  <div class="mx-auto" style="width: 150px;">
    <div class="list-group" id="myList" role="tablist" style="text-align:center">
      <a class="list-group-item list-group-item-action active" data-toggle="list" href="#list-visualizza" role="tab">Visualizza</a>
      <a class="list-group-item list-group-item-action" data-toggle="list" href="#list-modifica" role="tab">Modifica</a>
      <a class="list-group-item list-group-item-action elimina" href="php/elimina-exe.php">Elimina</a>
    </div>

  </div>
</div>
