 <!-- HEADER -->
 <section class="content-header">
          <h1>
            Motorist Map22
            <small>Motorist of E-tools</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="<?php echo BASE_URL(); ?>"><i class="fa fa-dashboard"></i>Home</a></li>
            <li><a href="<?php echo BASE_URL()."motorist"; ?>"><i class="fa fa-dashboard"></i>Motorist</a></li>
          </ol>
        </section>
  
  
   <!-- Content -->
   <section class="content">
          <div class="box sms box-default color-palette-box">
            <div class="box-header with-border">
              <h3 class="box-title"><i class="fa fa-table"></i> Table Motorist</h3>
            </div>
            <div class="box-body">
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
            <div id="wrapper-table">
           
            <?php
			$search = isset($_GET['search']) ? $_GET['search'] : '';
			function convert_price($price)
			{
				echo "Rp. ".number_format($price, 0 , '' , '.' );		
					}
			?>
            <div id="wrapper-console" class="clearfix">
                <div id="wrapper-search">
                	<div id="button"><a href="<?php echo base_url('maps/example/maps.php?distributor_code='.$data_account[0]['code'].'&&role='.$data_account[0]['user_type'].'&&token=22293848749484798&&motorist_code='.$data_motorist[0]['motorist_code'].''); ?>" target="_blank">View All Map</a></div>
                </div>
               
                </div>
            <div id="wrapper-console" class="clearfix"> 
             <h3 style="margin-bottom:10px; line-height:10px;">Motorist Name: <?php echo $data_motorist[0]['motorist_name']; ?></h3>  
            <h3>Motorist Code: <?php echo $data_motorist[0]['motorist_code']; ?></h3>             
           	 <div class="grid_4 height400">   
            <table id="myTable04" class="fancyTable table table-bordered table-hover">
                    <thead>
                      <tr>
                        <th>ID Store</th>
                        <th>Nama Toko</th>
                        <th>Kode Toko</th>
                        <th>Lihat Toko</th>
                      </tr>
                    </thead>
             		<tbody>
                    
                    <?php foreach($data_store as $data_store) {?>
                    <tr>
                    	<td><?php echo $data_store->id_store; ?></td>
                       <td><?php echo $data_store->customer_name; ?></td>
                       <td><?php echo $data_store->customer_code; ?></td>
                       <td><a target="_blank" href="<?php echo base_url('maps/example/maps.php?distributor_code='.$data_account[0]['code'].'&&role='.$data_account[0]['user_type'].'&&token=22293848749484798&&motorist_code='.$data_motorist[0]['motorist_code'].'&&search='.$data_store->customer_code.''); ?>">Lihat Lokasi</a></td>
                        </tr>
                    <?php }?>
                    </tbody>       
             </table>
             </div>
            		  <div class="pagination page">  
                     <?php  echo $this->pagination->create_links(); ?>
                     </div>
                    
            
           </div>
            </div>
            
            </div>
      </section>

