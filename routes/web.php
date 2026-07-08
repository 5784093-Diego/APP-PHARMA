<?php

use Illuminate\Support\Facades\Route;

// Ruta de bienvenida por defecto
Route::get('/', function () {
    return view('welcome');
});

// ==========================================================
// 1. PRÁCTICA PROPUESTA: RUTA /categorias
// ==========================================================
Route::get('/categorias', function () {
    
    
    $categorias = json_decode(json_encode([
        ["codigo" => "A02", "categoria" => "Medicamentos para el tratamiento de Trastornos causados por Ácidos"],
        ["codigo" => "A03", "categoria" => "Medicamentos contra Trastornos Funcionales Gastrointestinales"],
        ["codigo" => "A04", "categoria" => "Medicamentos Antieméticos y Antinauseosos"],
        ["codigo" => "A06", "categoria" => "Medicamentos para el Estreñimiento"],
        ["codigo" => "A07", "categoria" => "Medicamentos Antidiarreicos, Antiinflamatorios y Antiinfecciosos Intestinales"],
        ["codigo" => "A10", "categoria" => "Medicamentos usados en Diabetes"],
        ["codigo" => "A11", "categoria" => "Vitaminas"],
        ["codigo" => "A12", "categoria" => "Suplementos Minerales"]
    ]));

    // Construimos la tabla en una variable HTML aplicando estilos básicos
    $html = "<h2>Listado de Categorías Farmacéuticas</h2>";
    $html .= "<table border='1' cellpadding='8' cellspacing='0' style='border-collapse: collapse; font-family: Arial, sans-serif;'>";
    $html .= "<tr style='background-color: #f2f2f2;'><th>CÓDIGO</th><th>CATEGORÍA</th></tr>";

    // Recorremos los elementos dinámicamente usando un ciclo foreach
    foreach ($categorias as $cat) {
        // Hacemos interpolación usando comillas dobles y las llaves {}
        $html .= "<tr>
                    <td>{$cat->codigo}</td>
                    <td>{$cat->categoria}</td>
                  </tr>";
    }

    $html .= "</table>";

    // Retornamos el HTML directamente al navegador
    return $html;
});


