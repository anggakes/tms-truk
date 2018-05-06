 <!-- HEADER -->
 <section class="content-header">
          <h1>
            Workshop By
            <small>List Of Workshop By Status</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="<?php echo BASE_URL(); ?>"><i class="fa fa-dashboard"></i>Home</a></li>
            <li><a href="<?php echo BASE_URL()."room_service_management/roomServiceStatus"; ?>"><i class="fa fa-dashboard"></i>Workshop By Status</a></li>
          </ol>
        </section>
  
  
   <!-- Content -->
   <section class="content">
		
		
  
  
          <div class="box sms box-default color-palette-box">
            <div class="box-header with-border">
              <h3 class="box-title"><i class="fa fa-table"></i> Table Workshop Bay Status</h3>
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
			function convert_price($price)
			{
				echo "Rp. ".number_format($price, 0 , '' , '.' );		
					}
			?>
         
		 
				<?php
					$data_room_service = $this->db->query("SELECT * FROM room_service ")->result();
					foreach($data_room_service as $data_room_service){
					
					
					$select_room_service = $this->db->query("SELECT * FROM room_service_management WHERE room_service_id = '".$data_room_service->room_service_id."' AND service_status = 'On Progress' ");
					$check_room_service = $select_room_service->num_rows();
					
					$service_type = 'empty';
					$vehicle_id = '';
					$mecanic = 'empty';
					$start_service_date = '-';
					$finished_service_date = '-';
					$service_status = '-';
					$service_time = '-';
					
					$id_room_service = '';
					
					$background = 'bg-abu';
					
					if($check_room_service>=1)
					{
						$data_room_service_detail = $select_room_service->result_array();
						$id_room_service = $data_room_service_detail[0]['id_room_service_management'];
						$service_type = $data_room_service_detail[0]['service_type'];
						$vehicle_id = $data_room_service_detail[0]['vehicle_id'];
						$mecanic = $data_room_service_detail[0]['mecanic'];
						$start_service_date = $data_room_service_detail[0]['start_service_date'];
						$finished_service_date = '-';
						$service_status = $data_room_service_detail[0]['service_status'];
						$service_time = $data_room_service_detail[0]['start_service_time'];
						
						if($service_type=='Medium Repair')
						{$background='bg-aqua';}
						else if($service_type=='Quick Repair')
						{$background='bg-green';}	
						else if($service_type=='Heavy')
						{$background='bg-red';}
						else if($service_type=='Preventive')
						{$background='bg-yellow';}
						
					}
					
					
						
				?>
					<div class="col-lg-3 col-xs-6 box_room_service">
					  <!-- small box -->
					  <div class="small-box <?php echo $background; ?>">
						<div class="inner">
						  <h4><?php echo $data_room_service->room_service_name; ?></h4>
						  <span class='status_repair'><?php echo $service_type; ?></span>
						  <h2 class='truck_id'><?php echo $vehicle_id; ?></h2>
						  <span class='mecanic_title'>Mechanic : </span>
						  <span class='mecanic'><?php echo $mecanic; ?></span>
						  <span class='date_title'>Start Date :</span>
						  <span class='date'><?php echo $start_service_date; ?> <?php echo $service_time; ?></span>
						</div>
						 
						 <?php if($id_room_service!='') { ?>
						 <a style='display:block;' id="<?php echo $id_room_service; ?>" class="edit_data link_action"><span class='service_status service_status_<?php echo $id_room_service; ?>'><?php echo $service_status; ?></span></a>
						 <?php }else{ ?>
						 <span class='service_status'><?php echo $service_status; ?></span>
						 <?php } ?>
						 
					  </div>
					 </div>
					 
					<?php } ?>
					 
					 
					 
		 
					 
					 
					

					
					
            </div>
            
            </div>
      </section>

	
	
	
	<div class="remodal" data-remodal-id="modal_edit" role="dialog" aria-labelledby="modal1Titl aria-describedby="modal1Desc">
	  <button data-remodal-action="close" class="remodal-close" aria-label="Close"></button>
	  <div>
		<h2 id="modal1Title">Update Room Service Status</h2>
				<form role="form" id="form_edit_data" method="POST" action="<?php echo base_url()."index.php/room_service_management/updateRoomServiceStatus" ?>" enctype="multipart/form-data">
				 <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
				 
              <div class="box-body">
			  
				<div class="form-group">
					<select class="form-control" name="service_status" id="service_status" required="" aria-required="true">
							<option value="On Progress">On Progress</option>
							<option value="queue">Queue</option>
							<option value="Finished">Finished</option>
					</select>
				</div>
				
                <input type="hidden" class="form-control" name="id_room_service_management_update" id="id_room_service_management_update">
              
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button data-remodal-action="cancel" class="remodal-cancel">Cancel</button>
				<input type="submit" name="submit_add" class="remodal-confirm" value="Submit" id="submit_add">
              </div>
            </form>
	  </div>
	  <br>
	</div>
	
	
	
	
	
	
	
	
	
	

		
  <script>
			//Date picker
			$('.datepicker').datepicker({
			  autoclose: true,
			  Format: 'dd-mm-yyyy'
			});
  
			$(".delete_data").click(function(){
				var id = $(this).attr('id');
				var room_service_management_code =  $('#data_'+id+' .room_service_management_code').text();
				var id_room_service_management =  $('#data_'+id+' .id_room_service_management span').text();
				$("#reference_delete").text("Room Service Management Code:"+room_service_management_code)
				
			});
			
			
			
			$(".edit_data").click(function(){
				var id = $(this).attr('id');
				var room_service_management_code =  $(".service_status_"+id).text();
				$("#service_status").val(room_service_management_code);
				$("#id_room_service_management_update").val(id);
			});

			
			
			
			
	
	

		
  
  </script>  
		
  <script>

 
