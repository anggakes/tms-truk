 <!-- HEADER -->
 <section class="content-header">
          <h1>
            Daily Stock Total
            <small>Daily Stock of E-tools</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="<?php echo BASE_URL(); ?>"><i class="fa fa-dashboard"></i>Home</a></li>
            <li><a href="<?php echo BASE_URL()."dailySummaryMotorist"; ?>"><i class="fa fa-dashboard"></i>Daily Summary Motorist</a></li>
          </ol>
        </section>
  
  
   <!-- Content -->
   <section class="content">
          <div class="box sms box-default color-palette-box">
            <div class="box-header with-border">
              <h3 class="box-title"><i class="fa fa-table"></i>Table Stock Sales Motorist</h3>
            </div>
            <div class="box-body">
            <?php 
			$id_motorist = isset($_GET['id_motorist']) ? $_GET['id_motorist'] : '';
			$date_now = isset($_GET['tanggal']) ? $_GET['tanggal'] : '';
			
			$tanggal_indonesia = explode("-",$date_now);
			$tanggal_indonesia = $tanggal_indonesia[2].'-'.$tanggal_indonesia[1].'-'.$tanggal_indonesia[0];
			
			?>
            
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
           	<h3>Date: <?php echo $tanggal_indonesia; ?></h3> 
           	
            <table id="example2" class="table table-bordered table-hover">
                    <thead>
                      <tr>
                        <th>Id Product</th>
                        <th>SKU</th>
                        <th>Total QTY</th>
                        <th>Price Pcs</th>
                        <th>Total Amount</th>
                      </tr>
                    </thead>
                    
                     <?php foreach($data_stock as $data_stock) {	
						
						$total_amount = $this->db->query("SELECT SUM(price_total) as total_amount,SUM(qty) as total_qty FROM product_orders WHERE id_product = '".$data_stock['id_product']."' AND id_motorist = '".$id_motorist."' AND date LIKE '%".$date_now."%'  ")->result_array();
						
					?>
                        <tr>
                            <td><?php echo $data_stock['product_code']; ?></td>
                            <td><?php echo $data_stock['sku']; ?></td>
                            <td><?php echo $total_amount[0]['total_qty']; ?> QTY</td>
                            <td><?php echo convert_price($data_stock['price_pcs']); ?></td>
                            <td><?php echo convert_price($total_amount[0]['total_amount']); ?></td>
                        </tr>
                    <?php }?>
                    
             		<tbody>
                          </tbody>       
             </table>
                   
              
             
            		  
                    
            
           </div>
            </div>
            
            </div>
      </section>

