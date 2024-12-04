<?php
include(__DIR__ . '/../model/evennement.php');

class EvenementController
{
    public static function getEventById($id)
    {
        $db = config::getConnection();

        $sql = "SELECT * FROM evenement WHERE id = :id";

        try {
            $query = $db->prepare($sql);
            $query->bindParam(':id', $id, PDO::PARAM_INT);
            $query->execute();

            return $query->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Error: " . $e->getMessage());
        }
    }

    public function listevenement()
    {
        $sql = "SELECT * FROM evenement where statut ='actif' AND nombreParticipants > 0";
        $db = config::getConnection();

        try {
            return $db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Error: " . $e->getMessage());
        }
    }

    public function deleteevenement($id)
    {
        $sql = "DELETE FROM evenement WHERE id = :id";
        $db = config::getConnection();

        try {
            $req = $db->prepare($sql);
            $req->bindValue(':id', $id, PDO::PARAM_INT);
            $req->execute();
        } catch (Exception $e) {
            die("Error: " . $e->getMessage());
        }
    }

    public function addevenement(Evenement $evenement) {
        $query = "INSERT INTO Evenement (titre, description, date_debut, date_fin, nombreParticipants, statut, image)
                  VALUES (:titre, :description, :date_debut, :date_fin, :nombreParticipants, :statut, :image)";
        $db = config::getConnection();

        $stmt = $db->prepare($query);
    
        $stmt->bindValue(':titre', $evenement->getTitre());
        $stmt->bindValue(':description', $evenement->getDescription());
        $stmt->bindValue(':date_debut', $evenement->getDate_debut());
        $stmt->bindValue(':date_fin', $evenement->getDate_fin());
        $stmt->bindValue(':nombreParticipants', $evenement->getNbparticipants());
        $stmt->bindValue(':statut', $evenement->getStatut());
        $stmt->bindValue(':image', $evenement->getImage());
    
        $stmt->execute();
    }
    

    public function updateEvenement($evenement) {
        $query = "UPDATE Evenement 
                  SET titre = :titre, description = :description, date_debut = :date_debut, date_fin = :date_fin, 
                      statut = :statut, nombreParticipants = :nombreParticipants, image = :image 
                  WHERE id = :id";
        $db = config::getConnection();

        $stmt = $db->prepare($query);
        $stmt->execute([
            ':titre' => $evenement->getTitre(),
            ':description' => $evenement->getDescription(),
            ':date_debut' => $evenement->getDate_debut(),
            ':date_fin' => $evenement->getDate_fin(),
            ':statut' => $evenement->getStatut(),
            ':nombreParticipants' => $evenement->getNbparticipants(),
            ':image' => $evenement->getImage(),
            ':id' => $evenement->getId(),
        ]);
    }
    
}
?>
