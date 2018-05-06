 <!-- HEADER -->
 <section class="content-header">
          <h1>
            New PO
            <small>List Of New PO</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="<?php echo BASE_URL(); ?>"><i class="fa fa-dashboard"></i>Home</a></li>
            <li><a href="<?php echo BASE_URL()."po"; ?>"><i class="fa fa-dashboard"></i>New PO</a></li>
          </ol>
        </section>
  
  
   <!-- Content -->
   <section class="content">
		
		
  
  
          <div class="box sms box-default color-palette-box">
            <div class="box-header with-border">
              <h3 class="box-title"><i class="fa fa-table"></i>Table New PO</h3>
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
                             <form action="<?php echo base_url()."index.php/po" ?>" method="get">
                             <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                                <input type="text" id="search" name="search" placeholder="Search..."  value="<?php echo $search; ?>" />
                                <input type="submit" id="submit"  value="Search"/>
                                <?php if($search!="")
								{?>
                                <a href="<?php echo base_url()."index.php/po" ?>" id="clear-search">Clear Search</a>
                                <?php } ?>
                             </form>
                </div>
                <div id="wrapper-button" class="clearfix">
					<?php if($data_role[0]['export_po']=='yes'){ ?>
                	<a href="<?php echo base_url()."index.php/po/exportPo?search=".$search; ?>" class="button orange-button">
                    	Export PO
                    </a>
					
					<?php } ?>
                    <?php if($data_role[0]['add_po']=='yes'){ ?>
                    <a id="add-data" class="button green-button">
                    	Create PO
                    </a>
					<?php } ?>
					<?php if($data_role[0]['delete_po']=='yes'){ ?>
                    <a id="delete-data" class="button btn-danger deletelogg">
                    	Delete PO
                    </a>
					<?php } ?>
					
                </div>
                </div>
            <div id="wrapper-console" class="clearfix"> 
            <div class="grid_4 height400">                  
           	<table id="myTable04" class="fancyTable table table-bordered table-hover">
                    <thead>
                      <tr>
                        <th>
						<div class="mid">
						<div class="check-box-div"><input type="checkbox" name="select_all" id="select_all"></div>PO ID
						</div></th>
                        <th>Reference</th>
                        <th>Create PO Date</th>
						<th>Request Date</th>
						<th>Supplier</th>
						<th>Status</th>
						<th>Warehouse</th>
						<th>Order Type</th>
						<th>Supplier DO</th>
						<th>Created By</th>
						<th>Created Time</th>
						<th>Updated By</th>
						<th>Updated Time</th>
						<?php if($data_role[0]['delete_po']=='yes' || $data_role[0]['edit_po']=='yes'){ ?>
						<th>Action</th>
						<?php } ?>
                      </tr>
                    </thead>
             		<tbody>
					
					
                    <?php foreach($data_po as $data_po) {?>
                    <tr id="data_<?php echo $data_po->id_po; ?>">
                    	<td class="id_po">
						<div class="check-box-div">
						<?php if($data_po->status_gr=='new'){ ?>
						<input type="checkbox" name="id_checkbox[]" class="iCheck-helper toedit checkbox_satuan" value="<?php echo $data_po->id_po; ?>" />
						<?php } ?>
						</div><span><?php echo $data_po->id_po; ?></span></td>
                        <td class="reference"><?php echo $data_po->reference; ?></td>
                        <td class="create_po_date"><?php convert_date($data_po->create_po_date); ?></td>
						<td class="request_date"><?php echo convert_date($data_po->request_date); ?></td>
                        <td class="supplier_code">
						<span class='supplier_code'><?php echo $data_po->supplier_code; ?></span>
						<span class='supplier_name' style='display:none;'><?php echo $data_po->supplier_name; ?></span>
						<span class='supplier_address' style='display:none;'><?php echo $data_po->address_1; ?></span>
						</td>
						
						<td class="status"><?php echo $data_po->status; ?></td>
						<td class="warehouse_code"><?php echo $data_po->warehouse_code; ?></td>
						<td class="order_type"><?php echo $data_po->order_type; ?></td>
						<td class="supplier_do"><?php echo $data_po->supplier_do; ?></td>
						
						<td class="created_by"><?php echo $data_po->created_by; ?></td>
						<td class="created_time"><?php echo $data_po->created_time; ?></td>
						<td class="updated_by"><?php echo $data_po->updated_by; ?></td>
						<td class="updated_time"><?php echo $data_po->updated_time; ?></td>
						
						
						<?php if($data_role[0]['delete_po']=='yes' || $data_role[0]['edit_po']=='yes'){ ?>
						<td>
						<?php if($data_po->status_gr=='new'){ ?>
						<?php if($data_role[0]['delete_po']=='yes'){ ?><a  class="delete_data link_action" id="<?php echo $data_po->id_po; ?>" >Delete</a><?php } ?> | <?php if($data_role[0]['edit_po']=='yes'){ ?><a  id="<?php echo $data_po->id_po; ?>" class="edit_data link_action">Edit</a> | <?php } ?>
						<?php } ?>
						<?php if($data_role[0]['see_po']=='yes'){ ?><a  id="<?php echo $data_po->id_po; ?>" class="detail_data link_action">Detail</a><?php } ?>
						</td>
						
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
		<h2 id="modal1Title">Create PO</h2>
				<form role="form" id="form_add_data" method="POST" action="<?php echo base_url()."index.php/po/addPo" ?>" enctype="multipart/form-data">
				 <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
				 
              <div class="box-body form">
		  
		  
				<div class="left-form clearfix">
					
					<div class="form-group">
					 <label>PR Reference</label>
						<div class="input-group">
						  <div class="input-group-addon">
							<i class="fa fa-search"></i>
						  </div>
						  <input type="text" class="form-control pull-right" name="search_pr_reference" id="search_pr_reference" value=''n placeholder='Search PR Reference'>
						  <input type="text" readonly class="form-control" name="id_pr" id="id_pr" placeholder='ID PR' required>
						</div>
						<!-- /.input group -->
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
					 <label>Supplier Code:</label>
						<div class="input-group">
						  <div class="input-group-addon">
							<i class="fa fa-search"></i>
						  </div>
						  <input type="text" class="form-control pull-right" name="search_supplier_code" id="search_supplier_code" placeholder='Search Supplier Code'>
						  <input type="hidden" class="form-control" name="id_po" id="id_po" required>
						</div>
						<!-- /.input group -->
					</div>
					
					
					<div class="form-group">
					 <input type="text" class="form-control" readonly name="supplier_code" id="supplier_code" placeholder='Supplier Code' required>
					</div>
					
					
					<div class="form-group">
					 <input type="text" class="form-control" readonly name="supplier_name" id="supplier_name" placeholder='Po Name' required>
					</div>
					
					<div class="form-group">
					 <input type="text" class="form-control" readonly name="supplier_address" id="supplier_address" placeholder='Po Address' required>
					</div>
					
					
				</div>
				
				<div class="right-form clearfix">
					
					
				
					
					<div class="form-group">
					 <label>Warehouse Code:</label>
						<div class="input-group">
						  <div class="input-group-addon">
							<i class="fa fa-search"></i>
						  </div>
						  <input type="text" class="form-control pull-right" name="search_warehouse_code" id="search_warehouse_code" value=''n placeholder='Search Warehouse Code'>
						  <input type="text"  readonly class="form-control pull-right" name="warehouse_code" id="warehouse_code" required>
						</div>
						<!-- /.input group -->
					</div>
					
					
					
					<div class="form-group">
					 <label>Order type:</label>
						<div class="input-group">
						  <div class="input-group-addon">
							<i class="fa fa-search"></i>
						  </div>
						  <input type="text" class="form-control pull-right" name="search_order_description" id="search_order_description" value=''n placeholder='Search Order Type'>
						  <input type="text"  readonly class="form-control pull-right" name="order_description" id="order_description" required>
						</div>
						<!-- /.input group -->
					</div>
					
					
					<div class="form-group">
					  <label for="drivercode2">Supplier DO</label>
					 <input type="text" class="form-control" name="supplier_do" id="supplier_do" required>
					</div>
					
					<div class="form-group">
					  <label for="drivercode2">Po Date</label>
						  <div class="input-group date">
						  <div class="input-group-addon">
							<i class="fa fa-calendar"></i>
						  </div>
						  <input type="text" name="po_date" id="po_date" class="form-control pull-right datepicker"  required>
						</div>
					</div>
						
						
				 
				
               
              
              </div>
              <!-- /.box-body -->
				<div class="clearfix"></div>

					 <h2 class="table-title">List Of Item</h2>
					 
					 <div class="form-group add_product">
						<div class="input-group">
						  <div class="input-group-addon">
							<i class="fa fa-search"></i>
						  </div>
						  <input type="text" class="form-control pull-right" name="add_product_po" id="add_product_po" placeholder='add by product code or name'>
						</div>
						<!-- /.input group -->
					</div>
					
					 <button type="button" class='delete'>Delete</button>
					 <div class="box-body table clearfix">
						
						<table id='table_add_po' class="po">
						<thead>
							<tr>
							<th><input class='check_all' type='checkbox' onclick="select_all()"/></th>
							<th>Line</th>
							<th>Product ID</th>
							<th>Description</th>
							<th>Qty</th>
							<th>Price</th>
							<th>Custom Price</th>
							</tr>
						</thead>
						<tbody>
						</tbody>
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
		<h2 id="modal1Title">Edit PO</h2>
				<form role="form" id="form_edit_data" method="POST" action="<?php echo base_url()."index.php/po/editPo" ?>" enctype="multipart/form-data">
				 <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
              <div class="box-body">

				
				<div class="left-form clearfix">
					
					<div class="form-group">
					  <label for="drivercode2">ID PO</label>
					 <input type="text" readonly class="form-control" name="edit_id_po" id="edit_id_po" required>
					</div>
					
					
				
					
					<div class="form-group">
					  <label for="drivercode2">ID PR</label>
					 <input type="text" readonly class="form-control" name="edit_id_pr" id="edit_id_pr" required>
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
					 <label>Supplier Code:</label>
						<div class="input-group">
						  <div class="input-group-addon">
							<i class="fa fa-search"></i>
						  </div>
						  <input type="text" class="form-control pull-right" name="search_edit_supplier_code" id="search_edit_supplier_code" placeholder='Search Supplier Code'>
				
						</div>
						<!-- /.input group -->
					</div>
					
					
					<div class="form-group">
					 <input type="text" class="form-control" readonly name="edit_supplier_code" id="edit_supplier_code" placeholder='Supplier Code' required>
					</div>
					
					
					<div class="form-group">
					 <input type="text" class="form-control" readonly name="edit_supplier_name" id="edit_supplier_name" placeholder='Supplier Name' required>
					</div>
					
					<div class="form-group">
					 <input type="text" class="form-control" readonly name="edit_supplier_address" id="edit_supplier_address" placeholder='Supplier Address' required>
					</div>
					
					
				</div>
				
				<div class="right-form clearfix">
					
					
					 <div class="form-group">
					  <label for="drivercode2">PO Status</label>
					  <select class="form-control" name="edit_po_status" id="edit_po_status" required>
						<option selected="selected" value="">Choose Po Status</option>
						<option value="approved">Approved</option>
						<option value="not_approved">Not Approved</option>
					  </select> 
					</div>
					
					
					<div class="form-group">
					 <label>Warehouse Code:</label>
						<div class="input-group">
						  <div class="input-group-addon">
							<i class="fa fa-search"></i>
						  </div>
						  <input type="text" class="form-control pull-right" name="search_edit_warehouse_code" id="search_edit_warehouse_code" value=''n placeholder='Search Warehouse Code'>
						  <input type="text"  readonly class="form-control pull-right" name="edit_warehouse_code" id="edit_warehouse_code" required>
						</div>
						<!-- /.input group -->
					</div>
					
					
					
					<div class="form-group">
					 <label>Order type:</label>
						<div class="input-group">
						  <div class="input-group-addon">
							<i class="fa fa-search"></i>
						  </div>
						  <input type="text" class="form-control pull-right" name="search_edit_order_description" id="search_edit_order_description" value=''n placeholder='Search Order Type'>
						  <input type="text"  readonly class="form-control pull-right" name="edit_order_description" id="edit_order_description" required>
						</div>
						<!-- /.input group -->
					</div>
					
					
					<div class="form-group">
					  <label for="drivercode2">Supplier DO</label>
					 <input type="text" class="form-control" name="edit_supplier_do" id="edit_supplier_do" required>
					</div>
					
					<div class="form-group">
					  <label for="drivercode2">Po Date</label>
						  <div class="input-group date">
						  <div class="input-group-addon">
							<i class="fa fa-calendar"></i>
						  </div>
						  <input type="text" name="edit_po_date" id="edit_po_date" class="form-control pull-right datepicker"  required>
						</div>
					</div>
						
						
              </div>
						
						
				 
				
               
              
              </div>
              <!-- /.box-body -->
				<div class="clearfix"></div>

					 <h2 class="table-title">List Of Item</h2>
					 
					 <div class="form-group add_product">
						<div class="input-group">
						  <div class="input-group-addon">
							<i class="fa fa-search"></i>
						  </div>
						  <input type="text" class="form-control pull-right" name="add_edit_product_po" id="add_edit_product_po" placeholder='add by product code or name'>
						</div>
						<!-- /.input group -->
					</div>
					
					 <button type="button" class='delete'>Delete</button>
					 <div class="box-body table clearfix">
						
						<table id='table_edit_po' class="po">
						<thead>
							<tr>
							<th><input class='check_all' type='checkbox' onclick="select_all()"/></th>
							<th>Line</th>
							<th>Product ID</th>
							<th>Description</th>
							<th>Qty</th>
							<th>Qty Approved</th>
							<th>Price</th>
							<th>Custom Price</th>
							<th>Status</th>
							</tr>
						</thead>
						<tbody>
						</tbody>
						</table>
						
						
					</div>
              <div class="box-footer">
                <button data-remodal-action="cancel" class="remodal-cancel">Cancel</button>
				<input type="submit" name="submit_edit" class="remodal-confirm" value="Submit" id="submit_edit">
              </div>
            </form>
	  </div>
	  <br>
	  
	</div>
	</div>
	
	
	
	<div class="remodal" data-remodal-id="modal_delete" role="dialog" aria-labelledby="modal1Titl aria-describedby="modal1Desc">
	  <button data-remodal-action="close" class="remodal-close" aria-label="Close"></button>
	  <div>
		<h2 id="modal1Title">Delete PO</h2>
				<form role="form" id="form_delete_data" method="POST" action="<?php echo base_url()."index.php/po/deletePo" ?>" enctype="multipart/form-data">
				 <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
				 
              <div class="box-body">

				 <div class="form-group">
                     <p>Are you sure want to delete this data? (<span id="reference_delete"></span>)</p>
				</div>
				
				 <div class="form-group">
                      <input type="hidden" name="id_po_delete" id="id_po_delete" class="form-control" value="" />
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
		<h2 id="modal1Title">Delete PO</h2>
				<form role="form" id="form_selected_delete_data" method="POST" action="<?php echo base_url()."index.php/po/deletePoAll" ?>" enctype="multipart/form-data">
				 <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
				 
              <div class="box-body">
				 <div class="form-group">
                     <p>Are you sure want to delete selected data? </p>
				</div>
				 <div class="form-group">
                      <input type="hidden" name="id_po_delete_all" id="id_po_delete_all" class="form-control" value="" />
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
		<h2 id="modal1Title">Detail PO</h2>
				<div class="box-body">

				<div class="form-group">
					  <label for="drivercode2">ID PO :</label>
					  <div class='text_description' id='detail_id_po'></div>
				</div>
				
				<div class="form-group">
					  <label for="drivercode2">Request Date :</label>
					  <div class='text_description' id='detail_request_date'></div>
				</div>
				
				<div class="form-group">
					  <label for="drivercode2">Po :</label>
					  <div class='text_description' id='detail_po'></div>
				</div>
				
				<div class="form-group">
					  <label for="drivercode2">Status PO :</label>
					  <div class='text_description' id='detail_status_po'></div>
				</div>
				
				<div class="form-group">
					  <label for="drivercode2">Warehouse :</label>
					  <div class='text_description' id='detail_warehouse_code'></div>
				</div>
				
				<div class="form-group">
					  <label for="drivercode2">Order Type :</label>
					  <div class='text_description' id='detail_order_type'></div>
				</div>
				
				
				<div class="form-group">
					  <label for="drivercode2">Created PO Date :</label>
					  <div class='text_description' id='detail_created_po_date'></div>
				</div>
				
				<div class="form-group">
					  <label for="drivercode2">Created By :</label>
					  <div class='text_description' id='detail_created_by'></div>
				</div>
				
				
				<div class='clearfix' style='margin-top:10px;'></div>
				<h3>Table Product Orders</h3>
				
				<table class='po' id='table_detail_po'>
					<thead>
					<tr>
						<th>No</th>
						<th>Product Code</th>
						<th>Product Description</th>
						<th>Qty</th>
						<th>Qty Approved</th>
						<th>Price</th>
						<th>Custom Price</th>
						<th>Status</th>
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
				var id_po =  $('#data_'+id+' .id_po span').text();
				$("#reference_delete").text("ID PO:"+id_po)
				$("#id_po_delete").val(id_po);
			});
			
			
				$(".detail_data").click(function(){
				
				 
				 
				var id = $(this).attr('id');
				var id_po =  $('#data_'+id+' .id_po span').text();
				var request_date =  $('#data_'+id+' .request_date').text();
				var status =  $('#data_'+id+' .status').text();
				var create_po_date =  $('#data_'+id+' .create_po_date').text();
				var po_code =  $('#data_'+id+' .po_code').text();
				var warehouse_code =  $('#data_'+id+' .warehouse_code').text();
				var order_type =  $('#data_'+id+' .order_type').text();
				var created_by =  $('#data_'+id+' .created_by').text();
				
				
				$("#detail_id_po").text(id_po);
				$("#detail_request_date").text(request_date);
				$("#detail_po").text(po_code);
				$("#detail_status_po").text(status);
				$("#detail_warehouse_code").text(warehouse_code);
				$("#detail_order_type").text(order_type);
				$("#detail_created_po_date").text(create_po_date);
				$("#detail_created_by").text(created_by);
				
				$('#edit_po_status option[value="'+status+'"]').prop('selected',true);
				
				$.ajax({
				  url: '<?php echo BASE_URL(); ?>/index.php/json/jsonProductPo?id_po='+id_po,
				  success: function(data,status)
				  {
					$("#table_detail_po tbody tr").remove();  
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
					
					$("#table_detail_po tbody").append("<tr>"+
												"<td>"+no+"</td>"+
												"<td>"+data[i]['product_code']+"</td>"+
												"<td>"+data[i]['product_name']+"</td>"+
												"<td>"+data[i]['qty']+"</td>"+
												"<td>"+data[i]['qty_approve']+"</td>"+
												"<td>"+data[i]['price']+"</td>"+
												"<td>"+data[i]['custom_price']+"</td>"+
												"<td>"+data[i]['status_approved']+"</td>"+
												"</tr>");
			  }
			 
			}
			
			
			
			
			$(".edit_data").click(function(){
				var id = $(this).attr('id');
				var id_po =  $('#data_'+id+' .id_po span').text();
				var create_po_date =  $('#data_'+id+' .create_po_date').text();
				var id_pr =  $('#data_'+id+' .reference').text();
				var request_date =  $('#data_'+id+' .request_date').text();
				var supplier_code =  $('#data_'+id+' .supplier_code .supplier_code').text();
				
				var supplier_name =  $('#data_'+id+' .supplier_code .supplier_address').text();
				var supplier_address =  $('#data_'+id+' .supplier_code .supplier_name').text();
				
				var status =  $('#data_'+id+' .status').text();
				
				var warehouse_code =  $('#data_'+id+' .warehouse_code').text();
				var order_type =  $('#data_'+id+' .order_type').text();
				var supplier_do =  $('#data_'+id+' .supplier_do').text();
				
				$('#edit_po_status option[value="'+status+'"]').prop('selected',true);
				
				$("#edit_id_po").val(id_po);
				$("#edit_id_pr").val(id_pr);
				$("#edit_request_date").val(request_date);
				$("#edit_supplier_code").val(supplier_code);
				$("#edit_supplier_name").val(supplier_name);
				$("#edit_supplier_address").val(supplier_address);
				$("#edit_supplier_do").val(supplier_do);
				$("#edit_po_date").val(create_po_date);
				$("#edit_order_description").val(order_type);
				$("#edit_warehouse_code").val(warehouse_code);
				
				
				
				$.ajax({
				  url: '<?php echo BASE_URL(); ?>/index.php/json/jsonProductPo?id_po='+id_po,
				  success: function(data,status)
				  {
					$("#table_edit_po tbody tr").remove();  
					
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
					$("#table_edit_po tbody").append("<tr id='product_"+data[i]['id_product']+"'>"+
													 "<td><input type='checkbox' class='case'/></td>"+
													 "<td><span id='snum"+j+"'>"+no+".</span></td>"+
													 "<td><input type='hidden' name='id_product[]' id='id_product_"+j+"' class='id_product' id_row='"+j+"' value='"+data[i]['id_product']+"' ><input type='hidden' name='product_code[]' id='product_code_"+j+"' class='product_code_' id_row='"+j+"' value='"+data[i]['product_code']+"' ><span id='product_code_span_"+j+"'>"+data[i]['product_code']+"<span></td>"+
													 "<td><span id='description_"+j+"'>"+data[i]['product_name']+"<span></td>"+
													 "<td><input type='hidden' name='product_description[]' id='product_description_"+j+"' class='product_description' id_row='"+j+"' value='"+data[i]['product_name']+"' ><input type='hidden' name='price[]' id='price_"+j+"' class='price' id_row='"+j+"' value='"+data[i]['price']+"' ><input type='text' name='qty[]' id='qty_"+j+"' class='qty' id_row='"+j+"' value='"+data[i]['qty']+"' ></td>"+
													 "<td><input type='text' name='qty_approve[]' id='qty_approve_"+j+"' class='qty' id_row='"+j+"' value='"+data[i]['qty_approve']+"' ></td>"+
													 "<td><span id='price_"+j+"'>"+data[i]['price']+"<span></td>"+
													 "<td><input type='text' name='custom_price[]' id='custom_price_"+i+"' class='custom_price qty' id_row='"+i+"' value='"+data[i]['custom_price']+"' ></td>"+
													 "<td><select name='status_po[]' id='status_po_"+j+"'>"+
													 "<option value='not_approved'>Not Approved</option>"+
													 "<option value='approved'>Approved</option>"+
													 "</select></td>"+
													 "</tr>");
					
					$('#status_po_'+j+' option[value="'+data[i]['status_approved']+'"]').prop('selected',true);
					
			  }
			 
			}

			$("#form_add_data").validate({
			
				messages: {
				id_pr: {
				required: 'ID PR must be filled!'
				},
				request_date: {
				required: 'Request Date must be filled!'
				},
				supplier_name: {
				required: 'Po Name must be filled!'
				},
				supplier_address: {
				required: 'Po Address must be filled!'
				},
				po_code: {
				required: 'Po Code must be filled!'
				},
				po_date: {
				required: 'PO Date must be filled!'
				},
				po_do: {
				required: 'Po DO must be filled!'
				},
				order_description: {
				required: 'Order Description must be filled!'
				},
				warehouse_code: {
				required: 'Warehouse Code must be filled!'
				}
				
				
				
			}
			});
			
			
			
			$("#form_edit_data").validate({
				rules: {
				edit_email: {
				  email: true
				}
				},
				messages: {
				edit_po_code: {
				required: 'Po Code must be filled!'
				},
				edit_supplier_name: {
				required: 'Driver Name must be filled!'
				},
				edit_address_1: {
				required: 'Address 1 must be filled!'
				},
				edit_po_type: {
				required: 'Po type must be filled!'
				},
				edit_city: {
				required: 'City must be filled!'
				},
				edit_postal_code: {
				required: 'Postal code must be filled!'
				},
				edit_phone: {
				required: 'Phone must be filled!'
				},
				edit_fax: {
				required: 'Fax must be filled!'
				},
				edit_pic: {
				required: 'PIC must be filled!'
				},
				edit_email: {
				required: 'Email must be filled!'
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
  
  $(".detail_data").click(function(){
	$('[data-remodal-id = modal_detail]').remodal().open();
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
		$("#id_po_delete_all").val(ids);
		
    } else {
        alert("Please select items.");
    }
});



$(document).on('change', '#select_all', function() {

    $(".checkbox_satuan").prop('checked', $(this).prop("checked"));
});

$("#add-data").click(function(){
	$("#form_add_data").trigger('reset');
	$("#table_add_po tbody tr").remove(); 
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


 <script>
 
		//auto complete PR
        $( "#search_pr_reference" ).autocomplete({
         source: "<?php echo BASE_URL(); ?>/index.php/json/jsonPr",  
         minLength:0,
		 select: function( event , ui ) {
			  $("#id_pr").val(ui.item.id_pr);
			  var id_pr = ui.item.id_pr;
			  $.ajax({
				  url: '<?php echo BASE_URL(); ?>/index.php/json/jsonProductPr?id_pr='+id_pr,
				  success: function(data,status)
				  {
					$("#table_add_po tbody tr").remove();  
					createTableProductPO(data);
				  },
				  async:   true,
				  dataType: 'json'
			}); 
				
			  $(this).val('');
			  return false;
			  
        }    
        })
		.autocomplete( "instance" )._renderItem = function( ul, item ) {
		  return $( "<li style='position:relative; z-index:9999;'>" )
			.append( "<div style='font-size:10px;'>" + item.label +"</div>" )
			.appendTo( ul );
		};
		
		
		function createTableProductPO(data)
			{
			  for(var i=0; i<data.length;i++)
			  {
					var no = i + 1;
					var j = i + 2;
					$("#table_add_po tbody").append("<tr id='product_"+data[i]['id_product']+"'><td><input type='checkbox' class='case'/></td><td><span id='snum"+j+"'>"+no+".</span></td>"+
													"<td><input type='hidden' name='id_product[]' id='id_product_"+j+"' class='id_product' id_row='"+j+"' value='"+data[i]['id_product']+"' ><input type='hidden' name='product_code[]' id='product_code_"+j+"' class='product_code_' id_row='"+j+"' value='"+data[i]['product_code']+"' ><span id='product_code_span_"+j+"'>"+data[i]['product_code']+"<span></td><td><span id='description_"+j+"'>"+data[i]['product_name']+"<span></td><td><input type='hidden' name='product_description[]' id='product_description_"+j+"' class='product_description' id_row='"+j+"' value='"+data[i]['product_name']+"' ><input type='hidden' name='price[]' id='price_"+j+"' class='price' id_row='"+j+"' value='"+data[i]['price']+"' ><input type='text' name='qty[]' id='qty_"+j+"' class='qty' id_row='"+j+"' value='"+data[i]['qty']+"' ></td><td><span id='price_"+j+"'>"+data[i]['price']+"<span></td><td><input type='text' name='custom_price[]' id='custom_price_"+i+"' class='custom_price' id_row='"+i+"' ></td></tr>");
			  }
			 
			}
			
			
		//auto complete po
		var term = $("#search_supplier_code").val();
        $( "#search_supplier_code" ).autocomplete({
         source: "<?php echo BASE_URL(); ?>/index.php/json/jsonSupplier?term="+term,  
         minLength:0,
		 select: function( event , ui ) {
			  $( "#supplier_code" ).val( ui.item.supplier_code );
			  $( "#supplier_name" ).val( ui.item.supplier_name );
			  $( "#supplier_address" ).val( ui.item.address_1 );
			 
        }    
        })
		.autocomplete( "instance" )._renderItem = function( ul, item ) {
		  return $( "<li style='position:relative; z-index:9999;'>" )
			.append( "<div style='font-size:10px;'>" + item.label + "<br>" + item.supplier_name + "<br>" + item.address_1 +"</div>" )
			.appendTo( ul );
		};
		
		
		
		//auto complete product
		var term = $("#add_product_po").val();
        $('#add_product_po').autocomplete({
         source: "<?php echo BASE_URL(); ?>/index.php/json/jsonproduct?term="+term,  
         minLength:0,
		 select: function( event , ui ) {
			  
			  var id_pr = $("#id_pr").val();
			  if(id_pr!='')
			  {
			  var product_code = ui.item.label;
			  var id_product = ui.item.id_product;
			  var product_description = ui.item.product_description;
			  var base_uom = ui.item.base_uom;
			  var price = ui.item.price;
           	  addrow(product_code,id_product,product_description,base_uom,price);
			  }
			  else
			  { alert("Sorry Please Input PR first!"); $("#id_pr").focus();}
			  
			  
			 
			 
        }    
        })
		.autocomplete( "instance" )._renderItem = function( ul, item ) {
		  return $( "<li style='position:relative; z-index:9999;'>" )
			.append( "<div style='font-size:10px;'>" + item.label + "<br>" + item.product_description +"</div>" )
			.appendTo( ul );
		};
		
		
		
		
		
		//auto complete product
		var term = $("#add_edit_product_po").val();
        $('#add_edit_product_po').autocomplete({
         source: "<?php echo BASE_URL(); ?>/index.php/json/jsonproduct?term="+term,  
         minLength:0,
		 select: function( event , ui ) {
			  
				
			  var product_code = ui.item.label;
			  var id_product = ui.item.id_product;
			  var product_description = ui.item.product_description;
			  var base_uom = ui.item.base_uom;
			  var price = ui.item.price;
			  
           	  addEditRow(product_code,id_product,product_description,base_uom,price);
			 
			  
			  
			 
			 
        }    
        })
		.autocomplete( "instance" )._renderItem = function( ul, item ) {
		  return $( "<li style='position:relative; z-index:9999;'>" )
			.append( "<div style='font-size:10px;'>" + item.label + "<br>" + item.product_description +"</div>" )
			.appendTo( ul );
		};
		
		
		
		//auto complete warehouse
		var term = $("#search_warehouse_code").val();
        $( "#search_warehouse_code" ).autocomplete({
         source: "<?php echo BASE_URL(); ?>/index.php/json/jsonWarehouse?term="+term,  
         minLength:0,
		 select: function( event , ui ) {
			  $( "#warehouse_code" ).val( ui.item.label );
			 
        }    
        })
		.autocomplete( "instance" )._renderItem = function( ul, item ) {
		  return $( "<li style='position:relative; z-index:9999;'>" )
			.append( "<div style='font-size:10px;'>" + item.label +"</div>" )
			.appendTo( ul );
		};
		
		
		//auto complete Description
		var term = $("#search_order_description").val();
        $( "#search_order_description" ).autocomplete({
         source: "<?php echo BASE_URL(); ?>/index.php/json/jsonOrderType?term="+term,  
         minLength:0,
		 select: function( event , ui ) {
			  $( "#order_description" ).val( ui.item.label );
			 
        }    
        })
		.autocomplete( "instance" )._renderItem = function( ul, item ) {
		  return $( "<li style='position:relative; z-index:9999;'>" )
			.append( "<div style='font-size:10px;'>" + item.label +"</div>" )
			.appendTo( ul );
		};
		
	
  </script>
  
  
							
  <script>
$(".delete").on('click', function() {
	$('.case:checkbox:checked').parents("tr").remove();
    $('.check_all').prop("checked", false); 
	check();

});
var i=2;

function addrow(product_code,id_product,product_description,base_uom,price){
	count=$('table.po tr').length;
    var data = "<tr><td><input type='checkbox' class='case'/></td><td><span id='snum"+i+"'>"+count+".</span></td>";
    data +="<td><input type='hidden' name='id_product[]' id='id_product_"+i+"' class='id_product' id_row='"+i+"' value='"+id_product+"' ><input type='hidden' name='product_code[]' id='product_code_"+i+"' class='product_id' id_row='"+i+"' value='"+product_code+"' ><span id='product_code_span_"+i+"'>"+product_code+"<span></td><td><span id='description_"+i+"'>"+product_description+"<span></td><td><input type='text' name='qty[]' id='qty"+i+"' class='qty' id_row='"+i+"' ><input type='hidden' name='product_description[]' id='product_description"+i+"' class='product_description' value='"+product_description+"' id_row='"+i+"' ><input type='hidden' name='price[]' id='price"+i+"' class='price' id_row='"+i+"' value='"+price+"' ></td><td><span id='product_description_"+i+"'>"+product_description+"<span></td><td><input type='text' name='custom_price[]' id='custom_price_"+i+"' class='custom_price' id_row='"+i+"' ></td></tr>";
	
	if( $("#table_add_po tr#product_"+id_product).length ) 
	{
		alert("Sorry Product has been entered before!");
		}	
	else{
	$('#table_add_po tbody').append(data);
	i++;
	}
}

function addEditRow(product_code,id_product,product_description,base_uom,price){
	count=$('table.po tr').length;
    var data = "<tr><td><input type='checkbox' class='case'/></td><td><span id='snum"+i+"'>"+count+".</span></td>";
    data +="<td><input type='hidden' name='id_product[]' id='id_product_"+i+"' class='id_product' id_row='"+i+"' value='"+id_product+"' ><input type='hidden' name='product_code[]' id='product_code_"+i+"' class='product_id' id_row='"+i+"' value='"+product_code+"' ><span id='product_code_span_"+i+"'>"+product_code+"<span></td><td><span id='description_"+i+"'>"+product_description+"<span></td><td><input type='text' name='qty[]' id='qty"+i+"' class='qty' id_row='"+i+"' ><input type='hidden' name='product_description[]' id='product_description"+i+"' class='product_description' value='"+product_description+"' id_row='"+i+"' ><input type='hidden' name='price[]' id='price"+i+"' class='price' id_row='"+i+"' value='"+price+"' ></td><td><input type='text' name='qty_approve[]' id='qty_approve_"+i+"' class='qty' id_row='"+i+"' value='0' ></td><td><span id='product_description_"+i+"'>"+product_description+"<span></td><td><input type='text' name='custom_price[]' id='custom_price_"+i+"' class='custom_price' id_row='"+i+"' ></td><td><select name='status_po[]' id='status_po_"+i+"'><option value='not_approved'>Not Approved</option><option value='approved'>Approved</option></select></td></tr>";
	
	if( $("#table_edit_po tr#product_"+id_product).length ) 
	{
		alert("Sorry Product has been entered before!");
		}	
	else{
	$('#table_edit_po tbody').append(data);
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
	obj=$('table.po tr').find('span');
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





function select_all() {
	$('input[class=edit_case]:checkbox').each(function(){ 
		if($('input[class=edit_check_all]:checkbox:checked').length == 0){ 
			$(this).prop("checked", false); 
		} else {
			$(this).prop("checked", true); 
		} 
	});
}

function check(){
	obj=$('table.edit_po tr').find('span');
	$.each( obj, function( key, value ) {
	id=value.id;
	$('#'+id).html(key+1);
	});
	}

</script>
