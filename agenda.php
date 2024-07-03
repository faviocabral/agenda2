<?php 				

session_start();

if (!isset($_SESSION['usuario']))
{
	//header("location:index.php");
}
include("inc/conexion.php");
?>
<!doctype html>
<html><head>
<meta charset="utf-8">
<link rel="shortcut icon" href="clip.ico">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="Reservas para services de mantenimientos">
<meta name="author" content="Software">
<meta name="keywords" content="Reservas, Mantenimiento, Vehiculo, Reparacion, Agenda, Ticket, Turno" /> 
  
<!-- JAVASCRIPT Y CSS PARA EL BOOTSTRAP -->
<script src="js/jquery.js"></script> <!--jQuery JavaScript Library v1.11.0-->

<script src="js/bootstrap.js"></script>
<!--<script src="js/bootstrap.min.js"></script> --> <!--COMENTADO POR DUPLICIDAD-->
 
<script src="js/bootstrap-tooltip.js"></script>
<script src="js/bootstrap-popover.js"></script> 


<script src="js/glDatePicker.min.js"></script>
 
<link href="css/glDatePicker.default.css" rel="stylesheet" >


<link href="css/datepicker.css" rel="stylesheet"> <!--No necesario-->
<link href="css/bootstrap.css" rel="stylesheet">
<!--<link href="css/bootstrap.css.map" rel="stylesheet">-->
<!--<link href="css/bootstrap.min.css" rel="stylesheet">-->			<!--COMENTADO POR DUPLICIDAD-->
<!--<link href="css/bootstrap-theme.css" rel="stylesheet">-->		<!--COMENTADO POR DUPLICIDAD-->
<!--<link href="css/bootstrap-theme.css.map" rel="stylesheet">-->
<link href="css/bootstrap-theme.min.css" rel="stylesheet">

<link href="css/bootstrap-social.css" rel="stylesheet">


<script >

function ReloadPage() {
	location.reload();
};

$(document).ready(function() {
	setTimeout("ReloadPage()", 10000); 
});
		
						
 	var today = new Date();
	var dd = today.getDate();
	var mm = today.getMonth()+1; //January is 0!
	var yyyy = today.getFullYear();
	var datelimit = new Date(today);
	datelimit.setDate(today.getDate() + 9);
	//alert(today);
 	var marcarDia ;
//	 marcarDia = '30/05/2014';
//	 marcarDia = new Date(2014, 5, 30);
 
   //	today = yyyy+'/'+mm+'/'+dd;

 $(window).load(function()
{

//alert(marcarDia);
	$('#mydate').glDatePicker(
	{
		showAlways: false,
		onShow: function(glDatePicker) { glDatePicker.slideDown(''); },
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
		selectableDateRange: [{
			from: today,
			to: datelimit
		}, ],
		dowOffset: 1,
		// Hide the calendar when a date is selected (only if showAlways is set to false).
		hideOnClick: true,
 		selectableYears: [2014, 2015],
		selectableMonths: [0, 1 , 2 , 3 , 4,5,6, 7,8,9,10, 11],
		selectableDOW: [1,2,3, 4, 5, 6],
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
			var z  = date.getDate() + '/' +
                (date.getMonth() + 1) + '/' +
                date.getFullYear();
            target.val(z);
			$("#formFecha").submit()  
//            if(data != null) {
//                alert(data.message + '\n' + date);
//            }
        } 
		 

		 
 /*
 		onClick:function ()
		{
			alert(
			  $(this).val()
			);
		}*/
	
	});
	
	
});
 
 
 

