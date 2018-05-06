<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Supplier extends CI_Controller {

	function __construct()  {
 		parent::__construct();
			$this->load->library(array('PHPExcel','PHPExcel/IOFactory'));
			$this->load->model('model_account_master');
			$this->load->model('model_supplier');
			$this->load->library('tank_auth');
			
	}
	
	
	public function deleteSupplierAll()
	{
		
			date_default_timezone_set('Asia/Jakarta');
			ini_set('memory_limit', '-1');
			
			if ($this->tank_auth->is_logged_in()) {
			$user	= $this->tank_auth->get_username();
			$data_account = $this->model_account_master->getAccount("WHERE username = '".$user."' ")->result_array();
			$data_role = $this->model_account_master->getRole("WHERE id_role = '".$data_account[0]['user_access']."' ")->result_array();
			$user_role = $data_account[0]['user_type'];
			$code_role = $data_account[0]['code'];
			if($data_role[0]['delete_supplier']=='yes')
			{
				
			
				// Get Variable Post
				$id_supplier_delete = $_POST['id_supplier_delete_all'];
				
		
					//Update Product
					$res = $this->db->query("DELETE FROM supplier WHERE id_supplier in (".$id_supplier_delete.") ");
					if($res>=1)
					{
						$this->session->set_flashdata('message_success',"Data supplier has been successfully deleted!");
						redirect('supplier');
						
						}
					else
					{
						$this->session->set_flashdata('message_failed',"Data supplier failed to delete!");
						redirect('supplier');
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
	
	public function editSupplier()
	{
		
			date_default_timezone_set('Asia/Jakarta');
			ini_set('memory_limit', '-1');
			
			if ($this->tank_auth->is_logged_in()) {
			$user	= $this->tank_auth->get_username();
			$data_account = $this->model_account_master->getAccount("WHERE username = '".$user."' ")->result_array();
			$data_role = $this->model_account_master->getRole("WHERE id_role = '".$data_account[0]['user_access']."' ")->result_array();
			$user_role = $data_account[0]['user_type'];
			$code_role = $data_account[0]['code'];
			
			if($data_role[0]['edit_driver']=='yes')
			{
				
				$timestamp = date('Y:m:d H:i:s');
				// Get Variable Post
				$id_supplier = $_POST['id_supplier_update'];
				$supplier_code = $_POST['edit_supplier_code'];
				$supplier_name = $_POST['edit_supplier_name'];
				$address_1 = $_POST['edit_address_1'];
				$address_2 = $_POST['edit_address_2'];
				$supplier_type = $_POST['edit_supplier_type'];
				$city = $_POST['edit_city'];
				$postal_code = $_POST['edit_postal_code'];
				$phone = $_POST['edit_phone'];
				$fax = $_POST['edit_fax'];
				$pic = $_POST['edit_pic'];
				$email = $_POST['edit_email'];
				$username = $user;
				
				$data_update = array(
				
				"supplier_code" => $supplier_code,
				"supplier_name" => $supplier_name,
				"address_1" => $address_1,
				"address_2" => $address_2,
				"supplier_type" => $supplier_type,
				"city" => $city,
				"postal_code" => $postal_code,
				"phone" => $phone,
				"fax" => $fax,
				"pic" => $pic,
				"email" => $email,
				"updated_by" => $username,
				"updated_time" => $timestamp

				);
				
				$where = array("id_supplier"=>$id_supplier);
				
				//Check Product Apakah sudah ada dengan kode produk dan type motorist yang sama
				$check = $this->model_supplier->getSupplier("WHERE supplier_code = '".$supplier_code."' AND id_supplier != '".$id_supplier."' ");
				
				
				if($check->num_rows() >=1 )
				{
					$this->session->set_flashdata('message_failed',"Sorry data already exist!");
					redirect('supplier');
					
					}
				else
				{
				
					//Update
					$res = $this->model_supplier->UpdateData("supplier",$data_update,$where);
					
					if($res>=1)
					{
						$this->session->set_flashdata('message_success',"Data supplier has been successfully updated!");
						
						redirect('supplier');
						
						}
					else
					{
						$this->session->set_flashdata('message_failed',"Data supplier failed to update!");
						redirect('supplier');
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
	
	
	public function deleteSupplier()
	{
		
			date_default_timezone_set('Asia/Jakarta');
			ini_set('memory_limit', '-1');
			
			if ($this->tank_auth->is_logged_in()) {
			$user	= $this->tank_auth->get_username();
			$data_account = $this->model_account_master->getAccount("WHERE username = '".$user."' ")->result_array();
			$data_role = $this->model_account_master->getRole("WHERE id_role = '".$data_account[0]['user_access']."' ")->result_array();
			$user_role = $data_account[0]['user_type'];
			$code_role = $data_account[0]['code'];
			if($data_role[0]['delete_supplier']=='yes')
			{
				
			
				// Get Variable Post
				$id_supplier_delete = $_POST['id_supplier_delete'];
				$where = array("id_supplier" => $id_supplier_delete);
				
		
					//Update Product
					$res = $this->model_supplier->DeleteData("supplier",$where);
					if($res>=1)
					{
						$this->session->set_flashdata('message_success',"Data supplier has been successfully deleted!");
						redirect('supplier');
						
						}
					else
					{
						$this->session->set_flashdata('message_failed',"Data supplier failed to delete!");
						redirect('supplier');
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
					$check = $this->model_supplier->getSupplier("WHERE supplier_code  = '".$rowData[0][0]."' ");
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
						
						$res = $this->model_supplier->UpdateData("supplier",$data_update,$where);
					
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
						$res = $this->model_supplier->insertData("supplier",$data_insert);
					
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
	
	public function addSupplier()
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
			
			if($data_role[0]['add_driver']=='yes')
			{
				
			
				// Get Variable Post
				$supplier_code = $_POST['supplier_code'];
				$supplier_name = $_POST['supplier_name'];
				$address_1 = $_POST['address_1'];
				$address_2 = $_POST['address_2'];
				$supplier_type = $_POST['supplier_type'];
				$city = $_POST['city'];
				$postal_code = $_POST['postal_code'];
				$phone = $_POST['phone'];
				$fax = $_POST['fax'];
				$pic = $_POST['pic'];
				$email = $_POST['email'];
				$username = $user;
				
				
				$data_insert = array(
					"supplier_code" => $supplier_code,
					"supplier_name" => $supplier_name,
					"address_1" => $address_1,
					"address_2" => $address_2,
					"supplier_type" => $supplier_type,
					"city" => $city,
					"postal_code" => $postal_code,
					"phone" => $phone,
					"fax" => $fax,
					"pic" => $pic,
					"email" => $email,
					"created_by" => $username,
					"created_time" => $timestamp
				);
				
				//Check Product Apakah sudah ada dengan kode produk dan type motorist yang sama
				$check = $this->model_supplier->getSupplier("WHERE supplier_code = '".$supplier_code."' ");
				if($check->num_rows() >=1 )
				{
					$this->session->set_flashdata('message_failed',"Sorry data already exist!");
					redirect('supplier');
					
					}
				else
				{
					
					$res = $this->model_supplier->insertData("supplier",$data_insert);
					if($res>=1)
					{
						$this->session->set_flashdata('message_success',"Data supplier has been successfully saved!");
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
			
			
			$jumlah= $this->model_supplier->countSupplier($search);
			
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
			$data = $this->model_supplier->dataSupplier($config['per_page'],$dari,$search);
			
		
			$comp = array(
				'title' => ' Supplier',
				'content' => $this->load->view('supplier',array('data_supplier'=>$data,'data_role'=>$data_role,'search'=>$search),true),
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