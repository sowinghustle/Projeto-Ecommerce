<?php

/** @var HomeController $this */ ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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

    <div class=" container">
        <div class="main d-flex flex-column align-items-center justify-content-center mt-4">
            <div class="card text-start h-75 w-50">
                <div class="card-body">
                    <form method="POST">
                        <div class="mb-2 d-flex justify-content-center">
                            <span class="text-success">
                                <?php echo $this->view->successMsg ?>
                            </span>

                            <span class="text-danger">
                                <?php echo $this->view->errorMsg ?>
                            </span>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">E-Mail</label>
                            <input name="email" type="email" class="form-control" value="<?php echo $this->view->email ?>" readonly>
                        </div>

                        <div class="mb-3">
                            <label for="username" class="form-label">Usuário</label>
                            <input name="username" type="username" class="form-control" value="<?php echo $this->view->username ?>" autocomplete="username">
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Nova Senha (*deixe vazio para permanecer com a mesma senha)</label>
                            <input name="password" type="password" class="form-control" autocomplete="current-password" value="">
                        </div>

                        <div class="d-flex justify-content-center align-items-center gap-2">
                            <button type="submit" class="btn btn-primary" formaction="./profile">Atualizar</button>
                            <button type="submit" class="btn btn-danger" formaction="./profile?delete=true">Excluir Conta</button>
                        </div>
                    </form>
                </div>
            </div>

            <a href="../" class="mt-4">Ir para a Home</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
</body>

</html>
