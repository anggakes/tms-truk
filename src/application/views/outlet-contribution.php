 <!-- HEADER -->
 <section class="content-header">
          <h1>
            Chart Admin
            <small>Channel Outlet Contribution</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="<?php echo BASE_URL(); ?>"><i class="fa fa-dashboard"></i>Home</a></li>
            <li><a href="<?php echo BASE_URL()."chart_admin"; ?>"><i class="fa fa-dashboard"></i>Channel Outlet Contribution</a></li>
          </ol>
        </section>
  
  <style>
  #clear-search-filter-store{
    background: #1ba0d8;
    color: #FFF;
    padding: 12.5px;
    border: none;
    position: relative;
    left: -3px;
}




.highcharts-legend-item{
	display:block;}
  </style>
   <!-- Content -->
   <section class="content">
          <div class="box sms box-default color-palette-box">
            <div class="box-header with-border">
              <h3 class="box-title"><i class="fa fa-table"></i> Table Channel</h3>
            </div>
            <div class="box-body">
           
            <div id="wrapper-table">
            <?php
			$search = isset($_GET['search']) ? $_GET['search'] : '';
			$date = isset($_GET['date']) ? $_GET['date'] : '';
			
			$year = isset($_GET['year']) ? $_GET['year'] : '';
			
			$product = isset($_GET['product']) ? $_GET['product'] : '';
			if(isset($_GET['product']))
			{$product_implode = implode(",",$product);}
			else
			{$product_implode = "";}
			
			$motorist_type = isset($_GET['motorist_type']) ? $_GET['motorist_type'] : '';
			if(isset($_GET['motorist_type']))
			{$motorist_type_implode = implode(",",$motorist_type);}
			else
			{$motorist_type_implode = "";}
			
			$distributor = isset($_GET['distributor']) ? $_GET['distributor'] : '';
			if(isset($_GET['distributor']))
			{$distributor_implode = implode(",",$distributor);}
			else
			{$distributor_implode = "";}
			
			
			$regional = isset($_GET['regional']) ? $_GET['regional'] : '';
			if(isset($_GET['regional']))
			{$regional_implode = "'" . implode("','", $regional) . "'";}
			else
			{$regional_implode = "";}
	
			
			$area = isset($_GET['area']) ? $_GET['area'] : '';
			if(isset($_GET['area']))
			{$area_implode = "'" . implode("','", $area) . "'";}
			else
			{$area_implode = "";}
			
			

			
			?>
            <div id="wrapper-console" class="clearfix">
                <div id="wrapper-search">
                             <form action="<?php echo base_url()."index.php/chart_admin/" ?>" method="get">
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
                              
                            
                              <div class="select-filter">
                              <select name="regional[]" id="select-regional" multiple="multiple" >
                              <?php foreach($data_regional as $data_regional) {?>
                              <option <?php if(isset($_GET['regional'])) {if(in_array($data_regional['regional_name'], $regional)) {?> selected="selected" <?php }} ?> value="<?php echo $data_regional['regional_name']; ?>"><?php echo $data_regional['regional_name']; ?></option>
                              <?php } ?>
                              </select>
                              </div>
                              
                              
                              
                              
                            <div class="select-filter">
                              <select name="area[]" id="select-area" multiple="multiple" >
                              <?php foreach($data_area as $data_area) {?>
                              <option <?php if(isset($_GET['area'])) {if(in_array($data_area['area'], $area)) {?> selected="selected" <?php }} ?> value="<?php echo $data_area['area']; ?>"><?php echo $data_area['area']; ?>-<?php echo $data_area['regional']; ?></option>
                              <?php } ?>
                             </select>
                             </div>
                             
                            <div class="select-filter">
                              <select name="distributor[]" id="select-distributor" multiple="multiple" >
                              <?php foreach($data_distributor as $data_distributor) {?>
                              <option <?php if(isset($_GET['distributor'])) {if(in_array($data_distributor['distributor_code'], $distributor)) {?> selected="selected" <?php }} ?> value="<?php echo $data_distributor['distributor_code']; ?>"><?php echo $data_distributor['distributor_code']; ?>-<?php echo $data_distributor['distributor_name']; ?></option>
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
                             
                             
                             
                              <div class="select-filter">
                             <select name="product[]" id="select-product" multiple="multiple" >
                              <?php foreach($data_product as $data_product) {?>
                              <option <?php if(isset($_GET['product'])) {if(in_array($data_product['id_product'], $product)) {?> selected="selected" <?php }} ?> value="<?php echo $data_product['id_product']; ?>"><?php echo $data_product['type']; ?>-<?php echo $data_product['sku_front_end']; ?></option>
                              <?php } ?>
                             </select>
                             </div>
                              
                              
                          
                             
                          
                             
                                <input type="submit" id="submit"  value="Search" style="left:0px;"/>
                               
                                 <?php if($date!="" or $distributor_implode!="" or $product_implode!="" or $area_implode !="" or $regional_implode!="" or $motorist_type_implode!=""  )
								{?>
                                <a href="<?php echo base_url()."index.php/chart_admin/" ?>" id="clear-search-filter-store" style="margin-left:10px;">Clear Search</a>
                   <?php } ?>
                             </form>
                </div>
                
                
               
                </div>
            <div id="wrapper-console" class="clearfix">
            <div class="grid_4 ">             
           	
        <div id="container" style="min-width: 100%; height: 400px; max-width: 100%; margin: 0 auto"></div><br />
        <hr />
<br />

        
          <div id="container2" style="min-width: 100%; height: 400px; max-width: 100%; margin: 0 auto"></div>
           
            
            <?php 
					$product_query = 'AND product_orders.id_product in ('.$product_implode.') '; 
					$data_channel = $this->db->query("SELECT * FROM channel")->result();
					if($regional_implode!="")
					{ $regional_query = 'AND store.regional in ('.$regional_implode.') '; }
					else
					{ $regional_query = ''; }
					
					if($distributor_implode!="")
					{ $distributor_query = 'AND store.distributor_code in ('.$distributor_implode.') '; }
					else
					{ $distributor_query = ''; }
					
					
					 
					if($area_implode!="")
					{ $area_query = 'AND store.area in ('.$area_implode.') '; }
					else
					{ $area_query = ''; }
					
					if($motorist_type_implode!="")
					{ $motorist_type_query = 'AND store.motorist_type in ('.$motorist_type_implode.') '; }
					else
					{ $motorist_type_query = ''; }
				
				
				
				
				
				
				if($product_implode == '')
				{
					$product_query = '';
					}
				else
				{
					$product_query = 'AND product_orders.id_product in ('.$product_implode.') ';
					}
					
				
				
	
					
			
			?>
            
            
                  	 
            
           </div>
            </div>
            
            </div>
      </section>
<script>
	   $('#reservation').daterangepicker({ dateFormat: "dd-mm-yy" }).val();

$("#select-product").pqSelect({
   multiplePlaceholder: 'Select Product',
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

<script>

 $('#container2').highcharts({
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'pie'
        },
        title: {
            text: 'Sales Contribution By Channel'
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                    style: {
                        color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                    }
                }
            }
        },
        series: [{
            name: 'Brands',
            colorByPoint: true,
            data: [
			
			<?php
					foreach($data_channel as $data_channel2) {
					
					$bulan_now = date('m');
					$year_now = date('y');
						if($date != '')
						{
							$tanggal_range_pecah = explode(" - ", $date);
							$tanggal_from = $tanggal_range_pecah[0];
							$tanggal_from = explode("/", $tanggal_from);
							$tanggal_from = $tanggal_from[2].'-'.$tanggal_from[0].'-'.$tanggal_from[1];
							$tanggal_to = $tanggal_range_pecah[1];
							$tanggal_to = explode("/", $tanggal_to);
							$tanggal_to = $tanggal_to[2].'-'.$tanggal_to[0].'-'.$tanggal_to[1];
							
							$total_store = $this->db->query("SELECT SUM(price_total) as total_price_channel FROM product_orders INNER JOIN store on store.customer_code = product_orders.customer_code WHERE store.channel_code = '".$data_channel2->classification_code."' AND product_orders.date between '".$tanggal_from." 00-00-00' AND '".$tanggal_to." 23-59-59' ".$product_query." ".$distributor_query." ".$motorist_type_query." ".$area_query." ".$regional_query."   ")->result_array();  
						}
						else
						{
							$total_store = $this->db->query("SELECT SUM(price_total) as total_price_channel FROM product_orders INNER JOIN store on store.customer_code = product_orders.customer_code WHERE store.channel_code = '".$data_channel2->classification_code."' AND product_orders.date between '".$year_now."-".$bulan_now."-01 00-00-00' AND '".$year_now."-".$bulan_now."-31 23-59-59' ".$product_query." ".$distributor_query." ".$motorist_type_query." ".$area_query." ".$regional_query." ")->result_array();
						}
						//echo $data_channel2->sample.'-'.$total_store[0]['total_price_channel']."<br>";
					
					
					if($total_store[0]['total_price_channel']>0)
					{
					?>
				   
					
					{
                    name: '<?php echo $data_channel2->sample; ?> (<?php echo "Rp. ".number_format($total_store[0]['total_price_channel'], 0 , '' , '.' ); ?>)',
                    y:<?php echo $total_store[0]['total_price_channel']; ?>,
                	},
				
				<?php } } ?>
			
			]
        }]
    });
