 <!-- HEADER -->
 <section class="content-header">
          <h1>
            Chart Admin
            <small>Motorist Performance STT</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="<?php echo BASE_URL(); ?>"><i class="fa fa-dashboard"></i>Home</a></li>
            <li><a href="<?php echo BASE_URL()."chart_admin/motoristPerformanceStt/"; ?>"><i class="fa fa-dashboard"></i>Motorist Performance STT</a></li>
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
              <h3 class="box-title"><i class="fa fa-table"></i> Motorist Performance STT</h3>
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
                             <form action="<?php echo base_url()."index.php/chart_admin/motoristPerformanceStt/" ?>" method="get">
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
                              <select name="motorist_type[]" id="select-motorist-type" multiple="multiple" >
                              <?php foreach($data_motorist_type as $data_motorist_type) {?>
                              <option <?php if(isset($_GET['motorist_type'])) {if(in_array($data_motorist_type['id_motorist_type'], $motorist_type)) {?> selected="selected" <?php }} ?> value="<?php echo $data_motorist_type['id_motorist_type']; ?>"><?php echo $data_motorist_type['motorist_type']; ?></option>
                              <?php } ?>
                             </select>
                             </div>
                             
                             
                            
                              
                              
                          
                             
                          
                             
                                <input type="submit" id="submit"  value="Search" style="left:0px;"/>
                               
                                 <?php if($date!="" or $motorist_type_implode!=""  )
								{?>
                                <a href="<?php echo base_url()."index.php/chart_admin/motoristPerformanceStt/" ?>" id="clear-search-filter-store" style="margin-left:10px;">Clear Search</a>
                   <?php } ?>
                             </form>
                </div>
                
                
               
                </div>
            <div id="wrapper-console" class="clearfix">
            <div class="grid_4 ">             


        <div id="container" style="min-width: 100%; height: 400px; max-width: 100%; margin: 0 auto"></div><br />
