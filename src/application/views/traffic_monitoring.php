 <!-- HEADER -->
 <section class="content-header">
          <h1>
            Traffic Monitoring
            <small>List Of Traffic Monitoring</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="<?php echo BASE_URL(); ?>"><i class="fa fa-dashboard"></i>Home</a></li>
            <li><a href="<?php echo BASE_URL()."traffic_monitoring"; ?>"><i class="fa fa-dashboard"></i>Traffic Monitoring</a></li>
          </ol>
        </section>
  
  
   <!-- Content -->
   <section class="content">
		
		
  
  
          <div class="box sms box-default color-palette-box">
            <div class="box-header with-border">
              <h3 class="box-title"><i class="fa fa-table"></i> Table Traffic Monitoring</h3>
            </div>
            <div class="box-body">
            <?php $message_success = $this->session->flashdata('message_success');
					 	if($message_success!="")
						{
					  ?>
                     <div class="alert alert-success"><?php echo $message_success; ?></div>
                     <?php } ?>
                     <?php $message_failed = $this->session->flashdata('message_failed');
					 	if($message_failed!="")
						{
					  ?>
                     <div class="alert alert-danger"><?php echo $message_failed; ?></div>
                     <?php } ?>
            <div id="wrapper-table">
            <?php
			$search = isset($_GET['search']) ? $_GET['search'] : '';
			function convert_price($price)
			{
				echo "Rp. ".number_format($price, 0 , '' , '.' );		
					}
					
					function convert_date($date)
			{
				$date = (explode("-",$date));
				$date = $date[2].'-'.$date[1].'-'.$date[0];
				echo $date;
			}
			?>
            <div id="wrapper-console" class="clearfix">
                <div id="wrapper-button" class="clearfix">
					                	<a href="http://tms2.goodevamedia.com/index.php/traffic_monitoring/exportTrafficMonitoring?search=" class="button orange-button">
                    	Export Traffic Monitoring
                    </a><div id="wrapper-search">
                             <form action="http://tms2.goodevamedia.com/index.php/traffic_monitoring" method="get">
                             <input type="hidden" name="xcdsdh" value="1262037a46740530c41b92d23d0a87fa">
                                <input type="text" id="search" name="search" placeholder="Search By SPK Number" value="">
                                <input type="submit" id="submit" value="Search">
                                                             </form>
                </div>
					                </div>
                </div>
            <div id="wrapper-console" class="clearfix"> 
            <div class="grid_4">                  
           	<table id="myTable03" class="fancyTable table-bordered table-hover">
                    <thead>
                      <tr>
                        <th>Point</th>
                        <th>Name</th>
                        <th>Address</th>
						<th>Area</th>
						<th>State</th>
						<th>ETA</th>
						<th>ATA</th>
						<th>Last Check Point Notes</th>
						<th>Check Point Time</th>
						<?php if($data_role[0]['delete_traffic_monitoring']=='yes' || $data_role[0]['edit_traffic_monitoring']=='yes'){ ?>
						<th>Action</th>
						<?php } ?>
                      </tr>
                    </thead>
					
					
             		<tbody>
                    <?php foreach($data_traffic_monitoring as $data_traffic_monitoring) {?>
					
					 <tr id="data_<?php echo $data_traffic_monitoring->id_manifest; ?>" >
							<td colspan='10' style='background:#ccc;'>
								<?php 
								
								$data_transport_order = $this->db->query("SELECT order_type FROM transport_order where manifest = '".$data_traffic_monitoring->id_manifest."' ORDER BY spk_number ")->result_array();
								$delivery_date = explode('-',$data_traffic_monitoring->delivery_date);
								$delivery_date = $delivery_date[2].'-'.$delivery_date[1].'-'.$delivery_date[0];
								echo "ID Manifest - ".$data_traffic_monitoring->id_manifest." - ".$delivery_date." - ".$data_traffic_monitoring->vehicle_id." - ".$data_traffic_monitoring->vehicle_type.' ('.$data_transport_order[0]['order_type'].')'; ?>
							</td>
					 </tr>
					 
					<?php
					//Origin
					$select_transport_order = $this->db->query("SELECT manifest,origin_id,spk_number,origin_address,origin_area,order_type FROM transport_order WHERE manifest = '".$data_traffic_monitoring->id_manifest."' GROUP BY origin_id ");
					$check_transport_order = $select_transport_order->num_rows();
					if($check_transport_order>=1)
					{
						$data_transport_order =  $select_transport_order->result();
						foreach($data_transport_order as $data_transport_order) {
							
							$data_customer = $this->db->query("SELECT * FROM customer WHERE customer_id = '".$data_transport_order->origin_id."' ")->result_array(); 
							
							$class_status = 'blue';
						
							if($data_transport_order->order_type=='Regular')
							{
								$check_arrival = $this->db->query("SELECT * FROM traffic_monitoring_regular WHERE spk_number = '".$data_transport_order->spk_number."' AND state = 'Origin' AND point_id = '".$data_transport_order->origin_id."' AND arrival_actual_date != '0000-00-00' ")->num_rows();
								if($check_arrival>=1)
								{$class_status='yellow';}
							
								
								$check_loading = $this->db->query("SELECT * FROM traffic_monitoring_regular WHERE spk_number = '".$data_transport_order->spk_number."' AND state = 'Origin' AND point_id = '".$data_transport_order->origin_id."' AND loading_unloading_finish_date != '0000-00-00' ")->num_rows();
								if($check_loading>=1)
								{$class_status='green';}
							
								$check_landing = $this->db->query("SELECT * FROM traffic_monitoring_regular WHERE spk_number = '".$data_transport_order->spk_number."' AND state = 'Origin' AND point_id = '".$data_transport_order->origin_id."' AND departure_actual_date != '0000-00-00' ")->num_rows();
								if($check_landing>=1)
								{$class_status='green';}
							}
							else if($data_transport_order->order_type=='Langsir')
							{
								$check_arrival = $this->db->query("SELECT * FROM traffic_monitoring_langsir WHERE spk_number = '".$data_transport_order->spk_number."' AND state = 'Origin' AND point_id = '".$data_transport_order->origin_id."' AND arrival_actual_date != '0000-00-00' ")->num_rows();
								if($check_arrival>=1)
								{$class_status='yellow';}
							
								
								$check_loading = $this->db->query("SELECT * FROM traffic_monitoring_langsir WHERE spk_number = '".$data_transport_order->spk_number."' AND state = 'Origin' AND point_id = '".$data_transport_order->origin_id."' AND loading_landing_finish_date != '0000-00-00' ")->num_rows();
								if($check_loading>=1)
								{$class_status='green';}
							
								$check_landing = $this->db->query("SELECT * FROM traffic_monitoring_langsir WHERE spk_number = '".$data_transport_order->spk_number."' AND state = 'Origin' AND point_id = '".$data_transport_order->origin_id."' AND departure_actual_date != '0000-00-00' ")->num_rows();
								if($check_landing>=1)
								{$class_status='orange';}
							}
							else if($data_transport_order->order_type=='Import')
							{
								$check_arrival = $this->db->query("SELECT * FROM traffic_monitoring_import WHERE spk_number = '".$data_transport_order->spk_number."' AND state = 'Origin' AND point_id = '".$data_transport_order->origin_id."' AND arrival_actual_date != '0000-00-00' ")->num_rows();
								if($check_arrival>=1)
								{$class_status='yellow';}
							
								
								$check_loading = $this->db->query("SELECT * FROM traffic_monitoring_import WHERE spk_number = '".$data_transport_order->spk_number."' AND state = 'Origin' AND point_id = '".$data_transport_order->origin_id."' AND loading_unloading_finish_date != '0000-00-00' ")->num_rows();
								if($check_loading>=1)
								{$class_status='green';}
							
								$check_landing = $this->db->query("SELECT * FROM traffic_monitoring_import WHERE spk_number = '".$data_transport_order->spk_number."' AND state = 'Origin' AND point_id = '".$data_transport_order->origin_id."' AND landing_container_actual_date != '0000-00-00' ")->num_rows();
								if($check_landing>=1)
								{$class_status='orange';}
							
							
							
							}
							else if($data_transport_order->order_type=='Export')
							{
								$check_arrival = $this->db->query("SELECT * FROM traffic_monitoring_export WHERE spk_number = '".$data_transport_order->spk_number."' AND state = 'Origin' AND point_id = '".$data_transport_order->origin_id."' AND 	arrival_actual_date != '0000-00-00' ")->num_rows();
								if($check_arrival>=1)
								{$class_status='yellow';}
							
								
								$check_loading = $this->db->query("SELECT * FROM traffic_monitoring_export WHERE spk_number = '".$data_transport_order->spk_number."' AND state = 'Origin' AND point_id = '".$data_transport_order->origin_id."' AND loading_product_finish_date != '0000-00-00' ")->num_rows();
								if($check_loading>=1)
								{$class_status='green';}
							
								$check_landing = $this->db->query("SELECT * FROM traffic_monitoring_export WHERE spk_number = '".$data_transport_order->spk_number."' AND state = 'Origin' AND point_id = '".$data_transport_order->origin_id."' AND landing_cont_actual_date != '0000-00-00' ")->num_rows();
								if($check_landing>=1)
								{$class_status='orange';}
							
							}
							else if($data_transport_order->order_type=='Langsir_Empty_Cont')
							{
								$check_arrival = $this->db->query("SELECT * FROM traffic_monitoring_langsir_empty WHERE spk_number = '".$data_transport_order->spk_number."' AND state = 'Origin' AND point_id = '".$data_transport_order->origin_id."' AND arrival_actual_date != '0000-00-00' ")->num_rows();
								if($check_arrival>=1)
								{$class_status='yellow';}
							
								
								$check_loading = $this->db->query("SELECT * FROM traffic_monitoring_langsir_empty WHERE spk_number = '".$data_transport_order->spk_number."' AND state = 'Origin' AND point_id = '".$data_transport_order->origin_id."' AND loading_landing_finish_date != '0000-00-00' ")->num_rows();
								if($check_loading>=1)
								{$class_status='green';}
							
								$check_landing = $this->db->query("SELECT * FROM traffic_monitoring_langsir_empty WHERE spk_number = '".$data_transport_order->spk_number."' AND state = 'Origin' AND point_id = '".$data_transport_order->origin_id."' AND departure_actual_date != '0000-00-00' ")->num_rows();
								if($check_landing>=1)
								{$class_status='orange';}
							}
						?>
						  <tr id="data_<?php echo $data_transport_order->spk_number; ?>_origin_<?php echo $data_transport_order->origin_id; ?>">
								<td class="customer_name">
								<div class='<?php echo $class_status; ?> circle'></div>
								<span class='customer_name'><?php echo $data_customer[0]['customer_name']; ?></span>
								<span class='spk_number' style='display:none;'><?php echo $data_transport_order->spk_number; ?></span>
								<span class='manifest_id' style='display:none;'><?php echo $data_transport_order->manifest; ?></span>
								</td>
								
								<td class="origin_destination_id"><?php echo $data_transport_order->origin_id; ?></td>
								<td class="origin_destination_address"><?php echo $data_transport_order->origin_address; ?></td>
								<td class="origin_destination_area"><?php echo $data_transport_order->origin_area; ?></td>
								<td class="state">Origin</td>
								<td class="eta">ETA</td>
								<td class="ata">ATA</td>
								<td class="last_check_point_notes">Last Check Point Notes</td>
								<td class="check_point_time">Check Point Time</td>
								<?php if($data_role[0]['delete_traffic_monitoring']=='yes' || $data_role[0]['edit_traffic_monitoring']=='yes'){ ?>
								<td><?php if($data_role[0]['edit_traffic_monitoring']=='yes'){ ?><a id="<?php echo $data_transport_order->spk_number; ?>_origin_<?php echo $data_transport_order->origin_id; ?>" order_type='<?php echo $data_transport_order->order_type; ?>' state='origin' class="edit_data link_action">Edit</a>
								<a href='<?php echo site_url("traffic_monitoring/detailFromDriver?manifest=".$data_transport_order->manifest."&&state=origin"); ?>'  class="edit_data link_action">Detail From Driver</a>
								
								<?php } ?></td>
								
								<?php } ?>
							</tr>
						<?php 	
						}
					}
					?>
					
					<?php
					//Destination
					$select_transport_order = $this->db->query("SELECT  manifest,destination_id,spk_number,destination_address,destination_area,order_type FROM transport_order WHERE manifest = '".$data_traffic_monitoring->id_manifest."'  GROUP BY destination_id  ");
					$check_transport_order = $select_transport_order->num_rows();
					if($check_transport_order>=1)
					{
						
						$data_transport_order =  $select_transport_order->result();
						foreach($data_transport_order as $data_transport_order) {
							
							$data_customer = $this->db->query("SELECT * FROM customer WHERE customer_id = '".$data_transport_order->destination_id."' ")->result_array();
							
							
							$class_status = 'blue';
							
							if($data_transport_order->order_type=='Regular')
							{
								$check_arrival = $this->db->query("SELECT * FROM traffic_monitoring_regular WHERE spk_number = '".$data_transport_order->spk_number."' AND state = 'Destination' AND point_id = '".$data_transport_order->destination_id."' AND arrival_actual_date != '0000-00-00' ")->num_rows();
								if($check_arrival>=1)
								{$class_status='yellow';}
							
								
								$check_loading = $this->db->query("SELECT * FROM traffic_monitoring_regular WHERE spk_number = '".$data_transport_order->spk_number."' AND state = 'Destination' AND point_id = '".$data_transport_order->destination_id."' AND loading_unloading_finish_date != '0000-00-00' ")->num_rows();
								if($check_loading>=1)
								{$class_status='green';}
							
								$check_landing = $this->db->query("SELECT * FROM traffic_monitoring_regular WHERE spk_number = '".$data_transport_order->spk_number."' AND state = 'Destination' AND point_id = '".$data_transport_order->destination_id."' AND departure_actual_date != '0000-00-00' ")->num_rows();
								if($check_landing>=1)
								{$class_status='green';}
							}
							else if($data_transport_order->order_type=='Langsir')
							{
								$check_arrival = $this->db->query("SELECT * FROM traffic_monitoring_langsir WHERE spk_number = '".$data_transport_order->spk_number."' AND state = 'Destination' AND point_id = '".$data_transport_order->destination_id."' AND arrival_actual_date != '0000-00-00' ")->num_rows();
								if($check_arrival>=1)
								{$class_status='yellow';}
							
								
								$check_loading = $this->db->query("SELECT * FROM traffic_monitoring_langsir WHERE spk_number = '".$data_transport_order->spk_number."' AND state = 'Destination' AND point_id = '".$data_transport_order->destination_id."' AND loading_landing_finish_date != '0000-00-00' ")->num_rows();
								if($check_loading>=1)
								{$class_status='green';}
							
								$check_landing = $this->db->query("SELECT * FROM traffic_monitoring_langsir WHERE spk_number = '".$data_transport_order->spk_number."' AND state = 'Destination' AND point_id = '".$data_transport_order->destination_id."' AND departure_actual_date != '0000-00-00' ")->num_rows();
								if($check_landing>=1)
								{$class_status='orange';}
							}
							else if($data_transport_order->order_type=='Import')
							{
								$check_arrival = $this->db->query("SELECT * FROM traffic_monitoring_import WHERE spk_number = '".$data_transport_order->spk_number."' AND state = 'Destination' AND point_id = '".$data_transport_order->destination_id."' AND arrival_actual_date != '0000-00-00' ")->num_rows();
								if($check_arrival>=1)
								{$class_status='yellow';}
							
								
								$check_loading = $this->db->query("SELECT * FROM traffic_monitoring_import WHERE spk_number = '".$data_transport_order->spk_number."' AND state = 'Destination' AND point_id = '".$data_transport_order->destination_id."' AND loading_unloading_finish_date != '0000-00-00' ")->num_rows();
								if($check_loading>=1)
								{$class_status='green';}
							
								$check_landing = $this->db->query("SELECT * FROM traffic_monitoring_import WHERE spk_number = '".$data_transport_order->spk_number."' AND state = 'Destination' AND point_id = '".$data_transport_order->destination_id."' AND landing_container_actual_date != '0000-00-00' ")->num_rows();
								if($check_landing>=1)
								{$class_status='orange';}
							}
							else if($data_transport_order->order_type=='Export')
							{
								$check_arrival = $this->db->query("SELECT * FROM traffic_monitoring_export WHERE spk_number = '".$data_transport_order->spk_number."' AND state = 'Destination' AND point_id = '".$data_transport_order->destination_id."' AND 	arrival_actual_date != '0000-00-00' ")->num_rows();
								if($check_arrival>=1)
								{$class_status='yellow';}
							
								
								$check_loading = $this->db->query("SELECT * FROM traffic_monitoring_export WHERE spk_number = '".$data_transport_order->spk_number."' AND state = 'Destination' AND point_id = '".$data_transport_order->destination_id."' AND loading_product_finish_date != '0000-00-00' ")->num_rows();
								if($check_loading>=1)
								{$class_status='green';}
							
								$check_landing = $this->db->query("SELECT * FROM traffic_monitoring_export WHERE spk_number = '".$data_transport_order->spk_number."' AND state = 'Destination' AND point_id = '".$data_transport_order->destination_id."' AND landing_cont_actual_date != '0000-00-00' ")->num_rows();
								if($check_landing>=1)
								{$class_status='orange';}
							}
							else if($data_transport_order->order_type=='Langsir_Empty_Cont')
							{
								$check_arrival = $this->db->query("SELECT * FROM traffic_monitoring_langsir_empty WHERE spk_number = '".$data_transport_order->spk_number."' AND state = 'Destination' AND point_id = '".$data_transport_order->destination_id."' AND arrival_actual_date != '0000-00-00' ")->num_rows();
								if($check_arrival>=1)
								{$class_status='yellow';}
							
								
								$check_loading = $this->db->query("SELECT * FROM traffic_monitoring_langsir_empty WHERE spk_number = '".$data_transport_order->spk_number."' AND state = 'Destination' AND point_id = '".$data_transport_order->destination_id."' AND loading_landing_finish_date != '0000-00-00' ")->num_rows();
								if($check_loading>=1)
								{$class_status='green';}
							
								$check_landing = $this->db->query("SELECT * FROM traffic_monitoring_langsir_empty WHERE spk_number = '".$data_transport_order->spk_number."' AND state = 'Destination' AND point_id = '".$data_transport_order->destination_id."' AND departure_actual_date != '0000-00-00' ")->num_rows();
								if($check_landing>=1)
								{$class_status='orange';}
							}
						
						
						?>
						
						  <tr id="data_<?php echo $data_transport_order->spk_number; ?>_destination_<?php echo $data_transport_order->destination_id; ?>">
								<td class="customer_name">
								<div class='<?php echo $class_status; ?> circle'></div>
								<span class='customer_name'><?php echo $data_customer[0]['customer_name']; ?></span>
								<span class='spk_number' style='display:none;'><?php echo $data_transport_order->spk_number; ?></span>
								<span class='manifest_id' style='display:none;'><?php echo $data_transport_order->manifest; ?></span>
								</td>
								<td class="origin_destination_id"><?php echo $data_transport_order->destination_id; ?></td>
								<td class="origin_destination_address"><?php echo $data_transport_order->destination_address; ?></td>
								<td class="origin_destination_area"><?php echo $data_transport_order->destination_area; ?></td>
								<td class="state">Destination</td>
								<td class="eta">ETA</td>
								<td class="ata">ATA</td>
								<td class="last_check_point_notes">Last Check Point Notes</td>
								<td class="check_point_time">Check Point Time</td>
								<?php if($data_role[0]['delete_traffic_monitoring']=='yes' || $data_role[0]['edit_traffic_monitoring']=='yes'){ ?>
								<td><?php if($data_role[0]['edit_traffic_monitoring']=='yes'){ ?><a  id="<?php echo $data_transport_order->spk_number; ?>_destination_<?php echo $data_transport_order->destination_id; ?>" order_type='<?php echo $data_transport_order->order_type; ?>' state='destination' class="edit_data link_action">Edit</a>
								<a href='<?php echo site_url("traffic_monitoring/detailFromDriver?manifest=".$data_transport_order->manifest."&&state=destination"); ?>'  class="edit_data link_action">Detail From Driver</a>
								<?php } ?></td>
								<?php } ?>
							</tr>
						<?php 	
						}
					}
					?>
					
                    <?php }?>
                    </tbody>       
             </table>
             </div>
             
            		  <div class="pagination page">  
                     <?php  echo $this->pagination->create_links(); ?>
                     </div>
                    
            
           </div>
            </div>
            
            </div>
      </section>
	
	<div class="remodal" data-remodal-id="modal_edit_regular" role="dialog" aria-labelledby="modal1Titl aria-describedby="modal1Desc">
	  <button data-remodal-action="close" class="remodal-close" aria-label="Close"></button>
	  <div>
		<h2 id="modal1Title">Update Traffic Monitoring Regular</h2>
				<form role="form" id="form_update_regular" method="POST" action="<?php echo base_url()."index.php/traffic_monitoring/updateTrafficMonitoringRegular" ?>" enctype="multipart/form-data">
				 <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
				 
               <div class="box-body form">
				
			  
				
				<div class="form-group">
					  <label for="drivercode2">Point ID</label>
					 <input type="text" class="form-control" name="regular_client_id" id="regular_client_id" required>
				</div>
				
				<div class="form-group">
					  <label for="drivercode2">Name</label>
					 <input type="text" class="form-control" name="regular_client_name" id="regular_client_name" required>
				</div>
				
				<div class="form-group">
					  <label for="drivercode2">Address</label>
					 <input type="text" class="form-control" name="regular_address" id="regular_address" required>
				</div>
		  
				
				 
				 <h3>Arrival</h3>
				 
				 <div class="form-group">
						  <label for="drivercode2">Estimation</label>
						  <div class='wrapper-time-monitoring clearfix'>
						  
						  <div class="input-group checklist tiga_input">
							<input type='checkbox' name='regular_arrival_estimation' class='regular_arrival_estimation regular_checkbox_time' id='regular_arrival_estimation'>
						  </div>
						  
						  <div class="input-group date tiga_input">
						  <div class="input-group-addon">
							<i class="fa fa-calendar"></i>
						  </div>
						  <input type="text" name="regular_arrival_estimation_date" id="regular_arrival_estimation_date" class="form-control pull-right datepicker regular_arrival_estimation"  placeholder='Arrival Estimation Date' >
						  </div>
						  
						  <div class="bootstrap-timepicker  tiga_input time">
						  <div class="input-group">
						  <input type="text"  name="regular_arrival_estimation_time" id="regular_arrival_estimation_time" class="form-control timepicker regular_arrival_estimation" placeholder='Arrival Estimation Time'>
						  <div class="input-group-addon">
						  <i class="fa fa-clock-o"></i>
						  </div>
						  </div>
					      </div>
						  </div>
				</div>
				
				<div class="form-group">
						  <label for="drivercode2">Actual</label>
						  <div class='wrapper-time-monitoring clearfix'>
						  
						  <div class="input-group checklist tiga_input">
							<input type='checkbox' name='regular_arrival_actual' class='regular_arrival_actual regular_checkbox_time' id='regular_arrival_actual'>
						  </div>
						  
						  <div class="input-group date tiga_input">
						  <div class="input-group-addon">
							<i class="fa fa-calendar"></i>
						  </div>
						  <input type="text" name="regular_arrival_actual_date" id="regular_arrival_actual_date" class="form-control pull-right datepicker regular_arrival_actual"  placeholder='Arrival Actual Date' >
						  </div>
						  
						  <div class="bootstrap-timepicker  tiga_input time">
						  <div class="input-group">
						  <input type="text"  name="regular_arrival_actual_time" id="regular_arrival_actual_time" class="form-control timepicker regular_arrival_actual" placeholder='Arrival Actual Time' >
						  <div class="input-group-addon">
						  <i class="fa fa-clock-o"></i>
						  </div>
						  </div>
					      </div>
						  </div>
				</div>
				
				
				
				
				
				 <h3 class='title-loading'>Loading</h3>
				 
				 <div class="form-group">
						  <label for="drivercode2">Start</label>
						  <div class='wrapper-time-monitoring clearfix'>
						  
						  <div class="input-group checklist tiga_input">
							<input type='checkbox' name='regular_loading_start' class='regular_loading_start regular_checkbox_time' id='regular_loading_start'>
						  </div>
						  
						  <div class="input-group date tiga_input">
						  <div class="input-group-addon">
							<i class="fa fa-calendar"></i>
						  </div>
						  <input type="text" name="regular_loading_start_date" id="regular_loading_start_date" class="form-control pull-right datepicker regular_loading_start"  placeholder='Loading Start Date' >
						  </div>
						  
						  <div class="bootstrap-timepicker  tiga_input time">
						  <div class="input-group">
						  <input type="text"  name="regular_loading_start_time" id="regular_loading_start_time" class="form-control timepicker regular_loading_start" placeholder='Loading Start Time' >
						  <div class="input-group-addon">
						  <i class="fa fa-clock-o"></i>
						  </div>
						  </div>
					      </div>
						  </div>
				</div>
				
				<div class="form-group">
						  <label for="drivercode2">Finish</label>
						  <div class='wrapper-time-monitoring clearfix'>
						  
						  <div class="input-group checklist tiga_input">
							<input type='checkbox' name='regular_loading_finish' class='regular_loading_finish regular_checkbox_time' id='regular_loading_finish'>
						  </div>
						  
						  <div class="input-group date tiga_input">
						  <div class="input-group-addon">
							<i class="fa fa-calendar"></i>
						  </div>
						  <input type="text" name="regular_loading_finish_date" id="regular_loading_finish_date" class="form-control pull-right datepicker regular_loading_finish"  placeholder='Loading Finish Date' >
						  </div>
						  
						  <div class="bootstrap-timepicker  tiga_input time">
						  <div class="input-group">
						  <input type="text"  name="regular_loading_finish_time" id="regular_loading_finish_time" class="form-control timepicker regular_loading_finish" placeholder='Loading Finish Time' >
						  <div class="input-group-addon">
						  <i class="fa fa-clock-o"></i>
						  </div>
						  </div>
					      </div>
						  </div>
				</div>
				
				<div class="form-group">
						  <label for="drivercode2">Documentation</label>
						  <div class='wrapper-time-monitoring clearfix'>
						  
						  <div class="input-group checklist tiga_input">
							<input type='checkbox' name='regular_loading_documentation' class='regular_loading_documentation regular_checkbox_time' id='regular_loading_documentation'>
						  </div>
						  
						  <div class="input-group date tiga_input">
						  <div class="input-group-addon">
							<i class="fa fa-calendar"></i>
						  </div>
						  <input type="text" name="regular_loading_documentation_date" id="regular_loading_documentation_date" class="form-control pull-right datepicker regular_loading_documentation"  placeholder='Loading Documentation Date' >
						  </div>
						  
						  <div class="bootstrap-timepicker  tiga_input time">
						  <div class="input-group">
						  <input type="text"  name="regular_loading_documentation_time" id="regular_loading_documentation_time" class="form-control timepicker regular_loading_documentation" placeholder='Loading Documentation Time' >
						  <div class="input-group-addon">
						  <i class="fa fa-clock-o"></i>
						  </div>
						  </div>
					      </div>
						  </div>
				</div>
					
				


				<h3>Departure</h3>
				 
				 <div class="form-group">
						  <label for="drivercode2">Estimation</label>
						  <div class='wrapper-time-monitoring clearfix'>
						  
						  <div class="input-group checklist tiga_input">
							<input type='checkbox' name='regular_departure_estimation' class='regular_departure_estimation regular_checkbox_time' id='regular_departure_estimation'>
						  </div>
						  
						  <div class="input-group date tiga_input">
						  <div class="input-group-addon">
							<i class="fa fa-calendar"></i>
						  </div>
						  <input type="text" name="regular_departure_estimation_date" id="regular_departure_estimation_date" class="form-control pull-right datepicker regular_departure_estimation"  placeholder='Departure Estimation Date' >
						  </div>
						  
						  <div class="bootstrap-timepicker  tiga_input time">
						  <div class="input-group">
						  <input type="text"  name="regular_departure_estimation_time" id="regular_departure_estimation_time" class="form-control timepicker regular_departure_estimation" placeholder='Departure Estimation Time' >
						  <div class="input-group-addon">
						  <i class="fa fa-clock-o"></i>
						  </div>
						  </div>
					      </div>
						  </div>
				</div>
				
				<div class="form-group">
						  <label for="drivercode2">Actual</label>
						  <div class='wrapper-time-monitoring clearfix'>
						  
						  <div class="input-group checklist tiga_input">
							<input type='checkbox' name='regular_departure_actual' class='regular_departure_actual regular_checkbox_time' id='regular_departure_actual'>
						  </div>
						  
						  <div class="input-group date tiga_input">
						  <div class="input-group-addon">
							<i class="fa fa-calendar"></i>
						  </div>
						  <input type="text" name="regular_departure_actual_date" id="regular_departure_actual_date" class="form-control pull-right datepicker regular_departure_actual"  placeholder='Departure Actual Date' >
						  </div>
						  
						  <div class="bootstrap-timepicker  tiga_input time">
						  <div class="input-group">
						  <input type="text"  name="regular_departure_actual_time" id="regular_departure_actual_time" class="form-control timepicker regular_departure_actual" placeholder='Departure Actual Time' >
						  <div class="input-group-addon">
						  <i class="fa fa-clock-o"></i>
						  </div>
						  </div>
					      </div>
						  </div>
				</div>
				
					<input type='hidden' name='regular_state' id='regular_state' value=''>
					<input type='hidden' name='regular_spk_number' id='regular_spk_number' value=''>
					<input type='hidden' name='regular_manifest' id='regular_manifest' value=''>
                </div>
              <!-- /.box-body -->
			
              <div class="box-footer">
                <button data-remodal-action="cancel" class="remodal-cancel">Cancel</button>
				<input type="submit" name="submit_add" class="remodal-confirm" value="Submit" id="submit_edit">
              </div>
            </form>
	  </div>
	  <br>
	  
	</div>
	
	
	
	
	
	<div class="remodal" data-remodal-id="modal_edit_langsir" role="dialog" aria-labelledby="modal1Titl aria-describedby="modal1Desc">
	  <button data-remodal-action="close" class="remodal-close" aria-label="Close"></button>
	  <div>
		<h2 id="modal1Title">Update Traffic Monitoring Langsir</h2>
				<form role="form" id="form_update_langsir" method="POST" action="<?php echo base_url()."index.php/traffic_monitoring/updateTrafficMonitoringLangsir" ?>" enctype="multipart/form-data">
				 <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
				 
               <div class="box-body form">
				
			  
				
				<div class="form-group">
					  <label for="drivercode2">Point ID</label>
					 <input type="text" class="form-control" name="langsir_client_id" id="langsir_client_id" required>
				</div>
				
				<div class="form-group">
					  <label for="drivercode2">Name</label>
					 <input type="text" class="form-control" name="langsir_client_name" id="langsir_client_name" required>
				</div>
				
				<div class="form-group">
					  <label for="drivercode2">Address</label>
					 <input type="text" class="form-control" name="langsir_address" id="langsir_address" required>
				</div>
		  
				
				 
				<h3>Arrival</h3>
				 
				<div class="form-group">
						  <label for="drivercode2">Estimation</label>
						  <div class='wrapper-time-monitoring clearfix'>
						  
						  <div class="input-group checklist tiga_input">
							<input type='checkbox' name='langsir_arrival_estimation' class='langsir_arrival_estimation langsir_checkbox_time' id='langsir_arrival_estimation'>
						  </div>
						  
						  <div class="input-group date tiga_input">
						  <div class="input-group-addon">
							<i class="fa fa-calendar"></i>
						  </div>
						  <input type="text" name="langsir_arrival_estimation_date" id="langsir_arrival_estimation_date" class="form-control pull-right datepicker langsir_arrival_estimation"  placeholder='Arrival Estimation Date' >
						  </div>
						  
						  <div class="bootstrap-timepicker  tiga_input time">
						  <div class="input-group">
						  <input type="text"  name="langsir_arrival_estimation_time" id="langsir_arrival_estimation_time" class="form-control timepicker langsir_arrival_estimation" placeholder='Arrival Estimation Time' >
						  <div class="input-group-addon">
						  <i class="fa fa-clock-o"></i>
						  </div>
						  </div>
					      </div>
						  </div>
				</div>
				
				<div class="form-group">
						  <label for="drivercode2">Actual</label>
						  <div class='wrapper-time-monitoring clearfix'>
						  
						  <div class="input-group checklist tiga_input">
							<input type='checkbox' name='langsir_arrival_actual' class='langsir_arrival_actual langsir_checkbox_time' id='langsir_arrival_actual'>
						  </div>
						  
						  <div class="input-group date tiga_input">
						  <div class="input-group-addon">
							<i class="fa fa-calendar"></i>
						  </div>
						  <input type="text" name="langsir_arrival_actual_date" id="langsir_arrival_actual_date" class="form-control pull-right datepicker langsir_arrival_actual"  placeholder='Arrival Actual Date' >
						  </div>
						  
						  <div class="bootstrap-timepicker  tiga_input time">
						  <div class="input-group">
						  <input type="text"  name="langsir_arrival_actual_time" id="langsir_arrival_actual_time" class="form-control timepicker langsir_arrival_actual" placeholder='Arrival Actual Time' >
						  <div class="input-group-addon">
						  <i class="fa fa-clock-o"></i>
						  </div>
						  </div>
					      </div>
						  </div>
				</div>
				
				
				
				
				
				 <h3 class='title-loading'>Loading</h3>
				 
				 
				 <div class="form-group">
						  <label for="drivercode2">Documentation</label>
						  <div class='wrapper-time-monitoring clearfix'>
						  
						  <div class="input-group checklist tiga_input">
							<input type='checkbox' name='langsir_loading_documentation' class='langsir_loading_documentation langsir_checkbox_time' id='langsir_loading_documentation'>
						  </div>
						  
						  <div class="input-group date tiga_input">
						  <div class="input-group-addon">
							<i class="fa fa-calendar"></i>
						  </div>
						  <input type="text" name="langsir_loading_documentation_date" id="langsir_loading_documentation_date" class="form-control pull-right datepicker langsir_loading_documentation"  placeholder='Loading Documentation Date' >
						  </div>
						  
						  <div class="bootstrap-timepicker  tiga_input time">
						  <div class="input-group">
						  <input type="text"  name="langsir_loading_documentation_time" id="langsir_loading_documentation_time" class="form-control timepicker langsir_loading_documentation" placeholder='Loading Documentation Time' >
						  <div class="input-group-addon">
						  <i class="fa fa-clock-o"></i>
						  </div>
						  </div>
					      </div>
						  </div>
				</div>
				
				 <div class="form-group">
						  <label for="drivercode2">Start</label>
						  <div class='wrapper-time-monitoring clearfix'>
						  
						  <div class="input-group checklist tiga_input">
							<input type='checkbox' name='langsir_loading_start' class='langsir_loading_start langsir_checkbox_time' id='langsir_loading_start'>
						  </div>
						  
						  <div class="input-group date tiga_input">
						  <div class="input-group-addon">
							<i class="fa fa-calendar"></i>
						  </div>
						  <input type="text" name="langsir_loading_start_date" id="langsir_loading_start_date" class="form-control pull-right datepicker langsir_loading_start"  placeholder='Loading Start Date' >
						  </div>
						  
						  <div class="bootstrap-timepicker  tiga_input time">
						  <div class="input-group">
						  <input type="text"  name="langsir_loading_start_time" id="langsir_loading_start_time" class="form-control timepicker langsir_loading_start" placeholder='Loading Start Time' >
						  <div class="input-group-addon">
						  <i class="fa fa-clock-o"></i>
						  </div>
						  </div>
					      </div>
						  </div>
				</div>
				
				<div class="form-group">
						  <label for="drivercode2">Finish</label>
						  <div class='wrapper-time-monitoring clearfix'>
						  
						  <div class="input-group checklist tiga_input">
							<input type='checkbox' name='langsir_loading_finish' class='langsir_loading_finish langsir_checkbox_time' id='langsir_loading_finish'>
						  </div>
						  
						  <div class="input-group date tiga_input">
						  <div class="input-group-addon">
							<i class="fa fa-calendar"></i>
						  </div>
						  <input type="text" name="langsir_loading_finish_date" id="langsir_loading_finish_date" class="form-control pull-right datepicker langsir_loading_finish"  placeholder='Loading Finish Date' >
						  </div>
						  
						  <div class="bootstrap-timepicker  tiga_input time">
						  <div class="input-group">
						  <input type="text"  name="langsir_loading_finish_time" id="langsir_loading_finish_time" class="form-control timepicker langsir_loading_finish" placeholder='Loading Finish Time' >
						  <div class="input-group-addon">
						  <i class="fa fa-clock-o"></i>
						  </div>
						  </div>
					      </div>
						  </div>
				</div>
				
				
					
				<div class="form-group" id='select_landing_location_langsir' style='display:none;'>
					  <label for="drivercode2">Landing Location</label>
					  <select class="form-control" name="langsir_landing_location" id="langsir_landing_location" required>
						<option selected="selected" value="">Landing Location</option>
						<option value="Pool">Pool</option>
						<option value="Depo">Depo</option>
					  </select> 
				</div>


				<h3>Departure</h3>
				 
				 <div class="form-group">
						  <label for="drivercode2">Estimation</label>
						  <div class='wrapper-time-monitoring clearfix'>
						  
						  <div class="input-group checklist tiga_input">
							<input type='checkbox' name='langsir_departure_estimation' class='langsir_departure_estimation langsir_checkbox_time' id='langsir_departure_estimation'>
						  </div>
						  
						  <div class="input-group date tiga_input">
						  <div class="input-group-addon">
							<i class="fa fa-calendar"></i>
						  </div>
						  <input type="text" name="langsir_departure_estimation_date" id="langsir_departure_estimation_date" class="form-control pull-right datepicker langsir_departure_estimation"  placeholder='Departure Estimation Date' >
						  </div>
						  
						  <div class="bootstrap-timepicker  tiga_input time">
						  <div class="input-group">
						  <input type="text"  name="langsir_departure_estimation_time" id="langsir_departure_estimation_time" class="form-control timepicker langsir_departure_estimation" placeholder='Departure Estimation Time' >
						  <div class="input-group-addon">
						  <i class="fa fa-clock-o"></i>
						  </div>
						  </div>
					      </div>
						  </div>
				</div>
				
				<div class="form-group">
						  <label for="drivercode2">Actual</label>
						  <div class='wrapper-time-monitoring clearfix'>
						  
						  <div class="input-group checklist tiga_input">
							<input type='checkbox' name='langsir_departure_actual' class='langsir_departure_actual langsir_checkbox_time' id='langsir_departure_actual'>
						  </div>
						  
						  <div class="input-group date tiga_input">
						  <div class="input-group-addon">
							<i class="fa fa-calendar"></i>
						  </div>
						  <input type="text" name="langsir_departure_actual_date" id="langsir_departure_actual_date" class="form-control pull-right datepicker langsir_departure_actual"  placeholder='Departure Actual Date' >
						  </div>
						  
						  <div class="bootstrap-timepicker  tiga_input time">
						  <div class="input-group">
						  <input type="text"  name="langsir_departure_actual_time" id="langsir_departure_actual_time" class="form-control timepicker langsir_departure_actual" placeholder='Departure Actual Time' >
						  <div class="input-group-addon">
						  <i class="fa fa-clock-o"></i>
						  </div>
						  </div>
					      </div>
						  </div>
				</div>
				
					<input type='hidden' name='langsir_state' id='langsir_state' value=''>
					<input type='hidden' name='langsir_spk_number' id='langsir_spk_number' value=''>
					<input type='hidden' name='langsir_manifest' id='langsir_manifest' value=''>
                </div>
              <!-- /.box-body -->
			
              <div class="box-footer">
                <button data-remodal-action="cancel" class="remodal-cancel">Cancel</button>
				<input type="submit" name="submit_add" class="remodal-confirm" value="Submit" id="submit_edit">
              </div>
            </form>
	  </div>
	  <br>
	  
	</div>
	
	
	
	
	
	
	<div class="remodal" data-remodal-id="modal_edit_import" role="dialog" aria-labelledby="modal1Titl aria-describedby="modal1Desc">
	  <button data-remodal-action="close" class="remodal-close" aria-label="Close"></button>
	  <div>
		<h2 id="modal1Title">Update Traffic Monitoring Import</h2>
				<form role="form" id="form_update_import" method="POST" action="<?php echo base_url()."index.php/traffic_monitoring/updateTrafficMonitoringImport" ?>" enctype="multipart/form-data">
				 <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
				 
               <div class="box-body form">
				
			  
				
				<div class="form-group">
					  <label for="drivercode2">Point ID</label>
					 <input type="text" class="form-control" name="import_client_id" id="import_client_id" required>
				</div>
				
				<div class="form-group">
					  <label for="drivercode2">Name</label>
					 <input type="text" class="form-control" name="import_client_name" id="import_client_name" required>
				</div>
				
				<div class="form-group">
					  <label for="drivercode2">Address</label>
					 <input type="text" class="form-control" name="import_address" id="import_address" required>
				</div>
		  
				
				 
				<h3>Arrival</h3>
				 
				<div class="form-group">
						  <label for="drivercode2">Estimation</label>
						  <div class='wrapper-time-monitoring clearfix'>
						  
						  <div class="input-group checklist tiga_input">
							<input type='checkbox' name='import_arrival_estimation' class='import_arrival_estimation import_checkbox_time' id='import_arrival_estimation'>
						  </div>
						  
						  <div class="input-group date tiga_input">
						  <div class="input-group-addon">
							<i class="fa fa-calendar"></i>
						  </div>
						  <input type="text" name="import_arrival_estimation_date" id="import_arrival_estimation_date" class="form-control pull-right datepicker import_arrival_estimation"  placeholder='Arrival Estimation Date' >
						  </div>
						  
						  <div class="bootstrap-timepicker  tiga_input time">
						  <div class="input-group">
						  <input type="text"  name="import_arrival_estimation_time" id="import_arrival_estimation_time" class="form-control timepicker import_arrival_estimation" placeholder='Arrival Estimation Time' >
						  <div class="input-group-addon">
						  <i class="fa fa-clock-o"></i>
						  </div>
						  </div>
					      </div>
						  </div>
				</div>
				
				
				
				<div class="form-group">
						  <label for="drivercode2">Actual</label>
						  <div class='wrapper-time-monitoring clearfix'>
						  
						  <div class="input-group checklist tiga_input">
							<input type='checkbox' name='import_arrival_actual' class='import_arrival_actual import_checkbox_time' id='import_arrival_actual'>
						  </div>
						  
						  <div class="input-group date tiga_input">
						  <div class="input-group-addon">
							<i class="fa fa-calendar"></i>
						  </div>
						  <input type="text" name="import_arrival_actual_date" id="import_arrival_actual_date" class="form-control pull-right datepicker import_arrival_actual"  placeholder='Arrival Actual Date' >
						  </div>
						  
						  <div class="bootstrap-timepicker  tiga_input time">
						  <div class="input-group">
						  <input type="text"  name="import_arrival_actual_time" id="import_arrival_actual_time" class="form-control timepicker import_arrival_actual" placeholder='Arrival Actual Time' >
						  <div class="input-group-addon">
						  <i class="fa fa-clock-o"></i>
						  </div>
						  </div>
					      </div>
						  </div>
				</div>
				
				
				 
				
				
				<h3 class='title-loading'>Loading Container</h3>
				 
				 <div class="form-group">
						  <label for="drivercode2">Documentation</label>
						  <div class='wrapper-time-monitoring clearfix'>
						  
						  <div class="input-group checklist tiga_input">
							<input type='checkbox' name='import_loading_unloading_documentation' class='import_loading_unloading_documentation import_checkbox_time' id='import_loading_unloading_documentation'>
						  </div>
						  
						  <div class="input-group date tiga_input">
						  <div class="input-group-addon">
							<i class="fa fa-calendar"></i>
						  </div>
						  <input type="text" name="import_loading_unloading_documentation_date" id="import_loading_unloading_documentation_date" class="form-control pull-right datepicker import_loading_unloading_documentation"  placeholder='Documentation Date' >
						  </div>
						  
						  <div class="bootstrap-timepicker  tiga_input time">
						  <div class="input-group">
						  <input type="text"  name="import_loading_unloading_documentation_time" id="import_loading_unloading_documentation_time" class="form-control timepicker import_loading_unloading_documentation" placeholder='Documentation Time' >
						  <div class="input-group-addon">
						  <i class="fa fa-clock-o"></i>
						  </div>
						  </div>
					      </div>
						  </div>
				</div>
				
				 <div class="form-group">
						  <label for="drivercode2">Start</label>
						  <div class='wrapper-time-monitoring clearfix'>
						  
						  <div class="input-group checklist tiga_input">
							<input type='checkbox' name='import_loading_unloading_start' class='import_loading_unloading_start import_checkbox_time' id='import_loading_unloading_start'>
						  </div>
						  
						  <div class="input-group date tiga_input">
						  <div class="input-group-addon">
							<i class="fa fa-calendar"></i>
						  </div>
						  <input type="text" name="import_loading_unloading_start_date" id="import_loading_unloading_start_date" class="form-control pull-right datepicker import_loading_unloading_start"  placeholder='Start Date' >
						  </div>
						  
						  <div class="bootstrap-timepicker  tiga_input time">
						  <div class="input-group">
						  <input type="text"  name="import_loading_unloading_start_time" id="import_loading_unloading_start_time" class="form-control timepicker import_loading_unloading_start" placeholder='Start Time' >
						  <div class="input-group-addon">
						  <i class="fa fa-clock-o"></i>
						  </div>
						  </div>
					      </div>
						  </div>
				</div>
				
				<div class="form-group">
						  <label for="drivercode2">Finish</label>
						  <div class='wrapper-time-monitoring clearfix'>
						  
						  <div class="input-group checklist tiga_input">
							<input type='checkbox' name='import_loading_unloading_finish' class='import_loading_unloading_finish import_checkbox_time' id='import_loading_unloading_finish'>
						  </div>
						  
						  <div class="input-group date tiga_input">
						  <div class="input-group-addon">
							<i class="fa fa-calendar"></i>
						  </div>
						  <input type="text" name="import_loading_unloading_finish_date" id="import_loading_unloading_finish_date" class="form-control pull-right datepicker import_loading_unloading_finish"  placeholder='Finish Date' >
						  </div>
						  
						  <div class="bootstrap-timepicker  tiga_input time">
						  <div class="input-group">
						  <input type="text"  name="import_loading_unloading_finish_time" id="import_loading_unloading_finish_time" class="form-control timepicker import_loading_unloading_finish" placeholder='Finish Time' >
						  <div class="input-group-addon">
						  <i class="fa fa-clock-o"></i>
						  </div>
						  </div>
					      </div>
						  </div>
				</div>	
				


				<h3>Departure</h3>
				 
				 <div class="form-group">
						  <label for="drivercode2">Estimation</label>
						  <div class='wrapper-time-monitoring clearfix'>
						  
						  <div class="input-group checklist tiga_input">
							<input type='checkbox' name='import_departure_estimation' class='import_departure_estimation import_checkbox_time' id='import_departure_estimation'>
						  </div>
						  
						  <div class="input-group date tiga_input">
						  <div class="input-group-addon">
							<i class="fa fa-calendar"></i>
						  </div>
						  <input type="text" name="import_departure_estimation_date" id="import_departure_estimation_date" class="form-control pull-right datepicker import_departure_estimation"  placeholder='Departure Estimation Date' >
						  </div>
						  
						  <div class="bootstrap-timepicker  tiga_input time">
						  <div class="input-group">
						  <input type="text"  name="import_departure_estimation_time" id="import_departure_estimation_time" class="form-control timepicker import_departure_estimation" placeholder='Departure Estimation Time' >
						  <div class="input-group-addon">
						  <i class="fa fa-clock-o"></i>
						  </div>
						  </div>
					      </div>
						  </div>
				</div>
				
				<div class="form-group">
						  <label for="drivercode2">Actual</label>
						  <div class='wrapper-time-monitoring clearfix'>
						  
						  <div class="input-group checklist tiga_input">
							<input type='checkbox' name='import_departure_actual' class='import_departure_actual import_checkbox_time' id='import_departure_actual'>
						  </div>
						  
						  <div class="input-group date tiga_input">
						  <div class="input-group-addon">
							<i class="fa fa-calendar"></i>
						  </div>
						  <input type="text" name="import_departure_actual_date" id="import_departure_actual_date" class="form-control pull-right datepicker import_departure_actual"  placeholder='Departure Actual Date' >
						  </div>
						  
						  <div class="bootstrap-timepicker  tiga_input time">
						  <div class="input-group">
						  <input type="text"  name="import_departure_actual_time" id="import_departure_actual_time" class="form-control timepicker import_departure_actual" placeholder='Departure Actual Time' >
						  <div class="input-group-addon">
						  <i class="fa fa-clock-o"></i>
						  </div>
						  </div>
					      </div>
						  </div>
				</div>
				
				
				
				
				<div id='wrapper-landing-container-import'>
				<h3>Landing Container</h3>
				 
				 <div class="form-group">
						  <label for="drivercode2">Estimation</label>
						  <div class='wrapper-time-monitoring clearfix'>
						  
						  <div class="input-group checklist tiga_input">
							<input type='checkbox' name='import_landing_container_estimation' class='import_landing_container_estimation import_checkbox_time' id='import_landing_container_estimation'>
						  </div>
						  
						  <div class="input-group date tiga_input">
						  <div class="input-group-addon">
							<i class="fa fa-calendar"></i>
						  </div>
						  <input type="text" name="import_landing_container_estimation_date" id="import_landing_container_estimation_date" class="form-control pull-right datepicker import_landing_container_estimation"  placeholder='Landing Container Estimation Date' >
						  </div>
						  
						  <div class="bootstrap-timepicker  tiga_input time">
						  <div class="input-group">
						  <input type="text"  name="import_landing_container_estimation_time" id="import_landing_container_estimation_time" class="form-control timepicker import_landing_container_estimation" placeholder='Landing Container Estimation Time' >
						  <div class="input-group-addon">
						  <i class="fa fa-clock-o"></i>
						  </div>
						  </div>
					      </div>
						  </div>
				</div>
				
				<div class="form-group">
						  <label for="drivercode2">Actual</label>
						  <div class='wrapper-time-monitoring clearfix'>
						  
						  <div class="input-group checklist tiga_input">
							<input type='checkbox' name='import_landing_container_actual' class='import_landing_container_actual import_checkbox_time' id='import_landing_container_actual'>
						  </div>
						  
						  <div class="input-group date tiga_input">
						  <div class="input-group-addon">
							<i class="fa fa-calendar"></i>
						  </div>
						  <input type="text" name="import_landing_container_actual_date" id="import_landing_container_actual_date" class="form-control pull-right datepicker import_landing_container_actual"  placeholder='Landing Container Actual Date' >
						  </div>
						  
						  <div class="bootstrap-timepicker  tiga_input time">
						  <div class="input-group">
						  <input type="text"  name="import_landing_container_actual_time" id="import_landing_container_actual_time" class="form-control timepicker import_landing_container_actual" placeholder='Landing Container Actual Time' >
						  <div class="input-group-addon">
						  <i class="fa fa-clock-o"></i>
						  </div>
						  </div>
					      </div>
						  </div>
				</div>
				
				
					<div class="form-group">
					  <label for="drivercode2">Landing Location</label>
					  <select class="form-control" name="import_landing_location" id="import_landing_location" required>
						<option selected="selected" value="">Landing Location</option>
						<option value="Pool">Pool</option>
						<option value="Depo">Depo</option>
					  </select> 
					</div>
				
				
				</div>
				
				
				
				
					<input type='hidden' name='import_state' id='import_state' value=''>
					<input type='hidden' name='import_spk_number' id='import_spk_number' value=''>
					<input type='hidden' name='import_manifest' id='import_manifest' value=''>
                </div>
              <!-- /.box-body -->
			
              <div class="box-footer">
                <button data-remodal-action="cancel" class="remodal-cancel">Cancel</button>
				<input type="submit" name="submit_add" class="remodal-confirm" value="Submit" id="submit_edit">
              </div>
            </form>
	  </div>
	  <br>
	  
	</div>
	
	
	
	
	
	
	
	<div class="remodal" data-remodal-id="modal_edit_langsir_empty_cont" role="dialog" aria-labelledby="modal1Titl aria-describedby="modal1Desc">
	  <button data-remodal-action="close" class="remodal-close" aria-label="Close"></button>
	  <div>
		<h2 id="modal1Title">Update Traffic Monitoring Langsir</h2>
				<form role="form" id="form_update_langsir_empty_cont" method="POST" action="<?php echo base_url()."index.php/traffic_monitoring/updateTrafficMonitoringLangsirEmptyCont" ?>" enctype="multipart/form-data">
				 <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
				 
               <div class="box-body form">
				
			  
				
				<div class="form-group">
					  <label for="drivercode2">Point ID</label>
					 <input type="text" class="form-control" name="langsir_empty_cont_client_id" id="langsir_empty_cont_client_id" required>
				</div>
				
				<div class="form-group">
					  <label for="drivercode2">Name</label>
					 <input type="text" class="form-control" name="langsir_empty_cont_client_name" id="langsir_empty_cont_client_name" required>
				</div>
				
				<div class="form-group">
					  <label for="drivercode2">Address</label>
					 <input type="text" class="form-control" name="langsir_empty_cont_address" id="langsir_empty_cont_address" required>
				</div>
		  
				
				 
				<h3>Arrival</h3>
				 
				<div class="form-group">
						  <label for="drivercode2">Estimation</label>
						  <div class='wrapper-time-monitoring clearfix'>
						  
						  <div class="input-group checklist tiga_input">
							<input type='checkbox' name='langsir_empty_cont_arrival_estimation' class='langsir_empty_cont_arrival_estimation langsir_empty_cont_checkbox_time' id='langsir_empty_cont_arrival_estimation'>
						  </div>
						  
						  <div class="input-group date tiga_input">
						  <div class="input-group-addon">
							<i class="fa fa-calendar"></i>
						  </div>
						  <input type="text" name="langsir_empty_cont_arrival_estimation_date" id="langsir_empty_cont_arrival_estimation_date" class="form-control pull-right datepicker langsir_empty_cont_arrival_estimation"  placeholder='Arrival Estimation Date' >
						  </div>
						  
						  <div class="bootstrap-timepicker  tiga_input time">
						  <div class="input-group">
						  <input type="text"  name="langsir_empty_cont_arrival_estimation_time" id="langsir_empty_cont_arrival_estimation_time" class="form-control timepicker langsir_empty_cont_arrival_estimation" placeholder='Arrival Estimation Time' >
						  <div class="input-group-addon">
						  <i class="fa fa-clock-o"></i>
						  </div>
						  </div>
					      </div>
						  </div>
				</div>
				
				<div class="form-group">
						  <label for="drivercode2">Actual</label>
						  <div class='wrapper-time-monitoring clearfix'>
						  
						  <div class="input-group checklist tiga_input">
							<input type='checkbox' name='langsir_empty_cont_arrival_actual' class='langsir_empty_cont_arrival_actual langsir_empty_cont_checkbox_time' id='langsir_empty_cont_arrival_actual'>
						  </div>
						  
						  <div class="input-group date tiga_input">
						  <div class="input-group-addon">
							<i class="fa fa-calendar"></i>
						  </div>
						  <input type="text" name="langsir_empty_cont_arrival_actual_date" id="langsir_empty_cont_arrival_actual_date" class="form-control pull-right datepicker langsir_empty_cont_arrival_actual"  placeholder='Arrival Actual Date' >
						  </div>
						  
						  <div class="bootstrap-timepicker  tiga_input time">
						  <div class="input-group">
						  <input type="text"  name="langsir_empty_cont_arrival_actual_time" id="langsir_empty_cont_arrival_actual_time" class="form-control timepicker langsir_empty_cont_arrival_actual" placeholder='Arrival Actual Time' >
						  <div class="input-group-addon">
						  <i class="fa fa-clock-o"></i>
						  </div>
						  </div>
					      </div>
						  </div>
				</div>
				
				
				
				
				
				 <h3 class='title-loading'>Loading</h3>
				 
				 
				 <div class="form-group">
						  <label for="drivercode2">Documentation</label>
						  <div class='wrapper-time-monitoring clearfix'>
						  
						  <div class="input-group checklist tiga_input">
							<input type='checkbox' name='langsir_empty_cont_loading_documentation' class='langsir_empty_cont_loading_documentation langsir_empty_cont_checkbox_time' id='langsir_empty_cont_loading_documentation'>
						  </div>
						  
						  <div class="input-group date tiga_input">
						  <div class="input-group-addon">
							<i class="fa fa-calendar"></i>
						  </div>
						  <input type="text" name="langsir_empty_cont_loading_documentation_date" id="langsir_empty_cont_loading_documentation_date" class="form-control pull-right datepicker langsir_empty_cont_loading_documentation"  placeholder='Loading Documentation Date' >
						  </div>
						  
						  <div class="bootstrap-timepicker  tiga_input time">
						  <div class="input-group">
						  <input type="text"  name="langsir_empty_cont_loading_documentation_time" id="langsir_empty_cont_loading_documentation_time" class="form-control timepicker langsir_empty_cont_loading_documentation" placeholder='Loading Documentation Time' >
						  <div class="input-group-addon">
						  <i class="fa fa-clock-o"></i>
						  </div>
						  </div>
					      </div>
						  </div>
				</div>
				
				 <div class="form-group">
						  <label for="drivercode2">Start</label>
						  <div class='wrapper-time-monitoring clearfix'>
						  
						  <div class="input-group checklist tiga_input">
							<input type='checkbox' name='langsir_empty_cont_loading_start' class='langsir_empty_cont_loading_start langsir_empty_cont_checkbox_time' id='langsir_empty_cont_loading_start'>
						  </div>
						  
						  <div class="input-group date tiga_input">
						  <div class="input-group-addon">
							<i class="fa fa-calendar"></i>
						  </div>
						  <input type="text" name="langsir_empty_cont_loading_start_date" id="langsir_empty_cont_loading_start_date" class="form-control pull-right datepicker langsir_empty_cont_loading_start"  placeholder='Loading Start Date' >
						  </div>
						  
						  <div class="bootstrap-timepicker  tiga_input time">
						  <div class="input-group">
						  <input type="text"  name="langsir_empty_cont_loading_start_time" id="langsir_empty_cont_loading_start_time" class="form-control timepicker langsir_empty_cont_loading_start" placeholder='Loading Start Time' >
						  <div class="input-group-addon">
						  <i class="fa fa-clock-o"></i>
						  </div>
						  </div>
					      </div>
						  </div>
				</div>
				
				<div class="form-group">
						  <label for="drivercode2">Finish</label>
						  <div class='wrapper-time-monitoring clearfix'>
						  
						  <div class="input-group checklist tiga_input">
							<input type='checkbox' name='langsir_empty_cont_loading_finish' class='langsir_empty_cont_loading_finish langsir_empty_cont_checkbox_time' id='langsir_empty_cont_loading_finish'>
						  </div>
						  
						  <div class="input-group date tiga_input">
						  <div class="input-group-addon">
							<i class="fa fa-calendar"></i>
						  </div>
						  <input type="text" name="langsir_empty_cont_loading_finish_date" id="langsir_empty_cont_loading_finish_date" class="form-control pull-right datepicker langsir_empty_cont_loading_finish"  placeholder='Loading Finish Date' >
						  </div>
						  
						  <div class="bootstrap-timepicker  tiga_input time">
						  <div class="input-group">
						  <input type="text"  name="langsir_empty_cont_loading_finish_time" id="langsir_empty_cont_loading_finish_time" class="form-control timepicker langsir_empty_cont_loading_finish" placeholder='Loading Finish Time' >
						  <div class="input-group-addon">
						  <i class="fa fa-clock-o"></i>
						  </div>
						  </div>
					      </div>
						  </div>
				</div>
				
				
					
				<div class="form-group" id='select_landing_location_langsir_empty_cont' style='display:none;'>
					  <label for="drivercode2">Landing Location</label>
					  <select class="form-control" name="langsir_empty_cont_landing_location" id="langsir_empty_cont_landing_location" required>
						<option selected="selected" value="">Landing Location</option>
						<option value="Pool">Pool</option>
						<option value="Depo">Depo</option>
					  </select> 
				</div>


				<h3>Departure</h3>
				 
				 <div class="form-group">
						  <label for="drivercode2">Estimation</label>
						  <div class='wrapper-time-monitoring clearfix'>
						  
						  <div class="input-group checklist tiga_input">
							<input type='checkbox' name='langsir_empty_cont_departure_estimation' class='langsir_empty_cont_departure_estimation langsir_empty_cont_checkbox_time' id='langsir_empty_cont_departure_estimation'>
						  </div>
						  
						  <div class="input-group date tiga_input">
						  <div class="input-group-addon">
							<i class="fa fa-calendar"></i>
						  </div>
						  <input type="text" name="langsir_empty_cont_departure_estimation_date" id="langsir_empty_cont_departure_estimation_date" class="form-control pull-right datepicker langsir_empty_cont_departure_estimation"  placeholder='Departure Estimation Date' >
						  </div>
						  
						  <div class="bootstrap-timepicker  tiga_input time">
						  <div class="input-group">
						  <input type="text"  name="langsir_empty_cont_departure_estimation_time" id="langsir_empty_cont_departure_estimation_time" class="form-control timepicker langsir_empty_cont_departure_estimation" placeholder='Departure Estimation Time' >
						  <div class="input-group-addon">
						  <i class="fa fa-clock-o"></i>
						  </div>
						  </div>
					      </div>
						  </div>
				</div>
				
				<div class="form-group">
						  <label for="drivercode2">Actual</label>
						  <div class='wrapper-time-monitoring clearfix'>
						  
						  <div class="input-group checklist tiga_input">
							<input type='checkbox' name='langsir_empty_cont_departure_actual' class='langsir_empty_cont_departure_actual langsir_empty_cont_checkbox_time' id='langsir_empty_cont_departure_actual'>
						  </div>
						  
						  <div class="input-group date tiga_input">
						  <div class="input-group-addon">
							<i class="fa fa-calendar"></i>
						  </div>
						  <input type="text" name="langsir_empty_cont_departure_actual_date" id="langsir_empty_cont_departure_actual_date" class="form-control pull-right datepicker langsir_empty_cont_departure_actual"  placeholder='Departure Actual Date' >
						  </div>
						  
						  <div class="bootstrap-timepicker  tiga_input time">
						  <div class="input-group">
						  <input type="text"  name="langsir_empty_cont_departure_actual_time" id="langsir_empty_cont_departure_actual_time" class="form-control timepicker langsir_empty_cont_departure_actual" placeholder='Departure Actual Time' >
						  <div class="input-group-addon">
						  <i class="fa fa-clock-o"></i>
						  </div>
						  </div>
					      </div>
						  </div>
				</div>
				
					<input type='hidden' name='langsir_empty_cont_state' id='langsir_empty_cont_state' value=''>
					<input type='hidden' name='langsir_empty_cont_spk_number' id='langsir_empty_cont_spk_number' value=''>
					<input type='hidden' name='langsir_empty_cont_manifest' id='langsir_empty_cont_manifest' value=''>
                </div>
              <!-- /.box-body -->
			
              <div class="box-footer">
                <button data-remodal-action="cancel" class="remodal-cancel">Cancel</button>
				<input type="submit" name="submit_add" class="remodal-confirm" value="Submit" id="submit_edit">
              </div>
            </form>
	  </div>
	  <br>
	  
	</div>
	
	
	
	
	
	<div class="remodal" data-remodal-id="modal_edit_export" role="dialog" aria-labelledby="modal1Titl aria-describedby="modal1Desc">
	  <button data-remodal-action="close" class="remodal-close" aria-label="Close"></button>
	  <div>
		<h2 id="modal1Title">Update Traffic Monitoring Export</h2>
				<form role="form" id="form_update_export" method="POST" action="<?php echo base_url()."index.php/traffic_monitoring/updateTrafficMonitoringExport" ?>" enctype="multipart/form-data">
				 <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
				 
               <div class="box-body form">
				
			  
				
				<div class="form-group">
					  <label for="drivercode2">Point ID</label>
					 <input type="text" class="form-control" name="export_client_id" id="export_client_id" required>
				</div>
				
				<div class="form-group">
					  <label for="drivercode2">Name</label>
					 <input type="text" class="form-control" name="export_client_name" id="export_client_name" required>
				</div>
				
				<div class="form-group">
					  <label for="drivercode2">Address</label>
					 <input type="text" class="form-control" name="export_address" id="export_address" required>
				</div>
		  
				
				 
				<h3>Arrival</h3>
				 
				<div class="form-group">
						  <label for="drivercode2">Estimation</label>
						  <div class='wrapper-time-monitoring clearfix'>
						  
						  <div class="input-group checklist tiga_input">
							<input type='checkbox' name='export_arrival_estimation' class='export_arrival_estimation export_checkbox_time' id='export_arrival_estimation'>
						  </div>
						  
						  <div class="input-group date tiga_input">
						  <div class="input-group-addon">
							<i class="fa fa-calendar"></i>
						  </div>
						  <input type="text" name="export_arrival_estimation_date" id="export_arrival_estimation_date" class="form-control pull-right datepicker export_arrival_estimation"  placeholder='Arrival Estimation Date' >
						  </div>
						  
						  <div class="bootstrap-timepicker  tiga_input time">
						  <div class="input-group">
						  <input type="text"  name="export_arrival_estimation_time" id="export_arrival_estimation_time" class="form-control timepicker export_arrival_estimation" placeholder='Arrival Estimation Time' >
						  <div class="input-group-addon">
						  <i class="fa fa-clock-o"></i>
						  </div>
						  </div>
					      </div>
						  </div>
				</div>
				
				<div class="form-group">
						  <label for="drivercode2">Actual</label>
						  <div class='wrapper-time-monitoring clearfix'>
						  
						  <div class="input-group checklist tiga_input">
							<input type='checkbox' name='export_arrival_actual' class='export_arrival_actual export_checkbox_time' id='export_arrival_actual'>
						  </div>
						  
						  <div class="input-group date tiga_input">
						  <div class="input-group-addon">
							<i class="fa fa-calendar"></i>
						  </div>
						  <input type="text" name="export_arrival_actual_date" id="export_arrival_actual_date" class="form-control pull-right datepicker export_arrival_actual"  placeholder='Arrival Actual Date' >
						  </div>
						  
						  <div class="bootstrap-timepicker  tiga_input time">
						  <div class="input-group">
						  <input type="text"  name="export_arrival_actual_time" id="export_arrival_actual_time" class="form-control timepicker export_arrival_actual" placeholder='Arrival Actual Time' >
						  <div class="input-group-addon">
						  <i class="fa fa-clock-o"></i>
						  </div>
						  </div>
					      </div>
						  </div>
				</div>
				
				
				
				
				<div id='wrapper-export-landing-empty-cont'>
				 <h3 class='title-loading'>Loading Empty Cont</h3>
				 
				 
				 <div id='wrapper-loading-document'>
				 <div class="form-group">
						  <label for="drivercode2">Documentation</label>
						  <div class='wrapper-time-monitoring clearfix'>
						  
						  <div class="input-group checklist tiga_input">
							<input type='checkbox' name='export_loading_empty_cont_documentation' class='export_loading_empty_cont export_checkbox_time' id='export_loading_empty_cont_documentation'>
						  </div>
						  
						  <div class="input-group date tiga_input">
						  <div class="input-group-addon">
							<i class="fa fa-calendar"></i>
						  </div>
						  <input type="text" name="export_loading_empty_cont_documentation_date" id="export_loading_empty_cont_documentation_date" class="form-control pull-right datepicker export_loading_empty_cont_documentation"  placeholder='Loading Empty Cont Documentation Date' >
						  </div>
						  
						  <div class="bootstrap-timepicker  tiga_input time">
						  <div class="input-group">
						  <input type="text"  name="export_loading_empty_cont_documentation_time" id="export_loading_empty_cont_documentation_time" class="form-control timepicker export_loading_empty_cont_documentation" placeholder='Loading Empty Cont Documentation Time' >
						  <div class="input-group-addon">
						  <i class="fa fa-clock-o"></i>
						  </div>
						  </div>
					      </div>
						  </div>
				</div>
				</div>
				
				 <div class="form-group">
						  <label for="drivercode2">Start</label>
						  <div class='wrapper-time-monitoring clearfix'>
						  
						  <div class="input-group checklist tiga_input">
							<input type='checkbox' name='export_loading_empty_cont_start' class='export_loading_empty_cont_start export_checkbox_time' id='export_loading_empty_cont_start'>
						  </div>
						  
						  <div class="input-group date tiga_input">
						  <div class="input-group-addon">
							<i class="fa fa-calendar"></i>
						  </div>
						  <input type="text" name="export_loading_empty_cont_start_date" id="export_loading_empty_cont_start_date" class="form-control pull-right datepicker export_loading_empty_cont_start"  placeholder='Loading Empty Cont Start Time' >
						  </div>
						  
						  <div class="bootstrap-timepicker  tiga_input time">
						  <div class="input-group">
						  <input type="text"  name="export_loading_empty_cont_start_time" id="export_loading_empty_cont_start_time" class="form-control timepicker export_loading_empty_cont_start" placeholder='Loading Empty Cont Start Time' >
						  <div class="input-group-addon">
						  <i class="fa fa-clock-o"></i>
						  </div>
						  </div>
					      </div>
						  </div>
				</div>
				
				<div class="form-group">
						  <label for="drivercode2">Finish</label>
						  <div class='wrapper-time-monitoring clearfix'>
						  
						  <div class="input-group checklist tiga_input">
							<input type='checkbox' name='export_loading_empty_cont_finish' class='export_loading_empty_cont_finish export_checkbox_time' id='export_loading_empty_cont_finish'>
						  </div>
						  
						  <div class="input-group date tiga_input">
						  <div class="input-group-addon">
							<i class="fa fa-calendar"></i>
						  </div>
						  <input type="text" name="export_loading_empty_cont_finish_date" id="export_loading_empty_cont_finish_date" class="form-control pull-right datepicker export_loading_empty_cont_finish"  placeholder='Loading Empty Cont Finish Date' >
						  </div>
						  
						  <div class="bootstrap-timepicker  tiga_input time">
						  <div class="input-group">
						  <input type="text"  name="export_loading_empty_cont_finish_time" id="export_loading_empty_cont_finish_time" class="form-control timepicker export_loading_empty_cont_finish" placeholder='Loading Empty Cont Finish Time' >
						  <div class="input-group-addon">
						  <i class="fa fa-clock-o"></i>
						  </div>
						  </div>
					      </div>
						  </div>
				</div>
				</div>
				

				<div id='wrapper-export-loading-product'>
				 <h3 class='title-loading'>Loading Product</h3>
				 
				 
				 <div id='wrapper-loading-document'>
				 <div class="form-group">
						  <label for="drivercode2">Documentation</label>
						  <div class='wrapper-time-monitoring clearfix'>
						  
						  <div class="input-group checklist tiga_input">
							<input type='checkbox' name='export_loading_product_documentation' class='export_loading_product export_checkbox_time' id='export_loading_product_documentation'>
						  </div>
						  
						  <div class="input-group date tiga_input">
						  <div class="input-group-addon">
							<i class="fa fa-calendar"></i>
						  </div>
						  <input type="text" name="export_loading_product_documentation_date" id="export_loading_product_documentation_date" class="form-control pull-right datepicker export_loading_product_documentation"  placeholder='Loading Empty Cont Documentation Date' >
						  </div>
						  
						  <div class="bootstrap-timepicker  tiga_input time">
						  <div class="input-group">
						  <input type="text"  name="export_loading_product_documentation_time" id="export_loading_product_documentation_time" class="form-control timepicker export_loading_product_documentation" placeholder='Loading Empty Cont Documentation Time' >
						  <div class="input-group-addon">
						  <i class="fa fa-clock-o"></i>
						  </div>
						  </div>
					      </div>
						  </div>
				</div>
				</div>
				
				 <div class="form-group">
						  <label for="drivercode2">Start</label>
						  <div class='wrapper-time-monitoring clearfix'>
						  
						  <div class="input-group checklist tiga_input">
							<input type='checkbox' name='export_loading_product_start' class='export_loading_product_start export_checkbox_time' id='export_loading_product_start'>
						  </div>
						  
						  <div class="input-group date tiga_input">
						  <div class="input-group-addon">
							<i class="fa fa-calendar"></i>
						  </div>
						  <input type="text" name="export_loading_product_start_date" id="export_loading_product_start_date" class="form-control pull-right datepicker export_loading_product_start"  placeholder='Loading Empty Cont Start Time' >
						  </div>
						  
						  <div class="bootstrap-timepicker  tiga_input time">
						  <div class="input-group">
						  <input type="text"  name="export_loading_product_start_time" id="export_loading_product_start_time" class="form-control timepicker export_loading_product_start" placeholder='Loading Empty Cont Start Time' >
						  <div class="input-group-addon">
						  <i class="fa fa-clock-o"></i>
						  </div>
						  </div>
					      </div>
						  </div>
				</div>
				
				<div class="form-group">
						  <label for="drivercode2">Finish</label>
						  <div class='wrapper-time-monitoring clearfix'>
						  
						  <div class="input-group checklist tiga_input">
							<input type='checkbox' name='export_loading_product_finish' class='export_loading_product_finish export_checkbox_time' id='export_loading_product_finish'>
						  </div>
						  
						  <div class="input-group date tiga_input">
						  <div class="input-group-addon">
							<i class="fa fa-calendar"></i>
						  </div>
						  <input type="text" name="export_loading_product_finish_date" id="export_loading_product_finish_date" class="form-control pull-right datepicker export_loading_product_finish"  placeholder='Loading Empty Cont Finish Date' >
						  </div>
						  
						  <div class="bootstrap-timepicker  tiga_input time">
						  <div class="input-group">
						  <input type="text"  name="export_loading_product_finish_time" id="export_loading_product_finish_time" class="form-control timepicker export_loading_product_finish" placeholder='Loading Empty Cont Finish Time' >
						  <div class="input-group-addon">
						  <i class="fa fa-clock-o"></i>
						  </div>
						  </div>
					      </div>
						  </div>
				</div>
				</div>
				</div>
				
				
				<div id='wrapper-export-landing-container'>
				<h3>Landing Container</h3>
				 
				 <div class="form-group">
						  <label for="drivercode2">Estimation</label>
						  <div class='wrapper-time-monitoring clearfix'>
						  
						  <div class="input-group checklist tiga_input">
							<input type='checkbox' name='export_landing_container_estimation' class='export_landing_container_estimation export_checkbox_time' id='export_landing_container_estimation'>
						  </div>
						  
						  <div class="input-group date tiga_input">
						  <div class="input-group-addon">
							<i class="fa fa-calendar"></i>
						  </div>
						  <input type="text" name="export_landing_container_estimation_date" id="export_landing_container_estimation_date" class="form-control pull-right datepicker export_landing_container_estimation_date"  placeholder='Landing Container Estimation Time' >
						  </div>
						  
						  <div class="bootstrap-timepicker  tiga_input time">
						  <div class="input-group">
						  <input type="text"  name="export_landing_container_estimation_time" id="export_landing_container_estimation_time" class="form-control timepicker export_departure_estimation" placeholder='Landing Container Estimation Time' >
						  <div class="input-group-addon">
						  <i class="fa fa-clock-o"></i>
						  </div>
						  </div>
					      </div>
						  </div>
				</div>
				
				<div class="form-group">
						  <label for="drivercode2">Actual</label>
						  <div class='wrapper-time-monitoring clearfix'>
						  
						  <div class="input-group checklist tiga_input">
							<input type='checkbox' name='export_landing_container_actual' class='export_landing_container_actual export_checkbox_time' id='export_landing_container_actual'>
						  </div>
						  
						  <div class="input-group date tiga_input">
						  <div class="input-group-addon">
							<i class="fa fa-calendar"></i>
						  </div>
						  <input type="text" name="export_landing_container_actual_date" id="export_landing_container_actual_date" class="form-control pull-right datepicker export_landing_container_actual_date"  placeholder='Landing Container Actual Date' >
						  </div>
						  
						  <div class="bootstrap-timepicker  tiga_input time">
						  <div class="input-group">
						  <input type="text"  name="export_landing_container_actual_time" id="export_landing_container_actual_time" class="form-control timepicker export_landing_container_actual_time" placeholder='Landing Container Actual Time' >
						  <div class="input-group-addon">
						  <i class="fa fa-clock-o"></i>
						  </div>
						  </div>
					      </div>
						  </div>
				</div>
				
				
					
					<div class="form-group">
					  <label for="drivercode2">Landing Location</label>
					  <select class="form-control" name="export_landing_location" id="export_landing_location" required>
						<option selected="selected" value="">Landing Location</option>
						<option value="Pool">Pool</option>
						<option value="Depo">Depo</option>
					  </select> 
					</div>
					
				</div>
				


				<h3>Departure</h3>
				 
				 <div class="form-group">
						  <label for="drivercode2">Estimation</label>
						  <div class='wrapper-time-monitoring clearfix'>
						  
						  <div class="input-group checklist tiga_input">
							<input type='checkbox' name='export_departure_estimation' class='export_departure_estimation export_checkbox_time' id='export_departure_estimation'>
						  </div>
						  
						  <div class="input-group date tiga_input">
						  <div class="input-group-addon">
							<i class="fa fa-calendar"></i>
						  </div>
						  <input type="text" name="export_departure_estimation_date" id="export_departure_estimation_date" class="form-control pull-right datepicker export_departure_estimation"  placeholder='Departure Estimation Date' >
						  </div>
						  
						  <div class="bootstrap-timepicker  tiga_input time">
						  <div class="input-group">
						  <input type="text"  name="export_departure_estimation_time" id="export_departure_estimation_time" class="form-control timepicker export_departure_estimation" placeholder='Departure Estimation Time' >
						  <div class="input-group-addon">
						  <i class="fa fa-clock-o"></i>
						  </div>
						  </div>
					      </div>
						  </div>
				</div>
				
				<div class="form-group">
						  <label for="drivercode2">Actual</label>
						  <div class='wrapper-time-monitoring clearfix'>
						  
						  <div class="input-group checklist tiga_input">
							<input type='checkbox' name='export_departure_actual' class='export_departure_actual export_checkbox_time' id='export_departure_actual'>
						  </div>
						  
						  <div class="input-group date tiga_input">
						  <div class="input-group-addon">
							<i class="fa fa-calendar"></i>
						  </div>
						  <input type="text" name="export_departure_actual_date" id="export_departure_actual_date" class="form-control pull-right datepicker export_departure_actual"  placeholder='Departure Actual Date' >
						  </div>
						  
						  <div class="bootstrap-timepicker  tiga_input time">
						  <div class="input-group">
						  <input type="text"  name="export_departure_actual_time" id="export_departure_actual_time" class="form-control timepicker export_departure_actual" placeholder='Departure Actual Time' >
						  <div class="input-group-addon">
						  <i class="fa fa-clock-o"></i>
						  </div>
						  </div>
					      </div>
						  </div>
				</div>
				
				
				
				
				
					<input type='hidden' name='export_state' id='export_state' value=''>
					<input type='hidden' name='export_spk_number' id='export_spk_number' value=''>
					<input type='hidden' name='export_manifest' id='export_manifest' value=''>
                </div>
              <!-- /.box-body -->
			
              <div class="box-footer">
                <button data-remodal-action="cancel" class="remodal-cancel">Cancel</button>
				<input type="submit" name="submit_add" class="remodal-confirm" value="Submit" id="submit_edit">
              </div>
            </form>
	  </div>
	  <br>
	  
	</div>
	
	
	
	
	
	</div>

		
  <script>
  
			$('.datepicker').datepicker({
			  autoclose: true,
			  Format: 'dd-mm-yyyy'
			});
			
			
			  //Timepicker
			 $(".timepicker").timepicker({
			  showInputs: false
			});
			
			
			$( "#transporter" ).change(function() {
  
			  var transporter_status = $(this).val();
			  
			  if(transporter_status=='assets')
			  {
				  $('#truck_assets_div').show();
				  $('#truck_vendor_div').hide();
			  }
			  else if(transporter_status=='vendor')
			  {
				  $('#truck_assets_div').hide();
				  $('#truck_vendor_div').show();
			  }
			  else{
				   $('#truck_assets_div').hide();
				  $('#truck_vendor_div').hide();
			  }
			});
  
			$(".delete_data").click(function(){
				var id = $(this).attr('id');
				var id_traffic_monitoring =  $('#data_'+id+' .id_traffic_monitoring span').text();
				$("#reference_delete").text("Traffic Monitoring ID:"+id_traffic_monitoring)
				$("#id_traffic_monitoring_delete").val(id_traffic_monitoring);
			});
			
			
			

			$("#form_add_data").validate({
				
				messages: {
				spk_number: {
				required: 'SPK Number must be filled!'
				},
				order_type: {
				required: 'Order Type must be filled!'
				},
				manifest: {
				required: 'Manifest be filled!'
				},
				do_number: {
				required: 'DO Number must be filled!'
				},
				traffic_monitoring_type: {
				required: 'Traffic Monitoring Type must be filled!'
				},
				description: {
				required: 'Description must be filled!'
				},
				location: {
				required: 'Location must be filled!'
				}
			}
			});
			
			
			
			$("#form_edit_data").validate({
				
				messages: {
				edit_spk_number: {
				required: 'SPK Number must be filled!'
				},
				edit_order_type: {
				required: 'Order Type must be filled!'
				},
				edit_manifest: {
				required: 'Manifest be filled!'
				},
				edit_do_number: {
				required: 'DO Number must be filled!'
				},
				edit_traffic_monitoring_type: {
				required: 'Traffic Monitoring Type must be filled!'
				},
				edit_description: {
				required: 'Description must be filled!'
				},
				edit_location: {
				required: 'Location must be filled!'
				}
				}
			
			
			});
			
			
			
			$("#form_import_data").validate({
				rules: {
				import_file: {
				  required: true,
					extension: "xls|xlsx|csv"
				}
				},
				messages: {
				import_file: {
				required: 'Choose file must be filled!'
				}
			}
			});
	
	

		
  
  </script>  
		
  <script>

 
