 <!-- HEADER -->
 <section class="content-header">
          <h1>
           Invoice
            <small>Create Invoice</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="<?php echo BASE_URL(); ?>"><i class="fa fa-dashboard"></i>Home</a></li>
            <li><a href="<?php echo BASE_URL()."invoice/create_invoice"; ?>"><i class="fa fa-dashboard"></i>Create Invoice</a></li>
          </ol>
        </section>
  
  
   <!-- Content -->
   <section class="content">
		
			<?php
				$invoice_number = isset($_GET['invoice_number']) ? $_GET['invoice_number'] : '';
				$type = isset($_GET['type']) ? $_GET['type'] : '';
				$transporter = isset($_GET['transporter']) ? $_GET['transporter'] : '';
				$transporter_id = isset($_GET['transporter_id']) ? $_GET['transporter_id'] : '';
				$transporter_name = isset($_GET['transporter_name']) ? $_GET['transporter_name'] : '';
				$reservation = isset($_GET['reservation']) ? $_GET['reservation'] : '';
				$client_id = isset($_GET['client_id']) ? $_GET['client_id'] : '';
				$client_name = isset($_GET['client_name']) ? $_GET['client_name'] : '';
			?>
		
			<div class="box sms box-default color-palette-box">
            <div class="box-header with-border">
              <h3 class="box-title"><i class="fa fa-table"></i> Create Invoice</h3>
            </div>
            <div class="box-body">
				
				<form role="form" style='margin-bottom:20px;' class='clearfix' id="form_search_invoice" method="GET" action="<?php echo base_url()."index.php/invoice/create_invoice" ?>" enctype="multipart/form-data">
				<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
				 
				<div class="col-md-6">
				  <div class="form-group">
					  <label for="drivercode2">Invoice Number</label>
					 <input type="text" class="form-control" name="invoice_number" id="invoice_number" value='<?php echo $invoice_number ?>' required>
					</div>
					
				 <div class="form-group">
					  <label for="drivercode2">Type</label>
					  <select class="form-control" name="type" id="type" required>
						<option selected="selected" value="">Choose type</option>
						<option value="oncall">On Call</option>
						<option value="contract">Dedicated</option>
					  </select> 
				</div>
				
				
				<div class="form-group">
					  <label for="drivercode2">Transporter Type</label>
					  <select class="form-control" name="transporter" id="transporter" required>
						<option selected="selected" value="">Choose type</option>
						<option <?php if($transporter=='assets'){?> selected='selected' <?php } ?> value="assets">Assets</option>
						<option <?php if($transporter=='vendor'){?> selected='selected' <?php } ?> value="vendor">Vendor</option>
					  </select> 
				</div>
				
				
				<div id='transporter-wrapper' style='display:none' class="form-group">
					 <label>Transporter</label>
						<div class="input-group">
						  <div class="input-group-addon">
							<i class="fa fa-search"></i>
						  </div>
						  <input type="text" class="form-control pull-right" name="search_transporter_id" id="search_transporter_id" value='' placeholder='Search Transporter'>
						  <input type="text" readonly class="form-control" name="transporter_id" id="transporter_id" placeholder='Transporter ID' value='<?php echo $transporter_id; ?>' required>
						  <input type="text" readonly class="form-control" name="transporter_name" id="transporter_name" placeholder='Transporter Name' value='<?php echo $transporter_name; ?>' required>
					</div>
						<!-- /.input group -->
				</div>
				
				 
				</div>			  
				
				
				<div class="col-md-6">
				
				 <div class="form-group">
                                <label>Schedule Date:</label>
                                <div class="input-group">
                                  <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                  </div>
                                  <input type="text" class="form-control pull-right" id="reservation" name="reservation" value='<?php echo $reservation; ?>' required>
                                </div><!-- /.input group -->
                   </div><!-- /.form group -->
				   
				<div class="form-group">
					 <label>Client</label>
						<div class="input-group">
						  <div class="input-group-addon">
							<i class="fa fa-search"></i>
						  </div>
						  <input type="text" class="form-control pull-right" name="search_client_id" id="search_client_id" value='' placeholder='Search Client'>
						  <input type="text" readonly class="form-control" name="client_id" id="client_id" placeholder='Client ID' value='<?php echo $client_id; ?>' required>
						  <input type="text" readonly class="form-control" name="client_name" id="client_name" placeholder='Client Name' value='<?php echo $client_name; ?>' required>
					</div>
						<!-- /.input group -->
				</div>
				
				
                <a href='<?php echo BASE_URL(); ?>/index.php/invoice/create_invoice' class="remodal-cancel">Reset</a>
				<input type="submit" name="search_invoice" class="remodal-confirm" value="Search Invoice" id='search_invoice'>
				
				
				</div>
				</form>
				
				
				<form role="form" style='margin-bottom:20px;' class='clearfix' id="form_submit_invoice" method="POST" action="<?php echo base_url()."index.php/invoice/submitInvoice" ?>" enctype="multipart/form-data">
				<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
				 
				

				
				<div id='wrapper-invoice' class="col-md-12">
					<h3 style='text-align:center;'>Table Invoice</h3>
					<table id='invoice-table'>
						<thead>
							<tr>
							<th>Manifest ID</th>
							<th>Delivery Date</th>
							<th>Trip</th>
							<th>Origin</th>
							<th>Destination</th>
							<th>Amount Rate</th>
							<th>Amount Client Rate</th>
							</tr>
						</thead>
						
						
						<tbody>
						
						<?php
						$total_invoice = 0;
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
						<?php 
						
						if($invoice_number!='')
						{
						
						$schedule_date = explode('->',$reservation);
						
						$start_date = $schedule_date[0];
						$start_date = explode('-',$start_date);
						$start_date = $start_date[2].'-'.$start_date[1].'-'.$start_date[0];
						$start_date = str_replace(" ","",$start_date);
						
						$end_date = $schedule_date[1];
						$end_date = explode('-',$end_date);
						$end_date = $end_date[2].'-'.$end_date[1].'-'.$end_date[0];
						$end_date = str_replace(" ","",$end_date);
						
						?>
						
						<input type='hidden' name='input_invoice_number' id='input_invoice_number' value='<?php echo $invoice_number; ?>'>
						<input type='hidden' name='input_type' id='input_type' value='<?php echo $type; ?>'>
						<input type='hidden' name='input_transporter' id='input_transporter' value='<?php echo $transporter; ?>'>
						<input type='hidden' name='input_transporter_id' id='input_transporter_id' value='<?php echo $transporter_id; ?>'>
						<input type='hidden' name='input_client_id' id='input_client_id' value='<?php echo $client_id; ?>'>
						<input type='hidden' name='input_client_name' id='input_client_name' value='<?php echo $client_name; ?>'>
						<input type='hidden' name='input_start_date' id='input_start_date' value='<?php echo $start_date; ?>'>
						<input type='hidden' name='input_end_date' id='input_end_date' value='<?php echo $end_date; ?>'>
						
						<?php
						
						if($transporter=='assets')
						{
							$data_manifest = $this->db->query("SELECT * FROM master_manifest WHERE client_id = '".$client_id."' AND vehicle_status = '".$type."' AND transporter = 'assets' AND delivery_date BETWEEN '".$start_date."' AND '".$end_date."'   ")->result();
							
						}
						else if($transporter=='vendor')
						{
							$data_manifest = $this->db->query("SELECT * FROM master_manifest WHERE client_id = '".$client_id."' AND vehicle_status = '".$type."' AND delivery_date between '".$start_date."' AND '".$end_date."' AND transporter = 'vendor' AND transporter_id = '".$transporter_id."'  ")->result();
						}
						
						 foreach($data_manifest as $data_manifest)
						 {
							 
							$total_manifest_to = $this->db->query("SELECT * FROM transport_order WHERE manifest = '".$data_manifest->id_manifest."' ")->num_rows();
							
							$total_pod = $this->db->query("SELECT * FROM pod WHERE manifest = '".$data_manifest->id_manifest."' ")->num_rows();
							
							if($total_pod=$total_pod)
							{
								$total_invoice++;
								
								$check_invoice = $this->db->query("SELECT * FROM detail_master_invoice WHERE manifest_id = '".$data_manifest->id_manifest."' ")->num_rows();
								if($check_invoice<=0){
							?>
						
									<tr>
										<td><input type='hidden' name='id_manifest[]' value='<?php echo $data_manifest->id_manifest; ?>'><?php echo $data_manifest->id_manifest; ?></td>
										<td><input type='hidden' name='delivery_date[]' value='<?php echo $data_manifest->delivery_date; ?>'><?php convert_date($data_manifest->delivery_date); ?></td>
										<td><input type='hidden' name='trip[]' value='<?php echo $data_manifest->trip; ?>'><?php echo $data_manifest->trip; ?></td>
										<td><input type='hidden' name='origin_id[]' value='<?php echo $data_manifest->origin_id; ?>'><?php echo $data_manifest->origin_id; ?></td>
										<td><input type='hidden' name='destination_id[]' value='<?php echo $data_manifest->destination_id; ?>'><?php echo $data_manifest->destination_id; ?></td>
										<td><input type='hidden' name='rate[]' value='<?php echo $data_manifest->rate; ?>'><?php convert_price($data_manifest->rate); ?></td>
										<td><input type='hidden' name='client_rate[]' value='<?php echo $data_manifest->client_rate; ?>'><?php convert_price($data_manifest->client_rate); ?></td>
									</tr>
							
							<?php 
								}
							}
						
							
							
							
							
						 }
						
						}
						
						?>
							
						</tbody>
						
						
					</table>
					
					<?php if($total_invoice>=1){ ?> 
					<input style='float:right; margin-top:10px;' type="submit" name="submit_invoice" class="remodal-confirm" value="Submit Invoice" id='submit_invoice'>
					<?php } ?>
						
				</div>
				
				</form>
				
			</div>
			</div>
		
  
    </section>

	  
	 
