<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tire_management extends CI_Controller {

	function __construct()  {
 		parent::__construct();
			$this->load->library(array('PHPExcel','PHPExcel/IOFactory'));
			$this->load->model('model_account_master');
			$this->load->model('model_tire_management');
			$this->load->library('tank_auth');
			
	}
	
	
	public function deleteTireAll()
	{
		
			date_default_timezone_set('Asia/Jakarta');
			ini_set('memory_limit', '-1');
			
			if ($this->tank_auth->is_logged_in()) {
			$user	= $this->tank_auth->get_username();
			$data_account = $this->model_account_master->getAccount("WHERE username = '".$user."' ")->result_array();
			$data_role = $this->model_account_master->getRole("WHERE id_role = '".$data_account[0]['user_access']."' ")->result_array();
			$user_role = $data_account[0]['user_type'];
			$code_role = $data_account[0]['code'];
			if($data_role[0]['delete_tire']=='yes')
			{
				
			
				// Get Variable Post
				$id_tire_delete = $_POST['id_tire_delete_all'];
				
		
					//Update Product
					$res = $this->db->query("DELETE FROM master_tire WHERE id_tire in (".$id_tire_delete.") ");
					if($res>=1)
					{
						$this->session->set_flashdata('message_success',"Data Tire has been successfully deleted!");
						redirect('tire_management');
						
						}
					else
					{
						$this->session->set_flashdata('message_failed',"Data Tire failed to delete!");
						redirect('tire_management');
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
	
	public function editTire($id_channel)
	{
		
			date_default_timezone_set('Asia/Jakarta');
			ini_set('memory_limit', '-1');
			
			if ($this->tank_auth->is_logged_in()) {
			$user	= $this->tank_auth->get_username();
			$data_account = $this->model_account_master->getAccount("WHERE username = '".$user."' ")->result_array();
			$data_role = $this->model_account_master->getRole("WHERE id_role = '".$data_account[0]['user_access']."' ")->result_array();
			$user_role = $data_account[0]['user_type'];
			$code_role = $data_account[0]['code'];
			
			if($data_role[0]['edit_tire']=='yes')
			{
				
			
				// Get Variable Post
				$id_tire = $_POST['id_tire_update'];
					// Get Variable Post
				$username = $user;
				$timestamp = date('Y:m:d H:i:s');
				$product_code = $_POST['edit_product_code'];
				$serial_number = $_POST['edit_serial_number'];
				$description = $_POST['edit_description'];
				$current_odo_meter = $_POST['edit_current_odo_meter'];
				$installed_status = $_POST['edit_installed_status'];
				$condition_off_tire = $_POST['edit_condition_off_tire'];
				$unit_type = $_POST['edit_unit_type'];
				$warehouse_id = $_POST['edit_warehouse_id'];
				$location = $_POST['edit_location'];
				$status_recycle = $_POST['edit_status_recycle'];
				$vehicle_id = $_POST['edit_vehicle_id'];
				$chasis_id = $_POST['edit_chasis_id'];
				
				
				if($installed_status=='installed')
				{
					$warehouse_id = '';
					$location = '';
					$status_recycle = '';
				}
				else if($installed_status=='not_installed')
				{
					$unit_type = '';
					$vehicle_id = '';
					$chasis_id = '';
				}
				
				$data_update = array(
				
				"product_code" => $product_code,
				"serial_number" => $serial_number,
				"unit_type" => $unit_type,
				"installed_status" => $installed_status,
				"condition_off_tire" => $condition_off_tire,
				"vehicle_id" => $vehicle_id,
				"chasis_id" => $chasis_id,
				"current_odo_meter" => $current_odo_meter,
				"description" => $description,
				"warehouse_id" => $warehouse_id,
				"location_code" => $location,
				"updated_by" => $username,
				"updated_date" => $timestamp

				);
				
				$where = array("id_tire"=>$id_tire);
				
				//Check Product Apakah sudah ada dengan kode produk dan type motorist yang sama
				$check = $this->model_tire_management->getTire("WHERE product_code = '".$product_code."' AND serial_number = '".$serial_number."' AND id_tire != '".$id_tire."' ");
				
				
				if($check->num_rows() >=1 )
				{
					$this->session->set_flashdata('message_failed',"Sorry data already exist!");
					redirect('tire_management');
					
					}
				else
				{
				
					//Update
					$res = $this->model_tire_management->UpdateData("master_tire",$data_update,$where);
					
					if($res>=1)
					{
						$this->session->set_flashdata('message_success',"Data Tire has been successfully updated!");
						
						redirect('tire_management');
						
						}
					else
					{
						$this->session->set_flashdata('message_failed',"Data Tire failed to update!");
						redirect('tire_management');
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
	
	
	public function deleteDriver()
	{
		
			date_default_timezone_set('Asia/Jakarta');
			ini_set('memory_limit', '-1');
			
			if ($this->tank_auth->is_logged_in()) {
			$user	= $this->tank_auth->get_username();
			$data_account = $this->model_account_master->getAccount("WHERE username = '".$user."' ")->result_array();
			$data_role = $this->model_account_master->getRole("WHERE id_role = '".$data_account[0]['user_access']."' ")->result_array();
			$user_role = $data_account[0]['user_type'];
			$code_role = $data_account[0]['code'];
			if($data_role[0]['delete_driver']=='yes')
			{
				
			
				// Get Variable Post
				$id_driver_delete = $_POST['id_driver_delete'];
				$where = array("id_driver" => $id_driver_delete);
				
		
					//Update Product
					$res = $this->model_tire_management->DeleteData("driver",$where);
					if($res>=1)
					{
						$this->session->set_flashdata('message_success',"Data driver has been successfully deleted!");
						redirect('driver');
						
						}
					else
					{
						$this->session->set_flashdata('message_failed',"Data Driver failed to delete!");
						redirect('driver');
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
	
	public function exportTire()
	{
		
		date_default_timezone_set('Asia/Jakarta');
		if ($this->tank_auth->is_logged_in()) {
		$user	= $this->tank_auth->get_username();
		$data_account = $this->model_account_master->getAccount("WHERE username = '".$user."' ")->result_array();
		$data_role = $this->model_account_master->getRole("WHERE id_role = '".$data_account[0]['user_access']."' ")->result_array();
		$user_role = $data_account[0]['user_type'];
		$code_role = $data_account[0]['code'];
		
		if($data_role[0]['export_tire']=='yes')
		{
		$search = isset($_GET['search']) ? $_GET['search'] : '';

		
		$date = date("m-d-Y");
		$this->db->or_like('serial_number', $search);
		$query = $this->db->get('master_tire');
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
		
		
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 1, "Master Tire");
		//Merge And Center Title
		$objPHPExcel->getActiveSheet()->mergeCells('A1:D1');
		
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 2, "Date : ".$date);
		
		//Merge And Center Date
		$objPHPExcel->getActiveSheet()->mergeCells('A2:D2');
		
		//Set Font Color Title
		$objPHPExcel->getActiveSheet()->getStyle('A1:D2')->applyFromArray($FontstyleTitle);
		
		//Set Font Color Header
		$objPHPExcel->getActiveSheet()->getStyle('A4:L4')->applyFromArray($Fontstyle);
		
		//Set Backgroung Color Header
		$objPHPExcel->getActiveSheet()->getStyle('A4:L4')->applyFromArray(
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
		"Product Code" => "Product Code",
		"Serial Number" => "Serial Number",
		"Description" => "Description",
		"Unit Type" => "Unit Type",
		"Condition Off Tire" => "Condition Off Tire",
		"Installed Status" => "Installed Status",
		"Vehicle ID" => "Vehicle ID",
		"Chasis ID" => "Chasis ID",
		"Warehouse ID" => "Warehouse ID",
		"Location" => "Location",
		"Recycle Status" => "Recycle Status",
		
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
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $row, $data['product_code']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $row, $data['serial_number']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $row, $data['description']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $row, $data['unit_type']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, $row, $data['condition_off_tire']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, $row, $data['installed_status']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, $row, $data['vehicle_id']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8, $row, $data['chasis_id']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9, $row, $data['warehouse_id']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(10, $row, $data['location_code']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(11, $row, $data['recycle_status']);
 
            $row++;
			$no++;
        }
		
	   $last_row = $row-1;
	   //Set Border
       $objPHPExcel->getActiveSheet()->getStyle("A4".":"."L".$last_row)->applyFromArray($BStyle);
	   $objPHPExcel->getActiveSheet()->getStyle("A4".":"."L".$last_row)->applyFromArray($styleAlign);
       $objPHPExcel->setActiveSheetIndex(0);
 
        $objWriter = IOFactory::createWriter($objPHPExcel, 'Excel5');
 		
		
	   // Sending headers to force the user to download the file
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Master-tire-'.$date.'.xls"');
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
					$check = $this->model_tire_management->getDriver("WHERE driver_code  = '".$rowData[0][0]."' ");
					if($check->num_rows() >=1 )
					{
						
						$data_update = array(
							"driver_name" => $rowData[0][1],
							"password" => md5($rowData[0][2])
							
						);
						$where = array(
							"driver_code" => $rowData[0][0]
						);
						
						$res = $this->model_tire_management->UpdateData("driver",$data_update,$where);
					
						}
					else
					{
						$data_insert = array(
							"driver_code" => $rowData[0][0],
							"driver_name" => $rowData[0][1],
							"password" => md5($rowData[0][2])
						);
						
						//Insert Data
						$res = $this->model_tire_management->insertData("driver",$data_insert);
					
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
	
	public function addTire()
	{
		
			date_default_timezone_set('Asia/Jakarta');
			ini_set('memory_limit', '-1');
			
			if ($this->tank_auth->is_logged_in()) {
			$user	= $this->tank_auth->get_username();
			$data_account = $this->model_account_master->getAccount("WHERE username = '".$user."' ")->result_array();
			$data_role = $this->model_account_master->getRole("WHERE id_role = '".$data_account[0]['user_access']."' ")->result_array();
			$user_role = $data_account[0]['user_type'];
			$code_role = $data_account[0]['code'];
			
			if($data_role[0]['add_driver']=='yes')
			{
				
			
				// Get Variable Post
				$username = $user;
				$timestamp = date('Y:m:d H:i:s');
				$product_code = $_POST['product_code'];
				$serial_number = $_POST['serial_number'];
				$description = $_POST['description'];
				$current_odo_meter = $_POST['current_odo_meter'];
				$installed_status = $_POST['installed_status'];
				$condition_off_tire = $_POST['condition_off_tire'];
				$unit_type = $_POST['unit_type'];
				$warehouse_id = $_POST['warehouse_id'];
				$location = $_POST['location'];
				$status_recycle = $_POST['status_recycle'];
				$vehicle_id = $_POST['vehicle_id'];
				$chasis_id = $_POST['chasis_id'];
				
				
				if($installed_status=='installed')
				{
					$warehouse_id = '';
					$location = '';
					$status_recycle = '';
				}
				else if($installed_status=='not_installed')
				{
					$unit_type = '';
					$vehicle_id = '';
					$chasis_id = '';
				}
				
				
				$data_insert = array(
				"product_code" => $product_code,
				"serial_number" => $serial_number,
				"unit_type" => $unit_type,
				"installed_status" => $installed_status,
				"condition_off_tire" => $condition_off_tire,
				"vehicle_id" => $vehicle_id,
				"chasis_id" => $chasis_id,
				"current_odo_meter" => $current_odo_meter,
				"description" => $description,
				"warehouse_id" => $warehouse_id,
				"location_code" => $location,
				"recycle_status" => $recycle_status,
				"created_by" => $username,
				"created_date" => $timestamp

				);
				
				//Check Product Apakah sudah ada dengan kode produk dan type motorist yang sama
				$check = $this->model_tire_management->getTire("WHERE serial_number = '".$serial_number."' AND product_code = '".$product_code."' ");
				if($check->num_rows() >=1 )
				{
					$this->session->set_flashdata('message_failed',"Sorry data already exist!");
					redirect('tire_management');
					
					}
				else
				{
					
					$res = $this->model_tire_management->insertData("master_tire",$data_insert);
					if($res>=1)
					{
						$this->session->set_flashdata('message_success',"Data Tire Management has been successfully saved!");
						redirect('tire_management');
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
			
			if($data_role[0]['see_driver']=='yes')
			{	
			$this->load->library('table');
			$this->load->library('pagination');
			$search = isset($_GET['search']) ? $_GET['search'] : '';
			
			
			$jumlah= $this->model_tire_management->countTire($search);
			
			if (count($_GET) > 0) $config['suffix'] = '?' . http_build_query($_GET, '', "&");
			$config['base_url'] = base_url().'index.php/tire_management/tire_management/';
			$config['total_rows'] = $jumlah;
			$config['first_link'] = 'First';
			$config['last_link'] = 'End';
			$config['next_link'] = 'Next';
			$config['prev_link'] = 'Previous';
			$config['per_page'] = 5; 	
			if (count($_GET) > 0) $config['suffix'] = '?' . http_build_query($_GET, '', "&");
			$config['first_url'] = $config['base_url'].'?'.http_build_query($_GET);
			
			$dari = $this->uri->segment('3');
			$data = $this->model_tire_management->dataTire($config['per_page'],$dari,$search);
			
		
			$comp = array(
				'title' => ' Tire',
				'content' => $this->load->view('tire_management',array('data_tire'=>$data,'data_role'=>$data_role,'search'=>$search),true),
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