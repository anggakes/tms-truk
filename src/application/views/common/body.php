<div class="row">
                    

<?php $role = strtolower($this->session->userdata('role')); ?>

	<?php 
					
					function convert_date($date_nya)
					{
						if($date_nya == '0000-00-00')
						{
							echo '';
							}
						else
						{
							$originalDate = $date_nya;
							$newDate = date("d-m-Y", strtotime($originalDate));
							echo $newDate;
						}
					}
					
					function convert_timestamp($timestamp)
					{
						if($timestamp == '0000-00-00 00:00:00')
						{
							echo '';
							
							}
						else
						{
							echo $timestamp;
						}
					}
					
					function convert_number($number)
					{
						$english_format_number = number_format($number);
						echo $english_format_number;
						
						}
					
					
					
					
					?>
                    
<?php
if($role == 'distributor')
{
?>
<div class="col-md-12">
    <div class="content-panel">
        <h4><i class="fa fa-angle-right"></i> Dashboard</h4>
        <hr>
            
            <div class="panel-body">
            <div class="image">
            <img src="../../../assets/img/nestle.png" style=" max-width:100%;" />
            </div>
            
            
            
            </div>
            
    </div><! --/content-panel -->
</div><!-- /col-md-12 -->
<?php } ?>

<?php
if($role == 'administrator' or ($role='transporter' && $data_status_transporter['status_land_transporter']=='yes'))
{
?>
<div class="col-md-12 title-dashboard">
    <div class="content-panel">
        <h4>LAND Transporter</h4>
    </div>
</div>


                    
<div class="col-md-12 half">
    <div class="content-panel">
        <h4> Breakdown Shipment GIT, Unload vs Cloud (Land)</h4>
        <hr>
            
            <div class="panel-body">
           
           	<div class="wrapper-chart">
            <ul class="description">
            	<li><span class="shipment-cloud"></span>Shipment Cloud</li>
                <li><span class="unloaded-shipment"></span>Unloaded Shipment</li>
                <li><span class="git-shipment"></span>Git</li>
            </ul>
                <div id="canvas-holder-land-transporter-1">
                <canvas id="chart-doughnut-area-land-transporter" width="500" height="500"/>
                </div>
            </div>


        	<script>

		   var pieData = [
				{
					value: <?php echo $data_chart['cloud_land_transporter']; ?>,
					color:"#0c71c6",
					highlight: "#1f8be6",
					label: "Shipment Cloud"
				},
				{
					value: <?php echo $data_chart['receive_land_transporter']; ?>,
					color: "#eb2260",
					highlight: "#fa5084",
					label: "Unloaded Shipment"
				},
				{
					value: <?php echo $data_chart['git_land_transporter']; ?>,
					color: "#17bf13",
					highlight: "#38de34",
					label: "Git"
				}

			];
			
			 
			
			


	</script>
            
            </div>
            
 </div><! --/content-panel -->

</div>


<div class="col-md-12 half">
    <div class="content-panel">
        <h4> Shipment Cloud Data Land Transporter</h4>
        <hr>
            
         <div class="panel-body">
 			
            			 <table class="table-chart">
                          <thead>
                                <th><div>Transporter Name</div></th>
                                <th><div>Shipment Number</div></th>
                                <th><div>Distributor</div></th>
                                <th><div>Actual GI Date</div></th>
                                <th><div>ETA</div></th>
                                <th><div>Actual Arrival</div></th>
                                <th><div>Unload At Distributor</div></th>
                            </thead>
                            <tbody class="tbody">
                     			 <?php 
					  			foreach($data_shipmentcloud_land as $data_shipmentcloud_land){	
								?>
                                <tr >
                                	<td ><div><?php echo $data_shipmentcloud_land['transporter_name'];?></div></td>
                                    <td ><div><?php echo $data_shipmentcloud_land['shipment_number']; ?></div></td>
                                    <td ><div><?php echo $data_shipmentcloud_land['distributor_name']; ?></div></td>
                                    <td ><div><?php echo convert_date($data_shipmentcloud_land['actual_gi_date']); ?></div></td>
                                    <td ><div><?php echo convert_date($data_shipmentcloud_land['eta']); ?></div></td>
                                    <td ><div><?php echo convert_date($data_shipmentcloud_land['actual_arrival_distributor_t']); ?></div></td>
                                    <td ><div><?php echo convert_date($data_shipmentcloud_land['unload_date_distributor_transporter']); ?></div></td>
                                </tr>
                                <?php
								} ?>
                        
                        
                          </tbody>
                          </table>
                          
         </div>
            
 </div><! --/content-panel -->
 
 </div>
 
                     
<div class="col-md-12 half">
    <div class="content-panel">
        <h4>Count of Shipment not yet unload by Distributor</h4>
        <hr>
            
            <div class="panel-body">
           
					  			
			
            
            
            
            <div style="width: 90%; margin:0 auto;">
			<canvas id="canvas-satu" height="450" width="600"></canvas>
		</div>


			<script>
        
            var barChartData = {
                labels : [
				<?php 
				foreach($data_distributor_land as $data_distributor_lands){	
								echo '"'.$data_distributor_lands['distributor_name'].'",';
								}
				?>
				
				],
                datasets : [
                    {
                        fillColor : "#3b86f6",
                        strokeColor : "#0654ca",
                        highlightFill: "#518de6",
                        highlightStroke: "#3b86f6",
                        data : [
						
						<?php 
				foreach($data_distributor_land as $data_distributor_lands){	
								echo $data_distributor_lands['total'].',';
								}
				?>
				]
                    }
                ]
        
            }
           
        
            </script>
    
         
            </div>
            
 </div><! --/content-panel -->

</div>



<div class="col-md-12 half">
    <div class="content-panel">
        <h4> Current Performance Land</h4>
        <hr>
            
            <div class="panel-body">
           
           	<div class="wrapper-chart">
            <ul class="description">
            	<li><span class="shipment-cloud"></span>HIT Shipment Cloud</li>
                <li><span class="unloaded-shipment"></span>MISS Unloaded Shipment</li>
            </ul>
                <div id="canvas-current-performance">
                <canvas id="chart-doughnut-current-performance-land" width="500" height="500"/>
                </div>
            </div>


        	<script>

		   var pieData2 = [
				{
					value: <?php echo $data_chart['hit_land']; ?>,
					color:"#0c71c6",
					highlight: "#1f8be6",
					label: "HIT Shipment Cloud"
				},
				{
					value: <?php echo $data_chart['miss_land']; ?>,
					color: "#eb2260",
					highlight: "#fa5084",
					label: "MISS Unloaded Shipment"
				}

			];
			
			 
			
			


	</script>
            
            </div>
            
 </div><! --/content-panel -->

</div>

<script>
function ChartLand() {
  
   var ctx = document.getElementById("chart-doughnut-area-land-transporter").getContext("2d");
   window.myPie = new Chart(ctx).Pie(pieData, {responsive : true});
   
   var ctx2 = document.getElementById("canvas-satu").getContext("2d");
   window.myBar = new Chart(ctx2).Bar(barChartData, {responsive : true});
   
   var ctx3 = document.getElementById("chart-doughnut-current-performance-land").getContext("2d");
   window.myPie = new Chart(ctx3).Pie(pieData2, {responsive : true});

}

</script>

<?php } ?>
<!-- Sea -->
<?php if($role =='administrator' or ($role='transporter' && $data_status_transporter['status_sea_transporter'] == 'yes'))
{
?>
<div class="col-md-12 title-dashboard">
    <div class="content-panel">
        <h4>SEA Transporter</h4>
    </div>
</div> 



<div class="col-md-12 half">
    <div class="content-panel">
        <h4> Breakdown Shipment GIT, Unload vs Cloud (Sea)</h4>
        <hr>
            
            <div class="panel-body">
           
           	<div class="wrapper-chart">
            <ul class="description">
            	<li><span class="shipment-cloud"></span>Shipment Cloud</li>
                <li><span class="unloaded-shipment"></span>Unloaded Shipment</li>
                <li><span class="git-shipment"></span>Git</li>
            </ul>
                <div id="canvas-holder-sea-transporter-1">
                <canvas id="chart-doughnut-area-sea-transporter" width="500" height="500"/>
                </div>
            </div>


        	<script>

		   var pieDataSeaShipment = [
				{
					value: <?php echo $data_chart['cloud_sea_transporter']; ?>,
					color:"#0c71c6",
					highlight: "#1f8be6",
					label: "Shipment Cloud"
				},
				{
					value: <?php echo $data_chart['receive_sea_transporter']; ?>,
					color: "#eb2260",
					highlight: "#fa5084",
					label: "Unloaded Shipment"
				},
				{
					value: <?php echo $data_chart['git_sea_transporter']; ?>,
					color: "#17bf13",
					highlight: "#38de34",
					label: "Git"
				}

			];
			
			 
			
			


	</script>
            
            </div>
            
 </div><! --/content-panel -->

</div>



<div class="col-md-12 half">
    <div class="content-panel">
        <h4> Shipment Cloud Data Sea Transporter</h4>
        <hr>
            
         <div class="panel-body">
 			
            			 <table class="table-chart">
                          <thead>
                                <th><div>Transporter Name</div></th>
                                <th><div>Shipment Number</div></th>
                                <th><div>Distributor</div></th>
                                <th><div>Actual GI Date</div></th>
                                <th><div>ETA</div></th>
                                <th><div>Actual Arrival</div></th>
                                <th><div>Unload At Distributor</div></th>
                            </thead>
                            <tbody class="tbody">
                     			 <?php 
					  			foreach($data_shipmentcloud_sea as $data_shipmentcloud_sea){	
								?>
                                <tr >
                                	<td ><div><?php echo $data_shipmentcloud_sea['transporter_name'];?></div></td>
                                    <td ><div><?php echo $data_shipmentcloud_sea['shipment_number']; ?></div></td>
                                    <td ><div><?php echo $data_shipmentcloud_sea['distributor_name']; ?></div></td>
                                    <td ><div><?php echo convert_date($data_shipmentcloud_sea['actual_gi_date']); ?></div></td>
                                    <td ><div><?php echo convert_date($data_shipmentcloud_sea['eta']); ?></div></td>
                                    <td ><div><?php echo convert_date($data_shipmentcloud_sea['actual_arrival_distributor_t']); ?></div></td>
                                    <td ><div><?php echo convert_date($data_shipmentcloud_sea['unload_date_distributor_transporter']); ?></div></td>
                                </tr>
                                <?php
								} ?>
                        
                        
                          </tbody>
                          </table>
                          
         </div>
            
 </div><! --/content-panel -->
 
 </div>
 
 
                   
<div class="col-md-12 half">
    <div class="content-panel">
        <h4>Count of Shipment not yet unload by Distributor</h4>
        <hr>
            
            <div class="panel-body">
           
					  			
			
            
            
            
            <div style="width: 90%; margin:0 auto;">
			<canvas id="canvas-dua" height="450" width="600"></canvas>
		</div>


			<script>
        
            var barChartDataSea = {
                labels : [
				<?php 
				foreach($data_distributor_sea as $data_distributor_seas){	
								echo '"'.$data_distributor_seas['distributor_name'].'",';
								}
				?>
				
				],
                datasets : [
                    {
                        fillColor : "#3b86f6",
                        strokeColor : "#0654ca",
                        highlightFill: "#518de6",
                        highlightStroke: "#3b86f6",
                        data : [
						
						<?php 
				foreach($data_distributor_sea as $data_distributor_seas){	
								echo $data_distributor_seas['total'].',';
								}
				?>
				]
                    }
                ]
        
            }
           
        
            </script>
    
         
            </div>
            
 </div><! --/content-panel -->

</div>



<div class="col-md-12 half">
    <div class="content-panel">
        <h4> Current Performance Sea</h4>
        <hr>
            
            <div class="panel-body">
           
           	<div class="wrapper-chart">
            <ul class="description">
            	<li><span class="shipment-cloud"></span>HIT Shipment Cloud</li>
                <li><span class="unloaded-shipment"></span>MISS Unloaded Shipment</li>
            </ul>
                <div id="canvas-current-performance-sea">
                <canvas id="chart-doughnut-current-performance-sea" width="500" height="500"/>
                </div>
            </div>


        	<script>

		   var CurrentPerformanceSea = [
				{
					value: <?php echo $data_chart['hit_sea']; ?>,
					color:"#0c71c6",
					highlight: "#1f8be6",
					label: "Shipment Cloud"
				},
				{
					value: <?php echo $data_chart['miss_sea']; ?>,
					color: "#eb2260",
					highlight: "#fa5084",
					label: "Unloaded Shipment"
				}

			];
			
			 
			
			


	</script>
            
            </div>
            
 </div><! --/content-panel -->

</div>


<div class="col-md-12 half">
    <div class="content-panel">
        <h4> Sea Shipment Status</h4>
        <hr>
            
            <div class="panel-body">
            
            
           	<div class="wrapper-chart">
            <ul class="description">
            	<li><span class="shipment-cloud"></span>Not Departure</li>
                <li><span class="unloaded-shipment"></span>On Sailing</li>
                <li><span class="git-shipment"></span>Not Yet Unload</li>
                <li><span class="unloaded2"></span>Unloaded</li>
            </ul>
                <div id="canvas-holder-shipment-status">
                <canvas id="chart-doughnut-last" width="500" height="500"/>
                </div>
            </div>


        	<script>

			   var pieDataLast = [
					{
						value: <?php echo $data_chart['data_shipment_not_departure']; ?>,
						color:"#0c71c6",
						highlight: "#1f8be6",
						label: "Not Departure"
					},
					{
						value: <?php echo $data_chart['data_shipment_on_sailing']; ?>,
						color: "#eb2260",
						highlight: "#fa5084",
						label: "On Sailing"
					},
					{
						value: <?php echo $data_chart['data_shipment_not_unload']; ?>,
						color: "#17bf13",
						highlight: "#38de34",
						label: "Not Yet Unload"
					},
					{
						value: <?php echo $data_chart['data_shipment_unload']; ?>,
						color: "#b127f1",
						highlight: "#cb5aff",
						label: "Unloaded"
					}
	
				];
			
			 
			
			


			</script>
           
           	
            </div>
            
 </div><! --/content-panel -->

</div>


<script>
function ChartSea() {
	
	 var ctx4 = document.getElementById("chart-doughnut-area-sea-transporter").getContext("2d");
				 window.myPie = new Chart(ctx4).Pie(pieDataSeaShipment, {responsive : true});
				 
				  var ctx5 = document.getElementById("canvas-dua").getContext("2d");
                 window.myBar = new Chart(ctx5).Bar(barChartDataSea, {responsive : true});
				 
				  var ctx6 = document.getElementById("chart-doughnut-current-performance-sea").getContext("2d");
				 window.myPie = new Chart(ctx6).Pie(CurrentPerformanceSea, {responsive : true});
				 
				  var ctx7 = document.getElementById("chart-doughnut-last").getContext("2d");
				 window.myPie = new Chart(ctx7).Pie(pieDataLast, {responsive : true});
  
}

</script>
<?php } ?>

<script>



window.onload = function(){
				
			
				
				<?php if($role =='administrator' or ($role='transporter' && $data_status_transporter['status_land_transporter'] == 'yes'))
				{
				?>
					ChartLand();
				<?php } ?>
				
				<?php if($role =='administrator' or ($role='transporter' && $data_status_transporter['status_sea_transporter'] == 'yes'))
				{
				?>
					ChartSea();
				<?php } ?>
				
				
};
			
</script>
  