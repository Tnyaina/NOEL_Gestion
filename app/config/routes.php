<?php

use app\controllers\UserController;
use app\controllers\AdminController;
use flight\Engine;
use flight\net\Router;
// use Flight;

// user
Flight::route('GET /', function() {
    $controller = new UserController();
    $controller->showLoginForm();
});

Flight::route('GET /register', function() {
    $controller = new UserController();
    $controller->showRegisterForm();
});

Flight::route('POST /login', function() {
    $controller = new UserController();
    $controller->login();
});

Flight::route('POST /inscription', function() {
    $controller = new UserController();
    $controller->register();
});

Flight::route('GET /logout', function() {
    $controller = new UserController();
    $controller->logout();
});

// admin 
Flight::route('GET /admin', function() {
    $controller = new AdminController();
    $controller->index();
});

// Correct
Flight::route('POST /admin/accepter-depot', function(){
    $controller = new AdminController();
    $controller->confirmer();
});

// Dans routes.php
Flight::route('GET /cadeaux', function() {
    $controller = new AdminController();
    $controller->cadeaux();
});

Flight::route('POST /cadeaux/ajouter', function() {
    $controller = new AdminController();
    $controller->ajouterCadeau();
});

Flight::route('POST /cadeaux/modifier', function() {
    $controller = new AdminController();
    $controller->modifierCadeau();
});

Flight::route('POST /cadeaux/supprimer', function() {
    $controller = new AdminController();
    $controller->supprimerCadeau();
});

Flight::route('GET /accueil', function() {
    $controller = new UserController();
    $controller->showAccueil();
});

// Routes pour la sélection des cadeaux

Flight::route('GET /selection-cadeaux', function() {
    $controller = new UserController();
    if (!isset($_SESSION['selection'])) {
        Flight::redirect('/accueil');
        return;
    }
    $controller->afficherSelectionCadeaux();
});

Flight::route('POST /selection-cadeaux', function() {
    $controller = new UserController();
    $controller->selectionnerCadeaux();
});

Flight::route('POST /changer-cadeau', function() {
    $controller = new UserController();
    $controller->changerCadeau();
});

Flight::route('POST /valider-cadeaux', function() {
    $controller = new UserController();
    $controller->validerCadeaux();
});

Flight::route('POST /changer-tous-cadeaux', function() {
    $controller = new UserController();
    $controller->changerTousCadeaux();
});

// Dans routes.php, ajoutez ces routes

Flight::route('GET /depot', function() {
    $controller = new UserController();
    $controller->showDepotForm();
});

Flight::route('POST /depot', function() {
    $controller = new UserController();
    $controller->faireDepot();
});