<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="style.css">
    <link rel="script" href="ajax.js" defer>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    
</head>     
    <body>
        
        


    <?php
$compte =
array(array('pseudo'=>'login1','score'=>15),array('pseudo'=>'login2','score'=>5));
$html="ceci est un test de php"."<br>";
$html.="<table>";
for($i=0;$i<count($compte);$i++){
$joueurs=$compte[$i];
$html.="<tr><td>".$joueurs['pseudo']."</td><td>".$joueurs['score']."</td></tr>";
}
$html.="</table>";
echo $html;


    for($j= 124;$j<165;$j++){
         echo "$j \n";
    }

    echo "<br>";
    echo "<br>";

    foreach(range('a','z') as $v){
        echo "$v \n";
    }


   

?>

        
        
    </body>
</html>

