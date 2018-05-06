<!-- HEADER -->
<section class="content-header">
          <h1>
            Journey Motorist
            <small>Motorist of E-tools</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="<?php echo BASE_URL(); ?>"><i class="fa fa-dashboard"></i>Home</a></li>
            <li><a href="<?php echo BASE_URL()."journeyPlanMotorist"; ?>"><i class="fa fa-dashboard"></i>Journey Motorist</a></li>
          </ol>
        </section>
  
  
   <!-- Content -->
   <section class="content">
          <div class="box sms box-default color-palette-box">
            <div class="box-header with-border">
              <h3 class="box-title"><i class="fa fa-table"></i> Table Journey Plan Motorist</h3>
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
                             <form action="<?php echo base_url()."index.php/motorist/journeyPlanMotorist" ?>" method="get">
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
                                
                                
                                
                                <input type="text" id="search" name="search" placeholder="Search Motorist Code"  value="<?php echo $search; ?>" />
                                <input type="submit" id="submit"  value="Search"/>
                                <?php if($search!="" or $regional_implode!="" or $motorist_type_implode!="")
								{?>
                                <a href="<?php echo base_url()."index.php/motorist/dailySummaryMotorist" ?>" id="clear-search">Clear Search</a>
                                <?php } ?>
                             </form>
                 </div>
                <div id="wrapper-button" class="clearfix">
                	<a href="<?php echo base_url()."index.php/motorist/exportJourneyPlanMotorist?search=".$search."&&area=".$area_implode."&&distributor=".$distributor_implode."&&regional=".$regional_implode."&&motorist_type=".$motorist_type_implode; ?>" class="button orange-button">
                    	Export Journey Plant Motorist Motorist
                    </a>
                    
                </div>
                </div>
               
            <div id="wrapper-console" class="clearfix"> 
             <div class="grid_4 height400">  
           	<table id="myTable06"  class="fancyTable table-bordered table-hover">
  <thead>
  <tr>
    <th width="4%" style="background:#09F; text-align:center; padding:0 !important;" rowspan="2" scope="col">Motorist</th>
    <th width="4%" style="background:#09F; text-align:center; padding:0 !important;"  rowspan="2" scope="col">Motorist Type</th>
    <th width="4%" style="background:#09F; text-align:center; padding:0 !important;"  rowspan="2" scope="col">Distributor Code</th>
    <th width="4%" style="background:#09F; text-align:center; padding:0 !important; "  rowspan="2" scope="col">Distributor Name</th>
    <th colspan="5" style="background:#09F; text-align:center; padding:0 !important;"  scope="col">Monday
    <div class="clearfix">
   	<div style="width:20%; float:left;">f1
    </div>
    <div style="width:20%; float:left;">f2
    </div>
    <div style="width:20%; float:left;">W
    </div>
    <div style="width:20%; float:left;">F1 + W
    </div>
    <div style="width:20%; float:left;">F2 + W
    </div>
    </div>
    </th>
    <th colspan="5" style="background:#09F; text-align:center"  scope="col">Tuesday
    <div class="clearfix">
    <div class="clearfix">
   	<div style="width:20%; float:left;">f1
    </div>
    <div style="width:20%; float:left;">f2
    </div>
    <div style="width:20%; float:left;">W
    </div>
    <div style="width:20%; float:left;">F1 + W
    </div>
    <div style="width:20%; float:left;">F2 + W
    </div>
    </div>
    </div>
    </th>
    <th colspan="5" style="background:#09F; text-align:center"  scope="col">Wednesday
    <div class="clearfix">
    <div class="clearfix">
   	<div style="width:20%; float:left;">f1
    </div>
    <div style="width:20%; float:left;">f2
    </div>
    <div style="width:20%; float:left;">W
    </div>
    <div style="width:20%; float:left;">F1 + W
    </div>
    <div style="width:20%; float:left;">F2 + W
    </div>
    </div>
    </div>
    </th>
    <th colspan="5" style="background:#09F; text-align:center" scope="col">Thursday
    <div class="clearfix">
    <div class="clearfix">
   	<div style="width:20%; float:left;">f1
    </div>
    <div style="width:20%; float:left;">f2
    </div>
    <div style="width:20%; float:left;">W
    </div>
    <div style="width:20%; float:left;">F1 + W
    </div>
    <div style="width:20%; float:left;">F2 + W
    </div>
    </div>
    </div>
    </th>
    <th colspan="5" style="background:#09F; text-align:center"  scope="col">Friday
    <div class="clearfix">
    <div class="clearfix">
   	<div style="width:20%; float:left;">f1
    </div>
    <div style="width:20%; float:left;">f2
    </div>
    <div style="width:20%; float:left;">W
    </div>
    <div style="width:20%; float:left;">F1 + W
    </div>
    <div style="width:20%; float:left;">F2 + W
    </div>
    </div>
    </div>
    </th>
    <th colspan="5" style="background:#09F; text-align:center"  scope="col">Saturday
    <div class="clearfix">
    <div class="clearfix">
   	<div style="width:20%; float:left;">f1
    </div>
    <div style="width:20%; float:left;">f2
    </div>
    <div style="width:20%; float:left;">W
    </div>
    <div style="width:20%; float:left;">F1 + W
    </div>
    <div style="width:20%; float:left;">F2 + W
    </div>
    </div>
    </div>
    </th>
  </tr>
  
  </thead>
  <tbody class="journey-plan">
   <?php foreach($data_motorist as $data_motorist) {
						
					?>
                    
  <tr>
    <td><?php echo $data_motorist->motorist_code; ?>-<?php echo $data_motorist->motorist_name; ?></td>
    <td><?php echo $data_motorist->motorist_type; ?></td>
    <td><?php echo $data_motorist->distributor_code; ?></td>
    <td><?php echo $data_motorist->distributor_name; ?></td>
    
    <td style="text-align:center;"><a target="_blank" href="<?php echo BASE_URL()."index.php/motorist/storeJourney?motorist_code=".$data_motorist->motorist_code."&distributor_code=".$data_motorist->distributor_code."&day_visit=monday&frequently='f1'"?>" ><?php echo $data_motorist->f1_monday; ?></a></td>
    <td style="text-align:center;"><a target="_blank" href="<?php echo BASE_URL()."index.php/motorist/storeJourney?motorist_code=".$data_motorist->motorist_code."&distributor_code=".$data_motorist->distributor_code."&day_visit=monday&frequently='f2'"?>" ><?php echo $data_motorist->f2_monday; ?></a></td>
    <td style="text-align:center;"><a target="_blank" href="<?php echo BASE_URL()."index.php/motorist/storeJourney?motorist_code=".$data_motorist->motorist_code."&distributor_code=".$data_motorist->distributor_code."&day_visit=monday&frequently='w'"?>" ><?php echo $data_motorist->w_monday; ?></a></td>
    <td style="text-align:center;" <?php $total_monday_1 = $data_motorist->f1_monday+$data_motorist->w_monday; if($total_monday_1<30){?> class="red" <?php } ?>><a target="_blank" href="<?php echo BASE_URL()."index.php/motorist/storeJourney?motorist_code=".$data_motorist->motorist_code."&distributor_code=".$data_motorist->distributor_code."&day_visit=monday&frequently='w','f1'"?>" ><?php echo $total_monday_1;  ?></a></td>
    <td style="text-align:center;" <?php $total_monday_2 = $data_motorist->f2_monday+$data_motorist->w_monday; if($total_monday_2<30){?> class="red" <?php } ?> ><a target="_blank" href="<?php echo BASE_URL()."index.php/motorist/storeJourney?motorist_code=".$data_motorist->motorist_code."&distributor_code=".$data_motorist->distributor_code."&day_visit=monday&frequently='w','f2'"?>" ><?php echo $total_monday_2; ?></a></td>
    <td style="text-align:center;"><a target="_blank" href="<?php echo BASE_URL()."index.php/motorist/storeJourney?motorist_code=".$data_motorist->motorist_code."&distributor_code=".$data_motorist->distributor_code."&day_visit=tuesday&frequently='f1'"?>" ><?php echo $data_motorist->f1_tuesday; ?></a></td>
    <td style="text-align:center;"><a target="_blank" href="<?php echo BASE_URL()."index.php/motorist/storeJourney?motorist_code=".$data_motorist->motorist_code."&distributor_code=".$data_motorist->distributor_code."&day_visit=tuesday&frequently='f2'"?>" ><?php echo $data_motorist->f2_tuesday; ?></a></td>
    <td style="text-align:center;"><a target="_blank" href="<?php echo BASE_URL()."index.php/motorist/storeJourney?motorist_code=".$data_motorist->motorist_code."&distributor_code=".$data_motorist->distributor_code."&day_visit=tuesday&frequently='w'"?>" ><?php echo $data_motorist->w_tuesday; ?></a></td>
    <td style="text-align:center;" <?php $total_tuesday_1 = $data_motorist->f1_tuesday+$data_motorist->w_tuesday; if($total_tuesday_1<30){?> class="red" <?php } ?>><a target="_blank" href="<?php echo BASE_URL()."index.php/motorist/storeJourney?motorist_code=".$data_motorist->motorist_code."&distributor_code=".$data_motorist->distributor_code."&day_visit=tuesday&frequently='w','f1'"?>" ><?php echo $total_tuesday_1;  ?></a></td>
    <td style="text-align:center;" <?php $total_tuesday_2 = $data_motorist->f2_tuesday+$data_motorist->w_tuesday; if($total_tuesday_2<30){?> class="red" <?php } ?>><a target="_blank" href="<?php echo BASE_URL()."index.php/motorist/storeJourney?motorist_code=".$data_motorist->motorist_code."&distributor_code=".$data_motorist->distributor_code."&day_visit=tuesday&frequently='w','f2'"?>" ><?php echo $total_tuesday_2;   ?></a></td>
    <td style="text-align:center;"><a target="_blank" href="<?php echo BASE_URL()."index.php/motorist/storeJourney?motorist_code=".$data_motorist->motorist_code."&distributor_code=".$data_motorist->distributor_code."&day_visit=wednesday&frequently='f1'"?>" ><?php echo $data_motorist->f1_wednesday; ?></a></td>
    <td style="text-align:center;"><a target="_blank" href="<?php echo BASE_URL()."index.php/motorist/storeJourney?motorist_code=".$data_motorist->motorist_code."&distributor_code=".$data_motorist->distributor_code."&day_visit=wednesday&frequently='f2'"?>" ><?php echo $data_motorist->f2_wednesday; ?></a></td>
    <td style="text-align:center;"><a target="_blank" href="<?php echo BASE_URL()."index.php/motorist/storeJourney?motorist_code=".$data_motorist->motorist_code."&distributor_code=".$data_motorist->distributor_code."&day_visit=wednesday&frequently='w'"?>" ><?php echo $data_motorist->w_wednesday; ?></a></td>
    <td style="text-align:center;" <?php $total_monday_1 = $data_motorist->f1_wednesday+$data_motorist->w_wednesday; if($total_monday_1<30){?> class="red" <?php } ?> ><a target="_blank" href="<?php echo BASE_URL()."index.php/motorist/storeJourney?motorist_code=".$data_motorist->motorist_code."&distributor_code=".$data_motorist->distributor_code."&day_visit=wednesday&frequently='w','f1'"?>" ><?php echo $total_monday_1; ?></a></td>
    <td style="text-align:center;" <?php $total_monday_2 = $data_motorist->f2_wednesday+$data_motorist->w_wednesday; if($total_monday_2<30){?> class="red" <?php } ?> ><a target="_blank" href="<?php echo BASE_URL()."index.php/motorist/storeJourney?motorist_code=".$data_motorist->motorist_code."&distributor_code=".$data_motorist->distributor_code."&day_visit=wednesday&frequently='w','f2'"?>" ><?php echo $total_monday_2;   ?></a></td>
    <td style="text-align:center;"><a target="_blank" href="<?php echo BASE_URL()."index.php/motorist/storeJourney?motorist_code=".$data_motorist->motorist_code."&distributor_code=".$data_motorist->distributor_code."&day_visit=thursday&frequently='f1'"?>" ><?php echo $data_motorist->f1_thursday; ?></a></td>
    <td style="text-align:center;"><a target="_blank" href="<?php echo BASE_URL()."index.php/motorist/storeJourney?motorist_code=".$data_motorist->motorist_code."&distributor_code=".$data_motorist->distributor_code."&day_visit=thursday&frequently='f2'"?>" ><?php echo $data_motorist->f2_thursday; ?></a></td>
    <td style="text-align:center;"><a target="_blank" href="<?php echo BASE_URL()."index.php/motorist/storeJourney?motorist_code=".$data_motorist->motorist_code."&distributor_code=".$data_motorist->distributor_code."&day_visit=thursday&frequently='w'"?>" ><?php echo $data_motorist->w_thursday; ?></a></td>
    <td style="text-align:center;" <?php $total_monday_1 = $data_motorist->f1_thursday+$data_motorist->w_thursday; if($total_monday_1<30){?> class="red" <?php } ?> ><a target="_blank" href="<?php echo BASE_URL()."index.php/motorist/storeJourney?motorist_code=".$data_motorist->motorist_code."&distributor_code=".$data_motorist->distributor_code."&day_visit=thursday&frequently='w','f1'"?>" ><?php echo $total_monday_1;   ?></a></td>
    <td style="text-align:center;" <?php $total_monday_2 = $data_motorist->f2_thursday+$data_motorist->w_thursday; if($total_monday_2<30){?> class="red" <?php } ?>><a target="_blank" href="<?php echo BASE_URL()."index.php/motorist/storeJourney?motorist_code=".$data_motorist->motorist_code."&distributor_code=".$data_motorist->distributor_code."&day_visit=thursday&frequently='w','f2'"?>" ><?php echo $total_monday_2;  ?></a></td>
    <td style="text-align:center;"><a target="_blank" href="<?php echo BASE_URL()."index.php/motorist/storeJourney?motorist_code=".$data_motorist->motorist_code."&distributor_code=".$data_motorist->distributor_code."&day_visit=friday&frequently='f1'"?>" ><?php echo $data_motorist->f1_friday; ?></a></td>
    <td style="text-align:center;"><a target="_blank" href="<?php echo BASE_URL()."index.php/motorist/storeJourney?motorist_code=".$data_motorist->motorist_code."&distributor_code=".$data_motorist->distributor_code."&day_visit=friday&frequently='f2'"?>" ><?php echo $data_motorist->f2_friday; ?></a></td>
    <td style="text-align:center;"><a target="_blank" href="<?php echo BASE_URL()."index.php/motorist/storeJourney?motorist_code=".$data_motorist->motorist_code."&distributor_code=".$data_motorist->distributor_code."&day_visit=friday&frequently='w'"?>" ><?php echo $data_motorist->w_friday; ?></a></td>
    <td style="text-align:center;" <?php $total_monday_1 = $data_motorist->f1_friday+$data_motorist->w_friday; if($total_monday_1<30){?> class="red" <?php } ?> ><a target="_blank" href="<?php echo BASE_URL()."index.php/motorist/storeJourney?motorist_code=".$data_motorist->motorist_code."&distributor_code=".$data_motorist->distributor_code."&day_visit=friday&frequently='w','f1'"?>" ><?php echo $total_monday_1;  ?></a></td>
    <td style="text-align:center;" <?php $total_monday_2 = $data_motorist->f2_friday+$data_motorist->w_friday; if($total_monday_2<30){?> class="red" <?php } ?> ><a target="_blank" href="<?php echo BASE_URL()."index.php/motorist/storeJourney?motorist_code=".$data_motorist->motorist_code."&distributor_code=".$data_motorist->distributor_code."&day_visit=friday&frequently='w','f1'"?>" ><?php echo  $total_monday_2;  ?></a></td>
    <td style="text-align:center;"><a target="_blank" href="<?php echo BASE_URL()."index.php/motorist/storeJourney?motorist_code=".$data_motorist->motorist_code."&distributor_code=".$data_motorist->distributor_code."&day_visit=saturday&frequently='f1'"?>" ><?php echo $data_motorist->f1_saturday; ?></a></td>
    <td style="text-align:center;"><a target="_blank" href="<?php echo BASE_URL()."index.php/motorist/storeJourney?motorist_code=".$data_motorist->motorist_code."&distributor_code=".$data_motorist->distributor_code."&day_visit=saturday&frequently='f2'"?>" ><?php echo $data_motorist->f2_saturday; ?></a></td>
    <td style="text-align:center;"><a target="_blank" href="<?php echo BASE_URL()."index.php/motorist/storeJourney?motorist_code=".$data_motorist->motorist_code."&distributor_code=".$data_motorist->distributor_code."&day_visit=saturday&frequently='w'"?>" ><?php echo $data_motorist->w_saturday; ?></a></td>
    <td style="text-align:center;" <?php $total_monday_1 = $data_motorist->f1_saturday+$data_motorist->w_saturday; if($total_monday_1<30){?> class="red" <?php } ?> ><a target="_blank" href="<?php echo BASE_URL()."index.php/motorist/storeJourney?motorist_code=".$data_motorist->motorist_code."&distributor_code=".$data_motorist->distributor_code."&day_visit=saturday&frequently='f1','w'"?>" ><?php echo  $total_monday_1;  ?></a></td>
    <td style="text-align:center;" <?php $total_monday_2 = $data_motorist->f2_saturday+$data_motorist->w_saturday; if($total_monday_2<30){?> class="red" <?php } ?>><a target="_blank" href="<?php echo BASE_URL()."index.php/motorist/storeJourney?motorist_code=".$data_motorist->motorist_code."&distributor_code=".$data_motorist->distributor_code."&day_visit=saturday&frequently='w','f2'"?>" ><?php echo $total_monday_2;   ?></a></td>
    
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