<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report App</title>
    <link rel="icon" href="./src/favicon.png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="./src/style.css">
</head>

<body>

    <div class="m-0 vh-100 row justify-content-center align-items-center">
        <div class="col-6 bg-white p-5 rounded">
            <div class="row">
                <div class="col-12 m-3">
                    <div class="mb-3">
                        <label for="tipo_reporte" class="form-label fw-bold">Tipo</label>
                        <select class="form-select" id="select_tipo_reporte" aria-label="Tipo">
                            <option value="" selected>Seleccione un tipo</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 m-3">
                    <div class="mb-3">
                        <label for="file_data" class="form-label fw-bold">Archivo Excel</label>
                        <input type="file" class="form-control" id="file_data" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel.sheet.macroenabled.12">
                    </div>
                </div>
            </div>
            <div class="row m-3">
                <div class="col-12 text-center">
                    <button type="button" id="btn_generar_reporte" class="btn btn-dark btn-lg">Generar Reporte</button>
                </div>
            </div>
        </div>
    </div>
    <script src="./src/assets/jquery/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="./src/script.js"></script>

</body>

</html>