<hr /><br />

       
       
        <div id="container_wjr" style="min-width: 50%; float:left; height: 400px; max-width: 50%; margin: 0 auto"></div>
        <div id="container_cjr" style="min-width: 50%; float:left; height: 400px; max-width: 50%; margin: 0 auto"></div><br />

        <hr /><br />

        <div id="container_ejr" style="min-width: 50%; float:left; height: 400px; max-width: 50%; margin: 0 auto"></div>
        <div id="container_sulawesi" style="min-width: 50%; float:left; 50%; height: 400px; max-width: 50%; margin: 0 auto"></div><br />

       	 <hr /><br />

        <div id="container_sumatera" style="min-width: 50%; float:left; 50%; height: 400px; max-width: 50%; margin: 0 auto"></div>
       
        

            <?php 
				function convert_price($price)
			{
				echo "Rp. ".number_format($price, 0 , '' , '.' );		
					}
				
					
					if($motorist_type_implode!="")
					{ $motorist_type_query = 'AND motorist.motorist_type in ('.$motorist_type_implode.') '; }
					else
					{ $motorist_type_query = ''; }
					
					
					$total_motorist_national = 0;
					$data_motorist_up_national = 0;
					$data_motorist_under_national = 0;
					$data_motorist_national = $this->db->query("SELECT * FROM motorist WHERE id_motorist !='' ".$motorist_type_query." ")->result();
					foreach($data_motorist_national as $data_motorist_national)
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
								
								$data_total = $this->db->query("SELECT SUM(price_total) as total_penjualan FROM product_orders WHERE id_motorist = '".$data_motorist_national->id_motorist."' AND product_orders.date BETWEEN '".$tanggal_from." 00:00:00' AND '".$tanggal_to." 23:59:59'  ")->result_array();  
						}
						else
						{
							$year_month = date('Y-m');
							$tanggal_from = $year_month.'-01';
							$tanggal_to = $year_month.'-31';
							$data_total = $this->db->query("SELECT SUM(price_total) as total_penjualan FROM product_orders WHERE id_motorist = '".$data_motorist_national->id_motorist."' AND product_orders.date BETWEEN '".$tanggal_from." 00:00:00' AND '".$tanggal_to." 23:59:59'  ")->result_array();
						}
						$total_motorist_national = $total_motorist_national + 1;
						//echo $total_motorist."-".$data_motorist->motorist_name."-".$data_total[0]['total_penjualan']."<br>";
						if($data_total[0]['total_penjualan']>22500000)
						{ 
							$data_motorist_up_national = $data_motorist_up_national + 1;}
						
						else if($data_total[0]['total_penjualan']<=22500000)
						{$data_motorist_under_national = $data_motorist_under_national +1;}
					}
					
					//echo $data_motorist_up_national;
					//echo $data_motorist_under_national;
					
					
					//WEST JAVA
					$total_motorist_wjr = 0;
					$data_motorist_up_wjr = 0;
					$data_motorist_under_wjr = 0;
					$data_motorist_wjr = $this->db->query("SELECT * FROM motorist INNER JOIN distributor on distributor.distributor_code = motorist.distributor_code WHERE distributor.regional = 'West Java' ".$motorist_type_query." ")->result();
					foreach($data_motorist_wjr as $data_motorist_wjr)
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
								
								$data_total = $this->db->query("SELECT SUM(price_total) as total_penjualan FROM product_orders WHERE id_motorist = '".$data_motorist_wjr->id_motorist."' AND product_orders.date BETWEEN '".$tanggal_from." 00:00:00' AND '".$tanggal_to." 23:59:59'  ")->result_array();  
						}
						else
						{
							$year_month = date('Y-m');
							$tanggal_from = $year_month.'-01';
							$tanggal_to = $year_month.'-31';
							$data_total = $this->db->query("SELECT SUM(price_total) as total_penjualan FROM product_orders WHERE id_motorist = '".$data_motorist_wjr->id_motorist."' AND product_orders.date BETWEEN '".$tanggal_from." 00:00:00' AND '".$tanggal_to." 23:59:59'  ")->result_array();
						}
						$total_motorist_wjr = $total_motorist_wjr + 1;
						//echo $total_motorist."-".$data_motorist->motorist_name."-".$data_total[0]['total_penjualan']."<br>";
						if($data_total[0]['total_penjualan']>22500000)
						{ 
							$data_motorist_up_wjr = $data_motorist_up_wjr + 1;}
						
						else if($data_total[0]['total_penjualan']<=22500000)
						{$data_motorist_under_wjr = $data_motorist_under_wjr +1;}
					}
					
					//echo $data_motorist_up_wjr."<br>";
					//echo $data_motorist_under_wjr;
					
					
					
					//EAST JAVA
					$total_motorist_ejr = 0;
					$data_motorist_up_ejr = 0;
					$data_motorist_under_ejr = 0;
					$data_motorist_ejr = $this->db->query("SELECT * FROM motorist INNER JOIN distributor on distributor.distributor_code = motorist.distributor_code WHERE distributor.regional = 'East Java' ".$motorist_type_query." ")->result();
					foreach($data_motorist_ejr as $data_motorist_ejr)
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
								
								$data_total = $this->db->query("SELECT SUM(price_total) as total_penjualan FROM product_orders WHERE id_motorist = '".$data_motorist_ejr->id_motorist."' AND product_orders.date BETWEEN '".$tanggal_from." 00:00:00' AND '".$tanggal_to." 23:59:59'  ")->result_array();  
						}
						else
						{
							$year_month = date('Y-m');
							$tanggal_from = $year_month.'-01';
							$tanggal_to = $year_month.'-31';
							$data_total = $this->db->query("SELECT SUM(price_total) as total_penjualan FROM product_orders WHERE id_motorist = '".$data_motorist_ejr->id_motorist."' AND product_orders.date BETWEEN '".$tanggal_from." 00:00:00' AND '".$tanggal_to." 23:59:59'  ")->result_array();
						}
						$total_motorist_ejr = $total_motorist_ejr + 1;
						//echo $total_motorist."-".$data_motorist->motorist_name."-".$data_total[0]['total_penjualan']."<br>";
						if($data_total[0]['total_penjualan']>22500000)
						{ 
							$data_motorist_up_ejr = $data_motorist_up_ejr + 1;}
						
						else if($data_total[0]['total_penjualan']<=22500000)
						{$data_motorist_under_ejr = $data_motorist_under_ejr +1;}
					}
					
					//echo $data_motorist_up_ejr."<br>";
					//echo $data_motorist_under_ejr;
					
					
					
					//CENTRAL JAVA
					$total_motorist_cjr = 0;
					$data_motorist_up_cjr = 0;
					$data_motorist_under_cjr = 0;
					$data_motorist_cjr = $this->db->query("SELECT * FROM motorist INNER JOIN distributor on distributor.distributor_code = motorist.distributor_code WHERE distributor.regional = 'Central Java' ".$motorist_type_query." ")->result();
					foreach($data_motorist_cjr as $data_motorist_cjr)
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
								
								$data_total = $this->db->query("SELECT SUM(price_total) as total_penjualan FROM product_orders WHERE id_motorist = '".$data_motorist_cjr->id_motorist."' AND product_orders.date BETWEEN '".$tanggal_from." 00:00:00' AND '".$tanggal_to." 23:59:59'  ")->result_array();  
						}
						else
						{
							$year_month = date('Y-m');
							$tanggal_from = $year_month.'-01';
							$tanggal_to = $year_month.'-31';
							$data_total = $this->db->query("SELECT SUM(price_total) as total_penjualan FROM product_orders WHERE id_motorist = '".$data_motorist_cjr->id_motorist."' AND product_orders.date BETWEEN '".$tanggal_from." 00:00:00' AND '".$tanggal_to." 23:59:59'  ")->result_array();
						}
						$total_motorist_cjr = $total_motorist_cjr + 1;
						//echo $total_motorist."-".$data_motorist->motorist_name."-".$data_total[0]['total_penjualan']."<br>";
						if($data_total[0]['total_penjualan']>22500000)
						{ 
							$data_motorist_up_cjr = $data_motorist_up_cjr + 1;}
						
						else if($data_total[0]['total_penjualan']<=22500000)
						{$data_motorist_under_cjr = $data_motorist_under_cjr +1;}
					}
					
					//echo $data_motorist_up_cjr."<br>";
					//echo $data_motorist_under_cjr;
					
					
					
					//Sumatera
					$total_motorist_sumatera = 0;
					$data_motorist_up_sumatera = 0;
					$data_motorist_under_sumatera = 0;
					$data_motorist_sumatera = $this->db->query("SELECT * FROM motorist INNER JOIN distributor on distributor.distributor_code = motorist.distributor_code WHERE distributor.regional = 'Sumatera' ".$motorist_type_query." ")->result();
					foreach($data_motorist_cjr as $data_motorist_cjr)
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
								
								$data_total = $this->db->query("SELECT SUM(price_total) as total_penjualan FROM product_orders WHERE id_motorist = '".$data_motorist_sumatera->id_motorist."' AND product_orders.date BETWEEN '".$tanggal_from." 00:00:00' AND '".$tanggal_to." 23:59:59'  ")->result_array();  
						}
						else
						{
							$year_month = date('Y-m');
							$tanggal_from = $year_month.'-01';
							$tanggal_to = $year_month.'-31';
							$data_total = $this->db->query("SELECT SUM(price_total) as total_penjualan FROM product_orders WHERE id_motorist = '".$data_motorist_sumatera->id_motorist."' AND product_orders.date BETWEEN '".$tanggal_from." 00:00:00' AND '".$tanggal_to." 23:59:59'  ")->result_array();
						}
						$total_motorist_sumatera = $total_motorist_sumatera + 1;
						//echo $total_motorist."-".$data_motorist->motorist_name."-".$data_total[0]['total_penjualan']."<br>";
						if($data_total[0]['total_penjualan']>22500000)
						{ 
							$data_motorist_up_sumatera = $data_motorist_up_sumatera + 1;}
						
						else if($data_total[0]['total_penjualan']<=22500000)
						{$data_motorist_under_sumatera = $data_motorist_under_sumatera +1;}
					}
					
					//echo $data_motorist_up_sumatera."<br>";
					//echo $data_motorist_under_sumatera;
					
					
					
					//Sulawesi
					$total_motorist_sulawesi = 0;
					$data_motorist_up_sulawesi = 0;
					$data_motorist_under_sulawesi = 0;
					$data_motorist_sulawesi = $this->db->query("SELECT * FROM motorist INNER JOIN distributor on distributor.distributor_code = motorist.distributor_code WHERE distributor.regional = 'Sulawesi' ".$motorist_type_query." ")->result();
					foreach($data_motorist_cjr as $data_motorist_cjr)
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
								
								$data_total = $this->db->query("SELECT SUM(price_total) as total_penjualan FROM product_orders WHERE id_motorist = '".$data_motorist_sulawesi->id_motorist."' AND product_orders.date BETWEEN '".$tanggal_from." 00:00:00' AND '".$tanggal_to." 23:59:59'  ")->result_array();  
						}
						else
						{
							$year_month = date('Y-m');
							$tanggal_from = $year_month.'-01';
							$tanggal_to = $year_month.'-31';
							$data_total = $this->db->query("SELECT SUM(price_total) as total_penjualan FROM product_orders WHERE id_motorist = '".$data_motorist_sulawesi>id_motorist."' AND product_orders.date BETWEEN '".$tanggal_from." 00:00:00' AND '".$tanggal_to." 23:59:59'  ")->result_array();
						}
						$total_motorist_sulawesi = $total_motorist_sulawesi + 1;
						//echo $total_motorist."-".$data_motorist->motorist_name."-".$data_total[0]['total_penjualan']."<br>";
						if($data_total[0]['total_penjualan']>22500000)
						{ 
							$data_motorist_up_sulawesi = $data_motorist_up_sulawesi + 1;}
						
						else if($data_total[0]['total_penjualan']<=22500000)
						{$data_motorist_under_sulawesi = $data_motorist_under_sulawesi +1;}
					}
					
					//echo $data_motorist_up_sulawesi."<br>";
					//echo $data_motorist_under_sulawesi;
				
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


