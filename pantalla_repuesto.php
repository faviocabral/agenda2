<?php 
include_once ("inc/conexion.php");
session_start();
if (!isset($_SESSION['usuario']))
{
	header("location:index.php");  
}
?>
<!doctype html>
<html><head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<link rel="shortcut icon" href="clip.ico">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="Reservas para services de mantenimientos">
<meta name="author" content="Software">
<meta name="keywords" content="Reservas, Mantenimiento, Vehiculo, Reparacion, Agenda, Ticket, Turno" /> 
<meta http-equiv=”Expires” content=”0″>
  
<!-- JAVASCRIPT Y CSS PARA EL BOOTSTRAP -->
<script src="js/jquery.js"></script> <!--jQuery JavaScript Library v1.11.0-->
<script src="js/jquery.mask.min.js"></script> 

<script src="js/bootstrap.js"></script>
<!--<script src="js/bootstrap.min.js"></script> --> <!--COMENTADO POR DUPLICIDAD--> 
 
<script src="js/bootstrap-tooltip.js"></script> 
<script src="js/bootstrap-popover.js"></script> 

<script src="js/node_modules/socket.io/node_modules/socket.io-client/dist/socket.io.js"></script>
<script src="js/nodecliente.js"></script>

<script src="js/jquery.dropdown.js"></script> 
<script src="js/modernizr.custom.63321.js"></script> 
<link href="css/dropdown/style1.css" rel="stylesheet" >

<script src="js/glDatePicker.min.js"></script>
 
<link href="css/glDatePicker.default.css" rel="stylesheet" >

<script type="text/javascript" src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script>

<!--toast -->
<link rel="stylesheet" href="js/toast/toastr.min.css">
<script src="js/toast/toastr.min.js"></script>


<link href="css/datepicker.css" rel="stylesheet"> <!--No necesario-->
<link href="css/bootstrap.css" rel="stylesheet">
<!--<link href="css/bootstrap.css.map" rel="stylesheet">-->
<!--<link href="css/bootstrap.min.css" rel="stylesheet">-->			<!--COMENTADO POR DUPLICIDAD-->
<!--<link href="css/bootstrap-theme.css" rel="stylesheet">-->		<!--COMENTADO POR DUPLICIDAD-->
<!--<link href="css/bootstrap-theme.css.map" rel="stylesheet">-->
<link href="css/bootstrap-theme.min.css" rel="stylesheet">

<link href="css/bootstrap-social.css" rel="stylesheet">
<script>


$(document).ready(function(){
    $('[data-toggle="popover"]').popover(); 

        toastr.options.closeMethod       = 'fadeOut';
        toastr.options.closeDuration     = 500;
        toastr.options.closeEasing       = 'swing';
        toastr.options.closeButton       = true;
        toastr.options.preventDuplicates = true;
        toastr.options.timeOut           = 5000; // How long the toast will display without user interaction
        toastr.options.extendedTimeOut   = 500; // How long the toast will display after a user hovers over it
        toastr.options.positionClass     = 'toast-bottom-right'; // How long the toast will display after a user hovers over it

});

</script>

<script >

function cierraConfirmarIdentidad()
{
	window.location.href = "cupo.php?fecha="+$('#mydate').val();	
}
function cierraSesion()
{
	window.location.href = "cerrar.php?fecha="+$('#mydate').val();	
}
var intentos = 0;
//$('#inputTwitter').mask('9:9:9:9');
   
</script> 
 <style>

 .table{width:100%;margin-bottom:20px}
