$(document).ready(function() {
    $('#myTable01').fixedHeaderTable({ footer: false, cloneHeadToFoot: false, altClass: 'odd'});
	
	$('#myTable011').fixedHeaderTable({ footer: false, cloneHeadToFoot: false, altClass: 'odd'});
    
	
	
	
	
    $('#myTable02').fixedHeaderTable({ footer: true, altClass: 'odd' });
    
    $('#myTable05').fixedHeaderTable({ altClass: 'odd', footer: true, fixedColumns: 1 });
    
    $('#myTable032').fixedHeaderTable({ altClass: 'odd', footer: true, fixedColumns: 1 });
    
     $('#myTable04').fixedHeaderTable({ altClass: 'odd', footer: true, fixedColumns: 1 });
	
	$('#myTable06').fixedHeaderTable({ altClass: 'odd', fixedColumns: 1 });
});
