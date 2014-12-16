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
						//{ "sTitle" : "ID" , "mData" : "id_monitor"},
						{ "sTitle" : "Nro de Serie" , "mData" : "num_serie"},
						{ "sTitle" : "Marca" , "mData" : "marca"},
						{ "sTitle" : "Modelo" , "mData" : "modelo"},
						{ "sTitle" : "Pulgadas" , "mData" : "pulgadas"},
						{ "sTitle" : "Sector" , "mData" : "sector"},
						{ "sTitle" : "Usuario" , "mData" : "usuario"},
						{ "sTitle" : "Cpu" , "mData" : "cpu_serie"},
						{ "sTitle": "Action", "mData" : "m" , "sDefaultContent":
										'<a class="ventana_area " href="">Modificar</a>'}
						]
    			})
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
				action : "modif_usuario"
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
											height : 260,
											close : function(){
												$(this).dialog("destroy").empty();
												$("#dialogcontent_monitor").remove();
											},
											buttons :
						                    {
						                        "Cancelar" : function () {
						                            $(this).dialog("destroy").empty();
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
				action : "modif_cpu"
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
												$(this).dialog("destroy").empty();
												$("#dialogcontent_monitor").remove();
											},
											buttons :
						                    {
						                        "Cancelar" : function () {
						                            $(this).dialog("destroy").empty();
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
					action : "modif_sector"
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
													$(this).dialog("destroy").empty();
													$("#dialogcontent_monitor").remove();
												},
												buttons :
							                    {
							                        "Cancelar" : function () {
							                            $(this).dialog("destroy").empty();
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
					action : "liberar"
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
												height : 200,
												close : function(){
													$(this).dialog("destroy").empty();
													$("#dialogcontent_monitor").remove();
												},
												buttons :
							                    {
							                        "Cancelar" : function () {
							                            $(this).dialog("destroy").empty();
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
					action : "eliminar"
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
													$(this).dialog("destroy").empty();
													$("#dialogcontent_monitor").remove();
												},
												buttons :
							                    {
							                        "Cancelar" : function () {
							                            $(this).dialog("destroy").empty();
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