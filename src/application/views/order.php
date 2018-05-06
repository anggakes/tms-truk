 <!-- HEADER -->
 

    
 <section class="content-header">
          <h1>
            Invoice
            <small>Invoice Details</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="<?php echo BASE_URL(); ?>"><i class="fa fa-dashboard"></i>Home</a></li>
            <li><a href="<?php echo BASE_URL()."order"; ?>"><i class="fa fa-dashboard"></i>Invoice</a></li>
          </ol>
        </section>
  
  
   <!-- Content -->
   <section class="content">

          <div class="box sms box-default color-palette-box">
            <div class="box-header with-border">
              <h3 class="box-title"><i class="fa fa-table"></i> Table Invoice </h3>
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
			$search = isset($_GET['search']) ? $_GET['search'] : '';
			$date = isset($_GET['date']) ? $_GET['date'] : '';
			
			$regional = isset($_GET['regional']) ? $_GET['regional'] : '';
			if(isset($_GET['regional']))
			{$regional_implode = "'" . implode("','", $regional) . "'";;}
			else
			{$regional_implode = "";}

		$area = isset($_GET['area']) ? $_GET['area'] : '';
			if(isset($_GET['area']))
			{$area_implode = "'" . implode("','", $area) . "'";;}
			else
			{$area_implode = "";}
		
			$distributor = isset($_GET['distributor']) ? $_GET['distributor'] : '';
			if(isset($_GET['distributor']))
			{$distributor_implode = implode(",",$distributor);}
			else
			{$distributor_implode = "";}
			
			$motorist_type = isset($_GET['motorist_type']) ? $_GET['motorist_type'] : '';
			if(isset($_GET['motorist_type']))
			{$motorist_type_implode = implode(",",$motorist_type);}
			else
			{$motorist_type_implode = "";}
			
			$product = isset($_GET['product']) ? $_GET['product'] : '';
			if(isset($_GET['product']))
			{$product_implode = implode(",",$product);}
			else
			{$product_implode = "";}
			
			function convert_price($price)
			{
				echo "Rp. ".number_format($price, 0 , '' , '.' );		
					}
			?>
            <div id="wrapper-console" class="clearfix">
                <div id="wrapper-search">
                             <form action="<?php echo base_url()."index.php/order" ?>" method="get">
                             <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                                
                                
                                <div class="form-group">
                                <label>Date range:</label>
                                <div class="input-group">
                                  <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                  </div>
                                  <input type="text" class="form-control pull-right" id="reservation" name="date" value="<?php echo $date; ?>" >
                                </div><!-- /.input group -->
                              </div><!-- /.form group -->
								<?php if($data_account[0]['user_type']=="Administrator"){ ?>
                                 <div class="select-filter">
                             	<select name="regional[]" id="select-regional" multiple="multiple" >
                              	<?php foreach($data_regional as $data_regional) {?>
                              	<option <?php if(isset($_GET['regional'])) {if(in_array($data_regional['regional_name'], $regional)) {?> selected="selected" <?php }} ?> value="<?php echo $data_regional['regional_name']; ?>"><?php echo $data_regional['regional_name']; ?></option>
                              	<?php } ?>
                             	</select>
                             	</div>
                                
                                
                                <div class="select-filter">
                                 <select name="product[]" id="select-product" multiple="multiple" >
                                  <?php foreach($data_product as $data_product) {?>
                                  <option <?php if(isset($_GET['product'])) {if(in_array($data_product['id_product'], $product)) {?> selected="selected" <?php }} ?> value="<?php echo $data_product['id_product']; ?>"><?php echo $data_product['type']; ?>-<?php echo $data_product['sku_front_end']; ?></option>
                                  <?php } ?>
                                 </select>
                                 </div>
								<?php } ?> 
								 
								 
                                <?php if($data_account[0]['user_type']=="Administrator" or $data_account[0]['user_type']=="Regional"){ ?>
                              <div class="select-filter">
                             	<select name="area[]" id="select-area" multiple="multiple" >
                              	<?php foreach($data_area as $data_area) {?>
                              	<option <?php if(isset($_GET['area'])) {if(in_array($data_area['area'], $area)) {?> selected="selected" <?php }} ?> value="<?php echo $data_area['area']; ?>"><?php echo $data_area['area']; ?></option>
                              	<?php } ?>
                             	</select>
                             	</div>
                                <?php } ?>
								
								
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
                             	<select name="motorist_type[]" id="select-motorist-type" multiple="multiple" >
                              	<?php foreach($data_motorist_type as $data_motorist_type) {?>
                              	<option <?php if(isset($_GET['motorist_type'])) {if(in_array($data_motorist_type['id_motorist_type'], $motorist_type)) {?> selected="selected" <?php }} ?> value="<?php echo $data_motorist_type['id_motorist_type']; ?>"><?php echo $data_motorist_type['motorist_type']; ?></option>
                              	<?php } ?>
                             	</select>
                             	</div>
                                <input type="text" id="search" name="search" placeholder="Search by Motorist Code"  value="<?php echo $search; ?>" />
                                <input type="submit" id="submit"  value="Search"/>
                                <?php if($search!="" or $date!="" or $motorist_type_implode!="" or $regional_implode!="" or $product_implode!="")
								{?>
                                <a href="<?php echo base_url()."index.php/order" ?>" id="clear-search" style=" clear:both; float:left;">Clear Search</a>
                                <?php } ?>
                             </form>
                </div>
                <div id="wrapper-button" class="clearfix">
                	
                    
                     <a href="<?php echo base_url()."index.php/order/exportOrder?date=".$date."&search=".$search."&&distributor=".$distributor_implode."&&area=".$area_implode."&&regional=".$regional_implode."&&motorist_type=".$motorist_type_implode."&&product=".$product_implode; ?>" class="button blue-button">
                    	Export Invoice
                    </a>
                </div>
                </div>
            <div id="wrapper-table">
           
            <div id="wrapper-console" class="clearfix">  
            <div class="grid_4 height400">             
           	<table id="myTable05" class="fancyTable table table-bordered table-hover">
                    <thead>
                      <tr>
                        <th><div class="mid">Customer Code</div></th>
						<th><div class="mid">Regional</div></th>
                        <th><div class="mid">Area</div></th>
                        <th><div class="mid">Distributor Code</div></th>
                        <th><div class="mid">Distributor Name</div></th>
                        <th><div class="mid">Motorist Code</div></th>
                        <th><div class="mid">Motorist Name</div></th>
                        <th><div class="mid">Jenis Motorist</div></th>
                        <th><div class="mid">Invoice Number</div></th>
                        <th><div class="mid">Invoice Date</div></th>
                        
                        <th><div class="mid">Customer Name</div></th>
                        <th><div class="mid">Channel</div></th>
                        <th><div class="mid">Product Code</div></th>
                        <th><div class="mid">Product Description</div></th>
                        <th><div class="mid">product Quantity</div></th>
                        <th><div class="mid">Gross Amount</div></th>
                      </tr>
                    </thead>
             		<tbody>
                    <?php foreach($data_order as $data_order) {?>
                    <?php $invoice_detail = explode(" ",$data_order->date);
						  $invoice_detail = $invoice_detail[0]; 
						  $invoice_detail = explode("-",$invoice_detail);
						  $invoice_detail = $invoice_detail[2]."-".$invoice_detail[1]."-".$invoice_detail[0];
					?>
                    <tr>
                    	<td><div style="width:200px;"><?php echo $data_order->customer_code; ?></div></td>
						<td><?php echo $data_order->regional; ?></td>
						<td><?php echo $data_order->area; ?></td>
						<td><?php echo $data_order->distributor_code; ?></td>
                        <td><?php echo $data_order->distributor_name; ?></td>
                    	<td><?php echo $data_order->motorist_code; ?></td>
                        <td><?php echo $data_order->motorist_name; ?></td>
                        <td><?php echo $data_order->motorist_type; ?></td>
                        <td><?php echo $data_order->id_product_order; ?></td>
                        <td><?php echo $invoice_detail; ?></td>
                        
                        <td><?php echo $data_order->customer_name; ?></td>
                        <td><?php echo $data_order->channel_name; ?></td>
                        <td><?php echo $data_order->product_code; ?></td>
                        <td><?php echo $data_order->sku_front_end; ?></td>
                        <td><?php echo $data_order->qty; ?></td>
                        <td><?php echo convert_price($data_order->price_total); ?></td>
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
	   $('#reservation').daterangepicker({ dateFormat: "dd-mm-yy" }).val();
</script>
<script>
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

$("#select-product").pqSelect({
   multiplePlaceholder: 'Select Product',
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

	$("#select-distributor").pqSelect({
   multiplePlaceholder: 'Select Distributor',
   checkbox: true //adds checkbox to options    
   }).on("change", function(evt) {
      var val = $(this).val();
    })
</script>
