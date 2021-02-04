<?php
 include('session.php');

?>


<?php
  //invoice.php  
  include('database_connection.php');

  $statement = $connect->prepare("
    SELECT * FROM tbl_order WHERE MONTH(tbl_order.order_date)=MONTH(CURRENT_DATE())
    ORDER BY order_id DESC
  ");

  $statement->execute();

  $all_result = $statement->fetchAll();

  $total_rows = $statement->rowCount();

  $stat = $connect->prepare("SELECT sum(order_total_after_tax) as sum, sum(final_amt) as final_amt, sum(balance) as balance FROM tbl_order  WHERE MONTH(tbl_order.order_date)=MONTH(CURRENT_DATE())
    ORDER BY order_id DESC
  ");

  $stat->execute();

  $res = $stat->fetchAll();

  $rest = $stat->rowCount();

  $sttat = $connect->prepare("SELECT totalem FROM chargejour ORDER BY id DESC LIMIT 1");
  $sttat->execute();

  $resultt = $sttat->fetch();
//var_dump($resultt);
//  $count = $sttat->rowCount();
   

    $item_name = '';

    $query = "
      SELECT name FROM tbl_product  ORDER BY  name ASC
    ";
    $statement = $connect->prepare($query);

    $statement->execute();

    $result = $statement->fetchAll();

    foreach($result as $row)
    {
      $item_name .= '<option value="'.$row["name"].'">'.$row["name"].'</option>';


    }
     

  $statement3 = $connect->prepare("
    SELECT SUM(balance) FROM `tbl_order`  ORDER BY `tbl_order`.`balance` ASC;
  ");

  $statement3->execute();

  $balance = $statement3->fetch();


  $statement4 = $connect->prepare("SELECT totalem FROM chargejour ORDER BY id DESC LIMIT 1");

  $statement4->execute();

  $totalem = $statement4->fetch();


  $diff = $totalem[0] - ($balance[0]/1000);



  $statement5 = $connect->prepare("SELECT sum(coutm) as c  FROM chargejour ");

  $statement5->execute();

  $coutm = $statement5->fetch();
 

?>
<!DOCTYPE html>
<html lang="fr">
  <head>
    <title></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <script src="js/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
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
      #add_row
      {
  width: 5%;      
  display: inline-block;
  font-size: 20px;
  margin: 4px 2px;
  cursor: pointer;
      }
       #adds_row
      {
  width: 5%;      
  display: inline-block;
  font-size: 20px;
  margin: 4px 2px;
  cursor: pointer;
      }
    </style>
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker.css" rel="stylesheet" type="text/css" />
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script>
    <script>
      $(document).ready(function(){
        $('#order_date').datepicker({
          format: "yyyy-mm-dd",
          autoclose: true,
          defaultViewDate: true,
        }).datepicker('setDate','0');


    $('#demo').datepicker({
    format: "mm-yyyy",
    viewMode: "months", 
    minViewMode: "months"
      }).datepicker('setDate','0'); 
      });
    </script>
    <div class="container-fluid">
      <?php
      if(isset($_GET["add"]))
      {
      ?>
    <div class="table-responsive">
  <form method="POST" id="invoice_form1" action="invoice_save.php">

          <table class="table table-bordered">
            <tr>
              <td colspan="2" align="center"><h2 style="margin-top:10.5px">Caisse</h2></td>
            </tr>
            <tr>
               <br/>
    
                     <br/>

                <td colspan="2">
                  <div class="row">
                    <div class="col-md-4">
                      <input type="text" name="order_date" id="order_date" class="form-control input-sm" readonly />
                     <!-- <a href="#" name="order_date" id="order_date" class="form-control input-sm"></a> -->
                    </div>
                  </div>
                  <br />
                  <table id="invoice-item-table" class="table table-bordered">
                    <tr>
                      <th width="10%">Libellé</th>
                      <th width="5%">Quantité</th>
                      <th width="5%">Prix</th>
                      <th width="15%">Total</th> 
                      <th width="10%">Remarque</th>
            
                    </tr>
                  </table>
                  <div align="right">
                    <button type="button" name="add_row" id="add_row" class="btn btn-success btn-xs">+</button>
                  </div>
                </td>
              </tr>
              <tr>
                <td align="right"><b>Total</td>
                <td align="right"><b><span id="final_total_amt"></span></b></td>
              </tr>
              <tr>
                <td colspan="2"></td>
              </tr>
              <tr>
                <td colspan="2" align="center">   
                  <input type="hidden" name="total_item" id="total_item" value="1" />
                <input type="submit" name="create_invoice" id="create_invoice" class="btn btn-info" value="Créer" />

                </td>
              </tr>
          </table>

      <table class="table table-bordered">
            <tr>
              <td> <H2 id="depenses_h2_id"></H2></td>
            </tr>
            <tr>
              <td colspan="2" align="center"><h2 style="margin-top:10.5px">Dépenses</h2></td>
            </tr>
            <tr>
                <td colspan="2">
                  <div class="row">

                  </div>
                  <br />
                  <table id="depenses-item-table" class="table table-bordered">
                    <tr>
                      <th width="10%">Nom</th>
                      <th width="10%">Montant</th>
            
                    </tr>
                  </table>
                  <div align="right">
                    <button type="button" name="adds_row" id="adds_row" class="btn btn-success btn-xs">+</button>
                  </div>
                </td>
              </tr>
              <tr>
                <td align="right"><b>Total</td>
                <td align="right"><b><span id="final_amt"></span></b></td>
                <input type="hidden" name="final_amt" id="final_amt_val" value="0" />
                  <input type="hidden" name="total_item_2" id="total_item_2" value="0" />

              </tr>
              <tr>
                <td colspan="2"></td>
              </tr>
              <tr>
                <td colspan="2" align="center">
                  <input type="hidden" name="total_item" id="total_item" value="1" />
                </td>
              </tr>
      </table>
      <input type="hidden" name="depenses_h2_val" id="depenses_h2_val"/>
     </form>

    </div>
      <script>  
      $(document).ready(function(){
        var final_total_amt = $('#final_total_amt').text();
        console.log(final_total_amt);
        var count = 0;
        $(document).on('click', '#add_row', function(){
          count++;
          $('#total_item').val(count);
          var html_code = '';
          html_code += '<tr type="hidden" id="row_id_'+count+'">';
          
          html_code += '<td><select name="item_name[]" id="item_name'+count+'" class="form-control action"><option value="">Select item_name</option> <?php echo $item_name; ?></select></td>';
                                
          html_code += '<td><input  type="text" name="order_item_quantity[]" id="order_item_quantity'+count+'" data-srno="'+count+'" class="form-control input-sm number_only order_item_quantity" value="0" /></td>';
          html_code += '<td><input type="text" name="order_item_price[]" id="order_item_price'+count+'" data-srno="'+count+'" class="form-control number_only order_item_price" value="0" readonly /></td>';
          
          html_code += '<td><input type="text" name="order_item_final_amount[]" id="order_item_final_amount'+count+'" data-srno="'+count+'" class="form-control input-sm order_item_final_amount" value="0" readonly /></td>';
          html_code += '<td><textarea type="text" name="remarque[]" id="remarque'+count+'" data-srno="'+count+'" class="form-control remarque" value="0"> </textarea></td>';
          html_code += '<td><button type="button" name="remove_row" id="'+count+'" class="btn btn-danger btn-xs remove_row">X</button></td>';
          $('#invoice-item-table').append(html_code);

 $('.action').change(function(){
  if($(this).val() != '')
  {
    var action = $(this).attr("id");
    console.log(action);

   var query = $(this).val();
      var result = '';
      if(action == 'item_name')
      {
        result = 'order_item_price1';
      }
   $.ajax({
    url:'fetch.php',
    method:"POST",
    data:{action:action, query:query},
    success:function(data)
    {
           //$('#item_name').val(data);
console.log(data)
      let indice = action.substring(9,action.length);      
     $('#order_item_price'+indice).val(data);

    }
   })
  }
 });
     //console.log($('#final_total_amt').attr('id'));


 $('.order_item_quantity').on('input propertychange',function(){

    let order_item_quantity_id = $(this).attr("id");
    let order_item_quantity_val = $(this).attr("order_item_quantity");
    let row_no = $(this).attr("data-srno");
    //$('#order_item_actual_amount'+row_no).val(total_item);
    cal_final_total(row_no);
  

 

        $(document).on('click', '.remove_row', function(){
          var row_id = $(this).attr("id");
          var total_item_amount=0;
           total_item_amount = $('#order_item_final_amount'+row_id).val();
          console.log(total_item_amount);
          var final_amount = $('#final_total_amt').text();

          var result_amount = Number(final_amount) - Number(total_item_amount);
                    $('#final_total_amt').text(result_amount);
          $('#row_id_'+row_id).remove();

          count--;

          $('#total_item').val(count);
        });


        });

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
            if(quantity >= 0)
            {
              price = $('#order_item_price'+j).val();
              if(price >= 0)
              {
                actual_amount = parseFloat(quantity) * parseFloat(price);
                $('#order_item_actual_amount'+j).val(actual_amount);

                item_total = parseFloat(actual_amount);
                final_item_total = parseFloat(final_item_total) + parseFloat(item_total);
                $('#order_item_final_amount'+j).val(item_total);
              }
            }
          }
          $('#final_total_amt').text(final_item_total);

        }
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

      function cal_diff(){
        var diff = 0;
        let final_amt1 = $('#final_total_amt').text();
        let final_amt2 = $('#final_amt').text();

        let tot1 =  parseFloat(final_amt1);
        let tot2 =  parseFloat(final_amt2);
        
        diff = tot1 - tot2;

        if (diff != 'NaN'){
        $('#depenses_h2_id').text(diff);
        $('#depenses_h2_val').val(diff);

        }

      }
          $(document).ready(function(){
        var final_amt = $('#final_amt').text();
        var count = 0;
         $(document).on('click', '#adds_row', function(){
          count++;
          $('#total_item_2').val(count);
          var html_code = '';
          html_code += '<tr id="row_id_'+count+'">';          
          html_code += '<td><input type="text" name="nom[]" id="nom'+count+'" class="form-control input-sm" value="0"/></td>'; 
          html_code += '<td><input type="text" name="montant[]" id="montant'+count+'" data-srno="'+count+'" class="form-control input-sm montant" value="0" /></td>';
          html_code += '<td><button type="button" name="removes_row" id="'+count+'" class="btn btn-danger btn-xs removes_row">X</button></td>';
          html_code += '</tr>';
          $('#depenses-item-table').append(html_code);
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
          
           /*$.post('invoice_save.php', {final_amt: final_amt},
            function(){ alert('Data sent'); }).fail(function(){ alert('An error has ocurred'); });*/


          cal_diff();
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
        <form method="POST" id="invoice_form" action="invoice_save.php">
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
                      <th width="20%">Nom de l'article</th>
                      <th width="5%">Quantité</th>
                      <th width="5%">Prix</th>
                      <th width="12.5%">Total</th>
                    </tr>
                    <tr>
                    </tr>
                    <?php
                    $statement = $connect->prepare("
                      SELECT * FROM tbl_order_item 
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
                      <td><input type="text" name="item_name[]" id="item_name<?php echo $m; ?>" class="form-control input-sm" value="<?php echo $sub_row["item_name"]; ?>" /></td>

                      <td><input type="text" name="order_item_quantity[]" id="order_item_quantity" data-srno="<?php echo $m; ?>" class="form-control input-sm order_item_quantity" value = "<?php echo $sub_row["order_item_quantity"]; ?>"/></td>
                      <td><input type="text" name="order_item_price[]" id="order_item_price" data-srno="<?php echo $m; ?>" class="form-control input-sm number_only order_item_price" value="<?php echo $sub_row["order_item_price"]; ?>" /></td>
                      <td><input type="text" name="order_item_final_amount[]" id="order_item_final_amount" data-srno="<?php echo $m; ?>" readonly class="form-control input-sm order_item_final_amount" value="<?php echo $sub_row["order_item_final_amount"]; ?>" /></td>
                    </tr>
                    <?php
                    }
                    ?>
                  </table>
                </td>
              </tr>
              <tr>
                <td align="right"><b>Total</td>
                <td align="right"><b><span id="final_total_amt"><?php echo $row["order_total_after_tax"]; ?></span></b></td>

              </tr>
              <tr>
                <td colspan="2"></td>
              </tr>
              <tr>
                <td colspan="2" align="center">
                  <input type="hidden" name="total_item" id="total_item" value="<?php echo $m; ?>" />
                  <input type="hidden" name="order_id" id="order_id" value="<?php echo $row["order_id"]; ?>" />
                  <input type="submit" name="update_invoice" id="create_invoice" class="btn btn-info" value="Edit" />
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
  <div align="right">
        <a href="trial1.php" class="btn btn-info btn-xs" style="padding: 5px 15px; border-radius: 30px;">Retour</i></i></a>
      </div>
      <br />

    <div class="table-responsive">
    <table class="table table-bordered">
      <br />
      <div align="left">
      <input type="text" name="demo" id="demo"  style="background-color:#9400D3; color: #FDFEFE; font-size:30px; text-align: center;margin-left: 35%;margin-right: 35%;width: 30%;" class="form-control input-sm" readonly  />
      </div>
      <table id="data-table" class="table table-bordered table-striped" style="width:50%">
        <thead>
          <tr>
            <th style="background-color:#FFB6C1; text-align: center;">Date</th>
            <th style="background-color:#AFD8F3; text-align: center;">Caisse</th>
            <th style="background-color:#D8F3AF; text-align: center;">Dépense</th>
            
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
                <td>'.$row["order_total_after_tax"].'</td>
                <td>'.$row["final_amt"].'</td>
               
              </tr>
            ';
          }
        }
        if ($rest>0) {
foreach($res as $row)
          {
           echo '
              <tr>
              <td>Totaux</td>
                <td id="sum" value='.$row["sum"].'>'.$row["sum"].' </td>
                <td   id="final_amt" value='.$row["final_amt"].'>'.$row["final_amt"].' </td>
              
                </tr>';
          }
           }
           ?>

 </table>
 <table id="data-table" class="table table-bordered table-striped" style="width:50%">
           <?php
  
        if ($rest>0) {
      foreach($res as $row) {
              echo'  
     <tr><td>NET</td><td style="background:#ea79ff;"><span id="net">'.floatval($row["sum"] - $row["final_amt"]).'</span></td></tr>
     ';
     }
   }
    ?>

       </table>
       
 <table id="data-table" class="table table-bordered table-striped" style="width:50%">
           <?php
  
        if ($rest>0) {
      foreach($res as $row) {
              echo'  
     
     <tr><td>Moy/Jour</td><td><span id="moy_id">'.floatval($row["sum"]/31).'</span></td></tr> 
     <tr><td>Projection</td><td><span id="project">'.floatval(($row["sum"]/30)*30).'</span></td></tr> ';
     }
   }
    ?>

       </table>
  <table id="data-table" class="table table-bordered table-striped" style="width:30%;margin-left: 65%;margin-top: -10%;">
         <thead>
          <tr style="background: #85e96c;">
           <th colspan="2"><center>Balance du mois</center></th>
         </tr>
          </thead>
          <tbody>
            <tr> 
              <td style="background: #ef4949;">charge</td>
              <td style="background: #494eef;">Caisse</td>
            </tr>
          
            <?php
        if ($rest>0) {
      foreach($res as $row) {

              echo'   
     <tr><td><span id="coutm">'. floatval($coutm['c']).'</span></td>
     <td><span id="caisse">'.floatval(($row["sum"] - $row["final_amt"])/1000).'</span></td></tr> ';
     }
   }
    ?>

     </tbody>
     <tfoot>

        <th colspan="2" style="background: #f13737;">
         <center>
            <?php
        if ($rest>0) {
      foreach($res as $row) {
              echo'
   <span id="caisse">'.floatval((($row["sum"] - $row["final_amt"])/1000) - ($coutm['c'])).'</span></th>';
     }
   }
    ?>
</center>
         </tr>

     </tfoot>
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
//.floatval($row["balance"]/30).

        $('#nbjour_id').on('input propertychange', function(){
          var nbjour = $(this).val();
       console.log(nbjour);
           $.ajax({
    url:'invoice_save.php',
    method:"POST",
    data:{nbjour:nbjour, action:'save_nbjour'},
    success:function(data)
    {
$('#moy_id').text(data);
    }
       })
           $.ajax({
    url:'select.php',
    method:"POST",
    data:{nbjour:nbjour},
    success:function(data)
    {
    }
       })
          console.log(nbjour);

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
