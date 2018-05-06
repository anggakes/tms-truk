<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Truck_absent extends CI_Controller {

	function __construct()  {
 		parent::__construct();
			$this->load->library(array('PHPExcel','PHPExcel/IOFactory'));
			$this->load->model('model_account_master');
			$this->load->model('model_truck_absent');
			$this->load->library('tank_auth');
			
	}
	
	public function truckAbsentFilter()
	{
		
			date_default_timezone_set('Asia/Jakarta');
			if ($this->tank_auth->is_logged_in()) {
			$user	= $this->tank_auth->get_username();
			$data_account = $this->model_account_master->getAccount("WHERE username = '".$user."' ")->result_array();
			$data_role = $this->model_account_master->getRole("WHERE id_role = '".$data_account[0]['user_access']."' ")->result_array();
			$user_role = $data_account[0]['user_type'];
			$code_role = $data_account[0]['code'];
			
			if($data_role[0]['see_truck_absent']=='yes')
			{	
			$this->load->library('table');
			$this->load->library('pagination');
			$search = isset($_GET['search']) ? $_GET['search'] : '';
			
			
			$jumlah= $this->model_truck_absent->countTruckAbsentFilter($search);
			
			if (count($_GET) > 0) $config['suffix'] = '?' . http_build_query($_GET, '', "&");
			$config['base_url'] = base_url().'index.php/truck_absent/truckAbsentFilter/';
			$config['total_rows'] = $jumlah;
			$config['first_link'] = 'First';
			$config['last_link'] = 'End';
			$config['next_link'] = 'Next';
			$config['prev_link'] = 'Previous';
			$config['per_page'] = 5; 	
			if (count($_GET) > 0) $config['suffix'] = '?' . http_build_query($_GET, '', "&");
			$config['first_url'] = $config['base_url'].'?'.http_build_query($_GET);
			
			$dari = $this->uri->segment('3');
			$data = $this->model_truck_absent->dataTruckAbsentFilter($config['per_page'],$dari,$search);
			$data_shift = $this->db->query("SELECT * FROM shift")->result();
			
			$data_category_truck_absent = $this->db->query("SELECT * FROM master_data_category WHERE category = 'Truck Absent' ")->result();
			$data_category_shift = $this->db->query("SELECT * FROM master_data_category WHERE category = 'Shift Driver' ")->result();
		
			$comp = array(
				'title' => ' Truck Absent',
				'content' => $this->load->view('truck_absent_filter',array('data_category_shift'=>$data_category_shift,'data_category_truck_absent'=>$data_category_truck_absent,'data_shift'=>$data_shift,'data_absent'=>$data,'data_role'=>$data_role,'search'=>$search),true),
				'sidebar' => $this->html_sidebar()
			);
			$this->load->view("common/common",$comp);
			}
		else
		{
			$data = "You dont have permission to access this page";
			$comp = array(
			
			'title' => ' Permission Denied',
			'content' => $this->load->view('accessdenied',array('data'=>$data),true),
			'sidebar' => $this->html_sidebar()
			);
			$this->load->view("common/common",$comp);
			
			}
			
		}
		else
		{
			redirect('/auth/login/');
			}
		
	}
	
	public function editTruckAbsent()
	{
		
			date_default_timezone_set('Asia/Jakarta');
			ini_set('memory_limit', '-1');
			
			if ($this->tank_auth->is_logged_in()) {
			$user	= $this->tank_auth->get_username();
			$data_account = $this->model_account_master->getAccount("WHERE username = '".$user."' ")->result_array();
			$data_role = $this->model_account_master->getRole("WHERE id_role = '".$data_account[0]['user_access']."' ")->result_array();
			$user_role = $data_account[0]['user_type'];
			$code_role = $data_account[0]['code'];
			
			if($data_role[0]['add_truck_absent']=='yes')
			{
				
			
				// Get Variable Post
				$date_absence = date('Y:m:d');
				$timestamp = date('Y:m:d H:i:s');
				$username = $user;
				$driver_code = $_POST['driver_code'];
				$driver_name = $_POST['driver_name'];
				$vehicle_id = $_POST['vehicle_id'];
				//$id_shift = $_POST['id_shift'];
				//Kelengkapan
				$kelengkapan_oli_mesin = isset($_POST['kelengkapan_oli_mesin']) ? $_POST['kelengkapan_oli_mesin'] : 'not ok';
				$action_kelengkapan_oli_mesin = isset($_POST['action_kelengkapan_oli_mesin']) ? $_POST['action_kelengkapan_oli_mesin'] : 'not ok';
				$kecukupan_air_radioator = isset($_POST['kecukupan_air_radioator']) ? $_POST['kecukupan_air_radioator'] : 'not ok';
				$action_kecukupan_air_radioator = isset($_POST['action_kecukupan_air_radioator']) ? $_POST['action_kecukupan_air_radioator'] : 'not ok';
				$kondisi_ban = isset($_POST['kondisi_ban']) ? $_POST['kondisi_ban'] : 'not ok';
				$action_kondisi_ban = isset($_POST['action_kondisi_ban']) ? $_POST['action_kondisi_ban'] : 'not ok';
				$kondisi_accu = isset($_POST['kondisi_accu']) ? $_POST['kondisi_accu'] : 'not ok';
				$action_kondisi_accu = isset($_POST['action_kondisi_accu']) ? $_POST['action_kondisi_accu'] : 'not ok';
				$kontrol_lampu = isset($_POST['kontrol_lampu']) ? $_POST['kontrol_lampu'] : 'not ok';
				$action_kontrol_lampu = isset($_POST['action_kontrol_lampu']) ? $_POST['action_kontrol_lampu'] : 'not ok';
				$angin_untuk_rem = isset($_POST['angin_untuk_rem']) ? $_POST['angin_untuk_rem'] : 'not ok';
				$action_angin_untuk_rem = isset($_POST['action_angin_untuk_rem']) ? $_POST['action_angin_untuk_rem'] : 'not ok';
				$test_mesin = isset($_POST['test_mesin']) ? $_POST['test_mesin'] : 'not ok';
				$action_test_mesin = isset($_POST['action_test_mesin']) ? $_POST['action_test_mesin'] : 'not ok';
				$kondisi_body_truck = isset($_POST['kondisi_body_truck']) ? $_POST['kondisi_body_truck'] : 'not ok';
				$action_kondisi_body_truck = isset($_POST['action_kondisi_body_truck']) ? $_POST['action_kondisi_body_truck'] : 'not ok';
				$kecukupan_isi_solar = isset($_POST['kecukupan_isi_solar']) ? $_POST['kecukupan_isi_solar'] : 'not ok';
				$action_kecukupan_isi_solar = isset($_POST['action_kecukupan_isi_solar']) ? $_POST['action_kecukupan_isi_solar'] : 'not ok';
				$kelengkapan_safety = isset($_POST['kelengkapan_safety']) ? $_POST['kelengkapan_safety'] : 'not ok';
				$action_kelengkapan_safety = isset($_POST['action_kelengkapan_safety']) ? $_POST['action_kelengkapan_safety'] : 'not ok';
				$kelengkapan_document = isset($_POST['kelengkapan_document']) ? $_POST['kelengkapan_document'] : 'not ok';
				$action_kelengkapan_document = isset($_POST['action_kelengkapan_document']) ? $_POST['action_kelengkapan_document'] : 'not ok';
				$kelengkapan_document = isset($_POST['kelengkapan_document']) ? $_POST['kelengkapan_document'] : 'not ok';
				$action_kelengkapan_document = isset($_POST['action_kelengkapan_document']) ? $_POST['action_kelengkapan_document'] : 'not ok';
				$kelengkapan_document = isset($_POST['kelengkapan_document']) ? $_POST['kelengkapan_document'] : 'not ok';
				$action_kelengkapan_document = isset($_POST['action_kelengkapan_document']) ? $_POST['action_kelengkapan_document'] : 'not ok';
				
				$data_insert = array(
				
					
					"driver_code" => $driver_code,
					"driver_name" => $driver_name,
					"vehicle_id" => $vehicle_id,
					//"id_shift" => $id_shift,
					"kelengkapan_oli_mesin" => $kelengkapan_oli_mesin,
					"action_kelengkapan_oli_mesin" => $action_kelengkapan_oli_mesin,
					"kecukupan_air_radioator" => $kecukupan_air_radioator,
					"action_kecukupan_air_radioator" => $action_kecukupan_air_radioator,
					"kondisi_ban" => $kondisi_ban,
					"action_kondisi_ban" => $action_kondisi_ban,
					"kondisi_accu" => $kondisi_accu,
					"action_kondisi_accu" => $action_kondisi_accu,
					"kontrol_lampu" => $kontrol_lampu,
					"action_kontrol_lampu" => $action_kontrol_lampu,
					"angin_untuk_rem" => $angin_untuk_rem,
					"action_angin_untuk_rem" => $action_angin_untuk_rem,
					"test_mesin" => $test_mesin,
					"action_test_mesin" => $action_test_mesin,
					"kondisi_body_truck" => $kondisi_body_truck,
					"action_kondisi_body_truck" => $action_kondisi_body_truck,
					"kecukupan_isi_solar" => $kecukupan_isi_solar,
					"action_kecukupan_isi_solar" => $action_kecukupan_isi_solar,
					"kelengkapan_safety" => $kelengkapan_safety,
					"action_kelengkapan_safety" => $action_kelengkapan_safety,
					"kelengkapan_document" => $kelengkapan_document,
					"action_kelengkapan_document" => $action_kelengkapan_document,
					"kelengkapan_document" => $kelengkapan_document,
					"action_kelengkapan_document" => $action_kelengkapan_document,
					"kelengkapan_document" => $kelengkapan_document,
					"action_kelengkapan_document" => $action_kelengkapan_document,
					"date_absence" => $date_absence,
					"created_by" => $username,
					"created_date" => $timestamp

				);
				
				//Check Product Apakah sudah ada dengan kode produk dan type motorist yang sama
				$check = $this->model_truck_absent->getTruckAbsent("WHERE vehicle_id = '".$vehicle_id."' AND date_absence = '".$date_absence."' ");
				if($check->num_rows() >=1 )
				{
					$this->session->set_flashdata('message_failed',"Sorry data already exist!");
					redirect('truck_absent');
					
					}
				else
				{
					
					$res = $this->model_truck_absent->insertData("truck_absent",$data_insert);
					if($res>=1)
					{
						$this->session->set_flashdata('message_success',"Data Truck Absent has been successfully saved!");
						redirect('truck_absent');
						}
					
					}
				
				
			
			}
		else
		{
			$data = "You dont have permission to access this page";
			$comp = array(
			
			'title' => ' Permission Denied',
			'content' => $this->load->view('accessdenied',array('data'=>$data),true),
			'sidebar' => $this->html_sidebar()
			);
			$this->load->view("common/common",$comp);
			
			}
			
		}
		else
		{
			redirect('/auth/login/');
			}
		
	}
	
	public function deleteTruckAbsentAll()
	{
		
			date_default_timezone_set('Asia/Jakarta');
			ini_set('memory_limit', '-1');
			
			if ($this->tank_auth->is_logged_in()) {
			$user	= $this->tank_auth->get_username();
			$data_account = $this->model_account_master->getAccount("WHERE username = '".$user."' ")->result_array();
			$data_role = $this->model_account_master->getRole("WHERE id_role = '".$data_account[0]['user_access']."' ")->result_array();
			$user_role = $data_account[0]['user_type'];
			$code_role = $data_account[0]['code'];
			if($data_role[0]['delete_truck_absent']=='yes')
			{
				
			
				// Get Variable Post
				$id_truck_absent_delete = $_POST['id_absent_delete_all'];
				
		
					//Update Product
					$res = $this->db->query("DELETE FROM truck_absent WHERE id_truck_absent in (".$id_truck_absent_delete.") ");
					if($res>=1)
					{
						$this->session->set_flashdata('message_success',"Data Truck Absent has been successfully deleted!");
						redirect('truck_absent');
						
						}
					else
					{
						$this->session->set_flashdata('message_failed',"Data Truck Absent failed to delete!");
						redirect('truck_absent');
					}
				
				
				
				
				
				
			
			}
		else
		{
			$data = "You dont have permission to access this page";
			$comp = array(
			
			'title' => ' Permission Denied',
			'content' => $this->load->view('accessdenied',array('data'=>$data),true),
			'sidebar' => $this->html_sidebar()
			);
			$this->load->view("common/common",$comp);
			
			}
			
		}
		else
		{
			redirect('/auth/login/');
			}
		
	}
	
	public function editDriver($id_channel)
	{
		
			date_default_timezone_set('Asia/Jakarta');
			ini_set('memory_limit', '-1');
			
			if ($this->tank_auth->is_logged_in()) {
			$user	= $this->tank_auth->get_username();
			$data_account = $this->model_account_master->getAccount("WHERE username = '".$user."' ")->result_array();
			$data_role = $this->model_account_master->getRole("WHERE id_role = '".$data_account[0]['user_access']."' ")->result_array();
			$user_role = $data_account[0]['user_type'];
			$code_role = $data_account[0]['code'];
			
			if($data_role[0]['edit_driver']=='yes')
			{
				
			
				// Get Variable Post
				$driver_code = $_POST['edit_driver_code'];
				$driver_name = $_POST['edit_driver_name'];
				$password = $_POST['edit_password1'];
				$id_driver = $_POST['id_driver_update'];
				
				$data_update_with_password = array(
				
				"driver_code" => $driver_code,
				"driver_name" => $driver_name,
				"password" => md5($password)

				);
				$data_update_without_password = array(
				
				"driver_code" => $driver_code,
				"driver_name" => $driver_name,

				);
				
				$where = array("id_driver"=>$id_driver);
				
				//Check Product Apakah sudah ada dengan kode produk dan type motorist yang sama
				$check = $this->model_truck_absent->getDriver("WHERE driver_code = '".$driver_code."' AND id_driver != '".$id_driver."' ");
				
				
				if($check->num_rows() >=1 )
				{
					$this->session->set_flashdata('message_failed',"Sorry data already exist!");
					redirect('driver');
					
					}
				else
				{
				
					//Update
					if($password=='')
					{
					$res = $this->model_truck_absent->UpdateData("driver",$data_update_without_password,$where);
					}
					else{$res = $this->model_truck_absent->UpdateData("driver",$data_update_with_password,$where);}
					
					if($res>=1)
					{
						$this->session->set_flashdata('message_success',"Data Driver has been successfully updated!");
						
						redirect('driver');
						
						}
					else
					{
						$this->session->set_flashdata('message_failed',"Data Driver failed to update!");
						redirect('driver');
					}
				}
				
				
				
				
				//Check Product Apakah sudah ada dengan kode produk dan type motorist yang sama
			
			
			}
		else
		{
			$data = "You dont have permission to access this page";
			$comp = array(
			
			'title' => ' Permission Denied',
			'content' => $this->load->view('accessdenied',array('data'=>$data),true),
			'sidebar' => $this->html_sidebar()
			);
			$this->load->view("common/common",$comp);
			
			}
			
		}
		else
		{
			redirect('/auth/login/');
			}
		
	}
	
	
	public function deleteTruckAbsent()
	{
		
			date_default_timezone_set('Asia/Jakarta');
			ini_set('memory_limit', '-1');
			
			if ($this->tank_auth->is_logged_in()) {
			$user	= $this->tank_auth->get_username();
			$data_account = $this->model_account_master->getAccount("WHERE username = '".$user."' ")->result_array();
			$data_role = $this->model_account_master->getRole("WHERE id_role = '".$data_account[0]['user_access']."' ")->result_array();
			$user_role = $data_account[0]['user_type'];
			$code_role = $data_account[0]['code'];
			if($data_role[0]['delete_truck_absent']=='yes')
			{
				
			
				// Get Variable Post
				$id_absent_delete = $_POST['id_absent_delete'];
				$where = array("id_truck_absent" => $id_absent_delete);
				
		
					//Update Product
					$res = $this->model_truck_absent->DeleteData("truck_absent",$where);
					if($res>=1)
					{
						$this->session->set_flashdata('message_success',"Data Truck Absent has been successfully deleted!");
						redirect('truck_absent');
						
						}
					else
					{
						$this->session->set_flashdata('message_failed',"Data Truck Absent failed to delete!");
						redirect('truck_absent');
					}
				
				
				
				
				
				
			
			}
		else
		{
			$data = "You dont have permission to access this page";
			$comp = array(
			
			'title' => ' Permission Denied',
			'content' => $this->load->view('accessdenied',array('data'=>$data),true),
			'sidebar' => $this->html_sidebar()
			);
			$this->load->view("common/common",$comp);
			
			}
			
		}
		else
		{
			redirect('/auth/login/');
			}
		
	}
	
	public function exportTruckAbsent()
	{
		
		date_default_timezone_set('Asia/Jakarta');
		if ($this->tank_auth->is_logged_in()) {
		$user	= $this->tank_auth->get_username();
		$data_account = $this->model_account_master->getAccount("WHERE username = '".$user."' ")->result_array();
		$data_role = $this->model_account_master->getRole("WHERE id_role = '".$data_account[0]['user_access']."' ")->result_array();
		$user_role = $data_account[0]['user_type'];
		$code_role = $data_account[0]['code'];
		
		if($data_role[0]['export_truck_absent']=='yes')
		{
		$search = isset($_GET['search']) ? $_GET['search'] : '';

		
		$date = date("m-d-Y");
		$this->db->or_like('vehicle_id', $search);
		$this->db->join('shift', 'shift.id_shift = truck_absent.id_shift','LEFT');
		$query = $this->db->get('truck_absent');
        if(!$query)
        return false;
 
        // Starting the PHPExcel library
        $this->load->library('PHPExcel');
        $this->load->library('PHPExcel/IOFactory');
 
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setTitle("export")->setDescription("none");
		
 
        $objPHPExcel->setActiveSheetIndex(0);
 		$objPHPExcel->getActiveSheet()->setShowGridlines(false);
		
		$BStyle = array(
		  'borders' => array(
			'allborders' => array(
			  'style' => PHPExcel_Style_Border::BORDER_THIN
			)
		  )
		);
		
		$Fontstyle = array(
		'font'  => array(
			'bold'  => true,
			'color' => array('rgb' => 'ffffff')
		));
		
		$FontstyleTitle = array(
		'font'  => array(
			'bold'  => true,
			'color' => array('rgb' => '000000'),
			'size' => 15
		));
		
		$styleAlign = array(
        'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        )
    	);
		
		//Set Width Column
		foreach(range('B','Z') as $columnID)
		{
			$objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
		}
		
		
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 1, "Master Truck Roaster");
		//Merge And Center Title
		$objPHPExcel->getActiveSheet()->mergeCells('A1:D1');
		
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 2, "Date : ".$date);
		
		//Merge And Center Date
		$objPHPExcel->getActiveSheet()->mergeCells('A2:D2');
		
		//Set Font Color Title
		$objPHPExcel->getActiveSheet()->getStyle('A1:D2')->applyFromArray($FontstyleTitle);
		
		//Set Font Color Header
		$objPHPExcel->getActiveSheet()->getStyle('A4:G4')->applyFromArray($Fontstyle);
		
		//Set Backgroung Color Header
		$objPHPExcel->getActiveSheet()->getStyle('A4:G4')->applyFromArray(
			array(
				'fill' => array(
					'type' => PHPExcel_Style_Fill::FILL_SOLID,
					'color' => array('rgb' => '62a8ea')
				)
			)
		);


		
        // Field names in the first row
         // Field names in the first row
        $fields = array(
		
		"No" => "No",
		"ID Absent" => "ID Absent",
		"vehicle ID" => "vehicle ID",
		"Driver Code" => "Driver Code",
		"Driver Name" => "Driver Name",
		"Date Absence" => "Date Absence",
		"Shift" => "Shift"
		
		);
        $col = 0;
        foreach ($fields as $field)
        {
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, 4, $field);
            $col++;
        }
		
		
		

 
        // Fetching the table data
        $row = 5;
		$no = 1;
        foreach($query->result_array() as $data)
        {
			
			
		
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $row, $no);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $row, $data['id_truck_absent']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $row, $data['vehicle_id']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $row, $data['driver_code']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $row, $data['driver_name']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, $row, $data['date_absence']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, $row, $data['shift']);
			
 
            $row++;
			$no++;
        }
		
	   $last_row = $row-1;
	   //Set Border
       $objPHPExcel->getActiveSheet()->getStyle("A4".":"."G".$last_row)->applyFromArray($BStyle);
	   $objPHPExcel->getActiveSheet()->getStyle("A4".":"."G".$last_row)->applyFromArray($styleAlign);
       $objPHPExcel->setActiveSheetIndex(0);
 
        $objWriter = IOFactory::createWriter($objPHPExcel, 'Excel5');
 		
		
	   // Sending headers to force the user to download the file
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Master-truck-roaster-'.$date.'.xls"');
        header('Cache-Control: max-age=0');
        $objWriter->save('php://output');
		
			}
			else
			{
				$data = "You dont have permission to access this page";
				$comp = array(
			
				'title' => ' Permission Denied',
				'content' => $this->load->view('accessdenied',array('data'=>$data),true),
				'sidebar' => $this->html_sidebar()
				);
				$this->load->view("common/common",$comp);
			
				}
			
			}
		else
		{
			redirect('/auth/login/');
			}
			
		}
	
	public function importDriver()
	{
		
			date_default_timezone_set('Asia/Jakarta');
			ini_set('memory_limit', '-1');
			
			if ($this->tank_auth->is_logged_in()) {
			$user	= $this->tank_auth->get_username();
			$data_account = $this->model_account_master->getAccount("WHERE username = '".$user."' ")->result_array();
			$data_role = $this->model_account_master->getRole("WHERE id_role = '".$data_account[0]['user_access']."' ")->result_array();
			$user_role = $data_account[0]['user_type'];
			$code_role = $data_account[0]['code'];
			
			if($data_role[0]['import_driver']=='yes')
			{
				
				
			if ($_POST) {
			ini_set('memory_limit', '-1');
		    $fileName = $_FILES['import_file']['name'];
			$config['upload_path'] = './files/';
			$config['file_name'] = $fileName;
			$config['allowed_types'] = 'xls|xlsx';
			$config['max_size']		= 100000000;

			$this->load->library('upload');
			$this->upload->initialize($config);

			if(! $this->upload->do_upload('import_file') )
			{
				$this->session->set_flashdata('message_failed','Import Failed, Please upload file excel extension!');
				redirect('driver');
				
				
			}
			else
			{

			$media = $this->upload->data('import');
			
			$inputFileName = './files/'.$media['file_name'];

			//  Read your Excel workbook
			try {
				$inputFileType = IOFactory::identify($inputFileName);
				$objReader = IOFactory::createReader($inputFileType);
				$objPHPExcel = $objReader->load($inputFileName);
			} catch(Exception $e) {
				die('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());
			}

			//  Get worksheet dimensions
			$sheet = $objPHPExcel->getSheet(0);
			$highestRow = $sheet->getHighestRow();
			$highestColumn = $sheet->getHighestColumn();

			//  Loop through each row of the worksheet in turn
			for ($row = 2; $row <= $highestRow; $row++){  				//  Read a row of data into an array 				
                        $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,
												NULL,
												TRUE,
												FALSE);
												
												
				
				
			
					//jika master data tidak kosong maka akan diisi		
					$check = $this->model_truck_absent->getDriver("WHERE driver_code  = '".$rowData[0][0]."' ");
					if($check->num_rows() >=1 )
					{
						
						$data_update = array(
							"driver_name" => $rowData[0][1],
							"password" => md5($rowData[0][2])
							
						);
						$where = array(
							"driver_code" => $rowData[0][0]
						);
						
						$res = $this->model_truck_absent->UpdateData("driver",$data_update,$where);
					
						}
					else
					{
						$data_insert = array(
							"driver_code" => $rowData[0][0],
							"driver_name" => $rowData[0][1],
							"password" => md5($rowData[0][2])
						);
						
						//Insert Data
						$res = $this->model_truck_absent->insertData("driver",$data_insert);
					
					}
					
				
				
			}
				@unlink($inputFileName);
				$this->session->set_flashdata('message_success','Data imported successfully');
				redirect('driver');
			
               
			}
			
			 	
            }
		
			
			}
		else
		{
			$data = "You dont have permission to access this page";
			$comp = array(
			
			'title' => ' Permission Denied',
			'content' => $this->load->view('accessdenied',array('data'=>$data),true),
			'sidebar' => $this->html_sidebar()
			);
			$this->load->view("common/common",$comp);
			
			}
			
		}
		else
		{
			redirect('/auth/login/');
			}
		
	}
	
	public function addTruckAbsent()
	{
		
			date_default_timezone_set('Asia/Jakarta');
			ini_set('memory_limit', '-1');
			
			if ($this->tank_auth->is_logged_in()) {
			$user	= $this->tank_auth->get_username();
			$data_account = $this->model_account_master->getAccount("WHERE username = '".$user."' ")->result_array();
			$data_role = $this->model_account_master->getRole("WHERE id_role = '".$data_account[0]['user_access']."' ")->result_array();
			$user_role = $data_account[0]['user_type'];
			$code_role = $data_account[0]['code'];
			
			if($data_role[0]['add_truck_absent']=='yes')
			{
				
			
				// Get Variable Post
				$date_absence = date('Y:m:d');
				$timestamp = date('Y:m:d H:i:s');
				$username = $user;
				$driver_code = $_POST['driver_code'];
				$driver_name = $_POST['driver_name'];
				$vehicle_id = $_POST['vehicle_id'];
				//$id_shift = $_POST['id_shift'];
				//Kelengkapan
				$kelengkapan_oli_mesin = isset($_POST['kelengkapan_oli_mesin']) ? $_POST['kelengkapan_oli_mesin'] : 'not ok';
				$action_kelengkapan_oli_mesin = isset($_POST['action_kelengkapan_oli_mesin']) ? $_POST['action_kelengkapan_oli_mesin'] : 'not ok';
				$kecukupan_air_radioator = isset($_POST['kecukupan_air_radioator']) ? $_POST['kecukupan_air_radioator'] : 'not ok';
				$action_kecukupan_air_radioator = isset($_POST['action_kecukupan_air_radioator']) ? $_POST['action_kecukupan_air_radioator'] : 'not ok';
				$kondisi_ban = isset($_POST['kondisi_ban']) ? $_POST['kondisi_ban'] : 'not ok';
				$action_kondisi_ban = isset($_POST['action_kondisi_ban']) ? $_POST['action_kondisi_ban'] : 'not ok';
				$kondisi_accu = isset($_POST['kondisi_accu']) ? $_POST['kondisi_accu'] : 'not ok';
				$action_kondisi_accu = isset($_POST['action_kondisi_accu']) ? $_POST['action_kondisi_accu'] : 'not ok';
				$kontrol_lampu = isset($_POST['kontrol_lampu']) ? $_POST['kontrol_lampu'] : 'not ok';
				$action_kontrol_lampu = isset($_POST['action_kontrol_lampu']) ? $_POST['action_kontrol_lampu'] : 'not ok';
				$angin_untuk_rem = isset($_POST['angin_untuk_rem']) ? $_POST['angin_untuk_rem'] : 'not ok';
				$action_angin_untuk_rem = isset($_POST['action_angin_untuk_rem']) ? $_POST['action_angin_untuk_rem'] : 'not ok';
				$test_mesin = isset($_POST['test_mesin']) ? $_POST['test_mesin'] : 'not ok';
				$action_test_mesin = isset($_POST['action_test_mesin']) ? $_POST['action_test_mesin'] : 'not ok';
				$kondisi_body_truck = isset($_POST['kondisi_body_truck']) ? $_POST['kondisi_body_truck'] : 'not ok';
				$action_kondisi_body_truck = isset($_POST['action_kondisi_body_truck']) ? $_POST['action_kondisi_body_truck'] : 'not ok';
				$kecukupan_isi_solar = isset($_POST['kecukupan_isi_solar']) ? $_POST['kecukupan_isi_solar'] : 'not ok';
				$action_kecukupan_isi_solar = isset($_POST['action_kecukupan_isi_solar']) ? $_POST['action_kecukupan_isi_solar'] : 'not ok';
				$kelengkapan_safety = isset($_POST['kelengkapan_safety']) ? $_POST['kelengkapan_safety'] : 'not ok';
				$action_kelengkapan_safety = isset($_POST['action_kelengkapan_safety']) ? $_POST['action_kelengkapan_safety'] : 'not ok';
				$kelengkapan_document = isset($_POST['kelengkapan_document']) ? $_POST['kelengkapan_document'] : 'not ok';
				$action_kelengkapan_document = isset($_POST['action_kelengkapan_document']) ? $_POST['action_kelengkapan_document'] : 'not ok';
				$kelengkapan_document = isset($_POST['kelengkapan_document']) ? $_POST['kelengkapan_document'] : 'not ok';
				$action_kelengkapan_document = isset($_POST['action_kelengkapan_document']) ? $_POST['action_kelengkapan_document'] : 'not ok';
				$kelengkapan_document = isset($_POST['kelengkapan_document']) ? $_POST['kelengkapan_document'] : 'not ok';
				$action_kelengkapan_document = isset($_POST['action_kelengkapan_document']) ? $_POST['action_kelengkapan_document'] : 'not ok';
				
				$data_insert = array(
				
					
					"driver_code" => $driver_code,
					"driver_name" => $driver_name,
					"vehicle_id" => $vehicle_id,
					//"id_shift" => $id_shift,
					"kelengkapan_oli_mesin" => $kelengkapan_oli_mesin,
					"action_kelengkapan_oli_mesin" => $action_kelengkapan_oli_mesin,
					"kecukupan_air_radioator" => $kecukupan_air_radioator,
					"action_kecukupan_air_radioator" => $action_kecukupan_air_radioator,
					"kondisi_ban" => $kondisi_ban,
					"action_kondisi_ban" => $action_kondisi_ban,
					"kondisi_accu" => $kondisi_accu,
					"action_kondisi_accu" => $action_kondisi_accu,
					"kontrol_lampu" => $kontrol_lampu,
					"action_kontrol_lampu" => $action_kontrol_lampu,
					"angin_untuk_rem" => $angin_untuk_rem,
					"action_angin_untuk_rem" => $action_angin_untuk_rem,
					"test_mesin" => $test_mesin,
					"action_test_mesin" => $action_test_mesin,
					"kondisi_body_truck" => $kondisi_body_truck,
					"action_kondisi_body_truck" => $action_kondisi_body_truck,
					"kecukupan_isi_solar" => $kecukupan_isi_solar,
					"action_kecukupan_isi_solar" => $action_kecukupan_isi_solar,
					"kelengkapan_safety" => $kelengkapan_safety,
					"action_kelengkapan_safety" => $action_kelengkapan_safety,
					"kelengkapan_document" => $kelengkapan_document,
					"action_kelengkapan_document" => $action_kelengkapan_document,
					"kelengkapan_document" => $kelengkapan_document,
					"action_kelengkapan_document" => $action_kelengkapan_document,
					"kelengkapan_document" => $kelengkapan_document,
					"action_kelengkapan_document" => $action_kelengkapan_document,
					"date_absence" => $date_absence,
					"created_by" => $username,
					"created_date" => $timestamp

				);
				
				//Check Product Apakah sudah ada dengan kode produk dan type motorist yang sama
				$check = $this->model_truck_absent->getTruckAbsent("WHERE vehicle_id = '".$vehicle_id."' AND date_absence = '".$date_absence."' ");
				if($check->num_rows() >=1 )
				{
					$this->session->set_flashdata('message_failed',"Sorry data already exist!");
					redirect('truck_absent');
					
					}
				else
				{
					
					$res = $this->model_truck_absent->insertData("truck_absent",$data_insert);
					if($res>=1)
					{
						$this->session->set_flashdata('message_success',"Data Truck Absent has been successfully saved!");
						redirect('truck_absent');
						}
					
					}
				
				
			
			}
		else
		{
			$data = "You dont have permission to access this page";
			$comp = array(
			
			'title' => ' Permission Denied',
			'content' => $this->load->view('accessdenied',array('data'=>$data),true),
			'sidebar' => $this->html_sidebar()
			);
			$this->load->view("common/common",$comp);
			
			}
			
		}
		else
		{
			redirect('/auth/login/');
			}
		
	}
	
	
	public function index()
	{
		
			date_default_timezone_set('Asia/Jakarta');
			if ($this->tank_auth->is_logged_in()) {
			$user	= $this->tank_auth->get_username();
			$data_account = $this->model_account_master->getAccount("WHERE username = '".$user."' ")->result_array();
			$data_role = $this->model_account_master->getRole("WHERE id_role = '".$data_account[0]['user_access']."' ")->result_array();
			$user_role = $data_account[0]['user_type'];
			$code_role = $data_account[0]['code'];
			
			if($data_role[0]['see_truck_absent']=='yes')
			{	
			$this->load->library('table');
			$this->load->library('pagination');
			$search = isset($_GET['search']) ? $_GET['search'] : '';
			
			
			$jumlah= $this->model_truck_absent->countTruckAbsent($search);
			
			if (count($_GET) > 0) $config['suffix'] = '?' . http_build_query($_GET, '', "&");
			$config['base_url'] = base_url().'index.php/truck_absent/truck_absent/';
			$config['total_rows'] = $jumlah;
			$config['first_link'] = 'First';
			$config['last_link'] = 'End';
			$config['next_link'] = 'Next';
			$config['prev_link'] = 'Previous';
			$config['per_page'] = 5; 	
			if (count($_GET) > 0) $config['suffix'] = '?' . http_build_query($_GET, '', "&");
			$config['first_url'] = $config['base_url'].'?'.http_build_query($_GET);
			
			$dari = $this->uri->segment('3');
			$data = $this->model_truck_absent->dataTruckAbsent($config['per_page'],$dari,$search);
			$data_shift = $this->db->query("SELECT * FROM shift")->result();
			
			$data_category_truck_absent = $this->db->query("SELECT * FROM master_data_category WHERE category = 'Truck Absent' ")->result();
			$data_category_shift = $this->db->query("SELECT * FROM master_data_category WHERE category = 'Shift Driver' ")->result();
		
			$comp = array(
				'title' => ' Truck Absent',
				'content' => $this->load->view('truck_absent',array('data_category_shift'=>$data_category_shift,'data_category_truck_absent'=>$data_category_truck_absent,'data_shift'=>$data_shift,'data_absent'=>$data,'data_role'=>$data_role,'search'=>$search),true),
				'sidebar' => $this->html_sidebar()
			);
			$this->load->view("common/common",$comp);
			}
		else
		{
			$data = "You dont have permission to access this page";
			$comp = array(
			
			'title' => ' Permission Denied',
			'content' => $this->load->view('accessdenied',array('data'=>$data),true),
			'sidebar' => $this->html_sidebar()
			);
			$this->load->view("common/common",$comp);
			
			}
			
		}
		else
		{
			redirect('/auth/login/');
			}
		
	}
	
	public function html_sidebar()
	{
		
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {
			$user	= $this->tank_auth->get_username();
			
			$data_account = $this->model_account_master->getAccount("WHERE username = '".$user."' ")->result_array();
			$data_role = $this->model_account_master->getRole("WHERE id_role = '".$data_account[0]['user_access']."' ")->result_array();
			return $this->load->view("common/sidebar_admin",array('data_account'=>$data_account,'data_role'=>$data_role),true);
		}
	}
	
}

/* End of file dashboard.php */
/* Location: ./application/controllers/admin/dashboard.php */