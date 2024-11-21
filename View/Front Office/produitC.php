<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/projet_wb/config.php');

class ProduitC
{
    private $conn; // Add this property to store the database connection
    private ?string $idCategorie = null;
    // Constructor to initialize the database connection
    public function __construct() {
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "produit";

    }

     public function listProduit()
    {
        $sql="SELECT * FROM produit";
        $db = config::getConnexion();
        try{
        $liste = $db->query($sql);
        return $liste;
        }
        catch (PDOException $e){
        die('Erreur: '.$e->getMessage());
        }
    }
   public function listProduitWithCategories() {
    // Modify your SQL query to join the produit and categories tables
    $query = "SELECT produit.*, categorie.nomc as categorie_nom FROM produit
              LEFT JOIN categorie ON produit.idCategorie = categorie.idCategorie";
    $result = $this->conn->query($query);

    // Fetch the results into an array
    $produit = [];
    while ($row = $result->fetch_assoc()) {
        $produit[] = $row;
    }

    return $produit;
}


    function deleteProduit($ide)
    {
        $sql = "DELETE FROM produit WHERE idProduit = :id";
        $db = config::getConnexion();
        $req = $db->prepare($sql);
        $req->bindValue(':id', $ide);

        try {
            $req->execute();
        } catch (Exception $e) {
            die('Error:' . $e->getMessage());
        }
    }


  //  function addProduit($produit)
   //// {
       /// $sql = "INSERT INTO produit  VALUES ( NULL,:nom,:prix, :description,:inventaire,:image,:idCategorie)";
       // $db = config::getConnexion();
       // try {
            //$query = $db->prepare($sql);
           // $query->execute([
                ////'nom' => $produit->getNom(),
                //'prix' => $produit->getPrix(),
                //'description' => $produit->getDescription(),
                //'inventaire' => $produit->getInventaire(),
                //'image' => $produit->getImage(),
                //'idCategorie' => $produit->getIdCategorie(),
          //  ]);
      //  } catch (Exception $e) {
            //////echo 'Error: ' . $e->getMessage();
      //  }
   // }
   public function ajouterProduit($produit) {
    $sql = "INSERT INTO Produit (nom, prix, description, inventaire, image, idCategorie) 
            VALUES (:nom, :prix, :description, :inventaire, :image, :idCategorie)";
    $db = config::getConnexion();
    $stmt = $db->prepare($sql);

    try {
        $stmt->execute([
            'nom' => $produit->getNom(),
            'prix' => $produit->getPrix(),
            'description' => $produit->getDescription(),
            'inventaire' => $produit->getInventaire(),
            'image' => $produit->getImage(),
            'idCategorie' => $produit->getIdCategorie()
        ]);

        if ($stmt->rowCount() > 0) {
            // The insertion was successful
            return true;
        } else {
            // There was an error
            echo "No rows affected. Check the data you are trying to insert.";
            return false;
        }
    } catch (PDOException $e) {
        // Log or echo the error message for debugging
        echo 'Error: ' . $e->getMessage();
        return false;
    }
}


    function detailsProduit($id)
    {
        $sql = "SELECT * from produit where idProduit = $id";
        $db = config::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->execute();
            $produit = $query->fetch();
            return $produit;
        } catch (Exception $e) {
            die('Error: ' . $e->getMessage());
        }
    }

    function updateProduit($produit, $id)
    {   
        try {
            $db = config::getConnexion();
            $query = $db->prepare(
                'UPDATE produit SET 
                    nom = :nom, 
                    prix = :prix, 
                    description = :description, 
                    inventaire = :inventaire,
                    image = :image,
                    idCategorie = :idCategorie
                WHERE idProduit= :id'
            );
            
            $query->execute([
                'id' => $id,
                'nom' => $produit->getNom(),
                'prix' => $produit->getPrix(),
                'description' => $produit->getDescription(),
                'inventaire' => $produit->getInventaire(),
                'image' => $produit->getImage(),
                'idCategorie' => $produit->getIdCategorie()
            ]);
            
            echo $query->rowCount() . " records UPDATED successfully <br>";
        } catch (PDOException $e) {
            $e->getMessage();
        }
    }
    public function triProduit() {
        $sql = "SELECT * FROM produit order by nom";
        $db = config::getConnexion();
        try {
            $list = $db->query($sql);
            return $list;
        } catch (Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }
    public function rechercheProduit($rech)
    {
        $sql = "SELECT * FROM produit where produit.nom like '%$rech%' or produit.description like '%$rech%'";
        $db = config::getConnexion();
        try {
            $list = $db->query($sql);
            return $list;
        } catch (Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }
    // Destructor to close the database connection when the object is destroyed
    public function __destruct() {
        if ($this->conn) {
            $this->conn->close();
        }
    }
    public function afficherproduitUtilisateur($id_user)
    {
        $sql = "SELECT * FROM produit WHERE id_user = :id_user ";
        $db = config::getConnexion();
        
        try {
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':id_user', $id_user, PDO::PARAM_INT);
            $stmt->execute();
            $liste = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $liste;
        } catch (Exception $e) {
            die('Error:' . $e->getMessage());
        }
    }
    public function showProduit($id)
{
    $sql = "SELECT * FROM produit WHERE idProduit = :id";
    $db = config::getConnexion();
    try {
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $produit = $stmt->fetch(PDO::FETCH_ASSOC);
        return $produit;
    } catch (PDOException $e) {
        echo 'Erreur: ' . $e->getMessage();
    }
}

}
?>