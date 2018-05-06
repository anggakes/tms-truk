 <!-- HEADER -->
 <section class="content-header">
          <h1>
            Trucking Order
            <small>List Of Trucking Order</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="<?php echo BASE_URL(); ?>"><i class="fa fa-dashboard"></i>Home</a></li>
            <li><a href="<?php echo BASE_URL()."trucking_order"; ?>"><i class="fa fa-dashboard"></i>Trucking Order</a></li>
          </ol>
        </section>
  
  
   <!-- Content -->
   <section class="content">
		
		
  
  
          <div class="box sms box-default color-palette-box">
            <div class="box-header with-border">
              <h3 class="box-title"><i class="fa fa-table"></i> Table Trucking Order</h3>
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
					                	<a id="add-data" class="button blue-button">
                    	 Add
                    </a><a id="delete-data" class="button btn-danger deletelogg">
                    	Delete
                    </a><a href="http://tms2.goodevamedia.com/index.php/trucking_order/exportTrucking Order?search=" class="button green-button">
                    	Export
                    </a>
					                                        
										                    <div id="wrapper-search">
                             <form action="http://tms2.goodevamedia.com/index.php/trucking_order" method="get" style="
    width: 300px;
    height: 30px;
">
                             <input type="hidden" name="xcdsdh" value="3c21d42af63f5ef250111864418d162d">
                                <input type="text" id="search" name="search" placeholder="Search..." value="" style="
    padding-top: 7px;
    padding-bottom: 7px;
">
                                <input type="submit" id="submit" value="Search" style="
    padding-top: 8px;
    padding-bottom: 7px;
