-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 08, 2023 at 03:33 AM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gamegalaxy`
--

-- --------------------------------------------------------

--
-- Table structure for table `blog`
--

CREATE TABLE `blog` (
  `id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `likes` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `blog`
--

INSERT INTO `blog` (`id`, `title`, `content`, `image`, `created_at`, `updated_at`, `likes`) VALUES
(1, 'Gaming', 'Blog gaminggg', 'blogs/blog1.jpg', '2023-03-09 05:38:45', '2023-03-09 05:38:45', 2),
(2, 'Gaming22222', 'Blog gaminggggg', 'blogs/blog2.jpg', '2023-03-09 14:10:29', '2023-03-09 14:10:28', 1);

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `titre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `session` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prix` double NOT NULL,
  `quantite` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `titre`, `session`, `prix`, `quantite`) VALUES
(5, 'Visitor Cart #usdsh3t2qpk1mp0f5cbsaa3sak', 'usdsh3t2qpk1mp0f5cbsaa3sak', 11, 2),
(6, 'Visitor Cart #v3tcf2tp9e2dt07l3lqer05oo0', 'v3tcf2tp9e2dt07l3lqer05oo0', 1, 1),
(7, 'Visitor Cart #avjuqgaf4at2jjmi1kbd587ceq', 'avjuqgaf4at2jjmi1kbd587ceq', 11, 2);

-- --------------------------------------------------------

--
-- Table structure for table `cart_produit`
--

