 <!-- HEADER -->
		<section class="content-header">
          <h1>
            Route Planning
            <small>List Of Route Planning</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="<?php echo BASE_URL(); ?>"><i class="fa fa-dashboard"></i>Home</a></li>
            <li><a href="<?php echo BASE_URL()."route_planning"; ?>"><i class="fa fa-dashboard"></i>Route Planning</a></li>
          </ol>
        </section>
  
  
   <!-- Content -->
   <section class="content">
		
		  <div class="box sms box-default color-palette-box">
            <div class="box-header with-border">
              <h3 class="box-title"><i class="fa fa-table"></i> Route Planning</h3>
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
					 
			<div id='wrapper-control-search' class='clearfix'>
					<div class="form-group search_manifest">
					  <label for="drivercode2">Delivery Date</label>
						  <div class="input-group date">
						  <div class="input-group-addon">
							<i class="fa fa-calendar click-datepicker"></i>
						  </div>
						  <input type="text" name="delivery_date" id="delivery_date" class="form-control pull-right datepicker"  required>
						
						</div>
				</div>
				
				 <div class="form-group search_manifest">
					  <label for="drivercode2">Trip</label>
					  <select class="form-control" name="trip" id="trip" required>
						<option value="1">1</option>
						<option value="2">2</option>
						<option value="3">3</option>
						<option value="4">4</option>
						<option value="5">5</option>
						<option value="6">6</option>
						<option value="7">7</option>
						<option value="8">8</option>
						<option value="9">9</option>
						<option value="10">10</option>
						<option value="11">11</option>
						<option value="12">12</option>
						<option value="13">13</option>
						<option value="14">14</option>
						<option value="15">15</option>
						<option value="16">16</option>
						<option value="17">17</option>
						<option value="18">18</option>
						<option value="19">19</option>
						<option value="20">20</option>
					  </select> 
					</div>
				
				
				<div class="form-group search_manifest">
					 <label>Client ID</label>
						<div class="input-group">
						  <div class="input-group-addon">
							<i class="fa fa-search"></i>
						  </div>
						  <input type="text" class="form-control pull-right" name="search_client_id" id="search_client_id" value=''n placeholder='Search Client ID'>
						</div>
						<!-- /.input group -->
				</div>
				
				<input type='button' class='button blue-button search_button_manifest' value='Search Manifest' id='search_manifest_button'>
				
			</div>
            <div id="wrapper-console" class="clearfix">
               
				
			
				
				
				
					
                <div id="wrapper-button-full" style='margin-top:10px; margin-bottom:10px;' class="clearfix">
					
					<a href="#" class="button orange-button">
                    	Export Route Planning
                    </a>
					<a id="confirmed_additional_cost" class="button green-button">
                    	Confirm Additional Cost
                    </a>
					<a id="confirmed_manifest" class="button green-button">
                    	Confirm Manifest
                    </a>
					
					<a id="edit_vehicle_manifest" class="button green-button">
                    	Confirm Vehicle
                    </a>
					<a id="add-data-vehicle" class="button green-button">
                    	add Manifest
                    </a>
					
					
					
                </div>
                </div>
            <div id="wrapper-console" class="clearfix"> 
           
            <div id="guest-list"> 
            <div class="grid_4 height200" id='table_drop_received'>                  
           	<table id='myTable01' class="table_manifest fancyTable table-bordered table-hover">
                    <thead>
                      <tr>
                        <th><div class="short">Action</div></th>
						<th><div class="short">SPK Number</div></th>
						<th><div class="mid">Do Number</div></th>
                        <th><div class="mid">Reference</div></th>
						<th><div class="mid">Delivery</div></th>
						<th><div class="mid">Trip</div></th>
						<th><div class="mid">Origin Name</div></th>
						<th><div class="long">Origin Address</div></th>
						<th><div class="mid">Origin Region</div></th>
						<th><div class="mid">Destination Name</div></th>
						<th><div class="mid">Destination Address</div></th>
						<th><div class="mid">Destination Region</div></th>
						<th><div class="mid">Qty</div></th>
						<th><div class="mid">Volume</div></th>
						<th><div class="mid">Weight</div></th>
						<th><div class="mid">Remark</div></th>
                      </tr>
                    </thead>
             		<tbody>
                    </tbody>       
             </table>
             </div>
			 </div>
			 
			  
			  <div id="contact-list">
			 <div class="grid_4 height200" style='margin-top:20px;'>                  
           	<table id='myTable01' class="table_transport_order fancyTable table-bordered table-hover">
                    <thead>
                      <tr>
						<th>Action</th>
                        <th>SPK Number</th>
						<th>DO Number</th>
                        <th>Reference</th>
						<th>Delivery</th>
						<th>Trip</th>
						<th>Origin Name</th>
						<th>Origin Address</th>
						<th>Origin Region</th>
						<th>Destination Name</th>
						<th>Destination Address</th>
						<th>Destination Region</th>
						<th>Qty</th>
						<th>Volume</th>
						<th>Weight</th>
						<th>Remark</th>
                      </tr>
                    </thead>
						<tbody>
						
					</tbody>
					  
             </table>
             </div>
             </div>
           </div>
            </div>
            
            </div>
      </section>
	  
	  
	  
	  <div class="remodal" data-remodal-id="modal_confirmed_additional_cost" role="dialog" aria-labelledby="modal1Titl aria-describedby="modal1Desc">
	  <button data-remodal-action="close" class="remodal-close" aria-label="Close"></button>
	  <div>
		<h2 id="modal1Title">Additional Cost</h2>
				<form role="form" id="form_confirmed_additional_cost" method="POST" action="<?php echo base_url()."index.php/route_planning/confirmedAdditionalCost" ?>" enctype="multipart/form-data">
				 <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
				 
              <div class="box-body">
				
				<input type='hidden' name='delivery_date_confirmed_additional_cost' id='delivery_date_confirmed_additional_cost'>
				<input type='hidden' name='trip_confirmed_additional_cost' id='trip_confirmed_additional_cost'>
				<input type='hidden' name='id_manifest_confirmed_additional_cost' id='id_manifest_confirmed_additional_cost'>
				<input type='hidden' name='client_id_confirmed_additional_cost' id='client_id_confirmed_additional_cost'>
				
				
				 <div class="form-group">
                  <label for="drivercode2">Rate</label>
                 <input type="text" class="form-control amount" name="rate_confirmed_additional_cost" id="rate_confirmed_additional_cost" required>
                </div>
				
				<div class="form-group">
                  <label for="drivercode2">Client Rate</label>
                 <input type="text" class="form-control amount" name="client_rate_confirmed_additional_cost" id="client_rate_confirmed_additional_cost" required>
                </div>
				
					<button type="button" class='edit_delete'>Delete</button>
					<button type="button" class='add_data'>Add</button>
						
					 <div class="box-body table clearfix">
						
						
							
						<table style='margin-top:10px;' class="po">
								<thead>
								<tr>
								<th><input class='check_all2' type='checkbox' onclick="select_all2()"/></th>
								<th>Type</th>
								<th>Amount to Client</th>
								<th>Amount to Transporter</th>
								</tr>
								</thead>
								<tbody>
								</tbody>
						</table>
						
						
					</div>
				
               
			 
              <!-- /.box-body -->

              <div class="box-footer">
                <button data-remodal-action="cancel" class="remodal-cancel">Cancel</button>
				<input type="submit" name="confirmed_vehicle" class="remodal-confirm" value="Confirmed" id="Confirmed">
              </div>
            </form>
	  </div>
	  <br>
	</div>
	</div>
	  
	  <div class="remodal" data-remodal-id="modal_confirmed_manifest" role="dialog" aria-labelledby="modal1Titl aria-describedby="modal1Desc">
	  <button data-remodal-action="close" class="remodal-close" aria-label="Close"></button>
	  <div>
		<h2 id="modal1Title">Confirmed Manifest</h2>
				<form role="form" id="form_confirmed_manifest" method="POST" action="<?php echo base_url()."index.php/route_planning/confirmedManifest" ?>" enctype="multipart/form-data">
				 <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
				 
              <div class="box-body">
				
				<input type='hidden' name='delivery_date_confirmed_manifest' id='delivery_date_confirmed_manifest'>
				<input type='hidden' name='trip_confirmed_manifest' id='trip_confirmed_manifest'>
				<input type='hidden' name='id_manifest_confirmed_manifest' id='id_manifest_confirmed_manifest'>
				<input type='hidden' name='client_id_confirmed_manifest' id='client_id_confirmed_manifest'>
				
				
				<div class="form-group">
					  <label for="drivercode2">Confirmed Manifest</label>
					  <select class="form-control" name="confirmed_manifest" id="confirmed_manifest" required>
						<option value="yes">Confirmed</option>
						<option value="no">Unconfirmed</option>
					  </select> 
				</div>
				
               
			 
              <!-- /.box-body -->

              <div class="box-footer">
                <button data-remodal-action="cancel" class="remodal-cancel">Cancel</button>
				<input type="submit" name="confirmed_vehicle" class="remodal-confirm" value="Confirmed" id="Confirmed">
              </div>
            </form>
	  </div>
	  <br>
	</div>
	
	
	   <div class="remodal" data-remodal-id="modal_edit_vehicle" role="dialog" aria-labelledby="modal1Titl aria-describedby="modal1Desc">
	  <button data-remodal-action="close" class="remodal-close" aria-label="Close"></button>
	  <div>
		<h2 id="modal1Title">Edit Vehicle ID</h2>
				
				<form role="form" id="form_edit_vehicle" method="POST" action="<?php echo base_url()."index.php/route_planning/confirmedVehicle" ?>" enctype="multipart/form-data">
				<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
				 
				<div class="box-body">
				<input type='hidden' name='delivery_date_confirmed_vehicle' id='delivery_date_confirmed_vehicle'>
				<input type='hidden' name='trip_confirmed_vehicle' id='trip_confirmed_vehicle'>
				<input type='hidden' name='id_manifest_confirmed_vehicle' id='id_manifest_confirmed_vehicle'>
				<input type='hidden' name='client_id_confirmed_vehicle' id='client_id_confirmed_vehicle'>
				<div class="left-form clearfix">
				
					<div class="form-group">
					  <label for="drivercode2">Choose Transporter</label>
					  <select class="form-control" name="transporter" id="transporter" required>
						<option value="assets">Assets</option>
						<option value="vendor">Vendor</option>
					  </select> 
					</div>
					
					<div class="form-group">
					  <label for="drivercode2">Choose Transporter</label>
					  <select class="form-control" name="vehicle_status" id="vehicle_status" required>
						<option value="oncall">On call</option>
						<option value="contract">Contract</option>
					  </select> 
					</div>
					
					
					<div class="form-group">
					 <label>Origin</label>
						<div class="input-group">
						  <div class="input-group-addon">
							<i class="fa fa-search"></i>
						  </div>
						  <input type="text" class="form-control pull-right" name="search_origin_id" id="search_origin_id" value='' placeholder='Search origin ID'>
						  <input type="text" readonly class="form-control" name="origin_id" id="origin_id" placeholder='Origin ID' required>
						  <input type="text"  class="form-control" name="origin_address" id="origin_address" placeholder='Origin Address 1' required>
						  <input type="text"  class="form-control" name="origin_area" id="origin_area" placeholder='Origin Area' required>
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
						  <input type="text"  class="form-control" name="destination_address" id="destination_address" placeholder='Destination Address 1' required>
						  <input type="text"  class="form-control" name="destination_area" id="destination_area" placeholder='Destination Area' required>
					</div>
						<!-- /.input group -->
					</div>
					
				
					
					<div class="form-group form-assets">
					 <label>Driver Belawan Indah</label>
						<div class="input-group">
						  <div class="input-group-addon">
							<i class="fa fa-search"></i>
						  </div>
						  <input type="text" class="form-control pull-right" name="search_driver" id="search_driver" value='' placeholder='Search Driver'>
						  <input type="text" readonly class="form-control" name="driver_name_assets" id="driver_name_assets" placeholder='Driver Name' required>
						  <input type="text" readonly class="form-control" name="driver_code_assets" id="driver_code_assets" placeholder='Driver Code' required>
					</div>
						<!-- /.input group -->
					</div>
					
					<div class="form-group form-vendor" >
					  <label for="drivercode2">Driver Vendor</label>
					 <input type="text"  class="form-control" name="driver_vendor" id="driver_vendor" placeholder='Driver Name'>
					 <input type="text"  class="form-control" name="driver_vendor_phone_number" id="driver_vendor_phone_number"  placeholder='Driver Phone Number'>
					</div>
					
					
					<!--<div class="form-group">
					 <label>Trucking Order</label>
						<div class="input-group">
						  <div class="input-group-addon">
							<i class="fa fa-search"></i>
						  </div>
						  <input type="text" class="form-control pull-right" name="search_trucking_order" id="search_trucking_order" value='' placeholder='Search ID Trucking Order'>
						  <input type="text" readonly class="form-control" name="id_trucking_order" id="id_trucking_order" placeholder='ID Trucking Order' required>
					</div></div>-->
						<!-- /.input group -->
					
					
					
					
					
					
					
				</div>
				
				
				<div class="right-form clearfix">
				
				<div class="form-group form-assets">
					 <label>Vehicle ID</label>
						<div class="input-group">
						  <div class="input-group-addon">
							<i class="fa fa-search"></i>
						  </div>
						  <input type="text" class="form-control pull-right" name="search_vehicle_type" id="search_vehicle_type" value='' placeholder='Search vehicle ID'>
						  <input type="text" readonly class="form-control" name="vehicle_id_assets" id="vehicle_id_assets" placeholder='Vehicle ID'>
						  <input type="text" readonly class="form-control" name="vehicle_type_assets" id="vehicle_type_assets" placeholder='Vehicle Type'>
						  <input type="hidden" readonly class="form-control" name="vehicle_type_id_assets" id="vehicle_type_id_assets" placeholder='Vehicle Type ID'>
						  
					</div>
						<!-- /.input group -->
				</div>
				
				

				<div class="form-group form-vendor">
					  <label for="drivercode2 ">Vehicle ID</label>
					  <input type="text"  class="form-control" name="vehicle_id_vendor" id="vehicle_id_vendor"  placeholder='Vehicle ID'>
					</div>
				
				
				
				<div class="form-group form-vendor">
					 <label>Vehicle Type</label>
						<div class="input-group">
						  <div class="input-group-addon">
							<i class="fa fa-search"></i>
						  </div>
						  <input type="text" class="form-control pull-right" name="search_vehicle_type_vendor" id="search_vehicle_type_vendor" value='' placeholder='Search vehicle Type'>
						  <input type="text" readonly class="form-control" name="vehicle_type_vendor" id="vehicle_type_vendor" placeholder='vehicle Type'>
						  <input type="hidden" readonly class="form-control" name="vehicle_type_id_vendor" id="vehicle_type_id_vendor" placeholder='Vehicle Type ID'>
						  
					</div>
						<!-- /.input group -->
				</div>
				
				
				<div class="form-group form-vendor">
					 <label>Transporter</label>
						<div class="input-group">
						  <div class="input-group-addon">
							<i class="fa fa-search"></i>
						  </div>
						  <input type="text" class="form-control pull-right" name="search_transporter" id="search_transporter" value='' placeholder='Search Transporter'>
						  <input type="text" readonly class="form-control" name="transporter_id" id="transporter_id" placeholder='Transporter ID' required>
						  <input type="text" readonly class="form-control" name="transporter_name" id="transporter_name" placeholder='Transporter Name' required>
					</div>
						<!-- /.input group -->
				</div>
				
				
				
					
					<div class="form-group">
					  <label for="drivercode2">Client</label>
					  <input type="text"  class="form-control" readonly name="client_name" id="client_name"  placeholder='Client Name'>
					</div>
					
					<div class="form-group">
					  <label for="drivercode2">Mode</label>
					  <select class="form-control" name="mode" id="mode" required>
						<option value="land">Land</option>
						<option value="sea">Sea</option>
						<option value="train">Train</option>
						<option value="air">Air</option>
					  </select> 
					</div>
					
					<div class="form-group">
					  <label for="drivercode2">Seal Number</label>
					  <input type="text"  class="form-control" name="seal_number" id="seal_number"  placeholder='Seal Number'>
					</div>
					
					<div class="form-group">
					  <label for="drivercode2">Cont Number</label>
					  <input type="text"  class="form-control" name="cont_number" id="cont_number"  placeholder='Container Number'>
					</div>
					
					<div class="form-group">
					  <label for="drivercode2">Volume Cap</label>
					  <input type="text"  class="form-control" name="volume_cap" id="volume_cap"  placeholder='Volume Capacity'>
					</div>
				
				<div class="form-group">
					  <label for="drivercode2">weight Cap</label>
					  <input type="text"  class="form-control" name="weight_cap" id="weight_cap"  placeholder='Weight Capacity'>
					</div>
				
				
				
				<div class="form-group">
					  <label for="drivercode2">Remark</label>
					  <input type="text"  class="form-control" name="remark" id="remark"  placeholder='Remark'>
					</div>
				</div>
				
				
				
               
			 
              
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button data-remodal-action="cancel" class="remodal-cancel">Cancel</button>
				<input type="submit" name="confirmed_vehicle" class="remodal-confirm" value="Confirmed Vehicle" id="Confirmed">
              </div>
            </form>
	  </div>
	  <br>
	</div>
	
	
	   <div class="remodal" data-remodal-id="modal_add_vehicle" role="dialog" aria-labelledby="modal1Titl aria-describedby="modal1Desc">
	   <button data-remodal-action="close" class="remodal-close" aria-label="Close"></button>
	   <div>
	   <h2 id="modal1Title">Add Vehicle</h2>
			
              <div class="box-body">
					
			   <input type="text" name="search_vehicle" id="search_vehicle"> <input class='button green-button' type='button' name='search' value='Search Vehicle' id='search_button_vehicle'>
			   <div class="grid_4 height200 table" style='margin-top:20px;'>                  
					<table id="table_add_vehicle" class="">
					<thead>
						<tr>
							<th>Vehicle ID</th>
							<th>Vehicle Type</th>
							<th>Description</th>
						<tr>
					</thead>
					<tbody>
						
					</tbody>
					</table>
				</div>
               
              
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button data-remodal-action="cancel" class="remodal-cancel">Cancel</button>
				<input type="submit" name="submit_add" class="remodal-confirm" value="Submit" id="submit_add_manifest">
              </div>
	  </div>
	  <br>
	  
	</div>
	</div>  
