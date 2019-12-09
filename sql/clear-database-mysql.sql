SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

--
-- TABLE `AuthorGroups`
--

CREATE TABLE `AuthorGroups` (
  `id_author` int(11) NOT NULL,
  `id_travel` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

-- --------------------------------------------------------

--
-- TABLE `Authors`
--

CREATE TABLE `Authors` (
  `id_author` int(11) NOT NULL,
  `firstname` varchar(255) COLLATE utf8mb4_polish_ci NOT NULL,
  `lastname` varchar(255) COLLATE utf8mb4_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

-- --------------------------------------------------------

--
-- TABLE `MeetingPoints`
--

CREATE TABLE `MeetingPoints` (
  `id_meetingpoint` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_polish_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_polish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

-- --------------------------------------------------------

--
-- TABLE `Photos`
--

CREATE TABLE `Photos` (
  `id_photo` int(11) NOT NULL,
  `id_travel` int(11) NOT NULL,
  `filename` varchar(255) COLLATE utf8mb4_polish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

-- --------------------------------------------------------

--
-- TABLE `Travels`
--

CREATE TABLE `Travels` (
  `id_travel` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_polish_ci NOT NULL,
  `location` varchar(255) COLLATE utf8mb4_polish_ci NOT NULL,
  `date` date NOT NULL,
  `hour` time NOT NULL,
  `id_meetingpoint` int(11) NOT NULL,
  `latitude` double(10,2) DEFAULT NULL,
  `longitude` double(10,2) DEFAULT NULL,
  `description` varchar(255) COLLATE utf8mb4_polish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

-- --------------------------------------------------------

--
-- TABLE `Users`
--

CREATE TABLE `Users` (
  `id_user` int(11) NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_polish_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- KEYS `AuthorGroups`
--
ALTER TABLE `AuthorGroups`
  ADD PRIMARY KEY (`id_author`,`id_travel`),
  ADD KEY `id_travel` (`id_travel`);

--
-- KEYS `Authors`
--
ALTER TABLE `Authors`
  ADD PRIMARY KEY (`id_author`);

--
-- KEYS `MeetingPoints`
--
ALTER TABLE `MeetingPoints`
  ADD PRIMARY KEY (`id_meetingpoint`);

--
-- KEYS `Photos`
--
ALTER TABLE `Photos`
  ADD PRIMARY KEY (`id_photo`),
  ADD KEY `id_travel` (`id_travel`);

--
-- KEYS `Travels`
--
ALTER TABLE `Travels`
  ADD PRIMARY KEY (`id_travel`),
  ADD KEY `id_meetingpoint` (`id_meetingpoint`);

--
-- KEYS `Users`
--
ALTER TABLE `Users`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT `Authors`
--
ALTER TABLE `Authors`
  MODIFY `id_author` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT `MeetingPoints`
--
ALTER TABLE `MeetingPoints`
  MODIFY `id_meetingpoint` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT `Photos`
--
ALTER TABLE `Photos`
  MODIFY `id_photo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT `Travels`
--
ALTER TABLE `Travels`
  MODIFY `id_travel` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT `Users`
--
ALTER TABLE `Users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT;

--
-- CONSTRAINTS `AuthorGroups`
--
ALTER TABLE `AuthorGroups`
  ADD CONSTRAINT `AuthorGroups_ibfk_1` FOREIGN KEY (`id_author`) REFERENCES `Authors` (`id_author`),
  ADD CONSTRAINT `AuthorGroups_ibfk_2` FOREIGN KEY (`id_travel`) REFERENCES `Travels` (`id_travel`);

--
-- CONSTRAINTS `Photos`
--
ALTER TABLE `Photos`
  ADD CONSTRAINT `Photos_ibfk_1` FOREIGN KEY (`id_travel`) REFERENCES `Travels` (`id_travel`);

--
-- CONSTRAINTS `Travels`
--
ALTER TABLE `Travels`
  ADD CONSTRAINT `Travels_ibfk_1` FOREIGN KEY (`id_meetingpoint`) REFERENCES `MeetingPoints` (`id_meetingpoint`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;