 <!-- HEADER -->
 <section class="content-header">
          <h1>
            Truck Accident
            <small>List Of Truck Accident</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="<?php echo BASE_URL(); ?>"><i class="fa fa-dashboard"></i>Home</a></li>
            <li><a href="<?php echo BASE_URL()."truck_accident"; ?>"><i class="fa fa-dashboard"></i>Truck Accident</a></li>
          </ol>
        </section>
  
  
   <!-- Content -->
   <section class="content">
		
		
  
  
          <div class="box sms box-default color-palette-box">
            <div class="box-header with-border">
              <h3 class="box-title"><i class="fa fa-table"></i> Table Truck Accident</h3>
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
				$date = explode("-",$date);
				echo $date[2].'-'.$date[1].'-'.$date[0];		
			
			}
			?>
            <div id="wrapper-console" class="clearfix">
                <div id="wrapper-search">
                             <form action="<?php echo base_url()."index.php/truck_accident" ?>" method="get">
                             <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                                <input type="text" id="search" name="search" placeholder="Search..."  value="<?php echo $search; ?>" />
                                <input type="submit" id="submit"  value="Search"/>
                                <?php if($search!="")
								{?>
                                <a href="<?php echo base_url()."index.php/truck_accident" ?>" id="clear-search">Clear Search</a>
                                <?php } ?>
                             </form>
                </div>
                <div id="wrapper-button" class="clearfix">
					<?php if($data_role[0]['export_truck_accident']=='yes'){ ?>
                	<a href="<?php echo base_url()."index.php/truck_accident/exportTruckAccident?search=".$search; ?>" class="button orange-button">
                    	Export Truck Accident
                    </a>
					<?php } ?>
                    <?php if($data_role[0]['add_truck_accident']=='yes'){ ?>
                    <a id="add-data" class="button green-button">
                    	Add Truck Accident
                    </a>
					<?php } ?>
					<?php if($data_role[0]['delete_truck_accident']=='yes'){ ?>
                    <a id="delete-data" class="button btn-danger deletelogg">
                    	Delete Truck Accident
                    </a>
					<?php } ?>
					<!--<?php if($data_role[0]['import_truck_accident']=='yes'){ ?>
                    <a id="import-data" class="button blue-button">
                    	Import Truck Accident
                    </a>
					<?php } ?><-->
					
                </div>
                </div>
            <div id="wrapper-console" class="clearfix"> 
            <div class="grid_4 height400">                  
           	<table id="myTable04" class="fancyTable table-bordered table-hover">
                    <thead>
                      <tr>
                        <th><div class="check-box-div"><input type="checkbox" name="select_all" id="select_all"></div>ID Truck Accident</th>
                        <th>Date accident</th>
                        <th>Vehicle Id</th>
						<th>Client ID</th>
						<th>Client Name</th>
                        <th>Driver Name</th>
						<th>Driver Code</th>
                        <th>Type Accident</th>
                        <th>location</th>
						<th>Chronology Accident</th>
                        <th>Condition Vehicle After Accident</th>
						<th>Current Vehicle Position</th>
						<th>Amount Less</th>
						<th>Bap Police</th>
						<th>Created By</th>
						<th>Created Date</th>
						<th>Updated By</th>
						<th>Updated Date</th>
						<?php if($data_role[0]['delete_truck_accident']=='yes' || $data_role[0]['edit_truck_accident']=='yes'){ ?>
						<th>Action</th>
						<?php } ?>
                      </tr>
                    </thead>
             		<tbody>
                    <?php foreach($data_truck_accident as $data_truck_accident) {?>
                    <tr id="data_<?php echo $data_truck_accident->id_truck_accident; ?>">
                    	<td class="id_truck_accident">
						<div class="check-box-div">
						<input type="checkbox" name="id_checkbox[]" class="iCheck-helper toedit checkbox_satuan" value="<?php echo $data_truck_accident->id_truck_accident; ?>" />
						</div><span><?php echo $data_truck_accident->id_truck_accident; ?></span></td>
						
                        <td class="accident_date"><?php convert_date($data_truck_accident->accident_date); ?></td>
                        <td class="vehicle_id"><?php echo $data_truck_accident->vehicle_id; ?></td>
						<td class="client_id"><?php echo $data_truck_accident->client_id; ?></td>
						<td class="client_name"><?php echo $data_truck_accident->client_name; ?></td>
						
						<td class="driver_name"><?php echo $data_truck_accident->driver_name; ?></td>
						<td class="driver_code"><?php echo $data_truck_accident->driver_code; ?></td>
						<td class="accident_type"><?php echo $data_truck_accident->accident_type; ?></td>
						<td class="location"><?php echo $data_truck_accident->location; ?></td>
						<td class="chronology_accident"><?php echo $data_truck_accident->chronology_accident; ?></td>
						<td class="vehicle_condition"><?php echo $data_truck_accident->vehicle_condition; ?></td>
						<td class="vehicle_position"><?php echo $data_truck_accident->vehicle_position; ?></td>
						<td class="amount_less"><?php echo $data_truck_accident->amount_less; ?></td>
						<td class="bap_police"><?php echo $data_truck_accident->bap_police; ?></td>
						<td class="created_by"><?php echo $data_truck_accident->created_by; ?></td>
						<td class="created_date"><?php echo $data_truck_accident->created_date; ?></td>
						<td class="updated_by"><?php echo $data_truck_accident->updated_by; ?></td>
						<td class="updated_date"><?php echo $data_truck_accident->updated_date; ?></td>
						
						
						<?php if($data_role[0]['delete_truck_accident']=='yes' || $data_role[0]['edit_truck_accident']=='yes'){ ?>
						<td><?php if($data_role[0]['delete_truck_accident']=='yes'){ ?><a  class="delete_data link_action" id="<?php echo $data_truck_accident->id_truck_accident; ?>" >Delete</a><?php } ?> | <?php if($data_role[0]['edit_truck_accident']=='yes'){ ?><a  id="<?php echo $data_truck_accident->id_truck_accident; ?>" class="edit_data link_action">Edit</a><?php } ?></td>
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
		<h2 id="modal1Title">Add Truck Accident</h2>
				<form role="form" id="form_add_data" method="POST" action="<?php echo base_url()."index.php/truck_accident/addTruckAccident" ?>" enctype="multipart/form-data">
				 <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
				 
              <div class="box-body">
			  
				<div class="form-group">
					  <label for="drivercode2">Accident Date</label>
						  <div class="input-group date">
						  <div class="input-group-addon">
							<i class="fa fa-calendar"></i>
						  </div>
						  <input type="text" name="accident_date" id="accident_date" class="form-control pull-right datepicker"  required>
						</div>
					</div>

				 <div class="form-group">
					 <label>vehicle ID</label>
						<div class="input-group">
						  <div class="input-group-addon">
							<i class="fa fa-search"></i>
						  </div>
						  <input type="text" class="form-control pull-right" name="search_vehicle_id" id="search_vehicle_id" value=''n placeholder='Search Vehicle ID'>
						  <input type="text" readonly class="form-control" name="vehicle_id" id="vehicle_id" placeholder='Vehicle ID' required>
						</div>
						<!-- /.input group -->
					</div>
					
					<div class="form-group">
					 <label>Driver</label>
						<div class="input-group">
						  <div class="input-group-addon">
							<i class="fa fa-search"></i>
						  </div>
						  <input type="text" class="form-control pull-right" name="search_driver" id="search_driver" value=''n placeholder='Search Driver'>
						  <input type="text" readonly class="form-control" name="driver_code" id="driver_code" placeholder='Driver Code' required>
						  <input type="text" readonly class="form-control" name="driver_name" id="driver_name" placeholder='Driver Code' required>
						</div>
						<!-- /.input group -->
					</div>
					
					<div class="form-group">
					 <label>Client</label>
						<div class="input-group">
						  <div class="input-group-addon">
							<i class="fa fa-search"></i>
						  </div>
						  <input type="text" class="form-control pull-right" name="search_client" id="search_client" value=''n placeholder='Search Client'>
						  <input type="text" readonly class="form-control" name="client_id" id="client_id" placeholder='Client ID' required>
						  <input type="text" readonly class="form-control" name="client_name" id="client_name" placeholder='Client Name' required>
						</div>
						<!-- /.input group -->
					</div>
				
				
					<div class="form-group">
					  <label for="drivercode2">Accident Type</label>
					  <select class="form-control" name="accident_type" id="accident_type" required>
						<option selected="selected" value="">Choose Accident Type</option>
							 <?php foreach($data_category_accident as $data_category_accident1) {?>
								<option value='<?php echo $data_category_accident1->description; ?>'><?php echo $data_category_accident1->description; ?></option>
							 <?php } ?>
					  </select> 
					</div>
				
					 <div class="form-group">
					  <label for="drivercode2">Location</label>
					 <input type="text" class="form-control" name="location" id="location" required>
					</div>
					
					<div class="form-group">
					  <label for="drivercode2">Chronology Accident</label>
					 <textarea class="form-control" name="chronology_accident" id="chronology_accident" required></textarea>
					</div>
					
					<div class="form-group">
					  <label for="drivercode2">Vehicle Condition After Accident</label>
					 <textarea class="form-control" name="vehicle_condition" id="vehicle_condition" required></textarea>
					</div>
					
					<div class="form-group">
					  <label for="drivercode2">Current Vehicle Position</label>
					 <textarea class="form-control" name="vehicle_position" id="vehicle_position" required></textarea>
					</div>
					
					<div class="form-group">
					  <label for="drivercode2">Amount Less</label>
					 <textarea class="form-control" name="amount_less" id="amount_less" required></textarea>
					</div>
					
					<div class="form-group">
					  <label for="drivercode2">BAP Police</label>
					 <textarea class="form-control" name="bap_police" id="bap_police" required></textarea>
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
		<h2 id="modal1Title">Edit Truck Accident</h2>
				<form role="form" id="form_edit_data" method="POST" action="<?php echo base_url()."index.php/truck_accident/editTruckAccident" ?>" enctype="multipart/form-data">
				 <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
				 
              <div class="box-body">

				<div class="form-group">
					  <label for="drivercode2">Accident Date</label>
						  <div class="input-group date">
						  <div class="input-group-addon">
							<i class="fa fa-calendar"></i>
						  </div>
						  <input type="text" name="edit_accident_date" id="edit_accident_date" class="form-control pull-right datepicker"  required>
						</div>
					</div>
					
				 <div class="form-group">
					 <label>vehicle ID</label>
						<div class="input-group">
						  <div class="input-group-addon">
							<i class="fa fa-search"></i>
						  </div>
						  <input type="text" class="form-control pull-right" name="edit_search_vehicle_id" id="edit_search_vehicle_id" value=''n placeholder='Search Vehicle ID'>
						  <input type="text" readonly class="form-control" name="edit_vehicle_id" id="edit_vehicle_id" placeholder='Vehicle ID' required>
						</div>
						<!-- /.input group -->
					</div>
					
					<div class="form-group">
					 <label>Driver</label>
						<div class="input-group">
						  <div class="input-group-addon">
							<i class="fa fa-search"></i>
						  </div>
						  <input type="text" class="form-control pull-right" name="edit_search_driver" id="edit_search_driver" value=''n placeholder='Search Driver'>
						  <input type="text" readonly class="form-control" name="edit_driver_code" id="edit_driver_code" placeholder='Driver Code' required>
						  <input type="text" readonly class="form-control" name="edit_driver_name" id="edit_driver_name" placeholder='Driver Code' required>
						</div>
						<!-- /.input group -->
					</div>
					
					<div class="form-group">
					 <label>Client</label>
						<div class="input-group">
						  <div class="input-group-addon">
							<i class="fa fa-search"></i>
						  </div>
						  <input type="text" class="form-control pull-right" name="edit_search_client" id="edit_search_client" value=''n placeholder='Search Client'>
						  <input type="text" readonly class="form-control" name="edit_client_id" id="edit_client_id" placeholder='Client ID' required>
						  <input type="text" readonly class="form-control" name="edit_client_name" id="edit_client_name" placeholder='Client Name' required>
						</div>
						<!-- /.input group -->
					</div>
				
				
					<div class="form-group">
					  <label for="drivercode2">Accident Type</label>
					  <select class="form-control" name="edit_accident_type" id="edit_accident_type" required>
						<option selected="selected" value="">Choose Accident Type</option>
						<?php foreach($data_category_accident as $data_category_accident2) {?>
								<option value='<?php echo $data_category_accident2->description; ?>'><?php echo $data_category_accident2->description; ?></option>
							 <?php } ?>
					  </select> 
					</div>
				
					 <div class="form-group">
					  <label for="drivercode2">Location</label>
					 <input type="text" class="form-control" name="edit_location" id="edit_location" required>
					</div>
					
					<div class="form-group">
					  <label for="drivercode2">Chronology Accident</label>
					 <textarea class="form-control" name="edit_chronology_accident" id="edit_chronology_accident" required></textarea>
					</div>
					
					<div class="form-group">
					  <label for="drivercode2">Vehicle Condition After Accident</label>
					 <textarea class="form-control" name="edit_vehicle_condition" id="edit_vehicle_condition" required></textarea>
					</div>
					
					<div class="form-group">
					  <label for="drivercode2">Current Vehicle Position</label>
					 <textarea class="form-control" name="edit_vehicle_position" id="edit_vehicle_position" required></textarea>
					</div>
					
					<div class="form-group">
					  <label for="drivercode2">Amount Less</label>
					 <textarea class="form-control" name="edit_amount_less" id="edit_amount_less" required></textarea>
					</div>
					
					<div class="form-group">
					  <label for="drivercode2">BAP Police</label>
					 <textarea class="form-control" name="edit_bap_police" id="edit_bap_police" required></textarea>
					</div>
					
                <input type="hidden" class="form-control" name="id_truck_accident_update" id="id_truck_accident_update">
              
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
		<h2 id="modal1Title">Import Driver</h2>
				<form role="form" id="form_import_data" method="POST" action="<?php echo base_url()."index.php/driver/importDriver" ?>" enctype="multipart/form-data">
				 <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
				 
              <div class="box-body">

				 <div class="form-group">
                      <label for="exampleInputEmail1">Choose File</label>
                      <input type="file" name="import_file" id="import_file" class="form-control" value="" />
				</div>
				
				 <div class="form-group">
                    <p><a target="_blank" href="<?php echo base_url('/files/example-files/import-driver.xlsx')?>">Download sample file import driver</a></p>
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
		<h2 id="modal1Title">Delete Truck Accident</h2>
				<form role="form" id="form_delete_data" method="POST" action="<?php echo base_url()."index.php/truck_accident/deleteTruckAccident" ?>" enctype="multipart/form-data">
				 <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
				 
              <div class="box-body">

				 <div class="form-group">
                     <p>Are you sure want to delete this data? (<span id="reference_delete"></span>)</p>
				</div>
				
				 <div class="form-group">
                      <input type="hidden" name="id_truck_accident_delete" id="id_truck_accident_delete" class="form-control" value="" />
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
		<h2 id="modal1Title">Delete Truck Accident</h2>
				<form role="form" id="form_selected_delete_data" method="POST" action="<?php echo base_url()."index.php/truck_accident/deleteTruckAccidentAll" ?>" enctype="multipart/form-data">
				 <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
				 
              <div class="box-body">

				 <div class="form-group">
                     <p>Are you sure want to delete selected data? </p>
				</div>
				
				 <div class="form-group">
                      <input type="hidden" name="id_truck_accident_delete_all" id="id_truck_accident_delete_all" class="form-control" value="" />
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
			$('.datepicker').datepicker({
			  autoclose: true,
			  Format: 'dd-mm-yyyy'
			});
			
			
			$(".delete_data").click(function(){
				var id = $(this).attr('id');
				var vehicle_id =  $('#data_'+id+' .vehicle_id').text();
				var id_truck_accident =  $('#data_'+id+' .id_truck_accident span').text();
				var accident_date =  $('#data_'+id+' .accident_date').text();
				$("#reference_delete").text("Vehicle ID:"+vehicle_id+" Date Accident: "+accident_date);
				$("#id_truck_accident_delete").val(id_truck_accident);
			});
			
			
			
			$(".edit_data").click(function(){
				var id = $(this).attr('id');
				var accident_date =  $('#data_'+id+' .accident_date').text();
				var vehicle_id =  $('#data_'+id+' .vehicle_id').text();
				var id_truck_accident =  $('#data_'+id+' .id_truck_accident span').text();
				var driver_name =  $('#data_'+id+' .driver_name').text();
				var driver_code =  $('#data_'+id+' .driver_code').text();
				var client_id =  $('#data_'+id+' .client_id').text();
				var client_name =  $('#data_'+id+' .client_name').text();
				var driver_code =  $('#data_'+id+' .driver_code').text();
				var accident_type =  $('#data_'+id+' .accident_type').text();
				var location =  $('#data_'+id+' .location').text();
				var chronology_accident =  $('#data_'+id+' .chronology_accident').text();
				var vehicle_condition =  $('#data_'+id+' .vehicle_condition').text();
				var vehicle_position =  $('#data_'+id+' .vehicle_position').text();
				var amount_less =  $('#data_'+id+' .amount_less').text();
				var bap_police =  $('#data_'+id+' .bap_police').text();
				
				
				$("#edit_accident_date").val(accident_date);
				$("#edit_vehicle_id").val(vehicle_id);
				$("#edit_driver_name").val(driver_name);
				$("#edit_driver_code").val(driver_code);
				$("#edit_client_id").val(client_id);
				$("#edit_client_name").val(client_name);
				$('#edit_accident_type option[value="' + accident_type + '"]').prop('selected',true);
				
				$("#edit_location").val(location);
				$("#edit_chronology_accident").val(chronology_accident);
				$("#edit_vehicle_condition").val(vehicle_condition);
				$("#edit_vehicle_position").val(vehicle_position);
				$("#edit_amount_less").val(amount_less);
				$("#edit_bap_police").val(bap_police);
				$("#id_truck_accident_update").val(id_truck_accident);
			});

			$("#form_add_data").validate({
				rules: {
				amount_less: {
				  digits: true
				}
				},
				messages: {
				accident_date: {
				required: 'Accident Date must be filled!'
				},
				vehicle_id: {
				required: 'vehicle ID must be filled!'
				},
				driver_code: {
				required: 'Driver Code must be filled!'
				},
				driver_name: {
				required: 'Driver Name must be filled!'
				},
				client_name: {
				required: 'Client Name must be filled!'
				},
				client_id: {
				required: 'Client ID must be filled!'
				},
				accident_type: {
				required: 'Accident Type must be filled!'
				},
				location: {
				required: 'Location must be filled!'
				},
				chronology_accident: {
				required: 'Chronology Accident must be filled!'
				},
				vehicle_condition: {
				required: 'Vehicle Condition must be filled!'
				},
				vehicle_position: {
				required: 'Vehicle Position must be filled!'
				},
				amount_less: {
				required: 'Amount Less must be filled!'
				},
				bap_police: {
				required: 'BAP Police must be filled!'
				}
				
			}
			});
			
			
			
			$("#form_edit_data").validate({
				rules: {
				edit_amount_less: {
				  digits: true
				}
				},
				messages: {
				edit_accident_date: {
				required: 'Accident Date must be filled!'
				},
				edit_vehicle_id: {
				required: 'vehicle ID must be filled!'
				},
				edit_driver_code: {
				required: 'Driver Code must be filled!'
				},
				edit_driver_name: {
				required: 'Driver Name must be filled!'
				},
				edit_client_name: {
				required: 'Client Name must be filled!'
				},
				edit_client_id: {
				required: 'Client ID must be filled!'
				},
				edit_accident_type: {
				required: 'Accident Type must be filled!'
				},
				edit_location: {
				required: 'Location must be filled!'
				},
				edit_chronology_accident: {
				required: 'Chronology Accident must be filled!'
				},
				edit_vehicle_condition: {
				required: 'Vehicle Condition must be filled!'
				},
				edit_vehicle_position: {
				required: 'Vehicle Position must be filled!'
				},
				edit_amount_less: {
				required: 'Amount Less must be filled!'
				},
				edit_bap_police: {
				required: 'BAP Police must be filled!'
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
		$("#id_truck_accident_delete_all").val(ids);
		
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
		//auto complete Vehicle
        $( "#search_vehicle_id" ).autocomplete({
         source: "<?php echo BASE_URL(); ?>/index.php/json/jsonMasterUnit",  
         minLength:0,
		 select: function( event , ui ) {
			  $( "#vehicle_id" ).val(ui.item.label);
			  $(this).val('');
			  return false;
			  
        }    
        })
		.autocomplete( "instance" )._renderItem = function( ul, item ) {
		  return $( "<li style='position:relative; z-index:9999;'>" )
			.append( "<div style='font-size:10px;'>" + item.label +"</div>" )
			.appendTo( ul );
		};
		
		
		//auto complete Driver
        $( "#search_driver" ).autocomplete({
         source: "<?php echo BASE_URL(); ?>/index.php/json/jsonDriver",  
         minLength:0,
		 select: function( event , ui ) {
			  $( "#driver_code" ).val(ui.item.driver_code);
			  $( "#driver_name" ).val(ui.item.driver_name);
			  $(this).val('');
			  return false;
			  
        }    
        })
		.autocomplete( "instance" )._renderItem = function( ul, item ) {
		  return $( "<li style='position:relative; z-index:9999;'>" )
			.append( "<div style='font-size:10px;'>" + item.label +"</div>" )
			.appendTo( ul );
		};
		
		
		//auto complete Cient
        $( "#search_client" ).autocomplete({
         source: "<?php echo BASE_URL(); ?>/index.php/json/jsonClient",  
         minLength:0,
		 select: function( event , ui ) {
			  $( "#client_id" ).val(ui.item.client_id);
			  $( "#client_name" ).val(ui.item.client_name);
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
		//auto complete Vehicle
        $( "#edit_search_vehicle_id" ).autocomplete({
         source: "<?php echo BASE_URL(); ?>/index.php/json/jsonMasterUnit",  
         minLength:0,
		 select: function( event , ui ) {
			  $( "#edit_vehicle_id" ).val(ui.item.label);
			  $(this).val('');
			  return false;
			  
        }    
        })
		.autocomplete( "instance" )._renderItem = function( ul, item ) {
		  return $( "<li style='position:relative; z-index:9999;'>" )
			.append( "<div style='font-size:10px;'>" + item.label +"</div>" )
			.appendTo( ul );
		};
		
		
		//auto complete Driver
        $( "#edit_search_driver" ).autocomplete({
         source: "<?php echo BASE_URL(); ?>/index.php/json/jsonDriver",  
         minLength:0,
		 select: function( event , ui ) {
			  $( "#edit_driver_code" ).val(ui.item.driver_code);
			  $( "#edit_driver_name" ).val(ui.item.driver_name);
			  $(this).val('');
			  return false;
			  
        }    
        })
		.autocomplete( "instance" )._renderItem = function( ul, item ) {
		  return $( "<li style='position:relative; z-index:9999;'>" )
			.append( "<div style='font-size:10px;'>" + item.label +"</div>" )
			.appendTo( ul );
		};
		
		
		//auto complete Cient
        $( "#edit_search_client" ).autocomplete({
         source: "<?php echo BASE_URL(); ?>/index.php/json/jsonClient",  
         minLength:0,
		 select: function( event , ui ) {
			  $( "#edit_client_id" ).val(ui.item.client_id);
			  $( "#edit_client_name" ).val(ui.item.client_name);
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