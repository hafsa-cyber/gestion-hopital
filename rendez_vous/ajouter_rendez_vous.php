<?php include '../includes/header.php'; ?>
<?php include '../includes/config.php'; ?>

<h2>Ajouter un Rendez-vous</h2>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $idpatient = $_POST['idpatient'];
    $idmedecin = $_POST['idmedecin'];
    $date_rdv = $_POST['date_rdv'];
    $heure_rdv = $_POST['heure_rdv'];
    $motif = $_POST['motif'];
    $statut = $_POST['statut'];

    $sql = "INSERT INTO rendez_vous (idpatient, idmedecin, date_rdv, heure_rdv, motif, statut)
            VALUES ('$idpatient', '$idmedecin', '$date_rdv', '$heure_rdv', '$motif', '$statut')";

    if ($conn->query($sql) === TRUE) {
        echo "<div class='success'>Rendez-vous ajouté avec succès !</div>";
        echo "<a href='afficher_rendez_vous.php' class='btn-back'>← Retour à la liste</a>";
    } else {
        echo "<div class='error'>Erreur : " . $conn->error . "</div>";
    }
} else {
    // Récupérer la liste des patients
    $patients = $conn->query("SELECT idpatient, nom, prenom FROM patients ORDER BY nom");
    
    // Récupérer la liste des médecins actifs
    $medecins = $conn->query("SELECT idmedecin, nom, prenom, specialite FROM medecins WHERE statut='Actif' ORDER BY nom");
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
        <label>Date du rendez-vous :</label>
        <input type="date" name="date_rdv" required>
    </div>

    <div class="form-group">
        <label>Heure du rendez-vous :</label>
        <input type="time" name="heure_rdv" required>
    </div>

    <div class="form-group">
        <label>Motif de consultation :</label>
        <textarea name="motif" rows="4" required></textarea>
    </div>

    <div class="form-group">
        <label>Statut :</label>
        <select name="statut" required>
            <option value="Programmé">Programmé</option>
            <option value="Confirmé">Confirmé</option>
            <option value="Terminé">Terminé</option>
            <option value="Annulé">Annulé</option>
        </select>
    </div>

    <button type="submit" class="btn-submit">Ajouter le rendez-vous</button>
    <a href="afficher_rendez_vous.php" class="btn-cancel">Annuler</a>
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
