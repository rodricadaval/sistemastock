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
				$.get("logueo/check.php", function(answer){
     					if(answer == 1 || answer == 3){
							$("#dataTable").dataTable({
			   			 		"destroy" : true,
								"aaData" : data,
								"aoColumns" :[
									{ "sTitle" : "ID" , "mData" : "id_deposito"},
									{ "sTitle" : "Deposito" , "mData" : "nombre"},
									{ "mData" : "id_deposito" , "mRender": function(data, type, row) {
									  			return '<a class="btn btn-info btn-sm" href=vista/editar_deposito.php?' +'id_deposito=' + data + '>' + 'Modificar' + '</a>';
			  					  				 }					  
			  						}
			  					]
			    			})
						}
						else if(answer == 2){
							$("#dataTable").dataTable({
			   			 		"destroy" : true,
								"aaData" : data,
								"aoColumns" :[
									{ "sTitle" : "ID" , "mData" : "id_deposito"},
									{ "sTitle" : "Deposito" , "mData" : "nombre"},
			  					]
			    			})
						}
 				});
			}

		});
	});

</script>