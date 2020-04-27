<?php
if(isset($_POST['Post']) && !empty($_POST['Title']) && !empty($_POST['Content']))
    writePost();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Mon profil</title>
</head>
<body>
    
    <?php 
        include "../scripts/usermanager.php";
        showUser(); 
    ?>

    <form action="myprofile.php" method="post">
        <label for="Title">Titre</label>
        <input type="text" name="Title" id="titre">
        <input type="image" name="ImagePath">
        <textarea name="Content" rows="5" cols="50"></textarea>
        <input type="submit" name="Post" value="Publier">
    </form>

    <?php
        showUserPosts(true,$_COOKIE['idUser']);
    ?>
</body>
</html>

<?php
    function writePost(){
        $connect = connexion();
        $requete = "INSERT INTO Posts (PostId,Titre,Contenu,DatePoste,Likes,CouverturePath,Auteur)
                    VALUES (\"".uniqid()."\",\"".$_POST['Title']."\",\"".$_POST['Content']."\",\"".date("Y-m-d H:i:s")."\",
                    0,\"".$_POST['ImagePath']."\",\"".$_GET['id']."\");";
        $reponse = mysqli_query($connect,$requete);
        if($reponse!=null){
            $fichier = basename($_FILES['ImagePath']['name']);
            $dossier = '../images/covers/';
            move_uploaded_file($_FILES['fileUser']['tmp_name'], $dossier . $fichier);
            mysqli_free_result($reponse);
        }
        mysqli_close($connect);
    }
?>