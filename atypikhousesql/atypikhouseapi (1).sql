-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mar. 16 nov. 2021 à 23:03
-- Version du serveur :  10.4.14-MariaDB
-- Version de PHP : 7.4.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `atypikhouseapi`
--

-- --------------------------------------------------------

--
-- Structure de la table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `picture` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `categories`
--

INSERT INTO `categories` (`id`, `title`, `picture`, `created_at`, `updated_at`) VALUES
(1, 'categorie 1', 'blabla', '2021-10-30 23:30:23', '2021-10-30 23:30:23'),
(2, 'categorie 2', 'blabla', '2021-10-30 23:39:01', '2021-10-30 23:39:01');

-- --------------------------------------------------------

--
-- Structure de la table `categories_attributes`
--

CREATE TABLE `categories_attributes` (
  `id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `categories_categories_attributes`
--

CREATE TABLE `categories_categories_attributes` (
  `categories_id` int(11) NOT NULL,
  `categories_attributes_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `body` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` int(11) NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `userpicture` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `propertypicture` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `comments`
--

INSERT INTO `comments` (`id`, `body`, `value`, `username`, `userpicture`, `propertypicture`, `created_at`, `updated_at`) VALUES
(1, 'Tout y était et nous avons passé un agréable séjour', 5, 'seraphinp', 'blabla', 'blabla', '2021-11-14 23:36:56', '2021-11-14 23:36:56'),
(2, 'Séjour magnifique, je le recommande fortement', 4, 'joycem', 'blabla', 'blabla', '2021-11-14 23:42:20', '2021-11-14 23:42:20'),
(3, 'Pas la hauteur de nos attentes', 2, 'steevenm', 'blabla', 'blabla', '2021-11-14 23:50:32', '2021-11-14 23:50:32'),
(4, 'Je déconseille fortement ce logement', 1, 'loict', 'blabla', 'blabla', '2021-11-16 23:00:10', '2021-11-16 23:00:10');

-- --------------------------------------------------------

--
-- Structure de la table `conversations`
--

CREATE TABLE `conversations` (
  `id` int(11) NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `doctrine_migration_versions`
--

CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20211028185700', '2021-10-28 20:57:35', 366),
('DoctrineMigrations\\Version20211028192705', '2021-10-28 21:27:29', 329),
('DoctrineMigrations\\Version20211028193552', '2021-10-28 21:36:01', 1371),
('DoctrineMigrations\\Version20211028193957', '2021-10-28 21:40:04', 478),
('DoctrineMigrations\\Version20211028194156', '2021-10-28 21:42:04', 345),
('DoctrineMigrations\\Version20211028194329', '2021-10-28 21:43:37', 292),
('DoctrineMigrations\\Version20211028194900', '2021-10-28 21:49:10', 263),
('DoctrineMigrations\\Version20211028195024', '2021-10-28 21:50:31', 381),
('DoctrineMigrations\\Version20211028195205', '2021-10-28 21:52:12', 346),
('DoctrineMigrations\\Version20211028195929', '2021-10-28 21:59:37', 290),
('DoctrineMigrations\\Version20211030210656', '2021-10-30 23:07:18', 1033),
('DoctrineMigrations\\Version20211030210942', '2021-10-30 23:09:50', 316),
('DoctrineMigrations\\Version20211030213348', '2021-10-30 23:34:24', 4009),
('DoctrineMigrations\\Version20211030214337', '2021-10-30 23:43:46', 1722),
('DoctrineMigrations\\Version20211030214732', '2021-10-30 23:47:39', 3400),
('DoctrineMigrations\\Version20211030215250', '2021-10-30 23:53:08', 4730),
('DoctrineMigrations\\Version20211030215619', '2021-10-30 23:56:27', 1753),
('DoctrineMigrations\\Version20211030220218', '2021-10-31 00:02:28', 1671),
('DoctrineMigrations\\Version20211030220635', '2021-10-31 00:06:42', 1930),
('DoctrineMigrations\\Version20211030221020', '2021-10-31 00:10:30', 2220),
('DoctrineMigrations\\Version20211030221819', '2021-10-31 00:18:26', 1644),
('DoctrineMigrations\\Version20211030232121', '2021-10-31 01:21:29', 256),
('DoctrineMigrations\\Version20211030232510', '2021-10-31 01:25:17', 3430),
('DoctrineMigrations\\Version20211030235245', '2021-10-31 01:52:51', 155);

-- --------------------------------------------------------

--
-- Structure de la table `equipements`
--

CREATE TABLE `equipements` (
  `id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `body` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `conversations_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `payments`
--

CREATE TABLE `payments` (
  `id` int(11) NOT NULL,
  `amount` double NOT NULL,
  `is_paidback` tinyint(1) NOT NULL,
  `paidback_state` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `properties`
--

CREATE TABLE `properties` (
  `id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` double NOT NULL,
  `rooms` int(11) NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `booking` int(11) NOT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lat` decimal(8,5) NOT NULL,
  `longitude` decimal(8,5) NOT NULL,
  `bedrooms` int(11) NOT NULL,
  `surface` decimal(6,3) NOT NULL,
  `reference` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `picture` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `country` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `capacity` int(11) NOT NULL,
  `zip_code` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `categories_id` int(11) DEFAULT NULL,
  `propertiesgallery_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `properties`
--

INSERT INTO `properties` (`id`, `title`, `slug`, `price`, `rooms`, `address`, `booking`, `city`, `lat`, `longitude`, `bedrooms`, `surface`, `reference`, `picture`, `country`, `capacity`, `zip_code`, `created_at`, `updated_at`, `categories_id`, `propertiesgallery_id`) VALUES
(1, 'string', 'string', 0, 0, 'string', 0, 'string', '0.00000', '0.00000', 0, '0.000', 'string', 'string', 'string', 0, 0, '2021-11-02 18:52:06', '2021-11-02 18:52:06', 1, NULL),
(2, 'mon premier bien', 'mon-premier-bien', 0, 0, 'string', 0, 'string', '0.00000', '0.00000', 0, '0.000', 'string', 'string', 'string', 0, 0, '2021-11-04 17:47:25', '2021-11-04 17:47:25', 1, NULL),
(3, 'mon deuxième bien', 'mon-deuxième-bien', 0, 0, 'string', 0, 'string', '0.00000', '0.00000', 0, '0.000', 'string', 'string', 'string', 0, 0, '2021-11-04 17:47:25', '2021-11-04 17:47:25', NULL, NULL),
(4, 'blabla', 'blabla', 10.5, 5, 'blabla', 0, 'blabla', '105.10000', '55.20000', 3, '50.000', 'hhhhh', 'blabla', 'france', 6, 75010, '2021-11-14 22:25:25', '2021-11-14 22:25:25', NULL, NULL),
(5, 'mon quatrième bien', 'mon-quatrième-bien', 10.5, 5, 'blabla', 0, 'blabla', '105.10000', '55.20000', 3, '50.000', 'hhhhh', 'blabla', 'france', 6, 75010, '2021-11-14 23:32:20', '2021-11-14 23:32:20', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `properties_equipements`
--

CREATE TABLE `properties_equipements` (
  `properties_id` int(11) NOT NULL,
  `equipements_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `properties_gallery`
--

CREATE TABLE `properties_gallery` (
  `id` int(11) NOT NULL,
  `picture` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alt` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `reports`
--

CREATE TABLE `reports` (
  `id` int(11) NOT NULL,
  `report_state` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `reportscategories_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `reports_categories`
--

CREATE TABLE `reports_categories` (
  `id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `reservations`
--

CREATE TABLE `reservations` (
  `id` int(11) NOT NULL,
  `startdate` date NOT NULL,
  `end_date` date NOT NULL,
  `is_approuved` tinyint(1) NOT NULL,
  `is_cancelled` tinyint(1) NOT NULL,
  `is_paid` tinyint(1) NOT NULL,
  `participants_nbr` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `payments_id` int(11) DEFAULT NULL,
  `properties_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `reservations`
--

INSERT INTO `reservations` (`id`, `startdate`, `end_date`, `is_approuved`, `is_cancelled`, `is_paid`, `participants_nbr`, `created_at`, `updated_at`, `payments_id`, `properties_id`) VALUES
(1, '2021-11-15', '2021-11-17', 0, 0, 0, 4, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, 2),
(2, '2021-11-15', '2021-11-17', 0, 0, 0, 4, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, 3),
(3, '2021-11-14', '2021-11-14', 1, 0, 1, 4, '2021-11-14 19:53:00', '2021-11-14 19:53:00', NULL, NULL),
(4, '2021-11-14', '2021-11-14', 1, 1, 1, 0, '2021-11-14 22:15:20', '2021-11-14 22:15:20', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `reservations_comments`
--

CREATE TABLE `reservations_comments` (
  `reservations_id` int(11) NOT NULL,
  `comments_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `reservations_comments`
--

INSERT INTO `reservations_comments` (`reservations_id`, `comments_id`) VALUES
(1, 1),
(1, 2),
(2, 3);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `categories_attributes`
--
ALTER TABLE `categories_attributes`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `categories_categories_attributes`
--
ALTER TABLE `categories_categories_attributes`
  ADD PRIMARY KEY (`categories_id`,`categories_attributes_id`),
  ADD KEY `IDX_7C1C0452A21214B7` (`categories_id`),
  ADD KEY `IDX_7C1C04524EC5F032` (`categories_attributes_id`);

--
-- Index pour la table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `conversations`
--
ALTER TABLE `conversations`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `doctrine_migration_versions`
--
ALTER TABLE `doctrine_migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Index pour la table `equipements`
--
ALTER TABLE `equipements`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_DB021E96FE142757` (`conversations_id`);

--
-- Index pour la table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `properties`
--
ALTER TABLE `properties`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_87C331C7A21214B7` (`categories_id`),
  ADD KEY `IDX_87C331C71E56FA6E` (`propertiesgallery_id`);

--
-- Index pour la table `properties_equipements`
--
ALTER TABLE `properties_equipements`
  ADD PRIMARY KEY (`properties_id`,`equipements_id`),
  ADD KEY `IDX_3DDB17F23691D1CA` (`properties_id`),
  ADD KEY `IDX_3DDB17F2852CCFF5` (`equipements_id`);

--
-- Index pour la table `properties_gallery`
--
ALTER TABLE `properties_gallery`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_F11FA745CC5EBC32` (`reportscategories_id`);

--
-- Index pour la table `reports_categories`
--
ALTER TABLE `reports_categories`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_4DA239BBC61482` (`payments_id`),
  ADD KEY `IDX_4DA2393691D1CA` (`properties_id`);

--
-- Index pour la table `reservations_comments`
--
ALTER TABLE `reservations_comments`
  ADD PRIMARY KEY (`reservations_id`,`comments_id`),
  ADD KEY `IDX_3E78518BD9A7F869` (`reservations_id`),
  ADD KEY `IDX_3E78518B63379586` (`comments_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `categories_attributes`
--
ALTER TABLE `categories_attributes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `conversations`
--
ALTER TABLE `conversations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `equipements`
--
ALTER TABLE `equipements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `properties`
--
ALTER TABLE `properties`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `properties_gallery`
--
ALTER TABLE `properties_gallery`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `reports`
--
ALTER TABLE `reports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `reports_categories`
--
ALTER TABLE `reports_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `categories_categories_attributes`
--
ALTER TABLE `categories_categories_attributes`
  ADD CONSTRAINT `FK_7C1C04524EC5F032` FOREIGN KEY (`categories_attributes_id`) REFERENCES `categories_attributes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_7C1C0452A21214B7` FOREIGN KEY (`categories_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `FK_DB021E96FE142757` FOREIGN KEY (`conversations_id`) REFERENCES `conversations` (`id`);

--
-- Contraintes pour la table `properties`
--
ALTER TABLE `properties`
  ADD CONSTRAINT `FK_87C331C71E56FA6E` FOREIGN KEY (`propertiesgallery_id`) REFERENCES `properties_gallery` (`id`),
  ADD CONSTRAINT `FK_87C331C7A21214B7` FOREIGN KEY (`categories_id`) REFERENCES `categories` (`id`);

--
-- Contraintes pour la table `properties_equipements`
--
ALTER TABLE `properties_equipements`
  ADD CONSTRAINT `FK_3DDB17F23691D1CA` FOREIGN KEY (`properties_id`) REFERENCES `properties` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_3DDB17F2852CCFF5` FOREIGN KEY (`equipements_id`) REFERENCES `equipements` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `reports`
--
ALTER TABLE `reports`
  ADD CONSTRAINT `FK_F11FA745CC5EBC32` FOREIGN KEY (`reportscategories_id`) REFERENCES `reports_categories` (`id`);

--
-- Contraintes pour la table `reservations`
--
ALTER TABLE `reservations`
  ADD CONSTRAINT `FK_4DA2393691D1CA` FOREIGN KEY (`properties_id`) REFERENCES `properties` (`id`),
  ADD CONSTRAINT `FK_4DA239BBC61482` FOREIGN KEY (`payments_id`) REFERENCES `payments` (`id`);

--
-- Contraintes pour la table `reservations_comments`
--
ALTER TABLE `reservations_comments`
  ADD CONSTRAINT `FK_3E78518B63379586` FOREIGN KEY (`comments_id`) REFERENCES `comments` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_3E78518BD9A7F869` FOREIGN KEY (`reservations_id`) REFERENCES `reservations` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
