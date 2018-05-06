 <!-- HEADER -->
 <section class="content-header">
          <h1>
             Invoice
            <small>List Of Purchase Invoice</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="<?php echo BASE_URL(); ?>"><i class="fa fa-dashboard"></i>Home</a></li>
            <li><a href="<?php echo BASE_URL()."purchase_invoice"; ?>"><i class="fa fa-dashboard"></i>Invoice</a></li>
          </ol>
        </section>
  
  
   <!-- Content -->
   <section class="content">
		
		
  
  
          <div class="box sms box-default color-palette-box">
            <div class="box-header with-border">
              <h3 class="box-title"><i class="fa fa-table"></i> Table Invoice</h3>
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
                             <form action="<?php echo base_url()."index.php/purchase_invoice" ?>" method="get">
                             <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                                <input type="text" id="search" name="search" placeholder="Search..."  value="<?php echo $search; ?>" />
                                <input type="submit" id="submit"  value="Search"/>
                                <?php if($search!="")
								{?>
                                <a href="<?php echo base_url()."index.php/purchase_invoice" ?>" id="clear-search">Clear Search</a>
                                <?php } ?>
                             </form>
                </div>
                <div id="wrapper-button" class="clearfix">
					<?php if($data_role[0]['export_purchase_invoice']=='yes'){ ?>
                	<a href="#" class="button orange-button">
                    	Export Purchase Invoice
                    </a>
					<?php } ?>
                    <?php if($data_role[0]['add_purchase_invoice']=='yes'){ ?>
                    <a id="add-data" class="button green-button">
                    	Create Purchase Invoice
                    </a>
					<?php } ?>
					<?php if($data_role[0]['delete_purchase_invoice']=='yes'){ ?>
                    <a id="delete-data" class="button btn-danger deletelogg">
                    	Delete Purchase Invoice
                    </a>
					<?php } ?>
					
                </div>
                </div>
            <div id="wrapper-console" class="clearfix"> 
            <div class="grid_4 height400">                  
           	<table id="myTable0w2" class="fancyTable table table-bordered table-hover">
                    <thead>
                      <tr>
					  
                        <th><div class="check-box-div"><input type="checkbox" name="select_all" id="select_all"></div>ID Purchase Invoice</th>
                        <th>ID Reference</th>
						<th>Invoice Method</th>
						<th>Invoice Date</th>
                        <th>Invoice Number</th>
						<th>Invoice Type</th>
						<th>Confirmation</th>
						<th>Payment Method</th>
						<th>Created Date</th>
						<th>Created By</th>
						<th>Updated Date</th>
						<th>Updated By</th>
						<?php if($data_role[0]['delete_purchase_invoice']=='yes' || $data_role[0]['edit_purchase_invoice']=='yes'){ ?>
						<th>Action</th>
						<?php } ?>
						
						
                      </tr>
                    </thead>
             		<tbody>
                    <?php foreach($data_purchase_invoice as $data_purchase_invoice) {?>
                    <tr id="data_<?php echo $data_purchase_invoice->id_purchase_invoice; ?>">
                    	<td class="id_purchase_invoice">
						<div class="check-box-div">
						<?php if($data_purchase_invoice->confirmation!='yes'){ ?>
						<input type="checkbox" name="id_checkbox[]" class="iCheck-helper toedit checkbox_satuan" value="<?php echo $data_purchase_invoice->id_purchase_invoice; ?>" />
						<?php } ?>
						</div>
						<span><?php echo $data_purchase_invoice->id_purchase_invoice; ?></span>
						<b class='account' style='display:none'><?php echo $data_purchase_invoice->account; ?></b>
						</td>
                        
					
						<td class="id_reference"><?php echo $data_purchase_invoice->id_reference; ?></td>
						<td class="invoice_method"><?php echo $data_purchase_invoice->invoice_method; ?></td>
						<td class="invoice_date"><?php convert_date($data_purchase_invoice->invoice_date); ?></td>
                        <td class="invoice_number"><?php echo $data_purchase_invoice->invoice_number; ?></td>
						<td class="invoice_type"><?php echo $data_purchase_invoice->invoice_type; ?></td>
						<td class="confirmation"><?php echo $data_purchase_invoice->confirmation; ?></td>
						<td class="payment_method"><?php echo $data_purchase_invoice->payment_method; ?></td>
						<td class="created_date"><?php echo $data_purchase_invoice->created_date; ?></td>
						<td class="created_by"><?php echo $data_purchase_invoice->created_by; ?></td>
						<td class="updated_date"><?php echo $data_purchase_invoice->updated_date; ?></td>
						<td class="updated_by"><?php echo $data_purchase_invoice->updated_by; ?></td>
						
						
						<?php if($data_role[0]['delete_purchase_invoice']=='yes' || $data_role[0]['edit_purchase_invoice']=='yes'){ ?>
						<td>
						<?php if($data_role[0]['edit_purchase_invoice']=='yes'){ ?>
						
						
						<?php
								//Purchase
						if($data_purchase_invoice->invoice_method=='purchase')
						{
						?>
						<?php if($data_purchase_invoice->invoice_type=='tms' || $data_purchase_invoice->invoice_type=='po'){ ?>
						<a  class="confirmed_payment link_action" id="<?php echo $data_purchase_invoice->id_purchase_invoice; ?>" >Spend Money</a> |
						<?php } ?>
						
						<?php if($data_purchase_invoice->invoice_type=='io'){ ?>
						<a  class="confirmed_payment link_action" id="<?php echo $data_purchase_invoice->id_purchase_invoice; ?>" >Spend Stock</a> |
						<?php } ?>
						<?php }else{ ?>
							<a  class="charge_payment link_action" id="<?php echo $data_purchase_invoice->id_purchase_invoice; ?>" >Receive Money</a> |
						<?php } ?>
						
						
						
						
						
						
						<?php if($data_role[0]['edit_purchase_invoice']=='yes'){ ?><a  id="<?php echo $data_purchase_invoice->id_purchase_invoice; ?>" class="edit_data link_action">Edit</a><?php } ?>
						<?php } ?>
						
						
						<?php  ?>
						<a  class="delete_data link_action" id="<?php echo $data_purchase_invoice->id_purchase_invoice; ?>" >Delete</a><?php  ?>
						
						
						<?php } ?>
						</td>
						
						
						
						
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
	
	
	
	
	<div class="remodal" data-remodal-id="modal_spend" role="dialog" aria-labelledby="modal1Titl aria-describedby="modal1Desc">
	  <button data-remodal-action="close" class="remodal-close" aria-label="Close"></button>
	  <div>
		<h2 id="modal1TitleSpend">Spend Money / Stock</h2>
				<form role="form" id="form_confirmed_payment" method="POST" action="<?php echo base_url()."index.php/purchase_invoice/confirmedPayment" ?>" enctype="multipart/form-data">
				 <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
				 
              <div class="box-body">
			  
					<input type='hidden' name='confirmed_payment_id_invoice' id='confirmed_payment_id_invoice'>
					<input type='hidden' name='confirmed_payment_invoice_type' id='confirmed_payment_invoice_type'>
					
					<input type='hidden' name='confirmed_payment_invoice_number' id='confirmed_payment_invoice_number'>
					
					<div id='money-confirm'>
					
						<div class="form-group">
							  <label for="drivercode2">Confirmation</label>
							  <select class="form-control" name="confirm_payment" id="confirm_payment" required>
								<option selected="selected" value="">Choose Confirmation</option>
								<option value="confirmed">Confirmed</option>
								<option value="unconfirmed">Unconfirmed</option>
							  </select> 
						</div>
						
						
						
						
						<div class="form-group">
						  <label for="drivercode2">Payment Method</label>
						  <select class="form-control" name="payment_method" id="payment_method" required>
							<option selected="selected" value="">Choose Payment method</option>
							<option value="cash">Cash Account</option>
							<option value="bank">Bank Account</option>
						  </select> 
						</div>
						
						<div class="form-group">
						  <label for="drivercode2">Account</label>
						  <select class="form-control" name="account" id="account" required>
							<option selected="selected" value="">Choose Account</option>
							
							<?php foreach($data_cash_account_spend as $data_cash_account_spend){ ?>
								<option style='display:none' class='cash payment_method'  value="<?php echo $data_cash_account_spend->id_cash_account; ?>">Name : <?php echo $data_cash_account_spend->name; ?> - Balance : <?php echo $data_cash_account_spend->balance; ?></option>
							<?php } ?>
							<?php foreach($data_bank_account_spend as $data_bank_account_spend){ ?>
								<option  style='display:none' class='bank payment_method'  value="<?php echo $data_bank_account_spend->id_master_bank_account; ?>">Name : <?php echo $data_bank_account_spend->name; ?> - Balance : <?php echo $data_bank_account_spend->statement_balance; ?></option>
							<?php } ?>
							
						  </select> 
						</div>
						
					
					</div>
					
					<div id='stock-confirm'>
							<div class="form-group">
							  <label for="drivercode2">Confirmation</label>
							  <select class="form-control" name="confirm_stock" id="confirm_stock" required>
								<option selected="selected" value="">Choose Confirmation</option>
								<option value="confirmed">Confirmed</option>
								<option value="unconfirmed">Unconfirmed</option>
							  </select> 
						</div>
					</div>
			  
			  
			  </div>

              <div class="box-footer">
                <button data-remodal-action="cancel" class="remodal-cancel">Cancel</button>
				<input type="submit" name="submit_add" class="remodal-confirm" value="Submit" id="submit_add">
              </div>
            </form>
	  </div>
	  <br>
	</div>
	
	
	
	
	
	
	<div class="remodal" data-remodal-id="modal_charge" role="dialog" aria-labelledby="modal1Titl aria-describedby="modal1Desc">
	  <button data-remodal-action="close" class="remodal-close" aria-label="Close"></button>
	  <div>
		<h2 id="modal1TitleSpend">Receive Money</h2>
				<form role="form" id="form_charge_payment" method="POST" action="<?php echo base_url()."index.php/purchase_invoice/chargePayment" ?>" enctype="multipart/form-data">
				 <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
				 
              <div class="box-body">
			  
					<input type='hidden' name='charge_payment_id_invoice' id='charge_payment_id_invoice'>
					<input type='hidden' name='charge_payment_invoice_type' id='charge_payment_invoice_type'>
					
					<input type='hidden' name='charge_payment_invoice_number' id='charge_payment_invoice_number'>
					
					
						<div class="form-group">
							  <label for="drivercode2">Confirmation</label>
							  <select class="form-control" name="charge_payment" id="charge_payment" required>
								<option selected="selected" value="">Choose Confirmation</option>
								<option value="confirmed">Confirmed</option>
								<option value="unconfirmed">Unconfirmed</option>
							  </select> 
						</div>
						
						
						
						
						<div class="form-group">
						  <label for="drivercode2">Payment Method</label>
						  <select class="form-control" name="charge_payment_method" id="charge_payment_method" required>
							<option selected="selected" value="">Choose Payment method</option>
							<option value="cash">Cash Account</option>
							<option value="bank">Bank Account</option>
						  </select> 
						</div>
						
						<div class="form-group">
						  <label for="drivercode2">Account</label>
						  <select class="form-control" name="charge_account" id="charge_account" required>
							<option selected="selected" value="">Choose Account</option>
							<?php foreach($data_cash_account_receive as $data_cash_account_receive){ ?>
								<option style='display:none' class='cash payment_method'  value="<?php echo $data_cash_account_receive->id_cash_account; ?>">Name : <?php echo $data_cash_account_receive->name; ?> - Balance : <?php echo $data_cash_account_receive->balance; ?></option>
							<?php } ?>
							<?php foreach($data_bank_account_receive as $data_bank_account_receive){ ?>
								<option  style='display:none' class='bank payment_method'  value="<?php echo $data_bank_account_receive->id_master_bank_account; ?>">Name : <?php echo $data_bank_account_receive->name; ?> - Balance : <?php echo $data_bank_account_receive->statement_balance; ?></option>
							<?php } ?>
						  </select> 
						</div>
						
					
					
			  
			  
			  </div>

              <div class="box-footer">
                <button data-remodal-action="cancel" class="remodal-cancel">Cancel</button>
				<input type="submit" name="submit_add" class="remodal-confirm" value="Submit" id="submit_add">
              </div>
            </form>
	  </div>
	  <br>
	</div>
	
	
	
	  
	 <div class="remodal" data-remodal-id="modal_add" role="dialog" aria-labelledby="modal1Titl aria-describedby="modal1Desc">
	  <button data-remodal-action="close" class="remodal-close" aria-label="Close"></button>
	  <div>
		<h2 id="modal1Title">Create Purchase Invoice</h2>
				<form role="form" id="form_add_data" method="POST" action="<?php echo base_url()."index.php/purchase_invoice/addPurchaseInvoice" ?>" enctype="multipart/form-data">
				 <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
				 
              <div class="box-body">
				 
				 
				 <div class="form-group">
					  <label for="drivercode2">Invoice Method</label>
					  <select class="form-control" name="invoice_method" id="invoice_method" required>
						<option selected="selected" value="">Choose Invoice Method</option>
						<option value="purchase">Purchase</option>
						<option value="sales">Sales</option>
					  </select> 
				</div>
				
				
				
				 <div class="form-group">
                  <label for="purchase_invoicecode2">Invoice Number</label>
                 <input type="text" class="form-control" name="invoice_number" id="invoice_number" required>
                </div>
				
				<div class="form-group">
					  <label for="drivercode2">Invoice Date</label>
						  <div class="input-group date">
						  <div class="input-group-addon">
							<i class="fa fa-calendar"></i>
						  </div>
						  <input type="text" name="invoice_date" id="invoice_date" class="form-control pull-right datepicker"  required>
						</div>
				</div>
				
				
				<div class="form-group">
					  <label for="drivercode2">Purchase Invoice</label>
					  <select class="form-control" name="purchase_invoice" id="purchase_invoice" required>
						<option selected="selected" value="">Choose Purchase Invoice</option>
						<option class='purchase invoice_type' value="po">po</option>
						<option class='purchase sales invoice_type' value="io">IO</option>
						<option class='purchase sales invoice_type' value="tms">TMS</option>
					  </select> 
				</div>
				
				
				
				<div style='display:none;' class='panel_payment' id='add_tms'>
				
						<div class="form-group">
						 <label>Manifest ID</label>
							<div class="input-group">
							  <div class="input-group-addon">
								<i class="fa fa-search"></i>
							  </div>
							  <input type="text" class="form-control pull-right" name="search_manifest_id" id="search_manifest_id" value=''n placeholder='Search Manifest ID'>
							  <input type="text" readonly class="form-control" name="manifest_id" id="manifest_id" placeholder='Manifest ID' required>
							</div>
							<!-- /.input group -->
						</div>
						
						<h2>TMS Price</h2>
						<table class='po' id="list_table_tms">
							<thead>
								<tr>
									<th>No</th>
									<th>Manifest</th>
									<th>Client Id</th>
									<th>Client Name</th>
									<th>Origin</th>
									<th>Destination</th>
									<th>Cost</th>
								</tr>
							</thead>
							<tbody>
							</tbody>
						</table>
						
						<br>
						<h2>Additional Cost</h2>
						<table class='po' id="list_table_tms_additional_cost">
							<thead>
								<tr>
									<th>No</th>
									<th>Manifest</th>
									<th>Description</th>
									<th>Amount</th>
								</tr>
							</thead>
							<tbody>
							</tbody>
						</table>
						
				
				
				</div>
				
				<div style='display:none;' class='panel_payment' id='add_io'>
					
					<div class="form-group">
						 <label>IO ID</label>
							<div class="input-group">
							  <div class="input-group-addon">
								<i class="fa fa-search"></i>
							  </div>
							  <input type="text" class="form-control pull-right" name="search_io_id" id="search_io_id" value=''n placeholder='Search IO ID'>
							  <input type="text" readonly class="form-control" name="io_id" id="io_id" placeholder='IO ID' required>
							</div>
							<!-- /.input group -->
						</div>
						
						<table class='po' id="list_table_io">
							<thead>
								<tr>
									<th>No</th>
									<th>Product Name</th>
									<th>Qty</th>
									<th>Price</th>
									<th>Total</th>
								</tr>
							</thead>
							<tbody>
							</tbody>
						</table>
				</div>
				
				</div>
				
				<div style='display:none;' class='panel_payment' id='add_po'>
						
						
						<div class="form-group">
						 <label>PO ID</label>
							<div class="input-group">
							  <div class="input-group-addon">
								<i class="fa fa-search"></i>
							  </div>
							  <input type="text" class="form-control pull-right" name="search_po_id" id="search_po_id" value=''n placeholder='Search PO ID'>
							  <input type="text" readonly class="form-control" name="po_id" id="po_id" placeholder='PO ID' required>
							</div>
							<!-- /.input group -->
						</div>
						
						<table class='po' id="list_table_po">
							<thead>
								<tr>
									<th>No</th>
									<th>Product Name</th>
									<th>Qty</th>
									<th>Price</th>
									<th>Total</th>
								</tr>
							</thead>
							<tbody>
							</tbody>
						</table>
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
		<h2 id="modal1Title">Edit Purchase Invoice</h2>
				<form role="form" id="form_edit_data" method="POST" action="<?php echo base_url()."index.php/purchase_invoice/editPurchaseInvoice" ?>" enctype="multipart/form-data">
				 <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
				 
				
				
				 <div class="box-body">

				 
				 <input type='hidden' name='id_update_purchase_invoice' id='id_update_purchase_invoice' value=''>
				 <div class="form-group">
                  <label for="purchase_invoicecode2">Invoice Number</label>
                 <input type="text" class="form-control" name="edit_invoice_number" id="edit_invoice_number" required>
                </div>
				
				<div class="form-group">
					  <label for="drivercode2">Invoice Date</label>
						  <div class="input-group date">
						  <div class="input-group-addon">
							<i class="fa fa-calendar"></i>
						  </div>
						  <input type="text" name="edit_invoice_date" id="edit_invoice_date" class="form-control pull-right datepicker"  required>
						</div>
				</div>
				
				
				<div class="form-group">
					  <label for="drivercode2">Purchase Invoice</label>
					  <select readonly class="form-control" name="edit_purchase_invoice" id="edit_purchase_invoice" required>
						<option selected="selected" value="">Choose Purchase Invoice</option>
						<option value="po">po</option>
						<option value="io">IO</option>
						<option value="tms">TMS</option>
					  </select> 
				</div>
				
				
				
				<div style='display:none;' class='panel_payment' id='edit_tms'>
				
						<div class="form-group">
						 <label>Manifest ID</label>
							<div class="input-group">
							  <div class="input-group-addon">
								<i class="fa fa-search"></i>
							  </div>
							  <input type="text" class="form-control pull-right" name="edit_search_manifest_id" id="edit_search_manifest_id" value=''n placeholder='Search Manifest ID'>
							  <input type="text" readonly class="form-control" name="edit_manifest_id" id="edit_manifest_id" placeholder='Manifest ID' required>
							</div>
							<!-- /.input group -->
						</div>
						
						<h2>TMS Price</h2>
						<table class='po' id="edit_list_table_tms">
							<thead>
								<tr>
									<th>No</th>
									<th>Manifest</th>
									<th>Client Id</th>
									<th>Client Name</th>
									<th>Origin</th>
									<th>Destination</th>
									<th>Cost</th>
								</tr>
							</thead>
							<tbody>
							</tbody>
						</table>
						
						<br>
						<h2>Additional Cost</h2>
						<table class='po' id="edit_list_table_tms_additional_cost">
							<thead>
								<tr>
									<th>No</th>
									<th>Manifest</th>
									<th>Description</th>
									<th>Amount</th>
								</tr>
							</thead>
							<tbody>
							</tbody>
						</table>
						
				
				
				</div>
				
				<div style='display:none;' class='panel_payment' id='edit_io'>
					
					<div class="form-group">
						 <label>IO ID</label>
							<div class="input-group">
							  <div class="input-group-addon">
								<i class="fa fa-search"></i>
							  </div>
							  <input type="text" class="form-control pull-right" name="edit_search_io_id" id="edit_search_io_id" value=''n placeholder='Search IO ID'>
							  <input type="text" readonly class="form-control" name="edit_io_id" id="edit_io_id" placeholder='IO ID' required>
							</div>
							<!-- /.input group -->
						</div>
						
						<table class='po' id="edit_list_table_io">
							<thead>
								<tr>
									<th>No</th>
									<th>Product Name</th>
									<th>Qty</th>
									<th>Price</th>
									<th>Total</th>
								</tr>
							</thead>
							<tbody>
							</tbody>
						</table>
				</div>
				
				</div>
				
				<div style='display:none;' class='panel_payment' id='edit_po'>
						
						
						<div class="form-group">
						 <label>PO ID</label>
							<div class="input-group">
							  <div class="input-group-addon">
								<i class="fa fa-search"></i>
							  </div>
							  <input type="text" class="form-control pull-right" name="edit_search_po_id" id="edit_search_po_id" value=''n placeholder='Search PO ID'>
							  <input type="text" readonly class="form-control" name="edit_po_id" id="edit_po_id" placeholder='PO ID' required>
							</div>
							<!-- /.input group -->
						</div>
						
						<table class='po' id="edit_list_table_po">
							<thead>
								<tr>
									<th>No</th>
									<th>Product Name</th>
									<th>Qty</th>
									<th>Price</th>
									<th>Total</th>
								</tr>
							</thead>
							<tbody>
							</tbody>
						</table>
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
		<h2 id="modal1Title">Delete Purchase Invoice</h2>
				<form role="form" id="form_delete_data" method="POST" action="<?php echo base_url()."index.php/purchase_invoice/deletePurchase Invoice" ?>" enctype="multipart/form-data">
				 <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
				 
              <div class="box-body">

				 <div class="form-group">
                     <p>Are you sure want to delete this data? (<span id="reference_delete"></span>)</p>
				</div>
				
				 <div class="form-group">
                      <input type="hidden" name="id_purchase_invoice_delete" id="id_purchase_invoice_delete" class="form-control" value="" />
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
		<h2 id="modal1Title">Delete Purchase Invoice</h2>
				<form role="form" id="form_selected_delete_data" method="POST" action="<?php echo base_url()."index.php/purchase_invoice/deletePurchase InvoiceAll" ?>" enctype="multipart/form-data">
				 <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
				 
              <div class="box-body">

				 <div class="form-group">
                     <p>Are you sure want to delete selected data? </p>
				</div>
				
				 <div class="form-group">
                      <input type="hidden" name="id_purchase_invoice_delete_all" id="id_purchase_invoice_delete_all" class="form-control" value="" />
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
				var purchase_invoice_code =  $('#data_'+id+' .purchase_invoice_code').text();
				var id_purchase_invoice =  $('#data_'+id+' .id_purchase_invoice span').text();
				$("#reference_delete").text("Purchase Invoice Code:"+purchase_invoice_code)
				$("#id_purchase_invoice_delete").val(id_purchase_invoice);
			});
			
			
			$(".charge_payment").click(function(){
				$("#form_charge_payment").trigger('reset');
				$('[data-remodal-id = modal_charge]').remodal().open();
				
				var validator = $( "#form_charge_payment" ).validate();
				validator.resetForm();
	
				var id = $(this).attr('id');
				var id_purchase_invoice =  $('#data_'+id+' .id_purchase_invoice span').text();
				var invoice_date =  $('#data_'+id+' .invoice_date').text();
				var invoice_number =  $('#data_'+id+' .invoice_number').text();
				var invoice_type =  $('#data_'+id+' .invoice_type').text();
				var id_reference =  $('#data_'+id+' .id_reference').text();
				var status_payment =  $('#data_'+id+' .status_payment').text();
				
				var account =  $('#data_'+id+' .id_purchase_invoice .account').text();
				var confirmation =  $('#data_'+id+' .confirmation').text();
				var payment_method =  $('#data_'+id+' .payment_method').text();
				
				$(".payment_method").show();
				$('#form_charge_payment select#charge_payment option[value="'+confirmation+'"]').prop('selected',true);
				$('#form_charge_payment select#charge_payment_method option[value="'+payment_method+'"]').prop('selected',true);
				$('#form_charge_payment select#charge_account option[value="'+account+'"]').prop('selected',true);
				
				
				
				if(confirmation=='confirmed')
				{
					$("#charge_payment_method").attr('readonly','readonly');
					$("#charge_account").attr('readonly','readonly');
				}
				
				
				$("#charge_payment_id_invoice").val(id_purchase_invoice);
				$("#charge_payment_invoice_type").val(invoice_type);
				$("#charge_payment_invoice_number").val(invoice_number);
				
				
				
			});
			
			
			$(".confirmed_payment").click(function(){
				$("#form_confirmed_payment").trigger('reset');
				$('[data-remodal-id = modal_spend]').remodal().open();
				
				var validator = $( "#form_confirmed_payment" ).validate();
				validator.resetForm();
	
				var id = $(this).attr('id');
				var id_purchase_invoice =  $('#data_'+id+' .id_purchase_invoice span').text();
				var invoice_date =  $('#data_'+id+' .invoice_date').text();
				var invoice_number =  $('#data_'+id+' .invoice_number').text();
				var invoice_type =  $('#data_'+id+' .invoice_type').text();
				var id_reference =  $('#data_'+id+' .id_reference').text();
				var status_payment =  $('#data_'+id+' .status_payment').text();
				
				var account =  $('#data_'+id+' .id_purchase_invoice .account').text();
				var confirmation =  $('#data_'+id+' .confirmation').text();
				var payment_method =  $('#data_'+id+' .payment_method').text();
				
				
				$(".payment_method").show();
				$('#form_confirmed_payment select#confirm_payment option[value="'+confirmation+'"]').prop('selected',true);
				$('#form_confirmed_payment select#payment_method option[value="'+payment_method+'"]').prop('selected',true);
				$('#form_confirmed_payment select#account option[value="'+account+'"]').prop('selected',true);
				
			
				
				if(confirmation=='confirmed')
				{
					$("#payment_method").attr('readonly','readonly');
					$("#account").attr('readonly','readonly');
				}
				
				
				$("#confirmed_payment_id_invoice").val(id_purchase_invoice);
				$("#confirmed_payment_invoice_type").val(invoice_type);
				$("#confirmed_payment_invoice_number").val(invoice_number);
				
				if(invoice_type=='po' || invoice_type=='tms')
				{
					
					
					

					$("#stock-confirm").hide();
					$("#money-confirm").show();
					
					
				}
				else if(invoice_type=='io')
				{
					$("#stock-confirm").show();
					$("#money-confirm").hide();
				}
				
			});
			
			$(".edit_data").click(function(){
				var id = $(this).attr('id');
				var id_purchase_invoice =  $('#data_'+id+' .id_purchase_invoice span').text();
				var invoice_date =  $('#data_'+id+' .invoice_date').text();
				var invoice_number =  $('#data_'+id+' .invoice_number').text();
				var invoice_type =  $('#data_'+id+' .invoice_type').text();
				var id_reference =  $('#data_'+id+' .id_reference').text();
				var status_payment =  $('#data_'+id+' .status_payment').text();
				
				$("#edit_invoice_number").val(invoice_number);
				$("#edit_invoice_date").val(invoice_date);
				$("#id_update_purchase_invoice").val(id_purchase_invoice);
				
				$('#edit_purchase_invoice option[value="'+invoice_type+'"]').prop('selected',true);
				
				$('.panel_payment').hide();
				$('#edit_'+invoice_type).show();
				
				$("#edit_"+invoice_type+"_id").val(id_reference);
				
				
				if(status_payment=='yes')
				{$("#edit_search_"+invoice_type+"_id").attr('readonly','readonly');}
				
				
				if(invoice_type=='po')
				{
					editAjaxPo(id_purchase_invoice);
				}
				else if(invoice_type=='io')
				{
					editAjaxIo(id_purchase_invoice);
				}
				else if(invoice_type=='tms')
				{
					editAjaxTms(id_purchase_invoice);
					editAjaxTmsCost(id_purchase_invoice);
					$("#edit_manifest_id").val(id_reference);
					
					if(status_payment=='yes')
					{$("#edit_search_manifest_id").attr('readonly','readonly');}
				}
			
				
			});
			
			function editAjaxPo(id_pi)
			{
				 $.ajax({
				  url: '<?php echo BASE_URL(); ?>/index.php/json/jsonProductInvoice?term='+id_pi,
				  success: function(data,status)
				  {
					$("#edit_list_table_po tbody tr").remove();
					
					createTableProductPoPi(data,id_pi);
					
				  },
				  async:   true,
				  dataType: 'json'
				}); 
			}
			
			function createTableProductPoPi(data,id_pi)
			{
				
			  for(var i=0; i<data.length;i++)
			  {
					var total = parseInt(data[i]['qty']) * parseInt(data[i]['price']);
					var no = i + 1;
					var j = i + 2;
					
							harga_rupiah = data[i]['price'];
							var	number_string = harga_rupiah.toString(),
							sisa 	= number_string.length % 3,
							total_harga_rupiah = number_string.substr(0, sisa),
							ribuan 	= number_string.substr(sisa).match(/\d{3}/g);
								
							if (ribuan) {
								separator = sisa ? '.' : '';
								total_harga_rupiah += separator + ribuan.join('.');
							}
							
							harga_total = total;
							var	number_string = harga_total.toString(),
							sisa 	= number_string.length % 3,
							total_total_harga_rupiah = number_string.substr(0, sisa),
							ribuan 	= number_string.substr(sisa).match(/\d{3}/g);
								
							if (ribuan) {
								separator = sisa ? '.' : '';
								total_total_harga_rupiah += separator + ribuan.join('.');
							}
							
					$("#edit_list_table_po tbody").append("<tr>"+
												"<td><input type='hidden' name='id_product[]' value='"+data[i]['id_product']+"' >"+no+"</td>"+
												"<td>"+data[i]['product_name']+"</td>"+
												"<td><input type='hidden' name='qty[]' value='"+data[i]['qty']+"' >"+data[i]['qty']+"</td>"+
												"<td><input type='hidden' name='price[]' value='"+data[i]['price']+"' >"+total_harga_rupiah+"</td>"+
												"<td><input type='hidden' name='product_code[]' value='"+data[i]['product_code']+"' ><input type='hidden' name='product_name[]' value='"+data[i]['product_name']+"' ><input type='hidden' name='price_total[]' value='"+total+"' >"+total_total_harga_rupiah+"</td>"+
												"</tr>");
												
			  }
			  
			 
			}

		
			
			
			function editAjaxIo(id_pi)
			{
				 $.ajax({
				  url: '<?php echo BASE_URL(); ?>/index.php/json/jsonProductInvoice?term='+id_pi,
				  success: function(data,status)
				  {
					$("#edit_list_table_po tbody tr").remove();
					
					createTableProductIoPi(data,id_pi);
					
				  },
				  async:   true,
				  dataType: 'json'
				}); 
			}
			
			function createTableProductIoPi(data,id_pi)
			{
				
			  for(var i=0; i<data.length;i++)
			  {
					var total = parseInt(data[i]['qty']) * parseInt(data[i]['price']);
					var no = i + 1;
					var j = i + 2;
					
							harga_rupiah = data[i]['price'];
							var	number_string = harga_rupiah.toString(),
							sisa 	= number_string.length % 3,
							total_harga_rupiah = number_string.substr(0, sisa),
							ribuan 	= number_string.substr(sisa).match(/\d{3}/g);
								
							if (ribuan) {
								separator = sisa ? '.' : '';
								total_harga_rupiah += separator + ribuan.join('.');
							}
							
							harga_total = total;
							var	number_string = harga_total.toString(),
							sisa 	= number_string.length % 3,
							total_total_harga_rupiah = number_string.substr(0, sisa),
							ribuan 	= number_string.substr(sisa).match(/\d{3}/g);
								
							if (ribuan) {
								separator = sisa ? '.' : '';
								total_total_harga_rupiah += separator + ribuan.join('.');
							}
							
					$("#edit_list_table_io tbody").append("<tr>"+
												"<td><input type='hidden' name='id_product[]' value='"+data[i]['id_product']+"' >"+no+"</td>"+
												"<td>"+data[i]['product_name']+"</td>"+
												"<td><input type='hidden' name='qty[]' value='"+data[i]['qty']+"' >"+data[i]['qty']+"</td>"+
												"<td><input type='hidden' name='price[]' value='"+data[i]['price']+"' >"+total_harga_rupiah+"</td>"+
												"<td><input type='hidden' name='product_code[]' value='"+data[i]['product_code']+"' ><input type='hidden' name='product_name[]' value='"+data[i]['product_name']+"' ><input type='hidden' name='price_total[]' value='"+total+"' >"+total_total_harga_rupiah+"</td>"+
												"</tr>");
												
			  }
			  
			 
			}
			
			function editAjaxTms(id_pi)
			{
				 $.ajax({
				  url: '<?php echo BASE_URL(); ?>/index.php/json/jsonTmsInvoice?term='+id_pi,
				  success: function(data,status)
				  {
					$("#edit_list_table_tms tbody tr").remove();
					
					createEditTableTms(data,id_pi);
					//alert("hai");
				  },
				  async:   true,
				  dataType: 'json'
				}); 
			}
			
			function createEditTableTms(data,id_po)
			{
			  for(var i=0; i<data.length;i++)
			  {
					
					var no = i + 1;
					var j = i + 2;
							
							rate_rupiah = data[i]['cost'];
							var	number_string = rate_rupiah.toString(),
							sisa 	= number_string.length % 3,
							total_rate_rupiah = number_string.substr(0, sisa),
							ribuan 	= number_string.substr(sisa).match(/\d{3}/g);
								
							if (ribuan) {
								separator = sisa ? '.' : '';
								total_rate_rupiah += separator + ribuan.join('.');
							}
							
							
							
					$("#edit_list_table_tms tbody").append("<tr>"+
													 "<td>"+no+"</th>"+
													 "<td>"+data[i]['manifest']+"</td>"+
													 "<td>"+data[i]['client_id']+"</td>"+
													 "<td>"+data[i]['client_name']+"</td>"+
													 "<td>"+data[i]['origin']+"</td>"+
													 "<td>"+data[i]['destination']+"</td>"+
													 "<td>"+total_rate_rupiah+"</td>"+
													 "</tr>");
												
			  }
			  
			  }
			  
			 function editAjaxTmsCost(id_pi)
			{
				 $.ajax({
				  url: '<?php echo BASE_URL(); ?>/index.php/json/jsonTmsCostInvoice?term='+id_pi,
				  success: function(data,status)
				  {
					$("#edit_list_table_tms_additional_cost tbody tr").remove();
					
					createTableEditTmsAdditionalCost(data,id_pi);
					
				  },
				  async:   true,
				  dataType: 'json'
				}); 
			}
			
			
			
			function createTableEditTmsAdditionalCost(data,id_po)
			{
			  for(var i=0; i<data.length;i++)
			  {
					
					var no = i + 1;
					var j = i + 2;
							rate_rupiah = data[i]['amount'];
							var	number_string = rate_rupiah.toString(),
							sisa 	= number_string.length % 3,
							total_rate_rupiah = number_string.substr(0, sisa),
							ribuan 	= number_string.substr(sisa).match(/\d{3}/g);
								
							if (ribuan) {
								separator = sisa ? '.' : '';
								total_rate_rupiah += separator + ribuan.join('.');
							}
							
							
							
					$("#edit_list_table_tms_additional_cost tbody").append("<tr>"+
													  "<td>"+no+"</td>"+
													  "<td>"+data[i]['manifest']+"</td>"+
													  "<td>"+data[i]['additional_type']+"</td>"+
													  "<td>"+total_rate_rupiah+"</td>"+
													  "</tr>");
												
			  }
			  
			 
			}
			  
			 
			

			$("#form_add_data").validate({
				
				messages: {
				invoice_number: {
				required: 'Invoice Number must be filled!'
				},
				invoice_date: {
				required: 'Invoice Date must be filled!'
				}
			}
			});
			
			
			$("#form_confirmed_payment").validate({
				
				messages: {
				payment_method: {
				required: 'payment method must be filled!'
				},
				account: {
				required: 'Account must be filled!'
				},
				confirm_stock: {
				required: 'Confirm Stock must be filled!'
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
				edit_purchase_invoice_name: {
				required: 'Purchase Invoice Name must be filled!'
				},
				edit_purchase_invoice_code: {
				required: 'Purchase Invoice Code must be filled!'
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

 	$('.datepicker').datepicker({
			  autoclose: true,
			  Format: 'dd-mm-yyyy'
			});
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
		$("#id_purchase_invoice_delete_all").val(ids);
		
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


$( "#purchase_invoice" ).change(function() {
	
		var invoice_method = $("#invoice_method").val();
		
		if(invoice_method=='')
		{
			alert("Please Select Invoice Method first!");
			$(this).val();
		}
		else
		{
			purchase_invoice = $(this).val();
			$('.panel_payment').hide();
			$('#add_'+purchase_invoice).show();
			
		}
		
});


$("#invoice_method").change(function() {
	
		var invoice_method = $(this).val();
		
		
		$('#purchase_invoice option[value=""]').prop('selected',true);
		$('.panel_payment').hide();
		$('.invoice_type').hide();
		$('.'+invoice_method).show();
		
		$("#search_manifest_id").val('');
		$("#manifest_id").val('');
		$("#search_po_id").val('');
		$("#po_id").val('');
		$("#search_io_id").val('');
		$("#io_id").val('');
		
		$("#list_table_tms tbody tr").remove();  
		$("#list_table_tms_additional_cost tbody tr").remove();  
		$("#list_table_io tbody tr").remove(); 
		$("#list_table_po tbody tr").remove(); 		
		
		
});

</script>

<script>
        $( "#search_po_id" ).autocomplete({
         source: "<?php echo BASE_URL(); ?>/index.php/json/jsonPoPi",  
         minLength:0,
		 select: function( event , ui ) {
			  $( "#po_id" ).val( ui.item.id_po );
			  var id_po = ui.item.id_po;
			  
			   $.ajax({
				  url: '<?php echo BASE_URL(); ?>/index.php/json/jsonProductPoGr?id_po='+id_po,
				  success: function(data,status)
				  {
					$("#list_table_po tbody tr").remove();  
					createTableProductPO(data,id_po);
				  },
				  async:   true,
				  dataType: 'json'
				}); 
        }    
        })
		.autocomplete( "instance" )._renderItem = function( ul, item ) {
		  return $( "<li style='position:relative; z-index:9999;'>" )
			.append( "<div style='font-size:10px;'>" + item.label+"</div>" )
			.appendTo( ul );
		};
		
		
			function createTableProductPO(data,id_po)
			{
			  for(var i=0; i<data.length;i++)
			  {
					var total = parseInt(data[i]['qty_approve']) * parseInt(data[i]['price']);
					var no = i + 1;
					var j = i + 2;
					
							harga_rupiah = data[i]['price'];
							var	number_string = harga_rupiah.toString(),
							sisa 	= number_string.length % 3,
							total_harga_rupiah = number_string.substr(0, sisa),
							ribuan 	= number_string.substr(sisa).match(/\d{3}/g);
								
							if (ribuan) {
								separator = sisa ? '.' : '';
								total_harga_rupiah += separator + ribuan.join('.');
							}
							
							harga_total = total;
							var	number_string = harga_total.toString(),
							sisa 	= number_string.length % 3,
							total_total_harga_rupiah = number_string.substr(0, sisa),
							ribuan 	= number_string.substr(sisa).match(/\d{3}/g);
								
							if (ribuan) {
								separator = sisa ? '.' : '';
								total_total_harga_rupiah += separator + ribuan.join('.');
							}
							
					$("#list_table_po tbody").append("<tr>"+
												"<td><input type='hidden' name='id_product[]' value='"+data[i]['id_product']+"' >"+no+"</td>"+
												"<td>"+data[i]['product_name']+"</td>"+
												"<td><input type='hidden' name='qty[]' value='"+data[i]['qty_approve']+"' >"+data[i]['qty_approve']+"</td>"+
												"<td><input type='hidden' name='price[]' value='"+data[i]['price']+"' >"+total_harga_rupiah+"</td>"+
												"<td><input type='hidden' name='product_code[]' value='"+data[i]['product_code']+"' ><input type='hidden' name='product_name[]' value='"+data[i]['product_name']+"' ><input type='hidden' name='price_total[]' value='"+total+"' >"+total_total_harga_rupiah+"</td>"+
												"</tr>");
												
			  }
			  
			 
			}
</script>



<script>
        $( "#search_io_id" ).autocomplete({
         source: "<?php echo BASE_URL(); ?>/index.php/json/jsonIo",  
         minLength:0,
		 select: function( event , ui ) {
			  $( "#io_id" ).val( ui.item.id_io );
			  var id_io = ui.item.id_io;
			  
			   $.ajax({
				  url: '<?php echo BASE_URL(); ?>/index.php/json/jsonProductIoInvoice?id_io='+id_io,
				  success: function(data,status)
				  {
					$("#list_table_io tbody tr").remove();  
					createTableProductIo(data,id_io);
				  },
				  async:   true,
				  dataType: 'json'
				}); 
        }    
        })
		.autocomplete( "instance" )._renderItem = function( ul, item ) {
		  return $( "<li style='position:relative; z-index:9999;'>" )
			.append( "<div style='font-size:10px;'>" + item.label+"</div>" )
			.appendTo( ul );
		};
		
		
			function createTableProductIo(data,id_po)
			{
			  for(var i=0; i<data.length;i++)
			  {
					var total = parseInt(data[i]['qty_approved']) * parseInt(data[i]['price']);
					var no = i + 1;
					var j = i + 2;
					
							harga_rupiah = data[i]['price'];
							var	number_string = harga_rupiah.toString(),
							sisa 	= number_string.length % 3,
							total_harga_rupiah = number_string.substr(0, sisa),
							ribuan 	= number_string.substr(sisa).match(/\d{3}/g);
								
							if (ribuan) {
								separator = sisa ? '.' : '';
								total_harga_rupiah += separator + ribuan.join('.');
							}
							
							harga_total = total;
							var	number_string = harga_total.toString(),
							sisa 	= number_string.length % 3,
							total_total_harga_rupiah = number_string.substr(0, sisa),
							ribuan 	= number_string.substr(sisa).match(/\d{3}/g);
								
							if (ribuan) {
								separator = sisa ? '.' : '';
								total_total_harga_rupiah += separator + ribuan.join('.');
							}
							
					$("#list_table_io tbody").append("<tr>"+
												"<td><input type='hidden' name='id_product[]' value='"+data[i]['id_product']+"' >"+no+"</td>"+
												"<td>"+data[i]['product_name']+"</td>"+
												"<td><input type='hidden' name='qty[]' value='"+data[i]['qty_approved']+"' >"+data[i]['qty_approved']+"</td>"+
												"<td><input type='hidden' name='price[]' value='"+data[i]['price']+"' >"+total_harga_rupiah+"</td>"+
												"<td><input type='hidden' name='product_code[]' value='"+data[i]['product_code']+"' ><input type='hidden' name='product_name[]' value='"+data[i]['product_name']+"' ><input type='hidden' name='price_total[]' value='"+total+"' >"+total_total_harga_rupiah+"</td>"+
												"</tr>");
												
			  }
			  
			 
			}
</script>



<script>
        $( "#search_manifest_id" ).autocomplete({
         source: "<?php echo BASE_URL(); ?>/index.php/json/jsonManifestPi",  
         minLength:0,
		 select: function( event , ui ) {
			  $( "#manifest_id" ).val( ui.item.id_manifest );
			  var id_manifest = ui.item.id_manifest;
			  ajaxTms(id_manifest);
			  ajaxTmsAdditionalCost(id_manifest)
        }    
        })
		.autocomplete( "instance" )._renderItem = function( ul, item ) {
		  return $( "<li style='position:relative; z-index:9999;'>" )
			.append( "<div style='font-size:10px;'>" + item.label+"</div>" )
			.appendTo( ul );
		};
		
			
			function ajaxTms(id_manifest)
			{
				 $.ajax({
				  url: '<?php echo BASE_URL(); ?>/index.php/json/jsonDetailManifestPi?id_manifest='+id_manifest,
				  success: function(data,status)
				  {
					$("#list_table_tms tbody tr").remove();
					
					createTableTms(data,id_manifest);
					
				  },
				  async:   true,
				  dataType: 'json'
				}); 
			}
		
			function createTableTms(data,id_po)
			{
			  for(var i=0; i<data.length;i++)
			  {
					var invoice_method = $("#invoice_method").val();
					rate = 0;
					if(invoice_method=='sales')
					{rate = data[i]['client_rate'];}
					else if(invoice_method=='purchase')
					{rate = data[i]['rate'];}
					
					
					
					var no = i + 1;
					var j = i + 2;
							
							rate_rupiah = rate;
							var	number_string = rate_rupiah.toString(),
							sisa 	= number_string.length % 3,
							total_rate_rupiah = number_string.substr(0, sisa),
							ribuan 	= number_string.substr(sisa).match(/\d{3}/g);
								
							if (ribuan) {
								separator = sisa ? '.' : '';
								total_rate_rupiah += separator + ribuan.join('.');
							}
							
							
							
					$("#list_table_tms tbody").append("<tr>"+
													 "<td>"+no+"</th>"+
													 "<td>"+data[i]['id_manifest']+"</td>"+
													 "<td>"+data[i]['client_id']+"</td>"+
													 "<td>"+data[i]['client_name']+"</td>"+
													 "<td>"+data[i]['origin_id']+"-"+data[i]['origin_address']+"-"+data[i]['origin_area']+"</td>"+
													 "<td>"+data[i]['destination_id']+"-"+data[i]['destination_address']+"-"+data[i]['destination_area']+"</td>"+
													 "<td>"+total_rate_rupiah+"</td>"+
													 "</tr>");
												
			  }
			  
			 
			}
			
			
			
			
			function ajaxTmsAdditionalCost(id_manifest)
			{
				
				 $.ajax({
				  url: '<?php echo BASE_URL(); ?>/index.php/json/jsonAdditionalCostManifestPi?id_manifest='+id_manifest,
				  success: function(data,status)
				  {
					$("#list_table_tms_additional_cost tbody tr").remove();
					createTableTmsAdditionalCost(data,id_manifest);
					
				  },
				  async:   true,
				  dataType: 'json'
				}); 
			}
		
			function createTableTmsAdditionalCost(data,id_po)
			{
			  for(var i=0; i<data.length;i++)
			  {
					
					var no = i + 1;
					var j = i + 2;
							rate_rupiah = data[i]['amount'];
							var	number_string = rate_rupiah.toString(),
							sisa 	= number_string.length % 3,
							total_rate_rupiah = number_string.substr(0, sisa),
							ribuan 	= number_string.substr(sisa).match(/\d{3}/g);
								
							if (ribuan) {
								separator = sisa ? '.' : '';
								total_rate_rupiah += separator + ribuan.join('.');
							}
							
							
							
					$("#list_table_tms_additional_cost tbody").append("<tr>"+
													  "<td>"+no+"</td>"+
													  "<td>"+data[i]['manifest']+"</td>"+
													  "<td>"+data[i]['additional_type']+"</td>"+
													  "<td>"+total_rate_rupiah+"</td>"+
													  "</tr>");
												
			  }
			  
			 
			}
</script>







<script>
        $( "#edit_search_manifest_id" ).autocomplete({
         source: "<?php echo BASE_URL(); ?>/index.php/json/jsonManifestPi",  
         minLength:0,
		 select: function( event , ui ) {
			  $( "#manifest_id" ).val( ui.item.id_manifest );
			  var id_manifest = ui.item.id_manifest;
			  editAjaxTms(id_manifest);
			  editAjaxTmsAdditionalCost(id_manifest)
        }    
        })
		.autocomplete( "instance" )._renderItem = function( ul, item ) {
		  return $( "<li style='position:relative; z-index:9999;'>" )
			.append( "<div style='font-size:10px;'>" + item.label+"</div>" )
			.appendTo( ul );
		};
		
			
			function editAjaxTms(id_manifest)
			{
				 $.ajax({
				  url: '<?php echo BASE_URL(); ?>/index.php/json/jsonDetailManifestPi?id_manifest='+id_manifest,
				  success: function(data,status)
				  {
					$("#edit_list_table_tms tbody tr").remove();
					
					editCreateTableTms(data,id_manifest);
					
				  },
				  async:   true,
				  dataType: 'json'
				}); 
			}
		
			function editCreateTableTms(data,id_po)
			{
			  for(var i=0; i<data.length;i++)
			  {
					
					var no = i + 1;
					var j = i + 2;
							
							rate_rupiah = data[i]['rate'];
							var	number_string = rate_rupiah.toString(),
							sisa 	= number_string.length % 3,
							total_rate_rupiah = number_string.substr(0, sisa),
							ribuan 	= number_string.substr(sisa).match(/\d{3}/g);
								
							if (ribuan) {
								separator = sisa ? '.' : '';
								total_rate_rupiah += separator + ribuan.join('.');
							}
							
							
							
					$("#edit_list_table_tms tbody").append("<tr>"+
													 "<td>"+no+"</th>"+
													 "<td>"+data[i]['id_manifest']+"</td>"+
													 "<td>"+data[i]['client_id']+"</td>"+
													 "<td>"+data[i]['client_name']+"</td>"+
													 "<td>"+data[i]['origin_id']+"-"+data[i]['origin_address']+"-"+data[i]['origin_area']+"</td>"+
													 "<td>"+data[i]['destination_id']+"-"+data[i]['destination_address']+"-"+data[i]['destination_area']+"</td>"+
													 "<td>"+total_rate_rupiah+"</td>"+
													 "</tr>");
												
			  }
			  
			 
			}
			
			
			
			
			function editAjaxTmsAdditionalCost(id_manifest)
			{
				
				 $.ajax({
				  url: '<?php echo BASE_URL(); ?>/index.php/json/jsonAdditionalCostManifestPi?id_manifest='+id_manifest,
				  success: function(data,status)
				  {
					$("#edit_list_table_tms_additional_cost tbody tr").remove();
					editCreateTableTmsAdditionalCost(data,id_manifest);
					
				  },
				  async:   true,
				  dataType: 'json'
				}); 
			}
		
			function editCreateTableTmsAdditionalCost(data,id_po)
			{
			  for(var i=0; i<data.length;i++)
			  {
					
					var no = i + 1;
					var j = i + 2;
							rate_rupiah = data[i]['amount'];
							var	number_string = rate_rupiah.toString(),
							sisa 	= number_string.length % 3,
							total_rate_rupiah = number_string.substr(0, sisa),
							ribuan 	= number_string.substr(sisa).match(/\d{3}/g);
								
							if (ribuan) {
								separator = sisa ? '.' : '';
								total_rate_rupiah += separator + ribuan.join('.');
							}
							
							
							
					$("#edit_list_table_tms_additional_cost tbody").append("<tr>"+
													  "<td>"+no+"</td>"+
													  "<td>"+data[i]['manifest']+"</td>"+
													  "<td>"+data[i]['additional_type']+"</td>"+
													  "<td>"+total_rate_rupiah+"</td>"+
													  "</tr>");
												
			  }
			  
			 
			}
</script>





<script>
        $( "#edit_search_io_id" ).autocomplete({
         source: "<?php echo BASE_URL(); ?>/index.php/json/jsonIo",  
         minLength:0,
		 select: function( event , ui ) {
			  $( "#edit_io_id" ).val( ui.item.id_io );
			  var id_io = ui.item.id_io;
			  
			   $.ajax({
				  url: '<?php echo BASE_URL(); ?>/index.php/json/jsonProductIoInvoice?id_io='+id_io,
				  success: function(data,status)
				  {
					$("#edit_list_table_io tbody tr").remove();  
					editCreateTableProductIo(data,id_io);
				  },
				  async:   true,
				  dataType: 'json'
				}); 
        }    
        })
		.autocomplete( "instance" )._renderItem = function( ul, item ) {
		  return $( "<li style='position:relative; z-index:9999;'>" )
			.append( "<div style='font-size:10px;'>" + item.label+"</div>" )
			.appendTo( ul );
		};
		
		
			function editCreateTableProductIo(data,id_po)
			{
			  for(var i=0; i<data.length;i++)
			  {
					var total = parseInt(data[i]['qty_approved']) * parseInt(data[i]['price']);
					var no = i + 1;
					var j = i + 2;
					
							harga_rupiah = data[i]['price'];
							var	number_string = harga_rupiah.toString(),
							sisa 	= number_string.length % 3,
							total_harga_rupiah = number_string.substr(0, sisa),
							ribuan 	= number_string.substr(sisa).match(/\d{3}/g);
								
							if (ribuan) {
								separator = sisa ? '.' : '';
								total_harga_rupiah += separator + ribuan.join('.');
							}
							
							harga_total = total;
							var	number_string = harga_total.toString(),
							sisa 	= number_string.length % 3,
							total_total_harga_rupiah = number_string.substr(0, sisa),
							ribuan 	= number_string.substr(sisa).match(/\d{3}/g);
								
							if (ribuan) {
								separator = sisa ? '.' : '';
								total_total_harga_rupiah += separator + ribuan.join('.');
							}
							
					$("#edit_list_table_io tbody").append("<tr>"+
												"<td><input type='hidden' name='id_product[]' value='"+data[i]['id_product']+"' >"+no+"</td>"+
												"<td>"+data[i]['product_name']+"</td>"+
												"<td><input type='hidden' name='qty[]' value='"+data[i]['qty_approved']+"' >"+data[i]['qty_approved']+"</td>"+
												"<td><input type='hidden' name='price[]' value='"+data[i]['price']+"' >"+total_harga_rupiah+"</td>"+
												"<td><input type='hidden' name='product_code[]' value='"+data[i]['product_code']+"' ><input type='hidden' name='product_name[]' value='"+data[i]['product_name']+"' ><input type='hidden' name='price_total[]' value='"+total+"' >"+total_total_harga_rupiah+"</td>"+
												"</tr>");
												
			  }
			  
			 
			}
</script>


<script>
        $( "#edit_search_po_id" ).autocomplete({
         source: "<?php echo BASE_URL(); ?>/index.php/json/jsonPoPi",  
         minLength:0,
		 select: function( event , ui ) {
			  $( "#edit_po_id" ).val( ui.item.id_po );
			  var id_po = ui.item.id_po;
			  
			   $.ajax({
				  url: '<?php echo BASE_URL(); ?>/index.php/json/jsonProductPoGr?id_po='+id_po,
				  success: function(data,status)
				  {
					$("#edit_list_table_po tbody tr").remove();  
					editCreateTableProductPO(data,id_po);
				  },
				  async:   true,
				  dataType: 'json'
				}); 
        }    
        })
		.autocomplete( "instance" )._renderItem = function( ul, item ) {
		  return $( "<li style='position:relative; z-index:9999;'>" )
			.append( "<div style='font-size:10px;'>" + item.label+"</div>" )
			.appendTo( ul );
		};
		
		
			function editCreateTableProductPO(data,id_po)
			{
			  for(var i=0; i<data.length;i++)
			  {
					var total = parseInt(data[i]['qty_approve']) * parseInt(data[i]['price']);
					var no = i + 1;
					var j = i + 2;
					
							harga_rupiah = data[i]['price'];
							var	number_string = harga_rupiah.toString(),
							sisa 	= number_string.length % 3,
							total_harga_rupiah = number_string.substr(0, sisa),
							ribuan 	= number_string.substr(sisa).match(/\d{3}/g);
								
							if (ribuan) {
								separator = sisa ? '.' : '';
								total_harga_rupiah += separator + ribuan.join('.');
							}
							
							harga_total = total;
							var	number_string = harga_total.toString(),
							sisa 	= number_string.length % 3,
							total_total_harga_rupiah = number_string.substr(0, sisa),
							ribuan 	= number_string.substr(sisa).match(/\d{3}/g);
								
							if (ribuan) {
								separator = sisa ? '.' : '';
								total_total_harga_rupiah += separator + ribuan.join('.');
							}
							
					$("#edit_list_table_po tbody").append("<tr>"+
												"<td><input type='hidden' name='id_product[]' value='"+data[i]['id_product']+"' >"+no+"</td>"+
												"<td>"+data[i]['product_name']+"</td>"+
												"<td><input type='hidden' name='qty[]' value='"+data[i]['qty_approve']+"' >"+data[i]['qty_approve']+"</td>"+
												"<td><input type='hidden' name='price[]' value='"+data[i]['price']+"' >"+total_harga_rupiah+"</td>"+
												"<td><input type='hidden' name='product_code[]' value='"+data[i]['product_code']+"' ><input type='hidden' name='product_name[]' value='"+data[i]['product_name']+"' ><input type='hidden' name='price_total[]' value='"+total+"' >"+total_total_harga_rupiah+"</td>"+
												"</tr>");
												
			  }
			  
			 
			}
</script>

<script>
$( "#payment_method" ).change(function() {
		payment_method = $(this).val();
		$('.payment_method').hide();
		$('.'+payment_method).show();
		$("#account option[value='']").prop('selected',true);
		
});

$( "#charge_payment_method" ).change(function() {
		payment_method = $(this).val();
		$('.payment_method').hide();
		$('.'+payment_method).show();
		$("#charge_account option[value='']").prop('selected',true);
});
</script>