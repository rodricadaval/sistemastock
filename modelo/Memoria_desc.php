<?php

class Memoria_desc {

	public static function claseMinus() {
		return strtolower(get_class());
	}

	public function listarTodos() {

		$inst_table = BDD::getInstance()->query("select * from system." . self::claseMinus());
		$i = 0;
		while ($fila = $inst_table->_fetchRow()) {
			foreach ($fila as $campo => $valor) {
				$data[$i][$campo] = $valor;
			}
			$i++;
		}
		echo json_encode($data);
	}

	public function dameDatos($id) {
		$fila = BDD::getInstance()->query("select * from system." . self::claseMinus() . " where id_memoria_desc = '$id' ")->_fetchRow();
		foreach ($fila as $campo => $valor) {
			if ($campo == "id_marca") {
				$fila['marca'] = Marcas::getNombre($valor);
			} else {
				$fila[$campo] = $valor;
			}
		}
		return $fila;
	}

	public function dameSelect( $sos = "", $valor = "") {
		if ($valor == "") {
			$table = BDD::getInstance()->query("select distinct tipo from system." . self::claseMinus() . " where estado = 1");
		} else {
			$table = BDD::getInstance()->query("select distinct tipo from system." . self::claseMinus() . " where id_marca = '$valor' AND estado = 1");
		}

		if ($sos != "") {
			$html_view = "<select id='select_tipos" . $sos . "' name='tipo_mem'>";

		} else {
			$html_view = "<select id='select_tipos' name='tipo_mem'>";

		}

		while ($fila = $table->_fetchRow()) {
			$html_view = $html_view . "<option value=" . $fila['tipo'] . ">" . $fila['tipo'] . "</option>";
		}

		$html_view = $html_view . "</select>";
		return $html_view;

	}

	public function buscar_id_por_marca_y_tipo($id_marca, $tipo) {
		return BDD::getInstance()->query("SELECT id_memoria_desc FROM system.memoria_desc where id_marca ='$id_marca' AND tipo='$tipo' ")->_fetchRow()['id_memoria_desc'];
	}
}
?>