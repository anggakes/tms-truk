 <!-- HEADER -->
 <section class="content-header">
          <h1>
           Detail Invoice
            <small>Create Invoice</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="<?php echo BASE_URL(); ?>"><i class="fa fa-dashboard"></i>Home</a></li>
            <li><a href="<?php echo BASE_URL()."index.php/invoice"; ?>"><i class="fa fa-dashboard"></i> Invoice</a></li>
          </ol>
        </section>
  
  
   <!-- Content -->
   <section class="content">
		
		
			<?php
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
			<div class="box sms box-default color-palette-box">
            <div class="box-header with-border">
              <h3 class="box-title"><i class="fa fa-table"></i> Detail Invoice</h3>
            </div>
            <div class="box-body">
				
				<form role="form" style='margin-bottom:20px;' class='clearfix' id="form_search_invoice" method="GET" action="<?php echo base_url()."index.php/invoice/create_invoice" ?>" enctype="multipart/form-data">
				<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
				 
				<div class="col-md-6">
				  <div class="form-group">
					  <label for="drivercode2">Invoice Number</label> : 
					  <?php echo $data_invoice['invoice_number']; ?>
					</div>
					
				
				
				
				<div class="form-group">
					  <label for="drivercode2">Transporter Type</label> : 
					  <?php echo $data_invoice['transporter']; ?>
				</div>
				
				
				<div id='transporter-wrapper'  class="form-group">
					 <label>Transporter</label> : 
					 <?php echo $data_invoice['transporter_id']; ?> - <?php echo $data_invoice['transporter_name']; ?>
						<!-- /.input group -->
				</div>
				
				 
				</div>			  
				
				
				<div class="col-md-6">
				
				 <div class="form-group">
                        <label>Delivery Date</label> : 
                        <?php convert_date($data_invoice['schedule_date_from']); ?>-<?php convert_date($data_invoice['schedule_date_to']); ?>
                   </div><!-- /.form group -->
				   
				<div class="form-group">
					 <label>Client</label> : 
					 <?php echo $data_invoice['client_id']; ?>-<?php echo $data_invoice['client_id']; ?>
				</div>
				
				
				
				</div>
				</form>
				
				
				<form role="form" style='margin-bottom:20px;' class='clearfix' id="form_submit_invoice" method="POST" action="<?php echo base_url()."index.php/invoice/submitInvoice" ?>" enctype="multipart/form-data">
				<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
				 
				

				
				<div id='wrapper-invoice' class="col-md-12">
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
						
							<?php foreach($data_detail_invoice as $data_detail_invoice){ ?>
									<tr>
										<td><?php echo $data_detail_invoice->manifest_id; ?></td>
										<td><?php convert_date($data_detail_invoice->delivery_date); ?></td>
										<td><?php echo $data_detail_invoice->trip; ?></td>
										<td><?php echo $data_detail_invoice->origin; ?></td>
										<td><?php echo $data_detail_invoice->destination; ?></td>
										<td><?php convert_price($data_detail_invoice->amount_rate); ?></td>
										<td><?php convert_price($data_detail_invoice->amount_client_rate); ?></td>
										
									</tr>
							<?php } ?>
							
							
						</tbody>
						
						
					</table>
					
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
