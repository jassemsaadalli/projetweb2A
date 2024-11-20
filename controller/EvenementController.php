<?php
include(__DIR__ . '/../config.php');
include(__DIR__ . '/../model/evennement.php');

class EvenementController
{
    public function getEventById($id)
    {
        $db = config::getConnection();

        $sql = "SELECT * FROM evenements WHERE id = :id";

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
        $sql = "SELECT * FROM evenements";
        $db = config::getConnection();

        try {
            return $db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Error: " . $e->getMessage());
        }
    }

    public function deleteevenement($id)
    {
        $sql = "DELETE FROM evenements WHERE id = :id";
        $db = config::getConnection();

        try {
            $req = $db->prepare($sql);
            $req->bindValue(':id', $id, PDO::PARAM_INT);
            $req->execute();
        } catch (Exception $e) {
            die("Error: " . $e->getMessage());
        }
    }

    public function addevenement($evenement)
    {
        $db = config::getConnection();

        $sql = "INSERT INTO evenements (titre, date_debut, date_fin, nombre_participants, statut) 
                VALUES (:titre, :date_debut, :date_fin, :nombre_participants, :statut)";

        try {
            $query = $db->prepare($sql);
            $query->execute([
                ':titre' => $evenement->getTitre(),
                ':date_debut' => $evenement->getDate_debut(),
                ':date_fin' => $evenement->getDate_fin(),
                ':nombre_participants' => $evenement->getNbparticipants(),
                ':statut' => $evenement->getStatut(),
            ]);
        } catch (PDOException $e) {
            die("Error while adding event: " . $e->getMessage());
        }
    }

    public function updateevenement($evenement)
    {
        $db = config::getConnection();
        $sql = "UPDATE evenements 
                SET titre = :titre, date_debut = :date_debut, date_fin = :date_fin, statut = :statut, nombre_participants = :nombre_participants 
                WHERE id = :id";

        try {
            $query = $db->prepare($sql);
            $query->execute([
                ':id' => $evenement->getId(),
                ':titre' => $evenement->getTitre(),
                ':date_debut' => $evenement->getDate_debut(),
                ':date_fin' => $evenement->getDate_fin(),
                ':nombre_participants' => $evenement->getNbparticipants(),
                ':statut' => $evenement->getStatut(),
            ]);
        } catch (PDOException $e) {
            die("Error: " . $e->getMessage());
        }
    }
}
?>