.table>thead>tr>th,.table>tbody>tr>th,.table>tfoot>tr>th,.table>thead>tr>td,.table>tbody>tr>td,.table>tfoot>tr>td{padding:6px;line-height:2.5 ;vertical-align:top;border-top:1px solid #ddd}
.table>thead>tr>th{vertical-align:bottom;border-bottom:2px solid #ddd}
.table>caption+thead>tr:first-child>th,.table>colgroup+thead>tr:first-child>th,.table>thead:first-child>tr:first-child>th,.table>caption+thead>tr:first-child>td,.table>colgroup+thead>tr:first-child>td,.table>thead:first-child>tr:first-child>td{border-top:0}
.table>tbody+tbody{border-top:2px solid #ddd}
.table .table{background-color:#fff}
.table-condensed>thead>tr>th,.table-condensed>tbody>tr>th,.table-condensed>tfoot>tr>th,.table-condensed>thead>tr>td,.table-condensed>tbody>tr>td,.table-condensed>tfoot>tr>td{padding:5px}
.table-bordered{border:1px solid #ddd}
.table-bordered>thead>tr>th,.table-bordered>tbody>tr>th,.table-bordered>tfoot>tr>th,.table-bordered>thead>tr>td,.table-bordered>tbody>tr>td,.table-bordered>tfoot>tr>td{border:1px solid #ddd}
.table-bordered>thead>tr>th,.table-bordered>thead>tr>td{border-bottom-width:2px}
.table-striped>tbody>tr:nth-child(odd)>td,.table-striped>tbody>tr:nth-child(odd)>th{background-color:#f9f9f9}.table-hover>tbody>tr:hover>td,.table-hover>tbody>tr:hover>th{background-color:#f5f5f5}
table col[class*=col-]{position:static;float:none;display:table-column}
table td[class*=col-],table th[class*=col-]{position:static;float:none;display:table-cell}
.table>thead>tr>td.active,.table>tbody>tr>td.active,.table>tfoot>tr>td.active,.table>thead>tr>th.active,.table>tbody>tr>th.active,.table>tfoot>tr>th.active,.table>thead>tr.active>td,.table>tbody>tr.active>td,.table>tfoot>tr.active>td,.table>thead>tr.active>th,.table>tbody>tr.active>th,.table>tfoot>tr.active>th{background-color:#f5f5f5}
.table-hover>tbody>tr>td.active:hover,.table-hover>tbody>tr>th.active:hover,.table-hover>tbody>tr.active:hover>td,.table-hover>tbody>tr.active:hover>th{background-color:#e8e8e8}
.table>thead>tr>td.success,.table>tbody>tr>td.success,.table>tfoot>tr>td.success,.table>thead>tr>th.success,.table>tbody>tr>th.success,.table>tfoot>tr>th.success,.table>thead>tr.success>td,.table>tbody>tr.success>td,.table>tfoot>tr.success>td,.table>thead>tr.success>th,.table>tbody>tr.success>th,.table>tfoot>tr.success>th{background-color:#dff0d8}
.table-hover>tbody>tr>td.success:hover,.table-hover>tbody>tr>th.success:hover,.table-hover>tbody>tr.success:hover>td,.table-hover>tbody>tr.success:hover>th{background-color:#d0e9c6}
.table>thead>tr>td.info,.table>tbody>tr>td.info,.table>tfoot>tr>td.info,.table>thead>tr>th.info,.table>tbody>tr>th.info,.table>tfoot>tr>th.info,.table>thead>tr.info>td,.table>tbody>tr.info>td,.table>tfoot>tr.info>td,.table>thead>tr.info>th,.table>tbody>tr.info>th,.table>tfoot>tr.info>th{background-color:#d9edf7}
.table-hover>tbody>tr>td.info:hover,.table-hover>tbody>tr>th.info:hover,.table-hover>tbody>tr.info:hover>td,.table-hover>tbody>tr.info:hover>th{background-color:#c4e3f3}
.table>thead>tr>td.warning,.table>tbody>tr>td.warning,.table>tfoot>tr>td.warning,.table>thead>tr>th.warning,.table>tbody>tr>th.warning,.table>tfoot>tr>th.warning,.table>thead>tr.warning>td,.table>tbody>tr.warning>td,.table>tfoot>tr.warning>td,.table>thead>tr.warning>th,.table>tbody>tr.warning>th,.table>tfoot>tr.warning>th{background-color:#fcf8e3}
.table-hover>tbody>tr>td.warning:hover,.table-hover>tbody>tr>th.warning:hover,.table-hover>tbody>tr.warning:hover>td,.table-hover>tbody>tr.warning:hover>th{background-color:#faf2cc}.table>thead>tr>td.danger,.table>tbody>tr>td.danger,.table>tfoot>tr>td.danger,.table>thead>tr>th.danger,.table>tbody>tr>th.danger,.table>tfoot>tr>th.danger,.table>thead>tr.danger>td,.table>tbody>tr.danger>td,.table>tfoot>tr.danger>td,.table>thead>tr.danger>th,.table>tbody>tr.danger>th,.table>tfoot>tr.danger>th{background-color:#f2dede}
.table-hover>tbody>tr>td.danger:hover,.table-hover>tbody>tr>th.danger:hover,.table-hover>tbody>tr.danger:hover>td,.table-hover>tbody>tr.danger:hover>th{background-color:#ebcccc}
@media (max-width:767px){.table-responsive{width:100%;margin-bottom:15px;overflow-y:hidden;overflow-x:scroll;-ms-overflow-style:-ms-autohiding-scrollbar;border:1px solid #ddd;-webkit-overflow-scrolling:touch}.table-responsive>.table{margin-bottom:0}
.table-responsive>.table>thead>tr>th,.table-responsive>.table>tbody>tr>th,.table-responsive>.table>tfoot>tr>th,.table-responsive>.table>thead>tr>td,.table-responsive>.table>tbody>tr>td,.table-responsive>.table>tfoot>tr>td{white-space:nowrap}
.table-responsive>.table-bordered{border:0}
.table-responsive>.table-bordered>thead>tr>th:first-child,.table-responsive>.table-bordered>tbody>tr>th:first-child,.table-responsive>.table-bordered>tfoot>tr>th:first-child,.table-responsive>.table-bordered>thead>tr>td:first-child,.table-responsive>.table-bordered>tbody>tr>td:first-child,.table-responsive>.table-bordered>tfoot>tr>td:first-child{border-left:0}
.table-responsive>.table-bordered>thead>tr>th:last-child,.table-responsive>.table-bordered>tbody>tr>th:last-child,.table-responsive>.table-bordered>tfoot>tr>th:last-child,.table-responsive>.table-bordered>thead>tr>td:last-child,.table-responsive>.table-bordered>tbody>tr>td:last-child,.table-responsive>.table-bordered>tfoot>tr>td:last-child{border-right:0}
.table-responsive>.table-bordered>tbody>tr:last-child>th,.table-responsive>.table-bordered>tfoot>tr:last-child>th,.table-responsive>.table-bordered>tbody>tr:last-child>td,.table-responsive>.table-bordered>tfoot>tr:last-child>td{border-bottom:0}}

.td-nombre{ font-size:16px; 	height:34px;}
.td-servicio{ font-size:11px; 	height:28px;}
.td-situacion{ font-size:10px; 	height:26px; width:50%}
.td-trabajo{ font-size:10px; 	height:26px; width:50%}
.btn-pink{ background:#F39}


.clear{clear:both}
.tit-turno-fix{	float:left; width:25px; margin:1px 1px 1px 1px; padding-top:3px; height:30px; font-size:18px}
.tit-turno{		float:left; width:202px; text-align:center; margin:1px 6px 1px 1px; padding-top:3px; background-color:#337ab7; color:#FFF; height:30px; font-size:18px}
.tit-turno-fin{ float:left; width:202px; text-align:center; margin:1px 1px 1px 1px; padding-top:3px; background-color:#337ab7; color:#FFF; height:30px; font-size:18px}

.tit-hora-fix{	float:left; width:25px; height:20px; margin:1px;}
.tit-hora{		float:left; width:100px; text-align:center; margin:1px; background-color:#FFF; color:#333}
.tit-hora1{		float:left; width:100px; text-align:center; margin:1px 1px 1px 1px; background-color:#FFF; color:#333}
.tit-hora2{		float:left; width:100px; text-align:center; margin:1px 1px 1px 6px; background-color:#FFF; color:#333}
.tit-cupo{		float:left; width:25px; height:53px; margin:1px; padding-top:16px; font-size:22px; text-align:center; color:#999}
.cd-nombre{		position:relative; font-size:17px; margin:0 0 6px 0; padding:0 0 0 3px; line-height:normal; line-height:22px; height:45px; overflow:hidden}
.cd-servicio{	position: relative; font-size:11px; margin:0 0 0 0; padding:0 0 0 3px; line-height:normal; }
 
.btn-danger > .tooltip > .tooltipsubt {
 color: #d34945; 
 font-size:10px;
 }
 
 #mytabla  th , td {
	 border: 2px solid white;
	 border-radius: 8px;
 }
 
 #mytabla  td {
	 text-align:center;
	 height:50px;
	 background-color:#eee;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
  min-width:120px;
  min-height:100px;
	 
 }
 #mytabla td:hover {
	background-color: #337ab7; 
	color:white; 
 }
#mytabla  th {
	 height:40px;
	 text-align:center;
 }
 
</style>
	<title>Reservas</title>
</head>

<body onload=" estadoTaller() ">
 
 <div class="navbar navbar-inverse " role="navigation" style="margin-bottom: 0px;">
      <div class="container-fluid">
        <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span> 
        </button> 
          <a class="navbar-brand" href="#">Reservas Turnos</a>
        </div>
        <div class="collapse navbar-collapse" id"myNavbar<!-- ">
          <ul class="nav navbar-nav">
            <li class="disabled"><a href="index.php">Inicio</a></li>
            <li><a href="cupo.php">		Turnos disponibles</a></li>
            <li class="active"><a href="">	Panel de Taller</a></li>
			<li><a href="reportes.php">		Reportes</a></li>
			<!-- <li><a href="turnos.php">		Pantalla</a></li> -->
            <li class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown">Mi Perfil <b class="caret"></b></a>
                <ul class="dropdown-menu">
					<li><a href="miperfil.php">Cambiar Clave</a></li>
                </ul>
            </li> 
            <li><a href="#" onClick="cierraSesion();">	Cerrar Sesion</a></li>
				<li class="dropdown" >
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" >Configuraciones<b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li><a href="javascript:configBoxes();">Tecnicos</a></li>
							<li><a href="javascript:configTurnos();">Turnos</a></li>
							<li><a href="javascript:configHorarios();">Horarios</a></li>
							<li><a href="javascript:configServicios();">Servicios</a></li>
							<li><a href="javascript:configUsuarios();">Usuarios</a></li>
							<li><a href="javascript:configSucursales();">Sucursales</a></li>
						</ul>
				</li> 
          </ul>
        <div style="float:right; padding-top:15px; text-align:right"> 
			<span style="color:#FFF" id="myUsuario" user="<?php echo $_SESSION['nombre']; ?>"><?php echo $_SESSION['nombre']." <span class='glyphicon glyphicon-user text-danger'></span> ".$_SESSION['tipo']; ?></span>&nbsp;<img src="logo/LogoPequeno.png" style="width:60px;height:40px; position:relative; top:-5px;"></img>
		</div>
  
        </div><!--/.nav-collapse -->
      </div>
</div>

<div class="container-fluid theme-showcase" role="main" style="padding-left: 0px; padding-right: 0px;">
    <!--<div class="well"> -->

    <h2 class="bg-primary" style="margin-top:0px; margin-bottom: 0px; text-align: center; font-size: 40px;">
    	TABLERO DE TALLER <span class="pull-right" style="margin-right: 5px;"><span class="glyphicon glyphicon-calendar"></span> <span id="fechaTablero"></span></span>
    	<div class="btn-group pull-left">
			<!-- <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" style=" font-size: 18px;"> 
				<span class="glyphicon glyphicon-time" style="padding-top: 5px;"></span>
				<span id="listado">HOY</span> 
			</button>   
			<ul class="dropdown-menu" role="menu" style="font-size: 20px;">
				<li><a href="#" onclick="verListado(this)">HOY</a></li>
				<li><a href="#" onclick="verListado(this)">MAÑANA</a></li>
			</ul>			 -->
			<input type="date" class="form-control" id="fechaIns" value="<?php echo date('Y-m-d'); ?>" style="height:43px;" onchange="estadoTaller()"></a>
    	</div>

    	<div class="btn-group pull-left">
			<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" style=" font-size: 18px;"> 
				<span class="glyphicon glyphicon-time" style="padding-top: 5px;"></span>
				<span id="_sucursal">CHANGAN</span> 
			</button>   
			<ul class="dropdown-menu" role="menu" style="font-size: 20px;">
				<li><a href="#" onclick="verSucursal(this)">CHANGAN</a></li>
			</ul>			
    	</div>
    	<div class="btn-group pull-left ml-2">
			<button type="button" class="btn btn-success dropdown-toggle" style=" font-size: 18px;" onclick="ExportToExcel('xlsx')"> 
				<span class="glyphicon glyphicon-download" style="padding-top: 5px;"></span>
				<span id="_sucursal">EXCEL</span> 
			</button>   
    	</div>

    </h2>

<div class="container-fluid" style="font-size: 35px; font-weight: bold;">
  <div class="row">
	<!--
    <div class="col-sm-4" style="background-color:#337ab7; color:white;" >
    	<span class="glyphicon glyphicon-calendar"></span> AGENDADO
    	<span class= "pull-right" id="Tagendados" ></span>
    </div>
    <div class="col-sm-3" style="background-color:#fcf8e3; color:#8a6d3b;" >
    	<span class="glyphicon glyphicon-user"></span> ATENDIDO
    	<span class= "pull-right" id="Tatendidos" ></span>
    </div>
-->
    <div class="col-sm-12" style="background-color:#D4EEF6; color:#5BC0DE; ">
    	<span class="glyphicon glyphicon-cog"></span> CONFIRMADO
    	<span class= "pull-right" id="Tconfirmados" ></span>
    </div>
  </div>
</div> 
  
<div class="table-responsive">
	<table class="table" style="font-size:13px" id="tbl_exporttable_to_xls">
		<thead>
			<tr>
				<th>#</th>
				<th>HORARIO</th>
				<th>BOXES</th>
				<th>CLIENTE</th>
				<th>VEHICULO</th>
				<th>CHASSIS</th>
				<th>CALLCENTER</th>
				<th>SERVICIO</th>
				<th>ESTADO</th>
				<th>OT</th>
			</tr>
		</thead>
		<tbody id="resultado">
		</tbody>
	</table>
</div>  	
    <!-- </div>-->
</div>
 
<script>

$(document).ready(function() {
	
	$("#sucursal").on("change", function (){
		//fco cookie para guardar en la sucursal que esta trabajando 
		var sucu = $("#sucursal option:selected").val();
		var sucuCookie = getCookie("sucursal");

		if (sucuCookie !== "" || sucuCookie !== null) {
			if (sucu == "" || sucu == null) {sucu = 1 } 
			setCookie("sucursal", sucu, 30);
		}
		consultar();
	});

	jQuery.expr[':'].contains = function(a, i, m) {
	  return jQuery(a).text().toUpperCase()
		  .indexOf(m[3].toUpperCase()) >= 0;
	};
	
});

//para refrescar la session y no registrar 
window.setInterval(function(){ $.post('refresh_session.php'); },300000); 

function verListado(ele){
		$("#listado").html(  $(ele).text() )
		localStorage.setItem('listado-taller-dia', $(ele).text() )
		estadoTaller()
	}

function verSucursal(ele){
	$("#_sucursal").html(  $(ele).text())
	localStorage.setItem('listado-taller-sucursal', $(ele).text() )
	estadoTaller()
}
	

	function estadoTaller(){
		let fecha = $("#fechaIns").val()
		let valorDia = localStorage.getItem('listado-taller-dia') || 'HOY' 	
		let valorSucursal = localStorage.getItem('listado-taller-sucursal') || 'CHANGAN' 
		$("#listado").text( valorDia)
		$("#_sucursal").text( valorSucursal)

		let dia = (valorDia === 'HOY'? 0 : 1 ) // solo hoy(0) y mañana(1) 
		let sucursal = valorSucursal 

		console.log('datos de dia ', dia )
		console.log('datos de sucursal ', dia )
		if ( dia == 0 ) { $("#listado").html(  'HOY' ); }

		var jqxhr1 = $.ajax( { method: "POST" , url: 'inc/procesos.php', data: { accion: "estadoTaller" , dia : dia, sucursal: sucursal, fecha: fecha  }, dataType: 'json', encoding:"ISO-8859-1"});
		jqxhr1.done(function(rs) { //recuperar datos de turnos 
			
			console.log('datos de la agenda ', rs)
			//total agendados
			$("#Tagendados").html(rs.length);

			var html = ""; item = 0 ; color = ""; estado = ""; atendidos= 0, confirmados = 0 ;
			rs.forEach( function ( rs2 ){
				$("#fechaTablero").html(rs2["fecha"]);

				item++;
				if ( item % 2 == 0 ){ color = "white" }else{ color = "#D3D3D3" }
				if ( rs2["estado"] == 'ATENDIDO'){
					atendidos++;
					estado = 'style="background-color:#5cb85c; color:white;"' ;
				}else if( rs2["estado"] == 'CONFIRMADO'){
					confirmados++;
					estado = 'style="background-color:#F0AC4C; color:white;"' ;

				}else{

					estado = 'style="background-color:#f0ad4e; color:white;"' ;
				}
				html = html + '<tr style="background-color:'+ color +'; line-height:1.2;"><td><center>' 
							+ item            + '</center></td><td style="line-height:1.2;">'  
							+ rs2["horarios"] + '</td><td  style="line-height:1.2;">'  
							+ rs2["boxes"]    + '</td><td style="line-height:1.2;">'  
							+ rs2["cliente"]  + '</td><td style="line-height:1.2;">'  
							+ rs2["vehiculo"] + '</td><td style="line-height:1.2;">'
							+ rs2["chassis"]  + '</td><td style="line-height:1.2;">'
							+ rs2["callcenter"]  + '</td><td style="line-height:1.2;">'
							+ rs2["servicio"] + '</td><td '+ estado +' ><center><b>'  
							+ rs2["estado"]   + '</b></center></td><td style="padding:1px;"><center><b><span class="badge" style="font-size:30px;" id="'+ rs2['ficha'] +'">'  
							+ rs2["nro_ot"]   + '</span></b></center></td></tr>';
			});
			$("#Tatendidos").html( atendidos + '/' + rs.length);
			$("#Tconfirmados").html( confirmados + '/' + rs.length);
			$("#resultado").html( html );
			otTurno();
		});
	}
	function otTurno(){
		var cantidad= 0;
		var jqxhr1 = $.ajax( { method: "POST" , url: 'inc/procesos.php', data: { accion: "otTurno"  }, dataType: 'json', encoding:"ISO-8859-1"});
		jqxhr1.done(function(rs) { //recuperar datos de turnos 
			console.log(rs);
			rs.forEach( function ( rs2 ){
				if (rs2['ot'] > 0 ){ cantidad++; }
				$("#" + rs2["ficha"]).html(rs2["ot"]);
				$("#" + rs2["ficha"]).css("background-color", "#17202A");
			});	
			$("#Tprocesos").html(cantidad);
		});
	}

	function ExportToExcel(type, fn, dl) {
            var elt = document.getElementById('tbl_exporttable_to_xls');
            var wb = XLSX.utils.table_to_book(elt, { sheet: "sheet1" });
            return dl ?
                XLSX.write(wb, { bookType: type, bookSST: true, type: 'base64' }) :
                XLSX.writeFile(wb, fn || ('tableroTaller.' + (type || 'xlsx')));
    }

</script>
</body>
</html>
