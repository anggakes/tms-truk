<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {

	function __construct()  {
 		parent::__construct();
			
			$this->load->model('model_home');
			$this->load->model('model_account_master');
			$this->load->library('tank_auth');
			
	}
	
	
	public function normalization()
	{
		
			date_default_timezone_set('Asia/Jakarta');
			if ($this->tank_auth->is_logged_in()) {
			$user	= $this->tank_auth->get_username();
			$data_account = $this->model_account_master->getAccount("WHERE username = '".$user."' ")->result_array();
			$data_role = $this->model_account_master->getRole("WHERE id_role = '".$data_account[0]['user_access']."' ")->result_array();
			$user_role = $data_account[0]['user_type'];
			$code_role = $data_account[0]['code'];
			$name = $data_account[0]['name'];
			
			$data = array(
				'username' => $name
			);
			$comp = array(
				
				'title' => ' Index E-tools',
				'content' => $this->load->view('common/normalization',array('data_account'=>$data_account,'data'=>$data),true),
				'sidebar' => $this->html_sidebar()
			
			);
			
			$this->load->view("common/common",$comp);
			
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
			$name = $data_account[0]['name'];
			
			$data = array(
				'username' => $name
			);
			$comp = array(
				
				'title' => ' Index E-tools',
				'content' => $this->load->view('common/welcome',array('data_account'=>$data_account,'data'=>$data),true),
				'sidebar' => $this->html_sidebar()
			
			);
			
			$this->load->view("common/common",$comp);
			
		}
		else
		{
			redirect('/auth/login/');
			}
	}
	
	
	
	
	
	public function outletContributionTracking()
	{
		
			date_default_timezone_set('Asia/Jakarta');
			
			if ($this->tank_auth->is_logged_in()) {
			$user	= $this->tank_auth->get_username();
			$data_account = $this->model_account_master->getAccount("WHERE username = '".$user."' ")->result_array();
			$data_role = $this->model_account_master->getRole("WHERE id_role = '".$data_account[0]['user_access']."' ")->result_array();
			$user_role = $data_account[0]['user_type'];
			$code_role = $data_account[0]['code'];
			$name = $data_account[0]['name'];
			$date_now = date('Y-m-d');
			$search = isset($_GET['search']) ? $_GET['search'] : '';
			
			
			$jenis_motorist = isset($_GET['jenis_motorist']) ? $_GET['jenis_motorist'] : '';
			if(isset($_GET['jenis_motorist']))
			{
				$jenis_motorist = "'" . implode("','", $jenis_motorist) . "'";
			}
			
			$regional = isset($_GET['regional']) ? $_GET['regional'] : '';
			if(isset($_GET['regional']))
			{$regional = implode("','", $regional);}
			
			$product = isset($_GET['product']) ? $_GET['product'] : '';
			if(isset($_GET['product']))
			{$product = implode(",",$product);}
			
			
			
			
			$data_distributor = $this->model_home->getDistributor()->result_array();
			$data_product = $this->model_home->getProduct()->result_array();
			$data_regional = $this->model_home->getRegional()->result_array();
			$data_motorist_type = $this->model_home->getMotoristType()->result_array();
			$data_motorist = $this->model_home->getMotorist()->result_array();
			$data_area = $this->model_home->getArea()->result_array();
			$data_channel = $this->model_home->getChannel()->result();
			
			$data = array(
				'username' => $name
			);
			$comp = array(
				
				'title' => ' Index E-tools',
				'content' => $this->load->view('outlet-contribution-tracking',array('data'=>$data,'data_account'=>$data_account,'data_distributor'=>$data_distributor,'data_product'=>$data_product,'data_regional'=>$data_regional,'data_motorist_type'=>$data_motorist_type,'data_motorist'=>$data_motorist,'data_area'=>$data_area,'data_channel'=>$data_channel),true),
				'sidebar' => $this->html_sidebar()
			
			);
			
			$this->load->view("common/common",$comp);
			
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