<?php
  include('database_connection.php');
$somme=trim($_POST["somme"]);
$date_mois=$_POST["date_mois"];

    $statement = $connect->prepare(
      "INSERT INTO tbl_mois (month, somme) VALUES (:month, :somme)");
    $statement->execute(
      array(
':month' => $date_mois,
':somme' => $somme
      )
    );
       echo json_encode($statement);
 
  ?>