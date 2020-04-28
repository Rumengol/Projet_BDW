<?php  
    include "../scripts/usermanager.php";
    $url = "myprofile.php";
    if($_GET['id'] == $_COOKIE['idUser'])
        header("Location: ".$url);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <?php echo "<title>Profil de ".getUser()['Pseudo']."</title>"; ?>
</head>
<body>
    
    <?php 
    showUser(); 
    
    showUserPosts(false,$_GET['id']); ?>
</body>
</html>