function manejarFicha(accion, xficha, xfecha, xcolumna, xcupo, nombre, ci, celular, servicio, comentario, oldData, objeto)
{
//	accion:
//	nuevaFicha
//	eliminarFicha
//  alert(accion+' _ '+xficha+' _ '+xfecha+' _ '+xcolumna+' _ '+ xcupo);
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
						// alert(datos);
						 var resdatos;
 						 resdatos = datos.split("*tab*");
 						 if(resdatos[0] == 'ok')
						 {
						 	//window.location.href = "cupo.php?fecha="+xfecha;
							// Distribuir los valores recuperados del ajax luego del "insert"
							var zficha 			= resdatos[1];
							var zfecha 			= resdatos[2];
							var zcolumna 		= resdatos[3];
							var zcupo 			= resdatos[4];
							var zhora_selec 	= resdatos[5];
							var znombre 		= resdatos[6];
							var zidfunc 		= resdatos[7];
							var zdocumento 		= resdatos[8];
							var zcelular		= resdatos[9];
							var zservicio 		= resdatos[10];
							var zhora_solicitud = resdatos[11];
							var zcomentario 	= resdatos[12];
							
							var zz = zcupo+zcolumna;
							
 							// Quitar formulario de nueva ficha para esta celda y generar nuevo codigo HTML
						 	$("#popover-head"+zz).html('');
						 	$("#popover-content"+zz).html(
													'<div id="nuevoFormulario">'+
													'<input type="hidden" id="xficha"  	value="'+zficha+'" />'+
													'<input type="hidden" id="xcolumna"  value="'+zcolumna+'" />'+
													'<input type="hidden" id="xcupo" 	value="'+zcupo+'" />'+
													'<input type="hidden" id="xfecha" 	value="'+zfecha+'" />'+
													'<div class="delData" id="cont_accion'+zz+'">'+
													'<button type="button" id="button_accion'+zz+'" class="btn btn-danger" value="Get">Eliminar</button> '+ 
													'</div>'+
													'</div>'
													);
 							$('#celda'+zz).popover('destroy');
   							//$('.btn-flickr').tooltip({placement:'top'});

							
							// Valores solo para el Tooltip
 							var newValue=   '<div style="text-align:left;">'+znombre+'<br>'+ 
											'<span style="font-size:11px;">Cel:</span>'+zcelular+'<br>'+  
											'<span style="font-size:11px;">Doc:</span>'+zdocumento+'<br>'+  
											'<span style="font-size:11px;">Comentario:</span><br>'+zcomentario+'</div>';
											
											// FUNCIONA para colocar los botones y los divs pero se volvera a imprimir de cero
											//'<div id="cont_accion'+zz+'" class="delData">'+					
											//'<button type="button" id="" class="btn btn-danger" value="Get">Eliminar</button>  '+
											//'</div>';
											//--------------------------------------------------------------------------------

// 							objeto.closest("#nuevoFormulario").find("#xficha","input[type=text], value")   .val(zficha+zcelular);
//							objeto.closest("#nuevoFormulario").find("#xficha","input[type=text], value")   .val(zficha+zcelular);
//							objeto.closest("#nuevoFormulario").find("#xfecha","input[type=text], value")   .val(zfecha+zcelular);
//							objeto.closest("#nuevoFormulario").find("#xcolumna","input[type=text], value")   .val(zcolumna+zcelular);
// 							objeto.closest("#nuevoFormulario").find("#xcupo","input[type=text], value")   			.val(zcupo+zcelular);
//							objeto.closest("#nuevoFormulario").find("#nuevoNombre","input[type=text], value")   	.val(znombre+zdocumento);
//							objeto.closest("#nuevoFormulario").find("#nuevoDocumento","input[type=text], value")   .val(zdocumento);
//							objeto.closest("#nuevoFormulario").find("#nuevoCelular","input[type=text], value")   	.val(zcelular);
//							objeto.closest("#nuevoFormulario").find("#nuevoServicio","input[type=text], value")   	.val(zservicio);
//							objeto.closest("#nuevoFormulario").find("#nuevoComentario","input[type=text], value")  .val(zcomentario);
// 						//	$("#popover-content"+zz).closest("#nuevoFormulario").find("#cont_accion"+zz) .removeClass('getData').addClass('delData');
 							
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
 									.attr('onclick','eliminar("'+zcupo+'","'+zcolumna+'","'+zz+'")')
									.attr('data-original-title', newValue)
									.tooltip('fixTitle')
 									.html(    											//OK
												'<div class=cd-nombre style=max-height:42px;>'+znombre+'</div>'+
												'<div class=cd-servicio>'+zservicio+'</div>'
							);
															 
 						 }else{
							$('#error-nuevaFicha').html(resdatos[0]);
						 }
						},							
					}
				).responseText;
		}else{
	
			alert('Debe completar los campos requeridos');
	//		$("#celda"+xcupo+xcolumna).html(    	
//											'<div class="cd-nombre" style="height:42px; "> <br>Libre</div>'+
//											'<div class="cd-servicio">&nbsp;</div>' 
//											) 
//			 						 		.attr('class', 'btn-success');
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
																$(this).attr('class', 'btn-success');
															})
															.attr('class', 'btn-success')						// OK
															.attr('data-toggle', ''	)				  			// OK
															.attr('rel', '')									// OK
															.data( 'html', false ) 								// OK
															.attr('data-original-title', 'Nuevo Registro')
															//.attr('onclick','inicial("'+xcupo+'","'+xcolumna+'","'+xcupo+xcolumna+'")')
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
 var mx; 
 var my;
 
