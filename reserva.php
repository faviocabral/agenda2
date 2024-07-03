<?php 				

session_start();

?>
<!doctype html>
<html>
<head>
<meta charset="iso-8859-1">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- JAVASCRIPT Y CSS PARA EL BOOTSTRAP -->
<script src="js/jquery.js"></script> <!--jQuery JavaScript Library v1.11.0-->

<script src="js/bootstrap.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/bootstrap-datepicker.js"></script>

<link href="css/datepicker.css" rel="stylesheet">
<link href="css/bootstrap.css" rel="stylesheet">
<!--<link href="css/bootstrap.css.map" rel="stylesheet">-->
<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="css/bootstrap-theme.css" rel="stylesheet">
<!--<link href="css/bootstrap-theme.css.map" rel="stylesheet">-->
<link href="css/bootstrap-theme.min.css" rel="stylesheet">

<link href="css/bootstrap-social.css" rel="stylesheet">


<script >
    var nowTemp = new Date();
    var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);
     
    var checkin = $('#dpd1').datepicker({
    onRender: function(date) {
    return date.valueOf() < now.valueOf() ? 'disabled' : '';
    }
    }).on('changeDate', function(ev) {
    if (ev.date.valueOf() > checkout.date.valueOf()) {
    var newDate = new Date(ev.date)
    newDate.setDate(newDate.getDate() + 1);
    checkout.setValue(newDate);
    }
    checkin.hide();
    $('#dpd2')[0].focus();
    }).data('datepicker');
    var checkout = $('#dpd2').datepicker({
    onRender: function(date) {
    return date.valueOf() <= checkin.date.valueOf() ? 'disabled' : '';
    }
    }).on('changeDate', function(ev) {
    checkout.hide();
    }).data('datepicker');
	
	function procesarDatos()
	{
		error=0;
		var nombre 		= $("#nombre").val();
		var ci 			= $("#ci").val();	
		var celular 	= $("#celular").val();	
		var km 			= $("#km").val();	
		var gservicio	= $('input[name = "gservicio"]:checked').val();		
		var gvehiculo 	= $('input[name = "gvehiculo"]:checked').val();	
		var opcional	= $("#opcional").val();	
		var fechaelegida= $("#fechaelegida").val();	
		var horaelegida	= $("#horaelegida").val();	

		if (!nombre || !ci || !celular || !gservicio || !gvehiculo || !fechaelegida || !horaelegida ) error++;

		alert(error);
	}
