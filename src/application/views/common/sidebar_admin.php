
<section class="sidebar">
          <!-- Sidebar user panel -->
         <div class="user-panel">
            <div class="pull-left image">
              <img src="<?php echo base_url(); ?>assets_theme/dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
              <p><?php echo $data_account[0]['username']; ?></p>
              <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
          </div>
         
          <!-- sidebar menu: : style can be found in sidebar.less -->
          <ul class="sidebar-menu">
            <li class="header">TMS</li>
			
			<li class="treeview">
              <a href="<?php echo site_url(""); ?>">
                <i class="fa fa-dashboard"></i>
                <span>Dashboard</span>
                <i class="fa"></i>
              </a>
            </li>
			
			<!--<li class="treeview">
              <a href="#">
                <i class="fa fa-ship"></i>
                <span>Procurement</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
					<li><a href="<?php echo site_url("pr"); ?>"><i class="fa fa-circle-o"></i>Purchase Request</a></li>
                 <li><a href="<?php echo site_url("po"); ?>"><i class="fa fa-circle-o"></i>Purchase Order</a></li>
				 <li><a href="<?php echo site_url("gr"); ?>"><i class="fa fa-circle-o"></i>Good Receiving</a></li>
              </ul>
            </li>-->
			
			<!--<li class="treeview">
              <a href="#">
                <i class="fa fa-building"></i>
                <span>Inventory</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                 <li><a href="<?php echo site_url("inventory_list"); ?>"><i class="fa fa-circle-o"></i>Inventory List</a></li>
				 <li><a href="<?php echo site_url("inventory_list/stockTransfer"); ?>"><i class="fa fa-circle-o"></i>Stock Transfer</a></li>
				 <li><a href="<?php echo site_url("inventory_list/stockCheck"); ?>"><i class="fa fa-circle-o"></i>Stock Check</a></li>
              </ul>
            </li>-->
			
			
			
			
			
			
			<li class="treeview">
              <a href="#">
                <i class="fa fa-building"></i>
                <span>TMS</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
				 <li><a href="<?php echo site_url("transport_order"); ?>"><i class="fa fa-circle-o"></i>Dispatch Order</a></li>
				 <li><a href="<?php echo site_url("route_planning"); ?>"><i class="fa fa-circle-o"></i>Route Planning</a></li>
				 <li><a href="<?php echo site_url("traffic_monitoring"); ?>"><i class="fa fa-circle-o"></i>Traffic Monitoring</a></li>
              </ul>
            </li>
			
			<!--<li class="treeview">
              <a href="#">
                <i class="fa fa-building"></i>
                <span>Accounting</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                 <li><a href="<?php echo site_url("master_bank"); ?>"><i class="fa fa-circle-o"></i>Bank Account</a></li>
				 <li><a href="<?php echo site_url("purchase_invoice/bankTransaction"); ?>"><i class="fa fa-circle-o"></i>Bank Transaction</a></li>
				 <li><a href="<?php echo site_url("master_cash"); ?>"><i class="fa fa-circle-o"></i>Cash Account</a></li>
				 <li><a href="<?php echo site_url("purchase_invoice/cashTransaction"); ?>"><i class="fa fa-circle-o"></i>Cash Transaction</a></li>
				 <li><a href="<?php echo site_url("purchase_invoice"); ?>"><i class="fa fa-circle-o"></i>Invoice</a></li>
				 
				 <!--<li><a href="<?php echo site_url("home/normalization"); ?>"><i class="fa fa-circle-o"></i>Inter Account Transfer</a></li>
				 <li><a href="<?php echo site_url("home/normalization"); ?>"><i class="fa fa-circle-o"></i>Sales Invoice</a></li>
				 <li><a href="<?php echo site_url("home/normalization"); ?>"><i class="fa fa-circle-o"></i>Expence Claim</a></li>-->
				 <!--<li><a href="<?php echo site_url("po"); ?>"><i class="fa fa-circle-o"></i>Report</a>
				 <ul class='ul_down'>
						<li><a href="<?php echo site_url("po"); ?>"><i class="fa fa-circle-o"></i>Financial Statement</a>
							<ul class='ul_down'>
								<li><a href="<?php echo site_url("home/normalization"); ?>"><i class="fa fa-circle-o"></i>Profit And Loss Statement</a></li>
								<li><a href="<?php echo site_url("home/normalization"); ?>"><i class="fa fa-circle-o"></i>Balance Sheet</a></li>
							</ul>
						 </li>
						 <li><a href="<?php echo site_url("po"); ?>"><i class="fa fa-circle-o"></i>Account Receivable</a>
							<ul class='ul_down'>
								<li><a href="<?php echo site_url("home/normalization"); ?>"><i class="fa fa-circle-o"></i>Aged Receivable</a></li>
							</ul>
						 </li>
						  <li><a href="<?php echo site_url("po"); ?>"><i class="fa fa-circle-o"></i>Account Payable</a></li>
						 
						 <li><a href="<?php echo site_url("po"); ?>"><i class="fa fa-circle-o"></i>Fixed Asset Summary</a></li>
						 
						 <li><a href="<?php echo site_url("po"); ?>"><i class="fa fa-circle-o"></i>Sales Invoice</a>
							<ul class='ul_down'>
								<li><a href="<?php echo site_url("home/normalization"); ?>"><i class="fa fa-circle-o"></i>Sales Invoice Total By Client</a></li>
							</ul>
						 </li>
						 
						  <li><a href="<?php echo site_url("po"); ?>"><i class="fa fa-circle-o"></i>General Ledger</a>
							<ul class='ul_down'>
								<li><a href="<?php echo site_url("home/normalization"); ?>"><i class="fa fa-circle-o"></i>Gl Summary</a></li>
								<li><a href="<?php echo site_url("home/normalization"); ?>"><i class="fa fa-circle-o"></i>Gl Transaction</a></li>
							</ul>
						 </li>
						 
						  <li><a href="<?php echo site_url("po"); ?>"><i class="fa fa-circle-o"></i>Tax Report</a>
							<ul class='ul_down'>
								<li><a href="<?php echo site_url("home/normalization"); ?>"><i class="fa fa-circle-o"></i>Tax Audit</a></li>
								<li><a href="<?php echo site_url("home/normalization"); ?>"><i class="fa fa-circle-o"></i>Tax Summary</a></li>
								<li><a href="<?php echo site_url("home/normalization"); ?>"><i class="fa fa-circle-o"></i>Tax Reconsiliation</a></li>
								<li><a href="<?php echo site_url("home/normalization"); ?>"><i class="fa fa-circle-o"></i>Tax By Transaction</a></li>
							</ul>
						 </li>
						 
						  <li><a href="<?php echo site_url("po"); ?>"><i class="fa fa-circle-o"></i>Expense Claim</a>
							<ul class='ul_down'>
								<li><a href="<?php echo site_url("home/normalization"); ?>"><i class="fa fa-circle-o"></i>Expense Claim Summary</a></li>
							</ul>
						 </li>
						 
						 
					</ul>
				 </li>

              </ul>
            </li>-->
			
			
			<li class="treeview">
              <a href="#">
                <i class="fa fa-database"></i>
                <span>Master Data</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
				 <li><a href="<?php echo site_url("master_unit"); ?>"><i class="fa fa-circle-o"></i>Master Unit</a></li>
				 <li><a href="<?php echo site_url("vehicle_type"); ?>"><i class="fa fa-circle-o"></i>Data Vehicle Type</a></li>
                 <!--<li><a href="<?php echo site_url("warehouse"); ?>"><i class="fa fa-circle-o"></i>Data Warehouse</a></li>
				 <li><a href="<?php echo site_url("supplier"); ?>"><i class="fa fa-circle-o"></i>Data Supplier</a></li>-->
				 <li><a href="<?php echo site_url("area"); ?>"><i class="fa fa-circle-o"></i>Data Area</a></li>				
				 <li><a href="<?php echo site_url("driver"); ?>"><i class="fa fa-circle-o"></i>Data Driver</a></li>
				 
				 <li><a href="<?php echo site_url("customer"); ?>"><i class="fa fa-circle-o"></i>Data Customer</a></li>

              </ul>
            </li>
			
			

           
           
            <li class="reeview">
              <a href="/displaymap.php">
                <i class="fa fa-map-marker"></i> <span>Map Tracker</span> 
              </a>
            </li>
                     
            
            <li class="reeview">
              <a href="<?php echo site_url("auth/logout"); ?>">
                <i class="fa fa-sign-out"></i> <span>Logout</span> 
              </a>
            </li>
           
          </ul>
        </section>
        <!-- /.sidebar -->