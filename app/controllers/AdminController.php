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

public function ajouterCadeau() {
    $nom = Flight::request()->data->nom;
    $categorie = Flight::request()->data->categorie;
    $prix = Flight::request()->data->prix;
    
    // Gestion de l'upload d'image
    $photo_url = null;
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = 'uploads/cadeaux/';
        if (!file_exists($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }
        
        $file_extension = strtolower(pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION));
        $new_filename = uniqid() . '.' . $file_extension;
        $upload_path = $upload_dir . $new_filename;
        
        if (move_uploaded_file($_FILES['photo']['tmp_name'], $upload_path)) {
            $photo_url = $upload_path;
        }
    }
    
    $this->adminModel->ajouterCadeau($nom, $categorie, $prix, $photo_url);
    Flight::redirect('/ajout');
}

public function modifierCadeau() {
    $id_cadeaux = Flight::request()->data->id_cadeaux;
    $nom = Flight::request()->data->nom;
    $categorie = Flight::request()->data->categorie;
    $prix = Flight::request()->data->prix;
    
    // Gestion de l'upload d'image
    $photo_url = null;
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = 'uploads/cadeaux/';
        if (!file_exists($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }
        
        // Supprimer l'ancienne image si elle existe
        $ancien_cadeau = $this->adminModel->getCadeauById($id_cadeaux);
        if ($ancien_cadeau && !empty($ancien_cadeau['photo_url'])) {
            if (file_exists($ancien_cadeau['photo_url'])) {
                unlink($ancien_cadeau['photo_url']);
            }
        }
        
        $file_extension = strtolower(pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION));
        $new_filename = uniqid() . '.' . $file_extension;
        $upload_path = $upload_dir . $new_filename;
        
        if (move_uploaded_file($_FILES['photo']['tmp_name'], $upload_path)) {
            $photo_url = $upload_path;
        }
    }
    
    $this->adminModel->modifierCadeau($id_cadeaux, $nom, $categorie, $prix, $photo_url);
    Flight::redirect('/ajout');
}

public function supprimerCadeau(){
    $id_cadeaux = Flight::request()->data->id_cadeaux;
    $this->adminModel->supprimerCadeau($id_cadeaux);
    Flight::redirect('/ajout');
}

// Dans AdminController.php

public function showCommissionForm() {
    $commission = $this->adminModel->getCurrentCommission();
    $data = [
        'commission' => $commission
    ];
    Flight::render('admin/commission', $data);
}

public function updateCommission() {
    $taux = Flight::request()->data->taux;
    
    // Validation du taux
    if (!is_numeric($taux) || $taux < 0 || $taux > 100) {
        Flight::json(['error' => 'Le taux doit être compris entre 0 et 100'], 400);
        return;
    }
    
    $this->adminModel->updateCommission($taux);
    Flight::redirect('/admin/commission');
}

}