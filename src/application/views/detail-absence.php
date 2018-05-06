 <!-- HEADER -->
 <section class="content-header">
          <h1>
            Motorist
            <small>Detail Absence</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="<?php echo BASE_URL(); ?>"><i class="fa fa-dashboard"></i>Home</a></li>
            <li><a href="<?php echo BASE_URL()."absence"; ?>"><i class="fa fa-dashboard"></i>Data Absence</a></li>
          </ol>
        </section>
  
  
   <!-- Content -->
   <section class="content">
          <div class="box sms box-default color-palette-box">
            <div class="box-header with-border">
              <h3 class="box-title"><i class="fa fa-edit"></i> Detail Absence</h3>
            </div>
            <div class="box-body">
            
           		
                <div class="box-body">
            
                    
                    <div class="form-group">
                      <label for="exampleInputEmail1">Lokasi Toko</label> : 
                     <div id="map"></div>
                    </div>
                    
                    
                    <div class="form-group">
                      <label for="exampleInputEmail1">Foto Absensi</label> :  
                      <img src="http://103.195.30.218/etools-offline/foto-absen/<?php echo $image_absence; ?>" style="width:300px; height:100% display:block;">
                      <br/>
                      
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
                      <label for="exampleInputEmail1">Latitude</label> : 
                      <?php echo $latitude; ?>
                    </div>
                    
                    
                    <div class="form-group">
                      <label for="exampleInputEmail1">Longitude</label> : 
                      <?php echo $longitude; ?>
                    </div>
                    
                    
                    <div class="form-group">
                      <label for="exampleInputEmail1">Konfirmasi Kasir</label> : 
                      <?php echo $konfirmasi_kasir; ?>
                    </div>
                    
                    
                     <div class="form-group">
                      <label for="exampleInputEmail1">Tanggal Absensi</label> : 
                      <?php echo $date_absence; ?>
                    </div>
                   	
                     <div class="form-group">
                      <label for="exampleInputEmail1">Tanggal Konfirmasi Kasir</label> : 
                      <?php echo $tanggal_konfirmasi_kasir; ?>
                    </div>
                    
                    
                 
                    
                    
                    
                   
                   
                   
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