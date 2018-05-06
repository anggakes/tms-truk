<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Product extends CI_Controller {

	function __construct()  {
 		parent::__construct();
			$this->load->library(array('PHPExcel','PHPExcel/IOFactory'));
			$this->load->model('model_account_master');
			$this->load->model('model_product');
			$this->load->library('tank_auth');
			
	}
	
	
	public function deleteProductAll()
	{
		
			date_default_timezone_set('Asia/Jakarta');
			ini_set('memory_limit', '-1');
			
			if ($this->tank_auth->is_logged_in()) {
			$user	= $this->tank_auth->get_username();
			$data_account = $this->model_account_master->getAccount("WHERE username = '".$user."' ")->result_array();
			$data_role = $this->model_account_master->getRole("WHERE id_role = '".$data_account[0]['user_access']."' ")->result_array();
			$user_role = $data_account[0]['user_type'];
			$code_role = $data_account[0]['code'];
			if($data_role[0]['delete_product']=='yes')
			{
				
			
				// Get Variable Post
				$id_product_delete = $_POST['id_product_delete_all'];
				
		
					//Update Product
					$res = $this->db->query("DELETE FROM product WHERE id_product in (".$id_product_delete.") ");
					if($res>=1)
					{
						$this->session->set_flashdata('message_success',"Data product has been successfully deleted!");
						redirect('product');
						
						}
					else
					{
						$this->session->set_flashdata('message_failed',"Data product failed to delete!");
						redirect('productfexp');
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
	
	public function editProduct()
	{
		
			date_default_timezone_set('Asia/Jakarta');
			ini_set('memory_limit', '-1');
			
			if ($this->tank_auth->is_logged_in()) {
			$user	= $this->tank_auth->get_username();
			$data_account = $this->model_account_master->getAccount("WHERE username = '".$user."' ")->result_array();
			$data_role = $this->model_account_master->getRole("WHERE id_role = '".$data_account[0]['user_access']."' ")->result_array();
			$user_role = $data_account[0]['user_type'];
			$code_role = $data_account[0]['code'];
			
			if($data_role[0]['edit_product']=='yes')
			{
				
			
				// Get Variable Post
				$id_product = $_POST['id_product_update'];
				$id_warehouse = $_POST['edit_id_warehouse'];
				$id_supplier = $_POST['edit_id_supplier'];
				$product_code = $_POST['edit_product_code'];
				$serial_number = $_POST['edit_serial_number'];
				$product_description = $_POST['edit_product_description'];
				$base_uom = $_POST['edit_base_uom'];
				$qty_pallet = $_POST['qty_pallet'];
				$price = $_POST['edit_price'];
				$net_weight = $_POST['edit_net_weight'];
				$gross_weight = $_POST['edit_gross_weight'];
				$uow = $_POST['edit_uow'];
				
				$data_update = array(
				
				"id_warehouse" => $id_warehouse,
				"id_supplier" => $id_supplier,
				"product_code" => $product_code,
				"serial_number" => $serial_number,
				"product_description" => $product_description,
				"base_uom" => $base_uom,
				"qty_pallet" => $qty_pallet,
				"price" => $price,
				"net_weight" => $edit_net_weight,
				"gross_weight" => $gross_weight,
				"uow" => $uow

				);
				
				$where = array("id_product"=>$id_product);
				
				//Check Product Apakah sudah ada dengan kode produk dan type motorist yang sama
				$check = $this->model_product->getProduct("WHERE product_code = '".$product_code."' AND id_product != '".$id_product."' ");
				
				
				if($check->num_rows() >=1 )
				{
					$this->session->set_flashdata('message_failed',"Sorry data already exist!");
					redirect('product');
					
					}
				else
				{
				
					//Update
					
					$res = $this->model_product->UpdateData("product",$data_update,$where);
					
					
					if($res>=1)
					{
						$this->session->set_flashdata('message_success',"Data product has been successfully updated!");
						
						redirect('product');
						
						}
					else
					{
						$this->session->set_flashdata('message_failed',"Data product failed to update!");
						redirect('product');
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
	
	
	public function deleteProduct()
	{
		
			date_default_timezone_set('Asia/Jakarta');
			ini_set('memory_limit', '-1');
			
			if ($this->tank_auth->is_logged_in()) {
			$user	= $this->tank_auth->get_username();
			$data_account = $this->model_account_master->getAccount("WHERE username = '".$user."' ")->result_array();
			$data_role = $this->model_account_master->getRole("WHERE id_role = '".$data_account[0]['user_access']."' ")->result_array();
			$user_role = $data_account[0]['user_type'];
			$code_role = $data_account[0]['code'];
			if($data_role[0]['delete_product']=='yes')
			{
				
			
				// Get Variable Post
				$id_product_delete = $_POST['id_product_delete'];
				$where = array("id_product" => $id_product_delete);
				
		
					//Update Product
					$res = $this->model_product->DeleteData("product",$where);
					if($res>=1)
					{
						$this->session->set_flashdata('message_success',"Data product has been successfully deleted!");
						redirect('product');
						
						}
					else
					{
						$this->session->set_flashdata('message_failed',"Data product failed to delete!");
						redirect('product');
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
	
	public function exportProduct()
	{
		
		date_default_timezone_set('Asia/Jakarta');
		if ($this->tank_auth->is_logged_in()) {
		$user	= $this->tank_auth->get_username();
		$data_account = $this->model_account_master->getAccount("WHERE username = '".$user."' ")->result_array();
		$data_role = $this->model_account_master->getRole("WHERE id_role = '".$data_account[0]['user_access']."' ")->result_array();
		$user_role = $data_account[0]['user_type'];
		$code_role = $data_account[0]['code'];
		
		
		if($data_role[0]['export_product']=='yes')
		{
		$search = isset($_GET['search']) ? $_GET['search'] : '';	
		$date = date("m-d-Y");
		$this->db->or_like('product_code', $search);
		$this->db->or_like('product_description', $search);
		$this->db->join('warehouse', 'warehouse.id_warehouse = product.id_warehouse','LEFT');
		$this->db->join('supplier', 'supplier.id_supplier = product.id_supplier','LEFT');
		$query = $this->db->get('product');
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
		
		
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 1, "Master Product");
		//Merge And Center Title
		$objPHPExcel->getActiveSheet()->mergeCells('A1:D1');
		
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 2, "Date : ".$date.$search);
		
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
		"Warehouse Name" => "Warehouse Name",
		"Supplier Name" => "Supplier Name",
		"Product Code" => "Product Code",
		"Serial Number" => "Serial Number",
		"product Description" => "Product Description",
		"Base UOM" => "Base UOM",
		"Quantity Pallet" => "Quantity Pallet",
		"Price" => "Price",
		"net Weight" => "Net Weight",
		"Gross Weight" => "Gross Weight",
		"UOW" => "UOW"
		
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
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $row, $data['warehouse_name']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $row, $data['supplier_name']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $row, $data['product_code']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $row, $data['serial_number']);
			
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, $row, $data['product_description']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, $row, $data['base_uom']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, $row, $data['qty_pallet']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8, $row, $data['price']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9, $row, $data['net_weight']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(10, $row, $data['gross_weight']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(11, $row, $data['uow']);
 
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
	
	public function importProduct()
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
			
			if($data_role[0]['import_product']=='yes')
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
				redirect('product');
				
				
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
					$check = $this->model_product->getProduct("WHERE product_code  = '".$rowData[0][1]."' ");
					$id_warehouse = 0;
					$select_warehouse = $this->db->query("SELECT * FROM warehouse WHERE warehouse_code = '".$rowData[0][0]."' ");
					$check_warehouse = $select_warehouse->num_rows();
					if($check_warehouse>=1)
					{
						$data_warehouse = $select_warehouse->result_array();
						$id_warehouse = $data_warehouse[0]['id_warehouse']; }
					
					if($check->num_rows() >=1 )
					{
						
						
						
						
						$data_update = array(
							"id_warehouse" => $id_warehouse,
							"product_description" => $rowData[0][2],
							"base_uom" => $rowData[0][3],
							"price" => $rowData[0][4],
							"net_weight" => $rowData[0][5],
							"gross_weight" => $rowData[0][6],
							"uow" => $rowData[0][7],
							"updated_by" => $username,
							"updated_time" => $timestamp
									
							
							
						);
						$where = array(
							"product_code" => $rowData[0][1]
						);
						
						$res = $this->model_product->UpdateData("product",$data_update,$where);
					
						}
					else
					{
						$data_insert = array(
							"id_warehouse" => $id_warehouse,
							"product_code" => $rowData[0][1],
							"product_description" => $rowData[0][2],
							"base_uom" => $rowData[0][3],
							"price" => $rowData[0][4],
							"net_weight" => $rowData[0][5],
							"gross_weight" => $rowData[0][6],
							"uow" => $rowData[0][7],
							"created_by" => $username,
							"created_time" => $timestamp
						);
						
						//Insert Data
						$res = $this->model_product->insertData("product",$data_insert);
					
					}
					
				
				
			}
				@unlink($inputFileName);
				$this->session->set_flashdata('message_success','Data imported successfully');
				redirect('product');
			
               
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
	
	public function addProduct()
	{
		
			date_default_timezone_set('Asia/Jakarta');
			ini_set('memory_limit', '-1');
			$timestamp = date('Y:m:d H:i:s');
			if ($this->tank_auth->is_logged_in()) {
			$user	= $this->tank_auth->get_username();
			$data_account = $this->model_account_master->getAccount("WHERE username = '".$user."' ")->result_array();
			$username = $user;
			$data_role = $this->model_account_master->getRole("WHERE id_role = '".$data_account[0]['user_access']."' ")->result_array();
			$user_role = $data_account[0]['user_type'];
			$code_role = $data_account[0]['code'];
			
			if($data_role[0]['add_product']=='yes')
			{
				
				// Get Variable Post
				$id_warehouse = $_POST['id_warehouse'];
				$id_supplier = $_POST['id_supplier'];
				$product_code = $_POST['product_code'];
				$serial_number = $_POST['serial_number'];
				$product_description = $_POST['product_description'];
				$qty_pallet = $_POST['qty_pallet'];
				$price = $_POST['price'];
				$base_uom = $_POST['base_uom'];
				$net_weight = $_POST['net_weight'];
				$gross_weight = $_POST['gross_weight'];
				$uow = $_POST['uow'];
				
				
				$data_insert = array(
					"id_warehouse" => $id_warehouse,
					"id_supplier" => $id_supplier,
					"product_code" => $product_code,
					"serial_number" => $serial_number,
					"product_description" => $product_description,
					"qty_pallet" => $qty_pallet,
					"price" => $price,
					"base_uom" => $base_uom,
					"net_weight" => $net_weight,
					"gross_weight" => $gross_weight,
					"uow" => $uow,
					"created_by" => $username,
					"created_time" => $timestamp
				);
				
				//Check Product Apakah sudah ada dengan kode produk dan type motorist yang sama
				$check = $this->model_product->getProduct("WHERE product_code = '".$product_code."' ");
				if($check->num_rows() >=1 )
				{
					$this->session->set_flashdata('message_failed',"Sorry data already exist!");
					redirect('product');
					
					}
				else
				{
					
					$res = $this->model_product->insertData("product",$data_insert);
					if($res>=1)
					{
						$this->session->set_flashdata('message_success',"Data product has been successfully saved!");
						redirect('product');
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
			
			if($data_role[0]['see_supplier']=='yes')
			{	
			$this->load->library('table');
			$this->load->library('pagination');
			$search = isset($_GET['search']) ? $_GET['search'] : '';
			
			
			$jumlah= $this->model_product->countProduct($search);
			
			if (count($_GET) > 0) $config['suffix'] = '?' . http_build_query($_GET, '', "&");
			$config['base_url'] = base_url().'index.php/supplier/supplier/';
			$config['total_rows'] = $jumlah;
			$config['first_link'] = 'First';
			$config['last_link'] = 'End';
			$config['next_link'] = 'Next';
			$config['prev_link'] = 'Previous';
			$config['per_page'] = 5; 	
			if (count($_GET) > 0) $config['suffix'] = '?' . http_build_query($_GET, '', "&");
			$config['first_url'] = $config['base_url'].'?'.http_build_query($_GET);
			
			$dari = $this->uri->segment('3');
			$data = $this->model_product->dataProduct($config['per_page'],$dari,$search);
			
			$data_warehouse = $this->db->query("SELECT * FROM warehouse")->result();
			$data_supplier = $this->db->query("SELECT * FROM supplier")->result();
		
			$comp = array(
				'title' => ' Supplier',
				'content' => $this->load->view('product',array('data_warehouse'=>$data_warehouse,'data_supplier'=>$data_supplier,'data_product'=>$data,'data_role'=>$data_role,'search'=>$search),true),
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