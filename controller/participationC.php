<?php
require_once('../../model/participation.php');
require_once('../../config.php');
class ParticipationC
{



    public static function getParticipantById($id) {
        try {
            // Assurez-vous que votre connexion à la base de données est configurée
            $db = config::getConnection();
            $query = $db->prepare("SELECT * FROM participation WHERE id = :id");
            $query->bindParam(':id', $id, PDO::PARAM_INT);
            $query->execute();
            $participant = $query->fetch(PDO::FETCH_ASSOC);
            return $participant;
        } catch (Exception $e) {
            error_log("Erreur lors de la récupération du participant : " . $e->getMessage());
            return false;
        }
    }

    // Save participation to the database (Insert)
    public function save(int $user_id, int $event_id, ?string $registration_date = null, string $status = 'pending'): bool
    {
        $db = config::getConnection();
        
        // Insert the participation into the database
        $query = "INSERT INTO participation (user_id, event_id, registration_date, status) VALUES (:user_id, :event_id, :registration_date, :status)";
        $stmt = $db->prepare($query);
        $stmt->bindValue(':user_id', $user_id);
        $stmt->bindValue(':event_id', $event_id);
        $stmt->bindValue(':registration_date', $registration_date ?: date('Y-m-d H:i:s'));
        $stmt->bindValue(':status', $status);
        
        return $stmt->execute();
    }

    // Retrieve a participation based on user_id and event_id
    public static function getByUserAndEvent(int $user_id, int $event_id): ?Participation
    {
        $db = config::getConnection();
        $query = "SELECT * FROM participation WHERE user_id = :user_id AND event_id = :event_id";
        $stmt = $db->prepare($query);
        $stmt->bindValue(':user_id', $user_id);
        $stmt->bindValue(':event_id', $event_id);
        $stmt->execute();

        $participation = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($participation) {
            return new Participation($participation['id'], $participation['user_id'], $participation['event_id'], $participation['registration_date'], $participation['status']);
        }
        return null;
    }

    // Cancel participation by changing the status to 'canceled'
    public static function cancel(int $id): bool
    {
        $db = config::getConnection();
        $query = "UPDATE participation SET status = 'canceled' WHERE id = :id";
        $stmt = $db->prepare($query);
        $stmt->bindValue(':id', $id);
        return $stmt->execute();
    }

    // Example method to handle a user registering for an event
    public function registerForEvent(int $user_id, int $event_id)
{
    // Check if the user has already participated
    $existingParticipation = self::getByUserAndEvent($user_id, $event_id);

    if ($existingParticipation) {
        echo "<script>alert('Vous ête déja inscrit !.');</script>";
    } else {
        // Fetch the event details to get max participants and current participants
        $db = config::getConnection();
        $query = "SELECT nombreParticipants FROM evenement WHERE id = :event_id";
        $stmt = $db->prepare($query);
        $stmt->bindValue(':event_id', $event_id);
        $stmt->execute();

        $event = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($event) {
            // Check if there are available spots for the event
            $availableSpots = $event['nombreParticipants'] ;

            if ($availableSpots > 0) {
                // Register the user for the event
                $this->save($user_id, $event_id);

                echo "<script>alert('Vous vous êtes inscrit avec succès à l\'événement.');</script>";
            } else {
                // No available spots left
                echo "<script>alert('Désolé, l\'evenement est complet.');</script>";
            }
        } else {
            echo "<script>alert('Event non trouvé.');</script>";
        }
    }
}



    //ADMIN

    // Get all pending participations
    public static function getPendingParticipations()
    {
        $db = config::getConnection();
        $query = "SELECT p.id, p.user_id, p.event_id, p.status, p.registration_date, e.titre AS event_title, u.email AS user_email
                  FROM participation p
                  JOIN evenement e ON p.event_id = e.id
                  JOIN user u ON p.user_id = u.id
                  WHERE p.status = 'pending'";

        $stmt = $db->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Accept a participation (change status to 'accepted')
public static function acceptParticipation(int $participation_id)
{
    $db = config::getConnection();

    // First, fetch the event_id from the participation table based on the participation ID
    $query = "SELECT event_id FROM participation WHERE id = :id";
    $stmt = $db->prepare($query);
    $stmt->bindValue(':id', $participation_id);
    $stmt->execute();

    $participation = $stmt->fetch(PDO::FETCH_ASSOC);

    // If participation doesn't exist, return false
    if (!$participation) {
        return false;
    }

    $event_id = $participation['event_id'];

    // Now, update the participation status to 'accepted'
    $updateParticipationQuery = "UPDATE participation SET status = 'confirmed' WHERE id = :id";
    $updateParticipationStmt = $db->prepare($updateParticipationQuery);
    $updateParticipationStmt->bindValue(':id', $participation_id);
    $updateParticipationStmt->execute();

    // Now, increment the number of participants in the event
    $updateEventQuery = "UPDATE evenement SET nombreParticipants = nombreParticipants - 1 WHERE id = :event_id";
    $updateEventStmt = $db->prepare($updateEventQuery);
    $updateEventStmt->bindValue(':event_id', $event_id);
    $updateEventStmt->execute();

    return true;
}


    // Decline a participation (delete from the table)
    public static function declineParticipation(int $participation_id)
    {
        $db = config::getConnection();
        $query = "DELETE FROM participation WHERE id = :id";
        $stmt = $db->prepare($query);
        $stmt->bindValue(':id', $participation_id);
        return $stmt->execute();
    }
}
?>
