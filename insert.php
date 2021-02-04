<?php
  include('config.php');

 if($_POST["operation"] == "View")
 {
 $id=$_POST["id"];
 $it=$_POST["date"];
  $statement = $connect->prepare(
   "SELECT item_name, order_item_quantity, order_item_price, order_item_final_amount, remarque FROM tbl_order_item where created='$it' "
 );
 $statement->execute();
 $result = $statement->fetchAll();
 

  // fetch depenses 2021-01-04

 $statement1 = $connect->prepare(
   "SELECT nom, montant FROM depenses where created='$it' "
 );
 $statement1->execute();
 $depenses = $statement1->fetchAll();
 //var_dump($statement1);


 $statement2 = $connect->prepare(
   "SELECT balance FROM tbl_order where order_date='$it' "
 );
 $statement2->execute();
 $balance = $statement2->fetchAll();
 //var_dump($statement1);

 $res['orders'] = $result;
$res['depenses'] = $depenses;
$res['balance'] = $balance;
  echo json_encode($res);
/*if($_POST["operation"] == "View")
 {
}*/
 
}
  ?>
