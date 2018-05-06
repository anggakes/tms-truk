 <!-- HEADER -->
 <section class="content-header">
          <h1>
            Chart Admin
            <small>Motorist Performance Tracking</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="<?php echo BASE_URL(); ?>"><i class="fa fa-dashboard"></i>Home</a></li>
            <li><a href="<?php echo BASE_URL()."chart_admin/motoristperformancetracking/"; ?>"><i class="fa fa-dashboard"></i>Motorist Performance Tracking</a></li>
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
              <h3 class="box-title"><i class="fa fa-table"></i> Motorist Performance Tracking</h3>
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
                             <form action="<?php echo base_url()."index.php/chart_admin/motoristperformancetracking/" ?>" method="get">
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
                             
                             
                            
                              
                              
                          
                             
                          
                             
                                <input type="submit" id="submit"  value="Search" style="left:0px;"/>
                               
                                 <?php if($date!="" or $distributor_implode!="" or $product_implode!="" or $area_implode !="" or $regional_implode!="" or $motorist_type_implode!=""  )
								{?>
                                <a href="<?php echo base_url()."index.php/chart_admin/motoristperformancetracking/" ?>" id="clear-search-filter-store" style="margin-left:10px;">Clear Search</a>
                   <?php } ?>
                             </form>
                </div>
                
                
               
                </div>
            <div id="wrapper-console" class="clearfix">
            <div class="grid_4 ">             

        <div id="container" style="min-width: 100%; height: 400px; max-width: 100%; margin: 0 auto"></div>

            <?php 
				function convert_price($price)
			{
				echo "Rp. ".number_format($price, 0 , '' , '.' );		
					}
					$product_query = 'AND product_orders.id_product in ('.$product_implode.') '; 
					$data_loyalty = $this->db->query("SELECT * FROM master_loyalty")->result();
					if($regional_implode!="")
					{ $regional_query = 'AND distributor.regional in ('.$regional_implode.') '; }
					else
					{ $regional_query = ''; }
					
					if($distributor_implode!="")
					{ $distributor_query = 'AND motorist.distributor_code in ('.$distributor_implode.') '; }
					else
					{ $distributor_query = ''; }
				
					 
					if($area_implode!="")
					{ $area_query = 'AND distributor.area in ('.$area_implode.') '; }
					else
					{ $area_query = ''; }
					
					if($motorist_type_implode!="")
					{ $motorist_type_query = 'AND motorist.motorist_type in ('.$motorist_type_implode.') '; }
					else
					{ $motorist_type_query = ''; }
				
					
					$total_motorist = 0;
					$data_motorist_dibawah_10 = 0;
					$data_motorist_dibawah_15 = 0;
					$data_motorist_dibawah_20 = 0;
					$data_motorist_dibawah_22 = 0;
					$data_motorist_atas_22 = 0;
					
					$data_motorist = $this->db->query("SELECT * FROM motorist INNER JOIN distributor on distributor.distributor_code = motorist.distributor_code WHERE id_motorist != '' ".$motorist_type_query." ".$area_query." ".$regional_query." ".$distributor_query." ")->result();
					
					$data_sales_terbesar = 0;
					$data_sales_terbesar_distributor = 0;
					$data_sales_terbesar_motorist_code = 0;
					$data_sales_terbesar_id_motorist = 0;
					$data_sales_terbesar_motorist_name = 0;
					
					$data_sales_terkecil = 0;
					$data_sales_terkecil_distributor = 0;
					$data_sales_terkecil_motorist_code = 0;
					$data_sales_terkecil_id_motorist = 0;
					$data_sales_terkecil_motorist_name = 0;
					
					
					foreach($data_motorist as $data_motorist)
					{
						//echo $data_motorist->id_motorist."<br>";
						
						if($date != '')
						{
								$tanggal_range_pecah = explode(" - ", $date);
								$tanggal_from = $tanggal_range_pecah[0];
								$tanggal_from = explode("/", $tanggal_from);
								$tanggal_from = $tanggal_from[2].'-'.$tanggal_from[0].'-'.$tanggal_from[1];
								
								$tanggal_to = $tanggal_range_pecah[1];
								$tanggal_to = explode("/", $tanggal_to);
								$tanggal_to = $tanggal_to[2].'-'.$tanggal_to[0].'-'.$tanggal_to[1];
								
								$data_total = $this->db->query("SELECT SUM(price_total) as total_penjualan FROM product_orders WHERE id_motorist = '".$data_motorist->id_motorist."' AND product_orders.date BETWEEN '".$tanggal_from." 00:00:00' AND '".$tanggal_to." 23:59:59'  ")->result_array();  
						}
						else
						{
							$year_month = date('Y-m');
							$tanggal_from = $year_month.'-01';
							$tanggal_to = $year_month.'-31';
							$data_total = $this->db->query("SELECT SUM(price_total) as total_penjualan FROM product_orders WHERE id_motorist = '".$data_motorist->id_motorist."' AND product_orders.date BETWEEN '".$tanggal_from." 00:00:00' AND '".$tanggal_to." 23:59:59'  ")->result_array();
						}
						
						
						$total_motorist = $total_motorist + 1;
						//echo $total_motorist."-".$data_motorist->motorist_name."-".$data_total[0]['total_penjualan']."<br>";
						if($data_total[0]['total_penjualan']<10000000)
						{$data_motorist_dibawah_10 = $data_motorist_dibawah_10 +1;}
						else if($data_total[0]['total_penjualan']>10000000 && $data_total[0]['total_penjualan']<15000000 )
						{$data_motorist_dibawah_15 = $data_motorist_dibawah_15 +1;}
						else if($data_total[0]['total_penjualan']>15000000 && $data_total[0]['total_penjualan']<20000000 )
						{$data_motorist_dibawah_20 = $data_motorist_dibawah_20 +1;}
						else if($data_total[0]['total_penjualan']>20000000 && $data_total[0]['total_penjualan']<22500000 )
						{$data_motorist_dibawah_22 = $data_motorist_dibawah_22 +1;}
						else if($data_total[0]['total_penjualan']>22500000 )
						{$data_motorist_atas_22 = $data_motorist_atas_22 +1;}
						
						if($data_total[0]['total_penjualan']>$data_sales_terbesar)
						{
							$data_sales_terbesar = $data_total[0]['total_penjualan'];
							$data_sales_terbesar_distributor = $data_motorist->distributor_name;
							$data_sales_terbesar_motorist_code = $data_motorist->motorist_code;
							$data_sales_terbesar_id_motorist = $data_motorist->id_motorist;
							$data_sales_terbesar_motorist_name = $data_motorist->motorist_name;
						}
						
						if($data_total[0]['total_penjualan']<=$data_sales_terkecil)
						{
							$data_sales_terkecil = $data_total[0]['total_penjualan'];
							$data_sales_terkecil_distributor = $data_motorist->distributor_name;
							$data_sales_terkecil_motorist_code = $data_motorist->motorist_code;
							$data_sales_terkecil_id_motorist = $data_motorist->id_motorist;
							$data_sales_terkecil_motorist_name = $data_motorist->motorist_name;
						}
						
						
					}
				//	echo $data_sales_terbesar."<br>";
				//	echo $data_sales_terbesar_distributor."<br>";
				//	echo $data_sales_terbesar_motorist_code."<br>";
				//	echo $data_sales_terbesar_motorist_name."<br>";
				
				
				
						if($date != '')
						{
								$tanggal_range_pecah = explode(" - ", $date);
								$tanggal_from = $tanggal_range_pecah[0];
								$tanggal_from = explode("/", $tanggal_from);
								$tanggal_from = $tanggal_from[2].'-'.$tanggal_from[0].'-'.$tanggal_from[1];
								
								$tanggal_to = $tanggal_range_pecah[1];
								$tanggal_to = explode("/", $tanggal_to);
								$tanggal_to = $tanggal_to[2].'-'.$tanggal_to[0].'-'.$tanggal_to[1];
								
								$data_total_hari_kerja_terbesar = $this->db->query("SELECT * FROM absence WHERE id_motorist = '".$data_sales_terbesar_id_motorist."' AND date_absence BETWEEN '".$tanggal_from." 00:00:00' AND '".$tanggal_to." 23:59:59' AND status_absence = 'hadir'  ")->num_rows();  
								$data_total_hari_kerja_terkecil = $this->db->query("SELECT * FROM absence WHERE id_motorist = '".$data_sales_terkecil_id_motorist."' AND date_absence BETWEEN '".$tanggal_from." 00:00:00' AND '".$tanggal_to." 23:59:59' AND status_absence = 'hadir'  ")->num_rows();  
						}
						else
						{
							$year_month = date('Y-m');
							$tanggal_from = $year_month.'-01';
							$tanggal_to = $year_month.'-31';
							$data_total_hari_kerja_terbesar = $this->db->query("SELECT * FROM absence WHERE id_motorist = '".$data_sales_terbesar_id_motorist."' AND date_absence BETWEEN '".$tanggal_from." 00:00:00' AND '".$tanggal_to." 23:59:59' AND status_absence = 'hadir'  ")->num_rows();  
							$data_total_hari_kerja_terkecil = $this->db->query("SELECT * FROM absence WHERE id_motorist = '".$data_sales_terkecil_id_motorist."' AND date_absence BETWEEN '".$tanggal_from." 00:00:00' AND '".$tanggal_to." 23:59:59' AND status_absence = 'hadir'  ")->num_rows(); 
						}
							
				//	echo $data_sales_terkecil."<br>";
				//	echo $data_sales_terkecil_distributor."<br>";
				//	echo $data_sales_terkecil_motorist_code."<br>";
				//	echo $data_sales_terkecil_motorist_name."<br>";
					if($data_sales_terkecil=='')
					{$data_sales_terkecil =0;}
					
					//echo $total_motorist."<br>";
					//echo $data_motorist_dibawah_10."<br>";
					//echo $data_motorist_dibawah_15."<br>";
					//echo $data_motorist_dibawah_20."<br>";
					//echo $data_motorist_dibawah_22."<br>";
					//echo $data_motorist_atas_22."<br>";
			?>
            
            <h2>The Highest Achievement</h2>
            <table id="example2" class="table table-bordered table-hover">
            <thead>
            <tr>
            	<th>The Highest Achievement</th>
                <th>Distributor</th>
                <th>Motorist Code</th>
                <th>Work Days</th>
            </tr>
            </thead>
            
            <tbody>
            	<tr>
                	<td><?php convert_price($data_sales_terbesar); ?></td>
                    <td><?php echo $data_sales_terbesar_distributor; ?></td>
                    <td><?php echo $data_sales_terbesar_motorist_code; ?></td>
                    <td><?php echo $data_total_hari_kerja_terbesar; ?></td>
                </tr>
            </tbody>
            
            </table>
            
            
            <h2>The Lowest Achievement</h2>
            <table id="example2" class="table table-bordered table-hover">
            <thead>
            <tr>
            	<th>The Lowest Achievement</th>
                <th>Distributor</th>
                <th>Motorist Code</th>
                <th>Work Days</th>
            </tr>
            </thead>
            
            <tbody>
            	<tr>
                	<td><?php convert_price($data_sales_terkecil); ?></td>
               	    <td><?php echo $data_sales_terkecil_distributor; ?></td>
                    <td><?php echo $data_sales_terkecil_motorist_code; ?></td>
                    <td><?php echo $data_total_hari_kerja_terkecil; ?></td>
                </tr>
            </tbody>
            
            <table>
           
            
            
                  	 
            
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

$("#select-channel").pqSelect({
   multiplePlaceholder: 'Select Channel',
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
            text: 'Motorist sales achievement grouping'
        },
        xAxis: {
            type: 'category'
        },
        yAxis: {
            title: {
                text: ''
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
            name: 'Brands',
            colorByPoint: true,
            data: [{
                name: '< 10jt',
                y: <?php echo $data_motorist_dibawah_10; ?>,
                drilldown: '< 10jt'
            }, {
                name: '10jt - 15jt',
                y: <?php echo $data_motorist_dibawah_15; ?>,
                drilldown: '10jt - 15jt'
            }, {
                name: '15jt - 20jt',
                y: <?php echo $data_motorist_dibawah_20; ?>,
                drilldown: '10jt - 15jt'
            }, {
                name: '20jt - 22.5jt',
                y: <?php echo $data_motorist_dibawah_22; ?>,
                drilldown: '20jt - 22.5jt'
            }, {
                name: '> 22.5jt',
                y: <?php echo $data_motorist_atas_22; ?>,
                drilldown: '> 22.5jt'
            }]
        }]
    });
	
</script>
