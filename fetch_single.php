<?php
include('database_connection.php');
if(isset($_POST["user_id"]))
{
 $output = array();
 $statement = $connect->prepare(
  "SELECT * FROM tbl_product 
  WHERE id = '".$_POST["user_id"]."' 
  LIMIT 1"
 );
 $statement->execute();
 $result = $statement->fetchAll();
 foreach($result as $row)
 {
  $output["name"] = $row["name"];
  $output["price"] = $row["price"];

 }
 echo json_encode($output);
}
?>