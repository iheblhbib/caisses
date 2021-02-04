<?php
  include('database_connection.php');
echo "hkj";;

  if(isset($_POST["create_charge"])){  
        $totalem = $_POST["totalem"];
  for($count=0; $count<$_POST["total_item"]; $count++)
      {

        $id = $_POST["ch_id"][$count];
        if ($id == "-1"){
         $id = $count+1; 
        } 
        var_dump("id  ".$id);
        $coutm = $_POST["montant"][$count]; 
        $name = $_POST["nom"][$count]; 
        $final_amt = $_POST["final_amt"][$count]; 

 
        $sql = "
          INSERT INTO item_chargemensuel 
          (id, nom, montant, final_amt)
          VALUES (:id,:nom, :montant, :final_amt)
          on duplicate key update nom = ".$name.",montant = ".$montant.",final_amt = ".$final_amt." ";
          var_dump("sql =====".$sql."=============");
      
    //$statement->debugDumpParams();

}
      header("location:chargemensuelle.php");

}
  ?>