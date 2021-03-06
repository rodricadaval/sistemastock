<div class="ui one column grid">
	<div class="column">
		<div class="ui raised segment">
			<a class="ui teal ribbon label">{TABLA}</a>
			<table  cellpadding="0" cellspacing="0" border="0" class="display" id="dataTable"></table>
		</div>
	</div>
</div>

<script type="text/javascript">

	$(document).ready(function(event){

		cargando ();


		$.ajax({
			url : 'metodos_ajax.php',
			method: 'post',
			data:{ clase: '{TABLA}',
				   metodo: 'listarCorrecto',
				   tipo: 'json'},
			dataType: 'json',
			success : function(data){
				$.get('logueo/check_priority.php', function(permisos) {

					quitar_cargando ();

					if( permisos == 1 || permisos == 3) {
							var dataTable = $("#dataTable").dataTable({
			   			 		"destroy" : true,
								"aaData" : data,
								"iDisplayLength": 25,
								"aoColumns" :[
									//{ "sTitle" : "ID" , "mData" : "id_monitor"},
									{ "sTitle" : "Nro de Serie" , "mData" : "num_serie"},
									{ "sTitle" : "Marca" , "mData" : "marca"},
									{ "sTitle" : "Modelo" , "mData" : "modelo"},
									{ "sTitle" : "Pulgadas" , "mData" : "pulgadas"},
									{ "sTitle" : "Sector" , "mData" : "sector"},
									{ "sTitle" : "Cpu" , "mData" : "cpu_serie"},
									{ "sTitle" : "Usuario" ,"mDataProp": "nombre_apellido",
			              				"mRender": function ( data, type, row ) {
			  								return '<a id="ver_usuario" usuario="'+data+'" title="Ver productos de '+data+' "href="edit.php?usuario='+ data+'">'+data+'</a>';
										}
									},
									{ "sTitle": "Action", "mData" : "m" , "sDefaultContent":
													'<a class="ventana_area " href="">Modificar</a>'}
									],
								  "aoColumnDefs": [
							            { "sWidth": "20%", "aTargets": [ -1 ] }
							        ]
			    			})
						}
						else if (permisos == 2) {
							var dataTable = $("#dataTable").dataTable({
			   			 		"destroy" : true,
								"aaData" : data,
								"aoColumns" :[
									//{ "sTitle" : "ID" , "mData" : "id_monitor"},
									{ "sTitle" : "Nro de Serie" , "mData" : "num_serie"},
									{ "sTitle" : "Marca" , "mData" : "marca"},
									{ "sTitle" : "Modelo" , "mData" : "modelo"},
									{ "sTitle" : "Pulgadas" , "mData" : "pulgadas"},
									{ "sTitle" : "Sector" , "mData" : "sector"},
									{ "sTitle" : "Cpu" , "mData" : "cpu_serie"},
									{ "sTitle" : "Usuario" ,"mDataProp": "nombre_apellido",
			              				"mRender": function ( data, type, row ) {
			  								return '<a id="ver_usuario" usuario="'+data+'" title="Ver productos de '+data+' "href="edit.php?usuario='+ data+'">'+data+'</a>';
										}
									},
									],
								  "aoColumnDefs": [
							            { "sWidth": "20%", "aTargets": [ -1 ] }
							        ]
			    			})
						}
						else { window.location.href = "logueo/login.php";}
					});
			}
		});
	});


$("#contenedorPpal").on('click' , '#modificar_usuario_monitor' , function(){

		console.log("Entro a modificar usuario del monitor");
		console.log("id_monitor: "+$(this).attr("id_monitor"));
		var id_monitor = $(this).attr("id_monitor");
		$.post( "vista/dialog_content.php",
			{
				TablaPpal : "Monitores",
				ID : id_monitor,
				select_Areas : "Areas", //Clase de la cual quiero sacar el select
				queSos : "monitor", //a quien le voy a generar la vista
				select_Computadoras : "Computadoras",
				action : "modif_usuario",
				viene : "normal"
			}, function(data){
				jQuery('<div/>', {
				    id: 'dialogcontent_monitor',
				    text: 'Texto por defecto!'
				}).appendTo('#contenedorPpal');
				$("#dialogcontent_monitor").html(data);
				$("#dialogcontent_monitor").dialog({
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
											height : 350,
											close : function(){
												$(this).dialog("destroy");
												$("#dialogcontent_monitor").remove();
											},
											buttons :
						                    {
						                        "Cancelar" : function () {
						                            $(this).dialog("destroy");
						                            $("#dialogcontent_monitor").remove();
						                        },
						                        "Enviar" : function(){
						                        	$("#form_monitor_mod_usuario").submit();
						                        }
						                    }
				});
			}
		);
	});

	$("#contenedorPpal").on('click','#ver_usuario',function(event){
		event.preventDefault();
		console.log("Entro a ver los productos del usuario");
		console.log("usuario: "+$(this).attr("usuario"));
		var usuario = $(this).attr("usuario");

		$.post( "vista/dialog_productos_usuario.php",
				{
					usuario : usuario,
					action : "ver_productos"
				}, function(data){
					jQuery('<div/>', {
					    id: 'dialogcontent_prod_usuario',
					    text: 'Texto por defecto!'
					}).appendTo('#contenedorPpal');
					$("#dialogcontent_prod_usuario").html(data);
					$("#dialogcontent_prod_usuario").dialog({
												title: "Productos de "+usuario,
												show: {
												effect: "explode",
												duration: 200,
												modal:true
												},
												hide: {
												effect: "explode",
												duration: 200
												},
												width : 600,
												height : 630,
												close : function(){
													$(this).dialog("destroy");
													$("#dialogcontent_prod_usuario").remove();
												},
												buttons :
							                    {
							                        "Aceptar" : function () {
							                            $(this).dialog("destroy");
							                            $("#dialogcontent_prod_usuario").remove();
							                        }
							                    }
					});
				}
			);
	})

