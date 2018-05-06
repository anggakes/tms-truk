 <!-- HEADER -->
 <section class="content-header">
          <h1>
            Master POD
            <small>List Of POD</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="<?php echo BASE_URL(); ?>"><i class="fa fa-dashboard"></i>Home</a></li>
            <li><a href="<?php echo BASE_URL()."pod"; ?>"><i class="fa fa-dashboard"></i>Master POD</a></li>
          </ol>
        </section>
  
  
   <!-- Content -->
   <section class="content">
		
		
  
  
          <div class="box sms box-default color-palette-box">
            <div class="box-header with-border">
              <h3 class="box-title"><i class="fa fa-table"></i> Table POD</h3>
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
			function convert_date($date)
			{
				$date = (explode("-",$date));
				$date = $date[2].'-'.$date[1].'-'.$date[0];
				echo $date;
			}
			?>
            <div id="wrapper-console" class="clearfix">
                <div id="wrapper-search">
                             <form action="<?php echo base_url()."index.php/pod" ?>" method="get">
                             <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                                <input type="text" id="search" name="search" placeholder="Search..."  value="<?php echo $search; ?>" />
                                <input type="submit" id="submit"  value="Search"/>
                                <?php if($search!="")
								{?>
                                <a href="<?php echo base_url()."index.php/area" ?>" id="clear-search">Clear Search</a>
                                <?php } ?>
                             </form>
                </div>
                <div id="wrapper-button" class="clearfix">
					<?php if($data_role[0]['delete_pod']=='yes'){ ?>
                    <a id="delete-data" class="button btn-danger update_pod">
                    	Update POD
                    </a>
					<?php } ?>
                </div>
                </div>
            <div id="wrapper-console" class="clearfix"> 
            <div class="grid_4 height400">                  
           	<table id="myTable0" class="fancyTable table table-bordered table-hover">
                    <thead>
                      <tr>
					  
                        <th>
						<div class='mid'>
						<div class="check-box-div"><input type="checkbox" name="select_all" id="select_all"></div>SPK Number
						</div>
						</th>
                        <th><div class='short'>Manifest</div></th>
                        <th><div class='mid'>DO Number</div></th>
						<th><div class='mid'>Schedule Date</div></th>
						<th><div class='mid'>Transporter</div></th>
						<th><div class='mid'>Origin Name</div></th>
						<th><div class='mid'>Origin Area</div></th>
						<th><div class='mid'>Destination Name</div></th>
						<th><div class='mid'>Destination Area</div></th>
						<th><div class='mid'>Status POD</div></th>
                      </tr>
                    </thead>
             		<tbody>
					
					
					<?php foreach($data_pod as $data_pod) {
						$transporter = '';
						if($data_pod->transporter=='assets')
						{$transporter = 'Assets';}
						else if($data_pod->transporter=='vendor')
						{$transporter = $data_pod->transporter_id;}
						
						?>
						<tr>
							<td colspan='10' style='background:#ccc;'>ID Manifest - <?php echo $data_pod->id_manifest; ?> - <?php echo $data_pod->vehicle_id; ?> - <?php echo $transporter; ?> - <?php echo $data_pod->origin_id; ?></td>
						</tr>
					
					
                    <?php 
					
					$data_pod_do = $this->db->query("SELECT * FROM transport_order WHERE manifest = '".$data_pod->id_manifest."' ")->result();
					foreach($data_pod_do as $data_pod_do) {?>
                    <tr id="data_<?php echo $data_pod_do->spk_number; ?>">
                    	<td class="id_pod">
						<div class="check-box-div">
						<input type="checkbox" name="id_checkbox[]" class="iCheck-helper toedit checkbox_satuan" value="<?php echo $data_pod_do->spk_number; ?>" />
						</div><span><?php echo $data_pod_do->spk_number; ?></span></td>
						<?php 
								$data_manifest = $this->db->query("SELECT * FROM master_manifest WHERE id_manifest = '".$data_pod_do->manifest."' ")->result_array();
								$transporter = '';
								if($data_manifest[0]['transporter']=='assets')
								{$transporter = 'Assets';}
								else if($data_manifest[0]['transporter']=='vendor')
								{$transporter = $data_manifest[0]['transporter_id'];}
						?>
                        <td class="manifest"><?php echo $data_pod_do->manifest; ?></td>
                        <td class="do_number"><?php echo $data_pod_do->do_number; ?></td>
						<td class="schedule_date"><?php convert_date($data_manifest[0]['delivery_date']); ?></td>
						<td class="do_number"><?php echo $transporter; ?></td>
						<td class="origin_id"><?php echo $data_pod_do->origin_id; ?></td>
						<td class="origin_address"><?php echo $data_pod_do->origin_address; ?></td>
						<td class="destination_id"><?php echo $data_pod_do->destination_id; ?></td>
						<td class="destination_area"><?php echo $data_pod_do->destination_area; ?></td>
						<td class="status"></td>
					</tr>
                    <?php }?>
					
					<?php } ?>
					
					
                    </tbody>       
             </table>
             </div>
             
            		  <div class="pagination page">  
                     <?php  echo $this->pagination->create_links(); ?>
                     </div>
                    
            
           </div>
            </div>
            
            </div>
      </section>

	  
	
	
	
	<div class="remodal" data-remodal-id="modal_update_all" role="dialog" aria-labelledby="modal1Titl aria-describedby="modal1Desc">
	  <button data-remodal-action="close" class="remodal-close" aria-label="Close"></button>
	  <div>
		<h2 id="modal1Title">Update POD</h2>
				<form role="form" id="form_update_pod" method="POST" action="<?php echo base_url()."index.php/pod/update_pod" ?>" enctype="multipart/form-data">
				 <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
				 
              <div class="box-body pod">

				 
				 
				  <div class="form-group">
						  <label for="drivercode2">Pod Time</label>
						  <div class='wrapper-time-monitoring clearfix'>
						  
						  <div class="input-group checklist tiga_input">
							<input type='checkbox' name='checkbox_pod_time' class='checkbox_pod_time checkbox_pod_time' id='checkbox_pod_time'>
						  </div>
						  
						  <div class="input-group date tiga_input">
						  <div class="input-group-addon">
							<i class="fa fa-calendar"></i>
						  </div>
						  <input type="text" name="checkbox_pod_time_date" id="checkbox_pod_time_date" class="form-control pull-right datepicker checkbox_pod_time_date"  placeholder='POD Date' >
						  </div>
						  
						  <div class="bootstrap-timepicker  tiga_input time">
						  <div class="input-group">
						  <input type="text"  name="checkbox_pod_time_time" id="checkbox_pod_time_time" class="form-control timepicker checkbox_pod_time_time" placeholder='POD Time' >
						  <div class="input-group-addon">
						  <i class="fa fa-clock-o"></i>
						  </div>
						  </div>
					      </div>
						  </div>
				  </div>
				  
				  <div class="form-group">
					  <label for="drivercode2">Code</label>
					  <select class="form-control" name="code_pod" id="code_pod" >
						<option selected="selected" value="">Choose Code</option>
							<?php foreach($data_pod_action as $data_pod_action) {?>
							<option value='<?php echo $data_pod_action->description; ?>'><?php echo $data_pod_action->description; ?></option>
							<?php } ?>
					  </select> 
				</div>
				
				  <div class="form-group">
					 <label for="drivercode2">PIC</label>
					 <input type="text" class="form-control" name="pic" id="pic" >
				  </div>
				  
				 
				  
				   <div class="form-group">
						  <label for="drivercode2">Submit Time</label>
						  <div class='wrapper-time-monitoring clearfix'>
						  
						  <div class="input-group checklist tiga_input">
							<input type='checkbox' name='checkbox_submit_time' class='checkbox_submit_time checkbox_pod_time' id='checkbox_submit_time'>
						  </div>
						  
						  <div class="input-group date tiga_input">
						  <div class="input-group-addon">
							<i class="fa fa-calendar"></i>
						  </div>
						  <input type="text" name="checkbox_submit_time_date" id="checkbox_submit_time_date" class="form-control pull-right datepicker checkbox_submit_time"  placeholder='Submit Date' >
						  </div>
						  
						  <div class="bootstrap-timepicker  tiga_input time">
						  <div class="input-group">
						  <input type="text"  name="checkbox_submit_time_time" id="checkbox_submit_time_time" class="form-control timepicker checkbox_submit_time_time" placeholder='Submit Time' >
						  <div class="input-group-addon">
						  <i class="fa fa-clock-o"></i>
						  </div>
						  </div>
					      </div>
						  </div>
				  </div>
				  
				  <div class="form-group">
					 <label for="drivercode2">Doc Reference</label>
					 <input type="text" class="form-control" name="doc_reference" id="doc_reference">
				  </div>
				  
				   <div class="form-group">
						  <label for="drivercode2">Receive Time</label>
						  <div class='wrapper-time-monitoring clearfix'>
						  
						  <div class="input-group checklist tiga_input">
							<input type='checkbox' name='checkbox_receive_time' class='checkbox_receive_time checkbox_pod_time' id='checkbox_receive_time'>
						  </div>
						  
						  <div class="input-group date tiga_input">
						  <div class="input-group-addon">
							<i class="fa fa-calendar"></i>
						  </div>
						  <input type="text" name="checkbox_receive_time_date" id="checkbox_receive_time_date" class="form-control pull-right datepicker checkbox_receive_time_date"  placeholder='Receive Date' >
						  </div>
						  
						  <div class="bootstrap-timepicker  tiga_input time">
						  <div class="input-group">
						  <input type="text"  name="checkbox_receive_time_time" id="checkbox_receive_time_time" class="form-control timepicker checkbox_receive_time_time" placeholder='Receive Time' >
						  <div class="input-group-addon">
						  <i class="fa fa-clock-o"></i>
						  </div>
						  </div>
					      </div>
						  </div>
				  </div>
				  
				  
				  <div class="form-group">
					 <label for="drivercode2">Receiver</label>
					 <input type="text" class="form-control" name="receiver" id="receiver" >
				  </div>
				
				 <div class="form-group">
                      <input type="hidden" name="id_pod_delete_all" id="id_pod_delete_all" class="form-control" value="" />
				</div>
				
				
              
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
  
			$('.datepicker').datepicker({
			  autoclose: true,
			  Format: 'dd-mm-yyyy'
			});
			
			
			  //Timepicker
			 $(".timepicker").timepicker({
			  showInputs: false
			});
			
			
			$(".edit_data").click(function(){
				var id = $(this).attr('id');
				var id_pod =  $('#data_'+id+' .id_pod span').text();
				var category =  $('#data_'+id+' .category').text();
				var description =  $('#data_'+id+' .description').text();
				
				
				$("#id_pod_update").val(id_pod);
				$("#edit_description").val(description);
				$('#edit_category option[value="' + category + '"]').prop('selected',true);
				
			});

  
