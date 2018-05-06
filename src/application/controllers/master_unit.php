<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Master_unit extends CI_Controller {

	function __construct()  {
 		parent::__construct();
			$this->load->library(array('PHPExcel','PHPExcel/IOFactory'));
			$this->load->model('model_account_master');
			$this->load->model('Model_master_unit');
			$this->load->library('tank_auth');
			
	}
	
	
	public function deleteMasterUnitAll()
	{
		
			date_default_timezone_set('Asia/Jakarta');
			ini_set('memory_limit', '-1');
			
			if ($this->tank_auth->is_logged_in()) {
			$user	= $this->tank_auth->get_username();
			$data_account = $this->model_account_master->getAccount("WHERE username = '".$user."' ")->result_array();
			$data_role = $this->model_account_master->getRole("WHERE id_role = '".$data_account[0]['user_access']."' ")->result_array();
			$user_role = $data_account[0]['user_type'];
			$code_role = $data_account[0]['code'];
			if($data_role[0]['delete_master_unit']=='yes')
			{
				
			
				// Get Variable Post
				$id_master_unit_delete = $_POST['id_master_unit_delete_all'];
				
		
					//Update Product
					$res = $this->db->query("DELETE FROM master_unit WHERE id_master_unit in (".$id_master_unit_delete.") ");
					if($res>=1)
					{
						$this->session->set_flashdata('message_success',"Data Master unit has been successfully deleted!");
						redirect('master_unit');
						
						}
					else
					{
						$this->session->set_flashdata('message_failed',"Data Master unit failed to delete!");
						redirect('master_unit');
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
	
	public function editMasterunit()
	{
		
			date_default_timezone_set('Asia/Jakarta');
			ini_set('memory_limit', '-1');
			
			if ($this->tank_auth->is_logged_in()) {
			$user	= $this->tank_auth->get_username();
			$data_account = $this->model_account_master->getAccount("WHERE username = '".$user."' ")->result_array();
			$data_role = $this->model_account_master->getRole("WHERE id_role = '".$data_account[0]['user_access']."' ")->result_array();
			$user_role = $data_account[0]['user_type'];
			$code_role = $data_account[0]['code'];
			
			if($data_role[0]['edit_master_unit']=='yes')
			{
				
				$timestamp = date('Y:m:d H:i:s');
				// Get Variable Post
				$vehicle_id = $_POST['edit_vehicle_id'];
				$vehicle_type = $_POST['edit_vehicle_type'];
				$manufacture_date = (explode("-",$_POST['edit_manufacture_date']));
				$manufacture_date = $manufacture_date[2].'-'.$manufacture_date[1].'-'.$manufacture_date[0];
				$purchase_date = (explode("-",$_POST['edit_purchase_date']));
				$purchase_date = $purchase_date[2].'-'.$purchase_date[1].'-'.$purchase_date[0];
				$fuel_type = $_POST['edit_fuel_type'];
				$body_type = $_POST['edit_body_type'];
				$purchase_from = $_POST['edit_purchase_from'];
				$model = $_POST['edit_model'];
				$merk = $_POST['edit_merk'];
				$purchase_price = $_POST['edit_purchase_price'];
				$assembly_type = $_POST['edit_assembly_type'];
				$current_odo = $_POST['edit_current_odo'];
				$kode_lambung = $_POST['edit_kode_lambung'];
				$year = $_POST['edit_year'];
				$fuel_ratio_litre = $_POST['edit_fuel_ratio_litre'];
				$tire_qty = $_POST['edit_tire_qty'];
				$spare_tire = $_POST['edit_spare_tire'];
				$username = $user;
				$id_master_unit_update = $_POST['id_master_unit_update'];
				
			
				$data_update= array(
				
				'vehicle_id' => $vehicle_id,
				'vehicle_type' => $vehicle_type,
				'manufacture_date' => $manufacture_date,
				'purchase_date' => $purchase_date,
				'fuel_type' => $fuel_type,
				'body_type' => $body_type,
				'purchase_from' => $purchase_from,
				'model' => $model,
				'merk' => $merk,
				'purchase_price' => $purchase_price,
				'assembly_type' => $assembly_type,
				'current_odo' => $current_odo,
				'kode_lambung' => $kode_lambung,
				'year' => $year,
				'fuel_ratio_litre' => $fuel_ratio_litre,
				'tire_qty' => $tire_qty,
				'spare_tire' => $spare_tire,
				'updated_by' => $username,
				'updated_date' => $fuel_ratio_litre
				
				
				);
				
				$where = array("id_master_unit"=>$id_master_unit_update);
				
				//Check Product Apakah sudah ada dengan kode produk dan type motorist yang sama
				$check = $this->Model_master_unit->getMasterUnit("WHERE vehicle_id = '".$vehicle_id."' AND id_master_unit != '".$id_master_unit_update."' ");
				
				
				if($check->num_rows() >=1 )
				{
					$this->session->set_flashdata('message_failed',"Sorry data already exist!");
					redirect('master_unit');
					
					}
				else
				{
				
					//Update
					$res = $this->Model_master_unit->UpdateData("master_unit",$data_update,$where);
					
					if($res>=1)
					{
						$this->session->set_flashdata('message_success',"Data Master Unit has been successfully updated!");
						
						redirect('master_unit');
						
						}
					else
					{
						$this->session->set_flashdata('message_failed',"Data Master Unit failed to update!");
						redirect('master_unit');
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
	
	
	public function deleteMasterUnit()
	{
		
			date_default_timezone_set('Asia/Jakarta');
			ini_set('memory_limit', '-1');
			
			if ($this->tank_auth->is_logged_in()) {
			$user	= $this->tank_auth->get_username();
			$data_account = $this->model_account_master->getAccount("WHERE username = '".$user."' ")->result_array();
			$data_role = $this->model_account_master->getRole("WHERE id_role = '".$data_account[0]['user_access']."' ")->result_array();
			$user_role = $data_account[0]['user_type'];
			$code_role = $data_account[0]['code'];
			if($data_role[0]['delete_master_unit']=='yes')
			{
				
			
				// Get Variable Post
				$id_master_unit_delete = $_POST['id_master_unit_delete'];
				$where = array("vehicle_id" => $id_master_unit_delete);
				
		
					//Update Product
					$res = $this->Model_master_unit->DeleteData("master_unit",$where);
					if($res>=1)
					{
						$this->session->set_flashdata('message_success',"Data Master unit has been successfully deleted!");
						redirect('master_unit');
						
						}
					else
					{
						$this->session->set_flashdata('message_failed',"Data Master unit failed to delete!");
						redirect('master_unit');
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
	
	public function exportMasterUnit()
	{
		
		date_default_timezone_set('Asia/Jakarta');
		if ($this->tank_auth->is_logged_in()) {
		$user	= $this->tank_auth->get_username();
		$data_account = $this->model_account_master->getAccount("WHERE username = '".$user."' ")->result_array();
		$data_role = $this->model_account_master->getRole("WHERE id_role = '".$data_account[0]['user_access']."' ")->result_array();
		$user_role = $data_account[0]['user_type'];
		$code_role = $data_account[0]['code'];
		
		if($data_role[0]['export_master_unit']=='yes')
		{
		$search = isset($_GET['search']) ? $_GET['search'] : '';

		
		$date = date("m-d-Y");
		$this->db->like('vehicle_id', $search);
		$query = $this->db->get('master_unit');
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
		
		
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 1, "Master Unit ");
		//Merge And Center Title
		$objPHPExcel->getActiveSheet()->mergeCells('A1:D1');
		
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 2, "Date : ".$date);
		
		//Merge And Center Date
		$objPHPExcel->getActiveSheet()->mergeCells('A2:D2');
		
		//Set Font Color Title
		$objPHPExcel->getActiveSheet()->getStyle('A1:D2')->applyFromArray($FontstyleTitle);
		
		//Set Font Color Header
		$objPHPExcel->getActiveSheet()->getStyle('A4:R4')->applyFromArray($Fontstyle);
		
		//Set Backgroung Color Header
		$objPHPExcel->getActiveSheet()->getStyle('A4:R4')->applyFromArray(
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
		"vehicle ID" => "vehicle ID",
		"Vehicle Type" => "Vehicle Type",
		"Manufacture Date" => "Manufacture Date",
		"Purchase Date" => "Purchase Date",
		"Fuel type" => "Fuel type",
		"Body type" => "Body type",
		"Purchase From" => "Purchase From",
		"Merk" => "Merk",
		"Purchase Price" => "Purchase Price",
		"Model" => "Model",
		"Assembly Type" => "Assembly Type",
		"Current ODO" => "Current ODO",
		"Kode Lambung" => "Kode Lambung",
		"Year" => "Year",
		"Fuel Ratio Litre" => "Fuel Ratio Litre",
		"Tire Qty" => "Tire Qty",
		"Spare Tire" => "Spare Tire"
		
		
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
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $row, $data['vehicle_id']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $row, $data['vehicle_type']);
			$manufacture_date = (explode("-",$data['manufacture_date']));
			$manufacture_date = $manufacture_date[2].'-'.$manufacture_date[1].'-'.$manufacture_date[0];
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $row, $manufacture_date);
			$purchase_date = (explode("-",$data['purchase_date']));
			$purchase_date = $purchase_date[2].'-'.$purchase_date[1].'-'.$purchase_date[0];
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $row, $data['purchase_date']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, $row, $data['fuel_type']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, $row, $data['body_type']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, $row, $data['purchase_from']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8, $row, $data['merk']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9, $row, $data['purchase_price']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(10, $row, $data['model']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(11, $row, $data['assembly_type']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(12, $row, $data['current_odo']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(13, $row, $data['kode_lambung']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(14, $row, $data['year']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(15, $row, $data['fuel_ratio_litre']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(16, $row, $data['tire_qty']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(17, $row, $data['spare_tire']);
 
            $row++;
			$no++;
        }
		
	   $last_row = $row-1;
	   //Set Border
       $objPHPExcel->getActiveSheet()->getStyle("A4".":"."R".$last_row)->applyFromArray($BStyle);
	   $objPHPExcel->getActiveSheet()->getStyle("A4".":"."R".$last_row)->applyFromArray($styleAlign);
       $objPHPExcel->setActiveSheetIndex(0);
 
        $objWriter = IOFactory::createWriter($objPHPExcel, 'Excel5');
 		
		
	   // Sending headers to force the user to download the file
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Master-master-unit-type-'.$date.'.xls"');
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
	
	public function importMasterUnit()
	{
		
			date_default_timezone_set('Asia/Jakarta');
			ini_set('memory_limit', '-1');
			
			if ($this->tank_auth->is_logged_in()) {
			$user	= $this->tank_auth->get_username();
			$data_account = $this->model_account_master->getAccount("WHERE username = '".$user."' ")->result_array();
			$data_role = $this->model_account_master->getRole("WHERE id_role = '".$data_account[0]['user_access']."' ")->result_array();
			$user_role = $data_account[0]['user_type'];
			$code_role = $data_account[0]['code'];
			
			if($data_role[0]['import_vehicle_type']=='yes')
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
					$check = $this->Model_master_unit->getMasterUnit("WHERE vehicle_id  = '".$rowData[0][0]."' ");
					
					
					$timestamp = date('Y:m:d H:i:s');
					$username = $user;
					$manufacture_date = (explode("-",$rowData[0][2]));
					$manufacture_date = $manufacture_date[2].'-'.$manufacture_date[1].'-'.$manufacture_date[0];

					$purchase_date = (explode("-",$rowData[0][3]));
					$purchase_date = $purchase_date[2].'-'.$purchase_date[1].'-'.$purchase_date[0];
				
					if($check->num_rows() >=1 )
					{
						
						$data_update = array(
							"vehicle_id" => $rowData[0][0],
							"vehicle_type" => $rowData[0][1],
							"manufacture_date" => $manufacture_date,
							"purchase_date" => $purchase_date,
							"fuel_type" => $rowData[0][4],
							"body_type" => $rowData[0][5],
							"purchase_from" => $rowData[0][6],
							"merk" => $rowData[0][7],
							"purchase_price	" => $rowData[0][8],
							"model" => $rowData[0][9],
							"assembly_type" => $rowData[0][10],
							"current_odo" => $rowData[0][11],
							"year" => $rowData[0][12],
							"fuel_ratio_litre" => $rowData[0][13],
							"updated_by" => $username,
							"updated_date" => $timestamp
							
						);
						$where = array(
							"vehicle_id" => $rowData[0][0]
						);
						
						$res = $this->Model_master_unit->UpdateData("master_unit",$data_update,$where);
					
						}
					else
					{
						$data_insert = array(
							"vehicle_id" => $rowData[0][0],
							"vehicle_type" => $rowData[0][1],
							"manufacture_date" => $manufacture_date,
							"purchase_date" => $purchase_date,
							"fuel_type" => $rowData[0][4],
							"body_type" => $rowData[0][5],
							"purchase_from" => $rowData[0][6],
							"merk" => $rowData[0][7],
							"purchase_price	" => $rowData[0][8],
							"model" => $rowData[0][9],
							"assembly_type" => $rowData[0][10],
							"current_odo" => $rowData[0][11],
							"year" => $rowData[0][12],
							"fuel_ratio_litre" => $rowData[0][13],
							"created_by" => $username,
							"created_date" => $timestamp
						);
						
						//Insert Data
						$res = $this->Model_master_unit->insertData("master_unit",$data_insert);
					
					}
					
				
				
			}
				@unlink($inputFileName);
				$this->session->set_flashdata('message_success','Data imported successfully');
				redirect('master_unit');
			
               
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
	
	
	public function addMasterUnit()
	{
		
			date_default_timezone_set('Asia/Jakarta');
			ini_set('memory_limit', '-1');
			
			if ($this->tank_auth->is_logged_in()) {
			$user	= $this->tank_auth->get_username();
			$data_account = $this->model_account_master->getAccount("WHERE username = '".$user."' ")->result_array();
			$data_role = $this->model_account_master->getRole("WHERE id_role = '".$data_account[0]['user_access']."' ")->result_array();
			$user_role = $data_account[0]['user_type'];
			$code_role = $data_account[0]['code'];
			
			if($data_role[0]['add_master_unit']=='yes')
			{
				
				$timestamp = date('Y:m:d H:i:s');
				// Get Variable Post
				$vehicle_id = $_POST['vehicle_id'];
				$vehicle_type = $_POST['vehicle_type'];
				$manufacture_date = (explode("-",$_POST['manufacture_date']));
				$manufacture_date = $manufacture_date[2].'-'.$manufacture_date[1].'-'.$manufacture_date[0];
				$purchase_date = (explode("-",$_POST['purchase_date']));
				$purchase_date = $purchase_date[2].'-'.$purchase_date[1].'-'.$purchase_date[0];
				$fuel_type = $_POST['fuel_type'];
				$body_type = $_POST['body_type'];
				$purchase_from = $_POST['purchase_from'];
				$model = $_POST['model'];
				$merk = $_POST['merk'];
				$purchase_price = $_POST['purchase_price'];
				$assembly_type = $_POST['assembly_type'];
				$current_odo = $_POST['current_odo'];
				$kode_lambung = $_POST['kode_lambung'];
				$year = $_POST['year'];
				$fuel_ratio_litre = $_POST['fuel_ratio_litre'];
				$tire_qty = $_POST['tire_qty'];
				$spare_tire = $_POST['spare_tire'];
				$username = $user;
				
				
				$data_insert = array(
				
					'vehicle_id' => $vehicle_id,
					'vehicle_type' => $vehicle_type,
					'manufacture_date' => $manufacture_date,
					'purchase_date' => $purchase_date,
					'fuel_type' => $fuel_type,
					'body_type' => $body_type,
					'purchase_from' => $purchase_from,
					'merk' => $merk,
					'model' => $model,
					'purchase_price' => $purchase_price,
					'assembly_type' => $assembly_type,
					'current_odo' => $current_odo,
					'kode_lambung' => $kode_lambung,
					'year' => $year,
					'fuel_ratio_litre' => $fuel_ratio_litre,
					'tire_qty' => $tire_qty,
					'spare_tire' => $spare_tire,
					'created_by' => $username,
					'created_date' => $timestamp
				);
				
				//Check Product Apakah sudah ada dengan kode produk dan type motorist yang sama
				$check = $this->Model_master_unit->getMasterUnit("WHERE vehicle_id = '".$vehicle_id."' ");
				if($check->num_rows() >=1 )
				{
					$this->session->set_flashdata('message_failed',"Sorry data already exist!");
					redirect('master_unit');
					
					}
				else
				{
					
					$res = $this->Model_master_unit->insertData("master_unit",$data_insert);
					if($res>=1)
					{
						$this->session->set_flashdata('message_success',"Data Master Unit has been successfully saved!");
						redirect('master_unit');
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
			
			if($data_role[0]['see_master_unit']=='yes')
			{	
			$this->load->library('table');
			$this->load->library('pagination');
			$search = isset($_GET['search']) ? $_GET['search'] : '';
			
			
			$jumlah= $this->Model_master_unit->countMasterUnit($search);
			
			if (count($_GET) > 0) $config['suffix'] = '?' . http_build_query($_GET, '', "&");
			$config['base_url'] = base_url().'index.php/master_unit/master_unit/';
			$config['total_rows'] = $jumlah;
			$config['first_link'] = 'First';
			$config['last_link'] = 'End';
			$config['next_link'] = 'Next';
			$config['prev_link'] = 'Previous';
			$config['per_page'] = 20; 	
			if (count($_GET) > 0) $config['suffix'] = '?' . http_build_query($_GET, '', "&");
			$config['first_url'] = $config['base_url'].'?'.http_build_query($_GET);
			
			$dari = $this->uri->segment('3');
			$data = $this->Model_master_unit->dataMasterUnit($config['per_page'],$dari,$search);
			$this->pagination->initialize($config);
			$data_vehicle_type = $this->db->query("SELECT * FROM vehicle_type")->result();
			
			
			$data_category_fuel = $this->db->query("SELECT * FROM master_data_category WHERE category = 'Fuel Type Master Unit' ")->result();
			$data_category_body = $this->db->query("SELECT * FROM master_data_category WHERE category = 'Body Type Master Unit' ")->result();
			$data_category_assembly = $this->db->query("SELECT * FROM master_data_category WHERE category = 'Assembly Type Master Unit' ")->result();
			
			
			$comp = array(
				'title' => ' Master Unit',
				'content' => $this->load->view('master_unit',array('data_category_body'=>$data_category_body,'data_category_assembly'=>$data_category_assembly,'data_category_fuel'=>$data_category_fuel,'data_master_unit'=>$data,'data_vehicle_type'=>$data_vehicle_type,'data_role'=>$data_role,'search'=>$search),true),
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