<script>
	   $('#reservation').daterangepicker({ Format: "dd-mm-yy" }).val();
</script>	
	
	
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
			
			
			$("#form_search_invoice").validate({
				messages: {
				invoice_number: {
				required: 'Invoice Number must be filled!'
				},
				type: {
				required: 'Type must be filled!'
				},
				transporter: {
				required: 'Transporter must be filled!'
				},
				transporter_id: {
				required: 'Traneporter ID must be filled!'
				},
				transporter_name: {
				required: 'Transporter Name must be filled!'
				},
				reservation: {
				required: 'Schedule Date must be filled!'
				},
				client_id: {
				required: 'Client ID must be filled!'
				},
				client_name: {
				required: 'Client Name must be filled!'
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


$(".delete_data").click(function(){
	$('[data-remodal-id = modal_delete]').remodal().open();
});

$(".edit_data").click(function(){
	$('[data-remodal-id = modal_edit]').remodal().open();
	var validator = $( "#form_edit_data" ).validate();
	validator.resetForm();
});


$(document).on('change', '#transporter', function() {

    
	var transporter = $(this).val();
	if(transporter=='vendor')
	{$("#transporter-wrapper").show();}
	else
	{$("#transporter-wrapper").hide();}
	
	
});

</script>

		<script>
		//auto complete Cient
        $( "#search_client_id" ).autocomplete({
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
		
		//auto complete Destination
        $( "#search_transporter_id" ).autocomplete({
         source: "<?php echo BASE_URL(); ?>/index.php/json/jsonTransporter",  
         minLength:0,
		 select: function( event , ui ) {
			  $( "#transporter_id" ).val( ui.item.transporter_id );
			  $( "#transporter_name" ).val( ui.item.transporter_name );
        }    
        })
		.autocomplete( "instance" )._renderItem = function( ul, item ) {
		  return $( "<li style='position:relative; z-index:9999;'>" )
			.append( "<div style='font-size:10px;'>" + item.label+"</div>" )
			.appendTo( ul );
		};
		</script>
