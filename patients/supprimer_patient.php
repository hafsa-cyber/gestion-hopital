<?php
include '../includes/config.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0; // Récupère l’ID du patient depuis le lien

if ($id > 0) {
    $stmt = $conn->prepare("DELETE FROM patients WHERE idpatient = ?");
    $stmt->bind_param('i', $id);
    if ($stmt->execute()) {
        echo "<script>alert('Patient supprimé avec succès !'); window.location.href='afficher_patients.php';</script>";
    } else {
        echo "Erreur lors de la suppression : " . $conn->error;
    }
    $stmt->close();
} else {
    echo "<script>alert('Identifiant invalide.'); window.location.href='afficher_patients.php';</script>";
}

$conn->close();
?>
