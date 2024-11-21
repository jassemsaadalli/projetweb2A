<?php
require_once('../../Controller/produitC.php');
require_once('../../Model/produit.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $produit = new Produit(
        null,
        $_POST['nom'],
        $_POST['prix'],
        $_POST['description'],
        $_POST['inventaire'],
        $_POST['image'],
        $_POST['idCategorie'],
        $_POST['id_user']
    );

    $produitC = new ProduitC();
    $produitC->ajouterProduit($produit);
    header('Location: listProduit.php');
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un Produit</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 50px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            color: #333;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        label {
            font-size: 14px;
            margin-bottom: 6px;
            color: #333;
        }
        input, textarea, select {
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
        }
        textarea {
            resize: vertical;
            min-height: 100px;
        }
        button {
            background-color: #4CAF50;
            color: white;
            font-size: 16px;
            padding: 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        button:hover {
            background-color: #45a049;
        }
        .form-group {
            display: flex;
            flex-direction: column;
        }
        .form-group input,
        .form-group textarea {
            width: 100%;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Ajouter un Produit</h1>
        <form method="POST" action="">
            <div class="form-group">
                <label for="nom">Nom :</label>
                <input type="text" id="nom" name="nom" required>
            </div>

            <div class="form-group">
                <label for="prix">Prix :</label>
                <input type="text" id="prix" name="prix" required>
            </div>

            <div class="form-group">
                <label for="description">Description :</label>
                <textarea id="description" name="description" required></textarea>
            </div>

            <div class="form-group">
                <label for="inventaire">Inventaire :</label>
                <input type="number" id="inventaire" name="inventaire" required>
            </div>

            <div class="form-group">
                <label for="image">Image :</label>
                <input type="text" id="image" name="image">
            </div>

            <div class="form-group">
                <label for="idCategorie">Catégorie :</label>
                <input type="number" id="idCategorie" name="idCategorie" required>
            </div>

            <div class="form-group">
                <label for="id_user">Utilisateur :</label>
                <input type="number" id="id_user" name="id_user" required>
            </div>

            <button type="submit">Ajouter</button>
        </form>
    </div>
</body>
</html>
