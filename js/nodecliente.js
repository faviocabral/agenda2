//mensajeria instantanea... 
var socket = io.connect( 'http://192.168.10.54:8089' );
console.log(socket);
/*
var Usuario = "Inicio de socket...";
var f       = 1 ;
socket.emit( 'message', { usuario: Usuario, fila: f} );
alert('inicio el socket');
*/
/*
//socket.emit( 'message', { usuario: Usuario, fila: f} );
socket.on( 'message', function( data ) {

	$("td:contains('LIBRE')[id*='celda']").click(function(){
		console.log('click en la celda .... ');

	});


	console.log('Usuario : ' + data.usuario + ' - <?php echo $_SESSION['usuario']; ?>');	
	console.log('Fila : ' + data.fila);	
	var usuario = <?php echo "'" . $_SESSION['usuario'] . "'" ?> ; 
	if ( usuario != data.usuario ){
		$("td:contains('LIBRE')[id*='celda" + data.fila + "']").css("background-color", "#777"); //sino color normal #eee (
	}

});
*/