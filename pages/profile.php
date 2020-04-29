<?php  
    include "../scripts/usermanager.php";
    $url = "myprofile.php";
    if($_GET['id'] == $_COOKIE['idUser'])
        header("Location: ".$url);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <?php echo "<title>Profil de ".getUser()['Pseudo']."</title>"; ?>
</head>
<body>
    
    <?php 
    showUser(); 
    
    showUserPosts(false,$_GET['id']); ?>

    <aside>
        <h2>Ses Groupes</h2>
        <?php showGroupes(); ?>
        <h2>Ses Amis</h2>
        <?php showFriends(); ?>
    </aside>
</body>
</html>

<?php
function showGroups(){
    $connect = connexion();
    $requete = "SELECT GroupeId, Annee, Matiere FROM appartientpersonnegroupe JOIN groupes ON (Groupe=GroupeId) WHERE Personne=\'".$_GET["id"]."';";
    $reponse = mysqli_query($connect,$requete);
    while($ligne = mysqli_fetch_array($reponse)){
        echo "<div class='group'>";
        echo "<a href='".$ligne["GroupeId"]."'>";
        echo "<p>".$ligne["Matiere"]." <i>".$ligne["Annee"]."</i></p>";
        echo "</a></div>";
    }
    mysqli_free_result($reponse);
    mysqli_close($connect);
}

function showFriends(){
    $connect = connexion();
    $requete = "SELECT PersonneId, Pseudo, AvatarPath, EstProfesseur FROM amis JOIN Personnes ON (Ami2=PersonneId) WHERE Ami1=\'".$_GET["id"]."'
    UNION SELECT PersonneId, Pseudo, AvatarPath, EstProfesseur FROM amis JOIN Personnes ON (Ami1=PersonneId) WHERE Ami2=\'".$_GET["id"]."';";
    $reponse = mysqli_query($connect,$requete);
    while($ligne = mysqli_fetch_array($reponse)){
        echo "<div class='friend'>";
        echo "<a href='".$ligne["PersonneId"]."'>";
        echo "<img src='../images/avatars/".$ligne["AvatarPath"]."' class='avatar' />";
        echo "<p class='pseudo'>".$ligne["Pseudo"]."</p>";
        if($ligne['EstProfesseur'])
            echo "<img src='../images/prof.png' />";
        echo "</a></div>";
    }
    mysqli_free_result($reponse);
    mysqli_close($connect);
}
?>