<script>

$.urlParam = function(name){
		var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
		if (results==null){
		   return null;
		}
		else{
		   return results[1] || 0;
		}
		};
		
delivery_date_url = $.urlParam('delivery_date'); // name
trip_url = $.urlParam('trip'); // name
client_id_url = $.urlParam('client_id');
if(delivery_date_url==null)
{
	var client_id_url = '';
	var trip_url = 1;
	var fullDate = new Date();
	var twoDigitMonth = fullDate.getMonth()+1+"";if(twoDigitMonth.length==1)	twoDigitMonth="0" +twoDigitMonth;
	var twoDigitDate = fullDate.getDate()+"";if(twoDigitDate.length==1)	twoDigitDate="0" +twoDigitDate;
	var currentYear = fullDate.getFullYear();
	var date_show = twoDigitDate+'-'+twoDigitMonth+'-'+currentYear;
	var date =  twoDigitDate+'-'+twoDigitMonth+'-'+currentYear;
	$("#delivery_date").val(date);
	date = date.split('-');
	callTransportOrder(trip_url,date,client_id_url);
	callManifest(trip_url,date,client_id_url);

	$(".table_manifest tbody tr").remove(); 
	$(".table_transport_order tbody tr").remove(); 
	
}
else
{
	if(client_id_url==0){client_id_url='';}
	$("#delivery_date").val(delivery_date_url);
	var delivery_date_url =  delivery_date_url.split('-');
	callTransportOrder(trip_url,delivery_date_url,client_id_url);
	callManifest(trip_url,delivery_date_url,client_id_url);

	$(".table_manifest tbody tr").remove(); 
	$(".table_transport_order tbody tr").remove(); 
}