// ==========================================================
// 2. PRÁCTICA PROPUESTA: RUTA /medicamentos
// ==========================================================
Route::get('/medicamentos', function () {

    // Lista de objetos con los datos de los medicamentos (Formato pedido por el profesor)
    $medicamentos = json_decode(json_encode([
        ["codigo" => "A02BA02", "num" => "1", "nombre" => "Ranitidina", "dosis" => "50 mg", "forma" => "Líquidos parenterales", "via" => "IM/IV"],
        ["codigo" => "A02BA03", "num" => "2", "nombre" => "Famotidina", "dosis" => "40 mg", "forma" => "Sólidos orales", "via" => "VO"],
        ["codigo" => "A02BC01", "num" => "3", "nombre" => "Omeprazol", "dosis" => "20 mg", "forma" => "Sólidos orales", "via" => "VO"],
        ["codigo" => "A02BC01", "num" => "4", "nombre" => "Omeprazol", "dosis" => "40 mg", "forma" => "Sólidos parenterales", "via" => "IV"],
        ["codigo" => "A03BA01", "num" => "1", "nombre" => "Atropina (Sulfato)", "dosis" => "0.5-1 mg/mL", "forma" => "Líquidos parenterales", "via" => "SC/IM/IV"],
        ["codigo" => "A03BA03", "num" => "2", "nombre" => "Hiosciamina (bromuro de n-butil hioscina)", "dosis" => "10 mg", "forma" => "Sólidos orales", "via" => "VO"],
        ["codigo" => "A03BA03", "num" => "3", "nombre" => "Hiosciamina (bromuro de n-butil hioscina)", "dosis" => "20 mg/mL", "forma" => "Líquidos parenterales", "via" => "IM/IV"],
        ["codigo" => "A03FA01", "num" => "4", "nombre" => "Metoclopramida (clorhidrato)", "dosis" => "5 mg/mL", "forma" => "Líquidos parenterales", "via" => "IM/IV"],
        ["codigo" => "A03FA01", "num" => "5", "nombre" => "Metoclopramida (clorhidrato)", "dosis" => "10 mg", "forma" => "Sólidos orales", "via" => "VO"],
        ["codigo" => "A04AA01", "num" => "1", "nombre" => "Ondansetron", "dosis" => "8 mg", "forma" => "Sólidos orales", "via" => "VO"],
        ["codigo" => "A04AA01", "num" => "2", "nombre" => "Ondansetron", "dosis" => "2 mg/mL", "forma" => "Líquidos parenterales", "via" => "IV"],
        ["codigo" => "A04AA02", "num" => "3", "nombre" => "Granisetron", "dosis" => "1 mg", "forma" => "Sólidos orales", "via" => "VO"],
        ["codigo" => "A04AA02", "num" => "4", "nombre" => "Granisetron", "dosis" => "1 mg/mL", "forma" => "Líquidos parenterales", "via" => "IV"],
        ["[" => "R06AA11", "num" => "5", "nombre" => "Dimenhidrinato", "dosis" => "50 mg", "forma" => "Sólidos orales", "via" => "VO"],
        ["codigo" => "R06AA11", "num" => "6", "nombre" => "Dimenhidrinato", "dosis" => "50 mg/mL", "forma" => "Líquidos parenterales", "via" => "IM/IV"]
    ]));

    // Construimos la tabla de medicamentos en una variable HTML
    $html = "<h2>Listado de Medicamentos</h2>";
    $html .= "<table border='1' cellpadding='8' cellspacing='0' style='border-collapse: collapse; font-family: Arial, sans-serif;'>";
    $html .= "<tr style='background-color: #e3f2fd;'>
                <th>Código</th>
                <th>№</th>
                <th>Nombre</th>
                <th>Dosis</th>
                <th>Forma farmacéutica</th>
                <th>Vía de administración</th>
              </tr>";

    // Ciclo foreach para iterar y mostrar los medicamentos uno por uno
    foreach ($medicamentos as $med) {
        $html .= "<tr>
                    <td>{$med->codigo}</td>
                    <td>{$med->num}</td>
                    <td>{$med->nombre}</td>
                    <td>{$med->dosis}</td>
                    <td>{$med->forma}</td>
                    <td>{$med->via}</td>
                  </tr>";
    }

    $html .= "</table>";

    // Retornamos el HTML al navegador
    return $html;
});

/*
|--------------------------------------------------------------------------
| PARTE 1: EJERCICIOS 1 Y 2
|--------------------------------------------------------------------------
*/

// Ejercicio 1: Catálogo de Clientes VIP
Route::get('/clientes/vip', function () {
    // 1. Arreglo de objetos clientes
    $clientes = [
        (object) ['id' => 1, 'nombre' => 'Carlos Mendoza', 'telefono' => '7766-5544', 'puntos_altruistas' => 150],
        (object) ['id' => 2, 'nombre' => 'Ana Gutiérrez', 'telefono' => '2233-4455', 'puntos_altruistas' => 320],
        (object) ['id' => 3, 'nombre' => 'Roberto Tobar', 'telefono' => '7111-2223', 'puntos_altruistas' => 95],
    ];

    // 2. Estructura con el diseño exacto de la captura de pantalla
    $html = '<table border=1 cellspacing=0>
                <thead>
                    <tr>
                        <th>ID CLIENTE</th>
                        <th>NOMBRE</th>
                        <th>TELEFONO</th>
                        <th>PUNTOS ACUMULADOS</th>
                    </tr>
                </thead>
                <tbody>';

    // 3. Recorrer los objetos de forma limpia
    foreach ($clientes as $cliente) {
        $html .= "<tr>
                    <td>{$cliente->id}</td>
                    <td>{$cliente->nombre}</td>
                    <td>{$cliente->telefono}</td>
                    <td>{$cliente->puntos_altruistas}</td>
                  </tr>";
    }

    $html .= '</tbody>
            </table>';

    // 4. Imprimir con un solo echo
    echo $html;
});


