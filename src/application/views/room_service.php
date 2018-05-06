 <!-- HEADER -->
 <section class="content-header">
          <h1>
            Workshop Bay
            <small>List Of Workshop Bay</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="<?php echo BASE_URL(); ?>"><i class="fa fa-dashboard"></i>Home</a></li>
            <li><a href="<?php echo BASE_URL()."index.php/room_service"; ?>"><i class="fa fa-dashboard"></i>Workshop Bay</a></li>
          </ol>
        </section>
  
  
   <!-- Content -->
   <section class="content">
		
		
  
  
          <div class="box sms box-default color-palette-box">
            <div class="box-header with-border">
              <h3 class="box-title"><i class="fa fa-table"></i> Table Workshop Bay</h3>
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
                             <form action="<?php echo base_url()."index.php/room_service" ?>" method="get">
                             <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                                <input type="text" id="search" name="search" placeholder="Search..."  value="<?php echo $search; ?>" />
                                <input type="submit" id="submit"  value="Search"/>
                                <?php if($search!="")
								{?>
                                <a href="<?php echo base_url()."index.php/room_service" ?>" id="clear-search">Clear Search</a>
                                <?php } ?>
                             </form>
                </div>
                <div id="wrapper-button" class="clearfix">
					<?php if($data_role[0]['export_room_service']=='yes'){ ?>
                	<a href="<?php echo base_url()."index.php/room_service/exportRoomService?search=".$search; ?>" class="button orange-button">
                    	Export Workshop Bay
                    </a>
					<?php } ?>
                    <?php if($data_role[0]['add_room_service']=='yes'){ ?>
                    <a id="add-data" class="button green-button">
                    	Add Workshop Bay
                    </a>
					<?php } ?>
					<?php if($data_role[0]['delete_room_service']=='yes'){ ?>
                    <a id="delete-data" class="button btn-danger deletelogg">
                    	Delete Workshop Bay
                    </a>
					<?php } ?>
					<?php if($data_role[0]['import_room_service']=='yes'){ ?>
                    <a id="import-data" class="button blue-button">
                    	Import Workshop Bay
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
                        <th>Workshop Bay ID</th>
                        <th>Workshop Bay Name</th>
						<?php if($data_role[0]['delete_room_service']=='yes' || $data_role[0]['edit_room_service']=='yes'){ ?>
						<th>Action</th>
						<?php } ?>
                      </tr>
                    </thead>
             		<tbody>
                    <?php foreach($data_room_service as $data_room_service) {?>
                    <tr id="data_<?php echo $data_room_service->id_room_service; ?>">
                    	<td class="id_room_service">
						<div class="check-box-div">
						<input type="checkbox" name="id_checkbox[]" class="iCheck-helper toedit checkbox_satuan" value="<?php echo $data_room_service->id_room_service; ?>" />
						</div><span><?php echo $data_room_service->id_room_service; ?></span></td>
                        <td class="room_service_id"><?php echo $data_room_service->room_service_id; ?></td>
                        <td class="room_service_name"><?php echo $data_room_service->room_service_name; ?></td>
						<?php if($data_role[0]['delete_room_service']=='yes' || $data_role[0]['edit_room_service']=='yes'){ ?>
						<td><?php if($data_role[0]['delete_room_service']=='yes'){ ?><a  class="delete_data link_action" id="<?php echo $data_room_service->id_room_service; ?>" >Delete</a><?php } ?> | <?php if($data_role[0]['edit_room_service']=='yes'){ ?><a  id="<?php echo $data_room_service->id_room_service; ?>" class="edit_data link_action">Edit</a><?php } ?></td>
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
		<h2 id="modal1Title">Add Workshop Bay</h2>
				<form role="form" id="form_add_data" method="POST" action="<?php echo base_url()."index.php/room_service/addRoomService" ?>" enctype="multipart/form-data">
				 <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
				 
              <div class="box-body">

				 <div class="form-group">
                  <label for="drivercode2">Workshop Bay ID</label>
                 <input type="text" class="form-control" name="room_service_id" id="room_service_id" required>
                </div>
				
				<div class="form-group">
                  <label for="drivercode">Workshop Bay name</label>
                  <input type="text" class="form-control" name="room_service_name" id="room_service_name" required>
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
		<h2 id="modal1Title">Edit Workshop Bay</h2>
				<form role="form" id="form_edit_data" method="POST" action="<?php echo base_url()."index.php/room_service/editRoomService" ?>" enctype="multipart/form-data">
				 <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
				 
              <div class="box-body">

				 
				 <div class="form-group">
                  <label for="drivercode2">Workshop Bay ID</label>
                 <input type="text" class="form-control" name="edit_room_service_id" id="edit_room_service_id" required>
                </div>
				
				<div class="form-group">
                  <label for="drivercode">Workshop Bay Description</label>
                  <input type="text" class="form-control" name="edit_room_service_name" id="edit_room_service_name" required>
                </div>
				
               
                <input type="hidden" class="form-control" name="id_room_service_update" id="id_room_service_update">
              
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
		<h2 id="modal1Title">Import Workshop Bay</h2>
				<form role="form" id="form_import_data" method="POST" action="<?php echo base_url()."index.php/room_service/importRoomService" ?>" enctype="multipart/form-data">
				 <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
				 
              <div class="box-body">

				 <div class="form-group">
                      <label for="exampleInputEmail1">Choose File</label>
                      <input type="file" name="import_file" id="import_file" class="form-control" value="" />
				</div>
				
				 <div class="form-group">
                    <p><a target="_blank" href="<?php echo base_url('/files/example-files/import-room-service.xlsx')?>">Download sample file import Workshop Bay</a></p>
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
		<h2 id="modal1Title">Delete Workshop Bay</h2>
				<form role="form" id="form_delete_data" method="POST" action="<?php echo base_url()."index.php/room_service/deleteRoomService" ?>" enctype="multipart/form-data">
				 <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
				 
              <div class="box-body">

				 <div class="form-group">
                     <p>Are you sure want to delete this data? (<span id="reference_delete"></span>)</p>
				</div>
				
				 <div class="form-group">
                      <input type="hidden" name="id_room_service_delete" id="id_room_service_delete" class="form-control" value="" />
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
		<h2 id="modal1Title">Delete Workshop Bay</h2>
				<form role="form" id="form_selected_delete_data" method="POST" action="<?php echo base_url()."index.php/room_service/deleteRoomServiceAll" ?>" enctype="multipart/form-data">
				 <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
				 
              <div class="box-body">

				 <div class="form-group">
                     <p>Are you sure want to delete selected data? </p>
				</div>
				
				 <div class="form-group">
                      <input type="hidden" name="id_room_service_delete_all" id="id_room_service_delete_all" class="form-control" value="" />
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
				var room_service_id =  $('#data_'+id+' .room_service_id').text();
				var id_room_service =  $('#data_'+id+' .id_room_service span').text();
				$("#reference_delete").text("Workshop Bay ID:"+room_service_id)
				$("#id_room_service_delete").val(id_room_service);
			});
			
			
			
			$(".edit_data").click(function(){
				var id = $(this).attr('id');
				var room_service_id =  $('#data_'+id+' .room_service_id').text();
				var id_room_service =  $('#data_'+id+' .id_room_service span').text();
				var room_service_name =  $('#data_'+id+' .room_service_name').text();
				
				
				$("#id_room_service_update").val(id_room_service);
				$("#edit_room_service_id").val(room_service_id);
				$("#edit_room_service_name").val(room_service_name);
				
			});

			$("#form_add_data").validate({
				
				messages: {
				room_service_id: {
				required: 'Workshop Bay ID must be filled!'
				},
				room_service_name: {
				required: 'Workshop Bay Description must be filled!'
				}
			}
			});
			
			
			
			$("#form_edit_data").validate({
				
				messages: {
				edit_room_service_id: {
				required: 'Workshop Bay ID must be filled!'
				},
				edit_room_service_name: {
				required: 'Workshop Bay Name must be filled!'
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
		$("#id_room_service_delete_all").val(ids);
		
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