</script>  
		

<script>
window.location.hash = "";


$(".update_pod").on('click', function () {
    var ids = [];
    $(".toedit").each(function () {
        if ($(this).is(":checked")) {
            ids.push($(this).val());
        }
    });
    if (ids.length) {
		
		
			
		
		
        $("#form_update_pod").trigger('reset');
		$('[data-remodal-id = modal_update_all]').remodal().open();
		$("#id_pod_delete_all").val(ids);
		
		if(ids.length==1)
		{
			$.ajax({
			  url: '<?php echo BASE_URL(); ?>/index.php/json/jsonPOD?spk_number='+ids,
			  success: function(data,status)
			  {
					var id_pod = data[0]['id_pod'];
					var spk_number = data[0]['spk_number'];
					var pod_date = data[0]['pod_date'];
					var pod_time = data[0]['pod_time'];
					var code = data[0]['code'];
					var pic = data[0]['pic'];
					var submit_date = data[0]['submit_date'];
					var submit_time = data[0]['submit_time'];
					var doc_reference = data[0]['doc_reference'];
					var receive_date = data[0]['receive_date'];
					var receive_time = data[0]['receive_time'];
					var receiver = data[0]['receiver'];
					
					$("#checkbox_pod_time_date").val(pod_date);
					$("#checkbox_pod_time_time").val(pod_time);
					$("#pic").val(pic);
					$("#checkbox_submit_time_date").val(submit_date);
					$("#checkbox_submit_time_time").val(submit_time);
					$("#doc_reference").val(doc_reference);
					$("#checkbox_receive_time_date").val(receive_date);
					$("#checkbox_receive_time_time").val(receive_time);
					$("#receiver").val(receiver);
					$("#code_pod").val(code);
				
					
			  },
			 async:   true,
			  dataType: 'json'
			});
		}
		
		
    } else {
        alert("Please select items.");
    }
});



$(document).on('change', '#select_all', function() {

    $(".fht-tbody tbody .checkbox_satuan").prop('checked', $(this).prop("checked"));
});


</script>



   <script>
  
  $('.checkbox_pod_time').click(function(){
	  
	    if($(this).is(':checked'))
		{
		var id = $(this).attr('id');
		time = new Date().toString("hh:mm tt");
		date = new Date().toString("dd-MM-yyyy");
		$("#"+id+"_date").val(date);
		$("#"+id+"_time").val(time);
		}
		
		
  });
  </script>