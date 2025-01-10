<?php

namespace app\controllers;

use app\models\UserModel;
use Flight;


class UserController
{
    private $userModel;

    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $this->userModel = new UserModel(Flight::db());
    }

    public function login()
    {
        $email = Flight::request()->data->email;
        $password = Flight::request()->data->password;

        $user = $this->userModel->getUserConnecte($email, $password);

        if ($user) {
            // Utiliser les variables de session directement
            $_SESSION['user'] = $user;

            if ($this->userModel->estAdmin($user['id_user'])) {
                Flight::redirect("/admin");
            } else {
                Flight::redirect("/accueil");
            }
        } else {
            $_SESSION['login_error'] = 'Email ou mot de passe incorrect';
            Flight::render("user/login", [
                'error' => $_SESSION['login_error'] ?? null,
                'email' => $email
            ]);
            // Nettoyer le message d'erreur après l'avoir affiché

            unset($_SESSION['login_error']);
        }
    }

    public function showLoginForm()
    {
        Flight::render('user/login', [
            'error' => $_SESSION['login_error'] ?? null
        ]);
    }

    public function showRegisterForm()
    {
        Flight::render('user/register', [
            'error' => $_SESSION['register_error'] ?? null
        ]);
    }

    public function register()
    {
        $email = Flight::request()->data->email;
        $password = Flight::request()->data->password;
        $confirm_password = Flight::request()->data->confirm_password;

        // Validation des données
        $errors = [];

        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Email invalide";
        }

        if (strlen($password) < 8) {
            $errors[] = "Le mot de passe doit contenir au moins 8 caractères";
        }

        if ($password !== $confirm_password) {
            $errors[] = "Les mots de passe ne correspondent pas";
        }

        if ($this->userModel->emailExists($email)) {
            $errors[] = "Cette adresse email est déjà utilisée";
        }

        if (!empty($errors)) {
            $_SESSION['register_error'] = implode(', ', $errors);
            Flight::redirect('/register');
            return;
        }

        $id_user = $this->userModel->create($email, $password);
        if ($id_user) {
            $user = $this->userModel->getUser($id_user);
            $_SESSION['user'] = $user;
            Flight::redirect('/Accueil');
        } else {
            $_SESSION['register_error'] = 'Erreur lors de la création du compte';
            Flight::redirect('/register');
        }
    }

    public function showAccueil()
    {
        if (!isset($_SESSION['user'])) {
            Flight::redirect('/');
            return;
        }

        // Récupérer le solde validé de l'utilisateur
        $solde = $this->userModel->getSoldeValide($_SESSION['user']['id_user']);

        Flight::render('user/Accueil', [
            'solde' => $solde,
            'error' => $_SESSION['error'] ?? null
        ]);

        if (isset($_SESSION['error'])) {
            unset($_SESSION['error']);
        }
    }

    public function selectionnerCadeaux()
    {
        if (!isset($_SESSION['user'])) {
            Flight::redirect('/');
            return;
        }

        $nb_filles = (int)Flight::request()->data->nb_filles;
        $nb_garcons = (int)Flight::request()->data->nb_garcons;

        // Vérifier qu'il y a au moins un enfant
        if ($nb_filles + $nb_garcons === 0) {
            $_SESSION['error'] = 'Veuillez indiquer au moins un enfant';
            Flight::redirect('/accueil');
            return;
        }

        // Récupérer les suggestions de cadeaux
        $suggestions = $this->userModel->getSuggestionsCadeaux($nb_filles, $nb_garcons);

        // Sauvegarder les informations dans la session
        $_SESSION['selection'] = [
            'nb_filles' => $nb_filles,
            'nb_garcons' => $nb_garcons,
            'cadeaux' => $suggestions
        ];

        Flight::render('user/selection-cadeaux', [
            'cadeaux' => $suggestions,
            'solde' => $this->userModel->getSoldeValide($_SESSION['user']['id_user'])
        ]);
    }

    public function afficherSelectionCadeaux()
    {
        if (!isset($_SESSION['user']) || !isset($_SESSION['selection'])) {
            Flight::redirect('/');
            return;
        }

        Flight::render('user/selection-cadeaux', [
            'cadeaux' => $_SESSION['selection']['cadeaux'],
            'solde' => $this->userModel->getSoldeValide($_SESSION['user']['id_user'])
        ]);
    }

    public function changerCadeau()
    {
        if (!isset($_SESSION['user']) || !isset($_SESSION['selection'])) {
            Flight::redirect('/');
            return;
        }

        $id_cadeau_actuel = Flight::request()->data->id_cadeau;
        $type = Flight::request()->data->type; // 'fille', 'garcon', ou 'neutre'

        // Récupérer un nouveau cadeau aléatoire
        $nouveau_cadeau = $this->userModel->getNouveauCadeauAleatoire($type, [$id_cadeau_actuel]);

        // Mettre à jour la sélection en session
        foreach ($_SESSION['selection']['cadeaux'] as &$cadeau) {
            if ($cadeau['id_cadeaux'] == $id_cadeau_actuel) {
                $cadeau = $nouveau_cadeau;
                break;
            }
        }

        Flight::redirect('/selection-cadeaux');
    }

    public function validerCadeaux()
    {
        if (!isset($_SESSION['user']) || !isset($_SESSION['selection'])) {
            Flight::redirect('/');
            return;
        }

        $total = 0;
        foreach ($_SESSION['selection']['cadeaux'] as $cadeau) {
            $total += $cadeau['prix'];
        }

        $solde = $this->userModel->getSoldeValide($_SESSION['user']['id_user']);

        if ($total > $solde) {
            $_SESSION['error'] = 'Le total des cadeaux dépasse votre solde disponible';
            Flight::redirect('/selection-cadeaux');
            return;
        }

        // Enregistrer la commande
        $success = $this->userModel->enregistrerCommande(
            $_SESSION['user']['id_user'],
            $_SESSION['selection']['cadeaux'],
            $total
        );

        if ($success) {
            unset($_SESSION['selection']);
            $_SESSION['success'] = 'Votre commande a été validée avec succès !';
            Flight::redirect('/accueil');
        } else {
            $_SESSION['error'] = 'Une erreur est survenue lors de la validation de votre commande';
            Flight::redirect('/selection-cadeaux');
        }
    }

    public function changerTousCadeaux()
    {
        if (!isset($_SESSION['user']) || !isset($_SESSION['selection'])) {
            Flight::redirect('/');
            return;
        }

        // Récupérer les IDs des cadeaux actuels pour les exclure
        $ids_actuels = array_column($_SESSION['selection']['cadeaux'], 'id_cadeaux');

        // Pour chaque cadeau dans la sélection
        foreach ($_SESSION['selection']['cadeaux'] as &$cadeau) {
            // Obtenir un nouveau cadeau aléatoire du même type
            $nouveau_cadeau = $this->userModel->getNouveauCadeauAleatoire(
                $cadeau['categorie'],
                $ids_actuels // Exclure les cadeaux déjà sélectionnés
            );

            if ($nouveau_cadeau) {
                $cadeau = $nouveau_cadeau;
                // Ajouter le nouvel ID à la liste des IDs à exclure
                $ids_actuels[] = $nouveau_cadeau['id_cadeaux'];
            }
        }

        Flight::redirect('/selection-cadeaux');
    }
    public function logout()
    {
        // Détruire la session
        session_unset();
        session_destroy();
        Flight::redirect('/');
    }
}
