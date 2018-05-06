 <!-- HEADER -->
 <section class="content-header">
          <h1>
            Dispatch Order
            <small>List Of Dispatch Order</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="<?php echo BASE_URL(); ?>"><i class="fa fa-dashboard"></i>Home</a></li>
            <li><a href="<?php echo BASE_URL()."transport_order"; ?>"><i class="fa fa-dashboard"></i>Dispatch Order</a></li>
          </ol>
        </section>
  
  
   <!-- Content -->
   <section class="content">
		
		
  
  
          <div class="box sms box-default color-palette-box">
            <div class="box-header with-border">
              <h3 class="box-title"><i class="fa fa-table"></i> Table Dispatch Order</h3>
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
                <div id="wrapper-button" class="clearfix">
					                	
					                                        <a id="add-data" class="button blue-button">
                    	<span class="glyphicon glyphicon-plus"></span> Add
                    </a>
										                    <a id="delete-data" class="button btn-danger deletelogg">
                    	<span class="glyphicon glyphicon-trash"></span> Delete
                    </a>
										
					<a href="http://stms.goodevamedia.com/index.php/transport_order/exportTransportOrder?search=" class="button green-button">
                    	<span class="glyphicon glyphicon-upload"></span> Export
                    </a><div id="wrapper-search">
                             <form action="http://stms.goodevamedia.com/index.php/transport_order" method="get">
                             <input type="hidden" name="xcdsdh" value="1262037a46740530c41b92d23d0a87fa">
                                <input type="text" id="search" name="search" placeholder="Search..." value="">
                                <input type="submit" id="submit" value="Search">
                                                             </form>
                </div><!--                    <a id="import-data" class="button blue-button">
                    	Import Dispatch Order
                    </a>
					-->
					
                </div>
                </div>
            <div id="wrapper-console" class="clearfix"> 
            <div class="grid_4 height400">                  
           	<table id="myTable04" class="fancyDarkTable table table-bordered table-hover">
                    <thead>
                      <tr>
                        <th>
						<div class="long">
						<div class="check-box-div"><input type="checkbox" name="select_all" id="select_all"></div>SPK Number
						</div>
						</th>
                        <th>Reference</th>
						<th>DO Number</th>
						<th>Order Type</th>
                        <th>Delivery Date</th>
						<th>Posting Date</th>
						<th>Origin ID</th>
						<th>Origin Area</th>
						<th>Origin Address</th>
						<th>Destination ID</th>
						<th>Destination Area</th>
						<th>Destination Address</th>
						<th>Status</th>
						
						<?php if($data_role[0]['delete_transport_order']=='yes' || $data_role[0]['edit_transport_order']=='yes'){ ?>
						<th>Action</th>
						<?php } ?>
                      </tr>
                    </thead>
             		<tbody>
                    <?php foreach($data_transport_order as $data_transport_order) {?>
                    <tr id="data_<?php echo $data_transport_order->spk_number; ?>">
                    	<td class="spk_number">
						<?php if($data_transport_order->manifest=='0'){ ?>
						<div class="check-box-div">
						<!--<input type="checkbox" name="id_checkbox[]" class="iCheck-helper toedit checkbox_satuan" value="<?php echo $data_transport_order->spk_number; ?>" />-->
						</div>
						<?php } ?>
						<span class='spk_number'"><?php echo $data_transport_order->spk_number; ?></span>
						<span class='remark' style='display:none;'><?php echo $data_transport_order->remark; ?></span>
						<span class='si' style='display:none;'><?php echo $data_transport_order->si; ?></span>
						<span class='hawb' style='display:none;'><?php echo $data_transport_order->hawb; ?></span>
						<span class='mawb' style='display:none;'><?php echo $data_transport_order->mawb; ?></span>
						<span class='notes' style='display:none;'><?php echo $data_transport_order->notes; ?></span>
						<span class='manifest' style='display:none;'><?php echo $data_transport_order->manifest; ?></span>
						<span class='client_id' style='display:none;'><?php echo $data_transport_order->client_id; ?></span>
						<span class='client_name' style='display:none;'><?php echo $data_transport_order->client_name; ?></span>
						<span class='document_date' style='display:none;'><?php convert_date($data_transport_order->document_date); ?></span>
						<span class='document_time' style='display:none;'><?php echo $data_transport_order->document_time; ?></span>
						<span class='delivery_time' style='display:none;'><?php echo $data_transport_order->delivery_time; ?></span>
						<span class='posting_date' style='display:none;'><?php convert_date($data_transport_order->posting_date); ?></span>
						<span class='qty' style='display:none;'><?php echo $data_transport_order->qty; ?></span>
						<span class='volume' style='display:none;'><?php echo $data_transport_order->volume; ?></span>
						<span class='weight' style='display:none;'><?php echo $data_transport_order->weight; ?></span>
						
						<span class='cargo_type' style='display:none;'><?php echo $data_transport_order->cargo_type; ?></span>
						<span class='id_detail_trucking_order' style='display:none;'><?php echo $data_transport_order->id_detail_trucking_order; ?></span>
						<span class='id_trucking_order' style='display:none;'><?php echo $data_transport_order->id_trucking_order; ?></span>
						</td>
                        <td class="reference"><?php echo $data_transport_order->reference; ?></td>
						<td class="do_number"><?php echo $data_transport_order->do_number; ?></td>
						<td class="order_type"><?php echo $data_transport_order->order_type; ?></td>
                        <td class="delivery_date"><?php convert_date($data_transport_order->delivery_date); ?></td>
						<td class="posting_date"><?php convert_date($data_transport_order->posting_date); ?></td>
						<td class="origin_id"><?php echo $data_transport_order->origin_id; ?></td>
						<td class="origin_area"><?php echo $data_transport_order->origin_area; ?></td>
						<td class="origin_address"><?php echo $data_transport_order->origin_address; ?></td>
						<td class="destination_id"><?php echo $data_transport_order->destination_id; ?></td>
						<td class="destination_address"><?php echo $data_transport_order->destination_address; ?></td>
						<td class="destination_area"><?php echo $data_transport_order->destination_area; ?></td>
						<td class="status"><?php echo $data_transport_order->status; ?></td>
						<?php if($data_role[0]['delete_transport_order']=='yes' || $data_role[0]['edit_transport_order']=='yes'){ ?>
						<td><?php if($data_transport_order->manifest=='0'){ ?>
						<?php if($data_role[0]['delete_transport_order']=='yes'){ ?><a  class="delete_data link_action" id="<?php echo $data_transport_order->spk_number; ?>" >Delete</a>
						<?php } ?><?php } ?> | <?php if($data_role[0]['edit_transport_order']=='yes'){ ?>
						<a  id="<?php echo $data_transport_order->spk_number; ?>" class="edit_data link_action">Edit</a>
						<?php } ?></td>
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
		<h2 id="modal1Title">Add Dispatch Order</h2>
				<form role="form" id="form_add_data" method="POST" action="<?php echo base_url()."index.php/transport_order/addTransportOrder" ?>" enctype="multipart/form-data">
				 <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
				 
              <div class="box-body">

				<div class="left-form clearfix">
				
					<div class="form-group">
					  <label for="drivercode2">Reference</label>
					 <input type="text" class="form-control" name="reference" id="reference" required>
					</div>
					
					<div class="form-group">
					  <label for="drivercode2">DO Number</label>
					 <input type="text" class="form-control" name="do_number" id="do_number" required>
					</div>
					
					<div class="form-group">
						  <label for="drivercode2">Delivery Date </label>
						  <div class="input-group date">
						  <div class="input-group-addon">
							<i class="fa fa-calendar"></i>
						  </div>
						  <input type="text" name="delivery_date" id="delivery_date" class="form-control pull-right datepicker"   placeholder='Delivery Date' required>
						 </div>
					</div>
					
					<div class="bootstrap-timepicker">
					<div class="form-group">
					  <label>Delivery Time</label>

					  <div class="input-group">
						<input type="text"  name="delivery_time" id="delivery_time" class="form-control timepicker" placeholder='Delivery Time' required>

						<div class="input-group-addon">
						  <i class="fa fa-clock-o"></i>
						</div>
					  </div>
					  <!-- /.input group -->
					</div>
					<!-- /.form group -->
				  </div>
					
					
					<div class="form-group">
					 <label>Origin</label>
						<div class="input-group">
						  <div class="input-group-addon">
							<i class="fa fa-search"></i>
						  </div>
						  <input type="text" class="form-control pull-right" name="search_origin_id" id="search_origin_id" value='' placeholder='Search origin ID'>
						  <input type="text" readonly class="form-control" name="origin_id" id="origin_id" placeholder='Origin ID' required>
						  <input type="text" readonly class="form-control" name="origin_address" id="origin_address" placeholder='Origin Address 1' required>
						  <input type="text" readonly class="form-control" name="origin_area" id="origin_area" placeholder='Origin Area' required>
					</div>
						<!-- /.input group -->
					</div>
					
					
					<div class="form-group">
					 <label>Destination</label>
						<div class="input-group">
						  <div class="input-group-addon">
							<i class="fa fa-search"></i>
						  </div>
						  <input type="text" class="form-control pull-right" name="search_destination" id="search_destination" value='' placeholder='Search Destination'>
						  <input type="text" readonly class="form-control" name="destination_id" id="destination_id" placeholder='Destination ID' required>
						  <input type="text" readonly class="form-control" name="destination_address" id="destination_address" placeholder='Destination Address 1' required>
						  <input type="text" readonly class="form-control" name="destination_area" id="destination_area" placeholder='Destination Area' required>
					</div>
						<!-- /.input group -->
					</div>
					
					
				</div>
				
				
				<div class="right-form clearfix">
						
					<div class="form-group">
					 <label>Client</label>
						<div class="input-group">
						  <div class="input-group-addon">
							<i class="fa fa-search"></i>
						  </div>
						  <input type="text" class="form-control pull-right" name="search_client_id" id="search_client_id" value='' placeholder='Search Destination'>
						  <input type="text" readonly class="form-control" name="client_id" id="client_id" placeholder='Client ID' required>
						  <input type="text" readonly class="form-control" name="client_name" id="client_name" placeholder='Client Name' required>
					</div>
						<!-- /.input group -->
					</div>
					
					
					<div class="form-group">
						  <label for="drivercode2">Document Date </label>
						  <div class="input-group date">
						  <div class="input-group-addon">
							<i class="fa fa-calendar"></i>
						  </div>
						  <input type="text" name="document_date" id="document_date" class="form-control pull-right datepicker"   placeholder='Document Date' required>
						 </div>
					</div>
					
					<div class="bootstrap-timepicker">
					<div class="form-group">
					  <label>Document Time</label>

					  <div class="input-group">
						<input type="text"  name="document_time" id="document_time" class="form-control timepicker" placeholder='Document Time' required>

						<div class="input-group-addon">
						  <i class="fa fa-clock-o"></i>
						</div>
					  </div>
					  <!-- /.input group -->
					</div>
					<!-- /.form group -->
				  </div>
				
				 <div class="form-group">
						  <label for="drivercode2">Posting Date </label>
						  <div class="input-group date">
						  <div class="input-group-addon">
							<i class="fa fa-calendar"></i>
						  </div>
						  <input type="text" name="posting_date" id="posting_date" class="form-control pull-right datepicker"   placeholder='Posting Date' required>
						 </div>
				</div>
				
				
				<div class="form-group">
					 <label>Order Type</label>
						<div class="input-group">
						  <div class="input-group-addon">
							<i class="fa fa-search"></i>
						  </div>
						  <input type="text" class="form-control pull-right" name="search_order_type" id="search_order_type" value='' placeholder='Search Order Type'>
						  <input type="text" readonly class="form-control" name="order_type" id="order_type" placeholder='Order Type' required>
					</div>
						<!-- /.input group -->
					</div>
					
					
					<div class="form-group">
					  <label for="drivercode2">Status</label>
					 <input type="text" readonly='readonly' class="form-control" name="status" id="status">
					</div>
					
					<div class="form-group">
					  <label for="drivercode2">Remark</label>
					 <textarea class="form-control" name="remark" id="remark"></textarea>
					</div>
					
					
				</div>
               
			   <div class="clearfix"></div>
			   
			   
			   <div id="tabs">
				  <ul>
					<li><a href="#tabs-1">Qty & Volume</a></li>
					<li><a href="#tabs-2">Document</a></li>
					<li><a href="#tabs-3">Notes</a></li>
				  </ul>
				   <div id="tabs-1">
						
						<div class="form-group">
						  <label for="transport_ordercode">Qty</label>
						  <input type="text" class="form-control" name="qty" id="qty">
						</div>
						
						<div class="form-group">
						  <label for="transport_ordercode">Volume</label>
						  <input type="text" class="form-control" name="volume" id="volume">
						</div>
						
						<div class="form-group">
						  <label for="transport_ordercode">Weight</label>
						  <input type="text" class="form-control" name="weight" id="weight">
						</div>
					
				  </div>
				  <div id="tabs-2">
						
						<div class="form-group">
						  <label for="transport_ordercode">SI</label>
						  <input type="text" class="form-control" name="si" id="si">
						</div>
						
						<div class="form-group">
						  <label for="transport_ordercode">HAWB</label>
						  <input type="text" class="form-control" name="hawb" id="hawb">
						</div>
						
						<div class="form-group">
						  <label for="transport_ordercode">MAWB</label>
						  <input type="text" class="form-control" name="mawb" id="mawb">
						</div>
					
				  </div>
				  <div id="tabs-3">
						<div class="form-group">
						  <label for="transport_ordercode">Notes</label>
						  <textarea class="form-control" name="notes" id="notes"></textarea>
						</div>	
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
		<h2 id="modal1Title">Edit Dispatch Order</h2>
				<form role="form" id="form_edit_data" method="POST" action="<?php echo base_url()."index.php/transport_order/editTransportOrder" ?>" enctype="multipart/form-data">
				 <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
				 
               <div class="box-body">

				<div class="left-form clearfix">
					
					
					<div class="form-group">
					 <label>Search Job Number</label>
						<div class="input-group">
						  <div class="input-group-addon">
							<i class="fa fa-search"></i>
						  </div>
						  <input type="text" class="form-control pull-right" name="edit_search_job_number" id="edit_search_job_number" value='' placeholder='Search Job Number'>
						  <input type="text" readonly class="form-control" name="edit_job_number" id="edit_job_number" placeholder='Job Number' required>
						  <input type="hidden" readonly class="form-control" name="edit_id_detail_trucking_order" id="edit_id_detail_trucking_order" required>
						  <input type="hidden" readonly class="form-control" name="edit_id_detail_trucking_order_lama" id="edit_id_detail_trucking_order_lama" required>
					</div>
						<!-- /.input group -->
					</div>
					
					<div class="form-group">
					  <label for="drivercode2">Reference</label>
					 <input type="text" class="form-control" name="edit_reference" id="edit_reference" required>
					 <input type='hidden' name='id_transport_order_update' id='id_transport_order_update' value=''>
					</div>
					
					<div class="form-group">
					  <label for="drivercode2">DO Number</label>
					 <input type="text" class="form-control" name="edit_do_number" id="edit_do_number" required>
					</div>
					
					<div class="form-group">
						  <label for="drivercode2">Delivery Date </label>
						  <div class="input-group date">
						  <div class="input-group-addon">
							<i class="fa fa-calendar"></i>
						  </div>
						  <input type="text" name="edit_delivery_date" id="edit_delivery_date" class="form-control pull-right datepicker"   placeholder='Delivery Date' required>
						 </div>
					</div>
					
					<div class="bootstrap-timepicker">
					<div class="form-group">
					  <label>Delivery Time</label>

					  <div class="input-group">
						<input type="text"  name="edit_delivery_time" id="edit_delivery_time" class="form-control timepicker" placeholder='Delivery Time' required>

						<div class="input-group-addon">
						  <i class="fa fa-clock-o"></i>
						</div>
					  </div>
					  <!-- /.input group -->
					</div>
					<!-- /.form group -->
				  </div>
					
					
					<div class="form-group">
					 <label>Origin</label>
						<div class="input-group">
						  <div class="input-group-addon">
							<i class="fa fa-search"></i>
						  </div>
						  <input type="text" class="form-control pull-right" name="edit_search_origin_id" id="edit_search_origin_id" value='' placeholder='Search origin ID'>
						  <input type="text" readonly class="form-control" name="edit_origin_id" id="edit_origin_id" placeholder='Origin ID' required>
						  <input type="text" readonly class="form-control" name="edit_origin_address" id="edit_origin_address" placeholder='Origin Address 1' required>
						  <input type="text" readonly class="form-control" name="edit_origin_area" id="edit_origin_area" placeholder='Origin Area' required>
					</div>
						<!-- /.input group -->
					</div>
					
					
					<div class="form-group">
					 <label>Destination</label>
						<div class="input-group">
						  <div class="input-group-addon">
							<i class="fa fa-search"></i>
						  </div>
						  <input type="text" class="form-control pull-right" name="edit_search_destination" id="edit_search_destination" value='' placeholder='Search Destination'>
						  <input type="text" readonly class="form-control" name="edit_destination_id" id="edit_destination_id" placeholder='Destination ID' required>
						  <input type="text" readonly class="form-control" name="edit_destination_address" id="edit_destination_address" placeholder='Destination Address 1' required>
						  <input type="text" readonly class="form-control" name="edit_destination_area" id="edit_destination_area" placeholder='Destination Area' required>
					</div>
						<!-- /.input group -->
					</div>
					
					
				</div>
				
				
				<div class="right-form clearfix">
						
					<div class="form-group">
					 <label>Client</label>
						<div class="input-group">
						  <div class="input-group-addon">
							<i class="fa fa-search"></i>
						  </div>
						  <input type="text" class="form-control pull-right" name="edit_search_client_id" id="edit_search_client_id" value='' placeholder='Search Destination'>
						  <input type="text" readonly class="form-control" name="edit_client_id" id="edit_client_id" placeholder='Client ID' required>
						  <input type="text" readonly class="form-control" name="edit_client_name" id="edit_client_name" placeholder='Client Name' required>
					</div>
						<!-- /.input group -->
					</div>
					
					
					<div class="form-group">
						  <label for="drivercode2">Document Date </label>
						  <div class="input-group date">
						  <div class="input-group-addon">
							<i class="fa fa-calendar"></i>
						  </div>
						  <input type="text" name="edit_document_date" id="edit_document_date" class="form-control pull-right datepicker"   placeholder='Document Date' required>
						 </div>
					</div>
					
					<div class="bootstrap-timepicker">
					<div class="form-group">
					  <label>Document Time</label>

					  <div class="input-group">
						<input type="text"  name="edit_document_time" id="edit_document_time" class="form-control timepicker" placeholder='Document Time' required>

						<div class="input-group-addon">
						  <i class="fa fa-clock-o"></i>
						</div>
					  </div>
					  <!-- /.input group -->
					</div>
					<!-- /.form group -->
				  </div>
				
				 <div class="form-group">
						  <label for="drivercode2">Posting Date </label>
						  <div class="input-group date">
						  <div class="input-group-addon">
							<i class="fa fa-calendar"></i>
						  </div>
						  <input type="text" name="edit_posting_date" id="edit_posting_date" class="form-control pull-right datepicker"   placeholder='Posting Date' required>
						 </div>
				</div>
				
				
				<div class="form-group">
					 <label>Order Type</label>
						<div class="input-group">
						  <div class="input-group-addon">
							<i class="fa fa-search"></i>
						  </div>
						  <input type="text" class="form-control pull-right" name="edit_search_order_type" id="edit_search_order_type" value='' placeholder='Search Order Type'>
						  <input type="text" readonly class="form-control" name="edit_order_type" id="edit_order_type" placeholder='Order Type' required>
					</div>
						<!-- /.input group -->
					</div>
					
					
					<div class="form-group">
					  <label for="drivercode2">Status</label>
					 <input type="text" readonly='readonly' class="form-control" name="edit_status" id="edit_status">
					</div>
					
					<div class="form-group">
					  <label for="drivercode2">Remark</label>
					 <textarea class="form-control" name="edit_remark" id="edit_remark"></textarea>
					</div>
					
					
				</div>
               
			   <div class="clearfix"></div>
			   
			   
			   <div id="edit_tabs">
				  <ul>
					<li><a href="#tabs-1">Qty & Volume</a></li>
					<li><a href="#tabs-2">Document</a></li>
					<li><a href="#tabs-3">Notes</a></li>
				  </ul>
				  <div id="tabs-1">
						
						<div class="form-group">
						  <label for="transport_ordercode">Qty</label>
						  <input type="text" class="form-control" name="edit_qty" id="edit_qty">
						</div>
						
						<div class="form-group">
						  <label for="transport_ordercode">Volume</label>
						  <input type="text" class="form-control" name="edit_volume" id="edit_volume">
						</div>
						
						<div class="form-group">
						  <label for="transport_ordercode">Weight</label>
						  <input type="text" class="form-control" name="edit_weight" id="edit_weight">
						</div>
						
						
						 <div class="form-group">
						  <label for="drivercode2">Cargo Type</label>
						  <select class="form-control" name="edit_cargo_type" id="edit_cargo_type" required>
							<option selected="selected" value="">Choose Cargo type</option>
							<?php 
							$data_cargo_type = $this->db->query("SELECT * FROM master_data_category WHERE  category = 'Cargo Type' ")->result();
							foreach($data_cargo_type as $data_cargo_type)
							{
							?>
								<option value="<?php echo $data_cargo_type->description; ?>"><?php echo $data_cargo_type->description; ?></option>
							<?php
							}							
							?>
							
							
						  </select> 
					</div>
					
				  </div>
				  <div id="tabs-2">
						
						<div class="form-group">
						  <label for="transport_ordercode">SI</label>
						  <input type="text" class="form-control" name="edit_si" id="edit_si">
						</div>
						
						<div class="form-group">
						  <label for="transport_ordercode">HAWB</label>
						  <input type="text" class="form-control" name="edit_hawb" id="edit_hawb">
						</div>
						
						<div class="form-group">
						  <label for="transport_ordercode">MAWB</label>
						  <input type="text" class="form-control" name="edit_mawb" id="edit_mawb">
						</div>
					
				  </div>
				  <div id="tabs-3">
						<div class="form-group">
						  <label for="transport_ordercode">Notes</label>
						  <textarea class="form-control" name="edit_notes" id="edit_notes"></textarea>
						</div>	
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
	
	
	
	<div class="remodal" data-remodal-id="modal_import" role="dialog" aria-labelledby="modal1Titl aria-describedby="modal1Desc">
	  <button data-remodal-action="close" class="remodal-close" aria-label="Close"></button>
	  <div>
		<h2 id="modal1Title">Import Dispatch Order</h2>
				<form role="form" id="form_import_data" method="POST" action="<?php echo base_url()."index.php/transport_order/importDispatch Order" ?>" enctype="multipart/form-data">
				 <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
				 
              <div class="box-body">

				 <div class="form-group">
                      <label for="exampleInputEmail1">Choose File</label>
                      <input type="file" name="import_file" id="import_file" class="form-control" value="" />
				</div>
				
				 <div class="form-group">
                    <p><a target="_blank" href="<?php echo base_url('/files/example-files/import-transport_order.xlsx')?>">Download sample file import transport_order</a></p>
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
		<h2 id="modal1Title">Delete Dispatch Order</h2>
				<form role="form" id="form_delete_data" method="POST" action="<?php echo base_url()."index.php/transport_order/deleteTransportOrder" ?>" enctype="multipart/form-data">
				 <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
				 
              <div class="box-body">

				 <div class="form-group">
                     <p>Are you sure want to delete this data? (<span id="reference_delete"></span>)</p>
				</div>
				
				 <div class="form-group">
                      <input type="hidden" name="id_transport_order_delete" id="id_transport_order_delete" class="form-control" value="" />
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
		<h2 id="modal1Title">Delete Dispatch Order</h2>
				<form role="form" id="form_selected_delete_data" method="POST" action="<?php echo base_url()."index.php/transport_order/deleteTransportOrderAll" ?>" enctype="multipart/form-data">
				 <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
				 
              <div class="box-body">

				 <div class="form-group">
                     <p>Are you sure want to delete selected data? </p>
				</div>
				
				 <div class="form-group">
                      <input type="hidden" name="id_transport_order_delete_all" id="id_transport_order_delete_all" class="form-control" value="" />
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
			
			
			  //Timepicker
				 $(".timepicker").timepicker({
			  showInputs: false
			});
			
			$(".delete_data").click(function(){
				var id = $(this).attr('id');
				var do_number =  $('#data_'+id+' .do_number').text();
				var spk_number =  $('#data_'+id+' .spk_number span.spk_number').text();
				$("#reference_delete").text("SPK Number : "+spk_number)
				$("#id_transport_order_delete").val(spk_number);
			});
			
			$(".edit_data").click(function(){
				
				var id = $(this).attr('id');
				var spk_number =  $('#data_'+id+' .spk_number span.spk_number').text();
				var remark =  $('#data_'+id+' .spk_number .remark').text();
				var si =  $('#data_'+id+' .spk_number .si').text();
				var hawb =  $('#data_'+id+' .spk_number .hawb').text();
				var mawb =  $('#data_'+id+' .spk_number .mawb').text();
				var notes =  $('#data_'+id+' .spk_number .notes').text();
				var manifest =  $('#data_'+id+' .spk_number .manifest').text();
				var client_id =  $('#data_'+id+' .spk_number .client_id').text();
				var client_name =  $('#data_'+id+' .spk_number .client_name').text();
				var document_date =  $('#data_'+id+' .spk_number .document_date').text();
				var document_time =  $('#data_'+id+' .spk_number .document_time').text();
				var delivery_date =  $('#data_'+id+' .spk_number .delivery_date').text();
				var delivery_time =  $('#data_'+id+' .spk_number .delivery_time').text();
				var posting_date =  $('#data_'+id+' .spk_number .posting_date').text();
				var qty =  $('#data_'+id+' .spk_number .qty').text();
				var volume =  $('#data_'+id+' .spk_number .volume').text();
				var weight =  $('#data_'+id+' .spk_number .weight').text();
				
				var cargo_type =  $('#data_'+id+' .spk_number .cargo_type').text();
				var id_detail_trucking_order =  $('#data_'+id+' .spk_number .id_detail_trucking_order').text();
				var id_trucking_order =  $('#data_'+id+' .spk_number .id_trucking_order').text();
				
					$("#edit_search_origin_id").removeAttr('readonly', 'readonly');
					$("#edit_search_destination").removeAttr('readonly', 'readonly');
					$("#edit_search_order_type").removeAttr('readonly', 'readonly');
					$("#edit_reference").removeAttr('readonly', 'readonly');
					$("#edit_do_number").removeAttr('readonly', 'readonly');
					$("#edit_search_client_id").removeAttr('readonly', 'readonly');
					
				if(manifest!='0')
				{
					$("#edit_search_origin_id").attr('readonly', 'readonly');
					$("#edit_search_destination").attr('readonly', 'readonly');
					$("#edit_search_order_type").attr('readonly', 'readonly');
					$("#edit_reference").attr('readonly', 'readonly');
					$("#edit_do_number").attr('readonly', 'readonly');
					$("#edit_search_client_id").attr('readonly', 'readonly');
				}
				
				var reference =  $('#data_'+id+' .reference').text();
				var do_number =  $('#data_'+id+' .do_number').text();
				var order_type =  $('#data_'+id+' .order_type').text();
				var delivery_date =  $('#data_'+id+' .delivery_date').text();
				var posting_date =  $('#data_'+id+' .posting_date').text();
				var origin_id =  $('#data_'+id+' .origin_id').text();
				var origin_area =  $('#data_'+id+' .origin_area').text();
				var origin_address =  $('#data_'+id+' .origin_address').text();
				var destination_id =  $('#data_'+id+' .destination_id').text();
				var destination_address =  $('#data_'+id+' .destination_address').text();
				var destination_area =  $('#data_'+id+' .destination_area').text();
				
				$("#id_transport_order_update").val(spk_number);
				$("#edit_client_id").val(client_id);
				$("#edit_client_name").val(client_name);
				$("#edit_document_date").val(document_date);
				$("#edit_document_time").val(document_time);
				$("#edit_delivery_date").val(delivery_date);
				$("#edit_delivery_time").val(delivery_time);
				$("#edit_posting_date").val(posting_date);
				$("#edit_qty").val(qty);
				$("#edit_volume").val(volume);
				$("#edit_weight").val(weight);
				
				$("#edit_remark").val(remark);
				$("#edit_si").val(si);
				$("#edit_hawb").val(hawb);
				$("#edit_mawb").val(mawb);
				$("#edit_notes").val(notes);
				$("#edit_manifest").val(manifest);
				
				
				$("#edit_spk_number").val(spk_number);
				$("#edit_reference").val(reference);
				$("#edit_do_number").val(do_number);
				$("#edit_order_type").val(order_type);
				$("#edit_delivery_date").val(delivery_date);
				$("#edit_posting_date").val(posting_date);
				$("#edit_origin_id").val(origin_id);
				$("#edit_origin_area").val(origin_area);
				$("#edit_origin_address").val(origin_address);
				$("#edit_destination_id").val(destination_id);
				$("#edit_destination_address").val(destination_address);
				$("#edit_destination_area").val(destination_area);
				
				$("#edit_id_detail_trucking_order_lama").val(id_detail_trucking_order);
				$("#edit_cargo_type").val(cargo_type);
				
				
				
				
			});

			$("#form_add_data").validate({
				
				messages: {
				do_number: {
				required: 'DO Number must be filled!'
				},
				reference: {
				required: 'Reference must be filled!'
				},
				delivery_date: {
				required: 'Delivery Date must be filled!'
				},
				delivery_time: {
				required: 'Delivery Time must be filled!'
				},
				origin_id: {
				required: 'Origin ID must be filled!'
				},
				origin_address: {
				required: 'Origin Address must be filled!'
				},
				origin_area: {
				required: 'Origin Area must be filled!'
				},
				destination: {
				required: 'Destination ID must be filled!'
				},
				destination_address: {
				required: 'Destination Address must be filled!'
				},
				destination_area: {
				required: 'Destination Area must be filled!'
				},
				client_id: {
				required: 'Client ID must be filled!'
				},
				client_name: {
				required: 'Client Name must be filled!'
				},
				document_date: {
				required: 'Document Date must be filled!'
				},
				document_time: {
				required: 'Document Time must be filled!'
				},
				posting_date: {
				required: 'Posting Date must be filled!'
				},
				order_type: {
				required: 'Order Type must be filled!'
				},
				status: {
				required: 'Status must be filled!'
				}
				
				}
			});
			
			
			
			$("#form_edit_data").validate({
				messages: {
				edit_do_number: {
				required: 'DO Number must be filled!'
				},
				edit_reference: {
				required: 'Reference must be filled!'
				},
				edit_delivery_date: {
				required: 'Delivery Date must be filled!'
				},
				edit_delivery_time: {
				required: 'Delivery Time must be filled!'
				},
				edit_origin_id: {
				required: 'Origin ID must be filled!'
				},
				edit_origin_address: {
				required: 'Origin Address must be filled!'
				},
				edit_origin_area: {
				required: 'Origin Area must be filled!'
				},
				edit_destination: {
				required: 'Destination ID must be filled!'
				},
				edit_destination_address: {
				required: 'Destination Address must be filled!'
				},
				edit_destination_area: {
				required: 'Destination Area must be filled!'
				},
				edit_client_id: {
				required: 'Client ID must be filled!'
				},
				edit_client_name: {
				required: 'Client Name must be filled!'
				},
				edit_document_date: {
				required: 'Document Date must be filled!'
				},
				edit_document_time: {
				required: 'Document Time must be filled!'
				},
				edit_posting_date: {
				required: 'Posting Date must be filled!'
				},
				edit_order_type: {
				required: 'Order Type must be filled!'
				},
				edit_status: {
				required: 'Status must be filled!'
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
 $( "#tabs" ).tabs();
 $( "#edit_tabs" ).tabs();
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
		$("#id_transport_order_delete_all").val(ids);
		
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
		//auto complete Client ID
		var term = $("#search_client_id").val();
        $( "#search_client_id" ).autocomplete({
         source: "<?php echo BASE_URL(); ?>index.php/json/jsonClient", 
         minLength:0,
		 select: function( event , ui ) {
			  $( "#client_id" ).val( ui.item.client_id );
			  $( "#client_name" ).val( ui.item.client_name );
			 
        }    
        })
		.autocomplete( "instance" )._renderItem = function( ul, item ) {
		  return $( "<li style='position:relative; z-index:9999;'>" )
			.append( "<div style='font-size:10px;'>" + item.label+"</div>" )
			.appendTo( ul );
		};
		
		
		//auto complete Origin
		var term = $("#search_origin_id").val();
        $( "#search_origin_id" ).autocomplete({
         source: "<?php echo BASE_URL(); ?>index.php/json/jsonOrigin",  
         minLength:0,
		 select: function( event , ui ) {
			  $( "#origin_id" ).val( ui.item.customer_id );
			  $( "#origin_address" ).val( ui.item.customer_address_1 );
			  $( "#origin_area" ).val( ui.item.area );
			 
        }    
        })
		.autocomplete( "instance" )._renderItem = function( ul, item ) {
		  return $( "<li style='position:relative; z-index:9999;'>" )
			.append( "<div style='font-size:10px;'>" + item.label+"</div>" )
			.appendTo( ul );
		};
		
		
		
		//auto complete search_job_number
		var term = $("#search_job_number").val();
        $( "#search_job_number" ).autocomplete({
         source: "<?php echo BASE_URL(); ?>index.php/json/jsonJobNumber",  
         minLength:0,
		 select: function( event , ui ) {
			  
			  
			  $( "#client_id" ).val( ui.item.client_id );
			  $( "#client_name" ).val( ui.item.client_name );
			  $( "#origin_id" ).val( ui.item.origin );
			  $( "#origin_address" ).val( ui.item.origin_address );
			  $( "#origin_area" ).val( ui.item.origin_area );
			  $( "#destination_id" ).val( ui.item.destination );
			  $( "#destination_address" ).val( ui.item.destination_address );
			  $( "#destination_area" ).val( ui.item.destination_area );
			  
			  $( "#job_number" ).val( ui.item.value );
			  $( "#id_detail_trucking_order" ).val( ui.item.id_detail_trucking_order );
			  
        }    
        })
		.autocomplete( "instance" )._renderItem = function( ul, item ) {
		  return $( "<li style='position:relative; z-index:9999;'>" )
			.append( "<div style='font-size:10px;'>" + item.label+"</div>" )
			.appendTo( ul );
		};
		
		//auto complete Destination
		var term = $("#search_destination").val();
        $( "#search_destination" ).autocomplete({
         source: "<?php echo BASE_URL(); ?>index.php/json/jsonOrigin",  
         minLength:0,
		 select: function( event , ui ) {
			  $( "#destination_id" ).val( ui.item.customer_id );
			  $( "#destination_address" ).val( ui.item.customer_address_1 );
			  $( "#destination_area" ).val( ui.item.area );
			 
        }    
        })
		.autocomplete( "instance" )._renderItem = function( ul, item ) {
		  return $( "<li style='position:relative; z-index:9999;'>" )
			.append( "<div style='font-size:10px;'>" + item.label+"</div>" )
			.appendTo( ul );
		};
		
		
		
		//auto complete Order Type
		var term = $("#search_order_type").val();
        $( "#search_order_type" ).autocomplete({
         source: "<?php echo BASE_URL(); ?>index.php/json/jsonOrderType",  
         minLength:0,
		 select: function( event , ui ) {
			  $( "#order_type" ).val( ui.item.label );
			 
        }    
        })
		.autocomplete( "instance" )._renderItem = function( ul, item ) {
		  return $( "<li style='position:relative; z-index:9999;'>" )
			.append( "<div style='font-size:10px;'>" + item.label+"</div>" )
			.appendTo( ul );
		};
		
		
		
	
  </script>

  
  
  <script>
		//auto complete Client ID
		var term = $("#edit_search_client_id").val();
        $( "#edit_search_client_id" ).autocomplete({
         source: "<?php echo BASE_URL(); ?>index.php/json/jsonClient", 
         minLength:0,
		 select: function( event , ui ) {
			  $( "#edit_client_id" ).val( ui.item.client_id );
			  $( "#edit_client_name" ).val( ui.item.client_name );
			 
        }    
        })
		.autocomplete( "instance" )._renderItem = function( ul, item ) {
		  return $( "<li style='position:relative; z-index:9999;'>" )
			.append( "<div style='font-size:10px;'>" + item.label+"</div>" )
			.appendTo( ul );
		};
		
		
		//auto complete Origin
		var term = $("#edit_search_origin_id").val();
        $( "#edit_search_origin_id" ).autocomplete({
         source: "<?php echo BASE_URL(); ?>index.php/json/jsonOrigin",  
         minLength:0,
		 select: function( event , ui ) {
			  $( "#edit_origin_id" ).val( ui.item.customer_id );
			  $( "#edit_origin_address" ).val( ui.item.customer_address_1 );
			  $( "#edit_origin_area" ).val( ui.item.area );
			 
        }    
        })
		.autocomplete( "instance" )._renderItem = function( ul, item ) {
		  return $( "<li style='position:relative; z-index:9999;'>" )
			.append( "<div style='font-size:10px;'>" + item.label+"</div>" )
			.appendTo( ul );
		};
		
		
		//auto complete Destination
		var term = $("#edit_search_destination").val();
        $( "#edit_search_destination" ).autocomplete({
         source: "<?php echo BASE_URL(); ?>index.php/json/jsonOrigin",  
         minLength:0,
		 select: function( event , ui ) {
			  $( "#edit_destination_id" ).val( ui.item.customer_id );
			  $( "#edit_destination_address" ).val( ui.item.customer_address_1 );
			  $( "#edit_destination_area" ).val( ui.item.area );
			 
        }    
        })
		.autocomplete( "instance" )._renderItem = function( ul, item ) {
		  return $( "<li style='position:relative; z-index:9999;'>" )
			.append( "<div style='font-size:10px;'>" + item.label+"</div>" )
			.appendTo( ul );
		};
		
		
		
		//auto complete Order Type
		var term = $("#edit_search_order_type").val();
        $( "#edit_search_order_type" ).autocomplete({
         source: "<?php echo BASE_URL(); ?>index.php/json/jsonOrderType",  
         minLength:0,
		 select: function( event , ui ) {
			  $( "#edit_order_type" ).val( ui.item.label );
			 
        }    
        })
		.autocomplete( "instance" )._renderItem = function( ul, item ) {
		  return $( "<li style='position:relative; z-index:9999;'>" )
			.append( "<div style='font-size:10px;'>" + item.label+"</div>" )
			.appendTo( ul );
		};
		
		
		
		
		//auto complete search_job_number
		var term = $("#edit_search_job_number").val();
        $( "#edit_search_job_number" ).autocomplete({
         source: "<?php echo BASE_URL(); ?>index.php/json/jsonJobNumber",  
         minLength:0,
		 select: function( event , ui ) {
			  
			  
			  $( "#edit_client_id" ).val( ui.item.client_id );
			  $( "#edit_client_name" ).val( ui.item.client_name );
			  $( "#edit_origin_id" ).val( ui.item.origin );
			  $( "#edit_origin_address" ).val( ui.item.origin_address );
			  $( "#edit_origin_area" ).val( ui.item.origin_area );
			  $( "#edit_destination_id" ).val( ui.item.destination );
			  $( "#edit_destination_address" ).val( ui.item.destination_address );
			  $( "#edit_destination_area" ).val( ui.item.destination_area );
			  
			  $( "#edit_job_number" ).val( ui.item.value );
			  $( "#edit_id_detail_trucking_order" ).val( ui.item.id_detail_trucking_order );
			  
        }    
        })
		.autocomplete( "instance" )._renderItem = function( ul, item ) {
		  return $( "<li style='position:relative; z-index:9999;'>" )
			.append( "<div style='font-size:10px;'>" + item.label+"</div>" )
			.appendTo( ul );
		};
		
		
		
	
  </script>