 <!-- HEADER -->
 <section class="content-header">
          <h1>
            Product
            <small>Delete Product</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="<?php echo BASE_URL(); ?>"><i class="fa fa-dashboard"></i>Home</a></li>
            <li><a href="<?php echo BASE_URL()."product/deleteProduct/".$id_product; ?>"><i class="fa fa-dashboard"></i>Delete Product</a></li>
          </ol>
        </section>
  
  
   <!-- Content -->
   <section class="content">
          <div class="box sms box-default color-palette-box">
            <div class="box-header with-border">
              <h3 class="box-title"><i class="fa fa-edit"></i> Delete Product</h3>
            </div>
            <div class="box-body">
            
           		<?php
			function convert_price($price)
			{
				echo "Rp. ".number_format($price, 0 , '' , '.' );		
					}
			?>
                      
                  <form role="form" action="<?php echo site_url('product/deleteProduct')?>" method="post" enctype="multipart/form-data">
                  <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                  <p>Are you sure want to delete this product?</p>
                  
                  <table id="example2" class="table table-bordered table-hover">
                    <thead>
                      <tr>
                        <th>ID Product</th>
                        <th>Brand</th>
                        <th>Product Code</th>
                        <th>Category</th>
                        <th>SKU</th>
                        <th>Unit</th>
                        <th>Price Cs</th>
                        <th>Price Pcs</th>
                        <th>Type</th>
                      </tr>
                    </thead>
             		<tbody>
                    <tr>
                    	<td><?php echo $id_product; ?></td>
                        <td><?php echo $brand; ?></td>
                        <td><?php echo $product_code; ?></td>
                        <td><?php echo $category; ?></td>
                        <td><?php echo $sku; ?></td>
                        <td><?php echo $unit; ?></td>
                        <td><?php echo convert_price($price_cs); ?></td>
                        <td><?php echo convert_price($price_pcs); ?></td>
                        <td><?php echo $type; ?></td>
                        </tr>
                   
                    </tbody>       
             </table>
             
                  <div class="box-footer">
                  	<input type="hidden" name="id_product" id="id_product" value="<?php echo $id_product; ?>">
                    <button type="submit" class="btn btn-red">Delete Product</button>
                    <a href="<?php echo site_url('product')?>" class="btn btn-blue">Cancel</a>
                  </div>
                </form>
            
           </div>
            </div>
            
            </div>
      </section>

