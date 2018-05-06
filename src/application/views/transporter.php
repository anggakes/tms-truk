 <!-- HEADER -->
 <section class="content-header">
          <h1>
            Transporter
            <small>List Of Transporter</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="<?php echo BASE_URL(); ?>"><i class="fa fa-dashboard"></i>Home</a></li>
            <li><a href="<?php echo BASE_URL()."transporter"; ?>"><i class="fa fa-dashboard"></i>Transporter</a></li>
          </ol>
        </section>
  
  
   <!-- Content -->
   <section class="content">
		
		
  
  
          <div class="box sms box-default color-palette-box">
            <div class="box-header with-border">
              <h3 class="box-title"><i class="fa fa-table"></i> Table Transporter</h3>
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
                             <form action="<?php echo base_url()."index.php/transporter" ?>" method="get">
                             <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                                <input type="text" id="search" name="search" placeholder="Search..."  value="<?php echo $search; ?>" />
                                <input type="submit" id="submit"  value="Search"/>
                                <?php if($search!="")
								{?>
                                <a href="<?php echo base_url()."index.php/transporter" ?>" id="clear-search">Clear Search</a>
                                <?php } ?>
                             </form>
                </div>
                <div id="wrapper-button" class="clearfix">
					<?php if($data_role[0]['export_transporter']=='yes'){ ?>
                	<a href="<?php echo base_url()."index.php/transporter/exportTransporter?search=".$search; ?>" class="button orange-button">
                    	Export Transporter
                    </a>
					<?php } ?>
                    <?php if($data_role[0]['add_transporter']=='yes'){ ?>
                    <a id="add-data" class="button green-button">
                    	Add Transporter
                    </a>
					<?php } ?>
					<?php if($data_role[0]['delete_transporter']=='yes'){ ?>
                    <a id="delete-data" class="button btn-danger deletelogg">
                    	Delete Transporter
                    </a>
					<?php } ?>
					<?php if($data_role[0]['import_transporter']=='yes'){ ?>
                    <a id="import-data" class="button blue-button">
                    	Import Transporter
                    </a>
					<?php } ?>
					
                </div>
                </div>
            <div id="wrapper-console" class="clearfix"> 
            <div class="grid_4 height400">                  
           	<table id="myTable04" class="fancyTable table table-bordered table-hover">
                    <thead>
                      <tr>
                        <th><div class="mid"><div class="check-box-div"><input type="checkbox" name="select_all" id="select_all"></div>ID</div></th>
                        <th><div class="mid">Transporter ID</div></th>
                        <th><div class="mid">Transporter Name</div></th>
						<th><div class="mid">Address 1</div></th>
						<th><div class="mid">Address 2</div></th>
						<th><div class="mid">City</div></th>
						<th><div class="mid">Area</div></th>
						<th><div class="mid">Postal Code</div></th>
						<th><div class="mid">Pic</div></th>
						<th><div class="mid">Email</div></th>
						<?php if($data_role[0]['delete_transporter']=='yes' || $data_role[0]['edit_transporter']=='yes'){ ?>
						<th><div class="mid">Action</div></th>
						<?php } ?>
                      </tr>
                    </thead>
             		<tbody>
                    <?php foreach($data_transporter as $data_transporter) {?>
                    <tr id="data_<?php echo $data_transporter->id_transporter; ?>">
                    	<td class="id_transporter">
						<div class="check-box-div">
						<input type="checkbox" name="id_checkbox[]" class="iCheck-helper toedit checkbox_satuan" value="<?php echo $data_transporter->id_transporter; ?>" />
						</div><span><?php echo $data_transporter->id_transporter; ?></span></td>
						
                        <td class="transporter_id"><?php echo $data_transporter->transporter_id; ?></td>
						<td class="transporter_name"><?php echo $data_transporter->transporter_name; ?></td>
						<td class="transporter_address_1"><?php echo $data_transporter->transporter_address_1; ?></td>
						<td class="transporter_address_2"><?php echo $data_transporter->transporter_address_2; ?></td>
						<td class="transporter_city"><?php echo $data_transporter->transporter_city; ?></td>
						<td class="area"><?php echo $data_transporter->area; ?></td>
						<td class="postal_code"><?php echo $data_transporter->postal_code; ?></td>
						<td class="pic"><?php echo $data_transporter->pic; ?></td>
						<td class="email"><?php echo $data_transporter->email; ?></td>
						
						
						<?php if($data_role[0]['delete_transporter']=='yes' || $data_role[0]['edit_transporter']=='yes'){ ?>
						<td><?php if($data_role[0]['delete_transporter']=='yes'){ ?><a  class="delete_data link_action" id="<?php echo $data_transporter->id_transporter; ?>" >Delete</a><?php } ?> | <?php if($data_role[0]['edit_transporter']=='yes'){ ?><a  id="<?php echo $data_transporter->id_transporter; ?>" class="edit_data link_action">Edit</a><?php } ?></td>
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
		<h2 id="modal1Title">Add Transporter</h2>
				<form role="form" id="form_add_data" method="POST" action="<?php echo base_url()."index.php/transporter/addTransporter" ?>" enctype="multipart/form-data">
				 <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
				 
              <div class="box-body">
				
				<div class="form-group">
                  <label for="drivercode2">Transporter ID</label>
                 <input type="text" class="form-control" name="transporter_id" id="transporter_id" required>
                </div>
				
				<div class="form-group">
                  <label for="drivercode2">Transporter Name</label>
                 <input type="text" class="form-control" name="transporter_name" id="transporter_name" required>
                </div>
				
				<div class="form-group">
                  <label for="drivercode2">Transporter Address 1</label>
                 <input type="text" class="form-control" name="transporter_address_1" id="transporter_address_1" required>
                </div>
				
				<div class="form-group">
                  <label for="drivercode2">Transporter Address 2</label>
                 <input type="text" class="form-control" name="transporter_address_2" id="transporter_address_2">
                </div>
				
				
				
				<div class="form-group">
                  <label for="drivercode2">Transporter City</label>
                 <input type="text" class="form-control" name="transporter_city" id="transporter_city" required>
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
                 <input type="text" class="form-control" name="postal_code" id="postal_code" required>
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
		<h2 id="modal1Title">Edit Transporter</h2>
				<form role="form" id="form_edit_data" method="POST" action="<?php echo base_url()."index.php/transporter/editTransporter" ?>" enctype="multipart/form-data">
				 <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
				 
              <div class="box-body">
					
				<div class="form-group">
                  <label for="drivercode2">Transporter ID</label>
                 <input type="text" class="form-control" name="edit_transporter_id" id="edit_transporter_id" required>
                </div>
				 
				 <div class="form-group">
                  <label for="drivercode2">Transporter Name</label>
                 <input type="text" class="form-control" name="edit_transporter_name" id="edit_transporter_name" required>
                </div>
				
				<div class="form-group">
                  <label for="drivercode2">Transporter Address 1</label>
                 <input type="text" class="form-control" name="edit_transporter_address_1" id="edit_transporter_address_1" required>
                </div>
				
				<div class="form-group">
                  <label for="drivercode2">Transporter Address 2</label>
                 <input type="text" class="form-control" name="edit_transporter_address_2" id="edit_transporter_address_2">
                </div>
				
				
				
				<div class="form-group">
                  <label for="drivercode2">Transporter City</label>
                 <input type="text" class="form-control" name="edit_transporter_city" id="edit_transporter_city" required>
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
                 <input type="text" class="form-control" name="edit_postal_code" id="edit_postal_code" required>
                </div>
				
				<div class="form-group">
                  <label for="drivercode2">PIC</label>
                 <input type="text" class="form-control" name="edit_pic" id="edit_pic" required>
                </div>
				
				<div class="form-group">
                  <label for="drivercode2">Email</label>
                 <input type="text" class="form-control" name="edit_email" id="edit_email" required>
                </div>
				
				
                <input type="hidden" class="form-control" name="id_transporter_update" id="id_transporter_update">
              
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
		<h2 id="modal1Title">Import Transporter</h2>
				<form role="form" id="form_import_data" method="POST" action="<?php echo base_url()."index.php/transporter/importTransporter" ?>" enctype="multipart/form-data">
				 <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
				 
              <div class="box-body">

				 <div class="form-group">
                      <label for="exampleInputEmail1">Choose File</label>
                      <input type="file" name="import_file" id="import_file" class="form-control" value="" />
				</div>
				
				 <div class="form-group">
                    <p><a target="_blank" href="<?php echo base_url('/files/example-files/import-transporter.xlsx')?>">Download sample file import Transporter</a></p>
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
		<h2 id="modal1Title">Delete Transporter</h2>
				<form role="form" id="form_delete_data" method="POST" action="<?php echo base_url()."index.php/transporter/deleteTransporter" ?>" enctype="multipart/form-data">
				 <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
				 
              <div class="box-body">

				 <div class="form-group">
                     <p>Are you sure want to delete this data? (<span id="reference_delete"></span>)</p>
				</div>
				
				 <div class="form-group">
                      <input type="hidden" name="id_transporter_delete" id="id_transporter_delete" class="form-control" value="" />
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
		<h2 id="modal1Title">Delete Transporter</h2>
				<form role="form" id="form_selected_delete_data" method="POST" action="<?php echo base_url()."index.php/transporter/deleteTransporterAll" ?>" enctype="multipart/form-data">
				 <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
				 
              <div class="box-body">

				 <div class="form-group">
                     <p>Are you sure want to delete selected data? </p>
				</div>
				
				 <div class="form-group">
                      <input type="hidden" name="id_transporter_delete_all" id="id_transporter_delete_all" class="form-control" value="" />
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
				var transporter_id =  $('#data_'+id+' .transporter_id').text();
				var id_transporter =  $('#data_'+id+' .id_transporter span').text();
				$("#reference_delete").text("Transporter ID:"+transporter_id)
				$("#id_transporter_delete").val(id_transporter);
			});
			
			
			
			$(".edit_data").click(function(){
				var id = $(this).attr('id');
				var transporter_id  =  $('#data_'+id+' .transporter_id').text();
				var id_transporter =  $('#data_'+id+' .id_transporter span').text();
				var transporter_name =  $('#data_'+id+' .transporter_name').text();
				var transporter_address_1 =  $('#data_'+id+' .transporter_address_1').text();
				var transporter_address_2 =  $('#data_'+id+' .transporter_address_2').text();
				var transporter_city =  $('#data_'+id+' .transporter_city').text();
				var area =  $('#data_'+id+' .area').text();
				var postal_code =  $('#data_'+id+' .postal_code').text();
				var pic =  $('#data_'+id+' .pic').text();
				var email =  $('#data_'+id+' .email').text();				
				
				$("#id_transporter_update").val(id_transporter);
				$("#edit_transporter_id").val(transporter_id);
				$("#edit_id_transporter").val(id_transporter);
				$("#edit_transporter_name").val(transporter_name);
				$("#edit_transporter_address_1").val(transporter_address_1);
				$("#edit_transporter_address_2").val(transporter_address_2);
				$("#edit_transporter_city").val(transporter_city);
				$("#edit_area").val(area);
				$("#edit_postal_code").val(postal_code);
				$("#edit_pic").val(pic);
				$("#edit_email").val(email);
				
			});

			$("#form_add_data").validate({
				
				messages: {
				transporter_id: {
				required: 'Transporter ID must be filled!'
				},
				transporter_name: {
				required: 'Transporter Name must be filled!'
				},
				transporter_address_1: {
				required: 'Transporter Address 1 must be filled!'
				},
				transporter_city: {
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
				}
				
				
			}
			});
			
			
			
			$("#form_edit_data").validate({
				
				messages: {
				edit_transporter_id: {
				required: 'Transporter ID must be filled!'
				},
				edit_transporter_name: {
				required: 'Transporter Name must be filled!'
				},
				edit_transporter_address_1: {
				required: 'Transporter Address 1 must be filled!'
				},
				edit_transporter_city: {
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
		$("#id_transporter_delete_all").val(ids);
		
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