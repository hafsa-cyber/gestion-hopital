<?php include '../includes/header.php'; ?>
<?php include '../includes/config.php'; ?>

<div class="page-header">
    <h2 class="page-title">
        Ajouter un Patient
    </h2>
</div>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $age = $_POST['age'];
    $date_naissance = $_POST['date_naissance'];
    $adress = $_POST['adress'];
    $telephone = $_POST['telephone'];
    $email = $_POST['email'];
    $sexe = $_POST['sexe'];
    $groupe_sanguin = $_POST['groupe_sanguin'];

    $sql = "INSERT INTO patients (nom, prenom, age, date_naissance, adress, telephone, email, sexe, groupe_sanguin)
            VALUES ('$nom', '$prenom', '$age', '$date_naissance', '$adress', '$telephone', '$email', '$sexe', '$groupe_sanguin')";

    if ($conn->query($sql) === TRUE) {
        echo "<div class='alert alert-success'>
                <span>Patient ajouté avec succès !</span>
              </div>";
        echo "<a href='afficher_patients.php' class='btn btn-primary'>← Retour à la liste des patients</a>";
    } else {
        echo "<div class='alert alert-error'>
                <span>Erreur : " . $conn->error . "</span>
              </div>";
    }
    $conn->close();
} else {
?>

<div class="form-container">
    <form method="POST" action="">
        <div class="form-grid">
            <div class="form-group">
                <label>Nom <span class="required">*</span></label>
                <input type="text" name="nom" class="form-control" required>
            </div>

            <div class="form-group">
                <label>Prénom <span class="required">*</span></label>
                <input type="text" name="prenom" class="form-control" required>
            </div>

            <div class="form-group">
                <label>Âge <span class="required">*</span></label>
                <input type="number" name="age" class="form-control" min="0" max="150" required>
            </div>

            <div class="form-group">
                <label>Date de naissance <span class="required">*</span></label>
                <input type="date" name="date_naissance" class="form-control" required>
            </div>

            <div class="form-group">
                <label>Sexe <span class="required">*</span></label>
                <select name="sexe" class="form-control" required>
                    <option value="">-- Choisir --</option>
                    <option value="M">Masculin</option>
                    <option value="F">Féminin</option>
                    <option value="Autre">Autre</option>
                </select>
            </div>

            <div class="form-group">
                <label>Groupe Sanguin</label>
                <select name="groupe_sanguin" class="form-control">
                    <option value="">-- Choisir --</option>
                    <option value="A+">A+</option>
                    <option value="A-">A-</option>
                    <option value="B+">B+</option>
                    <option value="B-">B-</option>
                    <option value="AB+">AB+</option>
                    <option value="AB-">AB-</option>
                    <option value="O+">O+</option>
                    <option value="O-">O-</option>
                </select>
            </div>

            <div class="form-group">
                <label>Téléphone <span class="required">*</span></label>
                <input type="tel" name="telephone" class="form-control" placeholder="06XXXXXXXX" required>
            </div>

            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" class="form-control" placeholder="exemple@email.com">
            </div>
        </div>

        <div class="form-group">
            <label>Adresse <span class="required">*</span></label>
            <input type="text" name="adress" class="form-control" placeholder="Rue, Ville, Code postal" required>
        </div>

        <div class="flex gap-2 mt-3">
            <button type="submit" class="btn btn-success">Ajouter le patient</button>
            <a href="afficher_patients.php" class="btn btn-secondary">Annuler</a>
        </div>
    </form>
</div>

<?php } ?>

<?php include '../includes/footer.php'; ?>
