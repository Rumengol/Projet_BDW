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

function getUserPosts($user){

    $connect = connexion();
    $requete = "SELECT * FROM Posts p JOIN Personnes ON (p.Auteur=PersonneId) WHERE p.Auteur=\"".$user."\" ORDER BY DatePoste DESC LIMIT 10;";
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
    echo "<form action='myprofile.php' type='POST'>";
    echo "<div class='profile'><div id='avatarBox'><label id='avatarLabel' for='editAvatar' onclick='activateSave()'><input name='AvatarInput' type='file' id='editAvatar'><img class='avatar' src='../images/avatars/".$avatar."' /><i class='fas fa-pencil-alt'></i></label></div>";
    echo "<div class='infos'>";
    if($ligne['Pseudo'] != $ligne['Prenom']){
        echo "<div id='pseudoBox' onclick='showPseudoInput()'><h2>".$ligne['Pseudo']."</h2><i class='fas fa-pencil-alt'></i></div>";
        echo "<div id='nameBox' onclick='showNameInput()'><h3>".$ligne['Prenom']." ".$ligne['Nom']."</h3><i class='fas fa-pencil-alt'></i></div>";
    }
    else
        echo "<div id='pseudoBox' onclick='showPseudoInput()'><h2>".$ligne['Prenom']." ".$ligne['Nom']."</h2><i class='fas fa-pencil-alt'></i></div>";
        echo "<input name='save' id='save' type='submit' value='Enregistrer' disabled>";
        echo "<br />";
      echo "</div>";

    echo $ligne['EstProfesseur'] ? "<i class='fas fa-graduation-cap'></i>" : "<div class='prof vide'></div>";
    if(isset($_COOKIE['idUser']) && $id != $_COOKIE['idUser']){
        if(!areFriends($id, $_COOKIE['idUser']))
            echo "<div id='addfriend' class='save'><a href='#' class='addFriendButton' onclick='sendFriendRequest(\"".$_COOKIE['idUser']."\",\"".$id."\")'><i class='fas fa-user'></i> Ajouter ami</a></div>";
        else
            echo "<div id='addfriend' class='save'><a href=class='addFriendButton' disabled><i class='fas fa-user'></i> Ajouter ami</a><a href='#' class='unfriend' onclick='unfriend(\"".$_COOKIE['idUser']."\",\"".$id."\")'><i class='fas fa-times'></i></a></div>";
    }
        echo "</div></form>";
}

  function showUserPosts($user){
    $reponse = getUserPosts($user);
    showPost($reponse);
}

function showPost($reponse){
    while($ligne = mysqli_fetch_array($reponse)) {
        echo "<div class='post' id='post_".$ligne["PostId"]."'>";
        echo "<div class='postHead'>";
        echo "<h2 class='postTitle'>".$ligne['Titre']."</h2>";
        echo "<h3 class='author'>Posté par <a href='profile.php?id=".$ligne["PersonneId"]."'>".$ligne['Pseudo']."</a></h3>";
        echo "</div>";
        if($ligne['CouverturePath'])
          echo "<img class='cover' src='../images/covers/".$ligne['CouverturePath']." />";
        echo "<p class='postContent'>".$ligne['Contenu']."</p>";
        echo "<div class='footnotes'>";
        echo "<a class='likeCounter' href='#post_".$ligne["PostId"]."' onclick='toggleLike(\"".$ligne["PostId"]."\")'><i class='far fa-heart'></i> ".$ligne['Likes']."</a>";
        echo "<a href='#post_".$ligne["PostId"]."' class='commentNb' onclick='toggleComments(\"".$ligne["PostId"]."\")'><i class='fas fa-comments'></i> ".getNbComments($ligne['PostId'])."</a>";
        echo "<p class='date'>le <b>".$ligne['DatePoste']."</b></p>";
        if(isset($_COOKIE['idUser']) && $_COOKIE['idUser'] == $ligne['PersonneId'])
        echo "<p class='postActions'><a href='#post_".$ligne["PostId"]."' onclick='showEditPostForm(\"".$ligne["PostId"]."\")'> <i class='fas fa-pencil-alt'></i> Éditer</a> |<a href='#post_".$ligne["PostId"]."' onclick='deletePost(\"".$ligne["PostId"]."\")'> <i class='fas fa-times'></i> Supprimer</a></p>";
        if(isset($_COOKIE["idUser"]))
          echo "<a class='commenter' href='#post_".$ligne["PostId"]."' onclick='showCommentForm(\"".$ligne["PostId"]."\")'>Commenter</a>";
        else
          echo "<p class='nocomment'>Commenter</p>";
        echo "</div></div>";
      }
}

function getNbComments($postId){
  $connect = connexion();
  $requete = "SELECT COUNT(ParentPost) commentCount FROM Posts JOIN Commentaires ON (PostId = ParentPost) WHERE PostId=\"".$postId."\" GROUP BY PostId;";
  $reponse = mysqli_query($connect,$requete);
  if($reponse != null){
    $rep = mysqli_fetch_array($reponse);
    return $rep["commentCount"]!=null ?  $rep["commentCount"] : "0";
  }
  else return "0";
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

  function showGroups($id){
    $connect = connexion();
    $requete = "SELECT GroupeId, Annee, Matiere FROM appartientpersonnegroupe JOIN groupes ON (Groupe=GroupeId) WHERE Personne=\"".$id."\";";
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

function showFriends($id){
  $connect = connexion();
  $requete = "SELECT PersonneId, Pseudo, AvatarPath, EstProfesseur FROM amis JOIN Personnes ON (Ami2=PersonneId) WHERE Ami1=\"".$id."\" UNION SELECT PersonneId, Pseudo, AvatarPath, EstProfesseur FROM amis JOIN Personnes ON (Ami1=PersonneId) WHERE Ami2=\"".$id."\";";
  $reponse = mysqli_query($connect,$requete);
  while($ligne = mysqli_fetch_array($reponse)){
      $avatar = $ligne["AvatarPath"]!=null ? $ligne["AvatarPath"] : "default.png";
      echo "<div class='friend'>";
      echo "<a href='profile.php?id=".$ligne["PersonneId"]."'>";
      echo "<img src='../images/avatars/".$avatar."' class='avatar' />";
      echo "<p class='pseudo'>".$ligne["Pseudo"];
      if($ligne['EstProfesseur'])
          echo " <i class='fas fa-graduation-cap'></i>";
      echo "</p></a></div>";
  }
  mysqli_free_result($reponse);
  mysqli_close($connect);
}
?>