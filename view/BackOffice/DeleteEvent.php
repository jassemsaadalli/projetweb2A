
<?php
    include '../../controller/EvenementController.php';
    require_once('../../config.php');
    $eventC=new EvenementController();
    $eventC->deleteevenement($_GET["id"]);
    header('Location:BackOfficeDashboard.php');
?>


