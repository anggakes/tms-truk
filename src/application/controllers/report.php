<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Report extends CI_Controller {

	function __construct()  {
 		parent::__construct();
			$this->load->library(array('PHPExcel','PHPExcel/IOFactory'));
			$this->load->model('model_account_master');
			$this->load->model('model_report');
			$this->load->library('tank_auth');
			
	}
	
	
	
		function index()
    	{
		date_default_timezone_set('Asia/Jakarta');
		$date_now_check = date ('Y-m-d');
		$date_cutoff_check = new DateTime($date_now_check.'00:00:00');
		$datetime_now_check = date('Y-m-d H:i:s');
		$datetime_now_check = new DateTime($datetime_now_check);
		//Check Apakah sudah lebih dari jam setengah 4
		if($datetime_now_check > $date_cutoff_check)
		{
		
		$timestamp = date('D, M d Y H:s a ');
		$periode = date('M Y');
		$date_now = date ('Y-m-d');
		$date_yesterday = date('Y-m-d',strtotime("-1 days"));
		
		
		
		
		$select_email = $this->model_report->getEmail(" ");
		$data_emails = $select_email->result_array();
		
		foreach($data_emails as $data_email)
		{
			
		//Check Apakah sudah dikirim atau belum
		
		$select_motorist_type = $this->db->query("SELECT * FROM motorist_type WHERE motorist_type = '".$data_email['motorist']."' ")->result_array();
		$data_motorist_type = $select_motorist_type[0]['id_motorist_type'];
		echo $select_motorist_type[0]['motorist_type'];
		
		$email_receiver = $data_email['email'];	
		$check_log_report = $this->model_report->getLogReport("WHERE date = '".$date_now."' AND email = '".$data_email['email']."' AND motorist = '".$select_motorist_type[0]['motorist_type']."'  ")->num_rows;
		$query = $this->db->query("SELECT * FROM master_regional");
		if($check_log_report == 0 )
		{
		if(!$query)
        return false;
 		$report_date = date("d-m-Y");	
        //Starting the PHPExcel library
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
		foreach(range('A','Z') as $columnID)
		{
			$objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
		}
		
		
		//Merge And Center Title
		$objPHPExcel->getActiveSheet()->mergeCells('A1:D1');
		$objPHPExcel->getActiveSheet()->mergeCells('B5:I5');
		
		$objPHPExcel->getActiveSheet()->mergeCells('J5:W5');
		
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 1, "Tracking Productivity Motorist ".$select_motorist_type[0]['motorist_type']."");
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, 5, "Daily ");
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9, 5, "Month To Date ");
		$objPHPExcel->getActiveSheet()->getStyle('A5:W5')->applyFromArray($Fontstyle);
		
		$objPHPExcel->getActiveSheet()->getStyle('J5:W5')->applyFromArray(
			array(
				'fill' => array(
					'type' => PHPExcel_Style_Fill::FILL_SOLID,
					'color' => array('rgb' => '169805')
				)
			)
		);
		
		$objPHPExcel->getActiveSheet()->getStyle('B5:I5')->applyFromArray(
			array(
				'fill' => array(
					'type' => PHPExcel_Style_Fill::FILL_SOLID,
					'color' => array('rgb' => 'e4c208')
				)
			)
		);
		
		//Merge And Center Date
		$objPHPExcel->getActiveSheet()->mergeCells('A2:D2');
		
		$objPHPExcel->getActiveSheet()->mergeCells('A3:D3');
		
		//Set Font Color Title
		$objPHPExcel->getActiveSheet()->getStyle('A1:D2')->applyFromArray($FontstyleTitle);
		$objPHPExcel->getActiveSheet()->getStyle('A3:D3')->applyFromArray($FontstyleTitle);
		
		//Set Font Color Header
		$objPHPExcel->getActiveSheet()->getStyle('A6:W6')->applyFromArray($Fontstyle);
	
		
		
		//Set Backgroung Color Header
		$objPHPExcel->getActiveSheet()->getStyle('A6:O6')->applyFromArray(
			array(
				'fill' => array(
					'type' => PHPExcel_Style_Fill::FILL_SOLID,
					'color' => array('rgb' => '62a8ea')
				)
			)
		);
		
		
		$objPHPExcel->getActiveSheet()->getStyle('A6:A6')->applyFromArray(
			array(
				'fill' => array(
					'type' => PHPExcel_Style_Fill::FILL_SOLID,
					'color' => array('rgb' => '1dccec')
				)
			)
		);
		
		$objPHPExcel->getActiveSheet()->getStyle('B6:I6')->applyFromArray(
			array(
				'fill' => array(
					'type' => PHPExcel_Style_Fill::FILL_SOLID,
					'color' => array('rgb' => 'e4c208')
				)
			)
		);
		
		$objPHPExcel->getActiveSheet()->getStyle('J6:W6')->applyFromArray(
			array(
				'fill' => array(
					'type' => PHPExcel_Style_Fill::FILL_SOLID,
					'color' => array('rgb' => '169805')
				)
			)
		);
		
 		
		//Keterangan Report
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 1, "Tracking Productivity Motorist ".$select_motorist_type[0]['motorist_type']."");
		
		//Keterangan Distributor
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 2, $timestamp);
		
		
		
		
		
		
        // Field names in the first row
        $fields = array(
		"Sales Region" => "Sales Region",
		"Target Call" => "Target Call",
		"Actual Call" => "Actual Call",
		"% Call" => "% Call",
		"Effective Call" => "Effective Call",
		"% Effective Call" => "% Effective Call",
		"Target Sales" => "Target Sales",
		"Actual sales" => "Actual sales",
		"% Sales achievement" => "% Sales achievement",
		"Target Call Month" => "Target Call",
		"Actual Call Month" => "Actual Call",
		"% Call Month" => "% Call",
		"Effective Call Month" => "Effective Call",
		"% Effective Call Month" => "% Effective Call",
		"Target Sales Month" => "Target Sales",
		"Actual sales Month" => "Actual sales",
		"% Sales achievement Month" => "% Sales achievement",
		"Register Outlet" => "Register Outlet",
		"Active outlet" => "Active outlet",
		"% Active outlet" => "% Active outlet",
		"Target Switching" => "Target Switching",
		"Actual Switching" => "Actual Switching",
		"% Switching" => "% Switching"
		
		
		);
        $col = 0;
        foreach ($fields as $field)
        {
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, 6, $field);
            $col++;
        }
		
		
		 // Fetching the table data
        $row = 7;
		$no = 1;
		$no_order = "";
		
		$date_now_date = date('d');
		$bulan = date('m');
		$year = date('Y');
		
		$tanggal_bulan_awal = $year.'-'.$bulan."-01 00:00:00";
		$tanggal_bulan_akhir = $year.'-'.$bulan."-31 23:59:59";
		$month = intval($bulan);
		$month_with_null = $bulan;
		$total_day = date('t', mktime(0, 0, 0, $month, 1, $year)); 
		
		
		function number_of_working_days_all($from, $to) {
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
			
		
		function number_of_working_days($from, $to,$hari) {
			$workingDays = [$hari]; 
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
			
			$total_senin = number_of_working_days('2016-'.$bulan.'-01', '2016-'.$bulan.'-'.$date_now_date,1);
			//echo "total senin".$total_senin."<br>";
			$total_selasa = number_of_working_days('2016-'.$bulan.'-01', '2016-'.$bulan.'-'.$date_now_date,2);
			//echo "total selasa".$total_selasa."<br>";
			$total_rabu = number_of_working_days('2016-'.$bulan.'-01', '2016-'.$bulan.'-'.$date_now_date,3);
			//echo "total rabu".$total_rabu."<br>";
			$total_kamis = number_of_working_days('2016-'.$bulan.'-01', '2016-'.$bulan.'-'.$date_now_date,4);
			//echo "total kamis".$total_kamis."<br>";
			$total_jumat = number_of_working_days('2016-'.$bulan.'-01', '2016-'.$bulan.'-'.$date_now_date,5);
			//echo "total jumat".$total_jumat."<br>";
			$total_sabtu = number_of_working_days('2016-'.$bulan.'-01', '2016-'.$bulan.'-'.$date_now_date,6);
			//echo "total sabtu".$total_sabtu."<br>";
			
			$hari_kerja = number_of_working_days_all($year.'-'.$month_with_null.'-01', $year.'-'.$month_with_null.'-'.$total_day);
			
			$date_sekarang = date('d');
			$hari_sekarang = number_of_working_days_all($year.'-'.$month_with_null.'-01', $year.'-'.$month_with_null.'-'.$date_sekarang);
			$date_convert = date_create($date_yesterday);
			$day = date_format($date_convert,"l");
			
			
			
			//National
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $row, "National");			
			
			$data_target_call = $this->db->query("SELECT COUNT(customer_code) as target_call FROM store WHERE day_visit = '".$day."' AND motorist_type = '".$data_motorist_type."'  ")->result_array();		
			$target_call = $data_target_call[0]['target_call'];
			
							$total_store_keseluruhan = 0;
							
							$store_senin = $this->db->query("SELECT id_store FROM store WHERE day_visit = 'monday' AND motorist_type = '".$data_motorist_type."'  ")->num_rows();
							//echo "store_senin".$store_senin."<br>";
							$total_store_senin = $total_senin * $store_senin;
							$store_selasa = $this->db->query("SELECT id_store FROM store WHERE  day_visit = 'tuesday' AND motorist_type = '".$data_motorist_type."' ")->num_rows();
							//echo "store_selasa".$store_selasa."<br>";
							$total_store_selasa = $total_selasa * $store_selasa;
							$store_rabu = $this->db->query("SELECT id_store FROM store WHERE day_visit = 'wednesday' AND motorist_type = '".$data_motorist_type."' ")->num_rows();
							$total_store_rabu = $total_rabu * $store_rabu;
							//echo "store_rabu".$store_rabu."<br>";
							$store_kamis = $this->db->query("SELECT id_store FROM store WHERE  day_visit = 'thursday' AND motorist_type = '".$data_motorist_type."' ")->num_rows();
							$total_store_kamis = $total_kamis * $store_kamis;
							//echo "store_kamis".$store_kamis."<br>";
							$store_jumat = $this->db->query("SELECT id_store FROM store WHERE day_visit = 'friday' AND motorist_type = '".$data_motorist_type."' ")->num_rows();
							$total_store_jumat = $total_jumat * $store_jumat;
							//echo "store_jumat".$store_jumat."<br>";
							$store_sabtu = $this->db->query("SELECT id_store FROM store WHERE  day_visit = 'saturday' AND motorist_type = '".$data_motorist_type."' ")->num_rows();
							$total_store_sabtu = $total_sabtu * $store_sabtu;
							//echo "store_sabtu".$store_sabtu."<br>";
							$total_keseluruhan = $total_store_senin+$total_store_selasa+$total_store_rabu+$total_store_kamis+$total_store_jumat+$total_store_sabtu;

			$data_total_call = $this->db->query("SELECT COUNT(customer_code) as total_call FROM visit JOIN motorist on motorist.id_motorist = visit.id_motorist JOIN distributor on motorist.distributor_code = distributor.distributor_code  WHERE   status_visit = 'call' AND time_stamp_visit LIKE '%".$date_yesterday."%' AND motorist.motorist_type = '".$data_motorist_type."' ")->result_array();		
			$total_call = $data_total_call[0]['total_call'];
			
			$data_total_call_monthly = $this->db->query("SELECT COUNT(customer_code) as total_call_monthly FROM visit JOIN motorist on motorist.id_motorist = visit.id_motorist JOIN distributor on motorist.distributor_code = distributor.distributor_code WHERE  status_visit = 'call' AND time_stamp_visit between '".$tanggal_bulan_awal."' AND '".$tanggal_bulan_akhir."' AND motorist.motorist_type = '".$data_motorist_type."' ")->result_array();		
			$total_call_monthly = $data_total_call_monthly[0]['total_call_monthly'];
			
			$data_total_effective_call = $this->db->query("SELECT COUNT(customer_code) as total_effective_call FROM visit JOIN motorist on motorist.id_motorist = visit.id_motorist JOIN distributor on motorist.distributor_code = distributor.distributor_code  WHERE  status_order = 'order' AND  status_visit = 'call' AND time_stamp_visit LIKE '%".$date_yesterday."%' AND motorist.motorist_type = '".$data_motorist_type."' ")->result_array();		
			$total_effective_call = $data_total_effective_call[0]['total_effective_call'];
			
			$data_total_effective_call_monthly = $this->db->query("SELECT COUNT(customer_code) as total_effective_call_monthly FROM visit JOIN motorist on motorist.id_motorist = visit.id_motorist JOIN distributor on motorist.distributor_code = distributor.distributor_code  WHERE  status_order = 'order' AND  status_visit = 'call' AND time_stamp_visit between '".$tanggal_bulan_awal."' AND '".$tanggal_bulan_akhir."' AND motorist.motorist_type = '".$data_motorist_type."' ")->result_array();		
			$total_effective_call_monthly = $data_total_effective_call_monthly[0]['total_effective_call_monthly'];
			
			
			$data_total_target_sales = $this->db->query("SELECT SUM(target_harian) as target_harian FROM motorist JOIN distributor on motorist.distributor_code = distributor.distributor_code WHERE motorist.motorist_type = '".$data_motorist_type."' ")->result_array();		
			$total_daily_target_sales = $data_total_target_sales[0]['target_harian'];
			
			
			//Keterangan Distributor
			$timerate = ($hari_sekarang * 100)/ $hari_kerja;
			$timerate = number_format($timerate, 0, '.', '');
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 3, "Periode: ".$periode. " Elapsed workday: ".$hari_sekarang.'/'.$hari_kerja.' Timerate: '.$timerate.' %');
			
		
		
			if($total_daily_target_sales<=0)
			{
				$total_daily_target_sales = "0";
			}
			
			$data_total_actual_daily_sales = $this->db->query("SELECT SUM(total_order) as total_actual_daily_sales FROM orders JOIN motorist on motorist.id_motorist = orders.id_motorist JOIN distributor on motorist.distributor_code = distributor.distributor_code WHERE  date LIKE '%".$date_yesterday."%' AND motorist.motorist_type = '".$data_motorist_type."'  ")->result_array();		
			$total_actual_daily_sales = $data_total_actual_daily_sales[0]['total_actual_daily_sales'];
			
			
			$data_total_actual_daily_sales_monthly = $this->db->query("SELECT SUM(total_order) as total_actual_daily_sales_monthly FROM orders JOIN motorist on motorist.id_motorist = orders.id_motorist JOIN distributor on motorist.distributor_code = distributor.distributor_code WHERE date between '".$tanggal_bulan_awal."' AND '".$tanggal_bulan_akhir."' AND motorist.motorist_type = '".$data_motorist_type."'  ")->result_array();		
			$total_actual_daily_sales_monthly = $data_total_actual_daily_sales_monthly[0]['total_actual_daily_sales_monthly'];
			
			$total_daily_target_sales_monthly = $total_daily_target_sales * $hari_kerja; 

			if($total_actual_daily_sales<=0)
			{
				$total_actual_daily_sales = "0";
			}
			
			if($target_call>0)
			{
			$persentasi_call = ($total_call * 100) / $target_call;
			$persentasi_call = number_format($persentasi_call, 0, '.', '');	
			}
			else{
				$persentasi_call = "0";
			}
			
			
			if($total_keseluruhan>0)
			{
			$persentasi_call_monthly = ($total_call_monthly * 100) / $total_keseluruhan;
			$persentasi_call_monthly = number_format($persentasi_call_monthly, 0, '.', '');	
			}
			else
			{
				$persentasi_call_monthly = "0";
			}
			
			if($target_call >0)
			{
			$persentasi_effective_call = ($total_effective_call  * 100) / $target_call;
			$persentasi_effective_call = number_format($persentasi_effective_call, 0, '.', '');
			}
			else{
				$persentasi_effective_call  = "0";
			}
			
			if($total_keseluruhan >0)
			{
			$persentasi_effective_call_monthly = ($total_effective_call_monthly  * 100) / $total_keseluruhan;
			$persentasi_effective_call_monthly = number_format($persentasi_effective_call_monthly, 0, '.', '');
			}
			else{
				$persentasi_effective_call_monthly  = "0";
			}
			
			if($total_actual_daily_sales>0)
			{
			$persentasi_target_harian = ($total_actual_daily_sales * 100) / $total_daily_target_sales;
			$persentasi_target_harian = number_format($persentasi_target_harian, 0, '.', '');
			}
			else
			{
				$persentasi_target_harian = "0";
			}
			
			
			if($total_actual_daily_sales_monthly>0)
			{
			$persentasi_target_bulanan = ($total_actual_daily_sales_monthly * 100) / $total_daily_target_sales_monthly;
			$persentasi_target_bulanan = number_format($persentasi_target_bulanan, 0, '.', '');
			}
			else
			{
				$persentasi_target_bulanan = "0";
			}
			
			if($total_actual_daily_sales_monthly<=0)
			{
				$total_actual_daily_sales_monthly=0;
			}
			
			$objPHPExcel->getActiveSheet()->getStyle('A'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => 'e84fea')
						)
					 ) 
			);
			
							
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $row, $target_call);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $row, $total_call);
			
			if($persentasi_call>95)
			{
				$objPHPExcel->getActiveSheet()->getStyle("D".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('D'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => '099f3e')
						)
					 ) 
					 );
					 
				}
			else if($persentasi_call<90)
			{
				$objPHPExcel->getActiveSheet()->getStyle("D".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('D'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => 'fa364d')
						)
					 ) 
					 );
					 
			}
			
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $row, $persentasi_call." %");
			
			
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $row, $total_effective_call);
			
			if($persentasi_effective_call>95)
			{
				$objPHPExcel->getActiveSheet()->getStyle("F".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('F'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => '099f3e')
						)
					 ) 
					 );
					 
				}
			else if($persentasi_effective_call<90)
			{
				$objPHPExcel->getActiveSheet()->getStyle("F".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('F'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => 'fa364d')
						)
					 ) 
					 );
					 
			}
			
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, $row, $persentasi_effective_call." %");
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, $row, "Rp. ".number_format($total_daily_target_sales, 0 , '' , '.' ));
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, $row, "Rp. ".number_format($total_actual_daily_sales, 0 , '' , '.' ));
			
			if($persentasi_target_harian>100)
			{
				$objPHPExcel->getActiveSheet()->getStyle("I".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('I'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => '099f3e')
						)
					 ) 
					 );
					 
				}
			else if($persentasi_target_harian<100)
			{
				$objPHPExcel->getActiveSheet()->getStyle("I".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('I'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => 'fa364d')
						)
					 ) 
					 );
					 
			}
			
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8, $row, $persentasi_target_harian." %");
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9, $row, $total_keseluruhan);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(10, $row, $total_call_monthly);
			
			if($persentasi_call_monthly>95)
			{
				$objPHPExcel->getActiveSheet()->getStyle("L".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('L'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => '099f3e')
						)
					 ) 
					 );
					 
				}
			else if($persentasi_call_monthly<90)
			{
				$objPHPExcel->getActiveSheet()->getStyle("L".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('L'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => 'fa364d')
						)
					 ) 
					 );
					 
			}
			
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(11, $row, $persentasi_call_monthly." %");
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(12, $row, $total_effective_call_monthly);
			
			if($persentasi_effective_call_monthly>95)
			{
				$objPHPExcel->getActiveSheet()->getStyle("N".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('N'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => '099f3e')
						)
					 ) 
					 );
					 
				}
			else if($persentasi_effective_call_monthly<90)
			{
				$objPHPExcel->getActiveSheet()->getStyle("N".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('N'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => 'fa364d')
						)
					 ) 
					 );
					 
			}
			
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(13, $row, $persentasi_effective_call_monthly." %");
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(14, $row, "Rp. ".number_format($total_daily_target_sales_monthly, 0 , '' , '.' ));
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(15, $row, "Rp. ".number_format($total_actual_daily_sales_monthly, 0 , '' , '.' ));
			
			
			
			if($persentasi_effective_call_monthly>$timerate)
			{
				$objPHPExcel->getActiveSheet()->getStyle("Q".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('Q'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => '099f3e')
						)
					 ) 
					 );
					 
				}
			else if($persentasi_effective_call_monthly<$timerate)
			{
				$objPHPExcel->getActiveSheet()->getStyle("Q".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('Q'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => 'fa364d')
						)
					 ) 
					 );
					 
			}
			
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(16, $row, $persentasi_target_bulanan." %");
			//Monthly
			$data_total_outlet_register = $this->db->query("SELECT COUNT(customer_code) as total_outlet_register FROM store WHERE store.motorist_type = '".$data_motorist_type."'  ")->result_array();		
			$total_outlet_register = $data_total_outlet_register[0]['total_outlet_register'];
			
			//Monthly
			$total_outlet_active = $this->db->query("SELECT id_order FROM orders JOIN motorist on motorist.id_motorist = orders.id_motorist JOIN distributor on motorist.distributor_code = distributor.distributor_code WHERE  date between '2016-".$bulan."-01 00:00:00' AND '2016-".$bulan."-31 23:59:59' AND motorist.motorist_type = '".$data_motorist_type."' group by customer_code")->num_rows();		
			
			
			$data_outlet_switching = $this->db->query("SELECT COUNT(id_noo) as total_outlet_switching FROM noo JOIN distributor on noo.distributor_code = distributor.distributor_code JOIN motorist on noo.motorist_code = motorist.motorist_code AND noo.distributor_code = motorist.distributor_code  WHERE  customer_create_date between '".$year."-".$bulan."-01 00:00:00'  AND '".$year."-".$bulan."-31 00:00:00' AND product = 'Bukan_Carnation' AND motorist.motorist_code = '2' ")->result_array();		
			$total_outlet_switching = $data_outlet_switching[0]['total_outlet_switching'];
			
			$total_motorist = $this->db->query("SELECT * FROM motorist join distributor on distributor.distributor_code = motorist.distributor_code WHERE motorist.motorist_type = '".$data_motorist_type."'  ")->num_rows();
			$total_motorist = $total_motorist * 10;
			
			if($total_outlet_switching<=0)
			{$total_outlet_switching = '0'; }
			
			
			if($total_outlet_switching>0)
			{
			$persentasi_outlet_switching = ($total_outlet_switching * 100) / $total_motorist;
			$persentasi_outlet_switching = number_format($persentasi_outlet_switching, 0, '.', '');
			}
			else
			{
				$persentasi_outlet_switching = "0";
			}
			
			
			if($total_outlet_active>0)
			{
			$persentasi_outlet_active = ($total_outlet_active * 100) / $total_outlet_register;
			$persentasi_outlet_active = number_format($persentasi_outlet_active, 0, '.', '');
			}
			else
			{
				$persentasi_outlet_active = "0";
			}
			
			
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(17, $row, $total_outlet_register);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(18, $row, $total_outlet_active);
			
			if($persentasi_outlet_active>$timerate)
			{
				$objPHPExcel->getActiveSheet()->getStyle("T".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('T'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => '099f3e')
						)
					 ) 
					 );
					 
				}
			else if($persentasi_outlet_active<$timerate)
			{
				$objPHPExcel->getActiveSheet()->getStyle("T".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('T'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => 'fa364d')
						)
					 ) 
					 );
					 
			}
			
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(19, $row, $persentasi_outlet_active." %");
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(20, $row, $total_motorist);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(21, $row, $total_outlet_switching);
			
			if($persentasi_outlet_switching>$timerate)
			{
				$objPHPExcel->getActiveSheet()->getStyle("W".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('W'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => '099f3e')
						)
					 ) 
					 );
					 
				}
			else if($persentasi_outlet_switching<$timerate)
			{
				$objPHPExcel->getActiveSheet()->getStyle("W".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('W'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => 'fa364d')
						)
					 ) 
					 );
					 
			}
			
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(22, $row, $persentasi_outlet_switching." %");
			$row++;
			// End National
			
        foreach($query->result_array() as $data)
        {
			
			
			
			$objPHPExcel->getActiveSheet()->getStyle('A'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => '3bbe26')
						)
					 ) 
			);
			
			
			//Regional
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $row, $data['regional_name']);			
			$data_target_call = $this->db->query("SELECT COUNT(customer_code) as target_call FROM store WHERE day_visit = '".$day."' AND regional = '".$data['regional_name']."' AND motorist_type = '".$data_motorist_type."' ")->result_array();		
			$target_call = $data_target_call[0]['target_call'];
			
							$total_store_keseluruhan = 0;
							
							$store_senin = $this->db->query("SELECT id_store FROM store WHERE regional = '".$data['regional_name']."' AND day_visit = 'monday' AND motorist_type = '".$data_motorist_type."' ")->num_rows();
							//echo "store_senin".$store_senin."<br>";
							$total_store_senin = $total_senin * $store_senin;
							$store_selasa = $this->db->query("SELECT id_store FROM store WHERE regional = '".$data['regional_name']."' AND day_visit = 'tuesday' AND motorist_type = '".$data_motorist_type."' ")->num_rows();
							//echo "store_selasa".$store_selasa."<br>";
							$total_store_selasa = $total_selasa * $store_selasa;
							$store_rabu = $this->db->query("SELECT id_store FROM store WHERE regional = '".$data['regional_name']."' AND day_visit = 'wednesday' AND motorist_type = '".$data_motorist_type."' ")->num_rows();
							$total_store_rabu = $total_rabu * $store_rabu;
							//echo "store_rabu".$store_rabu."<br>";
							$store_kamis = $this->db->query("SELECT id_store FROM store WHERE regional = '".$data['regional_name']."' AND day_visit = 'thursday' AND motorist_type = '".$data_motorist_type."' ")->num_rows();
							$total_store_kamis = $total_kamis * $store_kamis;
							//echo "store_kamis".$store_kamis."<br>";
							$store_jumat = $this->db->query("SELECT id_store FROM store WHERE regional = '".$data['regional_name']."' AND day_visit = 'friday' AND motorist_type = '".$data_motorist_type."' ")->num_rows();
							$total_store_jumat = $total_jumat * $store_jumat;
							//echo "store_jumat".$store_jumat."<br>";
							$store_sabtu = $this->db->query("SELECT id_store FROM store WHERE regional = '".$data['regional_name']."' AND day_visit = 'saturday' AND motorist_type = '".$data_motorist_type."' ")->num_rows();
							$total_store_sabtu = $total_sabtu * $store_sabtu;
							//echo "store_sabtu".$store_sabtu."<br>";
							$total_keseluruhan = $total_store_senin+$total_store_selasa+$total_store_rabu+$total_store_kamis+$total_store_jumat+$total_store_sabtu;

			$data_total_call = $this->db->query("SELECT COUNT(customer_code) as total_call FROM visit JOIN motorist on motorist.id_motorist = visit.id_motorist JOIN distributor on motorist.distributor_code = distributor.distributor_code  WHERE distributor.regional = '".$data['regional_name']."' AND  status_visit = 'call' AND time_stamp_visit LIKE '%".$date_yesterday."%' AND motorist.motorist_type = '".$data_motorist_type."' ")->result_array();		
			$total_call = $data_total_call[0]['total_call'];
			
			$data_total_call_monthly = $this->db->query("SELECT COUNT(customer_code) as total_call_monthly FROM visit JOIN motorist on motorist.id_motorist = visit.id_motorist JOIN distributor on motorist.distributor_code = distributor.distributor_code WHERE distributor.regional = '".$data['regional_name']."' AND status_visit = 'call' AND time_stamp_visit between '".$tanggal_bulan_awal."' AND '".$tanggal_bulan_akhir."' AND motorist.motorist_type = '".$data_motorist_type."' ")->result_array();		
			$total_call_monthly = $data_total_call_monthly[0]['total_call_monthly'];
			
			$data_total_effective_call = $this->db->query("SELECT COUNT(customer_code) as total_effective_call FROM visit JOIN motorist on motorist.id_motorist = visit.id_motorist JOIN distributor on motorist.distributor_code = distributor.distributor_code  WHERE distributor.regional = '".$data['regional_name']."' AND status_order = 'order' AND  status_visit = 'call' AND time_stamp_visit LIKE '%".$date_yesterday."%' AND motorist.motorist_type = '".$data_motorist_type."' ")->result_array();		
			$total_effective_call = $data_total_effective_call[0]['total_effective_call'];
			
			$data_total_effective_call_monthly = $this->db->query("SELECT COUNT(customer_code) as total_effective_call_monthly FROM visit JOIN motorist on motorist.id_motorist = visit.id_motorist JOIN distributor on motorist.distributor_code = distributor.distributor_code  WHERE distributor.regional = '".$data['regional_name']."' AND status_order = 'order' AND  status_visit = 'call' AND time_stamp_visit between '".$tanggal_bulan_awal."' AND '".$tanggal_bulan_akhir."' AND motorist.motorist_type = '".$data_motorist_type."' ")->result_array();		
			$total_effective_call_monthly = $data_total_effective_call_monthly[0]['total_effective_call_monthly'];
			
			
			$data_total_target_sales = $this->db->query("SELECT SUM(target_harian) as target_harian FROM motorist JOIN distributor on motorist.distributor_code = distributor.distributor_code  WHERE distributor.regional = '".$data['regional_name']."' AND motorist.motorist_type = '".$data_motorist_type."' ")->result_array();		
			$total_daily_target_sales = $data_total_target_sales[0]['target_harian'];
			
			
			
			if($total_daily_target_sales<=0)
			{
				$total_daily_target_sales = "0";
			}
			
			$data_total_actual_daily_sales = $this->db->query("SELECT SUM(total_order) as total_actual_daily_sales FROM orders JOIN motorist on motorist.id_motorist = orders.id_motorist JOIN distributor on motorist.distributor_code = distributor.distributor_code WHERE  date LIKE '%".$date_yesterday."%' AND distributor.regional = '".$data['regional_name']."' AND motorist.motorist_type = '".$data_motorist_type."' ")->result_array();		
			$total_actual_daily_sales = $data_total_actual_daily_sales[0]['total_actual_daily_sales'];
			
			
			$data_total_actual_daily_sales_monthly = $this->db->query("SELECT SUM(total_order) as total_actual_daily_sales_monthly FROM orders JOIN motorist on motorist.id_motorist = orders.id_motorist JOIN distributor on motorist.distributor_code = distributor.distributor_code WHERE date between '".$tanggal_bulan_awal."' AND '".$tanggal_bulan_akhir."'  AND distributor.regional = '".$data['regional_name']."' AND motorist.motorist_type = '".$data_motorist_type."' ")->result_array();		
			$total_actual_daily_sales_monthly = $data_total_actual_daily_sales_monthly[0]['total_actual_daily_sales_monthly'];
			
			$total_daily_target_sales_monthly = $total_daily_target_sales * $hari_kerja; 

			if($total_actual_daily_sales<=0)
			{
				$total_actual_daily_sales = "0";
			}
			
			if($target_call>0)
			{
			$persentasi_call = ($total_call * 100) / $target_call;
			$persentasi_call = number_format($persentasi_call, 0, '.', '');	
			}
			else{
				$persentasi_call = "0";
			}
			
			
			if($total_keseluruhan>0)
			{
			$persentasi_call_monthly = ($total_call_monthly * 100) / $total_keseluruhan;
			$persentasi_call_monthly = number_format($persentasi_call_monthly, 0, '.', '');	
			}
			else
			{
				$persentasi_call_monthly = "0";
			}
			
			if($target_call >0)
			{
			$persentasi_effective_call = ($total_effective_call  * 100) / $target_call;
			$persentasi_effective_call = number_format($persentasi_effective_call, 0, '.', '');
			}
			else{
				$persentasi_effective_call  = "0";
			}
			
			if($total_keseluruhan >0)
			{
			$persentasi_effective_call_monthly = ($total_effective_call_monthly  * 100) / $total_keseluruhan;
			$persentasi_effective_call_monthly = number_format($persentasi_effective_call_monthly, 0, '.', '');
			}
			else{
				$persentasi_effective_call_monthly  = "0";
			}
			
			if($total_actual_daily_sales>0)
			{
			$persentasi_target_harian = ($total_actual_daily_sales * 100) / $total_daily_target_sales;
			$persentasi_target_harian = number_format($persentasi_target_harian, 0, '.', '');
			}
			else
			{
				$persentasi_target_harian = "0";
			}
			
			
			if($total_actual_daily_sales_monthly>0)
			{
			$persentasi_target_bulanan = ($total_actual_daily_sales_monthly * 100) / $total_daily_target_sales_monthly;
			$persentasi_target_bulanan = number_format($persentasi_target_bulanan, 0, '.', '');
			}
			else
			{
				$persentasi_target_bulanan = "0";
			}
			
			if($total_actual_daily_sales_monthly<=0)
			{
				$total_actual_daily_sales_monthly=0;
			}
							
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $row, $target_call);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $row, $total_call);
			
			
			if($persentasi_call>=95)
			{
				$objPHPExcel->getActiveSheet()->getStyle("D".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('D'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => '099f3e')
						)
					 ) 
					 );
					 
				}
			else if($persentasi_call<90)
			{
				$objPHPExcel->getActiveSheet()->getStyle("D".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('D'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => 'fa364d')
						)
					 ) 
					 );
					 
			}
			
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $row, $persentasi_call." %");
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $row, $total_effective_call);
			
			if($persentasi_effective_call>95)
			{
				$objPHPExcel->getActiveSheet()->getStyle("F".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('F'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => '099f3e')
						)
					 ) 
					 );
					 
				}
			else if($persentasi_effective_call<90)
			{
				$objPHPExcel->getActiveSheet()->getStyle("F".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('F'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => 'fa364d')
						)
					 ) 
					 );
					 
			}
			
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, $row, $persentasi_effective_call." %");
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, $row, "Rp. ".number_format($total_daily_target_sales, 0 , '' , '.' ) );
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, $row, "Rp. ".number_format($total_actual_daily_sales, 0 , '' , '.' ));
			if($persentasi_target_harian>100)
			{
				$objPHPExcel->getActiveSheet()->getStyle("I".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('I'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => '099f3e')
						)
					 ) 
					 );
					 
				}
			else if($persentasi_target_harian<100)
			{
				$objPHPExcel->getActiveSheet()->getStyle("I".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('I'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => 'fa364d')
						)
					 ) 
					 );
					 
			}
			
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8, $row, $persentasi_target_harian." %");
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9, $row, $total_keseluruhan);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(10, $row, $total_call_monthly);
			if($persentasi_call_monthly>95)
			{
				$objPHPExcel->getActiveSheet()->getStyle("L".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('L'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => '099f3e')
						)
					 ) 
					 );
					 
				}
			else if($persentasi_call_monthly<90)
			{
				$objPHPExcel->getActiveSheet()->getStyle("L".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('L'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => 'fa364d')
						)
					 ) 
					 );
					 
			}
			
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(11, $row, $persentasi_call_monthly." %");
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(12, $row, $total_effective_call_monthly);
			if($persentasi_effective_call_monthly>95)
			{
				$objPHPExcel->getActiveSheet()->getStyle("N".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('N'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => '099f3e')
						)
					 ) 
					 );
					 
				}
			else if($persentasi_effective_call_monthly<90)
			{
				$objPHPExcel->getActiveSheet()->getStyle("N".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('N'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => 'fa364d')
						)
					 ) 
					 );
					 
			}
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(13, $row, $persentasi_effective_call_monthly." %");
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(14, $row, "Rp. ".number_format($total_daily_target_sales_monthly, 0 , '' , '.' ));
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(15, $row, "Rp. ".number_format($total_actual_daily_sales_monthly, 0 , '' , '.' ));
			
			if($persentasi_effective_call_monthly>$timerate)
			{
				$objPHPExcel->getActiveSheet()->getStyle("Q".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('Q'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => '099f3e')
						)
					 ) 
					 );
					 
				}
			else if($persentasi_effective_call_monthly<$timerate)
			{
				$objPHPExcel->getActiveSheet()->getStyle("Q".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('Q'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => 'fa364d')
						)
					 ) 
					 );
					 
			}
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(16, $row, $persentasi_target_bulanan." %");
			//Monthly
			
			$data_total_outlet_register = $this->db->query("SELECT COUNT(customer_code) as total_outlet_register FROM store WHERE regional = '".$data['regional_name']."' AND store.motorist_type = '".$data_motorist_type."'  ")->result_array();		
			$total_outlet_register = $data_total_outlet_register[0]['total_outlet_register'];
			
			//Monthly
			$total_outlet_active = $this->db->query("SELECT id_order FROM orders JOIN motorist on motorist.id_motorist = orders.id_motorist JOIN distributor on motorist.distributor_code = distributor.distributor_code WHERE distributor.regional = '".$data['regional_name']."' AND  date between '2016-".$bulan."-01 00:00:00' AND '2016-".$bulan."-31 23:59:59' AND motorist.motorist_type = '".$data_motorist_type."' group by customer_code")->num_rows();		
			
			
			$data_outlet_switching = $this->db->query("SELECT COUNT(id_noo) as total_outlet_switching FROM noo JOIN distributor on noo.distributor_code = distributor.distributor_code JOIN motorist on noo.motorist_code = motorist.motorist_code AND noo.distributor_code = motorist.distributor_code  WHERE distributor.regional = '".$data['regional_name']."' AND customer_create_date between '".$year."-".$bulan."-01 00:00:00'  AND '".$year."-".$bulan."-31 00:00:00' AND product = 'Bukan_Carnation' AND motorist.motorist_code = '2' ")->result_array();		
			$total_outlet_switching = $data_outlet_switching[0]['total_outlet_switching'];
			
			$total_motorist = $this->db->query("SELECT * FROM motorist join distributor on distributor.distributor_code = motorist.distributor_code WHERE distributor.regional = '".$data['regional_name']."' AND motorist.motorist_type = '".$data_motorist_type."'  ")->num_rows();
			$total_motorist = $total_motorist * 10;
			
			if($total_outlet_switching<=0)
			{$total_outlet_switching = '0'; }
			
			
			if($total_motorist>0)
			{
			$persentasi_outlet_switching = ($total_outlet_switching * 100) / $total_motorist;
			$persentasi_outlet_switching = number_format($persentasi_outlet_switching, 0, '.', '');
			}
			else
			{
				$persentasi_outlet_switching = "0";
			}
			
			
			if($total_outlet_register>0)
			{
			$persentasi_outlet_active = ($total_outlet_active * 100) / $total_outlet_register;
			$persentasi_outlet_active = number_format($persentasi_outlet_active, 0, '.', '');
			}
			else
			{
				$persentasi_outlet_active = "0";
			}
			
			
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(17, $row, $total_outlet_register);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(18, $row, $total_outlet_active);
			
			if($persentasi_outlet_active>$timerate)
			{
				$objPHPExcel->getActiveSheet()->getStyle("T".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('T'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => '099f3e')
						)
					 ) 
					 );
					 
				}
			else if($persentasi_outlet_active<$timerate)
			{
				$objPHPExcel->getActiveSheet()->getStyle("T".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('T'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => 'fa364d')
						)
					 ) 
					 );
					 
			}
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(19, $row, $persentasi_outlet_active." %");
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(20, $row, $total_motorist);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(21, $row, $total_outlet_switching);
			
			if($persentasi_outlet_switching>$timerate)
			{
				$objPHPExcel->getActiveSheet()->getStyle("W".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('W'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => '099f3e')
						)
					 ) 
					 );
					 
				}
			else if($persentasi_outlet_switching<$timerate)
			{
				$objPHPExcel->getActiveSheet()->getStyle("W".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('W'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => 'fa364d')
						)
					 ) 
					 );
					 
			}
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(22, $row, $persentasi_outlet_switching." %");
            $row++;
			// END Regional
			
			// AREA
			$data_area = $this->db->query("SELECT * FROM master_area WHERE regional = '".$data['regional_name']."' ");
			foreach($data_area->result_array() as $data_regional)
			{
				
				
					$objPHPExcel->getActiveSheet()->getStyle('A'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => 'f2e666')
						)
					 ) 
			);
			
						//AREA
					
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $row, $data_regional['area']);			
					
					$data_target_call = $this->db->query("SELECT COUNT(customer_code) as target_call FROM store WHERE day_visit = '".$day."' AND area = '".$data_regional['area']."' AND motorist_type = '".$data_motorist_type."' ")->result_array();		
					$target_call = $data_target_call[0]['target_call'];
					
									$total_store_keseluruhan = 0;
									
									$store_senin = $this->db->query("SELECT id_store FROM store WHERE area = '".$data_regional['area']."' AND day_visit = 'monday' AND motorist_type = '".$data_motorist_type."' ")->num_rows();
									//echo "store_senin".$store_senin."<br>";
									$total_store_senin = $total_senin * $store_senin;
									$store_selasa = $this->db->query("SELECT id_store FROM store WHERE area = '".$data_regional['area']."' AND day_visit = 'tuesday' AND motorist_type = '".$data_motorist_type."' ")->num_rows();
									//echo "store_selasa".$store_selasa."<br>";
									$total_store_selasa = $total_selasa * $store_selasa;
									$store_rabu = $this->db->query("SELECT id_store FROM store WHERE area = '".$data_regional['area']."' AND day_visit = 'wednesday' AND motorist_type = '".$data_motorist_type."' ")->num_rows();
									$total_store_rabu = $total_rabu * $store_rabu;
									//echo "store_rabu".$store_rabu."<br>";
									$store_kamis = $this->db->query("SELECT id_store FROM store WHERE area = '".$data_regional['area']."' AND day_visit = 'thursday' AND motorist_type = '".$data_motorist_type."' ")->num_rows();
									$total_store_kamis = $total_kamis * $store_kamis;
									//echo "store_kamis".$store_kamis."<br>";
									$store_jumat = $this->db->query("SELECT id_store FROM store WHERE area = '".$data_regional['area']."' AND day_visit = 'friday' AND motorist_type = '".$data_motorist_type."' ")->num_rows();
									$total_store_jumat = $total_jumat * $store_jumat;
									//echo "store_jumat".$store_jumat."<br>";
									$store_sabtu = $this->db->query("SELECT id_store FROM store WHERE area = '".$data_regional['area']."' AND day_visit = 'saturday' AND motorist_type = '".$data_motorist_type."' ")->num_rows();
									$total_store_sabtu = $total_sabtu * $store_sabtu;
									//echo "store_sabtu".$store_sabtu."<br>";
									$total_keseluruhan = $total_store_senin+$total_store_selasa+$total_store_rabu+$total_store_kamis+$total_store_jumat+$total_store_sabtu;

					$data_total_call = $this->db->query("SELECT COUNT(customer_code) as total_call FROM visit JOIN motorist on motorist.id_motorist = visit.id_motorist JOIN distributor on motorist.distributor_code = distributor.distributor_code  WHERE distributor.area = '".$data_regional['area']."' AND  status_visit = 'call' AND time_stamp_visit LIKE '%".$date_yesterday."%' AND motorist.motorist_type = '".$data_motorist_type."' ")->result_array();		
					$total_call = $data_total_call[0]['total_call'];
					
					$data_total_call_monthly = $this->db->query("SELECT COUNT(customer_code) as total_call_monthly FROM visit JOIN motorist on motorist.id_motorist = visit.id_motorist JOIN distributor on motorist.distributor_code = distributor.distributor_code WHERE distributor.area = '".$data_regional['area']."' AND status_visit = 'call' AND time_stamp_visit between '".$tanggal_bulan_awal."' AND '".$tanggal_bulan_akhir."' AND motorist.motorist_type = '".$data_motorist_type."' ")->result_array();		
					$total_call_monthly = $data_total_call_monthly[0]['total_call_monthly'];
					
					$data_total_effective_call = $this->db->query("SELECT COUNT(customer_code) as total_effective_call FROM visit JOIN motorist on motorist.id_motorist = visit.id_motorist JOIN distributor on motorist.distributor_code = distributor.distributor_code  WHERE distributor.area = '".$data_regional['area']."' AND status_order = 'order' AND  status_visit = 'call' AND time_stamp_visit LIKE '%".$date_yesterday."%' AND motorist.motorist_type = '".$data_motorist_type."' ")->result_array();		
					$total_effective_call = $data_total_effective_call[0]['total_effective_call'];
					
					$data_total_effective_call_monthly = $this->db->query("SELECT COUNT(customer_code) as total_effective_call_monthly FROM visit JOIN motorist on motorist.id_motorist = visit.id_motorist JOIN distributor on motorist.distributor_code = distributor.distributor_code  WHERE distributor.area = '".$data_regional['area']."' AND status_order = 'order' AND  status_visit = 'call' AND time_stamp_visit between '".$tanggal_bulan_awal."' AND '".$tanggal_bulan_akhir."' AND motorist.motorist_type = '".$data_motorist_type."' ")->result_array();		
					$total_effective_call_monthly = $data_total_effective_call_monthly[0]['total_effective_call_monthly'];
					
					
					$data_total_target_sales = $this->db->query("SELECT SUM(target_harian) as target_harian FROM motorist JOIN distributor on motorist.distributor_code = distributor.distributor_code  WHERE distributor.area = '".$data_regional['area']."' AND motorist.motorist_type = '".$data_motorist_type."' ")->result_array();		
					$total_daily_target_sales = $data_total_target_sales[0]['target_harian'];
					
					
					
					if($total_daily_target_sales<=0)
					{
						$total_daily_target_sales = "0";
					}
					
					$data_total_actual_daily_sales = $this->db->query("SELECT SUM(total_order) as total_actual_daily_sales FROM orders JOIN motorist on motorist.id_motorist = orders.id_motorist JOIN distributor on motorist.distributor_code = distributor.distributor_code WHERE  date LIKE '%".$date_yesterday."%' AND distributor.area = '".$data_regional['area']."' AND motorist.motorist_type = '".$data_motorist_type."' ")->result_array();		
					$total_actual_daily_sales = $data_total_actual_daily_sales[0]['total_actual_daily_sales'];
					
					
					$data_total_actual_daily_sales_monthly = $this->db->query("SELECT SUM(total_order) as total_actual_daily_sales_monthly FROM orders JOIN motorist on motorist.id_motorist = orders.id_motorist JOIN distributor on motorist.distributor_code = distributor.distributor_code WHERE date between '".$tanggal_bulan_awal."' AND '".$tanggal_bulan_akhir."'  AND distributor.area = '".$data_regional['area']."' AND motorist.motorist_type = '".$data_motorist_type."' ")->result_array();		
					$total_actual_daily_sales_monthly = $data_total_actual_daily_sales_monthly[0]['total_actual_daily_sales_monthly'];
					
					$total_daily_target_sales_monthly = $total_daily_target_sales * $hari_kerja; 

					if($total_actual_daily_sales<=0)
					{
						$total_actual_daily_sales = "0";
					}
					
					if($target_call>0)
					{
					$persentasi_call = ($total_call * 100) / $target_call;
					$persentasi_call = number_format($persentasi_call, 0, '.', '');	
					}
					else{
						$persentasi_call = "0";
					}
					
					
					if($total_keseluruhan>0)
					{
					$persentasi_call_monthly = ($total_call_monthly * 100) / $total_keseluruhan;
					$persentasi_call_monthly = number_format($persentasi_call_monthly, 0, '.', '');	
					}
					else
					{
						$persentasi_call_monthly = "0";
					}
					
					if($target_call >0)
					{
					$persentasi_effective_call = ($total_effective_call  * 100) / $target_call;
					$persentasi_effective_call = number_format($persentasi_effective_call, 0, '.', '');
					}
					else{
						$persentasi_effective_call  = "0";
					}
					
					if($total_keseluruhan >0)
					{
					$persentasi_effective_call_monthly = ($total_effective_call_monthly  * 100) / $total_keseluruhan;
					$persentasi_effective_call_monthly = number_format($persentasi_effective_call_monthly, 0, '.', '');
					}
					else{
						$persentasi_effective_call_monthly  = "0";
					}
					
					if($total_daily_target_sales>0)
					{
					$persentasi_target_harian = ($total_actual_daily_sales * 100) / $total_daily_target_sales;
					$persentasi_target_harian = number_format($persentasi_target_harian, 0, '.', '');
					}
					else
					{
						$persentasi_target_harian = "0";
					}
					
					
					if($total_daily_target_sales_monthly>0)
					{
					$persentasi_target_bulanan = ($total_actual_daily_sales_monthly * 100) / $total_daily_target_sales_monthly;
					$persentasi_target_bulanan = number_format($persentasi_target_bulanan, 0, '.', '');
					}
					else
					{
						$persentasi_target_bulanan = "0";
					}
					
					if($total_actual_daily_sales_monthly<=0)
					{
						$total_actual_daily_sales_monthly=0;
					}
									
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $row, $target_call);
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $row, $total_call);
					
					if($persentasi_call>95)
			{
				$objPHPExcel->getActiveSheet()->getStyle("D".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('D'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => '099f3e')
						)
					 ) 
					 );
					 
				}
			else if($persentasi_call<90)
			{
				$objPHPExcel->getActiveSheet()->getStyle("D".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('D'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => 'fa364d')
						)
					 ) 
					 );
					 
			}
			
			
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $row, $persentasi_call." %");
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $row, $total_effective_call);
					
					if($persentasi_effective_call>95)
			{
				$objPHPExcel->getActiveSheet()->getStyle("F".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('F'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => '099f3e')
						)
					 ) 
					 );
					 
				}
			else if($persentasi_effective_call<90)
			{
				$objPHPExcel->getActiveSheet()->getStyle("F".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('F'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => 'fa364d')
						)
					 ) 
					 );
					 
			}
			
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, $row, $persentasi_effective_call." %");
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, $row, "Rp. ".number_format($total_daily_target_sales, 0 , '' , '.' ));
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, $row, "Rp. ".number_format($total_actual_daily_sales, 0 , '' , '.' ));
					
					if($persentasi_target_harian>100)
			{
				$objPHPExcel->getActiveSheet()->getStyle("I".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('I'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => '099f3e')
						)
					 ) 
					 );
					 
				}
			else if($persentasi_target_harian<100)
			{
				$objPHPExcel->getActiveSheet()->getStyle("I".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('I'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => 'fa364d')
						)
					 ) 
					 );
					 
			}
			
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8, $row, $persentasi_target_harian." %");
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9, $row, $total_keseluruhan);
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(10, $row, $total_call_monthly);
					if($persentasi_call_monthly>95)
			{
				$objPHPExcel->getActiveSheet()->getStyle("L".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('L'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => '099f3e')
						)
					 ) 
					 );
					 
				}
			else if($persentasi_call_monthly<90)
			{
				$objPHPExcel->getActiveSheet()->getStyle("L".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('L'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => 'fa364d')
						)
					 ) 
					 );
					 
			}
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(11, $row, $persentasi_call_monthly." %");
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(12, $row, $total_effective_call_monthly);
					
					if($persentasi_effective_call_monthly>95)
			{
				$objPHPExcel->getActiveSheet()->getStyle("N".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('N'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => '099f3e')
						)
					 ) 
					 );
					 
				}
			else if($persentasi_effective_call_monthly<90)
			{
				$objPHPExcel->getActiveSheet()->getStyle("N".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('N'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => 'fa364d')
						)
					 ) 
					 );
					 
			}
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(13, $row, $persentasi_effective_call_monthly." %");
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(14, $row, "Rp. ".number_format($total_daily_target_sales_monthly, 0 , '' , '.' ));
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(15, $row, "Rp. ".number_format($total_actual_daily_sales_monthly, 0 , '' , '.' ));
					
					if($persentasi_effective_call_monthly>$timerate)
			{
				$objPHPExcel->getActiveSheet()->getStyle("Q".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('Q'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => '099f3e')
						)
					 ) 
					 );
					 
				}
			else if($persentasi_effective_call_monthly<$timerate)
			{
				$objPHPExcel->getActiveSheet()->getStyle("Q".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('Q'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => 'fa364d')
						)
					 ) 
					 );
					 
			}
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(16, $row, $persentasi_target_bulanan." %");
					//Monthly
					$data_total_outlet_register = $this->db->query("SELECT COUNT(customer_code) as total_outlet_register FROM store WHERE area = '".$data_regional['area']."' AND store.motorist_type = '".$data_motorist_type."'  ")->result_array();		
					$total_outlet_register = $data_total_outlet_register[0]['total_outlet_register'];
					
					//Monthly
					$total_outlet_active = $this->db->query("SELECT id_order FROM orders JOIN motorist on motorist.id_motorist = orders.id_motorist JOIN distributor on motorist.distributor_code = distributor.distributor_code WHERE distributor.area = '".$data_regional['area']."' AND  date between '2016-".$bulan."-01 00:00:00' AND '2016-".$bulan."-31 23:59:59' AND motorist.motorist_type = '".$data_motorist_type."' group by customer_code")->num_rows();		
					
					
					$data_outlet_switching = $this->db->query("SELECT COUNT(id_noo) as total_outlet_switching FROM noo JOIN distributor on noo.distributor_code = distributor.distributor_code JOIN motorist on noo.motorist_code = motorist.motorist_code AND noo.distributor_code = motorist.distributor_code  WHERE distributor.area = '".$data_regional['area']."' AND customer_create_date between '".$year."-".$bulan."-01 00:00:00'  AND '".$year."-".$bulan."-31 00:00:00' AND product = 'Bukan_Carnation' AND motorist.motorist_code = '2' ")->result_array();		
					$total_outlet_switching = $data_outlet_switching[0]['total_outlet_switching'];
					
					$total_motorist = $this->db->query("SELECT * FROM motorist join distributor on distributor.distributor_code = motorist.distributor_code WHERE distributor.area = '".$data_regional['area']."' AND motorist.motorist_type = '".$data_motorist_type."'  ")->num_rows();
					$total_motorist = $total_motorist * 10;
					
					if($total_outlet_switching<=0)
					{$total_outlet_switching = '0'; }
					
					
					if($total_motorist>0)
					{
					$persentasi_outlet_switching = ($total_outlet_switching * 100) / $total_motorist;
					$persentasi_outlet_switching = number_format($persentasi_outlet_switching, 0, '.', '');
					}
					else
					{
						$persentasi_outlet_switching = "0";
					}
					
					
					if($total_outlet_register>0)
					{
					$persentasi_outlet_active = ($total_outlet_active * 100) / $total_outlet_register;
					$persentasi_outlet_active = number_format($persentasi_outlet_active, 0, '.', '');
					}
					else
					{
						$persentasi_outlet_active = "0";
					}
					
					
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(17, $row, $total_outlet_register);
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(18, $row, $total_outlet_active);
					
					if($persentasi_outlet_active>$timerate)
			{
				$objPHPExcel->getActiveSheet()->getStyle("T".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('T'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => '099f3e')
						)
					 ) 
					 );
					 
				}
			else if($persentasi_outlet_active<$timerate)
			{
				$objPHPExcel->getActiveSheet()->getStyle("T".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('T'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => 'fa364d')
						)
					 ) 
					 );
					 
			}
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(19, $row, $persentasi_outlet_active." %");
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(20, $row, $total_motorist);
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(21, $row, $total_outlet_switching);
					
					if($persentasi_outlet_switching>$timerate)
			{
				$objPHPExcel->getActiveSheet()->getStyle("W".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('W'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => '099f3e')
						)
					 ) 
					 );
					 
				}
			else if($persentasi_outlet_switching<$timerate)
			{
				$objPHPExcel->getActiveSheet()->getStyle("W".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('W'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => 'fa364d')
						)
					 ) 
					 );
					 
			}
			
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(22, $row, $persentasi_outlet_switching." %");
					$row++;
				
				
				
				
			// Distributor
			$data_distributor_level = $this->db->query("SELECT * FROM distributor WHERE area = '".$data_regional['area']."' ");
			foreach($data_distributor_level->result_array() as $data_level_distributor)
			{
				
				$objPHPExcel->getActiveSheet()->getStyle('A'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => 'f2c566')
						)
					 ) 
			);
			
				
						//Distributor
					
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $row, $data_level_distributor['distributor_name']);			
					
					$data_target_call = $this->db->query("SELECT COUNT(customer_code) as target_call FROM store WHERE day_visit = '".$day."' AND distributor_code = '".$data_level_distributor['distributor_code']."' AND motorist_type = '".$data_motorist_type."' ")->result_array();		
					$target_call = $data_target_call[0]['target_call'];
					
									$total_store_keseluruhan = 0;
									
									$store_senin = $this->db->query("SELECT id_store FROM store WHERE distributor_code = '".$data_level_distributor['distributor_code']."' AND day_visit = 'monday' AND motorist_type = '".$data_motorist_type."' ")->num_rows();
									//echo "store_senin".$store_senin."<br>";
									$total_store_senin = $total_senin * $store_senin;
									$store_selasa = $this->db->query("SELECT id_store FROM store WHERE distributor_code = '".$data_level_distributor['distributor_code']."' AND day_visit = 'tuesday' AND motorist_type = '".$data_motorist_type."' ")->num_rows();
									//echo "store_selasa".$store_selasa."<br>";
									$total_store_selasa = $total_selasa * $store_selasa;
									$store_rabu = $this->db->query("SELECT id_store FROM store WHERE distributor_code = '".$data_level_distributor['distributor_code']."' AND day_visit = 'wednesday' AND motorist_type = '".$data_motorist_type."' ")->num_rows();
									$total_store_rabu = $total_rabu * $store_rabu;
									//echo "store_rabu".$store_rabu."<br>";
									$store_kamis = $this->db->query("SELECT id_store FROM store WHERE distributor_code = '".$data_level_distributor['distributor_code']."' AND day_visit = 'thursday' AND motorist_type = '".$data_motorist_type."' ")->num_rows();
									$total_store_kamis = $total_kamis * $store_kamis;
									//echo "store_kamis".$store_kamis."<br>";
									$store_jumat = $this->db->query("SELECT id_store FROM store WHERE distributor_code = '".$data_level_distributor['distributor_code']."' AND day_visit = 'friday' AND motorist_type = '".$data_motorist_type."' ")->num_rows();
									$total_store_jumat = $total_jumat * $store_jumat;
									//echo "store_jumat".$store_jumat."<br>";
									$store_sabtu = $this->db->query("SELECT id_store FROM store WHERE distributor_code = '".$data_level_distributor['distributor_code']."' AND day_visit = 'saturday' AND motorist_type = '".$data_motorist_type."' ")->num_rows();
									$total_store_sabtu = $total_sabtu * $store_sabtu;
									//echo "store_sabtu".$store_sabtu."<br>";
									$total_keseluruhan = $total_store_senin+$total_store_selasa+$total_store_rabu+$total_store_kamis+$total_store_jumat+$total_store_sabtu;

					$data_total_call = $this->db->query("SELECT COUNT(customer_code) as total_call FROM visit JOIN motorist on motorist.id_motorist = visit.id_motorist JOIN distributor on motorist.distributor_code = distributor.distributor_code  WHERE distributor.distributor_code = '".$data_level_distributor['distributor_code']."' AND  status_visit = 'call' AND time_stamp_visit LIKE '%".$date_yesterday."%' AND motorist.motorist_type = '".$data_motorist_type."' ")->result_array();		
					$total_call = $data_total_call[0]['total_call'];
					
					$data_total_call_monthly = $this->db->query("SELECT COUNT(customer_code) as total_call_monthly FROM visit JOIN motorist on motorist.id_motorist = visit.id_motorist JOIN distributor on motorist.distributor_code = distributor.distributor_code WHERE distributor.distributor_code = '".$data_level_distributor['distributor_code']."' AND status_visit = 'call' AND time_stamp_visit between '".$tanggal_bulan_awal."' AND '".$tanggal_bulan_akhir."' AND motorist.motorist_type = '".$data_motorist_type."' ")->result_array();		
					$total_call_monthly = $data_total_call_monthly[0]['total_call_monthly'];
					
					$data_total_effective_call = $this->db->query("SELECT COUNT(customer_code) as total_effective_call FROM visit JOIN motorist on motorist.id_motorist = visit.id_motorist JOIN distributor on motorist.distributor_code = distributor.distributor_code  WHERE distributor.distributor_code = '".$data_level_distributor['distributor_code']."' AND status_order = 'order' AND  status_visit = 'call' AND time_stamp_visit LIKE '%".$date_yesterday."%' AND motorist.motorist_type = '".$data_motorist_type."' ")->result_array();		
					$total_effective_call = $data_total_effective_call[0]['total_effective_call'];
					
					$data_total_effective_call_monthly = $this->db->query("SELECT COUNT(customer_code) as total_effective_call_monthly FROM visit JOIN motorist on motorist.id_motorist = visit.id_motorist JOIN distributor on motorist.distributor_code = distributor.distributor_code  WHERE distributor.distributor_code = '".$data_level_distributor['distributor_code']."' AND status_order = 'order' AND  status_visit = 'call' AND time_stamp_visit between '".$tanggal_bulan_awal."' AND '".$tanggal_bulan_akhir."' AND motorist.motorist_type = '".$data_motorist_type."' ")->result_array();		
					$total_effective_call_monthly = $data_total_effective_call_monthly[0]['total_effective_call_monthly'];
					
					
					$data_total_target_sales = $this->db->query("SELECT SUM(target_harian) as target_harian FROM motorist JOIN distributor on motorist.distributor_code = distributor.distributor_code  WHERE distributor.distributor_code = '".$data_level_distributor['distributor_code']."' AND motorist.motorist_type = '".$data_motorist_type."' ")->result_array();		
					$total_daily_target_sales = $data_total_target_sales[0]['target_harian'];
					
					
					
					if($total_daily_target_sales<=0)
					{
						$total_daily_target_sales = "0";
					}
					
					$data_total_actual_daily_sales = $this->db->query("SELECT SUM(total_order) as total_actual_daily_sales FROM orders JOIN motorist on motorist.id_motorist = orders.id_motorist JOIN distributor on motorist.distributor_code = distributor.distributor_code WHERE  date LIKE '%".$date_yesterday."%' AND distributor.distributor_code = '".$data_level_distributor['distributor_code']."' AND motorist.motorist_type = '".$data_motorist_type."' ")->result_array();		
					$total_actual_daily_sales = $data_total_actual_daily_sales[0]['total_actual_daily_sales'];
					
					
					$data_total_actual_daily_sales_monthly = $this->db->query("SELECT SUM(total_order) as total_actual_daily_sales_monthly FROM orders JOIN motorist on motorist.id_motorist = orders.id_motorist JOIN distributor on motorist.distributor_code = distributor.distributor_code WHERE date between '".$tanggal_bulan_awal."' AND '".$tanggal_bulan_akhir."'  AND distributor.distributor_code = '".$data_level_distributor['distributor_code']."' AND motorist.motorist_type = '".$data_motorist_type."' ")->result_array();		
					$total_actual_daily_sales_monthly = $data_total_actual_daily_sales_monthly[0]['total_actual_daily_sales_monthly'];
					
					$total_daily_target_sales_monthly = $total_daily_target_sales * $hari_kerja; 

					if($total_actual_daily_sales<=0)
					{
						$total_actual_daily_sales = "0";
					}
					
					if($target_call>0)
					{
					$persentasi_call = ($total_call * 100) / $target_call;
					$persentasi_call = number_format($persentasi_call, 0, '.', '');	
					}
					else{
						$persentasi_call = "0";
					}
					
					
					if($total_keseluruhan>0)
					{
					$persentasi_call_monthly = ($total_call_monthly * 100) / $total_keseluruhan;
					$persentasi_call_monthly = number_format($persentasi_call_monthly, 0, '.', '');	
					}
					else
					{
						$persentasi_call_monthly = "0";
					}
					
					if($target_call >0)
					{
					$persentasi_effective_call = ($total_effective_call  * 100) / $target_call;
					$persentasi_effective_call = number_format($persentasi_effective_call, 0, '.', '');
					}
					else{
						$persentasi_effective_call  = "0";
					}
					
					if($total_keseluruhan >0)
					{
					$persentasi_effective_call_monthly = ($total_effective_call_monthly  * 100) / $total_keseluruhan;
					$persentasi_effective_call_monthly = number_format($persentasi_effective_call_monthly, 0, '.', '');
					}
					else{
						$persentasi_effective_call_monthly  = "0";
					}
					
					if($total_daily_target_sales>0)
					{
					$persentasi_target_harian = ($total_actual_daily_sales * 100) / $total_daily_target_sales;
					$persentasi_target_harian = number_format($persentasi_target_harian, 0, '.', '');
					}
					else
					{
						$persentasi_target_harian = "0";
					}
					
					
					if($total_daily_target_sales_monthly>0)
					{
					$persentasi_target_bulanan = ($total_actual_daily_sales_monthly * 100) / $total_daily_target_sales_monthly;
					$persentasi_target_bulanan = number_format($persentasi_target_bulanan, 0, '.', '');
					}
					else
					{
						$persentasi_target_bulanan = "0";
					}
					
					if($total_actual_daily_sales_monthly<=0)
					{
						$total_actual_daily_sales_monthly=0;
					}
									
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $row, $target_call);
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $row, $total_call);
					
					if($persentasi_call>95)
			{
				$objPHPExcel->getActiveSheet()->getStyle("D".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('D'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => '099f3e')
						)
					 ) 
					 );
					 
				}
			else if($persentasi_call<90)
			{
				$objPHPExcel->getActiveSheet()->getStyle("D".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('D'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => 'fa364d')
						)
					 ) 
					 );
					 
			}
			
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $row, $persentasi_call." %");
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $row, $total_effective_call);
					
					if($persentasi_effective_call>95)
			{
				$objPHPExcel->getActiveSheet()->getStyle("F".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('F'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => '099f3e')
						)
					 ) 
					 );
					 
				}
			else if($persentasi_effective_call<90)
			{
				$objPHPExcel->getActiveSheet()->getStyle("F".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('F'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => 'fa364d')
						)
					 ) 
					 );
					 
			}
			
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, $row, $persentasi_effective_call." %");
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, $row, "Rp. ".number_format($total_daily_target_sales, 0 , '' , '.' ));
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, $row, "Rp. ".number_format($total_actual_daily_sales, 0 , '' , '.' ));
					if($persentasi_target_harian>100)
			{
				$objPHPExcel->getActiveSheet()->getStyle("I".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('I'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => '099f3e')
						)
					 ) 
					 );
					 
				}
			else if($persentasi_target_harian<100)
			{
				$objPHPExcel->getActiveSheet()->getStyle("I".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('I'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => 'fa364d')
						)
					 ) 
					 );
					 
			}
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8, $row, $persentasi_target_harian." %");
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9, $row, $total_keseluruhan);
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(10, $row, $total_call_monthly);
					if($persentasi_call_monthly>95)
			{
				$objPHPExcel->getActiveSheet()->getStyle("L".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('L'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => '099f3e')
						)
					 ) 
					 );
					 
				}
			else if($persentasi_call_monthly<90)
			{
				$objPHPExcel->getActiveSheet()->getStyle("L".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('L'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => 'fa364d')
						)
					 ) 
					 );
					 
			}
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(11, $row, $persentasi_call_monthly." %");
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(12, $row, $total_effective_call_monthly);
					
					if($persentasi_effective_call_monthly>95)
			{
				$objPHPExcel->getActiveSheet()->getStyle("N".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('N'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => '099f3e')
						)
					 ) 
					 );
					 
				}
			else if($persentasi_effective_call_monthly<90)
			{
				$objPHPExcel->getActiveSheet()->getStyle("N".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('N'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => 'fa364d')
						)
					 ) 
					 );
					 
			}
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(13, $row, $persentasi_effective_call_monthly." %");
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(14, $row, "Rp. ".number_format($total_daily_target_sales_monthly, 0 , '' , '.' ));
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(15, $row, "Rp. ".number_format($total_actual_daily_sales_monthly, 0 , '' , '.' ));
					
					if($persentasi_effective_call_monthly>$timerate)
			{
				$objPHPExcel->getActiveSheet()->getStyle("Q".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('Q'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => '099f3e')
						)
					 ) 
					 );
					 
				}
			else if($persentasi_effective_call_monthly<$timerate)
			{
				$objPHPExcel->getActiveSheet()->getStyle("Q".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('Q'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => 'fa364d')
						)
					 ) 
					 );
					 
			}
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(16, $row, $persentasi_target_bulanan." %");
					//Monthly
					$data_total_outlet_register = $this->db->query("SELECT COUNT(customer_code) as total_outlet_register FROM store WHERE distributor_code = '".$data_level_distributor['distributor_code']."' AND store.motorist_type = '".$data_motorist_type."'  ")->result_array();		
					$total_outlet_register = $data_total_outlet_register[0]['total_outlet_register'];
					
					//Monthly
					$total_outlet_active = $this->db->query("SELECT id_order FROM orders JOIN motorist on motorist.id_motorist = orders.id_motorist JOIN distributor on motorist.distributor_code = distributor.distributor_code WHERE distributor.distributor_code = '".$data_level_distributor['distributor_code']."' AND  date between '2016-".$bulan."-01 00:00:00' AND '2016-".$bulan."-31 23:59:59' AND motorist.motorist_type = '".$data_motorist_type."' group by customer_code")->num_rows();		
					
					
					$data_outlet_switching = $this->db->query("SELECT COUNT(id_noo) as total_outlet_switching FROM noo JOIN distributor on noo.distributor_code = distributor.distributor_code JOIN motorist on noo.motorist_code = motorist.motorist_code AND noo.distributor_code = motorist.distributor_code  WHERE distributor.distributor_code = '".$data_level_distributor['distributor_code']."' AND customer_create_date between '".$year."-".$bulan."-01 00:00:00'  AND '".$year."-".$bulan."-31 00:00:00' AND product = 'Bukan_Carnation' AND motorist.motorist_code = '2'  ")->result_array();		
					$total_outlet_switching = $data_outlet_switching[0]['total_outlet_switching'];
					
					$total_motorist = $this->db->query("SELECT * FROM motorist join distributor on distributor.distributor_code = motorist.distributor_code WHERE distributor.distributor_code = '".$data_level_distributor['distributor_code']."' AND motorist.motorist_type = '".$data_motorist_type."'  ")->num_rows();
					$total_motorist = $total_motorist * 10;
					
					if($total_outlet_switching<=0)
					{$total_outlet_switching = '0'; }
					
					
					if($total_motorist>0)
					{
					$persentasi_outlet_switching = ($total_outlet_switching * 100) / $total_motorist;
					$persentasi_outlet_switching = number_format($persentasi_outlet_switching, 0, '.', '');
					}
					else
					{
						$persentasi_outlet_switching = "0";
					}
					
					
					if($total_outlet_register>0)
					{
					$persentasi_outlet_active = ($total_outlet_active * 100) / $total_outlet_register;
					$persentasi_outlet_active = number_format($persentasi_outlet_active, 0, '.', '');
					}
					else
					{
						$persentasi_outlet_active = "0";
					}
					
					
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(17, $row, $total_outlet_register);
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(18, $row, $total_outlet_active);
					
					if($persentasi_outlet_active>$timerate)
			{
				$objPHPExcel->getActiveSheet()->getStyle("T".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('T'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => '099f3e')
						)
					 ) 
					 );
					 
				}
			else if($persentasi_outlet_active<$timerate)
			{
				$objPHPExcel->getActiveSheet()->getStyle("T".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('T'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => 'fa364d')
						)
					 ) 
					 );
					 
			}
			
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(19, $row, $persentasi_outlet_active." %");
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(20, $row, $total_motorist);
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(21, $row, $total_outlet_switching);
					
					if($persentasi_outlet_switching>$timerate)
			{
				$objPHPExcel->getActiveSheet()->getStyle("W".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('W'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => '099f3e')
						)
					 ) 
					 );
					 
				}
			else if($persentasi_outlet_switching<$timerate)
			{
				$objPHPExcel->getActiveSheet()->getStyle("W".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('W'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => 'fa364d')
						)
					 ) 
					 );
					 
			}
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(22, $row, $persentasi_outlet_switching." %");
					$row++;
					
					
					
					
					// Motorist
			$data_motorist_level = $this->db->query("SELECT * FROM motorist WHERE distributor_code = '".$data_level_distributor['distributor_code']."' AND motorist_type = '".$data_motorist_type."' ");
			foreach($data_motorist_level->result_array() as $data_level_motorist)
			{
				
					$objPHPExcel->getActiveSheet()->getStyle('A'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => 'a0fff9')
						)
					 ) 
			);
			
				
						//Distributor
					
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $row, $data_level_motorist['motorist_name'].'-'.$data_level_motorist['motorist_code']);			
					
					$data_target_call = $this->db->query("SELECT COUNT(customer_code) as target_call FROM store WHERE day_visit = '".$day."' AND distributor_code = '".$data_level_motorist['distributor_code']."' AND motorist_code = '".$data_level_motorist['motorist_code']."' ")->result_array();		
					$target_call = $data_target_call[0]['target_call'];
					
									$total_store_keseluruhan = 0;
									
									$store_senin = $this->db->query("SELECT id_store FROM store WHERE distributor_code = '".$data_level_motorist['distributor_code']."' AND motorist_code = '".$data_level_motorist['motorist_code']."' AND day_visit = 'monday' ")->num_rows();
									//echo "store_senin".$store_senin."<br>";
									$total_store_senin = $total_senin * $store_senin;
									$store_selasa = $this->db->query("SELECT id_store FROM store WHERE distributor_code = '".$data_level_motorist['distributor_code']."' AND motorist_code = '".$data_level_motorist['motorist_code']."' AND day_visit = 'tuesday' ")->num_rows();
									//echo "store_selasa".$store_selasa."<br>";
									$total_store_selasa = $total_selasa * $store_selasa;
									$store_rabu = $this->db->query("SELECT id_store FROM store WHERE distributor_code = '".$data_level_motorist['distributor_code']."' AND motorist_code = '".$data_level_motorist['motorist_code']."' AND day_visit = 'wednesday' ")->num_rows();
									$total_store_rabu = $total_rabu * $store_rabu;
									//echo "store_rabu".$store_rabu."<br>";
									$store_kamis = $this->db->query("SELECT id_store FROM store WHERE distributor_code = '".$data_level_motorist['distributor_code']."' AND motorist_code = '".$data_level_motorist['motorist_code']."' AND day_visit = 'thursday' ")->num_rows();
									$total_store_kamis = $total_kamis * $store_kamis;
									//echo "store_kamis".$store_kamis."<br>";
									$store_jumat = $this->db->query("SELECT id_store FROM store WHERE distributor_code = '".$data_level_motorist['distributor_code']."' AND motorist_code = '".$data_level_motorist['motorist_code']."' AND day_visit = 'friday' ")->num_rows();
									$total_store_jumat = $total_jumat * $store_jumat;
									//echo "store_jumat".$store_jumat."<br>";
									$store_sabtu = $this->db->query("SELECT id_store FROM store WHERE distributor_code = '".$data_level_motorist['distributor_code']."' AND motorist_code = '".$data_level_motorist['motorist_code']."' AND day_visit = 'saturday' ")->num_rows();
									$total_store_sabtu = $total_sabtu * $store_sabtu;
									//echo "store_sabtu".$store_sabtu."<br>";
									$total_keseluruhan = $total_store_senin+$total_store_selasa+$total_store_rabu+$total_store_kamis+$total_store_jumat+$total_store_sabtu;

					$data_total_call = $this->db->query("SELECT COUNT(customer_code) as total_call FROM visit JOIN motorist on motorist.id_motorist = visit.id_motorist JOIN distributor on motorist.distributor_code = distributor.distributor_code  WHERE distributor.distributor_code = '".$data_level_motorist['distributor_code']."' AND motorist.motorist_code = '".$data_level_motorist['motorist_code']."' AND  status_visit = 'call' AND time_stamp_visit LIKE '%".$date_yesterday."%' ")->result_array();		
					$total_call = $data_total_call[0]['total_call'];
					
					$data_total_call_monthly = $this->db->query("SELECT COUNT(customer_code) as total_call_monthly FROM visit JOIN motorist on motorist.id_motorist = visit.id_motorist JOIN distributor on motorist.distributor_code = distributor.distributor_code WHERE distributor.distributor_code = '".$data_level_motorist['distributor_code']."' AND motorist.motorist_code = '".$data_level_motorist['motorist_code']."' AND status_visit = 'call' AND time_stamp_visit between '".$tanggal_bulan_awal."' AND '".$tanggal_bulan_akhir."'")->result_array();		
					$total_call_monthly = $data_total_call_monthly[0]['total_call_monthly'];
					
					$data_total_effective_call = $this->db->query("SELECT COUNT(customer_code) as total_effective_call FROM visit JOIN motorist on motorist.id_motorist = visit.id_motorist JOIN distributor on motorist.distributor_code = distributor.distributor_code  WHERE distributor.distributor_code = '".$data_level_motorist['distributor_code']."' AND motorist.motorist_code = '".$data_level_motorist['motorist_code']."' AND status_order = 'order' AND  status_visit = 'call' AND time_stamp_visit LIKE '%".$date_yesterday."%' ")->result_array();		
					$total_effective_call = $data_total_effective_call[0]['total_effective_call'];
					
					$data_total_effective_call_monthly = $this->db->query("SELECT COUNT(customer_code) as total_effective_call_monthly FROM visit JOIN motorist on motorist.id_motorist = visit.id_motorist JOIN distributor on motorist.distributor_code = distributor.distributor_code  WHERE distributor.distributor_code = '".$data_level_motorist['distributor_code']."' AND motorist.motorist_code = '".$data_level_motorist['motorist_code']."' AND status_order = 'order' AND  status_visit = 'call' AND time_stamp_visit between '".$tanggal_bulan_awal."' AND '".$tanggal_bulan_akhir."' ")->result_array();		
					$total_effective_call_monthly = $data_total_effective_call_monthly[0]['total_effective_call_monthly'];
					
					
					$data_total_target_sales = $this->db->query("SELECT SUM(target_harian) as target_harian FROM motorist JOIN distributor on motorist.distributor_code = distributor.distributor_code  WHERE distributor.distributor_code = '".$data_level_motorist['distributor_code']."' AND motorist.motorist_code = '".$data_level_motorist['motorist_code']."' ")->result_array();		
					$total_daily_target_sales = $data_total_target_sales[0]['target_harian'];
					
					
					
					if($total_daily_target_sales<=0)
					{
						$total_daily_target_sales = "0";
					}
					
					$data_total_actual_daily_sales = $this->db->query("SELECT SUM(total_order) as total_actual_daily_sales FROM orders JOIN motorist on motorist.id_motorist = orders.id_motorist JOIN distributor on motorist.distributor_code = distributor.distributor_code WHERE  date LIKE '%".$date_yesterday."%' AND distributor.distributor_code = '".$data_level_motorist['distributor_code']."' AND motorist.motorist_code = '".$data_level_motorist['motorist_code']."' ")->result_array();		
					$total_actual_daily_sales = $data_total_actual_daily_sales[0]['total_actual_daily_sales'];
					
					
					$data_total_actual_daily_sales_monthly = $this->db->query("SELECT SUM(total_order) as total_actual_daily_sales_monthly FROM orders JOIN motorist on motorist.id_motorist = orders.id_motorist JOIN distributor on motorist.distributor_code = distributor.distributor_code WHERE date between '".$tanggal_bulan_awal."' AND '".$tanggal_bulan_akhir."'  AND distributor.distributor_code = '".$data_level_motorist['distributor_code']."' AND motorist.motorist_code = '".$data_level_motorist['motorist_code']."' ")->result_array();		
					$total_actual_daily_sales_monthly = $data_total_actual_daily_sales_monthly[0]['total_actual_daily_sales_monthly'];
					
					$total_daily_target_sales_monthly = $total_daily_target_sales * $hari_kerja; 

					if($total_actual_daily_sales<=0)
					{
						$total_actual_daily_sales = "0";
					}
					
					if($target_call>0)
					{
					$persentasi_call = ($total_call * 100) / $target_call;
					$persentasi_call = number_format($persentasi_call, 0, '.', '');	
					}
					else{
						$persentasi_call = "0";
					}
					
					
					if($total_keseluruhan>0)
					{
					$persentasi_call_monthly = ($total_call_monthly * 100) / $total_keseluruhan;
					$persentasi_call_monthly = number_format($persentasi_call_monthly, 0, '.', '');	
					}
					else
					{
						$persentasi_call_monthly = "0";
					}
					
					if($target_call >0)
					{
					$persentasi_effective_call = ($total_effective_call  * 100) / $target_call;
					$persentasi_effective_call = number_format($persentasi_effective_call, 0, '.', '');
					}
					else{
						$persentasi_effective_call  = "0";
					}
					
					if($total_keseluruhan >0)
					{
					$persentasi_effective_call_monthly = ($total_effective_call_monthly  * 100) / $total_keseluruhan;
					$persentasi_effective_call_monthly = number_format($persentasi_effective_call_monthly, 0, '.', '');
					}
					else{
						$persentasi_effective_call_monthly  = "0";
					}
					
					if($total_daily_target_sales>0)
					{
					$persentasi_target_harian = ($total_actual_daily_sales * 100) / $total_daily_target_sales;
					$persentasi_target_harian = number_format($persentasi_target_harian, 0, '.', '');
					}
					else
					{
						$persentasi_target_harian = "0";
					}
					
					
					if($total_daily_target_sales_monthly>0)
					{
					$persentasi_target_bulanan = ($total_actual_daily_sales_monthly * 100) / $total_daily_target_sales_monthly;
					$persentasi_target_bulanan = number_format($persentasi_target_bulanan, 0, '.', '');
					}
					else
					{
						$persentasi_target_bulanan = "0";
					}
					
					if($total_actual_daily_sales_monthly<=0)
					{
						$total_actual_daily_sales_monthly=0;
					}
									
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $row, $target_call);
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $row, $total_call);
					
					if($persentasi_call>95)
			{
				$objPHPExcel->getActiveSheet()->getStyle("D".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('D'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => '099f3e')
						)
					 ) 
					 );
					 
				}
			else if($persentasi_call<90)
			{
				$objPHPExcel->getActiveSheet()->getStyle("D".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('D'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => 'fa364d')
						)
					 ) 
					 );
					 
			}
			
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $row, $persentasi_call." %");
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $row, $total_effective_call);
					
					
					if($persentasi_effective_call>95)
			{
				$objPHPExcel->getActiveSheet()->getStyle("F".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('F'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => '099f3e')
						)
					 ) 
					 );
					 
				}
			else if($persentasi_effective_call<90)
			{
				$objPHPExcel->getActiveSheet()->getStyle("F".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('F'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => 'fa364d')
						)
					 ) 
					 );
					 
			}
			
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, $row, $persentasi_effective_call." %");
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, $row, "Rp. ".number_format($total_daily_target_sales, 0 , '' , '.' ));
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, $row, "Rp. ".number_format($total_actual_daily_sales, 0 , '' , '.' ));
					
					if($persentasi_target_harian>100)
			{
				$objPHPExcel->getActiveSheet()->getStyle("I".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('I'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => '099f3e')
						)
					 ) 
					 );
					 
				}
			else if($persentasi_target_harian<100)
			{
				$objPHPExcel->getActiveSheet()->getStyle("I".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('I'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => 'fa364d')
						)
					 ) 
					 );
					 
			}
			
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8, $row, $persentasi_target_harian." %");
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9, $row, $total_keseluruhan);
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(10, $row, $total_call_monthly);
					if($persentasi_call_monthly>95)
			{
				$objPHPExcel->getActiveSheet()->getStyle("L".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('L'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => '099f3e')
						)
					 ) 
					 );
					 
				}
			else if($persentasi_call_monthly<90)
			{
				$objPHPExcel->getActiveSheet()->getStyle("L".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('L'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => 'fa364d')
						)
					 ) 
					 );
					 
			}
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(11, $row, $persentasi_call_monthly." %");
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(12, $row, $total_effective_call_monthly);
					if($persentasi_effective_call_monthly>95)
			{
				$objPHPExcel->getActiveSheet()->getStyle("N".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('N'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => '099f3e')
						)
					 ) 
					 );
					 
				}
			else if($persentasi_effective_call_monthly<90)
			{
				$objPHPExcel->getActiveSheet()->getStyle("N".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('N'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => 'fa364d')
						)
					 ) 
					 );
					 
			}
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(13, $row, $persentasi_effective_call_monthly." %");
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(14, $row, "Rp. ".number_format($total_daily_target_sales_monthly, 0 , '' , '.' ));
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(15, $row, "Rp. ".number_format($total_actual_daily_sales_monthly, 0 , '' , '.' ));
					
					if($persentasi_effective_call_monthly>$timerate)
			{
				$objPHPExcel->getActiveSheet()->getStyle("Q".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('Q'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => '099f3e')
						)
					 ) 
					 );
					 
				}
			else if($persentasi_effective_call_monthly<$timerate)
			{
				$objPHPExcel->getActiveSheet()->getStyle("Q".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('Q'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => 'fa364d')
						)
					 ) 
					 );
					 
			}
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(16, $row, $persentasi_target_bulanan." %");
					//Monthly
					$data_total_outlet_register = $this->db->query("SELECT COUNT(customer_code) as total_outlet_register FROM store WHERE distributor_code = '".$data_level_motorist['distributor_code']."' AND motorist_code = '".$data_level_motorist['motorist_code']."'  ")->result_array();		
					$total_outlet_register = $data_total_outlet_register[0]['total_outlet_register'];
					
					//Monthly
					$total_outlet_active = $this->db->query("SELECT id_order FROM orders JOIN motorist on motorist.id_motorist = orders.id_motorist JOIN distributor on motorist.distributor_code = distributor.distributor_code WHERE distributor.distributor_code = '".$data_level_motorist['distributor_code']."' AND motorist.motorist_code = '".$data_level_motorist['motorist_code']."' AND  date between '2016-".$bulan."-01 00:00:00' AND '2016-".$bulan."-31 23:59:59' group by customer_code")->num_rows();		
					
					
					$data_outlet_switching = $this->db->query("SELECT COUNT(id_noo) as total_outlet_switching FROM noo JOIN distributor on noo.distributor_code = distributor.distributor_code WHERE distributor.distributor_code = '".$data_level_motorist['distributor_code']."' AND noo.motorist_code = '".$data_level_motorist['motorist_code']."' AND customer_create_date between '".$year."-".$bulan."-01 00:00:00'  AND '".$year."-".$bulan."-31 00:00:00' AND product = 'Bukan_Carnation' ")->result_array();		
					$total_outlet_switching = $data_outlet_switching[0]['total_outlet_switching'];
					
					//$total_motorist = $this->db->query("SELECT * FROM motorist join distributor on distributor.distributor_code = motorist.distributor_code WHERE distributor.distributor_code = '".$data_level_distributor['distributor_code']."'  ")->num_rows();
					$total_motorist =  10;
					
					if($total_outlet_switching<=0)
					{$total_outlet_switching = '0'; }
					
					
					if($total_motorist>0)
					{
					$persentasi_outlet_switching = ($total_outlet_switching * 100) / $total_motorist;
					$persentasi_outlet_switching = number_format($persentasi_outlet_switching, 0, '.', '');
					}
					else
					{
						$persentasi_outlet_switching = "0";
					}
					
					
					if($total_outlet_register>0)
					{
					$persentasi_outlet_active = ($total_outlet_active * 100) / $total_outlet_register;
					$persentasi_outlet_active = number_format($persentasi_outlet_active, 0, '.', '');
					}
					else
					{
						$persentasi_outlet_active = "0";
					}
					
					
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(17, $row, $total_outlet_register);
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(18, $row, $total_outlet_active);
					if($persentasi_outlet_active>$timerate)
			{
				$objPHPExcel->getActiveSheet()->getStyle("T".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('T'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => '099f3e')
						)
					 ) 
					 );
					 
				}
			else if($persentasi_outlet_active<$timerate)
			{
				$objPHPExcel->getActiveSheet()->getStyle("T".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('T'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => 'fa364d')
						)
					 ) 
					 );
					 
			}
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(19, $row, $persentasi_outlet_active." %");
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(20, $row, $total_motorist);
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(21, $row, $total_outlet_switching);
					
					if($persentasi_outlet_switching>$timerate)
			{
				$objPHPExcel->getActiveSheet()->getStyle("W".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('W'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => '099f3e')
						)
					 ) 
					 );
					 
				}
			else if($persentasi_outlet_switching<$timerate)
			{
				$objPHPExcel->getActiveSheet()->getStyle("W".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('W'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => 'fa364d')
						)
					 ) 
					 );
					 
			}
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(22, $row, $persentasi_outlet_switching." %");
					$row++;
				
			}
			// END Motorist
			
				
			}
			// END Distributor
			
			
			
			}
			// END AREA
			
			
			
		}
		
		 $last_row = $row-1;
		
	
		
		//Set Border
        $objPHPExcel->getActiveSheet()->getStyle("A6".":"."W".$last_row)->applyFromArray($BStyle);
	    $objPHPExcel->getActiveSheet()->getStyle("A5".":"."W".$last_row)->applyFromArray($styleAlign);
        $objPHPExcel->setActiveSheetIndex(0);
        $objWriter = IOFactory::createWriter($objPHPExcel, 'Excel5');
 		
		
	   // Sending headers to force the user to download the file
       // header('Content-Type: application/vnd.ms-excel');
       // header('Content-Disposition: attachment;filename="Products_'.date('dMy').'.xls"');
       // header('Cache-Control: max-age=0');
		
		
        // Sending headers to force the user to download the file        
		
        $objWriter->save('files/daily_report_'.$select_motorist_type[0]['motorist_type'].'_'.$date_now.'.xls');
		
		$list_email = $data_email['email'];
		$attachment_email = 'files/daily_report_'.$select_motorist_type[0]['motorist_type'].'_'.$date_now.'.xls';
		$message = 'Daily Report '.$select_motorist_type[0]['motorist_type'].' Tanggal '.$report_date;
		$subject = 'Daily Report '.$select_motorist_type[0]['motorist_type'].' Tanggal '.$report_date;
		$this->sendmail($list_email,$attachment_email,$message,$subject);
		

		$status_kirim_email = 'Sukses';

			
			
		$data_log = array(
		
		'date' => $date_now,
		'email' => $email_receiver,
		'status' => $status_kirim_email,
		'motorist' => $select_motorist_type[0]['motorist_type']
		
		);
		
		$this->model_report->insertData('log_report',$data_log );
		
		}
		
		else
		{
			echo"sudah kirim <br>";
			}
		
		}
		}
		else
		{
			echo"belum boleh";
			}
    }
	
	
	
	
	
	
	function Kantin()
    	{
		date_default_timezone_set('Asia/Jakarta');
		$date_now_check = date ('Y-m-d');
		$date_cutoff_check = new DateTime($date_now_check.'00:00:00');
		$datetime_now_check = date('Y-m-d H:i:s');
		$datetime_now_check = new DateTime($datetime_now_check);
		//Check Apakah sudah lebih dari jam setengah 4
		if($datetime_now_check > $date_cutoff_check)
		{
		
		$timestamp = date('D, M d Y H:s a ');
		$periode = date('M Y');
		$date_now = date ('Y-m-d');
		$date_yesterday = date('Y-m-d',strtotime("-1 days"));
		
		
		
		
		$select_email = $this->model_report->getEmail("WHERE motorist = 'Kantin' ");
		$data_emails = $select_email->result_array();
		
		foreach($data_emails as $data_email)
		{
			
		//Check Apakah sudah dikirim atau belum
		
		$select_motorist_type = $this->db->query("SELECT * FROM motorist_type WHERE motorist_type = '".$data_email['motorist']."' ")->result_array();
		$data_motorist_type = $select_motorist_type[0]['id_motorist_type'];
		echo $select_motorist_type[0]['motorist_type'];
		
		$email_receiver = $data_email['email'];	
		$check_log_report = $this->model_report->getLogReport("WHERE date = '".$date_now."' AND email = '".$data_email['email']."' AND motorist = '".$select_motorist_type[0]['motorist_type']."'  ")->num_rows;
		$query = $this->db->query("SELECT * FROM master_regional");
		if($check_log_report == 0 )
		{
		if(!$query)
        return false;
 		$report_date = date("d-m-Y");	
        //Starting the PHPExcel library
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
		foreach(range('A','Z') as $columnID)
		{
			$objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
		}
		
		
		//Merge And Center Title
		$objPHPExcel->getActiveSheet()->mergeCells('A1:D1');
		$objPHPExcel->getActiveSheet()->mergeCells('B5:I5');
		
		$objPHPExcel->getActiveSheet()->mergeCells('J5:W5');
		
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 1, "Tracking Productivity Motorist ".$select_motorist_type[0]['motorist_type']."");
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, 5, "Daily ");
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9, 5, "Month To Date ");
		$objPHPExcel->getActiveSheet()->getStyle('A5:W5')->applyFromArray($Fontstyle);
		
		$objPHPExcel->getActiveSheet()->getStyle('J5:W5')->applyFromArray(
			array(
				'fill' => array(
					'type' => PHPExcel_Style_Fill::FILL_SOLID,
					'color' => array('rgb' => '169805')
				)
			)
		);
		
		$objPHPExcel->getActiveSheet()->getStyle('B5:I5')->applyFromArray(
			array(
				'fill' => array(
					'type' => PHPExcel_Style_Fill::FILL_SOLID,
					'color' => array('rgb' => 'e4c208')
				)
			)
		);
		
		//Merge And Center Date
		$objPHPExcel->getActiveSheet()->mergeCells('A2:D2');
		
		$objPHPExcel->getActiveSheet()->mergeCells('A3:D3');
		
		//Set Font Color Title
		$objPHPExcel->getActiveSheet()->getStyle('A1:D2')->applyFromArray($FontstyleTitle);
		$objPHPExcel->getActiveSheet()->getStyle('A3:D3')->applyFromArray($FontstyleTitle);
		
		//Set Font Color Header
		$objPHPExcel->getActiveSheet()->getStyle('A6:W6')->applyFromArray($Fontstyle);
	
		
		
		//Set Backgroung Color Header
		$objPHPExcel->getActiveSheet()->getStyle('A6:O6')->applyFromArray(
			array(
				'fill' => array(
					'type' => PHPExcel_Style_Fill::FILL_SOLID,
					'color' => array('rgb' => '62a8ea')
				)
			)
		);
		
		
		$objPHPExcel->getActiveSheet()->getStyle('A6:A6')->applyFromArray(
			array(
				'fill' => array(
					'type' => PHPExcel_Style_Fill::FILL_SOLID,
					'color' => array('rgb' => '1dccec')
				)
			)
		);
		
		$objPHPExcel->getActiveSheet()->getStyle('B6:I6')->applyFromArray(
			array(
				'fill' => array(
					'type' => PHPExcel_Style_Fill::FILL_SOLID,
					'color' => array('rgb' => 'e4c208')
				)
			)
		);
		
		$objPHPExcel->getActiveSheet()->getStyle('J6:W6')->applyFromArray(
			array(
				'fill' => array(
					'type' => PHPExcel_Style_Fill::FILL_SOLID,
					'color' => array('rgb' => '169805')
				)
			)
		);
		
 		
		//Keterangan Report
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 1, "Tracking Productivity Motorist ".$select_motorist_type[0]['motorist_type']."");
		
		//Keterangan Distributor
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 2, $timestamp);
		
		
		
		
		
		
        // Field names in the first row
        $fields = array(
		"Sales Region" => "Sales Region",
		"Target Call" => "Target Call",
		"Actual Call" => "Actual Call",
		"% Call" => "% Call",
		"Effective Call" => "Effective Call",
		"% Effective Call" => "% Effective Call",
		"Target Sales" => "Target Sales",
		"Actual sales" => "Actual sales",
		"% Sales achievement" => "% Sales achievement",
		"Target Call Month" => "Target Call",
		"Actual Call Month" => "Actual Call",
		"% Call Month" => "% Call",
		"Effective Call Month" => "Effective Call",
		"% Effective Call Month" => "% Effective Call",
		"Target Sales Month" => "Target Sales",
		"Actual sales Month" => "Actual sales",
		"% Sales achievement Month" => "% Sales achievement",
		"Register Outlet" => "Register Outlet",
		"Active outlet" => "Active outlet",
		"% Active outlet" => "% Active outlet",
		"Target Switching" => "Target Switching",
		"Actual Switching" => "Actual Switching",
		"% Switching" => "% Switching"
		
		
		);
        $col = 0;
        foreach ($fields as $field)
        {
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, 6, $field);
            $col++;
        }
		
		
		 // Fetching the table data
        $row = 7;
		$no = 1;
		$no_order = "";
		
		$date_now_date = date('d');
		$bulan = date('m');
		$year = date('Y');
		
		$tanggal_bulan_awal = $year.'-'.$bulan."-01 00:00:00";
		$tanggal_bulan_akhir = $year.'-'.$bulan."-31 23:59:59";
		$month = intval($bulan);
		$month_with_null = $bulan;
		$total_day = date('t', mktime(0, 0, 0, $month, 1, $year)); 
		
		
		function number_of_working_days_all($from, $to) {
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
			
		
		function number_of_working_days($from, $to,$hari) {
			$workingDays = [$hari]; 
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
			
			$total_senin = number_of_working_days('2016-'.$bulan.'-01', '2016-'.$bulan.'-'.$date_now_date,1);
			//echo "total senin".$total_senin."<br>";
			$total_selasa = number_of_working_days('2016-'.$bulan.'-01', '2016-'.$bulan.'-'.$date_now_date,2);
			//echo "total selasa".$total_selasa."<br>";
			$total_rabu = number_of_working_days('2016-'.$bulan.'-01', '2016-'.$bulan.'-'.$date_now_date,3);
			//echo "total rabu".$total_rabu."<br>";
			$total_kamis = number_of_working_days('2016-'.$bulan.'-01', '2016-'.$bulan.'-'.$date_now_date,4);
			//echo "total kamis".$total_kamis."<br>";
			$total_jumat = number_of_working_days('2016-'.$bulan.'-01', '2016-'.$bulan.'-'.$date_now_date,5);
			//echo "total jumat".$total_jumat."<br>";
			$total_sabtu = number_of_working_days('2016-'.$bulan.'-01', '2016-'.$bulan.'-'.$date_now_date,6);
			//echo "total sabtu".$total_sabtu."<br>";
			
			$hari_kerja = number_of_working_days_all($year.'-'.$month_with_null.'-01', $year.'-'.$month_with_null.'-'.$total_day);
			
			$date_sekarang = date('d');
			$hari_sekarang = number_of_working_days_all($year.'-'.$month_with_null.'-01', $year.'-'.$month_with_null.'-'.$date_sekarang);
			$date_convert = date_create($date_yesterday);
			$day = date_format($date_convert,"l");
			
			
			
			//National
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $row, "National");			
			
			$data_target_call = $this->db->query("SELECT COUNT(customer_code) as target_call FROM store WHERE day_visit = '".$day."' AND motorist_type = '".$data_motorist_type."'  ")->result_array();		
			$target_call = $data_target_call[0]['target_call'];
			
							$total_store_keseluruhan = 0;
							
							$store_senin = $this->db->query("SELECT id_store FROM store WHERE day_visit = 'monday' AND motorist_type = '".$data_motorist_type."'  ")->num_rows();
							//echo "store_senin".$store_senin."<br>";
							$total_store_senin = $total_senin * $store_senin;
							$store_selasa = $this->db->query("SELECT id_store FROM store WHERE  day_visit = 'tuesday' AND motorist_type = '".$data_motorist_type."' ")->num_rows();
							//echo "store_selasa".$store_selasa."<br>";
							$total_store_selasa = $total_selasa * $store_selasa;
							$store_rabu = $this->db->query("SELECT id_store FROM store WHERE day_visit = 'wednesday' AND motorist_type = '".$data_motorist_type."' ")->num_rows();
							$total_store_rabu = $total_rabu * $store_rabu;
							//echo "store_rabu".$store_rabu."<br>";
							$store_kamis = $this->db->query("SELECT id_store FROM store WHERE  day_visit = 'thursday' AND motorist_type = '".$data_motorist_type."' ")->num_rows();
							$total_store_kamis = $total_kamis * $store_kamis;
							//echo "store_kamis".$store_kamis."<br>";
							$store_jumat = $this->db->query("SELECT id_store FROM store WHERE day_visit = 'friday' AND motorist_type = '".$data_motorist_type."' ")->num_rows();
							$total_store_jumat = $total_jumat * $store_jumat;
							//echo "store_jumat".$store_jumat."<br>";
							$store_sabtu = $this->db->query("SELECT id_store FROM store WHERE  day_visit = 'saturday' AND motorist_type = '".$data_motorist_type."' ")->num_rows();
							$total_store_sabtu = $total_sabtu * $store_sabtu;
							//echo "store_sabtu".$store_sabtu."<br>";
							$total_keseluruhan = $total_store_senin+$total_store_selasa+$total_store_rabu+$total_store_kamis+$total_store_jumat+$total_store_sabtu;

			$data_total_call = $this->db->query("SELECT COUNT(customer_code) as total_call FROM visit JOIN motorist on motorist.id_motorist = visit.id_motorist JOIN distributor on motorist.distributor_code = distributor.distributor_code  WHERE   status_visit = 'call' AND time_stamp_visit LIKE '%".$date_yesterday."%' AND motorist.motorist_type = '".$data_motorist_type."' ")->result_array();		
			$total_call = $data_total_call[0]['total_call'];
			
			$data_total_call_monthly = $this->db->query("SELECT COUNT(customer_code) as total_call_monthly FROM visit JOIN motorist on motorist.id_motorist = visit.id_motorist JOIN distributor on motorist.distributor_code = distributor.distributor_code WHERE  status_visit = 'call' AND time_stamp_visit between '".$tanggal_bulan_awal."' AND '".$tanggal_bulan_akhir."' AND motorist.motorist_type = '".$data_motorist_type."' ")->result_array();		
			$total_call_monthly = $data_total_call_monthly[0]['total_call_monthly'];
			
			$data_total_effective_call = $this->db->query("SELECT COUNT(customer_code) as total_effective_call FROM visit JOIN motorist on motorist.id_motorist = visit.id_motorist JOIN distributor on motorist.distributor_code = distributor.distributor_code  WHERE  status_order = 'order' AND  status_visit = 'call' AND time_stamp_visit LIKE '%".$date_yesterday."%' AND motorist.motorist_type = '".$data_motorist_type."' ")->result_array();		
			$total_effective_call = $data_total_effective_call[0]['total_effective_call'];
			
			$data_total_effective_call_monthly = $this->db->query("SELECT COUNT(customer_code) as total_effective_call_monthly FROM visit JOIN motorist on motorist.id_motorist = visit.id_motorist JOIN distributor on motorist.distributor_code = distributor.distributor_code  WHERE  status_order = 'order' AND  status_visit = 'call' AND time_stamp_visit between '".$tanggal_bulan_awal."' AND '".$tanggal_bulan_akhir."' AND motorist.motorist_type = '".$data_motorist_type."' ")->result_array();		
			$total_effective_call_monthly = $data_total_effective_call_monthly[0]['total_effective_call_monthly'];
			
			
			$data_total_target_sales = $this->db->query("SELECT SUM(target_harian) as target_harian FROM motorist JOIN distributor on motorist.distributor_code = distributor.distributor_code WHERE motorist.motorist_type = '".$data_motorist_type."' ")->result_array();		
			$total_daily_target_sales = $data_total_target_sales[0]['target_harian'];
			
			
			//Keterangan Distributor
			$timerate = ($hari_sekarang * 100)/ $hari_kerja;
			$timerate = number_format($timerate, 0, '.', '');
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 3, "Periode: ".$periode. " Elapsed workday: ".$hari_sekarang.'/'.$hari_kerja.' Timerate: '.$timerate.' %');
			
		
		
			if($total_daily_target_sales<=0)
			{
				$total_daily_target_sales = "0";
			}
			
			$data_total_actual_daily_sales = $this->db->query("SELECT SUM(total_order) as total_actual_daily_sales FROM orders JOIN motorist on motorist.id_motorist = orders.id_motorist JOIN distributor on motorist.distributor_code = distributor.distributor_code WHERE  date LIKE '%".$date_yesterday."%' AND motorist.motorist_type = '".$data_motorist_type."'  ")->result_array();		
			$total_actual_daily_sales = $data_total_actual_daily_sales[0]['total_actual_daily_sales'];
			
			
			$data_total_actual_daily_sales_monthly = $this->db->query("SELECT SUM(total_order) as total_actual_daily_sales_monthly FROM orders JOIN motorist on motorist.id_motorist = orders.id_motorist JOIN distributor on motorist.distributor_code = distributor.distributor_code WHERE date between '".$tanggal_bulan_awal."' AND '".$tanggal_bulan_akhir."' AND motorist.motorist_type = '".$data_motorist_type."'  ")->result_array();		
			$total_actual_daily_sales_monthly = $data_total_actual_daily_sales_monthly[0]['total_actual_daily_sales_monthly'];
			
			$total_daily_target_sales_monthly = $total_daily_target_sales * $hari_kerja; 

			if($total_actual_daily_sales<=0)
			{
				$total_actual_daily_sales = "0";
			}
			
			if($target_call>0)
			{
			$persentasi_call = ($total_call * 100) / $target_call;
			$persentasi_call = number_format($persentasi_call, 0, '.', '');	
			}
			else{
				$persentasi_call = "0";
			}
			
			
			if($total_keseluruhan>0)
			{
			$persentasi_call_monthly = ($total_call_monthly * 100) / $total_keseluruhan;
			$persentasi_call_monthly = number_format($persentasi_call_monthly, 0, '.', '');	
			}
			else
			{
				$persentasi_call_monthly = "0";
			}
			
			if($target_call >0)
			{
			$persentasi_effective_call = ($total_effective_call  * 100) / $target_call;
			$persentasi_effective_call = number_format($persentasi_effective_call, 0, '.', '');
			}
			else{
				$persentasi_effective_call  = "0";
			}
			
			if($total_keseluruhan >0)
			{
			$persentasi_effective_call_monthly = ($total_effective_call_monthly  * 100) / $total_keseluruhan;
			$persentasi_effective_call_monthly = number_format($persentasi_effective_call_monthly, 0, '.', '');
			}
			else{
				$persentasi_effective_call_monthly  = "0";
			}
			
			if($total_actual_daily_sales>0)
			{
			$persentasi_target_harian = ($total_actual_daily_sales * 100) / $total_daily_target_sales;
			$persentasi_target_harian = number_format($persentasi_target_harian, 0, '.', '');
			}
			else
			{
				$persentasi_target_harian = "0";
			}
			
			
			if($total_actual_daily_sales_monthly>0)
			{
			$persentasi_target_bulanan = ($total_actual_daily_sales_monthly * 100) / $total_daily_target_sales_monthly;
			$persentasi_target_bulanan = number_format($persentasi_target_bulanan, 0, '.', '');
			}
			else
			{
				$persentasi_target_bulanan = "0";
			}
			
			if($total_actual_daily_sales_monthly<=0)
			{
				$total_actual_daily_sales_monthly=0;
			}
			
			$objPHPExcel->getActiveSheet()->getStyle('A'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => 'e84fea')
						)
					 ) 
			);
			
							
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $row, $target_call);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $row, $total_call);
			
			if($persentasi_call>95)
			{
				$objPHPExcel->getActiveSheet()->getStyle("D".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('D'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => '099f3e')
						)
					 ) 
					 );
					 
				}
			else if($persentasi_call<90)
			{
				$objPHPExcel->getActiveSheet()->getStyle("D".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('D'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => 'fa364d')
						)
					 ) 
					 );
					 
			}
			
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $row, $persentasi_call." %");
			
			
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $row, $total_effective_call);
			
			if($persentasi_effective_call>95)
			{
				$objPHPExcel->getActiveSheet()->getStyle("F".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('F'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => '099f3e')
						)
					 ) 
					 );
					 
				}
			else if($persentasi_effective_call<90)
			{
				$objPHPExcel->getActiveSheet()->getStyle("F".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('F'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => 'fa364d')
						)
					 ) 
					 );
					 
			}
			
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, $row, $persentasi_effective_call." %");
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, $row, "Rp. ".number_format($total_daily_target_sales, 0 , '' , '.' ));
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, $row, "Rp. ".number_format($total_actual_daily_sales, 0 , '' , '.' ));
			
			if($persentasi_target_harian>100)
			{
				$objPHPExcel->getActiveSheet()->getStyle("I".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('I'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => '099f3e')
						)
					 ) 
					 );
					 
				}
			else if($persentasi_target_harian<100)
			{
				$objPHPExcel->getActiveSheet()->getStyle("I".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('I'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => 'fa364d')
						)
					 ) 
					 );
					 
			}
			
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8, $row, $persentasi_target_harian." %");
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9, $row, $total_keseluruhan);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(10, $row, $total_call_monthly);
			
			if($persentasi_call_monthly>95)
			{
				$objPHPExcel->getActiveSheet()->getStyle("L".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('L'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => '099f3e')
						)
					 ) 
					 );
					 
				}
			else if($persentasi_call_monthly<90)
			{
				$objPHPExcel->getActiveSheet()->getStyle("L".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('L'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => 'fa364d')
						)
					 ) 
					 );
					 
			}
			
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(11, $row, $persentasi_call_monthly." %");
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(12, $row, $total_effective_call_monthly);
			
			if($persentasi_effective_call_monthly>95)
			{
				$objPHPExcel->getActiveSheet()->getStyle("N".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('N'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => '099f3e')
						)
					 ) 
					 );
					 
				}
			else if($persentasi_effective_call_monthly<90)
			{
				$objPHPExcel->getActiveSheet()->getStyle("N".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('N'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => 'fa364d')
						)
					 ) 
					 );
					 
			}
			
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(13, $row, $persentasi_effective_call_monthly." %");
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(14, $row, "Rp. ".number_format($total_daily_target_sales_monthly, 0 , '' , '.' ));
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(15, $row, "Rp. ".number_format($total_actual_daily_sales_monthly, 0 , '' , '.' ));
			
			
			
			if($persentasi_effective_call_monthly>$timerate)
			{
				$objPHPExcel->getActiveSheet()->getStyle("Q".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('Q'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => '099f3e')
						)
					 ) 
					 );
					 
				}
			else if($persentasi_effective_call_monthly<$timerate)
			{
				$objPHPExcel->getActiveSheet()->getStyle("Q".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('Q'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => 'fa364d')
						)
					 ) 
					 );
					 
			}
			
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(16, $row, $persentasi_target_bulanan." %");
			//Monthly
			$data_total_outlet_register = $this->db->query("SELECT COUNT(customer_code) as total_outlet_register FROM store WHERE store.motorist_type = '".$data_motorist_type."'  ")->result_array();		
			$total_outlet_register = $data_total_outlet_register[0]['total_outlet_register'];
			
			//Monthly
			$total_outlet_active = $this->db->query("SELECT id_order FROM orders JOIN motorist on motorist.id_motorist = orders.id_motorist JOIN distributor on motorist.distributor_code = distributor.distributor_code WHERE  date between '2016-".$bulan."-01 00:00:00' AND '2016-".$bulan."-31 23:59:59' AND motorist.motorist_type = '".$data_motorist_type."' group by customer_code")->num_rows();		
			
			
			$data_outlet_switching = $this->db->query("SELECT COUNT(id_noo) as total_outlet_switching FROM noo JOIN distributor on noo.distributor_code = distributor.distributor_code JOIN motorist on noo.motorist_code = motorist.motorist_code AND noo.distributor_code = motorist.distributor_code  WHERE  customer_create_date between '".$year."-".$bulan."-01 00:00:00'  AND '".$year."-".$bulan."-31 00:00:00' AND product = 'Bukan_Carnation' AND motorist.motorist_code = '2' ")->result_array();		
			$total_outlet_switching = $data_outlet_switching[0]['total_outlet_switching'];
			
			$total_motorist = $this->db->query("SELECT * FROM motorist join distributor on distributor.distributor_code = motorist.distributor_code WHERE motorist.motorist_type = '".$data_motorist_type."'  ")->num_rows();
			$total_motorist = $total_motorist * 10;
			
			if($total_outlet_switching<=0)
			{$total_outlet_switching = '0'; }
			
			
			if($total_outlet_switching>0)
			{
			$persentasi_outlet_switching = ($total_outlet_switching * 100) / $total_motorist;
			$persentasi_outlet_switching = number_format($persentasi_outlet_switching, 0, '.', '');
			}
			else
			{
				$persentasi_outlet_switching = "0";
			}
			
			
			if($total_outlet_active>0)
			{
			$persentasi_outlet_active = ($total_outlet_active * 100) / $total_outlet_register;
			$persentasi_outlet_active = number_format($persentasi_outlet_active, 0, '.', '');
			}
			else
			{
				$persentasi_outlet_active = "0";
			}
			
			
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(17, $row, $total_outlet_register);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(18, $row, $total_outlet_active);
			
			if($persentasi_outlet_active>$timerate)
			{
				$objPHPExcel->getActiveSheet()->getStyle("T".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('T'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => '099f3e')
						)
					 ) 
					 );
					 
				}
			else if($persentasi_outlet_active<$timerate)
			{
				$objPHPExcel->getActiveSheet()->getStyle("T".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('T'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => 'fa364d')
						)
					 ) 
					 );
					 
			}
			
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(19, $row, $persentasi_outlet_active." %");
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(20, $row, $total_motorist);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(21, $row, $total_outlet_switching);
			
			if($persentasi_outlet_switching>$timerate)
			{
				$objPHPExcel->getActiveSheet()->getStyle("W".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('W'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => '099f3e')
						)
					 ) 
					 );
					 
				}
			else if($persentasi_outlet_switching<$timerate)
			{
				$objPHPExcel->getActiveSheet()->getStyle("W".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('W'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => 'fa364d')
						)
					 ) 
					 );
					 
			}
			
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(22, $row, $persentasi_outlet_switching." %");
			$row++;
			// End National
			
        foreach($query->result_array() as $data)
        {
			
			
			
			$objPHPExcel->getActiveSheet()->getStyle('A'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => '3bbe26')
						)
					 ) 
			);
			
			
			//Regional
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $row, $data['regional_name']);			
			$data_target_call = $this->db->query("SELECT COUNT(customer_code) as target_call FROM store WHERE day_visit = '".$day."' AND regional = '".$data['regional_name']."' AND motorist_type = '".$data_motorist_type."' ")->result_array();		
			$target_call = $data_target_call[0]['target_call'];
			
							$total_store_keseluruhan = 0;
							
							$store_senin = $this->db->query("SELECT id_store FROM store WHERE regional = '".$data['regional_name']."' AND day_visit = 'monday' AND motorist_type = '".$data_motorist_type."' ")->num_rows();
							//echo "store_senin".$store_senin."<br>";
							$total_store_senin = $total_senin * $store_senin;
							$store_selasa = $this->db->query("SELECT id_store FROM store WHERE regional = '".$data['regional_name']."' AND day_visit = 'tuesday' AND motorist_type = '".$data_motorist_type."' ")->num_rows();
							//echo "store_selasa".$store_selasa."<br>";
							$total_store_selasa = $total_selasa * $store_selasa;
							$store_rabu = $this->db->query("SELECT id_store FROM store WHERE regional = '".$data['regional_name']."' AND day_visit = 'wednesday' AND motorist_type = '".$data_motorist_type."' ")->num_rows();
							$total_store_rabu = $total_rabu * $store_rabu;
							//echo "store_rabu".$store_rabu."<br>";
							$store_kamis = $this->db->query("SELECT id_store FROM store WHERE regional = '".$data['regional_name']."' AND day_visit = 'thursday' AND motorist_type = '".$data_motorist_type."' ")->num_rows();
							$total_store_kamis = $total_kamis * $store_kamis;
							//echo "store_kamis".$store_kamis."<br>";
							$store_jumat = $this->db->query("SELECT id_store FROM store WHERE regional = '".$data['regional_name']."' AND day_visit = 'friday' AND motorist_type = '".$data_motorist_type."' ")->num_rows();
							$total_store_jumat = $total_jumat * $store_jumat;
							//echo "store_jumat".$store_jumat."<br>";
							$store_sabtu = $this->db->query("SELECT id_store FROM store WHERE regional = '".$data['regional_name']."' AND day_visit = 'saturday' AND motorist_type = '".$data_motorist_type."' ")->num_rows();
							$total_store_sabtu = $total_sabtu * $store_sabtu;
							//echo "store_sabtu".$store_sabtu."<br>";
							$total_keseluruhan = $total_store_senin+$total_store_selasa+$total_store_rabu+$total_store_kamis+$total_store_jumat+$total_store_sabtu;

			$data_total_call = $this->db->query("SELECT COUNT(customer_code) as total_call FROM visit JOIN motorist on motorist.id_motorist = visit.id_motorist JOIN distributor on motorist.distributor_code = distributor.distributor_code  WHERE distributor.regional = '".$data['regional_name']."' AND  status_visit = 'call' AND time_stamp_visit LIKE '%".$date_yesterday."%' AND motorist.motorist_type = '".$data_motorist_type."' ")->result_array();		
			$total_call = $data_total_call[0]['total_call'];
			
			$data_total_call_monthly = $this->db->query("SELECT COUNT(customer_code) as total_call_monthly FROM visit JOIN motorist on motorist.id_motorist = visit.id_motorist JOIN distributor on motorist.distributor_code = distributor.distributor_code WHERE distributor.regional = '".$data['regional_name']."' AND status_visit = 'call' AND time_stamp_visit between '".$tanggal_bulan_awal."' AND '".$tanggal_bulan_akhir."' AND motorist.motorist_type = '".$data_motorist_type."' ")->result_array();		
			$total_call_monthly = $data_total_call_monthly[0]['total_call_monthly'];
			
			$data_total_effective_call = $this->db->query("SELECT COUNT(customer_code) as total_effective_call FROM visit JOIN motorist on motorist.id_motorist = visit.id_motorist JOIN distributor on motorist.distributor_code = distributor.distributor_code  WHERE distributor.regional = '".$data['regional_name']."' AND status_order = 'order' AND  status_visit = 'call' AND time_stamp_visit LIKE '%".$date_yesterday."%' AND motorist.motorist_type = '".$data_motorist_type."' ")->result_array();		
			$total_effective_call = $data_total_effective_call[0]['total_effective_call'];
			
			$data_total_effective_call_monthly = $this->db->query("SELECT COUNT(customer_code) as total_effective_call_monthly FROM visit JOIN motorist on motorist.id_motorist = visit.id_motorist JOIN distributor on motorist.distributor_code = distributor.distributor_code  WHERE distributor.regional = '".$data['regional_name']."' AND status_order = 'order' AND  status_visit = 'call' AND time_stamp_visit between '".$tanggal_bulan_awal."' AND '".$tanggal_bulan_akhir."' AND motorist.motorist_type = '".$data_motorist_type."' ")->result_array();		
			$total_effective_call_monthly = $data_total_effective_call_monthly[0]['total_effective_call_monthly'];
			
			
			$data_total_target_sales = $this->db->query("SELECT SUM(target_harian) as target_harian FROM motorist JOIN distributor on motorist.distributor_code = distributor.distributor_code  WHERE distributor.regional = '".$data['regional_name']."' AND motorist.motorist_type = '".$data_motorist_type."' ")->result_array();		
			$total_daily_target_sales = $data_total_target_sales[0]['target_harian'];
			
			
			
			if($total_daily_target_sales<=0)
			{
				$total_daily_target_sales = "0";
			}
			
			$data_total_actual_daily_sales = $this->db->query("SELECT SUM(total_order) as total_actual_daily_sales FROM orders JOIN motorist on motorist.id_motorist = orders.id_motorist JOIN distributor on motorist.distributor_code = distributor.distributor_code WHERE  date LIKE '%".$date_yesterday."%' AND distributor.regional = '".$data['regional_name']."' AND motorist.motorist_type = '".$data_motorist_type."' ")->result_array();		
			$total_actual_daily_sales = $data_total_actual_daily_sales[0]['total_actual_daily_sales'];
			
			
			$data_total_actual_daily_sales_monthly = $this->db->query("SELECT SUM(total_order) as total_actual_daily_sales_monthly FROM orders JOIN motorist on motorist.id_motorist = orders.id_motorist JOIN distributor on motorist.distributor_code = distributor.distributor_code WHERE date between '".$tanggal_bulan_awal."' AND '".$tanggal_bulan_akhir."'  AND distributor.regional = '".$data['regional_name']."' AND motorist.motorist_type = '".$data_motorist_type."' ")->result_array();		
			$total_actual_daily_sales_monthly = $data_total_actual_daily_sales_monthly[0]['total_actual_daily_sales_monthly'];
			
			$total_daily_target_sales_monthly = $total_daily_target_sales * $hari_kerja; 

			if($total_actual_daily_sales<=0)
			{
				$total_actual_daily_sales = "0";
			}
			
			if($target_call>0)
			{
			$persentasi_call = ($total_call * 100) / $target_call;
			$persentasi_call = number_format($persentasi_call, 0, '.', '');	
			}
			else{
				$persentasi_call = "0";
			}
			
			
			if($total_keseluruhan>0)
			{
			$persentasi_call_monthly = ($total_call_monthly * 100) / $total_keseluruhan;
			$persentasi_call_monthly = number_format($persentasi_call_monthly, 0, '.', '');	
			}
			else
			{
				$persentasi_call_monthly = "0";
			}
			
			if($target_call >0)
			{
			$persentasi_effective_call = ($total_effective_call  * 100) / $target_call;
			$persentasi_effective_call = number_format($persentasi_effective_call, 0, '.', '');
			}
			else{
				$persentasi_effective_call  = "0";
			}
			
			if($total_keseluruhan >0)
			{
			$persentasi_effective_call_monthly = ($total_effective_call_monthly  * 100) / $total_keseluruhan;
			$persentasi_effective_call_monthly = number_format($persentasi_effective_call_monthly, 0, '.', '');
			}
			else{
				$persentasi_effective_call_monthly  = "0";
			}
			
			if($total_actual_daily_sales>0)
			{
			$persentasi_target_harian = ($total_actual_daily_sales * 100) / $total_daily_target_sales;
			$persentasi_target_harian = number_format($persentasi_target_harian, 0, '.', '');
			}

			else
			{
				$persentasi_target_harian = "0";
			}
			
			
			if($total_actual_daily_sales_monthly>0)
			{
			$persentasi_target_bulanan = ($total_actual_daily_sales_monthly * 100) / $total_daily_target_sales_monthly;
			$persentasi_target_bulanan = number_format($persentasi_target_bulanan, 0, '.', '');
			}
			else
			{
				$persentasi_target_bulanan = "0";
			}
			
			if($total_actual_daily_sales_monthly<=0)
			{
				$total_actual_daily_sales_monthly=0;
			}
							
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $row, $target_call);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $row, $total_call);
			
			
			if($persentasi_call>=95)
			{
				$objPHPExcel->getActiveSheet()->getStyle("D".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('D'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => '099f3e')
						)
					 ) 
					 );
					 
				}
			else if($persentasi_call<90)
			{
				$objPHPExcel->getActiveSheet()->getStyle("D".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('D'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => 'fa364d')
						)
					 ) 
					 );
					 
			}
			
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $row, $persentasi_call." %");
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $row, $total_effective_call);
			
			if($persentasi_effective_call>95)
			{
				$objPHPExcel->getActiveSheet()->getStyle("F".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('F'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => '099f3e')
						)
					 ) 
					 );
					 
				}
			else if($persentasi_effective_call<90)
			{
				$objPHPExcel->getActiveSheet()->getStyle("F".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('F'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => 'fa364d')
						)
					 ) 
					 );
					 
			}
			
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, $row, $persentasi_effective_call." %");
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, $row, "Rp. ".number_format($total_daily_target_sales, 0 , '' , '.' ) );
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, $row, "Rp. ".number_format($total_actual_daily_sales, 0 , '' , '.' ));
			if($persentasi_target_harian>100)
			{
				$objPHPExcel->getActiveSheet()->getStyle("I".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('I'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => '099f3e')
						)
					 ) 
					 );
					 
				}
			else if($persentasi_target_harian<100)
			{
				$objPHPExcel->getActiveSheet()->getStyle("I".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('I'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => 'fa364d')
						)
					 ) 
					 );
					 
			}
			
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8, $row, $persentasi_target_harian." %");
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9, $row, $total_keseluruhan);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(10, $row, $total_call_monthly);
			if($persentasi_call_monthly>95)
			{
				$objPHPExcel->getActiveSheet()->getStyle("L".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('L'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => '099f3e')
						)
					 ) 
					 );
					 
				}
			else if($persentasi_call_monthly<90)
			{
				$objPHPExcel->getActiveSheet()->getStyle("L".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('L'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => 'fa364d')
						)
					 ) 
					 );
					 
			}
			
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(11, $row, $persentasi_call_monthly." %");
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(12, $row, $total_effective_call_monthly);
			if($persentasi_effective_call_monthly>95)
			{
				$objPHPExcel->getActiveSheet()->getStyle("N".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('N'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => '099f3e')
						)
					 ) 
					 );
					 
				}
			else if($persentasi_effective_call_monthly<90)
			{
				$objPHPExcel->getActiveSheet()->getStyle("N".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('N'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => 'fa364d')
						)
					 ) 
					 );
					 
			}
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(13, $row, $persentasi_effective_call_monthly." %");
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(14, $row, "Rp. ".number_format($total_daily_target_sales_monthly, 0 , '' , '.' ));
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(15, $row, "Rp. ".number_format($total_actual_daily_sales_monthly, 0 , '' , '.' ));
			
			if($persentasi_effective_call_monthly>$timerate)
			{
				$objPHPExcel->getActiveSheet()->getStyle("Q".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('Q'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => '099f3e')
						)
					 ) 
					 );
					 
				}
			else if($persentasi_effective_call_monthly<$timerate)
			{
				$objPHPExcel->getActiveSheet()->getStyle("Q".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('Q'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => 'fa364d')
						)
					 ) 
					 );
					 
			}
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(16, $row, $persentasi_target_bulanan." %");
			//Monthly
			
			$data_total_outlet_register = $this->db->query("SELECT COUNT(customer_code) as total_outlet_register FROM store WHERE regional = '".$data['regional_name']."' AND store.motorist_type = '".$data_motorist_type."'  ")->result_array();		
			$total_outlet_register = $data_total_outlet_register[0]['total_outlet_register'];
			
			//Monthly
			$total_outlet_active = $this->db->query("SELECT id_order FROM orders JOIN motorist on motorist.id_motorist = orders.id_motorist JOIN distributor on motorist.distributor_code = distributor.distributor_code WHERE distributor.regional = '".$data['regional_name']."' AND  date between '2016-".$bulan."-01 00:00:00' AND '2016-".$bulan."-31 23:59:59' AND motorist.motorist_type = '".$data_motorist_type."' group by customer_code")->num_rows();		
			
			
			$data_outlet_switching = $this->db->query("SELECT COUNT(id_noo) as total_outlet_switching FROM noo JOIN distributor on noo.distributor_code = distributor.distributor_code JOIN motorist on noo.motorist_code = motorist.motorist_code AND noo.distributor_code = motorist.distributor_code  WHERE distributor.regional = '".$data['regional_name']."' AND customer_create_date between '".$year."-".$bulan."-01 00:00:00'  AND '".$year."-".$bulan."-31 00:00:00' AND product = 'Bukan_Carnation' AND motorist.motorist_code = '2' ")->result_array();		
			$total_outlet_switching = $data_outlet_switching[0]['total_outlet_switching'];
			
			$total_motorist = $this->db->query("SELECT * FROM motorist join distributor on distributor.distributor_code = motorist.distributor_code WHERE distributor.regional = '".$data['regional_name']."' AND motorist.motorist_type = '".$data_motorist_type."'  ")->num_rows();
			$total_motorist = $total_motorist * 10;
			
			if($total_outlet_switching<=0)
			{$total_outlet_switching = '0'; }
			
			
			if($total_motorist>0)
			{
			$persentasi_outlet_switching = ($total_outlet_switching * 100) / $total_motorist;
			$persentasi_outlet_switching = number_format($persentasi_outlet_switching, 0, '.', '');
			}
			else
			{
				$persentasi_outlet_switching = "0";
			}
			
			
			if($total_outlet_register>0)
			{
			$persentasi_outlet_active = ($total_outlet_active * 100) / $total_outlet_register;
			$persentasi_outlet_active = number_format($persentasi_outlet_active, 0, '.', '');
			}
			else
			{
				$persentasi_outlet_active = "0";
			}
			
			
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(17, $row, $total_outlet_register);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(18, $row, $total_outlet_active);
			
			if($persentasi_outlet_active>$timerate)
			{
				$objPHPExcel->getActiveSheet()->getStyle("T".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('T'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => '099f3e')
						)
					 ) 
					 );
					 
				}
			else if($persentasi_outlet_active<$timerate)
			{
				$objPHPExcel->getActiveSheet()->getStyle("T".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('T'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => 'fa364d')
						)
					 ) 
					 );
					 
			}
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(19, $row, $persentasi_outlet_active." %");
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(20, $row, $total_motorist);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(21, $row, $total_outlet_switching);
			
			if($persentasi_outlet_switching>$timerate)
			{
				$objPHPExcel->getActiveSheet()->getStyle("W".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('W'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => '099f3e')
						)
					 ) 
					 );
					 
				}
			else if($persentasi_outlet_switching<$timerate)
			{
				$objPHPExcel->getActiveSheet()->getStyle("W".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('W'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => 'fa364d')
						)
					 ) 
					 );
					 
			}
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(22, $row, $persentasi_outlet_switching." %");
            $row++;
			// END Regional
			
			// AREA
			$data_area = $this->db->query("SELECT * FROM master_area WHERE regional = '".$data['regional_name']."' ");
			foreach($data_area->result_array() as $data_regional)
			{
				
				
					$objPHPExcel->getActiveSheet()->getStyle('A'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => 'f2e666')
						)
					 ) 
			);
			
						//AREA
					
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $row, $data_regional['area']);			
					
					$data_target_call = $this->db->query("SELECT COUNT(customer_code) as target_call FROM store WHERE day_visit = '".$day."' AND area = '".$data_regional['area']."' AND motorist_type = '".$data_motorist_type."' ")->result_array();		
					$target_call = $data_target_call[0]['target_call'];
					
									$total_store_keseluruhan = 0;
									
									$store_senin = $this->db->query("SELECT id_store FROM store WHERE area = '".$data_regional['area']."' AND day_visit = 'monday' AND motorist_type = '".$data_motorist_type."' ")->num_rows();
									//echo "store_senin".$store_senin."<br>";
									$total_store_senin = $total_senin * $store_senin;
									$store_selasa = $this->db->query("SELECT id_store FROM store WHERE area = '".$data_regional['area']."' AND day_visit = 'tuesday' AND motorist_type = '".$data_motorist_type."' ")->num_rows();
									//echo "store_selasa".$store_selasa."<br>";
									$total_store_selasa = $total_selasa * $store_selasa;
									$store_rabu = $this->db->query("SELECT id_store FROM store WHERE area = '".$data_regional['area']."' AND day_visit = 'wednesday' AND motorist_type = '".$data_motorist_type."' ")->num_rows();
									$total_store_rabu = $total_rabu * $store_rabu;
									//echo "store_rabu".$store_rabu."<br>";
									$store_kamis = $this->db->query("SELECT id_store FROM store WHERE area = '".$data_regional['area']."' AND day_visit = 'thursday' AND motorist_type = '".$data_motorist_type."' ")->num_rows();
									$total_store_kamis = $total_kamis * $store_kamis;
									//echo "store_kamis".$store_kamis."<br>";
									$store_jumat = $this->db->query("SELECT id_store FROM store WHERE area = '".$data_regional['area']."' AND day_visit = 'friday' AND motorist_type = '".$data_motorist_type."' ")->num_rows();
									$total_store_jumat = $total_jumat * $store_jumat;
									//echo "store_jumat".$store_jumat."<br>";
									$store_sabtu = $this->db->query("SELECT id_store FROM store WHERE area = '".$data_regional['area']."' AND day_visit = 'saturday' AND motorist_type = '".$data_motorist_type."' ")->num_rows();
									$total_store_sabtu = $total_sabtu * $store_sabtu;
									//echo "store_sabtu".$store_sabtu."<br>";
									$total_keseluruhan = $total_store_senin+$total_store_selasa+$total_store_rabu+$total_store_kamis+$total_store_jumat+$total_store_sabtu;

					$data_total_call = $this->db->query("SELECT COUNT(customer_code) as total_call FROM visit JOIN motorist on motorist.id_motorist = visit.id_motorist JOIN distributor on motorist.distributor_code = distributor.distributor_code  WHERE distributor.area = '".$data_regional['area']."' AND  status_visit = 'call' AND time_stamp_visit LIKE '%".$date_yesterday."%' AND motorist.motorist_type = '".$data_motorist_type."' ")->result_array();		
					$total_call = $data_total_call[0]['total_call'];
					
					$data_total_call_monthly = $this->db->query("SELECT COUNT(customer_code) as total_call_monthly FROM visit JOIN motorist on motorist.id_motorist = visit.id_motorist JOIN distributor on motorist.distributor_code = distributor.distributor_code WHERE distributor.area = '".$data_regional['area']."' AND status_visit = 'call' AND time_stamp_visit between '".$tanggal_bulan_awal."' AND '".$tanggal_bulan_akhir."' AND motorist.motorist_type = '".$data_motorist_type."' ")->result_array();		
					$total_call_monthly = $data_total_call_monthly[0]['total_call_monthly'];
					
					$data_total_effective_call = $this->db->query("SELECT COUNT(customer_code) as total_effective_call FROM visit JOIN motorist on motorist.id_motorist = visit.id_motorist JOIN distributor on motorist.distributor_code = distributor.distributor_code  WHERE distributor.area = '".$data_regional['area']."' AND status_order = 'order' AND  status_visit = 'call' AND time_stamp_visit LIKE '%".$date_yesterday."%' AND motorist.motorist_type = '".$data_motorist_type."' ")->result_array();		
					$total_effective_call = $data_total_effective_call[0]['total_effective_call'];
					
					$data_total_effective_call_monthly = $this->db->query("SELECT COUNT(customer_code) as total_effective_call_monthly FROM visit JOIN motorist on motorist.id_motorist = visit.id_motorist JOIN distributor on motorist.distributor_code = distributor.distributor_code  WHERE distributor.area = '".$data_regional['area']."' AND status_order = 'order' AND  status_visit = 'call' AND time_stamp_visit between '".$tanggal_bulan_awal."' AND '".$tanggal_bulan_akhir."' AND motorist.motorist_type = '".$data_motorist_type."' ")->result_array();		
					$total_effective_call_monthly = $data_total_effective_call_monthly[0]['total_effective_call_monthly'];
					
					
					$data_total_target_sales = $this->db->query("SELECT SUM(target_harian) as target_harian FROM motorist JOIN distributor on motorist.distributor_code = distributor.distributor_code  WHERE distributor.area = '".$data_regional['area']."' AND motorist.motorist_type = '".$data_motorist_type."' ")->result_array();		
					$total_daily_target_sales = $data_total_target_sales[0]['target_harian'];
					
					
					
					if($total_daily_target_sales<=0)
					{
						$total_daily_target_sales = "0";
					}
					
					$data_total_actual_daily_sales = $this->db->query("SELECT SUM(total_order) as total_actual_daily_sales FROM orders JOIN motorist on motorist.id_motorist = orders.id_motorist JOIN distributor on motorist.distributor_code = distributor.distributor_code WHERE  date LIKE '%".$date_yesterday."%' AND distributor.area = '".$data_regional['area']."' AND motorist.motorist_type = '".$data_motorist_type."' ")->result_array();		
					$total_actual_daily_sales = $data_total_actual_daily_sales[0]['total_actual_daily_sales'];
					
					
					$data_total_actual_daily_sales_monthly = $this->db->query("SELECT SUM(total_order) as total_actual_daily_sales_monthly FROM orders JOIN motorist on motorist.id_motorist = orders.id_motorist JOIN distributor on motorist.distributor_code = distributor.distributor_code WHERE date between '".$tanggal_bulan_awal."' AND '".$tanggal_bulan_akhir."'  AND distributor.area = '".$data_regional['area']."' AND motorist.motorist_type = '".$data_motorist_type."' ")->result_array();		
					$total_actual_daily_sales_monthly = $data_total_actual_daily_sales_monthly[0]['total_actual_daily_sales_monthly'];
					
					$total_daily_target_sales_monthly = $total_daily_target_sales * $hari_kerja; 

					if($total_actual_daily_sales<=0)
					{
						$total_actual_daily_sales = "0";
					}
					
					if($target_call>0)
					{
					$persentasi_call = ($total_call * 100) / $target_call;
					$persentasi_call = number_format($persentasi_call, 0, '.', '');	
					}
					else{
						$persentasi_call = "0";
					}
					
					
					if($total_keseluruhan>0)
					{
					$persentasi_call_monthly = ($total_call_monthly * 100) / $total_keseluruhan;
					$persentasi_call_monthly = number_format($persentasi_call_monthly, 0, '.', '');	
					}
					else
					{
						$persentasi_call_monthly = "0";
					}
					
					if($target_call >0)
					{
					$persentasi_effective_call = ($total_effective_call  * 100) / $target_call;
					$persentasi_effective_call = number_format($persentasi_effective_call, 0, '.', '');
					}
					else{
						$persentasi_effective_call  = "0";
					}
					
					if($total_keseluruhan >0)
					{
					$persentasi_effective_call_monthly = ($total_effective_call_monthly  * 100) / $total_keseluruhan;
					$persentasi_effective_call_monthly = number_format($persentasi_effective_call_monthly, 0, '.', '');
					}
					else{
						$persentasi_effective_call_monthly  = "0";
					}
					
					if($total_daily_target_sales>0)
					{
					$persentasi_target_harian = ($total_actual_daily_sales * 100) / $total_daily_target_sales;
					$persentasi_target_harian = number_format($persentasi_target_harian, 0, '.', '');
					}
					else
					{
						$persentasi_target_harian = "0";
					}
					
					
					if($total_daily_target_sales_monthly>0)
					{
					$persentasi_target_bulanan = ($total_actual_daily_sales_monthly * 100) / $total_daily_target_sales_monthly;
					$persentasi_target_bulanan = number_format($persentasi_target_bulanan, 0, '.', '');
					}
					else
					{
						$persentasi_target_bulanan = "0";
					}
					
					if($total_actual_daily_sales_monthly<=0)
					{
						$total_actual_daily_sales_monthly=0;
					}
									
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $row, $target_call);
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $row, $total_call);
					
					if($persentasi_call>95)
			{
				$objPHPExcel->getActiveSheet()->getStyle("D".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('D'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => '099f3e')
						)
					 ) 
					 );
					 
				}
			else if($persentasi_call<90)
			{
				$objPHPExcel->getActiveSheet()->getStyle("D".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('D'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => 'fa364d')
						)
					 ) 
					 );
					 
			}
			
			
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $row, $persentasi_call." %");
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $row, $total_effective_call);
					
					if($persentasi_effective_call>95)
			{
				$objPHPExcel->getActiveSheet()->getStyle("F".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('F'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => '099f3e')
						)
					 ) 
					 );
					 
				}
			else if($persentasi_effective_call<90)
			{
				$objPHPExcel->getActiveSheet()->getStyle("F".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('F'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => 'fa364d')
						)
					 ) 
					 );
					 
			}
			
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, $row, $persentasi_effective_call." %");
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, $row, "Rp. ".number_format($total_daily_target_sales, 0 , '' , '.' ));
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, $row, "Rp. ".number_format($total_actual_daily_sales, 0 , '' , '.' ));
					
					if($persentasi_target_harian>100)
			{
				$objPHPExcel->getActiveSheet()->getStyle("I".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('I'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => '099f3e')
						)
					 ) 
					 );
					 
				}
			else if($persentasi_target_harian<100)
			{
				$objPHPExcel->getActiveSheet()->getStyle("I".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('I'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => 'fa364d')
						)
					 ) 
					 );
					 
			}
			
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8, $row, $persentasi_target_harian." %");
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9, $row, $total_keseluruhan);
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(10, $row, $total_call_monthly);
					if($persentasi_call_monthly>95)
			{
				$objPHPExcel->getActiveSheet()->getStyle("L".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('L'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => '099f3e')
						)
					 ) 
					 );
					 
				}
			else if($persentasi_call_monthly<90)
			{
				$objPHPExcel->getActiveSheet()->getStyle("L".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('L'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => 'fa364d')
						)
					 ) 
					 );
					 
			}
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(11, $row, $persentasi_call_monthly." %");
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(12, $row, $total_effective_call_monthly);
					
					if($persentasi_effective_call_monthly>95)
			{
				$objPHPExcel->getActiveSheet()->getStyle("N".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('N'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => '099f3e')
						)
					 ) 
					 );
					 
				}
			else if($persentasi_effective_call_monthly<90)
			{
				$objPHPExcel->getActiveSheet()->getStyle("N".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('N'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => 'fa364d')
						)
					 ) 
					 );
					 
			}
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(13, $row, $persentasi_effective_call_monthly." %");
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(14, $row, "Rp. ".number_format($total_daily_target_sales_monthly, 0 , '' , '.' ));
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(15, $row, "Rp. ".number_format($total_actual_daily_sales_monthly, 0 , '' , '.' ));
					
					if($persentasi_effective_call_monthly>$timerate)
			{
				$objPHPExcel->getActiveSheet()->getStyle("Q".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('Q'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => '099f3e')
						)
					 ) 
					 );
					 
				}
			else if($persentasi_effective_call_monthly<$timerate)
			{
				$objPHPExcel->getActiveSheet()->getStyle("Q".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('Q'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => 'fa364d')
						)
					 ) 
					 );
					 
			}
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(16, $row, $persentasi_target_bulanan." %");
					//Monthly
					$data_total_outlet_register = $this->db->query("SELECT COUNT(customer_code) as total_outlet_register FROM store WHERE area = '".$data_regional['area']."' AND store.motorist_type = '".$data_motorist_type."'  ")->result_array();		
					$total_outlet_register = $data_total_outlet_register[0]['total_outlet_register'];
					
					//Monthly
					$total_outlet_active = $this->db->query("SELECT id_order FROM orders JOIN motorist on motorist.id_motorist = orders.id_motorist JOIN distributor on motorist.distributor_code = distributor.distributor_code WHERE distributor.area = '".$data_regional['area']."' AND  date between '2016-".$bulan."-01 00:00:00' AND '2016-".$bulan."-31 23:59:59' AND motorist.motorist_type = '".$data_motorist_type."' group by customer_code")->num_rows();		
					
					
					$data_outlet_switching = $this->db->query("SELECT COUNT(id_noo) as total_outlet_switching FROM noo JOIN distributor on noo.distributor_code = distributor.distributor_code JOIN motorist on noo.motorist_code = motorist.motorist_code AND noo.distributor_code = motorist.distributor_code  WHERE distributor.area = '".$data_regional['area']."' AND customer_create_date between '".$year."-".$bulan."-01 00:00:00'  AND '".$year."-".$bulan."-31 00:00:00' AND product = 'Bukan_Carnation' AND motorist.motorist_code = '2' ")->result_array();		
					$total_outlet_switching = $data_outlet_switching[0]['total_outlet_switching'];
					
					$total_motorist = $this->db->query("SELECT * FROM motorist join distributor on distributor.distributor_code = motorist.distributor_code WHERE distributor.area = '".$data_regional['area']."' AND motorist.motorist_type = '".$data_motorist_type."'  ")->num_rows();
					$total_motorist = $total_motorist * 10;
					
					if($total_outlet_switching<=0)
					{$total_outlet_switching = '0'; }
					
					
					if($total_motorist>0)
					{
					$persentasi_outlet_switching = ($total_outlet_switching * 100) / $total_motorist;
					$persentasi_outlet_switching = number_format($persentasi_outlet_switching, 0, '.', '');
					}
					else
					{
						$persentasi_outlet_switching = "0";
					}
					
					
					if($total_outlet_register>0)
					{
					$persentasi_outlet_active = ($total_outlet_active * 100) / $total_outlet_register;
					$persentasi_outlet_active = number_format($persentasi_outlet_active, 0, '.', '');
					}
					else
					{
						$persentasi_outlet_active = "0";
					}
					
					
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(17, $row, $total_outlet_register);
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(18, $row, $total_outlet_active);
					
					if($persentasi_outlet_active>$timerate)
			{
				$objPHPExcel->getActiveSheet()->getStyle("T".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('T'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => '099f3e')
						)
					 ) 
					 );
					 
				}
			else if($persentasi_outlet_active<$timerate)
			{
				$objPHPExcel->getActiveSheet()->getStyle("T".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('T'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => 'fa364d')
						)
					 ) 
					 );
					 
			}
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(19, $row, $persentasi_outlet_active." %");
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(20, $row, $total_motorist);
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(21, $row, $total_outlet_switching);
					
					if($persentasi_outlet_switching>$timerate)
			{
				$objPHPExcel->getActiveSheet()->getStyle("W".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('W'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => '099f3e')
						)
					 ) 
					 );
					 
				}
			else if($persentasi_outlet_switching<$timerate)
			{
				$objPHPExcel->getActiveSheet()->getStyle("W".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('W'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => 'fa364d')
						)
					 ) 
					 );
					 
			}
			
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(22, $row, $persentasi_outlet_switching." %");
					$row++;
				
				
				
				
			// Distributor
			$data_distributor_level = $this->db->query("SELECT * FROM distributor WHERE area = '".$data_regional['area']."' ");
			foreach($data_distributor_level->result_array() as $data_level_distributor)
			{
				
				$objPHPExcel->getActiveSheet()->getStyle('A'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => 'f2c566')
						)
					 ) 
			);
			
				
						//Distributor
					
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $row, $data_level_distributor['distributor_name']);			
					
					$data_target_call = $this->db->query("SELECT COUNT(customer_code) as target_call FROM store WHERE day_visit = '".$day."' AND distributor_code = '".$data_level_distributor['distributor_code']."' AND motorist_type = '".$data_motorist_type."' ")->result_array();		
					$target_call = $data_target_call[0]['target_call'];
					
									$total_store_keseluruhan = 0;
									
									$store_senin = $this->db->query("SELECT id_store FROM store WHERE distributor_code = '".$data_level_distributor['distributor_code']."' AND day_visit = 'monday' AND motorist_type = '".$data_motorist_type."' ")->num_rows();
									//echo "store_senin".$store_senin."<br>";
									$total_store_senin = $total_senin * $store_senin;
									$store_selasa = $this->db->query("SELECT id_store FROM store WHERE distributor_code = '".$data_level_distributor['distributor_code']."' AND day_visit = 'tuesday' AND motorist_type = '".$data_motorist_type."' ")->num_rows();
									//echo "store_selasa".$store_selasa."<br>";
									$total_store_selasa = $total_selasa * $store_selasa;
									$store_rabu = $this->db->query("SELECT id_store FROM store WHERE distributor_code = '".$data_level_distributor['distributor_code']."' AND day_visit = 'wednesday' AND motorist_type = '".$data_motorist_type."' ")->num_rows();
									$total_store_rabu = $total_rabu * $store_rabu;
									//echo "store_rabu".$store_rabu."<br>";
									$store_kamis = $this->db->query("SELECT id_store FROM store WHERE distributor_code = '".$data_level_distributor['distributor_code']."' AND day_visit = 'thursday' AND motorist_type = '".$data_motorist_type."' ")->num_rows();
									$total_store_kamis = $total_kamis * $store_kamis;
									//echo "store_kamis".$store_kamis."<br>";
									$store_jumat = $this->db->query("SELECT id_store FROM store WHERE distributor_code = '".$data_level_distributor['distributor_code']."' AND day_visit = 'friday' AND motorist_type = '".$data_motorist_type."' ")->num_rows();
									$total_store_jumat = $total_jumat * $store_jumat;
									//echo "store_jumat".$store_jumat."<br>";
									$store_sabtu = $this->db->query("SELECT id_store FROM store WHERE distributor_code = '".$data_level_distributor['distributor_code']."' AND day_visit = 'saturday' AND motorist_type = '".$data_motorist_type."' ")->num_rows();
									$total_store_sabtu = $total_sabtu * $store_sabtu;
									//echo "store_sabtu".$store_sabtu."<br>";
									$total_keseluruhan = $total_store_senin+$total_store_selasa+$total_store_rabu+$total_store_kamis+$total_store_jumat+$total_store_sabtu;

					$data_total_call = $this->db->query("SELECT COUNT(customer_code) as total_call FROM visit JOIN motorist on motorist.id_motorist = visit.id_motorist JOIN distributor on motorist.distributor_code = distributor.distributor_code  WHERE distributor.distributor_code = '".$data_level_distributor['distributor_code']."' AND  status_visit = 'call' AND time_stamp_visit LIKE '%".$date_yesterday."%' AND motorist.motorist_type = '".$data_motorist_type."' ")->result_array();		
					$total_call = $data_total_call[0]['total_call'];
					
					$data_total_call_monthly = $this->db->query("SELECT COUNT(customer_code) as total_call_monthly FROM visit JOIN motorist on motorist.id_motorist = visit.id_motorist JOIN distributor on motorist.distributor_code = distributor.distributor_code WHERE distributor.distributor_code = '".$data_level_distributor['distributor_code']."' AND status_visit = 'call' AND time_stamp_visit between '".$tanggal_bulan_awal."' AND '".$tanggal_bulan_akhir."' AND motorist.motorist_type = '".$data_motorist_type."' ")->result_array();		
					$total_call_monthly = $data_total_call_monthly[0]['total_call_monthly'];
					
					$data_total_effective_call = $this->db->query("SELECT COUNT(customer_code) as total_effective_call FROM visit JOIN motorist on motorist.id_motorist = visit.id_motorist JOIN distributor on motorist.distributor_code = distributor.distributor_code  WHERE distributor.distributor_code = '".$data_level_distributor['distributor_code']."' AND status_order = 'order' AND  status_visit = 'call' AND time_stamp_visit LIKE '%".$date_yesterday."%' AND motorist.motorist_type = '".$data_motorist_type."' ")->result_array();		
					$total_effective_call = $data_total_effective_call[0]['total_effective_call'];
					
					$data_total_effective_call_monthly = $this->db->query("SELECT COUNT(customer_code) as total_effective_call_monthly FROM visit JOIN motorist on motorist.id_motorist = visit.id_motorist JOIN distributor on motorist.distributor_code = distributor.distributor_code  WHERE distributor.distributor_code = '".$data_level_distributor['distributor_code']."' AND status_order = 'order' AND  status_visit = 'call' AND time_stamp_visit between '".$tanggal_bulan_awal."' AND '".$tanggal_bulan_akhir."' AND motorist.motorist_type = '".$data_motorist_type."' ")->result_array();		
					$total_effective_call_monthly = $data_total_effective_call_monthly[0]['total_effective_call_monthly'];
					
					
					$data_total_target_sales = $this->db->query("SELECT SUM(target_harian) as target_harian FROM motorist JOIN distributor on motorist.distributor_code = distributor.distributor_code  WHERE distributor.distributor_code = '".$data_level_distributor['distributor_code']."' AND motorist.motorist_type = '".$data_motorist_type."' ")->result_array();		
					$total_daily_target_sales = $data_total_target_sales[0]['target_harian'];
					
					
					
					if($total_daily_target_sales<=0)
					{
						$total_daily_target_sales = "0";
					}
					
					$data_total_actual_daily_sales = $this->db->query("SELECT SUM(total_order) as total_actual_daily_sales FROM orders JOIN motorist on motorist.id_motorist = orders.id_motorist JOIN distributor on motorist.distributor_code = distributor.distributor_code WHERE  date LIKE '%".$date_yesterday."%' AND distributor.distributor_code = '".$data_level_distributor['distributor_code']."' AND motorist.motorist_type = '".$data_motorist_type."' ")->result_array();		
					$total_actual_daily_sales = $data_total_actual_daily_sales[0]['total_actual_daily_sales'];
					
					
					$data_total_actual_daily_sales_monthly = $this->db->query("SELECT SUM(total_order) as total_actual_daily_sales_monthly FROM orders JOIN motorist on motorist.id_motorist = orders.id_motorist JOIN distributor on motorist.distributor_code = distributor.distributor_code WHERE date between '".$tanggal_bulan_awal."' AND '".$tanggal_bulan_akhir."'  AND distributor.distributor_code = '".$data_level_distributor['distributor_code']."' AND motorist.motorist_type = '".$data_motorist_type."' ")->result_array();		
					$total_actual_daily_sales_monthly = $data_total_actual_daily_sales_monthly[0]['total_actual_daily_sales_monthly'];
					
					$total_daily_target_sales_monthly = $total_daily_target_sales * $hari_kerja; 

					if($total_actual_daily_sales<=0)
					{
						$total_actual_daily_sales = "0";
					}
					
					if($target_call>0)
					{
					$persentasi_call = ($total_call * 100) / $target_call;
					$persentasi_call = number_format($persentasi_call, 0, '.', '');	
					}
					else{
						$persentasi_call = "0";
					}
					
					
					if($total_keseluruhan>0)
					{
					$persentasi_call_monthly = ($total_call_monthly * 100) / $total_keseluruhan;
					$persentasi_call_monthly = number_format($persentasi_call_monthly, 0, '.', '');	
					}
					else
					{
						$persentasi_call_monthly = "0";
					}
					
					if($target_call >0)
					{
					$persentasi_effective_call = ($total_effective_call  * 100) / $target_call;
					$persentasi_effective_call = number_format($persentasi_effective_call, 0, '.', '');
					}
					else{
						$persentasi_effective_call  = "0";
					}
					
					if($total_keseluruhan >0)
					{
					$persentasi_effective_call_monthly = ($total_effective_call_monthly  * 100) / $total_keseluruhan;
					$persentasi_effective_call_monthly = number_format($persentasi_effective_call_monthly, 0, '.', '');
					}
					else{
						$persentasi_effective_call_monthly  = "0";
					}
					
					if($total_daily_target_sales>0)
					{
					$persentasi_target_harian = ($total_actual_daily_sales * 100) / $total_daily_target_sales;
					$persentasi_target_harian = number_format($persentasi_target_harian, 0, '.', '');
					}
					else
					{
						$persentasi_target_harian = "0";
					}
					
					
					if($total_daily_target_sales_monthly>0)
					{
					$persentasi_target_bulanan = ($total_actual_daily_sales_monthly * 100) / $total_daily_target_sales_monthly;
					$persentasi_target_bulanan = number_format($persentasi_target_bulanan, 0, '.', '');
					}
					else
					{
						$persentasi_target_bulanan = "0";
					}
					
					if($total_actual_daily_sales_monthly<=0)
					{
						$total_actual_daily_sales_monthly=0;
					}
									
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $row, $target_call);
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $row, $total_call);
					
					if($persentasi_call>95)
			{
				$objPHPExcel->getActiveSheet()->getStyle("D".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('D'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => '099f3e')
						)
					 ) 
					 );
					 
				}
			else if($persentasi_call<90)
			{
				$objPHPExcel->getActiveSheet()->getStyle("D".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('D'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => 'fa364d')
						)
					 ) 
					 );
					 
			}
			
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $row, $persentasi_call." %");
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $row, $total_effective_call);
					
					if($persentasi_effective_call>95)
			{
				$objPHPExcel->getActiveSheet()->getStyle("F".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('F'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => '099f3e')
						)
					 ) 
					 );
					 
				}
			else if($persentasi_effective_call<90)
			{
				$objPHPExcel->getActiveSheet()->getStyle("F".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('F'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => 'fa364d')
						)
					 ) 
					 );
					 
			}
			
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, $row, $persentasi_effective_call." %");
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, $row, "Rp. ".number_format($total_daily_target_sales, 0 , '' , '.' ));
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, $row, "Rp. ".number_format($total_actual_daily_sales, 0 , '' , '.' ));
					if($persentasi_target_harian>100)
			{
				$objPHPExcel->getActiveSheet()->getStyle("I".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('I'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => '099f3e')
						)
					 ) 
					 );
					 
				}
			else if($persentasi_target_harian<100)
			{
				$objPHPExcel->getActiveSheet()->getStyle("I".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('I'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => 'fa364d')
						)
					 ) 
					 );
					 
			}
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8, $row, $persentasi_target_harian." %");
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9, $row, $total_keseluruhan);
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(10, $row, $total_call_monthly);
					if($persentasi_call_monthly>95)
			{
				$objPHPExcel->getActiveSheet()->getStyle("L".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('L'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => '099f3e')
						)
					 ) 
					 );
					 
				}
			else if($persentasi_call_monthly<90)
			{
				$objPHPExcel->getActiveSheet()->getStyle("L".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('L'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => 'fa364d')
						)
					 ) 
					 );
					 
			}
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(11, $row, $persentasi_call_monthly." %");
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(12, $row, $total_effective_call_monthly);
					
					if($persentasi_effective_call_monthly>95)
			{
				$objPHPExcel->getActiveSheet()->getStyle("N".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('N'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => '099f3e')
						)
					 ) 
					 );
					 
				}
			else if($persentasi_effective_call_monthly<90)
			{
				$objPHPExcel->getActiveSheet()->getStyle("N".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('N'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => 'fa364d')
						)
					 ) 
					 );
					 
			}
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(13, $row, $persentasi_effective_call_monthly." %");
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(14, $row, "Rp. ".number_format($total_daily_target_sales_monthly, 0 , '' , '.' ));
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(15, $row, "Rp. ".number_format($total_actual_daily_sales_monthly, 0 , '' , '.' ));
					
					if($persentasi_effective_call_monthly>$timerate)
			{
				$objPHPExcel->getActiveSheet()->getStyle("Q".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('Q'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => '099f3e')
						)
					 ) 
					 );
					 
				}
			else if($persentasi_effective_call_monthly<$timerate)
			{
				$objPHPExcel->getActiveSheet()->getStyle("Q".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('Q'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => 'fa364d')
						)
					 ) 
					 );
					 
			}
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(16, $row, $persentasi_target_bulanan." %");
					//Monthly
					$data_total_outlet_register = $this->db->query("SELECT COUNT(customer_code) as total_outlet_register FROM store WHERE distributor_code = '".$data_level_distributor['distributor_code']."' AND store.motorist_type = '".$data_motorist_type."'  ")->result_array();		
					$total_outlet_register = $data_total_outlet_register[0]['total_outlet_register'];
					
					//Monthly
					$total_outlet_active = $this->db->query("SELECT id_order FROM orders JOIN motorist on motorist.id_motorist = orders.id_motorist JOIN distributor on motorist.distributor_code = distributor.distributor_code WHERE distributor.distributor_code = '".$data_level_distributor['distributor_code']."' AND  date between '2016-".$bulan."-01 00:00:00' AND '2016-".$bulan."-31 23:59:59' AND motorist.motorist_type = '".$data_motorist_type."' group by customer_code")->num_rows();		
					
					
					$data_outlet_switching = $this->db->query("SELECT COUNT(id_noo) as total_outlet_switching FROM noo JOIN distributor on noo.distributor_code = distributor.distributor_code JOIN motorist on noo.motorist_code = motorist.motorist_code AND noo.distributor_code = motorist.distributor_code  WHERE distributor.distributor_code = '".$data_level_distributor['distributor_code']."' AND customer_create_date between '".$year."-".$bulan."-01 00:00:00'  AND '".$year."-".$bulan."-31 00:00:00' AND product = 'Bukan_Carnation' AND motorist.motorist_code = '2'  ")->result_array();		
					$total_outlet_switching = $data_outlet_switching[0]['total_outlet_switching'];
					
					$total_motorist = $this->db->query("SELECT * FROM motorist join distributor on distributor.distributor_code = motorist.distributor_code WHERE distributor.distributor_code = '".$data_level_distributor['distributor_code']."' AND motorist.motorist_type = '".$data_motorist_type."'  ")->num_rows();
					$total_motorist = $total_motorist * 10;
					
					if($total_outlet_switching<=0)
					{$total_outlet_switching = '0'; }
					
					
					if($total_motorist>0)
					{
					$persentasi_outlet_switching = ($total_outlet_switching * 100) / $total_motorist;
					$persentasi_outlet_switching = number_format($persentasi_outlet_switching, 0, '.', '');
					}
					else
					{
						$persentasi_outlet_switching = "0";
					}
					
					
					if($total_outlet_register>0)
					{
					$persentasi_outlet_active = ($total_outlet_active * 100) / $total_outlet_register;
					$persentasi_outlet_active = number_format($persentasi_outlet_active, 0, '.', '');
					}
					else
					{
						$persentasi_outlet_active = "0";
					}
					
					
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(17, $row, $total_outlet_register);
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(18, $row, $total_outlet_active);
					
					if($persentasi_outlet_active>$timerate)
			{
				$objPHPExcel->getActiveSheet()->getStyle("T".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('T'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => '099f3e')
						)
					 ) 
					 );
					 
				}
			else if($persentasi_outlet_active<$timerate)
			{
				$objPHPExcel->getActiveSheet()->getStyle("T".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('T'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => 'fa364d')
						)
					 ) 
					 );
					 
			}
			
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(19, $row, $persentasi_outlet_active." %");
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(20, $row, $total_motorist);
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(21, $row, $total_outlet_switching);
					
					if($persentasi_outlet_switching>$timerate)
			{
				$objPHPExcel->getActiveSheet()->getStyle("W".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('W'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => '099f3e')
						)
					 ) 
					 );
					 
				}
			else if($persentasi_outlet_switching<$timerate)
			{
				$objPHPExcel->getActiveSheet()->getStyle("W".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('W'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => 'fa364d')
						)
					 ) 
					 );
					 
			}
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(22, $row, $persentasi_outlet_switching." %");
					$row++;
					
					
					
					
					// Motorist
			$data_motorist_level = $this->db->query("SELECT * FROM motorist WHERE distributor_code = '".$data_level_distributor['distributor_code']."' AND motorist_type = '".$data_motorist_type."' ");
			foreach($data_motorist_level->result_array() as $data_level_motorist)
			{
				
					$objPHPExcel->getActiveSheet()->getStyle('A'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => 'a0fff9')
						)
					 ) 
			);
			
				
						//Distributor
					
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $row, $data_level_motorist['motorist_name'].'-'.$data_level_motorist['motorist_code']);			
					
					$data_target_call = $this->db->query("SELECT COUNT(customer_code) as target_call FROM store WHERE day_visit = '".$day."' AND distributor_code = '".$data_level_motorist['distributor_code']."' AND motorist_code = '".$data_level_motorist['motorist_code']."' ")->result_array();		
					$target_call = $data_target_call[0]['target_call'];
					
									$total_store_keseluruhan = 0;
									
									$store_senin = $this->db->query("SELECT id_store FROM store WHERE distributor_code = '".$data_level_motorist['distributor_code']."' AND motorist_code = '".$data_level_motorist['motorist_code']."' AND day_visit = 'monday' ")->num_rows();
									//echo "store_senin".$store_senin."<br>";
									$total_store_senin = $total_senin * $store_senin;
									$store_selasa = $this->db->query("SELECT id_store FROM store WHERE distributor_code = '".$data_level_motorist['distributor_code']."' AND motorist_code = '".$data_level_motorist['motorist_code']."' AND day_visit = 'tuesday' ")->num_rows();
									//echo "store_selasa".$store_selasa."<br>";
									$total_store_selasa = $total_selasa * $store_selasa;
									$store_rabu = $this->db->query("SELECT id_store FROM store WHERE distributor_code = '".$data_level_motorist['distributor_code']."' AND motorist_code = '".$data_level_motorist['motorist_code']."' AND day_visit = 'wednesday' ")->num_rows();
									$total_store_rabu = $total_rabu * $store_rabu;
									//echo "store_rabu".$store_rabu."<br>";
									$store_kamis = $this->db->query("SELECT id_store FROM store WHERE distributor_code = '".$data_level_motorist['distributor_code']."' AND motorist_code = '".$data_level_motorist['motorist_code']."' AND day_visit = 'thursday' ")->num_rows();
									$total_store_kamis = $total_kamis * $store_kamis;
									//echo "store_kamis".$store_kamis."<br>";
									$store_jumat = $this->db->query("SELECT id_store FROM store WHERE distributor_code = '".$data_level_motorist['distributor_code']."' AND motorist_code = '".$data_level_motorist['motorist_code']."' AND day_visit = 'friday' ")->num_rows();
									$total_store_jumat = $total_jumat * $store_jumat;
									//echo "store_jumat".$store_jumat."<br>";
									$store_sabtu = $this->db->query("SELECT id_store FROM store WHERE distributor_code = '".$data_level_motorist['distributor_code']."' AND motorist_code = '".$data_level_motorist['motorist_code']."' AND day_visit = 'saturday' ")->num_rows();
									$total_store_sabtu = $total_sabtu * $store_sabtu;
									//echo "store_sabtu".$store_sabtu."<br>";
									$total_keseluruhan = $total_store_senin+$total_store_selasa+$total_store_rabu+$total_store_kamis+$total_store_jumat+$total_store_sabtu;

					$data_total_call = $this->db->query("SELECT COUNT(customer_code) as total_call FROM visit JOIN motorist on motorist.id_motorist = visit.id_motorist JOIN distributor on motorist.distributor_code = distributor.distributor_code  WHERE distributor.distributor_code = '".$data_level_motorist['distributor_code']."' AND motorist.motorist_code = '".$data_level_motorist['motorist_code']."' AND  status_visit = 'call' AND time_stamp_visit LIKE '%".$date_yesterday."%' ")->result_array();		
					$total_call = $data_total_call[0]['total_call'];
					
					$data_total_call_monthly = $this->db->query("SELECT COUNT(customer_code) as total_call_monthly FROM visit JOIN motorist on motorist.id_motorist = visit.id_motorist JOIN distributor on motorist.distributor_code = distributor.distributor_code WHERE distributor.distributor_code = '".$data_level_motorist['distributor_code']."' AND motorist.motorist_code = '".$data_level_motorist['motorist_code']."' AND status_visit = 'call' AND time_stamp_visit between '".$tanggal_bulan_awal."' AND '".$tanggal_bulan_akhir."'")->result_array();		
					$total_call_monthly = $data_total_call_monthly[0]['total_call_monthly'];
					
					$data_total_effective_call = $this->db->query("SELECT COUNT(customer_code) as total_effective_call FROM visit JOIN motorist on motorist.id_motorist = visit.id_motorist JOIN distributor on motorist.distributor_code = distributor.distributor_code  WHERE distributor.distributor_code = '".$data_level_motorist['distributor_code']."' AND motorist.motorist_code = '".$data_level_motorist['motorist_code']."' AND status_order = 'order' AND  status_visit = 'call' AND time_stamp_visit LIKE '%".$date_yesterday."%' ")->result_array();		
					$total_effective_call = $data_total_effective_call[0]['total_effective_call'];
					
					$data_total_effective_call_monthly = $this->db->query("SELECT COUNT(customer_code) as total_effective_call_monthly FROM visit JOIN motorist on motorist.id_motorist = visit.id_motorist JOIN distributor on motorist.distributor_code = distributor.distributor_code  WHERE distributor.distributor_code = '".$data_level_motorist['distributor_code']."' AND motorist.motorist_code = '".$data_level_motorist['motorist_code']."' AND status_order = 'order' AND  status_visit = 'call' AND time_stamp_visit between '".$tanggal_bulan_awal."' AND '".$tanggal_bulan_akhir."' ")->result_array();		
					$total_effective_call_monthly = $data_total_effective_call_monthly[0]['total_effective_call_monthly'];
					
					
					$data_total_target_sales = $this->db->query("SELECT SUM(target_harian) as target_harian FROM motorist JOIN distributor on motorist.distributor_code = distributor.distributor_code  WHERE distributor.distributor_code = '".$data_level_motorist['distributor_code']."' AND motorist.motorist_code = '".$data_level_motorist['motorist_code']."' ")->result_array();		
					$total_daily_target_sales = $data_total_target_sales[0]['target_harian'];
					
					
					
					if($total_daily_target_sales<=0)
					{
						$total_daily_target_sales = "0";
					}
					
					$data_total_actual_daily_sales = $this->db->query("SELECT SUM(total_order) as total_actual_daily_sales FROM orders JOIN motorist on motorist.id_motorist = orders.id_motorist JOIN distributor on motorist.distributor_code = distributor.distributor_code WHERE  date LIKE '%".$date_yesterday."%' AND distributor.distributor_code = '".$data_level_motorist['distributor_code']."' AND motorist.motorist_code = '".$data_level_motorist['motorist_code']."' ")->result_array();		
					$total_actual_daily_sales = $data_total_actual_daily_sales[0]['total_actual_daily_sales'];
					
					
					$data_total_actual_daily_sales_monthly = $this->db->query("SELECT SUM(total_order) as total_actual_daily_sales_monthly FROM orders JOIN motorist on motorist.id_motorist = orders.id_motorist JOIN distributor on motorist.distributor_code = distributor.distributor_code WHERE date between '".$tanggal_bulan_awal."' AND '".$tanggal_bulan_akhir."'  AND distributor.distributor_code = '".$data_level_motorist['distributor_code']."' AND motorist.motorist_code = '".$data_level_motorist['motorist_code']."' ")->result_array();		
					$total_actual_daily_sales_monthly = $data_total_actual_daily_sales_monthly[0]['total_actual_daily_sales_monthly'];
					
					$total_daily_target_sales_monthly = $total_daily_target_sales * $hari_kerja; 

					if($total_actual_daily_sales<=0)
					{
						$total_actual_daily_sales = "0";
					}
					
					if($target_call>0)
					{
					$persentasi_call = ($total_call * 100) / $target_call;
					$persentasi_call = number_format($persentasi_call, 0, '.', '');	
					}
					else{
						$persentasi_call = "0";
					}
					
					
					if($total_keseluruhan>0)
					{
					$persentasi_call_monthly = ($total_call_monthly * 100) / $total_keseluruhan;
					$persentasi_call_monthly = number_format($persentasi_call_monthly, 0, '.', '');	
					}
					else
					{
						$persentasi_call_monthly = "0";
					}
					
					if($target_call >0)
					{
					$persentasi_effective_call = ($total_effective_call  * 100) / $target_call;
					$persentasi_effective_call = number_format($persentasi_effective_call, 0, '.', '');
					}
					else{
						$persentasi_effective_call  = "0";
					}
					
					if($total_keseluruhan >0)
					{
					$persentasi_effective_call_monthly = ($total_effective_call_monthly  * 100) / $total_keseluruhan;
					$persentasi_effective_call_monthly = number_format($persentasi_effective_call_monthly, 0, '.', '');
					}
					else{
						$persentasi_effective_call_monthly  = "0";
					}
					
					if($total_daily_target_sales>0)
					{
					$persentasi_target_harian = ($total_actual_daily_sales * 100) / $total_daily_target_sales;
					$persentasi_target_harian = number_format($persentasi_target_harian, 0, '.', '');
					}
					else
					{
						$persentasi_target_harian = "0";
					}
					
					
					if($total_daily_target_sales_monthly>0)
					{
					$persentasi_target_bulanan = ($total_actual_daily_sales_monthly * 100) / $total_daily_target_sales_monthly;
					$persentasi_target_bulanan = number_format($persentasi_target_bulanan, 0, '.', '');
					}
					else
					{
						$persentasi_target_bulanan = "0";
					}
					
					if($total_actual_daily_sales_monthly<=0)
					{
						$total_actual_daily_sales_monthly=0;
					}
									
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $row, $target_call);
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $row, $total_call);
					
					if($persentasi_call>95)
			{
				$objPHPExcel->getActiveSheet()->getStyle("D".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('D'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => '099f3e')
						)
					 ) 
					 );
					 
				}
			else if($persentasi_call<90)
			{
				$objPHPExcel->getActiveSheet()->getStyle("D".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('D'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => 'fa364d')
						)
					 ) 
					 );
					 
			}
			
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $row, $persentasi_call." %");
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $row, $total_effective_call);
					
					
					if($persentasi_effective_call>95)
			{
				$objPHPExcel->getActiveSheet()->getStyle("F".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('F'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => '099f3e')
						)
					 ) 
					 );
					 
				}
			else if($persentasi_effective_call<90)
			{
				$objPHPExcel->getActiveSheet()->getStyle("F".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('F'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => 'fa364d')
						)
					 ) 
					 );
					 
			}
			
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, $row, $persentasi_effective_call." %");
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, $row, "Rp. ".number_format($total_daily_target_sales, 0 , '' , '.' ));
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, $row, "Rp. ".number_format($total_actual_daily_sales, 0 , '' , '.' ));
					
					if($persentasi_target_harian>100)
			{
				$objPHPExcel->getActiveSheet()->getStyle("I".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('I'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => '099f3e')
						)
					 ) 
					 );
					 
				}
			else if($persentasi_target_harian<100)
			{
				$objPHPExcel->getActiveSheet()->getStyle("I".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('I'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => 'fa364d')
						)
					 ) 
					 );
					 
			}
			
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8, $row, $persentasi_target_harian." %");
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9, $row, $total_keseluruhan);
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(10, $row, $total_call_monthly);
					if($persentasi_call_monthly>95)
			{
				$objPHPExcel->getActiveSheet()->getStyle("L".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('L'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => '099f3e')
						)
					 ) 
					 );
					 
				}
			else if($persentasi_call_monthly<90)
			{
				$objPHPExcel->getActiveSheet()->getStyle("L".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('L'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => 'fa364d')
						)
					 ) 
					 );
					 
			}
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(11, $row, $persentasi_call_monthly." %");
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(12, $row, $total_effective_call_monthly);
					if($persentasi_effective_call_monthly>95)
			{
				$objPHPExcel->getActiveSheet()->getStyle("N".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('N'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => '099f3e')
						)
					 ) 
					 );
					 
				}
			else if($persentasi_effective_call_monthly<90)
			{
				$objPHPExcel->getActiveSheet()->getStyle("N".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('N'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => 'fa364d')
						)
					 ) 
					 );
					 
			}
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(13, $row, $persentasi_effective_call_monthly." %");
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(14, $row, "Rp. ".number_format($total_daily_target_sales_monthly, 0 , '' , '.' ));
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(15, $row, "Rp. ".number_format($total_actual_daily_sales_monthly, 0 , '' , '.' ));
					
					if($persentasi_effective_call_monthly>$timerate)
			{
				$objPHPExcel->getActiveSheet()->getStyle("Q".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('Q'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => '099f3e')
						)
					 ) 
					 );
					 
				}
			else if($persentasi_effective_call_monthly<$timerate)
			{
				$objPHPExcel->getActiveSheet()->getStyle("Q".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('Q'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => 'fa364d')
						)
					 ) 
					 );
					 
			}
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(16, $row, $persentasi_target_bulanan." %");
					//Monthly
					$data_total_outlet_register = $this->db->query("SELECT COUNT(customer_code) as total_outlet_register FROM store WHERE distributor_code = '".$data_level_motorist['distributor_code']."' AND motorist_code = '".$data_level_motorist['motorist_code']."'  ")->result_array();		
					$total_outlet_register = $data_total_outlet_register[0]['total_outlet_register'];
					
					//Monthly
					$total_outlet_active = $this->db->query("SELECT id_order FROM orders JOIN motorist on motorist.id_motorist = orders.id_motorist JOIN distributor on motorist.distributor_code = distributor.distributor_code WHERE distributor.distributor_code = '".$data_level_motorist['distributor_code']."' AND motorist.motorist_code = '".$data_level_motorist['motorist_code']."' AND  date between '2016-".$bulan."-01 00:00:00' AND '2016-".$bulan."-31 23:59:59' group by customer_code")->num_rows();		
					
					
					$data_outlet_switching = $this->db->query("SELECT COUNT(id_noo) as total_outlet_switching FROM noo JOIN distributor on noo.distributor_code = distributor.distributor_code WHERE distributor.distributor_code = '".$data_level_motorist['distributor_code']."' AND noo.motorist_code = '".$data_level_motorist['motorist_code']."' AND customer_create_date between '".$year."-".$bulan."-01 00:00:00'  AND '".$year."-".$bulan."-31 00:00:00' AND product = 'Bukan_Carnation' ")->result_array();		
					$total_outlet_switching = $data_outlet_switching[0]['total_outlet_switching'];
					
					//$total_motorist = $this->db->query("SELECT * FROM motorist join distributor on distributor.distributor_code = motorist.distributor_code WHERE distributor.distributor_code = '".$data_level_distributor['distributor_code']."'  ")->num_rows();
					$total_motorist =  10;
					
					if($total_outlet_switching<=0)
					{$total_outlet_switching = '0'; }
					
					
					if($total_motorist>0)
					{
					$persentasi_outlet_switching = ($total_outlet_switching * 100) / $total_motorist;
					$persentasi_outlet_switching = number_format($persentasi_outlet_switching, 0, '.', '');
					}
					else
					{
						$persentasi_outlet_switching = "0";
					}
					
					
					if($total_outlet_register>0)
					{
					$persentasi_outlet_active = ($total_outlet_active * 100) / $total_outlet_register;
					$persentasi_outlet_active = number_format($persentasi_outlet_active, 0, '.', '');
					}
					else
					{
						$persentasi_outlet_active = "0";
					}
					
					
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(17, $row, $total_outlet_register);
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(18, $row, $total_outlet_active);
					if($persentasi_outlet_active>$timerate)
			{
				$objPHPExcel->getActiveSheet()->getStyle("T".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('T'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => '099f3e')
						)
					 ) 
					 );
					 
				}
			else if($persentasi_outlet_active<$timerate)
			{
				$objPHPExcel->getActiveSheet()->getStyle("T".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('T'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => 'fa364d')
						)
					 ) 
					 );
					 
			}
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(19, $row, $persentasi_outlet_active." %");
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(20, $row, $total_motorist);
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(21, $row, $total_outlet_switching);
					
					if($persentasi_outlet_switching>$timerate)
			{
				$objPHPExcel->getActiveSheet()->getStyle("W".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('W'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => '099f3e')
						)
					 ) 
					 );
					 
				}
			else if($persentasi_outlet_switching<$timerate)
			{
				$objPHPExcel->getActiveSheet()->getStyle("W".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('W'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => 'fa364d')
						)
					 ) 
					 );
					 
			}
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(22, $row, $persentasi_outlet_switching." %");
					$row++;
				
			}
			// END Motorist
			
				
			}
			// END Distributor
			
			
			
			}
			// END AREA
			
			
			
		}
		
		 $last_row = $row-1;
		
	
		
		//Set Border
        $objPHPExcel->getActiveSheet()->getStyle("A6".":"."W".$last_row)->applyFromArray($BStyle);
	    $objPHPExcel->getActiveSheet()->getStyle("A5".":"."W".$last_row)->applyFromArray($styleAlign);
        $objPHPExcel->setActiveSheetIndex(0);
        $objWriter = IOFactory::createWriter($objPHPExcel, 'Excel5');
 		
		
	   // Sending headers to force the user to download the file
       // header('Content-Type: application/vnd.ms-excel');
       // header('Content-Disposition: attachment;filename="Products_'.date('dMy').'.xls"');
       // header('Cache-Control: max-age=0');
		
		
        // Sending headers to force the user to download the file        
		
        $objWriter->save('files/daily_report_'.$select_motorist_type[0]['motorist_type'].'_'.$date_now.'.xls');
		
		$list_email = $data_email['email'];
		$attachment_email = 'files/daily_report_'.$select_motorist_type[0]['motorist_type'].'_'.$date_now.'.xls';
		$message = 'Daily Report '.$select_motorist_type[0]['motorist_type'].' Tanggal '.$report_date;
		$subject = 'Daily Report '.$select_motorist_type[0]['motorist_type'].' Tanggal '.$report_date;
		$this->sendmail($list_email,$attachment_email,$message,$subject);
		

		$status_kirim_email = 'Sukses';

			
			
		$data_log = array(
		
		'date' => $date_now,
		'email' => $email_receiver,
		'status' => $status_kirim_email,
		'motorist' => $select_motorist_type[0]['motorist_type']
		
		);
		
		$this->model_report->insertData('log_report',$data_log );
		
		}
		
		else
		{
			echo"sudah kirim <br>";
			}
		
		}
		}
		else
		{
			echo"belum boleh";
			}
    }
	
	
	
	function Sergap()
    	{
		date_default_timezone_set('Asia/Jakarta');
		$date_now_check = date ('Y-m-d');
		$date_cutoff_check = new DateTime($date_now_check.'00:00:00');
		$datetime_now_check = date('Y-m-d H:i:s');
		$datetime_now_check = new DateTime($datetime_now_check);
		//Check Apakah sudah lebih dari jam setengah 4
		if($datetime_now_check > $date_cutoff_check)
		{
		
		$timestamp = date('D, M d Y H:s a ');
		$periode = date('M Y');
		$date_now = date ('Y-m-d');
		$date_yesterday = date('Y-m-d',strtotime("-1 days"));
		
		
		
		
		$select_email = $this->model_report->getEmail("WHERE motorist = 'Sergap' ");
		$data_emails = $select_email->result_array();
		
		foreach($data_emails as $data_email)
		{
			
		//Check Apakah sudah dikirim atau belum
		
		$select_motorist_type = $this->db->query("SELECT * FROM motorist_type WHERE motorist_type = '".$data_email['motorist']."' ")->result_array();
		$data_motorist_type = $select_motorist_type[0]['id_motorist_type'];
		echo $select_motorist_type[0]['motorist_type'];
		
		$email_receiver = $data_email['email'];	
		$check_log_report = $this->model_report->getLogReport("WHERE date = '".$date_now."' AND email = '".$data_email['email']."' AND motorist = '".$select_motorist_type[0]['motorist_type']."'  ")->num_rows;
		$query = $this->db->query("SELECT * FROM master_regional");
		if($check_log_report == 0 )
		{
		if(!$query)
        return false;
 		$report_date = date("d-m-Y");	
        //Starting the PHPExcel library
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
		foreach(range('A','Z') as $columnID)
		{
			$objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
		}
		
		
		//Merge And Center Title
		$objPHPExcel->getActiveSheet()->mergeCells('A1:D1');
		$objPHPExcel->getActiveSheet()->mergeCells('B5:I5');
		
		$objPHPExcel->getActiveSheet()->mergeCells('J5:W5');
		
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 1, "Tracking Productivity Motorist ".$select_motorist_type[0]['motorist_type']."");
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, 5, "Daily ");
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9, 5, "Month To Date ");
		$objPHPExcel->getActiveSheet()->getStyle('A5:W5')->applyFromArray($Fontstyle);
		
		$objPHPExcel->getActiveSheet()->getStyle('J5:W5')->applyFromArray(
			array(
				'fill' => array(
					'type' => PHPExcel_Style_Fill::FILL_SOLID,
					'color' => array('rgb' => '169805')
				)
			)
		);
		
		$objPHPExcel->getActiveSheet()->getStyle('B5:I5')->applyFromArray(
			array(
				'fill' => array(
					'type' => PHPExcel_Style_Fill::FILL_SOLID,
					'color' => array('rgb' => 'e4c208')
				)
			)
		);
		
		//Merge And Center Date
		$objPHPExcel->getActiveSheet()->mergeCells('A2:D2');
		
		$objPHPExcel->getActiveSheet()->mergeCells('A3:D3');
		
		//Set Font Color Title
		$objPHPExcel->getActiveSheet()->getStyle('A1:D2')->applyFromArray($FontstyleTitle);
		$objPHPExcel->getActiveSheet()->getStyle('A3:D3')->applyFromArray($FontstyleTitle);
		
		//Set Font Color Header
		$objPHPExcel->getActiveSheet()->getStyle('A6:W6')->applyFromArray($Fontstyle);
	
		
		
		//Set Backgroung Color Header
		$objPHPExcel->getActiveSheet()->getStyle('A6:O6')->applyFromArray(
			array(
				'fill' => array(
					'type' => PHPExcel_Style_Fill::FILL_SOLID,
					'color' => array('rgb' => '62a8ea')
				)
			)
		);
		
		
		$objPHPExcel->getActiveSheet()->getStyle('A6:A6')->applyFromArray(
			array(
				'fill' => array(
					'type' => PHPExcel_Style_Fill::FILL_SOLID,
					'color' => array('rgb' => '1dccec')
				)
			)
		);
		
		$objPHPExcel->getActiveSheet()->getStyle('B6:I6')->applyFromArray(
			array(
				'fill' => array(
					'type' => PHPExcel_Style_Fill::FILL_SOLID,
					'color' => array('rgb' => 'e4c208')
				)
			)
		);
		
		$objPHPExcel->getActiveSheet()->getStyle('J6:W6')->applyFromArray(
			array(
				'fill' => array(
					'type' => PHPExcel_Style_Fill::FILL_SOLID,
					'color' => array('rgb' => '169805')
				)
			)
		);
		
 		
		//Keterangan Report
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 1, "Tracking Productivity Motorist ".$select_motorist_type[0]['motorist_type']."");
		
		//Keterangan Distributor
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 2, $timestamp);
		
		
		
		
		
		
        // Field names in the first row
        $fields = array(
		"Sales Region" => "Sales Region",
		"Target Call" => "Target Call",
		"Actual Call" => "Actual Call",
		"% Call" => "% Call",
		"Effective Call" => "Effective Call",
		"% Effective Call" => "% Effective Call",
		"Target Sales" => "Target Sales",
		"Actual sales" => "Actual sales",
		"% Sales achievement" => "% Sales achievement",
		"Target Call Month" => "Target Call",
		"Actual Call Month" => "Actual Call",
		"% Call Month" => "% Call",
		"Effective Call Month" => "Effective Call",
		"% Effective Call Month" => "% Effective Call",
		"Target Sales Month" => "Target Sales",
		"Actual sales Month" => "Actual sales",
		"% Sales achievement Month" => "% Sales achievement",
		"Register Outlet" => "Register Outlet",
		"Active outlet" => "Active outlet",
		"% Active outlet" => "% Active outlet",
		"Target Switching" => "Target Switching",
		"Actual Switching" => "Actual Switching",
		"% Switching" => "% Switching"
		
		
		);
        $col = 0;
        foreach ($fields as $field)
        {
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, 6, $field);
            $col++;
        }
		
		
		 // Fetching the table data
        $row = 7;
		$no = 1;
		$no_order = "";
		
		$date_now_date = date('d');
		$bulan = date('m');
		$year = date('Y');
		
		$tanggal_bulan_awal = $year.'-'.$bulan."-01 00:00:00";
		$tanggal_bulan_akhir = $year.'-'.$bulan."-31 23:59:59";
		$month = intval($bulan);
		$month_with_null = $bulan;
		$total_day = date('t', mktime(0, 0, 0, $month, 1, $year)); 
		
		
		function number_of_working_days_all($from, $to) {
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
			
		
		function number_of_working_days($from, $to,$hari) {
			$workingDays = [$hari]; 
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
			
			$total_senin = number_of_working_days('2016-'.$bulan.'-01', '2016-'.$bulan.'-'.$date_now_date,1);
			//echo "total senin".$total_senin."<br>";
			$total_selasa = number_of_working_days('2016-'.$bulan.'-01', '2016-'.$bulan.'-'.$date_now_date,2);
			//echo "total selasa".$total_selasa."<br>";
			$total_rabu = number_of_working_days('2016-'.$bulan.'-01', '2016-'.$bulan.'-'.$date_now_date,3);
			//echo "total rabu".$total_rabu."<br>";
			$total_kamis = number_of_working_days('2016-'.$bulan.'-01', '2016-'.$bulan.'-'.$date_now_date,4);
			//echo "total kamis".$total_kamis."<br>";
			$total_jumat = number_of_working_days('2016-'.$bulan.'-01', '2016-'.$bulan.'-'.$date_now_date,5);
			//echo "total jumat".$total_jumat."<br>";
			$total_sabtu = number_of_working_days('2016-'.$bulan.'-01', '2016-'.$bulan.'-'.$date_now_date,6);
			//echo "total sabtu".$total_sabtu."<br>";
			
			$hari_kerja = number_of_working_days_all($year.'-'.$month_with_null.'-01', $year.'-'.$month_with_null.'-'.$total_day);
			
			$date_sekarang = date('d');
			$hari_sekarang = number_of_working_days_all($year.'-'.$month_with_null.'-01', $year.'-'.$month_with_null.'-'.$date_sekarang);
			$date_convert = date_create($date_yesterday);
			$day = date_format($date_convert,"l");
			
			
			
			//National
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $row, "National");			
			
			$data_target_call = $this->db->query("SELECT COUNT(customer_code) as target_call FROM store WHERE day_visit = '".$day."' AND motorist_type = '".$data_motorist_type."'  ")->result_array();		
			$target_call = $data_target_call[0]['target_call'];
			
							$total_store_keseluruhan = 0;
							
							$store_senin = $this->db->query("SELECT id_store FROM store WHERE day_visit = 'monday' AND motorist_type = '".$data_motorist_type."'  ")->num_rows();
							//echo "store_senin".$store_senin."<br>";
							$total_store_senin = $total_senin * $store_senin;
							$store_selasa = $this->db->query("SELECT id_store FROM store WHERE  day_visit = 'tuesday' AND motorist_type = '".$data_motorist_type."' ")->num_rows();
							//echo "store_selasa".$store_selasa."<br>";
							$total_store_selasa = $total_selasa * $store_selasa;
							$store_rabu = $this->db->query("SELECT id_store FROM store WHERE day_visit = 'wednesday' AND motorist_type = '".$data_motorist_type."' ")->num_rows();
							$total_store_rabu = $total_rabu * $store_rabu;
							//echo "store_rabu".$store_rabu."<br>";
							$store_kamis = $this->db->query("SELECT id_store FROM store WHERE  day_visit = 'thursday' AND motorist_type = '".$data_motorist_type."' ")->num_rows();
							$total_store_kamis = $total_kamis * $store_kamis;
							//echo "store_kamis".$store_kamis."<br>";
							$store_jumat = $this->db->query("SELECT id_store FROM store WHERE day_visit = 'friday' AND motorist_type = '".$data_motorist_type."' ")->num_rows();
							$total_store_jumat = $total_jumat * $store_jumat;
							//echo "store_jumat".$store_jumat."<br>";
							$store_sabtu = $this->db->query("SELECT id_store FROM store WHERE  day_visit = 'saturday' AND motorist_type = '".$data_motorist_type."' ")->num_rows();
							$total_store_sabtu = $total_sabtu * $store_sabtu;
							//echo "store_sabtu".$store_sabtu."<br>";
							$total_keseluruhan = $total_store_senin+$total_store_selasa+$total_store_rabu+$total_store_kamis+$total_store_jumat+$total_store_sabtu;

			$data_total_call = $this->db->query("SELECT COUNT(customer_code) as total_call FROM visit JOIN motorist on motorist.id_motorist = visit.id_motorist JOIN distributor on motorist.distributor_code = distributor.distributor_code  WHERE   status_visit = 'call' AND time_stamp_visit LIKE '%".$date_yesterday."%' AND motorist.motorist_type = '".$data_motorist_type."' ")->result_array();		
			$total_call = $data_total_call[0]['total_call'];
			
			$data_total_call_monthly = $this->db->query("SELECT COUNT(customer_code) as total_call_monthly FROM visit JOIN motorist on motorist.id_motorist = visit.id_motorist JOIN distributor on motorist.distributor_code = distributor.distributor_code WHERE  status_visit = 'call' AND time_stamp_visit between '".$tanggal_bulan_awal."' AND '".$tanggal_bulan_akhir."' AND motorist.motorist_type = '".$data_motorist_type."' ")->result_array();		
			$total_call_monthly = $data_total_call_monthly[0]['total_call_monthly'];
			
			$data_total_effective_call = $this->db->query("SELECT COUNT(customer_code) as total_effective_call FROM visit JOIN motorist on motorist.id_motorist = visit.id_motorist JOIN distributor on motorist.distributor_code = distributor.distributor_code  WHERE  status_order = 'order' AND  status_visit = 'call' AND time_stamp_visit LIKE '%".$date_yesterday."%' AND motorist.motorist_type = '".$data_motorist_type."' ")->result_array();		
			$total_effective_call = $data_total_effective_call[0]['total_effective_call'];
			
			$data_total_effective_call_monthly = $this->db->query("SELECT COUNT(customer_code) as total_effective_call_monthly FROM visit JOIN motorist on motorist.id_motorist = visit.id_motorist JOIN distributor on motorist.distributor_code = distributor.distributor_code  WHERE  status_order = 'order' AND  status_visit = 'call' AND time_stamp_visit between '".$tanggal_bulan_awal."' AND '".$tanggal_bulan_akhir."' AND motorist.motorist_type = '".$data_motorist_type."' ")->result_array();		
			$total_effective_call_monthly = $data_total_effective_call_monthly[0]['total_effective_call_monthly'];
			
			
			$data_total_target_sales = $this->db->query("SELECT SUM(target_harian) as target_harian FROM motorist JOIN distributor on motorist.distributor_code = distributor.distributor_code WHERE motorist.motorist_type = '".$data_motorist_type."' ")->result_array();		
			$total_daily_target_sales = $data_total_target_sales[0]['target_harian'];
			
			
			//Keterangan Distributor
			$timerate = ($hari_sekarang * 100)/ $hari_kerja;
			$timerate = number_format($timerate, 0, '.', '');
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 3, "Periode: ".$periode. " Elapsed workday: ".$hari_sekarang.'/'.$hari_kerja.' Timerate: '.$timerate.' %');
			
		
		
			if($total_daily_target_sales<=0)
			{
				$total_daily_target_sales = "0";
			}
			
			$data_total_actual_daily_sales = $this->db->query("SELECT SUM(total_order) as total_actual_daily_sales FROM orders JOIN motorist on motorist.id_motorist = orders.id_motorist JOIN distributor on motorist.distributor_code = distributor.distributor_code WHERE  date LIKE '%".$date_yesterday."%' AND motorist.motorist_type = '".$data_motorist_type."'  ")->result_array();		
			$total_actual_daily_sales = $data_total_actual_daily_sales[0]['total_actual_daily_sales'];
			
			
			$data_total_actual_daily_sales_monthly = $this->db->query("SELECT SUM(total_order) as total_actual_daily_sales_monthly FROM orders JOIN motorist on motorist.id_motorist = orders.id_motorist JOIN distributor on motorist.distributor_code = distributor.distributor_code WHERE date between '".$tanggal_bulan_awal."' AND '".$tanggal_bulan_akhir."' AND motorist.motorist_type = '".$data_motorist_type."'  ")->result_array();		
			$total_actual_daily_sales_monthly = $data_total_actual_daily_sales_monthly[0]['total_actual_daily_sales_monthly'];
			
			$total_daily_target_sales_monthly = $total_daily_target_sales * $hari_kerja; 

			if($total_actual_daily_sales<=0)
			{
				$total_actual_daily_sales = "0";
			}
			
			if($target_call>0)
			{
			$persentasi_call = ($total_call * 100) / $target_call;
			$persentasi_call = number_format($persentasi_call, 0, '.', '');	
			}
			else{
				$persentasi_call = "0";
			}
			
			
			if($total_keseluruhan>0)
			{
			$persentasi_call_monthly = ($total_call_monthly * 100) / $total_keseluruhan;
			$persentasi_call_monthly = number_format($persentasi_call_monthly, 0, '.', '');	
			}
			else
			{
				$persentasi_call_monthly = "0";
			}
			
			if($target_call >0)
			{
			$persentasi_effective_call = ($total_effective_call  * 100) / $target_call;
			$persentasi_effective_call = number_format($persentasi_effective_call, 0, '.', '');
			}
			else{
				$persentasi_effective_call  = "0";
			}
			
			if($total_keseluruhan >0)
			{
			$persentasi_effective_call_monthly = ($total_effective_call_monthly  * 100) / $total_keseluruhan;
			$persentasi_effective_call_monthly = number_format($persentasi_effective_call_monthly, 0, '.', '');
			}
			else{
				$persentasi_effective_call_monthly  = "0";
			}
			
			if($total_actual_daily_sales>0)
			{
			$persentasi_target_harian = ($total_actual_daily_sales * 100) / $total_daily_target_sales;
			$persentasi_target_harian = number_format($persentasi_target_harian, 0, '.', '');
			}
			else
			{
				$persentasi_target_harian = "0";
			}
			
			
			if($total_actual_daily_sales_monthly>0)
			{
			$persentasi_target_bulanan = ($total_actual_daily_sales_monthly * 100) / $total_daily_target_sales_monthly;
			$persentasi_target_bulanan = number_format($persentasi_target_bulanan, 0, '.', '');
			}
			else
			{
				$persentasi_target_bulanan = "0";
			}
			
			if($total_actual_daily_sales_monthly<=0)
			{
				$total_actual_daily_sales_monthly=0;
			}
			
			$objPHPExcel->getActiveSheet()->getStyle('A'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => 'e84fea')
						)
					 ) 
			);
			
							
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $row, $target_call);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $row, $total_call);
			
			if($persentasi_call>95)
			{
				$objPHPExcel->getActiveSheet()->getStyle("D".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('D'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => '099f3e')
						)
					 ) 
					 );
					 
				}
			else if($persentasi_call<90)
			{
				$objPHPExcel->getActiveSheet()->getStyle("D".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('D'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => 'fa364d')
						)
					 ) 
					 );
					 
			}
			
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $row, $persentasi_call." %");
			
			
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $row, $total_effective_call);
			
			if($persentasi_effective_call>95)
			{
				$objPHPExcel->getActiveSheet()->getStyle("F".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('F'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => '099f3e')
						)
					 ) 
					 );
					 
				}
			else if($persentasi_effective_call<90)
			{
				$objPHPExcel->getActiveSheet()->getStyle("F".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('F'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => 'fa364d')
						)
					 ) 
					 );
					 
			}
			
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, $row, $persentasi_effective_call." %");
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, $row, "Rp. ".number_format($total_daily_target_sales, 0 , '' , '.' ));
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, $row, "Rp. ".number_format($total_actual_daily_sales, 0 , '' , '.' ));
			
			if($persentasi_target_harian>100)
			{
				$objPHPExcel->getActiveSheet()->getStyle("I".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('I'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => '099f3e')
						)
					 ) 
					 );
					 
				}
			else if($persentasi_target_harian<100)
			{
				$objPHPExcel->getActiveSheet()->getStyle("I".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('I'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => 'fa364d')
						)
					 ) 
					 );
					 
			}
			
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8, $row, $persentasi_target_harian." %");
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9, $row, $total_keseluruhan);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(10, $row, $total_call_monthly);
			
			if($persentasi_call_monthly>95)
			{
				$objPHPExcel->getActiveSheet()->getStyle("L".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('L'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => '099f3e')
						)
					 ) 
					 );
					 
				}
			else if($persentasi_call_monthly<90)
			{
				$objPHPExcel->getActiveSheet()->getStyle("L".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('L'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => 'fa364d')
						)
					 ) 
					 );
					 
			}
			
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(11, $row, $persentasi_call_monthly." %");
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(12, $row, $total_effective_call_monthly);
			
			if($persentasi_effective_call_monthly>95)
			{
				$objPHPExcel->getActiveSheet()->getStyle("N".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('N'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => '099f3e')
						)
					 ) 
					 );
					 
				}
			else if($persentasi_effective_call_monthly<90)
			{
				$objPHPExcel->getActiveSheet()->getStyle("N".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('N'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => 'fa364d')
						)
					 ) 
					 );
					 
			}
			
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(13, $row, $persentasi_effective_call_monthly." %");
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(14, $row, "Rp. ".number_format($total_daily_target_sales_monthly, 0 , '' , '.' ));
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(15, $row, "Rp. ".number_format($total_actual_daily_sales_monthly, 0 , '' , '.' ));
			
			
			
			if($persentasi_effective_call_monthly>$timerate)
			{
				$objPHPExcel->getActiveSheet()->getStyle("Q".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('Q'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => '099f3e')
						)
					 ) 
					 );
					 
				}
			else if($persentasi_effective_call_monthly<$timerate)
			{
				$objPHPExcel->getActiveSheet()->getStyle("Q".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('Q'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => 'fa364d')
						)
					 ) 
					 );
					 
			}
			
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(16, $row, $persentasi_target_bulanan." %");
			//Monthly
			$data_total_outlet_register = $this->db->query("SELECT COUNT(customer_code) as total_outlet_register FROM store WHERE store.motorist_type = '".$data_motorist_type."'  ")->result_array();		
			$total_outlet_register = $data_total_outlet_register[0]['total_outlet_register'];
			
			//Monthly
			$total_outlet_active = $this->db->query("SELECT id_order FROM orders JOIN motorist on motorist.id_motorist = orders.id_motorist JOIN distributor on motorist.distributor_code = distributor.distributor_code WHERE  date between '2016-".$bulan."-01 00:00:00' AND '2016-".$bulan."-31 23:59:59' AND motorist.motorist_type = '".$data_motorist_type."' group by customer_code")->num_rows();		
			
			
			$data_outlet_switching = $this->db->query("SELECT COUNT(id_noo) as total_outlet_switching FROM noo JOIN distributor on noo.distributor_code = distributor.distributor_code JOIN motorist on noo.motorist_code = motorist.motorist_code AND noo.distributor_code = motorist.distributor_code  WHERE  customer_create_date between '".$year."-".$bulan."-01 00:00:00'  AND '".$year."-".$bulan."-31 00:00:00' AND product = 'Bukan_Carnation' AND motorist.motorist_code = '2' ")->result_array();		
			$total_outlet_switching = $data_outlet_switching[0]['total_outlet_switching'];
			
			$total_motorist = $this->db->query("SELECT * FROM motorist join distributor on distributor.distributor_code = motorist.distributor_code WHERE motorist.motorist_type = '".$data_motorist_type."'  ")->num_rows();
			$total_motorist = $total_motorist * 10;
			
			if($total_outlet_switching<=0)
			{$total_outlet_switching = '0'; }
			
			
			if($total_outlet_switching>0)
			{
			$persentasi_outlet_switching = ($total_outlet_switching * 100) / $total_motorist;
			$persentasi_outlet_switching = number_format($persentasi_outlet_switching, 0, '.', '');
			}
			else
			{
				$persentasi_outlet_switching = "0";
			}
			
			
			if($total_outlet_active>0)
			{
			$persentasi_outlet_active = ($total_outlet_active * 100) / $total_outlet_register;
			$persentasi_outlet_active = number_format($persentasi_outlet_active, 0, '.', '');
			}
			else
			{
				$persentasi_outlet_active = "0";
			}
			
			
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(17, $row, $total_outlet_register);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(18, $row, $total_outlet_active);
			
			if($persentasi_outlet_active>$timerate)
			{
				$objPHPExcel->getActiveSheet()->getStyle("T".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('T'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => '099f3e')
						)
					 ) 
					 );
					 
				}
			else if($persentasi_outlet_active<$timerate)
			{
				$objPHPExcel->getActiveSheet()->getStyle("T".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('T'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => 'fa364d')
						)
					 ) 
					 );
					 
			}
			
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(19, $row, $persentasi_outlet_active." %");
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(20, $row, $total_motorist);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(21, $row, $total_outlet_switching);
			
			if($persentasi_outlet_switching>$timerate)
			{
				$objPHPExcel->getActiveSheet()->getStyle("W".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('W'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => '099f3e')
						)
					 ) 
					 );
					 
				}
			else if($persentasi_outlet_switching<$timerate)
			{
				$objPHPExcel->getActiveSheet()->getStyle("W".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('W'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => 'fa364d')
						)
					 ) 
					 );
					 
			}
			
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(22, $row, $persentasi_outlet_switching." %");
			$row++;
			// End National
			
        foreach($query->result_array() as $data)
        {
			
			
			
			$objPHPExcel->getActiveSheet()->getStyle('A'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => '3bbe26')
						)
					 ) 
			);
			
			
			//Regional
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $row, $data['regional_name']);			
			$data_target_call = $this->db->query("SELECT COUNT(customer_code) as target_call FROM store WHERE day_visit = '".$day."' AND regional = '".$data['regional_name']."' AND motorist_type = '".$data_motorist_type."' ")->result_array();		
			$target_call = $data_target_call[0]['target_call'];
			
							$total_store_keseluruhan = 0;
							
							$store_senin = $this->db->query("SELECT id_store FROM store WHERE regional = '".$data['regional_name']."' AND day_visit = 'monday' AND motorist_type = '".$data_motorist_type."' ")->num_rows();
							//echo "store_senin".$store_senin."<br>";
							$total_store_senin = $total_senin * $store_senin;
							$store_selasa = $this->db->query("SELECT id_store FROM store WHERE regional = '".$data['regional_name']."' AND day_visit = 'tuesday' AND motorist_type = '".$data_motorist_type."' ")->num_rows();
							//echo "store_selasa".$store_selasa."<br>";
							$total_store_selasa = $total_selasa * $store_selasa;
							$store_rabu = $this->db->query("SELECT id_store FROM store WHERE regional = '".$data['regional_name']."' AND day_visit = 'wednesday' AND motorist_type = '".$data_motorist_type."' ")->num_rows();
							$total_store_rabu = $total_rabu * $store_rabu;
							//echo "store_rabu".$store_rabu."<br>";
							$store_kamis = $this->db->query("SELECT id_store FROM store WHERE regional = '".$data['regional_name']."' AND day_visit = 'thursday' AND motorist_type = '".$data_motorist_type."' ")->num_rows();
							$total_store_kamis = $total_kamis * $store_kamis;
							//echo "store_kamis".$store_kamis."<br>";
							$store_jumat = $this->db->query("SELECT id_store FROM store WHERE regional = '".$data['regional_name']."' AND day_visit = 'friday' AND motorist_type = '".$data_motorist_type."' ")->num_rows();
							$total_store_jumat = $total_jumat * $store_jumat;
							//echo "store_jumat".$store_jumat."<br>";
							$store_sabtu = $this->db->query("SELECT id_store FROM store WHERE regional = '".$data['regional_name']."' AND day_visit = 'saturday' AND motorist_type = '".$data_motorist_type."' ")->num_rows();
							$total_store_sabtu = $total_sabtu * $store_sabtu;
							//echo "store_sabtu".$store_sabtu."<br>";
							$total_keseluruhan = $total_store_senin+$total_store_selasa+$total_store_rabu+$total_store_kamis+$total_store_jumat+$total_store_sabtu;

			$data_total_call = $this->db->query("SELECT COUNT(customer_code) as total_call FROM visit JOIN motorist on motorist.id_motorist = visit.id_motorist JOIN distributor on motorist.distributor_code = distributor.distributor_code  WHERE distributor.regional = '".$data['regional_name']."' AND  status_visit = 'call' AND time_stamp_visit LIKE '%".$date_yesterday."%' AND motorist.motorist_type = '".$data_motorist_type."' ")->result_array();		
			$total_call = $data_total_call[0]['total_call'];
			
			$data_total_call_monthly = $this->db->query("SELECT COUNT(customer_code) as total_call_monthly FROM visit JOIN motorist on motorist.id_motorist = visit.id_motorist JOIN distributor on motorist.distributor_code = distributor.distributor_code WHERE distributor.regional = '".$data['regional_name']."' AND status_visit = 'call' AND time_stamp_visit between '".$tanggal_bulan_awal."' AND '".$tanggal_bulan_akhir."' AND motorist.motorist_type = '".$data_motorist_type."' ")->result_array();		
			$total_call_monthly = $data_total_call_monthly[0]['total_call_monthly'];
			
			$data_total_effective_call = $this->db->query("SELECT COUNT(customer_code) as total_effective_call FROM visit JOIN motorist on motorist.id_motorist = visit.id_motorist JOIN distributor on motorist.distributor_code = distributor.distributor_code  WHERE distributor.regional = '".$data['regional_name']."' AND status_order = 'order' AND  status_visit = 'call' AND time_stamp_visit LIKE '%".$date_yesterday."%' AND motorist.motorist_type = '".$data_motorist_type."' ")->result_array();		
			$total_effective_call = $data_total_effective_call[0]['total_effective_call'];
			
			$data_total_effective_call_monthly = $this->db->query("SELECT COUNT(customer_code) as total_effective_call_monthly FROM visit JOIN motorist on motorist.id_motorist = visit.id_motorist JOIN distributor on motorist.distributor_code = distributor.distributor_code  WHERE distributor.regional = '".$data['regional_name']."' AND status_order = 'order' AND  status_visit = 'call' AND time_stamp_visit between '".$tanggal_bulan_awal."' AND '".$tanggal_bulan_akhir."' AND motorist.motorist_type = '".$data_motorist_type."' ")->result_array();		
			$total_effective_call_monthly = $data_total_effective_call_monthly[0]['total_effective_call_monthly'];
			
			
			$data_total_target_sales = $this->db->query("SELECT SUM(target_harian) as target_harian FROM motorist JOIN distributor on motorist.distributor_code = distributor.distributor_code  WHERE distributor.regional = '".$data['regional_name']."' AND motorist.motorist_type = '".$data_motorist_type."' ")->result_array();		
			$total_daily_target_sales = $data_total_target_sales[0]['target_harian'];
			
			
			
			if($total_daily_target_sales<=0)
			{
				$total_daily_target_sales = "0";
			}
			
			$data_total_actual_daily_sales = $this->db->query("SELECT SUM(total_order) as total_actual_daily_sales FROM orders JOIN motorist on motorist.id_motorist = orders.id_motorist JOIN distributor on motorist.distributor_code = distributor.distributor_code WHERE  date LIKE '%".$date_yesterday."%' AND distributor.regional = '".$data['regional_name']."' AND motorist.motorist_type = '".$data_motorist_type."' ")->result_array();		
			$total_actual_daily_sales = $data_total_actual_daily_sales[0]['total_actual_daily_sales'];
			
			
			$data_total_actual_daily_sales_monthly = $this->db->query("SELECT SUM(total_order) as total_actual_daily_sales_monthly FROM orders JOIN motorist on motorist.id_motorist = orders.id_motorist JOIN distributor on motorist.distributor_code = distributor.distributor_code WHERE date between '".$tanggal_bulan_awal."' AND '".$tanggal_bulan_akhir."'  AND distributor.regional = '".$data['regional_name']."' AND motorist.motorist_type = '".$data_motorist_type."' ")->result_array();		
			$total_actual_daily_sales_monthly = $data_total_actual_daily_sales_monthly[0]['total_actual_daily_sales_monthly'];
			
			$total_daily_target_sales_monthly = $total_daily_target_sales * $hari_kerja; 

			if($total_actual_daily_sales<=0)
			{
				$total_actual_daily_sales = "0";
			}
			
			if($target_call>0)
			{
			$persentasi_call = ($total_call * 100) / $target_call;
			$persentasi_call = number_format($persentasi_call, 0, '.', '');	
			}
			else{
				$persentasi_call = "0";
			}
			
			
			if($total_keseluruhan>0)
			{
			$persentasi_call_monthly = ($total_call_monthly * 100) / $total_keseluruhan;
			$persentasi_call_monthly = number_format($persentasi_call_monthly, 0, '.', '');	
			}
			else
			{
				$persentasi_call_monthly = "0";
			}
			
			if($target_call >0)
			{
			$persentasi_effective_call = ($total_effective_call  * 100) / $target_call;
			$persentasi_effective_call = number_format($persentasi_effective_call, 0, '.', '');
			}
			else{
				$persentasi_effective_call  = "0";
			}
			
			if($total_keseluruhan >0)
			{
			$persentasi_effective_call_monthly = ($total_effective_call_monthly  * 100) / $total_keseluruhan;
			$persentasi_effective_call_monthly = number_format($persentasi_effective_call_monthly, 0, '.', '');
			}
			else{
				$persentasi_effective_call_monthly  = "0";
			}
			
			if($total_actual_daily_sales>0)
			{
			$persentasi_target_harian = ($total_actual_daily_sales * 100) / $total_daily_target_sales;
			$persentasi_target_harian = number_format($persentasi_target_harian, 0, '.', '');
			}

			else
			{
				$persentasi_target_harian = "0";
			}
			
			
			if($total_actual_daily_sales_monthly>0)
			{
			$persentasi_target_bulanan = ($total_actual_daily_sales_monthly * 100) / $total_daily_target_sales_monthly;
			$persentasi_target_bulanan = number_format($persentasi_target_bulanan, 0, '.', '');
			}
			else
			{
				$persentasi_target_bulanan = "0";
			}
			
			if($total_actual_daily_sales_monthly<=0)
			{
				$total_actual_daily_sales_monthly=0;
			}
							
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $row, $target_call);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $row, $total_call);
			
			
			if($persentasi_call>=95)
			{
				$objPHPExcel->getActiveSheet()->getStyle("D".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('D'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => '099f3e')
						)
					 ) 
					 );
					 
				}
			else if($persentasi_call<90)
			{
				$objPHPExcel->getActiveSheet()->getStyle("D".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('D'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => 'fa364d')
						)
					 ) 
					 );
					 
			}
			
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $row, $persentasi_call." %");
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $row, $total_effective_call);
			
			if($persentasi_effective_call>95)
			{
				$objPHPExcel->getActiveSheet()->getStyle("F".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('F'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => '099f3e')
						)
					 ) 
					 );
					 
				}
			else if($persentasi_effective_call<90)
			{
				$objPHPExcel->getActiveSheet()->getStyle("F".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('F'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => 'fa364d')
						)
					 ) 
					 );
					 
			}
			
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, $row, $persentasi_effective_call." %");
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, $row, "Rp. ".number_format($total_daily_target_sales, 0 , '' , '.' ) );
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, $row, "Rp. ".number_format($total_actual_daily_sales, 0 , '' , '.' ));
			if($persentasi_target_harian>100)
			{
				$objPHPExcel->getActiveSheet()->getStyle("I".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('I'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => '099f3e')
						)
					 ) 
					 );
					 
				}
			else if($persentasi_target_harian<100)
			{
				$objPHPExcel->getActiveSheet()->getStyle("I".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('I'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => 'fa364d')
						)
					 ) 
					 );
					 
			}
			
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8, $row, $persentasi_target_harian." %");
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9, $row, $total_keseluruhan);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(10, $row, $total_call_monthly);
			if($persentasi_call_monthly>95)
			{
				$objPHPExcel->getActiveSheet()->getStyle("L".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('L'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => '099f3e')
						)
					 ) 
					 );
					 
				}
			else if($persentasi_call_monthly<90)
			{
				$objPHPExcel->getActiveSheet()->getStyle("L".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('L'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => 'fa364d')
						)
					 ) 
					 );
					 
			}
			
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(11, $row, $persentasi_call_monthly." %");
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(12, $row, $total_effective_call_monthly);
			if($persentasi_effective_call_monthly>95)
			{
				$objPHPExcel->getActiveSheet()->getStyle("N".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('N'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => '099f3e')
						)
					 ) 
					 );
					 
				}
			else if($persentasi_effective_call_monthly<90)
			{
				$objPHPExcel->getActiveSheet()->getStyle("N".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('N'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => 'fa364d')
						)
					 ) 
					 );
					 
			}
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(13, $row, $persentasi_effective_call_monthly." %");
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(14, $row, "Rp. ".number_format($total_daily_target_sales_monthly, 0 , '' , '.' ));
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(15, $row, "Rp. ".number_format($total_actual_daily_sales_monthly, 0 , '' , '.' ));
			
			if($persentasi_effective_call_monthly>$timerate)
			{
				$objPHPExcel->getActiveSheet()->getStyle("Q".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('Q'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => '099f3e')
						)
					 ) 
					 );
					 
				}
			else if($persentasi_effective_call_monthly<$timerate)
			{
				$objPHPExcel->getActiveSheet()->getStyle("Q".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('Q'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => 'fa364d')
						)
					 ) 
					 );
					 
			}
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(16, $row, $persentasi_target_bulanan." %");
			//Monthly
			
			$data_total_outlet_register = $this->db->query("SELECT COUNT(customer_code) as total_outlet_register FROM store WHERE regional = '".$data['regional_name']."' AND store.motorist_type = '".$data_motorist_type."'  ")->result_array();		
			$total_outlet_register = $data_total_outlet_register[0]['total_outlet_register'];
			
			//Monthly
			$total_outlet_active = $this->db->query("SELECT id_order FROM orders JOIN motorist on motorist.id_motorist = orders.id_motorist JOIN distributor on motorist.distributor_code = distributor.distributor_code WHERE distributor.regional = '".$data['regional_name']."' AND  date between '2016-".$bulan."-01 00:00:00' AND '2016-".$bulan."-31 23:59:59' AND motorist.motorist_type = '".$data_motorist_type."' group by customer_code")->num_rows();		
			
			
			$data_outlet_switching = $this->db->query("SELECT COUNT(id_noo) as total_outlet_switching FROM noo JOIN distributor on noo.distributor_code = distributor.distributor_code JOIN motorist on noo.motorist_code = motorist.motorist_code AND noo.distributor_code = motorist.distributor_code  WHERE distributor.regional = '".$data['regional_name']."' AND customer_create_date between '".$year."-".$bulan."-01 00:00:00'  AND '".$year."-".$bulan."-31 00:00:00' AND product = 'Bukan_Carnation' AND motorist.motorist_code = '2' ")->result_array();		
			$total_outlet_switching = $data_outlet_switching[0]['total_outlet_switching'];
			
			$total_motorist = $this->db->query("SELECT * FROM motorist join distributor on distributor.distributor_code = motorist.distributor_code WHERE distributor.regional = '".$data['regional_name']."' AND motorist.motorist_type = '".$data_motorist_type."'  ")->num_rows();
			$total_motorist = $total_motorist * 10;
			
			if($total_outlet_switching<=0)
			{$total_outlet_switching = '0'; }
			
			
			if($total_motorist>0)
			{
			$persentasi_outlet_switching = ($total_outlet_switching * 100) / $total_motorist;
			$persentasi_outlet_switching = number_format($persentasi_outlet_switching, 0, '.', '');
			}
			else
			{
				$persentasi_outlet_switching = "0";
			}
			
			
			if($total_outlet_register>0)
			{
			$persentasi_outlet_active = ($total_outlet_active * 100) / $total_outlet_register;
			$persentasi_outlet_active = number_format($persentasi_outlet_active, 0, '.', '');
			}
			else
			{
				$persentasi_outlet_active = "0";
			}
			
			
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(17, $row, $total_outlet_register);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(18, $row, $total_outlet_active);
			
			if($persentasi_outlet_active>$timerate)
			{
				$objPHPExcel->getActiveSheet()->getStyle("T".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('T'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => '099f3e')
						)
					 ) 
					 );
					 
				}
			else if($persentasi_outlet_active<$timerate)
			{
				$objPHPExcel->getActiveSheet()->getStyle("T".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('T'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => 'fa364d')
						)
					 ) 
					 );
					 
			}
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(19, $row, $persentasi_outlet_active." %");
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(20, $row, $total_motorist);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(21, $row, $total_outlet_switching);
			
			if($persentasi_outlet_switching>$timerate)
			{
				$objPHPExcel->getActiveSheet()->getStyle("W".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('W'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => '099f3e')
						)
					 ) 
					 );
					 
				}
			else if($persentasi_outlet_switching<$timerate)
			{
				$objPHPExcel->getActiveSheet()->getStyle("W".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('W'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => 'fa364d')
						)
					 ) 
					 );
					 
			}
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(22, $row, $persentasi_outlet_switching." %");
            $row++;
			// END Regional
			
			// AREA
			$data_area = $this->db->query("SELECT * FROM master_area WHERE regional = '".$data['regional_name']."' ");
			foreach($data_area->result_array() as $data_regional)
			{
				
				
					$objPHPExcel->getActiveSheet()->getStyle('A'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => 'f2e666')
						)
					 ) 
			);
			
						//AREA
					
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $row, $data_regional['area']);			
					
					$data_target_call = $this->db->query("SELECT COUNT(customer_code) as target_call FROM store WHERE day_visit = '".$day."' AND area = '".$data_regional['area']."' AND motorist_type = '".$data_motorist_type."' ")->result_array();		
					$target_call = $data_target_call[0]['target_call'];
					
									$total_store_keseluruhan = 0;
									
									$store_senin = $this->db->query("SELECT id_store FROM store WHERE area = '".$data_regional['area']."' AND day_visit = 'monday' AND motorist_type = '".$data_motorist_type."' ")->num_rows();
									//echo "store_senin".$store_senin."<br>";
									$total_store_senin = $total_senin * $store_senin;
									$store_selasa = $this->db->query("SELECT id_store FROM store WHERE area = '".$data_regional['area']."' AND day_visit = 'tuesday' AND motorist_type = '".$data_motorist_type."' ")->num_rows();
									//echo "store_selasa".$store_selasa."<br>";
									$total_store_selasa = $total_selasa * $store_selasa;
									$store_rabu = $this->db->query("SELECT id_store FROM store WHERE area = '".$data_regional['area']."' AND day_visit = 'wednesday' AND motorist_type = '".$data_motorist_type."' ")->num_rows();
									$total_store_rabu = $total_rabu * $store_rabu;
									//echo "store_rabu".$store_rabu."<br>";
									$store_kamis = $this->db->query("SELECT id_store FROM store WHERE area = '".$data_regional['area']."' AND day_visit = 'thursday' AND motorist_type = '".$data_motorist_type."' ")->num_rows();
									$total_store_kamis = $total_kamis * $store_kamis;
									//echo "store_kamis".$store_kamis."<br>";
									$store_jumat = $this->db->query("SELECT id_store FROM store WHERE area = '".$data_regional['area']."' AND day_visit = 'friday' AND motorist_type = '".$data_motorist_type."' ")->num_rows();
									$total_store_jumat = $total_jumat * $store_jumat;
									//echo "store_jumat".$store_jumat."<br>";
									$store_sabtu = $this->db->query("SELECT id_store FROM store WHERE area = '".$data_regional['area']."' AND day_visit = 'saturday' AND motorist_type = '".$data_motorist_type."' ")->num_rows();
									$total_store_sabtu = $total_sabtu * $store_sabtu;
									//echo "store_sabtu".$store_sabtu."<br>";
									$total_keseluruhan = $total_store_senin+$total_store_selasa+$total_store_rabu+$total_store_kamis+$total_store_jumat+$total_store_sabtu;

					$data_total_call = $this->db->query("SELECT COUNT(customer_code) as total_call FROM visit JOIN motorist on motorist.id_motorist = visit.id_motorist JOIN distributor on motorist.distributor_code = distributor.distributor_code  WHERE distributor.area = '".$data_regional['area']."' AND  status_visit = 'call' AND time_stamp_visit LIKE '%".$date_yesterday."%' AND motorist.motorist_type = '".$data_motorist_type."' ")->result_array();		
					$total_call = $data_total_call[0]['total_call'];
					
					$data_total_call_monthly = $this->db->query("SELECT COUNT(customer_code) as total_call_monthly FROM visit JOIN motorist on motorist.id_motorist = visit.id_motorist JOIN distributor on motorist.distributor_code = distributor.distributor_code WHERE distributor.area = '".$data_regional['area']."' AND status_visit = 'call' AND time_stamp_visit between '".$tanggal_bulan_awal."' AND '".$tanggal_bulan_akhir."' AND motorist.motorist_type = '".$data_motorist_type."' ")->result_array();		
					$total_call_monthly = $data_total_call_monthly[0]['total_call_monthly'];
					
					$data_total_effective_call = $this->db->query("SELECT COUNT(customer_code) as total_effective_call FROM visit JOIN motorist on motorist.id_motorist = visit.id_motorist JOIN distributor on motorist.distributor_code = distributor.distributor_code  WHERE distributor.area = '".$data_regional['area']."' AND status_order = 'order' AND  status_visit = 'call' AND time_stamp_visit LIKE '%".$date_yesterday."%' AND motorist.motorist_type = '".$data_motorist_type."' ")->result_array();		
					$total_effective_call = $data_total_effective_call[0]['total_effective_call'];
					
					$data_total_effective_call_monthly = $this->db->query("SELECT COUNT(customer_code) as total_effective_call_monthly FROM visit JOIN motorist on motorist.id_motorist = visit.id_motorist JOIN distributor on motorist.distributor_code = distributor.distributor_code  WHERE distributor.area = '".$data_regional['area']."' AND status_order = 'order' AND  status_visit = 'call' AND time_stamp_visit between '".$tanggal_bulan_awal."' AND '".$tanggal_bulan_akhir."' AND motorist.motorist_type = '".$data_motorist_type."' ")->result_array();		
					$total_effective_call_monthly = $data_total_effective_call_monthly[0]['total_effective_call_monthly'];
					
					
					$data_total_target_sales = $this->db->query("SELECT SUM(target_harian) as target_harian FROM motorist JOIN distributor on motorist.distributor_code = distributor.distributor_code  WHERE distributor.area = '".$data_regional['area']."' AND motorist.motorist_type = '".$data_motorist_type."' ")->result_array();		
					$total_daily_target_sales = $data_total_target_sales[0]['target_harian'];
					
					
					
					if($total_daily_target_sales<=0)
					{
						$total_daily_target_sales = "0";
					}
					
					$data_total_actual_daily_sales = $this->db->query("SELECT SUM(total_order) as total_actual_daily_sales FROM orders JOIN motorist on motorist.id_motorist = orders.id_motorist JOIN distributor on motorist.distributor_code = distributor.distributor_code WHERE  date LIKE '%".$date_yesterday."%' AND distributor.area = '".$data_regional['area']."' AND motorist.motorist_type = '".$data_motorist_type."' ")->result_array();		
					$total_actual_daily_sales = $data_total_actual_daily_sales[0]['total_actual_daily_sales'];
					
					
					$data_total_actual_daily_sales_monthly = $this->db->query("SELECT SUM(total_order) as total_actual_daily_sales_monthly FROM orders JOIN motorist on motorist.id_motorist = orders.id_motorist JOIN distributor on motorist.distributor_code = distributor.distributor_code WHERE date between '".$tanggal_bulan_awal."' AND '".$tanggal_bulan_akhir."'  AND distributor.area = '".$data_regional['area']."' AND motorist.motorist_type = '".$data_motorist_type."' ")->result_array();		
					$total_actual_daily_sales_monthly = $data_total_actual_daily_sales_monthly[0]['total_actual_daily_sales_monthly'];
					
					$total_daily_target_sales_monthly = $total_daily_target_sales * $hari_kerja; 

					if($total_actual_daily_sales<=0)
					{
						$total_actual_daily_sales = "0";
					}
					
					if($target_call>0)
					{
					$persentasi_call = ($total_call * 100) / $target_call;
					$persentasi_call = number_format($persentasi_call, 0, '.', '');	
					}
					else{
						$persentasi_call = "0";
					}
					
					
					if($total_keseluruhan>0)
					{
					$persentasi_call_monthly = ($total_call_monthly * 100) / $total_keseluruhan;
					$persentasi_call_monthly = number_format($persentasi_call_monthly, 0, '.', '');	
					}
					else
					{
						$persentasi_call_monthly = "0";
					}
					
					if($target_call >0)
					{
					$persentasi_effective_call = ($total_effective_call  * 100) / $target_call;
					$persentasi_effective_call = number_format($persentasi_effective_call, 0, '.', '');
					}
					else{
						$persentasi_effective_call  = "0";
					}
					
					if($total_keseluruhan >0)
					{
					$persentasi_effective_call_monthly = ($total_effective_call_monthly  * 100) / $total_keseluruhan;
					$persentasi_effective_call_monthly = number_format($persentasi_effective_call_monthly, 0, '.', '');
					}
					else{
						$persentasi_effective_call_monthly  = "0";
					}
					
					if($total_daily_target_sales>0)
					{
					$persentasi_target_harian = ($total_actual_daily_sales * 100) / $total_daily_target_sales;
					$persentasi_target_harian = number_format($persentasi_target_harian, 0, '.', '');
					}
					else
					{
						$persentasi_target_harian = "0";
					}
					
					
					if($total_daily_target_sales_monthly>0)
					{
					$persentasi_target_bulanan = ($total_actual_daily_sales_monthly * 100) / $total_daily_target_sales_monthly;
					$persentasi_target_bulanan = number_format($persentasi_target_bulanan, 0, '.', '');
					}
					else
					{
						$persentasi_target_bulanan = "0";
					}
					
					if($total_actual_daily_sales_monthly<=0)
					{
						$total_actual_daily_sales_monthly=0;
					}
									
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $row, $target_call);
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $row, $total_call);
					
					if($persentasi_call>95)
			{
				$objPHPExcel->getActiveSheet()->getStyle("D".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('D'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => '099f3e')
						)
					 ) 
					 );
					 
				}
			else if($persentasi_call<90)
			{
				$objPHPExcel->getActiveSheet()->getStyle("D".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('D'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => 'fa364d')
						)
					 ) 
					 );
					 
			}
			
			
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $row, $persentasi_call." %");
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $row, $total_effective_call);
					
					if($persentasi_effective_call>95)
			{
				$objPHPExcel->getActiveSheet()->getStyle("F".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('F'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => '099f3e')
						)
					 ) 
					 );
					 
				}
			else if($persentasi_effective_call<90)
			{
				$objPHPExcel->getActiveSheet()->getStyle("F".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('F'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => 'fa364d')
						)
					 ) 
					 );
					 
			}
			
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, $row, $persentasi_effective_call." %");
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, $row, "Rp. ".number_format($total_daily_target_sales, 0 , '' , '.' ));
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, $row, "Rp. ".number_format($total_actual_daily_sales, 0 , '' , '.' ));
					
					if($persentasi_target_harian>100)
			{
				$objPHPExcel->getActiveSheet()->getStyle("I".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('I'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => '099f3e')
						)
					 ) 
					 );
					 
				}
			else if($persentasi_target_harian<100)
			{
				$objPHPExcel->getActiveSheet()->getStyle("I".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('I'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => 'fa364d')
						)
					 ) 
					 );
					 
			}
			
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8, $row, $persentasi_target_harian." %");
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9, $row, $total_keseluruhan);
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(10, $row, $total_call_monthly);
					if($persentasi_call_monthly>95)
			{
				$objPHPExcel->getActiveSheet()->getStyle("L".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('L'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => '099f3e')
						)
					 ) 
					 );
					 
				}
			else if($persentasi_call_monthly<90)
			{
				$objPHPExcel->getActiveSheet()->getStyle("L".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('L'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => 'fa364d')
						)
					 ) 
					 );
					 
			}
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(11, $row, $persentasi_call_monthly." %");
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(12, $row, $total_effective_call_monthly);
					
					if($persentasi_effective_call_monthly>95)
			{
				$objPHPExcel->getActiveSheet()->getStyle("N".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('N'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => '099f3e')
						)
					 ) 
					 );
					 
				}
			else if($persentasi_effective_call_monthly<90)
			{
				$objPHPExcel->getActiveSheet()->getStyle("N".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('N'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => 'fa364d')
						)
					 ) 
					 );
					 
			}
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(13, $row, $persentasi_effective_call_monthly." %");
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(14, $row, "Rp. ".number_format($total_daily_target_sales_monthly, 0 , '' , '.' ));
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(15, $row, "Rp. ".number_format($total_actual_daily_sales_monthly, 0 , '' , '.' ));
					
					if($persentasi_effective_call_monthly>$timerate)
			{
				$objPHPExcel->getActiveSheet()->getStyle("Q".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('Q'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => '099f3e')
						)
					 ) 
					 );
					 
				}
			else if($persentasi_effective_call_monthly<$timerate)
			{
				$objPHPExcel->getActiveSheet()->getStyle("Q".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('Q'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => 'fa364d')
						)
					 ) 
					 );
					 
			}
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(16, $row, $persentasi_target_bulanan." %");
					//Monthly
					$data_total_outlet_register = $this->db->query("SELECT COUNT(customer_code) as total_outlet_register FROM store WHERE area = '".$data_regional['area']."' AND store.motorist_type = '".$data_motorist_type."'  ")->result_array();		
					$total_outlet_register = $data_total_outlet_register[0]['total_outlet_register'];
					
					//Monthly
					$total_outlet_active = $this->db->query("SELECT id_order FROM orders JOIN motorist on motorist.id_motorist = orders.id_motorist JOIN distributor on motorist.distributor_code = distributor.distributor_code WHERE distributor.area = '".$data_regional['area']."' AND  date between '2016-".$bulan."-01 00:00:00' AND '2016-".$bulan."-31 23:59:59' AND motorist.motorist_type = '".$data_motorist_type."' group by customer_code")->num_rows();		
					
					
					$data_outlet_switching = $this->db->query("SELECT COUNT(id_noo) as total_outlet_switching FROM noo JOIN distributor on noo.distributor_code = distributor.distributor_code JOIN motorist on noo.motorist_code = motorist.motorist_code AND noo.distributor_code = motorist.distributor_code  WHERE distributor.area = '".$data_regional['area']."' AND customer_create_date between '".$year."-".$bulan."-01 00:00:00'  AND '".$year."-".$bulan."-31 00:00:00' AND product = 'Bukan_Carnation' AND motorist.motorist_code = '2' ")->result_array();		
					$total_outlet_switching = $data_outlet_switching[0]['total_outlet_switching'];
					
					$total_motorist = $this->db->query("SELECT * FROM motorist join distributor on distributor.distributor_code = motorist.distributor_code WHERE distributor.area = '".$data_regional['area']."' AND motorist.motorist_type = '".$data_motorist_type."'  ")->num_rows();
					$total_motorist = $total_motorist * 10;
					
					if($total_outlet_switching<=0)
					{$total_outlet_switching = '0'; }
					
					
					if($total_motorist>0)
					{
					$persentasi_outlet_switching = ($total_outlet_switching * 100) / $total_motorist;
					$persentasi_outlet_switching = number_format($persentasi_outlet_switching, 0, '.', '');
					}
					else
					{
						$persentasi_outlet_switching = "0";
					}
					
					
					if($total_outlet_register>0)
					{
					$persentasi_outlet_active = ($total_outlet_active * 100) / $total_outlet_register;
					$persentasi_outlet_active = number_format($persentasi_outlet_active, 0, '.', '');
					}
					else
					{
						$persentasi_outlet_active = "0";
					}
					
					
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(17, $row, $total_outlet_register);
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(18, $row, $total_outlet_active);
					
					if($persentasi_outlet_active>$timerate)
			{
				$objPHPExcel->getActiveSheet()->getStyle("T".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('T'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => '099f3e')
						)
					 ) 
					 );
					 
				}
			else if($persentasi_outlet_active<$timerate)
			{
				$objPHPExcel->getActiveSheet()->getStyle("T".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('T'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => 'fa364d')
						)
					 ) 
					 );
					 
			}
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(19, $row, $persentasi_outlet_active." %");
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(20, $row, $total_motorist);
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(21, $row, $total_outlet_switching);
					
					if($persentasi_outlet_switching>$timerate)
			{
				$objPHPExcel->getActiveSheet()->getStyle("W".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('W'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => '099f3e')
						)
					 ) 
					 );
					 
				}
			else if($persentasi_outlet_switching<$timerate)
			{
				$objPHPExcel->getActiveSheet()->getStyle("W".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('W'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => 'fa364d')
						)
					 ) 
					 );
					 
			}
			
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(22, $row, $persentasi_outlet_switching." %");
					$row++;
				
				
				
				
			// Distributor
			$data_distributor_level = $this->db->query("SELECT * FROM distributor WHERE area = '".$data_regional['area']."' ");
			foreach($data_distributor_level->result_array() as $data_level_distributor)
			{
				
				$objPHPExcel->getActiveSheet()->getStyle('A'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => 'f2c566')
						)
					 ) 
			);
			
				
						//Distributor
					
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $row, $data_level_distributor['distributor_name']);			
					
					$data_target_call = $this->db->query("SELECT COUNT(customer_code) as target_call FROM store WHERE day_visit = '".$day."' AND distributor_code = '".$data_level_distributor['distributor_code']."' AND motorist_type = '".$data_motorist_type."' ")->result_array();		
					$target_call = $data_target_call[0]['target_call'];
					
									$total_store_keseluruhan = 0;
									
									$store_senin = $this->db->query("SELECT id_store FROM store WHERE distributor_code = '".$data_level_distributor['distributor_code']."' AND day_visit = 'monday' AND motorist_type = '".$data_motorist_type."' ")->num_rows();
									//echo "store_senin".$store_senin."<br>";
									$total_store_senin = $total_senin * $store_senin;
									$store_selasa = $this->db->query("SELECT id_store FROM store WHERE distributor_code = '".$data_level_distributor['distributor_code']."' AND day_visit = 'tuesday' AND motorist_type = '".$data_motorist_type."' ")->num_rows();
									//echo "store_selasa".$store_selasa."<br>";
									$total_store_selasa = $total_selasa * $store_selasa;
									$store_rabu = $this->db->query("SELECT id_store FROM store WHERE distributor_code = '".$data_level_distributor['distributor_code']."' AND day_visit = 'wednesday' AND motorist_type = '".$data_motorist_type."' ")->num_rows();
									$total_store_rabu = $total_rabu * $store_rabu;
									//echo "store_rabu".$store_rabu."<br>";
									$store_kamis = $this->db->query("SELECT id_store FROM store WHERE distributor_code = '".$data_level_distributor['distributor_code']."' AND day_visit = 'thursday' AND motorist_type = '".$data_motorist_type."' ")->num_rows();
									$total_store_kamis = $total_kamis * $store_kamis;
									//echo "store_kamis".$store_kamis."<br>";
									$store_jumat = $this->db->query("SELECT id_store FROM store WHERE distributor_code = '".$data_level_distributor['distributor_code']."' AND day_visit = 'friday' AND motorist_type = '".$data_motorist_type."' ")->num_rows();
									$total_store_jumat = $total_jumat * $store_jumat;
									//echo "store_jumat".$store_jumat."<br>";
									$store_sabtu = $this->db->query("SELECT id_store FROM store WHERE distributor_code = '".$data_level_distributor['distributor_code']."' AND day_visit = 'saturday' AND motorist_type = '".$data_motorist_type."' ")->num_rows();
									$total_store_sabtu = $total_sabtu * $store_sabtu;
									//echo "store_sabtu".$store_sabtu."<br>";
									$total_keseluruhan = $total_store_senin+$total_store_selasa+$total_store_rabu+$total_store_kamis+$total_store_jumat+$total_store_sabtu;

					$data_total_call = $this->db->query("SELECT COUNT(customer_code) as total_call FROM visit JOIN motorist on motorist.id_motorist = visit.id_motorist JOIN distributor on motorist.distributor_code = distributor.distributor_code  WHERE distributor.distributor_code = '".$data_level_distributor['distributor_code']."' AND  status_visit = 'call' AND time_stamp_visit LIKE '%".$date_yesterday."%' AND motorist.motorist_type = '".$data_motorist_type."' ")->result_array();		
					$total_call = $data_total_call[0]['total_call'];
					
					$data_total_call_monthly = $this->db->query("SELECT COUNT(customer_code) as total_call_monthly FROM visit JOIN motorist on motorist.id_motorist = visit.id_motorist JOIN distributor on motorist.distributor_code = distributor.distributor_code WHERE distributor.distributor_code = '".$data_level_distributor['distributor_code']."' AND status_visit = 'call' AND time_stamp_visit between '".$tanggal_bulan_awal."' AND '".$tanggal_bulan_akhir."' AND motorist.motorist_type = '".$data_motorist_type."' ")->result_array();		
					$total_call_monthly = $data_total_call_monthly[0]['total_call_monthly'];
					
					$data_total_effective_call = $this->db->query("SELECT COUNT(customer_code) as total_effective_call FROM visit JOIN motorist on motorist.id_motorist = visit.id_motorist JOIN distributor on motorist.distributor_code = distributor.distributor_code  WHERE distributor.distributor_code = '".$data_level_distributor['distributor_code']."' AND status_order = 'order' AND  status_visit = 'call' AND time_stamp_visit LIKE '%".$date_yesterday."%' AND motorist.motorist_type = '".$data_motorist_type."' ")->result_array();		
					$total_effective_call = $data_total_effective_call[0]['total_effective_call'];
					
					$data_total_effective_call_monthly = $this->db->query("SELECT COUNT(customer_code) as total_effective_call_monthly FROM visit JOIN motorist on motorist.id_motorist = visit.id_motorist JOIN distributor on motorist.distributor_code = distributor.distributor_code  WHERE distributor.distributor_code = '".$data_level_distributor['distributor_code']."' AND status_order = 'order' AND  status_visit = 'call' AND time_stamp_visit between '".$tanggal_bulan_awal."' AND '".$tanggal_bulan_akhir."' AND motorist.motorist_type = '".$data_motorist_type."' ")->result_array();		
					$total_effective_call_monthly = $data_total_effective_call_monthly[0]['total_effective_call_monthly'];
					
					
					$data_total_target_sales = $this->db->query("SELECT SUM(target_harian) as target_harian FROM motorist JOIN distributor on motorist.distributor_code = distributor.distributor_code  WHERE distributor.distributor_code = '".$data_level_distributor['distributor_code']."' AND motorist.motorist_type = '".$data_motorist_type."' ")->result_array();		
					$total_daily_target_sales = $data_total_target_sales[0]['target_harian'];
					
					
					
					if($total_daily_target_sales<=0)
					{
						$total_daily_target_sales = "0";
					}
					
					$data_total_actual_daily_sales = $this->db->query("SELECT SUM(total_order) as total_actual_daily_sales FROM orders JOIN motorist on motorist.id_motorist = orders.id_motorist JOIN distributor on motorist.distributor_code = distributor.distributor_code WHERE  date LIKE '%".$date_yesterday."%' AND distributor.distributor_code = '".$data_level_distributor['distributor_code']."' AND motorist.motorist_type = '".$data_motorist_type."' ")->result_array();		
					$total_actual_daily_sales = $data_total_actual_daily_sales[0]['total_actual_daily_sales'];
					
					
					$data_total_actual_daily_sales_monthly = $this->db->query("SELECT SUM(total_order) as total_actual_daily_sales_monthly FROM orders JOIN motorist on motorist.id_motorist = orders.id_motorist JOIN distributor on motorist.distributor_code = distributor.distributor_code WHERE date between '".$tanggal_bulan_awal."' AND '".$tanggal_bulan_akhir."'  AND distributor.distributor_code = '".$data_level_distributor['distributor_code']."' AND motorist.motorist_type = '".$data_motorist_type."' ")->result_array();		
					$total_actual_daily_sales_monthly = $data_total_actual_daily_sales_monthly[0]['total_actual_daily_sales_monthly'];
					
					$total_daily_target_sales_monthly = $total_daily_target_sales * $hari_kerja; 

					if($total_actual_daily_sales<=0)
					{
						$total_actual_daily_sales = "0";
					}
					
					if($target_call>0)
					{
					$persentasi_call = ($total_call * 100) / $target_call;
					$persentasi_call = number_format($persentasi_call, 0, '.', '');	
					}
					else{
						$persentasi_call = "0";
					}
					
					
					if($total_keseluruhan>0)
					{
					$persentasi_call_monthly = ($total_call_monthly * 100) / $total_keseluruhan;
					$persentasi_call_monthly = number_format($persentasi_call_monthly, 0, '.', '');	
					}
					else
					{
						$persentasi_call_monthly = "0";
					}
					
					if($target_call >0)
					{
					$persentasi_effective_call = ($total_effective_call  * 100) / $target_call;
					$persentasi_effective_call = number_format($persentasi_effective_call, 0, '.', '');
					}
					else{
						$persentasi_effective_call  = "0";
					}
					
					if($total_keseluruhan >0)
					{
					$persentasi_effective_call_monthly = ($total_effective_call_monthly  * 100) / $total_keseluruhan;
					$persentasi_effective_call_monthly = number_format($persentasi_effective_call_monthly, 0, '.', '');
					}
					else{
						$persentasi_effective_call_monthly  = "0";
					}
					
					if($total_daily_target_sales>0)
					{
					$persentasi_target_harian = ($total_actual_daily_sales * 100) / $total_daily_target_sales;
					$persentasi_target_harian = number_format($persentasi_target_harian, 0, '.', '');
					}
					else
					{
						$persentasi_target_harian = "0";
					}
					
					
					if($total_daily_target_sales_monthly>0)
					{
					$persentasi_target_bulanan = ($total_actual_daily_sales_monthly * 100) / $total_daily_target_sales_monthly;
					$persentasi_target_bulanan = number_format($persentasi_target_bulanan, 0, '.', '');
					}
					else
					{
						$persentasi_target_bulanan = "0";
					}
					
					if($total_actual_daily_sales_monthly<=0)
					{
						$total_actual_daily_sales_monthly=0;
					}
									
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $row, $target_call);
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $row, $total_call);
					
					if($persentasi_call>95)
			{
				$objPHPExcel->getActiveSheet()->getStyle("D".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('D'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => '099f3e')
						)
					 ) 
					 );
					 
				}
			else if($persentasi_call<90)
			{
				$objPHPExcel->getActiveSheet()->getStyle("D".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('D'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => 'fa364d')
						)
					 ) 
					 );
					 
			}
			
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $row, $persentasi_call." %");
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $row, $total_effective_call);
					
					if($persentasi_effective_call>95)
			{
				$objPHPExcel->getActiveSheet()->getStyle("F".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('F'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => '099f3e')
						)
					 ) 
					 );
					 
				}
			else if($persentasi_effective_call<90)
			{
				$objPHPExcel->getActiveSheet()->getStyle("F".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('F'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => 'fa364d')
						)
					 ) 
					 );
					 
			}
			
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, $row, $persentasi_effective_call." %");
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, $row, "Rp. ".number_format($total_daily_target_sales, 0 , '' , '.' ));
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, $row, "Rp. ".number_format($total_actual_daily_sales, 0 , '' , '.' ));
					if($persentasi_target_harian>100)
			{
				$objPHPExcel->getActiveSheet()->getStyle("I".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('I'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => '099f3e')
						)
					 ) 
					 );
					 
				}
			else if($persentasi_target_harian<100)
			{
				$objPHPExcel->getActiveSheet()->getStyle("I".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('I'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => 'fa364d')
						)
					 ) 
					 );
					 
			}
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8, $row, $persentasi_target_harian." %");
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9, $row, $total_keseluruhan);
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(10, $row, $total_call_monthly);
					if($persentasi_call_monthly>95)
			{
				$objPHPExcel->getActiveSheet()->getStyle("L".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('L'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => '099f3e')
						)
					 ) 
					 );
					 
				}
			else if($persentasi_call_monthly<90)
			{
				$objPHPExcel->getActiveSheet()->getStyle("L".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('L'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => 'fa364d')
						)
					 ) 
					 );
					 
			}
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(11, $row, $persentasi_call_monthly." %");
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(12, $row, $total_effective_call_monthly);
					
					if($persentasi_effective_call_monthly>95)
			{
				$objPHPExcel->getActiveSheet()->getStyle("N".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('N'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => '099f3e')
						)
					 ) 
					 );
					 
				}
			else if($persentasi_effective_call_monthly<90)
			{
				$objPHPExcel->getActiveSheet()->getStyle("N".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('N'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => 'fa364d')
						)
					 ) 
					 );
					 
			}
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(13, $row, $persentasi_effective_call_monthly." %");
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(14, $row, "Rp. ".number_format($total_daily_target_sales_monthly, 0 , '' , '.' ));
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(15, $row, "Rp. ".number_format($total_actual_daily_sales_monthly, 0 , '' , '.' ));
					
					if($persentasi_effective_call_monthly>$timerate)
			{
				$objPHPExcel->getActiveSheet()->getStyle("Q".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('Q'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => '099f3e')
						)
					 ) 
					 );
					 
				}
			else if($persentasi_effective_call_monthly<$timerate)
			{
				$objPHPExcel->getActiveSheet()->getStyle("Q".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('Q'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => 'fa364d')
						)
					 ) 
					 );
					 
			}
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(16, $row, $persentasi_target_bulanan." %");
					//Monthly
					$data_total_outlet_register = $this->db->query("SELECT COUNT(customer_code) as total_outlet_register FROM store WHERE distributor_code = '".$data_level_distributor['distributor_code']."' AND store.motorist_type = '".$data_motorist_type."'  ")->result_array();		
					$total_outlet_register = $data_total_outlet_register[0]['total_outlet_register'];
					
					//Monthly
					$total_outlet_active = $this->db->query("SELECT id_order FROM orders JOIN motorist on motorist.id_motorist = orders.id_motorist JOIN distributor on motorist.distributor_code = distributor.distributor_code WHERE distributor.distributor_code = '".$data_level_distributor['distributor_code']."' AND  date between '2016-".$bulan."-01 00:00:00' AND '2016-".$bulan."-31 23:59:59' AND motorist.motorist_type = '".$data_motorist_type."' group by customer_code")->num_rows();		
					
					
					$data_outlet_switching = $this->db->query("SELECT COUNT(id_noo) as total_outlet_switching FROM noo JOIN distributor on noo.distributor_code = distributor.distributor_code JOIN motorist on noo.motorist_code = motorist.motorist_code AND noo.distributor_code = motorist.distributor_code  WHERE distributor.distributor_code = '".$data_level_distributor['distributor_code']."' AND customer_create_date between '".$year."-".$bulan."-01 00:00:00'  AND '".$year."-".$bulan."-31 00:00:00' AND product = 'Bukan_Carnation' AND motorist.motorist_code = '2'  ")->result_array();		
					$total_outlet_switching = $data_outlet_switching[0]['total_outlet_switching'];
					
					$total_motorist = $this->db->query("SELECT * FROM motorist join distributor on distributor.distributor_code = motorist.distributor_code WHERE distributor.distributor_code = '".$data_level_distributor['distributor_code']."' AND motorist.motorist_type = '".$data_motorist_type."'  ")->num_rows();
					$total_motorist = $total_motorist * 10;
					
					if($total_outlet_switching<=0)
					{$total_outlet_switching = '0'; }
					
					
					if($total_motorist>0)
					{
					$persentasi_outlet_switching = ($total_outlet_switching * 100) / $total_motorist;
					$persentasi_outlet_switching = number_format($persentasi_outlet_switching, 0, '.', '');
					}
					else
					{
						$persentasi_outlet_switching = "0";
					}
					
					
					if($total_outlet_register>0)
					{
					$persentasi_outlet_active = ($total_outlet_active * 100) / $total_outlet_register;
					$persentasi_outlet_active = number_format($persentasi_outlet_active, 0, '.', '');
					}
					else
					{
						$persentasi_outlet_active = "0";
					}
					
					
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(17, $row, $total_outlet_register);
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(18, $row, $total_outlet_active);
					
					if($persentasi_outlet_active>$timerate)
			{
				$objPHPExcel->getActiveSheet()->getStyle("T".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('T'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => '099f3e')
						)
					 ) 
					 );
					 
				}
			else if($persentasi_outlet_active<$timerate)
			{
				$objPHPExcel->getActiveSheet()->getStyle("T".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('T'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => 'fa364d')
						)
					 ) 
					 );
					 
			}
			
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(19, $row, $persentasi_outlet_active." %");
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(20, $row, $total_motorist);
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(21, $row, $total_outlet_switching);
					
					if($persentasi_outlet_switching>$timerate)
			{
				$objPHPExcel->getActiveSheet()->getStyle("W".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('W'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => '099f3e')
						)
					 ) 
					 );
					 
				}
			else if($persentasi_outlet_switching<$timerate)
			{
				$objPHPExcel->getActiveSheet()->getStyle("W".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('W'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => 'fa364d')
						)
					 ) 
					 );
					 
			}
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(22, $row, $persentasi_outlet_switching." %");
					$row++;
					
					
					
					
					// Motorist
			$data_motorist_level = $this->db->query("SELECT * FROM motorist WHERE distributor_code = '".$data_level_distributor['distributor_code']."' AND motorist_type = '".$data_motorist_type."' ");
			foreach($data_motorist_level->result_array() as $data_level_motorist)
			{
				
					$objPHPExcel->getActiveSheet()->getStyle('A'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => 'a0fff9')
						)
					 ) 
			);
			
				
						//Distributor
					
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $row, $data_level_motorist['motorist_name'].'-'.$data_level_motorist['motorist_code']);			
					
					$data_target_call = $this->db->query("SELECT COUNT(customer_code) as target_call FROM store WHERE day_visit = '".$day."' AND distributor_code = '".$data_level_motorist['distributor_code']."' AND motorist_code = '".$data_level_motorist['motorist_code']."' ")->result_array();		
					$target_call = $data_target_call[0]['target_call'];
					
									$total_store_keseluruhan = 0;
									
									$store_senin = $this->db->query("SELECT id_store FROM store WHERE distributor_code = '".$data_level_motorist['distributor_code']."' AND motorist_code = '".$data_level_motorist['motorist_code']."' AND day_visit = 'monday' ")->num_rows();
									//echo "store_senin".$store_senin."<br>";
									$total_store_senin = $total_senin * $store_senin;
									$store_selasa = $this->db->query("SELECT id_store FROM store WHERE distributor_code = '".$data_level_motorist['distributor_code']."' AND motorist_code = '".$data_level_motorist['motorist_code']."' AND day_visit = 'tuesday' ")->num_rows();
									//echo "store_selasa".$store_selasa."<br>";
									$total_store_selasa = $total_selasa * $store_selasa;
									$store_rabu = $this->db->query("SELECT id_store FROM store WHERE distributor_code = '".$data_level_motorist['distributor_code']."' AND motorist_code = '".$data_level_motorist['motorist_code']."' AND day_visit = 'wednesday' ")->num_rows();
									$total_store_rabu = $total_rabu * $store_rabu;
									//echo "store_rabu".$store_rabu."<br>";
									$store_kamis = $this->db->query("SELECT id_store FROM store WHERE distributor_code = '".$data_level_motorist['distributor_code']."' AND motorist_code = '".$data_level_motorist['motorist_code']."' AND day_visit = 'thursday' ")->num_rows();
									$total_store_kamis = $total_kamis * $store_kamis;
									//echo "store_kamis".$store_kamis."<br>";
									$store_jumat = $this->db->query("SELECT id_store FROM store WHERE distributor_code = '".$data_level_motorist['distributor_code']."' AND motorist_code = '".$data_level_motorist['motorist_code']."' AND day_visit = 'friday' ")->num_rows();
									$total_store_jumat = $total_jumat * $store_jumat;
									//echo "store_jumat".$store_jumat."<br>";
									$store_sabtu = $this->db->query("SELECT id_store FROM store WHERE distributor_code = '".$data_level_motorist['distributor_code']."' AND motorist_code = '".$data_level_motorist['motorist_code']."' AND day_visit = 'saturday' ")->num_rows();
									$total_store_sabtu = $total_sabtu * $store_sabtu;
									//echo "store_sabtu".$store_sabtu."<br>";
									$total_keseluruhan = $total_store_senin+$total_store_selasa+$total_store_rabu+$total_store_kamis+$total_store_jumat+$total_store_sabtu;

					$data_total_call = $this->db->query("SELECT COUNT(customer_code) as total_call FROM visit JOIN motorist on motorist.id_motorist = visit.id_motorist JOIN distributor on motorist.distributor_code = distributor.distributor_code  WHERE distributor.distributor_code = '".$data_level_motorist['distributor_code']."' AND motorist.motorist_code = '".$data_level_motorist['motorist_code']."' AND  status_visit = 'call' AND time_stamp_visit LIKE '%".$date_yesterday."%' ")->result_array();		
					$total_call = $data_total_call[0]['total_call'];
					
					$data_total_call_monthly = $this->db->query("SELECT COUNT(customer_code) as total_call_monthly FROM visit JOIN motorist on motorist.id_motorist = visit.id_motorist JOIN distributor on motorist.distributor_code = distributor.distributor_code WHERE distributor.distributor_code = '".$data_level_motorist['distributor_code']."' AND motorist.motorist_code = '".$data_level_motorist['motorist_code']."' AND status_visit = 'call' AND time_stamp_visit between '".$tanggal_bulan_awal."' AND '".$tanggal_bulan_akhir."'")->result_array();		
					$total_call_monthly = $data_total_call_monthly[0]['total_call_monthly'];
					
					$data_total_effective_call = $this->db->query("SELECT COUNT(customer_code) as total_effective_call FROM visit JOIN motorist on motorist.id_motorist = visit.id_motorist JOIN distributor on motorist.distributor_code = distributor.distributor_code  WHERE distributor.distributor_code = '".$data_level_motorist['distributor_code']."' AND motorist.motorist_code = '".$data_level_motorist['motorist_code']."' AND status_order = 'order' AND  status_visit = 'call' AND time_stamp_visit LIKE '%".$date_yesterday."%' ")->result_array();		
					$total_effective_call = $data_total_effective_call[0]['total_effective_call'];
					
					$data_total_effective_call_monthly = $this->db->query("SELECT COUNT(customer_code) as total_effective_call_monthly FROM visit JOIN motorist on motorist.id_motorist = visit.id_motorist JOIN distributor on motorist.distributor_code = distributor.distributor_code  WHERE distributor.distributor_code = '".$data_level_motorist['distributor_code']."' AND motorist.motorist_code = '".$data_level_motorist['motorist_code']."' AND status_order = 'order' AND  status_visit = 'call' AND time_stamp_visit between '".$tanggal_bulan_awal."' AND '".$tanggal_bulan_akhir."' ")->result_array();		
					$total_effective_call_monthly = $data_total_effective_call_monthly[0]['total_effective_call_monthly'];
					
					
					$data_total_target_sales = $this->db->query("SELECT SUM(target_harian) as target_harian FROM motorist JOIN distributor on motorist.distributor_code = distributor.distributor_code  WHERE distributor.distributor_code = '".$data_level_motorist['distributor_code']."' AND motorist.motorist_code = '".$data_level_motorist['motorist_code']."' ")->result_array();		
					$total_daily_target_sales = $data_total_target_sales[0]['target_harian'];
					
					
					
					if($total_daily_target_sales<=0)
					{
						$total_daily_target_sales = "0";
					}
					
					$data_total_actual_daily_sales = $this->db->query("SELECT SUM(total_order) as total_actual_daily_sales FROM orders JOIN motorist on motorist.id_motorist = orders.id_motorist JOIN distributor on motorist.distributor_code = distributor.distributor_code WHERE  date LIKE '%".$date_yesterday."%' AND distributor.distributor_code = '".$data_level_motorist['distributor_code']."' AND motorist.motorist_code = '".$data_level_motorist['motorist_code']."' ")->result_array();		
					$total_actual_daily_sales = $data_total_actual_daily_sales[0]['total_actual_daily_sales'];
					
					
					$data_total_actual_daily_sales_monthly = $this->db->query("SELECT SUM(total_order) as total_actual_daily_sales_monthly FROM orders JOIN motorist on motorist.id_motorist = orders.id_motorist JOIN distributor on motorist.distributor_code = distributor.distributor_code WHERE date between '".$tanggal_bulan_awal."' AND '".$tanggal_bulan_akhir."'  AND distributor.distributor_code = '".$data_level_motorist['distributor_code']."' AND motorist.motorist_code = '".$data_level_motorist['motorist_code']."' ")->result_array();		
					$total_actual_daily_sales_monthly = $data_total_actual_daily_sales_monthly[0]['total_actual_daily_sales_monthly'];
					
					$total_daily_target_sales_monthly = $total_daily_target_sales * $hari_kerja; 

					if($total_actual_daily_sales<=0)
					{
						$total_actual_daily_sales = "0";
					}
					
					if($target_call>0)
					{
					$persentasi_call = ($total_call * 100) / $target_call;
					$persentasi_call = number_format($persentasi_call, 0, '.', '');	
					}
					else{
						$persentasi_call = "0";
					}
					
					
					if($total_keseluruhan>0)
					{
					$persentasi_call_monthly = ($total_call_monthly * 100) / $total_keseluruhan;
					$persentasi_call_monthly = number_format($persentasi_call_monthly, 0, '.', '');	
					}
					else
					{
						$persentasi_call_monthly = "0";
					}
					
					if($target_call >0)
					{
					$persentasi_effective_call = ($total_effective_call  * 100) / $target_call;
					$persentasi_effective_call = number_format($persentasi_effective_call, 0, '.', '');
					}
					else{
						$persentasi_effective_call  = "0";
					}
					
					if($total_keseluruhan >0)
					{
					$persentasi_effective_call_monthly = ($total_effective_call_monthly  * 100) / $total_keseluruhan;
					$persentasi_effective_call_monthly = number_format($persentasi_effective_call_monthly, 0, '.', '');
					}
					else{
						$persentasi_effective_call_monthly  = "0";
					}
					
					if($total_daily_target_sales>0)
					{
					$persentasi_target_harian = ($total_actual_daily_sales * 100) / $total_daily_target_sales;
					$persentasi_target_harian = number_format($persentasi_target_harian, 0, '.', '');
					}
					else
					{
						$persentasi_target_harian = "0";
					}
					
					
					if($total_daily_target_sales_monthly>0)
					{
					$persentasi_target_bulanan = ($total_actual_daily_sales_monthly * 100) / $total_daily_target_sales_monthly;
					$persentasi_target_bulanan = number_format($persentasi_target_bulanan, 0, '.', '');
					}
					else
					{
						$persentasi_target_bulanan = "0";
					}
					
					if($total_actual_daily_sales_monthly<=0)
					{
						$total_actual_daily_sales_monthly=0;
					}
									
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $row, $target_call);
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $row, $total_call);
					
					if($persentasi_call>95)
			{
				$objPHPExcel->getActiveSheet()->getStyle("D".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('D'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => '099f3e')
						)
					 ) 
					 );
					 
				}
			else if($persentasi_call<90)
			{
				$objPHPExcel->getActiveSheet()->getStyle("D".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('D'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => 'fa364d')
						)
					 ) 
					 );
					 
			}
			
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $row, $persentasi_call." %");
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $row, $total_effective_call);
					
					
					if($persentasi_effective_call>95)
			{
				$objPHPExcel->getActiveSheet()->getStyle("F".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('F'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => '099f3e')
						)
					 ) 
					 );
					 
				}
			else if($persentasi_effective_call<90)
			{
				$objPHPExcel->getActiveSheet()->getStyle("F".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('F'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => 'fa364d')
						)
					 ) 
					 );
					 
			}
			
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, $row, $persentasi_effective_call." %");
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, $row, "Rp. ".number_format($total_daily_target_sales, 0 , '' , '.' ));
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, $row, "Rp. ".number_format($total_actual_daily_sales, 0 , '' , '.' ));
					
					if($persentasi_target_harian>100)
			{
				$objPHPExcel->getActiveSheet()->getStyle("I".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('I'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => '099f3e')
						)
					 ) 
					 );
					 
				}
			else if($persentasi_target_harian<100)
			{
				$objPHPExcel->getActiveSheet()->getStyle("I".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('I'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => 'fa364d')
						)
					 ) 
					 );
					 
			}
			
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8, $row, $persentasi_target_harian." %");
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9, $row, $total_keseluruhan);
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(10, $row, $total_call_monthly);
					if($persentasi_call_monthly>95)
			{
				$objPHPExcel->getActiveSheet()->getStyle("L".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('L'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => '099f3e')
						)
					 ) 
					 );
					 
				}
			else if($persentasi_call_monthly<90)
			{
				$objPHPExcel->getActiveSheet()->getStyle("L".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('L'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => 'fa364d')
						)
					 ) 
					 );
					 
			}
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(11, $row, $persentasi_call_monthly." %");
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(12, $row, $total_effective_call_monthly);
					if($persentasi_effective_call_monthly>95)
			{
				$objPHPExcel->getActiveSheet()->getStyle("N".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('N'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => '099f3e')
						)
					 ) 
					 );
					 
				}
			else if($persentasi_effective_call_monthly<90)
			{
				$objPHPExcel->getActiveSheet()->getStyle("N".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('N'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => 'fa364d')
						)
					 ) 
					 );
					 
			}
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(13, $row, $persentasi_effective_call_monthly." %");
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(14, $row, "Rp. ".number_format($total_daily_target_sales_monthly, 0 , '' , '.' ));
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(15, $row, "Rp. ".number_format($total_actual_daily_sales_monthly, 0 , '' , '.' ));
					
					if($persentasi_effective_call_monthly>$timerate)
			{
				$objPHPExcel->getActiveSheet()->getStyle("Q".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('Q'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => '099f3e')
						)
					 ) 
					 );
					 
				}
			else if($persentasi_effective_call_monthly<$timerate)
			{
				$objPHPExcel->getActiveSheet()->getStyle("Q".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('Q'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => 'fa364d')
						)
					 ) 
					 );
					 
			}
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(16, $row, $persentasi_target_bulanan." %");
					//Monthly
					$data_total_outlet_register = $this->db->query("SELECT COUNT(customer_code) as total_outlet_register FROM store WHERE distributor_code = '".$data_level_motorist['distributor_code']."' AND motorist_code = '".$data_level_motorist['motorist_code']."'  ")->result_array();		
					$total_outlet_register = $data_total_outlet_register[0]['total_outlet_register'];
					
					//Monthly
					$total_outlet_active = $this->db->query("SELECT id_order FROM orders JOIN motorist on motorist.id_motorist = orders.id_motorist JOIN distributor on motorist.distributor_code = distributor.distributor_code WHERE distributor.distributor_code = '".$data_level_motorist['distributor_code']."' AND motorist.motorist_code = '".$data_level_motorist['motorist_code']."' AND  date between '2016-".$bulan."-01 00:00:00' AND '2016-".$bulan."-31 23:59:59' group by customer_code")->num_rows();		
					
					
					$data_outlet_switching = $this->db->query("SELECT COUNT(id_noo) as total_outlet_switching FROM noo JOIN distributor on noo.distributor_code = distributor.distributor_code WHERE distributor.distributor_code = '".$data_level_motorist['distributor_code']."' AND noo.motorist_code = '".$data_level_motorist['motorist_code']."' AND customer_create_date between '".$year."-".$bulan."-01 00:00:00'  AND '".$year."-".$bulan."-31 00:00:00' AND product = 'Bukan_Carnation' ")->result_array();		
					$total_outlet_switching = $data_outlet_switching[0]['total_outlet_switching'];
					
					//$total_motorist = $this->db->query("SELECT * FROM motorist join distributor on distributor.distributor_code = motorist.distributor_code WHERE distributor.distributor_code = '".$data_level_distributor['distributor_code']."'  ")->num_rows();
					$total_motorist =  10;
					
					if($total_outlet_switching<=0)
					{$total_outlet_switching = '0'; }
					
					
					if($total_motorist>0)
					{
					$persentasi_outlet_switching = ($total_outlet_switching * 100) / $total_motorist;
					$persentasi_outlet_switching = number_format($persentasi_outlet_switching, 0, '.', '');
					}
					else
					{
						$persentasi_outlet_switching = "0";
					}
					
					
					if($total_outlet_register>0)
					{
					$persentasi_outlet_active = ($total_outlet_active * 100) / $total_outlet_register;
					$persentasi_outlet_active = number_format($persentasi_outlet_active, 0, '.', '');
					}
					else
					{
						$persentasi_outlet_active = "0";
					}
					
					
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(17, $row, $total_outlet_register);
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(18, $row, $total_outlet_active);
					if($persentasi_outlet_active>$timerate)
			{
				$objPHPExcel->getActiveSheet()->getStyle("T".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('T'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => '099f3e')
						)
					 ) 
					 );
					 
				}
			else if($persentasi_outlet_active<$timerate)
			{
				$objPHPExcel->getActiveSheet()->getStyle("T".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('T'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => 'fa364d')
						)
					 ) 
					 );
					 
			}
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(19, $row, $persentasi_outlet_active." %");
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(20, $row, $total_motorist);
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(21, $row, $total_outlet_switching);
					
					if($persentasi_outlet_switching>$timerate)
			{
				$objPHPExcel->getActiveSheet()->getStyle("W".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('W'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => '099f3e')
						)
					 ) 
					 );
					 
				}
			else if($persentasi_outlet_switching<$timerate)
			{
				$objPHPExcel->getActiveSheet()->getStyle("W".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle('W'.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => 'fa364d')
						)
					 ) 
					 );
					 
			}
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(22, $row, $persentasi_outlet_switching." %");
					$row++;
				
			}
			// END Motorist
			
				
			}
			// END Distributor
			
			
			
			}
			// END AREA
			
			
			
		}
		
		 $last_row = $row-1;
		
	
		
		//Set Border
        $objPHPExcel->getActiveSheet()->getStyle("A6".":"."W".$last_row)->applyFromArray($BStyle);
	    $objPHPExcel->getActiveSheet()->getStyle("A5".":"."W".$last_row)->applyFromArray($styleAlign);
        $objPHPExcel->setActiveSheetIndex(0);
        $objWriter = IOFactory::createWriter($objPHPExcel, 'Excel5');
 		
		
	   // Sending headers to force the user to download the file
       // header('Content-Type: application/vnd.ms-excel');
       // header('Content-Disposition: attachment;filename="Products_'.date('dMy').'.xls"');
       // header('Cache-Control: max-age=0');
		
		
        // Sending headers to force the user to download the file        
		
        $objWriter->save('files/daily_report_'.$select_motorist_type[0]['motorist_type'].'_'.$date_now.'.xls');
		
		$list_email = $data_email['email'];
		$attachment_email = 'files/daily_report_'.$select_motorist_type[0]['motorist_type'].'_'.$date_now.'.xls';
		$message = 'Daily Report '.$select_motorist_type[0]['motorist_type'].' Tanggal '.$report_date;
		$subject = 'Daily Report '.$select_motorist_type[0]['motorist_type'].' Tanggal '.$report_date;
		$this->sendmail($list_email,$attachment_email,$message,$subject);
		

		$status_kirim_email = 'Sukses';

			
			
		$data_log = array(
		
		'date' => $date_now,
		'email' => $email_receiver,
		'status' => $status_kirim_email,
		'motorist' => $select_motorist_type[0]['motorist_type']
		
		);
		
		$this->model_report->insertData('log_report',$data_log );
		
		}
		
		else
		{
			echo"sudah kirim <br>";
			}
		
		}
		}
		else
		{
			echo"belum boleh";
			}
    }
	
	
	public function sendmail($sendmail,$attachment_email,$message,$subject)
	{
		$this->load->library('parser');
 		$this->load->library('email');
		
		
		$this->email->set_newline("\r\n");
		 
		$mail = $this->email;
		 
		$mail->from('report.daily.etools@gmail.com', 'Auto report Etools');
		$mail->to($sendmail); 
		 
		$mail->subject($subject);
		$mail->message($message);	
		$this->email->attach($attachment_email);
		$mail->send();
		
		
		echo $mail->print_debugger();
		$this->email->clear(TRUE); 
		
	}
	
}

/* End of file dashboard.php */
/* Location: ./application/controllers/admin/dashboard.php */