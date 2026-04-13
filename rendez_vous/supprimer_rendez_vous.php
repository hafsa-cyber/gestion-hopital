<?php
include '../includes/config.php';

$id = $_GET['id'];

$sql = "DELETE FROM rendez_vous WHERE idrendezvous=$id";

if ($conn->query($sql) === TRUE) {
    header("Location: afficher_rendez_vous.php?msg=deleted");
} else {
    echo "Erreur : " . $conn->error;
}

$conn->close();
?>
