 <!-- HEADER -->
 <section class="content-header">
          <h1>
            Stt Motorist Motorist
            <small>Chart Motorist Ado</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="<?php echo BASE_URL(); ?>"><i class="fa fa-dashboard"></i>Home</a></li>
            <li><a href="<?php echo BASE_URL()."chart_motorist/sttMotorist/"; ?>"><i class="fa fa-dashboard"></i>Chart STT Motorist</a></li>
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
              <h3 class="box-title"><i class="fa fa-table"></i> Chart STT Motorist</h3>
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
			
			
			$motorist_type = isset($_GET['motorist_type']) ? $_GET['motorist_type'] : '';
			if(isset($_GET['product']))
			{$motorist_type_implode = implode(",",$motorist_type);}
			else
			{$motorist_type_implode = "";}
			
			$motorist = isset($_GET['motorist']) ? $_GET['motorist'] : '';
			if(isset($_GET['motorist']))
			{$motorist_implode = "'" . implode("','", $motorist) . "'";}
			else
			{$motorist_implode = "";}
			
			?>
            <div id="wrapper-console" class="clearfix">
                <div id="wrapper-search">
                             <form action="<?php echo base_url()."index.php/chart_motorist/sttMotorist/" ?>" method="get">
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
                             
                             
                             
                              
                                <input type="submit" id="submit"  value="Search"/>
                              
                                 <?php if($date!="" or $motorist_type_implode!="")
								{?>
                                <a href="<?php echo base_url()."index.php/chart_motorist/sttMotorist/" ?>" id="clear-search-filter-store">Clear Search</a>
                   <?php } ?>
                             </form>
                </div>
                
                
               
                </div>
            <div id="wrapper-console" class="clearfix">
            <div class="grid_4 height400">             
           	
            <?php 
			
					if($motorist_implode!="")
					{ $motorist = 'AND motorist_code in ('.$motorist_implode.') '; }
					else
					{ $motorist = ''; }
					
					
					
					
					
					$total_motorist = 0;
					$data_motorist_up = 0;
					$data_motorist_under = 0;
					foreach($data_motorist as $data_motorist)
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
						if($data_total[0]['total_penjualan']>22500000)
						{$data_motorist_up = $data_motorist_up + 1;}
						
						else if($data_total[0]['total_penjualan']<22500000)
						{$data_motorist_under = $data_motorist_under +1;}
					}
					
					
					
					
			
			
			
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



$("#select-motorist-type").pqSelect({
   multiplePlaceholder: 'Select Motorist Type',
   checkbox: true //adds checkbox to options    
   }).on("change", function(evt) {
      var val = $(this).val();
    })
	
</script>

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
            text: 'STT Performance Motorist'
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
                ['STT Under Rp. 22,5 juta', <?php echo $data_motorist_under; ?>],
                ['STT More Rp. 22,5 juta', <?php echo $data_motorist_up; ?>]
            ]
        }]
    });
	
</script>

