var truc = document.getElementById("truc");
var checkbPil = document.getElementById("CheckPilot");
var button = document.getElementById("buttonvalider");
 

button.addEventListener("click", envoyer);
button.addEventListener("click",appelGraph)
     

function appelGraph(){
  Graph(vitesse, regime, heure,"vitesse","regime","#FF0000", "#00FF00")

}


document.addEventListener("keyup", function(event) {
  if (event.keyCode === 13) {
      envoyer()
  }
});


function envoyer(){  
  var DateDeb = document.getElementById("datedebut").value
  DateDeb = DateDeb.replace("T", "%20")

  var DateFin = document.getElementById("datefin").value
  DateFin = DateFin.replace('T', "%20")
  var urlReq = `http://172.20.21.201/~lucas/M05SW/rest.php/mesure/${DateDeb}/${DateFin}/regime`

    var xh = new XMLHttpRequest();
    xh.onreadystatechange = function DecryptedMsg() {
        if (xh.readyState === 4 && xh.status === 200) {
            var texteRecu=JSON.parse(xh.responseText);
            // La clé
            var key = CryptoJS.enc.Hex.parse("0123456789abcdef0123456789abcdef");
            // Le vecteur d'initialisation
            var iv = CryptoJS.enc.Hex.parse("abcdef9876543210abcdef9876543210");
            var messageB64=texteRecu['chiffrement'];
            var message_dechiffreB64 = CryptoJS.enc.Base64.parse(messageB64);
            var texte_decrypte = CryptoJS.AES.decrypt(messageB64, key,
            {iv:iv}).toString(CryptoJS.enc.Utf8);
            var tg = JSON.parse(texte_decrypte) ;      
            LeTableau = Object.keys(tg[0]);           
            Grandeur = document.getElementById("SelectGrandeur").value      
      
            if (testTable() === false){
      
              MajTableau(LeTableau, tg, Grandeur)
            }
      
            else{
              deleteTable();
              MajTableau(LeTableau, tg, Grandeur)
            }
          }         
        }
    xh.open("GET", urlReq, true);
    xh.setRequestHeader("Content-type", "application/json");
    xh.send();
    }



function deleteTable(){

  document.getElementById("Tableau").innerHTML = "<thead> <tr> </tr> </thead>"
}



function testTable(){
  
  var TableauTruc = document.getElementById("Tableau").innerHTML

  bidule = TableauTruc.length


  if(bidule === 73 || bidule === 27) return false
  
  return true
}




let chart

function Graph(vitesse, regime ,heure,legende1, legende2 ,color1, color2) {
  
  


  const ctx = document.getElementById('monGraphe');   
  var data = {
      type: 'line',
      options: {scales:{
        vitesse:{type: 'linear',display:true,position:'left'},
        regime:{type: 'linear',display:true,position:'right' }
        
        }},
      data: {
      labels: heure,
      datasets: [{
          yAxisID: "vitesse",
          label: legende1,
          data: vitesse,
          borderWidth: 1,
          borderColor: color1,
          },
          
          {
          yAxisID: "regime",
          label: legende2,
          data: regime,
          borderColor: color2,
          borderWidth: 1
          }
      ]}
    }


  if(chart){
    chart.destroy()
    chart = new Chart(ctx, data)
  }
  else{
    chart = new Chart(ctx, data)
  }

}

  




var vitesse=[];var heure=[];var regime=[];

function MajTableau(RowARemp, Objects, Grandeur){

   var TableauTruc = document.getElementById("Tableau")
    var row = TableauTruc.insertRow(0)
    for(i=0; i<RowARemp.length;i++){
        LaCell = row.insertCell(i)
        LaCell.innerHTML = RowARemp[i]
    }

    for(j=1; j<Objects.length;j++){
        var NewRow = TableauTruc.insertRow(j)
        for(k=0; k<RowARemp.length;k++){
          TheCell = NewRow.insertCell(k)
          elementARemp = Object.values(Objects[j])          
          if (k === 1) vitesse[j] = elementARemp[k]
          if (k === 2) regime[j] = elementARemp[k]
          if (k === 3) heure[j] = elementARemp[k]

          if ((k === 1) && (Grandeur === "Mph")){            
            var truc = elementARemp[k] / 1.609            
            truc = truc.toFixed(2)
            TheCell.innerHTML = truc;
            continue
          }
          TheCell.innerHTML = elementARemp[k];
        }
    }
}
