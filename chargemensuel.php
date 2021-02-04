
<?php
  //invoice.php  
  include('config.php');

  $statement = $connect->prepare("
    SELECT * FROM charges
  ");

  $statement->execute();

  $all_result = $statement->fetchAll();

  $total_rows = $statement->rowCount();

  $stat = $connect->prepare("SELECT sum(order_total_after_tax) as sum FROM tbl_order 
  ");

  $stat->execute();

  $res = $stat->fetchAll();

  $rest = $stat->rowCount();



  ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <script src="js/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
  <script src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.15/js/dataTables.bootstrap.min.js"></script>
    <style>
      /* Remove the navbar's default margin-bottom and rounded borders */ 
      .navbar {
      margin-bottom: 4px;
      border-radius: 0;
      }
      /* Add a gray background color and some padding to the footer */
      footer {
      background-color: #f2f2f2;
      padding: 25px;
      }
      .carousel-inner img {
      width: 100%; /* Set width to 100% */
      margin: auto;
      min-height:200px;
      }
      .navbar-brand
      {
      padding:5px 40px;
      }
      .navbar-brand:hover
      {
      background-color:#ffffff;
      }
      /* Hide the carousel text when the screen is less than 600 pixels wide */
      @media (max-width: 600px) {
      .carousel-caption {
      display: none; 
      }
      }
    </style>
  </head>
  <body>
    <style>
      .box
      {
      width: 100%;
      max-width: 1390px;
      border-radius: 5px;
      border:1px solid #ccc;
      padding: 15px;
      margin: 0 auto;                
      margin-top:50px;
      box-sizing:border-box;
      }
    </style>
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker.css" rel="stylesheet" type="text/css" />
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script>
    <script>
      $(document).ready(function(){



    $('#order_date').datepicker({
    format: "mm-yyyy",
    viewMode: "months", 
    minViewMode: "months"
      }).datepicker('setDate','0'); 
      });
    </script>
<div id="Modal" class="modal fade">
 <div class="modal-dialog">
  <form method="post" id="user_form" enctype="multipart/form-data">
   <div class="modal-content" style = "width = 1200px">
    <div class="modal-header">
           <h4 class="modal-title">Voir</h4>

     <button type="button" class="close" data-dismiss="modal">&times;</button>
    </div>
    <div class="modal-body">
   <table id="voir_charge" class="table table-bordered table-striped">
     <thead>
      <tbody>
      <tr>
       
      </tr>
      </tbody>
     </thead>
     <tfoot></tfoot>
    </table>
    </div>
    <div class="modal-footer">
     <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    </div>
   </div>
  </form>
 </div>
</div>

    <div class="container-fluid">
      <?php
      if(isset($_GET["add"]))
      {
      ?>
   <br /><br />

    <div class="table-responsive" style="overflow: hidden;">
   <br/> 
  <form method="POST" id="invoice_form1" action="chargemensuel_save.php">
    <h2 style="margin-top:10.5px; text-align: center;">charges mensuelles</h2>
          <table class="table table-bordered" style=" width: 80%; margin-left: 10%; margin-right: 10%;">
            <tr>
                <td colspan="2">
                  <div class="row">
                    <div class="col-md-4">
                      <input type="text" name="order_date" id="order_date" class="form-control input-sm" style ="background-color:#9400D3; color: #FDFEFE; font-size:30px; text-align: center; width: 100%; "readonly />
                    </div>
                  </div>
                  <br />
                  <table id="invoice-item-table" class="table table-bordered">
                                        <tr>
                      <th width="10%">Nom</th>
                      <th width="10%">Montant</th>
            

                    </tr>
                  </table>
                  <div align="right">
                    <button type="button" name="adds_row" id="add_row" class="btn btn-success btn-xs">+</button>
                  </div>
                </td>
              </tr>
              <tr>
                <td align="center" style="width:50%;"><b>Total</td>
                <td align="right"><b><span id="final_amt"></span></b></td>
                <input type="hidden" name="final_amt" id="final_amt_val" value="0" />
                  <input type="hidden" name="total_item_2" id="total_item_2" value="0" />

              </tr>
              <tr>
                  <input type="hidden" name="total_item" id="total_item" value="1" />
              </tr>
          </table>
          <center>
 <input type="submit" name="create_invoice" id="create_invoice" class="btn btn-info" value="Créer" />
 </center>

     </form>
   <div align="right">
    
        <a href="trial.php" class="btn btn-info btn-xs" style="padding: 5px 15px; border-radius: 30px;">Retour</i></i></a>
      </div>
    </div>
      <script>
      $(document).ready(function(){
        var final_total_amt = $('#final_total_amt').text();
        console.log(final_total_amt);
        var count = 0;
       /* $(document).on('blur', '.order_item_price', function(){
          cal_final_total(count);
        });*/


        $('#create_invoice').click(function(){
         
          if($.trim($('#order_date').val()).length == 0)
          {
            alert("Please Select Invoice Date");
            return false;
          }

          for(var no=1; no<=count; no++)
          {
          

           /* if($.trim($('#order_item_quantity'+no).val()).length == 0)
            {
              alert("Please Enter Quantity");
              $('#order_item_quantity'+no).focus();
              return false;
            }*/

           /* if($.trim($('#order_item_price'+no).val()).length == 0)
            {
              alert("Please Enter Price");
              $('#order_item_price'+no).focus();
              return false;
            }*/

          }


          $('#invoice_form').submit();

        });

      });


          $(document).ready(function(){
        var final_amt = $('#final_amt').text();
        var count = 0;
         $(document).on('click', '#add_row', function(){
          count++;
          $('#total_item_2').val(count);
          var html_code = '';
          html_code += '<tr id="row_id_'+count+'">';          
          html_code += '<td><input type="text" name="nom[]" id="nom'+count+'" class="form-control input-sm" value="0"/></td>'; 
          html_code += '<td><input type="text" name="montant[]" id="montant'+count+'" data-srno="'+count+'" class="form-control input-sm montant" value="0" /></td>';
          html_code += '<td><button type="button" name="removes_row" id="'+count+'" class="btn btn-danger btn-xs removes_row">X</button></td>';
          html_code += '</tr>';
          $('#invoice-item-table').append(html_code);
        });
   
$(document).on('blur', '.montant', function(){
  //alert("aze");
    let row_not = $(this).attr("data-srno");
     console.log(row_not);
          cal_total(row_not);
        });
        function cal_total(count)
        {
          var final_item_total2 = 0;
          final_item_total2 = Number($('#final_amt').val());
          for(j=1; j<=count; j++)
          {
                var actual_amount = $('#montant'+j).val();

                console.log('actual amount',actual_amount);
                var item_total = parseFloat(actual_amount);
                console.log(typeof actual_amount);
                if ( typeof actual_amount != 'undefined'){
                final_item_total2 = parseFloat(final_item_total2) + parseFloat(item_total);

                }
                //$('#final_amt'+j).val(item_total);
          }
          $('#final_amt').text(final_item_total2);
          $('#final_amt_val').val(final_item_total2);
          
        }
        $(document).on('click', '.removes_row', function(){
          var row_id = $(this).attr("id");     
          var id = $(this).attr("data-srno");

/*
          var total_item_amount=0;
           total_item_amount = $('#montant'+row_id).val();
          console.log(total_item_amount);
          var final_amount = $('#final_amt').text();

          var result_amount = Number(final_amount) - Number(total_item_amount);
                    $('#final_amt').text(result_amount);
         */ $('#row_id_'+row_id).remove();

          //count--;
          var c = Number($('#total_item_2').val());
          c--;
          $('#total_item_2').val();
          cal_total(count);
        });


      });
      </script>
      <?php
      }
      elseif(isset($_GET["update"]) && isset($_GET["id"]))
      {
        $statement = $connect->prepare("
          SELECT * FROM tbl_order 
            WHERE order_id = :order_id
            LIMIT 1
        ");
        $statement->execute(
          array(
            ':order_id'       =>  $_GET["id"]
            )
          );
        $result = $statement->fetchAll();
        foreach($result as $row)
        {
        ?>
        <script>
        $(document).ready(function(){
          $('#order_date').val("<?php echo $row["order_date"]; ?>");
           $('.order_item_quantity').on('input propertychange',function(){

    let order_item_quantity_id = $(this).attr("id");
    let order_item_quantity_val = $(this).attr("order_item_quantity");
    let row_no = $(this).attr("data-srno");
    let order_item_price = Number($('#order_item_price'+row_no).val());
    let total_item = order_item_price * order_item_quantity_val;
    
    //$('#order_item_actual_amount'+row_no).val(total_item);
    cal_final_total(row_no);

 });
      
        function cal_final_total(count)
        {
          var final_item_total = 0;
          for(j=1; j<=count; j++)
          {
            var quantity = 0;
            var price = 0;
            var actual_amount = 0;
            var item_total = 0;
            quantity = $('#order_item_quantity'+j).val();
            if(quantity > 0)
            {
              price = $('#order_item_price'+j).val();
              if(price > 0)
              {
                actual_amount = Number(quantity) * parseFloat(price);
                console.log(actual_amount);
                $('#order_item_actual_amount'+j).val(actual_amount);

                item_total = parseFloat(actual_amount);
                final_item_total = parseFloat(final_item_total) + parseFloat(item_total);
                $('#order_item_final_amount'+j).val(item_total);
              }
            }
          }
          console.log(final_item_total);
          $('#final_total_amt').Number(final_item_total);
        }

        });
        </script>
        <form method="POST" id="invoice_form" action="chargemensuel.php">
        <div class="table-responsive">
          <table class="table table-bordered">
            <tr>
              <td colspan="2" align="center"><h2 style="margin-top:10.5px">Edit Invoice</h2></td>
            </tr>
            <tr>
                <td colspan="2">
                  <div class="row">
                    <div class="col-md-4">
                      <input type="text" name="order_date" id="order_date" class="form-control input-sm" readonly  />
                    </div>
                  </div>
                  <br />
                  <table id="invoice-item-table" class="table table-bordered">
                    <tr>
                      <th width="20%">Nom </th>
                      <th width="5%">montant</th>
                    </tr>
                    <tr>
                    </tr>
                    <?php
                    $statement = $connect->prepare("
                      SELECT * FROM item_chargemensuel 
                      WHERE order_id = :order_id
                    ");
                    $statement->execute(
                      array(
                        ':order_id'       =>  $_GET["id"]
                      )
                    );
                    $item_result = $statement->fetchAll();
                    $m = 0;
                    foreach($item_result as $sub_row)
                    {
                      $m = $m + 1;
                    ?>
                    <tr>
                      <td><input type="text" name="nom[]" id="nom<?php echo $m; ?>" class="form-control input-sm" value="<?php echo $sub_row["nom"]; ?>" /></td>
                      <td><input type="text" name="montant[]" id="montant" data-srno="<?php echo $m; ?>" class="form-control input-sm number_only montant" value="<?php echo $sub_row["montant"]; ?>" /></td>
                    </tr>
                    <?php
                    }
                    ?>
                  </table>
                </td>
              </tr>
              <tr>


              </tr>
              <tr>
                <td colspan="2"></td>
              </tr>
              <tr>
                <td colspan="2" align="center">
                  <input type="hidden" name="total_item" id="total_item" value="<?php echo $m; ?>" />
                  <input type="hidden" name="order_id" id="order_id" value="<?php echo $row["order_id"]; ?>" />
                </td>
              </tr>
          </table>
               
        </div>
      </form>
  
        <?php 
        }
      }
      else
      {
      ?>
      <h3 align="center"> </h3>

      <br />
<div align="right">
        <a href="chargemensuel.php?add=1" class="btn btn-info btn-xs">Create</a>
      </div>
    <div class="table-responsive">
    <table class="table table-bordered">
      <br />
      <div align="left">
      <input type="text" name="demo" id="demo" class="form-control input-sm" readonly  />
      </div>
      <table id="data-table" class="table table-bordered table-striped">
        <thead>
          <tr>
            <th>Date</th>
            <th>Total</th>
            <th>voir</th>


          </tr>
        </thead>
        <?php
        if($total_rows > 0)
        {
          foreach($all_result as $row)
          {
            echo '
              <tr>
                <td>'.$row["order_date"].'</td>
                <td>'.$row["order_item_final_amount"].'</td>
                <td><a href="javascript:;" name="voir" id="'.$row["id"].'" class="btn btn-sm btn-primary voir"><span class="glyphicon glyphicon-edit"></span></a></td>
              </tr>
            ';
          }
        }
       
        ?>
        <tr>
          <td colspan="3" align="center">
          </td>
        </tr>
      </table>
    </div>
    </table>
      <?php
      }
      ?>
 
    </div>

      

    <br>
   <!-- <footer class="container-fluid text-center">
      <p>Footer Text</p>
    </footer> -->
  </body>
</html>
<script type="text/javascript">
  
  $(document).on('click', '.voir', function(){
  var user_id = $(this).attr("id");
  $.ajax({
   url:"chargem.php",
   method:"POST",
   data:{id:user_id},

      success:function(data)
   {
    console.log(data);
    
    $('#Modal').modal('show');
     $('.modal-title').text("voir");
     var table =$('#voir_charge');
var jsonData = JSON.parse(data); 
 var len = jsonData.length;
table.html('');
table.html('<thead><tr><td width="20%">Nom </td><td width="20%">Montant</td></thead>')
for (var i = 0; i < len; i++) {
   el=jsonData[i];
  table.append('<tbody><tr><td width="10%">'+ el.nom +'</td ><td width="20%">'+ el.montant +'</td></tr><tbody>');
}

  }
})
})

</script>
<script type="text/javascript">
  $(document).ready(function(){
    var table = $('#data-table').DataTable({
          "order":[],
          "columnDefs":[
          {
            "targets":[4, 5, 6],
            "orderable":false,
          },
        ],
        "pageLength": 25
        });
    
  });
  $('#ajouter').click(function(){
          alert("drf");

      var date_mois = $('#demo').val();
      var somme = $('#sum').html();
      var order_date= $('#order_date').html();
          console.log(date_mois);
          console.log(order_date);
          console.log(somme);
$.ajax({
    type: "POST",
    url: "month.php",
    data:
    {date_mois: date_mois, somme: somme},
    success: function(data)
    {
$("#data-table").remove();
    }
});        
});
</script>

<script>
$(document).ready(function(){
$('.number_only').keypress(function(e){
return isNumbers(e, this);      
});
function isNumbers(evt, element) 
{
var charCode = (evt.which) ? evt.which : event.keyCode;
if (
(charCode != 46 || $(element).val().indexOf('.') != -1) &&      // “.” CHECK DOT, AND ONLY ONE.
(charCode < 48 || charCode > 57))
return false;
return true;
}
});
</script>
<script type="text/javascript">
 $('.order_item_quantity').on('input propertychange',function(){

    let order_item_quantity_id = $(this).attr("id");
    let order_item_quantity_val = $(this).attr("order_item_quantity");
    let row_no = $(this).attr("data-srno");
    let order_item_price = Number($('#order_item_price'+row_no).val());
    let total_item = order_item_price * order_item_quantity_val;
    
    //$('#order_item_actual_amount'+row_no).val(total_item);
    cal_final_total(row_no);

 });

        $(document).on('click', '.remove_row', function(){
          var row_id = $(this).attr("id");
          console.log(row_id);
          var total_item_amount = $('#order_item_final_amount'+row_id).val();
          console.log(total_item_amount);
          var final_amount = $('#final_total_amt').text();
          console.log(final_amount);
          var result_amount = parseFloat(final_amount) - parseFloat(total_item_amount);

          $('#final_total_amt').text(result_amount);
          $('#row_id_'+row_id).remove();

          count--;
              let total_item = order_item_price * order_item_quantity_val;

          $('#total_item').val(count);
        });


 
        


        function cal_final_total(count)
        {
          var final_item_total = 0;
          for(j=1; j<=count; j++)
          {
            var quantity = 0;
            var price = 0;
            var actual_amount = 0;
            var item_total = 0;
            quantity = $('#order_item_quantity'+j).val();
            if(quantity > 0)
            {
              price = $('#order_item_price'+j).val();
              if(price > 0)
              {
                actual_amount = parseFloat(quantity) * parseFloat(price);
                console.log(actual_amount);
                $('#order_item_actual_amount'+j).val(actual_amount);

                item_total = parseFloat(actual_amount);
                final_item_total = parseFloat(final_item_total) + parseFloat(item_total);
                $('#order_item_final_amount'+j).val(item_total);
              }
            }
          }
          console.log(final_item_total);
          $('#final_total_amt').text(final_item_total);
          cal_diff();
        }


</script>
