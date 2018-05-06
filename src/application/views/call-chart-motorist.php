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
                             <form action="<?php echo base_url()."index.php/chart_motorist/callMotorist/" ?>" method="get">
                             <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                               	
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
                                <a href="<?php echo base_url()."index.php/chart_motorist/callMotorist/" ?>" id="clear-search-filter-store">Clear Search</a>
                   <?php } ?>
                             </form>
                </div>
                
                
               
                </div>
            <div id="wrapper-console" class="clearfix">
            <div class="">             
           	
            <?php 
			
			
			
			
			function number_of_working_days($from, $to,$hari) {
			$workingDays = [$hari]; 
			$holidayDays = [];
		
			$from = new DateTime($from);
			$to = new DateTime($to);
			$to->modify('+1 day');
			$interval = new DateInterval('P1D');
			$periods = new DatePeriod($from, $interval, $to);
			$days = 0;
			foreach ($periods as $period) {
				if (!in_array($period->format('N'), $workingDays)) continue;
				if (in_array($period->format('Y-m-d'), $holidayDays)) continue;
				if (in_array($period->format('*-m-d'), $holidayDays)) continue;
				$days++;
			}
			return $days;
			}
			
			$year = date('Y');
			$month = date('m');
			
			$nama_bulan_min_tiga = date('M', strtotime('-2 month'));
			$nama_bulan_min_dua = date('M', strtotime('-1 month'));
			$nama_bulan_min_nol = date('M', strtotime('0 month'));
			
			$bulan_min_tiga = date('m', strtotime('-2 month'));
			$tanggal_mulai_min_tiga =  $year.'-'.$bulan_min_tiga.'-01 00:00:00';
			
			$tanggal_akhir_min_tiga =  $year.'-'.$bulan_min_tiga.'-31 23:59:59';
			
			$total_senin_min_tiga = number_of_working_days($year.'-'.$bulan_min_tiga.'-01', $year.'-'.$bulan_min_tiga.'-31',1);
			$total_selasa_min_tiga = number_of_working_days($year.'-'.$bulan_min_tiga.'-01', $year.'-'.$bulan_min_tiga.'-31',2);
			$total_rabu_min_tiga = number_of_working_days($year.'-'.$bulan_min_tiga.'-01', $year.'-'.$bulan_min_tiga.'-31',3);
			$total_kamis_min_tiga = number_of_working_days($year.'-'.$bulan_min_tiga.'-01', $year.'-'.$bulan_min_tiga.'-31',4);
			$total_jumat_min_tiga = number_of_working_days($year.'-'.$bulan_min_tiga.'-01', $year.'-'.$bulan_min_tiga.'-31',5);
			$total_sabtu_min_tiga = number_of_working_days($year.'-'.$bulan_min_tiga.'-01', $year.'-'.$bulan_min_tiga.'-31',6);
		
			$bulan_min_dua = date('m', strtotime('-1 month'));
			$tanggal_mulai_min_dua =  $year.'-'.$bulan_min_dua.'-01 00:00:00';
			$tanggal_akhir_min_dua =  $year.'-'.$bulan_min_dua.'-31 23:59:59';
		
			$total_senin_min_dua = number_of_working_days($year.'-'.$bulan_min_dua.'-01', $year.'-'.$bulan_min_dua.'-31',1);
			$total_selasa_min_dua = number_of_working_days($year.'-'.$bulan_min_dua.'-01', $year.'-'.$bulan_min_dua.'-31',2);
			$total_rabu_min_dua = number_of_working_days($year.'-'.$bulan_min_dua.'-01', $year.'-'.$bulan_min_dua.'-31',3);
			$total_kamis_min_dua = number_of_working_days($year.'-'.$bulan_min_dua.'-01', $year.'-'.$bulan_min_dua.'-31',4);
			$total_jumat_min_dua = number_of_working_days($year.'-'.$bulan_min_dua.'-01', $year.'-'.$bulan_min_dua.'-31',5);
			$total_sabtu_min_dua = number_of_working_days($year.'-'.$bulan_min_dua.'-01', $year.'-'.$bulan_min_dua.'-31',6);
			
			
			$bulan_min_nol = date('m', strtotime('0 month'));
	
			$tanggal_mulai_min_nol =  $year.'-'.$bulan_min_nol.'-01 00:00:00';
			$tanggal_akhir_min_nol =  $year.'-'.$bulan_min_nol.'-31 23:59:59';
			
			$tanggal_sekarang = date('d');
			$total_senin_min_nol  = number_of_working_days($year.'-'.$bulan_min_nol.'-01', $year.'-'.$bulan_min_nol.'-'.$tanggal_sekarang,1);
			$total_selasa_min_nol = number_of_working_days($year.'-'.$bulan_min_nol.'-01', $year.'-'.$bulan_min_nol.'-'.$tanggal_sekarang,2);
			$total_rabu_min_nol  = number_of_working_days($year.'-'.$bulan_min_nol.'-01', $year.'-'.$bulan_min_nol.'-'.$tanggal_sekarang,3);
			$total_kamis_min_nol  = number_of_working_days($year.'-'.$bulan_min_nol.'-01', $year.'-'.$bulan_min_nol.'-'.$tanggal_sekarang,4);
			$total_jumat_min_nol  = number_of_working_days($year.'-'.$bulan_min_nol.'-01', $year.'-'.$bulan_min_nol.'-'.$tanggal_sekarang,5);
			$total_sabtu_min_nol = number_of_working_days($year.'-'.$bulan_min_nol.'-01', $year.'-'.$bulan_min_nol.'-'.$tanggal_sekarang,6);
			
			
					
					
					
					
					
			
			
			
			?>
       		 <div id="container" style="min-width: 310px; height: 400px; max-width: 100%; margin: 0 auto"></div>
             
             
             <div id="container2" style="min-width: 310px; height: 400px; max-width: 100%; margin: 0 auto"></div>
                  
            
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
            type: 'column'
        },
        title: {
            text: 'Chart % Call'
        },
        xAxis: {
            categories: [
			<?php foreach($data_motorist as $data_motorist_name)
				{ ?>
                '<?php echo $data_motorist_name->motorist_code; ?>',
             <?php } ?>
            ],
            crosshair: true
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Percentage %'
            }
        },
        tooltip: {
            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
            pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                '<td style="padding:0"><b>{point.y} %</b></td></tr>',
            footerFormat: '</table>',
            shared: true,
            useHTML: true
        },
        plotOptions: {
            column: {
                pointPadding: 0.2,
                borderWidth: 0
            }
        },
        series: [{
            name: '<?php echo $nama_bulan_min_tiga; ?>',
            data: [<?php 
				
				foreach($data_motorist as $data_motorist_call)
					{
						
									
									
						
									
									
									$store_senin_min_tiga = $this->db->query("SELECT id_store FROM store WHERE distributor_code = '".$data_account[0]['code']."' AND motorist_code = '".$data_motorist_call->motorist_code."' AND day_visit = 'monday' ")->num_rows();
									//echo "store_senin".$store_senin."<br>";
									$total_store_senin_min_tiga = $total_senin_min_tiga * $store_senin_min_tiga;
									$store_selasa_min_tiga = $this->db->query("SELECT id_store FROM store WHERE distributor_code = '".$data_account[0]['code']."' AND motorist_code = '".$data_motorist_call->motorist_code."' AND day_visit = 'tuesday' ")->num_rows();
									//echo "store_selasa".$store_selasa."<br>";
									$total_store_selasa_min_tiga = $total_selasa_min_tiga * $store_selasa_min_tiga;
									$store_rabu_min_tiga = $this->db->query("SELECT id_store FROM store WHERE distributor_code = '".$data_account[0]['code']."' AND motorist_code = '".$data_motorist_call->motorist_code."' AND day_visit = 'wednesday' ")->num_rows();
									$total_store_rabu_min_tiga = $total_rabu_min_tiga * $store_rabu_min_tiga;
									//echo "store_rabu".$store_rabu."<br>";
									$store_kamis_min_tiga = $this->db->query("SELECT id_store FROM store WHERE distributor_code = '".$data_account[0]['code']."' AND motorist_code = '".$data_motorist_call->motorist_code."' AND day_visit = 'thursday' ")->num_rows();
									$total_store_kamis_min_tiga = $total_kamis_min_tiga * $store_kamis_min_tiga;
									//echo "store_kamis".$store_kamis."<br>";
									$store_jumat_min_tiga = $this->db->query("SELECT id_store FROM store WHERE distributor_code = '".$data_account[0]['code']."' AND motorist_code = '".$data_motorist_call->motorist_code."' AND day_visit = 'friday' ")->num_rows();
									$total_store_jumat_min_tiga = $total_jumat_min_tiga * $store_jumat_min_tiga;
									//echo "store_jumat".$store_jumat."<br>";
									$store_sabtu_min_tiga = $this->db->query("SELECT id_store FROM store WHERE distributor_code = '".$data_account[0]['code']."' AND motorist_code = '".$data_motorist_call->motorist_code."' AND day_visit = 'saturday' ")->num_rows();
									$total_store_sabtu_min_tiga = $total_sabtu_min_tiga * $store_sabtu_min_tiga;
									//echo "store_sabtu".$store_sabtu."<br>";
									$total_keseluruhan_min_tiga = $total_store_senin_min_tiga+$total_store_selasa_min_tiga+$total_store_rabu_min_tiga+$total_store_kamis_min_tiga+$total_store_jumat_min_tiga+$total_store_sabtu_min_tiga;
									
									$data_total_call_bulan_min_tiga = $this->db->query("SELECT COUNT(customer_code) as total_call_monthly FROM visit JOIN motorist on motorist.id_motorist = visit.id_motorist JOIN distributor on motorist.distributor_code = distributor.distributor_code WHERE visit.id_motorist = '".$data_motorist_call->id_motorist."' AND  status_visit = 'call' AND time_stamp_visit between '".$tanggal_mulai_min_tiga."' AND '".$tanggal_akhir_min_tiga."'")->result_array();		
									$total_call_bulan_min_tiga = $data_total_call_bulan_min_tiga[0]['total_call_monthly'];
						
									$persentasi_call_min_tiga = 0;
									if($total_keseluruhan_min_tiga >0)
									{
									$persentasi_call_min_tiga = ($total_call_bulan_min_tiga  * 100) / $total_keseluruhan_min_tiga;
									$persentasi_call_min_tiga = number_format($persentasi_call_min_tiga, 0, '.', '');
									}
					
						
						
					
				
				
				?>
				<?php echo $persentasi_call_min_tiga;  ?>,
				<?php } ?>
				]

        }, {
            name: '<?php echo $nama_bulan_min_dua; ?>',
            data: [<?php foreach($data_motorist as $data_motorist_call_dua)
					
				{ 
				
				$data_total_call_bulan_min_dua = $this->db->query("SELECT COUNT(customer_code) as total_call_monthly FROM visit JOIN motorist on motorist.id_motorist = visit.id_motorist JOIN distributor on motorist.distributor_code = distributor.distributor_code WHERE visit.id_motorist = '".$data_motorist_call_dua->id_motorist."'  AND  status_visit = 'call' AND time_stamp_visit between '".$tanggal_mulai_min_dua."' AND '".$tanggal_akhir_min_dua."'")->result_array();		
									$total_call_bulan_min_dua = $data_total_call_bulan_min_dua[0]['total_call_monthly'];
						
						
						
									$store_senin_min_dua = $this->db->query("SELECT id_store FROM store WHERE distributor_code = '".$data_account[0]['code']."' AND motorist_code = '".$data_motorist_call_dua->motorist_code."' AND day_visit = 'monday' ")->num_rows();
									//echo "store_senin".$store_senin."<br>";
									$total_store_senin_min_dua = $total_senin_min_dua * $store_senin_min_dua;
									$store_selasa_min_dua = $this->db->query("SELECT id_store FROM store WHERE distributor_code = '".$data_account[0]['code']."' AND motorist_code = '".$data_motorist_call_dua->motorist_code."' AND day_visit = 'tuesday' ")->num_rows();
									//echo "store_selasa".$store_selasa."<br>";
									$total_store_selasa_min_dua = $total_selasa_min_dua * $store_selasa_min_dua;
									$store_rabu_min_dua = $this->db->query("SELECT id_store FROM store WHERE distributor_code = '".$data_account[0]['code']."' AND motorist_code = '".$data_motorist_call_dua->motorist_code."' AND day_visit = 'wednesday' ")->num_rows();
									$total_store_rabu_min_dua = $total_rabu_min_dua * $store_rabu_min_dua;
									//echo "store_rabu".$store_rabu."<br>";
									$store_kamis_min_dua = $this->db->query("SELECT id_store FROM store WHERE distributor_code = '".$data_account[0]['code']."' AND motorist_code = '".$data_motorist_call_dua->motorist_code."' AND day_visit = 'thursday' ")->num_rows();
									$total_store_kamis_min_dua = $total_kamis_min_dua * $store_kamis_min_dua;
									//echo "store_kamis".$store_kamis."<br>";
									$store_jumat_min_dua = $this->db->query("SELECT id_store FROM store WHERE distributor_code = '".$data_account[0]['code']."' AND motorist_code = '".$data_motorist_call_dua->motorist_code."' AND day_visit = 'friday' ")->num_rows();
									$total_store_jumat_min_dua = $total_jumat_min_dua * $store_jumat_min_dua;
									//echo "store_jumat".$store_jumat."<br>";
									$store_sabtu_min_dua = $this->db->query("SELECT id_store FROM store WHERE distributor_code = '".$data_account[0]['code']."' AND motorist_code = '".$data_motorist_call_dua->motorist_code."' AND day_visit = 'saturday' ")->num_rows();
									$total_store_sabtu_min_dua = $total_sabtu_min_dua * $store_sabtu_min_dua;
									//echo "store_sabtu".$store_sabtu."<br>";
									$total_keseluruhan_min_dua = $total_store_senin_min_dua+$total_store_selasa_min_dua+$total_store_rabu_min_dua+$total_store_kamis_min_dua+$total_store_jumat_min_dua+$total_store_sabtu_min_dua;
									
									$persentasi_call_min_dua = 0;
									if($total_keseluruhan_min_dua >0)
									{
									$persentasi_call_min_dua = ($total_call_bulan_min_dua  * 100) / $total_keseluruhan_min_dua;
									$persentasi_call_min_dua = number_format($persentasi_call_min_dua, 0, '.', '');
									}
									
									?>
				<?php echo $persentasi_call_min_dua;  ?>,
				<?php } ?>]

        }, {
            name: '<?php echo $nama_bulan_min_nol; ?>',
            data: [<?php foreach($data_motorist as $data_motorist_call_tiga)
				{ 
				
								$data_total_call_bulan_min_nol = $this->db->query("SELECT COUNT(customer_code) as total_call_monthly FROM visit JOIN motorist on motorist.id_motorist = visit.id_motorist JOIN distributor on motorist.distributor_code = distributor.distributor_code WHERE visit.id_motorist = '".$data_motorist_call_tiga->id_motorist."'  AND  status_visit = 'call' AND time_stamp_visit between '".$tanggal_mulai_min_nol."' AND '".$tanggal_akhir_min_nol."' ")->result_array();		
									$total_call_bulan_min_nol = $data_total_call_bulan_min_nol[0]['total_call_monthly'];
						
									$store_senin_min_nol = $this->db->query("SELECT id_store FROM store WHERE distributor_code = '".$data_account[0]['code']."' AND motorist_code = '".$data_motorist_call_tiga->motorist_code."' AND day_visit = 'monday' ")->num_rows();
									//echo "store_senin".$store_senin."<br>";
									$total_store_senin_min_nol = $total_senin_min_nol * $store_senin_min_nol;
									$store_selasa_min_nol = $this->db->query("SELECT id_store FROM store WHERE distributor_code = '".$data_account[0]['code']."' AND motorist_code = '".$data_motorist_call_tiga->motorist_code."' AND day_visit = 'tuesday' ")->num_rows();
									//echo "store_selasa".$store_selasa."<br>";
									$total_store_selasa_min_nol = $total_selasa_min_nol * $store_selasa_min_nol;
									$store_rabu_min_nol = $this->db->query("SELECT id_store FROM store WHERE distributor_code = '".$data_account[0]['code']."' AND motorist_code = '".$data_motorist_call_tiga->motorist_code."' AND day_visit = 'wednesday' ")->num_rows();
									$total_store_rabu_min_nol = $total_rabu_min_nol * $store_rabu_min_nol;
									//echo "store_rabu".$store_rabu."<br>";
									$store_kamis_min_nol = $this->db->query("SELECT id_store FROM store WHERE distributor_code = '".$data_account[0]['code']."' AND motorist_code = '".$data_motorist_call_tiga->motorist_code."' AND day_visit = 'thursday' ")->num_rows();
									$total_store_kamis_min_nol = $total_kamis_min_nol * $store_kamis_min_nol;
									//echo "store_kamis".$store_kamis."<br>";
									$store_jumat_min_nol = $this->db->query("SELECT id_store FROM store WHERE distributor_code = '".$data_account[0]['code']."' AND motorist_code = '".$data_motorist_call_tiga->motorist_code."' AND day_visit = 'friday' ")->num_rows();
									$total_store_jumat_min_nol = $total_jumat_min_nol * $store_jumat_min_nol;
									//echo "store_jumat".$store_jumat."<br>";
									$store_sabtu_min_nol = $this->db->query("SELECT id_store FROM store WHERE distributor_code = '".$data_account[0]['code']."' AND motorist_code = '".$data_motorist_call_tiga->motorist_code."' AND day_visit = 'saturday' ")->num_rows();
									$total_store_sabtu_min_nol = $total_sabtu_min_nol * $store_sabtu_min_nol;
									//echo "store_sabtu".$store_sabtu."<br>";
									$total_keseluruhan_min_nol = $total_store_senin_min_nol+$total_store_selasa_min_nol+$total_store_rabu_min_nol+$total_store_kamis_min_nol+$total_store_jumat_min_nol+$total_store_sabtu_min_nol;
									
									$persentasi_call_min_nol = 0;
									if($total_keseluruhan_min_nol >0)
									{
									$persentasi_call_min_nol = ($total_call_bulan_min_nol  * 100) / $total_keseluruhan_min_nol;
									$persentasi_call_min_nol = number_format($persentasi_call_min_nol, 0, '.', '');
									}
				?>
				<?php echo $persentasi_call_min_nol; ?>,
				<?php } ?>]

        }]
    });
	
