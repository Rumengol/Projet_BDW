<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <link rel="stylesheet" href="../style/style.css">
    <script defer src="https://use.fontawesome.com/releases/v5.0.6/js/all.js"></script>
    <script src="../scripts/comment.js"></script>
    <title>Index</title>
  </head>
  <body>
    <header>
      <h1>C'est pas facebook mais presque</h1>
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
      include '../scripts/usermanager.php';
        IsConnect();
      ?>
      </div>

    </header>

    <div class="postContainer">
    <h2>Les derniers posts :</h2>
      <?php showLatestPosts(); ?>
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

  function showLatestPosts(){
    $connect = connexion();
    $requete = "SELECT * FROM Posts JOIN Personnes ON (Auteur=PersonneId) ORDER BY DatePoste DESC LIMIT 20";
    $reponse = mysqli_query($connect,$requete);
    
    if($reponse!=null){
      while($ligne = mysqli_fetch_array($reponse)) {
        echo "<div class='post' id='post_".$ligne["PostId"]."'>";
        echo "<div class='postHead'>";
        echo "<h2 class='postTitle'>".$ligne['Titre']."</h2>";
        echo "<h3 class='author'>Posté par <a href='".$ligne["PersonneId"]."'>".$ligne['Pseudo']."</a></h3>";
        echo "</div>";
        if($ligne['CouverturePath'])
          echo "<img class='cover' src='../images/covers/".$ligne['CouverturePath']." />";
        echo "<p class='postContent'>".$ligne['Contenu']."</p>";
        echo "<div class='footnotes'>";
        echo "<p class='likeCounter'><i class='far fa-heart'></i> ".$ligne['Likes']."</p>";
        echo "<p class='date'>le <b>".$ligne['DatePoste']."</b></p>";
        if($_COOKIE["idUser"])
          echo "<a class='comment' href='#' onclick='showCommentForm(\"".$ligne["PostId"]."\")'>Commenter</a>";
        else
          echo "<p class='nocomment'>Commenter</p>";
        echo "</div></div>";
      }
    }

    mysqli_free_result($reponse);
    mysqli_close($connect);
  }
?>