<?php

class Evenement
{
    private ?int $id = null;
    private ?string $titre = null;
    private ?string $date_debut = null;
    private ?string $date_fin = null;
    private ?int $nombreParticipants = null;
    private ?string $description = null;
    private ?string $statut = null;
    private ?string $image;

    public function __construct(?int $id = null, ?string $titre = null, ?string $description = null, ?string $date_debut = null, ?string $date_fin = null, ?string $statut = null, ?int $nombreParticipants = null, ?string $image = null)
    {
        $this->id = $id;
        $this->titre = $titre;
        $this->description = $description;
        $this->date_debut = $date_debut;
        $this->date_fin = $date_fin;
        $this->statut = $statut;
        $this->nombreParticipants = $nombreParticipants;
        $this->image = $image;
    }

    public function getId(): ?int { return $this->id; }
    public function getTitre(): ?string { return $this->titre; }
    public function getDescription(): ?string { return $this->description;}
    public function getDate_debut(): ?string { return $this->date_debut; }
    public function getDate_fin(): ?string { return $this->date_fin; }
    public function getNbparticipants(): ?int { return $this->nombreParticipants; }
    public function getStatut(): ?string { return $this->statut; }
    public function getImage(): ?string { return $this->image; }


    public function setTitre(string $titre): void { $this->titre = $titre; }
    public function setDescription(string $description): void { $this->description = $description;}
    public function setDate_debut(string $date_debut): void { $this->date_debut = $date_debut; }
    public function setDate_fin(string $date_fin): void { $this->date_fin = $date_fin; }
    public function setNbParticipants(int $nombreParticipants): void { $this->nombreParticipants = $nombreParticipants; }
    public function setStatut(string $statut): void { $this->statut = $statut; }
    public function setImage(string $image): void { $this->image = $image; }

}
?>
