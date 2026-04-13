-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3307
-- Généré le : lun. 10 nov. 2025 à 17:10
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `hopital`
--

-- --------------------------------------------------------

--
-- Structure de la table `factures`
--

CREATE TABLE `factures` (
  `idfacture` int(11) NOT NULL,
  `idpatient` int(11) NOT NULL,
  `idmedecin` int(11) DEFAULT NULL,
  `idrendezvous` int(11) DEFAULT NULL,
  `numero_facture` varchar(50) NOT NULL,
  `date_facture` date NOT NULL,
  `montant_total` decimal(10,2) NOT NULL,
  `montant_paye` decimal(10,2) DEFAULT 0.00,
  `statut_paiement` enum('Non payé','Partiellement payé','Payé') DEFAULT 'Non payé',
  `mode_paiement` enum('Espèces','Carte bancaire','Chèque','Virement','Assurance') DEFAULT NULL,
  `description` text DEFAULT NULL,
  `date_creation` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `factures`
--

INSERT INTO `factures` (`idfacture`, `idpatient`, `idmedecin`, `idrendezvous`, `numero_facture`, `date_facture`, `montant_total`, `montant_paye`, `statut_paiement`, `mode_paiement`, `description`, `date_creation`) VALUES
(2, 1, NULL, NULL, 'FACT-20251110-6755', '2025-11-10', 550.00, 400.00, 'Partiellement payé', 'Espèces', 'Examen médicale', '2025-11-10 15:25:51');

-- --------------------------------------------------------

--
-- Structure de la table `medecins`
--

CREATE TABLE `medecins` (
  `idmedecin` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `prenom` varchar(100) NOT NULL,
  `specialite` varchar(100) NOT NULL,
  `telephone` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `adresse` varchar(255) DEFAULT NULL,
  `numero_licence` varchar(50) DEFAULT NULL,
  `date_embauche` date DEFAULT NULL,
  `statut` enum('Actif','Inactif','En congé') DEFAULT 'Actif',
  `tarif_consultation` decimal(10,2) DEFAULT 0.00,
  `date_creation` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `medecins`
--

INSERT INTO `medecins` (`idmedecin`, `nom`, `prenom`, `specialite`, `telephone`, `email`, `adresse`, `numero_licence`, `date_embauche`, `statut`, `tarif_consultation`, `date_creation`) VALUES
(35, 'El Amrani', 'Fatima', 'Cardiologie', '0612345678', 'f.elamrani@hopital.ma', NULL, 'MED001', '2020-01-15', 'Actif', 500.00, '2025-11-10 16:08:47'),
(36, 'Benjelloun', 'Mohammed', 'Pédiatrie', '0623456789', 'm.benjelloun@hopital.ma', NULL, 'MED002', '2019-06-20', 'Actif', 400.00, '2025-11-10 16:08:47'),
(37, 'Alaoui', 'Khadija', 'Dermatologie', '0634567890', 'k.alaoui@hopital.ma', NULL, 'MED003', '2021-03-10', 'Actif', 450.00, '2025-11-10 16:08:47'),
(38, 'Tazi', 'Youssef', 'Chirurgie', '0645678901', 'y.tazi@hopital.ma', NULL, 'MED004', '2018-09-05', 'Actif', 800.00, '2025-11-10 16:08:47'),
(39, 'Idrissi', 'Amina', 'Médecine générale', '0656789012', 'a.idrissi@hopital.ma', NULL, 'MED005', '2022-01-12', 'Actif', 300.00, '2025-11-10 16:08:47'),
(40, 'Bennis', 'Hassan', 'Ophtalmologie', '0667890123', 'h.bennis@hopital.ma', NULL, 'MED006', '2021-08-20', 'Actif', 350.00, '2025-11-10 16:08:47'),
(41, 'Chraibi', 'Salma', 'Gynécologie', '0678901234', 's.chraibi@hopital.ma', NULL, 'MED007', '2020-05-15', 'Actif', 450.00, '2025-11-10 16:08:47'),
(42, 'Fassi', 'Omar', 'Radiologie', '0689012345', 'o.fassi@hopital.ma', NULL, 'MED008', '2019-11-10', 'Actif', 550.00, '2025-11-10 16:08:47'),
(43, 'Lahlou', 'Zineb', 'Psychiatrie', '0690123456', 'z.lahlou@hopital.ma', NULL, 'MED009', '2020-09-25', 'Actif', 400.00, '2025-11-10 16:08:47'),
(44, 'Berrada', 'Karim', 'Neurologie', '0601234567', 'k.berrada@hopital.ma', NULL, 'MED010', '2018-03-18', 'Actif', 600.00, '2025-11-10 16:08:47');

-- --------------------------------------------------------

--
-- Structure de la table `patients`
--

CREATE TABLE `patients` (
  `idpatient` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `prenom` varchar(100) NOT NULL,
  `age` int(11) DEFAULT NULL,
  `adresse` varchar(255) DEFAULT NULL,
  `telephone` varchar(20) DEFAULT NULL,
  `date_creation` timestamp NOT NULL DEFAULT current_timestamp(),
  `date_naissance` date DEFAULT NULL,
  `adress` varchar(255) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `sexe` enum('M','F','Autre') DEFAULT NULL,
  `groupe_sanguin` enum('A+','A-','B+','B-','AB+','AB-','O+','O-') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `patients`
--

INSERT INTO `patients` (`idpatient`, `nom`, `prenom`, `age`, `adresse`, `telephone`, `date_creation`, `date_naissance`, `adress`, `email`, `sexe`, `groupe_sanguin`) VALUES
(1, 'hafsa', 'allali', 19, NULL, '0661666721', '2025-11-10 15:22:16', '2007-09-01', '10mars,casablanca,20071', 'allalihafsa@gmail.com', 'F', 'A+');

-- --------------------------------------------------------

--
-- Structure de la table `rendez_vous`
--

CREATE TABLE `rendez_vous` (
  `idrendezvous` int(11) NOT NULL,
  `idpatient` int(11) NOT NULL,
  `idmedecin` int(11) NOT NULL,
  `date_rdv` date NOT NULL,
  `heure_rdv` time NOT NULL,
  `motif` text DEFAULT NULL,
  `statut` enum('Programmé','Confirmé','Terminé','Annulé') DEFAULT 'Programmé',
  `notes` text DEFAULT NULL,
  `date_creation` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `factures`
--
ALTER TABLE `factures`
  ADD PRIMARY KEY (`idfacture`),
  ADD UNIQUE KEY `numero_facture` (`numero_facture`),
  ADD KEY `idpatient` (`idpatient`),
  ADD KEY `idmedecin` (`idmedecin`),
  ADD KEY `idrendezvous` (`idrendezvous`);

--
-- Index pour la table `medecins`
--
ALTER TABLE `medecins`
  ADD PRIMARY KEY (`idmedecin`),
  ADD UNIQUE KEY `numero_licence` (`numero_licence`);

--
-- Index pour la table `patients`
--
ALTER TABLE `patients`
  ADD PRIMARY KEY (`idpatient`);

--
-- Index pour la table `rendez_vous`
--
ALTER TABLE `rendez_vous`
  ADD PRIMARY KEY (`idrendezvous`),
  ADD KEY `idpatient` (`idpatient`),
  ADD KEY `idmedecin` (`idmedecin`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `factures`
--
ALTER TABLE `factures`
  MODIFY `idfacture` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `medecins`
--
ALTER TABLE `medecins`
  MODIFY `idmedecin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT pour la table `patients`
--
ALTER TABLE `patients`
  MODIFY `idpatient` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `rendez_vous`
--
ALTER TABLE `rendez_vous`
  MODIFY `idrendezvous` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `factures`
--
ALTER TABLE `factures`
  ADD CONSTRAINT `factures_ibfk_1` FOREIGN KEY (`idpatient`) REFERENCES `patients` (`idpatient`) ON DELETE CASCADE,
  ADD CONSTRAINT `factures_ibfk_2` FOREIGN KEY (`idmedecin`) REFERENCES `medecins` (`idmedecin`) ON DELETE SET NULL,
  ADD CONSTRAINT `factures_ibfk_3` FOREIGN KEY (`idrendezvous`) REFERENCES `rendez_vous` (`idrendezvous`) ON DELETE SET NULL;

--
-- Contraintes pour la table `rendez_vous`
--
ALTER TABLE `rendez_vous`
  ADD CONSTRAINT `rendez_vous_ibfk_1` FOREIGN KEY (`idpatient`) REFERENCES `patients` (`idpatient`) ON DELETE CASCADE,
  ADD CONSTRAINT `rendez_vous_ibfk_2` FOREIGN KEY (`idmedecin`) REFERENCES `medecins` (`idmedecin`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
