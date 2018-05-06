<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Po extends CI_Controller {

	function __construct()  {
 		parent::__construct();
			$this->load->library(array('PHPExcel','PHPExcel/IOFactory'));
			$this->load->model('model_account_master');
			$this->load->model('model_po');
			$this->load->library('tank_auth');
			
	}
	
	
	
	
	public function deletePoAll()
	{
			date_default_timezone_set('Asia/Jakarta');
			ini_set('memory_limit', '-1');
			
			if ($this->tank_auth->is_logged_in()) {
			$user	= $this->tank_auth->get_username();
			$data_account = $this->model_account_master->getAccount("WHERE username = '".$user."' ")->result_array();
			$data_role = $this->model_account_master->getRole("WHERE id_role = '".$data_account[0]['user_access']."' ")->result_array();
			$user_role = $data_account[0]['user_type'];
			$code_role = $data_account[0]['code'];
			if($data_role[0]['delete_po']=='yes')
			{
				
			
				// Get Variable Post
				$id_po_delete = $_POST['id_po_delete_all'];
				
		
					//Update Product
					$res = $this->db->query("DELETE FROM master_po WHERE id_po in (".$id_po_delete.") ");
					$res = $this->db->query("DELETE FROM product_orders_po WHERE id_po in (".$id_po_delete.") ");
					if($res>=1)
					{
						$this->session->set_flashdata('message_success',"Data po has been successfully deleted!");
						redirect('po');
						
						}
					else
					{
						$this->session->set_flashdata('message_failed',"Data po failed to delete!");
						redirect('po');
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
	
	public function editPo()
	{
		
			date_default_timezone_set('Asia/Jakarta');
			ini_set('memory_limit', '-1');
			
			if ($this->tank_auth->is_logged_in()) {
			$user	= $this->tank_auth->get_username();
			$data_account = $this->model_account_master->getAccount("WHERE username = '".$user."' ")->result_array();
			$data_role = $this->model_account_master->getRole("WHERE id_role = '".$data_account[0]['user_access']."' ")->result_array();
			$user_role = $data_account[0]['user_type'];
			$code_role = $data_account[0]['code'];
			
			if($data_role[0]['edit_po']=='yes')
			{
				
				$timestamp = date('Y:m:d H:i:s');
				$username = $user;
				$id_po = $_POST['edit_id_po'];
				$id_pr = $_POST['edit_id_pr'];
				$request_date = explode('-',$_POST['edit_request_date']);
				$request_date = $request_date[2].'-'.$request_date[1].'-'.$request_date[0];
				$po_status = $_POST['edit_po_status'];
				$supplier_code = $_POST['edit_supplier_code'];
				$po_name = $_POST['edit_supplier_name'];
				$supplier_address = $_POST['edit_supplier_address'];
				$warehouse_code = $_POST['edit_warehouse_code'];
				$order_description = $_POST['edit_order_description'];
				$supplier_do = $_POST['edit_supplier_do'];
				$po_date = explode('-',$_POST['edit_po_date']);
				$po_date = $po_date[2].'-'.$po_date[1].'-'.$po_date[0];
				
				
				$qty = $_POST['qty'];
				$price = $_POST['price'];
				$product_code = $_POST['product_code'];
				$product_description = $_POST['product_description'];
				$id_product = $_POST['id_product'];
				$custom_price = $_POST['custom_price'];
				$status_po = $_POST['status_po'];
				$qty_approve = $_POST['qty_approve'];
				
				
				
				$data_update = array(
				
					"create_po_date" => $po_date,
					"request_date" => $request_date,
					"supplier_code" => $supplier_code,
					"warehouse_code" => $warehouse_code,
					"order_type" => $order_description,
					"status" => $po_status,
					"supplier_do" => $supplier_do,
					"created_by" => $user,
					"created_time" => $timestamp

				);
				
				$where = array("id_po"=>$id_po);
				
					//Update
				$res = $this->model_po->UpdateData("master_po",$data_update,$where);
					
				if($res>=1)
				{
						$delete_product_po = $this->db->query("DELETE FROM product_orders_po WHERE id_po = '".$id_po."' ");
						if($delete_product_po)
						{
							
							foreach( $id_product as $key => $id_products ) {

								$data_insert = array(						
									"id_product" => $id_products,
									"product_code" => $product_code[$key],
									"price" => $price[$key],
									"custom_price" => $custom_price[$key],
									"id_pr" => $id_pr,
									"id_po" => $id_po,
									"status_approved" => $status_po[$key],
									"product_name" => $product_description[$key],
									"qty" => $qty[$key],
									"qty_approve" => $qty_approve[$key],
								);
								$res = $this->model_po->insertData("product_orders_po",$data_insert);
								
								}
							
						$this->session->set_flashdata('message_success',"Data PO has been successfully updated!");
						redirect('po');
						}
					}
				else
				{
					$this->session->set_flashdata('message_failed',"Data pr failed to update!");
					redirect('po');
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
	
	
	public function deletePo()
	{
		
			date_default_timezone_set('Asia/Jakarta');
			ini_set('memory_limit', '-1');
			
			if ($this->tank_auth->is_logged_in()) {
			$user	= $this->tank_auth->get_username();
			$data_account = $this->model_account_master->getAccount("WHERE username = '".$user."' ")->result_array();
			$data_role = $this->model_account_master->getRole("WHERE id_role = '".$data_account[0]['user_access']."' ")->result_array();
			$user_role = $data_account[0]['user_type'];
			$code_role = $data_account[0]['code'];
			if($data_role[0]['delete_po']=='yes')
			{
				
			
				// Get Variable Post
				$id_po_delete = $_POST['id_po_delete'];
				$where = array("id_po" => $id_po_delete);
				
		
					//Update Product
					$res = $this->model_po->DeleteData("master_po",$where);
					if($res>=1)
					{
						$res = $this->db->query("DELETE FROM product_orders_po WHERE id_po = '".$id_po_delete."' ");
						$this->session->set_flashdata('message_success',"Data po has been successfully deleted!");
						redirect('po');
						
						}
					else
					{
						$this->session->set_flashdata('message_failed',"Data po failed to delete!");
						redirect('po');
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
	
	public function exportPo()
	{
		
		date_default_timezone_set('Asia/Jakarta');
		if ($this->tank_auth->is_logged_in()) {
		$user	= $this->tank_auth->get_username();
		$data_account = $this->model_account_master->getAccount("WHERE username = '".$user."' ")->result_array();
		$data_role = $this->model_account_master->getRole("WHERE id_role = '".$data_account[0]['user_access']."' ")->result_array();
		$user_role = $data_account[0]['user_type'];
		$code_role = $data_account[0]['code'];
		
		if($data_role[0]['export_po']=='yes')
		{
		$search = isset($_GET['search']) ? $_GET['search'] : '';
		
		$date = date("m-d-Y");
		$this->db->or_like('id_po', $search);
		$query = $this->db->get('master_po');
		
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
		
		
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 1, "Master Po");
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
		"ID PO" => "ID PO",
		"Reference" => "Reference",
		"Created PO Date" => "Created PO Date",
		"Requested Date" => "Requested Date",
		"Supplier" => "Supplier",
		"Status" => "Status",
		"Warehouse Code" => "Warehouse Code",
		"Order Type" => "Order Type",
		"Supplier DO" => "Supplier DO",
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
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $row, $data['id_po']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $row, $data['reference']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $row, $data['request_date']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $row, $data['create_po_date']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, $row, $data['po_code']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, $row, $data['status']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, $row, $data['warehouse_code']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8, $row, $data['order_type']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9, $row, $data['po_do']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(10, $row, $data['created_by']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(11, $row, $data['created_time']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(12, $row, $data['updated_by']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(13, $row, $data['updated_time']);
 
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
        header('Content-Disposition: attachment;filename="Master-po-'.$date.'.xls"');
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
	
	public function importPo()
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
			
			if($data_role[0]['import_po']=='yes')
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
				redirect('po');
				
				
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
					$check = $this->model_po->getPo("WHERE po_code  = '".$rowData[0][0]."' ");
					if($check->num_rows() >=1 )
					{
						
						
						$data_update = array(
							"po_name" => $rowData[0][1],
							"address_1" => $rowData[0][2],
							"address_2" => $rowData[0][3],
							"po_type" => $rowData[0][4],
							"city" => $rowData[0][5],
							"postal_code" => $rowData[0][6],
							"phone" => $rowData[0][7],
							"fax" => $rowData[0][8],
							"pic" => $rowData[0][9],
							"email" => $rowData[0][10],
							"updated_by" => $username,
							"updated_time" => $timestamp
									
							
							
						);
						$where = array(
							"po_code" => $rowData[0][0]
						);
						
						$res = $this->model_po->UpdateData("po",$data_update,$where);
					
						}
					else
					{
						$data_insert = array(
							"po_code" => $rowData[0][0],
							"po_name" => $rowData[0][1],
							"address_1" => $rowData[0][2],
							"address_2" => $rowData[0][3],
							"po_type" => $rowData[0][4],
							"city" => $rowData[0][5],
							"postal_code" => $rowData[0][6],
							"phone" => $rowData[0][7],
							"fax" => $rowData[0][8],
							"pic" => $rowData[0][9],
							"email" => $rowData[0][10],
							"created_by" => $username,
							"created_time" => $timestamp
						);
						
						//Insert Data
						$res = $this->model_po->insertData("po",$data_insert);
					
					}
					
				
				
			}
				@unlink($inputFileName);
				$this->session->set_flashdata('message_success','Data imported successfully');
				redirect('po');
			
               
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
	
	public function addPo()
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
			
			if($data_role[0]['add_po']=='yes')
			{
				
			
				// Get Variable Prst
				$timestamp = date('Y:m:d H:i:s');
				$username = $user;
				$request_date = explode('-',$_POST['request_date']);
				$request_date = $request_date[2].'-'.$request_date[1].'-'.$request_date[0];
				$id_pr = $_POST['id_pr'];
				$supplier_code = $_POST['supplier_code'];
				$po_name = $_POST['supplier_name'];
				$supplier_address = $_POST['supplier_address'];
				$warehouse_code = $_POST['warehouse_code'];
				$order_description = $_POST['order_description'];
				$supplier_do = $_POST['supplier_do'];
				$po_date = explode('-',$_POST['po_date']);
				$po_date = $po_date[2].'-'.$po_date[1].'-'.$po_date[0];
				
				
				
				print_r($qty);
				$qty = $_POST['qty'];
				$price = $_POST['price'];
				$product_code = $_POST['product_code'];
				$product_description = $_POST['product_description'];
				$id_product = $_POST['id_product'];
				$custom_price = $_POST['custom_price'];
				
				
				$data_insert = array(
					"reference" => $id_pr,
					"create_po_date" => $po_date,
					"request_date" => $request_date,
					"supplier_code" => $supplier_code,
					"warehouse_code" => $warehouse_code,
					"order_type" => $order_description,
					"status" => "new",
					"status_gr" => "new",
					"supplier_do" => $supplier_do,
					"created_by" => $user,
					"created_time" => $timestamp
				);
				$res = $this->model_po->insertData("master_po",$data_insert);
				if($res>=1)
				{
					$data_po = $this->db->query("SELECT * FROM master_po WHERE created_by = '".$username."'  AND reference = '".$id_pr."' ORDER BY id_po DESC ")->result_array();
					$update_po = $this->db->query("UPDATE master_pr SET status_pr = 'po_created' WHERE id_pr = '".$id_pr."' ");
					$last_id_po  = $data_po[0]['id_po'];
					
					foreach( $id_product as $key => $id_products ) {

						$data_insert = array(						
							"id_product" => $id_products,
							"product_code" => $product_code[$key],
							"price" => $price[$key],
							"custom_price" => $custom_price[$key],
							"id_pr" => $id_pr,
							"id_po" => $last_id_po,
							"status_approved" => "new",
							"product_name" => $product_description[$key],
							"qty" => $qty[$key]
						);
						$res = $this->model_po->insertData("product_orders_po",$data_insert);
						
						}
						
						$this->session->set_flashdata('message_success',"Data PO has been successfully saved!");
						redirect('po');
					
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
	
	
	public function index()
	{
		
			date_default_timezone_set('Asia/Jakarta');
			
			
			
			if ($this->tank_auth->is_logged_in()) {
			$user	= $this->tank_auth->get_username();
			$data_account = $this->model_account_master->getAccount("WHERE username = '".$user."' ")->result_array();
			$data_role = $this->model_account_master->getRole("WHERE id_role = '".$data_account[0]['user_access']."' ")->result_array();
			$user_role = $data_account[0]['user_type'];
			$code_role = $data_account[0]['code'];
			
			if($data_role[0]['see_po']=='yes')
			{	
			$this->load->library('table');
			$this->load->library('pagination');
			$search = isset($_GET['search']) ? $_GET['search'] : '';
			
			
			$jumlah= $this->model_po->countPo($search);
			
			if (count($_GET) > 0) $config['suffix'] = '?' . http_build_query($_GET, '', "&");
			$config['base_url'] = base_url().'index.php/Po/po/';
			$config['total_rows'] = $jumlah;
			$config['first_link'] = 'First';
			$config['last_link'] = 'End';
			$config['next_link'] = 'Next';
			$config['prev_link'] = 'Previous';
			$config['per_page'] = 5; 	
			if (count($_GET) > 0) $config['suffix'] = '?' . http_build_query($_GET, '', "&");
			$config['first_url'] = $config['base_url'].'?'.http_build_query($_GET);
			
			$dari = $this->uri->segment('3');
			$data = $this->model_po->dataPo($config['per_page'],$dari,$search);
			
		
			$comp = array(
				'title' => ' Po',
				'content' => $this->load->view('po',array('data_po'=>$data,'data_role'=>$data_role,'search'=>$search),true),
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