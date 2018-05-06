 <!-- HEADER -->
 <section class="content-header">
          <h1>
            STT Store
            <small>STT Store of E-tools</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="<?php echo BASE_URL(); ?>"><i class="fa fa-dashboard"></i>Home</a></li>
            <li><a href="<?php echo BASE_URL()."store/outletSTT"; ?>"><i class="fa fa-dashboard"></i>STT Store</a></li>
          </ol>
        </section>
  
  
   <!-- Content -->
   <section class="content">
          <div class="box sms box-default color-palette-box">
            <div class="box-header with-border">
              <h3 class="box-title"><i class="fa fa-table"></i> Table Store</h3>
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
			$year = isset($_GET['tahun']) ? $_GET['tahun'] : '';		  
			$search = isset($_GET['search']) ? $_GET['search'] : '';
			$store_name = isset($_GET['store_name']) ? $_GET['store_name'] : '';
			$motorist_code = isset($_GET['motorist_code']) ? $_GET['motorist_code'] : '';
			$regional = isset($_GET['regional']) ? $_GET['regional'] : '';
			if(isset($_GET['regional']))
			{$regional_implode = "'" . implode("','", $regional) . "'";;}
			else
			{$regional_implode = "";}
			
			
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
			
			
			$motorist_code = isset($_GET['motorist_code']) ? $_GET['motorist_code'] : '';
			$date = isset($_GET['date']) ? $_GET['date'] : '';
			
			
			function convert_price($price)
			{
				echo "Rp. ".number_format($price, 0 , '' , '.' );		
					}
			?>
            <div id="wrapper-console" class="clearfix">
                <div id="wrapper-search">
                             <form action="<?php echo base_url()."index.php/store/outletSTT" ?>" method="get">
                             <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                               
                                
                                 
                             
                                 <?php if($data_account[0]['user_type']=="Administrator"){ ?>
                                 <div class="select-filter">
                             	<select name="regional[]" id="select-regional" multiple="multiple" >
                              	<?php foreach($data_regional as $data_regional) {?>
                              	<option <?php if(isset($_GET['regional'])) {if(in_array($data_regional['regional_name'], $regional)) {?> selected="selected" <?php }} ?> value="<?php echo $data_regional['regional_name']; ?>"><?php echo $data_regional['regional_name']; ?></option>
                              	<?php } ?>
                             	</select>
                             	</div>
                                
                                
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
                                <?php } ?>
                                
                                <select name="tahun" id="tahun" style="float:left; width:300px;">
                                	<option value="">Choose year</option>
                                    <option <?php if($year==2016){ ?> selected="selected" <?php } ?> value="2016">2016</option>
                                    <option <?php if($year==2017){ ?> selected="selected" <?php } ?> value="2017">2017</option>
                                    <option <?php if($year==2018){ ?> selected="selected" <?php } ?> value="2018">2018</option>
                                </select>
                                
                                
                                <input type="text" id="store_name" name="store_name" placeholder="Search by Store Name" style="width:300px; clear:both; float:left;"   value="<?php echo $store_name; ?>" />
                                <input type="text" id="search" name="search" placeholder="Search by Store Code" style="width:300px; float:left;"  value="<?php echo $search; ?>" />
                                <input type="text" id="motorist_code" name="motorist_code" placeholder="Search by Motorist Code" style="width:300px; float:left;"  value="<?php echo $motorist_code; ?>" />
                                <input type="submit" id="submit"  value="Search" style=" float:left; margin-left:4px;"/>
                                <?php if($search!="" or $regional_implode!="" or $motorist_type_implode!="" or $motorist_code!='' or $distributor!='' or $date!='')
								{?>
                                <a href="<?php echo base_url()."/index.php/store/outletSTT" ?>" id="clear-search" style="float:left; padding:11.5px;">Clear Search</a>
                                <?php } ?>
                             </form>
                </div>
                <div id="wrapper-button" class="clearfix">
                	
                   
                     <a href="<?php echo base_url()."index.php/store/exportOutletSTT?search=".$search."&&store_name=".$store_name."&&motorist_type=".$motorist_type_implode."&&regional=".$regional_implode."&&distributor_code=".$distributor_implode."&&motorist_code=".$motorist_code."&&year=".$year; ?>" class="button blue-button">
                    	Export Store STT
                    </a>
                </div>
                </div>
            <div id="wrapper-table">
            <div id="wrapper-console" class="clearfix"> 
            <div class="grid_4 height400">             
           	<table id="myTable05" class="fancyTable table table-bordered table-hover">
                    <thead>
                      <tr>
                        <th><div class="mid">Customer Name</div></th>
                        <th><div class="mid">Customer Code</div></th>
                        <th><div class="mid">Distributor Name</div></th>
                        <th><div class="mid">Distributor Code</div></th>
                        <th><div class="mid">Motorist Code</div></th>
                        <th><div class="mid">Motorist Name</div></th>
                        <th><div class="mid">Day Visit</div></th>
                        <th><div class="mid">Frequency</div></th>
                        <?php 
						if($year=='')
						{
						 $year = date('Y');
						}
						 $months = array("January-01","February-02","March-03","April-04","May-05","June-06","July-07","August-08","September-09","October-10","November-11","December-12");
						 foreach($months as $month) {
							$data_month = explode('-',$month);
						    $bulan = $data_month[1];
					        $nama_bulan = $data_month[0];
							
							
						 ?>
                         <th><div class="mid"><?php echo $nama_bulan.' '.$year; ?></div></th>
                         <?php
						 
						 }
						?>
                        
                      </tr>
                    </thead>
             		<tbody>
                    <?php foreach($data_store as $data_store) {?>
                    <tr>
                      <td><div style="width:200px;"><?php echo $data_store->customer_name; ?></div></td>
                        <td><?php echo $data_store->customer_code; ?></td>
                        <td><?php echo $data_store->distributor_name; ?></td>
                        <td><?php echo $data_store->distributor_code; ?></td>
                        <td><?php echo $data_store->motorist_code ?></td>
                        <td><?php echo $data_store->motorist_name; ?></td>
                        <td><?php echo $data_store->day_visit; ?></td>
                        <td><?php echo $data_store->frequency; ?></td>
                        <?php
						foreach($months as $month) {
							$data_month = explode('-',$month);
						    $bulan = $data_month[1];
					        $nama_bulan = $data_month[0];
							
							$tanggal_bulan_awal = $year.'-'.$bulan.'-01 00:00:00';
							$tanggal_bulan_akhir = $year.'-'.$bulan.'-31 23:59:59';
			
							$select_mtd_sales = $this->db->query("SELECT SUM(total_order) as total_order FROM orders WHERE customer_code = '".$data_store->customer_code."' AND date BETWEEN '".$tanggal_bulan_awal."' AND '".$tanggal_bulan_akhir."' ")->result_array();
							if($select_mtd_sales[0]['total_order']=='')
							{$total_stt = 0;}
							else
							{$total_stt = $select_mtd_sales[0]['total_order'];}	
							
						 ?>
                         <td><div class="mid"><?php convert_price($total_stt); ?></div></td>
                         <?php
						 }
						?>
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
</script>
