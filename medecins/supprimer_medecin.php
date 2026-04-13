<?php
include '../includes/config.php';

$id = $_GET['id'];

$sql = "DELETE FROM medecins WHERE idmedecin=$id";

if ($conn->query($sql) === TRUE) {
    header("Location: afficher_medecins.php?msg=deleted");
} else {
    echo "Erreur : " . $conn->error;
}

$conn->close();
?>
