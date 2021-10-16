-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- 생성 시간: 21-10-16 08:01
-- 서버 버전: 8.0.26-0ubuntu0.20.04.2
-- PHP 버전: 8.0.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 데이터베이스: `osam`
--

-- --------------------------------------------------------

--
-- 테이블 구조 `note`
--

CREATE TABLE `note` (
  `idx` int NOT NULL,
  `recv_id` varchar(100) COLLATE utf8mb4_bin NOT NULL,
  `send_id` varchar(100) COLLATE utf8mb4_bin NOT NULL,
  `title` varchar(100) COLLATE utf8mb4_bin NOT NULL,
  `content` text COLLATE utf8mb4_bin NOT NULL,
  `recv_chk` int NOT NULL,
  `send_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `goods` int DEFAULT NULL,
  `r_del` int NOT NULL DEFAULT '0',
  `s_del` int NOT NULL DEFAULT '0',
  `sell` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- 테이블의 인덱스 `note`
--
ALTER TABLE `note`
  ADD PRIMARY KEY (`idx`);

--
-- 덤프된 테이블의 AUTO_INCREMENT
--

--
-- 테이블의 AUTO_INCREMENT `note`
--
ALTER TABLE `note`
  MODIFY `idx` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
