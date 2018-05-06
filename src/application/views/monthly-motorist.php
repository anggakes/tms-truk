 <!-- HEADER -->
 <section class="content-header">
          <h1>
            Monthly Motorist
            <small>Motorist of E-tools</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="<?php echo BASE_URL(); ?>"><i class="fa fa-dashboard"></i>Home</a></li>
            <li><a href="<?php echo BASE_URL()."monthlySummaryMotorist"; ?>"><i class="fa fa-dashboard"></i>Monthly Motorist</a></li>
          </ol>
        </section>
  
  
   <!-- Content -->
   <section class="content">
          <div class="box sms box-default color-palette-box">
            <div class="box-header with-border">
              <h3 class="box-title"><i class="fa fa-table"></i> Table Monthly Summary Motorist</h3>
            </div>
            <div class="box-body">
            <?php $message_success = $this->session->flashdata('message_success');
					 	if($message_success!="")
						{
					  ?>
                     <div class="alert alert-success"><?php echo $message_success; ?></div>
                     <?php } ?>
                     <?php $message_failed = $this->session->flashdata('message_failed');
					 	if($message_failed!="")
						{
					  ?>
                     <div class="alert alert-danger"><?php echo $message_failed; ?></div>
                     <?php } ?>
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
		
			$distributor = isset($_GET['distributor']) ? $_GET['distributor'] : '';
			if(isset($_GET['distributor']))
			{$distributor_implode = implode(",",$distributor);}
			else
			{$distributor_implode = "";}
			
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
			
			
			$tanggal_bulan_awal = $tahun.'-'.$bulan."-01 00:00:00";
			$tanggal_bulan_akhir = $tahun.'-'.$bulan."-31 23:59:59";
			
			$tanggal_bulan_awal_link = $bulan.'/01/2016 - '.$bulan.'/31/2016';
			
			 
			?>
            
            
            
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
			
			
			if($search!=='')
						{
						$search_query = "AND motorist.motorist_code LIKE '%".$search."%' ";
						$search_query_store = "AND store.motorist_code LIKE '%".$search."%' ";
						}
						else
						{
						$search_query = "";
						$search_query_store = '';
						}
			
			$total_senin = number_of_working_days('2016-'.$bulan.'-01', '2016-'.$bulan.'-'.$date_now,1);
			//echo "total senin".$total_senin."<br>";
			$total_selasa = number_of_working_days('2016-'.$bulan.'-01', '2016-'.$bulan.'-'.$date_now,2);
			//echo "total selasa".$total_selasa."<br>";
			$total_rabu = number_of_working_days('2016-'.$bulan.'-01', '2016-'.$bulan.'-'.$date_now,3);
			//echo "total rabu".$total_rabu."<br>";
			$total_kamis = number_of_working_days('2016-'.$bulan.'-01', '2016-'.$bulan.'-'.$date_now,4);
			//echo "total kamis".$total_kamis."<br>";
			$total_jumat = number_of_working_days('2016-'.$bulan.'-01', '2016-'.$bulan.'-'.$date_now,5);
			//echo "total jumat".$total_jumat."<br>";
			$total_sabtu = number_of_working_days('2016-'.$bulan.'-01', '2016-'.$bulan.'-'.$date_now,6);
			//echo "total sabtu".$total_sabtu."<br>";
			
			?>
            <div id="wrapper-console" class="clearfix">
                <div id="wrapper-search">
                             <form action="<?php echo base_url()."index.php/motorist/monthlySummaryMotorist" ?>" method="get">
                             <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                                <?php if($data_account[0]['user_type']=="Administrator"){ ?>
                                <div class="select-filter">
                             	<select name="regional[]" id="select-regional" multiple="multiple" >
                              	<?php foreach($data_regional as $data_regional) {?>
                              	<option <?php if(isset($_GET['regional'])) {if(in_array($data_regional['regional_name'], $regional)) {?> selected="selected" <?php }} ?> value="<?php echo $data_regional['regional_name']; ?>"><?php echo $data_regional['regional_name']; ?></option>
                              	<?php } ?>
                             	</select>
                             	</div>
                                
							
                                
                                
                                <?php }?>
								
								
									<?php if($data_account[0]['user_type']=="Administrator" or $data_account[0]['user_type']=="Regional"){ ?>
                              <div class="select-filter">
                             	<select name="area[]" id="select-area" multiple="multiple" >
                              	<?php foreach($data_area as $data_area) {?>
                              	<option <?php if(isset($_GET['area'])) {if(in_array($data_area['area'], $area)) {?> selected="selected" <?php }} ?> value="<?php echo $data_area['area']; ?>"><?php echo $data_area['area']; ?></option>
                              	<?php } ?>
                             	</select>
                             	</div>
                                <?php } ?>
								
								 <div class="select-filter">
                             	<select name="motorist_type[]" id="select-motorist-type" multiple="multiple" >
                              	<?php foreach($data_motorist_type as $data_motorist_type) {?>
                              	<option <?php if(isset($_GET['motorist_type'])) {if(in_array($data_motorist_type['id_motorist_type'], $motorist_type)) {?> selected="selected" <?php }} ?> value="<?php echo $data_motorist_type['id_motorist_type']; ?>"><?php echo $data_motorist_type['motorist_type']; ?></option>
                              	<?php } ?>
                             	</select>
                             	</div>
                              
								
								
							<?php  if($data_account[0]['user_type']=="Administrator" or $data_account[0]['user_type']=="Regional"){ ?>
                             <div class="select-filter">
                             <select name="distributor[]" id="select-distributor" multiple="multiple" >
                              <?php foreach($data_distributor as $data_distributor) {?>
                              <option <?php if(isset($_GET['distributor'])) {if(in_array($data_distributor['distributor_code'], $distributor)) {?> selected="selected" <?php }} ?> value="<?php echo $data_distributor['distributor_code']; ?>" ><?php echo $data_distributor['distributor_name']; ?></option>
                              <?php } ?>
                             </select>
                             </div>
                             <?php } ?>
                                
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
                                
                                  <select name="tahun" id="tahun" style="float:left; width:300px;">
                                	<option value="">Choose year</option>
                                    <option <?php if($tahun==2016){ ?> selected="selected" <?php } ?> value="2016">2016</option>
                                    <option <?php if($tahun==2017){ ?> selected="selected" <?php } ?> value="2017">2017</option>
                                    <option <?php if($tahun==2018){ ?> selected="selected" <?php } ?> value="2018">2018</option>
                                </select>
                                
                                <input type="text" id="search" name="search" placeholder="Search Motorist Code"  value="<?php echo $search; ?>" />
                                <input type="submit" id="submit"  value="Search"/>
                                <?php if($search!="" or $tahun!="" or $motorist_type_implode!="" or $tahun!="")
								{?>
                                <a href="<?php echo base_url()."index.php/motorist/monthlySummaryMotorist" ?>" id="clear-search">Clear Search</a>
                                <?php } ?>
                             </form>
                </div>
                
                </div>
            <div id="wrapper-button" class="clearfix">
                	<a href="<?php echo base_url()."index.php/motorist/exportMonthlySummaryMotorist?search=".$search."&&bulan=".$bulan."&&tahun=".$tahun."&&regional=".$regional_implode."&&distributor=".$distributor_implode."&&area=".$area_implode."&&motorist_type=".$motorist_type_implode; ?>" class="button orange-button">
                    	Export Table Daily Motorist
                    </a>
                </div>
            <?php if(($bulan!="") or ($tahun!="")){ ?>    
            <h3 class="keterangan">Data <?php echo 'Month '.$bulan ?> <?php if($tahun!==""){echo 'Year '.$tahun;} ?></h3>
            <?php } ?>
            
            <?php if(($regional_implode!="")){ ?>    
            <h3 class="keterangan">Data Regional <?php echo $regional_implode; ?></h3>
            <?php } ?>
            
            
              
                
            <div id="wrapper-console" class="clearfix">
             
             <div class="grid_4 height400">             
           	<table id="myTable05" class="fancyTable table-bordered table-hover">
                    <thead>
                      <tr>
                        <th><div class="mid">Nama Motorist</div></th>
					    <th><div class="mid">Regional</div></th>
						<th><div class="mid">Area</div></th>
						<th><div class="long">Distributor Code</div></th>
                        <th><div class="long">Distributo Name</div></th>
                        <th><div class="mid">Kode Motorist</div></th>
                         <th><div class="mid">Tipe Motorist</div></th>
                        <th><div class="mid">A<br />
						Target Call</div></th>
                        <th><div class="mid">B<br />
						Call</div></th>
						<th><div class="mid">B/A<br />
						%Call</div></th>
                        <th><div class="mid">C<br />
						Ekstra Call</div></th>
						<th><div class="mid">C/B<br />
						%Ekstra Call</div></th>
                        <th><div class="mid">D<br />
						Efektif Call</div></th>
						<th><div class="mid">D/A<br />
						%Efektiv Call</div></th>
                        <th><div class="mid">E<br />
						Target Penjualan Bulanan</div></th>                        
						<th><div class="mid">F<br />
						Penjualanan Bulanan</div></th>
                        <th><div class="mid">E/F<br />
						%Pencapaian Penjualan</div></th>
						<th><div class="mid">G<br />
						Total Setoran Bulanan</div></th>
						<th><div class="mid">G-F<br />
						Selisih Setoran Bulanan</div></th>
                        <th><div class="mid">H<br />
						Master Outltet</div></th>
                        <th><div class="mid">I<br />
						Outlet Aktif</div></th>
						<th><div class="mid">I/H<br />
						% Outlet Aktif</div></th>
                        <th>Additional Store</th>
                   		<th>Additional Noo</th>
                      </tr>
                    </thead>
             		<tbody>
                    
                    <?php foreach($data_motorist as $data_motorist) {
						$persentasi_call = 0;
						$total_keseluruhan = 0;
						$persentasi_extra_call = 0;
						$persentasi_effective_call = 0;
						$persentasi_extra_effective_call = 0;
						$persentasi_target_bulanan = 0;
						$persentasi_outlet_active=0;
						if($data_motorist->total_call>0)
						{
							
							
							if($data_motorist->total_extra_call>0)
							{
							$persentasi_extra_call = (($data_motorist->total_call+$data_motorist->total_extra_call) * 100) / $data_motorist->target_call;
							$persentasi_extra_call = number_format($persentasi_extra_call, 0, '.', '');	
							}
							if($data_motorist->total_effective_call>0)
							{
							$persentasi_effective_call = ($data_motorist->total_effective_call * 100) / $data_motorist->total_call;
							$persentasi_effective_call = number_format($persentasi_effective_call, 0, '.', '');
							}
							if($data_motorist->total_monthly_sales>0)
							{
							$persentasi_target_bulanan = ($data_motorist->total_monthly_sales * 100) / $data_motorist->target_bulanan;
							$persentasi_target_bulanan = number_format($persentasi_target_bulanan, 0, '.', '');
							}
							if($data_motorist->total_extra_call>0)
							{
								$persentasi_extra_effective_call = ($data_motorist->total_extra_effective_call * 100) / $data_motorist->total_extra_call;
								$persentasi_extra_effective_call = number_format($persentasi_extra_effective_call, 0, '.', '');
							}
						}
					?>
                    
                    
                    <tr>
	                    <td><div style="width:200px;"><?php echo $data_motorist->motorist_name; ?>-<?php echo $data_motorist->motorist_code; ?></div></td>
						<td><?php echo $data_motorist->regional; ?></td>
						<td><?php echo $data_motorist->area; ?></td>
						<td><?php echo $data_motorist->distributor_code ?></td>
                    	<td><?php echo $data_motorist->distributor_name; ?></td>
                        <td><?php echo $data_motorist->motorist_code; ?></td>
                        <td><?php echo $data_motorist->motorist_type; ?></td>
                        <td>
                        <?php 
							$total_store_keseluruhan = 0;
							
							$store_senin = $this->db->query("SELECT id_store FROM store WHERE motorist_code = '".$data_motorist->motorist_code."' AND distributor_code= '".$data_motorist->distributor_code."'  AND day_visit = 'monday' ")->num_rows();
							//echo "store_senin".$store_senin."<br>";
							$total_store_senin = $total_senin * $store_senin;
							$store_selasa = $this->db->query("SELECT id_store FROM store WHERE motorist_code = '".$data_motorist->motorist_code."' AND distributor_code= '".$data_motorist->distributor_code."' AND day_visit = 'tuesday' ")->num_rows();
							//echo "store_selasa".$store_selasa."<br>";
							$total_store_selasa = $total_selasa * $store_selasa;
							$store_rabu = $this->db->query("SELECT id_store FROM store WHERE motorist_code = '".$data_motorist->motorist_code."' AND distributor_code= '".$data_motorist->distributor_code."' AND day_visit = 'wednesday' ")->num_rows();
							$total_store_rabu = $total_rabu * $store_rabu;
							//echo "store_rabu".$store_rabu."<br>";
							$store_kamis = $this->db->query("SELECT id_store FROM store WHERE motorist_code = '".$data_motorist->motorist_code."' AND distributor_code= '".$data_motorist->distributor_code."' AND day_visit = 'thursday' ")->num_rows();
							$total_store_kamis = $total_kamis * $store_kamis;
							//echo "store_kamis".$store_kamis."<br>";
							$store_jumat = $this->db->query("SELECT id_store FROM store WHERE motorist_code = '".$data_motorist->motorist_code."' AND distributor_code= '".$data_motorist->distributor_code."' AND day_visit = 'friday' ")->num_rows();
							$total_store_jumat = $total_jumat * $store_jumat;
							//echo "store_jumat".$store_jumat."<br>";
							$store_sabtu = $this->db->query("SELECT id_store FROM store WHERE motorist_code = '".$data_motorist->motorist_code."' AND distributor_code= '".$data_motorist->distributor_code."' AND day_visit = 'saturday' ")->num_rows();
							$total_store_sabtu = $total_sabtu * $store_sabtu;
							//echo "store_sabtu".$store_sabtu."<br>";
							$total_keseluruhan = $total_store_senin+$total_store_selasa+$total_store_rabu+$total_store_kamis+$total_store_jumat+$total_store_sabtu;
							echo $total_keseluruhan;
								
						?>
                        
                        </th>
                        <td>
						<?php 
						
						echo $data_motorist->total_call; ?></td>
						
                        <?php 
						if($total_keseluruhan>0)
							{
							$persentasi_call = ($data_motorist->total_call * 100) / $total_keseluruhan;
							$persentasi_call = number_format($persentasi_call, 0, '.', '');	
						} ?>
                        <td <?php if($persentasi_call<90){ ?> class="red" <?php } else if($persentasi_call>90){ ?> class="green_td" <?php } ?>><?php echo $persentasi_call ?> %</td>
                        <td><?php 
						echo $data_motorist->total_extra_call; ?></td>
						<td><?php 
						if($total_keseluruhan>0)
							{
							$persentasi_extra_call = ($data_motorist->total_extra_call * 100) / $total_keseluruhan;
							$persentasi_extra_call = number_format($persentasi_extra_call, 0, '.', '');	
						}
						
						echo $persentasi_extra_call; ?></td>
                        <td><?php echo $data_motorist->total_effective_call; ?></td>
						<?php 
						if($total_keseluruhan>0)
							{
							$persentasi_effective_call = ($data_motorist->total_effective_call * 100) / $total_keseluruhan;
							$persentasi_effective_call = number_format($persentasi_effective_call, 0, '.', '');	
						}
						 ?>
                        <td <?php if($persentasi_effective_call<85){ ?> class="red" <?php } else if($persentasi_effective_call>85){ ?> class="green_td" <?php } ?>><?php echo $persentasi_effective_call; ?>%</td>
						
                        <td><?php echo convert_price($data_motorist->target_bulanan); ?></td>
                        <td><a target="_blank" href="<?php echo base_url()."index.php/motorist/monthlyStockMotoristTotal?id_motorist=".$data_motorist->id_motorist."&bulan=".$bulan."&year=".$tahun; ?>"><?php echo convert_price($data_motorist->total_monthly_sales);?></a></td>
                        <td <?php if($persentasi_target_bulanan<100){ ?> class="red" <?php } else if($persentasi_target_bulanan>100){ ?> class="green_td" <?php } ?>><?php echo $persentasi_target_bulanan?>%</td>
						<td><?php 
						
						$data = $this->db->query("SELECT sum(setoran) as total_setoran from absence WHERE motorist_code = '".$data_motorist->motorist_code."' AND distributor_code = '".$data_motorist->distributor_code."' AND date_absence between '".$tahun."-".$bulan."-01 00:00:00' AND '".$tahun."-".$bulan."-31 23:59:59' ");
						$check_setoran = $data->num_rows();
						if($check_setoran>=1)
						{
						$data_setoran = $data->result_array();
						print convert_price($data_setoran[0]['total_setoran']);
						}
						else
						{
						echo convert_price(0);
						}
						
						$selisih_setoran = $data_setoran[0]['total_setoran']-$data_motorist->total_monthly_sales;
						
						
						?>
						<td <?php if($selisih_setoran<0 ){?> class="red" <?php } else if($selisih_setoran>0) { ?> class="orange" <?php } ?>> <?php echo convert_price($selisih_setoran); ?></td>
						
						
                        <td><?php echo $data_motorist->total_outlet;?></td>
                        <td>
                        <?php 
							$data_outlet = $this->db->query("SELECT id_order FROM orders WHERE id_motorist = '".$data_motorist->id_motorist."' AND date between '2016-".$bulan."-01 00:00:00' AND '2016-".$bulan."-31 23:59:59' group by customer_code")->num_rows();
							print $data_outlet;		
						?>
                        </td>
						<td>
						<?php
						if($data_motorist->total_outlet>0)
						{
						$persentasi_outlet_active = ($data_outlet*100)/ $data_motorist->total_outlet;
						$persentasi_outlet_active = number_format($persentasi_outlet_active, 0, '.', '');
						}						
						echo $persentasi_outlet_active;
						?>
						%
						</td>
                        <td><a target="_blank" href="<?php echo BASE_URL()."index.php/store?xcdsdh=041082892193a4e7f08b5b099521c732&date=".$tanggal_bulan_awal_link."&motorist_code=".$data_motorist->motorist_code."&distributor_code=".$data_motorist->distributor_code; ?>" ><?php echo $data_motorist->total_store; ?></a></td>
                   		<td><a target="_blank" href="<?php echo BASE_URL()."index.php/noo?xcdsdh=041082892193a4e7f08b5b099521c732&date=".$tanggal_bulan_awal_link."&search=".$data_motorist->motorist_code."&distributor_code=".$data_motorist->distributor_code; ?>"><?php echo $data_motorist->total_noo; ?></a></td>
                    </tr>
                    <?php }?>
                    </tbody>     
                    <?php 
							
							
							if($regional_implode!="")
							{ 
							$regional_query = 'AND distributor.regional in ('.$regional_implode.') ';
							$regional_store_query = 'AND store.regional in ('.$regional_implode.') ';
							}
							else
							{$regional_query =''; $regional_store_query ='';}
						
							if($distributor_implode!="")
							{ 
							$distributor_query = 'AND distributor.distributor_code in ('.$distributor_implode.') ';
							$distributor_store_query = 'AND store.distributor_code in ('.$distributor_implode.') ';
							}
							else
							{$distributor_query =''; $distributor_store_query ='';}
						
							if($area_implode!="")
							{ 
							$area_query = 'AND distributor.area in ('.$area_implode.') ';
							$area_store_query = 'AND store.area in ('.$area_implode.') ';
							}
							else
							{$area_query =''; $area_store_query ='';}
							
							if($motorist_type_implode!="")
							{ 
							$motorist_type_query = 'AND motorist.motorist_type in ('.$motorist_type_implode.') ';
							$motorist_type_store_query = 'AND store.motorist_type in ('.$motorist_type_implode.') ';
							}
							else
							{$motorist_type_query =''; $motorist_type_store_query='';}
							
							if($data_account[0]['user_type']=='Administrator')
							{
						
							$total_regional_footer = $this->db->query("SELECT * FROM motorist join distributor where motorist.distributor_code = distributor.distributor_code ".$motorist_type_query." ".$regional_query." ".$search_query." group by distributor.regional")->num_rows();
							$total_area_footer = $this->db->query("SELECT * FROM motorist join distributor where motorist.distributor_code = distributor.distributor_code ".$motorist_type_query." ".$regional_query." ".$search_query." group by distributor.area")->num_rows();
							$total_distributor_footer = $this->db->query("SELECT * FROM motorist join distributor where motorist.distributor_code = distributor.distributor_code ".$motorist_type_query." ".$regional_query." ".$search_query." group by distributor.distributor_code")->num_rows();
							$total_motorist_footer = $this->db->query("SELECT * FROM motorist join distributor where motorist.distributor_code = distributor.distributor_code ".$motorist_type_query." ".$regional_query." ".$search_query." group by motorist.id_motorist")->num_rows();
							$total_motorist_tipe_footer = $this->db->query("SELECT * FROM motorist join distributor where motorist.distributor_code = distributor.distributor_code ".$motorist_type_query." ".$regional_query." ".$search_query." group by motorist.motorist_type")->num_rows();
							$total_call_motorist_footer =  $this->db->query("SELECT visit.customer_code FROM visit JOIN store on store.customer_code = visit.customer_code WHERE status_visit = 'call' AND time_stamp_visit between '".$tanggal_bulan_awal."' AND '".$tanggal_bulan_akhir."' ".$motorist_type_store_query." ".$search_query_store."  ".$regional_store_query." ")->num_rows();
							$total_extra_call_motorist_footer =  $this->db->query("SELECT visit.customer_code FROM visit JOIN store on store.customer_code = visit.customer_code WHERE status_visit = 'extra_call' AND time_stamp_visit between '".$tanggal_bulan_awal."' AND '".$tanggal_bulan_akhir."' ".$motorist_type_store_query." ".$search_query_store." ".$regional_store_query." ")->num_rows();
							$total_effective_call_motorist_footer =  $this->db->query("SELECT visit.customer_code FROM visit JOIN store on store.customer_code = visit.customer_code WHERE status_visit = 'call' AND status_order = 'order' AND time_stamp_visit between '".$tanggal_bulan_awal."' AND '".$tanggal_bulan_akhir."' ".$search_query_store." ".$motorist_type_store_query." ".$regional_store_query." ")->num_rows();
							$total_target_bulanan_footer = $this->db->query("SELECT SUM(target_bulanan) as target_bulanan FROM motorist join distributor on distributor.distributor_code = motorist.distributor_code WHERE id_motorist !='' ".$regional_query." ".$motorist_type_query." ")->result_array();
							$penjualan_bulanan_footer = $this->db->query("SELECT SUM(total_order) as total_penjualan_bulanan FROM orders JOIN store on store.customer_code = orders.customer_code WHERE date between '".$tanggal_bulan_awal."' AND '".$tanggal_bulan_akhir."' ".$regional_store_query." ".$motorist_type_store_query." ".$search_query_store." ")->result_array();
							$total_setoran_footer = $this->db->query("SELECT SUM(setoran) as total_setoran FROM absence JOIN distributor on distributor.distributor_code = absence.distributor_code JOIN motorist on motorist.id_motorist = absence.id_motorist WHERE date_absence between '".$tanggal_bulan_awal."' AND '".$tanggal_bulan_akhir."' ".$regional_query." ".$search_query." ".$motorist_type_query." ")->result_array();
							$total_master_outlet = $this->db->query("SELECT id_store FROM store WHERE id_store != '' ".$regional_store_query." ".$motorist_type_store_query." ".$search_query_store." ")->num_rows();
							$total_master_outlet_active = $this->db->query("SELECT id_order FROM orders JOIN store on store.customer_code = orders.customer_code  WHERE  date between '".$tanggal_bulan_awal."' AND '".$tanggal_bulan_akhir."' ".$motorist_type_store_query." ".$search_query_store." ".$regional_store_query." group by orders.customer_code")->num_rows();
							$total_noo_footer = $this->db->query("SELECT * FROM noo JOIN store on store.latitude = noo.latitude AND store.longitude = noo.longitude  WHERE noo.customer_create_date between '".$tanggal_bulan_awal."' AND '".$tanggal_bulan_akhir."' ".$regional_store_query." ".$search_query_store." ".$motorist_type_store_query."  group by store.customer_code ")->num_rows();
							$total_store_footer = $this->db->query("SELECt * FROM store WHERE customer_create_date between '".$tanggal_bulan_awal."' AND '".$tanggal_bulan_akhir."' ".$regional_store_query." ".$motorist_type_store_query." ".$search_query_store." ")->num_rows();
							$total_store_keseluruhan_footer = 0;
							
							$store_senin_footer = $this->db->query("SELECT id_store FROM store WHERE  day_visit = 'monday' ".$motorist_type_store_query." ".$regional_store_query."  ".$search_query_store." ")->num_rows();
							//echo "store_senin".$store_senin."<br>";
							$total_store_senin_footer = $total_senin * $store_senin_footer;
							$store_selasa_footer = $this->db->query("SELECT id_store FROM store WHERE day_visit = 'tuesday' ".$motorist_type_store_query." ".$regional_store_query." ".$search_query_store."  ")->num_rows();
							//echo "store_selasa".$store_selasa."<br>";
							$total_store_selasa_footer = $total_selasa * $store_selasa_footer;
							$store_rabu_footer = $this->db->query("SELECT id_store FROM store WHERE  day_visit = 'wednesday' ".$motorist_type_store_query." ".$regional_store_query." ".$search_query_store."  ")->num_rows();
							$total_store_rabu_footer = $total_rabu * $store_rabu_footer;
							//echo "store_rabu".$store_rabu."<br>";
							$store_kamis_footer = $this->db->query("SELECT id_store FROM store WHERE day_visit = 'thursday' ".$motorist_type_store_query." ".$regional_store_query." ".$search_query_store."  ")->num_rows();
							$total_store_kamis_footer = $total_kamis * $store_kamis_footer;
							//echo "store_kamis".$store_kamis."<br>"; 
							$store_jumat_footer = $this->db->query("SELECT id_store FROM store WHERE day_visit = 'friday' ".$motorist_type_store_query." ".$regional_store_query." ".$search_query_store."  ")->num_rows();
							$total_store_jumat_footer = $total_jumat * $store_jumat_footer;
							//echo "store_jumat".$store_jumat."<br>";
							$store_sabtu_footer = $this->db->query("SELECT id_store FROM store WHERE day_visit = 'saturday' ".$motorist_type_store_query." ".$regional_store_query."  ".$search_query_store." ")->num_rows();
							$total_store_sabtu_footer = $total_sabtu * $store_sabtu_footer;
							//echo "store_sabtu".$store_sabtu."<br>";
							$total_keseluruhan_footer = $total_store_senin_footer+$total_store_selasa_footer+$total_store_rabu_footer+$total_store_kamis_footer+$total_store_jumat_footer+$total_store_sabtu_footer;
							
							}
							else
							{
						
									$motorist_type_query = 'AND motorist.motorist_type in ('.$data_role_etools[0]['motorist_view'].') ';
									$motorist_type_store_query = 'AND store.motorist_type in ('.$data_role_etools[0]['motorist_view'].') ';
								
							
								
								if($data_account[0]['user_type']=='Ado')
								{
									
									$total_regional_footer = $this->db->query("SELECT * FROM motorist join distributor where motorist.distributor_code = distributor.distributor_code ".$motorist_type_query." ".$regional_query." ".$distributor_query." ".$area_query." ".$search_query." AND motorist.distributor_code = '".$data_account[0]['code']."' group by distributor.regional")->num_rows();
									$total_area_footer = $this->db->query("SELECT * FROM motorist join distributor where motorist.distributor_code = distributor.distributor_code ".$motorist_type_query." ".$regional_query." ".$distributor_query." ".$area_query." ".$search_query." AND motorist.distributor_code = '".$data_account[0]['code']."' group by distributor.area")->num_rows();
									$total_distributor_footer = $this->db->query("SELECT * FROM motorist join distributor where motorist.distributor_code = distributor.distributor_code ".$motorist_type_query." ".$regional_query." ".$distributor_query." ".$area_query." ".$search_query." AND motorist.distributor_code = '".$data_account[0]['code']."' group by distributor.distributor_code")->num_rows();
									$total_motorist_footer = $this->db->query("SELECT * FROM motorist join distributor where motorist.distributor_code = distributor.distributor_code ".$motorist_type_query." ".$regional_query." ".$distributor_query." ".$area_query." ".$search_query." AND motorist.distributor_code = '".$data_account[0]['code']."' group by motorist.id_motorist")->num_rows();
									$total_motorist_tipe_footer = $this->db->query("SELECT * FROM motorist join distributor where motorist.distributor_code = distributor.distributor_code ".$motorist_type_query." ".$regional_query." ".$distributor_query." ".$area_query." ".$search_query." AND motorist.distributor_code = '".$data_account[0]['code']."' group by motorist.motorist_type")->num_rows();
									$total_call_motorist_footer =  $this->db->query("SELECT visit.customer_code FROM visit JOIN store on store.customer_code = visit.customer_code WHERE status_visit = 'call' AND time_stamp_visit between '".$tanggal_bulan_awal."' AND '".$tanggal_bulan_akhir."' ".$motorist_type_store_query." ".$search_query_store." ".$distributor_store_query." ".$area_store_query."  ".$regional_store_query." AND store.distributor_code = '".$data_account[0]['code']."' ")->num_rows();
									$total_extra_call_motorist_footer =  $this->db->query("SELECT visit.customer_code FROM visit JOIN store on store.customer_code = visit.customer_code WHERE status_visit = 'extra_call' AND time_stamp_visit between '".$tanggal_bulan_awal."' AND '".$tanggal_bulan_akhir."' ".$motorist_type_store_query." ".$search_query_store." ".$distributor_store_query." ".$area_store_query." ".$regional_store_query." AND store.distributor_code = '".$data_account[0]['code']."' ")->num_rows();
									$total_effective_call_motorist_footer =  $this->db->query("SELECT visit.customer_code FROM visit JOIN store on store.customer_code = visit.customer_code WHERE status_visit = 'call' AND status_order = 'order' AND time_stamp_visit between '".$tanggal_bulan_awal."' AND '".$tanggal_bulan_akhir."' ".$search_query_store." ".$motorist_type_store_query." ".$distributor_store_query." ".$area_store_query." ".$regional_store_query." AND store.distributor_code = '".$data_account[0]['code']."' ")->num_rows();
									$total_target_bulanan_footer = $this->db->query("SELECT SUM(target_bulanan) as target_bulanan FROM motorist join distributor on distributor.distributor_code = motorist.distributor_code WHERE id_motorist !='' ".$regional_query." ".$distributor_query." ".$area_query." ".$motorist_type_query." AND motorist.distributor_code = '".$data_account[0]['code']."' ")->result_array();
									$penjualan_bulanan_footer = $this->db->query("SELECT SUM(total_order) as total_penjualan_bulanan FROM orders JOIN store on store.customer_code = orders.customer_code WHERE date between '".$tanggal_bulan_awal."' AND '".$tanggal_bulan_akhir."' ".$regional_store_query." ".$distributor_store_query." ".$area_store_query." ".$motorist_type_store_query." ".$search_query_store." AND store.distributor_code = '".$data_account[0]['code']."' ")->result_array();
									$total_setoran_footer = $this->db->query("SELECT SUM(setoran) as total_setoran FROM absence JOIN distributor on distributor.distributor_code = absence.distributor_code JOIN motorist on motorist.id_motorist = absence.id_motorist WHERE date_absence between '".$tanggal_bulan_awal."' AND '".$tanggal_bulan_akhir."' ".$regional_query." ".$distributor_query." ".$area_query." ".$search_query." ".$motorist_type_query." AND motorist.distributor_code = '".$data_account[0]['code']."' ")->result_array();
									$total_master_outlet = $this->db->query("SELECT id_store FROM store WHERE id_store != '' ".$regional_store_query." ".$motorist_type_store_query." ".$search_query_store." AND store.distributor_code = '".$data_account[0]['code']."' ")->num_rows();
									$total_master_outlet_active = $this->db->query("SELECT id_order FROM orders JOIN store on store.customer_code = orders.customer_code  WHERE  date between '".$tanggal_bulan_awal."' AND '".$tanggal_bulan_akhir."' ".$motorist_type_store_query." ".$search_query_store." ".$regional_store_query." ".$distributor_store_query." ".$area_store_query." AND store.distributor_code = '".$data_account[0]['code']."' group by orders.customer_code")->num_rows();
									$total_noo_footer = $this->db->query("SELECT * FROM noo JOIN store on store.latitude = noo.latitude AND store.longitude = noo.longitude  WHERE noo.customer_create_date between '".$tanggal_bulan_awal."' AND '".$tanggal_bulan_akhir."' ".$regional_store_query." ".$search_query_store." ".$motorist_type_store_query." ".$distributor_store_query." ".$area_store_query."  AND store.distributor_code = '".$data_account[0]['code']."' group by store.customer_code ")->num_rows();
									$total_store_footer = $this->db->query("SELECt * FROM store WHERE customer_create_date between '".$tanggal_bulan_awal."' AND '".$tanggal_bulan_akhir."' ".$regional_store_query." ".$motorist_type_store_query." ".$search_query_store." AND store.distributor_code = '".$data_account[0]['code']."' ")->num_rows();
									$total_store_keseluruhan_footer = 0;
									
									$store_senin_footer = $this->db->query("SELECT id_store FROM store WHERE  day_visit = 'monday' ".$motorist_type_store_query." ".$regional_store_query." ".$distributor_store_query." ".$area_store_query."  ".$search_query_store." AND store.distributor_code = '".$data_account[0]['code']."' ")->num_rows();
									//echo "store_senin".$store_senin."<br>";
									$total_store_senin_footer = $total_senin * $store_senin_footer;
									$store_selasa_footer = $this->db->query("SELECT id_store FROM store WHERE day_visit = 'tuesday' ".$motorist_type_store_query." ".$regional_store_query." ".$distributor_store_query." ".$area_store_query." ".$search_query_store." AND store.distributor_code = '".$data_account[0]['code']."'  ")->num_rows();
									//echo "store_selasa".$store_selasa."<br>";
									$total_store_selasa_footer = $total_selasa * $store_selasa_footer;
									$store_rabu_footer = $this->db->query("SELECT id_store FROM store WHERE  day_visit = 'wednesday' ".$motorist_type_store_query." ".$regional_store_query." ".$distributor_store_query." ".$area_store_query." ".$search_query_store." AND store.distributor_code = '".$data_account[0]['code']."'  ")->num_rows();
									$total_store_rabu_footer = $total_rabu * $store_rabu_footer;
									//echo "store_rabu".$store_rabu."<br>";
									$store_kamis_footer = $this->db->query("SELECT id_store FROM store WHERE day_visit = 'thursday' ".$motorist_type_store_query." ".$regional_store_query." ".$distributor_store_query." ".$area_store_query." ".$search_query_store." AND store.distributor_code = '".$data_account[0]['code']."'  ")->num_rows();
									$total_store_kamis_footer = $total_kamis * $store_kamis_footer;
									//echo "store_kamis".$store_kamis."<br>"; 
									$store_jumat_footer = $this->db->query("SELECT id_store FROM store WHERE day_visit = 'friday' ".$motorist_type_store_query." ".$regional_store_query." ".$distributor_store_query." ".$area_store_query." ".$search_query_store."  AND store.distributor_code = '".$data_account[0]['code']."' ")->num_rows();
									$total_store_jumat_footer = $total_jumat * $store_jumat_footer;
									//echo "store_jumat".$store_jumat."<br>";
									$store_sabtu_footer = $this->db->query("SELECT id_store FROM store WHERE day_visit = 'saturday' ".$motorist_type_store_query." ".$regional_store_query." ".$distributor_store_query." ".$area_store_query."  ".$search_query_store." AND store.distributor_code = '".$data_account[0]['code']."' ")->num_rows();
									$total_store_sabtu_footer = $total_sabtu * $store_sabtu_footer;
									//echo "store_sabtu".$store_sabtu."<br>";
									$total_keseluruhan_footer = $total_store_senin_footer+$total_store_selasa_footer+$total_store_rabu_footer+$total_store_kamis_footer+$total_store_jumat_footer+$total_store_sabtu_footer;
									
									
									
									}
								else if($data_account[0]['user_type']=='Regional')
								{
									
									$total_regional_footer = $this->db->query("SELECT * FROM motorist join distributor where motorist.distributor_code = distributor.distributor_code ".$motorist_type_query." ".$regional_query." ".$distributor_query." ".$area_query." ".$search_query." AND distributor.regional = '".$data_account[0]['code']."' group by distributor.regional")->num_rows();
									$total_area_footer = $this->db->query("SELECT * FROM motorist join distributor where motorist.distributor_code = distributor.distributor_code ".$motorist_type_query." ".$regional_query." ".$search_query." ".$distributor_query." ".$area_query." AND distributor.regional = '".$data_account[0]['code']."' group by distributor.area")->num_rows();
									$total_distributor_footer = $this->db->query("SELECT * FROM motorist join distributor where motorist.distributor_code = distributor.distributor_code ".$motorist_type_query." ".$regional_query." ".$search_query." ".$distributor_query." ".$area_query." AND distributor.regional = '".$data_account[0]['code']."' group by distributor.distributor_code")->num_rows();
									$total_motorist_footer = $this->db->query("SELECT * FROM motorist join distributor where motorist.distributor_code = distributor.distributor_code ".$motorist_type_query." ".$regional_query." ".$search_query." ".$distributor_query." ".$area_query." AND distributor.regional = '".$data_account[0]['code']."'group by motorist.id_motorist")->num_rows();
									$total_motorist_tipe_footer = $this->db->query("SELECT * FROM motorist join distributor where motorist.distributor_code = distributor.distributor_code ".$motorist_type_query." ".$regional_query." ".$search_query." ".$distributor_query." ".$area_query." AND distributor.regional = '".$data_account[0]['code']."' group by motorist.motorist_type")->num_rows();
									$total_call_motorist_footer =  $this->db->query("SELECT visit.customer_code FROM visit JOIN store on store.customer_code = visit.customer_code WHERE status_visit = 'call' AND time_stamp_visit between '".$tanggal_bulan_awal."' AND '".$tanggal_bulan_akhir."' ".$motorist_type_store_query." ".$distributor_store_query." ".$area_store_query." ".$search_query_store."  ".$regional_store_query." AND store.regional = '".$data_account[0]['code']."' ")->num_rows();
									$total_extra_call_motorist_footer =  $this->db->query("SELECT visit.customer_code FROM visit JOIN store on store.customer_code = visit.customer_code WHERE status_visit = 'extra_call' AND time_stamp_visit between '".$tanggal_bulan_awal."' AND '".$tanggal_bulan_akhir."' ".$motorist_type_store_query." ".$distributor_store_query." ".$area_store_query." ".$search_query_store." ".$regional_store_query." AND store.regional = '".$data_account[0]['code']."' ")->num_rows();
									$total_effective_call_motorist_footer =  $this->db->query("SELECT visit.customer_code FROM visit JOIN store on store.customer_code = visit.customer_code WHERE status_visit = 'call' AND status_order = 'order' AND time_stamp_visit between '".$tanggal_bulan_awal."' AND '".$tanggal_bulan_akhir."' ".$search_query_store." ".$distributor_store_query." ".$area_store_query." ".$motorist_type_store_query." ".$regional_store_query." AND store.regional = '".$data_account[0]['code']."' ")->num_rows();
									$total_target_bulanan_footer = $this->db->query("SELECT SUM(target_bulanan) as target_bulanan FROM motorist join distributor on distributor.distributor_code = motorist.distributor_code WHERE id_motorist !='' ".$regional_query." ".$distributor_query." ".$area_query." ".$motorist_type_query." AND distributor.regional = '".$data_account[0]['code']."' ")->result_array();
									$penjualan_bulanan_footer = $this->db->query("SELECT SUM(total_order) as total_penjualan_bulanan FROM orders JOIN store on store.customer_code = orders.customer_code WHERE date between '".$tanggal_bulan_awal."' AND '".$tanggal_bulan_akhir."' ".$regional_store_query." ".$distributor_store_query." ".$area_store_query." ".$motorist_type_store_query." ".$search_query_store." AND store.regional = '".$data_account[0]['code']."' ")->result_array();
									$total_setoran_footer = $this->db->query("SELECT SUM(setoran) as total_setoran FROM absence JOIN distributor on distributor.distributor_code = absence.distributor_code JOIN motorist on motorist.id_motorist = absence.id_motorist WHERE date_absence between '".$tanggal_bulan_awal."' AND '".$tanggal_bulan_akhir."' ".$regional_query." ".$distributor_query." ".$area_query." ".$search_query." ".$motorist_type_query."  AND distributor.regional = '".$data_account[0]['code']."'")->result_array();
									$total_master_outlet = $this->db->query("SELECT id_store FROM store WHERE id_store != '' ".$regional_store_query." ".$distributor_store_query." ".$area_store_query." ".$motorist_type_store_query." ".$search_query_store." AND store.regional = '".$data_account[0]['code']."' ")->num_rows();
									$total_master_outlet_active = $this->db->query("SELECT id_order FROM orders JOIN store on store.customer_code = orders.customer_code  WHERE  date between '".$tanggal_bulan_awal."' AND '".$tanggal_bulan_akhir."' ".$motorist_type_store_query." ".$search_query_store." ".$regional_store_query." ".$distributor_store_query." ".$area_store_query." AND store.regional = '".$data_account[0]['code']."' group by orders.customer_code")->num_rows();
									$total_noo_footer = $this->db->query("SELECT * FROM noo JOIN store on store.latitude = noo.latitude AND store.longitude = noo.longitude  WHERE noo.customer_create_date between '".$tanggal_bulan_awal."' AND '".$tanggal_bulan_akhir."' ".$regional_store_query." ".$search_query_store." ".$distributor_store_query." ".$area_store_query." ".$motorist_type_store_query." AND store.regional = '".$data_account[0]['code']."'  group by store.customer_code ")->num_rows();
									$total_store_footer = $this->db->query("SELECt * FROM store WHERE customer_create_date between '".$tanggal_bulan_awal."' AND '".$tanggal_bulan_akhir."' ".$regional_store_query." ".$motorist_type_store_query." ".$distributor_store_query." ".$area_store_query." ".$search_query_store." AND store.regional = '".$data_account[0]['code']."' ")->num_rows();
									$total_store_keseluruhan_footer = 0;
									
									$store_senin_footer = $this->db->query("SELECT id_store FROM store WHERE  day_visit = 'monday' ".$motorist_type_store_query." ".$regional_store_query." ".$distributor_store_query." ".$area_store_query."  ".$search_query_store." AND store.regional = '".$data_account[0]['code']."' ")->num_rows();
									//echo "store_senin".$store_senin."<br>";
									$total_store_senin_footer = $total_senin * $store_senin_footer;
									$store_selasa_footer = $this->db->query("SELECT id_store FROM store WHERE day_visit = 'tuesday' ".$motorist_type_store_query." ".$regional_store_query." ".$distributor_store_query." ".$area_store_query." ".$search_query_store." AND store.regional = '".$data_account[0]['code']."'  ")->num_rows();
									//echo "store_selasa".$store_selasa."<br>";
									$total_store_selasa_footer = $total_selasa * $store_selasa_footer;
									$store_rabu_footer = $this->db->query("SELECT id_store FROM store WHERE  day_visit = 'wednesday' ".$motorist_type_store_query." ".$regional_store_query." ".$distributor_store_query." ".$area_store_query." ".$search_query_store." AND store.regional = '".$data_account[0]['code']."'  ")->num_rows();
									$total_store_rabu_footer = $total_rabu * $store_rabu_footer;
									//echo "store_rabu".$store_rabu."<br>";
									$store_kamis_footer = $this->db->query("SELECT id_store FROM store WHERE day_visit = 'thursday' ".$motorist_type_store_query." ".$regional_store_query." ".$distributor_store_query." ".$area_store_query." ".$search_query_store." AND store.regional = '".$data_account[0]['code']."'  ")->num_rows();
									$total_store_kamis_footer = $total_kamis * $store_kamis_footer;
									//echo "store_kamis".$store_kamis."<br>"; 
									$store_jumat_footer = $this->db->query("SELECT id_store FROM store WHERE day_visit = 'friday' ".$motorist_type_store_query." ".$regional_store_query." ".$distributor_store_query." ".$area_store_query." ".$search_query_store." AND store.regional = '".$data_account[0]['code']."'  ")->num_rows();
									$total_store_jumat_footer = $total_jumat * $store_jumat_footer;
									//echo "store_jumat".$store_jumat."<br>";
									$store_sabtu_footer = $this->db->query("SELECT id_store FROM store WHERE day_visit = 'saturday' ".$motorist_type_store_query." ".$regional_store_query." ".$distributor_store_query." ".$area_store_query."  ".$search_query_store." AND store.regional = '".$data_account[0]['code']."' ")->num_rows();
									$total_store_sabtu_footer = $total_sabtu * $store_sabtu_footer;
									//echo "store_sabtu".$store_sabtu."<br>";
									$total_keseluruhan_footer = $total_store_senin_footer+$total_store_selasa_footer+$total_store_rabu_footer+$total_store_kamis_footer+$total_store_jumat_footer+$total_store_sabtu_footer;
									
									
									
									}
							
							}
							
							
							
						$persentasi_outlet_active_footer = 0;	
						$persentasi_call_footer = 0;
						$persentasi_extra_call_footer = 0;
						$persentasi_effective_call_footer = 0;
						$persentasi_extra_effective_call_footer = 0;
						$persentasi_target_bulanan_footer = 0;
						
						
						if($total_master_outlet>0)
							{
							$persentasi_outlet_active_footer = ($total_master_outlet_active * 100) / $total_master_outlet;
							$persentasi_outlet_active_footer = number_format($persentasi_outlet_active_footer, 0, '.', '');	
							}
							
						if($total_keseluruhan_footer>0)
							{
							$persentasi_call_footer = ($total_call_motorist_footer * 100) / $total_keseluruhan_footer;
							$persentasi_call_footer = number_format($persentasi_call_footer, 0, '.', '');	
							}
						
						if($total_keseluruhan_footer>0)
							{
							$persentasi_extra_call_footer = ($total_extra_call_motorist_footer * 100) / $total_keseluruhan_footer;
							$persentasi_extra_call_footer = number_format($persentasi_extra_call_footer, 0, '.', '');	
							}
						
						if($total_keseluruhan_footer>0)
							{
							$persentasi_effective_call_footer = ($total_effective_call_motorist_footer * 100) / $total_keseluruhan_footer;
							$persentasi_effective_call_footer = number_format($persentasi_effective_call_footer, 0, '.', '');	
							}
						
						
						if($total_target_bulanan_footer[0]['target_bulanan']>0)
							{
							$persentasi_target_bulanan_footer = ($penjualan_bulanan_footer[0]['total_penjualan_bulanan'] * 100) / $total_target_bulanan_footer[0]['target_bulanan'];
							$persentasi_target_bulanan_footer = number_format($persentasi_target_bulanan_footer, 0, '.', '');	
							}
							
						
					
					
						$selisih_setoran = $total_setoran_footer[0]['total_setoran']- $penjualan_bulanan_footer[0]['total_penjualan_bulanan'] ;
						
						
					?>
                    
                   <tfoot>
                    	<td>Total</td>
					    <td><?php echo $total_regional_footer; ?> Regional</td>
						<td><?php echo $total_area_footer; ?> Area</td>
						<td><?php echo $total_distributor_footer; ?> Distributor</td>
                        <td><?php echo $total_distributor_footer; ?> Distributor</td>
                        <td><?php echo $total_motorist_footer; ?> Motorist</td>
                        <td><?php echo $total_motorist_tipe_footer; ?> Tipe Motorist</td>
                        <td><?php echo $total_keseluruhan_footer; ?> </td>
                        <td><?php echo $total_call_motorist_footer; ?> </td>
						<td><?php echo $persentasi_call_footer; ?> %</td>
                        <td><?php echo $total_extra_call_motorist_footer; ?></td>
						<td><?php echo $persentasi_extra_call_footer; ?> %</td>
                        <td><?php echo $total_effective_call_motorist_footer; ?></td>
						<td><?php echo $persentasi_effective_call_footer; ?> %</td>
                        <td><?php convert_price($total_target_bulanan_footer[0]['target_bulanan']); ?></td>                       
						<td><?php convert_price($penjualan_bulanan_footer[0]['total_penjualan_bulanan']); ?></td>
                        <td><?php echo $persentasi_target_bulanan_footer;  ?> %</td>
						<td><?php convert_price($total_setoran_footer[0]['total_setoran']); ?></td>
						<td><?php convert_price($selisih_setoran); ?></td>
                        <td><?php echo $total_master_outlet ?></td>
                        <td><?php echo $total_master_outlet_active; ?></td>
						<td><?php echo $persentasi_outlet_active_footer; ?> %</td>
                        <td><?php echo $total_store_footer; ?></td>
                   		<td><?php echo $total_noo_footer; ?></td>
                    </tfoot>
                    
                      
             </table>
             </div>
            		  <div class="pagination page">  
                     <?php  echo $this->pagination->create_links(); ?>
                     </div>
                    
            
           </div>
            </div>
            
            </div>
      </section>


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

	
		$("#select-area").pqSelect({
   multiplePlaceholder: 'Select Area',
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
</script>