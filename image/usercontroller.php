<?php
include_once 'C:\xampp\htdocs\front\model\user.php';

class UserController {
    
    private $userModel;

    // Constructor qui passe la connexion à la base de données à la classe User
    public function __construct() {
        // Initialiser la connexion à la base de données
        $database = new Database();
        $connection = $database->getConnection();

        // Passer la connexion à la classe User
        $this->userModel = new User($connection);
    }

    // Lister tous les utilisateurs
    public function listUsers() {
        return $this->userModel->getAll();
    }

    // Créer un nouvel utilisateur avec le mot de passe
    public function createUser($firstname, $lastname, $email, $role, $password) {
        return $this->userModel->create($firstname, $lastname, $email, $role, $password);
    }

    // Obtenir un utilisateur par ID
    public function GET($id) {
        return $this->userModel->getById($id);
    }

    // Mettre à jour les détails de l'utilisateur, y compris le mot de passe si fourni
    public function updateUser($id, $firstname, $lastname, $email, $role, $password) {
        return $this->userModel->update($id, $firstname, $lastname, $email, $role, $password);
    }

    public function getUserByEmail($email) {
        return $this->userModel->getByEmail($email);
    }

    // Supprimer un utilisateur par email
    public function deleteUser($email) {
        return $this->userModel->deleteByEmail($email);
    }
}
