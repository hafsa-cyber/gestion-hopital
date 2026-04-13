<?php
include 'includes/config.php';

echo "<h2>🔍 Diagnostic des Rendez-vous</h2>";

// Vérifier la structure de la table
echo "<h3>1. Structure de la table rendez_vous :</h3>";
$structure = $conn->query("SHOW COLUMNS FROM rendez_vous");
echo "<table border='1' cellpadding='5'><tr><th>Colonne</th><th>Type</th></tr>";
while($col = $structure->fetch_assoc()) {
    echo "<tr><td>{$col['Field']}</td><td>{$col['Type']}</td></tr>";
}
echo "</table><br>";

// Compter les rendez-vous
$count = $conn->query("SELECT COUNT(*) as total FROM rendez_vous")->fetch_assoc();
echo "<h3>2. Nombre total de rendez-vous : <strong>{$count['total']}</strong></h3><br>";

// Afficher tous les rendez-vous
echo "<h3>3. Liste de tous les rendez-vous :</h3>";
$rdv = $conn->query("SELECT * FROM rendez_vous ORDER BY idrendezvous DESC");

if($rdv->num_rows > 0) {
    echo "<table border='1' cellpadding='10' style='border-collapse: collapse;'>";
    echo "<tr style='background: #007bff; color: white;'>
            <th>ID</th>
            <th>ID Patient</th>
            <th>ID Médecin</th>
            <th>Date</th>
            <th>Heure</th>
            <th>Motif</th>
            <th>Statut</th>
          </tr>";
    while($r = $rdv->fetch_assoc()) {
        echo "<tr>
                <td>{$r['idrendezvous']}</td>
                <td>{$r['idpatient']}</td>
                <td>{$r['idmedecin']}</td>
                <td>{$r['date_rdv']}</td>
                <td>{$r['heure_rdv']}</td>
                <td>{$r['motif']}</td>
                <td><strong>{$r['statut']}</strong></td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "<p style='color: red;'>❌ Aucun rendez-vous trouvé dans la base de données !</p>";
}

// Test de la requête de la page d'accueil
echo "<br><h3>4. Test de la requête de la page d'accueil :</h3>";
$test_query = "SELECT r.*, 
                CONCAT(p.nom, ' ', p.prenom) AS patient,
                CONCAT(m.nom, ' ', m.prenom) AS medecin
                FROM rendez_vous r
                JOIN patients p ON r.idpatient = p.idpatient
                JOIN medecins m ON r.idmedecin = m.idmedecin
                ORDER BY r.date_creation DESC
                LIMIT 5";

$test_result = $conn->query($test_query);
if($test_result) {
    echo "<p style='color: green;'>✅ Requête exécutée avec succès ! Résultats : <strong>{$test_result->num_rows}</strong></p>";
    
    if($test_result->num_rows > 0) {
        echo "<table border='1' cellpadding='10' style='border-collapse: collapse;'>";
        echo "<tr style='background: #28a745; color: white;'>
                <th>Patient</th>
                <th>Médecin</th>
                <th>Date</th>
                <th>Heure</th>
                <th>Statut</th>
              </tr>";
        while($t = $test_result->fetch_assoc()) {
            echo "<tr>
                    <td>{$t['patient']}</td>
                    <td>{$t['medecin']}</td>
                    <td>{$t['date_rdv']}</td>
                    <td>{$t['heure_rdv']}</td>
                    <td>{$t['statut']}</td>
                  </tr>";
        }
        echo "</table>";
    }
} else {
    echo "<p style='color: red;'>❌ Erreur dans la requête : " . $conn->error . "</p>";
}

echo "<br><p><a href='index.php' style='padding: 10px 20px; background: #007bff; color: white; text-decoration: none; border-radius: 5px;'>Retour à l'accueil</a></p>";

$conn->close();
?>
