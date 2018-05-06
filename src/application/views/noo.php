 <!-- HEADER -->
 

    
 <section class="content-header">
          <h1>
            Noo
            <small>NOO of E-tools</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="<?php echo BASE_URL(); ?>"><i class="fa fa-dashboard"></i>Home</a></li>
            <li><a href="<?php echo BASE_URL()."noo"; ?>"><i class="fa fa-dashboard"></i>Noo</a></li>
          </ol>
        </section>
  
  
   <!-- Content -->
   <section class="content">

          <div class="box sms box-default color-palette-box">
            <div class="box-header with-border">
              <h3 class="box-title"><i class="fa fa-table"></i> Table Noo</h3>
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
			$date = isset($_GET['date']) ? $_GET['date'] : '';
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
			function convert_price($price)
			{
				echo "Rp. ".number_format($price, 0 , '' , '.' );		
					}
			?>
            <div id="wrapper-console" class="clearfix">
                <div id="wrapper-search">
                             <form action="<?php echo base_url()."index.php/noo" ?>" method="get">
                             <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                                <div class="form-group">
                                <label>Date range:</label>
                                <div class="input-group">
                                  <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                  </div>
                                  <input type="text" class="form-control pull-right" id="reservation" name="date" value="<?php echo $date; ?>" >
                                </div><!-- /.input group -->
                              </div><!-- /.form group -->
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
                                <?php } ?>
                                <input type="text" id="search" name="search" placeholder="Search by Motorist Code"  value="<?php echo $search; ?>" />
                                <input type="submit" id="submit"  value="Search"/>
                                <?php if($search!="" or $date!="" or $regional_implode!="" or $motorist_type_implode!="")
								{?>
                                <a href="<?php echo base_url()."index.php/noo" ?>" id="clear-search">Clear Search</a>
                                <?php } ?>
                             </form>
                </div>
                <div id="wrapper-button" class="clearfix">
                	
                    
                     <a href="<?php echo base_url()."index.php/noo/exportNoo?date=".$date."&&search=".$search."&&motorist_type=".$motorist_type_implode."&&regional=".$regional_implode; ?>" class="button blue-button">
                    	Export Noo
                    </a>
                </div>
                </div>
            <div id="wrapper-table">
           
            <div id="wrapper-console" class="clearfix">   
            <div class="grid_4 height400">              
           	<table id="myTable05" class="fancyTable table table-bordered table-hover">
                    <thead>
                      <tr>
                      	<th><div class="mid">Motorist Name</div></th>
                        <th><div class="mid">ID Noo</div></th>
                        <th><div class="mid">Distributor Code</div></th>
                        <th><div class="mid">Motorist Code</div></th>
                        
                        <th><div class="mid">Day Visit</div></th>
                        <th><div class="mid">Frequency</div></th>
                        <th><div class="mid">Customer Name</div></th>
                        <th><div class="mid">Channel Code</div></th>
                        <th><div class="mid">Channel Name</div></th>
                        <th><div class="mid">Place Status</div></th>
                        <th><div class="mid">Address</div></th>
                        <th><div class="mid">Districts</div></th>
                        <th><div class="mid">Customer Contact</div></th>
                        <th><div class="mid">Loyalty Store</div></th>
                        <th><div class="mid">Action</div></th>
                      </tr>
                    </thead>
             		<tbody>
                    <?php foreach($data_noo as $data_noo) {?>
                    <tr>
                    	<td><div style="width:200px;"><?php echo $data_noo->motorist_name; ?>-<?php echo $data_noo->motorist_code ?></div></td>
                    	<td><?php echo $data_noo->id_noo; ?></td>
                        <td><?php echo $data_noo->distributor_code; ?></td>
                        <td><?php echo $data_noo->motorist_code ?></td>
                        
                        <td><?php echo $data_noo->day_visit; ?></td>
                        <td><?php echo $data_noo->frequency; ?></td>
                        <td><?php echo $data_noo->customer_name; ?></td>
                        <td><?php echo $data_noo->channel_code; ?></td>
                        <td><?php echo $data_noo->channel_name; ?></td>
                        <td><?php echo $data_noo->place_status; ?></td>
                        <td><?php echo $data_noo->address; ?></td>
                        <td><?php echo $data_noo->districts; ?></td>
                        <td><?php echo $data_noo->customer_contact; ?></td>
                        <td><?php echo $data_noo->loyalty_store; ?></td>
                        <td><a href="<?php echo base_url()."index.php/noo/detailNoo/".$data_noo->id_noo ?>">Detail</a></td>
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
</script>