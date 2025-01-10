<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Gestion des Cadeaux - Joyeux Noël</title>
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

        .cadeau-container {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 10px;
            padding: 20px;
            margin-top: 20px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        .btn-ajouter {
            background-color: #c41e3a;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            margin-bottom: 20px;
            transition: all 0.3s ease;
        }

        .btn-ajouter:hover {
            background-color: #a01830;
            transform: translateY(-2px);
        }

        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background: white;
            padding: 20px;
            border-radius: 10px;
            width: 400px;
            color: #333;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        input,
        select {
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
            color: #333;
        }

        th {
            background: #c41e3a;
            color: white;
        }

        .btn-modifier {
            background-color: #1a472a;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 3px;
            cursor: pointer;
            margin-right: 5px;
        }

        .btn-supprimer {
            background-color: #c41e3a;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 3px;
            cursor: pointer;
        }

        .christmas-decoration {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 20px;
            background: repeating-linear-gradient(45deg,
                    #c41e3a 0px,
                    #c41e3a 20px,
                    #1a472a 20px,
                    #1a472a 40px);
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
            <i class="fas fa-gift"></i>
            <h1>Gestion des Cadeaux</h1>
            <i class="fas fa-gift"></i>
        </div>

        <div class="cadeau-container">
            <button class="btn-ajouter" onclick="showModal()">
                <i class="fas fa-plus"></i> Ajouter un cadeau
            </button>

            <table>
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Nom</th>
                        <th>Catégorie</th>
                        <th>Prix</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cadeaux as $cadeau) { ?>
                        <tr>
                            <td style="width: 120px; text-align: center;">
                                <?php if (!empty($cadeau['photo_url'])) { ?>
                                    <img src="<?= htmlspecialchars($cadeau['photo_url']) ?>"
                                        alt="Photo du cadeau"
                                        style="max-width: 100px; max-height: 100px; object-fit: cover; border-radius: 5px; box-shadow: 0 2px 5px rgba(0,0,0,0.2);">
                                <?php } else { ?>
                                    <div style="width: 100px; height: 100px; background-color: #f0f0f0; border-radius: 5px; display: flex; align-items: center; justify-content: center;">
                                        <i class="fas fa-image" style="color: #999; font-size: 24px;"></i>
                                    </div>
                                <?php } ?>
                            </td>
                            <td><?= htmlspecialchars($cadeau['nom']) ?></td>
                            <td><?= htmlspecialchars($cadeau['categorie']) ?></td>
                            <td><?= htmlspecialchars($cadeau['prix']) ?> €</td>
                            <td>
                                <button class="btn-modifier" onclick="showEditModal(<?= htmlspecialchars(json_encode($cadeau)) ?>)">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <form action="/cadeaux/supprimer" method="POST" style="display: inline;">
                                    <input type="hidden" name="id_cadeaux" value="<?= $cadeau['id_cadeaux'] ?>">
                                    <button type="submit" class="btn-supprimer" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce cadeau ?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal Ajout -->
    <div id="addModal" class="modal">
        <div class="modal-content">
            <h2>Ajouter un cadeau</h2>
            <form action="/cadeaux/ajouter" method="POST" enctype="multipart/form-data">
                <input type="text" name="nom" placeholder="Nom du cadeau" required>
                <select name="categorie" required>
                    <option value="fille">Fille</option>
                    <option value="garcon">Garçon</option>
                    <option value="neutre">Neutre</option>
                </select>
                <input type="number" step="0.01" name="prix" placeholder="Prix" required>
                <input type="file" name="photo" accept="image/*" required>
                <button type="submit" class="btn-ajouter">Ajouter</button>
                <button type="button" class="btn-supprimer" onclick="hideModal()">Annuler</button>
            </form>
        </div>
    </div>

    <!-- Modal Modification -->
    <div id="editModal" class="modal">
        <div class="modal-content">
            <h2>Modifier un cadeau</h2>
            <form action="/cadeaux/modifier" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id_cadeaux" id="edit_id_cadeaux">
                <input type="text" name="nom" id="edit_nom" placeholder="Nom du cadeau" required>
                <select name="categorie" id="edit_categorie" required>
                    <option value="fille">Fille</option>
                    <option value="garcon">Garçon</option>
                    <option value="neutre">Neutre</option>
                </select>
                <input type="number" step="0.01" name="prix" id="edit_prix" placeholder="Prix" required>
                <input type="file" name="photo" accept="image/*">
                <img id="current_photo" src="" alt="Photo actuelle" style="max-width: 200px; display: none;">
                <button type="submit" class="btn-ajouter">Modifier</button>
                <button type="button" class="btn-supprimer" onclick="hideEditModal()">Annuler</button>
            </form>
        </div>
    </div>

    <script>
        function showModal() {
            document.getElementById('addModal').style.display = 'flex';
        }

        function hideModal() {
            document.getElementById('addModal').style.display = 'none';
        }

        function showEditModal(cadeau) {
            document.getElementById('edit_id_cadeaux').value = cadeau.id_cadeaux;
            document.getElementById('edit_nom').value = cadeau.nom;
            document.getElementById('edit_categorie').value = cadeau.categorie;
            document.getElementById('edit_prix').value = cadeau.prix;
            document.getElementById('editModal').style.display = 'flex';
        }

        function hideEditModal() {
            document.getElementById('editModal').style.display = 'none';
        }

        // Fermer les modals si on clique en dehors
        window.onclick = function(event) {
            if (event.target.className === 'modal') {
                event.target.style.display = 'none';
            }
        }
    </script>
</body>

</html>