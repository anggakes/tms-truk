<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Truck_accident extends CI_Controller {

	function __construct()  {
 		parent::__construct();
			$this->load->library(array('PHPExcel','PHPExcel/IOFactory'));
			$this->load->model('model_account_master');
			$this->load->model('model_truck_accident');
			$this->load->library('tank_auth');
			
	}
	
	
	public function deleteTruckAccidentAll()
	{
		
			date_default_timezone_set('Asia/Jakarta');
			ini_set('memory_limit', '-1');
			
			if ($this->tank_auth->is_logged_in()) {
			$user	= $this->tank_auth->get_username();
			$data_account = $this->model_account_master->getAccount("WHERE username = '".$user."' ")->result_array();
			$data_role = $this->model_account_master->getRole("WHERE id_role = '".$data_account[0]['user_access']."' ")->result_array();
			$user_role = $data_account[0]['user_type'];
			$code_role = $data_account[0]['code'];
			if($data_role[0]['delete_truck_accident']=='yes')
			{
				
			
				// Get Variable Post
				$id_truck_accident_delete = $_POST['id_truck_accident_delete_all'];
				
		
					//Update Product
					$res = $this->db->query("DELETE FROM truck_accident WHERE id_truck_accident in (".$id_truck_accident_delete.") ");
					if($res>=1)
					{
						$this->session->set_flashdata('message_success',"Data Truck Accident has been successfully deleted!");
						redirect('truck_accident');
						
						}
					else
					{
						$this->session->set_flashdata('message_failed',"Data Truck Accident failed to delete!");
						redirect('truck_accident');
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
	
	public function editTruckAccident()
	{
		
			date_default_timezone_set('Asia/Jakarta');
			ini_set('memory_limit', '-1');
			
			if ($this->tank_auth->is_logged_in()) {
			$user	= $this->tank_auth->get_username();
			$data_account = $this->model_account_master->getAccount("WHERE username = '".$user."' ")->result_array();
			$data_role = $this->model_account_master->getRole("WHERE id_role = '".$data_account[0]['user_access']."' ")->result_array();
			$user_role = $data_account[0]['user_type'];
			$code_role = $data_account[0]['code'];
			
			if($data_role[0]['edit_truck_accident']=='yes')
			{
				
			
				// Get Variable Post
				$timestamp = date('Y:m:d H:i:s');
				$username = $user;
				$accident_date = explode('-',$_POST['edit_accident_date']);
				$accident_date = $accident_date[2].'-'.$accident_date[1].'-'.$accident_date[0];
				$vehicle_id = $_POST['edit_vehicle_id'];
				$driver_name = $_POST['edit_driver_name'];
				$driver_code = $_POST['edit_driver_code'];
				$client_id = $_POST['edit_client_id'];
				$client_name = $_POST['edit_client_name'];
				$accident_type = $_POST['edit_accident_type'];
				$location = $_POST['edit_location'];
				$chronology_accident = $_POST['edit_chronology_accident'];
				$vehicle_condition = $_POST['edit_vehicle_condition'];
				$vehicle_position = $_POST['edit_vehicle_position'];
				$amount_less = $_POST['edit_amount_less'];
				$bap_police = $_POST['edit_bap_police'];
				$id_truck_accident = $_POST['id_truck_accident_update'];
				
			
				$data_update = array(
				
					"accident_date" => $accident_date,
					"vehicle_id" => $vehicle_id,
					"driver_name" => $driver_name,
					"driver_code" => $driver_code,
					"client_id" => $client_id,
					"client_name" => $client_name,
					"accident_type" => $accident_type,
					"location" => $location,
					"chronology_accident" => $chronology_accident,
					"vehicle_condition" => $vehicle_condition,
					"vehicle_position" => $vehicle_position,
					"amount_less" => $amount_less,
					"bap_police" => $bap_police,
					"updated_by" => $username,
					"updated_date" => $timestamp

				);
				
				$where = array("id_truck_accident"=>$id_truck_accident);
				
				//Check Product Apakah sudah ada dengan kode produk dan type motorist yang sama
			
				
					//Update
					$res = $this->model_truck_accident->UpdateData("truck_accident",$data_update,$where);
					
					if($res>=1)
					{
						$this->session->set_flashdata('message_success',"Data Truck Accident has been successfully updated!");
						
						redirect('truck_accident');
						
						}
					else
					{
						$this->session->set_flashdata('message_failed',"Data Truck Accident failed to update!");
						redirect('truck_accident');
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
	
	
	public function deleteTruckAccident()
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
				$id_truck_accident_delete = $_POST['id_truck_accident_delete'];
				$where = array("id_truck_accident" => $id_truck_accident_delete);
				
		
					//Update Product
					$res = $this->model_truck_accident->DeleteData("truck_accident",$where);
					if($res>=1)
					{
						$this->session->set_flashdata('message_success',"Data Truck Accident has been successfully deleted!");
						redirect('truck_accident');
						
						}
					else
					{
						$this->session->set_flashdata('message_failed',"Data Truck Accidentfedit failed to delete!");
						redirect('truck_accident');
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
	
	public function exportTruckAccident()
	{
		
		date_default_timezone_set('Asia/Jakarta');
		if ($this->tank_auth->is_logged_in()) {
		$user	= $this->tank_auth->get_username();
		$data_account = $this->model_account_master->getAccount("WHERE username = '".$user."' ")->result_array();
		$data_role = $this->model_account_master->getRole("WHERE id_role = '".$data_account[0]['user_access']."' ")->result_array();
		$user_role = $data_account[0]['user_type'];
		$code_role = $data_account[0]['code'];
		
		if($data_role[0]['export_driver']=='yes')
		{
		$search = isset($_GET['search']) ? $_GET['search'] : '';

		
		$date = date("m-d-Y");
		$this->db->or_like('vehicle_id', $search);
		$query = $this->db->get('truck_accident');
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
		
		
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 1, "Master Driver");
		//Merge And Center Title
		$objPHPExcel->getActiveSheet()->mergeCells('A1:D1');
		
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 2, "Date : ".$date);
		
		//Merge And Center Date
		$objPHPExcel->getActiveSheet()->mergeCells('A2:D2');
		
		//Set Font Color Title
		$objPHPExcel->getActiveSheet()->getStyle('A1:D2')->applyFromArray($FontstyleTitle);
		
		//Set Font Color Header
		$objPHPExcel->getActiveSheet()->getStyle('A4:N4')->applyFromArray($Fontstyle);
		
		//Set Backgroung Color Header
		$objPHPExcel->getActiveSheet()->getStyle('A4:N4')->applyFromArray(
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
		"Date Accident" => "Date Accident",
		"Vehicle Id" => "Vehicle Id",
		"Client ID" => "Client ID",
		"Client Name" => "Client Name",
		"Driver Name" => "Driver Name",
		"Driver Code" => "Driver Code",
		"Type Accident" => "Type Accident",
		"location" => "location",
		"Chronology Accident" => "Chronology Accident",
		"Condition Vehicle After Accident" => "Condition Vehicle After Accident",
		"Current Vehicle Position" => "Current Vehicle Position",
		"Amount Less" => "Amount Less",
		"Bap Police" => "Bap Police"
		
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
			$accident_date = explode('-',$data['accident_date']);
			$accident_date =$accident_date[2].'-'.$accident_date[1].'-'.$accident_date[0];
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $row, $accident_date);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $row, $data['vehicle_id']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $row, $data['client_id']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $row, $data['client_name']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, $row, $data['driver_name']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, $row, $data['driver_code']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, $row, $data['accident_type']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8, $row, $data['location']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9, $row, $data['chronology_accident']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(10, $row, $data['vehicle_condition']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(11, $row, $data['vehicle_position']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(12, $row, $data['amount_less']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(13, $row, $data['bap_police']);
 
            $row++;
			$no++;
        }
		
	   $last_row = $row-1;
	   //Set Border
       $objPHPExcel->getActiveSheet()->getStyle("A4".":"."N".$last_row)->applyFromArray($BStyle);
	   $objPHPExcel->getActiveSheet()->getStyle("A4".":"."N".$last_row)->applyFromArray($styleAlign);
       $objPHPExcel->setActiveSheetIndex(0);
 
        $objWriter = IOFactory::createWriter($objPHPExcel, 'Excel5');
 		
		
	   // Sending headers to force the user to download the file
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Master-truck_accident-'.$date.'.xls"');
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
					$check = $this->model_truck_accident->getDriver("WHERE driver_code  = '".$rowData[0][0]."' ");
					if($check->num_rows() >=1 )
					{
						
						$data_update = array(
							"driver_name" => $rowData[0][1],
							"password" => md5($rowData[0][2])
							
						);
						$where = array(
							"driver_code" => $rowData[0][0]
						);
						
						$res = $this->model_truck_accident->UpdateData("driver",$data_update,$where);
					
						}
					else
					{
						$data_insert = array(
							"driver_code" => $rowData[0][0],
							"driver_name" => $rowData[0][1],
							"password" => md5($rowData[0][2])
						);
						
						//Insert Data
						$res = $this->model_truck_accident->insertData("driver",$data_insert);
					
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
	
	public function addTruckAccident()
	{
		
			date_default_timezone_set('Asia/Jakarta');
			ini_set('memory_limit', '-1');
			
			if ($this->tank_auth->is_logged_in()) {
			$user	= $this->tank_auth->get_username();
			$data_account = $this->model_account_master->getAccount("WHERE username = '".$user."' ")->result_array();
			$data_role = $this->model_account_master->getRole("WHERE id_role = '".$data_account[0]['user_access']."' ")->result_array();
			$user_role = $data_account[0]['user_type'];
			$code_role = $data_account[0]['code'];
			
			if($data_role[0]['add_truck_accident']=='yes')
			{
				
			
				// Get Variable Post
				$timestamp = date('Y:m:d H:i:s');
				$username = $user;
				$accident_date = explode('-',$_POST['accident_date']);
				$accident_date = $accident_date[2].'-'.$accident_date[1].'-'.$accident_date[0];
				$vehicle_id = $_POST['vehicle_id'];
				$driver_name = $_POST['driver_name'];
				$driver_code = $_POST['driver_code'];
				$client_id = $_POST['client_id'];
				$client_name = $_POST['client_name'];
				$accident_type = $_POST['accident_type'];
				$location = $_POST['location'];
				$chronology_accident = $_POST['chronology_accident'];
				$vehicle_condition = $_POST['vehicle_condition'];
				$vehicle_position = $_POST['vehicle_position'];
				$amount_less = $_POST['amount_less'];
				$bap_police = $_POST['bap_police'];
				
				$data_insert = array(
				"accident_date" => $accident_date,
				"vehicle_id" => $vehicle_id,
				"driver_name" => $driver_name,
				"driver_code" => $driver_code,
				"client_id" => $client_id,
				"client_name" => $client_name,
				"accident_type" => $accident_type,
				"location" => $location,
				"chronology_accident" => $chronology_accident,
				"vehicle_condition" => $vehicle_condition,
				"vehicle_position" => $vehicle_position,
				"amount_less" => $amount_less,
				"bap_police" => $bap_police,
				"created_by" => $username,
				"created_date" => $timestamp
				

				);
				
				//Check Product Apakah sudah ada dengan kode produk dan type motorist yang sama
				
				
					
					$res = $this->model_truck_accident->insertData("truck_accident",$data_insert);
					if($res>=1)
					{
						$this->session->set_flashdata('message_success',"Data Truck Accident has been successfully saved!");
						redirect('truck_accident');
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
			
			if($data_role[0]['see_truck_accident']=='yes')
			{	
			$this->load->library('table');
			$this->load->library('pagination');
			$search = isset($_GET['search']) ? $_GET['search'] : '';
			
			
			$jumlah= $this->model_truck_accident->countTruckAccident($search);
			
			if (count($_GET) > 0) $config['suffix'] = '?' . http_build_query($_GET, '', "&");
			$config['base_url'] = base_url().'index.php/truck_accident/truck_accident/';
			$config['total_rows'] = $jumlah;
			$config['first_link'] = 'First';
			$config['last_link'] = 'End';
			$config['next_link'] = 'Next';
			$config['prev_link'] = 'Previous';
			$config['per_page'] = 5; 	
			if (count($_GET) > 0) $config['suffix'] = '?' . http_build_query($_GET, '', "&");
			$config['first_url'] = $config['base_url'].'?'.http_build_query($_GET);
			
			$dari = $this->uri->segment('3');
			$data = $this->model_truck_accident->dataTruckAccident($config['per_page'],$dari,$search);
			$data_category_accident = $this->db->query("SELECT * FROM master_data_category WHERE category = 'Accident Type' ")->result();
			
		
			$comp = array(
				'title' => ' Truck Accident',
				'content' => $this->load->view('truck_accident',array('data_category_accident'=>$data_category_accident,'data_truck_accident'=>$data,'data_role'=>$data_role,'search'=>$search),true),
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