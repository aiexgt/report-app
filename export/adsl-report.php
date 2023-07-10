<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use PhpOffice\PhpSpreadsheet\IOFactory;

include_once "../resources/dompdf/vendor/autoload.php";
include "../helper/function.php";

use Dompdf\Dompdf;

$nombre_archivo = $_FILES['file']['name'];
$tipo_archivo = $_FILES['file']['type'];

if ($tipo_archivo == "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" || $tipo_archivo == "application/vnd.ms-excel.sheet.macroEnabled.12") {
    if (move_uploaded_file($_FILES['file']['tmp_name'],  '../temp/' . $nombre_archivo)) {

        require "../resources/phpSpreadsheet/vendor/autoload.php";
        $document = IOFactory::load("../temp/" . $nombre_archivo);
        $sheet = $document->getSheet(0);

        $columnas = array(
            "A" => "orden_de_servicio",
            "B" => "marca_temporal",
            "C" => "puntuacion",
            "D" => "fecha",
            "E" => "mes_evaluado",
            "F" => "gerencia",
            "G" => "area_operativa",
            "H" => "nombre_de_tecnico",
            "I" => "nombre_del_supervisor",
            "J" => "orden_de_servicio_2",
            "K" => "conexion_en_caja_terminal_en_norma",
            "L" => "instalacion_de_cable_nuevo_normado_por_claro",
            "M" => "uso_de_amarre_argolla_o_tensor_para_cable_de_acometida_con_catenaria_adecuada",
            "N" => "trayectoria_del_cable_de_acometida_de_acuerdo_a_la_norma",
            "O" => "acometida_externa_sin_empalmes",
            "P" => "uso_de_postes_uso_de_ductos_de_claro",
            "Q" => "cliente_permite_acceso",
            "R" => "estetica_en_la_instalacion_y_cable_normado_por_claro",
            "S" => "uso_adecuado_de_grapas_silicone",
            "T" => "realizacion_de_retorno_de_linea_telefonica_a_solicitud_del_cliente",
            "U" => "fijacion_y_conexion_de_dispositivos_terminales",
            "V" => "conexion_y_configuracion_de_cpe_adecuada",
            "W" => "acometida_interna_sin_empalmes",
            "X" => "materiales_homologados_por_claro",
            "Y" => "utilizo_medidor_decibelimetro_subiendo_las_mediciones_al_servidor",
            "Z" => "las_mediciones_son_correctas",
            "AA" => "herramienta_para_regletas",
            "AB" => "herramienta_entorchadora_reversible_2_x_24",
            "AC" => "micro_telefono",
            "AD" => "llave_para_armario",
            "AE" => "equipo_medicion_homologado_de_pares_cobre_y_adsl_veex",
            "AF" => "escalera",
            "AG" => "alicate",
            "AH" => "pinza",
            "AI" => "corta_alambre",
            "AJ" => "destornilladores",
            "AK" => "navaja_curva",
            "AL" => "generador_de_tono_con_punta_inductiva",
            "AM" => "taladro_tipo_industrial_de_1_2",
            "AN" => "broca_pasa_muros_12_pulgadas_1_2_o_3_8",
            "AO" => "guia_acerada_de_30_metros",
            "AP" => "cadena_con_candados_asegurar_escalera_a_vehiculo",
            "AQ" => "camisa",
            "AR" => "pantalon",
            "AS" => "botas",
            "AT" => "gafete",
            "AU" => "faja",
            "AV" => "cinturon_de_seguridad_con_amarre_a_poste",
            "AW" => "chaleco_preventivo",
            "AX" => "casco_de_proteccion",
            "AY" => "guantes_de_cuero",
            "AZ" => "capa_impermeable",
            "BA" => "aspecto_personal",
            "BB" => "logotipo_de_empresa",
            "BC" => "carroceria",
            "BD" => "porta_escalera",
            "BE" => "estado_de_neumaticos",
            "BF" => "rotulado_de_unidad",
            "BG" => "orden_y_limpieza",
            "BH" => "tecnico_certificado_por_claro",
            "BI" => "evidencia_fotografica",
            "BJ" => "segundo_archivo",
            "BK" => "tercer_archivo",
            "BL" => "calidad_tecnica",
            "BM" => "herramienta",
            "BN" => "uniforme",
            "BO" => "vehiculo",
            "BP" => "tecnico_certificado",
            "BQ" => "no_supervision",
            "BR" => "tecnologia",
            "BS" => "observaciones"
        );

        $i = 3;
        $data = array();

        while ($sheet->getCell('A' . $i)->getCalculatedValue() != '') {

            $registro = array();
            foreach ($columnas as $key => $value) {
                $registro[$value] = $sheet->getCell($key . '' . $i)->getCalculatedValue();
            }
            $data[] = $registro;
            $i++;
        }

        if (count($data) > 0) {

            $html = '
                <!DOCTYPE html>
                <html>
                <head>
                    <title>Reporte en Carta</title>
                    <style>
                        @page {
                            size: letter;
                            margin: 0.5in;
                        }
                        body {
                            font-family: Arial, sans-serif;
                            font-size: 12px;
                        }
                        .container {
                            display: table;
                            width: 100%;
                            border-collapse: collapse;
                        }
                        .row {
                            display: table-row;
                        }
                        .cell {
                            display: table-cell;
                            padding: 2px;
                        }
                        .cell-table {
                            display: table-cell;
                            border: 1px solid gray;
                        }
                        .cb{
                            border: 2px solid #000;
                        }
                        table{
                            width:100%;
                            font-size:11px;
                            border-collapse: collapse;
                            border: 2px solid #000;
                        }
                        table th{
                            background-color: #000;
                            color: #fff;
                            border: 2px solid #000;
                        }
                        table td{
                            border: 1px solid #000;
                        }
                        .w-10{
                            width:10%;
                        }
                        .w-20{
                            width:20%;
                        }
                        .w-25{
                            width:25%;
                        }
                        .w-30{
                            width:30%;
                        }
                        .w-40{
                            width:40%;
                        }
                        .w-50{
                            width:50%;
                        }
                        .w-60{
                            width:60%;
                        }
                        .w-70{
                            width:70%;
                        }
                        .w-80{
                            width:80%;
                        }
                        .w-auto{
                            width:auto;
                        }
                        .bg-secondary{
                            background-color:#A3A3A3;
                        }
                        .text-center{
                            text-align: center;
                        }
                        .text-start{
                            text-align: left;
                        }
                        .text-end{
                            text-align: right;
                        }
                        .fw-11{
                            font-size:11px;
                        }
                        .evidencia{
                            max-height:22cm;
                            max-width:17cm;
                            height:auto;
                            width:auto;
                        }
                        .fw{
                            font-weight:bold;
                        }
                    </style>
                </head>
                <body>
            ';

            foreach ($data as $key => $value) {

                if($key != 0){
                    $html .= '
                        <div style="page-break-after:always;"></div>
                    ';
                }
                
                $value['fecha'] = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value['fecha']);

                $html .= '
                    <div class="container">
                    <div class="row">
                        <div class="cell">
                            <img src="../src/assets/img/logo.png" style="width:80px;">
                        </div>
                        <div class="cell text-center" colspan="4"><h4>** Evaluación de Calidad Técnica ADSL Instalaciones</h4></div>
                        <div class="cell" style="width:80px;"></div>
                    </div>
                    <div class="row">
                        <div class="cell">Mes evaluado</div>
                        <div class="cell cb text-center" colspan="2">'.$value['mes_evaluado'].'</div>
                        <div class="cell text-end">Fecha</div>
                        <div class="cell cb text-center" colspan="2">'.$value['fecha']->format('d/m/Y').'</div>
                    </div>
                    <div class="row">
                        <div class="cell">Pais</div>
                        <div class="cell cb text-center" colspan="2">Guatemala</div>
                        <div class="cell" colspan="3"></div>
                    </div>
                    <div class="row">
                        <div class="cell">Gerencia</div>
                        <div class="cell cb text-center" colspan="2">'.$value['gerencia'].'</div>
                        <div class="cell" colspan="3"></div>
                    </div>
                    <div class="row">
                        <div class="cell">Orden de servicio</div>
                        <div class="cell cb text-center" colspan="2">'.$value['orden_de_servicio'].'</div>
                        <div class="cell" colspan="3"></div>
                    </div>
                    <div class="row">
                        <div class="cell">Área operativa</div>
                        <div class="cell cb text-center" colspan="2">'.$value['area_operativa'].'</div>
                        <div class="cell" colspan="3"></div>
                    </div>
                    <div class="row">
                        <div class="cell" colspan="6"></div>
                    </div>
                    <div class="row">
                        <div class="cell" colspan="2">Nombre Técnico</div>
                        <div class="cell cb text-center" colspan="2">'.$value['nombre_de_tecnico'].'</div>
                        <div class="cell" colspan="2"></div>
                    </div>
                    <div class="row">
                        <div class="cell" colspan="2">Nombre de Supervisor Técnico</div>
                        <div class="cell cb text-center" colspan="2">'.$value['nombre_del_supervisor'].'</div>
                        <div class="cell" colspan="2"></div>
                    </div>
                    <div class="row">
                        <div class="cell" colspan="6"></div>
                    </div>
                    <div class="row">
                        <div class="cell-table" colspan="6">
                            <table>
                                <thead>
                                    <tr>
                                        <th class="w-10">Área</th>
                                        <th class="w-10">POND.</th>
                                        <th class="w-50">Descripción</th>
                                        <th class="w-10">POND.</th>
                                        <th class="w-10">Respuesta</th>
                                        <th class="w-10">Puntos</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="w-10 text-center" rowspan="4">MPF</td>
                                        <td class="w-10 text-center" rowspan="4">10</td>
                                        <td class="w-50">Trayectoria y calidad de conexión del puente</td>
                                        <td class="w-10 text-center">2.5</td>
                                        <td class="w-10 text-center">N/A</td>
                                        <td class="w-10 text-center">2.5</td>
                                    </tr>
                                    <tr>
                                        <td class="w-50">Realización de puente en par según sistema</td>
                                        <td class="w-10 text-center">2.5</td>
                                        <td class="w-10 text-center">N/A</td>
                                        <td class="w-10 text-center">2.5</td>
                                    </tr>
                                    <tr>
                                        <td class="w-50">Limpieza del área de trabajo</td>
                                        <td class="w-10 text-center">2.5</td>
                                        <td class="w-10 text-center">N/A</td>
                                        <td class="w-10 text-center">2.5</td>
                                    </tr>
                                    <tr>
                                        <td class="w-50">Materiales normados por CLARO</td>
                                        <td class="w-10 text-center">2.5</td>
                                        <td class="w-10 text-center">N/A</td>
                                        <td class="w-10 text-center">2.5</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <div class="cell" colspan="6"></div>
                    </div>
                    <div class="row">
                        <div class="cell-table" colspan="6">
                            <table>
                                <tbody>
                                    <tr>
                                        <td class="w-10 text-center" rowspan="4">ARMARIO</td>
                                        <td class="w-10 text-center" rowspan="4" class="w-10">5</td>
                                        <td class="w-50">Trayectoria y calidad de conexión del puente</td>
                                        <td class="w-10 text-center">2</td>
                                        <td class="w-10 text-center">N/A</td>
                                        <td class="w-10 text-center">2</td>
                                    </tr>
                                    <tr>
                                        <td class="w-50">Realización de puente en par según sistema</td>
                                        <td class="w-10 text-center">1</td>
                                        <td class="w-10 text-center">N/A</td>
                                        <td class="w-10 text-center">1</td>
                                    </tr>
                                    <tr>
                                        <td class="w-50">Limpieza del área de trabajo</td>
                                        <td class="w-10 text-center">1</td>
                                        <td class="w-10 text-center">N/A</td>
                                        <td class="w-10 text-center">1</td>
                                    </tr>
                                    <tr>
                                        <td class="w-50">Uso de Materiales normados por CLARO</td>
                                        <td class="w-10 text-center">1</td>
                                        <td class="w-10 text-center">N/A</td>
                                        <td class="w-10 text-center">1</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <div class="cell" colspan="6"></div>
                    </div>
                    <div class="row">
                        <div class="cell-table" colspan="6">
                            <table>
                                <tbody>
                                    <tr>
                                        <td class="w-10 text-center" rowspan="6">ACOMETIDA EXTERNA</td>
                                        <td class="w-10 text-center" rowspan="6">30</td>
                                        <td class="w-50">Conexión en caja terminal en norma</td>
                                        <td class="w-10 text-center">5</td>
                                        <td class="w-10 text-center">'.mostrarRespuesta(($value['conexion_en_caja_terminal_en_norma'])).'</td>
                                        <td class="w-10 text-center">'.mostrarPunteo(($value['conexion_en_caja_terminal_en_norma']), 5).'</td>
                                    </tr>
                                    <tr>
                                        <td class="w-50">instalacion de cable "nuevo", normado por Claro</td>
                                        <td class="w-10 text-center">5</td>
                                        <td class="w-10 text-center">'.mostrarRespuesta(($value['instalacion_de_cable_nuevo_normado_por_claro'])).'</td>
                                        <td class="w-10 text-center">'.mostrarPunteo(($value['instalacion_de_cable_nuevo_normado_por_claro']), 5).'</td>
                                    </tr>
                                    <tr>
                                        <td class="w-50">Uso de amarre, argolla o tensor para cable de acometida con catenaria adecuada</td>
                                        <td class="w-10 text-center">5</td>
                                        <td class="w-10 text-center">'.mostrarRespuesta(($value['uso_de_amarre_argolla_o_tensor_para_cable_de_acometida_con_catenaria_adecuada'])).'</td>
                                        <td class="w-10 text-center">'.mostrarPunteo(($value['uso_de_amarre_argolla_o_tensor_para_cable_de_acometida_con_catenaria_adecuada']),5).'</td>
                                    </tr>
                                    <tr>
                                        <td class="w-50">Trayectoria del cable de acometida de acuerdo a la norma</td>
                                        <td class="w-10 text-center">5</td>
                                        <td class="w-10 text-center">'.mostrarRespuesta(($value['trayectoria_del_cable_de_acometida_de_acuerdo_a_la_norma'])).'</td>
                                        <td class="w-10 text-center">'.mostrarPunteo(($value['trayectoria_del_cable_de_acometida_de_acuerdo_a_la_norma']),5).'</td>
                                    </tr>
                                    <tr>
                                        <td class="w-50">Acomentida externa sin empalmes</td>
                                        <td class="w-10 text-center">5</td>
                                        <td class="w-10 text-center">'.mostrarRespuesta(($value['acometida_externa_sin_empalmes'])).'</td>
                                        <td class="w-10 text-center">'.mostrarPunteo(($value['acometida_externa_sin_empalmes']),5).'</td>
                                    </tr>
                                    <tr>
                                        <td class="w-50">Uso de postes / uso de ductos de Claro</td>
                                        <td class="w-10 text-center">5</td>
                                        <td class="w-10 text-center">'.mostrarRespuesta(($value['uso_de_postes_uso_de_ductos_de_claro'])).'</td>
                                        <td class="w-10 text-center">'.mostrarPunteo(($value['uso_de_postes_uso_de_ductos_de_claro']),5).'</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <div class="cell" colspan="6"></div>
                    </div>
                    <div class="row">
                        <div class="cell-table" colspan="6">
                            <table>
                                <tbody>
                                    <tr class="bg-secondary">
                                        <td colspan="4" class="w-80 text-center">CLIENTE PERMITE ACCESO</td>
                                        <td class="text-center">'.mostrarRespuesta($value['cliente_permite_acceso']).'</td>
                                        <td></td>
                                    </tr>
                                </tbody>
                                <thead>
                                    <tr>
                                        <th class="w-10">Área</th>
                                        <th class="w-10">POND.</th>
                                        <th class="w-50">Descripción</th>
                                        <th class="w-10">POND.</th>
                                        <th class="w-10">Respuesta</th>
                                        <th class="w-10">Puntos</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="w-10 text-center" rowspan="7">ACOMETIDA INTERNA</td>
                                        <td class="w-10 text-center" rowspan="7">20</td>
                                        <td class="w-50">Estetica en la instalacion y cable normado por Claro</td>
                                        <td class="w-10 text-center">3</td>
                                        <td class="w-10 text-center">'.mostrarRespuesta($value['estetica_en_la_instalacion_y_cable_normado_por_claro']).'</td>
                                        <td class="w-10 text-center">'.mostrarPunteo(($value['estetica_en_la_instalacion_y_cable_normado_por_claro']),3).'</td>
                                    </tr>
                                    <tr>
                                        <td class="w-50">Uso adecuado de grapas, silicone</td>
                                        <td class="w-10 text-center">2</td>
                                        <td class="w-10 text-center">'.mostrarRespuesta($value['uso_adecuado_de_grapas_silicone']).'</td>
                                        <td class="w-10 text-center">'.mostrarPunteo(($value['uso_adecuado_de_grapas_silicone']),2).'</td>
                                    </tr>
                                    <tr>
                                        <td class="w-50">Realizacion de retorno de linea telefonica ( A solicitud del cliente)</td>
                                        <td class="w-10 text-center">3</td>
                                        <td class="w-10 text-center">'.mostrarRespuesta($value['realizacion_de_retorno_de_linea_telefonica_a_solicitud_del_cliente']).'</td>
                                        <td class="w-10 text-center">'.mostrarPunteo(($value['realizacion_de_retorno_de_linea_telefonica_a_solicitud_del_cliente']),3).'</td>
                                    </tr>
                                    <tr>
                                        <td class="w-50">Fijacion y conexión de dispositivos terminales</td>
                                        <td class="w-10 text-center">3</td>
                                        <td class="w-10 text-center">'.mostrarRespuesta($value['fijacion_y_conexion_de_dispositivos_terminales']).'</td>
                                        <td class="w-10 text-center">'.mostrarPunteo(($value['fijacion_y_conexion_de_dispositivos_terminales']),3).'</td>
                                    </tr>
                                    <tr>
                                        <td class="w-50">Conexión y configuracion de CPE adecuada</td>
                                        <td class="w-10 text-center">3</td>
                                        <td class="w-10 text-center">'.mostrarRespuesta($value['conexion_y_configuracion_de_cpe_adecuada']).'</td>
                                        <td class="w-10 text-center">'.mostrarPunteo(($value['conexion_y_configuracion_de_cpe_adecuada']),3).'</td>
                                    </tr>
                                    <tr>
                                        <td class="w-50">Acometida interna sin empalmes</td>
                                        <td class="w-10 text-center">3</td>
                                        <td class="w-10 text-center">'.mostrarRespuesta($value['acometida_interna_sin_empalmes']).'</td>
                                        <td class="w-10 text-center">'.mostrarPunteo(($value['acometida_interna_sin_empalmes']),3).'</td>
                                    </tr>
                                    <tr>
                                        <td class="w-50">Materiales homologados por CLARO</td>
                                        <td class="w-10 text-center">3</td>
                                        <td class="w-10 text-center">'.mostrarRespuesta($value['materiales_homologados_por_claro']).'</td>
                                        <td class="w-10 text-center">'.mostrarPunteo(($value['materiales_homologados_por_claro']),3).'</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <div class="cell" colspan="6"></div>
                    </div>
                    <div class="row">
                        <div class="cell-table" colspan="6">
                            <table>
                                <tbody>
                                    <tr>
                                        <td class="w-10" rowspan="2">MEDICIÓN</td>
                                        <td class="w-10 text-center" rowspan="2">35</td>
                                        <td class="w-50">Utilizo medidor (Decibelimetro) subiendo las mediciones al servidor</td>
                                        <td class="w-10 text-center">20</td>
                                        <td class="w-10 text-center">'.mostrarRespuesta($value['utilizo_medidor_decibelimetro_subiendo_las_mediciones_al_servidor']).'</td>
                                        <td class="w-10 text-center">'.mostrarPunteo(($value['utilizo_medidor_decibelimetro_subiendo_las_mediciones_al_servidor']),20).'</td>
                                    </tr>
                                    <tr>
                                        <td>Las mediciones son correctas </td>
                                        <td class="w-10 text-center">15</td>
                                        <td class="w-10 text-center">'.mostrarRespuesta($value['las_mediciones_son_correctas']).'</td>
                                        <td class="w-10 text-center">'.mostrarPunteo(($value['las_mediciones_son_correctas']),15).'</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <div class="cell" colspan="6"><br></div>
                    </div>
                ';

                $total = 10 + 5
                + mostrarPunteo(($value['conexion_en_caja_terminal_en_norma']), 5)
                + mostrarPunteo(($value['instalacion_de_cable_nuevo_normado_por_claro']), 5)
                + mostrarPunteo(($value['uso_de_amarre_argolla_o_tensor_para_cable_de_acometida_con_catenaria_adecuada']),5)
                + mostrarPunteo(($value['trayectoria_del_cable_de_acometida_de_acuerdo_a_la_norma']),5)
                + mostrarPunteo(($value['acometida_externa_sin_empalmes']),5)
                + mostrarPunteo(($value['uso_de_postes_uso_de_ductos_de_claro']),5)
                + mostrarPunteo(($value['estetica_en_la_instalacion_y_cable_normado_por_claro']),3)
                + mostrarPunteo(($value['uso_adecuado_de_grapas_silicone']),2)
                + mostrarPunteo(($value['realizacion_de_retorno_de_linea_telefonica_a_solicitud_del_cliente']),3)
                + mostrarPunteo(($value['fijacion_y_conexion_de_dispositivos_terminales']),3)
                + mostrarPunteo(($value['conexion_y_configuracion_de_cpe_adecuada']),3)
                + mostrarPunteo(($value['acometida_interna_sin_empalmes']),3)
                + mostrarPunteo(($value['materiales_homologados_por_claro']),3)
                + mostrarPunteo(($value['utilizo_medidor_decibelimetro_subiendo_las_mediciones_al_servidor']),20)
                + mostrarPunteo(($value['las_mediciones_son_correctas']),15);

                $html .= '
                    <div class="row">
                        <div class="cell">Observaciónes: </div>
                        <div class="cell cb" colspan="4">'.$value['observaciones'].'</div>
                        <div class="cell cb text-center">'.$total.'</div>
                    </div>
                </div>
                ';

                if($value['evidencia_fotografica'] != ''){

                    $value['evidencia_fotografica'] = str_replace('open','uc',$value['evidencia_fotografica']);
                    $html .= '
                        <div style="page-break-after:always;"></div>
                        <div class="container">
                            <div class="row">
                                <div class="cell">
                                    <img src="../src/assets/img/logo.png" style="width:80px;">
                                </div>
                            </div>
                            <div class="row">
                                <div class="cell text-center">
                                    <img src="'.$value['evidencia_fotografica'].'" class="evidencia">
                                </div>
                            </div>
                        </div>
                    ';
                }

                if($value['segundo_archivo'] != ''){

                    $value['segundo_archivo'] = str_replace('open','uc',$value['segundo_archivo']);
                    $html .= '
                        <div style="page-break-after:always;"></div>
                        <div class="container">
                            <div class="row">
                                <div class="cell">
                                    <img src="../src/assets/img/logo.png" style="width:80px;">
                                </div>
                            </div>
                            <div class="row">
                                <div class="cell text-center">
                                    <img src="'.$value['segundo_archivo'].'" class="evidencia">
                                </div>
                            </div>
                        </div>
                    ';
                }

                if($value['tercer_archivo'] != ''){

                    $value['tercer_archivo'] = str_replace('open','uc',$value['tercer_archivo']);
                    $html .= '
                        <div style="page-break-after:always;"></div>
                        <div class="container">
                            <div class="row">
                                <div class="cell">
                                    <img src="../src/assets/img/logo.png" style="width:80px;">
                                </div>
                            </div>
                            <div class="row">
                                <div class="cell text-center">
                                    <img src="'.$value['tercer_archivo'].'" class="evidencia">
                                </div>
                            </div>
                        </div>
                    ';
                }

                if (($value['camisa'] != '' && $value['camisa'] != 'N/A') 
                    || ($value['pantalon'] != '' && $value['pantalon'] != 'N/A')
                    || ($value['botas'] != '' && $value['botas'] != 'N/A')
                    || ($value['gafete'] != '' && $value['gafete'] != 'N/A')
                    || ($value['faja'] != '' && $value['faja'] != 'N/A')
                    || ($value['cinturon_de_seguridad_con_amarre_a_poste'] != '' && $value['cinturon_de_seguridad_con_amarre_a_poste'] != 'N/A')
                    || ($value['chaleco_preventivo'] != '' && $value['chaleco_preventivo'] != 'N/A')
                    || ($value['casco_de_proteccion'] != '' && $value['casco_de_proteccion'] != 'N/A')
                    || ($value['guantes_de_cuero'] != '' && $value['guantes_de_cuero'] != 'N/A')
                    || ($value['capa_impermeable'] != '' && $value['capa_impermeable'] != 'N/A')
                    || ($value['aspecto_personal'] != '' && $value['aspecto_personal'] != 'N/A')
                    || ($value['logotipo_de_empresa'] != '' && $value['logotipo_de_empresa'] != 'N/A')
                    || ($value['carroceria'] != '' && $value['carroceria'] != 'N/A')
                    || ($value['porta_escalera'] != '' && $value['porta_escalera'] != 'N/A')
                    || ($value['estado_de_neumaticos'] != '' && $value['estado_de_neumaticos'] != 'N/A')
                    || ($value['rotulado_de_unidad'] != '' && $value['rotulado_de_unidad'] != 'N/A')
                    || ($value['orden_y_limpieza'] != '' && $value['orden_y_limpieza'] != 'N/A')
                    || ($value['tecnico_certificado_por_claro'] != 'N/A' && $value['tecnico_certificado_por_claro'] != '')
                ){

                    $html .= '
                        <div style="page-break-after:always;"></div>
                        <div class="container">
                            <div class="row">
                                <div class="cell">
                                    <img src="../src/assets/img/logo.png" style="width:80px;">
                                </div>
                                <div class="cell text-center" colspan="4"><h4>** Evaluación de Vehículos y Uniformes (Cobre, ADSL, HFC)</h4></div>
                                <div class="cell" style="width:80px;"></div>
                            </div>
                            <div class="row">
                                <div class="cell">Mes evaluado</div>
                                <div class="cell cb text-center" colspan="2">'.$value['mes_evaluado'].'</div>
                                <div class="cell text-end">Fecha</div>
                                <div class="cell cb text-center" colspan="2">'.$value['fecha']->format('d/m/Y').'</div>
                            </div>
                            <div class="row">
                                <div class="cell">Pais</div>
                                <div class="cell cb text-center" colspan="2">Guatemala</div>
                                <div class="cell" colspan="3"></div>
                            </div>
                            <div class="row">
                                <div class="cell">Gerencia</div>
                                <div class="cell cb text-center" colspan="2">'.$value['gerencia'].'</div>
                                <div class="cell" colspan="3"></div>
                            </div>
                            <div class="row">
                                <div class="cell">Orden de servicio</div>
                                <div class="cell cb text-center" colspan="2">'.$value['orden_de_servicio'].'</div>
                                <div class="cell" colspan="3"></div>
                            </div>
                            <div class="row">
                                <div class="cell">Área operativa</div>
                                <div class="cell cb text-center" colspan="2">'.$value['area_operativa'].'</div>
                                <div class="cell" colspan="3"></div>
                            </div>
                            <div class="row">
                                <div class="cell">Contratista</div>
                                <div class="cell cb text-center" colspan="2"></div>
                                <div class="cell" colspan="3"></div>
                            </div>
                            <div class="row">
                                <div class="cell">Tecnología</div>
                                <div class="cell cb text-center" colspan="2">ADSL</div>
                                <div class="cell" colspan="3"></div>
                            </div>
                            <div class="row">
                                <div class="cell" colspan="6"></div>
                            </div>
                            <div class="row">
                                <div class="cell">Nombre Técnico</div>
                                <div class="cell cb text-center" colspan="2">'.$value['nombre_de_tecnico'].'</div>
                                <div class="cell" colspan="3"></div>
                            </div>
                            <div class="row">
                                <div class="cell">Nombre de Supervisor Técnico</div>
                                <div class="cell cb text-center" colspan="2">'.$value['nombre_del_supervisor'].'</div>
                                <div class="cell" colspan="3"></div>
                            </div>
                            <div class="row">
                                <div class="cell" colspan="6"></div>
                            </div>
                    ';

                    if(
                        ($value['camisa'] != '' && $value['camisa'] != 'N/A') 
                        || ($value['pantalon'] != '' && $value['pantalon'] != 'N/A')
                        || ($value['botas'] != '' && $value['botas'] != 'N/A')
                        || ($value['gafete'] != '' && $value['gafete'] != 'N/A')
                        || ($value['faja'] != '' && $value['faja'] != 'N/A')
                        || ($value['cinturon_de_seguridad_con_amarre_a_poste'] != '' && $value['cinturon_de_seguridad_con_amarre_a_poste'] != 'N/A')
                        || ($value['chaleco_preventivo'] != '' && $value['chaleco_preventivo'] != 'N/A')
                        || ($value['casco_de_proteccion'] != '' && $value['casco_de_proteccion'] != 'N/A')
                        || ($value['guantes_de_cuero'] != '' && $value['guantes_de_cuero'] != 'N/A')
                        || ($value['capa_impermeable'] != '' && $value['capa_impermeable'] != 'N/A')
                        || ($value['aspecto_personal'] != '' && $value['aspecto_personal'] != 'N/A')
                    ){

                        $html .= '
                            <div class="row">
                                <div class="cell-table" colspan="6">
                                    <table>
                                        <thead>
                                            <tr>
                                                <th class="w-30">Uniforme</th>
                                                <th class="w-30">POND.</th>
                                                <th class="w-20">Resultado</th>
                                                <th class="w-20">Puntos</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="w-40">Camisa</td>
                                                <td class="w-20 text-center">10</td>
                                                <td class="w-20 text-center">'.mostrarRespuesta($value['camisa']).'</td>
                                                <td class="w-20 text-center">'.mostrarPunteo(($value['camisa']),10).'</td>
                                            </tr>
                                            <tr>
                                                <td class="w-40">Pantalón</td>
                                                <td class="w-20 text-center">10</td>
                                                <td class="w-20 text-center">'.mostrarRespuesta($value['pantalon']).'</td>
                                                <td class="w-20 text-center">'.mostrarPunteo(($value['pantalon']),10).'</td>
                                            </tr>
                                            <tr>
                                                <td class="w-40">Botas</td>
                                                <td class="w-20 text-center">15</td>
                                                <td class="w-20 text-center">'.mostrarRespuesta($value['botas']).'</td>
                                                <td class="w-20 text-center">'.mostrarPunteo(($value['botas']),15).'</td>
                                            </tr>
                                            <tr>
                                                <td class="w-40">Gafete</td>
                                                <td class="w-20 text-center">15</td>
                                                <td class="w-20 text-center">'.mostrarRespuesta($value['gafete']).'</td>
                                                <td class="w-20 text-center">'.mostrarPunteo(($value['gafete']),15).'</td>
                                            </tr>
                                            <tr>
                                                <td class="w-40">Faja</td>
                                                <td class="w-20 text-center">5</td>
                                                <td class="w-20 text-center">'.mostrarRespuesta($value['faja']).'</td>
                                                <td class="w-20 text-center">'.mostrarPunteo(($value['faja']),5).'</td>
                                            </tr>

                                            <tr>
                                            <td class="w-40">Cinturón de seguridad con amarre a poste</td>
                                                <td class="w-20 text-center">10</td>
                                                <td class="w-20 text-center">'.mostrarRespuesta($value['cinturon_de_seguridad_con_amarre_a_poste']).'</td>
                                                <td class="w-20 text-center">'.mostrarPunteo(($value['cinturon_de_seguridad_con_amarre_a_poste']),10).'</td>
                                            </tr>
                                            <tr>
                                                <td class="w-40">Chaleco preventivo</td>
                                                <td class="w-20 text-center">5</td>
                                                <td class="w-20 text-center">'.mostrarRespuesta($value['chaleco_preventivo']).'</td>
                                                <td class="w-20 text-center">'.mostrarPunteo(($value['chaleco_preventivo']),5).'</td>
                                            </tr>
                                            <tr>
                                                <td class="w-40">Casco de protección</td>
                                                <td class="w-20 text-center">10</td>
                                                <td class="w-20 text-center">'.mostrarRespuesta($value['casco_de_proteccion']).'</td>
                                                <td class="w-20 text-center">'.mostrarPunteo(($value['casco_de_proteccion']),10).'</td>
                                            </tr>
                                            <tr>
                                                <td class="w-40">Guantes de cuero</td>
                                                <td class="w-20 text-center">5</td>
                                                <td class="w-20 text-center">'.mostrarRespuesta($value['guantes_de_cuero']).'</td>
                                                <td class="w-20 text-center">'.mostrarPunteo(($value['guantes_de_cuero']),5).'</td>
                                            </tr>
                                            <tr>
                                                <td class="w-40">Capa impermeable</td>
                                                <td class="w-20 text-center">5</td>
                                                <td class="w-20 text-center">'.mostrarRespuesta($value['capa_impermeable']).'</td>
                                                <td class="w-20 text-center">'.mostrarPunteo(($value['capa_impermeable']),5).'</td>
                                            </tr>
                                            <tr>
                                                <td class="w-40">Aspecto personal</td>
                                                <td class="w-20 text-center">10</td>
                                                <td class="w-20 text-center">'.mostrarRespuesta($value['aspecto_personal']).'</td>
                                                <td class="w-20 text-center">'.mostrarPunteo(($value['aspecto_personal']),10).'</td>
                                            </tr>
                        ';
                        
                        $total = 0 
                        + mostrarPunteo(($value['camisa']),10)
                        + mostrarPunteo(($value['pantalon']),10)
                        + mostrarPunteo(($value['botas']),15)
                        + mostrarPunteo(($value['gafete']),15)
                        + mostrarPunteo(($value['faja']),5)
                        + mostrarPunteo(($value['cinturon_de_seguridad_con_amarre_a_poste']),10)
                        + mostrarPunteo(($value['chaleco_preventivo']),5)
                        + mostrarPunteo(($value['casco_de_proteccion']),10)
                        + mostrarPunteo(($value['guantes_de_cuero']),5)
                        + mostrarPunteo(($value['capa_impermeable']),5)
                        + mostrarPunteo(($value['aspecto_personal']),10);
                                                
                        $html .= '
                                            <tr>
                                                <td class="w-40 fw">TOTAL</td>
                                                <td class="w-20 text-center fw">100</td>
                                                <td class="w-20"></td>
                                                <td class="w-20 text-center fw">'.$total.'</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="row">
                                <div class="cell" colspan="6"><br></div>
                            </div>
                            <div class="row">
                                <div class="cell cb" colspan="2">Observaciónes: </div>
                                <div class="cell cb" colspan="4">'.$value['observaciones'].'</div>
                            </div>
                        ';

                    };

                    $html .= '</div>';

                    if(
                        ($value['logotipo_de_empresa'] != '' && $value['logotipo_de_empresa'] != 'N/A')
                        || ($value['carroceria'] != '' && $value['carroceria'] != 'N/A')
                        || ($value['porta_escalera'] != '' && $value['porta_escalera'] != 'N/A')
                        || ($value['estado_de_neumaticos'] != '' && $value['estado_de_neumaticos'] != 'N/A')
                        || ($value['rotulado_de_unidad'] != '' && $value['rotulado_de_unidad'] != 'N/A')
                        || ($value['orden_y_limpieza'] != '' && $value['orden_y_limpieza'] != 'N/A')
                    ){

                        $html .= '
                            <div class="container">
                                <div class="row">
                                    <div class="cell" colspan="4"><br><hr><br></div>
                                </div>
                                <div class="row">
                                    <div class="cell w-40 text-end fw">APLICA</div>
                                    <div class="cell w-20 cb text-center">SI</div>
                                    <div class="cell w-20"></div>
                                    <div class="cell w-20"></div>
                                </div>
                                <div class="row">
                                    <div class="cell" colspan="4"><br></div>
                                </div>
                                <div class="row">
                                    <div class="cell-table" colspan="6">
                                        <table>
                                            <thead>
                                                <tr>
                                                    <th class="w-40">Vehículo</th>
                                                    <th class="w-20">POND.</th>
                                                    <th class="w-20">Resultado</th>
                                                    <th class="w-20">Puntos</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td class="w-40">Logotipo de empresa</td>
                                                    <td class="w-20 text-center">20</td>
                                                    <td class="w-20 text-center">'.mostrarRespuesta($value['logotipo_de_empresa']).'</td>
                                                    <td class="w-20 text-center">'.mostrarPunteo(($value['logotipo_de_empresa']),20).'</td>
                                                </tr>
                                                <tr>
                                                    <td class="w-40">Carrocería</td>
                                                    <td class="w-20 text-center">20</td>
                                                    <td class="w-20 text-center">'.mostrarRespuesta($value['carroceria']).'</td>
                                                    <td class="w-20 text-center">'.mostrarPunteo(($value['carroceria']),20).'</td>
                                                </tr>
                                                <tr>
                                                    <td class="w-40">Porta escalera</td>
                                                    <td class="w-20 text-center">20</td>
                                                    <td class="w-20 text-center">'.mostrarRespuesta($value['porta_escalera']).'</td>
                                                    <td class="w-20 text-center">'.mostrarPunteo(($value['porta_escalera']),20).'</td>
                                                </tr>
                                                <tr>
                                                    <td class="w-40">Estado de neumaticos</td>
                                                    <td class="w-20 text-center">20</td>
                                                    <td class="w-20 text-center">'.mostrarRespuesta($value['estado_de_neumaticos']).'</td>
                                                    <td class="w-20 text-center">'.mostrarPunteo(($value['estado_de_neumaticos']),20).'</td>
                                                </tr>
                                                <tr>
                                                    <td class="w-40">Rotulado de unidad</td>
                                                    <td class="w-20 text-center">5</td>
                                                    <td class="w-20 text-center">'.mostrarRespuesta($value['rotulado_de_unidad']).'</td>
                                                    <td class="w-20 text-center">'.mostrarPunteo(($value['rotulado_de_unidad']),5).'</td>
                                                </tr>
                                                <tr>
                                                    <td class="w-40">Orden y limpieza</td>
                                                    <td class="w-20 text-center">15</td>
                                                    <td class="w-20 text-center">'.mostrarRespuesta($value['orden_y_limpieza']).'</td>
                                                    <td class="w-20 text-center">'.mostrarPunteo(($value['orden_y_limpieza']),15).'</td>
                                                </tr>
                        ';

                        $total = 0 
                        + mostrarPunteo(($value['logotipo_de_empresa']),20)
                        + mostrarPunteo(($value['carroceria']),20)
                        + mostrarPunteo(($value['porta_escalera']),20)
                        + mostrarPunteo(($value['estado_de_neumaticos']),20)
                        + mostrarPunteo(($value['rotulado_de_unidad']),5)
                        + mostrarPunteo(($value['orden_y_limpieza']),15);

                        $html .= '
                                                <tr>
                                                    <td class="w-40 fw">TOTAL</td>
                                                    <td class="w-20 text-center fw">100</td>
                                                    <td class="w-20"></td>
                                                    <td class="w-20 text-center" fw>'.$total.'</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="cell" colspan="6"><br></div>
                                </div>
                                <div class="row">
                                    <div class="cell cb">Observaciónes: </div>
                                    <div class="cell cb" colspan="5">'.$value['observaciones'].'</div>
                                </div>
                            </div>
                        ';

                    }

                    if(false){

                        $html .= '
                                <div class="container">
                                    <div class="row">
                                        <div class="cell w-40 text-end fw">APLICA</div>
                                        <div class="cell w-20 cb text-center">SI</div>
                                        <div class="cell w-20"></div>
                                        <div class="cell w-20"></div>
                                    </div>
                                    <div class="row">
                                        <div class="cell" colspan="4"><br></div>
                                    </div>
                                    <div class="row">
                                        <div class="cell-table" colspan="6">
                                            <table>
                                                <thead>
                                                    <tr>
                                                        <th class="w-40">Moto</th>
                                                        <th class="w-20">POND.</th>
                                                        <th class="w-20">Resultado</th>
                                                        <th class="w-20">Puntos</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td class="w-40">Logotipo</td>
                                                        <td class="w-20 text-center">15</td>
                                                        <td class="w-20 text-center"></td>
                                                        <td class="w-20 text-center"></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="w-40">Estado de Carrocería</td>
                                                        <td class="w-20 text-center">15</td>
                                                        <td class="w-20 text-center"></td>
                                                        <td class="w-20 text-center"></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="w-40">Focos</td>
                                                        <td class="w-20 text-center">10</td>
                                                        <td class="w-20 text-center"></td>
                                                        <td class="w-20 text-center"></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="w-40">Parrilla</td>
                                                        <td class="w-20 text-center">10</td>
                                                        <td class="w-20 text-center"></td>
                                                        <td class="w-20 text-center"></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="w-40">Casco</td>
                                                        <td class="w-20 text-center">10</td>
                                                        <td class="w-20 text-center"></td>
                                                        <td class="w-20 text-center"></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="w-40">Pide Vía</td>
                                                        <td class="w-20 text-center">10</td>
                                                        <td class="w-20 text-center"></td>
                                                        <td class="w-20 text-center"></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="w-40">Luces Laterales</td>
                                                        <td class="w-20 text-center">10</td>
                                                        <td class="w-20 text-center"></td>
                                                        <td class="w-20 text-center"></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="w-40">Estado de las Llantas</td>
                                                        <td class="w-20 text-center">10</td>
                                                        <td class="w-20 text-center"></td>
                                                        <td class="w-20 text-center"></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="w-40">Stop Traseros</td>
                                                        <td class="w-20 text-center">10</td>
                                                        <td class="w-20 text-center"></td>
                                                        <td class="w-20 text-center"></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="w-40">Marca y Modelo</td>
                                                        <td class="w-20 text-center" colspan="3"></td>
                                                    </tr>
                            ';

                            $total = 0;

                            $html .= '
                                                    <tr>
                                                        <td class="w-40 fw">TOTAL</td>
                                                        <td class="w-20 text-center fw">100</td>
                                                        <td class="w-20"></td>
                                                        <td class="w-20 text-center" fw>'.$total.'</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="cell" colspan="6"><br></div>
                                    </div>
                                    <div class="row">
                                        <div class="cell cb">Observaciónes: </div>
                                        <div class="cell cb" colspan="5">'.$value['observaciones'].'</div>
                                    </div>
                                    <div class="row">
                                        <div class="cell" colspan="6"><br><hr><br></div>
                                    </div>
                                </div>
                            ';

                    }

                    if( $value['tecnico_certificado_por_claro'] != 'N/A' && $value['tecnico_certificado_por_claro'] != '' ){

                        $html .= '
                            <div class="container">
                                <div class="row">
                                    <div class="cell-table" colspan="6">
                                        <table>
                                            <thead>
                                                <tr>
                                                    <th class="w-40">CERTIFICACIÓN</th>
                                                    <th class="w-30">POND.</th>
                                                    <th class="w-30">Resultado</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td class="w-40">Técnico Certificado Por Claro</td>
                                                    <td class="w-30 text-center">'.mostrarRespuesta($value['tecnico_certificado_por_claro']).'</td>
                                                    <td class="w-30 text-center">'.mostrarPunteo(($value['tecnico_certificado_por_claro']),100).'</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="cell" colspan="6"><br></div>
                                </div>
                                <div class="row">
                                    <div class="cell cb">Observaciónes: </div>
                                    <div class="cell cb" colspan="5">'.$value['observaciones'].'</div>
                                </div>
                            </div>
                        ';

                    }

                    

                    if($value['evidencia_fotografica'] != ''){

                        $html .= '
                            <div style="page-break-after:always;"></div>
                            <div class="container">
                                <div class="row">
                                    <div class="cell">
                                        <img src="../src/assets/img/logo.png" style="width:80px;">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="cell text-center">
                                        <img src="'.$value['evidencia_fotografica'].'" class="evidencia">
                                    </div>
                                </div>
                            </div>
                        ';
                    }

                    if($value['segundo_archivo'] != ''){

                        $html .= '
                            <div style="page-break-after:always;"></div>
                            <div class="container">
                                <div class="row">
                                    <div class="cell">
                                        <img src="../src/assets/img/logo.png" style="width:80px;">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="cell text-center">
                                        <img src="'.$value['segundo_archivo'].'" class="evidencia">
                                    </div>
                                </div>
                            </div>
                        ';
                    }

                    if($value['tercer_archivo'] != ''){

                        $html .= '
                            <div style="page-break-after:always;"></div>
                            <div class="container">
                                <div class="row">
                                    <div class="cell">
                                        <img src="../src/assets/img/logo.png" style="width:80px;">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="cell text-center">
                                        <img src="'.$value['tercer_archivo'].'" class="evidencia">
                                    </div>
                                </div>
                            </div>
                        ';
                    }


                }

                if(
                    ($value['herramienta_para_regletas'] != '' && $value['herramienta_para_regletas'] != 'N/A')
                    || ($value['herramienta_entorchadora_reversible_2_x_24'] != '' && $value['herramienta_entorchadora_reversible_2_x_24'] != 'N/A')
                    || ($value['micro_telefono'] != '' && $value['micro_telefono'] != 'N/A')
                    || ($value['llave_para_armario'] != '' && $value['llave_para_armario'] != 'N/A')
                    || ($value['equipo_medicion_homologado_de_pares_cobre_y_adsl_veex'] != '' && $value['equipo_medicion_homologado_de_pares_cobre_y_adsl_veex'] != 'N/A')
                    || ($value['escalera'] != '' && $value['escalera'] != 'N/A')
                    || ($value['alicate'] != '' && $value['alicate'] != 'N/A')
                    || ($value['pinza'] != '' && $value['pinza'] != 'N/A')
                    || ($value['corta_alambre'] != '' && $value['corta_alambre'] != 'N/A')
                    || ($value['destornilladores'] != '' && $value['destornilladores'] != 'N/A')
                    || ($value['navaja_curva'] != '' && $value['navaja_curva'] != 'N/A')
                    || ($value['generador_de_tono_con_punta_inductiva'] != '' && $value['generador_de_tono_con_punta_inductiva'] != 'N/A')
                    || ($value['taladro_tipo_industrial_de_1_2'] != '' && $value['taladro_tipo_industrial_de_1_2'] != 'N/A')
                    || ($value['broca_pasa_muros_12_pulgadas_1_2_o_3_8'] != '' && $value['broca_pasa_muros_12_pulgadas_1_2_o_3_8'] != 'N/A')
                    || ($value['guia_acerada_de_30_metros'] != '' && $value['guia_acerada_de_30_metros'] != 'N/A')
                    || ($value['cadena_con_candados_asegurar_escalera_a_vehiculo'] != '' && $value['cadena_con_candados_asegurar_escalera_a_vehiculo'] != 'N/A')
                ){

                    $html .= '
                            <div style="page-break-after:always;"></div>
                            <div class="container">
                                <div class="row">
                                    <div class="cell">
                                        <img src="../src/assets/img/logo.png" style="width:80px;">
                                    </div>
                                    <div class="cell text-center" colspan="4"><h4>** Evaluación de Auditoria ADSL Reparaciones e Instalaciones</h4></div>
                                    <div class="cell" style="width:80px;"></div>
                                </div>
                                <div class="row">
                                    <div class="cell">Mes evaluado</div>
                                    <div class="cell cb text-center" colspan="2">'.$value['mes_evaluado'].'</div>
                                    <div class="cell text-end">Fecha de Evaluación</div>
                                    <div class="cell cb text-center" colspan="2">'.$value['fecha']->format('d/m/Y').'</div>
                                </div>
                                <div class="row">
                                    <div class="cell">Pais</div>
                                    <div class="cell cb text-center" colspan="2">Guatemala</div>
                                    <div class="cell" colspan="3"></div>
                                </div>
                                <div class="row">
                                    <div class="cell">Gerencia</div>
                                    <div class="cell cb text-center" colspan="2">'.$value['gerencia'].'</div>
                                    <div class="cell" colspan="3"></div>
                                </div>
                                <div class="row">
                                    <div class="cell">Orden de servicio</div>
                                    <div class="cell cb text-center" colspan="2">'.$value['orden_de_servicio'].'</div>
                                    <div class="cell" colspan="3"></div>
                                </div>
                                <div class="row">
                                    <div class="cell">Área operativa</div>
                                    <div class="cell cb text-center" colspan="2">'.$value['area_operativa'].'</div>
                                    <div class="cell" colspan="3"></div>
                                </div>
                                <div class="row">
                                    <div class="cell">Contratista</div>
                                    <div class="cell cb text-center" colspan="2"></div>
                                    <div class="cell" colspan="3"></div>
                                </div>
                                <div class="row">
                                    <div class="cell">Tecnología</div>
                                    <div class="cell cb text-center" colspan="2">ADSL</div>
                                    <div class="cell" colspan="3"></div>
                                </div>
                                <div class="row">
                                    <div class="cell" colspan="6"></div>
                                </div>
                                <div class="row">
                                    <div class="cell">Nombre Técnico</div>
                                    <div class="cell cb text-center" colspan="2">'.$value['nombre_de_tecnico'].'</div>
                                    <div class="cell" colspan="3"></div>
                                </div>
                                <div class="row">
                                    <div class="cell">Nombre de Supervisor Técnico</div>
                                    <div class="cell cb text-center" colspan="2">'.$value['nombre_del_supervisor'].'</div>
                                    <div class="cell" colspan="3"></div>
                                </div>
                                <div class="row">
                                    <div class="cell" colspan="6"></div>
                                </div>
                                <div class="row">
                                    <div class="cell-table" colspan="6">
                                        <table>
                                            <tbody>
                                                <tr class="bg-secondary">
                                                    <td colspan="4" class="w-80 text-center">ADSL</td>
                                                </tr>
                                            </tbody>
                                            <thead>
                                                <tr>
                                                    <th class="w-30">Descripción</th>
                                                    <th class="w-30">POND.</th>
                                                    <th class="w-20">RESPUESTA</th>
                                                    <th class="w-20">Puntos</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td class="w-40">Herramienta Para regletas</td>
                                                    <td class="w-20 text-center">10</td>
                                                    <td class="w-20 text-center">'.mostrarRespuesta($value['herramienta_para_regletas']).'</td>
                                                    <td class="w-20 text-center">'.mostrarPunteo(($value['herramienta_para_regletas']),10).'</td>
                                                </tr>
                                                <tr>
                                                    <td class="w-40">Herramienta entorchadora reversible 2X24</td>
                                                    <td class="w-20 text-center">5</td>
                                                    <td class="w-20 text-center">'.mostrarRespuesta($value['herramienta_entorchadora_reversible_2_x_24']).'</td>
                                                    <td class="w-20 text-center">'.mostrarPunteo(($value['herramienta_entorchadora_reversible_2_x_24']),5).'</td>
                                                </tr>
                                                <tr>
                                                    <td class="w-40">Microteléfono</td>
                                                    <td class="w-20 text-center">15</td>
                                                    <td class="w-20 text-center">'.mostrarRespuesta($value['micro_telefono']).'</td>
                                                    <td class="w-20 text-center">'.mostrarPunteo(($value['micro_telefono']),15).'</td>
                                                </tr>
                                                <tr>
                                                    <td class="w-40">Llave para armario</td>
                                                    <td class="w-20 text-center">5</td>
                                                    <td class="w-20 text-center">'.mostrarRespuesta($value['llave_para_armario']).'</td>
                                                    <td class="w-20 text-center">'.mostrarPunteo(($value['llave_para_armario']),5).'</td>
                                                </tr>
                                                <tr>
                                                    <td class="w-40">Equipo medición Homologado de pares cobre y ADSL (VEEX)</td>
                                                    <td class="w-20 text-center">20</td>
                                                    <td class="w-20 text-center">'.mostrarRespuesta($value['equipo_medicion_homologado_de_pares_cobre_y_adsl_veex']).'</td>
                                                    <td class="w-20 text-center">'.mostrarPunteo(($value['equipo_medicion_homologado_de_pares_cobre_y_adsl_veex']),20).'</td>
                                                </tr>
                                                <tr>
                                                    <td class="w-40">Escalera</td>
                                                    <td class="w-20 text-center">5</td>
                                                    <td class="w-20 text-center">'.mostrarRespuesta($value['escalera']).'</td>
                                                    <td class="w-20 text-center">'.mostrarPunteo(($value['escalera']),10).'</td>
                                                </tr>
                                                <tr>
                                                    <td class="w-40">Alicate</td>
                                                    <td class="w-20 text-center">5</td>
                                                    <td class="w-20 text-center">'.mostrarRespuesta($value['alicate']).'</td>
                                                    <td class="w-20 text-center">'.mostrarPunteo(($value['alicate']),2).'</td>
                                                </tr>
                                                <tr>
                                                    <td class="w-40">Pinza</td>
                                                    <td class="w-20 text-center">5</td>
                                                    <td class="w-20 text-center">'.mostrarRespuesta($value['pinza']).'</td>
                                                    <td class="w-20 text-center">'.mostrarPunteo(($value['pinza']),2).'</td>
                                                </tr>
                                                <tr>
                                                    <td class="w-40">Corta Alambre</td>
                                                    <td class="w-20 text-center">5</td>
                                                    <td class="w-20 text-center">'.mostrarRespuesta($value['corta_alambre']).'</td>
                                                    <td class="w-20 text-center">'.mostrarPunteo(($value['corta_alambre']),2).'</td>
                                                </tr>
                                                <tr>
                                                    <td class="w-40">Destornilladores</td>
                                                    <td class="w-20 text-center">5</td>
                                                    <td class="w-20 text-center">'.mostrarRespuesta($value['destornilladores']).'</td>
                                                    <td class="w-20 text-center">'.mostrarPunteo(($value['destornilladores']),2).'</td>
                                                </tr>
                                                <tr>
                                                    <td class="w-40">Navaja Curva</td>
                                                    <td class="w-20 text-center">5</td>
                                                    <td class="w-20 text-center">'.mostrarRespuesta($value['navaja_curva']).'</td>
                                                    <td class="w-20 text-center">'.mostrarPunteo(($value['navaja_curva']),2).'</td>
                                                </tr>
                                                <tr>
                                                    <td class="w-40">Generador de tono con punta inductiva</td>
                                                    <td class="w-20 text-center">5</td>
                                                    <td class="w-20 text-center">'.mostrarRespuesta($value['generador_de_tono_con_punta_inductiva']).'</td>
                                                    <td class="w-20 text-center">'.mostrarPunteo(($value['generador_de_tono_con_punta_inductiva']),5).'</td>
                                                </tr>
                                                <tr>
                                                    <td class="w-40">Taladro tipo industrial de 1/2"</td>
                                                    <td class="w-20 text-center">5</td>
                                                    <td class="w-20 text-center">'.mostrarRespuesta($value['taladro_tipo_industrial_de_1_2']).'</td>
                                                    <td class="w-20 text-center">'.mostrarPunteo(($value['taladro_tipo_industrial_de_1_2']),5).'</td>
                                                </tr>
                                                <tr>
                                                    <td class="w-40">Broca pasa muros 12 pulgadas * 1/2 o 3/8</td>
                                                    <td class="w-20 text-center">5</td>
                                                    <td class="w-20 text-center">'.mostrarRespuesta($value['broca_pasa_muros_12_pulgadas_1_2_o_3_8']).'</td>
                                                    <td class="w-20 text-center">'.mostrarPunteo(($value['broca_pasa_muros_12_pulgadas_1_2_o_3_8']),5).'</td>
                                                </tr>
                                                <tr>
                                                    <td class="w-40">Guía acerada de 30 metros</td>
                                                    <td class="w-20 text-center">5</td>
                                                    <td class="w-20 text-center">'.mostrarRespuesta($value['guia_acerada_de_30_metros']).'</td>
                                                    <td class="w-20 text-center">'.mostrarPunteo(($value['guia_acerada_de_30_metros']),5).'</td>
                                                </tr>
                                                <tr>
                                                    <td class="w-40">Cadena con candados (asegurar escalera a vehículo)</td>
                                                    <td class="w-20 text-center">5</td>
                                                    <td class="w-20 text-center">'.mostrarRespuesta($value['cadena_con_candados_asegurar_escalera_a_vehiculo']).'</td>
                                                    <td class="w-20 text-center">'.mostrarPunteo(($value['cadena_con_candados_asegurar_escalera_a_vehiculo']),5).'</td>
                                                </tr>
                        ';
                        
                        $total = 0 
                        + mostrarPunteo(($value['herramienta_para_regletas']),10)
                        + mostrarPunteo(($value['herramienta_entorchadora_reversible_2_x_24']),5)
                        + mostrarPunteo(($value['micro_telefono']),15)
                        + mostrarPunteo(($value['llave_para_armario']),5)
                        + mostrarPunteo(($value['equipo_medicion_homologado_de_pares_cobre_y_adsl_veex']),20)
                        + mostrarPunteo(($value['escalera']),10)
                        + mostrarPunteo(($value['alicate']),2)
                        + mostrarPunteo(($value['pinza']),2)
                        + mostrarPunteo(($value['corta_alambre']),2)
                        + mostrarPunteo(($value['destornilladores']),2)
                        + mostrarPunteo(($value['navaja_curva']),2)
                        + mostrarPunteo(($value['generador_de_tono_con_punta_inductiva']),5)
                        + mostrarPunteo(($value['taladro_tipo_industrial_de_1_2']),5)
                        + mostrarPunteo(($value['broca_pasa_muros_12_pulgadas_1_2_o_3_8']),5)
                        + mostrarPunteo(($value['guia_acerada_de_30_metros']),5)
                        + mostrarPunteo(($value['cadena_con_candados_asegurar_escalera_a_vehiculo']),5);
                                                
                        $html .= '
                                                <tr>
                                                    <td class="w-40 fw">TOTAL</td>
                                                    <td class="w-20 text-center fw">100</td>
                                                    <td class="w-20"></td>
                                                    <td class="w-20 text-center fw">'.$total.'</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        ';

                        if($value['evidencia_fotografica'] != ''){

                            $html .= '
                                <div style="page-break-after:always;"></div>
                                <div class="container">
                                    <div class="row">
                                        <div class="cell">
                                            <img src="../src/assets/img/logo.png" style="width:80px;">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="cell text-center">
                                            <img src="'.$value['evidencia_fotografica'].'" class="evidencia">
                                        </div>
                                    </div>
                                </div>
                            ';
                        }

                        if($value['segundo_archivo'] != ''){

                            $html .= '
                                <div style="page-break-after:always;"></div>
                                <div class="container">
                                    <div class="row">
                                        <div class="cell">
                                            <img src="../src/assets/img/logo.png" style="width:80px;">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="cell text-center">
                                            <img src="'.$value['segundo_archivo'].'" class="evidencia">
                                        </div>
                                    </div>
                                </div>
                            ';
                        }

                        if($value['tercer_archivo'] != ''){

                            $html .= '
                                <div style="page-break-after:always;"></div>
                                <div class="container">
                                    <div class="row">
                                        <div class="cell">
                                            <img src="../src/assets/img/logo.png" style="width:80px;">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="cell text-center">
                                            <img src="'.$value['tercer_archivo'].'" class="evidencia">
                                        </div>
                                    </div>
                                </div>
                            ';
                        }

                }
            }

            $html .= '
                </body>
                </html>
            ';


            $dompdf = new Dompdf();
            $dompdf->set_paper(array(0,0,612, 792.00));
            $dompdf->loadHtml($html);
            $dompdf->render();
            $contenido = $dompdf->output();

            $nombre_reporte = date('Ymdhis').'-adsl-report.pdf';
            $bytes = file_put_contents('../public/'.$nombre_reporte, $contenido);

            if(file_exists('../public/'.$nombre_reporte)){
                echo '1|'.$nombre_reporte;
            }else{
                echo '0|No se pudo generar el reporte';
            }

            unlink('../temp/'.$nombre_archivo);

        }else{
            echo '0|No hay registros';
            die();
        }
    }
}
