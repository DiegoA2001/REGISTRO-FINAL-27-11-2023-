<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Agregar Supervisor Nuevo</title>
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
<h2>AGREGAR SUPERVISOR NUEVO</h2>
<form method="post" action="agregar_supervisor_nuevo.php">
    <label for="nombre_supervisor">NOMBRE DEL SUPERVISOR NUEVO:</label>
    <input type="text" id="nombre_supervisor" name="nombre_supervisor" required oninput="convertirAMayusculas(this)">
    <input type="submit" value="Agregar Supervisor">
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

    $nombreSupervisor = $_POST['nombre_supervisor'];
    $insertQuery = "INSERT INTO supervisores (nombre_supervisor) VALUES ('$nombreSupervisor')";
    
    if (mysqli_query($conex, $insertQuery)) {
        header("Location: index.php"); // Puedes redirigir a donde corresponda
        exit();
    } else {
        echo "Error al guardar el supervisor: " . mysqli_error($conex);
    }
    mysqli_close($conex);
}
?>