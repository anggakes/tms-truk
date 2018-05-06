 <!-- HEADER -->
 <section class="content-header">
          <h1>
            Channel
            <small>Delete Channel</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="<?php echo BASE_URL(); ?>"><i class="fa fa-dashboard"></i>Home</a></li>
            <li><a href="<?php echo BASE_URL()."channel/deleteChannel/".$id_channel; ?>"><i class="fa fa-dashboard"></i>Delete Channel</a></li>
          </ol>
        </section>
  
  
   <!-- Content -->
   <section class="content">
          <div class="box sms box-default color-palette-box">
            <div class="box-header with-border">
              <h3 class="box-title"><i class="fa fa-edit"></i> Delete Channel</h3>
            </div>
            <div class="box-body">
            
           		<?php
			function convert_price($price)
			{
				echo "Rp. ".number_format($price, 0 , '' , '.' );		
					}
			?>
                      
                  <form role="form" action="<?php echo site_url('channel/deleteChannel')?>" method="post" enctype="multipart/form-data">
                  <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                  <p>Are you sure want to delete this channel?</p>
                  
                  <table id="example2" class="table table-bordered table-hover">
                    <thead>
                      <tr>
                        <th>ID Channel</th>
                        <th>Customer Outlet Classification Code</th>
                        <th>Channel Description</th>
                        <th>Sample</th>
                      </tr>
                    </thead>
             		<tbody>
                 
                    <tr>
                    	<td><?php echo $id_channel; ?></td>
                        <td><?php echo $classification_code; ?></td>
                        <td><?php echo $channel_description; ?></td>
                        <td><?php echo $sample; ?></td>
                        </tr>
                 
                    </tbody>       
             </table>
             
                  <div class="box-footer">
                  	<input type="hidden" name="id_channel" id="id_channel" value="<?php echo $id_channel; ?>">
                    <button type="submit" class="btn btn-red">Delete Channel</button>
                    <a href="<?php echo site_url('channel')?>" class="btn btn-blue">Cancel</a>
                  </div>
                </form>
            
           </div>
            </div>
            
            </div>
      </section>

