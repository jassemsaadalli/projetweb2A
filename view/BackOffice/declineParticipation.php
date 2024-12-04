<?php
require_once('../../config.php');
require_once('../../controller/ParticipationC.php');  
require_once('../../controller/EvenementController.php'); 
require_once('../../controller/userC.php'); // Inclure le contrôleur des utilisateurs
require_once('../mail.php'); // Inclure la fonction sendEmail

if (isset($_GET['id'])) {
    $participation_id = (int)$_GET['id'];  

    // Récupérer les détails du participant avant de supprimer la participation
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
            $eventName = $event['titre']; // Supposons que "titre" est le nom de l'événement

            // Détails de l'email
            $to = $userEmail;
            $subject = "Participation Declinee - $eventName";
            $body = "
                <p>Bonjour {$user['name']},</p>
                <p>Nous sommes desoles, mais votre demande de participation a l\'evenement <strong>$eventName</strong> a ete declinee.</p>
                <p>Nous vous remercions pour votre comprehension et esperons vous voir dans de futurs evenements.</p>
                <p>Cordialement,<br>L\'equipe de gestion des evenements</p>
            ";

            // Envoyer l'email
            if (sendEmail($to, $subject, $body)) {
                // Une fois l'email envoyé, supprimer la participation
                $declined = ParticipationC::declineParticipation($participation_id);

                if ($declined) {
                    header("Location: BackOfficeDashboard.php?section=participations&message=Participation déclinée avec succès et email envoyé.");
                } else {
                    echo "<script>alert('Erreur : Participation n\'a pas pu être déclinée.');</script>";
                }
            } else {
                echo "<script>alert('Participation déclinée, mais l\'email n\'a pas pu être envoyé.');</script>";
            }
        } else {
            echo "<script>alert('Participation déclinée, mais l\'utilisateur est introuvable.');</script>";
        }
    } else {
        echo "<script>alert('Participation déclinée, mais les détails du participant sont introuvables.');</script>";
    }
} else {
    echo "<script>alert('Erreur : ID de participation manquant.');</script>";
}
?>
