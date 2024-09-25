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
        <div class="mb-2 d-flex justify-content-center">
            <span class="text-danger">
                <?php echo $this->view->errorMsg ?>
            </span>

            <span class="text-success">
                <?php echo $this->view->successMsg ?>
            </span>
        </div>

        <div class="main d-flex flex-column align-items-center justify-content-center mt-4">
            <div class="card">
                <div class="card-body">
                    <div class="mb-3 w-100">
                        <a href="./books" class="w-100 btn btn-primary">Lista de Livros</a>
                    </div>

                    <?php if ($this->view->user != NULL) { ?>
                        <div class="mb-3 w-100">
                            <a href="./books/new" class="w-100 btn btn-primary">Cadastrar Novo Livro</a>
                        </div>

                        <div class="mb-3 w-100">
                            <a href="./profile" class="w-100 btn btn-secondary">Perfil</a>
                        </div>
                        
                        <?php if ($this->view->user->getIsAdmin()){?>
                        <div class='mb-3 w-100'>
                            <a href='./admin' class='w-100 btn btn-secondary'>Admin</a>
                        </div>
                        <?php } ?>
                        
                        <div class="mb-3 w-100">
                            <a href="./logout" class="w-100 btn btn-danger">Sair da Conta</a>
                        </div>
                    <?php } else { ?>
                        <div class="mb-3 w-100">
                            <a href="./login" class="w-100 btn btn-success">Fazer Login</a>
                        </div>

                        <div class="mb-3 w-100">
                            <a href="./register" class="w-100 btn btn-success">Registrar</a>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
</body>

</html>
