<?php
include "../scripts/usermanager.php";
if(isset($_POST["save"]))
    editInfos();
if(!isset($_COOKIE["idUser"]))
    header("Location : /index.php");
if(isset($_POST['Post']) && !empty($_POST['Title']) && !empty($_POST['Content']))
    writePost();
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
    <script src="../scripts/editPost.html"></script>
    <title>Mon profil</title>
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
        <div class="profileAndPost">
    <?php 
        showUser($_COOKIE['idUser']); 
    ?>

    <form action="myprofile.php" method="post" class="postForm">
        <input type="text" class="Title" placeholder="Titre du message">
        <label class="imgLabel" for="ImagePath">Choisir une couverture</label>
        <input type="file" accept="image/png, image/jpeg" id="ImagePath" class="image">
        <textarea class="inactiveForm" name="Content" rows="5" cols="50" onclick="showPostForm()">Écrivez votre message...</textarea>
        
        <input class="submitPost" type="submit" name="Post" value="Publier">
    </form>

        </div>

    <div class="postContainer">
    <?php
        showUserPosts($_COOKIE['idUser']);
    ?>
    </div>
</div>

    <aside>
        <a href='editInfo.php' id="editLink">Editer mes informations</a>
        <h2>Mes Groupes</h2>
            <div class="asideContainer">
            <?php showGroups($_COOKIE["idUser"]); ?>
            </div>
            <h2>Mes Amis</h2>
            <div class ="asideContainer">
            <?php showFriends($_COOKIE["idUser"]); ?>
            </div>
    </aside>

    </div>
</body>
<script id="commentHtml" type="text/html">
    <form class="postForm" method="POST" action="../scripts/Commentaire.php">
    <textarea class="activeForm" name="commentaire" placeholder="Votre commentaire..."></textarea><br />
    <input name="returnurl" value="<?php echo $_SERVER['REQUEST_URI']; ?>" hidden >
    <input class="submitPost" type="submit" value="Poster mon commentaire" name="submit_commentaire" />
    <button class="submitPost" class="cancel" onclick="CancelComment()">Annuler</button>
    </form>
</script>
<script type="text/html" id="editHtml">
    <form action="../scripts/edit.php" method="post" class="postForm">
  <input type="text" name="Title" class="Title" />
  <input name="returnurl" value="<?php echo $_SERVER['REQUEST_URI']; ?>" hidden >
  <textarea name="Content" cols="30" rows="10" class="activeForm"></textarea>
  <div class="editActions">
    <input class="submitPost" type="submit" value="Éditer" />
    <button class="submitPost" onclick="cancelEdit()">Annuler</button>
  </div>
</form>
</script>
</html>

<?php
    function writePost(){
        $connect = connexion();
        $cover=null;
        if(!empty($_POST['ImagePath']))
            $cover=$_FILES['ImagePath']['name'];
        date_default_timezone_set('UTC');
        $requete = "INSERT INTO Posts (PostId,Titre,Contenu,DatePoste,Likes,CouverturePath,Auteur)
                    VALUES (\"".uniqid()."\",\"".$_POST['Title']."\",\"".$_POST['Content']."\",\"".date("Y-m-d H:i:s")."\",
                    0,\"".$cover."\",\"".$_COOKIE['idUser']."\");";
        $reponse = mysqli_query($connect,$requete);
        if($reponse!=null){
            if(!empty($_POST['ImagePath'])){
            $fichier = basename($_FILES['ImagePath']['name']);
            $dossier = '../images/covers/';
            move_uploaded_file($_FILES['fileUser']['tmp_name'], $dossier . $fichier);
            }   
        }
        mysqli_close($connect);
    }

    function editInfos(){
        $connect = connexion();
        $user = getUser($_COOKIE["idUser"]);
        if(isset($_POST["pseudoInput"])){
            $req1 =  "Pseudo=\"".$_POST["pseudoInput"]."\"";
            $requete = "UPDATE Personnes SET ".$req1." WHERE PersonneId=\"".$user["PersonneId"]."\";";
        $reponse = mysqli_query($connect,$requete);
        }
        if(isset($_POST["AvatarInput"])){
            $avatar=$_FILES['AvatarInput']['name'];
            $req2 = "AvatarPath=\"".$avatar."\";";
            $requete = "UPDATE Personnes SET ".$req2." WHERE PersonneId=\"".$user["PersonneId"]."\";";
        $reponse = mysqli_query($connect,$requete);
        if($reponse!=null){
            if(!empty($_POST['AvatarInput'])){
            $fichier = basename($_FILES['AvatarInput']['name']);
            $dossier = '../images/avatars/';
            move_uploaded_file($_FILES['fileUser']['tmp_name'], $dossier . $fichier);
            }   
        }
        }
        if(isset($_POST["nameInput"])){
            $fullName = explode(" ",$_POST["nameInput"]);
            $prenom = $fullName[0];
            $nom = implode(" ",array_splice($fullName, 0));
            $req3 = "Prenom=\"".$prenom."\",Nom=\"".$nom."\"";
            $requete = "UPDATE Personnes SET ".$req3." WHERE PersonneId=\"".$user["PersonneId"]."\";";
        $reponse = mysqli_query($connect,$requete);
        }
        mysqli_close($connect);
    }
?>