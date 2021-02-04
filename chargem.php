<?php
  include('config.php');

 // if($_POST["operation"] == "View")
 //{
 $it=$_POST["id"];

  $statement = $connect->prepare(
   "SELECT nom, montant from item_chargemensuel where order_id=$it and nom<>'' "
 );
 $statement->execute();
 $result = $statement->fetchAll();
 //}

  echo json_encode($result);
/*if($_POST["operation"] == "View")
 {
}*/
  ?>