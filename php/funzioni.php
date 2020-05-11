<?php
	include_once("connessione.php");

	function esiste_utente($cid,$nickname,$pw) {
			$result = array("msg" => "","stato" => 1);
			$querysql = "SELECT nickname, password FROM utente WHERE nickname = '$nickname' AND password = '$pw'";
			$res = $cid->query($querysql) or die("<p>Impossibile eseguire query.</p>"
														 ."<p>Codice di errore ".$cid->errno
														 .":".$cid->error."</p>");


			if($res == null) {
					$msg = " Errore generico <br/>". $res->error;
					$result["stato"] = 0;	//0 = errore
					$result["msg"] = $msg;
			}

			elseif($res->num_rows == 0 || $res->num_rows > 1) {
					$msg = "Nickname o password errati.";
					$result["stato"] = 0;	//0 = errore
					$result["msg"] = $msg;
			}
			elseif($res->num_rows == 1) {
					$msg = "Login effettuato con successo!";
					$result["stato"] = 1;	//1 = successo
					$result["msg"] = $msg;
			}

			return $result;
		}



		function importa_dati_utente($cid, $nickname){
			//prelevo la mail
				$sel1 = "SELECT email FROM utente WHERE nickname = '$nickname'";
				$result1 = $cid->query($sel1)	or die("<p>Impossibile eseguire la query.</p>"
																			. "<p>Codice errore " . $cid->errno . ": " . $cid->error) . "</p>";
				$row = $result1->fetch_row();
				$_SESSION["email"] = $row[0];
				$email = $_SESSION["email"];

			//prelevo tipo, nome, cognome etc
				$sel2 = "SELECT tipo, nome, cognome, squadra_cuore, fantacash, residenza, data_nascita FROM utente WHERE email = '$email'";
				$result3 = $cid -> query($sel2) or die("<p>Impossibile eseguire la query.</p>"
																			. "<p>Codice errore " . $cid->errno . ": " . $cid->error . "</p>");
				$utente = $result3->fetch_assoc();

				$_SESSION["tipo"] = $utente["tipo"];
				$_SESSION["nome"] = $utente["nome"];
				$_SESSION["cognome"] = $utente["cognome"];
                $_SESSION["fantacash"] = $utente["fantacash"];
				$_SESSION["squadra_cuore"] = $utente["squadra_cuore"];
				$_SESSION["residenza"] = $utente["residenza"];
				$_SESSION["dataN"] = $utente["data_nascita"];

			//prelevo il nome squadra e motto
                $sel3 = "SELECT crea.squadra, squadra.motto FROM crea JOIN squadra ON (crea.squadra = squadra.nome) WHERE crea.email = '$email'";
                $result3 = $cid->query($sel3)	or die("<p>Impossibile eseguire la query.</p>"
                                                                            . "<p>Codice errore " . $cid->errno . ": " . $cid->error) . "</p>";
                $squadra = $result3->fetch_assoc();
                $_SESSION["squadra"] = $squadra["squadra"]; //nome squadra
                $_SESSION["motto"] = $squadra["motto"];

				return $email;
		}

        function importa_dati_campionato($cid, $campionato){
                $sel4 = "SELECT id, nome FROM campionato WHERE nome = '$campionato'";
				$result4 = $cid -> query($sel4) or die("<p>Impossibile eseguire la query.</p>"
																			. "<p>Codice errore " . $cid->errno . ": " . $cid->error . "</p>");
				$campion = $result4->fetch_assoc();
                $_SESSION["nome_campionato"] = $campion["nome"];
                $_SESSION["id_campionato"] = $campion["id"];

                return $campion;
        }

    function ruoli_gioc($nomeSq,$cid){
        $cont_p=0;
        $cont_d=0;
        $cont_c=0;
        $cont_a=0;
        $valori_ruoli;
       $sql6 = "SELECT giocatori, ruolo FROM composta JOIN giocatore ON (composta.giocatori = giocatore.nome) WHERE composta.squadra = '$nomeSq' ORDER BY ruolo, giocatori ASC";
	   $res6 = $cid->query($sql6) or die("<p>Impossibile eseguire la query.</p>"
		   										 . "<p>Codice errore " . $cid->errno . ": " . $cid->error) . "</p>";
        while($nome = $res6->fetch_assoc()) {
                $ruolo = $nome['ruolo'];
                if($ruolo == 'P'){$cont_p++;}
                if($ruolo == 'D'){$cont_d++;}
                if($ruolo == 'C'){$cont_c++;}
                if($ruolo == 'A'){$cont_a++;}
			}
        $valori_ruoli[0] = $cont_p;
        $valori_ruoli[1] = $cont_d;
        $valori_ruoli[2] = $cont_c;
        $valori_ruoli[3] = $cont_a;
        return $valori_ruoli;
    }


    //Funzione per calcolare il punteggio della giornata
    function punteggio_squadra($cid, $squadra, $giornata, $campionato){
        $punteggio = 0;
        //Seleziono i giocatori, il loro ruolo e se sono titolari da formazione, controllando la squadra, la giornata e il campionato.
        $sql8 = "SELECT nome_gioc, stato_gioc, ruolo FROM formazione WHERE nome_sq='$squadra' AND num_giornata='$giornata' AND id_campionato='$campionato' ORDER BY stato_gioc DESC, ruolo";
        $res8 = $cid->query($sql8) or die("<p>8. Impossibile eseguire la query.</p>"
		   										 . "<p>Codice errore " . $cid->errno . ": " . $cid->error) . "</p>";

        while ($nomi = $res8->fetch_assoc()){
            //Seleziono un giocatore, il suo ruolo e il suo stato.
            $giocatori_consid[] = $nomi["nome_gioc"];
            $ruoli_consid[] = $nomi["ruolo"];
            $stati[] = $nomi["stato_gioc"];
            $gia_contato[] = 0;
            $giocatore_consid = $nomi["nome_gioc"];

            //Seleziono il voto del giocatore considerato
            $sql2 = "SELECT voto FROM valuta WHERE nome_giocatore='$giocatore_consid ' AND num_giornata='$giornata' AND id_camp='$campionato'";
            $res2 = $cid->query($sql2) or die("<p>2. Impossibile eseguire la query.</p>"
		   										 . "<p>Codice errore " . $cid->errno . ": " . $cid->error) . "</p>";
            $voti = $res2->fetch_row();
            $voti_giocatore[] = $voti[0];

        }

        $giocatori_length = count($giocatori_consid);
        for($i=0; $i<$giocatori_length; $i++){
            //giocatore titolare e gioca
            if($stati[$i]==1 && $voti_giocatore[$i]>=0){
                $punteggio = $punteggio + $voti_giocatore[$i];
                $gia_contato[$i]=1;
            }
            //giocatore titolare ma non gioca
            if($stati[$i]==1 && $voti_giocatore[$i]==-1){
                for($j=0; $j<$giocatori_length; $j++){
                    if($stati[$j]==0 && $ruoli_consid[$j]==$ruoli_consid[$i]){
                        //controllo il voto della riserva
                        if(!($voti_giocatore[$j]==-1) && $gia_contato[$j]==0){
                            $punteggio = $punteggio + $voti_giocatore[$j];
                            $gia_contato[$j]=1;
                            break;
                        }
                        //controllo il voto dell'ulteriore riserva nel caso la prima non giochi
                        else{
                            if($ruoli_consid[$j+1]==$ruoli_consid[$i] && $voti_giocatore[$j+1]>=0 && $gia_contato[$j]==0){
                                $punteggio = $punteggio + $voti_giocatore[$j+1];
                                $gia_contato[$j]=1;
                                break;
                            }
                        }
                    }
                }
            }

        }
        $insert1 = "INSERT INTO punteggi (nome_squadra, num_giornata, id_campionato, punteggio)
				VALUES ('$squadra','$giornata','$campionato','$punteggio')";
        $res = $cid -> query($insert1) or die("<p>4.Impossibile eseguire la query.</p>"
											  . "<p>Codice errore " . $cid->errno . ": " . $cid->error . "</p>");
        return $punteggio;
    }

	//funzione per calcolare il punteggio complessivo nel campionato di un utente
    function classifica_utente($cid, $squadra, $campionato){
        $punti_class = 0;
        $sql2 = "SELECT punteggio FROM punteggi WHERE nome_squadra='$squadra' AND id_campionato='$campionato'";
        $res2 = $cid->query($sql2) or die("<p>2. Impossibile eseguire la query.</p>"
		   										 . "<p>Codice errore " . $cid->errno . ": " . $cid->error) . "</p>";
        while ($punti = $res2->fetch_row()){
            $punti_class = $punti_class +$punti[0];
        }

        return $punti_class;
    }



	function conta_giocatori($cid, $squadra){
		$select = "SELECT COUNT(*) FROM composta WHERE squadra = '$squadra'";
		$result = $cid->query($select) or die("<p>Impossibile eseguire la query.</p>"
									   . "<p>Codice errore " . $cid->errno . ": " . $cid->error . "</p>");
		$row = $result->fetch_row();
		$numGiocatori = $row[0];

		return $numGiocatori;
	}


    function top_coach($cid, $id_camp, $last_giornata, $squadra){
        $sql3 = "SELECT AVG(punteggio) FROM punteggi WHERE id_campionato='$id_camp' AND num_giornata='$last_giornata' AND nome_squadra<>'$squadra' ";
        $res3 = $cid->query($sql3) or die("<p>3.Impossibile eseguire la query.</p>"
                                       . "<p>Codice errore " . $cid->errno . ": " . $cid->error . "</p>");
        $media = $res3->fetch_row();
        $media_giornata = $media[0];

        $verita = false;

        $sql4 = "SELECT punteggio FROM punteggi WHERE id_campionato='$id_camp' AND num_giornata='$last_giornata' AND nome_squadra='$squadra' ";
        $res4 = $cid->query($sql4) or die("<p>3.Impossibile eseguire la query.</p>"
                                       . "<p>Codice errore " . $cid->errno . ": " . $cid->error . "</p>");
        $mio = $res4->fetch_row();
        $mio_pun = $mio[0];

        if($mio_pun > $media_giornata){
            $verita = true;
            return $verita;
        }
        else{
            $verita = false;
            return $verita;
        }

    }

    function se_35($cid, $id_camp, $squadra, $punteggio){
		$cont=0;
        if($punteggio>=35){
            $sql1 = "SELECT conta_35 FROM compete WHERE squadra='$squadra' AND campionato='$id_camp'";
            $res1 = $cid->query($sql1) or die("<p>1.Impossibile eseguire la query.</p>"
                                       . "<p>Codice errore " . $cid->errno . ": " . $cid->error . "</p>");
            $conteggia = $res1->fetch_row();
            $cont = $conteggia[0];
            $cont ++;

            $sql2 = "UPDATE compete SET conta_35='$cont' WHERE squadra='$squadra' AND campionato='$id_camp'";
            $res2 = $cid->query($sql2) or die("<p>2.Impossibile eseguire la query.</p>"
                                       . "<p>Codice errore " . $cid->errno . ": " . $cid->error . "</p>");
        }
        if($cont==3){
            $sql3 = "SELECT email FROM crea WHERE squadra='$squadra'";
            $res3 = $cid->query($sql3) or die("<p>3.Impossibile eseguire la query.</p>"
                                       . "<p>Codice errore " . $cid->errno . ": " . $cid->error . "</p>");
            $mail = $res3->fetch_row();
            $mia_mail = $mail[0];

            $sql4 = "UPDATE utente SET tipo='1' WHERE email='$mia_mail'";
            $res4 = $cid->query($sql4) or die("<p>4.Impossibile eseguire la query.</p>"
                                       . "<p>Codice errore " . $cid->errno . ": " . $cid->error . "</p>");
        }
    }

    function last_35($cid, $id_camp, $squadra){
        $sql1 = "SELECT num_giornata FROM punteggi WHERE id_campionato='$id_camp' AND nome_squadra='$squadra' AND punteggio>=35 ORDER BY num_giornata DESC";
        $res1 = $cid->query($sql1) or die("<p>1.Impossibile eseguire la query.</p>"
                                       . "<p>Codice errore " . $cid->errno . ": " . $cid->error . "</p>");
        $pun=$res1->fetch_assoc();
        $ultima_giornata = $pun["num_giornata"];
        if(!(isset($ultima_giornata))){
            return "<div class=\"alert alert-warning\">Non hai ancora superato i 35 punti in una giornata.</div>";
        }
        else{
            return "<div class=\"alert alert-info\">L'ultima volta che hai superato 35 punti una giornata è stato nel campionato: $id_camp, giornata: $ultima_giornata.</div>";
        }
    }
?>
