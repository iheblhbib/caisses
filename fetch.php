<?php

if(isset($_POST['action']))
{
	include('database_connection.php');

	$output = '';

		$query = "
		SELECT price, name FROM tbl_product 
		WHERE name = :name 
		";
		$statement = $connect->prepare($query);
		$statement->execute(
			array(
				':name'		=>	$_POST["query"]
			)
		);
		$result = $statement->fetchAll();
		foreach($result as $row)
		{
			$output .= $row["price"];
			//$output .= $row["name"];

		}
	
	echo $output;
}

?>