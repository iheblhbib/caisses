<?php
  //invoice.php  
  include('database_connection.php');
  include('session.php');

  $statement = $connect->prepare("
    SELECT *  FROM chargejour 
  ");

  $statement->execute(); 

  $all_result = $statement->fetchAll();

  $total_rows = $statement->rowCount();

 $statement2 = $connect->prepare("
    SELECT sum(coutm) as sum_coutm, sum(coutj) as sum_coutj FROM chargejour 
  ");
  $statement2->execute();

  $sum_res = $statement2->fetch();

?>

<!DOCTYPE html>
<html lang="en" >
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
    format: "mm-yyyy",
    viewMode: "months", 
    minViewMode: "months"
      }).datepicker('setDate','0'); 
      });

</script>
  <div align="right">
    <button onclick="window.print();" class="btn btn-primary" style="padding: 5px 15px; border-radius: 30px;" id="print-btn">Print</button> 
        <a href="trial1.php" class="btn btn-info btn-xs" style="padding: 5px 15px; border-radius: 30px;">Retour</i></i></a>
      </div>

  <form method="POST" id="charge_form1" action="chargejour_save.php" >

 <table class="table table-bordered">
            <tr style="background: #ecaff3;">
              <td colspan="2" align="center"><h2 style="margin-top:10.5px;">CHARGES</h2></td>
            </tr>
            <tr >
                <td colspan="2" >
                  <div class="row" >

 <div class="col-md-4" >
                      <input style="background-color:#9400D3;color: #FDFEFE;font-size: 31px;text-align: center;margin-left: 100%;margin-right: 100%;width: 100%;" type="text" name="order_date" id="order_date" class="form-control input-sm" readonly />
                     <!-- <a href="#" name="order_date" id="order_date" class="form-control input-sm"></a> -->
                    </div>
                  </div>
                  <br />
                   <br/>
                  <table id="depenses-item-table" class="table table-bordered" >
                    <tr>
                    <th width="10%"></th>
                  <th width="10%" style="border: solid; background-color:#F3AFD8;">Coût Mensuel</th>
                  <th width="10%" style="border: solid; background-color:#ECAFF3;">Coût Journalier</th>
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
        <input type="text" name="ch_id[]" value="'.$row["id"].'" hidden="true">
          <b><input type="text" name="nom[]" id="nom'.$count.'" class="form-control input-sm" value="'.$row["nom"].'"/></b></td>
          <td style="border: solid;"><input type="text" name="montant[]" id="montant'.$count.'" data-srno="'.$count.'" class="form-control input-sm montant" value="'.$row["coutm"].'" /></td>
          <td style="border: solid;"><input type="text" name="montantt[]" id="montantt'.$count.'" data-srno="'.$count.'" class="form-control input-sm montantt" value="'.$row["coutj"].'" /></td>
       
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
            <table id="depenses-item-table" class="table table-bordered" style="width: 30%;">
  <tr>
                <td align="center" style="width: 35%;"><b>Total mensuel</td>
                <td align="center"><b><span id="final_amt" ><?php echo $sum_res['sum_coutm'] ?></span></b></td>
              </tr>
              <tr>
                <td align="center"><b>Total journalier</td>
                <td align="center"><b><span id="final_amtt" ><?php echo $sum_res['sum_coutm'] ?> </span></b></td>
              </tr>
            
</table>
              <tr>
                <td colspan="2" align="center">
                  <input type="hidden" name="total_item" id="total_item" value="1" />
              <center>   <input type="submit" name="create_charge" id="create_charge" class="btn btn-info" value="Save" /></center> 
                </td>
              </tr>
          </table>

          
