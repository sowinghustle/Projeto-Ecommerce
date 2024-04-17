<?php

/** @var HomeController $this */
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="shortcut icon" href="assets/favicon.ico" type="image/x-icon" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/index.css" />
    <title>
        <?php echo $this->view->title ?>
    </title>
</head>

<body>
    <h1 class="text-center">
        <?php echo $this->view->title ?>
    </h1>

    <div class="container">
        <div class="main d-flex flex-column align-items-center justify-content-center mt-4">
            <div class="card">
                <div class="card-body">
                    <div class="mb-3 w-100">
                        <a href="./books" class="w-100 btn btn-primary">Ver a Lista de Livros</a>
                    </div>

                    <?php if ($this->session->has("usuario-logado")) { ?>
                        <div class="mb-3 w-100">
                            <a href="./logout" class="w-100 btn btn-primary">Sair da Conta</a>
                        </div>

                        <div class="mb-3 w-100">
                            <a href="./profile" class="w-100 btn btn-primary">Perfil</a>
                        </div>
                    <?php } else { ?>
                        <div class="mb-3 w-100">
                            <a href="./login" class="w-100 btn btn-primary">Fazer Login</a>
                        </div>

                        <div class="mb-3 w-100">
                            <a href="./register" class="w-100 btn btn-primary">Registrar</a>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
</body>

</html>
