 <!-- HEADER -->
 <section class="content-header">
          <h1>
            Charth
            <small>Outlet Contribution Tracking</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="<?php echo BASE_URL(); ?>"><i class="fa fa-dashboard"></i>Home</a></li>
            <li><a href="<?php echo BASE_URL()."home/outletContributionTracking/"; ?>"><i class="fa fa-dashboard"></i>Outlet Contribution</a></li>
          </ol>
        </section>
  
  
   <!-- Content -->
   <section class="content">
          <div class="box sms box-default color-palette-box">
            <div class="box-header with-border">
              <h3 class="box-title"><i class="fa fa-bar-chart"></i>Outlet Contribution</h3>
            </div>
            <div class="box-body">
            
            <div id="wrapper-table">
           
            <?php
			$search = isset($_GET['search']) ? $_GET['search'] : '';
			$bulan = isset($_GET['bulan']) ? $_GET['bulan'] : '';
			if($bulan=="")
			{
				$bulan = date('m');
			}
			
			$date_now = date('d');
			$month_now = date('m');
			if($bulan!=$month_now)
			{$date_now = "31";}
			
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
			
			
			$product = isset($_GET['product']) ? $_GET['product'] : '';
			if(isset($_GET['product']))
			{$product_implode = "'" . implode("','", $product) . "'";;}
			else
			{$product_implode = "";}
			
			
			$distributor = isset($_GET['distributor']) ? $_GET['distributor'] : '';
			if(isset($_GET['distributor']))
			{$distributor_implode = "'" . implode("','", $distributor) . "'";;}
			else
			{$distributor_implode = "";}
			
			
			$motorist= isset($_GET['motorist']) ? $_GET['motorist'] : '';
			if(isset($_GET['distributor']))
			{$motorist_implode = "'" . implode("','", $motorist) . "'";;}
			else
			{$motorist_implode = "";}
			
			
			$motorist_type = isset($_GET['motorist_type']) ? $_GET['motorist_type'] : '';
			if(isset($_GET['motorist_type']))
			{$motorist_type_implode = implode(",",$motorist_type);}
			else
			{$motorist_type_implode = "";}
			
			$tahun = isset($_GET['tahun']) ? $_GET['tahun'] : '';
			if($tahun=="")
			{
				$tahun = date('Y');
			}
			
			function convert_price($price)
			{
				echo "Rp. ".number_format($price, 0 , '' , '.' );		
			}
			?>
            
            
            <div id="wrapper-console" class="clearfix">
                <div id="wrapper-search" class="chart">
                             <form action="<?php echo base_url()."index.php/home/outletContributionTracking" ?>" method="get">
                             <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                                
                                <?php if($data_account[0]['user_type']=="Administrator"){ ?>
                                 <div class="select-filter">
                             	<select name="motorist_type[]" id="select-motorist-type" multiple="multiple" >
                              	<?php foreach($data_motorist_type as $data_motorist_type) {?>
                              	<option <?php if(isset($_GET['motorist_type'])) {if(in_array($data_motorist_type['id_motorist_type'], $motorist_type)) {?> selected="selected" <?php }} ?> value="<?php echo $data_motorist_type['id_motorist_type']; ?>"><?php echo $data_motorist_type['motorist_type']; ?></option>
                              	<?php } ?>
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
                             	<select name="area[]" id="select-area" multiple="multiple" >
                              	<?php foreach($data_area as $data_area) {?>
                              	<option <?php if(isset($_GET['area'])) {if(in_array($data_area['area'], $area)) {?> selected="selected" <?php }} ?> value="<?php echo $data_area['area']; ?>"><?php echo $data_area['area']; ?></option>
                              	<?php } ?>
                             	</select>
                             	</div>
                                
                                <div class="select-filter">
                             	<select name="distributor[]" id="select-distributor" multiple="multiple" >
                              	<?php foreach($data_distributor as $data_distributor) {?>
                              	<option <?php if(isset($_GET['distributor'])) {if(in_array($data_distributor['distributor_code'], $distributor)) {?> selected="selected" <?php }} ?> value="<?php echo $data_distributor['distributor_code']; ?>"><?php echo $data_distributor['distributor_name']; ?>-<?php echo $data_distributor['distributor_code']; ?></option>
                              	<?php } ?>
                             	</select>
                             	</div>
                                
                                <div class="select-filter">
                             	<select name="motorist[]" id="select-motorist" multiple="multiple" >
                              	<?php foreach($data_motorist as $data_motorist) {?>
                              	<option <?php if(isset($_GET['motorist'])) {if(in_array($data_motorist['id_motorist'], $motorist)) {?> selected="selected" <?php }} ?> value="<?php echo $data_motorist['id_motorist']; ?>"><?php echo $data_motorist['motorist_name']; ?>-<?php echo $data_motorist['motorist_code']; ?></option>
                              	<?php } ?>
                             	</select>
                                </div>
                                
                                <div class="select-filter">
                             	<select name="product[]" id="select-product" multiple="multiple" >
                              	<?php foreach($data_product as $data_product) {?>
                              	<option <?php if(isset($_GET['product'])) {if(in_array($data_product['id_product'], $product)) {?> selected="selected" <?php }} ?> value="<?php echo $data_product['id_product']; ?>"><?php echo $data_product['sku_front_end']; ?></option>
                              	<?php } ?>
                             	</select>
                             	</div>
                                
                                
                                <select name="bulan" id="bulan">
                                	<option <?php if($bulan==""){ ?> selected="selected" <?php } ?> value="">Choose Month</option>
                                    <option <?php if($bulan=="01"){ ?> selected="selected" <?php } ?> value="01">January</option>
                                    <option <?php if($bulan=="02"){ ?> selected="selected" <?php } ?> value="02">February</option>
                                    <option <?php if($bulan=="03"){ ?> selected="selected" <?php } ?> value="03">March</option>
                                    <option <?php if($bulan=="04"){ ?> selected="selected" <?php } ?> value="04">April</option>
                                    <option <?php if($bulan=="05"){ ?> selected="selected" <?php } ?> value="05">May</option>
                                    <option <?php if($bulan=="06"){ ?> selected="selected" <?php } ?> value="06">Juni</option>
                                    <option <?php if($bulan=="07"){ ?> selected="selected" <?php } ?> value="07">July</option>
                                    <option <?php if($bulan=="08"){ ?> selected="selected" <?php } ?> value="08">August</option>
                                    <option <?php if($bulan=="09"){ ?> selected="selected" <?php } ?> value="09">September</option>
                                    <option <?php if($bulan=="10"){ ?> selected="selected" <?php } ?> value="10">October</option>
                                    <option <?php if($bulan=="11"){ ?> selected="selected" <?php } ?> value="11">November</option>
                                    <option <?php if($bulan=="12"){ ?> selected="selected" <?php } ?> value="12">December</option>
                                </select>
                                
                                <select name="tahun" id="tahun">
                                	<option value="">Choose year</option>
                                    <option value="2016">2016</option>
                                    <option value="2017">2017</option>
                                    <option value="2018">2018</option>
                                </select>
                                 
                                <?php } ?>
                                
                                
                                <input type="submit" id="submit"  value="Search"/>
                                
                                <?php if($motorist_type!="" or $regional!="" or $area!="" or $bulan!="" or $distributor!="" or $tahun!="" or $product!="")
								{?>
                                <a href="<?php echo base_url()."index.php/home/outletContributionTracking" ?>" id="clear-search">Clear Search</a>
                                <?php } ?>
                             </form>
                </div>
               </div>
            
            
            	<div class="left-chart">
                <div id="chart-1" style="min-width: 310px; height: 400px; max-width: 600px; margin: 0 auto"></div>
                </div>
                
                <div class="right-chart">
                <?php 
				
				?>
                </div>
              
                
           
            </div>
            
            </div>
      </section>
