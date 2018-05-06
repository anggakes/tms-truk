 <!-- HEADER -->
 <section class="content-header">
          <h1>
            Master Traffic Monitoring
            <small>List Of Traffic Monitoring</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="<?php echo BASE_URL(); ?>"><i class="fa fa-dashboard"></i>Home</a></li>
            <li><a href="<?php echo BASE_URL()."index.php/traffic_monitoring/"; ?>"><i class="fa fa-dashboard"></i> Traffic Monitoring</a></li>
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
			?>
            <div id="wrapper-console" class="clearfix">
                <div id="wrapper-search">
                </div>
                <div id="wrapper-button" class="clearfix">
				
                </div>
                </div>
            <div id="wrapper-console" class="clearfix"> 
            <div class="grid_4 height400">                  
           	<table id="myTable03" class="fancyTable table-bordered table-hover">
                    <thead>
                      <tr>
					  
						<th>Point ID</th>
                        <th>Status</th>
						<th>Order Type</th>
						<th>State</th>
						<th>Driver</th>
						<th>Foto</th>
						<th>Manifest</th>
						<th>Detail</th>
						
                      </tr>
                    </thead>
             		<tbody>
                    <?php foreach($data_traffic_monitoring as $data_traffic_monitoring) {?>
                    <tr id="data_<?php echo $data_traffic_monitoring->id_update_apps; ?>">
                    	
                        <td><?php echo $data_traffic_monitoring->point_id; ?></td>
						<td><?php echo $data_traffic_monitoring->status; ?></td>
						<td><?php echo $data_traffic_monitoring->order_type; ?></td>
						<td><?php echo $data_traffic_monitoring->state; ?></td>
						<td><?php echo $data_traffic_monitoring->driver_code; ?></td>
						<td><?php echo $data_traffic_monitoring->foto; ?></td>
						<td><?php echo $data_traffic_monitoring->manifest; ?></td>
						<td><a href='<?php echo site_url("traffic_monitoring/detailUpdateApps?id=".$data_traffic_monitoring->id_update_apps); ?>'> Detail Maps & Foto</a></td>
						
					</tr>
                    <?php }?>
                    </tbody>       
             </table>
             </div>
             
            		 
           </div>
           </div>
            
            </div>
      </section>

	  
	 
	
	
	
	<div class="remodal" data-remodal-id="modal_edit" role="dialog" aria-labelledby="modal1Titl aria-describedby="modal1Desc">
	  <button data-remodal-action="close" class="remodal-close" aria-label="Close"></button>
	  <div>
		<h2 id="modal1Title">Edit Invoice</h2>
				<form role="form" id="form_edit_data" method="POST" action="<?php echo base_url()."index.php/invoice/editInvoice" ?>" enctype="multipart/form-data">
				 <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
				 
              <div class="box-body">

				 
				  <div class="form-group">
					  <label for="drivercode2">Status Invoice</label>
					  <select class="form-control" name="edit_status_invoice" id="edit_status_invoice" required>
						<option selected="selected" value="">Choose Category</option>
						<option value="Paid">Paid</option>
						<option value="Pending">Pending</option>
					  </select> 
				</div>
               
				 
					
					
				
                <input type="hidden" class="form-control" name="id_invoice_update" id="id_invoice_update">
              
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
		<h2 id="modal1Title">Delete Invoice</h2>
				<form role="form" id="form_delete_data" method="POST" action="<?php echo base_url()."index.php/invoice/deleteInvoice" ?>" enctype="multipart/form-data">
				 <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
				 
              <div class="box-body">

				 <div class="form-group">
                     <p>Are you sure want to delete this data? (<span id="reference_delete"></span>)</p>
				</div>
				
				 <div class="form-group">
                      <input type="hidden" name="id_invoice_delete" id="id_invoice_delete" class="form-control" value="" />
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
		<h2 id="modal1Title">Delete Invoice</h2>
				<form role="form" id="form_selected_delete_data" method="POST" action="<?php echo base_url()."index.php/invoice/deleteInvoiceAll" ?>" enctype="multipart/form-data">
				 <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
				 
              <div class="box-body">

				 <div class="form-group">
                     <p>Are you sure want to delete selected data? </p>
				</div>
				
				 <div class="form-group">
                      <input type="hidden" name="id_invoice_delete_all" id="id_invoice_delete_all" class="form-control" value="" />
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
				var invoice_number =  $('#data_'+id+' .invoice_number').text();
				var id_invoice =  $('#data_'+id+' .id_invoice span').text();
				$("#reference_delete").text("Invoice Number : "+invoice_number)
				$("#id_invoice_delete").val(id_invoice);
			});
			
			
			
			$(".edit_data").click(function(){
				var id = $(this).attr('id');
				var id_invoice =  $('#data_'+id+' .id_invoice span').text();
				var category =  $('#data_'+id+' .category').text();
				var description =  $('#data_'+id+' .description').text();
				
				
				$("#id_invoice_update").val(id_invoice);
				$("#edit_description").val(description);
				$('#edit_category option[value="' + category + '"]').prop('selected',true);
				
			});

			$("#form_add_data").validate({
				
				messages: {
				area_id: {
				required: 'Master Invoice ID must be filled!'
				},
				area_description: {
				required: 'Master Invoice Description must be filled!'
				},
				area_type: {
				required: 'Master Invoice Type must be filled!'
				}
			}
			});
			
			
			
			$("#form_edit_data").validate({
				
				messages: {
				edit_invoice_id: {
				required: 'Master Invoice ID must be filled!'
				},
				edit_invoice_description: {
				required: 'Master Invoice Description must be filled!'
				},
				edit_invoice_type: {
				required: 'Master Invoice Type must be filled!'
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
		$("#id_invoice_delete_all").val(ids);
		
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
