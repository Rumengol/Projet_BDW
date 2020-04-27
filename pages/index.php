<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Index</title>
  </head>
  <body>
    <header>
      <h1>C'est pas facebook mais presque</h1>

      <div id="account">
      <?php
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
  include '../scripts/usermanager.php';

  function IsConnect(){
    if($_COOKIE['idUser']){
      showUSer();
    }
    else{
      echo "<a href='register.html'>S'inscrire</a>";
      echo "<a href='login.html'>Se connecter</a>";
    }
  }

  function showUser(){
    $user = 'root';
    $password = 'root';
    $db = 'reseaudb';
    $host = 'localhost:3306';
    $connect = mysqli_connect($host,$user,$password,$db);

    if(mysqli_connect_errno())
        echo "<div class='errordb'></div>";
    else{
        $requete = "SELECT Pseudo,AvatarPath,EstProfesseur FROM Personnes WHERE PersonneId = \"".$_COOKIE['idUser']."\";";
        $reponse = mysqli_query($connect,$requete);
        $ligne = mysqli_fetch_array($reponse);

        if($ligne!=null){
          echo "<a href='profile.php?id=".$_COOKIE['idUser']."'>";
          echo "<img src='../images/avatars/".$ligne['AvatarPath']." />";
          echo "<p class='pseudo'>".$ligne['Pseudo']."</p>";
          if($ligne['EstProfesseur'])
            echo "<img src='../images/prof.png' />";
          echo "</a>";
        }
      }
  }

  function showLatestPosts(){
    $connect = connexion();
    $requete = "SELECT * FROM Posts JOIN Personnes ON ('Auteur'='PersonneId') ORDER BY DatePoste DESC LIMIT 10";
    $reponse = mysqli_connect($connect,$requete);
    $ligne = mysqli_fetch_array($reponse);
    if($ligne!=null){
      foreach ($ligne as $line) {
        echo "<div class='post'>";
        echo "<h2 class='postTitle'>".$line['Titre']."</h2>";
        echo "<h3 class='author'>Posté par ".$line['Pseudo']."</a></h3>";
        if($line['CouverturePath'])
          echo "<img class='cover' src='../images/covers/".$line['CouverturePath']." />";
        echo "<p class='postContent'>".$line['Contenu']."</p>";
        echo "<div class='footnotes'>";
        echo "<img src='../images/like.png' /> <p class='likeCounter'>".$line['Likes']."</p>";
        echo "<p class='date'>".$line['DatePoste']."</p>";
        echo "</div>";
      }
    }

    mysqli_free_result($reponse);
    mysqli_close($connect);
  }
?>