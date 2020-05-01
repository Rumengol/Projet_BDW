<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <link rel="stylesheet" href="../style/style.css">
    <script defer src="https://use.fontawesome.com/releases/v5.0.6/js/all.js"></script>
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

    <h2>Les derniers posts :</h2>
    <div class="postContainer">
      <?php showLatestPosts(); ?>
    </div>
  </body>
</html>

<?php

  function showLatestPosts(){
    $connect = connexion();
    $requete = "SELECT * FROM Posts JOIN Personnes ON ('Auteur'='PersonneId') ORDER BY DatePoste DESC LIMIT 10";
    $reponse = mysqli_query($connect,$requete);
    
    if($reponse!=null){
      while($ligne = mysqli_fetch_array($reponse)) {
        echo "<div class='post'>";
        echo "<h2 class='postTitle'>".$ligne['Titre']."</h2>";
        echo "<h3 class='author'>Posté par ".$ligne['Pseudo']."</a></h3>";
        if($ligne['CouverturePath'])
          echo "<img class='cover' src='../images/covers/".$ligne['CouverturePath']." />";
        echo "<p class='postContent'>".$ligne['Contenu']."</p>";
        echo "<div class='footnotes'>";
        echo "<img src='../images/like.png' /> <p class='likeCounter'>".$ligne['Likes']."</p>";
        echo "<p class='date'>".$ligne['DatePoste']."</p>";
        echo "</div>";
      }
    }

    mysqli_free_result($reponse);
    mysqli_close($connect);
  }
?>