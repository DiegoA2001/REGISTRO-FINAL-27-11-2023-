<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Agregar Monitor Nuevo</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f0f0f0;
            text-align: center;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh; /* Establecer el alto del body al alto de la ventana */
            margin: 0;
        }

        h1 {
            color: #333;
            font-size: 24px;
            margin-bottom: 20px;
            padding: 10px;
        }

        form {
            background-color: #ffffff;
            padding: 25px;
            border-radius: 10px;
            margin: 0 auto;
            max-width: 600px;
            text-align: left;
        }
        input[type="submit"] {
            background: linear-gradient(90deg, #2ecc71 0%, #27ae60 50%);
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            font-size: 18px;
            cursor: pointer;
            margin-top: 20px;
            transition: transform 0.2s; /* Transición suave del efecto de zoom */
        }
        input[type="submit"]:hover {
    background: #a9b8a9;
    transform: scale(1.1); /* Zoom al pasar el mouse */
}
    </style>
</head>
<body>
<h2>AGREGAR MONITOR NUEVO</h2>
<form method="post" action="agregar_monitor_nuevo.php">
    <label for="nombre_monitor">NOMBRE DEL MONITOR NUEVO:</label>
    <input type="text" id="nombre_monitor" name="nombre_monitor" required oninput="convertirAMayusculas(this)">
    <input type="submit" value="Agregar Monitor">
</form>
<script>
    // Función para convertir a mayúsculas
    function convertirAMayusculas(input) {
        input.value = input.value.toUpperCase();
    }
</script>
</body>
</html>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include("conexion.php");

    $nombreMonitor = $_POST['nombre_monitor'];
    $insertQuery = "INSERT INTO monitores (nombre_monitor) VALUES ('$nombreMonitor')";
    
    if (mysqli_query($conex, $insertQuery)) {
        header("Location: index.php"); // Puedes redirigir a donde corresponda
        exit();
    } else {
        echo "Error al guardar el monitor: " . mysqli_error($conex);
    }
    mysqli_close($conex);
}
?>