<?php
// Script d'installation de la base de données
include 'includes/config.php';

echo "<h2>Installation de la base de données...</h2>";

// Créer la table patients (schéma aligné avec l'application)
$sql_patients = "CREATE TABLE IF NOT EXISTS patients (
    idpatient INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    prenom VARCHAR(100) NOT NULL,
    age INT NULL,
    date_naissance DATE NULL,
    adress VARCHAR(255) NULL,
    telephone VARCHAR(20) NULL,
    email VARCHAR(100) NULL,
    sexe ENUM('M','F','Autre') NULL,
    groupe_sanguin ENUM('A+','A-','B+','B-','AB+','AB-','O+','O-') NULL,
    date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";

if ($conn->query($sql_patients) === TRUE) {
    echo "✅ Table 'patients' créée avec succès<br>";
} else {
    echo "❌ Erreur création table patients: " . $conn->error . "<br>";
}

// Compat: ajouter colonnes manquantes (sans IF NOT EXISTS) selon version
$required_patient_columns = [
    'date_naissance' => "ALTER TABLE patients ADD COLUMN date_naissance DATE NULL",
    'adress' => "ALTER TABLE patients ADD COLUMN adress VARCHAR(255) NULL",
    'email' => "ALTER TABLE patients ADD COLUMN email VARCHAR(100) NULL",
    'sexe' => "ALTER TABLE patients ADD COLUMN sexe ENUM('M','F','Autre') NULL",
    'groupe_sanguin' => "ALTER TABLE patients ADD COLUMN groupe_sanguin ENUM('A+','A-','B+','B-','AB+','AB-','O+','O-') NULL",
];
foreach ($required_patient_columns as $col => $alterSql) {
    $check = $conn->query("SHOW COLUMNS FROM patients LIKE '" . $conn->real_escape_string($col) . "'");
    if ($check && $check->num_rows === 0) {
        $conn->query($alterSql);
    }
}

// Créer la table medecins
$sql_medecins = "CREATE TABLE IF NOT EXISTS medecins (
    idmedecin INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    prenom VARCHAR(100) NOT NULL,
    specialite VARCHAR(100) NOT NULL,
    telephone VARCHAR(20),
    email VARCHAR(100),
    adresse VARCHAR(255),
    numero_licence VARCHAR(50) UNIQUE,
    date_embauche DATE,
    statut ENUM('Actif', 'Inactif', 'En congé') DEFAULT 'Actif',
    tarif_consultation DECIMAL(10,2) DEFAULT 0.00,
    date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";

if ($conn->query($sql_medecins) === TRUE) {
    echo "✅ Table 'medecins' créée avec succès<br>";
} else {
    echo "❌ Erreur création table medecins: " . $conn->error . "<br>";
}

// Créer la table rendez_vous
$sql_rdv = "CREATE TABLE IF NOT EXISTS rendez_vous (
    idrendezvous INT AUTO_INCREMENT PRIMARY KEY,
    idpatient INT NOT NULL,
    idmedecin INT NOT NULL,
    date_rdv DATE NOT NULL,
    heure_rdv TIME NOT NULL,
    motif TEXT,
    statut ENUM('Programmé', 'Confirmé', 'Terminé', 'Annulé') DEFAULT 'Programmé',
    notes TEXT,
    date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (idpatient) REFERENCES patients(idpatient) ON DELETE CASCADE,
    FOREIGN KEY (idmedecin) REFERENCES medecins(idmedecin) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";

if ($conn->query($sql_rdv) === TRUE) {
    echo "✅ Table 'rendez_vous' créée avec succès<br>";
} else {
    echo "❌ Erreur création table rendez_vous: " . $conn->error . "<br>";
}

// Créer la table factures
$sql_factures = "CREATE TABLE IF NOT EXISTS factures (
    idfacture INT AUTO_INCREMENT PRIMARY KEY,
    idpatient INT NOT NULL,
    idmedecin INT,
    idrendezvous INT,
    numero_facture VARCHAR(50) UNIQUE NOT NULL,
    date_facture DATE NOT NULL,
    montant_total DECIMAL(10,2) NOT NULL,
    montant_paye DECIMAL(10,2) DEFAULT 0.00,
    statut_paiement ENUM('Non payé', 'Partiellement payé', 'Payé') DEFAULT 'Non payé',
    mode_paiement ENUM('Espèces', 'Carte bancaire', 'Chèque', 'Virement', 'Assurance') NULL,
    description TEXT,
    date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (idpatient) REFERENCES patients(idpatient) ON DELETE CASCADE,
    FOREIGN KEY (idmedecin) REFERENCES medecins(idmedecin) ON DELETE SET NULL,
    FOREIGN KEY (idrendezvous) REFERENCES rendez_vous(idrendezvous) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";

if ($conn->query($sql_factures) === TRUE) {
    echo "✅ Table 'factures' créée avec succès<br>";
} else {
    echo "❌ Erreur création table factures: " . $conn->error . "<br>";
}

// Insérer des médecins de test avec des noms marocains
$sql_insert = "INSERT INTO medecins (nom, prenom, specialite, telephone, email, numero_licence, date_embauche, tarif_consultation) VALUES
('El Amrani', 'Fatima', 'Cardiologie', '0612345678', 'f.elamrani@hopital.ma', 'MED001', '2020-01-15', 500.00),
('Benjelloun', 'Mohammed', 'Pédiatrie', '0623456789', 'm.benjelloun@hopital.ma', 'MED002', '2019-06-20', 400.00),
('Alaoui', 'Khadija', 'Dermatologie', '0634567890', 'k.alaoui@hopital.ma', 'MED003', '2021-03-10', 450.00),
('Tazi', 'Youssef', 'Chirurgie', '0645678901', 'y.tazi@hopital.ma', 'MED004', '2018-09-05', 800.00),
('Idrissi', 'Amina', 'Médecine générale', '0656789012', 'a.idrissi@hopital.ma', 'MED005', '2022-01-12', 300.00),
('Bennis', 'Hassan', 'Ophtalmologie', '0667890123', 'h.bennis@hopital.ma', 'MED006', '2021-08-20', 350.00),
('Chraibi', 'Salma', 'Gynécologie', '0678901234', 's.chraibi@hopital.ma', 'MED007', '2020-05-15', 450.00),
('Fassi', 'Omar', 'Radiologie', '0689012345', 'o.fassi@hopital.ma', 'MED008', '2019-11-10', 550.00)";

if ($conn->query($sql_insert) === TRUE) {
    echo "✅ Médecins de test ajoutés avec succès<br>";
} else {
    echo "ℹ️ Médecins déjà présents ou erreur: " . $conn->error . "<br>";
}

echo "<br><h3>✅ Installation terminée !</h3>";
echo "<p><a href='index.php' style='padding: 10px 20px; background: #28a745; color: white; text-decoration: none; border-radius: 5px;'>Accéder au site</a></p>";

$conn->close();
?>