 <!-- HEADER -->
 <section class="content-header">
          <h1>
            Master Unit
            <small>List Of Master Unit</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="<?php echo BASE_URL(); ?>"><i class="fa fa-dashboard"></i>Home</a></li>
            <li><a href="<?php echo BASE_URL()."master_unit"; ?>"><i class="fa fa-dashboard"></i>Master Unit</a></li>
          </ol>
        </section>
  
  
   <!-- Content -->
   <section class="content">
		
		
  
  
          <div class="box sms box-default color-palette-box">
            <div class="box-header with-border">
              <h3 class="box-title"><i class="fa fa-table"></i> Table Master Unit</h3>
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
                             <form action="<?php echo base_url()."index.php/master_unit" ?>" method="get">
                             <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                                <input type="text" id="search" name="search" placeholder="Search..."  value="<?php echo $search; ?>" />
                                <input type="submit" id="submit"  value="Search"/>
                                <?php if($search!="")
								{?>
                                <a href="<?php echo base_url()."index.php/master_unit" ?>" id="clear-search">Clear Search</a>
                                <?php } ?>
                             </form>
                </div>
                <div id="wrapper-button" class="clearfix">
					<?php if($data_role[0]['export_master_unit']=='yes'){ ?>
                	<a href="<?php echo base_url()."index.php/master_unit/exportMasterUnit?search=".$search; ?>" class="button orange-button">
                    	Export Master Unit
                    </a>
					<?php } ?>
                    <?php if($data_role[0]['add_master_unit']=='yes'){ ?>
                    <a id="add-data" class="button green-button">
                    	Add Master Unit
                    </a>
					<?php } ?>
					<?php if($data_role[0]['delete_master_unit']=='yes'){ ?>
                    <a id="delete-data" class="button btn-danger deletelogg">
                    	Delete Master Unit
                    </a>
					<?php } ?>
					<?php if($data_role[0]['import_master_unit']=='yes'){ ?>
                    <a id="import-data" class="button blue-button">
                    	Import Master Unit
                    </a>
					<?php } ?>
					
                </div>
                </div>
            <div id="wrapper-console" class="clearfix"> 
            <div class="grid_4 height400">                  
           	<table id="myTable04" class="fancyTable table-bordered table-hover">
                    <thead>
                      <tr>
					  
                        <th><div class='long'><div class="check-box-div"><input type="checkbox" name="select_all" id="select_all"></div>Vehicle ID</div></th>
                        <th><div class='long'>Vehicle Type</div></th>
                        <th><div class="long">Manufacture Date</div></th>
						<th><div class="long">Purchase Date</div></th>
						<th><div class='long'>Fuel type</div></th>
						<th><div class='long'>Body type</div></th>
						<th><div class="long">Purchase From</div></th>
						<th><div class='long'>Merk</div></th>
						<th><div class="long">Purchase Price</div></th>
						<th><div class='long'>Model</div></th>
						<th><div class="long">Assembly Type</div></th>
						<th><div class='long'>Current ODO</div></th>
						<th><div class='long'>Kode Lambung</div></th>
						<th><div class='long'>Year</div></th>
						<th><div class="long">Fuel Ratio Litre</div></th>
						<th><div class="long">Tire Qty</div></th>
						<th><div class="long">Spare Tire</div></th>
						
						
						<?php if($data_role[0]['delete_master_unit']=='yes' || $data_role[0]['edit_master_unit']=='yes'){ ?>
						<th><div class="long">Action</div></th>
						<?php } ?>
                      </tr>
                    </thead>
             		<tbody>
                    <?php foreach($data_master_unit as $data_master_unit) {?>
                    <tr id="data_<?php echo $data_master_unit->id_master_unit; ?>">
                    	<td class="id_master_unit">
						<div class="check-box-div">
						<input type="checkbox" name="id_checkbox[]" class="iCheck-helper toedit checkbox_satuan" value="<?php echo $data_master_unit->id_master_unit; ?>" />
						</div><span class='id_master_unit' style='display:none;'><?php echo $data_master_unit->id_master_unit; ?></span><span class='vehicle_id'><?php echo $data_master_unit->vehicle_id; ?></span></td>
                        <td class="vehicle_type"><?php echo $data_master_unit->vehicle_type; ?><span class='id_vehicle_type' style='display:none;'><?php echo $data_master_unit->id_vehicle_type; ?></span></td>
                        <td class="manufacture_date"><?php convert_date($data_master_unit->manufacture_date); ?></td>
						<td class="purchase_date"><?php convert_date($data_master_unit->purchase_date); ?></td>
                        <td class="fuel_type"><?php echo $data_master_unit->fuel_type; ?></td>
						<td class="body_type"><?php echo $data_master_unit->body_type; ?></td>
                        <td class="purchase_from"><?php echo $data_master_unit->purchase_from; ?></td>
						<td class="merk"><?php echo $data_master_unit->merk; ?></td>
                        <td class="purchase_price"><?php echo $data_master_unit->purchase_price; ?></td>
						<td class="model"><?php echo $data_master_unit->model; ?></td>
						<td class="assembly_type"><?php echo $data_master_unit->assembly_type; ?></td>
                        <td class="current_odo"><?php echo $data_master_unit->current_odo; ?></td>
						<td class="kode_lambung"><?php echo $data_master_unit->kode_lambung; ?></td>
						<td class="year"><?php echo $data_master_unit->year; ?></td>
                        <td class="fuel_ratio_litre"><?php echo $data_master_unit->fuel_ratio_litre; ?></td>
						<td class="tire_qty"><?php echo $data_master_unit->tire_qty; ?></td>
						<td class="spare_tire"><?php echo $data_master_unit->spare_tire; ?></td>
						
						
						<?php if($data_role[0]['delete_master_unit']=='yes' || $data_role[0]['edit_master_unit']=='yes'){ ?>
						<td><?php if($data_role[0]['delete_master_unit']=='yes'){ ?><a  class="delete_data link_action" id="<?php echo $data_master_unit->id_master_unit; ?>" >Delete</a><?php } ?> | <?php if($data_role[0]['edit_master_unit']=='yes'){ ?><a  id="<?php echo $data_master_unit->id_master_unit; ?>" class="edit_data link_action">Edit</a><?php } ?></td>
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
		<h2 id="modal1Title">Add Master Unit</h2>
				<form role="form" id="form_add_data" method="POST" action="<?php echo base_url()."index.php/master_unit/addMasterUnit" ?>" enctype="multipart/form-data">
				 <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
				 
              <div class="box-body">

				 <div class="form-group">
                  <label for="drivercode2">Vehicle ID</label>
                  <input type="text" class="form-control" name="vehicle_id" id="vehicle_id" required>
                 </div>
				 
				 	<div class="form-group">
                  <label for="drivercode2">Vehicle Type</label>
				  <select class="form-control" name="vehicle_type" id="vehicle_type" required>
					<option selected="selected" value="">Choose vehicle Type</option>
					<?php foreach($data_vehicle_type as $data_vehicle_type1) {?>
					<option value="<?php echo $data_vehicle_type1->id_vehicle_type; ?>"><?php echo $data_vehicle_type1->vehicle_type; ?></option>
					<?php } ?>
				  </select> 
                </div>
				 
				 
				 <div class="form-group">
					  <label for="drivercode2">Manufacture Date</label>
						  <div class="input-group date">
						  <div class="input-group-addon">
							<i class="fa fa-calendar"></i>
						  </div>
						  <input type="text" name="manufacture_date" class="form-control pull-right datepicker" id="manufacture_date" required>
						</div>
					</div>
					
					
					 <div class="form-group">
					  <label for="drivercode2">Purchase Date</label>
						  <div class="input-group date">
						  <div class="input-group-addon">
							<i class="fa fa-calendar"></i>
						  </div>
						  <input type="text" name="purchase_date" class="form-control pull-right datepicker" id="purchase_date" required>
						</div>
					</div>
					
					<div class="form-group">
					<label for="drivercode2">Fuel Type</label>
					<select class="form-control" name="fuel_type" id="fuel_type" required>
					<option selected="selected" value="">Choose Fuel Type</option>
							<?php foreach($data_category_fuel as $data_category_fuel1) {?>
							<option value='<?php echo $data_category_fuel1->description; ?>'><?php echo $data_category_fuel1->description; ?></option>
							<?php } ?>
				    </select> 
					</div>
				 
				 
				 <div class="form-group">
                  <label for="drivercode2">Body Type</label>
				    <select class="form-control" name="body_type" id="body_type" required>
					<option selected="selected" value="">Choose Body Type</option>
							<?php foreach($data_category_body as $data_category_body1) {?>
							<option value='<?php echo $data_category_body1->description; ?>'><?php echo $data_category_body1->description; ?></option>
							<?php } ?>
				    </select> 
                 </div>
				 
				  <div class="form-group">
                  <label for="drivercode2">Purchase From</label>
                  <input type="text" class="form-control" name="purchase_from" id="purchase_from" required>
                 </div>
				 
				 
				 <div class="form-group">
                  <label for="drivercode2">Merk</label>
                  <input type="text" class="form-control" name="merk" id="merk" required>
                 </div>
				 
				 <div class="form-group">
                  <label for="drivercode2">Model</label>
                  <input type="text" class="form-control" name="model" id="model" required>
                 </div>
				 
				 <div class="form-group">
                  <label for="drivercode2">Purchase Price</label>
                  <input type="text" class="form-control" name="purchase_price" id="purchase_price" required>
                 </div>
				 
				 <div class="form-group">
                  <label for="drivercode2">Assembly Type</label>
					<select class="form-control" name="assembly_type" id="assembly_type" required>
					<option selected="selected" value="">Choose Assembly Type</option>
							<?php foreach($data_category_assembly as $data_category_assembly1) {?>
							<option value='<?php echo $data_category_assembly1->description; ?>'><?php echo $data_category_assembly1->description; ?></option>
							<?php } ?>
				    </select> 
                 </div>
				 
				  <div class="form-group">
                  <label for="drivercode2">Current ODO</label>
                  <input type="text" class="form-control" name="current_odo" id="current_odo" required>
                 </div>
				 
				 
				 <div class="form-group">
                  <label for="drivercode2">Kode Lambung</label>
                  <input type="text" class="form-control" name="kode_lambung" id="kode_lambung" required>
                 </div>
				 
				
				 <div class="form-group">
					  <label for="drivercode2">Year</label>
						  <div class="input-group date">
						  <div class="input-group-addon">
							<i class="fa fa-calendar"></i>
						  </div>
						  <input type="text" name="year" id="year" class="form-control pull-right datepicker_year" value='' required>
						</div>
					</div>
				 
				 <div class="form-group">
                  <label for="drivercode2">Fuel ratio Litre</label>
                  <input type="text" class="form-control" name="fuel_ratio_litre" id="fuel_ratio_litre" required>
                 </div>
				 
				  <div class="form-group">
                  <label for="drivercode2">Tire QTY</label>
                  <input type="text" class="form-control" name="tire_qty" id="tire_qty" required>
                 </div>
				 
				 
				  <div class="form-group">
                  <label for="drivercode2">Spare Tire</label>
                  <input type="text" class="form-control" name="spare_tire" id="spare_tire" required>
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
		<h2 id="modal1Title">Edit Master Unit</h2>
				<form role="form" id="form_edit_data" method="POST" action="<?php echo base_url()."index.php/master_unit/editMasterUnit" ?>" enctype="multipart/form-data">
				 <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
				 
              <div class="box-body">

				   <div class="form-group">
                  <label for="drivercode2">Vehicle ID</label>
                  <input type="text" class="form-control" name="edit_vehicle_id" id="edit_vehicle_id" required>
                 </div>
				 
				 	<div class="form-group">
                  <label for="drivercode2">Vehicle Type</label>
				  <select class="form-control" name="edit_vehicle_type" id="edit_vehicle_type" required>
					<option selected="selected" value="">Choose Vehicle Type</option>
					<?php foreach($data_vehicle_type as $data_vehicle_type2) {?>
					<option value="<?php echo $data_vehicle_type2->id_vehicle_type; ?>"><?php echo $data_vehicle_type2->vehicle_type; ?></option>
					<?php } ?>
				  </select> 
                </div>
				 
				 
				 <div class="form-group">
					  <label for="drivercode2">Manufacture Date</label>
						  <div class="input-group date">
						  <div class="input-group-addon">
							<i class="fa fa-calendar"></i>
						  </div>
						  <input type="text" name="edit_manufacture_date" class="form-control pull-right datepicker" id="edit_manufacture_date" required>
						</div>
					</div>
					
					
					 <div class="form-group">
					  <label for="drivercode2">Purchase Date</label>
						  <div class="input-group date">
						  <div class="input-group-addon">
							<i class="fa fa-calendar"></i>
						  </div>
						  <input type="text" name="edit_purchase_date" class="form-control pull-right datepicker" id="edit_purchase_date" required>
						</div>
					</div>
					
					<div class="form-group">
					<label for="drivercode2">Fuel Type</label>
					<select class="form-control" name="edit_fuel_type" id="edit_fuel_type" required>
					<option selected="selected" value="">Choose Fuel Type</option>
							<?php foreach($data_category_fuel as $data_category_fuel2) {?>
							<option value='<?php echo $data_category_fuel2->description; ?>'><?php echo $data_category_fuel2->description; ?></option>
							<?php } ?>
					</select> 
					</div>
				 
				 
				 <div class="form-group">
                  <label for="drivercode2">Body Type</label>
				    <select class="form-control" name="edit_body_type" id="edit_body_type" required>
					<option selected="selected" value="">Choose Body Type</option>
							<?php foreach($data_category_body as $data_category_body2) {?>
							<option value='<?php echo $data_category_body2->description; ?>'><?php echo $data_category_body2->description; ?></option>
							<?php } ?>
				    </select> 
                 </div>
				 
				  <div class="form-group">
                  <label for="drivercode2">Purchase From</label>
                  <input type="text" class="form-control" name="edit_purchase_from" id="edit_purchase_from" required>
                 </div>
				 
				 
				 <div class="form-group">
                  <label for="drivercode2">Merk</label>
                  <input type="text" class="form-control" name="edit_merk" id="edit_merk" required>
                 </div>
				 
				 <div class="form-group">
                  <label for="drivercode2">Model</label>
                  <input type="text" class="form-control" name="edit_model" id="edit_model" required>
                 </div>
				 
				 <div class="form-group">
                  <label for="drivercode2">Purchase Price</label>
                  <input type="text" class="form-control" name="edit_purchase_price" id="edit_purchase_price" required>
                 </div>
				 
				 <div class="form-group">
                  <label for="drivercode2">Assembly Type</label>
					<select class="form-control" name="edit_assembly_type" id="edit_assembly_type" required>
					<option selected="selected" value="">Choose Assembly Type</option>
							<?php foreach($data_category_assembly as $data_category_assembly2) {?>
							<option value='<?php echo $data_category_assembly2->description; ?>'><?php echo $data_category_assembly2->description; ?></option>
							<?php } ?>
				    </select> 
                 </div>
				 
				  <div class="form-group">
                  <label for="drivercode2">Current ODO</label>
                  <input type="text" class="form-control" name="edit_current_odo" id="edit_current_odo" required>
                 </div>
				 
				<div class="form-group">
                  <label for="drivercode2">Kode Lambung</label>
                  <input type="text" class="form-control" name="edit_kode_lambung" id="edit_kode_lambung" required>
                 </div>
				 
				 <div class="form-group">
					  <label for="drivercode2">Year</label>
						  <div class="input-group date">
						  <div class="input-group-addon">
							<i class="fa fa-calendar"></i>
						  </div>
						  <input type="text" name="edit_year" id="edit_year" class="form-control pull-right datepicker_year" value='' required>
						</div>
					</div>
				 
				 <div class="form-group">
                  <label for="drivercode2">Fuel ratio Litre</label>
                  <input type="text" class="form-control" name="edit_fuel_ratio_litre" id="edit_fuel_ratio_litre" required>
                 </div>
				
				
				<div class="form-group">
                  <label for="drivercode2">Tire QTY</label>
                  <input type="text" class="form-control" name="edit_tire_qty" id="edit_tire_qty" required>
                 </div>
				 
				 
				  <div class="form-group">
                  <label for="drivercode2">Spare Tire</label>
                  <input type="text" class="form-control" name="edit_spare_tire" id="edit_spare_tire" required>
                 </div>
				 
				 
                <input type="hidden" class="form-control" name="id_master_unit_update" id="id_master_unit_update">
              
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
		<h2 id="modal1Title">Import Master Unit</h2>
				<form role="form" id="form_import_data" method="POST" action="<?php echo base_url()."index.php/master_unit/importMasterUnit" ?>" enctype="multipart/form-data">
				 <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
				 
              <div class="box-body">

				 <div class="form-group">
                      <label for="exampleInputEmail1">Choose File</label>
                      <input type="file" name="import_file" id="import_file" class="form-control" value="" />
				</div>
				
				 <div class="form-group">
                    <p><a target="_blank" href="<?php echo base_url('/files/example-files/import-master-unit.xlsx')?>">Download sample file import Master Unit</a></p>
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
		<h2 id="modal1Title">Delete Master Unit</h2>
				<form role="form" id="form_delete_data" method="POST" action="<?php echo base_url()."index.php/master_unit/deleteMasterUnit" ?>" enctype="multipart/form-data">
				 <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
				 
              <div class="box-body">

				 <div class="form-group">
                     <p>Are you sure want to delete this data? (<span id="reference_delete"></span>)</p>
				</div>
				
				 <div class="form-group">
                      <input type="hidden" name="id_master_unit_delete" id="id_master_unit_delete" class="form-control" value="" />
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
		<h2 id="modal1Title">Delete Master Unit</h2>
				<form role="form" id="form_selected_delete_data" method="POST" action="<?php echo base_url()."index.php/master_unit/deleteMasterUnitAll" ?>" enctype="multipart/form-data">
				 <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
				 
              <div class="box-body">

				 <div class="form-group">
                     <p>Are you sure want to delete selected data? </p>
				</div>
				
				 <div class="form-group">
                      <input type="hidden" name="id_master_unit_delete_all" id="id_master_unit_delete_all" class="form-control" value="" />
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
			
			$('.datepicker_year').datepicker({
			  autoclose: true,
			    format: " yyyy", // Notice the Extra space at the beginning
				viewMode: "years", 
				minViewMode: "years"
			});
			
			
			$(".delete_data").click(function(){
				var id = $(this).attr('id');
				var vehicle_id =  $('#data_'+id+' span.vehicle_id ').text();
				var id_master_unit =  $('#data_'+id+' span.vehicle_id ').text();
				$("#reference_delete").text("Vehicle ID:"+vehicle_id)
				$("#id_master_unit_delete").val(id_master_unit);
			});
			
			
			
			$(".edit_data").click(function(){
				var id = $(this).attr('id');
				var id_master_unit =  $('#data_'+id+' span.id_master_unit').text();
				var vehicle_id =  $('#data_'+id+' span.vehicle_id').text();
				var id_vehicle_type =  $('#data_'+id+' span.id_vehicle_type').text();
				var manufacture_date =  $('#data_'+id+' .manufacture_date').text();
				var purchase_date =  $('#data_'+id+' .purchase_date').text();
				var fuel_type =  $('#data_'+id+' .fuel_type').text();
				var body_type =  $('#data_'+id+' .body_type').text();
				var purchase_from =  $('#data_'+id+' .purchase_from').text();
				var merk =  $('#data_'+id+' .merk').text();
				var purchase_price =  $('#data_'+id+' .purchase_price').text();
				var model =  $('#data_'+id+' .model').text();
				var assembly_type =  $('#data_'+id+' .assembly_type').text();
				var current_odo =  $('#data_'+id+' .current_odo').text();
				var year =  $('#data_'+id+' .year').text();
				var fuel_ratio_litre =  $('#data_'+id+' .fuel_ratio_litre').text();
				var tire_qty =  $('#data_'+id+' .tire_qty').text();
				var spare_tire =  $('#data_'+id+' .spare_tire').text();
				var kode_lambung =  $('#data_'+id+' .kode_lambung').text();
				
				
				
				$("#id_master_unit_update").val(id_master_unit);
				$("#edit_vehicle_id").val(vehicle_id);
				$('#edit_vehicle_type option[value="' + id_vehicle_type + '"]').prop('selected',true);
				$("#edit_manufacture_date").val(manufacture_date);
				$("#edit_purchase_date").val(purchase_date);
				$('#edit_fuel_type option[value="' + fuel_type + '"]').prop('selected',true);
				$('#edit_body_type option[value="' + body_type + '"]').prop('selected',true);
				$("#edit_purchase_from").val(purchase_from);
				$("#edit_merk").val(merk);
				$("#edit_model").val(model);
				$("#edit_purchase_price").val(purchase_price);
				$('#edit_assembly_type option[value="' + assembly_type + '"]').prop('selected',true);
				$("#edit_current_odo").val(current_odo);
				$("#edit_year").val(year);
				$("#edit_fuel_ratio_litre").val(fuel_ratio_litre);
				$("#edit_tire_qty").val(tire_qty);
				$("#edit_spare_tire").val(spare_tire);
				$("#edit_kode_lambung").val(kode_lambung);
				
				
			});

			$("#form_add_data").validate({
				rules: {
					fuel_ratio_litre: {
						 pattern: /^(\d+|\d+,\d{1,2})$/
					},
					current_odo: {
						 digits:true
					},
					purchase_price: {
						 digits:true
					},
					tire_qty: {
						 digits:true
					},
					spare_tire: {
						 digits:true
					}
				},
				messages: {
				vehicle_id: {
				required: 'Vehicle ID must be filled!'
				},
				model: {
				required: 'Model must be filled!'
				},
				vehicle_type: {
				required: 'Vehicle Type must be filled!'
				},
				manufacture_date: {
				required: 'Manufacture Date must be filled!'
				},
				purchase_date: {
				required: 'Purchase Date must be filled!'
				},
				fuel_type: {
				required: 'Fuel Type must be filled!'
				},
				body_type: {
				required: 'Body Type must be filled!'
				},
				purchase_from: {
				required: 'Purchase From must be filled!'
				},
				merk: {
				required: 'Merk must be filled!'
				},
				purchase_price: {
				required: 'Purchase Price must be filled!'
				},
				assembly_type: {
				required: 'Assembly Type must be filled!'
				},
				current_odo: {
				required: 'Current ODO must be filled!'
				},
				year: {
				required: 'Year must be filled!'
				},
				fuel_ratio_litre: {
				required: 'Fuel Ratio Litre must be filled!',
				pattern : 'Invalid Format, (Example : 2,3 or 2)'
				},
				tire_qty: {
				required: 'Tire Qty must be filled!',
				},
				spare_tire: {
				required: 'Spare Tire must be filled!',
				},
				kode_lambung: {
				required: 'Kode Lambung must be filled!',
				}
			}
			});
			
			
			
			$("#form_edit_data").validate({
			rules: {
					edit_fuel_ratio_litre: {
						 pattern: /^(\d+|\d+,\d{1,2})$/
					},
					edit_current_odo: {
						 digits:true
					},
					edit_purchase_price: {
						 digits:true
					},
					edit_tire_qty: {
						digits:true
					},
					edit_spare_tire: {
						 digits:true
					}
				},
				messages: {
				edit_vehicle_id: {
				required: 'Vehicle ID must be filled!'
				},
				edit_model: {
				required: 'Model must be filled!'
				},
				edit_vehicle_type: {
				required: 'Vehicle Type must be filled!'
				},
				edit_manufacture_date: {
				required: 'Manufacture Date must be filled!'
				},
				edit_purchase_date: {
				required: 'Purchase Date must be filled!'
				},
				edit_fuel_type: {
				required: 'Fuel Type must be filled!'
				},
				edit_body_type: {
				required: 'Body Type must be filled!'
				},
				edit_purchase_from: {
				required: 'Purchase From must be filled!'
				},
				edit_merk: {
				required: 'Merk must be filled!'
				},
				edit_purchase_price: {
				required: 'Purchase Price must be filled!'
				},
				edit_assembly_type: {
				required: 'Assembly Type must be filled!'
				},
				edit_current_odo: {
				required: 'Current ODO must be filled!'
				},
				edit_year: {
				required: 'Year must be filled!'
				},
				edit_fuel_ratio_litre: {
				required: 'Fuel Ratio Litre must be filled!',
				pattern : 'Invalid Format, (Example : 2,3 or 2)'
				},
				edit_tire_qty: {
				required: 'Tire Qty must be filled!',
				},
				edit_spare_tire: {
				required: 'Spare Tire must be filled!',
				},
				edit_kode_lambung: {
				required: 'Kode Lambung must be filled!',
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
		$("#id_master_unit_delete_all").val(ids);
		
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
