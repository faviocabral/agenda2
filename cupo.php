<?php 
include_once ("inc/conexion.php");
session_start();
if (!isset($_SESSION['usuario']))
{
	header("location:index.php");  
} 

header('Access-Control-Allow-Origin: *');
?>
<!doctype html>
<html><head> 
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<link rel="shortcut icon" href="clip.ico">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="Reservas para servhices de mantenimientos">
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

<!--toast -->
<link rel="stylesheet" href="js/toast/toastr.min.css">
<script src="js/toast/toastr.min.js"></script>
 

<link rel="stylesheet" type="text/css" href="dist/pivot.css">
<script type="text/javascript" src="dist/pivot.js"></script>

<link href="https://unpkg.com/bootstrap-table@1.22.1/dist/bootstrap-table.min.css" rel="stylesheet">
<link href="https://unpkg.com/bootstrap-table@1.22.1/dist/extensions/sticky-header/bootstrap-table-sticky-header.css" rel="stylesheet">

<script src="https://unpkg.com/bootstrap-table@1.22.1/dist/bootstrap-table.min.js"></script>
<script src="https://unpkg.com/bootstrap-table@1.22.1/dist/extensions/sticky-header/bootstrap-table-sticky-header.min.js"></script>



<link href="css/datepicker.css" rel="stylesheet"> <!--No necesario-->
<link href="css/bootstrap.css" rel="stylesheet">
<!--<link href="css/bootstrap.css.map" rel="stylesheet">-->
<!--<link href="css/bootstrap.min.css" rel="stylesheet">-->			<!--COMENTADO POR DUPLICIDAD-->
<!--<link href="css/bootstrap-theme.css" rel="stylesheet">-->		<!--COMENTADO POR DUPLICIDAD-->
<!--<link href="css/bootstrap-theme.css.map" rel="stylesheet">-->
<link href="css/bootstrap-theme.min.css" rel="stylesheet">

<link href="css/bootstrap-social.css" rel="stylesheet">

<style>
	.text-white{
		color: white;
		border-radius: 5px;
		padding-left: 3px;
		padding-right: 3px;
		font-weight: bold;
	}
	.f-asesor{
		background:#5F9EA0;
		color:white;
		font-weight:bold;
	}
</style>

<script>
$(window).load(function()
{
	// Example #1 - Basic calendar
	$('#example1').glDatePicker(
	{
		showAlways: false,
		 selectableDates: [
            { date: new Date(0, 8, 5), repeatYear: true },
            { date: new Date(0, 0, 14), repeatMonth: true, repeatYear: true },
            { date: new Date(0, 0, 13), repeatMonth: true, repeatYear: true },
            { date: new Date(2013, 0, 24), repeatMonth: true },
            { date: new Date(2013, 11, 25) },
         ]
	});
	$('#example1').glDatePicker(true).selectedDate=new Date(2015, 2, 2);
 	// Example #3 - Custom style, repeating special dates and callback
	$('#cd-dropdown').dropdown();
	
});

