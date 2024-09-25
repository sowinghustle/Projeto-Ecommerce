<?php

/** @var BookController $this */ ?>
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
        <div class="mb-2 d-flex justify-content-center">
            <span class="text-danger">
                <?php echo $this->view->errorMsg ?>
            </span>

            <span class="text-success">
                <?php echo $this->view->successMsg ?>
            </span>
        </div>

        <div class="main d-flex flex-column align-items-center justify-content-center mt-4">
            <div class="mb-5 w-100 d-flex flex-column align-items-center">
                <label for="search" class="form-label">Pesquisa</label>
                <input id="search" name="search" type="text" class="form-control" value="<?php echo $this->view->search ?>" style="max-width:450px;width:100%;" />
                <button id="btn-search" class="btn btn-primary mt-2" style="max-width:450px;width:100%;">pesquisar</button>
                <a href="../" class="mt-4">Ir para a Home</a>
            </div>

            <section>
                <?php
                $books = $this->view->bookList->getBooks();

                if (empty($books)) {
                    echo "<span>Nenhum livro foi encontrado!</span>";
                }

                foreach ($books as $book) {
                    $builder = BookBuilderFactory::create($book, $this->session->get("usuario-logado", 0), "view");
                    echo $builder->render();
                }
                ?>
            </section>
        </div>
    </div>

    <script src=" https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
    <script>
        const inputSearch = document.getElementById("search");
        const btnSearch = document.getElementById("btn-search");

        function search(value) {
            window.location.href = "../books?search=" + value;
        }

        inputSearch.addEventListener("keyup", ev => {
            if (ev.key === "Enter" || ev.keyCode === 13) {
                search(inputSearch.value);
            }
        });

        btnSearch.addEventListener("click", ev => {
            search(inputSearch.value);
        });
    </script>
</body>

</html>
