 <!-- HEADER -->
 <section class="content-header">
          <h1>
            Motorist
            <small>Delete Motorist</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="<?php echo BASE_URL(); ?>"><i class="fa fa-dashboard"></i>Home</a></li>
            <li><a href="<?php echo BASE_URL()."motorist/deleteMotorist/"; ?>"><i class="fa fa-dashboard"></i>Delete Motorist</a></li>
          </ol>
        </section>
  
  
   <!-- Content -->
   <section class="content">
          <div class="box sms box-default color-palette-box">
            <div class="box-header with-border">
              <h3 class="box-title"><i class="fa fa-edit"></i> Delete Motorist</h3>
            </div>
            <div class="box-body">
            
           		<?php
			function convert_price($price)
			{
				echo "Rp. ".number_format($price, 0 , '' , '.' );		
					}
			?>
                      
                  <form role="form" action="<?php echo site_url('motorist/deleteMotorist')?>" method="post" enctype="multipart/form-data">
                  <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                  <p>Are you sure want to delete this motorist?</p>
                  
                  <table id="example2" class="table table-bordered table-hover">
                    <thead>
                      <tr>
                        <th>ID Motorist</th>
                        <th>Motorist code</th>
                        <th>Motorist Name</th>
                        <th>Distributor Code</th>
                        <th>Distributor Name</th>
                        <th>Motorist Type</th>
                      </tr>
                    </thead>
             		<tbody>
                    
                    <tr>
                    	<td><?php print $data_motorist[0]['id_motorist']; ?></td>
                        <td><?php print $data_motorist[0]['motorist_code']; ?></td>
                        <td><?php print $data_motorist[0]['motorist_name']; ?></td>
                        <td><?php print $data_motorist[0]['distributor_code']; ?></td>
                        <td><?php print $data_motorist[0]['distributor_name']; ?></td>
                        <td><?php print $data_motorist[0]['motorist_type']; ?></td>
                        </tr>
                  
                    </tbody>       
             </table>
             
                  <div class="box-footer">
                  	<input type="hidden" name="id_motorist" id="id_motorist" value="<?php print $data_motorist[0]['id_motorist']; ?>">
                    <button type="submit" class="btn btn-red">Delete Motorist</button>
                    <a href="<?php echo site_url('motorist')?>" class="btn btn-blue">Cancel</a>
                  </div>
                </form>
            
           </div>
            </div>
            
            </div>
      </section>

