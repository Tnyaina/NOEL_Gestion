<?php

namespace app\models;

use PDO;
use Exception;

class UserModel
{
    private $db;

    public function __construct(PDO $database)
    {
        $this->db = $database;
    }

    // CREATE
    public function create($email, $password, $user_type = "user")
    {
        try {
            // Hash du mot de passe avant stockage
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            $stmt = $this->db->prepare(
                "INSERT INTO user (email, mot_de_passe, user_type) 
                 VALUES (:email, :password, :user_type)"
            );

            $stmt->execute([
                'email' => $email,
                'password' => $hashed_password,
                'user_type' => $user_type
            ]);

            return $this->db->lastInsertId();
        } catch (Exception $e) {
            throw new Exception("Erreur lors de la création de l'utilisateur: " . $e->getMessage());
        }
    }

    // READ
    public function getUser($id_user)
    {
        try {
            $stmt = $this->db->prepare("SELECT * FROM user WHERE id_user = :id_user");
            $stmt->execute(['id_user' => $id_user]);

            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            throw new Exception("Erreur lors de la récupération de l'utilisateur: " . $e->getMessage());
        }
    }

    public function getAllUsers()
    {
        try {
            $stmt = $this->db->query("SELECT * FROM user");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            throw new Exception("Erreur lors de la récupération des utilisateurs: " . $e->getMessage());
        }
    }

    // UPDATE
    public function update($id_user, $data)
    {
        try {
            $allowedFields = ['email', 'user_type'];
            $updates = [];
            $params = ['id_user' => $id_user];

            foreach ($data as $key => $value) {
                if (in_array($key, $allowedFields)) {
                    $updates[] = "$key = :$key";
                    $params[$key] = $value;
                }
            }

            if (isset($data['password'])) {
                $updates[] = "mot_de_passe = :password";
                $params['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
            }

            if (empty($updates)) {
                return false;
            }

            $sql = "UPDATE user SET " . implode(', ', $updates) . " WHERE id_user = :id_user";
            $stmt = $this->db->prepare($sql);

            return $stmt->execute($params);
        } catch (Exception $e) {
            throw new Exception("Erreur lors de la mise à jour de l'utilisateur: " . $e->getMessage());
        }
    }

    // DELETE
    public function delete($id_user)
    {
        try {
            $stmt = $this->db->prepare("DELETE FROM user WHERE id_user = :id_user");
            return $stmt->execute(['id_user' => $id_user]);
        } catch (Exception $e) {
            throw new Exception("Erreur lors de la suppression de l'utilisateur: " . $e->getMessage());
        }
    }

    // Utilitaires
    public function estAdmin($id_user)
    {
        try {
            $stmt = $this->db->prepare(
                "SELECT * FROM user 
                 WHERE id_user = :id_user AND user_type = 'admin'"
            );
            $stmt->execute(['id_user' => $id_user]);

            return $stmt->fetch(PDO::FETCH_ASSOC) ? true : false;
        } catch (Exception $e) {
            throw new Exception("Erreur lors de la vérification du statut admin: " . $e->getMessage());
        }
    }

    public function getUserByEmail($email)
    {
        try {
            $stmt = $this->db->prepare("SELECT * FROM user WHERE email = :email");
            $stmt->execute(['email' => $email]);

            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            throw new Exception("Erreur lors de la récupération de l'utilisateur: " . $e->getMessage());
        }
    }

    public function getUserConnecte($email, $password)
    {
        try {
            $user = $this->getUserByEmail($email);

            if ($user && password_verify($password, $user['mot_de_passe'])) {
                unset($user['mot_de_passe']); // Ne pas renvoyer le mot de passe
                return $user;
            }

            return false;
        } catch (Exception $e) {
            throw new Exception("Erreur lors de la connexion: " . $e->getMessage());
        }
    }

    // Vérification si l'email existe déjà
    public function emailExists($email)
    {
        try {
            $stmt = $this->db->prepare("SELECT COUNT(*) FROM user WHERE email = :email");
            $stmt->execute(['email' => $email]);

            return $stmt->fetchColumn() > 0;
        } catch (Exception $e) {
            throw new Exception("Erreur lors de la vérification de l'email: " . $e->getMessage());
        }
    }

    public function getSoldeValide($id_user)
    {
        $sql = "SELECT COALESCE(SUM(montant), 0) as solde 
            FROM depot 
            WHERE id_user = ? AND status_depot = 'validé'";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id_user]);
        $result = $stmt->fetch();

        return $result['solde'];
    }

    public function getSuggestionsCadeaux($nb_filles, $nb_garcons)
    {
        $suggestions = [];

        // Sélectionner des cadeaux pour les filles
        for ($i = 0; $i < $nb_filles; $i++) {
            $exclusionList = empty($suggestions) ? "0" : implode(',', array_map(function ($c) {
                return $c['id_cadeaux'];
            }, $suggestions));

            $sql = "SELECT * FROM cadeaux 
                WHERE categorie IN ('fille', 'neutre') 
                AND id_cadeaux NOT IN (" . $exclusionList . ")
                ORDER BY RAND() LIMIT 1";
            $stmt = $this->db->query($sql);
            $cadeau = $stmt->fetch();
            if ($cadeau) {
                $suggestions[] = $cadeau;
            }
        }

        // Sélectionner des cadeaux pour les garçons
        for ($i = 0; $i < $nb_garcons; $i++) {
            $exclusionList = empty($suggestions) ? "0" : implode(',', array_map(function ($c) {
                return $c['id_cadeaux'];
            }, $suggestions));

            $sql = "SELECT * FROM cadeaux 
                WHERE categorie IN ('garcon', 'neutre')
                AND id_cadeaux NOT IN (" . $exclusionList . ")
                ORDER BY RAND() LIMIT 1";
            $stmt = $this->db->query($sql);
            $cadeau = $stmt->fetch();
            if ($cadeau) {
                $suggestions[] = $cadeau;
            }
        }

        return $suggestions;
    }

    public function getNouveauCadeauAleatoire($type, $exclusions = [])
    {
        $exclusions = array_map('intval', $exclusions);
        $sql = "SELECT * FROM cadeaux 
            WHERE categorie = ? 
            AND id_cadeaux NOT IN (" . implode(',', $exclusions) . ")
            ORDER BY RAND() LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$type]);
        return $stmt->fetch();
    }

    public function enregistrerCommande($id_user, $cadeaux, $total)
    {
        try {
            $this->db->beginTransaction();

            // Créer la commande
            $sql = "INSERT INTO COMMANDE (id_user, total, date_commande) VALUES (?, ?, NOW())";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id_user, $total]);
        $id_commande = $this->db->lastInsertId();

            // Enregistrer les détails de la commande
            $sql = "INSERT INTO COMMANDE_DETAILS (id_commande, id_cadeaux) VALUES (?, ?)";
        $stmt = $this->db->prepare($sql);
        foreach ($cadeaux as $cadeau) {
            $stmt->execute([$id_commande, $cadeau['id_cadeaux']]);
        }

            // Mettre à jour le solde
            $sql = "INSERT INTO DEPOT (id_user, montant, status_depot) VALUES (?, ?, 'valide')";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id_user, -$total]);

            $this->db->commit();
            return true;
        } catch (Exception $e) {
            $this->db->rollBack();
            return false;
        }
    }
}
