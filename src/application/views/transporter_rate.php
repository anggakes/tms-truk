 <!-- HEADER -->
 <section class="content-header">
          <h1>
            Transporter Rate
            <small>List Of Transporter Rate</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="<?php echo BASE_URL(); ?>"><i class="fa fa-dashboard"></i>Home</a></li>
            <li><a href="<?php echo BASE_URL()."transporter_rate"; ?>"><i class="fa fa-dashboard"></i>Transporter Rate</a></li>
          </ol>
        </section>
  
  
   <!-- Content -->
   <section class="content">
		
		
  
  
          <div class="box sms box-default color-palette-box">
            <div class="box-header with-border">
              <h3 class="box-title"><i class="fa fa-table"></i> Table Transporter Rate</h3>
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
				$date = explode("-",$date);
				echo $date[2].'-'.$date[1].'-'.$date[0];		
			
			}
			?>
            <div id="wrapper-console" class="clearfix">
                <div id="wrapper-search">
                             <form action="<?php echo base_url()."index.php/transporter_rate" ?>" method="get">
                             <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                                <input type="text" id="search" name="search" placeholder="Search..."  value="<?php echo $search; ?>" />
                                <input type="submit" id="submit"  value="Search"/>
                                <?php if($search!="")
								{?>
                                <a href="<?php echo base_url()."index.php/transporter_rate" ?>" id="clear-search">Clear Search</a>
                                <?php } ?>
                             </form>
                </div>
                <div id="wrapper-button" class="clearfix">
					<?php if($data_role[0]['export_transporter_rate']=='yes'){ ?>
                	<a href="<?php echo base_url()."index.php/transporter_rate/exportTransporterRate?search=".$search; ?>" class="button orange-button">
                    	Export Transporter Rate
                    </a>
					<?php } ?>
                    <?php if($data_role[0]['add_transporter_rate']=='yes'){ ?>
                    <a id="add-data" class="button green-button">
                    	Add Transporter Rate
                    </a>
					<?php } ?>
					<?php if($data_role[0]['delete_transporter_rate']=='yes'){ ?>
                    <a id="delete-data" class="button btn-danger deletelogg">
                    	Delete Transporter Rate
                    </a>
					<?php } ?>
					<!--<?php if($data_role[0]['import_transporter_rate']=='yes'){ ?>
                    <a id="import-data" class="button blue-button">
                    	Import Transporter Rate
                    </a>
					<?php } ?>-->
					
                </div>
                </div>
            <div id="wrapper-console" class="clearfix"> 
            <div class="grid_4 height400">                  
           	<table id="myTable04" class="fancyTable table table-bordered table-hover">
                    <thead>
                      <tr>
					  
                        <th><div class="mid"><div class="check-box-div"><input type="checkbox" name="select_all" id="select_all"></div>ID Transporter Rate</div></th>
						<th><div class="mid">Client Id</div></th>
                        <th><div class="mid">Client Name</div></th>
						<th><div class="mid">Transporter Id</div></th>
                        <th><div class="mid">Transporter Name</div></th>
						<th><div class="mid">Origin</div></th>
						<th><div class="mid">Destination</div></th>
						<th><div class="mid">Province</div></th>
						<th><div class="mid">Vehicle Type</div></th>
						<th><div class="mid">Vehicle Status</div></th>
						<th><div class="mid">Fixed Rate</div></th>
						<th><div class="mid">Period Rate</div></th>
						<th><div class="mid">Trip Quota</div></th>
						<th><div class="mid">Vehicle Rate</div></th>
						<th><div class="mid">Weight Rate</div></th>
						<th><div class="mid">Excess Weight Rate</div></th>
						<th><div class="mid">Min Weight</div></th>
						<th><div class="mid">Max Weight</div></th>
						<th><div class="mid">Uow</div></th>
						<th><div class="mid">Volume Rate</div></th>
						<th><div class="mid">Min Volume</div></th>
						<th><div class="mid">Uov</div></th>
						<th><div class="mid">Currency</div></th>
						<th><div class="mid">Drop Destination</div></th>
						<th><div class="mid">Drop Rate</div></th>
						<th><div class="mid">Drop Charge After</div></th>
						<th><div class="mid">Drop Rate Inner</div></th>
						<th><div class="mid">Drop Rate Outer</div></th>
						<th><div class="mid">Start Valid Date</div></th>
						<th><div class="mid">Expired Date</div></th>
						<th><div class="mid">Rate Status</div></th>
						<th><div class="mid">Remark</div></th>
						<th><div class="mid">Created By</div></th>
						<th><div class="mid">Created Date</div></th>
						<th><div class="mid">Updated By</div></th>
						<th><div class="mid">Updated Date</div></th>
						
						
						<?php if($data_role[0]['delete_transporter_rate']=='yes' || $data_role[0]['edit_transporter_rate']=='yes'){ ?>
						<th><div class="mid">Action</div></th>
						<?php } ?>
                      </tr>
                    </thead>
             		<tbody>
                    <?php foreach($data_transporter_rate as $data_transporter_rate) {?>
                    <tr id="data_<?php echo $data_transporter_rate->id_transporter_rate; ?>">
                    	<td class="id_transporter_rate">
						<div style="width:200px;">
						<div class="check-box-div">
						<input type="checkbox" name="id_checkbox[]" class="iCheck-helper toedit checkbox_satuan" value="<?php echo $data_transporter_rate->id_transporter_rate; ?>" />
						</div><span><?php echo $data_transporter_rate->id_transporter_rate; ?></span></div></td>
						
                        <td class="client_id"><?php echo $data_transporter_rate->client_id; ?></td>
						<td class="client_name"><?php echo $data_transporter_rate->client_name; ?></td>
						<td class="transporter_id"><?php echo $data_transporter_rate->transporter_id; ?></td>
						<td class="transporter_name"><?php echo $data_transporter_rate->transporter_name; ?></td>
						<td class="origin"><?php echo $data_transporter_rate->origin; ?></td>
						<td class="destination"><?php echo $data_transporter_rate->destination; ?></td>
						<td class="province"><?php echo $data_transporter_rate->province; ?></td>
						<td class="vehicle_type"><?php echo $data_transporter_rate->vehicle_type; ?></td>
						<td class="vehicle_status"><?php echo $data_transporter_rate->vehicle_status; ?></td>
						<td class="fixed_rate"><?php echo $data_transporter_rate->fixed_rate; ?></td>
						<td class="period_rate"><?php convert_date($data_transporter_rate->period_rate); ?></td>
						<td class="trip_quota"><?php echo $data_transporter_rate->trip_quota; ?></td>
						<td class="vehicle_rate"><?php echo $data_transporter_rate->vehicle_rate; ?></td>
						<td class="weight_rate"><?php echo $data_transporter_rate->weight_rate; ?></td>
						<td class="excess_weight_rate"><?php echo $data_transporter_rate->excess_weight_rate; ?></td>
						<td class="min_weight"><?php echo $data_transporter_rate->min_weight; ?></td>
                        <td class="max_weight"><?php echo $data_transporter_rate->max_weight; ?></td>
						<td class="uow"><?php echo $data_transporter_rate->uow; ?></td>
						<td class="volume_rate"><?php echo $data_transporter_rate->volume_rate; ?></td>
						<td class="min_volume"><?php echo $data_transporter_rate->min_volume; ?></td>
						<td class="uov"><?php echo $data_transporter_rate->uov; ?></td>
						<td class="currency"><?php echo $data_transporter_rate->currency; ?></td>
						<td class="drop_destination"><?php echo $data_transporter_rate->drop_destination; ?></td>
						<td class="drop_rate"><?php echo $data_transporter_rate->drop_rate; ?></td>
						<td class="drop_charge_after"><?php echo $data_transporter_rate->drop_charge_after; ?></td>
						<td class="drop_rate_inner"><?php echo $data_transporter_rate->drop_rate_inner; ?></td>
						<td class="drop_rate_outer"><?php echo $data_transporter_rate->drop_rate_outer; ?></td>
						<td class="start_valid_date"><?php convert_date($data_transporter_rate->start_valid_date); ?></td>
						<td class="expired_date"><?php convert_date($data_transporter_rate->expired_date); ?></td>
						<td class="rate_status"><?php echo $data_transporter_rate->rate_status; ?></td>
						<td class="remark"><?php echo $data_transporter_rate->remark; ?></td>
						<td class="created_by"><?php echo $data_transporter_rate->created_by; ?></td>
						<td class="created_date"><?php echo $data_transporter_rate->created_date; ?></td>
						<td class="updated_by"><?php echo $data_transporter_rate->updated_by; ?></td>
						<td class="updated_date"><?php echo $data_transporter_rate->updated_date; ?></td>
						
						<?php if($data_role[0]['delete_transporter_rate']=='yes' || $data_role[0]['edit_transporter_rate']=='yes'){ ?>
						<td><?php if($data_role[0]['delete_transporter_rate']=='yes'){ ?><a  class="delete_data link_action" id="<?php echo $data_transporter_rate->id_transporter_rate; ?>" >Delete</a><?php } ?> | <?php if($data_role[0]['edit_transporter_rate']=='yes'){ ?><a  id="<?php echo $data_transporter_rate->id_transporter_rate; ?>" class="edit_data link_action">Edit</a><?php } ?></td>
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
		<h2 id="modal1Title">Add Transporter Rate</h2>
				<form role="form" id="form_add_data" method="POST" action="<?php echo base_url()."index.php/transporter_rate/addTransporterRate" ?>" enctype="multipart/form-data">
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
					 <label>Transporter ID</label>
						<div class="input-group">
						  <div class="input-group-addon">
							<i class="fa fa-search"></i>
						  </div>
						  <input type="text" class="form-control pull-right" name="search_client_id" id="search_transporter_id" value='' placeholder='Search Transporter ID'>
						  <input type="text" readonly class="form-control" name="transporter_id" id="transporter_id" placeholder='Transporter ID' required>
						  <input type="text" readonly class="form-control" name="transporter_name" id="transporter_name" placeholder='Transporter Name' required>
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
						  <input type="text" readonly class="form-control" name="origin" id="origin" placeholder='Origin ID' required>
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
							<option value='oncall'>On Call</option>
							<option value='contract'>Contract</option>
					  </select> 
				</div>
					
					
				
				<div class="form-group">
					  <label for="drivercode2">Fixed Rate</label>
					 <input type="text" class="form-control" name="fixed_rate" id="fixed_rate" required>
					</div>
					
				<div class="form-group">
					  <label for="drivercode2">Period Rate</label>
						  <div class="input-group date">
						  <div class="input-group-addon">
							<i class="fa fa-calendar"></i>
						  </div>
						  <input type="text" name="period_rate" id="period_rate" class="form-control pull-right datepicker"  required>
						</div>
				</div>
				
				<div class="form-group">
					  <label for="drivercode2">Trip Rate</label>
					 <input type="text" class="form-control" name="trip_quota" id="trip_quota" required>
					</div>
				
				<div class="form-group">
					  <label for="drivercode2">Vehicle Rate</label>
					 <input type="text" class="form-control" name="vehicle_rate" id="vehicle_rate" required>
					</div>
				
				<div class="form-group">
					  <label for="drivercode2">Weight Rate</label>
					 <input type="text" class="form-control" name="weight_rate" id="weight_rate" required>
					</div>
				
				<div class="form-group">
					  <label for="drivercode2">Excess Weight Rate</label>
					 <input type="text" class="form-control" name="excess_weight_rate" id="excess_weight_rate" required>
					</div>
				
				<div class="form-group">
					  <label for="drivercode2">Min Weight</label>
					 <input type="text" class="form-control" name="min_weight" id="min_weight" required>
					</div>
				
				<div class="form-group">
					  <label for="drivercode2">Max Weight</label>
					 <input type="text" class="form-control" name="max_weight" id="max_weight" required>
					</div>
				
				<div class="form-group">
					  <label for="drivercode2">UOW</label>
					 <input type="text" class="form-control" name="uow" id="uow" required>
					</div>
				
				<div class="form-group">
					  <label for="drivercode2">Volume Rate</label>
					 <input type="text" class="form-control" name="volume_rate" id="volume_rate" required>
					</div>
					
				<div class="form-group">
					  <label for="drivercode2">Min Volume</label>
					 <input type="text" class="form-control" name="min_volume" id="min_volume" required>
					</div>
				
				<div class="form-group">
					  <label for="drivercode2">UOV</label>
					 <input type="text" class="form-control" name="uov" id="uov" required>
					</div>
				
				
				<div class="form-group">
					  <label for="drivercode2">Currency</label>
					  <select class="form-control" name="currency" id="currency" required>
						<option selected="selected" value="">Choose Currency</option>
						<option value="IDR">IDR</option>
						<option value="USD">USD</option>
					  </select> 
				</div>
				
				<div class="form-group">
					  <label for="drivercode2">Drop Destination</label>
					  <input type="text" class="form-control" name="drop_destination" id="drop_destination" required>
					</div>
				
				<div class="form-group">
					  <label for="drivercode2">Drop Rate</label>
					  <input type="text" class="form-control" name="drop_rate" id="drop_rate" required>
					</div>
					
				
				<div class="form-group">
					  <label for="drivercode2">Drop Charge After</label>
					 <input type="text" class="form-control" name="drop_charge_after" id="drop_charge_after" required>
					</div>
				
					
				<div class="form-group">
					  <label for="drivercode2">Drop Rate Inner</label>
					 <input type="text" class="form-control" name="drop_rate_inner" id="drop_rate_inner" required>
					</div>
				
				<div class="form-group">
					  <label for="drivercode2">Drop Rate Outer	</label>
					 <input type="text" class="form-control" name="drop_rate_outer" id="drop_rate_outer" required>
					</div>
				
				
				
				 <div class="form-group">
					  <label for="drivercode2">Start Valid Date</label>
						  <div class="input-group date">
						  <div class="input-group-addon">
							<i class="fa fa-calendar"></i>
						  </div>
						  <input type="text" name="start_valid_date" id="start_valid_date" class="form-control pull-right datepicker"  required>
						</div>
				</div>
				
				
				 <div class="form-group">
					  <label for="drivercode2">Expired Date</label>
						  <div class="input-group date">
						  <div class="input-group-addon">
							<i class="fa fa-calendar"></i>
						  </div>
						  <input type="text" name="expired_date" id="expired_date" class="form-control pull-right datepicker"  required>
						</div>
				</div>
				
				<div class="form-group">
					  <label for="drivercode2">Rate Status</label>
					  <select class="form-control" name="rate_status" id="rate_status" required>
						<option value="active">Active</option>
						<option value="inactive">Inactive</option>
					  </select> 
				</div>
				
				
				<div class="form-group">
					  <label for="drivercode2">Remark</label>
					 <textarea class="form-control" name="remark" id="remark" required></textarea>
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
		<h2 id="modal1Title">Edit Transporter Rate</h2>
				<form role="form" id="form_edit_data" method="POST" action="<?php echo base_url()."index.php/transporter_rate/editTransporterRate" ?>" enctype="multipart/form-data">
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
					 <label>Transporter ID</label>
						<div class="input-group">
						  <div class="input-group-addon">
							<i class="fa fa-search"></i>
						  </div>
						  <input type="text" class="form-control pull-right" name="edit_search_client_id" id="edit_search_transporter_id" value='' placeholder='Search Transporter ID'>
						  <input type="text" readonly class="form-control" name="edit_transporter_id" id="edit_transporter_id" placeholder='Transporter ID' required>
						  <input type="text" readonly class="form-control" name="edit_transporter_name" id="edit_transporter_name" placeholder='Transporter Name' required>
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
						  <input type="text" readonly class="form-control" name="edit_origin" id="edit_origin" placeholder='origin ID' required>
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
							<option value='oncall'>On Call</option>
							<option value='contract'>Contract</option>
					  </select> 
				</div>
					
					
				
				<div class="form-group">
					  <label for="drivercode2">Fixed Rate</label>
					 <input type="text" class="form-control" name="edit_fixed_rate" id="edit_fixed_rate" required>
					</div>
					
				<div class="form-group">
					  <label for="drivercode2">Period Rate</label>
						  <div class="input-group date">
						  <div class="input-group-addon">
							<i class="fa fa-calendar"></i>
						  </div>
						  <input type="text" name="edit_period_rate" id="edit_period_rate" class="form-control pull-right datepicker"  required>
						</div>
				</div>
					
				<div class="form-group">
					  <label for="drivercode2">Trip Rate</label>
					 <input type="text" class="form-control" name="edit_trip_quota" id="edit_trip_quota" required>
					</div>
				
				<div class="form-group">
					  <label for="drivercode2">Vehicle Rate</label>
					 <input type="text" class="form-control" name="edit_vehicle_rate" id="edit_vehicle_rate" required>
					</div>
					
				<div class="form-group">
					  <label for="drivercode2">Weight Rate</label>
					 <input type="text" class="form-control" name="edit_weight_rate" id="edit_weight_rate" required>
					</div>
				
				<div class="form-group">
					  <label for="drivercode2">Excess Weight Rate</label>
					 <input type="text" class="form-control" name="edit_excess_weight_rate" id="edit_excess_weight_rate" required>
					</div>
				
				<div class="form-group">
					  <label for="drivercode2">Min Weight</label>
					 <input type="text" class="form-control" name="edit_min_weight" id="edit_min_weight" required>
					</div>
				
				<div class="form-group">
					  <label for="drivercode2">Max Weight</label>
					 <input type="text" class="form-control" name="edit_max_weight" id="edit_max_weight" required>
					</div>
				
				<div class="form-group">
					  <label for="drivercode2">UOW</label>
					 <input type="text" class="form-control" name="edit_uow" id="edit_uow" required>
					</div>
				
				
				<div class="form-group">
					  <label for="drivercode2">Volume Rate</label>
					 <input type="text" class="form-control" name="edit_volume_rate" id="edit_volume_rate" required>
					</div>
					
				<div class="form-group">
					  <label for="drivercode2">Min Volume</label>
					 <input type="text" class="form-control" name="edit_min_volume" id="edit_min_volume" required>
					</div>
				
				<div class="form-group">
					  <label for="drivercode2">UOV</label>
					 <input type="text" class="form-control" name="edit_uov" id="edit_uov" required>
					</div>
				
				
				<div class="form-group">
					  <label for="drivercode2">Currency</label>
					  <select class="form-control" name="edit_currency" id="edit_currency" required>
						<option selected="selected" value="">Choose Currency</option>
						<option value="IDR">IDR</option>
						<option value="USD">USD</option>
					  </select> 
				</div>
				
				<div class="form-group">
					  <label for="drivercode2">Drop Destination</label>
					  <input type="text" class="form-control" name="edit_drop_destination" id="edit_drop_destination" required>
					</div>
				
				
				<div class="form-group">
					  <label for="drivercode2">Drop Rate</label>
					  <input type="text" class="form-control" name="edit_drop_rate" id="edit_drop_rate" required>
					</div>
				
					
				
				<div class="form-group">
					  <label for="drivercode2">Drop Charge After</label>
					 <input type="text" class="form-control" name="edit_drop_charge_after" id="edit_drop_charge_after" required>
					</div>
				
				
				
					<div class="form-group">
					  <label for="drivercode2">Drop Rate Inner</label>
					 <input type="text" class="form-control" name="edit_drop_rate_inner" id="edit_drop_rate_inner" required>
					</div>
				
				<div class="form-group">
					  <label for="drivercode2">Drop Rate Outer	</label>
					 <input type="text" class="form-control" name="edit_drop_rate_outer" id="edit_drop_rate_outer" required>
					</div>
				
				
				<div class="form-group">
					  <label for="drivercode2">Start Valid Date</label>
						  <div class="input-group date">
						  <div class="input-group-addon">
							<i class="fa fa-calendar"></i>
						  </div>
						  <input type="text" name="edit_start_valid_date" id="edit_start_valid_date" class="form-control pull-right datepicker"  required>
						</div>
				</div>
                
				 <div class="form-group">
					  <label for="drivercode2">Expired Date</label>
						  <div class="input-group date">
						  <div class="input-group-addon">
							<i class="fa fa-calendar"></i>
						  </div>
						  <input type="text" name="edit_expired_date" id="edit_expired_date" class="form-control pull-right datepicker"  required>
						</div>
				</div>
				
				<div class="form-group">
					  <label for="drivercode2">Rate Status</label>
					  <select class="form-control" name="edit_rate_status" id="edit_rate_status" required>
						<option value="active">Active</option>
						<option value="inactive">Inactive</option>
					  </select> 
				</div>
				
				<div class="form-group">
					  <label for="drivercode2">Remark</label>
					 <textarea class="form-control" name="edit_remark" id="edit_remark" required></textarea>
				</div>
                
			  
			  
                <input type="hidden" class="form-control" name="id_transporter_rate_update" id="id_transporter_rate_update">
              
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
		<h2 id="modal1Title">Import Transporter Rate</h2>
				<form role="form" id="form_import_data" method="POST" action="<?php echo base_url()."index.php/transporter_rate/importTransporterRate" ?>" enctype="multipart/form-data">
				 <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
				 
              <div class="box-body">

				 <div class="form-group">
                      <label for="exampleInputEmail1">Choose File</label>
                      <input type="file" name="import_file" id="import_file" class="form-control" value="" />
				</div>
				
				 <div class="form-group">
                    <p><a target="_blank" href="<?php echo base_url('/files/example-files/import-transporter_rate.xlsx')?>">Download sample file import transporter_rate</a></p>
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
		<h2 id="modal1Title">Delete Transporter Rate</h2>
				<form role="form" id="form_delete_data" method="POST" action="<?php echo base_url()."index.php/transporter_rate/deleteTransporterRate" ?>" enctype="multipart/form-data">
				 <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
				 
              <div class="box-body">

				 <div class="form-group">
                     <p>Are you sure want to delete this data? (<span id="reference_delete"></span>)</p>
				</div>
				
				 <div class="form-group">
                      <input type="hidden" name="id_transporter_rate_delete" id="id_transporter_rate_delete" class="form-control" value="" />
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
		<h2 id="modal1Title">Delete Transporter Rate</h2>
				<form role="form" id="form_selected_delete_data" method="POST" action="<?php echo base_url()."index.php/transporter_rate/deleteTransporterRateAll" ?>" enctype="multipart/form-data">
				 <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
				 
              <div class="box-body">

				 <div class="form-group">
                     <p>Are you sure want to delete selected data? </p>
				</div>
				
				 <div class="form-group">
                      <input type="hidden" name="id_transporter_rate_delete_all" id="id_transporter_rate_delete_all" class="form-control" value="" />
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
				var id_transporter_rate =  $('#data_'+id+' .id_transporter_rate span').text();
				$("#reference_delete").text("ID:"+id_transporter_rate)
				$("#id_transporter_rate_delete").val(id_transporter_rate);
			});
			
			
			
			$(".edit_data").click(function(){
				var id = $(this).attr('id');
				var id_transporter_rate =  $('#data_'+id+' .id_transporter_rate span').text();
				var client_id	 =  $('#data_'+id+' .client_id ').text();
				var client_name	 =  $('#data_'+id+' .client_name ').text();
				var transporter_id	 =  $('#data_'+id+' .transporter_id ').text();
				var transporter_name	 =  $('#data_'+id+' .transporter_name ').text();
				var origin	 =  $('#data_'+id+' .origin ').text();
				var destination	 =  $('#data_'+id+' .destination ').text();
				var province	 =  $('#data_'+id+' .province ').text();
				var vehicle_type	 =  $('#data_'+id+' .vehicle_type ').text();
				var vehicle_status	 =  $('#data_'+id+' .vehicle_status ').text();
				var fixed_rate	 =  $('#data_'+id+' .fixed_rate ').text();
				var period_rate	 =  $('#data_'+id+' .period_rate ').text();
				var trip_quota	 =  $('#data_'+id+' .trip_quota ').text();
				var vehicle_rate	 =  $('#data_'+id+' .vehicle_rate ').text();
				var weight_rate	 =  $('#data_'+id+' .weight_rate ').text();
				var excess_weight_rate	 =  $('#data_'+id+' .excess_weight_rate ').text();
				var min_weight	 =  $('#data_'+id+' .min_weight ').text();
				var max_weight	 =  $('#data_'+id+' .max_weight ').text();
				var uow	 =  $('#data_'+id+' .uow ').text();
				var volume_rate	 =  $('#data_'+id+' .volume_rate ').text();
				var min_volume	 =  $('#data_'+id+' .min_volume ').text();
				var uov	 =  $('#data_'+id+' .uov ').text();
				var currency	 =  $('#data_'+id+' .currency ').text();
				var drop_destination	 =  $('#data_'+id+' .drop_destination ').text();
				var drop_rate	 =  $('#data_'+id+' .drop_rate ').text();
				var drop_charge_after	 =  $('#data_'+id+' .drop_charge_after ').text();
				var drop_rate_inner	 =  $('#data_'+id+' .drop_rate_inner ').text();
				var drop_rate_outer	 =  $('#data_'+id+' .drop_rate_outer ').text();
				var start_valid_date	 =  $('#data_'+id+' .start_valid_date ').text();
				var expired_date	 =  $('#data_'+id+' .expired_date ').text();
				var rate_status	 =  $('#data_'+id+' .rate_status ').text();
				var remark	 =  $('#data_'+id+' .remark ').text();


				$("#id_transporter_rate_update").val(id_transporter_rate);
				$("#edit_client_id").val(client_id);
				$("#edit_client_name").val(client_name);
				$("#edit_transporter_id").val(transporter_id);
				$("#edit_transporter_name").val(transporter_name);
				$("#edit_origin").val(origin);
				$("#edit_destination").val(destination);
				$("#edit_province").val(province);
				$("#edit_vehicle_type").val(vehicle_type);
				$("#edit_vehicle_status").val(vehicle_status);
				$("#edit_fixed_rate").val(fixed_rate);
				$("#edit_period_rate").val(period_rate);
				$("#edit_trip_quota").val(trip_quota);
				$("#edit_vehicle_rate").val(vehicle_rate);
				$("#edit_weight_rate").val(weight_rate);
				$("#edit_excess_weight_rate").val(excess_weight_rate);
				$("#edit_min_weight").val(min_weight);
				$("#edit_max_weight").val(max_weight);
				$("#edit_uow").val(uow);
				$("#edit_volume_rate").val(volume_rate);
				$("#edit_min_volume").val(min_volume);
				$("#edit_uov").val(uov);
				$("#edit_drop_destination").val(drop_destination);
				$("#edit_drop_rate").val(drop_rate);
				$("#edit_drop_charge_after").val(drop_charge_after);
				$("#edit_drop_rate_inner").val(drop_rate_inner);
				$("#edit_drop_rate_outer").val(drop_rate_outer);
				$("#edit_start_valid_date").val(start_valid_date);
				$("#edit_expired_date").val(expired_date);
				$("#edit_rate_status").val(rate_status);
				$("#edit_remark").val(remark);
				$('#edit_currency option[value="' + currency + '"]').prop('selected',true);
				$('#edit_vehicle_status option[value="' + vehicle_status + '"]').prop('selected',true);
				$('#edit_rate_status option[value="' + rate_status + '"]').prop('selected',true);
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
				},origin_area: {
				required: 'Origin Area must be filled!'
				},origin_address: {
				required: 'Origin Address must be filled!'
				},
				destination: {
				required: 'Destination must be filled!'
				},
				destination_address: {
				required: 'Destination Address must be filled!'
				},
				destination_area: {
				required: 'Destination Area must be filled!'
				},
				province: {
				required: 'Province must be filled!'
				},
				vehicle_type: {
				required: 'Vehicle Type must be filled!'
				},
				vehicle_status: {
				required: 'Vehicle Status must be filled!'
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
				required: 'Start Valid Date must be filled!'
				},
				expired_date: {
				required: 'Expired Date must be filled!'
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
				required: 'Vehicle Status must be filled!'
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
				required: 'Start Valid Date must be filled!'
				},
				edit_expired_date: {
				required: 'Expired Date must be filled!'
				},
				edit_remark: {
				required: 'Remark must be filled!'
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
		$("#id_transporter_rate_delete_all").val(ids);
		
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
		//auto complete Client
        $( "#search_client_id" ).autocomplete({
         source: "<?php echo BASE_URL(); ?>/index.php/json/jsonClient",  
         minLength:0,
		 select: function( event , ui ) {
			  $( "#client_id" ).val(ui.item.client_id);
			   $( "#client_name" ).val(ui.item.client_name);
			  $(this).val('');
			  return false;
			  
        }    
        })
		.autocomplete( "instance" )._renderItem = function( ul, item ) {
		  return $( "<li style='position:relative; z-index:9999;'>" )
			.append( "<div style='font-size:10px;'>" + item.label +"</div>" )
			.appendTo( ul );
		};
		
		
		//auto complete Origin
        $( "#search_origin" ).autocomplete({
         source: "<?php echo BASE_URL(); ?>/index.php/json/jsonArea",  
         minLength:0,
		 select: function( event , ui ) {
			  $( "#origin" ).val(ui.item.area_id);
			  $(this).val('');
			  return false;
			  
        }    
        })
		.autocomplete( "instance" )._renderItem = function( ul, item ) {
		  return $( "<li style='position:relative; z-index:9999;'>" )
			.append( "<div style='font-size:10px;'>" + item.label +"</div>" )
			.appendTo( ul );
		};
		
		//auto complete Destination
        $( "#search_destination" ).autocomplete({
         source: "<?php echo BASE_URL(); ?>/index.php/json/jsonArea",  
         minLength:0,
		 select: function( event , ui ) {
			  $( "#destination" ).val(ui.item.area_id);
			  $(this).val('');
			  return false;
			  
        }    
        })
		.autocomplete( "instance" )._renderItem = function( ul, item ) {
		  return $( "<li style='position:relative; z-index:9999;'>" )
			.append( "<div style='font-size:10px;'>" + item.label +"</div>" )
			.appendTo( ul );
		};
		
		
		//auto complete Vehicle Type
        $( "#search_vehicle_type" ).autocomplete({
         source: "<?php echo BASE_URL(); ?>/index.php/json/jsonVehicleType",  
         minLength:0,
		 select: function( event , ui ) {
			  $( "#vehicle_type" ).val(ui.item.vehicle_type);
			  $(this).val('');
			  return false;
			  
        }    
        })
		.autocomplete( "instance" )._renderItem = function( ul, item ) {
		  return $( "<li style='position:relative; z-index:9999;'>" )
			.append( "<div style='font-size:10px;'>" + item.label +"</div>" )
			.appendTo( ul );
		};
		
		
		//auto complete Province
        $( "#search_province" ).autocomplete({
         source: "<?php echo BASE_URL(); ?>/index.php/json/jsonProvince",  
         minLength:0,
		 select: function( event , ui ) {
			  $( "#province" ).val(ui.item.province);
			  $(this).val('');
			  return false;
			  
        }    
        })
		.autocomplete( "instance" )._renderItem = function( ul, item ) {
		  return $( "<li style='position:relative; z-index:9999;'>" )
			.append( "<div style='font-size:10px;'>" + item.label +"</div>" )
			.appendTo( ul );
		};
		
		
		
		//auto complete Province
        $( "#search_transporter_id" ).autocomplete({
         source: "<?php echo BASE_URL(); ?>/index.php/json/jsonTransporter",  
         minLength:0,
		 select: function( event , ui ) {
			  $( "#transporter_id" ).val(ui.item.transporter_id);
			   $( "#transporter_name" ).val(ui.item.transporter_name);
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

		
		
		
<script>
$('.datepicker').datepicker({
			  autoclose: true,
			  Format: 'dd-mm-yyyy'
			});
		//auto complete Client
        $( "#edit_search_client_id" ).autocomplete({
         source: "<?php echo BASE_URL(); ?>/index.php/json/jsonClient",  
         minLength:0,
		 select: function( event , ui ) {
			  $( "#edit_client_id" ).val(ui.item.client_id);
			   $( "#edit_client_name" ).val(ui.item.client_name);
			  $(this).val('');
			  return false;
			  
        }    
        })
		.autocomplete( "instance" )._renderItem = function( ul, item ) {
		  return $( "<li style='position:relative; z-index:9999;'>" )
			.append( "<div style='font-size:10px;'>" + item.label +"</div>" )
			.appendTo( ul );
		};
		
		
		//auto complete Origin
        $( "#edit_search_origin" ).autocomplete({
         source: "<?php echo BASE_URL(); ?>/index.php/json/jsonArea",  
         minLength:0,
		 select: function( event , ui ) {
			  $( "#edit_origin" ).val(ui.item.area_id);
			  $(this).val('');
			  return false;
			  
        }    
        })
		.autocomplete( "instance" )._renderItem = function( ul, item ) {
		  return $( "<li style='position:relative; z-index:9999;'>" )
			.append( "<div style='font-size:10px;'>" + item.label +"</div>" )
			.appendTo( ul );
		};
		
		//auto complete Destination
        $( "#edit_search_destination" ).autocomplete({
         source: "<?php echo BASE_URL(); ?>/index.php/json/jsonArea",  
         minLength:0,
		 select: function( event , ui ) {
			  $( "#edit_destination" ).val(ui.item.area_id);
			  $(this).val('');
			  return false;
			  
        }    
        })
		.autocomplete( "instance" )._renderItem = function( ul, item ) {
		  return $( "<li style='position:relative; z-index:9999;'>" )
			.append( "<div style='font-size:10px;'>" + item.label +"</div>" )
			.appendTo( ul );
		};
		
		
		//auto complete Vehicle Type
        $( "#edit_search_vehicle_type" ).autocomplete({
         source: "<?php echo BASE_URL(); ?>/index.php/json/jsonVehicleType",  
         minLength:0,
		 select: function( event , ui ) {
			  $( "#edit_vehicle_type" ).val(ui.item.vehicle_type);
			  $(this).val('');
			  return false;
			  
        }    
        })
		.autocomplete( "instance" )._renderItem = function( ul, item ) {
		  return $( "<li style='position:relative; z-index:9999;'>" )
			.append( "<div style='font-size:10px;'>" + item.label +"</div>" )
			.appendTo( ul );
		};
		
		
		//auto complete Province
        $( "#edit_search_province" ).autocomplete({
         source: "<?php echo BASE_URL(); ?>/index.php/json/jsonProvince",  
         minLength:0,
		 select: function( event , ui ) {
			  $( "#edit_province" ).val(ui.item.province);
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
