 <!-- HEADER -->
 <section class="content-header">
          <h1>
            Daily Call Strike
            <small>Motorist of E-tools</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="<?php echo BASE_URL(); ?>"><i class="fa fa-dashboard"></i>Home</a></li>
            <li><a href="<?php echo BASE_URL()."dailyCallStrike"; ?>"><i class="fa fa-dashboard"></i>Daily Call Strike</a></li>
          </ol>
        </section>
  
  
   <!-- Content -->
   <section class="content">
          <div class="box sms box-default color-palette-box">
            <div class="box-header with-border">
              <h3 class="box-title"><i class="fa fa-table"></i>Table Daily Call Strike Motorist</h3>
            </div>
            <div class="box-body">
            <?php 
			$id_motorist = isset($_GET['id_motorist']) ? $_GET['id_motorist'] : '';
			$date = isset($_GET['date']) ? $_GET['date'] : '';
			?>
            <div id="wrapper-console" class="clearfix">
                 <div id="wrapper-search">
                             <form id="form-daily-callstrike" action="<?php echo base_url()."index.php/motorist/dailyCallStrikeSidebar" ?>" method="get">
                             <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                                <div class="wrapper-form-input">
                                <input class="required" type="text" id="date" name="date" placeholder="Choose Date" value="<?php echo $date; ?>" />
                                </div>
                                <div class="wrapper-form-input">
                                <select class="required" name="id_motorist" id="id_motorist">
                                	<option value="">Choose Motorist</option>
                                    <?php foreach($data_motorist_array as $data_motorist_array){?>
                                    <option value="<?php echo $data_motorist_array->id_motorist; ?>" ><?php echo $data_motorist_array->motorist_name.'-'.$data_motorist_array->motorist_code;?></option>
                                    <?php } ?>
                                </select>
                                </div>
                                <input type="submit" id="submit"  value="Search"/>
                                <?php if($date!="")
								{?>
                                <a href="<?php echo base_url()."index.php/motorist/dailyCallStrikeSidebar" ?>" id="clear-search">Clear Search</a>
                                <?php } ?>
                             </form>
            </div>
                </div>
                
			<?php
			
			if($date!="" && $id_motorist!=""){
			 ?>
			<div id="map" style="width:100%; height:300px"></div>
			<a target="_blank" href="<?php echo base_url()."index.php/motorist/dailyCallStrikeMap?id_motorist=".$id_motorist; ?>&&date=<?php echo $date; ?>" id="zoom_map">View Full Map</a>
            
			<?php } $message_success = $this->session->flashdata('message_success');
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
			
			function convert_price($price)
			{
				echo "Rp. ".number_format($price, 0 , '' , '.' );		
					}
			if($date!="")
			{
			$tanggal_pecah = explode("/", $date);
			$date_now = $tanggal_pecah[2].'-'.$tanggal_pecah[0].'-'.$tanggal_pecah[1];
			
			
			
			$data_absen = $this->db->query("SELECT * FROM absence WHERE motorist_code = '".$data_motorist[0]['motorist_code']."' AND distributor_code = '".$data_motorist[0]['distributor_code']."' and date_absence LIKE '%".$date_now."%' ")->result_array();
			//echo $data_absen[0]['latitude']."-".$data_absen[0]['longitude'];
			
				
			}
			
			?>
            
      
            
            
            <?php if($id_motorist!="" and $date!=""){ ?>
           <div id="wrapper-button" class="clearfix" style="margin-top:20px;">>
                	<a href="<?php echo base_url()."index.php/motorist/exportDailyCallStrike?id_motorist=".$id_motorist."&&date=".$date; ?>" class="button orange-button">
                    	Export Daily Callstrike
                    </a>
                    
                </div>
                </div>
                <?php } ?>
                
            <?php if($id_motorist!="") { ?>   
            <h3 style="margin-bottom:10px; line-height:10px;">Motorist Name: <?php echo $data_motorist[0]['motorist_name']; ?></h3>  
            <h3>Motorist Code: <?php echo $data_motorist[0]['motorist_code']; ?></h3>
            <?php } ?>
            
            <div class="grid_4 height400">         
           	<table id="myTable03" class="fancyTable table  table-bordered table-hover">
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>ID Order</th>
                        <th>Time In</th>
                        <th>Time Out</th>
                        <th>Duration</th>
                        <th>Outlet</th>
                        <th>Customer Code</th>
                        <th>Channel Code</th>
                        <th>Jualan</th>
                        <th>SKU Sold</th>
                        <th>Actual Sales Of The Days</th>
                        <th>Detail CallStrike</th>
                      </tr>
                    </thead>
                    
                    <?php if($date!="" && $id_motorist!=""){ ?>
                     <?php 
					 $no = 1;
					 $total_order_sku = 0;
					 $time_total = 0;
					 $total_jualan = 0;
					 $total_order = 0;
					 foreach($data_callstrike as $data_callstrike1) {	
						
						$time_in = explode(" ",$data_callstrike1->jam_checkin);
						$time_in = $time_in[1];
						
						$time_checkout = explode(" ",$data_callstrike1->time_stamp_visit);
						$time_checkout = $time_checkout[1];
						$time_diff =  strtotime($time_checkout) - strtotime($time_in)  ;
						
						$select_customer = $this->db->query("SELECT * FROM store WHERE (customer_code = '".$data_callstrike1->customer_code."' OR store_code_websql	 = '".$data_callstrike1->store_code_websql."') ");
						$jumlah_customer = $select_customer->num_rows();
						if($jumlah_customer>=1)
						{
							$data_customer = $select_customer->result_array();
							$customer_name = $data_customer[0]['customer_name'];
							$customer_code = $data_customer[0]['customer_code'];
							$channel_code = $data_customer[0]['channel_code'];
						}
						else{
							
							$customer_name = "Toko ATC ".$data_callstrike1->id_visit;
							$customer_code = $data_callstrike1->id_visit;
							$channel_code = "020201";
						}
						
						if($data_callstrike1->status_order=='order' && $data_callstrike1->id_order!='0')
						{$select_order = $this->db->query("SELECT COUNT(id_product_order) as total_sku,SUM(price_total) as total_harga_benar  FROM product_orders WHERE id_order = '".$data_callstrike1->id_order."' ")->result_array();
						$total_harga_benar = $select_order[0]['total_harga_benar'];
						$total_sku = $select_order[0]['total_sku'];
						}
						else if($data_callstrike1->status_order=='order' && $data_callstrike1->id_order=='0')
						{$select_order = $this->db->query("SELECT COUNT(id_product_order) as total_sku,SUM(price_total) as total_harga_benar  FROM product_orders WHERE order_code_websql = '".$data_callstrike1->	order_code_websql."' ")->result_array();
						$total_harga_benar = $select_order[0]['total_harga_benar'];
						$total_sku = $select_order[0]['total_sku'];
						}
						else{$total_harga_benar=0;$total_sku = 0;}
						
						if($data_callstrike1->status_order=="order")
						{  $total_order  =   $total_order  + 1;}
						
						?>
                        <tr>
                        	<td><?php echo $no ?></td>
                            <td><?php echo $data_callstrike1->id_order; ?></td>
                            <td><?php echo $time_in; ?></td>
                            <td><?php echo $time_checkout; ?></td>
                            <td><?php echo gmdate("H:i:s", $time_diff); ?></td>
                            <td><?php echo $customer_name; ?></td>
                            <td><?php echo $customer_code; ?></td>
                            <td><?php echo $channel_code; ?></td>
                            <td><?php echo $data_callstrike1->status_order; ?></td>
                            <td><?php echo $total_sku; ?></td>
                            <td><?php echo convert_price($total_harga_benar); ?></td>
                            <td><a target="_blank" href="<?php echo base_url()."index.php/motorist/detailCallStrike/".$data_callstrike1->id_visit; ?>">Detail CallStrike</a></td>
                        </tr>
                    <?php 
					$no++;
					$time_total = $time_total+$time_diff;
					$total_jualan = $total_jualan + $total_harga_benar;
					$total_order_sku = $total_order_sku + $total_sku;
					}?>
                    
                    
                    <tfoot>
                      <tr>
                        <th colspan="4">Total</th>
                        <th><?php echo gmdate("H:i:s", $time_total); ?></th>
                        <th><?php echo $no-1; ?> Outlet</th>
                        <th><?php echo $no-1; ?> Customer</th>
                        <th>
                        <?php $data_channel = $this->db->query("SELECT * FROM visit inner JOIN store on store.customer_code = visit.customer_code WHERE visit.id_motorist = '".$id_motorist."' AND time_stamp_visit LIKE '%".$date_now."%' group by store.channel_code ")->num_rows(); ?>
                        <?php echo $data_channel; ?> Channel Code</th>
                        <th><?php echo  $total_order ; ?> Jualan</th>
                        <th><?php echo $total_order_sku ?> SKU </th>
                        <th><?php echo convert_price($total_jualan); ?></th>
                        <th>Detail CallStrike</th>
                      </tr>
                    </tfoot>
                   <?php } ?>
                    
             		<tbody>
                    </tbody>       
             </table>
                   
              </div>
             
            		  
                    
            
           </div>
            </div>
            
            </div>
      </section>
	 
	
