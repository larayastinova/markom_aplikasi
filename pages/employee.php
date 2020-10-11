<!-- validator -->
  <link rel="stylesheet" href="plugins/bootstrapvalidator/src/css/bootstrapValidator.css">
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
 <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Master Employee</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">Home</a></li>
              <li class="breadcrumb-item active">Employee </li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
	
<section class="content">
	<div class="card">
		<div class="card-header">
			<h3 class="card-title">List Employee</h3>
			
			<div class="card-tools">
            <button type="button" class="btn btn-tool" data-toggle="modal" data-target="#create_nasabah">
              <i class="fa fa-plus"></i> Add
          </div>
		 </div>
		<div class="card-body">
		<table class="table">
				<tr>
					<td>
						<input type="text" name="search_employee_id" id ="search_employee_id" class="form-control" placeholder="Employee ID Number">
					</td>
					<td>
						<input type="text" name="search_employee_name" id ="search_employee_name" class="form-control" placeholder="Employee Name">
					</td>
					<td>
						<select id="search_name" name="search_name" class="form-control">
							<option>-Select Company Name-</option>
						</select>
					</td>
					<td>
						<div class="input-group date">
						<div class="input-group-addon">
						<i class="fa fa-calendar"></i>
						</div>
						<input type="text" name="datepicker" id="datepicker" class="form-control pull-right" placeholder="Created">
						</div>
					</td>
					<td>
						<input type="text" name="search_by" id="search_by" class="form-control" placeholder="Created By">
					</td>
					<td>
						<input type="button" name="search_btn" id="search_btn" class="btn btn-warning" value="Search">
					</td>
					
				</tr>
			</table>
			
			<table class="table table-bordered table-striped">
				<thead>
					<tr align="center">
						<th>No</th>
						<th>Employee ID Number</th>
						<th>Employee Name</th>						
						<th>Company Name</th>
						<th>Created Date</th>
						<th>Created By</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<tr id="isi"></tr>
				</tbody>
			</table>
			<ul id="pagination" class="pagination-sm"></ul>
		</div>
	</div>
	
	<!--Modal Untuk Menapilkan Pop Up Create New -->
	<div class="modal fade" id="create_nasabah" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="card-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
					<h4 class="card-title" id="myModalLabel">Add Employee</h4>
				</div>

				<div class="modal-body">
					<form id="addForm" data-toggle="validator" action="#" method="POST">
						<div class="form-group">
							<label class="control-label" for="employee_number">EMP ID Number</label>
							<input type="text" name="employee_number" id="employee_number" class="form-control" required />
							<input type="hidden" name="username" id="username" class="form-control" value="<?php echo $_SESSION['username'];?>"/>
							<input type="hidden" name="m_role_id" id="m_role_id" class="form-control" value="<?php echo $_SESSION['m_role_id'];?>"/>
							<input type="hidden" name="nama" id="nama" class="form-control" value="<?php echo $_SESSION['employee_name'];?>"/>
						</div>
						<div class="form-group">
							<label class="control-label" for="first_name">First Name</label>
							<input type="text" name="first_name" id="first_name" class="form-control" required />
						</div>
						<div class="form-group">
							<label class="control-label" for="last_name">Last Name</label>
							<input type="text" name="last_name" id="last_name" class="form-control" required />
						</div>
						<div class="form-group">
							<label class="control-label" for="company_name">Company Name</label>
							<select class="form-control" name="company_name" id="company_name" required />								
							</select>
						</div>
						<div class="form-group">
							<label class="control-label" for="email">Email</label>
							<input type="text" class="form-control" name="email" id="email" required />
						</div>
						 <div class="modal-footer justify-content-between">
							<button type="button" class="btn btn-success" id='btn_add'>Save</button>
							<button type="button" class="btn btn-warning" data-dismiss="modal">Cancel</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	
	<!--Modal Untuk Menapilkan Pop Up Edit -->
	<div class="modal fade" id="edit_nasabah" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="card-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
					<h4 class="card-title" id="myModalLabel">Edit Employee</h4>
				</div>
				<div id="form-edit">
					
				</div>
			</div>
		</div>
	</div>
     <!-- /row -->
