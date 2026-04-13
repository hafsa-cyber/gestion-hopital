<?php
include '../includes/config.php';

$id = $_GET['id'];

$sql = "DELETE FROM factures WHERE idfacture=$id";

if ($conn->query($sql) === TRUE) {
    header("Location: afficher_factures.php?msg=deleted");
} else {
    echo "Erreur : " . $conn->error;
}

$conn->close();
?>
