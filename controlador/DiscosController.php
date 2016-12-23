<?php
require_once "../ini.php";

if (isset($_POST['action']))
{
	$inst_disco = new Discos();
	$inst_vinc  = new Vinculos();

	switch ($_POST['action'])
	{
		case 'modificar':
			unset($_POST['action']);
			$_POST['id_usuario'] = Usuarios::getIdByNombre($_POST['nombre_usuario']);
			if (isset($_POST['asing_usr']) && $_POST['asing_usr'] == "yes")
		{
				$_POST['id_cpu'] = $_POST['id_computadora'];
				unset($_POST['id_computadora']);
				unset($_POST['asing_usr']);
				echo $inst_vinc->modificarDatos($_POST);
			}
		else if (isset($_POST['asing_cpu']) && $_POST['asing_cpu'] == "yes")
		{
				$_POST['id_cpu'] = $_POST['id_computadora'];
				unset($_POST['id_computadora']);
				unset($_POST['asing_cpu']);
				echo $inst_vinc->cambiarCpu($_POST);
			}
		else if (isset($_POST['asing_sector']) && $_POST['asing_sector'] == "yes")
		{
				unset($_POST['asing_sector']);
				$_POST['id_sector'] = $_POST['area'];
				unset($_POST['area']);
				echo $inst_vinc->cambiarSector($_POST);
			}
		else
		{
				$_POST['id_cpu'] = Computadoras::getIdBySerie($_POST['cpu_serie']);
				unset($_POST['cpu_serie']);
				unset($_POST['nombre_usuario']);
				echo $inst_vinc->modificarDatos($_POST);
			}
			break;

		case 'asignar':
			unset($_POST['action']);
			$id_cpu = $_POST['id_computadora'];
			$id_disco = $_POST['id_disco'];

			$datosComputadora = Computadoras::getConSectorById($id_cpu);
			$datosDisco = Discos::dameDatos($id_disco);			
			$id_vinculo_disco = $datosDisco['id_vinculo'];

			$inst_vinc->cambiarUsuarioYSector(
				array(
					"id_vinculo" => $id_vinculo_disco,
					"id_usuario" => $datosComputadora['id_usuario'],
					"id_sector" => $datosComputadora['id_sector']
					)
				);

			$inst_vinc->cambiarCpu(
				array(
					"id_vinculo" => $id_vinculo_disco,
					"id_cpu" => $id_cpu
					)
				);			
			unset($_POST['id_computadora']);
			unset($_POST['id_disco']);
			echo "Logre asignalo";
			break;

		case 'eliminar':
			unset($_POST['action']);
			echo $inst_disco->eliminarLogico($_POST);
			break;

		case 'liberar':
			unset($_POST['action']);
			echo $inst_disco->liberar($_POST['id_disco']);
			break;

		default:
			# code...
			break;
	}
}
else
{
	$archivos   = array("vista/disco/view_discos.php");
	$parametros = array("TABLA" => "Discos", "");
	echo Disenio::HTML($archivos, $parametros);
}
?>