<style type="text/css">
  html { height: 100% }
  body { height: 100%; margin: 0; padding: 0 }
  #map_canvas { height: 100% }
   .labels{
		  font-size:16px;
		  color:#FFF;
		  margin-left:-10px !important;
		  text-align:center;
		  width:20px;
		  
	 }
</style>
<script>
$("#form-daily-callstrike").validate();



$("#date").datepicker({ dateFormat: "dd-mm-yy" }).val()
</script>
<script>
$.urlParam = function(name){
		
		
      // This example displays a marker at the center of Australia.
      // When the user clicks the marker, an info window opens.
		var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
		



		if (results==null){
		   return null;
		}
		else{
		   return results[1] || 0;
		}
		};
		
		latitude = -6.713243; // name
		longitude = 106.900470; // name
        function initMap() {
	  
		
		var uluru = new google.maps.LatLng(<?php echo $data_absen[0]['latitude'] ?>, <?php echo $data_absen[0]['longitude'] ?> ); 
		
        var map = new google.maps.Map(document.getElementById('map'), {
          zoom: 4,
          center: uluru
        });
		
		var pinColor = "69fe70";
		var pinImage = new google.maps.MarkerImage("http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=%E2%80%A2|" + pinColor,
        new google.maps.Size(21, 34),
        new google.maps.Point(0,0),
        new google.maps.Point(10, 34));
		var pinShadow = new google.maps.MarkerImage("http://chart.apis.google.com/chart?chst=d_map_pin_shadow",
        new google.maps.Size(40, 37),
        new google.maps.Point(0, 0),
        new google.maps.Point(12, 35));
		
        var contentString = 'Lokasi Absen';
        var infowindow = new google.maps.InfoWindow({
          content: contentString
        });

        var marker = new google.maps.Marker({
          position: uluru,
          map: map,
		  draggable: true,
		  animation: google.maps.Animation.BOUNCE,
          raiseOnDrag: true,
          icon: "<?php echo base_url()."assets_theme/marker/absen.png" ?>",
        });
        marker.addListener('click', function() {
          infowindow.open(map, marker);
        });


		
		$.getJSON("http://www.etools-apps.com/index.php/motorist/getDailyCallstrikeAbsenMap?id_motorist=<?php echo $id_motorist; ?>&&date=<?php echo $date; ?>", function(json1) {
        var i = 1;
		$.each(json1, function(key, data) {
			
				var labels = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
				var labelIndex = 0;


				var uluru1 = new google.maps.LatLng(data.store_latitude, data.store_longitude );
				 var contentString = 'Lokasi Toko' + data.customer_name;
				var infowindow = new google.maps.InfoWindow({
				  content: contentString
				});

				var marker = new google.maps.Marker({
				  position: uluru1,
				  map: map,
				  draggable: true,
				 icon: "<?php echo base_url()."assets_theme/marker/store.png" ?>",
				 label: '' + data.nomor_checkin
				   
				});
				marker.addListener('click', function() {
				  infowindow.open(map, marker);
				});
		
		});
		i++;
        });
		
		
		
		$.getJSON("http://www.etools-apps.com/index.php/motorist/getDailyCallstrikeMap?id_motorist=<?php echo $id_motorist; ?>&&date=<?php echo $date; ?>", function(json1) {
        $.each(json1, function(key, data) {
		  
				var labels = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
				var labelIndex = 0;


				var uluru1 = new google.maps.LatLng(data.visit_latitude, data.visit_longitude );
				 var contentString = 'Lokasi Checkin' + data.customer_name;
				var infowindow = new google.maps.InfoWindow({
				  content: contentString
				});

				var marker = new google.maps.Marker({
				  position: uluru1,
				  map: map,
				  draggable: true,
				 icon: "<?php echo base_url()."assets_theme/marker/location.png" ?>",
				 label: '' + data.nomor_checkin
				   
				});
				marker.addListener('click', function() {
				  infowindow.open(map, marker);
				});
		
		});
		i++;
        });
		
      }
    </script>
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCoxhCpa75Oe6014hzt4R_2O-YZIW9gunY&callback=initMap&language=id"></script>



