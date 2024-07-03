<?php 
//////////////////////////////////////////////////////////////////////////////////////////
//conexion a la base datos 
//include ("inc/conexion.php");
include_once ("inc/conexion.php");
session_start();
//////////////////////////////////////////////////////////////////////////////////////////
//consulta a la base datos 
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////	
// TABLERO 1
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////	

//CLIENTES EN ESPERA... 
$query = " 
		SELECT 
			T1.ITEM AS ITEM1, T1.NOMBRE AS COL1, T1.ESTADO ESTA1, T1.CODIGO COD1 , CASE WHEN T1.ATENCION = 4 THEN 'call ' ELSE '' END CALL1, T1.CASILLA CASI1 , CASE WHEN T1.ATENCION = 5 THEN ' glyphicon glyphicon-user ' ELSE '' END LLEGO1 , CASE WHEN T1.ATENCION = 5 THEN to_char( T1.hora_llamada , 'HH:MI' ) ELSE '' END HORALLEGADA1 ,
			T2.ITEM AS ITEM2, T2.NOMBRE AS COL2, T2.ESTADO ESTA2, T2.CODIGO COD2 , CASE WHEN T2.ATENCION = 4 THEN 'call ' ELSE '' END CALL2, T2.CASILLA CASI2 , CASE WHEN T2.ATENCION = 5 THEN ' glyphicon glyphicon-user ' ELSE '' END LLEGO2 , CASE WHEN T2.ATENCION = 5 THEN to_char( T2.hora_llamada , 'HH:MI' ) ELSE '' END HORALLEGADA2 ,
			T3.ITEM AS ITEM3, T3.NOMBRE AS COL3, T3.ESTADO ESTA3, T3.CODIGO COD3 , CASE WHEN T3.ATENCION = 4 THEN 'call ' ELSE '' END CALL3, T3.CASILLA CASI3 , CASE WHEN T3.ATENCION = 5 THEN ' glyphicon glyphicon-user ' ELSE '' END LLEGO3 , CASE WHEN T3.ATENCION = 5 THEN to_char( T3.hora_llamada , 'HH:MI' ) ELSE '' END HORALLEGADA3 ,
			T4.ITEM AS ITEM4, T4.NOMBRE AS COL4, T4.ESTADO ESTA4, T4.CODIGO COD4 , CASE WHEN T4.ATENCION = 4 THEN 'call ' ELSE '' END CALL4, T4.CASILLA CASI4 , CASE WHEN T4.ATENCION = 5 THEN ' glyphicon glyphicon-user ' ELSE '' END LLEGO4 , CASE WHEN T4.ATENCION = 5 THEN to_char( T4.hora_llamada , 'HH:MI' ) ELSE '' END HORALLEGADA4 ,
			T5.ITEM AS ITEM5, T5.NOMBRE AS COL5, T5.ESTADO ESTA5, T5.CODIGO COD5 , CASE WHEN T5.ATENCION = 4 THEN 'call ' ELSE '' END CALL5, T5.CASILLA CASI5 , CASE WHEN T5.ATENCION = 5 THEN ' glyphicon glyphicon-user ' ELSE '' END LLEGO5 , CASE WHEN T5.ATENCION = 5 THEN to_char( T5.hora_llamada , 'HH:MI' ) ELSE '' END HORALLEGADA5 ,
			T6.ITEM AS ITEM6, T6.NOMBRE AS COL6, T6.ESTADO ESTA6, T6.CODIGO COD6 , CASE WHEN T6.ATENCION = 4 THEN 'call ' ELSE '' END CALL6, T6.CASILLA CASI6 , CASE WHEN T6.ATENCION = 5 THEN ' glyphicon glyphicon-user ' ELSE '' END LLEGO6 , CASE WHEN T6.ATENCION = 5 THEN to_char( T6.hora_llamada , 'HH:MI' ) ELSE '' END HORALLEGADA6  
		FROM consultas T0 
			LEFT OUTER JOIN ( SELECT ROW_NUMBER() OVER(ORDER BY hora_solicitud ) ITEM , NOMBRE , ESTADO , ID_FICHA CODIGO , ESTADO_ATENCION ATENCION , REPLACE(CASILLA,' ','<br>') CASILLA, HORA_LLAMADA FROM public.fichas WHERE fecha = date( to_char(now(), 'YYYYMMDD')) AND hora = '07:30' AND estado = '1' and estado_atencion <> 2 AND NOMBRE <> '*' ORDER BY hora_solicitud ) T1 ON T0.ID = T1.ITEM 
			LEFT OUTER JOIN ( SELECT ROW_NUMBER() OVER(ORDER BY hora_solicitud ) ITEM , NOMBRE , ESTADO , ID_FICHA CODIGO , ESTADO_ATENCION ATENCION , REPLACE(CASILLA,' ','<br>') CASILLA, HORA_LLAMADA FROM public.fichas WHERE fecha = date( to_char(now(), 'YYYYMMDD')) AND hora = '07:45' AND estado = '1' and estado_atencion <> 2 AND NOMBRE <> '*' ORDER BY hora_solicitud ) T2 ON T0.ID = T2.ITEM 
			LEFT OUTER JOIN ( SELECT ROW_NUMBER() OVER(ORDER BY hora_solicitud ) ITEM , NOMBRE , ESTADO , ID_FICHA CODIGO , ESTADO_ATENCION ATENCION , REPLACE(CASILLA,' ','<br>') CASILLA, HORA_LLAMADA FROM public.fichas WHERE fecha = date( to_char(now(), 'YYYYMMDD')) AND hora = '08:00' AND estado = '1' and estado_atencion <> 2 AND NOMBRE <> '*' ORDER BY hora_solicitud ) T3 ON T0.ID = T3.ITEM 
			LEFT OUTER JOIN ( SELECT ROW_NUMBER() OVER(ORDER BY hora_solicitud ) ITEM , NOMBRE , ESTADO , ID_FICHA CODIGO , ESTADO_ATENCION ATENCION , REPLACE(CASILLA,' ','<br>') CASILLA, HORA_LLAMADA FROM public.fichas WHERE fecha = date( to_char(now(), 'YYYYMMDD')) AND hora = '08:15' AND estado = '1' and estado_atencion <> 2 AND NOMBRE <> '*' ORDER BY hora_solicitud ) T4 ON T0.ID = T4.ITEM 
			LEFT OUTER JOIN ( SELECT ROW_NUMBER() OVER(ORDER BY hora_solicitud ) ITEM , NOMBRE , ESTADO , ID_FICHA CODIGO , ESTADO_ATENCION ATENCION , REPLACE(CASILLA,' ','<br>') CASILLA, HORA_LLAMADA FROM public.fichas WHERE fecha = date( to_char(now(), 'YYYYMMDD')) AND hora = '08:30' AND estado = '1' and estado_atencion <> 2 AND NOMBRE <> '*' ORDER BY hora_solicitud ) T5 ON T0.ID = T5.ITEM 
			LEFT OUTER JOIN ( SELECT ROW_NUMBER() OVER(ORDER BY hora_solicitud ) ITEM , NOMBRE , ESTADO , ID_FICHA CODIGO , ESTADO_ATENCION ATENCION , REPLACE(CASILLA,' ','<br>') CASILLA, HORA_LLAMADA FROM public.fichas WHERE fecha = date( to_char(now(), 'YYYYMMDD')) AND hora = '08:45' AND estado = '1' and estado_atencion <> 2 AND NOMBRE <> '*' ORDER BY hora_solicitud ) T6 ON T0.ID = T6.ITEM 
		WHERE T0.id <= T1.ITEM OR T0.id <= T2.ITEM OR T0.id <= T3.ITEM OR T0.id <= T4.ITEM OR T0.id <= T5.ITEM OR T0.id <= T6.ITEM 
	";