function eliminar(i, j , y)
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
 
function inicial(i, j , x)
{
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
					});
	
	$(document).on("click", "#close"+x, function () 
		{
		$("#celda"+x).popover('hide');
		}
	);
 
}

  
$(function() {
 
 $('.btn-warning').tooltip({placement:'top'});
 $('.btn-primary').tooltip({placement:'top'});
 $('.btn-danger').tooltip({placement:'top'});
 $('.btn-flickr').tooltip({placement:'top'});
 
// Proceso para eliminar una Ficha 
		$(document).on("click", ".delData", function () {
		var ctlInputxficha 		= $(this).closest("#nuevoFormulario").find("#xficha").val();
		var ctlInputxfecha 		= $(this).closest("#nuevoFormulario").find("#xfecha").val();
		var ctlInputxcolumna	= $(this).closest("#nuevoFormulario").find("#xcolumna").val();
		var ctlInputxcupo 		= $(this).closest("#nuevoFormulario").find("#xcupo").val();
		var objeto 				= $(this);
		$("#celda"+ctlInputxcupo+ctlInputxcolumna).popover('hide');
		$("#celda"+ctlInputxcupo+ctlInputxcolumna).html('<img style="padding-top:20px;padding-left:37px" src="img/loading-flickr.png" border="0" /> ');
		
//		alert(
//							'ficha:'+ctlInputxficha+
//							'fecha:'+ctlInputxfecha+
//							'columna:'+ctlInputxcolumna+
//							'xcupo:'+ctlInputxcupo
//		);
		
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
.tit-turno{		float:left; width:202px; text-align:center; margin:1px 6px 1px 1px; padding-top:3px; background-color:#3470B1; color:#FFF; height:30px; font-size:18px}
.tit-turno-fin{ float:left; width:202px; text-align:center; margin:1px 1px 1px 1px; padding-top:3px; background-color:#3470B1; color:#FFF; height:30px; font-size:18px}

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
 
</style>
<title>Reservas</title>
</head>

<body >
 <div class="navbar navbar-inverse navbar-fixed-top hide" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">Reservas</a>
        </div>
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li><a href="index.php">Inicio</a></li>
            <li class="active"><a>Ver Agenda</a></li>
            <li><a href="cupo.php">Turnos disponibles</a></li>
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
        <div style="float:right; padding-top:15px; text-align:right"> 
  <span style="color:#FFF"><?php echo $_SESSION['nombre'].", ".$_SESSION['tipo']; ?></span>, <a href="cerrar.php"> cerrar sessi&oacute;n</a><br>
 <span class="text-danger" style="font-size:10px">Kia la Victoria</span> 
</div>
  
        </div><!--/.nav-collapse -->
      </div>
    </div>
   <div class="container theme-showcase" role="main" >
 	<span style="padding-bottom:10px" >&nbsp;</span> 
 <div id="error-nuevaFicha" class="alert-danger"></div>
<div class="clear"></div>	
 <div class="tabbable">
        <div class="tab-pane fade active in" id="tab_1"><p>
		<?php
function validateDate($date, $format = 'd/m/Y')
{
	$d = DateTime::createFromFormat($format, $date);
	return $d && $d->format($format) == $date;
}
// ------- Comprobar fecha ingresada
//$b_fecha = trim($_POST['fechaelegida']);
//$b_hora  = trim($_POST['horaelegida']);

//$b_fecha = $_GET['fecha'];
if (!empty($_GET['fecha']))
{
	$b_fecha = $_GET['fecha']; 
}else{
	if (!empty($b_fecha))
	{
		$check_fecha = validateDate($b_fecha);
		if ($check_fecha == "1")
		{
			$b_fecha = date("d/m/Y"); 
			$mensaje = "Error al ingresar fecha";
		}else{
			
		}
	}else{
		$mensaje = "";
		$b_fecha = date("d/m/Y");
	}
}
 
?>
		  <fieldset>
            <legend class="hidden"> Fecha actual:
                <span style="color:#900; font-size:16px; font-family:Verdana, Geneva, sans-serif">
                	<?php echo $b_fecha ;  ?>
                </span>
 			</legend><?php echo $mensaje ; ?>
 		<div class="well">
 <form action="agenda.php" method="post" id="formFecha" >
 <table style="margin-bottom:5px" width="100%">
      <tr>
       <td width="91%">
           
         	<input type="text" id="mydate" readonly required class="form-control hide" name="fechaelegida" style=" width:100px; margin-left:26px; position: relative;cursor:pointer" value="<?php echo trim($b_fecha); ?>"/> 
      <!--  <label for="horaelegida">Hora</label>
            <select name="horaelegida" id="horaelegida">
            	<option value="" selected></option>
                <option value="0">07:30 hs</option>
                <option value="1">08:00 hs</option>
                <option value="2">08:30 hs</option>
                <option value="3">09:00 hs</option>
                <option value="4">09:30 hs</option>
                <option value="5">10:00 hs</option>
                <option value="6">10:30 hs</option>
                <option value="7">11:00 hs</option>
                <option value="8">11:30 hs</option>
                <option value="9">12:00 hs</option>
                <option value="10">12:30 hs</option>
                <option value="11">13:00 hs</option>
            </select>-->
            <input type="submit" name="traeFecha" id="traeFecha" value="Buscar" style="display:none"> 
            
          </td>
       <td width="9%" align="right"><button type="button" class="btn btn-lg btn-info"  onClick="window.location.href='cupo.php'"> <span class="glyphicon glyphicon-log-in" ></span></button>
        </td>
       </tr>
  </table>
 </form>
<!--Titulos de turnos-->
<div class="tit-turno-fix">&nbsp;</div>
<div class="tit-turno">Turno 1</div>
<div class="tit-turno">Turno 2</div>
<div class="tit-turno">Turno 3</div>
<div class="tit-turno">Turno 4</div>
<div class="tit-turno">Turno 5</div>
<div class="tit-turno-fin">Turno 6</div>
<div class="clear"></div>
 
<!--Titulos para los horarios-->
<div class="tit-hora-fix">&nbsp;</div>
<div class="tit-hora1"> 7:30</div>
<div class="tit-hora1"> 7:45</div>
<div class="tit-hora2"> 8:00</div>
<div class="tit-hora1"> 8:15</div>
<div class="tit-hora2"> 8:30</div>
<div class="tit-hora1"> 8:45</div>
<div class="tit-hora2"> 9:00</div>
<div class="tit-hora1"> 9:15</div>
<div class="tit-hora2"> 9:30</div>
<div class="tit-hora1"> 9:45</div>
<div class="tit-hora2">13:00</div>
<div class="tit-hora1">13:15</div>
<div class="clear"></div>



<!--------------------------------- SCRIPT TURNOS --------------------------------->
<!------------------------------------- CUPO 1 ----------------------------------->
 
<?php

// -------------- TRAER DATOS DEL DIA

$q		= "select * from fichas where fecha = '$b_fecha' and estado <> '0' ";
$exq	= pg_query($con, $q);

// -------------- TRAER NOMBRES DE FUNCIONARIOS

$q		= "select * from funcionarios order by id_funcionario asc";
$exf	= pg_query($con, $q);
$grilla_funcionarios = array();
 	while ($ref	= pg_fetch_array($exf))
	{
 		$grilla_funcionarios[$ref['id_funcionario']]['id_funcionario'] = $ref['id_funcionario'];
 		$grilla_funcionarios[$ref['id_funcionario']]['nombre']		= $ref['nombre'];
 		$grilla_funcionarios[$ref['id_funcionario']]['pantalla']	= $ref['pantalla'];
		$grilla_funcionarios[$ref['id_funcionario']]['corporativo']	= $ref['corporativo'];
		$grilla_funcionarios[$ref['id_funcionario']]['documento']	= $ref['documento'];
		$grilla_funcionarios[$ref['id_funcionario']]['documento']	= $ref['privilegios'];
//		echo $grilla_funcionarios[$ref['id_funcionario']]['nombre']."<br>";
	}
// -------------- Variables iniciales para la matriz
$columna[1] = 0;
$columna[2] = 0;
$columna[3] = 0;
$columna[4] = 0;
$columna[5] = 0;
$columna[6] = 0;
$columna[7] = 0;
$columna[8] = 0;
$columna[9] = 0;
$columna[10] = 0;
$columna[11] = 0;

$cupo = array();
$dia1 = array();
$cupo[0] = 0;

// -------------- CREAR UNA MATRIZ PARA VOLCAR TODOS LOS CUPOS DE LA FECHA SOLICITADA
 	while ($res	= pg_fetch_array($exq))
	{
		$columna  	= $res['columna'];
		$cupo	  	= $res['cupo'];
				
		// -------------- Cargar la matriz con cada registro recuperado
		$dia1[$columna][$cupo]['ficha']		= $res['id_ficha'];
		$dia1[$columna][$cupo]['fecha'] 	= $res['fecha'];
		$dia1[$columna][$cupo]['nombre'] 	= $res['nombre'];
		$dia1[$columna][$cupo]['servicio'] 	= $res['servicio'];
		$dia1[$columna][$cupo]['columna'] 	= $res['columna'];
		$dia1[$columna][$cupo]['cupo'] 		= $res['cupo'];
		$dia1[$columna][$cupo]['hora'] 		= $res['hora'];
		$dia1[$columna][$cupo]['celular'] 	= $res['celular'];
		$dia1[$columna][$cupo]['documento'] = $res['documento'];
		$dia1[$columna][$cupo]['comentario'] = $res['comentario'];
		$dia1[$columna][$cupo]['estado'] 	= $res['estado'];
		$dia1[$columna][$cupo]['id_funcionario'] = $res['id_funcionario'];
		$dia1[$columna][$cupo]['id_funcionario_atencion'] = $res['id_funcionario_atencion'];
		$dia1[$columna][$cupo]['hora_atencion'] = $res['hora_atencion'];

		// -------------- Siguiente cupo por cada columna
	}
 
 for ($i = 0; $i < 10; $i++) 
{
	?>
    <div class="tit-cupo"><?php echo $i+1; ?></div>
    <?php
 	for ($j = 0; $j < 12; $j++) 
	{
		// -------------- Verificar si la celda de la matriz contiene informacion. 
		// -------------- Si contiene, se muestra los datos de la base, sino, se
		// -------------- muestra libre y listo para cargar
//		$usarNombre	 	= $dia1[$j][$i]['nombre'];
//		$usarNombre = ucwords($usarNombre); // Coloca todo el texto en mayusculas
//		$usarNombre = ucwords(mb_strtolower($usarNombre,"UTF-8")); // Mayuscula en cada palabra 
//		$usarNombre = substr($usarNombre,0,18);

 		if (!empty($dia1[$j][$i]['ficha']) && $dia1[$j][$i]['estado'] != '0')
		{
			$usarFicha 		= $dia1[$j][$i]['ficha'];
			$usarNombre	 	= $dia1[$j][$i]['nombre'];
			$usarNombre = ucwords($usarNombre); // Coloca todo el texto en mayusculas
			$usarNombre = ucwords(mb_strtolower($usarNombre,"UTF-8")); // Mayuscula en cada palabra 
			$usarServicio 	= $dia1[$j][$i]['servicio'];
			$usarCelular 	= $dia1[$j][$i]['celular'];
			$usarDocumento 	= $dia1[$j][$i]['documento'];
			$usarComentario = $dia1[$j][$i]['comentario'];
			$usarFunAtencion= $dia1[$j][$i]['id_funcionario_atencion'];
			$usarHoraAtendido= $dia1[$j][$i]['hora_atencion'];
			
				$tooltiptext 	= 'rel="tooltip" data-html="true" title="<div style=text-align:left;overflow:hidden;>'.
										 $usarNombre. '<br>'. 
										'<span style=font-size:11px;>Cel: 		</span>'	.$usarCelular.		'<br>'.  
										'<span style=font-size:11px;>Doc: 		</span>'	.$usarDocumento.	'<br>'.  
										'<span style=font-size:11px;>Comentario:</span><br>'.$usarComentario.  	'</div>"'; 			
			
			if($dia1[$j][$i]['estado'] == '1')
			{
				$tipoboton1 	= 'btn-primary';
				$tipoboton2 	= 'btn-primary';

			}
			if($dia1[$j][$i]['estado'] == '2')
			{
//				$usarNombre = $dia1[$j][$i]['nombre'];
//				$usarNombre = ucwords($usarNombre); // Coloca todo el texto en mayusculas
//				$usarNombre = ucwords(mb_strtolower($usarNombre,"UTF-8")); // Mayuscula en cada palabra 
 				$tipoboton1 	= 'btn-warning';
				$tipoboton2 	= 'btn-warning';
 				$usarNombre	 	= '<div style="position:relative; width:96px; height:24px; font-size:11px; display:block; overflow:hidden;">'.$usarNombre.'..</div> ';
				$usarNombre	 	.= '<div style="position:relative; width:96px; font-size:16px;width:67px; display:block;">Atendido </div>';
				$usarServicio	=  '<div style="float:left; font-size:11px;width:67px; color:yellow;">'.substr($grilla_funcionarios[$usarFunAtencion]['pantalla'],0,18).'</div>';
				$usarServicio	.= '<span style="float:left; font-size:10px;color:yellow">'.substr($usarHoraAtendido,0,5).'</span>';
			}
 		}else{
			$usarFicha 		= "";
			$usarNombre 	= "<br><span style='color:LightSkyBlue '> Libre </span>" ;
			$usarServicio 	= "";	
			$tipoboton1 	= 'btn-info';
			$tipoboton2 	= 'btn-info';
			$tooltiptext 	= "";
  		}
		if($j % 2 == 0 && $j != 0){ $margen = "margin: 1px 1px 1px 6px";}else{$margen = "margin: 1px ";}
     ?>
	   <div id="celda<?php echo $i.$j; ?>" 
        			class="<?php echo $tipoboton1; ?>" 
                    style="float:left; width:100px; height:67px; padding:1px; cursor:pointer; <?php echo $margen;?>"
                    <?php //echo $habilitar; ?>
                    data-toggle="tooltip<?php echo $i.$j; ?>"
                     <?php echo $tooltiptext; ?>
        >
        
    	<div class="cd-nombre" style="max-height:42px; "> <?php echo $usarNombre ;	?></div>
		<div class="cd-servicio">						<?php echo $usarServicio ;	?></div>
	</div>             
  
            <div id="popover-head<?php echo $i.$j; ?>" class="hide" >
                Nueva Reserva
                <button type="button" class="close" id="close<?php echo $i.$j; ?>"
                data-dismiss="popover" aria-hidden="true">×</button>
            </div>
            <div id="popover-content<?php echo $i.$j; ?>" class="hide" >
            
            <?php if ($tipoboton1 == 'btn-flickr'){ ?>
                <div id="nuevoFormulario">
                    <input type="hidden" id="xficha"  	value="<?php echo $usarFicha; ?>" />
                    <input type="hidden" id="xcolumna"  value="<?php echo $j; ?>" />
                    <input type="hidden" id="xcupo" 	value="<?php echo $i; ?>" />
                    <input type="hidden" id="xfecha" 	value="<?php echo $b_fecha; ?>" />
                    <div class="delData" id="cont_accion<?php echo $i.$j; ?>">
                    <button type="button" id="button_accion<?php echo $i.$j; ?>" class="btn btn-danger" value="Get">Eliminar</button>  
                    </div>	
                 </div>
             <?php }
 			 if ($tipoboton1 == 'btn-info'){  ?>
                <div id="nuevoFormulario">
                    <input type="hidden" id="xficha"  	value="<?php echo $usarFicha; ?>" />
                    <input type="hidden" id="xcolumna" 	value="<?php echo $j; ?>" />
                    <input type="hidden" id="xcupo" 	value="<?php echo $i; ?>" />
                    <input type="hidden" id="xfecha" 	value="<?php echo $b_fecha; ?>" />
    
                    <input type="textbox" id="nuevoNombre" 		class="form-control" value="" placeholder="Nombre" /> 
                    <input type="textbox" id="nuevoDocumento" 	class="form-control" value="" placeholder="Documento"/> 
                    <input type="textbox" id="nuevoCelular" 	class="form-control" value="" placeholder="Celular"/> 
                    <textarea cols="20"   id="nuevoComentario"  class="form-control" rows="4" placeholder="Breve comentario" style="width:230px"></textarea>
                    <select 			  id="nuevoServicio" 	class="form-control" style="margin-bottom:5px;" >
                            <option value="Mantenimiento" selected>Mantenimiento</option> 
                            <option value="Express">Express</option> 
                            <option value="Servicio Gral.">Servicios Generales</option> 
                    </select>
                    <div class="getData" style="text-align:right" id="cont_accion<?php echo $i.$j; ?>">
                    <button type="button" id="button_accion<?php echo $i.$j; ?>" class="btn btn-primary" value="Get">Agendar</button>  
					</div>
                 </div>
             <?php }
			 
 			 if ($tipoboton1 == 'btn-warning'){  ?>
                <div id="nuevoFormulario">
                    <input type="hidden" id="xficha"  	value="<?php echo $usarFicha; ?>" />
                    <input type="hidden" id="xcolumna"  value="<?php echo $j; ?>" />
                    <input type="hidden" id="xcupo" 	value="<?php echo $i; ?>" />
                    <input type="hidden" id="xfecha" 	value="<?php echo $b_fecha; ?>" />
                    <div class="attData" id="cont_accion<?php echo $i.$j; ?>">
                    <button type="button" id="button_accion<?php echo $i.$j; ?>" class="btn btn-warning" value="Get">Atender</button>  
                    </div>	
                 </div>
             <?php }
			 
			  ?>
 
                </div>   
                        
 	<?php 
	}
	?><div class="clear"></div> <?php
}
?>
<div class="clear"></div>
 <!--------------------------------- FIN GRILLA DEL DIA --------------------------------->
 </div>
 </fieldset></p>
        
        
       </div>
            
   
 </div>
     
</div>     
 
      


</body>
</html>
