 <!-- HEADER -->
 <section class="content-header">
          <h1>
            Chart Admin
            <small>Register Outlet VS Active Outlet</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="<?php echo BASE_URL(); ?>"><i class="fa fa-dashboard"></i>Home</a></li>
            <li><a href="<?php echo BASE_URL()."chart_admin/registerOutlet"; ?>"><i class="fa fa-dashboard"></i>Register Outlet VS Active Outlet</a></li>
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
                             <form action="<?php echo base_url()."index.php/chart_admin/registerOutlet/" ?>" method="get">
                             <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                               
                               
                              <div class="select-filter">
                             <select name="year" id="year"  >
                              <option <?php if($year==2016){?> selected="selected" <?php } ?> value="2016">2016</option>
                              <option <?php if($year==2017){?> selected="selected" <?php } ?> value="2017">2017</option>
                             </select>
                             </div>
                              
                            
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
                                <a href="<?php echo base_url()."index.php/chart_admin/registerOutlet/" ?>" id="clear-search-filter-store" style="margin-left:10px;">Clear Search</a>
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
            type: 'column'
        },
        title: {
            text: 'Outlet Active VS Register Outlet'
        },
        xAxis: {
            type: 'category'
        },
        yAxis: {
            title: {
                text: 'Total'
            }

        },
        legend: {
            enabled: false
        },
        plotOptions: {
            series: {
                borderWidth: 0,
                dataLabels: {
                    enabled: true,
                    format: '{point.y}'
                }
            }
        },

        tooltip: {
            headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
            pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y}</b> of total<br/>'
        },

        series: [{
            name: 'Outlet Active Vs Register Outlet',
            colorByPoint: true,
            data: [
			
			
			
			
			
			 <?php
					  $months = array("January-01","February-02","March-03","April-04","May-05","June-06","July-07","August-08","September-09","October-10","November-11","December-12");
					  if($year=="")
					  {
						  $year = date('Y');
					  }
					  $total_register_outlet = $this->db->query("SELECT * FROM store WHERE customer_code !='' ".$motorist_type_query." ".$regional_query." ".$area_query." ".$distributor_query." ".$channel_query."   ")->num_rows();
					?>
					
					{
               		    name: '<?php echo "Register Outlet"; ?>',
                		y: <?php echo $total_register_outlet; ?>,
                	    drilldown: '<?php echo "Register Outlet"; ?>'
           		 }, 
			
					<?php
					  foreach($months as $month) {
					  
					  
					  $data_month = explode('-',$month);
					  $bulan = $data_month[1];
					  $nama_bulan = $data_month[0];
					  $data_oulet_active = $this->db->query("SELECT * FROM product_orders INNER JOIN store on store.customer_code = product_orders.customer_code WHERE product_orders.date BETWEEN '".$year."-".$bulan."-01 00:00:00' AND '".$year."-".$bulan."-31  23:59:59' ".$motorist_type_query." ".$regional_query." ".$area_query." ".$distributor_query." ".$product_query." ".$channel_query." group by store.customer_code ")->num_rows();
					  
					
					 
					  ?>
					  
					  	{
						name: '<?php echo $nama_bulan; ?>',
						y: <?php echo $data_oulet_active; ?>,
						drilldown: '<?php echo $nama_bulan; ?>'
							},
					  
					  <?php
					  
						
					
					  }
				
						?>
						
						
			
			
			
			
			
			
			
			]
        }]
    });
	
</script>

