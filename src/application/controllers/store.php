<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Store extends CI_Controller {

	function __construct()  {
 		parent::__construct();
			$this->load->library(array('PHPExcel','PHPExcel/IOFactory'));
			$this->load->model('model_account_master');
			$this->load->model('model_store');
			$this->load->library('tank_auth');
			
	}
	
	
	public function stokpoint()
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
			$store_name = isset($_GET['store_name']) ? $_GET['store_name'] : '';
			$regional = isset($_GET['regional']) ? $_GET['regional'] : '';
			$motorist_code = isset($_GET['motorist_code']) ? $_GET['motorist_code'] : '';
			$distributor = isset($_GET['distributor_code']) ? $_GET['distributor_code'] : '';
			$date = isset($_GET['date']) ? $_GET['date'] : '';
			if(isset($_GET['regional']))
			{
				$regional = "'" . implode("','", $regional) . "'";
			}
			
			$motorist_type = isset($_GET['motorist_type']) ? $_GET['motorist_type'] : '';
			if(isset($_GET['motorist_type']))
			{$motorist_type = implode(",",$motorist_type);}
			
			if (count($_GET) > 0) $config['suffix'] = '?' . http_build_query($_GET, '', "&");
			$jumlah= $this->model_store->countStockPoint($search,$user_role,$code_role,$ket,$regional,$motorist_type,$motorist_code,$distributor,$date,$store_name);
			$config['base_url'] = base_url().'index.php/store/store/';
			$config['total_rows'] = $jumlah;
			$config['first_link'] = 'First';
			$config['last_link'] = 'End';
			$config['next_link'] = 'Next';
			$config['prev_link'] = 'Previous';
			$config['per_page'] = 20; 	
			
			if (count($_GET) > 0) $config['suffix'] = '?' . http_build_query($_GET, '', "&");
			$config['first_url'] = $config['base_url'].'?'.http_build_query($_GET);
			
			$dari = $this->uri->segment('3');
			$data = $this->model_store->dataStockPoint($config['per_page'],$dari,$search,$user_role,$code_role,$ket,$regional,$motorist_type,$motorist_code,$distributor,$date,$store_name);
			$data_regional = $this->model_store->getRegional()->result_array();
			$data_motorist_type = $this->model_store->getMotoristType()->result_array();
			$this->pagination->initialize($config);
			
		
			$comp = array(
				
				'title' => ' Stock Point',
				'content' => $this->load->view('stock_point',array('data_account'=>$data_account,'data_regional'=>$data_regional,'data_motorist_type'=>$data_motorist_type,'data_store'=>$data,'search'=>$search),true),
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
	
	public function updateStoreKa()
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
				
				// Get Variable Post
				$id_store = $_POST['id_store'];
				$status_valid = $_POST['status_toko'];
				$day_visit = $_POST['day_visit'];
				$customer_status = $_POST['customer_status'];
				
				foreach( $id_store as $key => $id_stores ) {

						$data_update = array(						
						"frequency" => $status_valid[$key],
						"day_visit" => $day_visit[$key],
						"customer_status" => $customer_status[$key],
						);
						$where = array("id_store"=>$id_stores);	
						
						$res = $this->model_store->updateData("store",$data_update,$where);
				}
				
				
				if($res)
				{
				$this->session->set_flashdata('message_success',"Data store has been successfully updated!");
				redirect('motorist/journeyPlanMotorist/');
				}
				else
				{
					$this->session->set_flashdata('message_failed',"Data store failed to updated!");
				redirect('motorist/journeyPlanMotorist/');
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
	
	
	
	public function outletSTT()
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
			$store_name = isset($_GET['store_name']) ? $_GET['store_name'] : '';
			$regional = isset($_GET['regional']) ? $_GET['regional'] : '';
			$motorist_code = isset($_GET['motorist_code']) ? $_GET['motorist_code'] : '';
			$distributor = isset($_GET['distributor']) ? $_GET['distributor'] : '';
			if(isset($_GET['distributor']))
			{$distributor = implode(",",$distributor);}
			
			
			$date = isset($_GET['date']) ? $_GET['date'] : '';
			if(isset($_GET['regional']))
			{
				$regional = "'" . implode("','", $regional) . "'";
			}
			
			$motorist_type = isset($_GET['motorist_type']) ? $_GET['motorist_type'] : '';
			if(isset($_GET['motorist_type']))
			{$motorist_type = implode(",",$motorist_type);}
			
			if (count($_GET) > 0) $config['suffix'] = '?' . http_build_query($_GET, '', "&");
			$jumlah= $this->model_store->countStoreStt($search,$user_role,$code_role,$ket,$regional,$motorist_type,$motorist_code,$distributor,$date,$store_name);
			$config['base_url'] = base_url().'index.php/store/outletSTT/';
			$config['total_rows'] = $jumlah;
			$config['first_link'] = 'First';
			$config['last_link'] = 'End';
			$config['next_link'] = 'Next';
			$config['prev_link'] = 'Previous';
			$config['per_page'] = 20; 	
			
			if (count($_GET) > 0) $config['suffix'] = '?' . http_build_query($_GET, '', "&");
			$config['first_url'] = $config['base_url'].'?'.http_build_query($_GET);
			
			$dari = $this->uri->segment('3');
			$data = $this->model_store->dataStoreStt($config['per_page'],$dari,$search,$user_role,$code_role,$ket,$regional,$motorist_type,$motorist_code,$distributor,$date,$store_name);
			$data_regional = $this->model_store->getRegional()->result_array();
			$data_motorist_type = $this->model_store->getMotoristType()->result_array();
			
			if($user_role=="Regional")
			{
				$data_distributor = $this->model_store->getDistributor("WHERE regional='".$code_role."' ")->result_array();
			}
			else
			{
				$data_distributor = $this->model_store->getDistributor()->result_array();
			}
			
			$this->pagination->initialize($config);
			
		
			$comp = array(
				
				'title' => ' Store',
				'content' => $this->load->view('store-stt',array('data_account'=>$data_account,'data_regional'=>$data_regional,'data_motorist_type'=>$data_motorist_type,'data_store'=>$data,'search'=>$search,'data_distributor'=>$data_distributor),true),
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
	
	
	
	public function switching()
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
			$id_motorist = isset($_GET['id_motorist']) ? $_GET['id_motorist'] : '';
			$bulan = isset($_GET['bulan']) ? $_GET['bulan'] : '';
			$tahun = isset($_GET['tahun']) ? $_GET['tahun'] : '';
			
			$detail_motorist = $this->db->query("SELECT * FROM motorist WHERE id_motorist = '".$id_motorist."' ")->result_array();
			$motorist_code = $detail_motorist[0]['motorist_code'];
			$distributor_code = $detail_motorist[0]['distributor_code'];
			

			
			$jumlah= $this->model_store->countStoreSwitching($user_role,$code_role,$bulan,$motorist_code,$distributor_code,$tahun);
			$config['base_url'] = base_url().'index.php/store/store/';
			$config['total_rows'] = $jumlah;
			$config['first_link'] = 'First';
			$config['last_link'] = 'End';
			$config['next_link'] = 'Next';
			$config['prev_link'] = 'Previous';
			$config['per_page'] = 100; 	
			
			$dari = $this->uri->segment('3');
			$data = $this->model_store->dataStoreSwitching($config['per_page'],$dari,$user_role,$code_role,$bulan,$motorist_code,$distributor_code,$tahun);
		
			
		
			$comp = array(
				
				'title' => ' Switching Store',
				'content' => $this->load->view('monthly-switching',array('data_account'=>$data_account,'data_motorist'=>$detail_motorist,'data_switching'=>$data),true),
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
	
	
	
	
	
	public function filterStore()
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
			$ket = $data_role_etools[0]['motorist_view'];
			if($data_role[0]['see_store']=='yes')
			{	
			
			$this->load->library('table');
			$this->load->library('pagination');
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
			
			
			$channel = isset($_GET['channel']) ? $_GET['channel'] : '';
			if(isset($_GET['channel']))
			{$channel = implode(",",$channel);}
			
			$motorist = isset($_GET['motorist']) ? $_GET['motorist'] : '';
			if(isset($_GET['motorist']))
			{$motorist = "'" . implode("','", $motorist ) . "'";
			}
			
			$day = isset($_GET['day']) ? $_GET['day'] : '';
			if(isset($_GET['day']))
			{
				$day = "'" . implode("','", $day) . "'";
			}
			
			
			$product = isset($_GET['product']) ? $_GET['product'] : '';
			if(isset($_GET['product']))
			{$product = implode(",",$product);}
			$month = isset($_GET['month']) ? $_GET['month'] : '';
			$transaction_month = isset($_GET['transaction-month']) ? $_GET['transaction-month'] : '';
			
			$jumlah= $this->model_store->countFilterMap($distributor,$channel,$motorist,$day,$product,$month,$transaction_month,$user_role,$code_role,$ket,$regional,$motorist_type,$area,$tahun);
			$config['base_url'] = base_url().'index.php/store/filterstore/';
			$config['total_rows'] = $jumlah;
			$config['first_link'] = 'First';
			$config['last_link'] = 'End';
			$config['next_link'] = 'Next';
			$config['prev_link'] = 'Previous';
			$config['per_page'] = 20; 	
			
			
			if (count($_GET) > 0) $config['suffix'] = '?' . http_build_query($_GET, '', "&");
			$config['first_url'] = $config['base_url'].'?'.http_build_query($_GET);
			
			$dari = $this->uri->segment('3');
			
			
			$data = $this->model_store->filterMap($config['per_page'],$dari,$distributor,$channel,$motorist,$day,$product,$month,$transaction_month,$user_role,$code_role,$ket,$regional,$motorist_type,$area,$tahun);
			
			
			$this->pagination->initialize($config);
			if($user_role=="Regional")
			{
				$data_distributor = $this->model_store->getDistributor("WHERE regional='".$code_role."' ")->result_array();
			}
			else
			{
				$data_distributor = $this->model_store->getDistributor()->result_array();
			}
			
			$data_channel = $this->model_store->getChannel()->result_array();
			
			if($user_role=="Ado")
			{
				
					$data_motorist_type = $this->model_store->getMotoristType("where motorist_type  in ('Kantin','OOH') ")->result_array();
					$data_motorist = $this->model_store->getMotorist("WHERE distributor_code = '".$code_role."' AND motorist_type in (".$ket.") ")->result_array();
				
				
				
			}
			else
			{
				$data_motorist_type = $this->model_store->getMotoristType()->result_array();
				$data_motorist = $this->model_store->getMotorist("")->result_array();
			}
			
		
			$data_product = $this->model_store->getProduct()->result_array();
			$data_total_store = $this->model_store->filterMapTotal($distributor,$channel,$motorist,$day,$product,$month,$transaction_month,$user_role,$code_role,$ket,$regional,$motorist_type,$area,$tahun);
			$data_regional = $this->model_store->getRegional()->result_array();
			
			$data_motorist_type = $this->model_store->getMotoristType("where id_motorist_type in (".$ket.") ")->result_array();
			
			if($user_role=="Regional")
			{
				
				$data_area = $this->db->query("SELECT * FROM master_area WHERE regional = '".$code_role."' ")->result_array();
			}
			else
			{
				
				$data_area = $this->db->query('SELECT * FROM master_area')->result_array();
			}
			
			
			$comp = array(
				
				'title' => ' Store',
				'content' => $this->load->view('filter-store',array('data_role_etools'=>$data_role_etools,'data_area'=>$data_area,'data_motorist_type'=>$data_motorist_type,'data_regional'=>$data_regional,'data_account'=>$data_account,'data_total_store'=>$data_total_store,'data_motorist'=>$data_motorist,'data_channel'=>$data_channel,'data_store'=>$data,'data_distributor'=>$data_distributor,'data_product'=>$data_product),true),
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
			$store_name = isset($_GET['store_name']) ? $_GET['store_name'] : '';
			$regional = isset($_GET['regional']) ? $_GET['regional'] : '';
			$motorist_code = isset($_GET['motorist_code']) ? $_GET['motorist_code'] : '';
			$distributor = isset($_GET['distributor_code']) ? $_GET['distributor_code'] : '';
			$date = isset($_GET['date']) ? $_GET['date'] : '';
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
			$jumlah= $this->model_store->countStore($search,$user_role,$code_role,$ket,$regional,$motorist_type,$motorist_code,$distributor,$date,$store_name,$area,$distributor);
			$config['base_url'] = base_url().'index.php/store/store/';
			$config['total_rows'] = $jumlah;
			$config['first_link'] = 'First';
			$config['last_link'] = 'End';
			$config['next_link'] = 'Next';
			$config['prev_link'] = 'Previous';
			$config['per_page'] = 20; 	
			
			if (count($_GET) > 0) $config['suffix'] = '?' . http_build_query($_GET, '', "&");
			$config['first_url'] = $config['base_url'].'?'.http_build_query($_GET);
			
			$dari = $this->uri->segment('3');
			$data = $this->model_store->dataStore($config['per_page'],$dari,$search,$user_role,$code_role,$ket,$regional,$motorist_type,$motorist_code,$distributor,$date,$store_name,$area,$distributor);
			$data_regional = $this->model_store->getRegional()->result_array();
			$data_motorist_type = $this->model_store->getMotoristType()->result_array();
			
			
			if($user_role=="Regional")
			{
				$data_area = $this->db->query("SELECT * FROM master_area WHERE regional = '".$code_role."' ")->result_array();
				$data_distributor = $this->model_store->getDistributor("WHERE regional='".$code_role."' ")->result_array();
			}
			else 
			{
				$data_area = $this->db->query('SELECT * FROM master_area')->result_array();
				$data_distributor = $this->model_store->getDistributor()->result_array();
			}
			
			
			
			$this->pagination->initialize($config);
			
		
			$comp = array(
				
				'title' => ' Store',
				'content' => $this->load->view('store',array('data_distributor'=>$data_distributor,'data_area'=>$data_area,'data_account'=>$data_account,'data_regional'=>$data_regional,'data_motorist_type'=>$data_motorist_type,'data_store'=>$data,'search'=>$search),true),
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
	
	
	
	public function addStore()
	{
		
			date_default_timezone_set('Asia/Jakarta');
			ini_set('memory_limit', '-1');
			
			if ($this->tank_auth->is_logged_in()) {
			$user	= $this->tank_auth->get_username();
			$data_account = $this->model_account_master->getAccount("WHERE username = '".$user."' ")->result_array();
			$data_role = $this->model_account_master->getRole("WHERE id_role = '".$data_account[0]['user_access']."' ")->result_array();
			$user_role = $data_account[0]['user_type'];
			$code_role = $data_account[0]['code'];
			
			if($data_role[0]['add_store']=='yes')
			{
				
			$this->load->helper('form');
			$this->load->helper('url');
			$this->load->library('form_validation');
		
			$this->form_validation->set_rules('motorist_code','Motorist','required');
			$this->form_validation->set_rules('day_visit','Day Visit','required');
			$this->form_validation->set_rules('channel','Channel','required');
			$this->form_validation->set_rules('frequency','Frequency','required');
			$this->form_validation->set_rules('customer_code','Customer Code','required');
			$this->form_validation->set_rules('customer_name','Customer Name','required');
			$this->form_validation->set_rules('customer_status','Customer Status','required');
			$this->form_validation->set_rules('place_status','Place Status','required');
			$this->form_validation->set_rules('address','Address','required');
			$this->form_validation->set_rules('status_qr_code','QR Code Status','required');
			
			$data_distributor = $this->model_store->getDistributor()->result();
			$data_motorist = $this->model_store->getMotorist("WHERE distributor_code = '".$code_role."' ")->result();
			$data_channel = $this->model_store->getChannel()->result();
			
			if($this->form_validation->run()==FALSE){
					
					$data = array ("");
					$comp = array(
						
						'title' => ' Add Store',
						'content' => $this->load->view('add-store',array('data'=>$data,'data_distributor'=>$data_distributor,'data_motorist'=>$data_motorist,'data_channel'=>$data_channel),true),
						'sidebar' => $this->html_sidebar()
					
					);
					
					
					$this->load->view("common/common",$comp);
			}
			
			else
			{
				// Get Variable Post
				$motorist_code = $_POST['motorist_code'];
				$day_visit = strtolower($_POST['day_visit']);
				$channel = $_POST['channel'];
				$frequency = strtolower($_POST['frequency']);
				$customer_name = $_POST['customer_name'];
				$customer_code = $_POST['customer_code'];
				$customer_contact = $_POST['customer_contact'];
				$customer_status= strtolower($_POST['customer_status']);
				$place_status = strtolower($_POST['place_status']);
				$address = $_POST['address'];
				$district = $_POST['district'];
				$latitude = $_POST['latitude'];
				$longitude = $_POST['longitude'];
				$status_qr_code = strtolower($_POST['status_qr_code']);
				$status_latitude = "";
				
				$address = str_replace(" ", "-", $address);
				$district = str_replace(" ", "", $district);
				
				//Give Status latitude 
				
				if($latitude!="" && $longitude!="")
				{$status_latitude = "Yes";}
				else
				{$status_latitude = "No";}
				
				
				$data_motorist = $this->model_store->getMotorist("WHERE motorist_code = '".$motorist_code."' ")->result_array();
				$motorist_name = $data_motorist[0]['motorist_name'];
				$urutan_motorist = $data_motorist[0]['urutan_motorist'];
				$distributor_code = $data_motorist[0]['distributor_code'];
				
				//Get Distributor
				$data_distributor = $this->model_store->getDistributor("WHERE distributor_code = '".$distributor_code."' ")->result_array();
				$distributor_name = $data_distributor[0]['distributor_name'];
				
				
				//Get Channel
				$data_channel = $this->model_store->getChannel("WHERE classification_code = '".$channel."' ")->result_array();
				$channel_name = $data_channel[0]['channel_description'];
				
				
				
				
				
				
				
				$data_insert= array(
				"distributor_code" => $distributor_code,
				"distributor_name" => $distributor_name,
				"motorist_code" => $motorist_code,
				"motorist_name" => $motorist_name,
				"day_visit" => $day_visit,
				"frequency" => $frequency,
				"customer_code" => $customer_code,
				"customer_name" => $customer_name,
				"channel_code" => $channel,
				"channel_name" => $channel_name,
				"place_status" => $place_status,
				"customer_status" => $customer_status,
				"address" => $address,
				"districts" => $district,
				"customer_contact" => $customer_contact,
				"latitude" => $latitude,
				"longitude" => $longitude,
				"status_latitude" => $status_latitude,
				"status_qr_code" => $status_qr_code,
				"urutan_motorist" => $urutan_motorist
				
				);
				
				
				//check apakah data sudah eksis
				$check_store_exist = $this->model_store->getStore("WHERE motorist_code = '".$motorist_code."' AND customer_code = '".$customer_code."' ")->num_rows();
				if($check_store_exist>=1)
				{
					$this->session->set_flashdata('message_failed',"Sorry data already exist!");
					redirect('store');
					
					}
				else
				{
					$res = $this->model_store->insertData("store",$data_insert);
					if($res>=1)
					{
						$this->session->set_flashdata('message_success',"Data store has been successfully saved!");
						redirect('store');
						}
					else
					{
						$this->session->set_flashdata('message_failed',"Data store failed to insert, Please try again!");
						redirect('store');
						
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
	
	
	
	public function editStore($id_store)
	{
		
			date_default_timezone_set('Asia/Jakarta');
			ini_set('memory_limit', '-1');
			
			if ($this->tank_auth->is_logged_in()) {
			$user	= $this->tank_auth->get_username();
			$data_account = $this->model_account_master->getAccount("WHERE username = '".$user."' ")->result_array();
			$data_role = $this->model_account_master->getRole("WHERE id_role = '".$data_account[0]['user_access']."' ")->result_array();
			$user_role = $data_account[0]['user_type'];
			$code_role = $data_account[0]['code'];
			$data_role_etools = $this->model_account_master->getRoleEtools("WHERE id_role = '".$data_account[0]['ket']."' ")->result_array();
			$ket = $data_role_etools[0]['motorist_view'];
			
			if($data_role[0]['add_product']=='yes')
			{
				
			$this->load->helper('form');
			$this->load->helper('url');
			$this->load->library('form_validation');
			
			$this->form_validation->set_rules('id_store','ID Store','required');
			$this->form_validation->set_rules('day_visit','Day Visit','required');
			$this->form_validation->set_rules('channel','Channel','required');
			$this->form_validation->set_rules('motorist_code','Motorist Code','required');
			$this->form_validation->set_rules('frequency','Frequency','required');
			$this->form_validation->set_rules('customer_name','Customer Name','required');
			$this->form_validation->set_rules('customer_status','Customer Status','required');
			$this->form_validation->set_rules('place_status','Place Status','required');
			$this->form_validation->set_rules('address','Address','required');
			$this->form_validation->set_rules('status_qr_code','QR Code Status','required');
			$this->form_validation->set_rules('loyalty_store','Loyalty Store','required');
			
			if($this->form_validation->run()==FALSE){
			
			$check_store = $this->model_store->getStore("WHERE id_store = '".$id_store."' ");
			if($check_store->num_rows() >=1)
			{	
			
			$data_distributor = $this->model_store->getDistributor()->result_array();
			$data_store = $check_store->result_array();
			
			$select_distributor_store = $this->db->query("SELECT * FROM store where id_store = '".$id_store."' ")->result_array();
			$data_distributor_store = $select_distributor_store[0]['distributor_code'];
			
			
			if($user_role=="Administrator")
			{
				$data_motorist = $this->db->query("SELECT * FROM motorist WHERE distributor_code = '".$data_distributor_store."'  ")->result();
			}
			
			if($user_role=="Ado")
			{
				
				
				$data_motorist = $this->model_store->getMotorist("WHERE motorist.motorist_type in (".$ket.") AND distributor_code = '".$code_role."' ")->result();
				
				
			}
			
			else if($user_role=="Regional")
			{
			
				$data_motorist = $this->db->query("SELECT * FROM motorist INNER JOIN distributor ON  motorist.distributor_code = distributor.distributor_code WHERE regional = '".$code_role."' AND motorist.motorist_type in (".$ket.") AND motorist.distributor_code = '".$data_distributor_store."'   ")->result();
				
				
					
			}
			
			
			
			
		
			
			
			
			$data_channel = $this->model_store->getChannel()->result();	
			
			
			$data = array (
				"id_store" => $data_store[0]['id_store'],
				"distributor_code" => $data_store[0]['distributor_code'],
				"distributor_name" => $data_store[0]['distributor_name'],
				"motorist_code" => $data_store[0]['motorist_code'],
				"motorist_name" => $data_store[0]['motorist_name'],
				"day_visit" => $data_store[0]['day_visit'],
				"frequency" => $data_store[0]['frequency'],
				"customer_code" => $data_store[0]['customer_code'],
				"customer_name" => $data_store[0]['customer_name'],
				"channel_code" => $data_store[0]['channel_code'],
				"channel_name" => $data_store[0]['channel_name'],
				"place_status" => $data_store[0]['place_status'],
				"customer_status" => $data_store[0]['customer_status'],
				"loyalty_store" => $data_store[0]['loyalty_store'],
				"address" => $data_store[0]['address'],
				"districts" => $data_store[0]['districts'],
				"customer_contact" => $data_store[0]['customer_contact'],
				"latitude" => $data_store[0]['latitude'],
				"longitude" => $data_store[0]['longitude'],
				"status_qr_code" => $data_store[0]['status_qr_code']
				
			);
			
			
			
					$comp = array(
						
						'title' => ' Edit store',
						'content' => $this->load->view('edit-store',array('data'=>$data,'data_motorist'=>$data_motorist,'data_channel'=>$data_channel,'data_distributor'=>$data_distributor),true),
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
				$id_store = $_POST['id_store'];
				$day_visit = strtolower($_POST['day_visit']);
				$channel = $_POST['channel'];
				$frequency = strtolower($_POST['frequency']);
				$motorist_code = $_POST['motorist_code'];
				$customer_name = $_POST['customer_name'];
				$customer_contact = $_POST['customer_contact'];
				$customer_status= strtolower($_POST['customer_status']);
				$place_status = strtolower($_POST['place_status']);
				$address = $_POST['address'];
				$district = $_POST['district'];
				$latitude = $_POST['latitude'];
				$loyalty_store = $_POST['loyalty_store'];
				$longitude = $_POST['longitude'];
				$status_qr_code = strtolower($_POST['status_qr_code']);
				$status_latitude = "";
				$customer_code = "";
				
				
				$address = str_replace(" ", "-", $address);
				$district = str_replace(" ", "", $district);
				
				//Give Status latitude 
				
				if($latitude!="" && $longitude!="")
				{$status_latitude = "Yes";}
				else
				{$status_latitude = "No";}
				
				//Get Channel
				$data_channel = $this->model_store->getChannel("WHERE classification_code = '".$channel."' ")->result_array();
				$channel_name = $data_channel[0]['channel_description'];
				
				
				//Get Motorist
				$data_motorist_detail = $this->model_store->getMotorist("WHERE motorist_code = '".$motorist_code."' ")->result_array();
				$motorist_name = $data_motorist_detail[0]['motorist_name'];
				
				
				$data_update = array(
				
				"day_visit" => $day_visit,
				"frequency" => $frequency,
				"motorist_code" => $motorist_code,
				"motorist_name" => $motorist_name,
				"customer_name" => $customer_name,
				"channel_code" => $channel,
				"channel_name" => $channel_name,
				"place_status" => $place_status,
				"customer_status" => $customer_status,
				"address" => $address,
				"loyalty_store" => $loyalty_store,
				"districts" => $district,
				"customer_contact" => $customer_contact,
				"latitude" => $latitude,
				"longitude" => $longitude,
				"status_latitude" => $status_latitude,
				"status_qr_code" => $status_qr_code,

				);
				
				$where = array("id_store"=>$id_store);
				
				//Check Product Apakah sudah ada dengan kode produk dan type motorist yang sama
				$check = $this->model_store->getStore("WHERE id_store = '".$id_store."' ");
				
				
					//Update Product
					$res = $this->model_store->UpdateData("store",$data_update,$where);
					if($res>=1)
					{
						$this->session->set_flashdata('message_success',"Data store has been successfully updated!");
						redirect('store');
						
						}
					else
					{
						$this->session->set_flashdata('message_failed',"Data store failed to update!");
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
	
	
	
	
	public function deleteStore($id_store)
	{
		
			date_default_timezone_set('Asia/Jakarta');
			ini_set('memory_limit', '-1');
			
			if ($this->tank_auth->is_logged_in()) {
			$user	= $this->tank_auth->get_username();
			$data_account = $this->model_account_master->getAccount("WHERE username = '".$user."' ")->result_array();
			$data_role = $this->model_account_master->getRole("WHERE id_role = '".$data_account[0]['user_access']."' ")->result_array();
			$user_role = $data_account[0]['user_type'];
			$code_role = $data_account[0]['code'];
			
			if($data_role[0]['delete_store']=='yes')
			{
				
			$this->load->helper('form');
			$this->load->helper('url');
			$this->load->library('form_validation');
			$this->form_validation->set_rules('id_store','ID Store','required');
			
			if($this->form_validation->run()==FALSE){
			
			$check_store = $this->model_store->getStore("WHERE id_store = '".$id_store."' ");
			if($check_store->num_rows() >=1)
			{	
			$data_store = $check_store->result_array();	
			$data = array (
				"id_store" => $data_store[0]['id_store'],
				"distributor_code" => $data_store[0]['distributor_code'],
				"distributor_name" => $data_store[0]['distributor_name'],
				"motorist_code" => $data_store[0]['motorist_code'],
				"motorist_name" => $data_store[0]['motorist_name'],
				"day_visit" => $data_store[0]['day_visit'],
				"frequency" => $data_store[0]['frequency'],
				"customer_code" => $data_store[0]['customer_code'],
				"customer_name" => $data_store[0]['customer_name'],
				"channel_code" => $data_store[0]['channel_code'],
				"channel_name" => $data_store[0]['channel_name'],
				"place_status" => $data_store[0]['place_status'],
				"customer_status" => $data_store[0]['customer_status'],
				"address" => $data_store[0]['address'],
				"districts" => $data_store[0]['districts'],
				"customer_contact" => $data_store[0]['customer_contact'],
				"latitude" => $data_store[0]['latitude'],
				"longitude" => $data_store[0]['longitude'],
				"status_qr_code" => $data_store[0]['status_qr_code']
			);
			
			
			
					$comp = array(
						
						'title' => ' Delete Store',
						'content' => $this->load->view('delete-store',$data,true),
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
	
	
	public function importStorexxx()
	{
		
			date_default_timezone_set('Asia/Jakarta');
			ini_set('memory_limit', '-1');
			
			if ($this->tank_auth->is_logged_in()) {
			$user	= $this->tank_auth->get_username();
			$data_account = $this->model_account_master->getAccount("WHERE username = '".$user."' ")->result_array();
			$data_role = $this->model_account_master->getRole("WHERE id_role = '".$data_account[0]['user_access']."' ")->result_array();
			$user_role = $data_account[0]['user_type'];
			$code_role = $data_account[0]['code'];
			
			if($data_role[0]['import_store']=='yes')
			{
				
			$this->load->helper('form', 'html', 'file');
			$this->load->helper('url');
			$this->load->library('form_validation');
			
			
			
			
			
					
					$data = array ("");
					$comp = array(
						
						'title' => ' Import Store',
						'content' => $this->load->view('import-store',array('data'=>$data),true),
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
	
	
	
	public function doImportStore()
	{
		
			date_default_timezone_set('Asia/Jakarta');
			ini_set('memory_limit', '-1');
			
			if ($this->tank_auth->is_logged_in()) {
			$user	= $this->tank_auth->get_username();
			$data_account = $this->model_account_master->getAccount("WHERE username = '".$user."' ")->result_array();
			$data_role = $this->model_account_master->getRole("WHERE id_role = '".$data_account[0]['user_access']."' ")->result_array();
			$user_role = $data_account[0]['user_type'];
			$code_role = $data_account[0]['code'];
			
			if($data_role[0]['import_store']=='yes')
			{
				
				
			if ($_POST) {
			ini_set('memory_limit', '-1');
		    $fileName = $_FILES['import']['name'];
			$config['upload_path'] = './files/';
			$config['file_name'] = $fileName;
			$config['allowed_types'] = 'xls|xlsx';
			$config['max_size'] = 100000000;

			$this->load->library('upload');
			$this->upload->initialize($config);

			if(! $this->upload->do_upload('import') )
			{
				$this->session->set_flashdata('message_failed','Import Failed, Please upload file excel extension!');
				redirect('store');
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
												
				
				if($rowData[0][0]!="")
				{
						
				$distributor_code = $rowData[0][0];		
				$customer_code = $rowData[0][1];
				$motorist_code = $rowData[0][2];
				$day_visit = strtolower($rowData[0][3]);
				$channel = $rowData[0][4];
				$frequency = strtolower($rowData[0][5]);
				$customer_name = $rowData[0][6];
				$customer_contact = $rowData[0][7];
				$customer_status= strtolower($rowData[0][8]);
				$place_status = strtolower($rowData[0][9]);
				$address = $rowData[0][10];
				$district = $rowData[0][11];
				$latitude = $rowData[0][12];
				$longitude = $rowData[0][13];
				$status_qr_code = strtolower($rowData[0][14]);
				$status_latitude = "";
				$foto_toko = $rowData[0][15];
				$loyalty_store = $rowData[0][16];
				
				$address = str_replace(" ", "-", $address);
				$district = str_replace(" ", "", $district);
				
				//Give Status latitude 
				
				if($latitude!="" && $longitude!="")
				{$status_latitude = "Yes";}
				else
				{$status_latitude = "No";}
				
				
				$data_motorist = $this->model_store->getMotorist("WHERE motorist_code = '".$motorist_code."' AND distributor_code = '".$distributor_code."' ")->result_array();
				$motorist_name = $data_motorist[0]['motorist_name'];
				$urutan_motorist = $data_motorist[0]['urutan_motorist'];
				$motorist_type = $data_motorist[0]['motorist_type'];
				
				//Get Distributor
				$data_distributor = $this->model_store->getDistributor("WHERE distributor_code = '".$distributor_code."' ")->result_array();
				$distributor_name = $data_distributor[0]['distributor_name'];
				$distributor_regional = $data_distributor[0]['regional'];
				$distributor_area = $data_distributor[0]['area'];
				
				
				//Get Channel
				$data_channel = $this->model_store->getChannel("WHERE classification_code LIKE '%".$channel."%' ")->result_array();
				$channel_name = $data_channel[0]['channel_description'];
				
				
				
				$data_insert= array(
				"regional" => $distributor_regional,
				"area" => $distributor_area,
				"distributor_code" => $distributor_code,
				"distributor_name" => $distributor_name,
				"motorist_code" => $motorist_code,
				"motorist_name" => $motorist_name,
				"motorist_type" => $motorist_type,
				"day_visit" => $day_visit,
				"frequency" => $frequency,
				"customer_code" => $customer_code,
				"customer_name" => $customer_name,
				"channel_code" => $channel,
				"channel_name" => $channel_name,
				"place_status" => $place_status,
				"customer_status" => $customer_status,
				"address" => $address,
				"districts" => $district,
				"customer_contact" => $customer_contact,
				"latitude" => $latitude,
				"longitude" => $longitude,
				"status_latitude" => $status_latitude,
				"status_qr_code" => $status_qr_code,
				"urutan_motorist" => $urutan_motorist,
				"foto_toko" => $foto_toko,
				"loyalty_store" => $loyalty_store
				);		
				
				
				$data_update = array(
				"regional" => $distributor_regional,
				"area" => $distributor_area,
				"distributor_code" => $distributor_code,
				"distributor_name" => $distributor_name,
				"motorist_code" => $motorist_code,
				"motorist_name" => $motorist_name,
				"motorist_type" => $motorist_type,
				"day_visit" => $day_visit,
				"frequency" => $frequency,
				"customer_name" => $customer_name,
				"channel_code" => $channel,
				"channel_name" => $channel_name,
				"place_status" => $place_status,
				"customer_status" => $customer_status,
				"address" => $address,
				"districts" => $district,
				"customer_contact" => $customer_contact,
				"latitude" => $latitude,
				"longitude" => $longitude,
				"status_latitude" => $status_latitude,
				"status_qr_code" => $status_qr_code,
				"urutan_motorist" => $urutan_motorist,
				"foto_toko" => $foto_toko,
				"loyalty_store" => $loyalty_store
				);						
				
				$where = array(
					"customer_code" => $customer_code
				);
				//jika master data tidak kosong maka akan diisi		
					
				
				$check_store_exist = $this->model_store->getStore("WHERE distributor_code = '".$distributor_code."' AND customer_code = '".$customer_code."' ")->num_rows();
				if($check_store_exist>=1)
				{
					$this->model_store->UpdateData("store",$data_update,$where);
					
					}
				else
				{
					//Insert Data
					$this->model_store->insertData("store",$data_insert);
					
				}
						
				
					
			}
					
				
				
			}
				@unlink($inputFileName);
				$this->session->set_flashdata('message_success','Data imported successfully');
				redirect('store');
			
               
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
	
	
	
	
	public function exportStore()
	{
		ini_set('memory_limit', '-1');
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
			
		$date = date("m-d-Y");
		
		$search = isset($_GET['search']) ? $_GET['search'] : '';
		$store_name = isset($_GET['store_name']) ? $_GET['store_name'] : '';
		$regional = isset($_GET['regional']) ? $_GET['regional'] : '';
		$motorist_type = isset($_GET['motorist_type']) ? $_GET['motorist_type'] : '';
		$motorist_code = isset($_GET['motorist_code']) ? $_GET['motorist_code'] : '';
		$distributor = isset($_GET['distributor']) ? $_GET['distributor'] : '';
		$area = isset($_GET['area']) ? $_GET['area'] : '';
		$date_search = isset($_GET['date']) ? $_GET['date'] : '';
		
		
		
		
		
		
		if($date_search != '')
		{
			$tanggal_range_pecah = explode(" - ", $date_search);
			$tanggal_from = $tanggal_range_pecah[0];
			$tanggal_from = explode("/", $tanggal_from);
			$tanggal_from = $tanggal_from[2].'-'.$tanggal_from[0].'-'.$tanggal_from[1];
			
			$tanggal_to = $tanggal_range_pecah[1];
			$tanggal_to = explode("/", $tanggal_to);
			$tanggal_to = $tanggal_to[2].'-'.$tanggal_to[0].'-'.$tanggal_to[1];
			
			$this->db->where("store.customer_create_date BETWEEN '".$tanggal_from." 00:00:00' AND '".$tanggal_to." 23:59:59' "); 
		}
			
		$this->db->where("motorist.motorist_type in (".$ket.") ");
		if($user_role=="Ado")
		{
			
			$this->db->where("motorist.distributor_code = '".$code_role."' ");
		}
		else if($user_role=="Regional")
		{
		
			$this->db->where("regional = '".$code_role."' ");
				
		}
		
		if($store_name!="")
		{
			$this->db->where('customer_name LIKE "%'.$store_name.'%" ');
		}
		
		
		if($area!="")
		{
			$this->db->where('store.area in ('.$area.') ');
		}
		
		if($distributor!="")
		{
			
			$this->db->where('store.distributor_code in ('.$distributor.') ');
		}
		
		if($motorist_code!='')
		{
			$this->db->where("motorist.motorist_code = '".$motorist_code."' ");
		}
		
		if($user_role=="Administrator" || $user_role=="Regional")
		{
			if($distributor!='')
			{
				$this->db->where("motorist.distributor_code = '".$distributor."' ");
				
				}
		}
		
		
		if($regional!="")
		{
			$this->db->where('regional in ('.$regional.') ');
		}
		
		if($motorist_type!="")
		{
			$this->db->where('motorist.motorist_type in ('.$motorist_type.') ');
		}
		$this->db->like('customer_code', $search);
		$this->db->join('motorist', 'motorist.motorist_code = store.motorist_code AND motorist.distributor_code = store.distributor_code');
		$this->db->join('motorist_type', 'motorist_type.id_motorist_type = motorist.motorist_type');
		$this->db->join('master_loyalty', 'master_loyalty.id_loyalty = store.loyalty_store',"LEFT");
	    	
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
		$objPHPExcel->getActiveSheet()->getStyle('A1:S1')->applyFromArray(
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
		"Kelurahan" => "Kelurahan",
		"Contact Number" => "Contact Number",
		"Latitude" => "Longitude",
		"Longitude" => "Longitude",
		"QR Code Status" => "QR Code Status",
		"Foto Toko" => "Foto Toko",
		"Loyalty Store" => "Loyalty Store"
		
		
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
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $row, $data['customer_code']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $row, $data['motorist_code']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $row, $data['day_visit']);
			$type = PHPExcel_Cell_DataType::TYPE_STRING;
			$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(4, $row)->setValueExplicit($data['channel_code'], $type);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, $row, $data['frequency']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, $row, $data['customer_name']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, $row, $data['customer_contact']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8, $row, $data['customer_status']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9, $row, $data['place_status']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(10, $row, $data['address']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(11, $row, $data['districts']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(12, $row, $data['kelurahan']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(13, $row, $data['contact_number']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(14, $row, $data['latitude']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(15, $row, $data['longitude']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(16, $row, $data['status_qr_code']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(17, $row, $data['foto_toko']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(18, $row, $data['description']);
			
 
            $row++;
			$no++;
        }
		
	   $last_row = $row-1;
	   //Set Border
       $objPHPExcel->getActiveSheet()->getStyle("A1".":"."S".$last_row)->applyFromArray($BStyle);
	   $objPHPExcel->getActiveSheet()->getStyle("A1".":"."S".$last_row)->applyFromArray($styleAlign);
       $objPHPExcel->setActiveSheetIndex(0);
 
        $objWriter = IOFactory::createWriter($objPHPExcel, 'Excel5');
 		
		
	   // Sending headers to force the user to download the file
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Export-store-'.$date.'.xls"');
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
	
	
	
	
	
	
	
	public function exportFilterStore()
	{
		ini_set('memory_limit', '-1');
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
			
		$date = date("m-d-Y");
		
			$distributor = isset($_GET['distributor']) ? $_GET['distributor'] : '';
			$area = isset($_GET['area']) ? $_GET['area'] : '';
			$regional = isset($_GET['regional']) ? $_GET['regional'] : '';
			$motorist_type = isset($_GET['motorist_type']) ? $_GET['motorist_type'] : '';
			
			
			$channel = isset($_GET['channel']) ? $_GET['channel'] : '';
			
			$motorist = isset($_GET['motorist']) ? $_GET['motorist'] : '';
			
			$tahun = isset($_GET['tahun']) ? $_GET['tahun'] : '';
			
			
			$day = isset($_GET['day']) ? $_GET['day'] : '';
			
			
			$product = isset($_GET['product']) ? $_GET['product'] : '';
			
			$month = isset($_GET['month']) ? $_GET['month'] : '';
			$transaction_month = isset($_GET['transaction-month']) ? $_GET['transaction-month'] : '';
		
		
		$this->db->select(" * ,store.customer_code as customer_code_bayangan");
		if($distributor!="")
		{
			
			$this->db->where('store.distributor_code in ('.$distributor.') ');
		}
		
		
		if($regional!="")
		{
			$this->db->where('store.regional in ('.$regional.') ');
		}
		
		if($motorist_type!="")
		{
			$this->db->where('store.motorist_type in ('.$motorist_type.') ');
		}
		
		if($area!="")
		{
			$this->db->where('area in ('.$area.') ');
		}
		
		$this->db->where("store.motorist_type in (".$ket.") ");
		if($user_role=="Ado")
		{
			$this->db->where("store.distributor_code = '".$code_role."' ");
		}
		else if($user_role=="Regional")
		{
			$this->db->where("store.regional = '".$code_role."' ");
				
		}
		
		
		
		if($channel!="")
		{
			$this->db->where('channel_code in ('.$channel.') ');
		}
		
		if($day!="")
		{
			$this->db->where('day_visit in ('.$day.') ');
		}
		
		if($motorist!="")
		{
			$this->db->where('store.motorist_code in ('.$motorist.') ');
		}
		
		
		if($product!="")
		{
			$mo =	date('m');
			
			$year = date('y');
			if($tahun!='')
			{$year = $tahun;}
			if($month!="")
			{
				$this->db->join('product_orders', "store.customer_code = product_orders.customer_code AND  id_product in (".$product.") AND product_orders.date between '$year-$month-01 00:00:00' AND '$year-$month-31 00:00:00' ","LEFT");
			}
			else
			{
				$this->db->join('product_orders', "store.customer_code = product_orders.customer_code AND  id_product in (".$product.") AND product_orders.date between '$year-$mo-01 00:00:00' AND '$year-$mo-31 00:00:00' ","LEFT");
			}
				//yang transaksi
				if($transaction_month=="yes")
				{
				
					$this->db->where('product_orders.customer_code IS NOT NULL ');

				
				}
			// yang tidak transaksi
			else
			{
					//Range Bulan Diisi
					$this->db->where('product_orders.customer_code IS NULL ');
				
			}
			}
			
		
		$this->db->group_by('store.customer_code');
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
					'color' => array('rgb' => '62a8ea')
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
		"Loyalty Store" => "Loyalty Store"
		
		
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
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $row, $data['customer_code_bayangan']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $row, $data['motorist_code']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $row, $data['day_visit']);
			$type = PHPExcel_Cell_DataType::TYPE_STRING;
			$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(4, $row)->setValueExplicit($data['channel_code'], $type);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, $row, $data['frequency']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, $row, $data['customer_name']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, $row, $data['customer_contact']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8, $row, $data['customer_status']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9, $row, $data['place_status']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(10, $row, $data['address']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(11, $row, $data['districts']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(12, $row, $data['latitude']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(13, $row, $data['longitude']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(14, $row, $data['status_qr_code']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(15, $row, $data['foto_toko']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(16, $row, $data['loyalty_store']);
			
 
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
        header('Content-Disposition: attachment;filename="Export-filter-store-'.$date.'.xls"');
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
	
	
	
	
	public function exportOutletSTT()
	{
		ini_set('memory_limit', '-1');
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
			
		$date = date("m-d-Y");
			
			$year = isset($_GET['year']) ? $_GET['year'] : '';
			$search = isset($_GET['search']) ? $_GET['search'] : '';
			$store_name = isset($_GET['store_name']) ? $_GET['store_name'] : '';
			$regional = isset($_GET['regional']) ? $_GET['regional'] : '';
			$motorist_code = isset($_GET['motorist_code']) ? $_GET['motorist_code'] : '';
			$distributor = isset($_GET['distributor_code']) ? $_GET['distributor_code'] : '';
			
			
			$date = isset($_GET['date']) ? $_GET['date'] : '';
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
			
			$this->db->where("store.customer_create_date BETWEEN '".$tanggal_from." 00:00:00' AND '".$tanggal_to." 23:59:59' "); 
		}
		
		$this->db->where("motorist.motorist_type in (".$ket.") ");
		if($user_role=="Ado")
		{
			$this->db->where("motorist.distributor_code = '".$code_role."' ");
		}
		else if($user_role=="Regional")
		{
			$this->db->where("regional = '".$code_role."' ");
				
		}
		if($regional!="")
		{
			$this->db->where('regional in ('.$regional.') ');
		}
		
		if($store_name!="")
		{
			$this->db->where('customer_name LIKE "%'.$store_name.'%" ');
		}
		
		
		if($motorist_code!='')
		{
			$this->db->where("motorist.motorist_code = '".$motorist_code."' ");
		}
		
		
		if($user_role=="Administrator" || $user_role=="Regional")
		{
			if($distributor!='')
			{
				$this->db->where("store.distributor_code = '".$distributor."' ");
				
				}
		}
		if($motorist_type!="")
		{
			$this->db->where('motorist.motorist_type in ('.$motorist_type.') ');
		}
		$this->db->like('customer_code', $search);
		$this->db->join('motorist', 'motorist.motorist_code = store.motorist_code AND motorist.distributor_code = store.distributor_code');
		$this->db->join('motorist_type', 'motorist_type.id_motorist_type = motorist.motorist_type');
		$this->db->join('master_loyalty', 'master_loyalty.id_loyalty = store.loyalty_store',"LEFT");
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
			'color' => array('rgb' => 'ffffff'),
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
		
		
		
		
		//Set Backgroung Color Header
		$objPHPExcel->getActiveSheet()->getStyle('A1:T1')->applyFromArray(
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
		
		"Customer Name" => "Customer Name",
		"Customer Code" => "Customer Code",
		"Distributor Name" => "Distributor Name",
		"Distributor Code" => "Distributor Code",
		"Motorist Code" => "Motorist Code",
		"Motorist Name" => "Motorist Name",
		"Day Visit" => "Day Visit",
		"Frequency" => "Frequency"
		);
        $col = 0;
        foreach ($fields as $field)
        {
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, 1, $field);
            $col++;
        }
		
		

			if($year=='')
						{
						 $year = date('Y');
						}
			$months = array("January-01","February-02","March-03","April-04","May-05","June-06","July-07","August-08","September-09","October-10","November-11","December-12");
			foreach($months as $month) {
				$data_month = explode('-',$month);
				$bulan = $data_month[1];
				$nama_bulan = $data_month[0];
                     
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, 1, $nama_bulan.' '.$year);
				$col++;
						 
		 }
				
		
		
		
		
		

 
        // Fetching the table data
        $row = 2;
		$no = 1;
        foreach($query->result_array() as $data)
        {
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $row, $data['customer_name']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $row, $data['customer_code']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $row, $data['distributor_name']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $row, $data['distributor_code']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $row, $data['motorist_code']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, $row, $data['motorist_name']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, $row, $data['day_visit']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, $row, $data['frequency']);
			
			$col_bawah = 8;
			foreach($months as $month) {
			$data_month = explode('-',$month);
			$bulan = $data_month[1];
			$nama_bulan = $data_month[0];
			$tanggal_bulan_awal = $year.'-'.$bulan.'-01 00:00:00';
			$tanggal_bulan_akhir = $year.'-'.$bulan.'-31 23:59:59';
			$select_mtd_sales = $this->db->query("SELECT SUM(total_order) as total_order FROM orders WHERE customer_code = '".$data['customer_code']."' AND date BETWEEN '".$tanggal_bulan_awal."' AND '".$tanggal_bulan_akhir."' ")->result_array();
			if($select_mtd_sales[0]['total_order']=='')
			{$total_stt = 0;}
			else
			{$total_stt = $select_mtd_sales[0]['total_order'];
			}
			
			$type = PHPExcel_Cell_DataType::TYPE_STRING;
			$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col_bawah, $row)->setValueExplicit(number_format($total_stt, 0 , '' , '.' ), $type);
			
			
			
			$col_bawah++;
			}	
			
							
 
            $row++;
			$no++;
        }
		
	   $last_row = $row-1;
	   //Set Border
       $objPHPExcel->getActiveSheet()->getStyle("A1".":"."T".$last_row)->applyFromArray($BStyle);
	   $objPHPExcel->getActiveSheet()->getStyle("A1".":"."T".$last_row)->applyFromArray($styleAlign);
       $objPHPExcel->setActiveSheetIndex(0);
 
        $objWriter = IOFactory::createWriter($objPHPExcel, 'Excel5');
 		
		
	   // Sending headers to force the user to download the file
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Export-store-STT-'.$date.'.xls"');
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