 <!-- HEADER -->
 <section class="content-header">
          <h1>
			Stock Transfer
            <small>List Of Stock Transfer</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="<?php echo BASE_URL(); ?>"><i class="fa fa-dashboard"></i>Home</a></li>
            <li><a href="<?php echo BASE_URL()."inventory_list/stockTransfer"; ?>"><i class="fa fa-dashboard"></i>Stock Transfer</a></li>
          </ol>
        </section>
  
  
   <!-- Content -->
   <section class="content">
		
		
  
  
          <div class="box sms box-default color-palette-box">
            <div class="box-header with-border">
              <h3 class="box-title"><i class="fa fa-table"></i> Table Stock Transfer</h3>
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
                             <form action="<?php echo base_url()."index.php/inventory_list/stockTransfer" ?>" method="get">
                             <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                                <input type="text" id="search" name="search" placeholder="Search..."  value="<?php echo $search; ?>" />
                                <input type="submit" id="submit"  value="Search"/>
                                <?php if($search!="")
								{?>
                                <a href="<?php echo base_url()."index.php/inventory_list/stockTransfer" ?>" id="clear-search">Clear Search</a>
                                <?php } ?>
                             </form>
                </div>
                <div id="wrapper-button" class="clearfix">
					<?php if($data_role[0]['export_gr']=='yes'){ ?>
                	<a href="<?php echo base_url()."index.php/inventory_list/exportStockCheck?search=".$search; ?>" class="button orange-button">
                    	Export Stock Check
                    </a>
					
					<?php } ?>
                    
					
                </div>
                </div>
            <div id="wrapper-console" class="clearfix"> 
            <div class="grid_4 height400">                  
           	<table id="myTable03" class="fancyTable table table-bordered table-hover">
                    <thead>
                      <tr>
						<th>ID Inventory List</th>
                        <th>Warehouse ID</th>
                        <th>Location Type</th>
                        <th>Location ID</th>
						<th>ID Product</th>
						<th>Product Code</th>
						<th>Product Description</th>
						<th>Serial Number</th>
						<th>Quantity Base</th>
						<th>Stock</th>
						<th>Action</th>
                      </tr>
                    </thead>
             		<tbody>
					
				 <?php foreach($data_inventory_list as $data_inventory_list) {?>
					
						<tr id="data_<?php echo $data_inventory_list->id_inventory_list; ?>" >
						<td class='id_inventory_list'><?php echo $data_inventory_list->id_inventory_list; ?></td>
                        <td class='warehouse_code'><?php echo $data_inventory_list->warehouse_code; ?></td>
                        <td class='location_type'><?php echo $data_inventory_list->location_type; ?></td>
                        <td class='location_code'><span class='location_code'><?php echo $data_inventory_list->location_code; ?></span>
						<span style='display:none;' class='id_location'><?php echo $data_inventory_list->id_location; ?></span>
						</td>
						<td class='id_product'><?php echo $data_inventory_list->id_product; ?></td>
						<td class='product_code'><?php echo $data_inventory_list->product_code; ?></td>
						<td class='product_description'><?php echo $data_inventory_list->product_description; ?></td>
						<td class='serial_number'><?php echo $data_inventory_list->serial_number; ?></td>
						<td class='base_uom'><?php echo $data_inventory_list->base_uom; ?></td>
						<td class='stock'><?php echo $data_inventory_list->stock; ?></td>
						<td><?php if($data_role[0]['delete_inventory_list']=='yes'){ ?><a  class="edit_data link_action" id="<?php echo $data_inventory_list->id_inventory_list; ?>" >Transfer Stock</a><?php } ?></td>
						</tr>
				 
				 <?php } ?>
					
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
		<h2 id="modal1Title">Stock Transfer</h2>
				<form role="form" id="form_edit_data" method="POST" action="<?php echo base_url()."index.php/inventory_list/stockTransferUpdate" ?>" enctype="multipart/form-data">
				 <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
              <div class="box-body">

				<h3>From</h3>
					
					<input type='hidden' name='id_product' id='id_product' value=''>
					<input type='hidden' name='product_code' id='product_code' value=''>
					<input type='hidden' name='id_location_from' id='id_location_from' value=''>
					
					<div class="form-group">
					  <label for="drivercode2">Location ID</label>
					 <input type="text" readonly class="form-control" name="location_id" id="location_id" required>
					</div>
					
					<div class="form-group">
					  <label for="drivercode2">Warehouse</label>
					 <input type="text" readonly class="form-control" name="warehouse_code_from" id="warehouse_code_from" required>
					</div>
					
					<div class="form-group">
					  <label for="drivercode2">Location Type</label>
					 <input type="text" readonly class="form-control" name="location_type_from" id="location_type_from" required>
					</div>
					
					
					
					<div class="form-group">
					  <label for="drivercode2">Stock</label>
					 <input type="text" readonly class="form-control" name="stock_from" id="stock_from" required>
					</div>
				
				
				<h3>To</h3>
				
				<div class="form-group">
					 <label>Location:</label>
						<div class="input-group">
						  <div class="input-group-addon">
							<i class="fa fa-search"></i>
						  </div>
						  <input type="text" class="form-control pull-right" name="search_edit_warehouse_code" id="search_edit_warehouse_code" value='' placeholder='Search Location ID'>
						  <input type="text"  readonly class="form-control pull-right" name="location_id_to" id="location_id_to" placeholder='Location ID' required>
						  <input type="text"  readonly class="form-control pull-right" name="warehouse_code_to" id="warehouse_code_to" placeholder='Warehouse Code' required>
						  <input type="text"  readonly class="form-control pull-right" name="location_type_to" id="location_type_to" placeholder='Location Type' required>
						  <input type="hidden"  readonly class="form-control pull-right" name="id_location_to" id="id_location_to" >
						  
						 
						</div>
						<!-- /.input group -->
				</div>
				
				<div class="form-group">
					  <label for="drivercode2">Stock</label>
					 <input type="text" class="form-control" name="stock_to" id="stock_to" required>
					</div>
				
              <div class="box-footer">
                <button data-remodal-action="cancel" class="remodal-cancel">Cancel</button>
				<input type="submit" name="submit_edit" class="remodal-confirm" value="Transfer Stock" id="submit_add">
              </div>
            </form>
	  </div>
	  <br>
	  
	</div>
	</div>
	
