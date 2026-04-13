<?php
$servername = "localhost";
$username = "root";
$password = ""; // vide par défaut sur XAMPP
$dbname = "hopital";
$port = 3307; // ⚠️ ajoute le port indiqué dans XAMPP

// Connexion serveur sans base
$conn = new mysqli($servername, $username, $password, null, $port);

// Vérification
if ($conn->connect_error) {
    die("Échec de la connexion : " . $conn->connect_error);
}

// Création de la base si absente puis sélection
if (!$conn->query("CREATE DATABASE IF NOT EXISTS `$dbname` CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci")) {
    die("Erreur création base : " . $conn->error);
}
if (!$conn->select_db($dbname)) {
    die("Erreur sélection base : " . $conn->error);
}
?>
