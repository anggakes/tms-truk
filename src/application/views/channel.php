 <!-- HEADER -->
 <section class="content-header">
          <h1>
            Channel
            <small>Channel of E-tools</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="<?php echo BASE_URL(); ?>"><i class="fa fa-dashboard"></i>Home</a></li>
            <li><a href="<?php echo BASE_URL()."channel"; ?>"><i class="fa fa-dashboard"></i>Channel</a></li>
          </ol>
        </section>
  
  
   <!-- Content -->
   <section class="content">
          <div class="box sms box-default color-palette-box">
            <div class="box-header with-border">
              <h3 class="box-title"><i class="fa fa-table"></i> Table Channel</h3>
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
			?>
            <div id="wrapper-console" class="clearfix">
                <div id="wrapper-search">
                             <form action="<?php echo base_url()."index.php/channel" ?>" method="get">
                             <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                                <input type="text" id="search" name="search" placeholder="Search..."  value="<?php echo $search; ?>" />
                                <input type="submit" id="submit"  value="Search"/>
                                <?php if($search!="")
								{?>
                                <a href="<?php echo base_url()."index.php/channel" ?>" id="clear-search">Clear Search</a>
                                <?php } ?>
                             </form>
                </div>
                <div id="wrapper-button" class="clearfix">
                	<a href="<?php echo base_url()."index.php/channel/addChannel" ?>" class="button green-button">
                    	Add Channel
                    </a>
                    
                    <a href="<?php echo base_url()."index.php/channel/importChannel" ?>" class="button blue-button">
                    	Import Channel
                    </a>
                    <a href="<?php echo base_url()."index.php/channel/exportChannel" ?>" class="button orange-button">
                    	Export Channel
                    </a>
                </div>
                </div>
            <div id="wrapper-console" class="clearfix">
            <div class="grid_4 height400">             
           	<table id="myTable04" class="fancyTable table table-bordered table-hover">
                    <thead>
                      <tr>
                        <th>ID Channel</th>
                        <th>Customer Outlet Classification Code</th>
                        <th>Channel Description</th>
                        <th>Sample</th>
                        <th>Action</th>
                      </tr>
                    </thead>
             		<tbody>
                    <?php foreach($data_channel as $data_channel) {?>
                    <tr>
                    	<td><?php echo $data_channel->id_channel; ?></td>
                        <td><?php echo $data_channel->classification_code; ?></td>
                        <td><?php echo $data_channel->channel_description; ?></td>
                        <td><?php echo $data_channel->sample; ?></td>
                        <td><a href="<?php echo base_url()."index.php/channel/editChannel/".$data_channel->id_channel ?>">Edit</a> | <a href="<?php echo base_url()."index.php/channel/deleteChannel/".$data_channel->id_channel ?>">Delete</a></td>
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

