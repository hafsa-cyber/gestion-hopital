# 📊 Documentation - Système de Gestion Hospitalière

## 1. MCD (Modèle Conceptuel de Données)

```
┌─────────────────┐
│    PATIENT      │
├─────────────────┤
│ idpatient (PK)  │
│ nom             │
│ prenom          │
│ age             │
│ date_naissance  │
│ adresse         │
│ telephone       │
│ email           │
│ sexe            │
│ groupe_sanguin  │
│ date_inscription│
└─────────────────┘
         │
         │ 1,n
         │
         │ PRENDRE
         │
         │ 0,n
         ▼
┌─────────────────┐
│  RENDEZ_VOUS    │
├─────────────────┤
│ idrendezvous(PK)│
│ date_rdv        │
│ heure_rdv       │
│ motif           │
│ statut          │
│ notes           │
│ date_creation   │
└─────────────────┘
         │
         │ 0,n
         │
         │ CONSULTER
         │
         │ 1,1
         ▼
┌─────────────────┐
│    MEDECIN      │
├─────────────────┤
│ idmedecin (PK)  │
│ nom             │
│ prenom          │
│ specialite      │
│ telephone       │
│ email           │
│ adresse         │
│ numero_licence  │
│ date_embauche   │
│ statut          │
│ tarif_consult   │
│ date_creation   │
└─────────────────┘
         │
         │ 1,n
         │
         │ ETABLIR
         │
         │ 0,n
         ▼
┌─────────────────┐
│    FACTURE      │
├─────────────────┤
│ idfacture (PK)  │
│ numero_facture  │
│ date_facture    │
│ montant_total   │
│ montant_paye    │
│ statut_paiement │
│ mode_paiement   │
│ description     │
│ date_creation   │
└─────────────────┘
         │
         │ 1,1
         │
         │ CONCERNER
         │
         │ 0,n
         ▼
┌─────────────────┐
│    PATIENT      │
└─────────────────┘
```

### Relations :
- **PATIENT** (1,n) ──PRENDRE──> (0,n) **RENDEZ_VOUS**
- **MEDECIN** (1,1) ──CONSULTER──> (0,n) **RENDEZ_VOUS**
- **PATIENT** (1,1) ──CONCERNER──> (0,n) **FACTURE**
- **MEDECIN** (1,n) ──ETABLIR──> (0,n) **FACTURE**
- **RENDEZ_VOUS** (0,1) ──GENERER──> (0,1) **FACTURE**

---

## 2. MLD (Modèle Logique de Données)

```sql
PATIENTS (
    idpatient INT PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(100) NOT NULL,
    prenom VARCHAR(100) NOT NULL,
    age INT,
    date_naissance DATE,
    adress VARCHAR(255),
    telephone VARCHAR(20),
    email VARCHAR(100),
    sexe ENUM('M', 'F', 'Autre'),
    groupe_sanguin VARCHAR(5),
    date_inscription TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)

MEDECINS (
    idmedecin INT PRIMARY KEY AUTO_INCREMENT,
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
)

RENDEZ_VOUS (
    idrendezvous INT PRIMARY KEY AUTO_INCREMENT,
    #idpatient INT NOT NULL,
    #idmedecin INT NOT NULL,
    date_rdv DATE NOT NULL,
    heure_rdv TIME NOT NULL,
    motif TEXT,
    statut ENUM('Programmé', 'Confirmé', 'Terminé', 'Annulé') DEFAULT 'Programmé',
    notes TEXT,
    date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (idpatient) REFERENCES PATIENTS(idpatient) ON DELETE CASCADE,
    FOREIGN KEY (idmedecin) REFERENCES MEDECINS(idmedecin) ON DELETE CASCADE
)

FACTURES (
    idfacture INT PRIMARY KEY AUTO_INCREMENT,
    #idpatient INT NOT NULL,
    #idmedecin INT,
    #idrendezvous INT,
    numero_facture VARCHAR(50) UNIQUE NOT NULL,
    date_facture DATE NOT NULL,
    montant_total DECIMAL(10,2) NOT NULL,
    montant_paye DECIMAL(10,2) DEFAULT 0.00,
    statut_paiement ENUM('Non payé', 'Partiellement payé', 'Payé') DEFAULT 'Non payé',
    mode_paiement ENUM('Espèces', 'Carte bancaire', 'Chèque', 'Virement', 'Assurance'),
    description TEXT,
    date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (idpatient) REFERENCES PATIENTS(idpatient) ON DELETE CASCADE,
    FOREIGN KEY (idmedecin) REFERENCES MEDECINS(idmedecin) ON DELETE SET NULL,
    FOREIGN KEY (idrendezvous) REFERENCES RENDEZ_VOUS(idrendezvous) ON DELETE SET NULL
)
```

