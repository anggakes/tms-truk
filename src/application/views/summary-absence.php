 <!-- HEADER -->
 

    
 <section class="content-header">
          <h1>
            Summary Absensi
            <small>Absensi of E-tools</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="<?php echo BASE_URL(); ?>"><i class="fa fa-dashboard"></i>Home</a></li>
            <li><a href="<?php echo BASE_URL()."absence"; ?>"><i class="fa fa-dashboard"></i>Absensi</a></li>
          </ol>
        </section>
  
  
   <!-- Content -->
   <section class="content">

          <div class="box sms box-default color-palette-box">
            <div class="box-header with-border">
              <h3 class="box-title"><i class="fa fa-table"></i> Table Absensi</h3>
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
                     
                      <?php
			$search = isset($_GET['search']) ? $_GET['search'] : '';
			$bulan = isset($_GET['bulan']) ? $_GET['bulan'] : '';
			$year = isset($_GET['tahun']) ? $_GET['tahun'] : '';
			
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
			?>
            
            
            
           

            <div id="wrapper-console" class="clearfix">
                <div id="wrapper-search">
                             <form action="<?php echo base_url()."index.php/absence/summaryAbsence" ?>" method="get">
                             <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                               <?php if($data_account[0]['user_type']=="Administrator"){ ?>
                                 <div class="select-filter">
                             	<select name="regional[]" id="select-regional" multiple="multiple" >
                              	<?php foreach($data_regional as $data_regional) {?>
                              	<option <?php if(isset($_GET['regional'])) {if(in_array($data_regional['regional_name'], $regional)) {?> selected="selected" <?php }} ?> value="<?php echo $data_regional['regional_name']; ?>"><?php echo $data_regional['regional_name']; ?></option>
                              	<?php } ?>
                             	</select>
                             	</div>
							   <?php } ?>
							   
							   <?php if($data_account[0]['user_type']=="Administrator" or $data_account[0]['user_type']=="Regional"){ ?>
                              <div class="select-filter">
                             	<select name="area[]" id="select-area" multiple="multiple" >
                              	<?php foreach($data_area as $data_area) {?>
                              	<option <?php if(isset($_GET['area'])) {if(in_array($data_area['area'], $area)) {?> selected="selected" <?php }} ?> value="<?php echo $data_area['area']; ?>"><?php echo $data_area['area']; ?></option>
                              	<?php } ?>
                             	</select>
                             	</div>
                                <?php } ?>
								
								
								<?php if($data_account[0]['user_type']=="Administrator" or $data_account[0]['user_type']=="Regional"){ ?>
                             <div class="select-filter">
                             <select name="distributor[]" id="select-distributor" multiple="multiple" >
                              <?php foreach($data_distributor as $data_distributor) {?>
                              <option <?php if(isset($_GET['distributor'])) {if(in_array($data_distributor['distributor_code'], $distributor)) {?> selected="selected" <?php }} ?> value="<?php echo $data_distributor['distributor_code']; ?>" ><?php echo $data_distributor['distributor_name']; ?></option>
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
                                
                                <select name="bulan" id="bulan">
                                	<option value="">Choose Month</option>
                                    <option <?php if($bulan=="01"){ ?> selected="selected" <?php }?> value="01">January</option>
                                    <option <?php if($bulan=="02"){ ?> selected="selected" <?php }?> value="02">February</option>
                                    <option <?php if($bulan=="03"){ ?> selected="selected" <?php }?> value="03">March</option>
                                    <option <?php if($bulan=="04"){ ?> selected="selected" <?php }?> value="04">April</option>
                                    <option <?php if($bulan=="05"){ ?> selected="selected" <?php }?> value="05">May</option>
                                    <option <?php if($bulan=="06"){ ?> selected="selected" <?php }?> value="06">Juni</option>
                                    <option <?php if($bulan=="07"){ ?> selected="selected" <?php }?> value="07">July</option>
                                    <option <?php if($bulan=="08"){ ?> selected="selected" <?php }?> value="08">August</option>
                                    <option <?php if($bulan=="09"){ ?> selected="selected" <?php }?> value="09">September</option>
                                    <option <?php if($bulan=="10"){ ?> selected="selected" <?php }?> value="10">October</option>
                                    <option <?php if($bulan=="11"){ ?> selected="selected" <?php }?> value="11">November</option>
                                    <option <?php if($bulan=="12"){ ?> selected="selected" <?php }?> value="12">December</option>
                                </select>
                                
                                 <select name="tahun" id="tahun">
                                	<option value="">Choose year</option>
                                    <option <?php if($year=="2016"){ ?> selected="selected" <?php }?> value="2016">2016</option>
                                    <option <?php if($year=="2017"){ ?> selected="selected" <?php }?> value="2017">2017</option>
                                    <option <?php if($year=="2018"){ ?> selected="selected" <?php }?> value="2018">2018</option>
                                </select>

                                <input type="text" id="search" name="search" placeholder="Search by Motorist Code"  value="<?php echo $search; ?>" />
                                <input type="submit" id="submit"  value="Search"/>
                                <?php if($search!=""  or $regional_implode!="" or $motorist_type_implode!="" or $bulan!="" or $year!="")
								{?>
                                <a href="<?php echo base_url()."index.php/absence/summaryAbsence" ?>" id="clear-search">Clear Search</a>
                                <?php } ?>
                             </form>
                </div>
                <div id="wrapper-button" class="clearfix">
                	<a href="<?php echo base_url()."index.php/absence/exportSummaryAbsence?search=".$search."&&regional=".$regional_implode."&&distributor=".$distributor_implode."&&area=".$area_implode."&&motorist_type=".$motorist_type_implode."&&bulan=".$bulan."&&year=".$year; ?>" class="button orange-button">
                    	Export Motorist Absence
                    </a>
             </div>
                </div>
            <div id="wrapper-table">
           	
            <?php
				
				if($bulan=="")
				{
				$month = date('n');
				$month_with_null = date('m');
				}
				else
				{
					$month = intval($bulan);
					$month_with_null = $bulan;
					}
					
				if($year=="")
				{
				$year = date('Y');
				}
				else
				{
				$year = $year;
				}
					
				$total_day = date('t', mktime(0, 0, 0, $month, 1, $year)); 
				
				function convert_price($price)
			{
				echo "Rp. ".number_format($price, 0 , '' , '.' );		
					}
			?>
            
            <?php
				function number_of_working_days($from, $to) {
				$workingDays = [1,2,3,4,5,6]; 
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
			
			 $hari_kerja = number_of_working_days($year.'-'.$month_with_null.'-01', $year.'-'.$month_with_null.'-'.$total_day);
			 $bulan_sekarang = date('n');
			 if($bulan=="")
			 {
			 $tanggal_sekarang = date('d');
			 $hari_kerja_sekarang = number_of_working_days($year.'-'.$month_with_null.'-01', $year.'-'.$month_with_null.'-'.$tanggal_sekarang);
			 }
			 else
			 { 
			   if($month>$bulan_sekarang)
			   {$hari_kerja_sekarang=0;}
			   else
			 {$hari_kerja_sekarang = number_of_working_days($year.'-'.$month_with_null.'-01', $year.'-'.$month_with_null.'-'.$total_day);}
			 
			 }
			
			?>  
            
             <div class="grid_4 height400">              
           	<table id="myTable05" class="fancyTable table-bordered table-hover">
                    <thead>
                      <tr>
                        <th><div class="mid">Nama Motorist</div></th>
                        <th><div class="mid">Regional</div></th>
                        <th><div class="mid">Area</div></th>
                        <th><div class="mid">Kode Distributor</div></th>
                        <th><div class="mid">Nama Distributor</div></th>
                        <th><div class="mid">Tipe Motorist</div></th>
                        <th><div class="mid">Kode Motorist</div></th>
                        <th><div class="mid">Hari kerja</div></th>
                        <th><div class="mid">Total Hadir</div></th>
                        <th><div class="mid">Total Izin</div></th>
                        <th><div class="mid">Total Sakit</div></th>
                        <th><div class="mid">Total Absent</div></th>
                        <?php
						
						for ($i = 1; $i <= $total_day; $i++) {
							
							$date = $year.'-'.$month.'-'.sprintf('%02d', $i);
							$date1 = strtotime($date);
							$date2 = date("l", $date1);
							$date3 = strtolower($date2);
							if (($date3 == "sunday")) {
								
								?>
								<th class="red"><div class="mid"><?php echo $i.'/'.$month.'/'.$year;  ?></div></th>
								<?php
							} else {
								?>
								<th><div class="mid"><?php echo $i.'/'.$month.'/'.$year;  ?></div></th>
								<?php
							}
										
                        	
                            
                        
						}
						 
						
						?>
                        
                        
                      </tr>
                    </thead>
             		<tbody>
                    <?php foreach($data_absence as $data_absence) {?>
                    <tr>
                    	<td><div style="width:200px;"><?php echo $data_absence->motorist_name; ?>-<?php echo $data_absence->motorist_code; ?></div></td>
                    	<td><?php echo $data_absence->regional; ?></td>
                        <td><?php echo $data_absence->area; ?></td>
                        <td><?php echo $data_absence->distributor_code; ?></td>
                        <td><?php echo $data_absence->distributor_name; ?></td>
                        <td><?php echo $data_absence->motorist_type; ?></td>
                        <td><?php echo $data_absence->motorist_code; ?></td>
                        <td><?php echo $hari_kerja; ?></td>
                        <td><?php echo $data_absence->total_hadir; ?></td>
                        <td><?php echo $data_absence->total_izin; ?></td>
                        <td><?php echo $data_absence->total_sakit; ?></td>
                        <td><?php $total_absent = $hari_kerja_sekarang -($data_absence->total_sakit+$data_absence->total_hadir+$data_absence->total_izin); echo $total_absent; ?></td>
                        <?php
						
						for ($i = 1; $i <= $total_day; $i++) {
							
							$date = $year.'-'.$month.'-'.sprintf('%02d', $i);
							$date1 = strtotime($date);
							$date2 = date("l", $date1);
							$date3 = strtolower($date2);
							if (($date3 == "sunday")) {
								?>
								<td class="red">Libur</td>
								<?php
							} else {
								?>
								
                                
                                <?php 
									$this->db->from("absence");
							 		$this->db->where("motorist_code = '".$data_absence->motorist_code."' AND distributor_code = '".$data_absence->distributor_code."'  ");	
									$this->db->where("date_absence LIKE '%".$year.'-'.$month_with_null.'-'.sprintf('%02d', $i)."%'");		
									$query = $this->db->get()->result_array();
									if (empty($query))
									{
										echo "<td>Tidak Absen</td>";
									}
									else
									{
										echo "<td class='".$query[0]['status_absence']."'><a target='_new' href='".base_url()."index.php/absence/detailAbsence/".$query[0]['id_absence']."' >".$query[0]['status_absence']."</a></td>";
									} 
									
								?>
                                
								<?php
							}
										
                        	
                            
                        
						}
						 
						
						?>
                        </tr>
                    <?php }?>
                    </tbody>       
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
	   $('#reservation').daterangepicker({ dateFormat: "dd-mm-yy" }).val();
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
