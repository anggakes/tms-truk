<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class DSOR extends CI_Controller {

	function __construct()  {
 		parent::__construct();
			$this->load->library(array('PHPExcel','PHPExcel/IOFactory'));
			$this->load->model('model_account_master');
			$this->load->model('model_noo');
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
			
			if($data_role[0]['see_store']=='yes')
			{	
			
			$this->load->library('table');
			$this->load->library('pagination');
			$search = isset($_GET['search']) ? $_GET['search'] : '';
			$date = isset($_GET['date']) ? $_GET['date'] : '';
			$regional = isset($_GET['regional']) ? $_GET['regional'] : '';
			if(isset($_GET['regional']))
			{
				$regional = "'" . implode("','", $regional) . "'";
			}
			
			$motorist_type = isset($_GET['motorist_type']) ? $_GET['motorist_type'] : '';
			if(isset($_GET['motorist_type']))
			{$motorist_type = implode(",",$motorist_type);}
			if (count($_GET) > 0) $config['suffix'] = '?' . http_build_query($_GET, '', "&");
			$jumlah= $this->model_noo->countNoo($search,$user_role,$code_role,$date,$regional,$motorist_type);
			$config['base_url'] = base_url().'index.php/noo/noo/';
			$config['total_rows'] = $jumlah;
			$config['first_link'] = 'First';
			$config['last_link'] = 'End';
			$config['next_link'] = 'Next';
			$config['prev_link'] = 'Previous';
			$config['per_page'] = 20; 	
			
			if (count($_GET) > 0) $config['suffix'] = '?' . http_build_query($_GET, '', "&");
			$config['first_url'] = $config['base_url'].'?'.http_build_query($_GET);
				
			$dari = $this->uri->segment('3');
			$data = $this->model_noo->dataNoo($config['per_page'],$dari,$search,$user_role,$code_role,$date,$regional,$motorist_type);
			$data_regional = $this->model_noo->getRegional()->result_array();
			$data_motorist_type = $this->model_noo->getMotoristType()->result_array();
			$this->pagination->initialize($config);
			
		
			$comp = array(
				
				'title' => ' Noo',
				'content' => $this->load->view('noo',array('data_account'=>$data_account,'data_regional'=>$data_regional,'data_motorist_type'=>$data_motorist_type,'data_noo'=>$data,'search'=>$search),true),
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
	
	
	
	
	
	public function exportNoo()
	{
		
		date_default_timezone_set('Asia/Jakarta');
		if ($this->tank_auth->is_logged_in()) {
		$user	= $this->tank_auth->get_username();
			
		$data_account = $this->model_account_master->getAccount("WHERE username = '".$user."' ")->result_array();
		$data_role = $this->model_account_master->getRole("WHERE id_role = '".$data_account[0]['user_access']."' ")->result_array();
		
		$search = isset($_GET['search']) ? $_GET['search'] : '';
		$date_seacrh = isset($_GET['date']) ? $_GET['date'] : '';
			
		
		$user_role = $data_account[0]['user_type'];
			$code_role = $data_account[0]['code'];
		if($data_role[0]['see_store']=='yes')
		{
			
		$date_now = date("m-d-Y");
		
		
		$search = isset($_GET['search']) ? $_GET['search'] : '';
		$date = isset($_GET['date']) ? $_GET['date'] : '';
		$regional = isset($_GET['regional']) ? $_GET['regional'] : '';
		$motorist_type = isset($_GET['motorist_type']) ? $_GET['motorist_type'] : '';
		
		
		
		
		
		if($date != '')
		{
			$tanggal_range_pecah = explode(" - ", $date);
			$tanggal_from = $tanggal_range_pecah[0];
			$tanggal_from = explode("/", $tanggal_from);
			$tanggal_from = $tanggal_from[2].'-'.$tanggal_from[0].'-'.$tanggal_from[1];
			
			$tanggal_to = $tanggal_range_pecah[1];
			$tanggal_to = explode("/", $tanggal_to);
			$tanggal_to = $tanggal_to[2].'-'.$tanggal_to[0].'-'.$tanggal_to[1];
			
			$this->db->where("noo.customer_create_date BETWEEN '".$tanggal_from." 00:00:00' AND '".$tanggal_to." 23:59:59' "); 
		}
		
		if($regional!="")
		{
			$this->db->where('regional in ('.$regional.') ');
		}
		
		if($motorist_type!="")
		{
			$this->db->where('motorist.motorist_type in ('.$motorist_type.') ');
		}
		
		if($user_role=="Ado")
		{
			$this->db->where('distributor_code = "'.$code_role.'" ');
		}
		$this->db->like('noo.motorist_code', $search);
		$this->db->join('motorist', 'motorist.motorist_code = noo.motorist_code');
		$this->db->join('motorist_type', 'motorist_type.id_motorist_type = motorist.motorist_type');
		$query = $this->db->get('noo');
		
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
			'color' => array('rgb' => 'ffffff'),
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
		
		
		
		
		//Set Backgroung Color Header
		$objPHPExcel->getActiveSheet()->getStyle('A1:Q1')->applyFromArray(
			array(
				'fill' => array(
					'type' => PHPExcel_Style_Fill::FILL_SOLID,
					'color' => array('rgb' => '#a5eef7')
				)
			)
		);


		
        // Field names in the first row
         // Field names in the first row
        $fields = array(
		
		"Distributor Code" => "Distributor Code",
		"Store Code" => "Store Code",
		"Motorist Code" => "Motorist Code",
		"Day Visit" => "Day Visit",
		"Channel Code" => "Channel Code",
		"Frequency" => "Frequency",
		"Customer Name" => "Customer Name",
		"Customer Contact" => "Customer Contact",
		"Customer Status" => "Customer Status",
		"Place Status" => "Place Status",
		"Address" => "Address",
		"District" => "District",
		"Latitude" => "Longitude",
		"Longitude" => "Longitude",
		"QR Code Status" => "QR Code Status",
		"Foto Toko" => "Foto Toko",
		"Loyatly Store" => "Loyatly Store"
		
		);
        $col = 0;
        foreach ($fields as $field)
        {
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, 1, $field);
            $col++;
        }
		
		
		

 
        // Fetching the table data
        $row = 2;
		$no = 1;
        foreach($query->result_array() as $data)
        {
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $row, $data['distributor_code']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $row, "");
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $row, $data['motorist_code']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $row, $data['day_visit']);
			$type = PHPExcel_Cell_DataType::TYPE_STRING;
			$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(4, $row)->setValueExplicit($data['channel_code'], $type);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, $row, $data['frequency']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, $row, $data['customer_name']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, $row, $data['customer_contact']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8, $row, "active");
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9, $row, $data['place_status']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(10, $row, $data['address']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(11, $row, $data['districts']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(12, $row, $data['latitude']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(13, $row, $data['longitude']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(14, $row, "");
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(15, $row, $data['foto_toko']);
 			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(15, $row, $data['loyalty_store']);
            $row++;
			$no++;
        }
		
	   $last_row = $row-1;
	   //Set Border
       $objPHPExcel->getActiveSheet()->getStyle("A1".":"."Q".$last_row)->applyFromArray($BStyle);
	   $objPHPExcel->getActiveSheet()->getStyle("A1".":"."Q".$last_row)->applyFromArray($styleAlign);
       $objPHPExcel->setActiveSheetIndex(0);
 
        $objWriter = IOFactory::createWriter($objPHPExcel, 'Excel5');
 		
		
	   // Sending headers to force the user to download the file
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Export-noo-'.$date_now.'.xls"');
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