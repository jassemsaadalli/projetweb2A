<?php
require_once 'mail.php';

$to = 'mohamedelbachir.benattia@esprit.tn';
$subject = 'Test Email';
$body = '<p>Ceci est un test de PHPMailer.</p>';

if (sendEmail($to, $subject, $body)) {
    echo "Email envoyé avec succès !";
} else {
    echo "Erreur lors de l'envoi de l'email.";
}
