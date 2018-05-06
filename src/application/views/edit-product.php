 <!-- HEADER -->
 <section class="content-header">
          <h1>
            Product
            <small>Edit Product</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="<?php echo BASE_URL(); ?>"><i class="fa fa-dashboard"></i>Home</a></li>
            <li><a href="<?php echo BASE_URL()."product/editProduct"; ?>"><i class="fa fa-dashboard"></i>Edit Product</a></li>
          </ol>
        </section>
  
  
   <!-- Content -->
   <section class="content">
          <div class="box sms box-default color-palette-box">
            <div class="box-header with-border">
              <h3 class="box-title"><i class="fa fa-edit"></i> Form Edit Product</h3>
            </div>
            <div class="box-body">
            
           		<?php if(validation_errors()){ ?>
                      <div class="error-box">
                      <?php echo validation_errors() ?>
                      </div>
                      <?php } ?>
                      
                  <form role="form" action="<?php echo site_url('product/editProduct')?>" method="post" enctype="multipart/form-data">
                  <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                  <div class="box-body">
                    
                    <div class="form-group">
                      <label for="exampleInputEmail1">Product Code</label>
                      <input readonly="readonly" type="text" name="product_code" id="product_code" class="form-control <?php if (form_error('product_code')) { echo 'error'; } ?>" value="<?php if(! set_value('product_code')){echo $product_code;}else{echo set_value('product_code');}; ?>" />
                      <?php echo form_error('product_code'); ?>
                    </div>
                    
                    
                    <div class="form-group">
                      <label for="exampleInputEmail1">Brand</label>
                      <input type="text" name="brand" id="brand" class="form-control <?php if (form_error('brand')) { echo 'error'; } ?>" value="<?php if(! set_value('brand')){echo $sku;}else{echo set_value('brand');}; ?>" />
                      <?php echo form_error('brand'); ?>
                    </div>
                    
                    <div class="form-group">
                      <label for="exampleInputEmail1">Category Product</label>
                      <select name="category" class="form-control  <?php if (form_error('category')) { echo 'error'; } ?>">
                      	<option value="">Choose Category</option>
                        <option value="Coffee" <?php if(set_value('category')=='Coffee'){echo"selected=selected";}else if($category == 'Coffee' ){echo"selected=selected";} ?> >Coffee</option>
                        <option value="Chocomalt Beverages" <?php if(set_value('category')=='Chocomalt Beverages'){echo"selected=selected";}else if($category == 'Chocomalt Beverages' ){echo"selected=selected";} ?>>Chocomalt Beverages</option>
                        <option value="Confectionery" <?php if(set_value('category')=='Confectionery'){echo"selected=selected";}else if($category == 'Confectionery' ){echo"selected=selected";} ?>>Confectionery</option>
                         <option value="Dairy" <?php if(set_value('category')=='Dairy'){echo"selected=selected";}else if($category == 'Dairy' ){echo"selected=selected";} ?>>Dairy</option>
                        <option value="RTD" <?php if(set_value('category')=='RTD'){echo"selected=selected";}else if($category == 'RTD' ){echo"selected=selected";} ?>>RTD</option>
                      </select>
                      <?php echo form_error('category'); ?>
                    </div>
                    
                    
                    
                    <div class="form-group">
                      <label for="exampleInputEmail1">SKU Name / Product Name</label>
                      <input type="text" name="product_name" id="product_name" class="form-control <?php if (form_error('product_name')) { echo 'error'; } ?>" value="<?php if(! set_value('product_name')){echo $sku;}else{echo set_value('product_name');}; ?>" />
                      <?php echo form_error('product_name'); ?>
                    </div>
                    
                    
                    <div class="form-group">
                      <label for="exampleInputEmail1">SKU Name Front / Product Name Front</label>
                      <input type="text" name="product_name_front" id="product_name_front" class="form-control <?php if (form_error('product_name_front')) { echo 'error'; } ?>" value="<?php if(! set_value('product_name_front')){echo $sku_front_end;}else{echo set_value('product_name_front');}; ?>" />
                      <?php echo form_error('product_name_front'); ?>
                    </div>
                    
                    <div class="form-group">
                      <label for="exampleInputEmail1">SKU Front End / Product Name Font End</label>
                      <input type="text" name="product_name" id="product_name" class="form-control <?php if (form_error('product_name')) { echo 'error'; } ?>" value="<?php if(! set_value('product_name')){echo $sku;}else{echo set_value('product_name');}; ?>" />
                      <?php echo form_error('product_name'); ?>
                    </div>
                    
                    <div class="form-group">
                      <label for="exampleInputEmail1">Unit</label>
                      <input type="text" name="unit" id="unit" class="form-control <?php if (form_error('unit')) { echo 'error'; } ?>" value="<?php if(! set_value('unit')){echo $unit;}else{echo set_value('unit');}; ?>" />
                     <?php echo form_error('unit'); ?>
                    </div>
                    
                     <div class="form-group">
                      <label for="exampleInputEmail1">Harga Cs (Ex 10000 for 10.000)</label>
                      <input type="text" name="price_cs" id="price_cs" class="form-control <?php if (form_error('price_cs')) { echo 'error'; } ?>" value="<?php if(! set_value('price_cs')){echo $price_cs;}else{echo set_value('price_cs');}; ?>" />
                    	<?php echo form_error('price_cs'); ?>
                    </div>
                    
                    <div class="form-group">
                      <label for="exampleInputEmail1">Harga Pcs (Ex 10000 for 10.000)</label>
                      <input type="text" name="price_pcs" id="price_pcs" class="form-control <?php if (form_error('price_pcs')) { echo 'error'; } ?>" value="<?php if(! set_value('price_pcs')){echo $price_pcs;}else{echo set_value('price_pcs');}; ?>" />
                    	<?php echo form_error('price_pcs'); ?>
                    </div>
                    
                   
                   <div class="form-group">
                      <label for="exampleInputEmail1">Type Motorist</label>
                      <select name="type_motorist" class="form-control <?php if (form_error('type_motorist')) { echo 'error'; } ?>">
                      	<option value="">Choose Type Motorist</option>
                        <option value="Kantin" <?php if(set_value('type_motorist')=='Kantin'){echo"selected=selected";}else if($type == 'Kantin' ){echo"selected=selected";} ?>>Kantin</option>
                        <option value="OOH" <?php if(set_value('type_motorist')=='OOH'){echo"selected=selected";}else if($type == 'OOH' ){echo"selected=selected";} ?>>OOH</option>
                      </select>
                    </div>
                   
                   
                  </div><!-- /.box-body -->

                  <div class="box-footer">
                  	<input type="hidden" name="id_product" id="id_product" value="<?php echo $id_product; ?>">
                    <button type="submit" class="btn btn-primary">Update Product</button>
                    <a href="<?php echo site_url("product/product"); ?>" class="btn btn-blue">Cancel Update</a>
                  </div>
                </form>
            
           </div>
            </div>
            
            </div>
      </section>

