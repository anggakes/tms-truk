 <!-- HEADER -->
 <section class="content-header">
          <h1>
            Chart Admin
            <small>STT Achievement</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="<?php echo BASE_URL(); ?>"><i class="fa fa-dashboard"></i>Home</a></li>
            <li><a href="<?php echo BASE_URL()."chart_admin/sttAchievement/"; ?>"><i class="fa fa-dashboard"></i>ATT Achievement</a></li>
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
              <h3 class="box-title"><i class="fa fa-table"></i> STT Achievement</h3>
            </div>
            <div class="box-body">
           
            <div id="wrapper-table">
            <?php
			$search = isset($_GET['search']) ? $_GET['search'] : '';
			
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
                             <form action="<?php echo base_url()."index.php/chart_admin/sttAchievement/" ?>" method="get">
                             <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                               
                               
                           
                              
                         
                              
                              
                              
                              
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
                             <select name="year" id="year"  >
                              <option <?php if($year=="2016"){ ?> selected="selected" <?php } ?> value="2016">2016</option>
                              <option <?php if($year=="2017"){ ?> selected="selected" <?php } ?> value="2017">2017</option>
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
                               
                                 <?php if( $distributor_implode!="" or $product_implode!="" or $area_implode !="" or $regional_implode!="" or $motorist_type_implode!=""  )
								{?>
                                <a href="<?php echo base_url()."index.php/chart_admin/sttAchievement/" ?>" id="clear-search-filter-store" style="margin-left:10px;">Clear Search</a>
                   <?php } ?>
                             </form>
                </div>
                
                
               
                </div>
            <div id="wrapper-console" class="clearfix">
            <div class="grid_4 ">             

        <div id="container" style="min-width: 100%; height: 400px; max-width: 100%; margin: 0 auto"></div><br />
<hr /><br />

        
        <div id="container2" style="min-width: 100%; height: 400px; max-width: 100%; margin: 0 auto"></div>

            <?php 
				function convert_price($price)
			{
				echo "Rp. ".number_format($price, 0 , '' , '.' );		
					}
					
					if($distributor_implode!="")
					{ $distributor_query = 'AND motorist.distributor_code in ('.$distributor_implode.') ';
					  $distributor_query_store = 'AND store.distributor_code in ('.$distributor_implode.') ';
					
					 }
					else
					{ $distributor_query = ''; $distributor_query_store = ''; }
				
					if($product_implode!="")
					{ $product_query = 'AND product_orders.id_product in ('.$product_implode.') ';
					}
					else
					{ $product_query  = '';  }
					
					
					if($area_implode!="")
					{ $area_query = 'AND distributor.area in ('.$area_implode.') ';
					  $area_query_store = 'AND store.area in ('.$area_implode.') ';
					 }
					else
					{ $area_query = ''; $area_query_store = ''; }
					
					if($motorist_type_implode!="")
					{ $motorist_type_query = 'AND motorist.motorist_type in ('.$motorist_type_implode.') ';
						$motorist_type_query_store = 'AND store.motorist_type in ('.$motorist_type_implode.') ';
					
					 }
					else
					{ $motorist_type_query = ''; $motorist_type_query_store = ''; }
				
					
					?>
                    
                    
                     <?php
					  $months = array("January-01","February-02","March-03","April-04","May-05","June-06","July-07","August-08","September-09","October-10","November-11","December-12");
					  if($year=="")
					  {
						  $year = date('Y');
					  }
					  
					  
					  $data_regional = $this->db->query("SELECT * FROM master_regional")->result();
					
					 
					  
					 
					  
					  
				
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
            type: 'spline'
        },
        title: {
            text: 'STT Achievement'
        },
        xAxis: {
            categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
                'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
        },
        yAxis: {
            title: {
                text: 'Rupiah'
            },
            labels: {
                formatter: function () {
                    return this.value + ' IDR';
                }
            }
        },
        tooltip: {
            crosshairs: true,
            shared: true
        },
        plotOptions: {
            spline: {
                marker: {
                    radius: 4,
                    lineColor: '#666666',
                    lineWidth: 1
                }
            }
        },
        series: [
			
			<?php 
			 foreach($data_regional as $data_regional_1)
					 {
						 ?>
						 
						 
						 {
						name: '<?php echo $data_regional_1->regional_name; ?>',
						data: [
						
					
		
						 <?php
						 
						  foreach($months as $month) {
						  $data_month = explode('-',$month);
						  $bulan = $data_month[1];
						  $nama_bulan = $data_month[0];
						  $data_stt = $this->db->query("SELECT sum(price_total) as total_stt FROM product_orders INNER JOIN store on store.customer_code = product_orders.customer_code WHERE product_orders.date BETWEEN '".$year."-".$bulan."-01 00:00:00' AND '".$year."-".$bulan."-31  23:59:59' AND store.regional = '".$data_regional_1->regional_name."' ".$product_query." ".$distributor_query_store." ".$area_query_store." ".$motorist_type_query_store."  ")->result_array();
						  //echo $data_stt[0]['total_stt'].",";
						  if($data_stt[0]['total_stt']<=0)
						  {$total_stt = 0; }
						  else
						  {
							  $total_stt = $data_stt[0]['total_stt'];
							  }
						  
						  ?>
						  <?php echo $total_stt; ?>,
						  <?php
						  }
						  
						  ?>
						  
						  ]
						  },
						  <?php
					 }
			
			?>
            
          
		
		]
    });
	
