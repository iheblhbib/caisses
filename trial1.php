<?php
include ('session.php');
include ('database_connection.php');
?>
 <!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" style="overflow: hidden;">
 <title>caisse</title>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
     <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker.css" rel="stylesheet" type="text/css" />
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script>
<link href="assets/css/bootstrap.css" rel="stylesheet" />
     <!-- FONTAWESOME STYLES-->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
     <!-- MORRIS CHART STYLES-->
   
        <!-- CUSTOM STYLES-->
    <link href="assets/css/custom.css" rel="stylesheet" />
     <!-- GOOGLE FONTS-->
   <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
     <!-- TABLE STYLES-->
    <link href="assets/js/dataTables/dataTables.bootstrap.css" rel="stylesheet" />
    
      <!--ASWESOME ICON-->
    <link rel="stylesheet" href="font-awesome-4.5.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="css/jquery.datetimepicker.css"/>

<!-- Perfect-DateTimePicker JS -->
<script type="text/javascript" src="js/jquery.datetimepicker.js"></script>
    
 </head>
  <script>
       $(document).ready(function(){

       $('#order_date').datepicker({
      selectOtherday: true,
    format: "yyyy-mm-dd",
    }).datepicker('setDate','0')
    $('tbody').click(function(){ window.location = "caisse1.php"; });
   });

  </script>
 <body>
  <br />

   <br />
 <nav class="navbar navbar-default" role="navigation">
        <div class="container-fluid" style="width: 55%;">
                      <div class="table-title">
                <div class="row" style="background: #428bca;">
                    <div class="col-sm-6">
            <h3 align="center" style="margin-top:10.5px;"><b style=" margin-left: 75%;font-size: 60px;color: white;">Caisse</b></h3>
          </div>
                </div>
            </div>
                    </div>
      </nav>   <br /><br />
   <br /><br />

<div class="panel panel-default">
             <center>            
<div id="order_date" name="order_date"></div>
                   </center>   
                            
                        </div>
       <div class="row">
 <center>
<a class="btn btn-primary" href="invoice1.php" role="button">Résultat/Mois</a>
<a class="btn btn-primary" href="ping1.php" role="button">Listes des articles</a>
<!--a class="btn btn-primary" href="chargemensuel.php?add=1" role="button">Charges Mensuelles</a-->
<a class="btn btn-primary" href="historique1.php" role="button">Historique</a>
<a class="btn btn-primary" href="chargejour1.php" role="button">Charges</a>
</center>
</div>
</br>
</br>
</br>
</br>
</br>
</br>
</br>
  <center> <a class="btn btn-primary" href="logout.php" role="button">Déconnexion</a></center>
