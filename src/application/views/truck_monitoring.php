 <!-- HEADER -->
 <section class="content-header">
          <h1>
            Truck Monitoring
            <small>List Of Truck Monitoring</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="<?php echo BASE_URL(); ?>"><i class="fa fa-dashboard"></i>Home</a></li>
            <li><a href="<?php echo BASE_URL()."pod"; ?>"><i class="fa fa-dashboard"></i>Truck Monitoring</a></li>
          </ol>
        </section>
  
  
   <!-- Content -->
   <section class="content">
		
		
  
  
          <div class="box sms box-default color-palette-box">
            <div class="box-header with-border">
              <h3 class="box-title"><i class="fa fa-table"></i> Table Truck Monitoring</h3>
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
                             <form action="<?php echo base_url()."index.php/pod" ?>" method="get">
                             <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                                <input type="text" id="search" name="search" placeholder="Search..."  value="<?php echo $search; ?>" />
                                <input type="submit" id="submit"  value="Search"/>
                                <?php if($search!="")
								{?>
                                <a href="<?php echo base_url()."index.php/pod" ?>" id="clear-search">Clear Search</a>
                                <?php } ?>
                             </form>
                </div>
                <div id="wrapper-button" class="clearfix">
					
					
					
                </div>
                </div>
            <div id="wrapper-console" class="clearfix"> 
            <div class="grid_4 height400">                  
           	<table id="myTable03" class="fancyTable table table-bordered table-hover">
                    <thead>
                      <tr>
					  
                        <th><div class="check-box-div"><input type="checkbox" name="select_all" id="select_all"></div>ID Truck Monitoring</th>
                        <th>Monitoring Status</th>
						<th>Reference</th>
                        <th>DO Number</th>
						<th>Trip</th>
						<th>vehicle</th>
						<th>Client</th>
						<th>Transporter</th>
						<th>Origin Name</th>
						<th>Destination</th>
					
                      </tr>
                    </thead>
             		<tbody>
                    <?php foreach($data_pod as $data_pod) {?>
                    <tr id="data_<?php echo $data_pod->spk_number; ?>">
                    	<td class="spk_number">
						<div class="check-box-div">
						<input type="checkbox" name="id_checkbox[]" class="iCheck-helper toedit checkbox_satuan" value="<?php echo $data_pod->spk_number; ?>" />
						</div>
						<span><?php echo $data_pod->spk_number; ?></span>
						<span class='pod_number' style='display:none;'><?php echo $data_pod->pod_number; ?></span>
						<span class='pod_confirmed' style='display:none;'><?php echo $data_pod->pod_confirmed; ?></span>
						<span class='pod' style='display:none;'><?php echo $data_pod->pod; ?></span>
						
						</td>
						<td class="reference"><div class='status_trucking green'></div></td>
                        <td class="reference"><?php echo $data_pod->reference; ?></td>
                        <td class="do_number"><?php echo $data_pod->do_number; ?></td>
						<td class="trip"><?php echo $data_pod->trip; ?></td>
						<td class="vehicle_id"><?php echo $data_pod->vehicle_id; ?></td>
						<td class="client_id"><?php echo $data_pod->client_id; ?></td>
						<td class="transporter"><?php echo $data_pod->transporter; ?></td>
						<td class="origin"><?php echo $data_pod->origin_id; ?> - <?php echo $data_pod->origin_address; ?> - <?php echo $data_pod->origin_area; ?></td>
						<td class="destination"><?php echo $data_pod->destination_id; ?> - <?php echo $data_pod->destination_address; ?> - <?php echo $data_pod->destination_area; ?></td>
						
						
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
		<h2 id="modal1Title">Add Truck Monitoring</h2>
				<form role="form" id="form_add_data" method="POST" action="<?php echo base_url()."index.php/driver/addTruck Monitoring" ?>" enctype="multipart/form-data">
				 <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
				 
              <div class="box-body">

				 <div class="form-group">
                  <label for="drivercode2">Truck Monitoring Code</label>
                 <input type="text" class="form-control" name="driver_code" id="driver_code" required>
                </div>
				
				<div class="form-group">
                  <label for="drivercode">Truck Monitoring Name</label>
                  <input type="text" class="form-control" name="driver_name" id="driver_name" required>
                </div>
				
                <div class="form-group">
                  <label for="exampleInputPassword1">Password</label>
                  <input type="password" class="form-control" name="password1" id="password1" required>
                </div>
				
				<div class="form-group">
                  <label for="exampleInputPassword1">Re type Password</label>
                  <input type="password" class="form-control" name="password2" id="password2" required>
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
		<h2 id="modal1Title">Confirmed Truck Monitoring</h2>
				<form role="form" id="form_edit_data" method="POST" action="<?php echo base_url()."index.php/pod/editTruck Monitoring" ?>" enctype="multipart/form-data">
				 <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
				 
              <div class="box-body">

				
				<div class="form-group">
                  <label for="drivercode2">Truck Monitoring Code</label>
                 <input type="text" class="form-control" name="edit_pod_code" id="edit_pod_code" required>
                </div>
				
				<div class="form-group">
					  <label for="drivercode2">Choose Truck Monitoring</label>
					  <select class="form-control" name="edit_pod" id="edit_pod" required>
						<option selected="selected" value="">Choose Truck Monitoring</option>
						<option value="in_full">In Full</option>
						<option value="redelivery">Redelivery</option>
						<option value="rejected">Rejected</option>
					  </select> 
				</div>
				
				<div class="form-group">
					  <label for="drivercode2">Choose Confirmation</label>
					  <select class="form-control" name="edit_confirmation" id="edit_confirmation" required>
						<option value="confirmed">Confirmed</option>
						<option value="unconfirmed">Unconfirmed</option>
					  </select> 
				</div>
               
                <input type="hidden" class="form-control" name="spk_number_update" id="spk_number_update">
              
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button data-remodal-action="cancel" class="remodal-cancel">Cancel</button>
				<input type="submit" name="submit_add" class="remodal-confirm" value="Confirm" id="submit_add">
              </div>
            </form>
	  </div>
	  <br>
	  
	</div>
	
	
	
	<div class="remodal" data-remodal-id="modal_import" role="dialog" aria-labelledby="modal1Titl aria-describedby="modal1Desc">
	  <button data-remodal-action="close" class="remodal-close" aria-label="Close"></button>
	  <div>
		<h2 id="modal1Title">Import Truck Monitoring</h2>
				<form role="form" id="form_import_data" method="POST" action="<?php echo base_url()."index.php/driver/importTruck Monitoring" ?>" enctype="multipart/form-data">
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
		<h2 id="modal1Title">Delete Truck Monitoring</h2>
				<form role="form" id="form_delete_data" method="POST" action="<?php echo base_url()."index.php/driver/deleteTruck Monitoring" ?>" enctype="multipart/form-data">
				 <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
				 
              <div class="box-body">

				 <div class="form-group">
                     <p>Are you sure want to delete this data? (<span id="reference_delete"></span>)</p>
				</div>
				
				 <div class="form-group">
                      <input type="hidden" name="spk_number_delete" id="spk_number_delete" class="form-control" value="" />
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
		<h2 id="modal1Title">Delete Truck Monitoring</h2>
				<form role="form" id="form_selected_delete_data" method="POST" action="<?php echo base_url()."index.php/driver/deleteTruck MonitoringAll" ?>" enctype="multipart/form-data">
				 <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
				 
              <div class="box-body">

				 <div class="form-group">
                     <p>Are you sure want to delete selected data? </p>
				</div>
				
				 <div class="form-group">
                      <input type="hidden" name="spk_number_delete_all" id="spk_number_delete_all" class="form-control" value="" />
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
				var driver_code =  $('#data_'+id+' .driver_code').text();
				var spk_number =  $('#data_'+id+' .spk_number span').text();
				$("#reference_delete").text("Truck Monitoring Code:"+driver_code)
				$("#spk_number_delete").val(spk_number);
			});
			
			
			
			$(".edit_data").click(function(){
				var id = $(this).attr('id');
				var spk_number =  $('#data_'+id+' .spk_number span').text();
				var pod_number =  $('#data_'+id+' .spk_number .pod_number ').text();
				var pod_confirmed =  $('#data_'+id+' .spk_number .pod_confirmed ').text();
				var pod =  $('#data_'+id+' .spk_number .pod').text();
				
				var driver_name =  $('#data_'+id+' .driver_name').text();
				var driver_name =  $('#data_'+id+' .driver_name').text();
				var driver_name =  $('#data_'+id+' .driver_name').text();
				$("#spk_number_update").val(spk_number);
				
				$("#edit_pod_code").val(pod_number);
				$('#edit_pod option[value="' + pod + '"]').prop('selected',true);
				$('#edit_confirmation option[value="' + pod_confirmed + '"]').prop('selected',true);
				
			});

			
			
			
			$("#form_edit_data").validate({
				
				messages: {
				edit_pod_code: {
				required: 'Truck Monitoring Code must be filled!'
				},
				edit_pod: {
				required: 'Truck Monitoring must be filled!'
				},
				edit_confirmation: {
				required: 'Confirmation must be filled!'
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
		$("#spk_number_delete_all").val(ids);
		
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
