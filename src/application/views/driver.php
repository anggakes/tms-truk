 <!-- HEADER -->
 <section class="content-header">
          <h1>
            Driver
            <small>List Of Driver</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="<?php echo BASE_URL(); ?>"><i class="fa fa-dashboard"></i>Home</a></li>
            <li><a href="<?php echo BASE_URL()."driver"; ?>"><i class="fa fa-dashboard"></i>Driver</a></li>
          </ol>
        </section>
  
  
   <!-- Content -->
   <section class="content">
		
		
  
  
          <div class="box sms box-default color-palette-box">
            <div class="box-header with-border">
              <h3 class="box-title"><i class="fa fa-table"></i> Table Driver</h3>
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
                             <form action="<?php echo base_url()."index.php/driver" ?>" method="get">
                             <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                                <input type="text" id="search" name="search" placeholder="Search..."  value="<?php echo $search; ?>" />
                                <input type="submit" id="submit"  value="Search"/>
                                <?php if($search!="")
								{?>
                                <a href="<?php echo base_url()."index.php/driver" ?>" id="clear-search">Clear Search</a>
                                <?php } ?>
                             </form>
                </div>
                <div id="wrapper-button" class="clearfix">
					<?php if($data_role[0]['export_driver']=='yes'){ ?>
                	<a href="<?php echo base_url()."index.php/driver/exportDriver?search=".$search; ?>" class="button orange-button">
                    	Export Driver
                    </a>
					<?php } ?>
                    <?php if($data_role[0]['add_driver']=='yes'){ ?>
                    <a id="add-data" class="button green-button">
                    	Add Driver
                    </a>
					<?php } ?>
					<?php if($data_role[0]['delete_driver']=='yes'){ ?>
                    <a id="delete-data" class="button btn-danger deletelogg">
                    	Delete Driver
                    </a>
					<?php } ?>
					<?php if($data_role[0]['import_driver']=='yes'){ ?>
                    <a id="import-data" class="button blue-button">
                    	Import Driver
                    </a>
					<?php } ?>
					
                </div>
                </div>
            <div id="wrapper-console" class="clearfix"> 
            <div class="grid_4 height400">                  
           	<table id="myTable0w2" class="fancyTable table table-bordered table-hover">
                    <thead>
                      <tr>
					  
                        <th><div class="check-box-div"><input type="checkbox" name="select_all" id="select_all"></div>ID Driver</th>
                        <th>Driver Code</th>
                        <th>Driver name</th>
						<th>Driver License Type</th>
						<th>Driver License Number</th>
						<th>Employee Status</th>
						<?php if($data_role[0]['delete_driver']=='yes' || $data_role[0]['edit_driver']=='yes'){ ?>
						<th>Action</th>
						<?php } ?>
                      </tr>
                    </thead>
             		<tbody>
                    <?php foreach($data_driver as $data_driver) {?>
                    <tr id="data_<?php echo $data_driver->id_driver; ?>">
                    	<td class="id_driver">
						<div class="check-box-div">
						<input type="checkbox" name="id_checkbox[]" class="iCheck-helper toedit checkbox_satuan" value="<?php echo $data_driver->id_driver; ?>" />
						</div><span><?php echo $data_driver->id_driver; ?></span></td>
                        <td class="driver_code"><?php echo $data_driver->driver_code; ?></td>
                        <td class="driver_name"><?php echo $data_driver->driver_name; ?></td>
						<td class="driver_license_type"><?php echo $data_driver->driver_license_type; ?></td>
						<td class="driver_license_number"><?php echo $data_driver->driver_license_number; ?></td>
						<td class="employee_status"><?php echo $data_driver->employee_status; ?></td>
						<?php if($data_role[0]['delete_driver']=='yes' || $data_role[0]['edit_driver']=='yes'){ ?>
						<td><?php if($data_role[0]['delete_driver']=='yes'){ ?><a  class="delete_data link_action" id="<?php echo $data_driver->id_driver; ?>" >Delete</a><?php } ?> | <?php if($data_role[0]['edit_driver']=='yes'){ ?><a  id="<?php echo $data_driver->id_driver; ?>" class="edit_data link_action">Edit</a><?php } ?></td>
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
		<h2 id="modal1Title">Add Driver</h2>
				<form role="form" id="form_add_data" method="POST" action="<?php echo base_url()."index.php/driver/addDriver" ?>" enctype="multipart/form-data">
				 <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
				 
              <div class="box-body">

				 <div class="form-group">
                  <label for="drivercode2">Driver Code</label>
                 <input type="text" class="form-control" name="driver_code" id="driver_code" required>
                </div>
				
				<div class="form-group">
                  <label for="drivercode">Driver Name</label>
                  <input type="text" class="form-control" name="driver_name" id="driver_name" required>
                </div>
				
				<div class="form-group">
                  <label for="drivercode">Driver License Type</label>
                  <input type="text" class="form-control" name="driver_license_type" id="driver_license_type" required>
                </div>
				
				<div class="form-group">
                  <label for="drivercode">Driver License Number</label>
                  <input type="text" class="form-control" name="driver_license_number" id="driver_license_number" required>
                </div>
				
				<div class="form-group">
					  <label for="drivercode2">Employee Status</label>
					  <select class="form-control" name="employee_status" id="employee_status" required>
						<option selected="selected" value="">Choose Employee Status</option>
						    <?php foreach($data_category as $data_category1) {?>
							<option value='<?php echo $data_category1->description; ?>'><?php echo $data_category1->description; ?></option>
							<?php } ?>
					  </select> 
				</div>
				
					
                <div class="form-group">
                  <label for="exampleInputPassword1">Password</label>
                  <input type="password" class="form-control" name="password1" id="password1" required>
                </div>
				
				<div class="form-group">
                  <label for="exampleInputPassword1">Re type Password</label>
                  <input type="password" class="form-control" name="password2" id="password2" required>
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
		<h2 id="modal1Title">Edit Driver</h2>
				<form role="form" id="form_edit_data" method="POST" action="<?php echo base_url()."index.php/driver/editDriver" ?>" enctype="multipart/form-data">
				 <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
				 
              <div class="box-body">

				 <div class="form-group">
                  <label for="drivercode2">Driver Code</label>
                 <input type="text" class="form-control" name="edit_driver_code" id="edit_driver_code" required>
                </div>
				
				<div class="form-group">
                  <label for="drivercode">Driver Name</label>
                  <input type="text" class="form-control" name="edit_driver_name" id="edit_driver_name" required>
                </div>
				
				
				
				
				<div class="form-group">
                  <label for="drivercode">Driver License Type</label>
                  <input type="text" class="form-control" name="edit_driver_license_type" id="edit_driver_license_type" required>
                </div>
				
				<div class="form-group">
                  <label for="drivercode">Driver License Number</label>
                  <input type="text" class="form-control" name="edit_driver_license_number" id="edit_driver_license_number" required>
                </div>
				
				<div class="form-group">
					  <label for="drivercode2">Employee Status</label>
					  <select class="form-control" name="edit_employee_status" id="edit_employee_status" required>
						<option selected="selected" value="">Choose Employee Status</option>
							<?php foreach($data_category as $data_category2) {?>
							<option value='<?php echo $data_category2->description; ?>'><?php echo $data_category2->description; ?></option>
							<?php } ?>
					  </select> 
				</div>
				
				
				
                <div class="form-group">
                  <label for="exampleInputPassword1">New Password</label>
                  <input type="password" class="form-control" name="edit_password1" id="edit_password1">
                </div>
				
				<div class="form-group">
                  <label for="exampleInputPassword1">Re type Password</label>
                  <input type="password" class="form-control" name="edit_password2" id="edit_password2">
                </div>
                <input type="hidden" class="form-control" name="id_driver_update" id="id_driver_update">
              
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
		<h2 id="modal1Title">Import Driver</h2>
				<form role="form" id="form_import_data" method="POST" action="<?php echo base_url()."index.php/driver/importDriver" ?>" enctype="multipart/form-data">
				 <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
				 
              <div class="box-body">

				 <div class="form-group">
                      <label for="exampleInputEmail1">Choose File</label>
                      <input type="file" name="import_file" id="import_file" class="form-control" value="" />
				</div>
				
				 <div class="form-group">
                    <p><a target="_blank" href="<?php echo base_url('/files/example-files/import-driver.xlsx')?>">Download sample file import driver</a></p>
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
		<h2 id="modal1Title">Delete Driver</h2>
				<form role="form" id="form_delete_data" method="POST" action="<?php echo base_url()."index.php/driver/deleteDriver" ?>" enctype="multipart/form-data">
				 <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
				 
              <div class="box-body">

				 <div class="form-group">
                     <p>Are you sure want to delete this data? (<span id="reference_delete"></span>)</p>
				</div>
				
				 <div class="form-group">
                      <input type="hidden" name="id_driver_delete" id="id_driver_delete" class="form-control" value="" />
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
		<h2 id="modal1Title">Delete Driver</h2>
				<form role="form" id="form_selected_delete_data" method="POST" action="<?php echo base_url()."index.php/driver/deleteDriverAll" ?>" enctype="multipart/form-data">
				 <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
				 
              <div class="box-body">

				 <div class="form-group">
                     <p>Are you sure want to delete selected data? </p>
				</div>
				
				 <div class="form-group">
                      <input type="hidden" name="id_driver_delete_all" id="id_driver_delete_all" class="form-control" value="" />
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
				var driver_code =  $('#data_'+id+' .driver_code').text();
				var id_driver =  $('#data_'+id+' .id_driver span').text();
				$("#reference_delete").text("Driver Code:"+driver_code)
				$("#id_driver_delete").val(id_driver);
			});
			
			
			
			$(".edit_data").click(function(){
				var id = $(this).attr('id');
				var driver_code =  $('#data_'+id+' .driver_code').text();
				var id_driver =  $('#data_'+id+' .id_driver span').text();
				var driver_name =  $('#data_'+id+' .driver_name').text();
				var driver_license_number =  $('#data_'+id+' .driver_license_number').text();
				var driver_license_type =  $('#data_'+id+' .driver_license_type').text();
				var employee_status =  $('#data_'+id+' .employee_status').text();
				
				$("#id_driver_update").val(id_driver);
				$("#edit_driver_code").val(driver_code);
				$("#edit_driver_name").val(driver_name);
				$("#edit_driver_license_number").val(driver_license_number);
				$("#edit_driver_license_type").val(driver_license_type);
				$("#edit_employee_status").val(employee_status);
			});

			$("#form_add_data").validate({
				rules: {
				password2: {
				  equalTo: "#password1"
				}
				},
				messages: {
				driver_name: {
				required: 'Driver Name must be filled!'
				},
				driver_code: {
				required: 'Driver Code must be filled!'
				},
				driver_license_number: {
				required: 'Driver License Number must be filled!'
				},
				driver_license_type: {
				required: 'Driver License Type must be filled!'
				},
				employee_status: {
				required: 'Employee Status must be filled!'
				},
				password1: {
				required: 'Password must be filled!'
				},
				password2: {
				required: 'Retype Password must be filled!'
				}
			}
			});
			
			
			
			$("#form_edit_data").validate({
				rules: {
				edit_password2: {
				  equalTo: "#edit_password1"
				}
				},
				messages: {
				edit_driver_name: {
				required: 'Driver Name must be filled!'
				},
				edit_driver_code: {
				required: 'Driver Code must be filled!'
				},
				edit_driver_license_number: {
				required: 'Driver License Number must be filled!'
				},
				edit_driver_license_type: {
				required: 'Driver License Type must be filled!'
				},
				edit_employee_status: {
				required: 'Employee Status must be filled!'
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
		$("#id_driver_delete_all").val(ids);
		
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
