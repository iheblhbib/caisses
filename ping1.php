<?php
include('session.php');
?>
<!DOCTYPE html>
<html>
  <head>
    <title></title>
    <script src="js/jquery.min.js"></script>
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <script src="js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
  <script src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.15/js/dataTables.bootstrap.min.js"></script>
  <script src="https://cdn.datatables.net/plug-ins/1.10.15/i18n/French.json"></script>
</head>

  <body>
    <div align="right">
        <a href="trial1.php" class="btn btn-info btn-xs" style="padding: 5px 15px; border-radius: 30px;">Retour</i></i></a>
      </div>
    <div class="container">
      <nav class="navbar navbar-default" role="navigation">
        <div class="container-fluid">
                      <div class="table-title">
                <div class="row">
                    <div class="col-sm-6">
            <h2><b><center style="margin-left: 75%;width: 50%; margin-right: 75%;">Liste des articles</center></b></h2>
          </div>

                </div>
            </div>
                    </div>
      </nav>
<div class="container box">
   <div class="table-responsive" style="overflow: hidden;">
	<div align="right">
	<button type="button" id="add_button" data-toggle="modal" data-target="#userModal" class="btn btn-info btn-lg">Ajouter un article</button>
	</div>
    <table id="display_item" class="table table-bordered table-striped">
     <thead>
      <tr>
       <th width="20%">Nom de l'article</th>
       <th width="20%">Prix</th>
      <th width="20%">Editer/Supprimer</th>

      </tr>
     </thead>
    </table>
    
   </div>
  </div>


    <div id="userModal" class="modal fade">
    <div class="modal-dialog">
      <div class="modal-content">
        <form id="user_form">
          <div class="modal-header">            
            <h4 class="modal-title">Ajouter Article</h4>
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          </div>
          <div class="modal-body">          
            <div class="form-group">
              <label>Article</label>
              <input type="text" id="name" name="name" class="form-control" required>
            </div>
            <div class="form-group">
              <label>Prix</label>
              <input type="text" id="price" name="price" class="form-control" required>
            </div>        
          </div>
          <div class="modal-footer">
                 <input type="hidden" name="user_id" id="user_id" />

              <input type="hidden" value="ajout" name="action">
              <input type="hidden" name="operation" id="operation" />
          <!--  <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel"> -->
     <input type="submit" name="action" id="action" class="btn btn-success" value="Ajouter" />
          </div>
        </form>
      </div>
    </div>
  </div>
  </body>
</html> 

<script>  
$(document).ready(function(){

  //load_product();

  $('#add_button').click(function(){
  $('#user_form')[0].reset();
  $('.modal-title').text("Ajouter un article");
  $('#action').val("Ajouter");
  $('#operation').val("ajout");
 })
  
var dataTable = $('#display_item').DataTable({
   "language": {
        url: 'https://cdn.datatables.net/plug-ins/1.10.15/i18n/French.json'
    },
  "processing":true,
  "serverSide":true,
   "order":[],
  "ajax":{
   url:"fetch_item.php",
   type:"POST"
  },
  "columnDefs":[
   {
    "orderable":false,
   },
  ],
});


$(document).on('submit', '#user_form', function(event){
    event.preventDefault();

    var name = $('#name').val();
    var price = $('#price').val();
    if(name != '' && price != '')
  {
      $.ajax({
        url:"action.php",
        method:"POST",
          data:new FormData(this),
          contentType:false,
          processData:false,
        success:function()
        {
     $('#user_form')[0].reset();
     $('#userModal').modal('hide');
          dataTable.ajax.reload();
        }
      })
  } 
  });
  


})
</script>