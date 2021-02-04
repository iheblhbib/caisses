<?php
  include('config.php');
 // $nbjour=$_POST["nbjour"];

$query = '';
$output = array();
  $statement1 = $connect->prepare("SELECT totalem FROM chargejour ORDER BY id DESC LIMIT 1");

  $statement1->execute();

  $result = $statement1->fetchAll();
 foreach ($result as $key) {
  $totalem=$key["totalem"];

 }
$query = "SELECT MONTH(tbl_order.order_date) as month, sum(order_total_after_tax) as somme , sum(balance) as balance , sum(final_amt) as depense, AVG(balance) as moy FROM tbl_order GROUP BY MONTH(tbl_order.order_date)";

$statement = $connect->prepare($query);
$statement->execute();
$result = $statement->fetchAll();
$data = array();
$filtered_rows = $statement->rowCount();
foreach($result as $row)
{

 $sub_array = array();

 $sub_array[] = $row["month"];
 $sub_array[] = $row["somme"];
  $sub_array[] =$row["depense"];

 $sub_array[] = $row["balance"];
 $sub_array[]= $row["moy"];
;



  //$sub_array[] = '<button type="button" name="view" id="'.$row["id"].'" class="btn btn-warning btn-xs view">view</button>';

 $data[] = $sub_array;
}
function get_total_all_records($connect)
{
 $statement = $connect->prepare("SELECT MONTH(tbl_order.order_date) as month, sum(order_total_after_tax) as sum FROM tbl_order GROUP BY MONTH(tbl_order.order_date)");
 $statement->execute();
 $result = $statement->fetchAll();
 return $statement->rowCount();
}

$output = array(
 "draw"    => intval($_POST["draw"]),
 "recordsTotal"  =>  $filtered_rows,
 "recordsFiltered" => get_total_all_records($connect),
 "data"    => $data
);
echo json_encode($output);
?>
