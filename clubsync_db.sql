-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : lun. 28 avr. 2025 à 01:17
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
-- Base de données : `clubsync_db`
--

-- --------------------------------------------------------

--
-- Structure de la table `club`
--

CREATE TABLE `club` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `members` int(11) NOT NULL,
  `president` varchar(255) NOT NULL,
  `foundation` date NOT NULL,
  `status` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `description` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `club`
--

INSERT INTO `club` (`id`, `name`, `members`, `president`, `foundation`, `status`, `image`, `description`) VALUES
(5, 'enactus', 3, 'talel', '2012-02-09', 'Active', '680e4f18af606.png', 'skffkfj'),
(7, 'iEEE', 5, 'yassine', '2025-04-09', 'club', '680e4f18af606.png', 'qnkjndjabzjdbakzjbdkazbdezbajkbed'),
(8, 'iEEE', 5, 'yassine', '2025-04-09', 'club', '680e4f18af606.png', 'qnkjndjabzjdbakzjbdkazbdezbajkbed'),
(9, 'iEEE', 5, 'yassine', '2025-04-09', 'club', '680e4f18af606.png', 'qnkjndjabzjdbakzjbdkazbdezbajkbed'),
(10, 'iEEE', 5, 'yassine', '2025-04-09', 'club', '680e4f18af606.png', 'qnkjndjabzjdbakzjbdkazbdezbajkbed'),
(11, 'iEEE', 5, 'yassine', '2025-04-09', 'club', '680e4f18af606.png', 'qnkjndjabzjdbakzjbdkazbdezbajkbed'),
(12, 'iEEE', 5, 'yassine', '2025-04-09', 'club', '680e4f18af606.png', 'qnkjndjabzjdbakzjbdkazbdezbajkbed'),
(13, 'iEEE', 5, 'yassine', '2025-04-09', 'club', '680e4f18af606.png', 'qnkjndjabzjdbakzjbdkazbdezbajkbed'),
(21, 'IEEE', 5, 'yassine', '2025-04-15', 'Active', '680eb39d8db9f0.54843986.png', 'cdsnsljcnkdsnvlcsq');

-- --------------------------------------------------------

--
-- Structure de la table `doctrine_migration_versions`
--

CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20250409114813', '2025-04-09 13:48:30', 172),
('DoctrineMigrations\\Version20250424102451', '2025-04-24 12:25:09', 67),
('DoctrineMigrations\\Version20250426112247', '2025-04-26 13:44:04', 162),
('DoctrineMigrations\\Version20250427094200', '2025-04-27 11:42:11', 35),
('DoctrineMigrations\\Version20250427152939', '2025-04-27 17:29:47', 48),
('DoctrineMigrations\\Version20250427165833', '2025-04-27 19:00:07', 9),
('DoctrineMigrations\\Version20250427171911', '2025-04-27 19:19:16', 6);

-- --------------------------------------------------------

--
-- Structure de la table `event`
--

CREATE TABLE `event` (
  `id` int(11) NOT NULL,
  `club_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `location` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `start_time` time DEFAULT NULL,
  `end_time` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `event`
--

INSERT INTO `event` (`id`, `club_id`, `name`, `description`, `start_date`, `end_date`, `location`, `status`, `image`, `start_time`, `end_time`) VALUES
(3, 5, 'Hackaton', 'skdsjdmlksmdlj', '2025-03-15', '2025-03-15', 'iset', 'Completed', '680e64c5cf2b23.95898800.png', '10:15:00', '12:00:00'),
(4, 5, 'bhhsqcxb', 'qcs,sqjjcnqs', '2000-06-05', '2025-04-20', 'knljn', 'Upcoming', '680eada583bb97.92890799.jpg', '23:05:00', '05:25:00');

-- --------------------------------------------------------

--
-- Structure de la table `messenger_messages`
--

CREATE TABLE `messenger_messages` (
  `id` bigint(20) NOT NULL,
  `body` longtext NOT NULL,
  `headers` longtext NOT NULL,
  `queue_name` varchar(190) NOT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `available_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `delivered_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `username`, `email`, `password`, `role`) VALUES
(2, 'talel12', 'talelbengharbia213@gmail.com', '$2y$13$cgpSy4YjQk6eD9zy9ucJAOpFVsF3qU9gcm5l3OLsIyjHb0raFMjSK', 'Admin'),
(3, 'aaaa', 'exemple@gmail.com', '$2y$13$4R9jx7b84njccANkjEIE1ezVQJCRJINN9VLs2A5OOZWqexFFqQswO', 'Student'),
(4, 'exemple1', 'exemple1@gmail.com', '$2y$13$0LNmHNv6X5Kjs8KRESCNMu3FquRPubcWJSg8iScLlgmUdhjlKm8fa', 'Student'),
(5, 'abab', 'exemple2@gmail.com', '$2y$13$KEcQMmSYENRiXOzMVYavZeD9JkRnJ3z1RmR7wZ6fSSAGGKM2DUme2', 'Student');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `club`
--
ALTER TABLE `club`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `doctrine_migration_versions`
--
ALTER TABLE `doctrine_migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Index pour la table `event`
--
ALTER TABLE `event`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_3BAE0AA761190A32` (`club_id`);

--
-- Index pour la table `messenger_messages`
--
ALTER TABLE `messenger_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_75EA56E0FB7336F0` (`queue_name`),
  ADD KEY `IDX_75EA56E0E3BD61CE` (`available_at`),
  ADD KEY `IDX_75EA56E016BA31DB` (`delivered_at`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `club`
--
ALTER TABLE `club`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT pour la table `event`
--
ALTER TABLE `event`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `messenger_messages`
--
ALTER TABLE `messenger_messages`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `event`
--
ALTER TABLE `event`
  ADD CONSTRAINT `FK_3BAE0AA761190A32` FOREIGN KEY (`club_id`) REFERENCES `club` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
