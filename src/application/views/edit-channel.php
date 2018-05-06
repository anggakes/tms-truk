 <!-- HEADER -->
 <section class="content-header">
          <h1>
            Channel
            <small>Edit Channel</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="<?php echo BASE_URL(); ?>"><i class="fa fa-dashboard"></i>Home</a></li>
            <li><a href="<?php echo BASE_URL()."channel/editChannel"; ?>"><i class="fa fa-dashboard"></i>Edit Channel</a></li>
          </ol>
        </section>
  
  
   <!-- Content -->
   <section class="content">
          <div class="box sms box-default color-palette-box">
            <div class="box-header with-border">
              <h3 class="box-title"><i class="fa fa-edit"></i> Form Add Channel</h3>
            </div>
            <div class="box-body">
            
           		<?php if(validation_errors()){ ?>
                      <div class="error-box">
                      <?php echo validation_errors() ?>
                      </div>
                      <?php } ?>
                      
                  <form role="form" action="<?php echo site_url('channel/editChannel')?>" method="post" enctype="multipart/form-data">
                  <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                  <div class="box-body">
                    
                    <div class="form-group">
                      <label for="exampleInputEmail1">Classification Code</label>
                      <input type="text" name="classification_code" id="classification_code" class="form-control <?php if (form_error('classification_code')) { echo 'error'; } ?>" value="<?php if(! set_value('classification_code')){echo $classification_code;}else{echo set_value('classification_code');}; ?>" />
                      <?php echo form_error('classification_code'); ?>
                    </div>
                    
                    <div class="form-group">
                      <label for="exampleInputEmail1">Channel Description</label>
                      <input type="text" name="channel_description" id="channel_description" class="form-control <?php if (form_error('channel_description')) { echo 'error'; } ?>" value="<?php if(! set_value('channel_description')){echo $channel_description;}else{echo set_value('channel_description');}; ?>" />
                      <?php echo form_error('channel_description'); ?>
                    </div>
                    
                    <div class="form-group">
                      <label for="exampleInputEmail1">Sample</label>
                      <input type="text" name="sample" id="sample" class="form-control <?php if (form_error('sample')) { echo 'error'; } ?>" value="<?php if(! set_value('sample')){echo $sample;}else{echo set_value('sample');}; ?>" />
                      <?php echo form_error('sample'); ?>
                    </div>
                    
                   
                   
                   
                  </div><!-- /.box-body -->

                  <div class="box-footer">
                  	<input type="hidden" name="id_channel" id="id_channel" value="<?php echo $id_channel; ?>">
                    <button type="submit" class="btn btn-primary">Update Channel</button>
                    <a href="<?php echo site_url("channel/channel"); ?>" class="btn btn-blue">Cancel Update</a>
                  </div>
                </form>
            
           </div>
            </div>
            
            </div>
      </section>

