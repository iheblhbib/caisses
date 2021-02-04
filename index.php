<?php
       session_start();

	  if(!isset($_SESSION["username"])){
   		 header("Location: login.php");
    	exit(); 
  }

if($username !== "" && $password !== "")
    {
        $requete = "SELECT * , count(*) FROM utilisateur where 
              nom_utilisateur = '".$username."' and mot_de_passe = '".$password."'";
        $exec_requete = mysqli_query($db,$requete);
        $reponse      = mysqli_fetch_array($exec_requete);
        
   

        if($count!=0 ) // nom d'utilisateur et mot de passe correctes
        {

         $type = $reponse['type'];

          $_SESSION['type'] = $type ;
          $_SESSION['id'] = $reponse['type'];

      
         if ($_SESSION['type'] == 'admin') {

            header('Location: trial.php');
         }
         else
         {
            header('Location: trial1.php');
         }
          }
  else
        {
           header('Location: login.php?erreur=1'); // utilisateur ou mot de passe incorrect
        }
   
   }
?>