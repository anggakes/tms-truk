 <!-- HEADER -->
 <section class="content-header">
          <h1>
            Store
            <small>Edit Store</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="<?php echo BASE_URL(); ?>"><i class="fa fa-dashboard"></i>Home</a></li>
            <li><a href="<?php echo BASE_URL()."store/editStore"; ?>"><i class="fa fa-dashboard"></i>Edit Store</a></li>
          </ol>
        </section>
  
  
   <!-- Content -->
   <section class="content">
          <div class="box sms box-default color-palette-box">
            <div class="box-header with-border">
              <h3 class="box-title"><i class="fa fa-edit"></i> Form Edit Store</h3>
            </div>
            <div class="box-body">
            
           		<?php if(validation_errors()){ ?>
                      <div class="error-box">
                      <?php echo validation_errors() ?>
                      </div>
                      <?php } ?>
                      
                  <form role="form" action="<?php echo site_url('store/editStore/'.$data['id_store'])?>" method="post" enctype="multipart/form-data">
                  <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                  <div class="box-body">
             
                    
                  
                    
                    
                    <div class="form-group">
                      <label for="exampleInputEmail1">Motorist Code</label>
                      <select name="motorist_code" class="form-control <?php if (form_error('motorist_code')) { echo 'error'; } ?>">
                      	<option value="">Choose Motorist</option>
                      	<?php foreach($data_motorist as $data_motorist){?>
                        <option value="<?php echo $data_motorist->motorist_code; ?>" <?php if(set_value('motorist_code')==$data_motorist->motorist_code){echo"selected=selected";}else if($data['motorist_code']== $data_motorist->motorist_code ){echo"selected=selected";} ?>><?php echo $data_motorist->motorist_code.' - '.$data_motorist->motorist_name ?></option>
                        <?php } ?>
                      </select>
                        <?php echo form_error('motorist_code'); ?>
                    </div>
                    
                    
                    
                    
                    <div class="form-group">
                      <label for="exampleInputEmail1">Distributor Code</label>
                      <input disabled="disabled" type="text" name="distributor_code" id="distributor_code" class="form-control" value="<?php echo $data['distributor_code']; ?>" />
                    </div>
                    
                     <div class="form-group">
                      <label for="exampleInputEmail1">Distributor Name</label>
                      <input disabled="disabled" type="text" name="distributor_name" id="distributor_name" class="form-control" value="<?php echo $data['distributor_name']; ?>" />
                    </div>
                    
                    
                    <div class="form-group">
                      <label for="exampleInputEmail1">Day Visit</label>
                      <select name="day_visit" class="form-control <?php if (form_error('day_visit')) { echo 'error'; } ?>">
                      	<option value="">Choose Day</option>
                        <option value="Monday" <?php if(set_value('day_visit')=="monday"){echo"selected=selected";}else if($data['day_visit']== "monday" ){echo"selected=selected";} ?>>Monday</option>
            			<option value="Tuesday" <?php if(set_value('day_visit')=="tuesday"){echo"selected=selected";}else if($data['day_visit']== "tuesday" ){echo"selected=selected";} ?>>Tuesday</option>
                        <option value="Wednesday" <?php if(set_value('day_visit')=="wednesday"){echo"selected=selected";}else if($data['day_visit']== "wednesday" ){echo"selected=selected";} ?>>Wednesday</option>
                        <option value="Thursday" <?php if(set_value('day_visit')=="thursday"){echo"selected=selected";}else if($data['day_visit']== "thursday" ){echo"selected=selected";} ?>>Thusrday</option>
                        <option value="Friday" <?php if(set_value('day_visit')=="friday"){echo"selected=selected";}else if($data['day_visit']== "friday" ){echo"selected=selected";}?>>Friday</option>
                        <option value="Saturday" <?php if(set_value('day_visit')=="saturday"){echo"selected=selected";}else if($data['day_visit']== "saturday" ){echo"selected=selected";} ?>>Saturday</option>
                      </select>
                        <?php echo form_error('day_visit'); ?>
                    </div>
                    
                    
                    <div class="form-group">
                      <label for="exampleInputEmail1">Channel</label>
                      <select name="channel" class="form-control <?php if (form_error('channel')) { echo 'error'; } ?>">
                      	<option value="">Choose Channel</option>
                      	<?php foreach($data_channel as $data_channel){?>
                        <option value="<?php echo $data_channel->classification_code; ?>" <?php if(set_value('channel')==$data_channel->classification_code){echo"selected=selected";}else if($data['channel_code']== $data_channel->classification_code ){echo"selected=selected";} ?>><?php echo $data_channel->channel_description.' - '.$data_channel->classification_code ?></option>
                        <?php } ?>
                      </select>
                        <?php echo form_error('channel'); ?>
                    </div>
                    
                    <div class="form-group">
                      <label for="exampleInputEmail1">Frequency</label>
                      <select name="frequency" class="form-control <?php if (form_error('frequency')) { echo 'error'; } ?>">
                      	<option value="">Choose Frequency</option>
                        <option value="w" <?php if(set_value('frequency')=="w"){echo"selected=selected";}else if($data['frequency']== "w" ){echo"selected=selected";} ?>>Once a week - W</option>
                        <option value="f1" <?php if(set_value('frequency')=="f1"){echo"selected=selected";}else if($data['frequency']== "f1" ){echo"selected=selected";} ?>>Twice a week - F1</option>
                        <option value="f2" <?php if(set_value('frequency')=="f2"){echo"selected=selected";}else if($data['frequency']== "f2" ){echo"selected=selected";} ?>>Twice a week - F2</option>
                      </select>
                        <?php echo form_error('frequency'); ?>
                    </div>
                    
                    <div class="form-group">
                      <label for="exampleInputEmail1">Loyalty Store</label>
                      <select name="loyalty_store" class="form-control <?php if (form_error('loyalty_store')) { echo 'error'; } ?>">
                      	<option value="">Choose Loyalty Store</option>
                      	 <option value="1" <?php if(set_value('loyalty_store')=="1"){echo"selected=selected";}else if($data['loyalty_store']== "1" ){echo"selected=selected";} ?>>Canteen Loyalty</option>
                        <option value="2" <?php if(set_value('loyalty_store')=="2"){echo"selected=selected";}else if($data['loyalty_store']== "2" ){echo"selected=selected";} ?>>Warkop Loyalty</option>
                        <option value="3" <?php if(set_value('loyalty_store')=="3"){echo"selected=selected";}else if($data['loyalty_store']== "3" ){echo"selected=selected";} ?>>Label Redemption</option>
                        <option value="4" <?php if(set_value('loyalty_store')=="4"){echo"selected=selected";}else if($data['loyalty_store']== "4" ){echo"selected=selected";} ?>>Chiller Display</option>
                        <option value="5" <?php if(set_value('loyalty_store')=="5"){echo"selected=selected";}else if($data['loyalty_store']== "5" ){echo"selected=selected";} ?>>Chiller Loyalty</option>
                         </select>
                        <?php echo form_error('loyalty_store'); ?>
                    </div>
                    
                    <div class="form-group">
                      <label for="exampleInputEmail1">Customer Name</label>
                      <input type="text" name="customer_name" id="customer_name" class="form-control <?php if (form_error('customer_name')) { echo 'error'; } ?>" value="<?php if(! set_value('customer_name')){echo $data['customer_name'];;}else{echo set_value('customer_name');}; ?>" />
                      <?php echo form_error('customer_name'); ?>
                    </div>
                    
                    
                    <div class="form-group">
                      <label for="exampleInputEmail1">Customer Contact</label>
                      <input type="text" name="customer_contact" id="customer_contact" class="form-control <?php if (form_error('customer_contact')) { echo 'error'; } ?>" value="<?php if(! set_value('customer_contact')){echo $data['customer_contact'];;}else{echo set_value('customer_contact');}; ?>" />
                      <?php echo form_error('customer_contact'); ?>
                    </div>
                    
                     <div class="form-group">
                      <label for="exampleInputEmail1">Customer Status</label>
                      <select name="customer_status" class="form-control <?php if (form_error('customer_status')) { echo 'error'; } ?>">
                      	<option value="">Choose Customer Status</option>
                        <option value="active" <?php if(set_value('customer_status')=="active"){echo"selected=selected";}else if($data['customer_status']== "active" ){echo"selected=selected";} ?>>Active</option>
                        <option value="no_active" <?php if(set_value('customer_status')=="non_active"){echo"selected=selected";}else if($data['customer_status']== "non_active" ){echo"selected=selected";} ?>>Non Active</option>
                      </select>
                        <?php echo form_error('customer_status'); ?>
                    </div>
                    
                     <div class="form-group">
                      <label for="exampleInputEmail1">Place Status</label>
                      <select name="place_status" class="form-control <?php if (form_error('customer_status')) { echo 'error'; } ?>">
                      	<option value="">Choose Place Status</option>
                        <option value="permanent" <?php if(set_value('place_status')=="permanent"){echo"selected=selected";}else if($data['place_status']== "permanent" ){echo"selected=selected";} ?>>Permanent</option>
                        <option value="mobile" <?php if(set_value('place_status')=="mobile"){echo"selected=selected";}else if($data['place_status']== "mobile" ){echo"selected=selected";} ?>>Mobile</option>
                      </select>
                        <?php echo form_error('place_status'); ?>
                    </div>
                    
                     <div class="form-group">
                      <label for="exampleInputEmail1">Address</label>
                      <input type="text" name="address" id="address" class="form-control <?php if (form_error('address')) { echo 'error'; } ?>" value="<?php if(! set_value('address')){echo $data['address'];;}else{echo set_value('address');}; ?>" />
                      <?php echo form_error('address'); ?>
                    </div>
                    
                    <div class="form-group">
                      <label for="exampleInputEmail1">District</label>
                      <input type="text" name="district" id="district" class="form-control <?php if (form_error('district')) { echo 'error'; } ?>" value="<?php if(! set_value('district')){echo $data['districts'];}else{echo set_value('district');}; ?>" />
                      <?php echo form_error('district'); ?>
                    </div>
                    
                    <div class="form-group">
                      <label for="exampleInputEmail1">Latitude</label>
                      <input type="text" name="latitude" id="latitude" class="form-control <?php if (form_error('latitude')) { echo 'error'; } ?>" value="<?php if(! set_value('latitude')){echo $data['latitude'];;}else{echo set_value('latitude');}; ?>" />
                      <?php echo form_error('latitude'); ?>
                    </div>
                    
                    <div class="form-group">
                      <label for="exampleInputEmail1">Longitude</label>
                      <input type="text" name="longitude" id="longitude" class="form-control <?php if (form_error('longitude')) { echo 'error'; } ?>" value="<?php if(! set_value('longitude')){echo $data['longitude'];}else{echo set_value('longitude');}; ?>" />
                      <?php echo form_error('longitude'); ?>
                    </div>
                    
                    
                    <div class="form-group">
                      <label for="exampleInputEmail1">QR Code Status</label>
                      <select name="status_qr_code" class="form-control <?php if (form_error('status_qr_code')) { echo 'error'; } ?>">
                      	<option value="">Choose Qr Code Status</option>
                        <option value="yes" <?php if(set_value('status_qr_code')=="yes"){echo"selected=selected";}else if($data['status_qr_code']== "yes" ){echo"selected=selected";} ?>>Yes</option>
                        <option value="no" <?php if(set_value('status_qr_code')=="no" or set_value('status_qr_code')==""){echo"selected=selected";}else if($data['status_qr_code']== "no" or $data['status_qr_code']== "" ){echo"selected=selected";} ?>>No</option>
                      </select>
                        <?php echo form_error('status_qr_code'); ?>
                    </div>
                    
                   
                   
                   
                  </div><!-- /.box-body -->

                  <div class="box-footer">
                  	<input type="hidden" name="id_store" id="id_store" value="<?php echo $data['id_store'] ?>" />
                    <button type="submit" class="btn btn-primary">Submit</button>
                  </div>
                </form>
            
           </div>
            </div>
            
            </div>
      </section>

