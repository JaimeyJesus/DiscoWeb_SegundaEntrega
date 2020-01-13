<!DOCTYPE html>
<html>
<head>
	<title>Archives Cloud</title>
    <meta charset="UTF-8">
    <meta   name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/vnd.microsoft.icon" href="web/img/favic.ico" sizes="64x64">
    <link   type="text/css" href="web/css/default.css" rel="stylesheet" />
    <link   type="text/css" href="web/css/Usuarios.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet"> 
    <link href="https://fonts.googleapis.com/css?family=Gelasio|Roboto&display=swap" rel="stylesheet"> 
    <link href="https://fonts.googleapis.com/css?family=Gelasio|Montserrat|Roboto|Rubik&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script type="text/javascript" src="web/js/jquery.js"></script>   
    <script type="text/javascript" src="web/js/validaciones.js"></script>
    <script type="text/javascript" src="web/js/funciones.js"></script>   
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
</head>
<body>
    <div id="header">
        <h1 id="titulo">Archives Cloud</h1>
    </div>
    <div id="container">        
        <div id="content">
            <?= $contenido ?>
            <footer class="page-footer font-small blue pt-4">
                <div class="container-fluid text-center text-md-left">
                    <div class="footer-copyright text-center py-3">
                        © 2020 Copyright: Diseñado y creado por Jesus Digón y Jaime Zaloña.
                        Iconos diseñados por <a href="https://www.flaticon.es/autores/freepik" title="Freepik">Freepik</a> from <a href="https://www.flaticon.es/" title="Flaticon">www.flaticon.es</a>
                    </div>
                </div>
            </footer>
        </div>        
    </div>
</body>
</html>
