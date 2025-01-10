<!-- views/admin/commission.php -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Paramétrage des Commissions - Joyeux Noël</title>
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

        .nav-link.active {
            background: #c41e3a;
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

        .commission-form {
            max-width: 500px;
            margin: 20px auto;
            padding: 20px;
            background: rgba(255, 255, 255, 0.95);
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
            color: #333;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        input[type="number"] {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
        }

        .btn-submit {
            background-color: #c41e3a;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            width: 100%;
        }

        .btn-submit:hover {
            background-color: #a01830;
        }

        .current-commission {
            margin-bottom: 20px;
            padding: 10px;
            background: #f8f8f8;
            border-radius: 4px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="christmas-decoration"></div>
    
    <nav class="navbar">
        <div class="nav-links">
            <a href="/admin" class="nav-link">
                <i class="fas fa-home"></i>
                Accueil
            </a>
            <a href="/ajout" class="nav-link active">
                <i class="fas fa-gift"></i>
                Cadeaux
            </a>
        </div>
        <a href="/logout" class="nav-link">
            <i class="fas fa-sign-out-alt"></i>
            Déconnexion
        </a>
    </nav>

    <div class="main-content">
        <div class="christmas-header">
            <i class="fas fa-percentage"></i>
            <h1>Paramétrage des Commissions</h1>
            <i class="fas fa-cog"></i>
        </div>

        <div class="commission-form">
            <div class="current-commission">
                <h3>Taux de commission actuel</h3>
                <p style="font-size: 24px; color: #c41e3a;"><?= number_format($commission['taux'], 2) ?>%</p>
                <p>Dernière modification : <?= date('d/m/Y H:i', strtotime($commission['date_modification'])) ?></p>
            </div>

            <form action="/admin/commission" method="POST">
                <div class="form-group">
                    <label for="taux">Nouveau taux de commission (%)</label>
                    <input type="number" id="taux" name="taux" min="0" max="100" step="0.01" required>
                </div>
                <button type="submit" class="btn-submit">
                    <i class="fas fa-save"></i> Enregistrer
                </button>
            </form>
        </div>
    </div>
</body>
</html>