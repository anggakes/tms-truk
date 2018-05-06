<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Accounting_report extends CI_Controller {

	function __construct()  {
 		parent::__construct();
			$this->load->library(array('PHPExcel','PHPExcel/IOFactory'));
			$this->load->model('model_account_master');
			$this->load->model('model_pod');
			$this->load->library('tank_auth');
			
	}
	
	
	
	

	
	
	
	
	
	
	
	
	public function reportDetailPayslipDeductionsSummary()
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
				'content' => $this->load->view('reportDetailPayslipDeductionsSummary',array('data_account'=>$data_account,'data'=>$data),true),
				'sidebar' => $this->html_sidebar()
			
			);
			
			$this->load->view("common/common",$comp);
			
		}
		else
		{
			redirect('/auth/login/');
			}
	}
	
	public function reportDetailPayslipEarningsSummary()
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
				'content' => $this->load->view('reportDetailPayslipEarningsSummary',array('data_account'=>$data_account,'data'=>$data),true),
				'sidebar' => $this->html_sidebar()
			
			);
			
			$this->load->view("common/common",$comp);
			
		}
		else
		{
			redirect('/auth/login/');
			}
	}
	
	public function reportDetailPayslipSummary()
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
				'content' => $this->load->view('reportDetailPayslipSummary',array('data_account'=>$data_account,'data'=>$data),true),
				'sidebar' => $this->html_sidebar()
			
			);
			
			$this->load->view("common/common",$comp);
			
		}
		else
		{
			redirect('/auth/login/');
			}
	}
	
	public function reportDetailFixedAssetSummary()
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
				'content' => $this->load->view('reportDetailFixedAssetSummary',array('data_account'=>$data_account,'data'=>$data),true),
				'sidebar' => $this->html_sidebar()
			
			);
			
			$this->load->view("common/common",$comp);
			
		}
		else
		{
			redirect('/auth/login/');
			}
	}
	
	public function reportDetailExpenseClaimsSummary()
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
				'content' => $this->load->view('reportDetailExpenseClaimsSummary',array('data_account'=>$data_account,'data'=>$data),true),
				'sidebar' => $this->html_sidebar()
			
			);
			
			$this->load->view("common/common",$comp);
			
		}
		else
		{
			redirect('/auth/login/');
			}
	}
	
	public function reportDetailSalesInvoiceTotalbyItem()
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
				'content' => $this->load->view('reportDetailSalesInvoiceTotalbyItem',array('data_account'=>$data_account,'data'=>$data),true),
				'sidebar' => $this->html_sidebar()
			
			);
			
			$this->load->view("common/common",$comp);
			
		}
		else
		{
			redirect('/auth/login/');
			}
	}
	
	public function reportDetailSalesInvoiceTotalbyCustomer()
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
				'content' => $this->load->view('reportDetailSalesInvoiceTotalbyCustomer',array('data_account'=>$data_account,'data'=>$data),true),
				'sidebar' => $this->html_sidebar()
			
			);
			
			$this->load->view("common/common",$comp);
			
		}
		else
		{
			redirect('/auth/login/');
			}
	}
	
	
	public function reportDetailAgedPayables()
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
				'content' => $this->load->view('reportDetailAgedPayables',array('data_account'=>$data_account,'data'=>$data),true),
				'sidebar' => $this->html_sidebar()
			
			);
			
			$this->load->view("common/common",$comp);
			
		}
		else
		{
			redirect('/auth/login/');
			}
	}
	public function reportDetailCustomerStatement()
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
				'content' => $this->load->view('reportDetailCustomerStatement',array('data_account'=>$data_account,'data'=>$data),true),
				'sidebar' => $this->html_sidebar()
			
			);
			
			$this->load->view("common/common",$comp);
			
		}
		else
		{
			redirect('/auth/login/');
			}
	}
	
	public function reportDetailAgedReceivable()
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
				'content' => $this->load->view('reportDetailAgedReceivable',array('data_account'=>$data_account,'data'=>$data),true),
				'sidebar' => $this->html_sidebar()
			
			);
			
			$this->load->view("common/common",$comp);
			
		}
		else
		{
			redirect('/auth/login/');
			}
	}
	
	
	public function reportDetailTaxTransactions()
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
				'content' => $this->load->view('reportDetailTaxTransactions',array('data_account'=>$data_account,'data'=>$data),true),
				'sidebar' => $this->html_sidebar()
			
			);
			
			$this->load->view("common/common",$comp);
			
		}
		else
		{
			redirect('/auth/login/');
			}
	}
	
	public function reportDetailTaxReconciliation()
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
				'content' => $this->load->view('reportDetailTaxReconciliation',array('data_account'=>$data_account,'data'=>$data),true),
				'sidebar' => $this->html_sidebar()
			
			);
			
			$this->load->view("common/common",$comp);
			
		}
		else
		{
			redirect('/auth/login/');
			}
	}
	
	public function reportDetailTaxSummary()
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
				'content' => $this->load->view('reportDetailTaxSummary',array('data_account'=>$data_account,'data'=>$data),true),
				'sidebar' => $this->html_sidebar()
			
			);
			
			$this->load->view("common/common",$comp);
			
		}
		else
		{
			redirect('/auth/login/');
			}
	}
	
	
	public function reportDetailStartingBalance()
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
				'content' => $this->load->view('reportDetailStartingBalance',array('data_account'=>$data_account,'data'=>$data),true),
				'sidebar' => $this->html_sidebar()
			
			);
			
			$this->load->view("common/common",$comp);
			
		}
		else
		{
			redirect('/auth/login/');
			}
	}
	
	public function reportDetailGeneralLedgerSummary()
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
				'content' => $this->load->view('reportDetailGeneralLedgerSummary',array('data_account'=>$data_account,'data'=>$data),true),
				'sidebar' => $this->html_sidebar()
			
			);
			
			$this->load->view("common/common",$comp);
			
		}
		else
		{
			redirect('/auth/login/');
			}
	}
	
	
	public function reportDetailTrialBalance()
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
				'content' => $this->load->view('reportDetailTrialBalance',array('data_account'=>$data_account,'data'=>$data),true),
				'sidebar' => $this->html_sidebar()
			
			);
			
			$this->load->view("common/common",$comp);
			
		}
		else
		{
			redirect('/auth/login/');
			}
	}
	public function reportDetailCashSummary()
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
				'content' => $this->load->view('reportDetailCashSummary',array('data_account'=>$data_account,'data'=>$data),true),
				'sidebar' => $this->html_sidebar()
			
			);
			
			$this->load->view("common/common",$comp);
			
		}
		else
		{
			redirect('/auth/login/');
			}
	}
	
	
	public function reportDetailStatementofChangesinEquity()
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
				'content' => $this->load->view('reportDetailStatementofChangesinEquity',array('data_account'=>$data_account,'data'=>$data),true),
				'sidebar' => $this->html_sidebar()
			
			);
			
			$this->load->view("common/common",$comp);
			
		}
		else
		{
			redirect('/auth/login/');
			}
	}
	
	public function reportDetailBalanceSheet()
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
				'content' => $this->load->view('reportDetailBalanceSheet',array('data_account'=>$data_account,'data'=>$data),true),
				'sidebar' => $this->html_sidebar()
			
			);
			
			$this->load->view("common/common",$comp);
			
		}
		else
		{
			redirect('/auth/login/');
			}
	}
	
	
	public function reportDetailProfitandLossStatementActualvsBudget()
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
				'content' => $this->load->view('reportDetailProfitandLossStatementActualvsBudget',array('data_account'=>$data_account,'data'=>$data),true),
				'sidebar' => $this->html_sidebar()
			
			);
			
			$this->load->view("common/common",$comp);
			
		}
		else
		{
			redirect('/auth/login/');
			}
	}
	public function reportDetailProfitandLossStatement()
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
				'content' => $this->load->view('reportDetailProfitandLossStatement',array('data_account'=>$data_account,'data'=>$data),true),
				'sidebar' => $this->html_sidebar()
			
			);
			
			$this->load->view("common/common",$comp);
			
		}
		else
		{
			redirect('/auth/login/');
			}
	}
	
	
	
	public function profit_and_lost_statement()
	{
		
			date_default_timezone_set('Asia/Jakarta');
			if ($this->tank_auth->is_logged_in()) {
			$user	= $this->tank_auth->get_username();
			$data_account = $this->model_account_master->getAccount("WHERE username = '".$user."' ")->result_array();
			$data_role = $this->model_account_master->getRole("WHERE id_role = '".$data_account[0]['user_access']."' ")->result_array();
			$user_role = $data_account[0]['user_type'];
			$code_role = $data_account[0]['code'];
			$name = $data_account[0]['name'];
			
			
			$title = isset($_GET['title']) ? $_GET['title'] : '';
			$id = isset($_GET['id']) ? $_GET['id'] : '';

			$data = array(
				'username' => $name
			);
			$comp = array(
				
				'title' => $title,
				'content' => $this->load->view('profit_and_lost_statement',array('data_account'=>$data_account,'data'=>$data),true),
				'sidebar' => $this->html_sidebar()
			
			);
			
			$this->load->view("common/common",$comp);
			
		}
		else
		{
			redirect('/auth/login/');
			}
	}
	
	
	public function report()
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
				'content' => $this->load->view('acounting_report',array('data_account'=>$data_account,'data'=>$data),true),
				'sidebar' => $this->html_sidebar()
			
			);
			
			$this->load->view("common/common",$comp);
			
		}
		else
		{
			redirect('/auth/login/');
			}
	}
	
	
	public function truckMonitoring()
	{
		
			date_default_timezone_set('Asia/Jakarta');
			if ($this->tank_auth->is_logged_in()) {
			$user	= $this->tank_auth->get_username();
			$data_account = $this->model_account_master->getAccount("WHERE username = '".$user."' ")->result_array();
			$data_role = $this->model_account_master->getRole("WHERE id_role = '".$data_account[0]['user_access']."' ")->result_array();
			$user_role = $data_account[0]['user_type'];
			$code_role = $data_account[0]['code'];
			
			if($data_role[0]['see_pod']=='yes')
			{	
			$this->load->library('table');
			$this->load->library('pagination');
			$search = isset($_GET['search']) ? $_GET['search'] : '';
			
			
			$jumlah= $this->model_pod->countPod($search);
			
			if (count($_GET) > 0) $config['suffix'] = '?' . http_build_query($_GET, '', "&");
			$config['base_url'] = base_url().'index.php/pod/pod/';
			$config['total_rows'] = $jumlah;
			$config['first_link'] = 'First';
			$config['last_link'] = 'End';
			$config['next_link'] = 'Next';
			$config['prev_link'] = 'Previous';
			$config['per_page'] = 5; 	
			if (count($_GET) > 0) $config['suffix'] = '?' . http_build_query($_GET, '', "&");
			$config['first_url'] = $config['base_url'].'?'.http_build_query($_GET);
			
			$dari = $this->uri->segment('3');
			$data = $this->model_pod->dataPod($config['per_page'],$dari,$search);
			
		
			$comp = array(
				'title' => ' Truck Monitoring',
				'content' => $this->load->view('truck_monitoring',array('data_pod'=>$data,'data_role'=>$data_role,'search'=>$search),true),
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
	
	
	public function editPOD()
	{
		
			date_default_timezone_set('Asia/Jakarta');
			ini_set('memory_limit', '-1');
			
			if ($this->tank_auth->is_logged_in()) {
			$user	= $this->tank_auth->get_username();
			$data_account = $this->model_account_master->getAccount("WHERE username = '".$user."' ")->result_array();
			$data_role = $this->model_account_master->getRole("WHERE id_role = '".$data_account[0]['user_access']."' ")->result_array();
			$user_role = $data_account[0]['user_type'];
			$code_role = $data_account[0]['code'];
			
			if($data_role[0]['edit_pod']=='yes')
			{
				
			
				// Get Variable Post
				$pod_code = $_POST['edit_pod_code'];
				$pod = $_POST['edit_pod'];
				$pod_confirmed = $_POST['edit_confirmation'];
				$spk_number_update = $_POST['spk_number_update'];
				
				$data_update = array(
				
					"pod_number" => $pod_code,
					"pod" => $pod,
					"pod_confirmed" => $pod_confirmed

				);
				
				$where = array("spk_number"=>$spk_number_update);
				
				
					
					$res = $this->model_pod->UpdateData("transport_order",$data_update,$where);
					
					if($res>=1)
					{
						$this->session->set_flashdata('message_success',"Data POD has been successfully updated!");
						
						redirect('pod');
						
						}
					else
					{
						$this->session->set_flashdata('message_failed',"Data POD failed to update!");
						redirect('pod');
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
	
	
	public function deleteDriverAll()
	{
		
			date_default_timezone_set('Asia/Jakarta');
			ini_set('memory_limit', '-1');
			
			if ($this->tank_auth->is_logged_in()) {
			$user	= $this->tank_auth->get_username();
			$data_account = $this->model_account_master->getAccount("WHERE username = '".$user."' ")->result_array();
			$data_role = $this->model_account_master->getRole("WHERE id_role = '".$data_account[0]['user_access']."' ")->result_array();
			$user_role = $data_account[0]['user_type'];
			$code_role = $data_account[0]['code'];
			if($data_role[0]['delete_pod']=='yes')
			{
				
			
				// Get Variable Post
				$id_pod_delete = $_POST['id_pod_delete_all'];
				
		
					//Update Product
					$res = $this->db->query("DELETE FROM pod WHERE id_pod in (".$id_pod_delete.") ");
					if($res>=1)
					{
						$this->session->set_flashdata('message_success',"Data pod has been successfully deleted!");
						redirect('pod');
						
						}
					else
					{
						$this->session->set_flashdata('message_failed',"Data Driver failed to delete!");
						redirect('pod');
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
	
	public function editDriver($id_channel)
	{
		
			date_default_timezone_set('Asia/Jakarta');
			ini_set('memory_limit', '-1');
			
			if ($this->tank_auth->is_logged_in()) {
			$user	= $this->tank_auth->get_username();
			$data_account = $this->model_account_master->getAccount("WHERE username = '".$user."' ")->result_array();
			$data_role = $this->model_account_master->getRole("WHERE id_role = '".$data_account[0]['user_access']."' ")->result_array();
			$user_role = $data_account[0]['user_type'];
			$code_role = $data_account[0]['code'];
			
			if($data_role[0]['edit_pod']=='yes')
			{
				
			
				// Get Variable Post
				$pod_code = $_POST['edit_pod_code'];
				$pod_name = $_POST['edit_pod_name'];
				$password = $_POST['edit_password1'];
				$id_pod = $_POST['id_pod_update'];
				
				$data_update_with_password = array(
				
				"pod_code" => $pod_code,
				"pod_name" => $pod_name,
				"password" => md5($password)

				);
				$data_update_without_password = array(
				
				"pod_code" => $pod_code,
				"pod_name" => $pod_name,

				);
				
				$where = array("id_pod"=>$id_pod);
				
				//Check Product Apakah sudah ada dengan kode produk dan type motorist yang sama
				$check = $this->model_pod->getDriver("WHERE pod_code = '".$pod_code."' AND id_pod != '".$id_pod."' ");
				
				
				if($check->num_rows() >=1 )
				{
					$this->session->set_flashdata('message_failed',"Sorry data already exist!");
					redirect('pod');
					
					}
				else
				{
				
					//Update
					if($password=='')
					{
					$res = $this->model_pod->UpdateData("pod",$data_update_without_password,$where);
					}
					else{$res = $this->model_pod->UpdateData("pod",$data_update_with_password,$where);}
					
					if($res>=1)
					{
						$this->session->set_flashdata('message_success',"Data Driver has been successfully updated!");
						
						redirect('pod');
						
						}
					else
					{
						$this->session->set_flashdata('message_failed',"Data Driver failed to update!");
						redirect('pod');
					}
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
	
	
	public function deleteDriver()
	{
		
			date_default_timezone_set('Asia/Jakarta');
			ini_set('memory_limit', '-1');
			
			if ($this->tank_auth->is_logged_in()) {
			$user	= $this->tank_auth->get_username();
			$data_account = $this->model_account_master->getAccount("WHERE username = '".$user."' ")->result_array();
			$data_role = $this->model_account_master->getRole("WHERE id_role = '".$data_account[0]['user_access']."' ")->result_array();
			$user_role = $data_account[0]['user_type'];
			$code_role = $data_account[0]['code'];
			if($data_role[0]['delete_pod']=='yes')
			{
				
			
				// Get Variable Post
				$id_pod_delete = $_POST['id_pod_delete'];
				$where = array("id_pod" => $id_pod_delete);
				
		
					//Update Product
					$res = $this->model_pod->DeleteData("pod",$where);
					if($res>=1)
					{
						$this->session->set_flashdata('message_success',"Data pod has been successfully deleted!");
						redirect('pod');
						
						}
					else
					{
						$this->session->set_flashdata('message_failed',"Data Driver failed to delete!");
						redirect('pod');
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
	
	public function exportDriver()
	{
		
		date_default_timezone_set('Asia/Jakarta');
		if ($this->tank_auth->is_logged_in()) {
		$user	= $this->tank_auth->get_username();
		$data_account = $this->model_account_master->getAccount("WHERE username = '".$user."' ")->result_array();
		$data_role = $this->model_account_master->getRole("WHERE id_role = '".$data_account[0]['user_access']."' ")->result_array();
		$user_role = $data_account[0]['user_type'];
		$code_role = $data_account[0]['code'];
		
		if($data_role[0]['export_pod']=='yes')
		{
		$search = isset($_GET['search']) ? $_GET['search'] : '';

		
		$date = date("m-d-Y");
		$this->db->or_like('pod_code', $search);
		$query = $this->db->get('pod');
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
		
		
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 1, "Master Driver");
		//Merge And Center Title
		$objPHPExcel->getActiveSheet()->mergeCells('A1:D1');
		
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 2, "Date : ".$date);
		
		//Merge And Center Date
		$objPHPExcel->getActiveSheet()->mergeCells('A2:D2');
		
		//Set Font Color Title
		$objPHPExcel->getActiveSheet()->getStyle('A1:D2')->applyFromArray($FontstyleTitle);
		
		//Set Font Color Header
		$objPHPExcel->getActiveSheet()->getStyle('A4:C4')->applyFromArray($Fontstyle);
		
		//Set Backgroung Color Header
		$objPHPExcel->getActiveSheet()->getStyle('A4:C4')->applyFromArray(
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
		
		"No" => "No",
		"Driver Code" => "Driver Code",
		"Driver Name" => "Driver Name"
		
		);
        $col = 0;
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
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $row, $no);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $row, $data['pod_code']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $row, $data['pod_name']);
 
            $row++;
			$no++;
        }
		
	   $last_row = $row-1;
	   //Set Border
       $objPHPExcel->getActiveSheet()->getStyle("A4".":"."C".$last_row)->applyFromArray($BStyle);
	   $objPHPExcel->getActiveSheet()->getStyle("A4".":"."C".$last_row)->applyFromArray($styleAlign);
       $objPHPExcel->setActiveSheetIndex(0);
 
        $objWriter = IOFactory::createWriter($objPHPExcel, 'Excel5');
 		
		
	   // Sending headers to force the user to download the file
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Master-pod-'.$date.'.xls"');
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
	
	public function importDriver()
	{
		
			date_default_timezone_set('Asia/Jakarta');
			ini_set('memory_limit', '-1');
			
			if ($this->tank_auth->is_logged_in()) {
			$user	= $this->tank_auth->get_username();
			$data_account = $this->model_account_master->getAccount("WHERE username = '".$user."' ")->result_array();
			$data_role = $this->model_account_master->getRole("WHERE id_role = '".$data_account[0]['user_access']."' ")->result_array();
			$user_role = $data_account[0]['user_type'];
			$code_role = $data_account[0]['code'];
			
			if($data_role[0]['import_pod']=='yes')
			{
				
				
			if ($_POST) {
			ini_set('memory_limit', '-1');
		    $fileName = $_FILES['import_file']['name'];
			$config['upload_path'] = './files/';
			$config['file_name'] = $fileName;
			$config['allowed_types'] = 'xls|xlsx';
			$config['max_size']		= 100000000;

			$this->load->library('upload');
			$this->upload->initialize($config);

			if(! $this->upload->do_upload('import_file') )
			{
				$this->session->set_flashdata('message_failed','Import Failed, Please upload file excel extension!');
				redirect('pod');
				
				
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
												
												
				
				
			
					//jika master data tidak kosong maka akan diisi		
					$check = $this->model_pod->getDriver("WHERE pod_code  = '".$rowData[0][0]."' ");
					if($check->num_rows() >=1 )
					{
						
						$data_update = array(
							"pod_name" => $rowData[0][1],
							"password" => md5($rowData[0][2])
							
						);
						$where = array(
							"pod_code" => $rowData[0][0]
						);
						
						$res = $this->model_pod->UpdateData("pod",$data_update,$where);
					
						}
					else
					{
						$data_insert = array(
							"pod_code" => $rowData[0][0],
							"pod_name" => $rowData[0][1],
							"password" => md5($rowData[0][2])
						);
						
						//Insert Data
						$res = $this->model_pod->insertData("pod",$data_insert);
					
					}
					
				
				
			}
				@unlink($inputFileName);
				$this->session->set_flashdata('message_success','Data imported successfully');
				redirect('pod');
			
               
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
	
	public function addDriver()
	{
		
			date_default_timezone_set('Asia/Jakarta');
			ini_set('memory_limit', '-1');
			
			if ($this->tank_auth->is_logged_in()) {
			$user	= $this->tank_auth->get_username();
			$data_account = $this->model_account_master->getAccount("WHERE username = '".$user."' ")->result_array();
			$data_role = $this->model_account_master->getRole("WHERE id_role = '".$data_account[0]['user_access']."' ")->result_array();
			$user_role = $data_account[0]['user_type'];
			$code_role = $data_account[0]['code'];
			
			if($data_role[0]['add_pod']=='yes')
			{
				
			
				// Get Variable Post
				$pod_code = $_POST['pod_code'];
				$pod_name = $_POST['pod_name'];
				$password = md5($_POST['password']);
				
				$data_insert = array(
				"pod_code" => $pod_code,
				"pod_name" => $pod_name,
				"password" => $password

				);
				
				//Check Product Apakah sudah ada dengan kode produk dan type motorist yang sama
				$check = $this->model_pod->getDriver("WHERE pod_code = '".$pod_code."' ");
				if($check->num_rows() >=1 )
				{
					$this->session->set_flashdata('message_failed',"Sorry data already exist!");
					redirect('pod');
					
					}
				else
				{
					
					$res = $this->model_pod->insertData("pod",$data_insert);
					if($res>=1)
					{
						$this->session->set_flashdata('message_success',"Data pod has been successfully saved!");
						redirect('pod');
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
	
	
	public function index()
	{
		
			date_default_timezone_set('Asia/Jakarta');
			if ($this->tank_auth->is_logged_in()) {
			$user	= $this->tank_auth->get_username();
			$data_account = $this->model_account_master->getAccount("WHERE username = '".$user."' ")->result_array();
			$data_role = $this->model_account_master->getRole("WHERE id_role = '".$data_account[0]['user_access']."' ")->result_array();
			$user_role = $data_account[0]['user_type'];
			$code_role = $data_account[0]['code'];
			
			if($data_role[0]['see_pod']=='yes')
			{	
			$this->load->library('table');
			$this->load->library('pagination');
			$search = isset($_GET['search']) ? $_GET['search'] : '';
			
			
			$jumlah= $this->model_pod->countPod($search);
			
			if (count($_GET) > 0) $config['suffix'] = '?' . http_build_query($_GET, '', "&");
			$config['base_url'] = base_url().'index.php/pod/pod/';
			$config['total_rows'] = $jumlah;
			$config['first_link'] = 'First';
			$config['last_link'] = 'End';
			$config['next_link'] = 'Next';
			$config['prev_link'] = 'Previous';
			$config['per_page'] = 5; 	
			if (count($_GET) > 0) $config['suffix'] = '?' . http_build_query($_GET, '', "&");
			$config['first_url'] = $config['base_url'].'?'.http_build_query($_GET);
			
			$dari = $this->uri->segment('3');
			$data = $this->model_pod->dataPod($config['per_page'],$dari,$search);
			
		
			$comp = array(
				'title' => ' POD',
				'content' => $this->load->view('accounting_report',array('data_pod'=>$data,'data_role'=>$data_role,'search'=>$search),true),
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