 <!-- HEADER -->
 <section class="content-header">
          <h1>
            Stok Point
            <small>Stok Point of E-tools</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="<?php echo BASE_URL(); ?>"><i class="fa fa-dashboard"></i>Home</a></li>
            <li><a href="<?php echo BASE_URL()."store"; ?>"><i class="fa fa-dashboard"></i>Stock Point</a></li>
          </ol>
        </section>
  
  
   <!-- Content -->
   <section class="content">
          <div class="box sms box-default color-palette-box">
            <div class="box-header with-border">
              <h3 class="box-title"><i class="fa fa-table"></i> Table Store</h3>
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
			$store_name = isset($_GET['store_name']) ? $_GET['store_name'] : '';
			$regional = isset($_GET['regional']) ? $_GET['regional'] : '';
			if(isset($_GET['regional']))
			{$regional_implode = "'" . implode("','", $regional) . "'";;}
			else
			{$regional_implode = "";}
			
			
			$motorist_type = isset($_GET['motorist_type']) ? $_GET['motorist_type'] : '';
			if(isset($_GET['motorist_type']))
			{$motorist_type_implode = implode(",",$motorist_type);}
			else
			{$motorist_type_implode = "";}
			
			
			$motorist_code = isset($_GET['motorist_code']) ? $_GET['motorist_code'] : '';
			$distributor = isset($_GET['distributor_code']) ? $_GET['distributor_code'] : '';
			$date = isset($_GET['date']) ? $_GET['date'] : '';
			
			
			function convert_price($price)
			{
				echo "Rp. ".number_format($price, 0 , '' , '.' );		
					}
			?>
            <div id="wrapper-console" class="clearfix">
                <div id="wrapper-search">
                             <form action="<?php echo base_url()."index.php/store/stokpoint" ?>" method="get">
                             <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                                <input type="text" id="search" name="search" placeholder="Search by Stock Point Code"  value="<?php echo $search; ?>" />
                                <input type="text" id="store_name" name="store_name" placeholder="Search by Stock Point Name"  value="<?php echo $store_name; ?>" />
                                 <?php if($data_account[0]['user_type']=="Administrator"){ ?>
                                 <div class="select-filter">
                             	<select name="regional[]" id="select-regional" multiple="multiple" >
                              	<?php foreach($data_regional as $data_regional) {?>
                              	<option <?php if(isset($_GET['regional'])) {if(in_array($data_regional['regional_name'], $regional)) {?> selected="selected" <?php }} ?> value="<?php echo $data_regional['regional_name']; ?>"><?php echo $data_regional['regional_name']; ?></option>
                              	<?php } ?>
                             	</select>
                             	</div>
                                
                                
                                 <div class="select-filter">
                             	<select name="motorist_type[]" id="select-motorist-type" multiple="multiple" >
                              	<?php foreach($data_motorist_type as $data_motorist_type) {?>
                              	<option <?php if(isset($_GET['motorist_type'])) {if(in_array($data_motorist_type['id_motorist_type'], $motorist_type)) {?> selected="selected" <?php }} ?> value="<?php echo $data_motorist_type['id_motorist_type']; ?>"><?php echo $data_motorist_type['motorist_type']; ?></option>
                              	<?php } ?>
                             	</select>
                             	</div>
                                <?php } ?>
                                <input type="submit" id="submit"  value="Search"/>
                                <?php if($search!="" or $regional_implode!="" or $motorist_type_implode!="" or $motorist_code!='' or $distributor!='' or $date!='')
								{?>
                                <a href="<?php echo base_url()."index.php/store" ?>" id="clear-search">Clear Search</a>
                                <?php } ?>
                             </form>
                </div>
                <div id="wrapper-button" class="clearfix">
                	
                  
                </div>
                </div>
            <div id="wrapper-table">
           
           	<?php
			
			//$mo =	date('m');
			//$year = date('y');
				
			//$total_all_store = $this->db->query("SELECT * FROM store WHERE store.motorist_type = '1' AND store.regional = 'West Java'  group by store.customer_code  ")->num_rows();
			
			//$total_all_store_beli = $this->db->query("SELECT * FROM store lEFT JOIN product_orders on store.customer_code = product_orders.customer_code AND id_product in (1) AND product_orders.date between '$year-$mo-01 00:00:00' AND '$year-$mo-31 00:00:00'  WHERE store.motorist_type = '1' AND store.regional = 'West Java' AND product_orders.customer_code IS NOT NULL GROUP BY store.customer_code  ")->num_rows();
			
			//$total_all_store_tidak_beli = $this->db->query("SELECT * FROM store LEFT JOIN product_orders on store.customer_code = product_orders.customer_code AND id_product in (1) AND product_orders.date between '$year-$mo-01 00:00:00' AND '$year-$mo-31 00:00:00' WHERE   store.motorist_type = '1' AND store.regional = 'West Java' AND product_orders.customer_code IS NULL GROUP BY store.customer_code   ")->num_rows();
			
			//echo "Total Keseluruhan Toko:".$total_all_store."<br>";
			//echo "Total Keseluruhan Toko Beli Ber Brand:".$total_all_store_beli."<br>";
			//echo "Total Keseluruhan Toko Tidak Beli Ber Brand:".$total_all_store_tidak_beli."<br>";
			
			?>
            <div id="wrapper-console" class="clearfix"> 
            <div class="grid_4 height400">             
           	<table id="myTable05" class="fancyTable table table-bordered table-hover">
                    <thead>
                      <tr>
                        <th><div class="mid">Stock Point Name</div></th>
                        <th><div class="mid">Distributor Name</div></th>
                        <th><div class="mid">Distributor Code</div></th>
                        <th><div class="mid">Motorist Code</div></th>
                        <th><div class="mid">Motorist Name</div></th>
                        <th><div class="mid">Customer Code</div></th>
                        <th><div class="mid">Address</div></th>
                        <th><div class="mid">Districts</div></th>
                        <th><div class="mid">Stock Point Contact</div></th>
                      </tr>
                    </thead>
             		<tbody>
                    <?php foreach($data_store as $data_store) {?>
                    <tr>
                      <td><div style="width:200px;"><?php echo $data_store->customer_name; ?>-<?php echo $data_store->customer_code; ?></div></td>
                        <td><?php echo $data_store->distributor_name; ?></td>
                        <td><?php echo $data_store->distributor_code; ?></td>
                        <td><?php echo $data_store->motorist_code ?></td>
                        <td><?php echo $data_store->motorist_name; ?></td>
                        <td><?php echo $data_store->customer_code; ?></td>
                        <td><?php echo $data_store->address; ?></td>
                        <td><?php echo $data_store->districts; ?></td>
                        <td><?php echo $data_store->customer_contact; ?></td>
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
</script>
