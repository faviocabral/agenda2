<?php 				

session_start();

if (!isset($_SESSION['usuario']))
{
 	header("location:index.php");
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<link rel="shortcut icon" href="clip.ico">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="Reservas para services de mantenimientos">
<meta name="author" content="Reservas">
<meta name="keywords" content="Reservas, Mantenimiento, Vehiculo, Reparacion, Agenda, Ticket, Turno" /> 
 
<!-- JAVASCRIPT Y CSS PARA EL BOOTSTRAP -->
<script src="js/jquery.js"></script> <!--jQuery JavaScript Library v1.11.0-->

<script src="js/bootstrap.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/bootstrap-datepicker.js"></script>

 
<link href="css/datepicker.css" rel="stylesheet">
 <link href="css/bootstrap.min.css" rel="stylesheet">
 <link href="css/bootstrap-theme.css" rel="stylesheet"> 
<!--<link href="css/bootstrap-theme.css.map" rel="stylesheet">
<link href="css/bootstrap-theme.min.css" rel="stylesheet">
 -->
<!--ANHADIDOS PARA PRUEBAS-->
<link href="css/bootstrap-responsive.css" rel="stylesheet">
<!--ANHADIDOS PARA PRUEBAS fin-->
	
<script >
/*    var nowTemp = new Date();
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
	*/
 function cambiarClave()
{
	if (condicion1 == 'ok' && condicion2 == 'ok'){
   	var usuario 	= $("#usuario").val();
 	var contrasena	= $("#clavenuevaconfirmar").val();
	
		accion ="cambiarClave";
		var respuesta = $.ajax({
					url: "inc/procesos.php",
					global:true,
					type: "POST",
					data: "accion="			+accion+
						  "&usuario="		+usuario+
						  "&contrasena="	+contrasena,
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
						 var resdatos;
				 		 resdatos = datos.split("*tab*");
 					 	 if (resdatos[0] == 'ok')
						 {
								$("#mensaje-sistema").addClass	(' alert alert-success');
								$('#mensaje-sistema').html('<span class="glyphicon glyphicon-ok"></span> Clave cambiada exitosamente');
								setTimeout(function(){window.location.href = "cupo.php"}, 1250);
 						 }else{
								$("#mensaje-sistema").addClass	(' alert alert-dismissable alert-danger');
								$('#mensaje-sistema').html('<span class="glyphicon glyphicon-alert"></span> Incorrecto '+resdatos[0]);
						 }
					},							
				}
			).responseText;
	}else{
			$("#mensaje-sistema").addClass	(' alert alert-dismissable alert-danger');
			$('#mensaje-sistema').html('<span class="glyphicon glyphicon-alert"></span>Datos ingresados incorrectos');
			$('#contrasena').focus()
		}
}

function confirmarIdentidad()
{
	var accion = 'confirmarIdentidad';
  	var usuario 	= $("#usuario").val();
 	var contrasena	= $("#contrasena").val();
  
 		var respuesta = $.ajax({
					url: "inc/procesos.php",
					global:true,
					type: "POST",
					data: "accion="			+accion+
						  "&usuario="		+usuario+
						  "&contrasena="	+contrasena,
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
						 var resdatos;
				 		 resdatos = datos.split("*tab*");
					 	 if (resdatos[0] == 'ok')
						 {
								$("#contrasena").addClass	(' alert alert-success');
								$("#contrasena").removeClass(' alert alert-danger');
								condicion1='ok';
							//window.location.href = "cupo.php";
						 }else{
								$("#contrasena").addClass	(' alert alert-danger');
								$("#contrasena").removeClass(' alert alert-success');
								condicion1='no';
						 }
					},							
				}
			).responseText;

}
var	condicion1='no';
var	condicion2='no';

