
<?php

// Chargement des dependances PHP
require_once '../vendor/autoload.php';

// Demarrage de session
session_start();


//Chargement des variables d'environnements
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ .'/../');
$dotenv->load();

// Chargement du Router
require_once '../core/Router.php';

// Instancier notre routeur afin de rediriger notre utilisateur
$router = new Router();

// Nos routes
// Accueil
$router->add('/portfolio', 'HomeController', 'index');

// Page test
$router->add('/portfolio/test', 'HomeController', 'test');

// Page contact
$router->add('/portfolio/contact', 'HomeController', 'contact');

// Insertion de donnees d'essai
$router->add('/portfolio/fixtures', 'FixtureController', 'index');

// Detail d'un projet
$router->add('/portfolio/projet/details', 'HomeController', 'details');

// Connexion
$router->add('/portfolio/login', 'AuthController', 'login');

// Deconnexion
$router->add('/portfolio/logout', 'AuthController', 'logout');

// Accueil de l'administration
$router->add('/portfolio/admin', 'AdminController', 'index');

// Administration - Ajout d'un projet
$router->add('/admin/new/project', 'AdminController', 'add');

// Administration - Edition d'un projet
$router->add('/admin/edit/project', 'AdminController', 'edit');

// Administration - Suppression d'un projet
$router->add('/admin/delete/project', 'AdminController', 'delete');

// Erreur 404
$router->add('/portfolio/404', 'ErrorController', 'error404');


// Dispatch
$router->dispatch($_SERVER['REQUEST_URI']);