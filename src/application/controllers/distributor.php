<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Distributor extends CI_Controller {

	function __construct()  {
 		parent::__construct();
			$this->load->library(array('PHPExcel','PHPExcel/IOFactory'));
			$this->load->model('model_account_master');
			$this->load->model('model_distributor');
			$this->load->library('tank_auth');
			
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
			
			if($data_role[0]['see_distributor']=='yes')
			{	
			$this->load->library('table');
			$this->load->library('pagination');
			$search = isset($_GET['search']) ? $_GET['search'] : '';
			$regional = isset($_GET['regional']) ? $_GET['regional'] : '';
			if(isset($_GET['regional']))
			{
				$regional = "'" . implode("','", $regional) . "'";
			}
			
			$jumlah= $this->model_distributor->countDistributor($search,$regional);
			$config['base_url'] = base_url().'index.php/distributor/distributor/';
			$config['total_rows'] = $jumlah;
			$config['first_link'] = 'First';
			$config['last_link'] = 'End';
			$config['next_link'] = 'Next';
			$config['prev_link'] = 'Previous';
			$config['per_page'] = 20; 	
			
			$dari = $this->uri->segment('3');
			$data = $this->model_distributor->dataDistributor($config['per_page'],$dari,$search,$regional);
			$this->pagination->initialize($config);
			$data_regional = $this->model_distributor->getRegional()->result_array();
		
			$comp = array(
				
				'title' => ' Distributor',
				'content' => $this->load->view('distributor',array('data_distributor'=>$data,'data_regional'=>$data_regional,'search'=>$search),true),
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
	
	
	
	public function addDistributor()
	{
		
			date_default_timezone_set('Asia/Jakarta');
			ini_set('memory_limit', '-1');
			
			if ($this->tank_auth->is_logged_in()) {
			$user	= $this->tank_auth->get_username();
			$data_account = $this->model_account_master->getAccount("WHERE username = '".$user."' ")->result_array();
			$data_role = $this->model_account_master->getRole("WHERE id_role = '".$data_account[0]['user_access']."' ")->result_array();
			$user_role = $data_account[0]['user_type'];
			$code_role = $data_account[0]['code'];
			
			if($data_role[0]['add_distributor']=='yes')
			{
				
			$this->load->helper('form');
			$this->load->helper('url');
			$this->load->library('form_validation');
		
			$this->form_validation->set_rules('regional','Regional','required');
			$this->form_validation->set_rules('area','Area','required');
			$this->form_validation->set_rules('distributor_code','Distributor Code','required');
			$this->form_validation->set_rules('distributor_name','Distributor Name','required');
			
			if($this->form_validation->run()==FALSE){
					
					$data = array ("");
					$comp = array(
						
						'title' => ' Add Channel',
						'content' => $this->load->view('add-distributor',array('data'=>$data),true),
						'sidebar' => $this->html_sidebar()
					
					);
					
					$this->load->view("common/common",$comp);
			}
			
			else
			{
			
				// Get Variable Post
				$regional= $_POST['regional'];
				$area = $_POST['area'];
				$distributor_code = $_POST['distributor_code'];
				$distributor_name = $_POST['distributor_name'];
				
				$data_insert = array(
				
				"regional" => $regional,
				"area" => $area,
				"distributor_code" => $distributor_code,
				"distributor_name" => $distributor_name

				);
				
				//Check Product Apakah sudah ada dengan kode produk dan type motorist yang sama
				$check = $this->model_distributor->getDistributor("WHERE distributor_code = '".$distributor_code."'");
				if($check->num_rows() >=1 )
				{
					$this->session->set_flashdata('message_failed',"Sorry data already exist!");
					redirect('distributor');
					}
				else
				{
					
					$res = $this->model_distributor->insertData("distributor",$data_insert);
					if($res>=1)
					{
						$this->session->set_flashdata('message_success',"Data distributor has been successfully saved!");
						redirect('distributor');
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
	
	
	
	public function editDistributor($id_distributor)
	{
		
			date_default_timezone_set('Asia/Jakarta');
			ini_set('memory_limit', '-1');
			
			if ($this->tank_auth->is_logged_in()) {
			$user	= $this->tank_auth->get_username();
			$data_account = $this->model_account_master->getAccount("WHERE username = '".$user."' ")->result_array();
			$data_role = $this->model_account_master->getRole("WHERE id_role = '".$data_account[0]['user_access']."' ")->result_array();
			$user_role = $data_account[0]['user_type'];
			$code_role = $data_account[0]['code'];
			
			if($data_role[0]['add_product']=='yes')
			{
				
			$this->load->helper('form');
			$this->load->helper('url');
			$this->load->library('form_validation');
			$this->form_validation->set_rules('id_distributor','ID Distributor','required');
			$this->form_validation->set_rules('regional','Regional','required');
			$this->form_validation->set_rules('area','Area','required');
			$this->form_validation->set_rules('distributor_code','Distributor Code','required');
			$this->form_validation->set_rules('distributor_name','Distributor Name','required');
			
			if($this->form_validation->run()==FALSE){
			
			$check_distributor = $this->model_distributor->getDistributor("WHERE id_distributor = '".$id_distributor."' ");
			if($check_distributor->num_rows() >=1)
			{	
			$data_distributor = $check_distributor->result_array();	
			$data = array (
				"id_distributor" => $data_distributor[0]['id_distributor'],
				"regional" => $data_distributor[0]['regional'],
				"area" => $data_distributor[0]['area'],
				"distributor_code" => $data_distributor[0]['distributor_code'],
				"distributor_name" => $data_distributor[0]['distributor_name']
			);
			
			
			
					$comp = array(
						
						'title' => ' Edit Distributor',
						'content' => $this->load->view('edit-distributor',$data,true),
						'sidebar' => $this->html_sidebar()
					);
					
					$this->load->view("common/common",$comp);
			}
			else
			{
			
			}
				
			
			}
			
			else
			{
				// Get Variable Post
				$id_distributor = $_POST['id_distributor'];
				$regional= $_POST['regional'];
				$area = $_POST['area'];
				$distributor_code = $_POST['distributor_code'];
				$distributor_name = $_POST['distributor_name'];
				
				$data_update = array(
				
				"regional" => $regional,
				"area" => $area,
				"distributor_code" => $distributor_code,
				"distributor_name" => $distributor_name

				);
				
				$where = array("id_distributor"=>$id_distributor);
				
				//Check Product Apakah sudah ada dengan kode produk dan type motorist yang sama
				$check = $this->model_distributor->getDistributor("WHERE distributor_code = '".$distributor_code."' and id_distributor !='".$id_distributor."' ");
				if($check->num_rows() >=1 )
				{
					$this->session->set_flashdata('message_failed',"Sorry data already exist!");
					redirect('distributor');
					
					}
				else
				{
				
					//Update Product
					$res = $this->model_distributor->UpdateData("distributor",$data_update,$where);
					if($res>=1)
					{
						$this->session->set_flashdata('message_success',"Data distributor has been successfully updated!");
						redirect('distributor');
						
						}
					else
					{
						$this->session->set_flashdata('message_failed',"Data distributor failed to update!");
						redirect('distributor');
					}
				}
				
				
				
				
				//Check Product Apakah sudah ada dengan kode produk dan type motorist yang sama
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
	
	
	
	
	public function deleteDistributor($id_distributor)
	{
		
			date_default_timezone_set('Asia/Jakarta');
			ini_set('memory_limit', '-1');
			
			if ($this->tank_auth->is_logged_in()) {
			$user = $this->tank_auth->get_username();
			$data_account = $this->model_account_master->getAccount("WHERE username = '".$user."' ")->result_array();
			$data_role = $this->model_account_master->getRole("WHERE id_role = '".$data_account[0]['user_access']."' ")->result_array();
			$user_role = $data_account[0]['user_type'];
			$code_role = $data_account[0]['code'];
			
			if($data_role[0]['delete_distributor']=='yes')
			{
				
			$this->load->helper('form');
			$this->load->helper('url');
			$this->load->library('form_validation');
			$this->form_validation->set_rules('id_distributor','ID Distributor','required');
			
			if($this->form_validation->run()==FALSE){
			
			$check_distributor = $this->model_distributor->getDistributor("WHERE id_distributor = '".$id_distributor."' ");
			if($check_distributor->num_rows() >=1)
			{	
			$data_distributor= $check_distributor->result_array();	
			$data = array (
				"id_distributor" => $data_distributor[0]['id_distributor'],
				"regional" => $data_distributor[0]['regional'],
				"area" => $data_distributor[0]['area'],
				"distributor_code" => $data_distributor[0]['distributor_code'],
				"distributor_name" => $data_distributor[0]['distributor_name']
			
			);
			
			
			
					$comp = array(
						
						'title' => ' Delete Distributor',
						'content' => $this->load->view('delete-distributor',$data,true),
						'sidebar' => $this->html_sidebar()
					);
					
					$this->load->view("common/common",$comp);
			}
			else
			{
			
			}
				
			
			}
			
			else
			{
				// Get Variable Post
				$id_distributor = $_POST['id_distributor'];
				$where = array("id_distributor" => $id_distributor);
				
		
					//Update Product
					$res = $this->model_distributor->DeleteData("distributor",$where);
					if($res>=1)
					{
						$this->session->set_flashdata('message_success',"Data distributor has been successfully deleted!");
						redirect('distributor');
						
						}
					else
					{
						$this->session->set_flashdata('message_failed',"Data distributor failed to delete!");
						redirect('distributor');
					}
				
				
				
				
				
				//Check Product Apakah sudah ada dengan kode produk dan type motorist yang sama
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
	
	
	public function importDistributor()
	{
		
			date_default_timezone_set('Asia/Jakarta');
			ini_set('memory_limit', '-1');
			
			if ($this->tank_auth->is_logged_in()) {
			$user	= $this->tank_auth->get_username();
			$data_account = $this->model_account_master->getAccount("WHERE username = '".$user."' ")->result_array();
			$data_role = $this->model_account_master->getRole("WHERE id_role = '".$data_account[0]['user_access']."' ")->result_array();
			$user_role = $data_account[0]['user_type'];
			$code_role = $data_account[0]['code'];
			
			if($data_role[0]['import_distributor']=='yes')
			{
				
			$this->load->helper('form', 'html', 'file');
			$this->load->helper('url');
			$this->load->library('form_validation');
		
			
			
					
					$data = array ("");
					$comp = array(
						
						'title' => ' Import Distributor',
						'content' => $this->load->view('import-distributor',array('data'=>$data),true),
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
	
	
	
	public function doImportDistributor()
	{
		
			date_default_timezone_set('Asia/Jakarta');
			ini_set('memory_limit', '-1');
			
			if ($this->tank_auth->is_logged_in()) {
			$user	= $this->tank_auth->get_username();
			$data_account = $this->model_account_master->getAccount("WHERE username = '".$user."' ")->result_array();
			$data_role = $this->model_account_master->getRole("WHERE id_role = '".$data_account[0]['user_access']."' ")->result_array();
			$user_role = $data_account[0]['user_type'];
			$code_role = $data_account[0]['code'];
			
			if($data_role[0]['import_distributor']=='yes')
			{
				
				
			if ($_POST) {
			ini_set('memory_limit', '-1');
		    $fileName = $_FILES['import']['name'];
			$config['upload_path'] = './files/';
			$config['file_name'] = $fileName;
			$config['allowed_types'] = 'xls|xlsx';
			$config['max_size']		= 100000000;

			$this->load->library('upload');
			$this->upload->initialize($config);

			if(! $this->upload->do_upload('import') )
			{
				$this->session->set_flashdata('message_failed','Import Failed, Please upload file excel extension!');
				redirect('distributor');
				
				
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
					$check = $this->model_distributor->getDistributor("WHERE distributor_code  = '".$rowData[0][2]."' ");
					if($check->num_rows() >=1 )
					{
						
						$data_update = array(
							"regional" => $rowData[0][0],
							"area" => $rowData[0][1],
							"distributor_name" => $rowData[0][3]
							
						);
						$where = array(
							"distributor_code" => $rowData[0][2]
						);
						
						$res = $this->model_distributor->UpdateData("distributor",$data_update,$where);
					
						}
					else
					{
						$data_insert = array(
							"regional" => $rowData[0][0],
							"area" => $rowData[0][1],
							"distributor_code" => $rowData[0][2],
							"distributor_name" => $rowData[0][3]
						);
						
						//Insert Data
						$res = $this->model_distributor->insertData("distributor",$data_insert);
					
					}
					
				
				
			}
				@unlink($inputFileName);
				$this->session->set_flashdata('message_success','Data imported successfully');
				redirect('distributor');
			
               
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
	
	
	
	
	
	
	public function exportDistributor()
	{
		
		date_default_timezone_set('Asia/Jakarta');
		if ($this->tank_auth->is_logged_in()) {
		$user	= $this->tank_auth->get_username();
			
		$data_account = $this->model_account_master->getAccount("WHERE username = '".$user."' ")->result_array();
		$data_role = $this->model_account_master->getRole("WHERE id_role = '".$data_account[0]['user_access']."' ")->result_array();
		
		if($data_role[0]['see_distributor']=='yes')
		{
			
		$date = date("m-d-Y");
		
		$search = isset($_GET['search']) ? $_GET['search'] : '';
		$regional = isset($_GET['regional']) ? $_GET['regional'] : '';
		
		
		if($search!="")
		{
			$this->db->like('distributor_code', $search);	
		}
		if($regional!="")
		{
			$this->db->where('regional in ('.$regional.') ');
		}
			
		$query = $this->db->get('distributor');
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
		
		
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 1, "Master Distributor");
		//Merge And Center Title
		$objPHPExcel->getActiveSheet()->mergeCells('A1:D1');
		
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 2, "Date : ".$date);
		
		//Merge And Center Date
		$objPHPExcel->getActiveSheet()->mergeCells('A2:D2');
		
		//Set Font Color Title
		$objPHPExcel->getActiveSheet()->getStyle('A1:D2')->applyFromArray($FontstyleTitle);
		
		//Set Font Color Header
		$objPHPExcel->getActiveSheet()->getStyle('B4:F4')->applyFromArray($Fontstyle);
		
		//Set Backgroung Color Header
		$objPHPExcel->getActiveSheet()->getStyle('B4:F4')->applyFromArray(
			array(
				'fill' => array(
					'type' => PHPExcel_Style_Fill::FILL_SOLID,
					'color' => array('rgb' => '#62a8ea')
				)
			)
		);


		
        // Field names in the first row
         // Field names in the first row
        $fields = array(
		
		"No" => "No",
		"Regional" => "Regional",
		"Area" => "Area",
		"Distributor Code" => "Distributor Code",
		"Distributor Name" => "Distributor Name"
		
		);
        $col = 1;
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
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $row, $no);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $row, $data['regional']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $row, $data['area']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $row, $data['distributor_code']);
		    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, $row, $data['distributor_name']);
            $row++;
			$no++;
        }
		
	   $last_row = $row-1;
	   //Set Border
       $objPHPExcel->getActiveSheet()->getStyle("B4".":"."F".$last_row)->applyFromArray($BStyle);
	   $objPHPExcel->getActiveSheet()->getStyle("B4".":"."F".$last_row)->applyFromArray($styleAlign);
       $objPHPExcel->setActiveSheetIndex(0);
 
        $objWriter = IOFactory::createWriter($objPHPExcel, 'Excel5');
 		
		
	   // Sending headers to force the user to download the file
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Master-Distributor-'.$date.'.xls"');
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