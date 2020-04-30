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
          <button name="search" type="submit">Rechercher</button>
        </form>
      </div>
      <div id="account">
      <?php
    include '../scripts/usermanager.php';
        IsConnect();
      ?>
      </div>

    </header>

    <h2>Résultats de la recherche :</h2>
    <?php 
    if(isset($_POST["search"])){
        showResults();
    }
?>
</body>
</html>

<?php
function showResults(){
    $connect = connexion();
    $requete = "SELECT PersonneId, AvatarPath, Pseudo, Prenom, Nom, EstProfesseur FROM Personnes WHERE Pseudo LIKE \"".$_POST["searchBar"]."\";";
    $reponse = mysqli_query($connect,$requete);

    $ctrl = 0;

    while ($ligne = mysqli_fetch_array($reponse)) {
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
            $ctrl++;
    }

    if($ctrl == 0)
    echo "<h2>Aucun résultat</h2>";

    mysqli_free_result($reponse);
    mysqli_close($connect);
}
?>