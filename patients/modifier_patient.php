<?php include '../includes/header.php'; ?>
<?php include '../includes/config.php'; ?>

<div class="page-header">
    <h2 class="page-title">
        Modifier un Patient
    </h2>
</div>

<?php
$id = $_GET['id'];

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

    $sql = "UPDATE patients 
            SET nom='$nom', prenom='$prenom', age='$age', date_naissance='$date_naissance', 
                adress='$adress', telephone='$telephone', email='$email', sexe='$sexe', groupe_sanguin='$groupe_sanguin'
            WHERE idpatient=$id";

    if ($conn->query($sql) === TRUE) {
        echo "<div class='alert alert-success'>
                <span>Patient modifié avec succès !</span>
              </div>";
        echo "<a href='afficher_patients.php' class='btn btn-primary'>← Retour à la liste</a>";
    } else {
        echo "<div class='alert alert-error'>
                <span>Erreur : " . $conn->error . "</span>
              </div>";
    }
} else {
    $sql = "SELECT * FROM patients WHERE idpatient=$id";
    $result = $conn->query($sql);
    $patient = $result->fetch_assoc();
?>

<div class="form-container">
    <form method="POST" action="">
        <div class="form-grid">
            <div class="form-group">
                <label>Nom <span class="required">*</span></label>
                <input type="text" name="nom" class="form-control" value="<?php echo $patient['nom']; ?>" required>
            </div>

            <div class="form-group">
                <label>Prénom <span class="required">*</span></label>
                <input type="text" name="prenom" class="form-control" value="<?php echo $patient['prenom']; ?>" required>
            </div>

            <div class="form-group">
                <label>Âge <span class="required">*</span></label>
                <input type="number" name="age" class="form-control" value="<?php echo $patient['age']; ?>" required>
            </div>

            <div class="form-group">
                <label>Date de naissance <span class="required">*</span></label>
                <input type="date" name="date_naissance" class="form-control" value="<?php echo $patient['date_naissance']; ?>" required>
            </div>

            <div class="form-group">
                <label>Sexe <span class="required">*</span></label>
                <select name="sexe" class="form-control" required>
                    <option value="M" <?php if($patient['sexe']=='M') echo 'selected'; ?>>Masculin</option>
                    <option value="F" <?php if($patient['sexe']=='F') echo 'selected'; ?>>Féminin</option>
                    <option value="Autre" <?php if($patient['sexe']=='Autre') echo 'selected'; ?>>Autre</option>
                </select>
            </div>

            <div class="form-group">
                <label>Groupe Sanguin</label>
                <select name="groupe_sanguin" class="form-control">
                    <option value="">-- Choisir --</option>
                    <option value="A+" <?php if($patient['groupe_sanguin']=='A+') echo 'selected'; ?>>A+</option>
                    <option value="A-" <?php if($patient['groupe_sanguin']=='A-') echo 'selected'; ?>>A-</option>
                    <option value="B+" <?php if($patient['groupe_sanguin']=='B+') echo 'selected'; ?>>B+</option>
                    <option value="B-" <?php if($patient['groupe_sanguin']=='B-') echo 'selected'; ?>>B-</option>
                    <option value="AB+" <?php if($patient['groupe_sanguin']=='AB+') echo 'selected'; ?>>AB+</option>
                    <option value="AB-" <?php if($patient['groupe_sanguin']=='AB-') echo 'selected'; ?>>AB-</option>
                    <option value="O+" <?php if($patient['groupe_sanguin']=='O+') echo 'selected'; ?>>O+</option>
                    <option value="O-" <?php if($patient['groupe_sanguin']=='O-') echo 'selected'; ?>>O-</option>
                </select>
            </div>

            <div class="form-group">
                <label>Téléphone <span class="required">*</span></label>
                <input type="tel" name="telephone" class="form-control" value="<?php echo $patient['telephone']; ?>" required>
            </div>

            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" class="form-control" value="<?php echo $patient['email']; ?>">
            </div>
        </div>

        <div class="form-group">
            <label>Adresse <span class="required">*</span></label>
            <input type="text" name="adress" class="form-control" value="<?php echo $patient['adress']; ?>" required>
        </div>

        <div class="flex gap-2 mt-3">
            <button type="submit" class="btn btn-success">Enregistrer les modifications</button>
            <a href="afficher_patients.php" class="btn btn-secondary">Annuler</a>
        </div>
    </form>
</div>

<?php } ?>

<?php include '../includes/footer.php'; ?>
