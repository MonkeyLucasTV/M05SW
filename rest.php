<?php
$texte = "";

  

    function isValid($date, $format = 'Y-m-d\tH:i:s'){
        $dt = DateTimeImmutable::createFromFormat($format, $date);
        return $dt && $dt->format($format) === $date;
    }

    $maConnexion = new PDO('mysql:host=localhost;dbname=F1;charset=utf8','lucas','mdp');
    
    
    $BDD = new PDO('mysql:host=localhost;dbname=F1;charset=utf8',"lucas",'ziziland');
    $req_typ = $_SERVER['REQUEST_METHOD'];
    
    if(isset($_SERVER['PATH_INFO'])){
        $req_path=$_SERVER['PATH_INFO'];
        $req_data=explode('/',$req_path);
        }

    if($req_typ=='GET'){


        if(isset($req_data[1])&&isset($req_data[3])&&$req_data[1]=='mesure'){ 
           

            if($req_data[3] == "regime" || $req_data[3] == "vitesse" && !(isset($req_data[4]))){
                if($req_data[3]== "regime"){

                    $instant = $req_data[2];
                    $req = "SELECT regime FROM Mesures WHERE instant='".$instant."'";
                    $res=$BDD->prepare($req, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
                    $res->execute(NULL);
                    $data = $res->fetchAll(PDO::FETCH_ASSOC);
                    $data_json = json_encode($data);
                    $text=$data_json;
                }
                if($req_data[3]== "vitesse"){
                    $instant = $req_data[2];
                    $req = "SELECT vitesse FROM Mesures WHERE instant='".$instant."'";
                    $res=$BDD->prepare($req, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
                    $res->execute(NULL);
                    $data = $res->fetchAll(PDO::FETCH_ASSOC);
                    $data_json = json_encode($data);
                    $texte=$data_json;
                }
            }        
            else{

                if(isset($req_data[6])) //Nom prenom 
                { 
                    
                    
                    $instant = $req_data[2];
                    $instant2 = $req_data[3];


                    $nom = $req_data[5];
                    $prenom= $req_data[6];
                    $req = "SELECT id FROM Pilote WHERE nom='".$nom."' AND prenom='".$prenom."'";
                    $res=$BDD->prepare($req, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
                    $res->execute(NULL);
                    $data = $res->fetchAll(PDO::FETCH_ASSOC);
                    $data_json = json_encode($data);
                    $idpil = $data[0]["id"];

                    $req2 = "SELECT instant FROM Mesures where pilote_id= '".$idpil."' and instant BETWEEN '".$instant."' and '".$instant2."'";
                    $res2=$BDD->prepare($req2, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
                    $res2->execute(NULL);
                    $data2 = $res2->fetchAll(PDO::FETCH_ASSOC);
                    $data_json2 = json_encode($data2);
                    
                    $texte = $data_json+ $data_json2;
                    

                }
                else if(isset($req_data[4])){     //Avoir deux instant


                    
                    $instant = $req_data[2];
                    $instant2 = $req_data[3];
                    $req = "SELECT * FROM Mesures WHERE instant BETWEEN '$instant' AND '$instant2'";
                    $res=$BDD->prepare($req, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
                    $res->execute(NULL);
                    $data = $res->fetchAll(PDO::FETCH_ASSOC);
                    $data_json = json_encode($data);
                    $texte =$data_json;

                }
                else{

                    $texte = "arguments manquants ou requete incorrect";
                    echo $texte;
                }
            }
            
            
        }
        else{
            $texte = "mauvaise requete";
            echo $texte;
        }
    }
    
        
    
    
    
    $key = pack('H*','0123456789abcdef0123456789abcdef');
    $iv = pack('H*','abcdef9876543210abcdef9876543210');
    $method = 'aes-128-cbc'; // C'est la méthode de cryptage utilisée par CrytoJS.AES.encrypt()
    $crypted=base64_encode(openssl_encrypt($texte,$method,$key,OPENSSL_RAW_DATA,$iv));
    echo '{"chiffrement":"'.$crypted.'"}'; // Sortie : 'Texte chiffré'






    
    
    // $req = "SELECT nom,prenom FROM Pilote";
    // $reqpreparer=$maConnexion->prepare($req);
    // $tableauDeDonnees=array() ;
    // $reqpreparer->execute($tableauDeDonnees);
    // $reponse = $reqpreparer->fetchAll(PDO::FETCH_ASSOC);
    // $reqpreparer->closeCursor(); 
    // print_r($reponse);
    // $req_type = $_SERVER['REQUEST_METHOD'];
    // echo $_SERVER['PATH_INFO'];
    // if(isset($_SERVER['PATH_INFO'])){
    //     $req_path=$_SERVER['PATH_INFO'];
    //     $req_data=explode('/',$req_path);
    // }
    // if ($req_type == 'GET') {
    //     echo'<h1>GET</h1>';

    //     if(isset($req_data[1]) && $req_data[1] == 'mesure') {
            
    //         echo 'mesure';

    //         if(isset($req_data[2])) {
    //             echo "/".$req_data[2];
    //         }

    //     }
    // }
    // else if ($req_type == 'POST') {
    //     echo '<h1>POST</h1>';
    // }



  
?>