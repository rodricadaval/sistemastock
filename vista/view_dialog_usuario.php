<head>
<style>
.login_result { border: 1px solid transparent; padding: 0.3em; color: red; }
</style>
</head>
<body>
<form id="form">
    <table class="mytable">
        <tr>
          <td colspan="2"><div class="login_result" id="login_result"><div style="color:green;"> Chequeo de estado</div></div></td>
        </tr>
        <tr>
          <td>Nombre</td>
          <td><input type="text" name="nombre_apellido" id="nombre_apellido" value="{nombre_apellido}"></td>
        </tr>
        <tr>
          <td>Usuario</td>
          <td><input type="text" name="usuario" id="usuario" value="{usuario}"></td>
        </tr>
        <tr>
          <td>Email</td>
          <td><input type="text" name="email" id="email" value="{email}"></td>
        </tr>     
        <tr>
          <td>Area</td>
          <td>{select_Areas}</td>
        </tr>
        <tr>
          <td>Permisos</td>
          <td>{select_Permisos}</td>
        </tr>
        <tr>
          <td>ID</td>
          <td><input style="background-color:#D3D3D3" type="text" name="id_usuario" id="id_usuario" value="{id_usuario}" readonly></td>
        </tr>
        <tr id="vista_pass">
          <td></td>
          <td><input type="button" id="cambiar_pass" name="boton" value="Cambiar Contraseña"></td> 
        </tr>
        </br>
        <tr>
          <td><input type="submit" id="submit" tabindex="-1"></td>
          <td></td>
        </tr>             
   </table>
</form>

<script>


  $(document).ready(function(){

    $('#nombre').focus();
    var login_result = $('.login_result'); // Get the login result div
    var usuario = $('#usuario');

    function updateTips( t ) {
      
     login_result.html(t);

        setTimeout(function() {
          login_result.removeClass( "ui-state-highlight", 1500 );
        }, 500 );
    }

    function multiline(text){
    return text.replace(/\n/g,'<br/>');
    }

    function includeTips( t ) {

        if(login_result.text() == "Chequeo de estado"){
          login_result.text(t);
        }
        else{
        var texto = multiline(login_result.text() + " \n " + t);
        login_result.html(texto);
        }

        setTimeout(function() {
            login_result.removeClass( "ui-state-highlight", 1500 );
          }, 500 );
    }

         function checkLength( o, n, min, max ) {
          if ( o.val().length > max || o.val().length < min ) {
             includeTips( "La longitud de " + n + " de debe estar entre " +
             min + " y " + max + "." );
            return false;
          } else {
            return true;
          }
      }

    var estado = "{nuevo}";  
    if(estado == 1){

      $.post( "vista/dialog_content.php", 
      { 
        id_usuario : "{id_usuario}",
      }
      );

      $.get("vista/agregar_datos_password_nueva.php",function(data){
        $("#vista_pass").replaceWith(data);
      });
    }

  });

    $('#usuario').on('input',function(){
        
        if(usuario.val() == ''){
            updateTips("El usuario no puede ser vacío");
        }
        else{

         var UrlToPass = 'action=chequeo&username='+usuario.val();
              $.ajax({ // Send the credential values to another checker.php using Ajax in POST menthod
              type : 'POST',
              data : UrlToPass,
              url  : 'checkDisponibilidad.php',
                success: function(responseText){ // Get the result and asign to each cases
                    if(responseText == 0){
                      updateTips("Usuario Disponible!");
                    }
                    else if(responseText == 1){
                      if(usuario.val() == "{usuario}"){
                        updateTips("No hay cambios");
                      }
                      else{
                      updateTips("Usuario en uso!");
                      }
                    }
                    else{
                      alert('Problem with Sql query');
                    }
                }
              });
        }
    });

    $('#submit').on('click',function(event){
      
      event.preventDefault();

      var usuario = $('#usuario');
      var password = $('#password');
      var nueva_password = $('#nueva_password');
      var conf_password = $('#conf_password');
      


      updateTips('');     

        login_result.html(''); // Set the pre-loader can be an animation

        if(usuario.val() == ''){
          updateTips("El usuario no puede ser vacío");
          usuario.val("{usuario}");
          return false;
        }
        
        else if(!checkLength(usuario,"usuario",3,20)){ // Check the username values is empty or not
          usuario.val("{usuario}");
        }

        console.log((password.val() == "{password}" && nueva_password.val() == conf_password.val() && checkLength(nueva_password,"Nueva Password",3,20)) || ( !password.val() && !nueva_password.val() && !conf_password.val()));

        if((password.val() == "{password}" && nueva_password.val() == conf_password.val() && checkLength(nueva_password,"Nueva Password",3,20)) || ( !password.val() && !nueva_password.val() && !conf_password.val())){

            console.log("ACA EMPIEZO A MODIFICAR LA BASE DE DATOS");
            
            var UrlToPass;

            console.log($("#form").serialize());

            UrlToPass = $("#form").serialize();

            UrlToPass+="&action=modificar";

            console.log(UrlToPass);

                $.ajax({
                  type : 'POST',
                  data : UrlToPass,
                  url  : 'controlador/UsuariosController.php',
                    success: function(responseText){ // Get the result and asign to each cases
                        if(responseText == 0){
                          updateTips("No se pudieron plasmar los datos. Error de en la Base de datos.");
                        }
                        else if(responseText == 1){
                          alert("Los datos han sido actualizados correctamente!");
                          $("#dialogcontent").dialog("close");
                          $("#contenedorPpal").load("controlador/UsuariosController.php");
                        }
                        else{
                          alert('Problema en la Sql query');
                        }
                    }
                  });
        }

        else{ 
              if(password.val() != "{password}" || nueva_password.val() != conf_password.val()){
              includeTips("La password actual no es tal o las nuevas passwords son distintas");
              }
             
             password.val("");
             nueva_password.val("");
             conf_password.val("");
        }

       });

   $("#cambiar_pass").on('click',function(){

    $.get("vista/agregar_datos_password.php",function(data){
      $("#vista_pass").replaceWith(data);
    })
   });

</script>
</body>