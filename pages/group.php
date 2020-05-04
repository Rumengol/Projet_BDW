<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../style/style.css">
    <script defer src="https://use.fontawesome.com/releases/v5.0.6/js/all.js"></script>
    <?php echo "<title>Groupe de ".getGroup()["Matiere"]."</title>"; ?>
</head>
<body>
<header>
      <h1>C'est pas facebook mais presque</h1>
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
    <h1>Groupe de <?php getGroup()["Matiere"] ?></h1>
    <div id="admin">
        <?php showAdmin(); ?>
    </div>
    <div class="postContainer">
        <?php showGroupPosts(); ?>
    </div>
    <aside>
        <h2>Membres</h2>
        <?php showMembers(); ?>
    </aside>
    
</body>
</html>

<?php
    include "../scripts/usermanager.php";
function getGroup(){
    $connect = connexion();
    $requete = "SELECT * FROM Groupes WHERE GroupeId = \"".$_GET['idg']."\";";
    $reponse = mysqli_query($connect,$requete);
    $ligne = mysqli_fetch_array($reponse);

    if($ligne!=null){
        return $ligne;
    }

    mysqli_free_result($reponse);
    mysqli_close($connect);
}

function showAdmin(){
    $connect = connexion();
    $requete = "SELECT * FROM Personnes WHERE PersonneId = \"".getGroup()["Administrateur"]."\";";
    $reponse = mysqli_query($connect,$requete);

    $ligne = mysqli_fetch_array($reponse);

    if($ligne!=null){
        echo "<div class='admin'>";
        echo "<h2>Administrateur</h2>";
        echo "<img class='avatar' src='../images/avatars/".$ligne["AvatarPath"]."' />";
        echo "<h3><a href='profile.php?id=".$ligne["PersonneId"]."'>".$ligne["Pseudo"]."</a></h3>";
    }

    mysqli_free_result($reponse);
    mysqli_close($connect);
}

function showGroupPosts(){
    $connect = connexion();

    $requete = "SELECT * FROM Posts WHERE Groupe=\"".$_GET["idg"]."\" ORDER BY DatePoste DESC LIMIT 20";
    $reponse = mysqli_query($connect,$requete);
    if($reponse != null){
        while($ligne = mysqli_fetch_array($reponse)) {
            echo "<div class='post'>";
            echo "<h2 class='postTitle'>".$ligne['Titre']."</h2>";
            echo "<img class='cover' src='../images/covers/".$ligne['CouverturePath']." />";
            echo "<p class='postContent'>".$ligne['Contenu']."</p>";
            echo "<div class='footnotes'>";
            echo "<img src='../images/like.png' /> <p class='likeCounter'>".$ligne['Likes']."</p>";
            echo "<p class='date'>".$ligne['DatePoste']."</p>";
            if($edit)
                echo "<p class='postActions'><a href='#'>Éditer</a>|<a href='supprimer.php?id=".$ligne['PostId']."&from=myprofile.php'>Supprimer</a></p>";
            if($_COOKIE["idUser"])
                echo "<a class='comment' href='#'>Commenter</a>";
            else
                echo "<p class='nocomment'>Commenter</p>";
            echo "</div>";
        }

        mysqli_free_result($reponse);
    }
    mysqli_close($connect);
}

function showMembers(){
    $connect = connexion();
    $requete = "SELECT PersonneId, Pseudo, AvatarPath, EstProfesseur FROM appartientpersonnegroupe JOIN Personnes ON (Personne=PersonneId) WHERE Group=\'".$_GET["idg"]."';";
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