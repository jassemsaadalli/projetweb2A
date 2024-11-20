<?php

class Evenement
{
    private ?int $id = null;
    private ?string $titre = null;
    private ?string $date_debut = null;
    private ?string $date_fin = null;
    private ?int $nombreParticipants = null;
    private ?string $statut = null;

    public function __construct(?int $id = null, ?string $titre = null, ?string $date_debut = null, ?string $date_fin = null, ?string $statut = null, ?int $nombreParticipants = null)
    {
        $this->id = $id;
        $this->titre = $titre;
        $this->date_debut = $date_debut;
        $this->date_fin = $date_fin;
        $this->statut = $statut;
        $this->nombreParticipants = $nombreParticipants;
    }

    public function getId(): ?int { return $this->id; }
    public function getTitre(): ?string { return $this->titre; }
    public function getDate_debut(): ?string { return $this->date_debut; }
    public function getDate_fin(): ?string { return $this->date_fin; }
    public function getNbparticipants(): ?int { return $this->nombreParticipants; }
    public function getStatut(): ?string { return $this->statut; }

    public function setTitre(string $titre): void { $this->titre = $titre; }
    public function setDate_debut(string $date_debut): void { $this->date_debut = $date_debut; }
    public function setDate_fin(string $date_fin): void { $this->date_fin = $date_fin; }
    public function setNbParticipants(int $nombreParticipants): void { $this->nombreParticipants = $nombreParticipants; }
    public function setStatut(string $statut): void { $this->statut = $statut; }
}
?>
