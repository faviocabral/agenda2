	<?php 				

session_start();
include ("inc/conexion.php");
if (!isset($_SESSION['usuario']))
{
	header("location:index.php");
}
?>
<!doctype html>
<html><head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<link rel="shortcut icon" 	href="clip.ico">
<meta name="viewport" 		content="width=device-width, initial-scale=1">
<meta name="description" 	content="Reservas Reportes">
<meta name="author" 		content="System">
<meta name="keywords" 		content="Reservas, Mantenimiento, Vehiculo, Reparacion, Agenda, Ticket, Turno" /> 
<!-- JAVASCRIPT Y CSS PARA EL BOOTSTRAP -->
<link href="css/bootstrap.css" 			rel="stylesheet">
<link href="css/bootstrap-theme.css" 	rel="stylesheet">
<link href="css/bootstrap-datetimepicker.css" rel="stylesheet">
<link href="css/jquery.printarea.css" 			rel="stylesheet">


<link rel="stylesheet" href="http://localhost/font-awesome.min.css">
<link href="https://unpkg.com/jquery-resizable-columns@0.2.3/dist/jquery.resizableColumns.css" rel="stylesheet">
<link rel="stylesheet" href="http://localhost/bootstrap-table.min.css">
<!-- Bootstrap core JavaScript
================================================== -->
<script src="js/jquery.js">				</script> <!--jQuery JavaScript Library v1.11.0-->
<script src="js/jquery.mask.min.js">	</script> 
<script src="js/bootstrap.min.js">		</script>
<script src="js/bootstrap-datepicker.min.js"></script>
<script src="js/bootstrap-tooltip.js"></script>
<script src="js/jquery.printarea.js"></script>

<!-- PivotTable.js libs from ../dist -->
<!-- <script type="text/javascript" src="jquery/jquery-1.12.0.min.js"></script> -->
<script type="text/javascript" src="jquery/jquery-ui.min.js"></script> 
<link rel="stylesheet" type="text/css" href="dist/pivot.css">
<script type="text/javascript" src="dist/pivot.js"></script>

<!--  table grouping  -->
<link rel="stylesheet" href="jqwidgets/styles/jqx.base.css" type="text/css" />
<script type="text/javascript" src="scripts/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="jqwidgets/jqxcore.js"></script>
<script type="text/javascript" src="jqwidgets/jqxdata.js"></script>
<script type="text/javascript" src="jqwidgets/jqxbuttons.js"></script>
<script type="text/javascript" src="jqwidgets/jqxcheckbox.js"></script>
<script type="text/javascript" src="jqwidgets/jqxscrollbar.js"></script>
<script type="text/javascript" src="jqwidgets/jqxmenu.js"></script>
<script type="text/javascript" src="jqwidgets/jqxgrid.js"></script>
<script type="text/javascript" src="jqwidgets/jqxgrid.selection.js"></script>
<script type="text/javascript" src="jqwidgets/jqxgrid.sort.js"></script>
<script type="text/javascript" src="jqwidgets/jqxgrid.grouping.js"></script>
<script type="text/javascript" src="jqwidgets/jqxgrid.filter.js"></script>
<script type="text/javascript" src="jqwidgets/jqxgrid.columnsresize.js"></script>
<script type="text/javascript" src="jqwidgets/jqxgrid.edit.js"></script>
<script type="text/javascript" src="jqwidgets/jqxlistbox.js"></script>
<script type="text/javascript" src="jqwidgets/jqxdropdownlist.js"></script>
<script type="text/javascript" src="jqwidgets/jqxdata.js"></script> 
<script type="text/javascript" src="jqwidgets/jqxdata.export.js"></script> 
<script type="text/javascript" src="jqwidgets/jqxgrid.export.js"></script> 

<script>

