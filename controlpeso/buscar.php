<?php
include("conexion.php");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['buscar'])) {
    $searchTerm = trim($_POST['buscar']);

    // Realiza una consulta SQL para buscar los datos en la base de datos
    $consulta = "SELECT datos.fecha, clientes.nombre_cliente, monitores.nombre_monitor, supervisores.nombre_supervisor, datos.lote, datos.ficha, datos.folio, datos.hora, datos.peso1, datos.peso2, datos.peso3, datos.peso4, datos.peso5, datos.peso6, datos.peso7, datos.peso8, datos.peso9, datos.peso10, datos.observaciones 
    FROM datos 
    INNER JOIN clientes ON datos.cliente = clientes.customer_id 
    LEFT JOIN monitores ON datos.monitor = monitores.monitor_id
    LEFT JOIN supervisores ON datos.supervisor = supervisores.supervisor_id
    WHERE datos.fecha LIKE '%$searchTerm%' OR datos.lote LIKE '%$searchTerm%' OR clientes.nombre_cliente LIKE '%$searchTerm%' OR datos.ficha LIKE '%$searchTerm%'";
    $resultado = mysqli_query($conex, $consulta);

    if (mysqli_num_rows($resultado) > 0) {
        // Construye una tabla con los resultados de la búsqueda
        echo "<table class='responsive-table resultados' border='1'>";
        echo "<thead>";
        echo "<tr>";
        echo "<th>FECHA</th>";
        echo "<th>CLIENTE</th>";
        echo "<th>MONITOR</th>";
        echo "<th>SUPERVISOR</th>";
        echo "<th>LOTE</th>";
        echo "<th>FICHA</th>";
        echo "<th>FOLIO</th>";
        echo "<th>HORA</th>";
        echo "<th>PESO 1</th>";
        echo "<th>PESO 2</th>";
        echo "<th>PESO 3</th>";
        echo "<th>PESO 4</th>";
        echo "<th>PESO 5</th>";
        echo "<th>PESO 6</th>";
        echo "<th>PESO 7</th>";
        echo "<th>PESO 8</th>";
        echo "<th>PESO 9</th>";
        echo "<th>PESO 10</th>";
        echo "<th>OBSERVACIONES</th>";
        echo '<th>ACCIONES</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';

        while ($fila = mysqli_fetch_assoc($resultado)) {
            echo "<tr>";
            echo "<td>{$fila['fecha']}</td>";
            echo "<td>{$fila['nombre_cliente']}</td>";
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
        echo '</tbody>';
        echo '</table>';
    } else {
        echo '<p>No se encontraron resultados.</p>';
    }
}
mysqli_close($conex);
?>