//CLIENTES ATENDIDOS.... 	
$query2 = " 
		SELECT 
			T1.ITEM AS ITEM1, T1.NOMBRE AS COL1, T1.ESTADO ESTA1, T1.CODIGO COD1, CASE WHEN T1.ATENCION = 4 THEN 'call ' ELSE '' END CALL1, T1.CASILLA CASI1 ,
			T2.ITEM AS ITEM2, T2.NOMBRE AS COL2, T2.ESTADO ESTA2, T2.CODIGO COD2, CASE WHEN T2.ATENCION = 4 THEN 'call ' ELSE '' END CALL2, T2.CASILLA CASI2 ,
			T3.ITEM AS ITEM3, T3.NOMBRE AS COL3, T3.ESTADO ESTA3, T3.CODIGO COD3, CASE WHEN T3.ATENCION = 4 THEN 'call ' ELSE '' END CALL3, T3.CASILLA CASI3 ,
			T4.ITEM AS ITEM4, T4.NOMBRE AS COL4, T4.ESTADO ESTA4, T4.CODIGO COD4, CASE WHEN T4.ATENCION = 4 THEN 'call ' ELSE '' END CALL4, T4.CASILLA CASI4 ,
			T5.ITEM AS ITEM5, T5.NOMBRE AS COL5, T5.ESTADO ESTA5, T5.CODIGO COD5, CASE WHEN T5.ATENCION = 4 THEN 'call ' ELSE '' END CALL5, T5.CASILLA CASI5 ,
			T6.ITEM AS ITEM6, T6.NOMBRE AS COL6, T6.ESTADO ESTA6, T6.CODIGO COD6, CASE WHEN T6.ATENCION = 4 THEN 'call ' ELSE '' END CALL6,  T6.CASILLA CASI6
		FROM consultas T0 
			LEFT OUTER JOIN ( SELECT ROW_NUMBER() OVER(ORDER BY hora_solicitud ) ITEM , NOMBRE , ESTADO , ID_FICHA CODIGO , ESTADO_ATENCION ATENCION , REPLACE(CASILLA,' ','<br>') CASILLA FROM public.fichas WHERE fecha = date( to_char(now(), 'YYYYMMDD')) AND hora = '07:30' AND estado = '2' AND estado_atencion <> 2 AND NOMBRE <> '*' ORDER BY hora_solicitud ) T1 ON T0.ID = T1.ITEM 
			LEFT OUTER JOIN ( SELECT ROW_NUMBER() OVER(ORDER BY hora_solicitud ) ITEM , NOMBRE , ESTADO , ID_FICHA CODIGO , ESTADO_ATENCION ATENCION , REPLACE(CASILLA,' ','<br>') CASILLA FROM public.fichas WHERE fecha = date( to_char(now(), 'YYYYMMDD')) AND hora = '07:45' AND estado = '2' AND estado_atencion <> 2 AND NOMBRE <> '*' ORDER BY hora_solicitud ) T2 ON T0.ID = T2.ITEM 
			LEFT OUTER JOIN ( SELECT ROW_NUMBER() OVER(ORDER BY hora_solicitud ) ITEM , NOMBRE , ESTADO , ID_FICHA CODIGO , ESTADO_ATENCION ATENCION , REPLACE(CASILLA,' ','<br>') CASILLA FROM public.fichas WHERE fecha = date( to_char(now(), 'YYYYMMDD')) AND hora = '08:00' AND estado = '2' AND estado_atencion <> 2 AND NOMBRE <> '*' ORDER BY hora_solicitud ) T3 ON T0.ID = T3.ITEM 
			LEFT OUTER JOIN ( SELECT ROW_NUMBER() OVER(ORDER BY hora_solicitud ) ITEM , NOMBRE , ESTADO , ID_FICHA CODIGO , ESTADO_ATENCION ATENCION , REPLACE(CASILLA,' ','<br>') CASILLA FROM public.fichas WHERE fecha = date( to_char(now(), 'YYYYMMDD')) AND hora = '08:15' AND estado = '2' AND estado_atencion <> 2 AND NOMBRE <> '*' ORDER BY hora_solicitud ) T4 ON T0.ID = T4.ITEM 
			LEFT OUTER JOIN ( SELECT ROW_NUMBER() OVER(ORDER BY hora_solicitud ) ITEM , NOMBRE , ESTADO , ID_FICHA CODIGO , ESTADO_ATENCION ATENCION , REPLACE(CASILLA,' ','<br>') CASILLA FROM public.fichas WHERE fecha = date( to_char(now(), 'YYYYMMDD')) AND hora = '08:30' AND estado = '2' AND estado_atencion <> 2 AND NOMBRE <> '*' ORDER BY hora_solicitud ) T5 ON T0.ID = T5.ITEM 
			LEFT OUTER JOIN ( SELECT ROW_NUMBER() OVER(ORDER BY hora_solicitud ) ITEM , NOMBRE , ESTADO , ID_FICHA CODIGO , ESTADO_ATENCION ATENCION , REPLACE(CASILLA,' ','<br>') CASILLA FROM public.fichas WHERE fecha = date( to_char(now(), 'YYYYMMDD')) AND hora = '08:45' AND estado = '2' AND estado_atencion <> 2 AND NOMBRE <> '*' ORDER BY hora_solicitud ) T6 ON T0.ID = T6.ITEM 
		WHERE T0.id <= T1.ITEM OR T0.id <= T2.ITEM OR T0.id <= T3.ITEM OR T0.id <= T4.ITEM OR T0.id <= T5.ITEM OR T0.id <= T6.ITEM 
	";

//CLIENTES LLAMADOS.... 	
$query3 = " 
		SELECT 
			T1.ITEM AS ITEM1, T1.NOMBRE AS COL1, T1.ESTADO ESTA1, T1.CODIGO COD1, CASE WHEN T1.ATENCION = 4 THEN 'call ' ELSE '' END CALL1 , T1.CASILLA CASI1 ,  
			T2.ITEM AS ITEM2, T2.NOMBRE AS COL2, T2.ESTADO ESTA2, T2.CODIGO COD2, CASE WHEN T2.ATENCION = 4 THEN 'call ' ELSE '' END CALL2 , T2.CASILLA CASI2 ,
			T3.ITEM AS ITEM3, T3.NOMBRE AS COL3, T3.ESTADO ESTA3, T3.CODIGO COD3, CASE WHEN T3.ATENCION = 4 THEN 'call ' ELSE '' END CALL3 , T3.CASILLA CASI3 , 
			T4.ITEM AS ITEM4, T4.NOMBRE AS COL4, T4.ESTADO ESTA4, T4.CODIGO COD4, CASE WHEN T4.ATENCION = 4 THEN 'call ' ELSE '' END CALL4 , T4.CASILLA CASI4 ,
			T5.ITEM AS ITEM5, T5.NOMBRE AS COL5, T5.ESTADO ESTA5, T5.CODIGO COD5, CASE WHEN T5.ATENCION = 4 THEN 'call ' ELSE '' END CALL5 , T5.CASILLA CASI5 ,
			T6.ITEM AS ITEM6, T6.NOMBRE AS COL6, T6.ESTADO ESTA6, T6.CODIGO COD6, CASE WHEN T6.ATENCION = 4 THEN 'call ' ELSE '' END CALL6 , T6.CASILLA CASI6 
		FROM consultas T0 
			LEFT OUTER JOIN ( SELECT ROW_NUMBER() OVER(ORDER BY hora_solicitud ) ITEM , NOMBRE , ESTADO , ID_FICHA CODIGO , ESTADO_ATENCION ATENCION , REPLACE(CASILLA,' ','<br>') CASILLA FROM public.fichas WHERE fecha = date( to_char(now(), 'YYYYMMDD')) AND hora = '07:30' AND estado_atencion = 2 AND NOMBRE <> '*' ORDER BY hora_solicitud ) T1 ON T0.ID = T1.ITEM 
			LEFT OUTER JOIN ( SELECT ROW_NUMBER() OVER(ORDER BY hora_solicitud ) ITEM , NOMBRE , ESTADO , ID_FICHA CODIGO , ESTADO_ATENCION ATENCION , REPLACE(CASILLA,' ','<br>') CASILLA FROM public.fichas WHERE fecha = date( to_char(now(), 'YYYYMMDD')) AND hora = '07:45' AND estado_atencion = 2 AND NOMBRE <> '*' ORDER BY hora_solicitud ) T2 ON T0.ID = T2.ITEM 
			LEFT OUTER JOIN ( SELECT ROW_NUMBER() OVER(ORDER BY hora_solicitud ) ITEM , NOMBRE , ESTADO , ID_FICHA CODIGO , ESTADO_ATENCION ATENCION , REPLACE(CASILLA,' ','<br>') CASILLA FROM public.fichas WHERE fecha = date( to_char(now(), 'YYYYMMDD')) AND hora = '08:00' AND estado_atencion = 2 AND NOMBRE <> '*' ORDER BY hora_solicitud ) T3 ON T0.ID = T3.ITEM 
			LEFT OUTER JOIN ( SELECT ROW_NUMBER() OVER(ORDER BY hora_solicitud ) ITEM , NOMBRE , ESTADO , ID_FICHA CODIGO , ESTADO_ATENCION ATENCION , REPLACE(CASILLA,' ','<br>') CASILLA FROM public.fichas WHERE fecha = date( to_char(now(), 'YYYYMMDD')) AND hora = '08:15' AND estado_atencion = 2 AND NOMBRE <> '*' ORDER BY hora_solicitud ) T4 ON T0.ID = T4.ITEM 
			LEFT OUTER JOIN ( SELECT ROW_NUMBER() OVER(ORDER BY hora_solicitud ) ITEM , NOMBRE , ESTADO , ID_FICHA CODIGO , ESTADO_ATENCION ATENCION , REPLACE(CASILLA,' ','<br>') CASILLA FROM public.fichas WHERE fecha = date( to_char(now(), 'YYYYMMDD')) AND hora = '08:30' AND estado_atencion = 2 AND NOMBRE <> '*' ORDER BY hora_solicitud ) T5 ON T0.ID = T5.ITEM 
			LEFT OUTER JOIN ( SELECT ROW_NUMBER() OVER(ORDER BY hora_solicitud ) ITEM , NOMBRE , ESTADO , ID_FICHA CODIGO , ESTADO_ATENCION ATENCION , REPLACE(CASILLA,' ','<br>') CASILLA FROM public.fichas WHERE fecha = date( to_char(now(), 'YYYYMMDD')) AND hora = '08:45' AND estado_atencion = 2 AND NOMBRE <> '*' ORDER BY hora_solicitud ) T6 ON T0.ID = T6.ITEM 
		WHERE T0.id <= T1.ITEM OR T0.id <= T2.ITEM OR T0.id <= T3.ITEM OR T0.id <= T4.ITEM OR T0.id <= T5.ITEM OR T0.id <= T6.ITEM 
	";
	

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////	
// TABLERO 2 
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////	

