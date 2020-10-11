<?php
	require 'config.php';
	$action = $_POST['action'];
	error_reporting(E_ALL^(E_NOTICE|E_WARNING));
	$username = $_POST['username'];
	$m_role_id = $_POST['m_role_id'];
	$nama = $_POST['nama'];
	
	$search_company_name = $_POST['search_company_name'];
	$search_company_code = $_POST['search_company_code'];
	$datepicker = $_POST['datepicker'];
	$search_by = $_POST['search_by'];
	$search_btn = $_POST['search_btn'];
	
	$id = $_POST['id'];
	$company_code = $_POST['company_code'];
	$email = $_POST['email'];
	$phone = $_POST['phone'];
	$company_name = $_POST['company_name'];
	$address = $_POST['address'];
	
	$company_code_edit = $_POST['company_code_edit'];
	$email_edit = $_POST['email_edit'];
	$phone_edit = $_POST['phone_edit'];
	$company_name_edit = $_POST['company_name_edit'];
	$address_edit = $_POST['address_edit'];
	
	if($action == 'show_company'){
		echo show_data();
	}
	if($action == 'save_company'){
		$qr_comp= $conn->query("select * from m_company order by code desc limit 1");
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
		$company_code = "CP".$no;
		$insert = $conn->query("insert into m_company (code,name,address,phone,email,created_by,created_date) values ('$company_code','$company_name','$address','$phone','$email','$nama',now())");	
		if($insert){
				$save = "Sukses";
			}else{
				$save = "Gagal";
			}
		echo show_data()."~$save";
	}
		
	if($action == 'edit_company'){
		$insert = $conn->query("update m_company set name='$company_name_edit', email='$email_edit', phone='$phone_edit', address='$address_edit' where id='$id'");	
		if($insert){
				$save = "Sukses";
			}else{
				$save = "Gagal";
			}
		echo show_data()."~$save";
		//echo "update m_company set company_name_edit='$company_name_edit', email_edit='$email_edit', phone_edit='$phone_edit', address_edit='$address_edit' where id='$id'";
	}
	
	if($action == 'delete_company'){
		$insert = $conn->query("update m_company set is_delete is null or is_delete <> '1' where id='$id'");	
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
		
		$qr=$conn->query("select * from m_company where id='$id'"); 
		$sql = $qr->fetch_assoc();
			
			$isi = "<div class='modal-body' id='modal_edit'>
					<form data-toggle='validator' action='#' method='POST'>
						<div class='form-group'>
							<label class='control-label' for='company_code_edit'>Company Code</label>
							<input type='text' name='company_code_edit' id='company_code_edit' class='form-control' value='$sql[code]' disabled/>
							<input type='hidden' name='id' id='id' class='form-control' value='$sql[id]' disabled/>
						</div>
						<div class='form-group'>
							<label class='control-label' for='company_name_edit'>Company Name</label>
							<input type='text' class='form-control' name='company_name_edit' id='company_name_edit' value='$sql[name]'/>
						</div>
						<div class='form-group'>
							<label class='control-label' for='email_edit'>Email</label>
							<input type='text' class='form-control' name='email_edit' id='email_edit' value='$sql[email]'/>
						</div>
						<div class='form-group'>
							<label class='control-label' for='phone_edit'>Phone</label>
							<input type='text' class='form-control' name='phone_edit' id='phone_edit' value='$sql[phone]'/>
						</div>
						<div class='form-group'>
							<label class='control-label' for='address_edit'>Address</label>
							<textarea class='form-control' name='address_edit' id='address_edit' rows='4' cols='50'>$sql[address]</textarea>
						</div>			
						<div class='form-group'>
							<button type='button' class='btn btn-info' id='btn_edit_data'>Save</button>
						</div>
					</form></div>";
		return $isi; 
	}
	
?>