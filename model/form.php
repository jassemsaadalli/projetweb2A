<?php
    class form
    {
        private ?int $id;
        private ?string $nom;
        private ?string $prenom;
        private ?int $age;
        private ?int $num;
        public function __construct(?int $id = null, ?string $nom = null, ?string $prenom = null, ?int $age = null, ?int $num = null)
{
    $this->id = $id;
    $this->nom = $nom;
    $this->prenom = $prenom;
    $this->age = $age;
    $this->num = $num;
}

        public function getId()
        {
            return $this->id;
        }
        public function getNom()
        {
            return $this->nom;
        }
        public function getPrenom()
        {
            return $this->prenom;
        }
        public function getAge()
        {
            return $this->age;
        }
        public function getNum()
        {
            return $this->num;
        }


        public function setNom($nom)
        {
            $this->nom = $nom;
        }
        public function setPrenom($prenom)
        {
            $this->prenom = $prenom;
        }
        public function setAge($age)
        {
            $this->num = $age;
        }
        public function setNum($num)
        {
            $this->num = $num;
        }
    }
?>