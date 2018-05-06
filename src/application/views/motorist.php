 <!-- HEADER -->
 <section class="content-header">
          <h1>
            Motorist
            <small>Motorist of E-tools</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="<?php echo BASE_URL(); ?>"><i class="fa fa-dashboard"></i>Home</a></li>
            <li><a href="<?php echo BASE_URL()."motorist"; ?>"><i class="fa fa-dashboard"></i>Motorist</a></li>
          </ol>
        </section>
  
  
   <!-- Content -->
   <section class="content">
          <div class="box sms box-default color-palette-box">
            <div class="box-header with-border">
              <h3 class="box-title"><i class="fa fa-table"></i> Table Motorist</h3>
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
			
			
			function convert_price($price)
			{
				echo "Rp. ".number_format($price, 0 , '' , '.' );		
					}
			?>
            
            <div id="wrapper-console" class="clearfix">
                <div id="wrapper-search">
                             <form action="<?php echo base_url()."index.php/motorist" ?>" method="get">
                             <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                                <input type="text" id="search" name="search" placeholder="Search by motorist code"  value="<?php echo $search; ?>" />
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
                                <?php } ?>
                                
                                <input type="submit" id="submit"  value="Search"/>
                                <?php if($search!="" or $regional_implode!="" or $motorist_type_implode!="")
								{?>
                                <a href="<?php echo base_url()."index.php/motorist" ?>" id="clear-search">Clear Search</a>
                                <?php } ?>
                             </form>
                </div>
                <div id="wrapper-button" class="clearfix">
                	<a href="<?php echo base_url()."index.php/motorist/exportMotorist?search=".$search."&&regional=".$regional_implode."&&area=".$area_implode."&&distributor=".$distributor_implode."&&motorist_type=".$motorist_type_implode; ?>" class="button orange-button">
                    	Export Motorist
                    </a>
                    
                    <a href="<?php echo base_url()."index.php/motorist/addMotorist" ?>" class="button green-button">
                    	Add Motorist
                    </a>
                    
                    <a href="<?php echo base_url()."index.php/motorist/importMotorist" ?>" class="button blue-button">
                    	Import Motorist
                    </a>
                    
                    <a target="_blank" href="<?php echo base_url()."maps/example/maps.php?distributor_code=".$data_account[0]['code']."&&role=".$data_account[0]['user_type']."&&token=22293848749484798" ?>" class="button blue-button">
                    	View All Map
                    </a>
                </div>
                </div>
               
            
            <div id="wrapper-console" class="clearfix">     
             <div class="grid_4 height400">        
           	<table id="myTable04" class="fancyTable table table-bordered table-hover">
                    <thead>
                      <tr>
                        <th>ID Motorist</th>
                        <th>Motorist code</th>
                        <th>Motorist Name</th>
                        <th>Distributor Code</th>
                        <th>Distributor Name</th>
                        <th>Motorist Type</th>
                        <th>Daily Target Sales</th>
                        <th>Monthly Target Sales</th>
                        <th>Lokasi Toko</th>
                        <th>Action</th>
                      </tr>
                    </thead>
             		<tbody>
                    
                    <?php foreach($data_motorist as $data_motorist) {?>
                    <tr>
                    	<td><?php echo $data_motorist->id_motorist; ?></td>
                        <td><?php echo $data_motorist->motorist_code; ?></td>
                        <td><?php echo $data_motorist->motorist_name; ?></td>
                        <td><?php echo $data_motorist->distributor_code; ?></td>
                        <td><?php echo $data_motorist->distributor_name; ?></td>
                        <td><?php echo $data_motorist->motorist_type; ?></td>
                        <td><?php echo convert_price($data_motorist->target_harian); ?></td>
                        <td><?php echo convert_price($data_motorist->target_bulanan); ?></td>
                        <td><a href="<?php echo base_url()."index.php/motorist/MotoristMap?id_motorist=".$data_motorist->id_motorist ?>">Lihat Lokasi Toko</a></td>
                        <td><a href="<?php echo base_url()."index.php/motorist/editMotorist/".$data_motorist->id_motorist ?>">Edit</a></td>
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