//CLIENTES EN ESPERA... 
$query4 = " 
		SELECT 
			T7.ITEM AS ITEM7, T7.NOMBRE AS COL7, T7.ESTADO ESTA7, T7.CODIGO COD7 , CASE WHEN T7.ATENCION = 4 THEN 'call ' ELSE '' END CALL7, T7.CASILLA CASI7 , CASE WHEN T7.ATENCION = 5 THEN ' glyphicon glyphicon-user ' ELSE '' END LLEGO7 , CASE WHEN T7.ATENCION = 5 THEN to_char( T7.hora_llamada , 'HH:MI' ) ELSE '' END HORALLEGADA7 ,
			T8.ITEM AS ITEM8, T8.NOMBRE AS COL8, T8.ESTADO ESTA8, T8.CODIGO COD8 , CASE WHEN T8.ATENCION = 4 THEN 'call ' ELSE '' END CALL8, T8.CASILLA CASI8 , CASE WHEN T8.ATENCION = 5 THEN ' glyphicon glyphicon-user ' ELSE '' END LLEGO8 , CASE WHEN T8.ATENCION = 5 THEN to_char( T8.hora_llamada , 'HH:MI' ) ELSE '' END HORALLEGADA8 ,
			T9.ITEM AS ITEM9, T9.NOMBRE AS COL9, T9.ESTADO ESTA9, T9.CODIGO COD9 , CASE WHEN T9.ATENCION = 4 THEN 'call ' ELSE '' END CALL9, T9.CASILLA CASI9 , CASE WHEN T9.ATENCION = 5 THEN ' glyphicon glyphicon-user ' ELSE '' END LLEGO9 , CASE WHEN T9.ATENCION = 5 THEN to_char( T9.hora_llamada , 'HH:MI' ) ELSE '' END HORALLEGADA9 ,
			T10.ITEM AS ITEM10, T10.NOMBRE AS COL10, T10.ESTADO ESTA10, T10.CODIGO COD10 , CASE WHEN T10.ATENCION = 4 THEN 'call ' ELSE '' END CALL10 , T10.CASILLA CASI10, CASE WHEN T10.ATENCION = 5 THEN ' glyphicon glyphicon-user ' ELSE '' END LLEGO10 , CASE WHEN T10.ATENCION = 5 THEN to_char( T10.hora_llamada , 'HH:MI' ) ELSE '' END HORALLEGADA10 ,
			T11.ITEM AS ITEM11, T11.NOMBRE AS COL11, T11.ESTADO ESTA11, T11.CODIGO COD11 , CASE WHEN T11.ATENCION = 4 THEN 'call ' ELSE '' END CALL11 , T11.CASILLA CASI11, CASE WHEN T11.ATENCION = 5 THEN ' glyphicon glyphicon-user ' ELSE '' END LLEGO11 , CASE WHEN T11.ATENCION = 5 THEN to_char( T11.hora_llamada , 'HH:MI' ) ELSE '' END HORALLEGADA11 ,
			T12.ITEM AS ITEM12, T12.NOMBRE AS COL12, T12.ESTADO ESTA12, T12.CODIGO COD12 , CASE WHEN T12.ATENCION = 4 THEN 'call ' ELSE '' END CALL12 , T12.CASILLA CASI12, CASE WHEN T12.ATENCION = 5 THEN ' glyphicon glyphicon-user ' ELSE '' END LLEGO12 , CASE WHEN T12.ATENCION = 5 THEN to_char( T12.hora_llamada , 'HH:MI' ) ELSE '' END HORALLEGADA12 
		FROM consultas T0 
			LEFT OUTER JOIN ( SELECT ROW_NUMBER() OVER(ORDER BY hora_solicitud ) ITEM , NOMBRE , ESTADO , ID_FICHA CODIGO , ESTADO_ATENCION ATENCION , REPLACE(CASILLA,' ','<br>') CASILLA, HORA_LLAMADA FROM public.fichas WHERE fecha = date( to_char(now(), 'YYYYMMDD')) AND hora = '09:00' AND estado = '1' and estado_atencion <> 2 AND NOMBRE <> '*' ORDER BY hora_solicitud ) T7 ON T0.ID = T7.ITEM 
			LEFT OUTER JOIN ( SELECT ROW_NUMBER() OVER(ORDER BY hora_solicitud ) ITEM , NOMBRE , ESTADO , ID_FICHA CODIGO , ESTADO_ATENCION ATENCION , REPLACE(CASILLA,' ','<br>') CASILLA, HORA_LLAMADA FROM public.fichas WHERE fecha = date( to_char(now(), 'YYYYMMDD')) AND hora = '09:15' AND estado = '1' and estado_atencion <> 2 AND NOMBRE <> '*' ORDER BY hora_solicitud ) T8 ON T0.ID = T8.ITEM 
			LEFT OUTER JOIN ( SELECT ROW_NUMBER() OVER(ORDER BY hora_solicitud ) ITEM , NOMBRE , ESTADO , ID_FICHA CODIGO , ESTADO_ATENCION ATENCION , REPLACE(CASILLA,' ','<br>') CASILLA, HORA_LLAMADA FROM public.fichas WHERE fecha = date( to_char(now(), 'YYYYMMDD')) AND hora = '09:30' AND estado = '1' and estado_atencion <> 2 AND NOMBRE <> '*' ORDER BY hora_solicitud ) T9 ON T0.ID = T9.ITEM 
			LEFT OUTER JOIN ( SELECT ROW_NUMBER() OVER(ORDER BY hora_solicitud ) ITEM , NOMBRE , ESTADO , ID_FICHA CODIGO , ESTADO_ATENCION ATENCION , REPLACE(CASILLA,' ','<br>') CASILLA, HORA_LLAMADA FROM public.fichas WHERE fecha = date( to_char(now(), 'YYYYMMDD')) AND hora = '09:45' AND estado = '1' and estado_atencion <> 2 AND NOMBRE <> '*' ORDER BY hora_solicitud ) T10 ON T0.ID = T10.ITEM 
			LEFT OUTER JOIN ( SELECT ROW_NUMBER() OVER(ORDER BY hora_solicitud ) ITEM , NOMBRE , ESTADO , ID_FICHA CODIGO , ESTADO_ATENCION ATENCION , REPLACE(CASILLA,' ','<br>') CASILLA, HORA_LLAMADA FROM public.fichas WHERE fecha = date( to_char(now(), 'YYYYMMDD')) AND hora = '10:30' AND estado = '1' and estado_atencion <> 2 AND NOMBRE <> '*' ORDER BY hora_solicitud ) T11 ON T0.ID = T11.ITEM 
			LEFT OUTER JOIN ( SELECT ROW_NUMBER() OVER(ORDER BY hora_solicitud ) ITEM , NOMBRE , ESTADO , ID_FICHA CODIGO , ESTADO_ATENCION ATENCION , REPLACE(CASILLA,' ','<br>') CASILLA, HORA_LLAMADA FROM public.fichas WHERE fecha = date( to_char(now(), 'YYYYMMDD')) AND hora = '14:30' AND estado = '1' and estado_atencion <> 2 AND NOMBRE <> '*' ORDER BY hora_solicitud ) T12 ON T0.ID = T12.ITEM 
		WHERE T0.id <= T7.ITEM OR T0.id <= T8.ITEM OR T0.id <= T9.ITEM OR T0.id <= T10.ITEM OR T0.id <= T11.ITEM OR T0.id <= T12.ITEM
	";

//CLIENTES ATENDIDOS.... 	
$query5 = " 
		SELECT 
			T7.ITEM AS ITEM7, T7.NOMBRE AS COL7, T7.ESTADO ESTA7, T7.CODIGO COD7, CASE WHEN T7.ATENCION = 4 THEN 'call ' ELSE '' END CALL7, T7.CASILLA CASI7 ,
			T8.ITEM AS ITEM8, T8.NOMBRE AS COL8, T8.ESTADO ESTA8, T8.CODIGO COD8, CASE WHEN T8.ATENCION = 4 THEN 'call ' ELSE '' END CALL8, T8.CASILLA CASI8 ,
			T9.ITEM AS ITEM9, T9.NOMBRE AS COL9, T9.ESTADO ESTA9, T9.CODIGO COD9, CASE WHEN T9.ATENCION = 4 THEN 'call ' ELSE '' END CALL9, T9.CASILLA CASI9 ,
			T10.ITEM AS ITEM10, T10.NOMBRE AS COL10, T10.ESTADO ESTA10, T10.CODIGO COD10, CASE WHEN T10.ATENCION = 4 THEN 'call ' ELSE '' END CALL10, T10.CASILLA CASI10 ,
			T11.ITEM AS ITEM11, T11.NOMBRE AS COL11, T11.ESTADO ESTA11, T11.CODIGO COD11, CASE WHEN T11.ATENCION = 4 THEN 'call ' ELSE '' END CALL11, T11.CASILLA CASI11 ,
			T12.ITEM AS ITEM12, T12.NOMBRE AS COL12, T12.ESTADO ESTA12, T12.CODIGO COD12, CASE WHEN T12.ATENCION = 4 THEN 'call ' ELSE '' END CALL12, T12.CASILLA CASI12 
		FROM consultas T0 
			LEFT OUTER JOIN ( SELECT ROW_NUMBER() OVER(ORDER BY hora_solicitud ) ITEM , NOMBRE , ESTADO , ID_FICHA CODIGO , ESTADO_ATENCION ATENCION , REPLACE(CASILLA,' ','<br>') CASILLA FROM public.fichas WHERE fecha = date( to_char(now(), 'YYYYMMDD')) AND hora = '09:00' AND estado = '2' AND estado_atencion <> 2 AND NOMBRE <> '*' ORDER BY hora_solicitud ) T7 ON T0.ID = T7.ITEM 
			LEFT OUTER JOIN ( SELECT ROW_NUMBER() OVER(ORDER BY hora_solicitud ) ITEM , NOMBRE , ESTADO , ID_FICHA CODIGO , ESTADO_ATENCION ATENCION , REPLACE(CASILLA,' ','<br>') CASILLA FROM public.fichas WHERE fecha = date( to_char(now(), 'YYYYMMDD')) AND hora = '09:15' AND estado = '2' AND estado_atencion <> 2 AND NOMBRE <> '*' ORDER BY hora_solicitud ) T8 ON T0.ID = T8.ITEM 
			LEFT OUTER JOIN ( SELECT ROW_NUMBER() OVER(ORDER BY hora_solicitud ) ITEM , NOMBRE , ESTADO , ID_FICHA CODIGO , ESTADO_ATENCION ATENCION , REPLACE(CASILLA,' ','<br>') CASILLA FROM public.fichas WHERE fecha = date( to_char(now(), 'YYYYMMDD')) AND hora = '09:30' AND estado = '2' AND estado_atencion <> 2 AND NOMBRE <> '*' ORDER BY hora_solicitud ) T9 ON T0.ID = T9.ITEM 
			LEFT OUTER JOIN ( SELECT ROW_NUMBER() OVER(ORDER BY hora_solicitud ) ITEM , NOMBRE , ESTADO , ID_FICHA CODIGO , ESTADO_ATENCION ATENCION , REPLACE(CASILLA,' ','<br>') CASILLA FROM public.fichas WHERE fecha = date( to_char(now(), 'YYYYMMDD')) AND hora = '09:45' AND estado = '2' AND estado_atencion <> 2 AND NOMBRE <> '*' ORDER BY hora_solicitud ) T10 ON T0.ID = T10.ITEM 
			LEFT OUTER JOIN ( SELECT ROW_NUMBER() OVER(ORDER BY hora_solicitud ) ITEM , NOMBRE , ESTADO , ID_FICHA CODIGO , ESTADO_ATENCION ATENCION , REPLACE(CASILLA,' ','<br>') CASILLA FROM public.fichas WHERE fecha = date( to_char(now(), 'YYYYMMDD')) AND hora = '10:30' AND estado = '2' AND estado_atencion <> 2 AND NOMBRE <> '*' ORDER BY hora_solicitud ) T11 ON T0.ID = T11.ITEM 
			LEFT OUTER JOIN ( SELECT ROW_NUMBER() OVER(ORDER BY hora_solicitud ) ITEM , NOMBRE , ESTADO , ID_FICHA CODIGO , ESTADO_ATENCION ATENCION , REPLACE(CASILLA,' ','<br>') CASILLA FROM public.fichas WHERE fecha = date( to_char(now(), 'YYYYMMDD')) AND hora = '14:30' AND estado = '2' AND estado_atencion <> 2 AND NOMBRE <> '*' ORDER BY hora_solicitud ) T12 ON T0.ID = T12.ITEM 
		WHERE T0.id <= T7.ITEM OR T0.id <= T8.ITEM OR T0.id <= T9.ITEM OR T0.id <= T10.ITEM OR T0.id <= T11.ITEM OR T0.id <= T12.ITEM 				
	";
	
