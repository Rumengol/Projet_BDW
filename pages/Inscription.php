

<html>
<head>
    <meta charset="utf-8" />
    <title>inscription</title>
</head>
<body>
	<div align="center">
        <?php register(); ?>
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

if(isset($_POST['forminscription']))
{
	if(!empty($_POST['pseudo']) && !empty($_POST['mail']) && !empty($_POST['mail2']) && !empty($_POST['mdp']) && !empty($_POST['mdp2']))
	{
		echo "ok";
	}
	else
	{
		echo "non";
	}
}
}
?> 