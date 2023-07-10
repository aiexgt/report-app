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
            "A" => "archivo",
            "B" => "marca_temporal",
            "C" => "puntuacion",
            "D" => "fecha",
            "E" => "mes_evaluado",
            "F" => "gerencia",
            "G" => "area_operativa",
            "H" => "nombre_de_tecnico",
            "I" => "nombre_del_supervisor",
            "J" => "orden_de_servicio",
            "K" => "tornillos_ajustados",
            "L" => "antena_sin_danios_o_torceduras",
            "M" => "fijacion_en_norma",
            "N" => "uso_de_dos_cinchos_plasticos",
            "O" => "orientacion_correcta",
            "P" => "torque_correcto_del_conector_homologado",
            "Q" => "capuchon_instalado_correctamente",
            "R" => "uso_de_cable_homologado",
            "S" => "uso_de_conectores_homologados",
            "T" => "cable_sin_uniones_ni_spliter",
            "U" => "bordeado_y_uso_de_grapas_correcto",
            "V" => "potencia_y_calidad_mayor_a_80",
            "W" => "transpondedor_11130",
            "X" => "transpondedor_11170",
            "Y" => "transpondedor_11190",
            "Z" => "transpondedor_11134",
            "AA" => "transpondedor_11174",
            "AB" => "transpondedor_11050",
            "AC" => "transpondedor_11010",
            "AD" => "revision_del_estado_del_cable_rca",
            "AE" => "instalacion_y_conexion_en_norma_del_stb",
            "AF" => "peladora_rg-6_homologada",
            "AG" => "ponchadora_rg-6_homologada",
            "AH" => "brujula",
            "AI" => "nivel_de_alto_impacto",
            "AJ" => "escalera",
            "AK" => "brocas_para_concreto",
            "AL" => "equipo_buscador_de_senal",
            "AM" => "taladro_con_rotomartillo",
            "AN" => "extension_electrica_de_20_metros",
            "AO" => "guia_de_acero_de_30_metros",
            "AP" => "corta_alambre",
            "AQ" => "pinza",
            "AR" => "alicate",
            "AS" => "navaja_curva_tipo_cuma",
            "AT" => "destornilladores",
            "AU" => "broca_pasa_muros_12_pulgadas_1_2_o_3_8",
            "AV" => "camisa",
            "AW" => "pantalon",
            "AX" => "botas",
            "AY" => "gafete",
            "AZ" => "faja",
            "BA" => "chaleco_preventivo",
            "BB" => "casco_de_proteccion",
            "BC" => "capa_impermeable",
            "BD" => "aspecto_personal",
            "BE" => "logotipo_de_empresa",
            "BF" => "carroceria",
            "BG" => "porta_escalera",
            "BH" => "estado_de_neumaticos",
            "BI" => "rotulado_de_unidad",
            "BJ" => "orden_y_limpieza",
            "BK" => "logotipo",
            "BL" => "estado_de_carroceria",
            "BM" => "focos",
            "BN" => "parrilla",
            "BO" => "casco",
            "BP" => "pide_via",
            "BQ" => "luces_laterales",
            "BR" => "estado_de_las_llantas",
            "BS" => "stop_traseros",
            "BT" => "tecnico_certificado_por_claro",
            "BU" => "evidencia_fotografica",
            "BV" => "segundo_archivo",
            "BW" => "calidad_tecnica",
            "BX" => "herramienta",
            "BY" => "uniforme",
            "BZ" => "vehiculo",
            "CA" => "tecnico_certificado",
            "CB" => "no_supervision",
            "CC" => "tecnologia",
            "CD" => "supervisor",
            "CE" => "observaciones"
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
                    <title>Auditoria DTH REPA</title>
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
                                        <td class="w-20 text-center">'.mostrarRespuesta($value['peladora_rg-6_homologada']).'</td>
                                        <td class="w-20 text-center">'.mostrarPunteo(($value['peladora_rg-6_homologada']), 5).'</td>
                                    </tr>
                                    <tr>
                                        <td class="w-40">Ponchadora RG-6 homologada</td>
                                        <td class="w-20 text-center">5</td>
                                        <td class="w-20 text-center">'.mostrarRespuesta($value['ponchadora_rg-6_homologada']).'</td>
                                        <td class="w-20 text-center">'.mostrarPunteo(($value['ponchadora_rg-6_homologada']), 5).'</td>
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
                                        <td class="w-20 text-center">'.mostrarRespuesta($value['guia_de_acero_de_30_metros']).'</td>
                                        <td class="w-20 text-center">'.mostrarPunteo(($value['guia_de_acero_de_30_metros']), 5).'</td>
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
                + mostrarPunteo(($value['peladora_rg-6_homologada']), 5)
                + mostrarPunteo(($value['ponchadora_rg-6_homologada']), 5)
                + mostrarPunteo(($value['brujula']), 10)
                + mostrarPunteo(($value['nivel_de_alto_impacto']), 10)
                + mostrarPunteo(($value['escalera']), 5)
                + mostrarPunteo(($value['brocas_para_concreto']), 5)
                + mostrarPunteo(($value['equipo_buscador_de_senal']), 25)
                + mostrarPunteo(($value['taladro_con_rotomartillo']), 10)
                + mostrarPunteo(($value['extension_electrica_de_20_metros']), 5)
                + mostrarPunteo(($value['guia_de_acero_de_30_metros']), 5)
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


                }

                if(
                    ($value['tornillos_ajustados'] != '' && $value['tornillos_ajustados'] != 'N/A')
                    || ($value['antena_sin_danios_o_torceduras'] != '' && $value['antena_sin_danios_o_torceduras'] != 'N/A')
                    || ($value['fijacion_en_norma'] != '' && $value['fijacion_en_norma'] != 'N/A')
                    || ($value['uso_de_dos_cinchos_plasticos'] != '' && $value['uso_de_dos_cinchos_plasticos'] != 'N/A')
                    || ($value['orientacion_correcta'] != '' && $value['orientacion_correcta'] != 'N/A')
                    || ($value['torque_correcto_del_conector_homologado'] != '' && $value['torque_correcto_del_conector_homologado'] != 'N/A')
                    || ($value['capuchon_instalado_correctamente'] != '' && $value['capuchon_instalado_correctamente'] != 'N/A')
                    || ($value['uso_de_cable_homologado'] != '' && $value['uso_de_cable_homologado'] != 'N/A')
                    || ($value['uso_de_conectores_homologados'] != '' && $value['uso_de_conectores_homologados'] != 'N/A')
                    || ($value['cable_sin_uniones_ni_spliter'] != '' && $value['cable_sin_uniones_ni_spliter'] != 'N/A')
                    || ($value['bordeado_y_uso_de_grapas_correcto'] != '' && $value['bordeado_y_uso_de_grapas_correcto'] != 'N/A')
                    || ($value['potencia_y_calidad_mayor_a_80'] != '' && $value['potencia_y_calidad_mayor_a_80'] != 'N/A')
                    || ($value['transpondedor_11130'] != '' && $value['transpondedor_11130'] != 'N/A')
                    || ($value['transpondedor_11170'] != '' && $value['transpondedor_11170'] != 'N/A')
                    || ($value['transpondedor_11190'] != '' && $value['transpondedor_11190'] != 'N/A')
                    || ($value['transpondedor_11134'] != '' && $value['transpondedor_11134'] != 'N/A')
                    || ($value['transpondedor_11174'] != '' && $value['transpondedor_11174'] != 'N/A')
                    || ($value['transpondedor_11050'] != '' && $value['transpondedor_11050'] != 'N/A')
                    || ($value['transpondedor_11010'] != '' && $value['transpondedor_11010'] != 'N/A')
                    || ($value['revision_del_estado_del_cable_rca'] != '' && $value['revision_del_estado_del_cable_rca'] != 'N/A')
                ){

                    $html .= '
                            <div style="page-break-after:always;"></div>
                            <div class="container">
                                <div class="row">
                                    <div class="cell">
                                        <img src="../src/assets/img/logo.png" style="width:80px;">
                                    </div>
                                    <div class="cell text-center" colspan="4"><h4>** Evaluación de Calidad Técnica DTH Reparaciones **</h4></div>
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
                                                    <td class="w-20 text-center" rowspan="4">Revisión física de antena</td>
                                                    <td class="w-10 text-center" rowspan="4">20%</td>
                                                    <td class="w-40">Tornillos ajustados</td>
                                                    <td class="w-10 text-center">5</td>
                                                    <td class="w-10 text-center">'.mostrarRespuesta($value['tornillos_ajustados']).'</td>
                                                    <td class="w-10 text-center">'.mostrarPunteo(($value['tornillos_ajustados']),5).'</td>
                                                </tr>
                                                <tr>
                                                    <td class="w-40">Antena sin daños o torceduras</td>
                                                    <td class="w-10 text-center">5</td>
                                                    <td class="w-10 text-center">'.mostrarRespuesta($value['antena_sin_danios_o_torceduras']).'</td>
                                                    <td class="w-10 text-center">'.mostrarPunteo(($value['antena_sin_danios_o_torceduras']),5).'</td>
                                                </tr>
                                                <tr>
                                                    <td class="w-40">Fijación en norma</td>
                                                    <td class="w-10 text-center">5</td>
                                                    <td class="w-10 text-center">'.mostrarRespuesta($value['fijacion_en_norma']).'</td>
                                                    <td class="w-10 text-center">'.mostrarPunteo(($value['fijacion_en_norma']),5).'</td>
                                                </tr>
                                                <tr>
                                                    <td class="w-40">Uso de dos cinchos plásticos</td>
                                                    <td class="w-10 text-center">5</td>
                                                    <td class="w-10 text-center">'.mostrarRespuesta($value['uso_de_dos_cinchos_plasticos']).'</td>
                                                    <td class="w-10 text-center">'.mostrarPunteo(($value['uso_de_dos_cinchos_plasticos']),5).'</td>
                                                </tr>
                                                <tr>
                                                    <td class="w-20 text-center" rowspan="3">LNB</td>
                                                    <td class="w-10 text-center" rowspan="3">20%</td>
                                                    <td class="w-40">Orientación correcta</td>
                                                    <td class="w-10 text-center">10</td>
                                                    <td class="w-10 text-center">'.mostrarRespuesta($value['orientacion_correcta']).'</td>
                                                    <td class="w-10 text-center">'.mostrarPunteo(($value['orientacion_correcta']),10).'</td>
                                                </tr>
                                                <tr>
                                                    <td class="w-40">Torque correcto del conector homologado</td>
                                                    <td class="w-10 text-center">5</td>
                                                    <td class="w-10 text-center">'.mostrarRespuesta($value['torque_correcto_del_conector_homologado']).'</td>
                                                    <td class="w-10 text-center">'.mostrarPunteo(($value['torque_correcto_del_conector_homologado']),5).'</td>
                                                </tr>
                                                <tr>
                                                    <td class="w-40">Capuchón instalado correctamente</td>
                                                    <td class="w-10 text-center">5</td>
                                                    <td class="w-10 text-center">'.mostrarRespuesta($value['capuchon_instalado_correctamente']).'</td>
                                                    <td class="w-10 text-center">'.mostrarPunteo(($value['capuchon_instalado_correctamente']),5).'</td>
                                                </tr>
                                                <tr>
                                                    <td class="w-20 text-center" rowspan="4">CABLEADO</td>
                                                    <td class="w-10 text-center" rowspan="4">20%</td>
                                                    <td class="w-40">Uso de cable homologado</td>
                                                    <td class="w-10 text-center">5</td>
                                                    <td class="w-10 text-center">'.mostrarRespuesta($value['uso_de_cable_homologado']).'</td>
                                                    <td class="w-10 text-center">'.mostrarPunteo(($value['uso_de_cable_homologado']),5).'</td>
                                                </tr>
                                                <tr>
                                                    <td class="w-40">Uso de conectores homologados</td>
                                                    <td class="w-10 text-center">5</td>
                                                    <td class="w-10 text-center">'.mostrarRespuesta($value['uso_de_conectores_homologados']).'</td>
                                                    <td class="w-10 text-center">'.mostrarPunteo(($value['uso_de_conectores_homologados']),5).'</td>
                                                </tr>
                                                <tr>
                                                    <td class="w-40">Cable sin uniones ni spliter</td>
                                                    <td class="w-10 text-center">5</td>
                                                    <td class="w-10 text-center">'.mostrarRespuesta($value['cable_sin_uniones_ni_spliter']).'</td>
                                                    <td class="w-10 text-center">'.mostrarPunteo(($value['cable_sin_uniones_ni_spliter']),5).'</td>
                                                </tr>
                                                <tr>
                                                    <td class="w-40">Bordeado y uso de grapas correcto</td>
                                                    <td class="w-10 text-center">5</td>
                                                    <td class="w-10 text-center">'.mostrarRespuesta($value['bordeado_y_uso_de_grapas_correcto']).'</td>
                                                    <td class="w-10 text-center">'.mostrarPunteo(($value['bordeado_y_uso_de_grapas_correcto']),5).'</td>
                                                </tr>
                                                <tr>
                                                    <td class="w-20 text-center" rowspan="10">EQUIPO</td>
                                                    <td class="w-10 text-center" rowspan="10">40%</td>
                                                    <td class="w-40">Potencia y calidad mayor a 80%</td>
                                                    <td class="w-10 text-center">5</td>
                                                    <td class="w-10 text-center">'.mostrarRespuesta($value['potencia_y_calidad_mayor_a_80']).'</td>
                                                    <td class="w-100 text-center">'.mostrarPunteo(($value['potencia_y_calidad_mayor_a_80']),5).'</td>
                                                </tr>
                                                <tr>
                                                    <td class="w-40">Transpondedor 11130</td>
                                                    <td class="w-10 text-center">4</td>
                                                    <td class="w-10 text-center">'.mostrarRespuesta($value['transpondedor_11130']).'</td>
                                                    <td class="w-10 text-center">'.mostrarPunteo(($value['transpondedor_11130']),4).'</td>
                                                </tr>
                                                <tr>
                                                    <td class="w-40">Transpondedor 11170</td>
                                                    <td class="w-10 text-center">4</td>
                                                    <td class="w-10 text-center">'.mostrarRespuesta($value['transpondedor_11170']).'</td>
                                                    <td class="w-10 text-center">'.mostrarPunteo(($value['transpondedor_11170']),4).'</td>
                                                </tr>
                                                <tr>
                                                    <td class="w-40">Transpondedor 11190</td>
                                                    <td class="w-10 text-center">4</td>
                                                    <td class="w-10 text-center">'.mostrarRespuesta($value['transpondedor_11190']).'</td>
                                                    <td class="w-10 text-center">'.mostrarPunteo(($value['transpondedor_11190']),4).'</td>
                                                </tr>
                                                <tr>
                                                    <td class="w-40">Transpondedor 11134</td>
                                                    <td class="w-10 text-center">4</td>
                                                    <td class="w-10 text-center">'.mostrarRespuesta($value['transpondedor_11134']).'</td>
                                                    <td class="w-10 text-center">'.mostrarPunteo(($value['transpondedor_11134']),4).'</td>
                                                </tr>
                                                <tr>
                                                    <td class="w-40">Transpondedor 11174</td>
                                                    <td class="w-10 text-center">4</td>
                                                    <td class="w-10 text-center">'.mostrarRespuesta($value['transpondedor_11174']).'</td>
                                                    <td class="w-10 text-center">'.mostrarPunteo(($value['transpondedor_11174']),4).'</td>
                                                </tr>
                                                <tr>
                                                    <td class="w-40">Transpondedor 11050</td>
                                                    <td class="w-10 text-center">4</td>
                                                    <td class="w-10 text-center">'.mostrarRespuesta($value['transpondedor_11050']).'</td>
                                                    <td class="w-10 text-center">'.mostrarPunteo(($value['transpondedor_11050']),4).'</td>
                                                </tr>
                                                <tr>
                                                    <td class="w-40">Transpondedor 11010</td>
                                                    <td class="w-10 text-center">4</td>
                                                    <td class="w-10 text-center">'.mostrarRespuesta($value['transpondedor_11010']).'</td>
                                                    <td class="w-10 text-center">'.mostrarPunteo(($value['transpondedor_11010']),4).'</td>
                                                </tr>
                                                <tr>
                                                    <td class="w-40">Revisión del estado del cable RCA</td>
                                                    <td class="w-10 text-center">4</td>
                                                    <td class="w-10 text-center">'.mostrarRespuesta($value['revision_del_estado_del_cable_rca']).'</td>
                                                    <td class="w-10 text-center">'.mostrarPunteo(($value['revision_del_estado_del_cable_rca']),4).'</td>
                                                </tr>
                                                <tr>
                                                    <td class="w-40">Instalación y conexión en norma del STB</td>
                                                    <td class="w-10 text-center">3</td>
                                                    <td class="w-10 text-center">'.mostrarRespuesta($value['instalacion_y_conexion_en_norma_del_stb']).'</td>
                                                    <td class="w-10 text-center">'.mostrarPunteo(($value['instalacion_y_conexion_en_norma_del_stb']),3).'</td>
                                                </tr>
                        ';
                        
                        $total = 0 
                        + mostrarPunteo(($value['tornillos_ajustados']),5)
                        + mostrarPunteo(($value['antena_sin_danios_o_torceduras']),5)
                        + mostrarPunteo(($value['fijacion_en_norma']),5)
                        + mostrarPunteo(($value['uso_de_dos_cinchos_plasticos']),5)
                        + mostrarPunteo(($value['orientacion_correcta']),10)
                        + mostrarPunteo(($value['torque_correcto_del_conector_homologado']),5)
                        + mostrarPunteo(($value['capuchon_instalado_correctamente']),5)
                        + mostrarPunteo(($value['uso_de_cable_homologado']),5)
                        + mostrarPunteo(($value['uso_de_conectores_homologados']),5)
                        + mostrarPunteo(($value['cable_sin_uniones_ni_spliter']),5)
                        + mostrarPunteo(($value['bordeado_y_uso_de_grapas_correcto']),5)
                        + mostrarPunteo(($value['potencia_y_calidad_mayor_a_80']),5)
                        + mostrarPunteo(($value['transpondedor_11130']),4)
                        + mostrarPunteo(($value['transpondedor_11170']),4)
                        + mostrarPunteo(($value['transpondedor_11190']),4)
                        + mostrarPunteo(($value['transpondedor_11134']),4)
                        + mostrarPunteo(($value['transpondedor_11174']),4)
                        + mostrarPunteo(($value['transpondedor_11050']),4)
                        + mostrarPunteo(($value['transpondedor_11010']),4)
                        + mostrarPunteo(($value['revision_del_estado_del_cable_rca']),4)
                        + mostrarPunteo(($value['instalacion_y_conexion_en_norma_del_stb']),3);
                                                
                        $html .= '
                                                <tr>
                                                    <td class="w-20 fw">TOTAL</td>
                                                    <td class="w-10 text-center fw">100</td>
                                                    <td class="w-40"></td>
                                                    <td class="w-10"></td>
                                                    <td class="w-10"></td>
                                                    <td class="w-10 text-center fw">'.$total.'</td>
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
