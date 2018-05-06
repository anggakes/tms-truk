<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Client extends CI_Controller {

	function __construct()  {
 		parent::__construct();
			$this->load->library(array('PHPExcel','PHPExcel/IOFactory'));
			$this->load->model('model_account_master');
			$this->load->model('model_client');
			$this->load->library('tank_auth');
			
	}
	
	
	public function deleteClientAll()
	{
		
			date_default_timezone_set('Asia/Jakarta');
			ini_set('memory_limit', '-1');
			
			if ($this->tank_auth->is_logged_in()) {
			$user	= $this->tank_auth->get_username();
			$data_account = $this->model_account_master->getAccount("WHERE username = '".$user."' ")->result_array();
			$data_role = $this->model_account_master->getRole("WHERE id_role = '".$data_account[0]['user_access']."' ")->result_array();
			$user_role = $data_account[0]['user_type'];
			$code_role = $data_account[0]['code'];
			if($data_role[0]['delete_client']=='yes')
			{
				
			
				// Get Variable Post
				$id_client_delete = $_POST['id_client_delete_all'];
				
		
					//Update Product
					$res = $this->db->query("DELETE FROM master_client WHERE id_client in (".$id_client_delete.") ");
					if($res>=1)
					{
						$this->session->set_flashdata('message_success',"Data Client has been successfully deleted!");
						redirect('client');
						
						}
					else
					{
						$this->session->set_flashdata('message_failed',"Data Client failed to delete!");
						redirect('client');
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
	
	public function editClient()
	{
		
			date_default_timezone_set('Asia/Jakarta');
			ini_set('memory_limit', '-1');
			
			if ($this->tank_auth->is_logged_in()) {
			$user	= $this->tank_auth->get_username();
			$data_account = $this->model_account_master->getAccount("WHERE username = '".$user."' ")->result_array();
			$data_role = $this->model_account_master->getRole("WHERE id_role = '".$data_account[0]['user_access']."' ")->result_array();
			$user_role = $data_account[0]['user_type'];
			$code_role = $data_account[0]['code'];
			
			if($data_role[0]['edit_client']=='yes')
			{
				
			
				// Get Variable Post
				$client_id = $_POST['edit_client_id'];
				$client_name = $_POST['edit_client_name'];
				$client_address_1 = $_POST['edit_client_address_1'];
				$client_address_2 = $_POST['edit_client_address_2'];
				$client_city = $_POST['edit_client_city'];
				$area = $_POST['edit_area'];
				$postal_code = $_POST['edit_postal_code'];
				$pic = $_POST['edit_pic'];
				$email = $_POST['edit_email'];
				$client_latitude = $_POST['edit_client_latitude'];
				$client_longitude = $_POST['edit_client_longitude'];
				$timestamp = date('Y:m:d H:i:s');
				$username = $user;
				$id_client = $_POST['id_client_update'];
				
				
				$data_update = array(
					
					"client_id" => $client_id,
					"client_name" => $client_name,
					"client_address_1" => $client_address_1,
					"client_address_2" => $client_address_2,
					"client_city" => $client_city,
					"area" => $area,
					"postal_code" => $postal_code,
					"pic" => $pic,
					"email" => $email,
					"client_latitude" => $client_latitude,
					"client_longitude" => $client_longitude,
					"updated_by" => $username,
					"updated_date" => $timestamp

				);
				
				$where = array("id_client"=>$id_client);
				
				$check_client = $this->model_client->getClient("WHERE client_id  = '".$client_id."' AND id_client != '".$id_client."' ");
					
				if($check_client->num_rows() >=1 )
				{
						$this->session->set_flashdata('message_failed',"Sorry data already exist!");
						
						redirect('client');
					
				}
				else{
					
					//Update
					$res = $this->model_client->UpdateData("master_client",$data_update,$where);
					
					if($res>=1)
					{
						$this->session->set_flashdata('message_success',"Data Client has been successfully updated!");
						
						redirect('client');
						
						}
					else
					{
						$this->session->set_flashdata('message_failed',"Data Client failed to update!");
						redirect('client');
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
	
	
	public function deleteClient()
	{
		
			date_default_timezone_set('Asia/Jakarta');
			ini_set('memory_limit', '-1');
			
			if ($this->tank_auth->is_logged_in()) {
			$user	= $this->tank_auth->get_username();
			$data_account = $this->model_account_master->getAccount("WHERE username = '".$user."' ")->result_array();
			$data_role = $this->model_account_master->getRole("WHERE id_role = '".$data_account[0]['user_access']."' ")->result_array();
			$user_role = $data_account[0]['user_type'];
			$code_role = $data_account[0]['code'];
			if($data_role[0]['delete_client']=='yes')
			{
				
			
				// Get Variable Post
				$id_client_delete = $_POST['id_client_delete'];
				$where = array("id_client" => $id_client_delete);
				
		
					//Update Product
					$res = $this->model_client->DeleteData("master_client",$where);
					if($res>=1)
					{
						$this->session->set_flashdata('message_success',"Data Client has been successfully deleted!");
						redirect('client');
						
						}
					else
					{
						$this->session->set_flashdata('message_failed',"Data Client failed to delete!");
						redirect('client');
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
	
	public function exportClient()
	{
		
		date_default_timezone_set('Asia/Jakarta');
		if ($this->tank_auth->is_logged_in()) {
		$user	= $this->tank_auth->get_username();
		$data_account = $this->model_account_master->getAccount("WHERE username = '".$user."' ")->result_array();
		$data_role = $this->model_account_master->getRole("WHERE id_role = '".$data_account[0]['user_access']."' ")->result_array();
		$user_role = $data_account[0]['user_type'];
		$code_role = $data_account[0]['code'];
		
		if($data_role[0]['export_client']=='yes')
		{
		$search = isset($_GET['search']) ? $_GET['search'] : '';

		
		$date = date("m-d-Y");
		$this->db->or_like('client_id', $search);
		$this->db->or_like('client_name', $search);
		$query = $this->db->get('master_client');
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
		
		
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 1, "Master Client ");
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
		"Client ID" => "Client ID",
		"Client Name" => "Client Name",
		"Client Address 1" => "Client Address 1",
		"Client Address 2" => "Client Address 2",
		"Client City" => "Client City",
		"Area" => "Area",
		"Postal Code" => "Postal Code",
		"Pic" => "Pic",
		"Email" => "Email",
		"Client latitude" => "Client latitude",
		"Client Longitude" => "Client Longitude",
		
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
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $row, $data['client_address_1']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $row, $data['client_address_2']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, $row, $data['client_city']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, $row, $data['area']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, $row, $data['postal_code']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8, $row, $data['pic']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9, $row, $data['email']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(10, $row, $data['client_latitude']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(11, $row, $data['client_longitude']);

 
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
        header('Content-Disposition: attachment;filename="Master-area-'.$date.'.xls"');
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
	
	public function importClient()
	{
		
			date_default_timezone_set('Asia/Jakarta');
			ini_set('memory_limit', '-1');
			
			if ($this->tank_auth->is_logged_in()) {
			$user	= $this->tank_auth->get_username();
			$data_account = $this->model_account_master->getAccount("WHERE username = '".$user."' ")->result_array();
			$data_role = $this->model_account_master->getRole("WHERE id_role = '".$data_account[0]['user_access']."' ")->result_array();
			$user_role = $data_account[0]['user_type'];
			$code_role = $data_account[0]['code'];
			
			if($data_role[0]['import_client']=='yes')
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
												
												
				
					$timestamp = date('Y:m:d H:i:s');
					$username = $user;
			
					//jika master data tidak kosong maka akan diisi		
					$check = $this->model_client->getArea("WHERE area_id  = '".$rowData[0][5]."' ");
					
					if($check->num_rows() >=1 )
					{
						
						$check_client = $this->model_client->getClient("WHERE client_id  = '".$rowData[0][0]."' ");
					
						if($check_client->num_rows() <=0 )
						{
						
						$data_insert = array(
							
							"client_id" => $rowData[0][0],
							"client_name" => $rowData[0][1],
							"client_address_1" => $rowData[0][2],
							"client_address_2" => $rowData[0][3],
							"client_city" => $rowData[0][4],
							"area" => $rowData[0][5],
							"postal_code" => $rowData[0][6],
							"pic" => $rowData[0][7],
							"email" => $rowData[0][8],
							"client_latitude" => $rowData[0][9],
							"client_longitude" => $rowData[0][10],
							"created_by" => $username,
							"created_date" => $timestamp

						);
						
						//Insert Data
						$res = $this->model_client->insertData("master_client",$data_insert);
					
					
					}}
					
				
				
			}
				@unlink($inputFileName);
				$this->session->set_flashdata('message_success','Data imported successfully');
				redirect('client');
			
               
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
	
	public function addClient()
	{
		
			date_default_timezone_set('Asia/Jakarta');
			ini_set('memory_limit', '-1');
			
			if ($this->tank_auth->is_logged_in()) {
			$user	= $this->tank_auth->get_username();
			$data_account = $this->model_account_master->getAccount("WHERE username = '".$user."' ")->result_array();
			$data_role = $this->model_account_master->getRole("WHERE id_role = '".$data_account[0]['user_access']."' ")->result_array();
			$user_role = $data_account[0]['user_type'];
			$code_role = $data_account[0]['code'];
			
			if($data_role[0]['add_client']=='yes')
			{
				// Get Variable Post
				$client_id = $_POST['client_id'];
				$client_name = $_POST['client_name'];
				$client_address_1 = $_POST['client_address_1'];
				$client_address_2 = $_POST['client_address_2'];
				$client_city = $_POST['client_city'];
				$area = $_POST['area'];
				$postal_code = $_POST['postal_code'];
				$pic = $_POST['pic'];
				$email = $_POST['email'];
				$client_latitude = $_POST['client_latitude'];
				$client_longitude = $_POST['client_longitude'];
				$timestamp = date('Y:m:d H:i:s');
				$username = $user;
				
				$data_insert = array(
					
					"client_id" => $client_id,
					"client_name" => $client_name,
					"client_address_1" => $client_address_1,
					"client_address_2" => $client_address_2,
					"client_city" => $client_city,
					"area" => $area,
					"postal_code" => $postal_code,
					"pic" => $pic,
					"email" => $email,
					"client_latitude" => $client_latitude,
					"client_longitude" => $client_longitude,
					"created_by" => $username,
					"created_date" => $timestamp

				);
				
					$check_client = $this->model_client->getClient("WHERE client_id  = '".$client_id."' ");
					
					if($check_client->num_rows() >=1 )
					{
						$this->session->set_flashdata('message_failed',"Sorry data already exist!");
						redirect('client');
					}
					else{
					
						$res = $this->model_client->insertData("master_client",$data_insert);
						if($res>=1)
						{
							$this->session->set_flashdata('message_success',"Data Client has been successfully saved!");
							redirect('client');
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
			
			if($data_role[0]['see_client']=='yes')
			{	
			$this->load->library('table');
			$this->load->library('pagination');
			$search = isset($_GET['search']) ? $_GET['search'] : '';
			
			
			$jumlah= $this->model_client->countClient($search);
			
			if (count($_GET) > 0) $config['suffix'] = '?' . http_build_query($_GET, '', "&");
			$config['base_url'] = base_url().'index.php/client/client/';
			$config['total_rows'] = $jumlah;
			$config['first_link'] = 'First';
			$config['last_link'] = 'End';
			$config['next_link'] = 'Next';
			$config['prev_link'] = 'Previous';
			$config['per_page'] = 5; 	
			if (count($_GET) > 0) $config['suffix'] = '?' . http_build_query($_GET, '', "&");
			$config['first_url'] = $config['base_url'].'?'.http_build_query($_GET);
			
			$dari = $this->uri->segment('3');
			$data = $this->model_client->dataClient($config['per_page'],$dari,$search);
			
		
			$comp = array(
				'title' => ' Client',
				'content' => $this->load->view('client',array('data_client'=>$data,'data_role'=>$data_role,'search'=>$search),true),
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