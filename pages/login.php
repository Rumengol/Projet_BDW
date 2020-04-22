    <?php
        if(isset($_POST["login"]))
            login();
    ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Identification en cours</title>
</head>
<body>
</body>
</html>

<?php
    function login()
    {
        $user = 'root';
        $password = 'root';
        $db = 'reseaudb';
        $host = 'localhost:3306';
        $connect = mysqli_connect($host,$user,$password,$db);

        if(mysqli_connect_errno())
            echo "Impossible de se connecter, veuillez réessayer.";
        else{
            $requete = "SELECT Pseudo,PersonneId FROM Personnes WHERE Email=".$_POST["mail"]." AND HashMDP=".password_hash($_POST["password"], PASSWORD_DEFAULT).";";
            $reponse = mysqli_query($connect,$requete);
            $ligne = mysqli_fetch_array($reponse);

            if($ligne!=null){
                echo "<p class='greets'>Bon retour, ".$ligne['Pseudo']." !</p>";
                echo "<p class='greets'>Vous allez être redirigé vers l'accueil...";

                setcookie("idUser",$ligne["PersonneId"],0,"/","localhost",true,true);

                $url = "localhost/index.html";
                header('Location: '.$url);
            }
            else{
                echo '<p class="error">Adresse mail ou mot de passe incorrect.</p>';
                echo '<form action="login.php" method="post">';
                echo '<fieldset>';
                  echo '<label for="mail">Email :</label>';
                  echo '<input name="mail" type="email" />';
                  echo '<label for="password">Mot de passe :</label>';
                  echo '<input name="password" type="password" />';
                  echo '<button name="login" type="submit">Se connecter</button>';
                echo '</fieldset>';
              echo '</form>';
            }

            mysqli_free_result($reponse);
            mysqli_close($connect);
        }
    }
?>