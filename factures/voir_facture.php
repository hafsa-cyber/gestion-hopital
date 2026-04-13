<?php include '../includes/header.php'; ?>
<?php include '../includes/config.php'; ?>

<?php
$id = $_GET['id'];

// Récupérer les détails de la facture
$sql = "SELECT f.*, 
        CONCAT(p.nom, ' ', p.prenom) AS patient_nom,
        p.adress AS patient_adresse,
        p.telephone AS patient_tel,
        CONCAT(m.nom, ' ', m.prenom) AS medecin_nom,
        m.specialite
        FROM factures f
        JOIN patients p ON f.idpatient = p.idpatient
        LEFT JOIN medecins m ON f.idmedecin = m.idmedecin
        WHERE f.idfacture = $id";
$result = $conn->query($sql);
$facture = $result->fetch_assoc();

$reste = $facture['montant_total'] - $facture['montant_paye'];
?>

<div class="facture-container">
    <div class="facture-header">
        <h1>FACTURE MÉDICALE</h1>
        <p><strong>Numéro:</strong> <?php echo $facture['numero_facture']; ?></p>
        <p><strong>Date:</strong> <?php echo date('d/m/Y', strtotime($facture['date_facture'])); ?></p>
    </div>

    <div class="facture-body">
        <div class="section">
            <h3>Informations Patient</h3>
            <p><strong>Nom:</strong> <?php echo $facture['patient_nom']; ?></p>
            <p><strong>Adresse:</strong> <?php echo $facture['patient_adresse']; ?></p>
            <p><strong>Téléphone:</strong> <?php echo $facture['patient_tel']; ?></p>
        </div>

        <div class="section">
            <h3>Médecin Traitant</h3>
            <p><strong>Dr.</strong> <?php echo $facture['medecin_nom']; ?></p>
            <p><strong>Spécialité:</strong> <?php echo $facture['specialite']; ?></p>
        </div>

        <div class="section">
            <h3>Description</h3>
            <p><?php echo nl2br($facture['description']); ?></p>
        </div>

        <div class="section montants">
            <table class="montants-table">
                <tr>
                    <td><strong>Montant Total:</strong></td>
                    <td class="montant"><?php echo number_format($facture['montant_total'], 2); ?> DH</td>
                </tr>
                <tr>
                    <td><strong>Montant Payé:</strong></td>
                    <td class="montant"><?php echo number_format($facture['montant_paye'], 2); ?> DH</td>
                </tr>
                <tr class="reste">
                    <td><strong>Reste à Payer:</strong></td>
                    <td class="montant"><strong><?php echo number_format($reste, 2); ?> DH</strong></td>
                </tr>
            </table>
        </div>

        <div class="section">
            <p><strong>Statut:</strong> 
                <span class="badge-<?php echo strtolower(str_replace(' ', '-', $facture['statut_paiement'])); ?>">
                    <?php echo $facture['statut_paiement']; ?>
                </span>
            </p>
            <?php if($facture['mode_paiement']) { ?>
                <p><strong>Mode de paiement:</strong> <?php echo $facture['mode_paiement']; ?></p>
            <?php } ?>
        </div>
    </div>

    <div class="facture-footer">
        <button onclick="window.print()" class="btn-print">Imprimer</button>
        <a href="modifier_facture.php?id=<?php echo $id; ?>" class="btn-edit">Modifier</a>
        <a href="afficher_factures.php" class="btn-back">← Retour</a>
    </div>
</div>

<style>
.facture-container {
    max-width: 800px;
    margin: 20px auto;
    background: white;
    padding: 40px;
    box-shadow: 0 0 20px rgba(0,0,0,0.1);
    border-radius: 10px;
}
.facture-header {
    text-align: center;
    border-bottom: 3px solid #60a5fa;
    padding-bottom: 20px;
    margin-bottom: 30px;
}
.facture-header h1 {
    color: #60a5fa;
    margin-bottom: 10px;
}
.section {
    margin-bottom: 25px;
    padding: 15px;
    background: #f8f9fa;
    border-radius: 5px;
}
.section h3 {
    color: #60a5fa;
    margin-bottom: 10px;
}
.section p {
    margin: 5px 0;
}
.montants {
    background: #e7f3ff;
}
.montants-table {
    width: 100%;
    border-collapse: collapse;
}
.montants-table td {
    padding: 10px;
    border-bottom: 1px solid #ccc;
}
.montants-table .montant {
    text-align: right;
    font-size: 18px;
}
.montants-table .reste {
    background: #ffc107;
    font-size: 20px;
}
.badge-non-payé { background: #dc3545; color: white; padding: 5px 15px; border-radius: 5px; }
.badge-partiellement-payé { background: #ffc107; color: black; padding: 5px 15px; border-radius: 5px; }
.badge-payé { background: #28a745; color: white; padding: 5px 15px; border-radius: 5px; }
.facture-footer {
    text-align: center;
    margin-top: 30px;
    padding-top: 20px;
    border-top: 2px solid #ccc;
}
.btn-print, .btn-edit, .btn-back {
    display: inline-block;
    padding: 10px 20px;
    margin: 5px;
    border: none;
    border-radius: 5px;
    font-weight: bold;
    text-decoration: none;
    cursor: pointer;
}
.btn-print { background: #60a5fa; color: white; }
.btn-edit { background: #ffc107; color: black; }
.btn-back { background: #6c757d; color: white; }

@media print {
    .facture-footer { display: none; }
    body { background: white; }
    main { padding: 0; }
}
</style>

<?php include '../includes/footer.php'; ?>
