<?php
include 'usermanager.php';
$connect = connexion();
$titre = $_POST["Title"];
$contenu = $_POST["Content"];
date_default_timezone_set('UTC');
$date = date("Y-m-d H:i:s");
$post = $_POST["post"];
$requete = "UPDATE Posts SET Titre=\"".$titre."\",Contenu=\"".$contenu."\",DatePoste=\"".$date."\" WHERE PostId=\"".$post."\";";
$reponse = mysqli_query($connect,$requete);
if($reponse != null){
    header("Location: ".$_POST["returnurl"]);
}
else return http_response_code(500);
?>