
<?php
    include '../controller/EvenementController.php';
    $eventC=new EvenementController();
    $eventC->deleteevenement($_GET["id"]);
    header('Location:dash.php');
?>