// Ejercicio 2: Panel de Proveedores Internacionales
Route::get('/proveedores/internacionales', function () {
    // 1. Colección de objetos proveedores
    $proveedores = [
        (object) ['empresa' => 'PharmaEurope', 'pais_origen' => 'Alemania', 'medicamento_principal' => 'Amoxicilina', 'tiempo_entrega_dias' => 12],
        (object) ['empresa' => 'LatamMeds', 'pais_origen' => 'Colombia', 'medicamento_principal' => 'Ibuprofeno', 'tiempo_entrega_dias' => 8],
        (object) ['empresa' => 'AsiaHealth Co.', 'pais_origen' => 'India', 'medicamento_principal' => 'Paracetamol', 'tiempo_entrega_dias' => 22],
    ];

    // 2. Estructura de la tabla
    $html = '<table border=1 cellspacing=0>
                <thead>
                    <tr>
                        <th>EMPRESA</th>
                        <th>PAÍS DE ORIGEN</th>
                        <th>MEDICAMENTO PRINCIPAL</th>
                        <th>TIEMPO DE ENTREGA (DÍAS)</th>
                    </tr>
                </thead>
                <tbody>';

    // 3. Recorrer aplicando la advertencia de demora
    foreach ($proveedores as $proveedor) {
        $tiempoTexto = $proveedor->tiempo_entrega_dias;
        
        if ($proveedor->tiempo_entrega_dias > 15) {
            $tiempoTexto .= " <strong>(Demora Crítica)</strong>";
        }

        $html .= "<tr>
                    <td>{$proveedor->empresa}</td>
                    <td>{$proveedor->pais_origen}</td>
                    <td>{$proveedor->medicamento_principal}</td>
                    <td>{$tiempoTexto}</td>
                  </tr>";
    }

    $html .= '</tbody>
            </table>';

    // 4. Imprimir el bloque
    echo $html;
});
// Ejercicio 3: Inventario Automatizado de Lotes de Medicamentos
Route::get('/lotes/inventario', function () {
    // 1. Arreglo de objetos que representa los lotes de la farmacia
    $lotes = [
        (object) ['codigo_lote' => 'LOTE-A10', 'nombre_medicamento' => 'Insulina Glargina', 'cantidad_cajas' => 50, 'temperatura_requerida_celsius' => 4],
        (object) ['codigo_lote' => 'LOTE-B22', 'nombre_medicamento' => 'Loratadina', 'cantidad_cajas' => 120, 'temperatura_requerida_celsius' => 22],
        (object) ['codigo_lote' => 'LOTE-C05', 'nombre_medicamento' => 'Vacuna Influenza', 'cantidad_cajas' => 30, 'temperatura_requerida_celsius' => 5],
    ];

    // 2. Estructura de la tabla con el estilo exacto del profesor
    $html = '<table border=1 cellspacing=0>
                <thead>
                    <tr>
                        <th>CÓDIGO DE LOTE</th>
                        <th>MEDICAMENTO</th>
                        <th>CANTIDAD (CAJAS)</th>
                        <th>TEMPERATURA REQUERIDA</th>
                    </tr>
                </thead>
                <tbody>';

    // 3. Recorrer y evaluar la temperatura para añadir la etiqueta [Requiere Cadena de Frío]
    foreach ($lotes as $lote) {
        $nombreMedicamento = $lote->nombre_medicamento;

        // Si la temperatura es menor o igual a 5°C
        if ($lote->temperatura_requerida_celsius <= 5) {
            $nombreMedicamento .= " <span style='color: blue; font-weight: bold;'>[Requiere Cadena de Frío]</span>";
        }

        $html .= "<tr>
                    <td>{$lote->codigo_lote}</td>
                    <td>{$nombreMedicamento}</td>
                    <td>{$lote->cantidad_cajas}</td>
                    <td>{$lote->temperatura_requerida_celsius}°C</td>
                  </tr>";
    }

    // 4. Cerrar la tabla
    $html .= '</tbody>
            </table>';

    // 5. Imprimir el contenido final
    echo $html;
});