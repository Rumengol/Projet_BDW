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

    <?php
        getUserPost();
    ?>
</body>
</html>

<?php
    $id = $_GET['id'];

    function connexion(){
        $user = 'root';
        $password = 'root';
        $db = 'reseaudb';
        $host = 'localhost:3306';
        $connect = mysqli_connect($host,$user,$password,$db);
        if(mysqli_connect_errno())
            return null;
        else
            return $connect;
    }

    function getUser(){
    global $pseudo, $prenom, $nom, $avatarPath;

    $connect = connexion();

        $requete = "SELECT * FROM Personnes WHERE PersonneId = ".$_GET['id'].";";
        $reponse = mysqli_query($connect,$requete);
        $ligne = mysqli_fetch_array($reponse);

        if($ligne!=null){
            return $ligne;
        }

        mysqli_close($connect);
    }


    function getUserPosts(){
        $connect = mysqli_connect($host,$user,$password,$db);
        if(mysqli_connect_errno())
            echo "<div class='errordb'></div>";
        else{
            $requete = "SELECT * FROM Posts WHERE Auteur=".$id." ORDER BY DatePoste DESC LIMIT 10";
            $reponse = mysqli_query($connect,$requete);
            $ligne = mysqli_fetch_array($reponse);
            if($ligne != null){

            }
        }
    }
?>