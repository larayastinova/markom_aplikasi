<?php
	require 'config.php';
	$action = $_POST['action'];
	error_reporting(E_ALL^(E_NOTICE|E_WARNING));
	$username = $_POST['username'];
	$m_role_id = $_POST['m_role_id'];
	$nama = $_POST['nama'];

	$search_employee_id = $_POST['search_employee_id'];	
	$search_employee_name = $_POST['search_employee_name'];
	$search_name = $_POST['search_name'];
	$datepicker = $_POST['datepicker'];
	$search_by = $_POST['search_by'];
	$search_btn = $_POST['search_btn'];
	
	$id = $_POST['id'];	
	$employee_number = $_POST['employee_number'];
	$first_name = $_POST['first_name'];	
	$last_name = $_POST['last_name'];
	$company_name = $_POST['company_name'];
	$email = $_POST['email'];
	
	$employee_number_edit = $_POST['employee_number_edit'];
	$first_name_edit = $_POST['first_name_edit'];	
	$last_name_edit = $_POST['last_name_edit'];
	$company_name_edit = $_POST['company_name_edit'];
	$email_edit = $_POST['email_edit'];
	
	if($action == 'show_employee'){
		//company select
		$s_comp .= "<option value=''>--Select Company--</option>";
		$qr_sc= $conn->query("select * from m_company");
		while($sql_sc = $qr_sc->fetch_array()){
			$s_comp .= "<option value='$sql_sc[id]'>$sql_sc[name]</option>";
		}
		echo "$s_comp~".show_data();
	}
	
	if($action == 'save_employee'){
		
		$insert = $conn->query("insert into m_employee (employee_number,first_name,last_name,m_company_id,email,created_by,created_date) values ('$employee_number','$first_name','$last_name','$company_name','$email','$nama',now())");	
		if($insert){
				$save = "Sukses";
			}else{
				$save = "Gagal";
			}
		echo show_data()."~$save";
	}
	if($action == 'edit_employee'){
		$insert = $conn->query("update m_employee set name='$company_name_edit', first_name='$first_name_edit',last_name='$last_name_edit', company_name='$company_name_edit', email='$email_edit' where id='$id'");	
		if($insert){
				$save = "Sukses";
			}else{
				$save = "Gagal";
			}
		echo show_data()."~$save";
	}
	
	if($action == 'delete_employee'){
		$insert = $conn->query("update m_employee set is_delete='1' where id='$id'");	
		if($insert){
				$save = "Sukses";
			}else{
				$save = "Gagal";
			}
		//echo show_data()."~$save";
		echo "update m_company set is_delete='1' where id='$id'";
	}
	
	if($action == 'form_edit'){
		echo form_edit($id);
	}
	
	function show_data(){
		global $conn;
		
		$qr=$conn->query("select * from m_employee where is_delete is null or is_delete <> '1'"); 
		$i = 1;
			while($sql = $qr->fetch_array()){
			$id_comp = $sql['m_company_id'];
			$qr_company = $conn->query("select * from m_company where is_delete <> '1'"); 
			$sql_comp = $qr_company->fetch_assoc(); 
			
			$isi .= "<tr>
						<td>$i</td>
						<td>$sql[employee_number]</td>
						<td>$sql[first_name] $sql[last_name]</td>
						<td>$sql_comp[name]</td>
						<td>$sql[created_date]</td>
						<td>$sql[created_by]</td>
						<td class='project-actions text-center'>
                          <a class='btn btn-info btn-sm' href='#' data-toggle='modal' data-target='#edit_nasabah' id='btn_edit' name='btn_edit' data='$sql[id]'>
                              <i class='fas fa-pencil-alt'>
                              </i>
                          </a>
                          <a class='btn btn-danger btn-sm' href='#' id='btn_delete' name='btn_delete' data='$sql[id]'>
                              <i class='fas fa-trash'>
                              </i>
                          </a>
                      </td>
					  </tr>";
			$i++;
		}	
	return $isi;
	}
			
	function form_edit($id){
		global $conn;
		
		$qr=$conn->query("select * from m_employee where id='$id'"); 
		$sql = $qr->fetch_assoc();
			
			$isi = "<div class='modal-body' id='modal_edit'>
					<form data-toggle='validator' action='#' method='POST'>
						<div class='form-group'>
							<label class='control-label' for='employee_number_edit'>Emp ID Number</label>
							<input type='text' name='employee_number_edit' id='employee_number_edit' class='form-control' value='$sql[code]' disabled/>
							<input type='text' name='id' id='id' class='form-control' value='$sql[id]' disabled/>
						</div>
						<div class='form-group'>
							<label class='control-label' for='first_name_edit'>First Name</label>
							<input type='text' class='form-control' name='first_name_edit' id='first_name_edit' value='$sql[name]'/>
						</div>
						<div class='form-group'>
							<label class='control-label' for='last_name_edit'>Last Name</label>
							<input type='text' class='form-control' name='last_name_edit' id='last_name_edit' value='$sql[email]'/>
						</div>
						<div class='form-group'>
							<label class='control-label' for='company_name_edit'>Company Name</label>
							<input type='text' class='form-control' name='company_name_edit' id='company_name_edit' value='$sql[phone]'/>
						</div>
						<div class='form-group'>
							<label class='control-label' for='email_edit'>Email</label>
							<input type='text' class='form-control' name='email_edit' id='email_edit' value='$sql[phone]'/>
						</div>		
						<div class='form-group'>
							<button type='button' class='btn btn-info' id='btn_edit_data'>Save</button>
						</div>
					</form></div>";
		return $isi; 
	}
	
?>