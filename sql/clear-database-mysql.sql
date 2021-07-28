SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET NAMES utf8mb4 */;

-- --------------------------------------------------------

--
-- CREATE TABLE `authorgroups`
--

CREATE TABLE `authorgroups` (
  `id_author` int(11) NOT NULL,
  `id_travel` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

-- --------------------------------------------------------

--
-- CREATE TABLE `authors`
--

CREATE TABLE `authors` (
  `id_author` int(11) NOT NULL,
  `firstname` varchar(255) COLLATE utf8mb4_polish_ci NOT NULL,
  `lastname` varchar(255) COLLATE utf8mb4_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

-- --------------------------------------------------------

--
-- CREATE TABLE `meetingpoints`
--

CREATE TABLE `meetingpoints` (
  `id_meetingpoint` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_polish_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_polish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

-- --------------------------------------------------------

--
-- CREATE TABLE `photos`
--

CREATE TABLE `photos` (
  `id_photo` int(11) NOT NULL,
  `id_travel` int(11) NOT NULL,
  `filename` varchar(255) COLLATE utf8mb4_polish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

-- --------------------------------------------------------

--
-- CREATE TABLE `travels`
--

CREATE TABLE `travels` (
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
-- CREATE TABLE `users`
--

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_polish_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- DEFAULT ADMIN USER
-- username: admin
-- password: admin123
-- REMEMBER TO CHANGE PASSWORD AFTER SETUP
--

INSERT INTO `users` (`id_user`, `username`, `password`) VALUES
(1, 'admin', '$2y$10$SPQ7X3.t7lnLM0Cdd5Z7CuILPSkNvaiRlgdyzlMos1kDvdOu.OsQS');

--
-- KEYS `authorgroups`
--
ALTER TABLE `authorgroups`
  ADD PRIMARY KEY (`id_author`,`id_travel`),
  ADD KEY `id_travel` (`id_travel`);

--
-- KEYS `authors`
--
ALTER TABLE `authors`
  ADD PRIMARY KEY (`id_author`);

--
-- KEYS `meetingpoints`
--
ALTER TABLE `meetingpoints`
  ADD PRIMARY KEY (`id_meetingpoint`);

--
-- KEYS `photos`
--
ALTER TABLE `photos`
  ADD PRIMARY KEY (`id_photo`),
  ADD KEY `id_travel` (`id_travel`);

--
-- KEYS `travels`
--
ALTER TABLE `travels`
  ADD PRIMARY KEY (`id_travel`),
  ADD KEY `id_meetingpoint` (`id_meetingpoint`);

--
-- KEYS `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT `authors`
--
ALTER TABLE `authors`
  MODIFY `id_author` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT `meetingpoints`
--
ALTER TABLE `meetingpoints`
  MODIFY `id_meetingpoint` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT `photos`
--
ALTER TABLE `photos`
  MODIFY `id_photo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT `travels`
--
ALTER TABLE `travels`
  MODIFY `id_travel` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- CONSTRAINTS `authorgroups`
--
ALTER TABLE `authorgroups`
  ADD CONSTRAINT `AuthorGroups_ibfk_1` FOREIGN KEY (`id_author`) REFERENCES `authors` (`id_author`),
  ADD CONSTRAINT `AuthorGroups_ibfk_2` FOREIGN KEY (`id_travel`) REFERENCES `travels` (`id_travel`);

--
-- CONSTRAINTS `photos`
--
ALTER TABLE `photos`
  ADD CONSTRAINT `Photos_ibfk_1` FOREIGN KEY (`id_travel`) REFERENCES `travels` (`id_travel`);

--
-- CONSTRAINTS `travels`
--
ALTER TABLE `travels`
  ADD CONSTRAINT `Travels_ibfk_1` FOREIGN KEY (`id_meetingpoint`) REFERENCES `meetingpoints` (`id_meetingpoint`);
COMMIT;
