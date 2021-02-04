<?php
  //invoice.php  
  include('config.php');

  $statement = $connect->prepare("
    SELECT *  FROM tbl_order_item where created=DATEADD(day, 1, CAST(GETDATE())) and item_name<>'';
  ");

  $statement->execute();

  $all_result = $statement->fetchAll();

  $total_rows = $statement->rowCount();

 $statement2 = $connect->prepare("
    SELECT sum(order_item_final_amount) as sum FROM tbl_order_item where created=CURRENT_DATE()
  ");
  $statement2->execute();

  $sum_res = $statement2->fetch();

$statement3 = $connect->prepare("
    SELECT * FROM depenses where created=CURRENT_DATE();
  ");

  $statement3->execute();

  $all_results = $statement3->fetchAll();

  $totalrows = $statement3->rowCount();
   $statement4 = $connect->prepare("
    SELECT sum(montant) as cat FROM depenses where created=CURRENT_DATE()
  ");
  $statement4->execute();

  $sum_rest = $statement4->fetch();

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
 format: "yyyy-mm-dd",
          autoclose: true,
          defaultViewDate: true,
      }).datepicker('setDate','0'); 
      });

</script>
 <table class="table table-bordered">
   <br />
  <div align="left">
    <input align="center" type="text" name="order_date" id="order_date" class="form-control input-sm" style="background-color:#9400D3; color: #FDFEFE; font-size:20px; text-align: center;" readonly />
                     <!-- <a href="#" name="order_date" id="order_date" class="form-control input-sm"></a> -->
                    </div>
            <tr>
              <td colspan="2" align="center"><h2 style="margin-top:10.5px">Caisse</h2></td>
            </tr>
            <tr>

                <td colspan="2">
                  <div class="row">

                    
                  </div>
                  <br />
                  <table id="caisse-item-table" class="table table-bordered">
                    <tr>
                    <th width="10%" style="border: solid; background-color:#FFB6C1; text-align: center;">Libellé</th>
                      <th width="10%" style="border: solid; background-color:#ADD8E6; text-align: center;">Quantité</th>
                      <th width="10%" style="border: solid;background-color:#FFFACD ; text-align: center;">Prix</th>
                      <th width="10%" style="border: solid;background-color:#FF0000; color:#FDFEFE; text-align: center;">Total</th>
                      <th width="10%" height="30px" style="border: solid;background-color:#90EE90; text-align: center;">Remarque</th>
                    </tr>
<?php
        if($total_rows > 0)
        {
          $count = 0;
          foreach($all_result as $row)
          {
            $count++;
            echo '
          <tr id="row_id_'.$count.'">          
          <td style="border: solid;">
          <input type="text" name="ch_id[]" id="ch_id'.$count.'" value="'.$row["order_item_id"].'" hidden="true">
          <input type="text" name="item_name[]" id="item_name'.$count.'" class="form-control input-sm" value="'.$row["item_name"].'"/></td>

          <td style="border: solid;"><input  type="text" name="order_item_quantity[]" id="order_item_quantity'.$count.'" data-srno="'.$count.'" class="form-control input-sm number_only order_item_quantity" value="'.$row["order_item_quantity"].'" /></td>
          <td style="border: solid;"><input type="text" name="order_item_price[]" id="order_item_price'.$count.'" data-srno="'.$count.'" class="form-control input-sm " number_only order_item_price" value="'.$row["order_item_price"].'"  readonly /></td>   
          <td style="border: solid;"><input type="text" name="order_item_final_amount[]" id="order_item_final_amount'.$count.'" data-srno="'.$count.'" class="form-control input-sm  order_item_final_amount"  value="'.$row["order_item_final_amount"].'" readonly /></td>
           <td style="border: solid;"><textarea type="text" name="remarque[]" id="remarque'.$count.'" data-srno="'.$count.'" class="form-control input-sm  remarque" value="'.$row["remarque"].'">'.$row["remarque"].'</textarea></td>
           <td><input type="hidden" name="removes_row" id="'.$count.'" class="btn btn-danger btn-xs removes_row"></td>
          </tr>
            ';
          }
        }

       ?>

                  </table>
                  <div align="right">
        <button type="button" name="add_row" id="add_row" class="btn btn-success btn-xs">+</button>
                  </div>
                </td>
              </tr>
              <tr>
                <td width="10%" align="center" style="border: solid; font-size:20px;"><b>Total </td>
                <td  width="10%" align="center"><b><span style="font-size:20px" id="final_total_amt" ><?php echo $sum_res['sum'] ?></span></b></td>
              </tr>
              <tr>
                <td colspan="2" align="center">
              <input type="hidden" name="total_item" id="total_item" value="1" />
                </td>
              </tr> 
          </table>

