<?php
include 'usermanager.php';
$connect = connexion();
$requete = "INSERT INTO Amis (Ami1, Ami2) 
            VALUES (\"".$_POST['id1']."\", \"".$_POST['id2']."\");";
$reponse = mysqli_query($connect, $requete);
if($reponse!=null){
    mysqli_free_result($reponse);
    mysqli_close($connect);
    return true;
}
else{
    mysqli_close($connect);
    return http_response_code(500);
}
?>