//CLIENTES LLAMADOS.... 	
$query6 = " 
		SELECT 
			T7.ITEM AS ITEM7, T7.NOMBRE AS COL7, T7.ESTADO ESTA7, T7.CODIGO COD7, CASE WHEN T7.ATENCION = 4 THEN 'call ' ELSE '' END CALL7 , T7.CASILLA CASI7 ,
			T8.ITEM AS ITEM8, T8.NOMBRE AS COL8, T8.ESTADO ESTA8, T8.CODIGO COD8, CASE WHEN T8.ATENCION = 4 THEN 'call ' ELSE '' END CALL8 , T8.CASILLA CASI8 ,
			T9.ITEM AS ITEM9, T9.NOMBRE AS COL9, T9.ESTADO ESTA9, T9.CODIGO COD9, CASE WHEN T9.ATENCION = 4 THEN 'call ' ELSE '' END CALL9 , T9.CASILLA CASI9 ,
			T10.ITEM AS ITEM10, T10.NOMBRE AS COL10, T10.ESTADO ESTA10, T10.CODIGO COD10 , CASE WHEN T10.ATENCION = 4 THEN 'call ' ELSE '' END CALL10 , T10.CASILLA CASI10 ,
			T11.ITEM AS ITEM11, T11.NOMBRE AS COL11, T11.ESTADO ESTA11, T11.CODIGO COD11 , CASE WHEN T11.ATENCION = 4 THEN 'call ' ELSE '' END CALL11 , T11.CASILLA CASI11 ,
			T12.ITEM AS ITEM12, T12.NOMBRE AS COL12, T12.ESTADO ESTA12, T12.CODIGO COD12 , CASE WHEN T12.ATENCION = 4 THEN 'call ' ELSE '' END CALL12 ,  T12.CASILLA CASI12 
		FROM consultas T0 
			LEFT OUTER JOIN ( SELECT ROW_NUMBER() OVER(ORDER BY hora_solicitud ) ITEM , NOMBRE , ESTADO , ID_FICHA CODIGO , ESTADO_ATENCION ATENCION , REPLACE(CASILLA,' ','<br>') CASILLA FROM public.fichas WHERE fecha = date( to_char(now(), 'YYYYMMDD')) AND hora = '09:00' AND estado_atencion = 2 AND NOMBRE <> '*' ORDER BY hora_solicitud ) T7 ON T0.ID = T7.ITEM 
			LEFT OUTER JOIN ( SELECT ROW_NUMBER() OVER(ORDER BY hora_solicitud ) ITEM , NOMBRE , ESTADO , ID_FICHA CODIGO , ESTADO_ATENCION ATENCION , REPLACE(CASILLA,' ','<br>') CASILLA FROM public.fichas WHERE fecha = date( to_char(now(), 'YYYYMMDD')) AND hora = '09:15' AND estado_atencion = 2 AND NOMBRE <> '*' ORDER BY hora_solicitud ) T8 ON T0.ID = T8.ITEM 
			LEFT OUTER JOIN ( SELECT ROW_NUMBER() OVER(ORDER BY hora_solicitud ) ITEM , NOMBRE , ESTADO , ID_FICHA CODIGO , ESTADO_ATENCION ATENCION , REPLACE(CASILLA,' ','<br>') CASILLA FROM public.fichas WHERE fecha = date( to_char(now(), 'YYYYMMDD')) AND hora = '09:30' AND estado_atencion = 2 AND NOMBRE <> '*' ORDER BY hora_solicitud ) T9 ON T0.ID = T9.ITEM 
			LEFT OUTER JOIN ( SELECT ROW_NUMBER() OVER(ORDER BY hora_solicitud ) ITEM , NOMBRE , ESTADO , ID_FICHA CODIGO , ESTADO_ATENCION ATENCION , REPLACE(CASILLA,' ','<br>') CASILLA FROM public.fichas WHERE fecha = date( to_char(now(), 'YYYYMMDD')) AND hora = '09:45' AND estado_atencion = 2 AND NOMBRE <> '*' ORDER BY hora_solicitud ) T10 ON T0.ID = T10.ITEM 
			LEFT OUTER JOIN ( SELECT ROW_NUMBER() OVER(ORDER BY hora_solicitud ) ITEM , NOMBRE , ESTADO , ID_FICHA CODIGO , ESTADO_ATENCION ATENCION , REPLACE(CASILLA,' ','<br>') CASILLA FROM public.fichas WHERE fecha = date( to_char(now(), 'YYYYMMDD')) AND hora = '10:30' AND estado_atencion = 2 AND NOMBRE <> '*' ORDER BY hora_solicitud ) T11 ON T0.ID = T11.ITEM 
			LEFT OUTER JOIN ( SELECT ROW_NUMBER() OVER(ORDER BY hora_solicitud ) ITEM , NOMBRE , ESTADO , ID_FICHA CODIGO , ESTADO_ATENCION ATENCION , REPLACE(CASILLA,' ','<br>') CASILLA FROM public.fichas WHERE fecha = date( to_char(now(), 'YYYYMMDD')) AND hora = '14:30' AND estado_atencion = 2 AND NOMBRE <> '*' ORDER BY hora_solicitud ) T12 ON T0.ID = T12.ITEM 
		WHERE T0.id <= T7.ITEM OR T0.id <= T8.ITEM OR T0.id <= T9.ITEM OR T0.id <= T10.ITEM OR T0.id <= T11.ITEM OR T0.id <= T12.ITEM 		
	";

	
//PARA LLAMAR LOS BOXES ... PARLANTE...  
$query7 = "
		SELECT ROW_NUMBER() OVER(ORDER BY CASILLA ) FILA , REPLACE( CASILLA , 'BOX 0' , 'BOX ' )AS CASILLA , NOMBRE  FROM public.fichas 
		WHERE CASILLA IS NOT NULL 
		AND fecha = date( to_char(now(), 'YYYYMMDD'))
		ORDER BY 1 
	";	

//PARA CONSULTAR SI YA EXISTE UN BOX UTILIZADO ONLINE.. 
$query8 = "	
			SELECT BOX , CASE WHEN CASILLA IS NULL THEN '' ELSE 'disabled' END estado 
			FROM ( 
					SELECT 'BOX 01' AS BOX UNION ALL SELECT 'BOX 02' UNION ALL SELECT 'BOX 03' UNION ALL SELECT 'BOX 04' UNION ALL SELECT 'BOX 05' UNION ALL SELECT 'BOX 06' UNION ALL
					SELECT 'BOX 07' UNION ALL SELECT 'BOX 08' UNION ALL SELECT 'BOX 09' UNION ALL SELECT 'BOX 10' UNION ALL SELECT 'BOX 11' UNION ALL SELECT 'BOX 12'
				 ) AS BOXES LEFT OUTER JOIN public.fichas ON BOX = CASILLA AND fecha = date( to_char(now(), 'YYYYMMDD')) 
		";	
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <title>TURNOS CLIENTES</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- <meta http-equiv="Refresh" content="300">   PARA CARGAR LA PAGINA CADA X SEGUNDOS -->
  <link rel="stylesheet" href="bootstrap/3.3.6/bootstrap.min.css">
  <script src="bootstrap/1.12.4/jquery.min.js"></script>
  <script src="bootstrap/3.3.6/bootstrap.min.js"></script>
  <!--<script src='https://code.responsivevoice.org/responsivevoice.js'></script>  -->
  <script src='js/responsivevoice.js'></script>  
  
  
<style>  
.well{
	padding:2px;
}

*{
	font-size:18px;
}
.cab {
	text-align:center;
	font-weight:bold;
	//font-size:25px;
	background-color:#428bca;
	color:white;
	border-radius:10px;
}

.volver {
	float:left;
}

