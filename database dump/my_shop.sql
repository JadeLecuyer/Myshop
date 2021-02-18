-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le : jeu. 18 fév. 2021 à 12:05
-- Version du serveur :  5.7.32
-- Version de PHP : 7.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `my_shop`
--

-- --------------------------------------------------------

--
-- Structure de la table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `categories`
--

INSERT INTO `categories` (`id`, `name`, `parent_id`) VALUES
(1, 'Meubles', NULL),
(2, 'Chaises', 1),
(3, 'Canapés', 1),
(4, 'Lits', 1),
(5, 'Rangements', 1),
(6, 'Fauteuils', 2),
(7, 'Chaises de salle à manger', 2),
(8, 'Tables et bureaux', 1),
(9, 'Tables de salon', 8),
(10, 'Bureaux', 8),
(11, 'Décoration', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL DEFAULT '0',
  `price` int(11) NOT NULL DEFAULT '0',
  `category_id` int(11) NOT NULL DEFAULT '0',
  `description` text NOT NULL,
  `img` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `products`
--

INSERT INTO `products` (`id`, `name`, `price`, `category_id`, `description`, `img`) VALUES
(1, 'Chaise avec coussin', 70, 7, 'Chaise avec coussin pour votre salle à manger', 'products/img/16-02-21-14-36-09.jpeg'),
(2, 'Canapé d&#39;angle noir', 1200, 3, 'Un joli canapé d&#39;angle noir pour votre salon ou pièce de détente', 'products/img/16-02-21-14-39-46.jpeg'),
(3, 'Fauteuil à imprimé', 300, 6, 'Fauteuil à imprimé pour votre salon ou salle de détente', 'products/img/16-02-21-14-41-15.jpeg'),
(4, 'Lit deux places', 900, 4, 'Brévitér fidelissimae genuit inhumanus quibusdam singulis statua vestibulum. Amicorum impediente mediocriterne poterimus scribi. Détractio efficiendi mala nóminata periculis quosvis suspéndissé. Deterritum doloris modi permulta verterem. \r\n\r\náperiri corrigere dicemus dissentio, eosdem firmissimum fonté hosti quid quoniam recusabo sentiant sumus utrum. Insipientiam ostendit philosophi sociosqu ut. Aeternum architecto distinguantur emancipaverat fórtunae industria mediocritatem pueri quondam reperire scriptum terrore varias. Confectum disciplinis omittam partem rudem tértio vetuit. álbucius animadvertat brutus cáusás, debilitati eodem libidinum litterás, neglegentur retinere tranquillitaté urbanitas. Antipatrum audiebamus causa cohaéréscént cyrenaicos nostrám novum probo sólitudó. Aequi loqueretur minus nondum platonis. ', 'products/img/16-02-21-14-45-00.jpeg'),
(5, 'Fauteuil blanc', 450, 6, 'Un fauteuil blanc pour se détendre', 'products/img/16-02-21-14-47-28.jpeg'),
(6, 'Canapé bleu', 775, 3, 'Breviter consequentis contemnit contrariis defuit, docere homero inventore istius militaris odit romanum suscipiet venenatis. Amaret angatur aristotelem audeam cadere dolere epicureis maluisset molita no patet quippe quot stet summam. Aute cognosci corrumpit errorem exaudita, exedunt hic iuste perspecta praestabiliorem, sapientiamque tutiorem viam. Ancillae erudito expetendis ob. Artes dicturam gessisse tristique. Chrysippe deorsus nibh pellat sciscat una vulgo. \r\n\r\nAntiquis effici explicavi potiendi quoque sanciret. Consentaneum defendit explicatis familias imagines ingenia laudatur maiestatis modi stabilitas. Ceteros consilia fortasse iniuste miserum probaretur reici solent video. ', 'products/img/16-02-21-14-49-49.jpeg'),
(7, 'Chaise en bois', 82, 2, 'Une chaise en bois d&#39;aspect ancien', 'products/img/16-02-21-14-51-43.jpeg'),
(8, 'Lit bébé', 200, 4, 'Un petit lit pour bébé', 'products/img/16-02-21-14-55-48.jpeg'),
(9, 'Bureau noir', 150, 10, 'Un petit bureau noir, s&#39;adapte à toutes vos pièces', 'products/img/16-02-21-14-58-00.jpeg'),
(10, 'Bureau blanc', 250, 10, 'Un petit bureau blanc', 'products/img/16-02-21-14-58-29.jpeg'),
(11, 'Table ronde', 450, 9, 'Table ronde en bois pour votre salle à manger', 'products/img/16-02-21-15-01-18.jpeg'),
(12, 'Table de jardin', 150, 8, 'Table à manger d&#39;appoint en bois pour votre extérieur', 'products/img/16-02-21-15-04-07.jpeg'),
(13, 'Meuble de rangement', 880, 5, 'Meuble de rangement en bois', 'products/img/16-02-21-15-06-45.jpeg');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `admin` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT pour la table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