function matchClave()
{
	$("#mensaje-sistema").removeClass	(' alert alert-dismissable alert-danger');
	$('#mensaje-sistema').html('');

	condicion2='no';
	if ($("#contrasena").val()=='')
	{
		$("#contrasena").removeClass(' alert alert-success');
		$("#contrasena").removeClass(' alert alert-danger');
	}
   	var clave1 	= ($("#clavenueva").val()).replace(/[^a-zA-Z 0-9.]+/g,' ');;
 	var clave2	= ($("#clavenuevaconfirmar").val()).replace(/[^a-zA-Z 0-9.]+/g,' ');;

 	clave1.length ;
	
	if (clave1 == '' || clave2== '')
	{
		$("#clavenueva").			removeClass(' alert-success');
		$("#clavenuevaconfirmar").	removeClass(' alert-success');	
		$("#clavenueva").			removeClass(' alert-danger');
		$("#clavenuevaconfirmar").	removeClass(' alert-danger');	
	}else if(clave1.length == clave2.length)
	{
			if (clave1 != clave2)
			{
				$("#clavenueva").			removeClass(' alert-success');
				$("#clavenuevaconfirmar").	removeClass(' alert-success');	
				$("#clavenueva").			addClass(' alert-danger');
				$("#clavenuevaconfirmar").	addClass(' alert-danger');
			}else if (clave1 == clave2){
				$("#clavenueva").			removeClass(' alert-danger');
				$("#clavenuevaconfirmar").	removeClass(' alert-danger');	
				$("#clavenueva").			addClass(' alert-success');
				$("#clavenuevaconfirmar").	addClass(' alert-success');
				condicion2='ok';
			}		
	}else{
		$("#clavenueva").			removeClass(' alert-success');
		$("#clavenuevaconfirmar").	removeClass(' alert-success');	
		$("#clavenueva").			removeClass(' alert-danger');
		$("#clavenuevaconfirmar").	removeClass(' alert-danger');	
	}
}
</script> 
<title>Reservas</title>
<style type="text/css">
body {
padding-top: 60px;
padding-bottom: 40px;
}
</style>
</head>

  <body>
    <!-- Fixed navbar -->
    <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="container">
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
            <li class="disabled"><a href="index.php">Inicio</a></li>
            <li><a href="agenda.php">	Ver Agenda</a></li>
            <li><a href="cupo.php">		Turnos disponibles</a></li>
			<li><a href="reportes.php">		Reportes</a></li>
			<li><a href="turnos.php">		Pantalla</a></li>
			
           <!-- <li class="active"><a>		Mi Perfil</a></li>-->
                 <li class="dropdown active">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown">Mi Perfil <b class="caret"></b></a>
                  <ul class="dropdown-menu">
                   <!-- <li><a href="datosfuncionario.php">Datos de Funcionario</a></li>-->
                    <li class="active"><a href="miperfil.php">Cambiar Clave</a></li>
                  </ul>
            </li> 
            <li><a href="cerrar.php">	Cerrar Sesion</a></li>
<!--             <li class="disabled"><a>Turnos disponibles</a></li>
            <li class="disabled"><a>Cerrar Sesion</a></li>
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
            </li>-->
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
          </form> -->      
			<div style="float:right; padding-top:15px; text-align:right"> 
				<img src="logo/LogoPequeno.gif" style="width:60px;height:40px; position:relative; top:-5px; float:right;"></img>
			</div>
          
        </div><!--/.nav-collapse -->
      </div>
    </div>  
         <div class="navbar-collapse collapse">

        </div>
		

 <div class="col-md-3 col-md-offset-4">

<center><h1 class="form-signin-heading text-primary"><strong>Cambiar Clave</strong></h1></center>
    <form data-toggle="validator" role="form" id="login" class="form-signin"  onSubmit="cambiarClave();" action="javascript: return false"  method="post" autocomplete="off">
    <div class="form-group">
        <!--<label for="inputName" class="control-label">Name</label>-->
        <div class="input-group">
        	<span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
        	<input 
                type=	"text" 
                class=	"form-control" 
                id=		"usuario" 
                value=	"<?php echo $_SESSION['usuario'] ?>"
                readonly 
            >
        </div>
        
    </div>
    <div class="form-group">
        <!--<label for="inputTwitter" class="control-label">Nueva</label>-->
        <div class="input-group">
        	<span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
        	<input 
             	onBlur=		"confirmarIdentidad();"
           		type=		"password" 
                class=		"form-control" 
                id=			"contrasena" 
                placeholder="Clave actual" 
                required 
                autofocus
            >
        </div>
    </div>
    <div class="form-group">
        <!--<label for="inputPassword" class="control-label">Password</label>-->
        <!--<div class="form-group col-sm-6">-->
        <div class="input-group">
        	<span class="input-group-addon">3 a 6 caracteres</span>
            <input 
            	onBlur=		"matchClave();"
                type=		"password" 
                minlength=	"3" 
                maxlength=	"6" 
                class=		"form-control" 
                id=			"clavenueva" 
                placeholder="Nueva Clave" 
                required style="letter-spacing:10px"
            >
    	</div>
    </div>
    <div class="form-group">
        <!--</div>-->
        <!--<div class="form-group col-sm-6">-->
        <div class="input-group">
        	<span class="input-group-addon">3 a 6 caracteres</span>
            <input
            	onKeyUp=	"matchClave();"
                type=		"password" 
                class=		"form-control" 
                minlength=	"3" 
                maxlength=	"6" 
                id=			"clavenuevaconfirmar" 
                data-match=	"#clavenueva" 
                style=		"letter-spacing:10px"
		data-match-error=	"No concuerdan" 
        placeholder=		"Reingresar clave" 
				required 
            >
            <div class="help-block with-errors"></div>
    	<!--</div>-->
    	</div>
    </div>
<div id="mensaje-sistema" > </div>
     <div class="form-group">
         <button 
             type=		"submit" 
             class=		"btn btn-lg btn-primary btn-block" 
             onClick=	"cambiarClave()" > 
         	<span class="glyphicon glyphicon-ok" ></span>
        	Confirmar
         </button>   
    </div>
    </form> <br> <br>
    <div class="alert alert-info text-center" role="alert">

     <span class="text-center sign-up">Como en <em>facebook</em>, lo que publiques con <strong>tu  usuario  </strong>  es tu responsabilidad.</span><br>

     <span class=""> Que tengas buen día!</span>
    </div>
 
</div>
    </div>
       
    </div> <!-- /container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>

  </body>
</html>