function guardarFicha()
{
	var error=0;
	var nombre 		= $("#nombre").val();
	var ci 			= $("#ci").val();	
	var celular 	= $("#celular").val();	
	var km 			= $("#km").val();	
	var gservicio	= $('input[name = "gservicio"]:checked').val();		
	var gvehiculo 	= $('input[name = "gvehiculo"]:checked').val();	
	var opcional	= $("#opcional").val();	
	var fechaelegida= $("#fechaelegida").val();	
	var horaelegida	= $("#horaelegida").val();	
	
	var conca = nombre+ci+celular+km+gservicio+gvehiculo+opcional+fechaelegida+horaelegida;
	
	
	if (!nombre || !ci || !celular || !gservicio || !gvehiculo || !fechaelegida || !horaelegida ) error++;
		
	alert(conca);
	
 	accion ="agendar";
	var respuesta = $.ajax({
				url: "inc/procesos.php",
				global:true,
				type: "POST",
				data: "accion="			+accion+
					  "&nombre="		+nombre+
					  "&ci="			+ci+
					  "&celular="		+celular+
					  "&km="			+km+
					  "&gservicio="		+gservicio+
					  "&gvehiculo="		+gvehiculo+
					  "&opcional="		+opcional+
					  "&fechaelegida="	+fechaelegida+
					  "&horaelegida="	+horaelegida,
				contentType: "application/x-www-form-urlencoded",
				dataType: "html",
				async: true,					
				ifModified: false,
				processData:true,
				beforeSend: function(objeto){ },
				complete: function(objeto, exito){  
					if(exito=="success"){ }},
					error: function(objeto, quepaso, otroobj){ },
					success: function(datos){
					///////////////////// --- Acciones con los datos obtenidos --- /////////////////////
						 var resdatos;
 						 resdatos = datos.split("*tab*");
 				 		alert(resdatos[0]);
					/*	if (datos == 'exito')
						{
							$('#cell_estado_conexion').html('<img src="img/estado_conectado.png" width="16" height="16" align="top" />'+
															'<span style="color:#006600";>&nbsp;Conectado</span>');
 							$('#cell_internet_alerta').html('Conexion establecida');
							$('#b_conectar_internet').attr('disabled', true);
							$('#b_conectar_internet').css('display', 'none');
							bandera_conexion = 1;
							monitorear_conexion();
						}
						if (datos == 'error')
						{
						$('#cell_estado_conexion').fadeIn(500).html('<img src="img/estado_desconectado.png" width="16" height="16" align="top" />'+
														 '<span style="color:#400000";>&nbsp;Desconectado</span>');
								$('#b_conectar_internet').attr('disabled', false);
								$('#b_conectar_internet').css('display', '');
							bandera_conexion = 0;
 						}
 						 */
					},							
				}
			).responseText;		
}
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
.btn-pink{
	
	background:#F39}
</style>
<title>Reservas Garden</title>
</head>

<body>
 
<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">Reservas Garden</a>
        </div>
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li><a href="index.php">Inicio</a></li>
            <li class="active"><a href="agenda.php">Agendar servicio</a></li>
            <li><a href="panel.php">Panel Administrativo</a></li>
             <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">Opciones <b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li><a href="#">Action</a></li>
                <li><a href="#">Another action</a></li>
                <li><a href="#">Something else here</a></li>
                <li class="divider"></li>
                <li class="dropdown-header">Nav header</li>
                <li><a href="#">Separated link</a></li>
                <li><a href="#">One more separated link</a></li>
              </ul>
            </li>
          </ul>
         <!-- agregado-->
<!--          <form class="navbar-form navbar-right" role="form">
            <div class="form-group">
              <input type="text" placeholder="Email" class="form-control">
            </div>
            <div class="form-group">
              <input type="password" placeholder="Password" class="form-control">
            </div>
            <button type="submit" class="btn btn-success">Loguearse</button>
          </form>  -->     
          
        </div><!--/.nav-collapse -->
      </div>
    </div>

<div class="container theme-showcase" role="main">
<a href="panel.php">Admin</a>
<h2>Reservas Garden</h2>
 <div class="tabbable">
     <ul role="menu" class="nav nav-tabs">
         <li role="menuitem" class="active"><a href="#tab_1" tabindex="-1" data-toggle="tab">Paso 1</a></li>
         <li role="menuitem" class=""><a href="#tab_2" tabindex="-1" data-toggle="tab">Paso 2</a></li>
         <li role="menuitem" class=""><a href="#tab_3" tabindex="-1" data-toggle="tab">Paso 3</a></li>
    </ul>
     <div class="tab-content">
      	 <!--Seccion 1-->
       <div class="tab-pane fade" id="tab_1"><p>
			<fieldset>
              <legend>Ingresa tu solicitud</legend>
              <div style="float:left; margin-right:20px ">
                <label for="text">Nombre</label>
                    <br>
    				
                    <input type="text" id="nombre" name="nombre" value="" placeholder="Nombre"><br>
                  <label for="text">Documento</label>
                  <br>
                  <input type="text" id="ci" name="ci" value="" placeholder="Documento de Identidad">
                  <br>
                  <label for="text">Celular</label>
                  <br>
                  <input type="text" id="celular" name="celular" value="" placeholder="Celular"> 
                  <br>
                  <label for="text">Kilometros</label>
                  <br>
                  <input type="text" id="km" name="km" value="" placeholder="Kilometros">        
                  <br> 
               </div>
              <div style="float:left; margin-right:20px  ">
              
                <label for="text">Vehiculo</label>
                  <br>
                       <label>
                        <input type="radio" name="gvehiculo" value="riohatch" id="grupovehiculo_0">
                        Rio Hatchback</label>
                      <br>
                      <label>
                        <input type="radio" name="gvehiculo" value="riosedan" id="grupovehiculo_1">
                        Rio Sedan</label>
                      <br>
                      <label>
                        <input type="radio" name="gvehiculo" value="picanto" id="grupovehiculo_2">
                        Picanto</label>
                      <br>
                      <label>
                        <input type="radio" name="gvehiculo" value="sportage" id="grupovehiculo_3">
                        Sportage</label>
                      <br>
                      <label>
                        <input type="radio" name="gvehiculo" value="sorento" id="grupovehiculo_4">
                        Sorento</label>
                   
                  <br>
                  <label for="text"> </label> 
                              
 			  </div>
<div style="float:left; margin-right:20px  ">
               
                 <label for="text">Tipo de Servicio</label>
                  <br>
                       <label>
                        <input type="radio" name="gservicio" value="mantenimiento" id="gruposervicio_0">
                        Mantenimiento</label>
                      <br>
                      <label>
                        <input type="radio" name="gservicio" value="motor" id="gruposervicio_1">
                        Motor</label>
                      <br>
                      <label>
                        <input type="radio" name="gservicio" value="chaperiaypintura" id="gruposervicio_2">
                        Chaperia y Pintura</label>
                      <br>
                      <label>
                        <input type="radio" name="gservicio" value="reparacion" id="gruposervicio_3">
                        Reparacion</label>
                      <br> 
  			  </div>
              <div style="float:left;  ">
                  <label for="text">Comentario opcional</label>
                  <br>
                  <textarea name="opcional" id="opcional" placeholder="Comentario" cols="30" rows="6"></textarea>
                  <br>  <br>  
                   <a href="#tab_2" tabindex="-1" data-toggle="tab" class="btn">Siguiente</a>           
 			  </div>
 			</fieldset>
          </p></div>
         <!--Seccion 2-->
       <div class="tab-pane fade active in" id="tab_2"><p>
		  <fieldset>
             
             <legend> Elig&iacute;  una fecha..</legend>
              
<div class="well">

<?php 
// Crear un vector con todos los horarios cada 15 minutos.
$th_cant = 0;
$nuevaHora = "07:00";
for ($i = 0; $i < 44; $i++) 
{
	$th_hora[] = $nuevaHora;
	$horaInicial=$nuevaHora; 
	$minutoAnadir=15; 
	$segundos_horaInicial=strtotime($horaInicial); 
	$segundos_minutoAnadir=$minutoAnadir*60; 
	$nuevaHora=date("H:i",$segundos_horaInicial+$segundos_minutoAnadir); 
}
?>
 <table width="355" class="table1">
   <thead>
     <tr>
       <td width="156">Fecha seleccionada:
          
         <br>
         <input type="text" name="fechaelegida" id="fechaelegida"  value="01/01/2014" class="span2"></td>
       <td width="187">Hora: <br>
         <span style="float:left;   ">
         <select name="horaelegida" id="horaelegida">
           <option value="07:00">07:00 hs</option>
           <option value="07:30">07:30 hs</option>
           <option value="08:00">08:00 hs</option>
           <option value="08:30">08:30 hs</option>
           <option value="09:00">09:00 hs</option>
           <option value="09:30">09:30 hs</option>
           <option value="10:00">10:00 hs</option>
           <option value="10:30">10:30 hs</option>
           <option value="11:00">11:00 hs</option>
           <option value="11:30">11:30 hs</option>
           <option value="12:00">12:00 hs</option>
           <option value="12:30">12:30 hs</option>
           <option value="13:00">13:00 hs</option>
           <option value="13:30">13:30 hs</option>
           <option value="14:00">14:00 hs</option>
           <option value="14:30">14:30 hs</option>
           <option value="15:00">15:00 hs</option>
           <option value="15:30">15:30 hs</option>
           <option value="16:00">16:00 hs</option>
           <option value="16:30">16:30 hs</option>
           <option value="17:00">17:00 hs</option>
           <option value="17:30">17:30 hs</option>
         </select>
         </span>
         <div style="float:left; margin-right:20px  "></div>
         </td>
     </tr>
     </thead>
 </table>
 <table class="table">
  <thead>
          <tr style="font-size:22px">
            <td align="center">&nbsp;</td>
            <td align="center">&nbsp;</td>
            <td align="center">1</td>
            <td align="center">&nbsp;</td>
            <td align="center">2</td>
            <td align="center">&nbsp;</td>
            <td align="center">3</td>
            <td align="center">&nbsp;</td>
            <td align="center">4</td>
            <td align="center">&nbsp;</td>
            <td align="center">5</td>
            <td align="center">&nbsp;</td>
            <td align="center">6</td>
            </tr>
          <tr style="font-size:18px">
            <td align="center">&nbsp;</td>
            <td align="center">&nbsp;</td>
            <td align="center">07:30 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 08:00</td>
            <td align="center">&nbsp;</td>
            <td align="center">08:00 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 08:30</td>
            <td align="center">&nbsp;</td>
            <td align="center">08:00 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 08:30</td>
            <td align="center">&nbsp;</td>
            <td align="center">08:00 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 08:30</td>
            <td align="center">&nbsp;</td>
            <td align="center">08:00 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 08:30</td>
            <td align="center">&nbsp;</td>
            <td align="center">08:00 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 08:30</td>
            </tr>
          <tr>
            <td align="center">1</td>
            <td>&nbsp;</td>      <td  class="btn-success"
                onMouseOver="this.className='btn-success'" 
               onMouseOut="this.className='btn-success" >
                <div class="cd-nombre" 		style="font-size:22px; height:30px; margin:0 0 0 0; padding:0 0 0 0; line-height:normal">Isaias Silva</div>
              <div class="cd-servicio" 	style="font-size:14px; height:22px; margin:0 0 0 0; padding:0 0 0 0; line-height:normal">Servicio Express</div>
              <div class="cd-situacion" 	style="font-size:10px; height:18px; float:left; width:50%; line-height:normal">Finalizado</div>
              <div class="cd-trabajo" 	style="font-size:10px; height:18px; float:left; width:50%; line-height:normal"> </div></td>
<td>&nbsp;</td>
				<td  class="btn-success"
                onMouseOver="this.className='btn-success'" 
                onMouseOut="this.className='btn-success" ><div class="cd-nombre" 		style="font-size:22px; height:30px; margin:0 0 0 0; padding:0 0 0 0; line-height:normal">Isaias Silva</div>
              <div class="cd-servicio" 	style="font-size:14px; height:22px; margin:0 0 0 0; padding:0 0 0 0; line-height:normal">Servicio Express</div>
              <div class="cd-situacion" 	style="font-size:10px; height:18px; float:left; width:50%; line-height:normal"><span class="cd-situacion" style="font-size:10px; height:18px; float:left; width:50%; line-height:normal">Finalizado</span></div>
              <div class="cd-trabajo" 	style="font-size:10px; height:18px; float:left; width:50%; line-height:normal"> </div></td>

            <td>&nbsp;</td>      <td  class="btn-success"
                onMouseOver="this.className='btn-success'" 
                onMouseOut="this.className='btn-success" ><div class="cd-nombre" 		style="font-size:22px; height:30px; margin:0 0 0 0; padding:0 0 0 0; line-height:normal">Isaias Silva</div>
              <div class="cd-servicio" 	style="font-size:14px; height:22px; margin:0 0 0 0; padding:0 0 0 0; line-height:normal">Servicio Express</div>
              <div class="cd-situacion" 	style="font-size:10px; height:18px; float:left; width:50%; line-height:normal"><span class="cd-situacion" style="font-size:10px; height:18px; float:left; width:50%; line-height:normal">Finalizado</span></div>
              <div class="cd-trabajo" 	style="font-size:10px; height:18px; float:left; width:50%; line-height:normal"> </div></td>

            <td>&nbsp;</td>      <td  class="btn-success"
                onMouseOver="this.className='btn-success'" 
                onMouseOut="this.className='btn-success" ><div class="cd-nombre" 		style="font-size:22px; height:30px; margin:0 0 0 0; padding:0 0 0 0; line-height:normal">Isaias Silva</div>
              <div class="cd-servicio" 	style="font-size:14px; height:22px; margin:0 0 0 0; padding:0 0 0 0; line-height:normal">Servicio Express</div>
              <div class="cd-situacion" 	style="font-size:10px; height:18px; float:left; width:50%; line-height:normal"><span class="cd-situacion" style="font-size:10px; height:18px; float:left; width:50%; line-height:normal">Finalizado</span></div>
              <div class="cd-trabajo" 	style="font-size:10px; height:18px; float:left; width:50%; line-height:normal"> </div></td>

            <td>&nbsp;</td>
                        <td  class="btn-info"
                onMouseOver="this.className='btn-info'" 
                onMouseOut="this.className='btn-info'" ><div class="cd-nombre" 		style="font-size:22px; height:30px; margin:0 0 0 0; padding:0 0 0 0; line-height:normal">Isaias Silva</div>
              <div class="cd-servicio" 	style="font-size:14px; height:22px; margin:0 0 0 0; padding:0 0 0 0; line-height:normal">Servicio Express</div>
              <div class="cd-situacion" 	style="font-size:10px; height:18px; float:left; width:50%; line-height:normal">En espera..</div>
              <div class="cd-trabajo" 	style="font-size:10px; height:18px; float:left; width:50%; line-height:normal">Hora</div></td>

            <td>&nbsp;</td>
                        <td  class="btn-info"
                onMouseOver="this.className='btn-info'" 
                onMouseOut="this.className='btn-info'" ><div class="cd-nombre" 		style="font-size:22px; height:30px; margin:0 0 0 0; padding:0 0 0 0; line-height:normal">Isaias Silva</div>
              <div class="cd-servicio" 	style="font-size:14px; height:22px; margin:0 0 0 0; padding:0 0 0 0; line-height:normal">Servicio Express</div>
              <div class="cd-situacion" 	style="font-size:10px; height:18px; float:left; width:50%; line-height:normal">En espera..</div>
              <div class="cd-trabajo" 	style="font-size:10px; height:18px; float:left; width:50%; line-height:normal">Hora</div></td>

            </tr>
          <tr>
            <td align="center">&nbsp;</td>
            <td align="center">&nbsp;</td>
            <td align="center">&nbsp;</td>
            <td align="center">&nbsp;</td>
            <td align="center">&nbsp;</td>
            <td align="center">&nbsp;</td>
            <td align="center">&nbsp;</td>
            <td align="center">&nbsp;</td>
            <td align="center">&nbsp;</td>
            <td align="center">&nbsp;</td>
            <td align="center">&nbsp;</td>
            <td align="center">&nbsp;</td>
            <td align="center">&nbsp;</td>
          </tr>
          <tr>
            <td align="center">2</td>
            <td>&nbsp;</td>      <td  class="btn-success"
                onMouseOver="this.className='btn-success'" 
                onMouseOut="this.className='btn-success" ><div class="cd-nombre" 		style="font-size:22px; height:30px; margin:0 0 0 0; padding:0 0 0 0; line-height:normal">Isaias Silva</div>
              <div class="cd-servicio" 	style="font-size:14px; height:22px; margin:0 0 0 0; padding:0 0 0 0; line-height:normal">Servicio Express</div>
              <div class="cd-situacion" style="font-size:10px; height:18px; float:left; width:50%; line-height:normal"> Finalizado </div>
              <div class="cd-trabajo" 	style="font-size:10px; height:18px; float:left; width:50%; line-height:normal"> </div></td>
            <td>&nbsp;</td>      <td  class="btn-success"
                onMouseOver="this.className='btn-success'" 
                onMouseOut="this.className='btn-success" >
                <div class="cd-nombre" 		style="font-size:22px; height:30px; margin:0 0 0 0; padding:0 0 0 0; line-height:normal">Isaias Silva</div>
              <div class="cd-servicio" 	style="font-size:14px; height:22px; margin:0 0 0 0; padding:0 0 0 0; line-height:normal">Mantenimiento</div>
              <div class="cd-situacion" 	style="font-size:10px; height:18px; float:left; width:50%; line-height:normal">Finalizado</div>
              <div class="cd-trabajo" 	style="font-size:10px; height:18px; float:left; width:50%; line-height:normal"> </div></td>
            <td>&nbsp;</td>      <td  class="btn-success"
                onMouseOver="this.className='btn-success'" 
                onMouseOut="this.className='btn-success" ><div class="cd-nombre" 		style="font-size:22px; height:30px; margin:0 0 0 0; padding:0 0 0 0; line-height:normal">Isaias Silva</div>
              <div class="cd-servicio" 	style="font-size:14px; height:22px; margin:0 0 0 0; padding:0 0 0 0; line-height:normal">Mantenimiento</div>
              <div class="cd-situacion" 	style="font-size:10px; height:18px; float:left; width:50%; line-height:normal">Finalizado</div>
              <div class="cd-trabajo" 	style="font-size:10px; height:18px; float:left; width:50%; line-height:normal"></div></td>
            <td>&nbsp;</td>
                        <td  class="btn-warning"
                onMouseOver="this.className='btn-warning'" 
                onMouseOut="this.className='btn-warning'" ><div class="cd-nombre" 		style="font-size:22px; height:30px; margin:0 0 0 0; padding:0 0 0 0; line-height:normal">Isaias Silva</div>
              <div class="cd-servicio" 	style="font-size:14px; height:22px; margin:0 0 0 0; padding:0 0 0 0; line-height:normal">Mantenimiento</div>
              <div class="cd-situacion" 	style="font-size:10px; height:18px; float:left; width:50%; line-height:normal">Taller 19</div>
              <div class="cd-trabajo" 	style="font-size:10px; height:18px; float:left; width:50%; line-height:normal">Hora</div></td>

            <td>&nbsp;</td>
                        <td  class="btn-warning"
                onMouseOver="this.className='btn-warning'" 
                onMouseOut="this.className='btn-warning'" ><div class="cd-nombre" 		style="font-size:22px; height:30px; margin:0 0 0 0; padding:0 0 0 0; line-height:normal">Isaias Silva</div>
              <div class="cd-servicio" 	style="font-size:14px; height:22px; margin:0 0 0 0; padding:0 0 0 0; line-height:normal">Servicio Express</div>
              <div class="cd-situacion" 	style="font-size:10px; height:18px; float:left; width:50%; line-height:normal">Taller 19</div>
              <div class="cd-trabajo" 	style="font-size:10px; height:18px; float:left; width:50%; line-height:normal">Hora</div></td>

            <td>&nbsp;</td>
                        <td  class="btn-info"
                onMouseOver="this.className='btn-info'" 
                onMouseOut="this.className='btn-info'" ><div class="cd-nombre" 		style="font-size:22px; height:30px; margin:0 0 0 0; padding:0 0 0 0; line-height:normal">Isaias Silva</div>
              <div class="cd-servicio" 	style="font-size:14px; height:22px; margin:0 0 0 0; padding:0 0 0 0; line-height:normal">Servicio Express</div>
              <div class="cd-situacion" 	style="font-size:10px; height:18px; float:left; width:50%; line-height:normal">En espera..</div>
              <div class="cd-trabajo" 	style="font-size:10px; height:18px; float:left; width:50%; line-height:normal"></div></td>

          </tr>
          <tr>
            <td align="center">&nbsp;</td>
            <td align="center">&nbsp;</td>
            <td align="center">&nbsp;</td>
            <td align="center">&nbsp;</td>
            <td align="center">&nbsp;</td>
            <td align="center">&nbsp;</td>
            <td align="center">&nbsp;</td>
            <td align="center">&nbsp;</td>
            <td align="center">&nbsp;</td>
            <td align="center">&nbsp;</td>
            <td align="center">&nbsp;</td>
            <td align="center">&nbsp;</td>
            <td align="center">&nbsp;</td>
          </tr>
<tr>
            <td align="center">3</td>
            <td>&nbsp;</td>            <td  class="btn-warning"
                onMouseOver="this.className='btn-warning'" 
                onMouseOut="this.className='btn-warning'" ><div class="cd-nombre" 		style="font-size:22px; height:30px; margin:0 0 0 0; padding:0 0 0 0; line-height:normal">Isaias Silva</div>
              <div class="cd-servicio" 	style="font-size:14px; height:22px; margin:0 0 0 0; padding:0 0 0 0; line-height:normal">Servicio Express</div>
              <div class="cd-situacion" style="font-size:10px; height:18px; float:left; width:50%; line-height:normal">Taller 1</div>
              <div class="cd-trabajo" 	style="font-size:10px; height:18px; float:left; width:50%; line-height:normal">Hora</div></td>
<td>&nbsp;</td>
                        <td  class="btn-warning"
                onMouseOver="this.className='btn-warning'" 
                onMouseOut="this.className='btn-warning'" ><div class="cd-nombre" 		style="font-size:22px; height:30px; margin:0 0 0 0; padding:0 0 0 0; line-height:normal">Isaias Silva</div>
              <div class="cd-servicio" 	style="font-size:14px; height:22px; margin:0 0 0 0; padding:0 0 0 0; line-height:normal">Mantenimiento</div>
              <div class="cd-situacion" 	style="font-size:10px; height:18px; float:left; width:50%; line-height:normal">Taller 3</div>
              <div class="cd-trabajo" 	style="font-size:10px; height:18px; float:left; width:50%; line-height:normal">Hora</div></td>

            <td>&nbsp;</td>
                        <td  class="btn-info"
                onMouseOver="this.className='btn-info'" 
                onMouseOut="this.className='btn-info'" ><div class="cd-nombre" 		style="font-size:22px; height:30px; margin:0 0 0 0; padding:0 0 0 0; line-height:normal">Isaias Silva</div>
              <div class="cd-servicio" 	style="font-size:14px; height:22px; margin:0 0 0 0; padding:0 0 0 0; line-height:normal">Servicio Express</div>
              <div class="cd-situacion" 	style="font-size:10px; height:18px; float:left; width:50%; line-height:normal">En espera...</div>
              <div class="cd-trabajo" 	style="font-size:10px; height:18px; float:left; width:50%; line-height:normal"></div></td>

            <td>&nbsp;</td>
                        <td  class="btn-info"
                onMouseOver="this.className='btn-info'" 
                onMouseOut="this.className='btn-info'" ><div class="cd-nombre" 		style="font-size:22px; height:30px; margin:0 0 0 0; padding:0 0 0 0; line-height:normal">Isaias Silva</div>
              <div class="cd-servicio" 	style="font-size:14px; height:22px; margin:0 0 0 0; padding:0 0 0 0; line-height:normal">Mantenimiento</div>
              <div class="cd-situacion" 	style="font-size:10px; height:18px; float:left; width:50%; line-height:normal">Situacion</div>
              <div class="cd-trabajo" 	style="font-size:10px; height:18px; float:left; width:50%; line-height:normal"></div></td>

            <td>&nbsp;</td>
                        <td  class="btn-active"
                onMouseOver="this.className='btn-flickr'" 
                onMouseOut="this.className='btn-active'" ><div class="cd-nombre" 		style="font-size:22px; height:30px; margin:0 0 0 0; padding:0 0 0 0; line-height:normal"><span class="cd-nombre" style="font-size:22px; height:30px; margin:0 0 0 0; padding:0 0 0 0; line-height:normal">Cupo Libre</span></div>
              <div class="cd-servicio" 	style="font-size:14px; height:22px; margin:0 0 0 0; padding:0 0 0 0; line-height:normal"></div>
              <div class="cd-situacion" 	style="font-size:10px; height:18px; float:left; width:50%; line-height:normal">Situacion</div>
              <div class="cd-trabajo" 	style="font-size:10px; height:18px; float:left; width:50%; line-height:normal">Hora</div></td>

            <td>&nbsp;</td>
                        <td  class="btn-active"
                onMouseOver="this.className='btn-flickr'" 
                onMouseOut="this.className='btn-active'" ><div class="cd-nombre" 		style="font-size:22px; height:30px; margin:0 0 0 0; padding:0 0 0 0; line-height:normal"><span class="cd-nombre" style="font-size:22px; height:30px; margin:0 0 0 0; padding:0 0 0 0; line-height:normal">Cupo Libre</span></div>
              <div class="cd-servicio" 	style="font-size:14px; height:22px; margin:0 0 0 0; padding:0 0 0 0; line-height:normal"></div>
              <div class="cd-situacion" 	style="font-size:10px; height:18px; float:left; width:50%; line-height:normal">Situacion</div>
              <div class="cd-trabajo" 	style="font-size:10px; height:18px; float:left; width:50%; line-height:normal">Hora</div></td>

            </tr>
          <tr>
            <td align="center">&nbsp;</td>
            <td align="center">&nbsp;</td>
            <td align="center">&nbsp;</td>
            <td align="center">&nbsp;</td>
            <td align="center">&nbsp;</td>
            <td align="center">&nbsp;</td>
            <td align="center">&nbsp;</td>
            <td align="center">&nbsp;</td>
            <td align="center">&nbsp;</td>
            <td align="center">&nbsp;</td>
            <td align="center">&nbsp;</td>
            <td align="center">&nbsp;</td>
            <td align="center">&nbsp;</td>
          </tr>
<tr>
            <td align="center">4</td>
            <td>&nbsp;</td>            <td  class="btn-active"
                onMouseOver="this.className='btn-flickr'" 
                onMouseOut="this.className='btn-active'" ><div class="cd-nombre" 		style="font-size:22px; height:30px; margin:0 0 0 0; padding:0 0 0 0; line-height:normal">
              <div class="cd-nombre" 		style="font-size:22px; height:30px; margin:0 0 0 0; padding:0 0 0 0; line-height:normal"><span class="cd-nombre" style="font-size:22px; height:30px; margin:0 0 0 0; padding:0 0 0 0; line-height:normal">Cupo Libre</span></div>
              <div class="cd-servicio" 	style="font-size:14px; height:22px; margin:0 0 0 0; padding:0 0 0 0; line-height:normal"></div>
            </div>
              <div class="cd-servicio" 	style="font-size:14px; height:22px; margin:0 0 0 0; padding:0 0 0 0; line-height:normal"></div>
              <div class="cd-situacion" 	style="font-size:10px; height:18px; float:left; width:50%; line-height:normal">Situacion</div>
              <div class="cd-trabajo" 	style="font-size:10px; height:18px; float:left; width:50%; line-height:normal">Hora</div></td>
<td>&nbsp;</td>
                        <td  class="btn-active"
                onMouseOver="this.className='btn-flickr'" 
                onMouseOut="this.className='btn-active'" ><div class="cd-nombre" 		style="font-size:22px; height:30px; margin:0 0 0 0; padding:0 0 0 0; line-height:normal">
                          <div class="cd-nombre" 		style="font-size:22px; height:30px; margin:0 0 0 0; padding:0 0 0 0; line-height:normal"><span class="cd-nombre" style="font-size:22px; height:30px; margin:0 0 0 0; padding:0 0 0 0; line-height:normal">Cupo Libre</span></div>
                          <div class="cd-servicio" 	style="font-size:14px; height:22px; margin:0 0 0 0; padding:0 0 0 0; line-height:normal"></div>
                        </div>
              <div class="cd-servicio" 	style="font-size:14px; height:22px; margin:0 0 0 0; padding:0 0 0 0; line-height:normal"></div>
              <div class="cd-situacion" 	style="font-size:10px; height:18px; float:left; width:50%; line-height:normal">Situacion</div>
              <div class="cd-trabajo" 	style="font-size:10px; height:18px; float:left; width:50%; line-height:normal">Hora</div></td>

            <td>&nbsp;</td>
                        <td  class="btn-active"
                onMouseOver="this.className='btn-flickr'" 
                onMouseOut="this.className='btn-active'" ><div class="cd-nombre" 		style="font-size:22px; height:30px; margin:0 0 0 0; padding:0 0 0 0; line-height:normal">
                          <div class="cd-nombre" 		style="font-size:22px; height:30px; margin:0 0 0 0; padding:0 0 0 0; line-height:normal"><span class="cd-nombre" style="font-size:22px; height:30px; margin:0 0 0 0; padding:0 0 0 0; line-height:normal">Cupo Libre</span></div>
                          <div class="cd-servicio" 	style="font-size:14px; height:22px; margin:0 0 0 0; padding:0 0 0 0; line-height:normal"></div>
                        </div>
              <div class="cd-servicio" 	style="font-size:14px; height:22px; margin:0 0 0 0; padding:0 0 0 0; line-height:normal"></div>
              <div class="cd-situacion" 	style="font-size:10px; height:18px; float:left; width:50%; line-height:normal">Situacion</div>
              <div class="cd-trabajo" 	style="font-size:10px; height:18px; float:left; width:50%; line-height:normal">Hora</div></td>

            <td>&nbsp;</td>
                        <td  class="btn-active"
                onMouseOver="this.className='btn-flickr'" 
                onMouseOut="this.className='btn-active'" ><div class="cd-nombre" 		style="font-size:22px; height:30px; margin:0 0 0 0; padding:0 0 0 0; line-height:normal">
                          <div class="cd-nombre" 		style="font-size:22px; height:30px; margin:0 0 0 0; padding:0 0 0 0; line-height:normal"><span class="cd-nombre" style="font-size:22px; height:30px; margin:0 0 0 0; padding:0 0 0 0; line-height:normal">Cupo Libre</span></div>
                          <div class="cd-servicio" 	style="font-size:14px; height:22px; margin:0 0 0 0; padding:0 0 0 0; line-height:normal"></div>
                        </div>
              <div class="cd-servicio" 	style="font-size:14px; height:22px; margin:0 0 0 0; padding:0 0 0 0; line-height:normal"></div>
              <div class="cd-situacion" 	style="font-size:10px; height:18px; float:left; width:50%; line-height:normal">Situacion</div>
              <div class="cd-trabajo" 	style="font-size:10px; height:18px; float:left; width:50%; line-height:normal">Hora</div></td>

            <td>&nbsp;</td>
                        <td  class="btn-active"
                onMouseOver="this.className='btn-flickr'" 
                onMouseOut="this.className='btn-active'" ><div class="cd-nombre" 		style="font-size:22px; height:30px; margin:0 0 0 0; padding:0 0 0 0; line-height:normal">
                          <div class="cd-nombre" 		style="font-size:22px; height:30px; margin:0 0 0 0; padding:0 0 0 0; line-height:normal"><span class="cd-nombre" style="font-size:22px; height:30px; margin:0 0 0 0; padding:0 0 0 0; line-height:normal">Cupo Libre</span></div>
                          <div class="cd-servicio" 	style="font-size:14px; height:22px; margin:0 0 0 0; padding:0 0 0 0; line-height:normal"></div>
                        </div>
              <div class="cd-servicio" 	style="font-size:14px; height:22px; margin:0 0 0 0; padding:0 0 0 0; line-height:normal"></div>
              <div class="cd-situacion" 	style="font-size:10px; height:18px; float:left; width:50%; line-height:normal">Situacion</div>
              <div class="cd-trabajo" 	style="font-size:10px; height:18px; float:left; width:50%; line-height:normal">Hora</div></td>

            <td>&nbsp;</td>
                        <td  class="btn-active"
                onMouseOver="this.className='btn-flickr'" 
                onMouseOut="this.className='btn-active'" ><div class="cd-nombre" 		style="font-size:22px; height:30px; margin:0 0 0 0; padding:0 0 0 0; line-height:normal">
                          <div class="cd-nombre" 		style="font-size:22px; height:30px; margin:0 0 0 0; padding:0 0 0 0; line-height:normal"><span class="cd-nombre" style="font-size:22px; height:30px; margin:0 0 0 0; padding:0 0 0 0; line-height:normal">Cupo Libre</span></div>
                          <div class="cd-servicio" 	style="font-size:14px; height:22px; margin:0 0 0 0; padding:0 0 0 0; line-height:normal"></div>
                        </div>
              <div class="cd-servicio" 	style="font-size:14px; height:22px; margin:0 0 0 0; padding:0 0 0 0; line-height:normal">
                <p>&nbsp;</p>
              </div>
              <div class="cd-situacion" 	style="font-size:10px; height:18px; float:left; width:50%; line-height:normal">Situacion</div>
              <div class="cd-trabajo" 	style="font-size:10px; height:18px; float:left; width:50%; line-height:normal">Hora</div></td>

            </tr>
          <tr>
            <td align="center">&nbsp;</td>
            <td align="center">&nbsp;</td>
            <td align="center">&nbsp;</td>
            <td align="center">&nbsp;</td>
            <td align="center">&nbsp;</td>
            <td align="center">&nbsp;</td>
            <td align="center">&nbsp;</td>
            <td align="center">&nbsp;</td>
            <td align="center">&nbsp;</td>
            <td align="center">&nbsp;</td>
            <td align="center">&nbsp;</td>
            <td align="center">&nbsp;</td>
            <td align="center">&nbsp;</td>
          </tr>
          <tr>
            <td align="center">5</td>
            <td>&nbsp;</td>
            <td  class="btn-active"
                onMouseOver="this.className='btn-flickr'" 
                onMouseOut="this.className='btn-active'" ><div class="cd-nombre" 		style="font-size:22px; height:30px; margin:0 0 0 0; padding:0 0 0 0; line-height:normal">
              <div class="cd-nombre" 		style="font-size:22px; height:30px; margin:0 0 0 0; padding:0 0 0 0; line-height:normal"><span class="cd-nombre" style="font-size:22px; height:30px; margin:0 0 0 0; padding:0 0 0 0; line-height:normal">Cupo Libre</span></div>
              <div class="cd-servicio" 	style="font-size:14px; height:22px; margin:0 0 0 0; padding:0 0 0 0; line-height:normal"></div>
            </div>
              <div class="cd-servicio" 	style="font-size:14px; height:22px; margin:0 0 0 0; padding:0 0 0 0; line-height:normal"></div>
              <div class="cd-situacion" 	style="font-size:10px; height:18px; float:left; width:50%; line-height:normal">Situacion</div>
              <div class="cd-trabajo" 	style="font-size:10px; height:18px; float:left; width:50%; line-height:normal">Hora</div></td>
            <td>&nbsp;</td>
            <td  class="btn-active"
                onMouseOver="this.className='btn-flickr'" 
                onMouseOut="this.className='btn-active'" ><div class="cd-nombre" 		style="font-size:22px; height:30px; margin:0 0 0 0; padding:0 0 0 0; line-height:normal">
              <div class="cd-nombre" 		style="font-size:22px; height:30px; margin:0 0 0 0; padding:0 0 0 0; line-height:normal"><span class="cd-nombre" style="font-size:22px; height:30px; margin:0 0 0 0; padding:0 0 0 0; line-height:normal">Cupo Libre</span></div>
              <div class="cd-servicio" 	style="font-size:14px; height:22px; margin:0 0 0 0; padding:0 0 0 0; line-height:normal"></div>
            </div>
              <div class="cd-servicio" 	style="font-size:14px; height:22px; margin:0 0 0 0; padding:0 0 0 0; line-height:normal"></div>
              <div class="cd-situacion" 	style="font-size:10px; height:18px; float:left; width:50%; line-height:normal">Situacion</div>
              <div class="cd-trabajo" 	style="font-size:10px; height:18px; float:left; width:50%; line-height:normal">Hora</div></td>
            <td>&nbsp;</td>
            <td  class="btn-active"
                onMouseOver="this.className='btn-flickr'" 
                onMouseOut="this.className='btn-active'" ><div class="cd-nombre" 		style="font-size:22px; height:30px; margin:0 0 0 0; padding:0 0 0 0; line-height:normal">
              <div class="cd-nombre" 		style="font-size:22px; height:30px; margin:0 0 0 0; padding:0 0 0 0; line-height:normal"><span class="cd-nombre" style="font-size:22px; height:30px; margin:0 0 0 0; padding:0 0 0 0; line-height:normal">Cupo Libre</span></div>
              <div class="cd-servicio" 	style="font-size:14px; height:22px; margin:0 0 0 0; padding:0 0 0 0; line-height:normal"></div>
            </div>
              <div class="cd-servicio" 	style="font-size:14px; height:22px; margin:0 0 0 0; padding:0 0 0 0; line-height:normal"></div>
              <div class="cd-situacion" 	style="font-size:10px; height:18px; float:left; width:50%; line-height:normal">Situacion</div>
              <div class="cd-trabajo" 	style="font-size:10px; height:18px; float:left; width:50%; line-height:normal">Hora</div></td>
            <td>&nbsp;</td>
            <td  class="btn-active"
                onMouseOver="this.className='btn-flickr'" 
                onMouseOut="this.className='btn-active'" ><div class="cd-nombre" 		style="font-size:22px; height:30px; margin:0 0 0 0; padding:0 0 0 0; line-height:normal"><span class="cd-nombre" style="font-size:22px; height:30px; margin:0 0 0 0; padding:0 0 0 0; line-height:normal">Cupo Libre</span></div>
              <div class="cd-servicio" 	style="font-size:14px; height:22px; margin:0 0 0 0; padding:0 0 0 0; line-height:normal"></div>
              <div class="cd-situacion" 	style="font-size:10px; height:18px; float:left; width:50%; line-height:normal">Situacion</div>
              <div class="cd-trabajo" 	style="font-size:10px; height:18px; float:left; width:50%; line-height:normal">Hora</div></td>
            <td>&nbsp;</td>
            <td  class="btn-active"
                onMouseOver="this.className='btn-flickr'" 
                onMouseOut="this.className='btn-active'" ><div class="cd-nombre" 		style="font-size:22px; height:30px; margin:0 0 0 0; padding:0 0 0 0; line-height:normal"><span class="cd-nombre" style="font-size:22px; height:30px; margin:0 0 0 0; padding:0 0 0 0; line-height:normal">Cupo Libre</span></div>
              <div class="cd-servicio" 	style="font-size:14px; height:22px; margin:0 0 0 0; padding:0 0 0 0; line-height:normal"></div>
              <div class="cd-situacion" 	style="font-size:10px; height:18px; float:left; width:50%; line-height:normal">Situacion</div>
              <div class="cd-trabajo" 	style="font-size:10px; height:18px; float:left; width:50%; line-height:normal">Hora</div></td>
            <td>&nbsp;</td>
            <td  class="btn-active"
                onMouseOver="this.className='btn-flickr'" 
                onMouseOut="this.className='btn-active'" ><div class="cd-nombre" 		style="font-size:22px; height:30px; margin:0 0 0 0; padding:0 0 0 0; line-height:normal">
              <div class="cd-nombre" 		style="font-size:22px; height:30px; margin:0 0 0 0; padding:0 0 0 0; line-height:normal"><span class="cd-nombre" style="font-size:22px; height:30px; margin:0 0 0 0; padding:0 0 0 0; line-height:normal">Cupo Libre</span></div>
              <div class="cd-servicio" 	style="font-size:14px; height:22px; margin:0 0 0 0; padding:0 0 0 0; line-height:normal"></div>
            </div>
              <div class="cd-servicio" 	style="font-size:14px; height:22px; margin:0 0 0 0; padding:0 0 0 0; line-height:normal"></div>
              <div class="cd-situacion" 	style="font-size:10px; height:18px; float:left; width:50%; line-height:normal">Situacion</div>
              <div class="cd-trabajo" 	style="font-size:10px; height:18px; float:left; width:50%; line-height:normal">Hora</div></td>
          </tr>
          <tr>
            <td align="center">&nbsp;</td>
            <td align="center">&nbsp;</td>
            <td align="center">&nbsp;</td>
            <td align="center">&nbsp;</td>
            <td align="center">&nbsp;</td>
            <td align="center">&nbsp;</td>
            <td align="center">&nbsp;</td>
            <td align="center">&nbsp;</td>
            <td align="center">&nbsp;</td>
            <td align="center">&nbsp;</td>
            <td align="center">&nbsp;</td>
            <td align="center">&nbsp;</td>
            <td align="center">&nbsp;</td>
          </tr>
 <tr>
            <td align="center">6</td>
            <td>&nbsp;</td>            <td  class="btn-active"
                onMouseOver="this.className='btn-flickr'" 
                onMouseOut="this.className='btn-active'" ><div class="cd-nombre" 		style="font-size:22px; height:30px; margin:0 0 0 0; padding:0 0 0 0; line-height:normal">
              <div class="cd-nombre" 		style="font-size:22px; height:30px; margin:0 0 0 0; padding:0 0 0 0; line-height:normal"><span class="cd-nombre" style="font-size:22px; height:30px; margin:0 0 0 0; padding:0 0 0 0; line-height:normal">Cupo Libre</span></div>
              <div class="cd-servicio" 	style="font-size:14px; height:22px; margin:0 0 0 0; padding:0 0 0 0; line-height:normal"></div>
            </div>
              <div class="cd-servicio" 	style="font-size:14px; height:22px; margin:0 0 0 0; padding:0 0 0 0; line-height:normal"></div>
              <div class="cd-situacion" 	style="font-size:10px; height:18px; float:left; width:50%; line-height:normal">Situacion</div>
              <div class="cd-trabajo" 	style="font-size:10px; height:18px; float:left; width:50%; line-height:normal">Hora</div></td>
<td>&nbsp;</td>
                        <td  class="btn-active"
                onMouseOver="this.className='btn-flickr'" 
                onMouseOut="this.className='btn-active'" ><div class="cd-nombre" 		style="font-size:22px; height:30px; margin:0 0 0 0; padding:0 0 0 0; line-height:normal">
                          <div class="cd-nombre" 		style="font-size:22px; height:30px; margin:0 0 0 0; padding:0 0 0 0; line-height:normal"><span class="cd-nombre" style="font-size:22px; height:30px; margin:0 0 0 0; padding:0 0 0 0; line-height:normal">Cupo Libre</span></div>
                          <div class="cd-servicio" 	style="font-size:14px; height:22px; margin:0 0 0 0; padding:0 0 0 0; line-height:normal"></div>
                        </div>
              <div class="cd-servicio" 	style="font-size:14px; height:22px; margin:0 0 0 0; padding:0 0 0 0; line-height:normal"></div>
              <div class="cd-situacion" 	style="font-size:10px; height:18px; float:left; width:50%; line-height:normal">Situacion</div>
              <div class="cd-trabajo" 	style="font-size:10px; height:18px; float:left; width:50%; line-height:normal">Hora</div></td>

            <td>&nbsp;</td>
                        <td  class="btn-active"
                onMouseOver="this.className='btn-flickr'" 
                onMouseOut="this.className='btn-active'" ><div class="cd-nombre" 		style="font-size:22px; height:30px; margin:0 0 0 0; padding:0 0 0 0; line-height:normal">
                          <div class="cd-nombre" 		style="font-size:22px; height:30px; margin:0 0 0 0; padding:0 0 0 0; line-height:normal"><span class="cd-nombre" style="font-size:22px; height:30px; margin:0 0 0 0; padding:0 0 0 0; line-height:normal">Cupo Libre</span></div>
                          <div class="cd-servicio" 	style="font-size:14px; height:22px; margin:0 0 0 0; padding:0 0 0 0; line-height:normal"></div>
                        </div>
              <div class="cd-servicio" 	style="font-size:14px; height:22px; margin:0 0 0 0; padding:0 0 0 0; line-height:normal"></div>
              <div class="cd-situacion" 	style="font-size:10px; height:18px; float:left; width:50%; line-height:normal">Situacion</div>
              <div class="cd-trabajo" 	style="font-size:10px; height:18px; float:left; width:50%; line-height:normal">Hora</div></td>

            <td>&nbsp;</td>
                        <td  class="btn-active"
                onMouseOver="this.className='btn-flickr'" 
                onMouseOut="this.className='btn-active'" ><div class="cd-nombre" 		style="font-size:22px; height:30px; margin:0 0 0 0; padding:0 0 0 0; line-height:normal"><span class="cd-nombre" style="font-size:22px; height:30px; margin:0 0 0 0; padding:0 0 0 0; line-height:normal">Cupo Libre</span></div>
              <div class="cd-servicio" 	style="font-size:14px; height:22px; margin:0 0 0 0; padding:0 0 0 0; line-height:normal"></div>
              <div class="cd-situacion" 	style="font-size:10px; height:18px; float:left; width:50%; line-height:normal">Situacion</div>
              <div class="cd-trabajo" 	style="font-size:10px; height:18px; float:left; width:50%; line-height:normal">Hora</div></td>

            <td>&nbsp;</td>
                        <td  class="btn-active"
                onMouseOver="this.className='btn-flickr'" 
                onMouseOut="this.className='btn-active'" ><div class="cd-nombre" 		style="font-size:22px; height:30px; margin:0 0 0 0; padding:0 0 0 0; line-height:normal"><span class="cd-nombre" style="font-size:22px; height:30px; margin:0 0 0 0; padding:0 0 0 0; line-height:normal">Cupo Libre</span></div>
              <div class="cd-servicio" 	style="font-size:14px; height:22px; margin:0 0 0 0; padding:0 0 0 0; line-height:normal"></div>
              <div class="cd-situacion" 	style="font-size:10px; height:18px; float:left; width:50%; line-height:normal">Situacion</div>
              <div class="cd-trabajo" 	style="font-size:10px; height:18px; float:left; width:50%; line-height:normal">Hora</div></td>

            <td>&nbsp;</td>
                        <td  class="btn-active"
                onMouseOver="this.className='btn-flickr'" 
                onMouseOut="this.className='btn-active'" ><div class="cd-nombre" 		style="font-size:22px; height:30px; margin:0 0 0 0; padding:0 0 0 0; line-height:normal">
                          <div class="cd-nombre" 		style="font-size:22px; height:30px; margin:0 0 0 0; padding:0 0 0 0; line-height:normal"><span class="cd-nombre" style="font-size:22px; height:30px; margin:0 0 0 0; padding:0 0 0 0; line-height:normal">Cupo Libre</span></div>
                          <div class="cd-servicio" 	style="font-size:14px; height:22px; margin:0 0 0 0; padding:0 0 0 0; line-height:normal"></div>
                        </div>
              <div class="cd-servicio" 	style="font-size:14px; height:22px; margin:0 0 0 0; padding:0 0 0 0; line-height:normal"></div>
              <div class="cd-situacion" 	style="font-size:10px; height:18px; float:left; width:50%; line-height:normal">Situacion</div>
              <div class="cd-trabajo" 	style="font-size:10px; height:18px; float:left; width:50%; line-height:normal">Hora</div></td>

            </tr>
          <tr>
            <td align="center">&nbsp;</td>
            <td align="center">&nbsp;</td>
            <td align="center">&nbsp;</td>
            <td align="center">&nbsp;</td>
            <td align="center">&nbsp;</td>
            <td align="center">&nbsp;</td>
            <td align="center">&nbsp;</td>
            <td align="center">&nbsp;</td>
            <td align="center">&nbsp;</td>
            <td align="center">&nbsp;</td>
            <td align="center">&nbsp;</td>
            <td align="center">&nbsp;</td>
            <td align="center">&nbsp;</td>
          </tr>
<tr>
            <td align="center">7</td>
            <td>&nbsp;</td>            <td  class="btn-active"
                onMouseOver="this.className='btn-flickr'" 
                onMouseOut="this.className='btn-active'" ><div class="cd-nombre" 		style="font-size:22px; height:30px; margin:0 0 0 0; padding:0 0 0 0; line-height:normal">
              <div class="cd-nombre" 		style="font-size:22px; height:30px; margin:0 0 0 0; padding:0 0 0 0; line-height:normal"><span class="cd-nombre" style="font-size:22px; height:30px; margin:0 0 0 0; padding:0 0 0 0; line-height:normal">Cupo Libre</span></div>
              <div class="cd-servicio" 	style="font-size:14px; height:22px; margin:0 0 0 0; padding:0 0 0 0; line-height:normal"></div>
            </div>
              <div class="cd-servicio" 	style="font-size:14px; height:22px; margin:0 0 0 0; padding:0 0 0 0; line-height:normal"></div>
              <div class="cd-situacion" 	style="font-size:10px; height:18px; float:left; width:50%; line-height:normal">Situacion</div>
              <div class="cd-trabajo" 	style="font-size:10px; height:18px; float:left; width:50%; line-height:normal">Hora</div></td>
<td>&nbsp;</td>
                        <td  class="btn-active"
                onMouseOver="this.className='btn-flickr'" 
                onMouseOut="this.className='btn-active'" ><div class="cd-nombre" 		style="font-size:22px; height:30px; margin:0 0 0 0; padding:0 0 0 0; line-height:normal"><span class="cd-nombre" style="font-size:22px; height:30px; margin:0 0 0 0; padding:0 0 0 0; line-height:normal">Cupo Libre</span></div>
              <div class="cd-servicio" 	style="font-size:14px; height:22px; margin:0 0 0 0; padding:0 0 0 0; line-height:normal"></div>
              <div class="cd-situacion" 	style="font-size:10px; height:18px; float:left; width:50%; line-height:normal">Situacion</div>
              <div class="cd-trabajo" 	style="font-size:10px; height:18px; float:left; width:50%; line-height:normal">Hora</div></td>

            <td>&nbsp;</td>
                        <td  class="btn-active"
                onMouseOver="this.className='btn-flickr'" 
                onMouseOut="this.className='btn-active'" ><div class="cd-nombre" 		style="font-size:22px; height:30px; margin:0 0 0 0; padding:0 0 0 0; line-height:normal">
                          <div class="cd-nombre" 		style="font-size:22px; height:30px; margin:0 0 0 0; padding:0 0 0 0; line-height:normal"><span class="cd-nombre" style="font-size:22px; height:30px; margin:0 0 0 0; padding:0 0 0 0; line-height:normal">Cupo Libre</span></div>
                          <div class="cd-servicio" 	style="font-size:14px; height:22px; margin:0 0 0 0; padding:0 0 0 0; line-height:normal"></div>
                        </div>
              <div class="cd-servicio" 	style="font-size:14px; height:22px; margin:0 0 0 0; padding:0 0 0 0; line-height:normal"></div>
              <div class="cd-situacion" 	style="font-size:10px; height:18px; float:left; width:50%; line-height:normal">Situacion</div>
              <div class="cd-trabajo" 	style="font-size:10px; height:18px; float:left; width:50%; line-height:normal">Hora</div></td>

            <td>&nbsp;</td>
                        <td  class="btn-active"
                onMouseOver="this.className='btn-flickr'" 
                onMouseOut="this.className='btn-active'" ><div class="cd-nombre" 		style="font-size:22px; height:30px; margin:0 0 0 0; padding:0 0 0 0; line-height:normal"><span class="cd-nombre" style="font-size:22px; height:30px; margin:0 0 0 0; padding:0 0 0 0; line-height:normal">Cupo Libre</span></div>
              <div class="cd-servicio" 	style="font-size:14px; height:22px; margin:0 0 0 0; padding:0 0 0 0; line-height:normal"></div>
              <div class="cd-situacion" 	style="font-size:10px; height:18px; float:left; width:50%; line-height:normal">Situacion</div>
              <div class="cd-trabajo" 	style="font-size:10px; height:18px; float:left; width:50%; line-height:normal">Hora</div></td>

            <td>&nbsp;</td>
                        <td  class="btn-active"
                onMouseOver="this.className='btn-flickr'" 
                onMouseOut="this.className='btn-active'" ><div class="cd-nombre" 		style="font-size:22px; height:30px; margin:0 0 0 0; padding:0 0 0 0; line-height:normal">Cupo Libre</div>
              <div class="cd-servicio" 	style="font-size:14px; height:22px; margin:0 0 0 0; padding:0 0 0 0; line-height:normal"></div>
              <div class="cd-situacion" 	style="font-size:10px; height:18px; float:left; width:50%; line-height:normal">Situacion</div>
              <div class="cd-trabajo" 	style="font-size:10px; height:18px; float:left; width:50%; line-height:normal">Hora</div></td>

            <td>&nbsp;</td>
                        <td  class="btn-active"
                onMouseOver="this.className='btn-flickr'" 
                onMouseOut="this.className='btn-active'" ><div class="cd-nombre" 		style="font-size:22px; height:30px; margin:0 0 0 0; padding:0 0 0 0; line-height:normal"><span class="cd-nombre" style="font-size:22px; height:30px; margin:0 0 0 0; padding:0 0 0 0; line-height:normal">Cupo Libre</span></div>
              <div class="cd-servicio" 	style="font-size:14px; height:22px; margin:0 0 0 0; padding:0 0 0 0; line-height:normal"></div>
              <div class="cd-situacion" 	style="font-size:10px; height:18px; float:left; width:50%; line-height:normal">Situacion</div>
              <div class="cd-trabajo" 	style="font-size:10px; height:18px; float:left; width:50%; line-height:normal">Hora</div></td>

            </tr>
          <tr>
            <td align="center">&nbsp;</td>
            <td align="center">&nbsp;</td>
            <td align="center">&nbsp;</td>
            <td align="center">&nbsp;</td>
            <td align="center">&nbsp;</td>
            <td align="center">&nbsp;</td>
            <td align="center">&nbsp;</td>
            <td align="center">&nbsp;</td>
            <td align="center">&nbsp;</td>
            <td align="center">&nbsp;</td>
            <td align="center">&nbsp;</td>
            <td align="center">&nbsp;</td>
            <td align="center">&nbsp;</td>
          </tr>
		</thead>
    </table>
</div>
                  <!--  Leyenda<br>
                    Lleno<br>
                    Libre<br>
                    No disponible<br> 
                   <br />-->
                 
         </fieldset></p>
         <button type="button" class="btn" onClick="test()">Test</button>
       </div>
            
         <!--Seccion 3-->
         <div class="tab-pane fade" id="tab_3"><p>
              <legend>Ya falta poco!</legend>
            <div class="well">
            <p>
              <h4>Gracias por ingresar tu solicitud!</h4> 
                   <ul><li> Al darle confirmar tus datos ser�n procesados. </li> 
					<li>Dentro de las 24 horas se comunicar&aacute; contigo un representante del taller para confirmar tus datos </li>
					<li>Si te queda alguna duda podes hacer las consultas al asesor!</li></ul>
                    </p>
            </div>
             <center><button name="enviar" type="button" class="btn" style="clear:both" onClick="guardarFicha();">Enviar solicitud!</button></center> 
         </p></div>
          <!--Seccion 4-->
        <!-- <div class="tab-pane fade" id="tab_4"><p>What up girl, this is Section 3.</p></div>-->
 	</div>
 </div>
     
</div>     
     <br style="clear:both">
<br>
<br>
<br>
<br>
<?php 

?>
 <!--          <?php echo TbHtml::tabbableTabs(array(
    array('label' => 'Section 1', 'active' => true, 'content' => '<p>I\'m in Section 1.</p>'),
    array('label' => 'Section 2', 'content' => '<p>Howdy, I\'m in Section 2.</p>'),
    array('label' => 'Section 3', 'content' => '<p>What up girl, this is Section 3.</p>'),
    )); ?> -->
      


</body>
</html>
