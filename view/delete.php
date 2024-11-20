<?php
    include '../controller/formC.php';
    $formC=new portes();
    $formC->deleteform($_GET["id"]);
    header('Location:dashboard.php');
?>


