<?php
require_once('../../Controller/produitC.php');

$produitC = new ProduitC();
$produit = $produitC->showProduit($_GET['id']);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Détails du Produit</title>
</head>
<body>
    <h1>Détails du Produit</h1>
    <p><strong>Nom:</strong> <?= $produit['nom'] ?></p>
    <p><strong>Prix:</strong> <?= $produit['prix'] ?></p>
    <p><strong>Description:</strong> <?= $produit['description'] ?></p>
    <p><strong>Inventaire:</strong> <?= $produit['inventaire'] ?></p>
    <p><strong>Image:</strong> <img src="<?= $produit['image'] ?>" width="100"></p>
    <p><strong>Catégorie:</strong> <?= $produit['idCategorie'] ?></p>
    <p><strong>Utilisateur:</strong> <?= $produit['id_user'] ?></p>
</body>
</html>
