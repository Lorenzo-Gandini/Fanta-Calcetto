//Aggiorna portieri
function aggiorna_por(dis,prezzo) {
    var fantacash = document.getElementById("fanta_c").innerHTML;
    var num_portieri = document.getElementById("f_por").innerHTML;
     if (!(dis.checked) && num_portieri==0){
         fantacash = parseInt(fantacash) + prezzo;
         num_portieri++;
         dis.checked = false;
     }
    else if(num_portieri==0){
         dis.checked = false;
    }
    else if(dis.checked) {
        fantacash = fantacash - prezzo;
        num_portieri--;
        if(fantacash<0){
            window.alert("Avresti il credito negativo! Rivedi i tuoi acquisti.");
            fantacash = parseInt(fantacash) + prezzo;
            num_portieri++;
            dis.checked = false;
        }
    }
    else{
        fantacash = parseInt(fantacash) + prezzo;
        num_portieri++;
        dis.checked = false;
    }
    document.getElementById("fanta_c").innerHTML = fantacash;
    document.getElementById("f_por").innerHTML = num_portieri;
}

//Aggiorna difensori
function aggiorna_dif(dis,prezzo) {
    var fantacash = document.getElementById("fanta_c").innerHTML;
    var num_difensori = document.getElementById("f_dif").innerHTML;
     if (!(dis.checked) && num_difensori==0){
         fantacash = parseInt(fantacash) + prezzo;
         num_difensori++;
         dis.checked = false;
     }
    else if(num_difensori==0){
         dis.checked = false;
    }
    else if(dis.checked) {
        fantacash = fantacash - prezzo;
        num_difensori--;
         if(fantacash<0){
            window.alert("Avresti il credito negativo! Rivedi i tuoi acquisti.");
            fantacash = parseInt(fantacash) + prezzo;
            num_difensori++;
            dis.checked = false;
        }
    }
    else{
        fantacash = parseInt(fantacash) + prezzo;
        num_difensori++;
        dis.checked = false;
    }
    document.getElementById("fanta_c").innerHTML = fantacash;
    document.getElementById("f_dif").innerHTML = num_difensori;
}

//Aggiorna centrocampisti
function aggiorna_cen(dis,prezzo) {
    var fantacash = document.getElementById("fanta_c").innerHTML;
    var num_centrocampisti = document.getElementById("f_cen").innerHTML;
     if (!(dis.checked) && num_centrocampisti==0){
         fantacash = parseInt(fantacash) + prezzo;
         num_centrocampisti++;
         dis.checked = false;
     }
    else if(num_centrocampisti==0){
         dis.checked = false;
    }
    else if(dis.checked) {
        fantacash = fantacash - prezzo;
        num_centrocampisti--;
        if(fantacash<0){
            window.alert("Avresti il credito negativo! Rivedi i tuoi acquisti.");
            fantacash = parseInt(fantacash) + prezzo;
            num_centrocampisti++;
            dis.checked = false;
        }
    }
    else{
        fantacash = parseInt(fantacash) + prezzo;
        num_centrocampisti++;
        dis.checked = false;
    }
    document.getElementById("fanta_c").innerHTML = fantacash;
    document.getElementById("f_cen").innerHTML = num_centrocampisti;
}

//Aggiorna attaccanti
function aggiorna_att(dis,prezzo) {
    var fantacash = document.getElementById("fanta_c").innerHTML;
    var num_attaccanti = document.getElementById("f_att").innerHTML;
     if (!(dis.checked) && num_attaccanti==0){
         fantacash = parseInt(fantacash) + prezzo;
         num_attaccanti++;
         dis.checked = false;
     }
    else if(num_attaccanti==0){
         dis.checked = false;
    }
    else if(dis.checked) {
        fantacash = fantacash - prezzo;
        num_attaccanti--;
        if(fantacash<0){
            window.alert("Avresti il credito negativo! Rivedi i tuoi acquisti.");
            fantacash = parseInt(fantacash) + prezzo;
            num_attaccanti++;
            dis.checked = false;
        }
    }
    else{
        fantacash = parseInt(fantacash) + prezzo;
        num_attaccanti++;
        dis.checked = false;
    }
    document.getElementById("fanta_c").innerHTML = fantacash;
    document.getElementById("f_att").innerHTML = num_attaccanti;
}

function aggiorna_cash(tis,prezzo) {
  var fantamilioni = document.getElementById("fanta_m").innerHTML;

  if(tis.checked) {
      //window.alert("Chkd");
      fantamilioni = parseInt(fantamilioni) + prezzo;

  }
  else{
      //window.alert("Unchkd");
      fantamilioni = fantamilioni - prezzo;
      tis.checked = false;
  }

  document.getElementById("fanta_m").innerHTML = fantamilioni;

}



//Controlla modulo 2-1-1
function aggiorna_mod1() {
    document.getElementById("m_por").innerHTML = 1;
    document.getElementById("m_dif").innerHTML = 2;
    document.getElementById("m_cen").innerHTML = 1;
    document.getElementById("m_att").innerHTML = 1;
}

//Controlla modulo 1-2-1
function aggiorna_mod2() {
    document.getElementById("m_por").innerHTML = 1;
    document.getElementById("m_dif").innerHTML = 1;
    document.getElementById("m_cen").innerHTML = 2;
    document.getElementById("m_att").innerHTML = 1;
}

//Controlla modulo 1-1-2
function aggiorna_mod3() {
    document.getElementById("m_por").innerHTML = 1;
    document.getElementById("m_dif").innerHTML = 1;
    document.getElementById("m_cen").innerHTML = 1;
    document.getElementById("m_att").innerHTML = 2;
}



// por = 0, dif = 1, cen = 2, att=3
function controlla_mod(dis,ruolo){
  var n_dif = document.getElementById("m_dif").innerHTML;
  var n_cen = document.getElementById("m_cen").innerHTML;
  var n_att = document.getElementById("m_att").innerHTML;
  var n_por = document.getElementById("m_por").innerHTML;

    if (!(dis.checked)) {
        if(ruolo==0){
          n_por++;
          document.getElementById("m_por").innerHTML = n_por;
        }
        if(ruolo==1){
          n_dif++;
          document.getElementById("m_dif").innerHTML = n_dif;
        }
        if(ruolo==2){
          n_cen++;
          document.getElementById("m_cen").innerHTML = n_cen;
        }
        if(ruolo==3){
          n_att++;
          document.getElementById("m_att").innerHTML = n_att;
        }
        //dis.checked = false;
    }

    else if((n_por==0 && ruolo == 0) || (n_dif==0 && ruolo == 1) || (n_cen==0 && ruolo == 2) || (n_att==0 && ruolo == 3)){
      dis.checked = false;
    }

    else if(dis.checked){
      if(ruolo==0){
        n_por--;
        document.getElementById("m_por").innerHTML = n_por;
      }
      if(ruolo==1){
        n_dif--;
        document.getElementById("m_dif").innerHTML = n_dif;
      }
      if(ruolo==2){
        n_cen--;
        document.getElementById("m_cen").innerHTML = n_cen;
      }
      if(ruolo==3){
        n_att--;
        document.getElementById("m_att").innerHTML = n_att;
      }
    }

}
