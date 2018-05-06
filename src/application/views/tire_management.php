 <!-- HEADER -->
 <section class="content-header">
          <h1>
            Tire Management
            <small>List Of Tire</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="<?php echo BASE_URL(); ?>"><i class="fa fa-dashboard"></i>Home</a></li>
            <li><a href="<?php echo BASE_URL()."driver"; ?>"><i class="fa fa-dashboard"></i>Tire</a></li>
          </ol>
        </section>
  
  
   <!-- Content -->
   <section class="content">
		
		
  
  
          <div class="box sms box-default color-palette-box">
            <div class="box-header with-border">
              <h3 class="box-title"><i class="fa fa-table"></i> Table Tire Management</h3>
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
			?>
            <div id="wrapper-console" class="clearfix">
                <div id="wrapper-search">
                             <form action="<?php echo base_url()."index.php/tire_management" ?>" method="get">
                             <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                                <input type="text" id="search" name="search" placeholder="Search..."  value="<?php echo $search; ?>" />
                                <input type="submit" id="submit"  value="Search"/>
                                <?php if($search!="")
								{?>
                                <a href="<?php echo base_url()."index.php/tire_management" ?>" id="clear-search">Clear Search</a>
                                <?php } ?>
                             </form>
                </div>
                <div id="wrapper-button" class="clearfix">
					<?php if($data_role[0]['export_driver']=='yes'){ ?>
                	<a href="<?php echo base_url()."index.php/tire_management/exportTire?search=".$search; ?>" class="button orange-button">
                    	Export Tire
                    </a>
					<?php } ?>
                    <?php if($data_role[0]['add_tire']=='yes'){ ?>
                    <a id="add-data" class="button green-button">
                    	Add Tire
                    </a>
					<?php } ?>
					<?php if($data_role[0]['delete_tire']=='yes'){ ?>
                    <a id="delete-data" class="button btn-danger deletelogg">
                    	Delete Tire
                    </a>
					<?php } ?>
					<!--<?php if($data_role[0]['import_tire']=='yes'){ ?>
                    <a id="import-data" class="button blue-button">
                    	Import Tire
                    </a>
					<?php } ?>-->
					
                </div>
                </div>
            <div id="wrapper-console" class="clearfix"> 
            <div class="grid_4 height400">                  
           	<table id="myTable04" class="fancyTable table-bordered table-hover">
                    <thead>
                      <tr>
					  
                        <th><div class="check-box-div"><input type="checkbox" name="select_all" id="select_all"></div>ID Tire</th>
                        <th>Product Code</th>
                        <th>Serial Number</th>
						<th>Description</th>
                        <th>Unit Type</th>
						<th>Condition Off Tire</th>
						<th>Current Odo Meter</th>
                        <th>Installed Status</th>
						<th>Vehicle ID</th>
						<th>Chasis ID</th>
                        <th>Warehouse ID</th>
						<th>Location</th>
                        <th>Recycle Status</th>
						<?php if($data_role[0]['delete_tire']=='yes' || $data_role[0]['edit_tire']=='yes'){ ?>
						<th>Action</th>
						<?php } ?>
						
                      </tr>
                    </thead>
             		<tbody>
                    <?php foreach($data_tire as $data_tire) {?>
                    <tr id="data_<?php echo $data_tire->id_tire; ?>">
                    	<td class="id_tire">
						<div class="check-box-div">
						<input type="checkbox" name="id_checkbox[]" class="iCheck-helper toedit checkbox_satuan" value="<?php echo $data_tire->id_tire; ?>" /></div><span><?php echo $data_tire->id_tire; ?></span></td>
						
                   
						
                        <td class="product_code"><?php echo $data_tire->product_code; ?></td>
                        <td class="serial_number"><?php echo $data_tire->serial_number; ?></td>
						<td class="description"><?php echo $data_tire->description; ?></td>
						<td class="unit_type"><?php echo $data_tire->unit_type; ?></td>
						<td class="condition_off_tire"><?php echo $data_tire->condition_off_tire; ?></td>
						<td class="current_odo_meter"><?php echo $data_tire->current_odo_meter; ?></td>
						<td class="installed_status"><?php echo $data_tire->installed_status; ?></td>
						<td class="vehicle_id"><?php echo $data_tire->vehicle_id; ?></td>
						<td class="chasis_id"><?php echo $data_tire->chasis_id; ?></td>
						<td class="warehouse_id"><?php echo $data_tire->warehouse_id; ?></td>
						<td class="location"><?php echo $data_tire->location_code; ?></td>
						<td class="recycle_status"><?php echo $data_tire->recycle_status; ?></td>
						
						<?php if($data_role[0]['delete_tire']=='yes' || $data_role[0]['edit_tire']=='yes'){ ?>
						<td><?php if($data_role[0]['delete_tire']=='yes'){ ?><a  class="delete_data link_action" id="<?php echo $data_tire->id_tire; ?>" >Delete</a><?php } ?> | <?php if($data_role[0]['edit_tire']=='yes'){ ?><a  id="<?php echo $data_tire->id_tire; ?>" class="edit_data link_action">Edit</a><?php } ?></td>
						
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
		<h2 id="modal1Title">Add Tire</h2>
				<form role="form" id="form_add_data" method="POST" action="<?php echo base_url()."index.php/tire_management/addTire" ?>" enctype="multipart/form-data">
				 <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
				 
              <div class="box-body">

				 <div class="form-group">
                  <label for="drivercode2">Product Code</label>
                 <input type="text" class="form-control" name="product_code" id="product_code" required>
                 </div>
				 
				 <div class="form-group">
                 <label for="drivercode2">Serial Number</label>
                 <input type="text" class="form-control" name="serial_number" id="serial_number" required>
                 </div>
				 
				 
				 <div class="form-group">
                 <label for="drivercode2">Description</label>
                 <input type="text" class="form-control" name="description" id="description" required>
                 </div>
				 
				 <div class="form-group">
                 <label for="drivercode2">Current ODO Meter</label>
                 <input type="text" class="form-control" name="current_odo_meter" id="current_odo_meter" required>
                 </div>
				 
				 <div class="form-group">
					  <label for="drivercode2">Installed Status</label>
					  <select class="form-control" name="installed_status" id="installed_status" required>
						<option selected="selected" value="">Choose Installed Status</option>
						<option value="installed">Installed</option>
						<option value="not_installed">Not Installed</option>
					  </select> 
				</div>
				
				
				<div class="form-group">
					  <label for="drivercode2">Condition Off Tire</label>
					  <select class="form-control" name="condition_off_tire" id="condition_off_tire" required>
						<option selected="selected" value="">Choose Condition Off Tire</option>
						<option value="new">New</option>
						<option value="second">Second</option>
						<option value="slippery">Slippery</option>
					  </select> 
				</div>
				
				
				<!-- Installed -->
				<div class='installed' style='display:none'>
					
					<div class="form-group">
					  <label for="drivercode2">Unit Type</label>
					  <select class="form-control" name="unit_type" id="unit_type" required>
						<option selected="selected" value="">Choose Unit Type</option>
						<option value="vehicle">Vehicle</option>
						<option value="chasis">Chasis</option>
					  </select> 
					</div>
					
					<!-- Chasis -->
					<div class='chasis' style='display:none'>
							
						<div class="form-group">
						 <label>Chasis ID</label>
							<div class="input-group">
							  <div class="input-group-addon">
								<i class="fa fa-search"></i>
							  </div>
							  <input type="text" class="form-control pull-right" name="chasis_id" id="chasis_id" value='' required>
							</div>
							<!-- /.input group -->
						</div>
							
					</div>
					<!-- Chasis End -->
					
					<!-- Vehicle -->
					<div class='vehicle' style='display:none'>
						<div class="form-group">
						 <label>Vehicle ID</label>
							<div class="input-group">
							  <div class="input-group-addon">
								<i class="fa fa-search"></i>
							  </div>
							  <input type="text" class="form-control pull-right" name="vehicle_id" id="vehicle_id" value='' required>
							</div>
							<!-- /.input group -->
						</div>
					</div>
					<!-- Vehicle End -->
					
				</div>
				<!-- Installed End -->
				
				<!-- Not Installed -->
				<div class='not_installed' style='display:none'>
						
						<div class="form-group">
						 <label>Warehouse ID</label>
							<div class="input-group">
							  <div class="input-group-addon">
								<i class="fa fa-search"></i>
							  </div>
							  <input type="text" class="form-control pull-right" name="warehouse_id" id="warehouse_id" value='' required>
							</div>
							<!-- /.input group -->
						</div>
						
						<div class="form-group">
						 <label>Location</label>
							<div class="input-group">
							  <div class="input-group-addon">
								<i class="fa fa-search"></i>
							  </div>
							  <input type="text" class="form-control pull-right" name="location" id="location" value='' required>
							</div>
							<!-- /.input group -->
						</div>
						
						
						<div class="form-group">
						  <label for="drivercode2">Recycle Status</label>
						  <select class="form-control" name="status_recycle" id="status_recycle" required>
							<option selected="selected" value="">Choose Recycle Status</option>
							<option value="not_recyling">Not Recyling</option>
							<option value="recyling">Recyling</option>
						  </select> 
					   </div>
						
				</div>
				<!-- Not Installed End -->
				
				
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
		<h2 id="modal1Title">Edit Tire</h2>
				<form role="form" id="form_edit_data" method="POST" action="<?php echo base_url()."index.php/tire_management/editTire" ?>" enctype="multipart/form-data">
				 <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
				 
              <div class="box-body">

				 <div class="form-group">
                  <label for="drivercode2">Product Code</label>
                 <input type="text" class="form-control" name="edit_product_code" id="edit_product_code" required>
                 </div>
				 
				 <div class="form-group">
                 <label for="drivercode2">Serial Number</label>
                 <input type="text" class="form-control" name="edit_serial_number" id="edit_serial_number" required>
                 </div>
				 
				 
				 <div class="form-group">
                 <label for="drivercode2">Description</label>
                 <input type="text" class="form-control" name="edit_description" id="edit_description" required>
                 </div>
				 
				 <div class="form-group">
                 <label for="drivercode2">Current ODO Meter</label>
                 <input type="text" class="form-control" name="edit_current_odo_meter" id="edit_current_odo_meter" required>
                 </div>
				 
				 <div class="form-group">
					  <label for="drivercode2">Installed Status</label>
					  <select class="form-control" name="edit_installed_status" id="edit_installed_status" required>
						<option selected="selected" value="">Choose Installed Status</option>
						<option value="installed">Installed</option>
						<option value="not_installed">Not Installed</option>
					  </select> 
				</div>
				
				
				<div class="form-group">
					  <label for="drivercode2">Condition Off Tire</label>
					  <select class="form-control" name="edit_condition_off_tire" id="edit_condition_off_tire" required>
						<option selected="selected" value="">Choose Condition Off Tire</option>
						<option value="new">New</option>
						<option value="second">Second</option>
						<option value="slippery">Slippery</option>
					  </select> 
				</div>
				
				
				<!-- Installed -->
				<div class='installed' style='display:none'>
					
					<div class="form-group">
					  <label for="drivercode2">Unit Type</label>
					  <select class="form-control" name="edit_unit_type" id="edit_unit_type" required>
						<option selected="selected" value="">Choose Unit Type</option>
						<option value="vehicle">Vehicle</option>
						<option value="chasis">Chasis</option>
					  </select> 
					</div>
					
					<!-- Chasis -->
					<div class='chasis' style='display:none'>
							
						<div class="form-group">
						 <label>Chasis ID</label>
							<div class="input-group">
							  <div class="input-group-addon">
								<i class="fa fa-search"></i>
							  </div>
							  <input type="text" class="form-control pull-right" name="edit_chasis_id" id="edit_chasis_id" value='' required>
							</div>
							<!-- /.input group -->
						</div>
							
					</div>
					<!-- Chasis End -->
					
					<!-- Vehicle -->
					<div class='vehicle' style='display:none'>
						<div class="form-group">
						 <label>Vehicle ID</label>
							<div class="input-group">
							  <div class="input-group-addon">
								<i class="fa fa-search"></i>
							  </div>
							  <input type="text" class="form-control pull-right" name="edit_vehicle_id" id="edit_vehicle_id" value='' required>
							</div>
							<!-- /.input group -->
						</div>
					</div>
					<!-- Vehicle End -->
					
				</div>
				<!-- Installed End -->
				
				<!-- Not Installed -->
				<div class='not_installed' style='display:none'>
						
						<div class="form-group">
						 <label>Warehouse ID</label>
							<div class="input-group">
							  <div class="input-group-addon">
								<i class="fa fa-search"></i>
							  </div>
							  <input type="text" class="form-control pull-right" name="edit_warehouse_id" id="edit_warehouse_id" value='' required>
							</div>
							<!-- /.input group -->
						</div>
						
						<div class="form-group">
						 <label>Location</label>
							<div class="input-group">
							  <div class="input-group-addon">
								<i class="fa fa-search"></i>
							  </div>
							  <input type="text" class="form-control pull-right" name="edit_location" id="edit_location" value='' required>
							</div>
							<!-- /.input group -->
						</div>
						
						
						<div class="form-group">
						  <label for="drivercode2">Recycle Status</label>
						  <select class="form-control" name="edit_status_recycle" id="edit_status_recycle" required>
							<option selected="selected" value="">Choose Recycle Status</option>
							<option value="not_recyling">Not Recyling</option>
							<option value="recyling">Recyling</option>
						  </select> 
					   </div>
						
				</div>
				<!-- Not Installed End -->
				
				
                <input type="hidden" class="form-control" name="id_tire_update" id="id_tire_update">
              
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
		<h2 id="modal1Title">Delete Tire</h2>
				<form role="form" id="form_delete_data" method="POST" action="<?php echo base_url()."index.php/tire_management/deleteTire" ?>" enctype="multipart/form-data">
				 <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
				 
              <div class="box-body">

				 <div class="form-group">
                     <p>Are you sure want to delete this data? (<span id="reference_delete"></span>)</p>
				</div>
				
				 <div class="form-group">
                      <input type="hidden" name="id_tire_delete" id="id_tire_delete" class="form-control" value="" />
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
		<h2 id="modal1Title">Delete Tire</h2>
				<form role="form" id="form_selected_delete_data" method="POST" action="<?php echo base_url()."index.php/tire_management/deleteTireAll" ?>" enctype="multipart/form-data">
				 <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
				 
              <div class="box-body">

				 <div class="form-group">
                     <p>Are you sure want to delete selected data? </p>
				</div>
				
				 <div class="form-group">
                      <input type="hidden" name="id_tire_delete_all" id="id_tire_delete_all" class="form-control" value="" />
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
  
			$(".delete_data").click(function(){
				var id = $(this).attr('id');
				var serial_number =  $('#data_'+id+' .serial_number').text();
				var product_code =  $('#data_'+id+' .product_code').text();
				var id_tire =  $('#data_'+id+' .id_tire span').text();
				$("#reference_delete").text("Product Code : "+product_code+" Serial Number : "+serial_number)
				$("#id_tire_delete").val(id_tire);
			});
			
			
			
			$(".edit_data").click(function(){
				var id = $(this).attr('id');
				var product_code =  $('#data_'+id+' .product_code').text();
				var id_tire =  $('#data_'+id+' .id_tire span').text();
				var serial_number =  $('#data_'+id+' .serial_number').text();
				var installed_status =  $('#data_'+id+' .installed_status').text();
				var unit_type =  $('#data_'+id+' .unit_type').text();
				var condition_off_tire =  $('#data_'+id+' .condition_off_tire').text();
				var vehicle_id =  $('#data_'+id+' .vehicle_id').text();
				var chasis_id =  $('#data_'+id+' .chasis_id').text();
				var current_odo_meter =  $('#data_'+id+' .current_odo_meter').text();
				var description =  $('#data_'+id+' .description').text();
				var warehouse_id =  $('#data_'+id+' .warehouse_id').text();
				var location_code =  $('#data_'+id+' .location').text();
				var recycle_status =  $('#data_'+id+' .recycle_status').text();
				
				
				$("#id_tire_update").val(id_tire);
				$("#edit_product_code").val(product_code);
				$("#edit_serial_number").val(serial_number);
				$("#edit_installed_status").val(installed_status);
				$("#edit_unit_type").val(unit_type);
				$("#edit_condition_off_tire").val(condition_off_tire);
				$("#edit_vehicle_id").val(vehicle_id);
				$("#edit_chasis_id").val(chasis_id);
				$("#edit_current_odo_meter").val(current_odo_meter);
				$("#edit_description").val(description);
				$("#edit_location").val(location_code);
				$("#edit_warehouse_id").val(warehouse_id);
				if(installed_status=='installed')
				{
					$('#form_edit_data .installed').show();
					$('#form_edit_data .not_installed').hide();
				}
				else if(installed_status=='not_installed')
				{
					$('#form_edit_data .installed').hide();
					$('#form_edit_data .not_installed').show();
				}
				
				if(unit_type=='vehicle')
				{
					$('#form_edit_data .vehicle').show();
					$('#form_edit_data .chasis').hide();
				}
				else if(unit_type=='chasis')
				{
					$('#form_edit_data .vehicle').hide();
					$('#form_edit_data .chasis').show();
				}
				
				$('#edit_unit_type option[value="' + unit_type + '"]').prop('selected',true);
				$('#edit_installed_status option[value="' + installed_status + '"]').prop('selected',true);
				$('#edit_condition_off_tire option[value="' + condition_off_tire + '"]').prop('selected',true);
				
				
			});

			$("#form_add_data").validate({
				rules: {
				current_odo_meter: {
				digits: true
				}
				},
				messages: {
				product_code: {
				required: 'product Code must be filled!'
				},
				serial_number: {
				required: 'Serial Number must be filled!'
				},
				description: {
				required: 'Description must be filled!'
				},
				installed_status: {
				required: 'Installed Status Name must be filled!'
				},
				condition_off_tire: {
				required: 'Condition Off Tire must be filled!'
				},
				unit_type: {
				required: 'Unit Type must be filled!'
				},
				chasis_id: {
				required: 'Chasis ID must be filled!'
				},
				vehicle_id: {
				required: 'Vehicle ID must be filled!'
				},
				warehouse_id: {
				required: 'Warehouse ID must be filled!'
				},
				location: {
				required: 'Location must be filled!'
				}
				,
				status_recycle: {
				required: 'Recycle Status must be filled!'
				}
				
			}
			});
			
			
			
			$("#form_edit_data").validate({
				rules: {
				edit_current_odo_meter: {
				digits: true
				}
				},
				messages: {
				edit_product_code: {
				required: 'product Code must be filled!'
				},
				edit_serial_number: {
				required: 'Serial Number must be filled!'
				},
				edit_description: {
				required: 'Description must be filled!'
				},
				edit_installed_status: {
				required: 'Installed Status Name must be filled!'
				},
				edit_condition_off_tire: {
				required: 'Condition Off Tire must be filled!'
				},
				edit_unit_type: {
				required: 'Unit Type must be filled!'
				},
				edit_chasis_id: {
				required: 'Chasis ID must be filled!'
				},
				edit_vehicle_id: {
				required: 'Vehicle ID must be filled!'
				},
				edit_warehouse_id: {
				required: 'Warehouse ID must be filled!'
				},
				edit_location: {
				required: 'Location must be filled!'
				}
				,
				edit_status_recycle: {
				required: 'Recycle Status must be filled!'
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
$( "#installed_status" ).change(function() {
  
  var status_installed = $(this).val();
  
  if(status_installed=='installed')
  {
	  $('#form_add_data .installed').show();
	  $('#form_add_data .not_installed').hide();
  }
  else if(status_installed=='not_installed')
  {
	  $('#form_add_data .installed').hide();
	  $('#form_add_data .not_installed').show();
  }
  else{
	   $('#form_add_data .installed').hide();
	   $('#form_add_data .not_installed').hide();
  }
  
});


$( "#unit_type" ).change(function() {
  
  var unit_type = $(this).val();
  
  if(unit_type=='chasis')
  {
	  $('#form_add_data .chasis').show();
	  $('#form_add_data .vehicle').hide();
  }
  else if(unit_type=='vehicle')
  {
	  $('#form_add_data .chasis').hide();
	  $('#form_add_data .vehicle').show();
  }
  else{
	   $('#form_add_data .chasis').hide();
	   $('#form_add_data .vehicle').hide();
  }
  
});

</script>


<script>
$( "#edit_installed_status" ).change(function() {
  
  var status_installed = $(this).val();
  
  if(status_installed=='installed')
  {
	  $('#form_edit_data .installed').show();
	  $('#form_edit_data .not_installed').hide();
  }
  else if(status_installed=='not_installed')
  {
	  $('#form_edit_data .installed').hide();
	  $('#form_edit_data .not_installed').show();
  }
  else{
	   $('#form_edit_data .installed').hide();
	   $('#form_edit_data .not_installed').hide();
  }
  
});


$( "#edit_unit_type" ).change(function() {
  
  var unit_type = $(this).val();
  
  if(unit_type=='chasis')
  {
	  $('#form_edit_data .chasis').show();
	  $('#form_edit_data .vehicle').hide();
  }
  else if(unit_type=='vehicle')
  {
	  $('#form_edit_data .chasis').hide();
	  $('#form_edit_data .vehicle').show();
  }
  else{
	   $('#form_edit_data .chasis').hide();
	   $('#form_edit_data .vehicle').hide();
  }
  
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
		$("#id_tire_delete_all").val(ids);
		
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
		//auto complete vehicle
		var term = $("#vehicle_id").val();
        $( "#vehicle_id" ).autocomplete({
         source: "<?php echo BASE_URL(); ?>/index.php/json/jsonMasterUnit?term="+term,  
         minLength:0,
		 select: function( event , ui ) {
			  $( "#vehicle_id" ).val( ui.item.label );
			 
        }    
        })
		.autocomplete( "instance" )._renderItem = function( ul, item ) {
		  return $( "<li style='position:relative; z-index:9999;'>" )
			.append( "<div style='font-size:10px;'>" + item.label +"</div>" )
			.appendTo( ul );
		};
		
		//auto complete Chasis
		var term = $("#chasis_id").val();
        $( "#chasis_id" ).autocomplete({
         source: "<?php echo BASE_URL(); ?>/index.php/json/jsonChasis?term="+term,  
         minLength:0,
		 select: function( event , ui ) {
			  $( "#chasis_id" ).val( ui.item.label );
        }    
        })
		.autocomplete( "instance" )._renderItem = function( ul, item ) {
		  return $( "<li style='position:relative; z-index:9999;'>" )
			.append( "<div style='font-size:10px;'>" + item.label +"</div>" )
			.appendTo( ul );
		};
		
		
		//auto complete Warehouse
		var term = $("#warehouse_id").val();
        $( "#warehouse_id" ).autocomplete({
         source: "<?php echo BASE_URL(); ?>/index.php/json/jsonWarehouse?term="+term,  
         minLength:0,
		 select: function( event , ui ) {
			  $( "#warehouse_id" ).val( ui.item.label );
			  $( "#location" ).val('');
        }    
        })
		.autocomplete( "instance" )._renderItem = function( ul, item ) {
		  return $( "<li style='position:relative; z-index:9999;'>" )
			.append( "<div style='font-size:10px;'>" + item.label +"</div>" )
			.appendTo( ul );
		};
		
		
		
		
		$( "#location" ).keyup(function() {
		  
		  $warehouse_id = $("#warehouse_id").val();
		  if($warehouse_id=='')
		  {
			  $(this).val('');
			  alert('Please Choose Warehouse First!');
			  $('#warehouse_id').focus();
		  }
		  else
		  {
				//auto complete Location
				var term = $("#warehouse_id").val();
				var warehouse_code = $("#warehouse_id").val();
				$( "#location" ).autocomplete({
				 source: "<?php echo BASE_URL(); ?>/index.php/json/jsonLocation?warehouse_code="+warehouse_code,  
				 minLength:0,
				 select: function( event , ui ) {
					  $( "#location" ).val(ui.item.value);
				}    
				})
				.autocomplete( "instance" )._renderItem = function( ul, item ) {
				  return $( "<li style='position:relative; z-index:9999;'>" )
					.append( "<div style='font-size:10px;'>" + item.label + "</div>" )
					.appendTo( ul );
				};
			  
			  
		  }
		  
		});
	
		
		
		
		
		
		
		</script>
		
		
<script>
		//auto complete vehicle Edit
		var term = $("#vehicle_id").val();
        $( "#edit_vehicle_id" ).autocomplete({
         source: "<?php echo BASE_URL(); ?>/index.php/json/jsonMasterUnit",  
         minLength:0,
		 select: function( event , ui ) {
			  $( "#edit_vehicle_id" ).val( ui.item.label );
			 
        }    
        })
		.autocomplete( "instance" )._renderItem = function( ul, item ) {
		  return $( "<li style='position:relative; z-index:9999;'>" )
			.append( "<div style='font-size:10px;'>" + item.label +"</div>" )
			.appendTo( ul );
		};
		
		//auto complete Chasis Edit
		var term = $("#edit_chasis_id").val();
        $( "#edit_chasis_id" ).autocomplete({
         source: "<?php echo BASE_URL(); ?>/index.php/json/jsonChasis",  
         minLength:0,
		 select: function( event , ui ) {
			  $( "#edit_chasis_id" ).val( ui.item.label );
        }    
        })
		.autocomplete( "instance" )._renderItem = function( ul, item ) {
		  return $( "<li style='position:relative; z-index:9999;'>" )
			.append( "<div style='font-size:10px;'>" + item.label +"</div>" )
			.appendTo( ul );
		};
		
		
		//auto complete Warehouse Edit
		var term = $("#edit_warehouse_id").val();
        $( "#edit_warehouse_id" ).autocomplete({
         source: "<?php echo BASE_URL(); ?>/index.php/json/jsonWarehouse",  
         minLength:0,
		 select: function( event , ui ) {
			  $( "#edit_warehouse_id" ).val( ui.item.label );
			  $( "#edit_location" ).val('');
        }    
        })
		.autocomplete( "instance" )._renderItem = function( ul, item ) {
		  return $( "<li style='position:relative; z-index:9999;'>" )
			.append( "<div style='font-size:10px;'>" + item.label +"</div>" )
			.appendTo( ul );
		};
		
		
		
		
		$( "#edit_location" ).keyup(function() {
		  
		  warehouse_id = $("#edit_warehouse_id").val();
		  if(warehouse_id=='')
		  {
			  $(this).val('');
			  alert('Please Choose Warehouse First!');
			  $('#edit_warehouse_id').focus();
		  }
		  else
		  {
				//auto complete Location
				var term = $("#edit_warehouse_id").val();
				var warehouse_code = $("#edit_warehouse_id").val();
				$( "#edit_location" ).autocomplete({
				 source: "<?php echo BASE_URL(); ?>/index.php/json/jsonLocation?warehouse_code="+warehouse_code,  
				 minLength:0,
				 select: function( event , ui ) {
					  $( "#edit_location" ).val(ui.item.value);
				}    
				})
				.autocomplete( "instance" )._renderItem = function( ul, item ) {
				  return $( "<li style='position:relative; z-index:9999;'>" )
					.append( "<div style='font-size:10px;'>" + item.label + "</div>" )
					.appendTo( ul );
				};
			  
			  
		  }
		  
		});
	
		
		
		
		
		
		
		</script>
		
		
