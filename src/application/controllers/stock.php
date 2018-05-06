<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Stock extends CI_Controller {

	function __construct()  {
 		parent::__construct();
			$this->load->library(array('PHPExcel','PHPExcel/IOFactory'));
			$this->load->model('model_account_master');
			$this->load->model('model_stock');
			$this->load->library('tank_auth');
			
	}
	
	
	
	public function summaryStock()
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
			if($data_role[0]['see_store']=='yes')
			{	
			$this->load->library('table');
			$this->load->library('pagination');
			$search = isset($_GET['search']) ? $_GET['search'] : '';
			$bulan = isset($_GET['bulan']) ? $_GET['bulan'] : '';
			$year = isset($_GET['year']) ? $_GET['year'] : '';
			
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
			$jumlah= $this->model_stock->countSummaryStock($search,$user_role,$code_role,$ket,$bulan,$year,$regional,$motorist_type,$area,$distributor);
			$config['base_url'] = base_url().'index.php/stock/summaryStock/';
			$config['total_rows'] = $jumlah;
			$config['first_link'] = 'First';
			$config['last_link'] = 'End';
			$config['next_link'] = 'Next';
			$config['prev_link'] = 'Previous';
			$config['per_page'] = 5; 	
			
			if (count($_GET) > 0) $config['suffix'] = '?' . http_build_query($_GET, '', "&");
			$config['first_url'] = $config['base_url'].'?'.http_build_query($_GET);
			$dari = $this->uri->segment('3');
			$data = $this->model_stock->dataSummaryStock($config['per_page'],$dari,$search,$user_role,$code_role,$ket,$bulan,$year,$regional,$motorist_type,$area,$distributor);
			$data_regional = $this->model_stock->getRegional()->result_array();
			$data_motorist_type = $this->model_stock->getMotoristType("WHERE id_motorist_type in (".$ket.") ")->result_array();
			$this->pagination->initialize($config);
			
			
			if($user_role=="Regional")
			{
				$data_area = $this->db->query("SELECT * FROM master_area WHERE regional = '".$code_role."' ")->result_array();
				$data_distributor = $this->model_stock->getDistributor("WHERE regional='".$code_role."' ")->result_array();
			}
			else 
			{
				$data_area = $this->db->query('SELECT * FROM master_area')->result_array();
				$data_distributor = $this->model_stock->getDistributor()->result_array();
			}
		
			$comp = array(
				
				'title' => ' Summary Stock',
				'content' => $this->load->view('summary-stock',array('data_distributor'=>$data_distributor,'data_area'=>$data_area,'data_account'=>$data_account,'data_regional'=>$data_regional,'data_motorist_type'=>$data_motorist_type,'data_stock'=>$data,'search'=>$search),true),
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
	
	
	
	
	public function exportsummaryStock()
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
		$motorist_type = isset($_GET['motorist_type']) ? $_GET['motorist_type'] : '';
		
		$distributor = isset($_GET['distributor']) ? $_GET['distributor'] : '';
		$area = isset($_GET['area']) ? $_GET['area'] : '';
		
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
		
		
		$this->db->select(" *,(SELECT SUM(stock) FROM stock as s WHERE s.id_motorist = motorist.id_motorist  AND date between '".$tanggal_bulan_awal."' AND '".$tanggal_bulan_akhir."') as total_stock_all");
		
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
		
		
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 1, "Motorist Stock");
		//Merge And Center Title
		$objPHPExcel->getActiveSheet()->mergeCells('A1:D1');
		
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 2, "Date : ".$date);
		
		//Merge And Center Date
		$objPHPExcel->getActiveSheet()->mergeCells('A2:D2');
		
		//Set Font Color Title
		$objPHPExcel->getActiveSheet()->getStyle('A1:D2')->applyFromArray($FontstyleTitle);
		
		//Set Font Color Header
		$objPHPExcel->getActiveSheet()->getStyle('B4:L4')->applyFromArray($Fontstyle);
		
		//Set Backgroung Color Header
		$objPHPExcel->getActiveSheet()->getStyle('B4:L4')->applyFromArray(
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
		
		"Regional" => "Regional",
		"Area" => "Area",
		"Kode Distributor" => "Kode Distributor",
		"Nama Distributor" => "Nama Distributor",
		"Tipe Motorist" => "Tipe Motorist",
		"Kode Motorist" => "Kode Motorist",
		"Nama Motorist" => "Nama Motorist",
		"Hari Kerja" => "Hari Kerja",
		"Total SKU" => "Total SKU",
		"Total Stock Quantity" => "Total Stock Quantity",
		"Total Harga Stock (Value)" => "Total Harga Stock (Value)"
		
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
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $row, $data['regional']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $row, $data['area']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $row, $data['distributor_code']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $row, $data['distributor_name']);
		    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, $row, $data['motorist_type']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, $row, $data['motorist_code']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, $row, $data['motorist_name']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8, $row, $hari_kerja);
			
			$total_sku = $this->db->query("SELECT * FROM stock WHERE id_motorist = '".$data['id_motorist']."' AND date between '".$year."-".$month_with_null."-01 00:00:00' AND '".$year."-".$month_with_null."-31 00:00:00' GROUP BY id_product")->num_rows();
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9, $row, $total_sku);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(10, $row, $data['total_stock_all'] );
			
									$this->db->from("stock");
							 		$this->db->where("id_motorist = '".$data['id_motorist']."' ");	
									$this->db->where("date between '".$tanggal_bulan_awal."' AND '".$tanggal_bulan_akhir."'");		
									$query = $this->db->get()->result_array();
									$total_price_day = $this->db->query("SELECT * FROM stock INNER JOIN product on product.id_product =  stock.id_product  WHERE stock.id_motorist = '".$data['id_motorist']."' AND stock.date between '".$tanggal_bulan_awal."' AND '".$tanggal_bulan_akhir."'")->result();
									$total_rupiah_all = 0;
									foreach($total_price_day as $total_price_day) {
									
									$total_rupiah = $total_price_day->stock * $total_price_day->price_pcs; 
									$total_rupiah_all = $total_rupiah + $total_rupiah_all;
									}
			
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(11, $row, number_format($total_rupiah_all, 0 , '' , '.' )  );
			
			
			$col_stock = 12;
			for ($i = 1; $i <= $total_day; $i++) {
							
			$date = $year.'-'.$month.'-'.sprintf('%02d', $i);
			$date1 = strtotime($date);
			$date2 = date("l", $date1);
			$date3 = strtolower($date2);
			$column_alpha = num2alpha($col_stock);
			$objPHPExcel->getActiveSheet()->getColumnDimension($column_alpha)->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getStyle($column_alpha.$row)->applyFromArray($Fontstyle);
			$objPHPExcel->getActiveSheet()->getStyle($column_alpha.$row)->applyFromArray($BStyle);
	    	$objPHPExcel->getActiveSheet()->getStyle($column_alpha.$row)->applyFromArray($styleAlign);
			
			if (($date3 == "sunday")) {
			
			$objPHPExcel->getActiveSheet()->getStyle($column_alpha.$row)->applyFromArray(
			 array(
				'fill' => array(
					'type' => PHPExcel_Style_Fill::FILL_SOLID,
					'color' => array('rgb' => 'fb062e')
				)
			 ) 
			 );	
			 					
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_stock, $row, "Libur");
			$col_stock++;
							
			} else {
								
			$this->db->from("stock");
			$this->db->where("id_motorist = '".$data['id_motorist']."' ");	
			$this->db->where("date LIKE '%".$year.'-'.$month_with_null.'-'.sprintf('%02d', $i)."%'");		
			$query = $this->db->get()->result_array();
			$total_sku_day = $this->db->query("SELECT * FROM stock WHERE id_motorist = '".$data['id_motorist']."' AND date LIKE '%".$year.'-'.$month_with_null.'-'.sprintf('%02d', $i)."%'")->num_rows();
			$total_price_day = $this->db->query("SELECT * FROM stock INNER JOIN product on product.id_product =  stock.id_product  WHERE stock.id_motorist = '".$data['id_motorist']."' AND stock.date LIKE '%".$year.'-'.$month_with_null.'-'.sprintf('%02d', $i)."%'")->result();
			$total_rupiah_all = 0;
			foreach($total_price_day as $total_price_day) {
			$total_rupiah = $total_price_day->stock * $total_price_day->price_pcs; 
			$total_rupiah_all = $total_rupiah + $total_rupiah_all;
			}
			if (empty($query))
			{
				$objPHPExcel->getActiveSheet()->getStyle($column_alpha.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => 'c1a300')
						)
					 ) 
					 );
					 
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_stock, $row, "Tidak Isi Stock");
				$col_stock++;
			}
			else
			{
				$objPHPExcel->getActiveSheet()->getStyle($column_alpha.$row)->applyFromArray(
					 array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => '2d7907')
						)
					 ) 
					 );
					 
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_stock, $row, $total_sku_day." SKU | ". number_format($total_rupiah_all, 0 , '' , '.' ) );
				$col_stock++;
			} 
			}
										
                        	
                            
                        
						}
			
            $row++;
			$no++;
        }
		
	   $last_row = $row-1;
	   //Set Border
       $objPHPExcel->getActiveSheet()->getStyle("B4".":"."L".$last_row)->applyFromArray($BStyle);
	   $objPHPExcel->getActiveSheet()->getStyle("B4".":"."L".$last_row)->applyFromArray($styleAlign);
       $objPHPExcel->setActiveSheetIndex(0);
 
        $objWriter = IOFactory::createWriter($objPHPExcel, 'Excel5');
 		
		
	   // Sending headers to force the user to download the file
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Motorist-stock-'.$date.'.xls"');
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