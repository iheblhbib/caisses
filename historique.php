<?php
  include('config.php');
  include('session.php');
  
$diff=[];  
  $statement1 = $connect->prepare("SELECT totalem FROM chargejour ORDER BY id DESC LIMIT 1");

  $statement1->execute();

  $result = $statement1->fetchAll();
 foreach ($result as $key) {
  $totalem=$key["totalem"];

 }
$statement = $connect->prepare("
    SELECT SUM(balance) as balance FROM `tbl_order` GROUP BY MONTH(tbl_order.order_date) ORDER BY tbl_order.balance ASC;
  ");

  $statement->execute();

  $balance = $statement->fetchAll();
$i = 0;
$row_num = 0;
foreach ($balance as $row) {

$diff[$i] = $row["balance"]-floatval($totalem);
$i++;
}
//var_dump($diff);
  //$diff = $totalem[0] - $balance[0];
?>
 <!DOCTYPE html>
<html lang="fr">
<style type="text/css">
  body {
margin : 20px;  
}

td.details-control {
    background: url('https://www.datatables.net/examples/resources/details_open.png') no-repeat center center;
    cursor: pointer;
}

tr.shown td.details-control {
   background: url('https://www.datatables.net/examples/resources/details_close.png') no-repeat center center;
}

tr.loading td.details-control {
 background :rgba(0, 0, 0, 0) url('http://i.imgur.com/mtfdoXy.gif') no-repeat scroll center center;
}

</style>
 <title>Historique</title>
 <script src="js/jquery.min.js"></script>
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <script src="js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
  <script src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.15/js/dataTables.bootstrap.min.js"></script>
  <body>
<div align="right">
        <a href="trial.php" class="btn btn-info btn-xs" style="padding: 5px 15px; border-radius: 30px;">Retour</i></i></a>
      </div>
    <div class="container">
  
<div class="container box">
   <br />
   <div class="table-responsive" style="overflow: hidden;">
    <br />
   <br/>
    <br /><br />
    <table id="myTable" class="table table-bordered table-striped">
     <thead>
      <tr>
       <th width="20%" style="background-color:#FFB6C1; text-align: center;">Mois</th>
       <th width="20%" style="background-color:#AFD8F3; text-align: center;">Caisse </th>
       <th width="20%" style="background-color:#D8F3AF; text-align: center;">Dépense</th>
       <th width="20%" style="background-color:#D8AFF3; text-align: center;">Balance</th>
       <th width="20%" style="background-color:#FFFACD; text-align: center;"> Moyenne/Jour</th>


      <th width="20%"></th>
      </tr>
     </thead>
       <tfoot></tfoot>
    </table>
    
   </div>
  </div>
</div>
<div id="userModal" class="modal fade">
 <div class="modal-dialog">
  <form method="post" id="user_form" enctype="multipart/form-data">
   <div class="modal-content" style = "width = 1200px">
    <div class="modal-header">
           <h4 class="modal-title">Voir détails</h4>

     <button type="button" class="close" data-dismiss="modal">&times;</button>
    </div>
    <div class="modal-body">
   <table id="view_details" class="table table-bordered table-striped">
    <center><h4 >VENTE</h4></center>
     <thead>
      <tr>
       <td width="20%">Nom</td>
       <td width="20%">Quantité</td>
        <td width="20%">Prix</td>
        <td width="20%">Total</td>
      </tr>
     </thead>
     <tfoot></tfoot>
    </table>
       <table id="view_depenses" class="table table-bordered table-striped">
         <center> <h4 >Dépenses</h4></center>
     <thead>
      <tr>
       <td width="20%">Nom</td>
       <td width="20%">Montant</td>
      </tr>
     </thead>
     <tfoot></tfoot>
    </table>
        <table id="view_balance" class="table table-bordered table-striped">
         <center> <h4 >Balance</h4></center>
     <thead>
      <tr>
       <td width="20%">Balance</td>
       <td width="20%">Montant</td>
      </tr>
     </thead>
     <tfoot></tfoot>
    </table>
    </div>
    <div class="modal-footer">
     <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
    </div>
   </div>
  </form>
 </div>
</div>
 
  </body>
</html>
<script type="text/javascript">
$(document).ready(function(){
    var table = $('#myTable').DataTable({
      "language": {
        url: 'https://cdn.datatables.net/plug-ins/1.10.15/i18n/French.json'
    },
          "processing":true,
          "serverSide":true,
           "order":[],
          "ajax":{
          url:"select.php",
          type:"POST"
 },
  
          "columnDefs":[
          {
            "className": "details-control", "targets": -1,
            "orderable":false,
            "searchable":false, 
            "defaultContent": "",
          
          },
          
        ],
        });

    $('#myTable tbody').on('click', 'td.details-control', function () {
        var tr = $(this).closest('tr');
        var row = table.row( tr );
 
        if ( row.child.isShown() ) {
            
            row.child.hide();
            tr.removeClass('shown');
        }
        else {
            
            row.child( format(row.data()) ).show();
            tr.addClass('shown');
        }
    } );

    function format ( rowData ) {
                  console.log(rowData[0]);

    var div = $('<div/>')
        .addClass( 'loading' ); 
    $.ajax( {
        url: 'insertt.php',
        method: 'POST',
        data: {
            date: rowData[0]

        },
        dataType: 'json',
        success: function ( json ) {
            var tableDetails = "<table id='babe' class='table table-bordered table-striped'>";
            for (var i = json.length - 1; i >= 0; i--) {

              let newTr =  "<tr><td width='50%'>"+json[i][0]+"</td> <td width='50%'>"+json[i][1]+"</td><td width='30%'><button type='button' name='"+json[i][0]+"' id='"+json[i][2]+"' class='btn btn-warning btn-xs view'>Voir</button></td></tr>";
              tableDetails += newTr;
            }
            tableDetails += "</table>";
            div
                .append( tableDetails )
                .removeClass( 'loading' );
        }
    } );
 
    return div;
}
});

$(document).on('click', '.view', function(){
  var user_id = $(this).attr("id");
  var selected_date = $(this).attr("name");
console.log(user_id);
  $.ajax({
   url:"insert.php",
   method:"POST",
   data:{id:user_id, operation: 'View' ,date : selected_date},

      success:function(data)
   {
    $('#userModal').modal('show');
     $('.modal-title').text("voir détails");
    $('#action').val("View");
    $('#operation').val("View");
    var table =$('#view_details');
    var table_dep =$('#view_depenses');
    var table_bal =$('#view_balance');
var jsonData = JSON.parse(data); 
var jsonel = jsonData['orders'];
 var len = jsonel.length;
table.html('');
table.html('<tr><td colspan="2" align="center"><h2 style="margin-top:10.5px">Caisse</h2></td></tr><thead><tr><td width="20%">Nom darticle</td><td width="20%">Quantité</td><td width="20%">Prix unitaire</td><td width="20%">Totale</td><td width="20%">Remarque</td></tr></thead>')
for (var i = 0; i < len; i++) {
   el=jsonel[i];
  table.append('<tbody><tr><td width="10%">'+ el.item_name +'</td ><td width="20%">'+ el.order_item_quantity +'</td><td width="20%">' + el.order_item_price + '</td><td width="20%">'+ el.order_item_final_amount + '</td><td width="20%">'+ el.remarque + '</td></tr><tbody>');
}


var jsonel1 = jsonData['depenses'];
 var len = jsonel1.length;
table_dep.html('');
table_dep.html('depense<thead><tr><td width="20%">Nom</td><td width="20%">Montant</td></tr></thead>')
for (var i = 0; i < len; i++) {
   el=jsonel1[i];
   console.log(el);
  table_dep.append('<tbody><tr><td width="10%">'+ el["nom"] +'</td ><td width="20%">'+ el.montant +'</td></tr><tbody>');
}

var jsonel2 = jsonData['balance'];
 var len = jsonel2.length;
table_bal.html('');
table_bal.html('balance<thead><tr><td width="20%">Montant</td></tr></thead>')
for (var i = 0; i < len; i++) {
   el=jsonel2[i];
   console.log(el);
  table_bal.append('<tbody><tr><td width="10%">'+ el["balance"] + ' </tr><tbody>');
}

} 
 });
});
</script>