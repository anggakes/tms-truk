<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Transport_report extends CI_Controller {

	function __construct()  {
 		parent::__construct();
			$this->load->library(array('PHPExcel','PHPExcel/IOFactory'));
			$this->load->model('model_account_master');
			$this->load->model('model_transport_report');
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
			
			if($data_role[0]['see_invoice']=='yes')
			{	
			
		
			$comp = array(
				'title' => ' Transport Report',
				'content' => $this->load->view('transport_report',array('data_role'=>$data_role),true),
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
	
	
	
	
	
	public function exportTransportReport()
	{
		
		date_default_timezone_set('Asia/Jakarta');
		if ($this->tank_auth->is_logged_in()) {
		$user	= $this->tank_auth->get_username();
		$data_account = $this->model_account_master->getAccount("WHERE username = '".$user."' ")->result_array();
		$data_role = $this->model_account_master->getRole("WHERE id_role = '".$data_account[0]['user_access']."' ")->result_array();
		$user_role = $data_account[0]['user_type'];
		$code_role = $data_account[0]['code'];
		
		if($data_role[0]['export_room_service']=='yes')
		{
			
			
		$delivery_date = isset($_GET['reservation']) ? $_GET['reservation'] : '';
		if($delivery_date!='')
		{
		$schedule_date = explode('->',$delivery_date);
						
		$start_date = $schedule_date[0];
		$start_date = explode('-',$start_date);
		$start_date = $start_date[2].'-'.$start_date[1].'-'.$start_date[0];
		$start_date = str_replace(" ","",$start_date);
						
		$end_date = $schedule_date[1];
		$end_date = explode('-',$end_date);
		$end_date = $end_date[2].'-'.$end_date[1].'-'.$end_date[0];
		$end_date = str_replace(" ","",$end_date);
		}
		
		$manifest_id = isset($_GET['manifest_id']) ? $_GET['manifest_id'] : '';
		$transporter_id = isset($_GET['transporter_id']) ? $_GET['transporter_id'] : '';
		$client_id = isset($_GET['client_id']) ? $_GET['client_id'] : '';
		$trip = isset($_GET['trip']) ? $_GET['trip'] : '';
		$vehicle_id = isset($_GET['vehicle_id']) ? $_GET['vehicle_id'] : '';
		$origin = isset($_GET['origin']) ? $_GET['origin'] : '';
		$destination = isset($_GET['destination']) ? $_GET['destination'] : '';
		$transporter = isset($_GET['transporter']) ? $_GET['transporter'] : '';
		$status_manifest = isset($_GET['status_manifest']) ? $_GET['status_manifest'] : '';
		$driver_code = isset($_GET['driver_code']) ? $_GET['driver_code'] : '';
		
		
		
		$date = date("m-d-Y");
		
		if($delivery_date!='')
		{$this->db->where("delivery_date between '".$start_date."' AND '".$end_date."' ");}
	
		if($manifest_id!='')
		{$this->db->where("id_manifest = '".$manifest_id."' ");}
	
		if($transporter_id!='')
		{$this->db->where("transporter_id = '".$transporter_id."' ");}
	
		if($client_id!='')
		{$this->db->where("client_id = '".$client_id."' ");}
	
		if($trip!='')
		{$this->db->where("trip = '".$trip."' ");}
	
		if($vehicle_id!='')
		{$this->db->where("vehicle_id = '".$vehicle_id."' ");}
	
		if($origin!='')
		{$this->db->where("origin_id = '".$origin."' ");}
	
		if($destination!='')
		{$this->db->where("destination_id = '".$destination."' ");}
	
		if($transporter!='')
		{$this->db->where("transporter = '".$transporter."' ");}
	
		if($status_manifest!='')
		{$this->db->where("status_manifest = '".$status_manifest."' ");}
		
		if($driver_code!='')
		{$this->db->where("driver_code = '".$driver_code."' ");}
		
		$query = $this->db->get('master_manifest');
		
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
		
		
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 1, "Transport Report");
		//Merge And Center Title
		$objPHPExcel->getActiveSheet()->mergeCells('A1:D1');
		
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 2, "Download Date : ".$date);
		
		//Merge And Center Date
		$objPHPExcel->getActiveSheet()->mergeCells('A2:D2');
		
		//Set Font Color Title
		$objPHPExcel->getActiveSheet()->getStyle('A1:D2')->applyFromArray($FontstyleTitle);
		
		//Set Font Color Header
		$objPHPExcel->getActiveSheet()->getStyle('A4:R4')->applyFromArray($Fontstyle);
		
		//Set Backgroung Color Header
		$objPHPExcel->getActiveSheet()->getStyle('A4:R4')->applyFromArray(
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
		
		"Manifest ID" => "Manifest ID",
		"Vehicle Type" => "Vehicle Type",
		"Vehicle ID" => "Vehicle ID",
		"Driver Code" => "Driver Code",
		"Driver Name" => "Driver Name",
		"Client ID" => "Client ID",
		"Client Name" => "Client Name",
		"Transporter" => "Transporter",
		"Transporter ID" => "Transporter ID",
		"Transporter Name" => "Transporter Name",
		"Trip" => "Trip",
		"Origin ID" => "Origin ID",
		"Origin Area" => "Origin Area",
		"Origin Destination" => "Origin Destination",
		"Destination ID" => "Destination ID",
		"Destination Area" => "Destination Area",
		"Destination Destination" => "Destination Destination",
		"Status Manifest" => "Status Manifest"
		
		
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
		
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $row, $data['id_manifest']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $row, $data['vehicle_type']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $row, $data['vehicle_id']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $row, $data['driver_code']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $row, $data['driver_name']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, $row, $data['client_id']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, $row, $data['client_name']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, $row, $data['transporter']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8, $row, $data['transporter_id']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9, $row, $data['transporter_name']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(10, $row, $data['trip']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(11, $row, $data['origin_id']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(12, $row, $data['origin_area']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(13, $row, $data['origin_address']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(14, $row, $data['destination_id']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(15, $row, $data['destination_area']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(16, $row, $data['destination_address']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(17, $row, $data['status_manifest']);
 
 
            $row++;
			$no++;
        }
		
	   $last_row = $row-1;
	   //Set Border
       $objPHPExcel->getActiveSheet()->getStyle("A4".":"."R".$last_row)->applyFromArray($BStyle);
	   $objPHPExcel->getActiveSheet()->getStyle("A4".":"."R".$last_row)->applyFromArray($styleAlign);
       $objPHPExcel->setActiveSheetIndex(0);
 
        $objWriter = IOFactory::createWriter($objPHPExcel, 'Excel5');
 		
		
	   // Sending headers to force the user to download the file
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Transport-report-'.$date.'.xls"');
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