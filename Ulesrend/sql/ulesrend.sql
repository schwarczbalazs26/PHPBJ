-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Gép: 127.0.0.1
-- Létrehozás ideje: 2023. Okt 05. 12:39
-- Kiszolgáló verziója: 10.4.28-MariaDB
-- PHP verzió: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Adatbázis: `ulesrend`
--

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `osztaly`
--

CREATE TABLE `osztaly` (
  `id` int(11) NOT NULL,
  `nev` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `sor` tinyint(3) UNSIGNED NOT NULL,
  `oszlop` tinyint(3) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- A tábla adatainak kiíratása `osztaly`
--

INSERT INTO `osztaly` (`id`, `nev`, `sor`, `oszlop`) VALUES
(1, 'S. Balázs', 0, 0),
(2, 'H. Szabolcs', 0, 1),
(3, 'F. László', 0, 2),
(4, 'G. Zoltán', 0, 4),
(5, 'H. Ferenc', 0, 5),
(6, 'K. Márton', 1, 0),
(7, 'B. László', 1, 1),
(8, 'K. Dominik', 1, 2),
(9, 'J. Dániel', 1, 4),
(10, 'V. Szabolcs', 1, 5),
(11, 'B. Marcell', 2, 0),
(12, 'S. Attila', 2, 1),
(13, 'H. Márk', 2, 4),
(14, 'R. Dávid', 2, 5),
(15, 'Tanár', 3, 3),
(16, 'T. Márton', 3, 4);

--
-- Indexek a kiírt táblákhoz
--

--
-- A tábla indexei `osztaly`
--
ALTER TABLE `osztaly`
  ADD PRIMARY KEY (`id`);

--
-- A kiírt táblák AUTO_INCREMENT értéke
--

--
-- AUTO_INCREMENT a táblához `osztaly`
--
ALTER TABLE `osztaly`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