$(document).ready(function(){

	$('[data-toggle="tooltip"]').tooltip();	
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

function sincronizar()
{
	cal = new Array();
 
	var respuesta = $.ajax({
				url: "inc/procesos.php",
				global:true,
				type: "POST",
				data: "accion="+accion+
					  "&idfun="+idfun,
				contentType: "application/x-www-form-urlencoded",
				dataType: "html",
				async: true,					
				ifModified: false,
				processData:true,
				beforeSend: function(objeto){},
				complete: function(objeto, exito){  
					if(exito=="success"){ }},
					error: function(objeto, quepaso, otroobj){ },
					success: function(datos){
					///////////////////// --- Acciones con los datos obtenidos --- /////////////////////

					 var resdatos = datos.split("*tab*");
					 if(resdatos[0] == 'ok')
					 {
						return resdatos[1];
					 }else{
						// alert(resdatos[1]);
					 } 
					}, 
				}
			).responseText;
}
 	var today = new Date();
	var dd = today.getDate();
	var mm = today.getMonth()+1; //January is 0!
	var yyyy = today.getFullYear();
	var datelimit = new Date(today);
	datelimit.setDate(today.getDate() + 180);
	today.setDate(today.getDate() - 120);
	//alert(today);
 	var marcarDia ;
//	 marcarDia = '30/05/2014';
//	 marcarDia = new Date(2014, 5, 30);
 
//	today = yyyy+'/'+mm+'/'+dd;

 $(window).load(function()
{
// alert($('#resaltarfecha').val());
//alert(marcarDia);

var diaResaltado = $('#resaltarfecha').val().split('/'); // Se le resta 1 al mes para q empieze enero en 0
	$('#mydate').glDatePicker(
	{
		showAlways: false,
        specialDates: [
             {
                //date: new Date(2015, 2, 30),
                date: new Date(diaResaltado[2],(diaResaltado[1]-1),diaResaltado[0]),
               // data: { message: 'Meeting every day 8 of the month' },
               //  repeatMonth: true
            }
        ],
		onShow: function(glDatePicker) { glDatePicker.slideDown('');
	},
//		onHide: function(glDatePicker) { glDatePicker.slideUp(''); },
		cssName: 'default',
		// The hidden field to receive the date
		// altField: "#mydate",
		// The format you want
		altFormat: "dd/mm/yyyy",
		// The format the user actually sees
		dateFormat: "dd/mm/yyyy",  
 //		selectedDate: Date(today),
//		specialDates: [
//			{
//				date: marcarDia,
//				data: { message: '' },
//				repeatMonth: true,
//				repeatYear: true
//			},
//		],
//		onChange: function(target, newDate)
//		{
//			target.val
//			(
//				newDate.getFullYear() + "-" +
//				(newDate.getMonth() + 1) + "-" +
//				newDate.getDate()
//			);
//		},
//		selectedDate: $("#resaltarfecha").val(),
		
 		selectableDateRange: [{
 			from: today,
			to: datelimit
		}, ],
 		
		startDate: new Date(),
		dowOffset: 1,
		// Hide the calendar when a date is selected (only if showAlways is set to false).
		hideOnClick: true,
 		selectableYears: 	[2014, 2015, 2016, 2017, 2018, 2019, 2020, 2021, 2022, 2023, 2024],
		selectableMonths: 	[0, 1 , 2 , 3 , 4, 5, 6, 7, 8, 9, 10, 11],
		selectableDOW: 		[1, 2, 3, 4, 5, 6],
		// Callback that will trigger when the user clicks a selectable date.
		// Parameters that are passed to the callback:
		//     el : The input element the date picker is bound to
		//   cell : The cell on the calendar that triggered this event
		//   date : The date associated with the cell
		//   data : Special data associated with the cell (if available, otherwise, null)
		//		onHover: (function(el, cell, date, data) {
		//        	el.val(date.toLocaleDateString());
		//    		}),
        onClick: function(target, cell, date, data) {
/*			var z  = date.getDate() + '/' +
                (date.getMonth() + 1) + '/' +
                date.getFullYear();
*/
			var z  = date.getFullYear() + '-' + (date.getMonth() + 1) + '-' + date.getDate() ;

            target.val(z);
			$("#resaltarfecha").val($('#mydate').val());
			consultar();
			//$("#formFecha").submit();

        } 
 	});
	
	//$('#mydate').glDatePicker(true).selectedDate=new Date(2015, 2, 2);
	
});

 
function traerNombre(idfun)
{
	var accion = 'traerNombre';

		var respuesta = $.ajax({
					url: "inc/procesos.php",
					global:true,
					type: "POST",
					data: "accion="+accion+
						  "&idfun="+idfun,
					contentType: "application/x-www-form-urlencoded",
					dataType: "html",
					async: true,					
					ifModified: false,
					processData:true,
					beforeSend: function(objeto){},
					complete: function(objeto, exito){  
						if(exito=="success"){ }},
						error: function(objeto, quepaso, otroobj){ },
						success: function(datos){
						///////////////////// --- Acciones con los datos obtenidos --- /////////////////////

 						 var resdatos = datos.split("*tab*");
  						 if(resdatos[0] == 'ok')
						 {
							return resdatos[1];
						 }else{
						 	alert(resdatos[1]);
						 }
 						},							
					}
				).responseText;
				
}
 

function manejarFicha(accion, xficha, xfecha, xcolumna, xcupo, nombre, ci, celular, servicio, comentario, oldData, objeto)
{
//	accion:
//	nuevaFicha
//	eliminarFicha
//	atenderCliente
//  alert(accion+' _ '+xficha+' _ '+xfecha+' _ '+xcolumna+' _ '+ xcupo);
//  
	var error=0;
//	alert(objeto.closest("#nuevoFormulario").find("#nuevoNombre").val());

	if ( (!nombre || !ci || !celular) && (accion =='nuevaFicha')) error++;
  	
 	if (error == 0)
		{
		var respuesta = $.ajax({
					url: "inc/procesos.php",
					global:true,
					type: "POST",
					data: "accion="			+accion+
						  "&xficha="		+xficha+
						  "&xfecha="		+xfecha+
						  "&xcolumna="		+xcolumna+
						  "&xcupo="			+xcupo+
						  "&nombre="		+nombre+
						  "&ci="			+ci+
						  "&servicio="		+servicio+
 						  "&comentario="	+comentario+
 						  "&celular="		+celular,
					contentType: "application/x-www-form-urlencoded",
					dataType: "html",
					async: true,					
					ifModified: false,
					processData:true,
					beforeSend: function(objeto){},
					complete: function(objeto, exito){  
						if(exito=="success"){ }},
						error: function(objeto, quepaso, otroobj){ },
						success: function(datos){
						///////////////////// --- Acciones con los datos obtenidos --- /////////////////////
						// alert( "DATOS:"+datos);
						 var resdatos;
 						 resdatos = datos.split("*tab*");
  						 if(resdatos[0] == 'ok')
						 {
							// $('#error-nuevaFicha').html(datos);
						 	// window.location.href = "cupo.php?fecha="+xfecha;
							// Distribuir los valores recuperados del ajax luego del "insert"
							var zficha 			= resdatos[1];
							var zfecha 			= resdatos[2];
							var zcolumna 		= resdatos[3];
							var zcupo 			= resdatos[4];
							var zhora_selec 	= resdatos[5];
							var znombre 		= resdatos[6]; // .substring(0,18);
							var zidfunc 		= resdatos[7];
							var zdocumento 		= resdatos[8];
							var zcelular		= resdatos[9];
							var zservicio 		= resdatos[10];
							var zhora_solicitud = resdatos[11];
							var zcomentario 	= resdatos[12];
							var znombrefuncarga	= resdatos[13];
							//alert(znombrefuncarga);
							var zz = zcupo+zcolumna;
							
 							// Quitar formulario de nueva ficha para esta celda y generar nuevo codigo HTML
						 	$("#popover-head"+zz).html('');
						 	$("#popover-content"+zz).html(
													'<div id="nuevoFormulario">'+
													'<input type="hidden" id="xficha" 	value="'+zficha+'" />'+
													'<input type="hidden" id="xcolumna" value="'+zcolumna+'" />'+
													'<input type="hidden" id="xcupo" 	value="'+zcupo+'" />'+
													'<input type="hidden" id="xfecha" 	value="'+zfecha+'" />'+
																										
													'<span class="attData" id="att_cont_accion'+zz+'">'+
													'<button type="button" id="button_accion'+zz+'" class="btn btn-warning" value="Get">Atender</button>'+ 
													'</span> '+
													
													'<span class="delData" id="del_cont_accion"'+zz+'>'+
													'<button type="button" id="button_accion'+zz+'" class="btn btn-danger" value="Get">Eliminar</button> '+ 
													'</span>'+
													
													'</div>'
													);
 							$('#celda'+zz).popover('destroy');

//		<span class="attData" id="att_cont_accionx">
//			<button type="button" id="button_accionx" class="btn btn-warning" value="Get">Atender</button>  
//		</span>	
//		<span class="delData" id="del_cont_accionx">
//			<button type="button" id="button_accionx" class="btn btn-danger" value="Get">Eliminar</button>  
//		</span>	
							
							// Valores solo para el Tooltip
 							var newValue=   '<div style="text-align:left; overflow:hidden">'+znombre+'<br>'+ 
											'<span style="font-size:11px;">Cel:</span>'+zcelular+'<br>'+  
											'<span style="font-size:11px;">Doc:</span>'+zdocumento+'<br>'+  
											'<span style="font-size:11px;">Comentario:</span>'+zcomentario+'<br>'+  
											'<span style="font-size:11px;">Funcionario:</span><br>'+znombrefuncarga+'</div>';
											
											// FUNCIONA para colocar los botones y los divs pero se volvera a imprimir de cero
											//'<div id="cont_accion'+zz+'" class="delData">'+					
											//'<button type="button" id="" class="btn btn-danger" value="Get">Eliminar</button>  '+
											//'</div>';
											//--------------------------------------------------------------------------------
  							
  							$("#celda"+zz)
 									.mouseover(function() {
										$(this).attr('class', 'btn-flickr');
									})
									.mouseout(function() {
										$(this).attr('class', 'btn-flickr');
									})
									.attr('class', 'btn-flickr')						// OK
 									.attr('data-toggle', 'tooltip'+zz)					// OK
 									.attr('rel', 'tooltip')								// OK
  									.data( 'html', true ) 								// OK
 									.attr('onclick','runPopup("'+zcupo+'","'+zcolumna+'","'+zz+'")')
									.attr('data-original-title', newValue)
									.tooltip('fixTitle')
 									.html(    											//OK
												'<div class=cd-nombre style="max-height:42px; overflow:hidden">'+znombre+'</div>'+
												'<div class=cd-servicio>'+zservicio+'</div>'
							);
															 
 						 }else{
							$('#error-nuevaFicha').html(resdatos[0]);
						 }

						if (accion == "atenderCliente" )
						{

							var zhora_atencion	 			= resdatos[13];
							var zid_funcionario_atencion 	= resdatos[14];

							var zpantalla 					= resdatos[15];
 							 
											$("#celda"+zz)
													.popover('destroy')
													.tooltip('destroy')
 													.mouseover(function() {
														$(this).attr('class', 'btn-warning');
													})
													.mouseout(function() {
														$(this).attr('class', 'btn-warning');
													})
													.attr('class', 'btn-warning')						// OK
													.attr('data-toggle', '')							// OK
													.attr('rel', '')									// OK
													.data('html', true ) 								// OK
													.tooltip('fixTitle')		
													.html(    											// OK
													'<div style="position:relative;padding-left:3px; margin-top:4px; width:100px; height:20px; font-size:11px; display:block; overflow:hidden;">'+znombre+'</div>'+
													'<div style="float:left; padding-left:3px; font-size:16px; width:67px;">Atendido </div>'+
									 				'<div style="float:left; margin-top:1px;  padding-left:3px; font-size:11px; color:yellow;">'+zpantalla+'</div>'+
													'<div style="float:right; margin-top:2px; margin-right:1px; font-size:10px; color:yellow">'+zhora_atencion.substring(0,5)+'</div>'
 											);	
											 
									//---------------------------------------
												$("#popover-head"+zz).html('');
												$("#popover-content"+zz).html(
																	'<div id="nuevoFormulario">'+
																	'<input type="hidden" id="xficha"  	value="'+zz+'" />'+
																	'<input type="hidden" id="xcolumna" value="'+zcolumna+'" />'+
																	'<input type="hidden" id="xcupo" 	value="'+zcupo+'" />'+
																	'<input type="hidden" id="xfecha" 	value="'+zfecha+'" />'+
																	'</div>'
												);
						}
						 
						},							
					}
				).responseText;
		}else{
	
			alert('Debe completar los campos requeridos');
 		 	$("#celda"+xcupo+xcolumna).html(oldData);
		}
		if (accion == 'eliminarFicha' )
		{
 		
								$("#celda"+xcupo+xcolumna)	.popover('destroy')
														  	.tooltip('destroy')
								 						  	.html(    	
																'<div class="cd-nombre" style="height:42px; "> <br>Libre</div>'+
																'<div class="cd-servicio">&nbsp;</div>')
														  	.mouseover(function() {
																$(this).attr('class', 'btn-flickr');
															})
															.mouseout(function() {
																$(this).attr('class', 'btn-primary');
															})
															.attr('class', 'btn-primary')						// OK
															.attr('data-toggle', ''	)				  			// OK
															.attr('rel', '')									// OK
															.data( 'html', false ) 								// OK
															.attr('data-original-title', 'Nuevo Registro')
															 ;
 					//---------------------------------------
								$("#popover-head"+xcupo+xcolumna).html('');
								$("#popover-content"+xcupo+xcolumna).html(
														'<div id="nuevoFormulario">'+
														'<input type="hidden" id="xficha"  	value="'+xcupo+xcolumna+'" />'+
														'<input type="hidden" id="xcolumna"  value="'+xcolumna+'" />'+
														'<input type="hidden" id="xcupo" 	value="'+xcupo+'" />'+
														'<input type="hidden" id="xfecha" 	value="'+ $('#mydate').val()+'" />'+
														'<input type="textbox" id="nuevoNombre" 	class="form-control" value="" placeholder="Nombre" /> '+
														'<input type="textbox" id="nuevoDocumento" 	class="form-control" value="" placeholder="Documento"/> '+
														'<input type="textbox" id="nuevoCelular" 	class="form-control" value="" placeholder="Celular"/> '+
														'<textarea cols="20"   id="nuevoComentario" class="form-control" rows="4" placeholder="Breve comentario" style="width:230px"></textarea>'+
														'<select 			  id="nuevoServicio" 	class="form-control" style="margin-bottom:5px;" >'+
														'		<option value="Mantenimiento" selected>Mantenimiento</option> '+
														'		<option value="Express">Express</option> '+
														'		<option value="Auxilio">Auxilio</option> '+
														'</select>'+
														'<div class="getData" id="cont_accion'+xcupo+xcolumna+'">'+
														'	<button type="button" id="button_accion'+xcupo+xcolumna+'" class="btn btn-primary" value="Get">Agendar</button> '+ 
														'</div>'+
														'</div>'
														);
   		}

}

// VERIFICAR SI LA FICHA YA ESTA OCUPADA
 function verificarFicha(accion, xficha, xfecha, xcolumna, xcupo, nombre, ci, celular, servicio, comentario, oldData, objeto)
{
//	accion:
//	nuevaFicha
//	eliminarFicha
//  alert(accion+' _ '+xficha+' _ '+xfecha+' _ '+xcolumna+' _ '+ xcupo);
	var error=0;
	var respuesta = $.ajax({
					url: "inc/procesos.php",
					global:true,
					type: "POST",
					data: "accion="			+accion+
						  "&xficha="		+xficha+
						  "&xfecha="		+xfecha+
						  "&xcolumna="		+xcolumna+
						  "&xcupo="			+xcupo+
						  "&nombre="		+nombre+
						  "&ci="			+ci+
						  "&servicio="		+servicio+
 						  "&comentario="	+comentario+
 						  "&celular="		+celular,
					contentType: "application/x-www-form-urlencoded",
					dataType: "html",
					async: true,					
					ifModified: false,
					processData:true,
					beforeSend: function(objeto){},
					complete: function(objeto, exito){  
						if(exito=="success"){ }},
						error: function(objeto, quepaso, otroobj){ },
						success: function(datos){
						///////////////////// --- Acciones con los datos obtenidos --- /////////////////////
						// alert(datos);
						 var resdatos;
 						 resdatos = datos.split("*tab*");
//						 alert ("res: "+resdatos[0]);
 						 if(resdatos[0] == '1')
						 {
						 	 alert ("Lo sentimos, cupo no disponible");
							 window.location.href = "cupo.php?fecha="+$('#mydate').val();
						 }
 						},							
					}
				).responseText;
 }
  
function probar()
{
 	$('#celdax'). 	popover({
					html: true,
 					placement: 'down',
					title: function () {
						return $('#popover-headx').html();
						},
					content:  function () {
						return $('#popover-contentx').html();
						},
					});	 
 }
// VERIFICAR SI LA FICHA ESTA CARGANDOSE EN ESTE MOMENTO
function comprobarFichaAbierta(i, j , x)
{
/*	
//	i: filas
//	j: columnas
//	x: filascolumnas concatenadas
*/
var lafecha = $('#mydate').val();
accion = 'comprobarFichaAbierta';

  		var respuesta = $.ajax({
					url: "inc/procesos.php",
					global:true,
					type: "POST",
					data: "accion="			+accion+
						  "&xfecha="		+lafecha+
						  "&xcolumna="		+j+
						  "&xcupo="			+i,
					contentType: "application/x-www-form-urlencoded",
					dataType: "html",
					async: true,	
					ifModified: false,
					processData:true,
					beforeSend: function(objeto){},
					complete: function(objeto, exito){  
						if(exito=="success"){ }},
						error: function(objeto, quepaso, otroobj){ },
						success: function(datos){
						///////////////////// --- Acciones con los datos obtenidos --- /////////////////////
						// alert(datos);
						 var resdatos;
 						 resdatos = datos.split("*tab*");
 						  //alert ("res: "+resdatos[0]);

 						 if(resdatos[0] == 'ficha-abierta')
						 {
						 	 alert ("Lo sentimos. Ficha ya abierta por "+resdatos[1]);
							 $("#celda"+x).popover('hide');
 							 //window.location.href = "cupo.php?fecha="+$('#mydate').val();
						 }
 						 if(resdatos[0] == 'no-disponible')
						 {
						 	 alert ("Lo sentimos. Cupo reservado" );
 							 window.location.href = "cupo.php?fecha="+$('#mydate').val();
						 }
 						 if(resdatos[0] == 'disponible')
						 {
							 //window.location.href = "cupo.php?fecha="+$('#mydate').val();
							// inicial(i, j , x);
						 }
 						},							
					}
				).responseText;
}

function desvincularFichaAbierta()
{
accion = 'desvincularFichaAbierta';
  		var respuesta = $.ajax({
					url: "inc/procesos.php",
					global:true,
					type: "POST",
					data: "accion="			+accion,
					contentType: "application/x-www-form-urlencoded",
					dataType: "html",
					async: true,					
					ifModified: false,
					processData:true,
					beforeSend: function(objeto){},
					complete: function(objeto, exito){  
						if(exito=="success"){ }},
						error: function(objeto, quepaso, otroobj){ },
						success: function(datos){
						///////////////////// --- Acciones con los datos obtenidos --- /////////////////////
 						},							
					}
				).responseText;
}

function inicial(i, j , x)
{
	//alert('i'+i+' j'+j+' x'+x);
 	var lafecha = $('#mydate').val();
	//verificarFicha ('disponibilidad',0,lafecha, j, i);
	comprobarFichaAbierta(i, j , x);
  	mx = x;
 	var direccion= "right";
	if (j > 5){direccion = "left"};  
	if (i == 0){direccion = "bottom"};  
	if (i == 9){direccion = "top"};  
	
 
 	$('#celda'+mx).popover({
					html: true,
					
					placement: direccion,
 					title: function () {
						return $('#popover-head'+mx).html();
						},
					content:  function () {
						return $('#popover-content'+mx).html();
						},
					} );

 	$(document).on("click", "#close"+x, function ()
		{
			desvincularFichaAbierta();
			$("#celda"+x).popover('hide');
		}
	);
 }
 
 var mx; 
 var my;
 
 function runPopup(i, j , y)
{
 	my = y;
 	var direccion= "right";
	if (j > 5){direccion = "left"};  
	if (i == 0){direccion = "bottom"};  
	if (i == 9){direccion = "top"};  
	 
 	$('#celda'+my).popover({
					html: true,
					 
					placement: direccion,
					title: function () {
						return $('#popover-head'+my).html();
						},
					content:  function () {
						return $('#popover-content'+my).html();
						},
					});
	
	$(document).on("click", "#close"+y, function () 
		{
		$("#celda"+y).popover('hide');
		}
	);
}
 $(function() {
$('.btn-primary').tooltip({placement:'top'});
$('.btn-primary').tooltip({placement:'top'});
$('.btn-warning').tooltip({placement:'top'});
$('.btn-danger').tooltip({placement:'top'});
$('.btn-flickr').tooltip({placement:'top'});
 
$('#celdax').click(function(){
	$('#celdax').popover();
}); 

	for (j = 0; j < 10; j++)
	{
		for (i = 0; i < 12; i++)
		{
 			$('#celda'+j+i).click(function(){
			
				$('#celda'+j+i).popover();
			
			}); 
		}
	}

 
// Proceso para eliminar una Ficha 
 
		$(document).on("click", ".attData", function () {

		var ctlInputxficha 		= $(this).closest("#nuevoFormulario").find("#xficha").val();
		var ctlInputxfecha 		= $(this).closest("#nuevoFormulario").find("#xfecha").val();
		var ctlInputxcolumna	= $(this).closest("#nuevoFormulario").find("#xcolumna").val();
		var ctlInputxcupo 		= $(this).closest("#nuevoFormulario").find("#xcupo").val();
		var objeto 				= $(this);
		$("#celda"+ctlInputxcupo+ctlInputxcolumna).popover('hide');
		$("#celda"+ctlInputxcupo+ctlInputxcolumna).html('<img style="padding-top:20px;padding-left:37px" src="img/loading-flickr.png" border="0" /> ');
		
		setTimeout(function(){manejarFicha(
							'atenderCliente',
							ctlInputxficha,
							ctlInputxfecha,
							ctlInputxcolumna,
							ctlInputxcupo,
							0, 0, 0, 0, 0, 0,
							objeto
						)}, 750); 
 
		});
		$(document).on("click", ".delData", function () {
		var ctlInputxficha 		= $(this).closest("#nuevoFormulario").find("#xficha").val();
		var ctlInputxfecha 		= $(this).closest("#nuevoFormulario").find("#xfecha").val();
		var ctlInputxcolumna	= $(this).closest("#nuevoFormulario").find("#xcolumna").val();
		var ctlInputxcupo 		= $(this).closest("#nuevoFormulario").find("#xcupo").val();
		var objeto 				= $(this);
		$("#celda"+ctlInputxcupo+ctlInputxcolumna).popover('hide');
		$("#celda"+ctlInputxcupo+ctlInputxcolumna).html('<img style="padding-top:20px;padding-left:37px" src="img/loading-flickr.png" border="0" /> ');
		
		setTimeout(function(){manejarFicha(
							'eliminarFicha',
							ctlInputxficha,
							ctlInputxfecha,
							ctlInputxcolumna,
							ctlInputxcupo,
							0, 0, 0, 0, 0, 0,
							objeto
						)}, 1000); 
		});

// Proceso para agregar nueva Ficha
		$(document).on("click", ".getData", function () {
		var ctlInputxficha 		= $(this).closest("#nuevoFormulario").find("#xficha").val();
		var ctlInputxfecha 		= $(this).closest("#nuevoFormulario").find("#xfecha").val();
		var ctlInputxcolumna	= $(this).closest("#nuevoFormulario").find("#xcolumna").val();
		var ctlInputxcupo 		= $(this).closest("#nuevoFormulario").find("#xcupo").val();
		var ctlInputNombre 		= $(this).closest("#nuevoFormulario").find("#nuevoNombre").val();
		var ctlInputDocumento 	= $(this).closest("#nuevoFormulario").find("#nuevoDocumento").val();
		var ctlInputCelular 	= $(this).closest("#nuevoFormulario").find("#nuevoCelular").val();
		var ctlInputServicio 	= $(this).closest("#nuevoFormulario").find("#nuevoServicio").val();
		var ctlInputComentario 	= $(this).closest("#nuevoFormulario").find("#nuevoComentario").val();
		var objeto 				= $(this);

		var datosAnteriores		= $("#celda"+ctlInputxcupo+ctlInputxcolumna).html();

		$("#celda"+ctlInputxcupo+ctlInputxcolumna).popover('hide');
		$("#celda"+ctlInputxcupo+ctlInputxcolumna).html('<img style="padding-top:20px;padding-left:37px" src="img/loading-primary.png" border="0" /> ');
		 
		setTimeout(function(){manejarFicha(
								'nuevaFicha',
								ctlInputxficha,
								ctlInputxfecha,
								ctlInputxcolumna,
								ctlInputxcupo,
								ctlInputNombre,
								ctlInputDocumento,
								ctlInputCelular,
								ctlInputServicio,
								ctlInputComentario,
								datosAnteriores,
								objeto
							)}, 1000); 
		});


	
	
});


$(document).ready(function() {
	
 	$("#myModal").on("shown.bs.modal", 
		function() {
			  $('#confirmarClave').focus();
	});
 	$("#myModal").on("hidden.bs.modal", 
		function() {
			  $('#nuevoNombre').focus();
	});
}); 

$('#sucursales').click( function () {
	alert(1);
	$('#sucursales').popover();
});

function confirmarIdentidad()
{
accion = 'confirmarIdentidad';
var usu = $('#sesionUsuario').val();
var cla = $('#confirmarClave').val();

  		var respuesta = $.ajax({
					url: "inc/procesos.php",
					global:true,
					type: "POST",
					data: "accion=" +accion+
							"&usuario=" +usu+
							"&contrasena=" +cla,
					contentType: "application/x-www-form-urlencoded",
					dataType: "html",
					async: true,					
					ifModified: false,
					processData:true,
					beforeSend: function(objeto){},
					complete: function(objeto, exito){  
						if(exito=="success"){ }},
						error: function(objeto, quepaso, otroobj){ },
						success: function(datos){
						///////////////////// --- Acciones con los datos obtenidos --- /////////////////////
							 var resdatos = datos.split("*tab*");
							 if(resdatos[0] == 'ok')
							 {
								$("#mimodal_msg_error").html			('');
								$("#mimodal_msg_error").removeClass	('alert alert-dismissable alert-danger');	
								$('#confirmarClave').val('');
								$('#myModal').modal('toggle');
								intentos=0;
								$('#nuevoNombre').focus();
							 }else{
								 if (intentos == 2){ window.location.href="cupo.php?fecha="+$('#mydate').val();	}
								$('#confirmarClave').focus();
								intentos++;
								$("#mimodal_msg_error").addClass	(' alert alert-dismissable alert-danger');
								$('#mimodal_msg_error').html('Incorrecto, quedan '+(3-intentos)+' intentos');
 							 }
 						},							
					}
				).responseText;
}

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

<body onLoad="desvincularFichaAbierta(); consultar();">
 
 <div class="navbar navbar-inverse" role="navigation">
      <div class="container-fluid">
        <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span> 
        </button> 
         <!-- <a class="navbar-brand" href="#">Reservas Turnos</a>-->
        </div>
        <div class="collapse navbar-collapse" id"myNavbar<!-- ">
          <ul class="nav navbar-nav">
            <!--<li class="disabled"><a href="index.php">Inicio</a></li>-->
            <li class="active"><a href="cupo.php">		Turnos disponibles</a></li>
            <li><a href="pantalla_repuesto.php">	Panel de Taller</a></li>
            <li><a href="pantalla_callcenter.php">	Panel de Call Center</a></li>
			<li><a href="reportes.php">		Reportes</a></li>
			<!-- <li><a href="turnos.php">		Pantalla</a></li> -->
            <li class="dropdown p-0">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown">Mi Perfil <b class="caret"></b></a>
                <ul class="dropdown-menu">
					<li><a href="miperfil.php">Cambiar Clave</a></li>
                </ul>
            </li> 
            <li class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown">Encuesta Cliente <b class="caret"></b></a>
                <ul class="dropdown-menu" >
					<li><a href="javascript:sincronizarReclamos();">Sincronizar Datos</a></li>
					<li><a href="reportes_encuesta.php">Reportes Encuesta</a></li>
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
			<span style="color:#FFF" id="myUsuario" user="<?php echo $_SESSION['nombre']; ?>" > <?php echo $_SESSION['nombre']." <span class='glyphicon glyphicon-user text-danger'></span> ".$_SESSION['tipo']; ?></span>&nbsp; <!-- <img src="logo/" style="width:60px;height:40px; position:relative; top:-5px; border-radius:5px"></img> -->
		</div>
  
        </div><!--/.nav-collapse -->
      </div>
</div>

<div class="container-fluid theme-showcase" role="main" >
    <!--<div class="well"> -->
        <form action="cupo.php" method="post" id="formFecha" >
            <div class="row">
                <div class="col-sm-3">
                    <input type="hidden" id="resaltarfecha" name="resaltarfecha" value="<?php echo '';//$resaltafecha; ?>"> 
                    <div class="form-group" >
                        <div class="input-group">
                            <span class="input-group-addon">Fecha</span>
                             <input 
                                type=		"text" 
                                id=			"mydate" 
                                readonly  required 
                                class=		"form-control" 
                                name=		"fechaelegida" 
                                style=		" cursor:pointer; font-size:18px ;text-align:center; height:60px;" 
                                value=		" <?php echo date("Y-m-d"); ?>"
                            />    
                        </div>
                    </div>  
                </div>
                <div class="col-sm-6" style="height:87px; position:relative; top:-34px;">
					<span class="badge bg-primary" style= "font-size: 30px; background-color:#333">CHANGAN <p id='totalChangan' >0</p> </span> 
					<!-- <span class="badge bg-primary" style= "font-size: 30px; background-color:#333">Mazda <p id='totalMazda'>0</p> </span> 
					<span class="badge bg-primary" style= "font-size: 30px; ">Mini BMW <p id='totalMini'>0</p> </span>  -->
					<span class="badge bg-primary" style= "font-size: 30px; background-color:darkolivegreen">Taller <p id='totalTaller'>0</p> </span> 
					<span class="badge bg-primary" style= "font-size: 14px; background-color:silver; position:relative; top:18px; padding:0px; width:100px;"> 
						<p style=" margin:0px; border-radius:5px; height:24px; padding-top:3px;" class="btn-danger" ><span style="float:left;">Agendado</span> <span class="badge " style="float:right;" id="agendado"></span></p> 
						<p style=" margin:0px; border-radius:5px; height:26px; padding-top:5px;" class="btn-warning" ><span style="float:left;">Confirmado</span> <span class="badge " style="float:right; position:absolute; right:-1px;" id="confirmado"></span></p> 
						<p style=" margin:0px; border-radius:5px; height:26px; padding-top:5px;" class="btn-success" ><span style="float:left;">Atendido</span> <span class="badge " style="float:right;" id="atendido"></span></p> 
						<p style=" margin:0px; border-radius:5px; height:26px; padding-top:5px;" class="btn-info" ><span style="float:left;">Llamar</span> <span class="badge " style="float:right;" id="llamar"></span></p> 
					</span> 
				</div>
                <div class="col-sm-3">
					<!-- <select id="cd-dropdown" class="cd-select"> -->
					<select id="sucursal" class="" style="min-width:350px; width:auto; height:60px; float:right; background-color:#eee; border-radius: 9px">
							<?php 
								$sql = " SELECT '<option value=@' || id_sucursal || '@>' || nombre ||'</option>' html FROM sucursales where estado = 1 ORDER BY 1 ; ";
								$exq= pg_query($con, str_replace('@', '"', $sql ) );
								while ($ref	= pg_fetch_array($exq))
								{
									echo $ref['html'];
								}
							?>
					</select>
                </div>
            </div>
            	<!-- sapo -->
				<table id="mytabla" style="width:100% ; table-layout: fixed;">
					<thead >
						<tr class="" style="background-color:#5F9EA0;" id="turnos">
						</tr>
						<tr class="text-white" style="background-color:#5F9EA0;" id="horario"> 
						</tr>
					</thead>
					<tbody id="cupos">
					</tbody>
				</table>
			</div>	
        </form>
    <!-- </div>-->
</div>
 

<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title" id="titulo"></h4>
      </div>
      <div class="modal-body" id="msj" >
      </div>
      <div class="modal-footer" id="pie">
        <button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-off"></span> Salir</button>
      </div>
    </div>
  </div>
</div>

  <!-- Modal -->
  <div class="modal" id="myModal2" role="dialog">
    <div class="modal-dialog modal-lg" style="width:90%;">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title text-center">VEHICULOS</h4>
        </div>
        <div class="modal-body">

            <div class="container-fluid">

            <div class="row text-center" style="margin-bottom: 20px;" id="#colores">
				<button type="button" onclick="set(this)" style="width:7%; height:50px; background-color:red; color:white;" class="btn ">&nbsp;Rojo</button>
				<button type="button" onclick="set(this)" style="width:7%; height:50px; background-color:brown; color:white;" class="btn">&nbsp;Bordo</button>
				<button type="button" onclick="set(this)" style="width:7%; height:50px; background-color:#804000; color:white;" class="btn">&nbsp;Marron</button>
				<button type="button" onclick="set(this)" style="width:7%; height:50px; background-color:tomato; color:white;" class="btn">&nbsp;Naranja</button>
				<button type="button" onclick="set(this)" style="width:7%; height:50px; background-color:orange;" class="btn">&nbsp;Amarillo</button>
				<button type="button" onclick="set(this)" style="width:7%; height:50px; background-color:blue; color:white;" class="btn">&nbsp;Azul</button>
				<button type="button" onclick="set(this)" style="width:7%; height:50px; background-color:skyblue;" class="btn">&nbsp;Celeste</button>
				<button type="button" onclick="set(this)" style="width:7%; height:50px; background-color:MediumSeaGreen; color:white;" class="btn">&nbsp;Verde</button>
				<button type="button" onclick="set(this)" style="width:7%; height:50px; background-color:black;color:white;" class="btn">&nbsp;Negro</button>
				<button type="button" onclick="set(this)" style="width:7%; height:50px; background-color:gray; color:white;" class="btn">&nbsp;Gris</button>
				<button type="button" onclick="set(this)" style="width:7%; height:50px; background-color:LightGray;" class="btn">&nbsp;Plata</button>
				<button type="button" onclick="set(this)" style="width:7%; height:50px; background-color:white;" class="btn">&nbsp;Blanco</button>
				<button type="button" onclick="set(this)" style="width:7%; height:50px; background-color:beige;" class="btn">&nbsp;Beige</button>
            </div>




              <div class="input-group" style="margin-bottom:10px;">
                <span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>
                <input id="buscar" type="text" class="form-control" placeholder="buscar..." onkeyup="buscarVehiculo(this)">
              </div>

              <ul class="nav nav-tabs nav-justified">
                <li class="active"><a data-toggle="tab" href="#page1">CHANGAN</a></li>
                <li><a data-toggle="tab" href="#page2">MARCA 2</a></li>
              </ul>
                <div class="tab-content" id="contenido">

                    <div id="page1" class="tab-pane fade in active">

                      <div class="row" style="margin-top:10px;">

                        <div class="col-sm-3"> 
                          <div class="list-group">
                            <a href="#" class="list-group-item active text-center">AUTO</a>
                            <a href="#" class="list-group-item" onclick="SeleccionarVehiculo(this)" ><span class="glyphicon glyphicon-share-alt" ></span>NEW ALSVIN</a>
                          </div>
                        </div>
                        <div class="col-sm-3"> 
                          <div class="list-group">
                            <a href="#" class="list-group-item active text-center text-center">SUV</a>
                            <a href="#" class="list-group-item" onclick="SeleccionarVehiculo(this)" ><span class="glyphicon glyphicon-share-alt" ></span> NEW CS55 PLUS</a>
                            <a href="#" class="list-group-item" onclick="SeleccionarVehiculo(this)" ><span class="glyphicon glyphicon-share-alt" ></span> NEW CS35 PLUS</a>
                            <a href="#" class="list-group-item" onclick="SeleccionarVehiculo(this)" ><span class="glyphicon glyphicon-share-alt" ></span> NEW CS15</a>
                          </div>
                        </div>
                        <div class="col-sm-3"> 
                          <div class="list-group">
                            <a href="#" class="list-group-item active text-center">PICKUP</a>
                            <a href="#" class="list-group-item" onclick="SeleccionarVehiculo(this)" ><span class="glyphicon glyphicon-share-alt" ></span> HUNTER</a>
                          </div>
                        </div>
                        <div class="col-sm-3"> 
                          <div class="list-group">
                            <a href="#" class="list-group-item active text-center">UNI</a>
                            <a href="#" class="list-group-item" onclick="SeleccionarVehiculo(this)" ><span class="glyphicon glyphicon-share-alt" ></span> UNI-T</a>
                            <a href="#" class="list-group-item" onclick="SeleccionarVehiculo(this)" ><span class="glyphicon glyphicon-share-alt" ></span> UNI-K</a>
                          </div>
                        </div>

                      </div> <!-- fin row --> 
                    </div> <!-- fin tap panel 1--> 

                    <div id="page2" class="tab-pane fade">
                        <div class="row" style="margin-top:10px;">

                          <div class="col-sm-4"> 
                            <div class="list-group">
                              <a href="#" class="list-group-item active text-center text-center">SUV</a>
                            </div>
                          </div>

                        </div> <!--fin row -->
                    </div> <!-- fin tab panel 2 --> 

                </div> <!-- fin tap content --> 
            </div> <!-- fin container-fluid --> 
        </div>
        <div class="modal-footer">
          <center>
		  <button type="button" style="width:10%;" class="btn btn-primary btn-lg text-center" onclick="Setvehiculo()" disabled="disabled">Ok</button>
		  <button type="button" style="width:10%;" class="btn btn-default btn-lg text-center" data-dismiss="modal" >Cancelar</button>
		</center>

        </div>
      </div>
    </div>
  </div>



<!-- Modal -->
<div id="myModal3" class="modal fade" role="dialog" >
  <div class="modal-dialog modal-lg" style="width: 90%; height: 100%; padding: 0;">
    <!-- Modal content-->
    <div class="modal-content" style="width: 100%">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title" id="titulo"></h4>
      </div>
      <div class="modal-body" id="msj" >
      	<div class="container-fluid">
		<table class="table table-bordered" style="font-size:11px;" id="tablero-servicio">
		<thead >
		<tr>
			<th colspan=24 style="text-align:center;">TABLERO DE TIEMPOS DE SERVICIO TEMA</th>
		</tr>
		<tr>
			<th colspan="1" style="text-align:center;" filtro> TODOS <span class="glyphicon glyphicon-search"></span></th>
			<th colspan="5" style="text-align:center;" filtro> AUTO <span class="glyphicon glyphicon-search"></span></th>
			<th colspan="6" style="text-align:center;" filtro> SUV <span class="glyphicon glyphicon-search"></span></th>
			<th colspan="6" style="text-align:center;" filtro> PICKUP <span class="glyphicon glyphicon-search"></span></th>
			<th colspan="6" style="text-align:center;" filtro> UTILITARIO <span class="glyphicon glyphicon-search"></span></th>
		</tr>
		<tr>    
			<th colspan=2 style="text-align:center;">VEHICULO</th>
			<th colspan=22 style="text-align:center;">KILOMETRAJE / HORA SERVICIO</th>
		</tr>
		  <tr>
		    <th>Tipo</th>
		    <th>Modelo</th>
		    <th>Check</th>
		    <!--<th>2.5K</th> -->
		    <th>5K</th>
		    <th>10K</th>
		    <th>15K</th>
		    <th>20K</th>
		    <th>25K</th>
		    <th>30K</th>
		    <th>35K</th>
		    <th>40K</th>
		    <th>45K</th>
		    <th>50K</th>
		    <th>55K</th>
		    <th>60K</th>
		    <th>65K</th>
		    <th>70K</th>
		    <th>75K</th>
		    <th>80K</th>
		    <th>85K</th>
		    <th>90K</th>
		    <th>95K</th>
		    <th>100K</th>
		  </tr>
		</thead>
		<tbody>
		  <tr style="text-align:center;"> <td rowspan=12 style="vertical-align:middle;">AUTO</td></td>
				<td modelo="ONIX" >ONIX</td> 
				<td hora="0.5"   km="0" data="diagnostico">0.5hs</td>
				<!--<td hora="1"   km="2500">1hs</td>-->
				<td hora='1' km='5000'>1hs</td>
				<td hora='1' km='10000'>1hs</td>
				<td hora='1' km='15000'>1hs</td>
				<td hora='1' km='20000'>1hs</td>
				<td hora='1' km='25000'>1hs</td>
				<td hora='2' km='30000'>2hs</td>
				<td hora='1' km='35000'>1hs</td>
				<td hora='2' km='40000'>2hs</td>
				<td hora='1' km='45000'>1hs</td>
				<td hora='2' km='50000'>2hs</td>
				<td hora='1' km='55000'>1hs</td>
				<td hora='2' km='60000'>2hs</td>
				<td hora='1' km='65000'>1hs</td>
				<td hora='2' km='70000'>2hs</td>
				<td hora='1' km='75000'>1hs</td>
				<td hora='2' km='80000'>2hs</td>
				<td hora='1' km='85000'>1hs</td>
				<td hora='2' km='90000'>2hs</td>
				<td hora='1' km='95000'>1hs</td>
				<td hora='3' km='100000'>3hs</td>


		  </tr>
		    <tr style="text-align:center;"> 
		    	<td modelo="PRISMA">PRISMA</td> <td style="display:none;">auto</td> 
				<td hora="0.5"   km="0" data="diagnostico">0.5hs</td>
				<!--<td hora="1"   km="2500">1hs</td>-->
				<td hora='1' km='5000'>1hs</td>
				<td hora='1' km='10000'>1hs</td>
				<td hora='1' km='15000'>1hs</td>
				<td hora='1' km='20000'>1hs</td>
				<td hora='1' km='25000'>1hs</td>
				<td hora='2' km='30000'>2hs</td>
				<td hora='1' km='35000'>1hs</td>
				<td hora='2' km='40000'>2hs</td>
				<td hora='1' km='45000'>1hs</td>
				<td hora='2' km='50000'>2hs</td>
				<td hora='1' km='55000'>1hs</td>
				<td hora='2' km='60000'>2hs</td>
				<td hora='1' km='65000'>1hs</td>
				<td hora='2' km='70000'>2hs</td>
				<td hora='1' km='75000'>1hs</td>
				<td hora='2' km='80000'>2hs</td>
				<td hora='1' km='85000'>1hs</td>
				<td hora='2' km='90000'>2hs</td>
				<td hora='1' km='95000'>1hs</td>
				<td hora='3' km='100000'>3hs</td>
		    </tr>
		    <tr style="text-align:center;"> 
		    	<td modelo="AVEO">AVEO</td> <td style="display:none;">auto</td> 
				<td hora="0.5"   km="0" data="diagnostico">0.5hs</td>
				<!--<td hora='1' km='2500'>1hs</td>-->
				<td hora='1' km='5000'>1hs</td>
				<td hora='1' km='10000'>1hs</td>
				<td hora='1' km='15000'>1hs</td>
				<td hora='1' km='20000'>1hs</td>
				<td hora='1' km='25000'>1hs</td>
				<td hora='1' km='30000'>1hs</td>
				<td hora='1' km='35000'>1hs</td>
				<td hora='1' km='40000'>1hs</td>
				<td hora='1' km='45000'>1hs</td>
				<td hora='2' km='50000'>2hs</td>
				<td hora='1' km='55000'>1hs</td>
				<td hora='1.5' km='60000'>1.5hs</td>
				<td hora='1' km='65000'>1hs</td>
				<td hora='1' km='70000'>1hs</td>
				<td hora='1' km='75000'>1hs</td>
				<td hora='1' km='80000'>1hs</td>
				<td hora='1' km='85000'>1hs</td>
				<td hora='1' km='90000'>1hs</td>
				<td hora='1' km='95000'>1hs</td>
				<td hora='2' km='100000'>2hs</td>
		    </tr>
		    <tr style="text-align:center;"> 
		    	<td modelo="SAIL">SAIL</td> <td style="display:none;">auto</td> 
				<td hora="0.5"   km="0" data="diagnostico">0.5hs</td>
				<!--<td hora='1' km='2500'>1hs</td>-->
				<td hora='1' km='5000'>1hs</td>
				<td hora='1' km='10000'>1hs</td>
				<td hora='1' km='15000'>1hs</td>
				<td hora='1' km='20000'>1hs</td>
				<td hora='1' km='25000'>1hs</td>
				<td hora='1' km='30000'>1hs</td>
				<td hora='1' km='35000'>1hs</td>
				<td hora='1' km='40000'>1hs</td>
				<td hora='1' km='45000'>1hs</td>
				<td hora='2' km='50000'>2hs</td>
				<td hora='1' km='55000'>1hs</td>
				<td hora='1.5' km='60000'>1.5hs</td>
				<td hora='1' km='65000'>1hs</td>
				<td hora='1' km='70000'>1hs</td>
				<td hora='1' km='75000'>1hs</td>
				<td hora='1' km='80000'>1hs</td>
				<td hora='1' km='85000'>1hs</td>
				<td hora='1' km='90000'>1hs</td>
				<td hora='1' km='95000'>1hs</td>
				<td hora='2' km='100000'>2hs</td>
		    </tr>


		    <tr style="text-align:center;"> 
		    	<td modelo="CRUZE 1.4">CRUZE 1.4</td> <td style="display:none;">auto</td>
				<td hora="0.5"   km="0" data="diagnostico">0.5hs</td>
				<!--<td hora="1"   km="2500">1hs</td>-->
				<td hora='1' km='5000'>1hs</td>
				<td hora='1' km='10000'>1hs</td>
				<td hora='1' km='15000'>1hs</td>
				<td hora='1' km='20000'>1hs</td>
				<td hora='1' km='25000'>1hs</td>
				<td hora='2' km='30000'>2hs</td>
				<td hora='1' km='35000'>1hs</td>
				<td hora='1' km='40000'>1hs</td>
				<td hora='1' km='45000'>1hs</td>
				<td hora='3' km='50000'>3hs</td>
				<td hora='1' km='55000'>1hs</td>
				<td hora='2' km='60000'>2hs</td>
				<td hora='1' km='65000'>1hs</td>
				<td hora='2' km='70000'>2hs</td>
				<td hora='1' km='75000'>1hs</td>
				<td hora='2' km='80000'>2hs</td>
				<td hora='1' km='85000'>1hs</td>
				<td hora='2' km='90000'>2hs</td>
				<td hora='1' km='95000'>1hs</td>
				<td hora='4' km='100000'>4hs</td>

		    </tr>
		    <tr style="text-align:center;"> 
		    	<td modelo="CRUZE 2.0">CRUZE 2.0</td> <td style="display:none;">auto</td>
				<td hora="0.5"   km="0" data="diagnostico">0.5hs</td>
				<!--<td hora="1"   km="2500">1hs</td>-->
				<td hora='1' km='5000'>1hs</td>
				<td hora='2' km='10000'>2hs</td>
				<td hora='1' km='15000'>1hs</td>
				<td hora='2' km='20000'>2hs</td>
				<td hora='1' km='25000'>1hs</td>
				<td hora='2' km='30000'>2hs</td>
				<td hora='1' km='35000'>1hs</td>
				<td hora='2' km='40000'>2hs</td>
				<td hora='1' km='45000'>1hs</td>
				<td hora='3' km='50000'>3hs</td>
				<td hora='1' km='55000'>1hs</td>
				<td hora='2' km='60000'>2hs</td>
				<td hora='1' km='65000'>1hs</td>
				<td hora='2' km='70000'>2hs</td>
				<td hora='1' km='75000'>1hs</td>
				<td hora='2' km='80000'>2hs</td>
				<td hora='1' km='85000'>1hs</td>
				<td hora='2' km='90000'>2hs</td>
				<td hora='1' km='95000'>1hs</td>
				<td hora='4' km='100000'>4hs</td>

		    </tr>
		    <tr style="text-align:center;"> 
		    	<td modelo="CORSA">CORSA</td> <td style="display:none;">auto</td>
				<td hora="0.5"   km="0" data="diagnostico">0.5hs</td>
				<!--<td hora="1"   km="2500">1hs</td>-->
				<td hora='1' km='5000'>1hs</td>
				<td hora='1' km='10000'>1hs</td>
				<td hora='1' km='15000'>1hs</td>
				<td hora='1' km='20000'>1hs</td>
				<td hora='1' km='25000'>1hs</td>
				<td hora='1' km='30000'>1hs</td>
				<td hora='1' km='35000'>1hs</td>
				<td hora='1' km='40000'>1hs</td>
				<td hora='1' km='45000'>1hs</td>
				<td hora='2' km='50000'>2hs</td>
				<td hora='1' km='55000'>1hs</td>
				<td hora='1.5' km='60000'>1.5hs</td>
				<td hora='1' km='65000'>1hs</td>
				<td hora='1' km='70000'>1hs</td>
				<td hora='1' km='75000'>1hs</td>
				<td hora='1' km='80000'>1hs</td>
				<td hora='1' km='85000'>1hs</td>
				<td hora='1' km='90000'>1hs</td>
				<td hora='1' km='95000'>1hs</td>
				<td hora='3' km='100000'>3hs</td>

		    </tr>
		    <tr style="text-align:center;"> 
		    	<td modelo ="SPARK">SPARK</td> <td style="display:none;">auto</td>
				<td hora="0.5"   km="0" data="diagnostico">0.5hs</td>
				<!--<td hora="1"   km="2500">1hs</td>-->
				<td hora='1' km='5000'>1hs</td>
				<td hora='1' km='10000'>1hs</td>
				<td hora='1' km='15000'>1hs</td>
				<td hora='1' km='20000'>1hs</td>
				<td hora='1' km='25000'>1hs</td>
				<td hora='1' km='30000'>1hs</td>
				<td hora='1' km='35000'>1hs</td>
				<td hora='1' km='40000'>1hs</td>
				<td hora='1' km='45000'>1hs</td>
				<td hora='2' km='50000'>2hs</td>
				<td hora='1' km='55000'>1hs</td>
				<td hora='1.5' km='60000'>1.5hs</td>
				<td hora='1' km='65000'>1hs</td>
				<td hora='1' km='70000'>1hs</td>
				<td hora='1' km='75000'>1hs</td>
				<td hora='1' km='80000'>1hs</td>
				<td hora='1' km='85000'>1hs</td>
				<td hora='1' km='90000'>1hs</td>
				<td hora='1' km='95000'>1hs</td>
				<td hora='2' km='100000'>2hs</td>

		    </tr>
		    <tr style="text-align:center;"> 
		    	<td modelo="AGIL">AGIL</td>  <td style="display:none;">auto</td>
				<td hora="0.5"   km="0" data="diagnostico">0.5hs</td>
				<!--<td hora="1"   km="2500">1hs</td>-->
				<td hora='1' km='5000'>1hs</td>
				<td hora='1' km='10000'>1hs</td>
				<td hora='1' km='15000'>1hs</td>
				<td hora='1' km='20000'>1hs</td>
				<td hora='1' km='25000'>1hs</td>
				<td hora='1' km='30000'>1hs</td>
				<td hora='1' km='35000'>1hs</td>
				<td hora='1' km='40000'>1hs</td>
				<td hora='1' km='45000'>1hs</td>
				<td hora='2' km='50000'>2hs</td>
				<td hora='1' km='55000'>1hs</td>
				<td hora='1.5' km='60000'>1.5hs</td>
				<td hora='1' km='65000'>1hs</td>
				<td hora='1' km='70000'>1hs</td>
				<td hora='1' km='75000'>1hs</td>
				<td hora='1' km='80000'>1hs</td>
				<td hora='1' km='85000'>1hs</td>
				<td hora='1' km='90000'>1hs</td>
				<td hora='1' km='95000'>1hs</td>
				<td hora='2' km='100000'>2hs</td>

		    </tr>
		  	<tr style="text-align:center;"> 
		  		<td modelo="SONIC">SONIC</td>  <td style="display:none;">suv</td>
				<td hora="0.5" km="0">0.5hs</td>
				<!--<td hora="1"   km="2500">1hs</td>-->
				<td hora='1' km='5000'>1hs</td>
				<td hora='1' km='10000'>1hs</td>
				<td hora='1' km='15000'>1hs</td>
				<td hora='1' km='20000'>1hs</td>
				<td hora='1' km='25000'>1hs</td>
				<td hora='1' km='30000'>1hs</td>
				<td hora='1' km='35000'>1hs</td>
				<td hora='1' km='40000'>1hs</td>
				<td hora='1' km='45000'>1hs</td>
				<td hora='2' km='50000'>2hs</td>
				<td hora='1' km='55000'>1hs</td>
				<td hora='2' km='60000'>2hs</td>
				<td hora='1' km='65000'>1hs</td>
				<td hora='2' km='70000'>2hs</td>
				<td hora='1' km='75000'>1hs</td>
				<td hora='2' km='80000'>2hs</td>
				<td hora='1' km='85000'>1hs</td>
				<td hora='2' km='90000'>2hs</td>
				<td hora='1' km='95000'>1hs</td>
				<td hora='3' km='100000'>3hs</td>

		  	</tr>
		    <tr style="text-align:center;"> 
		    	<td modelo="ASTRA">ASTRA</td>  <td style="display:none;">auto</td>
				<td hora="0.5"   km="0" data="diagnostico">0.5hs</td>
				<!--<td hora="1"   km="2500">1hs</td>-->
				<td hora='1' km='5000'>1hs</td>
				<td hora='1' km='10000'>1hs</td>
				<td hora='1' km='15000'>1hs</td>
				<td hora='1' km='20000'>1hs</td>
				<td hora='1' km='25000'>1hs</td>
				<td hora='1' km='30000'>1hs</td>
				<td hora='1' km='35000'>1hs</td>
				<td hora='2' km='40000'>2hs</td>
				<td hora='1' km='45000'>1hs</td>
				<td hora='2' km='50000'>2hs</td>
				<td hora='1' km='55000'>1hs</td>
				<td hora='2' km='60000'>2hs</td>
				<td hora='1' km='65000'>1hs</td>
				<td hora='2' km='70000'>2hs</td>
				<td hora='1' km='75000'>1hs</td>
				<td hora='2' km='80000'>2hs</td>
				<td hora='1' km='85000'>1hs</td>
				<td hora='2' km='90000'>2hs</td>
				<td hora='1' km='95000'>1hs</td>
				<td hora='3' km='100000'>3hs</td>

		    </tr>
		    <tr style="text-align:center;"> 
		    	<td modelo="VECTRA">VECTRA</td>  <td style="display:none;">auto</td>
				<td hora="0.5"   km="0" data="diagnostico">0.5hs</td>
				<!--<td hora="1"   km="2500">1hs</td>-->
				<td hora='1' km='5000'>1hs</td>
				<td hora='1' km='10000'>1hs</td>
				<td hora='1' km='15000'>1hs</td>
				<td hora='1' km='20000'>1hs</td>
				<td hora='1' km='25000'>1hs</td>
				<td hora='1' km='30000'>1hs</td>
				<td hora='1' km='35000'>1hs</td>
				<td hora='2' km='40000'>2hs</td>
				<td hora='1' km='45000'>1hs</td>
				<td hora='2' km='50000'>2hs</td>
				<td hora='1' km='55000'>1hs</td>
				<td hora='2' km='60000'>2hs</td>
				<td hora='1' km='65000'>1hs</td>
				<td hora='2' km='70000'>2hs</td>
				<td hora='1' km='75000'>1hs</td>
				<td hora='2' km='80000'>2hs</td>
				<td hora='1' km='85000'>1hs</td>
				<td hora='2' km='90000'>2hs</td>
				<td hora='1' km='95000'>1hs</td>
				<td hora='3' km='100000'>3hs</td>

		    </tr>
		  <tr style="text-align:center;"> <td rowspan=7 style="text-align:center; vertical-align:middle;">SUV</td> 
		  	   <td modelo="TRACKER 1.4">TRACKER 1.4</td> <td style="display:none;">suv</td>
				<td hora="0.5"   km="0" data="diagnostico">0.5hs</td>
				<!--<td hora="1"   km="2500">1hs</td>-->
				<td hora='1' km='5000'>1hs</td>
				<td hora='1' km='10000'>1hs</td>
				<td hora='1' km='15000'>1hs</td>
				<td hora='1' km='20000'>1hs</td>
				<td hora='1' km='25000'>1hs</td>
				<td hora='1' km='30000'>1hs</td>
				<td hora='1' km='35000'>1hs</td>
				<td hora='1' km='40000'>1hs</td>
				<td hora='1' km='45000'>1hs</td>
				<td hora='2' km='50000'>2hs</td>
				<td hora='1' km='55000'>1hs</td>
				<td hora='2' km='60000'>2hs</td>
				<td hora='1' km='65000'>1hs</td>
				<td hora='2' km='70000'>2hs</td>
				<td hora='1' km='75000'>1hs</td>
				<td hora='2' km='80000'>2hs</td>
				<td hora='1' km='85000'>1hs</td>
				<td hora='2' km='90000'>2hs</td>
				<td hora='1' km='95000'>1hs</td>
				<td hora='3' km='100000'>3hs</td>

		  	</tr>
		  	<tr style="text-align:center;"> 
		  		<td modelo="TRACKER 1.8">TRACKER 1.8</td>  <td style="display:none;">suv</td>
				<td hora="0.5" km="0">0.5hs</td>
				<!--<td hora="1"   km="2500">1hs</td>-->
				<td hora='1' km='5000'>1hs</td>
				<td hora='1' km='10000'>1hs</td>
				<td hora='1' km='15000'>1hs</td>
				<td hora='1' km='20000'>1hs</td>
				<td hora='1' km='25000'>1hs</td>
				<td hora='1' km='30000'>1hs</td>
				<td hora='1' km='35000'>1hs</td>
				<td hora='1' km='40000'>1hs</td>
				<td hora='1' km='45000'>1hs</td>
				<td hora='2' km='50000'>2hs</td>
				<td hora='1' km='55000'>1hs</td>
				<td hora='2' km='60000'>2hs</td>
				<td hora='1' km='65000'>1hs</td>
				<td hora='2' km='70000'>2hs</td>
				<td hora='1' km='75000'>1hs</td>
				<td hora='2' km='80000'>2hs</td>
				<td hora='1' km='85000'>1hs</td>
				<td hora='2' km='90000'>2hs</td>
				<td hora='1' km='95000'>1hs</td>
				<td hora='3' km='100000'>3hs</td>

		  	</tr>
		  	<tr style="text-align:center;"> 
		  		<td modelo="CAPTIVA DIESEL">CAPTIVA DIESEL</td> <td style="display:none;">suv</td>
				<td hora="0.5"   km="0" data="diagnostico">0.5hs</td>
				<!--<td hora="1"   km="2500">1hs</td>-->
				<td hora='1' km='5000'>1hs</td>
				<td hora='1' km='10000'>1hs</td>
				<td hora='1' km='15000'>1hs</td>
				<td hora='1' km='20000'>1hs</td>
				<td hora='1' km='25000'>1hs</td>
				<td hora='2' km='30000'>2hs</td>
				<td hora='1' km='35000'>1hs</td>
				<td hora='2' km='40000'>2hs</td>
				<td hora='1' km='45000'>1hs</td>
				<td hora='3' km='50000'>3hs</td>
				<td hora='1' km='55000'>1hs</td>
				<td hora='2' km='60000'>2hs</td>
				<td hora='1' km='65000'>1hs</td>
				<td hora='2' km='70000'>2hs</td>
				<td hora='1' km='75000'>1hs</td>
				<td hora='2' km='80000'>2hs</td>
				<td hora='1' km='85000'>1hs</td>
				<td hora='2' km='90000'>2hs</td>
				<td hora='1' km='95000'>1hs</td>
				<td hora='3' km='100000'>3hs</td>

		  	</tr>
		  	<tr style="text-align:center;"> 
		  		<td modelo="CAPTIVA SPORT">CAPTIVA SPORT</td> <td style="display:none;">suv</td>
				<td hora="0.5"   km="0" data="diagnostico">0.5hs</td>
				<!--<td hora="1"   km="2500">1hs</td>-->
				<td hora='1' km='5000'>1hs</td>
				<td hora='1' km='10000'>1hs</td>
				<td hora='1' km='15000'>1hs</td>
				<td hora='1' km='20000'>1hs</td>
				<td hora='1' km='25000'>1hs</td>
				<td hora='2' km='30000'>2hs</td>
				<td hora='1' km='35000'>1hs</td>
				<td hora='2' km='40000'>2hs</td>
				<td hora='1' km='45000'>1hs</td>
				<td hora='3' km='50000'>3hs</td>
				<td hora='1' km='55000'>1hs</td>
				<td hora='2' km='60000'>2hs</td>
				<td hora='1' km='65000'>1hs</td>
				<td hora='2' km='70000'>2hs</td>
				<td hora='1' km='75000'>1hs</td>
				<td hora='2' km='80000'>2hs</td>
				<td hora='1' km='85000'>1hs</td>
				<td hora='2' km='90000'>2hs</td>
				<td hora='1' km='95000'>1hs</td>
				<td hora='3' km='100000'>3hs</td>

		  	</tr>
		  	<tr style="text-align:center;"> 
		  		<td modelo="GRAND BLAZER">GRAND BLAZER</td>  <td style="display:none;">suv</td>
				<td hora="0.5"   km="0" data="diagnostico">0.5hs</td>
				<!--<td hora="1"   km="2500">1hs</td>-->
				<td hora='1' km='5000'>1hs</td>
				<td hora='1' km='10000'>1hs</td>
				<td hora='1' km='15000'>1hs</td>
				<td hora='1' km='20000'>1hs</td>
				<td hora='1' km='25000'>1hs</td>
				<td hora='2' km='30000'>2hs</td>
				<td hora='1' km='35000'>1hs</td>
				<td hora='2' km='40000'>2hs</td>
				<td hora='1' km='45000'>1hs</td>
				<td hora='3' km='50000'>3hs</td>
				<td hora='1' km='55000'>1hs</td>
				<td hora='2' km='60000'>2hs</td>
				<td hora='1' km='65000'>1hs</td>
				<td hora='2' km='70000'>2hs</td>
				<td hora='1' km='75000'>1hs</td>
				<td hora='2' km='80000'>2hs</td>
				<td hora='1' km='85000'>1hs</td>
				<td hora='2' km='90000'>2hs</td>
				<td hora='1' km='95000'>1hs</td>
				<td hora='3' km='100000'>3hs</td>

		  	</tr>
		  	<tr style="text-align:center;"> 
		  		<td modelo="MERIBA">MERIBA</td> <td style="display:none;">suv</td>
				<td hora="0.5"   km="0" data="diagnostico">0.5hs</td>
				<!--<td hora="1"   km="2500">1hs</td>-->
				<td hora='1' km='5000'>1hs</td>
				<td hora='1' km='10000'>1hs</td>
				<td hora='1' km='15000'>1hs</td>
				<td hora='1' km='20000'>1hs</td>
				<td hora='1' km='25000'>1hs</td>
				<td hora='2' km='30000'>2hs</td>
				<td hora='1' km='35000'>1hs</td>
				<td hora='2' km='40000'>2hs</td>
				<td hora='1' km='45000'>1hs</td>
				<td hora='2' km='50000'>2hs</td>
				<td hora='1' km='55000'>1hs</td>
				<td hora='2' km='60000'>2hs</td>
				<td hora='1' km='65000'>1hs</td>
				<td hora='2' km='70000'>2hs</td>
				<td hora='1' km='75000'>1hs</td>
				<td hora='2' km='80000'>2hs</td>
				<td hora='1' km='85000'>1hs</td>
				<td hora='2' km='90000'>2hs</td>
				<td hora='1' km='95000'>1hs</td>
				<td hora='3' km='100000'>3hs</td>

		  	</tr>
		  	<tr style="text-align:center;"> 
		  		<td modelo="ZAFIRA">ZAFIRA</td> <td style="display:none;">suv</td>
				<td hora="0.5"   km="0" data="diagnostico">0.5hs</td>
				<!--<td hora="1"   km="2500">1hs</td>-->
				<td hora='1' km='5000'>1hs</td>
				<td hora='1' km='10000'>1hs</td>
				<td hora='1' km='15000'>1hs</td>
				<td hora='1' km='20000'>1hs</td>
				<td hora='1' km='25000'>1hs</td>
				<td hora='2' km='30000'>2hs</td>
				<td hora='1' km='35000'>1hs</td>
				<td hora='2' km='40000'>2hs</td>
				<td hora='1' km='45000'>1hs</td>
				<td hora='2' km='50000'>2hs</td>
				<td hora='1' km='55000'>1hs</td>
				<td hora='2' km='60000'>2hs</td>
				<td hora='1' km='65000'>1hs</td>
				<td hora='2' km='70000'>2hs</td>
				<td hora='1' km='75000'>1hs</td>
				<td hora='2' km='80000'>2hs</td>
				<td hora='1' km='85000'>1hs</td>
				<td hora='2' km='90000'>2hs</td>
				<td hora='1' km='95000'>1hs</td>
				<td hora='3' km='100000'>3hs</td>
		  	</tr>
		  
		  <tr style="text-align:center;"> <td rowspan=3 style="text-align:center; vertical-align:middle;">PICKUP</td> 
		  		<td modelo="S10 4X2">S10 4X2</td> <td style="display:none;">pickup</td>
				<td hora="0.5"   km="0" data="diagnostico">0.5hs</td>
				<!--<td hora="1"   km="2500">1hs</td>-->
				<td hora='1' km='5000'>1hs</td>
				<td hora='2' km='10000'>2hs</td>
				<td hora='1' km='15000'>1hs</td>
				<td hora='2' km='20000'>2hs</td>
				<td hora='1' km='25000'>1hs</td>
				<td hora='2' km='30000'>2hs</td>
				<td hora='1' km='35000'>1hs</td>
				<td hora='2' km='40000'>2hs</td>
				<td hora='1' km='45000'>1hs</td>
				<td hora='3' km='50000'>3hs</td>
				<td hora='1' km='55000'>1hs</td>
				<td hora='2' km='60000'>2hs</td>
				<td hora='1' km='65000'>1hs</td>
				<td hora='2' km='70000'>2hs</td>
				<td hora='1' km='75000'>1hs</td>
				<td hora='2' km='80000'>2hs</td>
				<td hora='1' km='85000'>1hs</td>
				<td hora='2' km='90000'>2hs</td>
				<td hora='1' km='95000'>1hs</td>
				<td hora='3' km='100000'>3hs</td>

		  	</tr>
			
		  	<tr style="text-align:center;"> 
		  		<td modelo="S10 4X4">S10 4X4</td> <td style="display:none;">pickup</td>
				<td hora="0.5"   km="0" data="diagnostico">0.5hs</td>
				<!--<td hora="1"   km="2500">1hs</td>-->
				<td hora='1' km='5000'>1hs</td>
				<td hora='2' km='10000'>2hs</td>
				<td hora='1' km='15000'>1hs</td>
				<td hora='2' km='20000'>2hs</td>
				<td hora='1' km='25000'>1hs</td>
				<td hora='2' km='30000'>2hs</td>
				<td hora='1' km='35000'>1hs</td>
				<td hora='2' km='40000'>2hs</td>
				<td hora='1' km='45000'>1hs</td>
				<td hora='3' km='50000'>3hs</td>
				<td hora='1' km='55000'>1hs</td>
				<td hora='2' km='60000'>2hs</td>
				<td hora='1' km='65000'>1hs</td>
				<td hora='2' km='70000'>2hs</td>
				<td hora='1' km='75000'>1hs</td>
				<td hora='2' km='80000'>2hs</td>
				<td hora='1' km='85000'>1hs</td>
				<td hora='2' km='90000'>2hs</td>
				<td hora='1' km='95000'>1hs</td>
				<td hora='3' km='100000'>3hs</td>
		  	</tr>

		  	<tr style="text-align:center;"> 
		  		<td modelo="SILVERADO">SILVERADO</td> <td style="display:none;">pickup</td>
				<td hora="0.5"   km="0" data="diagnostico">0.5hs</td>
				<!--<td hora="1"   km="2500">1hs</td>-->
				<td hora='3' km='5000'>3hs</td>
				<td hora='3' km='10000'>3hs</td>
				<td hora='0' km='15000'>3hs</td>
				<td hora='0' km='20000'>0hs</td>
				<td hora='0' km='25000'>0hs</td>
				<td hora='0' km='30000'>0hs</td>
				<td hora='0' km='35000'>0hs</td>
				<td hora='0' km='40000'>0hs</td>
				<td hora='0' km='45000'>0hs</td>
				<td hora='0' km='50000'>0hs</td>
				<td hora='0' km='55000'>0hs</td>
				<td hora='0' km='60000'>0hs</td>
				<td hora='0' km='65000'>0hs</td>
				<td hora='0' km='70000'>0hs</td>
				<td hora='0' km='75000'>0hs</td>
				<td hora='0' km='80000'>0hs</td>
				<td hora='0' km='85000'>0hs</td>
				<td hora='0' km='90000'>0hs</td>
				<td hora='0' km='95000'>0hs</td>
				<td hora='0' km='100000'>0hs</td>
		  	</tr>



			
		  <tr style="text-align:center;"> <td rowspan=3 style="text-align:center; vertical-align:middle;">UTILITARIO</td> 
		  		<td modelo="N300 MAX">N300 MAX</td> <td style="display:none;">utilitario</td>
				<td hora="0.5"   km="0" data="diagnostico">0.5hs</td>
				<!--<td hora="1"   km="2500">1hs</td>-->
				<td hora='1' km='5000'>1hs</td>
				<td hora='1' km='10000'>1hs</td>
				<td hora='1' km='15000'>1hs</td>
				<td hora='1' km='20000'>1hs</td>
				<td hora='1' km='25000'>1hs</td>
				<td hora='2' km='30000'>2hs</td>
				<td hora='1' km='35000'>1hs</td>
				<td hora='2' km='40000'>2hs</td>
				<td hora='1' km='45000'>1hs</td>
				<td hora='2' km='50000'>2hs</td>
				<td hora='1' km='55000'>1hs</td>
				<td hora='2' km='60000'>2hs</td>
				<td hora='1' km='65000'>1hs</td>
				<td hora='2' km='70000'>2hs</td>
				<td hora='1' km='75000'>1hs</td>
				<td hora='2' km='80000'>2hs</td>
				<td hora='1' km='85000'>1hs</td>
				<td hora='2' km='90000'>2hs</td>
				<td hora='1' km='95000'>1hs</td>
				<td hora='2' km='100000'>2hs</td>

		  	</tr>
		  <tr style="text-align:center;"> 
		  	<td  modelo="N300 PICKUPS">N300 PICK-UP</td> <td style="display:none;">utilitario</td>
				<td hora="0.5"   km="0" data="diagnostico">0.5hs</td>
				<!--<td hora="1"   km="2500">1hs</td>-->
				<td hora='1' km='5000'>1hs</td>
				<td hora='1' km='10000'>1hs</td>
				<td hora='1' km='15000'>1hs</td>
				<td hora='1' km='20000'>1hs</td>
				<td hora='1' km='25000'>1hs</td>
				<td hora='2' km='30000'>2hs</td>
				<td hora='1' km='35000'>1hs</td>
				<td hora='2' km='40000'>2hs</td>
				<td hora='1' km='45000'>1hs</td>
				<td hora='2' km='50000'>2hs</td>
				<td hora='1' km='55000'>1hs</td>
				<td hora='2' km='60000'>2hs</td>
				<td hora='1' km='65000'>1hs</td>
				<td hora='2' km='70000'>2hs</td>
				<td hora='1' km='75000'>1hs</td>
				<td hora='2' km='80000'>2hs</td>
				<td hora='1' km='85000'>1hs</td>
				<td hora='2' km='90000'>2hs</td>
				<td hora='1' km='95000'>1hs</td>
				<td hora='2' km='100000'>2hs</td>

		  </tr>
		  <tr style="text-align:center;"> 
		  	<td modelo="MONTANA">MONTANA</td>  <td style="display:none;">utilitario</td>
				<td hora="0.5"   km="0" data="diagnostico">0.5hs</td>
				<!--<td hora="1"   km="2500">1hs</td>-->
				<td hora='1' km='5000'>1hs</td>
				<td hora='1' km='10000'>1hs</td>
				<td hora='1' km='15000'>1hs</td>
				<td hora='1' km='20000'>1hs</td>
				<td hora='1' km='25000'>1hs</td>
				<td hora='2' km='30000'>2hs</td>
				<td hora='1' km='35000'>1hs</td>
				<td hora='2' km='40000'>2hs</td>
				<td hora='1' km='45000'>1hs</td>
				<td hora='2' km='50000'>2hs</td>
				<td hora='1' km='55000'>1hs</td>
				<td hora='2' km='60000'>2hs</td>
				<td hora='1' km='65000'>1hs</td>
				<td hora='2' km='70000'>2hs</td>
				<td hora='1' km='75000'>1hs</td>
				<td hora='2' km='80000'>2hs</td>
				<td hora='1' km='85000'>1hs</td>
				<td hora='2' km='90000'>2hs</td>
				<td hora='1' km='95000'>1hs</td>
				<td hora='2' km='100000'>2hs</td>

		  </tr>
		</tbody>
		</table>
        <button type="button" class="btn btn-default pull-right" style="margin-left:5px ;" data-dismiss="modal" onclick="cancelartablero()"><span class="glyphicon glyphicon-off"></span> Cancelar</button>
        <button type="button" id="listo" class="btn btn-primary pull-right" data-dismiss="modal" disabled><span class="glyphicon glyphicon-ok"></span> Listo</button>

	</div>
      </div>
      <div class="modal-footer" id="pie">
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div id="myModal-2" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title" id="titulo-2"></h4>
      </div>
      <div class="modal-body" id="msj-2">
      </div>
      <div class="modal-footer" id="pie-2">
        <button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-off"></span> Salir</button>
      </div>
    </div>
  </div>
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

	function consultar(){ 
		$("#sucursal").val(getCookie("sucursal"));
		//$("#sucursal").val(getCookie());
		//para armar el tablero 
		vistaTurnos();
		vistaHorarios();
		vistaCupos();

		 $("#mytabla td[id^='celda']").each(function(){ 
			console.log("seteo celda..."); 
			var valor = $(this).html(); 	
			if ( valor.length > 0 ){ 
				$(this).html('LIBRE'); 
				$(this).removeAttr('style'); 
				$(this).css("{background-color:#eee; color:black;} :hover{background-color:#5F9EA0;}}");
			}
		 });
		 setTimeout(function(){ consultarCasillasOcupadas(); }, 500);
	}

	function bloquearHorario(){
		// if($("#sucursal").val() === '11'){
		// 	//bloquear cabeceras 
		// 	$("#horario th").each(function(){
		// 		if("08:15 09:00 10:15 11:00 11:45 12:00 14:30".includes( $(this).html() )){
		// 			$(this).css({'backgroundColor':'brown'})
		// 		}	
		// 	})
		// 	//bloquear detalles 
		// 	$("#cupos td:contains('LIBRE')").each(function(){ 
		// 		if("08:15 09:00 10:15 11:00 11:45 12:00 14:30".includes( $(this).attr('hora') )){
		// 			$(this).html('')
		// 		}	
		// 	})		
		// }
	}

	function consultar2(){
		 $("#mytabla td[id^='celda']").each(function(){
			var valor = $(this).html() ;
			if ( valor.length > 0 ){
				$(this).html('LIBRE');
				$(this).removeAttr('style');
				$(this).css("{background-color:#eee; color:black;} :hover{background-color:#5F9EA0;}}");
				//sapito
			}
		 });
		datosTablero(); 
	}

    
	function datosTablero(){
		//megasapo 
		$(function () { 
			var myfecha  = $("#mydate").val();
			var sucursal = $("#sucursal :selected").val();
			var jqxhr = $.ajax( 
								{ 
									method: "POST", 
									url: 'inc/procesos.php',
									data: {
											fecha: myfecha,
											sucu: sucursal,
											accion: 'consultar'
											},
									dataType: 'json', 
									encoding:"ISO-8859-1"
								})
							  .done(function(rs) {
								console.log(rs);
								//sapito
								let totalChangan = rs.length //rs.filter(item => !'MAZDA MINI'.includes(item.marca.toUpperCase()) ).length
								// let totalMazda = rs.filter(item => item.marca.toUpperCase().trim() === 'MAZDA' ).length 
								// let totalMini  = rs.filter(item => item.marca.toUpperCase().trim() === 'MINI').length 
								$("#totalChangan").text(totalChangan)
								// $("#totalMazda").text(totalMazda)
								// $("#totalMini").text(totalMini)
								$("#totalTaller").text(totalChangan)

								let totalAgendado = rs
									.filter(x => x.cliente.toLowerCase().includes('agendar') === false )
									.filter(x => x.estado === '1' ).length
								let totalAtendido = rs
									.filter(x => x.cliente.toLowerCase().includes('agendar') === false )
									.filter(x => x.estado === '2' ).length
								let totalConfirmado = rs
									.filter(x => x.cliente.toLowerCase().includes('agendar') === false )
									.filter(x => x.estado === '3' ).length
								let totalLlamar = rs
									.filter(x => x.cliente.toLowerCase().includes('agendar') === false )
									.filter(x => x.estado === '4' ).length

								$("#agendado").text(totalAgendado)	
								$("#atendido").text(totalAtendido)	
								$("#confirmado").text(totalConfirmado)	
								$("#llamar").text(totalLlamar)	


								let filas = [...new Set( rs.map(item => item.fila ) )];
								var valor = 0 , valorTotal = 0 ;
								filas.forEach(item => {
									valor = rs
									.filter(x => x.cliente.toLowerCase().includes('agendar') === false )
									.filter(x => x.fila === item ).length  
									valorTotal += valor 
									//valor = rs.filter(x => x.fila === item  ).length 
									if(valor >= 11 ){
										$('tr:nth-child('+item+') td.btn-primary').append(`<p style='margin-bottom:0px; margin-top:4px;'><span class='label-danger' style="font-size:18px; border-radius:10px; padding:3px;"> ${valor}/12 <span></p>`)
									}else if('9 10'.includes(valor)){
										$('tr:nth-child('+item+') td.btn-primary').append(`<p style='margin-bottom:0px; margin-top:4px;'><span class='label-warning' style="font-size:18px; border-radius:10px; padding:3px;"> ${valor}/12 <span></p>`) 
									}else{
										$('tr:nth-child('+item+') td.btn-primary').append(`<p style='margin-bottom:0px; margin-top:4px;'><span class='badge' style="font-size:18px;"> ${valor}/12 <span></p>`)
									}
								})
								$("#totalTaller").text(valorTotal)

								if (rs.length > 0 ){
									var color = 0 ;
									var clase = "";
									rs.forEach( function ( rs2 ){
										var celda = '#celda' + rs2["fila"] + rs2["col"];
										var asesor = '';
										//console.log(rs2['callcenter_nombre'] , localStorage.stellantis_user_name);

										if ( rs2["asesor"] !== ''){ 
											asesor = "<br><span class='pull-left label'data-toggle='tooltip' title='Asesor'> <span class='glyphicon glyphicon-wrench'></span> " + rs2["asesor"] +"</span><span class='pull-left label' data-toggle='tooltip' title='Asesor'><span class='glyphicon glyphicon-time'></span> "+ rs2["hora_atencion"] +"</span>";	
										}else {
											asesor = "";
										}

										if (localStorage.stellantis_user_name == rs2["callcenter_nombre"]) {
											clase = 'style="background-color:black; border-radius: 7px; padding-left:3px;"';	
										}else {
											clase = 'style="padding-left:3px;"';
										}
										let notificacion = ''
										if(rs2["whatsapp"] == 'SI'){
											notificacion = '<span class="glyphicon glyphicon-ok" data-toggle="tooltip" title="Notificado por Whatsapp"></span>'
										}
										$(celda).html( 
														"<span data-toggle='tooltip' title='Cliente'> <span class='glyphicon glyphicon-user'></span> "+ notificacion +" <br>" + rs2["cliente"] + "</span>" + 
														"<br><span class='pull-left label' data-toggle='tooltip' title='Servicio'><span class='glyphicon glyphicon-cog'></span> " + rs2["servicio"] + "</span>" +
														"<br><span class='pull-left label' data-toggle='tooltip' title='Call Center' "+ clase +"><span class='glyphicon glyphicon-earphone'></span> " + rs2["callcenter"] + "</span><span class='pull-left label' data-toggle='tooltip' title='Call Center'><span class='glyphicon glyphicon-time'></span> " + rs2["hora_call"] +"</span>" +
														asesor
													 );
										if (rs2["estado"] == '1'){
											//if (rs2["color"] == 0 ){
											if (rs2["item"] == 1 ){
												color++ ;
											}
											
											$(celda).css("background-color","#D45956");

											/*if ( color % 2 == 0 ){
												$(celda).css("background-color","#f0ad4e");
											}else{
												$(celda).css("background-color","#a55300");
											}*/

											$(celda).css("color","white");
											$(celda).removeAttr("onclick");
											$(celda).attr("onclick", "modificar(" + rs2["ficha"] +", " + rs2["fila"] + ", '" + rs2["horario"] + "', '"+ rs2["servicio"] +"')");

										} else if (rs2["estado"] == '3'){
											$(celda).css("background-color","#F0AC4C");
											$(celda).css("color","white");
											$(celda).removeAttr("onclick");
											$(celda).attr("onclick", "modificar(" + rs2["ficha"] +", " + rs2["fila"] + ", '" + rs2["horario"] + "', '" + rs2["servicio"] + "')");	

										} else {
											$(celda).css("background-color","#5cb85c");
											$(celda).css("color","white");
											$(celda).removeAttr("onclick");
											$(celda).attr("onclick", "modificar(" + rs2["ficha"] +", " + rs2["fila"] + ", '" + rs2["horario"] + "', '" + rs2["servicio"] + "')");	
											//$(celda).attr("onclick", "consultarFicha(" + rs2["ficha"] +", " + rs2["fila"] + ", '" + rs2["horario"] + "', '" + rs2["servicio"] + "')");	
										}
									});	
								}
							  })
							  .fail(function(jqxhr, textStatus, error) {
								var err = textStatus + ", " + error;
								console.log( "Request Failed: " + err );
							  });
		});		
	}
	
	
    function registro(f , c , box , hor){

		// if($("#sucursal").val() === '11'){
		// 	//nuevo pedido de bloqueo de fechas 
		// 	let fechaAgenda = $("#mydate").val() 
		// 	if(new Date( fechaAgenda ).getTime() > new Date("2024-01-28").getTime()){
		// 		if("08:15 09:00 10:15 11:00 11:45 12:00 14:30".includes(hor)){
		// 			alert('No se puede Agendar en estos horarios favor contactar con Callcenter !!!'); 
		// 			return;
		// 		}
		// 	}
		// }

		//fco si 
		if (hor == '12:00') { // no deberian poder 
			//
			alert('No se puede Agendar a las 12 por que es el horario de Almuerzo del Taller !!!!'); 
			return ;
		}

		//pedido de hernando ledezma 
		if ( box == 2 && hor == '07:30' && $("#sucursal").val() == 10 ) { // no deberian poder 
			//
			//alert('Para Mecanico Diego Alvarenga favor agendar a partir de las 08:00 !!!!'); 
			//return ;
		}
		if ( box == 3 && ( hor == '07:30' || hor == '08:00' ) && $("#sucursal").val() == 10 ) { // no deberian poder 
			//
			// alert('Para Ricardo Maldonado favor agendar a partir de las 08:30 !!!!'); 
			// return ;
		}


        $("#titulo").html(" <span class='badge'><h3 style='margin:0px;'>Box: " + box + " &nbsp; Horario: " + hor  + "</h3></span>"); 
        $("#pie").remove(); 
        $(".modal-header > button").remove(); 
		var html =  '<form id="registrar" >'+ 
						'<style> .campo{ width:100px; } .input-group{ width:100%; }  </style>'+
						'<div class="panel panel-default">'+ //well box inicio
						'<div class="panel-heading"><span style="font-size:20px;">Cliente:</span> <span class="glyphicon glyphicon-search pull-right text-primary btn" style="font-size:30px; margin:0px; padding:0px; font-weight:bold;" onclick="buscarCliente()"></span> </div>'+
						'<div class="panel-body">'+

						'<div class="form-group">'+
						'	<div class="input-group">'+
						'		<span class="input-group-addon campo">Horario: </span>'+
						'   	<input type="text" class="form-control" id="horario" placeholder="horario"><span id="help1" class="label label-danger"></span>'+
						//'		<span class="input-group-addon btn-primary" data-toggle="tooltip" title="Buscar Cliente..." onclick="buscarCliente()"><span class="glyphicon glyphicon-search" style="color:white;"></span></span>'+
						'	</div>'+
						'</div>'+

						'<div class="form-group">'+
						'	<div class="input-group">'+
						'		<span class="input-group-addon campo">Cliente: </span>'+
						'   	<input type="text" class="form-control" id="nombre" placeholder="Cliente"><span id="help1" class="label label-danger"></span>'+
						//'		<span class="input-group-addon btn-primary" data-toggle="tooltip" title="Buscar Cliente..." onclick="buscarCliente()"><span class="glyphicon glyphicon-search" style="color:white;"></span></span>'+
						'	</div>'+
						'</div>'+
						
						'<div class="form-group">'+
						'	<div class="input-group">'+	
						'		<span class="input-group-addon campo">Documento: </span>'+
						'   	<input type="text" class="form-control" id="documento" placeholder="Documento"><span id="help2" class="label label-danger"></span>'+
						'	</div>'+
						'</div>'+
						'<div class="form-group">'+
						'	<div class="input-group">'+
						'		<span class="input-group-addon campo">Celular: </span>'+
						'   	<input type="text" class="form-control" id="celular" placeholder="Celular"><span id="help3" class="label label-danger"></span>'+
						'	</div>'+
						'</div>'+
						'<div class="form-group">'+
						'	<div class="input-group">'+
						'		<span class="input-group-addon campo">Mail: </span>'+
						'   	<input type="text" class="form-control" id="mail" placeholder="mail"><span id="help5" class="label label-danger"></span>'+
						'	</div>'+
						'</div>'+
						'<div class="form-group">'+
						'	<div class="input-group">'+
						'		<span class="input-group-addon campo">Comentario: </span>'+
						'   	<textarea class="form-control" rows="5" id="comentario" placeholder="Comentario"></textarea><span id="help4" class="label label-danger"></span>'+
						'	</div>'+
						'</div>'+

						'</div>'+
						'</div>'+ //fin well box 

						'<div class="panel panel-default">'+ //well box inicio

						//'<div class="panel-heading"><span style="font-size:20px;">Vehiculo: </div>'+
						'<div class="panel-heading"><span style="font-size:20px;">Vehiculo:</span> <span class="glyphicon glyphicon-search pull-right text-primary btn" style="font-size:30px; margin:0px; padding:0px; font-weight:bold;" data-toggle="modal" data-target="#myModal2"></span> </div>'+
						'<div class="panel-body">'+

						'<div class="form-group">'+
						'	<div class="input-group">'+
						'		<span class="input-group-addon campo">Servicio:</span>'+
						'  		<select class="form-control" id="servicio">'+
						'  		</select>'+
						'	</div>'+
						'</div>'+

						'<div class="form-group">'+	
						'	<div class="input-group">'+
      					'		<span class="input-group-addon campo">Vin: </span>'+
                    	'		<input type="textbox" id="vin" class="form-control vin" value="" placeholder="Vin" >'+
                    	'	</div>'+
                    	'</div>'+

						'<div class="form-group">'+	
						'	<div class="input-group">'+
      					'		<span class="input-group-addon campo">Vehiculo: </span>'+
                    	'		<input type="textbox" id="vehiculo" class="form-control vehiculo" value="" placeholder="Vehiculo" >'+ 

						// '<div class="input-group-btn">'+
        				// 	'<button class="btn btn-default" type="button" onclick="buscarVehiculo()" data-toggle="modal" data-target="#myModal2"><i class="glyphicon glyphicon-search"></i></button>'+
      					// '</div>'+

                    	'	</div>'+
                    	'</div>'+
						'<div class="form-group">'+	
						'	<div class="input-group">'+
      					'		<span class="input-group-addon campo">kilometraje: </span>'+
                    	'		<input type="textbox" id="kilometraje" class="form-control " value="" placeholder="kilometraje Servicio" >'+ 
						'	</div>'+
						'</div>'+
						'<div class="form-group">'+	 
						'	<div class="input-group">'+
      					'		<span class="input-group-addon campo">Marca: </span>'+
                    	'		<input type="textbox" id="marca" class="form-control " value="" placeholder="Marca..." >'+ 
						'	</div>'+
						'</div>'+
						'<div class="form-group">'+	 
						'	<div class="input-group">'+
      					'		<span class="input-group-addon campo">Modelo: </span>'+
                    	'		<input type="textbox" id="modelo" class="form-control " value="" placeholder="Modelo..." >'+ 
						'	</div>'+
						'</div>'+
						'<div class="form-group">'+	 
						'	<div class="input-group">'+
      					'		<span class="input-group-addon campo">Color: </span>'+
                    	'		<input type="textbox" id="color" class="form-control " value="" placeholder="Color..." >'+ 
						'	</div>'+
						'</div>'+
						'<div class="form-group" >'+
						'	<div class="input-group">'+
						'		<span class="input-group-addon campo">Contacto Preferido:</span>'+
						'  		<select class="form-control" id="contacto_preferido">'+
						'  		<option value="llamada">Llamada</option>'+
						'  		<option value="correo">Correo Electronico</option>'+
						'  		<option value="whatsapp">Whatsapp</option>'+
						'  		<option value="sms">SMS</option>'+
						'  		</select>'+
						'	</div>'+
						'</div>'+
						'<div class="form-group">'+	
						'	<div class="input-group">'+
      					'		<span class="input-group-addon campo">Tiempo: </span>'+
                    	'		<input type="textbox" id="tiempo" class="form-control tiempo" value="1" placeholder="Tiempo Servicio" >'+ 
						'	</div>'+
						'</div>'+
						'<div class="checkbox">'+
      					'	<label style="font-size:15px;"><input type="checkbox" name="reingreso" id="reingreso" value="S"> Re-Ingreso</label>'+
    					'</div>'+
						'<div class="form-group"  style="display:none;">'+
						'	<div class="input-group">'+
						'		<span class="input-group-addon campo">Categoria:</span>'+
						'  		<select class="form-control" id="categoria">'+
						'  		<option value="1">Sin Categoria</option>'+
						'  		<option value="2">Prospeccion</option>'+
						'  		<option value="3">Silencioso</option>'+
						'  		<option value="4">Proactivo</option>'+
						'  		</select>'+
						'	</div>'+
						'</div>'+
						' <span id="help4" class="label label-danger"></span><br>'+

						'</div>'+
						'</div>'+
						'<div class="form-group" style="text-align:right;">'+
						'   <button id="boton_ins2" type="button" class="btn btn-primary pull-left" onClick="reagendar(' + f +','+ box +',@'+ hor +'@)" data-toggle="collapse" data-target="#contenedorbuscador" style="margin-right:3px;">Re-Agendar <span class="glyphicon glyphicon-resize-vertical"></button>'+
						'   <button id="boton_ins3" type="button" class="btn btn-primary pull-left" >Historial <span class="glyphicon glyphicon-resize-vertical"></button>'+
						'   <button id="boton_ins1" type="button" class="btn btn-primary" onClick="controlform(' + f + ',' + c + ', @' + hor + '@, ' + box +', -1'+ ')"><span class="glyphicon glyphicon-ok"></span> Aceptar</button>'+
						'   <button type="button" class="btn btn-default" onclick="desvincularFichaAbierta(); cancelarRegistro('+ f +');" data-dismiss="modal"><span class="glyphicon glyphicon-off"></span> Cancelar</button>'+
						'</div>'+
						'<div id="contenedorbuscador">'+
						'	<div class="form-group"><div class="input-group" id="buscador"> </div></div>'+
						'		<div class="table-responsive">'+  					//style="max-height:500px; overflow-y:scroll;">'+ //fco para hacer scroll la tabla 
						'			<table class="table table-hover" id="reagendar" >'+
						'				<thead></thead>'+
						'				<tbody ></tbody>'+
						'			</table>'+
						'		</div>'+
						'</div>'+
						'<div id="contenedorhistorial">'+
						'	<div class="form-group"><div class="input-group" id="buscador2"> </div></div>'+
						'		<div class="table-responsive">'+
						'			<table class="table table-hover" id="historial">'+
						'				<thead style="text-align:center;"></thead>'+
						'				<tbody></tbody>'+
						'			</table>'+
						'		</div>'+
						'</div>'+
					'</form>' ;
		html = html.replace(/@/g, "'"); //fco reemplazar todos los @ por ' cuando es string para pasar argumentos en funciones 

		//control si ya se abrio el registro... 
    	var Usuario  = <?php echo "'" . $_SESSION['usuario'] . "'" ?> ; 
		var fecha    = $("#mydate").val(); fecha = fecha.trim(); 
		
		var fecha2   = fecha;
		var jqxhr1   = $.ajax({ method: "POST", url: 'inc/procesos.php', data: { accion: "estadoCasilla", columna: c , fila: f , usuario : Usuario, fecha: fecha }, dataType: 'json' }); 
		jqxhr1.done(function(rs) { //recuperar datos de turnos 

			console.log(rs[0]); 
			if(rs[0]['existe'] > 0 ){
				console.log('entro en la linea 2427..............................')
				alert('El registro ya esta abierto por otro operador '+ Usuario +'!!! ');
				console.log('usuario socket ..... '  + window.socketUsuario );
				$("td:contains('LIBRE')[id*='celda" + f + c + "']").css("background-color","#777"); //sino color normal #eee (libre)

			}else {
				socket.emit( 'message', { usuario: Usuario, fila: f, evento: 'registrar', fecha: fecha2 } );

				//$("td:contains('LIBRE')[id*='celda" + f + "']").css("background-color", "#eee"); //
				reservar(f, c, <?php echo "'" . $_SESSION["usuario"] . "'" ?> ); //para manejar concurrencia 
		        $("#msj").html(html);
		        $("#myModal").modal({backdrop: "static"});
				$("#myModal").css('width', '100%')

				var url = 'http://172.16.16.85/servicios'
				$('#boton_ins3').bind('click', function() { window.open(url, '_blank'); });
				//fco recuperar datos de turnos para asignar a horarios 
				var jqxhr1 = $.ajax( { method: "POST", url: 'inc/procesos.php', data: { accion: "configServicios" }, dataType: 'json', encoding:"ISO-8859-1"});
				jqxhr1.done(function(rs) { //recuperar datos de turnos 
					console.log(rs);
					var html = "";
					rs.forEach( function ( rs2 ){
						if ( rs2["estado"] == 1 ){
							html = html + '<option value="'+ rs2["nombre"] +'">'+ rs2["nombre"] +'</option> ';
							$("#servicio").empty();
							$("#servicio").html(html);
						}
					});
				});
			}
		}); 

    }

    function consultarCasillasOcupadas(){
		var fecha    = $("#mydate").val(); fecha = fecha.trim(); 
		var jqxhr1 = $.ajax({ method: "POST", url: 'inc/procesos.php', data: { accion: "estadoCasilla2", fecha: fecha }, dataType: 'json' }); 
		jqxhr1.done(function(rs) { //recuperar datos de turnos 
			if(rs.length > 0 ){
				rs.forEach( function ( rs2 ){
					$("td:contains('LIBRE')[id*='celda" + rs2["fila"]+ rs2["columna"] + "']").css("background-color","#777"); //sino color normal #eee (libre)
					//socket.emit( 'message', { usuario: rs2["usuario"], fila: rs2["fila"], evento: 'registrar' } );
				});
			}else {
				//consultar();
				console.log('cancelar todo....');
				//socket.emit( 'message', { usuario: "", fila: "", evento: 'cancelarTodo' } );
			}
		}); 
    }

    function cancelarRegistro(f){
    	var Usuario  = <?php echo "'" . $_SESSION['usuario'] . "'" ?> ; 
    	socket.emit( 'message', { usuario: Usuario, fila: f, evento: 'cancelarRegistro' } );
    }

    //controla si esta alguien modificando... 
    var socketUsuario; 
    var socketFila;
    var socketFecha;
	socket.on( 'message', function( data ) {
		console.log('Evento ejecutado : ' + data.evento );
		console.log('Usuario : ' + data.usuario + ' - <?php echo $_SESSION['usuario']; ?>');	
		console.log('Fila : ' + data.fila);	
		console.log('fecha: ' + data.fecha );
		//variables globales.. 
		window.socketUsuario= data.usuario;
		window.socketFila = data.fila;
		window.socketFecha = data.fecha;

		var usuario = <?php echo "'" . $_SESSION['usuario'] . "'" ?> ;
		var fechaLocal = $("#mydate").val(); fechaLocal = fechaLocal.trim(); 
		if(data.evento == 'registrar'){
			if ( usuario != data.usuario && fechaLocal == data.fecha ){
				console.log('entro en la linea 2500 ...')
				toastr.info(' <span style="font-size:20px; font-weight:bold; text-align:center;">Usuario: '+ data.usuario +' <br> Box :'+ data.fila +' registrando !!! </span>');
				$("td:contains('LIBRE')[id*='celda" + data.fila + "']").css("background-color","#777"); //sino color normal #eee (
			}
		}else if(data.evento == 'cancelarRegistro' ){
			if ( usuario != data.usuario ){
				$("td:contains('LIBRE')[id*='celda" + data.fila + "']").css("background-color","#eee"); //sino color normal #eee
			}
		}else if(data.evento == 'cancelarTodo' ){
			//if ( usuario != data.usuario ){
				//$("td:contains('LIBRE')[id*='celda']").css("background-color"," #eee"); //sino color normal #eee 
			datosTablero();	
		}else if(data.evento == 'Registrado'){
			if ( usuario != data.usuario ){
				toastr.success(' <span style="font-size:20px; font-weight:bold; text-align:center;">Usuario: '+ data.usuario +' <br> Box :'+ data.fila +' Registro realizado !!! </span>');
				$("td:contains('LIBRE')[id*='celda" + data.fila + "']").css("background-color","#eee"); //sino color normal #eee 
				datosTablero();
			}

		}else if (data.evento == 'eliminarRegistro' ){
				toastr.success(' <span style="font-size:20px; font-weight:bold; text-align:center;">Usuario: '+ data.usuario +' <br> Box :'+ data.fila +' Registro Eliminado !!! </span>');
				consultar();
		}else if(data.evento == 'inicio'){
			toastr.success(' <span style="font-size:20px; font-weight:bold; text-align:center;">Usuario: '+ data.usuario +'  en linea !!! </span>');
		}
	});

    function TableroServicio() {
		$("#myModal3").modal({backdrop: "static"}); 
    }

	$('td').click(function () { 
		$('#tablero-servicio tr td').each(function() {
			if ( $("[data=diagnostico].clicked").length > 1 ){ 
				$("[data=diagnostico].clicked").css('background-color', '');
				$("[data=diagnostico].clicked").removeClass('clicked');
			} 

			if ( $(this).attr('data') != 'diagnostico' ){
			    $(this).css('background-color', '');
			    $(this).removeClass('clicked');
			}
		 })	

		if ($(this).attr("hora") === undefined ){
			$('#listo').attr('disabled', 'disabled');
			console.log('seleccion fuera de rango..');	
		} else {
			console.log($(this).hasClass('clicked'));
			if ($(this).hasClass('clicked') ) {

				$(this).removeClass('clicked');
				$(this).css('background-color', '');
				$("#vehiculo").val('');	
				$("#kilometraje").val('');
				$("#tiempo").val( '1');
				$('#listo').attr('disabled', 'disabled');

			}else {
				if ($(this).attr("km") == 0 ){
					$("#servicio").val("Diagnostico").change();
				}else {
					$("#servicio").val("Mantenimiento").change();
				}
				$(this).addClass('clicked');
				$(this).css('background-color', '#EAD575');
				$("#vehiculo").val($(this).parent().children('[modelo]').attr('modelo'));
				$("#kilometraje").val( $(this).attr("km"));
				$("#tiempo").val( $(this).attr("hora"));
				$('#listo').removeAttr('disabled');

			}
		}
	});

	$('th').click(function(){ 
		$('#tablero-servicio tr th').each(function() {
		    $(this).css('background-color', '');
		 })	
		if ( $(this).is('[filtro]') ){
			oheka('tablero-servicio', '')
			$(this).css('background-color','silver');
			if ( $(this).text().trim() == 'TODOS'){
				oheka('tablero-servicio', '')
			}else {
				oheka('tablero-servicio', $(this).text().trim())
			}
		}else {
			//oheka('tablero-servicio', '')
		}
	});

	$("#servicio").change(function(){
		console.log('servicio.....');
	});

	function cancelartablero(){
		$("#kilometraje").val('');
		$("#tiempo").val('');
		$("#vehiculo").val('');
		$('#tablero-servicio tr td').each(function() {
		    $(this).css('background-color', '');
		    $(this).removeClass('clicked');
		 })	
	}

	function buscarCliente(){
		var html = 
				`
					<div class="row " style="margin-left:5px;">
						<div class="radio-inline"> <label><input type="radio" name="baseRadio" value="base1" checked>Base 1</label> </div>		
					</div>
					<div class="row input-lg"><input type="text" id="BuscarCliente"  placeholder="Nombre ... Cedula.. Chassis ... Chapa... " style="width:100%;" onkeypress="javascript:  if(event.keyCode == 13) MostrarCliente();"></div>
					<div class="box">
						<p id="buscando" style="text-align:center; font-weight:bold; display:none;">Buscando ...</p>
						<div class="panel panel-default" id="Resultado" style="font-size:12px; text-align:left;">
						</div>
					</div>
				`;
		var head = ` <div class="col-9">Buscar cliente</div> `;
        $("#titulo-2").html(head );
        $("#msj-2").html(html);
		$('#myModal-2').modal({show: true });

	}
	function MostrarCliente(){ //fco esta funcion esta relacionada a consultar clientes cuando se crea una nueva orden 
		//fco ajax consultar datos!!!
		$("#buscando").css("display", "block")
		$('#Resultado > *').remove()
		result = $('#BuscarCliente').val();
		base   = $('input[name=baseRadio]:checked').val()
		console.log('datos de la busqueda ' , result )
		if (result == ''){
			$('#Resultado > *').remove();
		}else {	
			$.ajax({ method: "POST", url: "inc/procesos.php", data: {CodigoCliente : result , accion: 'ConsultarCliente' , base: base }, dataType: 'json'})
			//fco exito en la consulta 
			.done(function(rs) {
				$("#buscando").css("display", "none")
				//console.log( rs );//fco para ver en la consola de la web 
				console.log('datos de busqueda antes... ', rs)
				if(rs){
					console.log('datos de busqueda... ', rs)
					//fco consulta automatizada se debe poner el mismo nombre del form como los campos del sql para que funcione auto 
					var id = 0 , campo; //fco esta linea obtiene el nombre de los campos 
					var html = "";
					$('#Resultado > *').remove(); //fco vacia el body de la tabla 
					rs.forEach( function ( rs2 ){ //fco recorre la lista de resultados por cada  objeto[](campos[])
						var callid = Object.keys(rs2); //fco captura los nombres de los campos 
						Object.keys(rs2).forEach(function(key) {  //fco recorre los campos con sus valores 
							if(key === 'html'){
								campo = "#" + callid[id] , id++; //fco esta linea es para asignar automaticamente con el campo del form -> $(#campo).val(rs2[key]) //este apartado asigna al form 
								html = rs2[key];
								html = html.replace(/@/g, "'");
								html = html.replace(/%/g, '"');
								$('#Resultado').append(html);
							}
						}); //fco este forEach trae los datos de cada campo de la consulta php ver archivo consulta.php 
						id = 0;
					});
					if ( $('#BuscarCliente').val().length == 0 ){$('#Resultado > *').remove(); } //fco para prevenir que no quede nada colgado
					//console.log($('#BuscarCliente').val().length);
				}	
				else{ //fco no existen registros !!!
					console.log('hubo un problema para los datos.. ')
					$('#Resultado > *').remove();
				}
			})
			//fco Error en la consulta 
			.fail(function(jqxhr, textStatus, error) {
				$("#buscando").css("display", "none")
				var err = textStatus + ", " + error;
				alert('hubo un error ' + err)
				console.log( "Error Ajax: " + err );//fco para ver en la consola de la web 
			});
		}
	}	
	
	function AsignarCliente(documento , cliente , celular , chassis, vehiculo , color, marca , modelo , mail){
		
		$("#boton_ins3").removeAttr('disabled');
		$("#nombre").val(cliente);
		$("#documento").val(documento);
		$("#celular").val(celular);
		$("#vehiculo").val(vehiculo);
		$("#vin").val(chassis);
		$("#color").val(color);
		$("#marca").val(marca);
		$("#modelo").val(modelo);
		$("#mail").val(mail);

		alert('Registro Asignado !!!');
		$('#myModal-2').modal('hide');
		alert(chassis)
		var jqxhr1 = $.ajax( { method: "POST", url: 'inc/procesos.php', data: { accion: "historial", chassis: chassis  }, dataType: 'json', encoding:"ISO-8859-1"});
		jqxhr1.done(function(rs) { //recuperar datos de turnos  
			console.log(rs);
			var cabecera = "";
			var html = "";
			var buscador = '<span class="input-group-addon">Buscar:</span> <input type="text" onchange="oheka( @historial@ ,this.value);" name="buscar" class="form-control" id="buscar" placeholder="Historial... "> ';
			$("#historial > thead").empty();
			$("#historial > tbody").empty();
			titulo   = '<tr><th colspan="5" style="text-align:center;" class="btn-default">HISTORIAL</th></tr>';
			cabecera =  '<th class="btn-default">FECHA</th><th class="btn-default">ORDEN</th><th style="text-align:center;" class="btn-default">SERVICIO</th><th class="btn-default">KILOMETRAJE</th><th style="text-align:center;" class="btn-default">TRABAJO</th>';
			rs.forEach( function ( rs3 ){
				html = html + '<tr style="font-size:12px; text-align:justify;"><td>'+ rs3["fecha"] +'</td><td>'+ rs3["orden"] +'</td><td style="font-weight:bold;">'+ rs3["servicio"] +'</td><td>' + rs3["kmEntrada"] + '</td><td>'+ rs3["trabajo"] +'</td></tr>';
			});
			buscador = buscador.replace(/@/g, "'"); //fco reemplazar todos los @ por ' cuando es string para pasar argumentos en funciones 
			$("#buscador2").html(buscador);
			$("#historial > thead").html( titulo + cabecera);
			$("#historial > tbody").html(html);
		});
	}


	function confirmar(ficha){

		alert(ficha)
		
		var jqxhr = $.ajax( 
							{ 
								method: "POST", 
								url: 'inc/procesos.php',
								data: {
										ficha: ficha,
                                        accion: 'confirmar'
										},
								dataType: 'text', 
								encoding:"ISO-8859-1"
							})
						.done(function(rs) {
							alert(rs)
							consultar()

						})
						  .fail(function(jqxhr, textStatus, error) {
							var err = textStatus + ", " + error;
							alert("Request Failed: " + err);
							console.log( "Request Failed: " + err );
						});
						
	}


	function modificar(ficha , box , hor , servicio ){
		
		var jqxhr = $.ajax( 
							{ 
								method: "POST", 
								url: 'inc/procesos.php',
								data: {
										ficha: ficha,
                                        accion: 'modificar'
										},
								dataType: 'json', 
								encoding:"ISO-8859-1"
							})
						  .done(function(rs) {
							console.log( "consulta ok" );
							console.log(rs);
							rs.forEach( async function ( rs2 ){
								$("#titulo").html("Box: " + box + " | Horario: " + rs2["rango_horario"] );
								$("#pie").remove();
								$(".modal-header > button").remove();
								var isReingreso = '' 
								console.log('si tiene reingreso' , rs2['reingreso'])
								if(rs2['reingreso'] === 'S'){
									isReingreso = 'checked'
								}
								var html =  '<form id="modificar" >'+
											'<style> .campo{ width:100px; } .input-group{ width:100%; }  </style>'+
											'<div class="form-group">'+ 
												'	<div class="input-group">'+
												'		<span class="input-group-addon campo">Cliente: </span>'+
												'    <input type="text" name="nombre" class="form-control" id="nombre" placeholder="Nombre" value= "' +rs2["cliente"]+ '"><span id="help1" class="label label-danger"></span>'+
												'</div>'+
												'</div>'+
												'<div class="form-group">'+
												'	<div class="input-group">'+
												'		<span class="input-group-addon campo">Documento: </span>'+
												'   <input type="text" name="documento" class="form-control" id="documento" placeholder="Documento" value= "' +rs2["documento"]+ '"><span id="help2" class="label label-danger"></span>'+
												'</div>'+
												'</div>'+
												'<div class="form-group">'+
												'	<div class="input-group">'+
												'		<span class="input-group-addon campo">Celular: </span>'+
												'   <input type="text" name="celular" class="form-control" id="celular" placeholder="Celular" value= "' +rs2["celular"]+ '"><span id="help3" class="label label-danger"></span>'+
												'</div>'+
												'</div>'+
												'<div class="form-group">'+
												'	<div class="input-group">'+
												'		<span class="input-group-addon campo">Correo: </span>'+
												'   <input type="text" name="correo" class="form-control" id="correo" placeholder="correo" ><span id="help3" class="label label-danger"></span>'+
												'</div>'+
												'</div>'+


												'<div class="form-group">'+
												'	<div class="input-group">'+
												'		<span class="input-group-addon campo">Comentario: </span>'+
												'   <textarea name="comentario" class="form-control" rows="5" id="comentario" placeholder="Comentario">' +rs2["comentario"]+ '</textarea><span id="help4" class="label label-danger"></span>'+
												'</div>'+
												'</div>'+
												'<div class="form-group">'+
												'	<div class="input-group">'+
												'		<span class="input-group-addon">Servicio:</span>'+
												'  		<select class="form-control" id="servicio" name="servicio" onChange="servicio(this)">'+
												'  		</select>'+
												'	</div>'+
												'</div>'+
												'<div class="form-group">'+
												'	<div class="input-group">'+
												'		<span class="input-group-addon campo">Vin: </span>'+
												'   <input type="text" name="vin" class="form-control" id="vin" placeholder="vin" value= "' +rs2["vin"]+ '"><span id="help2" class="label label-danger"></span>'+
												'</div>'+
												'</div>'+
												'<div class="form-group">'+
												'	<div class="input-group">'+
												'		<span class="input-group-addon campo">Vehiculo: </span>'+
												'   <input type="text" name="vehiculo" class="form-control" id="vehiculo" placeholder="Vehiculo" value= "' +rs2["vehiculo"]+ '"><span id="help2" class="label label-danger"></span>'+
												'</div>'+
												'</div>'+
												'<div class="form-group">'+
												'	<div class="input-group">'+
												'		<span class="input-group-addon campo">kilometraje: </span>'+
												'   <input type="text" name="kilometraje" class="form-control" id="kilometraje" placeholder="kilometraje" value= "' +rs2["kilometraje"]+ '"><span id="help2" class="label label-danger"></span>'+
												'</div>'+
												'</div>'+

												'<div class="form-group">'+
												'	<div class="input-group">'+
												'		<span class="input-group-addon campo">Marca: </span>'+
												'   <input type="text" name="marca" class="form-control" id="marca" placeholder="kilometraje" value= "' +rs2["marca"]+ '" readonly><span id="help2" class="label label-danger"></span>'+
												'</div>'+
												'</div>'+

												'<div class="form-group">'+
												'	<div class="input-group">'+
												'		<span class="input-group-addon campo">Modelo: </span>'+
												'   <input type="text" name="modelo" class="form-control" id="modelo" placeholder="kilometraje" value= "' +rs2["modelo"]+ '" readonly><span id="help2" class="label label-danger"></span>'+
												'</div>'+
												'</div>'+

												'<div class="form-group">'+
												'	<div class="input-group">'+
												'		<span class="input-group-addon campo">color: </span>'+
												'   <input type="text" name="color" class="form-control" id="color" placeholder="kilometraje" value= "' +rs2["color"]+ '" readonly><span id="help2" class="label label-danger"></span>'+
												'</div>'+
												'</div>'+

												'<div class="form-group">'+
												'	<div class="input-group">'+
												'		<span class="input-group-addon campo">Tiempo: </span>'+
												'   <input type="text" name="tiempo" class="form-control" id="tiempo" placeholder="tiempo" value= "' +rs2["tiempo"]+ '" readonly><span id="help2" class="label label-danger"></span>'+
												'</div>'+

												'<div class="form-group">'+
												'	<div class="input-group" style="margin-top:15px;">'+
												'		<span class="input-group-addon campo">Contacto Preferido: </span>'+
												'   <input type="text" name="tiempo" class="form-control" id="contacto_preferido" placeholder="tiempo" value= "' +rs2["contacto_preferido"]+ '" readonly><span id="help2" class="label label-danger"></span>'+
												'</div>'+												
												
												'<div class="checkbox">'+
												'	<label style="font-size:15px;"><input type="checkbox" name="reingreso" id="reingreso" value= "' +rs2["reingreso"]+ '" '+ isReingreso +' > Re-Ingreso</label>'+
												'</div>'+

												'</div>'+

												'<div class="form-group" style="text-align:right;">'+
												'   <button id="boton_con" type="button" class="btn btn-default btn-user" onClick="confirmacion('+ ficha +')"><span class="glyphicon glyphicon-refresh"></span> Recordatorio</button>'+
												'   <button id="boton_con" type="button" class="btn btn-warning btn-user" onClick="confirmar('+ ficha +')"><span class="glyphicon glyphicon-refresh"></span> Confirmar</button>'+
												'   <button id="boton_upd" type="button" class="btn btn-info " onClick="modificarficha2(' + ficha +','+ box +',@'+ hor +'@)"><span class="glyphicon glyphicon-refresh"></span> Modificar</button>'+
												'   <button id="boton_ins" type="button" class="btn btn-success btn-user" onClick="atenderficha(' + ficha +','+ box +',@'+ hor +'@)"><span class="glyphicon glyphicon-ok"></span> Atender</button>'+
												'   <button id="boton_del" type="button" class="btn btn-danger btn-user" onClick="eliminarficha(' + ficha +','+ box +',@'+ hor +'@)"><span class="glyphicon glyphicon-trash"></span> Eliminar</button><span>&nbsp;&nbsp;&nbsp;</span> '+
												'   <button type="button" class="btn btn-default" onclick="desvincularFichaAbierta()" data-dismiss="modal"><span class="glyphicon glyphicon-off"></span> Cancelar</button>'+
												'</div>'+
											'</form>' ;
								html = html.replace(/@/g, "'"); //fco reemplazar todos los @ por ' cuando es string para pasar argumentos en funciones 
								$("#msj").html(html);
								$("#myModal").modal({backdrop: "static"});

								let datosCorreo = await fetch(`http://192.168.10.54:3010/datos-cliente/${rs2["documento"]}`)
								.then(result => result.json())
								.then(x=> $("#correo").val(x[0]['E_Mail']))
								let usuario =$("#myUsuario").text() 


								if(rs2["estado"] == '2'){
									$(".btn-user").css('visibility', 'hidden');
								}

								if(rs2["estado"] == '3'){
									//$("#boton_del").css('display', 'none');
									//supersapo
									if(usuario.toLowerCase().includes('admin') ){
										$("#boton_upd").css('display', 'initial')
									}else{
										$("#boton_upd").css('display', 'none');
									}
								}
									if(usuario.toLowerCase().includes('admin') ){
										$("#boton_upd").css('display', 'initial')
									}else{
										$("#boton_upd").css('display', 'none');
									}
								//fco recuperar datos de turnos para asignar a horarios 
								var jqxhr1 = $.ajax( { method: "POST", url: 'inc/procesos.php', data: { accion: "configServicios" }, dataType: 'json', encoding:"ISO-8859-1"});
								jqxhr1.done(function(rs) { //recuperar datos de turnos 
									console.log(rs);
									var html = "";
									rs.forEach( function ( rs3 ){
										if ( rs3["estado"] == 1 ){
											html = html + '<option value="'+ rs3["nombre"] +'">'+ rs3["nombre"] +'</option> ';
											$("#servicio").empty();
											$("#servicio").html(html);
										}
									});
									$('#servicio').val(servicio).prop('selected', true);
									$("#servicio option[value="+ servicio +"]").attr("selected", true);
								});
							});
						  })
						  .fail(function(jqxhr, textStatus, error) {
							var err = textStatus + ", " + error;
							alert("Request Failed: " + err);
							console.log( "Request Failed: " + err );
						  });
    }

	const enviarRecordatorio = async(data) =>{
		// datos = {fecha , hora , telefono , cedula}
		//verificamos si el numero tiene whatsapp 
		await fetch(`http://172.16.16.85:5010/agenda`,{
			method: 'POST',
			headers:{'Content-Type': 'application/json' },
			body: JSON.stringify(data)
		})	
		//.then(response => response.json())  // convertir a json
		.then(json => {
			alert('se envio la notificacion de whatsapp al Cliente!')
			console.log('se envio el recordatorio ')
		})    //imprimir los datos en la consola
		.catch(err => console.log('Solicitud fallida', err));
	}
	
	//let isChecked =  0 
	async function controlform (f , c , horario, box , reagendar ) {
	  if ( $.trim( $( "#nombre").val()) === "" ) {
			$( "#help1" ).text( "Ingrese un nombre cliente..." ).show().fadeOut( 5000 ); return;
	  } else if ($.trim( $( "#documento").val()) === ""){
			$( "#help2" ).text( "Ingrese un Nro Documento..." ).show().fadeOut( 5000 ); return;
	  } else if ($.trim( $( "#celular").val()) === ""){
			$( "#help3" ).text( "Ingrese un Nro Celular..." ).show().fadeOut( 5000 ); return;
	  } else if ($.trim( $( "#comentario").val()) === ""){
			$( "#help4" ).text( "Ingrese un comentario..." ).show().fadeOut( 5000 ); return;
	  } else if ($.trim( $( "#kilometraje").val()) === ""){
			$( "#help4" ).text( "Ingrese kilometraje..." ).show().fadeOut( 5000 ); return;
	  }	else {

		////////////////////////////////////////////// 
		//verificamos si el numero tiene whatsapp 
		////////////////////////////////////////////// 
		try {
			var reg = new RegExp('^[0-9]+$');			
			let nro = $("#celular").val().slice(-9).trim()
			localStorage.setItem("isChecked", "0")
			if(!reg.test(nro)){
				if(confirm('Nro Celular NO valido !!\n\nDesea corregir los datos para la notificacion de Whatsapp ??')){
					$("#celular").focus()
					return 
				}

			}else{
				let response = await fetch(`http://172.16.16.85:5010/verificar?numero=${nro}`)
				response = await response.json();
				console.log(response)
				//controlar si valido o no 
				if( response.message === 'si'){
					//alert('numero valido whatsapp!!')
					localStorage.setItem("isChecked", "1")
				}else{
					alert('Este Nro no tiene whatsapp!!')
				}

			}
			
		} catch (error) {

			console.log(error)
		}
		/////////////////////////////////////////////

		//insertar registro
		var nombre   = $("#nombre").val();
		var docu     = $("#documento").val();
		var celular  = $("#celular").val();
			celular = celular.replaceAll('-', '')
							.replaceAll('.', '')
							.replaceAll(' ', '');
		var coment   = $("#comentario").val();
		var servicio = $("#servicio :selected").val();
		var fecha    = $("#mydate").val(); fecha = fecha.trim();
		var usu      = localStorage.stellantis_user_id; 
		var usu2     = localStorage.stellantis_user_name; 
        var sucursal = $("#sucursal :selected").val();
        var km       = $("#kilometraje").val();
        var vin      = $("#vin").val();
        var vehiculo = $("#vehiculo").val();
        var tiempo   = $("#tiempo").val();

		var marca   = $("#marca").val();
        var modelo  = $("#modelo").val();
        var color   = $("#color").val();
        var reingreso   = ($('#reingreso').is(':checked')? 'S' : 'N');
		var contactoPreferido  = $("#contacto_preferido :selected").val();

		var res = {
										xfecha: fecha, 
										xcolumna: c,
										xcupo : f, 
										nombre: nombre,
										id_funcionario: usu, 
										ci: docu,
										celular: celular,
										servicio: servicio,
										comentario: coment,
										sucursal: sucursal,
										horario: horario,
										accion: 'nuevaFicha',
										reagendar: reagendar,
										km: km, 
										vin: vin, 
										vehiculo: vehiculo, 
										tiempo: tiempo,
										marca: marca , 
										modelo : modelo, 
										color: color, 
										reingreso: reingreso || 'N',
										contactoPreferido: contactoPreferido 
										}


		var jqxhr = $.ajax( 
							{ 
								method: "POST", 
								url: 'inc/procesos.php',
								data: {
										xfecha: fecha, 
										xcolumna: c,
										xcupo : f, 
										nombre: nombre,
										id_funcionario: usu, 
										ci: docu,
										celular: celular,
										servicio: servicio,
										comentario: coment,
										sucursal: sucursal,
										horario: horario,
										accion: 'nuevaFicha',
										reagendar: reagendar,
										km: km, 
										vin: vin, 
										vehiculo: vehiculo, 
										tiempo: tiempo,
										marca: marca , 
										modelo : modelo, 
										color: color , 
										reingreso: reingreso || 'N',
										contactoPreferido: contactoPreferido 

										},
								dataType: 'html', 
								encoding:"ISO-8859-1"
							})
						  .done( function() {
							console.log( "consulta ok" );
							
							//enviar la notificacion al cliente si la cuenta es verificada 
							 if(localStorage.getItem("isChecked") === '1' ){
							 	let lugares = [ {
									suc: '11', 
									ubicacion:'https://maps.app.goo.gl/squoYfk9L5hAvZ5Q8',
									nombre: 'TALLER CHANGAN', 
									direccion: 'Av. Madame Elisa A. Lynch esq. Sta. Teresa, Asunción - Paraguay'
								},];
							 	let lugar =  lugares.find(item => item.suc === sucursal )
							 	let data = {
							 		fecha: fecha, 
							 		hora: horario,
							 		celular: celular, 
							 		sucursal: sucursal,
							 		cliente: nombre,
							 		taller: lugar.nombre,
							 		direccion: lugar.direccion,
							 		ubicacion: lugar.ubicacion, 
							 		box: f
							 	}
							 	enviarRecordatorio(data)
							 }

							//fco hacer un retrieve para ver lista d... 
									desvincularFichaAbierta();
									consultar();
                                    $("myModal").modal("hide");
                                    $("#msj").html('<center><h3>Registro Grabado !!</h3> <br> <button type="button" onclick="consultar()" class="btn btn-default" data-dismiss="modal">Ok</button></center>');
                                    $("#titulo").html("Registro: Box: " + box + " | Horario: " + horario );
                                    $("#pie").remove();
                                    $("#myModal").modal();
							//setTimeout(function(){ location.reload(); }, 1500);
							socket.emit( 'message', { usuario: usu2, fila: f, evento: 'Registrado' } );

									
						  })
						  .fail(function(jqxhr, textStatus, error) {
							alert(error)
							var err = textStatus + ", " + error;
							console.log( "Request Failed: " + err );
						  });
	  }	
	  //event.preventDefault();
	}

	function reservar(f , c , us  ){
		var sucursal = $("#sucursal :selected").val();
		var fecha  = $("#mydate").val(); fecha = fecha.trim();
		console.log(sucursal);
		var jqxhr = $.ajax( 
							{ 
								method: "POST", 
								url: 'inc/procesos.php',
								data: {
										fila:f, 
										col :c,
										usu :us, 
                                        sucu: sucursal,
                                        fecha: fecha , 
                                        accion: 'reservar'
										},
								dataType: 'html', 
								encoding:"ISO-8859-1"
							})
						  .done(function() {
							console.log( "consulta ok" );
						  })
						  .fail(function(jqxhr, textStatus, error) {
							var err = textStatus + ", " + error;
							console.log( "Request Failed: " + err );
						  });

	  }

	function eliminarficha(ficha , box , hor ){
		
 		if (confirm("Esta Seguro que desea Eliminar este Registro ?") == true) {

            var usudelete  = localStorage.stellantis_user_id;
            console.log( "usuario" );
            console.log( usudelete );
			var jqxhr = $.ajax( 
								{ 
									method: "POST", 
									url: 'inc/procesos.php',
									data: {
										xficha:ficha,
                                        xusuario:usudelete,
                                        accion: 'eliminarFicha'
											},
									dataType: 'html', 
									encoding:"ISO-8859-1"
								})
							  .done(function(rs) {
                                  var Usuario  = <?php echo "'" . $_SESSION['usuario'] . "'" ?> ;
                                  socket.emit( 'message', { usuario: Usuario, fila: box, evento: 'eliminarRegistro' } );
                                  console.log( "Respuesta inc process" );
                                  console.log( rs );
                                  consultar();

                                  if(rs != "OK") {
                                      $("myModal").modal("hide");
                                      $("myModal").html("");
                                      $("#msj").html('<center><h3> No se puede eliminar este registro, Favor contactar con el Administrador !!</h3> <br> <button type="button" onclick="consultar()" class="btn btn-default" data-dismiss="modal">Ok</button></center> ');
                                      $("#titulo").html("Registro no modificado o eliminado" );
                                      $("#pie").remove();
                                      $("#myModal").modal();
                                  } else {
                                      console.log( "consulta ok" );
                                      $("myModal").modal("hide");
                                      $("myModal").html("");
                                      $("#msj").html('<center><h3>Registro Eliminado !!</h3> <br> <button type="button" onclick="consultar()" class="btn btn-default" data-dismiss="modal">Ok</button></center> ');
                                      $("#titulo").html("Registro: Box: " + box + " | Horario: " + hor );
                                      $("#pie").remove();
                                      $("#myModal").modal();
                                  }
							  })
							  .fail(function(jqxhr, textStatus, error) {
								var err = textStatus + ", " + error;
								alert("Request Failed: " + err);
								console.log( "Request Failed: " + err );
							  });
		}					  	

	}
		
		function modificarficha2(ficha, box , hor){

			try {
				const fichaUpd = {
					nombre: $("#nombre").val(),
					documento: $("#documento").val(),
					celular: $("#celular").val(),
					comentario: $("#comentario").val(),
					vin:  $("#vin").val(),
					vehiculo: $("#vehiculo").val(),
					km: $("#kilometraje").val(),
				}
				fetch(`http://192.168.10.54:3010/ficha/${ficha}`,
					{ 
						method: 'PUT', 
						body: JSON.stringify(fichaUpd), 
						headers: {"Content-type": "application/json; charset=UTF-8"
					}
				})
				.then((x)=>{
					consultar();
					$("myModal").modal("hide");
					$("myModal").html("");
					$("#msj").html('<center><h3>Registro Modificado !!</h3> <br> <button type="button" onclick="consultar()" class="btn btn-default" data-dismiss="modal">Ok</button></center> ');
					$("#titulo").html("Registro: Box: " + box + " | Horario: " + hor );
					$("#pie").remove();
					$("#myModal").modal();
				})
				.catch(e=>{ 
					alert('hubo un error ')
					console.log('error al actualizar la ficha ', e )
				})


			} catch (error) {
				console.log('hubo un error al actualizar la ficha ', error )
				alert('hubo un error al actualizar la ficha ' + error )
			}
		}


		function modificarficha(ficha , box , hor ){
			console.log($("#modificar").serialize());
			var reingreso   = ($('#reingreso').is(':checked')? $('#reingreso').val('S') : $('#reingreso').val('N')) ;

			var serial = $("#modificar").serialize(); 
			var jqxhr = $.ajax( 
							{ 
								method: "POST", 
								url: 'inc/procesos.php',
								data: {
										serial: serial, 
										ficha: ficha,
                                        accion: 'modificarFicha'
										},
								dataType: 'html', 
								encoding:"ISO-8859-1"
							})
						  .done(function() {
							console.log( "consulta ok" );
							consultar();
							$("myModal").modal("hide");
							$("myModal").html("");
							$("#msj").html('<center><h3>Registro Modificado !!</h3> <br> <button type="button" onclick="consultar()" class="btn btn-default" data-dismiss="modal">Ok</button></center> ');
							$("#titulo").html("Registro: Box: " + box + " | Horario: " + hor );
							$("#pie").remove();
							$("#myModal").modal();
							//setTimeout(function(){ location.reload(); }, 1500);
						  })
						  .fail(function(jqxhr, textStatus, error) {
							var err = textStatus + ", " + error;
							alert("Request Failed: " + err);
							console.log( "Request Failed: " + err );
						  });
		}
		function atenderficha(ficha , box , hor){
 		if (confirm("Atender Cliente ?") == true) {
			
			var jqxhr = $.ajax( 
							{ 
								method: "POST", 
								url: 'inc/procesos.php',
								data: {
										xficha: ficha,
                                        accion: 'atenderCliente', 
                                        funcionario : localStorage.stellantis_user_id 
										},
								dataType: 'html', 
								encoding:"ISO-8859-1"
							})
						  .done(function() {
							console.log( "consulta ok" );
							consultar();
							$("myModal").modal("hide");
							$("myModal").html("");
							$("#msj").html('<center><h3>Registro Atendido !!</h3> <br> <button type="button" onclick="location.reload()" class="btn btn-default" data-dismiss="modal">Ok</button></center> ');
							$("#titulo").html("Registro: Box: " + box + " | Horario: " + hor );
							$("#pie").remove();
							$("#myModal").modal();
							//setTimeout(function(){ location.reload(); }, 1500);
						  })
						  .fail(function(jqxhr, textStatus, error) {
							var err = textStatus + ", " + error;
							alert("Request Failed: " + err);
							console.log( "Request Failed: " + err );
						  });
		}				  
	}

	async function sincronizarReclamos(){
		var html = `
		<style>
			@keyframes spin {
				from {
					transform: rotate(0deg);
				}
				to {
					transform: rotate(360deg);
				}
			}
			#encuestaDet tr td , 
			#encuestaCab tr th,{
				padding: 10px;
			}
			#encuestaDet tr td {
				white-space: nowrap;
			} 
		</style>
		<div class="row">
			<div class="column">
				<h4>Ingrese el archivo excel: </h4>

				<form id="formFile">
					<div class="form-group">
						<div class="input-group">
							<span class="input-group-addon">Archivo Excel:</span>
							<input type="file" name="nombre" class="form-control" accept=".xls, .xlsx, .csv"  id="archivo" placeholder="Archivo"><span id="help2" class="label label-danger"></span>
						</div>
					</div>

					<div class="row" style="display:flex; flex-direction:row; justify-content:center;">

						<div class="column" style="display:none;" id="spinUp">
							<div class="column" style="display:flex; justify-content:center; align-items:center; flex-direction:column;" >
								<span class="glyphicon glyphicon-cog" style=" font-size:50px; animation: spin 1s infinite linear;"></span>
								<span style="font-size:24px; margin-left:10px"> Subiendo...</span>
							</div>
						</div>

						<div class="column" style="display:none;" id="spinOk">
							<div class="column" style="display:flex; justify-content:center; align-items:center; flex-direction:column; " >
								<span class="glyphicon glyphicon-ok" style=" font-size:50px;"></span>
								<span style="font-size:24px; margin-left:10px"> Datos Sincronizados !!</span>
							</div>
						</div>

						<div class="column" style="display:none;" id="spinError">
							<div class="column" style="display:flex; justify-content:center; align-items:center; flex-direction:column;" >
								<span class="glyphicon glyphicon-remove" style=" font-size:50px;"></span>
								<span style="font-size:24px; margin-left:10px"> Ocurrio un Error !!</span>
							</div>
						</div>

					</div>

					<div class="form-group">
						<button type="button" class="btn btn-default pull-right" onclick="" data-dismiss="modal">Cancelar</button>
						<button id="boton_ins" style="margin-right:5px;" type="button" class="btn btn-primary pull-right" onClick="enviarDatos()">Subir</button>
					</div>
				</form>
			</div>

			<div class="column " style="margin-top:50px;">
				<h3 class="mt-3">Datos de la Planilla <span class="label label-info" id="cantRegistros"></span></h3>

				<div class="" style="overflow:auto; height:300px;">
					<table class="table-hover table-bordered">
						<thead id="encuestaCab">
							<tr>
								<th >Codigo</th>
								<th >fecha</th>
								<th >vin</th>
								<th >modelo</th>
								<th >asesor</th>
								<th >NroOrden</th>	
								<th >taller</th>
								<th >cliente</th>
								<th >correo</th>
								<th >satisfacionCliente</th>
								<th >recomiendaTaller</th>
								<th >comentarioEstadiaTaller</th>
								<th >satisfacionEtiqueta</th>
								<th >comentarioNegativo</th>
								<th >comentarioNegativoEtiqueta</th>
								<th >comentarioPositivo</th>
							</tr>						
						</thead>
						
						<tbody id="encuestaDet"></tbody>
					</table>

				</div>
			</div>
			
		</div>
		
		`
		$("#titulo").html("SINCRONIZAR DATOS ENCUESTAS" );
		$("#pie").remove();
		$("#msj").html(html);
		$("#myModal").modal({backdrop: "static"});

	}

	async function enviarDatos(){
		if(!$('#archivo')[0].files[0] === true ) return alert('Debe ingresar el archivo excel!')


		$("#spinOk").css('display', 'none')
		$("#spinError").css('display', 'none')
		$("#spinUp").css('display', 'block')

		console.log( 'enviar datos ', $('#archivo')[0].files[0] )
		var fd = new FormData() 
		var file = $('#archivo')[0].files[0] 
		fd.append('file', file )

		let sucursal = 'reclamoCliente'
		await fetch(`http://192.168.10.54:3010/upload/${sucursal}`, {
			method: 'POST',
			body: fd
		})
		.then(async (result) =>{
			$("#spinUp").css('display', 'none')
			$("#spinOk").css('display', 'block')
			console.log('Success:')
			
			await fetch(`http://192.168.10.54:3010/excel-callcenter`)
			.then(response => response.json())  // convertir a json
		    .then(json =>{ console.log('datos de la encuenta ',json)
				console.log(json.result['Banco de Respuestas'])
				json.result['Banco de Respuestas'] = json.result['Banco de Respuestas'].filter(item=> item.vin.length > 5)
				let detString = json.result['Banco de Respuestas'].map(item=> '<tr>\n'+ Object.values(item).map(item=> `<td>${item}</td>`).join('\n') +'</tr>' ).join('\n') 
				console.log(detString)
				$("#encuestaDet").html(detString)
				$("#cantRegistros").html(json.result['Banco de Respuestas'].length + ' Registros ')


			})    //imprimir los datos en la consola			
			.catch(error => console.log('error en la lectura del archivo excel', error ))

		})
		.catch((error) =>{
			$("#spinUp").css('display', 'none')
			$("#spinError").css('display', 'block')
			console.error('Error:', error)			
		})
	}


	function consultarFicha(ficha , box , hor ){
		
		var jqxhr = $.ajax( 
							{ 
								method: "POST", 
								url: 'inc/procesos.php',
								data: {
										ficha: ficha,
                                        accion: 'modificar'
										},
								dataType: 'json', 
								encoding:"ISO-8859-1"
							})
						  .done(function(rs) {
							console.log( "consulta ok" );
							console.log(rs);
							$("#titulo").html("Registro: Box: " + box + " | Horario: " + hor );
							$("#pie").remove();
							rs.forEach( function ( rs2 ){
								$(".modal-header > button").remove();
								var html =  '<form id="modificar" >'+
												'<div class="form-group">'+ 
												'    <input type="text" name="nombre" class="form-control" id="nombre" placeholder="Nombre" value= "' +rs2["cliente"]+ '"><span id="help1" class="label label-danger"></span>'+
												'</div>'+
												'<div class="form-group">'+
												'   <input type="text" name="documento" class="form-control" id="documento" placeholder="Documento" value= "' +rs2["documento"]+ '"><span id="help2" class="label label-danger"></span>'+
												'</div>'+
												'<div class="form-group">'+
												'   <input type="text" name="celular" class="form-control" id="celular" placeholder="Celular" value= "' +rs2["celular"]+ '"><span id="help3" class="label label-danger"></span>'+
												'</div>'+
												'<div class="form-group">'+
												'   <textarea name="comentario" class="form-control" rows="5" id="comentario" placeholder="Comentario">' +rs2["comentario"]+ '</textarea><span id="help4" class="label label-danger"></span>'+
												'</div>'+
												'<div class="form-group">'+
												'  <select name="servicio" class="form-control" id="servicio">'+
												'    <option value="Mantenimiento">Mantenimiento</option>'+
												'    <option value="Express">Express</option>'+
												'    <option value="Servicio Gral.">Servicios Generales</option>'+
												'  </select>'+
												'</div><span id="help4"></span>'+ 
												'<div class="form-group" style="text-align:right;">'+
												'   <button id="boton_ins" type="button" disabled class="btn btn-warning" onClick="modificarficha2(' + ficha +','+ box +',@'+ hor +'@)">Modificarrrr</button>'+
												'   <button id="boton_ins" type="button" disabled class="btn btn-success" onClick="atenderficha(' + ficha +','+ box +',@'+ hor +'@)">Atender</button>'+
												'   <button id="boton_ins" type="button" disabled class="btn btn-danger" onClick="eliminarficha(' + ficha +','+ box +',@'+ hor +'@)">Eliminar</button><span>&nbsp;&nbsp;&nbsp;</span> '+
									
												'   <button type="button" class="btn btn-default" onclick="desvincularFichaAbierta()" data-dismiss="modal">Cancelar</button>'+
												'</div>'+
											'</form>' ;
								html = html.replace(/@/g, "'"); //fco reemplazar todos los @ por ' cuando es string para pasar argumentos en funciones 
								$("#msj").html(html);
								$("#myModal").modal({backdrop: "static"});   
								
							});
						  })
						  .fail(function(jqxhr, textStatus, error) {
							var err = textStatus + ", " + error;
							alert("Request Failed: " + err);
							console.log( "Request Failed: " + err );
						  });
    }
	function configBoxes(){
		
		var jqxhr = $.ajax( 
							{ 
								method: "POST", 
								url: 'inc/procesos.php',
								data: {
                                        accion: 'configBoxes'
										},
								dataType: 'json', 
								encoding:"ISO-8859-1"
							})
						  .done(function(rs) {
								console.log( "consulta ok" );
								console.log(rs);
								
								var html = '<form id="abmBox">'+
											'	<div class="form-group">'+
											'		<input readonly type="text" name="id_box" class="form-control" id="id_box" placeholder="Codigo"><span id="help1" class="label label-danger"></span>'+
											'	</div>'+
											'	<div class="form-group">'+
											'		<div class="input-group">'+
											'			<span class="input-group-addon">Sucursales:</span>'+
											'			<select name="sucursal" id="sucursal2" class="form-control">'+
											'			</select>'+
											'		</div>'+
											'	</div>'+											'	<div class="form-group">'+
											'		<div class="input-group">'+
											'			<span class="input-group-addon">Asesores:</span>'+
											'		<input type="text" name="nombre" class="form-control" id="nombre" placeholder="Asesores"><span id="help2" class="label label-danger"></span>'+
											'		</div>'+
											'	</div>'+
											'	<div class="form-group">'+
											'		<div class="input-group">'+
											'			<span class="input-group-addon">Orden:</span>'+
											'		<input type="text" name="orden" class="form-control" id="orden" placeholder="Orden..."><span id="help2" class="label label-danger"></span>'+
											'		</div>'+
											'	</div>'+

											
											'	<div class="form-group">'+
											'		<div class="input-group">'+
											'			<span class="input-group-addon">Estado:</span>'+
											'			<select name="estado" id="estado" class="form-control">'+
											'				<option value="1">Activo</option>'+
											'				<option value="0">Inactivo</option>'+
											'			</select>'+
											'		</div>'+
											'	</div>'+
											'	<div class="form-group">'+
											'   <button type="button" class="btn btn-default pull-right" onclick="consultar()" data-dismiss="modal">Cancelar</button>'+
											'   <button id="boton_ins" style="margin-right:5px;" type="button" class="btn btn-primary pull-right" onClick="abmBoxes(1)">Insertar</button>'+
											'	</div>'+
											'</form>'+
										   '<div class="table-responsive">'+
											'<br><br><div class="form-group"><div class="input-group" id="buscador">'+
											'<span class="input-group-addon">Buscar:</span> <input type="text" onchange="oheka( @boxes@ ,this.value);" name="buscar" class="form-control" id="buscar" placeholder="Buscar... "> '+
											' </div></div>'+

										   '<table class="table table-hover" sytle="text-align:center;" id="boxes">'+
										   '<thead> <th>Sucursal</th> <th>Asesor</th> <th>Orden</th> <th>Estado</th> <th>Editar</th> </thead>'+
										   '<tbody> ' ;
								$("#titulo").html("BOXES: " );
								$("#pie").remove();
								rs.forEach( function ( rs2 ){
									html = html + '<tr> <td>'+ rs2["sucursal"] +'</td> <td>'+ rs2["nombre"] +'</td> <td>'+ rs2["orden"] +'</td>'+ ( ( rs2["estado"] == 1) ? '<td class="text-success"> Activo' : '<td class="text-danger"> Inactivo') +'</td> <td> <a href=" javascript:recuperarBox('+ rs2["id_box"] +',@'+ rs2["nombre"] +'@,'+ rs2["estado"] +', '+ rs2["id_sucursal"] +', ' + rs2["orden"] + ')"> <span class="label label-primary"><span class="glyphicon glyphicon-edit"></span></span> </a> </td> </tr>';
								});
								html = html + '</tbody> </table></div>'
								html = html.replace(/@/g, "'"); //fco reemplazar todos los @ por ' cuando es string para pasar argumentos en funciones 
								$("#msj").html(html);
								$("#myModal").modal({backdrop: "static"});
								//fco recuperar sucursal 
								var jqxhr1 = $.ajax( { method: "POST", url: 'inc/procesos.php', data: { accion: "configSucursales" }, dataType: 'json', encoding:"ISO-8859-1"});
								jqxhr1.done(function(rs) { //recuperar datos de sucursal 
									console.log("trae los datos de sucursales .... ");
									console.log(rs);
									var html = "";
									rs.forEach( function ( rs2 ){
										if ( rs2["estado"] == 1 ){
											html = html + '<option value="'+ rs2["id"] +'">'+ rs2["nombre"] +'</option> ';
										}
									});
									$("#sucursal2").empty();
									$("#sucursal2").html(html);
									console.log("arma la estructura para sucursales ... ");
									console.log(html);
								});//fin recuperar sucursal 
								
								
						  })
						  .fail(function(jqxhr, textStatus, error) {
							var err = textStatus + ", " + error;
							alert("Request Failed: " + err);
							console.log( "Request Failed: " + err );
						  });
    }
	function abmBoxes(evento){
		if ( $.trim( $( "#nombre").val()) === "" ) {
			$( "#help2" ).text( "Ingrese un Box..." ).show().fadeOut( 5000 ); return;
		}

		console.log($("#abmBox").serialize());
		console.log($("#nombre").val());
		var serial = $("#abmBox").serialize();
		alert(serial)
		var jqxhr = $.ajax( 
							{ 
								method: "POST", 
								url: 'inc/procesos.php',
								data: {
										evento: evento,
										serial: serial,
                                        accion: 'abmBoxes'
										},
								dataType: 'json', 
								encoding:"ISO-8859-1"
							})
						  .done(function(rs) {
								console.log( "consulta ok" );
								console.log(rs);
								alert('Registro Grabado !!!');
								configBoxes();
						  })
						  .fail(function(jqxhr, textStatus, error) {
							var err = textStatus + ", " + error;
							alert("Request Failed: " + err);
							console.log( "Request Failed: " + err );
						  });
	}
	function recuperarBox(id_box , nombre , estado , sucursal , orden ){
		$("#boton_ins").removeAttr("onclick");
		$("#boton_ins").attr("onclick", "abmBoxes(2)");
		$("#boton_ins").html("Modificar");
		
		$("#id_box").val(id_box);
		$("#nombre").val(nombre);
		$("#orden").val(orden);
		$('#estado').val(estado).prop('selected', true);
		$("#estado option[value="+ estado +"]").attr("selected", true);
		$('#sucursal2').val(sucursal).prop('selected', true);
		$("#sucursal2 option[value="+ sucursal +"]").attr("selected", true);        
	}
	
	function configTurnos(){
		
		var jqxhr = $.ajax( 
							{ 
								method: "POST", 
								url: 'inc/procesos.php',
								data: {
                                        accion: 'configTurnos'
										},
								dataType: 'json', 
								encoding:"ISO-8859-1"
							})
						  .done(function(rs) {
								console.log( "consulta ok" );
								console.log(rs);
								
								var html = '<form id="abmTurnos">'+
											'	<div class="form-group">'+
											'		<input readonly type="text" name="id" class="form-control" id="id" placeholder="Codigo"><span id="help1" class="label label-danger"></span>'+
											'	</div>'+
											'	<div class="form-group">'+
											'		<div class="input-group">'+
											'			<span class="input-group-addon">Sucursales:</span>'+
											'			<select name="sucursal" id="sucursal2" class="form-control">'+
											'			</select>'+
											'		</div>'+
											'	</div>'+
											'	<div class="form-group">'+
											'		<div class="input-group">'+
											'			<span class="input-group-addon">Turnos:</span>'+
											'		<input type="text" name="nombre" class="form-control" id="nombre" placeholder="Turno"><span id="help2" class="label label-danger"></span>'+
											'		</div>'+
											'	</div>'+
											'	<div class="form-group">'+
											'		<div class="input-group">'+
											'			<span class="input-group-addon">Estado:</span>'+
											'			<select name="estado" id="estado" class="form-control">'+
											'				<option value="1">Activo</option>'+
											'				<option value="0">Inactivo</option>'+
											'			</select>'+
											'		</div>'+
											'	</div>'+
											'	<div class="form-group">'+
											'   <button type="button" class="btn btn-default pull-right" onclick="consultar()" data-dismiss="modal">Cancelar</button>'+
											'   <button id="boton_ins" style="margin-right:5px;" type="button" class="btn btn-primary pull-right" onClick="abmTurnos(1)">Insertar</button>'+
											'	</div>'+
											'</form>'+
										   '<div class="table-responsive">'+
										   '<table class="table table-hover" sytle="text-align:center;">'+
										   '<thead> <th>Sucursal</th> <th>Turnos</th> <th>Estado</th> <th>Editar</th> </thead>'+
										   '<tbody> ' ;
								$("#titulo").html("TURNOS: " );
								$("#pie").remove();
								rs.forEach( function ( rs2 ){
									html = html + '<tr> <td>'+ rs2["sucursal"] +'</td> <td>'+ rs2["nombre"] +'</td>'+ ( ( rs2["estado"] == 1) ? '<td class="text-success"> Activo' : '<td class="text-danger"> Inactivo') +'</td> <td> <a href=" javascript:recuperarTurno('+ rs2["id"] +',@'+ rs2["nombre"] +'@,'+ rs2["estado"] +', '+ rs2["id_sucursal"] +')"> <span class="label label-primary"><span class="glyphicon glyphicon-edit"></span></span> </a> </td> </tr>';
								});
								html = html + '</tbody> </table></div>'
								html = html.replace(/@/g, "'"); //fco reemplazar todos los @ por ' cuando es string para pasar argumentos en funciones 
								$("#msj").html(html);
								$("#myModal").modal({backdrop: "static"});
								
								var jqxhr1 = $.ajax( { method: "POST", url: 'inc/procesos.php', data: { accion: "configSucursales" }, dataType: 'json', encoding:"ISO-8859-1"});
								jqxhr1.done(function(rs) { //recuperar datos de sucursal 
									console.log("trae los datos de sucursales .... ");
									console.log(rs);
									var html = "";
									rs.forEach( function ( rs2 ){
										if ( rs2["estado"] == 1 ){
											html = html + '<option value="'+ rs2["id"] +'">'+ rs2["nombre"] +'</option> ';
										}
									});
									$("#sucursal2").empty();
									$("#sucursal2").html(html);
									console.log("arma la estructura para sucursales ... ");
									console.log(html);
								});//fin recuperar sucursal 
						  })
						  .fail(function(jqxhr, textStatus, error) {
							var err = textStatus + ", " + error;
							alert("Request Failed: " + err);
							console.log( "Request Failed: " + err );
						  });
    }
	function abmTurnos(evento){
		if ( $.trim( $( "#nombre").val()) === "" ) {
			$( "#help2" ).text( "Ingrese un Turno..." ).show().fadeOut( 5000 ); return;
		}

		console.log($("#abmTurnos").serialize());
		console.log($("#nombre").val());
		var serial = $("#abmTurnos").serialize();
		var jqxhr = $.ajax( 
							{ 
								method: "POST", 
								url: 'inc/procesos.php',
								data: {
										evento: evento,
										serial: serial ,
                                        accion: 'abmTurnos'
										},
								dataType: 'json', 
								encoding:"ISO-8859-1"
							})
						  .done(function(rs) {
								console.log( "consulta ok" );
								console.log(rs);
								alert("Registro Grabado !!!");
								configTurnos();
						  })
						  .fail(function(jqxhr, textStatus, error) {
							var err = textStatus + ", " + error;
							alert("Request Failed: " + err);
							console.log( "Request Failed: " + err );
						  });
	}
	function recuperarTurno(id , nombre , estado , sucursal ){
		$("#boton_ins").removeAttr("onclick");
		$("#boton_ins").attr("onclick", "abmTurnos(2)");
		$("#boton_ins").html("Modificar");
		
		$("#id").val(id);
		$("#nombre").val(nombre);
		$('#estado').val(estado).prop('selected', true);
		$("#estado option[value="+ estado +"]").attr("selected", true);
		$('#sucursal2').val(sucursal).prop('selected', true);
		$("#sucursal2 option[value="+ sucursal +"]").attr("selected", true);
	}

	function configHorarios(){
		
		var jqxhr = $.ajax( 
							{ 
								method: "POST", 
								url: 'inc/procesos.php',
								data: {
                                        accion: 'configHorarios'
										},
								dataType: 'json', 
								encoding:"ISO-8859-1"
							})
						  .done(function(rs) {
								console.log( "consulta ok" );
								console.log(rs);
								
								var html = '<form id="abmHorarios">'+
											'	<div class="form-group">'+
											'		<input readonly type="text" name="id" class="form-control" id="id" placeholder="Codigo"><span id="help1" class="label label-danger"></span>'+
											'	</div>'+
											'	<div class="form-group">'+
											'		<div class="input-group">'+
											'			<span class="input-group-addon">Turnos:</span>'+
											'			<select name="turno" id="turno" class="form-control">'+
											'			</select>'+
											'		</div>'+
											'	</div>'+
											'	<div class="form-group">'+
											'		<div class="input-group">'+
											'			<span class="input-group-addon">Horario:</span>'+
											'		<input type="text" name="nombre" class="form-control" id="nombre" placeholder="horario"><span id="help2" class="label label-danger"></span>'+
											'		</div>'+
											'	</div>'+
											'	<div class="form-group">'+
											'		<div class="input-group">'+
											'			<span class="input-group-addon">Orden:</span>'+
											'			<input type="text" name="orden" class="form-control" id="orden" placeholder="Orden"><span id="help2" class="label label-danger"></span>'+
											'		</div>'+
											'	</div>'+
											'	<div class="form-group">'+
											'		<div class="input-group">'+
											'			<span class="input-group-addon">Estado:</span>'+
											'			<select name="estado" id="estado" class="form-control">'+
											'				<option value="1">Activo</option>'+
											'				<option value="0">Inactivo</option>'+
											'			</select> '+
											'		</div>'+
											'	</div>'+
											'	<div class="form-group">'+
											'   <button type="button" class="btn btn-default pull-right" onclick="consultar()" data-dismiss="modal">Cancelar</button>'+
											'   <button id="boton_ins" style="margin-right:5px;" type="button" class="btn btn-primary pull-right" onClick="abmHorarios(1)">Insertar</button>'+
											'	</div><br><br>'+
											'</form>'+
										   '<div class="table-responsive">'+
											'<div class="form-group"><div class="input-group" id="buscador">'+
											'<span class="input-group-addon">Buscar:</span> <input type="text" onchange="oheka( @horarios@ ,this.value);" name="buscar" class="form-control" id="buscar" placeholder="Buscar... "> '+
											' </div></div>'+

										   '<table class="table table-hover" sytle="text-align:center;" id="horarios" >'+
										   '<thead> <th>Sucursales</th>  <th>Turnos</th> <th>Horario</th> <th>Orden</th><th>Estado</th> <th>Editar</th> </thead>'+
										   '<tbody style=" height:500px; width:500px; overflow-y: auto;"> ' ;
								$("#titulo").html("HORARIOS: " );
								$("#pie").remove();
								rs.forEach( function ( rs2 ){
									html = html + '<tr> <td>'+ rs2["sucursal"] +'</td> <td>'+ rs2["turno_nombre"] +'</td> <td>'+ rs2["nombre"] +'<td>'+ rs2["orden"] +'</td> '+ ( ( rs2["estado"] == 1) ? '<td class="text-success"> Activo' : '<td class="text-danger"> Inactivo') +'</td> <td> <a href=" javascript:recuperarHorario('+ rs2["id"] +',@'+ rs2["nombre"] +'@,'+ rs2["estado"] +','+rs2["turno"]+','+ rs2["orden"] +' )"> <span class="label label-primary"><span class="glyphicon glyphicon-edit"></span></span> </a> </td> </tr>';
								});
								html = html + '</tbody> </table></div>'
								html = html.replace(/@/g, "'"); //fco reemplazar todos los @ por ' cuando es string para pasar argumentos en funciones 
								$("#msj").html(html);
								$("#myModal").modal({backdrop: "static"});
								
									//fco recuperar datos de turnos para asignar a horarios 
									var jqxhr1 = $.ajax( { method: "POST", url: 'inc/procesos.php', data: { accion: "configTurnos" }, dataType: 'json', encoding:"ISO-8859-1"});
									jqxhr1.done(function(rs) { //recuperar datos de turnos 
										console.log(rs);
										var html = "";
										rs.forEach( function ( rs2 ){
											if ( rs2["estado"] == 1 ){
												html = html + '<option value="'+ rs2["id"] +'">'+ rs2["sucursal"]  + ' - ' + rs2["nombre"] +'</option> ';
												$("#turno").empty();
												$("#turno").html(html);
											}
										});
									});
						  })
						  .fail(function(jqxhr, textStatus, error) {
							var err = textStatus + ", " + error;
							alert("Request Failed: " + err);
							console.log( "Request Failed: " + err );
						  });
    }
	function abmHorarios(evento){
		if ( $.trim( $( "#nombre").val()) === "" ) {
			$( "#help2" ).text( "Ingrese un Horario..." ).show().fadeOut( 5000 ); return;
		}

		console.log($("#abmHorarios").serialize());
		console.log($("#nombre").val());
		var serial = $("#abmHorarios").serialize();
		var jqxhr = $.ajax( 
							{ 
								method: "POST", 
								url: 'inc/procesos.php',
								data: {
										evento: evento,
										serial: serial,
                                        accion: 'abmHorarios'
										},
								dataType: 'json', 
								encoding:"ISO-8859-1"
							})
						  .done(function(rs) {
								console.log( "consulta ok" );
								console.log(rs);
								alert("Registro Grabado !!!");
								configHorarios();
						  })
						  .fail(function(jqxhr, textStatus, error) {
							var err = textStatus + ", " + error;
							alert("Request Failed: " + err);
							console.log( "Request Failed: " + err );
						  });
	}
	function recuperarHorario(id , nombre , estado , turno , orden){
		$("#boton_ins").removeAttr("onclick");
		$("#boton_ins").attr("onclick", "abmHorarios(2)");
		$("#boton_ins").html("Modificar");
		
		$("#id").val(id);
		$("#nombre").val(nombre);
		$("#orden").val(orden);
		
		$('#estado').val(estado).prop('selected', true);
		$("#estado option[value="+ estado +"]").attr("selected", true);
		$('#turno').val(turno).prop('selected', true);
		$("#turno option[value="+ turno +"]").attr("selected", true);
		$("#nombre").focus();
		
	}
	
	function configSucursales(){
		//fco recuperar datos de horarios para el tablero 
		var jqxhr1 = $.ajax( { method: "POST", url: 'inc/procesos.php', data: { accion: "configSucursales" }, dataType: 'json', encoding:"ISO-8859-1"});
		jqxhr1.done(function(rs) { //recuperar datos de turnos 
			console.log(rs);
			var html = '<form id="abmSucursales">'+
						'	<div class="form-group">'+
						'		<input readonly type="text" name="id" class="form-control" id="id" placeholder="Codigo"><span id="help1" class="label label-danger"></span>'+
						'	</div>'+
						'	<div class="form-group">'+
						'		<input type="text" name="nombre" class="form-control" id="nombre" placeholder="Sucursal"><span id="help2" class="label label-danger"></span>'+
						'	</div>'+
						'	<div class="form-group">'+
						'		<div class="input-group">'+
						'			<span class="input-group-addon">Estado:</span>'+
						'			<select name="estado" id="estado" class="form-control">'+
						'				<option value="1">Activo</option>'+
						'				<option value="0">Inactivo</option>'+
						'			</select> '+
						'		</div>'+
						'	</div>'+
						'	<div class="form-group">'+
						'   <button type="button" class="btn btn-default pull-right" onclick="consultar()" data-dismiss="modal">Cancelar</button>'+
						'   <button id="boton_ins" style="margin-right:5px;" type="button" class="btn btn-primary pull-right" onClick="abmSucursales(1)">Insertar</button>'+
						'	</div>'+
						'</form>'+
					   '<div class="table-responsive">'+
						'<br><br><div class="form-group"><div class="input-group" id="buscador">'+
						'<span class="input-group-addon">Buscar:</span> <input type="text" onchange="oheka( @sucursales@ ,this.value);" name="buscar" class="form-control" id="buscar" placeholder="Buscar... "> '+
						' </div></div>'+

					   '<table class="table table-hover" sytle="text-align:center;" id="sucursales">'+
					   '<thead> <th>Sucursales</th> <th>Turnos</th><th>Estado</th></thead>'+
					   '<tbody> ' ;
			$("#titulo").html("SUCURSALES: " );
			$("#pie").remove();
			rs.forEach( function ( rs2 ){
				html = html + '<tr> <td>'+ rs2["nombre"] +'</td> '+ ( ( rs2["estado"] == 1) ? '<td class="text-success"> Activo' : '<td class="text-danger"> Inactivo') +'</td> <td> <a href=" javascript:recuperarSucursal('+ rs2["id"] +',@'+ rs2["nombre"] +'@, '+ rs2["estado"] + ' )"> <span class="label label-primary"><span class="glyphicon glyphicon-edit"></span></span> </a> </td> </tr>';
			});
			html = html + '</tbody> </table></div>'
			html = html.replace(/@/g, "'"); //fco reemplazar todos los @ por ' cuando es string para pasar argumentos en funciones 
			$("#msj").html(html);
			$("#myModal").modal({backdrop: "static"});
			
		});
	}
	
	function abmSucursales(evento){
		if ( $.trim( $( "#nombre").val()) === "" ) {
			$( "#help2" ).text( "Ingrese un Sucursal..." ).show().fadeOut( 5000 ); return;
		}
		console.log($("#abmSucursales").serialize());
		var serial = $("#abmSucursales").serialize();
		var jqxhr1 = $.ajax( { method: "POST", url: 'inc/procesos.php', data: { accion: "abmSucursales", serial: serial , evento : evento }, dataType: 'json', encoding:"ISO-8859-1"});
		jqxhr1.done(function(rs) { //recuperar datos de turnos 
			console.log(rs);
			alert("Registro Grabado !!!");
			configSucursales();
			vistaSucursales();
		})
		.fail(function(jqxhr1, textStatus, error) {
			var err = textStatus + ", " + error;
			alert("Request Failed: " + err);
			console.log( "Request Failed: " + err );
		});
	}
	
	function recuperarSucursal(id , nombre , estado ){
		$("#boton_ins").removeAttr("onclick");
		$("#boton_ins").attr("onclick", "abmSucursales(2)");
		$("#boton_ins").html("Modificar");
		
		$("#id").val(id);
		$("#nombre").val(nombre);
		$('#estado').val(estado).prop('selected', true);
		$("#estado option[value="+ estado +"]").attr("selected", true);
	}

	function configServicios(){
		//fco recuperar datos de horarios para el tablero 
		var jqxhr1 = $.ajax( { method: "POST", url: 'inc/procesos.php', data: { accion: "configServicios" }, dataType: 'json', encoding:"ISO-8859-1"});
		jqxhr1.done(function(rs) { //recuperar datos de turnos 
			console.log(rs);
			var html = '<form id="abmServicios">'+
						'	<div class="form-group">'+
						'		<input readonly type="text" name="id" class="form-control" id="id" placeholder="Codigo"><span id="help1" class="label label-danger"></span>'+
						'	</div>'+
						'	<div class="form-group">'+
						'		<input type="text" name="nombre" class="form-control" id="nombre" placeholder="Servicio"><span id="help2" class="label label-danger"></span>'+
						'	</div>'+
						'	<div class="form-group">'+
						'		<div class="input-group">'+
						'			<span class="input-group-addon">Estado:</span>'+
						'			<select name="estado" id="estado" class="form-control">'+
						'				<option value="1">Activo</option>'+
						'				<option value="0">Inactivo</option>'+
						'			</select> '+
						'		</div>'+
						'	</div>'+
						'	<div class="form-group">'+
						'   <button type="button" class="btn btn-default pull-right" onclick="consultar()" data-dismiss="modal">Cancelar</button>'+
						'   <button id="boton_ins" style="margin-right:5px;" type="button" class="btn btn-primary pull-right" onClick="abmServicios(1)">Insertar</button>'+
						'	</div>'+
						'</form>'+
					   '<div class="table-responsive">'+
						'<br><br><div class="form-group"><div class="input-group" id="buscador">'+
						'<span class="input-group-addon">Buscar: <span class="badge" id="cant-filas"></span></span> <input type="text" onchange="oheka( @servicios@ ,this.value);" name="buscar" class="form-control" id="buscar" placeholder="Buscar... "> '+
						' </div></div>'+

					   '<table class="table table-hover" sytle="text-align:center;" id="servicios">'+
					   '<thead> <th>Servicios</th> <th>Estado</th></thead>'+
					   '<tbody> ' ;
			$("#titulo").html("SERVICIOS: " );
			$("#pie").remove();
			rs.forEach( function ( rs2 ){
				html = html + '<tr> <td>'+ rs2["nombre"] +'</td> '+ ( ( rs2["estado"] == 1) ? '<td class="text-success"> Activo' : '<td class="text-danger"> Inactivo') +'</td> <td> <a href=" javascript:recuperarServicio('+ rs2["id"] +',@'+ rs2["nombre"] +'@, '+ rs2["estado"] + ' )"> <span class="label label-primary"><span class="glyphicon glyphicon-edit"></span></span> </a> </td> </tr>';
			});
			html = html + '</tbody> </table></div>'
			html = html.replace(/@/g, "'"); //fco reemplazar todos los @ por ' cuando es string para pasar argumentos en funciones 
			$("#msj").html(html);
			$("#myModal").modal({backdrop: "static"});
		});
	}
	
	function abmServicios(evento){
		if ( $.trim( $( "#nombre").val()) === "" ) {
			$( "#help2" ).text( "Ingrese un Servicio..." ).show().fadeOut( 5000 ); return;
		}
		console.log($("#abmServicios").serialize());
		var serial = $("#abmServicios").serialize();
		var jqxhr1 = $.ajax( { method: "POST", url: 'inc/procesos.php', data: { accion: "abmServicios", serial: serial , evento: evento }, dataType: 'json', encoding:"ISO-8859-1"});
		jqxhr1.done(function(rs) { //recuperar datos de turnos 
			console.log(rs);
			alert("Registro Grabado !!!");
			configServicios();
		})
		.fail(function(jqxhr1, textStatus, error) {
			var err = textStatus + ", " + error;
			alert("Request Failed: " + err);
			console.log( "Request Failed: " + err );
		});
	}
	
	function recuperarServicio(id , nombre , estado ){
		$("#boton_ins").removeAttr("onclick");
		$("#boton_ins").attr("onclick", "abmServicios(2)");
		$("#boton_ins").html("Modificar");
		
		$("#id").val(id);
		$("#nombre").val(nombre);
		$('#estado').val(estado).prop('selected', true);
		$("#estado option[value="+ estado +"]").attr("selected", true);
	}
	
	function reagendar(){
		var sucursal = $("#sucursal :selected").val();
		var jqxhr1 = $.ajax( { method: "POST", url: 'inc/procesos.php', data: { accion: "reagendar" , sucursal: sucursal }, dataType: 'json', encoding:"ISO-8859-1"});
		jqxhr1.done(function(rs) { //recuperar datos de turnos
			console.log(rs);
			
			var estados = [
				{color: '' , nombre: ''},
				{color: 'text-white label-danger ' , nombre: 'AGENDADO'},
				{color: 'text-white label-success' , nombre: 'ATENDIDO'},
				{color: 'text-white label-warning' , nombre: 'CONFIRMADO'},
				{color: 'text-white label-info' , nombre: 'LLAMAR'},
			];


			var buscador =	'<span class="input-group-addon">Buscar:</span> <input type="text" onchange="oheka( @reagendar@ ,this.value);" name="buscar" class="form-control" id="buscar" placeholder="Cliente ... Documento ... "> ';
			var html = '<thead> <th>Fecha</th> <th>Cliente</th> <th>Documento</th> <th>Servicio</th> <th>Box</th> <th>Turno</th> <th>Re-Agendar</th> <th>Estado</th> </thead> <tbody>'; //cabecera
			rs.forEach( function ( rs2 ){
				html = html + '<tr> <td>'+ rs2["fecha"] +'</td> <td>'+ rs2["cliente"] +'</td> <td>'+ rs2["documento"] +'</td> <td>' + rs2["servicio"] + '</td> <td>'+ rs2["box"] +'</td> <td>'+ rs2["turno"] +'</td> <td> <a href=" javascript:reagendar_abm('+ rs2["ficha"] +' , @'+ rs2["cliente"] +'@ , @' +rs2["documento"]+ '@ , @' + rs2["celular"] + '@ , @'+ rs2["comentario"] +'@ , @'+ rs2["servicio"] + '@ )"> <span class="label label-primary"><span class="glyphicon glyphicon-edit"></span></span> </a> </td> <td> <span class="'+ estados[rs2['estado']]['color'] +'"> '+ estados[rs2['estado']]['nombre'] +'</span></td> </tr>';
		});
			html = html + '</tbody>' //fco cerramos tabla 
			html = html.replace(/@/g, "'"); //fco reemplazar todos los @ por ' cuando es string para pasar argumentos en funciones 
			buscador = buscador.replace(/@/g, "'"); //fco reemplazar todos los @ por ' cuando es string para pasar argumentos en funciones 
			$("#buscador").html(buscador);
			$("#reagendar").empty();
			$("#reagendar").html(html);
		})
		.fail(function(jqxhr1, textStatus, error) {
			var err = textStatus + ", " + error;
			alert("Request Failed: " + err);
			console.log( "Request Failed: " + err );
		});
	}
	
	function oheka(id , texto) {
		if (texto.length == 0 ){
			$("#" + id + " tbody tr").show();
		}else{
			$("#" + id + " tbody tr").not(':contains("'+ texto +'")').hide();
		}
		$('#cant-filas').html($('#'+ id +' >tbody >tr:visible').length);
		console.log(id);
		console.log( $('#'+ id +' >tbody >tr:visible').length);
	}
	
	function reagendar_abm(ficha , cliente , documento , celular , comentario , servicio ){

		var jqxhr1 = $.ajax( { method: "POST", url: 'inc/procesos.php', data: { accion: "ficha" , ficha: ficha }, dataType: 'json', encoding:"ISO-8859-1"});
		jqxhr1.done(function(rs) { //recuperar datos de turnos 
			console.log(rs);
			$("#nombre").val(rs[0]['nombre']);
			$("#documento").val(rs[0]['documento']);
			$("#celular").val(rs[0]['celular']);
			$("#comentario").val(rs[0]['comentario']);
			$('#servicio').val(rs[0]['servicio']).prop('selected', true);
			$("#servicio option[value='"+ rs[0]['servicio'] +"']").attr("selected", true);
			$("#vin").val(rs[0]['vin']);
			$("#vehiculo").val(rs[0]['vehiculo']);
			$("#kilometraje").val(rs[0]['km']);
			$("#marca").val(rs[0]['marca']);
			$("#modelo").val(rs[0]['modelo']);
			$("#color").val(rs[0]['color']);
		})


		// $("#nombre").val(cliente);
		// $("#documento").val(documento);
		// $("#celular").val(celular);
		// $("#comentario").val(comentario);
		// $('#servicio').val(servicio).prop('selected', true);
		// $("#servicio option[value='"+ servicio +"']").attr("selected", true);
		// //fco enviar id ficha para cancelar por debajo.
		var funcion = $("#boton_ins1").attr("onClick");
		console.log(funcion);
		funcion = funcion.replace("-1" , ficha.toString() );
		$("#boton_ins1").attr("onClick", funcion );
	}
	
	function configUsuarios(){
		//fco recuperar datos de horarios para el tablero 
		var jqxhr1 = $.ajax( { method: "POST", url: 'inc/procesos.php', data: { accion: "configUsuarios" }, dataType: 'json', encoding:"ISO-8859-1"});
		jqxhr1.done(function(rs) { //recuperar datos de turnos 
			console.log(rs);
			var html = '<form id="abmUsuarios">'+
						'	<div class="form-group">'+
						'		<input readonly type="text" name="id" class="form-control" id="id" placeholder="Codigo"><span id="help1" class="label label-danger"></span>'+
						'	</div>'+
						'	<div class="form-group">'+
						'		<input type="text" name="nombre" class="form-control" id="nombre" placeholder="Nombre empleado"><span id="help2" class="label label-danger"></span>'+
						'	</div>'+
						'	<div class="form-group">'+
						'		<input type="text" name="usuario" class="form-control" id="usuario" placeholder="Usuario del sistema"><span id="help3" class="label label-danger"></span>'+
						'	</div>'+
						'	<div class="form-group">'+
						'		<input type="password" name="password" class="form-control" id="password" placeholder="password"><span id="help4" class="label label-danger"></span>'+
						'	</div>'+
						'	<div class="form-group">'+
						'		<div class="input-group">'+
						'			<span class="input-group-addon">Tipo:</span>'+
						'			<select name="tipousuario" id="tipousuario" class="form-control">'+
						'				<option value="1">Administrador</option>'+
						'				<option value="2">Callcenter</option>'+
						'				<option value="3">Asesor</option>'+
						'				<option value="3">Tecnico</option>'+
						'				<option value="4">Repuestos</option>'+
						'			</select> '+
						'		</div>'+
						'	</div>'+
						'	<div class="form-group">'+
						'		<div class="input-group">'+
						'			<span class="input-group-addon">Estado:</span>'+
						'			<select name="estado" id="estado" class="form-control">'+
						'				<option value="1">Activo</option>'+
						'				<option value="0">Inactivo</option>'+
						'			</select> '+
						'		</div>'+
						'	</div>'+
						'	<div class="form-group">'+
						'   <button type="button" class="btn btn-default pull-right" onclick="consultar()" data-dismiss="modal">Cancelar</button>'+
						'   <button id="boton_ins" style="margin-right:5px;" type="button" class="btn btn-primary pull-right" onClick="abmUsuarios(1)">Insertar</button>'+
						'	</div>'+
						'</form>'+
					   '<div class="table-responsive">'+
						'<br><br><div class="form-group"><div class="input-group" id="buscador">'+
						'<span class="input-group-addon"><span class="badge" id="cant-filas"></span> Buscar:</span> <input type="text" onchange="oheka( @usuarios@ ,this.value);" name="buscar" class="form-control" id="buscar" placeholder="Buscar... "> '+
						' </div></div>'+

					   '<table class="table table-hover" sytle="text-align:center;" id="usuarios">'+
					   '<thead> <th>Empleado</th> <th>Usuario</th> <th>Tipo</th> <th>Estado</th> </thead>'+
					   '<tbody> ' ;
			$("#titulo").html("USUARIOS: " );
			$("#pie").remove();
			rs.forEach( function ( rs2 ){
				html = html + '<tr> <td>'+ rs2["nombre"] +'</td> <td>'+ rs2["usuario"] +'</td> <td>'+ rs2["tipo"] +'</td> '+ ( ( rs2["estado"] == 1) ? '<td class="text-success"> Activo' : '<td class="text-danger"> Inactivo') +'</td> <td> <a href=" javascript:recuperarUsuario('+ rs2["id"] +',@'+ rs2["nombre"] +'@, @'+ rs2["usuario"] +'@, @'+ rs2["contrasena"] +'@, @'+ rs2["privilegios"] +'@, '+ rs2["estado"] + ' )"> <span class="label label-primary"><span class="glyphicon glyphicon-edit"></span></span> </a> </td> </tr>';
			});
			html = html + '</tbody> </table></div>'
			html = html.replace(/@/g, "'"); //fco reemplazar todos los @ por ' cuando es string para pasar argumentos en funciones 
			$("#msj").html(html);
			$("#myModal").modal({backdrop: "static"});
			$("#cant-filas").html(rs.length);
		});
	}

	function abmUsuarios(evento){
		if ( $.trim( $( "#nombre").val()) === "" ) {
			$( "#help2" ).text( "Ingrese un Nombre de empleado..." ).show().fadeOut( 5000 ); return;
		}else if ($.trim( $( "#usuario").val()) === ""){
			$( "#help3" ).text( "Ingrese un Usuario..." ).show().fadeOut( 5000 ); return;
		}else if ($.trim( $( "#password").val()) === ""){
			$( "#help4" ).text( "Ingrese un Password..." ).show().fadeOut( 5000 ); return;
		}
		console.log($("#abmUsuarios").serialize());
		var serial = $("#abmUsuarios").serialize();
		var jqxhr1 = $.ajax( { method: "POST", url: 'inc/procesos.php', data: { accion: "abmUsuarios", serial: serial , evento: evento }, dataType: 'json', encoding:"ISO-8859-1"});
		jqxhr1.done(function(rs) { //recuperar datos de turnos 
			console.log(rs);
			alert("Registro Grabado !!!");
			configUsuarios();
		})
		.fail(function(jqxhr1, textStatus, error) {
			var err = textStatus + ", " + error;
			alert("Request Failed: " + err);
			console.log( "Request Failed: " + err );
		});
	}

	function recuperarUsuario(id , nombre, usuario, password , tipo , estado ){
		$("#boton_ins").removeAttr("onclick");
		$("#boton_ins").attr("onclick", "abmUsuarios(2)");
		$("#boton_ins").html("Modificar");
		
		$("#id").val(id);
		$("#nombre").val(nombre);
		$("#usuario").val(usuario);
		$("#password").val(password);
		
		$('#estado').val(estado).prop('selected', true);
		$("#estado option[value="+ estado +"]").attr("selected", true);
		$('#tipousuario').val(tipo).prop('selected', true);
		$("#tipousuario option[value="+ tipo +"]").attr("selected", true);
	}
	
	function vistaHorarios(){
		//fco recuperar datos de horarios para el tablero 
		var sucursal = $("#sucursal :selected").val();
		var jqxhr1 = $.ajax( { method: "POST", url: 'inc/procesos.php', data: { accion: "vistaHorarios", sucursal: sucursal }, dataType: 'json', encoding:"ISO-8859-1"});
		jqxhr1.done(function(rs) { //recuperar datos de turnos 
			console.log('HORARIOS ... ', rs);
			var html = "";
			rs.forEach( function ( rs2 ){
				html = html + rs2["html"];
			});
			$("#horario").empty();
			$("#horario").html( html );

		})
		.then((e)=>{
			//bloquearHorario();
		})
		;
	}
	
	function vistaCupos(){
		//fco recuperar datos de horarios para el tablero 
		var sucursal = $("#sucursal :selected").val();
		var jqxhr1 = $.ajax( { method: "POST", url: 'inc/procesos.php', data: { accion: "vistaCupos" ,sucursal: sucursal }, dataType: 'json', encoding:"ISO-8859-1"});
		jqxhr1.done(function(rs) { //recuperar datos de turnos 
			console.log('vistacupos ', rs);
			var html = "";
			rs.forEach( function ( rs2 ){
				html = html + rs2["html"];
				html = html.replace(/%/g, "'");
			});
			$("#cupos").empty();
			$("#cupos").html(html);
			$(".f-asesor").css('background','#5F9EA0')
			datosTablero();
			
		})
		.then((e)=>{
			setTimeout(() => {
				bloquearHorario();
			}, 800);
		});
	}
	function vistaTurnos(){
		//fco recuperar datos de horarios para el tablero 
		var sucursal = $("#sucursal :selected").val();
		var jqxhr1 = $.ajax( { method: "POST", url: 'inc/procesos.php', data: { accion: "vistaTurnos" , sucursal: sucursal }, dataType: 'json', encoding:"ISO-8859-1"});
		jqxhr1.done(function(rs) { //recuperar datos de turnos 
			console.log(rs);
			var html = "" ;
			var pre = '<th colspan="1" rowspan="2" style="width:100px;">&nbsp;<span class="glyphicon glyphicon-fullscreen"></span>&nbsp;</th>';
			rs.forEach( function ( rs2 ){
				html =  html + rs2["html"];
			});
			$("#turnos").empty();
			$("#turnos").html(pre + html);
		})
		.fail(function(jqxhr1, textStatus, error) {
			var err = textStatus + ", " + error;
			alert("Request Failed: " + err);
			console.log( "Request Failed: " + err );
		});
	}

	function vistaSucursales(){
		//fco recuperar datos de horarios para el tablero 
		var jqxhr1 = $.ajax( { method: "POST", url: 'inc/procesos.php', data: { accion: "vistaSucursales" }, dataType: 'json', encoding:"ISO-8859-1"});
		jqxhr1.done(function(rs) { //recuperar datos de turnos 
			console.log(rs);
			var html = "";
			rs.forEach( function ( rs2 ){
				html = html + '<option value="'+ rs2["id"] +'">'+ rs2["nombre"] +'</option> ';
			});
			$("#sucursal").empty();
			$("#sucursal").html( html );
		});
	}
	

	function setCookie(cname,cvalue,exdays) {
		var d = new Date();
		d.setTime(d.getTime() + (exdays*24*60*60*1000));
		var expires = "expires=" + d.toGMTString();
		document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
	}

	function getCookie(cname) {
		var name = cname + "=";
		var decodedCookie = decodeURIComponent(document.cookie);
		var ca = decodedCookie.split(';');
		for(var i = 0; i < ca.length; i++) {
			var c = ca[i];
			while (c.charAt(0) == ' ') {
				c = c.substring(1);
			}
			if (c.indexOf(name) == 0) {
				return c.substring(name.length, c.length);
			}
		}
		return "";
	}

	function checkCookie() {
		var sucuCookie=getCookie("sucursal");
		if (sucuCookie !== "") {
			alert("Welcome again " + sucuCookie);
		} else {
			setCookie("sucursal", 1 , 30);
		   //user = prompt("Please enter your name:","");
		   //if (user != "" && user != null) {
			//   setCookie("username", user, 30);
		   //}
		}
	}
	
	function buscarVehiculo(ele){

var value = $(ele).val().toUpperCase();
var myid = "";
if($( "div:contains('" + value + "')" ).length > 0 ){
	myid = $( "div:contains('"+ value +"')" )[6].id;
	console.log(myid);
	if (myid.length > 0 ){
		$("[href='#"+ myid +"']").trigger( 'click' );
		console.log(value);
		if (value.length > 1){
			$( "a:contains('" + value + "')" ).css("background-color", "yellow");
			$( "a:not(:contains('" + value + "'))" ).css("background-color", "");
			console.log($("a[style*='yellow']").length);
			//control solo si elige un modelo deberia habilitar el boton aceptar 
			if ($("a[style*='yellow']").length == 1 ){
				$("button[onClick='Setvehiculo()']").removeAttr("disabled");
			}else {
				$("button[onClick='Setvehiculo()']").attr("disabled", "disabled");
			}	
		}else if (value.length == 0 ){
			$("a").removeAttr('style');
		}
	}else {
		   $("a").removeAttr('style');
	}    
}
}

function Setvehiculo(){
if ($("#buscar").val().toUpperCase().trim().length == 0 ){
	alert('Debe seleccionar un Vehiculo !!!');
	$("button[onClick='Setvehiculo()']").attr("disabled", "disabled");
	return;
}
var value = $("#buscar").val().toUpperCase();
console.log('setear vehiculo :' + value);
var vehiculo = $( "#myModal2 a:contains('"+ value +"')" ).text().trim();
var color =    $("button[onClick='set(this)']").has('i').text().trim().toUpperCase(); //setea el color del auto

if($("button[onClick='set(this)']").has('i').length  == 0 ){
	alert("Debe elegir un color de vehiculo !!");
	return ;
}

console.log(vehiculo);
$("#marca").val("CHANGAN"); //setea el auto 
$("#vehiculo").val(vehiculo); //setea el auto 
$("#modelo").val(vehiculo); //setea el auto 
$("#color").val(color);
$("#myModal2").modal('hide');
$("#buscar").val("");
$("a").removeAttr('style');
$("button[onClick='set(this)']").children('i, br').remove();

}

function SeleccionarVehiculo(ele){
$("button[onClick='Setvehiculo()']").removeAttr("disabled");
$("a").removeAttr('style');
$(ele).css("background-color", "yellow");
console.log($(ele).text().trim());
$("#buscar").val($(ele).text().trim());
$("#modelo").val($(ele).text().trim());

}

function set(ele){
$("button[onClick='set(this)']").children('i, br').remove();
//$("button").children('i, br').remove();
$(ele).append( '<br><i class="fa fa-check" style="font-size:24px;"></i>');
}




</script>
</body>
</html>
