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
  </body>
</html>

<?php
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
        $requete = "SELECT Pseudo,AvatarPath,EstProfesseur FROM Personnes WHERE PersonneId = ".$_COOKIE['idUser'].";";
        $reponse = mysqli_query($connect,$requete);
        $ligne = mysqli_fetch_array($reponse);

        if($ligne!=null){
          echo "<img src='../images/avatars/".$ligne['AvatarPath']." />";
          echo "<p class='pseudo'>".$ligne['Pseudo']."</p>";
          if($ligne['EstProfesseur'])
            echo "<img src='../images/prof.png' />";
        }
      }
  }
?>