<?php
// Inclure la bibliothèque FPDF
require_once('../view/fpdf184/fpdf.php'); // Assurez-vous que le chemin est correct

// Inclure votre contrôleur d'utilisateurs
include '../controller/usercontroller.php';

// Instancier le contrôleur
$controller = new UserController();

// Récupérer tous les utilisateurs (vous pouvez ajuster cette partie selon votre logique de récupération des données)
$users = $controller->listUsers(); 

// Créer une instance de FPDF
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 12);

// En-tête du tableau
$pdf->Cell(20, 10, 'ID', 1);
$pdf->Cell(40, 10, 'First Name', 1);
$pdf->Cell(40, 10, 'Last Name', 1);
$pdf->Cell(60, 10, 'Email', 1);
$pdf->Cell(30, 10, 'Role', 1);
$pdf->Ln();

// Ajouter les données des utilisateurs
foreach ($users as $user) {
    $pdf->Cell(20, 10, $user['id'], 1);
    $pdf->Cell(40, 10, $user['firstname'], 1);
    $pdf->Cell(40, 10, $user['lastname'], 1);
    $pdf->Cell(60, 10, $user['email'], 1);
    $pdf->Cell(30, 10, $user['role'], 1);
    $pdf->Ln();
}

// Générer le PDF et l'envoyer au navigateur
$pdf->Output('I', 'users_list.pdf'); // 'I' affiche le PDF dans le navigateur
?>
