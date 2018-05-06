// JavaScript Document

$(document).ready(function(){

	$( ".form" ).on( "keydown", "input.only-number", function(event) {
            if (event.shiftKey == true) {
                event.preventDefault();
            }

            if ((event.keyCode >= 48 && event.keyCode <= 57) || (event.keyCode >= 96 && event.keyCode <= 105) || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 37 || event.keyCode == 39 || event.keyCode == 46 || event.keyCode == 190) {

            } else {
                event.preventDefault();
            }
            
            if($(this).val().indexOf('.') !== -1 && event.keyCode == 190)
                event.preventDefault();

        });
	
	
		
	$("#table-wrapper").on( "click", "tr", function() {
	var id_value = $(this).attr('id_value');
	var id_value_input = $("#id_value").val();
	if(id_value == id_value_input)
	{
		$("#id_value").val(0);
		}
	else
	{
		$("#id_value").val(id_value);
		}
	$(this).closest("tr").siblings().removeClass("highlighted");
    $(this).toggleClass("highlighted");
  })
  
  
  
  
  
  
 $('#table-wrapper').scroll( function(){
	height = $(this).scrollTop();
	left = $(this).scrollLeft();
	$('#main-table thead').css('top',height);
});


  
});