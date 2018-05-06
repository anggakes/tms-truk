 <!-- HEADER -->
 <section class="content-header">
          <h1>
            DSOR
            <small>Summary penjualan per salesman</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="<?php echo BASE_URL(); ?>"><i class="fa fa-dashboard"></i>Home</a></li>
            <li><a href="<?php echo BASE_URL()."dailySalesMotoristAdo"; ?>"><i class="fa fa-dashboard"></i>Summary penjualan per salesman</a></li>
          </ol>
        </section>
  
  
   <!-- Content -->
   <section class="content">
          <div class="box sms box-default color-palette-box">
            <div class="box-header with-border">
              <h3 class="box-title"><i class="fa fa-table"></i> Table Summary penjualan per salesman</h3>
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
			
			$tanggal_pecah = explode("/", $date);
			
			
			?>
            <div id="wrapper-console" class="clearfix">
                <div id="wrapper-search">
                             <form action="<?php echo base_url()."index.php/motorist/dailySalesMotoristAdo" ?>" method="get">
                             <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                                <input type="text" id="date" name="date" placeholder="Choose Date" value="<?php echo $date; ?>" />
                               
                                
                                <input type="text" id="search" name="search" placeholder="Search Motorist Code"  value="<?php echo $search; ?>" />
                                <input type="submit" id="submit"  value="Search"/>
                                <?php if($search!="")
								{?>
                                <a href="<?php echo base_url()."index.php/motorist/dailySalesMotoristAdo" ?>" id="clear-search">Clear Search</a>
                                <?php } ?>
                             </form>
                </div>
                
                <div id="wrapper-button" class="clearfix">
                	<a href="<?php echo base_url()."index.php/motorist/exportDailySalesMotoristAdo?search=".$search."&&date=".$date; ?>" class="button orange-button">
                    	Export Summary penjualan per salesman
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
						Target Penjualan</div></th>
                        <th class="mid"><div class="mid">
						Stock Harian</div></th>
                        <th class="mid"><div class="mid">
						Setoran</div></th>
                        <th class="mid"><div class="mid">
						Actual Penjualan</div></th>
                        <th class="mid"><div class="mid">
						% Pencapaian Pejualan</div></th>
                        <th class="mid"><div class="mid">
						Selisih Setoran</div></th>
                      </tr>
                    </thead>
             		<tbody>
                    
                    <?php 
					$no =0;
					$total_target_penjualan_keseluruhan = 0;
					$total_stock_harian_keseluruhan = 0;
					$total_setoran_keseluruhan = 0;
					$total_actual_penjualan_keseluruhan = 0;
					$total_selisih_setoran_keseluruhan = 0;
					
					foreach($data_motorist as $data_motorist) {
					$persentasi_target_harian = 0;	
					
							if($data_motorist->total_daily_sales>0)
							{
							$persentasi_target_harian = ($data_motorist->total_daily_sales * 100) / $data_motorist->target_harian;
							$persentasi_target_harian = number_format($persentasi_target_harian, 0, '.', '');
							}
							
					?>
                    
                    
                    <tr>
                    	<td><div style="width:320px;"><?php echo $data_motorist->motorist_name; ?>-<?php echo $data_motorist->motorist_code; ?></div></td>
                        <td><?php echo $data_motorist->motorist_code; ?></td>
                        <td><?php echo convert_price($data_motorist->target_harian); ?></td>
                        <td>
                        <?php
									$total_price_day = $this->db->query("SELECT * FROM stock INNER JOIN product on product.id_product =  stock.id_product  WHERE stock.id_motorist = '".$data_motorist->id_motorist."' AND stock.date LIKE '%".$tanggal_pecah[2].'-'.$tanggal_pecah[0].'-'.$tanggal_pecah[1]."%'")->result();
									$total_rupiah_all = 0;
									foreach($total_price_day as $total_price_day) {
									
									$total_rupiah = $total_price_day->stock * $total_price_day->price_pcs; 
									$total_rupiah_all = $total_rupiah + $total_rupiah_all;
									}
						echo convert_price($total_rupiah_all);
						?>
                        
                        </td>
                        <td><?php echo convert_price($data_motorist->total_daily_setoran);
						$selisih_setoran = $data_motorist->total_daily_setoran - $data_motorist->total_daily_sales;
						 ?></td>
                        <td><?php echo convert_price($data_motorist->total_daily_sales); ?></td>
                        <td>
                        <?php echo convert_price($persentasi_target_harian); ?> %
                        </td>
                        <td <?php if($selisih_setoran<0){ ?> class="red" <?php } else if($selisih_setoran>0){ ?> class="orange" <?php } ?> ><?php echo convert_price($selisih_setoran); ?></td>
                       
                    </tr>
                    <?php $no++;
					$total_target_penjualan_keseluruhan = $total_target_penjualan_keseluruhan + $data_motorist->target_harian;
					$total_stock_harian_keseluruhan = $total_stock_harian_keseluruhan + $total_rupiah_all;
					$total_setoran_keseluruhan = $total_setoran_keseluruhan + $data_motorist->total_daily_setoran;
					$total_actual_penjualan_keseluruhan = $total_actual_penjualan_keseluruhan + $data_motorist->total_daily_sales;
					$total_selisih_setoran_keseluruhan = $total_selisih_setoran_keseluruhan + $selisih_setoran;
					}
					?>
                    </tbody>   
                    
                    
                    <?php
							$persentasi_total_pencapaian = 20;
		                 	if($total_target_penjualan_keseluruhan>0)
							{   
							$persentasi_total_pencapaian = ($total_actual_penjualan_keseluruhan * 100) / $total_target_penjualan_keseluruhan;
							$persentasi_total_pencapaian = number_format($persentasi_total_pencapaian, 0, '.', '');
							}
					?>
                    <tfoot>
                    	<td>Total</td>
                        <td><?php echo $no; ?> </td>
                        <td><?php echo convert_price($total_target_penjualan_keseluruhan);  ?></td>
                        <td><?php echo convert_price($total_stock_harian_keseluruhan);  ?></td>
                        <td><?php echo convert_price($total_setoran_keseluruhan);  ?></td>
                        <td><?php echo convert_price($total_actual_penjualan_keseluruhan);  ?></td>
                        <td><?php echo $persentasi_total_pencapaian  ?> %</td>
                        <td><?php echo convert_price($total_selisih_setoran_keseluruhan)  ?></td>
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


