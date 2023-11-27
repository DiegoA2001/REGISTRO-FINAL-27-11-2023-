<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>REGISTRO</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" type="text/css" href="estilo.css">
</head>
<body>
    <form method="post" autocomplete="off">
        <img width="100" height="74" src="https://www.standrews.cl/wp-content/uploads/2022/10/logo-st-andrews.png">
        <h2>REGISTRO CONTROL DE PESO PRODUCTO TERMINADO GRANEL-ENTERO</h2>
        <div class="input-group d-flex justify-content-center">
        <div class="input-container mb-2">
            <a href="agregar_cliente_nuevo.php" class="add-client-link">
            <i class="fa-solid fa-user-plus"></i>
            </a>
        </div>
        <select id="customer" name="customer" class="dynamic-select" required>
            <option value="" disabled selected>SELECCIONA UN CLIENTE EXISTENTE</option>
            <?php
                // Conexión a la base de datos establecida.
                include("conexion.php");

                // Consulta para obtener los clientes.
                $consultaClientes = "SELECT * FROM clientes";
                $resultadoClientes = mysqli_query($conex, $consultaClientes);

                // Verificación de resultados y muestreo de las opciones del selector.
                if (mysqli_num_rows($resultadoClientes) > 0) {
                    while ($filaCliente = mysqli_fetch_assoc($resultadoClientes)) {
                        echo "<option value='{$filaCliente['customer_id']}'>{$filaCliente['nombre_cliente']}</option>";
                    }
                }
            ?>
        </select>
            <div class="input-group d-flex justify-content-center">
            <div class="input-container mb-2">
            <a href="agregar_monitor_nuevo.php" class="add-client-link">
            <i class="fa-solid fa-user-plus"></i>
            </a>
            </div>
        <select id="monitor" name="monitor" class="dynamic-select" required>
        <option value="" disabled selected>SELECCIONA UN MONITOR EXISTENTE</option>
        <?php
        include("conexion.php");

        // Consulta para obtener los Monitores.
        $consultaMonitores = "SELECT * FROM monitores";
        $resultadoMonitores = mysqli_query($conex, $consultaMonitores);

        // Agregar opciones para Monitores.
        if (mysqli_num_rows($resultadoMonitores) > 0) {
            while ($filaMonitor = mysqli_fetch_assoc($resultadoMonitores)) {
                echo "<option value='{$filaMonitor['monitor_id']}'>{$filaMonitor['nombre_monitor']}</option>";;
            }
        }
        ?>
        </select>
        </div>
        <div class="input-container mb-2">
        <a href="agregar_supervisor_nuevo.php" class="add-client-link">
            <i class="fa-solid fa-user-plus"></i>
        </a>
        </div>
        <select id="supervisor" name="supervisor" class="dynamic-select" required>
        <option value="" disabled selected>SELECCIONA UN SUPERVISOR EXISTENTE</option>
        <?php
        include("conexion.php");

        // Consulta para obtener los Supervisores.
        $consultaSupervisores = "SELECT * FROM supervisores";
        $resultadoSupervisores = mysqli_query($conex, $consultaSupervisores);

        // Agregar opciones para Supervisores.
        if (mysqli_num_rows($resultadoSupervisores) > 0) {
            while ($filaSupervisor = mysqli_fetch_assoc($resultadoSupervisores)) {
                echo "<option value='{$filaSupervisor['supervisor_id']}'>{$filaSupervisor['nombre_supervisor']}</option>";
            }
        }
        ?>
        </select>
        </div>
        <div class="input-container">
            <input type="date" id="date" name="date" placeholder="FECHA" required>
        </div>
        <div class="input-container">
            <input type="text" id="lote" name="lote" placeholder="LOTE" required>
            <i class="fa-brands fa-font-awesome"></i>
        </div>
        <div class="input-container">
            <input type="text" id="ficha" name="ficha" placeholder="FICHA TÉCNICA" required>
            <i class="fa-solid fa-square-pen"></i>
        </div>
        </div>
        </div>
        <div class="background">
            <div class="shape"></div>
            <div class="shape"></div>
        </div>
        <div class="titulo">
            <h1>TABLA DE REGISTRO <i class="fa-solid fa-table"></i></h1>
        </div>
        <table class="responsive-table">
            <thead>
                <tr>
                    <th>HORA<i class="fa-solid fa-clock"></i></th>
                    <th>PESO 1</th>
                    <th>PESO 2</th>
                    <th>PESO 3</th>
                    <th>PESO 4</th>
                    <th>PESO 5</th>
                    <th>PESO 6</th>
                    <th>PESO 7</th>
                    <th>PESO 8</th>
                    <th>PESO 9</th>
                    <th>PESO 10</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><input type="time" id="hora" placeholder="Hora"></td>
                    <td><input type="text" id="peso1" name="peso1"></td>
                    <td><input type="text" id="peso2" name="peso2"></td>
                    <td><input type="text" id="peso3" name="peso3"></td>
                    <td><input type="text" id="peso4" name="peso4"></td>
                    <td><input type="text" id="peso5" name="peso5"></td>
                    <td><input type="text" id="peso6" name="peso6"></td>
                    <td><input type="text" id="peso7" name="peso7"></td>
                    <td><input type="text" id="peso8" name="peso8"></td>
                    <td><input type="text" id="peso9" name="peso9"></td>
                    <td><input type="text" id="peso10" name="peso10"></td>
                </tr>
            </tbody>
        </table>
        <table>
            <thead>
                <tr>
                    <th>OBSERVACIONES<i class="fa-solid fa-eye"></i>  :</th>
                    <td><textarea id="observaciones" name="observaciones" rows="4" placeholder="Escribe tu observación"></textarea></td>
                </tr>
            </thead>
        </table>
        <input type="submit" name="send" id="sendButton" value="Registrar Datos">
        <h1>RESULTADOS DE LA BASE DE DATOS</h1>
        <div class="text-center mb-2">
        <div class="search-export-container">
        <div class="input-container mb-2">
            <input type="text" class="buscar" id="searchInput" placeholder="Buscar">
            <button id="buscarButton" type="button" class="search-icon"><i class="fa-solid fa-search"></i></button>
        </div>
        <div class="export-buttons">
            <a href="fpdf/PruebaV.php" target="_blank" class="btn btn-success generate-pdf">Generar PDF de Búsqueda</a>
        </div>
        <div class="export-buttons">
            <a href="fpdf/ReporteGeneralPDF.php" target="_blank" class="btn btn-success generate-pdf">Generar PDF Completo</a>
        </div>
        </div>
        <table class="responsive-table resultados" border="1">
        <thead>
            <tr>
                <th>FECHA</th>
                <th>CLIENTE</th>
                <th>MONITOR</th>
                <th>SUPERVISOR</th>
                <th>LOTE</th>
                <th>FICHA</th>
                <th>FOLIO</th>
                <th>HORA</th>
                <th>PESO 1</th>
                <th>PESO 2</th>
                <th>PESO 3</th>
                <th>PESO 4</th>
                <th>PESO 5</th>
                <th>PESO 6</th>
                <th>PESO 7</th>
                <th>PESO 8</th>
                <th>PESO 9</th>
                <th>PESO 10</th>
                <th>OBSERVACIONES</th>
                <th>ACCIONES</th>
            </tr>
        </thead>
</form>
<?php
include("send.php");
?>
<script src="script.js"></script>
</body>
</html>