$('.datepicker').datepicker({
			  autoclose: true,
			  Format: 'dd-mm-yyyy',
});

$( "#search_manifest_button" ).click(function() {
        
		var trip = $("#trip").val();
		var client_id = $("#search_client_id").val();
		var delivery_date =  $("#delivery_date").val().split('-');
		
		callTransportOrder(trip,delivery_date,client_id);
		callManifest(trip,delivery_date,client_id);
		
		$(".table_manifest tbody tr").remove(); 
		$(".table_transport_order tbody tr").remove(); 
		
		
});


$('.datepicker').datepicker()
    .on('changeDate', function(e){
        
		var trip = $("#trip").val();
		var client_id = $("#search_client_id").val();
		var delivery_date =  $("#delivery_date").val().split('-');
		
		callTransportOrder(trip,delivery_date,client_id);
		callManifest(trip,delivery_date,client_id);
		
		$(".table_manifest tbody tr").remove(); 
		$(".table_transport_order tbody tr").remove(); 
		
		
});


function callManifest(trip,delivery_date,client_id){
	
		var delivery_date = delivery_date[2]+'-'+delivery_date[1]+'-'+delivery_date[0];
		$.ajax({
		  url: '<?php echo BASE_URL(); ?>index.php/json/jsonManifestRoutePlanning?delivery_date='+delivery_date+'&&trip='+trip+'&&client_id='+client_id,
		  success: function(data,status)
		  {
			createTableManifest(data);
		  },
		  async:   true,
		  dataType: 'json'
		}); 
		
}