<?php if($total_motorist_national>0){ ?>
<script>
 $('#container').highcharts({
        chart: {
            type: 'pie',
            options3d: {
                enabled: true,
                alpha: 45
            }
        },
        title: {
            text: 'STT Performance Motorist National'
        },
        plotOptions: {
            pie: {
                innerSize: 100,
                depth: 45
            }
        },
        series: [{
            name: 'Total Motorist',
            data: [
                ['STT Under Rp. 22,5 juta', <?php echo $data_motorist_under_national; ?>],
                ['STT More Rp. 22,5 juta', <?php echo $data_motorist_up_national; ?>]
            ]
        }]
    });
	
</script>
<?php } ?>

<?php if($total_motorist_wjr>0){ ?>
<script>
 $('#container_wjr').highcharts({
        chart: {
            type: 'pie',
            options3d: {
                enabled: true,
                alpha: 45
            }
        },
        title: {
            text: 'STT Performance Motorist WJR'
        },
        plotOptions: {
            pie: {
                innerSize: 100,
                depth: 45
            }
        },
        series: [{
            name: 'Total Motorist',
            data: [
                ['STT Under Rp. 22,5 juta', <?php echo $data_motorist_under_wjr; ?>],
                ['STT More Rp. 22,5 juta', <?php echo $data_motorist_up_wjr; ?>]
            ]
        }]
    });
	
</script>
<?php } ?>

