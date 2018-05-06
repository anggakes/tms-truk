 <!-- HEADER -->
 <section class="content-header">
          <h1>
            Master Invoice
            <small>List Of Master Invoice</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="<?php echo BASE_URL(); ?>"><i class="fa fa-dashboard"></i>Home</a></li>
            <li><a href="<?php echo BASE_URL()."invoice"; ?>"><i class="fa fa-dashboard"></i>Master Invoice</a></li>
          </ol>
        </section>
  
  
   <!-- Content -->
   <section class="content">
		
		
  
  
          <div class="box sms box-default color-palette-box">
            <div class="box-header with-border">
              <h3 class="box-title"><i class="fa fa-table"></i> Table Master Invoice</h3>
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
                             <form action="<?php echo base_url()."index.php/invoice" ?>" method="get">
                             <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                                <input type="text" id="search" name="search" placeholder="Search..."  value="<?php echo $search; ?>" />
                                <input type="submit" id="submit"  value="Search"/>
                                <?php if($search!="")
								{?>
                                <a href="<?php echo base_url()."index.php/area" ?>" id="clear-search">Clear Search</a>
                                <?php } ?>
                             </form>
                </div>
                <div id="wrapper-button" class="clearfix">
					<?php if($data_role[0]['export_invoice']=='yes'){ ?>
                	<a href="<?php echo base_url()."index.php/invoice/exportInvoice?search=".$search; ?>" class="button orange-button">
                    	Export Invoice
                    </a>
					<?php } ?>
                    <?php if($data_role[0]['add_invoice']=='yes'){ ?>
                    <a href='<?php echo BASE_URL(); ?>/index.php/invoice/create_invoice' target='_blank'  class="button green-button">
                    	Add Invoice
                    </a>
					<?php } ?>
					<?php if($data_role[0]['delete_invoice']=='yes'){ ?>
                    <a id="delete-data" class="button btn-danger deletelogg">
                    	Delete Invoice
                    </a>
					<?php } ?>
                </div>
                </div>
            <div id="wrapper-console" class="clearfix"> 
            <div class="grid_4 height400">                  
           	<table id="myTable03" class="fancyTable table-bordered table-hover">
                    <thead>
                      <tr>
					  
                        <th><div class="check-box-div"><input type="checkbox" name="select_all" id="select_all"></div>ID</th>
                        
						<th>Invoice Number</th>
                        <th>Client ID</th>
						<th>Transporter</th>
						<th>Transporter ID</th>
						<th>Transporter Name</th>
						<th>Remark</th>
						<th>Schedule Date</th>
						<th>Status</th>
						
						<?php if($data_role[0]['delete_invoice']=='yes' || $data_role[0]['edit_invoice']=='yes'){ ?>
						<th>Action</th>
						<?php } ?>
                      </tr>
                    </thead>
             		<tbody>
                    <?php foreach($data_invoice as $data_invoice) {?>
                    <tr id="data_<?php echo $data_invoice->id_invoice; ?>">
                    	<td class="id_invoice">
						<div class="check-box-div">
						<input type="checkbox" name="id_checkbox[]" class="iCheck-helper toedit checkbox_satuan" value="<?php echo $data_invoice->id_invoice; ?>" />
						</div><span><?php echo $data_invoice->id_invoice; ?></span></td>
						
						
                        <td class="invoice_number"><?php echo $data_invoice->invoice_number; ?></td>
                        <td class="client_id"><?php echo $data_invoice->client_id; ?></td>
						<td class="transporter"><?php echo $data_invoice->transporter; ?></td>
						<td class="transporter_id"><?php echo $data_invoice->transporter_id; ?></td>
						<td class="transporter_name"><?php echo $data_invoice->transporter_name; ?></td>
						<td class="remark"><?php echo $data_invoice->remark; ?></td>
						<td class="schedule_date"><?php echo $data_invoice->schedule_date_from; ?>-<?php echo $data_invoice->schedule_date_to; ?></td>
						<td class="status"><?php echo $data_invoice->status; ?></td>
						
						<?php if($data_role[0]['delete_invoice']=='yes' || $data_role[0]['edit_invoice']=='yes'){ ?>
						<td>
						<a  class=" link_action" id="<?php echo $data_invoice->id_invoice; ?>" target='_blank' href='<?php echo BASE_URL()."index.php/invoice/detailInvoice?id_invoice=".$data_invoice->id_invoice; ?>' >Detail</a> | 
						<?php if($data_role[0]['delete_invoice']=='yes'){ ?><a  class="delete_data link_action" id="<?php echo $data_invoice->id_invoice; ?>" >Delete</a><?php } ?> | <?php if($data_role[0]['edit_invoice']=='yes'){ ?><a  id="<?php echo $data_invoice->id_invoice; ?>" class="edit_data link_action">Update Status Invoice</a><?php } ?></td>
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
