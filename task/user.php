<?php
	require 'config.php';
	error_reporting(E_ALL^(E_NOTICE|E_WARNING));
	$action = $_POST['action'];
	$username = $_POST['username'];
	$m_role_id = $_POST['m_role_id'];	
	$m_employee_id = $_POST['m_employee_id'];
	$nama = $_POST['nama'];
	
	$search_employee_name = $_POST['search_employee_name'];
	$search_role_name = $_POST['search_role_name'];
	$search_company_name = $_POST['search_company_name'];
	$username = $_POST['username'];
	$datepicker = $_POST['datepicker'];
	$search_by = $_POST['search_by'];
	$search_btn = $_POST['search_btn'];
	
	$id = $_POST['id'];
	$role_name = $_POST['role_name'];
	$employee_name = $_POST['employee_name'];
	$username = $_POST['username'];
	$password = $_POST['password'];	
	$retype_password = $_POST['retype_password'];
	
	$role_name_edit = $_POST['role_name_edit'];
	$employee_name_edit = $_POST['employee_name_edit'];
	$username_edit = $_POST['username_edit'];
	$password_edit = $_POST['password_edit'];
	$retype_password_edit = $_POST['retype_password_edit'];
	
	if($action == 'show_user'){
		echo show_data();
	}
	if($action == 'save_user'){
		$qr_comp= $conn->query("select * from m_user order by id desc limit 1");
		$sql_cek = $qr_comp->fetch_assoc();
			
			if(!$sql_cek){
				$no = 1;
			}else{
				$no = substr($sql_cek['id'], -3) + 1;
			}
			
			if($no < 100){
				$no = "000".$no;
			}else if($no >100 && $no <1000){
				$no = "00".$no;
			}else if($no >10 && $no <100){
				$no = "0".$no;
			}else{
				$no=$no;
			}
		$username = "".$no;
		$insert = $conn->query("insert into m_user (username,password,m_role_id,m_employee_id,employee_name,created_by,created_date) values ('$username','$password','$m_role_id','$m_employee_id','$employee_name','$nama',now())");	
		if($insert){
				$save = "Sukses";
			}else{
				$save = "Gagal";
			}
		echo show_data()."~$save";
	}
		
	
	if($action == 'edit_user'){
		$insert = $conn->query("update user set role_name='$role_name_edit',employee_name='$employee_name_edit',username='$username_edit',password='$password_edit',retype_password='$retype_password_edit' where id='$id'");	
		if($insert){
				$save = "Sukses";
			}else{
				$save = "Gagal";
			}
		echo show_data($hal)."~$save";
	}
	
	if($action == 'delete_user'){
		$insert = $conn->query("update m_user set is_delete is null or is_delete <> '1' where id='$id'");	
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
		
		$qr=$conn->query("select * from m_user where is_delete is null or is_delete <> '1'"); 
		$i = 1;
		while($sql = $qr->fetch_array()){
			$isi .= "<tr>
						<td align='center'>$i</td>
						<td>$sql[username]</td>
						<td>$sql[role]</td>						
						<td>$sql[company]</td>
						<td>$sql[username]</td>
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
		
		$qr=$conn->query("select * from m_user where id='$id'"); 
		$sql = $qr->fetch_assoc();
			
			$isi = "<div class='modal-body' id='modal_edit'>
					<form data-toggle='validator' action='#' method='POST'>
						<div class='form-group'>
							<label class='control-label' for='role_name_edit'>Role Name</label>
							<input type='text' class='form-control' name='role_name_edit' id='role_name_edit' value='$sql[role_name]'/>
						</div>						
						<div class='form-group'>
							<label class='control-label' for='employee_name_edit'>Employee Name</label>
							<input type='text' class='form-control' name='employee_name_edit' id='employee_name_edit' value='$sql[emp_name]'/>
						</div>
						<div class='form-group'>
							<label class='control-label' for='username_edit'>Username</label>
							<input type='text' class='form-control' name='username_edit' id='username_edit' value='$sql[username]'/>
						</div>
						<div class='form-group'>
							<label class='control-label' for='password_edit'>Password</label>
							<input type='text' class='form-control' name='password_edit' id='password_edit' value='$sql[pass]'/>
						</div>
						<div class='form-group'>
							<label class='control-label' for='retype_password_edit'>Re-Type Password</label>
							<textarea class='form-control' name='retype_password_edit' id='retype_password_edit' rows='4' cols='50'>$sql[retype_pass]</textarea>
						</div>			
						<div class='form-group'>
							<button type='button' class='btn btn-info' id='btn_edit_data'>Save</button>
						</div>
					</form></div>";
		return $isi; 
	}
		
?>