<?php if($total_motorist_cjr>0){ ?>
<script>
 $('#container_cjr').highcharts({
        chart: {
            type: 'pie',
            options3d: {
                enabled: true,
                alpha: 45
            }
        },
        title: {
            text: 'STT Performance Motorist CJR'
        },
        plotOptions: {
            pie: {
                innerSize: 100,
                depth: 45
            }
        },
        series: [{
            name: 'Total Motorist',
            data: [
                ['STT Under Rp. 22,5 juta', <?php echo $data_motorist_under_cjr; ?>],
                ['STT More Rp. 22,5 juta', <?php echo $data_motorist_up_cjr; ?>]
            ]
        }]
    });
	
</script>
<?php } ?>
<?php if($total_motorist_ejr>0){ ?>
<script>
 $('#container_ejr').highcharts({
        chart: {
            type: 'pie',
            options3d: {
                enabled: true,
                alpha: 45
            }
        },
        title: {
            text: 'STT Performance Motorist EJR'
        },
        plotOptions: {
            pie: {
                innerSize: 100,
                depth: 45
            }
        },
        series: [{
            name: 'Total Motorist',
            data: [
                ['STT Under Rp. 22,5 juta', <?php echo $data_motorist_under_ejr; ?>],
                ['STT More Rp. 22,5 juta', <?php echo $data_motorist_up_ejr; ?>]
            ]
        }]
    });
	
</script>
<?php } ?>

<?php if($total_motorist_sulawesi>0){ ?>
<script>
 $('#container_sulawesi').highcharts({
        chart: {
            type: 'pie',
            options3d: {
                enabled: true,
                alpha: 45
            }
        },
        title: {
            text: 'STT Performance Motorist Sulawesi'
        },
        plotOptions: {
            pie: {
                innerSize: 100,
                depth: 45
            }
        },
        series: [{
            name: 'Total Motorist',
            data: [
                ['STT Under Rp. 22,5 juta', <?php echo $data_motorist_under_sulawesi; ?>],
                ['STT More Rp. 22,5 juta', <?php echo $data_motorist_up_sulawesi; ?>]
            ]
        }]
    });
	
</script>
<?php } ?>

<?php if($total_motorist_sumatera>0){ ?>
<script>
 $('#container_sumatera').highcharts({
        chart: {
            type: 'pie',
            options3d: {
                enabled: true,
                alpha: 45
            }
        },
        title: {
            text: 'STT Performance Motorist Sumatera'
        },
        plotOptions: {
            pie: {
                innerSize: 100,
                depth: 45
            }
        },
        series: [{
            name: 'Total Motorist',
            data: [
                ['STT Under Rp. 22,5 juta', <?php echo $data_motorist_under_sumatera; ?>],
                ['STT More Rp. 22,5 juta', <?php echo $data_motorist_up_sumatera; ?>]
            ]
        }]
    });
	
</script>
<?php } ?>
