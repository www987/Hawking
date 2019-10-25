-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 22 Paź 2019, 00:14
-- Wersja serwera: 10.4.6-MariaDB
-- Wersja PHP: 7.3.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `globalne_problemy`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `imie`
--

CREATE TABLE `imie` (
  `ID_imie` int(11) NOT NULL,
  `imie` varchar(35) COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `imie`
--

INSERT INTO `imie` (`ID_imie`, `imie`) VALUES
(1, 'Magdalena'),
(2, 'Małgorzata'),
(3, 'Agata'),
(4, 'Mariola'),
(5, 'Klaudia'),
(6, 'Maja'),
(7, 'Damian'),
(8, 'Dariusz'),
(9, 'Kazimiera'),
(10, 'Karina'),
(11, 'Wojciech'),
(12, 'Tomasz'),
(13, 'Grzegorz'),
(14, 'Zygmunt');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `miasto`
--

CREATE TABLE `miasto` (
  `ID_miasto` int(11) NOT NULL,
  `miasto` varchar(40) COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `miasto`
--

INSERT INTO `miasto` (`ID_miasto`, `miasto`) VALUES
(1, 'Łódź'),
(2, 'Warszawa'),
(3, 'Poznań'),
(4, 'Wrocław'),
(5, 'Kraków'),
(6, 'Lutomiersk'),
(7, 'Rąbień');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `nazwisko`
--

CREATE TABLE `nazwisko` (
  `ID_nazwisko` int(11) NOT NULL,
  `nazwisko` varchar(50) COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `nazwisko`
--

INSERT INTO `nazwisko` (`ID_nazwisko`, `nazwisko`) VALUES
(1, 'Kania'),
(2, 'Kubicki'),
(3, 'Baran'),
(4, 'Milewski'),
(5, 'Zawadzki'),
(6, 'Kulesza'),
(7, 'Sroka'),
(8, 'Gajewski'),
(9, 'Duda'),
(10, 'Kasprzyk'),
(11, 'Zakrzewski'),
(12, 'Szczucki');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `ogloszenie`
--

CREATE TABLE `ogloszenie` (
  `ID_ogloszenie` int(11) NOT NULL,
  `tytul` varchar(60) COLLATE utf8_polish_ci NOT NULL,
  `opis` varchar(1000) COLLATE utf8_polish_ci NOT NULL,
  `data` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `wynagrodzenie` float DEFAULT NULL,
  `ID_uzytkownicy` int(11) NOT NULL,
  `ID_umowa` int(11) NOT NULL,
  `ID_miasto` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `ogloszenie`
--

INSERT INTO `ogloszenie` (`ID_ogloszenie`, `tytul`, `opis`, `data`, `wynagrodzenie`, `ID_uzytkownicy`, `ID_umowa`, `ID_miasto`) VALUES
(1, 'Szkolimy programistów', 'Mamy najlepszych programistów', '2019-10-20 06:45:09', NULL, 1, 1, 1),
(2, 'Szkolimy kucharzy', 'Mamy najsmaczniejsze dania', '2019-10-20 06:45:19', NULL, 2, 2, 2),
(3, 'test', 'opis testu', '2019-10-20 06:45:27', 4000, 1, 3, 3);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `pracodawca`
--

CREATE TABLE `pracodawca` (
  `ID_pracodawca` int(11) NOT NULL,
  `pracodawca` varchar(60) COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `pracodawca`
--

INSERT INTO `pracodawca` (`ID_pracodawca`, `pracodawca`) VALUES
(1, 'Elektromonter'),
(2, 'Makro'),
(3, 'Selgros'),
(4, 'KFC');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `tag`
--

CREATE TABLE `tag` (
  `ID_tag` int(11) NOT NULL,
  `tag` varchar(30) COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `tag`
--

INSERT INTO `tag` (`ID_tag`, `tag`) VALUES
(1, 'SZKOLENIE'),
(2, 'PRACA');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `tag_do_ogloszenia`
--

CREATE TABLE `tag_do_ogloszenia` (
  `ID_tag_ogloszenie` int(11) NOT NULL,
  `ID_tag` int(11) NOT NULL,
  `ID_ogloszenie` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `tag_do_ogloszenia`
--

INSERT INTO `tag_do_ogloszenia` (`ID_tag_ogloszenie`, `ID_tag`, `ID_ogloszenie`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 2, 1);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `umowa`
--

CREATE TABLE `umowa` (
  `ID_umowa` int(11) NOT NULL,
  `umowa` varchar(14) COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `umowa`
--

INSERT INTO `umowa` (`ID_umowa`, `umowa`) VALUES
(1, 'Umowa o pracę'),
(2, 'Umowa zlecenie'),
(3, 'Umowa o dzieło'),
(4, 'Inny');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `uzytkownicy`
--

CREATE TABLE `uzytkownicy` (
  `ID_uzytkownicy` int(11) NOT NULL,
  `ID_imie` int(11) NOT NULL,
  `ID_nazwisko` int(11) NOT NULL,
  `mail` varchar(35) COLLATE utf8_polish_ci NOT NULL,
  `czyPracodawca` tinyint(1) NOT NULL,
  `nr_telefonu` varchar(15) COLLATE utf8_polish_ci NOT NULL,
  `haslo` varchar(255) COLLATE utf8_polish_ci NOT NULL,
  `ID_pracodawca` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `uzytkownicy`
--

INSERT INTO `uzytkownicy` (`ID_uzytkownicy`, `ID_imie`, `ID_nazwisko`, `mail`, `czyPracodawca`, `nr_telefonu`, `haslo`, `ID_pracodawca`) VALUES
(1, 1, 1, 'magdalena@gmail.com', 1, '183399466', '$2y$10$1n.bi2QDbtaJURd5x.UDIuzykK1EwFwfpNlVctYoL0.0KTnMjaBZK', 1),
(2, 2, 2, 'malgorzata@gmail.com', 1, '143916255', '$2y$10$pZArHsKQdvGhm7s1tnyzxOMl5gRu7iu3pfhdrIUsJ/e36smJu.ksC', 2),
(3, 3, 3, 'agata@gmail.com', 1, '424295178', '$2y$10$CWatwlf2Fp9BWxcOlL.9EujkN9GDqXmtKHejQJr6YdtRdYnv0PpOq', 3),
(4, 4, 4, 'mariola@gmail.com', 0, '255823579', '$2y$10$hFBs2SdopDoidJkCJw698e41kQO/HX1Od8FGZeJz6IWpEP2bb86xa', 4),
(5, 5, 5, 'klaudia@gmail.com', 0, '143577255', '$2y$10$bNGgG4SSAsTcw1TFTMDt6OD5DMG0nKkCBZ2eN2RD1meqjzIWyprF2', NULL),
(6, 6, 6, 'maja@gmail.com', 0, '154293879', '$2y$10$GTtP3dwgTFEF8G277R0k7eKyNLFRqWZxP/sbW6Iy.2Gh7bZOl3yYK', NULL),
(7, 7, 7, 'damian@gmail.com', 0, '554333953', '$2y$10$5gxQCC/xPQgQC5UZ.Klg/unHIRC2RSb4EHk8ohf64rdlxNeQY2Mj.', NULL),
(8, 8, 8, 'dariusz@gmail.com', 0, '679669569', '$2y$10$7Pbc4371KS4pCX07krdSjeq/4UZc3e/0Tx1RL2bQtfdFN5FXkCoQG', NULL),
(9, 9, 9, 'kazimiera@gmail.com', 0, '228812412', '$2y$10$Zsj8F5V/svMpOFk4plujYuHaoR.IsgPDwuWC07yp9OztzxyWAjeze', NULL),
(10, 10, 10, 'karina@gmail.com', 0, '229361189', '$2y$10$jCSiTOKPI05BG0fniqk69usYznOM.xp8uo46bLsVzHE/Lh9j1Bp8i', NULL),
(11, 11, 11, 'wojciech@gmail.com', 0, '175681434', '$2y$10$md5LtantDYXj3noc47NPyeb55.FNaUx3E/fxXnoKH7bUvdm3azOZW', NULL),
(12, 11, 12, 'wojtekszczucki@gmail.com', 0, '999999999', '$2y$10$Qf5Iew.TC1a6xLchFHY0LuXKOBuzD7TLch0hoRVn4BdrOxq/sxLJS', NULL),
(13, 11, 12, 'wojtekszczucki2@gmail.com', 0, '', '$2y$10$6w37pPC.rXDTVVlfqSn/8u2GgklVfuOh0qSns8yTCYTaJ3rsSgYgC', NULL),
(14, 11, 12, 'wojtekszczucki5@gmail.com', 0, '', '$2y$10$nL5qGIZ5kb/0a/771QUjCu3UeM6jadKpthUW0ZPxt5SWVWDJVGine', NULL),
(15, 11, 12, 'wojtekszczucki8@gmail.com', 0, '', '$2y$10$elasutc2AWjaFofNRKyusOUuKJ0VLBSdpvHGeXHgzOIlr2gbe6use', NULL);

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `imie`
--
ALTER TABLE `imie`
  ADD PRIMARY KEY (`ID_imie`);

--
-- Indeksy dla tabeli `miasto`
--
ALTER TABLE `miasto`
  ADD PRIMARY KEY (`ID_miasto`);

--
-- Indeksy dla tabeli `nazwisko`
--
ALTER TABLE `nazwisko`
  ADD PRIMARY KEY (`ID_nazwisko`);

--
-- Indeksy dla tabeli `ogloszenie`
--
ALTER TABLE `ogloszenie`
  ADD PRIMARY KEY (`ID_ogloszenie`);

--
-- Indeksy dla tabeli `pracodawca`
--
ALTER TABLE `pracodawca`
  ADD PRIMARY KEY (`ID_pracodawca`);

--
-- Indeksy dla tabeli `tag`
--
ALTER TABLE `tag`
  ADD PRIMARY KEY (`ID_tag`);

--
-- Indeksy dla tabeli `tag_do_ogloszenia`
--
ALTER TABLE `tag_do_ogloszenia`
  ADD PRIMARY KEY (`ID_tag_ogloszenie`);

--
-- Indeksy dla tabeli `umowa`
--
ALTER TABLE `umowa`
  ADD PRIMARY KEY (`ID_umowa`);

--
-- Indeksy dla tabeli `uzytkownicy`
--
ALTER TABLE `uzytkownicy`
  ADD PRIMARY KEY (`ID_uzytkownicy`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT dla tabeli `imie`
--
ALTER TABLE `imie`
  MODIFY `ID_imie` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT dla tabeli `miasto`
--
ALTER TABLE `miasto`
  MODIFY `ID_miasto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT dla tabeli `nazwisko`
--
ALTER TABLE `nazwisko`
  MODIFY `ID_nazwisko` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT dla tabeli `ogloszenie`
--
ALTER TABLE `ogloszenie`
  MODIFY `ID_ogloszenie` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT dla tabeli `pracodawca`
--
ALTER TABLE `pracodawca`
  MODIFY `ID_pracodawca` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT dla tabeli `tag`
--
ALTER TABLE `tag`
  MODIFY `ID_tag` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT dla tabeli `tag_do_ogloszenia`
--
ALTER TABLE `tag_do_ogloszenia`
  MODIFY `ID_tag_ogloszenie` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT dla tabeli `umowa`
--
ALTER TABLE `umowa`
  MODIFY `ID_umowa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT dla tabeli `uzytkownicy`
--
ALTER TABLE `uzytkownicy`
  MODIFY `ID_uzytkownicy` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