</script>


<script>

 $('#container').highcharts({
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'pie'
        },
        title: {
            text: 'Outlet Contribution By Channel'
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                    style: {
                        color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                    }
                }
            }
        },
        series: [{
            name: 'Brands',
            colorByPoint: true,
            data: [
			
			<?php
					foreach($data_channel as $data_channel1) {
					if($product_implode == '')
					{
						$total_store = $this->db->query("SELECT * FROM store WHERE channel_code = '".$data_channel1->classification_code."' ".$regional_query." ".$distributor_query." ".$area_query." ".$motorist_type_query." ")->num_rows();
					}
						
						
					else
					{
						
						if($date != '')
						{
							$tanggal_range_pecah = explode(" - ", $date);
							$tanggal_from = $tanggal_range_pecah[0];
							$tanggal_from = explode("/", $tanggal_from);
							$tanggal_from = $tanggal_from[2].'-'.$tanggal_from[0].'-'.$tanggal_from[1];
							
							$tanggal_to = $tanggal_range_pecah[1];
							$tanggal_to = explode("/", $tanggal_to);
							$tanggal_to = $tanggal_to[2].'-'.$tanggal_to[0].'-'.$tanggal_to[1];
							
							$total_store = $this->db->query("SELECT * FROM store INNER JOIN product_orders on product_orders.customer_code = store.customer_code WHERE channel_code = '".$data_channel1->classification_code."' ".$product_query."   AND product_orders.date BETWEEN '".$tanggal_from." 00:00:00' AND '".$tanggal_to." 23:59:59' ".$regional_query." ".$distributor_query." ".$area_query." ".$motorist_type_query." group BY store.customer_code ")->num_rows();  
						}
						else
						{
					
							$total_store = $this->db->query("SELECT * FROM store INNER JOIN product_orders on product_orders.customer_code = store.customer_code WHERE channel_code = '".$data_channel1->classification_code."' ".$product_query."  ".$regional_query." ".$distributor_query." ".$area_query." ".$motorist_type_query." group BY store.customer_code ")->num_rows();
							
						}
						
						
					}
					
					if($total_store>0)
					{
					?>
					
					{
                    name: '<?php echo $data_channel1->sample; ?> (<?php echo $total_store ?>)',
                    y:<?php echo $total_store; ?>,
                	},
				
					
					<?php
					}
					//echo $data_channel1->sample.'-'.$total_store."<br>";
				}
				
					 ?>
			
			]
        }]
    });
</script>