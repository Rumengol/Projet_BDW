<?php
include 'usermanager.php';
$connect = connexion();
$requete = "DELETE FROM Commentaires WHERE CommentId=\"".$_POST['id']."\";";
$reponse = mysqli_query($connect,$requete);
if($reponse != null){
    return http_response_code(200);
}
else return http_response_code(500);
mysqli_close($connect);
?>