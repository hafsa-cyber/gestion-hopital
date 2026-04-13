<?php
include('includes/config.php');

$resultat = $conn->query("SELECT * FROM patients");
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Liste des Patients</title>
  <style>
    body { font-family: Arial; margin: 40px; }
    table { border-collapse: collapse; width: 100%; }
    th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
    th { background-color: #f2f2f2; }
  </style>
</head>
<body>
  <h2>Liste des Patients</h2>
  <table>
    <tr>
      <th>ID</th>
      <th>Nom</th>
      <th>Prénom</th>
      <th>Âge</th>
      <th>Adresse</th>
      <th>Téléphone</th>
    </tr>

    <?php while($row = $resultat->fetch_assoc()) { ?>
    <tr>
      <td><?php echo $row['idpatient']; ?></td>
      <td><?php echo $row['nom']; ?></td>
      <td><?php echo $row['prenom']; ?></td>
      <td><?php echo $row['age']; ?></td>
      <td><?php echo $row['adress']; ?></td>
      <td><?php echo $row['telephone']; ?></td>
    </tr>
    <?php } ?>
  </table>
</body>
</html>
