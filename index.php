<?php
require_once 'ini.php';
require_once 'config.php';
include 'logueo/chequeo_login.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" content="text/html" http-equiv="Content-Type">
        <script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
        <script src="//cdn.datatables.net/1.10.2/js/jquery.dataTables.min.js"></script>
        <script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
        <script src="lib/jquery.hashchange.js" type="text/javascript"></script>
        <script src="lib/jquery.validate.js" type="text/javascript"></script>
        <script src="lib/semantic.js" type="text/javascript"></script>
        <script src="lib/bootstrap.js" type="text/javascript"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.blockUI/2.66.0-2013.10.09/jquery.blockUI.min.js"></script>
        <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css">
        <link href="//cdn.datatables.net/1.10.2/css/jquery.dataTables.min.css" rel=
        "stylesheet" type="text/css">
        <link href="css/semantic.css" rel="stylesheet" type="text/css">
        <link href="css/styles.css" rel="stylesheet" type="text/css">
        <link href="//code.jquery.com/ui/1.11.1/themes/smoothness/jquery-ui.css"
        rel="stylesheet">

            <title>Inicio</title>
            </head>
            <body>
                <div class="header">
                    <h1>Bienvenido
                    <b><?php echo ucfirst($_SESSION['username']);?></b><span class=
                    "logout" id="logout">Desconectarse</span></h1>
                </div>
                <div class="realBody">
<?php require_once TEMPLATES.'/panel_izq.html';?>
                <br>
                <div id="contenedorPpal"></div>
            	</div>
                <script type="text/javascript">

                    $.validator.addMethod("notEqual", function(value, element, param) {
                     return this.optional(element) || value != param;
                    });

                    $.validator.addMethod("sinCpu",function (value,element){
                     return value!=1;
                    }, 'El usuario no tiene Cpu.');

                    $.validator.addMethod('IP4Checker', function(value) {
                        var ip = "^(([0-9]|[1-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])\.){3}([0-9]|[1-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])$";
                        if(value == ""){
                            return true;
                        }
                        else{
                            return value.match(ip);
                        }
                    }, 'Invalid IP address');

	                $("#logout").on('click',function(){
		                $.ajax({
			                url : 'logueo/logout.php',
			                method: 'get',
			                complete: function(){window.location = "logueo/login.php"}
			            });
		            });
                    var primeraVez = true;
                    $("div.tab-lateral li.test a").on('click',function(event){
	                	event.preventDefault();

                        if($(this).attr("href") == "mis_productos"){
                                console.log("Entro a ver los productos del usuario");


                                $.get('logueo/check_user_id.php', function(id) {
                                    console.log("usuario: "+id);
                                    var usuario = id;

                                    $("#contenedorPpal").remove();
                                    jQuery('<div/>', {
                                    id: 'contenedorPpal',
                                    text: ''
                                    }).appendTo('.realBody');

                                    $.post( "vista/dialog_productos_usuario.php",
                                        {
                                            usuario : usuario,
                                            action : "ver_productos"
                                        }, function(data){
                                            jQuery('<div/>', {
                                                id: 'dialogcontent_prod_usuario',
                                                text: ''
                                            }).appendTo('#contenedorPpal');
                                            $("#dialogcontent_prod_usuario").html(data);
                                            $("#dialogcontent_prod_usuario").dialog({
                                                                        title: "Mis Productos",
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
                                                                            $(this).dialog("destroy").empty();
                                                                            $("#dialogcontent_prod_usuario").remove();
                                                                        },
                                                                        buttons :
                                                                        {
                                                                            "Aceptar" : function () {
                                                                                $(this).dialog("destroy").empty();
                                                                                $("#dialogcontent_prod_usuario").remove();
                                                                            }
                                                                        }
                                            });
                                        }
                                    );

                                });
                        }
                        else{
                            if(primeraVez){
                                 $("#contenedorPpal").load($(this).attr("href"));
                                 primeraVez = false;
                            }
                            else{
                                $("#contenedorPpal").remove();
                                jQuery('<div/>', {
                                id: 'contenedorPpal',
                                text: 'Texto por defecto!'
                                }).appendTo('.realBody');
                                $("#contenedorPpal").load($(this).attr("href"));
                            }
                        }
               		});
	            </script>
            </body>
        </html>