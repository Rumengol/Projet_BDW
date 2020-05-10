<?php
    if(isset($_COOKIE["idUser"])){
        unset($_COOKIE["idUser"]);
        setcookie("idUser","", time()-3600, "/", "localhost", true, true);
    }
    echo $_COOKIE["idUser"];
    $url = $_GET["returnurl"] == "myprofile.php" ? "index.php" : $_GET["returnurl"] ;
    header("Location: ".$url);
?>