$( document ).ready(function() {

	var d = new Date();
	var currMonth = d.getMonth();
	var currYear = d.getFullYear();
	var startDate = new Date(currYear, currMonth, 1);

	$('#datepicker1').datetimepicker({
		format: 'DD-MM-YYYY',
		setDate: startDate
	 });
	$('#datepicker2').datetimepicker({
		format: 'DD-MM-YYYY',
		setDate: startDate

	});

	$('#sortable').change(function () {
      $('#table').bootstrapTable('refreshOptions', {
        sortable: $('#sortable').prop('checked')
      })
    })



});


</script>
 
 <style>
</style>

<title>Reservas</title>
</head>

<body style="padding-top: 40px" onload="SetDate()">
<div class="container-fuild">
<form role="form" action="reportes.php" method="post">
 <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="container-fuild">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">Reservas Turnos</a>
        </div>
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li class="active"><a href="cupo.php">		Turnos disponibles</a></li>
            <li><a href="pantalla_repuesto.php">	Panel de Taller</a></li>
			<li><a href="reportes.php">		Reportes</a></li>
			
           <!-- <li class="active"><a>		Mi Perfil</a></li>-->
                 <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown">Mi Perfil <b class="caret"></b></a>
                  <ul class="dropdown-menu">
                    <!--<li><a href="datosfuncionario.php">Datos de Funcionario</a></li>-->
                    <li><a href="miperfil.php">Cambiar Clave</a></li>
                  </ul>
            </li> 
            <li><a href="#" onClick="cierraSesion();">	Cerrar Sesion</a></li>
          </ul>
        <div style="float:right; padding-top:15px; text-align:right"> 
			<p style="color:#FFF"> 
				<?php echo $_SESSION['nombre']." <span class='glyphicon glyphicon-user text-danger'></span> ";  ?>
			</p>
				
			<!-- <img src="logo/LogoPequeno.gif" style="width:60px;height:40px; position:relative; top:-5px;"></img><br> -->
			<!--  <span class="text-danger" style="font-size:11px">Empresa</span>   </a> -->
		</div>
 </div> 
        </div><!--/.nav-collapse -->
      </div>
      		<center>
			<div class="row clearfix" style="margin: 0 auto;">
				<div class="col-md-12 column" style="background-color: aliceblue";
>
					<h2 style="text-align: center;">REPORTE ENCUESTA CLIENTE TALLER</h2>
					<!--FILA 2-->
					<div class="row clearfix" style="display: flex;  align-items: center;  justify-content: center;">
					</div>
					<div class="row" style="display: flex;  align-items: center;  justify-content: center;">
						<div class="col-md-2 ">
							<button type="button" onclick="listar()" class="btn btn-primary btn-block"><span class="glyphicon glyphicon-search"></span>Listar</button>
							
						</div>
						<div class="col-md-2">
							<button type="button" class="btn btn-success btn-block" id="myButtonControlID3"><span class="glyphicon glyphicon-print" ></span>Print</button>
						</div>
							
					</div>
					<!--FILA 3-->
				</div>
			</div>  <!-- fin row clearfix-->
			</center>		
		</div>
	
		<style>
			.nav-tabs > li.active > a,
			.nav-tabs > li.active > a:hover,
			.nav-tabs > li.active > a:focus {
				background-color: aliceblue
			}
			.tab-content{
				background: aliceblue; 
				position: relative; 
				padding:10px; 
				border-left:1px solid #ddd; 
				border-right:1px solid #ddd; 
				border-bottom:1px solid #ddd;
				min-height: 350px;
			}
		</style>
		<div class="wrap" style="overflow: auto">
			<div class="container" style="margin-top:10px;">
				<ul class="nav nav-tabs">
					<li class="active"><a data-toggle="tab" href="#listado"> <strong>LISTADO</strong></a></li>
					<li><a data-toggle="tab" href="#dinamico"> <strong>DINAMICO</strong> </a></li>
				</ul>
				<div class="tab-content" >

					<div id="listado" class="tab-pane in active">
						<div class="container" style="padding-left:0; padding-right:0; max-width:100%;">
							<table class="table table-hover"  
								data-height="400" 
								data-sortable="true" 
								data-toolbar="#toolbar" 
								data-show-export="true" 
								data-show-columns="true"
								data-show-columns-toggle-all="true"
								data-show-fullscreen="true"	
								data-search-highlight="true"
								data-resizable="true"
								id="table">
								<thead id="cabecera" class="elevation-2" style="background-color:#eceff1;" ></thead>
								<tbody style="line-height: 18px; vertical-align:baseline;" id="resultados"></tbody>
							</table>
						</div>
					</div>
					<div id="dinamico" class="tab-pane">
						<div id="output" style="margin: 30px; "></div>
					</div>
				</div>

			</div>



			<div id="imprimir1">
				<center id="imprimir" style="display: none; margin-left: auto; margin-right: auto;"></center>
			</div>

		</div>

