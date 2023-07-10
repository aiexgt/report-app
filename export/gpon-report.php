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
            "K" => "ubicacion_de_puerto_en_base_a_red_asignada",
            "L" => "instalacion_fibra_en_infraestructura_existente_postes",
            "M" => "estetica_general_de_la_instalacion_cableado",
            "N" => "uso_de_conectores_nuevos_normados_por_claro",
            "O" => "nivel_de_potencia_optica_en_puerto_asignado_en_nap",
            "P" => "nivel_de_potencia_optica_en_roseta_optica",
            "Q" => "colocacion_de_roseta_optica",
            "R" => "colocacion_de_patchcore_en_roseta_optica_ont",
            "S" => "colocacion_de_ont_en_casa_del_cliente",
            "T" => "nivel_de_potencia_optica_en_patch_cord_entrada_ont",
            "U" => "medicion_de_velocidad_en_base_a_lo_solicitado_por_el_cliente_verificacion_de_funcionamienteo_de_internet_velocidad_contratada_telefonia_funcionamiento_tv_paquetes_contratados",
            "V" => "colocacion_de_cables_utp_en_ont",
            "W" => "colocacion_de_stb_en_casa_del_cliente",
            "X" => "medidor_de_potencia_optica",
            "Y" => "microscopio_optico",
            "Z" => "etiquetadora",
            "AA" => "tijera_para_cortar_kevlar",
            "AB" => "barreno_con_roto_martillo",
            "AC" => "cortadora_fo_angulo_recto",
            "AD" => "peladora_de_fo_3_en_1",
            "AE" => "cortadora_de_buffer",
            "AF" => "kit_de_limpieza_para_fibra_optica",
            "AG" => "escalera_de_fibra_de_vidrio_20",
            "AH" => "juego_de_destornilladores_de_castigadera_y_phillips",
            "AI" => "juego_de_brocas_para_concreto_y_metal_diferentes_medidas_incluir_broca_pasa_muro",
            "AJ" => "extension_electrica_calibre_12",
            "AK" => "guia_acerada_125_con_dispensador",
            "AL" => "guia_pasa_cables_de_fibra_de_vidrio",
            "AM" => "gancho_para_levantar_tapaderas_pozo_resultado",
            "AN" => "camisa",
            "AO" => "casco",
            "AP" => "pantalon",
            "AQ" => "cinturon_de_seguridad_para_amarre_a_poste",
            "AR" => "botas_industriales",
            "AS" => "gafete",
            "AT" => "faja_cincho",
            "AU" => "chaleco_preventivo",
            "AV" => "guantes_de_cuero",
            "AW" => "capa_impermeable",
            "AX" => "aspecto_personal",
            "AY" => "logotipo_de_empresa",
            "AZ" => "carroceria",
            "BA" => "porta_escalera",
            "BB" => "estado_de_neumaticos",
            "BC" => "rotulado_de_unidad",
            "BD" => "orden_y_limpieza",
            "BE" => "tecnico_certificado",
            "BF" => "evidencia_fotografica",
            "BG" => "segundo_archivo",
            "BH" => "tercer_archivo",
            "BI" => "tecnico_certificado_por_claro",
            "BJ" => "cuarto_archivo",
            "BK" => "calidad_tecnica",
            "BL" => "herramienta",
            "BM" => "uniforme",
            "BN" => "vehiculo",
            "BO" => "tecnico_certificado",
            "BP" => "no_supervision",
            "BQ" => "tecnologia",
            "BR" => "supervisor",
            "BS" => "observaciones"
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
                            <div class="cell text-center" colspan="4"><h4>** Evaluación de Calidad Técnica Instalaciones GPON **</h4></div>
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
                                            <td class="w-20 text-center">NAP</td>
                                            <td class="w-10 text-center">5</td>
                                            <td class="w-40">Ubicación de puerto en base a red asignada</td>
                                            <td class="w-10 text-center">5</td>
                                            <td class="w-10 text-center">'.mostrarRespuesta($value['ubicacion_de_puerto_en_base_a_red_asignada']).'</td>
                                            <td class="w-10 text-center">'.mostrarPunteo(($value['ubicacion_de_puerto_en_base_a_red_asignada']),5).'</td>
                                        </tr>
                                        <tr>
                                            <td class="w-20 text-center" rowspan="5">ACOMENTIDA</td>
                                            <td class="w-10 text-center" rowspan="5">45</td>
                                            <td class="w-40">Instalación Fibra en Infraestructura existente (Postes)</td>
                                            <td class="w-10 text-center">5</td>
                                            <td class="w-10 text-center">'.mostrarRespuesta($value['instalacion_fibra_en_infraestructura_existente_postes']).'</td>
                                            <td class="w-10 text-center">'.mostrarPunteo(($value['instalacion_fibra_en_infraestructura_existente_postes']),5).'</td>
                                        </tr>
                                        <tr>
                                            <td class="w-40">Estetica general de la instalación (Cableado) </td>
                                            <td class="w-10 text-center">5</td>
                                            <td class="w-10 text-center">'.mostrarRespuesta($value['estetica_general_de_la_instalacion_cableado']).'</td>
                                            <td class="w-10 text-center">'.mostrarPunteo(($value['estetica_general_de_la_instalacion_cableado']),5).'</td>
                                        </tr>
                                        <tr>
                                            <td class="w-40">Uso de conectores "nuevos", normados por Claro</td>
                                            <td class="w-10 text-center">10</td>
                                            <td class="w-10 text-center">'.mostrarRespuesta($value['uso_de_conectores_nuevos_normados_por_claro']).'</td>
                                            <td class="w-10 text-center">'.mostrarPunteo(($value['uso_de_conectores_nuevos_normados_por_claro']),10).'</td>
                                        </tr>
                                        <tr>
                                            <td class="w-40">Nivel de potencia óptica en puerto asignado en NAP </td>
                                            <td class="w-10 text-center">15</td>
                                            <td class="w-10 text-center">'.mostrarRespuesta($value['nivel_de_potencia_optica_en_puerto_asignado_en_nap']).'</td>
                                            <td class="w-10 text-center">'.mostrarPunteo(($value['nivel_de_potencia_optica_en_puerto_asignado_en_nap']),15).'</td>
                                        </tr>
                                        <tr>
                                            <td class="w-40">Nivel de potencia óptica en roseta óptica </td>
                                            <td class="w-10 text-center">10</td>
                                            <td class="w-10 text-center">'.mostrarRespuesta($value['nivel_de_potencia_optica_en_roseta_optica']).'</td>
                                            <td class="w-10 text-center">'.mostrarPunteo(($value['nivel_de_potencia_optica_en_roseta_optica']),10).'</td>
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
                                            <td class="w-20 text-center" rowspan="7">ONT</td>
                                            <td class="w-10 text-center" rowspan="7">30</td>
                                            <td class="w-40">Colocación de roseta óptica </td>
                                            <td class="w-10 text-center">5</td>
                                            <td class="w-10 text-center">'.mostrarRespuesta($value['colocacion_de_roseta_optica']).'</td>
                                            <td class="w-10 text-center">'.mostrarPunteo(($value['colocacion_de_roseta_optica']),5).'</td>
                                        </tr>
                                        <tr>
                                            <td class="w-40">Colocación de Patchcore en Roseta óptica /ONT </td>
                                            <td class="w-10 text-center">5</td>
                                            <td class="w-10 text-center">'.mostrarRespuesta($value['colocacion_de_patchcore_en_roseta_optica_ont']).'</td>
                                            <td class="w-10 text-center">'.mostrarPunteo(($value['colocacion_de_patchcore_en_roseta_optica_ont']),5).'</td>
                                        </tr>
                                        <tr>
                                            <td class="w-40">Colocación de ONT en casa del cliente </td>
                                            <td class="w-10 text-center">5</td>
                                            <td class="w-10 text-center">'.mostrarRespuesta($value['colocacion_de_ont_en_casa_del_cliente']).'</td>
                                            <td class="w-10 text-center">'.mostrarPunteo(($value['colocacion_de_ont_en_casa_del_cliente']),5).'</td>
                                        </tr>
                                        <tr>
                                            <td class="w-40">Nivel de potencia óptica en patch cord entrada ONT </td>
                                            <td class="w-10 text-center">10</td>
                                            <td class="w-10 text-center">'.mostrarRespuesta($value['nivel_de_potencia_optica_en_patch_cord_entrada_ont']).'</td>
                                            <td class="w-10 text-center">'.mostrarPunteo(($value['nivel_de_potencia_optica_en_patch_cord_entrada_ont']),10).'</td>
                                        </tr>
                                        <tr>
                                            <td class="w-40">Medición de velocidad en base a lo solicitado por el cliente / Verificación de funcionamienteo de Internet (Velocidad contratada) / telefonía (funcionamiento) / TV (Paquetes contratados)</td>
                                            <td class="w-10 text-center">10</td>
                                            <td class="w-10 text-center">'.mostrarRespuesta($value['medicion_de_velocidad_en_base_a_lo_solicitado_por_el_cliente_verificacion_de_funcionamienteo_de_internet_velocidad_contratada_telefonia_funcionamiento_tv_paquetes_contratados']).'</td>
                                            <td class="w-10 text-center">'.mostrarPunteo(($value['medicion_de_velocidad_en_base_a_lo_solicitado_por_el_cliente_verificacion_de_funcionamienteo_de_internet_velocidad_contratada_telefonia_funcionamiento_tv_paquetes_contratados']),10).'</td>
                                        </tr>
                                        <tr>
                                            <td class="w-40">Colocación de Cables UTP en ONT </td>
                                            <td class="w-10 text-center">10</td>
                                            <td class="w-10 text-center">'.mostrarRespuesta($value['colocacion_de_cables_utp_en_ont']).'</td>
                                            <td class="w-10 text-center">'.mostrarPunteo(($value['colocacion_de_cables_utp_en_ont']),10).'</td>
                                        </tr>
                                        <tr>
                                            <td class="w-40">Colocación de STB en casa del Cliente </td>
                                            <td class="w-10 text-center">5</td>
                                            <td class="w-10 text-center">'.mostrarRespuesta($value['colocacion_de_stb_en_casa_del_cliente']).'</td>
                                            <td class="w-10 text-center">'.mostrarPunteo(($value['colocacion_de_stb_en_casa_del_cliente']),5).'</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="row">
                            <div class="cell" colspan="6"><br></div>
                        </div>
                ';

                $total = 0
                + mostrarPunteo(($value['ubicacion_de_puerto_en_base_a_red_asignada']),5)
                + mostrarPunteo(($value['instalacion_fibra_en_infraestructura_existente_postes']),5)
                + mostrarPunteo(($value['estetica_general_de_la_instalacion_cableado']),5)
                + mostrarPunteo(($value['uso_de_conectores_nuevos_normados_por_claro']),10)
                + mostrarPunteo(($value['nivel_de_potencia_optica_en_puerto_asignado_en_nap']),15)
                + mostrarPunteo(($value['nivel_de_potencia_optica_en_roseta_optica']),10)
                + mostrarPunteo(($value['colocacion_de_roseta_optica']),5)
                + mostrarPunteo(($value['colocacion_de_patchcore_en_roseta_optica_ont']),5)
                + mostrarPunteo(($value['colocacion_de_ont_en_casa_del_cliente']),5)
                + mostrarPunteo(($value['nivel_de_potencia_optica_en_patch_cord_entrada_ont']),10)
                + mostrarPunteo(($value['medicion_de_velocidad_en_base_a_lo_solicitado_por_el_cliente_verificacion_de_funcionamienteo_de_internet_velocidad_contratada_telefonia_funcionamiento_tv_paquetes_contratados']),10)
                + mostrarPunteo(($value['colocacion_de_cables_utp_en_ont']),10)
                + mostrarPunteo(($value['colocacion_de_stb_en_casa_del_cliente']),5);

                $html .= '
                        <div class="row">
                            <div class="cell">Observaciónes: </div>
                            <div class="cell cb" colspan="4">'.$value['observaciones'].'</div>
                            <div class="cell cb text-center">'.$total.'</div>
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

                    $value['cuarto_archivo'] = str_replace('open','uc',$value['cuarto_archivo']);
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
                    || ($value['botas_industriales'] != '' && $value['botas_industriales'] != 'N/A')
                    || ($value['gafete'] != '' && $value['gafete'] != 'N/A')
                    || ($value['faja_cincho'] != '' && $value['faja_cincho'] != 'N/A')
                    || ($value['cinturon_de_seguridad_para_amarre_a_poste'] != '' && $value['cinturon_de_seguridad_para_amarre_a_poste'] != 'N/A')
                    || ($value['chaleco_preventivo'] != '' && $value['chaleco_preventivo'] != 'N/A')
                    || ($value['casco'] != '' && $value['casco'] != 'N/A')
                    || ($value['guantes_de_cuero'] != '' && $value['guantes_de_cuero'] != 'N/A')
                    || ($value['capa_impermeable'] != '' && $value['capa_impermeable'] != 'N/A')
                    || ($value['aspecto_personal'] != '' && $value['aspecto_personal'] != 'N/A')
                    || ($value['logotipo_de_empresa'] != '' && $value['logotipo_de_empresa'] != 'N/A')
                    || ($value['carroceria'] != '' && $value['carroceria'] != 'N/A')
                    || ($value['porta_escalera'] != '' && $value['porta_escalera'] != 'N/A')
                    || ($value['estado_de_neumaticos'] != '' && $value['estado_de_neumaticos'] != 'N/A')
                    || ($value['rotulado_de_unidad'] != '' && $value['rotulado_de_unidad'] != 'N/A')
                    || ($value['orden_y_limpieza'] != '' && $value['orden_y_limpieza'] != 'N/A')
                    || ($value['tecnico_certificado'] != 'N/A' && $value['tecnico_certificado'] != '')
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
                        || ($value['botas_industriales'] != '' && $value['botas_industriales'] != 'N/A')
                        || ($value['gafete'] != '' && $value['gafete'] != 'N/A')
                        || ($value['faja_cincho'] != '' && $value['faja_cincho'] != 'N/A')
                        || ($value['cinturon_de_seguridad_para_amarre_a_poste'] != '' && $value['cinturon_de_seguridad_para_amarre_a_poste'] != 'N/A')
                        || ($value['chaleco_preventivo'] != '' && $value['chaleco_preventivo'] != 'N/A')
                        || ($value['casco'] != '' && $value['casco'] != 'N/A')
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
                                                <td class="w-40">Botas Industriales</td>
                                                <td class="w-20 text-center">15</td>
                                                <td class="w-20 text-center">'.mostrarRespuesta($value['botas_industriales']).'</td>
                                                <td class="w-20 text-center">'.mostrarPunteo(($value['botas_industriales']),15).'</td>
                                            </tr>
                                            <tr>
                                                <td class="w-40">Gafete</td>
                                                <td class="w-20 text-center">15</td>
                                                <td class="w-20 text-center">'.mostrarRespuesta($value['gafete']).'</td>
                                                <td class="w-20 text-center">'.mostrarPunteo(($value['gafete']),15).'</td>
                                            </tr>
                                            <tr>
                                                <td class="w-40">Faja (Cincho)</td>
                                                <td class="w-20 text-center">5</td>
                                                <td class="w-20 text-center">'.mostrarRespuesta($value['faja_cincho']).'</td>
                                                <td class="w-20 text-center">'.mostrarPunteo(($value['faja_cincho']),5).'</td>
                                            </tr>

                                            <tr>
                                            <td class="w-40">Cinturón de seguridad para amarre a poste</td>
                                                <td class="w-20 text-center">10</td>
                                                <td class="w-20 text-center">'.mostrarRespuesta($value['cinturon_de_seguridad_para_amarre_a_poste']).'</td>
                                                <td class="w-20 text-center">'.mostrarPunteo(($value['cinturon_de_seguridad_para_amarre_a_poste']),10).'</td>
                                            </tr>
                                            <tr>
                                                <td class="w-40">Chaleco preventivo</td>
                                                <td class="w-20 text-center">5</td>
                                                <td class="w-20 text-center">'.mostrarRespuesta($value['chaleco_preventivo']).'</td>
                                                <td class="w-20 text-center">'.mostrarPunteo(($value['chaleco_preventivo']),5).'</td>
                                            </tr>
                                            <tr>
                                                <td class="w-40">Casco</td>
                                                <td class="w-20 text-center">10</td>
                                                <td class="w-20 text-center">'.mostrarRespuesta($value['casco']).'</td>
                                                <td class="w-20 text-center">'.mostrarPunteo(($value['casco']),10).'</td>
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
                        + mostrarPunteo(($value['botas_industriales']),15)
                        + mostrarPunteo(($value['gafete']),15)
                        + mostrarPunteo(($value['faja_cincho']),5)
                        + mostrarPunteo(($value['cinturon_de_seguridad_para_amarre_a_poste']),10)
                        + mostrarPunteo(($value['chaleco_preventivo']),5)
                        + mostrarPunteo(($value['casco']),10)
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
                            <div class="row">
                                    <div class="cell" colspan="6"><br></div>
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

                    if( $value['tecnico_certificado'] != 'N/A' && $value['tecnico_certificado'] != '' ){

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
                                                    <td class="w-30 text-center">'.mostrarRespuesta($value['tecnico_certificado']).'</td>
                                                    <td class="w-30 text-center">'.mostrarPunteo(($value['tecnico_certificado']),100).'</td>
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


                }

                if(
                    ($value['medidor_de_potencia_optica'] != '' && $value['medidor_de_potencia_optica'] != 'N/A')
                    || ($value['microscopio_optico'] != '' && $value['microscopio_optico'] != 'N/A')
                    || ($value['etiquetadora'] != '' && $value['etiquetadora'] != 'N/A')
                    || ($value['tijera_para_cortar_kevlar'] != '' && $value['tijera_para_cortar_kevlar'] != 'N/A')
                    || ($value['barreno_con_roto_martillo'] != '' && $value['barreno_con_roto_martillo'] != 'N/A')
                    || ($value['cortadora_fo_angulo_recto'] != '' && $value['cortadora_fo_angulo_recto'] != 'N/A')
                    || ($value['peladora_de_fo_3_en_1'] != '' && $value['peladora_de_fo_3_en_1'] != 'N/A')
                    || ($value['cortadora_de_buffer'] != '' && $value['cortadora_de_buffer'] != 'N/A')
                    || ($value['kit_de_limpieza_para_fibra_optica'] != '' && $value['kit_de_limpieza_para_fibra_optica'] != 'N/A')
                    || ($value['escalera_de_fibra_de_vidrio_20'] != '' && $value['escalera_de_fibra_de_vidrio_20'] != 'N/A')
                    || ($value['juego_de_destornilladores_de_castigadera_y_phillips'] != '' && $value['juego_de_destornilladores_de_castigadera_y_phillips'] != 'N/A')
                    || ($value['juego_de_brocas_para_concreto_y_metal_diferentes_medidas_incluir_broca_pasa_muro'] != '' && $value['juego_de_brocas_para_concreto_y_metal_diferentes_medidas_incluir_broca_pasa_muro'] != 'N/A')
                    || ($value['extension_electrica_calibre_12'] != '' && $value['extension_electrica_calibre_12'] != 'N/A')
                    || ($value['guia_acerada_125_con_dispensador'] != '' && $value['guia_acerada_125_con_dispensador'] != 'N/A')
                    || ($value['guia_pasa_cables_de_fibra_de_vidrio'] != '' && $value['guia_pasa_cables_de_fibra_de_vidrio'] != 'N/A')
                    || ($value['gancho_para_levantar_tapaderas_pozo_resultado'] != '' && $value['gancho_para_levantar_tapaderas_pozo_resultado'] != 'N/A')
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
                                                    <td colspan="4" class="w-80 text-center">HFC</td>
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
                                                    <td class="w-40">Medidor de Potencia Optica</td>
                                                    <td class="w-20 text-center">10</td>
                                                    <td class="w-20 text-center">'.mostrarRespuesta($value['medidor_de_potencia_optica']).'</td>
                                                    <td class="w-20 text-center">'.mostrarPunteo(($value['medidor_de_potencia_optica']), 10).'</td>
                                                </tr>
                                                <tr>
                                                    <td class="w-40">Microscopio Optico</td>
                                                    <td class="w-20 text-center">10</td>
                                                    <td class="w-20 text-center">'.mostrarRespuesta($value['microscopio_optico']).'</td>
                                                    <td class="w-20 text-center">'.mostrarPunteo(($value['microscopio_optico']), 10).'</td>
                                                </tr>
                                                <tr>
                                                    <td class="w-40">Etiquetadora</td>
                                                    <td class="w-20 text-center">10</td>
                                                    <td class="w-20 text-center">'.mostrarRespuesta($value['etiquetadora']).'</td>
                                                    <td class="w-20 text-center">'.mostrarPunteo(($value['etiquetadora']), 10).'</td>
                                                </tr>
                                                <tr>
                                                    <td class="w-40">Tijera Para Cortar Kevlar</td>
                                                    <td class="w-20 text-center">10</td>
                                                    <td class="w-20 text-center">'.mostrarRespuesta($value['tijera_para_cortar_kevlar']).'</td>
                                                    <td class="w-20 text-center">'.mostrarPunteo(($value['tijera_para_cortar_kevlar']), 10).'</td>
                                                </tr>
                                                <tr>
                                                    <td class="w-40">Barreno Con Roto Martillo</td>
                                                    <td class="w-20 text-center">10</td>
                                                    <td class="w-20 text-center">'.mostrarRespuesta($value['barreno_con_roto_martillo']).'</td>
                                                    <td class="w-20 text-center">'.mostrarPunteo(($value['barreno_con_roto_martillo']), 10).'</td>
                                                </tr>
                                                <tr>
                                                    <td class="w-40">Cortadora FO Angulo Recto</td>
                                                    <td class="w-20 text-center">8</td>
                                                    <td class="w-20 text-center">'.mostrarRespuesta($value['cortadora_fo_angulo_recto']).'</td>
                                                    <td class="w-20 text-center">'.mostrarPunteo(($value['cortadora_fo_angulo_recto']), 8).'</td>
                                                </tr>
                                                <tr>
                                                    <td class="w-40">Peladora de F.O 3 En 1</td>
                                                    <td class="w-20 text-center">7</td>
                                                    <td class="w-20 text-center">'.mostrarRespuesta($value['peladora_de_fo_3_en_1']).'</td>
                                                    <td class="w-20 text-center">'.mostrarPunteo(($value['peladora_de_fo_3_en_1']), 7).'</td>
                                                </tr>
                                                <tr>
                                                    <td class="w-40">Cortadora de Buffer</td>
                                                    <td class="w-20 text-center">7</td>
                                                    <td class="w-20 text-center">'.mostrarRespuesta($value['cortadora_de_buffer']).'</td>
                                                    <td class="w-20 text-center">'.mostrarPunteo(($value['cortadora_de_buffer']), 7).'</td>
                                                </tr>
                                                <tr>
                                                    <td class="w-40">Kit de Limpieza Para Fibra Óptica</td>
                                                    <td class="w-20 text-center">7</td>
                                                    <td class="w-20 text-center">'.mostrarRespuesta($value['kit_de_limpieza_para_fibra_optica']).'</td>
                                                    <td class="w-20 text-center">'.mostrarPunteo(($value['kit_de_limpieza_para_fibra_optica']), 7).'</td>
                                                </tr>
                                                <tr>
                                                    <td class="w-40">Escalera de Fibra de Vidrio 20´</td>
                                                    <td class="w-20 text-center">3</td>
                                                    <td class="w-20 text-center">'.mostrarRespuesta($value['escalera_de_fibra_de_vidrio_20']).'</td>
                                                    <td class="w-20 text-center">'.mostrarPunteo(($value['escalera_de_fibra_de_vidrio_20']), 3).'</td>
                                                </tr>
                                                <tr>
                                                    <td class="w-40">Juego de destornilladores de Castigadera y Phillips</td>
                                                    <td class="w-20 text-center">3</td>
                                                    <td class="w-20 text-center">'.mostrarRespuesta($value['juego_de_destornilladores_de_castigadera_y_phillips']).'</td>
                                                    <td class="w-20 text-center">'.mostrarPunteo(($value['juego_de_destornilladores_de_castigadera_y_phillips']), 3).'</td>
                                                </tr>
                                                <tr>
                                                    <td class="w-40">Juego de Brocas Para Concreto Y Metal Diferentes Medidas (Incluir Broca Pasa Muro)</td>
                                                    <td class="w-20 text-center">3</td>
                                                    <td class="w-20 text-center">'.mostrarRespuesta($value['juego_de_brocas_para_concreto_y_metal_diferentes_medidas_incluir_broca_pasa_muro']).'</td>
                                                    <td class="w-20 text-center">'.mostrarPunteo(($value['juego_de_brocas_para_concreto_y_metal_diferentes_medidas_incluir_broca_pasa_muro']), 3).'</td>
                                                </tr>
                                                <tr>
                                                    <td class="w-40">Extension Electrica Calibre 12</td>
                                                    <td class="w-20 text-center">3</td>
                                                    <td class="w-20 text-center">'.mostrarRespuesta($value['extension_electrica_calibre_12']).'</td>
                                                    <td class="w-20 text-center">'.mostrarPunteo(($value['extension_electrica_calibre_12']), 3).'</td>
                                                </tr>
                                                <tr>
                                                    <td class="w-40">Guía Acerada 125´ Con Dispensador</td>
                                                    <td class="w-20 text-center">3</td>
                                                    <td class="w-20 text-center">'.mostrarRespuesta($value['guia_acerada_125_con_dispensador']).'</td>
                                                    <td class="w-20 text-center">'.mostrarPunteo(($value['guia_acerada_125_con_dispensador']), 3).'</td>
                                                </tr>
                                                <tr>
                                                    <td class="w-40">Guía Pasa Cables de Fibra de Vidrio</td>
                                                    <td class="w-20 text-center">3</td>
                                                    <td class="w-20 text-center">'.mostrarRespuesta($value['guia_pasa_cables_de_fibra_de_vidrio']).'</td>
                                                    <td class="w-20 text-center">'.mostrarPunteo(($value['guia_pasa_cables_de_fibra_de_vidrio']), 3).'</td>
                                                </tr>
                                                <tr>
                                                    <td class="w-40">Gancho Para Levantar Tapaderas Pozo - Resultado</td>
                                                    <td class="w-20 text-center">3</td>
                                                    <td class="w-20 text-center">'.mostrarRespuesta($value['gancho_para_levantar_tapaderas_pozo_resultado']).'</td>
                                                    <td class="w-20 text-center">'.mostrarPunteo(($value['gancho_para_levantar_tapaderas_pozo_resultado']), 3).'</td>
                                                </tr>
                        ';
            
                        $total = 0 
                        + mostrarPunteo(($value['medidor_de_potencia_optica']), 10)
                        + mostrarPunteo(($value['microscopio_optico']), 10)
                        + mostrarPunteo(($value['etiquetadora']), 10)
                        + mostrarPunteo(($value['tijera_para_cortar_kevlar']), 10)
                        + mostrarPunteo(($value['barreno_con_roto_martillo']), 10)
                        + mostrarPunteo(($value['cortadora_fo_angulo_recto']), 8)
                        + mostrarPunteo(($value['peladora_de_fo_3_en_1']), 7)
                        + mostrarPunteo(($value['cortadora_de_buffer']), 7)
                        + mostrarPunteo(($value['kit_de_limpieza_para_fibra_optica']), 7)
                        + mostrarPunteo(($value['escalera_de_fibra_de_vidrio_20']), 3)
                        + mostrarPunteo(($value['juego_de_destornilladores_de_castigadera_y_phillips']), 3)
                        + mostrarPunteo(($value['juego_de_brocas_para_concreto_y_metal_diferentes_medidas_incluir_broca_pasa_muro']), 3)
                        + mostrarPunteo(($value['extension_electrica_calibre_12']), 3)
                        + mostrarPunteo(($value['guia_acerada_125_con_dispensador']), 3)
                        + mostrarPunteo(($value['guia_pasa_cables_de_fibra_de_vidrio']), 3)
                        + mostrarPunteo(($value['gancho_para_levantar_tapaderas_pozo_resultado']), 3);
                                                
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
