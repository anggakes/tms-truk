<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Invoice extends CI_Controller {

	function __construct()  {
 		parent::__construct();
			$this->load->library(array('PHPExcel','PHPExcel/IOFactory'));
			$this->load->model('model_account_master');
			$this->load->model('model_invoice');
			$this->load->library('tank_auth');
			
	}
	
	
	public function detailInvoice()
	{
		
			date_default_timezone_set('Asia/Jakarta');
			if ($this->tank_auth->is_logged_in()) {
			$user	= $this->tank_auth->get_username();
			$data_account = $this->model_account_master->getAccount("WHERE username = '".$user."' ")->result_array();
			$data_role = $this->model_account_master->getRole("WHERE id_role = '".$data_account[0]['user_access']."' ")->result_array();
			$user_role = $data_account[0]['user_type'];
			$code_role = $data_account[0]['code'];
			
			if($data_role[0]['see_invoice']=='yes')
			{	
		
		
			$id_invoice = isset($_GET['id_invoice']) ? $_GET['id_invoice'] : '';
			
			$data_invoice = $this->db->query("SELECT * FROM master_invoice WHERE id_invoice = '".$id_invoice."' ")->result_array();
			$data_invoice = array (
				"id_invoice" => $data_invoice[0]['id_invoice'],
				"invoice_number" => $data_invoice[0]['invoice_number'],
				"client_id" => $data_invoice[0]['client_id'],
				"transporter" => $data_invoice[0]['transporter'],
				"transporter_id" => $data_invoice[0]['transporter_id'],
				"transporter_name" => $data_invoice[0]['transporter_name'],
				"remark" => $data_invoice[0]['remark'],
				"schedule_date_from" => $data_invoice[0]['schedule_date_from'],
				"schedule_date_to" => $data_invoice[0]['schedule_date_to'],
				"status" => $data_invoice[0]['status']
			);
			
			$data_detail_invoice = $this->db->query("SELECT * FROM detail_master_invoice WHERE id_invoice = '".$id_invoice."' ")->result();
			
			
		
			$comp = array(
				'title' => ' Detail Invoice',
				'content' => $this->load->view('detail_invoice',array('data_invoice'=>$data_invoice,'data_detail_invoice'=>$data_detail_invoice,'data_role'=>$data_role),true),
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
	
	public function submitInvoice()
	{
		
			date_default_timezone_set('Asia/Jakarta');
			ini_set('memory_limit', '-1');
			
			if ($this->tank_auth->is_logged_in()) {
			$user	= $this->tank_auth->get_username();
			$data_account = $this->model_account_master->getAccount("WHERE username = '".$user."' ")->result_array();
			$data_role = $this->model_account_master->getRole("WHERE id_role = '".$data_account[0]['user_access']."' ")->result_array();
			$user_role = $data_account[0]['user_type'];
			$code_role = $data_account[0]['code'];
			
			if($data_role[0]['edit_invoice']=='yes')
			{
				
			
				// Get Variable Post
				$timestamp = date('Y:m:d H:i:s');
				$username = $user;
				$input_invoice_number = $_POST['input_invoice_number'];
				$input_type = $_POST['input_type'];
				$input_transporter = $_POST['input_transporter'];
				$input_transporter_id = $_POST['input_transporter_id'];
				$input_client_id = $_POST['input_client_id'];
				$input_client_name = $_POST['input_client_name'];
				$input_start_date = $_POST['input_start_date'];
				$input_end_date = $_POST['input_end_date'];
				
				$id_manifest = $_POST['id_manifest'];
				$delivery_date = $_POST['delivery_date'];
				$trip = $_POST['trip'];
				$origin_id = $_POST['origin_id'];
				$destination_id = $_POST['destination_id'];
				$rate = $_POST['rate'];
				$client_rate = $_POST['client_rate'];
				
				
				$data_insert = array(						
							"invoice_number" => $input_invoice_number,
							"client_id" => $input_client_id,
							"transporter" => $input_transporter,
							"transporter_id" => $input_transporter_id,
							"schedule_date_from" => $input_start_date,
							"schedule_date_to" => $input_end_date,
							"created_by" => $username,
							"created_date" => $timestamp
				);
				
				$check_invoice = $this->db->query("SELECT * FROM master_invoice WHERE invoice_number = '".$input_invoice_number."' ")->num_rows();
				if($check_invoice>=1)
				{
					$this->session->set_flashdata('message_failed',"Data Invoice Already Exist!");
					redirect('invoice');
				}
				else{
					
					$res = $this->model_invoice->insertData("master_invoice",$data_insert);
					if($res)
					{
						$data_last_invoice = $this->db->query("SELECT * FROM master_invoice WHERE invoice_number = '".$input_invoice_number."' ")->result_array();
						
						foreach($id_manifest as $key => $id_manifests) {
							
							$data_insert = array(						
								"id_invoice" => $data_last_invoice[0]['id_invoice'],
								"manifest_id" => $id_manifests,
								"delivery_date" => $delivery_date[$key],
								"trip" => $trip[$key],
								"origin" => $origin_id[$key],
								"destination" => $destination_id[$key],
								"amount_rate" => $rate[$key],
								"amount_client_rate" => $client_rate[$key]
							);
							$res = $this->model_invoice->insertData("detail_master_invoice",$data_insert);
							
							if($res)
							{
									$this->session->set_flashdata('message_success',"Data Invoice has been successfully updated!");
									redirect('invoice');
								}
							else{
								
									$this->session->set_flashdata('message_failed',"Data Invoice failed to update!");
									redirect('invoice');
								}
							
						}
						
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
	
	public function deleteInvoiceAll()
	{
		
			date_default_timezone_set('Asia/Jakarta');
			ini_set('memory_limit', '-1');
			
			if ($this->tank_auth->is_logged_in()) {
			$user	= $this->tank_auth->get_username();
			$data_account = $this->model_account_master->getAccount("WHERE username = '".$user."' ")->result_array();
			$data_role = $this->model_account_master->getRole("WHERE id_role = '".$data_account[0]['user_access']."' ")->result_array();
			$user_role = $data_account[0]['user_type'];
			$code_role = $data_account[0]['code'];
			if($data_role[0]['delete_invoice']=='yes')
			{
				
			
				// Get Variable Post
				$id_invoice_delete = $_POST['id_invoice_delete_all'];
				
		
					//Update Product
					$res = $this->db->query("DELETE FROM master_invoice WHERE id_invoice in (".$id_invoice_delete.") ");
					if($res>=1)
					{
						$this->session->set_flashdata('message_success',"Data Invoice has been successfully deleted!");
						redirect('invoice');
						
						}
					else
					{
						$this->session->set_flashdata('message_failed',"Data Invoice failed to delete!");
						redirect('invoice');
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
	
	public function editInvoice()
	{
		
			date_default_timezone_set('Asia/Jakarta');
			ini_set('memory_limit', '-1');
			
			if ($this->tank_auth->is_logged_in()) {
			$user	= $this->tank_auth->get_username();
			$data_account = $this->model_account_master->getAccount("WHERE username = '".$user."' ")->result_array();
			$data_role = $this->model_account_master->getRole("WHERE id_role = '".$data_account[0]['user_access']."' ")->result_array();
			$user_role = $data_account[0]['user_type'];
			$code_role = $data_account[0]['code'];
			
			if($data_role[0]['edit_invoice']=='yes')
			{
				
			
				// Get Variable Post
				$status = $_POST['edit_status_invoice'];
				$id_invoice = $_POST['id_invoice_update'];
				
				$data_update = array(
				
				"status" => $status

				);
				
				$where = array("id_invoice"=>$id_invoice);
				
				
				
					//Update
					$res = $this->model_invoice->UpdateData("master_invoice",$data_update,$where);
					
					if($res>=1)
					{
						$this->session->set_flashdata('message_success',"Data Invoice has been successfully updated!");
						
						redirect('invoice');
						
						}
					else
					{
						$this->session->set_flashdata('message_failed',"Data Invoice failed to update!");
						redirect('invoice');
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
	
	
	public function deleteInvoice()
	{
		
			date_default_timezone_set('Asia/Jakarta');
			ini_set('memory_limit', '-1');
			
			if ($this->tank_auth->is_logged_in()) {
			$user	= $this->tank_auth->get_username();
			$data_account = $this->model_account_master->getAccount("WHERE username = '".$user."' ")->result_array();
			$data_role = $this->model_account_master->getRole("WHERE id_role = '".$data_account[0]['user_access']."' ")->result_array();
			$user_role = $data_account[0]['user_type'];
			$code_role = $data_account[0]['code'];
			if($data_role[0]['delete_invoice']=='yes')
			{
				
			
				// Get Variable Post
				$id_invoice_delete = $_POST['id_invoice_delete'];
				$where = array("id_invoice" => $id_invoice_delete);
				
		
					//Update Product
					$res = $this->model_invoice->DeleteData("master_invoice",$where);
					if($res>=1)
					{
						$this->session->set_flashdata('message_success',"Data Invoice has been successfully deleted!");
						redirect('invoice');
						
						}
					else
					{
						$this->session->set_flashdata('message_failed',"Data Invoice failed to delete!");
						redirect('invoice');
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
	
	public function exportInvoice()
	{
		
		date_default_timezone_set('Asia/Jakarta');
		if ($this->tank_auth->is_logged_in()) {
		$user	= $this->tank_auth->get_username();
		$data_account = $this->model_account_master->getAccount("WHERE username = '".$user."' ")->result_array();
		$data_role = $this->model_account_master->getRole("WHERE id_role = '".$data_account[0]['user_access']."' ")->result_array();
		$user_role = $data_account[0]['user_type'];
		$code_role = $data_account[0]['code'];
		
		if($data_role[0]['export_invoice']=='yes')
		{
		$search = isset($_GET['search']) ? $_GET['search'] : '';

		
		$date = date("m-d-Y");
		$this->db->like('description', $search);
		$this->db->or_like('category', $search);
		$query = $this->db->get('master_data_category');
		
		
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
		
		
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 1, "Master Invoice");
		//Merge And Center Title
		$objPHPExcel->getActiveSheet()->mergeCells('A1:D1');
		
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 2, "Date : ".$date);
		
		//Merge And Center Date
		$objPHPExcel->getActiveSheet()->mergeCells('A2:D2');
		
		//Set Font Color Title
		$objPHPExcel->getActiveSheet()->getStyle('A1:D2')->applyFromArray($FontstyleTitle);
		
		//Set Font Color Header
		$objPHPExcel->getActiveSheet()->getStyle('A4:D4')->applyFromArray($Fontstyle);
		
		//Set Backgroung Color Header
		$objPHPExcel->getActiveSheet()->getStyle('A4:D4')->applyFromArray(
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
		"ID" => "ID",
		"Category" => "Category",
		"Description" => "Description"
		
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
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $row, $data['id_invoice']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $row, $data['category']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $row, $data['description']);
 
            $row++;
			$no++;
        }
		
	   $last_row = $row-1;
	   //Set Border
       $objPHPExcel->getActiveSheet()->getStyle("A4".":"."D".$last_row)->applyFromArray($BStyle);
	   $objPHPExcel->getActiveSheet()->getStyle("A4".":"."D".$last_row)->applyFromArray($styleAlign);
       $objPHPExcel->setActiveSheetIndex(0);
 
        $objWriter = IOFactory::createWriter($objPHPExcel, 'Excel5');
 		
		
	   // Sending headers to force the user to download the file
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Master-data-category-'.$date.'.xls"');
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
	
	public function importInvoice()
	{
		
			date_default_timezone_set('Asia/Jakarta');
			ini_set('memory_limit', '-1');
			
			if ($this->tank_auth->is_logged_in()) {
			$user	= $this->tank_auth->get_username();
			$data_account = $this->model_account_master->getAccount("WHERE username = '".$user."' ")->result_array();
			$data_role = $this->model_account_master->getRole("WHERE id_role = '".$data_account[0]['user_access']."' ")->result_array();
			$user_role = $data_account[0]['user_type'];
			$code_role = $data_account[0]['code'];
			
			if($data_role[0]['import_invoice']=='yes')
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
					$check = $this->model_invoice->getInvoice("WHERE area_id  = '".$rowData[0][0]."' ");
					if($check->num_rows() >=1 )
					{
						
						$data_update = array(
							"area_description" => $rowData[0][1],
							"area_type" => $rowData[0][2]
							
						);
						$where = array(
							"area_id" => $rowData[0][0]
						);
						
						$res = $this->model_invoice->UpdateData("master_invoice",$data_update,$where);
					
						}
					else
					{
						$data_insert = array(
							"area_id" => $rowData[0][0],
							"area_description" => $rowData[0][1],
							"area_type" => $rowData[0][2]
						);
						
						//Insert Data
						$res = $this->model_invoice->insertData("master_invoice",$data_insert);
					
					}
					
				
				
			}
				@unlink($inputFileName);
				$this->session->set_flashdata('message_success','Data imported successfully');
				redirect('area');
			
               
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
	
	public function addInvoice()
	{
		
			date_default_timezone_set('Asia/Jakarta');
			ini_set('memory_limit', '-1');
			
			if ($this->tank_auth->is_logged_in()) {
			$user	= $this->tank_auth->get_username();
			$data_account = $this->model_account_master->getAccount("WHERE username = '".$user."' ")->result_array();
			$data_role = $this->model_account_master->getRole("WHERE id_role = '".$data_account[0]['user_access']."' ")->result_array();
			$user_role = $data_account[0]['user_type'];
			$code_role = $data_account[0]['code'];
			
			if($data_role[0]['add_invoice']=='yes')
			{
				
			
				// Get Variable Post
				$category = $_POST['category'];
				$description = $_POST['description'];
				
				
				$data_insert = array(
				
					"category" => $category,
					"description" => $description

				);
				
				//Check Product Apakah sudah ada dengan kode produk dan type motorist yang sama
				$check = $this->model_invoice->getInvoice("WHERE category = '".$category."' AND description = '".$description."' ");
				if($check->num_rows() >=1 )
				{
					$this->session->set_flashdata('message_failed',"Sorry data already exist!");
					redirect('master_data_category');
					
					}
				else
				{
					
					$res = $this->model_invoice->insertData("master_data_category",$data_insert);
					if($res>=1)
					{
						$this->session->set_flashdata('message_success',"Data Master Data Category has been successfully saved!");
						redirect('master_data_category');
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
			
			if($data_role[0]['see_invoice']=='yes')
			{	
			$this->load->library('table');
			$this->load->library('pagination');
			$search = isset($_GET['search']) ? $_GET['search'] : '';
			
			
			$jumlah= $this->model_invoice->countInvoice($search);
			
			if (count($_GET) > 0) $config['suffix'] = '?' . http_build_query($_GET, '', "&");
			$config['base_url'] = base_url().'index.php/invoice/invoice/';
			$config['total_rows'] = $jumlah;
			$config['first_link'] = 'First';
			$config['last_link'] = 'End';
			$config['next_link'] = 'Next';
			$config['prev_link'] = 'Previous';
			$config['per_page'] = 20; 	
			if (count($_GET) > 0) $config['suffix'] = '?' . http_build_query($_GET, '', "&");
			$config['first_url'] = $config['base_url'].'?'.http_build_query($_GET);
			
			$dari = $this->uri->segment('3');
			$data = $this->model_invoice->datainvoice($config['per_page'],$dari,$search);
			$this->pagination->initialize($config);
		
			$comp = array(
				'title' => ' Invoice',
				'content' => $this->load->view('invoice',array('data_invoice'=>$data,'data_role'=>$data_role,'search'=>$search),true),
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
	
	
	
	
	
	
	public function create_invoice()
	{
		
			date_default_timezone_set('Asia/Jakarta');
			if ($this->tank_auth->is_logged_in()) {
			$user	= $this->tank_auth->get_username();
			$data_account = $this->model_account_master->getAccount("WHERE username = '".$user."' ")->result_array();
			$data_role = $this->model_account_master->getRole("WHERE id_role = '".$data_account[0]['user_access']."' ")->result_array();
			$user_role = $data_account[0]['user_type'];
			$code_role = $data_account[0]['code'];
			
			if($data_role[0]['see_invoice']=='yes')
			{	
			
		
			$comp = array(
				'title' => ' Create Invoice',
				'content' => $this->load->view('create_invoice',array('data_role'=>$data_role),true),
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