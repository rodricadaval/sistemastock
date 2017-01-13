<form id="form_cambiar_usuario_tablet" autocomplete="off">
    <table class="t_monitor">
        <tr>
            <tr type="hidden">
               <td><input type="hidden" name="id_tablet" id="id_tablet" value="{id_tablet}"></td>
            </tr>
        <tr>
            <td>Usuario:</td>
            <td>
                   <div id="multiple-datasets">
                     <input name="nombre_usuario" id="nombre_usuario" class="typeahead" type="text" placeholder="Nombre de usuario" value="{nombre_apellido}">
                </div>
            </td>
            <td id="usuario" value=""></td>
        </tr>
        <tr>
          <td>Sector:</td>
          <td id="sector"><input type="hidden" name="sector">{sector}</td>
        </tr>
        <tr><td colspan="2"><div class="error text-error"></div></td></tr>
  </table>
</form>

<script>

$(document).ready(function(){

    $("#nombre_usuario").on('focus', function(){
         this.select();
     })


   	 $("#nombre_usuario").typeahead({
        source : function (query , process) {
            $.ajax({
                type         : 'post' ,
                data         : {
                term         : query
                } ,
                url          : 'lib/listado_usuarios.php' ,
                dataType     : 'json' ,
                success     : function (data) {
                    process (data);
                }
            })
        } ,
        minLength : 3,
        updater: function(obj) { console.log(obj);
                                if(obj != "Sin usuario"){
                                    console.log('Entre a cambiar el area');

                                    $.post('controlador/UsuariosController.php',
                                    {
                                        nombre_usuario : obj,
                                        action : "nombre_sector"

                                    }, function(nombre_sector) {
                                    		console.log("El area es: "+nombre_sector);
                                            $("#sector").text(nombre_sector);
                                    });
                                }
                                else{console.log("No entro");}
                                $("#error").hide();

                                return obj; }

    });

     $("#form_cambiar_usuario_tablet").validate({
        errorLabelContainer : ".error" ,
        wrapper : "li" ,
        onfocusout: false,
        onkeyup: false,
        onclick: false,
        onsubmit: true,
        rules : {
            nombre_usuario : {
                required : true,
                remote      : {
                    url     : 'lib/busca_usuario.php' ,
                    type     : 'post' ,
                    data     : {
                        nombre_usuario : function() {
                            return $("#nombre_usuario").val();
                        }
                    }
                },
                notEqual: "Sin usuario"
            }    
        } ,
        messages : {
            nombre_usuario : {
                remote : 'El usuario no existe',
                required: "El campo usuario es OBLIGATORIO",
                notEqual: "No se puede asignar a Sin usuario. Si quieres quitar el usuario LIBERA la tablet"
            }
        } ,
        submitHandler : function (form) {
          console.log ("Formulario OK");

            console.log($("#form_cambiar_usuario_tablet").serialize());
    
            var datosUrl = $("#form_cambiar_usuario_tablet").serialize();

            
            datosUrl += "&action=cambiar_usuario";
console.log(datosUrl);
            $.ajax({
                url: 'controlador/TabletsController.php',
                type: 'POST',
                data: datosUrl,
                success : function(response){
                    console.log(response);
                    if(response){
                        console.log(response);
                        alert("Los datos han sido actualizados correctamente. Tenga en cuenta que al cambiar de usuario se reemplazará automáticamente la tablet asignada por la del usuario elegido.");
                        $("#dialogcontent").dialog("destroy").empty();
                        $("#dialogcontent").remove();
                         $("#contenedorPpal").remove();
                        jQuery('<div/>', {
                        id: 'contenedorPpal',
                        text: 'Texto por defecto!'
                        }).appendTo('.realBody');
                    $("#contenedorPpal").load("controlador/TabletsController.php");
                    }
                    else{
                       alert("Error en la query.");
                    }
                }
            })
            .fail(function() {
                console.log("error");
                alert("Algo no se registro correctamente");
            })
            .always(function() {
                console.log("complete");
            })

        } ,
        invalidHandler : function (event , validator) {
          console.log(validator);
        }
    });
});

</script>