//  Usage:
//  $(function() {
//
//    // In this case the initialization function returns the already created instance
//    var inst = $('[data-remodal-id=modal]').remodal();
//
//    inst.open();
//    inst.close();
//    inst.getState();
//    inst.destroy();
//  });

  //  The second way to initialize:
  $('[data-remodal-id=modal2]').remodal({
    modifier: 'with-red-theme'
  });
</script>

<script>
window.location.hash="";


$(".deletelogg").on('click', function () {
    var ids = [];
    $(".toedit").each(function () {
        if ($(this).is(":checked")) {
            ids.push($(this).val());
        }
    });
    if (ids.length) {
        
		$('[data-remodal-id = modal_delete_all]').remodal().open();
		$("#id_traffic_monitoring_delete_all").val(ids);
		
    } else {
        alert("Please select items.");
    }
});



$(document).on('change', '#select_all', function() {

    $(".checkbox_satuan").prop('checked', $(this).prop("checked"));
});

$("#add-data").click(function(){
	$("#form_add_data").trigger('reset');
	$('[data-remodal-id = modal_add]').remodal().open();
	
	var validator = $( "#form_add_data" ).validate();
	validator.resetForm();
	
});

$("#import-data").click(function(){
	$("#form_import_data").trigger('reset');
	$('[data-remodal-id = modal_import]').remodal().open();
	
	var validator = $( "#form_import_data" ).validate();
	validator.resetForm();
});

