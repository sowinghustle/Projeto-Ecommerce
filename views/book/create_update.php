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
        <div class="main d-flex flex-column align-items-center justify-content-center mt-4">
            <div class="card text-start h-75 w-50">
                <div class="card-body">
                    <form method="POST">
                        <div class="mb-2">
                            <span class="text-danger">
                                <?php echo $this->view->errorMsg ?>
                            </span>
                            <span class="text-success">
                                <?php echo $this->view->successMsg ?>
                            </span>
                        </div>

                        <?php if ($this->view->book->hasId()) { ?>
                            <div class="mb-3">
                                <label for="id" class="form-label">Código do Livro</label>
                                <input name="id" type="number" class="form-control" value="<?php echo $this->view->book->getId() ?>" readonly>
                            </div>
                        <?php } ?>

                        <div class="mb-3">
                            <label for="title" class="form-label">Nome do Livro</label>
                            <input name="title" type="text" class="form-control" value="<?php echo $this->view->book->getTitle() ?>">
                        </div>

                        <div class="mb-3">
                            <label for="author" class="form-label">Autor do livro</label>
                            <input name="author" type="text" class="form-control" value="<?php echo $this->view->book->getAuthor() ?>">
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Descrição do livro</label>
                            <textarea name="description" class="form-control" rows="5"><?php echo $this->view->book->getDescription() ?></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="categories" class="form-label">Categorias do livro (separados por
                                vírgula)</label>
                            <input name="categories" type="text" class="form-control" value="<?php echo $this->view->book->getRawCategories() ?>">
                        </div>

                        <div class="mb-3">
                            <label for="price" class="form-label">Valor do livro</label>
                            <input name="price" type="number" step="0.01" min="0.01" class="form-control" value="<?php echo $this->view->book->getPrice() ?>">
                        </div>

                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary">
                                <?php echo $this->view->book->hasId() ? "Atualizar" : "Cadastrar" ?>
                            </button>

                            <?php if ($this->view->book->hasId()) { ?>
                                <button type="submit" class="btn btn-danger" formaction="./delete?id=<?php echo $this->view->book->getId() ?>" formnovalidate>
                                    Excluir
                                </button>
                            <?php } ?>
                        </div>
                    </form>
                </div>
            </div>

            <a href="../books" class="mt-4">Voltar para a listagem de livros</a>
        </div>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
</body>

</html>
