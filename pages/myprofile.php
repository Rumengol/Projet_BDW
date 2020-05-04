<?php
include "../scripts/usermanager.php";
if(!isset($_COOKIE["idUser"]))
    header("Location : /index.php");
if(isset($_POST['Post']) && !empty($_POST['Title']) && !empty($_POST['Content']))
    writePost();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../style/style.css">
    <script defer src="https://use.fontawesome.com/releases/v5.0.6/js/all.js"></script>
    <script src="../scripts/comment.js"></script>
    <title>Mon profil</title>
</head>
<body>
<header>
      <h1><a href="index.php">C'est pas facebook mais presque</a></h1>
      <div id="search">
        <form action="search.php" method="post">
          <input type="text" name="searchBar" id="searchBar" placeholder="Chercher un pseudo">
          <button name="search" type="submit">Rechercher</button>
        </form>
      </div>
      <div id="account">
      <?php
        IsConnect();
      ?>
      </div>

    </header>
    <?php 
        showUser(); 
    ?>

    <form action="myprofile.php" method="post">
        <label for="Title">Titre</label>
        <input type="text" name="Title" id="titre">
        <input type="image" name="ImagePath">
        <textarea name="Content" rows="5" cols="50"></textarea>
        <input type="submit" name="Post" value="Publier">
    </form>

    <aside>
        <h2>Mes groupes</h2>
        <?php showGroups() ?>
        <br>
        <h2>Mes amis</h2>
        <?php showFriends() ?>
    </aside>

    <?php
        showUserPosts(true,$_COOKIE['idUser']);
    ?>
</body>
<script id="commentHtml" type="text/html">
    <form class="commentForm" method="POST">
    <textarea name="commentaire" placeholder="Votre commentaire..."></textarea><br />
    <input type="submit" value="Poster mon commentaire" name="submit_commentaire" />
    <button class="cancel" onclick="CancelComment()">Annuler</button>
    </form>
</script>
</html>

<?php
    function writePost(){
        $connect = connexion();
        $cover=null;
        if(!empty($_POST['ImagePath']))
            $cover=$_FILES['ImagePath']['name'];
        date_default_timezone_set('UTC');
        $requete = "INSERT INTO Posts (PostId,Titre,Contenu,DatePoste,Likes,CouverturePath,Auteur)
                    VALUES (\"".uniqid()."\",\"".$_POST['Title']."\",\"".$_POST['Content']."\",\"".date("Y-m-d H:i:s")."\",
                    0,\"".$cover."\",\"".$_COOKIE['idUser']."\");";
        $reponse = mysqli_query($connect,$requete);
        if($reponse!=null){
            $fichier = basename($_FILES['ImagePath']['name']);
            $dossier = '../images/covers/';
            move_uploaded_file($_FILES['fileUser']['tmp_name'], $dossier . $fichier);
            mysqli_free_result($reponse);
        }
        mysqli_close($connect);
    }

    function showGroups(){
        $connect = connexion();
        $requete = "SELECT GroupeId, Annee, Matiere FROM appartientpersonnegroupe JOIN groupes ON (Groupe=GroupeId) WHERE Personne=\"".$_COOKIE["idUser"]."\";";
        $reponse = mysqli_query($connect,$requete);
        while($ligne = mysqli_fetch_array($reponse)){
            echo "<div class='group'>";
            echo "<a href='group.php?idg=".$ligne["GroupeId"]."'>";
            echo "<p>".$ligne["Matiere"]." <i>".$ligne["Annee"]."</i></p>";
            echo "</a></div>";
        }
        mysqli_free_result($reponse);
        mysqli_close($connect);
    }

    function showFriends(){
        $connect = connexion();
        $requete = "SELECT PersonneId, Pseudo, AvatarPath, EstProfesseur FROM amis JOIN Personnes ON (Ami2=PersonneId) WHERE Ami1=\"".$_COOKIE["idUser"]."\" UNION SELECT PersonneId, Pseudo, AvatarPath, EstProfesseur FROM amis JOIN Personnes ON (Ami1=PersonneId) WHERE Ami2=\"".$_COOKIE["idUser"]."\";";
        $reponse = mysqli_query($connect,$requete);
        while($ligne = mysqli_fetch_array($reponse)){
            echo "<div class='friend'>";
            echo "<a href='profile.php?id=".$ligne["PersonneId"]."'>";
            echo "<img src='../images/avatars/".$ligne["AvatarPath"]."' class='avatar' />";
            echo "<p class='pseudo'>".$ligne["Pseudo"]."</p>";
            if($ligne['EstProfesseur'])
                echo "<img src='../images/prof.png' />";
            echo "</a></div>";
        }
        mysqli_free_result($reponse);
        mysqli_close($connect);
    }
?>