<input type="text" name="totalem" id="totalem" value="0" hidden="true">
<input type="text" name="totalj" id="totalj"  value="0" hidden="true">      
</form>

        <script type="text/javascript">
          $(document).ready(function(){
        var final_amt = $('#final_amt').text();
        var count = <?php echo $total_rows ?>;
                $('#total_item').val(count);

        cal_cout(count);
         $(document).on('click', '#adds_row', function(){
          count++;
          $('#total_item').val(count);
          var html_code = '';
          html_code += '<tr id="row_id_'+count+'">';    
          html_code += '<td style="border: solid;"><input type="text" name="ch_id[]" value="-1" hidden="true"><input type="text" name="nom[]" id="nom'+count+'" class="form-control input-sm" value="0"/></td>'; 
          html_code += '<td style="border: solid;"><input type="text" name="montant[]" id="montant'+count+'" data-srno="'+count+'" class="form-control input-sm montant" value="0" /></td>';
          html_code += '<td style="border: solid;"><input type="text" name="montantt[]" id="montantt'+count+'" data-srno="'+count+'" class="form-control input-sm montantt" value="0" /></td>';
          html_code += '<td><button type="button" name="removes_row" id="'+count+'" class="btn btn-danger btn-xs removes_row">X</button></td>';
          html_code += '</tr>';
          $('#depenses-item-table').append(html_code);
        });
   
$(document).on('blur', '.montant', function(){
  //alert("aze");
    let row_not = $(this).attr("data-srno");
          cal_total(row_not);
          cal_cout(row_not);

        });

function cal_cout(count)
        { 
          var final_item_total2 = 0;
          final_item_total2 = Number($('#montantt').val());
          var final_item =0;
          for(j=1; j<=count; j++)
          {
                var actual_amount = $('#montant'+j).val();

                //console.log('actual amount',actual_amount);
                var item_total = parseFloat(actual_amount);
                //console.log(typeof actual_amount);
                if ( typeof actual_amount != 'undefined'){
                 console.log(  document.getElementById("order_date") );
                  //const d =  new Date(y, m, 0).getDate() ;
                final_item_total2 = parseFloat(actual_amount) / 31; 
                //console.log(final_item_total2);

                final_item= final_item+final_item_total2;
                //console.log(final_item);

                }
                $('#montantt'+j).val(final_item_total2.toFixed(2));

          }

      $('#final_amtt').text(final_item.toFixed(2));
      $('#totalj').val(final_item.toFixed(2));

        }
        function cal_total(count)
        {
          var final_item_total2 = 0;
          final_item_total2 = Number($('#final_amt').val());
          for(j=1; j<=count; j++)
          {
                var actual_amount = $('#montant'+j).val();

                //console.log('actual amount',actual_amount);
                var item_total = parseFloat(actual_amount);
                //console.log(typeof actual_amount);
                if ( typeof actual_amount != 'undefined'){
                final_item_total2 = parseFloat(final_item_total2) + parseFloat(item_total);

                }
                //$('#final_amt'+j).val(item_total);
          }
          $('#final_amt').text(final_item_total2);
          $('#totalem').val(final_item_total2);
        }
        $(document).on('click', '.removes_row', function(){
          var row_id = $(this).attr("id");     
          var id = $(this).attr("data-srno");
console.log(row_id);
console.log(id);
         $('#row_id_'+row_id).remove();

          //count--;
          //$('#total_item').val(count);
          cal_total(count);
          cal_cout(count);
        });

   

      })
        </script>

<script>
$(document).ready(function(){  
      function autoSave()  
      {  
           var post_title = $('#post_title').val();  
           var post_description = $('#post_description').val();  
           var post_id = $('#post_id').val();  
           if(post_title != '' && post_description != '')  
           {  
                $.ajax({  
                     url:"chargejour_save.php",  
                     method:"POST",  
                     data:{postTitle:post_title, postDescription:post_description, postId:post_id},  
                     dataType:"text",  
                     success:function(data)  
                     {  
                          if(data != '')  
                          {  
                               $('#post_id').val(data);  
                          }  
                          $('#autoSave').text("Post save as draft");  
                          setInterval(function(){  
                               $('#autoSave').text('');  
                          }, 5000);  
                     }  
                });  
           }            
      }  
      setInterval(function(){   
           autoSave();   
           }, 10000);  
 });  
 </script>
 