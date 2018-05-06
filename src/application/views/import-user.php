 <!-- HEADER -->
 <section class="content-header">
          <h1>
           User
            <small>Import USer Account</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="<?php echo BASE_URL(); ?>"><i class="fa fa-dashboard"></i>Home</a></li>
            <li><a href="<?php echo BASE_URL()."user_account/importUserAccount"; ?>"><i class="fa fa-dashboard"></i>Import User Account</a></li>
          </ol>
        </section>
  
  
   <!-- Content -->
   <section class="content">
          <div class="box sms box-default color-palette-box">
            <div class="box-header with-border">
              <h3 class="box-title"><i class="fa fa-edit"></i> Form Import User Account</h3>
            </div>
            <div class="box-body">
                      
                  <form role="form" action="<?php echo site_url('user_account/doImportUser')?>" method="post" enctype="multipart/form-data">
                  <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                  <div class="box-body">
                    
                    <div class="form-group">
                      <label for="exampleInputEmail1">Choose File</label>
                      <input type="file" name="import" id="import" class="form-control" value="" />
               
                    </div>
                    
                    <div class="form-group">
                    <p><a target="_blank" href="<?php echo base_url('/files/example-files/import-distributor.xlsx')?>">Download sample file import distributor</a></p>
                    </div>
                   
                  </div><!-- /.box-body -->
                  <div class="box-footer">
                    <button type="submit" class="btn btn-primary" name="save">Submit</button>
                  </div>
                  </form>
            
           </div>
            </div>
            
            </div>
      </section>

