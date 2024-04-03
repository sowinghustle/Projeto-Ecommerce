<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/index.css" />
    <title>Sign-in</title>
</head>

<body>
    <h1>
        <?php echo $this->view->title ?>
    </h1>
    <div class="container">
        <div class="main d-flex justify-content-center mt-4">
            <div class="card text-start h-75 w-50">
                <div class="card-body">
                    <form method="POST">
                        <span class="text-danger">
                            <?php echo $this->view->errorMsg ?>
                        </span>
                        <span class="text-success">
                            <?php echo $this->view->successMsg ?>
                        </span>

                        <div class="mb-3">
                            <label for="Input" class="form-label">Usuário</label>
                            <input name="username" type="username" class="form-control" id="InputUsername1"
                                value="<?php echo $this->view->username ?>">
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">E-Mail</label>
                            <input name="email" type="email" class="form-control" id="InputEmail1"
                                value="<?php echo $this->view->email ?>">
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Senha</label>
                            <input name="password" type="password" class="form-control" id="InputPassword1" value="">
                        </div>

                        <div class="d-flex justify-content-center">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
        crossorigin="anonymous"></script>
</body>

</html>
