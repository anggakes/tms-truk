 <!-- HEADER -->
 <section class="content-header">
          <h1>
            Invoice Status 
            <small>List Of Invoice Status</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="<?php echo BASE_URL(); ?>"><i class="fa fa-dashboard"></i>Home</a></li>
            <li><a href="<?php echo BASE_URL()."status_invoice"; ?>"><i class="fa fa-dashboard"></i>Invoice Status</a></li>
          </ol>
        </section>
  
  
   <!-- Content -->
   <section class="content">
		
		
  
  
          <div class="box sms box-default color-palette-box">
            <div class="box-header with-border">
              <h3 class="box-title"><i class="fa fa-table"></i> Table Invoice Status</h3>
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
           	<table id="myTable04" class="fancyTable table table-bordered table-hover">
                    <thead>
                      <tr>
					  
                        <th><div class="check-box-div"><input type="checkbox" name="select_all" id="select_all"></div>SPK Number</th>
                        <th>Reference</th>
                        <th>DO Number</th>
						<th>vehicle</th>
						<th>Client</th>
						<th>Transporter</th>
						<th>Origin Name</th>
						<th>Destination</th>
						<th>Invoice Number to Client</th>
						<th>Invoice Number to Client Date</th>
						<th>Invoice Number from Supplier</th>
						<th>Invoice Number from Supplier Date</th>
						<?php if($data_role[0]['delete_pod']=='yes' || $data_role[0]['edit_pod']=='yes'){ ?>
						<th>Action</th>
						<?php } ?>
                      </tr>
                    </thead>
             		<tbody>
                    <?php foreach($data_status_invoice as $data_status_invoice) {?>
                    <tr id="data_<?php echo $data_status_invoice->spk_number; ?>">
                    	<td class="spk_number">
						<div class="check-box-div">
						<input type="checkbox" name="id_checkbox[]" class="iCheck-helper toedit checkbox_satuan" value="<?php echo $data_status_invoice->spk_number; ?>" />
						</div>
						<span><?php echo $data_status_invoice->spk_number; ?></span>
						</td>
                        <td class="reference"><?php echo $data_status_invoice->reference; ?></td>
                        <td class="do_number"><?php echo $data_status_invoice->do_number; ?></td>
						<td class="vehicle_id"><?php echo $data_status_invoice->vehicle_id; ?></td>
						<td class="client_id"><?php echo $data_status_invoice->client_id; ?></td>
						<td class="transporter"><?php echo $data_status_invoice->transporter; ?></td>
						<td class="origin"><?php echo $data_status_invoice->origin_id_echo; ?> - <?php echo $data_status_invoice->origin_address_echo; ?> - <?php echo $data_status_invoice->origin_area; ?></td>
						<td class="destination"><?php echo $data_status_invoice->destination_id_echo; ?> - <?php echo $data_status_invoice->destination_address_echo; ?> - <?php echo $data_status_invoice->destination_area; ?></td>
						<td class="invoice_number_to_client"><?php echo $data_status_invoice->invoice_number_to_client; ?></td>
						<td class="invoice_number_to_client_date"><?php convert_date($data_status_invoice->invoice_number_to_client_date); ?></td>
						<td class="invoice_number_from_supplier"><?php echo $data_status_invoice->invoice_number_from_supplier; ?></td>
						<td class="invoice_number_from_supplier_date"><?php convert_date($data_status_invoice->invoice_number_from_supplier_date); ?></td>
						<?php if($data_role[0]['edit_pod']=='yes'){ ?>
						<td><?php if($data_role[0]['edit_pod']=='yes'){ ?><a  id="<?php echo $data_status_invoice->spk_number; ?>" class="edit_data link_action">Update Status Invoice</a><?php } ?> | <a  href="<?php echo "<?php echo BASE_URL(); ?>/files/example-files/Purchase_Invoice.xlsx" ?>">Export Purchase Invoice</a> | <a  href="<?php echo "<?php echo BASE_URL(); ?>/files/example-files/Sales_Invoice.xlsx" ?>">Export Sales Invoice</a></td>
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

	  
	
	
	
	
	<div class="remodal" data-remodal-id="modal_edit" role="dialog" aria-labelledby="modal1Titl aria-describedby="modal1Desc">
	  <button data-remodal-action="close" class="remodal-close" aria-label="Close"></button>
	  <div>
		<h2 id="modal1Title">Status Payment Shipmet</h2>
				<form role="form" id="form_edit_data" method="POST" action="<?php echo base_url()."index.php/status_invoice/editStatusInvoice" ?>" enctype="multipart/form-data">
				 <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
				 
              <div class="box-body">

				
				<div class="form-group">
                  <label for="drivercode2">Invoice Number to Client</label>
                 <input type="text" class="form-control" name="invoice_number_to_client" id="invoice_number_to_client" required>
                </div>
				
				<div class="form-group">
					  <label for="drivercode2">Invoice Number to Client Date</label>
						  <div class="input-group date">
						  <div class="input-group-addon">
							<i class="fa fa-calendar"></i>
						  </div>
						  <input type="text" name="invoice_number_to_client_date" class="form-control pull-right datepicker" id="invoice_number_to_client_date" required>
						</div>
				</div>
				
				<div class="form-group">
                  <label for="drivercode2">Invoice Number from Supplier</label>
                 <input type="text" class="form-control" name="invoice_number_from_supplier" id="invoice_number_from_supplier" required>
                </div>
				
				<div class="form-group">
					  <label for="drivercode2">Invoice Number from Supplier Date</label>
						  <div class="input-group date">
						  <div class="input-group-addon">
							<i class="fa fa-calendar"></i>
						  </div>
						  <input type="text" name="invoice_number_from_supplier_date" class="form-control pull-right datepicker" id="invoice_number_from_supplier_date" required>
						</div>
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
	
	
	

		
  <script>
  
			$(".delete_data").click(function(){
				var id = $(this).attr('id');
				var driver_code =  $('#data_'+id+' .driver_code').text();
				var spk_number =  $('#data_'+id+' .spk_number span').text();
				$("#reference_delete").text("POD Code:"+driver_code)
				$("#spk_number_delete").val(spk_number);
			});
			
			
			
			$(".edit_data").click(function(){
				var id = $(this).attr('id');
				var spk_number =  $('#data_'+id+' .spk_number span').text();
				var invoice_number_to_client =  $('#data_'+id+' .invoice_number_to_client').text();
				var invoice_number_to_client_date =  $('#data_'+id+' .invoice_number_to_client_date').text();
				var invoice_number_from_supplier =  $('#data_'+id+' .invoice_number_from_supplier').text();
				var invoice_number_from_supplier_date =  $('#data_'+id+' .invoice_number_from_supplier_date').text();
				
				$("#invoice_number_to_client").val(invoice_number_to_client);
				$("#invoice_number_to_client_date").val(invoice_number_to_client_date);
				$("#invoice_number_from_supplier").val(invoice_number_from_supplier);
				$("#invoice_number_from_supplier_date").val(invoice_number_from_supplier_date);
				$("#spk_number_update").val(spk_number);
				
			});

			
			
			
			$("#form_edit_data").validate({
				
				messages: {
				edit_pod_code: {
				required: 'POD Code must be filled!'
				},
				edit_pod: {
				required: 'POD must be filled!'
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

$('.datepicker').datepicker({
			  autoclose: true,
			  Format: 'dd-mm-yyyy'
			});
			
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
