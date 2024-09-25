<?php

/** @var AuthController $this */ ?>
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

    <div class="container">
        <div class="main d-flex flex-column align-items-center justify-content-center mt-4">
            <div class="card text-start h-75 w-50">
                <div class="card-body">
                    <form method="POST">
                        <div class="mb-2 d-flex justify-content-center">
                            <span class="text-danger">
                                <?php echo $this->view->errorMsg ?>
                            </span>
                            <span class="text-success">
                                <?php echo $this->view->successMsg ?>
                            </span>
                        </div>

                        <div class="mb-3">
                            <label for="InputEmail1" class="form-label">E-Mail ou Username</label>
                            <input class="form-control" id="InputEmail1" name="email" value="<?php echo $this->view->usernameOrEmail ?>">
                        </div>

                        <div class="mb-3">
                            <label for="InputPassword1" class="form-label">Senha</label>
                            <input type="password" class="form-control" id="InputPassword1" name="password" value="<?php echo $this->view->password ?>">
                        </div>

                        <div class="d-flex justify-content-center align-items-center gap-2">
                            <button type="submit" class="btn btn-primary">Logar</button>
                            <a href="/register" class="link-underline-secondary">Criar uma conta</a>
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