</form>
</div>

<script src="http://localhost/jspdf.umd.js"></script>
<script>if (!window.jsPDF) window.jsPDF = window.jspdf.jsPDF </script>
<script src="http://localhost/jspdf.plugin.autotable.js"></script>
<script src="http://localhost/bootstrap-table.min.js"></script>
<script src="http://localhost/bootstrap-table-export.min.js"></script>
<script src="http://localhost/tableExport.min.js"></script>


<script src="https://cdn.jsdelivr.net/npm/tableexport.jquery.plugin@1.10.21/tableExport.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/tableexport.jquery.plugin@1.10.21/libs/jsPDF/jspdf.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/tableexport.jquery.plugin@1.10.21/libs/jsPDF-AutoTable/jspdf.plugin.autotable.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/store.js/2.0.1/store.modern.js" integrity="sha512-P4A4HNIIW5cs59d9Wl0f7HWhToxMcmTKa/2/fvUsFTuhn/N18rm9HduCfsob2tF/7P3132fLGU7c63btpRRjRg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://unpkg.com/jquery-resizable-columns@0.2.3/dist/jquery.resizableColumns.min.js"></script>
<script src="https://unpkg.com/bootstrap-table@1.21.4/dist/extensions/resizable/bootstrap-table-resizable.min.js"></script>
<script src="https://unpkg.com/bootstrap-table@1.22.1/dist/extensions/filter-control/bootstrap-table-filter-control.min.js"></script>


<script type="text/javascript">

	console.log( <?php  echo json_encode( pg_fetch_all($exq) , JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE );  ?> );
	var datos =  <?php  echo json_encode( pg_fetch_all($exq) , JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE );  ?> ;
    // This example loads data from the HTML table below.
    $(function(){
		var renderers = $.extend($.pivotUtilities.renderers,
        $.pivotUtilities.export_renderers);
        $("#output").pivotUI(datos, 
        { 
			renderers: renderers,
            //rows: ["hora", "boxes", "rango_horario", "tiempo" , "cliente", "vehiculo", "servicio", "kilometraje", "comentario"],
            cols: ["mes"], 
            rows: ["boxes"], 
             onRefresh: function(config) {
				
				//esta funcion trae los filtros de la tabla dinamica.. 
				if(Object.values(config.inclusionsInfo).length > 0){ 
		        	console.log(config.inclusionsInfo);
				}
             }, 
			sorters: {
				mes: $.pivotUtilities.sortAs(["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"])
			}
        });

     });


	$("#myButtonControlID1").click(function(e) {
		window.open('data:application/vnd.ms-excel,' + encodeURIComponent( $('#divTableDataHolder').html()));
		e.preventDefault();
	});

	$("#myButtonControlID3").click(function(e) {
		$("#imprimir").append('<h3>Reporte de Call Center </h3>');
		$("#imprimir").append($(".pvtRendererArea").html());
		$("#imprimir").css('display', 'block');

		$("#imprimir1").printArea();
		e.preventDefault();
		$("#imprimir").empty();
		/*$(".pvtRendererArea").printArea();
		e.preventDefault();*/
	});

