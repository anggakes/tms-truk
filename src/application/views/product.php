 <!-- HEADER -->
 <section class="content-header">
          <h1>
            Product
            <small>List Of Product</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="<?php echo BASE_URL(); ?>"><i class="fa fa-dashboard"></i>Home</a></li>
            <li><a href="<?php echo BASE_URL()."product"; ?>"><i class="fa fa-dashboard"></i>Product</a></li>
          </ol>
        </section>
  
  
   <!-- Content -->
   <section class="content">
		
		
  
  
          <div class="box sms box-default color-palette-box">
            <div class="box-header with-border">
              <h3 class="box-title"><i class="fa fa-table"></i> Table Product</h3>
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
                             <form action="<?php echo base_url()."index.php/product" ?>" method="get">
                             <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                                <input type="text" id="search" name="search" placeholder="Search..."  value="<?php echo $search; ?>" />
                                <input type="submit" id="submit"  value="Search"/>
                                <?php if($search!="")
								{?>
                                <a href="<?php echo base_url()."index.php/product" ?>" id="clear-search">Clear Search</a>
                                <?php } ?>
                             </form>
                </div>
                <div id="wrapper-button" class="clearfix">
					
					
					<?php 
					if($data_role[0]['export_product']=='yes'){ ?>
                	<a href="<?php echo base_url()."index.php/product/exportProduct?search=".$search; ?>" class="button orange-button">
                    	Export Product
                    </a>
					<?php } ?>
					
					
					
                    <?php if($data_role[0]['add_product']=='yes'){ ?>
                    <a id="add-data" class="button green-button">
                    	Add Product
                    </a>
					<?php } ?>
					
					
					<?php if($data_role[0]['delete_product']=='yes'){ ?>
                    <a id="delete-data" class="button btn-danger deletelogg">
                    	Delete Product
                    </a>
					<?php } ?>
					<?php if($data_role[0]['import_product']=='yes'){ ?>
                    <a id="import-data" class="button blue-button">
                    	Import Product
                    </a>
					<?php } ?>
					
                </div>
                </div>
            <div id="wrapper-console" class="clearfix"> 
            <div class="grid_4 height400">                  
           	<table id="myTable04" class="fancyTable table-bordered table-hover">
                    <thead>
                      <tr>
					  
                        <th><div class="check-box-div"><input type="checkbox" name="select_all" id="select_all"></div>ID Product</th>
                        <th>Warehouse Name</th>
						<th>Supplier</th>
                        <th>Product Code</th>
						<th>Serial Number</th>
						<th>Product Description</th>
						<th>Base UOM</th>
						<th>Price</th>
						<th>Quantity Pallet</th>
						<th>Net Weight</th>
						<th>Gross Weight</th>
						<th>UOW</th>
						<th>Created By</th>
						<th>Created Time</th>
						<th>Updated By</th>
						<th>Updated Time</th>
						
						
						<?php if($data_role[0]['delete_product']=='yes' || $data_role[0]['edit_product']=='yes'){ ?>
						<th>Action</th>
						<?php } ?>
                      </tr>
                    </thead>
             		<tbody>
                    <?php foreach($data_product as $data_product) {?>
                    <tr id="data_<?php echo $data_product->id_product; ?>">
                    	<td class="id_product">
						<div class="check-box-div">
						<input type="checkbox" name="id_checkbox[]" class="iCheck-helper toedit checkbox_satuan" value="<?php echo $data_product->id_product; ?>" />
						</div><span><?php echo $data_product->id_product; ?></span></td>
						
                        <td class="warehouse"><?php echo $data_product->warehouse_name; ?>
						<span style="display:none;"><?php echo $data_product->id_warehouse; ?></span></td>
						
						<td class="supplier"><?php echo $data_product->supplier_name; ?>
						<span style="display:none;"><?php echo $data_product->id_supplier; ?></span></td>
						
                        <td class="product_code"><?php echo $data_product->product_code; ?></td>
						<td class="serial_number"><?php echo $data_product->serial_number; ?></td>
						 <td class="product_description"><?php echo $data_product->product_description; ?></td>
						 
						 
						 
						 <td class="base_uom"><?php echo $data_product->base_uom; ?></td>
						 
						 <td class="price"><?php convert_price($data_product->price); ?></td>
						 
						 <td class="qty_pallet"><?php echo $data_product->qty_pallet; ?></td>
						
						 <td class="net_weight"><?php echo $data_product->net_weight; ?></td>
						 <td class="gross_weight"><?php echo $data_product->gross_weight; ?></td>
						 
						  <td class="uow"><?php echo $data_product->uow; ?></td>
						  
						  <td class="created_by"><?php echo $data_product->created_by; ?></td>
						  
						  <td class="created_time"><?php echo $data_product->created_time; ?></td>
						  
						  <td class="updated_by"><?php echo $data_product->updated_by; ?></td>
						  
						  <td class="updated_time"><?php echo $data_product->updated_time; ?></td>
						
						
						
						<?php if($data_role[0]['delete_product']=='yes' || $data_role[0]['edit_product']=='yes'){ ?>
						<td><?php if($data_role[0]['delete_product']=='yes'){ ?><a  class="delete_data link_action" id="<?php echo $data_product->id_product; ?>" >Delete</a><?php } ?> | <?php if($data_role[0]['edit_product']=='yes'){ ?><a  id="<?php echo $data_product->id_product; ?>" class="edit_data link_action">Edit</a><?php } ?></td>
						
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
		<h2 id="modal1Title">Add Product</h2>
				<form role="form" id="form_add_data" method="POST" action="<?php echo base_url()."index.php/product/addProduct" ?>" enctype="multipart/form-data">
				 <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
				 
              <div class="box-body">

				
				
				<div class="form-group">
                  <label for="drivercode2">Warehouse</label>
				  <select class="form-control" name="id_warehouse" id="id_warehouse" required>
					<option selected="selected" value="">Choose Warehouse</option>
					<?php foreach($data_warehouse as $data_warehouse1) {?>
					<option value="<?php echo $data_warehouse1->id_warehouse; ?>"><?php echo $data_warehouse1->warehouse_name; ?></option>
					<?php } ?>
				  </select> 
                </div>
				
				
				<div class="form-group">
                  <label for="drivercode2">Supplier</label>
				  <select class="form-control" name="id_supplier" id="id_supplier" required>
					<option selected="selected" value="">Choose Supplier</option>
					<?php foreach($data_supplier as $data_supplier1) {?>
					<option value="<?php echo $data_supplier1->id_supplier; ?>"><?php echo $data_supplier1->supplier_name; ?></option>
					<?php } ?>
				  </select> 
                </div>
				
				<div class="form-group">
                  <label for="drivercode2">Product Code</label>
                 <input type="text" class="form-control" name="product_code" id="product_code" required>
                </div>
				
				<div class="form-group">
                  <label for="drivercode2">Serial Number</label>
                 <input type="text" class="form-control" name="serial_number" id="serial_number" required>
                </div>
				
				<div class="form-group">
                  <label for="drivercode2">Product Description</label>
                 <input type="text" class="form-control" name="product_description" id="product_description" required>
                </div>
				
				<div class="form-group">
                  <label for="drivercode2">Base UOM</label>
                 <input type="text" class="form-control" name="base_uom" id="base_uom" required>
                </div>
				
				
				<div class="form-group">
                  <label for="drivercode2">Price</label>
                 <input type="text" class="form-control" name="price" id="price" required>
                </div>
				
				<div class="form-group">
                  <label for="drivercode2">Quantity Pallet</label>
                 <input type="text" class="form-control" name="qty_pallet" id="qty_pallet" required>
                </div>
				
				<div class="form-group">
                  <label for="drivercode2">Net Weight</label>
                 <input type="text" class="form-control" name="net_weight" id="net_weight" required>
                </div>
				<div class="form-group">
                  <label for="drivercode2">Gross Weight</label>
                 <input type="text" class="form-control" name="gross_weight" id="gross_weight" required>
                </div>
				
				<div class="form-group">
                  <label for="drivercode2">UOW</label>
                 <input type="text" class="form-control" name="uow" id="uow" required>
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
		<h2 id="modal1Title">Edit Product</h2>
				<form role="form" id="form_edit_data" method="POST" action="<?php echo base_url()."index.php/product/editProduct" ?>" enctype="multipart/form-data">
				 <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
				 
              <div class="box-body">

				
				<div class="form-group">
                  <label for="drivercode2">Warehouse</label>
				  <select class="form-control" name="edit_id_warehouse" id="edit_id_warehouse" required>
					<option selected="selected" value="">Choose Warehouse</option>
					<?php foreach($data_warehouse as $data_warehouse1) {?>
					<option value="<?php echo $data_warehouse1->id_warehouse; ?>"><?php echo $data_warehouse1->warehouse_name; ?></option>
					<?php } ?>
				  </select> 
                </div>
				
				
				<div class="form-group">
                  <label for="drivercode2">Supplier</label>
				  <select class="form-control" name="edit_id_supplier" id="edit_id_supplier" required>
					<option selected="selected" value="">Choose Supplier</option>
					<?php foreach($data_supplier as $data_supplier1) {?>
					<option value="<?php echo $data_supplier1->id_supplier; ?>"><?php echo $data_supplier1->supplier_name; ?></option>
					<?php } ?>
				  </select> 
                </div>
				
				<div class="form-group">
                  <label for="drivercode2">Product Code</label>
                 <input type="text" class="form-control" name="edit_product_code" id="edit_product_code" required>
                </div>
				
				<div class="form-group">
                  <label for="drivercode2">Serial Number</label>
                 <input type="text" class="form-control" name="edit_serial_number" id="edit_serial_number" required>
                </div>
				
				
				
				<div class="form-group">
                  <label for="drivercode2">Product Description</label>
                 <input type="text" class="form-control" name="edit_product_description" id="edit_product_description" required>
                </div>
				
				<div class="form-group">
                  <label for="drivercode2">Base UOM</label>
                 <input type="text" class="form-control" name="edit_base_uom" id="edit_base_uom" required>
                </div>
				
				
				<div class="form-group">
                  <label for="drivercode2">Quantity Pallet</label>
                 <input type="text" class="form-control" name="edit_qty_pallet" id="edit_qty_pallet" required>
                </div>
				
				<div class="form-group">
                  <label for="drivercode2">Price</label>
                 <input type="text" class="form-control" name="edit_price" id="edit_price" required>
                </div>
				
				<div class="form-group">
                  <label for="drivercode2">Net Weight</label>
                 <input type="text" class="form-control" name="edit_net_weight" id="edit_net_weight" required>
                </div>
				<div class="form-group">
                  <label for="drivercode2">Gross Weight</label>
                 <input type="text" class="form-control" name="edit_gross_weight" id="edit_gross_weight" required>
                </div>
				
				<div class="form-group">
                  <label for="drivercode2">UOW</label>
                 <input type="text" class="form-control" name="edit_uow" id="edit_uow" required>
                </div>
				
				 <input type="hidden" class="form-control" name="id_product_update" id="id_product_update">
              
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
	
	
	
	<div class="remodal" data-remodal-id="modal_import" role="dialog" aria-labelledby="modal1Titl aria-describedby="modal1Desc">
	  <button data-remodal-action="close" class="remodal-close" aria-label="Close"></button>
	  <div>
		<h2 id="modal1Title">Import Product</h2>
				<form role="form" id="form_import_data" method="POST" action="<?php echo base_url()."index.php/product/importProduct" ?>" enctype="multipart/form-data">
				 <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
				 
              <div class="box-body">

				 <div class="form-group">
                      <label for="exampleInputEmail1">Choose File</label>
                      <input type="file" name="import_file" id="import_file" class="form-control" value="" />
				</div>
				
				 <div class="form-group">
                    <p><a target="_blank" href="<?php echo base_url('/files/example-files/import-product.xlsx')?>">Download sample file import Supplier</a></p>
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
		<h2 id="modal1Title">Delete Product</h2>
				<form role="form" id="form_delete_data" method="POST" action="<?php echo base_url()."index.php/product/deleteproduct" ?>" enctype="multipart/form-data">
				 <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
				 
              <div class="box-body">

				 <div class="form-group">
                     <p>Are you sure want to delete this data? (<span id="reference_delete"></span>)</p>
				</div>
				
				 <div class="form-group">
                      <input type="hidden" name="id_product_delete" id="id_product_delete" class="form-control" value="" />
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
		<h2 id="modal1Title">Delete Product</h2>
				<form role="form" id="form_selected_delete_data" method="POST" action="<?php echo base_url()."index.php/product/deleteProductAll" ?>" enctype="multipart/form-data">
				 <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
				 
              <div class="box-body">

				 <div class="form-group">
                     <p>Are you sure want to delete selected data? </p>
				</div>
				
				 <div class="form-group">
                      <input type="hidden" name="id_product_delete_all" id="id_product_delete_all" class="form-control" value="" />
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
				var product_code =  $('#data_'+id+' .product_code').text();
				var id_product =  $('#data_'+id+' .id_product span').text();
				$("#reference_delete").text("Product Code:"+product_code);
				$("#id_product_delete").val(id_product);
			});
			
			
			
			$(".edit_data").click(function(){
				var id = $(this).attr('id');
				var id_warehouse =  $('#data_'+id+' .warehouse span').text();
				var id_supplier =  $('#data_'+id+' .supplier span').text();
				var product_code =  $('#data_'+id+' .product_code').text();
				var serial_number =  $('#data_'+id+' .serial_number').text();
				var id_product =  $('#data_'+id+' .id_product span').text();
				var product_description =  $('#data_'+id+' .product_description').text();
				var base_uom =  $('#data_'+id+' .base_uom').text();
				var qty_pallet =  $('#data_'+id+' .qty_pallet').text();
				var price =  $('#data_'+id+' .price').text();
				var net_weight =  $('#data_'+id+' .net_weight').text();
				var gross_weight =  $('#data_'+id+' .gross_weight').text();
				var uow =  $('#data_'+id+' .uow').text();
				$("#edit_product_code").val(product_code);
				$("#edit_product_description").val(product_description);
				$("#edit_serial_number").val(serial_number);
				$("#edit_base_uom").val(base_uom);
				$("#edit_product_code").val(product_code);
				$("#edit_qty_pallet").val(qty_pallet);
				$("#edit_price").val(price);
				$("#edit_net_weight").val(net_weight);
				$("#edit_gross_weight").val(gross_weight);
				$("#edit_uow").val(uow);
				$("#id_product_update").val(id_product);
				$('#edit_id_warehouse option[value="' + id_warehouse + '"]').prop('selected',true);
				$('#edit_id_supplier option[value="' + id_supplier + '"]').prop('selected',true);
				
			});

			$("#form_add_data").validate({
				rules: {
				price: {
				  digits: true
				}
				},
				messages: {
				id_warehouse: {
				required: 'Warehouse must be filled!'
				},
				id_supplier: {
				required: 'Supplier must be filled!'
				},
				product_code: {
				required: 'product Code must be filled!'
				},
				serial_number: {
				required: 'Serial Number must be filled!'
				},
				price: {
				required: 'Price must be filled!'
				},
				product_description: {
				required: 'Product Description must be filled!'
				},
				base_uom: {
				required: 'Base UOM must be filled!'
				},
				net_weight: {
				required: 'Net Weight must be filled!'
				},
				gross_weight: {
				required: 'Gross Weight must be filled!'
				},
				uow: {
				required: 'UOW must be filled!'
				}
				
			}
			});
			
			
			
			$("#form_edit_data").validate({
				rules: {
				edit_price: {
				  digits: true
				}
				},
				messages: {
				edit_id_warehouse: {
				required: 'Warehouse must be filled!'
				},
				edit_id_supplier: {
				required: 'Supplier must be filled!'
				},
				edit_product_code: {
				required: 'product Code must be filled!'
				},
				edit_serial_number: {
				required: 'Serial Number must be filled!'
				},
				edit_product_description: {
				required: 'Product Description must be filled!'
				},
				edit_price: {
				required: 'Price must be filled!'
				},
				edit_base_uom: {
				required: 'Base UOM must be filled!'
				},
				edit_net_weight: {
				required: 'Net Weight must be filled!'
				},
				edit_gross_weight: {
				required: 'Gross Weight must be filled!'
				},
				edit_uow: {
				required: 'UOW must be filled!'
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
		$("#id_product_delete_all").val(ids);
		
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
