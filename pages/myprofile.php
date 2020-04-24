<?php
if(isset($_POST['Post']))
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
    
    <form action="myprofile.php" method="post">
        <label for="Title">Titre</label>
        <input type="text" name="Title" id="titre">
        <input type="image" name="ImagePath">
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

        $connect = connexion();

            $requete = "SELECT * FROM Posts WHERE Auteur=".$id." ORDER BY DatePoste DESC LIMIT 10";
            $reponse = mysqli_query($connect,$requete);
            $ligne = mysqli_fetch_array($reponse);
            if($ligne != null){
                foreach ($ligne as $line) {
                    echo "<div class='post'>";
                    echo "<h2 class='postTitle'>".$line['Titre']."</h2>";
                    echo "<img class='cover' src='../images/covers/".$ligne['CouverturePath']." />";
                    echo "<p class='postContent'>".$line['Contenu']."</p>";
                    echo "<div class='footnotes'>";
                    echo "<img src='../images/like.png' /> <p class='likeCounter'>".$line['Likes']."</p>";
                    echo "<p class='date'>".$line['DatePost']."</p>";
                    echo "<p class='postActions'><a href='#'>Éditer</a>|<a href='supprimer.php?id=".$line['PostId']."&from=myprofile.php'>Supprimer</a></p>";
                    echo "</div>";
                }

                mysqli_free_result($reponse);
            }
            mysqli_close();
    } 

    function writePost(){
        $connect = connexion();
        $requete = "INSERT INTO Posts (PostId,Titre,Contenu,DatePoste,Likes,CouverturePath,Auteur)
                    VALUES ('".uniqid()."\','".$_POST['Title']."','".$_POST['Contenu']."','".date("Y-m-d H:i:s")."',
                    0,'".$_POST['ImagePath']."','".$_GET['id']."');";
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