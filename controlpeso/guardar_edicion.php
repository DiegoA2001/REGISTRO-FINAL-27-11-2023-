<?php
// Incluye el archivo de conexión a la base de datos
include("conexion.php");
// Verifica si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['customer'])) {
    // Obtiene los datos enviados desde el formulario de edición
    $fecha = $_POST['fecha'];
    $customer = $_POST['customer']; // Este es el cliente actualizado
    $monitor = $_POST['monitor'];
    $supervisor = $_POST['supervisor'];
    $lote = $_POST['lote'];
    $ficha = $_POST['ficha'];
    $folio = $_POST['folio'];
    $hora = $_POST['hora'];
    $peso1 = $_POST['peso1'];
    $peso2 = $_POST['peso2'];
    $peso3 = $_POST['peso3'];
    $peso4 = $_POST['peso4'];
    $peso5 = $_POST['peso5'];
    $peso6 = $_POST['peso6'];
    $peso7 = $_POST['peso7'];
    $peso8 = $_POST['peso8'];
    $peso9 = $_POST['peso9'];
    $peso10 = $_POST['peso10'];
    $observaciones = $_POST['observaciones'];
    
    // Realiza una consulta SQL para actualizar el registro en la base de datos
    $consultaUpdate = "UPDATE datos SET cliente = '$customer', monitor = '$monitor', supervisor = '$supervisor', lote = '$lote', ficha = '$ficha', fecha = '$fecha', hora = '$hora', peso1 = '$peso1', peso2 = '$peso2', peso3 = '$peso3', peso4 = '$peso4', peso5 = '$peso5', peso6 = '$peso6', peso7 = '$peso7', peso8 = '$peso8', peso9 = '$peso9', peso10 = '$peso10', observaciones = '$observaciones' WHERE folio = '$folio'";
    $resultadoUpdate = mysqli_query($conex, $consultaUpdate);

    if ($resultadoUpdate) {
        echo "¡Cambios guardados correctamente!";
         // Redirige a la interfaz principal
         header("Location: index.php");
         exit(); // Asegura que el script se detenga después de la redirección
    } else {
        echo "Error al guardar los cambios: " . mysqli_error($conex);
    }
} else {
    echo "No se han recibido datos válidos para actualizar.";
}

// Cierra la conexión a la base de datos si es necesario
mysqli_close($conex);
?>