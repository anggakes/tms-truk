 <!-- HEADER -->
 <section class="content-header">
          <h1>
            Area
            <small>List Of Area</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="<?php echo BASE_URL(); ?>"><i class="fa fa-dashboard"></i>Home</a></li>
            <li><a href="<?php echo BASE_URL()."area"; ?>"><i class="fa fa-dashboard"></i>Area</a></li>
          </ol>
        </section>
  
  
   <!-- Content -->
   <section class="content">
		
		
  
  
          <div class="box sms box-default color-palette-box">
            <div class="box-header with-border">
              <h3 class="box-title"><i class="fa fa-table"></i> Table Area</h3>
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
                             <form action="<?php echo base_url()."index.php/area" ?>" method="get">
                             <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                                <input type="text" id="search" name="search" placeholder="Search..."  value="<?php echo $search; ?>" />
                                <input type="submit" id="submit"  value="Search"/>
                                <?php if($search!="")
								{?>
                                <a href="<?php echo base_url()."index.php/area" ?>" id="clear-search">Clear Search</a>
                                <?php } ?>
                             </form>
                </div>
                <div id="wrapper-button" class="clearfix">
					<?php if($data_role[0]['export_area']=='yes'){ ?>
                	<a href="<?php echo base_url()."index.php/area/exportArea?search=".$search; ?>" class="button orange-button">
                    	Export Area
                    </a>
					<?php } ?>
                    <?php if($data_role[0]['add_area']=='yes'){ ?>
                    <a id="add-data" class="button green-button">
                    	Add Area
                    </a>
					<?php } ?>
					<?php if($data_role[0]['delete_area']=='yes'){ ?>
                    <a id="delete-data" class="button btn-danger deletelogg">
                    	Delete Area
                    </a>
					<?php } ?>
					<?php if($data_role[0]['import_area']=='yes'){ ?>
                    <a id="import-data" class="button blue-button">
                    	Import Area
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
                        <th>Area ID</th>
                        <th>Area Description</th>
						<th>Area Type</th>
						<?php if($data_role[0]['delete_area']=='yes' || $data_role[0]['edit_area']=='yes'){ ?>
						<th>Action</th>
						<?php } ?>
                      </tr>
                    </thead>
             		<tbody>
                    <?php foreach($data_area as $data_area) {?>
                    <tr id="data_<?php echo $data_area->id_area; ?>">
                    	<td class="id_area">
						<div class="check-box-div">
						<input type="checkbox" name="id_checkbox[]" class="iCheck-helper toedit checkbox_satuan" value="<?php echo $data_area->id_area; ?>" />
						</div><span><?php echo $data_area->id_area; ?></span></td>
                        <td class="area_id"><?php echo $data_area->area_id; ?></td>
                        <td class="area_description"><?php echo $data_area->area_description; ?></td>
						<td class="area_type"><?php echo $data_area->area_type; ?></td>
						<?php if($data_role[0]['delete_area']=='yes' || $data_role[0]['edit_area']=='yes'){ ?>
						<td><?php if($data_role[0]['delete_area']=='yes'){ ?><a  class="delete_data link_action" id="<?php echo $data_area->id_area; ?>" >Delete</a><?php } ?> | <?php if($data_role[0]['edit_area']=='yes'){ ?><a  id="<?php echo $data_area->id_area; ?>" class="edit_data link_action">Edit</a><?php } ?></td>
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
		<h2 id="modal1Title">Add Area</h2>
				<form role="form" id="form_add_data" method="POST" action="<?php echo base_url()."index.php/area/addArea" ?>" enctype="multipart/form-data">
				 <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
				 
              <div class="box-body">

				 <div class="form-group">
                  <label for="drivercode2">Area ID</label>
                 <input type="text" class="form-control" name="area_id" id="area_id" required>
                </div>
				
				<div class="form-group">
                  <label for="drivercode">Area Description</label>
                  <input type="text" class="form-control" name="area_description" id="area_description" required>
                </div>
				
                <div class="form-group">
					  <label for="drivercode2">Area Type</label>
					  <select class="form-control" name="area_type" id="area_type" required>
						<option selected="selected" value="">Choose Area Type</option>
							<?php foreach($data_category as $data_category1) {?>
							<option value='<?php echo $data_category1->description; ?>'><?php echo $data_category1->description; ?></option>
							<?php } ?>
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
		<h2 id="modal1Title">Edit Area</h2>
				<form role="form" id="form_edit_data" method="POST" action="<?php echo base_url()."index.php/area/editArea" ?>" enctype="multipart/form-data">
				 <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
				 
              <div class="box-body">

				 
				 <div class="form-group">
                  <label for="drivercode2">Area ID</label>
                 <input type="text" class="form-control" name="edit_area_id" id="edit_area_id" required>
                </div>
				
				<div class="form-group">
                  <label for="drivercode">Area Description</label>
                  <input type="text" class="form-control" name="edit_area_description" id="edit_area_description" required>
                </div>
				
                <div class="form-group">
					  <label for="drivercode2">Area Type</label>
					  <select class="form-control" name="edit_area_type" id="edit_area_type" required>
						<option selected="selected" value="">Choose Area Type</option>
							<?php foreach($data_category as $data_category2) {?>
							<option value='<?php echo $data_category2->description; ?>'><?php echo $data_category2->description; ?></option>
							<?php } ?>

					  </select> 
				</div>
				
                <input type="hidden" class="form-control" name="id_area_update" id="id_area_update">
              
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
		<h2 id="modal1Title">Import Area</h2>
				<form role="form" id="form_import_data" method="POST" action="<?php echo base_url()."index.php/area/importArea" ?>" enctype="multipart/form-data">
				 <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
				 
              <div class="box-body">

				 <div class="form-group">
                      <label for="exampleInputEmail1">Choose File</label>
                      <input type="file" name="import_file" id="import_file" class="form-control" value="" />
				</div>
				
				 <div class="form-group">
                    <p><a target="_blank" href="<?php echo base_url('/files/example-files/import-area.xlsx')?>">Download sample file import Area</a></p>
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
		<h2 id="modal1Title">Delete Area</h2>
				<form role="form" id="form_delete_data" method="POST" action="<?php echo base_url()."index.php/area/deleteArea" ?>" enctype="multipart/form-data">
				 <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
				 
              <div class="box-body">

				 <div class="form-group">
                     <p>Are you sure want to delete this data? (<span id="reference_delete"></span>)</p>
				</div>
				
				 <div class="form-group">
                      <input type="hidden" name="id_area_delete" id="id_area_delete" class="form-control" value="" />
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
		<h2 id="modal1Title">Delete Area</h2>
				<form role="form" id="form_selected_delete_data" method="POST" action="<?php echo base_url()."index.php/area/deleteAreaAll" ?>" enctype="multipart/form-data">
				 <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
				 
              <div class="box-body">

				 <div class="form-group">
                     <p>Are you sure want to delete selected data? </p>
				</div>
				
				 <div class="form-group">
                      <input type="hidden" name="id_area_delete_all" id="id_area_delete_all" class="form-control" value="" />
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
				var area_id =  $('#data_'+id+' .area_id').text();
				var id_area =  $('#data_'+id+' .id_area span').text();
				$("#reference_delete").text("Area ID:"+area_id)
				$("#id_area_delete").val(id_area);
			});
			
			
			
			$(".edit_data").click(function(){
				var id = $(this).attr('id');
				var area_id =  $('#data_'+id+' .area_id').text();
				var id_area =  $('#data_'+id+' .id_area span').text();
				var area_description =  $('#data_'+id+' .area_description').text();
				var area_type =  $('#data_'+id+' .area_type').text();
				
				
				$("#id_area_update").val(id_area);
				$("#edit_area_id").val(area_id);
				$("#edit_area_description").val(area_description);
				$('#edit_area_type option[value="' + area_type + '"]').prop('selected',true);
				
			});

			$("#form_add_data").validate({
				
				messages: {
				area_id: {
				required: 'Area ID must be filled!'
				},
				area_description: {
				required: 'Area Description must be filled!'
				},
				area_type: {
				required: 'Area Type must be filled!'
				}
			}
			});
			
			
			
			$("#form_edit_data").validate({
				
				messages: {
				edit_area_id: {
				required: 'Area ID must be filled!'
				},
				edit_area_description: {
				required: 'Area Description must be filled!'
				},
				edit_area_type: {
				required: 'Area Type must be filled!'
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
		$("#id_area_delete_all").val(ids);
		
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
