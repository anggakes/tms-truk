 <!-- HEADER -->
 <section class="content-header">
          <h1>
           Transport Report
            <small>Create Transport Report</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="<?php echo BASE_URL(); ?>"><i class="fa fa-dashboard"></i>Home</a></li>
            <li><a href="<?php echo BASE_URL()."transport_report"; ?>"><i class="fa fa-dashboard"></i>Create Transport Report</a></li>
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
              <h3 class="box-title"><i class="fa fa-table"></i> Create Transport Report</h3>
            </div>
            <div class="box-body">
				
				<form role="form" style='margin-bottom:20px;' class='clearfix' id="form_search_invoice" method="GET" action="<?php echo base_url()."index.php/transport_report/exportTransportReport" ?>" enctype="multipart/form-data">
				<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
				 
				<div class="col-md-6">
				  
				 <div class="form-group">
                                <label>Delivery Date:</label>
                                <div class="input-group">
                                  <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                  </div>
                                  <input type="text" class="form-control pull-right" id="reservation" name="reservation" value='<?php echo $reservation; ?>' >
                                </div><!-- /.input group -->
                   </div><!-- /.form group -->
				   
				   
					
					<div class="form-group">
					  <label for="drivercode2">Manifest ID</label>
					 <input type="text" class="form-control" name="manifest_id" id="manifest_id" value='' >
					</div>
					
					<div class="form-group">
					  <label for="drivercode2">Transporter ID</label>
					 <input type="text" class="form-control" name="transporter_id" id="transporter_id" value='' >
					</div>
					
					<div class="form-group">
					  <label for="drivercode2">Client ID</label>
					 <input type="text" class="form-control" name="client_id" id="client_id" value='' >
					</div>
					
					<div class="form-group">
					  <label for="drivercode2">Trip</label>
					 <input type="text" class="form-control" name="trip" id="trip" value='' >
					</div>
				<div class="form-group">
					  <label for="drivercode2">Vehicle ID</label>
					 <input type="text" class="form-control" name="vehicle_id" id="vehicle_id" value='' >
					</div>
				 
				</div>			  
				
				
				<div class="col-md-6">
				
				
					
					<div class="form-group">
					  <label for="drivercode2">Origin</label>
					 <input type="text" class="form-control" name="origin" id="origin" value='' >
					</div>
					
					<div class="form-group">
					  <label for="drivercode2">Destination</label>
					 <input type="text" class="form-control" name="destination" id="destination" value='' >
					</div>
					
				<div class="form-group">
					  <label for="drivercode2">Transporter Type</label>
					  <select class="form-control" name="transporter" id="transporter" >
						<option selected="selected" value="">Choose type</option>
						<option  value="assets">Assets</option>
						<option  value="vendor">Vendor</option>
					  </select> 
				</div>
				
				<div class="form-group">
					  <label for="drivercode2">Status Manifest</label>
					  <select class="form-control" name="status_manifest" id="status_manifest" >
						<option selected="selected" value="">Choose type</option>
						<option  value="open">Open</option>
						<option  value="closed">Closed</option>
					  </select> 
				</div>
				
				
					
				<div class="form-group">
					  <label for="drivercode2">Driver Code</label>
					 <input type="text" class="form-control" name="driver_code" id="driver_code" value='' >
					</div>
				   
				
				
				
                <a href='<?php echo BASE_URL(); ?>/index.php/transport_report' class="remodal-cancel">Reset</a>
				<input type="submit" name="search_invoice" class="remodal-confirm" value="Export Report" id='search_invoice'>
				
				
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
