 <!-- HEADER -->
 <section class="content-header">
          <h1>
            Customer
            <small>List Of Customer</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="<?php echo BASE_URL(); ?>"><i class="fa fa-dashboard"></i>Home</a></li>
            <li><a href="<?php echo BASE_URL()."customer"; ?>"><i class="fa fa-dashboard"></i>Customer</a></li>
          </ol>
        </section>
  
  
   <!-- Content -->
   <section class="content">
          <div class="box sms box-default color-palette-box">
            <div class="box-header with-border">
              <h3 class="box-title"><i class="fa fa-table"></i> Table Customer</h3>
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
                             <form action="<?php echo base_url()."index.php/customer" ?>" method="get">
                             <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                                <input type="text" id="search" name="search" placeholder="Search..."  value="<?php echo $search; ?>" />
                                <input type="submit" id="submit"  value="Search"/>
                                <?php if($search!="")
								{?>
                                <a href="<?php echo base_url()."index.php/customer" ?>" id="clear-search">Clear Search</a>
                                <?php } ?>
                             </form>
                </div>
                <div id="wrapper-button" class="clearfix">
					<?php if($data_role[0]['export_customer']=='yes'){ ?>
                	<a href="<?php echo base_url()."index.php/customer/exportCustomer?search=".$search; ?>" class="button orange-button">
                    	Export Customer
                    </a>
					<?php } ?>
                    <?php if($data_role[0]['add_customer']=='yes'){ ?>
                    <a id="add-data" class="button green-button">
                    	Add Customer
                    </a>
					<?php } ?>
					<?php if($data_role[0]['delete_customer']=='yes'){ ?>
                    <a id="delete-data" class="button btn-danger deletelogg">
                    	Delete Customer
                    </a>
					<?php } ?>
					<?php if($data_role[0]['import_customer']=='yes'){ ?>
                    <a id="import-data" class="button blue-button">
                    	Import Customer
                    </a>
					<?php } ?>
					
                </div>
                </div>
            <div id="wrapper-console" class="clearfix"> 
            <div class="grid_4 height400">                  
           	<table id="myTable03" class="fancyTable table table-bordered table-hover">
                    <thead>
                      <tr>
                        <th><div class="check-box-div"><input type="checkbox" name="select_all" id="select_all"></div>ID</th>
                        <th>Customer ID</th>
                        <th>Customer Name</th>
						<th>Address 1</th>
						<th>Address 2</th>
						<th>City</th>
						<th>Area</th>
						<th>Postal Code</th>
						<th>Pic</th>
						<th>Email</th>
						<th>Latitude</th>
						<th>Longitude</th>
						<?php if($data_role[0]['delete_customer']=='yes' || $data_role[0]['edit_customer']=='yes'){ ?>
						<th>Action</th>
						<?php } ?>
                      </tr>
                    </thead>
             		<tbody>
                    <?php foreach($data_customer as $data_customer) {?>
                    <tr id="data_<?php echo $data_customer->id_customer; ?>">
                    	<td class="id_customer">
						<div class="check-box-div">
						<input type="checkbox" name="id_checkbox[]" class="iCheck-helper toedit checkbox_satuan" value="<?php echo $data_customer->id_customer; ?>" />
						</div><span><?php echo $data_customer->id_customer; ?></span></td>
						
                        <td class="customer_id"><?php echo $data_customer->customer_id; ?></td>
						<td class="customer_name"><?php echo $data_customer->customer_name; ?></td>
						<td class="customer_address_1"><?php echo $data_customer->customer_address_1; ?></td>
						<td class="customer_address_2"><?php echo $data_customer->customer_address_2; ?></td>
						<td class="customer_city"><?php echo $data_customer->customer_city; ?></td>
						<td class="area"><?php echo $data_customer->area; ?></td>
						<td class="postal_code"><?php echo $data_customer->postal_code; ?></td>
						<td class="pic"><?php echo $data_customer->pic; ?></td>
						<td class="email"><?php echo $data_customer->email; ?></td>
						<td class="customer_latitude"><?php echo $data_customer->customer_latitude; ?></td>
						<td class="customer_longitude"><?php echo $data_customer->customer_longitude; ?></td>
						
						
						<?php if($data_role[0]['delete_customer']=='yes' || $data_role[0]['edit_customer']=='yes'){ ?>
						<td><?php if($data_role[0]['delete_customer']=='yes'){ ?><a  class="delete_data link_action" id="<?php echo $data_customer->id_customer; ?>" >Delete</a><?php } ?> | <?php if($data_role[0]['edit_customer']=='yes'){ ?><a  id="<?php echo $data_customer->id_customer; ?>" class="edit_data link_action">Edit</a><?php } ?></td>
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
		<h2 id="modal1Title">Add Customer</h2>
				<form role="form" id="form_add_data" method="POST" action="<?php echo base_url()."index.php/customer/addCustomer" ?>" enctype="multipart/form-data">
				 <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
				 
              <div class="box-body">
				
				
				<div class="form-group">
                  <label for="drivercode2">Customer ID</label>
                 <input type="text" class="form-control" name="customer_id" id="customer_id" required>
                </div>
				
				
				<div class="form-group">
                  <label for="drivercode2">Customer Name</label>
                 <input type="text" class="form-control" name="customer_name" id="customer_name" required>
                </div>
				
				<div class="form-group">
                  <label for="drivercode2">Customer Address 1</label>
                 <input type="text" class="form-control" name="customer_address_1" id="customer_address_1" required>
                </div>
				
				<div class="form-group">
                  <label for="drivercode2">Customer Address 2</label>
                 <input type="text" class="form-control" name="customer_address_2" id="customer_address_2">
                </div>
				
				
				
				<div class="form-group">
                  <label for="drivercode2">Customer City</label>
                 <input type="text" class="form-control" name="customer_city" id="customer_city" required>
                </div>
				
               <div class="form-group">
					 <label>Area</label>
						<div class="input-group">
						  <div class="input-group-addon">
							<i class="fa fa-search"></i>
						  </div>
						  <input type="text" class="form-control pull-right" name="search_area" id="search_area" value=''n placeholder='Search Area'>
						  <input type="text" readonly class="form-control" name="area" id="area" placeholder='Area' required>
						</div>
						<!-- /.input group -->
				</div>
				
				<div class="form-group">
                  <label for="drivercode2">Postal Code</label>
                 <input type="text" class="form-control" name="postal_code" id="postal_code" >
                </div>
				
				<div class="form-group">
                  <label for="drivercode2">PIC</label>
                 <input type="text" class="form-control" name="pic" id="pic" >
                </div>
				
				<div class="form-group">
                  <label for="drivercode2">Email</label>
                 <input type="text" class="form-control" name="email" id="email" >
                </div>
				
				<div class="form-group">
                  <label for="drivercode2">Customer Latitude</label>
                 <input type="text" class="form-control" name="customer_latitude" id="customer_latitude" >
                </div>
				
				<div class="form-group">
                  <label for="drivercode2">Customer Longitude</label>
                 <input type="text" class="form-control" name="customer_longitude" id="customer_longitude" >
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
		<h2 id="modal1Title">Edit Customer</h2>
				<form role="form" id="form_edit_data" method="POST" action="<?php echo base_url()."index.php/customer/editCustomer" ?>" enctype="multipart/form-data">
				 <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
				 
              <div class="box-body">

				 
				 <div class="form-group">
                  <label for="drivercode2">Customer ID</label>
                 <input type="text" class="form-control" name="edit_customer_id" id="edit_customer_id" required>
                </div>
				
				
				 <div class="form-group">
                  <label for="drivercode2">Customer Name</label>
                 <input type="text" class="form-control" name="edit_customer_name" id="edit_customer_name" required>
                </div>
				
				<div class="form-group">
                  <label for="drivercode2">Customer Address 1</label>
                 <input type="text" class="form-control" name="edit_customer_address_1" id="edit_customer_address_1" required>
                </div>
				
				<div class="form-group">
                  <label for="drivercode2">Customer Address 2</label>
                 <input type="text" class="form-control" name="edit_customer_address_2" id="edit_customer_address_2">
                </div>
				
				
				
				<div class="form-group">
                  <label for="drivercode2">Customer City</label>
                 <input type="text" class="form-control" name="edit_customer_city" id="edit_customer_city" required>
                </div>
				
               <div class="form-group">
					 <label>Area</label>
						<div class="input-group">
						  <div class="input-group-addon">
							<i class="fa fa-search"></i>
						  </div>
						  <input type="text" class="form-control pull-right" name="edit_search_area" id="edit_search_area" value=''n placeholder='Search Area'>
						  <input type="text" readonly class="form-control" name="edit_area" id="edit_area" placeholder='Area' required>
						</div>
						<!-- /.input group -->
				</div>
				
				<div class="form-group">
                  <label for="drivercode2">Postal Code</label>
                 <input type="text" class="form-control" name="edit_postal_code" id="edit_postal_code" >
                </div>
				
				<div class="form-group">
                  <label for="drivercode2">PIC</label>
                 <input type="text" class="form-control" name="edit_pic" id="edit_pic" >
                </div>
				
				<div class="form-group">
                  <label for="drivercode2">Email</label>
                 <input type="text" class="form-control" name="edit_email" id="edit_email" >
                </div>
				
				<div class="form-group">
                  <label for="drivercode2">Customer Latitude</label>
                 <input type="text" class="form-control" name="edit_customer_latitude" id="edit_customer_latitude" >
                </div>
				
				<div class="form-group">
                  <label for="drivercode2">Customer Longitude</label>
                 <input type="text" class="form-control" name="edit_customer_longitude" id="edit_customer_longitude" >
                </div>
				
                <input type="hidden" class="form-control" name="id_customer_update" id="id_customer_update">
              
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
		<h2 id="modal1Title">Import Customer</h2>
				<form role="form" id="form_import_data" method="POST" action="<?php echo base_url()."index.php/customer/importCustomer" ?>" enctype="multipart/form-data">
				 <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
				 
              <div class="box-body">

				 <div class="form-group">
                      <label for="exampleInputEmail1">Choose File</label>
                      <input type="file" name="import_file" id="import_file" class="form-control" value="" />
				</div>
				
				 <div class="form-group">
                    <p><a target="_blank" href="<?php echo base_url('/files/example-files/import-customer.xlsx')?>">Download sample file import Customer</a></p>
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
		<h2 id="modal1Title">Delete Customer</h2>
				<form role="form" id="form_delete_data" method="POST" action="<?php echo base_url()."index.php/customer/deleteCustomer" ?>" enctype="multipart/form-data">
				 <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
				 
              <div class="box-body">

				 <div class="form-group">
                     <p>Are you sure want to delete this data? (<span id="reference_delete"></span>)</p>
				</div>
				
				 <div class="form-group">
                      <input type="hidden" name="id_customer_delete" id="id_customer_delete" class="form-control" value="" />
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
		<h2 id="modal1Title">Delete Customer</h2>
				<form role="form" id="form_selected_delete_data" method="POST" action="<?php echo base_url()."index.php/customer/deleteCustomerAll" ?>" enctype="multipart/form-data">
				 <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
				 
              <div class="box-body">

				 <div class="form-group">
                     <p>Are you sure want to delete selected data? </p>
				</div>
				
				 <div class="form-group">
                      <input type="hidden" name="id_customer_delete_all" id="id_customer_delete_all" class="form-control" value="" />
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
				var customer_id =  $('#data_'+id+' .customer_id').text();
				var id_customer =  $('#data_'+id+' .id_customer span').text();
				$("#reference_delete").text("Customer ID:"+customer_id)
				$("#id_customer_delete").val(id_customer);
			});
			
			
			
			$(".edit_data").click(function(){
				var id = $(this).attr('id');
				var customer_id  =  $('#data_'+id+' .customer_id').text();
				var id_customer =  $('#data_'+id+' .id_customer span').text();
				var customer_name =  $('#data_'+id+' .customer_name').text();
				var customer_address_1 =  $('#data_'+id+' .customer_address_1').text();
				var customer_address_2 =  $('#data_'+id+' .customer_address_2').text();
				var customer_city =  $('#data_'+id+' .customer_city').text();
				var area =  $('#data_'+id+' .area').text();
				var postal_code =  $('#data_'+id+' .postal_code').text();
				var pic =  $('#data_'+id+' .pic').text();
				var email =  $('#data_'+id+' .email').text();				
				var customer_latitude =  $('#data_'+id+' .customer_latitude').text();	
				var customer_longitude =  $('#data_'+id+' .customer_longitude').text();	
				
				$("#id_customer_update").val(id_customer);
				$("#edit_customer_id").val(customer_id);
				$("#edit_id_customer").val(id_customer);
				$("#edit_customer_name").val(customer_name);
				$("#edit_customer_address_1").val(customer_address_1);
				$("#edit_customer_address_2").val(customer_address_2);
				$("#edit_customer_city").val(customer_city);
				$("#edit_area").val(area);
				$("#edit_postal_code").val(postal_code);
				$("#edit_pic").val(pic);
				$("#edit_email").val(email);
				$("#edit_customer_latitude").val(customer_latitude);
				$("#edit_customer_longitude").val(customer_longitude);
				
			});

			$("#form_add_data").validate({
				
				messages: {
				customer_id: {
				required: 'Customer ID must be filled!'
				},
				customer_name: {
				required: 'Customer Name must be filled!'
				},
				customer_address_1: {
				required: 'Customer Address 1 must be filled!'
				},
				customer_city: {
				required: 'City must be filled!'
				},
				area: {
				required: 'Area must be filled!'
				},
				postal_code: {
				required: 'Postal Code must be filled!'
				},
				pic: {
				required: 'PIC must be filled!'
				},
				email: {
				required: 'Email must be filled!'
				},
				customer_latitude: {
				required: 'Customer Latitude must be filled!'
				},
				customer_longitude: {
				required: 'Customer Longitude must be filled!'
				}
				
				
			}
			});
			
			
			
			$("#form_edit_data").validate({
				
				messages: {
				edit_customer_id: {
				required: 'Customer ID must be filled!'
				},
				edit_customer_name: {
				required: 'Customer Name must be filled!'
				},
				edit_customer_address_1: {
				required: 'Customer Address 1 must be filled!'
				},
				edit_customer_city: {
				required: 'City must be filled!'
				},
				edit_area: {
				required: 'Area must be filled!'
				},
				edit_postal_code: {
				required: 'Postal Code must be filled!'
				},
				edit_pic: {
				required: 'PIC must be filled!'
				},
				edit_email: {
				required: 'Email must be filled!'
				},
				edit_customer_latitude: {
				required: 'Customer Latitude must be filled!'
				},
				edit_customer_longitude: {
				required: 'Customer Longitude must be filled!'
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
		$("#id_customer_delete_all").val(ids);
		
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


<script>
		//auto complete Area
        $( "#search_area" ).autocomplete({
         source: "<?php echo BASE_URL(); ?>/index.php/json/jsonArea",  
         minLength:0,
		 select: function( event , ui ) {
			  $( "#area" ).val(ui.item.area_id);
			  $(this).val('');
			  return false;
			  
        }    
        })
		.autocomplete( "instance" )._renderItem = function( ul, item ) {
		  return $( "<li style='position:relative; z-index:9999;'>" )
			.append( "<div style='font-size:10px;'>" + item.label +"</div>" )
			.appendTo( ul );
		};
		
		//auto complete Edit Area
        $( "#edit_search_area" ).autocomplete({
         source: "<?php echo BASE_URL(); ?>/index.php/json/jsonArea",  
         minLength:0,
		 select: function( event , ui ) {
			  $( "#edit_area" ).val(ui.item.area_id);
			  $(this).val('');
			  return false;
			  
        }    
        })
		.autocomplete( "instance" )._renderItem = function( ul, item ) {
		  return $( "<li style='position:relative; z-index:9999;'>" )
			.append( "<div style='font-size:10px;'>" + item.label +"</div>" )
			.appendTo( ul );
		};
		
		</script>