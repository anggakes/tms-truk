 <!-- HEADER -->
	<section class="content-header">
          <h1>
            Summary Stock Motorist
            <small>Stock Motorist of E-tools</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="<?php echo BASE_URL(); ?>"><i class="fa fa-dashboard"></i>Home</a></li>
            <li><a href="<?php echo BASE_URL()."Stock"; ?>"><i class="fa fa-dashboard"></i>Stock</a></li>
          </ol>
        </section>
  
  
   <!-- Content -->
   <section class="content">

          <div class="box sms box-default color-palette-box">
            <div class="box-header with-border">
              <h3 class="box-title"><i class="fa fa-table"></i> Table Daily Stock</h3>
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
                             <form action="<?php echo base_url()."index.php/stock/summaryStock" ?>" method="get">
                             <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
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
                               
                                <input type="text" id="search" name="search" placeholder="Search by Motorist Code"  value="<?php echo $search; ?>" />
                                <input type="submit" id="submit"  value="Search"/>
                                <?php if($search!=""  or $regional_implode!="" or $motorist_type_implode!="" or $year!="" or $bulan!="")
								{?>
                                <a href="<?php echo base_url()."index.php/stock/summaryStock" ?>" id="clear-search">Clear Search</a>
                                <?php } ?>
                             </form>
               </div>
                <div id="wrapper-button" class="clearfix">
                	<a href="<?php echo base_url()."index.php/stock/exportsummaryStock?search=".$search."&&regional=".$regional_implode."&&distributor=".$distributor_implode."&&area=".$area_implode."&&motorist_type=".$motorist_type_implode."&&bulan=".$bulan."&&year=".$year; ?>" class="button orange-button">
                    	Export Motorist Stock
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
				
				$tanggal_bulan_awal = $year.'-'.$month_with_null."-01 00:00:00";
				$tanggal_bulan_akhir = $year.'-'.$month_with_null."-31 23:59:59";
					
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
				
			
			 

			?>
            
            
            <div id="wrapper-console" class="clearfix"> 
             <div class="grid_4 height400">                 
           	<table id="myTable05" class="fancyTable  table table-bordered table-hover">
                    <thead>
                      <tr>
                        <th><div class="mid">Nama Motorist</div></th>
                        <th><div class="mid">Regional</div></th>
                        <th><div class="mid">Area</div></th>
                        <th><div class="mid">Kode Distributor</div></th>
                        <th><div class="mid">Nama Distributor</div></th>
                        <th><div class="mid">Tipe Motorist</div></th>
                        <th><div class="mid">Kode Motorist</div></th>
                        <th><div class="mid">Hari Kerja</div></th>
                        <th><div class="mid">Total SKU</div></th>
                        <th><div class="mid">Total Stock Quantity</div></th>
                        <th><div class="mid">Total Harga Stock (Value)</div></th>
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
                    <?php foreach($data_stock as $data_stock) {?>
                    <tr>
                    	<td><div style="width:200px;"><?php echo $data_stock->motorist_name; ?>-<?php echo $data_stock->motorist_code; ?></div></td>
                    	<td><?php echo $data_stock->regional; ?></td>
                        <td><?php echo $data_stock->area; ?></td>
                        <td><?php echo $data_stock->distributor_code; ?></td>
                        <td><?php echo $data_stock->distributor_name; ?></td>
                        <td><?php echo $data_stock->motorist_type; ?></td>
                        <td><?php echo $data_stock->motorist_code; ?></td>
                        <td><?php echo $hari_kerja; ?></td>
                        <td><?php
						
						$total_sku = $this->db->query("SELECT * FROM stock WHERE id_motorist = '".$data_stock->id_motorist."' AND date between '".$year."-".$month_with_null."-01 00:00:00' AND '".$year."-".$month_with_null."-31 00:00:00' GROUP BY id_product")->num_rows();
					    echo $total_sku;
						?></td>
                        <td><?php echo $data_stock->total_stock_all; ?></td>
                        <td>
						<?php 
								
									$this->db->from("stock");
							 		$this->db->where("id_motorist = '".$data_stock->id_motorist."' ");	
									$this->db->where("date between '".$tanggal_bulan_awal."' AND '".$tanggal_bulan_akhir."'");		
									$query = $this->db->get()->result_array();
									$total_price_day = $this->db->query("SELECT * FROM stock INNER JOIN product on product.id_product =  stock.id_product  WHERE stock.id_motorist = '".$data_stock->id_motorist."' AND stock.date between '".$tanggal_bulan_awal."' AND '".$tanggal_bulan_akhir."'")->result();
									$total_rupiah_all = 0;
									foreach($total_price_day as $total_price_day) {
									
									$total_rupiah = $total_price_day->stock * $total_price_day->price_pcs; 
									$total_rupiah_all = $total_rupiah + $total_rupiah_all;
									}
									
									convert_price($total_rupiah_all);
						
						 ?>
                        
                        
                        </td>
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
								
									$this->db->from("stock");
							 		$this->db->where("id_motorist = '".$data_stock->id_motorist."' ");	
									$this->db->where("date LIKE '%".$year.'-'.$month_with_null.'-'.sprintf('%02d', $i)."%'");		
									$query = $this->db->get()->result_array();
									
									$total_sku_day = $this->db->query("SELECT * FROM stock WHERE id_motorist = '".$data_stock->id_motorist."' AND date LIKE '%".$year.'-'.$month_with_null.'-'.sprintf('%02d', $i)."%'")->num_rows();
									
									$total_price_day = $this->db->query("SELECT * FROM stock INNER JOIN product on product.id_product =  stock.id_product  WHERE stock.id_motorist = '".$data_stock->id_motorist."' AND stock.date LIKE '%".$year.'-'.$month_with_null.'-'.sprintf('%02d', $i)."%'")->result();
									$total_rupiah_all = 0;
									foreach($total_price_day as $total_price_day) {
									
									$total_rupiah = $total_price_day->stock * $total_price_day->price_pcs; 
									$total_rupiah_all = $total_rupiah + $total_rupiah_all;
									}
								
									
									if (empty($query))
									{
										echo "<td class='kosong'>Tidak Isi Stock</td>";
									}
									else
									{
										echo "<td  class='isi'><a target='_new' href='".base_url()."index.php/motorist/dailyStock/".$data_stock->id_motorist."/?date=".$month_with_null.'/'.sprintf('%02d', $i).'/'.$year."'>".$total_sku_day." SKU | Rp. ".number_format($total_rupiah_all, 0 , '' , '.' )."</a></td>";
									} 
									
							
								
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
