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
            <div class="card text-start h-75 w-100 overflow-scroll">
                <div class="card-body">
                    <h5 class="card-title">Painel de Administrador</h5>
                    <p class="card-text">Bem-vindo ao painel de administrador</p>
                </div>
                <div class="card-body">
                    <p class="card-text">Alunos</p>
                </div>
                <div class="position-relative">
                    <div class="position-absolute top-0 end-0">
                        <button class="btn btn-secondary" type="button">Exportar CSV</button>
                    </div>
                    <table class="table">
                        <thead class="sticky-top top-0">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">ID</th>
                                <th scope="col">Nome de usuário</th>
                                <th scope="col">E-Mail</th>
                                <th scope="col">Senha</th>
                                <th scope="col">Admin</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $users = $this->view->users;
                            if (!empty($users)) {
                                foreach ($users as $user) {
                                    echo "<tr>";
                                    echo "<th scope='row'>" . $user->getId() . "</th>";
                                    echo "<td>" . $user->getId() . "</td>";
                                    echo "<td>" . $user->getUsername() . "</td>";
                                    echo "<td>" . $user->getEmail() . "</td>";
                                    echo "<td>" . $user->getPassword() . "</td>";
                                    echo "<td>" . ($user->getIsAdmin() ? "Sim" : "Não") . "</td>";
                                    echo "</tr>";
                                }
                            }
                            ?>
                        </tbody>
                    </table>

                    <div class="card-body">
                        <p class="card-text">Livros</p>
                    </div>
                    <table class="table">
                        <thead class="sticky-top top-0">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">ID</th>
                                <th scope="col">Título</th>
                                <th scope="col">Autor</th>
                                <th scope="col">Descrição</th>
                                <th scope="col">Categorias</th>
                                <th scope="col">Preço</th>
                                <th scope="col">Usuário</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $books = $this->view->books;
                            if (!empty($books)) {
                                foreach ($books as $book) {
                                    echo "<tr>";
                                    echo "<th scope='row'>" . $book->getId() . "</th>";
                                    echo "<td>" . $book->getId() . "</td>";
                                    echo "<td>" . $book->getTitle() . "</td>";
                                    echo "<td>" . $book->getAuthor() . "</td>";
                                    echo "<td>" . $book->getDescription() . "</td>";
                                    echo "<td>" . $book->getCategories() . "</td>";
                                    echo "<td>" . $book->getPrice() . "</td>";
                                    echo "<td>" . $book->getUserId() . "</td>";
                                    echo "</tr>";
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>


            </div>

            <a href="../" class="mt-4">Ir para a Home</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
    <script>
        
    </script>
</body>

</html>