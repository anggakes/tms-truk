 <!-- HEADER -->
 <section class="content-header">
          <h1>
			Stock Check
            <small>List Of Stock Check</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="<?php echo BASE_URL(); ?>"><i class="fa fa-dashboard"></i>Home</a></li>
            <li><a href="<?php echo BASE_URL()."inventory_list/stock_check"; ?>"><i class="fa fa-dashboard"></i>Stock Check</a></li>
          </ol>
        </section>
  
  
   <!-- Content -->
   <section class="content">
		
		
  
  
          <div class="box sms box-default color-palette-box">
            <div class="box-header with-border">
              <h3 class="box-title"><i class="fa fa-table"></i> Table Stock Check</h3>
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
                             <form action="<?php echo base_url()."index.php/inventory_list/stockCheck" ?>" method="get">
                             <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                                <input type="text" id="search" name="search" placeholder="Search..."  value="<?php echo $search; ?>" />
                                <input type="submit" id="submit"  value="Search"/>
                                <?php if($search!="")
								{?>
                                <a href="<?php echo base_url()."index.php/inventory_list/stockCheck" ?>" id="clear-search">Clear Search</a>
                                <?php } ?>
                             </form>
                </div>
                <div id="wrapper-button" class="clearfix">
					<?php if($data_role[0]['export_gr']=='yes'){ ?>
                	<a href="<?php echo base_url()."index.php/inventory_list/exportStockCheck?search=".$search; ?>" class="button orange-button">
                    	Export Stock Check
                    </a>
					
					<?php } ?>
                    
					
                </div>
                </div>
            <div id="wrapper-console" class="clearfix"> 
            <div class="grid_4 height400">                  
           	<table id="myTable03" class="fancyTable table table-bordered table-hover">
                    <thead>
                      <tr>
                        <th>Warehouse ID</th>
                        <th>Location Type</th>
                        <th>Location ID</th>
						<th>Product Code</th>
						<th>Product Description</th>
						<th>Serial Number</th>
						<th>Quantity Base</th>
						<th>Stock</th>
                      </tr>
                    </thead>
             		<tbody>
					
				 <?php foreach($data_inventory_list as $data_inventory_list) {?>
					
						<tr>
                        <td><?php echo $data_inventory_list->warehouse_code; ?></td>
                        <td><?php echo $data_inventory_list->location_type; ?></td>
                        <td><?php echo $data_inventory_list->location_code; ?></td>
						<td><?php echo $data_inventory_list->product_code; ?></td>
						<td><?php echo $data_inventory_list->product_description; ?></td>
						<td><?php echo $data_inventory_list->serial_number; ?></td>
						<td><?php echo $data_inventory_list->base_uom; ?></td>
						<td>0</td>
						</tr>
				 
				 <?php } ?>
					
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

	  
	
