 <!-- HEADER -->
 <section class="content-header">
          <h1>
            Warehouse
            <small>List Of Warehouse</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="<?php echo BASE_URL(); ?>"><i class="fa fa-dashboard"></i>Home</a></li>
            <li><a href="<?php echo BASE_URL()."warehouse"; ?>"><i class="fa fa-dashboard"></i>Warehouse</a></li>
          </ol>
        </section>
  
  
   <!-- Content -->
   <section class="content">
		
		
  
  
          <div class="box sms box-default color-palette-box">
            <div class="box-header with-border">
              <h3 class="box-title"><i class="fa fa-table"></i> Table Warehouse</h3>
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
                             <form action="<?php echo base_url()."index.php/warehouse" ?>" method="get">
                             <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                                <input type="text" id="search" name="search" placeholder="Search..."  value="<?php echo $search; ?>" />
                                <input type="submit" id="submit"  value="Search"/>
                                <?php if($search!="")
								{?>
                                <a href="<?php echo base_url()."index.php/warehouse" ?>" id="clear-search">Clear Search</a>
                                <?php } ?>
                             </form>
                </div>
                <div id="wrapper-button" class="clearfix">
                	
					<?php if($data_role[0]['export_warehouse']=='yes'){ ?>
					<a href="<?php echo base_url()."index.php/warehouse/exportWarehouse?search=".$search; ?>" class="button orange-button">
                    	Export Warehouse
                    </a>
					<?php } ?>
                    <?php if($data_role[0]['add_warehouse']=='yes'){ ?>
                    <a id="add-data" class="button green-button">
                    	Add Warehouse
                    </a>
					<?php } ?>
					<?php if($data_role[0]['delete_warehouse']=='yes'){ ?>
                    <a id="delete-data" class="button btn-danger deletelogg">
                    	Delete Warehouse
                    </a>
					<?php } ?>
					<?php if($data_role[0]['import_warehouse']=='yes'){ ?>
                    <a id="import-data" class="button blue-button">
                    	Import Warehouse
                    </a>
					<?php } ?>
					
                </div>
                </div>
            <div id="wrapper-console" class="clearfix"> 
            <div class="grid_4 height400">                  
           	<table id="myTable03" class="fancyTable table-bordered table-hover">
                    <thead>
                      <tr>
					  
                        <th><div class="check-box-div"><input type="checkbox" name="select_all" id="select_all"></div>ID Warehouse</th>
                        <th>Warehouse Code</th>
                        <th>Warehouse Name</th>
						<th>Address 1</th>
						<th>Address 2</th>
						<th>Warehouse Type</th>
						<?php if($data_role[0]['delete_warehouse']=='yes' || $data_role[0]['edit_warehouse']=='yes'){ ?>
						<th>Action</th>
						<?php } ?>
                      </tr>
                    </thead>
             		<tbody>
                    <?php foreach($data_warehouse as $data_warehouse) {?>
                    <tr id="data_<?php echo $data_warehouse->id_warehouse; ?>">
                    	<td class="id_warehouse">
						<div class="check-box-div">
						<input type="checkbox" name="id_checkbox[]" class="iCheck-helper toedit checkbox_satuan" value="<?php echo $data_warehouse->id_warehouse; ?>" />
						</div><span><?php echo $data_warehouse->id_warehouse; ?></span></td>
                        <td class="warehouse_code"><?php echo $data_warehouse->warehouse_code; ?></td>
                        <td class="warehouse_name"><?php echo $data_warehouse->warehouse_name; ?></td>
						<td class="address_1"><?php echo $data_warehouse->address_1; ?></td>
                        <td class="address_2"><?php echo $data_warehouse->address_2; ?></td>
						<td class="warehouse_type"><?php echo $data_warehouse->warehouse_type; ?></td>
						
						<?php if($data_role[0]['delete_warehouse']=='yes' || $data_role[0]['edit_warehouse']=='yes'){ ?>
						<td><?php if($data_role[0]['delete_warehouse']=='yes'){ ?><a  class="delete_data link_action" id="<?php echo $data_warehouse->id_warehouse; ?>" >Delete</a><?php } ?> | <?php if($data_role[0]['edit_warehouse']=='yes'){ ?><a  id="<?php echo $data_warehouse->id_warehouse; ?>" class="edit_data link_action">Edit</a><?php } ?></td>
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
		<h2 id="modal1Title">Add Warehouse</h2>
				<form role="form" id="form_add_data" method="POST" action="<?php echo base_url()."index.php/warehouse/addWarehouse" ?>" enctype="multipart/form-data">
				 <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
				 
              <div class="box-body">

				 <div class="form-group">
                  <label for="drivercode2">Warehouse Code</label>
                 <input type="text" class="form-control" name="warehouse_code" id="warehouse_code" required>
                </div>
				
				 <div class="form-group">
                  <label for="drivercode2">Warehouse Name</label>
                 <input type="text" class="form-control" name="warehouse_name" id="warehouse_name" required>
                </div>
				
				<div class="form-group">
                  <label for="drivercode2">Address 1</label>
                 <input type="text" class="form-control" name="address_1" id="address_1" required>
                </div>
				
				<div class="form-group">
                  <label for="drivercode2">Address 2</label>
                 <input type="text" class="form-control" name="address_2" id="address_2">
                </div>
				
				
				<div class="form-group">
                  <label for="drivercode2">Warehouse Type</label>
				  <select class="form-control" name="warehouse_type" id="warehouse_type" required>
					<option value="">Choose Warehouse type</option>
					<option value="tipe_1">Type 1</option>
					<option value="tipe_2">Type 2</option>
				  </select> 
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
		<h2 id="modal1Title">Edit Warehouse</h2>
				<form role="form" id="form_edit_data" method="POST" action="<?php echo base_url()."index.php/warehouse/editWarehouse" ?>" enctype="multipart/form-data">
				 <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
				 
              <div class="box-body">

				 <div class="form-group">
                  <label for="drivercode2">Warehouse Code</label>
                 <input type="text" class="form-control" name="edit_warehouse_code" id="edit_warehouse_code" required>
                </div>
				
				 <div class="form-group">
                  <label for="drivercode2">Warehouse Name</label>
                 <input type="text" class="form-control" name="edit_warehouse_name" id="edit_warehouse_name" required>
                </div>
				
				<div class="form-group">
                  <label for="drivercode2">Address 1</label>
                 <input type="text" class="form-control" name="edit_address_1" id="edit_address_1" required>
                </div>
				
				<div class="form-group">
                  <label for="drivercode2">Address 2</label>
                 <input type="text" class="form-control" name="edit_address_2" id="edit_address_2" >
                </div>
				
				
				<div class="form-group">
                  <label for="drivercode2">Warehouse Type</label>
				  <select class="form-control" name="edit_warehouse_type" id="edit_warehouse_type" required>
					<option selected="selected" value="">Choose Warehouse type</option>
					<option value="type_1">Type 1</option>
					<option value="type_2">Type 2</option>
				  </select> 
                </div>
				
				
                <input type="hidden" class="form-control" name="id_warehouse_update" id="id_warehouse_update">
              
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
		<h2 id="modal1Title">Import Warehouse</h2>
				<form role="form" id="form_import_data" method="POST" action="<?php echo base_url()."index.php/warehouse/importWarehouse" ?>" enctype="multipart/form-data">
				 <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
				 
              <div class="box-body">

				 <div class="form-group">
                      <label for="exampleInputEmail1">Choose File</label>
                      <input type="file" name="import_file" id="import_file" class="form-control" value="" />
				</div>
				
				 <div class="form-group">
                    <p><a target="_blank" href="<?php echo base_url('/files/example-files/import-warehouse.xlsx')?>">Download sample file import driver</a></p>
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
		<h2 id="modal1Title">Delete Warehouse</h2>
				<form role="form" id="form_delete_data" method="POST" action="<?php echo base_url()."index.php/warehouse/deleteWarehouse" ?>" enctype="multipart/form-data">
				 <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
				 
              <div class="box-body">

				 <div class="form-group">
                     <p>Are you sure want to delete this data? (<span id="reference_delete"></span>)</p>
				</div>
				
				 <div class="form-group">
                      <input type="hidden" name="id_warehouse_delete" id="id_warehouse_delete" class="form-control" value="" />
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
		<h2 id="modal1Title">Delete Warehouse</h2>
				<form role="form" id="form_selected_delete_data" method="POST" action="<?php echo base_url()."index.php/warehouse/deleteWarehouseAll" ?>" enctype="multipart/form-data">
				 <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
				 
              <div class="box-body">

				 <div class="form-group">
                     <p>Are you sure want to delete selected data? </p>
				</div>
				
				 <div class="form-group">
                      <input type="hidden" name="id_warehouse_delete_all" id="id_warehouse_delete_all" class="form-control" value="" />
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
				var warehouse_code =  $('#data_'+id+' .warehouse_code').text();
				var id_warehouse =  $('#data_'+id+' .id_warehouse span').text();
				$("#reference_delete").text("Warehouse Code:"+warehouse_code)
				$("#id_warehouse_delete").val(id_warehouse);
			});
			
			
			
			$(".edit_data").click(function(){
				var id = $(this).attr('id');
				var warehouse_code =  $('#data_'+id+' .warehouse_code').text();
				var id_warehouse =  $('#data_'+id+' .id_warehouse span').text();
				var warehouse_name =  $('#data_'+id+' .warehouse_name').text();
				var address_1 =  $('#data_'+id+' .address_1').text();
				var address_2 =  $('#data_'+id+' .address_2').text();
				var warehouse_type =  $('#data_'+id+' .warehouse_type').text();
				
				$("#id_warehouse_update").val(id_warehouse);
				$("#edit_warehouse_code").val(warehouse_code);
				$("#edit_warehouse_name").val(warehouse_name);
				$("#edit_address_1").val(address_1);
				$("#edit_address_2").val(address_2);
				$('#edit_warehouse_type option[value="' + warehouse_type + '"]').prop('selected',true);
			});

			$("#form_add_data").validate({
				
				messages: {
				warehouse_code: {
				required: 'Warehouse Code must be filled!'
				},
				warehouse_name: {
				required: 'Warehouse Name must be filled!'
				},
				address_1: {
				required: 'Address 1 must be filled!'
				},
				address_2: {
				required: 'Address 2 must be filled!'
				},
				warehouse_type: {
				required: 'Warehouse type must be filled!'
				}
			}
			});
			
			
			
			$("#form_edit_data").validate({
				messages: {
				warehouse_code: {
				required: 'Warehouse Code must be filled!'
				},
				warehouse_name: {
				required: 'Warehouse Name must be filled!'
				},
				address_1: {
				required: 'Address 1 must be filled!'
				},
				address_2: {
				required: 'Address 2 must be filled!'
				},
				warehouse_type: {
				required: 'Warehouse type must be filled!'
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
		$("#id_warehouse_delete_all").val(ids);
		
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
