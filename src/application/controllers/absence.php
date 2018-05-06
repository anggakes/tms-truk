<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Absence extends CI_Controller {

	function __construct()  {
 		parent::__construct();
			$this->load->library(array('PHPExcel','PHPExcel/IOFactory'));
			$this->load->model('model_account_master');
			$this->load->model('model_absence');
			$this->load->library('tank_auth');
			
	}
	
	public function summaryAbsenceDriver()
	{
			date_default_timezone_set('Asia/Jakarta');
			if ($this->tank_auth->is_logged_in()) {
			$user	= $this->tank_auth->get_username();
			$data_account = $this->model_account_master->getAccount("WHERE username = '".$user."' ")->result_array();
			$data_role = $this->model_account_master->getRole("WHERE id_role = '".$data_account[0]['user_access']."' ")->result_array();
			$user_role = $data_account[0]['user_type'];
			$code_role = $data_account[0]['code'];
		
			if($data_role[0]['see_driver']=='yes')
			{	
			$this->load->library('table');
			$this->load->library('pagination');
			$search = isset($_GET['search']) ? $_GET['search'] : '';
			$bulan = isset($_GET['bulan']) ? $_GET['bulan'] : '';
			$year = isset($_GET['tahun']) ? $_GET['tahun'] : '';
			
			$regional = isset($_GET['regional']) ? $_GET['regional'] : '';
			if(isset($_GET['regional']))
			{
				$regional = "'" . implode("','", $regional) . "'";
			}
			
			$distributor = isset($_GET['distributor']) ? $_GET['distributor'] : '';
			if(isset($_GET['distributor']))
			{$distributor = implode(",",$distributor);}
			
			$area = isset($_GET['area']) ? $_GET['area'] : '';
			if(isset($_GET['area']))
			{
				$area = "'" . implode("','", $area) . "'";
			}
			
			$motorist_type = isset($_GET['motorist_type']) ? $_GET['motorist_type'] : '';
			if(isset($_GET['motorist_type']))
			{$motorist_type = implode(",",$motorist_type);}
			
			if (count($_GET) > 0) $config['suffix'] = '?' . http_build_query($_GET, '', "&");
			$jumlah= $this->model_absence->countSummaryAbsenceDriver($search);
			$config['base_url'] = base_url().'index.php/absence/summaryAbsenceDriver/';
			$config['total_rows'] = $jumlah;
			$config['first_link'] = 'First';
			$config['last_link'] = 'End';
			$config['next_link'] = 'Next';
			$config['prev_link'] = 'Previous';
			$config['per_page'] = 5; 	
			
			if (count($_GET) > 0) $config['suffix'] = '?' . http_build_query($_GET, '', "&");
			$config['first_url'] = $config['base_url'].'?'.http_build_query($_GET);
			$dari = $this->uri->segment('3');
			$data = $this->model_absence->dataSummaryAbsenceDriver($config['per_page'],$dari,$search);
			$this->pagination->initialize($config);
			
			
			
		
			$comp = array(
				
				'title' => ' Summary Absence',
				'content' => $this->load->view('summary-absence-driver',array('data_absence'=>$data,'search'=>$search),true),
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
			
			if (count($_GET) > 0) $config['suffix'] = '?' . http_build_query($_GET, '', "&");
			$jumlah= $this->model_absence->countAbsence($search,$user_role,$code_role,$date);
			$config['base_url'] = base_url().'index.php/absence/absence/';
			$config['total_rows'] = $jumlah;
			$config['first_link'] = 'First';
			$config['last_link'] = 'End';
			$config['next_link'] = 'Next';
			$config['prev_link'] = 'Previous';
			$config['per_page'] = 5; 	
			
			if (count($_GET) > 0) $config['suffix'] = '?' . http_build_query($_GET, '', "&");
			$config['first_url'] = $config['base_url'].'?'.http_build_query($_GET);
				
			$dari = $this->uri->segment('3');
			$data = $this->model_absence->dataAbsence($config['per_page'],$dari,$search,$user_role,$code_role,$date);
			$this->pagination->initialize($config);
			
		
			$comp = array(
				
				'title' => ' Absence',
				'content' => $this->load->view('absence',array('data_absence'=>$data,'search'=>$search),true),
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
	
	
	public function detailAbsenceDriver($id_absence)
	{
		
			date_default_timezone_set('Asia/Jakarta');
			ini_set('memory_limit', '-1');
			
			if ($this->tank_auth->is_logged_in()) {
			$user	= $this->tank_auth->get_username();
			$data_account = $this->model_account_master->getAccount("WHERE username = '".$user."' ")->result_array();
			$data_role = $this->model_account_master->getRole("WHERE id_role = '".$data_account[0]['user_access']."' ")->result_array();
			$user_role = $data_account[0]['user_type'];
			$code_role = $data_account[0]['code'];
			
			if($data_role[0]['see_driver']=='yes')
			{
				
			$this->load->helper('form');
			$this->load->helper('url');
			$this->load->library('form_validation');
			$this->form_validation->set_rules('id_store','ID Store','required');
			
			
			
			$check_absence = $this->model_absence->getAbsencDriver("WHERE id_absence = '".$id_absence."' ");
			if($check_absence->num_rows() >=1)
			{	
			$data_absence = $check_absence->result_array();	
		
			$data = array (
				"id_absence" => $data_absence[0]['id_absence'],
				"status_absence" => $data_absence[0]['status_absence'],
				"driver_code" => $data_absence[0]['driver_code'],
				"driver_name" => $data_absence[0]['driver_name'],
				"date_absence" => $data_absence[0]['date_absence'],
				"keterangan" => $data_absence[0]['keterangan'],
				"image_absence" => $data_absence[0]['image_absence'],
				"latitude" => $data_absence[0]['latitude'],
				"longitude" => $data_absence[0]['longitude'],
				"setoran" => $data_absence[0]['setoran'],
				"konfirmasi_kasir" => $data_absence[0]['konfirmasi_kasir'],
				"tanggal_konfirmasi_kasir" => $data_absence[0]['tanggal_konfirmasi_kasir']
				
			);
			
			
		
			
			
					$comp = array(
						
						'title' => ' Detail Absence',
						'content' => $this->load->view('detail-absence-driver',$data,true),
						'sidebar' => $this->html_sidebar()
					);
					
					$this->load->view("common/common",$comp);
			}
	
			
			
			
			else
			{
				// Get Variable Post
				$id_store = $_POST['id_store'];
				$where = array("id_store" => $id_store);
				
		
					//Update Product
					$res = $this->model_store->DeleteData("store",$where);
					if($res>=1)
					{
						$this->session->set_flashdata('message_success',"Data store has been successfully deleted!");
						redirect('store');
						
						}
					else
					{
						$this->session->set_flashdata('message_failed',"Data store failed to delete!");
						redirect('store');
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
	
	
	public function detailAbsence($id_absence)
	{
		
			date_default_timezone_set('Asia/Jakarta');
			ini_set('memory_limit', '-1');
			
			if ($this->tank_auth->is_logged_in()) {
			$user	= $this->tank_auth->get_username();
			$data_account = $this->model_account_master->getAccount("WHERE username = '".$user."' ")->result_array();
			$data_role = $this->model_account_master->getRole("WHERE id_role = '".$data_account[0]['user_access']."' ")->result_array();
			$user_role = $data_account[0]['user_type'];
			$code_role = $data_account[0]['code'];
			
			if($data_role[0]['see_store']=='yes')
			{
				
			$this->load->helper('form');
			$this->load->helper('url');
			$this->load->library('form_validation');
			$this->form_validation->set_rules('id_store','ID Store','required');
			
			
			
			$check_absence = $this->model_absence->getAbsence("WHERE id_absence = '".$id_absence."' ");
			if($check_absence->num_rows() >=1)
			{	
			$data_absence = $check_absence->result_array();	
		
			$data = array (
				"id_absence" => $data_absence[0]['id_absence'],
				"status_absence" => $data_absence[0]['status_absence'],
				"motorist_code" => $data_absence[0]['motorist_code'],
				"motorist_name" => $data_absence[0]['motorist_name'],
				"date_absence" => $data_absence[0]['date_absence'],
				"keterangan" => $data_absence[0]['keterangan'],
				"image_absence" => $data_absence[0]['image_absence'],
				"latitude" => $data_absence[0]['latitude'],
				"longitude" => $data_absence[0]['longitude'],
				"setoran" => $data_absence[0]['setoran'],
				"konfirmasi_kasir" => $data_absence[0]['konfirmasi_kasir'],
				"tanggal_konfirmasi_kasir" => $data_absence[0]['tanggal_konfirmasi_kasir']
				
			);
			
			
		
			
			
					$comp = array(
						
						'title' => ' Detail Absence',
						'content' => $this->load->view('detail-absence',$data,true),
						'sidebar' => $this->html_sidebar()
					);
					
					$this->load->view("common/common",$comp);
			}
	
			
			
			
			else
			{
				// Get Variable Post
				$id_store = $_POST['id_store'];
				$where = array("id_store" => $id_store);
				
		
					//Update Product
					$res = $this->model_store->DeleteData("store",$where);
					if($res>=1)
					{
						$this->session->set_flashdata('message_success',"Data store has been successfully deleted!");
						redirect('store');
						
						}
					else
					{
						$this->session->set_flashdata('message_failed',"Data store failed to delete!");
						redirect('store');
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
	
	public function exportSummaryAbsence()
	{
		
		date_default_timezone_set('Asia/Jakarta');
		if ($this->tank_auth->is_logged_in()) {
		$user	= $this->tank_auth->get_username();
			
		$data_account = $this->model_account_master->getAccount("WHERE username = '".$user."' ")->result_array();
		$data_role = $this->model_account_master->getRole("WHERE id_role = '".$data_account[0]['user_access']."' ")->result_array();
		$user_role = $data_account[0]['user_type'];
		$code_role = $data_account[0]['code'];
		$data_role_etools = $this->model_account_master->getRoleEtools("WHERE id_role = '".$data_account[0]['ket']."' ")->result_array();
		$ket = $data_role_etools[0]['motorist_view'];
			
		if($data_role[0]['see_motorist']=='yes')
		{
			
		$date = date("m-d-Y");
		
		
		$search = isset($_GET['search']) ? $_GET['search'] : '';
		$bulan = isset($_GET['bulan']) ? $_GET['bulan'] : '';
		$year = isset($_GET['year']) ? $_GET['year'] : '';
			
		$regional = isset($_GET['regional']) ? $_GET['regional'] : '';
		$distributor = isset($_GET['distributor']) ? $_GET['distributor'] : '';
		$area = isset($_GET['area']) ? $_GET['area'] : '';
			
		$motorist_type = isset($_GET['motorist_type']) ? $_GET['motorist_type'] : '';
		
		
		if($regional!="")
		{
			$this->db->where('regional in ('.$regional.') ');
		}
		
		if($distributor!="")
		{
			
			$this->db->where('motorist.distributor_code in ('.$distributor.') ');
		}
		if($area!="")
		{
			$this->db->where('area in ('.$area.') ');
		}
		
		if($motorist_type!="")
		{
			$this->db->where('motorist.motorist_type in ('.$motorist_type.') ');
		}
		
		if($bulan!="")
		{$bulan=$bulan;}
		else
		{$bulan = date('m');}
		
		if($year!="")
		{$year=$year;}
		else
		{$year = date('Y');}
		
		$tanggal_bulan_awal = $year.'-'.$bulan."-01 00:00:00";
		$tanggal_bulan_akhir = $year.'-'.$bulan."-31 23:59:59";
		
		
		$this->db->select(" * ,(SELECT COUNT(id_absence) FROM absence as a WHERE a.id_motorist = motorist.id_motorist AND status_absence = 'hadir' AND date_absence between '".$tanggal_bulan_awal."' AND '".$tanggal_bulan_akhir."' ) as total_hadir
		,(SELECT COUNT(id_absence) FROM absence as a WHERE a.id_motorist = motorist.id_motorist AND status_absence = 'sakit' AND date_absence between '".$tanggal_bulan_awal."' AND '".$tanggal_bulan_akhir."' ) as total_sakit
		,(SELECT COUNT(id_absence) FROM absence as a WHERE a.id_motorist = motorist.id_motorist AND status_absence = 'izin' AND date_absence between '".$tanggal_bulan_awal."' AND '".$tanggal_bulan_akhir."' ) as total_izin");
		
		
		
		$this->db->where("motorist.motorist_type in (".$ket.") ");
		if($user_role=="Ado")
		{
			$this->db->where("motorist.distributor_code = '".$code_role."' ");
		}
		else if($user_role=="Regional")
		{
			$this->db->where("distributor.regional = '".$code_role."' ");		
		}
		
		
		$this->db->like('motorist.motorist_code', $search);
		$this->db->join('motorist_type', 'motorist_type.id_motorist_type = motorist.motorist_type','left');
		$this->db->join('distributor', 'distributor.distributor_code = motorist.distributor_code','left');
		$query = $this->db->get('motorist');
		
		if($bulan=="")
				{
				$month = date('n');
				$month_with_null = date('m');
				}
				else
				{
					$month = intval($bulan);
					$month_with_null = $bulan;
					}
					
				if($year=="")
				{
				$year = date('Y');
				}
				else
				{
				$year = $year;
				}
					
				$total_day = cal_days_in_month(CAL_GREGORIAN, $month, $year); // 31	
		
		function number_of_working_days($from, $to) {
				$workingDays = [1,2,3,4,5,6]; 
				$holidayDays = [];
			
				$from = new DateTime($from);
				$to = new DateTime($to);
				$to->modify('+1 day');
				$interval = new DateInterval('P1D');
				$periods = new DatePeriod($from, $interval, $to);
			
				$days = 0;
				foreach ($periods as $period) {
					if (!in_array($period->format('N'), $workingDays)) continue;
					if (in_array($period->format('Y-m-d'), $holidayDays)) continue;
					if (in_array($period->format('*-m-d'), $holidayDays)) continue;
					$days++;
				}
				return $days;
			}
			
			 $hari_kerja = number_of_working_days($year.'-'.$month_with_null.'-01', $year.'-'.$month_with_null.'-'.$total_day);
			 $bulan_sekarang = date('n');
			 if($bulan=="")
			 {
			 $tanggal_sekarang = date('d');
			 $hari_kerja_sekarang = number_of_working_days($year.'-'.$month_with_null.'-01', $year.'-'.$month_with_null.'-'.$tanggal_sekarang);
			 }
			 else
			 { 
			   if($month>$bulan_sekarang)
			   {$hari_kerja_sekarang=0;}
			   else
			 {$hari_kerja_sekarang = number_of_working_days($year.'-'.$month_with_null.'-01', $year.'-'.$month_with_null.'-'.$total_day);}
			 
			 }
		
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
		
		$Fontstyle2 = array(
		'font'  => array(
			'bold'  => true,
			'color' => array('rgb' => '000000')
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
		
		
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 1, "Motorist Absence");
		//Merge And Center Title
		$objPHPExcel->getActiveSheet()->mergeCells('A1:D1');
		
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 2, "Date : ".$date);
		
		//Merge And Center Date
		$objPHPExcel->getActiveSheet()->mergeCells('A2:D2');
		
		//Set Font Color Title
		$objPHPExcel->getActiveSheet()->getStyle('A1:D2')->applyFromArray($FontstyleTitle);
		
		//Set Font Color Header
		$objPHPExcel->getActiveSheet()->getStyle('B4:N4')->applyFromArray($Fontstyle);
		
		//Set Backgroung Color Header
		
		
		$objPHPExcel->getActiveSheet()->getStyle('B4:N4')->applyFromArray(
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
		"Kode Distributor" => "Kode Distributor",
		"Nama Distributor" => "Nama Distributor",
		"Tipe Motorist" => "Tipe Motorist",
		"Kode Motorist" => "Kode Motorist",
		"Nama Motorist" => "Nama Motorist",
		"Hari kerja" => "Hari kerja",
		"Total Hadir" => "Total Hadir",
		"Total Izin" => "Total Izin",
		"Total Sakit" => "Total Sakit",
		"Total Absent" => "Total Absent"
		);
        $col = 1;
		
        foreach ($fields as $field)
        {
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, 4, $field);
            $col++;
        }
		
		
		$col_tanggal = $col;
		function num2alpha($n)
		{
			for($r = ""; $n >= 0; $n = intval($n / 26) - 1)
				$r = chr($n%26 + 0x41) . $r;
			return $r;
		}

		for ($i = 1; $i <= $total_day; $i++) {
							
			$date = $year.'-'.$month.'-'.sprintf('%02d', $i);
			$date1 = strtotime($date);
			$date2 = date("l", $date1);
			$date3 = strtolower($date2);
			$column_alpha = num2alpha($col_tanggal);
			$objPHPExcel->getActiveSheet()->getColumnDimension($column_alpha)->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getStyle($column_alpha."4")->applyFromArray($Fontstyle);
			$objPHPExcel->getActiveSheet()->getStyle($column_alpha."4")->applyFromArray($BStyle);
	    	$objPHPExcel->getActiveSheet()->getStyle($column_alpha."4")->applyFromArray($styleAlign);
			if (($date3 == "sunday")) {
			
			 
			 $objPHPExcel->getActiveSheet()->getStyle($column_alpha."4")->applyFromArray(
			 array(
				'fill' => array(
					'type' => PHPExcel_Style_Fill::FILL_SOLID,
					'color' => array('rgb' => 'fb062e')
				)
			 ) 
			 );		
			 $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_tanggal, 4, $i.'/'.$month.'/'.$year);
			 $col_tanggal++;
						
			} else {
				
				$objPHPExcel->getActiveSheet()->getStyle($column_alpha."4")->applyFromArray(
				 array(
					'fill' => array(
						'type' => PHPExcel_Style_Fill::FILL_SOLID,
						'color' => array('rgb' => '06a7fb')
					)
				 ) 
				 );	
						
			 $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_tanggal, 4, $i.'/'.$month.'/'.$year);
			 $col_tanggal++;		
			}
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
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, $row, $data['motorist_type']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, $row, $data['motorist_code']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8, $row, $data['motorist_name']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9, $row, $hari_kerja);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(10, $row, $data['total_hadir']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(11, $row, $data['total_izin']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(12, $row, $data['total_sakit']);
			$total_absent = $hari_kerja_sekarang -($data['total_sakit']+$data['total_hadir']+$data['total_izin']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(13, $row, $total_absent);
			
			$col_absen = 14;
			for ($i = 1; $i <= $total_day; $i++) {
							
			$date = $year.'-'.$month.'-'.sprintf('%02d', $i);
			$date1 = strtotime($date);
			$date2 = date("l", $date1);
			$date3 = strtolower($date2);
			$column_alpha = num2alpha($col_absen);
			$objPHPExcel->getActiveSheet()->getColumnDimension($column_alpha)->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getStyle($column_alpha.$row)->applyFromArray($Fontstyle);
			$objPHPExcel->getActiveSheet()->getStyle($column_alpha.$row)->applyFromArray($BStyle);
	    	$objPHPExcel->getActiveSheet()->getStyle($column_alpha.$row)->applyFromArray($styleAlign);
			
			if (($date3 == "sunday")) {
			
			$objPHPExcel->getActiveSheet()->getStyle($column_alpha.$row)->applyFromArray($Fontstyle2);	
			$objPHPExcel->getActiveSheet()->getStyle($column_alpha.$row)->applyFromArray(
			 array(
				'fill' => array(
					'type' => PHPExcel_Style_Fill::FILL_SOLID,
					'color' => array('rgb' => 'fb062e')
				)
			 ) 
			 );	
			 					
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_absen, $row, "Libur");
			$col_absen++;	
							
			} else {
								 
			$this->db->from("absence");
			$this->db->where("motorist_code = '".$data['motorist_code']."' AND distributor_code = '".$data['distributor_code']."'  ");	
			$this->db->where("date_absence LIKE '%".$year.'-'.$month_with_null.'-'.sprintf('%02d', $i)."%'");		
			$query = $this->db->get()->result_array();
			if (empty($query))
			{
				$objPHPExcel->getActiveSheet()->getStyle($column_alpha.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => '7d7d7d')
						)
					 ) 
					 );
					 
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_absen, $row, "Tidak Absen");
				$col_absen++;
			}
			else
			{
				if($query[0]['status_absence']=="hadir")
				{
					$objPHPExcel->getActiveSheet()->getStyle($column_alpha.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => '138001')
						)
					 ) 
					 );	
				 }
				else if($query[0]['status_absence']=="sakit")
				{
					$objPHPExcel->getActiveSheet()->getStyle($column_alpha.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => 'fb9006')
						)
					 ) 
					 );
					}
				else if($query[0]['status_absence']=="izin")
				{
					$objPHPExcel->getActiveSheet()->getStyle($column_alpha.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => '119fc8')
						)
					 ) 
					 );
					}
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_absen, $row, $query[0]['status_absence']);
				$col_absen++;
			} 
									
							
			}
										
                        	
                            
                        
						}
						
						
            $row++;
			$no++;
        }
		
	   $last_row = $row-1;
	   //Set Border
       $objPHPExcel->getActiveSheet()->getStyle("B4".":"."N".$last_row)->applyFromArray($BStyle);
	   $objPHPExcel->getActiveSheet()->getStyle("B4".":"."N".$last_row)->applyFromArray($styleAlign);
       $objPHPExcel->setActiveSheetIndex(0);
 
        $objWriter = IOFactory::createWriter($objPHPExcel, 'Excel5');
 		
		
	   // Sending headers to force the user to download the file
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Motorist-Absence-'.$date.'.xls"');
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
		
		
		
	
	
	
	public function exportSummaryAbsenceDriver()
	{
		
		date_default_timezone_set('Asia/Jakarta');
		if ($this->tank_auth->is_logged_in()) {
		$user	= $this->tank_auth->get_username();
			
		$data_account = $this->model_account_master->getAccount("WHERE username = '".$user."' ")->result_array();
		$data_role = $this->model_account_master->getRole("WHERE id_role = '".$data_account[0]['user_access']."' ")->result_array();
		$user_role = $data_account[0]['user_type'];
		$code_role = $data_account[0]['code'];
	
			
		if($data_role[0]['see_driver']=='yes')
		{
			
		$date = date("m-d-Y");
		
		
		$search = isset($_GET['search']) ? $_GET['search'] : '';
		$bulan = isset($_GET['bulan']) ? $_GET['bulan'] : '';
		$year = isset($_GET['year']) ? $_GET['year'] : '';
			
		
		
	
		if($bulan!="")
		{$bulan=$bulan;}
		else
		{$bulan = date('m');}
		
		if($year!="")
		{$year=$year;}
		else
		{$year = date('Y');}
		
		$tanggal_bulan_awal = $year.'-'.$bulan."-01 00:00:00";
		$tanggal_bulan_akhir = $year.'-'.$bulan."-31 23:59:59";
		
		
		
		$this->db->like('driver.driver_code', $search);
		$query = $this->db->get('driver');
		
		if($bulan=="")
				{
				$month = date('n');
				$month_with_null = date('m');
				}
				else
				{
					$month = intval($bulan);
					$month_with_null = $bulan;
					}
					
				if($year=="")
				{
				$year = date('Y');
				}
				else
				{
				$year = $year;
				}
					
				$total_day = cal_days_in_month(CAL_GREGORIAN, $month, $year); // 31	
		
		function number_of_working_days($from, $to) {
				$workingDays = [1,2,3,4,5,6]; 
				$holidayDays = [];
			
				$from = new DateTime($from);
				$to = new DateTime($to);
				$to->modify('+1 day');
				$interval = new DateInterval('P1D');
				$periods = new DatePeriod($from, $interval, $to);
			
				$days = 0;
				foreach ($periods as $period) {
					if (!in_array($period->format('N'), $workingDays)) continue;
					if (in_array($period->format('Y-m-d'), $holidayDays)) continue;
					if (in_array($period->format('*-m-d'), $holidayDays)) continue;
					$days++;
				}
				return $days;
			}
			
	
		
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
		
		$Fontstyle2 = array(
		'font'  => array(
			'bold'  => true,
			'color' => array('rgb' => '000000')
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
		
		
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 1, "Driver Absence");
		//Merge And Center Title
		$objPHPExcel->getActiveSheet()->mergeCells('A1:D1');
		
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 2, "Date : ".$date);
		
		//Merge And Center Date
		$objPHPExcel->getActiveSheet()->mergeCells('A2:D2');
		
		//Set Font Color Title
		$objPHPExcel->getActiveSheet()->getStyle('A1:D2')->applyFromArray($FontstyleTitle);
		
		//Set Font Color Header
		$objPHPExcel->getActiveSheet()->getStyle('B4:N4')->applyFromArray($Fontstyle);
		
		//Set Backgroung Color Header
		
		
		$objPHPExcel->getActiveSheet()->getStyle('B4:N4')->applyFromArray(
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
		"Kode Driver" => "Kode Driver",
		"Nama Driver" => "Nama Driver",
		);
        $col = 1;
		
        foreach ($fields as $field)
        {
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, 4, $field);
            $col++;
        }
		
		
		$col_tanggal = $col;
		function num2alpha($n)
		{
			for($r = ""; $n >= 0; $n = intval($n / 26) - 1)
				$r = chr($n%26 + 0x41) . $r;
			return $r;
		}

		for ($i = 1; $i <= $total_day; $i++) {
							
			$date = $year.'-'.$month.'-'.sprintf('%02d', $i);
			$date1 = strtotime($date);
			$date2 = date("l", $date1);
			$date3 = strtolower($date2);
			$column_alpha = num2alpha($col_tanggal);
			$objPHPExcel->getActiveSheet()->getColumnDimension($column_alpha)->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getStyle($column_alpha."4")->applyFromArray($Fontstyle);
			$objPHPExcel->getActiveSheet()->getStyle($column_alpha."4")->applyFromArray($BStyle);
	    	$objPHPExcel->getActiveSheet()->getStyle($column_alpha."4")->applyFromArray($styleAlign);
			if (($date3 == "sunday")) {
			
			 
			 $objPHPExcel->getActiveSheet()->getStyle($column_alpha."4")->applyFromArray(
			 array(
				'fill' => array(
					'type' => PHPExcel_Style_Fill::FILL_SOLID,
					'color' => array('rgb' => 'fb062e')
				)
			 ) 
			 );		
			 $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_tanggal, 4, $i.'/'.$month.'/'.$year);
			 $col_tanggal++;
						
			} else {
				
				$objPHPExcel->getActiveSheet()->getStyle($column_alpha."4")->applyFromArray(
				 array(
					'fill' => array(
						'type' => PHPExcel_Style_Fill::FILL_SOLID,
						'color' => array('rgb' => '06a7fb')
					)
				 ) 
				 );	
						
			 $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_tanggal, 4, $i.'/'.$month.'/'.$year);
			 $col_tanggal++;		
			}
		}
		
		
		

 
        // Fetching the table data
        $row = 5;
		$no = 1;
		
        foreach($query->result_array() as $data)
        {
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $row, $no);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $row, $data['driver_code']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $row, $data['driver_name']);
			
			$col_absen = 4;
			for ($i = 1; $i <= $total_day; $i++) {
							
			$date = $year.'-'.$month.'-'.sprintf('%02d', $i);
			$date1 = strtotime($date);
			$date2 = date("l", $date1);
			$date3 = strtolower($date2);
			$column_alpha = num2alpha($col_absen);
			$objPHPExcel->getActiveSheet()->getColumnDimension($column_alpha)->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getStyle($column_alpha.$row)->applyFromArray($Fontstyle);
			$objPHPExcel->getActiveSheet()->getStyle($column_alpha.$row)->applyFromArray($BStyle);
	    	$objPHPExcel->getActiveSheet()->getStyle($column_alpha.$row)->applyFromArray($styleAlign);
			
			if (($date3 == "sunday")) {
			
			$objPHPExcel->getActiveSheet()->getStyle($column_alpha.$row)->applyFromArray($Fontstyle2);	
			$objPHPExcel->getActiveSheet()->getStyle($column_alpha.$row)->applyFromArray(
			 array(
				'fill' => array(
					'type' => PHPExcel_Style_Fill::FILL_SOLID,
					'color' => array('rgb' => 'fb062e')
				)
			 ) 
			 );	
			 					
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_absen, $row, "Libur");
			$col_absen++;	
							
			} else {
								 
			$this->db->from("driver_absence");
			$this->db->where("driver_code = '".$data['driver_code']."' ");	
			$this->db->where("date_absence LIKE '%".$year.'-'.$month_with_null.'-'.sprintf('%02d', $i)."%'");		
			$query = $this->db->get()->result_array();
			if (empty($query))
			{
				$objPHPExcel->getActiveSheet()->getStyle($column_alpha.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => '7d7d7d')
						)
					 ) 
					 );
					 
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_absen, $row, "Tidak Absen");
				$col_absen++;
			}
			else
			{
				if($query[0]['status_absence']=="hadir")
				{
					$objPHPExcel->getActiveSheet()->getStyle($column_alpha.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => '138001')
						)
					 ) 
					 );	
				 }
				else if($query[0]['status_absence']=="sakit")
				{
					$objPHPExcel->getActiveSheet()->getStyle($column_alpha.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => 'fb9006')
						)
					 ) 
					 );
					}
				else if($query[0]['status_absence']=="izin")
				{
					$objPHPExcel->getActiveSheet()->getStyle($column_alpha.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => '119fc8')
						)
					 ) 
					 );
					}
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_absen, $row, $query[0]['status_absence']);
				$col_absen++;
			} 
									
							
			}
										
                        	
                            
                        
						}
						
						
            $row++;
			$no++;
        }
		
	   $last_row = $row-1;
	   //Set Border
       $objPHPExcel->getActiveSheet()->getStyle("B4".":"."N".$last_row)->applyFromArray($BStyle);
	   $objPHPExcel->getActiveSheet()->getStyle("B4".":"."N".$last_row)->applyFromArray($styleAlign);
       $objPHPExcel->setActiveSheetIndex(0);
 
        $objWriter = IOFactory::createWriter($objPHPExcel, 'Excel5');
 		
		
	   // Sending headers to force the user to download the file
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Driver-Absence-'.$date.'.xls"');
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