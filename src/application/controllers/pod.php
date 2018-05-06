<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pod extends CI_Controller {

	function __construct()  {
 		parent::__construct();
			$this->load->library(array('PHPExcel','PHPExcel/IOFactory'));
			$this->load->model('model_account_master');
			$this->load->model('model_pod');
			$this->load->library('tank_auth');
			
	}
	
	
	public function update_pod()
	{
		
			date_default_timezone_set('Asia/Jakarta');
			ini_set('memory_limit', '-1');
			
			if ($this->tank_auth->is_logged_in()) {
			$user	= $this->tank_auth->get_username();
			$data_account = $this->model_account_master->getAccount("WHERE username = '".$user."' ")->result_array();
			$data_role = $this->model_account_master->getRole("WHERE id_role = '".$data_account[0]['user_access']."' ")->result_array();
			$user_role = $data_account[0]['user_type'];
			$code_role = $data_account[0]['code'];
			
			if($data_role[0]['edit_pod']=='yes')
			{
				
			
				// Get Variable Post
				$timestamp = date('Y:m:d H:i:s');
				$username = $user;
				
				$pod_date = explode('-',$_POST['checkbox_pod_time_date']);
				$pod_date = $pod_date[2].'-'.$pod_date[1].'-'.$pod_date[0];
				
				$pod_time = $_POST['checkbox_pod_time_time'];
				$code = $_POST['code_pod'];
				$pic = $_POST['pic'];
				
				$submit_date = explode('-',$_POST['checkbox_submit_time_date']);
				$submit_date = $submit_date[2].'-'.$submit_date[1].'-'.$submit_date[0];
				$submit_time = $_POST['checkbox_submit_time_time'];
				$doc_reference = $_POST['doc_reference'];
				
				$receive_date = explode('-',$_POST['checkbox_receive_time_date']);
				$receive_date = $receive_date[2].'-'.$receive_date[1].'-'.$receive_date[0];
				$receive_time = $_POST['checkbox_receive_time_time'];
				$receiver = $_POST['receiver'];
			
				$id_pod_delete_all = $_POST['id_pod_delete_all'];
				
				$pieces = explode(",", $id_pod_delete_all);
				$pieces = array_unique($pieces);
				
				foreach($pieces as $spk_number)
				{
					$check_pod = $this->db->query("SELECT * FROM pod WHERE spk_number = '".$spk_number."' ")->num_rows();
					if($check_pod>=1)
					{
						$data_to = $this->db->query("SELECT * FROM transport_order WHERE spk_number = '".$spk_number."' ")->result_array();
						$data_update = array(
					
								
								"manifest" => $data_to[0]['manifest'],
								"pod_date" => $pod_date,
								"pod_time" => $pod_time,
								"code" => $code,
								"pic" => $pic,
								"submit_date" => $submit_date,
								"submit_time" => $submit_time,
								"doc_reference" => $doc_reference,
								"receive_date" => $receive_date,
								"receive_time" => $receive_time,
								"receiver" => $receiver,
								"updated_by" => $user,
								"updated_time" => $timestamp

						);
						
						$where = array(
								"spk_number" => $spk_number
						);
						
						$res = $this->model_pod->UpdateData("pod",$data_update,$where);
						if($res>=1)
						{
							$this->session->set_flashdata('message_success',"Data POD has been successfully saved!");
							redirect('pod');
						}	
						
					}
					else
					{
						//insert
						$data_to = $this->db->query("SELECT * FROM transport_order WHERE spk_number = '".$spk_number."' ")->result_array();
						$data_insert = array(
								"manifest" => $data_to[0]['manifest'],
								"spk_number" => $spk_number,
								"pod_date" => $pod_date,
								"pod_time" => $pod_time,
								"code" => $code,
								"pic" => $pic,
								"submit_date" => $submit_date,
								"submit_time" => $submit_time,
								"doc_reference" => $doc_reference,
								"receive_date" => $receive_date,
								"receive_time" => $receive_time,
								"receiver" => $receiver,
								"created_by" => $user,
								"created_time" => $timestamp
						);
						$res = $this->model_pod->insertData("pod",$data_insert);
						
						if($res>=1)
						{
							$this->session->set_flashdata('message_success',"Data POD has been successfully saved!");
							redirect('pod');
						}	
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
	
	public function deleteMasterDataPodAll()
	{
		
			date_default_timezone_set('Asia/Jakarta');
			ini_set('memory_limit', '-1');
			
			if ($this->tank_auth->is_logged_in()) {
			$user	= $this->tank_auth->get_username();
			$data_account = $this->model_account_master->getAccount("WHERE username = '".$user."' ")->result_array();
			$data_role = $this->model_account_master->getRole("WHERE id_role = '".$data_account[0]['user_access']."' ")->result_array();
			$user_role = $data_account[0]['user_type'];
			$code_role = $data_account[0]['code'];
			if($data_role[0]['delete_master_category']=='yes')
			{
				
			
				// Get Variable Post
				$id_master_data_category_delete = $_POST['id_master_data_category_delete_all'];
				
		
					//Update Product
					$res = $this->db->query("DELETE FROM master_data_category WHERE id_master_data_category in (".$id_master_data_category_delete.") ");
					if($res>=1)
					{
						$this->session->set_flashdata('message_success',"Data Master Data Pod has been successfully deleted!");
						redirect('master_data_category');
						
						}
					else
					{
						$this->session->set_flashdata('message_failed',"Data Master Data Pod failed to delete!");
						redirect('master_data_category');
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
	
	public function editMasterDataPod()
	{
		
			date_default_timezone_set('Asia/Jakarta');
			ini_set('memory_limit', '-1');
			
			if ($this->tank_auth->is_logged_in()) {
			$user	= $this->tank_auth->get_username();
			$data_account = $this->model_account_master->getAccount("WHERE username = '".$user."' ")->result_array();
			$data_role = $this->model_account_master->getRole("WHERE id_role = '".$data_account[0]['user_access']."' ")->result_array();
			$user_role = $data_account[0]['user_type'];
			$code_role = $data_account[0]['code'];
			
			if($data_role[0]['edit_master_category']=='yes')
			{
				
			
				// Get Variable Post
				$category = $_POST['edit_category'];
				$description = $_POST['edit_description'];
				$id_master_data_category = $_POST['id_master_data_category_update'];
				
				$data_update = array(
				
				"category" => $category,
				"description" => $description

				);
				
				$where = array("id_master_data_category"=>$id_master_data_category);
				
				//Check Product Apakah sudah ada dengan kode produk dan type motorist yang sama
				$check = $this->model_pod->getMasterDataPod("WHERE category = '".$category."' AND description = '".$description."' AND id_master_data_category != '".$id_master_data_category."' ");
				
				
				if($check->num_rows() >=1 )
				{
					$this->session->set_flashdata('message_failed',"Sorry data already exist!");
					redirect('master_data_category');
					
					}
				else
				{
				
					//Update
					$res = $this->model_pod->UpdateData("master_data_category",$data_update,$where);
					
					if($res>=1)
					{
						$this->session->set_flashdata('message_success',"Data Master Data Pod has been successfully updated!");
						
						redirect('master_data_category');
						
						}
					else
					{
						$this->session->set_flashdata('message_failed',"Data Master Data Pod failed to update!");
						redirect('master_data_category');
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
	
	
	public function deleteMasterDataPod()
	{
		
			date_default_timezone_set('Asia/Jakarta');
			ini_set('memory_limit', '-1');
			
			if ($this->tank_auth->is_logged_in()) {
			$user	= $this->tank_auth->get_username();
			$data_account = $this->model_account_master->getAccount("WHERE username = '".$user."' ")->result_array();
			$data_role = $this->model_account_master->getRole("WHERE id_role = '".$data_account[0]['user_access']."' ")->result_array();
			$user_role = $data_account[0]['user_type'];
			$code_role = $data_account[0]['code'];
			if($data_role[0]['delete_master_category']=='yes')
			{
				
			
				// Get Variable Post
				$id_master_data_category_delete = $_POST['id_master_data_category_delete'];
				$where = array("id_master_data_category" => $id_master_data_category_delete);
				
		
					//Update Product
					$res = $this->model_pod->DeleteData("master_data_category",$where);
					if($res>=1)
					{
						$this->session->set_flashdata('message_success',"Data Master Data Pod has been successfully deleted!");
						redirect('master_data_category');
						
						}
					else
					{
						$this->session->set_flashdata('message_failed',"Data Master Data Pod failed to delete!");
						redirect('master_data_category');
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
	
	public function exportMasterDataPod()
	{
		
		date_default_timezone_set('Asia/Jakarta');
		if ($this->tank_auth->is_logged_in()) {
		$user	= $this->tank_auth->get_username();
		$data_account = $this->model_account_master->getAccount("WHERE username = '".$user."' ")->result_array();
		$data_role = $this->model_account_master->getRole("WHERE id_role = '".$data_account[0]['user_access']."' ")->result_array();
		$user_role = $data_account[0]['user_type'];
		$code_role = $data_account[0]['code'];
		
		if($data_role[0]['export_master_category']=='yes')
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
		
		
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 1, "Master MasterDataPod");
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
		"Pod" => "Pod",
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
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $row, $data['id_master_data_category']);
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
	
	public function importMasterDataPod()
	{
		
			date_default_timezone_set('Asia/Jakarta');
			ini_set('memory_limit', '-1');
			
			if ($this->tank_auth->is_logged_in()) {
			$user	= $this->tank_auth->get_username();
			$data_account = $this->model_account_master->getAccount("WHERE username = '".$user."' ")->result_array();
			$data_role = $this->model_account_master->getRole("WHERE id_role = '".$data_account[0]['user_access']."' ")->result_array();
			$user_role = $data_account[0]['user_type'];
			$code_role = $data_account[0]['code'];
			
			if($data_role[0]['import_master_category']=='yes')
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
					$check = $this->model_pod->getMasterDataPod("WHERE area_id  = '".$rowData[0][0]."' ");
					if($check->num_rows() >=1 )
					{
						
						$data_update = array(
							"area_description" => $rowData[0][1],
							"area_type" => $rowData[0][2]
							
						);
						$where = array(
							"area_id" => $rowData[0][0]
						);
						
						$res = $this->model_pod->UpdateData("master_master_data_category",$data_update,$where);
					
						}
					else
					{
						$data_insert = array(
							"area_id" => $rowData[0][0],
							"area_description" => $rowData[0][1],
							"area_type" => $rowData[0][2]
						);
						
						//Insert Data
						$res = $this->model_pod->insertData("master_master_data_category",$data_insert);
					
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
	
	public function addMasterDataPod()
	{
		
			date_default_timezone_set('Asia/Jakarta');
			ini_set('memory_limit', '-1');
			
			if ($this->tank_auth->is_logged_in()) {
			$user	= $this->tank_auth->get_username();
			$data_account = $this->model_account_master->getAccount("WHERE username = '".$user."' ")->result_array();
			$data_role = $this->model_account_master->getRole("WHERE id_role = '".$data_account[0]['user_access']."' ")->result_array();
			$user_role = $data_account[0]['user_type'];
			$code_role = $data_account[0]['code'];
			
			if($data_role[0]['add_master_category']=='yes')
			{
				
			
				// Get Variable Post
				$category = $_POST['category'];
				$description = $_POST['description'];
				
				
				$data_insert = array(
				
					"category" => $category,
					"description" => $description

				);
				
				//Check Product Apakah sudah ada dengan kode produk dan type motorist yang sama
				$check = $this->model_pod->getMasterDataPod("WHERE category = '".$category."' AND description = '".$description."' ");
				if($check->num_rows() >=1 )
				{
					$this->session->set_flashdata('message_failed',"Sorry data already exist!");
					redirect('master_data_category');
					
					}
				else
				{
					
					$res = $this->model_pod->insertData("master_data_category",$data_insert);
					if($res>=1)
					{
						$this->session->set_flashdata('message_success',"Data Master Data Pod has been successfully saved!");
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
			
			if($data_role[0]['see_master_category']=='yes')
			{	
			$this->load->library('table');
			$this->load->library('pagination');
			$search = isset($_GET['search']) ? $_GET['search'] : '';
			
			
			$jumlah= $this->model_pod->countMasterDataPod($search);
			
			if (count($_GET) > 0) $config['suffix'] = '?' . http_build_query($_GET, '', "&");
			$config['base_url'] = base_url().'index.php/pod/pod/';
			$config['total_rows'] = $jumlah;
			$config['first_link'] = 'First';
			$config['last_link'] = 'End';
			$config['next_link'] = 'Next';
			$config['prev_link'] = 'Previous';
			$config['per_page'] = 20; 	
			if (count($_GET) > 0) $config['suffix'] = '?' . http_build_query($_GET, '', "&");
			$config['first_url'] = $config['base_url'].'?'.http_build_query($_GET);
			
			$dari = $this->uri->segment('3');
			$data = $this->model_pod->dataMasterDataPod($config['per_page'],$dari,$search);
			$this->pagination->initialize($config);
			
			$data_pod_action = $this->db->query("SELECT * FROM master_data_category WHERE category = 'Pod Code' ")->result();
		
			$comp = array(
				'title' => 'Pod',
				'content' => $this->load->view('pod',array('data_pod_action'=>$data_pod_action,'data_pod'=>$data,'data_role'=>$data_role,'search'=>$search),true),
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