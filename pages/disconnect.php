<?php
    if(isset($_COOKIE["idUser"])){
        unset($_COOKIE["idUSer"]);
        setcookie("idUser",null, time()-3600);
    }
    header("Location: ".$_GET["returnurl"]);
?>