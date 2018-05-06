<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Chart_motorist extends CI_Controller {

	function __construct()  {
 		parent::__construct();
			$this->load->library(array('PHPExcel','PHPExcel/IOFactory'));
			$this->load->model('model_account_master');
			$this->load->model('model_chart_motorist');
			$this->load->library('tank_auth');
			
	}
	
	
	
	public function callMotorist()
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
			$motorist = isset($_GET['motorist']) ? $_GET['motorist'] : '';
			if(isset($_GET['motorist']))
			{$motorist = "'" . implode("','", $motorist) . "'";}
			
			$product = isset($_GET['product']) ? $_GET['product'] : '';
			if(isset($_GET['product']))
			{$product_implode = implode(",",$product);}
			else
			{$product_implode = "";}
			
			
			$motorist_type = isset($_GET['motorist_type']) ? $_GET['motorist_type'] : '';
			if(isset($_GET['motorist_type']))
			{$motorist_type_implode = implode(",",$motorist_type);}
			else
			{
				
				$motorist_type_implode = $ket;
					
					
			}
					
			
			$data_chart = $this->model_chart_motorist->dataChannelChart($product,$motorist,$date,$code_role,$ket);
			
			
			
			$data_product = $this->model_chart_motorist->getProduct()->result_array();
			
			if($user_role=="Ado")
			{
				
					$data_motorist = $this->model_chart_motorist->getMotorist("WHERE distributor_code = '".$code_role."' AND motorist_type in (".$motorist_type_implode.") ")->result();
					$data_motorist_type = $this->model_chart_motorist->getMotoristType("where motorist_type not in (".$ket.") ")->result_array();
				
				
				
			}
			
			
			
			
			
		
			$comp = array(
				
				'title' => ' Call Performance Motorist',
				'content' => $this->load->view('call-chart-motorist',array('data_motorist_type'=>$data_motorist_type,'data_account'=>$data_account,'data_chart'=>$data_chart,'data_motorist'=>$data_motorist,'data_product'=>$data_product),true),
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
			
			$date = isset($_GET['date']) ? $_GET['date'] : '';
			
			$motorist = isset($_GET['motorist']) ? $_GET['motorist'] : '';
			if(isset($_GET['motorist']))
			{$motorist = "'" . implode("','", $motorist) . "'";}
			
			$product = isset($_GET['product']) ? $_GET['product'] : '';
			if(isset($_GET['product']))
			{$product_implode = implode(",",$product);}
			else
			{$product_implode = "";}
			
			$data_chart = $this->model_chart_motorist->dataChannelChart($product,$motorist,$date,$code_role,$ket);
			
			
			$data_motorist = $this->model_chart_motorist->getMotorist("WHERE distributor_code = '".$code_role."' ")->result_array();
			$data_product = $this->model_chart_motorist->getProduct()->result_array();
			
		
			$comp = array(
				
				'title' => ' Outlet Channel',
				'content' => $this->load->view('channel-oulet',array('data_account'=>$data_account,'data_chart'=>$data_chart,'data_motorist'=>$data_motorist,'data_product'=>$data_product),true),
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
	
	
	
	public function sttMotorist()
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
			
			$motorist = isset($_GET['motorist']) ? $_GET['motorist'] : '';
			if(isset($_GET['motorist']))
			{$motorist = "'" . implode("','", $motorist) . "'";}
			
			$product = isset($_GET['product']) ? $_GET['product'] : '';
			if(isset($_GET['product']))
			{$product_implode = implode(",",$product);}
			else
			{$product_implode = "";}
			
			
			$motorist_type = isset($_GET['motorist_type']) ? $_GET['motorist_type'] : '';
			if(isset($_GET['motorist_type']))
			{$motorist_type_implode = implode(",",$motorist_type);}
			else
			{
				
					$motorist_type_implode = $ket;
					
					
			}
			
			$data_chart = $this->model_chart_motorist->dataChannelChart($product,$motorist,$date,$code_role,$ket);
			
			
			
			$data_product = $this->model_chart_motorist->getProduct()->result_array();
			
			if($user_role=="Ado")
			{
			
					$data_motorist = $this->model_chart_motorist->getMotorist("WHERE distributor_code = '".$code_role."' AND motorist_type in (".$ket.") ")->result();
					$data_motorist_type = $this->model_chart_motorist->getMotoristType("where id_motorist_type not in (".$ket.") ")->result_array();
				
				
				
			}
			
			
			
		
			$comp = array(
				
				'title' => ' STT Performance Motorist',
				'content' => $this->load->view('stt-motorist',array('data_motorist_type'=>$data_motorist_type,'data_account'=>$data_account,'data_chart'=>$data_chart,'data_motorist'=>$data_motorist,'data_product'=>$data_product),true),
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
	
	
	
	
	public function outletActive()
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
			
			$motorist = isset($_GET['motorist']) ? $_GET['motorist'] : '';
			if(isset($_GET['motorist']))
			{$motorist = "'" . implode("','", $motorist) . "'";}
			
			$product = isset($_GET['product']) ? $_GET['product'] : '';
			if(isset($_GET['product']))
			{$product_implode = implode(",",$product);}
			else
			{$product_implode = "";}
			
			$data_chart = $this->model_chart_motorist->dataChannelChart($product,$motorist,$date,$code_role,$ket);
			
			
			$data_motorist = $this->model_chart_motorist->getMotorist("WHERE distributor_code = '".$code_role."' ")->result_array();
			$data_product = $this->model_chart_motorist->getProduct()->result_array();
			$data_channel = $this->model_chart_motorist->getChannel()->result_array();
			
		
			$comp = array(
				'title' => ' Outlet Active Vs Register Outlet',
				'content' => $this->load->view('active-oulet',array('data_channel'=>$data_channel,'data_account'=>$data_account,'data_chart'=>$data_chart,'data_motorist'=>$data_motorist,'data_product'=>$data_product),true),
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