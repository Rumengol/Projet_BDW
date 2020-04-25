

<html>
<head>
    <meta charset="utf-8" />
    <title>inscription</title>
</head>
<body>
	<div align="center">
        <?php 
        if(isset($_POST['forminscription']))
            register();
        ?>
        <h2>Inscription</h2>
        <br /> 
        <form method="POST" action="inscription.php">
            <table>
                <tr>   
                    <td align="right"> 
                        <label for="pseudo">
                        Pseudo :</label>
                    </td>
                    <td>
                        <input type="text"
                        placeholder="Votre pseudo"
                        id="pseudo"
                        name ="pseudo"/>
                    </td>
                </tr>
                <tr>   
                    <td align="right">
                        <label for="mail">
                        Mail :</label>
                    </td>
                    <td>
                        <input type="email"
                        placeholder="Votre mail"
                        id="mail"
                        name ="mail"/>
                    </td>
                </tr>
                <tr>    
                    <td align="right">
                        <label for="mail2">
                        Confirmation du mail :</label>
                    </td>
                    <td>
                        <input type="email"
                        placeholder="Confirmer votre mail"
                        id="mail2"
                        name ="mail2"/>
                    </td>
                </tr>
                <tr>    
                    <td align="right">
                        <label for="mdp">
                        Mot de passe :</label>
                    </td>
                    <td>
                        <input type="password"
                        placeholder="Votre mot de passe"
                        id="mdp"
                        name ="mdp"/>
                    </td>
                </tr>
                <tr>    
                    <td align="right">
                        <label for="mdp2">
                        Confirmation du mot de passe :</label>
                    </td>
                    <td>
                        <input type="password"
                        placeholder="Confirmer votre mdp"
                        id="mdp2"
                        name ="mdp2"/>
                    </td>
                </tr>
				<tr>
					<td align="right">
				<input type="submit" name="forminscription" value="S'inscrire"/>
					</td>
				</tr>
            </table>
            <br />    
        </form>
		<?php
		if(isset($erreur))
		{
            echo $erreur;
        }
		?>
    </div>
</body>
</html>

<?php
function register(){
  $user = 'root';
  $password = 'root';
  $db = 'espace_membre';
  $host ='localhost:3306';
  $connect = mysqli_connect($host, $user, $password, $db);



	if(!empty($_POST['pseudo']) && !empty($_POST['mail']) && !empty($_POST['mail2']) && !empty($_POST['mdp']) && !empty($_POST['mdp2']))
	{
		$pseudo = htmlspecialchars($_POST['pseudo']);
		$mail = htmlspecialchars($_POST['mail']);
		$mail2 = htmlspecialchars($_POST['mail2']);
		$mdp = sha1($_POST['mdp']);
		$mdp2 = sha1($_POST['mdp2']);
		
		$pseudolenght = strlen($pseudo);
		if($pseudolenght <= 255)
		{
			if($mail == $mail2)
			{
				if(filter_var($mail, FILTER_VALIDATE_EMAIL))
				{

					
					if($mdp == $mdp2)
					{
							$insertmbr = $bdd->prepare("INSERT INTO membres(pseudo, mail, motdepasse) VALUES(?,?,?)");
							$insertmbr->execute(array($pseudo, $mail, $mdp));
							$erreur = "Votre compte a bien été créé";
							header('Location: index.php');
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
				$erreur = "Vos adresses mails ne correspondent pas";
			}
		}
		else
		{
				$erreur = "Votre pseudo ne doit pas dépasser 255 caractères";
		}
			
	}
	else
	{
		$erreur = "Tous les champs doivent être remplis";
	}
}
        
?> 