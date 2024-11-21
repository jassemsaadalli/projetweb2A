<?php
require_once('../../Controller/produitC.php');

if (isset($_GET['id'])) {
    $produitC = new ProduitC();
    $produitC->deleteProduit($_GET['id']);
    header('Location: listProduit.php');
}
?>
