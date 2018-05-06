 <!-- HEADER -->
 <section class="content-header">
          <h1>
            Daily Stock
            <small>Daily Stock of E-tools</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="<?php echo BASE_URL(); ?>"><i class="fa fa-dashboard"></i>Home</a></li>
            <li><a href="<?php echo BASE_URL()."dailyStock"; ?>"><i class="fa fa-dashboard"></i>Daily Stock</a></li>
          </ol>
        </section>
  
  
   <!-- Content -->
   <section class="content">
          <div class="box sms box-default color-palette-box">
            <div class="box-header with-border">
              <h3 class="box-title"><i class="fa fa-table"></i>Table Daily Call Strike Motorist</h3>
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
           
           	<table id="example2" class="table table-bordered table-hover">
                    <thead>
                      <tr>
                        <th>Id Product</th>
                        <th>SKU</th>
                        <th>Total Stock Pcs</th>
                        <th>Price Pcs</th>
                        <th>Total Amount</th>
                      </tr>
                    </thead>
                    
                     <?php foreach($data_stock as $data_stock) {	
								$total_amount = $data_stock['stock'] * $data_stock['price_pcs'];
						?>
                        <tr>
                            <td><?php echo $data_stock['product_code']; ?></td>
                            <td><?php echo $data_stock['sku']; ?></td>
                            <td><?php echo $data_stock['stock']; ?></td>
                            <td><?php echo convert_price($data_stock['price_pcs']); ?></td>
                            <td><?php echo convert_price($total_amount); ?></td>
                        </tr>
                    <?php }?>
                    
             		<tbody>
                          </tbody>       
             </table>
                   
              
             
            		  
                    
            
           </div>
            </div>
            
            </div>
      </section>

