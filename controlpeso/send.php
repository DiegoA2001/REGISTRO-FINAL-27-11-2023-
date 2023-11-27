<?php
include("conexion.php");
date_default_timezone_set('America/Santiago');

// Verifica si se ha enviado el formulario:
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['send'])) {
    // Se ha enviado el formulario, procesa los datos:
    $date = isset($_POST['date']) ? trim($_POST['date']) : '';
    $customerId = isset($_POST['customer']) ? $_POST['customer'] : ''; // Verificación de la existencia de 'customer'
    $newCustomer = isset($_POST['newCustomer']) ? trim($_POST['newCustomer']) : '';
    $monitorId = isset($_POST['monitor']) ? $_POST['monitor'] : '';
    $newMonitor = isset($_POST['newMonitor']) ? trim($_POST['newMonitor']) : '';
    $supervisorId = isset($_POST['supervisor']) ? $_POST['supervisor'] : '';
    $newSupervisor = isset($_POST['newSupervisor']) ? trim($_POST['newSupervisor']) : '';
    $lote = isset($_POST['lote']) ? trim($_POST['lote']) : '';
    $ficha = isset($_POST['ficha']) ? trim($_POST['ficha']) : '';

    // Agregar el nuevo cliente, monitor y supervisor a sus respectivas tablas:
    if (!empty($newCustomer)) {
        $consultaNuevoCliente = "INSERT INTO clientes (nombre_cliente) VALUES ('$newCustomer')";
        $resultadoNuevoCliente = mysqli_query($conex, $consultaNuevoCliente);
        if ($resultadoNuevoCliente) {
            // Éxito al agregar el nuevo cliente:
            $customerId = mysqli_insert_id($conex);
        } else {
            // Manejo de error al agregar el cliente.
        }
    }

    if (!empty($newMonitor)) {
        $consultaNuevoMonitor = "INSERT INTO monitores (nombre_monitor) VALUES ('$newMonitor')";
        $resultadoNuevoMonitor = mysqli_query($conex, $consultaNuevoMonitor);
        if ($resultadoNuevoMonitor) {
            // Éxito al agregar el nuevo monitor:
            $monitorId = mysqli_insert_id($conex);
        } else {
            // Manejo de error al agregar el monitor.
        }
    }

    if (!empty($newSupervisor)) {
        $consultaNuevoSupervisor = "INSERT INTO supervisores (nombre_supervisor) VALUES ('$newSupervisor')";
        $resultadoNuevoSupervisor = mysqli_query($conex, $consultaNuevoSupervisor);
        if ($resultadoNuevoSupervisor) {
            // Éxito al agregar el nuevo Supervisor:
            $supervisorId = mysqli_insert_id($conex);
        } else {
            // Manejo de error al agregar el Supervisor.
        }
    }

    // Continuar con la inserción de datos si se tiene el ID del cliente, monitor y supervisor:
    if ($customerId != '' && $monitorId != '' && $supervisorId != '') {
            $hora = date("H:i:s");
            $pesos = array();
            $observaciones = trim($_POST['observaciones']);

            // Recopila los pesos del formulario en un array:
            for ($i = 1; $i <= 10; $i++) {
                $pesos[] = strval($_POST['peso' . $i]);
            }

            // Obtén el último número de folio para la fecha actual:
            $consultaUltimoFolio = "SELECT MAX(SUBSTRING(folio, 10)) AS ultimoNumero FROM datos WHERE fecha = '$date'";
            $resultadoUltimoFolio = mysqli_query($conex, $consultaUltimoFolio);
            $filaUltimoFolio = mysqli_fetch_assoc($resultadoUltimoFolio);
            $ultimoNumero = $filaUltimoFolio['ultimoNumero'];

            // Si no hay folios para la fecha actual, comienza desde 1:
            $nuevoNumero = ($ultimoNumero != null) ? intval($ultimoNumero) + 1 : 1;
            $numeroFormateado = str_pad($nuevoNumero, 2, '0', STR_PAD_LEFT);

            // Construye el nuevo folio con el nuevo número y la fecha:
            $invoice = "" . date("Ymd", strtotime($date)) . $numeroFormateado;

            // Verifica si el folio ya existe para la fecha actual:
            $consultaFolioExistente = "SELECT COUNT(*) AS folioExistente FROM datos WHERE folio = '$invoice'";
            $resultadoFolioExistente = mysqli_query($conex, $consultaFolioExistente);
            $filaFolioExistente = mysqli_fetch_assoc($resultadoFolioExistente);
            $folioExistente = $filaFolioExistente['folioExistente'];

            // Si el folio ya existe, incrementa el número y vuelve a verificar:
            while ($folioExistente > 0) {
                $nuevoNumero++;
                $numeroFormateado = str_pad($nuevoNumero, 2, '0', STR_PAD_LEFT);
                $invoice = "" . date("Ymd", strtotime($date)) . $numeroFormateado;

                $consultaFolioExistente = "SELECT COUNT(*) AS folioExistente FROM datos WHERE folio = '$invoice'";
                $resultadoFolioExistente = mysqli_query($conex, $consultaFolioExistente);
                $filaFolioExistente = mysqli_fetch_assoc($resultadoFolioExistente);
                $folioExistente = $filaFolioExistente['folioExistente'];
            }

            // Ahora, $invoice contiene un folio único para la fecha actual.

            // Insertar los datos en la tabla de datos:
            $consulta = "INSERT INTO datos(fecha, cliente, monitor, supervisor, lote, ficha, folio, hora, peso1, peso2, peso3, peso4, peso5, peso6, peso7, peso8, peso9, peso10, observaciones)
                 VALUES ('$date', '$customerId', '$monitorId', '$supervisorId', '$lote', '$ficha', '$invoice', '$hora', 
                 '" . implode("','", $pesos) . "', '$observaciones')";
            $resultado = mysqli_query($conex, $consulta);
            if ($resultado) {
                echo "<h3 class='success'>TU REGISTRO SE HA COMPLETADO</h3>";
            }
        }
    } else {
        // Manejo de error al agregar el cliente.
    }


