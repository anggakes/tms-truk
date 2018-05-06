<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Transport_order extends CI_Controller {

	function __construct()  {
 		parent::__construct();
			$this->load->library(array('PHPExcel','PHPExcel/IOFactory'));
			$this->load->model('model_account_master');
			$this->load->model('model_transport_order');
			$this->load->library('tank_auth');
			
	}
	
	
	public function deleteTransportOrderAll()
	{
		
			date_default_timezone_set('Asia/Jakarta');
			ini_set('memory_limit', '-1');
			
			if ($this->tank_auth->is_logged_in()) {
			$user	= $this->tank_auth->get_username();
			$data_account = $this->model_account_master->getAccount("WHERE username = '".$user."' ")->result_array();
			$data_role = $this->model_account_master->getRole("WHERE id_role = '".$data_account[0]['user_access']."' ")->result_array();
			$user_role = $data_account[0]['user_type'];
			$code_role = $data_account[0]['code'];
			if($data_role[0]['delete_transport_order']=='yes')
			{
				
			
				// Get Variable Post
				$id_transport_order_delete = $_POST['id_transport_order_delete_all'];
				
		
					//Update Product
					$res = $this->db->query("DELETE FROM transport_order WHERE spk_number in (".$id_transport_order_delete.") ");
					if($res>=1)
					{
						$this->session->set_flashdata('message_success',"Data Transport Order has been successfully deleted!");
						redirect('transport_order');
						
						}
					else
					{
						$this->session->set_flashdata('message_failed',"Data Transport Order failed to delete!");
						redirect('transport_order');
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
	
	public function editTransportOrder()
	{
		
			date_default_timezone_set('Asia/Jakarta');
			ini_set('memory_limit', '-1');
			
			if ($this->tank_auth->is_logged_in()) {
			$user	= $this->tank_auth->get_username();
			$data_account = $this->model_account_master->getAccount("WHERE username = '".$user."' ")->result_array();
			$data_role = $this->model_account_master->getRole("WHERE id_role = '".$data_account[0]['user_access']."' ")->result_array();
			$user_role = $data_account[0]['user_type'];
			$code_role = $data_account[0]['code'];
			
			if($data_role[0]['edit_transport_order']=='yes')
			{
				
			
				// Get Variable Post
				$timestamp = date('Y:m:d H:i:s');
				$username = $user;
				// Get Variable Post
				$id_transport_order_update = $_POST['id_transport_order_update'];
				$do_number = $_POST['edit_do_number'];
				$reference = $_POST['edit_reference'];
				$delivery_date = explode('-',$_POST['edit_delivery_date']);
				$delivery_date = $delivery_date[2].'-'.$delivery_date[1].'-'.$delivery_date[0];
				$delivery_time = $_POST['edit_delivery_time'];
				$origin_id = $_POST['edit_origin_id'];
				$origin_address = $_POST['edit_origin_address'];
				$origin_area = $_POST['edit_origin_area'];
				$destination_id = $_POST['edit_destination_id'];
				$destination_address = $_POST['edit_destination_address'];
				$destination_area = $_POST['edit_destination_area'];
				$client_id = $_POST['edit_client_id'];
				$client_name = $_POST['edit_client_name'];
				$document_date = explode('-',$_POST['edit_document_date']);
				$document_date = $document_date[2].'-'.$document_date[1].'-'.$document_date[0];
				$document_time = $_POST['edit_document_time'];
				$posting_date = explode('-',$_POST['edit_posting_date']);
				$posting_date = $posting_date[2].'-'.$posting_date[1].'-'.$posting_date[0];
				$order_type = $_POST['edit_order_type'];
				$remark = $_POST['edit_remark'];
				$si = $_POST['edit_si'];
				$hawb = $_POST['edit_hawb'];
				$mawb = $_POST['edit_mawb'];
				$notes = $_POST['edit_notes'];
				$qty = $_POST['edit_qty'];
				$volume = $_POST['edit_volume'];
				$weight = $_POST['edit_weight'];
				
				
				$job_number = $_POST['edit_job_number'];
				$id_detail_trucking_order = $_POST['edit_id_detail_trucking_order'];
				$cargo_type = $_POST['edit_cargo_type'];
				$id_detail_trucking_order_lama = $_POST['edit_id_detail_trucking_order_lama'];
				
				
				$data_update = array(
				
					"reference" => $reference,
					"do_number" => $do_number,
					"delivery_date" => $delivery_date,
					"delivery_time" => $delivery_time,
					"origin_id" => $origin_id,
					"origin_address" => $origin_address,
					"origin_area" => $origin_area,
					"destination_id" => $destination_id,
					"destination_address" => $destination_address,
					"destination_area" => $destination_area,
					"client_id" => $client_id,
					"client_name" => $client_name,
					"document_date" => $document_date,
					"document_time" => $document_time,
					"posting_date" => $posting_date,
					"order_type" => $order_type,
					"remark" => $remark,
					"si" => $si,
					"hawb" => $hawb,
					"mawb" => $mawb,
					"qty" => $qty,
					"volume" => $volume,
					"weight" => $weight,
					"cargo_type" => $cargo_type,
					"notes" => $notes,
					"id_detail_trucking_order" => $id_detail_trucking_order,
					"id_trucking_order" => $job_number,
					"updated_by" => $user,
					"updated_date" => $timestamp

				);
				
				$where = array(
				
				"spk_number" => $id_transport_order_update

				);
				
			
				
					//Update
					$res = $this->model_transport_order->UpdateData("transport_order",$data_update,$where);
					
					if($res>=1)
					{
						//echo $id_detail_trucking_order_lama.'-'.$id_detail_trucking_order;
						$update_detail_trucking_order_lama = $this->db->query("UPDATE detail_trucking_order SET status_transport_order = 'no' WHERE id_detail_trucking_order = '".$id_detail_trucking_order_lama."' ");
						
						$update_detail_trucking_order = $this->db->query("UPDATE detail_trucking_order SET 	status_transport_order = 'yes' WHERE id_detail_trucking_order = '".$id_detail_trucking_order."' ");
						
						$this->session->set_flashdata('message_success',"Data Transport Order has been successfully updated!");
						
						redirect('transport_order');
						
						}
					else
					{
						$this->session->set_flashdata('message_failed',"Data Transport Order failed to update!");
						redirect('transport_order');
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
	
	
	public function deleteTransportOrder()
	{
		
			date_default_timezone_set('Asia/Jakarta');
			ini_set('memory_limit', '-1');
			
			if ($this->tank_auth->is_logged_in()) {
			$user	= $this->tank_auth->get_username();
			$data_account = $this->model_account_master->getAccount("WHERE username = '".$user."' ")->result_array();
			$data_role = $this->model_account_master->getRole("WHERE id_role = '".$data_account[0]['user_access']."' ")->result_array();
			$user_role = $data_account[0]['user_type'];
			$code_role = $data_account[0]['code'];
			if($data_role[0]['delete_transport_order']=='yes')
			{
				
			
				// Get Variable Post
				$id_transport_order_delete = $_POST['id_transport_order_delete'];
				$where = array("spk_number" => $id_transport_order_delete);
				
		
					//Update Product
					$res = $this->model_transport_order->DeleteData("transport_order",$where);
					if($res>=1)
					{
						$this->session->set_flashdata('message_success',"Data Transport Order has been successfully deleted!");
						redirect('transport_order');
						
						}
					else
					{
						$this->session->set_flashdata('message_failed',"Data Transport Order failed to delete!");
						redirect('transport_order');
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
	
	public function exportTransportOrder()
	{
		
		date_default_timezone_set('Asia/Jakarta');
		if ($this->tank_auth->is_logged_in()) {
		$user	= $this->tank_auth->get_username();
		$data_account = $this->model_account_master->getAccount("WHERE username = '".$user."' ")->result_array();
		$data_role = $this->model_account_master->getRole("WHERE id_role = '".$data_account[0]['user_access']."' ")->result_array();
		$user_role = $data_account[0]['user_type'];
		$code_role = $data_account[0]['code'];
		
		if($data_role[0]['export_transport_order']=='yes')
		{
		$search = isset($_GET['search']) ? $_GET['search'] : '';

		
		$date = date("m-d-Y");
		$this->db->or_like('client_id', $search);
		$query = $this->db->get('transport_order');
		
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
		
		
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 1, "Master TransportOrder");
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
		"SPK Number" => "SPK Number",
		"Reference" => "Reference",
		"DO Number" => "DO Number",
		"Order Type" => "Order Type",
		"Delivery Date" => "Delivery Date",
		"Posting Date" => "Posting Date",
		"Origin ID" => "Origin ID",
		"Origin Area" => "Origin Area",
		"Origin Address" => "Origin Address",
		"Destination ID" => "Destination ID",
		"Destination Area" => "Destination Area",
		"Destination Address" => "Destination Address",
		"Status" => "Status"
		
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
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $row, $data['spk_number']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $row, $data['reference']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $row, $data['do_number']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $row, $data['order_type']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, $row, $data['delivery_date']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, $row, $data['posting_date']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, $row, $data['origin_id']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8, $row, $data['origin_area']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9, $row, $data['origin_address']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(10, $row, $data['destination_id']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(11, $row, $data['destination_area']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(12, $row, $data['destination_address']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(13, $row, $data['status']);
 
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
        header('Content-Disposition: attachment;filename="Master-transport_order-'.$date.'.xls"');
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
	
	public function importTransportOrder()
	{
		
			date_default_timezone_set('Asia/Jakarta');
			ini_set('memory_limit', '-1');
			
			if ($this->tank_auth->is_logged_in()) {
			$user	= $this->tank_auth->get_username();
			$data_account = $this->model_account_master->getAccount("WHERE username = '".$user."' ")->result_array();
			$data_role = $this->model_account_master->getRole("WHERE id_role = '".$data_account[0]['user_access']."' ")->result_array();
			$user_role = $data_account[0]['user_type'];
			$code_role = $data_account[0]['code'];
			
			if($data_role[0]['import_transport_order']=='yes')
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
					$check = $this->model_transport_order->getTransportOrder("WHERE transport_order_code  = '".$rowData[0][0]."' ");
					if($check->num_rows() >=1 )
					{
						
						$data_update = array(
							"transport_order_name" => $rowData[0][1],
							"password" => md5($rowData[0][2])
							
						);
						$where = array(
							"transport_order_code" => $rowData[0][0]
						);
						
						$res = $this->model_transport_order->UpdateData("driver",$data_update,$where);
					
						}
					else
					{
						$data_insert = array(
							"transport_order_code" => $rowData[0][0],
							"transport_order_name" => $rowData[0][1],
							"password" => md5($rowData[0][2])
						);
						
						//Insert Data
						$res = $this->model_transport_order->insertData("driver",$data_insert);
					
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
	
	public function addTransportOrder()
	{
		
			date_default_timezone_set('Asia/Jakarta');
			ini_set('memory_limit', '-1');
			
			if ($this->tank_auth->is_logged_in()) {
			$user	= $this->tank_auth->get_username();
			$data_account = $this->model_account_master->getAccount("WHERE username = '".$user."' ")->result_array();
			$data_role = $this->model_account_master->getRole("WHERE id_role = '".$data_account[0]['user_access']."' ")->result_array();
			$user_role = $data_account[0]['user_type'];
			$code_role = $data_account[0]['code'];
			
			if($data_role[0]['add_transport_order']=='yes')
			{
				
				
				$timestamp = date('Y:m:d H:i:s');
				$username = $user;
				// Get Variable Post
				$do_number = $_POST['do_number'];
				$reference = $_POST['reference'];
				$delivery_date = explode('-',$_POST['delivery_date']);
				$delivery_date = $delivery_date[2].'-'.$delivery_date[1].'-'.$delivery_date[0];
				$delivery_time = $_POST['delivery_time'];
				$origin_id = $_POST['origin_id'];
				$origin_address = $_POST['origin_address'];
				$origin_area = $_POST['origin_area'];
				$destination_id = $_POST['destination_id'];
				$destination_address = $_POST['destination_address'];
				$destination_area = $_POST['destination_area'];
				$client_id = $_POST['client_id'];
				$client_name = $_POST['client_name'];
				$document_date = explode('-',$_POST['document_date']);
				$document_date = $document_date[2].'-'.$document_date[1].'-'.$document_date[0];
				$document_time = $_POST['document_time'];
				$posting_date = explode('-',$_POST['posting_date']);
				$posting_date = $posting_date[2].'-'.$posting_date[1].'-'.$posting_date[0];
				$order_type = $_POST['order_type'];
				$remark = $_POST['remark'];
				$si = $_POST['si'];
				$hawb = $_POST['hawb'];
				$mawb = $_POST['mawb'];
				$notes = $_POST['notes'];
				$qty = $_POST['qty'];
				$volume = $_POST['volume'];
				$weight = $_POST['weight'];
				
				//$job_number = $_POST['job_number'];
				//$id_detail_trucking_order = $_POST['id_detail_trucking_order'];
				//$cargo_type = $_POST['cargo_type'];
				
				
				
				$data_insert = array(
					
					"reference" => $reference,
					"do_number" => $do_number,
					"delivery_date" => $delivery_date,
					"delivery_time" => $delivery_time,
					"origin_id" => $origin_id,
					"origin_address" => $origin_address,
					"origin_area" => $origin_area,
					"destination_id" => $destination_id,
					"destination_address" => $destination_address,
					"destination_area" => $destination_area,
					"client_id" => $client_id,
					"client_name" => $client_name,
					"document_date" => $document_date,
					"document_time" => $document_time,
					"posting_date" => $posting_date,
					"order_type" => $order_type,
					"remark" => $remark,
					"si" => $si,
					"hawb" => $hawb,
					"mawb" => $mawb,
					"qty" => $qty,
					"volume" => $volume,
					"weight" => $weight,
					//"cargo_type" => $cargo_type,
					"notes" => $notes,
					//"id_detail_trucking_order" => $id_detail_trucking_order,
					//"id_trucking_order" => $job_number,
					"created_by" => $user,
					"created_date" => $timestamp
		
				
				);
				
				//Check Product Apakah sudah ada dengan kode produk dan type motorist yang sama
				
					
					$res = $this->model_transport_order->insertData("transport_order",$data_insert);
					if($res>=1)
					{
						$update_detail_trucking_order = $this->db->query("UPDATE detail_trucking_order SET 	status_transport_order = 'yes' WHERE id_detail_trucking_order = '".$id_detail_trucking_order."' ");
						$this->session->set_flashdata('message_success',"Data Transport Order has been successfully saved!");
						redirect('transport_order');
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
			
			if($data_role[0]['see_transport_order']=='yes')
			{	
			$this->load->library('table');
			$this->load->library('pagination');
			$search = isset($_GET['search']) ? $_GET['search'] : '';
			
			
			$jumlah= $this->model_transport_order->countTransportOrder($search);
			
			if (count($_GET) > 0) $config['suffix'] = '?' . http_build_query($_GET, '', "&");
			$config['base_url'] = base_url().'index.php/driver/driver/';
			$config['total_rows'] = $jumlah;
			$config['first_link'] = 'First';
			$config['last_link'] = 'End';
			$config['next_link'] = 'Next';
			$config['prev_link'] = 'Previous';
			$config['per_page'] = 5; 	
			if (count($_GET) > 0) $config['suffix'] = '?' . http_build_query($_GET, '', "&");
			$config['first_url'] = $config['base_url'].'?'.http_build_query($_GET);
			
			$dari = $this->uri->segment('3');
			$data = $this->model_transport_order->dataTransportOrder($config['per_page'],$dari,$search);
			$this->pagination->initialize($config);
		
			$comp = array(
				'title' => ' TransportOrder',
				'content' => $this->load->view('transport_order',array('data_transport_order'=>$data,'data_role'=>$data_role,'search'=>$search),true),
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