### Légende :
- **PK** = Clé Primaire (Primary Key)
- **#** = Clé Étrangère (Foreign Key)
- **UNIQUE** = Valeur unique dans la table
- **NOT NULL** = Champ obligatoire

---

## 3. Diagramme de Cas d'Utilisation

```
                    ┌─────────────────────────────────────────────┐
                    │   Système de Gestion Hospitalière           │
                    │                                             │
                    │                                             │
┌──────────┐        │  ┌──────────────────────────────────┐      │
│          │        │  │   GESTION DES PATIENTS           │      │
│          │───────────│  - Ajouter un patient            │      │
│          │        │  │  - Consulter liste patients      │      │
│          │        │  │  - Modifier un patient           │      │
│          │        │  │  - Supprimer un patient          │      │
│          │        │  └──────────────────────────────────┘      │
│          │        │                                             │
│          │        │  ┌──────────────────────────────────┐      │
│          │        │  │   GESTION DES MÉDECINS           │      │
│ SECRÉTAIRE│───────────│  - Ajouter un médecin            │      │
│    /     │        │  │  - Consulter liste médecins      │      │
│ ADMIN    │        │  │  - Modifier un médecin           │      │
│          │        │  │  - Supprimer un médecin          │      │
│          │        │  └──────────────────────────────────┘      │
│          │        │                                             │
│          │        │  ┌──────────────────────────────────┐      │
│          │        │  │   GESTION DES RENDEZ-VOUS        │      │
│          │───────────│  - Prendre un rendez-vous        │      │
│          │        │  │  - Consulter les rendez-vous     │      │
│          │        │  │  - Modifier un rendez-vous       │      │
│          │        │  │  - Annuler un rendez-vous        │      │
│          │        │  │  - Confirmer un rendez-vous      │      │
└──────────┘        │  └──────────────────────────────────┘      │
                    │                                             │
                    │  ┌──────────────────────────────────┐      │
┌──────────┐        │  │   GESTION DE LA FACTURATION      │      │
│          │        │  │  - Créer une facture             │      │
│ COMPTABLE│───────────│  - Consulter les factures        │      │
│          │        │  │  - Modifier une facture          │      │
│          │        │  │  - Enregistrer un paiement       │      │
│          │        │  │  - Imprimer une facture          │      │
└──────────┘        │  └──────────────────────────────────┘      │
                    │                                             │
                    │  ┌──────────────────────────────────┐      │
┌──────────┐        │  │   CONSULTATION & RAPPORTS        │      │
│          │        │  │  - Voir tableau de bord          │      │
│ DIRECTEUR│───────────│  - Consulter statistiques        │      │
│          │        │  │  - Exporter base de données      │      │
│          │        │  │  - Générer rapports              │      │
└──────────┘        │  └──────────────────────────────────┘      │
                    │                                             │
                    └─────────────────────────────────────────────┘
```

### Acteurs du système :

1. **SECRÉTAIRE / ADMIN**
   - Gère les patients (CRUD)
   - Gère les médecins (CRUD)
   - Gère les rendez-vous (CRUD)
   - Accès complet au système

2. **COMPTABLE**
   - Gère la facturation
   - Enregistre les paiements
   - Génère et imprime les factures
   - Consulte l'état des paiements

3. **DIRECTEUR**
   - Consulte les statistiques
   - Visualise le tableau de bord
   - Exporte les données
   - Génère des rapports

---

## 4. Cas d'Utilisation Détaillés

### CU1 : Ajouter un Patient
**Acteur principal :** Secrétaire  
**Préconditions :** Système accessible  
**Scénario nominal :**
1. La secrétaire accède au formulaire d'ajout
2. Elle saisit les informations du patient (nom, prénom, âge, etc.)
3. Elle valide le formulaire
4. Le système enregistre le patient
5. Le système affiche un message de confirmation