function callTransportOrder(trip,delivery_date,client_id){
	
		var delivery_date = delivery_date[2]+'-'+delivery_date[1]+'-'+delivery_date[0];
		
		$.ajax({
		  url: '<?php echo BASE_URL(); ?>index.php/json/jsonTransportOrderRoutePlanning?delivery_date='+delivery_date+'&&trip='+trip+'&&client_id='+client_id,
		  success: function(data,status)
		  {
			createTableTransportOrder(data);
		  },
		  async:   true,
		  dataType: 'json'
		}); 
}




function createTableTransportOrder(data)
{
  for(var i=0; i<data.length;i++)
  {
	 
		$(".table_transport_order tbody").append("<tr spk_number='"+data[i]['spk_number']+"' class='drag draggable "+data[i]['spk_number']+" '>"+
													"<td><div class='delete_transport_order' confirmed_manifest='no' manifest='"+data[i]['manifest']+"' spk_number='"+data[i]['spk_number']+"' >Unroute</div></td>"+
													"<td>"+data[i]['spk_number']+"</td>"+
													"<td>"+data[i]['do_number']+"</td>"+
													"<td>"+data[i]['reference']+"</td>"+
													"<td>"+data[i]['delivery_date']+"</td>"+
													"<td>"+data[i]['trip']+"</td>"+
													"<td>"+data[i]['origin_id']+"</td>"+
													"<td>"+data[i]['origin_address']+"</td>"+
													"<td>"+data[i]['origin_area']+"</td>"+
													"<td>"+data[i]['destination_id']+"</td>"+
													"<td>"+data[i]['destination_address']+"</td>"+
													"<td>"+data[i]['destination_area']+"</td>"+
													"<td>"+data[i]['qty']+"</td>"+
													"<td>"+data[i]['volume']+"</td>"+
													"<td>"+data[i]['weight']+"</td>"+
													"<td>"+data[i]['remark']+"</td>"+
													"</tr>");
													var c = {};
													$("#contact-list tr").draggable({
															helper: "clone",
															start: function(event, ui) {
																c.tr = this;
																c.helper = ui.helper;
															}
													});
  }
 
}



function createTableManifest(data)
{
  for(var i=0; i<data.length;i++)
  {
				var transporter_tipe = data[i]['transporter'];
				if(transporter_tipe=='assets')
				{ var transporter = 'Assets'; }
				else if(transporter_tipe=='vendor')
				{ var transporter = data[i]['transporter_id']; }
				$("#table_drop_received tbody").append("<tr class='tr droppable' manifest='"+data[i]['manifest']+"' >"+
					"<td><div class='delete_manifest short' confirmed_manifest='"+data[i]['confirmed_manifest']+"' manifest='"+data[i]['manifest']+"'>Delete</div></td><td colspan='16' manifest='"+data[i]['manifest']+"' class='"+data[i]['manifest']+" vehicle_color '>Manifest ID - "+data[i]['manifest']+" - "+data[i]['vehicle_id']+" "+transporter+" - "+data[i]['vehicle_type']+" - "+data[i]['destination_area']+" <a href='<?php echo BASE_URL(); ?>index.php/route_planning/exportSPkDriver?id="+data[i]['manifest']+"'>Print SPK Pengemudi</a></td>"+
					"</tr>");
					
					
					
					$(".tr.droppable").droppable({
									hoverClass: 'hovered',
									drop: function(event, ui) {
										var spk_number = ui.draggable.attr("spk_number");
										var delivery_date = $('#delivery_date').val();
										var trip = $('#trip').val();
										var manifest = $(this).attr("manifest");
										var xhr = "<?php echo $this->security->get_csrf_hash();?>";
										$.ajax({
											type: "POST",
											url: "<?php echo BASE_URL(); ?>index.php/route_planning/updateManifest",
											data:{ <?php echo $this->security->get_csrf_token_name(); ?>:xhr,spk_number : spk_number,manifest : manifest,trip : trip,delivery_date : delivery_date},
											error: function() {
											alert("Upload Data Error");
											},
											success: function(data){
												
													var status = $(data).filter('div#message').text();
					
													if(status=='sukses')
													{
														
															$("#table_drop_received tbody tr[manifest='"+manifest+"'] ")
																.after(ui.helper.clone(false).css({
																position: 'relative',
																left: '0px',
																top: '0px'
															}));
															
															$("#contact-list tr[spk_number='"+spk_number+"'] ").remove();
													}
													else if(status=='beda'){
														alert("Sorry you enter different client data!");
													}
													else{
														alert("failed to save Data!");
													}
												
												
											}
										})
										
										
										
										
										
							}});
							callTransportOrderManifest(data[i]['trip'],data[i]['delivery_date'],data[i]['manifest'],data[i]['confirmed_manifest']);
							
							
  }
 
}

function callTransportOrderManifest(trip,delivery_date,manifest,status_confirmed){
		
		var delivery_date =  $("#delivery_date").val().split('-');
		var delivery_date = delivery_date[2]+'-'+delivery_date[1]+'-'+delivery_date[0];
		
		$.ajax({
		  url: '<?php echo BASE_URL(); ?>index.php/json/jsonTransportOrderManifestRoutePlanning?delivery_date='+delivery_date+'&&trip='+trip+'&&manifest='+manifest,
		  success: function(data,status)
		  {
			createTransportOrderManifest(data,status_confirmed);
		  },
		  async:   true,
		  dataType: 'json'
		}); 
}



