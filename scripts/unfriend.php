<?php
include 'usermanager.php';
$connect = connexion();
$requete = "DELETE FROM Amis WHERE (ami1=\"".$_POST['id1']."\" AND ami2=\"".$_POST['id2']."\") OR (ami1=\"".$_POST['id2']."\" AND ami2=\"".$_POST['id1']."\");";
$reponse = mysqli_query($connect,$requete);
if($reponse != null){
    echo mysqli_fetch_array($reponse);
    mysqli_free_result($reponse);
    mysqli_close($connect);
    if(areFriends($_POST['id1'],$_POST['id2']))
        return http_response_code(504);
    return true;
}
else {
    mysqli_close($connect);
    return http_response_code(500);
}
?>