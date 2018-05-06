<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Chart_admin extends CI_Controller {

	function __construct()  {
 		parent::__construct();
			$this->load->library(array('PHPExcel','PHPExcel/IOFactory'));
			$this->load->model('model_account_master');
			$this->load->model('model_chart_admin');
			$this->load->library('tank_auth');
			
	}
	
	public function brandContribution()
	{
		
			date_default_timezone_set('Asia/Jakarta');
			
			if ($this->tank_auth->is_logged_in()) {
			$user	= $this->tank_auth->get_username();
			$data_account = $this->model_account_master->getAccount("WHERE username = '".$user."' ")->result_array();
			$data_role = $this->model_account_master->getRole("WHERE id_role = '".$data_account[0]['user_access']."' ")->result_array();
			$user_role = $data_account[0]['user_type'];
			$code_role = $data_account[0]['code'];
			$ket = $data_account[0]['ket'];
			
			if($data_role[0]['see_motorist']=='yes')
			{	
		
			$data_motorist_type = $this->model_chart_admin->getMotoristType()->result_array();
			$data_product = $this->model_chart_admin->getProduct()->result_array();
			$data_regional = $this->model_chart_admin->getRegional()->result_array();
			$data_area = $this->model_chart_admin->getArea()->result_array();
			$data_distributor = $this->model_chart_admin->getDistributor()->result_array();
			$data_channel = $this->model_chart_admin->getChannel()->result_array();
			
		
			$comp = array(
				
				'title' => ' Brand Contribution',
				'content' => $this->load->view('brand-contribution',array('data_channel'=>$data_channel,'data_account'=>$data_account,'data_distributor'=>$data_distributor,'data_motorist_type'=>$data_motorist_type,'data_area'=>$data_area,'data_regional'=>$data_regional,'data_product'=>$data_product),true),
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
	
	
	public function sttAchievement()
	{
		
			date_default_timezone_set('Asia/Jakarta');
			
			if ($this->tank_auth->is_logged_in()) {
			$user	= $this->tank_auth->get_username();
			$data_account = $this->model_account_master->getAccount("WHERE username = '".$user."' ")->result_array();
			$data_role = $this->model_account_master->getRole("WHERE id_role = '".$data_account[0]['user_access']."' ")->result_array();
			$user_role = $data_account[0]['user_type'];
			$code_role = $data_account[0]['code'];
			$ket = $data_account[0]['ket'];
			
			if($data_role[0]['see_motorist']=='yes')
			{	
		
			$data_motorist_type = $this->model_chart_admin->getMotoristType()->result_array();
			$data_product = $this->model_chart_admin->getProduct()->result_array();
			$data_regional = $this->model_chart_admin->getRegional()->result_array();
			$data_area = $this->model_chart_admin->getArea()->result_array();
			$data_distributor = $this->model_chart_admin->getDistributor()->result_array();
			$data_channel = $this->model_chart_admin->getChannel()->result_array();
			
		
			$comp = array(
				
				'title' => ' STT Achievement',
				'content' => $this->load->view('stt-achievement',array('data_channel'=>$data_channel,'data_account'=>$data_account,'data_distributor'=>$data_distributor,'data_motorist_type'=>$data_motorist_type,'data_area'=>$data_area,'data_regional'=>$data_regional,'data_product'=>$data_product),true),
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
	
	
	
	public function motoristPerformanceStt()
	{
		
			date_default_timezone_set('Asia/Jakarta');
			
			if ($this->tank_auth->is_logged_in()) {
			$user	= $this->tank_auth->get_username();
			$data_account = $this->model_account_master->getAccount("WHERE username = '".$user."' ")->result_array();
			$data_role = $this->model_account_master->getRole("WHERE id_role = '".$data_account[0]['user_access']."' ")->result_array();
			$user_role = $data_account[0]['user_type'];
			$code_role = $data_account[0]['code'];
			$ket = $data_account[0]['ket'];
			
			if($data_role[0]['see_motorist']=='yes')
			{	
		
			$data_motorist_type = $this->model_chart_admin->getMotoristType()->result_array();
			$data_product = $this->model_chart_admin->getProduct()->result_array();
			$data_regional = $this->model_chart_admin->getRegional()->result_array();
			$data_area = $this->model_chart_admin->getArea()->result_array();
			$data_distributor = $this->model_chart_admin->getDistributor()->result_array();
			$data_channel = $this->model_chart_admin->getChannel()->result_array();
			
		
			$comp = array(
				
				'title' => ' motorist Performance STT',
				'content' => $this->load->view('motorist-performance-stt',array('data_channel'=>$data_channel,'data_account'=>$data_account,'data_distributor'=>$data_distributor,'data_motorist_type'=>$data_motorist_type,'data_area'=>$data_area,'data_regional'=>$data_regional,'data_product'=>$data_product),true),
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
	
	
	
	
	
	public function motoristPerformanceTracking()
	{
		
			date_default_timezone_set('Asia/Jakarta');
			
			if ($this->tank_auth->is_logged_in()) {
			$user	= $this->tank_auth->get_username();
			$data_account = $this->model_account_master->getAccount("WHERE username = '".$user."' ")->result_array();
			$data_role = $this->model_account_master->getRole("WHERE id_role = '".$data_account[0]['user_access']."' ")->result_array();
			$user_role = $data_account[0]['user_type'];
			$code_role = $data_account[0]['code'];
			$ket = $data_account[0]['ket'];
			
			if($data_role[0]['see_motorist']=='yes')
			{	
		
			$data_motorist_type = $this->model_chart_admin->getMotoristType()->result_array();
			$data_product = $this->model_chart_admin->getProduct()->result_array();
			$data_regional = $this->model_chart_admin->getRegional()->result_array();
			$data_area = $this->model_chart_admin->getArea()->result_array();
			$data_distributor = $this->model_chart_admin->getDistributor()->result_array();
			$data_channel = $this->model_chart_admin->getChannel()->result_array();
			
		
			$comp = array(
				
				'title' => ' motorist Performance Tracking',
				'content' => $this->load->view('motorist-performance-tracking',array('data_channel'=>$data_channel,'data_account'=>$data_account,'data_distributor'=>$data_distributor,'data_motorist_type'=>$data_motorist_type,'data_area'=>$data_area,'data_regional'=>$data_regional,'data_product'=>$data_product),true),
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
	
	
	public function loyaltyProgram()
	{
		
			date_default_timezone_set('Asia/Jakarta');
			
			if ($this->tank_auth->is_logged_in()) {
			$user	= $this->tank_auth->get_username();
			$data_account = $this->model_account_master->getAccount("WHERE username = '".$user."' ")->result_array();
			$data_role = $this->model_account_master->getRole("WHERE id_role = '".$data_account[0]['user_access']."' ")->result_array();
			$user_role = $data_account[0]['user_type'];
			$code_role = $data_account[0]['code'];
			$ket = $data_account[0]['ket'];
			
			if($data_role[0]['see_motorist']=='yes')
			{	
		
			$data_motorist_type = $this->model_chart_admin->getMotoristType()->result_array();
			$data_product = $this->model_chart_admin->getProduct()->result_array();
			$data_regional = $this->model_chart_admin->getRegional()->result_array();
			$data_area = $this->model_chart_admin->getArea()->result_array();
			$data_distributor = $this->model_chart_admin->getDistributor()->result_array();
			$data_channel = $this->model_chart_admin->getChannel()->result_array();
			
		
			$comp = array(
				
				'title' => ' Loyalty Program',
				'content' => $this->load->view('loyalty-program',array('data_channel'=>$data_channel,'data_account'=>$data_account,'data_distributor'=>$data_distributor,'data_motorist_type'=>$data_motorist_type,'data_area'=>$data_area,'data_regional'=>$data_regional,'data_product'=>$data_product),true),
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
	
	
	public function registerOutlet()
	{
		
			date_default_timezone_set('Asia/Jakarta');
			
			if ($this->tank_auth->is_logged_in()) {
			$user	= $this->tank_auth->get_username();
			$data_account = $this->model_account_master->getAccount("WHERE username = '".$user."' ")->result_array();
			$data_role = $this->model_account_master->getRole("WHERE id_role = '".$data_account[0]['user_access']."' ")->result_array();
			$user_role = $data_account[0]['user_type'];
			$code_role = $data_account[0]['code'];
			$ket = $data_account[0]['ket'];
			
			if($data_role[0]['see_motorist']=='yes')
			{	
		
			$data_motorist_type = $this->model_chart_admin->getMotoristType()->result_array();
			$data_product = $this->model_chart_admin->getProduct()->result_array();
			$data_regional = $this->model_chart_admin->getRegional()->result_array();
			$data_area = $this->model_chart_admin->getArea()->result_array();
			$data_distributor = $this->model_chart_admin->getDistributor()->result_array();
			$data_channel = $this->model_chart_admin->getChannel()->result_array();
			
		
			$comp = array(
				
				'title' => ' Register Outlet Vs Active Outlet',
				'content' => $this->load->view('register-outlet-admin',array('data_channel'=>$data_channel,'data_account'=>$data_account,'data_distributor'=>$data_distributor,'data_motorist_type'=>$data_motorist_type,'data_area'=>$data_area,'data_regional'=>$data_regional,'data_product'=>$data_product),true),
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
			$ket = $data_account[0]['ket'];
			
			if($data_role[0]['see_motorist']=='yes')
			{	
		
			$data_motorist_type = $this->model_chart_admin->getMotoristType()->result_array();
			$data_product = $this->model_chart_admin->getProduct()->result_array();
			$data_regional = $this->model_chart_admin->getRegional()->result_array();
			$data_area = $this->model_chart_admin->getArea()->result_array();
			$data_distributor = $this->model_chart_admin->getDistributor()->result_array();
			
		
			$comp = array(
				
				'title' => ' Outlet Contribution Tracking',
				'content' => $this->load->view('outlet-contribution',array('data_account'=>$data_account,'data_distributor'=>$data_distributor,'data_motorist_type'=>$data_motorist_type,'data_area'=>$data_area,'data_regional'=>$data_regional,'data_product'=>$data_product),true),
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