<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Noo extends CI_Controller {

	function __construct()  {
 		parent::__construct();
			$this->load->library(array('PHPExcel','PHPExcel/IOFactory'));
			$this->load->model('model_account_master');
			$this->load->model('model_noo');
			$this->load->library('tank_auth');
			
	}
	
	
	
	public function detailStore($id_store)
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

			$check_store = $this->model_noo->getStore("WHERE id_store = '".$id_store."' ");
			if($check_store->num_rows() >=1)
			{
						
			$data_store = $this->model_noo->detailStore($id_store);
			
			
			$history_order = $this->db->query("SELECT * FROM orders WHERE customer_code  = '".$data_store[0]['customer_code']."' ")->result();
				
		
		
			
			
		
			
			
					$comp = array(
						
						'title' => ' Detail Store',
						'content' => $this->load->view('detail-store',array('data'=>$data_store,'data_history_order'=>$history_order),true),
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
			'content' => $this->load->view('accessdenied',array('data'=>$data_store,'data_history_order'=>$history_order),true),
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
			$ket = $data_account[0]['ket'];
			
			if($data_role[0]['see_store']=='yes')
			{	
			
			$this->load->library('table');
			$this->load->library('pagination');
			$search = isset($_GET['search']) ? $_GET['search'] : '';
			$date = isset($_GET['date']) ? $_GET['date'] : '';
			$regional = isset($_GET['regional']) ? $_GET['regional'] : '';
			$distributor = isset($_GET['distributor_code']) ? $_GET['distributor_code'] : '';

			if(isset($_GET['regional']))
			{
				$regional = "'" . implode("','", $regional) . "'";
			}
			
			$motorist_type = isset($_GET['motorist_type']) ? $_GET['motorist_type'] : '';
			if(isset($_GET['motorist_type']))
			{$motorist_type = implode(",",$motorist_type);}
			if (count($_GET) > 0) $config['suffix'] = '?' . http_build_query($_GET, '', "&");
			
			$jumlah= $this->model_noo->countNoo($search,$user_role,$code_role,$ket,$date,$regional,$motorist_type,$distributor);
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
			$data = $this->model_noo->dataNoo($config['per_page'],$dari,$search,$user_role,$code_role,$ket,$date,$regional,$motorist_type,$distributor);
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
			
			if($data_role[0]['add_product']=='yes')
			{
				
			$this->load->helper('form');
			$this->load->helper('url');
			$this->load->library('form_validation');
			
			$this->form_validation->set_rules('id_store','ID Store','required');
			$this->form_validation->set_rules('day_visit','Day Visit','required');
			$this->form_validation->set_rules('channel','Channel','required');
			$this->form_validation->set_rules('frequency','Frequency','required');
			$this->form_validation->set_rules('customer_name','Customer Name','required');
			$this->form_validation->set_rules('customer_status','Customer Status','required');
			$this->form_validation->set_rules('place_status','Place Status','required');
			$this->form_validation->set_rules('address','Address','required');
			$this->form_validation->set_rules('status_qr_code','QR Code Status','required');
			
			if($this->form_validation->run()==FALSE){
			
			$check_store = $this->model_store->getStore("WHERE id_store = '".$id_store."' ");
			if($check_store->num_rows() >=1)
			{	
			
			$data_distributor = $this->model_store->getDistributor()->result_array();
			$data_store = $check_store->result_array();
			$data_motorist = $this->model_store->getMotorist()->result();
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
				$customer_name = $_POST['customer_name'];
				$customer_contact = $_POST['customer_contact'];
				$customer_status= strtolower($_POST['customer_status']);
				$place_status = strtolower($_POST['place_status']);
				$address = $_POST['address'];
				$district = $_POST['district'];
				$latitude = $_POST['latitude'];
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
				
				
				
				$data_update = array(
				
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
						
						'title' => ' Detail Noo',
						'content' => $this->load->view('delete-store',$data,true),
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
	
	
	
	
	public function detailNoo($id_noo)
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
			
			
			
			$check_store = $this->model_noo->getNoo("WHERE id_noo = '".$id_noo."' ");
			if($check_store->num_rows() >=1)
			{	
			$data_store = $check_store->result_array();	
		
			$data = array (
				"id_noo" => $data_store[0]['id_noo'],
				"distributor_code" => $data_store[0]['distributor_code'],
				"distributor_name" => $data_store[0]['distributor_name'],
				"motorist_code" => $data_store[0]['motorist_code'],
				"motorist_name" => $data_store[0]['motorist_name'],
				"day_visit" => $data_store[0]['day_visit'],
				"frequency" => $data_store[0]['frequency'],
				"customer_name" => $data_store[0]['customer_name'],
				"channel_code" => $data_store[0]['channel_code'],
				"channel_name" => $data_store[0]['channel_name'],
				"place_status" => $data_store[0]['place_status'],
				"address" => $data_store[0]['address'],
				"product" => $data_store[0]['product'],
				"districts" => $data_store[0]['districts'],
				"customer_contact" => $data_store[0]['customer_contact'],
				"latitude" => $data_store[0]['latitude'],
				"longitude" => $data_store[0]['longitude'],
				"foto_toko" => $data_store[0]['foto_toko'],
				"foto_produk" => $data_store[0]['foto_produk']
			);
			
			
		
			
			
					$comp = array(
						
						'title' => ' Detail Noo',
						'content' => $this->load->view('detail-noo',$data,true),
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
	
	
	public function importStore()
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
			$config['max_size']		= 100000000;

			$this->load->library('upload');
			$this->upload->initialize($config);

			if(! $this->upload->do_upload('import') )
			{
				$this->session->set_flashdata('message_failed','Import Failed, Please upload file excel extension!');
				redirect('storel');
				
				
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
				
				
				$address = str_replace(" ", "-", $address);
				$district = str_replace(" ", "", $district);
				
				//Give Status latitude 
				
				if($latitude!="" && $longitude!="")
				{$status_latitude = "Yes";}
				else
				{$status_latitude = "No";}
				
				
				$data_motorist = $this->model_store->getMotorist("WHERE motorist_code = '".$motorist_code."' ")->result_array();
				$motorist_name = $data_motorist[0]['motorist_name'];
				$distributor_code = $data_motorist[0]['distributor_code'];
				
				//Get Distributor
				$data_distributor = $this->model_store->getDistributor("WHERE distributor_code = '".$distributor_code."' ")->result_array();
				$distributor_name = $data_distributor[0]['distributor_name'];
				
				
				//Get Channel
				$data_channel = $this->model_store->getChannel("WHERE classification_code LIKE '%".$channel."%' ")->result_array();
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
				"status_qr_code" => $status_qr_code
				);		
				
				
				$data_update = array(
				"distributor_code" => $distributor_code,
				"distributor_name" => $distributor_name,
				"motorist_code" => $motorist_code,
				"motorist_name" => $motorist_name,
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
				"status_qr_code" => $status_qr_code
				);						
				
				$where = array(
					"customer_code" => $customer_code
				);
				//jika master data tidak kosong maka akan diisi		
					
				
				$check_store_exist = $this->model_store->getStore("WHERE motorist_code = '".$motorist_code."' AND customer_code = '".$customer_code."' ")->num_rows();
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
	
	
	
	
	public function exportNoo()
	{
		ini_set('memory_limit', '-1');
		date_default_timezone_set('Asia/Jakarta');
		if ($this->tank_auth->is_logged_in()) {
		$user	= $this->tank_auth->get_username();
			
		$data_account = $this->model_account_master->getAccount("WHERE username = '".$user."' ")->result_array();
		$data_role = $this->model_account_master->getRole("WHERE id_role = '".$data_account[0]['user_access']."' ")->result_array();
		
		$search = isset($_GET['search']) ? $_GET['search'] : '';
		$date_seacrh = isset($_GET['date']) ? $_GET['date'] : '';
			
		
		$user_role = $data_account[0]['user_type'];
			$code_role = $data_account[0]['code'];
			$ket = $data_account[0]['ket'];
		if($data_role[0]['see_store']=='yes')
		{
			
		$date_now = date("m-d-Y");
		
		
		$search = isset($_GET['search']) ? $_GET['search'] : '';
		$date = isset($_GET['date']) ? $_GET['date'] : '';
		$regional = isset($_GET['regional']) ? $_GET['regional'] : '';
		$distributor = isset($_GET['distributor_code']) ? $_GET['distributor_code'] : '';
		$motorist_type = isset($_GET['motorist_type']) ? $_GET['motorist_type'] : '';
		
		
		
		if($user_role=="Administrator" || $user_role=="Regional")
		{
			if($distributor!='')
			{
				$this->db->where("motorist.distributor_code = '".$distributor."' ");
				
				}
		}
		
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
			
			if($ket=="sergap")
			{$this->db->where("motorist.motorist_type in (3,4) ");}
		    else
			{
			$this->db->where("motorist.motorist_type in (1,2) ");
			}

			$this->db->where('noo.distributor_code = "'.$code_role.'" ');
		}
		else if($user_role=="Regional")
		{
			if($ket=="sergap")
			{$this->db->where("motorist.motorist_type in (3,4) ");}
		    else
			{
			$this->db->where("motorist.motorist_type in (1,2) ");
			}
			$this->db->where("distributor.regional = '".$code_role."' ");
				
		}
		$this->db->like('noo.motorist_code', $search);
		$this->db->join('motorist', 'motorist.motorist_code = noo.motorist_code AND motorist.distributor_code = noo.distributor_code  ');
		$this->db->join('distributor', 'distributor.distributor_code = noo.distributor_code');
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