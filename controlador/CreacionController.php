<?php
require '../ini.php';

if (isset($_POST['tipo'])) {
	foreach ($_POST as $campo => $valor) {
		$datos[$campo] = $valor;
	}
	$tipo_productos = array();
	$tipo_productos = Tipo_productos::get_rel_campos();

	if (in_array($_POST['tipo'], $tipo_productos)) {
		foreach ($tipo_productos as $indice => $valor) {
			if ($valor == $_POST['tipo']) {
				$datos['id_tipo_producto'] = $indice;
			}
		}

		$metodo = "crearVinculo" . $_POST['tipo'];
		Consola::mostrar("Muestro los datos con los que voy a crear el Monitor y Vinculo");
		Consola::mostrar($datos);

		return Vinculos::$metodo($datos);
	}
}

?>
