<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" />
  <title>404 - Página não encontrada</title>
</head>

<body>
  <center>
    <h1 style="color: #ff0000; ">404 - Não Encontrado</h1>
    <div class="d-flex justify-center">
      <img src="assets/images/404.gif" alt="404" />
      <img src="assets/images/404_fail.gif" alt="fails" />
    </div>
    <h2><?php echo $error404title ?></h2>
    <span><?php echo $error404description ?></span>
  </center>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
    integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
    crossorigin="anonymous"></script>
  <style>
    body {
      overflow: hidden;
      height: 100vh;
      display: grid;
      place-items: center
    }

    h1,
    h2 {
      font-family: cursive;
    }

    span {
      font-family: monospace;
      font-weight: bold;
    }

    .d-flex {
      display: flex !important;
      height: 150px;
    }
  </style>
</body>

</html>
