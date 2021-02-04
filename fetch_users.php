<?php
include('database_connection.php');
if(isset($_POST["user_id"]))
{
 $output = array();
 $statement = $connect->prepare(
  "SELECT * FROM utilisateur 
  WHERE id = '".$_POST["user_id"]."' 
  LIMIT 1"
 );
 $statement->execute();
 $result = $statement->fetchAll();
 foreach($result as $row)
 {
  $output["nom_utilisateur"] = $row["nom_utilisateur"];
  $output["mot_de_passe"] = $row["mot_de_passe"];
  $output["type"] = $row["type"];
 }
 echo json_encode($output);
}
?>