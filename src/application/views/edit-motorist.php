 <!-- HEADER -->
 <section class="content-header">
          <h1>
            Motorist
            <small>Edit Motorist</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="<?php echo BASE_URL(); ?>"><i class="fa fa-dashboard"></i>Home</a></li>
            <li><a href="<?php echo BASE_URL()."motorist/editMotorist"; ?>"><i class="fa fa-dashboard"></i>Edit Motorist</a></li>
          </ol>
        </section>
  
  
   <!-- Content -->
   <section class="content">
          <div class="box sms box-default color-palette-box">
            <div class="box-header with-border">
              <h3 class="box-title"><i class="fa fa-edit"></i> Form Add Motorist</h3>
            </div>
            <div class="box-body">
            
           		<?php if(validation_errors()){ ?>
                      <div class="error-box">
                      <?php echo validation_errors() ?>
                      </div>
                      <?php } ?>
                  <form role="form" action="<?php echo site_url('motorist/editMotorist')?>" method="post" enctype="multipart/form-data">
                  <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                  <div class="box-body">
                    
                    <div class="form-group">
                      <label for="exampleInputEmail1">Motorist Code</label>
                      <input type="text" name="motorist_code" id="motorist_code" class="form-control <?php if (form_error('motorist_code')) { echo 'error'; } ?>" value="<?php if(! set_value('motorist_code')){echo $data['motorist_code'];}else{echo set_value('motorist_code');}; ?>" />
                      <?php echo form_error('motorist_code'); ?>
                    </div>
                    
                    
                    <div class="form-group">
                      <label for="exampleInputEmail1">Motorist Name</label>
                      <input type="text" name="motorist_name" id="motorist_name" class="form-control <?php if (form_error('motorist_name')) { echo 'error'; } ?>" value="<?php if(! set_value('motorist_name')){echo $data['motorist_name'];}else{echo set_value('motorist_name');}; ?>" />
                      <?php echo form_error('motorist_name'); ?>
                    </div>
                    
                    <div class="form-group">
                      <label for="exampleInputEmail1">Motorist Type</label>
                      <select name="motorist_type" class="form-control <?php if (form_error('motorist_type')) { echo 'error'; } ?>">
                      	<option value="">Choose Motoris Type</option>
                        <?php foreach($data_motorist as $data_motorist){?>
                        <option value="<?php echo $data_motorist['id_motorist_type']; ?>" <?php if(set_value('motorist_type')==$data_motorist['id_motorist_type']){echo"selected=selected";}else if($data['motorist_type']== $data_motorist['id_motorist_type'] ){echo"selected=selected";} ?>><?php echo $data_motorist['motorist_type']; ?></option>
                         <?php } ?>
                      </select>
                      <?php echo form_error('motorist_type'); ?>
                    </div>
                    
                    
                    <div class="form-group">
                      <label for="exampleInputEmail1">Distributor</label>
                      <select name="distributor_code" class="form-control <?php if (form_error('distributor_code')) { echo 'error'; } ?>">
                      	<option value="">Choose Distributor</option>
                        <?php foreach($data_distributor as $data_distributor){?>
                        <option value="<?php echo $data_distributor['distributor_code']; ?>" <?php if(set_value('distributor_code')==$data_distributor['distributor_code']){echo"selected=selected";}else if($data['distributor_code']== $data_distributor['distributor_code'] ){echo"selected=selected";} ?>><?php echo $data_distributor['distributor_name'].' - '.$data_distributor['distributor_code'] ?></option>
                         <?php } ?>
                      </select>
                      <?php echo form_error('distributor_code'); ?>
                    </div>
                    
                    
                    <div class="form-group">
                      <label for="exampleInputEmail1">Daily Target Sales</label>
                      <input type="text" name="target_harian" id="target_harian" class="form-control <?php if (form_error('target_harian')) { echo 'error'; } ?>" value="<?php if(! set_value('target_harian')){echo $data['target_harian'];}else{echo set_value('target_harian');}; ?>" />
                      <?php echo form_error('target_harian'); ?>
                    </div>
                    
                    <div class="form-group">
                      <label for="exampleInputEmail1">Monthly Target Sales</label>
                      <input type="text" name="target_bulanan" id="target_bulanan" class="form-control <?php if (form_error('target_bulanan')) { echo 'error'; } ?>" value="<?php if(! set_value('target_bulanan')){echo $data['target_bulanan'];}else{echo set_value('target_bulanan');}; ?>" />
                      <?php echo form_error('target_bulanan'); ?>
                    </div>
                    
                   <div class="form-group">
                      <label for="exampleInputEmail1">New Password (filling the password field if want to change it)</label>
                      <input type="text" name="password" id="password" class="form-control <?php if (form_error('password')) { echo 'error'; } ?>" value="<?php echo set_value('password'); ?>" />
                      <?php echo form_error('password'); ?>
                    </div>
                    
                    
                   
                   
                  </div><!-- /.box-body -->

                  <div class="box-footer">
                  	<input type="hidden" name="id_motorist" id="id_motorist" value="<?php echo $data['id_motorist']; ?>">
                    <button type="submit" class="btn btn-primary">Update Motorist</button>
                    <a href="<?php echo site_url("motorist"); ?>" class="btn btn-blue">Cancel Update</a>
                  </div>
                </form>
            
           </div>
            </div>
            
            </div>
      </section>

