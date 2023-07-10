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
            "K" => "ubicacion_del_tap_rg_500_mas_cerca_del_cliente_por_distancia",
            "L" => "identificacion_de_la_red",
            "M" => "cable_pasa_por_chapa",
            "N" => "utilizo_cincho_id_e_identifico",
            "O" => "curvatura_de_reserva_adecuada",
            "P" => "protectores_de_humedad",
            "Q" => "torqueado_en_norma",
            "R" => "utilizo_filtro_pasa_alto_ventana",
            "S" => "correcta_elaboracion_de_conector",
            "T" => "uso_de_abrazaderas_de_remate_aplica_red_aerea",
            "U" => "instalacion_de_cable_correcto_con_mensajero_sin_mensajero",
            "V" => "uso_de_conector_nuevo_normado_por_claro",
            "W" => "utilizo_remates_y_clip_tipo_s",
            "X" => "ausencia_de_rozamiento_con_otros_elementos",
            "Y" => "tensado_de_cables_y_uso_de_postes",
            "Z" => "acometida_sin_empalmes",
            "AA" => "cliente_permite_acceso",
            "AB" => "se_cambio_el_cableado",
            "AC" => "se_utilizo_el_cable_correcto",
            "AD" => "estetica_en_la_instalacion_del_cableado",
            "AE" => "se_instalaron_protectores_contra_picos_hr_y_cpe",
            "AF" => "torqueado_de_accesorios_de_distribucion",
            "AG" => "uso_adecuado_de_grapas",
            "AH" => "uso_correcto_de_divisores_de_senal_aplica_para_mas_de_un_tv",
            "AI" => "correcta_aplicacion_de_conectores",
            "AJ" => "conexion_adecuada_del_stb",
            "AK" => "segun_os_se_cumplio_con_la_cantidad_de_televisores_instalados",
            "AL" => "segun_la_orden_de_servicio_se_dejaron_los_equipos_solicitados_repetidor_wifi_dvr",
            "AM" => "conexion_y_configuracion_adecuada_de_cable_modem",
            "AN" => "el_cable_modem_tiene_niveles_correctos",
            "AO" => "evidencia_fotografica",
            "AP" => "segundo_archivo",
            "AQ" => "peladora_rg_6",
            "AR" => "ponchadora_rg_6",
            "AS" => "equipo_de_medicion",
            "AT" => "desarmadores_destornilladores",
            "AU" => "escalera",
            "AV" => "lazo_para_asegurar_escalera_a_poste",
            "AW" => "taladro_tipo_industrial_de_1_2",
            "AX" => "extension_electrica_de_15_metros",
            "AY" => "guia_de_acero_de_30_metros",
            "AZ" => "broca_pasa_muros_12_pulgadas_1_2_o_3_8",
            "BA" => "llave_quita_trampas",
            "BB" => "herramienta_torquimetro",
            "BC" => "navaja_curva",
            "BD" => "corta_alambre_de_8",
            "BE" => "cadena_con_candados_asegurar_escalera_a_vehiculo",
            "BF" => "inversor_de_voltaje_de_1600_watts",
            "BG" => "camisa",
            "BH" => "pantalon",
            "BI" => "botas",
            "BJ" => "gafete",
            "BK" => "faja_cincho",
            "BL" => "chaleco_preventivo",
            "BM" => "casco_de_proteccion",
            "BN" => "guantes_de_cuero",
            "BO" => "capa_impermeable",
            "BP" => "aspecto_personal",
            "BQ" => "logotipo_de_empresa",
            "BR" => "carroceria",
            "BS" => "porta_escalera",
            "BT" => "estado_de_neumaticos",
            "BU" => "rotulado_de_unidad",
            "BV" => "orden_y_limpieza",
            "BW" => "tecnico_certificado_por_claro",
            "BX" => "direccion_de_correo_electronico",
            "BY" => "evidencia_fotografica",
            "BZ" => "segundo_archivo",
            "CA" => "tercer_archivo",
            "CB" => "cuarto_archivo",
            "CC" => "calidad_tecnica",
            "CD" => "herramienta",
            "CE" => "uniforme",
            "CF" => "vehiculo",
            "CG" => "tecnico_certificado",
            "CH" => "no_supervision",
            "CI" => "tecnologia",
            "CJ" => "supervisor",
            "CK" => "observaciones"
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
                    <title>Auditoria HFC</title>
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
                                            <td class="w-20 text-center" rowspan="9">TAP</td>
                                            <td class="w-10 text-center" rowspan="9">25</td>
                                            <td class="w-40">Ubicación del Tap RG-500 más cerca del cliente por distancia</td>
                                            <td class="w-10 text-center">4</td>
                                            <td class="w-10 text-center">'.mostrarRespuesta($value['ubicacion_del_tap_rg_500_mas_cerca_del_cliente_por_distancia']).'</td>
                                            <td class="w-10 text-center">'.mostrarPunteo(($value['ubicacion_del_tap_rg_500_mas_cerca_del_cliente_por_distancia']),4).'</td>
                                        </tr>
                                        <tr>
                                            <td class="w-40">Identificación de la red</td>
                                            <td class="w-10 text-center">4</td>
                                            <td class="w-10 text-center">'.mostrarRespuesta($value['identificacion_de_la_red']).'</td>
                                            <td class="w-10 text-center">'.mostrarPunteo(($value['identificacion_de_la_red']),4).'</td>
                                        </tr>
                                        <tr>
                                            <td class="w-40">Cable pasa por chapa</td>
                                            <td class="w-10 text-center">2</td>
                                            <td class="w-10 text-center">'.mostrarRespuesta($value['cable_pasa_por_chapa']).'</td>
                                            <td class="w-10 text-center">'.mostrarPunteo(($value['cable_pasa_por_chapa']),2).'</td>
                                        </tr>
                                        <tr>
                                            <td class="w-40">Utilizo cincho ID e identifico</td>
                                            <td class="w-10 text-center">2</td>
                                            <td class="w-10 text-center">'.mostrarRespuesta($value['utilizo_cincho_id_e_identifico']).'</td>
                                            <td class="w-10 text-center">'.mostrarPunteo(($value['utilizo_cincho_id_e_identifico']),2).'</td>
                                        </tr>
                                        <tr>
                                            <td class="w-40">Curvatura de reserva adecuada</td>
                                            <td class="w-10 text-center">4</td>
                                            <td class="w-10 text-center">'.mostrarRespuesta($value['curvatura_de_reserva_adecuada']).'</td>
                                            <td class="w-10 text-center">'.mostrarPunteo(($value['curvatura_de_reserva_adecuada']),4).'</td>
                                        </tr>
                                        <tr>
                                            <td class="w-40">Protectores de humedad</td>
                                            <td class="w-10 text-center">2</td>
                                            <td class="w-10 text-center">'.mostrarRespuesta($value['protectores_de_humedad']).'</td>
                                            <td class="w-10 text-center">'.mostrarPunteo(($value['protectores_de_humedad']),2).'</td>
                                        </tr>
                                        <tr>
                                            <td class="w-40">Torqueado en norma</td>
                                            <td class="w-10 text-center">3</td>
                                            <td class="w-10 text-center">'.mostrarRespuesta($value['torqueado_en_norma']).'</td>
                                            <td class="w-10 text-center">'.mostrarPunteo(($value['torqueado_en_norma']),3).'</td>
                                        </tr>
                                        <tr>
                                            <td class="w-40">Utilizo filtro pasa alto / ventana</td>
                                            <td class="w-10 text-center">2</td>
                                            <td class="w-10 text-center">'.mostrarRespuesta($value['utilizo_filtro_pasa_alto_ventana']).'</td>
                                            <td class="w-10 text-center">'.mostrarPunteo(($value['utilizo_filtro_pasa_alto_ventana']),2).'</td>
                                        </tr>
                                        <tr>
                                            <td class="w-40">Correcta elaboración de conector</td>
                                            <td class="w-10 text-center">2</td>
                                            <td class="w-10 text-center">'.mostrarRespuesta($value['correcta_elaboracion_de_conector']).'</td>
                                            <td class="w-10 text-center">'.mostrarPunteo(($value['correcta_elaboracion_de_conector']),2).'</td>
                                        </tr>
                                        <tr>
                                            <td class="w-20 text-center" rowspan="7">ACOMENTIDA EXTERNA</td>
                                            <td class="w-10 text-center" rowspan="7">25</td>
                                            <td class="w-40">Uso de abrazaderas  de remate (aplica red aérea)*</td>
                                            <td class="w-10 text-center">4</td>
                                            <td class="w-10 text-center">'.mostrarRespuesta($value['uso_de_abrazaderas_de_remate_aplica_red_aerea']).'</td>
                                            <td class="w-10 text-center">'.mostrarPunteo(($value['uso_de_abrazaderas_de_remate_aplica_red_aerea']),4).'</td>
                                        </tr>
                                        <tr>
                                            <td class="w-40">Instalación de cable correcto (con mensajero/sin mensajero)</td>
                                            <td class="w-10 text-center">4</td>
                                            <td class="w-10 text-center">'.mostrarRespuesta($value['instalacion_de_cable_correcto_con_mensajero_sin_mensajero']).'</td>
                                            <td class="w-10 text-center">'.mostrarPunteo(($value['instalacion_de_cable_correcto_con_mensajero_sin_mensajero']),4).'</td>
                                        </tr>
                                        <tr>
                                            <td class="w-40">Uso de conector  "nuevo", normado por Claro</td>
                                            <td class="w-10 text-center">4</td>
                                            <td class="w-10 text-center">'.mostrarRespuesta($value['uso_de_conector_nuevo_normado_por_claro']).'</td>
                                            <td class="w-10 text-center">'.mostrarPunteo(($value['uso_de_conector_nuevo_normado_por_claro']),4).'</td>
                                        </tr>
                                        <tr>
                                            <td class="w-40">Utilizo remates y clip tipo S</td>
                                            <td class="w-10 text-center">3</td>
                                            <td class="w-10 text-center">'.mostrarRespuesta($value['utilizo_remates_y_clip_tipo_s']).'</td>
                                            <td class="w-10 text-center">'.mostrarPunteo(($value['utilizo_remates_y_clip_tipo_s']),3).'</td>
                                        </tr>
                                        <tr>
                                            <td class="w-40">Ausencia de rozamiento con otros  elementos </td>
                                            <td class="w-10 text-center">3</td>
                                            <td class="w-10 text-center">'.mostrarRespuesta($value['ausencia_de_rozamiento_con_otros_elementos']).'</td>
                                            <td class="w-10 text-center">'.mostrarPunteo(($value['ausencia_de_rozamiento_con_otros_elementos']),3).'</td>
                                        </tr>
                                        <tr>
                                            <td class="w-40">Tensado de cables y uso de postes</td>
                                            <td class="w-10 text-center">3</td>
                                            <td class="w-10 text-center">'.mostrarRespuesta($value['tensado_de_cables_y_uso_de_postes']).'</td>
                                            <td class="w-10 text-center">'.mostrarPunteo(($value['tensado_de_cables_y_uso_de_postes']),3).'</td>
                                        </tr>
                                        <tr>
                                            <td class="w-40">Acomentida sin empalmes</td>
                                            <td class="w-10 text-center">4</td>
                                            <td class="w-10 text-center">'.mostrarRespuesta($value['acometida_sin_empalmes']).'</td>
                                            <td class="w-10 text-center">'.mostrarPunteo(($value['acometida_sin_empalmes']),4).'</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>          
                    </div>
                    <div class="container">
                        <div class="cell-table" colspan="6">
                            <table>
                            <tbody>
                            <tr class="bg-secondary">
                                <td></td>
                                <td colspan="4" class="w-80 text-center">CLIENTE PERMITE ACCESO</td>
                                <td class="text-center">'.mostrarRespuesta($value['cliente_permite_acceso']).'</td>
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
                                        <td class="w-20 text-center" rowspan="13">ACOMETIDA INTERNA</td>
                                        <td class="w-10 text-center" rowspan="13">30</td>
                                        <td class="w-40">Se cambio el cableado</td>
                                        <td class="w-10 text-center">5</td>
                                        <td class="w-10 text-center">'.mostrarRespuesta($value['se_cambio_el_cableado']).'</td>
                                        <td class="w-10 text-center">'.mostrarPunteo(($value['se_cambio_el_cableado']),5).'</td>
                                    </tr>
                                    <tr>
                                        <td class="w-40">Se utilizo el cable correcto</td>
                                        <td class="w-10 text-center">3</td>
                                        <td class="w-10 text-center">'.mostrarRespuesta($value['se_utilizo_el_cable_correcto']).'</td>
                                        <td class="w-10 text-center">'.mostrarPunteo(($value['se_utilizo_el_cable_correcto']),3).'</td>
                                    </tr>
                                    <tr>
                                        <td class="w-40">Estetica en la instalación del cableado</td>
                                        <td class="w-10 text-center">1</td>
                                        <td class="w-10 text-center">'.mostrarRespuesta($value['estetica_en_la_instalacion_del_cableado']).'</td>
                                        <td class="w-10 text-center">'.mostrarPunteo(($value['estetica_en_la_instalacion_del_cableado']),1).'</td>
                                    </tr>
                                    <tr>
                                        <td class="w-40">Se instalaron protectores contra picos (HR y CPE)</td>
                                        <td class="w-10 text-center">1</td>
                                        <td class="w-10 text-center">'.mostrarRespuesta($value['se_instalaron_protectores_contra_picos_hr_y_cpe']).'</td>
                                        <td class="w-10 text-center">'.mostrarPunteo(($value['se_instalaron_protectores_contra_picos_hr_y_cpe']),1).'</td>
                                    </tr>
                                    <tr>
                                        <td class="w-40">Torqueado de accesorios de distribucion</td>
                                        <td class="w-10 text-center">1</td>
                                        <td class="w-10 text-center">'.mostrarRespuesta($value['torqueado_de_accesorios_de_distribucion']).'</td>
                                        <td class="w-10 text-center">'.mostrarPunteo(($value['torqueado_de_accesorios_de_distribucion']),1).'</td>
                                    </tr>
                                    <tr>
                                        <td class="w-40">Uso adecuado de grapas</td>
                                        <td class="w-10 text-center">1</td>
                                        <td class="w-10 text-center">'.mostrarRespuesta($value['uso_adecuado_de_grapas']).'</td>
                                        <td class="w-10 text-center">'.mostrarPunteo(($value['uso_adecuado_de_grapas']),1).'</td>
                                    </tr>
                                    <tr>
                                        <td class="w-40">Uso correcto de divisores de señal, aplica para más de un TV*</td>
                                        <td class="w-10 text-center">1</td>
                                        <td class="w-10 text-center">'.mostrarRespuesta($value['uso_correcto_de_divisores_de_senal_aplica_para_mas_de_un_tv']).'</td>
                                        <td class="w-10 text-center">'.mostrarPunteo(($value['uso_correcto_de_divisores_de_senal_aplica_para_mas_de_un_tv']),1).'</td>
                                    </tr>
                                    <tr>
                                        <td class="w-40">Correcta aplicacion de conectores</td>
                                        <td class="w-10 text-center">1</td>
                                        <td class="w-10 text-center">'.mostrarRespuesta($value['correcta_aplicacion_de_conectores']).'</td>
                                        <td class="w-10 text-center">'.mostrarPunteo(($value['correcta_aplicacion_de_conectores']),1).'</td>
                                    </tr>
                                    <tr>
                                        <td class="w-40">Conexión adecuada del STB</td>
                                        <td class="w-10 text-center">5</td>
                                        <td class="w-10 text-center">'.mostrarRespuesta($value['conexion_adecuada_del_stb']).'</td>
                                        <td class="w-10 text-center">'.mostrarPunteo(($value['conexion_adecuada_del_stb']),5).'</td>
                                    </tr>
                                    <tr>
                                        <td class="w-40">Según OS se cumplio con la cantidad de televisores instalados</td>
                                        <td class="w-10 text-center">3</td>
                                        <td class="w-10 text-center">'.mostrarRespuesta($value['segun_os_se_cumplio_con_la_cantidad_de_televisores_instalados']).'</td>
                                        <td class="w-10 text-center">'.mostrarPunteo(($value['segun_os_se_cumplio_con_la_cantidad_de_televisores_instalados']),3).'</td>
                                    </tr>
                                    <tr>
                                        <td class="w-40">Según la orden de servicio se dejaron los equipos solicitados (repetidor wifi, DVR)</td>
                                        <td class="w-10 text-center">2</td>
                                        <td class="w-10 text-center">'.mostrarRespuesta($value['segun_la_orden_de_servicio_se_dejaron_los_equipos_solicitados_repetidor_wifi_dvr']).'</td>
                                        <td class="w-10 text-center">'.mostrarPunteo(($value['segun_la_orden_de_servicio_se_dejaron_los_equipos_solicitados_repetidor_wifi_dvr']),2).'</td>
                                    </tr>
                                    <tr>
                                        <td class="w-40">Conexión y configuración adecuada de cable modem *</td>
                                        <td class="w-10 text-center">3</td>
                                        <td class="w-10 text-center">'.mostrarRespuesta($value['conexion_y_configuracion_adecuada_de_cable_modem']).'</td>
                                        <td class="w-10 text-center">'.mostrarPunteo(($value['conexion_y_configuracion_adecuada_de_cable_modem']),3).'</td>
                                    </tr>
                                    <tr>
                                        <td class="w-40">El cable modem tiene niveles correctos</td>
                                        <td class="w-10 text-center">3</td>
                                        <td class="w-10 text-center">'.mostrarRespuesta($value['el_cable_modem_tiene_niveles_correctos']).'</td>
                                        <td class="w-10 text-center">'.mostrarPunteo(($value['el_cable_modem_tiene_niveles_correctos']),3).'</td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>
                        <div class="row">
                            <div class="cell" colspan="6"><br></div>
                        </div>

                ';

                $total = 0
                + mostrarPunteo(($value['ubicacion_del_tap_rg_500_mas_cerca_del_cliente_por_distancia']),4)
                + mostrarPunteo(($value['identificacion_de_la_red']),4)
                + mostrarPunteo(($value['cable_pasa_por_chapa']),2)
                + mostrarPunteo(($value['utilizo_cincho_id_e_identifico']),2)
                + mostrarPunteo(($value['curvatura_de_reserva_adecuada']),4)
                + mostrarPunteo(($value['protectores_de_humedad']),2)
                + mostrarPunteo(($value['torqueado_en_norma']),3)
                + mostrarPunteo(($value['utilizo_filtro_pasa_alto_ventana']),2)
                + mostrarPunteo(($value['correcta_elaboracion_de_conector']),2)
                + mostrarPunteo(($value['uso_de_abrazaderas_de_remate_aplica_red_aerea']),4)
                + mostrarPunteo(($value['instalacion_de_cable_correcto_con_mensajero_sin_mensajero']),4)
                + mostrarPunteo(($value['uso_de_conector_nuevo_normado_por_claro']),4) 
                + mostrarPunteo(($value['utilizo_remates_y_clip_tipo_s']),3)
                + mostrarPunteo(($value['ausencia_de_rozamiento_con_otros_elementos']),3)
                + mostrarPunteo(($value['tensado_de_cables_y_uso_de_postes']),3)
                + mostrarPunteo(($value['acometida_sin_empalmes']),4)
                + mostrarPunteo(($value['se_cambio_el_cableado']),5)
                + mostrarPunteo(($value['se_utilizo_el_cable_correcto']),3)
                + mostrarPunteo(($value['estetica_en_la_instalacion_del_cableado']),1)
                + mostrarPunteo(($value['se_instalaron_protectores_contra_picos_hr_y_cpe']),1)
                + mostrarPunteo(($value['torqueado_de_accesorios_de_distribucion']),1)
                + mostrarPunteo(($value['uso_adecuado_de_grapas']),1)
                + mostrarPunteo(($value['uso_correcto_de_divisores_de_senal_aplica_para_mas_de_un_tv']),1)
                + mostrarPunteo(($value['correcta_aplicacion_de_conectores']),1)
                + mostrarPunteo(($value['conexion_adecuada_del_stb']),5)
                + mostrarPunteo(($value['segun_os_se_cumplio_con_la_cantidad_de_televisores_instalados']),3)
                + mostrarPunteo(($value['segun_la_orden_de_servicio_se_dejaron_los_equipos_solicitados_repetidor_wifi_dvr']),2)
                + mostrarPunteo(($value['conexion_y_configuracion_adecuada_de_cable_modem']),3)
                + mostrarPunteo(($value['el_cable_modem_tiene_niveles_correctos']),3);

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
                    ($value['peladora_rg_6'] != '' && $value['peladora_rg_6'] != 'N/A')
                    || ($value['ponchadora_rg_6'] != '' && $value['ponchadora_rg_6'] != 'N/A')
                    || ($value['equipo_de_medicion'] != '' && $value['equipo_de_medicion'] != 'N/A')
                    || ($value['desarmadores_destornilladores'] != '' && $value['desarmadores_destornilladores'] != 'N/A')
                    || ($value['escalera'] != '' && $value['escalera'] != 'N/A')
                    || ($value['lazo_para_asegurar_escalera_a_poste'] != '' && $value['lazo_para_asegurar_escalera_a_poste'] != 'N/A')
                    || ($value['taladro_tipo_industrial_de_1_2'] != '' && $value['taladro_tipo_industrial_de_1_2'] != 'N/A')
                    || ($value['extension_electrica_de_15_metros'] != '' && $value['extension_electrica_de_15_metros'] != 'N/A')
                    || ($value['guia_de_acero_de_30_metros'] != '' && $value['guia_de_acero_de_30_metros'] != 'N/A')
                    || ($value['broca_pasa_muros_12_pulgadas_1_2_o_3_8'] != '' && $value['broca_pasa_muros_12_pulgadas_1_2_o_3_8'] != 'N/A')
                    || ($value['llave_quita_trampas'] != '' && $value['llave_quita_trampas'] != 'N/A')
                    || ($value['herramienta_torquimetro'] != '' && $value['herramienta_torquimetro'] != 'N/A')
                    || ($value['navaja_curva'] != '' && $value['navaja_curva'] != 'N/A')
                    || ($value['corta_alambre_de_8'] != '' && $value['corta_alambre_de_8'] != 'N/A')
                    || ($value['cadena_con_candados_asegurar_escalera_a_vehiculo'] != '' && $value['cadena_con_candados_asegurar_escalera_a_vehiculo'] != 'N/A')
                    || ($value['inversor_de_voltaje_de_1600_watts'] != '' && $value['inversor_de_voltaje_de_1600_watts'] != 'N/A')
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
                                                    <td class="w-40">Peladora RG-6</td>
                                                    <td class="w-20 text-center">10</td>
                                                    <td class="w-20 text-center">'.mostrarRespuesta($value['peladora_rg_6']).'</td>
                                                    <td class="w-20 text-center">'.mostrarPunteo(($value['peladora_rg_6']), 10).'</td>
                                                </tr>
                                                <tr>
                                                    <td class="w-40">Ponchadora RG-6</td>
                                                    <td class="w-20 text-center">10</td>
                                                    <td class="w-20 text-center">'.mostrarRespuesta($value['ponchadora_rg_6']).'</td>
                                                    <td class="w-20 text-center">'.mostrarPunteo(($value['ponchadora_rg_6']), 10).'</td>
                                                </tr>
                                                <tr>
                                                    <td class="w-40">Equipo de medición</td>
                                                    <td class="w-20 text-center">30</td>
                                                    <td class="w-20 text-center">'.mostrarRespuesta($value['equipo_de_medicion']).'</td>
                                                    <td class="w-20 text-center">'.mostrarPunteo(($value['equipo_de_medicion']), 30).'</td>
                                                </tr>
                                                <tr>
                                                    <td class="w-40">Desarmadores … DESATORNILLADORES</td>
                                                    <td class="w-20 text-center">3</td>
                                                    <td class="w-20 text-center">'.mostrarRespuesta($value['desarmadores_destornilladores']).'</td>
                                                    <td class="w-20 text-center">'.mostrarPunteo(($value['desarmadores_destornilladores']), 3).'</td>
                                                </tr>
                                                <tr>
                                                    <td class="w-40">Escalera</td>
                                                    <td class="w-20 text-center">10</td>
                                                    <td class="w-20 text-center">'.mostrarRespuesta($value['escalera']).'</td>
                                                    <td class="w-20 text-center">'.mostrarPunteo(($value['escalera']), 10).'</td>
                                                </tr>
                                                <tr>
                                                    <td class="w-40">Lazo (para asegurar escalera a poste)</td>
                                                    <td class="w-20 text-center">5</td>
                                                    <td class="w-20 text-center">'.mostrarRespuesta($value['lazo_para_asegurar_escalera_a_poste']).'</td>
                                                    <td class="w-20 text-center">'.mostrarPunteo(($value['lazo_para_asegurar_escalera_a_poste']), 5).'</td>
                                                </tr>
                                                <tr>
                                                    <td class="w-40">Taladro tipo industrial de 1/2"</td>
                                                    <td class="w-20 text-center">5</td>
                                                    <td class="w-20 text-center">'.mostrarRespuesta($value['taladro_tipo_industrial_de_1_2']).'</td>
                                                    <td class="w-20 text-center">'.mostrarPunteo(($value['taladro_tipo_industrial_de_1_2']), 5).'</td>
                                                </tr>
                                                <tr>
                                                    <td class="w-40">Extensión eléctrica de 15 metros</td>
                                                    <td class="w-20 text-center">2</td>
                                                    <td class="w-20 text-center">'.mostrarRespuesta($value['extension_electrica_de_15_metros']).'</td>
                                                    <td class="w-20 text-center">'.mostrarPunteo(($value['extension_electrica_de_15_metros']), 2).'</td>
                                                </tr>
                                                <tr>
                                                    <td class="w-40">Guia de acero de 30 metros </td>
                                                    <td class="w-20 text-center">5</td>
                                                    <td class="w-20 text-center">'.mostrarRespuesta($value['guia_de_acero_de_30_metros']).'</td>
                                                    <td class="w-20 text-center">'.mostrarPunteo(($value['guia_de_acero_de_30_metros']), 5).'</td>
                                                </tr>
                                                <tr>
                                                    <td class="w-40">Broca pasa muros 12 pulgadas * 1/2 o 3/8</td>
                                                    <td class="w-20 text-center">5</td>
                                                    <td class="w-20 text-center">'.mostrarRespuesta($value['broca_pasa_muros_12_pulgadas_1_2_o_3_8']).'</td>
                                                    <td class="w-20 text-center">'.mostrarPunteo(($value['broca_pasa_muros_12_pulgadas_1_2_o_3_8']), 5).'</td>
                                                </tr>
                                                <tr>
                                                    <td class="w-40">Llave quita trampas</td>
                                                    <td class="w-20 text-center">2</td>
                                                    <td class="w-20 text-center">'.mostrarRespuesta($value['llave_quita_trampas']).'</td>
                                                    <td class="w-20 text-center">'.mostrarPunteo(($value['llave_quita_trampas']), 2).'</td>
                                                </tr>
                                                <tr>
                                                    <td class="w-40">Herramienta Torquimetro</td>
                                                    <td class="w-20 text-center">5</td>
                                                    <td class="w-20 text-center">'.mostrarRespuesta($value['herramienta_torquimetro']).'</td>
                                                    <td class="w-20 text-center">'.mostrarPunteo(($value['herramienta_torquimetro']), 5).'</td>
                                                </tr>
                                                <tr>
                                                    <td class="w-40">Navaja curva</td>
                                                    <td class="w-20 text-center">2</td>
                                                    <td class="w-20 text-center">'.mostrarRespuesta($value['navaja_curva']).'</td>
                                                    <td class="w-20 text-center">'.mostrarPunteo(($value['navaja_curva']), 2).'</td>
                                                </tr>
                                                <tr>
                                                    <td class="w-40">Corta alambre de 8"</td>
                                                    <td class="w-20 text-center">2</td>
                                                    <td class="w-20 text-center">'.mostrarRespuesta($value['corta_alambre_de_8']).'</td>
                                                    <td class="w-20 text-center">'.mostrarPunteo(($value['corta_alambre_de_8']), 2).'</td>
                                                </tr>
                                                <tr>
                                                    <td class="w-40">Cadena con conadados (aegurar escalera a vehículo)</td>
                                                    <td class="w-20 text-center">2</td>
                                                    <td class="w-20 text-center">'.mostrarRespuesta($value['cadena_con_candados_asegurar_escalera_a_vehiculo']).'</td>
                                                    <td class="w-20 text-center">'.mostrarPunteo(($value['cadena_con_candados_asegurar_escalera_a_vehiculo']), 2).'</td>
                                                </tr>
                                                <tr>
                                                    <td class="w-40">Inversor de voltage de 1,600 watts</td>
                                                    <td class="w-20 text-center">2</td>
                                                    <td class="w-20 text-center">'.mostrarRespuesta($value['inversor_de_voltaje_de_1600_watts']).'</td>
                                                    <td class="w-20 text-center">'.mostrarPunteo(($value['inversor_de_voltaje_de_1600_watts']), 2).'</td>
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
