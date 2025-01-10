<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Administration des Dépôts - Joyeux Noël</title>
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

        /* Nouveau style pour la navbar */
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

        .nav-link.active {
            background: #c41e3a;
        }

        .logout-link {
            color: #ff9999;
        }

        /* Ajustement du padding pour le contenu principal */
        .main-content {
            padding: 20px;
        }

        /* Styles existants maintenus... */
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

        .depot-container {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 10px;
            padding: 20px;
            margin-top: 20px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
            color: #333;
        }

        th {
            background: #c41e3a;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f8f8f8;
        }

        .status {
            padding: 5px 10px;
            border-radius: 15px;
            font-weight: bold;
        }

        .en-attente {
            background-color: #ffd700;
            color: #000;
        }

        .valide {
            background-color: #4CAF50;
            color: white;
        }

        .btn-valider {
            background-color: #1a472a;
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-valider:hover {
            background-color: #2c6a3f;
            transform: scale(1.05);
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
            <a href="/admin" class="nav-link active">
                <i class="fas fa-home"></i>
                Accueil
            </a>
            <a href="/ajout" class="nav-link">
                <i class="fas fa-gift"></i>
                Cadeaux
            </a>
            <a href="/admin/commission" class="nav-link">
                <i class="fas fa-percentage"></i>
                Configuration Commission
            </a>
        </div>
        <a href="/logout" class="nav-link logout-link">
            <i class="fas fa-sign-out-alt"></i>
            Déconnexion
        </a>
    </nav>

    <div class="main-content">
        <div class="christmas-header">
            <i class="fas fa-candy-cane"></i>
            <h1>Administration des Dépôts</h1>
            <i class="fas fa-holly-berry"></i>
        </div>

        <div class="depot-container">
            <table>
                <thead>
                    <tr>
                        <th>ID Dépôt</th>
                        <th>Utilisateur</th>
                        <th>Montant</th>
                        <th>Statut</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($depots as $depot){ ?>
                    <tr>
                        <td><?= htmlspecialchars($depot['id_depot']) ?></td>
                        <td><?= htmlspecialchars($depot['id_user']) ?></td>
                        <td><?= htmlspecialchars($depot['montant']) ?></td>
                        <td>
                            <span class="status <?= $depot['status_depot'] === 'valide' ? 'valide' : 'en_attente' ?>">
                                <?= ucfirst(htmlspecialchars($depot['status_depot'])) ?>
                            </span>
                        </td>
                        <td>
                            <?php if($depot['status_depot'] !== 'valide'){ ?>
                                <form action="/admin/accepter-depot" method="POST" style="display: inline;">
                                    <input type="hidden" name="id_depot" value="<?= $depot['id_depot'] ?>">
                                    <button type="submit" class="btn-valider">
                                        <i class="fas fa-check"></i> Valider
                                    </button>
                                </form>
                            <?php } ?>
                        </td>
                    </tr>
                    <?php }?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        // Ajout d'une animation sur les boutons
        document.querySelectorAll('.btn-valider').forEach(button => {
            button.addEventListener('click', function() {
                this.style.transform = 'scale(0.95)';
                setTimeout(() => {
                    this.style.transform = 'scale(1)';
                }, 100);
            });
        });
    </script>
</body>
</html>