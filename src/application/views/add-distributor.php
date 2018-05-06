 <!-- HEADER -->
 <section class="content-header">
          <h1>
            Distributor
            <small>Add Distributor</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="<?php echo BASE_URL(); ?>"><i class="fa fa-dashboard"></i>Home</a></li>
            <li><a href="<?php echo BASE_URL()."distributor/addDistributor"; ?>"><i class="fa fa-dashboard"></i>Add Distributor</a></li>
          </ol>
        </section>
  
  
   <!-- Content -->
   <section class="content">
          <div class="box sms box-default color-palette-box">
            <div class="box-header with-border">
              <h3 class="box-title"><i class="fa fa-edit"></i> Form Add Distributor</h3>
            </div>
            <div class="box-body">
            
           		<?php if(validation_errors()){ ?>
                      <div class="error-box">
                      <?php echo validation_errors() ?>
                      </div>
                      <?php } ?>
                      
                  <form role="form" action="<?php echo site_url('distributor/addDistributor')?>" method="post" enctype="multipart/form-data">
                  <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                  <div class="box-body">
                    
                    <div class="form-group">
                      <label for="exampleInputEmail1">Regional</label>
                      <input type="text" name="regional" id="regional" class="form-control <?php if (form_error('regional')) { echo 'error'; } ?>" value="<?php echo set_value('regional'); ?>" />
                      <?php echo form_error('regional'); ?>
                    </div>
                    
                    <div class="form-group">
                      <label for="exampleInputEmail1">Area</label>
                      <input type="text" name="area" id="area" class="form-control <?php if (form_error('area')) { echo 'error'; } ?>" value="<?php echo set_value('area'); ?>" />
                      <?php echo form_error('area'); ?>
                    </div>
                    
                    <div class="form-group">
                      <label for="exampleInputEmail1">Distributor Code</label>
                      <input type="text" name="distributor_code" id="distributor_code" class="form-control <?php if (form_error('distributor_code')) { echo 'error'; } ?>" value="<?php echo set_value('distributor_code'); ?>" />
                      <?php echo form_error('distributor_code'); ?>
                    </div>
                    
                    <div class="form-group">
                      <label for="exampleInputEmail1">Distributor Name</label>
                      <input type="text" name="distributor_name" id="distributor_name" class="form-control <?php if (form_error('distributor_name')) { echo 'error'; } ?>" value="<?php echo set_value('distributor_name'); ?>" />
                      <?php echo form_error('distributor_name'); ?>
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

