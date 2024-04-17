<?php


require_once "config.php";
require_once "models/Session.php";

if (PRODUCTION == true) {
    error_reporting(0);
}

// redireciona todas as requisições que tem assets no meio para a pasta de assets
if (strpos($_SERVER['REQUEST_URI'], '/assets/') !== false) {
    $restOfUrl = substr($_SERVER['REQUEST_URI'], strpos($_SERVER['REQUEST_URI'], '/assets/') + 8);
    $baseUrl = getBaseUrl();
    header("Location: $baseUrl/assets/$restOfUrl");
    exit;
}

// mapeia e importa todos os controllers existentes
$controllersPath = 'controllers/';
$controllers = scandir($controllersPath);

foreach ($controllers as $controller) {
    if ($controller !== '.' && $controller !== '..') {
        require_once $controllersPath . $controller;
    }
}

// obtém todas as rotas do site e seu respectivo controller e método
$rotasJson = file_get_contents('routes.json');
$rotas = json_decode($rotasJson, true);

if ($rotas === null) {
    die('Error decoding routes JSON file.');
}

// remove a última barra das rotas, por exemplo: http://localhost:80/conta/editar/ => http://localhost:80/conta/editar
$urlBase = str_replace('/index.php', '', $_SERVER['SCRIPT_NAME']);

[$uriRequisitada] = explode('?', $_SERVER['REQUEST_URI']);
$rtrimUriRequisitada = rtrim($uriRequisitada, '/');


if ($urlBase != $rtrimUriRequisitada && substr($uriRequisitada, -1) == '/') {
    $baseUrl = getBaseUrl();
    header("Location: $baseUrl$rtrimUriRequisitada");
}

$rotaEncontrada = null;
$correspondentes = [];

foreach ($rotas as $rota => $acao) {
    $regex = '#^' . $urlBase . $rota . '$#';

    if (preg_match($regex, $uriRequisitada, $correspondentes)) {
        $rotaEncontrada = $rota;
        break;
    }
}

// caso a rota atual seja encontrada na lista de rotas, então o cotroller.metodo
// desta rota é executado, senão envia a página 404
if ($rotaEncontrada) {
    $controllerMetodoEscolhidos = explode('@', $rotas[$rotaEncontrada]);
    $nomeDoController = $controllerMetodoEscolhidos[0];
    $nomeDoMetodo = $controllerMetodoEscolhidos[1];

    $controller = new $nomeDoController();
    $controller->view = (object) [];
    $controller->session = new Session();

    try {
        $controller->$nomeDoMetodo(...array_slice($correspondentes, 1));
    } catch (Exception $ex) {
        // TODO: include '500.html'
        $error = $ex->getMessage();
        echo "Fatal error: $error<br/><a href='#' onclick='javascript:window.history.go(-1)'>Voltar</a>";
    }
} else {
    $error404title = "Desculpa, página não encontrada.";
    $error404description = "Verifique se a url está correta.";

    include '404.php';
}

function getBaseUrl()
{
    $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
    $host = $_SERVER['HTTP_HOST'];
    $baseUrl = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');
    return "$protocol://$host$baseUrl";
}
