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
        <div class="main d-flex justify-content-center mt-4">
            <div class="mb-2">
                <span class="text-danger">
                    <?php echo $this->view->errorMsg ?>
                </span>

                <span class="text-success">
                    <?php echo $this->view->successMsg ?>
                </span>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
        crossorigin="anonymous"></script>
</body>

</html>
