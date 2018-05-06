 <!-- HEADER -->
 <section class="content-header">
          <h1>
            New IO
            <small>List Of New IO</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="<?php echo BASE_URL(); ?>"><i class="fa fa-dashboard"></i>Home</a></li>
            <li><a href="<?php echo BASE_URL()."io"; ?>"><i class="fa fa-dashboard"></i>New IO</a></li>
          </ol>
        </section>
  
  
   <!-- Content -->
   <section class="content">
		
		
  
  
          <div class="box sms box-default color-palette-box">
            <div class="box-header with-border">
              <h3 class="box-title"><i class="fa fa-table"></i>Table New IO</h3>
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
                             <form action="<?php echo base_url()."index.php/io" ?>" method="get">
                             <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                                <input type="text" id="search" name="search" placeholder="Search..."  value="<?php echo $search; ?>" />
                                <input type="submit" id="submit"  value="Search"/>
                                <?php if($search!="")
								{?>
                                <a href="<?php echo base_url()."index.php/io" ?>" id="clear-search">Clear Search</a>
                                <?php } ?>
                             </form>
                </div>
                <div id="wrapper-button" class="clearfix">
					<?php if($data_role[0]['export_io']=='yes'){ ?>
                	<a href="<?php echo base_url()."index.php/io/exportPr?search=".$search; ?>" class="button orange-button">
                    	Export IO
                    </a>
					
					<?php } ?>
                    <?php if($data_role[0]['add_io']=='yes'){ ?>
                    <a id="add-data" class="button green-button">
                    	Create IO
                    </a>
					<?php } ?>
					<?php if($data_role[0]['delete_io']=='yes'){ ?>
                    <a id="delete-data" class="button btn-danger deletelogg">
                    	Delete IO
                    </a>
					<?php } ?>
					
                </div>
                </div>
            <div id="wrapper-console" class="clearfix"> 
            <div class="grid_4 height400">                  
           		<table id="myTable04" class="fancyTable table table-bordered table-hover">
                    <thead>
                      <tr>
                        <th><div class="mid"><div class="check-box-div">
						<input type="checkbox" name="select_all" id="select_all">
						</div>ID IO</div></th>
                        <th>Request Date</th>
                        <th>Division Code</th>
						<th>Division Name</th>
						<th>Description</th>
						<th>Status IO</th>
						<th>IO Type</th>
						<th>Created By</th>
						<th>Created Time</th>
						<th>Updated By</th>
						<th>Updated Time</th>
						
						<?php if($data_role[0]['delete_io']=='yes' || $data_role[0]['edit_io']=='yes'){ ?>
						<th><div class="mid">Action</div></th>
						<?php } ?>
                      </tr>
                    </thead>
             		<tbody>
                    <?php foreach($data_io as $data_io) {?>
                    <tr id="data_<?php echo $data_io->id_io; ?>">
                    	<td class="id_io">
						<div class="check-box-div">
						<?php if($data_io->status_io=='new'){ ?>
						<input type="checkbox" name="id_checkbox[]" class="iCheck-helper toedit checkbox_satuan" value="<?php echo $data_io->id_io; ?>" />
						<?php } ?>
						</div><span><?php echo $data_io->id_io; ?></span></td>
						
                        <td class="request_date"><?php convert_date($data_io->request_date); ?></td>
                        <td class="division_code"><?php echo $data_io->division_code; ?></td>
						<td class="division_name"><?php echo $data_io->division_name; ?></td>
						<td class="description"><?php echo $data_io->description; ?></td>
						<td class="status_io"><?php echo $data_io->status_io; ?></td>
						<td class="io_type"><?php echo $data_io->io_type; ?></td>
						<td class="created_by"><?php echo $data_io->created_by; ?></td>
						<td class="created_time"><?php echo $data_io->created_time; ?></td>
						<td class="updated_by"><?php echo $data_io->updated_by; ?></td>
						<td class="updated_time"><?php echo $data_io->updated_time; ?></td>
						
						
						<?php if($data_role[0]['delete_io']=='yes' || $data_role[0]['edit_io']=='yes'){ ?>
						<td><?php if($data_io->status_io=='new'){ ?><?php if($data_role[0]['delete_io']=='yes'){ ?><a  class="delete_data link_action" id="<?php echo $data_io->id_io; ?>" >Delete</a><?php } ?> | <?php if($data_role[0]['edit_io']=='yes'){ ?><a  id="<?php echo $data_io->id_io; ?>" class="edit_data link_action">Edit</a><?php } ?>
						| <?php } ?><?php if($data_role[0]['see_io']=='yes'){ ?><a  id="<?php echo $data_io->id_io; ?>" class="detail_data link_action">Detail</a><?php } ?></td>
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
		<h2 id="modal1Title">Create IO</h2>
				<form role="form" id="form_add_data" method="POST" action="<?php echo base_url()."index.php/io/addIo" ?>" enctype="multipart/form-data">
				 <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
				 
              <div class="box-body form">
		  
				
				
				 <div class="form-group">
					  <label for="drivercode2">Inventory Order Type</label>
					  <select class="form-control" name="io_type" id="io_type" required>
						<option selected="selected" value="">Choose Inventory Order Type</option>
						<option value="assets">Assets</option>
						<option value="selling">Seling</option>
					  </select> 
					</div>
					
				<div class="form-group">
					  <label for="drivercode2">Request Date</label>
						  <div class="input-group date">
						  <div class="input-group-addon">
							<i class="fa fa-calendar"></i>
						  </div>
						  <input type="text" name="request_date" class="form-control pull-right datepicker" id="request_date" required>
						</div>
				</div>
				
				
				<div class="form-group">
					  <label for="drivercode2">Select Division</label>
					  <select class="form-control required" name="division" id="division" >
						<option selected="selected" value="">Choose Division</option>
						<?php foreach($data_division as $data_division1) {?>
						<option value="<?php echo $data_division1->division_code; ?>*<?php echo $data_division1->division_name; ?>"><?php echo $data_division1->division_name; ?></option>
						<?php } ?>
					  </select> 
				</div>
					
			  
			  
			  <div class="form-group">
                  <label for="drivercode2">Description</label>
                 <textarea class="form-control required" name="description" id="description"></textarea>
                </div>
				
				
              <!-- /.box-body -->
				<div class="clearfix"></div>

					 <h2 class="table-title">List Of Item</h2>
					 
					 <div class="form-group add_product">
						<div class="input-group">
						  <div class="input-group-addon">
							<i class="fa fa-search"></i>
						  </div>
						  <input type="text" class="form-control pull-right" name="add_io_product" id="add_io_product" placeholder='add by product code or name'>
						</div>
						<!-- /.input group -->
					</div>
					
					 <button type="button" class='delete'>Delete</button>
					 <div class="box-body table clearfix">
						
						<table class="po" id='table_add_io'>
							<tr>
							<th><input class='check_all' type='checkbox' onclick="select_all()"/></th>
							<th>Line</th>
							<th>Product ID</th>
							<th>Description</th>
							<th>Warehouse</th>
							<th>Location</th>
							<th>Price</th>
							<th>Stock</th>
							<th>Order</th>
							
							</tr>
						</table>
						
						
					</div>
              <div class="box-footer">
                <button data-remodal-action="cancel" class="remodal-cancel">Cancel</button>
				<input type="submit" name="submit_add" class="remodal-confirm" value="Submit" id="submit_add">
              </div>
            </form>
	  </div>
	  <br>
	  
	</div>
	</div>
	
	
	
	<div class="remodal" data-remodal-id="modal_edit" role="dialog" aria-labelledby="modal1Titl aria-describedby="modal1Desc">
	  <button data-remodal-action="close" class="remodal-close" aria-label="Close"></button>
	  <div>
		<h2 id="modal1Title">Edit IO</h2>
				<form role="form" id="form_edit_data" method="POST" action="<?php echo base_url()."index.php/io/editIo" ?>" enctype="multipart/form-data">
				 <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
				 
              <div class="box-body form">
				
				
				 <div class="form-group">
					  <label for="drivercode2">Inventory Order Type</label>
					  <select class="form-control" name="edit_io_type" id="edit_io_type" required>
						<option selected="selected" value="">Choose Inventory Order Type</option>
						<option value="assets">Assets</option>
						<option value="selling">Seling</option>
					  </select> 
					</div>
					
					
				<div class="form-group">
					  <label for="drivercode2">PO Status</label>
					  <select class="form-control" name="edit_status_io" id="edit_status_io" required>
						<option selected="selected" value="">Choose Po Status</option>
						<option value="approved">Approved</option>
						<option value="not_approved">Not Approved</option>
					  </select> 
					</div>
				<div class="form-group">
					  <label for="drivercode2">Request Date</label>
						  <div class="input-group date">
						  <div class="input-group-addon">
							<i class="fa fa-calendar"></i>
						  </div>
						  <input type="text" name="edit_request_date" class="form-control pull-right datepicker" id="edit_request_date" required>
						</div>
				</div>
				
				
				<div class="form-group">
					  <label for="drivercode2">Select Division</label>
					  <select class="form-control required" name="edit_division" id="edit_division" >
						<option selected="selected" value="">Choose Division</option>
						<?php foreach($data_division as $data_division2) {?>
						<option value="<?php echo $data_division2->division_code; ?>*<?php echo $data_division2->division_name; ?>"><?php echo $data_division2->division_name; ?></option>
						<?php } ?>
					  </select> 
				</div>
					
			  
			  
			  <div class="form-group">
                  <label for="drivercode2">Description</label>
                 <textarea class="form-control required" name="edit_description" id="edit_description"></textarea>
                </div>
				
				
              <!-- /.box-body -->
				<div class="clearfix"></div>

					 <h2 class="table-title">List Of Item</h2>
					 
					
					 <div class="box-body table clearfix">
						
						<table class="po" id='table_edit_io'>
						<thead>
							<tr>
							<th>Line</th>
							<th>Product ID</th>
							<th>Description</th>
							<th>Warehouse</th>
							<th>Location</th>
							<th>Price</th>
							<th>Order</th>
							<th>Order Approved</th>
							<th>Approval</th>
							</tr>
							</thead>
							<tbody>
							</tbody>
						</table>
						
						<input type="hidden" name="id_io_update" id="id_io_update" value=''>
					</div>
              <div class="box-footer">
                <button data-remodal-action="cancel" class="remodal-cancel">Cancel</button>
				<input type="submit" name="submit_add" class="remodal-confirm" value="Submit" id="submit_add">
              </div>
            </form>
	  </div>
	  <br>
	  
	</div>
	</div>
	
	
	
	<div class="remodal" data-remodal-id="modal_delete" role="dialog" aria-labelledby="modal1Titl aria-describedby="modal1Desc">
	  <button data-remodal-action="close" class="remodal-close" aria-label="Close"></button>
	  <div>
		<h2 id="modal1Title">Delete IO</h2>
				<form role="form" id="form_delete_data" method="POST" action="<?php echo base_url()."index.php/io/deletePr" ?>" enctype="multipart/form-data">
				 <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
				 
              <div class="box-body">

				 <div class="form-group">
                     <p>Are you sure want to delete this data? (<span id="reference_delete"> </span>)</p>
				</div>
				
				 <div class="form-group">
                      <input type="hidden" name="id_io_delete" id="id_io_delete" class="form-control" value="" />
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
		<h2 id="modal1Title">Delete IO</h2>
				<form role="form" id="form_selected_delete_data" method="POST" action="<?php echo base_url()."index.php/io/deletePrAll" ?>" enctype="multipart/form-data">
				 <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
				 
              <div class="box-body">
				 <div class="form-group">
                     <p>Are you sure want to delete selected data? </p>
				</div>
				 <div class="form-group">
                      <input type="hidden" name="id_io_delete_all" id="id_io_delete_all" class="form-control" value="" />
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
	
	
	
	<div class="remodal" data-remodal-id="modal_detail" role="dialog" aria-labelledby="modal1Titl aria-describedby="modal1Desc">
	  <button data-remodal-action="close" class="remodal-close" aria-label="Close"></button>
	  <div>
		<h2 id="modal1Title">Detail IO</h2>
				<div class="box-body">

				<div class="form-group">
					  <label for="drivercode2">ID IO :</label>
					  <div class='text_description' id='detail_id_io'></div>
				</div>
				
				<div class="form-group">
					  <label for="drivercode2">Request Date :</label>
					  <div class='text_description' id='detail_request_date'></div>
				</div>
				
				<div class="form-group">
					  <label for="drivercode2">Description :</label>
					  <div class='text_description' id='detail_description'></div>
				</div>
				
				<div class="form-group">
					  <label for="drivercode2">Status IO :</label>
					  <div class='text_description' id='detail_status_io'></div>
				</div>
				
				<div class="form-group">
					  <label for="drivercode2">Division Name :</label>
					  <div class='text_description' id='detail_division_name'></div>
				</div>
				
				<div class="form-group">
					  <label for="drivercode2">Request By :</label>
					  <div class='text_description' id='detail_request_by'></div>
				</div>
				<div class='clearfix' style='margin-top:10px;'></div>
				<h3>Table Product Orders</h3>
				
				<table class='po' id='table_detail_io'>
					<thead>
					<tr>
							
							<th>Line</th>
							<th>Product ID</th>
							<th>Description</th>
							<th>Warehouse</th>
							<th>Location</th>
							<th>Price</th>
							<th>Qty Order</th>
					</tr>	
					</thead>
					<tbody>
					</tbody>
				</table>
				
				</div>
	</div>
	</div>
		
  <script>
			//Date picker
			$('.datepicker').datepicker({
			  autoclose: true,
			  Format: 'dd-mm-yyyy'
			});
			
			$(".delete_data").click(function(){
				var id = $(this).attr('id');
				var id_io =  $('#data_'+id+' .id_io span').text();
				$("#reference_delete").text("ID IO "+id_io)
				$("#id_io_delete").val(id_io);
			});
			
			$(".edit_data").click(function(){
				var id = $(this).attr('id');
				var id_io =  $('#data_'+id+' .id_io span').text();
				var request_date =  $('#data_'+id+' .request_date').text();
				var division_code =  $('#data_'+id+' .division_code').text();
				var division_name =  $('#data_'+id+' .division_name').text();
				var status_io =  $('#data_'+id+' .status_io').text();
				var created_by =  $('#data_'+id+' .created_by').text();
				var description =  $('#data_'+id+' .description').text();
				var io_type =  $('#data_'+id+' .io_type').text();
				
				var status_io =  $('#data_'+id+' .status_io').text();
				
				$('#edit_status_io option[value="'+status_io+'"]').prop('selected',true);
				$('#edit_io_type option[value="'+io_type+'"]').prop('selected',true);
				
				$("#id_io_update").val(id_io);
				$("#edit_request_date").val(request_date);
				$("#edit_description").val(description);
				$('#edit_division option[value="'+division_code+'*'+division_name+'"]').prop('selected',true);
				$("#id_io_update").val(id_io);
				
				
				$.ajax({
				  url: '<?php echo BASE_URL(); ?>/index.php/json/jsonProductIo?id_io='+id_io,
				  success: function(data,status)
				  {
					$("#table_edit_io tbody tr").remove();  
					createTableEdit(data);
				  },
				  async:   true,
				  dataType: 'json'
				}); 
				
				
			});
			
			
			function createTableEdit(data)
			{
			  for(var i=0; i<data.length;i++)
			  {
					var no = i + 1;
					var j = i + 2;
					$("#table_edit_io tbody").append("<tr id='product_"+data[i]['id_inventory_list']+"' >"+
													 "<td>"+no+"</td>"+
													 "<td><input type='hidden' class='order' name=id_product[] value='"+data[i]['id_product']+"' >"+data[i]['id_product']+"</td>"+
													 "<td>"+data[i]['product_name']+"</td>"+
													 "<td><input type='hidden' class='order' name=id_location[] value='"+data[i]['id_location']+"' >"+data[i]['warehouse_code']+"</td>"+
													 "<td><input type='hidden' class='product' name=product_code[] value='"+data[i]['product_code']+"' ><input type='hidden' class='product' name=product_description[] value='"+data[i]['product_description']+"' >"+data[i]['location_code']+"-"+data[i]['location_type']+"</td>"+
													 "<td><input type='hidden' class='price' name=price[] value='"+data[i]['price']+"' >"+data[i]['price']+"</td>"+
													 "<td>"+data[i]['qty']+"</td>"+
													 "<td><input type='text' class='qty_approved_io' name='qty_approved[]' value='"+data[i]['qty_approved']+"'></td>"+
													 "<td><select name='status_io[]' id='status_io"+j+"'>"+
													 "<option value='not_approved'>Not Approved</option>"+
													 "<option value='approved'>Approved</option>"+
													 "</select></td>"+
													 "</tr>");
					$('#status_io_'+j+' option[value="'+data[i]['status_approved']+'"]').prop('selected',true);
			  }
			 
			}
			
			
			
			$(".detail_data").click(function(){
				
				 
				 
				var id = $(this).attr('id');
				var id_io =  $('#data_'+id+' .id_io span').text();
				var request_date =  $('#data_'+id+' .request_date').text();
				var division_name =  $('#data_'+id+' .division_name').text();
				var status_io =  $('#data_'+id+' .status_io').text();
				var created_by =  $('#data_'+id+' .created_by').text();
				var description =  $('#data_'+id+' .description').text();
				
				$("#detail_id_io").text(id_io);
				$("#detail_request_date").text(request_date);
				$("#detail_division_name").text(division_name);
				$("#detail_status_io").text(status_io);
				$("#detail_request_by").text(created_by);
				$("#detail_description").text(description);
				
				
				$.ajax({
				  url: '<?php echo BASE_URL(); ?>/index.php/json/jsonProductIo?id_io='+id_io,
				  success: function(data,status)
				  {
					$("#table_detail_io tbody tr").remove();  
					createTableDetail(data);
				  },
				  async:   true,
				  dataType: 'json'
				}); 
				
				
			})
			
			function createTableDetail(data)
			{
			  for(var i=0; i<data.length;i++)
			  {
					var no = i + 1;
					
					$("#table_detail_io tbody").append("<tr id='product_"+data[i]['id_inventory_list']+"' >"+
														 "<td>"+no+"</td>"+
														 "<td>"+data[i]['id_product']+"</td>"+
														 "<td>"+data[i]['product_name']+"</td>"+
														 "<td>"+data[i]['warehouse_code']+"</td>"+
														 "<td>"+data[i]['location_code']+"-"+data[i]['location_type']+"</td>"+
														 "<td>"+data[i]['price']+"</td>"+
														 "<td>"+data[i]['qty']+"</td></tr>");
			  }
			 
			}

			$("#form_add_data").validate({
				messages: {
				io_type: {
				required: 'IO type Date must be filled!'
				},
				request_date: {
				required: 'Request Date must be filled!'
				},
				division: {
				required: 'Division must be filled!'
				},
				Description: {
				required: 'Description must be filled!'
				}
				
			}
			});
			
			
			
			$("#form_edit_data").validate({
				messages: {
				edit_io_type: {
				required: 'IO type Date must be filled!'
				},
				edit_request_date: {
				required: 'Request Date must be filled!'
				},
				edit_division: {
				required: 'Division must be filled!'
				},
				edit_Description: {
				required: 'Description must be filled!'
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
		$("#id_io_delete_all").val(ids);
		
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



$(".detail_data").click(function(){
	$('[data-remodal-id = modal_detail]').remodal().open();
});

</script>
<script>
		//auto complete io
		var term = $("#io_code").val();
        $( "#io_code" ).autocomplete({
         source: "<?php echo BASE_URL(); ?>/index.php/json/jsonio?term="+term,  
         minLength:0,
		 select: function( event , ui ) {
			  $( "#io_code" ).val( ui.item.label );
			  $( "#id_io" ).val( ui.item.id_io );
			  $( "#io_name" ).val( ui.item.io_name );
			  $( "#io_address" ).val( ui.item.address_1 );
			 
        }    
        })
		.autocomplete( "instance" )._renderItem = function( ul, item ) {
		  return $( "<li style='position:relative; z-index:9999;'>" )
			.append( "<div style='font-size:10px;'>" + item.label + "<br>" + item.io_name + "<br>" + item.address_1 +"</div>" )
			.appendTo( ul );
		};
		
		
		
		//auto complete product
		var term = $("#add_io_product").val();
        $('#add_io_product').autocomplete({
         source: "<?php echo BASE_URL(); ?>/index.php/json/jsonInventoryList?term="+term,  
         minLength:0,
		 select: function( event , ui ) {
			  
			  var id_inventory_list = ui.item.id_inventory_list;
			  var id_product = ui.item.id_product;
			  var product_code = ui.item.product_code;
			  var product_description = ui.item.product_name;
			  var warehouse_code = ui.item.warehouse_code;
			  var location_code = ui.item.location_code;
			  var location_type = ui.item.location_type;
			  var id_location = ui.item.id_location;
			  var stock = ui.item.stock;
			  var price = ui.item.price;
			  
           	  addrow(price,id_location,id_inventory_list,product_code,id_product,product_description,warehouse_code,location_code,location_type,stock);
			 
			 
        }    
        })
		.autocomplete( "instance" )._renderItem = function( ul, item ) {
		  return $( "<li style='position:relative; z-index:9999;'>" )
			.append( "<div style='font-size:10px;'>" + item.label +"</div>" )
			.appendTo( ul );
		};
		
		
		
		
		
		
			//auto complete product
		var term = $("#edit_product_io").val();
        $('#edit_product_io').autocomplete({
         source: "<?php echo BASE_URL(); ?>/index.php/json/jsonproduct?term="+term,  
         minLength:0,
		 select: function( event , ui ) {
			 
			  var product_code = ui.item.label;
			  var id_product = ui.item.id_product;
			  var product_description = ui.item.product_description;
			  var base_uom = ui.item.base_uom;
			  var price = ui.item.price;
           	  //addrowedit(product_code,id_product,product_description,base_uom,price);
			  alert1();
			 
        }    
        })
		.autocomplete( "instance" )._renderItem = function( ul, item ) {
		  return $( "<li style='position:relative; z-index:9999;'>" )
			.append( "<div style='font-size:10px;'>" + item.label + "<br>" + item.product_description +"</div>" )
			.appendTo( ul );
		};
		
		
		
		//auto complete warehouse
		var term = $("#warehouse_code").val();
        $( "#warehouse_code" ).autocomplete({
         source: "<?php echo BASE_URL(); ?>/index.php/json/jsonWarehouse?term="+term,  
         minLength:0,
		 select: function( event , ui ) {
			  $( "#warehouse_code" ).val( ui.item.label );
			  $( "#id_warehouse" ).val( ui.item.id_warehouse );
			 
        }    
        })
		.autocomplete( "instance" )._renderItem = function( ul, item ) {
		  return $( "<li style='position:relative; z-index:9999;'>" )
			.append( "<div style='font-size:10px;'>" + item.label +"</div>" )
			.appendTo( ul );
		};
		
		
		//auto complete Description
		var term = $("#order_description").val();
        $( "#order_description" ).autocomplete({
         source: "<?php echo BASE_URL(); ?>/index.php/json/jsonOrderType?term="+term,  
         minLength:0,
		 select: function( event , ui ) {
			  $( "#order_description" ).val( ui.item.label );
			  $( "#id_order_type" ).val( ui.item.id_order_type );
			 
        }    
        })
		.autocomplete( "instance" )._renderItem = function( ul, item ) {
		  return $( "<li style='position:relative; z-index:9999;'>" )
			.append( "<div style='font-size:10px;'>" + item.label +"</div>" )
			.appendTo( ul );
		};
		
function alert1()
{ alert("hai");}
$(".delete").on('click', function() {
	$('.case:checkbox:checked').parents("tr").remove();
    $('.check_all').prop("checked", false); 
	check();

});
var i=2;


function addrow(price,id_location,id_inventory_list,product_code,id_product,product_description,warehouse_code,location_code,location_type,stock){
		count=$('#table_add_io tr').length;
		var data="<tr id='product_"+id_inventory_list+"' ><td><input  class='case' type='checkbox' /></td>"+
				 "<td>"+count+"</td>"+
				 "<td><input type='hidden' class='order' name=id_product[] value='"+id_product+"' >"+id_product+"</td>"+
				 "<td>"+product_description+"</td>"+
				 "<td><input type='hidden' class='order' name=id_location[] value='"+id_location+"' >"+warehouse_code+"</td>"+
				 "<td><input type='hidden' class='product' name=product_code[] value='"+product_code+"' ><input type='hidden' class='product' name=product_description[] value='"+product_description+"' >"+location_code+"-"+location_type+"</td>"+
				 "<td><input type='hidden' class='price' name=price[] value='"+price+"' >"+price+"</td>"+
				 "<td>"+stock+"</td>"+
				 "<td><input type='text' class='order' name=order[] value='0' ></td></tr>";
		
		//var status_product = $(this).find("tr#product_"+id_product+" .status_invoice" ).text();
		if( $("#table_add_io tr#product_"+id_inventory_list).length ) 
		{
			alert("Sorry Product has been entered before!");
			}	
		else{
		$('#table_add_io tbody').append(data);
		i++;
		}
}


function addrowedit(product_code,id_product,product_description,base_uom,price){
	count=$('#table_edit_io tr').length;
    var data="<tr id='product_"+id_product+"'><td><input type='checkbox' class='case'/></td><td><span id='snum"+i+"'>"+count+".</span></td>";
    data +="<td><input type='hidden' name='edit_id_product[]' id='id_product_"+i+"' class='id_product' id_row='"+i+"' value='"+id_product+"' ><input type='hidden' name='edit_product_code[]' id='product_code_"+i+"' class='product_code_' id_row='"+i+"' value='"+product_code+"' ><span id='product_code_span_"+i+"'>"+product_code+"<span></td><td><span id='description_"+i+"'>"+product_description+"<span></td><td><input type='hidden' name='edit_product_description[]' id='product_description_"+i+"' class='product_description' id_row='"+i+"' value='"+product_description+"' ><input type='hidden' name='edit_price[]' id='price_"+i+"' class='price' id_row='"+i+"' value='"+price+"' ><input type='text' name='edit_qty[]' id='qty_"+i+"' class='qty' id_row='"+i+"' value='0' ></td><td><span id='price_"+i+"'>"+price+"<span></td><td><span id='uom_"+i+"'>"+base_uom+"<span></td></tr>";
	
	//var status_product = $(this).find("tr#product_"+id_product+" .status_invoice" ).text();
	if( $("table#table_edit_io tr#product_"+id_product).length ) 
	{
		alert("Sorry Product has been entered before!");
		}	
	else{
	$('table#table_edit_io').append(data);
	i++;
	}
}



function select_all() {
	$('input[class=case]:checkbox').each(function(){ 
		if($('input[class=check_all]:checkbox:checked').length == 0){ 
			$(this).prop("checked", false);
		} else {
			$(this).prop("checked", true); 
		} 
	});
}

function check(){
	obj=$('table#table_add_io tr').find('span');
	$.each( obj, function( key, value ) {
	id=value.id;
	$('#'+id).html(key+1);
	});
	}

</script>




<script>
$(".edit_delete").on('click', function() {
	$('.edit_case:checkbox:checked').parents("tr").remove();
    $('.edit_check_all').prop("checked", false); 
	check();

});
var i=2;



</script>
