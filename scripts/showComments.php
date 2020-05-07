<?php
include 'usermanager.php';
$connect = connexion();
$requete = "SELECT * FROM Commentaires JOIN Personnes ON (Auteur=PersonneId) WHERE ParentPost=\"".$_GET['postid']."\";";
$reponse = mysqli_query($connect,$requete);
if($reponse != null){
    while($ligne = mysqli_fetch_array($reponse)){
        echo "<div id='comment_".$ligne["CommentId"]."' class='comment'><div class='commentHead'>";
        echo "<p><a href='profile.php?id=".$ligne["PersonneId"]."' class='commAuth'>".$ligne["Pseudo"]."</a> <span class='dateComment'>".$ligne["DateCommentaire"]."</span></p>";
        echo "<a href='#post_".$ligne["ParentPost"]."' onclick='deleteComm(".$ligne["CommentId"].")'><i class='fas fa-times'></i></a>";
        echo "</div>";
        echo "<p class='commentContent'>".$ligne["Contenu"]."</p>";
        echo "</div>";
    }
}
?>