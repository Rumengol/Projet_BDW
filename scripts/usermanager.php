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
    $requete = "SELECT * FROM Personnes WHERE PersonneId = ".$_GET['id'].";";
    $reponse = mysqli_query($connect,$requete);
    $ligne = mysqli_fetch_array($reponse);

    if($ligne!=null){
        return $ligne;
    }

    mysqli_free_result($reponse);
    mysqli_close($connect);
}

//Le paramètre edit sert à indiquer si l'utilisateur peut ou non éditer les posts.
function getUserPosts($edit){

    $connect = connexion();

        $requete = "SELECT * FROM Posts WHERE Auteur=".$id." ORDER BY DatePoste DESC LIMIT 10";
        $reponse = mysqli_query($connect,$requete);
        $ligne = mysqli_fetch_array($reponse);
        if($ligne != null){
            foreach ($ligne as $line) {
                echo "<div class='post'>";
                echo "<h2 class='postTitle'>".$line['Titre']."</h2>";
                echo "<img class='cover' src='../images/covers/".$ligne['CouverturePath']." />";
                echo "<p class='postContent'>".$line['Contenu']."</p>";
                echo "<div class='footnotes'>";
                echo "<img src='../images/like.png' /> <p class='likeCounter'>".$line['Likes']."</p>";
                echo "<p class='date'>".$line['DatePost']."</p>";
                if($edit)
                    echo "<p class='postActions'><a href='#'>Éditer</a>|<a href='supprimer.php?id=".$line['PostId']."&from=myprofile.php'>Supprimer</a></p>";
                echo "</div>";
            }

            mysqli_free_result($reponse);
        }
        mysqli_close($connect);
    }

function showUser(){
    $ligne = getUser();
    echo "<div class='profile'><img class='avatar' src='../images/avatars/".$ligne['AvatarPath']."' />";
    if($ligne['Pseudo'] != $ligne['Prenom']){
        echo "<h2>".$ligne['Pseudo']."</h2>";
        echo "<h3>".$ligne['Prenom']." ".$ligne['Nom']."</h3>";
    }
    else
        echo "<h2>".$ligne['Prenom']." ".$ligne['Nom']."</h2>";
    
        echo $ligne['EstProfesseur'] ? "<img class='prof' src='../images/prof.png' />" : "<div class='prof vide'></div>";
    echo "</div>";
}
?>