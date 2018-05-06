<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Service_vendor extends CI_Controller {

	function __construct()  {
 		parent::__construct();
			$this->load->library(array('PHPExcel','PHPExcel/IOFactory'));
			$this->load->model('model_account_master');
			$this->load->model('model_service_vendor');
			$this->load->library('tank_auth');
			
	}
	
	
	public function deleteServiceVendorAll()
	{
		
			date_default_timezone_set('Asia/Jakarta');
			ini_set('memory_limit', '-1');
			
			if ($this->tank_auth->is_logged_in()) {
			$user	= $this->tank_auth->get_username();
			$data_account = $this->model_account_master->getAccount("WHERE username = '".$user."' ")->result_array();
			$data_role = $this->model_account_master->getRole("WHERE id_role = '".$data_account[0]['user_access']."' ")->result_array();
			$user_role = $data_account[0]['user_type'];
			$code_role = $data_account[0]['code'];
			if($data_role[0]['delete_service_vendor']=='yes')
			{
				
			
				// Get Variable Post
				$id_service_vendor_delete = $_POST['id_service_vendor_delete_all'];
		
					//Update Product
					$res = $this->db->query("DELETE FROM service_vendor WHERE id_service_vendor in (".$id_service_vendor_delete.") ");
					if($res>=1)
					{
						$this->session->set_flashdata('message_success',"Data Service Vendor has been successfully deleted!");
						redirect('service_vendor');
						
						}
					else
					{
						$this->session->set_flashdata('message_failed',"Data Service Vendor failed to delete!");
						redirect('service_vendor');
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
	
	public function editServiceVendor()
	{
		
			date_default_timezone_set('Asia/Jakarta');
			ini_set('memory_limit', '-1');
			
			if ($this->tank_auth->is_logged_in()) {
			$user	= $this->tank_auth->get_username();
			$data_account = $this->model_account_master->getAccount("WHERE username = '".$user."' ")->result_array();
			$data_role = $this->model_account_master->getRole("WHERE id_role = '".$data_account[0]['user_access']."' ")->result_array();
			$user_role = $data_account[0]['user_type'];
			$code_role = $data_account[0]['code'];
			
			if($data_role[0]['edit_service_vendor']=='yes')
			{
				
			
				// Get Variable Post
				$timestamp = date('Y:m:d H:i:s');
				$username = $user;
				$vehicle_id = $_POST['edit_vehicle_id'];
				$vendor_id = $_POST['edit_vendor_id'];
				$vendor_name = $_POST['edit_vendor_name'];
				$service_status = $_POST['edit_service_status'];
				$service_type = $_POST['edit_service_type'];
				
				$start_service_date = explode('-',$_POST['edit_start_service_date']);
				$start_service_date = $start_service_date[2].'-'.$start_service_date[1].'-'.$start_service_date[0];
				$start_service_time = $_POST['edit_start_service_time'];
				
				$finished_service_date = explode('-',$_POST['edit_finished_service_date']);
				$finished_service_date = $finished_service_date[2].'-'.$finished_service_date[1].'-'.$finished_service_date[0];
				$finished_service_time = $_POST['edit_finished_service_time'];
				
				$remark = $_POST['edit_remark'];
				$id_service_vendor = $_POST['id_service_vendor_update'];
				
				$data_update = array(
				
						"vehicle_id" => $vehicle_id,
						"vendor_id" => $vendor_id,
						"vendor_name" => $vendor_name,
						"service_status" => $service_status,
						"service_type" => $service_type,
						"start_service_date" => $start_service_date,
						"start_service_time" => $start_service_time,
						"finished_service_date" => $finished_service_date,
						"finished_service_time" => $finished_service_time,
						"remark" => $remark,
						"updated_by" => $username,
						"updated_date" => $timestamp
						
				);
				
				$where = array("id_service_vendor"=>$id_service_vendor);
				
				//Check Product Apakah sudah ada dengan kode produk dan type motorist yang sama
				$check = $this->model_service_vendor->getServiceVendor("WHERE vehicle_id = '".$vehicle_id."' AND service_status != 'finished' AND id_service_vendor != '".$id_service_vendor."' ");
				
				
				if($check->num_rows() >=1 )
				{
					$this->session->set_flashdata('message_failed',"Sorry data already exist!");
					redirect('service_vendor');
					
					}
				else
				{
				
					//Update
					$res = $this->model_service_vendor->UpdateData("service_vendor",$data_update,$where);
					
					if($res>=1)
					{
						$this->session->set_flashdata('message_success',"Data Service Vendor has been successfully updated!");
						
						redirect('service_vendor');
						
						}
					else
					{
						$this->session->set_flashdata('message_failed',"Data Service Vendor failed to update!");
						redirect('service_vendor');
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
	
	
	public function deleteServiceVendor()
	{
		
			date_default_timezone_set('Asia/Jakarta');
			ini_set('memory_limit', '-1');
			
			if ($this->tank_auth->is_logged_in()) {
			$user	= $this->tank_auth->get_username();
			$data_account = $this->model_account_master->getAccount("WHERE username = '".$user."' ")->result_array();
			$data_role = $this->model_account_master->getRole("WHERE id_role = '".$data_account[0]['user_access']."' ")->result_array();
			$user_role = $data_account[0]['user_type'];
			$code_role = $data_account[0]['code'];
			if($data_role[0]['delete_service_vendor']=='yes')
			{
				
			
				// Get Variable Post
				$id_service_vendor_delete = $_POST['id_service_vendor_delete'];
				$where = array("id_service_vendor" => $id_service_vendor_delete);
				
		
					//Update Product
					$res = $this->model_service_vendor->DeleteData("service_vendor",$where);
					if($res>=1)
					{
						$this->session->set_flashdata('message_success',"Data Service Vendor has been successfully deleted!");
						redirect('service_vendor');
						
						}
					else
					{
						$this->session->set_flashdata('message_failed',"Data Service Vendor failed to delete!");
						redirect('service_vendor');
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
	
	public function exportServiceVendor()
	{
		
		date_default_timezone_set('Asia/Jakarta');
		if ($this->tank_auth->is_logged_in()) {
		$user	= $this->tank_auth->get_username();
		$data_account = $this->model_account_master->getAccount("WHERE username = '".$user."' ")->result_array();
		$data_role = $this->model_account_master->getRole("WHERE id_role = '".$data_account[0]['user_access']."' ")->result_array();
		$user_role = $data_account[0]['user_type'];
		$code_role = $data_account[0]['code'];
		
		if($data_role[0]['export_service_vendor']=='yes')
		{
		$search = isset($_GET['search']) ? $_GET['search'] : '';

		
		$date = date("m-d-Y");
		$this->db->or_like('vehicle_id', $search);
		$query = $this->db->get('service_vendor');
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
		
		
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 1, "Master Service Vendor");
		//Merge And Center Title
		$objPHPExcel->getActiveSheet()->mergeCells('A1:D1');
		
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 2, "Date : ".$date);
		
		//Merge And Center Date
		$objPHPExcel->getActiveSheet()->mergeCells('A2:D2');
		
		//Set Font Color Title
		$objPHPExcel->getActiveSheet()->getStyle('A1:D2')->applyFromArray($FontstyleTitle);
		
		//Set Font Color Header
		$objPHPExcel->getActiveSheet()->getStyle('A4:O4')->applyFromArray($Fontstyle);
		
		//Set Backgroung Color Header
		$objPHPExcel->getActiveSheet()->getStyle('A4:O4')->applyFromArray(
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
		"Vehicle ID" => "Vehicle ID",
		"Service Status" => "Service Status",
		"Vendor Id" => "Vendor Id",
		"Vendor Name" => "Vendor Name",
		"Service Type" => "Service Type",
		
		"Start Service Date" => "Start Service Date",
		"Start Service Time" => "Start Service Time",
		"Finished Service Date" => "Finished Service Date",
		"Finished Service Time" => "Finished Service Time",
		
		"Remark" => "Remark",
		"Created By" => "Created By",
		"Created Date" => "Created Date",
		"Updated By" => "Updated By",
		"Updated Date" => "Updated Date"
		
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
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $row, $data['service_status']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $row, $data['vendor_id']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $row, $data['vendor_name']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, $row, $data['service_type']);
			
			$start_service_date = explode('-',$data['start_service_date']);
			$start_service_date = $start_service_date[2].'-'.$start_service_date[1].'-'.$start_service_date[0];
			
			$finished_service_date = explode('-',$data['finished_service_date']);
			$finished_service_date = $finished_service_date[2].'-'.$finished_service_date[1].'-'.$finished_service_date[0];
			
			
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, $row, $start_service_date);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, $row, $data['start_service_time']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8, $row, $finished_service_date);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9, $row, $data['finished_service_time	']);
			
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(10, $row, $data['remark']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(11, $row, $data['created_by']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(12, $row, $data['created_date']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(13, $row, $data['updated_by']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(14, $row, $data['updated_date']);
			
			
			
			
            $row++;
			$no++;
        }
		
	   $last_row = $row-1;
	   //Set Border
       $objPHPExcel->getActiveSheet()->getStyle("A4".":"."O".$last_row)->applyFromArray($BStyle);
	   $objPHPExcel->getActiveSheet()->getStyle("A4".":"."O".$last_row)->applyFromArray($styleAlign);
       $objPHPExcel->setActiveSheetIndex(0);
 
        $objWriter = IOFactory::createWriter($objPHPExcel, 'Excel5');
 		
		
	   // Sending headers to force the user to download the file
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Master-service-vendor-'.$date.'.xls"');
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
					$check = $this->model_service_vendor->getDriver("WHERE driver_code  = '".$rowData[0][0]."' ");
					if($check->num_rows() >=1 )
					{
						
						$data_update = array(
							"driver_name" => $rowData[0][1],
							"password" => md5($rowData[0][2])
							
						);
						$where = array(
							"driver_code" => $rowData[0][0]
						);
						
						$res = $this->model_service_vendor->UpdateData("driver",$data_update,$where);
					
						}
					else
					{
						$data_insert = array(
							"driver_code" => $rowData[0][0],
							"driver_name" => $rowData[0][1],
							"password" => md5($rowData[0][2])
						);
						
						//Insert Data
						$res = $this->model_service_vendor->insertData("driver",$data_insert);
					
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
	
	public function addServiceVendor()
	{
		
			date_default_timezone_set('Asia/Jakarta');
			ini_set('memory_limit', '-1');
			
			if ($this->tank_auth->is_logged_in()) {
			$user	= $this->tank_auth->get_username();
			$data_account = $this->model_account_master->getAccount("WHERE username = '".$user."' ")->result_array();
			$data_role = $this->model_account_master->getRole("WHERE id_role = '".$data_account[0]['user_access']."' ")->result_array();
			$user_role = $data_account[0]['user_type'];
			$code_role = $data_account[0]['code'];
			
			if($data_role[0]['add_service_vendor']=='yes')
			{
				
			
				// Get Variable Post
				$timestamp = date('Y:m:d H:i:s');
				$username = $user;
				$vehicle_id = $_POST['vehicle_id'];
				$vendor_id = $_POST['vendor_id'];
				$vendor_name = $_POST['vendor_name'];
				$service_status = $_POST['service_status'];
				$service_type = $_POST['service_type'];
				
				$start_service_date = explode('-',$_POST['start_service_date']);
				$start_service_date = $start_service_date[2].'-'.$start_service_date[1].'-'.$start_service_date[0];
				$start_service_time = $_POST['start_service_time'];
				
				$finished_service_date = explode('-',$_POST['finished_service_date']);
				$finished_service_date = $finished_service_date[2].'-'.$finished_service_date[1].'-'.$finished_service_date[0];
				$finished_service_time = $_POST['finished_service_time'];
				
				
				$remark = $_POST['remark'];
				
				$data_insert = array(
						
						"vehicle_id" => $vehicle_id,
						"vendor_id" => $vendor_id,
						"vendor_name" => $vendor_name,
						"service_status" => $service_status,
						"service_type" => $service_type,
						"start_service_date" => $start_service_date,
						"start_service_time" => $start_service_time,
						"finished_service_date" => $finished_service_date,
						"finished_service_time" => $finished_service_time,
						"service_type" => $service_type,
						"remark" => $remark,
						"created_by" => $username,
						"created_date" => $timestamp
				);
				
				//Check Product Apakah sudah ada dengan kode produk dan type motorist yang sama
				$check = $this->model_service_vendor->getServiceVendor("WHERE vehicle_id = '".$vehicle_id."' AND service_status != 'finished' ");
				if($check->num_rows() >=1 )
				{
					$this->session->set_flashdata('message_failed',"Sorry vehicle on progress service now!");
					redirect('service_vendor');
					
					}
				else
				{
					
					$res = $this->model_service_vendor->insertData("service_vendor",$data_insert);
					if($res>=1)
					{
						$this->session->set_flashdata('message_success',"Data Service Vendor has been successfully saved!");
						redirect('service_vendor');
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
			
			if($data_role[0]['see_service_vendor']=='yes')
			{	
			$this->load->library('table');
			$this->load->library('pagination');
			$search = isset($_GET['search']) ? $_GET['search'] : '';
			
			
			$jumlah= $this->model_service_vendor->countServiceVendor($search);
			
			if (count($_GET) > 0) $config['suffix'] = '?' . http_build_query($_GET, '', "&");
			$config['base_url'] = base_url().'index.php/service_vendor/service_vendor/';
			$config['total_rows'] = $jumlah;
			$config['first_link'] = 'First';
			$config['last_link'] = 'End';
			$config['next_link'] = 'Next';
			$config['prev_link'] = 'Previous';
			$config['per_page'] = 5; 	
			if (count($_GET) > 0) $config['suffix'] = '?' . http_build_query($_GET, '', "&");
			$config['first_url'] = $config['base_url'].'?'.http_build_query($_GET);
			
			$dari = $this->uri->segment('3');
			$data = $this->model_service_vendor->dataServiceVendor($config['per_page'],$dari,$search);
			
			$data_category_service = $this->db->query("SELECT * FROM master_data_category WHERE category = 'Service Type Fleet' ")->result();
		
			$comp = array(
				'title' => ' Service Vendor',
				'content' => $this->load->view('service_vendor',array('data_category_service'=>$data_category_service,'data_service_vendor'=>$data,'data_role'=>$data_role,'search'=>$search),true),
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