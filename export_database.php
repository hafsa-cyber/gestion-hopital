<?php
// Script pour exporter toute la base de données avec les données
include 'includes/config.php';

header('Content-Type: text/plain; charset=utf-8');

echo "-- ============================================\n";
echo "-- EXPORT COMPLET DE LA BASE DE DONNÉES\n";
echo "-- Base: hopital_db\n";
echo "-- Date: " . date('Y-m-d H:i:s') . "\n";
echo "-- ============================================\n\n";

echo "CREATE DATABASE IF NOT EXISTS hopital_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;\n";
echo "USE hopital_db;\n\n";

// Liste des tables
$tables = ['patients', 'medecins', 'rendez_vous', 'factures'];

foreach ($tables as $table) {
    echo "-- ============================================\n";
    echo "-- Table: $table\n";
    echo "-- ============================================\n\n";
    
    // Supprimer la table si elle existe
    echo "DROP TABLE IF EXISTS `$table`;\n\n";
    
    // Obtenir la structure de la table
    $create_table = $conn->query("SHOW CREATE TABLE `$table`");
    if ($create_table) {
        $row = $create_table->fetch_row();
        echo $row[1] . ";\n\n";
    }
    
    // Obtenir les données
    $result = $conn->query("SELECT * FROM `$table`");
    if ($result && $result->num_rows > 0) {
        echo "-- Données de la table `$table`\n";
        
        // Obtenir les noms des colonnes
        $fields = [];
        $field_info = $result->fetch_fields();
        foreach ($field_info as $field) {
            $fields[] = "`{$field->name}`";
        }
        
        $insert_header = "INSERT INTO `$table` (" . implode(', ', $fields) . ") VALUES\n";
        echo $insert_header;
        
        $first = true;
        while ($row = $result->fetch_assoc()) {
            if (!$first) {
                echo ",\n";
            }
            $first = false;
            
            $values = [];
            foreach ($row as $value) {
                if ($value === null) {
                    $values[] = 'NULL';
                } else {
                    $values[] = "'" . $conn->real_escape_string($value) . "'";
                }
            }
            echo "(" . implode(', ', $values) . ")";
        }
        echo ";\n\n";
    } else {
        echo "-- Aucune donnée dans la table `$table`\n\n";
    }
}

echo "-- ============================================\n";
echo "-- FIN DE L'EXPORT\n";
echo "-- ============================================\n";

$conn->close();
?>
