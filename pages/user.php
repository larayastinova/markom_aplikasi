<!-- validator -->
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
 <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Master User</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">Home</a></li>
              <li class="breadcrumb-item active">User</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
	
<section class="content">
	<div class="card">
		<div class="card-header">
			<h3 class="card-title">List User</h3>
			
			<div class="card-tools">
            <button type="button" class="btn btn-tool" data-toggle="modal" data-target="#create_nasabah">
              <i class="fa fa-plus"></i> Add
          </div>
		 </div>
		<div class="card-body">
		<table class="table">
				<tr>
					<td>
						<select id="employee_name" name="search_employee_name" class="form-control">
							<option>-Select Employee Name-</option>
						</select>
					</td>
					<td>
						<select id="role_name" name="search_role_name" class="form-control">
							<option>-Select Role Name-</option>
						</select>
					</td>
					<td>
						<select id="role_name" name="search_company_name" class="form-control">
							<option>-Select Company Name-</option>
						</select>
					</td>
					<td>
						<input type="text" name="username" id ="username" class="form-control" placeholder="Username">
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
			<table id="example1" class="table table-bordered table-striped">
				<thead>
					<tr align="center">
						<th>No <input type="hidden" name="hal" id="hal" class="form-control" value="<?php echo $_GET['hal']?>" /></th>
						<th>Employee</th>
						<th>Role</th>
						<th>Company</th>
						<th>Username</th>
						<th>Created Date</th>
						<th>Created By</th>
						<th class="align-middle" style="width: 10%">Action</th>
						
					</tr>
				</thead>
				<tbody>
					<tr id="isi"></tr>
				</tbody>
			</table>
			<div id ="paging"></div>
			
		</div>
	</div>
	
	<!--Modal Untuk Menapilkan Pop Up Create New -->
	<div class="modal fade" id="create_nasabah" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="card-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
					<h4 class="card-title" id="myModalLabel">Add User</h4>
				</div>

				<div class="modal-body">
					<form id="addForm" data-toggle="validator" action="#" method="POST">
						<div class="form-group">
							<label class="control-label" for="role_name">Role Name</label>
							<select class="form-control" name="role_name" id="role_name" required />
								<option value="">--Select Role Name--</option>
							</select>

							<label class="control-label" for="employee_name">Employee Name</label>
								<select class="form-control" name="employee_name" id="employee_name" required />
								<option value="">--Select Employee Name--</option>
							</select>
						</div>
						<div class="form-group">
							<label class="control-label" for="username">Username</label>
							<input type="text" name="username" id="username" class="form-control" required />
						</div>
						<div class="form-group">
							<label class="control-label" for="password">Password</label>
							<input type="password" name="password" id="password" class="form-control" required />
						</div>
						<div class="form-group">
							<label class="control-label" for="retype_password">Re-type Password</label>
							<input type="text" name="retype_password" id="retype_password" class="form-control" required />
						</div>
						<div class="form-group">
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
					<h4 class="card-title" id="myModalLabel">Edit User</h4>
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
<script src="plugins/jquery/jquery.min.js"></script>

<script type="text/javascript">
	$(document).ready(function () {
		 viewuser();
		 
		$(document).on('click','#btn_add',function(){
			//var error = 0;
			
			//ini untuk session
			var username = $('#username').val();
			var m_role_id = $('#m_role_id').val();
			var nama = $('#nama').val();
			
			//ini untuk search
			var search_employee_name = $('#search_employee_name').val();
			var search_role_name = $('#search_role_name').val();	
			var search_company_name = $('#search_company_name').val();
			var username = $('#username').val();
			var created_by = $('#created_by').val();
			var datepicker = $('#datepicker').val();
			
			//ini untuk kolom insert
			var role_name = $('#role_name').val();
			var employee_name = $('#employee_name').val();			
			var username = $('#username').val();
			var password = $('#password').val();			
			var retype_password = $('#retype_password').val();

			$.ajax({
					type: 'POST',
					url: 'task/user.php',
					data: {'action':'save_user','username':username,'nama':nama,'m_role_id':m_role_id,'search_employee_name':search_employee_name,'search_role_name':search_role_name,'search_company_name':search_company_name,'username':username,'created_by':created_by,'datepicker':datepicker,'role_name':role_name,'employee_name':employee_name,'username':username,'password':password,'retype_password':retype_password},
					success: function(data){
						sp = data.split('~');
						if(sp[2] == 'Sukses'){
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
					url: 'task/user.php',
					data: {'action':'delete_user','id':id},
					success: function(data){
						sp = data.split('~');
						if(sp[2] == 'Sukses'){
							alert(sp[2]);
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
					url: 'task/user.php',
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
			var role_name_edit = $('#role_name_edit').val();
			var employee_name_edit = $('#employee_name_edit').val();
			var username_edit = $('#username_edit').val();
			var password_edit = $('#password_edit').val();
			var retype_password_edit = $('#retype_password_edit').val();
				
			//if(error == 0){	
				$.ajax({
					type: 'POST',
					url: 'task/user.php',
					data: {'action':'edit_user','username':username,'m_role_id':m_role_id,'nama':nama,'id':id,'role_name_edit':role_name_edit,'employee_name_edit':employee_name_edit,'username_edit':username_edit,'password_edit':password_edit,'retype_password_edit':retype_password_edit},
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
	});
	
	
	function viewuser() {
		
	$.ajax({
		type: 'POST',
		url: 'task/user.php',
		data: {'action':'show_user'},
		success: function(data){
			$(data).insertBefore("#isi");
		}
	});
}
</script>