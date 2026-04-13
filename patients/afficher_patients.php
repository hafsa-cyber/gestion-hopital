<?php include '../includes/header.php'; ?>
<?php include '../includes/config.php'; ?>

<div class="page-header">
    <h2 class="page-title">
        Liste des Patients
    </h2>
    <a href="ajouter_patient.php" class="btn btn-success">
        Ajouter un patient
    </a>
</div>

<div class="table-container">
<?php
// Récupérer tous les patients de la base
$sql = "SELECT * FROM patients ORDER BY idpatient DESC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table>";
    echo "<tr>
            <th>ID</th>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Âge</th>
            <th>Date de naissance</th>
            <th>Adresse</th>
            <th>Téléphone</th>
            <th>Actions</th>
          </tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['idpatient']}</td>
                <td>{$row['nom']}</td>
                <td>{$row['prenom']}</td>
                <td>{$row['age']}</td>
                <td>{$row['date_naissance']}</td>
                <td>{$row['adress']}</td>
                <td>{$row['telephone']}</td>
                <td>
                    <a class='btn edit' href='modifier_patient.php?id={$row['idpatient']}'>Modifier</a>
                    <a class='btn delete' href='supprimer_patient.php?id={$row['idpatient']}' 
                       onclick='return confirm(\"Voulez-vous vraiment supprimer ce patient ?\")'>Supprimer</a>
                </td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "<p>Aucun patient trouvé.</p>";
}
$conn->close();
?>
</div>

<?php include '../includes/footer.php'; ?>
