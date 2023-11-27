<?php
// Incluye el archivo de conexión a la base de datos
include("conexion.php");

// Verifica si se ha pasado el folio en la URL
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['folio'])) {
    // Obtiene el folio del registro a editar desde la URL
    $folio = $_GET['folio'];

   // Realiza una consulta SQL para obtener los datos del registro con el folio proporcionado
   $consulta = "SELECT datos.*, clientes.nombre_cliente, monitores.nombre_monitor, supervisores.nombre_supervisor 
   FROM datos
   LEFT JOIN clientes ON datos.cliente = clientes.customer_id
   LEFT JOIN monitores ON datos.monitor = monitores.monitor_id
   LEFT JOIN supervisores ON datos.supervisor = supervisores.supervisor_id
   WHERE datos.folio = '$folio'";
   $resultado = mysqli_query($conex, $consulta);

    if (mysqli_num_rows($resultado) > 0) {
        // El registro existe, obtén los datos del registro
        $fila = mysqli_fetch_assoc($resultado);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Registro</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f0f0f0;
            text-align: center;
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

        label {
            display: block;
            margin-top: 15px;
        }

        .form-row {
            display: flex;
            justify-content: space-between;
        }
        
        /* Estilos para el select */
        select {
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
            width: 49%;
            margin-bottom: 10px;
        }

        input, textarea {
            width: 45%; /* Establece el ancho de cada campo */
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 15px;
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
            background-color: #0056b3;
            transform: scale(1.1); /* Zoom al pasar el mouse */
        }
    </style>
</head>
<body>
    <h1>EDITAR REGISTRO</h1>
    <form method="post" action="guardar_edicion.php">
        <div class="form-row">
            <label for="fecha">FECHA:</label>
            <input type="text" name="fecha" value="<?php echo $fila['fecha']; ?>">
        </div>

        <div class="form-row">
        <label for="cliente">CLIENTE:</label>
        <select id="customer" name="customer">
        <option value="" disabled selected>SELECCIONA UN CLIENTE EXISTENTE</option>
        <?php
        // Realiza la consulta para obtener los clientes
        $consultaClientes = "SELECT * FROM clientes";
        $resultadoClientes = mysqli_query($conex, $consultaClientes);

        // Verifica si hay resultados y muestra las opciones del selector
        if (mysqli_num_rows($resultadoClientes) > 0) {
            while ($filaCliente = mysqli_fetch_assoc($resultadoClientes)) {
                // Establece como seleccionado el cliente actual del registro
                $selected = ($filaCliente['customer_id'] == $fila['cliente']) ? 'selected' : '';
                echo "<option value='{$filaCliente['customer_id']}' $selected>{$filaCliente['nombre_cliente']}</option>";
            }
        }
        ?>
        </select>
        </div>
        <div class="form-row">
        <label for="monitor">MONITOR:</label>
        <select id="monitor" name="monitor">
        <option value="" disabled selected>SELECCIONA UN MONITOR</option>
        <?php
        // Realiza la consulta para obtener los monitores
        $consultaMonitores = "SELECT * FROM monitores";
        $resultadoMonitores = mysqli_query($conex, $consultaMonitores);

        // Verifica si hay resultados y muestra las opciones del selector
        if (mysqli_num_rows($resultadoMonitores) > 0) {
            while ($filaMonitor = mysqli_fetch_assoc($resultadoMonitores)) {
                // Establece como seleccionado el monitor actual del registro
                $selected = ($filaMonitor['monitor_id'] == $fila['monitor']) ? 'selected' : '';
                echo "<option value='{$filaMonitor['monitor_id']}' $selected>{$filaMonitor['nombre_monitor']}</option>";
            }
        }
        ?>
        </select>
        </div>

        <div class="form-row">
        <label for="supervisor">SUPERVISOR:</label>
        <select id="supervisor" name="supervisor">
        <option value="" disabled selected>SELECCIONA UN SUPERVISOR</option>
        <?php
        // Realiza la consulta para obtener los supervisores
        $consultaSupervisores = "SELECT * FROM supervisores";
        $resultadoSupervisores = mysqli_query($conex, $consultaSupervisores);

        // Verifica si hay resultados y muestra las opciones del selector
        if (mysqli_num_rows($resultadoSupervisores) > 0) {
            while ($filaSupervisor = mysqli_fetch_assoc($resultadoSupervisores)) {
                // Establece como seleccionado el supervisor actual del registro
                $selected = ($filaSupervisor['supervisor_id'] == $fila['supervisor']) ? 'selected' : '';
                echo "<option value='{$filaSupervisor['supervisor_id']}' $selected>{$filaSupervisor['nombre_supervisor']}</option>";
            }
        }
        ?>
        </select>
        </div>

        <div class="form-row">
            <label for="lote">LOTE:</label>
            <input type="text" name="lote" value="<?php echo $fila['lote']; ?>" oninput="convertirAMayusculas(this)">
        </div>

        <div class="form-row">
            <label for="ficha">FICHA:</label>
            <input type="text" name="ficha" value="<?php echo $fila['ficha']; ?>" oninput="convertirAMayusculas(this)">
        </div>

        <div class="form-row">
            <label for="folio">FOLIO:</label>
            <input type="text" name="folio" value="<?php echo $fila['folio']; ?>">
        </div>

        <div class="form-row">
            <label for="hora">HORA:</label>
            <input type="time" name="hora" value="<?php echo $fila['hora']; ?>">
        </div>

        <div class="form-row">
            <label for="peso1">PESO 1:</label>
            <input type="text" name="peso1" value="<?php echo $fila['peso1']; ?>">
        </div>

        <div class="form-row">
            <label for="peso2">PESO 2:</label>
            <input type="text" name="peso2" value="<?php echo $fila['peso2']; ?>">
        </div>

        <div class="form-row">
            <label for="peso3">PESO 3:</label>
            <input type="text" name="peso3" value="<?php echo $fila['peso3']; ?>">
        </div>

        <div class="form-row">
            <label for="peso4">PESO 4:</label>
            <input type="text" name="peso4" value="<?php echo $fila['peso4']; ?>">
        </div>

        <div class="form-row">
            <label for="peso5">PESO 5:</label>
            <input type="text" name="peso5" value="<?php echo $fila['peso5']; ?>">
        </div>

        <div class="form-row">
            <label for="peso6">PESO 6:</label>
            <input type="text" name="peso6" value="<?php echo $fila['peso6']; ?>">
        </div>

        <div class="form-row">
            <label for="peso7">PESO 7:</label>
            <input type="text" name="peso7" value="<?php echo $fila['peso7']; ?>">
        </div>

        <div class="form-row">
            <label for="peso8">PESO 8:</label>
            <input type="text" name="peso8" value="<?php echo $fila['peso8']; ?>">
        </div>

        <div class="form-row">
            <label for="peso9">PESO 9:</label>
            <input type="text" name="peso9" value="<?php echo $fila['peso9']; ?>">
        </div>

        <div class="form-row">
            <label for="peso10">PESO 10:</label>
            <input type="text" name="peso10" value="<?php echo $fila['peso10']; ?>">
        </div>

        <div class="form-row">
            <label for="observaciones">OBSERVACIONES:</label>
            <textarea name="observaciones"><?php echo $fila['observaciones']; ?></textarea>
        </div>

        <input type="submit" value="Guardar Cambios">
    </form>
<script>
    function convertirAMayusculas(input) {
        input.value = input.value.toUpperCase();
    }
</script>
</body>
</html>
<?php
    } else {
        // El registro no existe, muestra un mensaje de error o redirige a una página de error
        echo "El registro no existe.";
    }
    } else {
    // No se ha proporcionado un folio válido, muestra un mensaje de error o redirige a una página de error
    echo "Folio no válido.";
    }
?>