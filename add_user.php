
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
        <a href="trial.php" class="btn btn-info btn-xs" style="padding: 5px 15px; border-radius: 30px;">Retour</i></i></a>
      </div>
    <div class="container">
      <nav class="navbar navbar-default" role="navigation">
        <div class="container-fluid">
                      <div class="table-title">
                <div class="row">
                    <div class="col-sm-6">
            <h2><b><center style="margin-left: 75%;width: 50%; margin-right: 75%;">Listes des utilisateurs</center></b></h2>
          </div>

                </div>
            </div>
                    </div>
      </nav>
<div class="container box">
   <div class="table-responsive" style="overflow: hidden;">
	<div align="right">
	<button type="button" id="add_button" data-toggle="modal" data-target="#userModal" class="btn btn-info btn-lg">Ajouter un utilisateur</button>
	</div>
    <table id="display_itemm" class="table table-bordered table-striped">
     <thead>
      <tr>
       <th width="20%">Nom</th>
       <th width="20%">Mot de passe</th>
       <th width="20%">Type</th>
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
            <h4 class="modal-title">Ajouter Utilisateur</h4>
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          </div>
          <div class="modal-body">          
            <div class="form-group">
              <label>Nom</label>
              <input type="text" id="nom_utilisateur" name="nom_utilisateur" class="form-control" required>
            </div>
            <div class="form-group">
              <label>Mot de passe</label>
              <input type="text" id="mot_de_passe" name="mot_de_passe" class="form-control" required>
            </div>   
			<div>
      <select class="form-group" name="type" id="type" >
        <option value="" disabled selected>Type</option>
        <option value="admin">Admin</option>
        <option value="user">User</option>
      </select>
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
  $('.modal-title').text("Ajouter un utilisateur");
  $('#action').val("Ajouter");
  $('#operation').val("ajout");
 })
  
var dataTable = $('#display_itemm').DataTable({
   "language": {
        url: 'https://cdn.datatables.net/plug-ins/1.10.15/i18n/French.json'
    },
  "processing":true,
  "serverSide":true,
   "order":[],
  "ajax":{
   url:"fetch_user.php",
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

    var nom_utilisateur = $('#nom_utilisateur').val();
    var mot_de_passe = $('#mot_de_passe').val();
    var type = $('#type').val();
    if(nom_utilisateur != '' && mot_de_passe != '' && type != '')
  {
      $.ajax({
        url:"actionuser.php",
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
$(document).on('click', '.update', function(){
  var user_id = $(this).attr("id");
  $.ajax({
   url:"fetch_users.php",
   method:"POST",
   data:{user_id:user_id},
   dataType:"json",
   success:function(data)
   {
    $('#userModal').modal('show');
    $('#nom_utilisateur').val(data.nom_utilisateur);
    $('#mot_de_passe').val(data.mot_de_passe);
    $('#type').val(data.type);
    $('.modal-title').text("Editer utilisateur");
    $('#user_id').val(user_id);
    $('#action').val("Editer");
    $('#operation').val("update");


   }
  })
 });


$(document).on('click', '.delete', function(){
  var user_id = $(this).attr("id");

   $.ajax({
    url:"deleteuser.php",
    method:"POST",
    data:{user_id:user_id},
    success:function(data)
    {
     dataTable.ajax.reload();
    }
   });

 });  

})
</script>


