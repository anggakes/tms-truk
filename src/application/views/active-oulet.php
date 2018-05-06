 <!-- HEADER -->
 <section class="content-header">
          <h1>
            Channel Active Outlet Motorist
            <small>Channel of E-tools</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="<?php echo BASE_URL(); ?>"><i class="fa fa-dashboard"></i>Home</a></li>
            <li><a href="<?php echo BASE_URL()."channel"; ?>"><i class="fa fa-dashboard"></i>Channel</a></li>
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
			
			$motorist = isset($_GET['motorist']) ? $_GET['motorist'] : '';
			if(isset($_GET['motorist']))
			{$motorist_implode = "'" . implode("','", $motorist) . "'";}
			else
			{$motorist_implode = "";}
			
			$channel = isset($_GET['channel']) ? $_GET['channel'] : '';
			if(isset($_GET['channel']))
			{$channel_implode = "'" . implode("','", $channel) . "'";}
			else
			{$channel_implode = "";}
			
			?>
            <div id="wrapper-console" class="clearfix">
                <div id="wrapper-search">
                             <form action="<?php echo base_url()."index.php/chart_motorist/outletActive" ?>" method="get">
                             <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                               	
                             
                              
                              
                              <div class="select-filter">
                              <select name="motorist[]" id="select-motorist" multiple="multiple" >
                              <?php foreach($data_motorist as $data_motorist) {?>
                              <option <?php if(isset($_GET['motorist'])) {if(in_array($data_motorist['motorist_code'], $motorist)) {?> selected="selected" <?php }} ?> value="<?php echo $data_motorist['motorist_code']; ?>"><?php echo $data_motorist['motorist_name']; ?>-<?php echo $data_motorist['motorist_code']; ?></option>
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
                              
                              
                              <div class="select-filter">
                             <select name="channel[]" id="select-channel" multiple="multiple" >
                              <?php foreach($data_channel as $data_channel) {?>
                              <option <?php if(isset($_GET['channel'])) {if(in_array($data_channel['classification_code'], $channel)) {?> selected="selected" <?php }} ?> value="<?php echo $data_channel['classification_code']; ?>"><?php echo $data_channel['classification_code']; ?>-<?php echo $data_channel['channel_description']; ?></option>
                              <?php } ?>
                             </select>
                             </div>
                             
                              <div class="select-filter">
                             <select name="year" id="year"  >
                              <option value="2016">2016</option>
                              <option value="2017">2017</option>
                             </select>
                             </div>
                             
                                <input type="submit" id="submit"  value="Search" style="left:0 !important; margin-top:10px; margin-right:10px;"/>
                               
                                 <?php if($date!="" or $motorist_implode!="" or $product_implode!="")
								{?>
                                <a href="<?php echo base_url()."index.php/chart_motorist/outletActive/" ?>" id="clear-search-filter-store">Clear Search</a>
                   <?php } ?>
                             </form>
                </div>
                
                
               
                </div>
            <div id="wrapper-console" class="clearfix">
            <div class="grid_4 height400">             
            
           <div id="container" style="min-width: 310px; height: 400px; max-width: 600px; margin: 0 auto"></div>
            
            
                  	 
            
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


$("#select-motorist").pqSelect({
   multiplePlaceholder: 'Select Motorist',
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
					  
					  if($motorist_implode!="")
					  {$motorist = 'AND store.motorist_code in ('.$motorist_implode.') '; }
					  else
					  {$motorist = ''; }
					  
					  
					  if($channel_implode!="")
					  {$channel_query = 'AND store.channel_code in ('.$channel_implode.') '; }
					  else
					  {$channel_query = ''; }
					  
					 
					  
					  if($product_implode=="")
					  { $product_query = '';}
					  else
					  { $product_query = 'AND product_orders.id_product in ('.$product_implode.')'; }
					  $total_register_outlet = $this->db->query("SELECT * FROM store WHERE distributor_code = '".$data_account[0]['code']."' ".$motorist." ".$channel_query." ")->num_rows();
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
					  $data_oulet_active = $this->db->query("SELECT * FROM product_orders INNER JOIN store on store.customer_code = product_orders.customer_code WHERE distributor_code = '".$data_account[0]['code']."' AND product_orders.date BETWEEN '".$year."-".$bulan."-01 00:00:00' AND '".$year."-".$bulan."-31  23:59:59' ".$product_query." ".$motorist." ".$channel_query." group by store.customer_code ")->num_rows();
					  
					
					 
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

