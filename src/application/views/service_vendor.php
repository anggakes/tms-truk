 <!-- HEADER -->
 <section class="content-header">
          <h1>
            Service By Vendor
            <small>List Of Service By Vendor</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="<?php echo BASE_URL(); ?>"><i class="fa fa-dashboard"></i>Home</a></li>
            <li><a href="<?php echo BASE_URL()."service_vendor"; ?>"><i class="fa fa-dashboard"></i>Service By Vendor</a></li>
          </ol>
        </section>
  
  
   <!-- Content -->
   <section class="content">
		
		
  
  
          <div class="box sms box-default color-palette-box">
            <div class="box-header with-border">
              <h3 class="box-title"><i class="fa fa-table"></i> Table Service By Vendor</h3>
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
                             <form action="<?php echo base_url()."index.php/service_vendor" ?>" method="get">
                             <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                                <input type="text" id="search" name="search" placeholder="Search..."  value="<?php echo $search; ?>" />
                                <input type="submit" id="submit"  value="Search"/>
                                <?php if($search!="")
								{?>
                                <a href="<?php echo base_url()."index.php/service_vendor" ?>" id="clear-search">Clear Search</a>
                                <?php } ?>
                             </form>
                </div>
                <div id="wrapper-button" class="clearfix">
					<?php if($data_role[0]['export_service_vendor']=='yes'){ ?>
                	<a href="<?php echo base_url()."index.php/service_vendor/exportServiceVendor?search=".$search; ?>" class="button orange-button">
                    	Export Service Vendor
                    </a>
					<?php } ?>
                    <?php if($data_role[0]['add_service_vendor']=='yes'){ ?>
                    <a id="add-data" class="button green-button">
                    	Add Service Vendor
                    </a>
					<?php } ?>
					<?php if($data_role[0]['delete_service_vendor']=='yes'){ ?>
                    <a id="delete-data" class="button btn-danger deletelogg">
                    	Delete Service Vendor
                    </a>
					<?php } ?>
					<!--<?php if($data_role[0]['import_service_vendor']=='yes'){ ?>
                    <a id="import-data" class="button blue-button">
                    	Import Driver
                    </a>-->
					<?php } ?>
					
                </div>
                </div>
            <div id="wrapper-console" class="clearfix"> 
            <div class="grid_4 height400">                  
           	<table id="myTable04" class="fancyTable table table-bordered table-hover">
                    <thead>
                      <tr>
					  
                        <th><div class="mid"><div class="check-box-div"><input type="checkbox" name="select_all" id="select_all"></div>ID Service Vendor</div></th>
                        
						<th><div class="mid">Service Status</div></th>
						<th><div class="mid">Vehicle ID</div></th>
						<th><div class="mid">Vendor ID</div></th>
						<th><div class="mid">Vendor Name</div></th>
						<th><div class="mid">Service Type</div></th>
						<th><div class="mid">Remark</div></th>
						
						<th><div class="mid">Start Service Date</div></th>
						<th><div class="mid">Start Service Time</div></th>
						<th><div class="mid">Finished Service Date</div></th>
						<th><div class="mid">Finished Service Time</div></th>
						
						<th><div class="mid">Created By</div></th>
						<th><div class="mid">Created Date</div></th>
						<th><div class="mid">Updated By</div></th>
						<th><div class="mid">Updated Date</div></th>
						<?php if($data_role[0]['delete_service_vendor']=='yes' || $data_role[0]['edit_service_vendor']=='yes'){ ?>
						<th><div class="mid">Action</div></th>
						<?php } ?>
                      </tr>
                    </thead>
             		<tbody>
                    <?php foreach($data_service_vendor as $data_service_vendor) {?>
                    <tr id="data_<?php echo $data_service_vendor->id_service_vendor; ?>">
                    	<td class="id_service_vendor">
						<div class="check-box-div">
						<input type="checkbox" name="id_checkbox[]" class="iCheck-helper toedit checkbox_satuan" value="<?php echo $data_service_vendor->id_service_vendor; ?>" />
						</div><span><?php echo $data_service_vendor->id_service_vendor; ?></span></td>
						
						
						<td class="service_status"><?php echo $data_service_vendor->service_status; ?></td>
						<td class="vehicle_id"><?php echo $data_service_vendor->vehicle_id; ?></td>
						<td class="vendor_id"><?php echo $data_service_vendor->vendor_id; ?></td>
						<td class="vendor_name"><?php echo $data_service_vendor->vendor_name; ?></td>
						<td class="service_type"><?php echo $data_service_vendor->service_type; ?></td>
						<td class="remark"><?php echo $data_service_vendor->remark; ?></td>
						
						<td class="start_service_date"><?php echo $data_service_vendor->start_service_date; ?></td>
						<td class="start_service_time"><?php echo $data_service_vendor->start_service_time; ?></td>
						<td class="finished_service_date"><?php echo $data_service_vendor->finished_service_date; ?></td>
						<td class="finished_service_time"><?php echo $data_service_vendor->finished_service_time; ?></td>
						
						
						<td class="created_by"><?php echo $data_service_vendor->created_by; ?></td>
						<td class="created_date"><?php echo $data_service_vendor->created_date; ?></td>
						<td class="updated_by"><?php echo $data_service_vendor->updated_by; ?></td>
						<td class="updated_date"><?php echo $data_service_vendor->updated_date; ?></td>
						
						<?php if($data_role[0]['delete_service_vendor']=='yes' || $data_role[0]['edit_service_vendor']=='yes'){ ?>
						<td><?php if($data_role[0]['delete_service_vendor']=='yes'){ ?><a  class="delete_data link_action" id="<?php echo $data_service_vendor->id_service_vendor; ?>" >Delete</a><?php } ?> | <?php if($data_role[0]['edit_service_vendor']=='yes'){ ?><a  id="<?php echo $data_service_vendor->id_service_vendor; ?>" class="edit_data link_action">Edit</a><?php } ?></td>
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
		<h2 id="modal1Title">Add Service Vendor</h2>
				<form role="form" id="form_add_data" method="POST" action="<?php echo base_url()."index.php/service_vendor/addServiceVendor" ?>" enctype="multipart/form-data">
				 <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
				 
              <div class="box-body">
				 
				
					
					
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
					 <label>Vendor</label>
						<div class="input-group">
						  <div class="input-group-addon">
							<i class="fa fa-search"></i>
						  </div>
						  <input type="text" class="form-control pull-right" name="search_vendor" id="search_vendor" value=''n placeholder='Search Vendor ID'>
						  <input type="text" readonly class="form-control" name="vendor_id" id="vendor_id" placeholder='Vendor ID' required>
						  <input type="text" readonly class="form-control" name="vendor_name" id="vendor_name" placeholder='Vendor Name' required>
						</div>
						<!-- /.input group -->
					</div>
					
					
					
				<div class="form-group">
					  <label for="drivercode2">Service Status</label>
					  <select class="form-control" name="service_status" id="service_status" required>
						<option selected="selected" value="">Choose Service Status</option>
						<option value="On Progress">On Progress</option>
						<option value="Pending">Pending</option>
						<option value="Finished">Finished</option>
					  </select> 
				</div>
				
				<div class="form-group">
					  <label for="drivercode2">Service Type</label>
					  <select class="form-control" name="service_type" id="service_type" required>
						<option selected="selected" value="">Choose Service Type</option>
							 <?php foreach($data_category_service as $data_category_service1) {?>
							 <option value='<?php echo $data_category_service1->description; ?>'><?php echo $data_category_service1->description; ?></option>
							 <?php } ?>
					  </select> 
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
				

				
				
				<div class="form-group">
					  <label for="drivercode2">Remark</label>
					 <textarea class="form-control" name="remark" id="remark" required></textarea>
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
		<h2 id="modal1Title">Edit Service Vendor</h2>
				<form role="form" id="form_edit_data" method="POST" action="<?php echo base_url()."index.php/service_vendor/editServiceVendor" ?>" enctype="multipart/form-data">
				 <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
				 
              <div class="box-body">

			 
					
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
					 <label>Vendor</label>
						<div class="input-group">
						  <div class="input-group-addon">
							<i class="fa fa-search"></i>
						  </div>
						  <input type="text" class="form-control pull-right" name="edit_search_vendor" id="edit_search_vendor" value=''n placeholder='Search Vendor ID'>
						  <input type="text" readonly class="form-control" name="edit_vendor_id" id="edit_vendor_id" placeholder='Vendor ID' required>
						  <input type="text" readonly class="form-control" name="edit_vendor_name" id="edit_vendor_name" placeholder='Vendor Name' required>
						</div>
						<!-- /.input group -->
					</div>
					
					
					
				<div class="form-group">
					  <label for="drivercode2">Service Status</label>
					  <select class="form-control" name="edit_service_status" id="edit_service_status" required>
						<option selected="selected" value="">Choose Service Status</option>
						<option value="On Progress">On Progress</option>
						<option value="Pending">Pending</option>
						<option value="Finished">Finished</option>
					  </select> 
				</div>
				
				<div class="form-group">
					  <label for="drivercode2">Service Type</label>
					  <select class="form-control" name="edit_service_type" id="edit_service_type" required>
						<option selected="selected" value="">Choose Service Type</option>
							<?php foreach($data_category_service as $data_category_service2) {?>
							 <option value='<?php echo $data_category_service2->description; ?>'><?php echo $data_category_service2->description; ?></option>
							 <?php } ?>
					  </select> 
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
				
				<div class="form-group">
					  <label for="drivercode2">Remark</label>
					 <textarea class="form-control" name="edit_remark" id="edit_remark" required></textarea>
					</div>
					
                <input type="hidden" class="form-control" name="id_service_vendor_update" id="id_service_vendor_update">
              
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
		<h2 id="modal1Title">Delete Service Vendor</h2>
				<form role="form" id="form_delete_data" method="POST" action="<?php echo base_url()."index.php/service_vendor/deleteServiceVendor" ?>" enctype="multipart/form-data">
				 <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
				 
              <div class="box-body">

				 <div class="form-group">
                     <p>Are you sure want to delete this data? (<span id="reference_delete"></span>)</p>
				</div>
				
				 <div class="form-group">
                      <input type="hidden" name="id_service_vendor_delete" id="id_service_vendor_delete" class="form-control" value="" />
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
		<h2 id="modal1Title">Delete Vendor</h2>
				<form role="form" id="form_selected_delete_data" method="POST" action="<?php echo base_url()."index.php/service_vendor/deleteServiceVendorAll" ?>" enctype="multipart/form-data">
				 <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
				 
              <div class="box-body">

				 <div class="form-group">
                     <p>Are you sure want to delete selected data? </p>
				</div>
				
				 <div class="form-group">
                      <input type="hidden" name="id_service_vendor_delete_all" id="id_service_vendor_delete_all" class="form-control" value="" />
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
				var service_date =  $('#data_'+id+' .service_date').text();
				var id_service_vendor =  $('#data_'+id+' .id_service_vendor span').text();
				$("#reference_delete").text("Id Service Vendor:"+id_service_vendor)
				$("#id_service_vendor_delete").val(id_service_vendor);
			});
			
			
			 //Timepicker
			 $(".timepicker").timepicker({
			  showInputs: false
			});
			
			$(".edit_data").click(function(){
				var id = $(this).attr('id');
				var id_service_vendor =  $('#data_'+id+' .id_service_vendor span').text();
				var service_date =  $('#data_'+id+' .service_date').text();
				var vehicle_id =  $('#data_'+id+' .vehicle_id').text();
				var vendor_id =  $('#data_'+id+' .vendor_id').text();
				var vendor_name =  $('#data_'+id+' .vendor_name').text();
				var service_status =  $('#data_'+id+' .service_status').text();
				var service_type =  $('#data_'+id+' .service_type').text();
				var service_date_finished =  $('#data_'+id+' .service_date_finished').text();
				var remark =  $('#data_'+id+' .remark').text();
				
				$("#edit_service_date").val(service_date);
				$("#edit_vehicle_id").val(vehicle_id);
				$("#edit_vendor_id").val(vendor_id);
				$("#edit_vendor_name").val(vendor_name);
				$("#edit_service_status").val(service_status);
				$("#edit_service_type").val(service_type);
				$("#edit_service_date_finished").val(service_date_finished);
				$("#edit_remark").val(remark);
				$("#id_service_vendor_update").val(id_service_vendor);
				
				
			});

			$("#form_add_data").validate({
				
				messages: {
				service_date: {
				required: 'Service Date must be filled!'
				},
				vehicle_id: {
				required: 'Vehicle ID must be filled!'
				},
				vendor_id: {
				required: 'vendor ID be filled!'
				},
				vendor_name: {
				required: 'Vendor Name must be filled!'
				},
				service_status: {
				required: 'Service Status must be filled!'
				},
				service_type: {
				required: 'Service Type must be filled!'
				},
				service_date_finished: {
				required: 'Service Date must be filled!'
				},
				remark: {
				required: 'Remark must be filled!'
				}
			}
			});
			
			
			
			$("#form_edit_data").validate({
				messages: {
				edit_service_date: {
				required: 'Service Date must be filled!'
				},
				edit_vehicle_id: {
				required: 'Vehicle ID must be filled!'
				},
				edit_vendor_id: {
				required: 'vendor ID be filled!'
				},
				edit_vendor_name: {
				required: 'Vendor Name must be filled!'
				},
				edit_service_status: {
				required: 'Service Status must be filled!'
				},
				edit_service_type: {
				required: 'Service Type must be filled!'
				},
				edit_service_date_finished: {
				required: 'Service Date must be filled!'
				},
				edit_remark: {
				required: 'Remark must be filled!'
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
$('.datepicker').datepicker({
			  autoclose: true,
			  Format: 'dd-mm-yyyy'
			});
			
$( "#service_status" ).change(function() {
  
  var service_status = $(this).val();
  
  if(service_status=='Finished')
  {
	  $('.service_date_finished_add').show();
  }
  else{
	   $('.service_date_finished_add').hide();
	   $('#service_date_finished').val('');
  }
});


$( "#edit_service_status" ).change(function() {
  
  var service_status = $(this).val();
  
  if(service_status=='Finished')
  {
	  $('.edit_service_date_finished_add').show();
  }
  else{
	   $('.edit_service_date_finished_add').hide();
	   $('#edit_service_date_finished').val('');
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
		$("#id_service_vendor_delete_all").val(ids);
		
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
		
		
		//auto complete Vendor
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
		
		
		//auto complete Vendor
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