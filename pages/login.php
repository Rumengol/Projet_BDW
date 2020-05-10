    <?php
        include "../scripts/usermanager.php";
        if(isset($_POST["login"]))
            login();
    ?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/login.css">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Identification en cours</title>
</head>
<body>
</body>
</html>

<?php
    function login()
    {
        $connect = connexion();

        if(mysqli_connect_errno())
            echo "Impossible de se connecter, veuillez réessayer.";
        else{
            $requete = "SELECT Pseudo,PersonneId,HashMDP FROM Personnes WHERE Email LIKE \"".$_POST["mail"]."\" OR Pseudo LIKE \"".$_POST["mail"]."\";";
            $reponse = mysqli_query($connect,$requete);
            if(gettype($reponse) != "boolean"){
                $ligne = mysqli_fetch_array($reponse);
            }
            else{
                echo " Ca a foiré quelque part";
                return;
            }

            if($ligne!=null){
                if(password_verify($_POST["password"], $ligne["HashMDP"])){
                echo "<p class='greets'>Bon retour, ".$ligne['Pseudo']." !</p>";
                echo "<p class='greets'>Vous allez être redirigé vers l'accueil...";

                setcookie("idUser",$ligne["PersonneId"],time()+30*24*60*60,"/","localhost",true,true);

                $url = "index.php";
                header('Location: '.$url);
                }
                else{
                    echo '<p class="error">Mot de passe incorrect, veuillez réessayer.</p>';
                }
            }
            else{
                echo '<p class="error">Adresse mail ou nom d\'utilisateur inconnu.</p>';
            }

            echo '<form class="box" action="login.php" method="post">';
            echo '<h1>Se Connecter</h1>';
            echo '<input name="mail" type="text" placeholder="Email ou nom d\'utilisateur" />';
            echo '<input name="password" type="password" placeholder="Mot de passe"/>';
            echo '<input name="login" type="submit" value="Se connecter">';
            echo '</form>';


            mysqli_free_result($reponse);
            mysqli_close($connect);
        }
    }
?>