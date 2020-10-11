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
	
	$description = $_POST['description'];	
	$role_name = $_POST['role_name'];
	
	$id = $_POST['id'];
	$role_name_edit = $_POST['role_name_edit'];
	$description_edit = $_POST['description_edit'];
	
	if($action == 'show_role'){
		echo show_data();
	}
	
	if($action == 'save_role'){
		$qr_cek = $conn->query("select code from m_role order by code desc limit 1");
		$sql_cek = $qr_cek->fetch_assoc();
			
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
		$insert = $conn->query("insert into m_role (code,name,description,created_by,created_date) values ('$role_code','$role_name','$description','$nama',now())");	
		if($insert){
				$save = "Sukses";
			}else{
				$save = "Gagal";
			}
		echo show_data()."~$save";
	}
	
	if($action == 'edit_role'){
		$insert = $conn->query("update m_role set name='$role_name', description='$description',where id='$id'");	
		if($insert){
				$save = "Sukses";
			}else{
				$save = "Gagal";
			}
		echo show_data()."~$save";
	}
	
	if($action == 'delete_role'){
		$insert = $conn->query("update m_role set is_delete is null or is_delete <> '1' where id='$id'");	
		if($insert){
				$save = "Sukses";
			}else{
				$save = "Gagal";
			}
		//echo show_data()."~$save";
		echo "delete m_role set is_delete='1' where id='$id'";
	}
	
	if($action == 'form_edit'){
		echo form_edit($id);
	}
	
	function show_data(){
		global $conn;
		$qr=$conn->query("select * from m_role where is_delete is null or is_delete <> '1'"); 
		$i = 1;
		while($sql = $qr->fetch_array()){
			$isi .= "<tr>
						<td align='center'>$i</td>
						<td>$sql[code]</td>
						<td>$sql[name]</td>
						<td>$sql[created_date]</td>
						<td>$sql[created_by]</td>
						<td class='project-actions text-center'>
                          <a class='btn btn-info btn-sm' href='#' data-toggle='modal' data-target='#change_role' id='btn_edit' name='btn_edit' data='$sql[id]'>
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
		$qr=$conn->query("select * from m_role where id='$id'"); 
		$sql = $qr->fetch_assoc();
			
			$isi = "<div class='modal-body' id='modal_edit'>
					<form data-toggle='validator' action='#' method='POST'>
						<div class='form-group'>
							<label class='control-label' for='id'>Role Code</label>
							<input type='text' name='id_edit' id='id_edit' class='form-control' value='$sql[code]' disabled/>
						</div>
						<div class='form-group'>
							<label class='control-label' for='role_name_edit'>Role Name</label>
							<input type='text' name='role_name_edit' id='role_name_edit' class='form-control' value='$sql[name]' required />
						</div>
						<div class='form-group'>
							<label class='control-label' for='description_edit'>Description</label>
							<input type='text' name='description_edit' id='description_edit' class='form-control' value='$sql[description]' required />
						</div>
						
						<div class='form-group'>
							<button type='button' class='btn btn-info' id='btn_edit_data'>Save</button>
						</div>
					</form></div>";
		return $isi; 
	}
	
?>