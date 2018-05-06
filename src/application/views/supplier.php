 <!-- HEADER -->
 <section class="content-header">
          <h1>
            Supplier
            <small>List Of Supplier</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="<?php echo BASE_URL(); ?>"><i class="fa fa-dashboard"></i>Home</a></li>
            <li><a href="<?php echo BASE_URL()."supplier"; ?>"><i class="fa fa-dashboard"></i>Supplier</a></li>
          </ol>
        </section>
  
  
   <!-- Content -->
   <section class="content">
		
		
  
  
          <div class="box sms box-default color-palette-box">
            <div class="box-header with-border">
              <h3 class="box-title"><i class="fa fa-table"></i> Table Supplier</h3>
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
                             <form action="<?php echo base_url()."index.php/supplier" ?>" method="get">
                             <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                                <input type="text" id="search" name="search" placeholder="Search..."  value="<?php echo $search; ?>" />
                                <input type="submit" id="submit"  value="Search"/>
                                <?php if($search!="")
								{?>
                                <a href="<?php echo base_url()."index.php/supplier" ?>" id="clear-search">Clear Search</a>
                                <?php } ?>
                             </form>
                </div>
                <div id="wrapper-button" class="clearfix">
					<?php if($data_role[0]['export_supplier']=='yes'){ ?>
                	<a href="<?php echo base_url()."index.php/supplier/exportSupplier?search=".$search; ?>" class="button orange-button">
                    	Export Supplier
                    </a>
					<?php } ?>
                    <?php if($data_role[0]['add_supplier']=='yes'){ ?>
                    <a id="add-data" class="button green-button">
                    	Add Supplier
                    </a>
					<?php } ?>
					<?php if($data_role[0]['delete_supplier']=='yes'){ ?>
                    <a id="delete-data" class="button btn-danger deletelogg">
                    	Delete Supplier
                    </a>
					<?php } ?>
					<?php if($data_role[0]['import_supplier']=='yes'){ ?>
                    <a id="import-data" class="button blue-button">
                    	Import Supplier
                    </a>
					<?php } ?>
					
                </div>
                </div>
            <div id="wrapper-console" class="clearfix"> 
            <div class="grid_4 height400">                  
           	<table id="myTable04" class="fancyTable table-bordered table-hover">
                    <thead>
                      <tr>
					  
                        <th><div class="check-box-div"><input type="checkbox" name="select_all" id="select_all"></div>ID supplier</th>
                        <th>Supplier Code</th>
                        <th>Supplier name</th>
						<th>Address 1</th>
						<th>Address 2</th>
						<th>Supplier Type</th>
						<th>City</th>
						<th>Area</th>
						<th>Postal Code</th>
						<th>Phone</th>
						<th>Fax</th>
						<th>PIC</th>
						<th>Email</th>
						<th>Created By</th>
						<th>Created Time</th>
						<th>Updated By</th>
						<th>Updated Time</th>
						
						
						<?php if($data_role[0]['delete_supplier']=='yes' || $data_role[0]['edit_supplier']=='yes'){ ?>
						<th>Action</th>
						<?php } ?>
                      </tr>
                    </thead>
             		<tbody>
                    <?php foreach($data_supplier as $data_supplier) {?>
                    <tr id="data_<?php echo $data_supplier->id_supplier; ?>">
                    	<td class="id_supplier">
						<div class="check-box-div">
						<input type="checkbox" name="id_checkbox[]" class="iCheck-helper toedit checkbox_satuan" value="<?php echo $data_supplier->id_supplier; ?>" />
						</div><span><?php echo $data_supplier->id_supplier; ?></span></td>
                        <td class="supplier_code"><?php echo $data_supplier->supplier_code; ?></td>
                        <td class="supplier_name"><?php echo $data_supplier->supplier_name; ?></td>
						<td class="address_1"><?php echo $data_supplier->address_1; ?></td>
                        <td class="address_2"><?php echo $data_supplier->address_2; ?></td>
						
						<td class="supplier_type"><?php echo $data_supplier->supplier_type; ?></td>
						<td class="city"><?php echo $data_supplier->city; ?></td>
						<td class="area"><?php echo $data_supplier->area; ?></td>
						<td class="postal_code"><?php echo $data_supplier->postal_code; ?></td><td class="phone"><?php echo $data_supplier->phone; ?></td>
						<td class="fax"><?php echo $data_supplier->fax; ?></td>
						<td class="pic"><?php echo $data_supplier->pic; ?></td>
						<td class="email"><?php echo $data_supplier->email; ?></td>
						
						<td class="created_by"><?php echo $data_supplier->created_by; ?></td>
						<td class="created_time"><?php echo $data_supplier->created_time; ?></td>
						<td class="updated_by"><?php echo $data_supplier->updated_by; ?></td>
						<td class="updated_time"><?php echo $data_supplier->updated_time; ?></td>
						
						
						<?php if($data_role[0]['delete_supplier']=='yes' || $data_role[0]['edit_supplier']=='yes'){ ?>
						<td><?php if($data_role[0]['delete_supplier']=='yes'){ ?><a  class="delete_data link_action" id="<?php echo $data_supplier->id_supplier; ?>" >Delete</a><?php } ?> | <?php if($data_role[0]['edit_supplier']=='yes'){ ?><a  id="<?php echo $data_supplier->id_supplier; ?>" class="edit_data link_action">Edit</a><?php } ?></td>
						
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
		<h2 id="modal1Title">Add Supplier</h2>
				<form role="form" id="form_add_data" method="POST" action="<?php echo base_url()."index.php/supplier/addSupplier" ?>" enctype="multipart/form-data">
				 <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
				 
              <div class="box-body">

				 <div class="form-group">
                  <label for="drivercode2">Supplier Code</label>
                 <input type="text" class="form-control" name="supplier_code" id="supplier_code" required>
                </div>
				
				<div class="form-group">
                  <label for="drivercode2">Supplier Name</label>
                 <input type="text" class="form-control" name="supplier_name" id="supplier_name" required>
                </div>
				
				<div class="form-group">
                  <label for="drivercode2">Address 1</label>
				  <textarea class="form-control" name="address_1" id="address_1" required></textarea>
                </div>
				
				<div class="form-group">
                  <label for="drivercode2">Address 2</label>
				  <textarea class="form-control" name="address_2" id="address_2" ></textarea>
                </div>
				
				<div class="form-group">
                  <label for="drivercode2">Supplier Type</label>
				  <select class="form-control" name="supplier_type" id="supplier_type" required>
					<option selected="selected" value="">Choose Supplier Type</option>
					<option value="tipe_1">Type 1</option>
					<option value="tipe_2">Type 2</option>
				  </select> 
                </div>
				
				<div class="form-group">
                  <label for="drivercode2">City</label>
                 <input type="text" class="form-control" name="city" id="city" required>
                </div>
				
				<div class="form-group">
                  <label for="drivercode2">Postal Code</label>
                 <input type="text" class="form-control" name="postal_code" id="postal_code" required>
                </div>
				
				<div class="form-group">
                  <label for="drivercode2">Phone</label>
                 <input type="text" class="form-control" name="phone" id="phone" required>
                </div>
				
				<div class="form-group">
                  <label for="drivercode2">Fax</label>
                 <input type="text" class="form-control" name="fax" id="fax" required>
                </div>
				
				<div class="form-group">
                  <label for="drivercode2">PIC</label>
                 <input type="text" class="form-control" name="pic" id="pic" required>
                </div>
				
				<div class="form-group">
                  <label for="drivercode2">Email</label>
                 <input type="text" class="form-control" name="email" id="email" required>
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
		<h2 id="modal1Title">Edit Supplier</h2>
				<form role="form" id="form_edit_data" method="POST" action="<?php echo base_url()."index.php/supplier/editSupplier" ?>" enctype="multipart/form-data">
				 <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
              <div class="box-body">

				
				 <div class="form-group">
                  <label for="drivercode2">Supplier Code</label>
                 <input type="text" class="form-control" name="edit_supplier_code" id="edit_supplier_code" required>
                </div>
				
				<div class="form-group">
                  <label for="drivercode2">Supplier Name</label>
                 <input type="text" class="form-control" name="edit_supplier_name" id="edit_supplier_name" required>
                </div>
				
				<div class="form-group">
                  <label for="drivercode2">Address 1</label>
				  <textarea class="form-control" name="edit_address_1" id="edit_address_1" required></textarea>
                </div>
				
				<div class="form-group">
                  <label for="drivercode2">Address 2</label>
				  <textarea class="form-control" name="edit_address_2" id="edit_address_2" ></textarea>
                </div>
				
				<div class="form-group">
                  <label for="drivercode2">Supplier Type</label>
				  <select class="form-control" name="edit_supplier_type" id="edit_supplier_type" required>
					<option selected="selected" value="">Choose Supplier Type</option>
					<option value="tipe_1">Type 1</option>
					<option value="tipe_2">Type 2</option>
				  </select> 
                </div>
				
				<div class="form-group">
                  <label for="drivercode2">City</label>
                 <input type="text" class="form-control" name="edit_city" id="edit_city" required>
                </div>
				
				<div class="form-group">
                  <label for="drivercode2">Postal Code</label>
                 <input type="text" class="form-control" name="edit_postal_code" id="edit_postal_code" required>
                </div>
				
				<div class="form-group">
                  <label for="drivercode2">Phone</label>
                 <input type="text" class="form-control" name="edit_phone" id="edit_phone" required>
                </div>
				
				<div class="form-group">
                  <label for="drivercode2">Fax</label>
                 <input type="text" class="form-control" name="edit_fax" id="edit_fax" required>
                </div>
				
				<div class="form-group">
                  <label for="drivercode2">PIC</label>
                 <input type="text" class="form-control" name="edit_pic" id="edit_pic" required>
                </div>
				
				<div class="form-group">
                  <label for="drivercode2">Email</label>
                 <input type="text" class="form-control" name="edit_email" id="edit_email" required>
                </div>
				 
				 
                <input type="hidden" class="form-control" name="id_supplier_update" id="id_supplier_update">
              
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
		<h2 id="modal1Title">Import Supplier</h2>
				<form role="form" id="form_import_data" method="POST" action="<?php echo base_url()."index.php/supplier/importSupplier" ?>" enctype="multipart/form-data">
				 <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
				 
              <div class="box-body">

				 <div class="form-group">
                      <label for="exampleInputEmail1">Choose File</label>
                      <input type="file" name="import_file" id="import_file" class="form-control" value="" />
				</div>
				
				 <div class="form-group">
                    <p><a target="_blank" href="<?php echo base_url('/files/example-files/import-supplier.xlsx')?>">Download sample file import Supplier</a></p>
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
		<h2 id="modal1Title">Delete Supplier</h2>
				<form role="form" id="form_delete_data" method="POST" action="<?php echo base_url()."index.php/supplier/deleteSupplier" ?>" enctype="multipart/form-data">
				 <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
				 
              <div class="box-body">

				 <div class="form-group">
                     <p>Are you sure want to delete this data? (<span id="reference_delete"></span>)</p>
				</div>
				
				 <div class="form-group">
                      <input type="hidden" name="id_supplier_delete" id="id_supplier_delete" class="form-control" value="" />
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
		<h2 id="modal1Title">Delete Supplier</h2>
				<form role="form" id="form_selected_delete_data" method="POST" action="<?php echo base_url()."index.php/supplier/deleteSupplierAll" ?>" enctype="multipart/form-data">
				 <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
				 
              <div class="box-body">

				 <div class="form-group">
                     <p>Are you sure want to delete selected data? </p>
				</div>
				
				 <div class="form-group">
                      <input type="hidden" name="id_supplier_delete_all" id="id_supplier_delete_all" class="form-control" value="" />
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
				var supplier_code =  $('#data_'+id+' .supplier_code').text();
				var id_supplier =  $('#data_'+id+' .id_supplier span').text();
				$("#reference_delete").text("Supplier Code:"+supplier_code)
				$("#id_supplier_delete").val(id_supplier);
			});
			
			
			
			$(".edit_data").click(function(){
				var id = $(this).attr('id');
				var supplier_code =  $('#data_'+id+' .supplier_code').text();
				var id_supplier =  $('#data_'+id+' .id_supplier span').text();
				var supplier_name =  $('#data_'+id+' .supplier_name').text();
				var address_1 =  $('#data_'+id+' .address_1').text();
				var address_2 =  $('#data_'+id+' .address_2').text();
				var supplier_type =  $('#data_'+id+' .supplier_type').text();
				var city =  $('#data_'+id+' .city').text();
				var postal_code =  $('#data_'+id+' .postal_code').text();
				var phone =  $('#data_'+id+' .phone').text();
				var fax =  $('#data_'+id+' .fax').text();
				var pic =  $('#data_'+id+' .pic').text();
				var email =  $('#data_'+id+' .email').text();
				
				
				$("#edit_supplier_code").val(supplier_code);	
				$("#edit_supplier_name").val(supplier_name);
				$("#edit_address_1").val(address_1);
				$("#edit_address_2").val(address_2);
				$("#edit_city").val(city);
				$("#edit_postal_code").val(postal_code);
				$("#edit_phone").val(phone);
				$("#edit_fax").val(fax);
				$("#edit_pic").val(pic);
				$("#edit_email").val(email);
				$("#id_supplier_update").val(id_supplier);
				$('#edit_supplier_type option[value="' + supplier_type + '"]').prop('selected',true);
				
				
			});

			$("#form_add_data").validate({
				rules: {
				email: {
				  email: true
				}
				},
				messages: {
				supplier_code: {
				required: 'Supplier Code must be filled!'
				},
				supplier_name: {
				required: 'Driver Name must be filled!'
				},
				address_1: {
				required: 'Address 1 must be filled!'
				},
				supplier_type: {
				required: 'Supplier type must be filled!'
				},
				city: {
				required: 'City must be filled!'
				},
				postal_code: {
				required: 'Postal code must be filled!'
				},
				phone: {
				required: 'Phone must be filled!'
				},
				fax: {
				required: 'Fax must be filled!'
				},
				pic: {
				required: 'PIC must be filled!'
				},
				email: {
				required: 'Email must be filled!'
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
				edit_supplier_code: {
				required: 'Supplier Code must be filled!'
				},
				edit_supplier_name: {
				required: 'Driver Name must be filled!'
				},
				edit_address_1: {
				required: 'Address 1 must be filled!'
				},
				edit_supplier_type: {
				required: 'Supplier type must be filled!'
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
		$("#id_supplier_delete_all").val(ids);
		
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
