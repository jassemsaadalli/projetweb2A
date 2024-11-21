<?php
require_once('../../Controller/produitC.php');

$produitC = new ProduitC();
$produits = $produitC->listProduit();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Produits</title>
    <style>
        /* Style global de la page */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f7f7f7;
            margin: 0;
            padding: 0;
            color: #333;
        }

        /* Header et titre */
        h1 {
            text-align: center;
            color: #2c3e50;
            margin: 20px 0;
            font-size: 2em;
        }

        /* Conteneur principal */
        .container {
            width: 80%;
            margin: 0 auto;
            padding: 20px;
            background-color: white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        /* Lien pour ajouter un produit */
        .add-product {
            display: block;
            text-align: right;
            margin: 10px 0;
            font-size: 1.2em;
            color: #4CAF50;
            text-decoration: none;
        }

        .add-product:hover {
            text-decoration: underline;
        }

        /* Style du tableau */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border: 1px solid #ddd;
        }

        th {
            background-color: #f1f1f1;
            color: #333;
        }

        td {
            background-color: #fff;
        }

        /* Image des produits */
        img {
            border-radius: 4px;
            max-width: 50px;
            height: auto;
        }

        /* Actions */
        a {
            color: #3498db;
            text-decoration: none;
            padding: 5px 10px;
            border-radius: 4px;
            border: 1px solid #3498db;
            transition: all 0.3s ease;
        }

        a:hover {
            background-color: #3498db;
            color: white;
        }

        /* Style pour le lien de suppression */
        a.delete {
            color: #e74c3c;
            border-color: #e74c3c;
        }

        a.delete:hover {
            background-color: #e74c3c;
        }

        /* Gestion des messages d'alerte */
        .alert {
            padding: 10px;
            margin: 15px 0;
            border-radius: 4px;
            color: #fff;
            font-size: 1.2em;
        }

        .alert-success {
            background-color: #2ecc71;
        }

        .alert-danger {
            background-color: #e74c3c;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Liste des Produits</h1>
    <a href="ajouterProduit.php" class="add-product">Ajouter un produit</a>

    <!-- Exemple de message de succès ou erreur -->
    <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success">
            Produit ajouté avec succès !
        </div>
    <?php endif; ?>

    <?php if (isset($_GET['error'])): ?>
        <div class="alert alert-danger">
            Une erreur est survenue lors de l'ajout du produit.
        </div>
    <?php endif; ?>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Prix</th>
                <th>Description</th>
                <th>Inventaire</th>
                <th>Image</th>
                <th>Catégorie</th>
                <th>Utilisateur</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($produits as $produit): ?>
                <tr>
                    <td><?= $produit['idProduit'] ?></td>
                    <td><?= $produit['nom'] ?></td>
                    <td><?= $produit['prix'] ?>€</td>
                    <td><?= $produit['description'] ?></td>
                    <td><?= $produit['inventaire'] ?></td>
                    <td><img src="<?= $produit['image'] ?>" alt="Image produit"></td>
                    <td><?= $produit['idCategorie'] ?></td>
                    <td><?= $produit['id_user'] ?></td>
                    <td>
                        <a href="modifProduit.php?id=<?= $produit['idProduit'] ?>">Modifier</a>
                        <a href="deleteProduit.php?id=<?= $produit['idProduit'] ?>" class="delete">Supprimer</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

</body>
</html>
