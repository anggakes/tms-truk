<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Channel extends CI_Controller {

	function __construct()  {
 		parent::__construct();
			$this->load->library(array('PHPExcel','PHPExcel/IOFactory'));
			$this->load->model('model_account_master');
			$this->load->model('model_channel');
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
			
			if($data_role[0]['see_channel']=='yes')
			{	
			
			$this->load->library('table');
			$this->load->library('pagination');
			$search = isset($_GET['search']) ? $_GET['search'] : '';
			$jumlah= $this->model_channel->countChannel($search);
			$config['base_url'] = base_url().'index.php/channel/';
			$config['total_rows'] = $jumlah;
			$config['first_link'] = 'First';
			$config['last_link'] = 'End';
			$config['next_link'] = 'Next';
			$config['prev_link'] = 'Previous';
			$config['per_page'] = 20; 	
			
			$dari = $this->uri->segment('3');
			$data = $this->model_channel->dataChannel($config['per_page'],$dari,$search);
			$this->pagination->initialize($config);
			
		
			$comp = array(
				
				'title' => ' Channel',
				'content' => $this->load->view('channel',array('data_channel'=>$data,'search'=>$search),true),
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
	
	
	
	public function addChannel()
	{
		
			date_default_timezone_set('Asia/Jakarta');
			ini_set('memory_limit', '-1');
			
			if ($this->tank_auth->is_logged_in()) {
			$user	= $this->tank_auth->get_username();
			$data_account = $this->model_account_master->getAccount("WHERE username = '".$user."' ")->result_array();
			$data_role = $this->model_account_master->getRole("WHERE id_role = '".$data_account[0]['user_access']."' ")->result_array();
			$user_role = $data_account[0]['user_type'];
			$code_role = $data_account[0]['code'];
			
			if($data_role[0]['add_channel']=='yes')
			{
				
			$this->load->helper('form');
			$this->load->helper('url');
			$this->load->library('form_validation');
		
			$this->form_validation->set_rules('classification_code','Classification Code','required');
			$this->form_validation->set_rules('channel_description','Channel Description','required');
			$this->form_validation->set_rules('sample','Sample','required');
			
			if($this->form_validation->run()==FALSE){
					
					$data = array ("");
					$comp = array(
						
						'title' => ' Add Channel',
						'content' => $this->load->view('add-channel',array('data'=>$data),true),
						'sidebar' => $this->html_sidebar()
					
					);
					
					$this->load->view("common/common",$comp);
			}
			
			else
			{
				// Get Variable Post
				$classification_code = $_POST['classification_code'];
				$channel_description = $_POST['channel_description'];
				$sample = $_POST['sample'];
				
				$data_insert = array(
				
				"classification_code" => $classification_code,
				"channel_description" => $channel_description,
				"sample" => $sample

				);
				
				//Check Product Apakah sudah ada dengan kode produk dan type motorist yang sama
				$check = $this->model_channel->getChannel("WHERE classification_code = '".$classification_code."'");
				if($check->num_rows() >=1 )
				{
					$this->session->set_flashdata('message_failed',"Sorry data already exist!");
					redirect('channel');
					}
				else
				{
					
					$res = $this->model_channel->insertData("channel",$data_insert);
					if($res>=1)
					{
						$this->session->set_flashdata('message_success',"Data channel has been successfully saved!");
						redirect('channel');
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
	
	
	
	public function editChannel($id_channel)
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
			$this->form_validation->set_rules('id_channel','ID Channel','required');
			$this->form_validation->set_rules('classification_code','Classification Code','required');
			$this->form_validation->set_rules('channel_description','Channel Description','required');
			$this->form_validation->set_rules('sample','Sample','required');
			
			if($this->form_validation->run()==FALSE){
			
			$check_channel = $this->model_channel->getChannel("WHERE id_channel = '".$id_channel."' ");
			if($check_channel->num_rows() >=1)
			{	
			$data_channel = $check_channel->result_array();	
			$data = array (
				"id_channel" => $data_channel[0]['id_channel'],
				"classification_code" => $data_channel[0]['classification_code'],
				"channel_description" => $data_channel[0]['channel_description'],
				"sample" => $data_channel[0]['sample']
			);
			
			
			
					$comp = array(
						
						'title' => ' Edit Channel',
						'content' => $this->load->view('edit-channel',$data,true),
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
				$id_channel = $_POST['id_channel'];
				$classification_code = $_POST['classification_code'];
				$channel_description = $_POST['channel_description'];
				$sample = $_POST['sample'];
				
				$data_update = array(
				
				"classification_code" => $classification_code,
				"channel_description" => $channel_description,
				"sample" => $sample

				);
				
				$where = array("id_channel"=>$id_channel);
				
				//Check Product Apakah sudah ada dengan kode produk dan type motorist yang sama
				$check = $this->model_channel->getChannel("WHERE classification_code = '".$classification_code."' ");
				if($check->num_rows() >=1 )
				{
					$this->session->set_flashdata('message_failed',"Sorry data already exist!");
					redirect('channel');
					
					}
				else
				{
				
					//Update Product
					$res = $this->model_channel->UpdateData("channel",$data_update,$where);
					if($res>=1)
					{
						$this->session->set_flashdata('message_success',"Data channel has been successfully updated!");
						redirect('channel');
						
						}
					else
					{
						$this->session->set_flashdata('message_failed',"Data channel failed to update!");
						redirect('channel');
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
	
	
	
	
	public function deleteChannel($id_channel)
	{
		
			date_default_timezone_set('Asia/Jakarta');
			ini_set('memory_limit', '-1');
			
			if ($this->tank_auth->is_logged_in()) {
			$user	= $this->tank_auth->get_username();
			$data_account = $this->model_account_master->getAccount("WHERE username = '".$user."' ")->result_array();
			$data_role = $this->model_account_master->getRole("WHERE id_role = '".$data_account[0]['user_access']."' ")->result_array();
			$user_role = $data_account[0]['user_type'];
			$code_role = $data_account[0]['code'];
			
			if($data_role[0]['delete_channel']=='yes')
			{
				
			$this->load->helper('form');
			$this->load->helper('url');
			$this->load->library('form_validation');
			$this->form_validation->set_rules('id_channel','ID Channel','required');
			
			if($this->form_validation->run()==FALSE){
			
			$check_channel = $this->model_channel->getChannel("WHERE id_channel = '".$id_channel."' ");
			if($check_channel->num_rows() >=1)
			{	
			$data_channel = $check_channel->result_array();	
			$data = array (
				"id_channel" => $data_channel[0]['id_channel'],
				"classification_code" => $data_channel[0]['classification_code'],
				"channel_description" => $data_channel[0]['channel_description'],
				"sample" => $data_channel[0]['sample']
			
			);
			
			
			
					$comp = array(
						
						'title' => ' Delete Channel',
						'content' => $this->load->view('delete-channel',$data,true),
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
				$id_channel = $_POST['id_channel'];
				$where = array("id_channel" => $id_channel);
				
		
					//Update Product
					$res = $this->model_channel->DeleteData("channel",$where);
					if($res>=1)
					{
						$this->session->set_flashdata('message_success',"Data channel has been successfully deleted!");
						redirect('channel');
						
						}
					else
					{
						$this->session->set_flashdata('message_failed',"Data channel failed to delete!");
						redirect('channel');
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
	
	
	public function importChannel()
	{
		
			date_default_timezone_set('Asia/Jakarta');
			ini_set('memory_limit', '-1');
			
			if ($this->tank_auth->is_logged_in()) {
			$user	= $this->tank_auth->get_username();
			$data_account = $this->model_account_master->getAccount("WHERE username = '".$user."' ")->result_array();
			$data_role = $this->model_account_master->getRole("WHERE id_role = '".$data_account[0]['user_access']."' ")->result_array();
			$user_role = $data_account[0]['user_type'];
			$code_role = $data_account[0]['code'];
			
			if($data_role[0]['import_channel']=='yes')
			{
				
			$this->load->helper('form', 'html', 'file');
			$this->load->helper('url');
			$this->load->library('form_validation');
		
			
			
					
					$data = array ("");
					$comp = array(
						
						'title' => ' Import Channel',
						'content' => $this->load->view('import-channel',array('data'=>$data),true),
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
	
	
	
	public function doImportChannel()
	{
		
			date_default_timezone_set('Asia/Jakarta');
			ini_set('memory_limit', '-1');
			
			if ($this->tank_auth->is_logged_in()) {
			$user	= $this->tank_auth->get_username();
			$data_account = $this->model_account_master->getAccount("WHERE username = '".$user."' ")->result_array();
			$data_role = $this->model_account_master->getRole("WHERE id_role = '".$data_account[0]['user_access']."' ")->result_array();
			$user_role = $data_account[0]['user_type'];
			$code_role = $data_account[0]['code'];
			
			if($data_role[0]['import_channel']=='yes')
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
				redirect('channel');
				
				
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
					$check = $this->model_channel->getChannel("WHERE classification_code  = '".$rowData[0][0]."' ");
					if($check->num_rows() >=1 )
					{
						
						$data_update = array(
							"channel_description" => $rowData[0][1],
							"sample" => $rowData[0][2]
							
						);
						$where = array(
							"classification_code" => $rowData[0][0]
						);
						
						$res = $this->model_channel->UpdateData("channel",$data_update,$where);
					
						}
					else
					{
						$data_insert = array(
							"classification_code" => $rowData[0][0],
							"channel_description" => $rowData[0][1],
							"sample" => $rowData[0][2]
						);
						
						//Insert Data
						$res = $this->model_channel->insertData("channel",$data_insert);
					
					}
					
				
				
			}
				@unlink($inputFileName);
				$this->session->set_flashdata('message_success','Data imported successfully');
				redirect('channel');
			
               
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
	
	
	
	
	
	public function exportChannel()
	{
		
		date_default_timezone_set('Asia/Jakarta');
		if ($this->tank_auth->is_logged_in()) {
		$user	= $this->tank_auth->get_username();
			
		$data_account = $this->model_account_master->getAccount("WHERE username = '".$user."' ")->result_array();
		$data_role = $this->model_account_master->getRole("WHERE id_role = '".$data_account[0]['user_access']."' ")->result_array();
		
		if($data_role[0]['see_channel']=='yes')
		{
			
		$date = date("m-d-Y");
		$query = $this->db->get('channel');
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
		
		
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 1, "Master Channel");
		//Merge And Center Title
		$objPHPExcel->getActiveSheet()->mergeCells('A1:D1');
		
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 2, "Date : ".$date);
		
		//Merge And Center Date
		$objPHPExcel->getActiveSheet()->mergeCells('A2:D2');
		
		//Set Font Color Title
		$objPHPExcel->getActiveSheet()->getStyle('A1:D2')->applyFromArray($FontstyleTitle);
		
		//Set Font Color Header
		$objPHPExcel->getActiveSheet()->getStyle('B4:E4')->applyFromArray($Fontstyle);
		
		//Set Backgroung Color Header
		$objPHPExcel->getActiveSheet()->getStyle('B4:E4')->applyFromArray(
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
		"Customer Outlet Classification Code" => "Customer Outlet Classification Code",
		"Channel Description" => "Channel Description",
		"Sample" => "Sample"
		
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
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $row, $data['classification_code']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $row, $data['channel_description']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $row, $data['sample']);
 
            $row++;
			$no++;
        }
		
	   $last_row = $row-1;
	   //Set Border
       $objPHPExcel->getActiveSheet()->getStyle("B4".":"."E".$last_row)->applyFromArray($BStyle);
	   $objPHPExcel->getActiveSheet()->getStyle("B4".":"."D".$last_row)->applyFromArray($styleAlign);
       $objPHPExcel->setActiveSheetIndex(0);
 
        $objWriter = IOFactory::createWriter($objPHPExcel, 'Excel5');
 		
		
	   // Sending headers to force the user to download the file
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Master-Channel-'.$date.'.xls"');
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