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
        <div class="profileBox">
        <?php 
            showUser($_GET["id"]); 
            echo "</div>";
            echo "<div class='postContainer'>";
            showUserPosts($_GET['id']);
            echo "</div>";
        ?>
        </div>
        <aside>
            <h2>Ses Groupes</h2>
            <div class="asideContainer">
            <?php showGroups($_GET["id"]); ?>
            </div>
            <h2>Ses Amis</h2>
            <div class ="asideContainer">
            <?php showFriends($_GET["id"]); ?>
            </div>
        </aside>
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