<table class="table table-bordered">
            <tr>
            <td style="border: solid;" align="center"><b>Balance</td>
  <td style="border: solid;"><b><span style="font-size:20px" id="depenses_h2_id"></span></b><?php echo $sum_res['sum']-$sum_rest['cat']; ?></td>
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
                    <th width="10%" style="border: solid; background-color:#FFDAB9;">Libellés</th>
                      <th width="10%" style="border: solid; background-color:#AED6F1;">Montant</th>
                    </tr>

<?php
if($all_results > 0)
        {
          $count = 0;
          foreach($all_results as $row)
          {
            $count++;
            echo '
            <tr id="row_id_'.$count.'">          
          <td style="border: solid;"><input type="text" name="ch_id[]" value="'.$row["id"].'" hidden="true">
          <input type="text" name="nom[]" id="nom'.$count.'" class="form-control input-sm" value="'.$row["nom"].'"/></td>
          <td style="border: solid;"><input type="text" name="montant[]" id="montant'.$count.'" data-srno="'.$count.'" class="form-control number_only montant" value="'.$row["montant"].'" /></td>
        <td><input type="hidden" name="removes_row" id="'.$count.'" class="btn btn-danger btn-xs removes_row"/></td>
          </tr>
            ';
          }
        }

 ?>
  <!--<td><button type="hidden" name="removes_row" id="'.$count.'" class="btn btn-danger btn-xs removes_row">X</button></td> -->

                  </table>
                  <div align="right">
                    <button type="button" name="adds_row" id="adds_row" class="btn btn-success btn-xs">+</button>
                  </div>
                </td>
              </tr>
              <tr>
                <td align="center"><b>Total Dépenses </td>
                <td align="center" ><b><span  style="font-size:20px" id="final_amt" ><?php echo $sum_rest['cat'] ?></span></b></td>
              </tr>
              <tr>
                <td colspan="2" align="center">
                  <input type="hidden" name="total_item_2" id="total_item_2" value="1" />

                </td>
              </tr> 
          </table>
             <!--   <input type="hidden" name="depenses_h2_val" id="depenses_h2_val"/> -->

<!--  <input type="hidden" name="id" id="id" value="1" hidden="true"> -->

        
<script type="text/javascript">
  $(document).ready(function(){
  var final_amt = $('#final_amt').text();
  var count = <?php echo $total_rows ?>;
        $('#total_item').val(count);

         $(document).on('click', '#add_row', function(){
          count++;
          $('#total_item').val(count);
          var html_code = '';
          html_code += '<tr id="row_id_'+count+'">';    
          html_code += '<td style="border: solid;" width="10%"><select name="item_name[]" id="item_name'+count+'" class="form-control action"><option value="">Select item_name</option> <?php echo $item_name; ?></select></td>'; 
          html_code += '<td style="border: solid;"><input  type="text" name="order_item_quantity[]" id="order_item_quantity'+count+'" data-srno="'+count+'" class="form-control input-sm number_only order_item_quantity" value="0" onChange="saveNewItem('+count+')" /></td>';
          html_code += '<td style="border: solid;"><input type="text" name="order_item_price[]" id="order_item_price'+count+'" data-srno="'+count+'" class="form-control number_only order_item_price" value="0" readonly /></td>';
          html_code += '<td style="border: solid;"><input type="text" name="order_item_final_amount[]" id="order_item_final_amount'+count+'" data-srno="'+count+'" class="form-control input-sm order_item_final_amount" value="0" readonly /></td>';
          html_code += '<td style="border: solid;"><textarea type="text" name="remarque[]" id="remarque'+count+'" data-srno="'+count+'" class="form-control remarque" value="0" onChange="autosave('+count+')"> </textarea></td>';
          html_code += '<td><input type="hidden" name="remove_row" id="'+count+'" class="btn btn-danger btn-xs remove_row"></td>';
          /*html_code += '<td><button type="button" name="removes_row" id="'+count+'" class="btn btn-danger btn-xs removes_row">X</button></td>';*/
          html_code += '</tr>';
$('#caisse-item-table').append(html_code);
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

  });
  


/*  ENd OF ON READY DOC FN **/
}
  );
  /*  START EVENT FN UPDATE INPUT*/
   $('.order_item_quantity').on('input propertychange',function(){

console.log("Hello");
 let row_no = $(this).attr("data-srno");
 console.log(row_no);
  cal_final_total(row_no);
   autosave(row_no);

 }) ;

  /*  START EVENT FN UPDATE INPUT*/



