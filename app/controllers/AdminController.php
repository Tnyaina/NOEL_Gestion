<?php

namespace app\controllers;

use app\models\AdminModel;
use Flight;

class AdminController{
    private $adminModel;

    public function __construct()
    {
        $this->adminModel = new AdminModel(Flight::db());
    }

    public function index(){
        $depots = $this->adminModel->listDepot();
        $data = [
            'depots' => $depots
        ];
        Flight::render('admin/index',$data);
    }

    public function confirmer(){
        $id_depot = Flight::request()->data->id_depot;
        $this->adminModel->accepterDepot($id_depot);
        Flight::redirect('/admin');
    }

    // cadeaux

    // Dans AdminController.php
public function cadeaux(){
    $cadeaux = $this->adminModel->listCadeaux();
    $data = [
        'cadeaux' => $cadeaux
    ];
    Flight::render('admin/cadeaux', $data);
}

public function ajouterCadeau(){
    $nom = Flight::request()->data->nom;
    $categorie = Flight::request()->data->categorie;
    $prix = Flight::request()->data->prix;
    
    $this->adminModel->ajouterCadeau($nom, $categorie, $prix);
    Flight::redirect('/cadeaux');
}

public function modifierCadeau(){
    $id_cadeaux = Flight::request()->data->id_cadeaux;
    $nom = Flight::request()->data->nom;
    $categorie = Flight::request()->data->categorie;
    $prix = Flight::request()->data->prix;
    
    $this->adminModel->modifierCadeau($id_cadeaux, $nom, $categorie, $prix);
    Flight::redirect('/cadeaux');
}

public function supprimerCadeau(){
    $id_cadeaux = Flight::request()->data->id_cadeaux;
    $this->adminModel->supprimerCadeau($id_cadeaux);
    Flight::redirect('/cadeaux');
}

}