<div id="nuevo_usuario">
<input style="float:right;margin-bottom:10px;" type="button" id="crear_usuario" value="Crear Usuario">
</div>

<table style="text-align:center" cellpadding="0" cellspacing="0" border="0" class="display" id="dataTable"></table>
<div id="dialogcontent" title="Modificar Usuario">

  <p>All form fields are required.</p>
  
</div>

<script type="text/javascript">

	$(document).ready(function(event){
		var url;
			       		$.ajax({
							url : 'metodos_ajax.php',
							method: 'post',
							data:{ clase: '{TABLA}',
									metodo: 'listarTodos'},
							dataType: 'json',
							success : function(data){
								$.get('logueo/check_priority.php', function(permisos) {
			     
			    					if( permisos == 1 || permisos == 3) {
										$("#dataTable").dataTable({
						   			 		"destroy" : true,
						   			 		"bJQueryUI" : true,
											"aaData" : data,
											"aoColumns" :[
												{ "sTitle" : "ID" , "mData" : "id_usuario"},
												{ "sTitle" : "Usuario" , "mData" : "usuario"},
												{ "sTitle" : "Permisos" , "mData" : "permisos"},
												{ "sTitle" : "Nombre" , "mData" : "nombre_apellido"},
												{ "sTitle" : "Pass" , "mData" : "password"},
												{ "sTitle" : "Area" , "mData" : "area"},
												{ "sTitle" : "Email" , "mData" : "email"},
												{ "sTitle": "Action", "mData" : "m" , "sDefaultContent":
												'<a class="ventana_usuario " href="#">Modificar</a>'}
							  					]
						    			})
									}
									else if (permisos == 2) {
										$("#dataTable").dataTable({
						   			 		"destroy" : true,
						   			 		"bJQueryUI" : true,
											"aaData" : data,
											"aoColumns" :[
												{ "sTitle" : "Usuario" , "mData" : "usuario"},
												{ "sTitle" : "Permisos" , "mData" : "permisos"},
												{ "sTitle" : "Nombre" , "mData" : "nombre_apellido"},
												{ "sTitle" : "Area" , "mData" : "area"},
												{ "sTitle" : "Email" , "mData" : "email"}
											]
						    			})
									}
								});
							}
						});
});

//$('#dataTable tbody tr').find('td:eq(7)').live('click', function () {
	$("#contenedorPpal").on('click' , '.modificar' , function(){

		console.log($(this).attr("id_usuario"));
  		
  		var id_usuario = $(this).attr('id_usuario');

		$.post( "vista/dialog_content.php", 
			{ 
				TablaPpal : "Usuarios",
				ID : id_usuario,
				select_Areas : "Areas",	//Clase de la cual quiero obtener el select
				select_Permisos : "Permisos", //Clase de la cual quiero sacar el select
				queSos : "usuario" //a quien le voy a generar la vista

			}, function(data){
				$("#dialogcontent").html(data);
				$("#dialogcontent").dialog("open");
			});
});

	$("#nuevo_usuario").on('click' , '#crear_usuario' , function(){

		$.post( "vista/dialog_content.php", 
			{ 
				TablaPpal : "Usuarios",
				select_Areas : "Areas",	//Clase de la cual quiero obtener el select
				select_Permisos : "Permisos", //Clase de la cual quiero sacar el select
				queSos : "nuevo" //a quien le voy a generar la vista

			}, function(data){
				$("#dialogcontent").html(data);
				$("#dialogcontent").dialog("open");
			});
});

$( "#dialogcontent" ).dialog({
      autoOpen: false,
      show: {
        effect: "blind",
        duration: 1000,
        width: 1000,
        modal:true
      },
      hide: {
        effect: "explode",
        duration: 200
      }
});
</script>