async function listar(){
	
	await fetch('http://192.168.10.54:3010/encuestaTaller')
		.then(res=> res.json())
		.then(rows=>{
			console.log(rows)

			var renderers = $.extend($.pivotUtilities.renderers,
			$.pivotUtilities.export_renderers);
			$("#output").pivotUI(rows, 
			{ 
				renderers: renderers,
				//rows: ["hora", "boxes", "rango_horario", "tiempo" , "cliente", "vehiculo", "servicio", "kilometraje", "comentario"],
				cols: ["satisfacionCliente"], 
				rows: ["asesor"], 
				onRefresh: function(config) {
					
					//esta funcion trae los filtros de la tabla dinamica.. 
					if(Object.values(config.inclusionsInfo).length > 0){ 
						console.log(config.inclusionsInfo);
					}
				}, 
			});

			$('#table').bootstrapTable({
			//url: data.data,
			pagination: false,
			search: true,
			exportTypes: [ 'csv', 'txt', 'excel', 'pdf'],
			columns: [
				{ field: "id", title: "ID", sortable: true, datafiltercontrol:'input' },
			{ field: "codigoEncuesta", title: "CODIGO ENCUESTA", sortable: true },
			{ field: "fecha", title: "FECHA", sortable: true },
			{ field: "vin", title: "VIN", sortable: true },
			{ field: "modelo", title: "MODELO", sortable: true },
			{ field: "asesor", title: "ASESOR", sortable: true },
			{ field: "nroOrden", title: "NRO ORDEN", sortable: true },
			{ field: "taller", title: "TALLER", sortable: true },
			{ field: "cliente", title: "CLIENTE", sortable: true },
			{ field: "correo", title: "CORREO", sortable: true },
			{ field: "satisfacionCliente", title: "SATISFACION CLIENTE", sortable: true },
			{ field: "recomiendaTaller", title: "RECOMIENDA TALLER", sortable: true },
			{ field: "comentarioEstadiaTaller", title: "COMENTARIOS POSITIVOS", sortable: true },
			{ field: "satisfacionEtiqueta", title: "CLASIFICACION", sortable: true },
			{ field: "comentarioNegativo", title: "COMENTARIOS NEGATIVOS", sortable: true },
			{ field: "comentarioNegativoEtiqueta", title: "CLASIFICACION", sortable: true },
			//{ field: "comentarioPositivo", title: "COMENTARIO POSITIVO", sortable: true },
			// { field: "sucursal", title: "SUCURSAL", sortable: true },
			//{ field: "fecha_ins", title: "FECHA INGRESO", sortable: true },
			//{ field: "user_ins", title: "USUARIO INS", sortable: true },
			], 
			data: rows
			})

		})
		.finally(()=> console.log('listo'))
}



function SetDate(){
	$('#datepicker1').trigger("click");	
	$('#datepicker2').trigger("click");	

	var date = new Date();
	var primerDia = new Date(date.getFullYear(), date.getMonth() , 1);
	var ultimoDia = new Date(date.getFullYear(), date.getMonth() + 1, 0);
	var dia  = primerDia.getDate();
	var mes  = primerDia.getMonth() +1;
	var year = primerDia.getFullYear();
	var fecha1 = ('0' + String(dia)).slice(-2) + '-' + ( '0' + String(mes)).slice(-2) + '-' + String(year);
	var dia  = date.getDate();			// ultimoDia.getDate(); // esto devuelve el ultimo dia del mes.. 
	var mes  = ultimoDia.getMonth() +1;
	var year = ultimoDia.getFullYear();
	var fecha2 = ('0' + String(dia)).slice(-2) + '-' + ( '0' + String(mes)).slice(-2) + '-' + String(year);

	console.log(fecha1 , fecha2 );
	$("#fecha1").val(fecha1);
	$("#fecha2").val(fecha2);
}


</script>
<br />

</body>
</html>
