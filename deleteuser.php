<?php

include('database_connection.php');

if(isset($_POST["user_id"]))
{
 
 $statement = $connect->prepare(
  "DELETE FROM utilisateur  WHERE id = :id"
 );
 $result = $statement->execute(
  array(
   ':id' => $_POST["user_id"]
  )
 );
 
 if(!empty($result))
 {
  echo 'Data Deleted';
 }
}



?>
   