">
                                                             </form>
                </div>
										<!--                    <a id="import-data" class="button blue-button">
                    	Import Trucking Order
                    </a>
					-->
					
                </div>
                </div>
            <div id="wrapper-console" class="clearfix"> 
            <div class="grid_4 height400">                  
           	<table id="myTable04" class="fancyDarkTable table table-bordered table-hover">
                    <thead>
                      <tr>
					  
                        <th><div class="check-box-div"><input type="checkbox" name="select_all" id="select_all"></div>ID Trucking Order</th>
                        <th>Status</th>
						<th>Client ID</th>
                        <th>Manifest</th>
						<th>Vehicle Type</th>
						<th>vehicle Type Description</th>
						<th>Origin</th>
						<th>Origin Address</th>
						<th>Origin Area</th>
						<th>Req Pick Date</th>
						<th>Req Pick Time</th>
						<th>Destination</th>
						<th>Destination Address</th>
						<th>Destination Area</th>
						<th>Req Arrival Date</th>
						<th>Req Arrival Time</th>
						<th>Request By</th>
						<th>Request Date</th>
						<?php if($data_role[0]['delete_trucking_order']=='yes' || $data_role[0]['edit_trucking_order']=='yes'){ ?>
						<th>Action</th>
						<?php } ?>
                      </tr>
                    </thead>
					
					
             		<tbody>
                    <?php foreach($data_trucking_order as $data_trucking_order) {?>
                    <tr id="data_<?php echo $data_trucking_order->id_trucking_order; 
						
						$class = 'red';
						$check_trucking_order = $this->db->query("SELECT * FROM master_manifest WHERE id_trucking_order = '".$data_trucking_order->id_trucking_order."' ")->num_rows();
						if($check_trucking_order>=1)
						{
							$class = 'green';
						}
					?>">
                    	<td class="id_trucking_order">
						<div class="check-box-div">
						<input type="checkbox" name="id_checkbox[]" class="iCheck-helper toedit checkbox_satuan" value="<?php echo $data_trucking_order->id_trucking_order; ?>" />
						
						<span class="id_trucking_order" ><?php echo $data_trucking_order->id_trucking_order; ?></span>
						<span class="trip" style='display:none;'><?php echo $data_trucking_order->trip; ?></span>
						<span class="client_name" style='display:none;'><?php echo $data_trucking_order->client_name; ?></span>
						<span class="schedule_date" style='display:none;'><?php convert_date($data_trucking_order->schedule_date); ?></span>
						<span class="id_vehicle_type" style='display:none;'><?php echo $data_trucking_order->id_vehicle_type; ?></span>
						
						</div></td>
						
						<td><div class='status_trucking <?php echo $class; ?>'></div></td>
                        <td class="client_id"><?php echo $data_trucking_order->client_id; ?></td>
						<td class="manifest"><a style='cursor:pointer;' class='detail_data_manifest'><?php echo $data_trucking_order->manifest; ?></a></td>
						<td class="vehicle_type"><?php echo $data_trucking_order->vehicle_type; ?></td>
						<td class="vehicle_type_description"><?php echo $data_trucking_order->vehicle_type_description; ?></td>
                        
						<td class="origin"><?php echo $data_trucking_order->origin; ?></td>
						<td class="origin_address"><?php echo $data_trucking_order->origin_address; ?></td>
						<td class="origin_area"><?php echo $data_trucking_order->origin_area; ?></td>
						<td class="origin_pickup_date"><?php echo $data_trucking_order->origin_pickup_date; ?></td>
						<td class="origin_pickup_time"><?php echo $data_trucking_order->origin_pickup_time; ?></td>
						<td class="destination"><?php echo $data_trucking_order->destination; ?></td>
						<td class="destination_address"><?php echo $data_trucking_order->destination_address; ?></td>
						<td class="destination_area"><?php echo $data_trucking_order->destination_area; ?></td>
						<td class="destination_arrival_date"><?php echo $data_trucking_order->destination_arrival_date; ?></td>
						<td class="destination_arrival_time"><?php echo $data_trucking_order->destination_arrival_time; ?></td>
						<td class="created_by"><?php echo $data_trucking_order->created_by; ?></td>
						<td class="created_date"><?php echo $data_trucking_order->created_date; ?></td>
						
						
						<?php if($data_role[0]['delete_trucking_order']=='yes' || $data_role[0]['edit_trucking_order']=='yes'){ ?>
						<td><?php if($data_role[0]['delete_trucking_order']=='yes'){ ?><a  class="delete_data link_action" id="<?php echo $data_trucking_order->id_trucking_order; ?>" >Delete</a><?php } ?> | <?php if($data_role[0]['edit_trucking_order']=='yes'){ ?><a  id="<?php echo $data_trucking_order->id_trucking_order; ?>" class="edit_data link_action">Edit</a><?php } ?></td>
						<?php } ?>
					</tr>
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

	  
	 <div class="remodal" data-remodal-id="modal_add" role="dialog" aria-labelledby="modal1Titl aria-describedby="modal1Desc">
	  <button data-remodal-action="close" class="remodal-close" aria-label="Close"></button>
	  <div>
		<h2 id="modal1Title">Create Trucking Order</h2>
				<form role="form" id="form_add_data" method="POST" action="<?php echo base_url()."index.php/trucking_order/addTruckingOrder" ?>" enctype="multipart/form-data">
				 <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
				 
              <div class="box-body form">
				
			  <div class="form-group">
					 <label>Client ID</label>
						<div class="input-group">
						  <div class="input-group-addon">
							<i class="fa fa-search"></i>
						  </div>
						  <input type="text" class="form-control pull-right" name="search_client_id" id="search_client_id" value=''n placeholder='Search Client ID'>
						  <input type="text" readonly class="form-control" name="client_id" id="client_id" placeholder='Client ID' required>
						  <input type="text" readonly class="form-control" name="client_name" id="client_name" placeholder='Client Name' required>
						</div>
						<!-- /.input group -->
				</div>
				
				
				 <div class="form-group">
					 <label>vehicle Type</label>
						<div class="input-group">
						  <div class="input-group-addon">
							<i class="fa fa-search"></i>
						  </div>
						  <input type="text" class="form-control pull-right" name="search_vehicle_type" id="search_vehicle_type" value=''n placeholder='Search Vehicle Type'>
						  <input type="text" readonly class="form-control" name="vehicle_type" id="vehicle_type" placeholder='Vehicle Type' required>
						  <input type="text" readonly class="form-control" name="vehicle_type_description" id="vehicle_type_description" placeholder='Vehicle Type Description' required>
						  <input type="hidden" readonly class="form-control" name="vehicle_type_id" id="vehicle_type_id" placeholder='vehicle Type ID' required>
						</div>
						<!-- /.input group -->
				</div>
				
				<div class="form-group">
					  <label for="drivercode2">Schedule Date</label>
						  <div class="input-group date">
						  <div class="input-group-addon">
							<i class="fa fa-calendar"></i>
						  </div>
						  <input type="text" name="schedule_date" id="schedule_date" class="form-control pull-right datepicker"  required>
						</div>
					</div>
				
				<div class="form-group">
					  <label for="drivercode2">Trip</label>
					 <input type="text" class="form-control" name="trip" id="trip" required>
				</div>
		  
				<div class="left-form clearfix">
						
					<div class="form-group">
					 <label>Origin</label>
						<div class="input-group">
						  <div class="input-group-addon">
							<i class="fa fa-search"></i>
						  </div>
						  <input type="text" class="form-control pull-right" name="search_origin_id" id="search_origin_id" value=''n placeholder='Search origin ID'>
						  <input type="text" readonly class="form-control" name="origin_id" id="origin_id" placeholder='Origin ID' required>
						  <input type="text" readonly class="form-control" name="origin_address" id="origin_address" placeholder='Origin Address 1' required>
						  <input type="text" readonly class="form-control" name="origin_address_2" id="origin_address_2" placeholder='Origin Address 2' required>
						  <input type="text" readonly class="form-control" name="origin_area" id="origin_area" placeholder='Origin Area' required>
						  <input type="text" readonly class="form-control" name="origin_pic" id="origin_pic" placeholder='Origin PIC' required>
						  <input type="text" readonly class="form-control" name="origin_email" id="origin_email" placeholder='Origin Email' required>
						  
					</div>
						<!-- /.input group -->
					</div>
					
					
					<div class="form-group">
						  <label for="drivercode2">Pickup Date </label>
						  <div class="input-group date">
						  <div class="input-group-addon">
							<i class="fa fa-calendar"></i>
						  </div>
						  <input type="text" name="pickup_date" id="pickup_date" class="form-control pull-right datepicker"   placeholder='Pickup Date' required>
						 </div>
					</div>
					
					<div class="bootstrap-timepicker">
					<div class="form-group">
					  <label>Pickup Time</label>

					  <div class="input-group">
						<input type="text"  name="pickup_time" id="pickup_time" class="form-control timepicker" placeholder='Pickup Time' required>

						<div class="input-group-addon">
						  <i class="fa fa-clock-o"></i>
						</div>
					  </div>
					  <!-- /.input group -->
					</div>
					<!-- /.form group -->
				  </div>
				  
				  
				</div>
				
				<div class="right-form clearfix">
				
					<div class="form-group">
					 <label>Destination</label>
						<div class="input-group">
						  <div class="input-group-addon">
							<i class="fa fa-search"></i>
						  </div>
						  <input type="text" class="form-control pull-right" name="search_destination_id" id="search_destination_id" value=''n placeholder='Search destination ID'>
						  <input type="text" readonly class="form-control" name="destination_id" id="destination_id" placeholder='Destination ID' required>
						  <input type="text" readonly class="form-control" name="destination_address" id="destination_address" placeholder='Destination Address 1' required>
						  <input type="text" readonly class="form-control" name="destination_address_2" id="destination_address_2" placeholder='Destination Address 2' required>
						  <input type="text" readonly class="form-control" name="destination_area" id="destination_area" placeholder='Destination Area' required>
						  <input type="text" readonly class="form-control" name="destination_pic" id="destination_pic" placeholder='Destination PIC' required>
						  <input type="text" readonly class="form-control" name="destination_email" id="destination_email" placeholder='Destination Email' required>
						 
						</div>
						<!-- /.input group -->
				</div>
				
				 <div class="form-group">
						  <label for="drivercode2">Arrival Date</label>
						  <div class="input-group date">
						  <div class="input-group-addon">
							<i class="fa fa-calendar"></i>
						  </div>
						  <input type="text" name="arrival_date" id="arrival_date" class="form-control pull-right datepicker"  placeholder='Arrival Date' required>
						 
						</div>
					</div>
					
					
					
					<div class="bootstrap-timepicker">
                <div class="form-group">
                  <label>Arrival Time</label>

                  <div class="input-group">
                    <input type="text"  name="arrival_time" id="arrival_time" class="form-control timepicker" placeholder='Arrival Time' required>

                    <div class="input-group-addon">
                      <i class="fa fa-clock-o"></i>
                    </div>
                  </div>
                  <!-- /.input group -->
                </div>
                <!-- /.form group -->
              </div>
              
                </div>
              <!-- /.box-body -->
				<div class="clearfix"></div>
					
				
			  
			  
					 
					
					
					
					 
					
              <div class="box-footer">
                <button data-remodal-action="cancel" class="remodal-cancel">Cancel</button>
				<input type="submit" name="submit_add" class="remodal-confirm" value="Submit" id="submit_add">
              </div>
            </form>
	  </div>
	  <br>
	  
	</div>
	</div>
	
	
	
	<div class="remodal" data-remodal-id="modal_edit" role="dialog" aria-labelledby="modal1Titl aria-describedby="modal1Desc">
	  <button data-remodal-action="close" class="remodal-close" aria-label="Close"></button>
	  <div>
		<h2 id="modal1Title">Edit Trucking Order</h2>
				<form role="form" id="form_edit_data" method="POST" action="<?php echo base_url()."index.php/trucking_order/editTruckingOrder" ?>" enctype="multipart/form-data">
				 <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
				 
               <div class="box-body form">
				
			  <div class="form-group">
					 <label>Client ID</label>
						<div class="input-group">
						  <div class="input-group-addon">
							<i class="fa fa-search"></i>
						  </div>
						  <input type="text" class="form-control pull-right" name="edit_search_client_id" id="edit_search_client_id" value=''n placeholder='Search Client ID'>
						  <input type="text" readonly class="form-control" name="edit_client_id" id="edit_client_id" placeholder='Client ID' required>
						  <input type="text" readonly class="form-control" name="edit_client_name" id="edit_client_name" placeholder='Client Name' required>
						</div>
						<!-- /.input group -->
				</div>
				
				<div class="form-group">
					 <label>vehicle Type</label>
						<div class="input-group">
						  <div class="input-group-addon">
							<i class="fa fa-search"></i>
						  </div>
						  <input type="text" class="form-control pull-right" name="edit_search_vehicle_type" id="edit_search_vehicle_type" value=''n placeholder='Search Vehicle Type'>
						  <input type="text" readonly class="form-control" name="edit_vehicle_type" id="edit_vehicle_type" placeholder='Vehicle Type' required>
						  <input type="text" readonly class="form-control" name="edit_vehicle_type_description" id="edit_vehicle_type_description" placeholder='Vehicle Type Description' required>
						  <input type="hidden" readonly class="form-control" name="edit_vehicle_type_id" id="edit_vehicle_type_id" placeholder='vehicle Type ID' required>
						</div>
						<!-- /.input group -->
				</div>
				
				<div class="form-group">
					  <label for="drivercode2">Schedule Date</label>
						  <div class="input-group date">
						  <div class="input-group-addon">
							<i class="fa fa-calendar"></i>
						  </div>
						  <input type="text" name="edit_schedule_date" id="edit_schedule_date" class="form-control pull-right datepicker"  required>
						</div>
					</div>
				
				<div class="form-group">
					  <label for="drivercode2">Trip</label>
					 <input type="text" class="form-control" name="edit_trip" id="edit_trip" required>
				</div>
		  
				<div class="left-form clearfix">
						
					<div class="form-group">
					 <label>Origin</label>
						<div class="input-group">
						  <div class="input-group-addon">
							<i class="fa fa-search"></i>
						  </div>
						  <input type="text" class="form-control pull-right" name="edit_search_origin_id" id="edit_search_origin_id" value=''n placeholder='Search origin ID'>
						  <input type="text" readonly class="form-control" name="edit_origin_id" id="edit_origin_id" placeholder='Origin ID' required>
						  <input type="text" readonly class="form-control" name="edit_origin_address" id="edit_origin_address" placeholder='Origin Address 1' required>
						  <input type="text" readonly class="form-control" name="edit_origin_area" id="edit_origin_area" placeholder='Origin Area' required>
						  
					</div>
						<!-- /.input group -->
					</div>
					
					
					<div class="form-group">
						  <label for="drivercode2">Pickup Date </label>
						  <div class="input-group date">
						  <div class="input-group-addon">
							<i class="fa fa-calendar"></i>
						  </div>
						  <input type="text" name="edit_pickup_date" id="edit_pickup_date" class="form-control pull-right datepicker"   placeholder='Pickup Date' required>
						 </div>
					</div>
					
					<div class="bootstrap-timepicker">
					<div class="form-group">
					  <label>Pickup Time</label>

					  <div class="input-group">
						<input type="text"  name="edit_pickup_time" id="edit_pickup_time" class="form-control timepicker" placeholder='Pickup Time' required>

						<div class="input-group-addon">
						  <i class="fa fa-clock-o"></i>
						</div>
					  </div>
					  <!-- /.input group -->
					</div>
					<!-- /.form group -->
				  </div>
				  
				  
				</div>
				
				<div class="right-form clearfix">
				
					<div class="form-group">
					 <label>Destination</label>
						<div class="input-group">
						  <div class="input-group-addon">
							<i class="fa fa-search"></i>
						  </div>
						  <input type="text" class="form-control pull-right" name="edit_search_destination_id" id="edit_search_destination_id" value=''n placeholder='Search destination ID'>
						  <input type="text" readonly class="form-control" name="edit_destination_id" id="edit_destination_id" placeholder='Destination ID' required>
						  <input type="text" readonly class="form-control" name="edit_destination_address" id="edit_destination_address" placeholder='Destination Address 1' required>
						  <input type="text" readonly class="form-control" name="edit_destination_area" id="edit_destination_area" placeholder='Destination Area' required>
						 
						</div>
						<!-- /.input group -->
				</div>
				
				 <div class="form-group">
						  <label for="drivercode2">Arrival Date</label>
						  <div class="input-group date">
						  <div class="input-group-addon">
							<i class="fa fa-calendar"></i>
						  </div>
						  <input type="text" name="edit_arrival_date" id="edit_arrival_date" class="form-control pull-right datepicker"  placeholder='Arrival Date' required>
						 
						</div>
					</div>
					
					
					
					<div class="bootstrap-timepicker">
                <div class="form-group">
                  <label>Arrival Time</label>

                  <div class="input-group">
                    <input type="text"  name="edit_arrival_time" id="edit_arrival_time" class="form-control timepicker" placeholder='Arrival Time' required>

                    <div class="input-group-addon">
                      <i class="fa fa-clock-o"></i>
                    </div>
                  </div>
                  <!-- /.input group -->
                </div>
                <!-- /.form group -->
              </div>
              
                </div>
              <!-- /.box-body -->
				<div class="clearfix"></div>
					
				
			  
			  
              <!-- /.box-body -->

              <div class="box-footer">
                <button data-remodal-action="cancel" class="remodal-cancel">Cancel</button>
				<input type="submit" name="submit_add" class="remodal-confirm" value="Submit" id="submit_edit">
              </div>
            </form>
	  </div>
	  <br>
	  
	</div>
	
	
	
	<div class="remodal" data-remodal-id="modal_import" role="dialog" aria-labelledby="modal1Titl aria-describedby="modal1Desc">
	  <button data-remodal-action="close" class="remodal-close" aria-label="Close"></button>
	  <div>
		<h2 id="modal1Title">Import Trucking Order</h2>
				<form role="form" id="form_import_data" method="POST" action="<?php echo base_url()."index.php/trucking_order/importTrucking Order" ?>" enctype="multipart/form-data">
				 <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
				 
              <div class="box-body">

				 <div class="form-group">
                      <label for="exampleInputEmail1">Choose File</label>
                      <input type="file" name="import_file" id="import_file" class="form-control" value="" />
				</div>
				
				 <div class="form-group">
                    <p><a target="_blank" href="<?php echo base_url('/files/example-files/import-trucking_order.xlsx')?>">Download sample file import trucking_order</a></p>
                 </div>
              
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button data-remodal-action="cancel" class="remodal-cancel">Cancel</button>
				<input type="submit" name="submit_add" class="remodal-confirm" value="Submit" id="submit_import">
              </div>
            </form>
	  </div>
	  <br>
	  
	</div>
	
	
	<div class="remodal" data-remodal-id="modal_delete" role="dialog" aria-labelledby="modal1Titl aria-describedby="modal1Desc">
	  <button data-remodal-action="close" class="remodal-close" aria-label="Close"></button>
	  <div>
		<h2 id="modal1Title">Delete Trucking Order</h2>
				<form role="form" id="form_delete_data" method="POST" action="<?php echo base_url()."index.php/trucking_order/deleteTruckingOrder" ?>" enctype="multipart/form-data">
				 <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
				 
              <div class="box-body">

				 <div class="form-group">
                     <p>Are you sure want to delete this data? (<span id="reference_delete"></span>)</p>
				</div>
				
				 <div class="form-group">
                      <input type="hidden" name="id_trucking_order_delete" id="id_trucking_order_delete" class="form-control" value="" />
				</div>
				
				
              
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button data-remodal-action="cancel" class="remodal-cancel">Cancel</button>
				<input type="submit" name="submit_add" class="remodal-confirm" value="Submit" id="submit_delete">
              </div>
            </form>
	  </div>
	  <br>
	  
	</div>
	
	
	
	
	<div class="remodal" data-remodal-id="modal_delete_all" role="dialog" aria-labelledby="modal1Titl aria-describedby="modal1Desc">
	  <button data-remodal-action="close" class="remodal-close" aria-label="Close"></button>
	  <div>
		<h2 id="modal1Title">Delete Trucking Order</h2>
				<form role="form" id="form_selected_delete_data" method="POST" action="<?php echo base_url()."index.php/trucking_order/deleteTruckingOrderAll" ?>" enctype="multipart/form-data">
				 <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
				 
              <div class="box-body">

				 <div class="form-group">
                     <p>Are you sure want to delete selected data? </p>
				</div>
				
				 <div class="form-group">
                      <input type="hidden" name="id_trucking_order_delete_all" id="id_trucking_order_delete_all" class="form-control" value="" />
				</div>
				
				
              
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button data-remodal-action="cancel" class="remodal-cancel">Cancel</button>
				<input type="submit" name="submit_add" class="remodal-confirm" value="Submit" id="submit_delete_all">
              </div>
            </form>
	  </div>
	  <br>
	  
	</div>
		
		
	<div class="remodal" data-remodal-id="modal_detail" role="dialog" aria-labelledby="modal1Titl aria-describedby="modal1Desc">
	  <button data-remodal-action="close" class="remodal-close" aria-label="Close"></button>
	  <div>
		<h2 id="modal1Title">Detail Manifest</h2>
				<div class="box-body">

				<div class="form-group">
					  <label for="drivercode2">ID Manifest :</label>
					  <div class='text_description' id='detail_id_manifest'></div>
				</div>
				
				<div class="form-group">
					  <label for="drivercode2">Delivery Date :</label>
					  <div class='text_description' id='detail_delivery_date'></div>
				</div>
				
				<div class="form-group">
					  <label for="drivercode2">Trip :</label>
					  <div class='text_description' id='detail_trip'></div>
				</div>
				
				
				
				
				</div>
	</div>
	</div>	
	</div>	
  <script>

  $(".detail_data_manifest").click(function(){
	
	var id_manifest = $(this).text();
	if(id_manifest==0)
	{
		alert("Sorry there is no Manifest Number! ");
	}
	else
	{
		$('[data-remodal-id = modal_detail]').remodal().open();
		
			$.ajax({
				  url: 'http://localhost/tms/index.php/json/jsonDetailManifest?id_manifest='+id_manifest,
				  success: function(data,status)
				  {
					  $("#detail_id_manifest").text(data[0]['id_manifest']);
					  $("#detail_delivery_date").text(data[0]['delivery_date']);
					  $("#detail_trip").text(data[0]['trip']);
					
				  },
				  async:   true,
				  dataType: 'json'
				}); 
				
	}
  
  });
  
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

			
			$( "#edit_transporter" ).change(function() {
  
			  var transporter_status = $(this).val();
			  
			  if(transporter_status=='assets')
			  {
				 
				  $('#edit_truck_assets_div').show();
				  $('#edit_truck_vendor_div').hide();
			  }
			  else if(transporter_status=='vendor')
			  {
				  $('#edit_truck_assets_div').hide();
				  $('#edit_truck_vendor_div').show();
			  }
			  else{
				   $('#edit_truck_assets_div').hide();
				  $('#edit_truck_vendor_div').hide();
			  }
			});
			

			
			$(".delete_data").click(function(){
				var id = $(this).attr('id');
				var id_trucking_order =  $('#data_'+id+' .id_trucking_order span').text();
				$("#reference_delete").text("Trucking Order ID:"+id_trucking_order)
				$("#id_trucking_order_delete").val(id_trucking_order);
			});
			
			
			
			$(".edit_data").click(function(){
				var id = $(this).attr('id');
				var id_trucking_order =  $('#data_'+id+' .id_trucking_order span.id_trucking_order').text();
				var trip =  $('#data_'+id+' .id_trucking_order .trip').text();
				var client_name =  $('#data_'+id+' .id_trucking_order .client_name').text();
				var schedule_date =  $('#data_'+id+' .id_trucking_order .schedule_date').text();
				var id_vehicle_type =  $('#data_'+id+' .id_trucking_order .id_vehicle_type').text();
				
				var client_id =  $('#data_'+id+' .client_id').text();
				
				var origin =  $('#data_'+id+' .origin').text();
				var origin_address =  $('#data_'+id+' .origin_address').text();
				var origin_area =  $('#data_'+id+' .origin_area').text();
				var origin_pickup_date =  $('#data_'+id+' .origin_pickup_date').text();
				var origin_pickup_time =  $('#data_'+id+' .origin_pickup_time').text();
				var destination =  $('#data_'+id+' .destination').text();
				var destination_address =  $('#data_'+id+' .destination_address').text();
				var destination_area =  $('#data_'+id+' .destination_area').text();
				var destination_arrival_date =  $('#data_'+id+' .destination_arrival_date').text();
				var destination_arrival_time =  $('#data_'+id+' .destination_arrival_time').text();
				var vehicle_type =  $('#data_'+id+' .vehicle_type').text();
				var vehicle_type_description =  $('#data_'+id+' .vehicle_type_description').text();
				
				$("#edit_arrival_date").val(destination_arrival_date);
				$("#edit_arrival_time").val(destination_arrival_time);
				$("#edit_pickup_date").val(origin_pickup_date);
				$("#edit_pickup_time").val(origin_pickup_time);
				$("#edit_schedule_date").val(schedule_date);
				$("#edit_client_id").val(client_id);
				$("#edit_client_name").val(client_name);
				$("#edit_trip").val(trip);
				$("#edit_origin_id").val(origin);
				$("#edit_origin_address").val(origin_address);
				$("#edit_origin_address_2").val(origin_address_2);
				$("#edit_origin_area").val(origin_area);
				$("#edit_origin_pic").val(origin_pic);
				$("#edit_origin_email").val(origin_email);
				$("#edit_destination_id").val(destination);
				$("#edit_destination_address").val(destination_address);
				$("#edit_destination_address_2").val(destination_address_2);
				$("#edit_destination_area").val(destination_area);
				$("#edit_destination_pic").val(destination_pic);
				$("#edit_destination_email").val(destination_email);
				$("#id_update_trucking_order").val(id_trucking_order);
				
				$("#edit_vehicle_type").val(vehicle_type);
				$("#edit_vehicle_type_description").val(vehicle_type_description);
				$("#edit_vehicle_type_id").val(id_vehicle_type);
				
				  
				
				
			});

			$("#form_add_data").validate({
				
				messages: {
				client_id: {
				required: 'Client ID Name must be filled!'
				},
				schedule_date: {
				required: 'Schedule Date Code must be filled!'
				},
				trip: {
				required: 'Trip be filled!'
				},
				origin_id: {
				required: 'origin ID must be filled!'
				},
				origin_address: {
				required: 'origin Address must be filled!'
				},
				origin_area: {
				required: 'Origin Area must be filled!'
				},
				origin_pic: {
				required: 'origin PIC must be filled!'
				},
				origin_phone: {
				required: 'Origin Phone must be filled!'
				},
				origin_area: {
				required: 'Origin Area must be filled!'
				},
				pickup_date: {
				required: 'Pickup Date must be filled!'
				},
				pickup_time: {
				required: 'Pickup Time must be filled!'
				},
				destination_id: {
				required: 'Destination ID must be filled!'
				},
				destination_address: {
				required: 'Destination Address must be filled!'
				},
				destination_area: {
				required: 'Destination Area must be filled!'
				},
				destination_pic: {
				required: 'Destination PIC must be filled!'
				},
				destination_phone: {
				required: 'Destination Phone must be filled!'
				},
				destination_area: {
				required: 'Destination Area must be filled!'
				},
				arrival_date: {
				required: 'Arrival Date must be filled!'
				},
				arrival_time: {
				required: 'Arrival Time must be filled!'
				},
				transporter: {
				required: 'Transporter must be filled!'
				},
				vehicle_id: {
				required: 'Vehicle ID must be filled!'
				},
				driver: {
				required: 'Driver must be filled!'
				},
				vehicle_type: {
				required: 'Vendor Vehicle Type must be filled!'
				},
				vendor_transporter_id: {
				required: 'Vendor Transporter must be filled!'
				},
				vendor_vehicle_id: {
				required: 'Vendor Vehicle ID must be filled!'
				},
				vendor_driver_name: {
				required: 'Vendor Drive Name must be filled!'
				},
				vendor_driver_phone: {
				required: 'Vendor Drive Phone must be filled!'
				}
			}
			});
			
			
			
			$("#form_edit_data").validate({
				
				
				edit_messages: {
				client_id: {
				required: 'Client ID Name must be filled!'
				},
				edit_schedule_date: {
				required: 'Schedule Date Code must be filled!'
				},
				edit_trip: {
				required: 'Trip be filled!'
				},
				edit_origin_id: {
				required: 'origin ID must be filled!'
				},
				edit_origin_address: {
				required: 'origin Address must be filled!'
				},
				edit_origin_area: {
				required: 'Origin Area must be filled!'
				},
				edit_origin_pic: {
				required: 'origin PIC must be filled!'
				},
				edit_origin_phone: {
				required: 'Origin Phone must be filled!'
				},
				edit_origin_area: {
				required: 'Origin Area must be filled!'
				},
				edit_pickup_date: {
				required: 'Pickup Date must be filled!'
				},
				edit_pickup_time: {
				required: 'Pickup Time must be filled!'
				},
				edit_destination_id: {
				required: 'Destination ID must be filled!'
				},
				edit_destination_address: {
				required: 'Destination Address must be filled!'
				},
				edit_destination_area: {
				required: 'Destination Area must be filled!'
				},
				edit_destination_pic: {
				required: 'Destination PIC must be filled!'
				},
				edit_destination_phone: {
				required: 'Destination Phone must be filled!'
				},
				edit_destination_area: {
				required: 'Destination Area must be filled!'
				},
				edit_arrival_date: {
				required: 'Arrival Date must be filled!'
				},
				edit_arrival_time: {
				required: 'Arrival Time must be filled!'
				},
				edit_transporter: {
				required: 'Transporter must be filled!'
				},
				edit_vehicle_id: {
				required: 'Vehicle ID must be filled!'
				},
				edit_driver: {
				required: 'Driver must be filled!'
				},
				edit_vehicle_type: {
				required: 'Vendor Vehicle Type must be filled!'
				},
				edit_vendor_transporter_id: {
				required: 'Vendor Transporter must be filled!'
				},
				edit_vendor_vehicle_id: {
				required: 'Vendor Vehicle ID must be filled!'
				},
				edit_vendor_driver_name: {
				required: 'Vendor Drive Name must be filled!'
				},
				edit_vendor_driver_phone: {
				required: 'Vendor Drive Phone must be filled!'
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
		$("#id_trucking_order_delete_all").val(ids);
		
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
	$('[data-remodal-id = modal_edit]').remodal().open();
	var validator = $( "#form_edit_data" ).validate();
	validator.resetForm();
});

</script>

<script>

		//auto complete Client ID
		var term = $("#search_vehicle_type").val();
        $( "#search_vehicle_type" ).autocomplete({
         source: "http://localhost/tms/index.php/json/jsonVehicleType", 
         minLength:0,
		 select: function( event , ui ) {
			  $( "#vehicle_type" ).val( ui.item.vehicle_type );
			  $( "#vehicle_type_description" ).val( ui.item.description );
			  $( "#vehicle_type_id" ).val( ui.item.id_vehicle_type );
			 
        }    
        })
		.autocomplete( "instance" )._renderItem = function( ul, item ) {
		  return $( "<li style='position:relative; z-index:9999;'>" )
			.append( "<div style='font-size:10px;'>" + item.label+"</div>" )
			.appendTo( ul );
		};
		
		
		//auto complete Client ID
		var term = $("#edit_search_vehicle_type").val();
        $( "#edit_search_vehicle_type" ).autocomplete({
         source: "http://localhost/tms/index.php/json/jsonVehicleType", 
         minLength:0,
		 select: function( event , ui ) {
			  $( "#edit_vehicle_type" ).val( ui.item.vehicle_type );
			  $( "#edit_vehicle_type_description" ).val( ui.item.description );
			  $( "#edit_vehicle_type_id" ).val( ui.item.id_vehicle_type );
			 
        }    
        })
		.autocomplete( "instance" )._renderItem = function( ul, item ) {
		  return $( "<li style='position:relative; z-index:9999;'>" )
			.append( "<div style='font-size:10px;'>" + item.label+"</div>" )
			.appendTo( ul );
		};
		
		
		//auto complete Client ID
		var term = $("#search_client_id").val();
        $( "#search_client_id" ).autocomplete({
         source: "http://localhost/tms/index.php/json/jsonClient", 
         minLength:0,
		 select: function( event , ui ) {
			  $( "#client_id" ).val( ui.item.client_id );
			  $( "#client_name" ).val( ui.item.client_name );
			 
        }    
        })
		.autocomplete( "instance" )._renderItem = function( ul, item ) {
		  return $( "<li style='position:relative; z-index:9999;'>" )
			.append( "<div style='font-size:10px;'>" + item.label+"</div>" )
			.appendTo( ul );
		};
		
		
		//auto complete Client ID
		var term = $("#edit_search_client_id").val();
        $( "#edit_search_client_id" ).autocomplete({
         source: "http://localhost/tms/index.php/json/jsonClient", 
         minLength:0,
		 select: function( event , ui ) {
			  $( "#edit_client_id" ).val( ui.item.client_id );
			  $( "#edit_client_name" ).val( ui.item.client_name );
			 
        }    
        })
		.autocomplete( "instance" )._renderItem = function( ul, item ) {
		  return $( "<li style='position:relative; z-index:9999;'>" )
			.append( "<div style='font-size:10px;'>" + item.label+"</div>" )
			.appendTo( ul );
		};
		
		
		
		
		//auto complete Origin
		var term = $("#search_origin_id").val();
        $( "#search_origin_id" ).autocomplete({
         source: "http://localhost/tms/index.php/json/jsonOrigin",  
         minLength:0,
		 select: function( event , ui ) {
			  $( "#origin_id" ).val( ui.item.customer_id );
			  $( "#origin_address" ).val( ui.item.customer_address_1 );
			  $( "#origin_area" ).val( ui.item.area );
			  $( "#origin_address_2" ).val( ui.item.customer_address_1 );
			  $( "#origin_pic" ).val( ui.item.pic );
			  $( "#origin_email" ).val( ui.item.email );
			 
        }    
        })
		.autocomplete( "instance" )._renderItem = function( ul, item ) {
		  return $( "<li style='position:relative; z-index:9999;'>" )
			.append( "<div style='font-size:10px;'>" + item.label+"</div>" )
			.appendTo( ul );
		};
		
		
		
		//auto complete Origin
		var term = $("#edit_search_origin_id").val();
        $( "#edit_search_origin_id" ).autocomplete({
         source: "http://localhost/tms/index.php/json/jsonOrigin",  
         minLength:0,
		 select: function( event , ui ) {
			  $( "#edit_origin_id" ).val( ui.item.customer_id );
			  $( "#edit_origin_address" ).val( ui.item.customer_address_1 );
			  $( "#edit_origin_area" ).val( ui.item.area );
			  $( "#edit_origin_address_2" ).val( ui.item.customer_address_1 );
			  $( "#edit_origin_pic" ).val( ui.item.pic );
			  $( "#edit_origin_email" ).val( ui.item.email );
			 
        }    
        })
		.autocomplete( "instance" )._renderItem = function( ul, item ) {
		  return $( "<li style='position:relative; z-index:9999;'>" )
			.append( "<div style='font-size:10px;'>" + item.label+"</div>" )
			.appendTo( ul );
		};
		
		
		//auto complete Destination
		var term = $("#search_destination_id").val();
        $( "#search_destination_id" ).autocomplete({
         source: "http://localhost/tms/index.php/json/jsonOrigin",  
         minLength:0,
		 select: function( event , ui ) {
			  $( "#destination_id" ).val( ui.item.customer_id );
			  $( "#destination_address" ).val( ui.item.customer_address_1 );
			  $( "#destination_area" ).val( ui.item.area );
			  $( "#destination_address_2" ).val( ui.item.customer_address_1 );
			  $( "#destination_pic" ).val( ui.item.pic );
			  $( "#destination_email" ).val( ui.item.email );
			 
        }    
        })
		.autocomplete( "instance" )._renderItem = function( ul, item ) {
		  return $( "<li style='position:relative; z-index:9999;'>" )
			.append( "<div style='font-size:10px;'>" + item.label+"</div>" )
			.appendTo( ul );
		};
		
		
		
		
		//auto complete Destination
		var term = $("#search_vehicle_id").val();
        $( "#search_vehicle_id" ).autocomplete({
         source: "http://localhost/tms/index.php/json/jsonMasterUnit",  
         minLength:0,
		 select: function( event , ui ) {
			  $( "#vehicle_id" ).val( ui.item.value );
        }    
        })
		.autocomplete( "instance" )._renderItem = function( ul, item ) {
		  return $( "<li style='position:relative; z-index:9999;'>" )
			.append( "<div style='font-size:10px;'>" + item.label+"</div>" )
			.appendTo( ul );
		};
		
		
		//auto complete Destination
		var term = $("#vendor_search_transporter_id").val();
        $( "#vendor_search_transporter_id" ).autocomplete({
         source: "http://localhost/tms/index.php/json/jsonTransporter",  
         minLength:0,
		 select: function( event , ui ) {
			  $( "#vendor_transporter_id" ).val( ui.item.transporter_id );
        }    
        })
		.autocomplete( "instance" )._renderItem = function( ul, item ) {
		  return $( "<li style='position:relative; z-index:9999;'>" )
			.append( "<div style='font-size:10px;'>" + item.label+"</div>" )
			.appendTo( ul );
		};
		
		//auto complete Destination
		var term = $("#edit_vendor_search_transporter_id").val();
        $( "#edit_vendor_search_transporter_id" ).autocomplete({
         source: "http://localhost/tms/index.php/json/jsonTransporter",  
         minLength:0,
		 select: function( event , ui ) {
			  $( "#edit_vendor_transporter_id" ).val( ui.item.transporter_id );
        }    
        })
		.autocomplete( "instance" )._renderItem = function( ul, item ) {
		  return $( "<li style='position:relative; z-index:9999;'>" )
			.append( "<div style='font-size:10px;'>" + item.label+"</div>" )
			.appendTo( ul );
		};
		
		
		//auto complete Destination
		var term = $("#edit_search_vehicle_id").val();
        $( "#edit_search_vehicle_id" ).autocomplete({
         source: "http://localhost/tms/index.php/json/jsonMasterUnit",  
         minLength:0,
		 select: function( event , ui ) {
			  $( "#edit_vehicle_id" ).val( ui.item.value );
        }    
        })
		.autocomplete( "instance" )._renderItem = function( ul, item ) {
		  return $( "<li style='position:relative; z-index:9999;'>" )
			.append( "<div style='font-size:10px;'>" + item.label+"</div>" )
			.appendTo( ul );
		};
		
		
		
		
		var term = $("#edit_search_destination_id").val();
        $( "#edit_search_destination_id" ).autocomplete({
         source: "http://localhost/tms/index.php/json/jsonOrigin",  
         minLength:0,
		 select: function( event , ui ) {
			  $( "#edit_destination_id" ).val( ui.item.customer_id );
			  $( "#edit_destination_address" ).val( ui.item.customer_address_1 );
			  $( "#edit_destination_area" ).val( ui.item.area );
			  $( "#edit_destination_address_2" ).val( ui.item.customer_address_1 );
			  $( "#edit_destination_pic" ).val( ui.item.pic );
			  $( "#edit_destination_email" ).val( ui.item.email );
			 
        }    
        })
		.autocomplete( "instance" )._renderItem = function( ul, item ) {
		  return $( "<li style='position:relative; z-index:9999;'>" )
			.append( "<div style='font-size:10px;'>" + item.label+"</div>" )
			.appendTo( ul );
		};
		
		
	
  </script>

