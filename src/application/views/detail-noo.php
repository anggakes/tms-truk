 <!-- HEADER -->
 <section class="content-header">
          <h1>
            Store
            <small>Detail Noo</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="<?php echo BASE_URL(); ?>"><i class="fa fa-dashboard"></i>Home</a></li>
            <li><a href="<?php echo BASE_URL()."store/editStore"; ?>"><i class="fa fa-dashboard"></i>Edit Store</a></li>
          </ol>
        </section>
  
  
   <!-- Content -->
   <section class="content">
          <div class="box sms box-default color-palette-box">
            <div class="box-header with-border">
              <h3 class="box-title"><i class="fa fa-edit"></i> Detail Noo</h3>
            </div>
            <div class="box-body">
            
           	
                <div class="box-body">
            
                    
                    <div class="form-group">
                      <label for="exampleInputEmail1">Lokasi Toko</label> : 
                     <div id="map"></div>
                    </div>
                    
                    
                    
                    <div class="form-group">
                      <label for="exampleInputEmail1">Motorist Code</label> : 
                      <?php echo $id_noo; ?>
                    </div>
                    
                    
                    <div class="form-group">
                      <label for="exampleInputEmail1">Distributor Code</label> : 
                      <?php echo $distributor_code; ?>
                    </div>
                    
                    <div class="form-group">
                      <label for="exampleInputEmail1">Distributor Name</label> : 
                      <?php echo $distributor_name; ?>
                    </div>
                    
                     <div class="form-group">
                      <label for="exampleInputEmail1">Motorist Code</label> : 
                      <?php echo $motorist_code; ?>
                    </div>
                    
                     <div class="form-group">
                      <label for="exampleInputEmail1">Motorist Name</label> : 
                      <?php echo $motorist_name; ?>
                    </div>
                    
                    <div class="form-group">
                      <label for="exampleInputEmail1">Hari Kunjungan</label> : 
                      <?php echo $day_visit; ?>
                    </div>
                    
                    <div class="form-group">
                      <label for="exampleInputEmail1">Frekuensi Kunjungan</label> : 
                      <?php echo $frequency; ?>
                    </div>
                    
                    <div class="form-group">
                      <label for="exampleInputEmail1">Customer name</label> : 
                      <?php echo $customer_name; ?>
                    </div>
                    
                    <div class="form-group">
                      <label for="exampleInputEmail1">Channel Code</label> : 
                      <?php echo $channel_code; ?>
                    </div>
                    
                    <div class="form-group">
                      <label for="exampleInputEmail1">Channel Name</label> : 
                      <?php echo $channel_name; ?>
                    </div>
                    
                    
                    <div class="form-group">
                      <label for="exampleInputEmail1">Place Status</label> : 
                      <?php echo $place_status; ?>
                    </div>
                    
                    <div class="form-group">
                      <label for="exampleInputEmail1">Address</label> : 
                      <?php echo $address; ?>
                    </div>
                    
                    
                     <div class="form-group">
                      <label for="exampleInputEmail1">Kecamatan</label> : 
                      <?php echo $districts; ?>
                    </div>
                    
                    <div class="form-group">
                      <label for="exampleInputEmail1">Customer Contact</label> : 
                      <?php echo $customer_contact; ?>
                    </div>
                    
                    
                     <div class="form-group">
                      <label for="exampleInputEmail1">Customer Contact</label> : 
                      <?php echo $customer_contact; ?>
                    </div>
                    
                    
                    <div class="form-group">
                      <label for="exampleInputEmail1">Latitude</label> : 
                      <?php echo $latitude; ?>
                    </div>
                    
                    
                    <div class="form-group">
                      <label for="exampleInputEmail1">Longitude</label> : 
                      <?php echo $longitude; ?>
                    </div>
                    
                    
                    <div class="form-group">
                      <label for="exampleInputEmail1">Foto Toko</label> :  
                      <img src="http://103.31.251.169/etools-apps/foto-store/foto-store-noo/<?php echo $foto_toko; ?>" style="width:500px; height:auto; display:block;">
                    </div>
                    
                    
                    <?php if($product=="bukan_carnation"){ ?>
                     <div class="form-group">
                      <label for="exampleInputEmail1">Foto Product</label> : 
                      <img src="http://http://103.31.251.169/etools-offline/foto-store/foto-store-noo/<?php echo $foto_produk; ?> " style="width:500px; height:auto; display:block;"/>
                    </div>
                    <?php }?>
                    
                    
                    
                   
                   
                   
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
        var bangalore = { lat: <?php echo $latitude; ?>, lng: <?php echo $longitude; ?> };
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