 <!-- HEADER -->
 <section class="content-header">
          <h1>
            Master Data Category
            <small>List Of Master Data Category</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="<?php echo BASE_URL(); ?>"><i class="fa fa-dashboard"></i>Home</a></li>
            <li><a href="<?php echo BASE_URL()."area"; ?>"><i class="fa fa-dashboard"></i>Master Data Category</a></li>
          </ol>
        </section>
  
  
   <!-- Content -->
   <section class="content">
		
		
  
  
          <div class="box sms box-default color-palette-box">
            <div class="box-header with-border">
              <h3 class="box-title"><i class="fa fa-table"></i> Table Master Data Category</h3>
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
                             <form action="<?php echo base_url()."index.php/master_data_category" ?>" method="get">
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
					<?php if($data_role[0]['export_master_category']=='yes'){ ?>
                	<a href="<?php echo base_url()."index.php/master_data_category/exportMasterDataCategory?search=".$search; ?>" class="button orange-button">
                    	Export Master Data Category
                    </a>
					<?php } ?>
                    <?php if($data_role[0]['add_master_category']=='yes'){ ?>
                    <a id="add-data" class="button green-button">
                    	Add Master Data Category
                    </a>
					<?php } ?>
					<?php if($data_role[0]['delete_master_category']=='yes'){ ?>
                    <a id="delete-data" class="button btn-danger deletelogg">
                    	Delete Master Data Category
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
                        <th>Category</th>
                        <th>Description</th>
						<?php if($data_role[0]['delete_master_category']=='yes' || $data_role[0]['edit_master_category']=='yes'){ ?>
						<th>Action</th>
						<?php } ?>
                      </tr>
                    </thead>
             		<tbody>
                    <?php foreach($data_master_data_category as $data_master_data_category) {?>
                    <tr id="data_<?php echo $data_master_data_category->id_master_data_category; ?>">
                    	<td class="id_master_data_category">
						<div class="check-box-div">
						<input type="checkbox" name="id_checkbox[]" class="iCheck-helper toedit checkbox_satuan" value="<?php echo $data_master_data_category->id_master_data_category; ?>" />
						</div><span><?php echo $data_master_data_category->id_master_data_category; ?></span></td>
                        <td class="category"><?php echo $data_master_data_category->category; ?></td>
                        <td class="description"><?php echo $data_master_data_category->description; ?></td>
						<?php if($data_role[0]['delete_master_category']=='yes' || $data_role[0]['edit_master_category']=='yes'){ ?>
						<td><?php if($data_role[0]['delete_master_category']=='yes'){ ?><a  class="delete_data link_action" id="<?php echo $data_master_data_category->id_master_data_category; ?>" >Delete</a><?php } ?> | <?php if($data_role[0]['edit_master_category']=='yes'){ ?><a  id="<?php echo $data_master_data_category->id_master_data_category; ?>" class="edit_data link_action">Edit</a><?php } ?></td>
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
		<h2 id="modal1Title">Add Master Data Category</h2>
				<form role="form" id="form_add_data" method="POST" action="<?php echo base_url()."index.php/master_data_category/addMasterDataCategory" ?>" enctype="multipart/form-data">
				 <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
				 
              <div class="box-body">

				
				
                <div class="form-group">
					  <label for="drivercode2">Master Data</label>
					  <select class="form-control" name="category" id="category" required>
						<option selected="selected" value="">Choose Category</option>
						<option value="Truck Absent">Action Truck Absent (Fleet)</option>
						<option value="Accident Type">Accident Type (Fleet)</option>
						<option value="Service Type Fleet">Service Type (Fleet)</option>
						<option value="Area Type">Area Type (Master Area)</option>
						<option value="Employee Status Driver">Employee Status (Master Driver)</option>
						<option value="Shift Driver">Shift (Master Driver)</option>
						<option value="Fuel Type Master Unit">Fuel Type (Master Unit)</option>
						<option value="Body Type Master Unit">Body Type (Master Unit)</option>
						<option value="Assembly Type Master Unit">Assembly Type (Master Unit)</option>
						<option value="Pod Code">Pod Code</option>
						<option value="Cargo Type">Cargo Type</option>
					  </select> 
				</div>
               
				  <div class="form-group">
					  <label for="drivercode">Description</label>
					  <input type="text" class="form-control" name="description" id="description" required>
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
		<h2 id="modal1Title">Edit Master Data Category</h2>
				<form role="form" id="form_edit_data" method="POST" action="<?php echo base_url()."index.php/master_data_category/editMasterDataCategory" ?>" enctype="multipart/form-data">
				 <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
				 
              <div class="box-body">

				 
				  <div class="form-group">
					  <label for="drivercode2">Master Data</label>
					  <select class="form-control" name="edit_category" id="edit_category" required>
						<option selected="selected" value="">Choose Category</option>
						<option value="Truck Absent">Action Truck Absent (Fleet)</option>
						<option value="Accident Type">Accident Type (Fleet)</option>
						<option value="Service Type Fleet">Service Type (Fleet)</option>
						<option value="Area Type">Area Type (Master Area)</option>
						<option value="Employee Status Driver">Employee Status (Master Driver)</option>
						<option value="Shift Driver">Shift (Master Driver)</option>
						<option value="Fuel Type Master Unit">Fuel Type (Master Unit)</option>
						<option value="Body Type Master Unit">Body Type (Master Unit)</option>
						<option value="Assembly Type Master Unit">Assembly Type (Master Unit)</option>
						<option value="Pod Code">Pod Code</option>
						<option value="Cargo Type">Cargo Type</option>
					  </select> 
				</div>
               
				  <div class="form-group">
					  <label for="drivercode">Description</label>
					  <input type="text" class="form-control" name="edit_description" id="edit_description" required>
				</div>
					
					
				
                <input type="hidden" class="form-control" name="id_master_data_category_update" id="id_master_data_category_update">
              
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
		<h2 id="modal1Title">Import Master Data Category</h2>
				<form role="form" id="form_import_data" method="POST" action="<?php echo base_url()."index.php/area/importMasterDataCategory" ?>" enctype="multipart/form-data">
				 <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
				 
              <div class="box-body">

				 <div class="form-group">
                      <label for="exampleInputEmail1">Choose File</label>
                      <input type="file" name="import_file" id="import_file" class="form-control" value="" />
				</div>
				
				 <div class="form-group">
                    <p><a target="_blank" href="<?php echo base_url('/files/example-files/import-area.xlsx')?>">Download sample file import Master Data Category</a></p>
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
		<h2 id="modal1Title">Delete Master Data Category</h2>
				<form role="form" id="form_delete_data" method="POST" action="<?php echo base_url()."index.php/master_data_category/deleteMasterDataCategory" ?>" enctype="multipart/form-data">
				 <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
				 
              <div class="box-body">

				 <div class="form-group">
                     <p>Are you sure want to delete this data? (<span id="reference_delete"></span>)</p>
				</div>
				
				 <div class="form-group">
                      <input type="hidden" name="id_master_data_category_delete" id="id_master_data_category_delete" class="form-control" value="" />
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
		<h2 id="modal1Title">Delete Master Data Category</h2>
				<form role="form" id="form_selected_delete_data" method="POST" action="<?php echo base_url()."index.php/master_data_category/deleteMasterDataCategoryAll" ?>" enctype="multipart/form-data">
				 <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
				 
              <div class="box-body">

				 <div class="form-group">
                     <p>Are you sure want to delete selected data? </p>
				</div>
				
				 <div class="form-group">
                      <input type="hidden" name="id_master_data_category_delete_all" id="id_master_data_category_delete_all" class="form-control" value="" />
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
				var description =  $('#data_'+id+' .description').text();
				var id_master_data_category =  $('#data_'+id+' .id_master_data_category span').text();
				$("#reference_delete").text("Description : "+description)
				$("#id_master_data_category_delete").val(id_master_data_category);
			});
			
			
			
			$(".edit_data").click(function(){
				var id = $(this).attr('id');
				var id_master_data_category =  $('#data_'+id+' .id_master_data_category span').text();
				var category =  $('#data_'+id+' .category').text();
				var description =  $('#data_'+id+' .description').text();
				
				
				$("#id_master_data_category_update").val(id_master_data_category);
				$("#edit_description").val(description);
				$('#edit_category option[value="' + category + '"]').prop('selected',true);
				
			});

			$("#form_add_data").validate({
				
				messages: {
				area_id: {
				required: 'Master Data Category ID must be filled!'
				},
				area_description: {
				required: 'Master Data Category Description must be filled!'
				},
				area_type: {
				required: 'Master Data Category Type must be filled!'
				}
			}
			});
			
			
			
			$("#form_edit_data").validate({
				
				messages: {
				edit_master_data_category_id: {
				required: 'Master Data Category ID must be filled!'
				},
				edit_master_data_category_description: {
				required: 'Master Data Category Description must be filled!'
				},
				edit_master_data_category_type: {
				required: 'Master Data Category Type must be filled!'
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
		$("#id_master_data_category_delete_all").val(ids);
		
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
