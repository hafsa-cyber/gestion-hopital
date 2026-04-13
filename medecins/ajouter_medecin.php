<?php include '../includes/header.php'; ?>
<?php include '../includes/config.php'; ?>

<h2>Ajouter un Médecin</h2>

<?php
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

    $sql = "INSERT INTO medecins (nom, prenom, specialite, telephone, email, adresse, numero_licence, date_embauche, tarif_consultation, statut)
            VALUES ('$nom', '$prenom', '$specialite', '$telephone', '$email', '$adresse', '$numero_licence', '$date_embauche', '$tarif_consultation', '$statut')";

    if ($conn->query($sql) === TRUE) {
        echo "<div class='success'>Médecin ajouté avec succès !</div>";
        echo "<a href='afficher_medecins.php' class='btn-back'>← Retour à la liste</a>";
    } else {
        echo "<div class='error'>Erreur : " . $conn->error . "</div>";
    }
    $conn->close();
} else {
?>

<form method="POST" action="">
    <div class="form-group">
        <label>Nom :</label>
        <input type="text" name="nom" required>
    </div>

    <div class="form-group">
        <label>Prénom :</label>
        <input type="text" name="prenom" required>
    </div>

    <div class="form-group">
        <label>Spécialité :</label>
        <select name="specialite" required>
            <option value="">-- Choisir --</option>
            <option value="Médecine générale">Médecine générale</option>
            <option value="Cardiologie">Cardiologie</option>
            <option value="Pédiatrie">Pédiatrie</option>
            <option value="Dermatologie">Dermatologie</option>
            <option value="Chirurgie">Chirurgie</option>
            <option value="Gynécologie">Gynécologie</option>
            <option value="Ophtalmologie">Ophtalmologie</option>
            <option value="Psychiatrie">Psychiatrie</option>
            <option value="Radiologie">Radiologie</option>
            <option value="Autre">Autre</option>
        </select>
    </div>

    <div class="form-group">
        <label>Téléphone :</label>
        <input type="text" name="telephone" required>
    </div>

    <div class="form-group">
        <label>Email :</label>
        <input type="email" name="email">
    </div>

    <div class="form-group">
        <label>Adresse :</label>
        <input type="text" name="adresse">
    </div>

    <div class="form-group">
        <label>Numéro de Licence :</label>
        <input type="text" name="numero_licence" required>
    </div>

    <div class="form-group">
        <label>Date d'embauche :</label>
        <input type="date" name="date_embauche" required>
    </div>

    <div class="form-group">
        <label>Tarif Consultation (DH) :</label>
        <input type="number" step="0.01" name="tarif_consultation" required>
    </div>

    <div class="form-group">
        <label>Statut :</label>
        <select name="statut" required>
            <option value="Actif">Actif</option>
            <option value="Inactif">Inactif</option>
            <option value="En congé">En congé</option>
        </select>
    </div>

    <button type="submit" class="btn-submit">Ajouter le médecin</button>
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