<script>
$(".edit_data").click(function(){
	$('[data-remodal-id = modal_edit]').remodal().open();
	var validator = $( "#form_edit_data" ).validate();
	validator.resetForm();
});

$(".edit_data").click(function(){
	var id = $(this).attr('id');
	var warehouse_code =  $('#data_'+id+' .warehouse_code').text();
	var location_code =  $('#data_'+id+' .location_code .location_code').text();
	var id_location =  $('#data_'+id+' .location_code .id_location').text();
	var location_type =  $('#data_'+id+' .location_type').text();
	var stock =  $('#data_'+id+' .stock').text();
	var id_product =  $('#data_'+id+' .id_product').text();
	var product_code =  $('#data_'+id+' .product_code').text();
	
	$("#id_location_from").val(id_location);
	$("#id_product").val(id_product);
	$("#product_code").val(product_code);
	$("#location_id").val(location_code);
	$("#warehouse_code_from").val(warehouse_code);
	$("#location_type_from").val(location_type);
	$("#stock_from").val(stock);
	
})


var term = $("#search_edit_warehouse_code").val();
        $( "#search_edit_warehouse_code" ).autocomplete({
         source: "<?php echo BASE_URL(); ?>/index.php/json/jsonLocation?term="+term,  
         minLength:0,
		 select: function( event , ui ) {
			  $( "#location_id_to" ).val( ui.item.location_code );
			  $( "#warehouse_code_to" ).val( ui.item.warehouse_code );
			  $( "#location_type_to" ).val( ui.item.location_type );
			   $( "#id_location_to" ).val( ui.item.id_location );
			 
        }    
        })
		.autocomplete( "instance" )._renderItem = function( ul, item ) {
		  return $( "<li style='position:relative; z-index:9999;'>" )
			.append( "<div style='font-size:10px;'>" + item.label+"</div>" )
			.appendTo( ul );
};


	
$( "#stock_to" ).keyup(function() {
  
   if (/\D/g.test(this.value))
  {
    // Filter non-digits from input value.
    this.value = this.value.replace(/\D/g, '');
  }
  
  var stock_asli = $("#stock_from").val();
  var stock_transfer = $(this).val();
  
  if(stock_transfer>stock_asli)
  {
	  alert("Stock Transfer overload!");
	  $(this).val(0);
  }

  
});


$("#form_edit_data").validate({
				rules: {
				stock_to: {
				  digits: true
				}
				},
				messages: {
				stock_to: {
				required: 'Stock To must be filled!'
				},
				location_id_to: {
				required: 'Location ID To must be filled!'
				},
				warehouse_code_to: {
				required: 'Warehouse Code To must be filled!'
				},
				location_type_to: {
				required: 'Location Type To must be filled!'
				}
				
			}
			});
		
		
</script>

	  
	
