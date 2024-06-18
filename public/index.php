<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prueba parcial</title>
    <link href="./css/tailwind.css" rel="stylesheet">
</head>
<body class="bg-gray-100 p-6">

<div class="max-w-lg mx-auto bg-white p-8 rounded shadow-md">
    <h1 class="text-2xl font-bold mb-6 text-center text-blue-700">Ingreso de Producto</h1>
    <form id="productForm" method="POST" action="index.php" class="space-y-4">
        <div>
            <label for="nombre" class="block text-sm font-medium text-gray-700">Nombre del Producto</label>
            <input type="text" name="nombre" id="nombre" class="mt-1 p-2 border border-blue-300 rounded w-full focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            <p id="errorNombre" class="text-red-500 text-sm mt-1"></p>
        </div>
        <div>
            <label for="precio" class="block text-sm font-medium text-gray-700">Precio por Unidad en Dolares</label>
            <input type="number" step="0.01" name="precio" id="precio" class="mt-1 p-2 border border-blue-300 rounded w-full focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            <p id="errorPrecio" class="text-red-500 text-sm mt-1"></p>
        </div>
        <div>
            <label for="cantidad" class="block text-sm font-medium text-gray-700">Cantidad de Inventario</label>
            <input type="number" name="cantidad" id="cantidad" class="mt-1 p-2 border border-blue-300 rounded w-full focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            <p id="errorCantidad" class="text-red-500 text-sm mt-1"></p>
        </div>
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">Guardar Producto</button>
    </form>
</div>

<?php
// Función para almacenar la información ingresada por el usuario en un array asociativo
function almacenarProducto($nombre, $precio, $cantidad) {
    return array(
        "nombre" => $nombre,
        "precio" => $precio,
        "cantidad" => $cantidad,
        "total" => $precio * $cantidad,
        "estado" => $cantidad == 0 ? "Agotado" : "En Stock"
    );
}

// Función para mostrar la información del producto en una tabla usando foreach
function mostrarProductos($productos) {
    echo '
    <div class="max-w-lg mx-auto bg-white p-8 mt-6 rounded shadow-md">
        <h2 class="text-xl font-bold mb-4 text-center text-blue-700">Productos Ingresados</h2>
        <table class="min-w-full bg-white border border-blue-300">
            <thead>
                <tr class="bg-blue-100">
                    <th class="py-2 px-4 border-b text-blue-700">Nombre del Producto</th>
                    <th class="py-2 px-4 border-b text-blue-700">Precio por Unidad</th>
                    <th class="py-2 px-4 border-b text-blue-700">Cantidad de Inventario</th>
                    <th class="py-2 px-4 border-b text-blue-700">Valor Total</th>
                    <th class="py-2 px-4 border-b text-blue-700">Estado</th>
                </tr>
            </thead>
            <tbody>';
    
    foreach ($productos as $producto) {
        echo '
                <tr>
                    <td class="py-2 px-4 border-b">' . $producto["nombre"] . '</td>
                    <td class="py-2 px-4 border-b">$' . number_format($producto["precio"], 2) . '</td>
                    <td class="py-2 px-4 border-b">' . $producto["cantidad"] . '</td>
                    <td class="py-2 px-4 border-b">$' . number_format($producto["total"], 2) . '</td>
                    <td class="py-2 px-4 border-b">' . $producto["estado"] . '</td>
                </tr>';
    }

    echo '
            </tbody>
        </table>
    </div>';
}

// Procesar formulario si se envía
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST["nombre"];
    $precio = $_POST["precio"];
    $cantidad = $_POST["cantidad"];
    
    if ($nombre && $precio && $cantidad !== "") { // Verificamos que cantidad no esté vacío (incluyendo '0')
        $producto = almacenarProducto($nombre, $precio, $cantidad);
        
        // Inicializamos un array para almacenar productos ingresados
        $productos = [];

        // Verificamos si ya existe la sesión para mantener productos ingresados
        if (isset($_SESSION['productos'])) {
            $productos = $_SESSION['productos'];
        }

        // Agregamos el producto actual al array de productos
        $productos[] = $producto;

        // Almacenamos los productos en la sesión
        $_SESSION['productos'] = $productos;

        // Mostramos todos los productos ingresados hasta ahora
        mostrarProductos($productos);
    } else {
        echo '<div class="max-w-lg mx-auto bg-white p-8 mt-6 rounded shadow-md text-red-500 text-center">Debe ingresar todos los campos correctamente.</div>';
    }
}
?>

<script src="./js/main.js"></script>
</body>
</html>
