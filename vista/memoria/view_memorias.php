<h2>{TABLA}</h2>
<table style="text-align:center" cellpadding="0" cellspacing="0" border="0" class="display" id="dataTable"></table>

<script type="text/javascript">

	$(document).ready(function(event){
		$.ajax({
			url : 'metodos_ajax.php',
			method: 'post',
			data:{ clase: '{TABLA}',
				   metodo: 'listarCorrecto',
				   tipo: 'json'},
			dataType: 'json',
			success : function(data){
				var dataTable = $("#dataTable").dataTable({
   			 		"destroy" : true,
   			 		"bJQueryUI" : true,
					"aaData" : data,
					"aoColumns" :[
						{ "sTitle" : "Marca" , "mData" : "marca"},
						{ "sTitle" : "Tipo" , "mData" : "tipo"},
						{ "sTitle" : "Capacidad" , "mData" : "capacidad"},
						{ "sTitle" : "Velocidad (Mhz)" , "mData" : "velocidad"},
						{ "sTitle" : "Sector" , "mData" : "sector"},
						{ "sTitle" : "Usuario" , "mData" : "nombre_apellido"},						
						{ "sTitle" : "Cpu" , "mData" : "cpu_serie"},
						{ "sTitle": "Action", "mData" : "m" , "sDefaultContent":
										'<a class="ventana_area " href="">Modificar</a>'}
						]
    			})
			}
		});
	});

	$("#contenedorPpal").on('click' , '#modificar_sector_memoria' , function(){

			console.log("Entro a modificar sector de la memoria");
			console.log("id_memoria: "+$(this).attr("id_memoria"));
			var id_memoria = $(this).attr("id_memoria");
			$.post( "vista/dialog_content.php",
				{
					TablaPpal : "Memorias",
					ID : id_memoria,
					select_Areas : "Areas", //Clase de la cual quiero sacar el select
					queSos : "memoria", //a quien le voy a generar la vista
					action : "modif_sector"
				}, function(data){
					jQuery('<div/>', {
				    id: 'dialogcontent_memoria',
				    text: 'Texto por defecto!'
				}).appendTo('#contenedorPpal');
					$("#dialogcontent_memoria").html(data);
					$("#dialogcontent_memoria").dialog({
												show: {
												effect: "explode",
												duration: 200,
												modal:true
												},
												hide: {
												effect: "explode",
												duration: 200
												},
												width : 350,
												height : 360,
												close : function(){
													$(this).dialog("destroy").empty();
													$("#dialogcontent_memoria").remove();
												},
												buttons :
							                    {
							                        "Cancelar" : function () {
							                            $(this).dialog("destroy").empty();
							                            $("#dialogcontent_memoria").remove();
							                        },
							                        "Aceptar" : function(){
							                        	$("#form_memoria_mod_sector").submit();
							                        }
							                    }
					});
				}
			);
	});

	$("#contenedorPpal").on('click' , '#modificar_usuario_memoria' , function(){

		console.log("Entro a modificar usuario de la memoria");
		console.log("id_memoria: "+$(this).attr("id_memoria"));
		var id_memoria = $(this).attr("id_memoria");
		$.post( "vista/dialog_content.php",
			{
				TablaPpal : "Memorias",
				ID : id_memoria,
				select_Areas : "Areas", //Clase de la cual quiero sacar el select
				queSos : "memoria", //a quien le voy a generar la vista
				select_Computadoras : "Computadoras",
				action : "modif_usuario"
			}, function(data){
				jQuery('<div/>', {
				    id: 'dialogcontent_memoria',
				    text: 'Texto por defecto!'
				}).appendTo('#contenedorPpal');
				$("#dialogcontent_memoria").html(data);
				$("#dialogcontent_memoria").dialog({
											show: {
											effect: "explode",
											duration: 200,
											modal:true
											},
											hide: {
											effect: "explode",
											duration: 200
											},
											width : 350,
											height : 260,
											close : function(){
												$(this).dialog("destroy").empty();
												$("#dialogcontent_memoria").remove();
											},
											buttons :
						                    {
						                        "Cancelar" : function () {
						                            $(this).dialog("destroy").empty();
						                            $("#dialogcontent_memoria").remove();
						                        },
						                        "Enviar" : function(){
						                        	$("#form_memoria_mod_usuario").submit();
						                        }
						                    }
				});
			}
		);
	});
</script>