</script>



<script>
$('#container2').highcharts({
        chart: {
            type: 'column'
        },
        title: {
            text: 'Chart % Effective Call'
        },
        xAxis: {
            categories: [
			<?php foreach($data_motorist as $data_motorist_name)
				{ ?>
                '<?php echo $data_motorist_name->motorist_code; ?>',
             <?php } ?>
            ],
            crosshair: true
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Percentage %'
            }
        },
        tooltip: {
            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
            pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                '<td style="padding:0"><b>{point.y} %</b></td></tr>',
            footerFormat: '</table>',
            shared: true,
            useHTML: true
        },
        plotOptions: {
            column: {
                pointPadding: 0.2,
                borderWidth: 0
            }
        },
        series: [{
            name: '<?php echo $nama_bulan_min_tiga; ?>',
            data: [<?php 
				
				foreach($data_motorist as $data_motorist_call)
					{
						
									
									
						
									
									
									$store_senin_min_tiga = $this->db->query("SELECT id_store FROM store WHERE distributor_code = '".$data_account[0]['code']."' AND motorist_code = '".$data_motorist_call->motorist_code."' AND day_visit = 'monday' ")->num_rows();
									//echo "store_senin".$store_senin."<br>";
									$total_store_senin_min_tiga = $total_senin_min_tiga * $store_senin_min_tiga;
									$store_selasa_min_tiga = $this->db->query("SELECT id_store FROM store WHERE distributor_code = '".$data_account[0]['code']."' AND motorist_code = '".$data_motorist_call->motorist_code."' AND day_visit = 'tuesday' ")->num_rows();
									//echo "store_selasa".$store_selasa."<br>";
									$total_store_selasa_min_tiga = $total_selasa_min_tiga * $store_selasa_min_tiga;
									$store_rabu_min_tiga = $this->db->query("SELECT id_store FROM store WHERE distributor_code = '".$data_account[0]['code']."' AND motorist_code = '".$data_motorist_call->motorist_code."' AND day_visit = 'wednesday' ")->num_rows();
									$total_store_rabu_min_tiga = $total_rabu_min_tiga * $store_rabu_min_tiga;
									//echo "store_rabu".$store_rabu."<br>";
									$store_kamis_min_tiga = $this->db->query("SELECT id_store FROM store WHERE distributor_code = '".$data_account[0]['code']."' AND motorist_code = '".$data_motorist_call->motorist_code."' AND day_visit = 'thursday' ")->num_rows();
									$total_store_kamis_min_tiga = $total_kamis_min_tiga * $store_kamis_min_tiga;
									//echo "store_kamis".$store_kamis."<br>";
									$store_jumat_min_tiga = $this->db->query("SELECT id_store FROM store WHERE distributor_code = '".$data_account[0]['code']."' AND motorist_code = '".$data_motorist_call->motorist_code."' AND day_visit = 'friday' ")->num_rows();
									$total_store_jumat_min_tiga = $total_jumat_min_tiga * $store_jumat_min_tiga;
									//echo "store_jumat".$store_jumat."<br>";
									$store_sabtu_min_tiga = $this->db->query("SELECT id_store FROM store WHERE distributor_code = '".$data_account[0]['code']."' AND motorist_code = '".$data_motorist_call->motorist_code."' AND day_visit = 'saturday' ")->num_rows();
									$total_store_sabtu_min_tiga = $total_sabtu_min_tiga * $store_sabtu_min_tiga;
									//echo "store_sabtu".$store_sabtu."<br>";
									$total_keseluruhan_min_tiga = $total_store_senin_min_tiga+$total_store_selasa_min_tiga+$total_store_rabu_min_tiga+$total_store_kamis_min_tiga+$total_store_jumat_min_tiga+$total_store_sabtu_min_tiga;
									
									$data_total_call_bulan_min_tiga = $this->db->query("SELECT COUNT(customer_code) as total_call_monthly FROM visit JOIN motorist on motorist.id_motorist = visit.id_motorist JOIN distributor on motorist.distributor_code = distributor.distributor_code WHERE visit.id_motorist = '".$data_motorist_call->id_motorist."' AND  status_visit = 'call' AND status_order = 'order' AND time_stamp_visit between '".$tanggal_mulai_min_tiga."' AND '".$tanggal_akhir_min_tiga."'")->result_array();		
									$total_call_bulan_min_tiga = $data_total_call_bulan_min_tiga[0]['total_call_monthly'];
						
									$persentasi_call_min_tiga = 0;
									if($total_keseluruhan_min_tiga >0)
									{
									$persentasi_call_min_tiga = ($total_call_bulan_min_tiga  * 100) / $total_keseluruhan_min_tiga;
									$persentasi_call_min_tiga = number_format($persentasi_call_min_tiga, 0, '.', '');
									}
					
						
						
					
				
				
				?>
				<?php echo $persentasi_call_min_tiga;  ?>,
				<?php } ?>
				]

        }, {
            name: '<?php echo $nama_bulan_min_dua; ?>',
            data: [<?php foreach($data_motorist as $data_motorist_call_dua)
					
				{ 
				
				$data_total_call_bulan_min_dua = $this->db->query("SELECT COUNT(customer_code) as total_call_monthly FROM visit JOIN motorist on motorist.id_motorist = visit.id_motorist JOIN distributor on motorist.distributor_code = distributor.distributor_code WHERE visit.id_motorist = '".$data_motorist_call_dua->id_motorist."'  AND  status_visit = 'call' AND status_order = 'order' AND time_stamp_visit between '".$tanggal_mulai_min_dua."' AND '".$tanggal_akhir_min_dua."'")->result_array();		
									$total_call_bulan_min_dua = $data_total_call_bulan_min_dua[0]['total_call_monthly'];
						
						
						
									$store_senin_min_dua = $this->db->query("SELECT id_store FROM store WHERE distributor_code = '".$data_account[0]['code']."' AND motorist_code = '".$data_motorist_call_dua->motorist_code."' AND day_visit = 'monday' ")->num_rows();
									//echo "store_senin".$store_senin."<br>";
									$total_store_senin_min_dua = $total_senin_min_dua * $store_senin_min_dua;
									$store_selasa_min_dua = $this->db->query("SELECT id_store FROM store WHERE distributor_code = '".$data_account[0]['code']."' AND motorist_code = '".$data_motorist_call_dua->motorist_code."' AND day_visit = 'tuesday' ")->num_rows();
									//echo "store_selasa".$store_selasa."<br>";
									$total_store_selasa_min_dua = $total_selasa_min_dua * $store_selasa_min_dua;
									$store_rabu_min_dua = $this->db->query("SELECT id_store FROM store WHERE distributor_code = '".$data_account[0]['code']."' AND motorist_code = '".$data_motorist_call_dua->motorist_code."' AND day_visit = 'wednesday' ")->num_rows();
									$total_store_rabu_min_dua = $total_rabu_min_dua * $store_rabu_min_dua;
									//echo "store_rabu".$store_rabu."<br>";
									$store_kamis_min_dua = $this->db->query("SELECT id_store FROM store WHERE distributor_code = '".$data_account[0]['code']."' AND motorist_code = '".$data_motorist_call_dua->motorist_code."' AND day_visit = 'thursday' ")->num_rows();
									$total_store_kamis_min_dua = $total_kamis_min_dua * $store_kamis_min_dua;
									//echo "store_kamis".$store_kamis."<br>";
									$store_jumat_min_dua = $this->db->query("SELECT id_store FROM store WHERE distributor_code = '".$data_account[0]['code']."' AND motorist_code = '".$data_motorist_call_dua->motorist_code."' AND day_visit = 'friday' ")->num_rows();
									$total_store_jumat_min_dua = $total_jumat_min_dua * $store_jumat_min_dua;
									//echo "store_jumat".$store_jumat."<br>";
									$store_sabtu_min_dua = $this->db->query("SELECT id_store FROM store WHERE distributor_code = '".$data_account[0]['code']."' AND motorist_code = '".$data_motorist_call_dua->motorist_code."' AND day_visit = 'saturday' ")->num_rows();
									$total_store_sabtu_min_dua = $total_sabtu_min_dua * $store_sabtu_min_dua;
									//echo "store_sabtu".$store_sabtu."<br>";
									$total_keseluruhan_min_dua = $total_store_senin_min_dua+$total_store_selasa_min_dua+$total_store_rabu_min_dua+$total_store_kamis_min_dua+$total_store_jumat_min_dua+$total_store_sabtu_min_dua;
									
									$persentasi_call_min_dua = 0;
									if($total_keseluruhan_min_dua >0)
									{
									$persentasi_call_min_dua = ($total_call_bulan_min_dua  * 100) / $total_keseluruhan_min_dua;
									$persentasi_call_min_dua = number_format($persentasi_call_min_dua, 0, '.', '');
									}
									
									?>
				<?php echo $persentasi_call_min_dua;  ?>,
				<?php } ?>]

        }, {
            name: '<?php echo $nama_bulan_min_nol; ?>',
            data: [<?php foreach($data_motorist as $data_motorist_call_tiga)
				{ 
				
								$data_total_call_bulan_min_nol = $this->db->query("SELECT COUNT(customer_code) as total_call_monthly FROM visit JOIN motorist on motorist.id_motorist = visit.id_motorist JOIN distributor on motorist.distributor_code = distributor.distributor_code WHERE visit.id_motorist = '".$data_motorist_call_tiga->id_motorist."'  AND   status_visit = 'call' AND status_order = 'order' AND time_stamp_visit between '".$tanggal_mulai_min_nol."' AND '".$tanggal_akhir_min_nol."' ")->result_array();		
									$total_call_bulan_min_nol = $data_total_call_bulan_min_nol[0]['total_call_monthly'];
						
									$store_senin_min_nol = $this->db->query("SELECT id_store FROM store WHERE distributor_code = '".$data_account[0]['code']."' AND motorist_code = '".$data_motorist_call_tiga->motorist_code."' AND day_visit = 'monday' ")->num_rows();
									//echo "store_senin".$store_senin."<br>";
									$total_store_senin_min_nol = $total_senin_min_nol * $store_senin_min_nol;
									$store_selasa_min_nol = $this->db->query("SELECT id_store FROM store WHERE distributor_code = '".$data_account[0]['code']."' AND motorist_code = '".$data_motorist_call_tiga->motorist_code."' AND day_visit = 'tuesday' ")->num_rows();
									//echo "store_selasa".$store_selasa."<br>";
									$total_store_selasa_min_nol = $total_selasa_min_nol * $store_selasa_min_nol;
									$store_rabu_min_nol = $this->db->query("SELECT id_store FROM store WHERE distributor_code = '".$data_account[0]['code']."' AND motorist_code = '".$data_motorist_call_tiga->motorist_code."' AND day_visit = 'wednesday' ")->num_rows();
									$total_store_rabu_min_nol = $total_rabu_min_nol * $store_rabu_min_nol;
									//echo "store_rabu".$store_rabu."<br>";
									$store_kamis_min_nol = $this->db->query("SELECT id_store FROM store WHERE distributor_code = '".$data_account[0]['code']."' AND motorist_code = '".$data_motorist_call_tiga->motorist_code."' AND day_visit = 'thursday' ")->num_rows();
									$total_store_kamis_min_nol = $total_kamis_min_nol * $store_kamis_min_nol;
									//echo "store_kamis".$store_kamis."<br>";
									$store_jumat_min_nol = $this->db->query("SELECT id_store FROM store WHERE distributor_code = '".$data_account[0]['code']."' AND motorist_code = '".$data_motorist_call_tiga->motorist_code."' AND day_visit = 'friday' ")->num_rows();
									$total_store_jumat_min_nol = $total_jumat_min_nol * $store_jumat_min_nol;
									//echo "store_jumat".$store_jumat."<br>";
									$store_sabtu_min_nol = $this->db->query("SELECT id_store FROM store WHERE distributor_code = '".$data_account[0]['code']."' AND motorist_code = '".$data_motorist_call_tiga->motorist_code."' AND day_visit = 'saturday' ")->num_rows();
									$total_store_sabtu_min_nol = $total_sabtu_min_nol * $store_sabtu_min_nol;
									//echo "store_sabtu".$store_sabtu."<br>";
									$total_keseluruhan_min_nol = $total_store_senin_min_nol+$total_store_selasa_min_nol+$total_store_rabu_min_nol+$total_store_kamis_min_nol+$total_store_jumat_min_nol+$total_store_sabtu_min_nol;
									
									$persentasi_call_min_nol = 0;
									if($total_keseluruhan_min_nol >0)
									{
									$persentasi_call_min_nol = ($total_call_bulan_min_nol  * 100) / $total_keseluruhan_min_nol;
									$persentasi_call_min_nol = number_format($persentasi_call_min_nol, 0, '.', '');
									}
				?>
				<?php echo $persentasi_call_min_nol; ?>,
				<?php } ?>]

        }]
    });
	
</script>

