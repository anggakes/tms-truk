 <!-- HEADER -->
 <section class="content-header">
          <h1>
            Channel Outlet Motorist
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
			
			?>
            <div id="wrapper-console" class="clearfix">
                <div id="wrapper-search">
                             <form action="<?php echo base_url()."index.php/chart_motorist/" ?>" method="get">
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
                              
                                <input type="submit" id="submit"  value="Search"/>
                                <?php if($product_implode!="" && $motorist_implode!="" && $date!=="")
								{?>
                                <a href="<?php echo base_url()."index.php/channel" ?>" id="clear-search">Clear Search</a>
                                <?php } ?>
                                 <?php if($date!="" or $motorist_implode!="" or $product_implode!="")
								{?>
                                <a href="<?php echo base_url()."index.php/chart_motorist/" ?>" id="clear-search-filter-store">Clear Search</a>
                   <?php } ?>
                             </form>
                </div>
                
                
               
                </div>
            <div id="wrapper-console" class="clearfix">
            <div class="grid_4 height400">             
           	
           <?php  $product_query = 'AND product_orders.id_product in ('.$product_implode.') '; 
						//echo $product_query;
						?>
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


$("#select-motorist").pqSelect({
   multiplePlaceholder: 'Select Motorist',
   checkbox: true //adds checkbox to options    
   }).on("change", function(evt) {
      var val = $(this).val();
    })
</script>

<script>

  // Build the chart
        $('#container').highcharts({
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie'
            },
            title: {
                text: 'Register Outlet By Channel'
            },
            tooltip: {
                pointFormat: ': <b>{point.percentage:.1f}%</b>{series.hoi}'
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: false
                    },
                    showInLegend: true
                }
            },
            series: [{
                colorByPoint: true,
                data: [
				
				  <?php foreach($data_chart as $data_chart) {
					
					if($motorist_implode!="")
					{ $motorist = 'AND store.motorist_code in ('.$motorist_implode.') '; }
					else
					{ $motorist = ''; }
					
					if($product_implode == '')
					{
						$total_store = $this->db->query("SELECT * FROM store WHERE channel_code = '".$data_chart->classification_code."' ".$motorist." AND distributor_code = '".$data_account[0]['code']."' ")->num_rows();
						
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
							
							$total_store = $this->db->query("SELECT * FROM store INNER JOIN product_orders on product_orders.customer_code = store.customer_code WHERE channel_code = '".$data_chart->classification_code."' ".$product_query." ".$motorist." AND distributor_code = '".$data_account[0]['code']."' AND product_orders.date BETWEEN '".$tanggal_from." 00:00:00' AND '".$tanggal_to." 23:59:59' group BY store.customer_code ")->num_rows();  
						}
						else
						{
					
							$total_store = $this->db->query("SELECT * FROM store INNER JOIN product_orders on product_orders.customer_code = store.customer_code WHERE channel_code = '".$data_chart->classification_code."' ".$product_query." ".$motorist." AND distributor_code = '".$data_account[0]['code']."' group BY store.customer_code ")->num_rows();
							
							}
						
						
					}
					
					if($total_store>0)
					{	   
					?>
					
					{
                    name: '<?php echo $data_chart->channel_description; ?> (<?php echo $total_store ?>)',
                    y:<?php echo $total_store; ?>,
                	},
				
					<?php
					}
					} ?>
					
				
				
				]
            }]
        });
</script>