function saveNewItem(count){
cal_final_total(count);
autosave(count);
}
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




function autosave(count){
  console.log("autosave FN",count);

  var item_name=0;
  var item_id=-1;
  var order_item_quantity=0;
  var order_item_final_amount=0;
  var order_item_price=0;
  var remarque =0;
  var order_date= $("#order_date").val();

 item_name = $("#item_name"+count).val();
 order_item_quantity =  $("#order_item_quantity"+count).val();
 order_item_final_amount = $("#order_item_final_amount"+count).val();
 order_item_price = $("#order_item_price"+count).val();
 remarque = $("#remarque"+count).val();
 item_id = $("#ch_id"+count).val();
 console.log(item_id);


//console.log(order_item_quantity);
//console.log(order_item_final_amount);

if(order_item_quantity !='0' && order_item_final_amount !='0')
{
  //console.log((order_item_quantity !=0 && order_item_final_amount !=0));
$.ajax({
  url:"data.php",
  method:"POST",
  data:{
  id: item_id,
  item_name:item_name,
  order_item_quantity:order_item_quantity,
  order_item_final_amount:order_item_final_amount,
  order_item_price:order_item_price,
  remarque:remarque,
  order_date:order_date,
action:'caisse',

  },
  success:function(data){
   // alert("edfr");
if(data != ""){
$("#id").val(data);
    }

} 

    });    

}
}
function save_tbl_order(diff){

  let final_amt1 = $('#final_total_amt').text();
  let final_amt2 = $('#final_amt').text();

  let tot1 =  parseFloat(final_amt1);
  let tot2 =  parseFloat(final_amt2);
  
    var date= $("#order_date").val();
     

$('#final_amt').text();
  $.ajax({
  url:"data.php",
  method:"POST",
  data:{
  final_amt1:tot1,
  final_amt2: tot2,
  date:date,
  diff:diff,
  action:'save_tbl_order',
  },
  success:function(data){

  } 

  });
}

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

        save_tbl_order(diff);
      }
          $(document).ready(function(){
        var final_amt = $('#final_amt').text();
          var count = <?php echo $totalrows ?>;
                    $('#total_item_2').val(count);

         $(document).on('click', '#adds_row', function(){
          count++;
          $('#total_item_2').val(count);
          var html_code = '';
          html_code += '<tr id="row_id_'+count+'">';          
          html_code += '<td style="border: solid;"><input type="text" name="nom[]" id="nom'+count+'" class="form-control input-sm" value="0"/></td>'; 
          html_code += '<td style="border: solid;"><input type="text" name="montant[]" id="montant'+count+'" data-srno="'+count+'" class="form-control input-sm montant" value="0" /></td>';
          html_code += '<td><input type="hidden" name="removes_row" id="'+count+'" class="btn btn-danger btn-xs removes_row"/></td>';
          html_code += '</tr>';
          $('#depenses-item-table').append(html_code);
        });
       })

$(document).on('blur', '.montant', function(){
  //alert("aze");
    let row_not = $(this).attr("data-srno");
     console.log(row_not);
          cal_total(row_not);
          autoosave(row_not);
        });

function saveNewdep(count){
cal_total(count);
autoosave(count);
}
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
          }
          $('#final_amt').text(final_item_total2);
          $('#final_amt_val').val(final_item_total2);
          
           

          cal_diff();
        }
function autoosave(count){
  console.log("autosave FN",count);

  var nom=0;
  var id=0;
  var montant=0;
  var order_date= $("#order_date").val();

nom = $("#nom"+count).val();
montant =  $("#montant"+count).val();
id = $("#ch_id"+count).val();

console.log(id);

console.log(nom);
console.log(montant);

if(nom !='0' && montant !='0')
{
  //console.log((order_item_quantity !=0 && order_item_final_amount !=0));
$.ajax({
  url:"data.php",
  method:"POST",
  data:{
  id:id,
  nom:nom,
  montant:montant,
  action:'depenses',
  },
  success:function(data){
   // alert("edfr");
if(data != ""){
            $("#id").val(data);
    }

} 

    });    

}
}
        </script>