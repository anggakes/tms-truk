 <!-- HEADER -->
 <section class="content-header">
          <h1>
            Store
            <small>Store of E-tools</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="<?php echo BASE_URL(); ?>"><i class="fa fa-dashboard"></i>Home</a></li>
            <li><a href="<?php echo BASE_URL()."store"; ?>"><i class="fa fa-dashboard"></i>Store</a></li>
          </ol>
        </section>
  
  
   <!-- Content -->
   <section class="content">
          <div class="box sms box-default color-palette-box">
            <div class="box-header with-border">
              <h3 class="box-title"><i class="fa fa-table"></i> Table Filter Store</h3>
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
                     
            <?php
			
			$regional = isset($_GET['regional']) ? $_GET['regional'] : '';
			if(isset($_GET['regional']))
			{$regional_implode = "'" . implode("','", $regional) . "'";}
			else
			{$regional_implode = "";}
			
			
			$area = isset($_GET['area']) ? $_GET['area'] : '';
			if(isset($_GET['area']))
			{$area_implode = "'" . implode("','", $area) . "'";;}
			else
			{$area_implode = "";}
			
			
			$motorist_type = isset($_GET['motorist_type']) ? $_GET['motorist_type'] : '';
			if(isset($_GET['motorist_type']))
			{$motorist_type_implode = implode(",",$motorist_type);}
			else
			{$motorist_type_implode = "";}
		
		
			$tahun = isset($_GET['tahun']) ? $_GET['tahun'] : '';
			
			
			$distributor = isset($_GET['distributor']) ? $_GET['distributor'] : '';
			if(isset($_GET['distributor']))
			{$distributor_implode = implode(",",$distributor);}
			else
			{$distributor_implode = "";}
			
			$channel = isset($_GET['channel']) ? $_GET['channel'] : '';
			if(isset($_GET['channel']))
			{$channel_implode = implode(",",$channel);}
			else
			{$channel_implode = "";}
			
			$motorist = isset($_GET['motorist']) ? $_GET['motorist'] : '';
			if(isset($_GET['motorist']))
			{$motorist_implode = "'" . implode("','", $motorist) . "'";}
			else
			{$motorist_implode = "";}
			
			$day = isset($_GET['day']) ? $_GET['day'] : '';
			if(isset($_GET['day']))
			{$day_implode = "'" . implode("','", $day) . "'";}
			else
			{$day_implode = "";}
			
			
			
			$product = isset($_GET['product']) ? $_GET['product'] : '';
			if(isset($_GET['product']))
			{$product_implode = implode(",",$product);}
			else
			{$product_implode = "";}

			$transaction_month = isset($_GET['transaction-month']) ? $_GET['transaction-month'] : '';
			
			$month = isset($_GET['month']) ? $_GET['month'] : '';
			
			function convert_price($price)
			{
				echo "Rp. ".number_format($price, 0 , '' , '.' );		
					}
					
			?>
			
            <div id="wrapper-console" class="clearfix">
            <div id="wrapper-search">
                             <form class="advance-search" action="<?php echo base_url()."index.php/store/filterstore/" ?>" method="get">
                             <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />    
                             
                             
                          
                             
                             <?php if($data_account[0]['user_type']=="Administrator" or $data_account[0]['user_type']=="Regional"){ ?>
                              <div class="select-filter">
                             	<select name="area[]" id="select-area" multiple="multiple" >
                              	<?php foreach($data_area as $data_area) {?>
                              	<option <?php if(isset($_GET['area'])) {if(in_array($data_area['area'], $area)) {?> selected="selected" <?php }} ?> value="<?php echo $data_area['area']; ?>"><?php echo $data_area['area']; ?></option>
                              	<?php } ?>
                             	</select>
                             	</div>
                                <?php } ?>
                                
                                
                             
                              
                              	<?php if($data_account[0]['user_type']=="Administrator"){ ?>
                                 <div class="select-filter">
                             	<select name="regional[]" id="select-regional" multiple="multiple" >
                              	<?php foreach($data_regional as $data_regional) {?>
                              	<option <?php if(isset($_GET['regional'])) {if(in_array($data_regional['regional_name'], $regional)) {?> selected="selected" <?php }} ?> value="<?php echo $data_regional['regional_name']; ?>"><?php echo $data_regional['regional_name']; ?></option>
                              	<?php } ?>
                             	</select>
                             	</div>
                                <?php } ?>
                                
                                
                                <div class="select-filter">
                             	<select name="motorist_type[]" id="select-motorist-type" multiple="multiple" >
                              	<?php foreach($data_motorist_type as $data_motorist_type) {?>
                              	<option <?php if(isset($_GET['motorist_type'])) {if(in_array($data_motorist_type['id_motorist_type'], $motorist_type)) {?> selected="selected" <?php }} ?> value="<?php echo $data_motorist_type['id_motorist_type']; ?>"><?php echo $data_motorist_type['motorist_type']; ?></option>
                              	<?php } ?>
                             	</select>
                             	</div>
                                
                                <?php if($data_account[0]['user_type']=="Administrator" or $data_account[0]['user_type']=="Regional"){ ?>
                             <div class="select-filter">
                             <select name="distributor[]" id="select-distributor" multiple="multiple" >
                              <?php foreach($data_distributor as $data_distributor) {?>
                              <option <?php if(isset($_GET['distributor'])) {if(in_array($data_distributor['distributor_code'], $distributor)) {?> selected="selected" <?php }} ?> value="<?php echo $data_distributor['distributor_code']; ?>" ><?php echo $data_distributor['distributor_name']; ?></option>
                              <?php } ?>
                             </select>
                             </div>
                             <?php } ?>
                      
                           
                             <div class="select-filter">
                             <select name="channel[]" id="select-channel" multiple="multiple" >
                              <?php foreach($data_channel as $data_channel) {?>
                              <option <?php if(isset($_GET['channel'])) {if(in_array($data_channel['classification_code'], $channel)) {?> selected="selected" <?php }} ?>  value="<?php echo $data_channel['classification_code']; ?>"><?php echo $data_channel['channel_description']; ?></option>
                              <?php } ?>
                             </select>
                             </div>
                             
                             <?php if($data_account[0]['user_type']=="Ado"){ ?>
                              <div class="select-filter">
                              <select name="motorist[]" id="select-motorist" multiple="multiple" >
                              <?php foreach($data_motorist as $data_motorist) {?>
                              <option <?php if(isset($_GET['motorist'])) {if(in_array($data_motorist['motorist_code'], $motorist)) {?> selected="selected" <?php }} ?> value="<?php echo $data_motorist['motorist_code']; ?>"><?php echo $data_motorist['motorist_name']; ?>-<?php echo $data_motorist['motorist_code']; ?></option>
                              <?php } ?>
                             </select>
                             </div>
                             <?php } ?>
                             
                             
                             <div class="select-filter">
                             <select name="day[]" id="select-day" multiple="multiple" >
                              <option <?php if(isset($_GET['day'])) {if(in_array("monday", $day)) {?> selected="selected" <?php }} ?> value="monday">Monday</option>
                              <option <?php if(isset($_GET['day'])) {if(in_array("tuesday", $day)) {?> selected="selected" <?php }} ?>  value="tuesday">Tuesday</option>
                              <option <?php if(isset($_GET['day'])) {if(in_array("wednesday", $day)) {?> selected="selected" <?php }} ?> value="wednesday">Wednesday</option>
                              <option <?php if(isset($_GET['day'])) {if(in_array("thursday", $day)) {?> selected="selected" <?php }} ?> value="thursday">Thursday</option>
                              <option <?php if(isset($_GET['day'])) {if(in_array("friday", $day)) {?> selected="selected" <?php }} ?> value="friday">Friday</option>
                              <option <?php if(isset($_GET['day'])) {if(in_array("saturday", $day)) {?> selected="selected" <?php }} ?>  value="saturday">Saturday</option>
                             </select>
                             </div>
                             
                             
                             <div class="select-filter">
                             <select name="month" id="select-month"  >
                              <option value="">Choose Month</option>
                              <option <?php if($month=="01"){ ?> selected="selected" <?php } ?> value="01">January</option>
                              <option <?php if($month=="02"){ ?> selected="selected" <?php } ?> value="02">Februari</option>
                              <option <?php if($month=="03"){ ?> selected="selected" <?php } ?> value="03">March</option>
                              <option <?php if($month=="04"){ ?> selected="selected" <?php } ?> value="04">April</option>
                              <option <?php if($month=="05"){ ?> selected="selected" <?php } ?> value="05">May</option>
                              <option <?php if($month=="06"){ ?> selected="selected" <?php } ?> value="06">June</option>
                              <option <?php if($month=="07"){ ?> selected="selected" <?php } ?> value="07">July</option>
                              <option <?php if($month=="08"){ ?> selected="selected" <?php } ?> value="08">August</option>
                              <option <?php if($month=="09"){ ?> selected="selected" <?php } ?> value="09">September</option>
                              <option <?php if($month=="10"){ ?> selected="selected" <?php } ?> value="10">October</option>
                              <option <?php if($month=="11"){ ?> selected="selected" <?php } ?> value="11">November</option>
                              <option <?php if($month=="12"){ ?> selected="selected" <?php } ?> value="12">December</option>
                             </select>
                             </div>
                             
                             
							 <select name="tahun" id="tahun" style="float:left; width:300px;">
                                	<option value="">Choose year</option>
                                    <option <?php if($tahun==2016){ ?> selected="selected" <?php } ?> value="2016">2016</option>
                                    <option <?php if($tahun==2017){ ?> selected="selected" <?php } ?> value="2017">2017</option>
                                    <option <?php if($tahun==2018){ ?> selected="selected" <?php } ?> value="2018">2018</option>
                                </select>
								
                             <div class="select-filter">
                             <select name="product[]" id="select-product" multiple="multiple" >
                              <?php foreach($data_product as $data_product) {?>
                              <option <?php if(isset($_GET['product'])) {if(in_array($data_product['id_product'], $product)) {?> selected="selected" <?php }} ?> value="<?php echo $data_product['id_product']; ?>"><?php echo $data_product['type']; ?>-<?php echo $data_product['sku_front_end']; ?></option>
                              <?php } ?>
                             </select>
                             </div>
                             
                             
                             <div class="select-filter">
                             <select name="transaction-month" id="select-month"  >
                             
                              <option <?php if($transaction_month=='yes') {?> selected="selected" <?php } ?> value="yes">Yes (Transaction)</option>
                              <option <?php if($transaction_month=='no') {?> selected="selected" <?php } ?> value="no">No (Transaction)</option>
                             </select>
                             </div>
                             
                            
                            <input type="submit" id="submit"  value="Search"/> 
                             </form>
                </div>
                <div id="wrapper-button" style="width:100% !important" class="clearfix filter-map">
                	
                   <?php if($area_implode!="" or $regional_implode!="" or $motorist_type_implode!="" or $distributor_implode!="" or $motorist_implode!="" or $motorist_type_implode!="" or $day_implode!="" or $product_implode!="")
								{?>
                                <a href="<?php echo base_url()."index.php/store/filterstore/" ?>" id="clear-search-filter-store">Clear Search</a>
                   <?php } ?>
				   
				   
                  <a style="width:200px;" href="<?php echo base_url().'maps/example/maps-filter.php?ket='.$data_role_etools[0]['motorist_view'].'&&distributor_code='.$data_account[0]['code'].'&&role='.$data_account[0]['user_type'].'&&motorist_type='.$motorist_type_implode.'&&tahun='.$tahun.'&&distributor='.$distributor_implode.'&&channel='.$channel_implode.'&&motorist='.$motorist_implode.'&&day='.$day_implode.'&&product='.$product_implode.'&&transaction_month='.$transaction_month.'&&month='.$month."&&regional=".$regional_implode."&&area=".$area_implode."&&tipe=motorist"; ?>" target="_blank">
                  View Map By Motorist
                  </a>   
                  
                  
                  <?php if($data_account[0]['user_type']=="Administrator" or $data_account[0]['user_type']=="Regional"){ ?>
                  <a style="width:200px;" href="<?php echo base_url().'maps/example/maps-filter.php?ket='.$data_role_etools[0]['motorist_view'].'&&distributor_code='.$data_account[0]['code'].'&&role='.$data_account[0]['user_type'].'&&motorist_type='.$motorist_type_implode.'&&tahun='.$tahun.'&&distributor='.$distributor_implode.'&&channel='.$channel_implode.'&&motorist='.$motorist_implode.'&&day='.$day_implode.'&&product='.$product_implode.'&&transaction_month='.$transaction_month.'&&month='.$month."&&regional=".$regional_implode."&&area=".$area_implode."&&tipe=distributor"; ?>" target="_blank">
                  View Map By Distributor
                  </a>   
                  <?php } ?>
                  
                    <a  href="<?php echo base_url().'index.php/store/exportFilterStore?motorist_type='.$motorist_type_implode.'&&distributor='.$distributor_implode.'&&channel='.$channel_implode.'&&motorist='.$motorist_implode.'&&day='.$day_implode.'&&tahun='.$tahun.'&&product='.$product_implode.'&&transaction_month='.$transaction_month.'&&month='.$month."&&regional=".$regional_implode."&&area=".$area_implode."&&motorist_type=".$motorist_type_implode; ?>" class="button blue-button">
                    	Export Store
                    </a>

				

					
                </div>
                </div>
            <div id="wrapper-table">
            <h2>Total Store : <?php print_r($data_total_store); ?></h2>
           
            <div id="wrapper-console" class="clearfix">
             <div class="grid_4 height400">              
           	<table id="myTable05" class="fancyTable table table-bordered table-hover">
                    <thead>
                      <tr>
                      	<th>Customer Name</th>
                        <th>Distributor Code</th>
                        <th>Distributor Name</th>
                        <th>Motorist Code</th>
                        <th>Motorist Name</th>
                        <th>ID Store</th>
                        <th>Day Visit</th>
                        <th>Frequency</th>
                        <th>Customer Code</th>
                        <th>Channel Code</th>
                        <th>Channel Name</th>
                        <th>Place Status</th>
                        <th>Customer Status</th>
                        <th>Address</th>
                        <th>Districts</th>
                        <th>Customer Contact</th>
                        <th>Action</th>
                      </tr>
                    </thead>
             		<tbody>
                    <?php foreach($data_store as $data_store) {?>
                    <tr>
                    	<td><div style="width:200px;"><?php echo $data_store->customer_name; ?></div></td>
                    	
                        <td><?php echo $data_store->distributor_name; ?></td>
                        <td><?php echo $data_store->distributor_code; ?></td>
                        <td><?php echo $data_store->motorist_code ?></td>
                        <td><?php echo $data_store->motorist_name; ?></td>
                        <td><?php echo $data_store->id_store; ?></td>
                        <td><?php echo $data_store->day_visit; ?></td>
                        <td><?php echo $data_store->frequency; ?></td>
                        <td><?php echo $data_store->customer_code_bayangan; ?></td>
                        
                        <td><?php echo $data_store->channel_code; ?></td>
                        <td><?php echo $data_store->channel_name; ?></td>
                        <td><?php echo $data_store->place_status; ?></td>
                        <td><?php echo $data_store->customer_status; ?></td>
                        <td><?php echo $data_store->address; ?></td>
                        <td><?php echo $data_store->districts; ?></td>
                        <td><?php echo $data_store->customer_contact; ?></td>
                        <td><a href="<?php echo base_url()."index.php/store/editStore/".$data_store->id_store ?>">Edit</a> | <a href="<?php echo base_url()."index.php/store/deleteStore/".$data_store->id_store ?>">Delete</a></td>
                        
                        
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
<script>
$("#select-distributor").pqSelect({
   multiplePlaceholder: 'Select Distributor',
   checkbox: true //adds checkbox to options    
   }).on("change", function(evt) {
      var val = $(this).val();
    })

$("#select-channel").pqSelect({
   multiplePlaceholder: 'Select Channel',
   checkbox: true //adds checkbox to options    
   }).on("change", function(evt) {
      var val = $(this).val();
    })

$("#select-motorist").pqSelect({
   multiplePlaceholder: 'Select Motorist',
   checkbox: true //adds checkbox to options    
   }).on("change", function(evt) {
      var val = $(this).val();
    })

$("#select-day").pqSelect({
   multiplePlaceholder: 'Select Day',
   checkbox: true //adds checkbox to options    
   }).on("change", function(evt) {
      var val = $(this).val();
    })



$("#select-product").pqSelect({
   multiplePlaceholder: 'Select Product',
   checkbox: true //adds checkbox to options    
   }).on("change", function(evt) {
      var val = $(this).val();
    })

$("#select-regional").pqSelect({
   multiplePlaceholder: 'Select Regional',
   checkbox: true //adds checkbox to options    
   }).on("change", function(evt) {
      var val = $(this).val();
    })


$("#select-motorist-type").pqSelect({
   multiplePlaceholder: 'Select Motorist Type',
   checkbox: true //adds checkbox to options    
   }).on("change", function(evt) {
      var val = $(this).val();
    })

$("#select-area").pqSelect({
   multiplePlaceholder: 'Select Area',
   checkbox: true //adds checkbox to options    
   }).on("change", function(evt) {
      var val = $(this).val();
    })

</script>
