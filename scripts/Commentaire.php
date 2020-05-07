<?php
include 'usermanager.php';
if(isset($_POST['commentaire'])){
$text=$_POST['commentaire'];
$connect = connexion();
$id = uniqid();
date_default_timezone_set('UTC');
$date = date("Y-m-d H:i:s");
$post = $_POST["post"];
$author = $_COOKIE["idUser"];

$sql = "INSERT INTO commentaires (CommentId,Contenu,DateCommentaire,Likes,ParentPost,Auteur) 
        VALUES(\"".$id."\",\"".$text."\",\"".$date."\",0,\"".$post."\",\"".$author."\");";
$reponse = mysqli_query($connect,$sql);
if($reponse == null)
    echo 'Erreur SQL !'.$sql.'<br>'.mysqli_error();
else{
    mysqli_free_result($reponse);
}
mysqli_close($connect);
}
    
header("Location : ".$_POST['returnurl']);
?>
	
	
	
	
	
	
	