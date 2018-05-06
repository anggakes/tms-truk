 <!-- HEADER -->
 <section class="content-header">
          <h1>
            Chasis
            <small>List Of Chasis</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="<?php echo BASE_URL(); ?>"><i class="fa fa-dashboard"></i>Home</a></li>
            <li><a href="<?php echo BASE_URL()."chasis"; ?>"><i class="fa fa-dashboard"></i>Chasis
          </ol>
        </section>
  
  
   <!-- Content -->
   <section class="content">
		
		
  
  
          <div class="box sms box-default color-palette-box">
            <div class="box-header with-border">
              <h3 class="box-title"><i class="fa fa-table"></i> Table Chasis</h3>
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
                             <form action="<?php echo base_url()."index.php/chasis" ?>" method="get">
                             <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                                <input type="text" id="search" name="search" placeholder="Search..."  value="<?php echo $search; ?>" />
                                <input type="submit" id="submit"  value="Search"/>
                                <?php if($search!="")
								{?>
                                <a href="<?php echo base_url()."index.php/chasis" ?>" id="clear-search">Clear Search</a>
                                <?php } ?>
                             </form>
                </div>
                <div id="wrapper-button" class="clearfix">
					<?php if($data_role[0]['export_chasis']=='yes'){ ?>
                	<a href="<?php echo base_url()."index.php/chasis/exportChasis?search=".$search; ?>" class="button orange-button">
                    	Export Chasis
                    </a>
					<?php } ?>
                    <?php if($data_role[0]['add_chasis']=='yes'){ ?>
                    <a id="add-data" class="button green-button">
                    	Add Chasis
                    </a>
					<?php } ?>
					<?php if($data_role[0]['delete_chasis']=='yes'){ ?>
                    <a id="delete-data" class="button btn-danger deletelogg">
                    	Delete Chasis
                    </a>
					<?php } ?>
					<?php if($data_role[0]['import_chasis']=='yes'){ ?>
                    <a id="import-data" class="button blue-button">
                    	Import Chasis
                    </a>
					<?php } ?>
					
                </div>
                </div>
            <div id="wrapper-console" class="clearfix"> 
            <div class="grid_4 height400">                  
           	<table id="myTable04" class="fancyTable table-bordered table-hover">
                    <thead>
                      <tr>
					  
                        <th><div class="check-box-div"><input type="checkbox" name="select_all" id="select_all"></div>Chasis ID</th>
                        <th>Vehicle ID</th>
                        <th>Tire QTY</th>
						<?php if($data_role[0]['delete_chasis']=='yes' || $data_role[0]['edit_chasis']=='yes'){ ?>
						<th>Action</th>
						<?php } ?>
                      </tr>
                    </thead>
             		<tbody>
                    <?php foreach($data_chasis as $data_chasis) {?>
                    <tr id="data_<?php echo $data_chasis->id_chasis; ?>">
                    	<td class="id_driver">
						<div class="check-box-div">
						<input type="checkbox" name="id_checkbox[]" class="iCheck-helper toedit checkbox_satuan" value="<?php echo $data_chasis->id_chasis; ?>" />
						</div><span class='id_chasis' style='display:none;'><?php echo $data_chasis->id_chasis; ?></span><span class='chasis_id'><?php echo $data_chasis->chasis_id; ?></span></td>
                        <td class="vehicle_id"><?php echo $data_chasis->vehicle_id; ?></td>
                        <td class="tire_qty"><?php echo $data_chasis->tire_qty; ?></td>
						
						
						<?php if($data_role[0]['delete_chasis']=='yes' || $data_role[0]['edit_chasis']=='yes'){ ?>
						<td><?php if($data_role[0]['delete_chasis']=='yes'){ ?><a  class="delete_data link_action" id="<?php echo $data_chasis->id_chasis; ?>" >Delete</a><?php } ?> | <?php if($data_role[0]['edit_chasis']=='yes'){ ?><a  id="<?php echo $data_chasis->id_chasis; ?>" class="edit_data link_action">Edit</a><?php } ?></td>
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
		<h2 id="modal1Title">Add Chasis</h2>
				<form role="form" id="form_add_data" method="POST" action="<?php echo base_url()."index.php/chasis/addChasis" ?>" enctype="multipart/form-data">
				 <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
				 
              <div class="box-body">

				 <div class="form-group">
                  <label for="drivercode2">Chasis ID</label>
                 <input type="text" class="form-control" name="chasis_id" id="chasis_id" required>
                </div>
				
				<div class="form-group">
                  <label for="drivercode">Tire Qty</label>
                  <input type="text" class="form-control" name="tire_qty" id="tire_qty" required>
                </div>
				
                <div class="form-group">
					 <label>Vehicle ID:</label>
						<div class="input-group">
						  <div class="input-group-addon">
							<i class="fa fa-search"></i>
						  </div>
						  <input type="text" class="form-control pull-right" name="vehicle_id" id="vehicle_id" required>
						</div>
						<!-- /.input group -->
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
		<h2 id="modal1Title">Edit Chasis</h2>
				<form role="form" id="form_edit_data" method="POST" action="<?php echo base_url()."index.php/chasis/editChasis" ?>" enctype="multipart/form-data">
				 <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
				 
              <div class="box-body">

				 <div class="form-group">
                  <label for="drivercode2">Chasis ID</label>
                 <input type="text" class="form-control" name="edit_chasis_id" id="edit_chasis_id" required>
                </div>
				
				<div class="form-group">
                  <label for="drivercode">Tire Qty</label>
                  <input type="text" class="form-control" name="edit_tire_qty" id="edit_tire_qty" required>
                </div>
				
                <div class="form-group">
					 <label>Vehicle ID:</label>
						<div class="input-group">
						  <div class="input-group-addon">
							<i class="fa fa-search"></i>
						  </div>
						  <input type="text" class="form-control pull-right" name="edit_vehicle_id" id="edit_vehicle_id" required>
						</div>
						<!-- /.input group -->
					</div>
					
                <input type="hidden" class="form-control" name="id_chasis_update" id="id_chasis_update">
              
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
		<h2 id="modal1Title">Import Chasis</h2>
				<form role="form" id="form_import_data" method="POST" action="<?php echo base_url()."index.php/chasis/importChasis" ?>" enctype="multipart/form-data">
				 <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
				 
              <div class="box-body">

				 <div class="form-group">
                      <label for="exampleInputEmail1">Choose File</label>
                      <input type="file" name="import_file" id="import_file" class="form-control" value="" />
				</div>
				
				 <div class="form-group">
                    <p><a target="_blank" href="<?php echo base_url('/files/example-files/import-chasis.xlsx')?>">Download sample file import driver</a></p>
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
		<h2 id="modal1Title">Delete Chasis</h2>
				<form role="form" id="form_delete_data" method="POST" action="<?php echo base_url()."index.php/chasis/deleteChasis" ?>" enctype="multipart/form-data">
				 <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
				 
              <div class="box-body">

				 <div class="form-group">
                     <p>Are you sure want to delete this data? (<span id="reference_delete"></span>)</p>
				</div>
				
				 <div class="form-group">
                      <input type="hidden" name="id_chasis_delete" id="id_chasis_delete" class="form-control" value="" />
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
		<h2 id="modal1Title">Delete Chasis</h2>
				<form role="form" id="form_selected_delete_data" method="POST" action="<?php echo base_url()."index.php/chasis/deleteChasisAll" ?>" enctype="multipart/form-data">
				 <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
				 
              <div class="box-body">

				 <div class="form-group">
                     <p>Are you sure want to delete selected data? </p>
				</div>
				
				 <div class="form-group">
                      <input type="hidden" name="id_chasis_delete_all" id="id_chasis_delete_all" class="form-control" value="" />
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
  
			//auto complete Master Unit
			var term = $("#vehicle_id").val();
			$( "#vehicle_id" ).autocomplete({
			 source: "<?php echo BASE_URL(); ?>/index.php/json/jsonMasterUnit?term="+term,  
			 minLength:0,
			 select: function( event , ui ) {
				  $(vehicle_id).val( ui.item.label );
				 
			}    
			})
		
  
			$(".delete_data").click(function(){
				
				var id = $(this).attr('id');
				var chasis_id =  $('#data_'+id+' span.chasis_id').text();
				var id_chasis =  $('#data_'+id+' span.id_chasis').text();
				
				$("#reference_delete").text("Chasis ID:"+chasis_id)
				$("#id_chasis_delete").val(id_chasis);
			});
			
			
			
			$(".edit_data").click(function(){
				var id = $(this).attr('id');
				var chasis_id =  $('#data_'+id+' span.chasis_id ').text();
				var id_chasis =  $('#data_'+id+' span.id_chasis').text();
				var tire_qty =  $('#data_'+id+' .tire_qty').text();
				var vehicle_id =  $('#data_'+id+' .vehicle_id').text();
				
				
				$("#id_chasis_update").val(id_chasis);
				$("#edit_chasis_id").val(chasis_id);
				$("#edit_tire_qty").val(tire_qty);
				$("#edit_vehicle_id").val(vehicle_id);
				
				
			});

			$("#form_add_data").validate({
				rules: {
				tire_qty: {
				  digits: true
				}
				},
				messages: {
				tire_qty: {
				required: 'Tire Qty must be filled!'
				},
				vehicle_id: {
				required: 'Vehicle ID must be filled!'
				},
				chasis_id: {
				required: 'Chasis ID must be filled!'
				}
			}
			});
			
			
			
			$("#form_edit_data").validate({
				rules: {
				edit_tire_qty: {
				  digits: true
				}
				},
				messages: {
				edit_tire_qty: {
				required: 'Tire Qty must be filled!'
				},
				edit_vehicle_id: {
				required: 'Vehicle ID must be filled!'
				},
				edit_chasis_id: {
				required: 'Chasis ID must be filled!'
				}}
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
		$("#id_chasis_delete_all").val(ids);
		
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
