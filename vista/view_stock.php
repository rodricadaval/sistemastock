<table style="text-align:center" cellpadding="0" cellspacing="0" border="0" class="display" id="dataTable"></table>

<script type="text/javascript">

	$(document).ready(function(event){
		$.ajax({
			url : 'metodos_ajax.php',
			method: 'post',
			data:{ clase: '{TABLA}',
					metodo: 'listarTodos'},
			dataType: 'json',
			success : function(data){
				$("#dataTable").dataTable({
   			 		"destroy" : true,
					"aaData" : data,
					"aoColumns" :[
						{ "sTitle" : "Insumo" , "mData" : "insumo"},
						{ "sTitle" : "Marca" , "mData" : "marca"},
						{ "sTitle" : "Deposito" , "mData" : "deposito"},
						{ "sTitle" : "Area_ID" , "mData" : "area"},
						{ "sTitle" : "Cantidad" , "mData" : "cantidad"},
						{ "sTitle" : "Descripcion" , "mData" : "descripcion"},
						]
    			})
			}

		});
	});

</script>