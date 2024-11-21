<?PHP
  include_once($_SERVER['DOCUMENT_ROOT'] . '/unityDonation/config.php');
  include_once($_SERVER['DOCUMENT_ROOT'] . '/unityDonation/Model/panier.php');


	class panierC {
		

		function ajouterAuPanier($panier) {
            $sql = "INSERT INTO panier (idUtilisateur, idProduit, quantite) 
                    VALUES (:idUtilisateur, :idProduit, :quantite)";
            $db = config::getConnexion();
            try {
                $query = $db->prepare($sql);
                $query->execute([
                    'idUtilisateur' => $panier->getIdUtilisateur(),
                    'idProduit' => $panier->getIdProduit(),
                    'quantite' => $panier->getQuantite(),
                ]);
            } catch (PDOException $e) {
                echo 'Erreur: ' . $e->getMessage();
            }
        }
            

            function afficherPanier(){
            
            $sql="SELECT * FROM panier";
            $db = config::getConnexion();
            try{
            $liste = $db->query($sql);
            return $liste;
            }
            catch (PDOException $e){
            die('Erreur: '.$e->getMessage());
            }
            }
            
            function afficherPanier1($idPanier){

                try{
                    $db = config::getConnexion();
                    $query = $db->prepare('SELECT * FROM panier WHERE idPanier = :idPanier');
                    $query->execute(['idPanier' => $idPanier]);
                    $panier = $query->fetch(PDO::FETCH_ASSOC);
				
                return $panier;
                }
                catch (PDOException $e){
                die('Erreur: '.$e->getMessage());
                }
                }
                function afficherPanierC($idCommande) {
                    try {
                        $db = config::getConnexion();
                        $query = $db->prepare('SELECT * FROM panier WHERE idCommande = :idCommande');
                        $query->execute(['idCommande' => $idCommande]);
                        $paniers = $query->fetchAll(PDO::FETCH_ASSOC);
                
                        return $paniers;
                    } catch (PDOException $e) {
                        die('Erreur: '.$e->getMessage());
                    }
                }
                

            function supprimerDuPanier($idPanier){
            $sql="DELETE FROM panier WHERE idPanier= :idPanier";
            $db = config::getConnexion();
            $req=$db->prepare($sql);
            $req->bindValue(':idPanier',$idPanier);
            try{
            $req->execute();
            }
            catch (PDOException $e){
            die('Erreur: '.$e->getMessage());
            }
            }
            
            function modifierPanier($panier, $idPanier){
                try {
                $db = config::getConnexion();
                $query = $db->prepare(
                'UPDATE panier SET 
                idUtilisateur = :idUtilisateur,
                idProduit = :idProduit,
                quantite = :quantite
                WHERE idPanier = :idPanier'
                );
                
                $query->execute([

                'idUtilisateur' => $panier->getIdUtilisateur(),
                'idProduit' => $panier->getIdProduit(),
                'quantite' => $panier->getQuantite(),
                'idPanier' => $idPanier
                ]);
                //echo $query->rowCount() . " records UPDATED successfully <br>";
                } catch (PDOException $e) {
                $e->getMessage();
                }
                }

            function modifierPanier1($panier, $idProduit){
                try {
                $db = config::getConnexion();
                $query = $db->prepare(
                'UPDATE panier SET 
                idUtilisateur = :idUtilisateur,
                idProduit = :idProduit,
                quantite = :quantite
                WHERE idProduit = :idProduit'
                );
                
                $query->execute([
                'idUtilisateur' => $panier->getIdUtilisateur(),
                'idProduit' => $panier->getIdProduit(),
                'quantite' => $panier->getQuantite()
                ]);
                //echo $query->rowCount() . " records UPDATED successfully <br>";
                } catch (PDOException $e) {
                $e->getMessage();
                }
                }
                function modifierPaniernull($panier,$idCommande){
                    try {
                        $db = config::getConnexion();
                        $query = $db->prepare(
                        'UPDATE panier SET 
                        idCommande = :idCommande
                        WHERE idCommande IS NULL'
                        );
                        
                        $query->execute([
                        'idCommande' => $idCommande
                        ]);
                        //echo $query->rowCount() . " records UPDATED successfully <br>";
                        } catch (PDOException $e) {
                        $e->getMessage();
                        }
                }
            

		
	}

?>