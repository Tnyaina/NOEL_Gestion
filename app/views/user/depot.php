<?php
if (!isset($_SESSION['user'])) {
    Flight::redirect('/');
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Faire un dépôt - Joyeux Noël</title>
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

        .navbar {
            background: linear-gradient(145deg, #1a472a 0%, #0c2315 100%);
            padding: 15px 30px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
            display: flex;
            justify-content: space-between;
            align-items: center;
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
        }

        .nav-link:hover {
            background: rgba(255, 255, 255, 0.1);
        }

        .main-content {
            max-width: 600px;
            margin: 40px auto;
            padding: 20px;
        }

        .depot-form {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 10px;
            padding: 20px;
            color: #333;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        }

        .form-title {
            text-align: center;
            color: #1a472a;
            margin-bottom: 20px;
            font-size: 1.5em;
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
            box-sizing: border-box;
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
        }

        .error-message {
            background-color: #ffebee;
            color: #c62828;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
            border: 1px solid #ffcdd2;
        }

        .success-message {
            background-color: #e8f5e9;
            color: #2e7d32;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
            border: 1px solid #c8e6c9;
        }

        .solde-display {
            background: rgba(255, 255, 255, 0.1);
            padding: 10px 20px;
            border-radius: 25px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="nav-links">
            <a href="/accueil" class="nav-link">
                <i class="fas fa-home"></i> Accueil
            </a>
            <span class="solde-display">
                <i class="fas fa-wallet"></i>
                Solde: <?= number_format($solde, 2) ?> €
            </span>
        </div>
        <a href="/logout" class="nav-link">
            <i class="fas fa-sign-out-alt"></i> Déconnexion
        </a>
    </nav>

    <div class="main-content">
        <div class="depot-form">
            <h2 class="form-title">
                <i class="fas fa-euro-sign"></i> Faire un dépôt
            </h2>

            <h3 style="font-size: 24px; color: #c41e3a;">Taux de commission actuel : <?= number_format($commission['taux'], 2) ?>%</h3>

            <?php if (isset($error)): ?>
                <div class="error-message">
                    <i class="fas fa-exclamation-circle"></i>
                    <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>

            <?php if (isset($success)): ?>
                <div class="success-message">
                    <i class="fas fa-check-circle"></i>
                    <?= htmlspecialchars($success) ?>
                </div>
            <?php endif; ?>

            <form action="/depot" method="POST">
                <div class="form-group">
                    <label for="montant">
                        <i class="fas fa-money-bill-wave"></i>
                        Montant du dépôt (€)
                    </label>
                    <input type="number" id="montant" name="montant" step="0.01" min="0" required>
                </div>

                <button type="submit" class="submit-btn">
                    <i class="fas fa-paper-plane"></i>
                    Envoyer la demande de dépôt
                </button>
            </form>
        </div>
    </div>
</body>
</html>