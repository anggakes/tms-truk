 <!-- HEADER -->
 <section class="content-header">
          <h1>
            Switching Outlet Motorist
            <small>Motorist of E-tools</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="<?php echo BASE_URL(); ?>"><i class="fa fa-dashboard"></i>Home</a></li>
            <li><a href="<?php echo BASE_URL()."swicthingMotoristNoo"; ?>"><i class="fa fa-dashboard"></i>Switching Outlet Motorist</a></li>
          </ol>
        </section>
  
  
   <!-- Content -->
   <section class="content">
          <div class="box sms box-default color-palette-box">
            <div class="box-header with-border">
              <h3 class="box-title"><i class="fa fa-table"></i> Table Siwtching Store Motorist</h3>
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
			
			
			$motorist_type = isset($_GET['motorist_type']) ? $_GET['motorist_type'] : '';
			if(isset($_GET['motorist_type']))
			{$motorist_type_implode = implode(",",$motorist_type);}
			else
			{$motorist_type_implode = "";}
		
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
			
			$tahun = isset($_GET['tahun']) ? $_GET['tahun'] : '';
			if($tahun=="")
			{
				$tahun = date('Y');
			}
			function convert_price($price)
			{
				echo "Rp. ".number_format($price, 0 , '' , '.' );		
					}
			?>
            
            
            <div id="wrapper-console" class="clearfix">
                <div id="wrapper-search">
                             <form action="<?php echo base_url()."index.php/motorist/swicthingMotoristNoo" ?>" method="get">
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
								
								
								<?php if($data_account[0]['user_type']=="Administrator" or $data_account[0]['user_type']=="Regional"){ ?>
                             <div class="select-filter">
                             <select name="distributor[]" id="select-distributor" multiple="multiple" >
                              <?php foreach($data_distributor as $data_distributor) {?>
                              <option <?php if(isset($_GET['distributor'])) {if(in_array($data_distributor['distributor_code'], $distributor)) {?> selected="selected" <?php }} ?> value="<?php echo $data_distributor['distributor_code']; ?>" ><?php echo $data_distributor['distributor_name']; ?></option>
                              <?php } ?>
                             </select>
                             </div>
                             <?php } ?>
							 
                                 <select name="tahun" id="tahun">
                                	<option value="">Choose year</option>
                                    <option <?php if($tahun=='2016'){ ?> selected="selected" <?php } ?> value="2016">2016</option>
									<option <?php if($tahun=='2017'){ ?> selected="selected" <?php } ?> value="2017">2017</option>
                                </select>
                                <input type="text" id="search" name="search" placeholder="Search Motorist Code"  value="<?php echo $search; ?>" />
                                <input type="submit" id="submit"  value="Search"/>
                                <?php if($search!="" or $tahun!="" or $motorist_type_implode!="" or $tahun!="")
								{?>
                                <a href="<?php echo base_url()."index.php/motorist/swicthingMotoristNoo" ?>" id="clear-search">Clear Search</a>
                                <?php } ?>
								
								
                             </form>
                </div>
                
                    <div id="wrapper-button" class="clearfix">
                	<a href="<?php echo base_url()."index.php/motorist/exportSwicthingMotoristNoo?search=".$search."&&tahun=".$tahun."&&regional=".$regional_implode."&&area=".$area_implode."&&distributor=".$distributor_implode; ?>" class="button orange-button">
                    	Export Switching Motorist
                    </a>
                </div>
                </div>
        
           
            
            
              
                
            <div id="wrapper-console" class="clearfix">
             
             <div class="grid_4 height400">             
           	<table id="myTable05" class="fancyTable table-bordered table-hover">
                    <thead>
                      <tr>
                        <th><div class="mid">Nama Motorist</div></th>
                        <th><div class="mid">Kode Motorist</div></th>
					    <th><div class="mid">Regional</div></th>
						<th><div class="mid">Area</div></th>
						<th><div class="long">Distributor</div></th>
                  
                        
                        <th><div class="mid">Target Outlet Switching</div></th>
                        
                        <th><div class="mid">Januari <?php echo $tahun; ?></div></th>
                        <th><div class="mid">Februari <?php echo $tahun; ?></div></th>
                        <th><div class="mid">Maret <?php echo $tahun; ?></div></th>
                        <th><div class="mid">April <?php echo $tahun; ?></div></th>
                        <th><div class="mid">Mei <?php echo $tahun; ?></div></th>
                        <th><div class="mid">Juni <?php echo $tahun; ?></div></th>
                        <th><div class="mid">Juli <?php echo $tahun; ?></div></th>
                        <th><div class="mid">Agustus <?php echo $tahun; ?></div></th>
                        <th><div class="mid">September <?php echo $tahun; ?></div></th>
                        <th><div class="mid">Oktober <?php echo $tahun; ?></div></th>
                        <th><div class="mid">November <?php echo $tahun; ?></div></th>
                        <th><div class="mid">Desember <?php echo $tahun; ?></div></th>
                        
                        
                      </tr>
                    </thead>
             		<tbody>
                    
                    <?php foreach($data_motorist as $data_motorist) {
					
					?>
                    
                    
                    <tr>
	                    <td><div style="width:200px;"><?php echo $data_motorist->motorist_name; ?>-<?php echo $data_motorist->motorist_code; ?></div></td>
						 <td><?php echo $data_motorist->motorist_code; ?></td>
						<td><?php echo $data_motorist->regional; ?></td>
						<td><?php echo $data_motorist->area; ?></td>
						<td><?php echo $data_motorist->distributor_code.'-'.$data_motorist->distributor_name; ?></td>
                    	
                       
                        <td>10</td>
                        <td <?php if($data_motorist->total_store_januari<10){?> class="red" <?php } else { ?> class="green" <?php } ?>><div class="mid" ><?php if($data_motorist->total_store_januari<=0){echo $data_motorist->total_store_januari;}else{?> <a style="color:#FFF" target="_blank" href="<?php echo base_url()."index.php/store/switching?id_motorist=".$data_motorist->id_motorist."&&bulan=01"."&&tahun=".$tahun; ?>"> <?php echo $data_motorist->total_store_januari; ?> </a> <?php } ?></div></td>
                        <td <?php if($data_motorist->total_store_februari<10){?> class="red" <?php } else { ?> class="green" <?php } ?>><div class="mid"><?php if($data_motorist->total_store_februari<=0){echo $data_motorist->total_store_februari;}else{?> <a style="color:#FFF" target="_blank" href="<?php echo base_url()."index.php/store/switching?id_motorist=".$data_motorist->id_motorist."&&bulan=02"."&&tahun=".$tahun; ?>"> <?php echo $data_motorist->total_store_februari; ?> </a> <?php } ?></div></td>
                        <td <?php if($data_motorist->total_store_maret<10){?> class="red" <?php } else { ?> class="green" <?php } ?>><div class="mid"><?php if($data_motorist->total_store_maret<=0){echo $data_motorist->total_store_maret;}else{?> <a style="color:#FFF" target="_blank" href="<?php echo base_url()."index.php/store/switching?id_motorist=".$data_motorist->id_motorist."&&bulan=03"."&&tahun=".$tahun; ?>"> <?php echo $data_motorist->total_store_maret; ?> </a> <?php } ?></div></td>
                        <td <?php if($data_motorist->total_store_april<10){?> class="red" <?php } else { ?> class="green" <?php } ?>><div class="mid"><?php if($data_motorist->total_store_april<=0){echo $data_motorist->total_store_april;}else{?> <a style="color:#FFF" target="_blank" href="<?php echo base_url()."index.php/store/switching?id_motorist=".$data_motorist->id_motorist."&&bulan=04"."&&tahun=".$tahun; ?>"> <?php echo $data_motorist->total_store_april; ?> </a> <?php } ?></div></td>
                        <td <?php if($data_motorist->total_store_mei<10){?> class="red" <?php } else { ?> class="green" <?php } ?>><div class="mid"><?php if($data_motorist->total_store_mei<=0){echo $data_motorist->total_store_mei;}else{?> <a style="color:#FFF" target="_blank" href="<?php echo base_url()."index.php/store/switching?id_motorist=".$data_motorist->id_motorist."&&bulan=05"."&&tahun=".$tahun; ?>"> <?php echo $data_motorist->total_store_mei; ?> </a> <?php } ?></div></td>
                        <td <?php if($data_motorist->total_store_juni<10){?> class="red" <?php } else { ?> class="green" <?php } ?>><div class="mid"><?php if($data_motorist->total_store_juni<=0){echo $data_motorist->total_store_juni;}else{?> <a style="color:#FFF" target="_blank" href="<?php echo base_url()."index.php/store/switching?id_motorist=".$data_motorist->id_motorist."&&bulan=06"."&&tahun=".$tahun; ?>"> <?php echo $data_motorist->total_store_juni; ?> </a> <?php } ?></div></td>
                        <td <?php if($data_motorist->total_store_juli<10){?> class="red" <?php } else { ?> class="green" <?php } ?>><div class="mid"><?php if($data_motorist->total_store_juli<=0){echo $data_motorist->total_store_juli;}else{?> <a style="color:#FFF" target="_blank" href="<?php echo base_url()."index.php/store/switching?id_motorist=".$data_motorist->id_motorist."&&bulan=07"."&&tahun=".$tahun; ?>"> <?php echo $data_motorist->total_store_juli; ?> </a> <?php } ?></div></td>
                        <td <?php if($data_motorist->total_store_agustus<10){?> class="red" <?php } else { ?> class="green" <?php } ?>><div class="mid"><?php if($data_motorist->total_store_agustus<=0){echo $data_motorist->total_store_agustus;}else{?> <a style="color:#FFF" target="_blank" href="<?php echo base_url()."index.php/store/switching?id_motorist=".$data_motorist->id_motorist."&&bulan=08"."&&tahun=".$tahun; ?>"> <?php echo $data_motorist->total_store_agustus; ?> </a> <?php } ?></div></td>
                        <td <?php if($data_motorist->total_store_september<10){?> class="red" <?php } else { ?> class="green" <?php } ?>><div class="mid"><?php if($data_motorist->total_store_september<=0){echo $data_motorist->total_store_september;}else{?> <a style="color:#FFF" target="_blank" href="<?php echo base_url()."index.php/store/switching?id_motorist=".$data_motorist->id_motorist."&&bulan=09"."&&tahun=".$tahun; ?>"> <?php echo $data_motorist->total_store_september; ?> </a> <?php } ?></div></td>
                        <td <?php if($data_motorist->total_store_oktober<10){?> class="red" <?php } else { ?> class="green" <?php } ?>><div class="mid"><?php if($data_motorist->total_store_oktober<=0){echo $data_motorist->total_store_oktober;}else{?> <a style="color:#FFF" target="_blank" href="<?php echo base_url()."index.php/store/switching?id_motorist=".$data_motorist->id_motorist."&&bulan=10"."&&tahun=".$tahun; ?>"> <?php echo $data_motorist->total_store_oktober; ?> </a> <?php } ?></div></td>
                        <td <?php if($data_motorist->total_store_november<10){?> class="red" <?php } else { ?> class="green" <?php } ?>><div class="mid"><?php if($data_motorist->total_store_november<=0){echo $data_motorist->total_store_november;}else{?> <a style="color:#FFF" target="_blank" href="<?php echo base_url()."index.php/store/switching?id_motorist=".$data_motorist->id_motorist."&&bulan=11"."&&tahun=".$tahun; ?>"> <?php echo $data_motorist->total_store_november; ?> </a> <?php } ?></div></td>
                        <td <?php if($data_motorist->total_store_desember<10){?> class="red" <?php } else { ?> class="green" <?php } ?>><div class="mid"><?php if($data_motorist->total_store_desember<=0){echo $data_motorist->total_store_desember;}else{?> <a style="color:#FFF" target="_blank" href="<?php echo base_url()."index.php/store/switching?id_motorist=".$data_motorist->id_motorist."&&bulan=12"."&&tahun=".$tahun; ?>"> <?php echo $data_motorist->total_store_desember; ?> </a> <?php } ?></div></td>
                        
                      
                    
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