 <!-- HEADER -->
 <section class="content-header">
          <h1>
			Cash Transaction
            <small>List Of Cash Transaction</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="<?php echo BASE_URL(); ?>"><i class="fa fa-dashboard"></i>Home</a></li>
            <li><a href="<?php echo BASE_URL()."purchase_invoice/cashTransaction"; ?>"><i class="fa fa-dashboard"></i>Cash Transactio</a></li>
          </ol>
        </section>
  
  
   <!-- Content -->
   <section class="content">
		
		
  
  
          <div class="box sms box-default color-palette-box">
            <div class="box-header with-border">
              <h3 class="box-title"><i class="fa fa-table"></i> Table Cash Transaction</h3>
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
				function convert_date($date)
			{
				$date = (explode("-",$date));
				$date = $date[2].'-'.$date[1].'-'.$date[0];
				echo $date;
			}
			?>
            <div id="wrapper-console" class="clearfix">
                <div id="wrapper-search">
                             <form action="<?php echo base_url()."index.php/purchase_invoice/cashTransaction" ?>" method="get">
                             <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                                <input type="text" id="search" name="search" placeholder="Search..."  value="<?php echo $search; ?>" />
                                <input type="submit" id="submit"  value="Search"/>
                                <?php if($search!="")
								{?>
                                <a href="<?php echo base_url()."index.php/purchase_invoice/cashTransaction" ?>" id="clear-search">Clear Search</a>
                                <?php } ?>
                             </form>
                </div>
                <div id="wrapper-button" class="clearfix">
					<?php if($data_role[0]['export_gr']=='yes'){ ?>
                	<a href="#" class="button orange-button">
                    	Export Cash Transaction
                    </a>
					
					<?php } ?>
                    
					
                </div>
                </div>
            <div id="wrapper-console" class="clearfix"> 
            <div class="grid_4 height400">                  
           	<table id="myTable03" class="fancyTable table table-bordered table-hover">
                    <thead>
                      <tr>
                        <th>ID Transaction</th>
						<th>Invoice Date</th>
                        <th>Payment Type</th>
                        <th>ID Invoice</th>
						<th>Payment Method</th>
						<th>Account</th>
						<th>Amount</th>
                      </tr>
                    </thead>
             		<tbody>
					
				 <?php foreach($data_cash_transaction as $data_cash_transaction) {?>
					
						<tr>
                        <td><?php echo $data_cash_transaction->id_transaction; ?></td>
						<td><?php convert_date($data_cash_transaction->invoice_date); ?></td>
                        <td><?php echo $data_cash_transaction->type; ?></td>
                        <td><?php echo $data_cash_transaction->id_invoice; ?></td>
						<td><?php echo $data_cash_transaction->payment_method	; ?></td>
						<td><?php echo $data_cash_transaction->name; ?></td>
						<td><?php convert_price($data_cash_transaction->amount); ?></td>
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

	  
	
