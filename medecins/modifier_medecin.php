<?php include '../includes/header.php'; ?>
<?php include '../includes/config.php'; ?>

<h2>Modifier un Médecin</h2>

<?php
$id = $_GET['id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $specialite = $_POST['specialite'];
    $telephone = $_POST['telephone'];
    $email = $_POST['email'];
    $adresse = $_POST['adresse'];
    $numero_licence = $_POST['numero_licence'];
    $date_embauche = $_POST['date_embauche'];
    $tarif_consultation = $_POST['tarif_consultation'];
    $statut = $_POST['statut'];

    $sql = "UPDATE medecins SET 
            nom='$nom', 
            prenom='$prenom', 
            specialite='$specialite', 
            telephone='$telephone', 
            email='$email', 
            adresse='$adresse', 
            numero_licence='$numero_licence', 
            date_embauche='$date_embauche', 
            tarif_consultation='$tarif_consultation', 
            statut='$statut' 
            WHERE idmedecin=$id";

    if ($conn->query($sql) === TRUE) {
        echo "<div class='success'>Médecin modifié avec succès !</div>";
        echo "<a href='afficher_medecins.php' class='btn-back'>← Retour à la liste</a>";
    } else {
        echo "<div class='error'>Erreur : " . $conn->error . "</div>";
    }
} else {
    $sql = "SELECT * FROM medecins WHERE idmedecin=$id";
    $result = $conn->query($sql);
    $medecin = $result->fetch_assoc();
?>

<form method="POST" action="">
    <div class="form-group">
        <label>Nom :</label>
        <input type="text" name="nom" value="<?php echo $medecin['nom']; ?>" required>
    </div>

    <div class="form-group">
        <label>Prénom :</label>
        <input type="text" name="prenom" value="<?php echo $medecin['prenom']; ?>" required>
    </div>

    <div class="form-group">
        <label>Spécialité :</label>
        <select name="specialite" required>
            <option value="Médecine générale" <?php if($medecin['specialite']=='Médecine générale') echo 'selected'; ?>>Médecine générale</option>
            <option value="Cardiologie" <?php if($medecin['specialite']=='Cardiologie') echo 'selected'; ?>>Cardiologie</option>
            <option value="Pédiatrie" <?php if($medecin['specialite']=='Pédiatrie') echo 'selected'; ?>>Pédiatrie</option>
            <option value="Dermatologie" <?php if($medecin['specialite']=='Dermatologie') echo 'selected'; ?>>Dermatologie</option>
            <option value="Chirurgie" <?php if($medecin['specialite']=='Chirurgie') echo 'selected'; ?>>Chirurgie</option>
            <option value="Gynécologie" <?php if($medecin['specialite']=='Gynécologie') echo 'selected'; ?>>Gynécologie</option>
            <option value="Ophtalmologie" <?php if($medecin['specialite']=='Ophtalmologie') echo 'selected'; ?>>Ophtalmologie</option>
            <option value="Psychiatrie" <?php if($medecin['specialite']=='Psychiatrie') echo 'selected'; ?>>Psychiatrie</option>
            <option value="Radiologie" <?php if($medecin['specialite']=='Radiologie') echo 'selected'; ?>>Radiologie</option>
            <option value="Autre" <?php if($medecin['specialite']=='Autre') echo 'selected'; ?>>Autre</option>
        </select>
    </div>

    <div class="form-group">
        <label>Téléphone :</label>
        <input type="text" name="telephone" value="<?php echo $medecin['telephone']; ?>" required>
    </div>

    <div class="form-group">
        <label>Email :</label>
        <input type="email" name="email" value="<?php echo $medecin['email']; ?>">
    </div>

    <div class="form-group">
        <label>Adresse :</label>
        <input type="text" name="adresse" value="<?php echo $medecin['adresse']; ?>">
    </div>

    <div class="form-group">
        <label>Numéro de Licence :</label>
        <input type="text" name="numero_licence" value="<?php echo $medecin['numero_licence']; ?>" required>
    </div>

    <div class="form-group">
        <label>Date d'embauche :</label>
        <input type="date" name="date_embauche" value="<?php echo $medecin['date_embauche']; ?>" required>
    </div>

    <div class="form-group">
        <label>Tarif Consultation (DH) :</label>
        <input type="number" step="0.01" name="tarif_consultation" value="<?php echo $medecin['tarif_consultation']; ?>" required>
    </div>

    <div class="form-group">
        <label>Statut :</label>
        <select name="statut" required>
            <option value="Actif" <?php if($medecin['statut']=='Actif') echo 'selected'; ?>>Actif</option>
            <option value="Inactif" <?php if($medecin['statut']=='Inactif') echo 'selected'; ?>>Inactif</option>
            <option value="En congé" <?php if($medecin['statut']=='En congé') echo 'selected'; ?>>En congé</option>
        </select>
    </div>

    <button type="submit" class="btn-submit">Modifier</button>
    <a href="afficher_medecins.php" class="btn-cancel">Annuler</a>
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