//  Usage:
//  $(function() {
//
//    // In this case the initialization function returns the already created instance
//    var inst = $('[data-remodal-id=modal]').remodal();
//
//    inst.open();
//    inst.close();
//    inst.getState();
//    inst.destroy();
//  });

  //  The second way to initialize:
  $('[data-remodal-id=modal2]').remodal({
    modifier: 'with-red-theme'
  });
</script>

<script>
window.location.hash="";


$(".deletelogg").on('click', function () {
    var ids = [];
    $(".toedit").each(function () {
        if ($(this).is(":checked")) {
            ids.push($(this).val());
        }
    });
    if (ids.length) {
        
		$('[data-remodal-id = modal_delete_all]').remodal().open();
		$("#id_room_service_management_delete_all").val(ids);
		
    } else {
        alert("Please select items.");
    }
});



$(document).on('change', '#select_all', function() {

    $(".checkbox_satuan").prop('checked', $(this).prop("checked"));
});

$("#add-data").click(function(){
	$("#form_add_data").trigger('reset');
	$('[data-remodal-id = modal_add]').remodal().open();
	
	var validator = $( "#form_add_data" ).validate();
	validator.resetForm();
	
});

$("#import-data").click(function(){
	$("#form_import_data").trigger('reset');
	$('[data-remodal-id = modal_import]').remodal().open();
	
	var validator = $( "#form_import_data" ).validate();
	validator.resetForm();
});

$(".delete_data").click(function(){
	$('[data-remodal-id = modal_delete]').remodal().open();
});

$(".edit_data").click(function(){
	$('[data-remodal-id = modal_edit]').remodal().open();
	var validator = $( "#form_edit_data" ).validate();
	validator.resetForm();
});

</script>



<script>
		//auto complete Vehicle ID
        $( "#search_vehicle_id" ).autocomplete({
         source: "<?php echo BASE_URL(); ?>/index.php/json/jsonMasterUnit",  
         minLength:0,
		 select: function( event , ui ) {
			  $( "#vehicle_id" ).val(ui.item.value);
			  $(this).val('');
			  return false;
			  
        }    
        })
		.autocomplete( "instance" )._renderItem = function( ul, item ) {
		  return $( "<li style='position:relative; z-index:9999;'>" )
			.append( "<div style='font-size:10px;'>" + item.label +"</div>" )
			.appendTo( ul );
		};
		
		
		//auto complete Room
        $( "#search_room_service" ).autocomplete({
         source: "<?php echo BASE_URL(); ?>/index.php/json/jsonRoomService",  
         minLength:0,
		 select: function( event , ui ) {
			  $( "#room_service_id" ).val(ui.item.room_service_id);
			  $( "#room_service_name" ).val(ui.item.room_service_name);
			  
			  $(this).val('');
			  return false;
			  
        }    
        })
		.autocomplete( "instance" )._renderItem = function( ul, item ) {
		  return $( "<li style='position:relative; z-index:9999;'>" )
			.append( "<div style='font-size:10px;'>" + item.label +"</div>" )
			.appendTo( ul );
		};
		
		
	
		
		
</script>