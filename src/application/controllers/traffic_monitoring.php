<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Traffic_monitoring extends CI_Controller {

	function __construct()  {
 		parent::__construct();
			$this->load->library(array('PHPExcel','PHPExcel/IOFactory'));
			$this->load->model('model_account_master');
			$this->load->model('model_traffic_monitoring');
			$this->load->library('tank_auth');
			
	}
	
	
	public function detailUpdateApps()
	{
		
			date_default_timezone_set('Asia/Jakarta');
			if ($this->tank_auth->is_logged_in()) {
			$user	= $this->tank_auth->get_username();
			$data_account = $this->model_account_master->getAccount("WHERE username = '".$user."' ")->result_array();
			$data_role = $this->model_account_master->getRole("WHERE id_role = '".$data_account[0]['user_access']."' ")->result_array();
			$user_role = $data_account[0]['user_type'];
			$code_role = $data_account[0]['code'];
			
			if($data_role[0]['see_traffic_monitoring']=='yes')
			{	
			
			$id = isset($_GET['id']) ? $_GET['id'] : '';
			
			$data_traffic_monitoring = $this->db->query("SELECT * FROM update_apps WHERE id_update_apps = '".$id."' ")->result_array();
			
			$comp = array(
				'title' => ' Detail Traffic Monitoring From Driver',
				'content' => $this->load->view('detail-traffic-monitoring-driver',array('data_traffic_monitoring'=>$data_traffic_monitoring,'data_role'=>$data_role),true),
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
	
	
	public function detailFromDriver()
	{
		
			date_default_timezone_set('Asia/Jakarta');
			if ($this->tank_auth->is_logged_in()) {
			$user	= $this->tank_auth->get_username();
			$data_account = $this->model_account_master->getAccount("WHERE username = '".$user."' ")->result_array();
			$data_role = $this->model_account_master->getRole("WHERE id_role = '".$data_account[0]['user_access']."' ")->result_array();
			$user_role = $data_account[0]['user_type'];
			$code_role = $data_account[0]['code'];
			
			if($data_role[0]['see_traffic_monitoring']=='yes')
			{	
			
			$manifest = isset($_GET['manifest']) ? $_GET['manifest'] : '';
			$state = isset($_GET['state']) ? $_GET['state'] : '';
			
			$data_traffic_monitoring = $this->db->query("SELECT * FROM update_apps WHERE manifest = '".$manifest."' AND state = '".$state."' ")->result();
			
			$comp = array(
				'title' => ' Traffic Monitoring From Driver',
				'content' => $this->load->view('traffic_monitoring_driver',array('data_traffic_monitoring'=>$data_traffic_monitoring,'data_role'=>$data_role),true),
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
	
	public function updateTrafficMonitoringLangsirEmptyCont()
	{
		
			date_default_timezone_set('Asia/Jakarta');
			ini_set('memory_limit', '-1');
			
			if ($this->tank_auth->is_logged_in()) {
			$user	= $this->tank_auth->get_username();
			$data_account = $this->model_account_master->getAccount("WHERE username = '".$user."' ")->result_array();
			$data_role = $this->model_account_master->getRole("WHERE id_role = '".$data_account[0]['user_access']."' ")->result_array();
			$user_role = $data_account[0]['user_type'];
			$code_role = $data_account[0]['code'];
			
			if($data_role[0]['edit_traffic_monitoring']=='yes')
			{
				
			
				// Get Variable Post
				$timestamp = date('Y:m:d H:i:s');
				$username = $user;
				$langsir_empty_cont_client_id = $_POST['langsir_empty_cont_client_id'];
				$langsir_empty_cont_client_name = $_POST['langsir_empty_cont_client_name'];
				$langsir_empty_cont_address = $_POST['langsir_empty_cont_address'];
				$langsir_empty_cont_state = $_POST['langsir_empty_cont_state'];
				$langsir_empty_cont_spk_number = $_POST['langsir_empty_cont_spk_number'];
				$langsir_empty_cont_manifest = $_POST['langsir_empty_cont_manifest'];
				
				$langsir_empty_cont_arrival_estimation_date = explode('-',$_POST['langsir_empty_cont_arrival_estimation_date']);
				$langsir_empty_cont_arrival_estimation_date = $langsir_empty_cont_arrival_estimation_date[2].'-'.$langsir_empty_cont_arrival_estimation_date[1].'-'.$langsir_empty_cont_arrival_estimation_date[0];
				
				$langsir_empty_cont_arrival_estimation_time = $_POST['langsir_empty_cont_arrival_estimation_time'];
				
				$langsir_empty_cont_arrival_actual_date = explode('-',$_POST['langsir_empty_cont_arrival_actual_date']);
				$langsir_empty_cont_arrival_actual_date = $langsir_empty_cont_arrival_actual_date[2].'-'.$langsir_empty_cont_arrival_actual_date[1].'-'.$langsir_empty_cont_arrival_actual_date[0];
				
				$langsir_empty_cont_arrival_actual_time = $_POST['langsir_empty_cont_arrival_actual_time'];
				
				
				$langsir_empty_cont_loading_start_date = explode('-',$_POST['langsir_empty_cont_loading_start_date']);
				$langsir_empty_cont_loading_start_date = $langsir_empty_cont_loading_start_date[2].'-'.$langsir_empty_cont_loading_start_date[1].'-'.$langsir_empty_cont_loading_start_date[0];
				
				$langsir_empty_cont_loading_start_time = $_POST['langsir_empty_cont_loading_start_time'];
				
				$langsir_empty_cont_loading_finish_date = explode('-',$_POST['langsir_empty_cont_loading_finish_date']);
				$langsir_empty_cont_loading_finish_date = $langsir_empty_cont_loading_finish_date[2].'-'.$langsir_empty_cont_loading_finish_date[1].'-'.$langsir_empty_cont_loading_finish_date[0];
				
				$langsir_empty_cont_loading_finish_time = $_POST['langsir_empty_cont_loading_finish_time'];
				
				$langsir_empty_cont_loading_documentation_date = explode('-',$_POST['langsir_empty_cont_loading_documentation_date']);
				$langsir_empty_cont_loading_documentation_date = $langsir_empty_cont_loading_documentation_date[2].'-'.$langsir_empty_cont_loading_documentation_date[1].'-'.$langsir_empty_cont_loading_documentation_date[0];
				
				$langsir_empty_cont_loading_documentation_time = $_POST['langsir_empty_cont_loading_documentation_time'];
				
				$langsir_empty_cont_departure_estimation_date = explode('-',$_POST['langsir_empty_cont_departure_estimation_date']);
				$langsir_empty_cont_departure_estimation_date = $langsir_empty_cont_departure_estimation_date[2].'-'.$langsir_empty_cont_departure_estimation_date[1].'-'.$langsir_empty_cont_departure_estimation_date[0];
				
				$langsir_empty_cont_departure_estimation_time = $_POST['langsir_empty_cont_departure_estimation_time'];
				
				$langsir_empty_cont_departure_actual_date = explode('-',$_POST['langsir_empty_cont_departure_actual_date']);
				$langsir_empty_cont_departure_actual_date = $langsir_empty_cont_departure_actual_date[2].'-'.$langsir_empty_cont_departure_actual_date[1].'-'.$langsir_empty_cont_departure_actual_date[0];
				
				$langsir_empty_cont_departure_actual_time = $_POST['langsir_empty_cont_departure_actual_time'];
				
				$langsir_empty_cont_landing_location = $_POST['langsir_empty_cont_landing_location'];
				
				$check_traffic_monitoring_regular = $this->db->query("SELECT * FROM traffic_monitoring_langsir_empty WHERE spk_number = '".$langsir_empty_cont_spk_number."' AND state = '".$langsir_empty_cont_state."' AND point_id = '".$langsir_empty_cont_client_id."' ")->num_rows();
				if($check_traffic_monitoring_regular>=1)
				{
					$data_update = array(
				
							
							"name" => $langsir_empty_cont_client_name,
							"address" => $langsir_empty_cont_address,
							"arrival_estimation_date" => $langsir_empty_cont_arrival_estimation_date,
							"arrival_estimation_time" => $langsir_empty_cont_arrival_estimation_time,
							"arrival_actual_date" => $langsir_empty_cont_arrival_actual_date,
							"arrival_actual_time" => $langsir_empty_cont_arrival_actual_time,
							"loading_landing_start_date" => $langsir_empty_cont_loading_start_date,
							"loading_landing_start_time" => $langsir_empty_cont_loading_start_time,
							"loading_landing_finish_date" => $langsir_empty_cont_loading_finish_date,
							"loading_landing_finish_time" => $langsir_empty_cont_loading_finish_time,
							"loading_landing_documentation_date" => $langsir_empty_cont_loading_documentation_date,
							"loading_landing_documentation_time" => $langsir_empty_cont_loading_documentation_time,
							"departure_estimation_date" => $langsir_empty_cont_departure_actual_date,
							"departure_estimation_time" => $langsir_empty_cont_departure_actual_time,
							"departure_actual_date" => $langsir_empty_cont_departure_actual_date,
							"departure_actual_time" => $langsir_empty_cont_departure_actual_time,
							"landing_location" => $langsir_empty_cont_landing_location,
							"updated_by" => $user,
							"updated_time" => $timestamp

					);
					
					$where = array(
							"manifest" => $langsir_empty_cont_manifest,
							"spk_number" => $langsir_empty_cont_spk_number,
							"state" => $langsir_empty_cont_state,
							"point_id" => $langsir_empty_cont_client_id
					);
					
					$res = $this->model_traffic_monitoring->UpdateData("traffic_monitoring_langsir_empty",$data_update,$where);
					if($res>=1)
					{
						$this->session->set_flashdata('message_success',"Data Traffic Monitoring has been successfully saved!");
						redirect('traffic_monitoring');
					}	
					
				}
				else
				{
					//insert
					
					$data_insert = array(
							"manifest" => $langsir_empty_cont_manifest,
							"spk_number" => $langsir_empty_cont_spk_number,
							"state" => $langsir_empty_cont_state,
							"point_id" => $langsir_empty_cont_client_id,
							"name" => $langsir_empty_cont_client_name,
							"address" => $langsir_empty_cont_address,
							"arrival_estimation_date" => $langsir_empty_cont_arrival_estimation_date,
							"arrival_estimation_time" => $langsir_empty_cont_arrival_estimation_time,
							"arrival_actual_date" => $langsir_empty_cont_arrival_actual_date,
							"arrival_actual_time" => $langsir_empty_cont_arrival_actual_time,
							"loading_landing_start_date" => $langsir_empty_cont_loading_start_date,
							"loading_landing_start_time" => $langsir_empty_cont_loading_start_time,
							"loading_landing_finish_date" => $langsir_empty_cont_loading_finish_date,
							"loading_landing_finish_time" => $langsir_empty_cont_loading_finish_time,
							"loading_landing_documentation_date" => $langsir_empty_cont_loading_documentation_date,
							"loading_landing_documentation_time" => $langsir_empty_cont_loading_documentation_time,
							"departure_estimation_date" => $langsir_empty_cont_departure_actual_date,
							"departure_estimation_time" => $langsir_empty_cont_departure_actual_time,
							"departure_actual_date" => $langsir_empty_cont_departure_actual_date,
							"departure_actual_time" => $langsir_empty_cont_departure_actual_time,
							"landing_location" => $langsir_empty_cont_landing_location,
							"created_by" => $user,
							"created_time" => $timestamp
					);
					$res = $this->model_traffic_monitoring->insertData("traffic_monitoring_langsir_empty",$data_insert);
					
					if($res>=1)
					{
						$this->session->set_flashdata('message_success',"Data Traffic Monitoring has been successfully saved!");
						redirect('traffic_monitoring');
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
	
	
	public function updateTrafficMonitoringExport()
	{
		
			date_default_timezone_set('Asia/Jakarta');
			ini_set('memory_limit', '-1');
			
			if ($this->tank_auth->is_logged_in()) {
			$user	= $this->tank_auth->get_username();
			$data_account = $this->model_account_master->getAccount("WHERE username = '".$user."' ")->result_array();
			$data_role = $this->model_account_master->getRole("WHERE id_role = '".$data_account[0]['user_access']."' ")->result_array();
			$user_role = $data_account[0]['user_type'];
			$code_role = $data_account[0]['code'];
			
			if($data_role[0]['edit_traffic_monitoring']=='yes')
			{
				
			
				// Get Variable Post
				$timestamp = date('Y:m:d H:i:s');
				$username = $user;
				$export_client_id = $_POST['export_client_id'];
				$export_client_name = $_POST['export_client_name'];
				$export_address = $_POST['export_address'];
				$export_state = $_POST['export_state'];
				$export_spk_number = $_POST['export_spk_number'];
				$export_manifest = $_POST['export_manifest'];
				
				$export_arrival_estimation_date = explode('-',$_POST['export_arrival_estimation_date']);
				$export_arrival_estimation_date = $export_arrival_estimation_date[2].'-'.$export_arrival_estimation_date[1].'-'.$export_arrival_estimation_date[0];
				
				$export_arrival_estimation_time = $_POST['export_arrival_estimation_time'];
				
				
				$export_arrival_actual_date = explode('-',$_POST['export_arrival_actual_date']);
				$export_arrival_actual_date = $export_arrival_actual_date[2].'-'.$export_arrival_actual_date[1].'-'.$export_arrival_actual_date[0];
				
				$export_arrival_actual_time = $_POST['export_arrival_actual_time'];
				
				
				
				$export_landing_container_estimation_date = explode('-',$_POST['export_landing_container_estimation_date']);
				$export_landing_container_estimation_date = $export_landing_container_estimation_date[2].'-'.$export_landing_container_estimation_date[1].'-'.$export_landing_container_estimation_date[0];
				
				$export_landing_container_estimation_time = $_POST['export_landing_container_estimation_time'];
				
				
				$export_landing_container_actual_date = explode('-',$_POST['export_landing_container_actual_date']);
				$export_landing_container_actual_date = $export_landing_container_actual_date[2].'-'.$export_landing_container_actual_date[1].'-'.$export_landing_container_actual_date[0];
				
				$export_landing_container_actual_time = $_POST['export_landing_container_actual_time'];
				
				
				$export_departure_estimation_date = explode('-',$_POST['export_departure_estimation_date']);
				$export_departure_estimation_date = $export_departure_estimation_date[2].'-'.$export_departure_estimation_date[1].'-'.$export_departure_estimation_date[0];
				
				$export_departure_estimation_time = $_POST['export_departure_estimation_time'];
				
				$export_departure_actual_date = explode('-',$_POST['export_departure_actual_date']);
				$export_departure_actual_date = $export_departure_actual_date[2].'-'.$export_departure_actual_date[1].'-'.$export_departure_actual_date[0];
				
				$export_departure_actual_time = $_POST['export_departure_actual_time'];
				
				
				
				$export_loading_empty_cont_documentation_date = explode('-',$_POST['export_loading_empty_cont_documentation_date']);
				$export_loading_empty_cont_documentation_date = $export_loading_empty_cont_documentation_date[2].'-'.$export_loading_empty_cont_documentation_date[1].'-'.$export_loading_empty_cont_documentation_date[0];
				
				$export_loading_empty_cont_documentation_time = $_POST['export_loading_empty_cont_documentation_time'];
				
				
				$export_loading_empty_cont_start_date = explode('-',$_POST['export_loading_empty_cont_start_date']);
				$export_loading_empty_cont_start_date = $export_loading_empty_cont_start_date[2].'-'.$export_loading_empty_cont_start_date[1].'-'.$export_loading_empty_cont_start_date[0];
				
				$export_loading_empty_cont_start_time = $_POST['export_loading_empty_cont_start_time'];
				
				$export_loading_empty_cont_finish_date = explode('-',$_POST['export_loading_empty_cont_finish_date']);
				$export_loading_empty_cont_finish_date = $export_loading_empty_cont_finish_date[2].'-'.$export_loading_empty_cont_finish_date[1].'-'.$export_loading_empty_cont_finish_date[0];
				
				$export_loading_empty_cont_finish_time = $_POST['export_loading_empty_cont_finish_time'];
				
				$export_loading_product_documentation_date = explode('-',$_POST['export_loading_product_documentation_date']);
				$export_loading_product_documentation_date = $export_loading_product_documentation_date[2].'-'.$export_loading_product_documentation_date[1].'-'.$export_loading_product_documentation_date[0];
				
				$export_loading_product_documentation_time = $_POST['export_loading_product_documentation_time'];
				
				
				$export_loading_product_start_date = explode('-',$_POST['export_loading_product_start_date']);
				$export_loading_product_start_date = $export_loading_product_start_date[2].'-'.$export_loading_product_start_date[1].'-'.$export_loading_product_start_date[0];
				
				$export_loading_product_start_time = $_POST['export_loading_product_start_time'];
				
				
				$export_loading_product_finish_date = explode('-',$_POST['export_loading_product_finish_date']);
				$export_loading_product_finish_date = $export_loading_product_finish_date[2].'-'.$export_loading_product_finish_date[1].'-'.$export_loading_product_finish_date[0];
				
				$export_loading_product_finish_time = $_POST['export_loading_product_finish_time'];
				
			
				
				$check_traffic_monitoring_export = $this->db->query("SELECT * FROM traffic_monitoring_export WHERE spk_number = '".$export_spk_number."' AND state = '".$export_state."' AND point_id = '".$export_client_id."' ")->num_rows();
				if($check_traffic_monitoring_export>=1)
				{
					$data_update = array(
				
							
							"name" => $export_client_name,
							"address" => $export_address,
							"arrival_estimation_date" => $export_arrival_estimation_date,
							"arrival_estimation_time" => $export_arrival_estimation_time,
							"arrival_actual_date" => $export_arrival_actual_date,
							"arrival_actual_time" => $export_arrival_actual_time,
							"loading_empty_cont_documentation_date" => $export_loading_empty_cont_documentation_date,
							"loading_empty_cont_documentation_time	" => $export_loading_empty_cont_documentation_time,
							"loading_empty_cont_start_date" => $export_loading_empty_cont_start_date,
							"loading_empty_cont_start_time" => $export_loading_empty_cont_start_time,
							"loading_empty_cont_finish_date" => $export_loading_empty_cont_finish_date,
							"loading_empty_cont_finish_time" => $export_loading_empty_cont_finish_time,
							"loading_product_documentation_date" => $export_loading_product_documentation_date,
							"loading_product_documentation_time" => $export_loading_product_documentation_time,
							"loading_product_start_date" => $export_loading_product_start_date,
							"loading_product_start_time" => $export_loading_product_start_time,
							"loading_product_finish_date" => $export_loading_product_finish_date,
							"loading_product_finish_time" => $export_loading_product_finish_time,
							"departure_estimation_date" => $export_departure_estimation_date,
							"departure_estimation_time" => $export_departure_estimation_time,
							"departure_actual_date" => $export_departure_actual_date,
							"departure_actual_time" => $export_departure_actual_time,
							"landing_cont_estimation_date" => $export_landing_container_estimation_date,
							"landing_cont_estimation_time" => $export_landing_container_estimation_time,
							"landing_cont_actual_date" => $export_landing_container_actual_date,
							"landing_cont_actual_time" => $export_landing_container_actual_time,
							"updated_by" => $user,
							"updated_time" => $timestamp

					);
					
					$where = array(
							"manifest" => $export_manifest,
							"spk_number" => $export_spk_number,
							"state" => $export_state,
							"point_id" => $export_client_id
					);
					
					$res = $this->model_traffic_monitoring->UpdateData("traffic_monitoring_export",$data_update,$where);
					if($res>=1)
					{
						$this->session->set_flashdata('message_success',"Data Traffic Monitoring has been successfully saved!");
						redirect('traffic_monitoring');
					}	
					
				}
				else
				{
					//insert
					
					$data_insert = array(						
							"manifest" => $export_manifest,
							"spk_number" => $export_spk_number,
							"state" => $export_state,
							"point_id" => $export_client_id,
							"name" => $export_client_name,
							"address" => $export_address,
							"arrival_estimation_date" => $export_arrival_estimation_date,
							"arrival_estimation_time" => $export_arrival_estimation_time,
							"arrival_actual_date" => $export_arrival_actual_date,
							"arrival_actual_time" => $export_arrival_actual_time,
							"loading_empty_cont_documentation_date" => $export_loading_empty_cont_documentation_date,
							"loading_empty_cont_documentation_time	" => $export_loading_empty_cont_documentation_time,
							"loading_empty_cont_start_date" => $export_loading_empty_cont_start_date,
							"loading_empty_cont_start_time" => $export_loading_empty_cont_start_time,
							"loading_empty_cont_finish_date" => $export_loading_empty_cont_finish_date,
							"loading_empty_cont_finish_time" => $export_loading_empty_cont_finish_time,
							"loading_product_documentation_date" => $export_loading_product_documentation_date,
							"loading_product_documentation_time" => $export_loading_product_documentation_time,
							"loading_product_start_date" => $export_loading_product_start_date,
							"loading_product_start_time" => $export_loading_product_start_time,
							"loading_product_finish_date" => $export_loading_product_finish_date,
							"loading_product_finish_time" => $export_loading_product_finish_time,
							"departure_estimation_date" => $export_departure_estimation_date,
							"departure_estimation_time" => $export_departure_estimation_time,
							"departure_actual_date" => $export_departure_actual_date,
							"departure_actual_time" => $export_departure_actual_time,
							"landing_cont_estimation_date" => $export_landing_container_estimation_date,
							"landing_cont_estimation_time" => $export_landing_container_estimation_time,
							"landing_cont_actual_date" => $export_landing_container_actual_date,
							"landing_cont_actual_time" => $export_landing_container_actual_time,
							"created_by" => $user,
							"created_time" => $timestamp
					);
					$res = $this->model_traffic_monitoring->insertData("traffic_monitoring_export",$data_insert);
					
					if($res>=1)
					{
						$this->session->set_flashdata('message_success',"Data Traffic Monitoring has been successfully saved!");
						redirect('traffic_monitoring');
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
	
	public function updateTrafficMonitoringImport()
	{
		
			date_default_timezone_set('Asia/Jakarta');
			ini_set('memory_limit', '-1');
			
			if ($this->tank_auth->is_logged_in()) {
			$user	= $this->tank_auth->get_username();
			$data_account = $this->model_account_master->getAccount("WHERE username = '".$user."' ")->result_array();
			$data_role = $this->model_account_master->getRole("WHERE id_role = '".$data_account[0]['user_access']."' ")->result_array();
			$user_role = $data_account[0]['user_type'];
			$code_role = $data_account[0]['code'];
			
			if($data_role[0]['edit_traffic_monitoring']=='yes')
			{
				
			
				// Get Variable Post
				$timestamp = date('Y:m:d H:i:s');
				$username = $user;
				$import_client_id = $_POST['import_client_id'];
				$import_client_name = $_POST['import_client_name'];
				$import_address = $_POST['import_address'];
				$import_state = $_POST['import_state'];
				$import_spk_number = $_POST['import_spk_number'];
				$import_manifest = $_POST['import_manifest'];
				
				$import_arrival_estimation_date = explode('-',$_POST['import_arrival_estimation_date']);
				$import_arrival_estimation_date = $import_arrival_estimation_date[2].'-'.$import_arrival_estimation_date[1].'-'.$import_arrival_estimation_date[0];
				
				$import_arrival_estimation_time = $_POST['import_arrival_estimation_time'];
				
				$import_arrival_actual_date = explode('-',$_POST['import_arrival_actual_date']);
				$import_arrival_actual_date = $import_arrival_actual_date[2].'-'.$import_arrival_actual_date[1].'-'.$import_arrival_actual_date[0];
				
				$import_arrival_actual_time = $_POST['import_arrival_actual_time'];
				
				
				$import_loading_start_date = explode('-',$_POST['import_loading_unloading_start_date']);
				$import_loading_start_date = $import_loading_start_date[2].'-'.$import_loading_start_date[1].'-'.$import_loading_start_date[0];
				
				$import_loading_start_time = $_POST['import_loading_unloading_start_time'];
				
				$import_loading_finish_date = explode('-',$_POST['import_loading_unloading_finish_date']);
				$import_loading_finish_date = $import_loading_finish_date[2].'-'.$import_loading_finish_date[1].'-'.$import_loading_finish_date[0];
				
				$import_loading_finish_time = $_POST['import_loading_unloading_finish_time'];
				
				$import_loading_documentation_date = explode('-',$_POST['import_loading_unloading_documentation_date']);
				$import_loading_documentation_date = $import_loading_documentation_date[2].'-'.$import_loading_documentation_date[1].'-'.$import_loading_documentation_date[0];
				
				$import_loading_documentation_time = $_POST['import_loading_unloading_documentation_time'];
				
				$import_departure_estimation_date = explode('-',$_POST['import_departure_estimation_date']);
				$import_departure_estimation_date = $import_departure_estimation_date[2].'-'.$import_departure_estimation_date[1].'-'.$import_departure_estimation_date[0];
				
				$import_departure_estimation_time = $_POST['import_departure_estimation_time'];
				
				$import_departure_actual_date = explode('-',$_POST['import_departure_actual_date']);
				$import_departure_actual_date = $import_departure_actual_date[2].'-'.$import_departure_actual_date[1].'-'.$import_departure_actual_date[0];
				
				$import_departure_actual_time = $_POST['import_departure_actual_time'];
				
				
				
				$import_landing_container_estimation_date = explode('-',$_POST['import_landing_container_estimation_date']);
				$import_landing_container_estimation_date = $import_landing_container_estimation_date[2].'-'.$import_landing_container_estimation_date[1].'-'.$import_landing_container_estimation_date[0];
				
				$import_landing_container_estimation_time = $_POST['import_landing_container_estimation_time'];
				
				$import_landing_container_actual_date = explode('-',$_POST['import_landing_container_actual_date']);
				$import_landing_container_actual_date = $import_landing_container_actual_date[2].'-'.$import_landing_container_actual_date[1].'-'.$import_landing_container_actual_date[0];
				
				$import_landing_container_actual_time = $_POST['import_landing_container_actual_time'];
				
				$import_landing_location = $_POST['import_landing_location'];
				
				$check_traffic_monitoring_regular = $this->db->query("SELECT * FROM traffic_monitoring_import WHERE spk_number = '".$import_spk_number."' AND state = '".$import_state."' AND point_id = '".$import_client_id."' ")->num_rows();
				if($check_traffic_monitoring_regular>=1)
				{
					$data_update = array(
				
							
							"name" => $import_client_name,
							"address" => $import_address,
							"arrival_estimation_date" => $import_arrival_estimation_date,
							"arrival_estimation_time" => $import_arrival_estimation_time,
							"arrival_actual_date" => $import_arrival_actual_date,
							"arrival_actual_time" => $import_arrival_actual_time,
							"loading_unloading_start_date" => $import_loading_start_date,
							"loading_unloading_start_time" => $import_loading_start_time,
							"loading_unloading_finish_date" => $import_loading_finish_date,
							"loading_unloading_finish_time" => $import_loading_finish_time,
							"loading_unloading_documentation_date" => $import_loading_documentation_date,
							"loading_unloading_documentation_time" => $import_loading_documentation_time,
							"departure_estimation_date" => $import_departure_actual_date,
							"departure_estimation_time" => $import_departure_actual_time,
							"departure_actual_date" => $import_departure_actual_date,
							"departure_actual_time" => $import_departure_actual_time,
							"landing_container_estimation_date" => $import_landing_container_estimation_date,
							"landing_container_estimation_time" => $import_landing_container_estimation_time,
							"landing_container_actual_date" => $import_landing_container_actual_date,
							"landing_container_actual_time" => $import_landing_container_actual_time,
							"landing_location" => $import_landing_location,
							"updated_by" => $user,
							"updated_time" => $timestamp

					);
					
					$where = array(
							"manifest" => $import_manifest,
							"spk_number" => $import_spk_number,
							"state" => $import_state,
							"point_id" => $import_client_id
					);
					
					$res = $this->model_traffic_monitoring->UpdateData("traffic_monitoring_import",$data_update,$where);
					if($res>=1)
					{
						$this->session->set_flashdata('message_success',"Data Traffic Monitoring has been successfully saved!");
						redirect('traffic_monitoring');
					}	
					
				}
				else
				{
					//insert
					
					$data_insert = array(	
							"manifest" => $import_manifest,
							"spk_number" => $import_spk_number,
							"state" => $import_state,
							"point_id" => $import_client_id,
							"name" => $import_client_name,
							"address" => $import_address,
							"arrival_estimation_date" => $import_arrival_estimation_date,
							"arrival_estimation_time" => $import_arrival_estimation_time,
							"arrival_actual_date" => $import_arrival_actual_date,
							"arrival_actual_time" => $import_arrival_actual_time,
							"loading_unloading_start_date" => $import_loading_start_date,
							"loading_unloading_start_time" => $import_loading_start_time,
							"loading_unloading_finish_date" => $import_loading_finish_date,
							"loading_unloading_finish_time" => $import_loading_finish_time,
							"loading_unloading_documentation_date" => $import_loading_documentation_date,
							"loading_unloading_documentation_time" => $import_loading_documentation_time,
							"departure_estimation_date" => $import_departure_actual_date,
							"departure_estimation_time" => $import_departure_actual_time,
							"departure_actual_date" => $import_departure_actual_date,
							"departure_actual_time" => $import_departure_actual_time,
							"landing_container_estimation_date" => $import_landing_container_estimation_date,
							"landing_container_estimation_time" => $import_landing_container_estimation_time,
							"landing_container_actual_date" => $import_landing_container_actual_date,
							"landing_container_actual_time" => $import_landing_container_actual_time,
							"landing_location" => $import_landing_location,
							"created_by" => $user,
							"created_time" => $timestamp
					);
					$res = $this->model_traffic_monitoring->insertData("traffic_monitoring_import",$data_insert);
					
					if($res>=1)
					{
						$this->session->set_flashdata('message_success',"Data Traffic Monitoring has been successfully saved!");
						redirect('traffic_monitoring');
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
	
	
	public function updateTrafficMonitoringLangsir()
	{
		
			date_default_timezone_set('Asia/Jakarta');
			ini_set('memory_limit', '-1');
			
			if ($this->tank_auth->is_logged_in()) {
			$user	= $this->tank_auth->get_username();
			$data_account = $this->model_account_master->getAccount("WHERE username = '".$user."' ")->result_array();
			$data_role = $this->model_account_master->getRole("WHERE id_role = '".$data_account[0]['user_access']."' ")->result_array();
			$user_role = $data_account[0]['user_type'];
			$code_role = $data_account[0]['code'];
			
			if($data_role[0]['edit_traffic_monitoring']=='yes')
			{
				
			
				// Get Variable Post
				$timestamp = date('Y:m:d H:i:s');
				$username = $user;
				$langsir_client_id = $_POST['langsir_client_id'];
				$langsir_client_name = $_POST['langsir_client_name'];
				$langsir_address = $_POST['langsir_address'];
				$langsir_state = $_POST['langsir_state'];
				$langsir_spk_number = $_POST['langsir_spk_number'];
				$langsir_manifest = $_POST['langsir_manifest'];
				
				$langsir_arrival_estimation_date = explode('-',$_POST['langsir_arrival_estimation_date']);
				$langsir_arrival_estimation_date = $langsir_arrival_estimation_date[2].'-'.$langsir_arrival_estimation_date[1].'-'.$langsir_arrival_estimation_date[0];
				
				$langsir_arrival_estimation_time = $_POST['langsir_arrival_estimation_time'];
				
				$langsir_arrival_actual_date = explode('-',$_POST['langsir_arrival_actual_date']);
				$langsir_arrival_actual_date = $langsir_arrival_actual_date[2].'-'.$langsir_arrival_actual_date[1].'-'.$langsir_arrival_actual_date[0];
				
				$langsir_arrival_actual_time = $_POST['langsir_arrival_actual_time'];
				
				
				$langsir_loading_start_date = explode('-',$_POST['langsir_loading_start_date']);
				$langsir_loading_start_date = $langsir_loading_start_date[2].'-'.$langsir_loading_start_date[1].'-'.$langsir_loading_start_date[0];
				
				$langsir_loading_start_time = $_POST['langsir_loading_start_time'];
				
				$langsir_loading_finish_date = explode('-',$_POST['langsir_loading_finish_date']);
				$langsir_loading_finish_date = $langsir_loading_finish_date[2].'-'.$langsir_loading_finish_date[1].'-'.$langsir_loading_finish_date[0];
				
				$langsir_loading_finish_time = $_POST['langsir_loading_finish_time'];
				
				$langsir_loading_documentation_date = explode('-',$_POST['langsir_loading_documentation_date']);
				$langsir_loading_documentation_date = $langsir_loading_documentation_date[2].'-'.$langsir_loading_documentation_date[1].'-'.$langsir_loading_documentation_date[0];
				
				$langsir_loading_documentation_time = $_POST['langsir_loading_documentation_time'];
				
				$langsir_departure_estimation_date = explode('-',$_POST['langsir_departure_estimation_date']);
				$langsir_departure_estimation_date = $langsir_departure_estimation_date[2].'-'.$langsir_departure_estimation_date[1].'-'.$langsir_departure_estimation_date[0];
				
				$langsir_departure_estimation_time = $_POST['langsir_departure_estimation_time'];
				
				$langsir_departure_actual_date = explode('-',$_POST['langsir_departure_actual_date']);
				$langsir_departure_actual_date = $langsir_departure_actual_date[2].'-'.$langsir_departure_actual_date[1].'-'.$langsir_departure_actual_date[0];
				
				$langsir_departure_actual_time = $_POST['langsir_departure_actual_time'];
				
				$langsir_landing_location = $_POST['langsir_landing_location'];
				
				$check_traffic_monitoring_regular = $this->db->query("SELECT * FROM traffic_monitoring_langsir WHERE spk_number = '".$langsir_spk_number."' AND state = '".$langsir_state."' AND point_id = '".$langsir_client_id."' ")->num_rows();
				if($check_traffic_monitoring_regular>=1)
				{
					$data_update = array(
				
							
							"name" => $langsir_client_name,
							"address" => $langsir_address,
							"arrival_estimation_date" => $langsir_arrival_estimation_date,
							"arrival_estimation_time" => $langsir_arrival_estimation_time,
							"arrival_actual_date" => $langsir_arrival_actual_date,
							"arrival_actual_time" => $langsir_arrival_actual_time,
							"loading_landing_start_date" => $langsir_loading_start_date,
							"loading_landing_start_time" => $langsir_loading_start_time,
							"loading_landing_finish_date" => $langsir_loading_finish_date,
							"loading_landing_finish_time" => $langsir_loading_finish_time,
							"loading_landing_documentation_date" => $langsir_loading_documentation_date,
							"loading_landing_documentation_time" => $langsir_loading_documentation_time,
							"departure_estimation_date" => $langsir_departure_actual_date,
							"departure_estimation_time" => $langsir_departure_actual_time,
							"departure_actual_date" => $langsir_departure_actual_date,
							"departure_actual_time" => $langsir_departure_actual_time,
							"landing_location" => $langsir_landing_location,
							"updated_by" => $user,
							"updated_time" => $timestamp

					);
					
					$where = array(
							"manifest" => $langsir_manifest,
							"spk_number" => $langsir_spk_number,
							"state" => $langsir_state,
							"point_id" => $langsir_client_id
					);
					
					$res = $this->model_traffic_monitoring->UpdateData("traffic_monitoring_langsir",$data_update,$where);
					if($res>=1)
					{
						$this->session->set_flashdata('message_success',"Data Traffic Monitoring has been successfully saved!");
						redirect('traffic_monitoring');
					}	
					
				}
				else
				{
					//insert
					
					$data_insert = array(						
							"manifest" => $langsir_manifest,
							"spk_number" => $langsir_spk_number,
							"state" => $langsir_state,
							"point_id" => $langsir_client_id,
							"name" => $langsir_client_name,
							"address" => $langsir_address,
							"arrival_estimation_date" => $langsir_arrival_estimation_date,
							"arrival_estimation_time" => $langsir_arrival_estimation_time,
							"arrival_actual_date" => $langsir_arrival_actual_date,
							"arrival_actual_time" => $langsir_arrival_actual_time,
							"loading_landing_start_date" => $langsir_loading_start_date,
							"loading_landing_start_time" => $langsir_loading_start_time,
							"loading_landing_finish_date" => $langsir_loading_finish_date,
							"loading_landing_finish_time" => $langsir_loading_finish_time,
							"loading_landing_documentation_date" => $langsir_loading_documentation_date,
							"loading_landing_documentation_time" => $langsir_loading_documentation_time,
							"departure_estimation_date" => $langsir_departure_actual_date,
							"departure_estimation_time" => $langsir_departure_actual_time,
							"departure_actual_date" => $langsir_departure_actual_date,
							"departure_actual_time" => $langsir_departure_actual_time,
							"landing_location" => $langsir_landing_location,
							"created_by" => $user,
							"created_time" => $timestamp
					);
					$res = $this->model_traffic_monitoring->insertData("traffic_monitoring_langsir",$data_insert);
					
					if($res>=1)
					{
						$this->session->set_flashdata('message_success',"Data Traffic Monitoring has been successfully saved!");
						redirect('traffic_monitoring');
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
	
	public function deleteTrafficMonitoringAll()
	{
		
			date_default_timezone_set('Asia/Jakarta');
			ini_set('memory_limit', '-1');
			
			if ($this->tank_auth->is_logged_in()) {
			$user	= $this->tank_auth->get_username();
			$data_account = $this->model_account_master->getAccount("WHERE username = '".$user."' ")->result_array();
			$data_role = $this->model_account_master->getRole("WHERE id_role = '".$data_account[0]['user_access']."' ")->result_array();
			$user_role = $data_account[0]['user_type'];
			$code_role = $data_account[0]['code'];
			if($data_role[0]['delete_traffic_monitoring']=='yes')
			{
				
			
				// Get Variable Post
				$id_traffic_monitoring_delete = $_POST['id_traffic_monitoring_delete_all'];
				
		
					//Update Product
					$res = $this->db->query("DELETE FROM master_traffic_monitoring WHERE id_traffic_monitoring in (".$id_traffic_monitoring_delete.") ");
					if($res>=1)
					{
						$this->session->set_flashdata('message_success',"Data traffic_monitoring has been successfully deleted!");
						redirect('traffic_monitoring');
						
						}
					else
					{
						$this->session->set_flashdata('message_failed',"Data TrafficMonitoring failed to delete!");
						redirect('traffic_monitoring');
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
	
	public function updateTrafficMonitoringRegular($id_channel)
	{
		
			date_default_timezone_set('Asia/Jakarta');
			ini_set('memory_limit', '-1');
			
			if ($this->tank_auth->is_logged_in()) {
			$user	= $this->tank_auth->get_username();
			$data_account = $this->model_account_master->getAccount("WHERE username = '".$user."' ")->result_array();
			$data_role = $this->model_account_master->getRole("WHERE id_role = '".$data_account[0]['user_access']."' ")->result_array();
			$user_role = $data_account[0]['user_type'];
			$code_role = $data_account[0]['code'];
			
			if($data_role[0]['edit_traffic_monitoring']=='yes')
			{
				
			
				// Get Variable Post
				$timestamp = date('Y:m:d H:i:s');
				$username = $user;
				$regular_client_id = $_POST['regular_client_id'];
				$regular_client_name = $_POST['regular_client_name'];
				$regular_address = $_POST['regular_address'];
				$regular_state = $_POST['regular_state'];
				$regular_spk_number = $_POST['regular_spk_number'];
				$regular_manifest = $_POST['regular_manifest'];
				
				$regular_arrival_estimation_date = explode('-',$_POST['regular_arrival_estimation_date']);
				$regular_arrival_estimation_date = $regular_arrival_estimation_date[2].'-'.$regular_arrival_estimation_date[1].'-'.$regular_arrival_estimation_date[0];
				
				$regular_arrival_estimation_time = $_POST['regular_arrival_estimation_time'];
				
				$regular_arrival_actual_date = explode('-',$_POST['regular_arrival_actual_date']);
				$regular_arrival_actual_date = $regular_arrival_actual_date[2].'-'.$regular_arrival_actual_date[1].'-'.$regular_arrival_actual_date[0];
				
				$regular_arrival_actual_time = $_POST['regular_arrival_actual_time'];
				
				
				$regular_loading_start_date = explode('-',$_POST['regular_loading_start_date']);
				$regular_loading_start_date = $regular_loading_start_date[2].'-'.$regular_loading_start_date[1].'-'.$regular_loading_start_date[0];
				
				$regular_loading_start_time = $_POST['regular_loading_start_time'];
				
				$regular_loading_finish_date = explode('-',$_POST['regular_loading_finish_date']);
				$regular_loading_finish_date = $regular_loading_finish_date[2].'-'.$regular_loading_finish_date[1].'-'.$regular_loading_finish_date[0];
				
				$regular_loading_finish_time = $_POST['regular_loading_finish_time'];
				
				$regular_loading_documentation_date = explode('-',$_POST['regular_loading_documentation_date']);
				$regular_loading_documentation_date = $regular_loading_documentation_date[2].'-'.$regular_loading_documentation_date[1].'-'.$regular_loading_documentation_date[0];
				
				$regular_loading_documentation_time = $_POST['regular_loading_documentation_time'];
				
				$regular_departure_estimation_date = explode('-',$_POST['regular_departure_estimation_date']);
				$regular_departure_estimation_date = $regular_departure_estimation_date[2].'-'.$regular_departure_estimation_date[1].'-'.$regular_departure_estimation_date[0];
				
				$regular_departure_estimation_time = $_POST['regular_departure_estimation_time'];
				
				$regular_departure_actual_date = explode('-',$_POST['regular_departure_actual_date']);
				$regular_departure_actual_date = $regular_departure_actual_date[2].'-'.$regular_departure_actual_date[1].'-'.$regular_departure_actual_date[0];
				
				$regular_departure_actual_time = $_POST['regular_departure_actual_time'];
				
				$check_traffic_monitoring_regular = $this->db->query("SELECT * FROM traffic_monitoring_regular WHERE spk_number = '".$regular_spk_number."' AND state = '".$regular_state."' AND point_id = '".$regular_client_id."' ")->num_rows();
				if($check_traffic_monitoring_regular>=1)
				{
					$data_update = array(
				
							
							"name" => $regular_client_name,
							"address" => $regular_address,
							"arrival_estimation_date" => $regular_arrival_estimation_date,
							"arrival_estimation_time" => $regular_arrival_estimation_time,
							"arrival_actual_date" => $regular_arrival_actual_date,
							"arrival_actual_time" => $regular_arrival_actual_time,
							"loading_unloading_start_date" => $regular_loading_start_date,
							"loading_unloading_start_time" => $regular_loading_start_time,
							"loading_unloading_finish_date" => $regular_loading_finish_date,
							"loading_unloading_finish_time" => $regular_loading_finish_time,
							"loading_unloading_documentation_date" => $regular_loading_documentation_date,
							"loading_unloading_documentation_time" => $regular_loading_documentation_time,
							"departure_estimation_date" => $regular_departure_actual_date,
							"departure_estimation_time" => $regular_departure_actual_time,
							"departure_actual_date" => $regular_departure_actual_date,
							"departure_actual_time" => $regular_departure_actual_time,
							"updated_by" => $user,
							"updated_time" => $timestamp

					);
					
					$where = array(
							"manifest" => $regular_manifest,
							"spk_number" => $regular_spk_number,
							"state" => $regular_state,
							"point_id" => $regular_client_id
					);
					
					$res = $this->model_traffic_monitoring->UpdateData("traffic_monitoring_regular",$data_update,$where);
					if($res>=1)
					{
						$this->session->set_flashdata('message_success',"Data Traffic Monitoring has been successfully saved!");
						redirect('traffic_monitoring');
					}	
					
				}
				else
				{
					//insert
					
					$data_insert = array(						
							"manifest" => $regular_manifest,
							"spk_number" => $regular_spk_number,
							"state" => $regular_state,
							"point_id" => $regular_client_id,
							"name" => $regular_client_name,
							"address" => $regular_address,
							"arrival_estimation_date" => $regular_arrival_estimation_date,
							"arrival_estimation_time" => $regular_arrival_estimation_time,
							"arrival_actual_date" => $regular_arrival_actual_date,
							"arrival_actual_time" => $regular_arrival_actual_time,
							"loading_unloading_start_date" => $regular_loading_start_date,
							"loading_unloading_start_time" => $regular_loading_start_time,
							"loading_unloading_finish_date" => $regular_loading_finish_date,
							"loading_unloading_finish_time" => $regular_loading_finish_time,
							"loading_unloading_documentation_date" => $regular_loading_documentation_date,
							"loading_unloading_documentation_time" => $regular_loading_documentation_time,
							"departure_estimation_date" => $regular_departure_actual_date,
							"departure_estimation_time" => $regular_departure_actual_time,
							"departure_actual_date" => $regular_departure_actual_date,
							"departure_actual_time" => $regular_departure_actual_time,
							"created_by" => $user,
							"created_time" => $timestamp
					);
					$res = $this->model_traffic_monitoring->insertData("traffic_monitoring_regular",$data_insert);
					
					if($res>=1)
					{
						$this->session->set_flashdata('message_success',"Data Traffic Monitoring has been successfully saved!");
						redirect('traffic_monitoring');
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
	
	
	public function deleteTrafficMonitoring()
	{
		
			date_default_timezone_set('Asia/Jakarta');
			ini_set('memory_limit', '-1');
			
			if ($this->tank_auth->is_logged_in()) {
			$user	= $this->tank_auth->get_username();
			$data_account = $this->model_account_master->getAccount("WHERE username = '".$user."' ")->result_array();
			$data_role = $this->model_account_master->getRole("WHERE id_role = '".$data_account[0]['user_access']."' ")->result_array();
			$user_role = $data_account[0]['user_type'];
			$code_role = $data_account[0]['code'];
			if($data_role[0]['delete_traffic_monitoring']=='yes')
			{
				
			
				// Get Variable Post
				$id_traffic_monitoring_delete = $_POST['id_traffic_monitoring_delete'];
				$where = array("id_traffic_monitoring" => $id_traffic_monitoring_delete);
				
		
					//Update Product
					$res = $this->model_traffic_monitoring->DeleteData("master_traffic_monitoring",$where);
					if($res>=1)
					{
						$this->session->set_flashdata('message_success',"Data traffic_monitoring has been successfully deleted!");
						redirect('traffic_monitoring');
						
						}
					else
					{
						$this->session->set_flashdata('message_failed',"Data TrafficMonitoring failed to delete!");
						redirect('traffic_monitoring');
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
	
	public function exportTrafficMonitoring()
	{
		
		date_default_timezone_set('Asia/Jakarta');
		if ($this->tank_auth->is_logged_in()) {
		$user	= $this->tank_auth->get_username();
		$data_account = $this->model_account_master->getAccount("WHERE username = '".$user."' ")->result_array();
		$data_role = $this->model_account_master->getRole("WHERE id_role = '".$data_account[0]['user_access']."' ")->result_array();
		$user_role = $data_account[0]['user_type'];
		$code_role = $data_account[0]['code'];
		
		if($data_role[0]['export_traffic_monitoring']=='yes')
		{
		$search = isset($_GET['search']) ? $_GET['search'] : '';

		
		$date = date("m-d-Y");
		$this->db->or_like('traffic_monitoring_code', $search);
		$query = $this->db->get('traffic_monitoring');
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
		
		
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 1, "Master TrafficMonitoring");
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
		"TrafficMonitoring Code" => "TrafficMonitoring Code",
		"TrafficMonitoring Name" => "TrafficMonitoring Name"
		
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
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $row, $data['traffic_monitoring_code']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $row, $data['traffic_monitoring_name']);
 
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
        header('Content-Disposition: attachment;filename="Master-traffic_monitoring-'.$date.'.xls"');
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
	
	public function importTrafficMonitoring()
	{
		
			date_default_timezone_set('Asia/Jakarta');
			ini_set('memory_limit', '-1');
			
			if ($this->tank_auth->is_logged_in()) {
			$user	= $this->tank_auth->get_username();
			$data_account = $this->model_account_master->getAccount("WHERE username = '".$user."' ")->result_array();
			$data_role = $this->model_account_master->getRole("WHERE id_role = '".$data_account[0]['user_access']."' ")->result_array();
			$user_role = $data_account[0]['user_type'];
			$code_role = $data_account[0]['code'];
			
			if($data_role[0]['import_traffic_monitoring']=='yes')
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
				redirect('traffic_monitoring');
				
				
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
					$check = $this->model_traffic_monitoring->getTrafficMonitoring("WHERE traffic_monitoring_code  = '".$rowData[0][0]."' ");
					if($check->num_rows() >=1 )
					{
						
						$data_update = array(
							"traffic_monitoring_name" => $rowData[0][1],
							"password" => md5($rowData[0][2])
							
						);
						$where = array(
							"traffic_monitoring_code" => $rowData[0][0]
						);
						
						$res = $this->model_traffic_monitoring->UpdateData("traffic_monitoring",$data_update,$where);
					
						}
					else
					{
						$data_insert = array(
							"traffic_monitoring_code" => $rowData[0][0],
							"traffic_monitoring_name" => $rowData[0][1],
							"password" => md5($rowData[0][2])
						);
						
						//Insert Data
						$res = $this->model_traffic_monitoring->insertData("traffic_monitoring",$data_insert);
					
					}
					
				
				
			}
				@unlink($inputFileName);
				$this->session->set_flashdata('message_success','Data imported successfully');
				redirect('traffic_monitoring');
			
               
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
	
	public function addTrafficMonitoring()
	{
		
			date_default_timezone_set('Asia/Jakarta');
			ini_set('memory_limit', '-1');
			
			if ($this->tank_auth->is_logged_in()) {
			$user	= $this->tank_auth->get_username();
			$data_account = $this->model_account_master->getAccount("WHERE username = '".$user."' ")->result_array();
			$data_role = $this->model_account_master->getRole("WHERE id_role = '".$data_account[0]['user_access']."' ")->result_array();
			$user_role = $data_account[0]['user_type'];
			$code_role = $data_account[0]['code'];
			
			if($data_role[0]['add_traffic_monitoring']=='yes')
			{
				
			
				// Get Variable Post
				$timestamp = date('Y:m:d H:i:s');
				$username = $user;
				$spk_number = $_POST['spk_number'];
				$manifest = $_POST['manifest'];
				$order_type = $_POST['order_type'];
				$do_number = $_POST['do_number'];
				$traffic_monitoring_type = $_POST['traffic_monitoring_type'];
				$description = $_POST['description'];
				$location = $_POST['location'];
				
			
				
				$data_insert = array(
				
					"spk_number" => $spk_number,
					"order_type" => $order_type,
					"type_traffic" => $order_type,
					"manifest" => $manifest,
					"do_number" => $do_number,
					"description" => $description,
					"landing_location" => $order_type,
					"input_method" => 'backend',
					"created_by" => $user,
					"created_date" => $timestamp

				);
				
				//Check Product Apakah sudah ada dengan kode produk dan type motorist yang sama
				
					$check = $this->model_traffic_monitoring->getTrafficMonitoring("WHERE spk_number = '".$spk_number."' AND order_type = '".$order_type."' AND type_traffic = '".$traffic_monitoring_type."' ");
					if($check->num_rows() >=1 )
					{
						//$this->session->set_flashdata('message_failed',"Sorry data already exist!");
						//redirect('traffic_monitoring');
						
						}
					else
					{
					
						$res = $this->model_traffic_monitoring->insertData("traffic_monitoring",$data_insert);
						if($res>=1)
						{
							$this->session->set_flashdata('message_success',"Data Traffic Monitoring has been successfully saved!");
							redirect('traffic_monitoring');
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
			
			if($data_role[0]['see_traffic_monitoring']=='yes')
			{	
			$this->load->library('table');
			$this->load->library('pagination');
			$search = isset($_GET['search']) ? $_GET['search'] : '';
			
			
			$jumlah= $this->model_traffic_monitoring->countTrafficMonitoring($search);
			
			if (count($_GET) > 0) $config['suffix'] = '?' . http_build_query($_GET, '', "&");
			$config['base_url'] = base_url().'index.php/traffic_monitoring/traffic_monitoring/';
			$config['total_rows'] = $jumlah;
			$config['first_link'] = 'First';
			$config['last_link'] = 'End';
			$config['next_link'] = 'Next';
			$config['prev_link'] = 'Previous';
			$config['per_page'] = 5; 	
			if (count($_GET) > 0) $config['suffix'] = '?' . http_build_query($_GET, '', "&");
			$config['first_url'] = $config['base_url'].'?'.http_build_query($_GET);
			
			$dari = $this->uri->segment('3');
			$data = $this->model_traffic_monitoring->dataTrafficMonitoring($config['per_page'],$dari,$search);
			$this->pagination->initialize($config);
		
			$comp = array(
				'title' => ' TrafficMonitoring',
				'content' => $this->load->view('traffic_monitoring',array('data_traffic_monitoring'=>$data,'data_role'=>$data_role,'search'=>$search),true),
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