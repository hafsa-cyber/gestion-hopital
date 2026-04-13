<?php include '../includes/header.php'; ?>
<?php include '../includes/config.php'; ?>

<h2>Liste des Factures</h2>

<a href="ajouter_facture.php" style="display:inline-block; margin-bottom:20px; padding:10px 20px; background:#28a745; color:white; text-decoration:none; border-radius:5px; font-weight:bold;">Nouvelle facture</a>

<?php
// Récupérer toutes les factures
$sql = "SELECT f.*, 
        CONCAT(p.nom, ' ', p.prenom) AS patient_nom,
        CONCAT(m.nom, ' ', m.prenom) AS medecin_nom
        FROM factures f
        JOIN patients p ON f.idpatient = p.idpatient
        LEFT JOIN medecins m ON f.idmedecin = m.idmedecin
        ORDER BY f.date_facture DESC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table>";
    echo "<tr>
            <th>N° Facture</th>
            <th>Date</th>
            <th>Patient</th>
            <th>Médecin</th>
            <th>Montant Total</th>
            <th>Montant Payé</th>
            <th>Reste à Payer</th>
            <th>Statut</th>
            <th>Actions</th>
          </tr>";

    while ($row = $result->fetch_assoc()) {
        $total = isset($row['montant_total']) ? (float)$row['montant_total'] : 0.0;
        $paye  = isset($row['montant_paye']) ? (float)$row['montant_paye'] : 0.0;
        $reste = max(0, $total - $paye);
        
        // Couleur selon le statut
        $statut_colors = [
            'Non payé' => '#dc3545',
            'Partiellement payé' => '#ffc107',
            'Payé' => '#28a745'
        ];
        $color = $statut_colors[$row['statut_paiement']] ?? '#6c757d';
        
        echo "<tr>
                <td><strong>{$row['numero_facture']}</strong></td>
                <td>{$row['date_facture']}</td>
                <td>{$row['patient_nom']}</td>
                <td>" . (!empty($row['medecin_nom']) ? $row['medecin_nom'] : '-') . "</td>
                <td>" . number_format($total, 2, '.', ' ') . " DH</td>
                <td>" . number_format($paye, 2, '.', ' ') . " DH</td>
                <td><strong>" . number_format($reste, 2, '.', ' ') . " DH</strong></td>
                <td><span class='badge' style='background:{$color}'>{$row['statut_paiement']}</span></td>
                <td>
                    <a class='btn view' href='voir_facture.php?id={$row['idfacture']}'>Voir</a>
                    <a class='btn edit' href='modifier_facture.php?id={$row['idfacture']}'>Modifier</a>
                    <a class='btn delete' href='supprimer_facture.php?id={$row['idfacture']}' 
                       onclick='return confirm(\"Voulez-vous vraiment supprimer cette facture ?\")'>Supprimer</a>
                </td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "<p>Aucune facture trouvée.</p>";
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
.view { background: #60a5fa; color: white; }
.edit { background: #ffc107; color: black; }
.delete { background: #dc3545; color: white; }
.view:hover { background: #3b82f6; }
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
