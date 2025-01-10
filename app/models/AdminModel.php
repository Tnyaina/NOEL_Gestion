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

public function ajouterCadeau($nom, $categorie, $prix, $photo_url = null) {
    $sql = "INSERT INTO CADEAUX (nom, categorie, prix, photo_url) VALUES (?, ?, ?, ?)";
    $stmt = $this->db->prepare($sql);
    return $stmt->execute([$nom, $categorie, $prix, $photo_url]);
}

public function modifierCadeau($id_cadeaux, $nom, $categorie, $prix, $photo_url = null) {
    if ($photo_url === null) {
        $sql = "UPDATE CADEAUX SET nom = ?, categorie = ?, prix = ? WHERE id_cadeaux = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$nom, $categorie, $prix, $id_cadeaux]);
    } else {
        $sql = "UPDATE CADEAUX SET nom = ?, categorie = ?, prix = ?, photo_url = ? WHERE id_cadeaux = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$nom, $categorie, $prix, $photo_url, $id_cadeaux]);
    }
}

public function getCadeauById($id_cadeaux) {
    $sql = "SELECT * FROM CADEAUX WHERE id_cadeaux = ?";
    $stmt = $this->db->prepare($sql);
    $stmt->execute([$id_cadeaux]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
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

// Dans AdminModel.php

public function getCurrentCommission() {
    try {
        $stmt = $this->db->prepare("SELECT * FROM COMMISSION ORDER BY date_modification DESC LIMIT 1");
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        throw new Exception("Erreur lors de la récupération de la commission: " . $e->getMessage());
    }
}

public function updateCommission($taux) {
    try {
        $stmt = $this->db->prepare("INSERT INTO COMMISSION (taux) VALUES (:taux)");
        $stmt->execute(['taux' => $taux]);
        return true;
    } catch (Exception $e) {
        throw new Exception("Erreur lors de la mise à jour de la commission: " . $e->getMessage());
    }
}

// Méthode utilitaire pour calculer le montant après commission
public function calculerMontantApresCommission($montant) {
    $commission = $this->getCurrentCommission();
    $tauxCommission = $commission['taux'];
    return $montant * (1 - ($tauxCommission / 100));
}
}