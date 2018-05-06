 <!-- HEADER -->
 <section class="content-header">
          <h1>
            Master Cash
            <small>List Of Master Cash</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="<?php echo BASE_URL(); ?>"><i class="fa fa-dashboard"></i>Home</a></li>
            <li><a href="<?php echo BASE_URL()."master_cash"; ?>"><i class="fa fa-dashboard"></i>Master Cash</a></li>
          </ol>
        </section>
  
  
   <!-- Content -->
   <section class="content">
		
		
  
  
          <div class="box sms box-default color-palette-box">
            <div class="box-header with-border">
              <h3 class="box-title"><i class="fa fa-table"></i> Table Master Cash Account</h3>
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
			function convert_date($date)
			{
				$date = (explode("-",$date));
				$date = $date[2].'-'.$date[1].'-'.$date[0];
				echo $date;
			}
			?>
            <div id="wrapper-console" class="clearfix">
                <div id="wrapper-search">
                             <form action="<?php echo base_url()."index.php/master_cash" ?>" method="get">
                             <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                                <input type="text" id="search" name="search" placeholder="Search..."  value="<?php echo $search; ?>" />
                                <input type="submit" id="submit"  value="Search"/>
                                <?php if($search!="")
								{?>
                                <a href="<?php echo base_url()."index.php/master_cash" ?>" id="clear-search">Clear Search</a>
                                <?php } ?>
                             </form>
                </div>
                <div id="wrapper-button" class="clearfix">
					<?php if($data_role[0]['export_master_cash']=='yes'){ ?>
                	<a href="<?php echo base_url()."index.php/master_cash/exportMasterCashAccount?search=".$search; ?>" class="button orange-button">
                    	Export Cash Account
                    </a>
					<?php } ?>
                    <?php if($data_role[0]['add_master_cash']=='yes'){ ?>
                    <a id="add-data" class="button green-button">
                    	Add Cash Account
                    </a>
					<?php } ?>
					<?php if($data_role[0]['delete_master_cash']=='yes'){ ?>
                    <a id="delete-data" class="button btn-danger deletelogg">
                    	Delete Cash Account
                    </a>
					<?php } ?>
					
					
                </div>
                </div>
            <div id="wrapper-console" class="clearfix"> 
            <div class="grid_4 height400">                  
           	<table id="myTable0w2" class="fancyTable table table-bordered table-hover">
                    <thead>
                      <tr>
                        <th><div class="check-box-div"><input type="checkbox" name="select_all" id="select_all"></div>ID Cash Account</th>
                        <th>Name</th>
						<th>Balance</th>
						<th>Starting Balance Date</th>
						<th>Created By</th>
						<th>Created Date</th>
						<th>Updated By</th>
						<th>Updated Date</th>
						<?php if($data_role[0]['delete_master_cash']=='yes' || $data_role[0]['edit_master_cash']=='yes'){ ?>
						<th>Action</th>
						<?php } ?>
                      </tr>
                    </thead>
             		<tbody>
                    <?php foreach($data_master_cash as $data_master_cash) {?>
                    <tr id="data_<?php echo $data_master_cash->	id_cash_account; ?>">
                    	<td class="id_master_cash">
						<div class="check-box-div">
						<input type="checkbox" name="id_checkbox[]" class="iCheck-helper toedit checkbox_satuan" value="<?php echo $data_master_cash->id_cash_account; ?>" />
						</div><span><?php echo $data_master_cash->id_cash_account; ?></span></td>
						
						
                        <td class="name"><?php echo $data_master_cash->name; ?></td>
						<td class="balance"><?php convert_price($data_master_cash->balance); ?><span style='display:none;'><?php echo $data_master_cash->balance; ?></span></td>
						<td class="starting_balance_date"><?php convert_date($data_master_cash->starting_balance_date); ?></td>
						<td class="created_by"><?php echo $data_master_cash->created_by; ?></td>
						<td class="created_date"><?php echo $data_master_cash->created_date; ?></td>
						<td class="updated_by"><?php echo $data_master_cash->updated_by; ?></td>
						<td class="updated_date"><?php echo $data_master_cash->updated_date; ?></td>
						
						<?php if($data_role[0]['delete_master_cash']=='yes' || $data_role[0]['edit_master_cash']=='yes'){ ?>
						<td><?php if($data_role[0]['delete_master_cash']=='yes'){ ?><a  class="delete_data link_action" id="<?php echo $data_master_cash->id_cash_account; ?>" >Delete</a><?php } ?> | <?php if($data_role[0]['edit_master_cash']=='yes'){ ?><a  id="<?php echo $data_master_cash->id_cash_account; ?>" class="edit_data link_action">Edit</a><?php } ?></td>
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
		<h2 id="modal1Title">Add Cash Account</h2>
				<form role="form" id="form_add_data" method="POST" action="<?php echo base_url()."index.php/master_cash/addMasterCashAccount" ?>" enctype="multipart/form-data">
				 <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
				 
              <div class="box-body">

				<div class="form-group">
                  <label for="master_cashcode2">Name</label>
                 <input type="text" class="form-control" name="name" id="name" required>
                </div>
				
				<div class="form-group">
                  <label for="master_cashcode2">Statement Balance</label>
                 <input type="text" class="form-control" name="statement_balance" id="statement_balance" required>
                </div>
				
				
				<div class="form-group">
					  <label for="drivercode2">Starting Balance Date</label>
						  <div class="input-group date">
						  <div class="input-group-addon">
							<i class="fa fa-calendar"></i>
						  </div>
						  <input type="text" name="starting_balance_date" id="starting_balance_date" class="form-control pull-right datepicker"  required>
						</div>
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
		<h2 id="modal1Title">Edit Master Cash</h2>
				<form role="form" id="form_edit_data" method="POST" action="<?php echo base_url()."index.php/master_cash/editMasterCashAccount" ?>" enctype="multipart/form-data">
				 <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
				 
              <div class="box-body">

				<div class="form-group">
                  <label for="master_cashcode2">Name</label>
                 <input type="text" class="form-control" name="edit_name" id="edit_name" required>
                </div>
				
				<div class="form-group">
                  <label for="master_cashcode2">Statement Balance</label>
                 <input type="text" class="form-control" name="edit_statement_balance" id="edit_statement_balance" required>
                </div>
				
				
				<div class="form-group">
					  <label for="drivercode2">Starting Balance Date</label>
						  <div class="input-group date">
						  <div class="input-group-addon">
							<i class="fa fa-calendar"></i>
						  </div>
						  <input type="text" name="edit_starting_balance_date" id="edit_starting_balance_date" class="form-control pull-right datepicker"  required>
						</div>
				</div>
				
                <input type="hidden" class="form-control" name="id_master_cash_update" id="id_master_cash_update">
              
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
		<h2 id="modal1Title">Delete Cash Account</h2>
				<form role="form" id="form_delete_data" method="POST" action="<?php echo base_url()."index.php/master_cash/deleteMasterCashAccount" ?>" enctype="multipart/form-data">
				 <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
				 
              <div class="box-body">

				 <div class="form-group">
                     <p>Are you sure want to delete this data? (<span id="reference_delete"></span>)</p>
				</div>
				
				 <div class="form-group">
                      <input type="hidden" name="id_master_cash_delete" id="id_master_cash_delete" class="form-control" value="" />
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
		<h2 id="modal1Title">Delete Cash Account</h2>
				<form role="form" id="form_selected_delete_data" method="POST" action="<?php echo base_url()."index.php/master_cash/deleteMasterCashAccountAll" ?>" enctype="multipart/form-data">
				 <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
				 
              <div class="box-body">

				 <div class="form-group">
                     <p>Are you sure want to delete selected data? </p>
				</div>
				
				 <div class="form-group">
                      <input type="hidden" name="id_master_cash_delete_all" id="id_master_cash_delete_all" class="form-control" value="" />
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
			$('.datepicker').datepicker({
			  autoclose: true,
			  Format: 'dd-mm-yyyy'
			});
			$(".delete_data").click(function(){
				var id = $(this).attr('id');
				var name =  $('#data_'+id+' .name').text();
				var id_master_cash =  $('#data_'+id+' .id_master_cash span').text();
				$("#reference_delete").text("Driver Code:"+name)
				$("#id_master_cash_delete").val(id_master_cash);
			});
			
			
			
			$(".edit_data").click(function(){
				var id = $(this).attr('id');
				var id_master_cash =  $('#data_'+id+' .id_master_cash span').text();
				var name =  $('#data_'+id+' .name').text();
				var statement_balance =  $('#data_'+id+' .balance span').text();
				var starting_balance_date =  $('#data_'+id+' .starting_balance_date').text();
				$("#id_master_cash_update").val(id_master_cash);
				$("#edit_name").val(name);
				$("#edit_statement_balance").val(statement_balance);
				$("#edit_starting_balance_date").val(starting_balance_date);
			});

			$("#form_add_data").validate({
				rules: {
				statement_balance: {
				  digits: true
				}
				},
				messages: {
				name: {
				required: 'Name must be filled!'
				},
				statement_balance: {
				required: 'Statement Balance must be filled!'
				},
				starting_balance: {
				required: 'Starting Balance must be filled!'
				}
			}
			});
			
			
			
			$("#form_add_data").validate({
				rules: {
				edit_statement_balance: {
				  digits: true
				}
				},
				messages: {
				edit_name: {
				required: 'Name must be filled!'
				},
				edit_statement_balance: {
				required: 'Statement Balance must be filled!'
				},
				edit_starting_balance: {
				required: 'Starting Balance must be filled!'
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
		$("#id_master_cash_delete_all").val(ids);
		
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
