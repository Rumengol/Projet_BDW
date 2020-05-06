<?php  
    include "../scripts/usermanager.php";
    $url = "myprofile.php";
    if(isset($_COOKIE['idUser']) && $_GET['id'] == $_COOKIE['idUser'])
        header("Location: ".$url);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../style/style.css">
    <script defer src="https://use.fontawesome.com/releases/v5.0.6/js/all.js"></script>
    <script src="../scripts/post.js"></script>
    <script src="../scripts/user.js"></script>
    <?php echo "<title>Profil de ".getUser($_GET['id'])['Pseudo']."</title>"; ?>
</head>
<body>
<header>
<h1><a href="index.php">C'est pas facebook mais presque</a></h1>
<form action="search.php" method="post">
      <div id="search-box">
          <input type="text" name="searchBar" id="search-txt" placeholder="Chercher un pseudo">
          <button name="search" type="submit" id="search-btn">
            <i class="fas fa-search"></i>
          </button>
      </div>
    </form>
      <div id="account">
      <?php
        IsConnect();
      ?>
      </div>

    </header>
    <div class="page">
        <div class="content">
        <?php 
            showUser($_GET["id"]); 
            echo "<div class='postContainer'>";
            showUserPosts($_GET['id']);
            echo "</div>";
        ?>
        </div>
        <aside>
            <h2>Ses Groupes</h2>
            <?php showGroups(); ?>
            <h2>Ses Amis</h2>
            <?php showFriends(); ?>
        </aside>
    </div>
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
function showGroups(){
    $connect = connexion();
    $requete = "SELECT GroupeId, Annee, Matiere FROM appartientpersonnegroupe JOIN groupes ON (Groupe=GroupeId) WHERE Personne=\"".$_GET["id"]."\";";
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
    $requete = "SELECT PersonneId, Pseudo, AvatarPath, EstProfesseur FROM amis JOIN Personnes ON (Ami2=PersonneId) WHERE Ami1=\"".$_GET["id"]."\"
    UNION SELECT PersonneId, Pseudo, AvatarPath, EstProfesseur FROM amis JOIN Personnes ON (Ami1=PersonneId) WHERE Ami2=\"".$_GET["id"]."\";";
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