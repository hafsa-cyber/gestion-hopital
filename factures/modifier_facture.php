<?php include '../includes/header.php'; ?>
<?php include '../includes/config.php'; ?>

<h2>Modifier une Facture</h2>

<?php
$id = $_GET['id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $montant_paye = $_POST['montant_paye'];
    $statut_paiement = $_POST['statut_paiement'];
    $mode_paiement = $_POST['mode_paiement'] ?: NULL;

    $sql = "UPDATE factures SET 
            montant_paye='$montant_paye', 
            statut_paiement='$statut_paiement',
            mode_paiement=" . ($mode_paiement ? "'$mode_paiement'" : "NULL") . "
            WHERE idfacture=$id";

    if ($conn->query($sql) === TRUE) {
        echo "<div class='success'>Facture modifiée avec succès !</div>";
        echo "<a href='afficher_factures.php' class='btn-back'>← Retour à la liste</a>";
    } else {
        echo "<div class='error'>Erreur : " . $conn->error . "</div>";
    }
} else {
    $sql = "SELECT * FROM factures WHERE idfacture=$id";
    $result = $conn->query($sql);
    $facture = $result->fetch_assoc();
?>

<div class="info-box">
    <p><strong>Numéro de facture:</strong> <?php echo $facture['numero_facture']; ?></p>
    <p><strong>Montant total:</strong> <?php echo $facture['montant_total']; ?> DH</p>
    <p><strong>Reste à payer:</strong> <?php echo ($facture['montant_total'] - $facture['montant_paye']); ?> DH</p>
</div>

<form method="POST" action="">
    <div class="form-group">
        <label>Montant Payé (DH) :</label>
        <input type="number" step="0.01" name="montant_paye" value="<?php echo $facture['montant_paye']; ?>" required>
    </div>

    <div class="form-group">
        <label>Statut de Paiement :</label>
        <select name="statut_paiement" required>
            <option value="Non payé" <?php if($facture['statut_paiement']=='Non payé') echo 'selected'; ?>>Non payé</option>
            <option value="Partiellement payé" <?php if($facture['statut_paiement']=='Partiellement payé') echo 'selected'; ?>>Partiellement payé</option>
            <option value="Payé" <?php if($facture['statut_paiement']=='Payé') echo 'selected'; ?>>Payé</option>
        </select>
    </div>

    <div class="form-group">
        <label>Mode de Paiement :</label>
        <select name="mode_paiement">
            <option value="">-- Choisir --</option>
            <option value="Espèces" <?php if($facture['mode_paiement']=='Espèces') echo 'selected'; ?>>Espèces</option>
            <option value="Carte bancaire" <?php if($facture['mode_paiement']=='Carte bancaire') echo 'selected'; ?>>Carte bancaire</option>
            <option value="Chèque" <?php if($facture['mode_paiement']=='Chèque') echo 'selected'; ?>>Chèque</option>
            <option value="Virement" <?php if($facture['mode_paiement']=='Virement') echo 'selected'; ?>>Virement</option>
            <option value="Assurance" <?php if($facture['mode_paiement']=='Assurance') echo 'selected'; ?>>Assurance</option>
        </select>
    </div>

    <button type="submit" class="btn-submit">Modifier</button>
    <a href="afficher_factures.php" class="btn-cancel">Annuler</a>
</form>

<?php } ?>

<style>
.info-box {
    background: #e7f3ff;
    padding: 15px;
    border-radius: 5px;
    margin-bottom: 20px;
    border-left: 4px solid #60a5fa;
}
.info-box p {
    margin: 5px 0;
    font-size: 16px;
}
.form-group {
    margin-bottom: 15px;
}
.form-group label {
    display: block;
    font-weight: bold;
    margin-bottom: 5px;
}
.form-group input, .form-group select {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 14px;
}
.btn-submit, .btn-cancel, .btn-back {
    display: inline-block;
    padding: 10px 20px;
    margin: 10px 5px;
    border: none;
    border-radius: 5px;
    font-weight: bold;
    text-decoration: none;
    cursor: pointer;
}
.btn-submit {
    background: #28a745;
    color: white;
}
.btn-cancel {
    background: #dc3545;
    color: white;
}
.btn-back {
    background: #60a5fa;
    color: white;
}
.success {
    background: #d4edda;
    color: #155724;
    padding: 15px;
    border-radius: 5px;
    margin-bottom: 20px;
}
.error {
    background: #f8d7da;
    color: #721c24;
    padding: 15px;
    border-radius: 5px;
    margin-bottom: 20px;
}
</style>

<?php include '../includes/footer.php'; ?>
