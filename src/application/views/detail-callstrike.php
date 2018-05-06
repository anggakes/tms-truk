 <!-- HEADER -->
 <section class="content-header">
          <h1>
            Detail 
            <small>CallStrike</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="<?php echo BASE_URL(); ?>"><i class="fa fa-dashboard"></i>Home</a></li>
            <li><a href="<?php echo BASE_URL()."dailySummaryMotorist"; ?>"><i class="fa fa-dashboard"></i>Daily Summary Motorist</a></li>
          </ol>
        </section>
  
  
   <!-- Content -->
   <section class="content">
          <div class="box sms box-default color-palette-box">
            <div class="box-header with-border">
              <h3 class="box-title"><i class="fa fa-edit"></i> Detail CallStrike</h3>
            </div>
            <div class="box-body">
                <div class="box-body">
            		
                    <?php
						$time_in = explode(" ",$data_visit[0]['waktu_visit']);
						$time_in = $time_in[1];
						
						$time_checkout = explode(" ",$data_visit[0]['time_stamp_visit']);
						$time_checkout = $time_checkout[1];
						$time_diff =  strtotime($time_checkout) - strtotime($time_in)  ;
						echo $time_diff;						
					?>
                    
                     <?php
			
						function convert_price($price)
						{
							echo "Rp. ".number_format($price, 0 , '' , '.' );		
								}
					?>
                    
                    <div class="form-group">
                      <label for="exampleInputEmail1">Lokasi Checkin</label> : 
                     <div id="map"></div>
                    </div>
                    
                    <div class="form-group">
                      <label for="exampleInputEmail1">Jam Checkin</label> : 
                      <?php echo $time_in; ?>
                    </div>
                    
                    <div class="form-group">
                      <label for="exampleInputEmail1">Jam Checkout</label> : 
                      <?php echo $time_checkout; ?>
                    </div>
                    
                    <div class="form-group">
                      <label for="exampleInputEmail1">Durasi</label> : 
                      <?php echo gmdate("H:i:s", $time_diff); ?>
                    </div>
                    
                    <div class="form-group">
                      <label for="exampleInputEmail1">Status Order</label> : 
                      <?php echo $data_visit[0]['status_order']; ?>
                    </div>
                    
                    
                    <?php if($data_visit[0]['status_order']=='order'){ ?>
                    
                    <div class="form-group">
                      <label for="exampleInputEmail1">Total SKU Sold</label> : 
                      <?php echo $data_visit[0]['total_sku']; ?>
                    </div>
                    
                     <div class="form-group">
                      <label for="exampleInputEmail1">Total Order</label> : 
                      <?php echo convert_price($data_total_order[0]['total_harga']); ?>
                    </div>
                    <?php } else{?>
                    
                    <div class="form-group">
                      <label for="exampleInputEmail1">Foto Toko Tutup</label> :  
                      <img src="http://www.etools-apps.com/etools-offline/foto-store/foto-store-tutup/<?php echo $data_visit[0]['foto_toko_tutup']; ?>" style="display:block; width:300px; heigh:auto;">
                    </div>
                    
                    <?php } ?>
                    
					<?php if($data_visit[0]['status_order']=='order'){ ?>
					<table id="example2" class="table table-bordered table-hover">
                    <thead>
                      <tr>
                        <th>Id Produk Order</th>
                        <th>Produk Order</th>
                        <th>Harga</th>
                        <th>Jumlah Qty</th>
                        <th>Total Harga</th>
                      </tr>
                    </thead>
             		<tbody>
                    <?php
					$total_harga_keseluruhan = 0;
					$total_keseluruhan = 0 ;
					$total_qty = 0;

					foreach($data_product_orders  as $data_product_orders )
					{
						$total_harga_keseluruhan = $total_harga_keseluruhan +  $data_product_orders->price;
						$total_keseluruhan = $total_keseluruhan +  $data_product_orders->price_total;
						$total_qty = $total_qty +  $data_product_orders->qty;
						?>
                    <tr>
                    	<td><?php echo $data_product_orders->id_product_order; ?></td>
                        <td><?php echo $data_product_orders->sku_front_end; ?></td>
                        <td><?php echo convert_price($data_product_orders->price); ?></td>
                        <td><?php echo $data_product_orders->qty; ?></td>
                        <td><?php echo convert_price($data_product_orders->price_total); ?></td>
                        </tr>
                    <?php }?>
					
					 <tr>
                    	<td colspan=2>Total</td>
                        <td><?php echo convert_price($total_harga_keseluruhan); ?></td>
						<td><?php echo $total_qty; ?></td>
                        <td><?php echo convert_price($total_keseluruhan); ?></td>
                        </tr>
                    </tbody>       
             </table>
			 <?php } ?>
			 
                  </div><!-- /.box-body -->

            
           </div>
            </div>
            
            </div>
      </section>
 <style>
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
      #map {
        height: 400px;
		width:600px;
      }
    </style>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCoxhCpa75Oe6014hzt4R_2O-YZIW9gunY&callback"> </script>
 <script>
      // In the following example, markers appear when the user clicks on the map.
      // Each marker is labeled with a single alphabetical character.
      var labels = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
      var labelIndex = 0;

      function initialize() {
        var bangalore = { lat: <?php echo $data_visit[0]['latitude']; ?>, lng: <?php echo $data_visit[0]['longitude']; ?> };
        var map = new google.maps.Map(document.getElementById('map'), {
          zoom: 12,
          center: bangalore
        });

        // This event listener calls addMarker() when the map is clicked.
        

        // Add a marker at the center of the map.
        addMarker(bangalore, map);
      }

      // Adds a marker to the map.
      function addMarker(location, map) {
        // Add the marker at the clicked location, and add the next-available label
        // from the array of alphabetical characters.
        var marker = new google.maps.Marker({
          position: location,
          label: labels[labelIndex++ % labels.length],
          map: map
        });
      }

      google.maps.event.addDomListener(window, 'load', initialize);
    </script>