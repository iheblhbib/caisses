<?php

//fetch_item.php

include('database_connection.php');

function get_total_all_records($connect)
{
 $statement = $connect->prepare("SELECT * FROM tbl_product");
 $statement->execute();
 $result = $statement->fetchAll();
 return $statement->rowCount();
}
 $output = array();
$query = '';
$query = "SELECT * FROM tbl_product";
if(isset($_POST["search"]["value"]))
{
 $query .= ' where name LIKE "%'.$_POST["search"]["value"].'%" ';
}
if(isset($_POST["order"]))
{
 $query .= ' ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
}
else
{
 $query .= ' ORDER BY id DESC ';
}
if($_POST["length"] != -1)
{
 $query .= ' LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
}
$statement = $connect->prepare($query);

$statement->execute();

	$result = $statement->fetchAll();
      $data = array();
$filtered_rows = $statement->rowCount();

	foreach($result as $row)
	{
	$sub_array = array();
// $sub_array[] = $image;
 $sub_array[] = $row["name"];
 $sub_array[] = $row["price"];
  $sub_array[] = '<button type="button" name="update" id="'.$row["id"].'" class="btn btn-warning btn-xs update"><span class="glyphicon glyphicon-edit"/></button><button type="button" name="delete" id="'.$row["id"].'" class="btn btn-danger btn-xs delete"><span class="glyphicon glyphicon-remove" /></button>
 ';


 $data[] = $sub_array;
}
$output = array(
 "draw"    => intval($_POST["draw"]),
 "recordsTotal"  =>  $filtered_rows,
  "recordsFiltered" => get_total_all_records($connect),
 "data"    => $data
);

	
	//echo $output;
        echo json_encode($output);

  /*$output .= '
            <div class="col-md-3" style="margin-top:12px;">  
                  <h4 class="text-info">'.$row["name"].'</h4>
                  <h4 class="text-danger">$ '.$row["price"] .'</h4>
                  <input type="hidden" name="hidden_name" id="name'.$row["id"].'" value="'.$row["name"].'" />
                  <input type="hidden" name="hidden_price" id="price'.$row["id"].'" value="'.$row["price"].'" />
             <input type="text" name="quantity" id="quantity' . $row["id"] .'" class="form-control" value="1" />
<input type="button" name="add_to_cart" id="'.$row["id"].'" style="margin-top:5px;" class="btn btn-success form-control add_to_cart" value="Ajouter" />
        </div>
            ';*/

?>
