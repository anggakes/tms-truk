<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Trucking_order extends CI_Controller {

	function __construct()  {
 		parent::__construct();
			$this->load->library(array('PHPExcel','PHPExcel/IOFactory'));
			$this->load->model('model_account_master');
			$this->load->model('model_trucking_order');
			$this->load->library('tank_auth');
			
	}
	
	
	public function deleteTruckingOrderAll()
	{
		
			date_default_timezone_set('Asia/Jakarta');
			ini_set('memory_limit', '-1');
			
			if ($this->tank_auth->is_logged_in()) {
			$user	= $this->tank_auth->get_username();
			$data_account = $this->model_account_master->getAccount("WHERE username = '".$user."' ")->result_array();
			$data_role = $this->model_account_master->getRole("WHERE id_role = '".$data_account[0]['user_access']."' ")->result_array();
			$user_role = $data_account[0]['user_type'];
			$code_role = $data_account[0]['code'];
			if($data_role[0]['delete_trucking_order']=='yes')
			{
				
			
				// Get Variable Post
				$id_trucking_order_delete = $_POST['id_trucking_order_delete_all'];
				
		
					//Update Product
					$res = $this->db->query("DELETE FROM master_trucking_order WHERE id_trucking_order in (".$id_trucking_order_delete.") ");
					if($res>=1)
					{
						$this->session->set_flashdata('message_success',"Data trucking_order has been successfully deleted!");
						redirect('trucking_order');
						
						}
					else
					{
						$this->session->set_flashdata('message_failed',"Data TruckingOrder failed to delete!");
						redirect('trucking_order');
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
	
	public function editTruckingOrder()
	{
		
			date_default_timezone_set('Asia/Jakarta');
			ini_set('memory_limit', '-1');
			
			if ($this->tank_auth->is_logged_in()) {
			$user	= $this->tank_auth->get_username();
			$data_account = $this->model_account_master->getAccount("WHERE username = '".$user."' ")->result_array();
			$data_role = $this->model_account_master->getRole("WHERE id_role = '".$data_account[0]['user_access']."' ")->result_array();
			$user_role = $data_account[0]['user_type'];
			$code_role = $data_account[0]['code'];
			
			if($data_role[0]['edit_trucking_order']=='yes')
			{
				
			
				// Get Variable Post
				$timestamp = date('Y:m:d H:i:s');
				$username = $user;
				$id_trucking_order = $_POST['id_update_trucking_order'];
				$client_id = $_POST['edit_client_id'];
				$client_name = $_POST['edit_client_name'];
				$schedule_date = explode('-',$_POST['edit_schedule_date']);
				$schedule_date = $schedule_date[2].'-'.$schedule_date[1].'-'.$schedule_date[0];
				$trip = $_POST['edit_trip'];
				$origin_id = $_POST['edit_origin_id'];
				$origin_address = $_POST['edit_origin_address'];
				$origin_area = $_POST['edit_origin_area'];
				$destination_id = $_POST['edit_destination_id'];
				$destination_address = $_POST['edit_destination_address'];
				$destination_area = $_POST['edit_destination_area'];
				$pickup_date = explode('-',$_POST['edit_pickup_date']);
				$pickup_date = $pickup_date[2].'-'.$pickup_date[1].'-'.$pickup_date[0];
				$pickup_time = $_POST['edit_pickup_time'];
				$arrival_date = explode('-',$_POST['edit_arrival_date']);
				$arrival_date = $arrival_date[2].'-'.$arrival_date[1].'-'.$arrival_date[0];
				$arrival_time = $_POST['edit_arrival_time'];
				
				
				$data_update = array(
				
					"schedule_date" => $schedule_date,
					"trip" => $trip,
					"client_id" => $client_id,
					"client_name" => $client_name,
					"origin" => $origin_id,
					"origin_address" => $origin_address,
					"origin_area" => $origin_area,
					"origin_pickup_date" => $pickup_date,
					"origin_pickup_time" => $pickup_time,
					"destination" => $destination_id,
					"destination_address" => $destination_address,
					"destination_area" => $destination_area,
					"destination_arrival_date" => $arrival_date,
					"destination_arrival_time" => $arrival_time,
					"updated_by" => $user,
					"updated_date" => $timestamp

				);
				
				$where = array("id_trucking_order"=>$id_trucking_order);
				
				
				
					$res = $this->model_trucking_order->UpdateData("master_trucking_order",$data_update,$where);
					
					if($res>=1)
					{
						$this->session->set_flashdata('message_success',"Data Trucking Order has been successfully updated!");
						redirect('trucking_order');
						
						}
					else
					{
						$this->session->set_flashdata('message_failed',"Data Trucking Order failed to update!");
						redirect('trucking_order');
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
	
	
	public function deleteTruckingOrder()
	{
		
			date_default_timezone_set('Asia/Jakarta');
			ini_set('memory_limit', '-1');
			
			if ($this->tank_auth->is_logged_in()) {
			$user	= $this->tank_auth->get_username();
			$data_account = $this->model_account_master->getAccount("WHERE username = '".$user."' ")->result_array();
			$data_role = $this->model_account_master->getRole("WHERE id_role = '".$data_account[0]['user_access']."' ")->result_array();
			$user_role = $data_account[0]['user_type'];
			$code_role = $data_account[0]['code'];
			if($data_role[0]['delete_trucking_order']=='yes')
			{
				
			
				// Get Variable Post
				$id_trucking_order_delete = $_POST['id_trucking_order_delete'];
				$where = array("id_trucking_order" => $id_trucking_order_delete);
				
		
					//Update Product
					$res = $this->model_trucking_order->DeleteData("master_trucking_order",$where);
					if($res>=1)
					{
						$where = array("id_trucking_order" => $id_trucking_order_delete);
						$res = $this->model_trucking_order->DeleteData("detail_trucking_order",$where);
						$this->session->set_flashdata('message_success',"Data trucking_order has been successfully deleted!");
						redirect('trucking_order');
						
						}
					else
					{
						$this->session->set_flashdata('message_failed',"Data TruckingOrder failed to delete!");
						redirect('trucking_order');
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
	
	public function exportTruckingOrder()
	{
		
		date_default_timezone_set('Asia/Jakarta');
		if ($this->tank_auth->is_logged_in()) {
		$user	= $this->tank_auth->get_username();
		$data_account = $this->model_account_master->getAccount("WHERE username = '".$user."' ")->result_array();
		$data_role = $this->model_account_master->getRole("WHERE id_role = '".$data_account[0]['user_access']."' ")->result_array();
		$user_role = $data_account[0]['user_type'];
		$code_role = $data_account[0]['code'];
		
		if($data_role[0]['export_trucking_order']=='yes')
		{
		$search = isset($_GET['search']) ? $_GET['search'] : '';

		
		$date = date("m-d-Y");
		$this->db->or_like('trucking_order_code', $search);
		$query = $this->db->get('trucking_order');
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
		
		
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 1, "Master TruckingOrder");
		//Merge And Center Title
		$objPHPExcel->getActiveSheet()->mergeCells('A1:D1');
		
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 2, "Date : ".$date);
		
		//Merge And Center Date
		$objPHPExcel->getActiveSheet()->mergeCells('A2:D2');
		
		//Set Font Color Title
		$objPHPExcel->getActiveSheet()->getStyle('A1:D2')->applyFromArray($FontstyleTitle);
		
		//Set Font Color Header
		$objPHPExcel->getActiveSheet()->getStyle('A4:C4')->applyFromArray($Fontstyle);
		
		//Set Backgroung Color Header
		$objPHPExcel->getActiveSheet()->getStyle('A4:C4')->applyFromArray(
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
		"TruckingOrder Code" => "TruckingOrder Code",
		"TruckingOrder Name" => "TruckingOrder Name"
		
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
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $row, $data['trucking_order_code']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $row, $data['trucking_order_name']);
 
            $row++;
			$no++;
        }
		
	   $last_row = $row-1;
	   //Set Border
       $objPHPExcel->getActiveSheet()->getStyle("A4".":"."C".$last_row)->applyFromArray($BStyle);
	   $objPHPExcel->getActiveSheet()->getStyle("A4".":"."C".$last_row)->applyFromArray($styleAlign);
       $objPHPExcel->setActiveSheetIndex(0);
 
        $objWriter = IOFactory::createWriter($objPHPExcel, 'Excel5');
 		
		
	   // Sending headers to force the user to download the file
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Master-trucking_order-'.$date.'.xls"');
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
	
	public function importTruckingOrder()
	{
		
			date_default_timezone_set('Asia/Jakarta');
			ini_set('memory_limit', '-1');
			
			if ($this->tank_auth->is_logged_in()) {
			$user	= $this->tank_auth->get_username();
			$data_account = $this->model_account_master->getAccount("WHERE username = '".$user."' ")->result_array();
			$data_role = $this->model_account_master->getRole("WHERE id_role = '".$data_account[0]['user_access']."' ")->result_array();
			$user_role = $data_account[0]['user_type'];
			$code_role = $data_account[0]['code'];
			
			if($data_role[0]['import_trucking_order']=='yes')
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
				redirect('trucking_order');
				
				
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
					$check = $this->model_trucking_order->getTruckingOrder("WHERE trucking_order_code  = '".$rowData[0][0]."' ");
					if($check->num_rows() >=1 )
					{
						
						$data_update = array(
							"trucking_order_name" => $rowData[0][1],
							"password" => md5($rowData[0][2])
							
						);
						$where = array(
							"trucking_order_code" => $rowData[0][0]
						);
						
						$res = $this->model_trucking_order->UpdateData("trucking_order",$data_update,$where);
					
						}
					else
					{
						$data_insert = array(
							"trucking_order_code" => $rowData[0][0],
							"trucking_order_name" => $rowData[0][1],
							"password" => md5($rowData[0][2])
						);
						
						//Insert Data
						$res = $this->model_trucking_order->insertData("trucking_order",$data_insert);
					
					}
					
				
				
			}
				@unlink($inputFileName);
				$this->session->set_flashdata('message_success','Data imported successfully');
				redirect('trucking_order');
			
               
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
	
	public function addTruckingOrder()
	{
		
			date_default_timezone_set('Asia/Jakarta');
			ini_set('memory_limit', '-1');
			
			if ($this->tank_auth->is_logged_in()) {
			$user	= $this->tank_auth->get_username();
			$data_account = $this->model_account_master->getAccount("WHERE username = '".$user."' ")->result_array();
			$data_role = $this->model_account_master->getRole("WHERE id_role = '".$data_account[0]['user_access']."' ")->result_array();
			$user_role = $data_account[0]['user_type'];
			$code_role = $data_account[0]['code'];
			
			if($data_role[0]['add_trucking_order']=='yes')
			{
				
			
				// Get Variable Post
				$timestamp = date('Y:m:d H:i:s');
				$username = $user;
				$client_id = $_POST['client_id'];
				$client_name = $_POST['client_name'];
				$schedule_date = explode('-',$_POST['schedule_date']);
				$schedule_date = $schedule_date[2].'-'.$schedule_date[1].'-'.$schedule_date[0];
				$trip = $_POST['trip'];
				$origin_id = $_POST['origin_id'];
				$origin_address = $_POST['origin_address'];
				$origin_address_2 = $_POST['origin_address_2'];
				$origin_area = $_POST['origin_area'];
				$origin_pic = $_POST['origin_pic'];
				$origin_email = $_POST['origin_email'];
				$destination_id = $_POST['destination_id'];
				$destination_address = $_POST['destination_address'];
				$destination_address_2 = $_POST['destination_address_2'];
				$destination_area = $_POST['destination_area'];
				$destination_pic = $_POST['destination_pic'];
				$destination_email = $_POST['destination_email'];
				
				$pickup_date = explode('-',$_POST['pickup_date']);
				$pickup_date = $pickup_date[2].'-'.$pickup_date[1].'-'.$pickup_date[0];
				$pickup_time = $_POST['pickup_time'];
				$arrival_date = explode('-',$_POST['arrival_date']);
				$arrival_date = $arrival_date[2].'-'.$arrival_date[1].'-'.$arrival_date[0];
				$arrival_time = $_POST['arrival_time'];
				
				
				//Truck Number
				$count_vehicle = $_POST['count_vehicle'];
				
				$data_insert = array(
					"schedule_date" => $schedule_date,
					"trip" => $trip,
					"client_id" => $client_id,
					"client_name" => $client_name,
					"origin" => $origin_id,
					"origin_address" => $origin_address,
					"origin_area" => $origin_area,
					"origin_pickup_date" => $pickup_date,
					"origin_pickup_time" => $pickup_time,
					"destination" => $destination_id,
					"destination_address" => $destination_address,
					"destination_area" => $destination_area,
					"destination_arrival_date" => $arrival_date,
					"destination_arrival_time" => $arrival_time,
					
					"created_by" => $user,
					"created_date" => $timestamp
				);
				
				
				
				//Check Product Apakah sudah ada dengan kode produk dan type motorist yang sama
				
					
					$res = $this->model_trucking_order->insertData("master_trucking_order",$data_insert);
					if($res>=1)
					{
						//Select last Trucking Order
						$data_last_trucking_order = $this->db->query("SELECT * FROM master_trucking_order WHERE client_id = '".$client_id."' AND origin = '".$origin_id."' AND destination = '".$destination_id."' ORDER BY id_trucking_order DESC ")->result_array();
						
						foreach($count_vehicle as $key => $count_vehicles) {
							
							 $truck_number = $_POST['truck_number_'.$count_vehicles];
							 $vehicle_type = $_POST['vehicle_type_'.$count_vehicles];
							 $vehicle_type_description = $_POST['vehicle_type_description_'.$count_vehicles];
							 $vehicle_type_id = $_POST['vehicle_type_id_'.$count_vehicles];
							
							for ($i = 1; $i <= $truck_number; $i++) {
								
								$data_insert = array(
									"id_trucking_order" => $data_last_trucking_order[0]['id_trucking_order'],
									"vehicle_type" => $vehicle_type,
									"vehicle_type_description" => $vehicle_type_description,
									"id_vehicle_type" => $vehicle_type_id,
									"schedule_date" => $schedule_date,
									"trip" => $trip,
									"client_id" => $client_id,
									"client_name" => $client_name,
									"origin" => $origin_id,
									"origin_address" => $origin_address,
									"origin_area" => $origin_area,
									"origin_pickup_date" => $pickup_date,
									"origin_pickup_time" => $pickup_time,
									"destination" => $destination_id,
									"destination_address" => $destination_address,
									"destination_area" => $destination_area,
									"destination_arrival_date" => $arrival_date,
									"destination_arrival_time" => $arrival_time,
									"status_transport_order" => 'no',
									"created_by" => $user,
									"created_date" => $timestamp
								);
								
								$res = $this->model_trucking_order->insertData("detail_trucking_order",$data_insert);
							}
							
							
						}
						
						
						$this->session->set_flashdata('message_success',"Data Trcuking Order has been successfully saved!");
						redirect('trucking_order');
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
			
			if($data_role[0]['see_trucking_order']=='yes')
			{	
			$this->load->library('table');
			$this->load->library('pagination');
			$search = isset($_GET['search']) ? $_GET['search'] : '';
			
			
			$jumlah= $this->model_trucking_order->countTruckingOrder($search);
			
			if (count($_GET) > 0) $config['suffix'] = '?' . http_build_query($_GET, '', "&");
			$config['base_url'] = base_url().'index.php/trucking_order/trucking_order/';
			$config['total_rows'] = $jumlah;
			$config['first_link'] = 'First';
			$config['last_link'] = 'End';
			$config['next_link'] = 'Next';
			$config['prev_link'] = 'Previous';
			$config['per_page'] = 5; 	
			if (count($_GET) > 0) $config['suffix'] = '?' . http_build_query($_GET, '', "&");
			$config['first_url'] = $config['base_url'].'?'.http_build_query($_GET);
			
			$dari = $this->uri->segment('3');
			$data = $this->model_trucking_order->dataTruckingOrder($config['per_page'],$dari,$search);
			$this->pagination->initialize($config);
		
			$comp = array(
				'title' => ' TruckingOrder',
				'content' => $this->load->view('trucking_order',array('data_trucking_order'=>$data,'data_role'=>$data_role,'search'=>$search),true),
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