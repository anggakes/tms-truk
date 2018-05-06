 <!-- HEADER -->
 <section class="content-header">
          <h1>
            Additional Store Motorist
            <small>Motorist of E-tools</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="<?php echo BASE_URL(); ?>"><i class="fa fa-dashboard"></i>Home</a></li>
            <li><a href="<?php echo BASE_URL()."swicthingMotoristStore"; ?>"><i class="fa fa-dashboard"></i>Additional Store Motorist</a></li>
          </ol>
        </section>
  
  
   <!-- Content -->
   <section class="content">
          <div class="box sms box-default color-palette-box">
            <div class="box-header with-border">
              <h3 class="box-title"><i class="fa fa-table"></i> Table Additional Store Motorist</h3>
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
                             <form action="<?php echo base_url()."index.php/motorist/swicthingMotoristStore" ?>" method="get">
                             <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
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
                                
                                 <select name="tahun" id="tahun">
                                	<option value="">Choose year</option>
                                    <option value="2016">2016</option>
                                </select>
                                <input type="text" id="search" name="search" placeholder="Search Motorist Code"  value="<?php echo $search; ?>" />
                                <input type="submit" id="submit"  value="Search"/>
                                <?php if($search!="" or $tahun!="" or $motorist_type_implode!="" or $tahun!="")
								{?>
                                <a href="<?php echo base_url()."index.php/motorist/swicthingMotoristStore" ?>" id="clear-search">Clear Search</a>
                                <?php } ?>
                             </form>
                </div>
                
                </div>
            <div id="wrapper-button" class="clearfix">
                	<a href="<?php echo base_url()."index.php/motorist/exportSwicthingMotoristStore?search=".$search."&&tahun=".$tahun."&&regional=".$regional_implode."&&motorist_type=".$motorist_type_implode; ?>" class="button orange-button">
                    	Export Switching Motorist
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
                        <th><div class="mid">Kode Motorist</div></th>
					    <th><div class="mid">Regional</div></th>
						<th><div class="mid">Area</div></th>
						<th><div class="long">Distributor Code</div></th>
                        <th><div class="long">Distributor Name</div></th>
                        <th><div class="mid">Target Outlet Switching</div></th>
                        
                        <th><div class="mid">Januari</div></th>
                        <th><div class="mid">Februari</div></th>
                        <th><div class="mid">Maret</div></th>
                        <th><div class="mid">April</div></th>
                        <th><div class="mid">Mei</div></th>
                        <th><div class="mid">Juni</div></th>
                        <th><div class="mid">Juli</div></th>
                        <th><div class="mid">Agustus</div></th>
                        <th><div class="mid">September</div></th>
                        <th><div class="mid">Oktober</div></th>
                        <th><div class="mid">November</div></th>
                        <th><div class="mid">Desember</div></th>
                        
                        
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
						<td><?php echo $data_motorist->distributor_code; ?></td>
                    	<td><?php echo $data_motorist->distributor_name; ?></td>
                        
                        <td>10</td>
                        <td <?php if($data_motorist->total_store_januari<10){?> class="red" <?php } else { ?> class="green" <?php } ?>><div class="mid" ><?php echo $data_motorist->total_store_januari; ?></div></td>
                        <td <?php if($data_motorist->total_store_februari<10){?> class="red" <?php } else { ?> class="green" <?php } ?>><div class="mid"><?php echo $data_motorist->total_store_februari; ?></div></td>
                        <td <?php if($data_motorist->total_store_maret<10){?> class="red" <?php } else { ?> class="green" <?php } ?>><div class="mid"><?php echo $data_motorist->total_store_maret; ?></div></td>
                        <td <?php if($data_motorist->total_store_april<10){?> class="red" <?php } else { ?> class="green" <?php } ?>><div class="mid"><?php echo $data_motorist->total_store_april; ?></div></td>
                        <td <?php if($data_motorist->total_store_mei<10){?> class="red" <?php } else { ?> class="green" <?php } ?>><div class="mid"><?php echo $data_motorist->total_store_mei; ?></div></td>
                        <td <?php if($data_motorist->total_store_juni<10){?> class="red" <?php } else { ?> class="green" <?php } ?>><div class="mid"><?php echo $data_motorist->total_store_juni; ?></div></td>
                        <td <?php if($data_motorist->total_store_juli<10){?> class="red" <?php } else { ?> class="green" <?php } ?>><div class="mid"><?php echo $data_motorist->total_store_juli; ?></div></td>
                        <td <?php if($data_motorist->total_store_agustus<10){?> class="red" <?php } else { ?> class="green" <?php } ?>><div class="mid"><?php echo $data_motorist->total_store_agustus; ?></div></td>
                        <td <?php if($data_motorist->total_store_september<10){?> class="red" <?php } else { ?> class="green" <?php } ?>><div class="mid"><?php echo $data_motorist->total_store_september; ?></div></td>
                        <td <?php if($data_motorist->total_store_oktober<10){?> class="red" <?php } else { ?> class="green" <?php } ?>><div class="mid"><?php echo $data_motorist->total_store_oktober; ?></div></td>
                        <td <?php if($data_motorist->total_store_november<10){?> class="red" <?php } else { ?> class="green" <?php } ?>><div class="mid"><?php echo $data_motorist->total_store_november; ?></div></td>
                        <td <?php if($data_motorist->total_store_desember<10){?> class="red" <?php } else { ?> class="green" <?php } ?>><div class="mid"><?php echo $data_motorist->total_store_desember; ?></div></td>
                        
                      
                    
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
</script>