<?php
  //invoice.php  
  include('config.php');
  session_start();
  $dataaa =  $_SESSION['date'];

 
 // $id=trim($_POST["id"])+1;
 // var_dump($id);

 // if(isset($_POST["total_item"])){   

 if($_POST["action"]=='caisse') { //    echo "vfkl";
if(isset($_POST["id"] )){
  
$sql = "UPDATE tbl_order_item SET item_name='".$_POST["item_name"]."', order_item_quantity='".$_POST["order_item_quantity"]."', order_item_price='".$_POST["order_item_price"]."', remarque='".$_POST["remarque"]."' ,order_item_final_amount='".$_POST["order_item_final_amount"]."' where order_item_id = '".$_POST["id"]."'";
$stt = $connect->prepare($sql);
var_dump($stt);
$stt->execute();

    echo "data updated";
  

}else{
  
            $item_name   =         trim($_POST["item_name"]);
            $order_item_quantity          =  trim($_POST["order_item_quantity"]);
            $order_item_price           = trim($_POST["order_item_price"]);
            $remarque          = trim($_POST["remarque"]);
            $order_item_final_amount        =  trim($_POST["order_item_final_amount"]);
   $order_total_after_tax = 0;
   $total1=0;
   $balance=0;
   $statement = $connect->prepare("
      INSERT INTO tbl_order 
        (order_date, order_total_after_tax, final_amt, balance, order_datetime)
        VALUES (:order_date, :order_total_after_tax, :final_amt, :balance, :order_datetime)
    ");
    $statement->execute(
      array(
          ':order_date'  =>  trim($_POST["order_date"]),
          ':order_total_after_tax' =>  $order_total_after_tax,
      ':final_amt' => $total1,
      ':balance' => $balance, 
          ':order_datetime' =>  date("Y-m-d")
      )
    );


      /*$statement = $connect->query("SELECT LAST_INSERT_ID()");
      $order_id = $statement->execute();
      $order_id1 = $order_id;*/
       $statement = $connect->prepare("
   SELECT order_id from tbl_order ORDER BY order_id DESC LIMIT 1
  ");

  $statement->execute();

  $order_id = $statement->fetch();

$order_id = $order_id["order_id"];
    $order_total_after_tax = $order_total_after_tax + floatval(trim($_POST["order_item_final_amount"]));
        $statement5 = $connect->prepare("
          INSERT INTO tbl_order_item 
          (item_name, order_id, order_item_quantity, order_item_price, remarque, order_item_final_amount, created)
          VALUES (:item_name, :order_id, :order_item_quantity, :order_item_price, :remarque, :order_item_final_amount, :created)
          ");

      $statement5->execute(
          array(
            //':order_item_id' =>trim($_POST["id"]),
            ':item_name'              =>  trim($_POST["item_name"]),
            ':order_id'               => $order_id,
            ':order_item_quantity'    =>  trim($_POST["order_item_quantity"]),
            ':order_item_price'       =>  trim($_POST["order_item_price"]),
            ':remarque'             =>  trim($_POST["remarque"]),
            ':order_item_final_amount'        =>  trim($_POST["order_item_final_amount"]),
            ':created' =>  trim($dataaa)

          )
        );
     
         // var_dump($statement5);
        $all_result = $statement5->fetchAll();
          //var_dump($statement5);
          //print_r($statement5->errorInfo());


  $total_rows = $statement5->rowCount();
 $id=$connect->lastInsertId();
echo $id;

     // header("location:invoice.php");
//}
/*
on duplicate key update item_name = '".$item_name."', order_id = ".$order_id.", order_item_quantity = ".$order_item_quantity.", order_item_price = ".$order_item_price.", remarque = '".$remarque."', order_item_final_amount = ".$order_item_final_amount." */
}
}
  if ($_POST["action"]=="save_tbl_order") {
  $final_amt1 = $_POST["final_amt1"];
  $final_amt2 = $_POST["final_amt2"];
  $date = $_POST["date"];
  $diff = $_POST["diff"];

  $statement5 = $connect->prepare("
          INSERT INTO tbl_order 
          (order_date ,order_total_after_tax, final_amt ,balance )
          VALUES (:order_date, :order_total_after_tax , :final_amt , :balance )
        ON duplicate KEY UPDATE order_total_after_tax = :order_total_after_tax, final_amt = :final_amt, balance = :balance  
          ");

      $statement5->execute(
          array(
            ':order_date' => $date, ':order_total_after_tax' => $final_amt1,
            ':final_amt' => $final_amt2,':balance' => $diff
          )
      );


}

/*if(isset($_POST["id"] )){
  
$sql = "UPDATE tbl_order_item SET item_name='".$_POST["item_name"]."', order_item_quantity='".$_POST["order_item_quantity"]."', order_item_price='".$_POST["order_item_price"]."', remarque='".$_POST["remarque"]."' ,order_item_final_amount='".$_POST["order_item_final_amount"]."' where order_item_id = '".$_POST["id"]."'";
$stt = $connect->prepare($sql);
$stt->execute();

    echo "data updated";
  

}else{*/

  if ($_POST["action"]=="depenses") {
    if(isset($_POST["id"] )){
  
$sql = "UPDATE depenses SET nom='".$_POST["nom"]."', montant='".$_POST["montant"]."' where id = '".$_POST["id"]."'";
var_dump($sql);
$stt = $connect->prepare($sql);
$stt->execute();

    echo "data updated";
  

}else{
  $statement5 = $connect->prepare("
          INSERT INTO depenses 
          (nom,  montant, created)
          VALUES (:nom, :montant, :created)
          ");
      $statement5->execute(
          array(
            //':order_item_id' =>trim($_POST["id"]),
            ':nom'              =>  trim($_POST["nom"]),
            ':montant'    =>  trim($_POST["montant"]),
            ':created' =>  date("Y-m-d")

          )
        );
     var_dump($statement5);

         // var_dump($statement5);
        $all_result = $statement5->fetchAll();
          //var_dump($statement5);
          //print_r($statement5->errorInfo());


  $total_rows = $statement5->rowCount();
 $id=$connect->lastInsertId();

echo $id;
}

}

  ?>

