 <!-- HEADER -->
 <?php $title = isset($_GET['title']) ? $_GET['title'] : ''; ?>
 <section class="content-header">
          <h1>
            Report Detail Balance Sheet
            <small>List Of <?php echo $title;  ?></small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="<?php echo BASE_URL(); ?>"><i class="fa fa-dashboard"></i>Home</a></li>
            <li><a href="#"><i class="fa fa-dashboard"></i><?php echo $title;  ?></a></li>
          </ol>
        </section>
  
  
   <!-- Content -->
   <section class="content">
		
		
  
  
          <div class="box sms box-default color-palette-box">
            <div class="box-header with-border">
              <h3 class="box-title"><i class="fa fa-table"></i> Report Detail Balance Sheet<?php echo $title;  ?></h3>
            </div>
            <div class="box-body">
            
            <div id="wrapper-table">
          
					<img src='<?php echo BASE_URL().'image-report/BalanceSheet.png'; ?>'></img>
			
            </div>
            
            </div>
      </section>

	  

