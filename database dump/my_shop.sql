-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le : Dim 21 fév. 2021 à 13:02
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
(11, 'Décoration', NULL),
(12, 'Chaises en bois', 7),
(13, 'Tables de chevet', 8);

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
(7, 'Chaise en bois', 82, 12, 'Une chaise en bois d&#39;aspect ancien', 'products/img/16-02-21-14-51-43.jpeg'),
(8, 'Lit bébé', 200, 4, 'Un petit lit pour bébé', 'products/img/16-02-21-14-55-48.jpeg'),
(9, 'Bureau noir', 150, 10, 'Un petit bureau noir, s&#39;adapte à toutes vos pièces', 'products/img/16-02-21-14-58-00.jpeg'),
(10, 'Bureau blanc', 250, 10, 'Un petit bureau blanc', 'products/img/16-02-21-14-58-29.jpeg'),
(11, 'Table ronde', 450, 9, 'Table ronde en bois pour votre salle à manger', 'products/img/16-02-21-15-01-18.jpeg'),
(12, 'Table de jardin', 150, 8, 'Table à manger d&#39;appoint en bois pour votre extérieur', 'products/img/16-02-21-15-04-07.jpeg'),
(13, 'Meuble de rangement', 650, 5, 'Meuble de rangement en bois', 'products/img/16-02-21-15-06-45.jpeg'),
(14, 'Meuble de salle de bain', 880, 5, 'Meuble de salle de bain blanc', 'products/img/18-02-21-13-31-58.jpeg'),
(15, 'Cadres photo', 55, 11, 'Lot de cadres photo carrés', 'products/img/18-02-21-13-33-15.jpeg'),
(16, 'Lit deux places', 900, 4, 'Lit deux places avec tête de lit en bois', 'products/img/18-02-21-13-39-17.jpeg'),
(17, 'Échelle en bois', 42, 11, 'Échelle en bois décorative pouvant servir de porte serviettes', 'products/img/18-02-21-13-42-07.jpeg'),
(18, 'Bureau à tiroirs', 500, 10, 'Un bureau à tiroir noir et blanc', 'products/img/21-02-21-12-32-59.jpeg'),
(19, 'Table de chevet blanche', 65, 13, 'Petite table de chevet blanche à pieds en bois.', 'products/img/21-02-21-12-38-55.jpeg'),
(20, 'Lot de chaises assorties', 250, 7, 'Lot de chaises bleues pour salle à manger', 'products/img/21-02-21-12-40-54.jpeg'),
(21, 'Canapé en cuir', 750, 3, 'Conquirendae cuiquam ferrentur perfruique, sanos sinat! Angore aristotelem erit expectant, interesset malle nostros opus supplicii! Debeo improborum intus scribendi? Aliena athenis consistat discordia habent omnia pertineant simulent utroque? Antiquitate corpus disputata libero potiora, quantus rebus summa! Interesse iudicem referta reprehensione? Geometria hendrerit pri sanciret usque. \r\n\r\nAdhibenda causam clariora clarorum firmissimum, flagitem nullam persecuti plerisque probarem solido veniamus vester? Congue discordant esset gratissimo laetamur, malle ortum referrentur. Ceterorum infinito mutat vide! Adipiscuntur discere quaerendi tranquilli! Atqui confirmatur eiusdem legantur tation terentianus? Alliciat cedentem copulationes derepta ille iniucundus maximasque mnesarchum quaerenda redeamus! ', 'products/img/21-02-21-12-45-48.jpeg'),
(22, 'Petit bureau blanc', 100, 10, 'Lórem ipsum dolor sit, amet adiuvét ámicitiám árbitrium, corrupti nam. éffugiéndorum inferiorem neque praétéréat, quietus séditionés solum stoici suscepi. Aptént bona cómpróbavit eum factorum iaculis pérsonaé quippe semel similia terroribus viverrá. \r\n\r\nDisputari existimare mazim occaecat sis. Daré efflorescere equidem fama fautrices habitassé impetum morbi nimium pertinaces sé synephebos telos. Accedit amotio comprobávit confirmat curabitur errata intervenire iucunditate leguntur oporteat quiá re repugnantibus suspendisse vocant. Extremo illa quietae timorem vexetur. ', 'products/img/21-02-21-12-47-38.jpeg'),
(23, 'Miroir rond', 50, 11, 'Petit miroir rond à accrocher', 'products/img/21-02-21-12-52-50.jpeg'),
(24, 'Lot de vases', 45, 11, 'Lorem ipsum dolor sit amet cupiditate domo effectrices quisquam quodsi repellere rhoncus statue ullius. A cillum consedit disciplina feci, flagitem intellegitur levius moderatio omnium ponunt potenti sermone tolerabiles verterem. Improbis lucifugi quoquo sis tellus vita. Bonae ceteris dissident factis geometrica negarent patrius responsum. ', 'products/img/21-02-21-12-53-34.jpeg'),
(25, 'Lot de décorations de Noël', 40, 11, 'Lorem ipsum dolor sit amet cupiditate domo effectrices quisquam quodsi repellere rhoncus statue ullius. A cillum consedit disciplina feci, flagitem intellegitur levius moderatio omnium ponunt potenti sermone tolerabiles verterem. Improbis lucifugi quoquo sis tellus vita. Bonae ceteris dissident factis geometrica negarent patrius responsum. ', 'products/img/21-02-21-12-56-48.jpeg');

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
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `admin`) VALUES
(1, 'admin', '$2y$10$0u.iXpG7lBuuq/BtKp4cReRHenHDnntnvPYWaeTRLjFWbcxAw5aha', 'admin@admin.com', 1),
(2, 'user', '$2y$10$dEVpxflM7.FefWO384aXkej6A8PD7p9CoS7EvlR0SNVSPjd/0MLR2', 'user@user.com', NULL);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT pour la table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
