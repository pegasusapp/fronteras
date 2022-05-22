/*=============================================
SideBar Menu
=============================================*/

//$('.sidebar-menu').tree()

/*=============================================
Data Table
=============================================*/
var table =

$(".tablas").DataTable({

	"language": {

		"sProcessing":     "Procesando...",
		"sLengthMenu":     "Mostrar _MENU_ registros",
		"sZeroRecords":    "No se encontraron resultados",
		"sEmptyTable":     "Ningún dato disponible en esta tabla",
		"sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_",
		"sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0",
		"sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
		"sInfoPostFix":    "",
		"sSearch":         "Buscar:",
		"sUrl":            "",
		"sInfoThousands":  ",",
		"sLoadingRecords": "Cargando...",
		"oPaginate": {
		"sFirst":    "Primero",
		"sLast":     "Último",
		"sNext":     "Siguiente",
		"sPrevious": "Anterior"
		},
		"oAria": {
			"sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
			"sSortDescending": ": Activar para ordenar la columna de manera descendente"
		}

	},

        scrollY:        true,
        scrollX:        true,
        scrollCollapse: true,
		paging:         true,
	    lengthChange: true,
		searching: true,
		ordering: true,
		info: true,
		autoWidth: false,
		responsive: false,
        fixedColumns:   {
            leftColumns: 2
            
		},
		dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
		]
   

});


$('#tabla_total_ids').DataTable( {

	"language": {

		"sProcessing":     "Procesando...",
		"sLengthMenu":     "Mostrar _MENU_ registros",
		"sZeroRecords":    "No se encontraron resultados",
		"sEmptyTable":     "Ningún dato disponible en esta tabla",
		"sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_",
		"sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0",
		"sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
		"sInfoPostFix":    "",
		"sSearch":         "Buscar:",
		"sUrl":            "",
		"sInfoThousands":  ",",
		"sLoadingRecords": "Cargando...",
		"oPaginate": {
		"sFirst":    "Primero",
		"sLast":     "Último",
		"sNext":     "Siguiente",
		"sPrevious": "Anterior"
		},
		"oAria": {
			"sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
			"sSortDescending": ": Activar para ordenar la columna de manera descendente"
		}

	},
	scrollY:        true,
	scrollX:        true,
	scrollCollapse: true,
	paging:         true,
	lengthChange: true,
	searching: true,
	ordering: true,
	info: true,
	autoWidth: true,
	responsive: false,
	 fixedColumns:   {
            leftColumns: 2
            
		},

	dom: 'Bfrtip',
	buttons: [
		'copy', 'csv', 'excel', 'pdf', 'print'
	],
	orderCellsTop: true,
	fixedHeader: true,
	"footerCallback": function ( row, data, start, end, display ) {
	  var api = this.api(), data;

	  // Remove the formatting to get integer data for summation
	  var intVal = function ( i ) {
		return typeof i === 'string' ?
		  i.replace(/[\$,]/g, '')*1 :
		  typeof i === 'number' ?
			i : 0;
	  };

	  // Total over all pages
	  total = api
		.column( 2 )
		.data()
		.reduce( function (a, b) {
		  return intVal(a) + intVal(b);
		}, 0 );

	  // Total over this page
	  pageTotal = api
		.column( 2, { page: 'current'} )
		.data()
		.reduce( function (a, b) {
		  return intVal(a) + intVal(b);
		}, 0 );

	  // Total over all pages
	  total_a = api
		.column( 5 )
		.data()
		.reduce( function (a, b) {
		  return intVal(a) + intVal(b);
		}, 0 );

	  // Total over this page
	  pageTotal_b = api
		.column( 5, { page: 'current'} )
		.data()
		.reduce( function (a, b) {
		  return intVal(a) + intVal(b);
		}, 0 );


	  // Update footer
	  $( api.column( 2 ).footer() ).html(
		pageTotal.toFixed(2) +' ('+ total.toFixed(2) +' total)'
	  );

		 // Update footer
		 $( api.column(5 ).footer() ).html(
		pageTotal_b.toFixed(2) +' ('+ total_a.toFixed(2) +' total)'
	  );
	},
	destroy: true
  } );