function createTransportOrderManifest(data,status_confirmed)
{
  for(var i=0; i<data.length;i++)
  {
		$("#table_drop_received tbody tr[manifest='"+data[i]['manifest']+"']").after("<tr spk_number='"+data[i]['spk_number']+"' class='drag draggable "+data[i]['spk_number']+" '>"+
													"<td><div class='delete_transport_order short' confirmed_manifest='"+status_confirmed+"' manifest='"+data[i]['manifest']+"' spk_number='"+data[i]['spk_number']+"' >Unroute</div></td>"+
													"<td>"+data[i]['spk_number']+"</td>"+
													"<td>"+data[i]['do_number']+"</td>"+
													"<td>"+data[i]['reference']+"</td>"+
													"<td>"+data[i]['delivery_date']+"</td>"+
													"<td>"+data[i]['trip']+"</td>"+
													"<td>"+data[i]['origin_id']+"</td>"+
													"<td>"+data[i]['origin_address']+"</td>"+
													"<td>"+data[i]['origin_area']+"</td>"+
													"<td>"+data[i]['destination_id']+"</td>"+
													"<td>"+data[i]['destination_address']+"</td>"+
													"<td>"+data[i]['destination_area']+"</td>"+
													"<td>"+data[i]['qty']+"</td>"+
													"<td>"+data[i]['volume']+"</td>"+
													"<td>"+data[i]['weight']+"</td>"+
													"<td>"+data[i]['remark']+"</td>"+
													"</tr>");
													var c = {};
													$("#contact-list tr").draggable({
															helper: "clone",
															start: function(event, ui) {
																c.tr = this;
																c.helper = ui.helper;
															}
													});
  }
 
}
			
			

var c = {};
$("#contact-list tr").draggable({
        helper: "clone",
        start: function(event, ui) {
            c.tr = this;
            c.helper = ui.helper;
        }
});


$(".droppable").droppable({
    drop: function(event, ui) {
    }
   });


   
$("#add-data-vehicle").click(function(){
	
	var delivery_date = $("#delivery_date").val();
	if(delivery_date!='')
	{
		$('[data-remodal-id = modal_add_vehicle]').remodal().open();
		$("#table_add_vehicle tbody tr").remove(); 
	}
	else{
		
		alert("Please Select Date First!");
		$("#delivery_date").focus();
	}
	

	
	
});

$( "#guest-list" ).on( "click", ".delete_manifest", function() {
	
	var confirmed_manifest = $(this).attr('confirmed_manifest');
	
	
	if(confirmed_manifest!='yes')
	{
		if (confirm('Delete Manifest?')) {
			
			var manifest = $(this).attr('manifest');
			var xhr = "<?php echo $this->security->get_csrf_hash();?>";
			$.ajax({
				type: "POST",
				url: "<?php echo BASE_URL(); ?>index.php/route_planning/deleteManifest",
				data:{ <?php echo $this->security->get_csrf_token_name(); ?>:xhr,manifest : manifest},
				error: function() {
				alert("Upload Data Error");
				},
					success: function(data){
					
					var status = $(data).filter('div#message').text();
					
					var trip = $("#trip").val();
					var delivery_date =  $("#delivery_date").val().split('-');
					var client_id =  $("#search_client_id").val();
					callTransportOrder(trip,delivery_date,client_id);
					callManifest(trip,delivery_date,client_id);
					
					$(".table_manifest tbody tr").remove(); 
					$(".table_transport_order tbody tr").remove(); 
					
				}
			})
		}
	}
	else{alert("The manifest has been confirmed");}
	
	
});



	


$( "#guest-list" ).on( "click", ".delete_transport_order", function() {
	
	var confirmed_manifest = $(this).attr('confirmed_manifest');
	
	
	if(confirmed_manifest!='yes')
	{
	if (confirm('unroute Transport Order?')) {
		
		var manifest = $(this).attr('manifest');
		var spk_number = $(this).attr('spk_number');
		
		var xhr = "<?php echo $this->security->get_csrf_hash();?>";
		$.ajax({
			type: "POST",
			url: "<?php echo BASE_URL(); ?>index.php/route_planning/deleteTransportOrder",
			data:{ <?php echo $this->security->get_csrf_token_name(); ?>:xhr,manifest : manifest,spk_number : spk_number},
			error: function() {
			alert("Upload Data Error");
			},
				success: function(data){
				var status = $(data).filter('div#message').text();
				var trip = $("#trip").val();
				var delivery_date =  $("#delivery_date").val().split('-');
				callTransportOrder(trip,delivery_date);
				callManifest(trip,delivery_date);
				
				$(".table_manifest tbody tr").remove(); 
				$(".table_transport_order tbody tr").remove(); 
				
			}
		})
		
		
	
	}
	
	}
	else{alert("The manifest has been confirmed");}
	
	
});




$("#search_button_vehicle").click(function(){
	$("#table_add_vehicle tbody tr").remove(); 
	var vehicle_id = $("#search_vehicle").val();
	
	$.ajax({
      url: '<?php echo BASE_URL(); ?>index.php/json/jsonMasterUnitRoutePlanning?search='+vehicle_id,
      success: function(data,status)
      {
        createTableByForLoop(data);
      },
      async:   true,
      dataType: 'json'
    }); 
	
	
});

function createTableByForLoop(data)
{
  for(var i=0; i<data.length;i++)
  {
									  $("#table_add_vehicle tbody").append("<tr id_master_unit='"+data[i]['id_master_unit']+"' >"+
									  "<td id_master_unit='"+data[i]['id_master_unit']+"' class='vehicle_id "+data[i]['id_master_unit']+"'>"+data[i]['vehicle_id']+"</td>"+
									  "<td id_master_unit='"+data[i]['id_master_unit']+"' class='vehicle_type "+data[i]['id_master_unit']+"'>"+data[i]['vehicle_type']+"</td>"+
							          "<td id_master_unit='"+data[i]['id_master_unit']+"' class='description "+data[i]['id_master_unit']+"'>"+data[i]['description']+"</td>"+
						              "</tr>");
  }
 
}
 




$( "#table_add_vehicle" ).on( "click", "tr", function() {
	$(this).toggleClass("active");
})

$( "#guest-list" ).on( "click", ".vehicle_color ", function() {
	var manifest = $(this).attr('manifest');
	$('#guest-list .vehicle_color').removeClass('edit_vehicle_id');
	$("."+manifest+".vehicle_color").addClass('edit_vehicle_id');
})

$( "#transporter" ).change(function() {
  
	var transporter_status = $(this).val();
			  if(transporter_status=='assets')
			  {
				 $('.form-assets').show();
				 $('.form-vendor').hide();
			  }
			  else if(transporter_status=='vendor')
			  {
				  $('.form-assets').hide();
				  $('.form-vendor').show();
			  }
				
			
});
			
