<?php

if(isset($_POST['action']))
{
	include('database_connection.php');

	$output = '';
	
		$query = "SELECT nom_utilisateur, mot_de_passe , type FROM utilisateur ";
		$statement = $connect->prepare($query);
		$statement->execute(
			array(
				':nom_utilisateur'		=>	$_POST["nom_utilisateur"]
				':mot_de_passe'		=>	$_POST["mot_de_passe"]
				':type'		=>	$_POST["type"]
			)
		);
		$result = $statement->fetchAll();
		foreach($result as $row)
		{
			$output .= $row["nom_utilisateur"];
			$output .= $row["mot_de_passe"];
			$output .= $row["type"];
		

		}
	
	echo $output;
}

?>