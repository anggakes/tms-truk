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
			
			 <div id="map" style="width:100%; height:300px"></div>
			 
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
                    
                     <?php 
					 $no = 1;
					 $time_total = 0;
					 $total_jualan = 0;
					 $total_order = 0;
					 foreach($data_callstrike as $data_callstrike1) {	
						
						$time_in = explode(" ",$data_callstrike1->jam_checkin);
						$time_in = $time_in[1];
						
						$time_checkout = explode(" ",$data_callstrike1->time_stamp_visit);
						$time_checkout = $time_checkout[1];
						$time_diff =  strtotime($time_checkout) - strtotime($time_in)  ;
						
						if($data_callstrike1->status_order=="order")
						{  $total_order  =   $total_order  + 1;}
						
						?>
                        <tr>
                        	<td><?php echo $no ?></td>
                            <td><?php echo $data_callstrike1->id_order; ?></td>
                            <td><?php echo $time_in; ?></td>
                            <td><?php echo $time_checkout; ?></td>
                            <td><?php echo gmdate("H:i:s", $time_diff); ?></td>
                            <td><?php echo $data_callstrike1->customer_name; ?></td>
                            <td><?php echo $data_callstrike1->customer_code; ?></td>
                            <td><?php echo $data_callstrike1->channel_code; ?></td>
                            <td><?php echo $data_callstrike1->status_order; ?></td>
                            <td><?php echo $data_callstrike1->total_sku; ?></td>
                            <td><?php echo convert_price($data_callstrike1->total_order); ?></td>
                            <td><a target="_blank" href="<?php echo base_url()."index.php/motorist/detailCallStrike/".$data_callstrike1->id_visit; ?>">Detail CallStrike</a></td>
                        </tr>
                    <?php 
					$no++;
					$time_total = $time_total+$time_diff;
					$total_jualan = $total_jualan + $data_callstrike1->total_order;
					}?>
                    
                    
                    <tfoot>
                      <tr>
                        <th colspan="4">Total</th>
                        <th><?php echo gmdate("H:i:s", $time_total); ?></th>
                        <th><?php echo $no-1; ?> Outlet</th>
                        <th><?php echo $no-1; ?> Customer</th>
                        <th>
                        <?php $data_channel = $this->db->query("SELECT * FROM visit inner JOIN store on store.customer_code = visit.customer_code WHERE id_motorist = '".$id_motorist."' AND time_stamp_visit LIKE '%".$date_now."%' group by store.channel_code ")->num_rows(); ?>
                        <?php echo $data_channel; ?> Channel Code</th>
                        <th><?php echo  $total_order ; ?> Jualan</th>
                        <th>SKU Sold</th>
                        <th><?php echo convert_price($total_jualan); ?></th>
                        <th>Detail CallStrike</th>
                      </tr>
                    </tfoot>
                   
                    
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
</style>
<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?key=AIzaSyCoxhCpa75Oe6014hzt4R_2O-YZIW9gunY&amp;sensor=false"></script>
<script type="text/javascript">

var locations = [];

  function initialize() {

    var myOptions = {
      center: new google.maps.LatLng(-6.17446, 106.822745),
      zoom: 10,
      mapTypeId: google.maps.MapTypeId.ROADMAP

    };
    var map = new google.maps.Map(document.getElementById("map"),
        myOptions);

    setMarkers(map,locations)

  }



  function setMarkers(map,locations){

      var marker, i
	  
  <?php 
  $no_1 = 1;
  foreach($data_callstrike as $data_callstrike1)  {
	  
	  ?>
  
 var loan = "<?php echo $data_callstrike1->customer_name; ?>"
 var lat = <?php echo "$data_callstrike1->visit_latitude"; ?> 
 var long = <?php echo "$data_callstrike1->visit_longitude"; ?> 

 latlngset = new google.maps.LatLng(lat, long);


   var ICON = new google.maps.MarkerImage("<?php echo base_url()."assets_theme/marker/location.png" ?>", null, null, new google.maps.Point(14, 13));
		
  var marker = new google.maps.Marker({  
          map: map, title: loan , position: latlngset , icon: ICON,label: "C", draggable: true,
        raiseOnDrag: true,
        });
        map.setCenter(marker.getPosition())


        var content = "<?php echo $no_1; ?>. Lokasi Checkin " + loan   

  var infowindow = new google.maps.InfoWindow()

google.maps.event.addListener(marker,'click', (function(marker,content,infowindow){ 
        return function() {
           infowindow.setContent(content);
           infowindow.open(map,marker);
		  
        };
    })(marker,content,infowindow)); 
 

 <?php  $no_1++;} ?>
 
  <?php 
   $no_2 = 1;
  foreach($data_callstrike as $data_callstrike1)  {?>
 var loan = "<?php echo $data_callstrike1->customer_name; ?>"
 var lat = <?php echo "$data_callstrike1->store_latitude"; ?> 
 var long = <?php echo "$data_callstrike1->store_longitude"; ?> 

 latlngset = new google.maps.LatLng(lat, long);
 var ICON = new google.maps.MarkerImage("<?php echo base_url()."assets_theme/marker/store.png" ?>", null, null, new google.maps.Point(14, 13));
	
     
		
  var marker = new google.maps.Marker({  
          map: map, title: loan , position: latlngset , icon: ICON, label: "T", draggable: true,
        raiseOnDrag: true
        });
        map.setCenter(marker.getPosition())


        var content = "<?php echo $no_2; ?>. Lokasi Toko " + loan   

  var infowindow = new google.maps.InfoWindow()

google.maps.event.addListener(marker,'click', (function(marker,content,infowindow){ 
        return function() {
           infowindow.setContent(content);
           infowindow.open(map,marker);
		  
        };
    })(marker,content,infowindow)); 
 

 <?php  $no_2++;}; ?>
 
 
  }

google.maps.event.addDomListener(window, 'load', initialize);
  </script>

