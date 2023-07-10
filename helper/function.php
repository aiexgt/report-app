<?php

function mostrarRespuesta($texto){

    if($texto == 'SI' || $texto == 'si' || $texto == 'Si' || $texto == 'sI'){
        return 'Si';
    }
    else if($texto == 'NO' || $texto == 'no' || $texto == 'No' || $texto == 'nO'){
        return 'No';
    }
    else if($texto == 'N/A' || $texto == 'n/a' || $texto == 'N/a' || $texto == 'n/A' || $texto == ''){
        return 'N/A';
    }
    else{
        return 'Si';
    }

}

function mostrarPunteo($respuesta, $ponderado){

    $texto = mostrarRespuesta($respuesta);

    if($texto == 'Si' || $texto == 'N/A'){
        return $ponderado;
    }
    else if($texto == 'No'){
        return 0;
    }
    else{
        return $ponderado;
    }
}

function mostrarMes($fecha){
     $mes = date('m', strtotime($fecha));
     $nombresMeses = array(
         'Enero',
         'Febrero',
         'Marzo',
         'Abril',
         'Mayo',
         'Junio',
         'Julio',
         'Agosto',
         'Septiembre',
         'Octubre',
         'Noviembre',
         'Diciembre'
     );
     $nombreMes = $nombresMeses[(int)$mes - 1];
     return $nombreMes;

}