
<?php

class Computadora_desc {

	public static function claseMinus()
	{
		return strtolower(get_class());
	}

	public function getSlots($num)
	{
		$fila = BDD::getInstance()->query("select slots from system.". self::claseMinus()." where id_computadora_desc = '$num' ")->_fetchRow();
		if (isset($fila) && $fila != "")
		{
			return $fila['slots'];
		}
		else
		{
			return 0;
		}
	}

	public function getMemMax($num)
	{
		return BDD::getInstance()->query("select mem_max from system.". self::claseMinus()." where id_computadora_desc = '$num' ")->_fetchRow()['mem_max'];
	}

	public function listarTodos()
	{

		$inst_table = BDD::getInstance()->query("select * from system.". self::claseMinus()." where estado = 1");
		$i = 0;
		while ($fila = $inst_table->_fetchRow())
		{
			foreach ($fila as $campo => $valor)
			{
				$data[$i][$campo] = $valor;
			}
			$i++;
		}
		echo json_encode($data);
	}

	public function agregar_marca_y_modelo($datos)
	{
		$id_marca = $datos['id_marca'];
		$modelo   = $datos['modelo'];
		$slots    = $datos['slots'];
		$mem_max  = $datos['mem_max'];

		if (BDD::getInstance()->query("SELECT * FROM system.". self::claseMinus()." where id_marca = '$id_marca' AND modelo = '$modelo' ")->get_count() > 0)
		{
			return '"estaba"';
		}
		else if (BDD::getInstance()->query("INSERT INTO system.". self::claseMinus()." (id_marca,modelo,slots,mem_max) VALUES('$id_marca','$modelo','$slots','$mem_max') ")->get_error())
		{
			var_dump(BDD::getInstance());
			return "false";
		}
		else
		{
			return "true";
		}
	}

	public function borrar_marca_y_modelo($datos)
	{
		$id_marca = $datos['marca'];
		$modelo   = $datos['modelo'];

		if (BDD::getInstance()->query("DELETE FROM system.". self::claseMinus()." where id_marca = '$id_marca' AND modelo = '$modelo' ")->get_error())
		{
			var_dump(BDD::getInstance());
			return "false";
		}
		else
		{
			return "true";
		}
	}

	public function dameDatos($id)
	{
		$fila = BDD::getInstance()->query("select * from system.". self::claseMinus()." where id_computadora_desc = '$id' ")->_fetchRow();
		foreach ($fila as $campo => $valor)
		{
			if ($campo == "id_marca")
			{
				$fila['marca'] = Marcas::getNombre($valor);
			}
			else
			{
				$fila[$campo] = $valor;
			}
		}
		return $fila;
	}

	public function buscar_id_por_marca_modelo($id_marca, $modelo)
	{
		return BDD::getInstance()->query("SELECT id_computadora_desc FROM system.computadora_desc where id_marca ='$id_marca' AND modelo='$modelo' ")->_fetchRow()['id_computadora_desc'];
	}

	public function dameSelect($valor = "", $sos = "")
	{
		if ( ! isset($valor))
		{
			$table = BDD::getInstance()->query("select modelo from system.". self::claseMinus()." where estado = 1");
		}
		else
		{
			$table = BDD::getInstance()->query("select modelo from system.". self::claseMinus()." where id_marca = '$valor' AND estado = 1");
		}

		if ($sos != "")
		{
			$html_view = "<select id='select_modelos".$sos."' name='modelo'>";

		}
		else
		{
			$html_view = "<select id='select_modelos' name='modelo'>";
		}

		if (BDD::getInstance()->get_count() == 0)
		{
			$html_view = $html_view."<option value=''>No hay modelos</option>";
		}

		while ($fila = $table->_fetchRow())
		{

			$modeloReal = str_replace(' ', '.', $fila['modelo']);

			$html_view = $html_view."<option value=".$modeloReal.">".$fila['modelo']."</option>";
		}

		$html_view = $html_view."</select>";
		return $html_view;
	}

	public function dameSelectABorrar($valor = "")
	{
		if ( ! isset($valor))
		{
			$table = BDD::getInstance()->query("select modelo from system.". self::claseMinus()." where estado = 1");
		}
		else
		{
			$table = BDD::getInstance()->query("select modelo from system.". self::claseMinus()." where id_marca = '$valor' AND estado = 1");
		}
		$html_view = "<select id='select_modelos_a_borrar' name='modelo'>";

		if (BDD::getInstance()->get_count() == 0)
		{
			$html_view = $html_view."<option value=''>No hay modelos</option>";
		}

		while ($fila = $table->_fetchRow())
		{

			$modeloReal = str_replace(' ', '.', $fila['modelo']);

			$html_view = $html_view."<option value=".$modeloReal.">".$fila['modelo']."</option>";
		}

		$html_view = $html_view."</select>";
		return $html_view;
	}

}
?>