$("#confirmed_manifest").click(function(){
	
		var manifest = $('.edit_vehicle_id').attr('manifest');
		var delivery_date = $('#delivery_date').val();
		var trip = $('#trip').val();
		var client_id = $('#search_client_id').val();
		
		$("#delivery_date_confirmed_manifest").val(delivery_date);
		$("#trip_confirmed_manifest").val(trip);
		$("#client_id_confirmed_manifest").val(client_id);
		$("#id_manifest_confirmed_manifest").val(manifest);
		
		$.ajax({
		  url: '<?php echo BASE_URL(); ?>index.php/json/jsonManifest?manifest='+manifest,
		  success: function(data,status)
		  {
			
			var status_manifest = data[0]['status_manifest'];
			var client_name = data[0]['client_name'];
			var id_manifest = data[0]['id_manifest'];
			var driver_code = data[0]['driver_code'];
			var driver_name = data[0]['driver_name'];
			var driver_phone_number = data[0]['driver_phone_number'];
			var transporter = data[0]['transporter'];
			var transporter_id = data[0]['transporter_id'];
			var transporter_name = data[0]['transporter_name'];
			var client_id = data[0]['client_id'];
			var volume_cap = data[0]['volume_cap'];
			var weight_cap = data[0]['weight_cap'];
			var remark = data[0]['remark'];
			var vehicle_id = data[0]['vehicle_id'];
			var description = data[0]['description'];
			var vehicle_type = data[0]['vehicle_type'];
			var trip = data[0]['trip'];
			var client_id = data[0]['client_id'];
			var delivery_date = data[0]['delivery_date'];
			var origin_id = data[0]['origin_id'];
			var origin_address = data[0]['origin_address'];
			var origin_area = data[0]['origin_area'];
			var destination_id = data[0]['destination_id'];
			var destination_address = data[0]['destination_address'];
			var destination_area = data[0]['destination_area'];
			var confirmed_vehicle = data[0]['confirmed_vehicle'];
			var confirmed_manifest = data[0]['confirmed_manifest'];
			var confirmed_rate = data[0]['confirmed_rate'];
			
			
			
				if(confirmed_vehicle=='yes')
				{	
					i	
					$("#form_confirmed_manifest").trigger('reset');
					$('[data-remodal-id = modal_confirmed_manifest]').remodal().open();
					$('#confirmed_manifest option[value="' + confirmed_manifest + '"]').prop('selected',true);
					
					
					
				}
				else
				{
					$("#form_confirmed_manifest").trigger('reset');				
					alert("Please confirmed Vehicle before!"); 
				}
				
			
			
			
		  },
		 async:   true,
		  dataType: 'json'
		}); 
		
		
		
});





$("#confirmed_additional_cost").click(function(){
		
		$(".po tbody tr").remove();  
		var manifest = $('.edit_vehicle_id').attr('manifest');
		var delivery_date = $('#delivery_date').val();
		var trip = $('#trip').val();
		var client_id = $('#search_client_id').val();
		$("#form_confirmed_additional_cost").trigger('reset');
		$("#delivery_date_confirmed_additional_cost").val(delivery_date);
		$("#trip_confirmed_additional_cost").val(trip);
		$("#id_manifest_confirmed_additional_cost").val(manifest);
		$("#client_id_confirmed_additional_cost").val(client_id);
		
		$.ajax({
		  url: '<?php echo BASE_URL(); ?>index.php/json/jsonManifest?manifest='+manifest,
		  success: function(data,status)
		  {
			var status_manifest = data[0]['status_manifest'];
			var client_name = data[0]['client_name'];
			var id_manifest = data[0]['id_manifest'];
			var driver_code = data[0]['driver_code'];
			var driver_name = data[0]['driver_name'];
			var driver_phone_number = data[0]['driver_phone_number'];
			var transporter = data[0]['transporter'];
			var transporter_id = data[0]['transporter_id'];
			var transporter_name = data[0]['transporter_name'];
			var client_id = data[0]['client_id'];
			var volume_cap = data[0]['volume_cap'];
			var weight_cap = data[0]['weight_cap'];
			var remark = data[0]['remark'];
			var vehicle_id = data[0]['vehicle_id'];
			var description = data[0]['description'];
			var vehicle_type = data[0]['vehicle_type'];
			var trip = data[0]['trip'];
			var client_id = data[0]['client_id'];
			var delivery_date = data[0]['delivery_date'];
			var origin_id = data[0]['origin_id'];
			var origin_address = data[0]['origin_address'];
			var origin_area = data[0]['origin_area'];
			var destination_id = data[0]['destination_id'];
			var destination_address = data[0]['destination_address'];
			var destination_area = data[0]['destination_area'];
			var confirmed_vehicle = data[0]['confirmed_vehicle'];
			var confirmed_manifest = data[0]['confirmed_manifest'];
			var confirmed_rate = data[0]['confirmed_rate'];
			var rate = data[0]['rate'];
			var client_rate = data[0]['client_rate'];
			
			
			if(confirmed_vehicle=='yes')
			{	
				
					
			if(confirmed_manifest=='yes')
			{
					$("#rate_confirmed_additional_cost").val(rate);
					$("#client_rate_confirmed_additional_cost").val(client_rate);
					
					
					$.ajax({
					  url: '<?php echo BASE_URL(); ?>index.php/json/jsonAdditionalCost?id_manifest='+id_manifest,
					  success: function(data,status)
					  {
						$("table.po tbody tr").remove();  
						createTableDetail(data);
					  },
					  async:   true,
					  dataType: 'json'
					});
				
				$('[data-remodal-id = modal_confirmed_additional_cost]').remodal().open();
				
			}
			else{
				
				alert("Please confirmed Manifest before!"); 
			}
				
				
			}
			else
			{
				$("#form_confirmed_manifest").trigger('reset');				
				alert("Please confirmed Vehicle before!"); 
			}
			
			
			
		  },
		 async:   true,
		  dataType: 'json'
		}); 
		
		
		
});

function createTableDetail(data)
			{
			  for(var i=0; i<data.length;i++)
			  {
					var no = i + 1;
					
					$(".po tbody").append("<tr><td><input type='checkbox' class='edit_case'/></td>"+
											 "<td><select  name='additional_type[]' class='additional_type "+no+" '>"+
											 "<option value='Loading Charge'>Loading Charge</option>"+
											 "<option value='Unloading Charge'>Unloading Charge</option>"+
											 "<option value='Over Night'>Over Night</option>"+
											 "<option value='Lolo'>Lolo</option>"+
											 "<option value='Community Issue'>Community Issue</option>"+
											 "<option value='Escourting'>Escourting</option>"+
											 "<option value='Multidrop Inner City'>Multidrop Inner City</option>"+
											 "<option value='Multidrop Outer City'>Multidrop Outer City</option>"+
											 "</select></td>"+
											 "<td><input type='text' class='amount' name='amount_to_client[]' value='"+data[i]['amount_to_client']+"'/></td>"+
											 "<td><input type='text' class='description' name='amount_to_transporter[]' value='"+data[i]['amount_to_transporter']+"'/></td>"+
											 "</tr>");
											 
					$('.additional_type.'+no+' option[value="'+data[i]['additional_type']+'"]').prop('selected',true);
			  }
			 
	}

