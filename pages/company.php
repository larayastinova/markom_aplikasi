<!-- validator -->
  <link rel="stylesheet" href="plugins/bootstrapvalidator/src/css/bootstrapValidator.css">
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
 <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Master Company</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">Home</a></li>
              <li class="breadcrumb-item active">Company</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
	
<section class="content">
	<div class="card">
		<div class="card-header">
			<h3 class="card-title">List Company</h3>
			
			<div class="card-tools">
            <button type="button" class="btn btn-tool" data-toggle="modal" data-target="#create_nasabah">
              <i class="fa fa-plus"></i> Add
          </div>
		 </div>
		<div class="card-body">
			<table class="table">
				<tr>
					<td>
						<select id="search_company_code" name="search_company_code" class="form-control">
							<option>-Select Company Code-</option>
						</select>
					</td>
					<td>
						<select id="search_company_name" name="search_company_name" class="form-control">
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
						<th>Company Code</th>
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
					<h4 class="card-title" id="myModalLabel">Add Company</h4>
				</div>

				<div class="modal-body">
					<form id="addForm" data-toggle="validator" action="#" method="POST">
						<div class="form-group">
							<label class="control-label" for="company_code">Company Code</label>
							<input type="text" class="form-control" name="company_code" id="company_code" placeholder="Auto Generate" readonly />
							<input type="hidden" name="username" id="username" class="form-control" value="<?php echo $_SESSION['username'];?>"/>
							<input type="hidden" name="m_role_id" id="m_role_id" class="form-control" value="<?php echo $_SESSION['m_role_id'];?>"/>
							<input type="hidden" name="nama" id="nama" class="form-control" value="<?php echo $_SESSION['employee_name'];?>"/>
						</div>
						<div class="form-group">
							<label class="control-label" for="email">Email</label>
							<input type="email" class="form-control" name="email" id="email" required />
						</div>
						<div class="form-group">
							<label class="control-label" for="phone">Phone</label>
							<input type="number" class="form-control" name="phone" id="phone" required />
						</div>
						<div class="form-group">
							<label class="control-label" for="company_name">Company Name</label>
							<input type="text" class="form-control" name="company_name" id="company_name" required />
						</div>
						<div class="form-group">
							<label class="control-label" for="address">Address</label>
							<textarea class="form-control" name="address" id="address" rows="4" cols="25" required /></textarea>
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
					<h4 class="card-title" id="myModalLabel">Edit Company</h4>
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
		 viewcompany();
		 
		$(document).on('click','#btn_add',function(){
			//var error = 0;
			
			//ini untuk session
			var username = $('#username').val();
			var m_role_id = $('#m_role_id').val();
			var nama = $('#nama').val();
			
			//ini untuk search
			var search_company_code = $('#search_company_code').val();
			var search_company_name = $('#search_company_name').val();
			var created_by = $('#created_by').val();
			var datepicker = $('#datepicker').val();

			//ini untuk kolom insert
			var email = $('#email').val();
			var phone = $('#phone').val();			
			var company_name = $('#company_name').val();
			var address = $('#address').val();
						
				$.ajax({
					type: 'POST',
					url: 'task/company.php',
					data: {'action':'save_company','username':username,'nama':nama,'m_role_id':m_role_id,'search_company_code':search_company_code,'search_company_name':search_company_name,'created_by':created_by,'datepicker':datepicker,'email':email,'phone':phone,'company_name':company_name,'address':address},
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
					url: 'task/company.php',
					data: {'action':'delete_company','id':id},
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
					url: 'task/company.php',
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
			var company_code_edit = $('#company_code_edit').val();
			var email_edit = $('#email_edit').val();
			var phone_edit = $('#phone_edit').val();
			var company_name_edit = $('#company_name_edit').val();
			var address_edit = $('#address_edit').val();
			
			//if(error == 0){	
				$.ajax({
					type: 'POST',
					url: 'task/company.php',
					data: {'action':'edit_company','username':username,'m_role_id':m_role_id,'nama':nama,'id':id,'email_edit':email_edit,'phone_edit':phone_edit,'company_name_edit':company_name_edit,'address_edit':address_edit},
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
	
	
	function viewcompany() {
	$.ajax({
		type: 'POST',
		url: 'task/company.php',
		data: {'action':'show_company'},
		success: function(data){
			$(data).insertBefore("#isi");
		}
	});
}
</script>