<?PHP
	class panier{
		private ?int $idPanier = null;
		private ?int $idUtilisateur = null;
		private ?int $idCommande = null;
		private ?int $idProduit = null;
		private ?int $quantite = null;


		function __construct(int $idUtilisateur, int $idCommande,int $idProduit, int $quantite){
			
			$this->idUtilisateur=$idUtilisateur;
            $this->idCommande=$idCommande;
			$this->idProduit=$idProduit;
			$this->quantite=$quantite;

		}
		
		function getIdPanier(): int{
			return $this->idPanier;
		}
		function getIdUtilisateur(): int{
			return $this->idUtilisateur;
		}
		function getIdCommande(): int{
			return $this->idCommande;
		}
		function getIdProduit(): int{
			return $this->idProduit;
		}

        function getQuantite(): int{
			return $this->quantite;
		}


		

        function setIdUtilisateur(int $idUtilisateur): void{
			$this->idUtilisateur=$idUtilisateur;
		}
		function setIdCommande(int $idCommande): void{
			$this->idCommande=$idCommande;
		}	
		function setIdProduit(int $idProduit): void{
			$this->idProduit=$idProduit;
		}	
        function setQuantite(int $quantite): void{
			$this->quantite=$quantite;
		}
		
	}
?>