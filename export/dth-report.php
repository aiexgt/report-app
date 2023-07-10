<?php

use PhpOffice\PhpSpreadsheet\IOFactory;

include_once "../resources/dompdf/vendor/autoload.php";
require "../helper/function.php";
require "./components/style.php";

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
            "J" => "orden_de_servicio",
            "K" => "instalacion_de_antena_en_superficie_o_mastil_adecuado",
            "L" => "utilizacion_de_materiales_normado_por_claro",
            "M" => "fijacion_de_antena_anclaje_en_norma",
            "N" => "instalacion_de_lnb_en_norma",
            "O" => "linea_vista_adecuada",
            "P" => "resane_de_superficie_de_techo",
            "Q" => "limpieza_del_area_de_trabajo_materiales_sobrantes",
            "R" => "instalacion_de_cable_nuevo_normado_por_claro",
            "S" => "uso_de_conectores_nuevos_normados_por_claro",
            "T" => "correcta_aplicacion_de_conectores",
            "U" => "estetica_en_la_instalacion_del_cableado",
            "V" => "instalacion_de_cables_rg_06_sin_uniones",
            "W" => "uso_adecuado_de_grapas",
            "X" => "cliente_permite_acceso",
            "Y" => "instalaciones_de_cada_uno_de_los_equipos_contratados",
            "Z" => "nivel_de_calidad_70_se_encontro_gt_90_nivel_de_calidad_optima",
            "AA" => "nivel_de_potencia_70_se_encontro_gt_90_nivel_de_calidad_optima",
            "AB" => "calcomania_colocada_en_stb",
            "AC" => "verificacion_de_paquetes_contratados_canales",
            "AD" => "instalacion_y_conexion_adecuada_del_stb",
            "AE" => "peladora_rg_6_homologada",
            "AF" => "ponchadora_rg_6_homologada",
            "AG" => "brujula",
            "AH" => "nivel_de_alto_impacto",
            "AI" => "escalera",
            "AJ" => "brocas_para_concreto",
            "AK" => "equipo_buscador_de_senal",
            "AL" => "taladro_con_rotomartillo",
            "AM" => "extension_electrica_de_20_metros",
            "AN" => "guia_acerada_de_30_metros",
            "AO" => "corta_alambre",
            "AP" => "pinza",
            "AQ" => "alicate",
            "AR" => "navaja_curva_tipo_cuma",
            "AS" => "destornilladores",
            "AT" => "broca_pasa_muros_12_pulgadas_1_2_o_3_8",
            "AU" => "camisa",
            "AV" => "pantalon",
            "AW" => "botas",
            "AX" => "gafete",
            "AY" => "faja",
            "AZ" => "chaleco_preventivo",
            "BA" => "casco_de_proteccion",
            "BB" => "capa_impermeable",
            "BC" => "aspecto_personal",
            "BD" => "logotipo_de_empresa",
            "BE" => "carroceria",
            "BF" => "porta_escalera",
            "BG" => "estado_de_neumaticos",
            "BH" => "rotulado_de_unidad",
            "BI" => "orden_y_limpieza",
            "BJ" => "tecnico_certificado_por_claro",
            "BK" => "direccion_de_correo_electronico",
            "BL" => "evidencia_fotografica",
            "BM" => "segundo_archivo",
            "BN" => "tercer_archivo",
            "BO" => "calidad_tecnica",
            "BP" => "herramienta",
            "BQ" => "uniforme",
            "BR" => "vehiculo",
            "BS" => "tecnico_certificado",
            "BT" => "no_supervision",
            "BU" => "tecnologia",
            "BV" => "supervisor",
            "BW" => "observaciones"
        );

        $i = 3;
        $data = array();

        while ($sheet->getCell('J' . $i)->getCalculatedValue() != '') {

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
                    <title>Auditoria DTH</title>
            ';

            $html .= getComponentStyle();

            $html .= '
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
                            <div class="cell text-center" colspan="4"><h4>** Evaluación de Calidad Técnica DTH Instalaciones **</h4></div>
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
                                    <thead>
                                        <tr>
                                            <th class="w-20">Área</th>
                                            <th class="w-10">POND.</th>
                                            <th class="w-40">Descripción</th>
                                            <th class="w-10">POND.</th>
                                            <th class="w-10">Respuesta</th>
                                            <th class="w-10">Puntos</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="w-20 text-center" rowspan="7">ANTENA</td>
                                            <td class="w-10 text-center" rowspan="7">35</td>
                                            <td class="w-40">Instalación de antena en superficie o mastil adecuado</td>
                                            <td class="w-10 text-center">5</td>
                                            <td class="w-10 text-center">'.mostrarRespuesta($value['instalacion_de_antena_en_superficie_o_mastil_adecuado']).'</td>
                                            <td class="w-10 text-center">'.mostrarPunteo(($value['instalacion_de_antena_en_superficie_o_mastil_adecuado']),5).'</td>
                                        </tr>
                                        <tr>
                                            <td class="w-40">Utilizacion de materiales Normado por CLARO</td>
                                            <td class="w-10 text-center">5</td>
                                            <td class="w-10 text-center">'.mostrarRespuesta($value['utilizacion_de_materiales_normado_por_claro']).'</td>
                                            <td class="w-10 text-center">'.mostrarPunteo(($value['utilizacion_de_materiales_normado_por_claro']),5).'</td>
                                        </tr>
                                        <tr>
                                            <td class="w-40">Fijación de antena (anclaje) en norma</td>
                                            <td class="w-10 text-center">5</td>
                                            <td class="w-10 text-center">'.mostrarRespuesta($value['fijacion_de_antena_anclaje_en_norma']).'</td>
                                            <td class="w-10 text-center">'.mostrarPunteo(($value['fijacion_de_antena_anclaje_en_norma']),5).'</td>
                                        </tr>
                                        <tr>
                                            <td class="w-40">Instalación de LNB en norma</td>
                                            <td class="w-10 text-center">5</td>
                                            <td class="w-10 text-center">'.mostrarRespuesta($value['instalacion_de_lnb_en_norma']).'</td>
                                            <td class="w-10 text-center">'.mostrarPunteo(($value['instalacion_de_lnb_en_norma']),5).'</td>
                                        </tr>
                                        <tr>
                                            <td class="w-40">Linea vista adecuada</td>
                                            <td class="w-10 text-center">5</td>
                                            <td class="w-10 text-center">'.mostrarRespuesta($value['linea_vista_adecuada']).'</td>
                                            <td class="w-10 text-center">'.mostrarPunteo(($value['linea_vista_adecuada']),5).'</td>
                                        </tr>
                                        <tr>
                                            <td class="w-40">Resane de superficie de techo</td>
                                            <td class="w-10 text-center">5</td>
                                            <td class="w-10 text-center">'.mostrarRespuesta($value['resane_de_superficie_de_techo']).'</td>
                                            <td class="w-10 text-center">'.mostrarPunteo(($value['resane_de_superficie_de_techo']),5).'</td>
                                        </tr>
                                        <tr>
                                            <td class="w-40">Limpieza del área de trabajo, materiales sobrantes</td>
                                            <td class="w-10 text-center">5</td>
                                            <td class="w-10 text-center">'.mostrarRespuesta($value['limpieza_del_area_de_trabajo_materiales_sobrantes']).'</td>
                                            <td class="w-10 text-center">'.mostrarPunteo(($value['limpieza_del_area_de_trabajo_materiales_sobrantes']),5).'</td>
                                        </tr>
                                        <tr>
                                            <td class="w-20 text-center" rowspan="6">ACOMETIDA EXTERNA</td>
                                            <td class="w-10 text-center" rowspan="6">30</td>
                                            <td class="w-40">Instalación de cable "nuevo", normado por Claro</td>
                                            <td class="w-10 text-center">5</td>
                                            <td class="w-10 text-center">'.mostrarRespuesta($value['instalacion_de_cable_nuevo_normado_por_claro']).'</td>
                                            <td class="w-10 text-center">'.mostrarPunteo(($value['instalacion_de_cable_nuevo_normado_por_claro']),5).'</td>
                                        </tr>
                                        <tr>
                                            <td class="w-40">Uso de conectores "nuevos", normados por Claro</td>
                                            <td class="w-10 text-center">5</td>
                                            <td class="w-10 text-center">'.mostrarRespuesta($value['uso_de_conectores_nuevos_normados_por_claro']).'</td>
                                            <td class="w-10 text-center">'.mostrarPunteo(($value['uso_de_conectores_nuevos_normados_por_claro']),5).'</td>
                                        </tr>
                                        <tr>
                                            <td class="w-40">Correcta aplicacion de conectores</td>
                                            <td class="w-10 text-center">5</td>
                                            <td class="w-10 text-center">'.mostrarRespuesta($value['correcta_aplicacion_de_conectores']).'</td>
                                            <td class="w-10 text-center">'.mostrarPunteo(($value['correcta_aplicacion_de_conectores']),5).'</td>
                                        </tr>
                                        <tr>
                                            <td class="w-40">Estetica en la instalación del cableado</td>
                                            <td class="w-10 text-center">5</td>
                                            <td class="w-10 text-center">'.mostrarRespuesta($value['estetica_en_la_instalacion_del_cableado']).'</td>
                                            <td class="w-10 text-center">'.mostrarPunteo(($value['estetica_en_la_instalacion_del_cableado']),5).'</td>
                                        </tr>
                                        <tr>
                                            <td class="w-40">Instalacion de cables RG-06 sin uniones</td>
                                            <td class="w-10 text-center">5</td>
                                            <td class="w-10 text-center">'.mostrarRespuesta($value['instalacion_de_cables_rg_06_sin_uniones']).'</td>
                                            <td class="w-10 text-center">'.mostrarPunteo(($value['instalacion_de_cables_rg_06_sin_uniones']),5).'</td>
                                        </tr>
                                        <tr>
                                            <td class="w-40">Uso adecuado de grapas</td>
                                            <td class="w-10 text-center">5</td>
                                            <td class="w-10 text-center">'.mostrarRespuesta($value['uso_adecuado_de_grapas']).'</td>
                                            <td class="w-10 text-center">'.mostrarPunteo(($value['uso_adecuado_de_grapas']),5).'</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                ';
                                        
                $html .= '          
                    </div>
                    <div class="container">
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
                                        <th class="w-20">Área</th>
                                        <th class="w-10">POND.</th>
                                        <th class="w-40">Descripción</th>
                                        <th class="w-10">POND.</th>
                                        <th class="w-10">Respuesta</th>
                                        <th class="w-10">Puntos</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="w-20 text-center" rowspan="6">ACOMETIDA INTERNA</td>
                                        <td class="w-10 text-center" rowspan="6">30</td>
                                        <td class="w-40">Instalaciones de cada uno de los  de equipos contratados</td>
                                        <td class="w-10 text-center">5</td>
                                        <td class="w-10 text-center">'.mostrarRespuesta($value['instalaciones_de_cada_uno_de_los_equipos_contratados']).'</td>
                                        <td class="w-10 text-center">'.mostrarPunteo(($value['instalaciones_de_cada_uno_de_los_equipos_contratados']),5).'</td>
                                    </tr>
                                    <tr>
                                        <td class="w-40">Nivel de calidad ≥ 70%, se encontro: // GT ≥90    // Nivel de calidad óptima</td>
                                        <td class="w-10 text-center">5</td>
                                        <td class="w-10 text-center">'.mostrarRespuesta($value['nivel_de_calidad_70_se_encontro_gt_90_nivel_de_calidad_optima']).'</td>
                                        <td class="w-10 text-center">'.mostrarPunteo(($value['nivel_de_calidad_70_se_encontro_gt_90_nivel_de_calidad_optima']),5).'</td>
                                    </tr>
                                    <tr>
                                        <td class="w-40">Nivel de potencia ≥ 70%, se encontro: // GT≥90   // Nivel de calidad óptima</td>
                                        <td class="w-10 text-center">5</td>
                                        <td class="w-10 text-center">'.mostrarRespuesta($value['nivel_de_potencia_70_se_encontro_gt_90_nivel_de_calidad_optima']).'</td>
                                        <td class="w-10 text-center">'.mostrarPunteo(($value['nivel_de_potencia_70_se_encontro_gt_90_nivel_de_calidad_optima']),5).'</td>
                                    </tr>
                                    <tr>
                                        <td class="w-40">Calcomania colocada en STB</td>
                                        <td class="w-10 text-center">5</td>
                                        <td class="w-10 text-center">'.mostrarRespuesta($value['calcomania_colocada_en_stb']).'</td>
                                        <td class="w-10 text-center">'.mostrarPunteo(($value['calcomania_colocada_en_stb']),5).'</td>
                                    </tr>
                                    <tr>
                                        <td class="w-40">Verificacion de paquetes contratados ( Canales)</td>
                                        <td class="w-10 text-center">5</td>
                                        <td class="w-10 text-center">'.mostrarRespuesta($value['verificacion_de_paquetes_contratados_canales']).'</td>
                                        <td class="w-10 text-center">'.mostrarPunteo(($value['verificacion_de_paquetes_contratados_canales']),5).'</td>
                                    </tr>
                                    <tr>
                                        <td class="w-40">Instalación y conexión adecuada del STB</td>
                                        <td class="w-10 text-center">5</td>
                                        <td class="w-10 text-center">'.mostrarRespuesta($value['instalacion_y_conexion_adecuada_del_stb']).'</td>
                                        <td class="w-10 text-center">'.mostrarPunteo(($value['instalacion_y_conexion_adecuada_del_stb']),5).'</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="row">
                            <div class="cell" colspan="6"><br></div>
                        </div>

                ';

                $total = 0
                + mostrarPunteo(($value['instalacion_de_antena_en_superficie_o_mastil_adecuado']),5)
                + mostrarPunteo(($value['utilizacion_de_materiales_normado_por_claro']),5)
                + mostrarPunteo(($value['fijacion_de_antena_anclaje_en_norma']),5)
                + mostrarPunteo(($value['instalacion_de_lnb_en_norma']),5)
                + mostrarPunteo(($value['linea_vista_adecuada']),5)
                + mostrarPunteo(($value['resane_de_superficie_de_techo']),5)
                + mostrarPunteo(($value['limpieza_del_area_de_trabajo_materiales_sobrantes']),5)
                + mostrarPunteo(($value['instalacion_de_cable_nuevo_normado_por_claro']),5)
                + mostrarPunteo(($value['uso_de_conectores_nuevos_normados_por_claro']),5)
                + mostrarPunteo(($value['correcta_aplicacion_de_conectores']),5)
                + mostrarPunteo(($value['estetica_en_la_instalacion_del_cableado']),5)
                + mostrarPunteo(($value['instalacion_de_cables_rg_06_sin_uniones']),5)
                + mostrarPunteo(($value['uso_adecuado_de_grapas']),5)
                + mostrarPunteo(($value['instalaciones_de_cada_uno_de_los_equipos_contratados']),5)
                + mostrarPunteo(($value['nivel_de_calidad_70_se_encontro_gt_90_nivel_de_calidad_optima']),5)
                + mostrarPunteo(($value['nivel_de_potencia_70_se_encontro_gt_90_nivel_de_calidad_optima']),5)
                + mostrarPunteo(($value['calcomania_colocada_en_stb']),5)
                + mostrarPunteo(($value['verificacion_de_paquetes_contratados_canales']),5)
                + mostrarPunteo(($value['instalacion_y_conexion_adecuada_del_stb']),5);

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

                if($value['cuarto_archivo'] != ''){

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
                                    <img src="'.$value['cuarto_archivo'].'" class="evidencia">
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
                    || ($value['chaleco_preventivo'] != '' && $value['chaleco_preventivo'] != 'N/A')
                    || ($value['casco_de_proteccion'] != '' && $value['casco_de_proteccion'] != 'N/A')
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
                                <div class="cell text-center" colspan="4"><h4>** Evaluación de Vehículos y Uniformes DTH</h4></div>
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
                        || ($value['chaleco_preventivo'] != '' && $value['chaleco_preventivo'] != 'N/A')
                        || ($value['casco_de_proteccion'] != '' && $value['casco_de_proteccion'] != 'N/A')
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
                                                <td class="w-20 text-center">'.mostrarPunteo(($value['faja']),10).'</td>
                                            </tr>

                                            <tr>
                                            <tr>
                                                <td class="w-40">Chaleco preventivo</td>
                                                <td class="w-20 text-center">5</td>
                                                <td class="w-20 text-center">'.mostrarRespuesta($value['chaleco_preventivo']).'</td>
                                                <td class="w-20 text-center">'.mostrarPunteo(($value['chaleco_preventivo']),10).'</td>
                                            </tr>
                                            <tr>
                                                <td class="w-40">Casco de protección</td>
                                                <td class="w-20 text-center">10</td>
                                                <td class="w-20 text-center">'.mostrarRespuesta($value['casco_de_proteccion']).'</td>
                                                <td class="w-20 text-center">'.mostrarPunteo(($value['casco_de_proteccion']),10).'</td>
                                            </tr>
                                            <tr>
                                                <td class="w-40">Capa impermeable</td>
                                                <td class="w-20 text-center">5</td>
                                                <td class="w-20 text-center">'.mostrarRespuesta($value['capa_impermeable']).'</td>
                                                <td class="w-20 text-center">'.mostrarPunteo(($value['capa_impermeable']),10).'</td>
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
                        + mostrarPunteo(($value['faja']),10)
                        + mostrarPunteo(($value['chaleco_preventivo']),10)
                        + mostrarPunteo(($value['casco_de_proteccion']),10)
                        + mostrarPunteo(($value['capa_impermeable']),10)
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
                                <div class="row">
                                    <div class="cell" colspan="6"><br></div>
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
                    ($value['peladora_rg_6_homologada'] != '' && $value['peladora_rg_6_homologada'] != 'N/A')
                    || ($value['ponchadora_rg_6_homologada'] != '' && $value['ponchadora_rg_6_homologada'] != 'N/A')
                    || ($value['brujula'] != '' && $value['brujula'] != 'N/A')
                    || ($value['nivel_de_alto_impacto'] != '' && $value['nivel_de_alto_impacto'] != 'N/A')
                    || ($value['escalera'] != '' && $value['escalera'] != 'N/A')
                    || ($value['brocas_para_concreto'] != '' && $value['brocas_para_concreto'] != 'N/A')
                    || ($value['equipo_buscador_de_senal'] != '' && $value['equipo_buscador_de_senal'] != 'N/A')
                    || ($value['taladro_con_rotomartillo'] != '' && $value['taladro_con_rotomartillo'] != 'N/A')
                    || ($value['extension_electrica_de_20_metros'] != '' && $value['extension_electrica_de_20_metros'] != 'N/A')
                    || ($value['guia_acerada_de_30_metros'] != '' && $value['guia_acerada_de_30_metros'] != 'N/A')
                    || ($value['corta_alambre'] != '' && $value['corta_alambre'] != 'N/A')
                    || ($value['pinza'] != '' && $value['pinza'] != 'N/A')
                    || ($value['alicate'] != '' && $value['alicate'] != 'N/A')
                    || ($value['navaja_curva_tipo_cuma'] != '' && $value['navaja_curva_tipo_cuma'] != 'N/A')
                    || ($value['destornilladores'] != '' && $value['destornilladores'] != 'N/A')
                    || ($value['broca_pasa_muros_12_pulgadas_1_2_o_3_8'] != '' && $value['broca_pasa_muros_12_pulgadas_1_2_o_3_8'] != 'N/A')
                ){

                    $html .= '
                        <div style="page-break-after:always;"></div>
                            <div class="container">
                                <div class="row">
                                    <div class="cell">
                                        <img src="../src/assets/img/logo.png" style="width:80px;">
                                    </div>
                                    <div class="cell text-center" colspan="4"><h4>** Evaluación de Auditoria DTH Reparaciones e Instalaciones</h4></div>
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
                                            <tbody>
                                                <tr class="bg-secondary">
                                                    <td colspan="4" class="w-80 text-center">DTH</td>
                                                </tr>
                                            </tbody>
                                            <thead>
                                                <tr>
                                                    <th class="w-40">Descripción</th>
                                                    <th class="w-20">POND.</th>
                                                    <th class="w-20">Respuesta</th>
                                                    <th class="w-20">Puntos</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td class="w-40">Peladora RG-6 homologada</td>
                                                    <td class="w-20 text-center">5</td>
                                                    <td class="w-20 text-center">'.mostrarRespuesta($value['peladora_rg_6_homologada']).'</td>
                                                    <td class="w-20 text-center">'.mostrarPunteo(($value['peladora_rg_6_homologada']), 5).'</td>
                                                </tr>
                                                <tr>
                                                    <td class="w-40">Ponchadora RG-6 homologada</td>
                                                    <td class="w-20 text-center">5</td>
                                                    <td class="w-20 text-center">'.mostrarRespuesta($value['ponchadora_rg_6_homologada']).'</td>
                                                    <td class="w-20 text-center">'.mostrarPunteo(($value['ponchadora_rg_6_homologada']), 5).'</td>
                                                </tr>
                                                <tr>
                                                    <td class="w-40">Brujula</td>
                                                    <td class="w-20 text-center">10</td>
                                                    <td class="w-20 text-center">'.mostrarRespuesta($value['brujula']).'</td>
                                                    <td class="w-20 text-center">'.mostrarPunteo(($value['brujula']), 10).'</td>
                                                </tr>
                                                <tr>
                                                    <td class="w-40">Nivel de alto impacto</td>
                                                    <td class="w-20 text-center">10</td>
                                                    <td class="w-20 text-center">'.mostrarRespuesta($value['nivel_de_alto_impacto']).'</td>
                                                    <td class="w-20 text-center">'.mostrarPunteo(($value['nivel_de_alto_impacto']), 10).'</td>
                                                </tr>
                                                <tr>
                                                    <td class="w-40">Escalera</td>
                                                    <td class="w-20 text-center">5</td>
                                                    <td class="w-20 text-center">'.mostrarRespuesta($value['escalera']).'</td>
                                                    <td class="w-20 text-center">'.mostrarPunteo(($value['escalera']), 5).'</td>
                                                </tr>
                                                <tr>
                                                    <td class="w-40">Brocas para concreto</td>
                                                    <td class="w-20 text-center">5</td>
                                                    <td class="w-20 text-center">'.mostrarRespuesta($value['brocas_para_concreto']).'</td>
                                                    <td class="w-20 text-center">'.mostrarPunteo(($value['brocas_para_concreto']), 5).'</td>
                                                </tr>
                                                <tr>
                                                    <td class="w-40">Equipo buscador de señal</td>
                                                    <td class="w-20 text-center">25</td>
                                                    <td class="w-20 text-center">'.mostrarRespuesta($value['equipo_buscador_de_senal']).'</td>
                                                    <td class="w-20 text-center">'.mostrarPunteo(($value['equipo_buscador_de_senal']), 25).'</td>
                                                </tr>
                                                <tr>
                                                    <td class="w-40">Taladro con rotomartillo</td>
                                                    <td class="w-20 text-center">10</td>
                                                    <td class="w-20 text-center">'.mostrarRespuesta($value['taladro_con_rotomartillo']).'</td>
                                                    <td class="w-20 text-center">'.mostrarPunteo(($value['taladro_con_rotomartillo']), 10).'</td>
                                                </tr>
                                                <tr>
                                                    <td class="w-40">Extensión eléctrica de 20 metros</td>
                                                    <td class="w-20 text-center">5</td>
                                                    <td class="w-20 text-center">'.mostrarRespuesta($value['extension_electrica_de_20_metros']).'</td>
                                                    <td class="w-20 text-center">'.mostrarPunteo(($value['extension_electrica_de_20_metros']), 5).'</td>
                                                </tr>
                                                <tr>
                                                    <td class="w-40">Guia de acero de 30 metros </td>
                                                    <td class="w-20 text-center">5</td>
                                                    <td class="w-20 text-center">'.mostrarRespuesta($value['guia_acerada_de_30_metros']).'</td>
                                                    <td class="w-20 text-center">'.mostrarPunteo(($value['guia_acerada_de_30_metros']), 5).'</td>
                                                </tr>
                                                <tr>
                                                    <td class="w-40">Corta Alambre</td>
                                                    <td class="w-20 text-center">2</td>
                                                    <td class="w-20 text-center">'.mostrarRespuesta($value['corta_alambre']).'</td>
                                                    <td class="w-20 text-center">'.mostrarPunteo(($value['corta_alambre']), 2).'</td>
                                                </tr>
                                                <tr>
                                                    <td class="w-40">Pinza</td>
                                                    <td class="w-20 text-center">2</td>
                                                    <td class="w-20 text-center">'.mostrarRespuesta($value['pinza']).'</td>
                                                    <td class="w-20 text-center">'.mostrarPunteo(($value['pinza']), 2).'</td>
                                                </tr>
                                                <tr>
                                                    <td class="w-40">Alicate</td>
                                                    <td class="w-20 text-center">2</td>
                                                    <td class="w-20 text-center">'.mostrarRespuesta($value['alicate']).'</td>
                                                    <td class="w-20 text-center">'.mostrarPunteo(($value['alicate']), 2).'</td>
                                                </tr>
                                                <tr>
                                                    <td class="w-40">Navaja curva, tipo cuma</td>
                                                    <td class="w-20 text-center">2</td>
                                                    <td class="w-20 text-center">'.mostrarRespuesta($value['navaja_curva_tipo_cuma']).'</td>
                                                    <td class="w-20 text-center">'.mostrarPunteo(($value['navaja_curva_tipo_cuma']), 2).'</td>
                                                </tr>
                                                <tr>
                                                    <td class="w-40">Desatornilladores</td>
                                                    <td class="w-20 text-center">2</td>
                                                    <td class="w-20 text-center">'.mostrarRespuesta($value['destornilladores']).'</td>
                                                    <td class="w-20 text-center">'.mostrarPunteo(($value['destornilladores']), 2).'</td>
                                                </tr>
                                                <tr>
                                                    <td class="w-40">Broca pasa muros 12 pulgadas *  1/2 o 3/8</td>
                                                    <td class="w-20 text-center">5</td>
                                                    <td class="w-20 text-center">'.mostrarRespuesta($value['broca_pasa_muros_12_pulgadas_1_2_o_3_8']).'</td>
                                                    <td class="w-20 text-center">'.mostrarPunteo(($value['broca_pasa_muros_12_pulgadas_1_2_o_3_8']), 5).'</td>
                                                </tr>
                        ';
            
                        $total = 0 
                        + mostrarPunteo(($value['peladora_rg_6_homologada']), 5)
                        + mostrarPunteo(($value['ponchadora_rg_6_homologada']), 5)
                        + mostrarPunteo(($value['brujula']), 10)
                        + mostrarPunteo(($value['nivel_de_alto_impacto']), 10)
                        + mostrarPunteo(($value['escalera']), 5)
                        + mostrarPunteo(($value['brocas_para_concreto']), 5)
                        + mostrarPunteo(($value['equipo_buscador_de_senal']), 25)
                        + mostrarPunteo(($value['taladro_con_rotomartillo']), 10)
                        + mostrarPunteo(($value['extension_electrica_de_20_metros']), 5)
                        + mostrarPunteo(($value['guia_acerada_de_30_metros']), 5)
                        + mostrarPunteo(($value['corta_alambre']), 2)
                        + mostrarPunteo(($value['pinza']), 2)
                        + mostrarPunteo(($value['alicate']), 2)
                        + mostrarPunteo(($value['navaja_curva_tipo_cuma']), 2)
                        + mostrarPunteo(($value['destornilladores']), 2)
                        + mostrarPunteo(($value['broca_pasa_muros_12_pulgadas_1_2_o_3_8']), 5);
                                                
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

            $nombre_reporte = date('Ymdhis').'-dth-repa-report.pdf';
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
