<?php
	require 'config.php';
	$action = $_POST['action'];
	error_reporting(E_ALL^(E_NOTICE|E_WARNING));
	$username = $_POST['username'];
	$m_role_id = $_POST['m_role_id'];
	$nama = $_POST['nama'];
	
	$search_role_code = $_POST['search_role_code'];
	$search_role_name = $_POST['search_role_name'];	
	$datepicker = $_POST['datepicker'];
	$search_by = $_POST['search_by'];	
	$search_btn = $_POST['search_btn'];	
	
	$id = $_POST['id'];
	$role_code = $_POST['role_code'];
	$menu_access = $_POST['menu_access'];	
	
	$role_code_edit = $_POST['role_code_edit'];
	$menu_access_edit = $_POST['menu_access_edit'];
	
	if($action == 'show_menu_access'){
		echo show_data();
	}
	
	if($action == 'save_menu_access'){
		$qr_comp= $conn->query("select * from m_menu_access order by code desc limit 1");
		$sql_cek = $qr_comp->fetch_assoc();
			
			if(!$sql_cek){
				$no = 1;
			}else{
				$no = substr($sql_cek['code'], -3) + 1;
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
		$role_code = "RO".$no;
		$insert = $conn->query("insert into m_menu_access (m_role_id,m_menu_id,created_by,created_date) values ('$m_role_id','$company_name','$m_menu_id','$nama',now())");	
		if($insert){
				$save = "Sukses";
			}else{
				$save = "Gagal";
			}
		echo show_data()."~$save";
	}
	
	if($action == 'edit_menu_access'){
		$insert = $conn->query("update m_menu_access set name='$role_code_edit', menu_access='$menu_access_edit' where id='$id'");	
		if($insert){
				$save = "Sukses";
			}else{
				$save = "Gagal";
			}
		echo show_data()."~$save";
		//echo "update m_company set company_name_edit='$company_name_edit', email_edit='$email_edit', phone_edit='$phone_edit', address_edit='$address_edit' where id='$id'";
	}
	
	if($action == 'delete_menu_access'){
		$insert = $conn->query("update m_menu_access set is_delete is null or is_delete <> '1' where id='$id'");	
		if($insert){
				$save = "Sukses";
			}else{
				$save = "Gagal";
			}
		//echo show_data()."~$save";
		echo "update m_menu_access set is_delete='1' where id='$id'";
	}
	
	if($action == 'form_edit'){
		echo form_edit($id);
	}
	
	function show_data(){
		global $conn;
		
		$qr=$conn->query("select * from m_company where is_delete is null or is_delete <> '1'"); 
		$i = 1;
		while($sql = $qr->fetch_array()){
			$isi .= "<tr>
						<td align='center'>$i</td>
						<td>$sql[code]</td>
						<td>$sql[name]</td>
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
		
		$qr=$conn->query("select * from m_menu_access where id='$id'"); 
		$sql = $qr->fetch_assoc();
			
			$isi = "<div class='modal-body' id='modal_edit'>
					<form data-toggle='validator' action='#' method='POST'>
						<div class='form-group'>
							<label class='control-label' for='role_code_edit'>Role Code</label>
							<input type='text' name='role_code_edit' id='role_code_edit' class='form-control' value='$sql[code]' disabled/>
							<input type='hidden' name='id' id='id' class='form-control' value='$sql[id]' disabled/>
						</div>
						<div class='form-group'>
							<label class='control-label' for='menu_access_edit'>Menu Access</label>
							<input type='text' class='form-control' name='menu_access_edit' id='menu_access_edit' value='$sql[name]'/>
						</div>
						<div class='form-group'>
							<button type='button' class='btn btn-info' id='btn_edit_data'>Save</button>
						</div>
					</form></div>";
		return $isi; 
	}
	
?>