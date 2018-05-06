 <!-- HEADER -->
 <section class="content-header">
          <h1>
            Daily Motorist
            <small>Motorist of E-tools</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="<?php echo BASE_URL(); ?>"><i class="fa fa-dashboard"></i>Home</a></li>
            <li><a href="<?php echo BASE_URL()."dailySummaryMotorist"; ?>"><i class="fa fa-dashboard"></i>Daily Motorist</a></li>
          </ol>
        </section>
  
  
   <!-- Content -->
   <section class="content">
          <div class="box sms box-default color-palette-box">
            <div class="box-header with-border">
              <h3 class="box-title"><i class="fa fa-table"></i> Table Daily Summary Motorist</h3>
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
			
	
			
			$date = isset($_GET['date']) ? $_GET['date'] : '';
			if($date=='')
			{
				$date = date ('m/d/Y');
				}
			
			
			$date_now_stock = date('Y-m-d');
			if($date!="")
			{
					$tanggal_pecah = explode("/", $date);
					$date_now_stock =$tanggal_pecah[2].'-'.$tanggal_pecah[0].'-'.$tanggal_pecah[1];
			}
					
			function convert_price($price)
			{
				echo "Rp. ".number_format($price, 0 , '' , '.' );		
					}
			?>
            <div id="wrapper-console" class="clearfix">
                <div id="wrapper-search">
                             <form action="<?php echo base_url()."index.php/motorist/dailySummaryMotorist" ?>" method="get">
                             <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                                <input type="text" id="date" name="date" placeholder="Choose Date" value="<?php echo $date; ?>" />
                              

							  <?php if($data_account[0]['user_type']=="Administrator"){ ?>
                                <div class="select-filter">
                             	<select name="regional[]" id="select-regional" multiple="multiple" >
                              	<?php foreach($data_regional as $data_regional) {?>
                              	<option <?php if(isset($_GET['regional'])) {if(in_array($data_regional['regional_name'], $regional)) {?> selected="selected" <?php }} ?> value="<?php echo $data_regional['regional_name']; ?>"><?php echo $data_regional['regional_name']; ?></option>
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
								
								
							<?php if($data_account[0]['user_type']=="Administrator" or $data_account[0]['user_type']=="Regional"){ ?>
                             <div class="select-filter">
                             <select name="distributor[]" id="select-distributor" multiple="multiple" >
                              <?php foreach($data_distributor as $data_distributor) {?>
                              <option <?php if(isset($_GET['distributor'])) {if(in_array($data_distributor['distributor_code'], $distributor)) {?> selected="selected" <?php }} ?> value="<?php echo $data_distributor['distributor_code']; ?>" ><?php echo $data_distributor['distributor_name']; ?></option>
                              <?php } ?>
                             </select>
                             </div>
                             <?php } ?>
                                
                                <input type="text" id="search" name="search" placeholder="Search Motorist Code"  value="<?php echo $search; ?>" />
                                <input type="submit" id="submit"  value="Search"/>
                                <?php if($search!="" or $regional_implode!="" or $motorist_type_implode!="")
								{?>
                                <a href="<?php echo base_url()."index.php/motorist/dailySummaryMotorist" ?>" id="clear-search">Clear Search</a>
                                <?php } ?>
                             </form>
                </div>
                
                <div id="wrapper-button" class="clearfix">
                	<a href="<?php echo base_url()."index.php/motorist/exportDailySummaryMotorist?search=".$search."&&date=".$date."&&regional=".$regional_implode."&&distributor=".$distributor_implode."&&area=".$area_implode."&&motorist_type=".$motorist_type_implode; ?>" class="button orange-button">
                    	Export Table Daily Motorist
                    </a>
                </div>
                
                </div>
            <div id="wrapper-console" class="clearfix">
             <div class="grid_4 height400">              
           	<table id="myTable05" class="fancyTable table-bordered table-hover">
                    <thead>
                      <tr>
                        <th class="mid"><div class="mid">Nama Motorist</div></th>
                        <th class="mid"><div class="mid">Kode Motorist</div></th>
                        <th class="mid"><div class="mid">Tipe Motorist</div></th>
                        <th class="mid"><div class="mid">Kode Distributor</div></th>
                        <th class="mid"><div class="mid">Nama Distributor</div></th>
                        <th class="mid"><div class="mid">A<br />
						Target Call</div></th>
                        <th class="mid"><div class="mid">B<br />
						Call</div></th>
                        <th class="mid"><div class="mid">B/A<br />
						%Call</div></th>
                        <th class="mid"><div class="mid">C<br />
						Ekstra Call</div></th>
                        <th class="mid"><div class="mid">C/B<br />
						%Ekstra Call</div></th>
                        <th class="mid"><div class="mid">D<br />
						Efektif Call</div></th>
                        <th class="mid"><div class="mid">D/A<br />
						%Efektif Call</div></th>
                        <th class="long"><div class="mid">E<br />
						Ekstra Effective Call</div></th>
                        <th class="long"><div class="mid">E/A<br />
						%Ekstra Effective Call</div></th>
                        <th class="long"><div class="mid">F<br />
						Target Penjualan Harian</div></th>
                        <th class="mid"><div class="mid">G<br />
						Penjualan Harian</div></th>
                        <th class="mid"><div class="mid">G/F<br />
						Pencapaian Penjualan</div></th>
						<th class="mid"><div class="mid">I<br />
						Total Setoran</div></th>
						<th class="mid"><div class="mid">I-G<br />
						Selisih Setoran</div></th>
                        <th class="mid"><div class="mid">Daily Call Strike</div></th>
                        <th ><div class="mid">Daily Stock Motorist</div></th>
                      </tr>
                    </thead>
             		<tbody>
                    
                    <?php 
						$ddate = date("Y-m-d");
						$date_new = new DateTime($ddate);
						$week = $date_new->format("W");
						$status_minggu = "";
						if ($week % 2 == 0) {
						  $status_minggu = "F2";
						}
						else
						{
							$status_minggu = "F1";
						}

						$date_now = date('Y-m-d');
						$date_convert = date_create($date_now);
						$day = date_format($date_convert,"l");
						if($date!="")
						{
							$tanggal_pecah = explode("/", $date);
							$date_now=$tanggal_pecah[2].'-'.$tanggal_pecah[0].'-'.$tanggal_pecah[1];
							$date_convert = date_create($date_now);
							$day = date_format($date_convert,"l");
						}
		
						foreach($data_motorist as $data_motorist) {
						
						$target_call = $this->db->query("SELECT id_store FROM store WHERE motorist_code = '".$data_motorist->motorist_code."' AND distributor_code = '".$data_motorist->distributor_code."' AND day_visit = '".$day."' AND customer_status = 'active' AND frequency in ('W','".$status_minggu."') ")->num_rows();
						
						
						$persentasi_call = 0;
						$persentasi_extra_call = 0;
						$persentasi_effective_call = 0;
						$persentasi_extra_effective_call = 0;
						$persentasi_target_harian = 0;
						if($data_motorist->total_call>0)
						{
							if($target_call>0)
							{
							$persentasi_call = ($data_motorist->total_call * 100) / $target_call;
							$persentasi_call = number_format($persentasi_call, 0, '.', '');	
							}
							if($target_call>0)
							{
							$persentasi_extra_call = ($data_motorist->total_extra_call * 100) / $target_call;
							$persentasi_extra_call = number_format($persentasi_extra_call, 0, '.', '');	
							}
							
							if($target_call>0)
							{
							$persentasi_effective_call = ($data_motorist->total_effective_call * 100) / $target_call;
							$persentasi_effective_call = number_format($persentasi_effective_call, 0, '.', '');
							}
							if($data_motorist->target_harian>0)
							{
							$persentasi_target_harian = ($data_motorist->total_daily_sales * 100) / $data_motorist->target_harian;
							$persentasi_target_harian = number_format($persentasi_target_harian, 0, '.', '');
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
                        <td><?php echo $data_motorist->motorist_code; ?></td>
                        <td><?php echo $data_motorist->motorist_type; ?></td>
                        <td><?php echo $data_motorist->distributor_code; ?></td>
                        <td><?php echo $data_motorist->distributor_name; ?></td>
                        <td><?php echo $target_call; ?></th>
                        <td><?php echo $data_motorist->total_call; ?></th>
                        <td <?php if($persentasi_call<90){ ?> class="red" <?php } else if($persentasi_call>90){ ?> class="green_td" <?php } ?> ><?php echo $persentasi_call ?> %</td>
                        <td><?php echo $data_motorist->total_extra_call; ?></td>
                        <td><?php echo $persentasi_extra_call; ?>%</td>
                        <td><?php echo $data_motorist->total_effective_call; ?></td>
                         <td <?php if($persentasi_effective_call<85){ ?> class="red" <?php } else if($persentasi_effective_call>85){ ?> class="green_td" <?php } ?> ><?php echo $persentasi_effective_call; ?>%</td>
                        <td><?php echo $data_motorist->total_extra_effective_call; ?></td>
                        <td><?php echo $persentasi_extra_effective_call; ?>%</td>
                        <td><?php echo convert_price($data_motorist->target_harian); ?></td>
                        <td><a target="_blank" href="<?php echo base_url()."index.php/motorist/dailyStockMotoristTotal?id_motorist=".$data_motorist->id_motorist."&tanggal=".$date_now_stock; ?>"><?php echo convert_price($data_motorist->total_daily_sales);?></a></td>
                        <td <?php if($persentasi_target_harian<100){ ?> class="red" <?php } else if($persentasi_target_harian>100){ ?> class="green_td" <?php } ?>><?php echo $persentasi_target_harian?>%</td>
						<td><?php echo convert_price($data_motorist->total_daily_setoran);
						$selisih_setoran = $data_motorist->total_daily_setoran - $data_motorist->total_daily_sales;
						?></td>
                        <td <?php if($selisih_setoran<0){ ?> class="red" <?php } else if($selisih_setoran>0){ ?> class="orange" <?php } ?> ><?php echo convert_price($selisih_setoran) ?> </td>
                       
                   	    <td><a href="<?php echo base_url()."index.php/motorist/dailyCallStrike?id_motorist=".$data_motorist->id_motorist; ?>&&date=<?php echo $date; ?>">Daily Call Strike</a></td>
                        <td><a href="<?php echo base_url()."index.php/motorist/dailyStock/".$data_motorist->id_motorist; ?>?date=<?php echo $date; ?>">Daily Stock Motorist</a></td>
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
	   $("#date").datepicker({ dateFormat: "dd-mm-yy" }).val()
	   
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