$(".delete_data").click(function(){
	$('[data-remodal-id = modal_delete]').remodal().open();
});

$(".edit_data").click(function(){
	
	var order_type = $(this).attr('order_type');
	var state = $(this).attr('state');
	
	if(order_type=='Regular')
	{
		var id = $(this).attr('id');
		var customer_name =  $('#data_'+id+' .customer_name span.customer_name').text();
		var spk_number =  $('#data_'+id+' .customer_name span.spk_number').text();
		var manifest_id =  $('#data_'+id+' .customer_name span.manifest_id').text();
		var state =  $('#data_'+id+' .state').text();
		var origin_destination_id =  $('#data_'+id+' .origin_destination_id').text();
		var origin_destination_address =  $('#data_'+id+' .origin_destination_address').text();
		var origin_destination_area =  $('#data_'+id+' .origin_destination_area').text();
		
		if(state=='Origin')
		{
			$("#form_update_regular h3.title-loading").text("Loading");
		}
		else
		{
			$("#form_update_regular h3.title-loading").text("Unloading");
		}
		$("#form_update_regular").trigger('reset');
		$('[data-remodal-id = modal_edit_regular]').remodal().open();
		var validator = $( "#form_update_regular" ).validate();
		validator.resetForm();	
		
		$("#regular_client_id").val(origin_destination_id);
		$("#regular_client_name").val(customer_name);
		$("#regular_address").val(origin_destination_address);
		$("#regular_spk_number").val(spk_number);
		$("#regular_manifest").val(manifest_id);
		$("#regular_state").val(state);
		
		$.ajax({
		  url: '<?php echo BASE_URL(); ?>/index.php/json/jsonTMRegular?spk_number='+spk_number+'&&state='+state+'&&point_id='+origin_destination_id,
		  success: function(data,status)
		  {
			  
				var id_traffic_monitoring_regular = data[0]['id_traffic_monitoring_regular'];
				var spk_number = data[0]['spk_number'];
				var state = data[0]['state'];
				var point_id = data[0]['point_id'];
				var name = data[0]['name'];
				var address = data[0]['address'];
				var arrival_estimation_date = data[0]['arrival_estimation_date'];
				var arrival_estimation_time = data[0]['arrival_estimation_time'];
				var arrival_actual_date = data[0]['arrival_actual_date'];
				var arrival_actual_time = data[0]['arrival_actual_time'];
				var loading_unloading_start_date = data[0]['loading_unloading_start_date'];
				var loading_unloading_start_time = data[0]['loading_unloading_start_time'];
				var loading_unloading_finish_date = data[0]['loading_unloading_finish_date'];
				var loading_unloading_finish_time = data[0]['loading_unloading_finish_time'];
				var loading_unloading_documentation_date = data[0]['loading_unloading_documentation_date'];
				var loading_unloading_documentation_time = data[0]['loading_unloading_documentation_time'];
				var departure_estimation_date = data[0]['departure_estimation_date'];
				var departure_estimation_time = data[0]['departure_estimation_time'];
				var departure_actual_date = data[0]['departure_actual_date'];
				var departure_actual_time = data[0]['departure_actual_time'];
				var created_by = data[0]['created_by'];
				var created_time = data[0]['created_time'];
				var updated_by = data[0]['updated_by'];
				var updated_time = data[0]['updated_time'];
				
				$("#regular_arrival_estimation_date").val(arrival_estimation_date);
				$("#regular_arrival_estimation_time").val(arrival_estimation_time);
				$("#regular_arrival_actual_date").val(arrival_actual_date);
				$("#regular_arrival_actual_time").val(arrival_actual_time);
				$("#regular_loading_start_date").val(loading_unloading_start_date);
				$("#regular_loading_start_time").val(loading_unloading_start_time);
				$("#regular_loading_finish_date").val(loading_unloading_finish_date);
				$("#regular_loading_finish_time").val(loading_unloading_finish_time);
				$("#regular_loading_documentation_date").val(loading_unloading_documentation_date);
				$("#regular_loading_documentation_time").val(loading_unloading_documentation_time);
				$("#regular_departure_estimation_date").val(departure_estimation_date);
				$("#regular_departure_estimation_time").val(departure_estimation_time);
				$("#regular_departure_actual_date").val(departure_actual_date);
				$("#regular_departure_actual_time").val(departure_actual_time);
		  },
		 async:   true,
		  dataType: 'json'
		});
	}
	
	else if(order_type=='Langsir')
	{
		
		var id = $(this).attr('id');
		var customer_name =  $('#data_'+id+' .customer_name span.customer_name').text();
		var spk_number =  $('#data_'+id+' .customer_name span.spk_number').text();
		var manifest_id =  $('#data_'+id+' .customer_name span.manifest_id').text();
		var state =  $('#data_'+id+' .state').text();
		var origin_destination_id =  $('#data_'+id+' .origin_destination_id').text();
		var origin_destination_address =  $('#data_'+id+' .origin_destination_address').text();
		var origin_destination_area =  $('#data_'+id+' .origin_destination_area').text();
		
		if(state=='Origin')
		{
			$("#form_update_langsir h3.title-loading").text("Loading Container");
			
			$("#langsir_loading_start_date").attr("placeholder","Loading Cont Start Date");
			$("#langsir_loading_start_time").attr("placeholder","Loading Cont Start Time");
			$("#langsir_loading_finish_date").attr("placeholder","Loading Loading Finish Date");
			$("#langsir_loading_finish_time").attr("placeholder","Loading Loading Finish Time");
			$("#langsir_loading_documentation_date").attr("placeholder","Loading Loading Documentation Date");
			$("#langsir_loading_documentation_time").attr("placeholder","Loading Loading Documentation Time");
			
			$("#select_landing_location_langsir").hide();
			
		}
		else
		{
			$("#form_update_langsir h3.title-loading").text("Landing Cont");
			$("#select_landing_location_langsir").show();
			$("#langsir_loading_start_date").attr("placeholder","Landing Cont Start Date");
			$("#langsir_loading_start_time").attr("placeholder","Landing Cont Start Time");
			$("#langsir_loading_finish_date").attr("placeholder","Langsir Loading Finish Date");
			$("#langsir_loading_finish_time").attr("placeholder","Langsir Loading Finish Time");
			$("#langsir_loading_documentation_date").attr("placeholder","Langsir Loading Documentation Date");
			$("#langsir_loading_documentation_time").attr("placeholder","Langsir Loading Documentation Time");
			
		}
		
		$("#form_update_langsir").trigger('reset');
		$('[data-remodal-id = modal_edit_langsir]').remodal().open();
		var validator = $( "#form_update_langsir" ).validate();
		validator.resetForm();
		
		
		$("#langsir_client_id").val(origin_destination_id);
		$("#langsir_client_name").val(customer_name);
		$("#langsir_address").val(origin_destination_address);
		$("#langsir_spk_number").val(spk_number);
		$("#langsir_manifest").val(manifest_id);
		$("#langsir_state").val(state);
		
		$.ajax({
		  url: '<?php echo BASE_URL(); ?>/index.php/json/jsonTMLangsir?spk_number='+spk_number+'&&state='+state+'&&point_id='+origin_destination_id,
		  success: function(data,status)
		  {
				var id_traffic_monitoring_langsir = data[0]['	d_traffic_monitoring_langsir'];
				var spk_number = data[0]['spk_number'];
				var state = data[0]['state'];
				var point_id = data[0]['point_id'];
				var name = data[0]['name'];
				var address = data[0]['address'];
				var arrival_estimation_date = data[0]['arrival_estimation_date'];
				var arrival_estimation_time = data[0]['arrival_estimation_time'];
				var arrival_actual_date = data[0]['arrival_actual_date'];
				var arrival_actual_time = data[0]['arrival_actual_time'];
				var loading_landing_start_date = data[0]['loading_landing_start_date'];
				var loading_landing_start_time = data[0]['loading_landing_start_time'];
				var loading_landing_finish_date = data[0]['loading_landing_finish_date'];
				var loading_landing_finish_time = data[0]['loading_landing_finish_time'];
				var loading_landing_documentation_date	 = data[0]['loading_landing_documentation_date'];
				var loading_landing_documentation_time = data[0]['loading_landing_documentation_time'];
				var departure_estimation_date = data[0]['departure_estimation_date'];
				var departure_estimation_time = data[0]['departure_estimation_time'];
				var departure_actual_date = data[0]['departure_actual_date'];
				var departure_actual_time = data[0]['departure_actual_time'];
				var created_by = data[0]['created_by'];
				var created_time = data[0]['created_time'];
				var updated_by = data[0]['updated_by'];
				var updated_time = data[0]['updated_time'];
				
				$("#langsir_arrival_estimation_date").val(arrival_estimation_date);
				$("#langsir_arrival_estimation_time").val(arrival_estimation_time);
				$("#langsir_arrival_actual_date").val(arrival_actual_date);
				$("#langsir_arrival_actual_time").val(arrival_actual_time);
				$("#langsir_loading_documentation_date").val(loading_landing_documentation_date);
				$("#langsir_loading_documentation_time").val(loading_landing_documentation_time);
				$("#langsir_loading_start_date").val(loading_landing_start_date);
				$("#langsir_loading_start_time").val(loading_landing_start_time);
				$("#langsir_loading_finish_date").val(loading_landing_finish_date);
				$("#langsir_loading_finish_time").val(loading_landing_finish_time);
				$("#langsir_departure_estimation_date").val(departure_estimation_date);
				$("#langsir_departure_estimation_time").val(departure_estimation_time);
				$("#langsir_departure_actual_date").val(departure_actual_date);
				$("#langsir_departure_actual_time").val(departure_actual_time);
		  },
		 async:   true,
		  dataType: 'json'
		});
	}
	
	
	
	
	
	else if(order_type=='Import')
	{
		
		var id = $(this).attr('id');
		var customer_name =  $('#data_'+id+' .customer_name span.customer_name').text();
		var spk_number =  $('#data_'+id+' .customer_name span.spk_number').text();
		var manifest_id =  $('#data_'+id+' .customer_name span.manifest_id').text();
		var state =  $('#data_'+id+' .state').text();
		var origin_destination_id =  $('#data_'+id+' .origin_destination_id').text();
		var origin_destination_address =  $('#data_'+id+' .origin_destination_address').text();
		var origin_destination_area =  $('#data_'+id+' .origin_destination_area').text();
		
		if(state=='Origin')
		{
			$("#form_update_import h3.title-loading").text("Loading Container");
			$("#wrapper-landing-container-import").hide();
		
			
			$("#import_loading_documentation_date").attr("placeholder","Loading Documentation Date");
			$("#import_loading_documentation_time").attr("placeholder","loading Documentation Time");
			$("#import_loading_start_date").attr("placeholder","Loading Container Start Date");
			$("#import_loading_start_time").attr("placeholder","Loading Container Start Time");
			$("#import_loading_finish_date").attr("placeholder","Loading Container Finish Date");
			$("#import_loading_finish_time").attr("placeholder","Loading Container Finish Time");
			
		}
		else
		{
			$("#form_update_import h3.title-loading").text("Unloading Container");
			$("#wrapper-landing-container-import").show();
			
			$("#import_loading_start_date").attr("placeholder","Unloading Container Start Date");
			$("#import_loading_start_time").attr("placeholder","Unloading Container Start Time");
			$("#import_loading_finish_date").attr("placeholder","Unloading Container Finish Date");
			$("#import_loading_finish_time").attr("placeholder","Unloading ContainerFinish Time");
			
		}
		
		$("#form_update_import").trigger('reset');
		$('[data-remodal-id = modal_edit_import]').remodal().open();
		var validator = $( "#form_update_import" ).validate();
		validator.resetForm();
		
		
		$("#import_client_id").val(origin_destination_id);
		$("#import_client_name").val(customer_name);
		$("#import_address").val(origin_destination_address);
		$("#import_spk_number").val(spk_number);
		$("#import_manifest").val(manifest_id);
		$("#import_state").val(state);
		
		$.ajax({
		  url: '<?php echo BASE_URL(); ?>/index.php/json/jsonTMImport?spk_number='+spk_number+'&&state='+state+'&&point_id='+origin_destination_id,
		  success: function(data,status)
		  {
				var id_traffic_monitoring_import = data[0]['id_traffic_monitoring_import'];
				var spk_number = data[0]['	spk_number'];
				var state = data[0]['state'];
				var point_id = data[0]['point_id'];
				var name = data[0]['name'];
				var address = data[0]['address'];
				var arrival_estimation_date = data[0]['arrival_estimation_date'];
				var arrival_estimation_time = data[0]['arrival_estimation_time'];
				var arrival_actual_date = data[0]['arrival_actual_date'];
				var arrival_actual_time = data[0]['arrival_actual_time'];
				var loading_unloading_start_date = data[0]['loading_unloading_start_date'];
				var loading_unloading_start_time = data[0]['loading_unloading_start_time'];
				var loading_unloading_finish_date = data[0]['loading_unloading_finish_date'];
				var loading_unloading_finish_time = data[0]['loading_unloading_finish_time'];
				var loading_unloading_documentation_date = data[0]['loading_unloading_documentation_date'];
				var loading_unloading_documentation_time = data[0]['loading_unloading_documentation_time'];
				var departure_estimation_date = data[0]['departure_estimation_date'];
				var departure_estimation_time = data[0]['departure_estimation_time'];
				var departure_actual_date = data[0]['departure_actual_date'];
				var departure_actual_time = data[0]['departure_actual_time'];
				var landing_container_estimation_date = data[0]['landing_container_estimation_date'];
				var landing_container_estimation_time = data[0]['landing_container_estimation_time'];
				var landing_container_actual_date = data[0]['landing_container_actual_date'];
				var landing_container_actual_time = data[0]['landing_container_actual_time'];
				var landing_location = data[0]['landing_location'];
				var created_by = data[0]['created_by'];
				var created_time = data[0]['created_time'];
				var updated_by = data[0]['updated_by'];
				var updated_time = data[0]['updated_time'];
				
				$("#import_arrival_estimation_date").val(arrival_estimation_date);
				$("#import_arrival_estimation_time").val(arrival_estimation_time);
				$("#import_arrival_actual_date").val(arrival_actual_date);
				$("#import_arrival_actual_time").val(arrival_actual_time);
				$("#import_departure_estimation_date").val(departure_estimation_date);
				$("#import_departure_estimation_time").val(departure_estimation_time);
				$("#import_departure_actual_date").val(departure_actual_date);
				$("#import_departure_actual_time").val(departure_actual_time);
				$("#import_loading_unloading_documentation_date").val(loading_unloading_documentation_date);
				$("#import_loading_unloading_documentation_time").val(loading_unloading_documentation_time);
				$("#import_loading_unloading_start_date").val(loading_unloading_start_date);
				$("#import_loading_unloading_start_time").val(loading_unloading_start_time);
				$("#import_loading_unloading_finish_date").val(loading_unloading_finish_date);
				$("#import_loading_unloading_finish_time").val(loading_unloading_finish_time);
				$("#import_landing_container_estimation_date").val(landing_container_estimation_date);
				$("#import_landing_container_estimation_time").val(landing_container_estimation_time);
				$("#import_landing_container_actual_date").val(landing_container_actual_date);
				$("#import_landing_container_actual_time").val(landing_container_actual_time);
				$("#import_landing_location").val(landing_location);
				
		  },
		 async:   true,
		  dataType: 'json'
		});
	}
	
	
	
	
	
	else if(order_type=='Export')
	{
		
		var id = $(this).attr('id');
		var customer_name =  $('#data_'+id+' .customer_name span.customer_name').text();
		var spk_number =  $('#data_'+id+' .customer_name span.spk_number').text();
		var manifest_id =  $('#data_'+id+' .customer_name span.manifest_id').text();
		var state =  $('#data_'+id+' .state').text();
		var origin_destination_id =  $('#data_'+id+' .origin_destination_id').text();
		var origin_destination_address =  $('#data_'+id+' .origin_destination_address').text();
		var origin_destination_area =  $('#data_'+id+' .origin_destination_area').text();
		
		if(state=='Origin')
		{
			$("#wrapper-export-landing-empty-cont").show();
			$("#wrapper-export-loading-product").show();
			$("#wrapper-export-landing-container").hide();
			
		}
		else
		{
			$("#wrapper-export-landing-container").show();
			$("#wrapper-export-landing-empty-cont").hide();
			$("#wrapper-export-loading-product").hide();
		}
		
		$("#form_update_export").trigger('reset');
		$('[data-remodal-id = modal_edit_export]').remodal().open();
		var validator = $( "#form_update_export" ).validate();
		validator.resetForm();
		
		
		$("#export_client_id").val(origin_destination_id);
		$("#export_client_name").val(customer_name);
		$("#export_address").val(origin_destination_address);
		$("#export_spk_number").val(spk_number);
		$("#export_manifest").val(manifest_id);
		$("#export_state").val(state);
		
		$.ajax({
		  url: '<?php echo BASE_URL(); ?>/index.php/json/jsonTMExport?spk_number='+spk_number+'&&state='+state+'&&point_id='+origin_destination_id,
		  success: function(data,status)
		  {
				var id_traffic_monitoring_export = data[0]['id_traffic_monitoring_export'];
				var spk_number = data[0]['spk_number'];
				var state = data[0]['state'];
				var point_id = data[0]['point_id'];
				var name = data[0]['name'];
				var address = data[0]['address'];
				var arrival_estimation_date = data[0]['arrival_estimation_date'];
				var arrival_estimation_time = data[0]['arrival_estimation_time'];
				var arrival_actual_date = data[0]['arrival_actual_date'];
				var arrival_actual_time = data[0]['arrival_actual_time'];
				var loading_empty_cont_documentation_date = data[0]['loading_empty_cont_documentation_date'];
				var loading_empty_cont_documentation_time = data[0]['loading_empty_cont_documentation_time'];
				var loading_empty_cont_start_date = data[0]['loading_empty_cont_start_date'];
				var loading_empty_cont_start_time = data[0]['loading_empty_cont_start_time'];
				var loading_empty_cont_finish_date = data[0]['loading_empty_cont_finish_date'];
				var loading_empty_cont_finish_time = data[0]['loading_empty_cont_finish_time'];
				var loading_product_documentation_date = data[0]['loading_product_documentation_date'];
				var loading_product_documentation_time = data[0]['loading_product_documentation_time'];
				var loading_product_start_date = data[0]['loading_product_start_date'];
				var loading_product_start_time = data[0]['loading_product_start_time'];
				var loading_product_finish_date = data[0]['loading_product_finish_date'];
				var loading_product_finish_time = data[0]['loading_product_finish_time'];
				var departure_estimation_date = data[0]['departure_estimation_date'];
				var departure_estimation_time = data[0]['departure_estimation_time'];
				var departure_actual_date = data[0]['departure_actual_date'];
				var departure_actual_time = data[0]['departure_actual_time'];
				var landing_cont_estimation_date = data[0]['landing_cont_estimation_date'];
				var landing_cont_estimation_time = data[0]['landing_cont_estimation_time'];
				var landing_cont_actual_date = data[0]['landing_cont_actual_date'];
				var landing_cont_actual_time = data[0]['landing_cont_actual_time'];
				var landing_location = data[0]['landing_location'];
				var created_by = data[0]['created_by'];
				var created_time = data[0]['created_time'];
				var updated_by = data[0]['updated_by'];
				var updated_time = data[0]['updated_time'];
				
				$("#export_arrival_estimation_date").val(arrival_estimation_date);
				$("#export_arrival_estimation_time").val(arrival_estimation_time);
				$("#export_arrival_actual_date").val(arrival_actual_date);
				$("#export_arrival_actual_time").val(arrival_actual_time);
				$("#export_loading_empty_cont_documentation_date").val(loading_empty_cont_documentation_date);
				$("#export_loading_empty_cont_documentation_time").val(loading_empty_cont_documentation_time);
				$("#export_loading_empty_cont_start_date").val(loading_empty_cont_start_date);
				$("#export_loading_empty_cont_start_time").val(loading_empty_cont_start_time);
				$("#export_loading_empty_cont_finish_date").val(loading_empty_cont_finish_date);
				$("#export_loading_empty_cont_finish_time").val(loading_empty_cont_finish_time);
				$("#export_loading_product_documentation_date").val(loading_product_documentation_date);
				$("#export_loading_product_documentation_time").val(loading_product_documentation_time);
				$("#export_loading_product_start_date").val(loading_product_start_date);
				$("#export_loading_product_start_time").val(loading_product_start_time);
				$("#export_loading_product_finish_date").val(loading_product_finish_date);
				$("#export_loading_product_finish_time").val(loading_product_finish_time);
				$("#export_departure_estimation_date").val(departure_estimation_date);
				$("#export_departure_estimation_time").val(departure_estimation_time);
				$("#export_departure_actual_date").val(departure_actual_date);
				$("#export_departure_actual_time").val(departure_actual_time);
				$("#export_landing_container_estimation_date").val(landing_cont_estimation_date);
				$("#export_landing_container_estimation_time").val(landing_cont_estimation_time);
				$("#export_landing_container_actual_date").val(landing_cont_actual_date);
				$("#export_landing_container_actual_time").val(landing_cont_actual_time);
				$("#export_landing_location").val(landing_location);
				
		  },
		 async:   true,
		  dataType: 'json'
		});
	}
	
	
	
	
	
	else if(order_type=='Langsir_Empty_Cont')
	{
		
		var id = $(this).attr('id');
		var customer_name =  $('#data_'+id+' .customer_name span.customer_name').text();
		var spk_number =  $('#data_'+id+' .customer_name span.spk_number').text();
		var manifest_id =  $('#data_'+id+' .customer_name span.manifest_id').text();
		var state =  $('#data_'+id+' .state').text();
		var origin_destination_id =  $('#data_'+id+' .origin_destination_id').text();
		var origin_destination_address =  $('#data_'+id+' .origin_destination_address').text();
		var origin_destination_area =  $('#data_'+id+' .origin_destination_area').text();
		
		if(state=='Origin')
		{
			$("#form_update_langsir_empty_cont h3.title-loading").text("Loading Container");
			
			$("#langsir_empty_cont_loading_start_date").attr("placeholder","Loading Cont Start Date");
			$("#langsir_empty_cont_loading_start_time").attr("placeholder","Loading Cont Start Time");
			$("#langsir_empty_cont_loading_finish_date").attr("placeholder","Loading Loading Finish Date");
			$("#langsir_empty_cont_loading_finish_time").attr("placeholder","Loading Loading Finish Time");
			$("#langsir_empty_cont_loading_documentation_date").attr("placeholder","Loading Loading Documentation Date");
			$("#langsir_empty_cont_loading_documentation_time").attr("placeholder","Loading Loading Documentation Time");
			
			$("#select_landing_location_langsir_empty_cont").hide();
			
		}
		else
		{
			$("#form_update_langsir_empty_cont h3.title-loading").text("Landing Cont");
			$("#select_landing_location_langsir_empty_cont").show();
			$("#langsir_empty_cont_loading_start_date").attr("placeholder","Landing Cont Start Date");
			$("#langsir_empty_cont_loading_start_time").attr("placeholder","Landing Cont Start Time");
			$("#langsir_empty_cont_loading_finish_date").attr("placeholder","Langsir Loading Finish Date");
			$("#langsir_empty_cont_loading_finish_time").attr("placeholder","Langsir Loading Finish Time");
			$("#langsir_empty_cont_loading_documentation_date").attr("placeholder","Langsir Loading Documentation Date");
			$("#langsir_empty_cont_loading_documentation_time").attr("placeholder","Langsir Loading Documentation Time");
			
		}
		
		$("#form_update_langsir_empty_cont").trigger('reset');
		$('[data-remodal-id = modal_edit_langsir_empty_cont]').remodal().open();
		var validator = $( "#form_update_langsir_empty_cont" ).validate();
		validator.resetForm();
		
		
		$("#langsir_empty_cont_client_id").val(origin_destination_id);
		$("#langsir_empty_cont_client_name").val(customer_name);
		$("#langsir_empty_cont_address").val(origin_destination_address);
		$("#langsir_empty_cont_spk_number").val(spk_number);
		$("#langsir_empty_cont_manifest").val(manifest_id);
		$("#langsir_empty_cont_state").val(state);
		
		
		$.ajax({
		  url: '<?php echo BASE_URL(); ?>/index.php/json/jsonTMLangsirEmpty?spk_number='+spk_number+'&&state='+state+'&&point_id='+origin_destination_id,
		  success: function(data,status)
		  {
			   
				var id_traffic_monitoring_langsir_empty_cont = data[0]['id_traffic_monitoring_langsir_empty_cont'];
				var spk_number = data[0]['spk_number'];
				var state = data[0]['state'];
				var point_id = data[0]['point_id'];
				var name = data[0]['name'];
				var spk_number = data[0]['name'];
				var address = data[0]['address'];
				var arrival_estimation_date = data[0]['arrival_estimation_date'];
				var arrival_estimation_time = data[0]['arrival_estimation_time'];
				var arrival_actual_date = data[0]['arrival_actual_date'];
				var arrival_actual_time = data[0]['arrival_actual_time'];
				var loading_landing_start_date = data[0]['loading_landing_start_date'];
				var loading_landing_start_time = data[0]['loading_landing_start_time'];
				var loading_landing_finish_date = data[0]['loading_landing_finish_date'];
				var loading_landing_finish_time = data[0]['loading_landing_finish_time'];
				var loading_landing_documentation_date = data[0]['loading_landing_documentation_date'];
				var loading_landing_documentation_time = data[0]['loading_landing_documentation_time'];
				var departure_estimation_date = data[0]['departure_estimation_date'];
				var departure_estimation_time = data[0]['departure_estimation_time'];
				var departure_actual_date = data[0]['departure_actual_date'];
				var departure_actual_time = data[0]['departure_actual_time'];
				var created_by = data[0]['created_by'];
				var created_time = data[0]['created_time'];
				var updated_by = data[0]['updated_by'];
				var updated_time = data[0]['updated_time'];
				
				$("#langsir_empty_cont_arrival_estimation_date").val(arrival_estimation_date);
				$("#langsir_empty_cont_arrival_estimation_time").val(arrival_estimation_time);
				$("#langsir_empty_cont_arrival_actual_date").val(arrival_actual_date);
				$("#langsir_empty_cont_arrival_actual_time").val(arrival_actual_time);
				$("#langsir_empty_cont_loading_documentation_date").val(loading_landing_documentation_date);
				$("#langsir_empty_cont_loading_documentation_time").val(loading_landing_documentation_time);
				$("#langsir_empty_cont_loading_start_date").val(loading_landing_start_date);
				$("#langsir_empty_cont_loading_start_time").val(loading_landing_start_time);
				$("#langsir_empty_cont_loading_finish_date").val(loading_landing_finish_date);
				$("#langsir_empty_cont_loading_finish_time").val(loading_landing_finish_time);
				$("#langsir_empty_cont_departure_estimation_date").val(departure_estimation_date);
				$("#langsir_empty_cont_departure_estimation_time").val(departure_estimation_time);
				$("#langsir_empty_cont_departure_actual_date").val(departure_actual_date);
				$("#langsir_empty_cont_departure_actual_time").val(departure_actual_time);
		  },
		 async:   true,
		  dataType: 'json'
		}); 
		
		
	}
	
	
});

