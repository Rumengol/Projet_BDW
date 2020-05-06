<?php
 $user = 'root';
 $password = 'root';
 $db = 'reseaudb';
 $host = 'localhost:3306';
 $connect = mysqli_connect($host,$user,$password,$db);
 if(mysqli_connect_errno())
 return http_response_code(500);
 else{
     $requete = "SELECT PostId FROM Posts WHERE PostId=\"".$_POST['id']."\";";
     $reponse = mysqli_query($connect,$requete);
     if($reponse != null){
         $requete2 = "DELETE FROM Posts WHERE PostId=\"".$_POST['id']."\";";
         $reponse2 = mysqli_query($connect,$requete2);
         if($reponse2 != null)
            return http_response_code(200);
        else return http_response_code(501);
     }
     return http_response_code(502);
 }
?>