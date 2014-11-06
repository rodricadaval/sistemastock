
<h3>{titulo}</h3><p>Seleccione la marca y modelo del monitor</p>

<div class="combo_boxes">
<table style="text-align:center" cellpadding="0" cellspacing="0" border="0" class="display" id="tabla_agregar"></table>
	<div id="selects">
	<tr>
            <th>Marca: </th>
    </tr>
    <tr>
            <td>{select_marcas}</td>
    </tr>
    <tr>
    	<td>Modelo:</td>
    	<td><select id='select_modelos' name='modelos'>
    				<option value='0'>Seleccionar</option></select></td>
    	</td>
    	<td>Deposito:</td>
    	<td><select id='select_areas' name='depositos'>
    				<option value=''>Seleccionar</option></select>
    	</td>
    	<td>Nro de Serie:</td>
    	<td><input class="input_nro_serie" type="text" name="nro_de_serie"</td>
    </tr>
    </div>
    <div id="agregar"><input class="boton_agregar_monitor" type="button" name="crearMonitor" value="Crear"</div>
</table>
</div>

<script type="text/javascript">
	$(document).ready(function(event){

	$("#select_marcas").on('change',function(){

		console.log("Evento de seleccion de modelos");

		$.post('controlador/ProductosController.php',
			{
				value : $('#select_marcas option:selected').val(),
				tipo : "sel_modelos",
				action : "view_agregar_monitor"

			}, function(data) {
			$("#select_modelos").replaceWith(data);
		});
			$.post('controlador/ProductosController.php',
			{
				value : $('#select_marcas option:selected').val(),
				tipo : "sel_depositos",
				action : "view_agregar_monitor"

			}, function(data) {
			$("#select_areas").replaceWith(data);
			});
	});

	$("#agregar").on('click',function(){
		console.log('Evento de click en crear');

		var id_marca = $('#select_marcas option:selected').val();
		var id_deposito = $('#select_areas option:selected').val();
		var modelo = $('#select_modelos option:selected').val();
		var nro_de_serie = $('.input_nro_serie').val();

		if(id_deposito == ""){
			alert('Debes ingresar algún deposito!');

			$("#tabs1").load("controlador/ProductosController.php",{action:"view_agregar_monitor",tipo:"sel_marcas"});
		}
		else if(nro_de_serie != ""){

		$.ajax({
			url: 'controlador/CreacionController.php',
			type: 'POST',
			data: {id_marca: id_marca,
				   id_deposito: id_deposito,
				   modelo: modelo,
				   num_serie: nro_de_serie,
				   tipo: "Monitor"},
		})
		.done(function(resultado) {
			console.log(resultado);
			console.log("success");
			alert("Se ha agregado el producto a la base de datos.");

		})
		.fail(function() {
			console.log("error");
		})
		.always(function() {
			console.log("complete");
		});
		}
		else{alert('Debes ingresar el Numero de serie!');

			$("#tabs1").load("controlador/ProductosController.php",{action:"view_agregar_monitor",tipo:"sel_marcas"});}

	});
});
</script>