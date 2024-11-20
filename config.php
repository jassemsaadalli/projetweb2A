<?php

class Config {
    private static $dbHost = 'localhost';
    private static $dbName = 'biovert';
    private static $dbUser = 'root'; // Remplacez par votre nom d'utilisateur
    private static $dbPass = ''; // Remplacez par votre mot de passe

    public static function getConnection() {
        try {
            $pdo = new PDO(
                "mysql:host=" . self::$dbHost . ";dbname=" . self::$dbName,
                self::$dbUser,
                self::$dbPass
            );
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;
        } catch (PDOException $e) {
            die("Erreur de connexion : " . $e->getMessage());
        }
    }
}
?>
