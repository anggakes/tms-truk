<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Direct_cost extends CI_Controller {

	function __construct()  {
 		parent::__construct();
			$this->load->library(array('PHPExcel','PHPExcel/IOFactory'));
			$this->load->model('model_account_master');
			$this->load->model('model_direct_cost');
			$this->load->library('tank_auth');
			
	}
	
	
	public function deleteDirectCostAll()
	{
		
			date_default_timezone_set('Asia/Jakarta');
			ini_set('memory_limit', '-1');
			
			if ($this->tank_auth->is_logged_in()) {
			$user	= $this->tank_auth->get_username();
			$data_account = $this->model_account_master->getAccount("WHERE username = '".$user."' ")->result_array();
			$data_role = $this->model_account_master->getRole("WHERE id_role = '".$data_account[0]['user_access']."' ")->result_array();
			$user_role = $data_account[0]['user_type'];
			$code_role = $data_account[0]['code'];
			if($data_role[0]['delete_direct_cost']=='yes')
			{
				
			
				// Get Variable Post
				$id_direct_cost_delete = $_POST['id_direct_cost_delete_all'];
				
		
					//Update Product
					$res = $this->db->query("DELETE FROM direct_cost WHERE id_direct_cost in (".$id_direct_cost_delete.") ");
					if($res>=1)
					{
						$this->session->set_flashdata('message_success',"Data direct_cost has been successfully deleted!");
						redirect('direct_cost');
						
						}
					else
					{
						$this->session->set_flashdata('message_failed',"Data DirectCost failed to delete!");
						redirect('direct_cost');
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
	
	public function editDirectCost()
	{
		
			date_default_timezone_set('Asia/Jakarta');
			ini_set('memory_limit', '-1');
			
			if ($this->tank_auth->is_logged_in()) {
			$user	= $this->tank_auth->get_username();
			$data_account = $this->model_account_master->getAccount("WHERE username = '".$user."' ")->result_array();
			$data_role = $this->model_account_master->getRole("WHERE id_role = '".$data_account[0]['user_access']."' ")->result_array();
			$user_role = $data_account[0]['user_type'];
			$code_role = $data_account[0]['code'];
			
			if($data_role[0]['edit_direct_cost']=='yes')
			{
				
			
				// Get Variable Post
				$timestamp = date('Y:m:d H:i:s');
				$username = $user;
				$client_id = $_POST['edit_client_id'];
				$client_name = $_POST['edit_client_name'];
				$origin = $_POST['edit_origin'];
				$destination = $_POST['edit_destination'];
				$province = $_POST['edit_province'];
				$vehicle_type = $_POST['edit_vehicle_type'];
				$vehicle_status = $_POST['edit_vehicle_status'];
				$fixed_rate = $_POST['edit_fixed_rate'];
				$period_rate = explode('-',$_POST['edit_period_rate']);
				$period_rate = $period_rate[2].'-'.$period_rate[1].'-'.$period_rate[0];
				$trip_quota = $_POST['edit_trip_quota'];
				$vehicle_rate = $_POST['edit_vehicle_rate'];
				$weight_rate = $_POST['edit_weight_rate'];
				$excess_weight_rate = $_POST['edit_excess_weight_rate'];
				$min_weight = $_POST['edit_min_weight'];
				$max_weight = $_POST['edit_max_weight'];
				$uow = $_POST['edit_uow'];
				$volume_rate = $_POST['edit_volume_rate'];	
				$min_volume = $_POST['edit_min_volume'];
				$uov = $_POST['edit_uov'];
				$currency = $_POST['edit_currency'];
				$rate_status = $_POST['edit_rate_status'];
				$drop_destination = $_POST['edit_drop_destination'];
				$drop_rate = $_POST['edit_drop_rate'];
				$drop_charge_after = $_POST['edit_drop_charge_after'];
				$drop_rate_inner = $_POST['edit_drop_rate_inner'];
				$drop_rate_outer = $_POST['edit_drop_rate_outer'];
				
				$start_valid_date = explode('-',$_POST['edit_start_valid_date']);
				$start_valid_date = $start_valid_date[2].'-'.$start_valid_date[1].'-'.$start_valid_date[0];
				
				$expired_date = explode('-',$_POST['edit_expired_date']);
				$expired_date = $expired_date[2].'-'.$expired_date[1].'-'.$expired_date[0];
				
				
				$remark = $_POST['edit_remark'];
				$uov = $_POST['edit_uov'];
				$id_direct_cost = $_POST['id_direct_cost_update'];
				
				
				$data_vehicle_type = $this->db->query("SELECT * FROM vehicle_type WHERE vehicle_type = '".$vehicle_type."' ")->result_array();
				$id_vehicle_type = $data_vehicle_type[0]['id_vehicle_type'];
				
				$data_update = array(
				
					"client_id" => $client_id,
					"client_name" => $client_name,
					"origin" => $origin,
					"destination" => $destination,
					"province" => $province,
					"vehicle_type" => $vehicle_type,
					"id_vehicle_type" => $id_vehicle_type,
					"vehicle_status" => $vehicle_status,
					"fixed_rate" => $fixed_rate,
					"period_rate" => $period_rate,
					"trip_quota" => $trip_quota,
					"vehicle_rate" => $vehicle_rate,
					"weight_rate" => $weight_rate,
					"excess_weight_rate" => $excess_weight_rate,
					"min_weight" => $min_weight,
					"max_weight" => $max_weight,
					"uow" => $uow,
					"volume_rate" => $volume_rate,	
					"min_volume" => $min_volume,
					"uov" => $uov,
					"currency" => $currency,
					"drop_destination" => $drop_destination,
					"drop_rate" => $drop_rate,
					"drop_charge_after" => $drop_charge_after,
					"drop_rate_inner" => $drop_rate_inner,
					"drop_rate_outer" => $drop_rate_outer,
					"start_valid_date" => $start_valid_date,
					"expired_date" => $expired_date,
					"rate_status" => $rate_status,
					"remark" => $remark,
					"uov" => $uov,
					"updated_by" => $user,
					"updated_date" => $timestamp

				);
				
				$where = array("id_direct_cost"=>$id_direct_cost);
				
				//Check Product Apakah sudah ada dengan kode produk dan type motorist yang sama
				$check = $this->model_direct_cost->getDirectCost("WHERE client_id = '".$client_id."' AND origin = '".$origin."' AND destination = '".$destination."' AND id_direct_cost != '".$id_direct_cost."' ");
				
				
				if($check->num_rows() >=1 )
				{
					$this->session->set_flashdata('message_failed',"Sorry data already exist!");
					redirect('direct_cost');
					
					}
				else
				{
				
					//Update
					$res = $this->model_direct_cost->UpdateData("direct_cost",$data_update,$where);
					
					if($res>=1)
					{
						$this->session->set_flashdata('message_success',"Data DirectCost has been successfully updated!");
						
						redirect('direct_cost');
						
						}
					else
					{
						$this->session->set_flashdata('message_failed',"Data DirectCost failed to update!");
						redirect('direct_cost');
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
	
	
	public function deleteDirectCost()
	{
		
			date_default_timezone_set('Asia/Jakarta');
			ini_set('memory_limit', '-1');
			
			if ($this->tank_auth->is_logged_in()) {
			$user	= $this->tank_auth->get_username();
			$data_account = $this->model_account_master->getAccount("WHERE username = '".$user."' ")->result_array();
			$data_role = $this->model_account_master->getRole("WHERE id_role = '".$data_account[0]['user_access']."' ")->result_array();
			$user_role = $data_account[0]['user_type'];
			$code_role = $data_account[0]['code'];
			if($data_role[0]['delete_direct_cost']=='yes')
			{
				
			
				// Get Variable Post
				$id_direct_cost_delete = $_POST['id_direct_cost_delete'];
				$where = array("id_direct_cost" => $id_direct_cost_delete);
				
		
					//Update Product
					$res = $this->model_direct_cost->DeleteData("direct_cost",$where);
					if($res>=1)
					{
						$this->session->set_flashdata('message_success',"Data direct_cost has been successfully deleted!");
						redirect('direct_cost');
						
						}
					else
					{
						$this->session->set_flashdata('message_failed',"Data DirectCost failed to delete!");
						redirect('direct_cost');
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
	
	public function exportDirectCost()
	{
		
		date_default_timezone_set('Asia/Jakarta');
		if ($this->tank_auth->is_logged_in()) {
		$user	= $this->tank_auth->get_username();
		$data_account = $this->model_account_master->getAccount("WHERE username = '".$user."' ")->result_array();
		$data_role = $this->model_account_master->getRole("WHERE id_role = '".$data_account[0]['user_access']."' ")->result_array();
		$user_role = $data_account[0]['user_type'];
		$code_role = $data_account[0]['code'];
		
		if($data_role[0]['export_direct_cost']=='yes')
		{
		$search = isset($_GET['search']) ? $_GET['search'] : '';

		
		$date = date("m-d-Y");
		$this->db->or_like('client_name', $search);
		$this->db->or_like('client_id', $search);
		$query = $this->db->get('direct_cost');
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
		
		
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 1, "Master DirectCost");
		//Merge And Center Title
		$objPHPExcel->getActiveSheet()->mergeCells('A1:D1');
		
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 2, "Date : ".$date);
		
		//Merge And Center Date
		$objPHPExcel->getActiveSheet()->mergeCells('A2:D2');
		
		//Set Font Color Title
		$objPHPExcel->getActiveSheet()->getStyle('A1:D2')->applyFromArray($FontstyleTitle);
		
		//Set Font Color Header
		$objPHPExcel->getActiveSheet()->getStyle('A4:AC4')->applyFromArray($Fontstyle);
		
		//Set Backgroung Color Header
		$objPHPExcel->getActiveSheet()->getStyle('A4:AC4')->applyFromArray(
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
		"Client ID" => "Client ID",
		"Client Name" => "Client Name",
		"Origin" => "Origin",
		"Destination" => "Destination",
		"Province" => "Province",
		"Vehicle Type" => "Vehicle Type",
		"Vehicle Status" => "Vehicle Status",
		"Fixed Rate" => "Fixed Rate",
		"Period Rate" => "Period Rate",
		"Trip Quota" => "Trip Quota",
		"Vehicle Rate" => "Vehicle Rate",
		"Weight Rate" => "Weight Rate",
		"Excess Weight Rate" => "Excess Weight Rate",
		"Min Weight" => "Min Weight",
		"Max Weight" => "Max Weight",
		"Uow" => "Uow",
		"Volume Rate" => "Volume Rate",
		"Min Volume" => "Min Volume",
		"Currency" => "Currency",
		"Drop Destination" => "Drop Destination",
		"Drop Rate" => "Drop Rate",
		"Drop Charge After" => "Drop Charge After",
		"Drop Rate Inner" => "Drop Rate Inner",
		"Drop Rate Outer" => "Drop Rate Outer",
		"Start Valid Date" => "Start Valid Date",
		"Expired Date" => "Expired Date",
		"Rate Status" => "Rate Status",
		"Remark" => "Remark"
		
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
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $row, $data['client_id']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $row, $data['client_name']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $row, $data['origin']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $row, $data['destination']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, $row, $data['province']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, $row, $data['vehicle_type']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, $row, $data['vehicle_status']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8, $row, $data['fixed_rate']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9, $row, $data['period_rate']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(10, $row, $data['trip_quota']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(11, $row, $data['vehicle_rate']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(12, $row, $data['weight_rate']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(13, $row, $data['excess_weight_rate']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(14, $row, $data['min_weight']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(15, $row, $data['max_weight']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(16, $row, $data['uow']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(17, $row, $data['volume_rate']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(18, $row, $data['min_volume']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(19, $row, $data['currency']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(20, $row, $data['drop_destination']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(21, $row, $data['drop_rate']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(22, $row, $data['drop_charge_after']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(23, $row, $data['drop_rate_inner']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(24, $row, $data['drop_rate_outer']);
			
			$start_valid_date = explode('-',$data['start_valid_date']);
			$start_valid_date = $start_valid_date[2].'-'.$start_valid_date[1].'-'.$start_valid_date[0];
			
			$expired_date = explode('-',$data['expired_date']);
			$expired_date = $expired_date[2].'-'.$expired_date[1].'-'.$expired_date[0];
				
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(25, $row, $start_valid_date);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(26, $row, $expired_date);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(27, $row, $data['rate_status']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(28, $row, $data['remark']);
				
			
				
				
			
            $row++;
			$no++;
        }
		
	   $last_row = $row-1;
	   //Set Border
       $objPHPExcel->getActiveSheet()->getStyle("A4".":"."AC".$last_row)->applyFromArray($BStyle);
	   $objPHPExcel->getActiveSheet()->getStyle("A4".":"."AC".$last_row)->applyFromArray($styleAlign);
       $objPHPExcel->setActiveSheetIndex(0);
 
        $objWriter = IOFactory::createWriter($objPHPExcel, 'Excel5');
 		
		
	   // Sending headers to force the user to download the file
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Master-direct_cost-'.$date.'.xls"');
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
	
	public function importDirectCost()
	{
		
			date_default_timezone_set('Asia/Jakarta');
			ini_set('memory_limit', '-1');
			
			if ($this->tank_auth->is_logged_in()) {
			$user	= $this->tank_auth->get_username();
			$data_account = $this->model_account_master->getAccount("WHERE username = '".$user."' ")->result_array();
			$data_role = $this->model_account_master->getRole("WHERE id_role = '".$data_account[0]['user_access']."' ")->result_array();
			$user_role = $data_account[0]['user_type'];
			$code_role = $data_account[0]['code'];
			
			if($data_role[0]['import_direct_cost']=='yes')
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
				redirect('direct_cost');
				
				
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
					$check = $this->model_direct_cost->getDirectCost("WHERE direct_costcode  = '".$rowData[0][0]."' ");
					if($check->num_rows() >=1 )
					{
						
						$data_update = array(
							"direct_costname" => $rowData[0][1],
							"password" => md5($rowData[0][2])
							
						);
						$where = array(
							"direct_costcode" => $rowData[0][0]
						);
						
						$res = $this->model_direct_cost->UpdateData("direct_cost",$data_update,$where);
					
						}
					else
					{
						$data_insert = array(
							"direct_costcode" => $rowData[0][0],
							"direct_costname" => $rowData[0][1],
							"password" => md5($rowData[0][2])
						);
						
						//Insert Data
						$res = $this->model_direct_cost->insertData("direct_cost",$data_insert);
					
					}
					
				
				
			}
				@unlink($inputFileName);
				$this->session->set_flashdata('message_success','Data imported successfully');
				redirect('direct_cost');
			
               
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
	
	public function addDirectCost()
	{
		
			date_default_timezone_set('Asia/Jakarta');
			ini_set('memory_limit', '-1');
			
			if ($this->tank_auth->is_logged_in()) {
			$user	= $this->tank_auth->get_username();
			$data_account = $this->model_account_master->getAccount("WHERE username = '".$user."' ")->result_array();
			$data_role = $this->model_account_master->getRole("WHERE id_role = '".$data_account[0]['user_access']."' ")->result_array();
			$user_role = $data_account[0]['user_type'];
			$code_role = $data_account[0]['code'];
			
			if($data_role[0]['add_direct_cost']=='yes')
			{
				
				
				$timestamp = date('Y:m:d H:i:s');
				$username = $user;
				$client_id = $_POST['client_id'];
				$client_name = $_POST['client_name'];
				$origin = $_POST['origin'];
				$destination = $_POST['destination'];
				$province = $_POST['province'];
				$vehicle_type = $_POST['vehicle_type'];
				$vehicle_status = $_POST['vehicle_status'];
				$fixed_rate = $_POST['fixed_rate'];
				$period_rate = explode('-',$_POST['period_rate']);
				$period_rate = $period_rate[2].'-'.$period_rate[1].'-'.$period_rate[0];
				$trip_quota = $_POST['trip_quota'];
				$vehicle_rate = $_POST['vehicle_rate'];
				$weight_rate = $_POST['weight_rate'];
				$excess_weight_rate = $_POST['excess_weight_rate'];
				$min_weight = $_POST['min_weight'];
				$max_weight = $_POST['max_weight'];
				$uow = $_POST['uow'];
				$volume_rate = $_POST['volume_rate'];	
				$min_volume = $_POST['min_volume'];
				$uov = $_POST['uov'];
				$currency = $_POST['currency'];
				$drop_destination = $_POST['drop_destination'];
				$drop_rate = $_POST['drop_rate'];
				$drop_charge_after = $_POST['drop_charge_after'];
				$drop_rate_inner = $_POST['drop_rate_inner'];
				$drop_rate_outer = $_POST['drop_rate_outer'];
				$start_valid_date = explode('-',$_POST['start_valid_date']);
				$start_valid_date = $start_valid_date[2].'-'.$start_valid_date[1].'-'.$start_valid_date[0];
				
				$expired_date = explode('-',$_POST['expired_date']);
				$expired_date = $expired_date[2].'-'.$expired_date[1].'-'.$expired_date[0];
				$remark = $_POST['remark'];
				$rate_status = $_POST['rate_status'];
				$uov = $_POST['uov'];
				
				// Get Variable Post
				
				$data_vehicle_type = $this->db->query("SELECT * FROM vehicle_type WHERE vehicle_type = '".$vehicle_type."' ")->result_array();
				$id_vehicle_type = $data_vehicle_type[0]['id_vehicle_type'];
				$data_insert = array(
					"client_id" => $client_id,
					"client_name" => $client_name,
					"origin" => $origin,
					"destination" => $destination,
					"province" => $province,
					"vehicle_type" => $vehicle_type,
					"id_vehicle_type" => $id_vehicle_type,
					"vehicle_status" => $vehicle_status,
					"fixed_rate" => $fixed_rate,
					"period_rate" => $period_rate,
					"trip_quota" => $trip_quota,
					"vehicle_rate" => $vehicle_rate,
					"weight_rate" => $weight_rate,
					"excess_weight_rate" => $excess_weight_rate,
					"min_weight" => $min_weight,
					"max_weight" => $max_weight,
					"uow" => $uow,
					"volume_rate" => $volume_rate,	
					"min_volume" => $min_volume,
					"uov" => $uov,
					"currency" => $currency,
					"drop_destination" => $drop_destination,
					"drop_rate" => $drop_rate,
					"drop_charge_after" => $drop_charge_after,
					"drop_rate_inner" => $drop_rate_inner,
					"drop_rate_outer" => $drop_rate_outer,
					"start_valid_date" => $start_valid_date,
					"expired_date" => $expired_date,
					"rate_status" => $rate_status,
					"remark" => $remark,
					"uov" => $uov,
					"created_by" => $user,
					"created_date" => $timestamp
				);
				
				//Check Product Apakah sudah ada dengan kode produk dan type motorist yang sama
				$check = $this->model_direct_cost->getDirectCost("WHERE client_id = '".$client_id."' AND origin = '".$origin."' AND destination = '".$destination."'  ");
				if($check->num_rows() >=1 )
				{
					$this->session->set_flashdata('message_failed',"Sorry data already exist!");
					redirect('direct_cost');
					
					}
				else
				{
					
					$res = $this->model_direct_cost->insertData("direct_cost",$data_insert);
					if($res>=1)
					{
						$this->session->set_flashdata('message_success',"Data direct_cost has been successfully saved!");
						redirect('direct_cost');
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
			
			if($data_role[0]['see_direct_cost']=='yes')
			{	
			$this->load->library('table');
			$this->load->library('pagination');
			$search = isset($_GET['search']) ? $_GET['search'] : '';
			
			
			$jumlah= $this->model_direct_cost->countDirectCost($search);
			
			if (count($_GET) > 0) $config['suffix'] = '?' . http_build_query($_GET, '', "&");
			$config['base_url'] = base_url().'index.php/direct_cost/direct_cost/';
			$config['total_rows'] = $jumlah;
			$config['first_link'] = 'First';
			$config['last_link'] = 'End';
			$config['next_link'] = 'Next';
			$config['prev_link'] = 'Previous';
			$config['per_page'] = 5; 	
			if (count($_GET) > 0) $config['suffix'] = '?' . http_build_query($_GET, '', "&");
			$config['first_url'] = $config['base_url'].'?'.http_build_query($_GET);
			
			$dari = $this->uri->segment('3');
			$data = $this->model_direct_cost->dataDirectCost($config['per_page'],$dari,$search);
			
			$data_category = $this->db->query("SELECT * FROM master_data_category WHERE category = 'Vehicle Status Direct Cost' ")->result();
		
			$comp = array(
				'title' => ' DirectCost',
				'content' => $this->load->view('direct_cost',array('data_category'=>$data_category,'data_direct_cost'=>$data,'data_role'=>$data_role,'search'=>$search),true),
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