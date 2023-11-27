// Función para validar y convertir a mayúsculas:
function validateAndUpperCase(inputElement) {
    inputElement.value = inputElement.value.toUpperCase(); // Convierte a mayúsculas.
        // Expresión regular para permitir solo letras y mayúsculas:
        var regex = /^[A-Z0-9\s]+$/;
        if (!regex.test(inputElement.value)) {
            alert("Solo se permiten letras en mayúscula.");
            inputElement.value = ""; // Borra el valor si no cumple con la regla.
        }
    }

    // Agrega oyente de eventos para el nuevo campo:
    var customerInput = document.getElementById("customer");
    customerInput.addEventListener("input", function () {
    validateAndUpperCase(newCustomerInput);
    });

    // Obtener los elementos de los campos de monitor y supervisor:
    var monitorInput = document.getElementById("monitor");
    var supervisorInput = document.getElementById("supervisor");

    // Agregar oyentes de eventos para validar y convertir a mayúsculas los campos de monitor y supervisor:
    monitorInput.addEventListener("input", function () {
    validateAndUpperCase(monitorInput);
    });
    supervisorInput.addEventListener("input", function () {
    validateAndUpperCase(supervisorInput);
    });
    // Obtener el elemento de la casilla de "Ficha Técnica":
    var fichaInput = document.getElementById("ficha");

    // Agregar un oyente de eventos para el evento de entrada (input):
    fichaInput.addEventListener("input", function () {
    validateAndUpperCase(fichaInput);
    });

    // Función para validar el formulario:
    function validateForm() {
        // Obtener los valores de los campos obligatorios:
        var date = document.getElementById("date").value;
        var customer = document.getElementById("customer").value;
        var monitor = document.getElementById("monitor").value; // Nuevo campo de monitor.
        var supervisor = document.getElementById("supervisor").value; // Nuevo campo de supervisor.
        var lote = document.getElementById("lote").value;
        // Verificar si alguno de los campos está vacío:
        if (date === "" || customer === "" || monitor === "" || supervisor === "" || lote === "") {
            alert("Por favor, complete todos los campos obligatorios.");
            return false; // Evitar el envío del formulario si falta algún dato.
        }
        // Si todos los campos obligatorios están completos, se permite el envío:
        return true;
    }
    // Agrega oyentes de eventos a los campos de cliente y lote:
    var customerInput = document.getElementById("customer");
    var loteInput = document.getElementById("lote");
    customerInput.addEventListener("input", function () {
        validateAndUpperCase(customerInput);
    });
    loteInput.addEventListener("input", function () {
        validateAndUpperCase(loteInput);
    });
    document.getElementById("sendButton").addEventListener("click", function (event) {
        // Verificar si el botón presionado es el de "Registrar Datos":
        if (event.target.name === "send" && event.target.getAttribute("data-action") === "insert") {
            if (!validateForm()) {
                event.preventDefault(); // Evitar el envío del formulario si la validación falla.
            }
        }
    });
    
    // Función para validar el formulario al hacer clic en el botón "Registrar Datos":
    function validateForm(event) {
    // Obtener el botón que fue clickeado:
    var clickedButton = event.target;
    // Verificar si el botón presionado es el de "Registrar Datos":
    if (clickedButton.id === "sendButton" && clickedButton.getAttribute("data-action") === "insert") {
        // Obtener los valores de los campos obligatorios:
        var date = document.getElementById("date").value;
        var customer = document.getElementById("customer").value;
        var lote = document.getElementById("lote").value;
        // Verificar si alguno de los campos está vacío:
        if (date === "" || customer === "" || lote === "") {
            alert("Por favor, complete todos los campos obligatorios.");
            event.preventDefault(); // Evitar el envío del formulario si falta algún dato.
            return false;
        }
    }
    // Si no es el botón de "Registrar Datos", permitir el envío:
    return true;
    }

    // Evento de clic para el botón de búsqueda:
    document.getElementById("buscarButton").addEventListener("click", function (event) {
        // Prevenir el envío del formulario:
        event.preventDefault();

        // Obtener el valor de búsqueda:
        const searchTerm = document.querySelector(".buscar").value;

        // Realizar la solicitud AJAX para buscar los datos en el servidor:
        const xhr = new XMLHttpRequest();
        xhr.open("POST", "buscar.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                // Reemplazar el contenido de la tabla con los resultados de la búsqueda:
                const resultadoTable = document.querySelector("table.resultados");
                resultadoTable.innerHTML = xhr.responseText;
            }
        };
        xhr.send("buscar=" + searchTerm);
    });

    // Evento de clic para los botones "Editar":
    const editButtons = document.querySelectorAll(".edit-button");
    editButtons.forEach((editButton) => {
    editButton.addEventListener("click", function () {
        // Obtener el folio asociado a esta fila:
        const folio = editButton.getAttribute("data-folio");
        // Redirigir a la página de edición con el folio como parámetro:
        window.location.href = `editar.php?folio=${folio}`;
    });
    });

    // Evento de clic para los botones "Eliminar":
    const deleteButtons = document.querySelectorAll(".delete-button");
    deleteButtons.forEach((deleteButton) => {
    deleteButton.addEventListener("click", function () {
        // Obtener el folio asociado a esta fila:
        const folio = deleteButton.getAttribute("data-folio");
        // Preguntar al usuario si realmente desea eliminar el registro:
        if (confirm("¿Estás seguro de que deseas eliminar este registro?")) {
            // Redirigir a la página de eliminación con el folio como parámetro:
            window.location.href = `eliminar.php?folio=${folio}`;
        }
    });
    });

    // Función para manejar clics en los botones "Editar" en los resultados de búsqueda:
    function handleEditButtonClick(event) {
    const folio = event.target.getAttribute("data-folio");
    // Redirigir a la página de edición con el folio como parámetro:
    window.location.href = `editar.php?folio=${folio}`;
    }

    // Función para manejar clics en los botones "Eliminar" en los resultados de búsqueda:
    function handleDeleteButtonClick(event) {
    const folio = event.target.getAttribute("data-folio");
    // Preguntar al usuario si realmente desea eliminar el registro:
    if (confirm("¿Estás seguro de que deseas eliminar este registro?")) {
        // Redirigir a la página de eliminación con el folio como parámetro:
        window.location.href = `eliminar.php?folio=${folio}`;
    }
    }

    // Agregar manejadores de eventos a los botones de editar y eliminar:
    document.addEventListener("click", function (event) {
    if (event.target.classList.contains("edit-button")) {
        handleEditButtonClick(event);
    } else if (event.target.classList.contains("delete-button")) {
        handleDeleteButtonClick(event);
    }
    });

    // Función para el botón de Generar PDF de Búsqueda:
    document.addEventListener("DOMContentLoaded", function() {
        var generatePDFButton = document.querySelector('.generate-pdf');
    
        generatePDFButton.addEventListener("click", function(event) {
            event.preventDefault();
    
            var searchTerm = document.getElementById("searchInput").value; // Aquí se obtiene el término de búsqueda de algún campo de entrada.
    
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "fpdf/PruebaV.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.responseType = "blob";
    
            xhr.onload = function() {
                if (xhr.status === 200) {
                    var blob = new Blob([xhr.response], { type: "application/pdf" });
                    var link = document.createElement("a");
                    link.href = window.URL.createObjectURL(blob);
                    link.download = "Reporte.pdf";
                    link.click();
                }
            };
            xhr.send("buscar=" + searchTerm); // Envía el término de búsqueda al archivo PHP.
        });
    });
    // Asociar la función de validación al evento de clic en el botón "Registrar Datos":
    document.getElementById("sendButton").addEventListener("click", validateForm);