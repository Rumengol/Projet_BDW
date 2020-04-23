<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Mon profil</title>
</head>
<body>
    
    <form action="profile.php" method="post">
        <label for="Title">Titre</label>
        <input type="text" name="Title" id="titre">
        <input type="textarea" name="Contenu">
        <input type="submit" name="Post" value="Publier">
    </form>
</body>
</html>

<?php
    function getUser(){
    $user = 'root';
    $password = 'root';
    $db = 'reseaudb';
    $host = 'localhost:3306';
    $connect = mysqli_connect($host,$user,$password,$db);

    $id = $_GET['id'];
    if(mysqli_connect_errno())
        echo "<div class='errordb'></div>";
    else{
        $requete = "SELECT * FROM Personnes WHERE PersonneId = ".$_GET['id'].";";
        $reponse = mysqli_query($connect,$requete);
        $ligne = mysqli_fetch_array($reponse);

        if($ligne!=null){
            $pseudo = $ligne['Pseudo'];
            $prenom = $ligne['Prenom'];
            $nom = $ligne['Nom'];
            $avatarPath = "../images/avatars/".$ligne['AvatarPath'];
        }
    }
}
?>