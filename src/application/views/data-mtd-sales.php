 <!-- HEADER -->
 <section class="content-header">
          <h1>
            Product
            <small>Mtd Sales</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="<?php echo BASE_URL(); ?>"><i class="fa fa-dashboard"></i>Home</a></li>
            <li><a href="<?php echo BASE_URL()."mtdProductSales"; ?>"><i class="fa fa-dashboard"></i>MtdSales</a></li>
          </ol>
        </section>
  
  
   <!-- Content -->
   <section class="content">
          <div class="box sms box-default color-palette-box">
            <div class="box-header with-border">
              <h3 class="box-title"><i class="fa fa-table"></i> Table Mtd Sales</h3>
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
               
                
            </div>
            <div id="wrapper-console" class="clearfix">             
           	<table id="example2" class="table table-bordered table-hover">
                    <thead>
                      <tr>
                        <th>ID Product</th>
                        <th>Total Order</th>
                        <th>SKU</th>
                        <th>Unit</th>
                        <th>Price Cs</th>
                        <th>Price Pcs</th>
                        <th>Total Amount</th>
                      </tr>
                    </thead>
             		<tbody>
                    <?php foreach($data_product as $data_product) {?>
                    <?php if($data_product->total_order>=1)
					
					{ $total_amount = $data_product->total_order *$data_product->price_pcs;?> 
                    <tr>
                    	<td><?php echo $data_product->id_product; ?></td>
                        <td><?php echo $data_product->total_order; ?></td>
                        <td><?php echo $data_product->sku; ?></td>
                        <td><?php echo $data_product->unit; ?></td>
                        <td><?php echo convert_price($data_product->price_cs); ?></td>
                        <td><?php echo convert_price($data_product->price_pcs); ?></td>
                         <td><?php echo convert_price($total_amount); ?></td>
                        </tr>
                        <?php } ?>
                    <?php }?>
                    </tbody>       
             </table>
             
            		  <div class="pagination page">  
                     <?php  echo $this->pagination->create_links(); ?>
                     </div>
                    
            
           </div>
            </div>
            
            </div>
      </section>