CREATE TABLE `cart_produit` (
  `cart_id` int(11) NOT NULL,
  `produit_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cart_produit`
--

INSERT INTO `cart_produit` (`cart_id`, `produit_id`) VALUES
(5, 1),
(5, 2),
(5, 3),
(6, 2),
(7, 1),
(7, 2);

-- --------------------------------------------------------

--
-- Table structure for table `categorie`
--

CREATE TABLE `categorie` (
  `id` int(11) NOT NULL,
  `nom_categorie` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `etat` int(11) NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categorie`
--

INSERT INTO `categorie` (`id`, `nom_categorie`, `etat`, `type`) VALUES
(1, 'jeux', 1, '+5ans'),
(2, 'Skins', 1, '+5ans');

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

CREATE TABLE `comment` (
  `id` int(11) NOT NULL,
  `bbid_id` int(11) DEFAULT NULL,
  `iduscomm_id` int(11) NOT NULL,
  `content` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `doctrine_migration_versions`
--

CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20230308231940', '2023-03-09 00:19:44', 1232),
('DoctrineMigrations\\Version20230309043249', '2023-03-09 05:32:55', 247);

-- --------------------------------------------------------

--
-- Table structure for table `evenement`
--

CREATE TABLE `evenement` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` datetime DEFAULT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `duree` int(11) DEFAULT NULL,
  `capacite` int(11) DEFAULT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `evenement`
--

INSERT INTO `evenement` (`id`, `nom`, `date`, `description`, `duree`, `capacite`, `type`, `image`) VALUES
(5, 'Streamer Tournament', '2023-04-26 00:00:00', '\"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor', 30, 499, 'Tournament', 'evenements/streamers.jpg'),
(7, 'Lorem Ipsum', '2023-04-21 18:35:00', '\"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor ', 30, 499, 'Social', 'evenements/704231-2595167854079-701032544-o-643ad2627aa92.jpg'),
(12, 'aaaaaaaaa', '2023-05-17 19:37:00', 'eeeeeeeee', 3, 3, 'efef', 'evenements/mvp-logo-2-6457e1eb7f294.png');

-- --------------------------------------------------------

--
-- Table structure for table `item`
--

CREATE TABLE `item` (
  `id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `commande_id` int(11) DEFAULT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `item`
--

INSERT INTO `item` (`id`, `product_id`, `commande_id`, `quantity`) VALUES
(1, 1, 1, 1),
(2, 2, 2, 1),
(3, 1, 3, 1),
(4, 2, 3, 1),
(5, 2, 4, 1),
(6, 3, 5, 2),
(7, 1, 6, 1),
(8, 1, 7, 1),
(9, 2, 7, 1),
(10, 1, 9, 1),
(11, 2, 9, 1);

-- --------------------------------------------------------

--
-- Table structure for table `membre`
--

CREATE TABLE `membre` (
  `id` int(11) NOT NULL,
  `pseudo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `niveau_compte` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `messenger_messages`
--

CREATE TABLE `messenger_messages` (
  `id` bigint(20) NOT NULL,
  `body` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `headers` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue_name` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `available_at` datetime NOT NULL,
  `delivered_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order`
--

CREATE TABLE `order` (
  `id` int(11) NOT NULL,
  `payment_id` int(11) DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order`
--

INSERT INTO `order` (`id`, `payment_id`, `status`, `total`) VALUES
(1, 1, 'Pending', 50),
(2, NULL, 'Pending', 1),
(3, 2, 'Pending', 51),
(4, 3, 'Confirmed', 1),
(5, NULL, 'Pending', 100),
(6, NULL, 'Pending', 10),
(7, NULL, 'Pending', 11),
(8, NULL, 'Pending', 0),
(9, NULL, 'Pending', 11);

-- --------------------------------------------------------

--
-- Table structure for table `order_produit`
--

CREATE TABLE `order_produit` (
  `order_id` int(11) NOT NULL,
  `produit_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `id` int(11) NOT NULL,
  `order_line_id` int(11) NOT NULL,
  `session_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total` double NOT NULL,
  `created_on` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`id`, `order_line_id`, `session_id`, `status`, `total`, `created_on`) VALUES
(1, 1, '6409591b2a634f40dd9eb62d', 'pending', 50, '2023-03-09'),
(2, 3, '6409ce0a2a634f40dd9ec3ed', 'pending', 51, '2023-03-09'),
(3, 4, '6409d61f2a634f40dd9ec4cf', 'paid', 1, '2023-03-09');

-- --------------------------------------------------------

--
-- Table structure for table `produit`
--

CREATE TABLE `produit` (
  `id` int(11) NOT NULL,
  `id_categorie_id` int(11) NOT NULL,
  `nom_produit` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prix` double NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `stock` int(11) NOT NULL,
  `img` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rating` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `produit`
--

INSERT INTO `produit` (`id`, `id_categorie_id`, `nom_produit`, `prix`, `description`, `stock`, `img`, `rating`) VALUES
(1, 1, 'Roblox', 10, 'Roblox1', 156, 'produits/roblox.jpg', 4),
(2, 1, 'Valorant', 1, 'Valorant1', 15, 'produits/valorant.jpg', 1),
(3, 2, 'CS:GO Knife Skin #01', 50, 'CS:GO Knife Skin1', 300, 'produits/skin1.png', 5);

-- --------------------------------------------------------

--
-- Table structure for table `reclamation`
--

CREATE TABLE `reclamation` (
  `id` int(11) NOT NULL,
  `commande_id` int(11) DEFAULT NULL,
  `titre_rec` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type_rec` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_rec` date NOT NULL,
  `contenu_rec` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `statut_rec` int(11) NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reclamation`
--

INSERT INTO `reclamation` (`id`, `commande_id`, `titre_rec`, `type_rec`, `date_rec`, `contenu_rec`, `statut_rec`, `username`) VALUES
(1, 1, 'test', 'test', '2027-01-01', 'lkjkn', 1, 'gdsgs'),
(2, 2, 'test', 'test', '2026-01-01', 'dsfdsfdf', 1, 'gdsgs'),
(3, 3, 'test', 'QSS', '2026-01-01', 'SQSQS', 1, 'gdsgs'),
(4, 4, 'Problème', 'test', '2023-05-01', 'problème', 1, 'user1');

-- --------------------------------------------------------

--
-- Table structure for table `repons`
--

CREATE TABLE `repons` (
  `id` int(11) NOT NULL,
  `id_reclamation_id` int(11) DEFAULT NULL,
  `date_rep` date NOT NULL,
  `contenu_rep` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `status_rep` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `repons`
--

INSERT INTO `repons` (`id`, `id_reclamation_id`, `date_rep`, `contenu_rep`, `status_rep`) VALUES
(1, 4, '2023-05-01', 'contenu', 3);

-- --------------------------------------------------------

--
-- Table structure for table `reservation`
--

CREATE TABLE `reservation` (
  `id` int(11) NOT NULL,
  `id_membre_id` int(11) NOT NULL,
  `id_evenement_id` int(11) NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `email` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` longtext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '(DC2Type:json)',
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pseudo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `addresse` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_naissance` date NOT NULL,
  `disable_token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `activation_token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reset_token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `email`, `roles`, `password`, `pseudo`, `addresse`, `date_naissance`, `disable_token`, `activation_token`, `reset_token`) VALUES
(11, 'louay.khemiri@esprit.tn', '[\"ROLE_USER\"]', '$2a$13$hCTW8q3G9qsvRkYPzwv8cO8b3YjDCzpLYfaQESWGlmKTbT6gFFAua', 'louay', 'aa', '2022-05-05', 'Enabled', NULL, NULL),
(12, 'anesthesied@mail.com', '[\"ROLE_ADMIN\"]', '$2a$13$Z2rnxoCPfp4fEJldil3T9Ov.JAJvcxwEYgzZoXyxQHBeY8IrXlPYi', 'hassen', 'aa', '2022-05-04', 'Enabled', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `blog`
--
ALTER TABLE `blog`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cart_produit`
--
ALTER TABLE `cart_produit`
  ADD PRIMARY KEY (`cart_id`,`produit_id`),
  ADD KEY `IDX_D27F24201AD5CDBF` (`cart_id`),
  ADD KEY `IDX_D27F2420F347EFB` (`produit_id`);

--
-- Indexes for table `categorie`
--
ALTER TABLE `categorie`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_9474526C7D1F45A9` (`bbid_id`),
  ADD KEY `IDX_9474526C72EBC645` (`iduscomm_id`);

--
-- Indexes for table `doctrine_migration_versions`
--
ALTER TABLE `doctrine_migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Indexes for table `evenement`
--
ALTER TABLE `evenement`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `item`
--
ALTER TABLE `item`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_1F1B251E4584665A` (`product_id`),
  ADD KEY `IDX_1F1B251E82EA2E54` (`commande_id`);

--
-- Indexes for table `membre`
--
ALTER TABLE `membre`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messenger_messages`
--
ALTER TABLE `messenger_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_75EA56E0FB7336F0` (`queue_name`),
  ADD KEY `IDX_75EA56E0E3BD61CE` (`available_at`),
  ADD KEY `IDX_75EA56E016BA31DB` (`delivered_at`);

--
-- Indexes for table `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_F52993984C3A3BB` (`payment_id`);

--
-- Indexes for table `order_produit`
--
ALTER TABLE `order_produit`
  ADD PRIMARY KEY (`order_id`,`produit_id`),
  ADD KEY `IDX_DFDF456C8D9F6D38` (`order_id`),
  ADD KEY `IDX_DFDF456CF347EFB` (`produit_id`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_6D28840DBB01DC09` (`order_line_id`);

--
-- Indexes for table `produit`
--
ALTER TABLE `produit`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_29A5EC279F34925F` (`id_categorie_id`);

--
-- Indexes for table `reclamation`
--
ALTER TABLE `reclamation`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_CE60640482EA2E54` (`commande_id`);

--
-- Indexes for table `repons`
--
ALTER TABLE `repons`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_BC3CBF7A100D1FDF` (`id_reclamation_id`);

--
-- Indexes for table `reservation`
--
ALTER TABLE `reservation`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_42C84955EAAC4B6D` (`id_membre_id`),
  ADD KEY `IDX_42C849552C115A61` (`id_evenement_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `blog`
--
ALTER TABLE `blog`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `categorie`
--
ALTER TABLE `categorie`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `comment`
--
ALTER TABLE `comment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `evenement`
--
ALTER TABLE `evenement`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `item`
--
ALTER TABLE `item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `membre`
--
ALTER TABLE `membre`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `messenger_messages`
--
ALTER TABLE `messenger_messages`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order`
--
ALTER TABLE `order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `produit`
--
ALTER TABLE `produit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `reclamation`
--
ALTER TABLE `reclamation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `repons`
--
ALTER TABLE `repons`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `reservation`
--
ALTER TABLE `reservation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart_produit`
--
ALTER TABLE `cart_produit`
  ADD CONSTRAINT `FK_D27F24201AD5CDBF` FOREIGN KEY (`cart_id`) REFERENCES `cart` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_D27F2420F347EFB` FOREIGN KEY (`produit_id`) REFERENCES `produit` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `FK_9474526C72EBC645` FOREIGN KEY (`iduscomm_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `FK_9474526C7D1F45A9` FOREIGN KEY (`bbid_id`) REFERENCES `blog` (`id`);

--
-- Constraints for table `item`
--
ALTER TABLE `item`
  ADD CONSTRAINT `FK_1F1B251E4584665A` FOREIGN KEY (`product_id`) REFERENCES `produit` (`id`),
  ADD CONSTRAINT `FK_1F1B251E82EA2E54` FOREIGN KEY (`commande_id`) REFERENCES `order` (`id`);

--
-- Constraints for table `order`
--
ALTER TABLE `order`
  ADD CONSTRAINT `FK_F52993984C3A3BB` FOREIGN KEY (`payment_id`) REFERENCES `payment` (`id`);

--
-- Constraints for table `order_produit`
--
ALTER TABLE `order_produit`
  ADD CONSTRAINT `FK_DFDF456C8D9F6D38` FOREIGN KEY (`order_id`) REFERENCES `order` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_DFDF456CF347EFB` FOREIGN KEY (`produit_id`) REFERENCES `produit` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `payment`
--
ALTER TABLE `payment`
  ADD CONSTRAINT `FK_6D28840DBB01DC09` FOREIGN KEY (`order_line_id`) REFERENCES `order` (`id`);

--
-- Constraints for table `produit`
--
ALTER TABLE `produit`
  ADD CONSTRAINT `FK_29A5EC279F34925F` FOREIGN KEY (`id_categorie_id`) REFERENCES `categorie` (`id`);

--
-- Constraints for table `reclamation`
--
ALTER TABLE `reclamation`
  ADD CONSTRAINT `FK_CE60640482EA2E54` FOREIGN KEY (`commande_id`) REFERENCES `order` (`id`);

--
-- Constraints for table `repons`
--
ALTER TABLE `repons`
  ADD CONSTRAINT `FK_BC3CBF7A100D1FDF` FOREIGN KEY (`id_reclamation_id`) REFERENCES `reclamation` (`id`);

--
-- Constraints for table `reservation`
--
ALTER TABLE `reservation`
  ADD CONSTRAINT `FK_42C849552C115A61` FOREIGN KEY (`id_evenement_id`) REFERENCES `evenement` (`id`),
  ADD CONSTRAINT `FK_42C84955EAAC4B6D` FOREIGN KEY (`id_membre_id`) REFERENCES `user` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
