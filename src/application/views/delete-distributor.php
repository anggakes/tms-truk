 <!-- HEADER -->
 <section class="content-header">
          <h1>
            Distributor
            <small>Delete Distributor</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="<?php echo BASE_URL(); ?>"><i class="fa fa-dashboard"></i>Home</a></li>
            <li><a href="<?php echo BASE_URL()."channel/deleteChannel/".$id_distributor; ?>"><i class="fa fa-dashboard"></i>Delete Distributor</a></li>
          </ol>
        </section>
  
  
   <!-- Content -->
   <section class="content">
          <div class="box sms box-default color-palette-box">
            <div class="box-header with-border">
              <h3 class="box-title"><i class="fa fa-edit"></i> Delete Distributor</h3>
            </div>
            <div class="box-body">
            
           		<?php
			function convert_price($price)
			{
				echo "Rp. ".number_format($price, 0 , '' , '.' );		
					}
			?>
                      
                  <form role="form" action="<?php echo site_url('distributor/deleteDistributor')?>" method="post" enctype="multipart/form-data">
                  <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                  <p>Are you sure want to delete this distributor?</p>
                  
                 	<table id="example2" class="table table-bordered table-hover">
                    <thead>
                      <tr>
                        <th>ID Distributor</th>
                        <th>Regional</th>
                        <th>Area</th>
                        <th>Distributor Code</th>
                        <th>Distributor Name</th>
                      </tr>
                    </thead>
             		<tbody>
                    <tr>
                    	<td><?php echo $id_distributor; ?></td>
                        <td><?php echo $regional; ?></td>
                        <td><?php echo $area; ?></td>
                        <td><?php echo $distributor_code; ?></td>
                        <td><?php echo $distributor_name; ?></td>
                        </tr>
                    </tbody>       
             </table>
             
                  <div class="box-footer">
                  	<input type="hidden" name="id_distributor" id="id_distributor" value="<?php echo $id_distributor; ?>">
                    <button type="submit" class="btn btn-red">Delete Channel</button>
                    <a href="<?php echo site_url('distributor')?>" class="btn btn-blue">Cancel</a>
                  </div>
                </form>
            
           </div>
            </div>
            
            </div>
      </section>

