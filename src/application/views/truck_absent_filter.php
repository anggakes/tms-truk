<!-- HEADER -->
 <section class="content-header">
          <h1>
            Truck Roaster
            <small>List Of  Truck Roaster</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="<?php echo BASE_URL(); ?>"><i class="fa fa-dashboard"></i>Home</a></li>
            <li><a href="<?php echo BASE_URL()."truck_absent"; ?>"><i class="fa fa-dashboard"></i> Truck Roaster</a></li>
          </ol>
        </section>
  
  
   <!-- Content -->
   <section class="content">
		
		
  
  
          <div class="box sms box-default color-palette-box">
            <div class="box-header with-border">
              <h3 class="box-title"><i class="fa fa-table"></i> Table Roaster</h3>
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
			function convert_price($price)
			{
				echo "Rp. ".number_format($price, 0 , '' , '.' );		
					}
			
			function convert_date($date)
			{
				$date = explode("-",$date);
				echo $date[2].'-'.$date[1].'-'.$date[0];		
			
			}
			?>
            <div id="wrapper-console" class="clearfix">
                <div id="wrapper-search">
                             <form action="<?php echo base_url()."index.php/truck_absent" ?>" method="get">
                             <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                                <input type="text" id="search" name="search" placeholder="Search..."  value="<?php echo $search; ?>" />
                                <input type="submit" id="submit"  value="Search"/>
                                <?php if($search!="")
								{?>
                                <a href="<?php echo base_url()."index.php/truck_absent" ?>" id="clear-search">Clear Search</a>
                                <?php } ?>
                             </form>
                </div>
                <div id="wrapper-button" class="clearfix">
					<?php if($data_role[0]['export_truck_absent']=='yes'){ ?>
                	<a href="<?php echo base_url()."index.php/truck_absent/exportTruckAbsent?search=".$search; ?>" class="button orange-button">
                    	Export Truck Roaster
                    </a>
					<?php } ?>
                    <?php if($data_role[0]['add_truck_absent']=='yes'){ ?>
                    <a id="add-data" class="button green-button">
                    	Add Truck Roaster
                    </a>
					<?php } ?>
					<?php if($data_role[0]['delete_truck_absent']=='yes'){ ?>
                    <a id="delete-data" class="button btn-danger deletelogg">
                    	Delete Truck Roaster
                    </a>
					<?php } ?>
					<!--<?php if($data_role[0]['import_truck_absent']=='yes'){ ?>
                    <a id="import-data" class="button blue-button">
                    	Import Truck Absent
                    </a>
					<?php } ?>-->
					
                </div>
                </div>
            <div id="wrapper-console" class="clearfix"> 
            <div class="grid_4 height400">                  
           	<table id="table-summary" class="table table-hover">
                    <thead>
                      <tr>
                        <th>Vehicle ID</th>
						<th>Klengkapan Oli Mesin</th>
						<th>Kecukupan Air Radioator</th>
						<th>Kondisi Ban</th>
						<th>Kondisi Accu</th>
						<th>Kontrol Lampu</th>
						<th>Angin Untuk Rem</th>
						<th>Test Mesin</th>
						<th>Kondisi Body Truck</th>
						<th>Kecukupan Isi Solar</th>
						<th>Kelengkapan Safety</th>
						<th>Kelengkapan Document</th>
                      </tr>
                    </thead>
             		<tbody>
                    <?php foreach($data_absent as $data_absent) {?>
                    <tr id="data_<?php echo $data_absent->id_truck_absent; ?>">
					
                        <td class="vehicle_id"><?php echo $data_absent->vehicle_id; ?></td>
						<td class="action_kelengkapan_oli_mesin <?php echo $data_absent->action_kelengkapan_oli_mesin; ?>"><?php echo $data_absent->action_kelengkapan_oli_mesin; ?></td>
			<td class="action_kecukupan_air_radioator <?php echo $data_absent->action_kecukupan_air_radioator; ?>"><?php echo $data_absent->action_kecukupan_air_radioator; ?></td>
			<td class="action_kondisi_ban <?php echo $data_absent->action_kondisi_ban; ?>"><?php echo $data_absent->action_kondisi_ban; ?></td>
						<td class="action_kondisi_accu <?php echo $data_absent->action_kondisi_accu; ?>"><?php echo $data_absent->action_kondisi_accu; ?></td>
						<td class="action_kontrol_lampu <?php echo $data_absent->action_kontrol_lampu; ?>"><?php echo $data_absent->action_kontrol_lampu; ?></td>
						<td class="action_angin_untuk_rem <?php echo $data_absent->action_angin_untuk_rem; ?>"><?php echo $data_absent->action_angin_untuk_rem; ?></td>
						<td class="action_test_mesin <?php echo $data_absent->action_test_mesin; ?>"><?php echo $data_absent->action_test_mesin; ?></td>
						<td class="action_kondisi_body_truck <?php echo $data_absent->action_kondisi_body_truck; ?>"><?php echo $data_absent->action_kondisi_body_truck; ?></td>
						<td class="action_kecukupan_isi_solar <?php echo $data_absent->action_kecukupan_isi_solar; ?>"><?php echo $data_absent->action_kecukupan_isi_solar; ?></td>
						<td class="action_kelengkapan_safety <?php echo $data_absent->action_kelengkapan_safety; ?>"><?php echo $data_absent->action_kelengkapan_safety; ?></td>
						<td class="	action_kelengkapan_document	<?php echo $data_absent->action_kelengkapan_document	; ?>"><?php echo $data_absent->action_kelengkapan_document	; ?></td>
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

	  
	 <div class="remodal" data-remodal-id="modal_add" role="dialog" aria-labelledby="modal1Titl aria-describedby="modal1Desc">
	  <button data-remodal-action="close" class="remodal-close" aria-label="Close"></button>
	  <div>
		<h2 id="modal1Title">Add Truck Roaster</h2>
				<form role="form" id="form_add_data" method="POST" action="<?php echo base_url()."index.php/truck_absent/addTruckAbsent" ?>" enctype="multipart/form-data">
				 <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
				 
              <div class="box-body">

				 <div class="form-group">
					 <label>vehicle ID</label>
						<div class="input-group">
						  <div class="input-group-addon">
							<i class="fa fa-search"></i>
						  </div>
						  <input type="text" class="form-control pull-right" name="search_vehicle_id" id="search_vehicle_id" value=''n placeholder='Search Vehicle ID'>
						  <input type="text" readonly class="form-control" name="vehicle_id" id="vehicle_id" placeholder='Vehicle ID' required>
						</div>
						<!-- /.input group -->
					</div>
					
					
					<div class="form-group">
					 <label>Driver</label>
						<div class="input-group">
						  <div class="input-group-addon">
							<i class="fa fa-search"></i>
						  </div>
						  <input type="text" class="form-control pull-right" name="search_driver" id="search_driver" value=''n placeholder='Search Driver'>
						  <input type="text" readonly class="form-control" name="driver_code" id="driver_code" placeholder='Driver Code' required>
						  <input type="text" readonly class="form-control" name="driver_name" id="driver_name" placeholder='Driver Code' required>
						</div>
						<!-- /.input group -->
					</div>
					
					
					<!--<div class="form-group">
					  <label for="drivercode2">Shift</label>
					  <select class="form-control" name="id_shift" id="id_shift" required>
						<option selected="selected" value="">Choose Shift</option>
							<?php foreach($data_category_shift as $data_category_shift1) {?>
								<option value='<?php echo $data_category_shift1->description; ?>'><?php echo $data_category_shift1->description; ?></option>
							 <?php } ?>
					  </select> 
					</div>-->
					
					<table class='table-truck-absent'>
						<tr>
							<th>No</th>
							<th>Pemeriksaan</th>
							<th>Action</th>
						</tr>
						
						<tr>
							<td>1</td>
							<td><input class='checkbox_check' type="checkbox" value='ok' name='kelengkapan_oli_mesin' id='kelengkapan_oli_mesin'>Kelengkapan Oli Mesin</td>
							<td><select class='select_check' name='action_kelengkapan_oli_mesin' id='action_kelengkapan_oli_mesin'>
							 <?php foreach($data_category_truck_absent as $data_category_truck_absent1) {?>
								<option value='<?php echo $data_category_truck_absent1->description; ?>'><?php echo $data_category_truck_absent1->description; ?></option>
							 <?php } ?>
							</select></td>
						</tr>
						
						<tr>
							<td>2</td>
							<td><input class='checkbox_check' type="checkbox" value='ok' name='kecukupan_air_radioator' id='kecukupan_air_radioator'>Kecukupan Air Radioator</td>
							<td><select class='select_check' name='action_kecukupan_air_radioator' id='action_kecukupan_air_radioator'>
							<?php foreach($data_category_truck_absent as $data_category_truck_absent2) {?>
								<option value='<?php echo $data_category_truck_absent2->description; ?>'><?php echo $data_category_truck_absent2->description; ?></option>
							 <?php } ?>
							</select></td>
						</tr>
						
						<tr>
							<td>3</td>
							<td><input class='checkbox_check' type="checkbox" value='ok' name='kondisi_ban' id='kondisi_ban'>Kondisi Ban</td>
							<td><select class='select_check' name='action_kondisi_ban' id='action_kondisi_ban'>
							<?php foreach($data_category_truck_absent as $data_category_truck_absent3) {?>
								<option value='<?php echo $data_category_truck_absent3->description; ?>'><?php echo $data_category_truck_absent3->description; ?></option>
							 <?php } ?>
							</select></td>
						</tr>
						
						<tr>
							<td>4</td>
							<td><input class='checkbox_check' type="checkbox" value='ok' name='kondisi_accu' id='kondisi_accu'>kondisi Accu</td>
							<td><select class='select_check' name='action_kondisi_accu' id='action_kondisi_accu'>
							<?php foreach($data_category_truck_absent as $data_category_truck_absent4) {?>
								<option value='<?php echo $data_category_truck_absent4->description; ?>'><?php echo $data_category_truck_absent4->description; ?></option>
							 <?php } ?>
							</select></td>
						</tr>
						
						<tr>
							<td>5</td>
							<td><input class='checkbox_check' type="checkbox" value='ok' name='kontrol_lampu' id='kontrol_lampu'>kondisi Lampu</td>
							<td><select class='select_check' name='action_kontrol_lampu' id='action_kontrol_lampu'>
							<?php foreach($data_category_truck_absent as $data_category_truck_absent5) {?>
								<option value='<?php echo $data_category_truck_absent5->description; ?>'><?php echo $data_category_truck_absent5->description; ?></option>
							 <?php } ?>
							</select></td>
						</tr>
						
						<tr>
							<td>6</td>
							<td><input class='checkbox_check' type="checkbox" value='ok' name='angin_untuk_rem' id='angin_untuk_rem'>Angin Untuk Rem</td>
							<td><select class='select_check' name='action_angin_untuk_rem' id='action_angin_untuk_rem'>
							<?php foreach($data_category_truck_absent as $data_category_truck_absent6) {?>
								<option value='<?php echo $data_category_truck_absent6->description; ?>'><?php echo $data_category_truck_absent6->description; ?></option>
							 <?php } ?>
							</select></td>
						</tr>
						
						<tr>
							<td>7</td>
							<td><input class='checkbox_check' type="checkbox" value='ok' name='test_mesin' id='test_mesin'>Test mesin</td>
							<td><select class='select_check' name='action_test_mesin' id='action_test_mesin'>
							<?php foreach($data_category_truck_absent as $data_category_truck_absent7) {?>
								<option value='<?php echo $data_category_truck_absent7->description; ?>'><?php echo $data_category_truck_absent7->description; ?></option>
							 <?php } ?>
							</select></td>
						</tr>
						
						<tr>
							<td>8</td>
							<td><input class='checkbox_check' type="checkbox" value='ok' name='kondisi_body_truck' id='kondisi_body_truck'>Kondisi Body Truck</td>
							<td><select class='select_check' name='action_kondisi_body_truck' id='action_kondisi_body_truck'>
							<?php foreach($data_category_truck_absent as $data_category_truck_absent8) {?>
								<option value='<?php echo $data_category_truck_absent8->description; ?>'><?php echo $data_category_truck_absent8->description; ?></option>
							 <?php } ?>
							</select></td>
						</tr>
						
						<tr>
							<td>9</td>
							<td><input class='checkbox_check' type="checkbox" value='ok' name='kecukupan_isi_solar' id='kecukupan_isi_solar'>Kecukupan Isi Solar</td>
							<td><select class='select_check' name='action_kecukupan_isi_solar' id='action_kecukupan_isi_solar'>
							<?php foreach($data_category_truck_absent as $data_category_truck_absent9) {?>
								<option value='<?php echo $data_category_truck_absent9->description; ?>'><?php echo $data_category_truck_absent9->description; ?></option>
							 <?php } ?>
							</select></td>
						</tr>
						
						<tr>
							<td>10</td>
							<td><input class='checkbox_check' type="checkbox" value='ok' name='kelengkapan_safety' id='kelengkapan_safety'>Kelengkapan Safety</td>
							<td><select class='select_check' name='action_kelengkapan_safety' id='action_kelengkapan_safety'>
							<?php foreach($data_category_truck_absent as $data_category_truck_absent10) {?>
								<option value='<?php echo $data_category_truck_absent10->description; ?>'><?php echo $data_category_truck_absent10->description; ?></option>
							 <?php } ?>
							</select></td>
						</tr>
						
						<tr>
							<td>11</td>
							<td><input class='checkbox_check' type="checkbox" value='ok' name='kelengkapan_document' id='kelengkapan_document'>Kelengkapan Document</td>
							<td><select class='select_check' name='action_kelengkapan_document' id='action_kelengkapan_document'>
							<?php foreach($data_category_truck_absent as $data_category_truck_absent11) {?>
								<option value='<?php echo $data_category_truck_absent11->description; ?>'><?php echo $data_category_truck_absent11->description; ?></option>
							 <?php } ?>
							</select></td>
						</tr>
						
						
					</table>
				
				
				
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button data-remodal-action="cancel" class="remodal-cancel">Cancel</button>
				<input type="submit" name="submit_add" class="remodal-confirm" value="Submit" id="submit_add">
              </div>
            </form>
	  </div>
	  <br>
	  
	</div>
	
	
	
	<div class="remodal" data-remodal-id="modal_edit" role="dialog" aria-labelledby="modal1Titl aria-describedby="modal1Desc">
	  <button data-remodal-action="close" class="remodal-close" aria-label="Close"></button>
	  <div>
		<h2 id="modal1Title">Edit Truck Roaster</h2>
				<form role="form" id="form_edit_data" method="POST" action="<?php echo base_url()."index.php/truck_absent/edittruckAbsent" ?>" enctype="multipart/form-data">
				 <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
				 
              <div class="box-body">

				<div class="form-group">
					 <label>vehicle ID</label>
						<div class="input-group">
						  <div class="input-group-addon">
							<i class="fa fa-search"></i>
						  </div>
						  <input type="text" class="form-control pull-right" name="edit_search_vehicle_id" id="edit_search_vehicle_id" value=''n placeholder='Search Vehicle ID'>
						  <input type="text" readonly class="form-control" name="edit_vehicle_id" id="edit_vehicle_id" placeholder='Vehicle ID' required>
						</div>
						<!-- /.input group -->
					</div>
					
					
					<div class="form-group">
					 <label>Driver</label>
						<div class="input-group">
						  <div class="input-group-addon">
							<i class="fa fa-search"></i>
						  </div>
						  <input type="text" class="form-control pull-right" name="edit_search_driver" id="edit_search_driver" value=''n placeholder='Search Driver'>
						  <input type="text" readonly class="form-control" name="edit_driver_code" id="edit_driver_code" placeholder='Driver Code' required>
						  <input type="text" readonly class="form-control" name="edit_driver_name" id="edit_driver_name" placeholder='Driver Code' required>
						</div>
						<!-- /.input group -->
					</div>
					
					
					<!--<div class="form-group">
					  <label for="drivercode2">Shift</label>
					  <select class="form-control" name="edit_id_shift" id="edit_id_shift" required>
						<option selected="selected" value="">Choose Shift</option>
						<?php foreach($data_category_shift as $data_category_shift2) {?>
								<option value='<?php echo $data_category_shift2->description; ?>'><?php echo $data_category_shift2->description; ?></option>
							 <?php } ?>
					  </select> 
					</div>-->
					
					<table class='table-truck-absent'>
						<tr>
							<th>No</th>
							<th>Pemeriksaan</th>
							<th>Action</th>
						</tr>
						
						<tr>
							<td>1</td>
							<td><input class='checkbox_check' type="checkbox" value='ok' name='edit_kelengkapan_oli_mesin' id='edit_kelengkapan_oli_mesin'>Kelengkapan Oli Mesin</td>
							<td><select class='select_check' name='edit_action_kelengkapan_oli_mesin' id='edit_action_kelengkapan_oli_mesin'>
							<?php foreach($data_category_truck_absent as $data_category_truck_absent12) {?>
								<option value='<?php echo $data_category_truck_absent12->description; ?>'><?php echo $data_category_truck_absent12->description; ?></option>
							 <?php } ?>
							</select></td>
						</tr>
						
						<tr>
							<td>2</td>
							<td><input class='checkbox_check' type="checkbox" value='ok' name='edit_kecukupan_air_radioator' id='edit_kecukupan_air_radioator'>Kecukupan Air Radioator</td>
							<td><select class='select_check' name='edit_action_kecukupan_air_radioator' id='edit_action_kecukupan_air_radioator'>
							<?php foreach($data_category_truck_absent as $data_category_truck_absent13) {?>
								<option value='<?php echo $data_category_truck_absent13->description; ?>'><?php echo $data_category_truck_absent13->description; ?></option>
							 <?php } ?>
							</select></td>
						</tr>
						
						<tr>
							<td>3</td>
							<td><input class='checkbox_check' type="checkbox" value='ok' name='edit_kondisi_ban' id='edit_kondisi_ban'>Kondisi Ban</td>
							<td><select class='select_check' name='edit_action_kondisi_ban' id='edit_action_kondisi_ban'>
							<?php foreach($data_category_truck_absent as $data_category_truck_absent14) {?>
								<option value='<?php echo $data_category_truck_absent14->description; ?>'><?php echo $data_category_truck_absent14->description; ?></option>
							 <?php } ?>
							</select></td>
						</tr>
						
						<tr>
							<td>4</td>
							<td><input class='checkbox_check' type="checkbox" value='ok' name='edit_kondisi_accu' id='edit_kondisi_accu'>kondisi Accu</td>
							<td><select class='select_check' name='edit_action_kondisi_accu' id='edit_action_kondisi_accu'>
							<?php foreach($data_category_truck_absent as $data_category_truck_absent15) {?>
								<option value='<?php echo $data_category_truck_absent15->description; ?>'><?php echo $data_category_truck_absent15->description; ?></option>
							 <?php } ?>
							</select></td>
						</tr>
						
						<tr>
							<td>5</td>
							<td><input class='checkbox_check' type="checkbox" value='ok' name='edit_kontrol_lampu' id='edit_kontrol_lampu'>kondisi Lampu</td>
							<td><select class='select_check' name='edit_action_kontrol_lampu' id='edit_action_kontrol_lampu'>
							<?php foreach($data_category_truck_absent as $data_category_truck_absent16) {?>
								<option value='<?php echo $data_category_truck_absent16->description; ?>'><?php echo $data_category_truck_absent16->description; ?></option>
							 <?php } ?>
							</select></td>
						</tr>
						
						<tr>
							<td>6</td>
							<td><input class='checkbox_check' type="checkbox" value='ok' name='edit_angin_untuk_rem' id='edit_angin_untuk_rem'>Angin Untuk Rem</td>
							<td><select class='select_check' name='edit_action_angin_untuk_rem' id='edit_action_angin_untuk_rem'>
							<?php foreach($data_category_truck_absent as $data_category_truck_absent17) {?>
								<option value='<?php echo $data_category_truck_absent17->description; ?>'><?php echo $data_category_truck_absent17->description; ?></option>
							 <?php } ?>
							</select></td>
						</tr>
						
						<tr>
							<td>7</td>
							<td><input class='checkbox_check' type="checkbox" value='ok' name='edit_test_mesin' id='edit_test_mesin'>Test mesin</td>
							<td><select class='select_check' name='edit_action_test_mesin' id='edit_action_test_mesin'>
							<?php foreach($data_category_truck_absent as $data_category_truck_absent18) {?>
								<option value='<?php echo $data_category_truck_absent18->description; ?>'><?php echo $data_category_truck_absent18->description; ?></option>
							 <?php } ?>
							</select></td>
						</tr>
						
						<tr>
							<td>8</td>
							<td><input class='checkbox_check' type="checkbox" value='ok' name='edit_kondisi_body_truck' id='edit_kondisi_body_truck'>Kondisi Body Truck</td>
							<td><select class='select_check' name='edit_action_kondisi_body_truck' id='edit_action_kondisi_body_truck'>
							<?php foreach($data_category_truck_absent as $data_category_truck_absent19) {?>
								<option value='<?php echo $data_category_truck_absent19->description; ?>'><?php echo $data_category_truck_absent19->description; ?></option>
							 <?php } ?>
							</select></td>
						</tr>
						
						<tr>
							<td>9</td>
							<td><input class='checkbox_check' type="checkbox" value='ok' name='edit_kecukupan_isi_solar' id='edit_kecukupan_isi_solar'>Kecukupan Isi Solar</td>
							<td><select class='select_check' name='edit_action_kecukupan_isi_solar' id='edit_action_kecukupan_isi_solar'>
							<?php foreach($data_category_truck_absent as $data_category_truck_absent20) {?>
								<option value='<?php echo $data_category_truck_absent20->description; ?>'><?php echo $data_category_truck_absent20->description; ?></option>
							 <?php } ?>
							</select></td>
						</tr>
						
						<tr>
							<td>10</td>
							<td><input class='checkbox_check' type="checkbox" value='ok' name='edit_kelengkapan_safety' id='edit_kelengkapan_safety'>Kelengkapan Safety</td>
							<td><select class='select_check' name='edit_action_kelengkapan_safety' id='edit_action_kelengkapan_safety'>
							<?php foreach($data_category_truck_absent as $data_category_truck_absent21) {?>
								<option value='<?php echo $data_category_truck_absent21->description; ?>'><?php echo $data_category_truck_absent21->description; ?></option>
							 <?php } ?>
							</select></td>
						</tr>
						
						<tr>
							<td>11</td>
							<td><input class='checkbox_check' type="checkbox" value='ok' name='edit_kelengkapan_document' id='edit_kelengkapan_document'>Kelengkapan Document</td>
							<td><select class='select_check' name='edit_action_kelengkapan_document' id='edit_action_kelengkapan_document'>
							<?php foreach($data_category_truck_absent as $data_category_truck_absent22) {?>
								<option value='<?php echo $data_category_truck_absent22->description; ?>'><?php echo $data_category_truck_absent22->description; ?></option>
							 <?php } ?>
							</select></td>
						</tr>
						
						
					</table>
					
					
                <input type="hidden" class="form-control" name="id_absent_update" id="id_absent_update">
              
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button data-remodal-action="cancel" class="remodal-cancel">Cancel</button>
				<input type="submit" name="submit_add" class="remodal-confirm" value="Submit" id="submit_add">
              </div>
            </form>
	  </div>
	  <br>
	  
	</div>
	
	
	
	<div class="remodal" data-remodal-id="modal_import" role="dialog" aria-labelledby="modal1Titl aria-describedby="modal1Desc">
	  <button data-remodal-action="close" class="remodal-close" aria-label="Close"></button>
	  <div>
		<h2 id="modal1Title">Import Driver</h2>
				<form role="form" id="form_import_data" method="POST" action="<?php echo base_url()."index.php/driver/importDriver" ?>" enctype="multipart/form-data">
				 <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
				 
              <div class="box-body">

				 <div class="form-group">
                      <label for="exampleInputEmail1">Choose File</label>
                      <input type="file" name="import_file" id="import_file" class="form-control" value="" />
				</div>
				
				 <div class="form-group">
                    <p><a target="_blank" href="<?php echo base_url('/files/example-files/import-driver.xlsx')?>">Download sample file import driver</a></p>
                 </div>
              
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button data-remodal-action="cancel" class="remodal-cancel">Cancel</button>
				<input type="submit" name="submit_add" class="remodal-confirm" value="Submit" id="submit_add">
              </div>
            </form>
	  </div>
	  <br>
	  
	</div>
	
	
	
	<div class="remodal" data-remodal-id="modal_detail" role="dialog" aria-labelledby="modal1Titl aria-describedby="modal1Desc">
	  <button data-remodal-action="close" class="remodal-close" aria-label="Close"></button>
	  <div>
		<h2 id="modal1Title">Detail Truck Absent</h2>
				
              <div class="box-body">

				 <div class="form-group">
                      <label for="exampleInputEmail1">vehicle ID</label>
					  <span class='detail_text' id='detail_vehicle_id'></span>
				 </div> 
				 
				 <div class="form-group">
                      <label for="exampleInputEmail1">Date Absence</label>
					  <span class='detail_text' id='detail_date_absence'></span>
				 </div>
				 
				 <div class="form-group">
                      <label for="exampleInputEmail1">Driver Code</label>
					  <span class='detail_text' id='detail_driver_code'></span>
				 </div>
				 
				 <div class="form-group">
                      <label for="exampleInputEmail1">Driver Name</label>
					  <span class='detail_text' id='detail_driver_name'></span>
				 </div>
				 
				 <!--<div class="form-group">
                      <label for="exampleInputEmail1">Shift</label>
					  <span class='detail_text' id='detail_shift'></span>
				 </div>-->
				 
				
					<table class='table-truck-absent'>
						<tr>
							<th>No</th>
							<th>Pemeriksaan</th>
							<th>Status</th>
							<th>Action</th>
						</tr>
						
						<tr>
							<td>1</td>
							<td>Kelengkapan Oli Mesin</td>
							<td><div id='detail_kelengkapan_oli_mesin'></div></td>
							<td><div id='detail_action_kelengkapan_oli_mesin'></div></td>
						</tr>
						
						<tr>
							<td>2</td>
							<td>Kecukupan Air Radioator</td>
							<td><div id='detail_kecukupan_air_radioator'></div></td>
							<td><div id='detail_action_kecukupan_air_radioator'></div></td>
						</tr>
						
						<tr>
							<td>3</td>
							<td>Kondisi Ban</td>
							<td><div id='detail_kondisi_ban'></div></td>
							<td><div id='detail_action_kondisi_ban'></div></td>
						</tr>
						
						<tr>
							<td>4</td>
							<td>Kondisi Accu</td>
							<td><div id='detail_kondisi_accu'></div></td>
							<td><div id='detail_action_kondisi_accu'></div></td>
						</tr>
						
						<tr>
							<td>5</td>
							<td>Kondisi Lampu</td>
							<td><div id='detail_kontrol_lampu'></div></td>
							<td><div id='detail_action_kontrol_lampu'></div></td>
						</tr>
						
						<tr>
							<td>6</td>
							<td>Angin Untuk Rem</td>
							<td><div id='detail_angin_untuk_rem'></div></td>
							<td><div id='detail_action_angin_untuk_rem'></div></td>
						</tr>
						
						<tr>
							<td>7</td>
							<td>Test Mesin</td>
							<td><div id='detail_test_mesin'></div></td>
							<td><div id='detail_action_test_mesin'></div></td>
							
						</tr>
						
						<tr>
							<td>8</td>
							<td>Kondisi Body Truck</td>
							<td><div id='detail_kondisi_body_truck'></div></td>
							<td><div id='detail_action_kondisi_body_truck'></div></td>
						</tr>
						
						<tr>
							<td>9</td>
							<td>Kecukupan Isi Solar</td>
							<td><div id='detail_kecukupan_isi_solar'></div></td>
							<td><div id='detail_action_kecukupan_isi_solar'></div></td>
						</tr>
						
						<tr>
							<td>10</td>
							<td>Kelengkapan Safety</td>
							<td><div id='detail_kelengkapan_safety'></div></td>
							<td><div id='detail_action_kelengkapan_safety'></div></td>
						</tr>
						
						<tr>
							<td>11</td>
							<td>Kelengkapan Document</td>
							<td><div id='detail_kelengkapan_document'></div></td>
							<td><div id='detail_action_kelengkapan_document'></div></td>
						</tr>
						
						
						
					</table>
				
              
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
             
	  </div>
	  <br>
	  
	</div></div>
	
	
	<div class="remodal" data-remodal-id="modal_delete" role="dialog" aria-labelledby="modal1Titl aria-describedby="modal1Desc">
	  <button data-remodal-action="close" class="remodal-close" aria-label="Close"></button>
	  <div>
		<h2 id="modal1Title">Delete Truck Absent</h2>
				<form role="form" id="form_delete_data" method="POST" action="<?php echo base_url()."index.php/truck_absent/deleteTruckAbsent" ?>" enctype="multipart/form-data">
				 <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
				 
              <div class="box-body">

				 <div class="form-group">
                     <p>Are you sure want to delete this data? (<span id="reference_delete"></span>)</p>
				</div>
				
				 <div class="form-group">
                      <input type="hidden" name="id_absent_delete" id="id_absent_delete" class="form-control" value="" />
				</div>
				
				
              
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button data-remodal-action="cancel" class="remodal-cancel">Cancel</button>
				<input type="submit" name="submit_add" class="remodal-confirm" value="Submit" id="submit_add">
              </div>
            </form>
	  </div>
	  <br>
	  
	</div>
	
	
	
	
	<div class="remodal" data-remodal-id="modal_delete_all" role="dialog" aria-labelledby="modal1Titl aria-describedby="modal1Desc">
	  <button data-remodal-action="close" class="remodal-close" aria-label="Close"></button>
	  <div>
		<h2 id="modal1Title">Delete Absent</h2>
				<form role="form" id="form_selected_delete_data" method="POST" action="<?php echo base_url()."index.php/truck_absent/deleteTruckAbsentAll" ?>" enctype="multipart/form-data">
				 <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
				 
              <div class="box-body">

				 <div class="form-group">
                     <p>Are you sure want to delete selected data? </p>
				</div>
				
				 <div class="form-group">
                      <input type="hidden" name="id_absent_delete_all" id="id_absent_delete_all" class="form-control" value="" />
				</div>
				
				
              
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button data-remodal-action="cancel" class="remodal-cancel">Cancel</button>
				<input type="submit" name="submit_add" class="remodal-confirm" value="Submit" id="submit_add">
              </div>
            </form>
	  </div>
	  <br>
	  
	</div>
		
  <script>
  
			$(".delete_data").click(function(){
				var id = $(this).attr('id');
				var vehicle_id =  $('#data_'+id+' .vehicle_id').text();
				var id_absent =  $('#data_'+id+' .id_truck_absent span').text();
				var date_absence =  $('#data_'+id+' .date_absence').text();
				$("#reference_delete").text("Vehicle ID: "+vehicle_id+" - Date Absence: "+date_absence)
				$("#id_absent_delete").val(id_absent);
			});
			
			
			
			$(".edit_data").click(function(){
				var id = $(this).attr('id');
				var date_absence =  $('#data_'+id+' .date_absence').text();
				var vehicle_id =  $('#data_'+id+' .vehicle_id').text();
				var driver_name =  $('#data_'+id+' .driver_name').text();
				var driver_code =  $('#data_'+id+' .driver_code').text();
				var shift =  $('#data_'+id+' span.shift').text();
				var shift_description =  $('#data_'+id+'  span.shift_description').text();
				var kelengkapan_oli_mesin =  $('#data_'+id+' .data_detail_truck_absent span.kelengkapan_oli_mesin').text();
				var action_kelengkapan_oli_mesin =  $('#data_'+id+' .data_detail_truck_absent span.action_kelengkapan_oli_mesin').text();
	
				var kecukupan_air_radioator =  $('#data_'+id+' .data_detail_truck_absent span.kecukupan_air_radioator').text();
				var action_kecukupan_air_radioator =  $('#data_'+id+' .data_detail_truck_absent span.action_kecukupan_air_radioator').text();
				var kondisi_ban =  $('#data_'+id+' .data_detail_truck_absent span.kondisi_ban').text();
				var action_kondisi_ban =  $('#data_'+id+' .data_detail_truck_absent span.action_kondisi_ban').text();
				var kondisi_accu =  $('#data_'+id+' .data_detail_truck_absent span.kondisi_accu').text();
				var action_kondisi_accu =  $('#data_'+id+' .data_detail_truck_absent span.action_kondisi_accu').text();
				var kontrol_lampu =  $('#data_'+id+' .data_detail_truck_absent span.kontrol_lampu').text();
				var action_kontrol_lampu =  $('#data_'+id+' .data_detail_truck_absent span.action_kontrol_lampu').text();
				var angin_untuk_rem =  $('#data_'+id+' .data_detail_truck_absent span.angin_untuk_rem').text();
				var action_angin_untuk_rem =  $('#data_'+id+' .data_detail_truck_absent span.action_angin_untuk_rem').text();
				var test_mesin =  $('#data_'+id+' .data_detail_truck_absent span.test_mesin').text();
				var action_test_mesin =  $('#data_'+id+' .data_detail_truck_absent span.action_test_mesin').text();
				var kondisi_body_truck =  $('#data_'+id+' .data_detail_truck_absent span.kondisi_body_truck').text();
				var action_kondisi_body_truck =  $('#data_'+id+' .data_detail_truck_absent span.action_kondisi_body_truck').text();
				var kecukupan_isi_solar =  $('#data_'+id+' .data_detail_truck_absent span.kecukupan_isi_solar').text();
				var action_kecukupan_isi_solar =  $('#data_'+id+' .data_detail_truck_absent span.action_kecukupan_isi_solar').text();
				var kelengkapan_safety =  $('#data_'+id+' .data_detail_truck_absent span.kelengkapan_safety').text();
				var action_kelengkapan_safety =  $('#data_'+id+' .data_detail_truck_absent span.action_kelengkapan_safety').text();
				var kelengkapan_document =  $('#data_'+id+' .data_detail_truck_absent span.kelengkapan_document').text();
				var action_kelengkapan_document =  $('#data_'+id+' .data_detail_truck_absent span.action_kelengkapan_document').text();
				
				
				$("#edit_date_absence").val(date_absence);
				$("#edit_vehicle_id").val(vehicle_id);
				$("#edit_driver_name").val(driver_name);
				$("#edit_driver_code").val(driver_code);
				$("#edit_shift").val("Shift "+shift+ " - "+shift_description);
				
				
				$("#edit_kelengkapan_oli_mesin:checkbox[value='"+kelengkapan_oli_mesin+"']").attr("checked", true);
				$('#edit_action_kelengkapan_oli_mesin option[value="' + action_kelengkapan_oli_mesin + '"]').prop('selected',true);
				
				$("#edit_kecukupan_air_radioator:checkbox[value='"+kecukupan_air_radioator+"']").attr("checked", true);
				$('#edit_action_kecukupan_air_radioator option[value="' + action_kecukupan_air_radioator + '"]').prop('selected',true);
				
				
				$("#edit_kondisi_ban:checkbox[value='"+kondisi_ban+"']").attr("checked", true);
				$('#edit_action_kondisi_ban option[value="' + action_kondisi_ban + '"]').prop('selected',true);
				
				
				$("#edit_kondisi_accu:checkbox[value='"+kondisi_accu+"']").attr("checked", true);
				$('#edit_action_kondisi_accu option[value="' + action_kondisi_accu + '"]').prop('selected',true);
				
				$("#edit_kontrol_lampu:checkbox[value='"+kontrol_lampu+"']").attr("checked", true);
				$('#edit_action_kontrol_lampu option[value="' + action_kontrol_lampu + '"]').prop('selected',true);
				
				
				$("#edit_angin_untuk_rem:checkbox[value='"+angin_untuk_rem+"']").attr("checked", true);
				$('#edit_action_angin_untuk_rem option[value="' + action_angin_untuk_rem + '"]').prop('selected',true);
				
				
				$("#edit_test_mesin:checkbox[value='"+test_mesin+"']").attr("checked", true);
				$('#edit_action_test_mesin option[value="' + action_test_mesin + '"]').prop('selected',true);
				
				
				$("#edit_kondisi_body_truck:checkbox[value='"+kondisi_body_truck+"']").attr("checked", true);
				$('#edit_action_kondisi_body_truck option[value="' + action_kondisi_body_truck + '"]').prop('selected',true);
				
				
				$("#edit_kecukupan_isi_solar:checkbox[value='"+kecukupan_isi_solar+"']").attr("checked", true);
				$('#edit_action_kecukupan_isi_solar option[value="' + action_kecukupan_isi_solar + '"]').prop('selected',true);
				
				
				$("#edit_kelengkapan_safety:checkbox[value='"+kelengkapan_safety+"']").attr("checked", true);
				$('#edit_action_kelengkapan_safety option[value="' + action_kelengkapan_safety + '"]').prop('selected',true);
				
				
				$("#edit_kelengkapan_document:checkbox[value='"+kelengkapan_document+"']").attr("checked", true);
				$('#edit_action_kelengkapan_document option[value="' + action_kelengkapan_document + '"]').prop('selected',true);
				
			});
			
			
			
			$(".detail_data").click(function(){
				var id = $(this).attr('id');
				var date_absence =  $('#data_'+id+' .date_absence').text();
				var vehicle_id =  $('#data_'+id+' .vehicle_id').text();
				var driver_name =  $('#data_'+id+' .driver_name').text();
				var driver_code =  $('#data_'+id+' .driver_code').text();
				var shift =  $('#data_'+id+' span.shift').text();
				var shift_description =  $('#data_'+id+'  span.shift_description').text();
				var kelengkapan_oli_mesin =  $('#data_'+id+' .data_detail_truck_absent span.kelengkapan_oli_mesin').text();
				var action_kelengkapan_oli_mesin =  $('#data_'+id+' .data_detail_truck_absent span.action_kelengkapan_oli_mesin').text();
	
				var kecukupan_air_radioator =  $('#data_'+id+' .data_detail_truck_absent span.kecukupan_air_radioator').text();
				var action_kecukupan_air_radioator =  $('#data_'+id+' .data_detail_truck_absent span.action_kecukupan_air_radioator').text();
				var kondisi_ban =  $('#data_'+id+' .data_detail_truck_absent span.kondisi_ban').text();
				var action_kondisi_ban =  $('#data_'+id+' .data_detail_truck_absent span.action_kondisi_ban').text();
				var kondisi_accu =  $('#data_'+id+' .data_detail_truck_absent span.kondisi_accu').text();
				var action_kondisi_accu =  $('#data_'+id+' .data_detail_truck_absent span.action_kondisi_accu').text();
				var kontrol_lampu =  $('#data_'+id+' .data_detail_truck_absent span.kontrol_lampu').text();
				var action_kontrol_lampu =  $('#data_'+id+' .data_detail_truck_absent span.action_kontrol_lampu').text();
				var angin_untuk_rem =  $('#data_'+id+' .data_detail_truck_absent span.angin_untuk_rem').text();
				var action_angin_untuk_rem =  $('#data_'+id+' .data_detail_truck_absent span.action_angin_untuk_rem').text();
				var test_mesin =  $('#data_'+id+' .data_detail_truck_absent span.test_mesin').text();
				var action_test_mesin =  $('#data_'+id+' .data_detail_truck_absent span.action_test_mesin').text();
				var kondisi_body_truck =  $('#data_'+id+' .data_detail_truck_absent span.kondisi_body_truck').text();
				var action_kondisi_body_truck =  $('#data_'+id+' .data_detail_truck_absent span.action_kondisi_body_truck').text();
				var kecukupan_isi_solar =  $('#data_'+id+' .data_detail_truck_absent span.kecukupan_isi_solar').text();
				var action_kecukupan_isi_solar =  $('#data_'+id+' .data_detail_truck_absent span.action_kecukupan_isi_solar').text();
				var kelengkapan_safety =  $('#data_'+id+' .data_detail_truck_absent span.kelengkapan_safety').text();
				var action_kelengkapan_safety =  $('#data_'+id+' .data_detail_truck_absent span.action_kelengkapan_safety').text();
				var kelengkapan_document =  $('#data_'+id+' .data_detail_truck_absent span.kelengkapan_document').text();
				var action_kelengkapan_document =  $('#data_'+id+' .data_detail_truck_absent span.action_kelengkapan_document').text();
				
				$("#detail_date_absence").text(date_absence);
				$("#detail_vehicle_id").text(vehicle_id);
				$("#detail_driver_name").text(driver_name);
				$("#detail_driver_code").text(driver_code);
				$("#detail_shift").text("Shift "+shift+ " - "+shift_description);
				$("#detail_kelengkapan_oli_mesin").text(kelengkapan_oli_mesin);
				$("#detail_action_kelengkapan_oli_mesin").text(action_kelengkapan_oli_mesin);
				$("#detail_kecukupan_air_radioator").text(kecukupan_air_radioator);
				$("#detail_action_kecukupan_air_radioator").text(action_kecukupan_air_radioator);
				$("#detail_kondisi_ban").text(kondisi_ban);
				$("#detail_action_kondisi_ban").text(action_kondisi_ban);
				$("#detail_kondisi_accu").text(kondisi_accu);
				$("#detail_action_kondisi_accu").text(action_kondisi_accu);
				$("#detail_kontrol_lampu").text(kontrol_lampu);
				$("#detail_action_kontrol_lampu").text(action_kontrol_lampu);
				$("#detail_angin_untuk_rem").text(angin_untuk_rem);
				$("#detail_action_angin_untuk_rem").text(action_angin_untuk_rem);
				$("#detail_test_mesin").text(test_mesin);
				$("#detail_action_test_mesin").text(action_test_mesin);
				$("#detail_kondisi_body_truck").text(kondisi_body_truck);
				$("#detail_action_kondisi_body_truck").text(action_kondisi_body_truck);
				$("#detail_kecukupan_isi_solar").text(kecukupan_isi_solar);
				$("#detail_action_kecukupan_isi_solar").text(action_kecukupan_isi_solar);
				$("#detail_kelengkapan_safety").text(kelengkapan_safety);
				$("#detail_action_kelengkapan_safety").text(action_kelengkapan_safety);
				$("#detail_kelengkapan_document").text(kelengkapan_document);
				$("#detail_action_kelengkapan_document").text(action_kelengkapan_document);
				
			});

			$("#form_add_data").validate({
				
				messages: {
				driver_name: {
				required: 'Driver Name must be filled!'
				},
				driver_code: {
				required: 'Driver Code must be filled!'
				},
				vehicle_id: {
				required: 'vehicle ID must be filled!'
				}
				,
				id_shift: {
				required: 'Shift must be filled!'
				}
			}
			});
			
			
			
			$("#form_edit_data").validate({
				rules: {
				edit_password2: {
				  equalTo: "#edit_password1"
				}
				},
				messages: {
				edit_driver_name: {
				required: 'Driver Name must be filled!'
				},
				edit_driver_code: {
				required: 'Driver Code must be filled!'
				}
				
			}
			});
			
			
			
			$("#form_import_data").validate({
				rules: {
				import_file: {
				  required: true,
					extension: "xls|xlsx|csv"
				}
				},
				messages: {
				import_file: {
				required: 'Choose file must be filled!'
				}
			}
			});
	
	

		
  
  </script>  
		
  <script>

 
//  Usage:
//  $(function() {
//
//    // In this case the initialization function returns the already created instance
//    var inst = $('[data-remodal-id=modal]').remodal();
//
//    inst.open();
//    inst.close();
//    inst.getState();
//    inst.destroy();
//  });

  //  The second way to initialize:
  $('[data-remodal-id=modal2]').remodal({
    modifier: 'with-red-theme'
  });
</script>

<script>
window.location.hash="";


$(".deletelogg").on('click', function () {
    var ids = [];
    $(".toedit").each(function () {
        if ($(this).is(":checked")) {
            ids.push($(this).val());
        }
    });
    if (ids.length) {
        
		$('[data-remodal-id = modal_delete_all]').remodal().open();
		$("#id_absent_delete_all").val(ids);
		
    } else {
        alert("Please select items.");
    }
});



$(document).on('change', '#select_all', function() {

    $(".checkbox_satuan").prop('checked', $(this).prop("checked"));
});

$("#add-data").click(function(){
	$("#form_add_data").trigger('reset');
	$('[data-remodal-id = modal_add]').remodal().open();
	
	var validator = $( "#form_add_data" ).validate();
	validator.resetForm();
	
});

$("#import-data").click(function(){
	$("#form_import_data").trigger('reset');
	$('[data-remodal-id = modal_import]').remodal().open();
	
	var validator = $( "#form_import_data" ).validate();
	validator.resetForm();
});

$(".delete_data").click(function(){
	$('[data-remodal-id = modal_delete]').remodal().open();
});

$(".edit_data").click(function(){
	$('[data-remodal-id = modal_edit]').remodal().open();
	var validator = $( "#form_edit_data" ).validate();
	validator.resetForm();
});


$(".detail_data").click(function(){
	$('[data-remodal-id = modal_detail]').remodal().open();
});

</script>


	<script>
		//auto complete Vehicle
        $( "#search_vehicle_id" ).autocomplete({
         source: "<?php echo BASE_URL(); ?>/index.php/json/jsonMasterUnit",  
         minLength:0,
		 select: function( event , ui ) {
			  $( "#vehicle_id" ).val(ui.item.label);
			  $(this).val('');
			  return false;
			  
        }    
        })
		.autocomplete( "instance" )._renderItem = function( ul, item ) {
		  return $( "<li style='position:relative; z-index:9999;'>" )
			.append( "<div style='font-size:10px;'>" + item.label +"</div>" )
			.appendTo( ul );
		};
		
		
		//auto complete Driver
        $( "#search_driver" ).autocomplete({
         source: "<?php echo BASE_URL(); ?>/index.php/json/jsonDriver",  
         minLength:0,
		 select: function( event , ui ) {
			  $( "#driver_code" ).val(ui.item.driver_code);
			  $( "#driver_name" ).val(ui.item.driver_name);
			  $(this).val('');
			  return false;
			  
        }    
        })
		.autocomplete( "instance" )._renderItem = function( ul, item ) {
		  return $( "<li style='position:relative; z-index:9999;'>" )
			.append( "<div style='font-size:10px;'>" + item.label +"</div>" )
			.appendTo( ul );
		};
		</script>
		
		
		<script>
		//auto complete Vehicle Edit
        $( "#edit_search_vehicle_id" ).autocomplete({
         source: "<?php echo BASE_URL(); ?>/index.php/json/jsonMasterUnit",  
         minLength:0,
		 select: function( event , ui ) {
			  $( "#edit_vehicle_id" ).val(ui.item.label);
			  $(this).val('');
			  return false;
			  
        }    
        })
		.autocomplete( "instance" )._renderItem = function( ul, item ) {
		  return $( "<li style='position:relative; z-index:9999;'>" )
			.append( "<div style='font-size:10px;'>" + item.label +"</div>" )
			.appendTo( ul );
		};
		
		
		//auto complete Driver
        $( "#edit_search_driver" ).autocomplete({
         source: "<?php echo BASE_URL(); ?>/index.php/json/jsonDriver",  
         minLength:0,
		 select: function( event , ui ) {
			  $( "#edit_driver_code" ).val(ui.item.driver_code);
			  $( "#edit_driver_name" ).val(ui.item.driver_name);
			  $(this).val('');
			  return false;
			  
        }    
        })
		.autocomplete( "instance" )._renderItem = function( ul, item ) {
		  return $( "<li style='position:relative; z-index:9999;'>" )
			.append( "<div style='font-size:10px;'>" + item.label +"</div>" )
			.appendTo( ul );
		};
		</script>