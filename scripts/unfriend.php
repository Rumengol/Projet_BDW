<?php
include 'usermanager.php';
$connect = connexion();
$requete = "DELETE FROM Amis WHERE (ami1=\"".$_POST['id1']."\" AND ami2=\"".$_POST['id2']."\") OR (ami1=\"".$_POST['id2']."\" AND ami2=\"".$_POST['id1']."\");";
$reponse = mysqli_query($connect,$requete);
if($reponse != null){
    echo "supprimé";
    return true;
}
else return http_response_code(500);
?>