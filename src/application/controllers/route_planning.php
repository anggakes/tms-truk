<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Route_planning extends CI_Controller {

	function __construct()  {
 		parent::__construct();
			$this->load->library(array('PHPExcel','PHPExcel/IOFactory'));
			$this->load->model('model_account_master');
			$this->load->model('model_route_planning');
			$this->load->library('tank_auth');
			
	}
	
	public function confirmedAdditionalCost()
	{
			date_default_timezone_set('Asia/Jakarta');
			ini_set('memory_limit', '-1');
			
			if ($this->tank_auth->is_logged_in()) {
			$user	= $this->tank_auth->get_username();
			$data_account = $this->model_account_master->getAccount("WHERE username = '".$user."' ")->result_array();
			$data_role = $this->model_account_master->getRole("WHERE id_role = '".$data_account[0]['user_access']."' ")->result_array();
			$user_role = $data_account[0]['user_type'];
			$code_role = $data_account[0]['code'];
			
			if($data_role[0]['edit_route_planning']=='yes')
			{
				// Get Variable Post
				$delivery_date_direct = $_POST['delivery_date_confirmed_additional_cost'];
				$delivery_date = explode('-',$_POST['delivery_date_confirmed_additional_cost']);
				$delivery_date = $delivery_date[2].'-'.$delivery_date[1].'-'.$delivery_date[0];
				$trip = $_POST['trip_confirmed_additional_cost'];
				$timestamp = date('Y:m:d H:i:s');
				$username = $user;
				$id_manifest =  $_POST['id_manifest_confirmed_additional_cost'];
				$client_id =  $_POST['client_id_confirmed_additional_cost'];
				$rate =  isset($_POST['rate_confirmed_additional_cost']) ? $_POST['rate_confirmed_additional_cost'] : '';
				$rate = str_replace(',','',$rate);
				$client_rate =  isset($_POST['client_rate_confirmed_additional_cost']) ? $_POST['client_rate_confirmed_additional_cost'] : '';
				$client_rate = str_replace(',','',$client_rate);

				$amount_to_client =  isset($_POST['amount_to_client']) ? $_POST['amount_to_client'] : '';
				$amount_to_client = str_replace(',','',$amount_to_client);
				$amount_to_transporter =  isset($_POST['amount_to_transporter']) ? $_POST['amount_to_transporter'] : '';
				$amount_to_transporter = str_replace(',','',$amount_to_transporter);
				$additional_type =  isset($_POST['additional_type']) ? $_POST['additional_type'] : '';
				
				
				$update_manifest = $this->db->query("UPDATE master_manifest SET confirmed_rate='yes',rate = '".$rate."',client_rate = '".$client_rate."' WHERE id_manifest = '".$id_manifest."'  ");

				
				$delete_additional_cost = $this->db->query("DELETE FROM manifest_additional_cost WHERE manifest = '".$id_manifest."' ");
				
				
				if($amount_to_client!='' AND $amount_to_transporter!=''){
					foreach($additional_type as $key => $additional_types) {

						$data_insert = array(						
							"additional_type" => $additional_types,
							"manifest" => $id_manifest,
							"delivery_date" => $delivery_date,
							"trip" => $trip,
							"amount_to_client" => $amount_to_client[$key],
							"amount_to_transporter" => $amount_to_transporter[$key]
						);
						$res = $this->model_route_planning->insertData("manifest_additional_cost",$data_insert);
						
						}
				
					if($res)
					{
							$this->session->set_flashdata('message_success',"Data route planning has been successfully updated!");
							redirect('route_planning?delivery_date='.$delivery_date_direct.'&&trip='.$trip.'&&client_id='.$client_id);
						}
					else{
						
							$this->session->set_flashdata('message_failed',"Data RoutePlanning failed to update!");
							redirect('route_planning');
						}
				}
				else{
					
					if($update_manifest)
					{
							$this->session->set_flashdata('message_success',"Data route planning has been successfully updated!");
							redirect('route_planning?delivery_date='.$delivery_date_direct.'&&trip='.$trip.'&&client_id='.$client_id);
						}
					else{
						
							$this->session->set_flashdata('message_failed',"Data RoutePlanning failed to update!");
							redirect('route_planning');
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
	
	public function confirmedManifest()
	{
			date_default_timezone_set('Asia/Jakarta');
			ini_set('memory_limit', '-1');
			
			if ($this->tank_auth->is_logged_in()) {
			$user	= $this->tank_auth->get_username();
			$data_account = $this->model_account_master->getAccount("WHERE username = '".$user."' ")->result_array();
			$data_role = $this->model_account_master->getRole("WHERE id_role = '".$data_account[0]['user_access']."' ")->result_array();
			$user_role = $data_account[0]['user_type'];
			$code_role = $data_account[0]['code'];
			
			if($data_role[0]['edit_route_planning']=='yes')
			{
				// Get Variable Post
				$delivery_date = $_POST['delivery_date_confirmed_manifest'];
				$trip = $_POST['trip_confirmed_manifest'];
				$client_id = $_POST['client_id_confirmed_manifest'];
				$timestamp = date('Y:m:d H:i:s');
				$username = $user;
				$id_manifest =  $_POST['id_manifest_confirmed_manifest'];
				$confirmed_manifest =  $_POST['confirmed_manifest'];
				
				
				
				$data_manifest = $this->db->query("SELECT * FROM master_manifest WHERE id_manifest = '".$id_manifest."' ")->result_array();
				
				$transporter_type = $data_manifest[0]['transporter'];
				
				
				
				
				$rate = 0;
				$client_rate = 0;
				if($transporter_type=='assets')
				{
					$select_client_rate = $this->db->query("SELECT * FROM client_rate WHERE client_id = '".$data_manifest[0]['client_id']."' AND vehicle_status = '".$data_manifest[0]['vehicle_status']."'  AND  origin = '".$data_manifest[0]['origin_id']."' AND  destination = '".$data_manifest[0]['destination_id']."' AND id_vehicle_type = '".$data_manifest[0]['id_vehicle_type']."'  ");
					$check_client_rate = $select_client_rate->num_rows();
					$data_client_rate = $select_client_rate->result_array();
					
					echo $check_client_rate;
					
					$select_direct_cost = $this->db->query("SELECT * FROM direct_cost WHERE client_id = '".$data_manifest[0]['client_id']."' AND vehicle_status = '".$data_manifest[0]['vehicle_status']."' AND  origin = '".$data_manifest[0]['origin_id']."' AND  destination = '".$data_manifest[0]['destination_id']."' AND id_vehicle_type = '".$data_manifest[0]['id_vehicle_type']."'  ");
					$check_direct_cost = $select_direct_cost->num_rows();
					$data_direct_cost = $select_direct_cost->result_array();
					
					echo $check_direct_cost;
					
					
				
					if($check_client_rate>=1 && $check_direct_cost)
					{
							$rate = $data_direct_cost[0]['vehicle_rate'];
							$client_rate = $data_client_rate[0]['vehicle_rate'];
							$data_update = array(
							"rate"=> $rate,
							"client_rate"=> $client_rate,
							"confirmed_manifest"=> $confirmed_manifest,
							"updated_by"=> $username,
							"updated_date"=> $timestamp
							);
							
							$where = array(
							
								"id_manifest" => $id_manifest,

							);
							
							$res = $this->model_route_planning->UpdateData("master_manifest",$data_update,$where);
							if($res)
							{
									$this->session->set_flashdata('message_success',"Data route planning has been successfully updated!");
									redirect('route_planning?delivery_date='.$delivery_date.'&&trip='.$trip.'&&client_id='.$client_id);
								}
							else{
								
									$this->session->set_flashdata('message_failed',"Data RoutePlanning failed to update!");
									redirect('route_planning');
								}
					}
					else
					{
						$this->session->set_flashdata('message_failed',"Data RoutePlanning failed to confirm, Plese set the rate!");
						redirect('route_planning');
					}
				}
				else if($transporter_type=='vendor')
				{
					$select_client_rate = $this->db->query("SELECT * FROM client_rate WHERE client_id = '".$data_manifest[0]['client_id']."' AND vehicle_status = '".$data_manifest[0]['vehicle_status']."' AND  origin = '".$data_manifest[0]['origin_id']."' AND  destination = '".$data_manifest[0]['destination_id']."' AND id_vehicle_type = '".$data_manifest[0]['id_vehicle_type']."'  ");
					$check_client_rate = $select_client_rate->num_rows();
					$data_client_rate = $select_client_rate->result_array();
					
					
					
					$select_transporter_rate = $this->db->query("SELECT * FROM transporter_rate WHERE client_id = '".$data_manifest[0]['client_id']."' AND vehicle_status = '".$data_manifest[0]['vehicle_status']."' AND  origin = '".$data_manifest[0]['origin_id']."' AND  destination = '".$data_manifest[0]['destination_id']."' AND 	id_vehicle_type = '".$data_manifest[0]['id_vehicle_type']."' AND transporter_id = '".$data_manifest[0]['transporter_id']."' ");
					$check_transporter_rate = $select_transporter_rate->num_rows();
					$data_transporter_rate = $select_transporter_rate->result_array();
					
					echo $check_transporter_rate;
				
					if($check_client_rate>=1 && $check_transporter_rate)
					{
							
							$rate = $data_transporter_rate[0]['vehicle_rate'];
							$client_rate = $data_client_rate[0]['vehicle_rate'];
							echo $rate;
							$data_update = array(
							"rate"=> $rate,
							"client_rate"=> $client_rate,
							"confirmed_manifest"=> $confirmed_manifest,
							"updated_by"=> $username,
							"updated_date"=> $timestamp
							);
							
							$where = array(
							
								"id_manifest" => $id_manifest,

							);
							
							$res = $this->model_route_planning->UpdateData("master_manifest",$data_update,$where);
							if($res)
							{
									$this->session->set_flashdata('message_success',"Data route planning has been successfully updated!");
									redirect('route_planning?delivery_date='.$delivery_date.'&&trip='.$trip.'&&client_id='.$client_id);
								}
							else{
								
									$this->session->set_flashdata('message_failed',"Data RoutePlanning failed to update!");
									redirect('route_planning');
								}
					}
					else
					{
						$this->session->set_flashdata('message_failed',"Data RoutePlanning failed to confirm, Plese set the rate!");
						redirect('route_planning');
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
	
	public function confirmedVehicle()
	{
			date_default_timezone_set('Asia/Jakarta');
			ini_set('memory_limit', '-1');
			
			if ($this->tank_auth->is_logged_in()) {
			$user	= $this->tank_auth->get_username();
			$data_account = $this->model_account_master->getAccount("WHERE username = '".$user."' ")->result_array();
			$data_role = $this->model_account_master->getRole("WHERE id_role = '".$data_account[0]['user_access']."' ")->result_array();
			$user_role = $data_account[0]['user_type'];
			$code_role = $data_account[0]['code'];
			
			if($data_role[0]['add_route_planning']=='yes')
			{
				// Get Variable Post
				$delivery_date = $_POST['delivery_date_confirmed_vehicle'];
				$trip = $_POST['trip_confirmed_vehicle'];
				$client_id = $_POST['client_id_confirmed_vehicle'];
				$timestamp = date('Y:m:d H:i:s');
				$username = $user;
				$id_manifest =  $_POST['id_manifest_confirmed_vehicle'];
				$origin_id =  $_POST['origin_id'];
				$origin_address = $_POST['origin_address'];
				$origin_area = $_POST['origin_area'];
				$destination_id = $_POST['destination_id'];
				$destination_address = $_POST['destination_address'];
				$destination_area = $_POST['destination_area'];
				$client_name = $_POST['client_name'];
				$volume_cap = $_POST['volume_cap'];
				$weight_cap = $_POST['weight_cap'];
				$remark = $_POST['remark'];
				$mode = $_POST['mode'];
				$seal_number = $_POST['seal_number'];
				$cont_number = $_POST['cont_number'];
				$id_trucking_order = $_POST['id_trucking_order'];
				
				$transporter = $_POST['transporter'];
				//Vendor
				$transporter_id = $_POST['transporter_id'];
				$transporter_name = $_POST['transporter_name'];
				$vehicle_type_vendor = $_POST['vehicle_type_vendor'];
				$vehicle_type_id_vendor = $_POST['vehicle_type_id_vendor'];
				$vehicle_id_vendor = $_POST['vehicle_id_vendor'];
				$driver_vendor = $_POST['driver_vendor'];
				$driver_vendor_phone_number = $_POST['driver_vendor_phone_number'];
				
				//assets
				$vehicle_id_assets = $_POST['vehicle_id_assets'];
				$vehicle_type_assets = $_POST['vehicle_type_assets'];
				$vehicle_type_id_assets = $_POST['vehicle_type_id_assets'];
				$driver_name_assets = $_POST['driver_name_assets'];
				$driver_code_assets = $_POST['driver_code_assets'];
				
				$vehicle_status = $_POST['vehicle_status'];
				
				if($transporter=='assets')
				{
					$vehicle_id = $vehicle_id_assets ;
					$vehicle_type = $vehicle_type_assets ;
					$id_vehicle_type = $vehicle_type_id_assets ;
					$transporter_id = '';
					$transporter_name = '';
					$driver_code = $driver_code_assets ;
					$driver_name = $driver_name_assets;
					$driver_phone_number = '';
					
				}
				else if($transporter=='vendor')
				{
					$vehicle_id = $vehicle_id_vendor ;
					$vehicle_type = $vehicle_type_vendor ;
					$id_vehicle_type = $vehicle_type_id_vendor ;
					$transporter_id = $transporter_id;
					$transporter_name = $transporter_name;
					$driver_code = '' ;
					$driver_name = $driver_vendor;
					$driver_phone_number = $driver_vendor_phone_number;
				}
				
				$data_vehicle_type = $this->db->query("SELECT * FROM vehicle_type WHERE vehicle_type = '".$vehicle_type."' ")->result_array();
				$id_vehicle_type = $data_vehicle_type[0]['id_vehicle_type'];
				
				
				$data_update = array(
				
				"id_trucking_order" => $id_trucking_order,
				"driver_code" => $driver_code,
				"driver_name" => $driver_name,
				"driver_phone_number" => $driver_phone_number,
				"transporter" => $transporter,
				"transporter_id" => $transporter_id,
				"transporter_name" => $transporter_name,
				"volume_cap" => $volume_cap,
				"weight_cap" => $weight_cap,
				"remark" => $remark,
				"vehicle_id" => $vehicle_id,
				"vehicle_status" => $vehicle_status,
				"vehicle_type" => $vehicle_type,
				"id_vehicle_type" => $id_vehicle_type,
				"origin_id" => $origin_id,
				"origin_address" => $origin_address,
				"origin_area" => $origin_area,
				"destination_id" => $destination_id,
				"destination_address" => $destination_address,
				"destination_area" => $destination_area,
				"confirmed_vehicle"=> 'yes',
				"mode" => $mode,
				"seal_number" => $seal_number,
				"cont_number" => $cont_number,
				"updated_by"=> $username,
				"updated_date"=> $timestamp

				);
				
				$where = array(
				
				"id_manifest" => $id_manifest,

				);
				
				$res = $this->model_route_planning->UpdateData("master_manifest",$data_update,$where);
				if($res)
				{
						$this->session->set_flashdata('message_success',"Data route planning has been successfully updated!");
						redirect('route_planning?delivery_date='.$delivery_date.'&&trip='.$trip.'&&client_id='.$client_id);
					}
				else{
					
						$this->session->set_flashdata('message_failed',"Data RoutePlanning failed to update!");
						redirect('route_planning');
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
	
	public function deleteTransportOrder()
	{
		
			date_default_timezone_set('Asia/Jakarta');
			ini_set('memory_limit', '-1');
			
			if ($this->tank_auth->is_logged_in()) {
			$user	= $this->tank_auth->get_username();
			$data_account = $this->model_account_master->getAccount("WHERE username = '".$user."' ")->result_array();
			$data_role = $this->model_account_master->getRole("WHERE id_role = '".$data_account[0]['user_access']."' ")->result_array();
			$user_role = $data_account[0]['user_type'];
			$code_role = $data_account[0]['code'];
			
			if($data_role[0]['delete_route_planning']=='yes')
			{
				
				// Get Variable Post
				$timestamp = date('Y:m:d H:i:s');
				$username = $user;
				$manifest = $_POST['manifest'];
				$spk_number = $_POST['spk_number'];
				
			
					$update_transport_order = $this->db->query("update transport_order SET manifest='0',trip ='0' WHERE spk_number = '".$spk_number."' ");
					if($update_transport_order)
					{
						echo "<div id='message'>sukses</div>";
					}
					else{
						echo "<div id='message'>gagal</div>";
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
	
	public function deleteManifest()
	{
		
			date_default_timezone_set('Asia/Jakarta');
			ini_set('memory_limit', '-1');
			
			if ($this->tank_auth->is_logged_in()) {
			$user	= $this->tank_auth->get_username();
			$data_account = $this->model_account_master->getAccount("WHERE username = '".$user."' ")->result_array();
			$data_role = $this->model_account_master->getRole("WHERE id_role = '".$data_account[0]['user_access']."' ")->result_array();
			$user_role = $data_account[0]['user_type'];
			$code_role = $data_account[0]['code'];
			
			if($data_role[0]['add_route_planning']=='yes')
			{
				
				// Get Variable Post
				$timestamp = date('Y:m:d H:i:s');
				$username = $user;
				$manifest = $_POST['manifest'];
				
				$delete_manifest = $this->db->query("DELETE FROM master_manifest WHERE id_manifest = '".$manifest."' ");
				if($delete_manifest)
				{
					$update_transport_order = $this->db->query("update transport_order SET manifest='0',trip ='0' WHERE manifest = '".$manifest."' ");
					if($update_transport_order)
					{
						echo "<div id='message'>sukses</div>";
					}
				
				}
				else{
					
						echo "<div id='message'>gagal</div>";
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
	
	public function updateManifest()
	{
		
			date_default_timezone_set('Asia/Jakarta');
			ini_set('memory_limit', '-1');
			
			if ($this->tank_auth->is_logged_in()) {
			$user	= $this->tank_auth->get_username();
			$data_account = $this->model_account_master->getAccount("WHERE username = '".$user."' ")->result_array();
			$data_role = $this->model_account_master->getRole("WHERE id_role = '".$data_account[0]['user_access']."' ")->result_array();
			$user_role = $data_account[0]['user_type'];
			$code_role = $data_account[0]['code'];
			
			if($data_role[0]['add_route_planning']=='yes')
			{
				
				// Get Variable Post
				$timestamp = date('Y:m:d H:i:s');
				$username = $user;
				$manifest =  $_POST['manifest'];
				$spk_number =  $_POST['spk_number'];
				$delivery_date = explode('-',$_POST['delivery_date']);
				$delivery_date = $delivery_date[2].'-'.$delivery_date[1].'-'.$delivery_date[0];
				$trip = $_POST['trip'];
				
				$data_transport_order = $this->db->query("SELECT * FROM transport_order WHERE spk_number = '".$spk_number."' ")->result_array();
				
				$check_manifest = $this->db->query("SELECT * FROM transport_order WHERE manifest = '".$manifest."' ")->num_rows();
				if($check_manifest>=1){
					
					//check Apakah Client Sama atau tidak
					$data_manifest = $this->db->query("SELECT * FROM master_manifest WHERE id_manifest = '".$manifest."' ")->result_array();
					if($data_transport_order[0]['client_id']==$data_manifest[0]['client_id'])
					{
						//echo $data_transport_order[0]['client_id']."<br>";
						//echo $data_manifest[0]['client_id'];
						//echo "<div id='message'>sukses</div>";
						$update_transport_order = $this->db->query("UPDATE transport_order SET manifest = '".$manifest."',trip = '".$trip."',delivery_date = '".$delivery_date."' WHERE spk_number = '".$spk_number."' ");
						if($update_transport_order)
						{ echo "<div id='message'>sukses</div>"; }
						else{ echo "<div id='message'>gagal</div>"; }
					}
					else
					{echo "<div id='message'>beda</div>";}
				}
				else{
					$update_transport_order = $this->db->query("UPDATE transport_order SET manifest = '".$manifest."',trip = '".$trip."',delivery_date = '".$delivery_date."' WHERE spk_number = '".$spk_number."' ");
					$update_manifest = $this->db->query("UPDATE master_manifest SET client_id = '".$data_transport_order[0]['client_id']."',client_name = '".$data_transport_order[0]['client_name']."' WHERE id_manifest = '".$manifest."' ");
					if($update_transport_order && $update_manifest)
					{ echo "<div id='message'>sukses</div>"; }
					else{ echo "<div id='message'>gagal</div>"; }
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
	
	
	public function saveManifest()
	{
		
			date_default_timezone_set('Asia/Jakarta');
			ini_set('memory_limit', '-1');
			
			if ($this->tank_auth->is_logged_in()) {
			$user	= $this->tank_auth->get_username();
			$data_account = $this->model_account_master->getAccount("WHERE username = '".$user."' ")->result_array();
			$data_role = $this->model_account_master->getRole("WHERE id_role = '".$data_account[0]['user_access']."' ")->result_array();
			$user_role = $data_account[0]['user_type'];
			$code_role = $data_account[0]['code'];
			
			if($data_role[0]['add_route_planning']=='yes')
			{
				
				// Get Variable Post
				$timestamp = date('Y:m:d H:i:s');
				$username = $user;
				$delivery_date = explode('-',$_POST['delivery_date']);
				$delivery_date = $delivery_date[2].'-'.$delivery_date[1].'-'.$delivery_date[0];
				$trip = $_POST['trip'];
				$vehicle_id = $_POST['vehicle_id'];
				$vehicle_type = $_POST['vehicle_type'];
				$description = $_POST['description'];
				
				$data_insert = array(
					"vehicle_id" => $vehicle_id,
					"vehicle_type" => $vehicle_type,
					"trip" => $trip,
					"delivery_date" => $delivery_date,
					"created_by" => $user,
					"created_date" => $timestamp
				);
				
					$check = $this->model_route_planning->getRoutePlanning("WHERE vehicle_id = '".$vehicle_id."' AND trip = '".$trip."' AND delivery_date = '".$delivery_date."' ");
					if($check->num_rows() >=1 )
					{
						echo "<div id='message'>gagal</div>"; 
						
						}
					else
					{
						
						$res = $this->model_route_planning->insertData("master_manifest",$data_insert);
						if($res>=1)
						{
							 $data_last_manifest = $this->db->query("SELECT * FROM master_manifest WHERE trip = '".$trip."' AND delivery_date = '".$delivery_date."' ORDER BY id_manifest DESC   ")->result_array();
							 
							 echo "<div id='message'>sukses</div><div id='manifest'>".$data_last_manifest[0]['id_manifest']."</div>"; 
						}
						else{
							
							echo "<div id='message'>gagal</div>";
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
	
	
	public function deleteRoutePlanningAll()
	{
		
			date_default_timezone_set('Asia/Jakarta');
			ini_set('memory_limit', '-1');
			
			if ($this->tank_auth->is_logged_in()) {
			$user	= $this->tank_auth->get_username();
			$data_account = $this->model_account_master->getAccount("WHERE username = '".$user."' ")->result_array();
			$data_role = $this->model_account_master->getRole("WHERE id_role = '".$data_account[0]['user_access']."' ")->result_array();
			$user_role = $data_account[0]['user_type'];
			$code_role = $data_account[0]['code'];
			if($data_role[0]['delete_route_planning']=='yes')
			{
				
			
				// Get Variable Post
				$id_route_planning_delete = $_POST['id_route_planning_delete_all'];
				
		
					//Update Product
					$res = $this->db->query("DELETE FROM route_planning WHERE id_route_planning in (".$id_route_planning_delete.") ");
					if($res>=1)
					{
						$this->session->set_flashdata('message_success',"Data route_planning has been successfully deleted!");
						redirect('route_planning');
						
						}
					else
					{
						$this->session->set_flashdata('message_failed',"Data RoutePlanning failed to delete!");
						redirect('route_planning');
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
	
	public function editRoutePlanning($id_channel)
	{
		
			date_default_timezone_set('Asia/Jakarta');
			ini_set('memory_limit', '-1');
			
			if ($this->tank_auth->is_logged_in()) {
			$user	= $this->tank_auth->get_username();
			$data_account = $this->model_account_master->getAccount("WHERE username = '".$user."' ")->result_array();
			$data_role = $this->model_account_master->getRole("WHERE id_role = '".$data_account[0]['user_access']."' ")->result_array();
			$user_role = $data_account[0]['user_type'];
			$code_role = $data_account[0]['code'];
			
			if($data_role[0]['edit_route_planning']=='yes')
			{
				
			
				// Get Variable Post
				$route_planning_code = $_POST['edit_route_planning_code'];
				$route_planning_name = $_POST['edit_route_planning_name'];
				$password = $_POST['edit_password1'];
				$id_route_planning = $_POST['id_route_planning_update'];
				
				$data_update_with_password = array(
				
				"route_planning_code" => $route_planning_code,
				"route_planning_name" => $route_planning_name,
				"password" => md5($password)

				);
				$data_update_without_password = array(
				
				"route_planning_code" => $route_planning_code,
				"route_planning_name" => $route_planning_name,

				);
				
				$where = array("id_route_planning"=>$id_route_planning);
				
				//Check Product Apakah sudah ada dengan kode produk dan type motorist yang sama
				$check = $this->model_route_planning->getRoutePlanning("WHERE route_planning_code = '".$route_planning_code."' AND id_route_planning != '".$id_route_planning."' ");
				
				
				if($check->num_rows() >=1 )
				{
					$this->session->set_flashdata('message_failed',"Sorry data already exist!");
					redirect('route_planning');
					
					}
				else
				{
				
					//Update
					if($password=='')
					{
					$res = $this->model_route_planning->UpdateData("route_planning",$data_update_without_password,$where);
					}
					else{$res = $this->model_route_planning->UpdateData("route_planning",$data_update_with_password,$where);}
					
					if($res>=1)
					{
						$this->session->set_flashdata('message_success',"Data RoutePlanning has been successfully updated!");
						
						redirect('route_planning');
						
						}
					else
					{
						$this->session->set_flashdata('message_failed',"Data RoutePlanning failed to update!");
						redirect('route_planning');
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
	
	
	public function deleteRoutePlanning()
	{
		
			date_default_timezone_set('Asia/Jakarta');
			ini_set('memory_limit', '-1');
			
			if ($this->tank_auth->is_logged_in()) {
			$user	= $this->tank_auth->get_username();
			$data_account = $this->model_account_master->getAccount("WHERE username = '".$user."' ")->result_array();
			$data_role = $this->model_account_master->getRole("WHERE id_role = '".$data_account[0]['user_access']."' ")->result_array();
			$user_role = $data_account[0]['user_type'];
			$code_role = $data_account[0]['code'];
			if($data_role[0]['delete_route_planning']=='yes')
			{
				
			
				// Get Variable Post
				$id_route_planning_delete = $_POST['id_route_planning_delete'];
				$where = array("id_route_planning" => $id_route_planning_delete);
				
		
					//Update Product
					$res = $this->model_route_planning->DeleteData("route_planning",$where);
					if($res>=1)
					{
						$this->session->set_flashdata('message_success',"Data route_planning has been successfully deleted!");
						redirect('route_planning');
						
						}
					else
					{
						$this->session->set_flashdata('message_failed',"Data RoutePlanning failed to delete!");
						redirect('route_planning');
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
	
	public function exportRoutePlanning()
	{
		
		date_default_timezone_set('Asia/Jakarta');
		if ($this->tank_auth->is_logged_in()) {
		$user	= $this->tank_auth->get_username();
		$data_account = $this->model_account_master->getAccount("WHERE username = '".$user."' ")->result_array();
		$data_role = $this->model_account_master->getRole("WHERE id_role = '".$data_account[0]['user_access']."' ")->result_array();
		$user_role = $data_account[0]['user_type'];
		$code_role = $data_account[0]['code'];
		
		if($data_role[0]['export_route_planning']=='yes')
		{
		$search = isset($_GET['search']) ? $_GET['search'] : '';

		
		$date = date("m-d-Y");
		$this->db->or_like('route_planning_code', $search);
		$query = $this->db->get('route_planning');
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
		
		
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 1, "Master RoutePlanning");
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
		"RoutePlanning Code" => "RoutePlanning Code",
		"RoutePlanning Name" => "RoutePlanning Name"
		
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
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $row, $data['route_planning_code']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $row, $data['route_planning_name']);
 
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
        header('Content-Disposition: attachment;filename="Master-route_planning-'.$date.'.xls"');
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
		
		
	
	
	
	
	public function exportSPkDriver()
	{
		
		date_default_timezone_set('Asia/Jakarta');
		if ($this->tank_auth->is_logged_in()) {
		$user	= $this->tank_auth->get_username();
		$data_account = $this->model_account_master->getAccount("WHERE username = '".$user."' ")->result_array();
		$data_role = $this->model_account_master->getRole("WHERE id_role = '".$data_account[0]['user_access']."' ")->result_array();
		$user_role = $data_account[0]['user_type'];
		$code_role = $data_account[0]['code'];
		
		if($data_role[0]['export_route_planning']=='yes')
		{
		$id = isset($_GET['id']) ? $_GET['id'] : '';

		
		$date = date("m-d-Y");
		$data_manifest = $this->db->query("SELECT * FROM master_manifest WHERE id_manifest = '".$id."' ")->result_array();
		
 
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
		
		
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 1, "SPK Pengemudi");
		//Merge And Center Title
		$objPHPExcel->getActiveSheet()->mergeCells('A1:D1');
		
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 2, "Download Date : ".$date);
		
		//Merge And Center Date
		$objPHPExcel->getActiveSheet()->mergeCells('A2:D2');
		
		//Set Font Color Title
		//$objPHPExcel->getActiveSheet()->getStyle('A1:D2')->applyFromArray($FontstyleTitle);
		
		//Set Font Color Header
		//$objPHPExcel->getActiveSheet()->getStyle('A4:C4')->applyFromArray($Fontstyle);
		
		//Set Backgroung Color Header

		
		$delivery_date = explode('-',$data_manifest[0]['delivery_date']);
		$delivery_date = $delivery_date[2].'-'.$delivery_date[1].'-'.$delivery_date[0];
		
		
		// Kolom Kiri
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 4, "Manifest ID");
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, 4, ': '.$data_manifest[0]['id_manifest']);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 5, "Delivery Date");		
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, 5, ': '.$delivery_date);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 6, "Origin ID");		
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, 6, ': '.$data_manifest[0]['origin_id']);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 7, "Origin Address");		
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, 7, ': '.$data_manifest[0]['origin_address']);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 8, "Origin Area");		
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, 8, ': '.$data_manifest[0]['origin_area']);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 9, "Destination ID");		
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, 9, ': '.$data_manifest[0]['destination_id']);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 10, "Destination Address");		
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, 10, ': '.$data_manifest[0]['destination_address']);
		
		//Kolom Kanan
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, 4, "Client ID");
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, 4, ': '.$data_manifest[0]['client_id']);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, 5, "Client Name");		
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, 5, ': '.$data_manifest[0]['client_name']);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, 6, "Driver Name");		
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, 6, ': '.$data_manifest[0]['driver_name']);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, 7, "Driver Code");		
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, 7, ': '.$data_manifest[0]['driver_code']);
		
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 11, "Jumlah Uang Jalan : RP ".number_format($data_manifest[0]['rate'], 0 , '' , '.' ));
		
		
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, 13, "TTD Supir");
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, 13, "TTD Mandor");
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, 13, "TTD Kasir");
		
		$objPHPExcel->getActiveSheet()->mergeCells('B14:B18');
		$objPHPExcel->getActiveSheet()->mergeCells('C14:C18');
		$objPHPExcel->getActiveSheet()->mergeCells('D14:D18');
		
		$objPHPExcel->getActiveSheet()->getStyle("B13".":"."D18")->applyFromArray($BStyle);
		
		$objPHPExcel->getActiveSheet()->mergeCells('A11:D11');
		

		
		 $objPHPExcel->getActiveSheet()->getStyle("A4".":"."D11")->applyFromArray($BStyle);
	   
		   foreach(range('A','G') as $columnID) {
		$objPHPExcel->getActiveSheet()->getColumnDimension($columnID)
			->setAutoSize(true);
	}

		//Merge And Center Title
		$objPHPExcel->getActiveSheet()->mergeCells('A1:D1');
		
		
		//Merge And Center Title
		$objPHPExcel->getActiveSheet()->mergeCells('A1:D1');
		
		
       $objPHPExcel->setActiveSheetIndex(0);
 
        $objWriter = IOFactory::createWriter($objPHPExcel, 'Excel5');
 		
		
	   // Sending headers to force the user to download the file
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="spk-pengemudi-'.$date.'-'.$data_manifest[0]['driver_name'].'.xls"');
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
	
	public function importRoutePlanning()
	{
		
			date_default_timezone_set('Asia/Jakarta');
			ini_set('memory_limit', '-1');
			
			if ($this->tank_auth->is_logged_in()) {
			$user	= $this->tank_auth->get_username();
			$data_account = $this->model_account_master->getAccount("WHERE username = '".$user."' ")->result_array();
			$data_role = $this->model_account_master->getRole("WHERE id_role = '".$data_account[0]['user_access']."' ")->result_array();
			$user_role = $data_account[0]['user_type'];
			$code_role = $data_account[0]['code'];
			
			if($data_role[0]['import_route_planning']=='yes')
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
				redirect('route_planning');
				
				
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
					$check = $this->model_route_planning->getRoutePlanning("WHERE route_planning_code  = '".$rowData[0][0]."' ");
					if($check->num_rows() >=1 )
					{
						
						$data_update = array(
							"route_planning_name" => $rowData[0][1],
							"password" => md5($rowData[0][2])
							
						);
						$where = array(
							"route_planning_code" => $rowData[0][0]
						);
						
						$res = $this->model_route_planning->UpdateData("route_planning",$data_update,$where);
					
						}
					else
					{
						$data_insert = array(
							"route_planning_code" => $rowData[0][0],
							"route_planning_name" => $rowData[0][1],
							"password" => md5($rowData[0][2])
						);
						
						//Insert Data
						$res = $this->model_route_planning->insertData("route_planning",$data_insert);
					
					}
					
				
				
			}
				@unlink($inputFileName);
				$this->session->set_flashdata('message_success','Data imported successfully');
				redirect('route_planning');
			
               
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
	
	public function addRoutePlanning()
	{
		
			date_default_timezone_set('Asia/Jakarta');
			ini_set('memory_limit', '-1');
			
			if ($this->tank_auth->is_logged_in()) {
			$user	= $this->tank_auth->get_username();
			$data_account = $this->model_account_master->getAccount("WHERE username = '".$user."' ")->result_array();
			$data_role = $this->model_account_master->getRole("WHERE id_role = '".$data_account[0]['user_access']."' ")->result_array();
			$user_role = $data_account[0]['user_type'];
			$code_role = $data_account[0]['code'];
			
			if($data_role[0]['add_route_planning']=='yes')
			{
				
			
				// Get Variable Post
				$route_planning_code = $_POST['route_planning_code'];
				$route_planning_name = $_POST['route_planning_name'];
				
				
				$data_insert = array(
				"route_planning_code" => $route_planning_code,
				"route_planning_name" => $route_planning_name,
				"password" => $password

				);
				
				//Check Product Apakah sudah ada dengan kode produk dan type motorist yang sama
				$check = $this->model_route_planning->getRoutePlanning("WHERE route_planning_code = '".$route_planning_code."' ");
				if($check->num_rows() >=1 )
				{
					$this->session->set_flashdata('message_failed',"Sorry data already exist!");
					redirect('route_planning');
					
					}
				else
				{
					
					$res = $this->model_route_planning->insertData("route_planning",$data_insert);
					if($res>=1)
					{
						$this->session->set_flashdata('message_success',"Data route_planning has been successfully saved!");
						redirect('route_planning');
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
			
			if($data_role[0]['see_route_planning']=='yes')
			{	
			$this->load->library('table');
			$this->load->library('pagination');
		
			$comp = array(
				'title' => ' RoutePlanning',
				'content' => $this->load->view('route_planning',array('data_role'=>$data_role),true),
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