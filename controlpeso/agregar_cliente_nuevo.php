<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Agregar Cliente Nuevo</title>
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
    <h2>AGREGAR CLIENTE NUEVO</h2>
    <form method="post" action="agregar_cliente_nuevo.php">
        <label for="nombre">NOMBRE DEL CLIENTE NUEVO:</label>
        <input type="text" id="nombre" name="nombre" required oninput="convertirAMayusculas(this)">
        <input type="submit" value="Agregar Cliente">
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
// Verificar si se está enviando un formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Conectar a la base de datos (asegúrate de tener tu conexión establecida)
    include("conexion.php");

    // Obtener el nombre del cliente del formulario
    $nombreCliente = $_POST['nombre'];

    // Insertar el nuevo cliente en la base de datos
    $insertQuery = "INSERT INTO clientes (nombre_cliente) VALUES ('$nombreCliente')";
    
    if (mysqli_query($conex, $insertQuery)) {
        // Redirigir a index.php después de agregar el cliente
        header("Location: index.php");
        exit();
    } else {
        echo "Error al guardar el cliente: " . mysqli_error($conex);
    }
    // Cerrar la conexión a la base de datos (si es necesario)
    mysqli_close($conex);
}
?>