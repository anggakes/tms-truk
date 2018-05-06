 <!-- HEADER -->
 <section class="content-header">
          <h1>
            Master Bank
            <small>List Of Master Bank</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="<?php echo BASE_URL(); ?>"><i class="fa fa-dashboard"></i>Home</a></li>
            <li><a href="<?php echo BASE_URL()."master_bank"; ?>"><i class="fa fa-dashboard"></i>Master Bank</a></li>
          </ol>
        </section>
  
  
   <!-- Content -->
   <section class="content">
		
		
  
  
          <div class="box sms box-default color-palette-box">
            <div class="box-header with-border">
              <h3 class="box-title"><i class="fa fa-table"></i> Table Master Bank Account</h3>
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
                             <form action="<?php echo base_url()."index.php/master_bank" ?>" method="get">
                             <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                                <input type="text" id="search" name="search" placeholder="Search..."  value="<?php echo $search; ?>" />
                                <input type="submit" id="submit"  value="Search"/>
                                <?php if($search!="")
								{?>
                                <a href="<?php echo base_url()."index.php/master_bank" ?>" id="clear-search">Clear Search</a>
                                <?php } ?>
                             </form>
                </div>
                <div id="wrapper-button" class="clearfix">
					<?php if($data_role[0]['export_master_bank']=='yes'){ ?>
                	<a href="<?php echo base_url()."index.php/master_bank/exportMasterBankAccount?search=".$search; ?>" class="button orange-button">
                    	Export Bank Account
                    </a>
					<?php } ?>
                    <?php if($data_role[0]['add_master_bank']=='yes'){ ?>
                    <a id="add-data" class="button green-button">
                    	Add Bank Account
                    </a>
					<?php } ?>
					<?php if($data_role[0]['delete_master_bank']=='yes'){ ?>
                    <a id="delete-data" class="button btn-danger deletelogg">
                    	Delete Bank Account
                    </a>
					<?php } ?>
					
					
                </div>
                </div>
            <div id="wrapper-console" class="clearfix"> 
            <div class="grid_4 height400">                  
           	<table id="myTable0w2" class="fancyTable table table-bordered table-hover">
                    <thead>
                      <tr>
					  
                        <th><div class="check-box-div"><input type="checkbox" name="select_all" id="select_all"></div>ID Master Bank Account</th>
                        <th>Code</th>
                        <th>Name</th>
						<th>Statement Balance</th>
						<th>Available Credit</th>
						<th>Starting Balance</th>
						<th>Created By</th>
						<th>Created Date</th>
						<th>Updated By</th>
						<th>Updated Date</th>
						<?php if($data_role[0]['delete_master_bank']=='yes' || $data_role[0]['edit_master_bank']=='yes'){ ?>
						<th>Action</th>
						<?php } ?>
                      </tr>
                    </thead>
             		<tbody>
                    <?php foreach($data_master_bank as $data_master_bank) {?>
                    <tr id="data_<?php echo $data_master_bank->id_master_bank_account; ?>">
                    	<td class="id_master_bank">
						<div class="check-box-div">
						<input type="checkbox" name="id_checkbox[]" class="iCheck-helper toedit checkbox_satuan" value="<?php echo $data_master_bank->id_master_bank_account; ?>" />
						</div><span><?php echo $data_master_bank->id_master_bank_account; ?></span></td>
                        <td class="code"><?php echo $data_master_bank->code; ?></td>
                        <td class="name"><?php echo $data_master_bank->name; ?></td>
						<td class="statement_balance"><?php convert_price($data_master_bank->statement_balance); ?></td>
						<td class="available_credit"><?php convert_price($data_master_bank->available_credit); ?></td>
						<td class="starting_balance"><?php echo $data_master_bank->starting_balance; ?></td>
						<td class="created_by"><?php echo $data_master_bank->created_by; ?></td>
						<td class="created_date"><?php echo $data_master_bank->created_date; ?></td>
						<td class="updated_by"><?php echo $data_master_bank->updated_by; ?></td>
						<td class="updated_date"><?php echo $data_master_bank->updated_date; ?></td>
						<?php if($data_role[0]['delete_master_bank']=='yes' || $data_role[0]['edit_master_bank']=='yes'){ ?>
						<td><?php if($data_role[0]['delete_master_bank']=='yes'){ ?><a  class="delete_data link_action" id="<?php echo $data_master_bank->id_master_bank_account; ?>" >Delete</a><?php } ?> | <?php if($data_role[0]['edit_master_bank']=='yes'){ ?><a  id="<?php echo $data_master_bank->id_master_bank_account; ?>" class="edit_data link_action">Edit</a><?php } ?></td>
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
		<h2 id="modal1Title">Add Master Bank Account</h2>
				<form role="form" id="form_add_data" method="POST" action="<?php echo base_url()."index.php/master_bank/addMasterBankAccount" ?>" enctype="multipart/form-data">
				 <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
				 
              <div class="box-body">

				<div class="form-group">
                  <label for="master_bankcode2">Code</label>
                 <input type="text" class="form-control" name="code" id="code" required>
                </div>
				
				<div class="form-group">
                  <label for="master_bankcode2">Name</label>
                 <input type="text" class="form-control" name="name" id="name" required>
                </div>
				
				<div class="form-group">
                  <label for="master_bankcode2">Statement Balance</label>
                 <input type="text" class="form-control" name="statement_balance" id="statement_balance" required>
                </div>
				
				<div class="form-group">
                  <label for="master_bankcode2">Available Credit</label>
                 <input type="text" class="form-control" name="available_credit" id="available_credit" required>
                </div>
				
				<div class="form-group">
					  <label for="drivercode2">Starting Balance</label>
						  <div class="input-group date">
						  <div class="input-group-addon">
							<i class="fa fa-calendar"></i>
						  </div>
						  <input type="text" name="starting_balance" id="starting_balance" class="form-control pull-right datepicker"  required>
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
		<h2 id="modal1Title">Edit Master Bank</h2>
				<form role="form" id="form_edit_data" method="POST" action="<?php echo base_url()."index.php/master_bank/editMasterBankAccount" ?>" enctype="multipart/form-data">
				 <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
				 
              <div class="box-body">

				<div class="form-group">
                  <label for="master_bankcode2">Code</label>
                 <input type="text" class="form-control" name="edit_code" id="edit_code" required>
                </div>
				
				<div class="form-group">
                  <label for="master_bankcode2">Name</label>
                 <input type="text" class="form-control" name="edit_name" id="edit_name" required>
                </div>
				
				<div class="form-group">
                  <label for="master_bankcode2">Statement Balance</label>
                 <input type="text" class="form-control" name="edit_statement_balance" id="edit_statement_balance" required>
                </div>
				
				<div class="form-group">
                  <label for="master_bankcode2">Available Credit</label>
                 <input type="text" class="form-control" name="edit_available_credit" id="edit_available_credit" required>
                </div>
				
				<div class="form-group">
					  <label for="drivercode2">Starting Balance</label>
						  <div class="input-group date">
						  <div class="input-group-addon">
							<i class="fa fa-calendar"></i>
						  </div>
						  <input type="text" name="edit_starting_balance" id="edit_starting_balance" class="form-control pull-right datepicker"  required>
						</div>
				</div>
				
                <input type="hidden" class="form-control" name="id_master_bank_update" id="id_master_bank_update">
              
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
				<form role="form" id="form_import_data" method="POST" action="<?php echo base_url()."index.php/master_bank/importDriver" ?>" enctype="multipart/form-data">
				 <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
				 
              <div class="box-body">

				 <div class="form-group">
                      <label for="exampleInputEmail1">Choose File</label>
                      <input type="file" name="import_file" id="import_file" class="form-control" value="" />
				</div>
				
				 <div class="form-group">
                    <p><a target="_blank" href="<?php echo base_url('/files/example-files/import-master_bank.xlsx')?>">Download sample file import master_bank</a></p>
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
				<form role="form" id="form_delete_data" method="POST" action="<?php echo base_url()."index.php/master_bank/deleteDriver" ?>" enctype="multipart/form-data">
				 <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
				 
              <div class="box-body">

				 <div class="form-group">
                     <p>Are you sure want to delete this data? (<span id="reference_delete"></span>)</p>
				</div>
				
				 <div class="form-group">
                      <input type="hidden" name="id_master_bank_delete" id="id_master_bank_delete" class="form-control" value="" />
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
				<form role="form" id="form_selected_delete_data" method="POST" action="<?php echo base_url()."index.php/master_bank/deleteDriverAll" ?>" enctype="multipart/form-data">
				 <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
				 
              <div class="box-body">

				 <div class="form-group">
                     <p>Are you sure want to delete selected data? </p>
				</div>
				
				 <div class="form-group">
                      <input type="hidden" name="id_master_bank_delete_all" id="id_master_bank_delete_all" class="form-control" value="" />
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
				var master_bank_code =  $('#data_'+id+' .master_bank_code').text();
				var id_master_bank =  $('#data_'+id+' .id_master_bank span').text();
				$("#reference_delete").text("Driver Code:"+master_bank_code)
				$("#id_master_bank_delete").val(id_master_bank);
			});
			
			
			
			$(".edit_data").click(function(){
				var id = $(this).attr('id');
				var id_master_bank =  $('#data_'+id+' .id_master_bank span').text();
				var code =  $('#data_'+id+' .code').text();
				var name =  $('#data_'+id+' .name').text();
				var statement_balance =  $('#data_'+id+' .statement_balance').text();
				var available_credit =  $('#data_'+id+' .available_credit').text();
				var starting_balance =  $('#data_'+id+' .starting_balance').text();
				
				$("#id_master_bank_update").val(id_master_bank);
				$("#edit_code").val(code);
				$("#edit_name").val(name);
				$("#edit_statement_balance").val(statement_balance);
				$("#edit_available_credit").val(available_credit);
				$("#edit_starting_balance").val(starting_balance);
			});

			$("#form_add_data").validate({
				rules: {
				statement_balance: {
				  digits: true
				},
				available_credit: {
				  digits: true
				}
				},
				messages: {
				code: {
				required: 'Code must be filled!'
				},
				name: {
				required: 'Name must be filled!'
				},
				statement_balance: {
				required: 'Statement Balance must be filled!'
				},
				available_credit: {
				required: 'Available Credit must be filled!'
				},
				starting_balance: {
				required: 'Starting Balance must be filled!'
				}
			}
			});
			
			
			
			$("#form_edit_data").validate({
				rules: {
				edit_statement_balance: {
				  digits: true
				},
				edit_available_credit: {
				  digits: true
				}
				},
				messages: {
				edit_code: {
				required: 'Code must be filled!'
				},
				edit_name: {
				required: 'Name must be filled!'
				},
				edit_statement_balance: {
				required: 'Statement Balance must be filled!'
				},
				edit_available_credit: {
				required: 'Available Credit must be filled!'
				},
				edit_starting_balance: {
				required: 'Starting Balance must be filled!'
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
		$("#id_master_bank_delete_all").val(ids);
		
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
