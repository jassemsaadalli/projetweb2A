<?php
require_once('../../config.php');
require_once('../../controller/participationC.php');  
require_once('../../controller/EvenementController.php'); 
require_once('../../controller/userC.php'); // Nouveau : inclure le contrôleur des utilisateurs
require_once('../mail.php'); // Inclure la fonction sendEmail

if (isset($_GET['id'])) {
    $participation_id = (int)$_GET['id'];  

    // Accepter la participation
    $accepted = ParticipationC::acceptParticipation($participation_id);

    if ($accepted) {
        // Récupérer les détails du participant
        $participant = ParticipationC::getParticipantById($participation_id); 
        if ($participant) {
            $userId = $participant['user_id']; // Récupérer l'ID de l'utilisateur lié
            $eventId = $participant['event_id']; // Récupérer l'ID de l'événement

            // Récupérer les détails de l'utilisateur (email)
            $user = UserController::getUserById($userId);
            if ($user) {
                $userEmail = $user['email']; // Supposons que "email" est un champ dans la table des utilisateurs
                
                // Récupérer le nom de l'événement
                $event = EvenementController::getEventById($eventId); 
                $eventName = $event['titre']; // Supposons que "name" est un champ dans les données de l'événement
                
                // Détails de l'email
                $to = $userEmail;
                $subject = "Participation Acceptee - $eventName";
                $body = "
                    <p>Bonjour {$user['name']},</p>
                    <p>Felicitations ! Votre demande de participation a levenement <strong>$eventName</strong> a ete acceptee.</p>
                    <p>Nous avons hate de vous voir lors de l\'evenement !</p>
                    <p>Cordialement,<br>L\'equipe de gestion des evenements</p>
                ";

                // Envoyer l'email
                if (sendEmail($to, $subject, $body)) {
                    header("Location: BackOfficeDashboard.php?section=participations&message=Participation acceptée avec succès et email envoyé.");
                } else {
                    echo "<script>alert('Participation acceptée, mais l\'email n\'a pas pu être envoyé.');</script>";
                }
            } else {
                echo "<script>alert('Participation acceptée, mais l\'utilisateur est introuvable.');</script>";
            }
        } else {
            echo "<script>alert('Participation acceptée, mais les détails du participant sont introuvables.');</script>";
        }
    } else {
        echo "<script>alert('Erreur : Participation introuvable ou n\'a pas pu être acceptée.');</script>";
    }
} else {
    echo "<script>alert('Erreur : ID de participation manquant.');</script>";
}
