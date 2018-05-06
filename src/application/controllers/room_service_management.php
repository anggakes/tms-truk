<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Room_service_management extends CI_Controller {

	function __construct()  {
 		parent::__construct();
			$this->load->library(array('PHPExcel','PHPExcel/IOFactory'));
			$this->load->model('model_account_master');
			$this->load->model('model_room_service_management');
			$this->load->library('tank_auth');
			
	}
	
	
	public function warningService()
	{
		
			date_default_timezone_set('Asia/Jakarta');
			if ($this->tank_auth->is_logged_in()) {
			$user	= $this->tank_auth->get_username();
			$data_account = $this->model_account_master->getAccount("WHERE username = '".$user."' ")->result_array();
			$data_role = $this->model_account_master->getRole("WHERE id_role = '".$data_account[0]['user_access']."' ")->result_array();
			$user_role = $data_account[0]['user_type'];
			$code_role = $data_account[0]['code'];
			
			if($data_role[0]['see_room_service_management']=='yes')
			{	
			$this->load->library('table');
			$this->load->library('pagination');
			$search = isset($_GET['search']) ? $_GET['search'] : '';
			
			
			$jumlah= $this->model_room_service_management->countRoomServiceWarning($search);
			
			if (count($_GET) > 0) $config['suffix'] = '?' . http_build_query($_GET, '', "&");
			$config['base_url'] = base_url().'index.php/room_service_management/warningService/';
			$config['total_rows'] = $jumlah;
			$config['first_link'] = 'First';
			$config['last_link'] = 'End';
			$config['next_link'] = 'Next';
			$config['prev_link'] = 'Previous';
			$config['per_page'] = 20; 	
			if (count($_GET) > 0) $config['suffix'] = '?' . http_build_query($_GET, '', "&");
			$config['first_url'] = $config['base_url'].'?'.http_build_query($_GET);
			
			$dari = $this->uri->segment('3');
			$data = $this->model_room_service_management->dataRoomServiceWarning($config['per_page'],$dari,$search);
			$this->pagination->initialize($config);
		
			$comp = array(
				'title' => ' Room Service Management',
				'content' => $this->load->view('room_service_warning',array('data_room_service_management'=>$data,'data_role'=>$data_role,'search'=>$search),true),
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
	
	public function updateRoomServiceStatus()
	{
		
			date_default_timezone_set('Asia/Jakarta');
			ini_set('memory_limit', '-1');
			
			if ($this->tank_auth->is_logged_in()) {
			$user	= $this->tank_auth->get_username();
			$data_account = $this->model_account_master->getAccount("WHERE username = '".$user."' ")->result_array();
			$data_role = $this->model_account_master->getRole("WHERE id_role = '".$data_account[0]['user_access']."' ")->result_array();
			$user_role = $data_account[0]['user_type'];
			$code_role = $data_account[0]['code'];
			if($data_role[0]['delete_room_service_management']=='yes')
			{
				
			
				// Get Variable Post
				$service_status = $_POST['service_status'];
				$id_room_service_management_update = $_POST['id_room_service_management_update'];;
				
				$data_update = array(
					
					"service_status" => $service_status

				);
				
				$where = array(
					
					"id_room_service_management" => $id_room_service_management_update

				);
		
					//Update Room Service
					$res = $this->model_room_service_management->updateData("room_service_management",$data_update,$where);
					if($res>=1)
					{
						$this->session->set_flashdata('message_success',"Data Room Service Management has been successfully deleted!");
						redirect('room_service_management/roomServiceStatus');
						
						}
					else
					{
						$this->session->set_flashdata('message_failed',"Data Room Service Management failed to delete!");
						redirect('room_service_management/roomServiceStatus');
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
	
	
	public function roomServiceQueu()
	{
		
			date_default_timezone_set('Asia/Jakarta');
			if ($this->tank_auth->is_logged_in()) {
			$user	= $this->tank_auth->get_username();
			$data_account = $this->model_account_master->getAccount("WHERE username = '".$user."' ")->result_array();
			$data_role = $this->model_account_master->getRole("WHERE id_role = '".$data_account[0]['user_access']."' ")->result_array();
			$user_role = $data_account[0]['user_type'];
			$code_role = $data_account[0]['code'];
			
			if($data_role[0]['see_room_service_management']=='yes')
			{	
			$this->load->library('table');
			$this->load->library('pagination');
			$search = isset($_GET['search']) ? $_GET['search'] : '';
			
			
			$jumlah= $this->model_room_service_management->countRoomServiceManagementQueu($search);
			
			if (count($_GET) > 0) $config['suffix'] = '?' . http_build_query($_GET, '', "&");
			$config['base_url'] = base_url().'index.php/driver/driver/';
			$config['total_rows'] = $jumlah;
			$config['first_link'] = 'First';
			$config['last_link'] = 'End';
			$config['next_link'] = 'Next';
			$config['prev_link'] = 'Previous';
			$config['per_page'] = 20; 	
			if (count($_GET) > 0) $config['suffix'] = '?' . http_build_query($_GET, '', "&");
			$config['first_url'] = $config['base_url'].'?'.http_build_query($_GET);
			
			$dari = $this->uri->segment('3');
			$data = $this->model_room_service_management->dataRoomServiceManagementQueu($config['per_page'],$dari,$search);
			$this->pagination->initialize($config);
		
			$comp = array(
				'title' => ' Room Service Management',
				'content' => $this->load->view('room_service_management_queu',array('data_room_service_management'=>$data,'data_role'=>$data_role,'search'=>$search),true),
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
	
	public function roomServiceStatus()
	{
		
			date_default_timezone_set('Asia/Jakarta');
			if ($this->tank_auth->is_logged_in()) {
			$user	= $this->tank_auth->get_username();
			$data_account = $this->model_account_master->getAccount("WHERE username = '".$user."' ")->result_array();
			$data_role = $this->model_account_master->getRole("WHERE id_role = '".$data_account[0]['user_access']."' ")->result_array();
			$user_role = $data_account[0]['user_type'];
			$code_role = $data_account[0]['code'];
			
			if($data_role[0]['see_room_service_management']=='yes')
			{	
		
			$comp = array(
				'title' => ' Room Service Status',
				'content' => $this->load->view('room_service_status',array(),true),
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
	
	
	public function deleteRoomWorkshopAll()
	{
		
			date_default_timezone_set('Asia/Jakarta');
			ini_set('memory_limit', '-1');
			
			if ($this->tank_auth->is_logged_in()) {
			$user	= $this->tank_auth->get_username();
			$data_account = $this->model_account_master->getAccount("WHERE username = '".$user."' ")->result_array();
			$data_role = $this->model_account_master->getRole("WHERE id_role = '".$data_account[0]['user_access']."' ")->result_array();
			$user_role = $data_account[0]['user_type'];
			$code_role = $data_account[0]['code'];
			if($data_role[0]['delete_room_service_management']=='yes')
			{
				
			
				// Get Variable Post
				$id_room_service_management_delete = $_POST['id_room_service_management_delete_all'];
				
		
					//Update Product
					$res = $this->db->query("DELETE FROM room_service_management WHERE id_room_service_management in (".$id_room_service_management_delete.") ");
					if($res>=1)
					{
						$this->session->set_flashdata('message_success',"Data Room Service Management has been successfully deleted!");
						redirect('room_service_management');
						
						}
					else
					{
						$this->session->set_flashdata('message_failed',"Data Room Service Management failed to delete!");
						redirect('room_service_management');
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
	
	public function editRoomServiceManagement($id_channel)
	{
		
			date_default_timezone_set('Asia/Jakarta');
			ini_set('memory_limit', '-1');
			
			if ($this->tank_auth->is_logged_in()) {
			$user	= $this->tank_auth->get_username();
			$data_account = $this->model_account_master->getAccount("WHERE username = '".$user."' ")->result_array();
			$data_role = $this->model_account_master->getRole("WHERE id_role = '".$data_account[0]['user_access']."' ")->result_array();
			$user_role = $data_account[0]['user_type'];
			$code_role = $data_account[0]['code'];
			
			if($data_role[0]['edit_room_service_management']=='yes')
			{
				// Get Variable Post
				$id_update_room_service = $_POST['id_update_room_service'];
				$vehicle_id = $_POST['edit_vehicle_id'];
				$room_service_id = $_POST['edit_room_service_id'];
				$room_service_name = $_POST['edit_room_service_name'];
				$service_type = $_POST['edit_service_type'];
				$service_status = $_POST['edit_service_status'];
				$service_man_power = $_POST['edit_service_man_power'];
				
				$start_service_date = explode('-',$_POST['edit_start_service_date']);
				$start_service_date = $start_service_date[2].'-'.$start_service_date[1].'-'.$start_service_date[0];
				$start_service_time = $_POST['edit_start_service_time'];
				$finished_service_date = explode('-',$_POST['edit_finished_service_date']);
				$finished_service_date = $finished_service_date[2].'-'.$finished_service_date[1].'-'.$finished_service_date[0];
				$finished_service_time = $_POST['edit_finished_service_time'];
				$timestamp = date('Y:m:d H:i:s');
				$username = $user;
				
				
				$self_mecanic = $_POST['edit_self_mecanic'];
				
				$vendor_mecanic = $_POST['edit_vendor_mecanic'];
				$vendor_id = $_POST['edit_vendor_id'];
				$vendor_name = $_POST['edit_vendor_name'];
				
				if($service_man_power=='inhouse_service')
				{
					$mecanic = $self_mecanic;
					$vendor_id = '';
					$vendor_name = '';
				}
				else
				{
					$mecanic = $vendor_mecanic;
					$vendor_id = $vendor_id;
					$vendor_name = $vendor_name;
				}
			
				$service_description =  isset($_POST['service_description']) ? $_POST['service_description'] : '';
				$sparepart =  isset($_POST['sparepart']) ? $_POST['sparepart'] : '';
				$remark =  isset($_POST['remark']) ? $_POST['remark'] : '';
				
				$data_update = array(
					
					"vehicle_id" => $vehicle_id,
					"room_service_id" => $room_service_id,
					"room_service_name" => $room_service_name,
					"service_type" => $service_type,
					"service_status" => $service_status,
					"service_man_power" => $service_man_power,
					"mecanic" => $mecanic,
					"vendor_id" => $vendor_id,
					"vendor_name" => $vendor_name,
					"start_service_date" => $start_service_date,
					"start_service_time" => $start_service_time,
					"finished_service_date" => $finished_service_date,
					"finished_service_time" => $finished_service_time,
					"updated_date" => $timestamp,
					"updated_by" => $username

				);
				
				$where = array(
					
					"id_room_service_management" => $id_update_room_service

				);
				
				//Check Product Apakah sudah ada dengan kode produk dan type motorist yang sama
				
					$res = $this->model_room_service_management->UpdateData("room_service_management",$data_update,$where);
					if($res>=1)
					{
						$delete_data = $this->db->query("DELETE FROM detail_service WHERE id_room_service_management = '".$id_update_room_service."' ");
						foreach($service_description as $key => $service_description) {

							$data_insert = array(	
								"id_room_service_management" => $id_update_room_service,
								"service_description" => $service_description,
								"spare_part" => $sparepart[$key],
								"remark" => $remark[$key],
								"type" => "room_service"
							);
							$res = $this->model_room_service_management->insertData("detail_service",$data_insert);
						}
						
						$this->session->set_flashdata('message_success',"Data Room Service Management has been successfully saved!");
						redirect('room_service_management');
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
	
	
	public function deleteRoomWorkshop()
	{
		
			date_default_timezone_set('Asia/Jakarta');
			ini_set('memory_limit', '-1');
			
			if ($this->tank_auth->is_logged_in()) {
			$user	= $this->tank_auth->get_username();
			$data_account = $this->model_account_master->getAccount("WHERE username = '".$user."' ")->result_array();
			$data_role = $this->model_account_master->getRole("WHERE id_role = '".$data_account[0]['user_access']."' ")->result_array();
			$user_role = $data_account[0]['user_type'];
			$code_role = $data_account[0]['code'];
			if($data_role[0]['delete_room_service_management']=='yes')
			{
				
			
				// Get Variable Post
				$id_room_service_management_delete = $_POST['id_room_service_management_delete'];
				$where = array("id_room_service_management" => $id_room_service_management_delete);
				
		
					//Update Product
					$res = $this->model_room_service_management->DeleteData("room_service_management",$where);
					if($res>=1)
					{
						$this->session->set_flashdata('message_success',"Data Room Service Management has been successfully deleted!");
						redirect('room_service_management');
						
						}
					else
					{
						$this->session->set_flashdata('message_failed',"Data Room Service Management failed to delete!");
						redirect('room_service_management');
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
	
	public function exportRoomServiceManagement()
	{
		
		date_default_timezone_set('Asia/Jakarta');
		if ($this->tank_auth->is_logged_in()) {
		$user	= $this->tank_auth->get_username();
		$data_account = $this->model_account_master->getAccount("WHERE username = '".$user."' ")->result_array();
		$data_role = $this->model_account_master->getRole("WHERE id_role = '".$data_account[0]['user_access']."' ")->result_array();
		$user_role = $data_account[0]['user_type'];
		$code_role = $data_account[0]['code'];
		
		if($data_role[0]['export_room_service_management']=='yes')
		{
		$search = isset($_GET['search']) ? $_GET['search'] : '';

		
		$date = date("m-d-Y");
		$this->db->or_like('driver_code', $search);
		$query = $this->db->get('driver');
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
		
		
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 1, "Master RoomServiceManagement");
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
		"RoomServiceManagement Code" => "RoomServiceManagement Code",
		"RoomServiceManagement Name" => "RoomServiceManagement Name"
		
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
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $row, $data['driver_code']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $row, $data['driver_name']);
 
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
        header('Content-Disposition: attachment;filename="Master-driver-'.$date.'.xls"');
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
	
	public function importRoomServiceManagement()
	{
		
			date_default_timezone_set('Asia/Jakarta');
			ini_set('memory_limit', '-1');
			
			if ($this->tank_auth->is_logged_in()) {
			$user	= $this->tank_auth->get_username();
			$data_account = $this->model_account_master->getAccount("WHERE username = '".$user."' ")->result_array();
			$data_role = $this->model_account_master->getRole("WHERE id_role = '".$data_account[0]['user_access']."' ")->result_array();
			$user_role = $data_account[0]['user_type'];
			$code_role = $data_account[0]['code'];
			
			if($data_role[0]['import_room_service_management']=='yes')
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
					$check = $this->model_room_service_management->getRoomServiceManagement("WHERE driver_code  = '".$rowData[0][0]."' ");
					if($check->num_rows() >=1 )
					{
						
						$data_update = array(
							"driver_name" => $rowData[0][1],
							"password" => md5($rowData[0][2])
							
						);
						$where = array(
							"driver_code" => $rowData[0][0]
						);
						
						$res = $this->model_room_service_management->UpdateData("driver",$data_update,$where);
					
						}
					else
					{
						$data_insert = array(
							"driver_code" => $rowData[0][0],
							"driver_name" => $rowData[0][1],
							"password" => md5($rowData[0][2])
						);
						
						//Insert Data
						$res = $this->model_room_service_management->insertData("driver",$data_insert);
					
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
	
	public function addRoomServiceManagement()
	{
		
			date_default_timezone_set('Asia/Jakarta');
			ini_set('memory_limit', '-1');
			
			if ($this->tank_auth->is_logged_in()) {
			$user	= $this->tank_auth->get_username();
			$data_account = $this->model_account_master->getAccount("WHERE username = '".$user."' ")->result_array();
			$data_role = $this->model_account_master->getRole("WHERE id_role = '".$data_account[0]['user_access']."' ")->result_array();
			$user_role = $data_account[0]['user_type'];
			$code_role = $data_account[0]['code'];
			
			if($data_role[0]['add_room_service_management']=='yes')
			{
				
			
				// Get Variable Post
				$vehicle_id = $_POST['vehicle_id'];
				$room_service_id = $_POST['room_service_id'];
				$room_service_name = $_POST['room_service_name'];
				$service_type = $_POST['service_type'];
				$service_status = $_POST['service_status'];
				$service_man_power = $_POST['service_man_power'];
				
				$start_service_date = explode('-',$_POST['start_service_date']);
				$start_service_date = $start_service_date[2].'-'.$start_service_date[1].'-'.$start_service_date[0];
				$start_service_time = $_POST['start_service_time'];
				$finished_service_date = explode('-',$_POST['finished_service_date']);
				$finished_service_date = $finished_service_date[2].'-'.$finished_service_date[1].'-'.$finished_service_date[0];
				$finished_service_time = $_POST['finished_service_time'];
				$timestamp = date('Y:m:d H:i:s');
				$username = $user;
				
				
				$self_mecanic = $_POST['self_mecanic'];
				
				$vendor_mecanic = $_POST['vendor_mecanic'];
				$vendor_id = $_POST['vendor_id'];
				$vendor_name = $_POST['vendor_name'];
				
				if($service_man_power=='inhouse_service')
				{
					$mecanic = $self_mecanic;
					$vendor_id = '';
					$vendor_name = '';
				}
				else
				{
					$mecanic = $vendor_mecanic;
					$vendor_id = $vendor_id;
					$vendor_name = $vendor_name;
				}
			
				$service_description =  isset($_POST['service_description']) ? $_POST['service_description'] : '';
				$sparepart =  isset($_POST['sparepart']) ? $_POST['sparepart'] : '';
				$remark =  isset($_POST['remark']) ? $_POST['remark'] : '';
				
				
				$data_insert = array(
					
					"vehicle_id" => $vehicle_id,
					"room_service_id" => $room_service_id,
					"room_service_name" => $room_service_name,
					"service_type" => $service_type,
					"service_status" => $service_status,
					"service_man_power" => $service_man_power,
					"mecanic" => $mecanic,
					"vendor_id" => $vendor_id,
					"vendor_name" => $vendor_name,
					"start_service_date" => $start_service_date,
					"start_service_time" => $start_service_time,
					"finished_service_date" => $finished_service_date,
					"finished_service_time" => $finished_service_time,
					"created_date" => $timestamp,
					"created_by" => $username

				);
				
					//Check Workshop Apakah sudah ada dengan kode produk dan type motorist yang sama
					$check_data_workshop = $this->db->query("SELECT * FROM room_service_management WHERE vehicle_id = '".$vehicle_id."' AND service_status != 'Finished' ")->num_rows();
					
					if($check_data_workshop>=1)
					{
						$this->session->set_flashdata('message_failed',"Input failed, Please Finish the service before!");
						redirect('room_service_management');
					}
					else{
						$res = $this->model_room_service_management->insertData("room_service_management",$data_insert);
						if($res>=1)
						{
							$data_last_room_service = $this->db->query("SELECT * FROM room_service_management WHERE vehicle_id = '".$vehicle_id."' AND room_service_id = '".$room_service_id."' ORDER BY id_room_service_management DESC ")->result_array();
							
							foreach($service_description as $key => $service_description) {

								$data_insert = array(	
									"id_room_service_management" => $data_last_room_service[0]['id_room_service_management'],
									"service_description" => $service_description,
									"spare_part" => $sparepart[$key],
									"remark" => $remark[$key],
									"type" => "room_service"
								);
								$res = $this->model_room_service_management->insertData("detail_service",$data_insert);
							}
							
							$this->session->set_flashdata('message_success',"Data Room Service Management has been successfully saved!");
							redirect('room_service_management');
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
			
			if($data_role[0]['see_room_service_management']=='yes')
			{	
			$this->load->library('table');
			$this->load->library('pagination');
			$search = isset($_GET['search']) ? $_GET['search'] : '';
			
			
			$jumlah= $this->model_room_service_management->countRoomServiceManagement($search);
			
			if (count($_GET) > 0) $config['suffix'] = '?' . http_build_query($_GET, '', "&");
			$config['base_url'] = base_url().'index.php/driver/driver/';
			$config['total_rows'] = $jumlah;
			$config['first_link'] = 'First';
			$config['last_link'] = 'End';
			$config['next_link'] = 'Next';
			$config['prev_link'] = 'Previous';
			$config['per_page'] = 20; 	
			if (count($_GET) > 0) $config['suffix'] = '?' . http_build_query($_GET, '', "&");
			$config['first_url'] = $config['base_url'].'?'.http_build_query($_GET);
			
			$dari = $this->uri->segment('3');
			$data = $this->model_room_service_management->dataRoomServiceManagement($config['per_page'],$dari,$search);
			$this->pagination->initialize($config);
		
			$comp = array(
				'title' => ' Room Service Management',
				'content' => $this->load->view('room_service_management',array('data_room_service_management'=>$data,'data_role'=>$data_role,'search'=>$search),true),
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