$("#edit_vehicle_manifest").click(function(){
		
		var manifest = $('.edit_vehicle_id').attr('manifest');
		var delivery_date = $('#delivery_date').val();
		var trip = $('#trip').val();
		var client_id = $('#search_client_id').val();
		
		$("#delivery_date_confirmed_vehicle").val(delivery_date);
		$("#trip_confirmed_vehicle").val(trip);
		$("#client_id_confirmed_vehicle").val(client_id);
		$("#id_manifest_confirmed_vehicle").val(manifest);
		
		$.ajax({
		  url: '<?php echo BASE_URL(); ?>index.php/json/jsonManifest?manifest='+manifest,
		  success: function(data,status)
		  {
			
			var status_manifest = data[0]['status_manifest'];
			var id_trucking_order = data[0]['id_trucking_order'];
			var client_name = data[0]['client_name'];
			var id_manifest = data[0]['id_manifest'];
			var driver_code = data[0]['driver_code'];
			var driver_name = data[0]['driver_name'];
			var driver_phone_number = data[0]['driver_phone_number'];
			var transporter = data[0]['transporter'];
			var transporter_id = data[0]['transporter_id'];
			var transporter_name = data[0]['transporter_name'];
			var client_id = data[0]['client_id'];
			var volume_cap = data[0]['volume_cap'];
			var weight_cap = data[0]['weight_cap'];
			var remark = data[0]['remark'];
			var vehicle_id = data[0]['vehicle_id'];
			var vehicle_status = data[0]['vehicle_status'];
			var description = data[0]['description'];
			var vehicle_type = data[0]['vehicle_type'];
			var trip = data[0]['trip'];
			var client_id = data[0]['client_id'];
			var delivery_date = data[0]['delivery_date'];
			var origin_id = data[0]['origin_id'];
			var origin_address = data[0]['origin_address'];
			var origin_area = data[0]['origin_area'];
			var destination_id = data[0]['destination_id'];
			var destination_address = data[0]['destination_address'];
			var destination_area = data[0]['destination_area'];
			var mode = data[0]['mode'];
			var seal_number = data[0]['seal_number'];
			var cont_number = data[0]['cont_number'];
			var confirmed_manifest = data[0]['confirmed_manifest'];
			
			if(confirmed_manifest!='yes')
			{
						if(status_manifest=='yes_route')
						{	
							$("#form_edit_vehicle").trigger('reset');
							$('[data-remodal-id = modal_edit_vehicle]').remodal().open();
							
							$("#id_trucking_order").val(id_trucking_order);
							
							$('#transporter option[value="' + transporter + '"]').prop('selected',true);
							$('#vehicle_status option[value="' + vehicle_status + '"]').prop('selected',true);
							$("#client_name").val(client_name);
							$("#origin_id").val(origin_id);
							$("#origin_address").val(origin_address);
							$("#origin_area").val(origin_area);
							$("#destination_id").val(destination_id);
							$("#destination_address").val(destination_address);
							$("#destination_area").val(destination_area);
							$("#driver_name_assets").val(driver_name);
							$("#driver_code_assets").val(driver_code);
							$("#driver_vendor").val(driver_name);
							$("#driver_vendor_phone_number").val(driver_phone_number);
							$("#vehicle_id_assets").val(vehicle_id);
							$("#vehicle_id_vendor").val(vehicle_id);
							$("#vehicle_type_assets").val(vehicle_type);
							$("#transporter_id").val(transporter_id);
							$("#transporter_name").val(transporter_name);
							$("#volume_cap").val(volume_cap);
							$("#weight_cap").val(weight_cap);
							$("#remark").val(remark);
							$("#vehicle_type_vendor").val(vehicle_type);
							$("#vehicle_type_id_vendor").val(vehicle_type);
							$("#seal_number").val(seal_number);
							$("#cont_number").val(cont_number);
							
							
							$('#mode option[value="' + mode + '"]').prop('selected',true);
							
							if(transporter=='' || transporter=='assets')
							{
								$('.form-assets').show();$('.form-vendor').hide();
							}
							else
							{
								$('.form-assets').hide();$('.form-vendor').show();
							}
							
						}
						else
						{
						
						$("#form_edit_vehicle").trigger('reset');				
						alert("Please Insert Route before!"); }
			}
			else
			{
				alert("The manifest has been confirmed!");
			}
			
		  },
		 async:   true,
		  dataType: 'json'
		}); 
		
});

$("#submit_add_manifest").click(function(){
	
	$('[data-remodal-id = modal_add_vehicle]').remodal().close();
	
	$( "tr.active" ).each(function( index ) {
		
		var id_master_unit = $(this).attr('id_master_unit');
		
		var delivery_date = $('#delivery_date').val();
		var trip = $('#trip').val();
		var vehicle_id = $('.vehicle_id.'+id_master_unit).text();
		var vehicle_type = $('.vehicle_type.'+id_master_unit).text();
		var description = $('.description.'+id_master_unit).text();
		var xhr = "<?php echo $this->security->get_csrf_hash();?>";
			$.ajax({
			type: "POST",
			url: "<?php echo BASE_URL(); ?>index.php/route_planning/saveManifest",
			data:{ <?php echo $this->security->get_csrf_token_name(); ?>:xhr,delivery_date : delivery_date,trip : trip,vehicle_id : vehicle_id,vehicle_type : vehicle_type,description : description},
			error: function() {
			alert("Upload Data Error");
			},
			success: function(data){
				
					var status = $(data).filter('div#message').text();
					
					if(status=='sukses')
					{
					var manifest = parseInt($(data).filter('div#manifest').text());
					var manifest = manifest;
					$("#table_drop_received tbody").append("<tr class='tr droppable' manifest='"+manifest+"' >"+
					"<td><div class='delete_manifest short' confirmed_manifest='no' manifest='"+manifest+"'>Delete</div></td><td manifest='"+manifest+"' colspan='16' class='"+manifest+" vehicle_color '>Manifest ID - "+manifest+"  - "+vehicle_id+"  - "+vehicle_type+"  - .. </td>"+
					"</tr>");
					
					$(".tr.droppable").droppable({
									hoverClass: 'hovered',
									drop: function(event, ui) {
										
										var spk_number = ui.draggable.attr("spk_number");
										var delivery_date = $('#delivery_date').val();
										var trip = $('#trip').val();
										var manifest = $(this).attr("manifest");
										var xhr = "<?php echo $this->security->get_csrf_hash();?>";
										
										
										
										$.ajax({
											type: "POST",
											url: "<?php echo BASE_URL(); ?>index.php/route_planning/updateManifest",
											data:{ <?php echo $this->security->get_csrf_token_name(); ?>:xhr,spk_number : spk_number,manifest : manifest,trip : trip,delivery_date : delivery_date},
											error: function() {
											alert("Upload Data Error");
											},
											success: function(data){
												
													var status = $(data).filter('div#message').text();
					
													if(status=='sukses')
													{
														
															$("#table_drop_received tbody  ")
																.append(ui.helper.clone(false).css({
																position: 'relative',
																left: '0px',
																top: '0px'
															}));
													}
													
													else{
														alert("failed to save Data!");
													}
												
												
											}
										})
										
									 
										
									
										
							}});
					}
					else
					{alert("Sorry,Data inputs already exist");}
				
				
			}
		})
		
		
		
		
	

	});
	
	
});
</script>
	
