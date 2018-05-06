<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Order extends CI_Controller {

	function __construct()  {
 		parent::__construct();
			$this->load->library(array('PHPExcel','PHPExcel/IOFactory'));
			$this->load->model('model_account_master');
			$this->load->model('model_order');
			$this->load->library('tank_auth');
			
	}
	
	

	public function monthlyOrder()
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
			$date = isset($_GET['date']) ? $_GET['date'] : '';
			
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
			
			
			$product = isset($_GET['product']) ? $_GET['product'] : '';
			if(isset($_GET['product']))
			{$product = implode(",",$product);}
			
			
			if (count($_GET) > 0) $config['suffix'] = '?' . http_build_query($_GET, '', "&");
			$jumlah= $this->model_order->countOrderMonthly($search,$user_role,$code_role,$ket,$date,$regional,$motorist_type,$product,$area,$distributor);
			$config['base_url'] = base_url().'index.php/order/monthlyOrder/';
			$config['total_rows'] = $jumlah;
			$config['first_link'] = 'First';
			$config['last_link'] = 'End';
			$config['next_link'] = 'Next';
			$config['prev_link'] = 'Previous';
			$config['per_page'] = 20; 	
			
			if (count($_GET) > 0) $config['suffix'] = '?' . http_build_query($_GET, '', "&");
			$config['first_url'] = $config['base_url'].'?'.http_build_query($_GET);
				
			$dari = $this->uri->segment('3');
			$data = $this->model_order->dataOrderMonthly($config['per_page'],$dari,$search,$user_role,$code_role,$ket,$date,$regional,$motorist_type,$product,$area,$distributor);
			$data_regional = $this->model_order->getRegional()->result_array();
			$data_motorist_type = $this->model_order->getMotoristType()->result_array();
			$data_product = $this->model_order->getProduct()->result_array();
			$this->pagination->initialize($config);
			
			if($user_role=="Regional")
			{
				$data_area = $this->db->query("SELECT * FROM master_area WHERE regional = '".$code_role."' ")->result_array();
				$data_distributor = $this->model_order->getDistributor("WHERE regional='".$code_role."' ")->result_array();
			}
			else 
			{
				$data_area = $this->db->query('SELECT * FROM master_area')->result_array();
				$data_distributor = $this->model_order->getDistributor()->result_array();
			}
			
		
			$comp = array(
				
				'title' => ' Data Order',
				'content' => $this->load->view('monthly-order',array('data_distributor'=>$data_distributor,'data_area'=>$data_area,'data_product'=>$data_product,'data_account'=>$data_account,'data_regional'=>$data_regional,'data_motorist_type'=>$data_motorist_type,'data_order'=>$data,'search'=>$search),true),
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
			$data_role_etools = $this->model_account_master->getRoleEtools("WHERE id_role = '".$data_account[0]['ket']."' ")->result_array();
			$ket = $data_role_etools[0]['motorist_view'];
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
			
			
			$product = isset($_GET['product']) ? $_GET['product'] : '';
			if(isset($_GET['product']))
			{$product = implode(",",$product);}
			
			
			if (count($_GET) > 0) $config['suffix'] = '?' . http_build_query($_GET, '', "&");
			$jumlah= $this->model_order->countOrder($search,$user_role,$code_role,$ket,$date,$regional,$motorist_type,$product,$area,$distributor);
			$config['base_url'] = base_url().'index.php/order/order/';
			$config['total_rows'] = $jumlah;
			$config['first_link'] = 'First';
			$config['last_link'] = 'End';
			$config['next_link'] = 'Next';
			$config['prev_link'] = 'Previous';
			$config['per_page'] = 20; 	
			
			if (count($_GET) > 0) $config['suffix'] = '?' . http_build_query($_GET, '', "&");
			$config['first_url'] = $config['base_url'].'?'.http_build_query($_GET);
				
			$dari = $this->uri->segment('3');
			$data = $this->model_order->dataOrder($config['per_page'],$dari,$search,$user_role,$code_role,$ket,$date,$regional,$motorist_type,$product,$area,$distributor);
			$data_regional = $this->model_order->getRegional()->result_array();
			$data_motorist_type = $this->model_order->getMotoristType()->result_array();
			$data_product = $this->model_order->getProduct()->result_array();
			$this->pagination->initialize($config);
			
			if($user_role=="Regional")
			{
				$data_area = $this->db->query("SELECT * FROM master_area WHERE regional = '".$code_role."' ")->result_array();
				$data_distributor = $this->model_order->getDistributor("WHERE regional='".$code_role."' ")->result_array();
			}
			else 
			{
				$data_area = $this->db->query('SELECT * FROM master_area')->result_array();
				$data_distributor = $this->model_order->getDistributor()->result_array();
			}
			
		
			$comp = array(
				
				'title' => ' Data Order',
				'content' => $this->load->view('order',array('data_distributor'=>$data_distributor,'data_area'=>$data_area,'data_product'=>$data_product,'data_account'=>$data_account,'data_regional'=>$data_regional,'data_motorist_type'=>$data_motorist_type,'data_order'=>$data,'search'=>$search),true),
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
	
	
	
	
	
	
	
	
	public function exportOrder()
	{
		
		date_default_timezone_set('Asia/Jakarta');
		ini_set('memory_limit', '-1');
		if ($this->tank_auth->is_logged_in()) {
		$user	= $this->tank_auth->get_username();
		$data_account = $this->model_account_master->getAccount("WHERE username = '".$user."' ")->result_array();
		$data_role = $this->model_account_master->getRole("WHERE id_role = '".$data_account[0]['user_access']."' ")->result_array();
		$data_role_etools = $this->model_account_master->getRoleEtools("WHERE id_role = '".$data_account[0]['ket']."' ")->result_array();
		$ket = $data_role_etools[0]['motorist_view'];
		$search = isset($_GET['search']) ? $_GET['search'] : '';
		$date_search = isset($_GET['date']) ? $_GET['date'] : '';
		$regional = isset($_GET['regional']) ? $_GET['regional'] : '';
		$motorist_type = isset($_GET['motorist_type']) ? $_GET['motorist_type'] : '';
		
		$product = isset($_GET['product']) ? $_GET['product'] : '';
		
		$user_role = $data_account[0]['user_type'];
		$code_role = $data_account[0]['code'];
		$distributor = isset($_GET['distributor']) ? $_GET['distributor'] : '';
		$area = isset($_GET['area']) ? $_GET['area'] : '';
		
		$this->db->select(" *,master_loyalty.description as description_loyalty");
		
		
		if($data_role[0]['see_store']=='yes')
		{
			
		$date = date("m-d-Y");
		
		if($regional!="")
		{
			$this->db->where('store.regional in ('.$regional.') ');
		}
		
		if($distributor!="")
		{
			
			$this->db->where('motorist.distributor_code in ('.$distributor.') ');
		}
		if($area!="")
		{
			$this->db->where('distributor.area in ('.$area.') ');
		}
		
		if($motorist_type!="")
		{
			$this->db->where('motorist.motorist_type in ('.$motorist_type.') ');
		}
		
		
		if($product!="")
		{
			$this->db->where("product_orders.id_product in (".$product.") ");
		}
		
		$month_now = date('m');
		$year_now = date('Y');
		
		if($date_search != '')
		{
			$tanggal_range_pecah = explode(" - ", $date_search);
			$tanggal_from = $tanggal_range_pecah[0];
			$tanggal_from = explode("/", $tanggal_from);
			$tanggal_from = $tanggal_from[2].'-'.$tanggal_from[0].'-'.$tanggal_from[1];
			
			$tanggal_to = $tanggal_range_pecah[1];
			$tanggal_to = explode("/", $tanggal_to);
			$tanggal_to = $tanggal_to[2].'-'.$tanggal_to[0].'-'.$tanggal_to[1];
			
			$this->db->where("product_orders.date BETWEEN '".$tanggal_from." 00:00:00' AND '".$tanggal_to." 23:59:59' "); 
		}
		else
		{
			$this->db->where("product_orders.date BETWEEN  '".$year_now."-".$month_now."-01 00:00:00' AND '".$year_now."-".$month_now."-31 23:59:59' "); 
		}
		
		$this->db->where("motorist.motorist_type in (".$ket.") ");
		if($user_role=="Ado")
		{
		
			$this->db->where("motorist.distributor_code = '".$code_role."' ");
		}
		else if($user_role=="Regional")
		{
			
			$this->db->where("distributor.regional = '".$code_role."' ");
				
		}
		
		if($search!="")
		{
			$this->db->where("store.motorist_code LIKE '%".$search."%' ");
		}
		$this->db->where("store.customer_status = 'active' ");
		
		$this->db->join('store', 'store.customer_code = product_orders.customer_code',"LEFT");
		//$this->db->group_by('store.customer_code');
		$this->db->join('master_loyalty', 'master_loyalty.id_loyalty = store.loyalty_store',"LEFT");
		$this->db->join('product', 'product.id_product = product_orders.id_product');
		$this->db->join('motorist', 'motorist.id_motorist = product_orders.id_motorist');
		$this->db->join('distributor', 'distributor.distributor_code = motorist.distributor_code');
		$this->db->join('motorist_type', 'motorist_type.id_motorist_type = motorist.motorist_type',"LEFT");
		
		$query = $this->db->get('product_orders');
		
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
		
		"Regional" => "Regional",
		"Area" => "Area",
		"Distributor Code" => "Distributor Code",
		"Distributor Name" => "Distributor Name",
		"Motorist Code" => "Motorist Code",
		"Motorist Name" => "Motorist Name",
		"Invoice Number" => "Invoice Number",
		"Invoice Date" => "Invoice Date",
		"Customer Code" => "Customer Code",
		"Customer Name" => "Customer Name",
		"Channel" => "Channel",
		"Channel Code" => "Channel Code",
		"Loyalty Store" => "Loyalty Store",
		"Product Code" => "Product Code",
		"Product Description" => "Product Description",
		"Product Quantity (pcs/renceng)" => "Product Quantity (pcs/renceng)",
		"Gross amount" => "Gross amount"
		
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
			$invoice_detail = explode(" ",$data['date']);
			$invoice_detail = $invoice_detail[0]; 
			$invoice_detail = explode("-",$invoice_detail);
			$invoice_detail = $invoice_detail[2]."-".$invoice_detail[1]."-".$invoice_detail[0];
						  
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $row, $data['regional']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $row, $data['area']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $row, $data['distributor_code']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $row, $data['distributor_name']);
		    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $row, $data['motorist_code']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, $row, $data['motorist_name']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, $row, $data['id_product_order']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, $row, $invoice_detail);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8, $row, $data['customer_code']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9, $row, $data['customer_name']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(10, $row, $data['channel_name']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(11, $row, $data['channel_code']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(12, $row, $data['description_loyalty']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(13, $row, $data['product_code']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(14, $row, $data['sku_front_end']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(15, $row, $data['qty']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(16, $row, $data['price_total']);
 
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
        header('Content-Disposition: attachment;filename="Export-invoice-detail-'.$date.'.xls"');
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
	
	
	
	
	
	
	public function exportMonthlyOrder()
	{
		
		date_default_timezone_set('Asia/Jakarta');
		ini_set('memory_limit', '-1');
		if ($this->tank_auth->is_logged_in()) {
		$user	= $this->tank_auth->get_username();
		$data_account = $this->model_account_master->getAccount("WHERE username = '".$user."' ")->result_array();
		$data_role = $this->model_account_master->getRole("WHERE id_role = '".$data_account[0]['user_access']."' ")->result_array();
		$data_role_etools = $this->model_account_master->getRoleEtools("WHERE id_role = '".$data_account[0]['ket']."' ")->result_array();
		$ket = $data_role_etools[0]['motorist_view'];
		$search = isset($_GET['search']) ? $_GET['search'] : '';
		$date_search = isset($_GET['date']) ? $_GET['date'] : '';
		$regional = isset($_GET['regional']) ? $_GET['regional'] : '';
		$motorist_type = isset($_GET['motorist_type']) ? $_GET['motorist_type'] : '';
		$distributor = isset($_GET['distributor']) ? $_GET['distributor'] : '';
		$area = isset($_GET['area']) ? $_GET['area'] : '';
		
		$product = isset($_GET['product']) ? $_GET['product'] : '';
		
		$user_role = $data_account[0]['user_type'];
		$code_role = $data_account[0]['code'];
		if($data_role[0]['see_store']=='yes')
		{
			
		$date = date("m-d-Y");
		
		$this->db->where("motorist.motorist_type in (".$ket.") ");
		if($user_role=="Ado")
		{
		
			$this->db->where("motorist.distributor_code = '".$code_role."' ");
		}
		else if($user_role=="Regional")
		{
			
			$this->db->where("distributor.regional = '".$code_role."' ");
				
		}
		if($regional!="")
		{
			$this->db->where('distributor.regional in ('.$regional.') ');
		}
		
		if($search!="")
		{
			$this->db->where("store.motorist_code LIKE '%".$search."%' ");
		}
		
		if($distributor!="")
		{
			
			$this->db->where('motorist.distributor_code in ('.$distributor.') ');
		}
		
		if($area!="")
		{
			$this->db->where('distributor.area in ('.$area.') ');
		}
		
		
		
		if($motorist_type!="")
		{
			$this->db->where('motorist.motorist_type in ('.$motorist_type.') ');
		}
		//$this->db->where("product_orders.id_product in (1,41) ");
		
		if($product!="")
		{
			$this->db->where("product_orders.id_product in (".$product.") ");
		}
		
		$month_now = date('m');
		$year_now = date('Y');
		if($date_search != '')
		{
			$tanggal_range_pecah = explode(" - ", $date_search);
			$tanggal_from = $tanggal_range_pecah[0];
			$tanggal_from = explode("/", $tanggal_from);
			$tanggal_from = $tanggal_from[2].'-'.$tanggal_from[0].'-'.$tanggal_from[1];
			
			$tanggal_to = $tanggal_range_pecah[1];
			$tanggal_to = explode("/", $tanggal_to);
			$tanggal_to = $tanggal_to[2].'-'.$tanggal_to[0].'-'.$tanggal_to[1];
			
			$this->db->where("product_orders.date BETWEEN '".$tanggal_from." 00:00:00' AND '".$tanggal_to." 23:59:59' "); 
			
			
	
		}
		else
		{
			$tanggal_from = $year_now.'-'.$month_now.'-01';
			$tanggal_to = $year_now.'-'.$month_now.'-31';
			$this->db->where("product_orders.date BETWEEN  '".$year_now."-".$month_now."-01 00:00:00' AND '".$year_now."-".$month_now."-31 23:59:59' "); 
			}
		
		
	
	
		$this->db->where("store.customer_status = 'active' ");
		
		
		$this->db->join('product', 'product.id_product = product_orders.id_product');
		$this->db->join('motorist', 'motorist.id_motorist = product_orders.id_motorist');
		
		$this->db->join('distributor', 'distributor.distributor_code = motorist.distributor_code');
		$this->db->join('store', 'store.customer_code = product_orders.customer_code');
		$this->db->group_by('product_orders.customer_code');
		$this->db->group_by('product_orders.id_product');
		$this->db->join('motorist_type', 'motorist_type.id_motorist_type = motorist.motorist_type','left');
		$query = $this->db->get('product_orders');
		
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
		$objPHPExcel->getActiveSheet()->getStyle('A1:M1')->applyFromArray(
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
		
		"Regional" => "Regional",
		"Area" => "Area",
		"Distributor Code" => "Distributor Code",
		"Distributor Name" => "Distributor Name",
		"Motorist Code" => "Motorist Code",
		"Motorist Name" => "Motorist Name",
		"Customer Code" => "Customer Code",
		"Customer Name" => "Customer Name",
		"Channel" => "Channel",
		"Product Code" => "Product Code",
		"Product Description" => "Product Description",
		"Product Quantity (pcs/renceng)" => "Product Quantity (pcs/renceng)",
		"Gross amount" => "Gross amount"
		
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
			
			$invoice_detail = explode(" ",$data['date']);
			$invoice_detail = $invoice_detail[0]; 
			$invoice_detail = explode("-",$invoice_detail);
			$invoice_detail = $invoice_detail[2]."-".$invoice_detail[1]."-".$invoice_detail[0];
						  
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $row, $data['regional']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $row, $data['area']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $row, $data['distributor_code']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $row, $data['distributor_name']);
		    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $row, $data['motorist_code']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, $row, $data['motorist_name']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, $row, $data['customer_code']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, $row, $data['customer_name']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8, $row, $data['channel_name']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9, $row, $data['product_code']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(10, $row, $data['sku_front_end']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(11, $row, $data['qty']);
			
			$select_total_price = $this->db->query("SELECT SUM(price_total) as total_price FROM product_orders WHERE id_product = '".$data['id_product']."' AND customer_code = '".$data['customer_code']."' AND date BETWEEN '".$tanggal_from." 00-00-00' AND '".$tanggal_to." 23-59-59' ")->result_array();
						
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(12, $row, $select_total_price[0]['total_price']);
 
            $row++;
			$no++;
        }
		
	   $last_row = $row-1;
	   //Set Border
       $objPHPExcel->getActiveSheet()->getStyle("A1".":"."M".$last_row)->applyFromArray($BStyle);
	   $objPHPExcel->getActiveSheet()->getStyle("A1".":"."M".$last_row)->applyFromArray($styleAlign);
       $objPHPExcel->setActiveSheetIndex(0);
 
        $objWriter = IOFactory::createWriter($objPHPExcel, 'Excel5');
 		
		
	   // Sending headers to force the user to download the file
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Export-invoice-monthly-detail-'.$date.'.xls"');
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