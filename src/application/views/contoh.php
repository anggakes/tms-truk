<div class="form-group">
					 <label>Order type</label>
						<div class="input-group">
						  <div class="input-group-addon">
							<i class="fa fa-search"></i>
						  </div>
						  <input type="text" class="form-control pull-right" name="edit_order_description" id="edit_order_description" value='reg' required>
						  <input type="hidden" class="form-control" name="edit_id_order_type" id="edit_id_order_type" required>
						</div>
						<!-- /.input group -->
					</div>

					
	<div class="form-group">
					  <label for="drivercode2">PO Status</label>
					  <select class="form-control" name="edit_po_status" id="edit_po_status" required>
						<option selected="selected" value="">Choose PO Status</option>
						<option value="new">New</option>
						<option value="canceled">Cancel</option>
						<option value="approved">Approve</option>
					  </select> 
					</div>
	
	
		<div class="form-group">
                  <label for="drivercode2">Warehouse</label>
				  <select class="form-control" name="id_warehouse" id="id_warehouse" required>
					<option selected="selected" value="">Choose Warehouse</option>
					<?php foreach($data_warehouse as $data_warehouse1) {?>
					<option value="<?php echo $data_warehouse1->id_warehouse; ?>"><?php echo $data_warehouse1->warehouse_name; ?></option>
					<?php } ?>
				  </select> 
                </div>

				
		<script>
		//auto complete supplier
		var term = $("#supplier_code").val();
        $( "#supplier_code" ).autocomplete({
         source: "<?php echo BASE_URL(); ?>/index.php/json/jsonsupplier?term="+term,  
         minLength:0,
		 select: function( event , ui ) {
			  $( "#supplier_code" ).val( ui.item.label );
			  $( "#id_supplier" ).val( ui.item.id_supplier );
			  $( "#supplier_name" ).val( ui.item.supplier_name );
			  $( "#supplier_address" ).val( ui.item.address_1 );
			 
        }    
        })
		.autocomplete( "instance" )._renderItem = function( ul, item ) {
		  return $( "<li style='position:relative; z-index:9999;'>" )
			.append( "<div style='font-size:10px;'>" + item.label + "<br>" + item.supplier_name + "<br>" + item.address_1 +"</div>" )
			.appendTo( ul );
		};
		</script>