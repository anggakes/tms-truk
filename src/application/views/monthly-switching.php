 <!-- HEADER -->
 <section class="content-header">
          <h1>
            Monthly Outlet Switching
            <small>Monthly Outlet Switching of E-tools</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="<?php echo BASE_URL(); ?>"><i class="fa fa-dashboard"></i>Home</a></li>
            <li><a href="<?php echo BASE_URL()."dailyStock"; ?>"><i class="fa fa-dashboard"></i>Monthly Outlet swicthingMotoristNoo</a></li>
          </ol>
        </section>
  
  
   <!-- Content -->
   <section class="content">
          <div class="box sms box-default color-palette-box">
            <div class="box-header with-border">
              <h3 class="box-title"><i class="fa fa-table"></i>Table Monthly Outlet Swithcingt</h3>
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
			
			function convert_price($price)
			{
				echo "Rp. ".number_format($price, 0 , '' , '.' );		
					}
			?>
            <div id="wrapper-console" class="clearfix">
                
                </div>
            <div id="wrapper-console" class="clearfix">  
            <h3 style="margin-bottom:10px; line-height:10px;">Motorist Name: <?php echo $data_motorist[0]['motorist_name']; ?></h3>  
            <h3>Motorist Code: <?php echo $data_motorist[0]['motorist_code']; ?></h3>     
            <div style="overflow-x:scroll">
           	<table id="example2" class="table table-bordered table-hover">
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>Customer Code</th>
                        <th>Customer Name</th>
                        <th>Order Januari</th>
                        <th>Order Februari</th>
                        <th>Order Maret</th>
                        <th>Order April</th>
                        <th>Order Mei</th>
                        <th>Order Juni</th>
                        <th>Order Juli</th>
                        <th>Order Agustus</th>
                        <th>Order September</th>
                        <th>Order Oktober</th>
                        <th>Order November</th>
                        <th>Order Desember</th>
                        <th>Foto Toko</th>
                        <th>Foto Product</th>
                        <th>ID Store</th>
                        <th>Detil Toko</th>
                      </tr>
                    </thead>
                    
                      <?php $no=1; foreach($data_switching as $data_switching) {	
						?>
                        <tr>
                            <td><?php echo $no; ?></td>
                            <td><?php echo $data_switching->customer_code; ?></td>
                            <td><?php echo $data_switching->customer_name; ?></td>
                             <td><?php convert_price($data_switching->total_order_januari); ?></td>
                            <td><?php convert_price($data_switching->total_order_februari); ?></td>
                            <td><?php convert_price($data_switching->total_order_maret); ?></td>
                            <td><?php convert_price($data_switching->total_order_april); ?></td>
                            <td><?php convert_price($data_switching->total_order_mei); ?></td>
                            <td><?php convert_price($data_switching->total_order_juni); ?></td>
                            <td><?php convert_price($data_switching->total_order_juli); ?></td>
                            <td><?php convert_price($data_switching->total_order_agustus); ?></td>
                            <td><?php convert_price($data_switching->total_order_september); ?></td>
                            <td><?php convert_price($data_switching->total_order_oktober); ?></td>
                            <td><?php convert_price($data_switching->total_order_november); ?></td>
                            <td><?php convert_price($data_switching->total_order_desember); ?></td>
                            <td><img style="width:100px;" height="auto" src="http://www.etools-apps.com//etools-offline/foto-store/foto-store-noo/<?php echo $data_switching->foto_toko; ?>"  /></td>
                            <td><img style="width:100px;" height="auto" src="http://www.etools-apps.com//etools-offline/foto-store/foto-product/<?php echo $data_switching->foto_product; ?>"></td>
                            <td><?php echo $data_switching->id_store; ?></td>
                            <td><a href="<?php echo base_url()."index.php/noo/detailStore/".$data_switching->id_store; ?>">Detil Toko</a></td>
                        </tr>
                    <?php $no++;}?>
                    
             		<tbody>
                          </tbody>       
             </table>
                   
              </div>
             
            		  
                    
            
           </div>
            </div>
            
            </div>
      </section>

