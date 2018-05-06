<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pr extends CI_Controller {

	function __construct()  {
 		parent::__construct();
			$this->load->library(array('PHPExcel','PHPExcel/IOFactory'));
			$this->load->model('model_account_master');
			$this->load->model('model_pr');
			$this->load->library('tank_auth');
			
	}
	
	
	
	
	public function deletePrAll()
	{
			date_default_timezone_set('Asia/Jakarta');
			ini_set('memory_limit', '-1');
			
			if ($this->tank_auth->is_logged_in()) {
			$user	= $this->tank_auth->get_username();
			$data_account = $this->model_account_master->getAccount("WHERE username = '".$user."' ")->result_array();
			$data_role = $this->model_account_master->getRole("WHERE id_role = '".$data_account[0]['user_access']."' ")->result_array();
			$user_role = $data_account[0]['user_type'];
			$code_role = $data_account[0]['code'];
			if($data_role[0]['delete_pr']=='yes')
			{
				
			
				// Get Variable Prst
				$id_pr_delete = $_POST['id_pr_delete_all'];
				
		
					//Update Product
					$res = $this->db->query("DELETE FROM master_pr WHERE id_pr in (".$id_pr_delete.") ");
					if($res>=1)
					{
						$delete_product_pr = $this->db->query("DELETE FROM product_orders_pr WHERE id_pr = '".$id_pr_delete."' ");
							if($delete_product_pr)
							{
							$this->session->set_flashdata('message_success',"Data PR has been successfully deleted!");
							redirect('pr');
							}
							
						}
					else
					{
						$this->session->set_flashdata('message_failed',"Data PR failed to delete!");
						redirect('pr');
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
	
	public function editPr()
	{
		
			date_default_timezone_set('Asia/Jakarta');
			ini_set('memory_limit', '-1');
			
			if ($this->tank_auth->is_logged_in()) {
			$user	= $this->tank_auth->get_username();
			$data_account = $this->model_account_master->getAccount("WHERE username = '".$user."' ")->result_array();
			$data_role = $this->model_account_master->getRole("WHERE id_role = '".$data_account[0]['user_access']."' ")->result_array();
			$user_role = $data_account[0]['user_type'];
			$code_role = $data_account[0]['code'];
			
			if($data_role[0]['edit_pr']=='yes')
			{
				
				$timestamp = date('Y:m:d H:i:s');
				$username = $user;
				$request_date = explode('-',$_POST['edit_request_date']);
				$request_date = $request_date[2].'-'.$request_date[1].'-'.$request_date[0];
				$division = explode('*',$_POST['edit_division']);
				$division_code = $division[0];
				$division_name = $division[1];
				$description = $_POST['edit_description'];
				$id_pr = $_POST['id_pr_update'];
				
				$qty = $_POST['edit_qty'];
				$price = $_POST['edit_price'];
				$product_code = $_POST['edit_product_code'];
				$product_description = $_POST['edit_product_description'];
				$id_product = $_POST['edit_id_product'];
				
				$data_update = array(
				
					"request_date" => $request_date,
					"division_code" => $division_code,
					"division_name" => $division_name,
					"description" => $description,
					"updated_by" => $username,
					"updated_time" => $timestamp,

				);
				
				$where = array("id_pr"=>$id_pr);
				
				//Update
				$res = $this->model_pr->UpdateData("master_pr",$data_update,$where);
					
				if($res>=1)
				{
						$delete_product_pr = $this->db->query("DELETE FROM product_orders_pr WHERE id_pr = '".$id_pr."' ");
						if($delete_product_pr)
						{
							foreach( $id_product as $key => $id_products ) {

							$data_insert = array(						
								"id_product" => $id_products,
								"product_code" => $product_code[$key],
								"price" => $price[$key],
								"id_pr" => $id_pr,
								"product_name" => $product_description[$key],
								"qty" => $qty[$key]
							);
							$res = $this->model_pr->insertData("product_orders_pr",$data_insert);
							
							}
							
						$this->session->set_flashdata('message_success',"Data pr has been successfully updated!");
						redirect('pr');
						}
					}
				else
				{
					$this->session->set_flashdata('message_failed',"Data pr failed to update!");
					redirect('pr');
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
	
	
	public function deletePr()
	{
		
			date_default_timezone_set('Asia/Jakarta');
			ini_set('memory_limit', '-1');
			
			if ($this->tank_auth->is_logged_in()) {
			$user	= $this->tank_auth->get_username();
			$data_account = $this->model_account_master->getAccount("WHERE username = '".$user."' ")->result_array();
			$data_role = $this->model_account_master->getRole("WHERE id_role = '".$data_account[0]['user_access']."' ")->result_array();
			$user_role = $data_account[0]['user_type'];
			$code_role = $data_account[0]['code'];
			if($data_role[0]['delete_pr']=='yes')
			{
				
			
				// Get Variable Prst
				$id_pr_delete = $_POST['id_pr_delete'];
				echo $id_pr_delete;
				$where = array("id_pr" => $id_pr_delete);
				
		
					//Update Product
					$res = $this->model_pr->DeleteData("master_pr",$where);
					if($res>=1)
					{
						$delete_product_pr = $this->db->query("DELETE FROM product_orders_pr WHERE id_pr = '".$id_pr_delete."' ");
						if($delete_product_pr)
						{
							$this->session->set_flashdata('message_success',"Data pr has been successfully deleted!");
							redirect('pr');
						}
						}
					else
					{
						$this->session->set_flashdata('message_failed',"Data pr failed to delete!");
						redirect('pr');
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
	
	public function exprrtPr()
	{
		
		date_default_timezone_set('Asia/Jakarta');
		if ($this->tank_auth->is_logged_in()) {
		$user	= $this->tank_auth->get_username();
		$data_account = $this->model_account_master->getAccount("WHERE username = '".$user."' ")->result_array();
		$data_role = $this->model_account_master->getRole("WHERE id_role = '".$data_account[0]['user_access']."' ")->result_array();
		$user_role = $data_account[0]['user_type'];
		$code_role = $data_account[0]['code'];
		
		if($data_role[0]['exprrt_pr']=='yes')
		{
		$search = isset($_GET['search']) ? $_GET['search'] : '';
		
		$date = date("m-d-Y");
		$this->db->or_like('pr_code', $search);
		$this->db->or_like('pr_name', $search);
		
		$query = $this->db->get('pr');
        if(!$query)
        return false;
 
        // Starting the PHPExcel library
        $this->load->library('PHPExcel');
        $this->load->library('PHPExcel/IOFactory');
 
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setTitle("exprrt")->setDescription("none");
		
 
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
		
		
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 1, "Master Pr");
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
		"pr_code" => "pr_code",
		"pr_name" => "pr_name",
		"address_1" => "address_1",
		"address_2" => "address_2",
		"pr_type" => "pr_type",
		"city" => "city",
		"prstal_code" => "prstal_code",
		"phone" => "phone",
		"fax" => "fax",
		"pic" => "pic",
		"email" => "email"
		
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
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $row, $data['pr_code']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $row, $data['pr_name']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $row, $data['address_1']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $row, $data['address_2']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, $row, $data['pr_type']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, $row, $data['city']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, $row, $data['prstal_code']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8, $row, $data['phone']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9, $row, $data['fax']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(10, $row, $data['pic']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(11, $row, $data['email']);
 
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
        header('Content-Disprsition: attachment;filename="Master-pr-'.$date.'.xls"');
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
	
	public function imprrtPr()
	{
		
			date_default_timezone_set('Asia/Jakarta');
			ini_set('memory_limit', '-1');
			
			if ($this->tank_auth->is_logged_in()) {
			$user	= $this->tank_auth->get_username();
			$data_account = $this->model_account_master->getAccount("WHERE username = '".$user."' ")->result_array();
			$timestamp = date('Y:m:d H:i:s');
			$username = $user;
			$data_role = $this->model_account_master->getRole("WHERE id_role = '".$data_account[0]['user_access']."' ")->result_array();
			$user_role = $data_account[0]['user_type'];
			$code_role = $data_account[0]['code'];
			
			if($data_role[0]['imprrt_pr']=='yes')
			{
				
				
			if ($_POST) {
			ini_set('memory_limit', '-1');
		    $fileName = $_FILES['imprrt_file']['name'];
			$config['upload_path'] = './files/';
			$config['file_name'] = $fileName;
			$config['allowed_types'] = 'xls|xlsx';
			$config['max_size']		= 100000000;

			$this->load->library('upload');
			$this->upload->initialize($config);

			if(! $this->upload->do_upload('imprrt_file') )
			{
				$this->session->set_flashdata('message_failed','Imprrt Failed, Please upload file excel extension!');
				redirect('pr');
				
				
			}
			else
			{

			$media = $this->upload->data('imprrt');
			
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
					$check = $this->model_pr->getPr("WHERE pr_code  = '".$rowData[0][0]."' ");
					if($check->num_rows() >=1 )
					{
						
						
						$data_update = array(
							"pr_name" => $rowData[0][1],
							"address_1" => $rowData[0][2],
							"address_2" => $rowData[0][3],
							"pr_type" => $rowData[0][4],
							"city" => $rowData[0][5],
							"prstal_code" => $rowData[0][6],
							"phone" => $rowData[0][7],
							"fax" => $rowData[0][8],
							"pic" => $rowData[0][9],
							"email" => $rowData[0][10],
							"updated_by" => $username,
							"updated_time" => $timestamp
									
							
							
						);
						$where = array(
							"pr_code" => $rowData[0][0]
						);
						
						$res = $this->model_pr->UpdateData("pr",$data_update,$where);
					
						}
					else
					{
						$data_insert = array(
							"pr_code" => $rowData[0][0],
							"pr_name" => $rowData[0][1],
							"address_1" => $rowData[0][2],
							"address_2" => $rowData[0][3],
							"pr_type" => $rowData[0][4],
							"city" => $rowData[0][5],
							"prstal_code" => $rowData[0][6],
							"phone" => $rowData[0][7],
							"fax" => $rowData[0][8],
							"pic" => $rowData[0][9],
							"email" => $rowData[0][10],
							"created_by" => $username,
							"created_time" => $timestamp
						);
						
						//Insert Data
						$res = $this->model_pr->insertData("pr",$data_insert);
					
					}
					
				
				
			}
				@unlink($inputFileName);
				$this->session->set_flashdata('message_success','Data imprrted successfully');
				redirect('pr');
			
               
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
	
	public function addPr()
	{
		
			date_default_timezone_set('Asia/Jakarta');
			ini_set('memory_limit', '-1');
			$timestamp = date('Y:m:d H:i:s');
			if ($this->tank_auth->is_logged_in()) {
			$user	= $this->tank_auth->get_username();
			$data_account = $this->model_account_master->getAccount("WHERE username = '".$user."' ")->result_array();
			$data_role = $this->model_account_master->getRole("WHERE id_role = '".$data_account[0]['user_access']."' ")->result_array();
			$user_role = $data_account[0]['user_type'];
			$code_role = $data_account[0]['code'];
			
			if($data_role[0]['add_pr']=='yes')
			{
				// Get Variable Prst
				$timestamp = date('Y:m:d H:i:s');
				$username = $user;
				$request_date = explode('-',$_POST['request_date']);
				$request_date = $request_date[2].'-'.$request_date[1].'-'.$request_date[0];
				$division = explode('*',$_POST['division']);
				$division_code = $division[0];
				$division_name = $division[1];
				$description = $_POST['description'];
				
				$qty = $_POST['qty'];
				$price = $_POST['price'];
				$product_code = $_POST['product_code'];
				$product_description = $_POST['product_description'];
				$id_product = $_POST['id_product'];
				
				$data_insert = array(
					"request_date" => $request_date,
					"division_code" => $division_code,
					"division_name" => $division_name,
					"description" => $description,
					"status_pr" => 'new',
					"created_by" => $username,
					"created_time" => $timestamp,
				);
				
				//Check Product Apakah sudah ada dengan kode produk dan type motorist yang sama
				$res = $this->model_pr->insertData("master_pr",$data_insert);
				if($res>=1)
				{
					
					$data_pr = $this->db->query("SELECT * FROM master_pr WHERE created_by = '".$username."' AND division_name = '".$division_name."' ORDER BY id_pr DESC ")->result_array();
					$last_id_pr = $data_pr[0]['id_pr'];
					foreach( $id_product as $key => $id_products ) {

						$data_insert = array(						
							"id_product" => $id_products,
							"product_code" => $product_code[$key],
							"price" => $price[$key],
							"id_pr" => $last_id_pr,
							"product_name" => $product_description[$key],
							"qty" => $qty[$key]
						);
						$res = $this->model_pr->insertData("product_orders_pr",$data_insert);
						
						}
						
						$this->session->set_flashdata('message_success',"Data PR has been successfully saved!");
						redirect('pr');
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
			
			if($data_role[0]['see_pr']=='yes')
			{	
			$this->load->library('table');
			$this->load->library('pagination');
			$search = isset($_GET['search']) ? $_GET['search'] : '';
			
			
			$jumlah= $this->model_pr->countPr($search);
			
			if (count($_GET) > 0) $config['suffix'] = '?' . http_build_query($_GET, '', "&");
			$config['base_url'] = base_url().'index.php/Pr/pr/';
			$config['total_rows'] = $jumlah;
			$config['first_link'] = 'First';
			$config['last_link'] = 'End';
			$config['next_link'] = 'Next';
			$config['prev_link'] = 'Previous';
			$config['per_page'] = 5; 	
			if (count($_GET) > 0) $config['suffix'] = '?' . http_build_query($_GET, '', "&");
			$config['first_url'] = $config['base_url'].'?'.http_build_query($_GET);
			
			$dari = $this->uri->segment('3');
			$data = $this->model_pr->dataPr($config['per_page'],$dari,$search);
			
			$data_division = $this->db->query("SELECT * FROM division")->result();
			
		
			$comp = array(
				'title' => ' Pr',
				'content' => $this->load->view('pr',array('data_division'=>$data_division,'data_pr'=>$data,'data_role'=>$data_role,'search'=>$search),true),
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
	
	
	
	
	public function exportPr()
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
		
		$this->db->or_like('division_name', $search);
		$this->db->or_like('id_pr', $search);
		$query = $this->db->get('master_pr');
		
		
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
		
		
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 1, "Master PR");
		//Merge And Center Title
		$objPHPExcel->getActiveSheet()->mergeCells('A1:D1');
		
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 2, "Date : ".$date);
		
		//Merge And Center Date
		$objPHPExcel->getActiveSheet()->mergeCells('A2:D2');
		
		//Set Font Color Title
		$objPHPExcel->getActiveSheet()->getStyle('A1:D2')->applyFromArray($FontstyleTitle);
		
		//Set Font Color Header
		$objPHPExcel->getActiveSheet()->getStyle('A4:J4')->applyFromArray($Fontstyle);
		
		//Set Backgroung Color Header
		$objPHPExcel->getActiveSheet()->getStyle('A4:J4')->applyFromArray(
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
		"Request Date" => "Request Date",
		"Division Code" => "Division Code",
		"Division Name" => "Division Name",
		"Description" => "Description",
		"Status PR" => "Status PR",
		"Created By" => "Created By",
		"Created Time" => "Created Time",
		"Updated By" => "Updated By",
		"Updated Time" => "Updated Time"
		
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
			$request_date = explode('-',$data['request_date']);
			$request_date = $request_date[2].'-'.$request_date[1].'-'.$request_date[0];
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $row, $request_date);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $row, $data['division_code']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $row, $data['division_name']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $row, $data['status_pr']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, $row, $data['description']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, $row, $data['created_by']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, $row, $data['created_time']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8, $row, $data['updated_by']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9, $row, $data['updated_time']);
 
            $row++;
			$no++;
        }
		
	   $last_row = $row-1;
	   //Set Border
       $objPHPExcel->getActiveSheet()->getStyle("A4".":"."J".$last_row)->applyFromArray($BStyle);
	   $objPHPExcel->getActiveSheet()->getStyle("A4".":"."J".$last_row)->applyFromArray($styleAlign);
       $objPHPExcel->setActiveSheetIndex(0);
 
        $objWriter = IOFactory::createWriter($objPHPExcel, 'Excel5');
 		
		
	   // Sending headers to force the user to download the file
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Master-pr-'.$date.'.xls"');
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