.cab1 , .cab2 , .cab3 {
	text-align:center;
	font-weight:bold;
	//font-size:20px;
	color:white;
	border-radius:10px;
	
}
.cab1{	background-color:#5cb85c; }
.cab2{	background-color:#d9534f; }
.cab3{	background-color:#f0ad4e; }


.det{
	text-align:left;
	//font-size:25px;
}
.det1{
	text-align:left;
	//font-size:25px;
	background-color:#eee;
}

.call {
	background-color:#d9534f;
	color:white;
}
.reloj{
	float:right;
}
.popover .popover{
    width: 660px; /* Max Width of the popover (depending on the container!) */
	max-width:1000px;
}

.popover {
    width: 335px; /* Max Width of the popover (depending on the container!) */
	max-width:1000px;
}
.boton1 {
	width:130px;
	margin:0px;
}

.badge{
	//font-size:25px;
	margin-right:5px;
	background-color:#333;
}
.cerrar{
	position:absolute;
    right: 10px;
    top:   10px;
	color:#777;
	//font-size:25px;
	cursor:pointer;
}
.right.carousel-control , .left.carousel-control{
	width:25px;
}
.carousel-indicators{
	visibility:hidden;
}
#CheckLlamada{
	visibility:hidden;
}
#myCarousel{
	height:100%:
}

.datos .glyphicon-user {
	//color:#d9534f;
	color:#5cb85c;
	font-size:30px;
	float:left;
	width:0px;
	top:-6px;
}
.datos{
	cursor:pointer;
}

.horallegada {
	background-color:#5cb85c; 
	float:left; 
	position:relative; 
	left:-6px;
	top:20px;
	margin:0px;
	width:42px;
	height:17px;
}
.glyphicon-ban-circle , .glyphicon-bullhorn
{
	color:white;
}

</style>
<script type="text/javascript">
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	// FUNCIONES DE COOKIE
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	function getCookie(cname) {
		var name = cname + "=";
		var ca = document.cookie.split(';');
		for(var i = 0; i <ca.length; i++) {
			var c = ca[i];
			while (c.charAt(0)==' ') {
				c = c.substring(1);
			}
			if (c.indexOf(name) == 0) {
				return c.substring(name.length,c.length);
			}
		}
		return "";
	}
	function setCookie(cname, cvalue, exdays) {
		var d = new Date();
		d.setTime(d.getTime() + (exdays*24*60*60*1000));
		var expires = "expires="+d.toUTCString();
		document.cookie = cname + "=" + cvalue + "; " + expires;
	}
	function checkCookie() {
		//console.log(getCookie("pagina"));
		var username=getCookie("pagina");
		if (username!="") {
			setCookie("pagina","0", 1);
		} 
	}
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	$(document).ready(function(){
		var valor = parseInt( getCookie("pagina")); //para saber en que pagina estaba trabajando entonces se recarga alli la pagina
		$('#myCarousel').carousel(valor);
	});	
	//$(document).ready(function(){
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		// CONTROL DE EVENTOS 
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		$('html').on('click', function(e) {
			//////////////////////////////////////////
			//CONTROL DE EVENTO PARA CERRAR EL POPOVER ABIERTO 
			if (typeof $(e.target).data('original-title') == 'undefined' &&
				!$(e.target).parents().is('.popover.in')) {
				$('*').popover('hide');
			}
			
			$("#myCarousel").carousel("pause"); //DETENER EL CAROUSEL EN EL MOMENTO 
			/////////////////////////////////////////////////////////////////
			//ESTA CONDICION INDICA EN QUE PAGINA ESTA TRABAJANDO EL USUARIO 
			if ( $("#myCarousel").find('.item').eq(0).hasClass('active') ) 
			{
				setCookie("pagina","0", 1); //pagina 1
			}else {
				setCookie("pagina","1", 1); //pagina 2
			}
			//console.log(getCookie("pagina"));
			//console.log( $(".table:contains('BOX02')").length );
			//$( "#voice" ).click();
			//console.log( $("#voz:contains('si')").length > 0 ) ;
		});	
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////	
		function cerrarpopover(){$('*').popover('hide');}//funcion para cerrar el popover 

		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////	
		// INTERVALOS DE TIEMPO 
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////	
		setInterval(blink, 2000);
		var stop = 0;
		var segundo = 0;
		timer() ; //corre el timer ... 
		var	MyTimer;
		function timer () 
		{
			MyTimer = setInterval(function(){
									cuentaregresiva();
									//console.log(segundo);
									if(segundo ==1 || segundo == 5 || segundo == 9)
									{
										if ($("#voz:contains('si')").length > 0)
										{
											voz();//LLAMAR POR ALTA VOZ... 
											detener();
										}
									}
									if (segundo == 1)
									{
										fechahora();
									}
								} , 1000);
		}
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//LLAMAR LOS BOXES LLAMA CADA 10 SEGUNDOS... 
		function detener () 
		{
			var jqx = $.ajax({
			  method: "POST",
			  url: "turnosprocesos.php",
			  data: { funcion: "CuantoBoxHay" },
			  dataType: 'html'
			})
			.done(function( msg ) {
				console.log("ok control box");
			  })
			.fail(function( textStatus ) {
				var err = textStatus + ", " + "";	//error;
				console.log( "Request Failed: " + err );
				alert("Hubo un Error al realizar la Transaccion Ajax !!!");
			  })
			jqx.done(function(rs){
			  console.log(rs);
			  var valor = 0;
			  if (rs == 2){ valor = 6000} if (rs == 6){ valor = 18000} if (rs == 10){ valor = 30000 } 
			  if (rs == 3){ valor = 9000} if (rs == 7){ valor = 21000} if (rs == 11){ valor = 33000 } 
			  if (rs == 4){ valor = 12000} if (rs == 8){ valor = 24000} if (rs == 12){ valor = 36000} 
			  if (rs == 5){ valor = 15000} if (rs == 9){ valor = 27000} if (rs == 1 ){ valor = 3000 } 
				  
				clearInterval( MyTimer );
				setTimeout(function(){ 
					timer();
				}, valor);
			});
		}
		function stopTotal() 
		{
			clearInterval( MyTimer );
			$("#myCarousel").carousel("pause");
		}
		function voz ()
		{
			$("#voz" ).click();
		}
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////	
		//ESTA FUNCION HACE EL FLASH DE LA COLUMNA QUE SE ESTA LLAMANDO 
		function blink()
		{
			$(".call:nth-child(2n)").fadeTo(50, 0.1).fadeTo(200, 1.0);
			$( ".call:nth-child(2n)" ).css( "border-radius", "10px" );		
		}
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////	
		//ESTA FUNCION HACE LA CUENTA REGRESIVA PARA QUE SE RECARGUE LA PAGINA 
		function cuentaregresiva() 
		{
			//var tiempo = new Date();
			//var segundo = tiempo.getSeconds(); 
			segundo++ ;
			$('.reloj').text( ' Se actualizara en ' + ( 16 - segundo)  + ' sg');
			if ( ( 15 - segundo) == 0 ) 
			{
				location.reload(true);
				$("#myCarousel").carousel("cycle");
			}
		}
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////	
		//ESTA FUNCION ACTIVA EL POPOVER PARA VER QUE ACCION QUE VA A REALIZAR 
		function cliente(cod)
		{
			if ( cod > 0 ) 
			{
				var selector = '#'+cod+' .badge'; //para verificar si se esta llamando
				var valor = $(selector).html(); //controla si el campo seleccionado ya tiene un box seleccionado entonces deshabilita la llamada 
				var estado1 = ' active '; //en espera
				var estado2 = ' active '; //llamado
				var estado3 = ' active '; //atendido
				var estado4 = ' active '; //llamar
				var estado5 = ' active '; //llamar
				var jqx = $.ajax({
							  method: "POST",
							  url: "turnosprocesos.php",
							  data: { codigo: cod , funcion: "ControlAtencion" },
							  dataType: 'html'
							})
							.done(function( msg ) {
								console.log("ok control box");
							  })
							.fail(function( textStatus ) {
								var err = textStatus + ", " + "";	//error;
								console.log( "Request Failed: " + err );
								alert("Hubo un Error al realizar la Transaccion Ajax !!!");
							  })
							jqx.done(function(rs){
							  console.log(rs);
							  var data = JSON.parse(rs);
							  //boxes = JSON.parse(rs);
							  //console.log( Object.keys( boxes.data ).length ); //para saber la cantidad de registros que trae el json 
							  //console.log( Object.keys( boxes.estado ).length );
							  //$('*').popover('hide');
							  
								if ( data.estado_atencion[0] == 1 ){
									estado1 = ' disabled ';
								}
								if ( data.estado_atencion[0] == 2 ){
									estado2 = ' disabled ';
								}
								if ( data.estado_atencion[0] == 3 || data.estado[0] == 2 ){
									estado3 = ' disabled ';
									estado1 = ' disabled ';
									estado2 = ' disabled ';
									estado4 = ' disabled ';
									estado5 = ' disabled ';
								}
								if ( data.estado_atencion[0] == 4 ){
									estado4 = ' disabled ';
								}
								if ( data.estado_atencion[0] == 5 ){
									estado5 = ' disabled ';
								}
								
								$('#'+cod).popover(
									{
										title: "<center><strong>ACCIONES</strong></center><span class='cerrar glyphicon glyphicon-remove' onclick='cerrarpopover()'></span>", 
										content: "<button type='button' "+estado4+" onclick='accion("+ cod +",4)' class='btn btn-primary btn-block " +estado4+ "' id='llamar'><strong>LLAMAR <span class='glyphicon glyphicon-earphone'></span></strong></button>"+ 
												 "<div class='well'><button type='button' "+estado1+" onclick='accion("+ cod +",1)' class='boton1 btn btn-danger " +estado1+ "'><strong>EN ESPERA</strong></button>"+ 
												 "<button type='button' "+estado2+" onclick='accion("+ cod +",2)' class='boton1 btn btn-warning " +estado2+ "'><strong>LLAMADO</strong></button>"+
												 "<button type='button' "+estado3+" onclick='accion("+ cod +",3)' class='boton1 btn btn-success " +estado3+ "'><strong>ATENDIDO</strong></button>"+
												 "<button type='button' "+estado5+" onclick='accion("+ cod +",5)' class='boton1 btn btn-info " +estado5+ "'><strong>LLEGO <span class='glyphicon glyphicon-user'></span></strong></button></div>",
										html: true, 
										placement: "auto"  
									} 
								);
								$('#'+cod).popover('show'); //muestra el popover 
							});
							
			}
			else{
				alert("No existe codigo seleccionado !!!");	
			}	
		}
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////	
		//ESTA FUNCION LEVANTA EL POPOVER DE LOS BOX Y DAR LA OPCION DE SELECCIONAR UN BOX PARA LA LLAMADA.
		function accion (cod , valor ) 
		{
			var box = -1;
			if ( valor == 4 ) //llamar 
			{
				var boxes ;
				var jqx = $.ajax({
							  method: "POST",
							  url: "turnosprocesos.php",
							  data: { funcion: "controlbox" },
							  dataType: 'html'
							})
							.done(function( msg ) {
								console.log("ok control box");
							  })
							.fail(function( textStatus ) {
								var err = textStatus + ", " + "";	//error;
								console.log( "Request Failed: " + err );
								alert("Hubo un Error al realizar la Transaccion Ajax !!!");
							  })
							jqx.done(function(rs){
							  console.log(rs);
							  boxes = JSON.parse(rs);
								console.log( Object.keys( boxes.data ).length ); //para saber la cantidad de registros que trae el json 
								console.log( Object.keys( boxes.estado ).length );
								//console.log(boxes.estado[0].length);
							  
								var disabled = $("#llamar").is(":disabled"); //deshabilita la opcion de llamar si es que ya ha sido llamada 
								//recibo el codigo del registro  -> cod 
								var box1 = " onclick='actualizar("+ cod +","+ valor +",1)' ";
								var box2 = " onclick='actualizar("+ cod +","+ valor +",2)' "; 
								var box3 = " onclick='actualizar("+ cod +","+ valor +",3)' "; 
								var box4 = " onclick='actualizar("+ cod +","+ valor +",4)' "; 
								var box5 = " onclick='actualizar("+ cod +","+ valor +",5)' "; 
								var box6 = " onclick='actualizar("+ cod +","+ valor +",6)' "; 
								var box7 = " onclick='actualizar("+ cod +","+ valor +",7)' "; 
								var box8 = " onclick='actualizar("+ cod +","+ valor +",8)' "; 
								var box9 = " onclick='actualizar("+ cod +","+ valor +",9)' "; 
								var box10 = " onclick='actualizar("+ cod +","+ valor +",10)' "; 
								var box11 = " onclick='actualizar("+ cod +","+ valor +",11)' "; 
								var box12 = " onclick='actualizar("+ cod +","+ valor +",12)' "; 
								///CONTROL DE BOXES UTILIZADOS desde html ... 
								//if ( $(".table:contains('BOX01')").length > 0 ){ box1  = 'disabled' } if ( $(".table:contains('BOX07')").length > 0 ){ box7  = 'disabled' }
								//if ( $(".table:contains('BOX02')").length > 0 ){ box2  = 'disabled' } if ( $(".table:contains('BOX08')").length > 0 ){ box8  = 'disabled' }
								//if ( $(".table:contains('BOX03')").length > 0 ){ box3  = 'disabled' } if ( $(".table:contains('BOX09')").length > 0 ){ box9  = 'disabled' }
								//if ( $(".table:contains('BOX04')").length > 0 ){ box4  = 'disabled' } if ( $(".table:contains('BOX10')").length > 0 ){ box10 = 'disabled' }
								//if ( $(".table:contains('BOX05')").length > 0 ){ box5  = 'disabled' } if ( $(".table:contains('BOX11')").length > 0 ){ box11 = 'disabled' }
								//if ( $(".table:contains('BOX06')").length > 0 ){ box6  = 'disabled' } if ( $(".table:contains('BOX12')").length > 0 ){ box12 = 'disabled' }

								//CONTROL CON BASE DATOS... CON AJAX
								if ( boxes.estado[0].length > 0 ){ box1  = 'disabled'; } if ( boxes.estado[6].length  > 0 ){ box7  = 'disabled'; }
								if ( boxes.estado[1].length > 0 ){ box2  = 'disabled'; } if ( boxes.estado[7].length  > 0 ){ box8  = 'disabled'; }
								if ( boxes.estado[2].length > 0 ){ box3  = 'disabled'; } if ( boxes.estado[8].length  > 0 ){ box9  = 'disabled'; }
								if ( boxes.estado[3].length > 0 ){ box4  = 'disabled'; } if ( boxes.estado[9].length  > 0 ){ box10 = 'disabled'; }
								if ( boxes.estado[4].length > 0 ){ box5  = 'disabled'; } if ( boxes.estado[10].length > 0 ){ box11 = 'disabled'; }
								if ( boxes.estado[5].length > 0 ){ box6  = 'disabled'; } if ( boxes.estado[11].length > 0 ){ box12 = 'disabled'; }

								//abrir el popover de los boxes .. 	
								$('#llamar').popover(
								{
									title:"<center><strong>ASIGNAR BOX </strong></center><span class='cerrar glyphicon glyphicon-remove' onclick='cerrarpopover()'></span>",
									content:
										"<div class='well'>"+
											"<div class='btn-group btn-group-lg'>"+
												"<a href='#' class='btn btn-primary btn-lg' "+ box1  +" >BOX 01</a>"+
												"<a href='#' class='btn btn-primary btn-lg' "+ box2  +" >BOX 02</a>"+
												"<a href='#' class='btn btn-primary btn-lg' "+ box3  +" >BOX 03</a>"+
												"<a href='#' class='btn btn-primary btn-lg' "+ box4  +" >BOX 04</a>"+
												"<a href='#' class='btn btn-primary btn-lg' "+ box5  +" >BOX 05</a>"+
												"<a href='#' class='btn btn-primary btn-lg' "+ box6  +" >BOX 06</a>"+
											"</div>"+
											"<div class='btn-group btn-group-lg'>"+
												"<a href='#' class='btn btn-primary btn-lg' "+ box7  +" >BOX 07</a>"+
												"<a href='#' class='btn btn-primary btn-lg' "+ box8  +" >BOX 08</a>"+
												"<a href='#' class='btn btn-primary btn-lg' "+ box9  +" >BOX 09</a>"+
												"<a href='#' class='btn btn-primary btn-lg' "+ box10 +" >BOX 10</a>"+
												"<a href='#' class='btn btn-primary btn-lg' "+ box11 +" >BOX 11</a>"+
												"<a href='#' class='btn btn-primary btn-lg' "+ box12 +" >BOX 12</a>"+
											"</div>"+
										"</div>",
									html:true,
									placement:"auto"  
								}
								);
								if ( $('#llamar').data('bs.popover').tip().hasClass('in') == false )
								{
									$('#llamar').popover('show');
								}
							}); //FIN AJAX
			}else{
				//alert(cod +' - '+valor);
				if (valor == 3) //CONTROLAMOS SI VA A MARCAR COMO ATENDIDO QUE ESTE SETEADO LA SESSION ID_USUARIO 
				{
					var jqx = $.ajax({
								  method: "POST",
								  url: "turnosprocesos.php",
								  data: { funcion: "ControlUsuario" },
								  dataType: 'html'
								})
								.done(function( msg ) {
									console.log("ok control box");
								  })
								.fail(function( textStatus ) {
									var err = textStatus + ", " + "";	//error;
									console.log( "Request Failed: " + err );
									alert("Hubo un Error al realizar la Transaccion Ajax !!!");
								  })
								jqx.done(function(rs){
								  console.log(rs);
								  if (rs == 'si'){
									  actualizar(cod , valor , box );
								  }else {
									  alert("Para realizar esta operacion debe ingresar su usuario y contraseña");
									  window.location.assign("http://192.168.10.214/reservasgarden/index.php");
								  }
								  
								});
				}else {
					actualizar(cod , valor , box );
				}	
			}	
		
		}
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////	
		//ESTA FUNCION ACTUALIZA LOS DATOS PARA MOSTRAR EN LA GRILLA 
	
		function actualizar(cod, valor , box ) 
		{
				//alert(cod +' - '+valor+' - '+box);
				var jqx = $.ajax({
							  method: "POST",
							  url: "turnosprocesos.php",
							  data: { codigo: cod , estado: valor , casilla: box , funcion: "actualizar" },
							  dataType: 'html'
							})
							.done(function( msg ) {
								$('*').popover('hide');
								//fco123
								location.reload();
							  })
							.fail(function( textStatus ) {
								var err = textStatus + ", " + "";	//error;
								console.log( "Request Failed: " + err );
								alert("Hubo un Error al realizar la Transaccion Ajax !!!");
							  })
							jqx.done(function(rs){
							  console.log(rs);
							  //var boxes = JSON.parse(rs);
							  //console.log( Object.keys( boxes.data ).length ) ;
							  //console.log( Object.keys( boxes.estado ).length ) ;
							});
		}
	//});
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////	
		//ESTA FUNCION LEVANTA EL POPOVER DE LOS BOX Y DAR LA OPCION DE SELECCIONAR UN BOX PARA LA LLAMADA.
		//CUALQUIERA DE LAS DOS FUNCIONES LLAMAR FUNCIONAN... 
		function llamar1 (texto)
		{
			var msg = new SpeechSynthesisUtterance();
			var voices = window.speechSynthesis.getVoices();
			msg.voice = voices[5]; // Note: some voices don't support altering params
			msg.voiceURI = 'Google español';
			msg.name = "Google español";
			msg.volume = 1; // 0 to 1
			msg.rate = 1; // 0.1 to 10
			msg.pitch = 1; //0 to 2
			msg.text = 'box 1';
			msg.lang = 'es-ES';
			console.log( window.speechSynthesis.getVoices());
			window.speechSynthesis.speak(msg);
		}
		
		function fechahora()
		{
			var jqx = $.ajax({
			  method: "POST",
			  url: "turnosprocesos.php",
			  data: { funcion: "FechaHora" },
			  dataType: 'html'
			})
			.done(function( msg ) {
				console.log('ok consulta de FechaHora');
			  })
			.fail(function( textStatus ) {
				var err = textStatus + ", " + "";	//error;
				console.log( "Request Failed: " + err );
				//alert("FechaHora - Hubo un Error al realizar la Transaccion Ajax !!!");
			  })
			jqx.done(function(rs){
			  //console.log(rs);
			  var data = JSON.parse(rs);
			  var valor = data.fecha[0] + ' - ' + data.hora[0] ;
			  //console.log(valor);
			  $( ".fechahora" ).html(valor);
			  //console.log( Object.keys( boxes.data ).length ) ;
			  //console.log( Object.keys( boxes.estado ).length ) ;
			});

		}
</script>

</head>
<body>
<div class= "well"> 


	<div id="myCarousel" data-ride="carousel" class="carousel slide" data-interval="8000" style="min-height: 600px;">
    <!-- Indicators -->
    <ol class="carousel-indicators">
      <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
      <li data-target="#myCarousel" data-slide-to="1"></li>
    </ol>
		<!-- Wrapper for slides -->
		<div class="carousel-inner" role="listbox">
			<div class="item active" style="min-height: 600px;">
				<!-- PRIMERA PARTE DEL TABLERO -->
				<table class="table table-bordered ">
					<thead>
						<th class="cab" colspan="24"> 
							<button type="button" class="volver btn btn-primary" onclick="window.location.href='cupo.php'"> <span class="glyphicon glyphicon-log-in"></span>Volver</button>
							<i>TURNOS CLIENTES <span class="fechahora"></span></i> <span class= "reloj label label-primary"></span>
							<a href="#" onclick="stopTotal()"><span class="glyphicon glyphicon-ban-circle"></span></a>
							<a id="voz" onclick="<?php
													$exq7	= pg_query($con, $query7);
													$texto = '';
													$mostrar = '' ;
													echo "responsiveVoice.speak(' ";
													while ($res = pg_fetch_array($exq7))
													{
														$texto =  $texto . $res["casilla"] . '; ' . $res["nombre"] . ', ';
														$mostrar = $mostrar . '<span class="mostrar label label-danger"><span class=" mostrar badge"> ' . $res["casilla"] . '</span>' . $res["nombre"] . '</span> ' ;
													}
													echo $texto;
													echo " ', 'Spanish Female', {rate:0.9})";
												?> " class="glyphicon glyphicon-bullhorn"><span id="CheckLlamada"><?php if( strlen( $texto ) > 0 ){ echo "si"; }else{ echo "no";} ?></span></a>
						</th>
					</thead>
					
					<thead>
						<th class="cab" colspan="2">07:30</th> 
						<th class="cab" colspan="2">07:45</th> 
						<th class="cab" colspan="2">08:00</th> 
						<th class="cab" colspan="2">08:15</th> 
						<th class="cab" colspan="2">08:30</th> 
						<th class="cab" colspan="2">08:45</th> 
					<thead>
					<thead>
						<th class="cab2" colspan="12"><b>EN ESPERA...   <span class="glyphicon glyphicon-arrow-down"></span></b></th> 
					<thead>
					
					<tbody>
						<?php
							$exq	= pg_query($con, $query);
							while ($res = pg_fetch_array($exq))
							{
									echo "<tr>";
										echo "<td class='det1'> <span class='label label-danger'>" . $res['item1'] . "</span></td>"; echo "<td class='". $res['call1'] ."det1'><span class='datos' id='" . $res['cod1'] . "' onclick='cliente(". $res['cod1'] .")'><span class='badge'>".$res['casi1']."</span><span data-toggle='tooltip' title='Ya Llego' class='" . $res['llego1'] . "'></span><span class='horallegada badge'>" . $res['horallegada1'] . "</span>" . $res['col1'] . "</span></td>";
										echo "<td class='det'>  <span class='label label-danger'>" . $res['item2'] . "</span></td>"; echo "<td class='". $res['call2'] ."det'><span  class='datos' id='" . $res['cod2'] . "' onclick='cliente(". $res['cod2'] .")'><span class='badge'>".$res['casi2']."</span><span data-toggle='tooltip' title='Ya Llego' class='" . $res['llego2'] . "'></span><span class='horallegada badge'>" . $res['horallegada2'] . "</span>" . $res['col2'] . "</span></td>";
										echo "<td class='det1'> <span class='label label-danger'>" . $res['item3'] . "</span></td>"; echo "<td class='". $res['call3'] ."det1'><span class='datos' id='" . $res['cod3'] . "' onclick='cliente(". $res['cod3'] .")'><span class='badge'>".$res['casi3']."</span><span data-toggle='tooltip' title='Ya Llego' class='" . $res['llego3'] . "'></span><span class='horallegada badge'>" . $res['horallegada3'] . "</span>" . $res['col3'] . "</span></td>";
										echo "<td class='det'>  <span class='label label-danger'>" . $res['item4'] . "</span></td>"; echo "<td class='". $res['call4'] ."det'><span  class='datos' id='" . $res['cod4'] . "' onclick='cliente(". $res['cod4'] .")'><span class='badge'>".$res['casi4']."</span><span data-toggle='tooltip' title='Ya Llego' class='" . $res['llego4'] . "'></span><span class='horallegada badge'>" . $res['horallegada4'] . "</span>" . $res['col4'] . "</span></td>";
										echo "<td class='det1'> <span class='label label-danger'>" . $res['item5'] . "</span></td>"; echo "<td class='". $res['call5'] ."det1'><span class='datos' id='" . $res['cod5'] . "' onclick='cliente(". $res['cod5'] .")'><span class='badge'>".$res['casi5']."</span><span data-toggle='tooltip' title='Ya Llego' class='" . $res['llego5'] . "'></span><span class='horallegada badge'>" . $res['horallegada5'] . "</span>" . $res['col5'] . "</span></td>";
										echo "<td class='det'>  <span class='label label-danger'>" . $res['item6'] . "</span></td>"; echo "<td class='". $res['call6'] ."det'><span  class='datos' id='" . $res['cod6'] . "' onclick='cliente(". $res['cod6'] .")'><span class='badge'>".$res['casi6']."</span><span data-toggle='tooltip' title='Ya Llego' class='" . $res['llego6'] . "'></span><span class='horallegada badge'>" . $res['horallegada6'] . "</span>" . $res['col6'] . "</span></td>";
									echo "</tr>";
							}
						?>
					</tbody>
					<thead>
						<th class="cab3" colspan="12"><b>LLAMADOS...   <span class="glyphicon glyphicon-arrow-down"></span></b></th> 
					<thead>
					<tbody>
					<!-- <button type='button' class='btn btn-success btn-block'> ATENDIDO </button> -->
						<?php
							$exq3	= pg_query($con, $query3);
							while ($res = pg_fetch_array($exq3))
							{
									echo "<tr>";
										echo "<td class='det1'> <span class='label label-warning'>" . $res['item1'] . "</span></td>"; echo "<td class='" . $res['call1'] . "det1'><span class='datos' id='" . $res['cod1'] . "' onclick='cliente(" . $res['cod1'] . ")'><span class='badge'>" .$res['casi1'] . "</span>" . $res['col1'] . "</span></td>";
										echo "<td class='det'>  <span class='label label-warning'>" . $res['item2'] . "</span></td>"; echo "<td class='" . $res['call2'] . "det'><span  class='datos' id='" . $res['cod2'] . "' onclick='cliente(" . $res['cod2'] . ")'><span class='badge'>" .$res['casi2'] . "</span>" . $res['col2'] . "</span></td>";
										echo "<td class='det1'> <span class='label label-warning'>" . $res['item3'] . "</span></td>"; echo "<td class='" . $res['call3'] . "det1'><span class='datos' id='" . $res['cod3'] . "' onclick='cliente(" . $res['cod3'] . ")'><span class='badge'>" .$res['casi3'] . "</span>" . $res['col3'] . "</span></td>";
										echo "<td class='det'>  <span class='label label-warning'>" . $res['item4'] . "</span></td>"; echo "<td class='" . $res['call4'] . "det'><span  class='datos' id='" . $res['cod4'] . "' onclick='cliente(" . $res['cod4'] . ")'><span class='badge'>" .$res['casi4'] . "</span>" . $res['col4'] . "</span></td>";
										echo "<td class='det1'> <span class='label label-warning'>" . $res['item5'] . "</span></td>"; echo "<td class='" . $res['call5'] . "det1'><span class='datos' id='" . $res['cod5'] . "' onclick='cliente(" . $res['cod5'] . ")'><span class='badge'>" .$res['casi5'] . "</span>" . $res['col5'] . "</span></td>";
										echo "<td class='det'>  <span class='label label-warning'>" . $res['item6'] . "</span></td>"; echo "<td class='" . $res['call6'] . "det'><span  class='datos' id='" . $res['cod6'] . "' onclick='cliente(" . $res['cod6'] . ")'><span class='badge'>" .$res['casi6'] . "</span>" . $res['col6'] . "</span></td>";
									echo "</tr>";
							}
						?>		
					</tbody>
					
					<thead>
						<th class="cab1" colspan="12"><b>ATENDIDOS...   <span class="glyphicon glyphicon-arrow-down"></span></b></th> 
					<thead>
					<tbody>
					<!-- <button type='button' class='btn btn-success btn-block'> ATENDIDO </button> -->
						<?php
							$exq2	= pg_query($con, $query2);
							while ($res = pg_fetch_array($exq2))
							{
									echo "<tr>";
										echo "<td class='det1'> <span class='label label-success'>" . $res['item1'] . "</span></td>"; echo "<td class='". $res['call1'] ."det1'><span class='datos' id='" . $res['cod1'] . "' onclick='cliente(". $res['cod1'] .")'><span class='badge'>".$res['casi1']."</span>" . $res['col1'] . "</span></td>";
										echo "<td class='det'>  <span class='label label-success'>" . $res['item2'] . "</span></td>"; echo "<td class='". $res['call2'] ."det'><span  class='datos' id='" . $res['cod2'] . "' onclick='cliente(". $res['cod2'] .")'><span class='badge'>".$res['casi2']."</span>" . $res['col2'] . "</span></td>";
										echo "<td class='det1'> <span class='label label-success'>" . $res['item3'] . "</span></td>"; echo "<td class='". $res['call3'] ."det1'><span class='datos' id='" . $res['cod3'] . "' onclick='cliente(". $res['cod3'] .")'><span class='badge'>".$res['casi3']."</span>" . $res['col3'] . "</span></td>";
										echo "<td class='det'>  <span class='label label-success'>" . $res['item4'] . "</span></td>"; echo "<td class='". $res['call4'] ."det'><span  class='datos' id='" . $res['cod4'] . "' onclick='cliente(". $res['cod4'] .")'><span class='badge'>".$res['casi4']."</span>" . $res['col4'] . "</span></td>";
										echo "<td class='det1'> <span class='label label-success'>" . $res['item5'] . "</span></td>"; echo "<td class='". $res['call5'] ."det1'><span class='datos' id='" . $res['cod5'] . "' onclick='cliente(". $res['cod5'] .")'><span class='badge'>".$res['casi5']."</span>" . $res['col5'] . "</span></td>";
										echo "<td class='det'>  <span class='label label-success'>" . $res['item6'] . "</span></td>"; echo "<td class='". $res['call6'] ."det'><span  class='datos' id='" . $res['cod6'] . "' onclick='cliente(". $res['cod6'] .")'><span class='badge'>".$res['casi6']."</span>" . $res['col6'] . "</span></td>";
									echo "</tr>";
							}
						?>		
					</tbody>
				</table>
			</div>
			
			<div class="item">
				<!-- SEGUNDA PARTE DEL TABLERO -->
				<table class="table table-bordered ">
					<thead><th class="cab" colspan="24"><button type="button" class=" volver btn btn-primary" onclick="window.location.href='cupo.php'"> <span class="glyphicon glyphicon-log-in"></span>Volver</button>   <i>TURNOS CLIENTES <span class="fechahora"></span></i> <span class= "reloj label label-primary"></span></th></thead>
					
					<thead>
						<th class="cab" colspan="2">09:00</th> 
						<th class="cab" colspan="2">09:15</th> 
						<th class="cab" colspan="2">09:30</th> 
						<th class="cab" colspan="2">09:45</th> 
						<th class="cab" colspan="2">10:30</th> 
						<th class="cab" colspan="2">14:30</th> 
					<thead>
					<thead>
						<th class="cab2" colspan="12"><b>EN ESPERA...   <span class="glyphicon glyphicon-arrow-down"></span></b></th> 
					<thead>
					
					<tbody>
						<?php
							$exq4	= pg_query($con, $query4);
							while ($res = pg_fetch_array($exq4))
							{
									echo "<tr>";
										echo "<td class='det1'> <span class='label label-danger'>" . $res['item7']  . "</span></td>"; echo "<td class='" . $res['call7']  . "det1'><span class='datos' id='" . $res['cod7']  . "' onclick='cliente(" . $res['cod7']  . ")'><span class='badge'>" . $res['casi7']  . "</span><span data-toggle='tooltip' title='Ya Llego' class='" . $res['llego7']  . "'></span><span class='horallegada badge'>" . $res['horallegada7']  . "</span>" . $res['col7']  . "</span></td>";
										echo "<td class='det' > <span class='label label-danger'>" . $res['item8']  . "</span></td>"; echo "<td class='" . $res['call8']  . "det'><span  class='datos' id='" . $res['cod8']  . "' onclick='cliente(" . $res['cod8']  . ")'><span class='badge'>" . $res['casi8']  . "</span><span data-toggle='tooltip' title='Ya Llego' class='" . $res['llego8']  . "'></span><span class='horallegada badge'>" . $res['horallegada8']  . "</span>" . $res['col8']  . "</span></td>";
										echo "<td class='det1'> <span class='label label-danger'>" . $res['item9']  . "</span></td>"; echo "<td class='" . $res['call9']  . "det1'><span class='datos' id='" . $res['cod9']  . "' onclick='cliente(" . $res['cod9']  . ")'><span class='badge'>" . $res['casi9']  . "</span><span data-toggle='tooltip' title='Ya Llego' class='" . $res['llego9']  . "'></span><span class='horallegada badge'>" . $res['horallegada9']  . "</span>" . $res['col9']  . "</span></td>";
										echo "<td class='det' > <span class='label label-danger'>" . $res['item10'] . "</span></td>"; echo "<td class='" . $res['call10'] . "det'><span  class='datos' id='" . $res['cod10'] . "' onclick='cliente(" . $res['cod10'] . ")'><span class='badge'>" . $res['casi10'] . "</span><span data-toggle='tooltip' title='Ya Llego' class='" . $res['llego10'] . "'></span><span class='horallegada badge'>" . $res['horallegada10'] . "</span>" . $res['col10'] . "</span></td>";
										echo "<td class='det1'> <span class='label label-danger'>" . $res['item11'] . "</span></td>"; echo "<td class='" . $res['call11'] . "det1'><span class='datos' id='" . $res['cod11'] . "' onclick='cliente(" . $res['cod11'] . ")'><span class='badge'>" . $res['casi11'] . "</span><span data-toggle='tooltip' title='Ya Llego' class='" . $res['llego11'] . "'></span><span class='horallegada badge'>" . $res['horallegada11'] . "</span>" . $res['col11'] . "</span></td>";
										echo "<td class='det' > <span class='label label-danger'>" . $res['item12'] . "</span></td>"; echo "<td class='" . $res['call12'] . "det'><span  class='datos' id='" . $res['cod12'] . "' onclick='cliente(" . $res['cod12'] . ")'><span class='badge'>" . $res['casi12'] . "</span><span data-toggle='tooltip' title='Ya Llego' class='" . $res['llego12'] . "'></span><span class='horallegada badge'>" . $res['horallegada12'] . "</span>" . $res['col12'] . "</span></td>";
									echo "</tr>";
							}
						?>
					</tbody>
					<thead>
						<th class="cab3" colspan="12"><b>LLAMADOS...   <span class="glyphicon glyphicon-arrow-down"></span></b></th> 
					<thead>
					<tbody>
					<!-- <button type='button' class='btn btn-success btn-block'> ATENDIDO </button> -->
						<?php
							$exq6	= pg_query($con, $query6);
							while ($res = pg_fetch_array($exq6))
							{
									echo "<tr>";
										echo "<td class='det1'> <span class='label label-warning'>" . $res['item7'] . "</span></td>"; echo "<td class='". $res['call7'] ."det1'><span class='datos' id='" . $res['cod7'] . "' onclick='cliente(". $res['cod7'] .")'><span class='badge'>".$res['casi7']."</span>" . $res['col7'] . "</span></td>";
										echo "<td class='det'>  <span class='label label-warning'>" . $res['item8'] . "</span></td>"; echo "<td class='". $res['call8'] ."det'><span  class='datos' id='" . $res['cod8'] . "' onclick='cliente(". $res['cod8'] .")'><span class='badge'>".$res['casi8']."</span>" . $res['col8'] . "</span></td>";
										echo "<td class='det1'> <span class='label label-warning'>" . $res['item9'] . "</span></td>"; echo "<td class='". $res['call9'] ."det1'><span class='datos' id='" . $res['cod9'] . "' onclick='cliente(". $res['cod9'] .")'><span class='badge'>".$res['casi9']."</span>" . $res['col9'] . "</span></td>";
										echo "<td class='det'>  <span class='label label-warning'>" . $res['item10'] . "</span></td>"; echo "<td class='". $res['call10'] ."det'><span  class='datos' id='" . $res['cod10'] . "' onclick='cliente(". $res['cod10'] .")'><span class='badge'>".$res['casi10']."</span>" . $res['col10'] . "</span></td>";
										echo "<td class='det1'> <span class='label label-warning'>" . $res['item11'] . "</span></td>"; echo "<td class='". $res['call11'] ."det1'><span class='datos' id='" . $res['cod11'] . "' onclick='cliente(". $res['cod11'] .")'><span class='badge'>".$res['casi11']."</span>" . $res['col11'] . "</span></td>";
										echo "<td class='det'>  <span class='label label-warning'>" . $res['item12'] . "</span></td>"; echo "<td class='". $res['call12'] ."det'><span  class='datos' id='" . $res['cod12'] . "' onclick='cliente(". $res['cod12'] .")'><span class='badge'>".$res['casi12']."</span>" . $res['col12'] . "</span></td>";
									echo "</tr>";
							}
						?>		
					</tbody>
					
					<thead>
						<th class="cab1" colspan="12"><b>ATENDIDOS...   <span class="glyphicon glyphicon-arrow-down"></span></b></th> 
					<thead>
					<tbody>
					<!-- <button type='button' class='btn btn-success btn-block'> ATENDIDO </button> -->
						<?php
							$exq5	= pg_query($con, $query5);
							while ($res = pg_fetch_array($exq5))
							{
									echo "<tr>";
										echo "<td class='det1'> <span class='label label-success'>" . $res['item7'] . "</span></td>"; echo "<td class='". $res['call7'] ."det1'><span class='datos' id='" . $res['cod7'] . "' onclick='cliente(". $res['cod7'] .")'><span class='badge'>".$res['casi7']."</span>" . $res['col7'] . "</span></td>";
										echo "<td class='det'>  <span class='label label-success'>" . $res['item8'] . "</span></td>"; echo "<td class='". $res['call8'] ."det'><span  class='datos' id='" . $res['cod8'] . "' onclick='cliente(". $res['cod8'] .")'><span class='badge'>".$res['casi8']."</span>" . $res['col8'] . "</span></td>";
										echo "<td class='det1'> <span class='label label-success'>" . $res['item9'] . "</span></td>"; echo "<td class='". $res['call9'] ."det1'><span class='datos' id='" . $res['cod9'] . "' onclick='cliente(". $res['cod9'] .")'><span class='badge'>".$res['casi9']."</span>" . $res['col9'] . "</span></td>";
										echo "<td class='det'>  <span class='label label-success'>" . $res['item10'] . "</span></td>"; echo "<td class='". $res['call10'] ."det'><span  class='datos' id='" . $res['cod10'] . "' onclick='cliente(". $res['cod10'] .")'><span class='badge'>".$res['casi10']."</span>" . $res['col10'] . "</span></td>";
										echo "<td class='det1'> <span class='label label-success'>" . $res['item11'] . "</span></td>"; echo "<td class='". $res['call11'] ."det1'><span class='datos' id='" . $res['cod11'] . "' onclick='cliente(". $res['cod11'] .")'><span class='badge'>".$res['casi11']."</span>" . $res['col11'] . "</span></td>";
										echo "<td class='det'>  <span class='label label-success'>" . $res['item12'] . "</span></td>"; echo "<td class='". $res['call12'] ."det'><span  class='datos' id='" . $res['cod12'] . "' onclick='cliente(". $res['cod12'] .")'><span class='badge'>".$res['casi12']."</span>" . $res['col12'] . "</span></td>";
									echo "</tr>";
							}
						?>		
					</tbody>
				</table>
			</div>
		</div>
		
		<!-- Left and right controls -->
		<a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
		  <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
		  <span class="sr-only">Previous</span>
		</a>
		<a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
		  <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
		  <span class="sr-only">Next</span>
		</a>		
	</div>	
</div>
</body>
</html>