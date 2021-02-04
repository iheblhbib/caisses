<?php
  include('database_connection.php');

  if(isset($_POST["create_charge"])){  

        $totalj = $_POST["totalj"]; 
        $totalem = $_POST["totalem"];
  for($count=0; $count<$_POST["total_item"]; $count++)
      {

        $id = $_POST["ch_id"][$count];
        if ($id == "-1"){
         $id = $count+1; 
        } 
      //  var_dump("id  ".$id);
        $coutj = $_POST["montantt"][$count]; 
        $coutm = $_POST["montant"][$count]; 
        $nom = $_POST["nom"][$count]; 
 
        $sql = "
          INSERT INTO chargejour 
          (id, nom, coutm,coutj,totalem,totalj)
          VALUES ($id,'$nom', $coutm,$coutj,$totalem,$totalj)  
          on duplicate key update coutj = ".$coutj.",coutm = ".$coutm.",totalem = ".$totalem.",totalj =   
          ".$totalj.",nom = ".$nom;
          //var_dump("sql =====".$sql."=============");
        $statement = $connect->prepare("INSERT INTO chargejour 
          (id, nom, coutm,coutj,totalem,totalj)
          VALUES ($id,'$nom', $coutj,$coutm,$totalem,$totalj)
          on duplicate key update coutm = ".$coutm.",coutj = ".$coutj.",nom = '".$nom."',totalem = ".$totalem.",totalj = ".$totalj."
          ");

try{
        $statement->execute(
          array(
            ':id'               =>  $id,
            ':nom'               =>  $nom,
            ':coutm'              =>  $coutm,
            ':coutj'          =>  $coutj,
            ':totalj'           =>  $totalj,
            ':totalem'           =>  $totalem,
          )
        );
    }catch(Exception $ex){
   // var_dump($ex);
    }



}
     header("location:chargejour.php");

}
  ?>