 <!-- HEADER -->
 <section class="content-header">
          <h1>
            Motorist
            <small>Add Product</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="<?php echo BASE_URL(); ?>"><i class="fa fa-dashboard"></i>Home</a></li>
            <li><a href="<?php echo BASE_URL()."product/addProduct"; ?>"><i class="fa fa-dashboard"></i>Add Product</a></li>
          </ol>
        </section>
  
  
   <!-- Content -->
   <section class="content">
          <div class="box sms box-default color-palette-box">
            <div class="box-header with-border">
              <h3 class="box-title"><i class="fa fa-edit"></i> Form Add Product</h3>
            </div>
            <div class="box-body">
           			  <?php if(validation_errors()){ ?>
                      <div class="error-box">
                      <?php echo validation_errors() ?>
                      </div>
                      <?php } ?>
                      
                  <form role="form" action="<?php echo site_url('motorist/addMotorist')?>" method="post" enctype="multipart/form-data">
                  <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                  <div class="box-body">
                    
                    <div class="form-group">
                      <label for="exampleInputEmail1">Motorist Code</label>
                      <input type="text" name="motorist_code" id="motorist_code" class="form-control <?php if (form_error('motorist_code')) { echo 'error'; } ?>" value="<?php echo set_value('motorist_code'); ?>" />
                      <?php echo form_error('motorist_code'); ?>
                    </div>
                    
                    
                    <div class="form-group">
                      <label for="exampleInputEmail1">Motorist Name</label>
                      <input type="text" name="motorist_name" id="motorist_name" class="form-control <?php if (form_error('motorist_name')) { echo 'error'; } ?>" value="<?php echo set_value('motorist_name'); ?>" />
                      <?php echo form_error('motorist_name'); ?>
                    </div>
                    
                    
                     <div class="form-group">
                      <label for="exampleInputEmail1">Motorist Type</label>
                      <select name="motorist_type" class="form-control <?php if (form_error('motorist_type')) { echo 'error'; } ?>">
                      	<option value="">Choose Motoris Type</option>
                      	<?php foreach($data_motorist as $data_motorist){?>
                        <option value="<?php echo $data_motorist['id_motorist_type']; ?>" <?php if(set_value('motorist_type')==$data_motorist['id_motorist_type']){echo"selected=selected";} ?>><?php echo $data_motorist['motorist_type'].'-'.$data_motorist['description']; ?></option>
                        <?php } ?>
                      </select>
                        <?php echo form_error('motorist_type'); ?>
                    </div>
                    
                   
                   <div class="form-group">
                      <label for="exampleInputEmail1">Distributor</label>
                      <select name="distributor_code" class="form-control <?php if (form_error('distributor_code')) { echo 'error'; } ?>">
                      	<option value="">Choose Distributor</option>
                      	<?php foreach($data_distributor as $data_distributor){?>
                        <option value="<?php echo $data_distributor->distributor_code; ?>" <?php if(set_value('distributor_code')==$data_distributor->distributor_code){echo"selected=selected";} ?>><?php echo $data_distributor->distributor_name.' - '.$data_distributor->distributor_code ?></option>
                        <?php } ?>
                      </select>
                        <?php echo form_error('distributor_code'); ?>
                    </div>
                   
                   
                   <div class="form-group">
                      <label for="exampleInputEmail1">Daily Target Sales</label>
                      <input type="text" name="target_harian" id="target_harian" class="form-control <?php if (form_error('target_harian')) { echo 'error'; } ?>" value="<?php echo set_value('target_harian'); ?>" />
                      <?php echo form_error('target_harian'); ?>
                    </div>
                    
                    
                    <div class="form-group">
                      <label for="exampleInputEmail1">Monthly Target Sales</label>
                      <input type="text" name="target_bulanan" id="target_bulanan" class="form-control <?php if (form_error('target_bulanan')) { echo 'error'; } ?>" value="<?php echo set_value('target_bulanan'); ?>" />
                      <?php echo form_error('target_bulanan'); ?>
                    </div>
                   
                   
                   <div class="form-group">
                      <label for="exampleInputEmail1">Password</label>
                      <input type="password" name="password" id="password" class="form-control <?php if (form_error('password')) { echo 'error'; } ?>" value="<?php echo set_value('password'); ?>" />
                      <?php echo form_error('password'); ?>
                    </div>
                    
                    
                    <div class="form-group">
                      <label for="exampleInputEmail1">Retype Password</label>
                      <input type="password" name="re_password" id="re_password" class="form-control <?php if (form_error('re_password')) { echo 'error'; } ?>" value="<?php echo set_value('re_password'); ?>" />
                      <?php echo form_error('re_password'); ?>
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

