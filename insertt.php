
<?php
  include('config.php');

 // if($_POST["operation"] == "View")
 //{
 $it=$_POST["date"];

  $statement = $connect->prepare(
   "SELECT order_date as date, order_total_after_tax as totale, order_id FROM tbl_order where MONTH(tbl_order.order_date)=$it order by order_date ASC "
 );
 $statement->execute();
 $result = $statement->fetchAll();
 //}
foreach($result as $row)
{

 $sub_array = array();

 $sub_array[] = $row["date"];
 $sub_array[] = $row["totale"];


  //$sub_array[] = '<button type="button" name="view" id="'.$row["id"].'" class="btn btn-warning btn-xs view">view</button>';

 $data[] = $sub_array;
}
  echo json_encode($result);
/*if($_POST["operation"] == "View")
 {
}*/
  ?>