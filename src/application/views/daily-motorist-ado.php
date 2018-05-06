 <!-- HEADER -->
 <section class="content-header">
          <h1>
            DSOR
            <small>Summary productivity per salesman</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="<?php echo BASE_URL(); ?>"><i class="fa fa-dashboard"></i>Home</a></li>
            <li><a href="<?php echo BASE_URL()."dailySummaryMotoristAdo"; ?>"><i class="fa fa-dashboard"></i>Summary productivity per salesman</a></li>
          </ol>
        </section>
  
  
   <!-- Content -->
   <section class="content">
          <div class="box sms box-default color-palette-box">
            <div class="box-header with-border">
              <h3 class="box-title"><i class="fa fa-table"></i> Table Summary productivity per salesman</h3>
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
			
			
			
			$date = isset($_GET['date']) ? $_GET['date'] : '';
			if($date=='')
			{
				$date = date ('m/d/Y');
				}
			function convert_price($price)
			{
				echo "Rp. ".number_format($price, 0 , '' , '.' );		
					}
			?>
            <div id="wrapper-console" class="clearfix">
                <div id="wrapper-search">
                             <form action="<?php echo base_url()."index.php/motorist/dailySummaryMotoristAdo" ?>" method="get">
                             <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                                <input type="text" id="date" name="date" placeholder="Choose Date" value="<?php echo $date; ?>" />
                               
                                
                                <input type="text" id="search" name="search" placeholder="Search Motorist Code"  value="<?php echo $search; ?>" />
                                <input type="submit" id="submit"  value="Search"/>
                                <?php if($search!="")
								{?>
                                <a href="<?php echo base_url()."index.php/motorist/dailySummaryMotoristAdo" ?>" id="clear-search">Clear Search</a>
                                <?php } ?>
                             </form>
                </div>
                
                <div id="wrapper-button" class="clearfix">
                	<a href="<?php echo base_url()."index.php/motorist/exportDailySummaryMotoristAdo?search=".$search."&&date=".$date; ?>" class="button orange-button">
                    	Export Summary productivity per salesman
                    </a>
                </div>
                
                </div>
            <div id="wrapper-console" class="clearfix">
             <div class="grid_4 height400">              
           	<table id="myTable05" class="fancyTable table-bordered table-hover">
                    <thead>
                      <tr>
                        <th class="mid"><div class="mid">Nama Motorist</div></th>
                        <th class="mid"><div class="mid">Kode Motorist</div></th>
                        <th class="mid"><div class="mid">
						Target Call</div></th>
                        <th class="mid"><div class="mid">
						Call</div></th>
                        <th class="mid"><div class="mid">
						%Call</div></th>
                        <th class="mid"><div class="mid">
						Efektif Call</div></th>
                        <th class="mid"><div class="mid">
						New Customer</div></th>
                        <th class="mid"><div class="mid">
						%Efektif Call</div></th>
                      </tr>
                    </thead>
             		<tbody>
                    
                    <?php 
					$total_call_keseluruhan = 0;
					$total_new_customer_keseluruhan = 0;
					$total_effective_call_keseluruhan = 0;
					$total_target_call_keseluruhan = 0;
					$no =0; foreach($data_motorist as $data_motorist) {
						
						$persentasi_call = 0;
						$persentasi_extra_call = 0;
						$persentasi_effective_call = 0;
						$persentasi_extra_effective_call = 0;
						$persentasi_target_harian = 0;
						if($data_motorist->total_call>0)
						{
							if($data_motorist->target_call>0)
							{
								
							$persentasi_call = ($data_motorist->total_call * 100) / $data_motorist->target_call;
							$persentasi_call = number_format($persentasi_call, 0, '.', '');	
							}
							
							
							if($data_motorist->target_call>0)
							{
							$persentasi_effective_call = ($data_motorist->total_effective_call * 100) / $data_motorist->target_call;
							$persentasi_effective_call = number_format($persentasi_effective_call, 0, '.', '');
							}
						}
					?>
                    
                    
                    <tr>
                    	<td><div style="width:320px;"><?php echo $data_motorist->motorist_name; ?>-<?php echo $data_motorist->motorist_code; ?></div></td>
                        <td><?php echo $data_motorist->motorist_code; ?></td>
                        <td><?php echo $data_motorist->target_call; ?></td>
                        <td><?php echo $data_motorist->total_call; ?></td>
                        <td><?php echo $persentasi_call ?> %</td>
                        <td><?php echo $data_motorist->total_effective_call; ?></td>
                        <td><?php echo $data_motorist->total_new_customer; ?></td>
                        <td><?php echo $persentasi_effective_call; ?>%</td>
                    </tr>
                    <?php $no++; 
					$total_call_keseluruhan = $total_call_keseluruhan+$data_motorist->total_call;
					$total_target_call_keseluruhan = $total_target_call_keseluruhan+$data_motorist->target_call;
					$total_effective_call_keseluruhan = $total_effective_call_keseluruhan+$data_motorist->total_effective_call;
					$total_new_customer_keseluruhan = $total_new_customer_keseluruhan+$data_motorist->total_new_customer;
					}
					
					$total_persen_call = 0;
					if($total_target_call_keseluruhan>0)
					{
					$total_persen_call  = ($total_call_keseluruhan * 100) / $total_target_call_keseluruhan;
					$total_persen_call  = number_format($total_persen_call, 0, '.', '');
					}
					$total_persen_effective_call=0;
					if($total_call_keseluruhan>0)
					{
					$total_persen_effective_call  = ($total_effective_call_keseluruhan * 100) / $total_call_keseluruhan;
					$total_persen_effective_call  = number_format($total_persen_effective_call, 0, '.', '');
					}
					
					?>
                    </tbody>   
                    
                    <tfoot>
                    	<td>Total</td>
                        <td><?php echo $no; ?> </td>
                        <td><?php echo $total_target_call_keseluruhan; ?></td>
                        <td><?php echo $total_call_keseluruhan; ?></td>
                        <td><?php echo $total_persen_call ?> %</td>
                        <td><?php echo $total_effective_call_keseluruhan; ?></td>
                        <td><?php echo $total_new_customer_keseluruhan; ?></td>
                        <td><?php echo $total_persen_effective_call; ?> %</td>
                    </tfoot>    
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
	   $("#date").datepicker({ dateFormat: "dd-mm-yy" }).val()
	   
</script>


