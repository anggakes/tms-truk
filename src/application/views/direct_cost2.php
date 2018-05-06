 <!-- HEADER -->
 <section class="content-header">
          <h1>
            Direct Cost
            <small>List Of Direct Cost</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="<?php echo BASE_URL(); ?>"><i class="fa fa-dashboard"></i>Home</a></li>
            <li><a href="<?php echo BASE_URL()."direct_cost"; ?>"><i class="fa fa-dashboard"></i>Direct Cost</a></li>
          </ol>
        </section>
  
  
   <!-- Content -->
   <section class="content">
		
		
  
  
          <div class="box sms box-default color-palette-box">
            <div class="box-header with-border">
              <h3 class="box-title"><i class="fa fa-table"></i> Table Direct Cost</h3>
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
                             <form action="<?php echo base_url()."index.php/direct_cost" ?>" method="get">
                             <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                                <input type="text" id="search" name="search" placeholder="Search..."  value="<?php echo $search; ?>" />
                                <input type="submit" id="submit"  value="Search"/>
                                <?php if($search!="")
								{?>
                                <a href="<?php echo base_url()."index.php/direct_cost" ?>" id="clear-search">Clear Search</a>
                                <?php } ?>
                             </form>
                </div>
                <div id="wrapper-button" class="clearfix">
					<?php if($data_role[0]['export_direct_cost']=='yes'){ ?>
                	<a href="<?php echo base_url()."index.php/direct_cost/exportDirectCost?search=".$search; ?>" class="button orange-button">
                    	Export Direct Cost
                    </a>
					<?php } ?>
                    <?php if($data_role[0]['add_direct_cost']=='yes'){ ?>
                    <a id="add-data" class="button green-button">
                    	Add Direct Cost
                    </a>
					<?php } ?>
					<?php if($data_role[0]['delete_direct_cost']=='yes'){ ?>
                    <a id="delete-data" class="button btn-danger deletelogg">
                    	Delete Direct Cost
                    </a>
					<?php } ?>
					<!--<?php if($data_role[0]['import_direct_cost']=='yes'){ ?>
                    <a id="import-data" class="button blue-button">
                    	Import Direct Cost
                    </a>
					<?php } ?>-->
					
                </div>
                </div>
            <div id="wrapper-console" class="clearfix"> 
            <div class="grid_4 height400">                  
           	<table id="myTable04" class="fancyTable table-bordered table-hover">
                    <thead>
                      <tr>
					  
                        <th><div class="check-box-div"><input type="checkbox" name="select_all" id="select_all"></div>ID Direct Cost</th>
						<th>Client Id</th>
                        <th>Client Name</th>
						<th>Origin</th>
						<th>Destination</th>
						<th>Province</th>
						<th>Vehicle Type</th>
						<th>Vehicle Status</th>
						<th>Fixed Rate</th>
						<th>Period Rate</th>
						<th>Trip Quota</th>
						<th>Weight Rate</th>
						<th>Excess Weight Rate</th>
						<th>Min Weight</th>
						<th>Max Weight</th>
						<th>Uow</th>
						<th>Volume Rate</th>
						<th>Min Volume</th>
						<th>Uov</th>
						<th>Currency</th>
						<th>Drop Destination</th>
						<th>Drop Rate</th>
						<th>Drop Charge After</th>
						<th>Drop Rate Inner</th>
						<th>Drop Rate Outer</th>
						<th>Start Valid Date</th>
						<th>Remark</th>
						<th>Created By</th>
						<th>Created Date</th>
						<th>Updated By</th>
						<th>Updated Date</th>
						
						
						<?php if($data_role[0]['delete_direct_cost']=='yes' || $data_role[0]['edit_direct_cost']=='yes'){ ?>
						<th>Action</th>
						<?php } ?>
                      </tr>
                    </thead>
             		<tbody>
                    <?php foreach($data_direct_cost as $data_direct_cost) {?>
                    <tr id="data_<?php echo $data_direct_cost->id_direct_cost; ?>">
                    	<td class="id_direct_cost">
						<div class="check-box-div">
						<input type="checkbox" name="id_checkbox[]" class="iCheck-helper toedit checkbox_satuan" value="<?php echo $data_direct_cost->id_direct_cost; ?>" />
						</div><span><?php echo $data_direct_cost->id_direct_cost; ?></span></td>
						
                        <td class="client_id"><?php echo $data_direct_cost->client_id; ?></td>
						<td class="client_name"><?php echo $data_direct_cost->client_name; ?></td>
						<td class="origin"><?php echo $data_direct_cost->origin; ?></td>
						<td class="destination"><?php echo $data_direct_cost->destination; ?></td>
						<td class="province"><?php echo $data_direct_cost->province; ?></td>
						<td class="vehicle_type"><?php echo $data_direct_cost->vehicle_type; ?></td>
						<td class="vehicle_status"><?php echo $data_direct_cost->vehicle_status; ?></td>
						<td class="fixed_rate"><?php echo $data_direct_cost->fixed_rate; ?></td>
						<td class="period_rate"><?php echo $data_direct_cost->period_rate; ?></td>
						<td class="trip_quota"><?php echo $data_direct_cost->trip_quota; ?></td>
						<td class="vehicle_rate"><?php echo $data_direct_cost->vehicle_rate; ?></td>
						<td class="weight_rate"><?php echo $data_direct_cost->weight_rate; ?></td>
						<td class="excess_weight_rate"><?php echo $data_direct_cost->excess_weight_rate; ?></td>
						<td class="min_weight"><?php echo $data_direct_cost->min_weight; ?></td>
                        <td class="max_weight"><?php echo $data_direct_cost->max_weight; ?></td>
						<td class="uow"><?php echo $data_direct_cost->uow; ?></td>
						<td class="volume_rate"><?php echo $data_direct_cost->volume_rate; ?></td>
						<td class="min_volume"><?php echo $data_direct_cost->min_volume; ?></td>
						<td class="uov"><?php echo $data_direct_cost->uov; ?></td>
						<td class="currency"><?php echo $data_direct_cost->currency; ?></td>
						<td class="drop_destination"><?php echo $data_direct_cost->drop_destination; ?></td>
						<td class="drop_rate"><?php echo $data_direct_cost->drop_rate; ?></td>
						<td class="drop_charge_after"><?php echo $data_direct_cost->drop_charge_after; ?></td>
						<td class="drop_rate_inner"><?php echo $data_direct_cost->drop_rate_inner; ?></td>
						<td class="drop_rate_outer"><?php echo $data_direct_cost->drop_rate_outer; ?></td>
						<td class="remark"><?php echo $data_direct_cost->remark; ?></td>
						<td class="start_valid_date"><?php echo $data_direct_cost->start_valid_date; ?></td>
						<td class="start_valid_date"><?php echo $data_direct_cost->start_valid_date; ?></td>
						<td class="start_valid_date"><?php echo $data_direct_cost->start_valid_date; ?></td>
						<td class="created_by"><?php echo $data_direct_cost->created_by; ?></td>
						<td class="created_date"><?php echo $data_direct_cost->created_date; ?></td>
						<td class="updated_by"><?php echo $data_direct_cost->updated_by; ?></td>
						<td class="updated_date"><?php echo $data_direct_cost->updated_date; ?></td>
						
						<?php if($data_role[0]['delete_direct_cost']=='yes' || $data_role[0]['edit_direct_cost']=='yes'){ ?>
						<td><?php if($data_role[0]['delete_direct_cost']=='yes'){ ?><a  class="delete_data link_action" id="<?php echo $data_direct_cost->id_direct_cost; ?>" >Delete</a><?php } ?> | <?php if($data_role[0]['edit_direct_cost']=='yes'){ ?><a  id="<?php echo $data_direct_cost->id_direct_cost; ?>" class="edit_data link_action">Edit</a><?php } ?></td>
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
		<h2 id="modal1Title">Add Direct Cost</h2>
				<form role="form" id="form_add_data" method="POST" action="<?php echo base_url()."index.php/direct_cost/addDirectCost" ?>" enctype="multipart/form-data">
				 <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
				 
              <div class="box-body">

				
				
					
				<div class="form-group">
					 <label>Client ID</label>
						<div class="input-group">
						  <div class="input-group-addon">
							<i class="fa fa-search"></i>
						  </div>
						  <input type="text" class="form-control pull-right" name="search_client_id" id="search_client_id" value='' placeholder='Search Client ID'>
						  <input type="text" readonly class="form-control" name="client_id" id="client_id" placeholder='Client ID' required>
						  <input type="text" readonly class="form-control" name="client_name" id="client_name" placeholder='Client Name' required>
						</div>
						<!-- /.input group -->
				</div>
				
				
				<div class="form-group">
					 <label>Origin</label>
						<div class="input-group">
						  <div class="input-group-addon">
							<i class="fa fa-search"></i>
						  </div>
						  <input type="text" class="form-control pull-right" name="search_origin" id="search_origin" value='' placeholder='Search Origin'>
						  <input type="text" readonly class="form-control" name="origin" id="origin" placeholder='Client ID' required>
						</div>
						<!-- /.input group -->
				</div>
				
				<div class="form-group">
					 <label>Destination</label>
						<div class="input-group">
						  <div class="input-group-addon">
							<i class="fa fa-search"></i>
						  </div>
						  <input type="text" class="form-control pull-right" name="search_destination" id="search_destination" value='' placeholder='Search Origin'>
						  <input type="text" readonly class="form-control" name="destination" id="destination" placeholder='Destination' required>
						</div>
						<!-- /.input group -->
				</div>
				
				
				
				<div class="form-group">
					 <label>Province</label>
						<div class="input-group">
						  <div class="input-group-addon">
							<i class="fa fa-search"></i>
						  </div>
						  <input type="text" class="form-control pull-right" name="search_province" id="search_province" value='' placeholder='Search Province'>
						  <input type="text" readonly class="form-control" name="province" id="province" placeholder='Province' required>
						</div>
						<!-- /.input group -->
				</div>
				
				
				<div class="form-group">
					 <label>Vehicle Type</label>
						<div class="input-group">
						  <div class="input-group-addon">
							<i class="fa fa-search"></i>
						  </div>
						  <input type="text" class="form-control pull-right" name="search_vehicle_type" id="search_vehicle_type" value='' placeholder='Search Vehicle Type'>
						  <input type="text" readonly class="form-control" name="vehicle_type" id="vehicle_type" placeholder='Vehicle Type' required>
						</div>
						<!-- /.input group -->
				</div>
				
					
				
				<div class="form-group">
					  <label for="drivercode2">Vehicle Status</label>
					  <select class="form-control" name="vehicle_status" id="vehicle_status" required>
						<option selected="selected" value="">Choose Vehicle Status</option>
						<option value="new">New</option>
						<option value="Assets">Assets</option>
						<option value="Non Assets">Non Assets</option>
					  </select> 
				</div>
					
					
				
				<div class="form-group">
					  <label for="drivercode2">Fixed Rate</label>
					 <input type="text" class="form-control" name="fixed_rate" id="fixed_rate" required>
					</div>
                </div>
					
				<div class="form-group">
					  <label for="drivercode2">Period Rate</label>
					 <input type="text" class="form-control" name="period_rate" id="period_rate" required>
					</div>
                </div>
				
				<div class="form-group">
					  <label for="drivercode2">Trip Rate</label>
					 <input type="text" class="form-control" name="trip_quota" id="trip_quota" required>
					</div>
                </div>
				
				<div class="form-group">
					  <label for="drivercode2">Vehicle Rate</label>
					 <input type="text" class="form-control" name="vehicle_rate" id="vehicle_rate" required>
					</div>
                </div>
				
				<div class="form-group">
					  <label for="drivercode2">Weight Rate</label>
					 <input type="text" class="form-control" name="weight_rate" id="weight_rate" required>
					</div>
                </div>
				
				<div class="form-group">
					  <label for="drivercode2">Excess Weight Rate</label>
					 <input type="text" class="form-control" name="excess_weight_rate" id="excess_weight_rate" required>
					</div>
                </div>
				
				<div class="form-group">
					  <label for="drivercode2">Min Weight</label>
					 <input type="text" class="form-control" name="min_weight" id="min_weight" required>
					</div>
                </div>
				
				<div class="form-group">
					  <label for="drivercode2">Max Weight</label>
					 <input type="text" class="form-control" name="max_weight" id="max_weight" required>
					</div>
                </div>
				
				<div class="form-group">
					  <label for="drivercode2">UOW</label>
					 <input type="text" class="form-control" name="uow" id="uow" required>
					</div>
                </div>
				
				
				<div class="form-group">
					  <label for="drivercode2">Volume Rate</label>
					 <input type="text" class="form-control" name="volume_rate" id="volume_rate" required>
					</div>
                </div>
					
				<div class="form-group">
					  <label for="drivercode2">Min Volume</label>
					 <input type="text" class="form-control" name="min_volume" id="min_volume" required>
					</div>
                </div>
				
				<div class="form-group">
					  <label for="drivercode2">UOV</label>
					 <input type="text" class="form-control" name="uov" id="uov" required>
					</div>
                </div>
				
				
				<div class="form-group">
					  <label for="drivercode2">Currency</label>
					  <select class="form-control" name="currency" id="currency" required>
						<option selected="selected" value="">Choose Currency</option>
						<option value="new">New</option>
						<option value="IDR">IDR</option>
						<option value="USD">USD</option>
					  </select> 
				</div>
				
				<div class="form-group">
					  <label for="drivercode2">Drop Destination</label>
					  <input type="text" class="form-control" name="drop_destination" id="drop_destination" required>
					</div>
                </div>
				
				
				<div class="form-group">
					  <label for="drivercode2">Drop Rate</label>
					  <input type="text" class="form-control" name="drop_rate" id="drop_rate" required>
					</div>
                </div>
				
					
				
				<div class="form-group">
					  <label for="drivercode2">Drop Charge After</label>
					 <input type="text" class="form-control" name="drop_charge_after" id="drop_charge_after" required>
					</div>
                </div>
				
				
				
				<div class="form-group">
					  <label for="drivercode2">Drop Charge After</label>
					  <input type="text" class="form-control" name="drop_rate_inner" id="drop_rate_inner" required>
					</div>
                </div>
				
					
				<div class="form-group">
					  <label for="drivercode2">Drop Charge After</label>
					 <input type="text" class="form-control" name="drop_rate_outer" id="drop_rate_outer" required>
					</div>
                </div>
					
				<div class="form-group">
					  <label for="drivercode2">Drop Charge After</label>
					  <input type="text" class="form-control" name="start_valid_date" id="start_valid_date" required>
					</div>
                </div>
				
				<div class="form-group">
					  <label for="drivercode2">Remark</label>
					 <textarea class="form-control" name="remark" id="remark" required></textarea>
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
		<h2 id="modal1Title">Edit Direct Cost</h2>
				<form role="form" id="form_edit_data" method="POST" action="<?php echo base_url()."index.php/direct_cost/editDirectCost" ?>" enctype="multipart/form-data">
				 <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
				 
              <div class="box-body">

				<div class="form-group">
					 <label>Client ID</label>
						<div class="input-group">
						  <div class="input-group-addon">
							<i class="fa fa-search"></i>
						  </div>
						  <input type="text" class="form-control pull-right" name="edit_search_client_id" id="edit_search_client_id" value='' placeholder='Search Client ID'>
						  <input type="text" readonly class="form-control" name="edit_client_id" id="edit_client_id" placeholder='Client ID' required>
						  <input type="text" readonly class="form-control" name="edit_client_name" id="edit_client_name" placeholder='Client Name' required>
						</div>
						<!-- /.input group -->
				</div>
				
				
				<div class="form-group">
					 <label>Origin</label>
						<div class="input-group">
						  <div class="input-group-addon">
							<i class="fa fa-search"></i>
						  </div>
						  <input type="text" class="form-control pull-right" name="edit_search_origin" id="edit_search_origin" value='' placeholder='Search Origin'>
						  <input type="text" readonly class="form-control" name="edit_origin" id="edit_origin" placeholder='Client ID' required>
						</div>
						<!-- /.input group -->
				</div>
				
				<div class="form-group">
					 <label>Destination</label>
						<div class="input-group">
						  <div class="input-group-addon">
							<i class="fa fa-search"></i>
						  </div>
						  <input type="text" class="form-control pull-right" name="edit_search_destination" id="edit_search_destination" value='' placeholder='Search Origin'>
						  <input type="text" readonly class="form-control" name="edit_destination" id="edit_destination" placeholder='Destination' required>
						</div>
						<!-- /.input group -->
				</div>
				
				
				
				<div class="form-group">
					 <label>Province</label>
						<div class="input-group">
						  <div class="input-group-addon">
							<i class="fa fa-search"></i>
						  </div>
						  <input type="text" class="form-control pull-right" name="edit_search_province" id="edit_search_province" value='' placeholder='Search Province'>
						  <input type="text" readonly class="form-control" name="edit_province" id="edit_province" placeholder='Province' required>
						</div>
						<!-- /.input group -->
				</div>
				
				
				<div class="form-group">
					 <label>Vehicle Type</label>
						<div class="input-group">
						  <div class="input-group-addon">
							<i class="fa fa-search"></i>
						  </div>
						  <input type="text" class="form-control pull-right" name="edit_search_vehicle_type" id="sedit_earch_vehicle_type" value='' placeholder='Search Vehicle Type'>
						  <input type="text" readonly class="form-control" name="edit_vehicle_type" id="edit_vehicle_type" placeholder='Vehicle Type' required>
						</div>
						<!-- /.input group -->
				</div>
				
					
				
				<div class="form-group">
					  <label for="drivercode2">Vehicle Status</label>
					  <select class="form-control" name="edit_vehicle_status" id="edit_vehicle_status" required>
						<option selected="selected" value="">Choose Vehicle Status</option>
						<option value="new">New</option>
						<option value="Assets">Assets</option>
						<option value="Non Assets">Non Assets</option>
					  </select> 
				</div>
					
					
				
				<div class="form-group">
					  <label for="drivercode2">Fixed Rate</label>
					 <input type="text" class="form-control" name="edit_fixed_rate" id="edit_fixed_rate" required>
					</div>
                </div>
					
				<div class="form-group">
					  <label for="drivercode2">Period Rate</label>
					 <input type="text" class="form-control" name="edit_period_rate" id="edit_period_rate" required>
					</div>
                </div>
				
				<div class="form-group">
					  <label for="drivercode2">Trip Rate</label>
					 <input type="text" class="form-control" name="edit_trip_quota" id="edit_trip_quota" required>
					</div>
                </div>
				
				<div class="form-group">
					  <label for="drivercode2">Vehicle Rate</label>
					 <input type="text" class="form-control" name="edit_vehicle_rate" id="edit_vehicle_rate" required>
					</div>
                </div>
				
				<div class="form-group">
					  <label for="drivercode2">Weight Rate</label>
					 <input type="text" class="form-control" name="edit_weight_rate" id="edit_weight_rate" required>
					</div>
                </div>
				
				<div class="form-group">
					  <label for="drivercode2">Excess Weight Rate</label>
					 <input type="text" class="form-control" name="edit_excess_weight_rate" id="edit_excess_weight_rate" required>
					</div>
                </div>
				
				<div class="form-group">
					  <label for="drivercode2">Min Weight</label>
					 <input type="text" class="form-control" name="edit_min_weight" id="edit_min_weight" required>
					</div>
                </div>
				
				<div class="form-group">
					  <label for="drivercode2">Max Weight</label>
					 <input type="text" class="form-control" name="edit_max_weight" id="edit_max_weight" required>
					</div>
                </div>
				
				<div class="form-group">
					  <label for="drivercode2">UOW</label>
					 <input type="text" class="form-control" name="edit_uow" id="edit_uow" required>
					</div>
                </div>
				
				
				<div class="form-group">
					  <label for="drivercode2">Volume Rate</label>
					 <input type="text" class="form-control" name="edit_volume_rate" id="edit_volume_rate" required>
					</div>
                </div>
					
				<div class="form-group">
					  <label for="drivercode2">Min Volume</label>
					 <input type="text" class="form-control" name="edit_min_volume" id="edit_min_volume" required>
					</div>
                </div>
				
				<div class="form-group">
					  <label for="drivercode2">UOV</label>
					 <input type="text" class="form-control" name="edit_uov" id="edit_uov" required>
					</div>
                </div>
				
				
				<div class="form-group">
					  <label for="drivercode2">Currency</label>
					  <select class="form-control" name="edit_currency" id="edit_currency" required>
						<option selected="selected" value="">Choose Currency</option>
						<option value="new">New</option>
						<option value="IDR">IDR</option>
						<option value="USD">USD</option>
					  </select> 
				</div>
				
				<div class="form-group">
					  <label for="drivercode2">Drop Destination</label>
					  <input type="text" class="form-control" name="edit_drop_destination" id="edit_drop_destination" required>
					</div>
                </div>
				
				
				<div class="form-group">
					  <label for="drivercode2">Drop Rate</label>
					  <input type="text" class="form-control" name="edit_drop_rate" id="edit_drop_rate" required>
					</div>
                </div>
				
					
				
				<div class="form-group">
					  <label for="drivercode2">Drop Charge After</label>
					 <input type="text" class="form-control" name="edit_drop_charge_after" id="edit_drop_charge_after" required>
					</div>
                </div>
				
				
				
				<div class="form-group">
					  <label for="drivercode2">Drop Charge After</label>
					  <input type="text" class="form-control" name="edit_drop_rate_inner" id="edit_drop_rate_inner" required>
					</div>
                </div>
				
					
				<div class="form-group">
					  <label for="drivercode2">Drop Charge After</label>
					 <input type="text" class="form-control" name="edit_drop_rate_outer" id="edit_drop_rate_outer" required>
					</div>
                </div>
					
				<div class="form-group">
					  <label for="drivercode2">Drop Charge After</label>
					  <input type="text" class="form-control" name="edit_start_valid_date" id="edit_start_valid_date" required>
					</div>
                </div>
				
				<div class="form-group">
					  <label for="drivercode2">Remark</label>
					 <textarea class="form-control" name="edit_remark" id="edit_remark" required></textarea>
					</div>
                </div>
              </div>
			  
			  
                <input type="hidden" class="form-control" name="id_direct_cost_update" id="id_direct_cost_update">
              
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
		<h2 id="modal1Title">Import Direct Cost</h2>
				<form role="form" id="form_import_data" method="POST" action="<?php echo base_url()."index.php/direct_cost/importDirectCost" ?>" enctype="multipart/form-data">
				 <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
				 
              <div class="box-body">

				 <div class="form-group">
                      <label for="exampleInputEmail1">Choose File</label>
                      <input type="file" name="import_file" id="import_file" class="form-control" value="" />
				</div>
				
				 <div class="form-group">
                    <p><a target="_blank" href="<?php echo base_url('/files/example-files/import-direct_cost.xlsx')?>">Download sample file import direct_cost</a></p>
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
		<h2 id="modal1Title">Delete Direct Cost</h2>
				<form role="form" id="form_delete_data" method="POST" action="<?php echo base_url()."index.php/direct_cost/deleteDirectCost" ?>" enctype="multipart/form-data">
				 <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
				 
              <div class="box-body">

				 <div class="form-group">
                     <p>Are you sure want to delete this data? (<span id="reference_delete"></span>)</p>
				</div>
				
				 <div class="form-group">
                      <input type="hidden" name="id_direct_cost_delete" id="id_direct_cost_delete" class="form-control" value="" />
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
		<h2 id="modal1Title">Delete Direct Cost</h2>
				<form role="form" id="form_selected_delete_data" method="POST" action="<?php echo base_url()."index.php/direct_cost/deleteDirectCostAll" ?>" enctype="multipart/form-data">
				 <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
				 
              <div class="box-body">

				 <div class="form-group">
                     <p>Are you sure want to delete selected data? </p>
				</div>
				
				 <div class="form-group">
                      <input type="hidden" name="id_direct_cost_delete_all" id="id_direct_cost_delete_all" class="form-control" value="" />
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
				var direct_cost_code =  $('#data_'+id+' .direct_cost_code').text();
				var id_direct_cost =  $('#data_'+id+' .id_direct_cost span').text();
				$("#reference_delete").text("Direct Cost Code:"+direct_cost_code)
				$("#id_direct_cost_delete").val(id_direct_cost);
			});
			
			
			
			$(".edit_data").click(function(){
				var id = $(this).attr('id');
				var direct_cost_code =  $('#data_'+id+' .direct_cost_code').text();
				var id_direct_cost =  $('#data_'+id+' .id_direct_cost span').text();
				var direct_cost_name =  $('#data_'+id+' .direct_cost_name').text();
				$("#id_direct_cost_update").val(id_direct_cost);
				$("#edit_direct_cost_code").val(direct_cost_code);
				$("#edit_direct_cost_name").val(direct_cost_name);
			});
			
			
				
				
			

			$("#form_add_data").validate({
				messages: {
				client_id: {
				required: 'Client Id Name must be filled!'
				},
				client_name: {
				required: 'Client Name Code must be filled!'
				},
				origin: {
				required: 'Origin must be filled!'
				},
				destination: {
				required: 'Destination must be filled!'
				},
				province: {
				required: 'Province must be filled!'
				},
				vehicle_type: {
				required: 'Vehicle Type must be filled!'
				},
				vehicle_status: {
				required: 'vVehicle Status must be filled!'
				},
				fixed_rate: {
				required: 'Fixed Rate must be filled!'
				},
				period_rate: {
				required: 'Period Rate must be filled!'
				},
				trip_quota: {
				required: 'Trip Quota must be filled!'
				},
				vehicle_rate: {
				required: 'Vehicle Rate must be filled!'
				},
				weight_rate: {
				required: 'Weight Rate must be filled!'
				},
				excess_weight_rate: {
				required: 'Excess Weight Rate must be filled!'
				},
				min_weight: {
				required: 'Min Weight must be filled!'
				},
				max_weight: {
				required: 'Max Weight must be filled!'
				},
				uow: {
				required: 'UOW must be filled!'
				},
				volume_rate: {
				required: 'Volume Rate must be filled!'
				},
				min_volume: {
				required: 'Min Volume must be filled!'
				},
				uov: {
				required: 'UOV must be filled!'
				},
				currency: {
				required: 'Currency must be filled!'
				},
				drop_destination: {
				required: 'Drop Destination must be filled!'
				},
				drop_rate: {
				required: 'Drop Rate must be filled!'
				},
				drop_charge_after: {
				required: 'Drop Charge After must be filled!'
				},
				drop_rate_inner: {
				required: 'Drop Rate Inner must be filled!'
				},
				drop_rate_outer: {
				required: 'Drop Rate Outer must be filled!'
				},
				start_valid_date: {
				required: 'Start Vaid Date must be filled!'
				},
				remark: {
				required: 'Remark must be filled!'
				}
			
			}
			});
			
			
			
			$("#form_edit_data").validate({
				messages: {
				edit_client_id: {
				required: 'Client Id Name must be filled!'
				},
				edit_client_name: {
				required: 'Client Name Code must be filled!'
				},
				edit_origin: {
				required: 'Origin must be filled!'
				},
				edit_destination: {
				required: 'Destination must be filled!'
				},
				edit_province: {
				required: 'Province must be filled!'
				},
				edit_vehicle_type: {
				required: 'Vehicle Type must be filled!'
				},
				edit_vehicle_status: {
				required: 'vVehicle Status must be filled!'
				},
				edit_fixed_rate: {
				required: 'Fixed Rate must be filled!'
				},
				edit_period_rate: {
				required: 'Period Rate must be filled!'
				},
				edit_trip_quota: {
				required: 'Trip Quota must be filled!'
				},
				edit_vehicle_rate: {
				required: 'Vehicle Rate must be filled!'
				},
				edit_weight_rate: {
				required: 'Weight Rate must be filled!'
				},
				edit_excess_weight_rate: {
				required: 'Excess Weight Rate must be filled!'
				},
				edit_min_weight: {
				required: 'Min Weight must be filled!'
				},
				edit_max_weight: {
				required: 'Max Weight must be filled!'
				},
				edit_uow: {
				required: 'UOW must be filled!'
				},
				edit_volume_rate: {
				required: 'Volume Rate must be filled!'
				},
				edit_min_volume: {
				required: 'Min Volume must be filled!'
				},
				edit_uov: {
				required: 'UOV must be filled!'
				},
				edit_currency: {
				required: 'Currency must be filled!'
				},
				edit_drop_destination: {
				required: 'Drop Destination must be filled!'
				},
				edit_drop_rate: {
				required: 'Drop Rate must be filled!'
				},
				edit_drop_charge_after: {
				required: 'Drop Charge After must be filled!'
				},
				edit_drop_rate_inner: {
				required: 'Drop Rate Inner must be filled!'
				},
				edit_drop_rate_outer: {
				required: 'Drop Rate Outer must be filled!'
				},
				edit_start_valid_date: {
				required: 'Start Vaid Date must be filled!'
				},
				edit_remark: {
				required: 'Remark must be filled!'
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
		$("#id_direct_cost_delete_all").val(ids);
		
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
