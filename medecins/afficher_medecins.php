<?php include '../includes/header.php'; ?>
<?php include '../includes/config.php'; ?>

<h2>Liste des Médecins</h2>

<a href="ajouter_medecin.php" style="display:inline-block; margin-bottom:20px; padding:10px 20px; background:#28a745; color:white; text-decoration:none; border-radius:5px; font-weight:bold;">Ajouter un médecin</a>

<?php
// Récupérer tous les médecins
$sql = "SELECT * FROM medecins ORDER BY idmedecin DESC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table>";
    echo "<tr>
            <th>ID</th>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Spécialité</th>
            <th>Téléphone</th>
            <th>Email</th>
            <th>N° Licence</th>
            <th>Tarif Consultation</th>
            <th>Statut</th>
            <th>Actions</th>
          </tr>";

    while ($row = $result->fetch_assoc()) {
        $statut_color = $row['statut'] == 'Actif' ? 'green' : 'red';
        echo "<tr>
                <td>{$row['idmedecin']}</td>
                <td>{$row['nom']}</td>
                <td>{$row['prenom']}</td>
                <td>{$row['specialite']}</td>
                <td>{$row['telephone']}</td>
                <td>{$row['email']}</td>
                <td>{$row['numero_licence']}</td>
                <td>{$row['tarif_consultation']} DH</td>
                <td style='color:{$statut_color}; font-weight:bold;'>{$row['statut']}</td>
                <td>
                    <a class='btn edit' href='modifier_medecin.php?id={$row['idmedecin']}'>Modifier</a>
                    <a class='btn delete' href='supprimer_medecin.php?id={$row['idmedecin']}' 
                       onclick='return confirm(\"Voulez-vous vraiment supprimer ce médecin ?\")'>Supprimer</a>
                </td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "<p>Aucun médecin trouvé.</p>";
}
$conn->close();
?>

<style>
table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
    background: white;
    box-shadow: 0 0 8px rgba(0,0,0,0.1);
}
th, td {
    border: 1px solid #ccc;
    padding: 10px;
    text-align: center;
}
th {
    background: #60a5fa;
    color: white;
}
tr:nth-child(even) { background-color: #f2f2f2; }
.btn {
    text-decoration: none;
    padding: 6px 12px;
    border-radius: 5px;
    font-weight: bold;
    display: inline-block;
    margin: 2px;
}
.edit { background: #ffc107; color: black; }
.delete { background: #dc3545; color: white; }
.edit:hover { background: #e0a800; }
.delete:hover { background: #c82333; }
</style>

<?php include '../includes/footer.php'; ?>
