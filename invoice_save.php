<?php
  //invoice.php  
  include('database_connection.php');

if (isset($_POST["action"])){
$nbjour=$_POST["nbjour"];
 $statement = $connect->prepare("SELECT sum(balance) as balance FROM tbl_order  WHERE MONTH(tbl_order.order_date)=MONTH(CURRENT_DATE())");

  $statement->execute();

  $result = $statement->fetch();
  
  $moy = $result["balance"]/$nbjour;
  

echo json_encode($moy);

}else{
  
  $statement = $connect->prepare("
    SELECT * FROM tbl_order WHERE MONTH(tbl_order.order_date)=MONTH(CURRENT_DATE())
    ORDER BY order_id DESC
  ");

  $statement->execute();

  $all_result = $statement->fetchAll();

  $total_rows = $statement->rowCount();

  $stat = $connect->prepare("SELECT sum(order_total_after_tax) as sum FROM tbl_order 
  ");

  $stat->execute();

  $res = $stat->fetchAll();

  $rest = $stat->rowCount();
  $sttat = $connect->prepare("SELECT totalem FROM chargejour ORDER BY id DESC LIMIT");
  $sttat->execute();

  $result = $sttat->fetchAll();

  $count = $sttat->rowCount();
   
  // save invoice 

  if(isset($_POST["total_item"])){   

   $order_total_after_tax = 0;
    $total = 0;
    $total1 = 0;
    //item_name
    //order_item_quantity dec
    //order_item_price dec
    // order_item_final_amount dec
    // remarque txt
     $total1 = $total + floatval(trim($_POST["final_amt"]));
	$balance = 0;
     $balance= $balance + floatval(trim($_POST["depenses_h2_val"]));
    // var_dump($balance);

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


      //var_dump("expression ---".$order_id);

   $order_total_after_tax = 0;

      for($count=0; $count<$_POST["total_item_2"]; $count++)
      {


        $order_total_after_tax = $order_total_after_tax + floatval(trim($_POST["order_item_final_amount"][$count]));
        $statement = $connect->prepare("
          INSERT INTO tbl_order_item 
          (order_id, item_name, order_item_quantity, order_item_price, remarque, order_item_final_amount, created)
          VALUES (:order_id, :item_name, :order_item_quantity, :order_item_price, :remarque, :order_item_final_amount, :created)
        ");

        $statement->execute(
          array(
            ':order_id'               =>  $order_id,
            ':item_name'              =>  trim($_POST["item_name"][$count]),
            ':order_item_quantity'          =>  trim($_POST["order_item_quantity"][$count]),
            ':order_item_price'           =>  trim($_POST["order_item_price"][$count]),
            ':remarque'           =>  trim($_POST["remarque"][$count]),
            ':order_item_final_amount'        =>  trim($_POST["order_item_final_amount"][$count]),
            ':created' =>  date("Y-m-d")

          )
        );
      }




  $statement = $connect->prepare("
   SELECT order_id from tbl_order ORDER BY order_id DESC LIMIT 1
  ");

  $statement->execute();

  $order_id = $statement->fetch();

$order_id = $order_id["order_id"];



//var_dump($order_id);
      for($count=0; $count<$_POST["total_item_2"]; $count++)
      {


        $total = $total + floatval(trim($_POST["final_amt"]));
        $statement = $connect->prepare("
          INSERT INTO depenses 
          (nom, order_id, montant,  order_date, final_amt, created)
          VALUES (:nom, :order_id, :montant, :order_date, :final_amt, :created)
        ");

        $statement->execute(
          array(
            ':nom'              =>  trim($_POST["nom"][$count]),
            ':order_id'               =>  $order_id, 
            ':montant'          =>  trim($_POST["montant"][$count]),
            ':order_date'           =>  trim($_POST["order_date"]),
            ':final_amt'           =>  trim($_POST["final_amt"]),
            ':created' =>  date("Y-m-d")

          )
        );

//var_dump("expression".$order_total_after_tax);
      //var_dump("expression1".$order_id1);

        $sql = "UPDATE tbl_order SET order_total_after_tax = ".$order_total_after_tax." WHERE tbl_order.order_id = ".$order_id.";";
//var_dump($sql);
	  $statement = $connect->prepare($sql);
      
      $statement->execute();

      }


      header("location:invoice.php");
  }



if(isset($_POST["update_invoice"]))
  {
      $order_total_after_tax = 0;
      
      $order_id = $_POST["order_id"];
      
      
      
      $statement = $connect->prepare("
                DELETE FROM tbl_order_item WHERE order_id = :order_id
            ");
            $statement->execute(
                array(
                    ':order_id'       =>      $order_id
                )
            );
      
      for($count=0; $count<$_POST["total_item_2"]; $count++)
      {
        $order_total_before_tax = $order_total_before_tax + floatval(trim($_POST["order_item_actual_amount"][$count]));
        $order_total_tax1 = $order_total_tax1 + floatval(trim($_POST["order_item_tax1_amount"][$count]));
        $order_total_tax2 = $order_total_tax2 + floatval(trim($_POST["order_item_tax2_amount"][$count]));
        $order_total_tax3 = $order_total_tax3 + floatval(trim($_POST["order_item_tax3_amount"][$count]));
        $order_total_after_tax = $order_total_after_tax + floatval(trim($_POST["order_item_final_amount"][$count]));
        $statement = $connect->prepare("
          INSERT INTO tbl_order_item 
          (order_id, item_name, order_item_quantity, order_item_price, remarque, order_item_final_amount) 
          VALUES (:order_id, :item_name, :order_item_quantity, :order_item_price, :remarque, :order_item_final_amount)
        ");
        $statement->execute(
          array(
            ':order_id'                 =>  $order_id,
            ':item_name'                =>  trim($_POST["item_name"][$count]),
            ':order_item_quantity'          =>  trim($_POST["order_item_quantity"][$count]),
            ':order_item_price'            =>  trim($_POST["order_item_price"][$count]),
            ':remarque'            =>  trim($_POST["remarque"][$count]),
            ':order_item_final_amount'      =>  trim($_POST["order_item_final_amount"][$count])
          )
        );
        $result = $statement->fetchAll();
      }
      $order_total_tax = $order_total_tax1 + $order_total_tax2 + $order_total_tax3;
      
      $statement = $connect->prepare("
        UPDATE tbl_order 
        SET 
        order_date = :order_date, 
        order_total_before_tax = :order_total_before_tax, 
        order_total_tax1 = :order_total_tax1, 
        order_total_tax2 = :order_total_tax2, 
        order_total_tax3 = :order_total_tax3, 
        order_total_tax = :order_total_tax, 
        order_total_after_tax = :order_total_after_tax 
        WHERE order_id = :order_id 
      ");
      
      $statement->execute(
        array(
          ':order_date'             =>  trim($_POST["order_date"]),
          ':order_total_before_tax'     =>  $order_total_before_tax,
          ':order_total_tax1'          =>  $order_total_tax1,
          ':order_total_tax2'          =>  $order_total_tax2,
          ':order_total_tax3'          =>  $order_total_tax3,
          ':order_total_tax'           =>  $order_total_tax,
          ':order_total_after_tax'      =>  $order_total_after_tax,
          ':order_id'               =>  $order_id
        )
      );
      
      $result = $statement->fetchAll();
            
      header("location:invoice.php");
  }
}

  ?>