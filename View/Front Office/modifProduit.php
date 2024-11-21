<?php
require_once('../../Controller/produitC.php');
require_once('../../Model/produit.php');

$produitC = new ProduitC();
$produit = $produitC->showProduit($_GET['id']);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $updatedProduit = new Produit(
        $_GET['id'],
        $_POST['nom'],
        $_POST['prix'],
        $_POST['description'],
        $_POST['inventaire'],
        $_POST['image'],
        $_POST['idCategorie'],
        $_POST['id_user']
    );

    $produitC->updateProduit($updatedProduit, $_GET['id']);
    header('Location: listProduit.php');
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Modifier un Produit</title>
</head>
<body>
    <form method="POST" action="">
        <label>Nom:</label><input type="text" name="nom" value="<?= $produit['nom'] ?>" required><br>
        <label>Prix:</label><input type="text" name="prix" value="<?= $produit['prix'] ?>" required><br>
        <label>Description:</label><textarea name="description" required><?= $produit['description'] ?></textarea><br>
        <label>Inventaire:</label><input type="number" name="inventaire" value="<?= $produit['inventaire'] ?>" required><br>
        <label>Image:</label><input type="text" name="image" value="<?= $produit['image'] ?>"><br>
        <label>Catégorie:</label><input type="number" name="idCategorie" value="<?= $produit['idCategorie'] ?>" required><br>
        <label>Utilisateur:</label><input type="number" name="id_user" value="<?= $produit['id_user'] ?>" required><br>
        <button type="submit">Modifier</button>
    </form>
</body>
</html>
