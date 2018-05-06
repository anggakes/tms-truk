 <!-- HEADER -->
 <section class="content-header">
          <h1>
            Location 
            <small>List Of Location</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="<?php echo BASE_URL(); ?>"><i class="fa fa-dashboard"></i>Home</a></li>
            <li><a href="<?php echo BASE_URL()."location"; ?>"><i class="fa fa-dashboard"></i>Location</a></li>
          </ol>
        </section>
  
  
   <!-- Content -->
   <section class="content">
		
		
  
  
          <div class="box sms box-default color-palette-box">
            <div class="box-header with-border">
              <h3 class="box-title"><i class="fa fa-table"></i> Table Location</h3>
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
                             <form action="<?php echo base_url()."index.php/location" ?>" method="get">
                             <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                                <input type="text" id="search" name="search" placeholder="Search..."  value="<?php echo $search; ?>" />
                                <input type="submit" id="submit"  value="Search"/>
                                <?php if($search!="")
								{?>
                                <a href="<?php echo base_url()."index.php/location" ?>" id="clear-search">Clear Search</a>
                                <?php } ?>
                             </form>
                </div>
                <div id="wrapper-button" class="clearfix">
					<?php if($data_role[0]['export_location']=='yes'){ ?>
                	<a href="<?php echo base_url()."index.php/location/exportLocation?search=".$search; ?>" class="button orange-button">
                    	Export Location
                    </a>
					<?php } ?>
                    <?php if($data_role[0]['add_location']=='yes'){ ?>
                    <a id="add-data" class="button green-button">
                    	Add Location
                    </a>
					<?php } ?>
					<?php if($data_role[0]['delete_location']=='yes'){ ?>
                    <a id="delete-data" class="button btn-danger deletelogg">
                    	Delete Location
                    </a>
					<?php } ?>
					<?php if($data_role[0]['import_location']=='yes'){ ?>
                    <a id="import-data" class="button blue-button">
                    	Import Location 
                    </a>
					<?php } ?>
					
                </div>
                </div>
            <div id="wrapper-console" class="clearfix"> 
            <div class="grid_4 height400">                  
           	<table id="myTable03" class="fancyTable table-bordered table-hover">
                    <thead>
                      <tr>
					  
                        <th><div class="check-box-div"><input type="checkbox" name="select_all" id="select_all"></div>ID Location</th>
						<th>Warehouse Code</th>
						<th>Location Code</th>
                        <th>Location Type</th>
						<?php if($data_role[0]['delete_location']=='yes' || $data_role[0]['edit_location']=='yes'){ ?>
						<th>Action</th>
						<?php } ?>
                      </tr>
                    </thead>
             		<tbody>
                    <?php foreach($data_location as $data_location) {?>
                    <tr id="data_<?php echo $data_location->id_location; ?>">
                    	<td class="id_location">
						<div class="check-box-div">
						<input type="checkbox" name="id_checkbox[]" class="iCheck-helper toedit checkbox_satuan" value="<?php echo $data_location->id_location; ?>" />
						</div><span><?php echo $data_location->id_location; ?></span></td>
                        <td class="warehouse_id"><span class='warehouse_code'><?php echo $data_location->warehouse_code; ?></span><span style='display:none' class='id_warehouse'><?php echo $data_location->id_warehouse; ?></div></td>
						
						<td class="location_code"><?php echo $data_location->location_code; ?></td>
						<td class="id_location_type"><?php echo $data_location->location_type; ?><span><?php echo $data_location->id_location_type; ?></span></td>
						<?php if($data_role[0]['delete_location']=='yes' || $data_role[0]['edit_location']=='yes'){ ?>
						<td><?php if($data_role[0]['delete_location']=='yes'){ ?><a  class="delete_data link_action" id="<?php echo $data_location->id_location; ?>" >Delete</a><?php } ?> | <?php if($data_role[0]['edit_location']=='yes'){ ?><a  id="<?php echo $data_location->id_location; ?>" class="edit_data link_action">Edit</a><?php } ?></td>
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
		<h2 id="modal1Title">Add Location</h2>
				<form role="form" id="form_add_data" method="POST" action="<?php echo base_url()."index.php/location/addLocation" ?>" enctype="multipart/form-data">
				 <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
				 
              <div class="box-body">

				 <div class="form-group">
                  <label for="drivercode2">Location Code</label>
                 <input type="text" class="form-control" name="location_code" id="location_code" required>
                </div>
				
				<div class="form-group">
					 <label>Warehouse Code:</label>
						<div class="input-group">
						  <div class="input-group-addon">
							<i class="fa fa-search"></i>
						  </div>
						  <input type="text" class="form-control pull-right" name="warehouse_code" id="warehouse_code" required>
						</div>
						<!-- /.input group -->
					</div>
				
				<div class="form-group">
                  <label for="drivercode2">Location Type</label>
				  <select class="form-control" name="id_location_type" id="id_location_type" required>
					<option selected="selected" value="">Choose Location Type</option>
					<?php foreach($data_location_type as $data_location_type1) {?>
					<option value="<?php echo $data_location_type1->id_location_type; ?>"><?php echo $data_location_type1->location_type; ?></option>
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
		<h2 id="modal1Title">Edit Location</h2>
				<form role="form" id="form_edit_data" method="POST" action="<?php echo base_url()."index.php/location/editLocation" ?>" enctype="multipart/form-data">
				 <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
				 
              <div class="box-body">

				 <div class="form-group">
                  <label for="drivercode2">Location Code</label>
                 <input type="text" class="form-control" name="edit_location_code" id="edit_location_code" required>
                </div>
				
				
				<div class="form-group">
					 <label>Warehouse Code:</label>
						<div class="input-group">
						  <div class="input-group-addon">
							<i class="fa fa-search"></i>
						  </div>
						  <input type="text" class="form-control pull-right" name="edit_warehouse_code" id="edit_warehouse_code" required>
						</div>
						<!-- /.input group -->
					</div>
				
				<div class="form-group">
                  <label for="drivercode2">Location Type</label>
				  <select class="form-control" name="edit_id_location_type" id="edit_id_location_type" required>
					<option selected="selected" value="">Choose Location Type</option>
					<?php foreach($data_location_type as $data_location_type) {?>
					<option value="<?php echo $data_location_type->id_location_type; ?>"><?php echo $data_location_type->location_type; ?></option>
					<?php } ?>
				  </select> 
                </div>
				
				
				<input type="hidden" class="form-control" name="id_location_update" id="id_location_update">
				
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
		<h2 id="modal1Title">Import Location</h2>
				<form role="form" id="form_import_data" method="POST" action="<?php echo base_url()."index.php/location/importlocation" ?>" enctype="multipart/form-data">
				 <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
				 
              <div class="box-body">

				 <div class="form-group">
                      <label for="exampleInputEmail1">Choose File</label>
                      <input type="file" name="import_file" id="import_file" class="form-control" value="" />
				</div>
				
				 <div class="form-group">
                    <p><a target="_blank" href="<?php echo base_url('/files/example-files/import-location.xlsx')?>">Download sample file import Location</a></p>
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
		<h2 id="modal1Title">Delete Location</h2>
				<form role="form" id="form_delete_data" method="POST" action="<?php echo base_url()."index.php/location/deleteLocation" ?>" enctype="multipart/form-data">
				 <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
				 
              <div class="box-body">

				 <div class="form-group">
                     <p>Are you sure want to delete this data? (<span id="reference_delete"></span>)</p>
				</div>
				
				 <div class="form-group">
                      <input type="hidden" name="id_location_delete" id="id_location_delete" class="form-control" value="" />
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
		<h2 id="modal1Title">Delete Location</h2>
				<form role="form" id="form_selected_delete_data" method="POST" action="<?php echo base_url()."index.php/location/deleteLocationAll" ?>" enctype="multipart/form-data">
				 <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
				 
              <div class="box-body">

				 <div class="form-group">
                     <p>Are you sure want to delete selected data? </p>
				</div>
				
				 <div class="form-group">
                      <input type="hidden" name="id_location_delete_all" id="id_location_delete_all" class="form-control" value="" />
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
				var location_code =  $('#data_'+id+' .location_code').text();
				var id_location =  $('#data_'+id+' .id_location span').text();
				$("#reference_delete").text("Location Code:"+location_code)
				$("#id_location_delete").val(id_location);
			});
			
			
			
			$(".edit_data").click(function(){
				var id = $(this).attr('id');
				var location_code =  $('#data_'+id+' .location_code').text();
				var id_location =  $('#data_'+id+' .id_location span').text();
				var warehouse_code =  $('#data_'+id+' span.warehouse_code').text();
				var id_warehouse =  $('#data_'+id+' span.id_warehouse').text();
				var id_location_type =  $('#data_'+id+' .id_location_type span').text();
				$("#id_location_update").val(id_location);
				$("#edit_location_code").val(location_code);
				$("#edit_warehouse_code").val(warehouse_code);
				$('#edit_id_location_type option[value="' + id_location_type + '"]').prop('selected',true);
			});

			$("#form_add_data").validate({
				
				messages: {
				location_type: {
				required: 'Location Type Name must be filled!'
				},
				location_code: {
				required: 'Location Code must be filled!'
				}
				,
				warehouse_code: {
				required: 'Location Code must be filled!'
				}
			}
			});
			
			
			
			$("#form_edit_data").validate({
				
				messages: {
				edit_location_type: {
				required: 'Location Type Name must be filled!'
				},
				edit_location_code: {
				required: 'Location Code must be filled!'
				},
				edit_warehouse_code: {
				required: 'Warehouse Code must be filled!'
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
  
		//auto complete warehouse
		var term = $("#warehouse_code").val();
        $( "#warehouse_code" ).autocomplete({
         source: "<?php echo BASE_URL(); ?>/index.php/json/jsonWarehouse?term="+term,  
         minLength:0,
		 select: function( event , ui ) {
			  $( "#warehouse_code" ).val( ui.item.label );
			 
        }    
        })
		.autocomplete( "instance" )._renderItem = function( ul, item ) {
		  return $( "<li style='position:relative; z-index:9999;'>" )
			.append( "<div style='font-size:10px;'>" + item.label +"</div>" )
			.appendTo( ul );
		};
		
		//auto complete Edit warehouse
		var term = $("#warehouse_code").val();
        $( "#edit_warehouse_code" ).autocomplete({
         source: "<?php echo BASE_URL(); ?>/index.php/json/jsonWarehouse?term="+term,  
         minLength:0,
		 select: function( event , ui ) {
			  $( "#edit_warehouse_code" ).val( ui.item.label );
			 
        }    
        })
		.autocomplete( "instance" )._renderItem = function( ul, item ) {
		  return $( "<li style='position:relative; z-index:9999;'>" )
			.append( "<div style='font-size:10px;'>" + item.label +"</div>" )
			.appendTo( ul );
		};
		
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
		$("#id_location_delete_all").val(ids);
		
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