// Realiza una consulta SQL para obtener los registros y guárdalos en una variable de sesión:
if (!isset($_SESSION['resultados'])) {
    $consulta = "SELECT datos.*, clientes.nombre_cliente AS nombre_cliente, monitores.nombre_monitor, supervisores.nombre_supervisor
             FROM datos
             LEFT JOIN clientes ON datos.cliente = clientes.customer_id
             LEFT JOIN monitores ON datos.monitor = monitores.monitor_id
             LEFT JOIN supervisores ON datos.supervisor = supervisores.supervisor_id
             ORDER BY datos.folio";
    $resultado = mysqli_query($conex, $consulta);

    $_SESSION['resultados'] = array();

    while ($fila = mysqli_fetch_assoc($resultado)) {
        $_SESSION['resultados'][] = $fila;
    }
}
// Obtener los resultados de la variable de sesión y mostrarlos en la tabla:
if (isset($_SESSION['resultados'])) {
    foreach ($_SESSION['resultados'] as $fila) {
        echo "<tr>";
        echo "<tr class='data-row' data-folio='{$fila['folio']}'>";
        echo "<td>{$fila['fecha']}</td>";
        echo "<td>{$fila['nombre_cliente']}</td>"; // Mostrar el nombre del cliente en lugar del ID.
        echo "<td>{$fila['nombre_monitor']}</td>";
        echo "<td>{$fila['nombre_supervisor']}</td>";
        echo "<td>{$fila['lote']}</td>";
        echo "<td>{$fila['ficha']}</td>";
        echo "<td>{$fila['folio']}</td>";
        echo "<td>{$fila['hora']}</td>";
        echo "<td>{$fila['peso1']}</td>";
        echo "<td>{$fila['peso2']}</td>";
        echo "<td>{$fila['peso3']}</td>";
        echo "<td>{$fila['peso4']}</td>";
        echo "<td>{$fila['peso5']}</td>";
        echo "<td>{$fila['peso6']}</td>";
        echo "<td>{$fila['peso7']}</td>";
        echo "<td>{$fila['peso8']}</td>";
        echo "<td>{$fila['peso9']}</td>";
        echo "<td>{$fila['peso10']}</td>";
        echo "<td>{$fila['observaciones']}</td>";
        echo "<td>";
        echo "<button class='edit-button' data-folio='{$fila['folio']}'>Editar</button>";
        echo "<button class='delete-button' data-folio='{$fila['folio']}'>Eliminar</button>";
        echo "</td>";
        echo "</tr>";
    }
    echo "</tbody>";
    echo "</table>";
}
mysqli_close($conex);
?>