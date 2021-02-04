<?php

//action.php

session_start();
include ('database_connection.php');

if(isset($_POST["action"]))
{

	if($_POST["operation"] == 'ajout'){
		$name=$_POST['name'];
		$price=$_POST['price'];

		$sql = "INSERT INTO tbl_product (name, price) 
		VALUES ('$name','$price')";
	 $statement = $connect->prepare($sql); 
$result = $statement->execute();
  if(!empty($result))
  {
   echo 'Data Inserted';
  }

	}

	if($_POST["operation"] == 'update'){
		$name=$_POST['name'];
		$price=$_POST['price'];
		$id=$_POST["user_id"];
		$sql = "UPDATE tbl_product SET name ='$name', price='$price' WHERE id='$id'";
	 $statement = $connect->prepare($sql); 
$result = $statement->execute();
  if(!empty($result))
  {
   echo 'Data updated';
  }

	}

}
/*if(count($_POST)>0){
	if($_POST['type']==2){
		$id=$_POST['id'];
		$name=$_POST['name'];
		$price=$_POST['price'];

		$sql = "UPDATE `produits` SET name ='$name', price='$price' WHERE id='$id'";
		if (mysqli_query($conn, $sql)) {
			echo json_encode(array("statusCode"=>200));
		} 
		else {
			echo "Error: " . $sql . "<br>" . mysqli_error($conn);
		}
		mysqli_close($conn);
	}
}*/
?>