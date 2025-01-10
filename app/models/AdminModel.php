<?php

namespace app\models;

use PDO;
use Exception;

class AdminModel{

    private $db;
    public function __construct(PDO $database){
        $this->db = $database;
    }

    public function listDepot(){
        try {
            $stmt = $this->db->prepare("SELECT * FROM depot");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC); // Changé de fetch() à fetchAll()
        } catch (Exception $e) {
            throw new Exception("Erreur lors de la récupération des depots: " . $e->getMessage());
        }
    }

    public function accepterDepot($id_depot){
        try {
            $stmt = $this->db->prepare("UPDATE depot SET status_depot = 'valide' WHERE id_depot = :id_depot");
            $stmt->execute(['id_depot' => $id_depot]);
            return true; // Pas besoin de fetchAll() pour un UPDATE
        } catch (Exception $e) {
            throw new Exception("Erreur lors de la validation du depot: " . $e->getMessage());
        }
    }

    //Cadeaux
public function listCadeaux(){
    try {
        $stmt = $this->db->prepare("SELECT * FROM cadeaux");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        throw new Exception("Erreur lors de la récupération des cadeaux: " . $e->getMessage());
    }
}

public function ajouterCadeau($nom, $categorie, $prix){
    try {
        $stmt = $this->db->prepare("INSERT INTO cadeaux (nom, categorie, prix) VALUES (:nom, :categorie, :prix)");
        $stmt->execute([
            'nom' => $nom,
            'categorie' => $categorie,
            'prix' => $prix
        ]);
        return true;
    } catch (Exception $e) {
        throw new Exception("Erreur lors de l'ajout du cadeau: " . $e->getMessage());
    }
}

public function modifierCadeau($id_cadeaux, $nom, $categorie, $prix){
    try {
        $stmt = $this->db->prepare("UPDATE cadeaux SET nom = :nom, categorie = :categorie, prix = :prix WHERE id_cadeaux = :id_cadeaux");
        $stmt->execute([
            'id_cadeaux' => $id_cadeaux,
            'nom' => $nom,
            'categorie' => $categorie,
            'prix' => $prix
        ]);
        return true;
    } catch (Exception $e) {
        throw new Exception("Erreur lors de la modification du cadeau: " . $e->getMessage());
    }
}

public function supprimerCadeau($id_cadeaux){
    try {
        $stmt = $this->db->prepare("DELETE FROM cadeaux WHERE id_cadeaux = :id_cadeaux");
        $stmt->execute(['id_cadeaux' => $id_cadeaux]);
        return true;
    } catch (Exception $e) {
        throw new Exception("Erreur lors de la suppression du cadeau: " . $e->getMessage());
    }
}
}