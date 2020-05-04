<?php
    if(isset($_COOKIE["idUser"])){
        unset($_COOKIE["idUser"]);
        setcookie("idUser","", time()-3600, "/", "localhost", true, true);
    }
    echo $_COOKIE["idUser"];
    header("Location: ".$_GET["returnurl"]);
?>