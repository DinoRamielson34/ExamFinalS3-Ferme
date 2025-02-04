<?php

namespace app\models;

use Flight;
use PDO; // Assurez-vous que PDO est accessible

class LogModel
{
    protected $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getUserByEmail($email)
    {
        // Exécuter la requête directement (pas sécurisé)
        $query = "SELECT * FROM elevage_Users WHERE email = '$email'";
        $result = $this->db->query($query);

        // Vérifiez si la requête a réussi
        if ($result === false) {
            error_log("Query failed: " . $this->db->error); // Journaliser l'erreur de requête
            return false;
        }

        // Récupérer le résultat
        $user = $result->fetch(PDO::FETCH_ASSOC); // Retourner l'utilisateur sous forme de tableau associatif

        // Vérifier si un utilisateur a été trouvé
        if ($user) {
            return $user;
        }

        error_log("No user found with email: " . $email); // Journaliser si aucun utilisateur n'est trouvé
        return false; // Aucun utilisateur trouvé
    }
    // Inscription d'un nouvel utilisateur
    public function registerUser($name, $email, $password, $phone, $isAdmin)
    {
        $role = $isAdmin ? 'admin' : 'client'; // Déterminer le rôle

        $stmt = $this->db->prepare("INSERT INTO elevage_Users (name, email, password, phone, role) VALUES (:name, :email, :password, :phone, :role)");

        // Exécuter la requête avec un tableau associatif
        $result = $stmt->execute([
            ':name' => $name,
            ':email' => $email,
            ':password' => $password,
            ':phone' => $phone,
            ':role' => $role
        ]);

        // Gérer les erreurs
        if (!$result) {
            var_dump($stmt->errorInfo());
            return false;
        }

        return true;
    }
}