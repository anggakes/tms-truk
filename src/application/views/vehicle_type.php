 <!-- HEADER -->
 <section class="content-header">
          <h1>
            Vehicle Type
            <small>List Of vehicle Type</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="<?php echo BASE_URL(); ?>"><i class="fa fa-dashboard"></i>Home</a></li>
            <li><a href="<?php echo BASE_URL()."vehicle_type"; ?>"><i class="fa fa-dashboard"></i>vehicle Type</a></li>
          </ol>
        </section>
  
  
   <!-- Content -->
   <section class="content">
		
		
  
  
          <div class="box sms box-default color-palette-box">
            <div class="box-header with-border">
              <h3 class="box-title"><i class="fa fa-table"></i> Table Vehicle Type</h3>
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
                             <form action="<?php echo base_url()."index.php/vehicle_type" ?>" method="get">
                             <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                                <input type="text" id="search" name="search" placeholder="Search..."  value="<?php echo $search; ?>" />
                                <input type="submit" id="submit"  value="Search"/>
                                <?php if($search!="")
								{?>
                                <a href="<?php echo base_url()."index.php/vehicle_type" ?>" id="clear-search">Clear Search</a>
                                <?php } ?>
                             </form>
                </div>
                <div id="wrapper-button" class="clearfix">
					<?php if($data_role[0]['export_vehicle_type']=='yes'){ ?>
                	<a href="<?php echo base_url()."index.php/vehicle_type/exportVehicleType?search=".$search; ?>" class="button orange-button">
                    	Export Vehicle Type
                    </a>
					<?php } ?>
                    <?php if($data_role[0]['add_vehicle_type']=='yes'){ ?>
                    <a id="add-data" class="button green-button">
                    	Add Vehicle Type
                    </a>
					<?php } ?>
					<?php if($data_role[0]['delete_vehicle_type']=='yes'){ ?>
                    <a id="delete-data" class="button btn-danger deletelogg">
                    	Delete Vehicle Type
                    </a>
					<?php } ?>
					<?php if($data_role[0]['import_vehicle_type']=='yes'){ ?>
                    <a id="import-data" class="button blue-button">
                    	Import Vehicle Type
                    </a>
					<?php } ?>
					
                </div>
                </div>
            <div id="wrapper-console" class="clearfix"> 
            <div class="grid_4 height400">                  
           <table id="myTable02" class="fancyTable table table-bordered table-hover">
                    <thead>
                      <tr>
					  
                        <th><div class="mid"><div class="check-box-div"><input type="checkbox" name="select_all" id="select_all"></div>ID Vehicle Type</div></th>
                        <th><div class="mid">Vehicle Type</div></th>
                        <th><div class="mid">Description</div></th>
						<th><div class="mid">Volume Cap (CBM)</div></th>
						<th><div class="mid">Weight Cap (Kg)</div></th>
						<?php if($data_role[0]['delete_vehicle_type']=='yes' || $data_role[0]['edit_vehicle_type']=='yes'){ ?>
						<th><div class="mid">Action</div></th>
						<?php } ?>
                      </tr>
                    </thead>
             		<tbody>
                    <?php foreach($data_vehicle_type as $data_vehicle_type) {?>
                    <tr id="data_<?php echo $data_vehicle_type->id_vehicle_type; ?>">
                    	<td class="id_vehicle_type">
						<div style="width:200px;">
						<div class="check-box-div">
						<input type="checkbox" name="id_checkbox[]" class="iCheck-helper toedit checkbox_satuan" value="<?php echo $data_vehicle_type->id_vehicle_type; ?>" />
						</div><span><?php echo $data_vehicle_type->id_vehicle_type; ?></span></div></td>
						
						
                        <td class="vehicle_type"><?php echo $data_vehicle_type->vehicle_type; ?></td>
                        <td class="description"><?php echo $data_vehicle_type->description; ?></td>
						<td class="volume_cap"><?php echo $data_vehicle_type->volume_cap; ?></td>
                        <td class="weight_cap"><?php echo $data_vehicle_type->weight_cap; ?></td>
						
						
						<?php if($data_role[0]['delete_vehicle_type']=='yes' || $data_role[0]['edit_vehicle_type']=='yes'){ ?>
						<td><?php if($data_role[0]['delete_vehicle_type']=='yes'){ ?><a  class="delete_data link_action" id="<?php echo $data_vehicle_type->id_vehicle_type; ?>" >Delete</a><?php } ?> | <?php if($data_role[0]['edit_vehicle_type']=='yes'){ ?><a  id="<?php echo $data_vehicle_type->id_vehicle_type; ?>" class="edit_data link_action">Edit</a><?php } ?></td>
						<?php } ?>
					</tr>
                    <?php }?>
                    </tbody>       
             </table>
             </div>
             
            		  
                    
            
           </div>
            </div>
            
            </div>
			
					 <div class="pagination page">
						<?php  echo $this->pagination->create_links(); ?>
					 </div>
					 
					 
      </section>

	  
	 <div class="remodal" data-remodal-id="modal_add" role="dialog" aria-labelledby="modal1Titl aria-describedby="modal1Desc">
	  <button data-remodal-action="close" class="remodal-close" aria-label="Close"></button>
	  <div>
		<h2 id="modal1Title">Add vehicle Type</h2>
				<form role="form" id="form_add_data" method="POST" action="<?php echo base_url()."index.php/vehicle_type/addVehicleType" ?>" enctype="multipart/form-data">
				 <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
				 
              <div class="box-body">

				 <div class="form-group">
                  <label for="drivercode2">Vehicle Type</label>
                 <input type="text" class="form-control" name="vehicle_type" id="vehicle_type" required>
                </div>
				
				<div class="form-group">
                  <label for="drivercode">Description</label>
                  <input type="text" class="form-control" name="description" id="description" required>
                </div>
				
                <div class="form-group">
                  <label for="exampleInputPassword1">Volume Cap (CBM)</label>
                  <input type="text" class="form-control" name="volume_cap" id="volume_cap" required>
                </div>
				
				<div class="form-group">
                  <label for="exampleInputPassword1">Weight Cap (KG)</label>
                  <input type="text" class="form-control" name="weight_cap" id="weight_cap" required>
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
		<h2 id="modal1Title">Edit Vehicle Type</h2>
				<form role="form" id="form_edit_data" method="POST" action="<?php echo base_url()."index.php/vehicle_type/editVehicleType" ?>" enctype="multipart/form-data">
				 <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
				 
              <div class="box-body">

				  <div class="form-group">
                  <label for="drivercode2">Vehicle Type</label>
                 <input type="text" class="form-control" name="edit_vehicle_type" id="edit_vehicle_type" required>
                </div>
				
				<div class="form-group">
                  <label for="drivercode">Description</label>
                  <input type="text" class="form-control" name="edit_description" id="edit_description" required>
                </div>
				
                <div class="form-group">
                  <label for="exampleInputPassword1">Volume Cap (CBM)</label>
                  <input type="text" class="form-control" name="edit_volume_cap" id="edit_volume_cap" required>
                </div>
				
				<div class="form-group">
                  <label for="exampleInputPassword1">Weight Cap (KG)</label>
                  <input type="text" class="form-control" name="edit_weight_cap" id="edit_weight_cap" required>
                </div>
				
                <input type="hidden" class="form-control" name="id_vehicle_type_update" id="id_vehicle_type_update">
              
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
		<h2 id="modal1Title">Import Vehicle Type</h2>
				<form role="form" id="form_import_data" method="POST" action="<?php echo base_url()."index.php/vehicle_type/importVehicleType" ?>" enctype="multipart/form-data">
				 <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
				 
              <div class="box-body">

				 <div class="form-group">
                      <label for="exampleInputEmail1">Choose File</label>
                      <input type="file" name="import_file" id="import_file" class="form-control" value="" />
				</div>
				
				 <div class="form-group">
                    <p><a target="_blank" href="<?php echo base_url('/files/example-files/import-vehicle-type.xlsx')?>">Download sample file import vehicle type</a></p>
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
		<h2 id="modal1Title">Delete Driver</h2>
				<form role="form" id="form_delete_data" method="POST" action="<?php echo base_url()."index.php/vehicle_type/deleteVehicleType" ?>" enctype="multipart/form-data">
				 <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
				 
              <div class="box-body">

				 <div class="form-group">
                     <p>Are you sure want to delete this data? (<span id="reference_delete"></span>)</p>
				</div>
				
				 <div class="form-group">
                      <input type="hidden" name="id_vehicle_type_delete" id="id_vehicle_type_delete" class="form-control" value="" />
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
		<h2 id="modal1Title">Delete Vehicle Type</h2>
				<form role="form" id="form_selected_delete_data" method="POST" action="<?php echo base_url()."index.php/vehicle_type/deleteVehicleTypeAll" ?>" enctype="multipart/form-data">
				 <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
				 
              <div class="box-body">

				 <div class="form-group">
                     <p>Are you sure want to delete selected data? </p>
				</div>
				
				 <div class="form-group">
                      <input type="hidden" name="id_vehicle_type_delete_all" id="id_vehicle_type_delete_all" class="form-control" value="" />
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
				var vehicle_type =  $('#data_'+id+' .vehicle_type').text();
				var id_vehicle_type =  $('#data_'+id+' .id_vehicle_type span').text();
				$("#reference_delete").text("Vehicle Type:"+vehicle_type)
				$("#id_vehicle_type_delete").val(id_vehicle_type);
			});
			
			
			
			$(".edit_data").click(function(){
				var id = $(this).attr('id');
				var vehicle_type =  $('#data_'+id+' .vehicle_type').text();
				var id_vehicle_type =  $('#data_'+id+' .id_vehicle_type span').text();
				var description =  $('#data_'+id+' .description').text();
				var volume_cap =  $('#data_'+id+' .volume_cap').text();
				var weight_cap =  $('#data_'+id+' .weight_cap').text();
				$("#id_vehicle_type_update").val(id_vehicle_type);
				$("#edit_vehicle_type").val(vehicle_type);
				$("#edit_description").val(description);
				$("#edit_volume_cap").val(volume_cap);
				$("#edit_weight_cap").val(weight_cap);
			});

			$("#form_add_data").validate({
				messages: {
				vehicle_type: {
				required: 'Vehicle Type must be filled!'
				},
				description: {
				required: 'Description must be filled!'
				},
				volume_cap: {
				required: 'Volume Cap must be filled!'
				},
				weight_cap: {
				required: 'Weight Cap must be filled!'
				}
			}
			});
			
			
			
			$("#form_edit_data").validate({
				messages: {
				edit_vehicle_type: {
				required: 'Vehicle Type must be filled!'
				},
				edit_description: {
				required: 'Description must be filled!'
				},
				edit_volume_cap: {
				required: 'Volume Cap must be filled!'
				},
				edit_weight_cap: {
				required: 'Weight Cap must be filled!'
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
		$("#id_vehicle_type_delete_all").val(ids);
		
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
