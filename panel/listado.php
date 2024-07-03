<?php 				

session_start();

?>
<!doctype html>
<html>
<head>
<meta charset="iso-8859-1">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
d 
<!-- JAVASCRIPT Y CSS PARA EL BOOTSTRAP -->
<script src="../js/jquery.js"></script> <!--jQuery JavaScript Library v1.11.0-->

<script src="../js/bootstrap.js"></script>
<script src="../js/bootstrap.min.js"></script>
<script src="../js/bootstrap-datepicker.js"></script>

<link href="../css/datepicker.css" rel="stylesheet">
<link href="../css/bootstrap.css" rel="stylesheet">
<!--<link href="css/bootstrap.css.map" rel="stylesheet">-->
<link href="../css/bootstrap.min.css" rel="stylesheet">
<link href="../css/bootstrap-theme.css" rel="stylesheet">
<!--<link href="css/bootstrap-theme.css.map" rel="stylesheet">-->
<link href="../css/bootstrap-theme.min.css" rel="stylesheet">

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
function actualizarFicha(uso, ficha)
{
 	//uso:
	//confirmar
	//cancelar
	var idficha 		= $("#idficha"+ficha).val();
  	accion = uso;
 	var respuesta = $.ajax({
				url: "../inc/procesos.php",
				global:true,
				type: "POST",
				data: "accion="			+accion+
					  "&idficha="		+idficha,
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
						if (resdatos[0] == 'ok')
						{
							 recargar();
						}
				 
					/*	if (datos == 'ok')
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
function recargar() 
{
window.location.reload();	
}
</script> 
<title>Reservas</title>
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
          <a class="navbar-brand" href="#">Reservas </a>
        </div>
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li><a href="../index.php">Inicio</a></li>
            <li><a href="../cupo.php">Agendar servicio</a></li>
            <li class="active"><a href="../panel.php">Panel Administrativo</a></li>
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

<div class="container theme-showcase" role="main"><br>
<br>
Bienvenido, <?php echo $_SESSION['usuario'];?>
 <h2>Administracion</h2>
 <div class="tabbable">
     <ul role="menu" class="nav nav-tabs">
         <li role="menuitem" class="active"><a href="#tab_1" tabindex="-1" data-toggle="tab">Listado de reservas</a></li>
         <li role="menuitem" class=""><a href="#tab_2" tabindex="-1" data-toggle="tab">Filtro 2</a></li>
         <li role="menuitem" class=""><a href="#tab_3" tabindex="-1" data-toggle="tab">Filtro 3</a></li>
    </ul>
     <div class="tab-content">
      	 <!--Seccion 1-->
       <div class="tab-pane fade active in" id="tab_1"> 
            <div class="view">
                    <table contenteditable="true" class="table">
                  <thead>
                    <tr>
                      <th>Turno</th>
                      <th>Fecha</th>
                      <th>Hora</th>
                      <th>Responsable</th>
                      <th>Cliente</th>

                      <th>Documento</th>
                      <th>Celular</th>
                      <th>KM</th>
                      <th>Vehiculo</th>
                      <th>Servicio</th>

                      <th>Comentario</th>
                      <th>Estado</th>
                      <th>Solicitud</th>
                      <th>Respuesta</th>
                      <th>Acciones</th>
 
                    </tr>
                  </thead>
                  <tbody>
            <?php 
 			$host 		= 'localhost';
			$puerto 	= '5432';
			$contrasena = 'nautilus';
			$usuario	= 'postgres';
			$db			= 'reservas';

			$con	= pg_connect("host=$host port=$puerto password=$contrasena user=$usuario dbname=$db") or die('No se pudo conectar');
			$q		= "select * from fichas order by estado asc, fecha asc, hora asc";
			$exq	= pg_query($con, $q);
 			
			while($res=pg_fetch_array($exq)){
				
			switch ($res[12]){
				case '0':
						$stat = "active";
						$cstat = "Pendiente";
				break;	
				case '1':
						$stat = "success";
						$cstat = "Confirmado";
				break;	
				case '2':
						$stat = "danger";
						$cstat = "Cancelado";
				break;	
				case '3':
						$stat = "warning";
						$cstat = "Observacion";
				break;	
			}
		?>
       	<tr class="<?php echo $stat; ?>">
         <input type="hidden" id="idficha<?php echo $res[0]; ?>" value="<?php echo $res[0]; ?>">
          <td><?php echo $res[1]; ?></td>
          <td><?php echo $res[2]; ?></td>
          <td><?php echo $res[3]; ?></td>
          <?php
 			$qnombre	= "select * from funcionarios where documento ='".trim($res[4]) ."'";
 			$exqnombre	= pg_query($con, $qnombre);
			$resqnombre	=pg_fetch_array($exqnombre)
		   ?>
          <td><?php echo $resqnombre['nombre'];?></td>
          <td><?php echo $res[5]; ?></td>

          <td><?php echo $res[6]; ?></td>
          <td><?php echo $res[7]; ?></td>
          <td><?php echo $res[8]; ?></td>
          <td><?php echo $res[9]; ?></td>
          <td><?php echo $res[10]; ?></td>

          <td><?php echo $res[11]; ?></td>
          <td><?php echo $cstat; ?></td>
          <td><?php echo $res[13]; ?></td>
          <td><?php echo $res[14]; ?></td>
          <td>
          
          <button class="btn btn-xs btn-success<?php if ($stat == "success") echo " disabled"; ?>" 
          contenteditable="true" type="button" onClick="actualizarFicha('actualizar','<?php echo $res[0]; ?>');">Confirmar</button>
          <button class="btn btn-xs btn-danger" contenteditable="true" type="button" onClick="actualizarFicha('cancelar','<?php echo $res[0]; ?>');">Cancelar</button>
          <button class="btn btn-xs btn-info<?php if ($stat == "warning") echo " disabled"; ?>" contenteditable="true" type="button" onClick="actualizarFicha('cerar','<?php echo $res[0]; ?>');">Pendiente</button>
          </td>
 		</tr>     
         <?php
 
		 }
		?>  
             </tbody>
            </table>
            </div> 
           </div>
         <!--Seccion 2-->
       <div class="tab-pane fade" id="tab_2"> 
	 
       </div>
            
         <!--Seccion 3-->
         <div class="tab-pane fade" id="tab_3"> 
       </div>
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
