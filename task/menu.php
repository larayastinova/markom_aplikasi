<?php
	require 'config.php';
	$action = $_POST['action'];
	error_reporting(E_ALL^(E_NOTICE|E_WARNING));
	$username = $_POST['username'];
	$m_role_id = $_POST['m_role_id'];
	$nama = $_POST['nama'];
	
	$search_menu_code = $_POST['search_menu_code'];
	$search_menu_name = $_POST['search_menu_name'];
	$datepicker = $_POST['datepicker'];
	$search_by = $_POST['search_by'];
	$search_btn = $_POST['search_btn'];
	
	$id = $_POST['id'];
	$menu_code = $_POST['menu_code'];
	$menu_name = $_POST['menu_name'];
	$controller_name = $_POST['controller_name'];	
	$parent = $_POST['parent'];

	$menu_code_edit = $_POST['menu_code_edit'];	
	$menu_name_edit = $_POST['menu_name_edit'];
	$controller_name_edit = $_POST['controller_name_edit'];
	$parent_edit = $_POST['parent_edit'];
	
	if($action == 'show_menu'){
		echo show_data();
	}
	if($action == 'save_menu'){
		$qr_comp= $conn->query("select * from m_menu order by code desc limit 1");
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
		$menu_code = "ME".$no;
		$insert = $conn->query("insert into m_menu (code,name,controller,parent_id,created_by,created_date) values ('$menu_code','$menu_name','$controller_name','$parent','$nama',now())");	
		if($insert){
				$save = "Sukses";
			}else{
				$save = "Gagal";
			}
		echo show_data()."~$save";
	}	
	if($action == 'edit_menu'){
		$insert = $conn->query("update m_menu set name='$menu_name_edit',controller_name='$controller_name_edit',parent='$parent_edit' where id='$id'");
		if($insert){
				$save = "Sukses";
			}else{
				$save = "Gagal";
			}
		echo show_data()."~$save";
	}
	
	if($action == 'delete_menu'){
		$insert = $conn->query("update m_menu set is_delete is null or is_delete <> '1' where id='$id'");	
		if($insert){
				$save = "Sukses";
			}else{
				$save = "Gagal";
			}
		echo show_data()."~$save";
		echo "update m_menu set is_delete='1' where id='$id'";
	}
	
	if($action == 'form_edit'){
		echo form_edit($id);
	}
	
	function show_data(){
		global $conn;
		$qr=$conn->query("select * from m_menu where is_delete is null or is_delete <> '1'"); 
		$i = 1;
		while($sql = $qr->fetch_array()){
			
			$isi .= "<tr>
						<td align='center'>$i</td>
						<td align='center'>$sql[code]</td>
						<td>$sql[name]</td>
						<td>$sql[created_date]</td>
						<td>$sql[created_by]</td>
						<td class='project-actions text-right'>
                          <a class='btn btn-info btn-sm' href='#' data-toggle='modal' data-target='#edit_nasabah' id='btn_edit' name='btn_edit' data='$sql[id_dampak]'>
                              <i class='fas fa-pencil-alt'>
                              </i>
                          </a>
                          <a class='btn btn-danger btn-sm' href='#' id='btn_delete' name='btn_delete' data='$sql[id_dampak]'>
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
		
		$qr=$conn->query("select * from m_menu where id='$id'"); 
		$sql = $qr->fetch_assoc();
			
			$isi = "<div class='modal-body' id='modal_edit'>
					<form data-toggle='validator' action='#' method='POST'>
						<div class='form-group'>
							<label class='control-label' for='menu_code_edit'>Menu Code</label>
							<input type='text' name='menu_code_edit' id='menu_code_edit' class='form-control' value='$sql[code]' disabled/>
							<input type='hidden' name='id' id='id' class='form-control' value='$sql[id]' disabled/>
						</div>
						<div class='form-group'>
							<label class='control-label' for='menu_name_edit'>Menu Name</label>
							<input type='text' class='form-control' name='menu_name_edit' id='menu_name_edit' value='$sql[menu_name]'/>
						</div>
						<div class='form-group'>
							<label class='control-label' for='controller_name_edit'>Controller Name</label>
							<input type='text' class='form-control' name='controller_name_edit' id='controller_name_edit' value='$sql[controller_name]'/>
						</div>
						<div class='form-group'>
							<label class='control-label' for='parent_edit'>Parent</label>
							<input type='text' class='form-control' name='parent_edit' id='parent_edit' value='$sql[parent]'/>
						</div>		
						<div class='form-group'>
							<button type='button' class='btn btn-info' id='btn_edit_data'>Save</button>
						</div>
					</form></div>";
		return $isi; 
	}
	
?>