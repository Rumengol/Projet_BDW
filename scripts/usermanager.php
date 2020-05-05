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

function getUser($id){
    $connect = connexion();
    $requete = "SELECT * FROM Personnes WHERE PersonneId = \"".$id."\";";
    $reponse = mysqli_query($connect,$requete);
    $ligne = mysqli_fetch_array($reponse);

    if($ligne!=null){
        return $ligne;
    }

    mysqli_free_result($reponse);
    mysqli_close($connect);
}

function areFriends($user1,$user2){
    $connect = connexion();
    $requete = "SELECT Ami1, Ami2 FROM amis WHERE Ami1=\"".$user1."\" AND Ami2=\"".$user2."\" UNION SELECT Ami1, Ami2 FROM amis WHERE Ami1=\"".$user2."\" AND Ami2=\"".$user1."\";";
    $reponse = mysqli_query($connect,$requete);
    if(mysqli_fetch_array($reponse) != null){
        return true;
        mysqli_free_result($reponse);
    }
    else 
        return false;
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

function showUser($id){
    $ligne = getUser($id);
    $avatar = $ligne['AvatarPath'] ? $ligne['AvatarPath'] : "default.png";
    echo "<div class='profile'><img class='avatar' src='../images/avatars/".$avatar."' />";
    if($ligne['Pseudo'] != $ligne['Prenom']){
        echo "<h2>".$ligne['Pseudo']."</h2>";
        echo "<h3>".$ligne['Prenom']." ".$ligne['Nom']."</h3>";
    }
    else
        echo "<h2>".$ligne['Prenom']." ".$ligne['Nom']."</h2>";
    
    echo $ligne['EstProfesseur'] ? "<img class='prof' src='../images/prof.png' />" : "<div class='prof vide'></div>";
    if(isset($_COOKIE['idUser']) && $id != $_COOKIE['idUser']){
        if(!areFriends($id, $_COOKIE['idUser']))
            echo "<div id='addfriend'><a href='#' class='addFriendButton' onclick='sendFriendRequest(\"".$_COOKIE['idUser']."\",\"".$id."\")'><i class='fas fa-user'></i> Ajouter ami</a></div>";
        else
            echo "<div id=''#' addfriend'><a href=class='addFriendButton' disabled><i class='fas fa-user'></i> Ajouter ami</a><a href='#' class='unfriend' onclick='unfriend('".$_COOKIE['idUser']."','".$id."')'><i class='fas fa-times'></i></a></div>";
    }
        echo "</div>";
}

function showUserPosts($edit,$user){
    $reponse = getUserPosts($edit,$user);
    while($ligne = mysqli_fetch_array($reponse)) {
        echo "<div class='post'>";
        echo "<h2 class='postTitle'>".$ligne['Titre']."</h2>";
        if($ligne["CouverturePath"])
            echo "<img class='cover' src='../images/covers/".$ligne['CouverturePath']." />";
        echo "<p class='postContent'>".$ligne['Contenu']."</p>";
        echo "<div class='footnotes'>";
        echo "<p class='likeCounter'><i class='far fa-heart'></i> ".$ligne['Likes']."</p>";
        echo "<p class='date'>".$ligne['DatePoste']."</p>";
        if($edit)
            echo "<p class='postActions'><a href='#'>Éditer</a>|<a href='supprimer.php?id=".$ligne['PostId']."&from=myprofile.php'>Supprimer</a></p>";
        if(isset($_COOKIE["idUser"]))
            echo "<a class='comment' href='#'>Commenter</a>";
        else
            echo "<p class='nocomment'>Commenter</p>";
        echo "</div></div>";
    }
}

function IsConnect(){
    if(isset($_COOKIE['idUser'])){
      showUserTop();
    }
    else{
      echo "<a class='notco' href='register.php'>S'inscrire</a>";
      echo "<a class='notco' href='login.html'>Se connecter</a>";
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
        $avatar;

        if($ligne!=null){
          echo "<a class='acc' href='profile.php?id=".$_COOKIE['idUser']."'>";
          if($ligne['AvatarPath'] == null)
            $avatar = "default.png";
        else
            $avatar = $ligne['AvatarPath'];
          echo "<img src='../images/avatars/".$avatar."' />";
          echo "<p class='pseudo'>".$ligne['Pseudo']."</p>";
          if($ligne['EstProfesseur'])
            echo "<img src='../images/prof.png' />";
          echo "</a>";
          echo "<a class='disconnect' href='disconnect.php?returnurl=".$_SERVER["REQUEST_URI"]."'><i class='fas fa-sign-out-alt'></i></a>";
        }
      }
  }
?>