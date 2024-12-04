<?php
include(__DIR__ . '/../model/user.php');
require_once('../../model/participation.php');
require_once('../../config.php');

class UserController
{



    
    public static function getUserById($id) {
        try {
            // Assurez-vous que votre connexion à la base de données est configurée
            $db = config::getConnection();
            $query = $db->prepare("SELECT * FROM user WHERE id = :id");
            $query->bindParam(':id', $id, PDO::PARAM_INT);
            $query->execute();
            $participant = $query->fetch(PDO::FETCH_ASSOC);
            return $participant;
        } catch (Exception $e) {
            error_log("Erreur lors de la récupération du participant : " . $e->getMessage());
            return false;
        }
    }
    // Register a user for an event
    public function registerForEvent(int $user_id, int $event_id)
    {
        $db = config::getConnection();

        // Check if the user is already registered for the event
        $existingParticipation = ParticipationC::getByUserAndEvent($db, $user_id, $event_id);

        if ($existingParticipation) {
            echo "You are already registered for this event.";
        } else {
            // Register the user for the event
            $participationController = new ParticipationC();
            if ($participationController->save($user_id, $event_id)) {
                echo "You have successfully registered for the event.";
            } else {
                echo "There was an error registering for the event.";
            }
        }
    }


    public function getUserByIdAndEmail(PDO $db, int $user_id, string $email)
{
    $query = "SELECT * FROM user WHERE id = :user_id AND email = :email";
    $stmt = $db->prepare($query);
    $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->bindValue(':email', $email, PDO::PARAM_STR);
    $stmt->execute();

    return $stmt->fetch(PDO::FETCH_ASSOC); // Returns user data if found, false otherwise
}


    // Show all events the user has participated in
    public function getParticipatedEvents(int $user_id)
    {
        $db = config::getConnection();

        // Fetch all participations for the user
        $query = "SELECT e.id, e.titre, e.date_debut, e.date_fin, p.status 
                  FROM participation p 
                  JOIN event e ON p.event_id = e.id 
                  WHERE p.user_id = :user_id";
        $stmt = $db->prepare($query);
        $stmt->bindValue(':user_id', $user_id);
        $stmt->execute();

        $events = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($events) {
            foreach ($events as $event) {
                echo "Event Title: " . $event['titre'] . "<br>";
                echo "Start Date: " . $event['date_debut'] . "<br>";
                echo "End Date: " . $event['date_fin'] . "<br>";
                echo "Status: " . $event['status'] . "<br><br>";
            }
        } else {
            echo "You have not participated in any events.";
        }
    }

    // Cancel user's participation in an event
    public function cancelParticipation(int $user_id, int $event_id)
    {
        $db = config::getConnection();

        // Check if the user has already registered for the event
        $existingParticipation = ParticipationC::getByUserAndEvent($db, $user_id, $event_id);

        if ($existingParticipation) {
            // Cancel the participation
            if (ParticipationC::cancel($db, $existingParticipation->getId())) {
                echo "Your participation has been canceled.";
            } else {
                echo "There was an error canceling your participation.";
            }
        } else {
            echo "You are not registered for this event.";
        }
    }
}
?>
