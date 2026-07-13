<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| PARTE 2: GESTIÓN DE FACTURACIÓN (ESTRUCTURAS COMPLEJAS Y PARÁMETROS)
|--------------------------------------------------------------------------
*/

// =========================================================================
// Ejercicio 4: Historial General de Facturas de Clientes (Tabla Completa)
// Ruta: GET /facturas/clientes/historial
// =========================================================================
Route::get('/facturas/clientes/historial', function () {
    // 1. Simulación de los datos del aula (Basado exactamente en la proyección del profesor)
    $facturas = json_decode(json_encode([
        ["num_factura" => "001", "cliente" => "Karen Criollo", "fecha_emision" => "2026-07-13", "total_pagar" => 150, "estado" => "Pendiente"],
        ["num_factura" => "002", "cliente" => "Karen Criollo", "fecha_emision" => "2026-07-05", "total_pagar" => 175, "estado" => "Pagada"],
        ["num_factura" => "003", "cliente" => "Cristofer Guevara", "fecha_emision" => "2026-07-13", "total_pagar" => 200, "estado" => "Pendiente"]
    ]));

    // 2. Definición e inicio de la estructura de la tabla idéntica a la pizarra
    $html = "<table border='1' cellpadding='5' cellspacing='0' style='border-collapse: collapse; font-family: sans-serif;'>";
    $html .= "<thead>
                <tr style='font-weight: bold;'>
                    <th>No. FACTURA</th>
                    <th>CLIENTE</th>
                    <th>FECHA EMISION</th>
                    <th>TOTAL A PAGAR</th>
                    <th>ESTADO</th>
                </tr>
              </thead>";
    $html .= "<tbody>";

    // 3. Iteración de la colección usando el ciclo foreach
    foreach ($facturas as $factura) {
        $estadoFormateado = $factura->estado;

        // Reto Avanzado: Si está Pendiente, concatenar el aviso en mayúsculas entre paréntesis
        if ($factura->estado === "Pendiente") {
            $estadoFormateado = "Pendiente (PENDIENTE DE COBRO)";
        }

        // Interpolación de propiedades en celdas con comillas dobles
        $html .= "<tr>
                    <td>{$factura->num_factura}</td>
                    <td>{$factura->cliente}</td>
                    <td>{$factura->fecha_emision}</td>
                    <td>{$factura->total_pagar}</td>
                    <td>{$estadoFormateado}</td>
                  </tr>";
    }

    $html .= "</tbody></table>";

    // 4. Renderizado final en el navegador mediante la instrucción echo
    echo $html;
});


// =========================================================================
// Ejercicio 5: Detalle de Factura de Cliente Específica (Ficha Técnica)
// Ruta: GET /facturas/clientes/detalle/{numero}
// =========================================================================
Route::get('/facturas/clientes/detalle/{numero}', function ($numero) { // Recibe el parámetro numérico de la URL
    // 1. Colección de datos alineada con los registros del ejercicio anterior
    $facturas = json_decode(json_encode([
        ["num_factura" => "001", "cliente" => "Karen Criollo", "fecha_emision" => "2026-07-13", "total_pagar" => 150, "estado" => "Pendiente"],
        ["num_factura" => "002", "cliente" => "Karen Criollo", "fecha_emision" => "2026-07-05", "total_pagar" => 175, "estado" => "Pagada"],
        ["num_factura" => "003", "cliente" => "Cristofer Guevara", "fecha_emision" => "2026-07-13", "total_pagar" => 200, "estado" => "Pendiente"]
    ]));

    // 2. Inicialización de variables de búsqueda
    $facturaEncontrada = null;
    $html = "";

    // 3. Lógica de Búsqueda: Recorrer el arreglo para validar si coincide con el parámetro de la URL
    foreach ($facturas as $factura) {
        if ($factura->num_factura === $numero) {
            $facturaEncontrada = $factura;
            break; // Terminar el bucle al hallar la coincidencia
        }
    }

    // 4. Renderizado Condicional de la Ficha Técnica (Uso de bloques div, títulos y listas)
    if ($facturaEncontrada !== null) {
        $estadoFicha = $facturaEncontrada->estado;
        if ($facturaEncontrada->estado === "Pendiente") {
            $estadoFicha = "Pendiente (PENDIENTE DE COBRO)";
        }

        $html .= "<div style='border: 2px solid #000; padding: 15px; width: 45%; font-family: sans-serif;'>";
        $html .= "<h2>Ficha de Factura: No. {$facturaEncontrada->num_factura}</h2>";
        $html .= "<hr style='border: 1px solid #000;'>";
        $html .= "<ul>";
        $html .= "<li><strong>CLIENTE:</strong> {$facturaEncontrada->cliente}</li>";
        $html .= "<li><strong>FECHA EMISION:</strong> {$facturaEncontrada->fecha_emision}</li>";
        $html .= "<li><strong>TOTAL A PAGAR:</strong> {$facturaEncontrada->total_pagar}</li>";
        $html .= "<li><strong>ESTADO:</strong> {$estadoFicha}</li>";
        $html .= "</ul>";
        $html .= "</div>";
    } else {
        // En caso de que el código de factura no exista en nuestro arreglo
        $html .= "<h1 style='font-family: sans-serif; color: red;'>Factura No Encontrada</h1>";
    }

    // 5. Envío del resultado final al navegador con echo
    echo $html;
});


