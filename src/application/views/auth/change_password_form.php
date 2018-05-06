<?php
$old_password = array(
	'name'	=> 'old_password',
	'id'	=> 'old_password',
	'value' => set_value('old_password'),
	'size' 	=> 30,
	'AutoComplete' => 'off',
	'class' => 'form-control',
);
$new_password = array(
	'name'	=> 'new_password',
	'id'	=> 'new_password',
	'maxlength'	=> $this->config->item('password_max_length', 'tank_auth'),
	'size'	=> 30,
	'AutoComplete' => 'off',
	'class' => 'form-control'
);
$confirm_new_password = array(
	'name'	=> 'confirm_new_password',
	'id'	=> 'confirm_new_password',
	'maxlength'	=> $this->config->item('password_max_length', 'tank_auth'),
	'size' 	=> 30,
	'AutoComplete' => 'off',
	'class' => 'form-control'
);
?>
<?php echo form_open($this->uri->uri_string()); ?>

<div class="row">
<div class="col-lg-12">
<div class="content-panel" style="min-height:500px;">
  <h4 class="mb"> Change Password</h4> 
                     
                      <div class="wrapper-form-box"> 
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
                     
<style>
.change_password{
	margin-bottom:20px;}
</style>
<form class="form-horizontal style-form" id="formAdd" action="<?php echo site_url('auth/change_password')?>" method="post" role="form">
                         
                          <div class="form-group change_password">
                              <label class="col-sm-2 col-sm-2 control-label">Old Password</label>
                              <div class="col-sm-10">
                                  <?php echo form_password($old_password); ?>
                                  <label><?php echo form_error($old_password['name']); ?><?php echo isset($errors[$old_password['name']])?$errors[$old_password['name']]:''; ?></label>
                              </div>
                          </div>

                          
                          <div class="form-group change_password">
                              <label class="col-sm-2 col-sm-2 control-label">New Password</label>
                              <div class="col-sm-10">
                                  <?php echo form_password($new_password); ?>
                                  <label><?php echo form_error($new_password['name']); ?><?php echo isset($errors[$new_password['name']])?$errors[$new_password['name']]:''; ?></label>
                              </div>
                          </div>
                        

                          <div class="form-group change_password">
                              <label class="col-sm-2 col-sm-2 control-label">Retype New Password</label>
                              <div class="col-sm-10">
                                  <?php echo form_password($confirm_new_password); ?>
                              	  <label><?php echo form_error($confirm_new_password['name']); ?><?php echo isset($errors[$confirm_new_password['name']])?$errors[$confirm_new_password['name']]:''; ?></label>
                              </div>
                          </div>
                          
                          
                         
                          
                          <div class="form-group" style="border-bottom:0;">
                              <label class="col-sm-2 col-sm-2 control-label"></label>
                              <div class="col-sm-10">
                                  <input type="submit"  value="Change Password" class="btn btn-success" name="save" />
                              </div>
                          </div>
                          
                      </form>

</div>
</div>



</div><!-- col-lg-12-->  
</div><!-- row -->



