 <!-- HEADER -->
 <section class="content-header">
          <h1>
            Chart Admin
            <small>Brand Contribution</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="<?php echo BASE_URL(); ?>"><i class="fa fa-dashboard"></i>Home</a></li>
            <li><a href="<?php echo BASE_URL()."chart_admin/brandContribution"; ?>"><i class="fa fa-dashboard"></i>Brand Contribution</a></li>
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
              <h3 class="box-title"><i class="fa fa-table"></i> Chart Brand Contribution</h3>
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
			
			
			$channel = isset($_GET['channel']) ? $_GET['channel'] : '';
			if(isset($_GET['channel']))
			{$channel_implode = implode(",",$channel);}
			else
			{$channel_implode = "";}
			
			
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
                             <form action="<?php echo base_url()."index.php/chart_admin/brandContribution/" ?>" method="get">
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
                              <select name="channel[]" id="select-channel" multiple="multiple" >
                              <?php foreach($data_channel as $data_channel) {?>
                              <option <?php if(isset($_GET['channel'])) {if(in_array($data_channel['classification_code'], $channel)) {?> selected="selected" <?php }} ?> value="<?php echo $data_channel['classification_code']; ?>"><?php echo $data_channel['channel_description']; ?></option>
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
                                <a href="<?php echo base_url()."index.php/chart_admin/brandContribution/" ?>" id="clear-search-filter-store" style="margin-left:10px;">Clear Search</a>
                   <?php } ?>
                             </form>
                </div>
                
                
               
                </div>
            <div id="wrapper-console" class="clearfix">
            <div class="grid_4 ">             
           	

        
          <div id="container" style="min-width: 100%; height: 400px; max-width: 100%; margin: 0 auto"></div>
           
            
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
					
					
					if($channel_implode!="")
					{ $channel_query = 'AND store.channel_code in ('.$channel_implode.') '; }
					else
					{ $channel_query = ''; }
					
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
			$data_brand = $this->db->query("SELECT * FROM product group by brand")->result();
				if($date != '')
						{
								$tanggal_range_pecah = explode(" - ", $date);
								$tanggal_from = $tanggal_range_pecah[0];
								$tanggal_from = explode("/", $tanggal_from);
								$tanggal_from = $tanggal_from[2].'-'.$tanggal_from[0].'-'.$tanggal_from[1];
								
								$tanggal_to = $tanggal_range_pecah[1];
								$tanggal_to = explode("/", $tanggal_to);
								$tanggal_to = $tanggal_to[2].'-'.$tanggal_to[0].'-'.$tanggal_to[1];
						}
						else
						{
							$year_month = date('Y-m');
							$tanggal_from = $year_month.'-01';
							$tanggal_to = $year_month.'-31';
							
						}
				
				$data_total_keseluruhan = $this->db->query("SELECT SUM(price_total) as total_penjualan FROM product_orders INNER JOIN product on product.id_product = product_orders.id_product INNER JOIN store on product_orders.customer_code = store.customer_code WHERE product_orders.date BETWEEN '".$tanggal_from." 00:00:00' AND '".$tanggal_to." 23:59:59' ".$regional_query." ".$channel_query." ".$area_query." ".$distributor_query." ".$motorist_type_query." ".$product_query."    ")->result_array();
				$total_contribution_keseluruhan = $data_total_keseluruhan[0]['total_penjualan']."<br>";
				//echo $total_contribution_keseluruhan;
				
					function convert_price($price)
					{
					echo "Rp. ".number_format($price, 0 , '' , '.' );		
					}
						
			?>
            
           
            
            <h2>Sales contr largest to smallest</h2>
            <table id="example2" class="table table-bordered table-hover">
            <thead>
            <tr>
            	<th>Brand</th>
                <th>Sales</th>
                <th>Contribution</th>
            </tr>
            </thead>
            
            <tbody>
             <?php
			
				foreach($data_brand as $data_brand_1)
				{
					
					
					$data_total = $this->db->query("SELECT SUM(price_total) as total_penjualan FROM product_orders INNER JOIN product on product.id_product = product_orders.id_product INNER JOIN store on product_orders.customer_code = store.customer_code WHERE product_orders.date BETWEEN '".$tanggal_from." 00:00:00' AND '".$tanggal_to." 23:59:59' AND product.brand = '".$data_brand_1->brand."' ".$regional_query." ".$channel_query." ".$area_query." ".$distributor_query." ".$motorist_type_query." ".$product_query." ")->result_array();
					$total_contribution = '0';
					if($data_total[0]['total_penjualan']>0)
					{$total_contribution=$data_total[0]['total_penjualan'];}
					
					if($total_contribution_keseluruhan>0)
					{
						$persentasi_contributrion = ($total_contribution * 100) / $total_contribution_keseluruhan;
						$persentasi_contributrion = number_format($persentasi_contributrion, 0, '.', '');
					}
					?>
            
					<tr>
                	<td><?php echo $data_brand_1->brand; ?></td>
                    <td><?php convert_price($total_contribution); ?></td>
                    <td><?php echo $persentasi_contributrion; ?> %</td>
                	</tr>
                
			<?php
				}
            ?>
            
            	
            </tbody>
            
            </table>
                  	 
            
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

$("#select-channel").pqSelect({
   multiplePlaceholder: 'Select Channel',
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

 $('#container').highcharts({
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'pie'
        },
        title: {
            text: 'Brand Contribution'
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
            name: 'Brands Contribution',
            colorByPoint: true,
            data: [
					
					
					    <?php
			
						foreach($data_brand as $data_brand_1)
						{
							
							
							$data_total = $this->db->query("SELECT SUM(price_total) as total_penjualan FROM product_orders INNER JOIN product on product.id_product = product_orders.id_product INNER JOIN store on product_orders.customer_code = store.customer_code WHERE product_orders.date BETWEEN '".$tanggal_from." 00:00:00' AND '".$tanggal_to." 23:59:59' AND product.brand = '".$data_brand_1->brand."' ".$regional_query." ".$channel_query." ".$area_query." ".$distributor_query." ".$motorist_type_query." ".$product_query." ")->result_array();
							$total_contribution = '0';
							if($data_total[0]['total_penjualan']>0)
							{$total_contribution=$data_total[0]['total_penjualan'];}
							
							if($total_contribution_keseluruhan>0)
							{
								$persentasi_contributrion = ($total_contribution * 100) / $total_contribution_keseluruhan;
								$persentasi_contributrion = number_format($persentasi_contributrion, 0, '.', '');
							}
							?>
		
					{
                    name: '<?php echo $data_brand_1->brand; ?>(<?php convert_price($total_contribution); ?>)',
                    y:<?php echo $total_contribution; ?>,
                	},
					
					<?php 
						}
					?>
					
			
			
			]
        }]
    });
</script>


