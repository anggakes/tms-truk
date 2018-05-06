 <!-- HEADER -->
 <section class="content-header">
          <h1>
            Store
            <small>Add Store</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="<?php echo BASE_URL(); ?>"><i class="fa fa-dashboard"></i>Home</a></li>
            <li><a href="<?php echo BASE_URL()."store/addStore"; ?>"><i class="fa fa-dashboard"></i>Add Store</a></li>
          </ol>
        </section>
  
  
   <!-- Content -->
   <section class="content">
          <div class="box sms box-default color-palette-box">
            <div class="box-header with-border">
              <h3 class="box-title"><i class="fa fa-edit"></i> Form Add Store</h3>
            </div>
            <div class="box-body">
            
           		<?php if(validation_errors()){ ?>
                      <div class="error-box">
                      <?php echo validation_errors() ?>
                      </div>
                      <?php } ?>
                      
                  <form role="form" action="<?php echo site_url('store/addStore')?>" method="post" enctype="multipart/form-data">
                  <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                  <div class="box-body">
             
                    
                    
                    <div class="form-group">
                      <label for="exampleInputEmail1">Motorist</label>
                      <select name="motorist_code" class="form-control <?php if (form_error('motorist_code')) { echo 'error'; } ?>">
                      	<option value="">Choose Motorist</option>
                      	<?php foreach($data_motorist as $data_motorist){?>
                        <option value="<?php echo $data_motorist->motorist_code; ?>" <?php if(set_value('motorist_code')==$data_motorist->motorist_code){echo"selected=selected";} ?>><?php echo $data_motorist->motorist_name.' - '.$data_motorist->motorist_code ?></option>
                        <?php } ?>
                      </select>
                        <?php echo form_error('motorist_code'); ?>
                    </div>
                    
                    
                    
                    <div class="form-group">
                      <label for="exampleInputEmail1">Day Visit</label>
                      <select name="day_visit" class="form-control <?php if (form_error('day_visit')) { echo 'error'; } ?>">
                      	<option value="">Choose Day</option>
                        <option value="Monday" <?php if(set_value('day_visit')=='Monday'){echo"selected=selected";} ?>>Monday</option>
            			<option value="Tuesday" <?php if(set_value('day_visit')=='Tuesday'){echo"selected=selected";} ?>>Tuesday</option>
                        <option value="Wednesday" <?php if(set_value('day_visit')=='Wednesday'){echo"selected=selected";} ?>>Wednesday</option>
                        <option value="Thursday" <?php if(set_value('day_visit')=='Thursday'){echo"selected=selected";} ?>>Thusrday</option>
                        <option value="Friday" <?php if(set_value('day_visit')=='Friday'){echo"selected=selected";} ?>>Friday</option>
                        <option value="Saturday" <?php if(set_value('day_visit')=='Saturday'){echo"selected=selected";} ?>>Saturday</option>
                      </select>
                        <?php echo form_error('day_visit'); ?>
                    </div>
                    
                    
                    <div class="form-group">
                      <label for="exampleInputEmail1">Channel</label>
                      <select name="channel" class="form-control <?php if (form_error('channel')) { echo 'error'; } ?>">
                      	<option value="">Choose Channel</option>
                      	<?php foreach($data_channel as $data_channel){?>
                        <option value="<?php echo $data_channel->classification_code; ?>" <?php if(set_value('channel')==$data_channel->classification_code){echo"selected=selected";} ?>><?php echo $data_channel->channel_description.' - '.$data_channel->classification_code ?></option>
                        <?php } ?>
                      </select>
                        <?php echo form_error('channel'); ?>
                    </div>
                    
                    <div class="form-group">
                      <label for="exampleInputEmail1">Frequency</label>
                      <select name="frequency" class="form-control <?php if (form_error('frequency')) { echo 'error'; } ?>">
                      	<option value="">Choose Frequency</option>
                        <option value="f4" <?php if(set_value('frequency')=='f4'){echo"selected=selected";} ?>>Once a week</option>
                        <option value="f2" <?php if(set_value('frequency')=='f2'){echo"selected=selected";} ?>>Twice a week</option>
                      </select>
                        <?php echo form_error('frequency'); ?>
                    </div>
                    
                    <div class="form-group">
                      <label for="exampleInputEmail1">Customer Name</label>
                      <input type="text" name="customer_name" id="customer_name" class="form-control <?php if (form_error('customer_name')) { echo 'error'; } ?>" value="<?php echo set_value('customer_name'); ?>" />
                      <?php echo form_error('customer_name'); ?>
                    </div>
                    
                    <div class="form-group">
                      <label for="exampleInputEmail1">Customer Code / Store Code</label>
                      <input type="text" name="customer_code" id="customer_code" class="form-control <?php if (form_error('customer_code')) { echo 'error'; } ?>" value="<?php echo set_value('customer_code'); ?>" />
                      <?php echo form_error('customer_code'); ?>
                    </div>
                    
                    
                    <div class="form-group">
                      <label for="exampleInputEmail1">Customer Contact</label>
                      <input type="text" name="customer_contact" id="customer_contact" class="form-control <?php if (form_error('customer_contact')) { echo 'error'; } ?>" value="<?php echo set_value('customer_contact'); ?>" />
                      <?php echo form_error('customer_contact'); ?>
                    </div>
                    
                     <div class="form-group">
                      <label for="exampleInputEmail1">Customer Status</label>
                      <select name="customer_status" class="form-control <?php if (form_error('customer_status')) { echo 'error'; } ?>">
                      	<option value="">Choose Customer Status</option>
                        <option value="active" <?php if(set_value('customer_status')=='active'){echo"selected=selected";} ?>>Active</option>
                        <option value="no_active" <?php if(set_value('customer_status')=='non_active'){echo"selected=selected";} ?>>Non Active</option>
                      </select>
                        <?php echo form_error('customer_status'); ?>
                    </div>
                    
                     <div class="form-group">
                      <label for="exampleInputEmail1">Place Status</label>
                      <select name="place_status" class="form-control <?php if (form_error('customer_status')) { echo 'error'; } ?>">
                      	<option value="">Choose Place Status</option>
                        <option value="permanent" <?php if(set_value('place_status')=='permanent'){echo"selected=selected";} ?>>Permanent</option>
                        <option value="mobile" <?php if(set_value('place_status')=='mobile'){echo"selected=selected";} ?>>Mobile</option>
                      </select>
                        <?php echo form_error('place_status'); ?>
                    </div>
                    
                     <div class="form-group">
                      <label for="exampleInputEmail1">Address</label>
                      <input type="text" name="address" id="address" class="form-control <?php if (form_error('address')) { echo 'error'; } ?>" value="<?php echo set_value('address'); ?>" />
                      <?php echo form_error('address'); ?>
                    </div>
                    
                    <div class="form-group">
                      <label for="exampleInputEmail1">District</label>
                      <input type="text" name="district" id="district" class="form-control <?php if (form_error('district')) { echo 'error'; } ?>" value="<?php echo set_value('district'); ?>" />
                      <?php echo form_error('district'); ?>
                    </div>
                    
                    <div class="form-group">
                      <label for="exampleInputEmail1">Latitude</label>
                      <input type="text" name="latitude" id="latitude" class="form-control <?php if (form_error('latitude')) { echo 'error'; } ?>" value="<?php echo set_value('latitude'); ?>" />
                      <?php echo form_error('latitude'); ?>
                    </div>
                    
                    <div class="form-group">
                      <label for="exampleInputEmail1">Longitude</label>
                      <input type="text" name="longitude" id="longitude" class="form-control <?php if (form_error('longitude')) { echo 'error'; } ?>" value="<?php echo set_value('longitude'); ?>" />
                      <?php echo form_error('longitude'); ?>
                    </div>
                    
                    <div class="form-group">
                      <label for="exampleInputEmail1">QR Code Status</label>
                      <select name="status_qr_code" class="form-control <?php if (form_error('status_qr_code')) { echo 'error'; } ?>">
                      	<option value="">Choose Qr Code Status</option>
                        <option value="Yes" <?php if(set_value('status_qr_code')=='Yes'){echo"selected=selected";} ?>>Yes</option>
                        <option value="No" <?php if(set_value('status_qr_code')=='No'){echo"selected=selected";} ?>>No</option>
                      </select>
                        <?php echo form_error('status_qr_code'); ?>
                    </div>
                    
                   
                   
                   
                  </div><!-- /.box-body -->

                  <div class="box-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                  </div>
                </form>
            
           </div>
            </div>
            
            </div>
      </section>

