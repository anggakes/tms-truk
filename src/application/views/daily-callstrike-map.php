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
              <h3 class="box-title"><i class="fa fa-table"></i>Map Daily Call Strike Motorist</h3>
            </div>
            <div class="box-body">
			
			 <div id="map" style="width:100%; height:800px"></div>
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
			
			function convert_price($price)
			{
				echo "Rp. ".number_format($price, 0 , '' , '.' );		
					}
			$id_motorist = isset($_GET['id_motorist']) ? $_GET['id_motorist'] : '';
			$date = isset($_GET['date']) ? $_GET['date'] : '';
			$tanggal_pecah = explode("/", $date);
			$date_now = $tanggal_pecah[2].'-'.$tanggal_pecah[0].'-'.$tanggal_pecah[1];
		
			?>
			
            <div id="wrapper-console" class="clearfix">
                
                </div>
            <div id="wrapper-console" class="clearfix">  
            <h3 style="margin-bottom:10px; line-height:10px;">Motorist Name: <?php echo $data_motorist[0]['motorist_name']; ?></h3>  
            <h3>Motorist Code: <?php echo $data_motorist[0]['motorist_code']; ?></h3>
            <h3>Tanggal : <?php echo $date; ?></h3>
             
            	<?php
			
			$data_absen = $this->db->query("SELECT * FROM absence WHERE motorist_code = '".$data_motorist[0]['motorist_code']."' AND distributor_code = '".$data_motorist[0]['distributor_code']."' and date_absence LIKE '%".$date_now."%' ")->result_array();
			//echo $data_absen[0]['latitude']."-".$data_absen[0]['longitude'];
			
			?>	  
                    
            
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
	  
		
		var uluru = new google.maps.LatLng(latitude, longitude ); 
		
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

		   $.getJSON("http://www.etools-apps.com/index.php/motorist/getDailyCallstrikeAbsenMap?id_motorist=<?php echo $id_motorist; ?>&&date=<?php echo $date; ?>", function(json1) {
        $.each(json1, function(key, data) {
		  
				var labels = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
				var labelIndex = 0;


				var uluru1 = new google.maps.LatLng(data.absence_latitude, data.absence_longitude );
				 var contentString = 'Lokasi Absence';
				var infowindow = new google.maps.InfoWindow({
				  content: contentString
				});

				var marker = new google.maps.Marker({
				  position: uluru1,
				  map: map,
				  draggable: true,
				 icon: "<?php echo base_url()."assets_theme/marker/absen.png" ?>"
				   
				});
				marker.addListener('click', function() {
				  infowindow.open(map, marker);
				});
		
		});

        });


		
		$.getJSON("http://www.etools-apps.com/index.php/motorist/getDailyCallstrikeMap?id_motorist=<?php echo $id_motorist; ?>&&date=<?php echo $date; ?>", function(json1) {
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