$("#contenedorPpal").on('click' , '#modificar_cpu_monitor' , function(){

		console.log("Entro a modificar cpu del monitor");
		console.log("id_monitor: "+$(this).attr("id_monitor"));
		var id_monitor = $(this).attr("id_monitor");
		$.post( "vista/dialog_content.php",
			{
				TablaPpal : "Monitores",
				ID : id_monitor,
				select_Areas : "Areas", //Clase de la cual quiero sacar el select
				queSos : "monitor", //a quien le voy a generar la vista
				select_Computadoras : "Computadoras",
				action : "modif_cpu",
				viene : "normal"
			}, function(data){
				jQuery('<div/>', {
				    id: 'dialogcontent_monitor',
				    text: 'Texto por defecto!'
				}).appendTo('#contenedorPpal');
				$("#dialogcontent_monitor").html(data);
				$("#dialogcontent_monitor").dialog({
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
											height : 330,
											close : function(){
												$(this).dialog("destroy");
												$("#dialogcontent_monitor").remove();
											},
											buttons :
						                    {
						                        "Cancelar" : function () {
						                            $(this).dialog("destroy");
						                            $("#dialogcontent_monitor").remove();
						                        },
						                        "Enviar" : function(){
						                        	$("#form_monitor_mod_cpu").submit();
						                        }
						                    }
				});
			}
		);
	});

	$("#contenedorPpal").on('click' , '#modificar_sector_monitor' , function(){

			console.log("Entro a modificar sector del monitor");
			console.log("id_monitor: "+$(this).attr("id_monitor"));
			var id_monitor = $(this).attr("id_monitor");
			$.post( "vista/dialog_content.php",
				{
					TablaPpal : "Monitores",
					ID : id_monitor,
					select_Areas : "Areas", //Clase de la cual quiero sacar el select
					queSos : "monitor", //a quien le voy a generar la vista
					action : "modif_sector",
					viene : "normal"
				}, function(data){
					jQuery('<div/>', {
				    id: 'dialogcontent_monitor',
				    text: 'Texto por defecto!'
				}).appendTo('#contenedorPpal');
					$("#dialogcontent_monitor").html(data);
					$("#dialogcontent_monitor").dialog({
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
													$(this).dialog("destroy");
													$("#dialogcontent_monitor").remove();
												},
												buttons :
							                    {
							                        "Cancelar" : function () {
							                            $(this).dialog("destroy");
							                            $("#dialogcontent_monitor").remove();
							                        },
							                        "Aceptar" : function(){
							                        	$("#form_monitor_mod_sector").submit();
							                        }
							                    }
					});
				}
			);
	});

$("#contenedorPpal").on('click' , '#desasignar_todo_monitor' , function(){

			console.log("Entro a desasignar todo del monitor");
			console.log("id_monitor: "+$(this).attr("id_monitor"));
			var id_monitor = $(this).attr("id_monitor");

			$.post( "vista/dialog_content.php",
				{
					TablaPpal : "Monitores",
					ID : id_monitor,
					queSos : "monitor", //a quien le voy a generar la vista
					action : "liberar",
					viene : "normal"
				}, function(data){
					jQuery('<div/>', {
				    id: 'dialogcontent_monitor',
				    text: 'Texto por defecto!'
				}).appendTo('#contenedorPpal');
					$("#dialogcontent_monitor").html(data);
					$("#dialogcontent_monitor").dialog({
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
												height : 220,
												close : function(){
													$(this).dialog("destroy");
													$("#dialogcontent_monitor").remove();
												},
												buttons :
							                    {
							                        "Cancelar" : function () {
							                            $(this).dialog("destroy");
							                            $("#dialogcontent_monitor").remove();
							                        },
							                        "Aceptar" : function(){
							                        		$("#liberar_monitor").submit();
													}
							                    }
					});
				}
			);
		});


	$("#contenedorPpal").on('click' , '#eliminar_monitor' , function(){

		console.log("Entro a eliminar monitor");
		console.log("id_monitor: "+$(this).attr("id_monitor"));
		var id_monitor = $(this).attr("id_monitor");

		$.post( "vista/dialog_content.php",
				{
					TablaPpal : "Monitores",
					ID : id_monitor,
					queSos : "monitor", //a quien le voy a generar la vista
					action : "eliminar",
					viene : "normal"
				}, function(data){
					jQuery('<div/>', {
				    id: 'dialogcontent_monitor',
				    text: 'Texto por defecto!'
				}).appendTo('#contenedorPpal');
					$("#dialogcontent_monitor").html(data);
					$("#dialogcontent_monitor").dialog({
												title: "Motivo de baja",
												show: {
												effect: "explode",
												duration: 200,
												modal:true
												},
												hide: {
												effect: "explode",
												duration: 200
												},
												width : 300,
												height : 280,
												close : function(){
													$(this).dialog("destroy");
													$("#dialogcontent_monitor").remove();
												},
												buttons :
							                    {
							                        "Cancelar" : function () {
							                            $(this).dialog("destroy");
							                            $("#dialogcontent_monitor").remove();
							                        },
							                        "Aceptar" : function(){
							                        		$("#form_detalle_eliminar_monitor").submit();
													}
							                    }
					});
				}
			);


	});

</script>