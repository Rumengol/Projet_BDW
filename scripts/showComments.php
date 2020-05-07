<?php
include 'usermanager.php';
$connect = connexion();
$requete = "SELECT * FROM Commentaires JOIN Personnes ON (Auteur=PersonneId) WHERE ParentPost=\"".$_GET['postid']."\";";
$reponse = mysqli_query($connect,$requete);
if($reponse != null){
    while($ligne = mysqli_fetch_array($reponse)){
        echo "<div class='comment'>";
        echo "<a href='profile.php?id=".$ligne["PersonneId"]."' class='commAuth'>".$ligne["Pseudo"]."</a>";
        echo "<p class='dateComment'>".$ligne["DateCommentaire"]."</p>";
        echo "<p class='commentContent'>".$ligne["Contenu"]."</p>";
        echo "</div>";
        //Rajouter de quoi supprimer le commentaire
    }
}
?>