### CU2 : Prendre un Rendez-vous
**Acteur principal :** Secrétaire  
**Préconditions :** Patient et médecin existent dans le système  
**Scénario nominal :**
1. La secrétaire accède au formulaire de rendez-vous
2. Elle sélectionne le patient
3. Elle sélectionne le médecin et la spécialité
4. Elle choisit la date et l'heure
5. Elle saisit le motif de consultation
6. Elle valide le rendez-vous
7. Le système enregistre le rendez-vous
8. Le système affiche une confirmation

### CU3 : Créer une Facture
**Acteur principal :** Comptable  
**Préconditions :** Patient existe, rendez-vous terminé (optionnel)  
**Scénario nominal :**
1. Le comptable accède au formulaire de facturation
2. Il sélectionne le patient
3. Il sélectionne le médecin
4. Il peut associer un rendez-vous
5. Il saisit le montant et la description
6. Il valide la facture
7. Le système génère un numéro de facture unique
8. Le système enregistre la facture

### CU4 : Enregistrer un Paiement
**Acteur principal :** Comptable  
**Préconditions :** Facture existe  
**Scénario nominal :**
1. Le comptable consulte la liste des factures
2. Il sélectionne une facture impayée
3. Il saisit le montant payé
4. Il sélectionne le mode de paiement
5. Le système met à jour le statut de paiement
6. Le système calcule le reste à payer

### CU5 : Consulter le Tableau de Bord
**Acteur principal :** Directeur  
**Préconditions :** Système accessible  
**Scénario nominal :**
1. Le directeur accède à la page d'accueil
2. Le système affiche les statistiques :
   - Nombre de patients
   - Nombre de médecins actifs
   - Nombre de rendez-vous
   - Nombre de factures impayées
3. Le système affiche les derniers rendez-vous
4. Le directeur peut accéder aux détails

---

## 5. Règles de Gestion

### RG1 : Patients
- Un patient doit avoir au minimum un nom, prénom et téléphone
- L'âge et la date de naissance doivent être cohérents
- Un patient peut avoir plusieurs rendez-vous
- Un patient peut avoir plusieurs factures

### RG2 : Médecins
- Un médecin doit avoir une spécialité
- Le numéro de licence doit être unique
- Un médecin peut avoir plusieurs rendez-vous
- Un médecin peut établir plusieurs factures
- Seuls les médecins actifs peuvent recevoir de nouveaux rendez-vous

### RG3 : Rendez-vous
- Un rendez-vous concerne un seul patient et un seul médecin
- La date du rendez-vous doit être future ou présente
- Un rendez-vous peut avoir les statuts : Programmé, Confirmé, Terminé, Annulé
- Un rendez-vous terminé peut générer une facture

### RG4 : Factures
- Chaque facture a un numéro unique généré automatiquement
- Une facture concerne un seul patient
- Le montant payé ne peut pas dépasser le montant total
- Le statut de paiement est calculé automatiquement :
  - "Non payé" si montant_paye = 0
  - "Partiellement payé" si 0 < montant_paye < montant_total
  - "Payé" si montant_paye = montant_total
- Une facture peut être associée à un rendez-vous (optionnel)

### RG5 : Sécurité
- Toutes les données sensibles doivent être protégées
- Les suppressions de patients/médecins entraînent la suppression en cascade des rendez-vous associés
- Les factures conservent les informations même si le médecin est supprimé (SET NULL)

---

## 6. Contraintes d'Intégrité

### Contraintes de domaine :
- `statut` médecin : {'Actif', 'Inactif', 'En congé'}
- `statut` rendez-vous : {'Programmé', 'Confirmé', 'Terminé', 'Annulé'}
- `statut_paiement` : {'Non payé', 'Partiellement payé', 'Payé'}
- `sexe` : {'M', 'F', 'Autre'}
- `tarif_consultation` >= 0
- `montant_total` >= 0
- `montant_paye` >= 0

### Contraintes référentielles :
- `rendez_vous.idpatient` → `patients.idpatient` (CASCADE)
- `rendez_vous.idmedecin` → `medecins.idmedecin` (CASCADE)
- `factures.idpatient` → `patients.idpatient` (CASCADE)
- `factures.idmedecin` → `medecins.idmedecin` (SET NULL)
- `factures.idrendezvous` → `rendez_vous.idrendezvous` (SET NULL)

### Contraintes d'unicité :
- `medecins.numero_licence` UNIQUE
- `factures.numero_facture` UNIQUE

---

**Date de création :** 2025-10-08  
**Auteur :** Hafsa Allali  
**Projet :** Système de Gestion Hospitalière - MediCare Plus