// =========================================================================
// Ejercicio 6: Libro de Facturas de Proveedores (Cálculo de Totales)
// Ruta: GET /facturas/proveedores/resumen
// =========================================================================
Route::get('/facturas/proveedores/resumen', function () {
    // 1. Declaración del arreglo de objetos representando las facturas de laboratorios proveedores
    $facturasProveedores = json_decode(json_encode([
        ["proveedor" => "Laboratorio MK", "nrc" => "1234-5", "monto_sin_iva" => 500],
        ["proveedor" => "Droguería Santa Inés", "nrc" => "6789-0", "monto_sin_iva" => 1250],
        ["proveedor" => "Corporación PharmaCare", "nrc" => "4556-1", "monto_sin_iva" => 350],
        ["proveedor" => "Laboratorios Vijosa", "nrc" => "9988-2", "monto_sin_iva" => 2100]
    ]));

    // 2. Inicialización de acumuladores para procesar las sumatorias finales (tfoot)
    $totalSinIva = 0;
    $totalIva = 0;
    $totalGeneral = 0;

    // 3. Inicio del diseño estricto de la tabla estructurada
    $html = "<table border='1' cellpadding='5' cellspacing='0' style='border-collapse: collapse; font-family: sans-serif;'>";
    $html .= "<thead>
                <tr style='font-weight: bold;'>
                    <th>PROVEEDOR</th>
                    <th>NRC</th>
                    <th>MONTO SIN IVA</th>
                    <th>IVA (13%)</th>
                    <th>MONTO TOTAL</th>
                </tr>
              </thead>";
    $html .= "<tbody>";

    // 4. Lógica de Procesamiento de cálculos matemáticos dentro del ciclo foreach
    foreach ($facturasProveedores as $fac) {
        // Cálculo del 13% del IVA e Importe Total por cada elemento de la colección
        $ivaFila = $fac->monto_sin_iva * 0.13;
        $montoTotalFila = $fac->monto_sin_iva + $ivaFila;

        // Sumatoria acumulativa de los valores numéricos
        $totalSinIva += $fac->monto_sin_iva;
        $totalIva += $ivaFila;
        $totalGeneral += $montoTotalFila;

        // Armado de celdas inyectando las operaciones resueltas directamente
        $html .= "<tr>
                    <td>{$fac->proveedor}</td>
                    <td>{$fac->nrc}</td>
                    <td>{$fac->monto_sin_iva}</td>
                    <td>{$ivaFila}</td>
                    <td>{$montoTotalFila}</td>
                  </tr>";
    }
    
    $html .= "</tbody>";

    // 5. Construcción de la sección tfoot para los totales generales combinando columnas
    $html .= "<tfoot>
                <tr style='font-weight: bold;'>
                    <td colspan='2' style='text-align: right;'>TOTALES GENERALES:</td>
                    <td>{$totalSinIva}</td>
                    <td>{$totalIva}</td>
                    <td>{$totalGeneral}</td>
                </tr>
              </tfoot>";

    $html .= "</table>";

    // 6. Impresión del bloque completo de datos mediante echo
    echo $html;
});