<?PHP
class commande {
    private ?int $idCommande = null;
    private ?int $idUtilisateur = null;
    private ?string $montant = null;
    private ?string $datecommande = null;

    function __construct(int $idUtilisateur, string $montant, string $datecommande) {
        $this->idUtilisateur = $idUtilisateur;
        $this->montant = $montant;
        $this->datecommande = $datecommande;
    }

    function getIdCommande(): ?int {
        return $this->idCommande;
    }

    function getidUtilisateur(): ?int {
        return $this->idUtilisateur;
    }

    function getmontantTotale(): ?string {
        return $this->montant;
    }

    function getdatecommande(): ?string {
        return $this->datecommande;
    }

    function setIdCommande(int $idCommande): void {
        $this->idCommande = $idCommande;
    }

    function setidUtilisateur(int $idUtilisateur): void {
        $this->idUtilisateur = $idUtilisateur;
    }

    function setmontantTotale(string $montant): void {
        $this->montant = $montant;
    }

    function setdatecommande(string $datecommande): void {
        $this->datecommande = $datecommande;
    }
}

?>