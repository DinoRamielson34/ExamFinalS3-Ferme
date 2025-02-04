<?php

use app\controllers\ApiExampleController;
use app\controllers\WelcomeController;
use app\controllers\LogController;
use app\controllers\HomeController;
use app\controllers\AccueilController;
use app\controllers\CrudController;
use app\controllers\TableauController;
use flight\Engine;
use flight\net\Router;
//use Flight;

/** 
 * @var Router $router 
 * @var Engine $app
 */
/*$router->get('/', function() use ($app) {
	$Welcome_Controller = new WelcomeController($app);
	$app->render('welcome', [ 'message' => 'It works!!' ]);
});*/

$Welcome_Controller = new WelcomeController();
$Log_Controller = new LogController();
$Home_Controller = new HomeController();
$Accuiel_Controller = new AccueilController();
$Crud_Controller = new CrudController();
$Tableau_Controller = new TableauController();

$router->get('/', [$Log_Controller, 'login']);
$router->post('/log', [$Log_Controller, 'log']);
$router->post('/register', [$Log_Controller, 'register']);
$router->get('/home', [$Accuiel_Controller, 'home']);
$router->post('/update-capital', [$Accuiel_Controller, 'updateCapital']);
$router->get('/liste', [$Crud_Controller, 'listeAnimaux']);
$router->get('/suppression', [$Crud_Controller, 'suppressionAnimal']);
$router->get('/form_ajout', [$Crud_Controller, 'form_AjoutAnimal']);
$router->post('/ajout', [$Crud_Controller, 'AjoutAnimal']);
$router->get('/modification', [$Crud_Controller, 'form_UpdateAnimal']);
$router->post('/modifierAnimal', [$Crud_Controller, 'ModificationAnimal']);
$router->get('/alimentation', [$Crud_Controller, 'listeAlimentations']);
$router->get('/form_ajoutAlimentation', [$Crud_Controller, 'form_AjoutAlimentation']);
$router->get('/suppressionAlimentation', [$Crud_Controller, 'suppressionAlimentation']);
$router->get('/modificationAlimentation', [$Crud_Controller, 'form_UpdateAlimentation']);
$router->post('/modifierAlimentation', [$Crud_Controller, 'ModificationAlimentation']);
$router->post('/ajoutAlimentation', [$Crud_Controller, 'AjoutAlimentation']);
$router->post('/acheter-animal', [$Crud_Controller, 'acheterAnimal']);
$router->post('/acheter-aliment', [$Crud_Controller, 'acheterAliment']);
$router->get('/product', [$Crud_Controller, 'aliment']);
$router->get('/tableau', [$Tableau_Controller, 'tableauDeBord']);
$router->get('/getSituationElevage', [$Tableau_Controller, 'getSituationElevage']);
$router->post('/vendreAnimal', [$Tableau_Controller, 'vendreAnimal']);


//$router->get('/', \app\controllers\WelcomeController::class.'->home'); 

$router->get('/hello-world/@name', function ($name) {
	echo '<h1>Hello world! Oh hey ' . $name . '!</h1>';
});

$router->group('/api', function () use ($router, $app) {
	$Api_Example_Controller = new ApiExampleController($app);
	$router->get('/users', [$Api_Example_Controller, 'getUsers']);
	$router->get('/users/@id:[0-9]', [$Api_Example_Controller, 'getUser']);
	$router->post('/users/@id:[0-9]', [$Api_Example_Controller, 'updateUser']);
});