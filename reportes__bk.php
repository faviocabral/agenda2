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
<!-- <script type="text/javascript" src="scripts/jquery-1.11.1.min.js"></script> -->
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
					<h2 style="text-align: center;">REPORTE CALL CENTER</h2>
					<!--FILA 2-->
					<div class="row clearfix" style="display: flex;  align-items: center;  justify-content: center;">
						<div class="col-md-3 column">                
								<div class="form-group" style="margin: 0px;">
										 <div class='input-group date' id='datepicker1'>
											<span class="input-group-addon">DESDE:  </span>
											<input type='text' class="form-control" name="fecha1" id="fecha1" />
											<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
											</span>
										</div>
								 </div>
						</div>
						<div class="col-md-3 column">                
								<div class="form-group"  style="margin: 0px;">
									  <div class='input-group date' id='datepicker2'>
										<span class="input-group-addon">HASTA:  </span>
										<input type='text' class="form-control" name="fecha2" id="fecha2" />
										<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
										</span>
									</div>
								</div>
						</div>
					</div>
					<br>
					<div class="row" style="display: flex;  align-items: center;  justify-content: center;">
						<div class="col-md-2 ">
							<button type="submit" class="btn btn-primary btn-block"><span class="glyphicon glyphicon-search"></span>Buscar</button>
							
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
	

				<?php 
				if ( !isset($_POST['fecha1']) ||  !isset($_POST['fecha2']) )
				{ 
				}else{
					$fecha1 = $_POST['fecha1'];
					$fecha2 = $_POST['fecha2'];
					//$query = " select * from fichas where fecha >= '".$fecha1."' and fecha <= '".$fecha2."' 
					//		order by fecha desc , id_funcionario_atencion desc, columna, cupo asc
					//		";
					$query = "
								SELECT 
									(SELECT nombre FROM public.sucursales WHERE id_sucursal = t1.id_sucursal ) SUCURSALES , 
									t1.fecha FECHA, 
									t1.hora_solicitud FECHA_REGISTRO,
									to_char( t1.hora, 'hh24:mm') HORA, 
									to_char( t1.fecha , 'TMDay') DIASEMANA,
									t1.documento DOCUMENTO,
									t1.nombre CLIENTE, 
									t1.celular CELULAR, 
									t1.servicio SERVICIO, 
									to_char( t1.fecha , 'TMMonth') MES, 
									to_char( t1.fecha , 'DD') DIA, 
									replace( replace( T1.comentario , chr(13) , '' ), chr(10), '')  COMENTARIO, 
									CASE T1.estado WHEN '0' THEN 'CANCELADO' WHEN '1' THEN 'NO ATENDIDO' WHEN '2' THEN 'ATENDIDO' END ESTADO, 
									coalesce( (SELECT NOMBRE FROM public.funcionarios WHERE TRIM( CAST( id_funcionario AS CHAR(10) ) )= TRIM( T1.id_funcionario ) LIMIT 1 ) , '') CALLCENTER ,
									coalesce( (SELECT NOMBRE FROM public.funcionarios WHERE TRIM( CAST( id_funcionario AS CHAR(10) ) )= TRIM( T1.id_funcionario_atencion ) LIMIT 1 ), '' ) ASESOR 
									, Vehiculo VEHICULO 
									, km  KILOMETRAJE
									
									, ( 
										SELECT RIGHT( BOX , 5 ) || ' - ' ||LEFT( BOX,  char_length(box) - 5)  
											FROM ( 
												SELECT replace ( replace( nombre , '<br> <span class=badge>', '' ), '<span>', '' ) BOX , row_number() over(ORDER BY orden ) fila , orden , id_sucursal 
												FROM boxes WHERE ESTADO = 1 
											) tabla1 where tabla1.orden = t1.cupo AND tabla1.id_sucursal = t1.id_sucursal
									) boxes 
				,LEFT( CAST( hora AS VARCHAR(100)), 5 )  || 'hs | ' || left(cast(hora + ( coalesce( tiempo , 0 ) / 0.5 )	* INTERVAL '30 minute' as varchar(100)),5) || 'hs' rango_horario 
									, cast ( tiempo as varchar(100) ) || 'hs' as tiempo, vin 
									, marca , modelo 
									, COALESCE(whatsapp, 'NO') whatsapp
								FROM public.fichas t1 
								WHERE fecha BETWEEN '" . $fecha1 . "' AND '" . $fecha2 . "' 
								ORDER BY hora , cupo 
							 ";
				
					$exq	= pg_query($con, $query);
				}	
				?>

				<div class="wrap" style="overflow: auto">
					<div id="output" style="margin: 30px; "></div>
					<div id="imprimir1">
						<center id="imprimir" style="display: none; margin-left: auto; margin-right: auto;"></center>
					</div>

				</div>

</form>
</div>
 
<script type="text/javascript">

	console.log( <?php  echo json_encode( pg_fetch_all($exq) , JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE );  ?> );
	var datos =  <?php  echo json_encode( pg_fetch_all($exq) , JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE );  ?> ;
    // This example loads data from the HTML table below.

	
    $(async function(){
		var renderers = $.extend($.pivotUtilities.renderers, 
            $.pivotUtilities.export_renderers);
		console.log('datos del reporte ', datos )
        $("#output").pivotUI(datos, 
        { 
			renderers: renderers,
            //rows: ["hora", "boxes", "rango_horario", "tiempo" , "cliente", "vehiculo", "servicio", "kilometraje", "comentario"],
            cols: ["mes"], 
            rows: ["boxes"], 
             onRefresh: function(config) {
				
				//esta funcion trae los filtros de la tabla dinamica.. 
				if ( Object.values(config.inclusionsInfo).length > 0 ) { 
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
