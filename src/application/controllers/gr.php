<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Gr extends CI_Controller {

	function __construct()  {
 		parent::__construct();
			$this->load->library(array('PHPExcel','PHPExcel/IOFactory'));
			$this->load->model('model_account_master');
			$this->load->model('model_gr');
			$this->load->library('tank_auth');
			
	}
	
	
	
	
	
	
	public function editGr()
	{
		
			date_default_timezone_set('Asia/Jakarta');
			ini_set('memory_limit', '-1');
			
			if ($this->tank_auth->is_logged_in()) {
			$user	= $this->tank_auth->get_username();
			$data_account = $this->model_account_master->getAccount("WHERE username = '".$user."' ")->result_array();
			$data_role = $this->model_account_master->getRole("WHERE id_role = '".$data_account[0]['user_access']."' ")->result_array();
			$user_role = $data_account[0]['user_type'];
			$code_role = $data_account[0]['code'];
			
			if($data_role[0]['edit_gr']=='yes')
			{
				// Get Variable Prst
				$timestamp = date('Y:m:d H:i:s');
				$username = $user;
				$id_gr = $_POST['id_gr_update'];
				$id_po = $_POST['edit_id_po'];
				$gr_date = explode('-',$_POST['edit_gr_date']);
				$gr_date = $gr_date[2].'-'.$gr_date[1].'-'.$gr_date[0];
				$remark = $_POST['edit_remark'];
				
				$id_product = $_POST['id_product'];
				$product_code = $_POST['product_code'];
				$description = $_POST['description'];
				$qty = $_POST['qty'];
				$qty_received = $_POST['qty_received'];
				$price = $_POST['price'];
				$location = $_POST['location'];
				
				//kembalikan_stock_dulu
				$data_product_orders_gr = $this->db->query("SELECT * FROM product_orders_gr WHERE id_gr = '".$id_gr."' ")->result();
				foreach($data_product_orders_gr as $data_product_orders_gr) {	
					$res = $this->db->query("UPDATE inventory_list SET stock = stock - '".$data_product_orders_gr->qty_received."' WHERE id_product = '".$data_product_orders_gr->id_product."' AND id_location = '".$data_product_orders_gr->id_location."' ");
				}
				
				//update_gr_product
				foreach( $id_product as $key => $id_products ) {
					
							$data_update = array(	
								"id_location" => $location[$key],
								"qty_received" => $qty_received[$key]
							);
							
							$where = array(						
								"id_product" => $id_products,
								"id_gr" => $id_gr
							);
							
							
							$res = $this->model_gr->UpdateData("product_orders_gr",$data_update,$where);
					
					$res = $this->db->query("UPDATE inventory_list SET stock = stock + '".$qty_received[$key]."' WHERE id_product = '".$id_products."' AND id_location = '".$location[$key]."' ");
				}
				
				//update_gr
				
							$data_update = array(	
								"gr_date" => $gr_date,
								"remark" => $remark,
								"updated_by" => $username,
								"updated_date" => $timestamp
							);
							
							$where = array(				
								"id_gr" => $id_gr
							);
							
							
							$res = $this->model_gr->UpdateData("gr",$data_update,$where);
				
				$this->session->set_flashdata('message_success',"Data Gr has been successfully saved!");
						redirect('gr');
				
			
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
	
	
	public function deleteGr()
	{
		
			date_default_timezone_set('Asia/Jakarta');
			ini_set('memory_limit', '-1');
			
			if ($this->tank_auth->is_logged_in()) {
			$user	= $this->tank_auth->get_username();
			$data_account = $this->model_account_master->getAccount("WHERE username = '".$user."' ")->result_array();
			$data_role = $this->model_account_master->getRole("WHERE id_role = '".$data_account[0]['user_access']."' ")->result_array();
			$user_role = $data_account[0]['user_type'];
			$code_role = $data_account[0]['code'];
			if($data_role[0]['delete_gr']=='yes')
			{
				
			
				// Get Variable Post
				$id_gr_delete = $_POST['id_gr_delete'];
				$id_po_delete = $_POST['id_po_delete'];
				
				$where = array("id_gr" => $id_gr_delete);
				
				
				$data_product_orders_gr = $this->db->query("SELECT * FROM product_orders_gr WHERE id_gr = '".$id_gr_delete."' ")->result();
				foreach($data_product_orders_gr as $data_product_orders_gr) {
					
				$res = $this->db->query("UPDATE inventory_list SET stock = stock - '".$data_product_orders_gr->qty_received."' WHERE id_product = '".$data_product_orders_gr->id_product."' AND id_location = '".$data_product_orders_gr->id_location."' ");
					
				}
		
					//Update Product
					$res = $this->db->query("update master_po SET status_gr = 'new' WHERE id_po = '".$id_po_delete."' ");
					$res = $this->model_gr->DeleteData("gr",$where);
					$res = $this->model_gr->DeleteData("product_orders_gr",$where);
					if($res>=1)
					{
						$this->session->set_flashdata('message_success',"Data gr has been successfully deleted!");
						redirect('gr');
						
					}
					else
					{
						$this->session->set_flashdata('message_failed',"Data gr failed to delete!");
						redirect('gr');
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
	
	public function exportSupplier()
	{
		
		date_default_timezone_set('Asia/Jakarta');
		if ($this->tank_auth->is_logged_in()) {
		$user	= $this->tank_auth->get_username();
		$data_account = $this->model_account_master->getAccount("WHERE username = '".$user."' ")->result_array();
		$data_role = $this->model_account_master->getRole("WHERE id_role = '".$data_account[0]['user_access']."' ")->result_array();
		$user_role = $data_account[0]['user_type'];
		$code_role = $data_account[0]['code'];
		
		if($data_role[0]['export_supplier']=='yes')
		{
		$search = isset($_GET['search']) ? $_GET['search'] : '';
		
		$date = date("m-d-Y");
		$this->db->or_like('supplier_code', $search);
		$this->db->or_like('supplier_name', $search);
		
		$query = $this->db->get('supplier');
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
		
		
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 1, "Master Supplier");
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
		"supplier_code" => "supplier_code",
		"supplier_name" => "supplier_name",
		"address_1" => "address_1",
		"address_2" => "address_2",
		"supplier_type" => "supplier_type",
		"city" => "city",
		"postal_code" => "postal_code",
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
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $row, $data['supplier_code']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $row, $data['supplier_name']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $row, $data['address_1']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $row, $data['address_2']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, $row, $data['supplier_type']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, $row, $data['city']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, $row, $data['postal_code']);
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
        header('Content-Disposition: attachment;filename="Master-supplier-'.$date.'.xls"');
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
	
	public function importSupplier()
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
			
			if($data_role[0]['import_supplier']=='yes')
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
				redirect('supplier');
				
				
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
					$check = $this->model_gr->getSupplier("WHERE supplier_code  = '".$rowData[0][0]."' ");
					if($check->num_rows() >=1 )
					{
						
						
						$data_update = array(
							"supplier_name" => $rowData[0][1],
							"address_1" => $rowData[0][2],
							"address_2" => $rowData[0][3],
							"supplier_type" => $rowData[0][4],
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
							"supplier_code" => $rowData[0][0]
						);
						
						$res = $this->model_gr->UpdateData("supplier",$data_update,$where);
					
						}
					else
					{
						$data_insert = array(
							"supplier_code" => $rowData[0][0],
							"supplier_name" => $rowData[0][1],
							"address_1" => $rowData[0][2],
							"address_2" => $rowData[0][3],
							"supplier_type" => $rowData[0][4],
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
						$res = $this->model_gr->insertData("supplier",$data_insert);
					
					}
					
				
				
			}
				@unlink($inputFileName);
				$this->session->set_flashdata('message_success','Data imported successfully');
				redirect('supplier');
			
               
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
	
	public function addGr()
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
			
			if($data_role[0]['add_gr']=='yes')
			{
				
			
				// Get Variable Prst
				$timestamp = date('Y:m:d H:i:s');
				$username = $user;
				$id_po = $_POST['id_po'];
				$gr_date = explode('-',$_POST['gr_date']);
				$gr_date = $gr_date[2].'-'.$gr_date[1].'-'.$gr_date[0];
				$remark = $_POST['remark'];
				
				
				
				$id_product = $_POST['id_product'];
				$product_code = $_POST['product_code'];
				$description = $_POST['description'];
				$qty = $_POST['qty'];
				$qty_received = $_POST['qty_received'];
				$price = $_POST['price'];
				$location = $_POST['location'];
				
				
				$data_insert = array(
					"id_po" => $id_po,
					"gr_date" => $gr_date,
					"status_putaway" => 'new',
					"remark" => $remark,
					"created_by" => $username,
					"created_date" => $timestamp
				);
				
				$res = $this->model_gr->insertData("gr",$data_insert);
				
				if($res>=1)
				{
					$data_gr = $this->db->query("SELECT * FROM gr WHERE created_by = '".$username."'  AND id_po = '".$id_po."' ORDER BY id_gr DESC ")->result_array();
					$update_po = $this->db->query("UPDATE master_po SET status_gr = 'gr_created' WHERE id_po = '".$id_po."' ");
					$last_id_gr  = $data_gr[0]['id_gr'];
					
					foreach( $id_product as $key => $id_products ) {

					
					
							$data_insert = array(						
								"id_product" => $id_products,
								"product_code" => $product_code[$key],
								"price" => $price[$key],
								"id_gr" => $last_id_gr,
								"product_name" => $description[$key],
								"qty" => $qty[$key],
								"id_location" => $location[$key],
								"qty_received" => $qty_received[$key]
							);
							$res = $this->model_gr->insertData("product_orders_gr",$data_insert);
							
							
							//Check Inventory List
							$select_inventory_list = $this->db->query("SELECT * FROM inventory_list WHERE id_product = '".$id_products."' AND id_location = '".$location[$key]."' ");
							$check_inventory_list = $select_inventory_list->num_rows();
							if($check_inventory_list>=1)
							{
								$res = $this->db->query("UPDATE inventory_list SET stock = stock + '".$qty_received[$key]."' WHERE id_product = '".$id_products."' AND id_location = '".$location[$key]."' ");
							}
							else
							{
								
								$data_insert = array(						
								"id_location" => $location[$key],
								"id_product" => $id_products,
								"stock" => $qty_received[$key],
								"product_name" => $description[$key]
								);
								$res = $this->model_gr->insertData("inventory_list",$data_insert);
								
							}
						
						}
						
						$this->session->set_flashdata('message_success',"Data Gr has been successfully saved!");
						redirect('gr');
					
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
			
			if($data_role[0]['see_supplier']=='yes')
			{	
			$this->load->library('table');
			$this->load->library('pagination');
			$search = isset($_GET['search']) ? $_GET['search'] : '';
			
			
			$jumlah= $this->model_gr->countGr($search);
			
			if (count($_GET) > 0) $config['suffix'] = '?' . http_build_query($_GET, '', "&");
			$config['base_url'] = base_url().'index.php/gr/gr/';
			$config['total_rows'] = $jumlah;
			$config['first_link'] = 'First';
			$config['last_link'] = 'End';
			$config['next_link'] = 'Next';
			$config['prev_link'] = 'Previous';
			$config['per_page'] = 5; 	
			if (count($_GET) > 0) $config['suffix'] = '?' . http_build_query($_GET, '', "&");
			$config['first_url'] = $config['base_url'].'?'.http_build_query($_GET);
			
			$dari = $this->uri->segment('3');
			$data = $this->model_gr->dataGr($config['per_page'],$dari,$search);
			
		
			$comp = array(
				'title' => ' Po',
				'content' => $this->load->view('gr',array('data_gr'=>$data,'data_role'=>$data_role,'search'=>$search),true),
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