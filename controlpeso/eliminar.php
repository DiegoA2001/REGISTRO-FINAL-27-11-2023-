<?php
// Incluye el archivo de conexión a la base de datos
include("conexion.php");

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['folio'])) {
    // Obtiene el folio del registro a eliminar desde la URL
    $folio = $_GET['folio'];

    // Realiza una consulta SQL para eliminar el registro con el folio proporcionado
    $consulta = "DELETE FROM datos WHERE folio = '$folio'";

    if (mysqli_query($conex, $consulta)) {
        // La eliminación se realizó con éxito, redirige a la página principal o muestra un mensaje de éxito
        header("Location: index.php"); // Cambia "index.php" por la URL de tu página principal.
        exit();
    } else {
        // La eliminación falló, muestra un mensaje de error o maneja el error de otra manera
        echo "Error al eliminar el registro: " . mysqli_error($conex);
    }
} else {
    // No se ha proporcionado un folio válido, muestra un mensaje de error o redirige a una página de error
    echo "Folio no válido.";
}

// Cierra la conexión a la base de datos si es necesario
mysqli_close($conex);
?>
