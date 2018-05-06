 <!-- HEADER -->
 <section class="content-header">
          <h1>
            Profit And Lost Statement (Actual vs Budget)
            <small>List Of Profit And Lost Statement</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="<?php echo BASE_URL(); ?>"><i class="fa fa-dashboard"></i>Home</a></li>
            <li><a href="#"><i class="fa fa-dashboard"></i>Profit And Lost Statement</a></li>
          </ol>
        </section>
  
  
   <!-- Content -->
   <section class="content">
		
		
  
  
          <div class="box sms box-default color-palette-box">
            <div class="box-header with-border">
              <h3 class="box-title"><i class="fa fa-table"></i> Table Profil And Loss Statement</h3>
            </div>
            <div class="box-body">
            
            <div id="wrapper-table">
            <?php
			$search = isset($_GET['search']) ? $_GET['search'] : '';
			function convert_price($price)
			{
				echo "Rp. ".number_format($price, 0 , '' , '.' );		
					}
			?>
            <div id="wrapper-console" class="clearfix"> 
            <div class="grid_4 height400">                  
           	<table id="myTable03" class="fancyTable table table-bordered table-hover">
                    <thead>
                      <tr>
                        <th>From</th>
                        <th>To</th>
                        <th>Accounting Method</th>
						<th>Tracking Code</th>
						<th>Description</th>
						<th>action</th>
                      </tr>
                    </thead>
             		<tbody>
						<tr>
                        <td>01-01-2018</td>
                        <td>31-01-2018</td>
                        <td>Accrual Basis</td>
						<td>Nestle</td>
						<td>-</td>
						<td><a href='#'>Edit</a> | <a href='#'>View</a></td>
						</tr>
                    </tbody>       
             </table>
             </div>
             
                    
            
           </div>
            </div>
            
            </div>
      </section>

	  