</script>





<script>

 $('#container2').highcharts({
        chart: {
            type: 'spline'
        },
        title: {
            text: '% STT Achievement'
        },
        xAxis: {
            categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
                'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
        },
        yAxis: {
            title: {
                text: 'Percentage'
            },
            labels: {
                formatter: function () {
                    return this.value + '%';
                }
            }
        },
        tooltip: {
            crosshairs: true,
            shared: true
        },
        plotOptions: {
            spline: {
                marker: {
                    radius: 4,
                    lineColor: '#666666',
                    lineWidth: 1
                }
            }
        },
        series: [
			
		<?php
		
		 foreach($data_regional as $data_regional_2)
					  {
						  ?>
						  
						  {
						name: '<?php echo $data_regional_2->regional_name; ?>',
						data: [
						
						  
						  
						  <?php
						  $total_target = $this->db->query("SELECT SUM(target_bulanan) as total_target_bulanan FROM motorist INNER JOIN distributor on distributor.distributor_code = motorist.distributor_code WHERE distributor.regional = '".$data_regional_2->regional_name."' ".$area_query." ".$motorist_type_query." ")->result_array();
						  $total_target_bulanan = $total_target[0]['total_target_bulanan'];
						//  echo $total_target_bulanan."hai";
						
						
						  foreach($months as $month2) {
						  $data_month = explode('-',$month2);
						  $bulan = $data_month[1];
						  $nama_bulan = $data_month[0];
						  
						  
						  $data_stt = $this->db->query("SELECT sum(price_total) as total_stt FROM product_orders INNER JOIN store on store.customer_code = product_orders.customer_code WHERE product_orders.date BETWEEN '".$year."-".$bulan."-01 00:00:00' AND '".$year."-".$bulan."-31  23:59:59' AND store.regional = '".$data_regional_2->regional_name."' ".$product_query." ".$distributor_query_store." ".$area_query_store." ".$motorist_type_query_store."  ")->result_array();
						  
						  
						  if($total_target_bulanan>0)
						  {
							$persentasi_stt= ($data_stt[0]['total_stt'] * 100) / $total_target_bulanan;
							$persentasi_stt = number_format($persentasi_stt, 0, '.', '');
						  }
						  else
						  {$persentasi_stt=0;}
						//  echo $persentasi_stt."<br>";
						?>
						
						<?php echo $persentasi_stt; ?>,
						<?php
						
					  }
					  ?>
					    ]},
					  <?php
					 }
					  
		?>
						 
						 
						 

            
          
		
		]
    });
	
</script>