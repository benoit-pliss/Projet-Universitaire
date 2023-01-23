--
-- Structure de la table `Aptitude`
--

CREATE TABLE `Aptitude` (
  `aptitudeId` int(11) NOT NULL,
  `aptitudeName` varchar(100) NOT NULL,
  `skillId` int(11) NOT NULL,
  `aptitudeDeleted` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `Aptitude`
--

INSERT INTO `Aptitude` (`aptitudeId`, `aptitudeName`, `skillId`, `aptitudeDeleted`) VALUES
(1, 'Gréage et dégréage', 1, 0);

-- --------------------------------------------------------

--
-- Structure de la table `Content`
--

CREATE TABLE `Content` (
  `contentId` int(11) NOT NULL,
  `sessionId` int(11) NOT NULL,
  `aptitudeId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `Content`
--

INSERT INTO `Content` (`contentId`, `sessionId`, `aptitudeId`) VALUES
(1, 3, 5);

-- --------------------------------------------------------

--
-- Structure de la table `Formation`
--

CREATE TABLE `Formation` (
  `formationId` int(11) NOT NULL,
  `formationName` varchar(45) NOT NULL,
  `formationDeleted` tinyint(4) NOT NULL DEFAULT 0,
  `levelId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `Formation`
--

INSERT INTO `Formation` (`formationId`, `formationName`, `formationDeleted`, `levelId`) VALUES
(1, 'Niveau 1 - Groupe 1', 0, 1);

-- --------------------------------------------------------

--
-- Structure de la table `Initiator`
--

CREATE TABLE `Initiator` (
  `initiatorId` int(11) NOT NULL,
  `initiatorName` varchar(16) NOT NULL,
  `initiatorEmail` varchar(255) NOT NULL,
  `initiatorPassword` varchar(32) NOT NULL,
  `initiatorDeleted` tinyint(4) NOT NULL DEFAULT 0,
  `initiatorIsDirector` tinyint(4) NOT NULL DEFAULT 0,
  `levelId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `Initiator`
--

INSERT INTO `Initiator` (`initiatorId`, `initiatorName`, `initiatorEmail`, `initiatorPassword`, `initiatorDeleted`, `initiatorIsDirector`, `levelId`) VALUES
(1, 'Jort', 'fabienne.jort@unicaen.fr', 'aVeryGood_PassW0rd', 0, 1, 2);

-- --------------------------------------------------------

--
-- Structure de la table `Level`
--

CREATE TABLE `Level` (
  `levelId` int(11) NOT NULL,
  `levelName` varchar(45) DEFAULT NULL,
  `levelDeleted` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `Level`
--

INSERT INTO `Level` (`levelId`, `levelName`, `levelDeleted`) VALUES
(1, 'Niveau 1', 0),
(2, 'Niveau 2', 0);

-- --------------------------------------------------------

--
-- Structure de la table `OneTimePassword`
--

CREATE TABLE `OneTimePassword` (
  `initiatorId` int(11) NOT NULL,
  `otpIP` varchar(45) NOT NULL,
  `otpKey` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `Participation`
--

CREATE TABLE `Participation` (
  `participationId` int(11) NOT NULL,
  `contentId` int(11) NOT NULL,
  `studentId` int(11) NOT NULL,
  `statusId` int(11) NOT NULL DEFAULT 1,
  `commentary` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `Participation`
--

INSERT INTO `Participation` (`participationId`, `contentId`, `studentId`, `statusId`, `commentary`) VALUES
(1, 28, 17, 3, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `Session`
--

CREATE TABLE `Session` (
  `sessionId` int(11) NOT NULL,
  `sessionDate` datetime NOT NULL,
  `formationId` int(11) NOT NULL,
  `sessionDeleted` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `Session`
--

INSERT INTO `Session` (`sessionId`, `sessionDate`, `formationId`, `sessionDeleted`) VALUES
(3, '2023-01-12 19:00:00', 1, 0);

-- --------------------------------------------------------

--
-- Structure de la table `Skill`
--

CREATE TABLE `Skill` (
  `skillId` int(11) NOT NULL,
  `skillName` varchar(100) NOT NULL,
  `skillDeleted` tinyint(4) NOT NULL DEFAULT 0,
  `levelId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `Skill`
--

INSERT INTO `Skill` (`skillId`, `skillName`, `skillDeleted`, `levelId`) VALUES
(1, 'Séquiper et se déséquiper', 0, 1);

-- --------------------------------------------------------

--
-- Structure de la table `Status`
--

CREATE TABLE `Status` (
  `statusId` int(11) NOT NULL,
  `statusName` varchar(45) NOT NULL,
  `statusColor` char(7) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `Status`
--

INSERT INTO `Status` (`statusId`, `statusName`, `statusColor`) VALUES
(1, 'Non-Évalué', '#F3F3F3');

-- --------------------------------------------------------

--
-- Structure de la table `Student`
--

CREATE TABLE `Student` (
  `studentId` int(11) NOT NULL,
  `studentName` varchar(45) NOT NULL,
  `formationId` int(11) NOT NULL,
  `studentDeleted` tinyint(4) NOT NULL DEFAULT 0,
  `StudentPhone` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `Student`
--

INSERT INTO `Student` (`studentId`, `studentName`, `formationId`, `studentDeleted`, `StudentPhone`) VALUES
(1, 'lemeur loic', 3, 1, '061011121314');

-- --------------------------------------------------------

--
-- Structure de la table `TrainingManager`
--

CREATE TABLE `TrainingManager` (
  `trainingManagerId` int(11) NOT NULL,
  `initiatorId` int(11) NOT NULL,
  `formationId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `TrainingManager`
--

INSERT INTO `TrainingManager` (`trainingManagerId`, `initiatorId`, `formationId`) VALUES
(1, 1, 2);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `Aptitude`
--
ALTER TABLE `Aptitude`
  ADD PRIMARY KEY (`aptitudeId`),
  ADD KEY `fk_Aptitude_Skill_idx` (`skillId`);

--
-- Index pour la table `Content`
--
ALTER TABLE `Content`
  ADD PRIMARY KEY (`contentId`),
  ADD KEY `fk_Contains_Session1_idx` (`sessionId`),
  ADD KEY `fk_Contains_Aptitude1_idx` (`aptitudeId`);

--
-- Index pour la table `Formation`
--
ALTER TABLE `Formation`
  ADD PRIMARY KEY (`formationId`),
  ADD UNIQUE KEY `name_UNIQUE` (`formationName`),
  ADD KEY `fk_Formation_Level1_idx` (`levelId`);

--
-- Index pour la table `Initiator`
--
ALTER TABLE `Initiator`
  ADD PRIMARY KEY (`initiatorId`),
  ADD UNIQUE KEY `email_UNIQUE` (`initiatorEmail`),
  ADD KEY `fk_Initiator_Level1_idx` (`levelId`);

--
-- Index pour la table `Level`
--
ALTER TABLE `Level`
  ADD PRIMARY KEY (`levelId`),
  ADD UNIQUE KEY `name_UNIQUE` (`levelName`);

--
-- Index pour la table `OneTimePassword`
--
ALTER TABLE `OneTimePassword`
  ADD PRIMARY KEY (`initiatorId`);

--
-- Index pour la table `Participation`
--
ALTER TABLE `Participation`
  ADD PRIMARY KEY (`participationId`),
  ADD KEY `fk_Participate_Student_idx` (`studentId`),
  ADD KEY `fk_Participate_Status_idx` (`statusId`),
  ADD KEY `fk_Participate_Content1_idx` (`contentId`);

--
-- Index pour la table `Session`
--
ALTER TABLE `Session`
  ADD PRIMARY KEY (`sessionId`),
  ADD KEY `fk_Session_Formation_idx` (`formationId`);

--
-- Index pour la table `Skill`
--
ALTER TABLE `Skill`
  ADD PRIMARY KEY (`skillId`),
  ADD KEY `fk_Skill_Level1_idx` (`levelId`);

--
-- Index pour la table `Status`
--
ALTER TABLE `Status`
  ADD PRIMARY KEY (`statusId`),
  ADD UNIQUE KEY `statusName_UNIQUE` (`statusName`);

--
-- Index pour la table `Student`
--
ALTER TABLE `Student`
  ADD PRIMARY KEY (`studentId`),
  ADD KEY `fk_Student_Formation_idx` (`formationId`);

--
-- Index pour la table `TrainingManager`
--
ALTER TABLE `TrainingManager`
  ADD PRIMARY KEY (`trainingManagerId`),
  ADD KEY `fk_TrainingManager_Intiator_idx` (`initiatorId`),
  ADD KEY `fk_TrainingManager_Formation_idx` (`formationId`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `Aptitude`
--
ALTER TABLE `Aptitude`
  MODIFY `aptitudeId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT pour la table `Content`
--
ALTER TABLE `Content`
  MODIFY `contentId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT pour la table `Formation`
--
ALTER TABLE `Formation`
  MODIFY `formationId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `Initiator`
--
ALTER TABLE `Initiator`
  MODIFY `initiatorId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT pour la table `Level`
--
ALTER TABLE `Level`
  MODIFY `levelId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `Participation`
--
ALTER TABLE `Participation`
  MODIFY `participationId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=183;

--
-- AUTO_INCREMENT pour la table `Session`
--
ALTER TABLE `Session`
  MODIFY `sessionId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT pour la table `Skill`
--
ALTER TABLE `Skill`
  MODIFY `skillId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT pour la table `Status`
--
ALTER TABLE `Status`
  MODIFY `statusId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `Student`
--
ALTER TABLE `Student`
  MODIFY `studentId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT pour la table `TrainingManager`
--
ALTER TABLE `TrainingManager`
  MODIFY `trainingManagerId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `Aptitude`
--
ALTER TABLE `Aptitude`
  ADD CONSTRAINT `fk_Aptitude_Skill` FOREIGN KEY (`skillId`) REFERENCES `Skill` (`skillId`) ON UPDATE CASCADE;

--
-- Contraintes pour la table `Content`
--
ALTER TABLE `Content`
  ADD CONSTRAINT `fk_Contains_Aptitude1` FOREIGN KEY (`aptitudeId`) REFERENCES `Aptitude` (`aptitudeId`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_Contains_Session1` FOREIGN KEY (`sessionId`) REFERENCES `Session` (`sessionId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `Formation`
--
ALTER TABLE `Formation`
  ADD CONSTRAINT `fk_Formation_Level1` FOREIGN KEY (`levelId`) REFERENCES `Level` (`levelId`) ON UPDATE CASCADE;

--
-- Contraintes pour la table `Initiator`
--
ALTER TABLE `Initiator`
  ADD CONSTRAINT `fk_Initiator_Level1` FOREIGN KEY (`levelId`) REFERENCES `Level` (`levelId`);

--
-- Contraintes pour la table `OneTimePassword`
--
ALTER TABLE `OneTimePassword`
  ADD CONSTRAINT `fk_table1_Initiator1` FOREIGN KEY (`initiatorId`) REFERENCES `Initiator` (`initiatorId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `Participation`
--
ALTER TABLE `Participation`
  ADD CONSTRAINT `fk_Participate_Content1` FOREIGN KEY (`contentId`) REFERENCES `Content` (`contentId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_Participate_Status` FOREIGN KEY (`statusId`) REFERENCES `Status` (`statusId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_Participate_Student` FOREIGN KEY (`studentId`) REFERENCES `Student` (`studentId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `Session`
--
ALTER TABLE `Session`
  ADD CONSTRAINT `fk_Session_Formation` FOREIGN KEY (`formationId`) REFERENCES `Formation` (`formationId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `Skill`
--
ALTER TABLE `Skill`
  ADD CONSTRAINT `fk_Skill_Level1` FOREIGN KEY (`levelId`) REFERENCES `Level` (`levelId`) ON UPDATE CASCADE;

--
-- Contraintes pour la table `Student`
--
ALTER TABLE `Student`
  ADD CONSTRAINT `fk_Student_Formation` FOREIGN KEY (`formationId`) REFERENCES `Formation` (`formationId`) ON UPDATE CASCADE;

--
-- Contraintes pour la table `TrainingManager`
--
ALTER TABLE `TrainingManager`
  ADD CONSTRAINT `fk_TrainingManager_Formation` FOREIGN KEY (`formationId`) REFERENCES `Formation` (`formationId`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_TrainingManager_Initiator` FOREIGN KEY (`initiatorId`) REFERENCES `Initiator` (`initiatorId`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
