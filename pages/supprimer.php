<?php
 $user = 'root';
 $password = 'root';
 $db = 'reseaudb';
 $host = 'localhost:3306';
 $connect = mysqli_connect($host,$user,$password,$db);
 if(mysqli_connect_errno())
     return null;
 else{
     $requete = "SELECT PostId FROM Posts WHERE PostId=".$_GET['id'].";";
     $reponse = mysqli_query($connect,$requete);
     if($reponse){
         $requete2 = "DELETE FROM Posts WHERE PostId=".$GET['id'].";";
         $reponse2 = mysqli_query($connect,$requete2);
         header("Location: " + $_GET['from']);
     }
 }
?>