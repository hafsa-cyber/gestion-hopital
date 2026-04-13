<?php include 'includes/header.php'; ?>
<?php include 'includes/config.php'; ?>

<h2>Tableau de Bord - Gestion Hospitalière</h2>

<div class="dashboard">
    <?php
    
    $nb_patients = $conn->query("SELECT COUNT(*) as total FROM patients")->fetch_assoc()['total'];
    $nb_medecins = $conn->query("SELECT COUNT(*) as total FROM medecins WHERE statut='Actif'")->fetch_assoc()['total'];
    $nb_rdv_total = $conn->query("SELECT COUNT(*) as total FROM rendez_vous")->fetch_assoc()['total'];
    $nb_factures_impayees = $conn->query("SELECT COUNT(*) as total FROM factures WHERE statut_paiement != 'Payé'")->fetch_assoc()['total'];
    ?>

    <div class="stats-grid">
        <div class="stat-card blue">
            <div class="stat-icon"></div>
            <div class="stat-info">
                <h3><?php echo $nb_patients; ?></h3>
                <p>Patients</p>
            </div>
            <a href="patients/afficher_patients.php" class="stat-link">Voir tous →</a>
        </div>

        <div class="stat-card green">
            <div class="stat-icon"></div>
            <div class="stat-info">
                <h3><?php echo $nb_medecins; ?></h3>
                <p>Médecins Actifs</p>
            </div>
            <a href="medecins/afficher_medecins.php" class="stat-link">Voir tous →</a>
        </div>

        <div class="stat-card orange">
            <div class="stat-icon"></div>
            <div class="stat-info">
                <h3><?php echo $nb_rdv_total; ?></h3>
                <p>Rendez-vous</p>
            </div>
            <a href="rendez_vous/afficher_rendez_vous.php" class="stat-link">Voir tous →</a>
        </div>

        <div class="stat-card red">
            <div class="stat-icon"></div>
            <div class="stat-info">
                <h3><?php echo $nb_factures_impayees; ?></h3>
                <p>Factures Impayées</p>
            </div>
            <a href="factures/afficher_factures.php" class="stat-link">Voir toutes →</a>
        </div>
    </div>

    <div class="quick-actions">
        <h3>Actions Rapides</h3>
        <div class="actions-grid">
            <a href="patients/ajouter_patient.php" class="action-btn">
                <span class="action-icon">+</span>
                <span>Nouveau Patient</span>
            </a>
            <a href="medecins/ajouter_medecin.php" class="action-btn">
                <span class="action-icon">+</span>
                <span>Nouveau Médecin</span>
            </a>
            <a href="rendez_vous/ajouter_rendez_vous.php" class="action-btn">
                <span class="action-icon">+</span>
                <span>Nouveau RDV</span>
            </a>
            <a href="factures/ajouter_facture.php" class="action-btn">
                <span class="action-icon">+</span>
                <span>Nouvelle Facture</span>
            </a>
        </div>
    </div>

    <div class="recent-section">
        <h3>Derniers Rendez-vous</h3>
        <?php
        $recent_rdv = $conn->query("SELECT r.*, 
                                    CONCAT(p.nom, ' ', p.prenom) AS patient,
                                    CONCAT(m.nom, ' ', m.prenom) AS medecin,
                                    m.specialite
                                    FROM rendez_vous r
                                    JOIN patients p ON r.idpatient = p.idpatient
                                    JOIN medecins m ON r.idmedecin = m.idmedecin
                                    ORDER BY r.idrendezvous DESC
                                    LIMIT 5");
        
        if($recent_rdv && $recent_rdv->num_rows > 0) {
            echo "<table class='recent-table'>";
            echo "<tr><th>Patient</th><th>Médecin</th><th>Spécialité</th><th>Date</th><th>Heure</th><th>Statut</th></tr>";
            while($rdv = $recent_rdv->fetch_assoc()) {
                $statut_class = str_replace(' ', '-', strtolower($rdv['statut']));
                echo "<tr>
                        <td>{$rdv['patient']}</td>
                        <td>Dr. {$rdv['medecin']}</td>
                        <td>{$rdv['specialite']}</td>
                        <td>{$rdv['date_rdv']}</td>
                        <td>{$rdv['heure_rdv']}</td>
                        <td><span class='badge badge-{$statut_class}'>{$rdv['statut']}</span></td>
                      </tr>";
            }
            echo "</table>";
        } else {
            echo "<div style='text-align: center; padding: 40px; background: white; border-radius: 10px;'>
                    <p style='font-size: 1.2rem; color: #6b7280;'>Aucun rendez-vous pour le moment</p>
                    <a href='rendez_vous/ajouter_rendez_vous.php' class='btn btn-primary' style='margin-top: 15px;'>Ajouter un rendez-vous</a>
                  </div>";
        }
        ?>
    </div>
</div>

<style>
.dashboard {
    padding: 20px 0;
}
.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 20px;
    margin-bottom: 30px;
}
.stat-card {
    background: white;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    display: flex;
    flex-direction: column;
    gap: 10px;
}
.stat-card.blue { border-left: 5px solid #60a5fa; }
.stat-card.green { border-left: 5px solid #28a745; }
.stat-card.orange { border-left: 5px solid #ffc107; }
.stat-card.red { border-left: 5px solid #dc3545; }
.stat-icon {
    font-size: 40px;
}
.stat-info h3 {
    font-size: 36px;
    margin: 0;
    color: #333;
}
.stat-info p {
    margin: 0;
    color: #666;
    font-size: 14px;
}
.stat-link {
    color: #60a5fa;
    text-decoration: none;
    font-weight: bold;
    font-size: 14px;
}
.stat-link:hover {
    text-decoration: underline;
}
.quick-actions {
    background: white;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    margin-bottom: 30px;
}
.quick-actions h3 {
    margin-top: 0;
    color: #333;
}
.actions-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 15px;
}
.action-btn {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 15px;
    background: linear-gradient(135deg, #60a5fa 0%, #93c5fd 100%);
    color: white;
    text-decoration: none;
    border-radius: 8px;
    font-weight: bold;
    transition: transform 0.2s;
}
.action-btn:hover {
    transform: translateY(-3px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.2);
}
.action-icon {
    font-size: 24px;
}
.recent-section {
    background: white;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}
.recent-section h3 {
    margin-top: 0;
    color: #333;
}
.recent-table {
    width: 100%;
    border-collapse: collapse;
}
.recent-table th, .recent-table td {
    padding: 10px;
    text-align: left;
    border-bottom: 1px solid #eee;
}
.recent-table th {
    background: #f8f9fa;
    font-weight: bold;
}
.badge-Programmé { background: #ffc107; color: black; padding: 5px 10px; border-radius: 5px; font-size: 12px; }
.badge-Confirmé { background: #60a5fa; color: white; padding: 5px 10px; border-radius: 5px; font-size: 12px; }
.badge-Terminé { background: #28a745; color: white; padding: 5px 10px; border-radius: 5px; font-size: 12px; }
.badge-Annulé { background: #dc3545; color: white; padding: 5px 10px; border-radius: 5px; font-size: 12px; }
</style>

<?php include 'includes/footer.php'; ?>
