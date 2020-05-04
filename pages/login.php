    <?php
        if(isset($_POST["login"]))
            login();
    ?>

<!DOCTYPE html>
<html lang="fr">
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
            $requete = "SELECT Pseudo,PersonneId,HashMDP FROM Personnes WHERE Email LIKE \"".$_POST["mail"]."\";";
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
                echo '<p class="error">Adresse mail non reconnue.</p>';
            }

            echo '<form action="login.php" method="post">';
            echo '<fieldset>';
            echo '<label for="mail">Email :</label>';
            echo '<input name="mail" type="email" />';
            echo '<label for="password">Mot de passe :</label>';
            echo '<input name="password" type="password" />';
            echo '<button name="login" type="submit">Se connecter</button>';
            echo '</fieldset>';
            echo '</form>';


            mysqli_free_result($reponse);
            mysqli_close($connect);
        }
    }
?>