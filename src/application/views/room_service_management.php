 <!-- HEADER -->
 <section class="content-header">
          <h1>
            Workshop Bay
            <small>List Of Room Workshop</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="<?php echo BASE_URL(); ?>"><i class="fa fa-dashboard"></i>Home</a></li>
            <li><a href="<?php echo BASE_URL()."room_service_management"; ?>"><i class="fa fa-dashboard"></i>Room Workshop</a></li>
          </ol>
        </section>
  
  
   <!-- Content -->
   <section class="content">
		
		
  
  
          <div class="box sms box-default color-palette-box">
            <div class="box-header with-border">
              <h3 class="box-title"><i class="fa fa-table"></i> Table Workshop</h3>
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
                <div id="wrapper-search">
                             <form action="<?php echo base_url()."index.php/room_service_management" ?>" method="get">
                             <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                                <input type="text" id="search" name="search" placeholder="Search..."  value="<?php echo $search; ?>" />
                                <input type="submit" id="submit"  value="Search"/>
                                <?php if($search!="")
								{?>
                                <a href="<?php echo base_url()."index.php/room_service_management" ?>" id="clear-search">Clear Search</a>
                                <?php } ?>
                             </form>
                </div>
                <div id="wrapper-button" class="clearfix">
					<!--<?php if($data_role[0]['export_room_service_management']=='yes'){ ?>
                	<a href="<?php echo base_url()."index.php/room_service_management/exportRoomServiceManagement?search=".$search; ?>" class="button orange-button">
                    	Export Workshop
                    </a>
					<?php } ?>-->
                    <?php if($data_role[0]['add_room_service_management']=='yes'){ ?>
                    <a id="add-data" class="button green-button">
                    	Add Workshop
                    </a>
					<?php } ?>
					<?php if($data_role[0]['delete_room_service_management']=='yes'){ ?>
                    <a id="delete-data" class="button btn-danger deletelogg">
                    	Delete Workshop
                    </a>
					<?php } ?>
					<!--<?php if($data_role[0]['import_room_service_management']=='yes'){ ?>
                    <a id="import-data" class="button blue-button">
                    	Import Room Workshop
                    </a>
					<?php } ?>-->
					
                </div>
                </div>
            <div id="wrapper-console" class="clearfix"> 
            <div class="grid_4 height400">                  
           	<table id="myTable04" class="fancyTable table table-bordered table-hover">
                    <thead>
                      <tr>
						
						
                        <th><div class="mid"><div class="check-box-div"><input type="checkbox" name="select_all" id="select_all"></div>ID</div></th>
						<th><div class="mid">Vehicle ID</div></th>
                        <th><div class="mid">Workshop ID</div></th>
						<th><div class="mid">Workshop Name</div></th>
                        <th><div class="mid">Service Type</div></th>
						<th><div class="mid">Mechanic</div></th>
						<th><div class="mid">Service Status</div></th>
						<th><div class="mid">Service Man Power</div></th>
						
						<th><div class="mid">Vendor ID</div></th>
						<th><div class="mid">Vendor Name</div></th>
						<th><div class="mid">Start Service Date</div></th>
						<th><div class="mid">Start Service Time</div></th>
						<th><div class="mid">Finished Service Date</div></th>
						<th><div class="mid">Finished Service Time</div></th>
						
						<th><div class="mid">Created By</div></th>
						<th><div class="mid">Created Date</div></th>
						<th><div class="mid">Updated By</div></th>
						<th><div class="mid">Updated Date</div></th>
						<?php if($data_role[0]['delete_room_service_management']=='yes' || $data_role[0]['edit_room_service_management']=='yes'){ ?>
						<th><div class="mid">Action</div></th>
						<?php } ?>
                      </tr>
                    </thead>
             		<tbody>
                    <?php foreach($data_room_service_management as $data_room_service_management) {?>
                    <tr id="data_<?php echo $data_room_service_management->id_room_service_management; ?>">
                    	<td class="id_room_service_management">
						<div style="width:200px;">
						<div class="check-box-div">
						<input type="checkbox" name="id_checkbox[]" class="iCheck-helper toedit checkbox_satuan" value="<?php echo $data_room_service_management->id_room_service_management; ?>" />
						</div><span><?php echo $data_room_service_management->id_room_service_management; ?></span></div></td>
						
						
                        <td class="vehicle_id"><?php echo $data_room_service_management->vehicle_id; ?></td>
						<td class="room_service_id"><?php echo $data_room_service_management->room_service_id; ?></td>
						<td class="room_name"><?php echo $data_room_service_management->room_service_name; ?></td>
						<td class="service_type"><?php echo $data_room_service_management->service_type; ?></td>
						<td class="mecanic"><?php echo $data_room_service_management->mecanic; ?></td>
						<td class="service_status"><?php echo $data_room_service_management->service_status; ?></td>
						<td class="service_man_power"><?php echo $data_room_service_management->service_man_power; ?></td>
						
						<td class="vendor_id"><?php echo $data_room_service_management->vendor_id; ?></td>
						<td class="vendor_name"><?php echo $data_room_service_management->vendor_name; ?></td>
						<td class="start_service_date"><?php convert_date($data_room_service_management->start_service_date); ?></td>
						<td class="start_service_time"><?php echo $data_room_service_management->start_service_time; ?></td>
						<td class="finished_service_date"><?php convert_date($data_room_service_management->finished_service_date); ?></td>
						<td class="finished_service_time"><?php echo $data_room_service_management->finished_service_time; ?></td>
						
						
						<td class="created_by"><?php echo $data_room_service_management->created_by; ?></td>
						<td class="created_date"><?php echo $data_room_service_management->created_date; ?></td>
						<td class="updated_by"><?php echo $data_room_service_management->updated_by; ?></td>
						<td class="updated_date"><?php echo $data_room_service_management->updated_date; ?></td>
						
						
						
						
						<?php if($data_role[0]['delete_room_service_management']=='yes' || $data_role[0]['edit_room_service_management']=='yes'){ ?>
						<td><?php if($data_role[0]['delete_room_service_management']=='yes'){ ?><a  class="delete_data link_action" id="<?php echo $data_room_service_management->id_room_service_management; ?>" >Delete</a><?php } ?> | <?php if($data_role[0]['edit_room_service_management']=='yes'){ ?><a  id="<?php echo $data_room_service_management->id_room_service_management; ?>" class="edit_data link_action">Edit</a><?php } ?> | <a  href="<?php echo "<?php echo BASE_URL(); ?>/files/example-files/SPK_Mekanik.xlsx"; ?>">Print SPK</a></td>
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
		<h2 id="modal1Title">Add Workshop Bay</h2>
				<form role="form" id="form_add_data" method="POST" action="<?php echo base_url()."index.php/room_service_management/addRoomServiceManagement" ?>" enctype="multipart/form-data">
				 <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
				 
              <div class="box-body">

				<div class="form-group">
					 <label>Vehicle ID</label>
						<div class="input-group">
						  <div class="input-group-addon">
							<i class="fa fa-search"></i>
						  </div>
						  <input type="text" class="form-control pull-right" name="search_vehicle_id" id="search_vehicle_id" value='' placeholder='Search Vehicle ID'>
						  <input type="text" readonly class="form-control" name="vehicle_id" id="vehicle_id" placeholder='Vehicle ID' required>
						</div>
						<!-- /.input group -->
				</div>
				
				
				<div class="form-group">
					 <label>Workshop</label>
						<div class="input-group">
						  <div class="input-group-addon">
							<i class="fa fa-search"></i>
						  </div>
						  <input type="text" class="form-control pull-right" name="search_room_service" id="search_room_service" value='' placeholder='Search Workshop'>
						  <input type="text" readonly class="form-control" name="room_service_id" id="room_service_id" placeholder='Workshop ID' required>
						  <input type="text" readonly class="form-control" name="room_service_name" id="room_service_name" placeholder='Workshop Name' required>
						</div>
						<!-- /.input group -->
				</div>
				
				<div class="form-group">
					  <label for="drivercode2">Service Type</label>
					  <select class="form-control" name="service_type" id="service_type" required>
						<option selected="selected" value="">Choose Service Type</option>
						<option value="Quick Repair">Quick Repair</option>
						<option value="Medium Repair">Medium Repair</option>
						<option value="Heavy">Heavy Repair</option>
						<option value="Preventive">Preventive Maintenance</option>
					  </select> 
				</div>
				
				
				<div class="form-group">
					  <label for="drivercode2">Service Status</label>
					  <select class="form-control" name="service_status" id="service_status" required>
						<option selected="selected" value="">Choose Service Status</option>
						<option value="On Progress">On Progress</option>
						<option value="queue">Queue</option>
						<option value="Finished">Finished</option>
						
					  </select> 
				</div>
				
				<div class="form-group">
					  <label for="drivercode2">Service Man Power</label>
					  <select class="form-control" name="service_man_power" id="service_man_power" required>
						<option selected="selected" value="">Choose Service Service Man Power</option>
						<option value="inhouse_service">In House Service</option>
						<option value="vendor_service">Service By Vendor</option>
					  </select> 
				</div>
				
				
			   <div id="vendor_id_div" style='display:none;'>	
			   
				   <div class="form-group">
						  <label for="drivercode2">Mecanic</label>
						 <input type="text" class="form-control" name="vendor_mecanic" id="vendor_mecanic" required>
						</div>
						
						
				   <div class="form-group vendor_id_add">
						 <label>Vendor ID</label>
							<div class="input-group">
							  <div class="input-group-addon">
								<i class="fa fa-search"></i>
							  </div>
							  <input type="text" class="form-control pull-right" name="search_vendor" id="search_vendor" value='' placeholder='Search Vendor'>
							  <input type="text" readonly class="form-control" name="vendor_id" id="vendor_id" placeholder='Vendor ID'>
							  <input type="text" readonly class="form-control" name="vendor_name" id="vendor_name" placeholder='Vendor Name'>
							</div>
							<!-- /.input group -->
					</div>
					
					
				</div>
				
				
				
				 <div id="self_service_div" style='display:none;'>	
			   
				   <div class="form-group">
						  <label for="drivercode2">Mechanic</label>
						 <input type="text" class="form-control" name="self_mecanic" id="self_mecanic" required>
						</div>
						
						
				
					
					
				</div>
				
				
				 <div class="form-group start_service_date">
					  <label for="drivercode2">Start Service Date</label>
						  <div class="input-group date">
						  <div class="input-group-addon">
							<i class="fa fa-calendar"></i>
						  </div>
						  <input type="text" name="start_service_date" id="start_service_date" class="form-control pull-right datepicker" >
						</div>
				</div>
				
				<div class="bootstrap-timepicker  form-group">
				<label for="drivercode2">Start Service Time</label>
						  <div class="input-group">
						   
						  <input type="text"  name="start_service_time" id="start_service_time" class="form-control timepicker regular_arrival_estimation" placeholder='Star Service Time' >
						  <div class="input-group-addon">
						  <i class="fa fa-clock-o"></i>
						  </div>
						  </div>
				</div>
				
				 <div class="form-group finished_service_date">
					  <label for="drivercode2">Finished Service Date</label>
						  <div class="input-group date">
						  <div class="input-group-addon">
							<i class="fa fa-calendar"></i>
						  </div>
						  <input type="text" name="finished_service_date" id="finished_service_date" class="form-control pull-right datepicker" >
						</div>
				</div>
				
				<div class="bootstrap-timepicker  form-group">
				<label for="drivercode2">Finished Service Time</label>
						  <div class="input-group">
						   
						  <input type="text"  name="finished_service_time" id="finished_service_time" class="form-control timepicker regular_arrival_estimation" placeholder='Finished Service Time' >
						  <div class="input-group-addon">
						  <i class="fa fa-clock-o"></i>
						  </div>
						  </div>
				</div>
				
					<h3>Services</h3>
					<button type="button" class='add_delete btn-table'>Delete</button>
					<button type="button" class='add_data btn-table'>Add</button>
						
					 <div class="box-body table clearfix">
						
						
							
						<table style='margin-top:10px;' class="po">
								<thead>
								<tr>
								<th><input class='check_all2' type='checkbox' onclick="select_all2()"/></th>
								<th>Service Description</th>
								<th>Spare Part</th>
								<th>Remark</th>
								</tr>
								</thead>
								<tbody>
								</tbody>
						</table>
						
						
					</div>
				
              
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button data-remodal-action="cancel" class="remodal-cancel">Cancel</button>
				<input type="submit" name="submit_add" class="remodal-confirm" value="Submit" id="submit_add">
              </div>
            </form>
	  </div>
	  <br>
	  
	</div>
	
	
	
	<div class="remodal" data-remodal-id="modal_edit" role="dialog" aria-labelledby="modal1Titl aria-describedby="modal1Desc">
	  <button data-remodal-action="close" class="remodal-close" aria-label="Close"></button>
	  <div>
		<h2 id="modal1Title">Edit Room Workshop</h2>
				<form role="form" id="form_edit_data" method="POST" action="<?php echo base_url()."index.php/room_service_management/editRoomServiceManagement" ?>" enctype="multipart/form-data">
				 <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
				 
              <div class="box-body">
				<input type='hidden' name='id_update_room_service' id='id_update_room_service' value=''>
				<div class="form-group">
					 <label>Vehicle ID</label>
						<div class="input-group">
						  <div class="input-group-addon">
							<i class="fa fa-search"></i>
						  </div>
						  <input type="text" class="form-control pull-right" name="edit_search_vehicle_id" id="edit_search_vehicle_id" value='' placeholder='Search Vehicle ID'>
						  <input type="text" readonly class="form-control" name="edit_vehicle_id" id="edit_vehicle_id" placeholder='Vehicle ID' required>
						</div>
						<!-- /.input group -->
				</div>
				
				
				<div class="form-group">
					 <label>Workshop</label>
						<div class="input-group">
						  <div class="input-group-addon">
							<i class="fa fa-search"></i>
						  </div>
						  <input type="text" class="form-control pull-right" name="edit_search_room_service" id="edit_search_room_service" value='' placeholder='Search Workshop'>
						  <input type="text" readonly class="form-control" name="edit_room_service_id" id="edit_room_service_id" placeholder='Workshop ID' required>
						  <input type="text" readonly class="form-control" name="edit_room_service_name" id="edit_room_service_name" placeholder='Workshop Name' required>
						</div>
						<!-- /.input group -->
				</div>
				
				<div class="form-group">
					  <label for="drivercode2">Service Type</label>
					  <select class="form-control" name="edit_service_type" id="edit_service_type" required>
						<option selected="selected" value="">Choose Service Type</option>
						<option value="Quick Repair">Quick Repair</option>
						<option value="Medium Repair">Medium Repair</option>
						<option value="Heavy">Heavy Repair</option>
					  </select> 
				</div>
				
				
				<div class="form-group">
					  <label for="drivercode2">Service Status</label>
					  <select class="form-control" name="edit_service_status" id="edit_service_status" required>
						<option selected="selected" value="">Choose Service Status</option>
						<option value="On Progress">On Progress</option>
						<option value="queue">Queue</option>
						<option value="Finished">Finished</option>
					  </select> 
				</div>
				
				<div class="form-group">
					  <label for="drivercode2">Service Man Power</label>
					  <select class="form-control" name="edit_service_man_power" id="edit_service_man_power" required>
						<option selected="selected" value="">Choose Service Service Man Power</option>
						<option value="inhouse_service">In House Service</option>
						<option value="vendor_service">Service By Vendor</option>
					  </select> 
				</div>
				
				
			   <div id="edit_vendor_id_div" style='display:none;'>	
			   
				   <div class="form-group">
						  <label for="drivercode2">Mechanic</label>
						 <input type="text" class="form-control" name="edit_vendor_mecanic" id="edit_vendor_mecanic" required>
						</div>
						
						
				   <div class="form-group vendor_id_add">
						 <label>Vendor ID</label>
							<div class="input-group">
							  <div class="input-group-addon">
								<i class="fa fa-search"></i>
							  </div>
							  <input type="text" class="form-control pull-right" name="search_vendor" id="search_vendor" value='' placeholder='Search Vendor'>
							  <input type="text" readonly class="form-control" name="edit_vendor_id" id="edit_vendor_id" placeholder='Vendor ID'>
							  <input type="text" readonly class="form-control" name="edit_vendor_name" id="edit_vendor_name" placeholder='Vendor Name'>
							</div>
							<!-- /.input group -->
					</div>
					
					
				</div>
				
				
				
				 <div id="edit_self_service_div" style='display:none;'>	
			   
				   <div class="form-group">
						  <label for="drivercode2">Mechanic</label>
						 <input type="text" class="form-control" name="edit_self_mecanic" id="edit_self_mecanic" required>
						</div>
						
						
				
					
					
				</div>
				
				
				 <div class="form-group start_service_date">
					  <label for="drivercode2">Start Service Date</label>
						  <div class="input-group date">
						  <div class="input-group-addon">
							<i class="fa fa-calendar"></i>
						  </div>
						  <input type="text" name="edit_start_service_date" id="edit_start_service_date" class="form-control pull-right datepicker" >
						</div>
				</div>
				
				<div class="bootstrap-timepicker  form-group">
				<label for="drivercode2">Start Service Time</label>
						  <div class="input-group">
						   
						  <input type="text"  name="edit_start_service_time" id="edit_start_service_time" class="form-control timepicker regular_arrival_estimation" placeholder='Star Service Time' >
						  <div class="input-group-addon">
						  <i class="fa fa-clock-o"></i>
						  </div>
						  </div>
				</div>
				
				 <div class="form-group finished_service_date">
					  <label for="drivercode2">Finished Service Date</label>
						  <div class="input-group date">
						  <div class="input-group-addon">
							<i class="fa fa-calendar"></i>
						  </div>
						  <input type="text" name="edit_finished_service_date" id="edit_finished_service_date" class="form-control pull-right datepicker" >
						</div>
				</div>
				
				<div class="bootstrap-timepicker  form-group">
				<label for="drivercode2">Finished Service Time</label>
						  <div class="input-group">
						   
						  <input type="text"  name="edit_finished_service_time" id="edit_finished_service_time" class="form-control timepicker regular_arrival_estimation" placeholder='Finished Service Time' >
						  <div class="input-group-addon">
						  <i class="fa fa-clock-o"></i>
						  </div>
						  </div>
				</div>
				
				<h3>Services</h3>
					<button type="button" class='edit_delete btn-table'>Delete</button>
					<button type="button" class='edit_add btn-table'>Add</button>
						
					 <div class="box-body table clearfix">
						
						
							
						<table style='margin-top:10px;' class="edit_po">
								<thead>
								<tr>
								<th><input class='check_all2' type='checkbox' onclick="edit_select_all2()"/></th>
								<th>Service Description</th>
								<th>Spare Part</th>
								<th>Remark</th>
								</tr>
								</thead>
								<tbody>
								</tbody>
						</table>
						
						
					</div>
				
              
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button data-remodal-action="cancel" class="remodal-cancel">Cancel</button>
				<input type="submit" name="submit_add" class="remodal-confirm" value="Submit" id="submit_add">
              </div>
            </form>
	  </div>
	  <br>
	  
	</div>
	
	
	
	<div class="remodal" data-remodal-id="modal_import" role="dialog" aria-labelledby="modal1Titl aria-describedby="modal1Desc">
	  <button data-remodal-action="close" class="remodal-close" aria-label="Close"></button>
	  <div>
		<h2 id="modal1Title">Import Room Workshop</h2>
				<form role="form" id="form_import_data" method="POST" action="<?php echo base_url()."index.php/room_service_management/importRoom Workshop" ?>" enctype="multipart/form-data">
				 <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
				 
              <div class="box-body">

				 <div class="form-group">
                      <label for="exampleInputEmail1">Choose File</label>
                      <input type="file" name="import_file" id="import_file" class="form-control" value="" />
				</div>
				
				 <div class="form-group">
                    <p><a target="_blank" href="<?php echo base_url('/files/example-files/import-room_service_management.xlsx')?>">Download sample file import room_service_management</a></p>
                 </div>
              
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button data-remodal-action="cancel" class="remodal-cancel">Cancel</button>
				<input type="submit" name="submit_add" class="remodal-confirm" value="Submit" id="submit_add">
              </div>
            </form>
	  </div>
	  <br>
	  
	</div>
	
	
	<div class="remodal" data-remodal-id="modal_delete" role="dialog" aria-labelledby="modal1Titl aria-describedby="modal1Desc">
	  <button data-remodal-action="close" class="remodal-close" aria-label="Close"></button>
	  <div>
		<h2 id="modal1Title">Delete Room Workshop</h2>
				<form role="form" id="form_delete_data" method="POST" action="<?php echo base_url()."index.php/room_service_management/deleteRoomWorkshop" ?>" enctype="multipart/form-data">
				 <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
				 
              <div class="box-body">

				 <div class="form-group">
                     <p>Are you sure want to delete this data? (<span id="reference_delete"></span>)</p>
				</div>
				
				 <div class="form-group">
                      <input type="hidden" name="id_room_service_management_delete" id="id_room_service_management_delete" class="form-control" value="" />
				</div>
				
				
              
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button data-remodal-action="cancel" class="remodal-cancel">Cancel</button>
				<input type="submit" name="submit_add" class="remodal-confirm" value="Submit" id="submit_add">
              </div>
            </form>
	  </div>
	  <br>
	  
	</div>
	
	
	
	
	<div class="remodal" data-remodal-id="modal_delete_all" role="dialog" aria-labelledby="modal1Titl aria-describedby="modal1Desc">
	  <button data-remodal-action="close" class="remodal-close" aria-label="Close"></button>
	  <div>
		<h2 id="modal1Title">Delete Room Workshop</h2>
				<form role="form" id="form_selected_delete_data" method="POST" action="<?php echo base_url()."index.php/room_service_management/deleteRoomWorkshopAll" ?>" enctype="multipart/form-data">
				 <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
				 
              <div class="box-body">

				 <div class="form-group">
                     <p>Are you sure want to delete selected data? </p>
				</div>
				
				 <div class="form-group">
                      <input type="hidden" name="id_room_service_management_delete_all" id="id_room_service_management_delete_all" class="form-control" value="" />
				</div>
				
				
              
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button data-remodal-action="cancel" class="remodal-cancel">Cancel</button>
				<input type="submit" name="submit_add" class="remodal-confirm" value="Submit" id="submit_add">
              </div>
            </form>
	  </div>
	  <br>
	  
	</div>
		
  <script>
			//Date picker
			$('.datepicker').datepicker({
			  autoclose: true,
			  Format: 'dd-mm-yyyy'
			});
			
			 //Timepicker
			 $(".timepicker").timepicker({
			  showInputs: false
			});
			
			
			$(".delete_data").click(function(){
				var id = $(this).attr('id');
				var room_service_id =  $('#data_'+id+' .room_service_id').text();
				var id_room_service_management =  $('#data_'+id+' .id_room_service_management span').text();
				$("#reference_delete").text("Room Workshop Code:"+room_service_id)
				$("#id_room_service_management_delete").val(id_room_service_management);
			});
			
			
			
			$(".edit_data").click(function(){
				var id = $(this).attr('id');
				var room_service_management_code =  $('#data_'+id+' .room_service_management_code').text();
				var id_room_service_management =  $('#data_'+id+' .id_room_service_management span').text();
				var room_name =  $('#data_'+id+' .room_name').text();
				var room_service_id =  $('#data_'+id+' .room_service_id').text();
				var service_type =  $('#data_'+id+' .service_type').text();
				var mecanic =  $('#data_'+id+' .mecanic').text();
				var service_status =  $('#data_'+id+' .service_status').text();
				var service_man_power =  $('#data_'+id+' .service_man_power').text();
				var vehicle_id =  $('#data_'+id+' .vehicle_id').text();
				var vendor_id =  $('#data_'+id+' .vendor_id').text();
				var vendor_name =  $('#data_'+id+' .vendor_name').text();
				var start_service_date =  $('#data_'+id+' .start_service_date').text();
				var start_service_time =  $('#data_'+id+' .start_service_time').text();
				var finished_service_date =  $('#data_'+id+' .finished_service_date').text();
				var finished_service_time =  $('#data_'+id+' .finished_service_time').text();
				$("#edit_vehicle_id").val(vehicle_id);
				$("#edit_room_service_id").val(room_service_id);
				$("#edit_room_service_name").val(room_name);
				$("#edit_start_service_date").val(start_service_date);
				$("#edit_start_service_time").val(start_service_time);
				$("#edit_finished_service_date").val(finished_service_date);
				$("#edit_finished_service_date_time").val(finished_service_time);
				
				
				if(service_man_power=='vendor_service')
				{
					
					$("#edit_vendor_id_div").show();
					$("#edit_self_service_div").hide();
					
					$("#edit_vendor_mecanic").val(mecanic);
					$("#edit_vendor_id").val(vendor_id);
					$("#edit_vendor_name").val(vendor_name);
					
				}
				else if(service_man_power=='inhouse_service')
				{
					
					$("#edit_vendor_id_div").hide();
					$("#edit_self_service_div").show();
					
					$("#edit_self_mecanic").val(mecanic);
					
				}
				
				$('#edit_service_type option[value="' + service_type + '"]').prop('selected',true);
				$('#edit_service_status option[value="' + service_status + '"]').prop('selected',true);
				$('#edit_service_man_power option[value="' + service_man_power + '"]').prop('selected',true);
				
				$("#id_update_room_service").val(id_room_service_management);
				
				$.ajax({
					  url: '<?php echo BASE_URL(); ?>/index.php/json/jsonRSM?id_room_service_management='+id_room_service_management,
					  success: function(data,status)
					  {
						$("table.edit_po tbody tr").remove();  
						createTableDetail(data);
					  },
					  async:   true,
					  dataType: 'json'
				});
				
				
			});
			
			
			function createTableDetail(data)
			{
			  for(var i=0; i<data.length;i++)
			  {
					var no = i + 1;
					
					$(".edit_po tbody").append("<tr><td><input type='checkbox' class='edit_case'/></td>"+
											 "<td><textarea class='textarea_room_service' name='service_description[]'>"+data[i]['service_description']+"</textarea></td>"+
											 "<td><textarea class='textarea_room_service' name='sparepart[]'>"+data[i]['spare_part']+"</textarea></td>"+
											 "<td><textarea class='textarea_room_service' name='remark[]'>"+data[i]['remark']+"</textarea></td>"+
											 "</tr>");
					
			  }
			 
		}

			$("#form_add_data").validate({
				
				messages: {
				vehicle_id: {
				required: 'Vehicle ID must be filled!'
				},
				room_service_id: {
				required: 'Workshop ID must be filled!'
				},
				self_mecanic: {
				required: 'Self mecanic be filled!'
				},
				room_service_name: {
				required: 'Workshop Name be filled!'
				},
				service_type: {
				required: 'Service Type be filled!'
				},
				service_status: {
				required: 'Service Status be filled!'
				},
				service_man_power: {
				required: 'Service Man Power be filled!'
				},
				vendor_mecanic: {
				required: 'Mecanic be filled!'
				},
				vendor_id: {
				required: 'vendor ID be filled!'
				},
				vendor_name: {
				required: 'vendor Name be filled!'
				},
				start_service_date: {
				required: 'Password must be filled!'
				},
				finished_service_date: {
				required: 'Password must be filled!'
				}
				
			}
			});
			
			
			
			$("#form_edit_data").validate({
				
				messages: {
				edit_vehicle_id: {
				required: 'Vehicle ID must be filled!'
				},
				edit_room_service_id: {
				required: 'Workshop ID must be filled!'
				},
				edit_self_mecanic: {
				required: 'Self mecanic be filled!'
				},
				edit_room_service_name: {
				required: 'Workshop Name be filled!'
				},
				edit_service_type: {
				required: 'Service Type be filled!'
				},
				edit_service_status: {
				required: 'Service Status be filled!'
				},
				edit_service_man_power: {
				required: 'Service Man Power be filled!'
				},
				edit_vendor_mecanic: {
				required: 'Mecanic be filled!'
				},
				edit_vendor_id: {
				required: 'vendor ID be filled!'
				},
				edit_vendor_name: {
				required: 'vendor Name be filled!'
				},
				edit_start_service_date: {
				required: 'Password must be filled!'
				},
				edit_finished_service_date: {
				required: 'Password must be filled!'
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
		$("#id_room_service_management_delete_all").val(ids);
		
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
		//auto complete Vehicle ID
        $( "#search_vehicle_id" ).autocomplete({
         source: "<?php echo BASE_URL(); ?>/index.php/json/jsonMasterUnit",  
         minLength:0,
		 select: function( event , ui ) {
			  $( "#vehicle_id" ).val(ui.item.value);
			  $(this).val('');
			  return false;
			  
        }    
        })
		.autocomplete( "instance" )._renderItem = function( ul, item ) {
		  return $( "<li style='position:relative; z-index:9999;'>" )
			.append( "<div style='font-size:10px;'>" + item.label +"</div>" )
			.appendTo( ul );
		};
		
		
		//auto complete Room
        $( "#search_room_service" ).autocomplete({
         source: "<?php echo BASE_URL(); ?>/index.php/json/jsonRoomService",  
         minLength:0,
		 select: function( event , ui ) {
			  $( "#room_service_id" ).val(ui.item.room_service_id);
			  $( "#room_service_name" ).val(ui.item.room_service_name);
			  
			  $(this).val('');
			  return false;
			  
        }    
        })
		.autocomplete( "instance" )._renderItem = function( ul, item ) {
		  return $( "<li style='position:relative; z-index:9999;'>" )
			.append( "<div style='font-size:10px;'>" + item.label +"</div>" )
			.appendTo( ul );
		};
		
		
		//auto complete Room
        $( "#search_vendor" ).autocomplete({
         source: "<?php echo BASE_URL(); ?>/index.php/json/jsonVendor",  
         minLength:0,
		 select: function( event , ui ) {
			  $( "#vendor_id" ).val(ui.item.vendor_id);
			  $( "#vendor_name" ).val(ui.item.vendor_name);
			  
			  $(this).val('');
			  return false;
			  
        }    
        })
		.autocomplete( "instance" )._renderItem = function( ul, item ) {
		  return $( "<li style='position:relative; z-index:9999;'>" )
			.append( "<div style='font-size:10px;'>" + item.label +"</div>" )
			.appendTo( ul );
		};
		
		
</script>

<script>
$( "#service_man_power" ).change(function() {
	
	var service_status = $(this).val();
	if(service_status=='vendor_service')
	{
		$("#vendor_id_div").show();
		$("#self_service_div").hide();
	}
	else if(service_status=='inhouse_service')
	{
		$("#vendor_id_div").hide();
		$("#self_service_div").show();
	}
	
});


$( "#edit_service_man_power" ).change(function() {
	
	var service_status = $(this).val();
	if(service_status=='vendor_service')
	{
		$("#edit_vendor_id_div").show();
		$("#edit_self_service_div").hide();
	}
	else if(service_status=='inhouse_service')
	{
		$("#edit_vendor_id_div").hide();
		$("#edit_self_service_div").show();
	}
	
});
</script>






<script>
		//auto complete Vehicle ID
        $( "#edit_search_vehicle_id" ).autocomplete({
         source: "<?php echo BASE_URL(); ?>/index.php/json/jsonMasterUnit",  
         minLength:0,
		 select: function( event , ui ) {
			  $( "#edit_vehicle_id" ).val(ui.item.value);
			  $(this).val('');
			  return false;
			  
        }    
        })
		.autocomplete( "instance" )._renderItem = function( ul, item ) {
		  return $( "<li style='position:relative; z-index:9999;'>" )
			.append( "<div style='font-size:10px;'>" + item.label +"</div>" )
			.appendTo( ul );
		};
		
		
		//auto complete Room
        $( "#edit_search_room_service" ).autocomplete({
         source: "<?php echo BASE_URL(); ?>/index.php/json/jsonRoomService",  
         minLength:0,
		 select: function( event , ui ) {
			  $( "#edit_room_service_id" ).val(ui.item.room_service_id);
			  $( "#edit_room_service_name" ).val(ui.item.room_service_name);
			  
			  $(this).val('');
			  return false;
			  
        }    
        })
		.autocomplete( "instance" )._renderItem = function( ul, item ) {
		  return $( "<li style='position:relative; z-index:9999;'>" )
			.append( "<div style='font-size:10px;'>" + item.label +"</div>" )
			.appendTo( ul );
		};
		
		
		//auto complete Room
        $( "#edit_search_vendor" ).autocomplete({
         source: "<?php echo BASE_URL(); ?>/index.php/json/jsonVendor",  
         minLength:0,
		 select: function( event , ui ) {
			  $( "#edit_vendor_id" ).val(ui.item.vendor_id);
			  $( "#edit_vendor_name" ).val(ui.item.vendor_name);
			  
			  $(this).val('');
			  return false;
			  
        }    
        })
		.autocomplete( "instance" )._renderItem = function( ul, item ) {
		  return $( "<li style='position:relative; z-index:9999;'>" )
			.append( "<div style='font-size:10px;'>" + item.label +"</div>" )
			.appendTo( ul );
		};
		
		
</script>


<script>
$(".add_delete").on('click', function() {
	$('.edit_case:checkbox:checked').parents("tr").remove();
    $('.edit_check_all').prop("checked", false); 
	check2();

});
var i=2;


$(".add_data").on('click', function() {
	
	addrow();

});


function addrow(){
	count=$('table.po tr').length;
    var data="<tr><td><input type='checkbox' class='edit_case'/></td>"+
			 "<td><textarea class='textarea_room_service' name='service_description[]'></textarea></td>"+
			 "<td><textarea class='textarea_room_service' name='sparepart[]'></textarea></td>"+
			 "<td><textarea class='textarea_room_service' name='remark[]'></textarea></td>"+
			 "</tr>";
	$('table.po').append(data);
	i++;
}





function select_all2() {
	$('input[class=edit_case]:checkbox').each(function(){ 

		if($('input[class=edit_case]:checkbox:checked').length == 0){
	
		$('.edit_case').prop('checked', true);			
		} else {
			$('.edit_case').prop('checked', false);	
			
		} 
	});
}

function check2(){
	obj=$('table.po tr').find('span');
	$.each( obj, function( key, value ) {
	id=value.id;
	$('#'+id).html(key+1);
	});
	}
</script>	




<script>
$(".edit_delete").on('click', function() {
	$('.edit_case:checkbox:checked').parents("tr").remove();
    $('.edit_check_all').prop("checked", false); 
	edit_check2();

});
var i=2;


$(".edit_add").on('click', function() {
	
	addrowedit();

});


function addrowedit(){
	count=$('table.edit_po tr').length;
    var data="<tr><td><input type='checkbox' class='edit_case'/></td>"+
			 "<td><textarea class='textarea_room_service' name='service_description[]'></textarea></td>"+
			 "<td><textarea class='textarea_room_service' name='sparepart[]'></textarea></td>"+
			 "<td><textarea class='textarea_room_service' name='remark[]'></textarea></td>"+
			 "</tr>";
	$('table.edit_po').append(data);
	i++;
}





function edit_select_all2() {
	$('input[class=edit_case]:checkbox').each(function(){ 

		if($('input[class=edit_case]:checkbox:checked').length == 0){
	
		$('.edit_case').prop('checked', true);			
		} else {
			$('.edit_case').prop('checked', false);	
			
		} 
	});
}

function edit_check2(){
	obj=$('table.edit_po tr').find('span');
	$.each( obj, function( key, value ) {
	id=value.id;
	$('#'+id).html(key+1);
	});
	}
</script>