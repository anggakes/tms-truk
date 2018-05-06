<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>My store locator</title>
		<link rel="stylesheet" type="text/css" href="style.css">
	</head>
	<body>

		<div id="storeLocator" class="storeLocator">
        
       <!-- <div id="alert">
        alert
		</div> --!>

			<!--
				This is the autocomplete address search field.
				It must have the "input" class.
			-->
			<input type="text" style="display:none;" class="input controls" placeholder="Enter an address, city...">
			
			<?php $distributor = isset($_GET['distributor']) ? $_GET['distributor'] : ''; ?>
            <?php $channel = isset($_GET['channel']) ? $_GET['channel'] : ''; ?>
            <?php $ket = isset($_GET['ket']) ? $_GET['ket'] : ''; ?>
            <?php $motorist = isset($_GET['motorist']) ? $_GET['motorist'] : ''; ?>
            <?php $motorist_type = isset($_GET['motorist_type']) ? $_GET['motorist_type'] : ''; ?>
			<?php $distributor_code = isset($_GET['distributor_code']) ? $_GET['distributor_code'] : '';  ?>
            <?php $role = isset($_GET['role']) ? $_GET['role'] : '';  ?>
            <?php $day = isset($_GET['day']) ? $_GET['day'] : '';?>
			<?php $tahun = isset($_GET['tahun']) ? $_GET['tahun'] : '';?>
            
            <?php $regional = isset($_GET['regional']) ? $_GET['regional'] : '';  ?>
            <?php $area = isset($_GET['area']) ? $_GET['area'] : '';?>
            <?php $tipe = isset($_GET['tipe']) ? $_GET['tipe'] : '';?>
            
            <?php $product = isset($_GET['product']) ? $_GET['product'] : ''; ?>
            <?php $transaction_month = isset($_GET['transaction_month']) ? $_GET['transaction_month'] : ''; ?>
            <?php $month = isset($_GET['month']) ? $_GET['month'] : ''; ?>
           
			<!--
				This is the map div which will contain the map generated
				by Google Maps. It must have the "map" class.
			-->
			<div id="map-canvas" class="map"></div>
            
			<!--s
				This is the store list. It must contain the "data-list-stores"
				attribute.
			--><div id="canvas-store" style="display:none;">Show List Store</div>
			<ul id="stores" data-list-stores>
 <li id="hide-store">Hide List Store</li>
				<!--
					This element will be displayed while the stores are
					loading. It must have the "loading" class.
				-->
				<input type="text" name="search_store" id="search_store" placeHolder="Search">
                		<span id="filter-count"></span>
				<p class="loading">Loading...</p>

				<!--
					This element will be displayed if no store is found
					at this place. It must have the "no-store" class.
				-->
				<p class="no-store" style="display: none">No store found.</p>

				<!--
					This element is actually the template which will be
					cloned for each store to show. It is hidden (display: none)
					and must have the "data-store-template" attribute.
				-->
				<li class="store nama-store" data-store-template style="display: none">

					<!--
						The "data-store-link-to-map" on this div specifies
						that when the user clicks on the div, the store should
						be focused on the map. Note that you can add this attribute
						on a big div or only on a tiny link if you want.
					-->
					<div data-store-link-to-map>

						<!--
							The next elements define how this store will be showed
							in the list. The attribute "data-store-attr" defines which
							store data must be shown here. For example, if you want to
							show the name of the store, just use:
								<span data-store-attr="name"></span>
							Then the name will be inserted in the span element.
						-->

						<span class="distance" data-store-attr="distance-miles"></span>

						<!--
							Here is a new notation for the attibute "data-store-attr"
							to specify that it is not only the content that should be
							replaced by a store data, but also the content of an attribute
							(in this case "href"). The syntax is :
								data-store-attr='{"content":"the store property which will
								be used to replace the element's content","attr1":"property
								used for attribute attr1","attr2":"etc"}'
							The attribute content must be valid JSON.
							Note that the following notations are equivalent:
								<span data-store-attr="name"></span>
								<span data-store-attr='{"content":"name"}''></span>
						-->
						<strong>Toko <a  data-store-attr='{"content":"customer_name"}'></a></strong><br>
						Nama Customer : <span data-store-attr="customer_name"></span><br>
                        Kode Customer : <span data-store-attr="customer_code"></span><br>
						Channel : <span data-store-attr="channel_name"></span><br>
                        Alamat : <span data-store-attr="address"></span><br>
                        Kecamatan : <span data-store-attr="districts"></span><br>
                        Motorist: <span data-store-attr="motorist_name"></span>-<span data-store-attr="motorist_code"></span><br>
                        Distributor Name : <span data-store-attr="distributor_name"></span>-<span data-store-attr="distributor_code"></span><br>
                        Hari Kunjungan : <span data-store-attr="day_visit"></span><br>
					</div>
				</li>
			</ul>

			<!--
				This div defines what will be shown in the balloon window which will
				appear when the user clicks on a store on the map. It works exactly as
				the previous template div.
			-->
			<div style="display:none;" data-store-infowindow-template>
				<strong><a  data-store-attr='{"content":"customer_name"}'></a></strong><br>
						Nama Customer : <span data-store-attr="customer_name"></span><br>
                        Kode Customer : <span data-store-attr="customer_code"></span><br>
                        Channel : <span data-store-attr="channel_name"></span><br>
                        Alamat : <span data-store-attr="address"></span><br>
                        Kecamatan : <span data-store-attr="districts"></span><br>
                        Motorist: <span data-store-attr="motorist_name"></span>-<span data-store-attr="motorist_code"></span><br>
                        Distributor Name : <span data-store-attr="distributor_name"></span>-<span data-store-attr="distributor_code"></span><br>
                        Hari Kunjungan : <span data-store-attr="day_visit"></span><br>
                        <img style="width:300px; height:auto;"  data-store-attr='{"src":"foto_toko"}'>
			</div>

		</div>

		<!--
			Remember that the plugins requires jQuery library, and the
			Google Maps API.
		-->
		<script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCoxhCpa75Oe6014hzt4R_2O-YZIW9gunY&callback&amp;libraries=places"> </script>
		 <!--<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCoxhCpa75Oe6014hzt4R_2O-YZIW9gunY&callback"> </script>-->
		<!--
			Include the jQuery plugin.
		-->
        <?php if($tipe=="motorist"){ ?>
		<script src="../jquery.storelctr.js"></script>
        <?php } else if($tipe=="distributor") { ?>
        <script src="../jquery.storelctr-distri.js"></script>
        <?php } ?>
        
 <script>
		$(document).ready(function(){
			
   		 $("#search_store").keyup(function(){
 
        // Retrieve the input field text and reset the count to zero
        var filter = $(this).val(), count = 0;
 
        // Loop through the comment list
        $("li.nama-store").each(function(){
 
            // If the list item does not contain the text phrase fade it out
            if ($(this).text().search(new RegExp(filter, "i")) < 0) {
                $(this).fadeOut();
 
            // Show the list item if the phrase matches and increase the count by 1
            } else {
                $(this).show();
                count++;
            }
        });
 
        // Update the count
				var numberItems = count;
				$("#filter-count").text("Number of Stores = "+count);
			});
		});
		</script>
		<script>

			// When the document is fully loaded...
			$(document).ready(function() {
$( "#hide-store" ).click(function() {
				  $( "#stores" ).hide();
				  $( "#canvas-store" ).show();
				});
				
				$( "#canvas-store" ).click(function() {
				  $( "#stores" ).show();
				  $(this).hide();
				});
				// Here we say that we want to use the plugin
				// on the "storeLocator" div. The storeLocator
				// methods accepts as parameter the options that
				// you want to pass to the plugin.
			    $('#storeLocator').storeLocator({

			    	// The fetchStoresFunction is a quite required
			    	// option. It is a function which take three parameters:
			    	// the latitude and the longitude of the address that
			    	// the user wants to find the store nearby, and the
			    	// function that will be called when the stores are fetched.
			    	// See below for an example of such a function.
			    	fetchStoresFunction: fetchStores,

			    	// This options defines wether the user should be located
			    	// to center the map on his position (it uses HTML5 API).
			    	enableGeolocation: false,

			    	// This is the coordinates of the default location the map
			    	// will be centered to.
			    	defaultLocation: { latitude: -6.203277, longitude: 106.845984 }
					

			    });

			});

			// This example function simply makes an AJAX call to the stores.php
			// script, which returns the stores in JSON format. The script takes
			// two parameters: the latitude and the longitude. When the AJAX call
			// is finished, we call the callback function. The stores will be passed
			// as parameter to this function.
			function fetchStores(lat, lng, callback) {
			    $.get("stores-filter.php?ket=<?php echo $ket; ?>&&distributor_code=<?php echo $distributor_code; ?>&&tahun=<?php echo $tahun; ?>&&role=<?php echo $role; ?>&&distributor=<?php echo $distributor ?>&&channel=<?php echo $channel ?>&&motorist=<?php echo $motorist ?>&&day=<?php echo $day ?>&&product=<?php echo $product ?>&&month=<?php echo $month ?>&&transaction_month=<?php echo $transaction_month ?>&&area=<?php echo $area ?>&&regional=<?php echo $regional ?>&&motorist_type=<?php echo $motorist_type ?>", { lat: lat, lng: lng }, 'json').success(callback);
			}
		</script>
	</body>
</html>
