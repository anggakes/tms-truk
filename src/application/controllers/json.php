<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class json extends CI_Controller {

	function __construct()  {
 		parent::__construct();
			$this->load->library(array('PHPExcel','PHPExcel/IOFactory'));
			$this->load->model('model_account_master');
			$this->load->model('model_json');
			$this->load->library('tank_auth');
			
	}
	
	
	public function jsonJobNumber()
	{
			date_default_timezone_set('Asia/Jakarta');
			ini_set('memory_limit', '-1');
			
			if ($this->tank_auth->is_logged_in()) {
			$job_number = isset($_GET['term']) ? $_GET['term'] : '';
			$data_job_number = $this->model_json->dataJobNumber($job_number);
			$return_arr = array();
			
			
				foreach($data_job_number as $data_job_number)
				{
					$row_array['value'] = $data_job_number->id_trucking_order;
					$row_array['label'] = $data_job_number->id_trucking_order.' - '.$data_job_number->vehicle_type;
					
					$row_array['id_detail_trucking_order'] = $data_job_number->id_detail_trucking_order;
					$row_array['client_id'] = $data_job_number->client_id;
					$row_array['client_name'] = $data_job_number->client_name;
					$row_array['origin'] = $data_job_number->origin;
					$row_array['origin_address'] = $data_job_number->origin_address;
					$row_array['origin_area'] = $data_job_number->origin_area;
					$row_array['destination'] = $data_job_number->destination;
					$row_array['destination_address'] = $data_job_number->destination_address;
					$row_array['destination_area'] = $data_job_number->destination_area;
					
					
					array_push($return_arr,$row_array);
				}
				
			echo json_encode($return_arr);
			
			}
			else
			{
				redirect('/auth/login/');
				}
			
	}
	
	public function jsonPOD()
	{
			date_default_timezone_set('Asia/Jakarta');
			ini_set('memory_limit', '-1');
			
			if ($this->tank_auth->is_logged_in()) {
			$spk_number = isset($_GET['spk_number']) ? $_GET['spk_number'] : '';
			$data_pod = $this->model_json->dataJsonPOD($spk_number);
			$return_arr = array();
			
			
				foreach($data_pod as $data_pod)
				{
					$row_array['id_pod'] = $data_pod->id_pod;
					$row_array['spk_number'] = $data_pod->spk_number;
					
					$pod_date = (explode("-",$data_pod->pod_date));
					$pod_date = $pod_date[2].'-'.$pod_date[1].'-'.$pod_date[0];
					$row_array['pod_date'] = $pod_date;
					
					$row_array['pod_time'] = $data_pod->pod_time;
					$row_array['code'] = $data_pod->code;
					$row_array['pic'] = $data_pod->pic;
					
					$submit_date = (explode("-",$data_pod->submit_date));
					$submit_date = $submit_date[2].'-'.$submit_date[1].'-'.$submit_date[0];
					$row_array['submit_date'] = $submit_date;
					
					$row_array['submit_time'] = $data_pod->submit_time;
					$row_array['doc_reference'] = $data_pod->doc_reference;
					
					$receive_date = (explode("-",$data_pod->receive_date));
					$receive_date = $receive_date[2].'-'.$receive_date[1].'-'.$receive_date[0];
					$row_array['receive_date'] = $receive_date;
					
					$row_array['receive_time'] = $data_pod->receive_time;
					$row_array['receiver'] = $data_pod->receiver;
					array_push($return_arr,$row_array);
				}
				
			echo json_encode($return_arr);
			
			}
			else
			{
				redirect('/auth/login/');
				}
			
	}
	
	public function jsonRSM()
	{
			date_default_timezone_set('Asia/Jakarta');
			ini_set('memory_limit', '-1');
			
			if ($this->tank_auth->is_logged_in()) {
			$id_room_service_management = isset($_GET['id_room_service_management']) ? $_GET['id_room_service_management'] : '';
			$data_sm = $this->model_json->dataSM($id_room_service_management);
			$return_arr = array();
			
			
				foreach($data_sm as $data_sm)
				{
					$row_array['id_detail_service'] = $data_sm->id_detail_service;
					$row_array['id_room_service_management'] = $data_sm->id_room_service_management;
					$row_array['service_description'] = $data_sm->service_description;
					$row_array['spare_part'] = $data_sm->spare_part;
					$row_array['remark'] = $data_sm->remark;
					$row_array['type'] = $data_sm->type;
					array_push($return_arr,$row_array);
				}
				
			echo json_encode($return_arr);
			
			}
			else
			{
				redirect('/auth/login/');
				}
			
	}
	
		
	
	public function jsonTMLangsirEmpty()
	{
			date_default_timezone_set('Asia/Jakarta');
			ini_set('memory_limit', '-1');
			
			if ($this->tank_auth->is_logged_in()) {
			$spk_number = isset($_GET['spk_number']) ? $_GET['spk_number'] : '';
			$state = isset($_GET['state']) ? $_GET['state'] : '';
			$point_id = isset($_GET['point_id']) ? $_GET['point_id'] : '';
			$data_tm = $this->model_json->dataTMLangsirEmpty($spk_number,$state,$point_id);
			$return_arr = array();
			
			
				foreach($data_tm as $data_tm)
				{
					$row_array['id_traffic_monitoring_langsir_empty_cont'] = $data_tm->id_traffic_monitoring_langsir_empty_cont;
					$row_array['spk_number'] = $data_tm->spk_number;
					$row_array['state'] = $data_tm->state;
					$row_array['point_id'] = $data_tm->	point_id;
					$row_array['name'] = $data_tm->name;
					$row_array['address'] = $data_tm->address;
					
					$date_arrival_estimation_date = (explode("-",$data_tm->arrival_estimation_date));
					$date_arrival_estimation_date = $date_arrival_estimation_date[2].'-'.$date_arrival_estimation_date[1].'-'.$date_arrival_estimation_date[0];
					
					
					$row_array['arrival_estimation_date'] = $date_arrival_estimation_date;
					$row_array['arrival_estimation_time'] = $data_tm->arrival_estimation_time;
					
					$date_arrival_actual_date = (explode("-",$data_tm->arrival_actual_date));
					$date_arrival_actual_date = $date_arrival_actual_date[2].'-'.$date_arrival_actual_date[1].'-'.$date_arrival_actual_date[0];
					
					$row_array['arrival_actual_date'] = $data_tm->arrival_actual_date;
					$row_array['arrival_actual_time'] = $data_tm->arrival_actual_time;
					
					$date_loading_landing_start_date = (explode("-",$data_tm->loading_landing_start_date));
					$date_loading_landing_start_date = $date_loading_landing_start_date[2].'-'.$date_loading_landing_start_date[1].'-'.$date_loading_landing_start_date[0];
					$row_array['loading_landing_start_date'] = $data_tm->loading_landing_start_date;
					
					$row_array['loading_landing_start_time'] = $data_tm->loading_landing_start_time;
					
					$date_loading_landing_finish_date = (explode("-",$data_tm->loading_landing_finish_date));
					$date_loading_landing_finish_date = $date_loading_landing_finish_date[2].'-'.$date_loading_landing_finish_date[1].'-'.$date_loading_landing_finish_date[0];
					$row_array['loading_landing_finish_date'] = $data_tm->loading_landing_finish_date;
					
					$row_array['loading_landing_finish_time'] = $data_tm->loading_landing_finish_time;
					
					$date_loading_landing_documentation_date = (explode("-",$data_tm->loading_landing_documentation_date));
					$date_loading_landing_documentation_date = $date_loading_landing_documentation_date[2].'-'.$date_loading_landing_documentation_date[1].'-'.$date_loading_landing_documentation_date[0];
					$row_array['loading_landing_documentation_date'] = $date_loading_landing_documentation_date;
					
					$row_array['loading_landing_documentation_time'] = $data_tm->loading_landing_documentation_time;
					
					$date_departure_estimation_date = (explode("-",$data_tm->departure_estimation_date));
					$date_departure_estimation_date = $date_departure_estimation_date[2].'-'.$date_departure_estimation_date[1].'-'.$date_departure_estimation_date[0];
					
					$row_array['departure_estimation_date'] = $date_departure_estimation_date;
					
					
					$row_array['departure_estimation_time'] = $data_tm->departure_estimation_time;
					
					$date_departure_actual_date = (explode("-",$data_tm->departure_actual_date));
					$date_departure_actual_date = $date_departure_actual_date[2].'-'.$date_departure_actual_date[1].'-'.$date_departure_actual_date[0];
					$row_array['departure_actual_date'] = $data_tm->departure_actual_date;
					
					$row_array['departure_actual_time'] = $data_tm->departure_actual_time;
					$row_array['created_by'] = $data_tm->created_by;
					$row_array['created_time'] = $data_tm->created_time;
					$row_array['updated_by'] = $data_tm->updated_by;
					$row_array['updated_time'] = $data_tm->updated_time;
					
					
					
					
					array_push($return_arr,$row_array);
				}
				
			echo json_encode($return_arr);
			
			}
			else
			{
				redirect('/auth/login/');
				}
			
	}
	
	public function jsonTMLangsir()
	{
			date_default_timezone_set('Asia/Jakarta');
			ini_set('memory_limit', '-1');
			
			if ($this->tank_auth->is_logged_in()) {
			$spk_number = isset($_GET['spk_number']) ? $_GET['spk_number'] : '';
			$state = isset($_GET['state']) ? $_GET['state'] : '';
			$point_id = isset($_GET['point_id']) ? $_GET['point_id'] : '';
			$data_tm = $this->model_json->dataTMLangsir($spk_number,$state,$point_id);
			$return_arr = array();
			
			
				foreach($data_tm as $data_tm)
				{
					$row_array['id_traffic_monitoring_langsir'] = $data_tm->id_traffic_monitoring_langsir;
					$row_array['spk_number'] = $data_tm->spk_number;
					$row_array['state'] = $data_tm->state;
					$row_array['point_id'] = $data_tm->point_id;
					$row_array['name'] = $data_tm->name;
					$row_array['address'] = $data_tm->address;
					
					$date_arrival_estimation_date = (explode("-",$data_tm->arrival_estimation_date));
					$date_arrival_estimation_date = $date_arrival_estimation_date[2].'-'.$date_arrival_estimation_date[1].'-'.$date_arrival_estimation_date[0];
					$row_array['arrival_estimation_date'] = $date_arrival_estimation_date;
					
					$row_array['arrival_estimation_time'] = $data_tm->arrival_estimation_time;
					
					$date_arrival_actual_date = (explode("-",$data_tm->arrival_actual_date));
					$date_arrival_actual_date = $date_arrival_actual_date[2].'-'.$date_arrival_actual_date[1].'-'.$date_arrival_actual_date[0];
					$row_array['arrival_actual_date'] = $date_arrival_actual_date;
					
					$row_array['arrival_actual_time'] = $data_tm->arrival_actual_time;
					
					$date_loading_landing_start_date = (explode("-",$data_tm->loading_landing_start_date));
					$date_loading_landing_start_date = $date_loading_landing_start_date[2].'-'.$date_loading_landing_start_date[1].'-'.$date_loading_landing_start_date[0];
					$row_array['loading_landing_start_date'] = $date_loading_landing_start_date;
					
					$row_array['loading_landing_start_time'] = $data_tm->loading_landing_start_time;
					
					$date_loading_landing_finish_date = (explode("-",$data_tm->loading_landing_finish_date));
					$date_loading_landing_finish_date = $date_loading_landing_finish_date[2].'-'.$date_loading_landing_finish_date[1].'-'.$date_loading_landing_finish_date[0];
					$row_array['loading_landing_finish_date'] = $date_loading_landing_finish_date;
					
					
					$row_array['loading_landing_finish_time'] = $data_tm->loading_landing_finish_time;
					
					$date_loading_landing_documentation_date = (explode("-",$data_tm->loading_landing_documentation_date));
					$date_loading_landing_documentation_date = $date_loading_landing_documentation_date[2].'-'.$date_loading_landing_documentation_date[1].'-'.$date_loading_landing_documentation_date[0];
					$row_array['loading_landing_documentation_date'] = $date_loading_landing_documentation_date;
					
					$row_array['loading_landing_documentation_time'] = $data_tm->loading_landing_documentation_time;
					
					$date_departure_estimation_date = (explode("-",$data_tm->departure_estimation_date));
					$date_departure_estimation_date = $date_departure_estimation_date[2].'-'.$date_departure_estimation_date[1].'-'.$date_departure_estimation_date[0];
					$row_array['departure_estimation_date'] = $data_tm->departure_estimation_date;
					
					$row_array['departure_estimation_time'] = $data_tm->departure_estimation_time;
					
					$date_departure_actual_date = (explode("-",$data_tm->departure_actual_date));
					$date_departure_actual_date = $date_departure_actual_date[2].'-'.$date_departure_actual_date[1].'-'.$date_departure_actual_date[0];
					$row_array['departure_actual_date'] = $data_tm->departure_actual_date;
					
					$row_array['departure_actual_time'] = $data_tm->departure_actual_time;
					$row_array['created_by'] = $data_tm->created_by;
					$row_array['created_time'] = $data_tm->created_time;
					$row_array['updated_by'] = $data_tm->updated_by;
					$row_array['updated_time'] = $data_tm->updated_time;
					
					
					
					array_push($return_arr,$row_array);
				}
				
			echo json_encode($return_arr);
			
			}
			else
			{
				redirect('/auth/login/');
				}
			
	}
	
	public function jsonTMImport()
	{
			date_default_timezone_set('Asia/Jakarta');
			ini_set('memory_limit', '-1');
			
			if ($this->tank_auth->is_logged_in()) {
			$spk_number = isset($_GET['spk_number']) ? $_GET['spk_number'] : '';
			$state = isset($_GET['state']) ? $_GET['state'] : '';
			$point_id = isset($_GET['point_id']) ? $_GET['point_id'] : '';
			$data_tm = $this->model_json->dataTMImport($spk_number,$state,$point_id);
			$return_arr = array();
			
			
				foreach($data_tm as $data_tm)
				{
					$row_array['id_traffic_monitoring_import'] =$data_tm->id_traffic_monitoring_import;
					$row_array['spk_number'] = $data_tm->spk_number;
					$row_array['state'] = $data_tm->state;
					$row_array['point_id'] = $data_tm->point_id;
					$row_array['name'] = $data_tm->name;
					$row_array['address'] = $data_tm->address;
					
					
					$date_arrival_estimation_date = (explode("-",$data_tm->arrival_estimation_date));
					$date_arrival_estimation_date = $date_arrival_estimation_date[2].'-'.$date_arrival_estimation_date[1].'-'.$date_arrival_estimation_date[0];
					$row_array['arrival_estimation_date'] = $date_arrival_estimation_date;
					$row_array['arrival_estimation_time'] = $data_tm->arrival_estimation_time;
					
					$date_arrival_actual_date = (explode("-",$data_tm->arrival_actual_date));
					$date_arrival_actual_date = $date_arrival_actual_date[2].'-'.$date_arrival_actual_date[1].'-'.$date_arrival_actual_date[0];
					$row_array['arrival_actual_date'] = $date_arrival_actual_date;
					
					$row_array['arrival_actual_time'] = $data_tm->arrival_actual_time;
					
					$date_loading_unloading_start_date = (explode("-",$data_tm->loading_unloading_start_date));
					$date_loading_unloading_start_date = $date_loading_unloading_start_date[2].'-'.$date_loading_unloading_start_date[1].'-'.$date_loading_unloading_start_date[0];
					$row_array['loading_unloading_start_date'] = $date_loading_unloading_start_date;
					
					$row_array['loading_unloading_start_time'] = $data_tm->loading_unloading_start_time;
					
					$date_loading_unloading_finish_date = (explode("-",$data_tm->loading_unloading_finish_date));
					$date_loading_unloading_finish_date = $date_loading_unloading_finish_date[2].'-'.$date_loading_unloading_finish_date[1].'-'.$date_loading_unloading_finish_date[0];
					$row_array['loading_unloading_finish_date'] = $date_loading_unloading_finish_date;
					
					
					$date_loading_unloading_documentation_date = (explode("-",$data_tm->loading_unloading_documentation_date));
					$date_loading_unloading_documentation_date = $date_loading_unloading_documentation_date[2].'-'.$date_loading_unloading_documentation_date[1].'-'.$date_loading_unloading_documentation_date[0];
					
					$row_array['loading_unloading_documentation_date'] = $date_loading_unloading_documentation_date;
					$row_array['loading_unloading_documentation_time'] = $data_tm->loading_unloading_documentation_time;
					
					$date_departure_estimation_date = (explode("-",$data_tm->departure_estimation_date));
					$date_departure_estimation_date = $date_departure_estimation_date[2].'-'.$date_departure_estimation_date[1].'-'.$date_departure_estimation_date[0];
					
					$row_array['departure_estimation_date'] = $date_departure_estimation_date;
					
					$row_array['departure_estimation_time'] = $data_tm->departure_estimation_time;
					
					$date_departure_actual_date = (explode("-",$data_tm->departure_actual_date));
					$date_departure_actual_date = $date_departure_actual_date[2].'-'.$date_departure_actual_date[1].'-'.$date_departure_actual_date[0];
					
					$row_array['departure_actual_date'] = $date_departure_actual_date;
					$row_array['departure_actual_time'] = $data_tm->departure_actual_time;
					$row_array['created_by'] = $data_tm->created_by;
					$row_array['created_time'] = $data_tm->created_time;
					$row_array['updated_by'] = $data_tm->updated_by;
					$row_array['updated_time'] = $data_tm->updated_time;
					
					$date_landing_container_estimation_date = (explode("-",$data_tm->landing_container_estimation_date));
					$date_landing_container_estimation_date = $date_landing_container_estimation_date[2].'-'.$date_landing_container_estimation_date[1].'-'.$date_landing_container_estimation_date[0];
					
					$row_array['landing_container_estimation_date'] = $date_landing_container_estimation_date;
					$row_array['landing_container_estimation_time'] = $data_tm->landing_container_estimation_time;
					
					$date_landing_container_actual_date = (explode("-",$data_tm->landing_container_actual_date));
					$date_landing_container_actual_date = $date_landing_container_actual_date[2].'-'.$date_landing_container_actual_date[1].'-'.$date_landing_container_actual_date[0];
					
					$row_array['landing_container_actual_date'] = $date_landing_container_actual_date;
					$row_array['landing_container_actual_time'] = $data_tm->landing_container_actual_time;
					$row_array['landing_location'] = $data_tm->landing_location;
					
					
					array_push($return_arr,$row_array);
				}
				
			echo json_encode($return_arr);
			
			}
			else
			{
				redirect('/auth/login/');
				}
			
	}
	
	
	
	public function jsonTMExport()
	{
			date_default_timezone_set('Asia/Jakarta');
			ini_set('memory_limit', '-1');
			
			if ($this->tank_auth->is_logged_in()) {
			$spk_number = isset($_GET['spk_number']) ? $_GET['spk_number'] : '';
			$state = isset($_GET['state']) ? $_GET['state'] : '';
			$point_id = isset($_GET['point_id']) ? $_GET['point_id'] : '';
			$data_tm = $this->model_json->dataTMExport($spk_number,$state,$point_id);
			$return_arr = array();
			
			
				foreach($data_tm as $data_tm)
				{
					$row_array['id_traffic_monitoring_export'] = $data_tm->id_traffic_monitoring_export;
					$row_array['spk_number'] = $data_tm->spk_number;
					$row_array['state'] = $data_tm->state;
					$row_array['point_id'] = $data_tm->point_id;
					$row_array['name'] = $data_tm->name;
					$row_array['address'] = $data_tm->address;
					
					$date_arrival_estimation_date = (explode("-",$data_tm->arrival_estimation_date));
					$date_arrival_estimation_date = $date_arrival_estimation_date[2].'-'.$date_arrival_estimation_date[1].'-'.$date_arrival_estimation_date[0];
					$row_array['arrival_estimation_date'] = $date_arrival_estimation_date;
					
					$row_array['arrival_estimation_time'] = $data_tm->arrival_estimation_time;
					
					$date_arrival_actual_date = (explode("-",$data_tm->arrival_actual_date));
					$date_arrival_actual_date = $date_arrival_actual_date[2].'-'.$date_arrival_actual_date[1].'-'.$date_arrival_actual_date[0];
					$row_array['arrival_actual_date'] = $date_arrival_actual_date;
					
					$row_array['arrival_actual_time'] = $data_tm->arrival_actual_time;
					
					$date_loading_empty_cont_documentation_date = (explode("-",$data_tm->loading_empty_cont_documentation_date));
					$date_loading_empty_cont_documentation_date = $date_loading_empty_cont_documentation_date[2].'-'.$date_loading_empty_cont_documentation_date[1].'-'.$date_loading_empty_cont_documentation_date[0];
					$row_array['loading_empty_cont_documentation_date'] = $date_loading_empty_cont_documentation_date;
					
					$row_array['loading_empty_cont_documentation_time	'] = $data_tm->loading_empty_cont_documentation_time;
					
					$date_loading_empty_cont_start_date = (explode("-",$data_tm->loading_empty_cont_start_date));
					$date_loading_empty_cont_start_date = $date_loading_empty_cont_start_date[2].'-'.$date_loading_empty_cont_start_date[1].'-'.$date_loading_empty_cont_start_date[0];
					$row_array['loading_empty_cont_start_date'] = $date_loading_empty_cont_start_date;
					
					$row_array['loading_empty_cont_start_time'] = $data_tm->loading_empty_cont_start_time;
					
					$date_loading_empty_cont_finish_date = (explode("-",$data_tm->loading_empty_cont_finish_date));
					$date_loading_empty_cont_finish_date = $date_loading_empty_cont_finish_date[2].'-'.$date_loading_empty_cont_finish_date[1].'-'.$date_loading_empty_cont_finish_date[0];
					$row_array['loading_empty_cont_finish_date'] = $date_loading_empty_cont_finish_date;
					
					
					$row_array['loading_empty_cont_finish_time'] = $data_tm->loading_empty_cont_finish_time;
					
					$date_loading_product_documentation_date = (explode("-",$data_tm->loading_product_documentation_date));
					$date_loading_product_documentation_date = $date_loading_product_documentation_date[2].'-'.$date_loading_product_documentation_date[1].'-'.$date_loading_product_documentation_date[0];
					$row_array['loading_product_documentation_date'] = $date_loading_product_documentation_date;
					
					$row_array['loading_product_documentation_time'] = $data_tm->loading_product_documentation_time;
					
					$date_loading_product_start_date = (explode("-",$data_tm->loading_product_start_date));
					$date_loading_product_start_date = $date_loading_product_start_date[2].'-'.$date_loading_product_start_date[1].'-'.$date_loading_product_start_date[0];
					
					$row_array['loading_product_start_date'] = $data_tm->loading_product_start_date;
					$row_array['loading_product_start_time'] = $data_tm->loading_product_start_time;
					
					$date_loading_product_finish_date = (explode("-",$data_tm->loading_product_finish_date));
					$date_loading_product_finish_date = $date_loading_product_finish_date[2].'-'.$date_loading_product_finish_date[1].'-'.$date_loading_product_finish_date[0];
					$row_array['loading_product_finish_date'] = $date_loading_product_finish_date;
					
					$row_array['loading_product_finish_time'] = $data_tm->loading_product_finish_time;
					
					$date_departure_estimation_date = (explode("-",$data_tm->departure_estimation_date));
					$date_departure_estimation_date = $date_departure_estimation_date[2].'-'.$date_departure_estimation_date[1].'-'.$date_departure_estimation_date[0];
					
					$row_array['departure_estimation_date'] = $date_departure_estimation_date;
					
					$row_array['departure_estimation_time'] = $data_tm->departure_estimation_time;
					
					$date_departure_actual_date = (explode("-",$data_tm->departure_actual_date));
					$date_departure_actual_date = $date_departure_actual_date[2].'-'.$date_departure_actual_date[1].'-'.$date_departure_actual_date[0];
					$row_array['departure_actual_date'] = $date_departure_actual_date;
					
					$row_array['departure_actual_time'] = $data_tm->departure_actual_time;
					
					$date_landing_cont_estimation_date = (explode("-",$data_tm->landing_cont_estimation_date));
					$date_landing_cont_estimation_date = $date_landing_cont_estimation_date[2].'-'.$date_landing_cont_estimation_date[1].'-'.$date_landing_cont_estimation_date[0];
					$row_array['landing_cont_estimation_date'] = $date_landing_cont_estimation_date;
					
					$row_array['landing_cont_estimation_time'] = $data_tm->landing_cont_estimation_time;
					
					$date_landing_cont_actual_date = (explode("-",$data_tm->landing_cont_actual_date));
					$date_landing_cont_actual_date = $date_landing_cont_actual_date[2].'-'.$date_landing_cont_actual_date[1].'-'.$date_landing_cont_actual_date[0];
					
					$row_array['landing_cont_actual_date'] = $data_tm->landing_cont_actual_date;
					$row_array['landing_location'] = $data_tm->landing_location;
					
					$row_array['landing_cont_actual_time'] = $data_tm->landing_cont_actual_time;
					$row_array['created_by'] = $data_tm->created_by;
					$row_array['created_time'] = $data_tm->created_time;
					$row_array['updated_by'] = $data_tm->updated_by;
					$row_array['updated_time'] = $data_tm->updated_time;
					
					
					
					array_push($return_arr,$row_array);
				}
				
			echo json_encode($return_arr);
			
			}
			else
			{
				redirect('/auth/login/');
				}
			
	}
	
	public function jsonTMRegular()
	{
			date_default_timezone_set('Asia/Jakarta');
			ini_set('memory_limit', '-1');
			
			if ($this->tank_auth->is_logged_in()) {
			$spk_number = isset($_GET['spk_number']) ? $_GET['spk_number'] : '';
			$state = isset($_GET['state']) ? $_GET['state'] : '';
			$point_id = isset($_GET['point_id']) ? $_GET['point_id'] : '';
			$data_tm = $this->model_json->dataTMRegular($spk_number,$state,$point_id);
			$return_arr = array();
			
			
				foreach($data_tm as $data_tm)
				{
					$row_array['id_traffic_monitoring_regular'] = $data_tm->id_traffic_monitoring_regular;
					$row_array['spk_number'] = $data_tm->spk_number;
					$row_array['state'] = $data_tm->state;
					$row_array['point_id'] = $data_tm->point_id;
					$row_array['name'] = $data_tm->	name;
					$row_array['address'] = $data_tm->address;
					
					$date_arrival_estimation_date = (explode("-",$data_tm->arrival_estimation_date));
					$date_arrival_estimation_date = $date_arrival_estimation_date[2].'-'.$date_arrival_estimation_date[1].'-'.$date_arrival_estimation_date[0];
					$row_array['arrival_estimation_date'] = $date_arrival_estimation_date;
					
					$row_array['arrival_estimation_time'] = $data_tm->arrival_estimation_time;
					
					$date_arrival_actual_date = (explode("-",$data_tm->arrival_actual_date));
					$date_arrival_actual_date = $date_arrival_actual_date[2].'-'.$date_arrival_actual_date[1].'-'.$date_arrival_actual_date[0];
					$row_array['arrival_actual_date'] = $date_arrival_actual_date;
					
					$row_array['arrival_actual_time'] = $data_tm->arrival_actual_time;
					
					$date_loading_unloading_start_date = (explode("-",$data_tm->loading_unloading_start_date));
					$date_loading_unloading_start_date = $date_loading_unloading_start_date[2].'-'.$date_loading_unloading_start_date[1].'-'.$date_loading_unloading_start_date[0];
					$row_array['loading_unloading_start_date'] = $date_loading_unloading_start_date;
					
					
					$row_array['loading_unloading_start_time'] = $data_tm->loading_unloading_start_time;
					
					$date_loading_unloading_finish_date = (explode("-",$data_tm->loading_unloading_finish_date));
					$date_loading_unloading_finish_date = $date_loading_unloading_finish_date[2].'-'.$date_loading_unloading_finish_date[1].'-'.$date_loading_unloading_finish_date[0];
					
					$row_array['loading_unloading_finish_date'] = $date_loading_unloading_finish_date;
					
					$row_array['loading_unloading_finish_time'] = $data_tm->loading_unloading_finish_time;
					
					$date_loading_unloading_documentation_date = (explode("-",$data_tm->loading_unloading_documentation_date));
					$date_loading_unloading_documentation_date = $date_loading_unloading_documentation_date[2].'-'.$date_loading_unloading_documentation_date[1].'-'.$date_loading_unloading_documentation_date[0];
					
					$row_array['loading_unloading_documentation_date'] = $date_loading_unloading_documentation_date;
					
					$row_array['loading_unloading_documentation_time'] = $data_tm->loading_unloading_documentation_time;
					
					$date_departure_estimation_date = (explode("-",$data_tm->departure_estimation_date));
					$date_departure_estimation_date = $date_departure_estimation_date[2].'-'.$date_departure_estimation_date[1].'-'.$date_departure_estimation_date[0];
					
					$row_array['departure_estimation_date'] = $date_departure_estimation_date;
					
					
					$row_array['departure_estimation_time'] = $data_tm->departure_estimation_time;
					
					$date_departure_actual_date = (explode("-",$data_tm->departure_actual_date));
					$date_departure_actual_date = $date_departure_actual_date[2].'-'.$date_departure_actual_date[1].'-'.$date_departure_actual_date[0];
					
					$row_array['departure_actual_date'] = $date_departure_actual_date;
					
					$row_array['departure_actual_time'] = $data_tm->departure_actual_time;
					$row_array['created_by'] = $data_tm->created_by;
					$row_array['created_time'] = $data_tm->created_time;
					$row_array['updated_by'] = $data_tm->updated_by;
					$row_array['updated_time'] = $data_tm->updated_time;
					
					
					array_push($return_arr,$row_array);
				}
				
			echo json_encode($return_arr);
			
			}
			else
			{
				redirect('/auth/login/');
				}
			
	}
	
	
	public function jsonDetailManifest()
	{
			date_default_timezone_set('Asia/Jakarta');
			ini_set('memory_limit', '-1');
			
			if ($this->tank_auth->is_logged_in()) {
			$id_manifest = isset($_GET['id_manifest']) ? $_GET['id_manifest'] : '';
			$data_manifest = $this->model_json->dataDetailManifest($id_manifest);
			$return_arr = array();
			
			
				foreach($data_manifest as $data_manifest)
				{
					$row_array['id_manifest'] = $data_manifest->id_manifest;
					$row_array['trip'] = $data_manifest->trip;
					$delivery_date = explode('-',$data_manifest->delivery_date);
					$delivery_date = $delivery_date[2].'-'.$delivery_date[1].'-'.$delivery_date[0];
					$row_array['delivery_date'] = $delivery_date;
					
					array_push($return_arr,$row_array);
				}
				
			echo json_encode($return_arr);
			
			}
			else
			{
				redirect('/auth/login/');
				}
			
	}
	
	
	public function jsonTruckingOrder()
	{
			date_default_timezone_set('Asia/Jakarta');
			ini_set('memory_limit', '-1');
			
			if ($this->tank_auth->is_logged_in()) {
			$id_trucking_order = isset($_GET['term']) ? $_GET['term'] : '';
			$data_trucking_order = $this->model_json->dataTruckingOrder($id_trucking_order);
			$return_arr = array();
			
			
				foreach($data_trucking_order as $data_trucking_order)
				{
					$row_array['value'] = $data_trucking_order->id_trucking_order;
					$row_array['label'] = $data_trucking_order->id_trucking_order;
					$row_array['id_trucking_order '] = $data_trucking_order->id_trucking_order;
					array_push($return_arr,$row_array);
					
					
				}
				
			echo json_encode($return_arr);
			
			}
			else
			{
				redirect('/auth/login/');
				}
			
	}
	
	
	public function jsonTmsCostInvoice()
	{
			date_default_timezone_set('Asia/Jakarta');
			ini_set('memory_limit', '-1');
			
			if ($this->tank_auth->is_logged_in()) {
			$id_pi = isset($_GET['term']) ? $_GET['term'] : '';
			$data_tms_invoice= $this->model_json->dataTmsCostInvoice($id_pi);
			$return_arr = array();
			
			
				foreach($data_tms_invoice as $data_tms_invoice)
				{
					
					$row_array['id_purchase_additional'] = $data_tms_invoice->id_purchase_additional;
					$row_array['id_invoice'] = $data_tms_invoice->id_invoice;
					$row_array['additional_type'] = $data_tms_invoice->additional_type;
					$row_array['manifest'] = $data_tms_invoice->manifest;
					$row_array['delivery_date'] = $data_tms_invoice->delivery_date;
					$row_array['trip'] = $data_tms_invoice->trip;
					$row_array['amount_to_client'] = $data_tms_invoice->amount_to_client;
					$row_array['amount_to_transporter'] = $data_tms_invoice->amount_to_transporter;
					$row_array['timestamp'] = $data_tms_invoice->timestamp;
					array_push($return_arr,$row_array);
					
					
				}
				
			echo json_encode($return_arr);
			
			}
			else
			{
				redirect('/auth/login/');
				}
			
	}
	
	public function jsonTmsInvoice()
	{
			date_default_timezone_set('Asia/Jakarta');
			ini_set('memory_limit', '-1');
			
			if ($this->tank_auth->is_logged_in()) {
			$id_pi = isset($_GET['term']) ? $_GET['term'] : '';
			$data_tms_invoice= $this->model_json->dataTmsInvoice($id_pi);
			$return_arr = array();
			
			
				foreach($data_tms_invoice as $data_tms_invoice)
				{
					
					$row_array['id_purchase_tms'] = $data_tms_invoice->id_purchase_tms;
					$row_array['id_invoice'] = $data_tms_invoice->id_invoice;
					$row_array['manifest'] = $data_tms_invoice->manifest;
					$row_array['delivery_date'] = $data_tms_invoice->delivery_date;
					$row_array['client_id'] = $data_tms_invoice->client_id;
					$row_array['client_name'] = $data_tms_invoice->client_name;
					$row_array['origin'] = $data_tms_invoice->origin;
					$row_array['destination'] = $data_tms_invoice->destination;
					$row_array['origin_id'] = $data_tms_invoice->origin_id;
					$row_array['destination_id'] = $data_tms_invoice->destination_id;
					$row_array['cost'] = $data_tms_invoice->cost;
					
					array_push($return_arr,$row_array);
					
					
				}
				
			echo json_encode($return_arr);
			
			}
			else
			{
				redirect('/auth/login/');
				}
			
	}

	
	public function jsonProductInvoice()
	{
			date_default_timezone_set('Asia/Jakarta');
			ini_set('memory_limit', '-1');
			
			if ($this->tank_auth->is_logged_in()) {
			$id_pi = isset($_GET['term']) ? $_GET['term'] : '';
			$data_product_invoice = $this->model_json->dataProductPi($id_pi);
			$return_arr = array();
			
			
				foreach($data_product_invoice as $data_product_invoice)
				{
					
					$row_array['id_product_orders_invoice'] = $data_product_invoice->id_product_orders_invoice;
					$row_array['id_product'] = $data_product_invoice->id_product;
					$row_array['product_code'] = $data_product_invoice->product_code;
					$row_array['price'] = $data_product_invoice->price;
					$row_array['price_total'] = $data_product_invoice->price_total;
					$row_array['id_invoice'] = $data_product_invoice->id_invoice;
					$row_array['product_name'] = $data_product_invoice->product_name;
					$row_array['qty'] = $data_product_invoice->qty;
					$row_array['time_stamp'] = $data_product_invoice->time_stamp;
					
					array_push($return_arr,$row_array);
					
					
				}
				
			echo json_encode($return_arr);
			
			}
			else
			{
				redirect('/auth/login/');
				}
			
	}
	
	
	public function jsonAdditionalCostManifestPi()
	{
			date_default_timezone_set('Asia/Jakarta');
			ini_set('memory_limit', '-1');
			
			if ($this->tank_auth->is_logged_in()) {
			$id_manifest = isset($_GET['id_manifest']) ? $_GET['id_manifest'] : '';
			$data_manifest = $this->model_json->dataAdditionalCostManifestPi($id_manifest);
			$return_arr = array();
			
			
				foreach($data_manifest as $data_manifest)
				{
					$row_array['additional_type'] = $data_manifest->additional_type;
					$row_array['manifest'] = $data_manifest->manifest;
					$row_array['delivery_date'] = $data_manifest->delivery_date;
					$row_array['trip'] = $data_manifest->trip;
					$row_array['amount_to_client'] = $data_tms_invoice->amount_to_client;
					$row_array['amount_to_transporter'] = $data_tms_invoice->amount_to_transporter;
					$row_array['description'] = $data_manifest->description;
					$row_array['timestamp'] = $data_manifest->timestamp;
					
					
					array_push($return_arr,$row_array);
				}
				
			echo json_encode($return_arr);
			
			}
			else
			{
				redirect('/auth/login/');
				}
			
	}
	
	
	public function jsonDetailManifestPi()
	{
			date_default_timezone_set('Asia/Jakarta');
			ini_set('memory_limit', '-1');
			
			if ($this->tank_auth->is_logged_in()) {
			$id_manifest = isset($_GET['id_manifest']) ? $_GET['id_manifest'] : '';
			$data_manifest = $this->model_json->dataDetailManifestPi($id_manifest);
			$return_arr = array();
			
			
				foreach($data_manifest as $data_manifest)
				{
					$row_array['id_manifest'] = $data_manifest->id_manifest;
					$row_array['origin_id'] = $data_manifest->origin_id;
					$row_array['origin_area'] = $data_manifest->origin_area;
					$row_array['origin_address'] = $data_manifest->origin_address;
					$row_array['destination_id'] = $data_manifest->destination_id;
					$row_array['destination_area'] = $data_manifest->destination_area;
					$row_array['destination_address'] = $data_manifest->destination_address;
					$row_array['client_id'] = $data_manifest->client_id;
					$row_array['client_name'] = $data_manifest->client_name;
					$row_array['rate'] = $data_manifest->rate;
					$row_array['client_rate'] = $data_manifest->client_rate;
					
					array_push($return_arr,$row_array);
				}
				
			echo json_encode($return_arr);
			
			}
			else
			{
				redirect('/auth/login/');
				}
			
	}
	
	public function jsonManifestPi()
	{
			date_default_timezone_set('Asia/Jakarta');
			ini_set('memory_limit', '-1');
			
			if ($this->tank_auth->is_logged_in()) {
			$id_manifest = isset($_GET['term']) ? $_GET['term'] : '';
			$data_manifest = $this->model_json->dataManifestPi($id_manifest);
			$return_arr = array();
			
			
				foreach($data_manifest as $data_manifest)
				{
					
					$row_array['value'] = "ID Manifest => ".$data_manifest->id_manifest;
					$row_array['id_manifest'] = $data_manifest->id_manifest;
					array_push($return_arr,$row_array);
				}
				
			echo json_encode($return_arr);
			
			}
			else
			{
				redirect('/auth/login/');
				}
			
	}
	
	
	public function jsonProductIoInvoice()
	{
			date_default_timezone_set('Asia/Jakarta');
			ini_set('memory_limit', '-1');
			
			if ($this->tank_auth->is_logged_in()) {
			$id_io = isset($_GET['id_io']) ? $_GET['id_io'] : '';
			$data_product_io = $this->model_json->dataProductInvoice($id_io);
			$return_arr = array();
			
			
				foreach($data_product_io as $data_product_io)
				{
					
					
					
					$row_array['id_product_orders_io'] = $data_product_io->id_product_orders_io;
					$row_array['id_product'] = $data_product_io->id_product;
					$row_array['product_code'] = $data_product_io->product_code;
					$row_array['price'] = $data_product_io->price;
					$row_array['product_name'] = $data_product_io->product_name;
					$row_array['id_io'] = $data_product_io->id_io;
					$row_array['qty'] = $data_product_io->qty;
					$row_array['qty_approved'] = $data_product_io->qty_approved;
					$row_array['id_location'] = $data_product_io->id_location;
					$row_array['location_code'] = $data_product_io->location_code;
					$row_array['warehouse_code'] = $data_product_io->warehouse_code;
					$row_array['location_type'] = $data_product_io->location_type;
					$row_array['status_approved'] = $data_product_io->status_approved;
					
					array_push($return_arr,$row_array);
					
					
				}
				
			echo json_encode($return_arr);
			
			}
			else
			{
				redirect('/auth/login/');
				}
			
	}
	
	
	public function jsonIo()
	{
			date_default_timezone_set('Asia/Jakarta');
			ini_set('memory_limit', '-1');
			
			if ($this->tank_auth->is_logged_in()) {
			$id_po = isset($_GET['term']) ? $_GET['term'] : '';
			$data_io = $this->model_json->dataIo($id_po);
			$return_arr = array();
			
			
				foreach($data_io as $data_io)
				{
					
					$row_array['value'] = "ID IO => ".$data_io->id_io;
					$row_array['id_io'] = $data_io->id_io;
					array_push($return_arr,$row_array);
				}
				
			echo json_encode($return_arr);
			
			}
			else
			{
				redirect('/auth/login/');
				}
			
	}
	
	
	public function jsonProductIo()
	{
			date_default_timezone_set('Asia/Jakarta');
			ini_set('memory_limit', '-1');
			
			if ($this->tank_auth->is_logged_in()) {
			$id_io = isset($_GET['id_io']) ? $_GET['id_io'] : '';
			$data_product_io = $this->model_json->dataProductIo($id_io);
			$return_arr = array();
			
			
				foreach($data_product_io as $data_product_io)
				{
					
					
					
					$row_array['id_product_orders_io'] = $data_product_io->id_product_orders_io;
					$row_array['id_product'] = $data_product_io->id_product;
					$row_array['product_code'] = $data_product_io->product_code;
					$row_array['price'] = $data_product_io->price;
					$row_array['product_name'] = $data_product_io->product_name;
					$row_array['id_io'] = $data_product_io->id_io;
					$row_array['qty'] = $data_product_io->qty;
					$row_array['qty_approved'] = $data_product_io->qty_approved;
					$row_array['id_location'] = $data_product_io->id_location;
					$row_array['location_code'] = $data_product_io->location_code;
					$row_array['warehouse_code'] = $data_product_io->warehouse_code;
					$row_array['location_type'] = $data_product_io->location_type;
					$row_array['status_approved'] = $data_product_io->status_approved;
					
					array_push($return_arr,$row_array);
					
					
				}
				
			echo json_encode($return_arr);
			
			}
			else
			{
				redirect('/auth/login/');
				}
			
	}
	
	
	public function jsonInventoryList()
	{
			date_default_timezone_set('Asia/Jakarta');
			ini_set('memory_limit', '-1');
			
			if ($this->tank_auth->is_logged_in()) {
			$search = isset($_GET['term']) ? $_GET['term'] : '';
			$data_inventory_list = $this->model_json->dataInventoryList($search);
			$return_arr = array();
			
			
				foreach($data_inventory_list as $data_inventory_list)
				{
					$row_array['label'] = "Product => ".$data_inventory_list->product_code." - ".$data_inventory_list->product_description." Warehouse Code => ".$data_inventory_list->warehouse_code." Stock => ".$data_inventory_list->stock;
					$row_array['id_inventory_list'] = $data_inventory_list->id_inventory_list;
					$row_array['id_location'] = $data_inventory_list->id_location;
					$row_array['id_product'] = $data_inventory_list->id_product;
					$row_array['stock'] = $data_inventory_list->stock;
					$row_array['product_name'] = $data_inventory_list->product_name;
					$row_array['product_code'] = $data_inventory_list->product_code;
					$row_array['location_code'] = $data_inventory_list->location_code;
					$row_array['warehouse_code'] = $data_inventory_list->warehouse_code;
					$row_array['location_type'] = $data_inventory_list->location_type;
					$row_array['price'] = $data_inventory_list->price;
					
					
					
					array_push($return_arr,$row_array);
					
					
				}
				
			echo json_encode($return_arr);
			
			}
			else
			{
				redirect('/auth/login/');
				}
			
	}
	
	
	public function jsonProductGr()
	{
			date_default_timezone_set('Asia/Jakarta');
			ini_set('memory_limit', '-1');
			
			if ($this->tank_auth->is_logged_in()) {
			$id_gr = isset($_GET['id_gr']) ? $_GET['id_gr'] : '';
			$data_product_gr = $this->model_json->dataProductGr($id_gr);
			$return_arr = array();
			
			
				foreach($data_product_gr as $data_product_gr)
				{
					
					$row_array['id_product_orders_gr'] = $data_product_gr->id_product_orders_gr;
					$row_array['id_product'] = $data_product_gr->id_product;
					$row_array['product_code'] = $data_product_gr->product_code;
					$row_array['price'] = $data_product_gr->price;
					$row_array['product_name'] = $data_product_gr->product_name;
					$row_array['id_gr'] = $data_product_gr->id_gr;
					$row_array['qty'] = $data_product_gr->qty;
					$row_array['qty_received'] = $data_product_gr->qty_received;
					$row_array['id_location'] = $data_product_gr->id_location;
					
					array_push($return_arr,$row_array);
					
					
				}
				
			echo json_encode($return_arr);
			
			}
			else
			{
				redirect('/auth/login/');
				}
			
	}
	
	
	public function jsonLocationGr()
	{
			date_default_timezone_set('Asia/Jakarta');
			ini_set('memory_limit', '-1');
			
			if ($this->tank_auth->is_logged_in()) {
			$id_po = isset($_GET['id_po']) ? $_GET['id_po'] : '';
			$data_po = $this->db->query("SELECT * FROM master_po WHERE id_po = '".$id_po."' ")->result_array();
			$warehouse_code = $data_po[0]['warehouse_code'];
			$data_location = $this->model_json->dataLocationGr($warehouse_code);
			$return_arr = array();
			
			
				foreach($data_location as $data_location)
				{
					
					$row_array['id_location'] = $data_location->id_location;
					$row_array['location_code'] = $data_location->location_code;
					$row_array['warehouse_code'] = $data_location->warehouse_code;
					$row_array['id_warehouse'] = $data_location->id_warehouse;
					$row_array['id_location_type'] = $data_location->id_location_type;
					$row_array['location_type'] = $data_location->location_type;
					$row_array['value'] = $data_location->location_code.'-'.$data_location->location_type;
					
					array_push($return_arr,$row_array);
					
					
				}
				
			echo json_encode($return_arr);
			
			}
			else
			{
				redirect('/auth/login/');
				}
			
	}
	
	
	
	public function jsonProductPoGr()
	{
			date_default_timezone_set('Asia/Jakarta');
			ini_set('memory_limit', '-1');
			
			if ($this->tank_auth->is_logged_in()) {
			$id_po = isset($_GET['id_po']) ? $_GET['id_po'] : '';
			$data_product_po = $this->model_json->dataProductPoGr($id_po);
			$return_arr = array();
			
			
				foreach($data_product_po as $data_product_po)
				{
					
					$row_array['id_product_orders_po'] = $data_product_po->id_product_orders_po;
					$row_array['id_product'] = $data_product_po->id_product;
					$row_array['product_code'] = $data_product_po->product_code;
					$row_array['price'] = $data_product_po->price;
					$row_array['custom_price'] = $data_product_po->custom_price;
					$row_array['id_po'] = $data_product_po->id_po;
					$row_array['product_name'] = $data_product_po->product_name;
					$row_array['id_pr'] = $data_product_po->id_pr;
					$row_array['qty'] = $data_product_po->qty_approve;
					$row_array['status_approved'] = $data_product_po->status_approved;
					$row_array['qty_approve'] = $data_product_po->qty_approve;
					
					array_push($return_arr,$row_array);
					
					
				}
				
			echo json_encode($return_arr);
			
			}
			else
			{
				redirect('/auth/login/');
				}
			
	}
	
	
	public function jsonPoGr()
	{
			date_default_timezone_set('Asia/Jakarta');
			ini_set('memory_limit', '-1');
			
			if ($this->tank_auth->is_logged_in()) {
			$id_po = isset($_GET['term']) ? $_GET['term'] : '';
			$data_po_gr = $this->model_json->dataPoGr($id_po);
			$return_arr = array();
			
			
				foreach($data_po_gr as $data_po_gr)
				{
					
					$row_array['value'] = "ID PO => ".$data_po_gr->id_po;
					$row_array['id_po'] = $data_po_gr->id_po;
					
					array_push($return_arr,$row_array);
					
					
				}
				
			echo json_encode($return_arr);
			
			}
			else
			{
				redirect('/auth/login/');
				}
			
	}
	
	
	
	public function jsonPoPi()
	{
			date_default_timezone_set('Asia/Jakarta');
			ini_set('memory_limit', '-1');
			
			if ($this->tank_auth->is_logged_in()) {
			$id_po = isset($_GET['term']) ? $_GET['term'] : '';
			$data_po_gr = $this->model_json->dataPoPi($id_po);
			$return_arr = array();
			
			
				foreach($data_po_gr as $data_po_gr)
				{
					
					$row_array['value'] = "ID PO => ".$data_po_gr->id_po;
					$row_array['id_po'] = $data_po_gr->id_po;
					
					array_push($return_arr,$row_array);
					
					
				}
				
			echo json_encode($return_arr);
			
			}
			else
			{
				redirect('/auth/login/');
				}
			
	}
	
	
	public function jsonAdditionalCost()
	{
			date_default_timezone_set('Asia/Jakarta');
			ini_set('memory_limit', '-1');
			
			if ($this->tank_auth->is_logged_in()) {
			$id_manifest = isset($_GET['id_manifest']) ? $_GET['id_manifest'] : '';
			$data_additional_manifest = $this->model_json->dataAdditionalCost($id_manifest);
			$return_arr = array();
			
			
				foreach($data_additional_manifest as $data_additional_manifest)
				{
					
					$row_array['id_manifest_additional_cost'] = $data_additional_manifest->id_manifest_additional_cost;
					$row_array['additional_type'] = $data_additional_manifest->additional_type;
					$row_array['manifest'] = $data_additional_manifest->manifest;
					$row_array['delivery_date'] = $data_additional_manifest->delivery_date;
					$row_array['trip'] = $data_additional_manifest->trip;
					$row_array['amount_to_client'] = $data_additional_manifest->amount_to_client;
					$row_array['amount_to_transporter'] = $data_additional_manifest->amount_to_transporter;
					$row_array['timestamp'] = $data_additional_manifest->timestamp;
					
					array_push($return_arr,$row_array);
					
					
				}
				
			echo json_encode($return_arr);
			
			}
			else
			{
				redirect('/auth/login/');
				}
			
	}
	
	public function jsonManifest()
	{
			date_default_timezone_set('Asia/Jakarta');
			ini_set('memory_limit', '-1');
			
			if ($this->tank_auth->is_logged_in()) {
			$manifest = isset($_GET['manifest']) ? $_GET['manifest'] : '';
			$data_manifest= $this->model_json->dataManifest($manifest);
			$return_arr = array();
			
			
				foreach($data_manifest as $data_manifest)
				{
					$status_manifest = 'no_route';
					$select_manifest = $this->db->query("SELECT * FROM transport_order WHERE manifest = '".$manifest."'");
					$check_manifest = $select_manifest->num_rows();
					
					if($check_manifest>=1)
					{$status_manifest = 'yes_route';}
					
					$row_array['status_manifest'] = $status_manifest;
					$row_array['id_manifest'] = $data_manifest->id_manifest;
					$row_array['id_trucking_order'] = $data_manifest->id_trucking_order;
					$row_array['driver_code'] = $data_manifest->driver_code;
					$row_array['driver_name'] = $data_manifest->driver_name;
					$row_array['driver_phone_number'] = $data_manifest->driver_phone_number;
					$row_array['transporter'] = $data_manifest->transporter;
					$row_array['transporter_id'] = $data_manifest->transporter_id;
					$row_array['transporter_name'] = $data_manifest->transporter_name;
					$row_array['client_id'] = $data_manifest->client_id;
					$row_array['client_name'] = $data_manifest->client_name;
					$row_array['volume_cap'] = $data_manifest->volume_cap;
					$row_array['weight_cap'] = $data_manifest->weight_cap;
					$row_array['remark'] = $data_manifest->remark;
					$row_array['vehicle_id'] = $data_manifest->vehicle_id;
					$row_array['vehicle_status'] = $data_manifest->vehicle_status;
					$row_array['description'] = $data_manifest->description;
					$row_array['vehicle_type'] = $data_manifest->vehicle_type;
					$row_array['id_vehicle_type'] = $data_manifest->id_vehicle_type;
					$row_array['trip'] = $data_manifest->trip;
					$row_array['confirmed_manifest'] = $data_manifest->confirmed_manifest;
					$row_array['confirmed_vehicle'] = $data_manifest->confirmed_vehicle;
					$row_array['confirmed_rate'] = $data_manifest->confirmed_rate;
					$row_array['delivery_date'] = $data_manifest->delivery_date;
					$row_array['origin_id'] = $data_manifest->origin_id;
					$row_array['origin_address'] = $data_manifest->origin_address;
					$row_array['origin_area'] = $data_manifest->origin_area;
					$row_array['destination_id'] = $data_manifest->destination_id;
					$row_array['destination_address'] = $data_manifest->destination_address;
					$row_array['destination_area'] = $data_manifest->destination_area;
					$row_array['mode'] = $data_manifest->mode;
					$row_array['seal_number'] = $data_manifest->seal_number;
					$row_array['cont_number'] = $data_manifest->cont_number;
					$row_array['rate'] = $data_manifest->rate;
					$row_array['client_rate'] = $data_manifest->client_rate;
					array_push($return_arr,$row_array);
				}
				
			echo json_encode($return_arr);
			
			}
			else
			{
				redirect('/auth/login/');
				}
			
	}
	
	public function jsonTransportOrderManifestRoutePlanning()
	{
			date_default_timezone_set('Asia/Jakarta');
			ini_set('memory_limit', '-1');
			
			if ($this->tank_auth->is_logged_in()) {
			$delivery_date = isset($_GET['delivery_date']) ? $_GET['delivery_date'] : '';
			$trip = isset($_GET['trip']) ? $_GET['trip'] : '';
			$manifest = isset($_GET['manifest']) ? $_GET['manifest'] : '';
			$data_transport_order = $this->model_json->dataTransportOrderManifestRoutePlanning($trip,$delivery_date,$manifest);
			$return_arr = array();
			
			
				foreach($data_transport_order as $data_transport_order)
				{
					
					$row_array['spk_number'] = $data_transport_order->spk_number;
					$row_array['manifest'] = $data_transport_order->manifest;
					$row_array['do_number'] = $data_transport_order->do_number;
					$row_array['reference'] = $data_transport_order->reference;
					$row_array['delivery_date'] = $data_transport_order->delivery_date;
					$row_array['delivery_time'] = $data_transport_order->delivery_time;
					$row_array['origin_id'] = $data_transport_order->origin_id;
					$row_array['origin_address'] = $data_transport_order->origin_address;
					$row_array['origin_area'] = $data_transport_order->origin_area;
					$row_array['destination_id'] = $data_transport_order->destination_id;
					$row_array['destination_address'] = $data_transport_order->destination_address;
					$row_array['destination_area'] = $data_transport_order->destination_area;
					$row_array['client_id'] = $data_transport_order->client_id;
					$row_array['client_name'] = $data_transport_order->client_name;
					$row_array['document_date'] = $data_transport_order->document_date;
					$row_array['document_time'] = $data_transport_order->document_time;
					$row_array['order_type'] = $data_transport_order->order_type;
					$row_array['posting_date'] = $data_transport_order->posting_date;
					$row_array['status'] = $data_transport_order->status;
					$row_array['status_to'] = $data_transport_order->status_to;
					$row_array['remark'] = $data_transport_order->remark;
					$row_array['trip'] = $data_transport_order->trip;
					$row_array['si'] = $data_transport_order->si;
					$row_array['hawb'] = $data_transport_order->hawb;
					$row_array['mawb'] = $data_transport_order->mawb;
					$row_array['notes'] = $data_transport_order->notes;
					$row_array['qty'] = $data_transport_order->qty;
					$row_array['volume'] = $data_transport_order->volume;
					$row_array['weight'] = $data_transport_order->weight;
					
					array_push($return_arr,$row_array);
				}
				
			echo json_encode($return_arr);
			
			}
			else
			{
				redirect('/auth/login/');
				}
			
	}
	
	
	public function jsonTransportOrderRoutePlanning()
	{
			date_default_timezone_set('Asia/Jakarta');
			ini_set('memory_limit', '-1');
			
			if ($this->tank_auth->is_logged_in()) {
			$delivery_date = isset($_GET['delivery_date']) ? $_GET['delivery_date'] : '';
			$client_id = isset($_GET['client_id']) ? $_GET['client_id'] : '';
			$trip = isset($_GET['trip']) ? $_GET['trip'] : '';
			$data_transport_order = $this->model_json->dataTransportOrderRoutePlanning($trip,$delivery_date,$client_id);
			$return_arr = array();
			
			
				foreach($data_transport_order as $data_transport_order)
				{
					$row_array['spk_number'] = $data_transport_order->spk_number;
					$row_array['manifest'] = $data_transport_order->manifest;
					$row_array['do_number'] = $data_transport_order->do_number;
					$row_array['reference'] = $data_transport_order->reference;
					$row_array['delivery_date'] = $data_transport_order->delivery_date;
					$row_array['delivery_time'] = $data_transport_order->delivery_time;
					$row_array['origin_id'] = $data_transport_order->origin_id;
					$row_array['origin_address'] = $data_transport_order->origin_address;
					$row_array['origin_area'] = $data_transport_order->origin_area;
					$row_array['destination_id'] = $data_transport_order->destination_id;
					$row_array['destination_address'] = $data_transport_order->destination_address;
					$row_array['destination_area'] = $data_transport_order->destination_area;
					$row_array['client_id'] = $data_transport_order->client_id;
					$row_array['client_name'] = $data_transport_order->client_name;
					$row_array['document_date'] = $data_transport_order->document_date;
					$row_array['document_time'] = $data_transport_order->document_time;
					$row_array['order_type'] = $data_transport_order->order_type;
					$row_array['posting_date'] = $data_transport_order->posting_date;
					$row_array['status'] = $data_transport_order->status;
					$row_array['status_to'] = $data_transport_order->status_to;
					$row_array['remark'] = $data_transport_order->remark;
					$row_array['trip'] = $data_transport_order->trip;
					$row_array['si'] = $data_transport_order->si;
					$row_array['hawb'] = $data_transport_order->hawb;
					$row_array['mawb'] = $data_transport_order->mawb;
					$row_array['notes'] = $data_transport_order->notes;
					$row_array['qty'] = $data_transport_order->qty;
					$row_array['volume'] = $data_transport_order->volume;
					$row_array['weight'] = $data_transport_order->weight;
					
					array_push($return_arr,$row_array);
				}
				
			echo json_encode($return_arr);
			
			}
			else
			{
				redirect('/auth/login/');
				}
			
	}
	
	
	public function jsonManifestRoutePlanning()
	{
			date_default_timezone_set('Asia/Jakarta');
			ini_set('memory_limit', '-1');
			
			if ($this->tank_auth->is_logged_in()) {
			$delivery_date = isset($_GET['delivery_date']) ? $_GET['delivery_date'] : '';
			$trip = isset($_GET['trip']) ? $_GET['trip'] : '';
			$client_id = isset($_GET['client_id']) ? $_GET['client_id'] : '';
			$data_manifest= $this->model_json->dataManifestRoutePlanning($trip,$delivery_date,$client_id);
			$return_arr = array();
			
			
				foreach($data_manifest as $data_manifest)
				{
					$row_array['manifest'] = $data_manifest->id_manifest;
					$row_array['driver_code'] = $data_manifest->driver_code;
					$row_array['vehicle_id'] = $data_manifest->vehicle_id;
					$row_array['vehicle_type'] = $data_manifest->vehicle_type;
					$row_array['trip'] = $data_manifest->trip;
					$row_array['transporter'] = $data_manifest->transporter;
					$row_array['transporter_id'] = $data_manifest->transporter_id;
					$row_array['transporter_name'] = $data_manifest->transporter_name;
					$row_array['destination_area'] = $data_manifest->destination_area;
					$row_array['description'] = $data_manifest->description;
					$row_array['delivery_date'] = $data_manifest->delivery_date;
					$row_array['created_by'] = $data_manifest->created_by;
					$row_array['created_date'] = $data_manifest->created_date;
					$row_array['updated_by'] = $data_manifest->updated_by;
					$row_array['updated_date'] = $data_manifest->updated_date;
					$row_array['confirmed_manifest'] = $data_manifest->confirmed_manifest;
					
					array_push($return_arr,$row_array);
				}
				
			echo json_encode($return_arr);
			
			}
			else
			{
				redirect('/auth/login/');
				}
			
	}
	
	
	public function jsonMasterUnitRoutePlanning()
	{
			date_default_timezone_set('Asia/Jakarta');
			ini_set('memory_limit', '-1');
			
			if ($this->tank_auth->is_logged_in()) {
			$search = isset($_GET['search']) ? $_GET['search'] : '';
			$data_master_unit = $this->model_json->dataMasterUnitRoutePlanning($search);
			$return_arr = array();
			
			
				foreach($data_master_unit as $data_master_unit)
				{
					$row_array['value'] = $data_master_unit->vehicle_id;
					$row_array['label'] = $data_master_unit->vehicle_id;
					$row_array['id_master_unit'] = $data_master_unit->id_master_unit;
					$row_array['vehicle_id'] = $data_master_unit->vehicle_id;
					$row_array['vehicle_type'] = $data_master_unit->vehicle_type;
					$row_array['description'] = $data_master_unit->description;
					array_push($return_arr,$row_array);
				}
				
			echo json_encode($return_arr);
			
			}
			else
			{
				redirect('/auth/login/');
				}
			
	}
	
	
	
	public function jsonTransportOrder()
	{
			date_default_timezone_set('Asia/Jakarta');
			ini_set('memory_limit', '-1');
			
			if ($this->tank_auth->is_logged_in()) {
			$search = isset($_GET['term']) ? $_GET['term'] : '';
			$data_transport_order = $this->model_json->dataTransportOrder($search);
			$return_arr = array();
			
			
				foreach($data_transport_order as $data_transport_order)
				{
					$row_array['value'] = $data_transport_order->spk_number.' - '.$data_transport_order->do_number;
					$row_array['label'] = $data_transport_order->spk_number.' - '.$data_transport_order->do_number;
					$row_array['spk_number'] = $data_transport_order->spk_number;
					$row_array['do_number'] = $data_transport_order->do_number;
					$row_array['order_type'] = $data_transport_order->order_type;
					$row_array['manifest'] = $data_transport_order->manifest;
					array_push($return_arr,$row_array);
				}
				
			echo json_encode($return_arr);
			
			}
			else
			{
				redirect('/auth/login/');
				}
			
	}
	
	
	public function jsonProductPo()
	{
			date_default_timezone_set('Asia/Jakarta');
			ini_set('memory_limit', '-1');
			
			if ($this->tank_auth->is_logged_in()) {
			$id_po = isset($_GET['id_po']) ? $_GET['id_po'] : '';
			$data_product_po = $this->model_json->dataProductPo($id_po);
			$return_arr = array();
			
			
				foreach($data_product_po as $data_product_po)
				{
					
					$row_array['id_product_orders_po'] = $data_product_po->id_product_orders_po;
					$row_array['id_product'] = $data_product_po->id_product;
					$row_array['product_code'] = $data_product_po->product_code;
					$row_array['price'] = $data_product_po->price;
					$row_array['custom_price'] = $data_product_po->custom_price;
					$row_array['id_po'] = $data_product_po->id_po;
					$row_array['product_name'] = $data_product_po->product_name;
					$row_array['id_pr'] = $data_product_po->id_pr;
					$row_array['qty'] = $data_product_po->qty;
					$row_array['status_approved'] = $data_product_po->status_approved;
					$row_array['qty_approve'] = $data_product_po->qty_approve;
					
					array_push($return_arr,$row_array);
					
					
				}
				
			echo json_encode($return_arr);
			
			}
			else
			{
				redirect('/auth/login/');
				}
			
	}
	
	public function jsonPr()
	{
			date_default_timezone_set('Asia/Jakarta');
			ini_set('memory_limit', '-1');
			
			if ($this->tank_auth->is_logged_in()) {
			$id_pr = isset($_GET['term']) ? $_GET['term'] : '';
			$data_pr = $this->model_json->dataPr($id_pr);
			$return_arr = array();
			
			
				foreach($data_pr as $data_pr)
				{
					$row_array['value'] = $data_pr->id_pr.' - '.$data_pr->division_name;
					$row_array['label'] = $data_pr->id_pr.' - '.$data_pr->division_name;
					$row_array['id_pr'] = $data_pr->id_pr;
					$row_array['request_date'] = $data_pr->request_date;
					$row_array['division_code'] = $data_pr->division_code;
					$row_array['division_name'] = $data_pr->division_name;
					array_push($return_arr,$row_array);
				}
				
			echo json_encode($return_arr);
			
			}
			else
			{
				redirect('/auth/login/');
			}
			
	}
	
	
	public function jsonProductPr()
	{
			date_default_timezone_set('Asia/Jakarta');
			ini_set('memory_limit', '-1');
			
			if ($this->tank_auth->is_logged_in()) {
			$id_pr = isset($_GET['id_pr']) ? $_GET['id_pr'] : '';
			$data_product_pr = $this->model_json->dataProductPr($id_pr);
			$return_arr = array();
			
			
				foreach($data_product_pr as $data_product_pr)
				{
					
					
					
					$row_array['id_product_orders_pr'] = $data_product_pr->id_product_orders_pr;
					$row_array['id_product'] = $data_product_pr->id_product;
					$row_array['product_code'] = $data_product_pr->product_code;
					$row_array['price'] = $data_product_pr->price;
					$row_array['id_pr'] = $data_product_pr->id_pr;
					$row_array['product_name'] = $data_product_pr->product_name;
					$row_array['qty'] = $data_product_pr->qty;
					$row_array['base_uom'] = $data_product_pr->base_uom;
					$row_array['time_stamp'] = $data_product_pr->time_stamp;
					
					array_push($return_arr,$row_array);
					
					
				}
				
			echo json_encode($return_arr);
			
			}
			else
			{
				redirect('/auth/login/');
				}
			
	}
	
	
	public function jsonTruckAbsent()
	{
			date_default_timezone_set('Asia/Jakarta');
			ini_set('memory_limit', '-1');
			
			if ($this->tank_auth->is_logged_in()) {
			$search = isset($_GET['term']) ? $_GET['term'] : '';
			$data_truck_absent = $this->model_json->datatruckAbsent($search);
			$return_arr = array();
			
			
				foreach($data_truck_absent as $data_truck_absent)
				{
					
					$row_array['id_truck_absent'] = $data_truck_absent->id_truck_absent;
					$row_array['vehicle_id'] = $data_truck_absent->vehicle_id;
					$row_array['transporter_name'] = $data_truck_absent->transporter_name;
					$row_array['vehicle_type'] = $data_truck_absent->vehicle_type;
					$row_array['driver_name'] = $data_truck_absent->driver_name;
					array_push($return_arr,$row_array);
					
					
				}
				
			echo json_encode($return_arr);
			
			}
			else
			{
				redirect('/auth/login/');
				}
			
	}
	
	
	
	
	public function jsonOrigin()
	{
			date_default_timezone_set('Asia/Jakarta');
			ini_set('memory_limit', '-1');
			
			if ($this->tank_auth->is_logged_in()) {
			$search = isset($_GET['term']) ? $_GET['term'] : '';
			$data_origin = $this->model_json->dataOrigin($search);
			$return_arr = array();
			
			
				foreach($data_origin as $data_origin)
				{
					
					$row_array['value'] = $data_origin->customer_id.' - '.$data_origin->customer_name;
					$row_array['label'] = $data_origin->customer_id.' - '.$data_origin->customer_name;
					$row_array['customer_id'] = $data_origin->customer_id;
					$row_array['customer_name'] = $data_origin->customer_name;
					$row_array['area'] = $data_origin->area;
					$row_array['customer_address_1'] = $data_origin->customer_address_1;
					$row_array['customer_address_2'] = $data_origin->customer_address_2;
					$row_array['pic'] = $data_origin->pic;
					$row_array['email'] = $data_origin->email;
					array_push($return_arr,$row_array);
				}
				
			echo json_encode($return_arr);
			
			}
			else
			{
				redirect('/auth/login/');
				}
			
	}
	
	
	public function jsonRoomService()
	{
			date_default_timezone_set('Asia/Jakarta');
			ini_set('memory_limit', '-1');
			
			if ($this->tank_auth->is_logged_in()) {
			$search = isset($_GET['term']) ? $_GET['term'] : '';
			$data_room_service = $this->model_json->dataRoomService($search);
			$return_arr = array();
			
			
				foreach($data_room_service as $data_room_service)
				{
					$check_room_service = $this->db->query("SELECT * FROM room_service_management WHERE room_service_id = '".$data_room_service->room_service_id."' AND service_status = 'On Progress' ")->num_rows();
					$status_room  = 'Available';
					if($check_room_service>=1)
					{$status_room='Not Available';}
					$row_array['value'] = $data_room_service->room_service_id.' - '.$data_room_service->room_service_name;
					$row_array['label'] = $data_room_service->room_service_id.' - '.$data_room_service->room_service_name;
					$row_array['room_service_id'] = $data_room_service->room_service_id;
					$row_array['room_service_name'] = $data_room_service->room_service_name;
					$row_array['status_room'] = $status_room;
					array_push($return_arr,$row_array);
				}
				
			echo json_encode($return_arr);
			
			}
			else
			{
				redirect('/auth/login/');
				}
			
	}
	
	public function jsonTransporter()
	{
			date_default_timezone_set('Asia/Jakarta');
			ini_set('memory_limit', '-1');
			
			if ($this->tank_auth->is_logged_in()) {
			$search = isset($_GET['term']) ? $_GET['term'] : '';
			$data_transporter = $this->model_json->dataTransporter($search);
			$return_arr = array();
			
			
				foreach($data_transporter as $data_transporter)
				{
					$row_array['value'] = $data_transporter->transporter_id.' - '.$data_transporter->transporter_name;
					$row_array['label'] = $data_transporter->transporter_id.' - '.$data_transporter->transporter_name;
					$row_array['transporter_id'] = $data_transporter->transporter_id;
					$row_array['transporter_name'] = $data_transporter->transporter_name;
					array_push($return_arr,$row_array);
				}
				
			echo json_encode($return_arr);
			
			}
			else
			{
				redirect('/auth/login/');
				}
			
	}
	
	public function jsonProvince()
	{
			date_default_timezone_set('Asia/Jakarta');
			ini_set('memory_limit', '-1');
			
			if ($this->tank_auth->is_logged_in()) {
			$search = isset($_GET['term']) ? $_GET['term'] : '';
			$data_province = $this->model_json->dataProvince($search);
			$return_arr = array();
			
			
				foreach($data_province as $data_province)
				{
					$row_array['value'] = $data_province->province_name;
					$row_array['label'] = $data_province->province_name;
					$row_array['province'] = $data_province->province_name;
					array_push($return_arr,$row_array);
				}
				
			echo json_encode($return_arr);
			
			}
			else
			{
				redirect('/auth/login/');
				}
			
	}
	
	public function jsonVehicleType()
	{
			date_default_timezone_set('Asia/Jakarta');
			ini_set('memory_limit', '-1');
			
			if ($this->tank_auth->is_logged_in()) {
			$search = isset($_GET['term']) ? $_GET['term'] : '';
			$data_vehicle_type = $this->model_json->dataVehicleType($search);
			$return_arr = array();
			
			
				foreach($data_vehicle_type as $data_vehicle_type)
				{
					$row_array['value'] = $data_vehicle_type->vehicle_type.' - '.$data_vehicle_type->description;
					$row_array['label'] = $data_vehicle_type->vehicle_type.' - '.$data_vehicle_type->description;
					$row_array['vehicle_type'] = $data_vehicle_type->vehicle_type;
					$row_array['description'] = $data_vehicle_type->description;
					$row_array['id_vehicle_type'] = $data_vehicle_type->id_vehicle_type;
					array_push($return_arr,$row_array);
				}
				
			echo json_encode($return_arr);
			
			}
			else
			{
				redirect('/auth/login/');
				}
			
	}
	
	public function jsonArea()
	{
			date_default_timezone_set('Asia/Jakarta');
			ini_set('memory_limit', '-1');
			
			if ($this->tank_auth->is_logged_in()) {
			$search = isset($_GET['term']) ? $_GET['term'] : '';
			$data_area = $this->model_json->dataArea($search);
			$return_arr = array();
			
			
				foreach($data_area as $data_area)
				{
					$row_array['value'] = $data_area->area_id.' - '.$data_area->area_description;
					$row_array['label'] = $data_area->area_id.' - '.$data_area->area_description;
					$row_array['area_id'] = $data_area->area_id;
					$row_array['area_description'] = $data_area->area_description;
					array_push($return_arr,$row_array);
				}
				
			echo json_encode($return_arr);
			
			}
			else
			{
				redirect('/auth/login/');
				}
			
	}
	
	public function jsonVendor()
	{
			date_default_timezone_set('Asia/Jakarta');
			ini_set('memory_limit', '-1');
			
			if ($this->tank_auth->is_logged_in()) {
			$search = isset($_GET['term']) ? $_GET['term'] : '';
			$data_vendor = $this->model_json->dataVendor($search);
			$return_arr = array();
			
			
				foreach($data_vendor as $data_vendor)
				{
					$row_array['value'] = $data_vendor->vendor_id.' - '.$data_vendor->vendor_name;
					$row_array['label'] = $data_vendor->vendor_id.' - '.$data_vendor->vendor_name;
					$row_array['vendor_id'] = $data_vendor->vendor_id;
					$row_array['vendor_name'] = $data_vendor->vendor_name;
					array_push($return_arr,$row_array);
				}
				
			echo json_encode($return_arr);
			
			}
			else
			{
				redirect('/auth/login/');
				}
			
	}
	
	public function jsonClient()
	{
			date_default_timezone_set('Asia/Jakarta');
			ini_set('memory_limit', '-1');
			
			if ($this->tank_auth->is_logged_in()) {
			$search = isset($_GET['term']) ? $_GET['term'] : '';
			$data_client = $this->model_json->dataClient($search);
			$return_arr = array();
			
			
				foreach($data_client as $data_client)
				{
					$row_array['value'] = $data_client->client_id.' - '.$data_client->client_name;
					$row_array['label'] = $data_client->client_id.' - '.$data_client->client_name;
					$row_array['client_id'] = $data_client->client_id;
					$row_array['client_name'] = $data_client->client_name;
					array_push($return_arr,$row_array);
				}
				
			echo json_encode($return_arr);
			
			}
			else
			{
				redirect('/auth/login/');
				}
			
	}
	
	public function jsonDriver()
	{
			date_default_timezone_set('Asia/Jakarta');
			ini_set('memory_limit', '-1');
			
			if ($this->tank_auth->is_logged_in()) {
			$search = isset($_GET['term']) ? $_GET['term'] : '';
			$data_driver = $this->model_json->dataDriver($search);
			$return_arr = array();
			
			
				foreach($data_driver as $data_driver)
				{
					$row_array['value'] = $data_driver->driver_code.' - '.$data_driver->driver_name;
					$row_array['label'] = $data_driver->driver_code.' - '.$data_driver->driver_name;
					$row_array['driver_code'] = $data_driver->driver_code;
					$row_array['driver_name'] = $data_driver->driver_name;
					array_push($return_arr,$row_array);
				}
				
			echo json_encode($return_arr);
			
			}
			else
			{
				redirect('/auth/login/');
				}
			
	}
	
	
	public function jsonLocation()
	{
			date_default_timezone_set('Asia/Jakarta');
			ini_set('memory_limit', '-1');
			
			if ($this->tank_auth->is_logged_in()) {
			$search = isset($_GET['term']) ? $_GET['term'] : '';
			$warehouse_code = isset($_GET['warehouse_code']) ? $_GET['warehouse_code'] : '';
			$data_location = $this->model_json->dataLocation($search,$warehouse_code);
			$return_arr = array();
			
			
				foreach($data_location as $data_location)
				{
					$row_array['value'] = $data_location->location_code.' - '.$data_location->location_type;
					$row_array['label'] = $data_location->location_code.' - '.$data_location->location_type;
					$row_array['id_location'] = $data_location->id_location;
					$row_array['id_location_type'] = $data_location->id_location_type;
					$row_array['location_type'] = $data_location->location_type;
					$row_array['location_code'] = $data_location->location_code;
					$row_array['warehouse_code'] = $data_location->warehouse_code;
					array_push($return_arr,$row_array);
				}
				
			echo json_encode($return_arr);
			
			}
			else
			{
				redirect('/auth/login/');
				}
			
	}
	
	
	public function jsonMasterUnit()
	{
			date_default_timezone_set('Asia/Jakarta');
			ini_set('memory_limit', '-1');
			
			if ($this->tank_auth->is_logged_in()) {
			$search = isset($_GET['term']) ? $_GET['term'] : '';
			$data_master_unit = $this->model_json->dataMasterUnit($search);
			$return_arr = array();
			
			
				foreach($data_master_unit as $data_master_unit)
				{
					$row_array['value'] = $data_master_unit->vehicle_id;
					$row_array['label'] = $data_master_unit->vehicle_id;
					$row_array['id_master_unit'] = $data_master_unit->id_master_unit;
					$row_array['vehicle_type'] = $data_master_unit->vehicle_type;
					$row_array['vehicle_id'] = $data_master_unit->vehicle_id;
					$row_array['id_vehicle_type'] = $data_master_unit->id_vehicle_type;
					array_push($return_arr,$row_array);
				}
				
			echo json_encode($return_arr);
			
			}
			else
			{
				redirect('/auth/login/');
				}
			
	}
	
	public function jsonChasis()
	{
			date_default_timezone_set('Asia/Jakarta');
			ini_set('memory_limit', '-1');
			
			if ($this->tank_auth->is_logged_in()) {
			$search = isset($_GET['term']) ? $_GET['term'] : '';
			$data_chasis = $this->model_json->dataChasis($search);
			$return_arr = array();
			
			
				foreach($data_chasis as $data_chasis)
				{
					$row_array['value'] = $data_chasis->chasis_id;
					$row_array['label'] = $data_chasis->chasis_id;
					$row_array['id_chasis'] = $data_chasis->id_chasis;
					array_push($return_arr,$row_array);
				}
				
			echo json_encode($return_arr);
			
			}
			else
			{
				redirect('/auth/login/');
				}
			
	}
	
	public function jsonSupplier()
	{
			date_default_timezone_set('Asia/Jakarta');
			ini_set('memory_limit', '-1');
			
			if ($this->tank_auth->is_logged_in()) {
			$search = isset($_GET['term']) ? $_GET['term'] : '';
			$data_supplier = $this->model_json->dataSupplier($search);
			$return_arr = array();
			
			
				foreach($data_supplier as $data_supplier)
				{
					$row_array['value'] = $data_supplier->supplier_code;
					$row_array['label'] = $data_supplier->supplier_code;
					$row_array['supplier_code'] = $data_supplier->supplier_code;
					$row_array['id_supplier'] = $data_supplier->id_supplier;
					$row_array['address_1'] = $data_supplier->address_1;
					$row_array['supplier_name'] = $data_supplier->supplier_name;
					array_push($return_arr,$row_array);
				}
				
			echo json_encode($return_arr);
			
			}
			else
			{
				redirect('/auth/login/');
				}
			
	}
	
	
	public function jsonWarehouse()
	{
			date_default_timezone_set('Asia/Jakarta');
			ini_set('memory_limit', '-1');
			
			if ($this->tank_auth->is_logged_in()) {
			$search = isset($_GET['term']) ? $_GET['term'] : '';
			$data_warehouse = $this->model_json->dataWarehouse($search);
			$return_arr = array();
				foreach($data_warehouse as $data_warehouse)
				{
					$row_array['value'] = $data_warehouse->warehouse_code;
					$row_array['label'] = $data_warehouse->warehouse_code;
					$row_array['id_warehouse'] = $data_warehouse->id_warehouse;
					array_push($return_arr,$row_array);
				}
			echo json_encode($return_arr);
			
			}
			else
			{
				redirect('/auth/login/');
				}
	}
	
	
	
	public function jsonOrderType()
	{
			date_default_timezone_set('Asia/Jakarta');
			ini_set('memory_limit', '-1');
			
			if ($this->tank_auth->is_logged_in()) {
			$search = isset($_GET['term']) ? $_GET['term'] : '';
			$data_order_type = $this->model_json->dataOrderType($search);
			$return_arr = array();
				foreach($data_order_type as $data_order_type)
				{
					$row_array['value'] = $data_order_type->description;
					$row_array['label'] = $data_order_type->description;
					$row_array['id_warehouse'] = $data_order_type->id_order_type;
					array_push($return_arr,$row_array);
				}
			echo json_encode($return_arr);
			
			}
			else
			{
				redirect('/auth/login/');
				}
	}
	
	
	public function jsonProduct()
	{
			date_default_timezone_set('Asia/Jakarta');
			ini_set('memory_limit', '-1');
			
			if ($this->tank_auth->is_logged_in()) {
			$search = isset($_GET['term']) ? $_GET['term'] : '';
			$data_product = $this->model_json->dataProduct($search);
			$return_arr = array();
				foreach($data_product as $data_product)
				{
					$row_array['value'] = $data_product->product_code;
					$row_array['label'] = $data_product->product_code;
					$row_array['id_product'] = $data_product->id_product;
					$row_array['product_description'] = $data_product->product_description;
					$row_array['base_uom'] = $data_product->base_uom;
					$row_array['price'] = $data_product->price;
					array_push($return_arr,$row_array);
				}
			echo json_encode($return_arr);
			
			}
			else
			{
				redirect('/auth/login/');
				}
	}
	
	
}

/* End of file dashboard.php */
/* Location: ./application/controllers/admin/dashboard.php */