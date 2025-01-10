<?php
if (!isset($_SESSION['user']) || !isset($_SESSION['selection'])) {
    Flight::redirect('/');
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Sélection des Cadeaux - Joyeux Noël</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #1a472a;
            background-image:
                radial-gradient(#ffffff 1px, transparent 1px),
                radial-gradient(#ffffff 1px, transparent 1px);
            background-size: 50px 50px;
            background-position: 0 0, 25px 25px;
            margin: 0;
            padding: 0;
            color: #fff;
        }

        h3 {
            color: #0c2315;
        }

        .navbar {
            background: linear-gradient(145deg, #1a472a 0%, #0c2315 100%);
            padding: 15px 30px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 20px;
            z-index: 1000;
        }

        .nav-links {
            display: flex;
            gap: 20px;
            align-items: center;
        }

        .nav-link {
            color: white;
            text-decoration: none;
            padding: 8px 16px;
            border-radius: 25px;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .nav-link:hover {
            background: rgba(255, 255, 255, 0.1);
            transform: translateY(-2px);
        }

        .logout-link {
            color: #ff9999;
        }

        .main-content {
            padding: 20px;
        }

        .christmas-header {
            text-align: center;
            margin-bottom: 30px;
            padding: 20px;
            background: linear-gradient(145deg, #c41e3a 0%, #8b0000 100%);
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        .christmas-header h1 {
            margin: 0;
            font-size: 2.5em;
            color: #fff;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
        }

        .christmas-header i {
            font-size: 2em;
            margin: 10px;
            color: #fff;
        }

        .form-container {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 10px;
            padding: 20px;
            margin-top: 20px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            color: #333;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        .form-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
        }

        .submit-btn {
            background-color: #c41e3a;
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            width: 100%;
            transition: all 0.3s ease;
        }

        .submit-btn:hover {
            background-color: #a01830;
            transform: scale(1.02);
        }

        .cadeaux-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
            padding: 20px;
        }

        .cadeau-card {
            background: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
            position: relative;
        }

        .cadeau-card:hover {
            transform: translateY(-5px);
        }

        .cadeau-type {
            position: absolute;
            top: 10px;
            right: 10px;
            padding: 5px 10px;
            border-radius: 15px;
            font-size: 0.8em;
        }

        .type-fille {
            background-color: #FF69B4;
            color: white;
        }

        .type-garcon {
            background-color: #4169E1;
            color: white;
        }

        .type-neutre {
            background-color: #808080;
            color: white;
        }

        .cadeau-prix {
            font-size: 1.5em;
            color: #c41e3a;
            margin: 10px 0;
        }

        .changer-btn {
            background-color: #1a472a;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .changer-btn:hover {
            background-color: #2c6a3f;
        }

        .total-section {
            background: white;
            padding: 20px;
            border-radius: 10px;
            margin: 20px;
            text-align: right;
            color: #333;
        }

        .total-montant {
            font-size: 1.5em;
            color: #c41e3a;
            margin-left: 10px;
        }

        .valider-btn {
            background-color: #c41e3a;
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 5px;
            font-size: 1.1em;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 20px;
        }

        .valider-btn:hover {
            background-color: #a01830;
        }

        .error-message {
            background-color: #ffebee;
            color: #c62828;
            padding: 15px;
            margin: 20px;
            border-radius: 5px;
            border: 1px solid #ffcdd2;
        }

        .action-buttons {
            padding: 20px;
            text-align: center;
        }

        .changer-tous-btn {
            background-color: #2c6a3f;
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1.1em;
            transition: all 0.3s ease;
            margin-bottom: 20px;
        }

        .changer-tous-btn:hover {
            background-color: #3d8b54;
            transform: scale(1.05);
        }

        .changer-tous-btn i {
            margin-right: 8px;
        }
    </style>
</head>

<body>
    <div class="christmas-decoration"></div>

    <nav class="navbar">
        <div class="nav-links">
            <a href="/accueil" class="nav-link">
                <i class="fas fa-home"></i>
                Retour
            </a>
            <span class="solde-display">
                <i class="fas fa-wallet"></i>
                Solde: <?= number_format($solde, 2) ?> €
            </span>
        </div>
        <a href="/logout" class="nav-link logout-link">
            <i class="fas fa-sign-out-alt"></i>
            Déconnexion
        </a>
    </nav>

    <div class="main-content">
        <?php if (isset($_SESSION['error'])): ?>
            <div class="error-message">
                <i class="fas fa-exclamation-circle"></i>
                <?= htmlspecialchars($_SESSION['error']) ?>
            </div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>

        <div class="action-buttons">
            <form action="/changer-tous-cadeaux" method="POST" style="text-align: center; margin-bottom: 20px;">
                <button type="submit" class="changer-tous-btn">
                    <i class="fas fa-sync-alt"></i>
                    Changer toutes les suggestions
                </button>
            </form>
        </div>

        <!-- Ajout des styles pour l'image -->
<style>
    .cadeau-card {
        background: white;
        border-radius: 10px;
        padding: 20px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease;
        position: relative;
        display: flex;
        flex-direction: column;
    }

    .cadeau-image {
        width: 100%;
        height: 200px;
        margin-bottom: 15px;
        border-radius: 8px;
        overflow: hidden;
        display: flex;
        justify-content: center;
        align-items: center;
        background-color: #f5f5f5;
    }

    .cadeau-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .cadeau-image .no-image {
        color: #999;
        font-size: 40px;
    }

    .cadeau-details {
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }
</style>

<!-- Mise à jour de la structure de la carte -->
<div class="cadeaux-grid">
    <?php foreach ($_SESSION['selection']['cadeaux'] as $index => $cadeau): ?>
        <div class="cadeau-card">
            <span class="cadeau-type type-<?= htmlspecialchars($cadeau['categorie']) ?>">
                <?= ucfirst(htmlspecialchars($cadeau['categorie'])) ?>
            </span>
            
            <div class="cadeau-image">
                <?php if (!empty($cadeau['photo_url'])) : ?>
                    <img src="<?= htmlspecialchars($cadeau['photo_url']) ?>" 
                         alt="Photo de <?= htmlspecialchars($cadeau['nom']) ?>">
                <?php else : ?>
                    <i class="fas fa-gift no-image"></i>
                <?php endif; ?>
            </div>

            <div class="cadeau-details">
                <h3><?= htmlspecialchars($cadeau['nom']) ?></h3>
                <div class="cadeau-prix"><?= number_format($cadeau['prix'], 2) ?> €</div>
                <form action="/changer-cadeau" method="POST">
                    <input type="hidden" name="id_cadeau" value="<?= $cadeau['id_cadeaux'] ?>">
                    <input type="hidden" name="type" value="<?= $cadeau['categorie'] ?>">
                    <button type="submit" class="changer-btn">
                        <i class="fas fa-sync-alt"></i>
                        Changer ce cadeau
                    </button>
                </form>
            </div>
        </div>
    <?php endforeach; ?>
</div>

        <div class="total-section">
            <span>Total des cadeaux:</span>
            <span class="total-montant">
                <?= number_format(array_sum(array_column($_SESSION['selection']['cadeaux'], 'prix')), 2) ?> €
            </span>
            <form action="/valider-cadeaux" method="POST">
                <button type="submit" class="valider-btn">
                    <i class="fas fa-check-circle"></i>
                    Valider la sélection
                </button>
            </form>
        </div>
    </div>
</body>

</html>