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
    <title>Accueil - Joyeux Noël</title>
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
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        }

        .christmas-header h1 {
            margin: 0;
            font-size: 2.5em;
            color: #fff;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
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
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
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

        .error-message {
            background-color: #ffebee;
            color: #c62828;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
            border: 1px solid #ffcdd2;
        }

        .solde-display {
            background: rgba(255, 255, 255, 0.1);
            padding: 10px 20px;
            border-radius: 25px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .christmas-decoration {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 20px;
            background: repeating-linear-gradient(
                45deg,
                #c41e3a 0px,
                #c41e3a 20px,
                #1a472a 20px,
                #1a472a 40px
            );
        }
    </style>
</head>
<body>
    <div class="christmas-decoration"></div>
    
    <nav class="navbar">
        <div class="nav-links">
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
        <div class="christmas-header">
            <i class="fas fa-gift"></i>
            <h1>Sélection des Cadeaux de Noël</h1>
            <i class="fas fa-star"></i>
        </div>

        <div class="form-container">
            <?php if (isset($error)): ?>
                <div class="error-message">
                    <i class="fas fa-exclamation-circle"></i>
                    <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>

            <form action="/selection-cadeaux" method="POST">
                <div class="form-group">
                    <label for="nb_filles">
                        <i class="fas fa-female"></i>
                        Nombre de filles
                    </label>
                    <input type="number" id="nb_filles" name="nb_filles" min="0" value="0" required>
                </div>

                <div class="form-group">
                    <label for="nb_garcons">
                        <i class="fas fa-male"></i>
                        Nombre de garçons
                    </label>
                    <input type="number" id="nb_garcons" name="nb_garcons" min="0" value="0" required>
                </div>

                <button type="submit" class="submit-btn">
                    <i class="fas fa-magic"></i>
                    Voir les suggestions de cadeaux
                </button>
            </form>
        </div>
    </div>

    <script>
        // Animation des boutons
        document.querySelector('.submit-btn').addEventListener('mousedown', function() {
            this.style.transform = 'scale(0.98)';
        });
        document.querySelector('.submit-btn').addEventListener('mouseup', function() {
            this.style.transform = 'scale(1)';
        });
    </script>
</body>
</html>