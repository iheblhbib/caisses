<?php
  //invoice.php  
  include('database_connection.php');

   
  // save invoice 

  if(isset($_POST["total_item"])){   

   $order_total_after_tax = 0;
    $total = 0;
    $total1 = 0;
    $dat=trim($_POST["order_date"]);
   // var_dump($dat);
  
     $total1 = $total + floatval(trim($_POST["final_amt"]));

$statement = $connect->prepare("
      INSERT INTO chargemensuel 
        (order_date, order_item_final_amount)
        VALUES (:order_date, :order_item_final_amount)
    ");
    $statement->execute(
      array(
          ':order_date'  =>  trim($_POST["order_date"]),
      ':order_item_final_amount' => $total1,
      )
    );


  $statement = $connect->prepare("
   SELECT id from chargemensuel ORDER BY id DESC LIMIT 1
  ");

  $statement->execute();

  $order_id = $statement->fetch();

$order_id = $order_id["id"];         

var_dump($order_id);
      for($count=0; $count<$_POST["total_item_2"]; $count++)
      {


        $total = $total + floatval(trim($_POST["final_amt"]));
        $statement = $connect->prepare("
          INSERT INTO item_chargemensuel 
          (order_id, nom, montant, order_date, final_amt)
          VALUES (:order_id, :nom, :montant, :order_date, :final_amt)
        ");

        $statement->execute(
          array(
            ':order_id'       =>$order_id,
            ':nom'              =>  trim($_POST["nom"][$count]),
            ':montant'          =>  trim($_POST["montant"][$count]),
            ':order_date'           =>  trim($_POST["order_date"]),
            ':final_amt'           =>  trim($_POST["final_amt"]),

          )
        );

      }


    header("location:chargemensuel.php");
  }



  ?>