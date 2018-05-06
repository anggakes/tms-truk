 <!-- HEADER -->
 <section class="content-header">
          <h1>
            Distributor
            <small>Distributor of E-tools</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="<?php echo BASE_URL(); ?>"><i class="fa fa-dashboard"></i>Home</a></li>
            <li><a href="<?php echo BASE_URL()."distributor"; ?>"><i class="fa fa-dashboard"></i>Distributor</a></li>
          </ol>
        </section>
  
  
   <!-- Content -->
   <section class="content">
          <div class="box sms box-default color-palette-box">
            <div class="box-header with-border">
              <h3 class="box-title"><i class="fa fa-table"></i> Table Distributor</h3>
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
			
			
			$regional = isset($_GET['regional']) ? $_GET['regional'] : '';
			if(isset($_GET['regional']))
			{$regional_implode = "'" . implode("','", $regional) . "'";;}
			else
			{$regional_implode = "";}
			
			
			
			?>
            <div id="wrapper-console" class="clearfix">
                <div id="wrapper-search">
                             <form action="<?php echo base_url()."index.php/distributor" ?>" method="get">
                             <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                                <input type="text" id="search" name="search" placeholder="Search by distributor code"  value="<?php echo $search; ?>" />
                                
                                
                                <div class="select-filter">
                             	<select name="regional[]" id="select-regional" multiple="multiple" >
                              	<?php foreach($data_regional as $data_regional) {?>
                              	<option <?php if(isset($_GET['regional'])) {if(in_array($data_regional['regional_name'], $regional)) {?> selected="selected" <?php }} ?> value="<?php echo $data_regional['regional_name']; ?>"><?php echo $data_regional['regional_name']; ?></option>
                              	<?php } ?>
                             	</select>
                             	</div>
                             
                                <input type="submit" id="submit"  value="Search"/>
                                <?php if($search!="" or $regional_implode!="")
								{?>
                                <a href="<?php echo base_url()."index.php/distributor" ?>" id="clear-search">Clear Search</a>
                                <?php } ?>
                             </form>
                </div>
                <div id="wrapper-button" class="clearfix">
                	<a href="<?php echo base_url()."index.php/distributor/exportDistributor?search=".$search."&&regional=".$regional_implode; ?>" class="button orange-button">
                    	Export Distributor
                    </a>
                    
                    <a href="<?php echo base_url()."index.php/distributor/addDistributor" ?>" class="button green-button">
                    	Add Distributor
                    </a>
                    
                    <a href="<?php echo base_url()."index.php/distributor/importDistributor" ?>" class="button blue-button">
                    	Import Distributor
                    </a>
                </div>
                </div>
            <div id="wrapper-console" class="clearfix">
            <div class="grid_4 height400">                     
           	<table  id="myTable04" class="fancyTable table table-bordered table-hover">
                    <thead>
                      <tr>
                        <th>Distributor Name</th>
                        <th>ID Distributor</th>
                        <th>Regional</th>
                        <th>Area</th>
                        <th>Distributor Code</th>
                        <th>Action</th>
                      </tr>
                    </thead>
             		<tbody>
                    <?php foreach($data_distributor as $data_distributor) {?>
                    <tr>
                    	<td><?php echo $data_distributor->distributor_name; ?></td>
                    	<td><?php echo $data_distributor->id_distributor; ?></td>
                        <td><?php echo $data_distributor->regional; ?></td>
                        <td><?php echo $data_distributor->area; ?></td>
                        <td><?php echo $data_distributor->distributor_code; ?></td>
                        <td><a href="<?php echo base_url()."index.php/distributor/editDistributor/".$data_distributor->id_distributor ?>">Edit</a> | <a href="<?php echo base_url()."index.php/distributor/deleteDistributor/".$data_distributor->id_distributor ?>">Delete</a></td>
                        </tr>
                    <?php }?>
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

<script>
$("#select-regional").pqSelect({
   multiplePlaceholder: 'Select Regional',
   checkbox: true //adds checkbox to options    
   }).on("change", function(evt) {
      var val = $(this).val();
    })
</script>
