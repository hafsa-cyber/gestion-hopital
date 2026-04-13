<?php include '../includes/header.php'; ?>
<?php include '../includes/config.php'; ?>

<h2>Créer une Facture</h2>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $idpatient = $_POST['idpatient'];
    $idmedecin = $_POST['idmedecin'];
    $idrendezvous = $_POST['idrendezvous'] ?: NULL;
    $date_facture = $_POST['date_facture'];
    $montant_total = $_POST['montant_total'];
    $montant_paye = $_POST['montant_paye'];
    $statut_paiement = $_POST['statut_paiement'];
    $mode_paiement = $_POST['mode_paiement'] ?: NULL;
    $description = $_POST['description'];
    
    // Générer un numéro de facture unique
    $numero_facture = 'FACT-' . date('Ymd') . '-' . rand(1000, 9999);

    $sql = "INSERT INTO factures (idpatient, idmedecin, idrendezvous, numero_facture, date_facture, montant_total, montant_paye, statut_paiement, mode_paiement, description)
            VALUES ('$idpatient', '$idmedecin', " . ($idrendezvous ? "'$idrendezvous'" : "NULL") . ", '$numero_facture', '$date_facture', '$montant_total', '$montant_paye', '$statut_paiement', " . ($mode_paiement ? "'$mode_paiement'" : "NULL") . ", '$description')";

    if ($conn->query($sql) === TRUE) {
        echo "<div class='success'>Facture créée avec succès ! Numéro: <strong>$numero_facture</strong></div>";
        echo "<a href='afficher_factures.php' class='btn-back'>← Retour à la liste</a>";
    } else {
        echo "<div class='error'>Erreur : " . $conn->error . "</div>";
    }
} else {
    // Récupérer la liste des patients
    $patients = $conn->query("SELECT idpatient, nom, prenom FROM patients ORDER BY nom");
    
    // Récupérer la liste des médecins
    $medecins = $conn->query("SELECT idmedecin, nom, prenom, specialite FROM medecins ORDER BY nom");
    
    // Récupérer les rendez-vous terminés
    $rendez_vous = $conn->query("SELECT r.idrendezvous, CONCAT(p.nom, ' ', p.prenom) AS patient, CONCAT(m.nom, ' ', m.prenom) AS medecin, r.date_rdv 
                                 FROM rendez_vous r 
                                 JOIN patients p ON r.idpatient = p.idpatient 
                                 JOIN medecins m ON r.idmedecin = m.idmedecin 
                                 WHERE r.statut='Terminé' 
                                 ORDER BY r.date_rdv DESC");
?>

<form method="POST" action="">
    <div class="form-group">
        <label>Patient :</label>
        <select name="idpatient" required>
            <option value="">-- Choisir un patient --</option>
            <?php while($p = $patients->fetch_assoc()) { ?>
                <option value="<?php echo $p['idpatient']; ?>">
                    <?php echo $p['nom'] . ' ' . $p['prenom']; ?>
                </option>
            <?php } ?>
        </select>
    </div>

    <div class="form-group">
        <label>Médecin :</label>
        <select name="idmedecin" required>
            <option value="">-- Choisir un médecin --</option>
            <?php while($m = $medecins->fetch_assoc()) { ?>
                <option value="<?php echo $m['idmedecin']; ?>">
                    Dr. <?php echo $m['nom'] . ' ' . $m['prenom']; ?> (<?php echo $m['specialite']; ?>)
                </option>
            <?php } ?>
        </select>
    </div>

    <div class="form-group">
        <label>Rendez-vous associé (optionnel) :</label>
        <select name="idrendezvous">
            <option value="">-- Aucun --</option>
            <?php while($r = $rendez_vous->fetch_assoc()) { ?>
                <option value="<?php echo $r['idrendezvous']; ?>">
                    RDV du <?php echo $r['date_rdv']; ?> - <?php echo $r['patient']; ?> / Dr. <?php echo $r['medecin']; ?>
                </option>
            <?php } ?>
        </select>
    </div>

    <div class="form-group">
        <label>Date de la facture :</label>
        <input type="date" name="date_facture" value="<?php echo date('Y-m-d'); ?>" required>
    </div>

    <div class="form-group">
        <label>Description :</label>
        <textarea name="description" rows="3" required placeholder="Ex: Consultation générale, Examen médical..."></textarea>
    </div>

    <div class="form-group">
        <label>Montant Total (DH) :</label>
        <input type="number" step="0.01" name="montant_total" required>
    </div>

    <div class="form-group">
        <label>Montant Payé (DH) :</label>
        <input type="number" step="0.01" name="montant_paye" value="0" required>
    </div>

    <div class="form-group">
        <label>Statut de Paiement :</label>
        <select name="statut_paiement" required>
            <option value="Non payé">Non payé</option>
            <option value="Partiellement payé">Partiellement payé</option>
            <option value="Payé">Payé</option>
        </select>
    </div>

    <div class="form-group">
        <label>Mode de Paiement :</label>
        <select name="mode_paiement">
            <option value="">-- Choisir --</option>
            <option value="Espèces">Espèces</option>
            <option value="Carte bancaire">Carte bancaire</option>
            <option value="Chèque">Chèque</option>
            <option value="Virement">Virement</option>
            <option value="Assurance">Assurance</option>
        </select>
    </div>

    <button type="submit" class="btn-submit">Créer la facture</button>
    <a href="afficher_factures.php" class="btn-cancel">Annuler</a>
</form>

<?php } ?>

<style>
.form-group {
    margin-bottom: 15px;
}
.form-group label {
    display: block;
    font-weight: bold;
    margin-bottom: 5px;
}
.form-group input, .form-group select, .form-group textarea {
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
