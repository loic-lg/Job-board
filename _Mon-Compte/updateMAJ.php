<?php
session_start();
include_once('../__db/connexionDB.php');

// Activer les erreurs PDO
$BD->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    echo "Vous devez être connecté.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    
    // Récupérer les données du formulaire
    $email = $_POST['email'];
    $password = $_POST['password'];

    $updates = [];
    $params = [];

    // Vérifier si l'utilisateur est dans 'people' ou 'companies'
    if ($user_id < 100001) {
        // table people
        $username = $_POST['username'];
        $lastname = $_POST['lastname'];

        $updates[] = "username = ?";
        $params[] = $username;

        $updates[] = "lastname = ?";
        $params[] = $lastname;

        $updates[] = "email = ?";
        $params[] = $email;

        // Maj du mot de passe
        if (!empty($password)) {
            $updates[] = "mdp = ?";
            $params[] = $password;  
        }

        // Requête SQL pour 'people'
        $sql = "UPDATE people SET " . implode(", ", $updates) . " WHERE id = ?";

    } else {
        // table companies
        $name = $_POST['name'];
        $address = $_POST['address'];

        $updates[] = "name = ?";
        $params[] = $name;

        $updates[] = "address = ?";
        $params[] = $address;

        $updates[] = "email = ?";
        $params[] = $email;

        
        if (!empty($password)) {
            $updates[] = "password = ?";
            $params[] = $password;  
        }

        $sql = "UPDATE companies SET " . implode(", ", $updates) . " WHERE id = ?";
    }

    // Ajout id user 
    $params[] = $user_id;

    try {
        $stmt = $BD->prepare($sql);
        if ($stmt->execute($params)) {
            echo "Mise à jour réussie !";
        } else {
            echo "Erreur lors de la mise à jour.";
        }
    } catch (PDOException $e) {
        echo "Erreur SQL : " . $e->getMessage();
    }

} else {
    echo "Quelque chose n'a pas fonctionné.";
}
