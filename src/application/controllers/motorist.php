<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Motorist extends CI_Controller {

	function __construct()  {
 		parent::__construct();
			$this->load->library(array('PHPExcel','PHPExcel/IOFactory'));
			$this->load->model('model_account_master');
			$this->load->model('model_motorist');
			$this->load->library('tank_auth');
			
	}
	
	
	public function getDailyCallstrikeAbsenMap()
	{
		if ($this->tank_auth->is_logged_in()) {
			$user	= $this->tank_auth->get_username();
			$data_account = $this->model_account_master->getAccount("WHERE username = '".$user."' ")->result_array();
			$data_role = $this->model_account_master->getRole("WHERE id_role = '".$data_account[0]['user_access']."' ")->result_array();
			$user_role = $data_account[0]['user_type'];
			$code_role = $data_account[0]['code'];
			
			$id_motorist = isset($_GET['id_motorist']) ? $_GET['id_motorist'] : '';
			$date = isset($_GET['date']) ? $_GET['date'] : '';
			
			if($data_role[0]['import_motorist']=='yes')
			{
				
				$return_arr = array();
		
				if($date!="")
				{
				$tanggal_pecah = explode("/", $date);
				$date_now = $tanggal_pecah[2].'-'.$tanggal_pecah[0].'-'.$tanggal_pecah[1];
				$this->db->where("date_absence LIKE '%".$date_now."%' ");
				}
		
				
				$this->db->where("id_motorist = '".$id_motorist."' ");
				$this->db->where("date_absence LIKE '%".$date_now."%' ");

				$query = $this->db->get('absence');
				$no = 1;
				foreach($query->result_array() as $data){
					
					
					$row_array['absence_latitude'] = $data['latitude'];
					$row_array['absence_longitude'] = $data['longitude'];
					array_push($return_arr,$row_array);
					$no++;
				}
				
				 echo json_encode($return_arr); 
				
			}
		}
		
	}
	
	public function getDailyCallstrikeMap()
	{
		if ($this->tank_auth->is_logged_in()) {
			$user	= $this->tank_auth->get_username();
			$data_account = $this->model_account_master->getAccount("WHERE username = '".$user."' ")->result_array();
			$data_role = $this->model_account_master->getRole("WHERE id_role = '".$data_account[0]['user_access']."' ")->result_array();
			$user_role = $data_account[0]['user_type'];
			$code_role = $data_account[0]['code'];
			
			$id_motorist = isset($_GET['id_motorist']) ? $_GET['id_motorist'] : '';
			$date = isset($_GET['date']) ? $_GET['date'] : '';
			
			if($data_role[0]['import_motorist']=='yes')
			{
				
				$return_arr = array();
				$this->db->select("store.customer_name as store_customer_name,store.latitude as store_latitude,store.longitude as store_longitude,visit.latitude as visit_latitude,visit.longitude as visit_longitude");
		
		
				if($date!="")
				{
				$tanggal_pecah = explode("/", $date);
				$date_now = $tanggal_pecah[2].'-'.$tanggal_pecah[0].'-'.$tanggal_pecah[1];
				$this->db->where("time_stamp_visit LIKE '%".$date_now."%' ");
				}
		
				
				$this->db->where("visit.id_motorist = '".$id_motorist."' ");
				$this->db->where("time_stamp_visit LIKE '%".$date_now."%' ");
				$this->db->join('store', 'store.customer_code = visit.customer_code');
				$this->db->join('motorist', 'motorist.id_motorist = visit.id_motorist');
				$this->db->order_by("visit.id_visit","asc");
				$query = $this->db->get('visit');
				$no = 1;
				foreach($query->result_array() as $data){
					
					$row_array['nomor_checkin'] = $no;
					$row_array['customer_name'] = $data['store_customer_name'];
					$row_array['visit_latitude'] = $data['visit_latitude'];
					$row_array['visit_longitude'] = $data['visit_longitude'];
					$row_array['store_latitude'] = $data['store_latitude'];
					$row_array['store_longitude'] = $data['store_longitude'];
					array_push($return_arr,$row_array);
					$no++;
				}
				
				 echo json_encode($return_arr); 
				
			}
		}
		
	}
	
	
	
	
	
	public function monthlyStockMotoristTotal()
	{
		
			date_default_timezone_set('Asia/Jakarta');
			if ($this->tank_auth->is_logged_in()) {
			$user	= $this->tank_auth->get_username();
			$data_account = $this->model_account_master->getAccount("WHERE username = '".$user."' ")->result_array();
			$data_role = $this->model_account_master->getRole("WHERE id_role = '".$data_account[0]['user_access']."' ")->result_array();
			$user_role = $data_account[0]['user_type'];
			$code_role = $data_account[0]['code'];
			
			if($data_role[0]['see_motorist']=='yes')
			{	
			
			$id_motorist = isset($_GET['id_motorist']) ? $_GET['id_motorist'] : '';
			$bulan = isset($_GET['bulan']) ? $_GET['bulan'] : '';
			$tahun = isset($_GET['year']) ? $_GET['year'] : '';
			$tanggal_bulan_awal = $tahun.'-'.$bulan."-01 00:00:00";
			$tanggal_bulan_akhir = $tahun.'-'.$bulan."-31 23:59:59";
			$data = $this->db->query("SELECT * FROM product_orders JOIN product on product.id_product = product_orders.id_product WHERE id_motorist = '".$id_motorist."' AND date BETWEEN '".$tanggal_bulan_awal."' AND '".$tanggal_bulan_akhir."'  GROUP BY product_orders.id_product ")->result_array();
			$data_motorist =$this->model_motorist->getMotorist("WHERE id_motorist = '".$id_motorist."' ")->result_array();
			$comp = array(
				
				'title' => ' Monthly Stock Total Motorist',
				'content' => $this->load->view('monthly-stock-total',array('data_stock'=>$data,'data_motorist'=>$data_motorist),true),
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
	
	
	public function dailyStockMotoristTotal()
	{
		
			date_default_timezone_set('Asia/Jakarta');
			if ($this->tank_auth->is_logged_in()) {
			$user	= $this->tank_auth->get_username();
			$data_account = $this->model_account_master->getAccount("WHERE username = '".$user."' ")->result_array();
			$data_role = $this->model_account_master->getRole("WHERE id_role = '".$data_account[0]['user_access']."' ")->result_array();
			$user_role = $data_account[0]['user_type'];
			$code_role = $data_account[0]['code'];
			
			if($data_role[0]['see_motorist']=='yes')
			{	
			
			$id_motorist = isset($_GET['id_motorist']) ? $_GET['id_motorist'] : '';
			$date_now = isset($_GET['tanggal']) ? $_GET['tanggal'] : '';
			
		
			$data = $this->db->query("SELECT * FROM product_orders JOIN product on product.id_product = product_orders.id_product WHERE id_motorist = '".$id_motorist."' AND date LIKE '%".$date_now."%' GROUP BY product_orders.id_product ")->result_array();
			$data_motorist =$this->model_motorist->getMotorist("WHERE id_motorist = '".$id_motorist."' ")->result_array();
			$comp = array(
				
				'title' => ' Daily Stock Total Motorist',
				'content' => $this->load->view('daily-stock-total',array('data_stock'=>$data,'data_motorist'=>$data_motorist),true),
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
	
	
	public function storeJourney()
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
			
			$this->load->library('table');
			$this->load->library('pagination');
			$motorist_code = isset($_GET['motorist_code']) ? $_GET['motorist_code'] : '';
			$distributor_code = isset($_GET['distributor_code']) ? $_GET['distributor_code'] : '';
			$day_visit = isset($_GET['day_visit']) ? $_GET['day_visit'] : '';
			$frequently = isset($_GET['frequently']) ? $_GET['frequently'] : '';
			
		
			
			$jumlah= $this->model_motorist->countStoreJourney($user_role,$code_role,$ket,$motorist_code,$distributor_code,$day_visit,$frequently);
			$config['base_url'] = base_url().'index.php/motorist/storeJourney/';
			$config['total_rows'] = $jumlah;
			$config['first_link'] = 'First';
			$config['last_link'] = 'End';
			$config['next_link'] = 'Next';
			$config['prev_link'] = 'Previous';
			$config['per_page'] = 80; 	
			
			$dari = $this->uri->segment('3');
			$data = $this->model_motorist->dataStoreJourney($config['per_page'],$dari,$user_role,$code_role,$ket,$motorist_code,$distributor_code,$day_visit,$frequently);
			$data_regional = $this->model_motorist->getRegional()->result_array();
			$data_motorist_type = $this->model_motorist->getMotoristType()->result_array();
			$this->pagination->initialize($config);
			
			$data_motorist = $this->model_motorist->getMotorist("WHERE motorist_code = '".$motorist_code."' AND distributor_code = '".$distributor_code."'  ")->result_array();
			
			$comp = array(
				'title' => ' Store Journey Motorist',
				'content' => $this->load->view('store-journey',array('data_account'=>$data_account,'data_regional'=>$data_regional,'data_store'=>$data,'data_motorist'=>$data_motorist),true),
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
	
	
	public function swicthingMotoristNoo()
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
			$this->load->library('table');
			$this->load->library('pagination');
			$search = isset($_GET['search']) ? $_GET['search'] : '';
			$bulan = isset($_GET['bulan']) ? $_GET['bulan'] : '';
			$tahun = isset($_GET['tahun']) ? $_GET['tahun'] : '';
			
			
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
			
			
			if (count($_GET) > 0) $config['suffix'] = '?' . http_build_query($_GET, '', "&");
			$jumlah= $this->model_motorist->countNooSwitching($search,$bulan,$tahun,$user_role,$code_role,$ket,$regional,$area,$distributor);
			$config['base_url'] = base_url().'index.php/motorist/swicthingMotoristNoo/';
			$config['total_rows'] = $jumlah;
			$config['first_link'] = 'First';
			$config['last_link'] = 'End';
			$config['next_link'] = 'Next';
			$config['prev_link'] = 'Previous';
			$config['per_page'] = 5; 	
			
			if (count($_GET) > 0) $config['suffix'] = '?' . http_build_query($_GET, '', "&");
			$config['first_url'] = $config['base_url'].'?'.http_build_query($_GET);
			
			$dari = $this->uri->segment('3');
			$data = $this->model_motorist->dataNooSwitching($config['per_page'],$dari,$bulan,$tahun,$search,$user_role,$code_role,$ket,$regional,$area,$distributor);
			$this->pagination->initialize($config);
			$data_regional = $this->model_motorist->getRegional()->result_array();
			$data_motorist_type = $this->model_motorist->getMotoristType()->result_array();
			
			if($user_role=="Regional")
			{
				$data_area = $this->db->query("SELECT * FROM master_area WHERE regional = '".$code_role."' ")->result_array();
				$data_distributor = $this->model_motorist->getDistributor("WHERE regional='".$code_role."' ")->result_array();
			}
			else 
			{
				$data_area = $this->db->query('SELECT * FROM master_area')->result_array();
				$data_distributor = $this->model_motorist->getDistributor()->result_array();
			}
		
			$comp = array(
				'title' => ' Switching Noo Motorist',
				'content' => $this->load->view('switching-store-motorist2',array('data_distributor'=>$data_distributor,'data_area'=>$data_area,'data_account'=>$data_account,'data_motorist'=>$data,'data_regional'=>$data_regional,'search'=>$search,'data_motorist_type'=>$data_motorist_type),true),
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
	
	
	
	public function swicthingMotoristStore()
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
			
			$this->load->library('table');
			$this->load->library('pagination');
			$search = isset($_GET['search']) ? $_GET['search'] : '';
			$bulan = isset($_GET['bulan']) ? $_GET['bulan'] : '';
			$tahun = isset($_GET['tahun']) ? $_GET['tahun'] : '';
			
			
			$regional = isset($_GET['regional']) ? $_GET['regional'] : '';
			if(isset($_GET['regional']))
			{
				$regional = "'" . implode("','", $regional) . "'";
			}
			
			$motorist_type = isset($_GET['motorist_type']) ? $_GET['motorist_type'] : '';
			if(isset($_GET['motorist_type']))
			{$motorist_type = implode(",",$motorist_type);}
			
			if (count($_GET) > 0) $config['suffix'] = '?' . http_build_query($_GET, '', "&");
			$jumlah= $this->model_motorist->countOutletSwitching($search,$bulan,$tahun,$user_role,$code_role,$ket,$regional,$motorist_type);
			$config['base_url'] = base_url().'index.php/motorist/swicthingMotoristStore/';
			$config['total_rows'] = $jumlah;
			$config['first_link'] = 'First';
			$config['last_link'] = 'End';
			$config['next_link'] = 'Next';
			$config['prev_link'] = 'Previous';
			$config['per_page'] = 5; 	
			
			if (count($_GET) > 0) $config['suffix'] = '?' . http_build_query($_GET, '', "&");
			$config['first_url'] = $config['base_url'].'?'.http_build_query($_GET);
			
			$dari = $this->uri->segment('3');
			$data = $this->model_motorist->dataOutletSwitching($config['per_page'],$dari,$bulan,$tahun,$search,$user_role,$code_role,$ket,$regional,$motorist_type);
			$this->pagination->initialize($config);
			$data_regional = $this->model_motorist->getRegional()->result_array();
			$data_motorist_type = $this->model_motorist->getMotoristType()->result_array();
			
		
			$comp = array(
				'title' => ' Monthly Additional Store',
				'content' => $this->load->view('switching-store-motorist',array('data_account'=>$data_account,'data_motorist'=>$data,'data_regional'=>$data_regional,'search'=>$search,'data_motorist_type'=>$data_motorist_type),true),
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
	
	
	public function journeyPlanMotorist()
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
			
			$this->load->library('table');
			$this->load->library('pagination');
			$search = isset($_GET['search']) ? $_GET['search'] : '';
			
			$regional = isset($_GET['regional']) ? $_GET['regional'] : '';
            
            
			if(isset($_GET['regional']))
			{
				$regional = "'" . implode("','", $regional) . "'";
			}
			
			$motorist_type = isset($_GET['motorist_type']) ? $_GET['motorist_type'] : '';
			if(isset($_GET['motorist_type']))
			{$motorist_type = implode(",",$motorist_type);}
		
			$distributor = isset($_GET['distributor']) ? $_GET['distributor'] : '';
			if(isset($_GET['distributor']))
			{$distributor = implode(",",$distributor);}

		
		
			$area = isset($_GET['area']) ? $_GET['area'] : '';
			if(isset($_GET['area']))
			{
				$area = "'" . implode("','", $area) . "'";
			}
			
			if (count($_GET) > 0) $config['suffix'] = '?' . http_build_query($_GET, '', "&");
			$jumlah= $this->model_motorist->countJourneyMotorist($search,$user_role,$code_role,$ket,$regional,$motorist_type,$area,$distributor);
			$config['base_url'] = base_url().'index.php/motorist/journeyPlanMotorist/';
			$config['total_rows'] = $jumlah;
			$config['first_link'] = 'First';
			$config['last_link'] = 'End';
			$config['next_link'] = 'Next';
			$config['prev_link'] = 'Previous';
			$config['per_page'] = 5; 	
			
			if (count($_GET) > 0) $config['suffix'] = '?' . http_build_query($_GET, '', "&");
			$config['first_url'] = $config['base_url'].'?'.http_build_query($_GET);
			
			$dari = $this->uri->segment('3');
			$data = $this->model_motorist->journeyMotorist($config['per_page'],$dari,$search,$user_role,$code_role,$ket,$regional,$motorist_type,$area,$distributor);
			$data_regional = $this->model_motorist->getRegional()->result_array();
			$data_motorist_type = $this->model_motorist->getMotoristType()->result_array();
			$this->pagination->initialize($config);
			
			if($user_role=="Regional")
			{
				$data_area = $this->db->query("SELECT * FROM master_area WHERE regional = '".$code_role."' ")->result_array();
				$data_distributor = $this->model_motorist->getDistributor("WHERE regional='".$code_role."' ")->result_array();
			}
			else 
			{
				$data_area = $this->db->query('SELECT * FROM master_area')->result_array();
				$data_distributor = $this->model_motorist->getDistributor()->result_array();
			}
			
		
			$comp = array(
				'title' => ' Daily Journey Motorist',
				'content' => $this->load->view('journey-motorist',array('data_distributor'=>$data_distributor,'data_area'=>$data_area,'data_account'=>$data_account,'data_motorist_type'=>$data_motorist_type,'data_regional'=>$data_regional,'data_motorist'=>$data,'search'=>$search),true),
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
	
	
	public function dailySummaryMotorist()
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
			
			$this->load->library('table');
			$this->load->library('pagination');
			$date = isset($_GET['date']) ? $_GET['date'] : '';
			$search = isset($_GET['search']) ? $_GET['search'] : '';
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
			$jumlah= $this->model_motorist->countDailySummary($search,$user_role,$code_role,$ket,$regional,$motorist_type,$area,$distributor);
			$config['base_url'] = base_url().'index.php/motorist/dailySummaryMotorist/';
			$config['total_rows'] = $jumlah;
			$config['first_link'] = 'First';
			$config['last_link'] = 'End';
			$config['next_link'] = 'Next';
			$config['prev_link'] = 'Previous';
			$config['per_page'] = 5; 	
			
			$dari = $this->uri->segment('3');
			$data = $this->model_motorist->dataDailySummary($config['per_page'],$dari,$search,$user_role,$code_role,$ket,$date,$regional,$motorist_type,$area,$distributor);
			$data_motorist_type = $this->model_motorist->getMotoristType("WHERE id_motorist_type in (".$ket.") ")->result_array();
			if($user_role=="Regional")
			{
				$data_area = $this->db->query("SELECT * FROM master_area WHERE regional = '".$code_role."' ")->result_array();
				$data_distributor = $this->model_motorist->getDistributor("WHERE regional='".$code_role."' ")->result_array();
				$data_regional = $this->model_motorist->getRegional("WHERE regional_name='".$code_role."' ")->result_array();
			}
			else 
			{
				$data_area = $this->db->query('SELECT * FROM master_area')->result_array();
				$data_distributor = $this->model_motorist->getDistributor()->result_array();
				$data_regional = $this->model_motorist->getRegional()->result_array();
			}
			
			$this->pagination->initialize($config);
			
		
			$comp = array(
				
				'title' => ' Daily Summary Motorist',
				'content' => $this->load->view('daily-motorist',array('data_distributor'=>$data_distributor,'data_area'=>$data_area,'data_role_etools'=>$data_role_etools,'data_account'=>$data_account,'data_motorist'=>$data,'data_motorist_type'=>$data_motorist_type,'data_regional'=>$data_regional,'search'=>$search),true),
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
	
	
	
	
	public function dailySummaryMotoristAdo()
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
			
			$this->load->library('table');
			$this->load->library('pagination');
			$date = isset($_GET['date']) ? $_GET['date'] : '';
			$search = isset($_GET['search']) ? $_GET['search'] : '';
			
			$jumlah= $this->model_motorist->countDailySummaryAdo($search,$user_role,$code_role,$ket);
			$config['base_url'] = base_url().'index.php/motorist/dailySummaryMotoristAdo/';
			$config['total_rows'] = $jumlah;
			$config['first_link'] = 'First';
			$config['last_link'] = 'End';
			$config['next_link'] = 'Next';
			$config['prev_link'] = 'Previous';
			$config['per_page'] = 5; 	
			
			if (count($_GET) > 0) $config['suffix'] = '?' . http_build_query($_GET, '', "&");
			$config['first_url'] = $config['base_url'].'?'.http_build_query($_GET);
			
			$dari = $this->uri->segment('3');
			$data = $this->model_motorist->dataDailySummaryAdo($config['per_page'],$dari,$search,$user_role,$code_role,$ket,$date);
			$data_motorist_type = $this->model_motorist->getMotoristType()->result_array();
			$data_regional = $this->model_motorist->getRegional()->result_array();
			$this->pagination->initialize($config);
			
		
			$comp = array(
				
				'title' => ' Daily Summary Motorist',
				'content' => $this->load->view('daily-motorist-ado',array('data_account'=>$data_account,'data_motorist'=>$data,'data_motorist_type'=>$data_motorist_type,'data_regional'=>$data_regional,'search'=>$search),true),
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
	
	
	
	public function dailySalesMotoristAdo()
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
			
			$this->load->library('table');
			$this->load->library('pagination');
			$date = isset($_GET['date']) ? $_GET['date'] : '';
			$search = isset($_GET['search']) ? $_GET['search'] : '';
			if (count($_GET) > 0) $config['suffix'] = '?' . http_build_query($_GET, '', "&");
			$jumlah= $this->model_motorist->countSalesSummaryAdo($search,$user_role,$code_role,$ket);
			$config['base_url'] = base_url().'index.php/motorist/dailySalesMotoristAdo/';
			$config['total_rows'] = $jumlah;
			$config['first_link'] = 'First';
			$config['last_link'] = 'End';
			$config['next_link'] = 'Next';
			$config['prev_link'] = 'Previous';
			$config['per_page'] = 5; 	
			
			if (count($_GET) > 0) $config['suffix'] = '?' . http_build_query($_GET, '', "&");
			$config['first_url'] = $config['base_url'].'?'.http_build_query($_GET);
			
			$dari = $this->uri->segment('3');
			$data = $this->model_motorist->dataSalesSummaryAdo($config['per_page'],$dari,$search,$user_role,$code_role,$ket,$date);
			$data_motorist_type = $this->model_motorist->getMotoristType()->result_array();
			$data_regional = $this->model_motorist->getRegional()->result_array();
			$this->pagination->initialize($config);
			
		
			$comp = array(
				
				'title' => ' Daily Sales Motorist',
				'content' => $this->load->view('daily-sales-motorist-ado',array('data_account'=>$data_account,'data_motorist'=>$data,'data_motorist_type'=>$data_motorist_type,'data_regional'=>$data_regional,'search'=>$search),true),
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
	
	
	public function dailyCallStrikeSidebar()
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
			
			$this->load->library('table');
			$this->load->library('pagination');
			$id_motorist = isset($_GET['id_motorist']) ? $_GET['id_motorist'] : '';
			$date = isset($_GET['date']) ? $_GET['date'] : '';
		
			if (count($_GET) > 0) $config['suffix'] = '?' . http_build_query($_GET, '', "&");
			$jumlah= $this->model_motorist->countCallStrikeSidebar($user_role,$code_role,$id_motorist,$date);
			$config['base_url'] = base_url().'index.php/dailyCallStrike/';
			$config['total_rows'] = $jumlah;
			$config['first_link'] = 'First';
			$config['last_link'] = 'End';
			$config['next_link'] = 'Next';
			$config['prev_link'] = 'Previous';
			$config['per_page'] = 100; 	
			
			
			if (count($_GET) > 0) $config['suffix'] = '?' . http_build_query($_GET, '', "&");
			$config['first_url'] = $config['base_url'].'?'.http_build_query($_GET);
			$dari = $this->uri->segment('3');
			$data = $this->model_motorist->dataCallStrikeSidebar($config['per_page'],$dari,$user_role,$code_role,$id_motorist,$date);
			$this->pagination->initialize($config);
			
			
			$data_motorist = $this->model_motorist->getMotorist("WHERE id_motorist = '".$id_motorist."' ")->result_array();
			$data_motorist_array = $this->model_motorist->getMotoristList()->result();
			
			
			
			
			if($user_role=="Ado")
			{
				$data_motorist_array = $this->model_motorist->getMotoristList("WHERE distributor_code = '".$code_role."' AND motorist_type in (".$ket.") ")->result();
			}
			else if($user_role=="Regional")
			{
				$data_motorist_array = $this->db->query("SELECT * FROM motorist INNER JOIN distributor ON  motorist.distributor_code = distributor.distributor_code WHERE regional = '".$code_role."' AND motorist.motorist_type in (".$ket.")  ")->result();		
			}
		
			else if($user_role=="Administrator")
			{
			$data_motorist_array = $this->model_motorist->getMotoristList()->result();
			}
			
			
			
			
			
			$comp = array(
				
				'title' => ' Motorist',
				'content' => $this->load->view('daily-callstrike-sidebar',array('data_account'=>$data_account,'data_callstrike'=>$data,'data_motorist'=>$data_motorist,'data_motorist_array'=>$data_motorist_array),true),
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
	
	
	public function dailyCallStrike()
	{
			date_default_timezone_set('Asia/Jakarta');
			if ($this->tank_auth->is_logged_in()) {
			$user	= $this->tank_auth->get_username();
			$data_account = $this->model_account_master->getAccount("WHERE username = '".$user."' ")->result_array();
			$data_role = $this->model_account_master->getRole("WHERE id_role = '".$data_account[0]['user_access']."' ")->result_array();
			$user_role = $data_account[0]['user_type'];
			$code_role = $data_account[0]['code'];
			
			if($data_role[0]['see_motorist']=='yes')
			{	
			
			$this->load->library('table');
			$this->load->library('pagination');
			$id_motorist = isset($_GET['id_motorist']) ? $_GET['id_motorist'] : '';
			$date = isset($_GET['date']) ? $_GET['date'] : '';
		
			if (count($_GET) > 0) $config['suffix'] = '?' . http_build_query($_GET, '', "&");
			$jumlah= $this->model_motorist->countCallStrike($user_role,$code_role,$id_motorist,$date);
			$config['base_url'] = base_url().'index.php/dailyCallStrike/';
			$config['total_rows'] = $jumlah;
			$config['first_link'] = 'First';
			$config['last_link'] = 'End';
			$config['next_link'] = 'Next';
			$config['prev_link'] = 'Previous';
			$config['per_page'] = 100; 	
			
			
			if (count($_GET) > 0) $config['suffix'] = '?' . http_build_query($_GET, '', "&");
			$config['first_url'] = $config['base_url'].'?'.http_build_query($_GET);
			$dari = $this->uri->segment('3');
			$data = $this->model_motorist->dataCallStrike($config['per_page'],$dari,$user_role,$code_role,$id_motorist,$date);
			$this->pagination->initialize($config);
			
			
			$data_motorist = $this->model_motorist->getMotorist("WHERE id_motorist = '".$id_motorist."' ")->result_array();
		
			$comp = array(
				
				'title' => ' Motorist',
				'content' => $this->load->view('daily-callstrike',array('data_account'=>$data_account,'data_callstrike'=>$data,'data_motorist'=>$data_motorist),true),
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
	
	
	public function dailyCallStrikeMap()
	{
			date_default_timezone_set('Asia/Jakarta');
			if ($this->tank_auth->is_logged_in()) {
			$user	= $this->tank_auth->get_username();
			$data_account = $this->model_account_master->getAccount("WHERE username = '".$user."' ")->result_array();
			$data_role = $this->model_account_master->getRole("WHERE id_role = '".$data_account[0]['user_access']."' ")->result_array();
			$user_role = $data_account[0]['user_type'];
			$code_role = $data_account[0]['code'];
			
			if($data_role[0]['see_motorist']=='yes')
			{	
			
			$this->load->library('table');
			$this->load->library('pagination');
			$id_motorist = isset($_GET['id_motorist']) ? $_GET['id_motorist'] : '';
			$date = isset($_GET['date']) ? $_GET['date'] : '';
		
			if (count($_GET) > 0) $config['suffix'] = '?' . http_build_query($_GET, '', "&");
			$jumlah= $this->model_motorist->countCallStrike($user_role,$code_role,$id_motorist,$date);
			$config['base_url'] = base_url().'index.php/dailyCallStrike/';
			$config['total_rows'] = $jumlah;
			$config['first_link'] = 'First';
			$config['last_link'] = 'End';
			$config['next_link'] = 'Next';
			$config['prev_link'] = 'Previous';
			$config['per_page'] = 40; 	
			
			
			if (count($_GET) > 0) $config['suffix'] = '?' . http_build_query($_GET, '', "&");
			$config['first_url'] = $config['base_url'].'?'.http_build_query($_GET);
			$dari = $this->uri->segment('3');
			$data = $this->model_motorist->dataCallStrike($config['per_page'],$dari,$user_role,$code_role,$id_motorist,$date);
			$this->pagination->initialize($config);
			
			
			$data_motorist = $this->model_motorist->getMotorist("WHERE id_motorist = '".$id_motorist."' ")->result_array();
		
			$comp = array(
				
				'title' => ' Motorist',
				'content' => $this->load->view('daily-callstrike-map',array('data_account'=>$data_account,'data_callstrike'=>$data,'data_motorist'=>$data_motorist),true),
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
	
	
	
	public function detailCallStrike($id_visit)
	{
			date_default_timezone_set('Asia/Jakarta');
			if ($this->tank_auth->is_logged_in()) {
			$user	= $this->tank_auth->get_username();
			$data_account = $this->model_account_master->getAccount("WHERE username = '".$user."' ")->result_array();
			$data_role = $this->model_account_master->getRole("WHERE id_role = '".$data_account[0]['user_access']."' ")->result_array();
			$user_role = $data_account[0]['user_type'];
			$code_role = $data_account[0]['code'];
			
			if($data_role[0]['see_motorist']=='yes')
			{	
			
			$this->load->library('table');
			$this->load->library('pagination');
			
			
			if($data_visit[0]['id_order']='order')
			{
			$data_visit = $this->model_motorist->getVisitData("id_visit = '".$id_visit."' ");
			$data_product_orders = $this->model_motorist->getProductOrders("id_order = '".$data_visit[0]['id_order']."' ");
			}
			else
			{
			$data_product_orders='';
			$data_visit = $this->db->query("SELECT * FROM visit where id_visit = '".$id_visit."' ")->result_array();
			
			}
			
			$data_total_order = $this->db->query("SELECT SUM(price_total) as total_harga FROM product_orders where id_order = '".$data_visit[0]['id_order']."' ")->result_array();
		
		
			$comp = array(
				
				'title' => ' Detail CallStrike',
				'content' => $this->load->view('detail-callstrike',array('data_total_order'=>$data_total_order,'data_account'=>$data_account,'data_visit'=>$data_visit,'data_product_orders'=>$data_product_orders),true),
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
	
	
	
	public function dailyStock($id_motorist)
	{
		
			date_default_timezone_set('Asia/Jakarta');
			if ($this->tank_auth->is_logged_in()) {
			$user	= $this->tank_auth->get_username();
			$data_account = $this->model_account_master->getAccount("WHERE username = '".$user."' ")->result_array();
			$data_role = $this->model_account_master->getRole("WHERE id_role = '".$data_account[0]['user_access']."' ")->result_array();
			$user_role = $data_account[0]['user_type'];
			$code_role = $data_account[0]['code'];
			
			if($data_role[0]['see_motorist']=='yes')
			{	
			
			$date = isset($_GET['date']) ? $_GET['date'] : '';
			$tanggal_pecah = explode("/", $date);
			$date_now = $tanggal_pecah[2].'-'.$tanggal_pecah[0].'-'.$tanggal_pecah[1];
			
		
			$data = $this->model_motorist->getStock("motorist.id_motorist = '".$id_motorist."' AND date LIKE '%".$date_now."%' ");
			$data_motoris =$this->model_motorist->getMotorist("WHERE id_motorist = '".$id_motorist."' ")->result_array();
		
			$comp = array(
				
				'title' => ' Daily Call Strike',
				'content' => $this->load->view('daily-stock',array('data_stock'=>$data,'data_motorist'=>$data_motoris),true),
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
	
	
	
	public function MotoristMap()
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
			
			$this->load->library('table');
			$this->load->library('pagination');
			$id_motorist = isset($_GET['id_motorist']) ? $_GET['id_motorist'] : '';
			
			$data_motorist = $this->db->query("SELECT * FROM motorist WHERE id_motorist = '".$id_motorist."' ")->result_array();
			$motorist_code = $data_motorist[0]['motorist_code'];
			$distributor_code = $data_motorist[0]['distributor_code'];
						
			$search = isset($_GET['search']) ? $_GET['search'] : '';
			
			if (count($_GET) > 0) $config['suffix'] = '?' . http_build_query($_GET, '', "&");
			$jumlah= $this->model_motorist->countMapMotorist($search,$motorist_code,$distributor_code);
			$config['base_url'] = base_url().'index.php/motorist/MotoristMap/';
			$config['total_rows'] = $jumlah;
			$config['first_link'] = 'First';
			$config['last_link'] = 'End';
			$config['next_link'] = 'Next';
			$config['prev_link'] = 'Previous';
			$config['per_page'] = 5; 	
			
			if (count($_GET) > 0) $config['suffix'] = '?' . http_build_query($_GET, '', "&");
			$config['first_url'] = $config['base_url'].'?'.http_build_query($_GET);
			$dari = $this->uri->segment('3');
			$data = $this->model_motorist->dataMapMotorist($config['per_page'],$dari,$search,$motorist_code,$distributor_code);
			$this->pagination->initialize($config);
			$data_motoris = $this->model_motorist->getMotorist("WHERE id_motorist = '".$id_motorist."' ")->result_array();
		
			$comp = array(
				
				'title' => ' Motorist',
				'content' => $this->load->view('motorist-map',array('data_account'=>$data_account,'data_store'=>$data,'search'=>$search,'data_motorist'=>$data_motoris),true),
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
	
	
	public function monthlySummaryMotorist()
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
			
			$this->load->library('table');
			$this->load->library('pagination');
			$search = isset($_GET['search']) ? $_GET['search'] : '';
			$bulan = isset($_GET['bulan']) ? $_GET['bulan'] : '';
			$tahun = isset($_GET['tahun']) ? $_GET['tahun'] : '';
			
			
			$distributor = isset($_GET['distributor']) ? $_GET['distributor'] : '';
			if(isset($_GET['distributor']))
			{$distributor = implode(",",$distributor);}
			
			$area = isset($_GET['area']) ? $_GET['area'] : '';
			if(isset($_GET['area']))
			{
				$area = "'" . implode("','", $area) . "'";
			}
			
			$regional = isset($_GET['regional']) ? $_GET['regional'] : '';
			if(isset($_GET['regional']))
			{
				$regional = "'" . implode("','", $regional) . "'";
			}
			
			$motorist_type = isset($_GET['motorist_type']) ? $_GET['motorist_type'] : '';
			if(isset($_GET['motorist_type']))
			{$motorist_type = implode(",",$motorist_type);}
			
			if (count($_GET) > 0) $config['suffix'] = '?' . http_build_query($_GET, '', "&");
			$jumlah= $this->model_motorist->countMonthlySummary($search,$bulan,$tahun,$user_role,$code_role,$ket,$regional,$motorist_type,$area,$distributor);
			$config['base_url'] = base_url().'index.php/motorist/monthlySummaryMotorist/';
			$config['total_rows'] = $jumlah;
			$config['first_link'] = 'First';
			$config['last_link'] = 'End';
			$config['next_link'] = 'Next';
			$config['prev_link'] = 'Previous';
			$config['per_page'] = 5 ; 	
			if (count($_GET) > 0) $config['suffix'] = '?' . http_build_query($_GET, '', "&");
			$config['first_url'] = $config['base_url'].'?'.http_build_query($_GET);
			
			$dari = $this->uri->segment('3');
			$data = $this->model_motorist->dataMonthlySummary($config['per_page'],$dari,$bulan,$tahun,$search,$user_role,$code_role,$ket,$regional,$motorist_type,$area,$distributor);
			$this->pagination->initialize($config);
			$data_regional = $this->model_motorist->getRegional()->result_array();
			$data_motorist_type = $this->model_motorist->getMotoristType()->result_array();
			
			if($user_role=="Regional")
			{
				$data_area = $this->db->query("SELECT * FROM master_area WHERE regional = '".$code_role."' ")->result_array();
				$data_distributor = $this->model_motorist->getDistributor("WHERE regional='".$code_role."' ")->result_array();
			}
			else 
			{
				$data_area = $this->db->query('SELECT * FROM master_area')->result_array();
				$data_distributor = $this->model_motorist->getDistributor()->result_array();
			}
		
			$comp = array(
				'title' => ' Monthly Summary Motorist',
				'content' => $this->load->view('monthly-motorist',array('data_distributor'=>$data_distributor,'data_area'=>$data_area,'data_role_etools'=>$data_role_etools,'data_account'=>$data_account,'data_motorist'=>$data,'data_regional'=>$data_regional,'search'=>$search,'data_motorist_type'=>$data_motorist_type),true),
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
			
			
			
			if($data_role[0]['see_motorist']=='yes')
			{	
			$this->load->library('table');
			$this->load->library('pagination');
			$search = isset($_GET['search']) ? $_GET['search'] : '';
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
			
			$jumlah= $this->model_motorist->countMotorist($search,$user_role,$code_role,$ket,$regional,$motorist_type,$area,$distributor);
			
			if (count($_GET) > 0) $config['suffix'] = '?' . http_build_query($_GET, '', "&");
			$config['base_url'] = base_url().'index.php/motorist/motorist/';
			$config['total_rows'] = $jumlah;
			$config['first_link'] = 'First';
			$config['last_link'] = 'End';
			$config['next_link'] = 'Next';
			$config['prev_link'] = 'Previous';
			$config['per_page'] = 5; 	
			if (count($_GET) > 0) $config['suffix'] = '?' . http_build_query($_GET, '', "&");
			$config['first_url'] = $config['base_url'].'?'.http_build_query($_GET);
			
			$dari = $this->uri->segment('3');
			$data = $this->model_motorist->dataMotorist($config['per_page'],$dari,$search,$user_role,$code_role,$ket,$regional,$motorist_type,$area,$distributor);
			$data_regional = $this->model_motorist->getRegional()->result_array();
			
			$data_motorist_type = $this->model_motorist->getMotoristType("WHERE id_motorist_type in (".$ket.") ")->result_array();
			$this->pagination->initialize($config);
			
			if($user_role=="Regional")
			{
				$data_area = $this->db->query("SELECT * FROM master_area WHERE regional = '".$code_role."' ")->result_array();
				$data_distributor = $this->model_motorist->getDistributor("WHERE regional='".$code_role."' ")->result_array();
			}
			else 
			{
				$data_area = $this->db->query('SELECT * FROM master_area')->result_array();
				$data_distributor = $this->model_motorist->getDistributor()->result_array();
			}
			
			
		
			$comp = array(
				'title' => ' Motorist',
				'content' => $this->load->view('motorist',array('data_distributor'=>$data_distributor,'data_area'=>$data_area,'data_account'=>$data_account,'data_regional'=>$data_regional,'data_motorist'=>$data,'data_motorist_type'=>$data_motorist_type,'search'=>$search),true),
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
	
	
	
	public function addMotorist()
	{
		
			date_default_timezone_set('Asia/Jakarta');
			ini_set('memory_limit', '-1');
			
			if ($this->tank_auth->is_logged_in()) {
			$user	= $this->tank_auth->get_username();
			$data_account = $this->model_account_master->getAccount("WHERE username = '".$user."' ")->result_array();
			$data_role = $this->model_account_master->getRole("WHERE id_role = '".$data_account[0]['user_access']."' ")->result_array();
			$user_role = $data_account[0]['user_type'];
			$code_role = $data_account[0]['code'];
			
			if($data_role[0]['add_motorist']=='yes')
			{
				
			$this->load->helper('form');
			$this->load->helper('url');
			$this->load->library('form_validation');
			
			$this->form_validation->set_rules('motorist_code','Motorist Code','required');
			$this->form_validation->set_rules('motorist_name','Motorist Name','required');
			$this->form_validation->set_rules('motorist_type','Motorist Type','required');
			$this->form_validation->set_rules('distributor_code','Distributor','required');
			$this->form_validation->set_rules('target_harian','Daily Target Sales','required');
			$this->form_validation->set_rules('target_bulanan','Monthly Target Sales','required');
			$this->form_validation->set_rules('password','Password','required|matches[re_password]');
			$this->form_validation->set_rules('re_password','Retype password','required');
			
			if($this->form_validation->run()==FALSE){
					
					
					if($user_role=="Administrator")
					{
					$data =$this->model_motorist->getDistributor()->result();
					}
					else if($user_role=="Ado")
					{
						$data =$this->model_motorist->getDistributor("WHERE distributor_code = '".$code_role."' ")->result();
						}
					
					$data_motorist_type = $this->model_motorist->getMotoristType("")->result_array();
					$comp = array(
						
						'title' => ' Add Motorist',
						'content' => $this->load->view('add-motorist',array('data_distributor'=>$data,'data_motorist'=>$data_motorist_type),true),
						'sidebar' => $this->html_sidebar()
					
					);
					
					$this->load->view("common/common",$comp);
			}
			
			else
			{
				// Get Variable Post
				$motorist_code = $_POST['motorist_code'];
				$motorist_name = $_POST['motorist_name'];
				$motorist_type = $_POST['motorist_type'];
				$distributor_code = $_POST['distributor_code'];
				$target_harian = $_POST['target_harian'];
				$target_bulanan = $_POST['target_bulanan'];
				$password = md5($_POST['password']);
				
				$data_motorist = $this->model_motorist->getMotorist("WHERE distributor_code = '".$distributor_code."' ORDER BY urutan_motorist DESC ")->result_array();
				$urutan_motorist = $data_motorist[0]['urutan_motorist'] + 1;
				
				
				$data_insert = array(
				"motorist_code" => $motorist_code,
				"distributor_code" => $distributor_code,
				"motorist_name" => $motorist_name,
				"password" => $password,
				"motorist_type" => $motorist_type,
				"target_harian" => $target_harian,
				"target_bulanan" => $target_bulanan,
				"urutan_motorist" => $urutan_motorist

				);
				
				//Check Product Apakah sudah ada dengan kode produk dan type motorist yang sama
				$check = $this->model_motorist->getMotorist("WHERE motorist_code = '".$motorist_code."' AND distributor_code = '".$distributor_code."' ");
				if($check->num_rows() >=1 )
				{
					$this->session->set_flashdata('message_failed',"Sorry data already exist!");
					redirect('motorist');
					}
				else
				{
					
					$res = $this->model_motorist->insertData("motorist",$data_insert);
					if($res>=1)
					{
						
						$this->session->set_flashdata('message_success',"Data motorist has been successfully saved!");
						redirect('motorist');
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
	
	
	
	public function editMotorist($id_motorist)
	{
		
			date_default_timezone_set('Asia/Jakarta');
			ini_set('memory_limit', '-1');
			
			if ($this->tank_auth->is_logged_in()) {
			$user	= $this->tank_auth->get_username();
			$data_account = $this->model_account_master->getAccount("WHERE username = '".$user."' ")->result_array();
			$data_role = $this->model_account_master->getRole("WHERE id_role = '".$data_account[0]['user_access']."' ")->result_array();
			$user_role = $data_account[0]['user_type'];
			$code_role = $data_account[0]['code'];
			
			if($data_role[0]['add_motorist']=='yes')
			{
				
			$this->load->helper('form');
			$this->load->helper('url');
			$this->load->library('form_validation');
			$this->form_validation->set_rules('id_motorist','ID Motorist','required');
			$this->form_validation->set_rules('motorist_code','Motorist Code','required');
			$this->form_validation->set_rules('motorist_name','Motorist Name','required');
			$this->form_validation->set_rules('motorist_type','Motorist Type','required');
			$this->form_validation->set_rules('distributor_code','Distributor Code','required');
			$this->form_validation->set_rules('target_harian','Daily Target Sales','required');
			$this->form_validation->set_rules('target_bulanan','Monthly Target Sales','required');
			
			if($this->form_validation->run()==FALSE){
			
			$check_motorist = $this->model_motorist->getMotorist("WHERE id_motorist = '".$id_motorist."' ");
			
			$data_motorist_type = $this->model_motorist->getMotoristType()->result_array();
			$data_distributor = $this->model_motorist->getDistributor()->result_array();
			if($check_motorist->num_rows() >=1)
			{	
			$data_motorist = $check_motorist->result_array();	
			$data = array (
				"id_motorist" => $data_motorist[0]['id_motorist'],
				"motorist_code" => $data_motorist[0]['motorist_code'],
				"motorist_name" => $data_motorist[0]['motorist_name'],
				"motorist_type" => $data_motorist[0]['motorist_type'],
				"distributor_code" => $data_motorist[0]['distributor_code'],
				"target_harian" => $data_motorist[0]['target_harian'],
				"target_bulanan" => $data_motorist[0]['target_bulanan']
			);
			
			
			
					$comp = array(
						
						'title' => ' Edit Motorist',
						'content' => $this->load->view('edit-motorist',array('data'=>$data,'data_motorist'=>$data_motorist_type,'data_distributor'=>$data_distributor),true),
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
				$id_motorist = $_POST['id_motorist'];
				$motorist_code = $_POST['motorist_code'];
				$motorist_name = $_POST['motorist_name'];
				$motorist_type = $_POST['motorist_type'];
				$distributor_code = $_POST['distributor_code'];
				$target_bulanan = $_POST['target_bulanan'];
				$target_harian = $_POST['target_harian'];
				$password = $_POST['password'];
				
				
				if($password=="")
				{
				
					$data_update = array(
					
					"motorist_code" => $motorist_code,
					"motorist_name" => $motorist_name,
					"motorist_type" => $motorist_type,
					"distributor_code" => $distributor_code,
					"target_bulanan" => $target_bulanan,
					"target_harian" => $target_harian
	
					);
				}
				else
				{
					$data_update = array(
					
					"motorist_code" => $motorist_code,
					"motorist_name" => $motorist_name,
					"motorist_type" => $motorist_type,
					"distributor_code" => $distributor_code,
					"target_bulanan" => $target_bulanan,
					"target_harian" => $target_harian,
					"password" => md5($password),
	
					);
					
					}
				
				$where = array("id_motorist"=>$id_motorist);
				
				//Check Product Apakah sudah ada dengan kode produk dan type motorist yang sama
				$check = $this->model_motorist->getMotorist("WHERE motorist_code = '".$motorist_code."' AND distributor_code = '".$distributor_code."' and id_motorist != '".$id_motorist."' ");
				if($check->num_rows() >=1 )
				{
					$this->session->set_flashdata('message_failed',"Sorry data already exist!");
					redirect('motorist');
					
					}
				else
				{
				
					//Update Motorist
					$res = $this->model_motorist->UpdateData("motorist",$data_update,$where);
					if($res>=1)
					{
						$this->session->set_flashdata('message_success',"Data motorist has been successfully updated!");
						redirect('motorist');
						
						}
					else
					{
						$this->session->set_flashdata('message_failed',"Data motorist failed to update!");
						redirect('motorist');
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
	
	
	
	
	public function deleteMotorist($id_motorist)
	{
		
			date_default_timezone_set('Asia/Jakarta');
			ini_set('memory_limit', '-1');
			
			if ($this->tank_auth->is_logged_in()) {
			$user	= $this->tank_auth->get_username();
			$data_account = $this->model_account_master->getAccount("WHERE username = '".$user."' ")->result_array();
			$data_role = $this->model_account_master->getRole("WHERE id_role = '".$data_account[0]['user_access']."' ")->result_array();
			$user_role = $data_account[0]['user_type'];
			$code_role = $data_account[0]['code'];
			
			if($data_role[0]['delete_motorist']=='yes')
			{
				
			$this->load->helper('form');
			$this->load->helper('url');
			$this->load->library('form_validation');
			$this->form_validation->set_rules('id_motorist','ID Motorist','required');
			
			if($this->form_validation->run()==FALSE){
			
			$check_motorist = $this->model_motorist->getMotorist("WHERE id_motorist = '".$id_motorist."' ");
			if($check_motorist->num_rows() >=1)
			{	
			
			$data_motorist = $this->model_motorist->getMotoristData("id_motorist = '".$id_motorist."' ");
					$comp = array(
						
						'title' => ' Delete Product',
						'content' => $this->load->view('delete-motorist',array("data_motorist"=>$data_motorist),true),
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
				$id_motorist = $_POST['id_motorist'];
				$where = array("id_motorist" => $id_motorist);
				
		
					//Update Product
					$res = $this->model_motorist->DeleteData("motorist",$where);
					if($res>=1)
					{
						$this->session->set_flashdata('message_success',"Data motorist has been successfully deleted!");
						redirect('motorist');
						
						}
					else
					{
						$this->session->set_flashdata('message_failed',"Data motorist failed to delete!");
						redirect('motorist');
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
	
	
	public function importMotorist()
	{
		
			date_default_timezone_set('Asia/Jakarta');
			ini_set('memory_limit', '-1');
			
			if ($this->tank_auth->is_logged_in()) {
			$user	= $this->tank_auth->get_username();
			$data_account = $this->model_account_master->getAccount("WHERE username = '".$user."' ")->result_array();
			$data_role = $this->model_account_master->getRole("WHERE id_role = '".$data_account[0]['user_access']."' ")->result_array();
			$user_role = $data_account[0]['user_type'];
			$code_role = $data_account[0]['code'];
			
			if($data_role[0]['import_motorist']=='yes')
			{
				
			$this->load->helper('form', 'html', 'file');
			$this->load->helper('url');
			$this->load->library('form_validation');
		
			
			
					
					$data = array ("");
					$comp = array(
						
						'title' => ' Import Motorist',
						'content' => $this->load->view('import-motorist',array('data'=>$data),true),
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
	
	
	
	public function doImportMotorist()
	{

			date_default_timezone_set('Asia/Jakarta');
			ini_set('memory_limit', '-1');
			
			if ($this->tank_auth->is_logged_in()) {
			$user	= $this->tank_auth->get_username();
			$data_account = $this->model_account_master->getAccount("WHERE username = '".$user."' ")->result_array();
			$data_role = $this->model_account_master->getRole("WHERE id_role = '".$data_account[0]['user_access']."' ")->result_array();
			$user_role = $data_account[0]['user_type'];
			$code_role = $data_account[0]['code'];
			
			if($data_role[0]['import_motorist']=='yes')
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
				redirect('motorist');
				
				
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
												
												
					//Check Motorist Type
					$select_motorist = $this->model_motorist->getMotoristType("WHERE motorist_type = '".$rowData[0][3]."' ");
					$check_motorist = $select_motorist->num_rows();
					if($check_motorist>=1)
					{
						
						$data_motorist = $select_motorist->result_array();
						
						$password = md5($rowData[0][4]);
						$check = $this->model_motorist->getMotorist("WHERE motorist_code = '".$rowData[0][1]."' AND distributor_code = '".$rowData[0][0]."' ");
						if($check->num_rows() >=1 )
						{
							$data_update = array(
								"motorist_name" => $rowData[0][2],
								"motorist_type" => $data_motorist[0]['id_motorist_type'],
								"target_harian" => $rowData[0][5],
								"target_bulanan" =>  $rowData[0][6],
								"password" => $password
								
							);
							$where = array(
								"motorist_code" => $rowData[0][1],
								"distributor_code" => $rowData[0][0]
							);
							
							$res = $this->model_motorist->UpdateData("motorist",$data_update,$where);
						
							}
						else
						{
							$data_motorist_urutan = $this->model_motorist->getMotorist("WHERE distributor_code = '".$rowData[0][0]."' ORDER BY urutan_motorist DESC ")->result_array();
							$urutan_motorist = $data_motorist_urutan[0]['urutan_motorist'] + 1;
				
							$data_insert = array(
								"motorist_code" => $rowData[0][1],
								"motorist_name" => $rowData[0][2],
								"distributor_code" => $rowData[0][0],
								"motorist_type" => $data_motorist[0]['id_motorist_type'],
								"password" => $password,
								"target_harian" => $rowData[0][5],
								"target_bulanan" =>  $rowData[0][6],
								"urutan_motorist" =>  $urutan_motorist
								
							);
							
							
							//Insert Data
							$res = $this->model_motorist->insertData("motorist",$data_insert);
						
						}
					
					}
					
					
				
				
			}
				@unlink($inputFileName);
				$this->session->set_flashdata('message_success','Data imported successfully');
				redirect('motorist');
			
               
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
	
	
	
	public function exportJourneyPlanMotorist()
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
		$area = isset($_GET['area']) ? $_GET['area'] : '';
		$distributor = isset($_GET['distributor']) ? $_GET['distributor'] : '';
		$regional = isset($_GET['regional']) ? $_GET['regional'] : '';
		$motorist_type = isset($_GET['motorist_type']) ? $_GET['motorist_type'] : '';
		
		
		date_default_timezone_set('Asia/Jakarta');
		$day = date('l');
		$date_now = date('Y-m-d');
		
		$this->db->select(" * ,(SELECT COUNT(customer_code) FROM store as s WHERE s.motorist_code = motorist.motorist_code AND customer_status = 'active' AND frequency = 'f2' AND s.distributor_code = motorist.distributor_code AND s.day_visit = 'monday') as f2_monday,
		(SELECT COUNT(customer_code) FROM store as s WHERE s.motorist_code = motorist.motorist_code AND s.distributor_code = motorist.distributor_code AND customer_status = 'active' AND frequency = 'F1' AND s.day_visit = 'monday') as f1_monday,
		(SELECT COUNT(customer_code) FROM store as s WHERE s.motorist_code = motorist.motorist_code AND s.distributor_code = motorist.distributor_code AND customer_status = 'active' AND frequency = 'W' AND s.day_visit = 'monday') as w_monday,
		(SELECT COUNT(customer_code) FROM store as s WHERE s.motorist_code = motorist.motorist_code AND s.distributor_code = motorist.distributor_code AND customer_status = 'active' AND frequency = 'F1' AND s.day_visit = 'tuesday') as f1_tuesday,
		(SELECT COUNT(customer_code) FROM store as s WHERE s.motorist_code = motorist.motorist_code AND s.distributor_code = motorist.distributor_code AND customer_status = 'active' AND frequency = 'F2' AND s.day_visit = 'tuesday') as f2_tuesday,
		(SELECT COUNT(customer_code) FROM store as s WHERE s.motorist_code = motorist.motorist_code AND s.distributor_code = motorist.distributor_code AND customer_status = 'active' AND frequency = 'W' AND s.day_visit = 'tuesday') as w_tuesday,
		(SELECT COUNT(customer_code) FROM store as s WHERE s.motorist_code = motorist.motorist_code AND s.distributor_code = motorist.distributor_code AND customer_status = 'active' AND frequency = 'F2' AND s.day_visit = 'wednesday') as f2_wednesday,
		(SELECT COUNT(customer_code) FROM store as s WHERE s.motorist_code = motorist.motorist_code AND s.distributor_code = motorist.distributor_code AND customer_status = 'active' AND frequency = 'F1' AND s.day_visit = 'wednesday') as f1_wednesday,
		(SELECT COUNT(customer_code) FROM store as s WHERE s.motorist_code = motorist.motorist_code AND s.distributor_code = motorist.distributor_code AND customer_status = 'active' AND frequency = 'W' AND s.day_visit = 'wednesday') as w_wednesday,
		(SELECT COUNT(customer_code) FROM store as s WHERE s.motorist_code = motorist.motorist_code AND s.distributor_code = motorist.distributor_code AND customer_status = 'active' AND frequency = 'F2' AND s.day_visit = 'thursday') as f2_thursday,
		(SELECT COUNT(customer_code) FROM store as s WHERE s.motorist_code = motorist.motorist_code AND s.distributor_code = motorist.distributor_code AND customer_status = 'active' AND frequency = 'F1' AND s.day_visit = 'thursday') as f1_thursday,
		(SELECT COUNT(customer_code) FROM store as s WHERE s.motorist_code = motorist.motorist_code AND s.distributor_code = motorist.distributor_code  AND customer_status = 'active' AND frequency = 'W' AND s.day_visit = 'thursday') as w_thursday,
		(SELECT COUNT(customer_code) FROM store as s WHERE s.motorist_code = motorist.motorist_code AND s.distributor_code = motorist.distributor_code AND customer_status = 'active' AND frequency = 'F2' AND s.day_visit = 'friday') as f2_friday,
		(SELECT COUNT(customer_code) FROM store as s WHERE s.motorist_code = motorist.motorist_code AND s.distributor_code = motorist.distributor_code AND customer_status = 'active' AND frequency = 'F1' AND s.day_visit = 'friday') as f1_friday,
		(SELECT COUNT(customer_code) FROM store as s WHERE s.motorist_code = motorist.motorist_code AND s.distributor_code = motorist.distributor_code AND customer_status = 'active' AND frequency = 'W' AND s.day_visit = 'friday') as w_friday,
		(SELECT COUNT(customer_code) FROM store as s WHERE s.motorist_code = motorist.motorist_code AND s.distributor_code = motorist.distributor_code AND customer_status = 'active' AND frequency = 'F2' AND s.day_visit = 'saturday') as f2_saturday,
		(SELECT COUNT(customer_code) FROM store as s WHERE s.motorist_code = motorist.motorist_code AND s.distributor_code = motorist.distributor_code  AND customer_status = 'active' AND frequency = 'W' AND s.day_visit = 'saturday') as w_saturday,
		(SELECT COUNT(customer_code) FROM store as s WHERE s.motorist_code = motorist.motorist_code AND s.distributor_code = motorist.distributor_code AND customer_status = 'active' AND frequency = 'F1' AND s.day_visit = 'saturday') as f1_saturday
		
		");
		if($regional!="")
		{
			$this->db->where('regional in ('.$regional.') ');
		}
		
		if($motorist_type!="")
		{
			$this->db->where('motorist.motorist_type in ('.$motorist_type.') ');
		}
		
		if($area!="")
		{
			$this->db->where('distributor.area in ('.$area.') ');
		}
		
		if($distributor!="")
		{
			$this->db->where('distributor.distributor_code in ('.$distributor.') ');
		}
		
		if($regional!="")
		{
			$this->db->where('regional in ('.$regional.') ');
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
		
		$this->db->like('motorist_code', $search);
		$this->db->join('distributor', 'distributor.distributor_code = motorist.distributor_code');
		$this->db->join('motorist_type', 'motorist_type.id_motorist_type = motorist.motorist_type');
		$query = $this->db->get('motorist');
		
		
		
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
		
		function num2alpha($n)
		{
			for($r = ""; $n >= 0; $n = intval($n / 26) - 1)
				$r = chr($n%26 + 0x41) . $r;
			return $r;
		}
		//Set Width Column
		for ($i = 1; $i <= 100; $i++) {
			$column_alpha = num2alpha($i);
			$objPHPExcel->getActiveSheet()->getColumnDimension($column_alpha)->setAutoSize(true);
		}
		
		
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 1, "Journey Plan Motorist");
		//Merge And Center Title
		$objPHPExcel->getActiveSheet()->mergeCells('A1:D1');
		
		
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, 3, "Journey Plan Motorist");
		//Merge And Center Title
		$objPHPExcel->getActiveSheet()->mergeCells('G3:K3');
		$objPHPExcel->getActiveSheet()->mergeCells('L3:P3');
		$objPHPExcel->getActiveSheet()->mergeCells('Q3:U3');
		$objPHPExcel->getActiveSheet()->mergeCells('V3:Z3');
		$objPHPExcel->getActiveSheet()->mergeCells('AA3:AE3');
		$objPHPExcel->getActiveSheet()->mergeCells('AF3:AJ3');
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 2, "Date : ".$date);
		
		//Merge And Center Date
		$objPHPExcel->getActiveSheet()->mergeCells('A2:D2');
		
		//Set Font Color Title
		$objPHPExcel->getActiveSheet()->getStyle('A1:D2')->applyFromArray($FontstyleTitle);
		
		//Set Font Color Header
		$objPHPExcel->getActiveSheet()->getStyle('B4:AJ4')->applyFromArray($Fontstyle);
		
		//Set Backgroung Color Header
		$objPHPExcel->getActiveSheet()->getStyle('B4:AJ4')->applyFromArray(
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
		
		"f1" => "f1",
		"f2" => "f2",
		"W" => "W",
		"Total F1 + W" => "Total F1 + W",
		"Total F2 + W" => "Total F2 + W",
		"f1_2" => "f1",
		"f2_2" => "f2",
		"W_2" => "W",
		"Total F1 + W_2" => "Total F1 + W",
		"Total F2 + W_2" => "Total F2 + W",
		"f1_3" => "f1",
		"f2_3" => "f2",
		"W_3" => "W",
		"Total F1 + W_3" => "Total F1 + W",
		"Total F2 + W_3" => "Total F2 + W",
		"f1_4" => "f1",
		"f2_4" => "f2",
		"W_4" => "W",
		"Total F1 + W_4" => "Total F1 + W",
		"Total F2 + W_4" => "Total F2 + W",
		"f1_5" => "f1",
		"f2_5" => "f2",
		"W_5" => "W",
		"Total F1 + W_5" => "Total F1 + W",
		"Total F2 + W_5" => "Total F2 + W",
		"f1_6" => "f1",
		"f2_6" => "f2",
		"W_6" => "W",
		"Total F1 + W_6" => "Total F1 + W",
		"Total F2 + W_6" => "Total F2 + W"
		
		);
        $col = 6;
        foreach ($fields as $field)
        {
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, 4, $field);
			
            $col++;
        }
		
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, 4, "No");
		
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, 4, "Motorist");
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, 4, "Motorist Type");
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, 4, "Distributor Code");
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, 4, "Distributor Name");
		
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, 3, "Monday");
		//Merge And Center Title
		//$objPHPExcel->getActiveSheet()->mergeCells('D3:H3');
		
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(11, 3, "Tuesday");
		//Merge And Center Title
		//$objPHPExcel->getActiveSheet()->mergeCells('I3:M3');
		
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(16, 3, "Wednesday");
		//Merge And Center Title
		//$objPHPExcel->getActiveSheet()->mergeCells('N3:R3');
		
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(21, 3, "Thursday");
		//Merge And Center Title
		//$objPHPExcel->getActiveSheet()->mergeCells('S3:W3');
		
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(26, 3, "Friday");
		//Merge And Center Title
		//$objPHPExcel->getActiveSheet()->mergeCells('X3:AB3');
		
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(31, 3, "Saturday");
		//Merge And Center Title
		//$objPHPExcel->getActiveSheet()->mergeCells('AC3:AJ3');
		
		

 
        // Fetching the table data
        $row = 5;
		$no = 1;
        foreach($query->result_array() as $data)
        {
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $row, $no);
			
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $row, $data['motorist_code'].'-'.$data['motorist_name']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $row, $data['motorist_type']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $row, $data['distributor_code']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, $row, $data['distributor_name']);
			
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, $row, $data['f1_monday']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, $row, $data['f2_monday']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8, $row, $data['w_monday']);
			$total_monday_1 = $data['f1_monday']+$data['w_monday'];
			$total_monday_2 = $data['f2_monday']+$data['w_monday'];
			
			if($total_monday_1<30)
			{
				$objPHPExcel->getActiveSheet()->getStyle("J".$row)->applyFromArray($Fontstyle);
				$objPHPExcel->getActiveSheet()->getStyle("J".$row)->applyFromArray(
			 array(
				'fill' => array(
					'type' => PHPExcel_Style_Fill::FILL_SOLID,
					'color' => array('rgb' => 'ff1b20')
				)
			 ) 
			 );	
			 
			 }
			 
			 if($total_monday_2<30)
			{
				$objPHPExcel->getActiveSheet()->getStyle("K".$row)->applyFromArray($Fontstyle);
				$objPHPExcel->getActiveSheet()->getStyle("K".$row)->applyFromArray(
			 array(
				'fill' => array(
					'type' => PHPExcel_Style_Fill::FILL_SOLID,
					'color' => array('rgb' => 'ff1b20')
				)
			 ) 
			 );	
			 
			 }
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9, $row, $total_monday_1);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(10, $row, $total_monday_2);
			
			
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(11, $row, $data['f1_tuesday']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(12, $row, $data['f2_tuesday']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(13, $row, $data['w_tuesday']);
			$total_monday_1 = $data['f1_tuesday']+$data['w_tuesday'];
			$total_monday_2 = $data['f2_tuesday']+$data['w_tuesday'];
			
			if($total_monday_1<30)
			{
				$objPHPExcel->getActiveSheet()->getStyle("O".$row)->applyFromArray($Fontstyle);
				$objPHPExcel->getActiveSheet()->getStyle("O".$row)->applyFromArray(
			 array(
				'fill' => array(
					'type' => PHPExcel_Style_Fill::FILL_SOLID,
					'color' => array('rgb' => 'ff1b20')
				)
			 ) 
			 );	
			 
			 }
			 
			 if($total_monday_2<30)
			{
				$objPHPExcel->getActiveSheet()->getStyle("P".$row)->applyFromArray($Fontstyle);
				$objPHPExcel->getActiveSheet()->getStyle("P".$row)->applyFromArray(
			 array(
				'fill' => array(
					'type' => PHPExcel_Style_Fill::FILL_SOLID,
					'color' => array('rgb' => 'ff1b20')
				)
			 ) 
			 );	
			 
			 }
			 
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(14, $row, $total_monday_1);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(15, $row, $total_monday_2);
			
			
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(16, $row, $data['f1_wednesday']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(17, $row, $data['f2_wednesday']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(18, $row, $data['w_wednesday']);
			$total_monday_1 = $data['f1_wednesday']+$data['w_wednesday'];
			$total_monday_2 = $data['f2_wednesday']+$data['w_wednesday'];
			if($total_monday_1<30)
			{
				$objPHPExcel->getActiveSheet()->getStyle("T".$row)->applyFromArray($Fontstyle);
				$objPHPExcel->getActiveSheet()->getStyle("T".$row)->applyFromArray(
			 array(
				'fill' => array(
					'type' => PHPExcel_Style_Fill::FILL_SOLID,
					'color' => array('rgb' => 'ff1b20')
				)
			 ) 
			 );	
			 
			 }
			 
			 if($total_monday_2<30)
			{
				$objPHPExcel->getActiveSheet()->getStyle("U".$row)->applyFromArray($Fontstyle);
				$objPHPExcel->getActiveSheet()->getStyle("U".$row)->applyFromArray(
			 array(
				'fill' => array(
					'type' => PHPExcel_Style_Fill::FILL_SOLID,
					'color' => array('rgb' => 'ff1b20')
				)
			 ) 
			 );	
			 
			 }
			 
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(19, $row, $total_monday_1);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(20, $row, $total_monday_2);
			
			
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(21, $row, $data['f1_thursday']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(22, $row, $data['f2_thursday']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(23, $row, $data['w_thursday']);
			$total_monday_1 = $data['f1_thursday']+$data['w_thursday'];
			$total_monday_2 = $data['f2_thursday']+$data['w_thursday'];
			if($total_monday_1<30)
			{
				$objPHPExcel->getActiveSheet()->getStyle("Y".$row)->applyFromArray($Fontstyle);
				$objPHPExcel->getActiveSheet()->getStyle("Y".$row)->applyFromArray(
			 array(
				'fill' => array(
					'type' => PHPExcel_Style_Fill::FILL_SOLID,
					'color' => array('rgb' => 'ff1b20')
				)
			 ) 
			 );	
			 
			 }
			 
			 if($total_monday_2<30)
			{
				$objPHPExcel->getActiveSheet()->getStyle("Z".$row)->applyFromArray($Fontstyle);
				$objPHPExcel->getActiveSheet()->getStyle("Z".$row)->applyFromArray(
			 array(
				'fill' => array(
					'type' => PHPExcel_Style_Fill::FILL_SOLID,
					'color' => array('rgb' => 'ff1b20')
				)
			 ) 
			 );	
			 
			 }
			 
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(24, $row, $total_monday_1);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(25, $row, $total_monday_2);
			
			
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(26, $row, $data['f1_friday']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(27, $row, $data['f2_friday']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(28, $row, $data['w_friday']);
			$total_monday_1 = $data['f1_friday']+$data['w_friday'];
			$total_monday_2 = $data['f2_friday']+$data['w_friday'];
			if($total_monday_1<30)
			{
				$objPHPExcel->getActiveSheet()->getStyle("AD".$row)->applyFromArray($Fontstyle);
				$objPHPExcel->getActiveSheet()->getStyle("AD".$row)->applyFromArray(
			 array(
				'fill' => array(
					'type' => PHPExcel_Style_Fill::FILL_SOLID,
					'color' => array('rgb' => 'ff1b20')
				)
			 ) 
			 );	
			 
			 }
			 
			 if($total_monday_2<30)
			{
				$objPHPExcel->getActiveSheet()->getStyle("AE".$row)->applyFromArray($Fontstyle);
				$objPHPExcel->getActiveSheet()->getStyle("AE".$row)->applyFromArray(
			 array(
				'fill' => array(
					'type' => PHPExcel_Style_Fill::FILL_SOLID,
					'color' => array('rgb' => 'ff1b20')
				)
			 ) 
			 );	
			 
			 }
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(29, $row, $total_monday_1);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(30, $row, $total_monday_2);
			
			
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(31, $row, $data['f1_saturday']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(32, $row, $data['f2_saturday']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(33, $row, $data['w_saturday']);
			$total_monday_1 = $data['f1_saturday']+$data['w_saturday'];
			$total_monday_2 = $data['f2_saturday']+$data['w_saturday'];
			if($total_monday_1<30)
			{
				$objPHPExcel->getActiveSheet()->getStyle("AI".$row)->applyFromArray($Fontstyle);
				$objPHPExcel->getActiveSheet()->getStyle("AI".$row)->applyFromArray(
			 array(
				'fill' => array(
					'type' => PHPExcel_Style_Fill::FILL_SOLID,
					'color' => array('rgb' => 'ff1b20')
				)
			 ) 
			 );	
			 
			 }
			 
			 if($total_monday_2<30)
			{
				$objPHPExcel->getActiveSheet()->getStyle("AJ".$row)->applyFromArray($Fontstyle);
				$objPHPExcel->getActiveSheet()->getStyle("AJ".$row)->applyFromArray(
			 array(
				'fill' => array(
					'type' => PHPExcel_Style_Fill::FILL_SOLID,
					'color' => array('rgb' => 'ff1b20')
				)
			 ) 
			 );	
			 
			 }
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(34, $row, $total_monday_1);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(35, $row, $total_monday_2);
			
			
            $row++;
			$no++;
        }
		
	   $last_row = $row-1;
	   //Set Border
       $objPHPExcel->getActiveSheet()->getStyle("B3".":"."AJ".$last_row)->applyFromArray($BStyle);
	   $objPHPExcel->getActiveSheet()->getStyle("B3".":"."AJ".$last_row)->applyFromArray($styleAlign);
       $objPHPExcel->setActiveSheetIndex(0);
 
        $objWriter = IOFactory::createWriter($objPHPExcel, 'Excel5');
 		
		
	   // Sending headers to force the user to download the file
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Journey-Plan-'.$date.'.xls"');
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
	
	
	
	
	
	public function exportStoreJourney()
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
		
		
		$motorist_code = isset($_GET['motorist_code']) ? $_GET['motorist_code'] : '';
		$distributor_code = isset($_GET['distributor_code']) ? $_GET['distributor_code'] : '';
		
		$data_motorist = $this->model_motorist->getMotorist("WHERE distributor_code = '".$distributor_code."' AND motorist_code = '".$motorist_code."' ")->result_array();
		
		$day_visit = isset($_GET['day_visit']) ? $_GET['day_visit'] : '';
		$frequently = isset($_GET['frequently']) ? $_GET['frequently'] : '';
		
		if($motorist_code!='')
		{$this->db->where("store.motorist_code = '".$motorist_code."' ");}
		
		if($distributor_code!='')
		{$this->db->where("store.distributor_code = '".$distributor_code."' ");}
		
		if($day_visit!='')
		{$this->db->where("store.day_visit = '".$day_visit."' ");}
		
		
		if($frequently!='')
		{$this->db->where('store.frequency in ('.$frequently.') ');}
		
		
		
		$query = $this->db->get('store');
		
		
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
		
		
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 1, "Master Store Journey Motorist");
		//Merge And Center Title
		$objPHPExcel->getActiveSheet()->mergeCells('A1:D1');
		
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 2, "Motorist : ".$data_motorist[0]['motorist_name'].'-'.$data_motorist[0]['motorist_code']);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 3, "Distributor Code: ".$data_motorist[0]['distributor_code']);
		//Merge And Center Date
		$objPHPExcel->getActiveSheet()->mergeCells('A2:D2');
		
		//Set Font Color Title
		$objPHPExcel->getActiveSheet()->getStyle('A1:D3')->applyFromArray($FontstyleTitle);
		
		//Set Font Color Header
		$objPHPExcel->getActiveSheet()->getStyle('B4:I4')->applyFromArray($Fontstyle);
		
		//Set Backgroung Color Header
		$objPHPExcel->getActiveSheet()->getStyle('B4:I4')->applyFromArray(
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
		"Customer Name" => "Customer Name",
		"Customer Code" => "Customer Code",
		"Alamat" => "Alamat",
		"Kecamatan" => "Kecamatan",
		"Customer Contact" => "Customer Contact",
		"MTD Sales" => "MTD Sales",
		"Kelurahan" => "Kelurahan"
		
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
		$year = date('Y');
		$month = date('m');
		$tanggal_bulan_awal = $year.'-'.$month.'-01 00:00:00';
		$tanggal_bulan_akhir = $year.'-'.$month.'-31 23:59:59';
        foreach($query->result_array() as $data)
        {
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $row, $no);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $row, $data['customer_name']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $row, $data['customer_code']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $row, $data['address']);
		    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, $row, $data['districts']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, $row, $data['customer_contact']);
			
			$select_mtd_sales = $this->db->query("SELECT SUM(total_order) as total_order FROM orders WHERE customer_code = '".$data['customer_code']."' AND date BETWEEN '".$tanggal_bulan_awal."' AND '".$tanggal_bulan_akhir."' ")->result_array();
			if($select_mtd_sales[0]['total_order']=='')
			{$total_mtd = 0;}
			else
			{$total_mtd = $select_mtd_sales[0]['total_order'];}
						
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, $row, number_format($total_mtd, 0 , '' , '.' ));
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8, $row, $data['kelurahan']);
            $row++;
			$no++;
        }
		
	   $last_row = $row-1;
	   //Set Border
       $objPHPExcel->getActiveSheet()->getStyle("B4".":"."I".$last_row)->applyFromArray($BStyle);
	   $objPHPExcel->getActiveSheet()->getStyle("B4".":"."I".$last_row)->applyFromArray($styleAlign);
       $objPHPExcel->setActiveSheetIndex(0);
 
        $objWriter = IOFactory::createWriter($objPHPExcel, 'Excel5');
 		
		
	   // Sending headers to force the user to download the file
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Master-Store-Journey-Motorist-'.$data_motorist[0]['motorist_name'].'-'.$data_motorist[0]['motorist_code'].'.xls"');
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
		
		
		
	public function exportMotorist()
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
		$regional = isset($_GET['regional']) ? $_GET['regional'] : '';
		$motorist_type = isset($_GET['motorist_type']) ? $_GET['motorist_type'] : '';
		
		
		if($search!="")
		{
			$this->db->like('motorist_code', $search);	
		}
		
		if($regional!="")
		{
			$this->db->where('regional in ('.$regional.') ');
		}
		
		if($motorist_type!="")
		{
			$this->db->where('motorist.motorist_type in ('.$motorist_type.') ');
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
		
		
		$this->db->join('distributor', 'distributor.distributor_code = motorist.distributor_code');
		$this->db->join('motorist_type', 'motorist_type.id_motorist_type = motorist.motorist_type');
		$query = $this->db->get('motorist');
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
		
		
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 1, "Master Motorist");
		//Merge And Center Title
		$objPHPExcel->getActiveSheet()->mergeCells('A1:D1');
		
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 2, "Date : ".$date);
		
		//Merge And Center Date
		$objPHPExcel->getActiveSheet()->mergeCells('A2:D2');
		
		//Set Font Color Title
		$objPHPExcel->getActiveSheet()->getStyle('A1:D2')->applyFromArray($FontstyleTitle);
		
		//Set Font Color Header
		$objPHPExcel->getActiveSheet()->getStyle('B4:I4')->applyFromArray($Fontstyle);
		
		//Set Backgroung Color Header
		$objPHPExcel->getActiveSheet()->getStyle('B4:I4')->applyFromArray(
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
		"Motorist Code" => "Motorist Code",
		"Motorist Name" => "Motorist Name",
		"Distributor Code" => "Distributor Code",
		"Distributor Name" => "Distributor Name",
		"Motorist Type" => "Motorist Type",
		"Daily Target Sales" => "Daily Target Sales",
		"Monthly Target Sales" => "Monthly Target Sales"
		
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
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $row, $data['motorist_code']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $row, $data['motorist_name']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $row, $data['distributor_code']);
		    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, $row, $data['distributor_name']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, $row, $data['motorist_type']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, $row, $data['target_harian']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8, $row, $data['target_bulanan']);
            $row++;
			$no++;
        }
		
	   $last_row = $row-1;
	   //Set Border
       $objPHPExcel->getActiveSheet()->getStyle("B4".":"."I".$last_row)->applyFromArray($BStyle);
	   $objPHPExcel->getActiveSheet()->getStyle("B4".":"."I".$last_row)->applyFromArray($styleAlign);
       $objPHPExcel->setActiveSheetIndex(0);
 
        $objWriter = IOFactory::createWriter($objPHPExcel, 'Excel5');
 		
		
	   // Sending headers to force the user to download the file
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Master-Motorist-'.$date.'.xls"');
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
		
	
	
	public function exportSwicthingMotoristNoo()
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
		$tahun = isset($_GET['tahun']) ? $_GET['tahun'] : '';
		$search = isset($_GET['search']) ? $_GET['search'] : '';
		$regional = isset($_GET['regional']) ? $_GET['regional'] : '';
		$area = isset($_GET['area']) ? $_GET['area'] : '';
		$distributor = isset($_GET['distributor']) ? $_GET['distributor'] : '';
		
		
		date_default_timezone_set('Asia/Jakarta');
		
		$year = date('Y');
		if($tahun!="")
		{$year=$tahun;}
		
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
			$this->db->where('distributor.area in ('.$area.') ');
		}
		
		
		
		
		$this->db->select(" * ,
		(SELECT COUNT(id_store) FROM store as n WHERE motorist.motorist_code = n.motorist_code AND motorist.distributor_code = n.distributor_code AND n.customer_create_date between '".$year.'-01-01 00:00:00'."' AND '".$year.'-01-31 23:59:59'."' AND n.product = 'Bukan_Carnation' ) as total_store_januari,
		(SELECT COUNT(id_store) FROM store as n WHERE motorist.motorist_code = n.motorist_code AND motorist.distributor_code = n.distributor_code AND n.customer_create_date between '".$year.'-02-01 00:00:00'."' AND '".$year.'-02-31 23:59:59'."' AND n.product = 'Bukan_Carnation' ) as total_store_februari,
		(SELECT COUNT(id_store) FROM store as n WHERE motorist.motorist_code = n.motorist_code AND motorist.distributor_code = n.distributor_code AND n.customer_create_date between '".$year.'-03-01 00:00:00'."' AND '".$year.'-03-31 23:59:59'."' AND n.product = 'Bukan_Carnation' ) as total_store_maret,
		(SELECT COUNT(id_store) FROM store as n WHERE motorist.motorist_code = n.motorist_code AND motorist.distributor_code = n.distributor_code AND n.customer_create_date between '".$year.'-04-01 00:00:00'."' AND '".$year.'-04-31 23:59:59'."' AND n.product = 'Bukan_Carnation' ) as total_store_april,
		(SELECT COUNT(id_store) FROM store as n WHERE motorist.motorist_code = n.motorist_code AND motorist.distributor_code = n.distributor_code AND n.customer_create_date between '".$year.'-05-01 00:00:00'."' AND '".$year.'-05-31 23:59:59'."' AND n.product = 'Bukan_Carnation' ) as total_store_mei,
		(SELECT COUNT(id_store) FROM store as n WHERE motorist.motorist_code = n.motorist_code AND motorist.distributor_code = n.distributor_code AND n.customer_create_date between '".$year.'-06-01 00:00:00'."' AND '".$year.'-06-31 23:59:59'."' AND n.product = 'Bukan_Carnation' ) as total_store_juni,
		(SELECT COUNT(id_store) FROM store as n WHERE motorist.motorist_code = n.motorist_code AND motorist.distributor_code = n.distributor_code AND n.customer_create_date between '".$year.'-07-01 00:00:00'."' AND '".$year.'-07-31 23:59:59'."' AND n.product = 'Bukan_Carnation' ) as total_store_juli,
		(SELECT COUNT(id_store) FROM store as n WHERE motorist.motorist_code = n.motorist_code AND motorist.distributor_code = n.distributor_code AND n.customer_create_date between '".$year.'-08-01 00:00:00'."' AND '".$year.'-08-31 23:59:59'."' AND n.product = 'Bukan_Carnation' ) as total_store_agustus,
		(SELECT COUNT(id_store) FROM store as n WHERE motorist.motorist_code = n.motorist_code AND motorist.distributor_code = n.distributor_code AND n.customer_create_date between '".$year.'-09-01 00:00:00'."' AND '".$year.'-09-31 23:59:59'."' AND n.product = 'Bukan_Carnation' ) as total_store_september,
		(SELECT COUNT(id_store) FROM store as n WHERE motorist.motorist_code = n.motorist_code AND motorist.distributor_code = n.distributor_code AND n.customer_create_date between '".$year.'-10-01 00:00:00'."' AND '".$year.'-10-31 23:59:59'."' AND n.product = 'Bukan_Carnation' ) as total_store_oktober,
		(SELECT COUNT(id_store) FROM store as n WHERE motorist.motorist_code = n.motorist_code AND motorist.distributor_code = n.distributor_code AND n.customer_create_date between '".$year.'-11-01 00:00:00'."' AND '".$year.'-11-31 23:59:59'."' AND n.product = 'Bukan_Carnation' ) as total_store_november,
		(SELECT COUNT(id_store) FROM store as n WHERE motorist.motorist_code = n.motorist_code AND motorist.distributor_code = n.distributor_code AND n.customer_create_date between '".$year.'-12-01 00:00:00'."' AND '".$year.'-12-31 23:59:59'."' AND n.product = 'Bukan_Carnation' ) as total_store_desember");
		
		
		$this->db->where("motorist.motorist_type in (".$ket.") ");
		if($user_role=="Ado")
		{
			$this->db->where("motorist.distributor_code = '".$code_role."' ");
		}
		else if($user_role=="Regional")
		{
			$this->db->where("distributor.regional = '".$code_role."' ");		
		}
		
		
		$this->db->like('motorist_code', $search);
		$this->db->join('distributor', 'distributor.distributor_code = motorist.distributor_code');
		$this->db->join('motorist_type', 'motorist_type.id_motorist_type = motorist.motorist_type');
		$query = $this->db->get('motorist');
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
		
		$Fontstyle2 = array(
		'font'  => array(
			'bold'  => true,
			'color' => array('rgb' => 'ffffff')
		));
		
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
		
		
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 1, "Master Switching Outlet Motorist");
		//Merge And Center Title
		$objPHPExcel->getActiveSheet()->mergeCells('A1:D1');
		
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 2, "Date : ".$date);
		
		//Merge And Center Date
		$objPHPExcel->getActiveSheet()->mergeCells('A2:D2');
		
		//Set Font Color Title
		$objPHPExcel->getActiveSheet()->getStyle('A1:D2')->applyFromArray($FontstyleTitle);
		
		//Set Font Color Header
		$objPHPExcel->getActiveSheet()->getStyle('B4:U4')->applyFromArray($Fontstyle);
		
		//Set Backgroung Color Header
		$objPHPExcel->getActiveSheet()->getStyle('B4:U4')->applyFromArray(
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
		"Nama Motorist" => "Nama Motorist",
		"Kode Motorist" => "Kode Motorist",
		"Regional" => "Regional",
		"Area" => "Area",
		"Distributor" => "Distributor",
		
		"Target Outlet Switching" => "Target Outlet Switching",
		"Januari" => "Januari",
		"Februari" => "Februari",
		"Maret" => "Maret",
		"April" => "April",
		"Mei" => "Mei",
		"Juni" => "Juni",
		"Juli" => "Juli",
		"Agustus" => "Agustus",
		"September" => "September",
		"Oktober" => "Oktober",
		"November" => "November",
		"Desember" => "Desember"
		
		
		
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
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $row, $data['motorist_name']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $row, $data['motorist_code']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $row, $data['regional']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, $row, $data['area']);
		    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, $row, $data['distributor_code']);
			
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, $row, '10');
			
			if($data['total_store_januari']<10)
			{
				$objPHPExcel->getActiveSheet()->getStyle("I".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle("I".$row)->applyFromArray(
						 array(
							'fill' => array(
								'type' => PHPExcel_Style_Fill::FILL_SOLID,
								'color' => array('rgb' => 'F00')
							)
						 ) 
				);
			}
			else
			{
				$objPHPExcel->getActiveSheet()->getStyle("I".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle("I".$row)->applyFromArray(
						 array(
							'fill' => array(
								'type' => PHPExcel_Style_Fill::FILL_SOLID,
								'color' => array('rgb' => '138001')
							)
						 ) 
				);

				
				}
					 
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8, $row, $data['total_store_januari']);
			if($data['total_store_februari']<10)
			{
				$objPHPExcel->getActiveSheet()->getStyle("J".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle("J".$row)->applyFromArray(
						 array(
							'fill' => array(
								'type' => PHPExcel_Style_Fill::FILL_SOLID,
								'color' => array('rgb' => 'F00')
							)
						 ) 
				);
			}
			else
			{
				$objPHPExcel->getActiveSheet()->getStyle("J".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle("J".$row)->applyFromArray(
						 array(
							'fill' => array(
								'type' => PHPExcel_Style_Fill::FILL_SOLID,
								'color' => array('rgb' => '138001')
							)
						 ) 
				);

				
				}
				
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9, $row, $data['total_store_februari']);
			
			
			
			
			if($data['total_store_maret']<10)
			{
				$objPHPExcel->getActiveSheet()->getStyle("K".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle("K".$row)->applyFromArray(
						 array(
							'fill' => array(
								'type' => PHPExcel_Style_Fill::FILL_SOLID,
								'color' => array('rgb' => 'F00')
							)
						 ) 
				);
			}
			else
			{
				$objPHPExcel->getActiveSheet()->getStyle("K".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle("K".$row)->applyFromArray(
						 array(
							'fill' => array(
								'type' => PHPExcel_Style_Fill::FILL_SOLID,
								'color' => array('rgb' => '138001')
							)
						 ) 
				);

				
				}
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(10, $row, $data['total_store_maret']);
			
			
			
			
			if($data['total_store_april']<10)
			{
				$objPHPExcel->getActiveSheet()->getStyle("L".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle("L".$row)->applyFromArray(
						 array(
							'fill' => array(
								'type' => PHPExcel_Style_Fill::FILL_SOLID,
								'color' => array('rgb' => 'F00')
							)
						 ) 
				);
			}
			else
			{
				$objPHPExcel->getActiveSheet()->getStyle("L".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle("L".$row)->applyFromArray(
						 array(
							'fill' => array(
								'type' => PHPExcel_Style_Fill::FILL_SOLID,
								'color' => array('rgb' => '138001')
							)
						 ) 
				);

				
				}
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(11, $row, $data['total_store_april']);
			
			
			
			if($data['total_store_mei']<10)
			{
				$objPHPExcel->getActiveSheet()->getStyle("M".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle("M".$row)->applyFromArray(
						 array(
							'fill' => array(
								'type' => PHPExcel_Style_Fill::FILL_SOLID,
								'color' => array('rgb' => 'F00')
							)
						 ) 
				);
			}
			else
			{
				$objPHPExcel->getActiveSheet()->getStyle("M".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle("M".$row)->applyFromArray(
						 array(
							'fill' => array(
								'type' => PHPExcel_Style_Fill::FILL_SOLID,
								'color' => array('rgb' => '138001')
							)
						 ) 
				);

				
				}
				
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(12, $row, $data['total_store_mei']);
			
			
			
			if($data['total_store_juni']<10)
			{
				$objPHPExcel->getActiveSheet()->getStyle("N".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle("N".$row)->applyFromArray(
						 array(
							'fill' => array(
								'type' => PHPExcel_Style_Fill::FILL_SOLID,
								'color' => array('rgb' => 'F00')
							)
						 ) 
				);
			}
			else
			{
				$objPHPExcel->getActiveSheet()->getStyle("N".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle("N".$row)->applyFromArray(
						 array(
							'fill' => array(
								'type' => PHPExcel_Style_Fill::FILL_SOLID,
								'color' => array('rgb' => '138001')
							)
						 ) 
				);

				
				}
				
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(13, $row, $data['total_store_juni']);
			
			
			
			
			if($data['total_store_juli']<10)
			{
				$objPHPExcel->getActiveSheet()->getStyle("O".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle("O".$row)->applyFromArray(
						 array(
							'fill' => array(
								'type' => PHPExcel_Style_Fill::FILL_SOLID,
								'color' => array('rgb' => 'F00')
							)
						 ) 
				);
			}
			else
			{
				$objPHPExcel->getActiveSheet()->getStyle("O".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle("O".$row)->applyFromArray(
						 array(
							'fill' => array(
								'type' => PHPExcel_Style_Fill::FILL_SOLID,
								'color' => array('rgb' => '138001')
							)
						 ) 
				);

				
				}
				
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(14, $row, $data['total_store_juli']);
			
			
			
			if($data['total_store_agustus']<10)
			{
				$objPHPExcel->getActiveSheet()->getStyle("P".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle("P".$row)->applyFromArray(
						 array(
							'fill' => array(
								'type' => PHPExcel_Style_Fill::FILL_SOLID,
								'color' => array('rgb' => 'F00')
							)
						 ) 
				);
			}
			else
			{
				$objPHPExcel->getActiveSheet()->getStyle("P".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle("P".$row)->applyFromArray(
						 array(
							'fill' => array(
								'type' => PHPExcel_Style_Fill::FILL_SOLID,
								'color' => array('rgb' => '138001')
							)
						 ) 
				);

				
				}
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(15, $row, $data['total_store_agustus']);
			
			
			if($data['total_store_september']<10)
			{
				$objPHPExcel->getActiveSheet()->getStyle("Q".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle("Q".$row)->applyFromArray(
						 array(
							'fill' => array(
								'type' => PHPExcel_Style_Fill::FILL_SOLID,
								'color' => array('rgb' => 'F00')
							)
						 ) 
				);
			}
			else
			{
				$objPHPExcel->getActiveSheet()->getStyle("Q".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle("Q".$row)->applyFromArray(
						 array(
							'fill' => array(
								'type' => PHPExcel_Style_Fill::FILL_SOLID,
								'color' => array('rgb' => '138001')
							)
						 ) 
				);

				
				}
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(16, $row, $data['total_store_september']);
			
			if($data['total_store_oktober']<10)
			{
				$objPHPExcel->getActiveSheet()->getStyle("R".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle("R".$row)->applyFromArray(
						 array(
							'fill' => array(
								'type' => PHPExcel_Style_Fill::FILL_SOLID,
								'color' => array('rgb' => 'F00')
							)
						 ) 
				);
			}
			else
			{
				$objPHPExcel->getActiveSheet()->getStyle("R".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle("R".$row)->applyFromArray(
						 array(
							'fill' => array(
								'type' => PHPExcel_Style_Fill::FILL_SOLID,
								'color' => array('rgb' => '138001')
							)
						 ) 
				);

				
				}
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(17, $row, $data['total_store_oktober']);
			
			if($data['total_store_november']<10)
			{
				$objPHPExcel->getActiveSheet()->getStyle("S".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle("S".$row)->applyFromArray(
						 array(
							'fill' => array(
								'type' => PHPExcel_Style_Fill::FILL_SOLID,
								'color' => array('rgb' => 'F00')
							)
						 ) 
				);
			}
			else
			{
				$objPHPExcel->getActiveSheet()->getStyle("S".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle("S".$row)->applyFromArray(
						 array(
							'fill' => array(
								'type' => PHPExcel_Style_Fill::FILL_SOLID,
								'color' => array('rgb' => '138001')
							)
						 ) 
				);

				
				}
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(18, $row, $data['total_store_november']);
			
			if($data['total_store_desember']<10)
			{
				$objPHPExcel->getActiveSheet()->getStyle("T".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle("T".$row)->applyFromArray(
						 array(
							'fill' => array(
								'type' => PHPExcel_Style_Fill::FILL_SOLID,
								'color' => array('rgb' => 'F00')
							)
						 ) 
				);
			}
			else
			{
				$objPHPExcel->getActiveSheet()->getStyle("T".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle("T".$row)->applyFromArray(
						 array(
							'fill' => array(
								'type' => PHPExcel_Style_Fill::FILL_SOLID,
								'color' => array('rgb' => '138001')
							)
						 ) 
				);

				
				}
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(19, $row, $data['total_store_desember']);
            $row++;
			$no++;
        }
		
	   $last_row = $row-1;
	   //Set Border
       $objPHPExcel->getActiveSheet()->getStyle("B4".":"."T".$last_row)->applyFromArray($BStyle);
	   $objPHPExcel->getActiveSheet()->getStyle("B4".":"."T".$last_row)->applyFromArray($styleAlign);
       $objPHPExcel->setActiveSheetIndex(0);
 
        $objWriter = IOFactory::createWriter($objPHPExcel, 'Excel5');
 		
		
	   // Sending headers to force the user to download the file
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Master-switching-outlet-'.$date.'.xls"');
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
		
		
	public function exportSwicthingMotoristStore()
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
		$tahun = isset($_GET['tahun']) ? $_GET['tahun'] : '';
		$search = isset($_GET['search']) ? $_GET['search'] : '';
		$regional = isset($_GET['regional']) ? $_GET['regional'] : '';
		$motorist_type = isset($_GET['motorist_type']) ? $_GET['motorist_type'] : '';
		
		
		date_default_timezone_set('Asia/Jakarta');
		
		$year = date('Y');
		if($tahun!="")
		{$year=$tahun;}
		
		date_default_timezone_set('Asia/Jakarta');
		
		$year = date('Y');
		if($tahun!="")
		{$year=$tahun;}
		
		if($regional!="")
		{
			$this->db->where('regional in ('.$regional.') ');
		}
		
		if($motorist_type!="")
		{
			$this->db->where('motorist.motorist_type in ('.$motorist_type.') ');
		}
		
		$tanggal_bulan_awal = $year."-01-01 00:00:00";
		$tanggal_bulan_akhir = $year."-01-31 23:59:59";
		
		$this->db->select(" * ,
		(SELECT COUNT(customer_code) FROM store as s WHERE motorist.motorist_code = s.motorist_code AND motorist.distributor_code = s.distributor_code AND s.customer_create_date between '".$year.'-01-01 00:00:00'."' AND '".$year.'-01-31 23:59:59'."' ) as total_store_januari,
		(SELECT COUNT(customer_code) FROM store as s WHERE motorist.motorist_code = s.motorist_code AND motorist.distributor_code = s.distributor_code AND s.customer_create_date between '".$year.'-02-01 00:00:00'."' AND '".$year.'-02-29 23:59:59'."' ) as total_store_februari,
		(SELECT COUNT(customer_code) FROM store as s WHERE motorist.motorist_code = s.motorist_code AND motorist.distributor_code = s.distributor_code AND s.customer_create_date between '".$year.'-03-01 00:00:00'."' AND '".$year.'-03-31 23:59:59'."' ) as total_store_maret,
		(SELECT COUNT(customer_code) FROM store as s WHERE motorist.motorist_code = s.motorist_code AND motorist.distributor_code = s.distributor_code AND s.customer_create_date between '".$year.'-04-01 00:00:00'."' AND '".$year.'-04-31 23:59:59'."' ) as total_store_april,
		(SELECT COUNT(customer_code) FROM store as s WHERE motorist.motorist_code = s.motorist_code AND motorist.distributor_code = s.distributor_code AND s.customer_create_date between '".$year.'-05-01 00:00:00'."' AND '".$year.'-05-31 23:59:59'."' ) as total_store_mei,
		(SELECT COUNT(customer_code) FROM store as s WHERE motorist.motorist_code = s.motorist_code AND motorist.distributor_code = s.distributor_code AND s.customer_create_date between '".$year.'-06-01 00:00:00'."' AND '".$year.'-06-31 23:59:59'."' ) as total_store_juni,
		(SELECT COUNT(customer_code) FROM store as s WHERE motorist.motorist_code = s.motorist_code AND motorist.distributor_code = s.distributor_code AND s.customer_create_date between '".$year.'-07-01 00:00:00'."' AND '".$year.'-07-31 23:59:59'."' ) as total_store_juli,
		(SELECT COUNT(customer_code) FROM store as s WHERE motorist.motorist_code = s.motorist_code AND motorist.distributor_code = s.distributor_code AND s.customer_create_date between '".$year.'-08-01 00:00:00'."' AND '".$year.'-08-31 23:59:59'."' ) as total_store_agustus,
		(SELECT COUNT(customer_code) FROM store as s WHERE motorist.motorist_code = s.motorist_code AND motorist.distributor_code = s.distributor_code AND s.customer_create_date between '".$year.'-09-01 00:00:00'."' AND '".$year.'-09-31 23:59:59'."' ) as total_store_september,
		(SELECT COUNT(customer_code) FROM store as s WHERE motorist.motorist_code = s.motorist_code AND motorist.distributor_code = s.distributor_code AND s.customer_create_date between '".$year.'-10-01 00:00:00'."' AND '".$year.'-10-31 23:59:59'."' ) as total_store_oktober,
		(SELECT COUNT(customer_code) FROM store as s WHERE motorist.motorist_code = s.motorist_code AND motorist.distributor_code = s.distributor_code AND s.customer_create_date between '".$year.'-11-01 00:00:00'."' AND '".$year.'-11-31 23:59:59'."' ) as total_store_november,
		(SELECT COUNT(customer_code) FROM store as s WHERE motorist.motorist_code = s.motorist_code AND motorist.distributor_code = s.distributor_code AND s.customer_create_date between '".$year.'-12-01 00:00:00'."' AND '".$year.'-12-31 23:59:59'."' ) as total_store_desember");
		
		$this->db->where("motorist.motorist_type in (".$ket.") ");
		if($user_role=="Ado")
		{
			$this->db->where("motorist.distributor_code = '".$code_role."' ");
		}
		else if($user_role=="Regional")
		{
			$this->db->where("distributor.regional = '".$code_role."' ");		
		}
		
		$this->db->like('motorist_code', $search);
		$this->db->join('distributor', 'distributor.distributor_code = motorist.distributor_code');
		$this->db->join('motorist_type', 'motorist_type.id_motorist_type = motorist.motorist_type');
		$query = $this->db->get('motorist');
		
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
		
		$Fontstyle2 = array(
		'font'  => array(
			'bold'  => true,
			'color' => array('rgb' => 'ffffff')
		));
		
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
		
		
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 1, "Master Additional Outlet Motorist");
		//Merge And Center Title
		$objPHPExcel->getActiveSheet()->mergeCells('A1:D1');
		
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 2, "Date : ".$date);
		
		//Merge And Center Date
		$objPHPExcel->getActiveSheet()->mergeCells('A2:D2');
		
		//Set Font Color Title
		$objPHPExcel->getActiveSheet()->getStyle('A1:D2')->applyFromArray($FontstyleTitle);
		
		//Set Font Color Header
		$objPHPExcel->getActiveSheet()->getStyle('B4:U4')->applyFromArray($Fontstyle);
		
		//Set Backgroung Color Header
		$objPHPExcel->getActiveSheet()->getStyle('B4:U4')->applyFromArray(
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
		"Nama Motorist" => "Nama Motorist",
		"Kode Motorist" => "Kode Motorist",
		"Regional" => "Regional",
		"Area" => "Area",
		"Distributor" => "Distributor",
		"Target Outlet Switching" => "Target Outlet Switching",
		"Januari" => "Januari",
		"Februari" => "Februari",
		"Maret" => "Maret",
		"April" => "April",
		"Mei" => "Mei",
		"Juni" => "Juni",
		"Juli" => "Juli",
		"Agustus" => "Agustus",
		"September" => "September",
		"Oktober" => "Oktober",
		"November" => "November",
		"Desember" => "Desember"
		
		
		
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
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $row, $data['motorist_name']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $row, $data['motorist_code']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $row, $data['regional']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, $row, $data['area']);
		    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, $row, $data['distributor_code']);
			
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, $row, '10');
			
			if($data['total_store_januari']<10)
			{
				$objPHPExcel->getActiveSheet()->getStyle("I".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle("I".$row)->applyFromArray(
						 array(
							'fill' => array(
								'type' => PHPExcel_Style_Fill::FILL_SOLID,
								'color' => array('rgb' => 'F00')
							)
						 ) 
				);
			}
			else
			{
				$objPHPExcel->getActiveSheet()->getStyle("I".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle("I".$row)->applyFromArray(
						 array(
							'fill' => array(
								'type' => PHPExcel_Style_Fill::FILL_SOLID,
								'color' => array('rgb' => '138001')
							)
						 ) 
				);

				
				}
					 
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8, $row, $data['total_store_januari']);
			if($data['total_store_februari']<10)
			{
				$objPHPExcel->getActiveSheet()->getStyle("J".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle("J".$row)->applyFromArray(
						 array(
							'fill' => array(
								'type' => PHPExcel_Style_Fill::FILL_SOLID,
								'color' => array('rgb' => 'F00')
							)
						 ) 
				);
			}
			else
			{
				$objPHPExcel->getActiveSheet()->getStyle("J".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle("J".$row)->applyFromArray(
						 array(
							'fill' => array(
								'type' => PHPExcel_Style_Fill::FILL_SOLID,
								'color' => array('rgb' => '138001')
							)
						 ) 
				);

				
				}
				
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9, $row, $data['total_store_februari']);
			
			
			
			
			if($data['total_store_maret']<10)
			{
				$objPHPExcel->getActiveSheet()->getStyle("K".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle("K".$row)->applyFromArray(
						 array(
							'fill' => array(
								'type' => PHPExcel_Style_Fill::FILL_SOLID,
								'color' => array('rgb' => 'F00')
							)
						 ) 
				);
			}
			else
			{
				$objPHPExcel->getActiveSheet()->getStyle("K".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle("K".$row)->applyFromArray(
						 array(
							'fill' => array(
								'type' => PHPExcel_Style_Fill::FILL_SOLID,
								'color' => array('rgb' => '138001')
							)
						 ) 
				);

				
				}
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(10, $row, $data['total_store_maret']);
			
			
			
			
			if($data['total_store_april']<10)
			{
				$objPHPExcel->getActiveSheet()->getStyle("L".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle("L".$row)->applyFromArray(
						 array(
							'fill' => array(
								'type' => PHPExcel_Style_Fill::FILL_SOLID,
								'color' => array('rgb' => 'F00')
							)
						 ) 
				);
			}
			else
			{
				$objPHPExcel->getActiveSheet()->getStyle("L".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle("L".$row)->applyFromArray(
						 array(
							'fill' => array(
								'type' => PHPExcel_Style_Fill::FILL_SOLID,
								'color' => array('rgb' => '138001')
							)
						 ) 
				);

				
				}
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(11, $row, $data['total_store_april']);
			
			
			
			if($data['total_store_mei']<10)
			{
				$objPHPExcel->getActiveSheet()->getStyle("M".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle("M".$row)->applyFromArray(
						 array(
							'fill' => array(
								'type' => PHPExcel_Style_Fill::FILL_SOLID,
								'color' => array('rgb' => 'F00')
							)
						 ) 
				);
			}
			else
			{
				$objPHPExcel->getActiveSheet()->getStyle("M".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle("M".$row)->applyFromArray(
						 array(
							'fill' => array(
								'type' => PHPExcel_Style_Fill::FILL_SOLID,
								'color' => array('rgb' => '138001')
							)
						 ) 
				);

				
				}
				
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(12, $row, $data['total_store_mei']);
			
			
			
			if($data['total_store_juni']<10)
			{
				$objPHPExcel->getActiveSheet()->getStyle("N".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle("N".$row)->applyFromArray(
						 array(
							'fill' => array(
								'type' => PHPExcel_Style_Fill::FILL_SOLID,
								'color' => array('rgb' => 'F00')
							)
						 ) 
				);
			}
			else
			{
				$objPHPExcel->getActiveSheet()->getStyle("N".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle("N".$row)->applyFromArray(
						 array(
							'fill' => array(
								'type' => PHPExcel_Style_Fill::FILL_SOLID,
								'color' => array('rgb' => '138001')
							)
						 ) 
				);

				
				}
				
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(13, $row, $data['total_store_juni']);
			
			
			
			
			if($data['total_store_juli']<10)
			{
				$objPHPExcel->getActiveSheet()->getStyle("O".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle("O".$row)->applyFromArray(
						 array(
							'fill' => array(
								'type' => PHPExcel_Style_Fill::FILL_SOLID,
								'color' => array('rgb' => 'F00')
							)
						 ) 
				);
			}
			else
			{
				$objPHPExcel->getActiveSheet()->getStyle("O".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle("O".$row)->applyFromArray(
						 array(
							'fill' => array(
								'type' => PHPExcel_Style_Fill::FILL_SOLID,
								'color' => array('rgb' => '138001')
							)
						 ) 
				);

				
				}
				
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(14, $row, $data['total_store_juli']);
			
			
			
			if($data['total_store_agustus']<10)
			{
				$objPHPExcel->getActiveSheet()->getStyle("P".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle("P".$row)->applyFromArray(
						 array(
							'fill' => array(
								'type' => PHPExcel_Style_Fill::FILL_SOLID,
								'color' => array('rgb' => 'F00')
							)
						 ) 
				);
			}
			else
			{
				$objPHPExcel->getActiveSheet()->getStyle("P".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle("P".$row)->applyFromArray(
						 array(
							'fill' => array(
								'type' => PHPExcel_Style_Fill::FILL_SOLID,
								'color' => array('rgb' => '138001')
							)
						 ) 
				);

				
				}
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(15, $row, $data['total_store_agustus']);
			
			
			if($data['total_store_september']<10)
			{
				$objPHPExcel->getActiveSheet()->getStyle("Q".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle("Q".$row)->applyFromArray(
						 array(
							'fill' => array(
								'type' => PHPExcel_Style_Fill::FILL_SOLID,
								'color' => array('rgb' => 'F00')
							)
						 ) 
				);
			}
			else
			{
				$objPHPExcel->getActiveSheet()->getStyle("Q".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle("Q".$row)->applyFromArray(
						 array(
							'fill' => array(
								'type' => PHPExcel_Style_Fill::FILL_SOLID,
								'color' => array('rgb' => '138001')
							)
						 ) 
				);

				
				}
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(16, $row, $data['total_store_september']);
			
			if($data['total_store_oktober']<10)
			{
				$objPHPExcel->getActiveSheet()->getStyle("R".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle("R".$row)->applyFromArray(
						 array(
							'fill' => array(
								'type' => PHPExcel_Style_Fill::FILL_SOLID,
								'color' => array('rgb' => 'F00')
							)
						 ) 
				);
			}
			else
			{
				$objPHPExcel->getActiveSheet()->getStyle("R".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle("R".$row)->applyFromArray(
						 array(
							'fill' => array(
								'type' => PHPExcel_Style_Fill::FILL_SOLID,
								'color' => array('rgb' => '138001')
							)
						 ) 
				);

				
				}
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(17, $row, $data['total_store_oktober']);
			
			if($data['total_store_november']<10)
			{
				$objPHPExcel->getActiveSheet()->getStyle("S".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle("S".$row)->applyFromArray(
						 array(
							'fill' => array(
								'type' => PHPExcel_Style_Fill::FILL_SOLID,
								'color' => array('rgb' => 'F00')
							)
						 ) 
				);
			}
			else
			{
				$objPHPExcel->getActiveSheet()->getStyle("S".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle("S".$row)->applyFromArray(
						 array(
							'fill' => array(
								'type' => PHPExcel_Style_Fill::FILL_SOLID,
								'color' => array('rgb' => '138001')
							)
						 ) 
				);

				
				}
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(18, $row, $data['total_store_november']);
			
			if($data['total_store_desember']<10)
			{
				$objPHPExcel->getActiveSheet()->getStyle("T".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle("T".$row)->applyFromArray(
						 array(
							'fill' => array(
								'type' => PHPExcel_Style_Fill::FILL_SOLID,
								'color' => array('rgb' => 'F00')
							)
						 ) 
				);
			}
			else
			{
				$objPHPExcel->getActiveSheet()->getStyle("T".$row)->applyFromArray($Fontstyle2);
				$objPHPExcel->getActiveSheet()->getStyle("T".$row)->applyFromArray(
						 array(
							'fill' => array(
								'type' => PHPExcel_Style_Fill::FILL_SOLID,
								'color' => array('rgb' => '138001')
							)
						 ) 
				);

				
				}
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(19, $row, $data['total_store_desember']);
            $row++;
			$no++;
        }
		
	   $last_row = $row-1;
	   //Set Border
       $objPHPExcel->getActiveSheet()->getStyle("B4".":"."T".$last_row)->applyFromArray($BStyle);
	   $objPHPExcel->getActiveSheet()->getStyle("B4".":"."T".$last_row)->applyFromArray($styleAlign);
       $objPHPExcel->setActiveSheetIndex(0);
 
        $objWriter = IOFactory::createWriter($objPHPExcel, 'Excel5');
 		
		
	   // Sending headers to force the user to download the file
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Master-additional-outlet-'.$date.'.xls"');
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
	
	
	
	
	
	public function exportDailySalesMotoristAdo2()
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
		$date = isset($_GET['date']) ? $_GET['date'] : '';
		$search = isset($_GET['search']) ? $_GET['search'] : '';
				
		date_default_timezone_set('Asia/Jakarta');
		$day = date('l');
		
		$date_now = date('Y-m-d');
		
		if($date!="")
		{
			$tanggal_pecah = explode("/", $date);
			$date_now = $tanggal_pecah[2].'-'.$tanggal_pecah[0].'-'.$tanggal_pecah[1];
		    $date_convert = date_create($date_now);
			$day = date_format($date_convert,"l");

		}
		$this->db->select(" * ,(SELECT setoran FROM absence as a WHERE a.motorist_code = motorist.motorist_code AND a.distributor_code = motorist.distributor_code AND date_absence LIKE '%".$date_now."%' limit 1) as total_daily_setoran,
		(SELECT SUM(total_order) FROM orders as o WHERE o.id_motorist = motorist.id_motorist AND date LIKE '%".$date_now."%') as total_daily_sales
		");
		
		$this->db->where("motorist.motorist_type in (".$ket.") ");
		if($user_role=="Ado")
		{
			$this->db->where("motorist.distributor_code = '".$code_role."' ");
		}
		else if($user_role=="Regional")
		{
			$this->db->where("distributor.regional = '".$code_role."' ");		
		}
		
		
		$this->db->like('motorist_code', $search);
		$this->db->join('distributor', 'distributor.distributor_code = motorist.distributor_code');
		$this->db->join('motorist_type', 'motorist_type.id_motorist_type = motorist.motorist_type');
		$query = $this->db->get('motorist');
			
	
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
		
		
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 1, "Summary penjualan per salesman");
		//Merge And Center Title
		$objPHPExcel->getActiveSheet()->mergeCells('A1:D1');
		
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 2, "Date : ".$date_now);
		
		//Merge And Center Date
		$objPHPExcel->getActiveSheet()->mergeCells('A2:D2');
		
		//Set Font Color Title
		$objPHPExcel->getActiveSheet()->getStyle('A1:D2')->applyFromArray($FontstyleTitle);
		
		//Set Font Color Header
		$objPHPExcel->getActiveSheet()->getStyle('B4:J4')->applyFromArray($Fontstyle);
		
		//Set Backgroung Color Header
		$objPHPExcel->getActiveSheet()->getStyle('B4:J4')->applyFromArray(
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
		"Motorist Code" => "Motorist Code",
		"Motorist Name" => "Motorist Name",
		"Target Penjualan" => "Target Penjualan",
		"Stock Harian" => "Stock Harian",
		"Setoran" => "Setoran",
		"Actual Penjualan" => "Actual Penjualan",
		"% Pencapaian Pejualan" => "% Pencapaian Pejualan",
		"Selisih Setoran" => "Selisih Setoran"
		
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
		$total_target_penjualan_keseluruhan = 0;
		$total_stock_harian_keseluruhan = 0;
		$total_setoran_keseluruhan = 0;
		$total_actual_penjualan_keseluruhan = 0;
		$total_selisih_setoran_keseluruhan = 0;
		
        foreach($query->result_array() as $data)
        {
			$persentasi_target_harian = 0;	
			if($data['total_daily_sales']>0)
			{
			$persentasi_target_harian = ($data['total_daily_sales'] * 100) / $data['target_harian'];
			$persentasi_target_harian = number_format($persentasi_target_harian, 0, '.', '');
			}
			
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $row, $no);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $row, $data['motorist_name']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $row, $data['motorist_code']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $row, $data['target_harian']);
			$total_price_day = $this->db->query("SELECT * FROM stock INNER JOIN product on product.id_product =  stock.id_product  WHERE stock.id_motorist = '".$data['id_motorist']."' AND stock.date LIKE '%".$date_now."%'")->result();
			$total_rupiah_all = 0;
			foreach($total_price_day as $total_price_day) {
			$total_rupiah = $total_price_day->stock * $total_price_day->price_pcs; 
			$total_rupiah_all = $total_rupiah + $total_rupiah_all;
			}
			
		    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, $row, $total_rupiah_all);
			$selisih_setoran = $data['total_daily_setoran'] - $data['total_daily_sales'];
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, $row, $data['total_daily_setoran']);
			
			$total_daily_sales=0;
			if($data['total_daily_sales']>0)
			{$total_daily_sales=$data['total_daily_sales'];}
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, $row, $total_daily_sales);
			
			
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8, $row, $persentasi_target_harian," %");
			
			if($selisih_setoran<0)
			{
			$objPHPExcel->getActiveSheet()->getStyle('J'.$row)->applyFromArray($Fontstyle);
			$objPHPExcel->getActiveSheet()->getStyle('J'.$row)->applyFromArray(
				array(
					'fill' => array(
						'type' => PHPExcel_Style_Fill::FILL_SOLID,
						'color' => array('rgb' => 'f31338')
					)
				)
			);
			}
			else if($selisih_setoran>0) 
			{
				$objPHPExcel->getActiveSheet()->getStyle('J'.$row)->applyFromArray($Fontstyle);
				$objPHPExcel->getActiveSheet()->getStyle('J'.$row)->applyFromArray(
				array(
					'fill' => array(
						'type' => PHPExcel_Style_Fill::FILL_SOLID,
						'color' => array('rgb' => 'ed7e07')
					)
				)
			);
				}
			
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9, $row, $selisih_setoran);
            $row++;
			$no++;
			$total_target_penjualan_keseluruhan = $total_target_penjualan_keseluruhan + $data['target_harian'];
			$total_stock_harian_keseluruhan = $total_stock_harian_keseluruhan + $total_rupiah_all;
			$total_setoran_keseluruhan = $total_setoran_keseluruhan + $data['total_daily_setoran'];
			$total_actual_penjualan_keseluruhan = $total_actual_penjualan_keseluruhan + $data['total_daily_sales'];
			$total_selisih_setoran_keseluruhan = $total_selisih_setoran_keseluruhan + $selisih_setoran;
        }
		
		$persentasi_total_pencapaian = 0;
		if($total_target_penjualan_keseluruhan>0)
		{   
			$persentasi_total_pencapaian = ($total_actual_penjualan_keseluruhan * 100) / $total_target_penjualan_keseluruhan;
			$persentasi_total_pencapaian = number_format($persentasi_total_pencapaian, 0, '.', '');
		}
		
	   $row_total = $row;
	   
	   //Set Backgroung Color Header
		$objPHPExcel->getActiveSheet()->getStyle('B'.$row_total.':J'.$row_total)->applyFromArray(
			array(
				'fill' => array(
					'type' => PHPExcel_Style_Fill::FILL_SOLID,
					'color' => array('rgb' => '#62a8ea')
				)
			)
		);
			$total_number = $no-1;
	  	    $objPHPExcel->getActiveSheet()->getStyle('B'.$row_total.':L'.$row_total)->applyFromArray($Fontstyle);
	   	    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $row_total, "Total");
			$objPHPExcel->getActiveSheet()->mergeCells('B'.$row_total.':C'.$row_total);
			
		    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $row_total, $total_number);
			
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $row_total, $total_target_penjualan_keseluruhan);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, $row_total, $total_stock_harian_keseluruhan);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, $row_total, $total_setoran_keseluruhan);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, $row_total, $total_actual_penjualan_keseluruhan);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8, $row_total, $persentasi_total_pencapaian." %");
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9, $row_total, $total_selisih_setoran_keseluruhan);
			
	   
	   $last_row = $row_total;
	   //Set Border
       $objPHPExcel->getActiveSheet()->getStyle("B4".":"."J".$last_row)->applyFromArray($BStyle);
	   $objPHPExcel->getActiveSheet()->getStyle("B4".":"."J".$last_row)->applyFromArray($styleAlign);
       $objPHPExcel->setActiveSheetIndex(0);
 
        $objWriter = IOFactory::createWriter($objPHPExcel, 'Excel5');
 		
		
	   // Sending headers to force the user to download the file
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Master-Motorist-'.$date.'.xls"');
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
	
	public function exportDailySummaryMotoristAdo()
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
			
		$date = isset($_GET['date']) ? $_GET['date'] : '';
		$search = isset($_GET['search']) ? $_GET['search'] : '';
		
		date_default_timezone_set('Asia/Jakarta');
		$day = date('l');
		
		$date_now = date('Y-m-d');
		
		if($date!="")
		{
			$tanggal_pecah = explode("/", $date);
			$date_now = $tanggal_pecah[2].'-'.$tanggal_pecah[0].'-'.$tanggal_pecah[1];
		    $date_convert = date_create($date_now);
			$day = date_format($date_convert,"l");

		}
		$this->db->select(" * ,(SELECT COUNT(customer_code) FROM store as s WHERE s.motorist_code = motorist.motorist_code AND s.distributor_code = distributor.distributor_code AND s.day_visit = '".$day."') as target_call,
		(SELECT COUNT(customer_code) FROM visit as v WHERE v.id_motorist = motorist.id_motorist AND status_visit = 'call' AND time_stamp_visit LIKE '%".$date_now."%') as total_call,
		(SELECT COUNT(id_noo) FROM noo as n WHERE n.motorist_code = motorist.motorist_code AND n.distributor_code = motorist.distributor_code AND customer_create_date LIKE '%".$date_now."%') as total_new_customer,
		(SELECT COUNT(customer_code) FROM visit as v WHERE v.id_motorist = motorist.id_motorist AND status_visit = 'call' AND status_order = 'order' AND time_stamp_visit LIKE '%".$date_now."%') as total_effective_call
		");
		
		$this->db->where("motorist.motorist_type in (".$ket.") ");
		if($user_role=="Ado")
		{
			$this->db->where("motorist.distributor_code = '".$code_role."' ");
		}
		else if($user_role=="Regional")
		{
			$this->db->where("distributor.regional = '".$code_role."' ");		
		}
		
		
		$this->db->like('motorist_code', $search);
		$this->db->join('distributor', 'distributor.distributor_code = motorist.distributor_code');
		$this->db->join('motorist_type', 'motorist_type.id_motorist_type = motorist.motorist_type');
		$query = $this->db->get('motorist');
		
		
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
		
		
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 1, "Summary productivity per salesman");
		//Merge And Center Title
		$objPHPExcel->getActiveSheet()->mergeCells('A1:D1');
		
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 2, "Date : ".$date_now);
		
		//Merge And Center Date
		$objPHPExcel->getActiveSheet()->mergeCells('A2:D2');
		
		//Set Font Color Title
		$objPHPExcel->getActiveSheet()->getStyle('A1:D2')->applyFromArray($FontstyleTitle);
		
		//Set Font Color Header
		$objPHPExcel->getActiveSheet()->getStyle('B4:J4')->applyFromArray($Fontstyle);
		
		//Set Backgroung Color Header
		$objPHPExcel->getActiveSheet()->getStyle('B4:J4')->applyFromArray(
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
		"Nama Motorist" => "Nama Motorist",
		"Kode Motorist" => "Kode Motorist",
		"Target Call" => "Target Call",
		"Call" => "Call",
		"%Call" => "%Call",
		"Efektif Call" => "Efektif Call",
		"New Customer" => "New Customer",
		"%Efektif Call" => "%Efektif Call"
		
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
		$total_call_keseluruhan = 0;
		$total_new_customer_keseluruhan = 0;
		$total_effective_call_keseluruhan = 0;
		$total_target_call_keseluruhan = 0;
        foreach($query->result_array() as $data)
        {
					
						
						$persentasi_call = 0;
						$persentasi_extra_call = 0;
						$persentasi_effective_call = 0;
						$persentasi_extra_effective_call = 0;
						$persentasi_target_harian = 0;
						if($data['target_call']>0)
						{
							if($data['target_call']>0)
							{
							$persentasi_call = ($data['total_call'] * 100) / $data['target_call'];
							$persentasi_call = number_format($persentasi_call, 0, '.', '');	
							}
							if($data['target_call']>0)
							{
							$persentasi_effective_call = ($data['total_effective_call'] * 100) / $data['target_call'];
							$persentasi_effective_call = number_format($persentasi_effective_call, 0, '.', '');
							}
						}
						
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $row, $no);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $row, $data['motorist_name']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $row, $data['motorist_code']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $row, $data['target_call']);
		    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, $row, $data['total_call']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, $row, $persentasi_call);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, $row, $data['total_effective_call']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8, $row, $data['total_new_customer']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9, $row, $persentasi_effective_call);
			
            $row++;
			$no++;
			$total_call_keseluruhan = $total_call_keseluruhan+$data['total_call'];
			$total_target_call_keseluruhan = $total_target_call_keseluruhan+$data['target_call'];
			$total_effective_call_keseluruhan = $total_effective_call_keseluruhan+$data['total_effective_call'];
			$total_new_customer_keseluruhan = $total_new_customer_keseluruhan+$data['total_new_customer'];
        }
					$total_persen_call = 0;
					if($total_target_call_keseluruhan>0)
					{
					$total_persen_call  = ($total_call_keseluruhan * 100) / $total_target_call_keseluruhan;
					$total_persen_call  = number_format($total_persen_call, 0, '.', '');
					}
					$total_persen_effective_call=0;
					if($total_call_keseluruhan>0)
					{
					$total_persen_effective_call  = ($total_effective_call_keseluruhan * 100) / $total_call_keseluruhan;
					$total_persen_effective_call  = number_format($total_persen_effective_call, 0, '.', '');
					}
	    $row_total = $row;
	   
	   //Set Backgroung Color Header
		$objPHPExcel->getActiveSheet()->getStyle('B'.$row_total.':J'.$row_total)->applyFromArray(
			array(
				'fill' => array(
					'type' => PHPExcel_Style_Fill::FILL_SOLID,
					'color' => array('rgb' => '#62a8ea')
				)
			)
		);
			$total_number = $no-1;
	  	    $objPHPExcel->getActiveSheet()->getStyle('B'.$row_total.':L'.$row_total)->applyFromArray($Fontstyle);
	   	    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $row_total, "Total");
			$objPHPExcel->getActiveSheet()->mergeCells('B'.$row_total.':C'.$row_total);
			
		    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $row_total, $total_number);
			
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $row_total, $total_target_call_keseluruhan);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, $row_total, $total_call_keseluruhan);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, $row_total, $total_persen_call." %");
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, $row_total, $total_effective_call_keseluruhan);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8, $row_total, $total_new_customer_keseluruhan);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9, $row_total, $total_persen_effective_call." %");
			
	   
	   $last_row = $row_total;
	   //Set Border
       $objPHPExcel->getActiveSheet()->getStyle("B4".":"."J".$last_row)->applyFromArray($BStyle);
	   $objPHPExcel->getActiveSheet()->getStyle("B4".":"."J".$last_row)->applyFromArray($styleAlign);
       $objPHPExcel->setActiveSheetIndex(0);
	   
	   
	   
 
        $objWriter = IOFactory::createWriter($objPHPExcel, 'Excel5');
 		
		
	   // Sending headers to force the user to download the file
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Summary-productivity-salesman-'.$date_now.'.xls"');
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
		
		
		
		
	public function exportDailyCallStrike()
	{
		
		date_default_timezone_set('Asia/Jakarta');
		if ($this->tank_auth->is_logged_in()) {
		$user	= $this->tank_auth->get_username();
			
		$data_account = $this->model_account_master->getAccount("WHERE username = '".$user."' ")->result_array();
		$data_role = $this->model_account_master->getRole("WHERE id_role = '".$data_account[0]['user_access']."' ")->result_array();
		$user_role = $data_account[0]['user_type'];
		$code_role = $data_account[0]['code'];
		if($data_role[0]['see_motorist']=='yes')
		{
			
		
		$id_motorist = isset($_GET['id_motorist']) ? $_GET['id_motorist'] : '';
		$date = isset($_GET['date']) ? $_GET['date'] : '';
	
	
		
		if($date!="")
		{
		$tanggal_pecah = explode("/", $date);
		$date_now = $tanggal_pecah[2].'-'.$tanggal_pecah[0].'-'.$tanggal_pecah[1];
		$this->db->where("time_stamp_visit LIKE '%".$date_now."%' ");
		}
		
		if($id_motorist!="")
		{
			
		$this->db->select(" *, (SELECT SUM(price_total) FROM product_orders where id_order = visit.id_order ) as total_harga_benar, visit.jam_checkin as jam_checkin_visit ,(SELECT COUNT(id_order) FROM product_orders as p WHERE p.id_order = orders.id_order ) as total_sku,store.latitude as store_latitude,store.longitude as store_longitude,visit.latitude as visit_latitude,visit.longitude as visit_longitude");
		
		if($user_role=="Ado")
		{
			$this->db->where("motorist.distributor_code = '".$code_role."' ");
		}
		
		$tanggal_pecah = explode("/", $date);
		$date_now = $tanggal_pecah[2].'-'.$tanggal_pecah[0].'-'.$tanggal_pecah[1];
		
		$this->db->where("visit.id_motorist = '".$id_motorist."' ");
		$this->db->where("time_stamp_visit LIKE '%".$date_now."%' ");
		$this->db->join('orders', 'orders.id_order = visit.id_order',"LEFT");
		$this->db->join('store', 'store.customer_code = visit.customer_code');
		$this->db->join('motorist', 'motorist.id_motorist = visit.id_motorist');
		$this->db->order_by("visit.id_visit","asc");
		$query = $this->db->get('visit');
		
		
		
		$data_motorist = $this->db->query("SELECT * FROM motorist WHERE id_motorist = '".$id_motorist."' ")->result_array();
		
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
		
		
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 1, "Daily Call Strike");
		//Merge And Center Title
		$objPHPExcel->getActiveSheet()->mergeCells('A1:D1');
		
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 2, "Motorist : ".$data_motorist[0]['motorist_name']." Date : ".$date);
		
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
		
		"No" => "No",
		"ID Order" => "ID Order",
		"Time In" => "Time In",
		"Time Out" => "Time Out",
		"Duration" => "Duration",
		"Outlet" => "Outlet",
		"Customer Code" => "Customer Code",
		"Channel Code" => "Channel Code",
		"Jualan" => "Jualan",
		"SKU Sold" => "SKU Sold",
		"Actual Sales Of The Days" => "Actual Sales Of The Days"
		
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
		$total_order_sku = 0;
		$time_total = 0;
		$total_jualan = 0;
		$total_order = 0;
        foreach($query->result_array() as $data)
        {
			$time_in = explode(" ",$data['jam_checkin_visit']);
						$time_in = $time_in[1];
						
						$time_checkout = explode(" ",$data['time_stamp_visit']);
						$time_checkout = $time_checkout[1];
						$time_diff =  strtotime($time_checkout) - strtotime($time_in)  ;
						
						
						
						if($data['status_order']=="order")
						{  $total_order  =   $total_order  + 1;}
						
						
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $row, $no);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $row, $data['id_order']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $row, $time_in);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $row, $time_checkout);
		    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, $row, gmdate("H:i:s", $time_diff));
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, $row, $data['customer_name']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, $row, $data['customer_code']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8, $row, $data['channel_code']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9, $row, $data['status_order']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(10, $row, $data['total_sku']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(11, $row, $data['total_harga_benar']);
			
			$time_total = $time_total+$time_diff;
			$total_jualan = $total_jualan + $data['total_harga_benar'];
			$total_order_sku = $total_order_sku + $data['total_sku'];
					
            $row++;
			$no++;
        }
		$row_total = $row;
		//Set Backgroung Color Header
		$objPHPExcel->getActiveSheet()->getStyle('B'.$row_total.':L'.$row_total)->applyFromArray(
			array(
				'fill' => array(
					'type' => PHPExcel_Style_Fill::FILL_SOLID,
					'color' => array('rgb' => '#62a8ea')
				)
			)
		);
			
	   		$total_number = $no-1;
	  	    $objPHPExcel->getActiveSheet()->getStyle('B'.$row_total.':L'.$row_total)->applyFromArray($Fontstyle);
	   	    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $row_total, "Total");
			$objPHPExcel->getActiveSheet()->mergeCells('B'.$row_total.':E'.$row_total);
			
		    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, $row_total, gmdate("H:i:s", $time_total));
			
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, $row_total, $total_number." Outlet");
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, $row_total,  $total_number." Customer");
			$data_channel = $this->db->query("SELECT * FROM visit inner JOIN store on store.customer_code = visit.customer_code WHERE visit.id_motorist = '".$id_motorist."' AND time_stamp_visit LIKE '%".$date_now."%' group by store.channel_code ")->num_rows();
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8, $row_total, $data_channel." Channel");
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9, $row_total, $total_order." Jualan");
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(10, $row_total, $total_order_sku." Sku");
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(11, $row_total, $total_jualan);
			
	   $last_row = $row_total;
	   //Set Border
       $objPHPExcel->getActiveSheet()->getStyle("B4".":"."L".$last_row)->applyFromArray($BStyle);
	   $objPHPExcel->getActiveSheet()->getStyle("B4".":"."L".$last_row)->applyFromArray($styleAlign);
       $objPHPExcel->setActiveSheetIndex(0);
 
        $objWriter = IOFactory::createWriter($objPHPExcel, 'Excel5');
 		
		
	   // Sending headers to force the user to download the file
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="DailyCallStrike-'.$data_motorist[0]['motorist_name'].'-'.$date.'.xls"');
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
			
		}}
		
		
		
	
	
	public function exportMonthlySummaryMotorist()
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
		
		$area = isset($_GET['area']) ? $_GET['area'] : '';
		$distributor = isset($_GET['distributor']) ? $_GET['distributor'] : '';
		$search = isset($_GET['search']) ? $_GET['search'] : '';
		$regional = isset($_GET['regional']) ? $_GET['regional'] : '';
		$motorist_type = isset($_GET['motorist_type']) ? $_GET['motorist_type'] : '';
		$tahun = isset($_GET['tahun']) ? $_GET['tahun'] : '';
		$bulan_2 = isset($_GET['bulan']) ? $_GET['bulan'] : '';
		
		$bulan = date('m');
		if($bulan_2!="")
		{$bulan=$bulan_2;}
		
		
		$date_now = date('d');
		$month_now = date('m');
		if($bulan!=$month_now)
		{$date_now = "31";}
		
		$year = date('Y');
		if($tahun!="")
		{$year=$tahun;}
		
		if($regional!="")
		{
			$this->db->where('regional in ('.$regional.') ');
		}
		
		if($motorist_type!="")
		{
			$this->db->where('motorist.motorist_type in ('.$motorist_type.') ');
		}
		
		if($distributor!="")
		{
			
			$this->db->where('motorist.distributor_code in ('.$distributor.') ');
		}
		if($area!="")
		{
			$this->db->where('distributor.area in ('.$area.') ');
		}
		
		$tanggal_bulan_awal = $year.'-'.$bulan."-01 00:00:00";
		$tanggal_bulan_akhir = $year.'-'.$bulan."-31 23:59:59";
		
		$this->db->select(" * ,
		(SELECT COUNT(customer_code) FROM store as s WHERE s.motorist_code = motorist.motorist_code AND s.distributor_code = motorist.distributor_code) as target_call,
		(SELECT COUNT(id_noo) FROM noo as n WHERE n.motorist_code = motorist.motorist_code AND n.distributor_code = motorist.distributor_code AND customer_create_date between '".$tanggal_bulan_awal."' AND '".$tanggal_bulan_akhir."') as total_noo,
		(SELECT COUNT(id_store) FROM store as s WHERE s.motorist_code = motorist.motorist_code AND s.distributor_code = motorist.distributor_code AND customer_create_date between '".$tanggal_bulan_awal."' AND '".$tanggal_bulan_akhir."') as total_store,
		(SELECT COUNT(customer_code) FROM visit as v WHERE v.id_motorist = motorist.id_motorist AND status_visit = 'call' AND time_stamp_visit between '".$tanggal_bulan_awal."' AND '".$tanggal_bulan_akhir."') as total_call,
		(SELECT COUNT(customer_code) FROM visit as v WHERE v.id_motorist = motorist.id_motorist AND status_visit = 'extra_call' AND time_stamp_visit between '".$tanggal_bulan_awal."' AND '".$tanggal_bulan_akhir."') as total_extra_call,
		(SELECT COUNT(customer_code) FROM visit as v WHERE v.id_motorist = motorist.id_motorist AND status_visit = 'call' AND status_order = 'order' AND time_stamp_visit between '".$tanggal_bulan_awal."' AND '".$tanggal_bulan_akhir."') as total_effective_call,
		(SELECT COUNT(customer_code) FROM visit as v WHERE v.id_motorist = motorist.id_motorist AND status_visit = 'call' AND status_order = 'extra_call' AND time_stamp_visit between '".$tanggal_bulan_awal."' AND '".$tanggal_bulan_akhir."') as total_extra_effective_call,
		(SELECT SUM(total_order) FROM orders as o WHERE o.id_motorist = motorist.id_motorist AND date between '".$tanggal_bulan_awal."' AND '".$tanggal_bulan_akhir."') as total_monthly_sales,
		(SELECT COUNT(customer_code) FROM store as s WHERE s.motorist_code = motorist.motorist_code AND s.distributor_code = motorist.distributor_code) as total_outlet,
		(SELECT COUNT(customer_code) FROM store as s WHERE s.motorist_code = motorist.motorist_code AND s.distributor_code = motorist.distributor_code  AND customer_status = 'active') as total_outlet_active");
		$this->db->where("motorist.motorist_type in (".$ket.") ");
		if($user_role=="Ado")
		{
			$this->db->where("motorist.distributor_code = '".$code_role."' ");
		}
		else if($user_role=="Regional")
		{
			$this->db->where("distributor.regional = '".$code_role."' ");		
		}
		
		$this->db->like('motorist_code', $search);
		$this->db->join('distributor', 'distributor.distributor_code = motorist.distributor_code');
		$this->db->join('motorist_type', 'motorist_type.id_motorist_type = motorist.motorist_type');
		$query = $this->db->get('motorist');
		
		
		
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
			
			$total_senin = number_of_working_days('2016-'.$bulan.'-01', '2016-'.$bulan.'-'.$date_now,1);
			//echo "total senin".$total_senin."<br>";
			$total_selasa = number_of_working_days('2016-'.$bulan.'-01', '2016-'.$bulan.'-'.$date_now,2);
			//echo "total selasa".$total_selasa."<br>";
			$total_rabu = number_of_working_days('2016-'.$bulan.'-01', '2016-'.$bulan.'-'.$date_now,3);
			//echo "total rabu".$total_rabu."<br>";
			$total_kamis = number_of_working_days('2016-'.$bulan.'-01', '2016-'.$bulan.'-'.$date_now,4);
			//echo "total kamis".$total_kamis."<br>";
			$total_jumat = number_of_working_days('2016-'.$bulan.'-01', '2016-'.$bulan.'-'.$date_now,5);
			//echo "total jumat".$total_jumat."<br>";
			$total_sabtu = number_of_working_days('2016-'.$bulan.'-01', '2016-'.$bulan.'-'.$date_now,6);
			//echo "total sabtu".$total_sabtu."<br>";

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
		
		
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 1, "Monthly Motorist");
		//Merge And Center Title
		$objPHPExcel->getActiveSheet()->mergeCells('A1:D1');
		
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 2, "Month : ".$bulan."Year : ".$tahun);
		
		//Merge And Center Date
		$objPHPExcel->getActiveSheet()->mergeCells('A2:D2');
		
		//Set Font Color Title
		$objPHPExcel->getActiveSheet()->getStyle('A1:D2')->applyFromArray($FontstyleTitle);
		
		//Set Font Color Header
		$objPHPExcel->getActiveSheet()->getStyle('B4:Z4')->applyFromArray($Fontstyle);
		
		//Set Backgroung Color Header
		$objPHPExcel->getActiveSheet()->getStyle('B4:Z4')->applyFromArray(
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
		"Distributor Name" => "Distributor Name",
		"Kode Motorist" => "Kode Motorist",
		"Nama Motorist" => "Nama Motorist",
		"Tipe Motorist" => "Tipe Motorist",
		"(A) Target Call" => "(A) Target Call",
		"(B) Call" => "(B) Call",
		"(B/A) %Call" => "(B/A) %Call",
		"(C) Ekstra Call" => "(C) Ekstra Call",
		"(C/B) %Ekstra Call" => "(C/B) %Ekstra Call",
		"(D) Efektif Call" => "(D) Efektif Call",
		"(D/A) %Efektiv Call" => "(D/A) %Efektiv Call",
		"(E) Target Penjualan Bulanan" => "(E) Target Penjualan Bulanan",
		"(F) Penjualanan Bulanan" => "(F) Penjualanan Bulanan",
		"(E/F) %Pencapaian Penjualan" => "(E/F) %Pencapaian Penjualan",
		"(G) Total Setoran Bulanan" => "(G) Total Setoran Bulanan",
		"(G-F) Selisih Setoran Bulanan" => "(G-F) Selisih Setoran Bulanan",
		"(H) Master Outltet" => "(H) Master Outltet",
		"(I) Outlet Aktif" => "(I) Outlet Aktif",
		"(I/H) % Outlet Aktif" => "(I/H) % Outlet Aktif",
		"Additional Store" => "Additional Store",
		"Additional Noo" => "Additional Noo"
		
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
			
			$persentasi_call = 0;
			$total_keseluruhan = 0;
			$persentasi_extra_call = 0;
			$persentasi_effective_call = 0;
			$persentasi_extra_effective_call = 0;
			$persentasi_target_bulanan = 0;
			$persentasi_outlet_active=0;
			if($data['total_call']>0)
			{
							
							
			if($data['target_call']>0)
			{
			
			$persentasi_extra_call = (($data['total_call']+$data['total_extra_call']) * 100) / $data['target_call'];
			$persentasi_extra_call = number_format($persentasi_extra_call, 0, '.', '');	
			
			}
			if($data['total_call']>0)
			{
			$persentasi_effective_call = ($data['total_effective_call'] * 100) / $data['total_call'];
			$persentasi_effective_call = number_format($persentasi_effective_call, 0, '.', '');
			}
			if($data['target_bulanan']>0)
			{
			$persentasi_target_bulanan = ($data['total_monthly_sales'] * 100) / $data['target_bulanan'];
			$persentasi_target_bulanan = number_format($persentasi_target_bulanan, 0, '.', '');
			}
			if($data['total_extra_call']>0)
			{
			$persentasi_extra_effective_call = ($data['total_extra_effective_call'] * 100) / $data['total_extra_call'];
			$persentasi_extra_effective_call = number_format($persentasi_extra_effective_call, 0, '.', '');
			}
			}
						
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $row, $no);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $row, $data['regional']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $row, $data['area']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $row, $data['distributor_code']);
		    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, $row, $data['distributor_name']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, $row, $data['motorist_code']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, $row, $data['motorist_name']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8, $row, $data['motorist_type']);
			$total_store_keseluruhan = 0;
			$store_senin = $this->db->query("SELECT id_store FROM store WHERE motorist_code = '".$data['motorist_code']."' AND distributor_code = '".$data['distributor_code']."' AND day_visit = 'monday' ")->num_rows();
			//echo "store_senin".$store_senin."<br>";
			$total_store_senin = $total_senin * $store_senin;
			$store_selasa = $this->db->query("SELECT id_store FROM store WHERE motorist_code = '".$data['motorist_code']."' AND distributor_code = '".$data['distributor_code']."' AND day_visit = 'tuesday' ")->num_rows();
			//echo "store_selasa".$store_selasa."<br>";
			$total_store_selasa = $total_selasa * $store_selasa;
			$store_rabu = $this->db->query("SELECT id_store FROM store WHERE motorist_code = '".$data['motorist_code']."' AND distributor_code = '".$data['distributor_code']."' AND day_visit = 'wednesday' ")->num_rows();
			$total_store_rabu = $total_rabu * $store_rabu;
			//echo "store_rabu".$store_rabu."<br>";
			$store_kamis = $this->db->query("SELECT id_store FROM store WHERE motorist_code = '".$data['motorist_code']."' AND distributor_code = '".$data['distributor_code']."' AND day_visit = 'thursday' ")->num_rows();
			$total_store_kamis = $total_kamis * $store_kamis;
			//echo "store_kamis".$store_kamis."<br>";
			$store_jumat = $this->db->query("SELECT id_store FROM store WHERE motorist_code = '".$data['motorist_code']."' AND distributor_code = '".$data['distributor_code']."' AND day_visit = 'friday' ")->num_rows();
			$total_store_jumat = $total_jumat * $store_jumat;
			//echo "store_jumat".$store_jumat."<br>";
			$store_sabtu = $this->db->query("SELECT id_store FROM store WHERE motorist_code = '".$data['motorist_code']."' AND distributor_code = '".$data['distributor_code']."' AND day_visit = 'saturday' ")->num_rows();
			$total_store_sabtu = $total_sabtu * $store_sabtu;
			//echo "store_sabtu".$store_sabtu."<br>";
			$total_keseluruhan = $total_store_senin+$total_store_selasa+$total_store_rabu+$total_store_kamis+$total_store_jumat+$total_store_sabtu;
							
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9, $row, $total_keseluruhan);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(10, $row, $data['total_call']);
			if($total_keseluruhan>0)
			{
			$persentasi_call = ($data['total_call'] * 100) / $total_keseluruhan;
			$persentasi_call = number_format($persentasi_call, 0, '.', '');	
			}
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(11, $row, $persentasi_call." %");
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(12, $row, $data['total_extra_call']);
			if($total_keseluruhan>0)
			{
			$persentasi_extra_call = ($data['total_extra_call'] * 100) / $total_keseluruhan;
			$persentasi_extra_call = number_format($persentasi_extra_call, 0, '.', '');	
			}
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(13, $row, $persentasi_extra_call." %");
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(14, $row, $data['total_effective_call']);
			if($total_keseluruhan>0)
			{
			$persentasi_effective_call = ($data['total_effective_call'] * 100) / $total_keseluruhan;
			$persentasi_effective_call = number_format($persentasi_effective_call, 0, '.', '');	
			}
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(15, $row, $persentasi_effective_call." %");
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(16, $row, number_format($data['target_bulanan'], 0 , '' , '.' ));
			
			if($data['total_monthly_sales']=="")
			{$total_monthly_sales=0;}
			else
			{$total_monthly_sales=$data['total_monthly_sales'];}
			
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(17, $row,number_format($total_monthly_sales, 0 , '' , '.' ));
			
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(18, $row, $persentasi_target_bulanan." %");
			
			$data_query_setoran = $this->db->query("SELECT sum(setoran) as total_setoran from absence WHERE motorist_code = '".$data['motorist_code']."' AND  distributor_code = '".$data['distributor_code']."'  AND date_absence between '".$year."-".$bulan."-01 00:00:00' AND '".$year."-".$bulan."-31 23:59:59' ");
			$check_setoran = $data_query_setoran->num_rows();
			if($check_setoran>=1)
			{
			$data_setoran = $data_query_setoran->result_array();
			$setoran_bulanan = $data_setoran[0]['total_setoran'];
			}
			else
			{
			$setoran_bulanan = 0;
			}
			
			$selisih_setoran = $data_setoran[0]['total_setoran']-$data['total_monthly_sales'];
			
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(19, $row, number_format($setoran_bulanan, 0 , '' , '.' ));
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(20, $row, number_format($selisih_setoran, 0 , '' , '.' ));
			
			if($selisih_setoran<0)
			{
			$objPHPExcel->getActiveSheet()->getStyle('U'.$row)->applyFromArray($Fontstyle);
			$objPHPExcel->getActiveSheet()->getStyle('U'.$row)->applyFromArray(
				array(
					'fill' => array(
						'type' => PHPExcel_Style_Fill::FILL_SOLID,
						'color' => array('rgb' => 'f31338')
					)
				)
			);
			}
			else if($selisih_setoran>0) 
			{
				$objPHPExcel->getActiveSheet()->getStyle('U'.$row)->applyFromArray($Fontstyle);
				$objPHPExcel->getActiveSheet()->getStyle('U'.$row)->applyFromArray(
				array(
					'fill' => array(
						'type' => PHPExcel_Style_Fill::FILL_SOLID,
						'color' => array('rgb' => 'ed7e07')
					)
				)
			);
				}
				
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(21, $row, $data['total_outlet']);
			$data_outlet = $this->db->query("SELECT id_order FROM orders WHERE id_motorist = '".$data['id_motorist']."' AND date between '".$year."-".$bulan."-01 00:00:00' AND '".$year."-".$bulan."-31 23:59:59' group by customer_code")->num_rows();
							
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(22, $row, $data_outlet);
			if($data['total_outlet']>0)
			{
			$persentasi_outlet_active = ($data_outlet*100)/ $data['total_outlet'];
			$persentasi_outlet_active = number_format($persentasi_outlet_active, 0, '.', '');
			}
						
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(23, $row, $persentasi_outlet_active." %");
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(24, $row, $data['total_store']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(25, $row, $data['total_noo']);
			
			
            $row++;
			$no++;
        }
		
							if($search=='')
							{
							$search_query = "AND motorist.motorist_code LIKE '%".$search."%' ";
							$search_query_store = "AND store.motorist_code LIKE '%".$search."%' ";
							}
							else
							{
							$search_query = "";
							$search_query_store = '';
							}
		
							if($regional!="")
							{ 
							$regional_query = 'AND distributor.regional in ('.$regional.') ';
							$regional_store_query = 'AND store.regional in ('.$regional.') ';
							}
							else
							{$regional_query =''; $regional_store_query ='';}
							
							
							if($distributor!="")
							{ 
							$distributor_query = 'AND distributor.distributor_code in ('.$distributor.') ';
							$distributor_store_query = 'AND store.distributor_code in ('.$distributor.') ';
							}
							else
							{$distributor_query =''; $distributor_store_query ='';}
						
							if($area!="")
							{ 
							$area_query = 'AND distributor.area in ('.$area.') ';
							$area_store_query = 'AND store.area in ('.$area.') ';
							}
							else
							{$area_query =''; $area_store_query ='';}
				
							if($motorist_type!="")
							{ 
							$motorist_type_query = 'AND motorist.motorist_type in ('.$motorist_type.') ';
							$motorist_type_store_query = 'AND store.motorist_type in ('.$motorist_type.') ';
							}
							else
							{$motorist_type_query =''; $motorist_type_store_query='';}
							
							if($data_account[0]['user_type']=='Administrator')
							{
						
							$total_regional_footer = $this->db->query("SELECT * FROM motorist join distributor where motorist.distributor_code = distributor.distributor_code ".$motorist_type_query." ".$regional_query." ".$search_query." group by distributor.regional")->num_rows();
							$total_area_footer = $this->db->query("SELECT * FROM motorist join distributor where motorist.distributor_code = distributor.distributor_code ".$motorist_type_query." ".$regional_query." ".$search_query." group by distributor.area")->num_rows();
							$total_distributor_footer = $this->db->query("SELECT * FROM motorist join distributor where motorist.distributor_code = distributor.distributor_code ".$motorist_type_query." ".$regional_query." ".$search_query." group by distributor.distributor_code")->num_rows();
							$total_motorist_footer = $this->db->query("SELECT * FROM motorist join distributor where motorist.distributor_code = distributor.distributor_code ".$motorist_type_query." ".$regional_query." ".$search_query." group by motorist.id_motorist")->num_rows();
							$total_motorist_tipe_footer = $this->db->query("SELECT * FROM motorist join distributor where motorist.distributor_code = distributor.distributor_code ".$motorist_type_query." ".$regional_query." ".$search_query." group by motorist.motorist_type")->num_rows();
							$total_call_motorist_footer =  $this->db->query("SELECT visit.customer_code FROM visit JOIN store on store.customer_code = visit.customer_code WHERE status_visit = 'call' AND time_stamp_visit between '".$tanggal_bulan_awal."' AND '".$tanggal_bulan_akhir."' ".$motorist_type_store_query." ".$search_query_store."  ".$regional_store_query." ")->num_rows();
							$total_extra_call_motorist_footer =  $this->db->query("SELECT visit.customer_code FROM visit JOIN store on store.customer_code = visit.customer_code WHERE status_visit = 'extra_call' AND time_stamp_visit between '".$tanggal_bulan_awal."' AND '".$tanggal_bulan_akhir."' ".$motorist_type_store_query." ".$search_query_store." ".$regional_store_query." ")->num_rows();
							$total_effective_call_motorist_footer =  $this->db->query("SELECT visit.customer_code FROM visit JOIN store on store.customer_code = visit.customer_code WHERE status_visit = 'call' AND status_order = 'order' AND time_stamp_visit between '".$tanggal_bulan_awal."' AND '".$tanggal_bulan_akhir."' ".$search_query_store." ".$motorist_type_store_query." ".$regional_store_query." ")->num_rows();
							$total_target_bulanan_footer = $this->db->query("SELECT SUM(target_bulanan) as target_bulanan FROM motorist join distributor on distributor.distributor_code = motorist.distributor_code WHERE id_motorist !='' ".$regional_query." ".$motorist_type_query." ")->result_array();
							$penjualan_bulanan_footer = $this->db->query("SELECT SUM(total_order) as total_penjualan_bulanan FROM orders JOIN store on store.customer_code = orders.customer_code WHERE date between '".$tanggal_bulan_awal."' AND '".$tanggal_bulan_akhir."' ".$regional_store_query." ".$motorist_type_store_query." ".$search_query_store." ")->result_array();
							$total_setoran_footer = $this->db->query("SELECT SUM(setoran) as total_setoran FROM absence JOIN distributor on distributor.distributor_code = absence.distributor_code JOIN motorist on motorist.id_motorist = absence.id_motorist WHERE date_absence between '".$tanggal_bulan_awal."' AND '".$tanggal_bulan_akhir."' ".$regional_query." ".$search_query." ".$motorist_type_query."  ")->result_array();
							$total_master_outlet = $this->db->query("SELECT id_store FROM store WHERE id_store != '' ".$regional_store_query." ".$motorist_type_store_query." ".$search_query_store." ")->num_rows();
							$total_master_outlet_active = $this->db->query("SELECT id_order FROM orders JOIN store on store.customer_code = orders.customer_code  WHERE  date between '".$tanggal_bulan_awal."' AND '".$tanggal_bulan_akhir."' ".$motorist_type_store_query." ".$search_query_store." ".$regional_store_query." group by orders.customer_code")->num_rows();
							$total_noo_footer = $this->db->query("SELECT * FROM noo JOIN store on store.latitude = noo.latitude AND store.longitude = noo.longitude  WHERE noo.customer_create_date between '".$tanggal_bulan_awal."' AND '".$tanggal_bulan_akhir."' ".$regional_store_query." ".$search_query_store." ".$motorist_type_store_query."  group by store.customer_code ")->num_rows();
							$total_store_footer = $this->db->query("SELECt * FROM store WHERE customer_create_date between '".$tanggal_bulan_awal."' AND '".$tanggal_bulan_akhir."' ".$regional_store_query." ".$motorist_type_store_query." ".$search_query_store." ")->num_rows();
							$total_store_keseluruhan_footer = 0;
							
							$store_senin_footer = $this->db->query("SELECT id_store FROM store WHERE  day_visit = 'monday' ".$motorist_type_store_query." ".$regional_store_query."  ".$search_query_store." ")->num_rows();
							//echo "store_senin".$store_senin."<br>";
							$total_store_senin_footer = $total_senin * $store_senin_footer;
							$store_selasa_footer = $this->db->query("SELECT id_store FROM store WHERE day_visit = 'tuesday' ".$motorist_type_store_query." ".$regional_store_query." ".$search_query_store."  ")->num_rows();
							//echo "store_selasa".$store_selasa."<br>";
							$total_store_selasa_footer = $total_selasa * $store_selasa_footer;
							$store_rabu_footer = $this->db->query("SELECT id_store FROM store WHERE  day_visit = 'wednesday' ".$motorist_type_store_query." ".$regional_store_query." ".$search_query_store."  ")->num_rows();
							$total_store_rabu_footer = $total_rabu * $store_rabu_footer;
							//echo "store_rabu".$store_rabu."<br>";
							$store_kamis_footer = $this->db->query("SELECT id_store FROM store WHERE day_visit = 'thursday' ".$motorist_type_store_query." ".$regional_store_query." ".$search_query_store."  ")->num_rows();
							$total_store_kamis_footer = $total_kamis * $store_kamis_footer;
							//echo "store_kamis".$store_kamis."<br>"; 
							$store_jumat_footer = $this->db->query("SELECT id_store FROM store WHERE day_visit = 'friday' ".$motorist_type_store_query." ".$regional_store_query." ".$search_query_store."  ")->num_rows();
							$total_store_jumat_footer = $total_jumat * $store_jumat_footer;
							//echo "store_jumat".$store_jumat."<br>";
							$store_sabtu_footer = $this->db->query("SELECT id_store FROM store WHERE day_visit = 'saturday' ".$motorist_type_store_query." ".$regional_store_query."  ".$search_query_store." ")->num_rows();
							$total_store_sabtu_footer = $total_sabtu * $store_sabtu_footer;
							//echo "store_sabtu".$store_sabtu."<br>";
							$total_keseluruhan_footer = $total_store_senin_footer+$total_store_selasa_footer+$total_store_rabu_footer+$total_store_kamis_footer+$total_store_jumat_footer+$total_store_sabtu_footer;
							
							}
							else
							{
						
								$motorist_type_query = 'AND motorist.motorist_type in ('.$ket.') ';
								$motorist_type_store_query = 'AND store.motorist_type in ('.$ket.') ';
								
							
								
								if($data_account[0]['user_type']=='Ado')
								{
									
									$total_regional_footer = $this->db->query("SELECT * FROM motorist join distributor where motorist.distributor_code = distributor.distributor_code ".$motorist_type_query." ".$regional_query." ".$search_query." AND motorist.distributor_code = '".$data_account[0]['code']."' group by distributor.regional")->num_rows();
									$total_area_footer = $this->db->query("SELECT * FROM motorist join distributor where motorist.distributor_code = distributor.distributor_code ".$motorist_type_query." ".$regional_query." ".$search_query." AND motorist.distributor_code = '".$data_account[0]['code']."' group by distributor.area")->num_rows();
									$total_distributor_footer = $this->db->query("SELECT * FROM motorist join distributor where motorist.distributor_code = distributor.distributor_code ".$motorist_type_query." ".$regional_query." ".$search_query." AND motorist.distributor_code = '".$data_account[0]['code']."' group by distributor.distributor_code")->num_rows();
									$total_motorist_footer = $this->db->query("SELECT * FROM motorist join distributor where motorist.distributor_code = distributor.distributor_code ".$motorist_type_query." ".$regional_query." ".$search_query." AND motorist.distributor_code = '".$data_account[0]['code']."' group by motorist.id_motorist")->num_rows();
									$total_motorist_tipe_footer = $this->db->query("SELECT * FROM motorist join distributor where motorist.distributor_code = distributor.distributor_code ".$motorist_type_query." ".$regional_query." ".$search_query." AND motorist.distributor_code = '".$data_account[0]['code']."' group by motorist.motorist_type")->num_rows();
									$total_call_motorist_footer =  $this->db->query("SELECT visit.customer_code FROM visit JOIN store on store.customer_code = visit.customer_code WHERE status_visit = 'call' AND time_stamp_visit between '".$tanggal_bulan_awal."' AND '".$tanggal_bulan_akhir."' ".$motorist_type_store_query." ".$search_query_store."  ".$regional_store_query." AND store.distributor_code = '".$data_account[0]['code']."' ")->num_rows();
									$total_extra_call_motorist_footer =  $this->db->query("SELECT visit.customer_code FROM visit JOIN store on store.customer_code = visit.customer_code WHERE status_visit = 'extra_call' AND time_stamp_visit between '".$tanggal_bulan_awal."' AND '".$tanggal_bulan_akhir."' ".$motorist_type_store_query." ".$search_query_store." ".$regional_store_query." AND store.distributor_code = '".$data_account[0]['code']."' ")->num_rows();
									$total_effective_call_motorist_footer =  $this->db->query("SELECT visit.customer_code FROM visit JOIN store on store.customer_code = visit.customer_code WHERE status_visit = 'call' AND status_order = 'order' AND time_stamp_visit between '".$tanggal_bulan_awal."' AND '".$tanggal_bulan_akhir."' ".$search_query_store." ".$motorist_type_store_query." ".$regional_store_query." AND store.distributor_code = '".$data_account[0]['code']."' ")->num_rows();
									$total_target_bulanan_footer = $this->db->query("SELECT SUM(target_bulanan) as target_bulanan FROM motorist join distributor on distributor.distributor_code = motorist.distributor_code WHERE id_motorist !='' ".$regional_query." ".$motorist_type_query." AND motorist.distributor_code = '".$data_account[0]['code']."' ")->result_array();
									$penjualan_bulanan_footer = $this->db->query("SELECT SUM(total_order) as total_penjualan_bulanan FROM orders JOIN store on store.customer_code = orders.customer_code WHERE date between '".$tanggal_bulan_awal."' AND '".$tanggal_bulan_akhir."' ".$regional_store_query." ".$motorist_type_store_query." ".$search_query_store." AND store.distributor_code = '".$data_account[0]['code']."' ")->result_array();
									$total_setoran_footer = $this->db->query("SELECT SUM(setoran) as total_setoran FROM absence JOIN distributor on distributor.distributor_code = absence.distributor_code JOIN motorist on motorist.id_motorist = absence.id_motorist WHERE date_absence between '".$tanggal_bulan_awal."' AND '".$tanggal_bulan_akhir."' ".$regional_query." ".$search_query." ".$motorist_type_query." AND motorist.distributor_code = '".$data_account[0]['code']."' ")->result_array();
									$total_master_outlet = $this->db->query("SELECT id_store FROM store WHERE id_store != '' ".$regional_store_query." ".$motorist_type_store_query." ".$search_query_store." AND store.distributor_code = '".$data_account[0]['code']."' ")->num_rows();
									$total_master_outlet_active = $this->db->query("SELECT id_order FROM orders JOIN store on store.customer_code = orders.customer_code  WHERE  date between '".$tanggal_bulan_awal."' AND '".$tanggal_bulan_akhir."' ".$motorist_type_store_query." ".$search_query_store." ".$regional_store_query." AND store.distributor_code = '".$data_account[0]['code']."' group by orders.customer_code")->num_rows();
									$total_noo_footer = $this->db->query("SELECT * FROM noo JOIN store on store.latitude = noo.latitude AND store.longitude = noo.longitude  WHERE noo.customer_create_date between '".$tanggal_bulan_awal."' AND '".$tanggal_bulan_akhir."' ".$regional_store_query." ".$search_query_store." ".$motorist_type_store_query."  AND store.distributor_code = '".$data_account[0]['code']."' group by store.customer_code ")->num_rows();
									$total_store_footer = $this->db->query("SELECt * FROM store WHERE customer_create_date between '".$tanggal_bulan_awal."' AND '".$tanggal_bulan_akhir."' ".$regional_store_query." ".$motorist_type_store_query." ".$search_query_store." AND store.distributor_code = '".$data_account[0]['code']."' ")->num_rows();
									$total_store_keseluruhan_footer = 0;
									
									$store_senin_footer = $this->db->query("SELECT id_store FROM store WHERE  day_visit = 'monday' ".$motorist_type_store_query." ".$regional_store_query."  ".$search_query_store." AND store.distributor_code = '".$data_account[0]['code']."' ")->num_rows();
									//echo "store_senin".$store_senin."<br>";
									$total_store_senin_footer = $total_senin * $store_senin_footer;
									$store_selasa_footer = $this->db->query("SELECT id_store FROM store WHERE day_visit = 'tuesday' ".$motorist_type_store_query." ".$regional_store_query." ".$search_query_store." AND store.distributor_code = '".$data_account[0]['code']."'  ")->num_rows();
									//echo "store_selasa".$store_selasa."<br>";
									$total_store_selasa_footer = $total_selasa * $store_selasa_footer;
									$store_rabu_footer = $this->db->query("SELECT id_store FROM store WHERE  day_visit = 'wednesday' ".$motorist_type_store_query." ".$regional_store_query." ".$search_query_store." AND store.distributor_code = '".$data_account[0]['code']."'  ")->num_rows();
									$total_store_rabu_footer = $total_rabu * $store_rabu_footer;
									//echo "store_rabu".$store_rabu."<br>";
									$store_kamis_footer = $this->db->query("SELECT id_store FROM store WHERE day_visit = 'thursday' ".$motorist_type_store_query." ".$regional_store_query." ".$search_query_store." AND store.distributor_code = '".$data_account[0]['code']."'  ")->num_rows();
									$total_store_kamis_footer = $total_kamis * $store_kamis_footer;
									//echo "store_kamis".$store_kamis."<br>"; 
									$store_jumat_footer = $this->db->query("SELECT id_store FROM store WHERE day_visit = 'friday' ".$motorist_type_store_query." ".$regional_store_query." ".$search_query_store."  AND store.distributor_code = '".$data_account[0]['code']."' ")->num_rows();
									$total_store_jumat_footer = $total_jumat * $store_jumat_footer;
									//echo "store_jumat".$store_jumat."<br>";
									$store_sabtu_footer = $this->db->query("SELECT id_store FROM store WHERE day_visit = 'saturday' ".$motorist_type_store_query." ".$regional_store_query."  ".$search_query_store." AND store.distributor_code = '".$data_account[0]['code']."' ")->num_rows();
									$total_store_sabtu_footer = $total_sabtu * $store_sabtu_footer;
									//echo "store_sabtu".$store_sabtu."<br>";
									$total_keseluruhan_footer = $total_store_senin_footer+$total_store_selasa_footer+$total_store_rabu_footer+$total_store_kamis_footer+$total_store_jumat_footer+$total_store_sabtu_footer;
									
									
									
									}
								else if($data_account[0]['user_type']=='Regional')
								{
									
									$total_regional_footer = $this->db->query("SELECT * FROM motorist join distributor where motorist.distributor_code = distributor.distributor_code ".$motorist_type_query." ".$regional_query." ".$distributor_query." ".$area_query." ".$search_query." AND distributor.regional = '".$data_account[0]['code']."' group by distributor.regional")->num_rows();
									$total_area_footer = $this->db->query("SELECT * FROM motorist join distributor where motorist.distributor_code = distributor.distributor_code ".$motorist_type_query." ".$regional_query." ".$search_query." ".$distributor_query." ".$area_query." AND distributor.regional = '".$data_account[0]['code']."' group by distributor.area")->num_rows();
									$total_distributor_footer = $this->db->query("SELECT * FROM motorist join distributor where motorist.distributor_code = distributor.distributor_code ".$motorist_type_query." ".$regional_query." ".$search_query." ".$distributor_query." ".$area_query." AND distributor.regional = '".$data_account[0]['code']."' group by distributor.distributor_code")->num_rows();
									$total_motorist_footer = $this->db->query("SELECT * FROM motorist join distributor where motorist.distributor_code = distributor.distributor_code ".$motorist_type_query." ".$regional_query." ".$search_query." ".$distributor_query." ".$area_query." AND distributor.regional = '".$data_account[0]['code']."'group by motorist.id_motorist")->num_rows();
									$total_motorist_tipe_footer = $this->db->query("SELECT * FROM motorist join distributor where motorist.distributor_code = distributor.distributor_code ".$motorist_type_query." ".$regional_query." ".$search_query." ".$distributor_query." ".$area_query." AND distributor.regional = '".$data_account[0]['code']."' group by motorist.motorist_type")->num_rows();
									$total_call_motorist_footer =  $this->db->query("SELECT visit.customer_code FROM visit JOIN store on store.customer_code = visit.customer_code WHERE status_visit = 'call' AND time_stamp_visit between '".$tanggal_bulan_awal."' AND '".$tanggal_bulan_akhir."' ".$motorist_type_store_query." ".$distributor_store_query." ".$area_store_query." ".$search_query_store."  ".$regional_store_query." AND store.regional = '".$data_account[0]['code']."' ")->num_rows();
									$total_extra_call_motorist_footer =  $this->db->query("SELECT visit.customer_code FROM visit JOIN store on store.customer_code = visit.customer_code WHERE status_visit = 'extra_call' AND time_stamp_visit between '".$tanggal_bulan_awal."' AND '".$tanggal_bulan_akhir."' ".$motorist_type_store_query." ".$distributor_store_query." ".$area_store_query." ".$search_query_store." ".$regional_store_query." AND store.regional = '".$data_account[0]['code']."' ")->num_rows();
									$total_effective_call_motorist_footer =  $this->db->query("SELECT visit.customer_code FROM visit JOIN store on store.customer_code = visit.customer_code WHERE status_visit = 'call' AND status_order = 'order' AND time_stamp_visit between '".$tanggal_bulan_awal."' AND '".$tanggal_bulan_akhir."' ".$search_query_store." ".$distributor_store_query." ".$area_store_query." ".$motorist_type_store_query." ".$regional_store_query." AND store.regional = '".$data_account[0]['code']."' ")->num_rows();
									$total_target_bulanan_footer = $this->db->query("SELECT SUM(target_bulanan) as target_bulanan FROM motorist join distributor on distributor.distributor_code = motorist.distributor_code WHERE id_motorist !='' ".$regional_query." ".$distributor_query." ".$area_query." ".$motorist_type_query." AND distributor.regional = '".$data_account[0]['code']."' ")->result_array();
									$penjualan_bulanan_footer = $this->db->query("SELECT SUM(total_order) as total_penjualan_bulanan FROM orders JOIN store on store.customer_code = orders.customer_code WHERE date between '".$tanggal_bulan_awal."' AND '".$tanggal_bulan_akhir."' ".$regional_store_query." ".$distributor_store_query." ".$area_store_query." ".$motorist_type_store_query." ".$search_query_store." AND store.regional = '".$data_account[0]['code']."' ")->result_array();
									$total_setoran_footer = $this->db->query("SELECT SUM(setoran) as total_setoran FROM absence JOIN distributor on distributor.distributor_code = absence.distributor_code JOIN motorist on motorist.id_motorist = absence.id_motorist WHERE date_absence between '".$tanggal_bulan_awal."' AND '".$tanggal_bulan_akhir."' ".$regional_query." ".$distributor_query." ".$area_query." ".$search_query." ".$motorist_type_query."  AND distributor.regional = '".$data_account[0]['code']."'")->result_array();
									$total_master_outlet = $this->db->query("SELECT id_store FROM store WHERE id_store != '' ".$regional_store_query." ".$distributor_store_query." ".$area_store_query." ".$motorist_type_store_query." ".$search_query_store." AND store.regional = '".$data_account[0]['code']."' ")->num_rows();
									$total_master_outlet_active = $this->db->query("SELECT id_order FROM orders JOIN store on store.customer_code = orders.customer_code  WHERE  date between '".$tanggal_bulan_awal."' AND '".$tanggal_bulan_akhir."' ".$motorist_type_store_query." ".$search_query_store." ".$regional_store_query." ".$distributor_store_query." ".$area_store_query." AND store.regional = '".$data_account[0]['code']."' group by orders.customer_code")->num_rows();
									$total_noo_footer = $this->db->query("SELECT * FROM noo JOIN store on store.latitude = noo.latitude AND store.longitude = noo.longitude  WHERE noo.customer_create_date between '".$tanggal_bulan_awal."' AND '".$tanggal_bulan_akhir."' ".$regional_store_query." ".$search_query_store." ".$distributor_store_query." ".$area_store_query." ".$motorist_type_store_query." AND store.regional = '".$data_account[0]['code']."'  group by store.customer_code ")->num_rows();
									$total_store_footer = $this->db->query("SELECt * FROM store WHERE customer_create_date between '".$tanggal_bulan_awal."' AND '".$tanggal_bulan_akhir."' ".$regional_store_query." ".$motorist_type_store_query." ".$distributor_store_query." ".$area_store_query." ".$search_query_store." AND store.regional = '".$data_account[0]['code']."' ")->num_rows();
									$total_store_keseluruhan_footer = 0;
									
									$store_senin_footer = $this->db->query("SELECT id_store FROM store WHERE  day_visit = 'monday' ".$motorist_type_store_query." ".$regional_store_query." ".$distributor_store_query." ".$area_store_query."  ".$search_query_store." AND store.regional = '".$data_account[0]['code']."' ")->num_rows();
									//echo "store_senin".$store_senin."<br>";
									$total_store_senin_footer = $total_senin * $store_senin_footer;
									$store_selasa_footer = $this->db->query("SELECT id_store FROM store WHERE day_visit = 'tuesday' ".$motorist_type_store_query." ".$regional_store_query." ".$distributor_store_query." ".$area_store_query." ".$search_query_store." AND store.regional = '".$data_account[0]['code']."'  ")->num_rows();
									//echo "store_selasa".$store_selasa."<br>";
									$total_store_selasa_footer = $total_selasa * $store_selasa_footer;
									$store_rabu_footer = $this->db->query("SELECT id_store FROM store WHERE  day_visit = 'wednesday' ".$motorist_type_store_query." ".$regional_store_query." ".$distributor_store_query." ".$area_store_query." ".$search_query_store." AND store.regional = '".$data_account[0]['code']."'  ")->num_rows();
									$total_store_rabu_footer = $total_rabu * $store_rabu_footer;
									//echo "store_rabu".$store_rabu."<br>";
									$store_kamis_footer = $this->db->query("SELECT id_store FROM store WHERE day_visit = 'thursday' ".$motorist_type_store_query." ".$regional_store_query." ".$distributor_store_query." ".$area_store_query." ".$search_query_store." AND store.regional = '".$data_account[0]['code']."'  ")->num_rows();
									$total_store_kamis_footer = $total_kamis * $store_kamis_footer;
									//echo "store_kamis".$store_kamis."<br>"; 
									$store_jumat_footer = $this->db->query("SELECT id_store FROM store WHERE day_visit = 'friday' ".$motorist_type_store_query." ".$regional_store_query." ".$distributor_store_query." ".$area_store_query." ".$search_query_store." AND store.regional = '".$data_account[0]['code']."'  ")->num_rows();
									$total_store_jumat_footer = $total_jumat * $store_jumat_footer;
									//echo "store_jumat".$store_jumat."<br>";
									$store_sabtu_footer = $this->db->query("SELECT id_store FROM store WHERE day_visit = 'saturday' ".$motorist_type_store_query." ".$regional_store_query." ".$distributor_store_query." ".$area_store_query."  ".$search_query_store." AND store.regional = '".$data_account[0]['code']."' ")->num_rows();
									$total_store_sabtu_footer = $total_sabtu * $store_sabtu_footer;
									//echo "store_sabtu".$store_sabtu."<br>";
									$total_keseluruhan_footer = $total_store_senin_footer+$total_store_selasa_footer+$total_store_rabu_footer+$total_store_kamis_footer+$total_store_jumat_footer+$total_store_sabtu_footer;
									
									
									
									}
							
							}
							
							
							
						$persentasi_outlet_active_footer = 0;	
						$persentasi_call_footer = 0;
						$persentasi_extra_call_footer = 0;
						$persentasi_effective_call_footer = 0;
						$persentasi_extra_effective_call_footer = 0;
						$persentasi_target_bulanan_footer = 0;
						
						
						if($total_master_outlet>0)
							{
							$persentasi_outlet_active_footer = ($total_master_outlet_active * 100) / $total_master_outlet;
							$persentasi_outlet_active_footer = number_format($persentasi_outlet_active_footer, 0, '.', '');	
							}
							
						if($total_keseluruhan_footer>0)
							{
							$persentasi_call_footer = ($total_call_motorist_footer * 100) / $total_keseluruhan_footer;
							$persentasi_call_footer = number_format($persentasi_call_footer, 0, '.', '');	
							}
						
						if($total_keseluruhan_footer>0)
							{
							$persentasi_extra_call_footer = ($total_extra_call_motorist_footer * 100) / $total_keseluruhan_footer;
							$persentasi_extra_call_footer = number_format($persentasi_extra_call_footer, 0, '.', '');	
							}
						
						if($total_keseluruhan_footer>0)
							{
							$persentasi_effective_call_footer = ($total_effective_call_motorist_footer * 100) / $total_keseluruhan_footer;
							$persentasi_effective_call_footer = number_format($persentasi_effective_call_footer, 0, '.', '');	
							}
						
						
						if($total_target_bulanan_footer[0]['target_bulanan']>0)
							{
							$persentasi_target_bulanan_footer = ($penjualan_bulanan_footer[0]['total_penjualan_bulanan'] * 100) / $total_target_bulanan_footer[0]['target_bulanan'];
							$persentasi_target_bulanan_footer = number_format($persentasi_target_bulanan_footer, 0, '.', '');	
							}
							
						
					
					
						$selisih_setoran = $total_setoran_footer[0]['total_setoran']- $penjualan_bulanan_footer[0]['total_penjualan_bulanan'] ;
						
						
						
		
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $row, "Total");
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $row, $total_regional_footer." Regional");
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $row, $total_area_footer." Area");
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $row, $total_distributor_footer." Distributor");   
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, $row, $total_distributor_footer." Distributor");
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, $row, $total_motorist_footer." Motorist");
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, $row, $total_motorist_footer." Motorist");
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8, $row, $total_motorist_tipe_footer." Motorist Type");
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9, $row, $total_keseluruhan_footer);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(10, $row, $total_call_motorist_footer);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(11, $row, $persentasi_call_footer." %");
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(12, $row, $total_extra_call_motorist_footer);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(13, $row, $persentasi_extra_call_footer." %");
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(14, $row, $total_effective_call_motorist_footer);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(15, $row, $persentasi_effective_call_footer." %");
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(16, $row, number_format($total_target_bulanan_footer[0]['target_bulanan'], 0 , '' , '.' ));
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(17, $row, number_format($penjualan_bulanan_footer[0]['total_penjualan_bulanan'], 0 , '' , '.' ));
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(18, $row, $persentasi_target_bulanan_footer." %");
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(19, $row, number_format($total_setoran_footer[0]['total_setoran'], 0 , '' , '.' ));
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(20, $row, number_format($selisih_setoran, 0 , '' , '.' ));
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(21, $row, $total_master_outlet);
	    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(22, $row, $total_master_outlet_active);
	   	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(23, $row, $persentasi_outlet_active_footer." %");
     	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(24, $row, $total_store_footer);
   	    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(25, $row, $total_noo_footer);
	   //Set Font Color Header
		$objPHPExcel->getActiveSheet()->getStyle('B'.$row.':'.'Z'.$row)->applyFromArray($Fontstyle);
		
		//Set Backgroung Color Header
		$objPHPExcel->getActiveSheet()->getStyle('B'.$row.':'.'Z'.$row)->applyFromArray(
			array(
				'fill' => array(
					'type' => PHPExcel_Style_Fill::FILL_SOLID,
					'color' => array('rgb' => '62a8ea')
				)
			)
		);
		
		
	   $last_row = $row;
	   //Set Border
       $objPHPExcel->getActiveSheet()->getStyle("B4".":"."Z".$last_row)->applyFromArray($BStyle);
	   $objPHPExcel->getActiveSheet()->getStyle("B4".":"."Z".$last_row)->applyFromArray($styleAlign);
       $objPHPExcel->setActiveSheetIndex(0);
 
        $objWriter = IOFactory::createWriter($objPHPExcel, 'Excel5');
 		
		
	   // Sending headers to force the user to download the file
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Monthly-motorist-month-'.$bulan.'-year-'.$year.'.xls"');
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
		
	
	
	
	
	public function exportDailySummaryMotorist()
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
		
		$area = isset($_GET['area']) ? $_GET['area'] : '';
		$distributor = isset($_GET['distributor']) ? $_GET['distributor'] : '';
		$search = isset($_GET['search']) ? $_GET['search'] : '';
		$regional = isset($_GET['regional']) ? $_GET['regional'] : '';
		$motorist_type = isset($_GET['motorist_type']) ? $_GET['motorist_type'] : '';
		$date = isset($_GET['date']) ? $_GET['date'] : '';
		
		$day = date('l');
		$date_now = date('Y-m-d');
		
		if($date!="")
		{
			$tanggal_pecah = explode("/", $date);
			$date_now=$tanggal_pecah[2].'-'.$tanggal_pecah[0].'-'.$tanggal_pecah[1];
			$date_convert = date_create($date_now);
			$day = date_format($date_convert,"l");

		}
		$this->db->select(" * ,
		(SELECT COUNT(customer_code) FROM visit as v WHERE v.id_motorist = motorist.id_motorist AND status_visit = 'call' AND time_stamp_visit LIKE '%".$date_now."%') as total_call,
		(SELECT COUNT(customer_code) FROM visit as v WHERE v.id_motorist = motorist.id_motorist AND status_visit = 'extra_call' AND time_stamp_visit LIKE '%".$date_now."%') as total_extra_call,
		(SELECT COUNT(customer_code) FROM visit as v WHERE v.id_motorist = motorist.id_motorist AND status_visit = 'call' AND status_order = 'order' AND time_stamp_visit LIKE '%".$date_now."%') as total_effective_call,
		(SELECT COUNT(customer_code) FROM visit as v WHERE v.id_motorist = motorist.id_motorist AND status_visit = 'call' AND status_order = 'extra_call' AND time_stamp_visit LIKE '%".$date_now."%') as total_extra_effective_call,
		(SELECT SUM(price_total) FROM product_orders as p WHERE p.id_motorist = motorist.id_motorist AND date LIKE '%".$date_now."%') as total_daily_sales,
		(SELECT setoran FROM absence as a WHERE a.motorist_code = motorist.motorist_code AND a.distributor_code = motorist.distributor_code AND date_absence LIKE '%".$date_now."%' limit 1) as total_daily_setoran
		");
		
		$this->db->where("motorist.motorist_type in (".$ket.") ");
		if($user_role=="Ado")
		{
			$this->db->where("motorist.distributor_code = '".$code_role."' ");
		}
		else if($user_role=="Regional")
		{
			$this->db->where("distributor.regional = '".$code_role."' ");		
		}
		
		if($distributor!="")
		{
			
			$this->db->where('motorist.distributor_code in ('.$distributor.') ');
		}
		if($area!="")
		{
			$this->db->where('distributor.area in ('.$area.') ');
		}
		
		if($regional!="")
		{
			$this->db->where('regional in ('.$regional.') ');
		}
		
		if($motorist_type!="")
		{
			$this->db->where('motorist.motorist_type in ('.$motorist_type.') ');
		}
		$this->db->like('motorist_code', $search);
		$this->db->join('distributor', 'distributor.distributor_code = motorist.distributor_code');
		$this->db->join('motorist_type', 'motorist_type.id_motorist_type = motorist.motorist_type');
		$query = $this->db->get('motorist');
		
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
		
		
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 1, "Daily Summary Motorist");
		//Merge And Center Title
		$objPHPExcel->getActiveSheet()->mergeCells('A1:D1');
		
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 2, "Date : ".$date);
		
		//Merge And Center Date
		$objPHPExcel->getActiveSheet()->mergeCells('A2:D2');
		
		//Set Font Color Title
		$objPHPExcel->getActiveSheet()->getStyle('A1:D2')->applyFromArray($FontstyleTitle);
		
		//Set Font Color Header
		$objPHPExcel->getActiveSheet()->getStyle('B4:W4')->applyFromArray($Fontstyle);
		
		//Set Backgroung Color Header
		$objPHPExcel->getActiveSheet()->getStyle('B4:W4')->applyFromArray(
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
		"Distributor Name" => "Distributor Name",
		"Kode Motorist" => "Kode Motorist",
		"Nama Motorist" => "Nama Motorist",
		"Tipe Motorist" => "Tipe Motorist",
		"(A) Target Call" => "(A) Target Call",
		"(B) Call" => "(B) Call",
		"(B/A)  %Call" => "(B/A)  %Call",
		"(C) Ekstra Call" => "(C) Ekstra Call",
		"(C/B) %Ekstra Call" => "(C/B) %Ekstra Call",
		"(D) Efektif Call" => "(D) Efektif Call",
		"(D/A) %Efektif Call" => "(D/A) %Efektif Call",
		"(E) Ekstra Effective Call" => "(E) Ekstra Effective Call",
		"(E/A) %Ekstra Effective Call" => "(E/A) %Ekstra Effective Call",
		"(F) Target Penjualan Harian" => "(F) Target Penjualan Harian",
		"(G) Penjualan Harian" => "(G) Penjualan Harian",
		"(G/F) Pencapaian Penjualan" => "(G/F) Pencapaian Penjualan",
		"(I) Total Setoran" => "(I) Total Setoran",
		"(I-G) Selisih Setoran" => "(I-G) Selisih Setoran"
		
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
		
						$ddate = date("Y-m-d");
						$date_new = new DateTime($ddate);
						$week = $date_new->format("W");
						$status_minggu = "";
						if ($week % 2 == 0) {
						  $status_minggu = "F2";
						}
						else
						{
							$status_minggu = "F1";
						}

						$date_now = date('Y-m-d');
						$date_convert = date_create($date_now);
						$day = date_format($date_convert,"l");
						if($date!="")
						{
							$tanggal_pecah = explode("/", $date);
							$date_now=$tanggal_pecah[2].'-'.$tanggal_pecah[0].'-'.$tanggal_pecah[1];
							$date_convert = date_create($date_now);
							$day = date_format($date_convert,"l");
						}
						
        foreach($query->result_array() as $data)
        {
			$target_call = $this->db->query("SELECT id_store FROM store WHERE motorist_code = '".$data['motorist_code']."' AND distributor_code = '".$data['distributor_code']."' AND day_visit = '".$day."' AND customer_status = 'active' AND frequency in ('W','".$status_minggu."') ")->num_rows();
			
			$persentasi_call = 0;
			$persentasi_extra_call = 0;
			$persentasi_effective_call = 0;
			$persentasi_extra_effective_call = 0;
			$persentasi_target_harian = 0;
			if($data['total_call']>0)
			{
			if($target_call>0)
			{
			$persentasi_call = ($data['total_call'] * 100) / $target_call;
			$persentasi_call = number_format($persentasi_call, 0, '.', '');	
			}
			if($target_call>0)
			{
			$persentasi_extra_call = ($data['total_extra_call'] * 100) / $target_call;
			$persentasi_extra_call = number_format($persentasi_extra_call, 0, '.', '');	
			}
			if($target_call>0)
			{
			$persentasi_effective_call = ($data['total_effective_call'] * 100) / $target_call;
			$persentasi_effective_call = number_format($persentasi_effective_call, 0, '.', '');
			}
			if($data['total_daily_sales']>0)
			{
			$persentasi_target_harian = ($data['total_daily_sales'] * 100) / $data['target_harian'];
			$persentasi_target_harian = number_format($persentasi_target_harian, 0, '.', '');
			}
			if($data['total_extra_call']>0)
			{
			$persentasi_extra_effective_call = ($data['total_extra_effective_call'] * 100) / $data['total_extra_call'];
			$persentasi_extra_effective_call = number_format($persentasi_extra_effective_call, 0, '.', '');
			}
			}
			
			if($data['total_daily_sales']=="")
			{$total_daily_sales = 0;}
			else
			{$total_daily_sales = $data['total_daily_sales'];}
			
			if($data['total_daily_setoran']=="")
			{$total_daily_setoran = 0;}
			else
			{$total_daily_setoran = $data['total_daily_setoran'];}
			
						
			
						
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $row, $no);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $row, $data['regional']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $row, $data['area']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $row, $data['distributor_code']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, $row, $data['distributor_name']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, $row, $data['motorist_code']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, $row,$data['motorist_name']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8, $row,$data['motorist_type']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9, $row, $target_call);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(10, $row, $data['total_call']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(11, $row, $persentasi_call." %");
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(12, $row, $data['total_extra_call']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(13, $row, $persentasi_extra_call." %");
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(14, $row, $data['total_effective_call']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(15, $row, $persentasi_effective_call." %");
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(16, $row, $data['total_extra_effective_call']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(17, $row, $persentasi_extra_effective_call." %");
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(18, $row, number_format($data['target_harian'], 0 , '' , '.' ));
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(19, $row, number_format($total_daily_sales, 0 , '' , '.' ));
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(20, $row, $persentasi_target_harian." %");
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(21, $row, number_format($total_daily_setoran, 0 , '' , '.' ) );
			$selisih_setoran = $data['total_daily_setoran'] - $data['total_daily_sales'];
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(22, $row,number_format($selisih_setoran, 0 , '' , '.' ) );
			
		
			if($selisih_setoran<0)
			{
			$objPHPExcel->getActiveSheet()->getStyle('W'.$row)->applyFromArray($Fontstyle);
			$objPHPExcel->getActiveSheet()->getStyle('W'.$row)->applyFromArray(
				array(
					'fill' => array(
						'type' => PHPExcel_Style_Fill::FILL_SOLID,
						'color' => array('rgb' => 'f31338')
					)
				)
			);
			}
			else if($selisih_setoran>0) 
			{
				$objPHPExcel->getActiveSheet()->getStyle('W'.$row)->applyFromArray($Fontstyle);
				$objPHPExcel->getActiveSheet()->getStyle('W'.$row)->applyFromArray(
				array(
					'fill' => array(
						'type' => PHPExcel_Style_Fill::FILL_SOLID,
						'color' => array('rgb' => 'ed7e07')
					)
				)
			);
				}
			
            $row++;
			$no++;
        }
		
		
		
					$date_now_footer = date('Y-m-d');
					if($date!="")
					{
						$tanggal_pecah = explode("/", $date);
						$date_now_footer=$tanggal_pecah[2].'-'.$tanggal_pecah[0].'-'.$tanggal_pecah[1];
						$date_convert = date_create($date_now_footer);
						$day = date_format($date_convert,"l");
					}
					
					if($regional!='')
					{ 
					$regional_query = 'AND distributor.regional in ('.$regional.') ';
					$regional_store_query = 'AND store.regional in ('.$regional.') ';
					}
					else
					{$regional_query =''; $regional_store_query ='';}
					
					
					if($distributor!="")
					{ 
					$distributor_query = 'AND distributor.distributor_code in ('.$distributor.') ';
					$distributor_store_query = 'AND store.distributor_code in ('.$distributor.') ';
					}
					else
					{$distributor_query =''; $distributor_store_query ='';}
				
					if($area!="")
					{ 
					$area_query = 'AND distributor.area in ('.$area.') ';
					$area_store_query = 'AND store.area in ('.$area.') ';
					}
					else
					{$area_query =''; $area_store_query ='';}
				

					if($search!=='')
					{
						$search_query = "AND motorist.motorist_code LIKE '%".$search."%' ";
						$search_query_store = "AND store.motorist_code LIKE '%".$search."%' ";
						}
					else
					{
						$search_query = "";
						$search_query_store = '';
					}
					
					
					if($motorist_type!="")
					{ 
					$motorist_type_query = 'AND motorist.motorist_type in ('.$motorist_type.') ';
					$motorist_type_store_query = 'AND store.motorist_type in ('.$motorist_type.') ';
					}
					else
					{$motorist_type_query =''; $motorist_type_store_query='';}
					
					if($data_account[0]['user_type']=='Administrator')
					{
					$total_area_footer = $this->db->query("SELECT * FROM motorist join distributor on motorist.distributor_code = distributor.distributor_code WHERE id_motorist !='' ".$regional_query." ".$distributor_query." ".$area_query." ".$motorist_type_query." ".$search_query." group by distributor.area")->num_rows();
					$total_regional_footer = $this->db->query("SELECT * FROM motorist join distributor on motorist.distributor_code = distributor.distributor_code WHERE id_motorist !='' ".$regional_query." ".$distributor_query." ".$area_query." ".$motorist_type_query." ".$search_query." group by distributor.regional")->num_rows();
					$total_motorist_footer = $this->db->query("SELECT * FROM motorist join distributor on motorist.distributor_code = distributor.distributor_code WHERE id_motorist !='' ".$regional_query." ".$distributor_query." ".$area_query." ".$search_query." ".$motorist_type_query." ")->num_rows();
					$total_tipe_motorist_footer = $this->db->query("SELECT * FROM motorist join distributor on motorist.distributor_code = distributor.distributor_code WHERE id_motorist !='' ".$regional_query." ".$distributor_query." ".$area_query." ".$motorist_type_query." ".$search_query."  group by motorist_type")->num_rows();
					$total_distributor_footer = $this->db->query("SELECT * FROM motorist join distributor on motorist.distributor_code = distributor.distributor_code WHERE id_motorist !='' ".$regional_query." ".$distributor_query." ".$area_query." ".$motorist_type_query." ".$search_query." group by motorist.distributor_code")->num_rows();
					$target_call_footer = $this->db->query("SELECT id_store FROM store WHERE day_visit = '".$day."' ".$regional_store_query." ".$distributor_store_query." ".$area_store_query." ".$motorist_type_store_query." ".$search_query_store." AND customer_status = 'active'  AND frequency in ('W','".$status_minggu."') ")->num_rows();
					$call_footer = $this->db->query("SELECT visit.customer_code FROM visit JOIN store on store.customer_code = visit.customer_code WHERE status_visit = 'call' AND time_stamp_visit LIKE '%".$date_now."%' ".$regional_store_query." ".$distributor_store_query." ".$area_store_query." ".$search_query_store." ".$motorist_type_store_query." ")->num_rows();
					$extra_call_footer = $this->db->query("SELECT visit.customer_code FROM visit JOIN store on store.customer_code = visit.customer_code WHERE status_visit = 'extra_call' AND time_stamp_visit LIKE '%".$date_now."%' ".$regional_store_query." ".$distributor_store_query." ".$area_store_query." ".$search_query_store." ".$motorist_type_store_query." ")->num_rows();
					$effective_call_footer = $this->db->query("SELECT visit.customer_code FROM visit JOIN store on store.customer_code = visit.customer_code WHERE status_visit = 'call' AND status_order = 'order' AND time_stamp_visit LIKE '%".$date_now."%' ".$regional_store_query." ".$distributor_store_query." ".$area_store_query." ".$search_query_store." ".$motorist_type_store_query." ")->num_rows();
					$extra_effective_call_footer = $this->db->query("SELECT visit.customer_code FROM visit JOIN store on store.customer_code = visit.customer_code WHERE status_visit = 'extra_call' AND status_order = 'order' AND time_stamp_visit LIKE '%".$date_now."%' ".$search_query_store." ".$regional_store_query." ".$distributor_store_query." ".$area_store_query." ".$motorist_type_store_query." ")->num_rows();
					$target_harian_footer = $this->db->query("SELECT SUM(target_harian) as total_target_harian FROM motorist join distributor on distributor.distributor_code = motorist.distributor_code WHERE id_motorist !='' ".$motorist_type_query." ".$regional_query." ".$distributor_query." ".$area_query."  ".$search_query." ")->result_array();
					$penjualan_harian_footer = $this->db->query("SELECT SUM(price_total) as total_penjualan_harian FROM product_orders JOIN store on store.customer_code = product_orders.customer_code WHERE date LIKE '%".$date_now."%' ".$regional_store_query." ".$motorist_type_store_query." ".$distributor_store_query." ".$area_store_query." ".$search_query_store." ")->result_array();
					$total_setoran_footer = $this->db->query("SELECT SUM(setoran) as total_setoran FROM absence JOIN distributor on distributor.distributor_code = absence.distributor_code JOIN motorist on motorist.id_motorist = absence.id_motorist WHERE date_absence LIKE '%".$date_now."%' ".$regional_query." ".$distributor_query." ".$area_query." ".$search_query." ".$motorist_type_query." ")->result_array();
					
					}
					else
					{
						
						
						$motorist_type_query = 'AND motorist.motorist_type in ('.$ket.') ';
						$motorist_type_store_query = 'AND store.motorist_type in ('.$ket.') ';
						
						
					if($data_account[0]['user_type']=='Ado')
					{
					
					
					$total_area_footer = $this->db->query("SELECT * FROM motorist join distributor on motorist.distributor_code = distributor.distributor_code WHERE id_motorist !='' ".$regional_query." ".$distributor_query." ".$area_query." ".$motorist_type_query." ".$search_query."   AND motorist.distributor_code = '".$data_account[0]['code']."' group by distributor.area")->num_rows();
					$total_regional_footer = $this->db->query("SELECT * FROM motorist join distributor on motorist.distributor_code = distributor.distributor_code WHERE id_motorist !='' ".$regional_query." ".$distributor_query." ".$area_query." ".$motorist_type_query." ".$search_query."  AND motorist.distributor_code = '".$data_account[0]['code']."' group by distributor.regional")->num_rows();
					$total_motorist_footer = $this->db->query("SELECT * FROM motorist join distributor on motorist.distributor_code = distributor.distributor_code WHERE id_motorist !='' ".$regional_query." ".$distributor_query." ".$area_query." AND motorist.distributor_code = '".$data_account[0]['code']."' ".$search_query." ".$motorist_type_query." ")->num_rows();
					$total_tipe_motorist_footer = $this->db->query("SELECT * FROM motorist join distributor on motorist.distributor_code = distributor.distributor_code WHERE id_motorist !='' ".$regional_query." ".$distributor_query." ".$area_query." ".$search_query." ".$motorist_type_query." AND motorist.distributor_code = '".$data_account[0]['code']."' group by motorist_type")->num_rows();
					$total_distributor_footer = $this->db->query("SELECT * FROM motorist join distributor on motorist.distributor_code = distributor.distributor_code WHERE id_motorist !='' ".$regional_query." ".$distributor_query." ".$area_query." ".$search_query." ".$motorist_type_query." AND motorist.distributor_code = '".$data_account[0]['code']."' group by motorist.distributor_code")->num_rows();
					$target_call_footer = $this->db->query("SELECT id_store FROM store WHERE day_visit = '".$day."' ".$regional_store_query." ".$distributor_store_query." ".$area_store_query." ".$motorist_type_store_query." ".$search_query_store."  AND store.distributor_code = '".$data_account[0]['code']."' AND customer_status = 'active' AND frequency in ('W','".$status_minggu."') ")->num_rows();
					$call_footer = $this->db->query("SELECT visit.customer_code FROM visit JOIN store on store.customer_code = visit.customer_code WHERE status_visit = 'call' AND time_stamp_visit LIKE '%".$date_now."%' ".$regional_store_query." ".$distributor_store_query." ".$area_store_query." ".$search_query_store." ".$motorist_type_store_query." AND store.distributor_code = '".$data_account[0]['code']."' ")->num_rows();
					$extra_call_footer = $this->db->query("SELECT visit.customer_code FROM visit JOIN store on store.customer_code = visit.customer_code WHERE status_visit = 'extra_call' AND time_stamp_visit LIKE '%".$date_now."%' ".$regional_store_query." ".$distributor_store_query." ".$area_store_query." ".$search_query_store." ".$motorist_type_store_query." AND store.distributor_code = '".$data_account[0]['code']."' ")->num_rows();
					$effective_call_footer = $this->db->query("SELECT visit.customer_code FROM visit JOIN store on store.customer_code = visit.customer_code WHERE status_visit = 'call' AND status_order = 'order' AND time_stamp_visit LIKE '%".$date_now."%' ".$search_query_store." ".$distributor_store_query." ".$area_store_query." ".$regional_store_query." ".$motorist_type_store_query." AND store.distributor_code = '".$data_account[0]['code']."' ")->num_rows();
					$extra_effective_call_footer = $this->db->query("SELECT visit.customer_code FROM visit JOIN store on store.customer_code = visit.customer_code WHERE status_visit = 'extra_call' AND status_order = 'order' AND time_stamp_visit LIKE '%".$date_now."%' ".$search_query_store." ".$regional_store_query." ".$distributor_store_query." ".$area_store_query." ".$motorist_type_store_query." AND store.distributor_code = '".$data_account[0]['code']."' ")->num_rows();
					$target_harian_footer = $this->db->query("SELECT SUM(target_harian) as total_target_harian FROM motorist join distributor on distributor.distributor_code = motorist.distributor_code WHERE id_motorist !='' ".$motorist_type_query." ".$regional_query." ".$distributor_query." ".$area_query." ".$search_query." AND motorist.distributor_code = '".$data_account[0]['code']."'  ")->result_array();
					$penjualan_harian_footer = $this->db->query("SELECT SUM(price_total) as total_penjualan_harian FROM product_orders JOIN store on store.customer_code = product_orders.customer_code WHERE date LIKE '%".$date_now."%' ".$regional_store_query." ".$distributor_store_query." ".$area_store_query." ".$motorist_type_store_query." ".$search_query_store." AND store.distributor_code = '".$data_account[0]['code']."' ")->result_array();
					$total_setoran_footer = $this->db->query("SELECT SUM(setoran) as total_setoran FROM absence JOIN distributor on distributor.distributor_code = absence.distributor_code JOIN motorist on motorist.id_motorist = absence.id_motorist WHERE date_absence LIKE '%".$date_now."%' ".$search_query." ".$regional_query." ".$distributor_query." ".$area_query." ".$motorist_type_query."  AND motorist.distributor_code = '".$data_account[0]['code']."' ")->result_array();
							
						}
					else if($data_account[0]['user_type']=='Regional')
					{
						
					$total_area_footer = $this->db->query("SELECT * FROM motorist join distributor on motorist.distributor_code = distributor.distributor_code WHERE id_motorist !='' ".$regional_query." ".$distributor_query." ".$area_query." ".$motorist_type_query." ".$search_query."   AND distributor.regional = '".$data_account[0]['code']."' group by distributor.area")->num_rows();
					$total_regional_footer = $this->db->query("SELECT * FROM motorist join distributor on motorist.distributor_code = distributor.distributor_code WHERE id_motorist !='' ".$regional_query." ".$distributor_query." ".$area_query." ".$motorist_type_query." ".$search_query."  AND distributor.regional = '".$data_account[0]['code']."' group by distributor.regional")->num_rows();	
					$total_motorist_footer = $this->db->query("SELECT * FROM motorist join distributor on motorist.distributor_code = distributor.distributor_code WHERE id_motorist !='' ".$regional_query." ".$distributor_query." ".$area_query." AND distributor.regional = '".$data_account[0]['code']."' ".$search_query." ".$motorist_type_query." ")->num_rows();
					$total_tipe_motorist_footer = $this->db->query("SELECT * FROM motorist join distributor on motorist.distributor_code = distributor.distributor_code WHERE id_motorist !='' ".$regional_query." ".$distributor_query." ".$area_query." ".$motorist_type_query." ".$search_query." AND distributor.regional = '".$data_account[0]['code']."' group by motorist_type")->num_rows();
					$total_distributor_footer = $this->db->query("SELECT * FROM motorist join distributor on motorist.distributor_code = distributor.distributor_code WHERE id_motorist !='' ".$regional_query." ".$distributor_query." ".$area_query." ".$motorist_type_query." ".$search_query_store." AND distributor.regional = '".$data_account[0]['code']."' group by motorist.distributor_code")->num_rows();
					$target_call_footer = $this->db->query("SELECT id_store FROM store WHERE day_visit = '".$day."' ".$regional_store_query." ".$motorist_type_store_query." ".$distributor_store_query." ".$area_store_query." ".$search_query_store." AND store.regional = '".$data_account[0]['code']."' AND customer_status = 'active' AND frequency in ('W','".$status_minggu."') ")->num_rows();
					$call_footer = $this->db->query("SELECT visit.customer_code FROM visit JOIN store on store.customer_code = visit.customer_code WHERE status_visit = 'call' AND time_stamp_visit LIKE '%".$date_now."%' ".$regional_store_query." ".$distributor_store_query." ".$area_store_query."  ".$search_query_store." ".$motorist_type_store_query." AND store.regional = '".$data_account[0]['code']."' ")->num_rows();
					$extra_call_footer = $this->db->query("SELECT visit.customer_code FROM visit JOIN store on store.customer_code = visit.customer_code WHERE status_visit = 'extra_call' AND time_stamp_visit LIKE '%".$date_now."%' ".$regional_store_query." ".$distributor_store_query." ".$area_store_query."  ".$search_query_store." ".$motorist_type_store_query." AND store.regional = '".$data_account[0]['code']."' ")->num_rows();
					$effective_call_footer = $this->db->query("SELECT visit.customer_code FROM visit JOIN store on store.customer_code = visit.customer_code WHERE status_visit = 'call' AND status_order = 'order' AND time_stamp_visit LIKE '%".$date_now."%' ".$search_query_store." ".$distributor_store_query." ".$area_store_query."  ".$regional_store_query." ".$motorist_type_store_query." AND store.regional = '".$data_account[0]['code']."' ")->num_rows();
					$extra_effective_call_footer = $this->db->query("SELECT visit.customer_code FROM visit JOIN store on store.customer_code = visit.customer_code WHERE status_visit = 'extra_call' AND status_order = 'order' AND time_stamp_visit LIKE '%".$date_now."%' ".$search_query_store." ".$distributor_store_query." ".$area_store_query."  ".$regional_store_query." ".$motorist_type_store_query." AND store.regional = '".$data_account[0]['code']."' ")->num_rows();
					$target_harian_footer = $this->db->query("SELECT SUM(target_harian) as total_target_harian FROM motorist join distributor on distributor.distributor_code = motorist.distributor_code WHERE id_motorist !='' ".$motorist_type_query." ".$search_query." ".$regional_query." ".$distributor_query." ".$area_query."  AND distributor.regional= '".$data_account[0]['code']."'  ")->result_array();
					$penjualan_harian_footer = $this->db->query("SELECT SUM(price_total) as total_penjualan_harian FROM product_orders JOIN store on store.customer_code = product_orders.customer_code WHERE date LIKE '%".$date_now."%' ".$regional_store_query." ".$search_query_store." ".$motorist_type_store_query." ".$distributor_store_query." ".$area_store_query."  AND store.regional = '".$data_account[0]['code']."' ")->result_array();
					$total_setoran_footer = $this->db->query("SELECT SUM(setoran) as total_setoran FROM absence JOIN distributor on distributor.distributor_code = absence.distributor_code JOIN motorist on motorist.id_motorist = absence.id_motorist WHERE date_absence LIKE '%".$date_now."%' ".$regional_query." ".$distributor_query." ".$area_query."  ".$search_query." ".$motorist_type_query."  AND distributor.regional = '".$data_account[0]['code']."' ")->result_array();
						
						
						
						}	
					
						
					
					}
					
					
						$persentasi_call_footer = 0;
						$persentasi_extra_call_footer = 0;
						$persentasi_effective_call_footer = 0;
						$persentasi_extra_effective_call_footer = 0;
						$persentasi_target_harian_footer = 0;
						if($target_call_footer>0)
							{
							$persentasi_call_footer = ($call_footer * 100) / $target_call_footer;
							$persentasi_call_footer = number_format($persentasi_call_footer, 0, '.', '');	
							}
						
						if($target_call_footer>0)
							{
							$persentasi_extra_call_footer = ($extra_call_footer * 100) / $target_call_footer;
							$persentasi_extra_call_footer = number_format($persentasi_extra_call_footer, 0, '.', '');	
							}
						
						if($target_call_footer>0)
							{
							$persentasi_effective_call_footer = ($effective_call_footer * 100) / $target_call_footer;
							$persentasi_effective_call_footer = number_format($persentasi_effective_call_footer, 0, '.', '');	
							}
						
						if($target_call_footer>0)
							{
							$persentasi_extra_effective_call_footer = ($extra_effective_call_footer * 100) / $target_call_footer;
							$persentasi_extra_effective_call_footer = number_format($persentasi_extra_effective_call_footer, 0, '.', '');	
							}
						
						if($target_harian_footer[0]['total_target_harian']>0)
							{
							$persentasi_target_harian_footer = ($penjualan_harian_footer[0]['total_penjualan_harian'] * 100) / $target_harian_footer[0]['total_target_harian'];
							$persentasi_target_harian_footer = number_format($persentasi_target_harian_footer, 0, '.', '');	
							}
		
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $row, "Total");
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $row, $total_regional_footer." Regional");
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $row, $total_area_footer." Area");
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $row, $total_distributor_footer." Distributor");
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, $row, $total_distributor_footer." Distributor");
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, $row, $total_motorist_footer." Motorist");
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, $row, $total_motorist_footer." Motorist");
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8, $row, $total_tipe_motorist_footer." Tipe Motorist");
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9, $row, $target_call_footer);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(10, $row, $call_footer);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(11, $row, $persentasi_call_footer);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(12, $row, $extra_call_footer);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(13, $row, $persentasi_extra_call_footer);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(14, $row, $effective_call_footer);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(15, $row, $persentasi_effective_call_footer);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(16, $row, $extra_effective_call_footer);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(17, $row, $persentasi_extra_effective_call_footer);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(18, $row, number_format($target_harian_footer[0]['total_target_harian'], 0 , '' , '.' ));
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(19, $row, number_format($penjualan_harian_footer[0]['total_penjualan_harian'], 0 , '' , '.' ));
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(20, $row, $persentasi_target_harian_footer);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(21, $row, number_format($total_setoran_footer[0]['total_setoran'], 0 , '' , '.' ));
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(22, $row, number_format($total_setoran_footer[0]['total_setoran']-$penjualan_harian_footer[0]['total_penjualan_harian'], 0 , '' , '.' ) );
		
		
		
		//Set Font Color Header
		$objPHPExcel->getActiveSheet()->getStyle('B'.$row.':W'.$row)->applyFromArray($Fontstyle);
		
		//Set Backgroung Color Header
		$objPHPExcel->getActiveSheet()->getStyle('B'.$row.':W'.$row)->applyFromArray(
			array(
				'fill' => array(
					'type' => PHPExcel_Style_Fill::FILL_SOLID,
					'color' => array('rgb' => '62a8ea')
				)
			)
		);
		
			
		
	   $last_row = $row;
	   //Set Border
       $objPHPExcel->getActiveSheet()->getStyle("B4".":"."W".$last_row)->applyFromArray($BStyle);
	   $objPHPExcel->getActiveSheet()->getStyle("B4".":"."W".$last_row)->applyFromArray($styleAlign);
       $objPHPExcel->setActiveSheetIndex(0);
 
        $objWriter = IOFactory::createWriter($objPHPExcel, 'Excel5');
 		
		
	   // Sending headers to force the user to download the file
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Master-Motorist-'.$date.'.xls"');
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