</script>

  <script>
  
  $('.regular_checkbox_time').click(function(){
	  
	    if($(this).is(':checked'))
		{
		var id = $(this).attr('id');
		time = new Date().toString("hh:mm tt");
		date = new Date().toString("dd-MM-yyyy");
		$("#"+id+"_date").val(date);
		$("#"+id+"_time").val(time);
		}
		
		
  });
  </script>

  
    <script>
  
  $('.langsir_checkbox_time').click(function(){
	  
	    if($(this).is(':checked'))
		{
		var id = $(this).attr('id');
		time = new Date().toString("hh:mm tt");
		date = new Date().toString("dd-MM-yyyy");
		$("#"+id+"_date").val(date);
		$("#"+id+"_time").val(time);
		}
		
		
  });
  </script>
  
  
    
    <script>
  
  $('.import_checkbox_time').click(function(){
	  
	    if($(this).is(':checked'))
		{
		var id = $(this).attr('id');
		time = new Date().toString("hh:mm tt");
		date = new Date().toString("dd-MM-yyyy");
		$("#"+id+"_date").val(date);
		$("#"+id+"_time").val(time);
		}
		
		
  });
  </script>
  
  
  
    <script>
  
  $('.export_checkbox_time').click(function(){
	  
	    if($(this).is(':checked'))
		{
		var id = $(this).attr('id');
		time = new Date().toString("hh:mm tt");
		date = new Date().toString("dd-MM-yyyy");
		$("#"+id+"_date").val(date);
		$("#"+id+"_time").val(time);
		}
		
		
  });
  </script>
  
  
  
   <script>
  
  $('.langsir_empty_cont_checkbox_time').click(function(){
	  
	    if($(this).is(':checked'))
		{
		var id = $(this).attr('id');
		time = new Date().toString("hh:mm tt");
		date = new Date().toString("dd-MM-yyyy");
		$("#"+id+"_date").val(date);
		$("#"+id+"_time").val(time);
		}
		
		
  });
  </script>

