<?php include '../includes/header.php'; ?>
<?php include '../includes/config.php'; ?>

<h2>Liste des Rendez-vous</h2>

<a href="ajouter_rendez_vous.php" style="display:inline-block; margin-bottom:20px; padding:10px 20px; background:#28a745; color:white; text-decoration:none; border-radius:5px; font-weight:bold;">Nouveau rendez-vous</a>

<?php
// Récupérer tous les rendez-vous avec les infos patients et médecins
$sql = "SELECT r.*, 
        CONCAT(p.nom, ' ', p.prenom) AS patient_nom,
        CONCAT(m.nom, ' ', m.prenom) AS medecin_nom,
        m.specialite
        FROM rendez_vous r
        JOIN patients p ON r.idpatient = p.idpatient
        JOIN medecins m ON r.idmedecin = m.idmedecin
        ORDER BY r.date_rdv DESC, r.heure_rdv DESC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table>";
    echo "<tr>
            <th>ID</th>
            <th>Patient</th>
            <th>Médecin</th>
            <th>Spécialité</th>
            <th>Date</th>
            <th>Heure</th>
            <th>Motif</th>
            <th>Statut</th>
            <th>Actions</th>
          </tr>";

    while ($row = $result->fetch_assoc()) {
        // Couleur selon le statut
        $statut_colors = [
            'Programmé' => '#fbbf24',
            'Confirmé' => '#60a5fa',
            'Terminé' => '#34d399',
            'Annulé' => '#f87171'
        ];
        $color = $statut_colors[$row['statut']] ?? '#6c757d';
        
        echo "<tr>
                <td>{$row['idrendezvous']}</td>
                <td>{$row['patient_nom']}</td>
                <td>{$row['medecin_nom']}</td>
                <td>{$row['specialite']}</td>
                <td>{$row['date_rdv']}</td>
                <td>{$row['heure_rdv']}</td>
                <td>{$row['motif']}</td>
                <td><span class='badge' style='background:{$color}'>{$row['statut']}</span></td>
                <td>
                    <a class='btn edit' href='modifier_rendez_vous.php?id={$row['idrendezvous']}'>Modifier</a>
                    <a class='btn delete' href='supprimer_rendez_vous.php?id={$row['idrendezvous']}' 
                       onclick='return confirm(\"Voulez-vous vraiment supprimer ce rendez-vous ?\")'>Supprimer</a>
                </td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "<p>Aucun rendez-vous trouvé.</p>";
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
.badge {
    padding: 5px 10px;
    border-radius: 5px;
    color: white;
    font-weight: bold;
}
</style>

<?php include '../includes/footer.php'; ?>
