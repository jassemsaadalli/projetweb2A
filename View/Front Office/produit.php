<?php
class Produit
{
    private ?int $idProduit = null;
    private string $nom ;
    private string $prix ;
    private string $description;
    private string $inventaire ;
    private string $image ;
   private string $idCategorie;
   private int $id_user;

   
    public function __construct($id = null, $n, $p, $a, $d, $m,$c,$u)
    {
        $this->idProduit = $id;
        $this->nom = $n;
        $this->prix= $p;
        $this->description = $a;
        $this->inventaire= $d;
        $this->image= $m;
        $this->idCategorie = $c;
        $this->id_user = $u;


     
    }


    public function getIdProduit()   // get taccedi lel les attributs eli hachtek bihom  
    {
        return $this->idProduit;
    }
    public function setIdProduit($idProduit)
    {
        $this->idProduit= $idProduit;

        return $this;
    }

    public function getNom()
    {
        return $this->nom;
    }
    public function setNom($nom)                // trodha tnjm tmodifi lattribut 
    {
        $this->nom = $nom;

        return $this;
    }


    public function getPrix()
    {
        return $this->prix;
    }


    public function setPrix($prix)
    {
        $this->prix= $prix;

        return $this;
    }


    public function getDescription()
    {
        return $this->description;
    }


    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }


    public function getInventaire()
    {
        return $this->inventaire;
    }


    public function setInventaire($inventaire)
    {
        $this->inventaire= $inventaire;
        return $this;
    }
    public function getImage()
    {
        return $this->image;
    }


    public function setImage($image)
    {
        $this->image= $image;
        return $this;
    }
   
    public function getIdCategorie()   // get taccedi lel les attributs eli hachtek bihom  
    {
        return $this->idCategorie;
    }
    public function setIdCategorie($idCategorie)
    {
        $this->idCategorie= $idCategorie;

        return $this;
    }
       
    public function getIduser()   // get taccedi lel les attributs eli hachtek bihom  
    {
        return $this->id_user;
    }
    public function setIduser($idCategorie)
    {
        $this->id_user= $id_user;

        return $this;
    }
}
?>


