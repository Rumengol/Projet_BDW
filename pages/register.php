<?php 
include "../scripts/usermanager.php";
        if(isset($_POST['register']))
            register();
        ?>

<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <link rel="stylesheet" href="../style/login.css" />
    <title>Inscription</title>
  </head>
  <body>
    <form action="register.php" method="post" class="box">
      <h1>S'inscrire</h1>
    <div id="columns">
        <div class="col">
      <input name="mail" type="email" placeholder="Entrez votre adresse e-mail" />
      <input type="text" name="prenom" id="prenom" placeholder="Entrez votre prénom">
      <input type="text" name="nom" id="nom" placeholder="Entrez votre nom">
    </div>
      <div class="col">
        <label id="pseudolabel" for="pseudo">Ce champ est optionnel</label>
      <input type="text" name="pseudo" id="pseudo" placeholder="Entrez votre pseudonyme">
      <input type="password" name="password" placeholder="Entrez votre mot de passe" />
      <input type="password" name="confirmPass" id="confirmPass" placeholder="Confirmez votre mot de passe">
    </div>
    </div>
    <input name="register" type="submit" value="S'inscrire" />
</form>
    <?php if(isset($erreur)){
        echo $erreur;
    }
    ?>
  </body>
</html>

<?php
function register(){
  $connect = connexion();

    $erreur = null;

	if(!empty($_POST['nom']) && !empty($_POST['mail']) && !empty($_POST['prenom']) && !empty($_POST['password']) && !empty($_POST['confirmPass']))
	{
        $prenom = htmlspecialchars($_POST['prenom']);
        $nom = htmlspecialchars($_POST["nom"]);
        $pseudo = isset($_POST["pseudo"]) ? $_POST["pseudo"] : $prenom;
        $mail = htmlspecialchars($_POST['mail']);
        if($_POST["password"] == $_POST["confirmPass"])
		    $mdp = password_hash($_POST['password'], PASSWORD_DEFAULT);
				if(filter_var($mail, FILTER_VALIDATE_EMAIL))
				{

					
					if($mdp != null)
					{
                        $id = uniqid();
                            $requete = "INSERT INTO Personnes (PersonneId,Email,Pseudo,HashMDP,Prenom,Nom)
                            VALUES (\"".$id."\",\"".$mail."\",\"".$pseudo."\",\"".$mdp."\",\"".$prenom."\",\"".$nom."\");";
                            $reponse = mysqli_connect($connect,$requete);
                            if($reponse != null){
                                header('Location: myprofile.php');
                                setcookie("idUser",$ligne["PersonneId"],time()+30*24*60*60,"/","localhost",true,true);
                            } else{
                                $erreur = "Erreur inconnue, veuillez réessayer.";
                            }
					}
					else
					{
						$erreur = "Vos mots de passe ne correspondent pas";
					}
				}
				else
				{
				$erreur = "Votre adresse mail n'est pas valide";
				}
			
	}
	else
	{
		$erreur = "Tous les champs doivent être remplis";
	}
}
        
?> 