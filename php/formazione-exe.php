<?php
	include_once("funzioni.php");

	if(!(isset($_POST["nomeG"]))) {
		echo "<div class=\"alert alert-danger\">Devi selezionare dei giocatori per presentare la formazione!</div>";
	}
	else if(count($_POST["nomeG"])==5) {
		$squadra = $_SESSION["squadra"];
		$nomi_giocatori = $_POST["nomeG"];
		$campionati = $_SESSION["nCampForm"];
		$lenghtNomiGioc  = count($nomi_giocatori);


		//prendo i giocatori della squadra
			$sql = "SELECT giocatori FROM composta WHERE squadra = '$squadra'";
			$res = $cid->query($sql) or die("<p>1.Impossibile eseguire la query.</p>"
				   										 . "<p>Codice errore " . $cid->errno . ": " . $cid->error) . "</p>";

			while($nomi = $res->fetch_assoc()){
				$nomiSq[] = $nomi["giocatori"];
			}


		//prendo gli id dei campionati
			foreach($campionati as $nome_camp){
				$sql1 = "SELECT id FROM campionato WHERE nome='$nome_camp'";
				$res1 = $cid->query($sql1) or die("<p>2.Impossibile eseguire la query.</p>"
												. "<p>Codice errore " . $cid->errno . ": " . $cid->error) . "</p>";
				$id_camp = $res1->fetch_row();
			 	$id_considerato[] = $id_camp[0];
		}

				foreach($id_considerato as $id){
					//prendo il numero di giornata aperta del campionato
					$sql2 = "SELECT num_giornata FROM giornata WHERE id='$id' AND stato='1' ORDER BY num_giornata DESC ";
					$res2 = $cid->query($sql2) or die("<p>3.Impossibile eseguire la query.</p>"
													. "<p>Codice errore " . $cid->errno . ": " . $cid->error) . "</p>";
					$giornata = $res2->fetch_row();
					$giornata_cons = $giornata[0];


					//inserisco i giocatori nella formazione
					foreach($nomi_giocatori as $nomiForm){
						$stato_gioc = 1;
		                $sql4 = "SELECT ruolo FROM giocatore WHERE nome='$nomiForm'";
		                $res4 = $cid->query($sql4) or die("<p>4.Impossibile eseguire la query.</p>"
													. "<p>Codice errore " . $cid->errno . ": " . $cid->error) . "</p>";
					    $ruolo = $res4->fetch_row();
					    $ruolo_con = $ruolo[0];

						$insert = "INSERT INTO formazione (nome_gioc, ruolo, num_giornata, stato_gioc, id_campionato, nome_sq)
						VALUES ('$nomiForm','$ruolo_con','$giornata_cons','$stato_gioc','$id','$squadra')";
						$res = $cid -> query($insert) or die("<p>4.Impossibile eseguire la query.</p>"
													  . "<p>Codice errore " . $cid->errno . ": " . $cid->error . "</p>");
					}


					//inserisco le riserve
					foreach($nomiSq as $nomiSquadra){
						for($i=0; $i<$lenghtNomiGioc; $i++){
							if($nomiSquadra == $nomi_giocatori[$i]) {
								$check = 1;
								break;
							}
							else{
								$check = 0;
								continue;
							}
						}
						if ($check==0){
							$stato_gioc = 0;
		                    $sql5 = "SELECT ruolo FROM giocatore WHERE nome='$nomiSquadra'";
		                    $res5 = $cid->query($sql5) or die("<p>5.Impossibile eseguire la query.</p>"
													. "<p>Codice errore " . $cid->errno . ": " . $cid->error) . "</p>";
					        $ruolo_panc = $res5->fetch_row();
					        $ruolo_con_panc = $ruolo_panc[0];

		                    $insert = "INSERT INTO formazione (nome_gioc, ruolo, num_giornata, stato_gioc, id_campionato, nome_sq)
							VALUES ('$nomiSquadra','$ruolo_con_panc','$giornata_cons','$stato_gioc','$id','$squadra')";
							$res = $cid -> query($insert) or die("<p>5.Impossibile eseguire la query.</p>"
														  . "<p>Codice errore " . $cid->errno . ": " . $cid->error . "</p>");
						}
					}
				}


			echo "<div class=\"alert alert-success\">Operazione riuscita! La formazione è stata presentata!</div>";


	}

	else {
		echo "<div class=\"alert alert-danger\">Attenzione! Devi selezionare 5 giocatori</div>";
	}

 ?>
