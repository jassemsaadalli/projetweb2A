<?PHP
  include_once($_SERVER['DOCUMENT_ROOT'] . '/unityDonation/config.php');
  include_once($_SERVER['DOCUMENT_ROOT'] . '/unityDonation/Model/commande.php');

	class commandeC {
		
		/*function archivercommande($id){
			
			$sql="UPDATE commande SET etatC = '0' WHERE id= :id";
			$db = config::getConnexion();
			$req=$db->prepare($sql);
			$req->bindValue(':id',$id);
			try{
				$req->execute();
			}
			catch (Exception $e){
				die('Erreur: '.$e->getMessage());
			}
		}*/
		
		function ajoutercommande($commande){
            $sql="INSERT Into commande (idUtilisateur, montantTotale, dateCommande) 
            VALUES (:idUtilisateur, :montantTotale, :dateCommande)";
            $db = config::getConnexion();
            try{
            $query = $db->prepare($sql);
            
            $query->execute([
            'idUtilisateur' => $commande->getidUtilisateur(),
            'montantTotale' => $commande->getmontantTotale(),
            'dateCommande' => $commande->getdatecommande()
            ]);
            return $db->lastInsertId();
            }
            catch (PDOException $e){
            echo 'Erreur: '.$e->getMessage();
            }
            }
            
            function affichercommande(){
            
            $sql="SELECT * FROM commande ";
            $db = config::getConnexion();
            try{
            $liste = $db->query($sql);
            return $liste;
            }
            catch (PDOException $e){
            die('Erreur: '.$e->getMessage());
            }
            }
            function affichercommande1($idCommande){
                  try{
                        $db = config::getConnexion();
                        $query = $db->prepare('SELECT * FROM commande WHERE idCommande = :idCommande');
                        $query->execute(['idCommande' => $idCommande]);
                        $commande = $query->fetch(PDO::FETCH_ASSOC);
                            
                    return $commande;
                    }
                    catch (PDOException $e){
                    die('Erreur: '.$e->getMessage());
                    }
            }
            function supprimercommande($idCommande){
            $sql="DELETE FROM commande WHERE idCommande= :idCommande";
            $db = config::getConnexion();
            $req=$db->prepare($sql);
            $req->bindValue(':idCommande',$idCommande);
            try{
            $req->execute();
            }
            catch (PDOException $e){
            die('Erreur: '.$e->getMessage());
            }
            }
            
            function modifiercommande($commande, $idCommande) {
                  try {
                      $db = config::getConnexion();
                      $query = $db->prepare(
                          'UPDATE commande SET 
                          idUtilisateur = :idUtilisateur,
                          montantTotale = :montantTotale,
                          dateCommande = :dateCommande
                          WHERE idCommande = :idCommande'
                      );
              
                      $query->execute([
                          'idUtilisateur' => $commande->getidUtilisateur(),
                          'montantTotale' => $commande->getmontantTotale(),
                          'dateCommande' => $commande->getdatecommande(),
                          'idCommande' => $idCommande
                      ]);
              
                      echo $query->rowCount() . " records UPDATED successfully <br>";
                  } catch (PDOException $e) {
                      // Log or display the error message for debugging
                      echo "Error: " . $e->getMessage();
                      // You might also want to rethrow the exception or handle it further
                  }
              }

              
            
		/*function recuperercommande($id){
			$sql="SELECT * from commande where id=$id";
			$db = config::getConnexion();
			try{
				$query=$db->prepare($sql);
				$query->execute();

				$user=$query->fetch();
				return $user;
			}
			catch (Exception $e){
				die('Erreur: '.$e->getMessage());
			}
		}*/

		/*function recuperercommande1($id){
			$sql="SELECT * from commande where id=$id";
			$db = config::getConnexion();
			try{
				$query=$db->prepare($sql);
				$query->execute();
				
				$user = $query->fetch(PDO::FETCH_OBJ);
				return $user;
			}
			catch (Exception $e){
				die('Erreur: '.$e->getMessage());
			}
		}*/
		
	}

?>