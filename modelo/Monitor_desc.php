<?php

class Monitor_desc {

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
		$fila = BDD::getInstance()->query("select * from system." . self::claseMinus() . " where id_monitor_desc = '$id' ")->_fetchRow();
		foreach ($fila as $campo => $valor) {
			if ($campo == "id_marca") {
				$fila['marca'] = Marcas::getNombre($valor);
			} else {
				$fila[$campo] = $valor;
			}
		}
		return $fila;
	}

	public function dameSelects() {
		$marcas = new Marcas();
		$select_marcas = $marcas->dameSelect();

		$select_modelos = self::dameSelect();

		return $select_marcas . "<br><br>" . $select_modelos;
	}

	public function dameSelect($valor = "") {
		if (!isset($valor)) {
			$table = BDD::getInstance()->query("select modelo from system." . self::claseMinus() . " where estado = 1");
		} else {
			$table = BDD::getInstance()->query("select modelo from system." . self::claseMinus() . " where id_marca = '$valor' AND estado = 1");
		}

		$html_view = "<select id='select_modelos' name='modelos'>";

		while ($fila = $table->_fetchRow()) {

			$html_view = $html_view . "<option value=" . $fila['modelo'] . ">" . $fila['modelo'] . "</option>";
		}

		$html_view = $html_view . "</select>";
		return $html_view;
	}

	public function buscar_id_por_marca_modelo($id_marca, $modelo) {
		return BDD::getInstance()->query("SELECT id_monitor_desc FROM system.monitor_desc where id_marca ='$id_marca' AND modelo='$modelo' ")->_fetchRow()['id_monitor_desc'];
	}
}
?>