 <!-- HEADER -->
 <section class="content-header">
          <h1>
            Channel
            <small>Delete Store</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="<?php echo BASE_URL(); ?>"><i class="fa fa-dashboard"></i>Home</a></li>
            <li><a href="<?php echo BASE_URL()."store/deleteStore/".$id_store; ?>"><i class="fa fa-dashboard"></i>Delete Store</a></li>
          </ol>
        </section>
  
  
   <!-- Content -->
   <section class="content">
          <div class="box sms box-default color-palette-box">
            <div class="box-header with-border">
              <h3 class="box-title"><i class="fa fa-edit"></i> Delete Store</h3>
            </div>
            <div class="box-body">
            
           		<?php
			function convert_price($price)
			{
				echo "Rp. ".number_format($price, 0 , '' , '.' );		
					}
			?>
                      
                  <form role="form" action="<?php echo site_url('store/deleteStore')?>" method="post" enctype="multipart/form-data">
                  <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                  <p>Are you sure want to delete this store?</p>
                    <div id="wrapper-table">
                 <table id="example2" class="table table-bordered table-hover">
                    <thead>
                      <tr>
                        <th>ID Store</th>
                        <th>Distributor Code</th>
                        <th>Motorist Code</th>
                        <th>Motorist Name</th>
                        <th>Day Visit</th>
                        <th>Frequency</th>
                        <th>Customer Code</th>
                        <th>Customer Name</th>
                        <th>Channel Code</th>
                        <th>Channel Name</th>
                        <th>Place Status</th>
                        <th>Customer Status</th>
                        <th>Address</th>
                        <th>Districts</th>
                        <th>Customer Contact</th>
                        <th>Latitude</th>
                        <th>Longitude</th>
                      </tr>
                    </thead>
             		<tbody>
                    <tr>
                    	<td><?php echo $id_store; ?></td>
                        <td><?php echo $distributor_code; ?></td>
                        <td><?php echo $motorist_code ?></td>
                        <td><?php echo $motorist_name; ?></td>
                        <td><?php echo $day_visit; ?></td>
                        <td><?php echo $frequency; ?></td>
                        <td><?php echo $customer_code; ?></td>
                        <td><?php echo $customer_name; ?></td>
                        <td><?php echo $channel_code; ?></td>
                        <td><?php echo $channel_name; ?></td>
                        <td><?php echo $place_status; ?></td>
                        <td><?php echo $customer_status; ?></td>
                        <td><?php echo $address; ?></td>
                        <td><?php echo $districts; ?></td>
                        <td><?php echo $customer_contact; ?></td>
                        <td><?php echo $latitude; ?></td>
                        <td><?php echo $longitude; ?></td>
                         </tr>
                    </tbody>       
             </table>
             </div>
                  <div class="box-footer">
                  	<input type="hidden" name="id_store" id="id_store" value="<?php echo $id_store; ?>">
                    <button type="submit" class="btn btn-red">Delete Channel</button>
                    <a href="<?php echo site_url('store')?>" class="btn btn-blue">Cancel</a>
                  </div>
                </form>
            
           </div>
            </div>
            
            </div>
      </section>

