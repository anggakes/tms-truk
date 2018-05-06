 <!-- HEADER -->
 <section class="content-header">
          <h1>
            Good Receive
            <small>List Of New GR</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="<?php echo BASE_URL(); ?>"><i class="fa fa-dashboard"></i>Home</a></li>
            <li><a href="<?php echo BASE_URL()."po"; ?>"><i class="fa fa-dashboard"></i>Good Receive</a></li>
          </ol>
        </section>
  
  
   <!-- Content -->
   <section class="content">
		
		
  
  
          <div class="box sms box-default color-palette-box">
            <div class="box-header with-border">
              <h3 class="box-title"><i class="fa fa-table"></i> Table Good Receive</h3>
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
                             <form action="<?php echo base_url()."index.php/gr" ?>" method="get">
                             <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                                <input type="text" id="search" name="search" placeholder="Search..."  value="<?php echo $search; ?>" />
                                <input type="submit" id="submit"  value="Search"/>
                                <?php if($search!="")
								{?>
                                <a href="<?php echo base_url()."index.php/gr" ?>" id="clear-search">Clear Search</a>
                                <?php } ?>
                             </form>
                </div>
                <div id="wrapper-button" class="clearfix">
					<?php if($data_role[0]['export_gr']=='yes'){ ?>
                	<a href="<?php echo base_url()."index.php/po/exportPo?search=".$search; ?>" class="button orange-button">
                    	Export GR
                    </a>
					
					<?php } ?>
                    <?php if($data_role[0]['add_gr']=='yes'){ ?>
                    <a id="add-data" class="button green-button">
                    	Create GR
                    </a>
					<?php } ?>
					
					
                </div>
                </div>
            <div id="wrapper-console" class="clearfix"> 
            <div class="grid_4 height400">                  
           	<table id="myTable03" class="fancyTable table table-bordered table-hover">
                    <thead>
                      <tr>
					  
                        <th>GR ID</th>
                        <th>Reference (PO ID)</th>
                        <th>GR Date</th>
						<th>Remark</th>
						<th>Created By</th>
						<th>Created Date</th>
						<th>Updated By</th>
						<th>Updated Date</th>
						
						<?php if($data_role[0]['delete_gr']=='yes' || $data_role[0]['edit_gr']=='yes'){ ?>
						<th>Action</th>
						<?php } ?>
                      </tr>
                    </thead>
             		<tbody>
					
                    <?php foreach($data_gr as $data_gr) {?>
                    <tr id="data_<?php echo $data_gr->id_gr; ?>">
					
                    	<td class="id_gr">
						<div class="check-box-div">
						
						</div><span><?php echo $data_gr->id_gr; ?></span></td>
						
                        <td class="id_po"><?php echo $data_gr->id_po; ?></td>
                        <td class="gr_date"><?php convert_date($data_gr->gr_date); ?></td>
						<td class="remark"><?php echo $data_gr->remark; ?></td>
						
					
						<td class="created_by"><?php echo $data_gr->created_by; ?></td>
						<td class="created_time"><?php echo $data_gr->created_date; ?></td>
						<td class="updated_by"><?php echo $data_gr->updated_by; ?></td>
						<td class="updated_time"><?php echo $data_gr->updated_date; ?></td>
						
						
						<?php if($data_role[0]['delete_gr']=='yes' || $data_role[0]['edit_gr']=='yes'){ ?>
						<td><?php if($data_role[0]['delete_gr']=='yes'){ ?><a  class="delete_data link_action" id="<?php echo $data_gr->id_gr; ?>" >Delete</a><?php } ?> | <?php if($data_role[0]['edit_supplier']=='yes'){ ?><a  id="<?php echo $data_gr->id_gr; ?>" class="edit_data link_action">Edit</a><?php } ?></td>
						
						<?php } ?>
					</tr>
                    <?php }?>
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

	
	
	 <div class="remodal" data-remodal-id="modal_add" role="dialog" aria-labelledby="modal1Titl aria-describedby="modal1Desc">
	  <button data-remodal-action="close" class="remodal-close" aria-label="Close"></button>
	  <div>
		<h2 id="modal1Title">Create GR</h2>
				<form role="form" id="form_add_data" method="POST" action="<?php echo base_url()."index.php/gr/addGr" ?>" enctype="multipart/form-data">
				 <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
				 
              <div class="box-body form">
		  
		  
					<div class="form-group">
					 <label>PO Reference</label>
						<div class="input-group">
						  <div class="input-group-addon">
							<i class="fa fa-search"></i>
						  </div>
						  <input type="text" class="form-control pull-right" name="search_po_reference" id="search_po_reference" value=''n placeholder='Search PO Reference'>
						  <input type="text" readonly class="form-control" name="id_po" id="id_po" placeholder='ID PO' required>
						</div>
						<!-- /.input group -->
					</div>
					
					<div class="form-group">
					  <label for="drivercode2">GR Date</label>
						  <div class="input-group date">
						  <div class="input-group-addon">
							<i class="fa fa-calendar"></i>
						  </div>
						  <input type="text" name="gr_date" class="form-control pull-right datepicker" id="gr_date" required>
						</div>
					</div>
					
					
					<div class="form-group">
					  <label for="drivercode2">Remark</label>
					 <input type="text" class="form-control" name="remark" id="remark" required>
					</div>
				
					
					
				
				
              <!-- /.box-body -->
				<div class="clearfix"></div>

					 <h2 class="table-title">List Of Item</h2>
					 <div class="box-body table clearfix">
						
						<table id='add_gr' class="po">
						<thead>
							<tr>
							<th><input class='check_all' type='checkbox' onclick="select_all()"/></th>
							<th>Line</th>
							<th>Product ID</th>
							<th>Description</th>
							<th>Qty Order</th>
							<th>Qty Received</th>
							<th>Price</th>
							<th>Location</th>
							</tr>
						</thead>
						<tbody>
							</tbody>
						
							
						</table>
						
						
					</div>
              <div class="box-footer">
                <button data-remodal-action="cancel" class="remodal-cancel">Cancel</button>
				<input type="submit" name="submit_add" class="remodal-confirm" value="Submit" id="submit_add">
              </div>
            </form>
	  </div>
	  <br>
	  
	</div>
	</div>
	
	
	
	<div class="remodal" data-remodal-id="modal_edit" role="dialog" aria-labelledby="modal1Titl aria-describedby="modal1Desc">
	  <button data-remodal-action="close" class="remodal-close" aria-label="Close"></button>
	  <div>
		<h2 id="modal1Title">Edit GR</h2>
				<form role="form" id="form_edit_data" method="POST" action="<?php echo base_url()."index.php/gr/editGr" ?>" enctype="multipart/form-data">
				 <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
					
					 <div class="box-body form">
					
					<input type='hidden' name='id_gr_update' id='id_gr_update' value=''>
		  
					<div class="form-group">
					 <label>PO Reference</label>
						<div class="input-group">
						  <div class="input-group-addon">
							<i class="fa fa-search"></i>
						  </div>
						  <input type="text" readonly class="form-control" name="edit_id_po" id="edit_id_po" placeholder='ID PO' required>
						</div>
						<!-- /.input group -->
					</div>
					
					<div class="form-group">
					  <label for="drivercode2">GR Date</label>
						  <div class="input-group date">
						  <div class="input-group-addon">
							<i class="fa fa-calendar"></i>
						  </div>
						  <input type="text" name="edit_gr_date" class="form-control pull-right datepicker" id="edit_gr_date" required>
						</div>
					</div>
					
					
					<div class="form-group">
					  <label for="drivercode2">Remark</label>
					 <input type="text" class="form-control" name="edit_remark" id="edit_remark" required>
					</div>
				
					
					
				
				
              <!-- /.box-body -->
				<div class="clearfix"></div>

					 <h2 class="table-title">List Of Item</h2>
					 <div class="box-body table clearfix">
						
						<table id='edit_gr' class="po">
						<thead>
							<tr>
							<th><input class='check_all' type='checkbox' onclick="select_all()"/></th>
							<th>Line</th>
							<th>Product ID</th>
							<th>Description</th>
							<th>Qty Order</th>
							<th>Qty Received</th>
							<th>Price</th>
							<th>Location</th>
							</tr>
						</thead>
						<tbody>
							</tbody>
						
							
						</table>
					</div>
             
              <div class="box-footer">
                <button data-remodal-action="cancel" class="remodal-cancel">Cancel</button>
				<input type="submit" name="submit_edit" class="remodal-confirm" value="Submit" id="submit_edit">
              </div>
            </form>
	  </div>
	  <br>
	</div>
	</div>
	
	
	
	
	
	
	
	
	
	<div class="remodal" data-remodal-id="modal_delete" role="dialog" aria-labelledby="modal1Titl aria-describedby="modal1Desc">
	  <button data-remodal-action="close" class="remodal-close" aria-label="Close"></button>
	  <div>
		<h2 id="modal1Title">Delete GR</h2>
				<form role="form" id="form_delete_data" method="POST" action="<?php echo base_url()."index.php/gr/deleteGr" ?>" enctype="multipart/form-data">
				 <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
				 
              <div class="box-body">

				 <div class="form-group">
                     <p>Are you sure want to delete this data? (<span id="reference_delete"></span>)</p>
				</div>
				
				 <div class="form-group">
                      <input type="hidden" name="id_gr_delete" id="id_gr_delete" class="form-control" value="" />
					  <input type="hidden" name="id_po_delete" id="id_po_delete" class="form-control" value="" />
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
	
	
	
	
	<div class="remodal" data-remodal-id="modal_delete_all" role="dialog" aria-labelledby="modal1Titl aria-describedby="modal1Desc">
	  <button data-remodal-action="close" class="remodal-close" aria-label="Close"></button>
	  <div>
		<h2 id="modal1Title">Delete GR</h2>
				<form role="form" id="form_selected_delete_data" method="POST" action="<?php echo base_url()."index.php/supplier/deleteSupplierAll" ?>" enctype="multipart/form-data">
				 <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
				 
              <div class="box-body">
				 <div class="form-group">
                     <p>Are you sure want to delete selected data? </p>
				</div>
				 <div class="form-group">
                      <input type="hidden" name="id_supplier_delete_all" id="id_supplier_delete_all" class="form-control" value="" />
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
			//Date picker
			$('.datepicker').datepicker({
			  autoclose: true,
			  Format: 'dd-mm-yyyy'
			});
			
			
  
			$(".delete_data").click(function(){
				var id = $(this).attr('id');
				var id_gr =  $('#data_'+id+' .id_gr span').text();
				var id_po =  $('#data_'+id+' .id_po').text();
				$("#reference_delete").text("ID GR:"+id_gr)
				$("#id_gr_delete").val(id_gr);
				$("#id_po_delete").val(id_po);
			});
			
			
			
			$(".edit_data").click(function(){
				var id = $(this).attr('id');
				
				var id_gr =  $('#data_'+id+' .id_gr span').text();
				var id_po =  $('#data_'+id+' .id_po').text();
				var gr_date =  $('#data_'+id+' .gr_date').text();
				var remark =  $('#data_'+id+' .remark').text();
				
				$("#id_gr_update").val(id_gr);
				$("#edit_id_po").val(id_po);
				$("#edit_gr_date").val(gr_date);
				$("#edit_remark").val(remark);
				
				$.ajax({
				  url: '<?php echo BASE_URL(); ?>/index.php/json/jsonProductGr?id_gr='+id_gr,
				  success: function(data,status)
				  {
					$("#edit_gr tbody tr").remove();  
					
					createTableEdit(data,id_po,id_gr);
				  },
				  async:   true,
				  dataType: 'json'
				}); 
				
			});
			
			
			function createTableEdit(data,id_po,id_gr)
			{
			  for(var i=0; i<data.length;i++)
			  {
				  
				
						
					var no = i + 1;
					var j = i + 2;
					$("#edit_gr tbody").append("<tr id='product_"+data[i]['id_product']+"'>"+
												    "<td><input type='checkbox' class='case'/></td>"+
													"<td><span id='snum"+j+"'>"+no+".</span></td>"+
													"<td><input type='hidden' name='id_product[]' id='id_product_"+j+"' class='id_product' id_row='"+j+"' value='"+data[i]['id_product']+"' ><input type='hidden' name='product_code[]' id='product_code_"+j+"' class='product_code_' id_row='"+j+"' value='"+data[i]['product_code']+"' ><span id='product_code_span_"+j+"'>"+data[i]['product_code']+"<span></td>"+
													"<td><span id='description_"+j+"'>"+data[i]['product_name']+"<span><input type='hidden' name='description[]' class='description' id='description"+j+"' value='"+data[i]['product_name']+"'></td>"+
													"<td><span>"+data[i]['qty']+"</span><input type='hidden' name='qty[]' class='qty' id='qty"+j+"' value='"+data[i]['qty']+"'></td>"+
													"<td><input type='text' name='qty_received[]' class='qty_received' id='qty_received_"+j+"' value='"+data[i]['qty_received']+"'></td>"+
													"<td><span>"+data[i]['price']+"</span><input type='hidden' name='price[]' class='price' id='price"+j+"' value='"+data[i]['price']+"'></td>"+
													"<td><select name='location[]' class='location_select' id='location_"+j+"'>"+
													"</select></td>"+
													"</tr>");
					callEditLocation(id_po,id_gr,j,data[i]['id_location']);
			  }
			 
			}
			
			
			function callEditLocation(id_po,id_gr,j,id_location)
			{
					$.ajax({
					  url: '<?php echo BASE_URL(); ?>/index.php/json/jsonLocationGr?id_po='+id_po,
					  success: function(data,status)
					  {
						  
							createEditSelect(data,id_po,j,id_location)
					  },
					  async:   true,
					  dataType: 'json'
					}); 
			}
			
			
			
			
			function createEditSelect(data,id_po,x,id_location)
			{
			  for(var i=0; i<data.length;i++)
			  {
					
					var no = i + 1;
					var j = i + 2;
					
					$("#form_edit_data #location_"+x).append("<option value='"+data[i]['id_location']+"' >"+data[i]['value']+"</option>");
					$('#location_'+x+' option[value="'+id_location+'"]').prop('selected',true);
			  }
			  
			 
			}
			
			

			$("#form_add_data").validate({
				rules: {
				email: {
				  email: true
				}
				},
				messages: {
				supplier_code: {
				required: 'Supplier Code must be filled!'
				},
				supplier_name: {
				required: 'Driver Name must be filled!'
				},
				address_1: {
				required: 'Address 1 must be filled!'
				},
				supplier_type: {
				required: 'Supplier type must be filled!'
				},
				city: {
				required: 'City must be filled!'
				},
				postal_code: {
				required: 'Postal code must be filled!'
				},
				phone: {
				required: 'Phone must be filled!'
				},
				fax: {
				required: 'Fax must be filled!'
				},
				pic: {
				required: 'PIC must be filled!'
				},
				email: {
				required: 'Email must be filled!'
				}
				
			}
			});
			
			$( "#form_create_gr" ).submit(function( event ) {
			$('[data-remodal-id = modal_add]').remodal().close();
			$('[data-remodal-id = modal_create_gr]').remodal().open();
			  event.preventDefault();
			});
			
			$("#form_edit_data").validate({
				rules: {
				edit_email: {
				  email: true
				}
				},
				messages: {
				edit_supplier_code: {
				required: 'Supplier Code must be filled!'
				},
				edit_supplier_name: {
				required: 'Driver Name must be filled!'
				},
				edit_address_1: {
				required: 'Address 1 must be filled!'
				},
				edit_supplier_type: {
				required: 'Supplier type must be filled!'
				},
				edit_city: {
				required: 'City must be filled!'
				},
				edit_postal_code: {
				required: 'Postal code must be filled!'
				},
				edit_phone: {
				required: 'Phone must be filled!'
				},
				edit_fax: {
				required: 'Fax must be filled!'
				},
				edit_pic: {
				required: 'PIC must be filled!'
				},
				edit_email: {
				required: 'Email must be filled!'
				}
				
			}
			});
			
			
			
			$("#form_import_data").validate({
				rules: {
				import_file: {
				  required: true,
					extension: "xls|xlsx|csv"
				}
				},
				messages: {
				import_file: {
				required: 'Choose file must be filled!'
				}
			}
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
		$("#id_supplier_delete_all").val(ids);
		
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

$(".putaway").click(function(){
	$('[data-remodal-id = modal_putaway]').remodal().open();
	var validator = $( "#form_edit_data" ).validate();
	validator.resetForm();
});

</script>


							
  <script>
$(".delete").on('click', function() {
	$('.case:checkbox:checked').parents("tr").remove();
    $('.check_all').prop("checked", false); 
	check();

});
var i=2;

function addrow(product_code,id_product,product_description,base_uom,price){
	count=$('table.po tr').length;
    var data="<tr><td><input type='checkbox' class='case'/></td><td><span id='snum"+i+"'>"+count+".</span></td>";
    data +="<td><input type='hidden' name='product_code[]' id='product_code_"+i+"' class='product_id' id_row='"+i+"' value='"+id_product+"' ><span id='product_code_span_"+i+"'>"+product_code+"<span></td><td><span id='description_"+i+"'>"+product_description+"<span></td><td><input type='text' name='qty_[]' id='qty_"+i+"' class='qty' id_row='"+i+"' ></td><td><span id='price_"+i+"'>"+price+"<span></td><td><span id='uom_"+i+"'>"+base_uom+"<span></td></tr>";
	$('table.po').append(data);
	i++;
}



function select_all() {
	$('input[class=case]:checkbox').each(function(){ 
		if($('input[class=check_all]:checkbox:checked').length == 0){ 
			$(this).prop("checked", false); 
		} else {
			$(this).prop("checked", true); 
		} 
	});
}

function check(){
	obj=$('table.po tr').find('span');
	$.each( obj, function( key, value ) {
	id=value.id;
	$('#'+id).html(key+1);
	});
	}

</script>




<script>
$(".edit_delete").on('click', function() {
	$('.edit_case:checkbox:checked').parents("tr").remove();
    $('.edit_check_all').prop("checked", false); 
	check();

});
var i=2;

function select_all() {
	$('input[class=edit_case]:checkbox').each(function(){ 
		if($('input[class=edit_check_all]:checkbox:checked').length == 0){ 
			$(this).prop("checked", false); 
		} else {
			$(this).prop("checked", true); 
		} 
	});
}

function check(){
	obj=$('table.edit_po tr').find('span');
	$.each( obj, function( key, value ) {
	id=value.id;
	$('#'+id).html(key+1);
	});
	}

</script>

<script>
 
		//auto complete PR
        $( "#search_po_reference" ).autocomplete({
         source: "<?php echo BASE_URL(); ?>/index.php/json/jsonPoGr",  
         minLength:0,
		 select: function( event , ui ) {
			  $("#id_po").val(ui.item.id_po);
			  var id_po = ui.item.id_po;
			  $.ajax({
				  url: '<?php echo BASE_URL(); ?>/index.php/json/jsonProductPoGr?id_po='+id_po,
				  success: function(data,status)
				  {
					$("#add_gr tbody tr").remove();  
					createTableProductPO(data,id_po);
				  },
				  async:   true,
				  dataType: 'json'
			}); 
				
			  $(this).val('');
			  return false;
			  
        }    
        })
		.autocomplete( "instance" )._renderItem = function( ul, item ) {
		  return $( "<li style='position:relative; z-index:9999;'>" )
			.append( "<div style='font-size:10px;'>" + item.label +"</div>" )
			.appendTo( ul );
		};
		
		
							
		
		function createTableProductPO(data,id_po)
			{
			  for(var i=0; i<data.length;i++)
			  {
					
					var no = i + 1;
					var j = i + 2;
					$("#add_gr tbody").append("<tr id='product_"+data[i]['id_product']+"'>"+
												    "<td><input type='checkbox' class='case'/></td>"+
													"<td><span id='snum"+j+"'>"+no+".</span></td>"+
													"<td><input type='hidden' name='id_product[]' id='id_product_"+j+"' class='id_product' id_row='"+j+"' value='"+data[i]['id_product']+"' ><input type='hidden' name='product_code[]' id='product_code_"+j+"' class='product_code_' id_row='"+j+"' value='"+data[i]['product_code']+"' ><span id='product_code_span_"+j+"'>"+data[i]['product_code']+"<span></td>"+
													"<td><span id='description_"+j+"'>"+data[i]['product_name']+"<span><input type='hidden' name='description[]' class='description' id='description"+j+"' value='"+data[i]['product_name']+"'></td>"+
													"<td><span>"+data[i]['qty']+"</span><input type='hidden' name='qty[]' class='qty' id='qty"+j+"' value='"+data[i]['qty']+"'></td>"+
													"<td><input type='text' name='qty_received[]' class='qty_received' id='qty_received_"+j+"' value='0'></td>"+
													"<td><span>"+data[i]['price']+"</span><input type='hidden' name='price[]' class='price' id='price"+j+"' value='"+data[i]['price']+"'></td>"+
													"<td><select name='location[]' class='location_select' id='location_"+j+"'>"+
													"</select></td>"+
													"</tr>");
			  }
			  
			  callLocation(id_po);
			 
			}
			
			function callLocation(id_po)
			{
					$.ajax({
					  url: '<?php echo BASE_URL(); ?>/index.php/json/jsonLocationGr?id_po='+id_po,
					  success: function(data,status)
					  {
						  
							createSelect(data,id_po)
					  },
					  async:   true,
					  dataType: 'json'
					}); 
			}
			
			
			
			
			function createSelect(data,id_po)
			{
			  for(var i=0; i<data.length;i++)
			  {
					
					var no = i + 1;
					var j = i + 2;
					
					$(".location_select").append("<option value='"+data[i]['id_location']+"' >"+data[i]['value']+"</option>");
			  }
			  
			 
			}
			
			
		
	
  </script>


