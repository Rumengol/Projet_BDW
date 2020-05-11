<?php 
    include '../scripts/usermanager.php';
if(isset($_POST["edit"])){
    checkEdit();
}
?>
<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <link rel="stylesheet" href="../style/login.css" />
    <title>Éditer mes informations</title>
  </head>
  <body>
    <form action="editInfo.php" method="post" class="box">
      <h1>Éditer mes informations</h1>
      <input name="mail" type="text" value="<?php echo getUser($_COOKIE["idUser"])["Email"]; ?>" />
      <input name="password" type="password" placeholder="Ancien mot de passe" />
      <input name="newPass" type="password" placeholder="Nouveau mot de passe" />
      <input name="confirmNewPass" type="password" placeholder="Confirmer le mot de passe" />
      <input name="edit" type="submit" value="Enregistrer les modifications" />
    </form>
    <?php
    if(isset($erreur))
        echo "<p class='error'>".$erreur."</p>";
    ?>
  </body>
</html>

<?php
function checkEdit(){
    $erreur = null;
    $ligne = getUser($_COOKIE["idUser"]);
    $mail = $_POST["mail"];
    if(password_verify($_POST["password"], $ligne["HashMDP"])){
        if($_POST["newPass"] == $_POST["confirmNewPass"]){
            if(filter_var($mail, FILTER_VALIDATE_EMAIL)){
                $password = password_hash($_POST["newPass"],PASSWORD_DEFAULT);
                $connect = connexion();
                $requete = "UPDATE Personnes SET Email=\"".$mail."\",HashMDP=\"".$password."\" WHERE PersonneId=\"".$ligne["PersonneId"]."\";";
                $reponse = mysqli_query($connect,$requete);
                if($reponse != null){
                    header("Location: myprofile.php");
                }
                mysqli_close($connect);
            } else {
                $erreur = "L'e-mail saisi est inccorect";
            }
        } else {
            $erreur = "Les mauvais mots de passes ne correspondent pas.";
        }
    } else {
        $erreur = "L'ancien mot de passe est incorrect.";
    }
}
?>