 <!-- HEADER -->
 

    
 <section class="content-header">
          <h1>
            Absensi
            <small>Absensi of E-tools</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="<?php echo BASE_URL(); ?>"><i class="fa fa-dashboard"></i>Home</a></li>
            <li><a href="<?php echo BASE_URL()."absence"; ?>"><i class="fa fa-dashboard"></i>Absensi</a></li>
          </ol>
        </section>
  
  
   <!-- Content -->
   <section class="content">

          <div class="box sms box-default color-palette-box">
            <div class="box-header with-border">
              <h3 class="box-title"><i class="fa fa-table"></i> Table Absensi</h3>
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
                     
                      <?php
			$search = isset($_GET['search']) ? $_GET['search'] : '';
			$date = isset($_GET['date']) ? $_GET['date'] : '';
			function convert_price($price)
			{
				echo "Rp. ".number_format($price, 0 , '' , '.' );		
					}
			?>
            <div id="wrapper-console" class="clearfix">
                <div id="wrapper-search">
                             <form action="<?php echo base_url()."index.php/absence" ?>" method="get">
                             <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                                <div class="form-group">
                                <label>Date range:</label>
                                <div class="input-group">
                                  <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                  </div>
                                  <input type="text" class="form-control pull-right" id="reservation" name="date" value="<?php echo $date; ?>" >
                                </div><!-- /.input group -->
                              </div><!-- /.form group -->

                                <input type="text" id="search" name="search" placeholder="Search by Motorist Code"  value="<?php echo $search; ?>" />
                                <input type="submit" id="submit"  value="Search"/>
                                <?php if($search!="" or $date!="")
								{?>
                                <a href="<?php echo base_url()."index.php/absence" ?>" id="clear-search">Clear Search</a>
                                <?php } ?>
                             </form>
                </div>
                </div>
            <div id="wrapper-table">
           
            <div id="wrapper-console" class="clearfix">             
           	<table id="example2" class="table table-bordered table-hover">
                    <thead>
                      <tr>
                        <th>ID Absensi</th>
                        <th>Status Absensi</th>
                        <th>Motorist Code</th>
                        <th>Motorist Name</th>
                        <th>Tanggal Absensi</th>
                        <th>Keterangan</th>
                        <th>Action</th>
                      </tr>
                    </thead>
             		<tbody>
                    <?php foreach($data_absence as $data_absence) {?>
                    <tr>
                    	<td><?php echo $data_absence->id_absence; ?></td>
                        <td><?php echo $data_absence->status_absence; ?></td>
                        <td><?php echo $data_absence->motorist_code; ?></td>
                        <td><?php echo $data_absence->motorist_name; ?></td>
                        <td><?php echo $data_absence->date_absence; ?></td>
                        <td><?php echo $data_absence->keterangan; ?></td>
                        <td><a href="<?php echo base_url()."index.php/absence/detailAbsence/".$data_absence->id_absence ?>">Detail</a></td>
                        </tr>
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
<script>
	   $('#reservation').daterangepicker({ dateFormat: "dd-mm-yy" }).val();
</script>
