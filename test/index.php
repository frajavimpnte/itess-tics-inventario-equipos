<?php 
use Inventario\Core\Config;
use Inventario\Core\Router;
use Inventario\Core\Request;
use Inventario\Utils\DependencyInjector;
use Inventario\Domain\Usuario;
use Inventario\Domain\TiposDeUsuario;
use Inventario\Models\UsuarioModel;

require_once __DIR__ . '/../vendor/autoload.php';


//Config Test========================================================
echo '---------------Config Test-----------------</br>';
$config = new Config();

var_dump($config);
echo '<br/>';

//Usuario Test=========================================================
echo '---------------Usuario Test-----------------</br>';
$usuario = new Usuario(1, "juan", "asdfasdf", TiposDeUsuario::ADMINISTRADOR);

var_dump($usuario);
echo '<br/>';


//UsuarioModel Test====================================================
echo '---------------UsuarioModel Test-----------------</br>';
$config = new Config();
var_dump($config);
$dbConfig = $config->get('db');

$db = new PDO(
    'mysql:host=127.0.0.1;dbname=inventario_itess_db',
    $dbConfig['user'],
    $dbConfig['password']
);
$usuarioModel = new UsuarioModel($db);

// probar usuario existente por id
$usuario_test_id = $usuarioModel->getById(1);
var_dump($usuario_test_id);

// Twig Loader Test=======================================
$loader = new Twig_Loader_Filesystem(__DIR__ . '/../views');
$view = new Twig_Environment($loader);
echo $view->loadTemplate('error.twig')->render(['errorMessage' => 'Page not found!']);


// Main
$config = new Config();

$dbConfig = $config->get('db');
$db = new PDO(
    'mysql:host=127.0.0.1;dbname=inventario_itess_db',
    $dbConfig['user'],
    $dbConfig['password']
);

//$log = new Logger('inventario');
//$logFile = $config->get('log');
//$log->pushHandler(new StreamHandler($logFile, Logger::DEBUG));

$di = new DependencyInjector();
$di->set('PDO', $db);
$di->set('Utils\Config', $config);
$di->set('Twig_Environment', $view);
//$di->set('Logger', $log);


$di->set('UsuarioModel', new UsuarioModel($di->get('PDO')));

$router = new Router($di);
$response = $router->route(new Request());
echo $response;