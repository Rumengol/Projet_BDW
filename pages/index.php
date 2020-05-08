<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <link rel="stylesheet" href="../style/style.css">
    <script defer src="https://use.fontawesome.com/releases/v5.0.6/js/all.js"></script>
    <script src="../scripts/post.js"></script>
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
  <form class="commentForm" method="POST" action="../scripts/Commentaire.php">
    <textarea name="commentaire" placeholder="Votre commentaire..."></textarea><br />
    <input name="returnurl" value="<?php echo $_SERVER['REQUEST_URI']; ?>" hidden >
    <input type="submit" value="Poster mon commentaire" name="submit_commentaire" />
    <button class="cancel" onclick="CancelComment()">Annuler</button>
    </form>
</script>
<script type="text/html" id="editHtml">
    <form action="../scripts/edit.php" method="post" class="editForm">
  <input type="text" name="Title" class="titleEdit" />
  <input name="returnurl" value="<?php echo $_SERVER['REQUEST_URI']; ?>" hidden >
  <textarea name="Content" cols="30" rows="10" class="textEdit"></textarea>
  <div class="editActions">
    <input type="submit" value="Éditer" />
    <button onclick="cancelEdit()">Annuler</button>
  </div>
</form>
</script>
</html>

<?php

  function showLatestPosts(){
    $connect = connexion();
    $requete = "SELECT * FROM Posts JOIN Personnes ON (Auteur=PersonneId) ORDER BY DatePoste DESC LIMIT 20";
    $reponse = mysqli_query($connect,$requete);
    
    if($reponse!=null){
      showPost($reponse);
      
    }

    mysqli_free_result($reponse);
    mysqli_close($connect);
  }
?>