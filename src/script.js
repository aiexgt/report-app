"use strict";

const tipo_reporte = $("#select_tipo_reporte");
const file_data = $("#file_data");

const btn_generar_reporte = $("#btn_generar_reporte");

const tipos = [
  {
    id: 1,
    nombre: "ADSL",
    ruta: "adsl-report",
  },
  {
    id: 2,
    nombre: "DTH REPA",
    ruta: "dth-repa-report",
  },
  {
    id: 3,
    nombre: "DTH",
    ruta: "dth-report",
  },
  {
    id: 3,
    nombre: "GPON",
    ruta: "gpon-report",
  },
  {
    id: 4,
    nombre: "HFC",
    ruta: "hfc-report",
  },
];

const mostrarTipos = () => {
  let html = '<option value="" selected>Selecciona un tipo</option>';

  tipos.forEach((i) => {
    html += `<option value="${i.id}">${i.nombre}</option>`;
  });

  tipo_reporte.html(html);
};

const generarReporte = () => {
  if (tipo_reporte.val() == "") {
    Swal.fire({
      icon: "error",
      title: "Oops...",
      text: "No se ha seleccionado el tipo",
    });
    return;
  }

  if (file_data.val() == "") {
    Swal.fire({
      icon: "error",
      title: "Oops...",
      text: "No se ha subido el archivo",
    });
    return;
  }

  btn_generar_reporte.attr("disabled", "disabled");
  let formData = new FormData();
  let files = file_data[0].files[0];
  formData.append("file", files);

  const ruta = () => {
    return tipos.filter((tipo) => tipo.id == tipo_reporte.val());
  };

  $.ajax({
    url: `./export/${ruta()[0].ruta}.php`,
    type: "post",
    data: formData,
    contentType: false,
    processData: false,
    success: function (response) {
      const resp = response.split("|");

      if (resp[0] == "1") {
        window.open(`./public/${resp[1]}`, "_blank");
      } else {
        Swal.fire({
          icon: "error",
          title: "Oops...",
          text: resp[1],
        });
      }

    //   tipo_reporte.val('');
    //   file_data.val('');
      btn_generar_reporte.removeAttr("disabled");

    },
  });
};

btn_generar_reporte.click(generarReporte);

// const subirListadoPrecio = () => {
//   if (file_listado_precio.val() != "") {
//     btn_subir_listado_precio.attr("disabled", "disabled");
//     loading_listado_precio.removeAttr("hidden");
//     let formData = new FormData();
//     let files = file_listado_precio[0].files[0];
//     formData.append("userfile", files);
//     $.ajax({
//       url: "./import/listado_precio.php",
//       type: "post",
//       data: formData,
//       contentType: false,
//       processData: false,
//       success: function (response) {
//         const data = response.split("|");
//         if (data[0] == "1") {
//           window.location.href = "../../public/temp/" + data[1];
//         } else {
//           Swal.fire({
//             icon: "error",
//             title: "Oops...",
//             text: data[1],
//           });
//         }
//         file_listado_precio.val("");
//         btn_subir_listado_precio.removeAttr("disabled");
//         loading_listado_precio.attr("hidden", "hidden");
//       },
//     });
//   }
// };

$(document).ready(() => {
  mostrarTipos();
});
