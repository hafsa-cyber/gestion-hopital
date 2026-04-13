<?php
include 'includes/config.php';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Structure de la Base de Données - Hôpital</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 20px;
            margin: 0;
        }
        .container {
            max-width: 1400px;
            margin: 0 auto;
        }
        h1 {
            text-align: center;
            color: white;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
            margin-bottom: 30px;
        }
        .table-section {
            background: white;
            border-radius: 15px;
            padding: 25px;
            margin-bottom: 30px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }
        .table-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 3px solid #007bff;
        }
        .table-name {
            font-size: 1.8rem;
            font-weight: bold;
            color: #007bff;
        }
        .table-count {
            background: #007bff;
            color: white;
            padding: 8px 20px;
            border-radius: 20px;
            font-weight: bold;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        th {
            background: linear-gradient(135deg, #007bff, #0056b3);
            color: white;
            padding: 12px;
            text-align: left;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
        }
        td {
            padding: 12px;
            border-bottom: 1px solid #e0e0e0;
        }
        tr:hover {
            background: #f8f9fa;
        }
        .structure-table th {
            background: linear-gradient(135deg, #28a745, #1e7e34);
        }
        .btn-export {
            display: inline-block;
            background: #28a745;
            color: white;
            padding: 15px 30px;
            border-radius: 10px;
            text-decoration: none;
            font-weight: bold;
            margin: 20px 10px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            transition: all 0.3s;
        }
        .btn-export:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(0,0,0,0.2);
        }
        .btn-back {
            background: #6c757d;
        }
        .actions {
            text-align: center;
            margin: 30px 0;
        }
        .stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        .stat-card {
            background: white;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        .stat-number {
            font-size: 2.5rem;
            font-weight: bold;
            color: #007bff;
        }
        .stat-label {
            color: #6c757d;
            font-size: 0.9rem;
            margin-top: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🏥 Base de Données - Système de Gestion Hospitalière</h1>
        
        <?php
        // Statistiques globales
        $stats = [
            'patients' => $conn->query("SELECT COUNT(*) as total FROM patients")->fetch_assoc()['total'],
            'medecins' => $conn->query("SELECT COUNT(*) as total FROM medecins")->fetch_assoc()['total'],
            'rendez_vous' => $conn->query("SELECT COUNT(*) as total FROM rendez_vous")->fetch_assoc()['total'],
            'factures' => $conn->query("SELECT COUNT(*) as total FROM factures")->fetch_assoc()['total']
        ];
        ?>
        
        <div class="stats">
            <div class="stat-card">
                <div class="stat-number"><?php echo $stats['patients']; ?></div>
                <div class="stat-label">👥 Patients</div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?php echo $stats['medecins']; ?></div>
                <div class="stat-label">👨‍⚕️ Médecins</div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?php echo $stats['rendez_vous']; ?></div>
                <div class="stat-label">📅 Rendez-vous</div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?php echo $stats['factures']; ?></div>
                <div class="stat-label">💰 Factures</div>
            </div>
        </div>

        <?php
        $tables = ['patients', 'medecins', 'rendez_vous', 'factures'];
        
        foreach ($tables as $table) {
            echo "<div class='table-section'>";
            
            // En-tête de la table
            $count = $conn->query("SELECT COUNT(*) as total FROM `$table`")->fetch_assoc()['total'];
            echo "<div class='table-header'>";
            echo "<div class='table-name'>📊 Table: $table</div>";
            echo "<div class='table-count'>$count enregistrement(s)</div>";
            echo "</div>";
            
            // Structure de la table
            echo "<h3 style='color: #28a745; margin-top: 20px;'>🔧 Structure</h3>";
            $structure = $conn->query("SHOW COLUMNS FROM `$table`");
            echo "<table class='structure-table'>";
            echo "<tr><th>Colonne</th><th>Type</th><th>Null</th><th>Clé</th><th>Défaut</th><th>Extra</th></tr>";
            while ($col = $structure->fetch_assoc()) {
                echo "<tr>";
                echo "<td><strong>{$col['Field']}</strong></td>";
                echo "<td>{$col['Type']}</td>";
                echo "<td>{$col['Null']}</td>";
                echo "<td>{$col['Key']}</td>";
                echo "<td>" . ($col['Default'] ?? 'NULL') . "</td>";
                echo "<td>{$col['Extra']}</td>";
                echo "</tr>";
            }
            echo "</table>";
            
            // Données de la table
            echo "<h3 style='color: #007bff; margin-top: 30px;'>📋 Données</h3>";
            $data = $conn->query("SELECT * FROM `$table`");
            
            if ($data && $data->num_rows > 0) {
                echo "<table>";
                
                // En-têtes
                $fields = $data->fetch_fields();
                echo "<tr>";
                foreach ($fields as $field) {
                    echo "<th>{$field->name}</th>";
                }
                echo "</tr>";
                
                // Données
                while ($row = $data->fetch_assoc()) {
                    echo "<tr>";
                    foreach ($row as $value) {
                        echo "<td>" . ($value ?? '<em style="color:#999;">NULL</em>') . "</td>";
                    }
                    echo "</tr>";
                }
                echo "</table>";
            } else {
                echo "<p style='text-align: center; color: #999; padding: 20px;'>Aucune donnée dans cette table</p>";
            }
            
            echo "</div>";
        }
        
        $conn->close();
        ?>
        
        <div class="actions">
            <a href="export_database.php" class="btn-export" target="_blank">📥 Télécharger SQL</a>
            <a href="index.php" class="btn-export btn-back">🏠 Retour à l'accueil</a>
        </div>
    </div>
</body>
</html>