</section>
<!-- /.Main content -->
</div>
<!-- /.content-wrapper -->

<script src="plugins/jquery/jquery.min.js"></script>

<script type="text/javascript">
	$(document).ready(function () {
		 viewemployee();
		 
		$(document).on('click','#btn_add',function(){
			//var error = 0;
			
			//ini untuk session
			var username = $('#username').val();
			var m_role_id = $('#m_role_id').val();
			var nama = $('#nama').val();
			
			//ini untuk search
			var search_employee_id = $('#search_employee_id').val();
			var search_employee_name = $('#search_employee_name').val();var search_name = $('#search_name').val();
			var created_by = $('#created_by').val();
			var datepicker = $('#datepicker').val();

			//ini untuk kolom insert
			var employee_number = $('#employee_number').val();
			var first_name = $('#first_name').val();				
			var last_name = $('#last_name').val();		
			var company_name = $('#company_name').val();
			var email = $('#email').val();

			$.ajax({
					type: 'POST',
					url: 'task/employee.php',
					data: {'action':'save_employee','username':username,'nama':nama,'m_role_id':m_role_id,'search_employee_id':search_employee_id,'search_employee_name':search_employee_name,'search_name':search_name,'created_by':created_by,'datepicker':datepicker,'employee_number':employee_number,'first_name':first_name,'last_name':last_name,'company_name':company_name,'email':email},
					success: function(data){
						sp = data.split('~');
						if(sp[1] == 'Sukses'){
							$('#modal').modal('toggle');
							alert(sp[1]);
							location.reload();
						}else{
							alert('Saving Failed, please cek your data');
						}
					} 
				});
		});
		
		$(document).on('click','#btn_delete',function(){
			var id = $(this).attr('data');
			
			var del=confirm("Are you sure you want to delete this record?");
			if (del==true){
				$.ajax({
					type: 'POST',
					url: 'task/employee.php',
					data: {'action':'delete_employee','id':id},
					success: function(data){
						sp = data.split('~');
						if(sp[1] == 'Sukses'){
							alert(sp[1]);
							location.reload();
						}else{
							alert('Saving Failed, please cek your data');
						}
					} 
				});
			}
		}); 
		
				$(document).on('click','#btn_edit',function(){
			var id = $(this).attr('data');
			
				$.ajax({
					type: 'POST',
					url: 'task/employee.php',
					data: {'action':'form_edit','id':id},
					success: function(data){
						$('#modal_edit').remove();
						$(data).insertAfter("#form-edit");
						//alert(data);
					} 
				});
		}); 
		
		$(document).on('click','#btn_edit_data',function(){
			//var error = 0;
			//ini untuk session
			var username = $('#username').val();
			var m_role_id = $('#m_role_id').val();
			var nama = $('#nama').val();
			
			var id = $('#id').val();
			var employee_number_edit = $('#employee_number_edit').val();
			var first_name_edit = $('#first_name_edit').val();
			var last_name_edit = $('#last_name_edit').val();
			var company_name_edit = $('#company_name_edit').val();
			var email_edit = $('#email_edit').val();
			
			//if(error == 0){	
				$.ajax({
					type: 'POST',
					url: 'task/employee.php',
					data: {'action':'edit_employee','username':username,'m_role_id':m_role_id,'nama':nama,'id':id,'employee_number_edit':employee_number_edit,'first_name_edit':first_name_edit,'last_name_edit':last_name_edit,'company_name_edit':company_name_edit,'email_edit':email_edit},
					success: function(data){
						sp = data.split('~');
						if(sp[1] == 'Sukses'){
							$('#modal').modal('toggle');
							alert(sp[1]);
							location.reload();
						}else{
							alert('Saving Failed, please cek your data');
						}
					} 
				});
			//}else{
			//	alert("Lengkapi Data")
			//}
		}); 
	});
	
	
	function viewemployee() {
	$.ajax({
		type: 'POST',
		url: 'task/employee.php',
		data: {'action':'show_employee'},
		success: function(data){
			sp = data.split('~');
			$('#company_name').html(sp[0]);
			$('#search_name').html(sp[0]);
			$(sp[1]).insertBefore("#isi");
		}
	});
}
</script>