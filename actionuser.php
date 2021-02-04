<?php

session_start();
include ('database_connection.php');

if(isset($_POST["action"]))
{

	if($_POST["operation"] == 'ajout'){
		$nom_utilisateur=$_POST['nom_utilisateur'];
		$mot_de_passe=$_POST['mot_de_passe'];
		$type=$_POST['type'];

		$sql = "INSERT INTO utilisateur (nom_utilisateur, mot_de_passe,type) 
		VALUES ('$nom_utilisateur','$mot_de_passe','$type')";
	 $statement = $connect->prepare($sql); 
$result = $statement->execute();
  if(!empty($result))
  {
   echo 'Data Inserted';
  }

	}

	if($_POST["operation"] == 'update'){
		$nom_utilisateur=$_POST['nom_utilisateur'];
		$mot_de_passe=$_POST['mot_de_passe'];
		$type=$_POST['type'];
		$id=$_POST["user_id"];
		
		$sql = "UPDATE utilisateur SET nom_utilisateur ='$nom_utilisateur', mot_de_passe ='$mot_de_passe' ,type ='$type' WHERE id='$id'";
	 $statement = $connect->prepare($sql); 
$result = $statement->execute();
  if(!empty($result))
  {
   echo 'Data updated';
  }

	}

}

?>