<script>

 $('#chart-1').highcharts({
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie'
            },
            title: {
                text: 'Outlet contribution by channel'
            },
            tooltip: {
                pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
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
                name: 'Channel',
                colorByPoint: true,
                data: [
				
				<?php foreach($data_channel as $data_channel) {
				
				$tanggal_bulan_awal = $tahun.'-'.$bulan."-01 00:00:00";
				$tanggal_bulan_akhir = $tahun.'-'.$bulan."-31 23:59:59";	
				
				$this->db->select("id_store");
				$this->db->group_by('store.customer_code'); 
				
				
				if($motorist_type_implode!="")
				{
					$this->db->where('motorist.motorist_type in ('.$motorist_type.') ');
				}
		
				$this->db->where("channel_code = '".$data_channel->classification_code."' ");
				$this->db->where("product_orders.date between '".$tanggal_bulan_awal."' AND '".$tanggal_bulan_akhir."' ");
				$this->db->join('product_orders', 'product_orders.customer_code = store.customer_code');
				$this->db->join('distributor', 'distributor.distributor_code = store.distributor_code',"LEFT");
				$this->db->join('motorist', 'motorist.id_motorist = motorist.id_motorist',"LEFT");
				$data = $this->db->get("store")->num_rows;
				?>
				
				{
					
                    name: '<?php echo $data_channel->channel_description ?>-<?php echo $data; ?>',
                    y: <?php echo $data; ?>
                },
				<?php } ?>
				
				]
            }]
        });
		
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

$("#select-distributor").pqSelect({
   multiplePlaceholder: 'Select Distributor',
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

$("#select-motorist").pqSelect({
   multiplePlaceholder: 'Select Motorist',
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