<script>
		//auto complete Origin
		var term = $("#search_origin_id").val();
        $( "#search_origin_id" ).autocomplete({
         source: "<?php echo BASE_URL(); ?>index.php/json/jsonArea",   
         minLength:0,
		 select: function( event , ui ) {
			  $( "#origin_id" ).val( ui.item.area_id );
			 //$( "#origin_address" ).val( ui.item.customer_address_1 );
			 // $( "#origin_area" ).val( ui.item.area );
			 
        }    
        })
		.autocomplete( "instance" )._renderItem = function( ul, item ) {
		  return $( "<li style='position:relative; z-index:9999;'>" )
			.append( "<div style='font-size:10px;'>" + item.label+"</div>" )
			.appendTo( ul );
		};
		
		
		//auto complete Origin
		var term = $("#search_destination").val();
        $( "#search_destination" ).autocomplete({
        source: "<?php echo BASE_URL(); ?>index.php/json/jsonArea",   
         minLength:0,
		 select: function( event , ui ) {
			  $( "#destination_id" ).val( ui.item.area_id );
			  //$( "#destination_address" ).val( ui.item.customer_address_1 );
			//  $( "#destination_area" ).val( ui.item.area );
			 
        }    
        })
		.autocomplete( "instance" )._renderItem = function( ul, item ) {
		  return $( "<li style='position:relative; z-index:9999;'>" )
			.append( "<div style='font-size:10px;'>" + item.label+"</div>" )
			.appendTo( ul );
		};
		
		
		
		//auto complete Destination
		var term = $("#search_vehicle_type").val();
        $( "#search_vehicle_type" ).autocomplete({
         source: "<?php echo BASE_URL(); ?>index.php/json/jsonMasterUnit",  
         minLength:0,
		 select: function( event , ui ) {
			  $( "#vehicle_id_assets" ).val( ui.item.value );
			  $( "#vehicle_type_assets" ).val( ui.item.vehicle_type );
			  $( "#vehicle_type_id_assets" ).val( ui.item.id_vehicle_type );
        }    
        })
		.autocomplete( "instance" )._renderItem = function( ul, item ) {
		  return $( "<li style='position:relative; z-index:9999;'>" )
			.append( "<div style='font-size:10px;'>" + item.label+"</div>" )
			.appendTo( ul );
		};
		
		//auto complete Destination
		var term = $("#search_transporter").val();
        $( "#search_transporter" ).autocomplete({
         source: "<?php echo BASE_URL(); ?>index.php/json/jsonTransporter",  
         minLength:0,
		 select: function( event , ui ) {
			  $( "#transporter_id" ).val( ui.item.transporter_id );
			  $( "#transporter_name" ).val( ui.item.transporter_name );
        }    
        })
		.autocomplete( "instance" )._renderItem = function( ul, item ) {
		  return $( "<li style='position:relative; z-index:9999;'>" )
			.append( "<div style='font-size:10px;'>" + item.label+"</div>" )
			.appendTo( ul );
		};
		
		
		//auto complete Destination
		var term = $("#search_driver").val();
        $( "#search_driver" ).autocomplete({
         source: "<?php echo BASE_URL(); ?>index.php/json/jsonDriver",  
         minLength:0,
		 select: function( event , ui ) {
			  $( "#driver_code_assets" ).val( ui.item.driver_code );
			  $( "#driver_name_assets" ).val( ui.item.driver_name );
        }    
        })
		.autocomplete( "instance" )._renderItem = function( ul, item ) {
		  return $( "<li style='position:relative; z-index:9999;'>" )
			.append( "<div style='font-size:10px;'>" + item.label+"</div>" )
			.appendTo( ul );
		};
		
		
		//auto complete Destination
		var term = $("#search_trucking_order").val();
        $( "#search_trucking_order" ).autocomplete({
         source: "<?php echo BASE_URL(); ?>index.php/json/jsonTruckingOrder",  
         minLength:0,
		 select: function( event , ui ) {
			  $( "#id_trucking_order" ).val( ui.item.label );
        }    
        })
		.autocomplete( "instance" )._renderItem = function( ul, item ) {
		  return $( "<li style='position:relative; z-index:9999;'>" )
			.append( "<div style='font-size:10px;'>" + item.label+"</div>" )
			.appendTo( ul );
		};
		
		
		
</script>
<script>
$(".edit_delete").on('click', function() {
	$('.edit_case:checkbox:checked').parents("tr").remove();
    $('.edit_check_all').prop("checked", false); 
	check2();

});
var i=2;


$(".add_data").on('click', function() {
	
	addrow();

});


function addrow(){
	count=$('table.po tr').length;
    var data="<tr><td><input type='checkbox' class='edit_case'/></td>"+
			 "<td><select name='additional_type[]' class='additional_type'>"+
			 "<option value='Loading Charge'>Loading Charge</option>"+
			 "<option value='Unloading Charge'>Unloading Charge</option>"+
			 "<option value='Over Night'>Over Night</option>"+
			 "<option value='Lolo'>Lolo</option>"+
			 "<option value='Community Issue'>Community Issue</option>"+
			 "<option value='Escourting'>Escourting</option>"+
			 "<option value='Multidrop Inner City'>Multidrop Inner City</option>"+
			 "<option value='Multidrop Outer City'>Multidrop Outer City</option>"+
			 "</select></td>"+
			 "<td><input type='text' class='amount' name='amount_to_client[]' value=''/></td>"+
			 "<td><input type='text' class='amount' name='amount_to_transporter[]' value=''/></td>"+
			 "</tr>";
	$('table.po').append(data);
	create_mask();
	i++;
}





function select_all2() {
	$('input[class=edit_case]:checkbox').each(function(){ 

		if($('input[class=edit_case]:checkbox:checked').length == 0){
	
		$('.edit_case').prop('checked', true);			
		} else {
			$('.edit_case').prop('checked', false);	
			
		} 
	});
}

function check2(){
	obj=$('table.po tr').find('span');
	$.each( obj, function( key, value ) {
	id=value.id;
	$('#'+id).html(key+1);
	});
	}

	
		//auto complete Client ID
		var term = $("#search_client_id").val();
        $( "#search_client_id" ).autocomplete({
         source: "<?php echo BASE_URL(); ?>index.php/json/jsonClient", 
         minLength:0,
		 select: function( event , ui ) {
			  $(this).val( ui.item.client_id );
			  return false;
        }    
        })
		.autocomplete( "instance" )._renderItem = function( ul, item ) {
		  return $( "<li style='position:relative; z-index:9999;'>" )
			.append( "<div style='font-size:10px;'>" + item.label +"</div>" )
			.appendTo( ul );
		};
create_mask();
		
		function create_mask()
		{
			$('.amount').inputmask("numeric", {
				radixPoint: ".",
				groupSeparator: ".",
				digits: 2,
				autoGroup: true,
				prefix: '', //No Space, this will truncate the first character
				rightAlign: false,
				oncleared: function () { self.Value(''); }
			});
		}
</script>	
	
	