<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Résultat de la recherche</title>
</head>
<body>
<header>
      <h1>C'est pas facebook mais presque</h1>
      <div id="search">
        <form action="search.php" method="post">
          <input type="text" name="searchBar" id="searchBar" placeholder="Chercher un pseudo">
          <button type="submit">Rechercher</button>
        </form>
      </div>
      <div id="account">
      <?php
        IsConnect();
      ?>
      </div>

    </header>

    <?php 
    if(isset($_POST['searchBar'])){
        showResults();
    }
?>
</body>
</html>

<?php
include '../scripts/usermanager.php';
function showResults(){
    $connect = connexion();
    $requete = "SELECT PersonneId, AvatarPath, Pseudo, Prenom, Nom, EstProfesseur FROM Personnes WHERE Pseudo LIKE \'".$_POST["searchBar"]."';";
    $reponse = mysqli_query($connect,$requete);
    do {
        if($ligne["Pseudo"] == null)
            echo "<h2 class='notFound'>Aucun résultat</h2>";
        else{
            echo "<div class='searchResult'>";
            echo "<a href='profile.php?id=".$ligne["PersonneId"]."'>";
            echo "<img src='../images/avatars/".$ligne["AvatarPath"]."' class='avatar'>";
            echo "<div class='pseudo'>";
            echo "<h2>".$ligne["Pseudo"]."</h2>";
            echo "<h3>".$ligne["Prenom"]." ".$ligne["Nom"]."</h3>";
            echo "</div>";
            if($ligne["EstProfesseur"])
                echo "<img src='../images/prof.png' />";
            echo "</a></div>";
        }
    } while ($ligne = mysqli_fetch_array($reponse));
}
?>