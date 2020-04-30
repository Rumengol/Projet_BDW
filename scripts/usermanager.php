<?php
function connexion(){
    $user = 'root';
$password = 'root';
$db = 'reseaudb';
$host = 'localhost:3306';
$connect = mysqli_connect($host,$user,$password,$db);
if(mysqli_connect_errno())
    return;
else
    return $connect;
}

function getUser(){
    $connect = connexion();
    $requete = "SELECT * FROM Personnes WHERE PersonneId = \"".$_COOKIE['idUser']."\";";
    $reponse = mysqli_query($connect,$requete);
    $ligne = mysqli_fetch_array($reponse);

    if($ligne!=null){
        return $ligne;
    }

    mysqli_free_result($reponse);
    mysqli_close($connect);
}

//Le paramètre edit sert à indiquer si l'utilisateur peut ou non éditer les posts.
function getUserPosts($edit,$user){

    $connect = connexion();

        $requete = "SELECT * FROM Posts WHERE Auteur=\"".$user."\" ORDER BY DatePoste DESC LIMIT 10";
        $reponse = mysqli_query($connect,$requete);
        if($reponse != null){
            return $reponse;

            mysqli_free_result($reponse);
        }
        mysqli_close($connect);
    }

function showUser(){
    $ligne = getUser();
    $avatar = $ligne['AvatarPath'] ? $ligne['AvatarPath'] : "default.png";
    echo "<div class='profile'><img class='avatar' src='../images/avatars/".$avatar."' />";
    if($ligne['Pseudo'] != $ligne['Prenom']){
        echo "<h2>".$ligne['Pseudo']."</h2>";
        echo "<h3>".$ligne['Prenom']." ".$ligne['Nom']."</h3>";
    }
    else
        echo "<h2>".$ligne['Prenom']." ".$ligne['Nom']."</h2>";
    
        echo $ligne['EstProfesseur'] ? "<img class='prof' src='../images/prof.png' />" : "<div class='prof vide'></div>";
    echo "</div>";
}

function showUserPosts($edit,$user){
    $reponse = getUserPosts($edit,$user);
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
        echo "</div>";
    }
}

function IsConnect(){
    if($_COOKIE['idUser']){
      showUserTop();
    }
    else{
      echo "<a href='register.html'>S'inscrire</a>";
      echo "<a href='login.html'>Se connecter</a>";
    }
  }

  function showUserTop(){
    $connect = connexion();

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
?>