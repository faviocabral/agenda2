<?php 
if(session_id() == '') {
    session_start();
}

if (isset($_SESSION['usuario']))
{
	header("location:cupo.php");
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
<meta name="author" content="Software">
<meta name="keywords" content="Reservas, Mantenimiento, Vehiculo, Reparacion, Agenda, Ticket, Turno" /> 
 
<!-- JAVASCRIPT Y CSS PARA EL BOOTSTRAP -->
<script src="js/jquery.js"></script> <!--jQuery JavaScript Library v1.11.0-->

<!--<script src="js/bootstrap.js"></script>-->
<script src="js/bootstrap.min.js"></script>
<script src="js/bootstrap-datepicker.js"></script>

<script src="js/node_modules/socket.io/node_modules/socket.io-client/dist/socket.io.js"></script>
<script src="js/nodecliente.js"></script>
 
<link href="css/datepicker.css" rel="stylesheet">
<link href="css/bootstrap.css" rel="stylesheet">
<link href="css/bootstrap.css.map" rel="stylesheet">
<!--<link href="css/bootstrap.min.css" rel="stylesheet">-->
<!--<link href="css/bootstrap-theme.css" rel="stylesheet">-->
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
 function autenticar(b_fecha)
{
	$("#mensaje-sistema").removeClass	(' alert alert-danger');
	$('#mensaje-sistema').html('');

	var error = 0;
  var usuario 	= $("#usuario").val();
 	var contrasena	= $("#contrasena").val();
	
 	usuario = usuario.replace(/[^a-zA-Z 0-9.]+/g,' ');

 	if (!usuario || !contrasena) error++;
  	
 	if (error == 0)
		{
		accion ="autenticar";
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
						error: function(objeto, quepaso, otroobj){
              $("#mensaje-sistema").addClass	(' alert alert-danger');
							$('#mensaje-sistema').html('<span class="glyphicon glyphicon-alert"> Datos incorrectos </span> ');

             },
						success: function(datos){
						///////////////////// --- Acciones con los datos obtenidos --- /////////////////////
             //alert(JSON.parse(datos).id_funcionario )
             //alert(JSON.stringify(datos))
             if (datos.length > 0 )
						 {
              autenticar2(usuario, contrasena);
							$("#mostrarProgressBar").removeClass	(' hide');
							setTimeout(function(){window.location.href = "cupo.php?fecha="+b_fecha}, 100); 
						 }else{
 							$("#mensaje-sistema").addClass	(' alert alert-danger');
							$('#mensaje-sistema').html('<span class="glyphicon glyphicon-alert"></span> '+resdatos[0]);
						 }
					},							
				}
			).responseText;
	}else{
		//alert('Debe completar los campos requeridos');	
		$("#mensaje-sistema").addClass	(' alert alert-danger');
		$('#mensaje-sistema').html('<span class="glyphicon glyphicon-alert"></span> Campos requeridos');
	}
}

  function autenticar2(usuario , pass){
    //fco otra forma de registrar usuarios. 
    var jqxhr1 = $.ajax( { method: "POST", url: 'inc/procesos.php', data: { accion: "autenticar2" ,usuario: usuario, contrasena: pass }, dataType: 'json', encoding:"ISO-8859-1"});
    jqxhr1.done(function(rs) { //recuperar datos de turnos 
      console.log(rs);
      var html = "";
      rs.forEach( function ( rs2 ){
        //alert(rs2["id_funcionario"] + ' ' + rs2["usuario"] );
        localStorage.stellantis_user_id   =  rs2["id_funcionario"];
        localStorage.stellantis_user      =  rs2["usuario"];
        localStorage.stellantis_user_name =  rs2["nombre"];
      });
    });
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
            <li class="active"><a href="index.php">Inicio</a></li>
            <li ><a href="agenda.php">Ver Agenda</a></li> 
          </ul>
			<div style="float:right; padding-top:15px; text-align:right"> 
				<img src="logo/logo-gorostiaga.jpeg" style="width:60px;height:40px; position:relative; top:-5px; float:right; border-radius: 5%"></img>
			</div>
          
        </div><!--/.nav-collapse -->
      </div>
    </div>  
         <div class="navbar-collapse collapse">

        </div>
		
        <!--/.navbar-collapse -->
    <?php if (isset($_GET['login']) ){?>
     <!-- Formulario de ingreso -->
    <div class="container" style="width:300px">
    <form id="login" class="form-signin"  onSubmit="autenticar('<?php echo date("Y-m-d"); ?>');" action="javascript: return false"  method="post">       
<center>
    <img src="img/reservaturno.png" style="width:270px; height:100px; border: 2px solid blue; border-radius:15px; margin-bottom:5px;"> </center>
   <!-- <span class="input-group-addon">@</span>-->
    <div class="form-group">
        <div class="input-group">
            <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
            <input type="text" autofocus required placeholder="Usuario" name="username" id="usuario" class="form-control">
        </div>
	</div>
    <div class="form-group">
        <div class="input-group">
            <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
         <input type="password" required placeholder="Contraseña" name="password" id="contrasena" class="form-control">   
        </div>
	</div>
     <button type="submit" onClick="autenticar('<?php echo date("Y-m-d"); ?>')" class="btn btn-lg btn-primary btn-block">
     Iniciar Sesi&oacute;n <span class="glyphicon glyphicon-log-in" ></span></button>   
    </form>
    <br>
   
<div id="mensaje-sistema" ></div>
    <!--<p class="text-center sign-up text-info">Se admite <strong> un usuario </strong> conectado a la vez   </p>-->
    
    <div id="mostrarProgressBar" class="progress progress-striped active hide">
        <div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
        <span style="color:#FFF"></span>
        </div>
    </div>

    </div>
    <?php }else{?>

    <!-- Main jumbotron for a primary marketing message or call to action -->
	<center>
    <div class="jumbotron" style="margin-left:0px; margin-top:0px; padding-top:0px;">
       <div class="container">
          <h2 style="font-family: Arial Black">Sistema de Agendamiento</h2>
			<p>Gorostiaga Automotores. 
				<p > <button type="button" class="btn btn-primary btn-lg btn-responsive" style=" width:450px" onClick="javascript:window.location.href = 'index.php?login=y'"  /> Comenzar</button>  
				<!-- <a class="btn btn-primary btn-lg h2 "  href="index.php?login=y" role="button"> Comenzar </a>--></p>
			</p>
			<img src="logo/logo-gorostiaga.jpeg" style="width:450px; height:350px; border-radius: 5% " class="img-responsive"></img>
      </div>
    </div>
	</center>
    <div class="container hide">
      <!-- Example row of columns -->
      <div class="row" >
        <div class="col-md-4">
          <h2>Titulo</h2>
          <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
          <p><a class="btn btn-default" href="#" role="button">Ver detalles</a></p>
        </div>
        <div class="col-md-4">
          <h2>Titulo</h2>
          <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
          <p><a class="btn btn-default" href="#" role="button">Ver detalles</a></p>
       </div>
        <div class="col-md-4">
          <h2>Titulo</h2>
          <p>Donec sed odio dui. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Vestibulum id ligula porta felis euismod semper. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus.</p>
          <p><a class="btn btn-default" href="#" role="button">Ver detalles</a></p>
        </div>
      </div>
      <hr>

      <footer>
        <p>&copy; Company 2014</p>
      </footer>
<?php } ?>
      
    </div> <!-- /container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>

  </body>
</html>
