<!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="utf-8" />
        <title>Testeador API</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
        <meta content="Coderthemes" name="author" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="assets/images/favicon.ico">

        <!-- App css -->
        <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/app-creative.min.css" rel="stylesheet" type="text/css" id="light-style" />
        <link href="assets/css/app-creative-dark.min.css" rel="stylesheet" type="text/css" id="dark-style" />

    </head>

    <body class="loading" data-layout="topnav" data-layout-config='{"layoutBoxed":false,"darkMode":false}'>
        <!-- Begin page -->
        <div class="wrapper">

            <!-- ============================================================== -->
            <!-- Start Page Content here -->
            <!-- ============================================================== -->

            <div class="content-page">
                <div class="content">
                    <!-- Topbar Start -->
                    <div class="navbar-custom topnav-navbar topnav-navbar-dark">
                        <div class="container-fluid">
                            <div class="app-search dropdown">
                                <form action="">
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="Buscar..." name="libros_busqueda" id="libros_busqueda">
                                        <span class="mdi mdi-magnify search-icon"></span>
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="submit">Buscar Libros</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- end Topbar -->

                    <!-- Start Content-->
                    <div class="container-fluid">
                    
                    <!-- container -->
                    <div class="row mt-4">
                            <div class="col-12">
                            <div class="card border-primary border">
                                    <div class="card-body">
                    <?php 

                        if (isset($_GET["libros_busqueda"])) //Realizamos la búsqueda de libros por título.
                        {

                            //Se realiza la peticion a la api que nos devuelve el JSON con la información de los libros pero debemos sustituir los espacios en blanco por signos + tal y como indica la documentación
                            //de la api
                            $libros_info = file_get_contents('https://openlibrary.org/search.json?title=' . str_replace(' ', '+',$_GET["libros_busqueda"]));
                            // Se decodifica el fichero JSON y se convierte a array
                            $libros_info = json_decode($libros_info);

                    ?>
                            <h5 class="card-title">Resultados de la búsqueda <?php echo $_GET["libros_busqueda"]; ?> </h5>
                            <ul>
                                <?php 
                                    foreach($libros_info->docs as $libro): ?>
                                        <li>
                                                <?php echo $libro->title; ?> (<a href="<?php echo "index.php?autor_info=" . $libro->author_key[0]  ?>"><?php echo $libro->author_name[0]; ?></a>)
                                        </li>
                                <?php endforeach; ?>  
                            </ul>
                    <?php 
                        }else if(isset($_GET["autor_info"]))
                        {
                            //Se realiza la peticion a la api que nos devuelve el JSON con la información de los autores utilizando el código de autor facilitado
                            $autor_info = file_get_contents('https://openlibrary.org/authors/' . $_GET["autor_info"] . ".json");
                            // Se decodifica el fichero JSON y se convierte a array
                            $autor_info = json_decode($autor_info);
                    ?>
                            <h5 class="card-title">Datos de Autor</h5>
                            <form class="form-horizontal">
                                <div class="row mb-3">
                                    <label class="col-3 col-form-label">Nombre</label>
                                    <div class="col-9">
                                        <input class="form-control" readonly value="<?php echo $autor_info->personal_name; ?>" >
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label class="col-3 col-form-label">Fecha de nacimiento</label>
                                    <div class="col-9">
                                        <input class="form-control" readonly value="<?php echo $autor_info->birth_date; ?>" >
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label class="col-3 col-form-label">Wikipedia</label>
                                    <div class="col-9">
                                        <input class="form-control" readonly value="<?php echo $autor_info->wikipedia; ?>" >
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label class="col-3 col-form-label">Sitio Web Oficial</label>
                                    <div class="col-9">
                                        <input class="form-control" readonly value="<?php echo $autor_info->links[0]->url; ?>" >
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label class="col-3 col-form-label">Bio</label>
                                    <div class="col-9">
                                        <textarea class="form-control" style="height:200px" readonly>
                                            <?php echo $autor_info->bio; ?>
                                        </textarea>
                                        </div>
                                </div>
                            </form>
                    <?php 
                        }
                    ?>
                                    </div> <!-- end card-body-->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- content -->
                

            </div>

            <!-- ============================================================== -->
            <!-- End Page content -->
            <!-- ============================================================== -->


        </div>
        <!-- END wrapper -->


        <!-- bundle -->
        <script src="assets/js/vendor.min.js"></script>
        <script src="assets/js/app.min.js"></script>

    </body>
</html>